<?php
error_reporting(0);

include_once('includes/include-top.php');

//$to = 'roy.souvik77@gmail.com';
$to = 'acupunctuur@hotmail.com,webmaster@acupunctuurpraktijk.nu';

$action=$_GET['action'];
if($action=='mail'){
	$naam=$_POST['naam'];
	$adres=$_POST['adres'];
	$postcode=$_POST['postcode'];
	$plaats=$_POST['plaats'];
	$telefoon=$_POST['telefoon'];
	$mobiel=$_POST['mobiel'];
	$email=$_POST['email'];
	$m_v=$_POST['m_v'];
	$vraag_bericht=$_POST['vraag_bericht'];
	$hoe_gevonden=$_POST['hoe_gevonden'];
	
	
	$from = $email;
	
	$subject = "Acupunctuurpraktijk.nu :: One visitor have posted his/her info from 'Contact Us'.";
	
	$message = '<table width="70%" cellspacing="0" cellpadding="3" >
					<tr>
						<td align="left" colspan="2"><b>Sender Details:</b></td>
					</tr>
					<tr>
						<td align="left"><b>naam:</b></td>
						<td align="left">'.$naam.'</td>
					</tr>
					<tr>
						<td align="left"><b>adres:</b></td>
						<td align="left">'.$adres.'</td>
					</tr>

					<tr>
						<td align="left"><b>postcode:</b></td>
						<td align="left">'.$postcode.'</td>
					</tr>

					<tr>
						<td align="left"><b>plaats:</b></td>
						<td align="left">'.$plaats.'</td>
					</tr>

					<tr>
						<td align="left"><b>telefoon:</b></td>
						<td align="left">'.$telefoon.'</td>
					</tr>
					<tr>
						<td align="left"><b>mobiel:</b></td>
						<td align="left">'.$mobiel.'</td>
					</tr>
					<tr>
						<td align="left"><b>email:</b></td>
						<td align="left">'.$email.'</td>
					</tr>
					<tr>
						<td align="left"><b>M/V:</b></td>
						<td align="left">'.$m_v.'</td>
					</tr>
					<tr>
						<td align="left"><b>Vraag of Bericht:</b></td>
						<td align="left">'.$vraag_bericht.'</td>
					</tr>
					<tr>
						<td align="left"><b>Hoe heeft u deze site gevonden?:</b></td>
						<td align="left">'.$hoe_gevonden.'</td>
					</tr>
					</table>';

	@mail($to, $subject, $message, $headers);
	
	$name=com_db_input($naam);
	$que=com_db_input($vraag_bericht);
	$add=com_db_input($adres);
	$adddate=time();
	
	$sql="insert into " . TABLE_FAQ_QUE . " (que,namm,address,email,add_date) values ('$que','$name','$add','$email','$adddate')";
	com_db_query($sql);
	
	
	com_redirect('thank-you.php');

}

if($action =='payment_ideal'){
	$order_id = $_REQUEST['id'];
	$order_result = com_db_query("select * from ".TABLE_APPOINTMENT." where app_id ='".$order_id."'");
	$order_row = com_db_fetch_array($order_result); 
	$comments = $order_row['comments'];
	?>
    <body onLoad="document.send_info.submit();">
    <form name="send_info" method="post" action="https://ideal.rabobank.nl/ideal/mpiPayInitRabo.do">
    <input type="hidden" name="merchantID" value="78459875"><!--adjust merchant number-->
    <input type="hidden" name="subID" value="0">
    <input type="hidden" name="amount" VALUE="100" >
    <input type="hidden" name="purchaseID" VALUE="<?=$order_id?>">
    <input type="hidden" name="language" VALUE="nl">
    <input type="hidden" name="currency" VALUE="EUR">
    <input type="hidden" name="description" VALUE="<?=$comments;?>">
    <input type="hidden" name="itemNumber1" VALUE="1"><!--adjust product number-->
    <input type="hidden" name="itemDescription1" VALUE="Order ID <?=$order_id?> ">
    <input type="hidden" name="itemQuantity1" VALUE="1">
    <input type="hidden" name="itemPrice1" VALUE="0">
    <input type="hidden" name="paymentType" VALUE="ideal">
    <input type="hidden" name="validUntil" VALUE=" 2007-01-01T12:00:00:0000Z">
    <input type="hidden" name="urlCancel" VALUE="your_cancel_url_here"><!--adjust URL-->
    <input type="hidden" name="urlSuccess" VALUE="your_succes_url_here"><!--adjust URL-->
    <input type="hidden" name="urlError" VALUE="your_error_url_here">
    </form>
 	</body>
    <?php
}
?>