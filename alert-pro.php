<?php
include("includes/include-top.php");
$action = $_GET['action'];
//Admin Address start
$adminInfo = "select * from ". TABLE_ADMIN_SETTINGS ." where setting_id ='1'";
$adminResult = com_db_query($adminInfo);
$adminRow = com_db_fetch_array($adminResult);

$from_admin = $adminRow['site_email_from'];
$to_admin = $adminRow['site_email_address'];
		 
$site_owner_name = com_db_output($adminRow['site_owner_name']);
$site_owner_position = com_db_output($adminRow['site_owner_position']);

$site_domain_name = com_db_output($adminRow['site_domain_name']);
$site_phone_number = com_db_output($adminRow['site_phone_number']);
$site_company_address = com_db_output($adminRow['site_company_address']);
$site_company_city  = com_db_output($adminRow['site_company_city']);
$site_company_state = com_db_output($adminRow['site_company_state']);
$site_company_zip = com_db_output($adminRow['site_company_zip']);

$fromEmailSent='<table border="0" cellpadding="0" cellspacing="0">
					<tr><td align="left">'.$site_owner_name.'</td></tr>
					<tr><td align="left">'.$site_owner_position.'</td></tr>
					<tr><td align="left">'.$site_domain_name.'</td></tr>
					<tr><td align="left">'.$site_company_address.'</td></tr>
					<tr><td align="left">'.$site_company_city.', '.$site_company_state.'</td></tr>
					<tr><td align="left">'.$site_company_zip.'</td></tr>
					<tr><td align="left">'.$site_phone_number.'</td></tr>
					<tr><td align="left">'.$from_admin.'</td></tr>
				</table>';
//end
				
