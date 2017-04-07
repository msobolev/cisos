<?php
include("includes/include-top.php");
$full_name = $_POST['full_name'];
$fullname = explode(' ',$full_name);
$first_name = $fullname[0];
$email = $_POST['email'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en-US" xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
	<title><?=$PageTitle;?></title>
	<meta name="keywords" content="<?=$PageKeywords?>" />
	<meta name="description" content="<?=$PageDescription?>" />
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" href="css/images/favicon.jpg" />
	<link rel="stylesheet" href="css/style_new.css" type="text/css" media="all" />
	<script type='text/javascript'>
	var _vis_opt_account_id = 17805;
	var _vis_opt_protocol = (('https:' == document.location.protocol) ? 'https://' : 'http://');
	document.write('<s' + 'cript src="' + _vis_opt_protocol + 
	'dev.visualwebsiteoptimizer.com/deploy/js_visitor_settings.php?v=1&a='+_vis_opt_account_id+'&url='
	+encodeURIComponent(document.URL)+'&random='+Math.random()+'" type="text/javascript">' + '<\/s' + 'cript>');
	</script>
	
	<script type='text/javascript'>
	if(typeof(_vis_opt_settings_loaded) == "boolean") { document.write('<s' + 'cript src="' + _vis_opt_protocol + 
	'd5phz18u4wuww.cloudfront.net/vis_opt.js" type="text/javascript">' + '<\/s' + 'cript>'); }
	// if your site already has jQuery 1.4.2, replace vis_opt.js with vis_opt_no_jquery.js above
	</script>
	
	<script type='text/javascript'>
	if(typeof(_vis_opt_settings_loaded) == "boolean" && typeof(_vis_opt_top_initialize) == "function") {
			_vis_opt_top_initialize(); vwo_$(document).ready(function() { _vis_opt_bottom_initialize(); });
	}
	</script>

</head>
<body>
	<!-- Header -->
	<div id="header-logo">
		<!-- Shell -->
		<div class="shell" style="padding-left:70px;">
			 <h1 id="logo"><a class="notext" href="index.php">CTOs on the Move</a></h1>
	  </div>
	</div>
	<!-- end Header -->
	<!-- Main -->
	<div id="main-vig-next" style="height:530px;">
		<!-- Shell -->
		<div class="shell">
			<!-- Content -->
			<div class="content">
			<!-- field box -->	
			<div class="vig-next-field-box">
					<div class="thank-you-inner-box-new">
					  <div class="thank-you-heading">
							<br /><br /><br /><br />
							The email you entered is already in use. Please <a href="<?=HTTP_SERVER?>login.php">sign in</a> here. <a href="<?=HTTP_SERVER?>forgot-password.php">Forgot password?</a>
							<br /><br /><br /><br /><br /><br />
					  </div>
					</div>	
					
			</div>	
				<!-- field box -->		
			</div>
			<!-- Content -->
			<div class="cl">&nbsp;</div>
		</div>
		<!-- end Shell -->
	</div>
	
	<!-- end Main -->
	<!-- Footer -->
	<div id="footer">
		<div class="shell" style="padding-left:50px;">
			<p>&copy; <?=date("Y");?> CTOsOnTheMove. All rights reserved.</p>
			<br /><br />
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