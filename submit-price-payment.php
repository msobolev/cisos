<?php
include("includes/include-top.php");
$action = $_REQUEST['action'];
$email = $_REQUEST['email'];

if($action == 'DataRestore' || $action=='BlankField'){
	
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$email = $_REQUEST['email'];
	$card_type =$_POST['card_type'];
	$card_num = $_POST['card_num'];
	$exp_month = $_POST['exp_month'];
	$exp_year = $_POST['exp_year'];
	$security_code = $_POST['security_code'];
	
	$profileDesc = $_POST['profileDesc'];
	$billingPeriod = $_POST['billingPeriod'];
	$billingFrequency = $_POST['billingFrequency'];
	$totalBillingCycles = $_POST['totalBillingCycles'];
	$startDate = $_POST['startDate'];
	
	$company = $_POST['company'];
	$address = $_POST['address'];
	$address_cont = $_POST['address_cont'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$zip_code = $_POST['zip_code'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en-US" xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
	<title><?=$PageTitle;?></title>
	<meta name="keywords" content="<?=$PageKeywords?>" />
	<meta name="description" content="<?=$PageDescription?>" />
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" href="images/favicon.jpg" />
	<link rel="stylesheet" href="css/style-price-payment.css" type="text/css" media="all" />
	<!--[if IE 6]>
		<link rel="stylesheet" href="css/ie6.css" type="text/css" media="all" />
	<![endif]-->
	
<script type="text/javascript" language="javascript">


function SubmitPaymentValidation(){
		var email = document.getElementById('email').value;
		if(email==''){
			document.getElementById('divEmail').className='input-input-box-red';
			document.getElementById('divEmailErr').style.display="block";
			document.getElementById('divEmailErr').innerHTML="Login cannot be blank";
			document.getElementById('email').focus();
			return false;
		}else{
			var reg=/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
			if(reg.test(email)==false){
				document.getElementById('divEmail').className='input-input-box-red';
				document.getElementById('divEmailErr').style.display="block";
				document.getElementById('divEmailErr').innerHTML="Enter your Work Email Address";
				document.getElementById('email').focus();
				return false;
			}else{
				var start_position = email.indexOf('@');
				var email_part = email.substring(start_position);
				var end_position = email_part.indexOf('.');
				var find_part = email_part.substring(0,end_position+1);
				var pemail = [<?=$banned_domain_array;?>];
				var email_result = include(pemail, find_part);
				if(email_result){
					document.getElementById('divEmail').className='input-input-box-red';
					document.getElementById('divEmailErr').style.display="block";
					document.getElementById('divEmailErr').innerHTML="Enter your Work Email Address";
					document.getElementById('email').focus();
					return false;
				}
			}
		}
		var pass = document.getElementById('password').value;
		if(pass==''){
			document.getElementById('divPassword').className='input-input-box-red';
			document.getElementById('divPasswordErr').style.display="block";
			document.getElementById('divPasswordErr').innerHTML="New password cannot be blank";
			document.getElementById('password').focus();
			return false;
		}
		var chname = document.getElementById('card_holder_name').value;
		if(chname==''){
			document.getElementById('divCardHolderName').className='input-input-box-red';
			document.getElementById('divCardHolderNameErr').style.display="block";
			document.getElementById('divCardHolderNameErr').innerHTML="Enter your name is it appears on the card";
			document.getElementById('card_holder_name').focus();
			return false;
		}
		var cnum = document.getElementById('card_num').value;
		if(cnum=='' || (cnum=='Enter your Credit Card Number') ){
			document.getElementById('divCardNum').className='input-input-box1-red';
			document.getElementById('divCardNumErr').style.display="block";
			document.getElementById('divCardNumErr').innerHTML="Enter your Credit Card Number";
			document.getElementById('card_num').focus();
			return false;
		}
		var scode = document.getElementById('security_code').value;
		if(scode==''){
			document.getElementById('divSecurityCode').className='input-input-box2-red';
			document.getElementById('divSecurityCodeErr').style.display="block";
			document.getElementById('divSecurityCodeErr').innerHTML="Enter your card Security Code";
			document.getElementById('security_code').focus();
			return false;
		}
		var emonth = document.getElementById('exp_month').value;
		if(emonth=='' || emonth == 'Month'){
			document.getElementById('exp_month').focus();
			return false;
		}
		var eyear = document.getElementById('exp_year').value;
		if(eyear=='' || eyear == 'Year'){
			document.getElementById('exp_year').focus();
			return false;
		}

		var address = document.getElementById('address').value;
		if(address=='' || address=='Enter your Billing Address'){
			document.getElementById('divAddress').className='input-input-box-red';
			document.getElementById('divAddressErr').style.display="block";
			document.getElementById('divAddressErr').innerHTML="Enter your Billing Address";
			document.getElementById('address').focus();
			return false;
		}
		var city = document.getElementById('city').value;
		if(city=='' || city == 'Enter your City'){
			document.getElementById('divCity').className='input-input-box-red';
			document.getElementById('divCityErr').style.display="block";
			document.getElementById('divCityErr').innerHTML="Enter your City";
			document.getElementById('city').focus();
			return false;
		}
		var state = document.getElementById('state').value;
		if(state=='' || state == 'State'){
			document.getElementById('state').focus();
			return false;
		}
		var zcode = document.getElementById('zip_code').value;
		if(zcode=='' || zcode == 'Enter your Zip Code'){
			document.getElementById('divZip').className='zip-input-box-red';
			document.getElementById('divZipErr').style.display="block";
			document.getElementById('divZipErr').innerHTML="Enter your zip";
			document.getElementById('zip_code').focus();
			return false;
		}
	document.getElementById('frmSubmitPay').submit();	
}
function include(arr, obj) {
	  for(var i=0; i<arr.length; i++) {
		if (arr[i].toUpperCase() == obj.toUpperCase()) return true;
	  }
	}
function PaymentProcessByPayPal(){
	var email = document.getElementById('email').value;
		if(email==''){
			document.getElementById('divEmail').className='input-input-box-red';
			document.getElementById('divEmailErr').style.display="block";
			document.getElementById('divEmailErr').innerHTML="Login cannot be blank";
			document.getElementById('email').focus();
			return false;
		}else{
			var reg=/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
			if(reg.test(email)==false){
				document.getElementById('divEmail').className='input-input-box-red';
				document.getElementById('divEmailErr').style.display="block";
				document.getElementById('divEmailErr').innerHTML="Enter your Work Email Address";
				document.getElementById('email').focus();
				return false;
			}else{
				var start_position = email.indexOf('@');
				var email_part = email.substring(start_position);
				var end_position = email_part.indexOf('.');
				var find_part = email_part.substring(0,end_position+1);
				var pemail = [<?=$banned_domain_array;?>];
				var email_result = include(pemail, find_part);
				if(email_result){
					document.getElementById('divEmail').className='input-input-box-red';
					document.getElementById('divEmailErr').style.display="block";
					document.getElementById('divEmailErr').innerHTML="Enter your Work Email Address";
					document.getElementById('email').focus();
					return false;
				}
			}
		}
		var pass = document.getElementById('password').value;
		if(pass==''){
			document.getElementById('divPassword').className='input-input-box-red';
			document.getElementById('divPasswordErr').style.display="block";
			document.getElementById('divPasswordErr').innerHTML="New password cannot be blank";
			document.getElementById('password').focus();
			return false;
		}
		if(email !='' && pass !=''){
			var url = "paypal_process.php?email=" + email + "&pass=" + pass;	
			window.location=url;
		}
}
</script>

</head>
<body>
<!-- ClickTale Top part -->
<script type="text/javascript">
var WRInitTime=(new Date()).getTime();
</script>
<!-- ClickTale end of Top part -->

<div class="header">
  <div class="contaner">
    <div class="header-main">
      <div class="logo"><a href="<?=HTTP_SERVER?>index.php"><img src="css/images/logo.jpg" alt="" width="340" height="50" border="0" /></a></div>
    </div>
  </div>
</div>
<div class="body-main">
  <div class="body-top">
    <h1>Get Instant Access to Prospective IT Clients in Real-Time</h1>
    <span>Subscribe to Detailed Updates on Appointments and Promotions of Your Future Clients</span>
    <div class="free-subscription-box">
      <div class="free-subscription-box-left"><img src="css/images/mony-back.jpg" alt="m" width="131" height="131" border="0" /></div>
      <div class="free-subscription-box-right">
        <h3>100% Risk-Free Subscription</h3>
        <ul>
          <li><b>1)</b> Set up your subscription account</li>
          <li><b>2)</b> Billing is month-to-month. No contract. No commitment. No cancelation penalties or fees.</li>
          <li><b>3)</b> Cancel any time.</li>
          <li><b>4)</b> Didn't get the value of out of subscription? Just let us know within 365 days from sign up <br />
            and we will refund your subscription, no questions asked! And keep all the leads!</li>
        </ul>
      </div>
    </div>
  </div>
  <div class="body-buttom">
    <div class="body-buttom-left">
      <div class="subscript-accoutn-box">
        <div class="subscript-accoutn-box-top"><img src="css/images/subscript-box-top.jpg" alt="s" width="595" height="7" border="0" /></div>
        <div class="subscript-accoutn-box-medile">
          <div class="subscript-accoutn-box-padding">
            <? $card_holder_name = $first_name.' '.$last_name; ?>
			 <form name="frmSubmitPay" id="frmSubmitPay" method="post" action="res-price-process.php?action=SubmitPaymentPrice" onsubmit="return SubmitPaymentValidation();" >
              <div class="subscript-accoutn-box-account"> 1 &nbsp;&nbsp;CREATE YOUR  SUBSCRIPTION ACCOUNT </div>
              <div class="input-box">
                <div class="input-text">Email Address</div>
                <div id="divEmail" <? if(($action =='BlankField' && trim($email)=='') || ($action =='BannedEmail' && trim($email)!='')){echo 'class="input-input-box-red"'; }else{ echo 'class="input-input-box"';}?>>
                  <input name="email" id="email" type="text" class="input" value="<?=trim($email)?>" />
                </div>
              </div>
              <? if($action=='BlankField' && trim($email)==''){?>
              <div id="divEmailErr" class="blank-box" style="display:block;">Login cannot be blank</div>
              <? }elseif($action=='BannedEmail' && trim($email)!=''){ ?>
              <div id="divEmailErr" class="blank-box" style="display:block;">Enter your Work Email Address</div>
              <? }else{ ?>
              <div id="divEmailErr" class="blank-box" style="display:none;">Login cannot be blank</div>
              <? } ?>
              <div class="input-box">
                <div class="input-text">Password</div>
                <div id="divPassword" <? if($action =='BlankField'){echo 'class="input-input-box-red"'; }else{ echo 'class="input-input-box"';}?>>
                  <input name="password" id="password" type="password"  class="input"/>
                </div>
              </div>
              <div id="divPasswordErr" class="blank-box" style="display:<? if($action=='BlankField'){echo 'block';}else{echo 'none';}?>;padding-bottom:10px;">New password cannot be blank</div>
              <div class="subscript-accoutn-box-account"> 2 &nbsp;&nbsp;ENTER BILLING INFORMATION </div>
              <div id="divPaymentInfo" class="blank-box-declined" style="display:<? if($action == 'DataRestore'){echo 'block';}else{echo 'none';}?>;">Your credit card cannot be processed at this time. <br/>Please verify your credit card details or try another card</div>
              <div class="input-box">
                <div class="input-text">Full Name</div>
                <div id="divCardHolderName" <? if($action =='BlankField' && trim($card_holder_name) ==''){echo 'class="input-input-box-red"'; }else{ echo 'class="input-input-box"';}?>>
                  <input name="card_holder_name" id="card_holder_name" type="text" class="input" value="<?=trim($card_holder_name)?>"/>
                </div>
              </div>
              <div id="divCardHolderNameErr" class="blank-box" style="display:<? if($action=='BlankField' && trim($card_holder_name) ==''){echo 'block';}else{echo 'none';}?>;">Enter your name is it appears on the card</div>
              <div class="input-box">
                <div class="input-text">Credit Card Number</div>
                <div id="divCardNum" <? if($action =='BlankField' && trim($card_num)==''){echo 'class="input-input-box1-red"'; }else{ echo 'class="input-input-box1"';}?>>
                  <input name="card_num" id="card_num" type="text"  class="input1" value="<?=trim($card_num)?>"/>
                </div>
                <div class="card-box">
                  <div class="card-pic"><a href="javascript:;" onclick="PaymentProcessByPayPal();"><img src="css/images/paypal.jpg" alt="p" width="40" height="23" border="0" /></a><!--<input type="image" name="pay_submit" src="css/images/paypal.jpg" />--></div>
                  <div class="card-pic"><a href="javascript:;"><img src="css/images/visa.jpg" alt="p" width="40" height="23" border="0" /></a></div>
                  <div class="card-pic"><a href="javascript:;"><img src="css/images/master-card.jpg" alt="p" width="40" height="23" border="0" /></a></div>
                  <div class="card-pic"><a href="javascript:;"><img src="css/images/amex.jpg" alt="p" width="40" height="23" border="0" /></a></div>
                </div>
              </div>
              <div id="divCardNumErr" class="blank-box" style="display:<? if($action=='BlankField' && trim($card_num)==''){echo 'block';}else{echo 'none';}?>;">Enter your Credit Card Number</div>
              <div class="input-box">
                <div class="input-text">Security Code (CW)</div>
                <div id="divSecurityCode" <? if($action =='BlankField' && trim($security_code) ==''){echo 'class="input-input-box2-red"'; }else{ echo 'class="input-input-box2"';}?>>
                  <input name="security_code" id="security_code" type="text"  class="input2" value="<?=trim($security_code)?>"/>
                </div>
                <div class="log-box">
                  <div class="log-box-pic"><img src="css/images/card.png" alt="l" width="32" height="22" border="0" /></div>
                  <p>This is the 3-4 digit number on 
                    the back of your card.</p>
                </div>
              </div>
              <div id="divSecurityCodeErr" class="blank-box" style="display:<? if($action=='BlankField' && trim($security_code)==''){echo 'block';}else{echo 'none';}?>;">Enter your Security Code</div>
              <div class="input-box1">
                <div class="input-text1">Card Expiration Date</div>
                <div class="check-box">
                  <select name="exp_month" id="exp_month" class="list-box">
                  	<option value="">Month </option>
                    <? for($mm=1;$mm<=12;$mm++){ 
							if($mm<=9){
								$mVal = '0'.$mm;
							}else{
								$mVal = $mm;
							}
							if($mVal==$exp_month){
								echo '<option value="'.$mVal.'" selected="selected">'.$mVal.'</option>';
							}else{
								echo '<option value="'.$mVal.'">'.$mVal.'</option>';
							}
						}?>
                  </select>
                  <select name="exp_year" id="exp_year" class="list-box1">
                  	<option value="">Year </option>
                    <? for($yy=date('Y');$yy<=date('Y')+10;$yy++){ 
							if($yy==$exp_year){
								echo '<option value="'.$yy.'" selected="selected">'.$yy.'</option>';
							}else{
								echo '<option value="'.$yy.'">'.$yy.'</option>';
							}
						}
					?>
                  </select>
                </div>
              </div>
              <div class="input-box">
                <div class="input-text">Address
                	<input type="hidden" name="profileDesc" id="profileDesc" value="CTOsOnTheMove – Subscription" />	
                    <input type="hidden" name="billingPeriod" id="billingPeriod" value="Month" />
                    <input type="hidden" name="billingFrequency" id="billingFrequency" value="1" />
                    <input type="hidden" name="totalBillingCycles" id="totalBillingCycles" value="" />
                    <input type="hidden" name="startDate" id="startDate" size="35" value="<?=date('d/m/Y',mktime(0, 0, 0, date("m")  , date("d")+1, date("Y")));?>" />
                </div>
                <div id="divAddress" <? if($action =='BlankField' && trim($address)==''){echo 'class="input-input-box-red"'; }else{ echo 'class="input-input-box"';}?>>
                  <input name="address" id="address" type="text" class="input" value="<?=trim($address)?>"/>
                </div>
              </div>
              <div id="divAddressErr" class="blank-box" style="display:<? if($action=='BlankField' && trim($address)==''){echo 'block';}else{echo 'none';}?>;">Enter your Billing Address</div>
              <div class="input-box">
                <div class="input-text">City</div>
                <div id="divCity" <? if($action =='BlankField' && trim($city)==''){echo 'class="input-input-box-red"'; }else{ echo 'class="input-input-box"';}?>>
                  <input name="city" id="city" type="text" class="input" value="<?=trim($city)?>"/>
                </div>
              </div>
              <div id="divCityErr" class="blank-box" style="display:<? if($action=='BlankField' && trim($city)==''){echo 'block';}else{echo 'none';}?>;">Enter your city</div>
              <div class="input-box">
                <div class="input-text2">State / Province</div>
                <div class="list-main-box">
                  <select name="state" id="state" class="list-check">
                    <option value="">State</option>
                    <?=selectComboBox("select short_name, short_name from ".TABLE_STATE,$state);?>
                  </select>
                </div>
                <div class="zip-box">
                  <div class="zip-text">Zip</div>
                  <div id="divZip" <? if($action =='BlankField' && trim($zip_code)==''){echo 'class="zip-input-box-red"'; }else{ echo 'class="zip-input-box"';}?>>
                    <input name="zip_code" id="zip_code" type="text" class="zip-input" value="<?=trim($zip_code)?>"/>
                  </div>
                </div>
              </div>
              <div id="divZipErr" class="blank-box" style="display:<? if($action=='BlankField' && trim($zip_code)==''){echo 'block';}else{echo 'none';}?>;">Enter your zip</div>
              <div class="input-box">
                <div class="input-text2">Country</div>
                <div class="list-main-box">
                	<? if($country==''){
							$country='US';
					   }
					 ?>
                  <select name="country" id="country" class="list-check">
                    <option value="">Country</option>
                    <?=selectComboBox("select countries_iso_code_2, countries_name from ".TABLE_COUNTRIES,$country);?>
                  </select>
                </div>
              </div>
              <div class="subscript-accoutn-box-account1"> 3 &nbsp;&nbsp;REVIEW YOUR SUBSCRIPTION </div>
              <div class="buttom-subscripition">
              	<? $subscript_amount = com_db_GetVAlue("select amount from ".TABLE_SUBSCRIPTION." where sub_id='".$_SESSION['sess_sub_choose']."'") ?>
                <div class="buttom-subscripition-text">Total :&nbsp;<span>$<?=$subscript_amount?> every 30 days</span></div>
                <div class="risk-subscription"><input type="image" name="pay_submit" src="css/images/subscription.jpg" /></div>
              </div>
              <div> </div>
            </form>
          </div>
        </div>
      </div>
      <div class="subscript-accoutn-box-buttom"><img src="css/images/subscript-box-buttom1.jpg" alt="b" width="595" height="7" border="0" /></div>
      <div class="commen-question-box">
        <div class="subscript-accoutn-box-top"><img src="css/images/subscript-box-top.jpg" alt="s" width="595" height="7" border="0" /></div>
        <div class="subscript-accoutn-box-medile">
          <div class="commen-question-padding">
            <h3>COMMON QUESTIONS :</h3>
            <div class="question-text">
              <p>Can I upgrade / downgrade my subscription?<br />
                <span>Yes, you can change your subscription at any time.</span> </p>
            </div>
            <div class="question-text">
              <p>Am I locked into a contract?<br />
                <span>No! You can cancel any time you want without any fees or penalties.</span> </p>
            </div>
            <div class="question-text">
              <p>Can I cancel my subscription anytime?<br />
                <span>Yes, you can stop the subscription at any time. Just drop us a line here.</span> </p>
            </div>
            <div class="question-text">
              <p>Are there any penalties or fees for cancellation?<br />
                <span>Absolutely not. There are no fees or penalties for cancellation.</span> </p>
            </div>
          </div>
        </div>
        <div class="subscript-accoutn-box-buttom"><img src="css/images/subscript-box-buttom1.jpg" alt="b" width="595" height="7" border="0" /></div>
      </div>
    </div>
    <div class="body-buttom-right">
      <div class="right-top-it-box">
        <div class="top-it-top"><img src="css/images/top-it-top-bg.jpg" alt="" width="303" height="9" border="0" /></div>
        <div class="top-it-top-medile">
          <div class="top-it-top-medile-padding">
            <div class="top-it-text">TOP IT COMPANIES TRUST <br />
              CTOsOnTheMove:</div>
          </div>
          <div class="pic-link-box">
            <table width="302" border="0" cellspacing="0" cellpadding="5">
              <tr>
                <td width="302" align="center" valign="middle"><a href="#"><img src="css/images/pic1.jpg" alt="" width="85" height="54" border="0" /></a></td>
              </tr>
              <tr>
                <td width="302" align="center" valign="middle">&nbsp;</td>
              </tr>
              <tr>
                <td width="302" align="center" valign="middle"><a href="#"><img src="css/images/amd.jpg" alt="a" width="111" height="27" border="0" /></a></td>
              </tr>
              <tr>
                <td width="302" align="center" valign="middle">&nbsp;</td>
              </tr>
              <tr>
                <td width="302" align="center" valign="middle"><a href="#"><img src="css/images/amazon.jpg" alt="a" width="121" height="44" border="0" /></a></td>
              </tr>
              <tr>
                <td width="302" align="center" valign="middle">&nbsp;</td>
              </tr>
              <tr>
                <td width="302" align="center" valign="middle"><a href="#"><img src="css/images/coraid.jpg" alt="c" width="116" height="51" border="0" /></a></td>
              </tr>
              <tr>
                <td width="302" align="center" valign="middle">&nbsp;</td>
              </tr>
              <tr>
                <td width="302" align="center" valign="middle"><a href="#"><img src="css/images/gartner.jpg" alt="g" width="142" height="31" border="0" /></a></td>
              </tr>
              <tr>
                <td width="302" align="center" valign="middle">&nbsp;</td>
              </tr>
              <tr>
                <td width="302" align="center" valign="middle"><a href="#"><img src="css/images/telwares.jpg" alt="t" width="169" height="33" border="0" /></a></td>
              </tr>
              <tr>
                <td width="302" align="center" valign="middle">&nbsp;</td>
              </tr>
              <tr>
                <td width="302" align="center" valign="middle"><a href="#"><img src="css/images/unitrends.jpg" alt="u" width="159" height="26" border="0" /></a></td>
              </tr>
              <tr>
                <td width="302" align="center" valign="middle">&nbsp;</td>
              </tr>
              <tr>
                <td width="302" align="center" valign="middle"><a href="#"><img src="css/images/verdiem.jpg" alt="v" width="172" height="33" border="0" /></a></td>
              </tr>
              <tr>
                <td width="302" align="center" valign="middle">&nbsp;</td>
              </tr>
             
            </table>
          </div>
        </div>
        <div class="top-it-buttom"><img src="css/images/top-it-top-buttom.jpg" alt="t" width="303" height="9" border="0" /></div>
      </div>
    </div>
  </div>
</div>
<div class="clear"></div>
<div class="footer">
  <div class="footer-main">
    <div class="footer-padding">
      <p>&copy;&nbsp;<?=date("Y");?> CTOsOnTheMove. All rights reserved</p>
    </div>
  </div>
</div>
<!-- ClickTale Bottom part -->
<div id="ClickTaleDiv" style="display: none;"></div>
<script type="text/javascript">
if(document.location.protocol!='https:')
  document.write(unescape("%3Cscript%20src='http://s.clicktale.net/WRd.js'%20type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
if(typeof ClickTale=='function') ClickTale(16042,0.1,"www14");
</script>
<!-- ClickTale end of Bottom part -->

</body>
</html>