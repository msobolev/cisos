<?php
require('includes/include_top.php');

$courseid = 'PHP';
$section = 'A';
 function xlsBOF() {
    echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);  
    return;
}

function xlsEOF() {
    echo pack("ss", 0x0A, 0x00);
    return;
}

function xlsWriteNumber($Row, $Col, $Value) {
    echo pack("sssss", 0x203, 14, $Row, $Col, 0x0);
    echo pack("d", $Value);
    return;
}

function xlsWriteLabel($Row, $Col, $Value ) {
    $L = strlen($Value);
    echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
    echo $Value;
return;
} 

 // Query Database
    $result=com_db_query("select id,prename,name,sname,grade from " . TABLE_APPDATA . " where course='$courseid' and sec='$section'");

    // Send Header
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");;
    header("Content-Disposition: attachment;filename=$courseid-$section.xls "); 
    header("Content-Transfer-Encoding: binary ");

    // XLS Data Cell

	xlsBOF();
	xlsWriteLabel(1,0,"Student Register $semester/$year");
	xlsWriteLabel(2,0,"COURSENO : ");
	xlsWriteLabel(2,1,"$courseid");
	xlsWriteLabel(3,0,"TITLE : ");
	xlsWriteLabel(3,1,"$title");
	xlsWriteLabel(4,0,"SETION : ");
	xlsWriteLabel(4,1,"$sec");
	xlsWriteLabel(6,0,"NO");
	xlsWriteLabel(6,1,"ID");
	xlsWriteLabel(6,2,"Gender");
	xlsWriteLabel(6,3,"Name");
	xlsWriteLabel(6,4,"Lastname");
	$xlsRow = 7;
	while(list($id,$prename,$name,$sname,$grade)=com_db_fetch_row($result)) {
		++$i;
			  xlsWriteNumber($xlsRow,0,"$i");
			  xlsWriteNumber($xlsRow,1,"$id");
			  xlsWriteLabel($xlsRow,2,"$prename");
			  xlsWriteLabel($xlsRow,3,"$name");
			  xlsWriteLabel($xlsRow,4,"$sname");
		$xlsRow++;
		}
		 xlsEOF();
	 exit();

?>