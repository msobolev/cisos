<?php
include("includes/include-top.php");

$subscription_id = $_SESSION['sess_sub_choose'];
$amount = com_db_GetValue("select amount from " . TABLE_SUBSCRIPTION . " where sub_id='".$subscription_id."'");
$email = msg_encode($_REQUEST['email']);
$password = msg_encode($_REQUEST['pass']);
if($subscription_id==''){
	$url = "pricing.html";
	com_redirect($url);
}
?>
<html>
  <body style="text-align:center;">
  	<p>&nbsp;</p>
    <img src="images/loading.gif" alt="" title="">
  	<p><h2>Redirecting you to PayPal site now. Please wait...</h2></p>
    
        <form name="frmPayPalProcess"action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post"> <!-- testing https://www.sandbox.paypal.com/cgi-bin/webscr   Live https://www.paypal.com/cgi-bin/webscr-->
            <input type="hidden" name="business" value="ananga_1275462143_biz@gmail.com"><!-- testing ananga_1275462143_biz@gmail.com   Live Mike_Sobolev@yahoo.com-->
            <input type="hidden" name="return" value="<?=HTTP_SERVER.DIR_WS_HTTP_FOLDER;?>subpaypal_1dollar.php?action=success&amp;ss_id=<?=com_session_id();?>">
            <input type="hidden" name="cancel_return" value="<?=HTTP_SERVER.DIR_WS_HTTP_FOLDER;?>subpaypal_1dollar.php?action=cancel">
            <input type="hidden" name="notify_url" value="<?=HTTP_SERVER.DIR_WS_HTTP_FOLDER;?>subpaypal_1dollar.php?action=ipn&amp;ss_id=<?=com_session_id();?>">
            <input type="hidden" name="item_name" value="CTOsOnTheMove - Subscription">
            <input type="hidden" name="rm" value="2">
            <input type="hidden" name="cmd" value="_xclick-subscriptions">
            <input type="hidden" name="a1" value="<?=$_SESSION['sess_offer_price']?>">
            <input type="hidden" name="p1" value="1">
            <input type="hidden" name="t1" value="M">
            <input type="hidden" name="a3" value="<?=$amount;?>">
            <input type="hidden" name="p3" value="1">
            <input type="hidden" name="t3" value="M">
            <input type="hidden" name="src" value="1"> <!-- recurring=yes -->
            <input type="hidden" name="sra" value="1"> <!-- reattempt=yes -->
            <input type="hidden" name="currency_code" value="USD">
        </form>
        <script type="text/javascript" language="javascript">
            document.frmPayPalProcess.submit();
        </script>
   </body>
 </html>