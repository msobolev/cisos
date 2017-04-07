<?php
include("includes/include-top.php");
$action = $_REQUEST['action'];
$alert_id = $_REQUEST['alt_id'];
if($action == 'DataRestore'){
	$amount = $_REQUEST['amount'];
	
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	
	$card_type =$_POST['card_type'];
	$card_num = $_POST['card_num'];
	$exp_month = $_POST['exp_month'];
	$exp_year = $_POST['exp_year'];
	$security_code = $_POST['security_code'];
	
	$company = $_POST['company'];
	$address = $_POST['address'];
	$address_cont = $_POST['address_cont'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$zip_code = $_POST['zip_code'];
	$country = $_POST['country'];
}
include(DIR_INCLUDES."header.php");
?>	 
    <!-- heading start -->
    <tr>
      <td align="left"  valign="top">&nbsp;</td>
            <td align="left" valign="middle"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td align="left" valign="top" class="header-nav"><a href="<?=HTTP_SERVER?>index.php">Home</a> / <a href="#" class="active">Payment</a></td>
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
                      <td align="left" valign="middle" class="registration-page-title-text">Payment</td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top" class="registration-page-bg"><img src="images/blue-down-arrow.jpg" width="235" height="13"  alt="" title="" /></td>
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
		   <script type="text/javascript" src="selectuser.js" language="javascript"></script>
		  	<form name="frmSubmitPay" id="frmSubmitPay" method="post" action="alert-pro.php?action=SubmitAlertPayment&alt_id=<?=$alert_id?>">
			  <table width="850" border="0" align="center" cellpadding="0" cellspacing="0">
	
				<tr>
				  <td align="center" valign="top"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr>
						<td align="left" valign="top" class="submit-payment-content-heading-text">Name on the Card:</td>
					  </tr>
				  </table></td>
				</tr>
				<tr>
				 <td align="left" valign="top"><img src="images/specer.gif" width="1" height="5" alt="" title="" /></td>
				</tr>
				<tr>
				  <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="4" cellspacing="0">
					  <tr>
						<td height="27" align="left" valign="middle" class="list-field-text">First Name: </td>
						<td align="left" valign="middle"><input name="first_name" type="text" id="first_name"  value="<?=$first_name;?>" size="46" class="list-field" onfocus="AllComboDivClosePayment('');fieldHighlight('first_name');" onblur="fieldLosslight('first_name');"/></td>
					  </tr>
					  <tr>
						<td width="245" align="left" valign="middle" class="list-field-text">Last Name: </td>
						<td width="245" align="left" valign="middle"><input name="last_name" type="text" id="last_name" value="<?=$last_name;?>" size="46" class="list-field" onfocus="AllComboDivClosePayment('');fieldHighlight('last_name');" onblur="fieldLosslight('last_name');"/></td>
					  </tr>
				  </table></td>
				</tr>
				<tr>
				 <td align="left" valign="top"><img src="images/specer.gif" width="1" height="5" alt="" title="" /></td>
				</tr>
				<tr>
				  <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr>
						<td align="left" valign="top" class="submit-payment-content-heading-text">Credit Card Info:</td>
					  </tr>
				  </table>
				  <input type="hidden" name="amount" id="amount" value="<?=$amount;?>" />
				  </td>
				</tr>
				<tr>
				  <td align="left" valign="top"><img src="images/specer.gif" width="1" height="5" alt="" title="" /></td>
				</tr>
				<tr>
				  <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="4" cellspacing="0">
					  <tr>
						<td height="27" align="left" valign="middle" class="list-field-text">Card Type:</td>
						<td align="left" valign="top">
								   
						<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" class="my_div">
							<tr>
							  <td valign="top">
									<input type="text" name="card_type" id="card_type" class="text-new-227" style="margin-top:0px; border:0px solid #000000; color:#737373;" onfocus="fieldHighlightCombo('card_type');MyCombo_Open('div_card_type');AllComboDivClosePayment('div_card_type');" size="34" value="<?=$card_type?>" onblur="fieldLosslightCombo('card_type')"/>
									<img src="images/down.png" align="right" width="20" height="20" onclick="MyCombo_Open('div_card_type');"/>								</td>
							</tr>
							<tr>
								<td valign="top">
									<div id="div_card_type" class="inner" style="display:none; position:absolute;">
										<a href="javascript:TextboxValueChange('card_type','div_card_type','Visa');">Visa</a><br />
										<a href="javascript:TextboxValueChange('card_type','div_card_type','MasterCard');">MasterCard</a><br />
										<a href="javascript:TextboxValueChange('card_type','div_card_type','Discover');">Discover</a><br />
										<a href="javascript:TextboxValueChange('card_type','div_card_type','Amex');">Amex</a><br />
									</div>
								</td>
							</tr>
						</table>
						</td>
					  </tr>
					  <tr>
						<td align="left" valign="middle" class="list-field-text">Card Number:</td>
						<td align="left" valign="middle"><input name="card_num" type="text" id="card_num" value="<?=$card_num;?>"  size="46" class="list-field" onfocus="AllComboDivClosePayment('');fieldHighlight('card_num');" onblur="fieldLosslight('card_num');"/></td>
					  </tr>
					  <tr>
						<td align="left" valign="middle" class="list-field-text">Expiration:</td>
						<td align="left" valign="middle"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
						  <tr>
							<td height="27" align="left" valign="top">								       
							<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" class="my_div_small">
							<tr>
							  <td valign="top">
									<input type="text" name="exp_month" id="exp_month" class="text-new-100" value="<?=$exp_month;?>" style="margin-top:0px; border:0px solid #000000; color:#737373;" onfocus="MyCombo_Open('div_exp_month');fieldHighlightCombo2('exp_month');" onblur="fieldLosslightCombo2('exp_month');" size="13"/>
									<img src="images/down.png" align="right" width="20" height="20" onclick="MyCombo_Open('div_exp_month');"/></td>
							</tr>
							<tr>
								<td valign="top">
									<div id="div_exp_month" class="middle" style="display:none; position:absolute;">
										<a href="javascript:TextboxValueChange('exp_month','div_exp_month','01');">01</a><br />
										<a href="javascript:TextboxValueChange('exp_month','div_exp_month','02');">02</a><br />
										<a href="javascript:TextboxValueChange('exp_month','div_exp_month','03');">03</a><br />
										<a href="javascript:TextboxValueChange('exp_month','div_exp_month','04');">04</a><br />
										<a href="javascript:TextboxValueChange('exp_month','div_exp_month','05');">05</a><br />
										<a href="javascript:TextboxValueChange('exp_month','div_exp_month','06');">06</a><br />
										<a href="javascript:TextboxValueChange('exp_month','div_exp_month','07');">07</a><br />
										<a href="javascript:TextboxValueChange('exp_month','div_exp_month','08');">08</a><br />
										<a href="javascript:TextboxValueChange('exp_month','div_exp_month','09');">09</a><br />
										<a href="javascript:TextboxValueChange('exp_month','div_exp_month','10');">10</a><br />
										<a href="javascript:TextboxValueChange('exp_month','div_exp_month','11');">11</a><br />
										<a href="javascript:TextboxValueChange('exp_month','div_exp_month','12');">12</a><br />
									</div>								
									</td>
							</tr>
						</table>
							<br />	 
							</td>
							<td height="27" align="left" valign="top">						       
							
							<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" class="my_div_small">
								<tr>
								  <td valign="top">
										<input type="text" name="exp_year" id="exp_year" class="text-new-100"  value="<?=$exp_year;?>" style="margin-top:0px; border:0px solid #000000; color:#737373;" onfocus="MyCombo_Open('div_exp_year');fieldHighlightCombo2('exp_year');" onblur="fieldLosslightCombo2('exp_year');" size="13"/>
										<img src="images/down.png" align="right" width="20" height="20" onclick="MyCombo_Open('div_exp_year');"/></td>
								</tr>
								<tr>
									<td valign="top">
										<div id="div_exp_year" class="middle" style="display:none; position:absolute;">
											<a href="javascript:TextboxValueChange('exp_year','div_exp_year','2010');">2010</a><br />
											<a href="javascript:TextboxValueChange('exp_year','div_exp_year','2011');">2011</a><br />
											<a href="javascript:TextboxValueChange('exp_year','div_exp_year','2012');">2012</a><br />
											<a href="javascript:TextboxValueChange('exp_year','div_exp_year','2013');">2013</a><br />
											<a href="javascript:TextboxValueChange('exp_year','div_exp_year','2014');">2014</a><br />
											<a href="javascript:TextboxValueChange('exp_year','div_exp_year','2015');">2015</a><br />
											<a href="javascript:TextboxValueChange('exp_year','div_exp_year','2016');">2016</a><br />
											<a href="javascript:TextboxValueChange('exp_year','div_exp_year','2017');">2017</a><br />
											<a href="javascript:TextboxValueChange('exp_year','div_exp_year','2018');">2018</a><br />
											<a href="javascript:TextboxValueChange('exp_year','div_exp_year','2019');">2019</a><br />
											<a href="javascript:TextboxValueChange('exp_year','div_exp_year','2020');">2020</a><br />
											
										</div>								
									</td>
								</tr>
							</table>
							<br />
							</td>
						  </tr>
						</table></td>
					  </tr>
			 
					  <tr>
						<td width="245" align="left" valign="middle" class="list-field-text">Card Security Code:</td>
						<td width="245" align="left" valign="middle"><table width="245" border="0" cellspacing="0" cellpadding="0">
							<tr>
							  <td width="178"><input name="security_code" type="text" id="security_code" value="<?=$security_code;?>" size="35" class="list-field3"  onfocus="AllComboDivClosePayment('');fieldHighlightCombo1('security_code');" onblur="fieldLosslightCombo1('security_code');"/></td>
							  <td width="67">
							  	<a href="javascript://" onmouseover="question_mark_show('scode_alert');" onmouseout="question_mark_close('scode_alert');">
								<img src="images/yellow-questionmark-icon.gif" width="30" height="29"  alt="" title="" border="0" />
								</a>
								
								<div id="scode_alert" style="display:none; position:absolute; width:230px;">
									<table width="235" border="0" align="center" cellpadding="0" cellspacing="0">
									  <tr>
										<td align="center" valign="top" class="help-popup-bg-payment"><table width="195" border="0" align="center" cellpadding="0" cellspacing="0">
										  <tr>
											<td align="left" valign="top"><img src="images/specer.gif" width="1" height="5" alt="" title="" /></td>
										  </tr>
										  <tr>
											<td align="left" valign="middle"  class="help-popup-text">A three digit code on the back of your card</td>
										  </tr>
									  
										</table></td>
									  </tr>
									
									</table>
						
								</div>
							  </td>
							</tr>
						  </table></td>
					  </tr>
				  </table></td>
				</tr>
				<tr>
				 <td align="left" valign="top"><img src="images/specer.gif" width="1" height="5" alt="" title="" /></td>
				</tr>
				
				<tr>
				  <td align="center" valign="middle">
					<div style="display:none;">
					  <table width="490" border="0" align="center" cellpadding="0" cellspacing="0">
						  <tr>
							<td align="left" valign="top"><img src="images/specer.gif" width="1" height="5" alt="" title="" /></td>
						  </tr>
						  <tr>
							<td align="left" valign="top" class="submit-payment-content-heading-text">Profile Details:</td>
						  </tr>
						  <tr>
							  <td align="left" valign="top"><img src="images/specer.gif" width="1" height="5" alt="" title="" /></td>
						  </tr>
					  </table>
					  </div>
				  </td>
				</tr>
				
				<tr>
				  <td align="center" valign="middle">
					<div style="display:none;">
					  <table width="490" border="0" align="center" cellpadding="4" cellspacing="0">
						  <tr>
							<td width="245" height="27" align="left" valign="middle" class="list-field-text">Profile Description:</td>
							<td align="left" valign="middle"><input name="profileDesc" type="text" id="profileDesc" size="46" value="Welcome to the world of shopping where you get everything" class="list-field" onfocus="AllComboDivClosePayment('');fieldHighlight('profileDesc');" onblur="fieldLosslight('profileDesc');"/></td>
						  </tr>
						  <tr>
							<td width="245" align="left" valign="middle" class="list-field-text">Billing Period:</td>
							<td align="left" valign="middle"><input name="billingPeriod" type="text" id="billingPeriod" size="46" value="<? if ($billingPeriod==''){echo 'Month';}else{ echo $billingPeriod;};?>" class="list-field" onfocus="AllComboDivClosePayment('');fieldHighlight('billingPeriod');" onblur="fieldLosslight('billingPeriod');"/></td>
						  </tr>
						  <tr>
							<td width="245" align="left" valign="middle" class="list-field-text">Billing Frequency:</td>
							<td align="left" valign="middle"><input name="billingFrequency" type="text" id="billingFrequency" size="46" value="<? if ($billingFrequency==''){echo '1';}else{ echo $billingFrequency;};?>" class="list-field" onfocus="AllComboDivClosePayment('');fieldHighlight('billingFrequency');" onblur="fieldLosslight('billingFrequency');"/></td>
						  </tr>
						  <tr>
							<td width="245" align="left" valign="middle" class="list-field-text">Total Billing Cycles:</td>
							<td align="left" valign="middle"><input name="totalBillingCycles" type="text" id="totalBillingCycles" size="46" value="<?=$totalBillingCycles;?>" class="list-field" onfocus="AllComboDivClosePayment('');fieldHighlight('totalBillingCycles');" onblur="fieldLosslight('totalBillingCycles');"/></td>
						  </tr>
						  <tr>
							<td width="245" align="left" valign="middle" class="list-field-text">Profile Start Date:</td>
							<td align="left" valign="middle"><input name="startDate" type="text" id="startDate" size="35" value="<? if ($startDate==''){echo date("d/m/Y");}else{ echo $startDate;};?>" class="list-field3"  onfocus="AllComboDivClosePayment('');fieldHighlightCombo1('startDate');" onblur="fieldLosslightCombo1('startDate');"/>&nbsp;&nbsp;<a href="javascript:NewCssCal('startDate','ddmmyyyy','arrow')"><img src="images/calender-icon.gif" width="25" height="20" alt="" border="0" title="" /></a></td>
						  </tr>
					  </table>
					 </div>
					</td>
				</tr>
				<tr>
				  <td align="left" valign="top"><img src="images/specer.gif" width="1" height="5" alt="" title="" /></td>
				</tr>
				
				<tr>
				  <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr>
						<td align="left" valign="top" class="submit-payment-content-heading-text">Billing Address:</td>
					  </tr>
				  </table></td>
				</tr>
				<tr>
				 <td align="left" valign="top"><img src="images/specer.gif" width="1" height="5" alt="" title="" /></td>
				</tr>
				<tr>
				  <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="4" cellspacing="0">
					  <tr>
						<td width="245" height="27" align="left" valign="middle" class="list-field-text">Company:</td>
						<td align="left" valign="middle"><input name="company" type="text" id="company" size="46" value="<?=$company;?>" class="list-field" onfocus="AllComboDivClosePayment('');fieldHighlight('company');" onblur="fieldLosslight('company');"/></td>
					  </tr>
					  <tr>
						<td width="245" align="left" valign="middle" class="list-field-text">Address:</td>
						<td align="left" valign="middle"><input name="address" type="text" id="address" size="46" value="<?=$address;?>" class="list-field" onfocus="AllComboDivClosePayment('');fieldHighlight('address');" onblur="fieldLosslight('address');"/></td>
					  </tr>
					  <tr>
						<td width="245" align="left" valign="middle" class="list-field-text">Address (cont.):</td>
						<td align="left" valign="middle"><input name="address_cont" type="text" id="address_cont" size="46" value="<?=$address_cont;?>" class="list-field" onfocus="AllComboDivClosePayment('');fieldHighlight('address_cont');" onblur="fieldLosslight('address_cont');"/></td>
					  </tr>
					  <tr>
						<td width="245" align="left" valign="middle" class="list-field-text">City:</td>
						<td align="left" valign="middle"><input name="city" type="text" id="city" size="46" value="<?=$city;?>" class="list-field" onfocus="AllComboDivClosePayment('');fieldHighlight('city');" onblur="fieldLosslight('city');"/></td>
					  </tr>
					  <tr>
						<td width="245" height="27" align="left" valign="middle" class="list-field-text">State:</td>
						<td height="27" align="left" valign="top">
							
							<table width="280" border="0" align="left" cellpadding="0" cellspacing="0" class="my_div">
							<tr>
							  <td valign="top"><input name="state" class="text-new-227" type="text" id="state" style="margin-top:0px; border:0px solid #000000; color:#737373;" onfocus="fieldHighlightCombo('state');MyCombo_Open('div_state');AllComboDivClosePayment('div_state');" onkeyup="AddState('state');" size="34"  value="<?=$state;?>" onblur="fieldLosslightCombo('state');"/>
						      <img src="images/down.png" align="right" width="20" height="20" onclick="MyCombo_Open('div_state');"/> </td>
							</tr>
							<tr>
								<td valign="top">
									<div id="div_state" class="inner" style="display:none; position:absolute;">
										<?=DivContentLoad('div_state','state','short_name',TABLE_STATE)?>
									</div>
								</td>
							</tr>
					    </table>					   
						</td>
					  </tr>
					  <tr>
						<td width="245" align="left" valign="middle" class="list-field-text">Zip Code:</td>
						<td align="left" valign="middle"><input name="zip_code" type="text" id="zip_code" size="46" value="<?=$zip_code;?>" class="list-field" onfocus="AllComboDivClosePayment('');fieldHighlight('zip_code');" onblur="fieldLosslight('zip_code');"/></td>
					  </tr>
					 
				  </table></td>
				</tr>
	
				<tr>
				  <td align="center" valign="middle">&nbsp;</td>
				</tr>
				<tr>
				   <td align="center" valign="middle"><table width="107" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
					 <td align="center" valign="top" class="next-buttn"><a href="javascript:AlertPaymentSubmit();" onclick="return AlertPaymentSubmit();">Next&nbsp;<img src="images/next-arrow-big.gif" width="11" height="9" alt=""  title="" border="0"/></a></td>
					</tr>
				  </table></td>
				</tr>
			  </table>
			  </form>
			  
			  </td>
        </tr>
        <tr>
          <td align="center" valign="top"><img src="images/registration-page-bottom-bg.jpg" width="960" height="11" alt="" title="" /></td>
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