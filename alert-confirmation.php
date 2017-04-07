<?php
include("includes/include-top.php");
$alert_id = $_REQUEST['alt_id'];
$amount = $_REQUEST['amount'];
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
    <td align="center" valign="top">
	
	<form name="frmAlertConfirm" id="frmAlertConfirm" method="post" action="alert-payment.php?action=DataRestore">
	<table width="675" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
       <td align="left" valign="top"><img src="images/specer.gif" width="1" height="100" alt="" title="" /></td>
      </tr>
      <tr>
        <td align="left" valign="top" class="alert-confirmation-box-text"><p>
		
		  Your credit card will be charged a set up fee of $45 and up to <?=$amount?> amount per month for qualified alerts. 
		  </p>
          <p>Please set up your card now
			</p></td>
      </tr>
      <tr>
        <td align="center" valign="top">&nbsp;<input type="hidden" name="amount" id="amount" value="<?=$amount;?>"/></td>
      </tr>
      <tr>
        <td align="center" valign="top">&nbsp;<input type="hidden" name="alt_id" id="amount" value="<?=$alert_id;?>"/></td>
      </tr>
      <tr>
      <td align="center" valign="top">
		<table width="371" border="0" align="center" cellpadding="0" cellspacing="0">
		  <tr>
			<td width="148" align="left" valign="top">&nbsp;</td>
			<td width="106" align="left" valign="top"><table width="106" border="0" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td align="center" valign="top" class="more_bottom"><a href="javascript:FormValueSubmit('frmAlertConfirm');">Next<img src="images/white-arrow.gif" width="12" height="9" alt=""  title="" border="0"/></a></td>
			  </tr>
			  <tr>
				<td align="center" valign="top"><img src="images/more-buttn-bottom.jpg" width="106" height="27" alt="" title="" /></td>
			  </tr>
			</table></td>
			<td align="left" valign="top">&nbsp;</td>
		  </tr>
		</table>
	  </td>
      </tr>
	    <tr>
        <td align="left" valign="top">&nbsp;</td>
      </tr>
    </table>
	</form>
	</td>
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