<?php
include("includes/include-top.php");
$action = $_REQUEST['action'];
$login_email = $_REQUEST['login_email'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en-US" xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title><?=$PageTitle;?></title>
<meta name="keywords" content="<?=$PageKeywords?>" />
<meta name="description" content="<?=$PageDescription?>" />
<link rel="shortcut icon" href="images/favicon.jpg" type="image/x-icon" />

<link href="<?=DIR_CSS?>login.css" rel="stylesheet" type="text/css" />
</head>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    
<script type="text/javascript">

function ClassChangeFocus(divid){
	document.getElementById(divid).className="loginboxdivFocus";
}
function ClassChangeBlur(divid){
	document.getElementById(divid).className="loginboxdiv";
}

function getpassval(){
    
    console.log("pas value");
    console.log(document.getElementById("login_pass").value);
}

function check_empty()
{
    var l_em = document.getElementById("login_email").value;
    if(l_em == '')
    {
        document.getElementById("email_message").style.display = 'block';
        return false;
    }    
}

</script>
<body onload="<?PHP if($action==''){echo "document.getElementById('login_email').focus();";}//elseif($action=='Login'){echo "document.getElementById('login_pass').focus();";}?>">
<div class="main-popup">
<div class="top-logo"><a href="<?=HTTP_SERVER?>index.php"><img src="images/logo-top.jpg" width="336" height="44" alt="" title="" border="0" /></a></div>

<div class="round-box-top"><img src="images/top-shadow.jpg" width="460" height="18"  alt="" title="" /></div>
<div class="round-box">
	 <form name="frm_login" method="post" action="res-process.php?action=UserLogin" onsubmit="return check_empty();">
    <div class="inner-field-box">
		<div class="text">
		<div id="email_message" style="display:<?PHP if($action=='LoginEmail' || $action=='LoginEmailPassword'){echo 'block;';}else{ echo 'none;';} ?>">The email is not recognized.&nbsp;<a href="<?=HTTP_SERVER?>provide-contact-information.php">New user?</a></div>Email
		</div>
		
		<div class="field">
		<div id="loginbox_email" <?PHP if($action=='LoginEmail' || $action=='LoginEmailPassword'){echo 'class="loginboxdiv_error"';}else{ echo 'class="loginboxdiv"';} ?>>
		
                     
                <?PHP
                //if($login_email == '')
                //{    
                ?>
                   <!--  <input class="loginbox" name="login_email" id="login_email" type="text"  onfocus="ClassChangeFocus('loginbox_email');" onkeyup="ShowSignUpButton();" onblur="ClassChangeBlur('loginbox_email');"/> -->
                <?PHP
                //}
                //else
                //{    
                ?>
                <input class="loginbox" name="login_email" id="login_email" type="text" value="<?=$login_email?>" onfocus="ClassChangeFocus('loginbox_email');"  onblur="ClassChangeBlur('loginbox_email');"  autocomplete="off" />  <!-- onkeyup="ShowSignUpButton();" -->
		
                
                <?PHP
                //}
                ?>
                
                </div>
		</div> 
		
		<div class="text">
		<div style="display:<?php if($action=='LoginPassword' || $action=='LoginEmailPassword'){echo 'block;';}else{ echo 'none;';} ?>">Incorrect password. Try again?</div>Password		
		</div>
                
		<div class="field1">
                    <div id="loginbox_password" <?PHP if($action=='LoginPassword' || $action=='LoginEmailPassword'){echo 'class="loginboxdiv_error"';}else{ echo 'class="loginboxdiv"';} ?>>
                        <input value="" class="loginbox" name="login_pass" id="login_pass" type="password" onfocus="ClassChangeFocus('loginbox_password');"  onblur="ClassChangeBlur('loginbox_password');"  /> <!-- onkeyup="ShowSignUpButton();" -->
                         <!--<input class="loginbox" name="login_pass" id="login_pass" type="password"  value="<?=$login_email?>" onfocus="ClassChangeFocus('loginbox_password');" onkeyup="ShowSignUpButton();" onblur="ClassChangeBlur('loginbox_password');"  autocomplete="off"  />-->
                    </div>
		</div>
		
		<div class="field">
		<div class="blue-text-left blue-text"><a href="<?=HTTP_SERVER?>forgot-password.php">Forgot Your Password?</a><a href="<?=HTTP_SERVER?>provide-contact-information.php" class="padding-left">New User?</a></div>
		</div>
		
		 <div id="submit_dutton" class="buttn-gray">
                    <!-- <img src="images/gray-signin-buttn.jpg"  alt="Sign Up" title="Sign Up" style="border: 0px none;" /> -->
                     
                     <input name="image" value="Sign Up" src="images/blue-signin-buttn.jpg"  alt="Sign Up" style="border: 0px none;" type="image">
                     
		 </div>
    </div> 
	</form>
</div>

<div class="round-box-bottom"><img src="images/bottom-shadow.jpg" width="460" height="18"  alt="" title="" /></div>


<div class="bottom-coppyright-text">© <?=date("Y");?> CISOsOnTheMove. All rights reserved.</div>

</div>
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


<script language="javascript">

function ShowSignUpButton(){ 
        
        var email_status=true;
	var email = document.getElementById('login_email').value;
	var pass = document.getElementById('login_pass').value;
        
        //alert("Email after : "+email);
        //alert("Email_status: "+email_status);
        //alert("Pass: "+pass);
        //console.log(document.getElementById('login_pass'));
        
	if(email !=''){
		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		   if(reg.test(email) == false) {
			   email_status=false;
		   }
	}
        //alert("Before if");
        
	if(email !='' && email_status && pass !='')
        {
            document.getElementById("email_message").style.display = 'block';
            //document.getElementById('submit_dutton').innerHTML='<input name="image" value="Sign Up" src="images/blue-signin-buttn.jpg"  alt="Sign Up" style="border: 0px none;" type="image">';
	}
        else
        {
            document.getElementById('submit_dutton').innerHTML='<img src="images/gray-signin-buttn.jpg"  alt="Sign Up" title="Sign Up" style="border: 0px none;" />';
	}
}

/*
$(window).bind("load", function() {
   alert("JQ val : "+$("#login_pass" ).val());// code here
});
*/


//document.getElementById("loginbox_password").addEventListener("load", "getpassval");
//setTimeout(function() { ShowSignUpButton(); }, 2000);

//ShowSignUpButton();

/*
window.onload=function() 
{ 
    //alert("AFTER");
    var email = document.getElementById('login_email').value;
    //alert("Email: "+email);
}
*/

</script>
</body>
</html>