if($action == 'AlertCreate'){
	$title = $_POST['title'];
	if($title=='e.g. Chief Information Officer'){
		$title='';
	}else{
		$title = com_db_input($title);
	}
	$type = $_POST['management'];
	if($type=='Any'){
		$type='';
	}else{
		$type = com_db_GetValue('select id from '.TABLE_MANAGEMENT_CHANGE." where name='".com_db_input($type)."'");
	}
	$country = $_POST['country'];
	if($country=='Any'){
		$country='';
	}else{
		$country = com_db_GetValue('select countries_id from '.TABLE_COUNTRIES." where countries_name='".com_db_input($country)."'");
	}
	
	$state = $_POST['state'];
	$city = $_POST['city'];
	
	$zip_code = $_POST['zip_code'];
	if($zip_code =='Zip Code'){
		$zip_code = '';
	}
	$company = $_POST['company'];
	if($company =='e.g. Microsoft'){
		$company ='';
	}
	$rep   = array("\r\n", "\n","\r");
	$company_website	= str_replace($rep, "<br />", $_POST['company_website']);
	$industry = $_POST['industry'];
    $revenue_size = $_POST['revenue_size'];
	$employee_size = $_POST['employee_size'];
	$speaking = $_POST['speaking'];
	$awards = $_POST['awards'];
	$publication = $_POST['publication'];
	$media_mentions = $_POST['media_mentions'];
	$board = $_POST['board'];
	$delivery_schedule = $_POST['delivery_schedule'];
	$alert_date=date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('Y')));
	$monthly_budget = $_POST['monthly_budget'];
	$add_date = date('Y-m-d');
	$exp_date =date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('Y')+10));
	$user_id = $_SESSION['sess_user_id'];
	
	$jobs = $_POST['jobs'];
	$fundings = $_POST['fundings'];
	
	
	$isAlertPresent = com_db_GetValue("select count(alert_id) as cnt from ".TABLE_ALERT." where user_id='".$user_id."'");
	$subscriptionID = com_db_GetValue("select subscription_id from ".TABLE_USER." where user_id='".$user_id."'");
	$alertPermition = com_db_GetValue("select custom_alerts from ".TABLE_SUBSCRIPTION." where sub_id='".$subscriptionID."'");
	if($subscriptionID==2 && $isAlertPresent >=$alertPermition){
		$url ='alert-notifications.php';
		com_redirect($url);
	}elseif($subscriptionID==3 && $isAlertPresent >=$alertPermition){
		$url ='alert-notifications.php';
		com_redirect($url);
	}
	$alert_query = "insert into " . TABLE_ALERT . " (user_id,title,type,country,state,city,zip_code,company,company_website,industry_id,revenue_size,employee_size,delivery_schedule,speaking,awards,publication,media_mention,board,jobs,fundings,monthly_budget,exp_date,alert_date,add_date) values ('$user_id','$title','$type','$country','$state','$city','$zip_code','$company','$company_website','$industry','$revenue_size','$employee_size','$delivery_schedule','$speaking','$awards','$publication','$media_mentions','$board','$jobs','$fundings','$monthly_budget','$exp_date','$alert_date','$add_date')";
	com_db_query($alert_query);
	$alert_id = com_db_insert_id();
	
	if($user_id ==''){
		$user_session_id = com_session_id();
		$add_date = date('Y-m-d');
		$alert_sess_query = "insert into " . TABLE_ALERT_WITHOUT_LOGIN . " (session_id,alert_id,add_date) values ('$user_session_id','$alert_id','$add_date')";
		com_db_query($alert_sess_query);
	}
	if($_SESSION['sess_user_id'] !=''){
		  $alert_email_send = com_db_query("select first_name,last_name,email from " . TABLE_USER ." where user_id='".$user_id."'");
		  $alert_email_send_row = com_db_fetch_array($alert_email_send);
		  $first_name = $alert_email_send_row['first_name'];
		  $last_name = $alert_email_send_row['last_name'];
		  $to_email = $alert_email_send_row['email'];
		 
		 //$to_admin = com_db_GetValue("select site_email_address from ". TABLE_ADMIN_SETTINGS ." where setting_id ='1'" );
		 //$from_site = com_db_GetValue("select site_email_from from ". TABLE_ADMIN_SETTINGS ." where setting_id ='1'" );	
		 //for admin
		 $admin_mail_result =com_db_query("select * from " .TABLE_AUTORESPONDERS. " where type='Admin' and autoresponder_for='user set up an alert'");
		 $admin_mail_row = com_db_fetch_array($admin_mail_result);
		 $admin_subject = "CTOsOnTheMove.com :: ".$admin_mail_row['subject'];
		 $admin_body1 = com_db_output($admin_mail_row['body1']);
		 $admin_body2 = com_db_output($admin_mail_row['body2']);
		  $message = '<a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'index.php"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/logo.jpg"  alt="Logo" width="196" height="32" border="0" title="Logo" /></a>&nbsp;
		  				<table width="70%" cellspacing="0" cellpadding="3" >
							<tr>
								<td align="left" colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td align="left" colspan="2">'.$admin_body1." ".$admin_body2.'</td> 
							</tr>
							<tr>
								<td align="left" colspan="2">Name:'.$first_name.' '.$last_name.'</td> 
							</tr>
							<tr>
								<td align="left" colspan="2">Email:'.$to_email.'</td> 
							</tr>
							<tr>
								<td align="left" colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td align="left" colspan="2">'.$fromEmailSent.'</td>
							</tr>';
		 
		$message .=	'</table>';
		
		@send_email($to_admin, $admin_subject, $message, $from_admin);
		 
		//for user email
		  //$from_admin = com_db_GetValue("select site_email_from from ". TABLE_ADMIN_SETTINGS ." where setting_id ='1'" );	
		 		  
		  $user_mail_result =com_db_query("select * from " .TABLE_AUTORESPONDERS. " where type='User' and autoresponder_for='user set up an alert'");
		  $user_mail_row = com_db_fetch_array($user_mail_result);
		  
		  $subject = "CTOsOnTheMove.com :: ".$user_mail_row['subject'];
		  
		  $message = '<a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'index.php"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/logo.jpg"  alt="Logo" width="196" height="32" border="0" title="Logo" /></a>&nbsp;
		  				<table width="70%" cellspacing="0" cellpadding="3" >
							<tr>
								<td align="left" colspan="2"><b>Dear '.$first_name.', </b>'.com_db_output($user_mail_row['body1']).' '.com_db_output($user_mail_row['body2']).'</td>
							</tr>
							<tr>
								<td align="left" colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td align="left" colspan="2">'.$fromEmailSent.'</td>
							</tr>';
		 
		$message .=	'</table>';
		@send_email($to_email, $subject, $message, $from_admin);
		
	 }
	if($_SESSION['sess_user_id'] !=''){
		$url = 'sub-thank-you.php?ragName='.$first_name.' '.$last_name;
		com_redirect($url);
	}else{
		$url = 'provide-contact-information.php';
		com_redirect($url);	
	}	
	
}

