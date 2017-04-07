<?php
include("includes/include_top.php");

$type = $_GET['type'];
	
	if($type == 'Sample'){
		/*$fpath = 'sample-data.csv';
		$file_name = 'sample-data.csv';
		$ext = 'csv';
		$ext1 = $ext[1];
		if(file_exists($fpath)){
			header("Content-type: application/".$ext1.";\n"); //or yours?
			header("Content-Transfer-Encoding: binary");
			$len = filesize($fpath);
			header("Content-Length: $len;\n");
			header("Content-Disposition: attachment; filename=\"$file_name\";\n\n");
			
			readfile($fpath);
		}*/
		$file_name = 'sample-data.csv';
		ob_start();
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=".$file_name);
		readfile($file_name);
		ob_end_flush();	
	}
	if($type == 'Sample-upadte'){
		$fpath = 'sample-update-data.csv';
		$file_name = 'sample-update-data.csv';
		$ext = 'csv';
		$ext1 = $ext[1];
		if(file_exists($fpath)){
			header("Content-type: application/".$ext1.";\n"); //or yours?
			header("Content-Transfer-Encoding: binary");
			$len = filesize($fpath);
			header("Content-Length: $len;\n");
			header("Content-Disposition: attachment; filename=\"$file_name\";\n\n");
			
			readfile($fpath);
		}	
	}	
?>