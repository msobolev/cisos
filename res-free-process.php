<?php
include("includes/include-top.php");
$action = $_GET['action'];
$res_id = $_REQUEST['res_id'];
$free = $_REQUEST['free'];
if($action == 'SubmitPaymentFreeRacaring'){
	$subscription_id = 3;
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
	$email = com_db_input($_POST['email']);
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
$user_email = urlencode($_POST['email']);
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
                <form name="frm_pay" method="post" action="card-info-incorrect-free.php?action=DataRestore&res_id=<?=$res_id?>">
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
                <input type="hidden" name="email" value="<?=$email?>" />
                <input type="hidden" name="free" value="<?=$free?>" />
                </form>
                <script type="text/javascript" language="javascript">
                document.frm_pay.submit();
                </script>
            </body>
        </html>
        <?
		
	}else{
		$user_id = $res_id;
		//$transaction_id = $resArray['TRANSACTIONID'];
		$transaction_id = $resArray['PROFILEID'];
		$payment_query = "insert into " . TABLE_PAYMENT . " (payment_type,user_id,first_name,last_name,transaction_id,add_date) values ('Registration','$user_id','$first_name','$last_name','$transaction_id','$add_date')";
		com_db_query($payment_query);
		$payment_id = com_db_insert_id();
			
		$billing_query = "insert into " . TABLE_BILLING_ADDRESS . " (payment_id,user_id,company_name,address,address_cont,city,state,zip_code,country,add_date) values ('$payment_id','$user_id','$company','$address','$address_cont','$city','$state','$zip_code','$country','$add_date')";
		com_db_query($billing_query);
		
		$user_subscription_update = "update ".TABLE_USER." set subscription_id='".$subscription_id."',level='Paid', payment_by='User', status='0' where user_id='".$res_id."'";
		com_db_query($user_subscription_update);		
		
		$url = 'sub-thank-you.php?ragName='.$first_name.' '.$last_name;
		com_redirect($url);
	}
}

?>