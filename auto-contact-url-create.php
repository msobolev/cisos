<?php
chdir(dirname( __FILE__ ));
include("includes/include-top.php");

//URL CREATE
$fixDate = '2012-03-28';
$url_query = "SELECT pm.first_name,pm.last_name,pm.personal_id,cm.company_id,cm.company_name,mm.move_id,mm.title,mm.movement_type FROM " . TABLE_MOVEMENT_MASTER. " mm, ".TABLE_COMPANY_MASTER." cm, ".TABLE_PERSONAL_MASTER." pm WHERE (mm.personal_id=pm.personal_id and mm.company_id=cm.company_id) and mm.add_date >= '".$fixDate."' and (mm.movement_url='' OR mm.movement_url=NULL)";
$url_result = com_db_query($url_query);
if($url_result){
	while($url_row = com_db_fetch_array($url_result)){
		$url_company_name = trim(com_db_output($url_row['company_name']));
		$url_company_name = str_replace(' ','-',$url_company_name);
		$mmc = com_db_GetValue("select name from ". TABLE_MANAGEMENT_CHANGE. " where id='".$url_row['movement_type']."'");
		$mmc1 = strtoupper($mmc);
		if($mmc1 == 'APPOINTMENT' || $mmc1 == 'LATERAL MOVE'){
			$url_mmc='Appointed';
		}elseif($mmc1 =='PROMOTION'){
			$url_mmc='Promoted';
		}elseif($mmc1 =='RETIREMENT'){
			$url_mmc='Retired';
		}elseif($mmc1 =='RESIGNATION'){
			$url_mmc='Resigned';
		}elseif($mmc1 =='TERMINATION'){
			$url_mmc='Terminated';
		}else{
			$url_mmc='Job-Opening';
		}		
		
		$ntt = com_db_output($url_row['title']);
		$ntt = str_replace(' ','-', $ntt);
		
		$contact_url = trim($url_row['first_name']).'-'.trim($url_row['last_name']).'-'.$url_company_name.'-'.$ntt.'-'.$url_mmc;
		
		$contact_url = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '-', ''), $contact_url);
		com_db_query("UPDATE " . TABLE_MOVEMENT_MASTER . " SET movement_url = '".com_db_input($contact_url)."' where move_id='".$url_row['move_id'] ."'");
	}
}

//For before data

$url_query1 = "SELECT pm.first_name,pm.last_name,pm.personal_id,cm.company_id,cm.company_name,mm.move_id,mm.title,mm.movement_type FROM " . TABLE_MOVEMENT_MASTER. " mm, ".TABLE_COMPANY_MASTER." cm, ".TABLE_PERSONAL_MASTER." pm WHERE (mm.personal_id=pm.personal_id and mm.company_id=cm.company_id) and mm.add_date < '".$fixDate."' and (movement_url='' OR movement_url=NULL)";
$url_result1 = com_db_query($url_query1);
if($url_result1){
	while($url_row = com_db_fetch_array($url_result1)){
		$url_company_name = trim(com_db_output($url_row['company_name']));
		$url_company_name = str_replace(' ','-',$url_company_name);
		$mmc = com_db_GetValue("select name from ". TABLE_MANAGEMENT_CHANGE. " where id='".$url_row['movement_type']."'");
		$mmc1 = strtoupper($mmc);
		if($mmc1 == 'APPOINTMENT' || $mmc1 == 'LATERAL MOVE'){
			$url_mmc='Appointed';
		}elseif($mmc1 =='PROMOTION'){
			$url_mmc='Promoted-to';
		}elseif($mmc1 =='RETIREMENT'){
			$url_mmc='Retired-as';
		}elseif($mmc1 =='RESIGNATION'){
			$url_mmc='Resigned-as';
		}elseif($mmc1 =='TERMINATION'){
			$url_mmc='was-terminated-as';
		}else{
			$url_mmc='Job-Opening';
		}		
		
		$ntt = com_db_output($url_row['title']);
		$ntt = str_replace(' ','-', $ntt);
		
		if($mmc1 =='RETIREMENT'){
			$contact_url = trim($url_row['first_name']).'-'.trim($url_row['last_name']).'-'.$url_mmc.'-'.$ntt.'-from-'. $url_company_name;
		}else{
			$contact_url = trim($url_row['first_name']).'-'.trim($url_row['last_name']).'-'.$url_mmc.'-'.$ntt.'-at-'. $url_company_name;
		}
		
		$contact_url = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '-', ''), $contact_url);
		com_db_query("UPDATE " . TABLE_MOVEMENT_MASTER . " SET movement_url = '".com_db_input($contact_url)."' where move_id='".$url_row['move_id'] ."'");
	}
}
?>
