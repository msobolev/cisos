<?php
include("includes/include_top.php");

$type = $_GET['type'];
	
	if($type == 'Sample'){
		$file_name = 'sample-personal-data.csv';
		ob_start();
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=".$file_name);
		readfile($file_name);
		ob_end_flush();	
	}
	
?>