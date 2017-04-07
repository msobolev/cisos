<?php
require('includes/include-top.php');

/*
$update_query = "select * from ".TABLE_CONTACT;
$update_result = com_db_query($update_query);
while($update_row=com_db_fetch_array($update_result)){
	$update_contact_id = $update_row['contact_id'];
	$contact_title = $update_row['new_title'];
	$ins_title_id = com_db_GetValue("select id from " .TABLE_TITLE ." where title='".$contact_title."'");
	$movement_type = $update_row['movement_type'];
	$ins_movement_type_id = com_db_GetValue("select id from " .TABLE_MANAGEMENT_CHANGE ." where name='".$movement_type."'");
	$contact_country = $update_row['country'];
	$ins_country_id = com_db_GetValue("select countries_id from " .TABLE_COUNTRIES ." where countries_iso_code_3='".$contact_country."'");
	$contact_state = $update_row['state'];
	$ins_state_id = com_db_GetValue("select state_id from " .TABLE_STATE ." where short_name='".$contact_state."'");
	$contact_revenue_size = $update_row['company_revenue'];
	$ins_revenue_size_id = com_db_GetValue("select id from " .TABLE_REVENUE_SIZE ." where name='".$contact_revenue_size."'");
	$contact_employee_size = $update_row['company_employee'];
	$ins_employee_size_id = com_db_GetValue("select id from " .TABLE_EMPLOYEE_SIZE ." where name='".$contact_employee_size."'");
	$contact_source = $update_row['source'];
	$ins_source_id = com_db_GetValue("select id from " .TABLE_SOURCE ." where source='".$contact_source."'");
	
	$contact_city = $update_row['city'];
	if($contact_city=='Type in the City'){
		$contact_city='';
	}else{
		$contact_city=$contact_city;
	}
	$contact_zip_code = $update_row['zip_code'];
	if($contact_zip_code=='Type in the Zip code'){
		$contact_zip_code='';
	}else{
		$contact_zip_code=$contact_zip_code;
	}
	$contact_company = $update_row['company_name'];
	if($contact_company=='New Company'){
		$contact_company='';
	}else{
		$contact_company=$contact_company;
	}
	$industry_id=$update_row['industry_id'];
	com_db_query("update ".TABLE_CONTACT . " set new_title='".$ins_title_id."',company_industry='".$industry_id."', movement_type ='".$ins_movement_type_id."', country='".$ins_country_id."', 
				state='".$ins_state_id."', company_revenue='".$ins_revenue_size_id."', company_employee='".$ins_employee_size_id."', 
				city='".$contact_city."',zip_code='".$contact_zip_code."', company_name='".$contact_company."',source='".$ins_source_id."' where contact_id='".$update_contact_id."'");
}

$update_query = "select * from ".TABLE_ALERT;
$update_result = com_db_query($update_query);
while($update_row=com_db_fetch_array($update_result)){
	$update_alert_id = $update_row['alert_id'];
	$alert_title = $update_row['title'];
	$ins_title_id = com_db_GetValue("select id from " .TABLE_TITLE ." where title='".$alert_title."'");
	$alert_type = $update_row['type'];
	$ins_type_id = com_db_GetValue("select id from " .TABLE_MANAGEMENT_CHANGE ." where name='".$alert_type."'");
	$alert_country = $update_row['country'];
	$ins_country_id = com_db_GetValue("select countries_id from " .TABLE_COUNTRIES ." where countries_iso_code_3='".$alert_country."'");
	$alert_state = $update_row['state'];
	$ins_state_id = com_db_GetValue("select state_id from " .TABLE_STATE ." where short_name='".$alert_state."'");
	$alert_revenue_size = $update_row['revenue_size'];
	$ins_revenue_size_id = com_db_GetValue("select id from " .TABLE_REVENUE_SIZE ." where name='".$alert_revenue_size."'");
	$alert_employee_size = $update_row['employee_size'];
	$ins_employee_size_id = com_db_GetValue("select id from " .TABLE_EMPLOYEE_SIZE ." where name='".$alert_employee_size."'");
	$alert_city = $update_row['city'];
	if($alert_city=='Type in the City'){
		$alert_city='';
	}else{
		$alert_city=$alert_city;
	}
	$alert_zip_code = $update_row['zip_code'];
	if($alert_zip_code=='Type in the Zip code'){
		$alert_zip_code='';
	}else{
		$alert_zip_code=$alert_zip_code;
	}
	$alert_company = $update_row['company'];
	if($alert_company=='Type in the Company Name'){
		$alert_company='';
	}else{
		$alert_company=$alert_company;
	}
	com_db_query("update ".TABLE_ALERT . " set title='".$ins_title_id."', type ='".$ins_type_id."', country='".$ins_country_id."', 
				state='".$ins_state_id."', revenue_size='".$ins_revenue_size_id."', employee_size='".$ins_employee_size_id."', 
				city='".$alert_city."',zip_code='".$alert_zip_code."', company='".$alert_company."' where alert_id='".$update_alert_id."'");
}

$update_query = "select * from ".TABLE_SEARCH_HISTORY." where search_type='AdvanceSearch'";
$update_result = com_db_query($update_query);
while($update_row=com_db_fetch_array($update_result)){
	$update_search_id = $update_row['search_id'];
	$alert_title = $update_row['title'];
	$ins_title_id = com_db_GetValue("select id from " .TABLE_TITLE ." where title='".$alert_title."'");
	$alert_type = $update_row['management'];
	$ins_type_id = com_db_GetValue("select id from " .TABLE_MANAGEMENT_CHANGE ." where name='".$alert_type."'");
	$alert_country = $update_row['country'];
	$ins_country_id = com_db_GetValue("select countries_id from " .TABLE_COUNTRIES ." where countries_iso_code_3='".$alert_country."'");
	$alert_state = $update_row['state'];
	$ins_state_id = com_db_GetValue("select state_id from " .TABLE_STATE ." where short_name='".$alert_state."'");
	$alert_revenue_size = $update_row['revenue_size'];
	$ins_revenue_size_id = com_db_GetValue("select id from " .TABLE_REVENUE_SIZE ." where name='".$alert_revenue_size."'");
	$alert_employee_size = $update_row['employee_size'];
	$ins_employee_size_id = com_db_GetValue("select id from " .TABLE_EMPLOYEE_SIZE ." where name='".$alert_employee_size."'");
	$alert_city = $update_row['city'];
	if($alert_city=='Type in the City'){
		$alert_city='';
	}else{
		$alert_city=$alert_city;
	}
	$alert_zip_code = $update_row['zip_code'];
	if($alert_zip_code=='Type in the Zip code'){
		$alert_zip_code='';
	}else{
		$alert_zip_code=$alert_zip_code;
	}
	$alert_company = $update_row['company'];
	if($alert_company=='Type in the Company Name'){
		$alert_company='';
	}else{
		$alert_company=$alert_company;
	}
	com_db_query("update ".TABLE_SEARCH_HISTORY . " set title='".$ins_title_id."', management ='".$ins_type_id."', country='".$ins_country_id."', 
				state='".$ins_state_id."', revenue_size='".$ins_revenue_size_id."', employee_size='".$ins_employee_size_id."', 
				city='".$alert_city."',zip_code='".$alert_zip_code."', company='".$alert_company."' where search_id='".$update_search_id."'");
}*/

