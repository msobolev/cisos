<?php
/*************************************************
APIError.php

Displays error parameters.

Called by DoDirectPaymentReceipt.php, TransactionDetails.php,
GetExpressCheckoutDetails.php and DoExpressCheckoutPayment.php.

*************************************************/

session_start();
$resArray=$_SESSION['reshash']; 
?>

<html>
<head>
<title>PayPal PHP API Response</title>
<link href="sdk.css" rel="stylesheet" type="text/css"/>
</head>

<body alink=#0000FF vlink=#0000FF>

<center>

<table width="700">
<tr>
		<td colspan="2" class="header">The PayPal API has returned an error!</td>
	</tr>

<?php  //it will print if any URL errors 
	if(isset($_SESSION['curl_error_no'])) { 
			$errorCode= $_SESSION['curl_error_no'] ;
			$errorMessage=$_SESSION['curl_error_msg'] ;	
			session_unset();	
?>

   
<tr>
		<td>Error Number:</td>
		<td><?= $errorCode ?></td>
	</tr>
	<tr>
		<td>Error Message:</td>
		<td><?= $errorMessage ?></td>
	</tr>
	
	</center>
	</table>
<?php } else {

/* If there is no URL Errors, Construct the HTML page with 
   Response Error parameters.   
   */
?>

		<td>Ack:</td>
		<td><?= $resArray['ACK'] ?></td>
	</tr>
	<tr>
		<td>Correlation ID:</td>
		<td><?= $resArray['CORRELATIONID'] ?></td>
	</tr>
	<tr>
		<td>Version:</td>
		<td><?= $resArray['VERSION']?></td>
	</tr>
<?php
	$count=0;
	while (isset($resArray["L_SHORTMESSAGE".$count])) {		
		  $errorCode    = $resArray["L_ERRORCODE".$count];
		  $shortMessage = $resArray["L_SHORTMESSAGE".$count];
		  $longMessage  = $resArray["L_LONGMESSAGE".$count]; 
		  $count=$count+1; 
?>
	<tr>
		<td>Error Number:</td>
		<td><?= $errorCode ?></td>
	</tr>
	<tr>
		<td>Short Message:</td>
		<td><?= $shortMessage ?></td>
	</tr>
	<tr>
		<td>Long Message:</td>
		<td><?= $longMessage ?></td>
	</tr>
	
<?php }//end while
}// end else
?>
</center>
	</table>
<br>
<a class="home"  id="CallsLink" href="index.html"><font color=blue><B>Home<B><font></a>
</body>
</html>

