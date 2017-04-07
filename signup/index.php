<?php
require('../includes/configuration.php');
include('../includes/only_signup_include-top.php');
$page_content = com_db_output(com_db_GetValue("select page_content from " . TABLE_PAGE_CONTENT . " where page_name='".$current_page."'"));
include(DIR_INCLUDES."header.php");
?>	
<!-- heading start --> 
<tr>
      <td align="left"  valign="top">&nbsp;</td>
      <td align="left" valign="top"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
	       <tr>
        <td align="left" valign="top" class="header-nav"><a href="index.php">Home</a>  /  <a href="../provide-contact-information.php" class="active">Signup / Subscription</a></td>
      </tr>
   <tr>
      <td align="left" valign="top"><img src="images/specer.gif" width="1" height="10" alt="" title="" /></td>
      </tr>
      <tr>
      <td align="left" valign="middle" class="registration-page-heading-bg"><table width="960" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="left" valign="middle" class="registration-page-title-text">Subscription</td>
        </tr>
      </table></td>
      </tr>
	    <tr>
      <td align="left" valign="top" class="registration-page-bg"><img src="../images/blue-down-arrow.jpg" width="235" height="13"  alt="" title="" /></td>
      </tr>
      </table></td>
      <td align="left"  valign="top">&nbsp;</td>
    </tr>
	<!-- heading end -->
    <!-- content start -->
	
	<tr>
      <td align="left"  valign="top">&nbsp;</td>
      <td align="center" valign="top" class="registration-page-bg"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td align="center" valign="top">
		   <table width="928" border="0" align="center" cellpadding="0" cellspacing="0">
			  <tr>
			   <td align="left" valign="top">
			   
			   <div>
			   		<form action="https://authorize.payments.amazon.com/pba/paypipeline" method="post">
					<input type="hidden" name="immediateReturn" value="1" >
					<input type="hidden" name="collectShippingAddress" value="0" >
					<input type="hidden" name="signatureVersion" value="2" >
					<input type="hidden" name="signatureMethod" value="HmacSHA256" >
					<input type="hidden" name="accessKey" value="11SEM03K88SD016FS1G2" >
					<input type="hidden" name="recurringFrequency" value="1 month" >
					<input type="hidden" name="amount" value="USD 85" >
					<input type="hidden" name="signature" value="ZlJoqNeBjlin9JVEEjwPeqebpPrvySbRPRdLUdo1ryU=" >
					<input type="hidden" name="description" value="CTOsOnTheMove - Monthly Subscription" >
					<input type="hidden" name="amazonPaymentsAccountId" value="FCYAQIKAFZBL51Z4EEUHAKKJ46J66A6Q6CUSFN" >
					<input type="hidden" name="ipnUrl" value="http://ctosonthemove.com" >
					<input type="hidden" name="returnUrl" value="http://ctosonthemove.com" >
					<input type="hidden" name="processImmediate" value="0" >
					<input type="hidden" name="cobrandingStyle" value="logo" >
					<input type="hidden" name="abandonUrl" value="http://ctosonthemove.com" >
					<input type="image" src="http://g-ecx.images-amazon.com/images/G/01/asp/golden_small_subscribe_withlogo_whitebg.gif" border="0">
					</form>
			   </div>
			   <p align="left"><b>Subscribe now for $85 / month and get unlimited searching, browsing and downloading access to the online database of unique and responsive sales leads - CTOs, CIOs and other senior IT decision makers who recently changed jobs.</b></p>
			   <p align="left"><b>The subscription is monthly, and you can cancel your subscription any time, no questions asked.</b></p>
  			   <p align="left"><b>Subscribe now and by clicking the button on the left and connect with your potential customers today.</b></p>
			   <br/>
				
			   
			   </td>
			  </tr>
		   </table>
		 </td>
        </tr>
        <tr>
          <td align="center" valign="top"><img src="../images/registration-page-bottom-bg.jpg" width="960" height="11" alt="" title="" /></td>
        </tr>
      </table></td>
      <td align="left"  valign="top">&nbsp;</td>
    </tr>
 <!-- content end-->
   <!-- footer link start -->
<?php include(DIR_INCLUDES."footer-link.php");?>
   <!-- footer link end -->
<?php      
include(DIR_INCLUDES."footer.php");	
?>