<?php
include("includes/include-top.php");
?>
<?php if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?='CTOsOnTheMove.com ::'.$PageTitle;?></title>
<meta name="keywords" content="<?=$PageKeywords?>" />
<meta name="description" content="<?=$PageDescription?>" />
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />

<link href="css/style-aboutus.css" rel="stylesheet" type="text/css" />

</head>

<body>
<!-- ClickTale Top part -->
<script type="text/javascript">
var WRInitTime=(new Date()).getTime();
</script>
<!-- ClickTale end of Top part -->

<img src="http://ad.retargeter.com/px?id=61366&amp;t=2" width="1" height="1" />

<script type="text/javascript" src="//www.hellobar.com/hellobar.js"></script>
<script type="text/javascript">
new HelloBar(53072,87093);
</script>

	<div class="abo_top">
    	<div class="abo_topmid">
        	<div class="abo_topmid_left"><a href="<?=HTTP_SERVER?>index.php"><img src="images/new-logo.png" alt="" /></a></div>
          <div class="abo_topmid_right">
               <? if($_SESSION['sess_is_user'] == 1){ ?>
          		<div class="abo_topmenu">
                <div style="float:left;margin-right:2px;">
                	<ul>
                       <li><a href="<?=HTTP_SERVER?>index.php">Home</a></li>
                       <li><a href="<?=HTTP_SERVER?>why-cto.html">How it Works</a></li>
                       <li><a href="<?=HTTP_SERVER?>my-profile.php"><?=$_SESSION['sess_username']?>:&nbsp;Profile</a></li>
                    </ul>
                    </div>
                    <div style="float:left">
                    <a href="<?=HTTP_SERVER?>logout.php" class="login-btn">Log Out</a>
                    </div>
                </div>
               
              <? }else{ ?>      
				<div class="abo_topmenu">
                	<div style="float:left;margin-right:2px;">
                    <ul>
                       <li><a href="<?=HTTP_SERVER?>index.php">Home</a></li>
                       <li><a href="<?=HTTP_SERVER?>why-cto.html">How it Works</a></li>
                       <li><a href="<?=HTTP_SERVER?>team.html">About us</a></li>
                       <li><a href="pricing.thml">Pricing</a></li>
                      
                    </ul>
                    </div>
                    <div style="float:left;">
                    	<a href="<?=HTTP_SERVER?>login.php" class="login-btn">Login</a>
                    </div>
                </div>
                
               <? } ?>  
          </div>
      </div>
    </div>
    
    <div class="abo_headbg">
    	<div class="abo_headmid">
        	<div class="abo_meet abo_meettext">Meet the Team</div>
        </div>
    </div>
    
    <div class="abo_midmain">
    	<div class="abo_mid">
        	<?php
			    $i = 0;
				$team_query = "select * from " . TABLE_TEAM_ADVISORS ." where type='Team' order by ta_id";
				$team_result = com_db_query($team_query);
				$num_row = com_db_num_rows($team_result);
				while($team_row=com_db_fetch_array($team_result)){
			 ?>
        	<div class="abo_probox">
            	<div class="abo_proboxleft">
                	<div class="rounded-corners"><img src="<?=DIR_TEAM_IMAGE?><?=$team_row['image_path']?>" alt="<?=com_db_output($team_row['name']);?>" title="<?=com_db_output($team_row['name']);?>" /></div>
                </div>
                <div class="abo_proboxright">
                	<div class="abo_prorightin1 abo_protext"><?=com_db_output($team_row['name']);?></div>
                	<div class="abo_prorightin1 abo_protext1"><?=com_db_output($team_row['designation']);?></div>
                	<div class="abo_prorightin2 abo_protext2"><?=com_db_output($team_row['details']);?></div>
                </div>
            </div>
            <? } ?>
            <div class="abo_probox">
            	<div class="abo_mapbox">
                	<!--<iframe width="660" height="340" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.co.in/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=575+Madison+Avenue+New+York,+NY+10022&amp;aq=&amp;sll=22.675949,88.368056&amp;sspn=0.684249,1.344452&amp;ie=UTF8&amp;hq=&amp;hnear=575+Madison+Ave,+New+York,+10022,+United+States&amp;t=m&amp;ll=40.767347,-73.970947&amp;spn=0.022102,0.056562&amp;z=14&amp;iwloc=A&amp;output=embed"></iframe>-->
					<iframe width="660" height="340" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=40+West+38th+street,+5th+Floor,+Manhattan,+NY+10018&amp;aq=&amp;sll=37.0625,-95.677068&amp;sspn=35.90509,86.572266&amp;ie=UTF8&amp;hq=&amp;hnear=40+W+38th+St,+New+York,+10018&amp;t=m&amp;ll=40.758375,-73.98468&amp;spn=0.022105,0.056562&amp;z=14&amp;iwloc=A&amp;output=embed"></iframe><br /><small><a href="https://maps.google.com/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=40+West+38th+street,+5th+Floor,+Manhattan,+NY+10018&amp;aq=&amp;sll=37.0625,-95.677068&amp;sspn=35.90509,86.572266&amp;ie=UTF8&amp;hq=&amp;hnear=40+W+38th+St,+New+York,+10018&amp;t=m&amp;ll=40.758375,-73.98468&amp;spn=0.022105,0.056562&amp;z=14&amp;iwloc=A" style="color:#0000FF;text-align:left">View Larger Map</a></small>                
                </div>
                <div class="abo_mapright">
                <?
				$adminInfo = "select * from ". TABLE_ADMIN_SETTINGS ." where setting_id ='1'";
				$adminResult = com_db_query($adminInfo);
				$adminRow = com_db_fetch_array($adminResult);
				
				$from_admin = $adminRow['site_email_from'];
				$to_admin = $adminRow['site_email_address'];
				
				$site_company_address = com_db_output($adminRow['site_company_address']);
				$site_company_city  = com_db_output($adminRow['site_company_city']);
				$site_company_state = com_db_output($adminRow['site_company_state']);
				$site_company_zip = com_db_output($adminRow['site_company_zip']);
				$site_phone_number = com_db_output($adminRow['site_phone_number']);
				?>
                	<div class="abo_maprightin abo_addtext">We're just right here  </div>
                    <div class="abo_maprightin1 abo_addtext1"><?=$site_company_address?><br />  <?=$site_company_state?>, <?=$site_company_zip?><br /><?=$site_phone_number?></div>
                	<div class="abo_maprightin abo_addtext2"><a href="mailto:<?=$to_admin?>"><?=$to_admin?></a></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="abo_foot">
    	<div class="abo_footmid">
        	<div class="abo_footleft abo_foottext">&copy; <?=date("Y");?> CTOsOnTheMove. All rights reserved.</div>
        </div>
    </div>
    
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