<?php
include("includes/include-top.php");

$sub_query = "select * from " . TABLE_SUBSCRIPTION ;
$sub_result = com_db_query($sub_query);
while($sub_row = com_db_fetch_array($sub_result)){
	if($sub_row['subscription_name'] == 'Basic'){
		$basic_sub_id = $sub_row['sub_id'];
		$basic_subscription_name = com_db_output($sub_row['subscription_name']);
		$basic_sub_header = com_db_output($sub_row['sub_header']);
		$basic_sub_footer = com_db_output($sub_row['sub_footer']);
		$basic_email_updates = com_db_output($sub_row['email_updates']);
		$basic_search_database = com_db_output($sub_row['search_database']);
		$basic_download_contacts = com_db_output($sub_row['download_contacts']);
		$basic_price = com_db_output($sub_row['price']);
		$basic_amount = $sub_row['amount'];
	}elseif($sub_row['subscription_name'] == 'Standard'){
		$standard_sub_id = $sub_row['sub_id'];
		$standard_subscription_name = com_db_output($sub_row['subscription_name']);
		$standard_sub_header = com_db_output($sub_row['sub_header']);
		$standard_sub_footer = com_db_output($sub_row['sub_footer']);
		$standard_email_updates = com_db_output($sub_row['email_updates']);
		$standard_search_database = com_db_output($sub_row['search_database']);
		$standard_download_contacts = com_db_output($sub_row['download_contacts']);
		$standard_price = com_db_output($sub_row['price']);
		$standard_amount = $sub_row['amount'];
	}elseif($sub_row['subscription_name'] == 'Professional'){
		$professional_sub_id = $sub_row['sub_id'];
		$professional_subscription_name = com_db_output($sub_row['subscription_name']);
		$professional_sub_header = com_db_output($sub_row['sub_header']);
		$professional_sub_footer = com_db_output($sub_row['sub_footer']);
		$professional_email_updates = com_db_output($sub_row['email_updates']);
		$professional_search_database = com_db_output($sub_row['search_database']);
		$professional_download_contacts = com_db_output($sub_row['download_contacts']);
		$professional_price = com_db_output($sub_row['price']);
		$professional_amount = $sub_row['amount'];
	}
}
?>
<?

$log_history_query="select * from " .TABLE_LOGIN_HISTORY." where last_respond_time >0 and add_date = '".date('Y-m-d')."' and log_status='Login'";
$log_history_result = com_db_query($log_history_query);
while($log_history_row = com_db_fetch_array($log_history_result)){
	if($log_history_row['last_respond_time'] > 0)
	$tot_off_time = time()-$log_history_row['last_respond_time'];
	if($tot_off_time > 600){
		$log_history_update = "update ".TABLE_LOGIN_HISTORY." set log_status='Logout', logout_time='".time()."' where add_date = '".date('Y-m-d')."' and log_status='Login' and user_id='".$log_history_row['user_id']."'";
		com_db_query($log_history_update);
	}
}
if($_SESSION['sess_payment'] == 'Not Complited'){
	if($current_page == 'provide-contact-information.php' || $current_page == 'choose-subscription.php' || $current_page == 'submit-payment.php'){
	//not redirect;
	}else{
		echo $url = "provide-contact-information.php?action=back&resID=".$_SESSION['sess_user_id'];
		com_redirect($url);
	}
}
if ($_SESSION['sess_user_id'] !='' and $_SESSION['sess_user_id'] > 0 ){
	
	$log_history_update = "update ".TABLE_LOGIN_HISTORY." set last_respond_time='".time()."' where add_date = '".date('Y-m-d')."' and log_status='Login' and user_id='".$_SESSION['sess_user_id']."'";
	com_db_query($log_history_update);
}
$asin = $_REQUEST['asin'];

?>	

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en-US" xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <title><? echo 'CTOsOnTheMove.com ::';?> <?=$PageTitle;?></title>
    <meta name="keywords" content="<?=$PageKeywords?>" />
    <meta name="description" content="<?=$PageDescription?>" />

	<link rel="shortcut icon" href="css_new/images/favicon.jpg" />
	<link rel="stylesheet" href="css_new/style-price.css" type="text/css" media="all" />
	<script src="js_new/jquery-1.7.2.min.js" type="text/javascript"></script>
	<script src="js_new/functions_price.js" type="text/javascript"></script>
</head>

<body>
<!-- ClickTale Top part -->
<script type="text/javascript">
var WRInitTime=(new Date()).getTime();
</script>
<!-- ClickTale end of Top part -->

<!-- Header -->
<div id="header">
	<div class="shell">
		<h1 id="logo"><a href="<?=HTTP_SERVER?>index.php" class="notext">CTOsOnTheMove</a></h1>
		<div id="navigation">
			<br />
            <br />
           
		</div>
		<div class="cl">&nbsp;</div>
        
		<div class="headerCaption">Actionable Real-Time Sales Leads for Technology Companies</div>
	</div>
</div>

<!-- End of Header -->
<!-- Main -->
<div id="main">
	<div class="shell">
		<div id="top-content">
        	<br />
            <br />
           
			<h3><span>Currently this offer is unavailable, for today's best price <a href="<?=HTTP_SERVER?>pricing.html">click here</a>.</span></h3>
            	
		</div>
		<!-- end of #top-content -->
		
	</div>
</div>
<!-- End of Main -->
<!-- Footer -->
<!--<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />-->

<div style="position:absolute;width:100%;bottom:0;background: #ececec url(images/footer.png) repeat-x 0 0;">
	<div style="width:70%;margin:0 auto;">
		<p style="padding:20px 0;width:100%;">© <?=date("Y");?> CTOsOnTheMove. All rights reserved.</p>
	</div>
</div>
<!-- End of Footer -->
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