<?php
include("includes/include-top.php");
$email_id = $_REQUEST['emailid'];
$alert_email_content = com_db_output(com_db_GetValue("select email_details from " . TABLE_DEMO_SUMMARY_EMAIL_INFO . " where email_id='".$email_id."'"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=320, initial-scale=1" />
	<meta content="telephone=no" name="format-detection" />
	<title>Email Alert Details</title>
	

	<style type="text/css" media="screen">
		/* Linked Styles */
		body { padding:0 !important; margin:0 !important; display:block !important; background:#eaeaea; -webkit-text-size-adjust:none }
		a { color:#4f81bd; text-decoration:none }
		.footer a { color:#adadad; text-decoration:none }

		/* Mobile styles */
		@media only screen and (max-device-width: 480px) { 
			div[class="h2"] { font-size:14px; }
			div[class='mobile-br-15'] { height: 15px !important; }
			div[class='mobile-br-25'] { height: 25px !important; }
			div[class='mobile-br-30'] { height: 30px !important; }
			table[class='w320'] { width: 320px !important; }
			div[class='top'] { text-align: right !important; }
			td[class='column'] { float: left !important; display: block !important; width: 320px !important; }
			td[class='column2'] { float: left !important; display: block !important; width: 310px !important; }
			td[class='col-300'] { float: left !important; display: block !important; width: 300px !important; }
			td[class='shadow'], td[class='spacing'] { display: none !important; width: 0 !important; height: 0 !important; }
			div[class='hide-for-mobile'] { display: none !important; width: 0 !important; height: 0 !important; font-size: 0 !important; line-height: 0 !important; }
			td[class='text'] { font-size: 10px !important; line-height: 14px !important; }
			td[class='links'] { font-size: 10px !important; line-height: 14px !important; }
			td[class='btn'] { font-size: 10px !important; line-height: 14px !important; }
			td[class='btn-container'] { width: 80px !important; }
			td[class='mobile-space'] { width: 10px !important; }
			td[class='img-holder'] { width: 90px !important; }
			td[class='footer'] { padding: 0 10px  !important; }
		} 
	</style>
</head>
<body class="body" style="padding:0 !important; margin:0 !important; display:block !important; background:#eaeaea; -webkit-text-size-adjust:none">
<?
if($alert_email_content ==''){
	?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#eaeaea">
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        
        <tr>
            <td align="center" valign="top" style="color:#00C;font-size:24px;">Your email alert not Available</td>
        </tr>
    </table>    
    <?
}else{
	echo $alert_email_content;
}
?>

</body>
</html>