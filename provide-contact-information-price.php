<?php
include("includes/include-top.php");
$first_name = $_REQUEST['first_name'];
$last_name = $_REQUEST['last_name'];
$action = $_REQUEST['action'];
if($action=='DublicatEmail' || $action == 'BlankField' || $action == 'BannedEmail'){
	$first_name = $_REQUEST['fn'];
	$last_name = $_REQUEST['ln'];
	$company_name = $_REQUEST['cn'];
	$phone = $_REQUEST['ph'];
	$email = $_REQUEST['em'];
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

function TextBoxOnFocus(divId,fieldName,className,fieldVal){
	if(document.getElementById(fieldName).value==fieldVal){
	document.getElementById(fieldName).value='';
	}
	document.getElementById(divId).className=className;
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

function pviValidationNew(){
		var fname = document.getElementById('first_name').value;
		if(fname=='' || (fname=='Enter your First Name')){
			document.getElementById('first_name').focus();
			return false;
		}
		var lname = document.getElementById('last_name').value;
		if(lname=='' || lname == 'Enter your Last Name'){
			document.getElementById('last_name').focus();
			return false;
		}
		
		var cname = document.getElementById('company_name').value;
		if(cname=='' || (cname=='Enter your Company Name') ){
			document.getElementById('company_name').focus();
			return false;
		}
		
		var email = document.getElementById('email').value;
		if(email=='' || email == 'Enter your Work Email Address'){
			document.getElementById('email').focus();
			return false;
		}else{
			var reg=/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
			if(reg.test(email)==false){
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
					document.getElementById('div_email_status').innerHTML='Enter your Work Email Address';
					document.getElementById('email').focus();
					return false;
				}
			}
		}
		
		var password = document.getElementById('password').value;
		if(password==''){
			document.getElementById('div_password').focus();
			return false;
		}
		
	//document.frm_pci.submit();	
}
function include(arr, obj) {
	  for(var i=0; i<arr.length; i++) {
		if (arr[i].toUpperCase() == obj.toUpperCase()) return true;
	  }
	}
function SignUpEmailChecking(old_email){
	var email=document.getElementById('email').value;
	if(old_email !='' && email != old_email){
		EditUserEmailPCI(email,old_email);
	}//else if(old_email ==''){
		//AddUserPCI(email);
	//}
}
</script>
<script type="text/javascript" src="selectuser_new.js"></script>
</head>
<body onload="document.getElementById('first_name').focus();">
    <!-- ClickTale Top part -->
    <script type="text/javascript">
    var WRInitTime=(new Date()).getTime();
    </script>
    <!-- ClickTale end of Top part -->

	<!-- Header -->
	<div id="header">
		<!-- Shell -->
		<div class="shell">
			 <h1 id="logo"><a class="notext" href="<?=HTTP_SERVER?>index.php">CTOs on the Move</a></h1>
			 <div class="page-title-right">Sign Up</div>
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
			 <div class="step-box">
	  <div class="step4">
	  <div class="step-box-heading">Step 1<br />Submit Payment Details</div>
	  </div>
	  
	    <div class="step2-active">
	    <div class="active-heading">Step 2<br />Provide Contact Information</div>
	    </div>
		  <div class="step5">
		   <div class="step-box-heading"></div>
		  </div>
				</div>
			<!-- step box -->
			<!-- field box -->	
			<div class="step-field-box">
					<form name="frm_pci" id="frm_pci" method="post" action="res-price-process.php?action=PCInformation" onsubmit="return pviValidationNew();">
					<div class="inner-field-box-new">
							<div class="blue-heading-requer">(*) -  required information</div>
							
							<div class="name-field-box">First Name :<span class="blue-star"> *</span></div>	
							<div id="div_first_name" class="field-box">
							<input name="first_name" id="first_name" type="text"  class="text-field" value='<? if($first_name==''){echo 'Enter your First Name';}else{echo $first_name;} ?>'  onfocus="TextBoxOnFocus('div_first_name','first_name','field-box-blue','Enter your First Name');" onblur="TextBoxLossFocus('div_first_name','first_name','field-box','field-box-red','Enter your First Name');" />
							</div>
							
							<div class="name-field-box">Last Name :<span class="blue-star"> *</span></div>	
							<div id="div_last_name" class="field-box">
							<input name="last_name" id="last_name" type="text"  class="text-field" value='<? if($last_name==''){echo 'Enter your Last Name';}else{echo $last_name;} ?>'  onfocus="TextBoxOnFocus('div_last_name','last_name','field-box-blue','Enter your Last Name');" onblur="TextBoxLossFocus('div_last_name','last_name','field-box','field-box-red','Enter your Last Name');" />
							</div>	
							
							<div class="name-field-box">Company :<span class="blue-star"> *</span></div>	
							<div id="div_company_name" class="field-box">
							<input name="company_name" id="company_name" type="text"  class="text-field" value="<? if($company_name==''){echo 'Enter your Company Name';}else{echo $company_name;}?>"  onfocus="TextBoxOnFocus('div_company_name','company_name','field-box-blue','Enter your Company Name');" onblur="TextBoxLossFocus('div_company_name','company_name','field-box','field-box-red','Enter your Company Name');" />
							</div>	
							
							<div class="name-field-box">Phone : </div>	
							<div id="div_phone" class="field-box">
							<input name="phone" id="phone" type="text"  class="text-field" value="<? if($phone==''){echo 'Enter your Phone Number';}else{echo $phone;}?>"  onfocus="TextBoxOnFocus('div_phone','phone','field-box-blue','Enter your Phone Number');" onblur="TextBoxLossFocus('div_phone','phone','field-box','field-box','Enter your Phone Number');" />
							</div>	
							
							<div class="name-field-box">Email :<span class="blue-star"> *</span>
					  		<div id="div_email_status" style="float:right" class="errMsg"><? if($action=='DublicatEmail'){echo 'the email already exists in our system, <a href="'.HTTP_SERVER.'login.php">login here</a>';}elseif($action == 'BannedEmail'){echo 'Enter your Work Email Address';}?></div></div>	
							<div id="div_email" class="field-box">
							<input name="email" id="email" type="text"  class="text-field" value='<? if($email==''){echo 'Enter your Work Email Address';}else{echo $email;} ?>'  onfocus="TextBoxOnFocus('div_email','email','field-box-blue','Enter your Work Email Address');" onblur="TextBoxLossFocus('div_email','email','field-box','field-box-red','Enter your Work Email Address');SignUpEmailChecking('<?=$email?>');" />
							</div>	
							
							<div class="name-field-box">Password :<span class="blue-star"> *</span></div>	
							<div id="div_password" class="field-box">
							<input name="password" id="password" type="password"  class="text-field" value="" onfocus="TextBoxOnFocus('div_password','password','field-box-blue','');" onblur="TextBoxLossFocus('div_password','password','field-box','field-box-red','');" />
							</div>	
							
							<div class="clear-bottom"></div>
							<div class="buttn-box">
							<div class="blue-buttn"><input type="image" name="submit" src="css/images/next-buttn.gif" onmouseover="this.src='css/images/next-buttn-h.gif'" onmouseout="this.src='css/images/next-buttn.gif'"/></div>
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
			<p>&copy; <?=date("Y");?> CTOsOnTheMove. All rights reserved.</p>
		</div>
	</div>
	<!-- end Footer -->
	
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>

<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-6168564-1");
pageTracker._trackPageview();
} catch(err) {}</script>

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