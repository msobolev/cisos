<?php
include("includes/include_top.php");
$action = $_GET['action'];
$uID = $_GET['uID'];
if($action == 'AlertCreate'){
	$title = com_db_input($_POST['title']);
	if($title == 'Type in the Title'){
		$title = '';
	}
	$type = $_POST['management'];
	$country = $_POST['country'];
	$state = $_POST['state'];
	$city = com_db_input($_POST['city']);
	if($city == 'Type in the City'){
		$city = '';
	}
	$zip_code = com_db_input($_POST['zip_code']);
	if($zip_code =='Type in the Zip code'){
		$zip_code = '';
	}
	$company = com_db_input($_POST['company']);
	if($company =='Type in the Company Name'){
		$company ='';
	}
	$industry = com_db_input($_POST['industry']);
	$industry = $_POST['industry'];
    $revenue_size = $_POST['revenue_size'];
	$employee_size = $_POST['employee_size'];
	$delivery_schedule = $_POST['delivery_schedule'];
	$alert_date=date('Y-m-d',mktime(0,0,0,date('m'),date('d')+1,date('Y')));
	$monthly_budget = $_POST['monthly_budget'];
	$add_date = date('Y-m-d');
	$exp_date =date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('Y')+10));
	$user_id = $uID;
	
	$alert_query = "insert into " . TABLE_ALERT . " (user_id,title,type,country,state,city,zip_code,company,industry_id,revenue_size,employee_size,delivery_schedule,monthly_budget,exp_date,alert_date,add_date) values ('$user_id','$title','$type','$country','$state','$city','$zip_code','$company','$industry','$revenue_size','$employee_size','$delivery_schedule','$monthly_budget','$exp_date','$alert_date','$add_date')";
	com_db_query($alert_query);
	$alert_id = com_db_insert_id();
		
	$url = 'user.php?selected_menu=user&msg=' . msg_encode("New alert create successfully");
	com_redirect($url);
}

?>