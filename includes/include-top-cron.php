<?php



// Set the level of error reporting
  error_reporting(E_ALL & ~E_NOTICE);
  
// Include application configuration parameters
  require('includes/configuration-cron.php');

// include the list of project database tables
  require(DIR_INCLUDES . 'define-tables.php'); 

// include the database functions
  require(DIR_FUNCTIONS . 'database.php');
  
// make a connection to the database... now
  com_db_connect() or die('Unable to connect to database server!');

// define our common functions used application-wide
  require(DIR_FUNCTIONS . 'common.php');
  require(DIR_FUNCTIONS . 'siteuse.php');
  
 // define how the session functions will be used
  require(DIR_FUNCTIONS . 'sessions.php');
  
// lets start our session
  com_session_start();
  
 $banned_domain_array ='';
 $banned_domain_result = com_db_query("select domain_name from ".TABLE_BANNED_DOMAIN." where status='0'");
 
 while($bdRow = com_db_fetch_array($banned_domain_result)){
		$dot_pos = explode('.', $bdRow['domain_name']);
		$domain = strtolower(substr($bdRow['domain_name'],0,strlen($dot_pos[0])));
		if($banned_domain_array==''){
			$banned_domain_array = "'@".$domain.".'";
		}else{
			$banned_domain_array .= ",'@".$domain.".'";
		}
	
 }
 
 $current_page = basename($_SERVER['PHP_SELF']);
 
//page meta keyword 
 $tkd_result = com_db_query("select * from " . TABLE_META_TAG . " where page_name = '". $current_page."'");
 if($tkd_result){
 	$tkd_row = com_db_fetch_array($tkd_result);
	$PageTitle = $tkd_row['page_title'];
	$PageKeywords = $tkd_row['meta_keyword'];
	$PageDescription = $tkd_row['meta_desc'];
 }	
  if($PageTitle == ''){
 	$PageTitle = com_db_output(com_db_GetValue("select page_title from " . TABLE_META_TAG . " where page_name ='Default'"));
 }
  if($PageKeywords == ''){
  	  $PageKeywords = com_db_output(com_db_GetValue("select meta_keyword from " . TABLE_META_TAG . " where page_name ='Default'"));
  }
   if($PageDescription == ''){
  	  $PageDescription = com_db_output(com_db_GetValue("select meta_desc from " . TABLE_META_TAG . " where page_name ='Default'"));
  }
  if($current_page=='vigilant-appoints.php'){
  	$dim_url = explode('/', $_SERVER['REQUEST_URI']);
	$vigilant =$dim_url[sizeof($dim_url)-1];
	$mt_result = com_db_query("select * from ". TABLE_MANAGEMENT_CHANGE." where status ='0'");
	$mt_type='';
	while($mt_row=com_db_fetch_array($mt_result)){
		$mt_type .= $mt_row['name'].', ';	
	}
	if($mt_type !=''){
		$mt_type = substr($mt_type,0,strlen($mt_type)-2);
	}
	$conid = explode('-',$vigilant);
	$vg_name = explode('-at-',$vigilant);
	if(sizeof($vg_name)==1){
		$vg_name = explode('-from-',$vigilant);
	}
	$vg_company_name = $vg_name[1];
	$vg_company_name =str_replace('-',' ',$vg_company_name);
	$new_title = com_db_GetValue("select new_title from " .TABLE_CONTACT. " as c where c.first_name='".$conid[0]."' and c.last_name='".$conid[1]."' and c.company_name='".$vg_company_name."'");
	$vg_title =str_replace('-',' ', $vigilant);
	$PageTitle = $vg_title.', '.$new_title;
	$PageKeywords .= ', '.$new_title;
	$PageDescription .= ', '.$new_title;
  }
  
?>
