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
		$url = "provide-contact-information-price.php?action=BlankField&fn=".$first_name."&ln=".$last_name."&cn=".$company_name."&em=".$email."&ph=".$phone;
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
				$url = "provide-contact-information-price.php?action=BannedEmail&fn=".$first_name."&ln=".$last_name."&cn=".$company_name."&em=".$email."&ph=".$phone;
				com_redirect($url);
			}
		}
	
	}
	
	$add_date = date('Y-m-d');
	$exp_date =date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('Y')+10));
	$isPresentEmail = com_db_GetValue("select email from ".TABLE_USER." where email ='".$email."'");
	if($isPresentEmail !=''){
		$url = "provide-contact-information-price.php?action=DublicatEmail&fn=".$first_name."&ln=".$last_name."&cn=".$company_name."&em=".$email."&ph=".$phone;
		com_redirect($url);
	}		
	$res_query = "insert into " . TABLE_USER . " (first_name,last_name,company_name,phone,email,password,exp_date,res_date,status) values ('$first_name','$last_name','$company_name','$phone','$email','$password','$exp_date','$add_date','0')";
	com_db_query($res_query);
	$res_id = com_db_insert_id();
	//Email send
	//$to_admin = com_db_GetValue("select site_email_address from ". TABLE_ADMIN_SETTINGS ." where setting_id ='1'" );
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
	  //$from_admin = com_db_GetValue("select site_email_from from ". TABLE_ADMIN_SETTINGS ." where setting_id ='1'" );	
	  
	  $user_mail_result =com_db_query("select * from " .TABLE_AUTORESPONDERS. " where type='User' and autoresponder_for='successful registration of a new user'");
	  $user_mail_row = com_db_fetch_array($user_mail_result);
	  
	  $subject = "CTOsOnTheMove.com :: ".$user_mail_row['subject'];
			
	
	//$admin_address = com_db_query("Select * from " . TABLE_ADMIN_SETTINGS);	
	//$admin_address_row = com_db_fetch_array($admin_address);	
	  
	  $message = '<a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'index.php"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/logo.jpg"  alt="Logo" width="196" height="32" border="0" title="Logo" /></a>&nbsp;
				  <table width="70%" cellspacing="0" cellpadding="3">
					<tr>
						<td align="left" colspan="2">Dear '.$first_name.', </td>
					</tr>
					<tr>
						<td align="left" colspan="2">'.com_db_output($user_mail_row['body1']).'<a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'index.php?action=Activate&act_id='.$res_id.'">'.com_db_output($user_mail_row['link_caption']).'</a> </td>
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
						<td align="left" colspan="2">'.$fromEmailSent.'</td>
					</tr>';
	 				
	$message .=	'</table>';
	@send_email($email, $subject, $message, $from_admin);
	
	if ($_SESSION['sess_sub_choose'] !=''){
		$subscription_id = $_SESSION['sess_sub_choose'];
		$amount = com_db_GetValue("select amount from " . TABLE_SUBSCRIPTION . " where sub_id='".$subscription_id."'");
		if($amount > 0){
			$level = 'Paid';	
		}else{
			$level = 'Free';
		}
		//$limit_value = $_SESSION['sess_alert_price'];
	
		$exp_date = date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('y')+10));
		$res_query = "update " . TABLE_USER . " set exp_date ='".$exp_date."', subscription_id ='" .$subscription_id . "', alert_price='".$limit_value."', level ='" . $level . "', payment_by='User'  where user_id='".$res_id."'";
		com_db_query($res_query);
		
		$user_session_id = com_session_id();
		$payment_id = com_db_GetValue("select payment_id from " . TABLE_PAYMENT_BEFOR_REG. " where session_id='".$user_session_id."'");
		if($payment_id > 0){
			com_db_query("update " . TABLE_PAYMENT . " set user_id ='".$res_id."' where session_id='".$user_session_id."' and payment_id='".$payment_id."'");
			com_db_query("update " . TABLE_BILLING_ADDRESS . " set user_id ='".$res_id."' where session_id='".$user_session_id."' and payment_id='".$payment_id."'");
			
		}
		
		//session_unregister('sess_alert_price');
		session_unregister('sess_sub_choose');
		
		$userName = com_db_GetValue("select concat(first_name,' ',last_name) from ".TABLE_USER." where user_id='".$res_id."'");
		$url = 'sub-thank-you.php?ragName='.$userName;
		
		com_redirect($url);
	}	
	
}