if($action == 'Subscription'){
	$subscription_id = $_POST['radio_sub_id'];
	$res_id = $_REQUEST['res_id'];
	$res_query = "update " . TABLE_USER . " set subscription_id ='" .$subscription_id."' where user_id='".$res_id."'";
	$userName = com_db_GetValue("select concat(first_name,' ',last_name) from". TABLE_USER." where user_id='".$reg_id."'");
	com_db_query($res_query);
	if($subscription_id == 1){
		$url = 'sub-thank-you.php?ragName='.$userName;
	}else{
		$url = 'submit-payment.php?res_id='.$res_id;
	}	
	com_redirect($url);
}

if($action == 'SubmitAlertPayment'){

	$alert_id = $_REQUEST['alt_id'];
	$amount = $_POST['amount'];
	$first_name = com_db_input($_POST['first_name']);
	$last_name = com_db_input($_POST['last_name']);
	
	$card_type = com_db_input($_POST['card_type']);
	$card_num = com_db_input($_POST['card_num']);
	$exp_month = $_POST['exp_month'];
	$exp_year = $_POST['exp_year'];
	$security_code = com_db_input($_POST['security_code']);
	
	$company = com_db_input($_POST['company']);
	$address = com_db_input($_POST['address']);
	$address_cont = com_db_input($_POST['address_cont']);
	$city = com_db_input($_POST['city']);
	$state = com_db_input($_POST['state']);
	$zip_code = com_db_input($_POST['zip_code']);
	$country = com_db_input($_POST['country']);
	$add_date = date('Y-m-d');
	

require_once 'CallerService.php';
require_once 'constants.php';

$API_UserName=API_USERNAME;

$API_Password=API_PASSWORD;

$API_Signature=API_SIGNATURE;

$API_Endpoint =API_ENDPOINT;

$subject = SUBJECT;

/**
 * Get required parameters from the web form for the request
 */
//$paymentType =urlencode( $_POST['paymentType']);
$firstName =urlencode( $_POST['first_name']);
$lastName =urlencode( $_POST['last_name']);
$creditCardType =urlencode( $_POST['card_type']);
$creditCardNumber = urlencode($_POST['card_num']);
$expDateMonth =urlencode( $_POST['exp_month']);

// Month must be padded with leading zero
$padDateMonth = str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);

$expDateYear =urlencode( $_POST['exp_year']);
$cvv2Number = urlencode($_POST['security_code']);
$address1 = urlencode($_POST['address']);
$address2 = urlencode($_POST['address_cont']);
$city = urlencode($_POST['city']);
//$state =urlencode($_POST['state']);
$state =urlencode($_POST['state']);
$country =urlencode($_POST['country']);
$zip = urlencode($_POST['zip_code']);
$amount = urlencode($amount);
//$currencyCode=urlencode($_POST['currency']);
$currencyCode="USD";
$paymentType='Sale';//'Authorization'; //urlencode($_POST['paymentType']); AMS

