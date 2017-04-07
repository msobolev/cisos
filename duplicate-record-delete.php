<?php
include("includes/include-top.php");

//Duplicate Record Delete

$urlQuery = "select * from cto_delete_info order by contact_url";
$urlResult = com_db_query($urlQuery);
while($row = com_db_fetch_array($urlResult)){
	$delResult = com_db_query("select contact_id,contact_url from ".TABLE_CONTACT." where contact_url='".$row['contact_url']."' order by contact_id");
	if($delResult){
		$num_row = com_db_num_rows($delResult);
		if($num_row > 1){
			$delRow = com_db_fetch_array($delResult);
			$first_id = $delRow['contact_id'];
			com_db_query("delete from ".TABLE_CONTACT." where contact_id !='".$first_id."' and contact_url='".$delRow['contact_url']."'");
		}
	}
}
echo 'Duplicate record delete successfully done';

?>