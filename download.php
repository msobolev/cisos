<?php
include("includes/include-top.php");
$id = $_GET['id'];
$type = $_GET['type'];
	if($type == 'wp'){
		$query_download = "select * from ". TABLE_WHITE_PAPER ." where paper_id='".$id."'";
		$download_file = com_db_query($query_download);
		$download_row = com_db_fetch_array($download_file);
		
		$fname = $download_row['download_path'];
		$file_name = $fname;
		$fpath = DIR_WHITE_PAPER . $download_row['download_path'];
		$ext = explode('.',$file_name);
		$ext1 = $ext[1];
		if(file_exists($fpath)){
			header("Content-type: application/".$ext1.";\n"); //or yours?
			header("Content-Transfer-Encoding: binary");
			$len = filesize($fpath);
			header("Content-Length: $len;\n");
			header("Content-Disposition: attachment; filename=\"$file_name\";\n\n");
			
			readfile($fpath);
		}else{
			$url = 'white-paper.php';
			com_redirect($url);
		}
	}
?>