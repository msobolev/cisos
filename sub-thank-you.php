<?php
include("includes/include-top.php");
$regUN = explode(' ', $_REQUEST['ragName']);
$regFirstName = $regUN[0];
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

</head>
<body>


	<!-- Header -->
	<div id="header">
		<!-- Shell -->
		<div class="shell">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="333" align="left" valign="top"><h1 id="logo"><a class="notext" href="<?=HTTP_SERVER?>index.php">CISOs on the Move</a></h1></td>
                <td width="19" align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
                </td>
              </tr>
            </table>
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
			
			<!-- field box -->	
			<div class="step-field-box">
            	<div style="padding:15px">
                	<div style="padding-right:70px;">
                        <br /><br /><div class="welcome-heading-text">Hi <?=$regFirstName;?>!</div><br />
                        <div class="welcome-content-text">Thank you for signing up with CISOsOnTheMove and…  WELCOME ON BOARD!</div>	
                        <div class="welcome-content-text">This is going to be an exciting ride and I'd like to give you a quick preview of what's coming:</div>	
                        <div class="welcome-content-text">
                            <ol>
                                <li><u>Full Access.</u> You now have full unlimited access to the database with 14,000+ profiles of CISOs. You can access this database with the login (your email) and the password you created at signup. You can <a href="http://www.cisosonthemove.com/login.php">login here</a>.</li> 
                                <li><u>Monthly update.</u> Every month you will receive a file with 100+ CISOs and other senior IT Security executives who changed jobs that month, with updated emails, phone numbers, full text of a press release (where available), etc. Look out for it the first week of the month.</li>
                                <li><u>Customer Service.</u> If you have a question, a concern, a suggestion… if there is anything we could do to help you grow your business, please reach out and I'd be happy to help. You can ping me any time at <a href="mailto:support@cisosonthemove.com" >support@cisosonthemove.com</a> or 646.812.6814 and I'd be happy to help.</p></li>
                                <li><u>Free resources.</u> As you can tell, we've been helping companies like Gartner, AMD, Telwares, Fujitsu and others for a while and over time accumulated best practices, benchmarks, strategies, tips and shortcuts that produce results. Here is a short list that I hope you will get good value from:
                                    <ul  class="new1">
                                        <li type="a"><a href="http://www.ctosonthemove.com/white_paper/CTOsOnTheMove%20-%20TriggerEvents.pdf/" target="_blank">Free eBook: How to Use Sales Trigger Events to Grow Sales</a></li>
                                        <li type="a"><a href="http://blog.ctosonthemove.com/5-advanced-techniques-to-get-10x-sales-leads-from-your-industry-events/" target="_blank">5 Advanced Techniques to Get 10x Sales Leads from Your Industry Events</a></li>
                                        <li type="a"><a href="http://blog.ctosonthemove.com/25-stealthy-techniques-to-maximize-b2b-lead-generation-on-facebook-part-1" target="_blank">25 Techniques to Maximize B2B Lead Generation on Facebook</a></li>
                                        <li type="a"><a href="http://blog.ctosonthemove.com/10-sneaky-tricks-to-leverage-linkedin-for-b2b-lead-generation/" target="_blank">10 Sneaky Tricks to Leverage LinkedIn for B2B Lead Generation</a></li>
                                        <li type="a"><a href="http://blog.ctosonthemove.com/top-30-productivity-tools-for-overworked-salespeople/" target="_blank">30 Productivity Tools for Overworked Salespeople </a></li>	
                                        <li type="a"> <a href="http://blog.ctosonthemove.com/top-30-technology-research-companies-you-must-follow-in-2012/" target="_blank">Top 30 Technology Research Companies You Must Follow in 2012</a></li>
                                        <li type="a"> <a href="http://blog.ctosonthemove.com/20-must-follow-technology-marketing-blogs-for-2012/" target="_blank">20 Must-Follow Technology Marketing Blogs </a><br /><br /></li>
                                    </ul>    
                                </li>
                                <li><u>Blog.</u> We publish free updates and resources constantly on our blog. Feel free to keep track of news and updates at <a href="http://blog.ctosonthemove.com/" target="_blank">CTOsOnTheMove's blog</a>.</li>
                            </ol>
                        </div>
                        <div class="welcome-content-text">
                        Thank you for trusting us. I am looking forward to working with and your team on helping to grow your business with the timely, actionable and unique insights we provide.
                        <br /><br />
                        Best,
                        <br /><br />
                        -Misha
                         <br /><br />
                         Managing Partner<br />
                         CISOsOnTheMove
                        <br /><br />
                        <img src="team_photo/thumb/Misha-image-1278918507.jpg" title="" alt="" />
                        </div>	
                    </div>
                    	
                  </div> 
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