if($action == 'SubmitPaymentPrice'){
	$subscription_id = $_SESSION['sess_sub_choose'];
	$amount = com_db_GetValue("select amount from " . TABLE_SUBSCRIPTION . " where sub_id='".$subscription_id."'");
	$ch_name =explode(' ', $_POST['card_holder_name']);
	$first_name = com_db_input($ch_name[0]);
	$last_name = com_db_input($ch_name[sizeof($ch_name)-1]);
	
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
$firstName =urlencode( $ch_name[0]);
$lastName =urlencode( $ch_name[sizeof($ch_name)-1]);
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
$free_subscription_price = $_SESSION['sess_offer_price'];//com_db_GetValue("select amount from ".TABLE_FREE_SUBSCRIPTION_ONOFF." where sub_id=1");
$tAmt=$free_subscription_price;
$trialAmount = urlencode($tAmt);
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
$to_date_day = str_pad(date("d"), 2, '0', STR_PAD_LEFT);
$to_date_month = str_pad(date("m"), 2, '0', STR_PAD_LEFT);
$to_date_year = date("Y");
$trialStart = urlencode($to_date_year . '-' . $to_date_month . '-' . $to_date_day . 'T00:00:00Z'); 
$profileStartDate = urlencode($profileStartDateYear . '-' . $padprofileStartDateMonth . '-' . $padprofileStartDateDay . 'T00:00:00Z'); 

$tBillingPeriod = urlencode($_POST['billingPeriod']);
$tBillingFrequency = urlencode($_POST['billingFrequency']);
$tTotalBillingCycles = urlencode('1');
/* Construct the request string that will be sent to PayPal.
   The variable $nvpstr contains all the variables and is a 
   name value pair string with & as a delimiter */

$nvpstr="&PAYMENTACTION=$paymentType&AMT=$amount&TRIALTERM=$tTotalBillingCycles&TRIALAMT=$trialAmount&TRIALBILLINGPERIOD=$tBillingPeriod&TRIALBILLINGFREQUENCY=$tBillingFrequency&TRIALTOTALBILLINGCYCLES=$tTotalBillingCycles&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber&EXPDATE=". $padDateMonth.$expDateYear."&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName&STREET=$address1&CITY=$city&STATE=$state".
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
                <form name="frm_pay" method="post" action="card-info-incorrect-onedollar-price.php?action=DataRestore">
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
        <?
		
	}else{
		$user_session_id = com_session_id();
		//$transaction_id = $resArray['TRANSACTIONID'];
		$transaction_id = $resArray['PROFILEID'];
		$payment_query = "insert into " . TABLE_PAYMENT . " (payment_type,first_name,last_name,transaction_id,session_id,add_date) values ('Registration','$first_name','$last_name','$transaction_id','$user_session_id','$add_date')";
		com_db_query($payment_query);
		$payment_id = com_db_insert_id();
		
			
		$billing_query = "insert into " . TABLE_BILLING_ADDRESS . " (payment_id,company_name,address,address_cont,city,state,zip_code,country,session_id,add_date) values ('$payment_id','$company','$address','$address_cont','$city','$state','$zip_code','$country','$user_session_id','$add_date')";
		com_db_query($billing_query);
		
		
		$befor_reg_query = "insert into " . TABLE_PAYMENT_BEFOR_REG . " (session_id,payment_id,add_date) values ('$user_session_id','$payment_id','$add_date')";
		com_db_query($befor_reg_query);		
		
		
		$url = 'provide-contact-information-price.php?first_name='.$first_name.'&last_name='.$last_name;
		com_redirect($url);
	}
}

if($action =='ChoosePricing'){
	$choose_opt = $_POST['radio_sub_id'];
	$offer_price = $_POST['offer_price'];
	$referring_links = $_POST['referring_links'];
	session_register('sess_sub_choose');
	session_register('sess_offer_price');
	session_register('sess_referring_links');
	$_SESSION['sess_sub_choose'] = $choose_opt;
	$_SESSION['sess_offer_price'] = $offer_price;
	$_SESSION['sess_referring_links'] = $referring_links;
	if($choose_opt ==1){
		$url = "provide-contact-information-price.php";
	}else{
		$url = "submit-1dollar-price-payment.php";
	}	
	com_redirect($url);
}
?>