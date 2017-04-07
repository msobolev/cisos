<?php
include("includes/include-top.php");
$action = $_GET['action'];

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
								
if($action == 'PCInformation'){
	$type=$_REQUEST['type'];
	$first_name = com_db_input($_POST['first_name']);
	if($first_name == 'Enter your First Name'){$first_name = '';}
	$last_name = com_db_input($_POST['last_name']);
	if($last_name== 'Enter your Last Name'){$last_name = '';}
	$company_name = com_db_input($_POST['company_name']);
	if($company_name == 'Enter your Company Name'){$company_name = '';}
	$phone = com_db_input($_POST['phone']);
	if($phone == 'Enter your Phone Number'){
		$phone ='';
	}
	$email = com_db_input($_POST['email']);
	if($email == 'Enter your Work Email Address'){$email = '';}
	$password = $_POST['password'];
	
	if(trim($first_name)=='' || trim($last_name) =='' || trim($company_name) == '' || trim($email) =='' || trim($password) ==''){
		$url = "provide-contact-information.php?action=BlankField&fn=".$first_name."&ln=".$last_name."&cn=".$company_name."&em=".$email."&ph=".$phone;
		com_redirect($url);
	}
        
	if($email !=''){
		$dom_name = explode("@",$email);
		$dname = explode(".", $dom_name[1]);
		$domain_name ='@'.$dname[0]."." ;
		$eda = str_replace("'","", $banned_domain_array);
		$banned_email_array = explode(",", $eda);
		for($dm = 0; $dm < sizeof($banned_email_array); $dm++){
			if(strtoupper($domain_name)==strtoupper($banned_email_array[$dm])){
				$url = "provide-contact-information.php?action=BannedEmail&fn=".$first_name."&ln=".$last_name."&cn=".$company_name."&em=".$email."&ph=".$phone;
				com_redirect($url);
			}
		}
	
	}
        
	$add_date = date('Y-m-d');
	$exp_date = date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('Y')+10));
	$referring_links = $_POST['referring_links'];
	if($type=='edit'){ die("in if");
		$res_id = $_REQUEST['resID'];
		$res_query = "update " . TABLE_USER . " set first_name ='".$first_name."',last_name ='".$last_name."', company_name = '".$company_name."',phone='".$phone."',email ='".$email."', password ='".$password."' where user_id='".$res_id."'";
		com_db_query($res_query);
	}elseif($type=='add'){ 
		$isPresentEmail = com_db_GetValue("select email from ".TABLE_USER." where email ='".$email."'");
		
                    
                    if($isPresentEmail !=''){
			$insert_delete_user = "insert into ".TABLE_DELETE_USER. " (user_id,first_name,last_name,title,company_name,phone,email,password,update_frequency,accept,subscription_id,alert_price,exp_date,res_date,modify_date,level,payment_by,status) (select user_id,first_name,last_name,title,company_name,phone,email,password,update_frequency,accept,subscription_id,alert_price,exp_date,res_date,modify_date,level,payment_by,status from ".TABLE_USER." where email ='".$email."')";
			com_db_query($insert_delete_user);
			com_db_query("delete from ".TABLE_USER." where email='".$email."'");
		}
                
                
			$res_query = "insert into " . TABLE_USER . " (first_name,last_name,company_name,phone,email,password,exp_date,res_date,referring_links) values ('$first_name','$last_name','$company_name','$phone','$email','$password','$exp_date','$add_date','$referring_links')";
			com_db_query($res_query);
			$res_id = com_db_insert_id();
                        
                        
                        
			//Email send
			//for admin email
			$admin_mail_result =com_db_query("select * from " .TABLE_AUTORESPONDERS. " where type='Admin' and autoresponder_for='New user registered'");
			$admin_mail_row = com_db_fetch_array($admin_mail_result);
			  
			  $subject = "CTOsOnTheMove.com :: ".com_db_output($admin_mail_row['subject']);
				
			  $message = '<a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'index.php"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/logo.jpg"  alt="Logo" width="196" height="32" border="0" title="Logo" /></a>&nbsp;
						  <table width="70%" cellspacing="0" cellpadding="3">
							<tr>
								<td align="left" colspan="2">'.com_db_output($admin_mail_row['body1']).' '.com_db_output($admin_mail_row['body2']).'</td>
							</tr>
							<tr>
								<td align="left"><b>Name:</b></td>
								<td align="left">'.$first_name.' '.$last_name.'</td>
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
			@send_email($to_admin, $subject, $message, $email); 
			//for user email
		  
			  $user_mail_result =com_db_query("select * from " .TABLE_AUTORESPONDERS. " where type='User' and autoresponder_for='successful registration of a new user'");
			  $user_mail_row = com_db_fetch_array($user_mail_result);
			  
			  $subject = "CTOsOnTheMove :: ".$user_mail_row['subject'];
					
			  $message = '<a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'index.php"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/logo.jpg"  alt="Logo" width="196" height="32" border="0" title="Logo" /></a>
						  <table width="70%" cellspacing="0" cellpadding="3">
							<tr>
								<td align="left" colspan="2">Dear '.$first_name.', </td>
							</tr>
							<tr>
								<td align="left" colspan="2">'.com_db_output($user_mail_row['body1']).'&nbsp;<a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'index.php?action=Activate&act_id='.$res_id.'">'.com_db_output($user_mail_row['link_caption']).'</a> </td>
							</tr>
							<tr>
								<td align="left" colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td align="left" colspan="2">'.com_db_output($user_mail_row['body2']).'</a> </td>
							</tr>
							<tr>
								<td align="left" colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td align="left" colspan="2">Best,</td>
							</tr>
							<tr>
								<td align="left" colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td align="left" colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td align="left" colspan="2">'.$fromEmailSent.'</td>
							</tr>';
							
			$message .=	'</table>';
			@send_email($email, $subject, $message, $from_admin);
	}
	if ($_SESSION['sess_sub_choose'] !=''){
		$subscription_id = $_SESSION['sess_sub_choose'];
		$amount = com_db_GetValue("select amount from " . TABLE_SUBSCRIPTION . " where sub_id='".$subscription_id."'");
		if($amount > 0){
			$level = 'Paid';	
		}else{
			$level = 'Free';
		}
		$limit_value = $_SESSION['sess_alert_price'];
		$isPayment =  com_db_GetValue("select transaction_id from " . TABLE_PAYMENT . " where user_id='".$res_id."'");
		if($isPayment !=''){
			$exp_date = date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('y')+10));
			$res_query = "update " . TABLE_USER . " set exp_date ='".$exp_date."', subscription_id ='" .$subscription_id . "', alert_price='".$limit_value."', level ='" . $level . "', status='0'  where user_id='".$res_id."'";
			com_db_query($res_query);
			//session_unregister('sess_alert_price');
			//session_unregister('sess_sub_choose');
			unset($_SESSION['sess_alert_price']);
			unset($_SESSION['sess_sub_choose']);
		}

		if($subscription_id == 1){
			$userName = com_db_GetValue("select concat(first_name,' ',last_name) from ".TABLE_USER." where user_id='".$res_id."'");
			$url = 'sub-thank-you.php?ragName='.$userName;
		}else{
			$url = 'submit-payment.php?res_id='.$res_id;
		}	
	}else{
		$user_session_id = com_session_id();
		$alert_id = com_db_GetValue("select alert_id from " . TABLE_ALERT_WITHOUT_LOGIN. " where session_id='".$user_session_id."'");
		if($alert_id > 0){
			$alert_query ="update " . TABLE_ALERT . " set user_id='".$res_id."' where alert_id='".$alert_id."'";
			com_db_query($alert_query);
			com_db_query("update " . TABLE_PAYMENT . " set user_id ='".$res_id."' where session_id='".$user_session_id."'");
			com_db_query("update " . TABLE_BILLING_ADDRESS . " set user_id ='".$res_id."' where session_id='".$user_session_id."'");
		}
		$url = 'choose-subscription.php?res_id='.$res_id;
	}	
	com_redirect($url);
}

