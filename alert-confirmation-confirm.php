<?php
include("includes/include-top.php");
$alert_id=$_REQUEST['alt_id'];
include(DIR_INCLUDES."header.php");
?>	 
    <!-- heading start -->
    <tr>
      <td align="left"  valign="top">&nbsp;</td>
      <td align="left" valign="top"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">

   <tr>
      <td align="left" valign="top"><img src="images/specer.gif" width="1" height="10" alt="" title="" /></td>
      </tr>
      <tr>
      <td align="left" valign="middle" class="registration-page-heading-bg"><table width="960" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="left" valign="middle" class="registration-page-title-text">ALERT CONFIRMATION</td>
        </tr>
      </table></td>
      </tr>

      </table></td>
      <td align="left"  valign="top">&nbsp;</td>
    </tr>
    <!-- heading end -->
    <!-- content start -->
   <tr>
    <td width="21" align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top" bgcolor="#f9fcff"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top"><table width="675" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
       <td align="left" valign="top"><img src="images/specer.gif" width="1" height="100" alt="" title="" /></td>
      </tr>
      <tr>
        <td align="left" valign="top" class="alert-confirmation-box-text"><p>
		  Your credit card on file will be charged a set up fee of $45 and up to <?=$_POST['amount'];?> amount per month for qualified alerts
		  </p>          </td>
      </tr>
      <tr>
        <td align="center" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" valign="top">
		<form name="frmAlertPayment" id="frmAlertPayment" method="post" action="alert-pro.php?action=SubmitAlertPayment&alt_id=<?=$alert_id;?>">
		<table width="371" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="148" align="left" valign="top">&nbsp;
				<input type="hidden" name="first_name" value="<?=$_POST['first_name'];?>" />
                <input type="hidden" name="last_name" value="<?=$_POST['last_name'];?>" />
                <input type="hidden" name="card_type" value="<?=$_POST['card_type'];?>" />
                <input type="hidden" name="card_num" value="<?=$_POST['card_num'];?>" />
                <input type="hidden" name="exp_month" value="<?=$_POST['exp_month'];?>" />
                <input type="hidden" name="exp_year" value="<?=$_POST['exp_year'];?>" />
                <input type="hidden" name="security_code" value="<?=$_POST['security_code'];?>" />
				
				<input type="hidden" name="profileDesc" value="<?=$_POST['profileDesc'];?>" />
				<input type="hidden" name="billingPeriod" value="<?=$_POST['billingPeriod'];?>" />
				<input type="hidden" name="billingFrequency" value="<?=$_POST['billingFrequency'];?>" />
				<input type="hidden" name="totalBillingCycles" value="<?=$_POST['totalBillingCycles'];?>" />
				<input type="hidden" name="startDate" value="<?=date('d/m/Y');?>" />
                
                <input type="hidden" name="company" value="<?=$_POST['company'];?>" />
                <input type="hidden" name="address" value="<?=$_POST['address'];?>" />
                <input type="hidden" name="address_cont" value="<?=$_POST['address_cont'];?>" />
                <input type="hidden" name="city" value="<?=$_POST['city'];?>" />
                <input type="hidden" name="state" value="<?=$_POST['state'];?>" />
                <input type="hidden" name="zip_code" value="<?=$_POST['zip_code'];?>" />
                <input type="hidden" name="country" value="<?=$_POST['country'];?>" />
				<input type="hidden" name="amount" value="<?=$_POST['amount'];?>" />
			</td>
            <td width="106" align="left" valign="top"><table width="106" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="center" valign="top" class="more_bottom"><a href="javascript:FormValueSubmit('frmAlertPayment');">Confirm</a></td>
                </tr>
                <tr>
                  <td align="center" valign="top"><img src="images/more-buttn-bottom.jpg" width="106" height="27" alt="" title="" /></td>
                </tr>
            </table></td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
        </table>
		</form>
		</td>
      </tr>
    <tr>
        <td align="left" valign="top">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table></td>
    <td width="21" align="left" valign="top">&nbsp;</td>
  </tr>
    <!-- content end-->
   <!-- footer link start -->
<?php include(DIR_INCLUDES."footer-link.php");?>
   <!-- footer link end -->
<?php      
include(DIR_INCLUDES."footer.php");
?>