$profileDesc = urlencode($_POST['profileDesc']);
$billingPeriod = urlencode($_POST['billingPeriod']);
$billingFrequency = urlencode($_POST['billingFrequency']);
$totalBillingCycles = urlencode($_POST['totalBillingCycles']);
$startDate = explode('/',$_POST['startDate']);
$pStartDate = $startDate[2].'-'.$startDate[1].'-'.$startDate[0];
$profileStartDateDay = $startDate[0];//$_POST['profileStartDateDay'];
// Day must be padded with leading zero
$padprofileStartDateDay = str_pad($profileStartDateDay, 2, '0', STR_PAD_LEFT);
$profileStartDateMonth = $startDate[1];//$_POST['profileStartDateMonth'];
// Month must be padded with leading zero
$padprofileStartDateMonth = str_pad($profileStartDateMonth, 2, '0', STR_PAD_LEFT);
$profileStartDateYear =$startDate[2];// $_POST['profileStartDateYear'];

$profileStartDate = urlencode($profileStartDateYear . '-' . $padprofileStartDateMonth . '-' . $padprofileStartDateDay . 'T00:00:00Z'); 


/* Construct the request string that will be sent to PayPal.
   The variable $nvpstr contains all the variables and is a
   name value pair string with & as a delimiter */
$nvpstr="&PAYMENTACTION=$paymentType&AMT=$amount&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber&EXPDATE=". $padDateMonth.$expDateYear."&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName&STREET=$address1&CITY=$city&STATE=$state".
"&ZIP=$zip&COUNTRYCODE=US&CURRENCYCODE=$currencyCode&PROFILESTARTDATE=$profileStartDate&DESC=$profileDesc&BILLINGPERIOD=$billingPeriod&BILLINGFREQUENCY=$billingFrequency&TOTALBILLINGCYCLES=$totalBillingCycles";

$getAuthModeFromConstantFile = true;
//$getAuthModeFromConstantFile = false;
$nvpHeader = "";

if(!$getAuthModeFromConstantFile) {
	//$AuthMode = "3TOKEN"; //Merchant's API 3-TOKEN Credential is required to make API Call.
	//$AuthMode = "FIRSTPARTY"; //Only merchant Email is required to make EC Calls.
	$AuthMode = "THIRDPARTY"; //Partner's API Credential and Merchant Email as Subject are required.
} else {
	if(!empty($API_UserName) && !empty($API_Password) && !empty($API_Signature) && !empty($subject)) {
		$AuthMode = "THIRDPARTY";
	}else if(!empty($API_UserName) && !empty($API_Password) && !empty($API_Signature)) {
		$AuthMode = "3TOKEN";
	}else if(!empty($subject)) {
		$AuthMode = "FIRSTPARTY";
	}
}

switch($AuthMode) {
	
	case "3TOKEN" : 
			$nvpHeader = "&PWD=".urlencode($API_Password)."&USER=".urlencode($API_UserName)."&SIGNATURE=".urlencode($API_Signature);
			break;
	case "FIRSTPARTY" :
			$nvpHeader = "&SUBJECT=".urlencode($subject);
			break;
	case "THIRDPARTY" :
			$nvpHeader = "&PWD=".urlencode($API_Password)."&USER=".urlencode($API_UserName)."&SIGNATURE=".urlencode($API_Signature)."&SUBJECT=".urlencode($subject);
			break;		
	
}

$nvpstr = $nvpHeader.$nvpstr;

/* Make the API call to PayPal, using API signature.
   The API response is stored in an associative array called $resArray */
