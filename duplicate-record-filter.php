<?php
include("includes/include-top.php");

//Duplicate Record Filter
$urlQuery = " SELECT contact_id, contact_url, count( * ) as totrec FROM ".TABLE_CONTACT." GROUP BY contact_url ORDER BY contact_url";
$urlResult = com_db_query($urlQuery);
com_db_query(" TRUNCATE TABLE `cto_delete_info` ");
while($row = com_db_fetch_array($urlResult)){
	if($row['totrec'] > 1 && $row['contact_url'] !=''){
		$ins_query = "insert into cto_delete_info (contact_id,contact_url,number) values ('".$row['contact_id']."','".$row['contact_url']."','".$row['totrec']."')";
		com_db_query($ins_query);
	}
}
echo 'Duplicate record filter successfully done';

?>