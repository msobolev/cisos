<?php
include("includes/include-top.php");
$action = $_REQUEST['action'];
$res_id = $_REQUEST['res_id'];
if($action == 'DataRestore'){
	
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	
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
	$country = $_POST['country'];
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
	<link rel="stylesheet" href="css/style_new.css" type="text/css" media="all" />
	<!--[if IE 6]>
		<link rel="stylesheet" href="css/ie6.css" type="text/css" media="all" />
	<![endif]-->
	
<script type="text/javascript" language="javascript">

function TextBoxOnFocus(divId,fieldName,className,fieldValue){
	if(fieldValue==document.getElementById(fieldName).value){
	document.getElementById(fieldName).value='';
	}
	document.getElementById(divId).className=className;
	SPAllComboBoxClose();
}
function TextBoxLossFocus(divId,fieldName,className,errClaseName,altMsg){
	var fvalue = document.getElementById(fieldName).value;
	if(fvalue==''){
		document.getElementById(divId).className=errClaseName;
		document.getElementById(fieldName).value=altMsg;
	}else{
		document.getElementById(divId).className=className;
	}	
}

function TextBoxOnFocus_107(divId,fieldName,className,fieldValue){
	if(fieldValue==document.getElementById(fieldName).value){
	document.getElementById(fieldName).value='';
	}
	document.getElementById(divId).className=className;
	SPAllComboBoxClose();
}
function TextBoxLossFocus_107(divId,fieldName,className,errClaseName,altMsg){
	var fvalue = document.getElementById(fieldName).value;
	if(fvalue==''){
		document.getElementById(divId).className=errClaseName;
		document.getElementById(fieldName).value=altMsg;
	}else{
		document.getElementById(divId).className=className;
	}	
}
function TextBoxOnFocus_255(divId,fieldName,className,fieldValue){
	if(fieldValue==document.getElementById(fieldName).value){
	document.getElementById(fieldName).value='';
	}
	document.getElementById(divId).className=className;
	SPAllComboBoxClose();
}
function TextBoxLossFocus_255(divId,fieldName,className,errClaseName,altMsg){
	var fvalue = document.getElementById(fieldName).value;
	if(fvalue==''){
		document.getElementById(divId).className=errClaseName;
		document.getElementById(fieldName).value=altMsg;
	}else{
		document.getElementById(divId).className=className;
	}	
}
function MyCombo_Open(divID){
	if(document.getElementById(divID).style.display=='block'){
	document.getElementById(divID).style.display='none';
	}else{
	document.getElementById(divID).style.display='block';
	}
}
function TextboxValueChange(txtbox,divID,val){
	document.getElementById(txtbox).value=val;
	document.getElementById(divID).style.display='none';
}

function ComboBoxFocus(tdId,className){
	SPAllComboBoxClose();
	document.getElementById(tdId).className=className;
}
function SPAllComboBoxClose(){
	document.getElementById('div_card_type').style.display='none';
	document.getElementById('div_exp_month').style.display='none';
	document.getElementById('div_exp_year').style.display='none';
	document.getElementById('div_state').style.display='none';
	document.getElementById('td_card_type').className='combo-box';
	document.getElementById('td_exp_month').className='combo-box1';
	document.getElementById('td_exp_year').className='combo-box1';
	document.getElementById('td_state').className='combo-box3';
	
}
function SubmitPaymentValidation(){
		var fname = document.getElementById('card_holder_name').value;
		if(fname=='' || (fname=='Enter your name is it appears on the card')){
			document.getElementById('card_holder_name').focus();
			return false;
		}
		var cnum = document.getElementById('card_num').value;
		if(cnum=='' || (cnum=='Enter your Credit Card Number') ){
			document.getElementById('card_num').focus();
			return false;
		}
		var ctype = document.getElementById('card_type').value;
		if(ctype=='' || (ctype=='Card Type') ){
			document.getElementById('card_type').focus();
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
		var scode = document.getElementById('security_code').value;
		if(scode==''){
			document.getElementById('security_code').focus();
			return false;
		}
		var address = document.getElementById('address').value;
		if(address=='' || address=='Enter your Billing Address'){
			document.getElementById('address').focus();
			return false;
		}
		var city = document.getElementById('city').value;
		if(city=='' || city == 'Enter your City'){
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
			document.getElementById('zip_code').focus();
			return false;
		}
	document.getElementById('frmSubmitPay').submit();	
}

</script>

</head>
<body>
	<!-- ClickTale Top part -->
	<script type="text/javascript">
    var WRInitTime=(new Date()).getTime();
    </script>
    <!-- ClickTale end of Top part -->


	<!-- Header -->
	<div id="header">
		<!-- Shell -->
		<div class="shell">
			 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="333" align="left" valign="top"><h1 id="logo"><a class="notext" href="index.php">CISOs on the Move</a></h1></td>
    <td width="19" align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">
		<div class="headernew-repeat1">
			<div class="arrow-left1">
				<div class="new-arrowbg">Step 1<br />
			    Provide Contact Information</div>
			</div>
			<div class="arrow-left1">
				<div class="new-arrowbg2">Step 2<br />
			    Chose Subscription Level</div>
			</div>
			<div class="arrow-left1">
				<div class="new-arrowbg1">Step 3<br />
			    Submit Payment Details</div>
			</div>
			<div style="clear:both;"></div>
		</div>
	</td>
  </tr>
</table>

			 <!--<div class="page-title-right">Sign Up</div>-->
	  </div>
	</div>
	<!-- end Header -->

	<!-- Main -->
	<div id="main">
	
		<!-- Shell -->
		<div class="shell-new">
		<div class="shell-new-inner">
		
			<!-- Content -->
			<div class="content">
			<!-- step box -->
			<!--<div class="step-box">
				<div class="step6">
				  <div class="step-box-heading">Step 2<br />
				    Chose Subscription Level</div>
				</div>
				<div class="step2-active">
					<div class="active-heading">Step 3<br />Submit Payment Details</div>
				</div>
			
			</div>-->
			<!--<div class="step-box">
				<div class="step8">
					<div class="step-box-heading">Step 1<br />Provide Contact Information</div>
				</div>
				
				<div class="step7">
				  <div class="step-box-heading">Step 2<br />
				    Chose Subscription Level</div>
				</div>
			  <div class="step3-active">
					<div class="active-heading">Step 3<br />
					Submit Payment Details</div>
				</div>
			</div> -->
			<!-- step box -->
			<!-- field box -->	
			<div class="step-field-box">
					<div class="fieldsnew1"><div class="fieldsnew2">All fields are required</div></div>
					 <?PHP 
					  $card_holder_name = $first_name.' '.$last_name;
					  ?>
					  <form name="frmSubmitPay" id="frmSubmitPay" method="post" action="res-process.php?action=SubmitPaymentSignUp&amp;res_id=<?=$res_id?>" onsubmit="return SubmitPaymentValidation();" >
						<div class="inner-field-box-submit">
							<div class="newpadding2">
							  <div class="name-field-box">Name on the card :</div></div>	
							<div id="div_card_holder_name" class="field-box ">
							<input  type="text" name="card_holder_name" id="card_holder_name" class="text-field" value='<?PHP if( trim($card_holder_name)==''){echo 'Enter your name is it appears on the card';}else{echo  $card_holder_name;}?>'  onfocus="TextBoxOnFocus('div_card_holder_name','card_holder_name','field-box-blue','Enter your name is it appears on the card');" onblur="TextBoxLossFocus('div_card_holder_name','card_holder_name','field-box','field-box-red','Enter your name is it appears on the card');" />
							</div>
							
							<div class="name-field-box ">Card Number : </div>	
							<div id="div_card_num" class="field-box ">
							<input type="text" name="card_num" id="card_num" class="text-field" value='<?PHP if($card_num==''){echo 'Enter your Credit Card Number';}else{echo $card_num;}?>'  onfocus="TextBoxOnFocus('div_card_num','card_num','field-box-blue','Enter your Credit Card Number');" onblur="TextBoxLossFocus('div_card_num','card_num','field-box','field-box-red','Enter your Credit Card Number');" />
							</div>	
							<!--<div class="lock-icon-new"><img src="css/images/lock.jpg"  alt="" width="23" height="31" title=""/></div>-->
							<!--<div class="lock-icon-new"><img src="css/images/lock1.jpg"  alt="lock" title="lock"/></div>
							<div class="lock-icon-text">Safe and Secure 128 Bit SSL Certified Encrypted Transaction</div>-->
							
							<div class="padlock" style="margin-top:10px;">
								<img src="css/images/padlock.jpg" alt="padlock" style="margin-right:11px" />
								<img src="css/images/visa.gif" alt="Visa" style="margin-right:11px" />
								<img src="css/images/mastercard.gif" alt="Mastercard" style="margin-right:11px" />
								<img src="css/images/american-express.gif" alt="American Express" style="margin-right:11px" />
								<img src="css/images/discover.gif" alt="Discover" style="margin-right:11px" />
								<img src="css/images/paypal.gif" alt="PayPal" />
					    	</div>
							
						<!--<div class="name-field-box">		                    
							<div class="info-box-left"><img src="css/images/info-box-left.gif" alt="" /></div>
							<div class="info-box-mid">Order Securely 24 Hours/Day, 7 Days a Week, 365 Days Per Year</div>
							<div class="info-box-right"><img src="css/images/info-box-right.gif" alt="" /></div>
						</div>	-->

						<div class="field-box-new">
							<table width="540" border="0" align="center" cellpadding="0" cellspacing="0">
							  <tr>
								<td width="172" align="left" valign="middle" class="name-field-box-new">Card Type : </td>
								<td align="left" valign="middle">&nbsp;</td>
								<td align="left" valign="middle" class="name-field-box-new">Expiration : </td>
								<td align="left" valign="middle">&nbsp;</td>
								<td width="113" align="left" valign="middle">&nbsp;</td>
								<td align="left" valign="middle">&nbsp;</td>
								<td width="115" align="left" valign="middle" class="name-field-box-new">Security Code : </td>
							  </tr>
							  <tr>
								<td width="172" align="left" valign="top" class="combo-box">
									<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" id="td_card_type" class="combo-box">
										<tr>
										  <td valign="top">
												<input type="text" name="card_type" id="card_type" value="<?PHP if($card_type==''){echo '';}else{echo $card_type;}?>" style="margin:5px; float:left; width:118px;  padding-top:6px; height:22px; border: 0px solid rgb(0, 0, 0); color: rgb(115, 115, 115); font-weight:bold;" onfocus="ComboBoxFocus('td_card_type','combo-box-blue');MyCombo_Open('div_card_type');" onblur="fieldLosslightCombo('card_type');"/>
												<img src="css/images/down.gif" align="right" width="35" height="42" alt="" title="" onclick="MyCombo_Open('div_card_type');"/>	</td>
										</tr>
										<tr>
											<td valign="top">
												<div id="div_card_type" class="drop-box-170" style="display:none; position:absolute;">
													<a href="javascript:TextboxValueChange('card_type','div_card_type','Visa');">Visa</a><br />
													<a href="javascript:TextboxValueChange('card_type','div_card_type','MasterCard');">MasterCard</a><br />
													<a href="javascript:TextboxValueChange('card_type','div_card_type','Discover');">Discover</a><br />
													<a href="javascript:TextboxValueChange('card_type','div_card_type','Amex');">Amex</a><br />
												</div>
											</td>
										</tr>
									</table>
								</td>
								<td align="left" valign="top">&nbsp;</td>
								<td width="113" align="left" valign="top" class="combo-box1">
									<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" id="td_exp_month" class="combo-box1">
										<tr>
										  <td valign="top">
											<input type="text" name="exp_month" id="exp_month" value="<?PHP if($exp_month==''){echo 'Month';}else{echo $exp_month;}?>" style="margin:5px; float:left; width:68px;  padding-top:6px; height:22px; border: 0px solid rgb(0, 0, 0); color: rgb(115, 115, 115); font-weight:bold;" onfocus="ComboBoxFocus('td_exp_month','combo-box1-blue');MyCombo_Open('div_exp_month');" />
											<img src="css/images/down.gif" align="right" width="35" height="42" alt="" title="" onclick="MyCombo_Open('div_exp_month');"/>
										  </td>
										</tr>
										<tr>
											<td valign="top">
												<div id="div_exp_month" class="drop-box-112" style="display:none; position:absolute;">
													<?PHP for($mm=1;$mm<=12;$mm++){ 
														if($mm<=9){
															$mVal = '0'.$mm;
														}else{
															$mVal = $mm;
														}
													?>
														<a href="javascript:TextboxValueChange('exp_month','div_exp_month','<?=$mVal?>');"><?=$mVal?></a><br />
												     <?PHP }?>
												</div>
											</td>
										</tr>
									</table>
								</td>
								<td align="left" valign="top">&nbsp;</td>
									<td width="113" align="left" valign="top" class="combo-box1">
										<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" id="td_exp_year" class="combo-box1">
											<tr>
											  <td valign="top">
												<input type="text" name="exp_year" id="exp_year"  value="<?PHP if($exp_year==''){echo 'Year';}else{echo $exp_year;}?>" style="margin:5px; float:left; width:68px; padding-top:6px; height:22px; border: 0px solid rgb(0, 0, 0); color: rgb(115, 115, 115); font-weight:bold;" onfocus="ComboBoxFocus('td_exp_year','combo-box1-blue');MyCombo_Open('div_exp_year');" />
												<img src="css/images/down.gif" align="right" width="35" height="42" alt="" title="" onclick="MyCombo_Open('div_exp_year');"/>	</td>
											</tr>
											<tr>
												<td valign="top">
													<div id="div_exp_year" class="drop-box-112" style="display:none; position:absolute;">
													<?PHP for($yy=date('Y');$yy<=date('Y')+10;$yy++){ ?>
														<a href="javascript:TextboxValueChange('exp_year','div_exp_year','<?=$yy?>');"><?=$yy?></a><br />
													<?PHP } ?>	
													</div>
												</td>
											</tr>
										</table>
								</td>
								<td align="left" valign="top">&nbsp;</td>
								<td width="115" align="left" valign="top" id="div_security_code" class="combo-box2">
								  <input type="text" name="security_code" id="security_code" class="text-field-new" value="<?=$security_code?>" onfocus="TextBoxOnFocus_107('div_security_code','security_code','combo-box2-blue','');" onblur="TextBoxLossFocus_107('div_security_code','security_code','combo-box2','combo-box2-red','');" />
								</td>
							  </tr>
							</table>
							</div>
								
								<div class="name-field-box ">Billing Address :
									<input type="hidden" name="profileDesc" id="profileDesc" value="CTOsOnTheMove – Subscription" />	
									<input type="hidden" name="billingPeriod" id="billingPeriod" value="Month" />
									<input type="hidden" name="billingFrequency" id="billingFrequency" value="1" />
									<input type="hidden" name="totalBillingCycles" id="totalBillingCycles" value="" />
									<input type="hidden" name="startDate" id="startDate" size="35" value="<?=date('d/m/Y',mktime(0, 0, 0, date("m")  , date("d")+1, date("Y")));?>" />
								</div>	
								<div id="div_address" class="field-box ">
								<input type="text" name="address" id="address" class="text-field" value="<?PHP if($address==''){echo 'Enter your Billing Address';}else{echo $address;} ?>"  onfocus="TextBoxOnFocus('div_address','address','field-box-blue','Enter your Billing Address');" onblur="TextBoxLossFocus('div_address','address','field-box','field-box-red','Enter your Billing Address');" />
							</div>	
							
							<div class="name-field-box ">City : </div>	
							<div id="div_city" class="field-box ">
							<input type="text" name="city" id="city" class="text-field" value="<?PHP if($city==''){echo 'Enter your City';}else{echo $city;}?>"  onfocus="TextBoxOnFocus('div_city','city','field-box-blue','Enter your City');" onblur="TextBoxLossFocus('div_city','city','field-box','field-box-red','Enter your City');" />
							</div>	
							
							<div class="name-field-box ">
							  <table width="540" border="0" align="center" cellpadding="0" cellspacing="0">
								<tr>
								  <td width="265" align="left" valign="top" class="name-field-box-new">State : </td>
								  <td width="102" align="left" valign="top">&nbsp;</td>
								  <td width="266" align="left" valign="top" class="name-field-box-new">Zip Code : </td>
								</tr>
								<tr>
								  <td width="256" align="left" valign="top" class="combo-box3">
								  	  <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" id="td_state" class="combo-box3">
											<tr>
											  <td valign="top">
												<input type="text" name="state" id="state" value="<?PHP if($state==''){echo '';}else{echo $state;}?>" style="margin:3px; float:left; width:180px;  padding-top:8px; padding-left:5px; height:22px; border: 0px solid rgb(0, 0, 0); color: rgb(115, 115, 115);font-weight:bold;" onfocus="ComboBoxFocus('td_state','combo-box3-blue');MyCombo_Open('div_state');" />
												<img src="css/images/down.gif" align="right" width="35" height="42" alt="" title="" onclick="MyCombo_Open('div_state');"/>	</td>
											</tr>
											<tr>
												<td valign="top">
													<div id="div_state" class="drop-box-256" style="display:none; position:absolute;">
														<?=DivContentLoad('div_state','state','short_name',TABLE_STATE)?>
													</div>
												</td>
											</tr>
										</table>
								   </td>		
								  <td align="left" valign="top">&nbsp;</td>
								  <td width="266" align="left" valign="top" id="div_zip_code" class="combo-box4">
								  <input name="zip_code" id="zip_code" style="margin:5px; float:left; width:240px;" type="text"  class="text-field" value="<?PHP if($zip_code==''){echo 'Enter your Zip Code';}else{echo $zip_code;}?>"  onfocus="TextBoxOnFocus_255('div_zip_code','zip_code','combo-box4-blue','Enter your Zip Code');" onblur="TextBoxLossFocus_255('div_zip_code','zip_code','combo-box4','combo-box4-red','Enter your Zip Code');" /></td>
								</tr>
							  </table>
							</div>	
		                   
							
							<div class="clear-bottom"></div>
							<div class="buttn-box">
							<div class="blue-buttn"><input type="image" name="pay_submit"  src="css/images/confirm.jpg" /><!--onmouseover="this.src='css/images/confirm-buttn-h.gif'" onmouseout="this.src='css/images/confirm-buttn.gif'" <a href="javascript:;" onclick="SubmitPaymentValidation();"><span>Confirm</span></a>--></div>
							</div>	
					</div>
					</form>
						
			</div>	
				<!-- field box -->		
				
			</div>
			<!-- Content -->
			
			<div class="cl">&nbsp;</div>
		</div>
		</div>
		<!-- end Shell -->
	</div>
	<!-- end Main -->
	<!-- Footer -->
	<div id="footer">
		<div class="shell">
			<p>&copy; <?=date("Y");?> CISOsOnTheMove. All rights reserved.</p>
		</div>
	</div>
	<!-- end Footer -->
	
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
	<!-- begin olark code -->
<script data-cfasync="false" type='text/javascript'>/*<![CDATA[*/window.olark||(function(c){var f=window,d=document,l=f.location.protocol=="https:"?"https:":"http:",z=c.name,r="load";var nt=function(){
f[z]=function(){
(a.s=a.s||[]).push(arguments)};var a=f[z]._={
},q=c.methods.length;while(q--){(function(n){f[z][n]=function(){
f[z]("call",n,arguments)}})(c.methods[q])}a.l=c.loader;a.i=nt;a.p={
0:+new Date};a.P=function(u){
a.p[u]=new Date-a.p[0]};function s(){
a.P(r);f[z](r)}f.addEventListener?f.addEventListener(r,s,false):f.attachEvent("on"+r,s);var ld=function(){function p(hd){
hd="head";return["<",hd,"></",hd,"><",i,' onl' + 'oad="var d=',g,";d.getElementsByTagName('head')[0].",j,"(d.",h,"('script')).",k,"='",l,"//",a.l,"'",'"',"></",i,">"].join("")}var i="body",m=d[i];if(!m){
return setTimeout(ld,100)}a.P(1);var j="appendChild",h="createElement",k="src",n=d[h]("div"),v=n[j](d[h](z)),b=d[h]("iframe"),g="document",e="domain",o;n.style.display="none";m.insertBefore(n,m.firstChild).id=z;b.frameBorder="0";b.id=z+"-loader";if(/MSIE[ ]+6/.test(navigator.userAgent)){
b.src="javascript:false"}b.allowTransparency="true";v[j](b);try{
b.contentWindow[g].open()}catch(w){
c[e]=d[e];o="javascript:var d="+g+".open();d.domain='"+d.domain+"';";b[k]=o+"void(0);"}try{
var t=b.contentWindow[g];t.write(p());t.close()}catch(x){
b[k]=o+'d.write("'+p().replace(/"/g,String.fromCharCode(92)+'"')+'");d.close();'}a.P(2)};ld()};nt()})({
loader: "static.olark.com/jsclient/loader0.js",name:"olark",methods:["configure","extend","declare","identify"]});
/* custom configuration goes here (www.olark.com/documentation) */
olark.identify('9112-492-10-1323');/*]]>*/</script><noscript><a href="https://www.olark.com/site/9112-492-10-1323/contact" title="Contact us" target="_blank">Questions? Feedback?</a> powered by <a href="http://www.olark.com?welcome" title="Olark live chat software">Olark live chat software</a></noscript>
<!-- end olark code -->


</body>
</html>