if($action == 'Subscription'){
	$subscription_id = $_POST['radio_sub_id'];
	$amount = com_db_GetValue("select amount from " . TABLE_SUBSCRIPTION . " where sub_id='".$subscription_id."'");
	if($amount > 0){
		$level = 'Paid';	
	}else{
		$level = 'Free';
	}
	$res_id = $_REQUEST['res_id'];
	$limit_value = $_REQUEST['limit_value'];

	$exp_date = date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('y')+10));
	if($subscription_id == 1){
		$res_query = "update " . TABLE_USER . " set exp_date ='".$exp_date."', subscription_id ='" .$subscription_id . "', alert_price='".$limit_value."', level ='" . $level . "', status='0'  where user_id='".$res_id."'";
		com_db_query($res_query);
	}else{
		//$res_query = "update " . TABLE_USER . " set exp_date ='".$exp_date."', subscription_id ='1', level ='Free', status='0'  where user_id='".$res_id."'";
		//com_db_query($res_query);
		$insert_query = "insert into ".TABLE_TEMP_SUBSCRIPTION ."(user_id,subscription_id,alert_price,level,add_date) values('$res_id','$subscription_id','$limit_value','$level','".date('Y-m-d')."')";
		com_db_query($insert_query);
	}	
	if($subscription_id == 1){
		$userName = com_db_GetValue("select concat(first_name,' ',last_name) from ".TABLE_USER." where user_id='".$res_id."'");
		$url = 'sub-thank-you.php?ragName='.$userName;
	}else{
		$url = 'submit-payment.php?res_id='.$res_id;
	}	
	com_redirect($url);
}
if($action == 'SubscriptionAdminUser'){
	$subscription_id = $_POST['radio_sub_id'];
	$amount = com_db_GetValue("select amount from " . TABLE_SUBSCRIPTION . " where sub_id='".$subscription_id."'");
	if($amount > 0){
		$level = 'Paid';	
	}else{
		$level = 'Free';
	}
	$res_id = $_REQUEST['res_id'];
	$limit_value = $_REQUEST['limit_value'];

	$exp_date = date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('y')+10));

	
	if($subscription_id == 1){
		$res_query = "update " . TABLE_USER . " set exp_date ='".$exp_date."', subscription_id ='" .$subscription_id . "', alert_price='".$limit_value."', level ='" . $level . "', status='0'  where user_id='".$res_id."'";
		com_db_query($res_query);
	}else{
		$insert_query = "insert into ".TABLE_TEMP_SUBSCRIPTION ."(user_id,subscription_id,alert_price,level,add_date) values('$res_id','$subscription_id','$limit_value','$level','".date('Y-m-d')."')";
		com_db_query($insert_query);
	}

	if($subscription_id == 1){
		$userName = com_db_GetValue("select concat(first_name,' ',last_name) from ".TABLE_USER." where user_id='".$res_id."'");
		$url = 'sub-thank-you.php?ragName='.$userName;
	}else{
		$url = 'submit-user-payment.php?res_id='.$res_id;
	}	
	com_redirect($url);
}
if($action == 'SubmitPayment'){

	$res_id = $_REQUEST['res_id'];
	$amount = com_db_GetValue("select amount from " . TABLE_SUBSCRIPTION . ' s, '. TABLE_TEMP_SUBSCRIPTION . " ts where s.sub_id = ts.subscription_id and ts.user_id='".$res_id."'");
	$card_holder_name = explode(' ',$_POST['card_holder_name']);
	
	$first_name = $card_holder_name[0];
	$last_name = $card_holder_name[sizeof($card_holder_name)-1];
	$user_email =com_db_GetValue("select email from " . TABLE_USER . " where user_id='".$res_id."'");
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
$firstName =urlencode($first_name);
$lastName =urlencode($last_name);
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
"&ZIP=$zip&COUNTRYCODE=US&CURRENCYCODE=$currencyCode&PROFILESTARTDATE=$profileStartDate&DESC=$profileDesc&BILLINGPERIOD=$billingPeriod&BILLINGFREQUENCY=$billingFrequency&TOTALBILLINGCYCLES=$totalBillingCycles&EMAIL=$user_email";

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
		//$location = "APIError.php";
		//header("Location: $location");
		?>
        <html>
            <body>
                <form name="frm_pay" method="post" action="card-info-incorrect.php?action=DataRestore&res_id=<?=$res_id?>">
                <input type="hidden" name="first_name" value="<?=$first_name?>" />
                <input type="hidden" name="last_name" value="<?=$last_name?>" />
                <input type="hidden" name="card_type" value="<?=$card_type?>" />
                <input type="hidden" name="card_num" value="<?=$card_num?>" />
                <input type="hidden" name="exp_month" value="<?=$exp_month?>" />
                <input type="hidden" name="exp_year" value="<?=$exp_year?>" />
                <input type="hidden" name="security_code" value="<?=$security_code?>" />
                
				<input type="hidden" name="profileDesc" value="<?=$profileDesc?>" />
                <input type="hidden" name="billingPeriod" value="<?=$billingPeriod?>" />
                <input type="hidden" name="billingFrequency" value="<?=$billingFrequency?>" />
                <input type="hidden" name="totalBillingCycles" value="<?=$totalBillingCycles?>" />
				<input type="hidden" name="startDate" value="<?=$startDate?>" />
				
                <input type="hidden" name="company" value="<?=$company?>" />
                <input type="hidden" name="address" value="<?=$address?>" />
                <input type="hidden" name="address_cont" value="<?=$address_cont?>" />
                <input type="hidden" name="city" value="<?=$city?>" />
                <input type="hidden" name="state" value="<?=$state?>" />
                <input type="hidden" name="zip_code" value="<?=$zip_code?>" />
                <input type="hidden" name="country" value="<?=$country?>" />
                </form>
                <script type="text/javascript" language="javascript">
                	document.frm_pay.submit();
                </script>
            </body>
        </html>
        <?PHP
		
	}else{
		//$transaction_id = $resArray['TRANSACTIONID'];
		$transaction_id = $resArray['PROFILEID'];
		$subscrip_result = com_db_query("select * from ". TABLE_TEMP_SUBSCRIPTION." where user_id='".$res_id."' and add_date='".date('Y-m-d')."'");
		$subscrip_row = com_db_fetch_array($subscrip_result);
		$update_user = "update ". TABLE_USER. " set subscription_id='".$subscrip_row['subscription_id']."',alert_price ='".$subscrip_row['alert_price']."', level='".$subscrip_row['level']."', payment_by='User' where user_id='".$res_id."'";
		com_db_query($update_user);
		com_db_query("delete from " .TABLE_TEMP_SUBSCRIPTION ." where user_id='".$res_id."'");
		
		$payment_query = "insert into " . TABLE_PAYMENT . " (payment_type,user_id,first_name,last_name,transaction_id,add_date) values ('Registration','$res_id','$first_name','$last_name','$transaction_id','$add_date')";
		com_db_query($payment_query);
		$payment_id = com_db_insert_id();
		
		$billing_query = "insert into " . TABLE_BILLING_ADDRESS . " (payment_id,user_id,company_name,address,address_cont,city,state,zip_code,country,add_date) values ('$payment_id','$res_id','$company','$address','$address_cont','$city','$state','$zip_code','$country','$add_date')";
		com_db_query($billing_query);
		
	
		$userResult = com_db_query("select first_name, last_name,email from " . TABLE_USER . " where user_id='".$res_id."'");
		$userrow = com_db_fetch_array($userResult);
		//$_SESSION['sess_username'] = $userrow['first_name'].' '.$userrow['last_name'];
		$email = $userrow['email'];
		//Email send
		//$to_admin = com_db_GetValue("select site_email_address from ". TABLE_ADMIN_SETTINGS ." where setting_id ='1'" );
		//$from_site = com_db_GetValue("select site_email_from from ". TABLE_ADMIN_SETTINGS ." where setting_id ='1'" );
		//for admin email

		$admin_mail_result =com_db_query("select * from " .TABLE_AUTORESPONDERS. " where type='Admin' and autoresponder_for='user submitted a credit card for subscription'");
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
		  //$from_admin = com_db_GetValue("select site_email_address from ". TABLE_ADMIN_SETTINGS ." where setting_id ='1'" );	
		 
		  $user_mail_result =com_db_query("select * from " .TABLE_AUTORESPONDERS. " where type='User' and autoresponder_for='user submitted a credit card for subscription'");
		  $user_mail_row = com_db_fetch_array($user_mail_result);
		  
		  $subject = "CTOsOnTheMove.com :: ".com_db_output($user_mail_row['subject']);
				 		
		  $message = '<a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'index.php"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/logo.jpg"  alt="Logo" width="196" height="32" border="0" title="Logo" /></a>&nbsp;
					  <table width="70%" cellspacing="0" cellpadding="3" >
						<tr>
							<td align="left" colspan="2"><b>Dear '.$userrow['first_name'].', </b></td>
						</tr>
						<tr>
							<td align="left" colspan="2">'.com_db_output($user_mail_row['body1']).' '.com_db_output($user_mail_row['body2']).'</td>
						</tr>
						<tr>
							<td align="left" colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td align="left" colspan="2">'.$fromEmailSent.'</td>
						</tr>';
		 
		$message .=	'</table>';
		@send_email($email, $subject, $message, $from_admin);
		
		$userName = com_db_GetValue("select concat(first_name,' ',last_name) from ".TABLE_USER." where user_id='".$res_id."'");
		$url = 'sub-thank-you.php?ragName='.$userName;
		
		com_redirect($url);
	}
}
//
if($action == 'SubmitPaymentAdminUser'){

	$res_id = $_REQUEST['res_id'];
	//$amount = com_db_GetValue("select amount from " . TABLE_SUBSCRIPTION . ' s, '. TABLE_USER . " u where s.sub_id = u.subscription_id and u.user_id='".$res_id."'");
	$amount = com_db_GetValue("select amount from " . TABLE_SUBSCRIPTION . ' s, '. TABLE_TEMP_SUBSCRIPTION . " ts where s.sub_id = ts.subscription_id and ts.user_id='".$res_id."'");
	$ch_name = explode(' ', $_POST['card_holder_name']);
	$first_name = com_db_input($ch_name[0]);
	$last_name = com_db_input($ch_name[sizeof($ch_name)-1]);
	$user_email =com_db_GetValue("select email from " . TABLE_USER . " where user_id='".$res_id."'");
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
$firstName =urlencode($ch_name[0]);
$lastName =urlencode($ch_name[sizeof($ch_name)-1]);
$creditCardType =urlencode($_POST['card_type']);
$creditCardNumber = urlencode($_POST['card_num']);
$expDateMonth =urlencode($_POST['exp_month']);

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
"&ZIP=$zip&COUNTRYCODE=US&CURRENCYCODE=$currencyCode&PROFILESTARTDATE=$profileStartDate&DESC=$profileDesc&BILLINGPERIOD=$billingPeriod&BILLINGFREQUENCY=$billingFrequency&TOTALBILLINGCYCLES=$totalBillingCycles&EMAIL=$user_email";

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
		//$location = "APIError.php";
		//header("Location: $location");
		?>
        <html>
            <body>
                <form name="frm_pay" method="post" action="card-info-user-incorrect.php?action=DataRestore&res_id=<?=$res_id?>">
                <input type="hidden" name="first_name" value="<?=$first_name?>" />
                <input type="hidden" name="last_name" value="<?=$last_name?>" />
                <input type="hidden" name="card_type" value="<?=$card_type?>" />
                <input type="hidden" name="card_num" value="<?=$card_num?>" />
                <input type="hidden" name="exp_month" value="<?=$exp_month?>" />
                <input type="hidden" name="exp_year" value="<?=$exp_year?>" />
                <input type="hidden" name="security_code" value="<?=$security_code?>" />
                
				<input type="hidden" name="profileDesc" value="<?=$profileDesc?>" />
                <input type="hidden" name="billingPeriod" value="<?=$billingPeriod?>" />
                <input type="hidden" name="billingFrequency" value="<?=$billingFrequency?>" />
                <input type="hidden" name="totalBillingCycles" value="<?=$totalBillingCycles?>" />
				<input type="hidden" name="startDate" value="<?=$startDate?>" />
				
                <input type="hidden" name="company" value="<?=$company?>" />
                <input type="hidden" name="address" value="<?=$address?>" />
                <input type="hidden" name="address_cont" value="<?=$address_cont?>" />
                <input type="hidden" name="city" value="<?=$city?>" />
                <input type="hidden" name="state" value="<?=$state?>" />
                <input type="hidden" name="zip_code" value="<?=$zip_code?>" />
                <input type="hidden" name="country" value="<?=$country?>" />
                </form>
                <script type="text/javascript" language="javascript">
                document.frm_pay.submit();
                </script>
            </body>
        </html>
        <?PHP
		
	}else{
		//$transaction_id = $resArray['TRANSACTIONID'];
		$transaction_id = $resArray['PROFILEID'];
		$subscrip_result = com_db_query("select * from ". TABLE_TEMP_SUBSCRIPTION." where user_id='".$res_id."' and add_date='".date('Y-m-d')."'");
		$subscrip_row = com_db_fetch_array($subscrip_result);
		$update_user = "update ". TABLE_USER. " set subscription_id='".$subscrip_row['subscription_id']."',alert_price ='".$subscrip_row['alert_price']."', level='".$subscrip_row['level']."',payment_by='User' where user_id='".$res_id."'";
		com_db_query($update_user);
		com_db_query("delete from " .TABLE_TEMP_SUBSCRIPTION ." where user_id='".$res_id."'");
		
		$payment_query = "insert into " . TABLE_PAYMENT . " (payment_type,user_id,first_name,last_name,transaction_id,add_date) values ('Registration','$res_id','$first_name','$last_name','$transaction_id','$add_date')";
		com_db_query($payment_query);
		$payment_id = com_db_insert_id();
		
				
		$billing_query = "insert into " . TABLE_BILLING_ADDRESS . " (payment_id,user_id,company_name,address,address_cont,city,state,zip_code,country,add_date) values ('$payment_id','$res_id','$company','$address','$address_cont','$city','$state','$zip_code','$country','$add_date')";
		com_db_query($billing_query);
		
			
		$userResult = com_db_query("select first_name, last_name,email from " . TABLE_USER . " where user_id='".$res_id."'");
		$userrow = com_db_fetch_array($userResult);
		$email = $userrow['email'];
		//Email send
		//$to_admin = com_db_GetValue("select site_email_address from ". TABLE_ADMIN_SETTINGS ." where setting_id ='1'" );
		//$from_site = com_db_GetValue("select site_email_from from ". TABLE_ADMIN_SETTINGS ." where setting_id ='1'" );
		//for admin email


		$admin_mail_result =com_db_query("select * from " .TABLE_AUTORESPONDERS. " where type='Admin' and autoresponder_for='user submitted a credit card for subscription'");
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
		  //$from_admin = com_db_GetValue("select site_email_address from ". TABLE_ADMIN_SETTINGS ." where setting_id ='1'" );	
		 
		  $user_mail_result =com_db_query("select * from " .TABLE_AUTORESPONDERS. " where type='User' and autoresponder_for='user submitted a credit card for subscription'");
		  $user_mail_row = com_db_fetch_array($user_mail_result);
		  
		  $subject = "CTOsOnTheMove.com :: ".com_db_output($user_mail_row['subject']);
				 		
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
		
		$userName = com_db_GetValue("select concat(first_name,' ',last_name) from ".TABLE_USER." where user_id='".$res_id."'");
		$url = 'sub-thank-you.php?ragName='.$userName;
		
		com_redirect($url);
	}
}
//
if($action == 'UserLogin'){
    
	$login_email = $_POST['login_email'];
	$login_pass	= $_POST['login_pass'];
        
        $login_email_lower = strtolower($login_email);
        
	if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $login_email_lower)){ 
		 $url = "login.php?action=LoginEmail&login_email=".$login_email;
		 com_redirect($url);
	 }
         
	//$user_query = "select * from " . TABLE_USER ." where email = '".$login_email."' and status='0'";
	$user_query = "select * from " . TABLE_USER ." where LOWER(`email`) = '".$login_email_lower."' and status='0'";
	$user_result = com_db_query($user_query);
        
	if($user_result){
		$row_count = com_db_num_rows($user_result);
		if($row_count > 0){
			$user_row = com_db_fetch_array($user_result);
			$user_name = $user_row['first_name'] .' ' . $user_row['last_name'];
			$user_email = $user_row['email'];
			$password_db = $user_row['password'];
			
			if(strtoupper($login_pass) == strtoupper($password_db)){	
				if(isset($_COOKIE['loginsessionid'])){
					com_db_query("update ".TABLE_LOGIN_HISTORY." set logout_time ='" .time()."', log_status='Logout' where session_id='".$_COOKIE['loginsessionid']."'");
				}
				$user_is_login = com_db_GetValue("select login_id from " . TABLE_LOGIN_HISTORY . " where user_id='".$user_row['user_id']."' and log_status='Login' and add_date='".date('Y-m-d')."' order by login_id desc");
				if($user_is_login){
					  
					  $admin_mail_result =com_db_query("select * from " .TABLE_AUTORESPONDERS. " where type='Admin' and autoresponder_for='User attempted to concurrently login with the same login/password'");
					  $admin_mail_row = com_db_fetch_array($admin_mail_result);
					  $subject = "CTOsOnTheMove.com :: ".$admin_mail_row['subject'];
					  $admin_body1 = com_db_output($admin_mail_row['body1']);
					  $admin_body2 = com_db_output($admin_mail_row['body2']);

					  $message = '<a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'index.php"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/logo.jpg"  alt="Logo" width="196" height="32" border="0" title="Logo" /></a>&nbsp;
					  			  <table width="70%" cellspacing="0" cellpadding="3" >
									
									<tr>
										<td align="left" colspan="2">'.$admin_body1." ".$admin_body2.'</td> 
									</tr>
									<tr>
										<td align="left"><b>Name:</b></td>
										<td align="left">'.$user_row['first_name'].' '.$user_row['last_name'].'</td>
									</tr>
									<tr>
										<td align="left"><b>Email:</b></td>
										<td align="left">'.$user_row['email'].'</td>
									</tr>
									<tr>
										<td align="left" colspan="2">&nbsp;</td>
									</tr>
									<tr>
										<td align="left" colspan="2">'.$fromEmailSent.'</td>
									</tr>';
					 				
					$message .=	'</table>';
					
					@send_email($to_admin, $subject, $message, $user_email);
					$url = "concurrent-logins.php";
					com_redirect($url);	
				}
				
				
				$_SESSION['sess_is_user'] = 1;
				$_SESSION['sess_user_id'] = $user_row['user_id'];
				$_SESSION['sess_username'] = $user_name;
				$_SESSION['sess_payment'] = 'Complited';
				$user_id = $user_row['user_id'];
				$add_date = date("Y-m-d");
				$login_time = time();
				$logout_time =0;
				$log_status = 'Login';
				
				$session_id = session_id();
				setcookie("loginsessionid", $session_id, time()+3600);
				$sql_login_query = "insert into " . TABLE_LOGIN_HISTORY . " (user_id,add_date,login_time,logout_time,session_id,log_status) values('$user_id','$add_date','$login_time','$logout_time','$session_id','$log_status')";
	    		com_db_query($sql_login_query);
				
				$user_level = $user_row['level'];
				$payment_by = $user_row['payment_by'];	
					if($user_level==''){
						com_redirect("choose-user-subscription.php?res_id=".$user_id);
					}elseif($user_level=='Paid'){
						$isPayment	= com_db_GetValue("select payment_id from ".TABLE_PAYMENT." where payment_type='Registration' and user_id='".$user_id."'");
						if($isPayment=='' && $payment_by =='Admin'){
							com_redirect("advance-search.php");
						}elseif($isPayment=='' && $payment_by =='User'){
							$_SESSION['sess_payment'] = 'Not Complited';
							com_redirect("provide-contact-information.php?action=back&resID=".$user_id);
						}else{
							com_redirect("advance-search.php");
						}
					}else{
						com_redirect("advance-search.php");
					}	
				}
			$url = "login.php?action=LoginPassword&login_email=".$login_email;
			com_redirect($url);
		}else{
			$url = "login.php?action=LoginEmail&login_email=".$login_email;
			com_redirect($url);
		}
	}else{
		$url = "login.php?action=LoginEmailPassword";
		com_redirect($url);	
	}
}
if($action =='ChoosePricing'){
	$choose_opt = $_POST['radiobutton'];
	$alert_price = $_POST['limit_value'];
	
	$_SESSION['sess_sub_choose'] = $choose_opt;
	$_SESSION['sess_alert_price'] = $alert_price;
	$url = "provide-contact-information.php";
	com_redirect($url);
}

