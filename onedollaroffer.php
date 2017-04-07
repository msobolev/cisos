<?php
include("includes/include-top.php");

$offer_url = explode('/', $_SERVER['REQUEST_URI']);
$offerUrl = $offer_url[sizeof($offer_url)-1];
$isPresent = com_db_GetValue("select sub_id from ".TABLE_FREE_SUBSCRIPTION_ONOFF." where offer_url='".$offerUrl."'"); 
if($isPresent !=''){
	$free_subscription_on_off = com_db_GetValue("select on_off from ".TABLE_FREE_SUBSCRIPTION_ONOFF." where sub_id='".$isPresent."'");
	if($free_subscription_on_off=='OFF'){
		$url ='offer-off-page.php';
		com_redirect($url);
	}
	$free_subscription_price = number_format(com_db_GetValue("select amount from ".TABLE_FREE_SUBSCRIPTION_ONOFF." where sub_id='".$isPresent."'"),0);
}else{
	$url ='offer-off-page.php';
	com_redirect($url);
}
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
    <link rel="stylesheet" href="css_new/one_doller_price.css" type="text/css" media="all" />
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
        	
			<ul>
				<li><a href="<?=HTTP_SERVER?>why-cto.html">How it Works</a></li>
				<li><a href="<?=HTTP_SERVER?>team.html">About Us</a></li>
				<li><a href="<?=HTTP_SERVER?>pricing.html">Pricing</a></li>
				<? if($_SESSION['sess_is_user'] == 1){ ?>
				<li><a href="<?=HTTP_SERVER?>logout.php" class="btn"><span>Log Out</span></a></li>
				<? }else{ ?>
				<li><a href="<?=HTTP_SERVER?>login.php" class="btn"><span>Login</span></a></li>
				<? } ?>
			</ul>
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
			<h3><span>Get Updated Emails of IT Execs Who Recently Changed Jobs to Instantly Engage Them as Your Prospective Clients.</span></h3>
            	<script type="text/ecmascript">
					function SubscriptionSelect(subid){
						document.getElementById('radio_sub_id').value = subid;
						document.getElementById('frmChooscSub').submit();
					}
				</script>
				<form method="post" name="frmChooscSub" id="frmChooscSub" action="res-1dollar-price-process.php?action=ChoosePricing">
                	<input type="hidden" name="referring_links" id="referring_links" value="<?=$current_page?>"/>
                	<input type="hidden" name="offer_price" id="offer_price" value="<?=$free_subscription_price?>" />
                    <div class="pricing-table">
                        <?
                           $sub_alert_result =com_db_query("select * from ".TABLE_SUBSCRIPTION_ALERT);
                           while($saRow = com_db_fetch_array($sub_alert_result)){
                                if($saRow['caption_name'] =='Email Updates'){
                                     $email_update_alert = com_db_output($saRow['description']);
                                }
                                if($saRow['caption_name'] =='Search of the Database'){
                                    $search_database_alert = com_db_output($saRow['description']);
                                }
                                if($saRow['caption_name'] =='Download Contacts'){
                                    $download_contacts_alert = com_db_output($saRow['description']);
                                }
                            }
                            ?>	
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <th width="180">&nbsp;</th>
                                <th width="180"><em>Professional</em><strong style="background:url(images/cross.png) bottom center  no-repeat;">$<?=$professional_amount?></strong><span>/mo</span></th>
                                <th class="blue"  width="180"><em>Standard</em><strong style="background:url(images/cross.png) bottom center no-repeat;">$<?=$standard_amount?></strong><span>/mo</span></th>
                                <th width="180"><em>Basic</em><strong style="background:url(images/cross.png) bottom center no-repeat;">$<?=$basic_amount?></strong><span>/mo</span></th>
                                <th rowspan="7" class="t-cell">
                                    <div class="testimonials" style="height:375px;">
                                        <h5>Our Clients Say:</h5>
                                        <div class="item">
                                            <div class="entry">
                                                <div class="entry-i">
                                                    <p>CTOsOnTheMove has helped us to create real client engagements..</p>
                                                </div>
                                            </div>
                                            <div class="author">
                                                <img src="css_new/images/Michael-Voellinger.jpg" alt="" />
                                                <p>Michael Voellinger, EVP</p>
                                                <p class="gray">Telwares</p>
                                                <div class="cl">&nbsp;</div>
                                            </div>
                                        </div>
                                        <br /><br />
                                        <div class="item type2">
                                            <div class="entry">
                                                <div class="entry-i">
                                                    <p>CTOsOnTheMove has become a valuable piece of our lead generation portfolio.</p>
                                                </div>
                                            </div>
                                            <div class="author">
                                                <img src="css_new/images/Jennifer-Sipala.jpg" alt="" />
                                                <p>Jennifer Sipala, Marketing</p>
                                                <p class="gray">Unitrends</p>
                                                <div class="cl">&nbsp;</div>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                            <tr class="blue">
                                <td class="first">&nbsp;</td>
                                <td class="one_doller_price" align="center"><strong>$<?=$free_subscription_price?></strong><br /><span>for the first month</span></td>
                                <td class="one_doller_price_blue" align="center"><strong>$<?=$free_subscription_price?></strong><br /><span>for the first month</span></td>
                                <td class="one_doller_price" align="center"><strong>$<?=$free_subscription_price?></strong><br /><span>for the first month</span></td>
                            </tr>
                            <tr>
                                <td class="first">Choose if you'd like to:</td>
                                <td><?=$professional_sub_header?></td>
                                <td class="blue"><?=$standard_sub_header?></td>
                                <td><?=$basic_sub_header?></td>
                            </tr>
                            <tr class="blue">
                                <td class="first">Email Updates 
                                    <span class="tip">
                                        <span class="balloon">
                                            <span class="top">&nbsp;</span>
                                            <span class="center"><?=$email_update_alert?></span>
                                            <span class="bottom">&nbsp;</span>
                                        </span>
                                    </span>
                                </td>
                                <td><? if(strtolower($professional_email_updates)=='yes'){echo '<img src="css_new/images/check.png" alt="" />';}else{echo '<img src="css_new/images/red-cross.gif" alt="" />';}?></td>
                                <td class="blue"><? if(strtolower($standard_email_updates)=='yes'){echo '<img src="css_new/images/check.png" alt="" />';}else{echo '<img src="css_new/images/red-cross.gif" alt="" />';}?></td>
                                <td><? if(strtolower($basic_email_updates)=='yes'){echo '<img src="css_new/images/check.png" alt="" />';}else{echo '<img src="css/images/red-cross.gif" alt="" />';}?></td>
                            </tr>
                            <tr>
                                <td class="first">Database Searches 
                                    <span class="tip">
                                        <span class="balloon">
                                            <span class="top">&nbsp;</span>
                                            <span class="center"><?=$search_database_alert?></span>
                                            <span class="bottom">&nbsp;</span>
                                        </span>
                                    </span>
                                </td>
                                <td><? if(!ctype_digit($professional_search_database)){echo $professional_search_database;}else{ echo $professional_search_database.' searches / month';}?></td>
                                <td class="blue"><? if(!ctype_digit($standard_search_database)){echo $standard_search_database;}else{ echo $standard_search_database.' searches / month';}?></td>
                                <td><? if(!ctype_digit($basic_search_database)){echo $basic_search_database;}else{ echo $basic_search_database.' searches / month';}?></td>
                            </tr>
                            <tr class="blue">
                                <td class="first">Download Contacts 
                                    <span class="tip">
                                        <span class="balloon">
                                            <span class="top">&nbsp;</span>
                                            <span class="center"><?=$download_contacts_alert?></span>
                                            <span class="bottom">&nbsp;</span>
                                        </span>
                                    </span>
                                </td>
                                <td><? if(!ctype_digit($professional_download_contacts)){echo $professional_download_contacts;}else{ echo $professional_download_contacts.' profiles / month';}?></td>
                                <td class="blue"><? if(!ctype_digit($standard_download_contacts)){echo $standard_download_contacts;}else{ echo $standard_download_contacts.' profiles / month';}?></td>
                                <td><? if(!ctype_digit($basic_download_contacts)){echo $basic_download_contacts;}else{ echo $basic_download_contacts.' profiles / month';}?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;<input type="hidden" name="radio_sub_id" id="radio_sub_id" /></td>
                                <td><a href="javascript:;" onclick="SubscriptionSelect('<?=$professional_sub_id?>');" class="yellow-btn">Get Started Now >></a></td>
                                <td><a href="javascript:;" onclick="SubscriptionSelect('<?=$standard_sub_id?>');" class="yellow-btn">Get Started Now >></a></td>
                                <td><a href="javascript:;" onclick="SubscriptionSelect('<?=$basic_sub_id?>');" class="yellow-btn">Get Started Now >></a></td>
                            </tr>
                        </table>
                    </div>
				</form>
		</div>
		<!-- end of #top-content -->
		<div class="gray-section">
			<div class="content">
				<h2>Questions You May Ask:</h2>
				<h4>Can I upgrade/downgrade my subscription?</h4>
				<p>Yes, you can change your subscription at any time.</p>
				<h4>Am I locked into a contract?</h4>
				<p>No! You can cancel any time you want without any fees or penalties.</p>
				<h4>How do I contact support?</h4>
				<p>Just drop us a line at <a href="#">support@ctosonthemove.com</a> and we will get on it right away.</p>
				<h4>Where do you get your data?</h4>
				<p>We track in real-time over 50,000 news sources – press releases, company announcements, SEC filings, social media, etc. This fire hose of data is then analyzed, de-duped, updated with contact details and industry taxonomy so that it is immediately actionable for you.</p>
				<h4>Can I cancel my subscription anytime?</h4>
				<p>Yes, you can stop the subscription at any time. Just drop us a line here.</p>
				<h4>Are there any penalties or fees for cancellation?</h4>
				<p>Absolutely not. There are no fees or penalties for cancellation.</p>
				<h4>Does your database include emails and phone numbers?</h4>
				<p>Yes!</p>
				<h4>What if I need to talk to a human being?</h4>
				<p>If you can't find answers on our website or have an urgent question, call Misha Sobolev at 646.812.6814</p>
				<h4>How long have you been in business?</h4>
				<p>We were founded in 2009.</p>
				<h4>Where are you based?</h4>
				<p>We are based in New York City and our research team is in Hyderabad, India.</p>
				<h4>What do I get with subscription?</h4>
				<p>The two main deliverables are 1) regular email updates when CIOs and CTOs change jobs, including their updated emails and 2) full unlimited access to 14,000+ profiles of senior IT executives for searching/browsing/downloading.</p>
				<h4>Who is this service for?</h4>
				<p>Technology marketers, insides sales teams, contact database manager, technology research organizations, conferences and tradeshows, consultants, executive search professionals, real estate executives with datacenter portfolios, custom software development teams, IT outsourcing organizations and many others.</p>
				<h4>Would I get my money back if I don't like the service?</h4>
				<p>Yes. If you don't like the service for any reason and let us know within 30 days of your sign up, we will refund 100% of your subscription fee, no questions asked.</p>
				<h4>Can I share my password?</h4>
				<p>At this point we don't allow concurrent logins, however we offer substantial discounts for corporate packages from 5 licenses and up.</p>
				<h4>Do you offer a free trial?</h4>
				<p>Currently, we offer a full refund of your subscription fee for 30 days from the moment you sign up, so essentially it is a free trial.</p>
				<h4>Why should I chose you, and not ____ (insert company name)?</h4>
				<p>Many companies will offer you oceans of data however you will soon find for yourself that they cannot accurately track in real-time 20-40 million people.</p>
				<h4>Why buy a Swiss Army knife when you really just need a toothpick?</h4>
				<p>If you want to have access to top IT leaders at the moment they are most likely to be researching buying decisions – after they changed jobs – and you don't want to spend a fortune on these insights, try us.</p>
				<h4>Does your feed integrate with Salesforce, Oracle, Dynamics, SugarCRM, etc. ?</h4>
				<p>With a few clicks you can select your target list by company size, geography, title, industry and data of the management change > export into a csv file and > upload to your CRM of choice.</p>
				<h4>What's so important about management changes?</h4>
				<p>Management change is one of the sales triggers – events that change the status quo for your potential clients and made them aware of needs that your product or service can fill. It could be one of the strongest catalysts for your sales opportunities and revenue.</p>
				<h4>How safe is my credit card information?</h4>
				<p>We do not store any credit card information. It was passed seamlessly to our payment gateway provider – PayPal.</p>
			</div>
			<div class="aside">
				<h2>Our Clients:</h2>
				<div class="clients">
					<a href="#"><img src="css_new/images/l1.png" alt="" /></a>
					<a href="#"><img src="css_new/images/l2.png" alt="" /></a>
					<a href="#"><img src="css_new/images/l3.png" alt="" /></a>
					<a href="#"><img src="css_new/images/l4.png" alt="" /></a>
					<a href="#"><img src="css_new/images/l5.png" alt="" /></a>
					<a href="#"><img src="css_new/images/l6.png" alt="" /></a>
					<a href="#"><img src="css_new/images/l7.png" alt="" /></a>
					<a href="#"><img src="css_new/images/l8.png" alt="" /></a>
					<a href="#"><img src="css_new/images/l9.png" alt="" /></a>
					<a href="#"><img src="css_new/images/l10.png" alt="" /></a>
					<a href="#"><img src="css_new/images/l11.png" alt="" /></a>
					<a href="#"><img src="css_new/images/l12.png" alt="" /></a>
				</div>
				<h2>Your Guarantee</h2>
				<div class="guarantee-article">
					<img src="css_new/images/guarantee.png" class="centered" alt="" />
					<h4>100% Money Back Guarantee</h4>
					<p>If you are not fully satisfied by our service and let us know within 30 days of signing up we will <strong>fully refund your subscription fee</strong>, no questions asked! </p>
					<p>Your subscription is <br /><strong>absolutely risk-free</strong> – you have nothing to lose.</p>
				</div>
			</div>
			<div class="cl">&nbsp;</div>
		</div>
	</div>
</div>
<!-- End of Main -->
<!-- Footer -->
<div id="footer">
	<div class="shell">
		<p class="copy">© <?=date("Y");?> CTOsOnTheMove. All rights reserved.</p>
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