/*echo $string = " -Lo#&@rem  IPSUM //dolor-/sit - '---- , ; amet-/-consectetur! 12 -- ";

function post_slug($str)
{
  return strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '-', ''), $str));
} 
echo '<br>';
echo post_slug($string) ;*/
//echo post_slug($str);
//will output: lorem-ipsum-dolor-sit-amet-consectetur-12

	$main_query2 = "select c.contact_id from " 
				.TABLE_CONTACT. " as c, " 
				.TABLE_INDUSTRY." as i, "
				.TABLE_MANAGEMENT_CHANGE." as m, "
				.TABLE_STATE." as s ,"
				.TABLE_SOURCE." as so ,"
				.TABLE_COUNTRIES." as ct 
				where c.industry_id=i.industry_id and c.state=s.state_id and c.source=so.id and 
				c.country=ct.countries_id and c.movement_type=m.id and c.status ='0'";		
				
echo $check_query = "select * from ".TABLE_CONTACT. " where contact_id not in (".$main_query2.")";

//New Title Update
/*$title_query="select contact_id, new_title from cto_contact_old";
$title_result = com_db_query($title_query);
while($title_row=com_db_fetch_array($title_result)){
	com_db_query("update ".TABLE_CONTACT. " set new_title='".$title_row['new_title']."' where contact_id='".$title_row['contact_id']."'" );
}*/

//Reminder New title update
/*$title_query="select contact_id, new_title from ".TABLE_CONTACT. " where new_title>=1 and new_title<=57";
$title_result = com_db_query($title_query);
while($title_row=com_db_fetch_array($title_result)){
	$new_title = com_db_GetValue("select title from ".TABLE_TITLE." where id='".$title_row['new_title']."'");
	if($new_title !=''){
		com_db_query("update ".TABLE_CONTACT. " set new_title='".$new_title."' where contact_id='".$title_row['contact_id']."'" );
	}
}*/
//Alert title update
/*$alert_title_query="select alert_id, title from ".TABLE_ALERT. " where title>=1 and title<=8";
$alert_title_result = com_db_query($alert_title_query);
while($alert_title_row=com_db_fetch_array($alert_title_result)){
	$new_title = com_db_GetValue("select title from cto_title_old where id='".$alert_title_row['title']."'");
	if($new_title !=''){
		com_db_query("update ".TABLE_ALERT. " set title='".$new_title."' where alert_id='".$alert_title_row['alert_id']."'" );
	}
}*/
//Search history title update
/*$title_query="select search_id, title from ".TABLE_SEARCH_HISTORY. " where title<>''";
$title_result = com_db_query($title_query);
while($title_row=com_db_fetch_array($title_result)){
	$new_title = com_db_GetValue("select title from cto_title_old where id='".$title_row['title']."'");
	if($new_title !=''){
		com_db_query("update ".TABLE_SEARCH_HISTORY. " set title='".$new_title."' where search_id='".$title_row['search_id']."'" );
	}
}*/
?>