if($action == 'SubscriptionSignUp'){
	$subscription_id = $_POST['radio_sub_id'];
	$amount = com_db_GetValue("select amount from " . TABLE_SUBSCRIPTION . " where sub_id='".$subscription_id."'");
	if($amount > 0){
		$level = 'Paid';	
	}else{
		$level = 'Free';
	}
	$res_id = $_REQUEST['res_id'];

	$exp_date = date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('y')+10));
	
	if($subscription_id == 1){
		$res_query = "update " . TABLE_USER . " set exp_date ='".$exp_date."', subscription_id ='" .$subscription_id . "', alert_price='".$limit_value."', level ='" . $level . "', status='0'  where user_id='".$res_id."'";
		com_db_query($res_query);
	}else{
		$insert_query = "insert into ".TABLE_TEMP_SUBSCRIPTION ."(user_id,subscription_id,alert_price,level,add_date) values('$res_id','$subscription_id','$limit_value','$level','".date('Y-m-d')."')";
		com_db_query($insert_query);
	}

	if($subscription_id == 1){
		$userName = com_db_GetValue("select concat(first_name,' ',last_name) from ".TABLE_USER." where user_id='".$res_id."'");
		$url = 'sub-thank-you.php?ragName='.$userName;
	}else{
		$url = 'submit-signup-payment.php?res_id='.$res_id;
	}	
	com_redirect($url);
}

