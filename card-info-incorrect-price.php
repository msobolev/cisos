<?php
include("includes/include-top.php");
$action = $_REQUEST['action'];
if($action == 'DataRestore'){
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$email = $_POST['email'];
	$card_type =$_POST['card_type'];
	$card_num = com_db_input($_POST['card_num']);
	$exp_month = $_POST['exp_month'];
	$exp_year = $_POST['exp_year'];
	$security_code = $_POST['security_code'];
	
	$company = $_POST['company'];
	$address = $_POST['address'];
	$address_cont = $_POST['address_cont'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$zip_code = $_POST['zip_code'];
}
include(DIR_INCLUDES."header-content-page.php");
?>	 
    <!-- heading start -->
 <div style="margin:0 auto; width:960px;">
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	 <tr>
        <td colspan="2" align="left" valign="top" class="caption-text">
		<?=com_db_GetValue("select page_content from " .TABLE_PAGE_CONTENT . " where page_name='index.php' and page_title='Page Heading'")?>
		</td>
    </tr>
    <tr><td colspan="2">&nbsp;</td></tr>
    <!-- content start -->
   <tr>
    <td width="21" align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top"  class="registration-page-bg">
		<form name="frmCardInfo" id="frmCardInfo" method="post" action="submit-price-payment.php?action=DataRestore">
		<table width="775" border="0" align="center" cellpadding="0" cellspacing="0">
		  <tr>
			<td align="left" valign="top"><img src="images/specer.gif" width="1" height="50" alt="" title="" /> </td>
		  </tr>
		  <tr>
			<td align="left" valign="top" class="alert-confirmation-box-text"><p>You credit card information could not be validated, please check <br />
			  and correct the credit card details you provided and submit again.</p>            </td>
		  </tr>
		  <tr>
			<td align="center" valign="top">&nbsp;</td>
		  </tr>
		  <tr>
			<td align="center" valign="top">&nbsp;</td>
		  </tr>
		  <tr>
			<td align="center" valign="top">&nbsp;</td>
		  </tr>
		  <tr>
			<td align="center" valign="top"><table width="371" border="0" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="148" align="left" valign="top">
                	<input type="hidden" name="email" value="<?=$email?>" />
					<input type="hidden" name="first_name" value="<?=$first_name?>" />
					<input type="hidden" name="last_name" value="<?=$last_name?>" />
					<input type="hidden" name="card_type" value="<?=$card_type?>" />
					<input type="hidden" name="card_num" value="<?=$card_num?>" />
					<input type="hidden" name="exp_month" value="<?=$exp_month?>" />
					<input type="hidden" name="exp_year" value="<?=$exp_year?>" />
					<input type="hidden" name="security_code" value="<?=$security_code?>" />
					
					<input type="hidden" name="company" value="<?=$company?>" />
					<input type="hidden" name="address" value="<?=$address?>" />
					<input type="hidden" name="address_cont" value="<?=$address_cont?>" />
					<input type="hidden" name="city" value="<?=$city?>" />
					<input type="hidden" name="state" value="<?=$state?>" />
					<input type="hidden" name="zip_code" value="<?=$zip_code?>" />
				</td>
			   <td width="106" align="left" valign="top">
			   		<table width="106" border="0" align="center" cellpadding="0" cellspacing="0">
						  <tr>
							<td align="center" valign="top" class="more_bottom"><a href="javascript:FormValueSubmit('frmCardInfo');"><img src="images/white-back-arrow.gif" width="12" height="9" alt=""  title="" border="0"/>&nbsp;Back</a></td>
						  </tr>
						  <tr>
							<td align="center" valign="top"><img src="images/more-buttn-bottom.jpg" width="106" height="27" alt="" title="" /></td>
						  </tr>
					</table>
				</td>
				<td align="left" valign="top">&nbsp;</td>
			  </tr>
			</table></td>
		  </tr>
		  <tr>
			<td align="center" valign="top">&nbsp;</td>
		  </tr>
		</table>
		</form>
	</td>
  </tr>
</table></td>
    <td width="21" align="left" valign="top">&nbsp;</td>
  </tr>
</table>
    </div>
    <!-- content end-->
<?php      
include(DIR_INCLUDES."footer-content-page.php");
?>