//$resArray=hash_call("doDirectPayment",$nvpstr);//for DirectPayment
$resArray=hash_call("CreateRecurringPaymentsProfile",$nvpstr);//for recaurringPayment
/* Display the API response back to the browser.
   If the response from PayPal was a success, display the response parameters'
   If the response was an error, display the errors received using APIError.php.
   */
 $ack = strtoupper($resArray["ACK"]);

	if($ack!="SUCCESS")  {
		$_SESSION['reshash']=$resArray;
		?>
        <html>
            <body>
                <form name="frm_pay" method="post" action="alert-payment.php?action=DataRestore&alt_id=<?=$alt_id?>">
                <input type="hidden" name="first_name" value="<?=$first_name?>" />
                <input type="hidden" name="last_name" value="<?=$last_name?>" />
                <input type="hidden" name="card_type" value="<?=$card_type?>" />
                <input type="hidden" name="card_num" value="<?=$card_num?>" />
                <input type="hidden" name="exp_month" value="<?=$exp_month?>" />
                <input type="hidden" name="exp_year" value="<?=$exp_year?>" />
                <input type="hidden" name="security_code" value="<?=$security_code?>" />
				
				<input type="hidden" name="profileDesc" value="<?=$card_row['profileDesc'];?>" />
				<input type="hidden" name="billingPeriod" value="<?=$card_row['billingPeriod'];?>" />
				<input type="hidden" name="billingFrequency" value="<?=$card_row['billingFrequency'];?>" />
				<input type="hidden" name="totalBillingCycles" value="<?=$card_row['totalBillingCycles'];?>" />
				<input type="hidden" name="startDate" value="<?=date('d/m/Y');?>" />
                
                <input type="hidden" name="company" value="<?=$company?>" />
                <input type="hidden" name="address" value="<?=$address?>" />
                <input type="hidden" name="address_cont" value="<?=$address_cont?>" />
                <input type="hidden" name="city" value="<?=$city?>" />
                <input type="hidden" name="state" value="<?=$state?>" />
                <input type="hidden" name="zip_code" value="<?=$zip_code?>" />
                <input type="hidden" name="country" value="<?=$country?>" />
				<input type="hidden" name="amount" value="<?=$_POST['amount']?>" />
                </form>
                <script type="text/javascript" language="javascript">
                document.frm_pay.submit();
                </script>
            </body>
        </html>
        <?PHP
		
	}else{
		$user_id = $_SESSION['sess_user_id'];
		$user_session_id = com_session_id();
		//$transaction_id = $resArray['TRANSACTIONID'];
		$transaction_id = $resArray['PROFILEID'];
		$payment_query = "insert into " . TABLE_PAYMENT . " (payment_type,user_id,first_name,last_name,transaction_id,session_id,add_date) values ('Alert','$user_id','$first_name','$last_name','$transaction_id','$user_session_id','$add_date')";
		com_db_query($payment_query);
		$payment_id = com_db_insert_id();
		
		$card_query = "insert into " . TABLE_CARD_INFO . " (user_id,payment_id,type,number,exp_month,exp_year,security_code,profileDesc,billingPeriod,billingFrequency,totalBillingCycles,profileStartDate,session_id) values ('$user_id','$payment_id','$card_type','$card_num','$exp_month','$exp_year','$security_code','$profileDesc','$billingPeriod','$billingFrequency','$totalBillingCycles','$pStartDate','$user_session_id')";
		com_db_query($card_query);
		
		$billing_query = "insert into " . TABLE_BILLING_ADDRESS . " (payment_id,user_id,company_name,address,address_cont,city,state,zip_code,country,add_date,session_id) values ('$payment_id','$user_id','$company','$address','$address_cont','$city','$state','$zip_code','$country','$add_date','$user_session_id')";
		com_db_query($billing_query);
		
		if($user_id !=''){
			$is_primary = com_db_GetValue("select user_id from " . TABLE_MY_CARD . " where user_id='".$user_id."' and card_number = '".$card_num."'");
			if(!$is_primary){
				$my_card = "insert into " . TABLE_MY_CARD . " (user_id,first_name,last_name,card_type,card_number,exp_month,exp_year,security_code,profileDesc,billingPeriod,billingFrequency,totalBillingCycles,profileStartDate,company_name,address,address_cont,city,state,zip_code,country,is_primary,add_date) values ('$user_id','$first_name','$last_name','$card_type','$card_num','$exp_month','$exp_year','$security_code','$profileDesc','$billingPeriod','$billingFrequency','$totalBillingCycles','$pStartDate','$company','$address','$address_cont','$city','$state','$zip_code','$country','Yes','$add_date')";
				com_db_query($my_card);
			}
			$alert_update = "update ".TABLE_ALERT." set transaction_id ='".$transaction_id."' where alert_id='".$alert_id."'";		
			com_db_query($alert_update);
			//
			$userResult = com_db_query("select first_name, last_name,email from " . TABLE_USER . " where user_id='".$user_id."'");
			$userrow = com_db_fetch_array($userResult);
			$email = $userrow['email'];
			//Email send
			//$to_admin = com_db_GetValue("select site_email_address from ". TABLE_ADMIN_SETTINGS ." where setting_id ='1'" );
			//$from_admin = com_db_GetValue("select site_email_from from ". TABLE_ADMIN_SETTINGS ." where setting_id ='1'" );
			//for admin email
			  
			$admin_mail_result =com_db_query("select * from " .TABLE_AUTORESPONDERS. " where type='Admin' and autoresponder_for='user submitted a credit card for alert'");
			$admin_mail_row = com_db_fetch_array($admin_mail_result);
			$admin_subject = "CTOsOnTheMove.com :: ".$admin_mail_row['subject'];
			$admin_body1 = com_db_output($admin_mail_row['body1']);
			$admin_body2 = com_db_output($admin_mail_row['body2']);
	
			  $message = '<a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'index.php"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/logo.jpg"  alt="Logo" width="196" height="32" border="0" title="Logo" /></a>&nbsp;
						  <table width="70%" cellspacing="0" cellpadding="3" >
							<tr>
								<td align="left" colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td align="left" colspan="2">'.$admin_body1." ".$admin_body2.'</td> 
							</tr>
							<tr>
								<td align="left"><b>Name:</b></td>
								<td align="left">'.$userrow['first_name'].' '.$userrow['last_name'].'</td>
							</tr>
							<tr>
								<td align="left"><b>Email:</b></td>
								<td align="left">'.$email.'</td>
							</tr>
							<tr>
								<td align="left" colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td align="left" colspan="2">'.$fromEmailSent.'</td>
							</tr>';
			 
			$message .=	'</table>';
			@send_email($to_admin, $admin_subject, $message, $from_admin); 
			//for user email
			  //$from_admin = com_db_GetValue("select site_email_from from ". TABLE_ADMIN_SETTINGS ." where setting_id ='1'" );	
			  
			  $user_mail_result =com_db_query("select * from " .TABLE_AUTORESPONDERS. " where type='User' and autoresponder_for='user submitted a credit card for alert'");
			  $user_mail_row = com_db_fetch_array($user_mail_result);
			  
			  $subject = "CTOsOnTheMove.com :: ".$user_mail_row['subject'];
					
			  $message = '<a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'index.php"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/logo.jpg"  alt="Logo" width="196" height="32" border="0" title="Logo" /></a>&nbsp;
							<table width="70%" cellspacing="0" cellpadding="3" >
								<tr>
									<td align="left" colspan="2"><b>Dear '.$userrow['first_name'].', </b>'.com_db_output($user_mail_row['body1']).' '.com_db_output($user_mail_row['body2']).'</td>
								</tr>
								<tr>
									<td align="left" colspan="2">&nbsp;</td>
								</tr>
								<tr>
									<td align="left" colspan="2">'.$fromEmailSent.'</td>
								</tr>';
			 
			$message .=	'</table>';
			@send_email($email, $subject, $message, $from_admin);
			$userName = com_db_GetValue("select concat(first_name,' ',last_name) from ".TABLE_USER." where user_id='".$user_id."'");
			$url = 'sub-thank-you.php?ragName='.$userName;
			com_redirect($url);
		}else{
			$url = 'provide-contact-information.php';
			com_redirect($url);	
		}	
	}
}
?>