if($action == 'SubmitPaymentSignUp'){

	$res_id = $_REQUEST['res_id'];
	$amount = com_db_GetValue("select amount from " . TABLE_SUBSCRIPTION . ' s, '. TABLE_TEMP_SUBSCRIPTION . " ts where s.sub_id = ts.subscription_id and ts.user_id='".$res_id."'");
	$ch_name = explode(' ', $_POST['card_holder_name']);
	$first_name = com_db_input($ch_name[0]);
	$last_name = com_db_input($ch_name[sizeof($ch_name)-1]);
	$user_email =com_db_GetValue("select email from " . TABLE_USER . " where user_id='".$res_id."'");
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
$firstName =urlencode($ch_name[0]);
$lastName =urlencode($ch_name[sizeof($ch_name)-1]);
$creditCardType =urlencode($_POST['card_type']);
$creditCardNumber = urlencode($_POST['card_num']);
$expDateMonth =urlencode($_POST['exp_month']);

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
"&ZIP=$zip&COUNTRYCODE=US&CURRENCYCODE=$currencyCode&PROFILESTARTDATE=$profileStartDate&DESC=$profileDesc&BILLINGPERIOD=$billingPeriod&BILLINGFREQUENCY=$billingFrequency&TOTALBILLINGCYCLES=$totalBillingCycles&EMAIL=$user_email";

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
		//$location = "APIError.php";
		//header("Location: $location");
		?>
        <html>
            <body>
                <form name="frm_pay" method="post" action="card-info-signup-incorrect.php?action=DataRestore&res_id=<?=$res_id?>">
                <input type="hidden" name="first_name" value="<?=$first_name?>" />
                <input type="hidden" name="last_name" value="<?=$last_name?>" />
                <input type="hidden" name="card_type" value="<?=$card_type?>" />
                <input type="hidden" name="card_num" value="<?=$card_num?>" />
                <input type="hidden" name="exp_month" value="<?=$exp_month?>" />
                <input type="hidden" name="exp_year" value="<?=$exp_year?>" />
                <input type="hidden" name="security_code" value="<?=$security_code?>" />
                
				<input type="hidden" name="profileDesc" value="<?=$profileDesc?>" />
                <input type="hidden" name="billingPeriod" value="<?=$billingPeriod?>" />
                <input type="hidden" name="billingFrequency" value="<?=$billingFrequency?>" />
                <input type="hidden" name="totalBillingCycles" value="<?=$totalBillingCycles?>" />
				<input type="hidden" name="startDate" value="<?=$startDate?>" />
				
                <input type="hidden" name="company" value="<?=$company?>" />
                <input type="hidden" name="address" value="<?=$address?>" />
                <input type="hidden" name="address_cont" value="<?=$address_cont?>" />
                <input type="hidden" name="city" value="<?=$city?>" />
                <input type="hidden" name="state" value="<?=$state?>" />
                <input type="hidden" name="zip_code" value="<?=$zip_code?>" />
                <input type="hidden" name="country" value="<?=$country?>" />
                </form>
                <script type="text/javascript" language="javascript">
                document.frm_pay.submit();
                </script>
            </body>
        </html>
        <?PHP
		
	}else{
		//$transaction_id = $resArray['TRANSACTIONID'];
		$transaction_id = $resArray['PROFILEID'];
		$subscrip_result = com_db_query("select * from ". TABLE_TEMP_SUBSCRIPTION." where user_id='".$res_id."' and add_date='".date('Y-m-d')."'");
		$subscrip_row = com_db_fetch_array($subscrip_result);
		$update_user = "update ". TABLE_USER. " set subscription_id='".$subscrip_row['subscription_id']."',alert_price ='".$subscrip_row['alert_price']."', level='".$subscrip_row['level']."',payment_by='User', status='0' where user_id='".$res_id."'";
		com_db_query($update_user);
		com_db_query("delete from " .TABLE_TEMP_SUBSCRIPTION ." where user_id='".$res_id."'");
		
		$payment_query = "insert into " . TABLE_PAYMENT . " (payment_type,user_id,first_name,last_name,transaction_id,add_date) values ('Registration','$res_id','$first_name','$last_name','$transaction_id','$add_date')";
		com_db_query($payment_query);
		$payment_id = com_db_insert_id();
		
				
		$billing_query = "insert into " . TABLE_BILLING_ADDRESS . " (payment_id,user_id,company_name,address,address_cont,city,state,zip_code,country,add_date) values ('$payment_id','$res_id','$company','$address','$address_cont','$city','$state','$zip_code','$country','$add_date')";
		com_db_query($billing_query);
		
		
		$userResult = com_db_query("select first_name, last_name,email from " . TABLE_USER . " where user_id='".$res_id."'");
		$userrow = com_db_fetch_array($userResult);
		$email = $userrow['email'];
		//Email send
		//$to_admin = com_db_GetValue("select site_email_address from ". TABLE_ADMIN_SETTINGS ." where setting_id ='1'" );
		//$from_site = com_db_GetValue("select site_email_from from ". TABLE_ADMIN_SETTINGS ." where setting_id ='1'" );
		//for admin email


		$admin_mail_result =com_db_query("select * from " .TABLE_AUTORESPONDERS. " where type='Admin' and autoresponder_for='user submitted a credit card for subscription'");
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
		  //$from_admin = com_db_GetValue("select site_email_address from ". TABLE_ADMIN_SETTINGS ." where setting_id ='1'" );	
		 
		  $user_mail_result =com_db_query("select * from " .TABLE_AUTORESPONDERS. " where type='User' and autoresponder_for='user submitted a credit card for subscription'");
		  $user_mail_row = com_db_fetch_array($user_mail_result);
		  
		  $subject = "CTOsOnTheMove.com :: ".com_db_output($user_mail_row['subject']);
				 		
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
		
		$userName = com_db_GetValue("select concat(first_name,' ',last_name) from ".TABLE_USER." where user_id='".$res_id."'");
		$url = 'sub-thank-you.php?ragName='.$userName;
		
		com_redirect($url);
	}
}
?>