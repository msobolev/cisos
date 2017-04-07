<!-- Footer -->
<?php if($current_page=='movement.php'){ ?>
	<div id="footer_vigilant">
		<div class="shell">
            <div class="vig_footer_link">&copy; <?=date("Y");?> CTOsOnTheMove. All rights reserved.</div>
            <div class="vig_footer_link"><a href="<?=HTTP_SERVER?>contact-us.html">Contact</a> | <a href="<?=HTTP_SERVER?>why-cto.html">About Us</a> | <a href="<?=HTTP_SERVER?>terms-use.html">Terms of Service</a></div>
		</div>
	</div>
 <? }else{ ?>
 	<div id="footer">
		<div class="shell">
			<p>&copy; <?=date("Y");?> CTOsOnTheMove. All rights reserved.</p>
		</div>
	</div>
 <? } ?>
	    
	<!-- end Footer -->
	<div id="light" class="white_content" style="display:none;">
		<div class="inner">
			<form name="frm_sign_up" id="sign_up_popup" method="post" action="movement-next.php?action=MovementAppoints&amp;mid=<?=$mmRow['move_id']?>" onsubmit="return SignUpPopUpValidation();">
				<input type="hidden" name="referring_links" id="referring_links" value="<?=$current_page?>"/>
                <div class="top-bg">
                    <div class="close-buttn"><a href="javascript:;" onclick="SignUpClose();"><img src="css/images/blank.gif" width="35" height="33" alt="" border="0" title=""/></a></div>
    <!--			<div class="heading">Looking to Contact <?//=com_db_output($contact_row['first_name']);?> <?//=com_db_output($contact_row['last_name']);?>?<br />Get Instant Access to <?//=com_db_output($contact_row['first_name']);?>'s Email Now – Free!</div>-->
                    <div class="heading">Download <?=com_db_output($contact_row['first_name']);?>'s Email Now – FREE! </div>
                </div>

                <div class="middle-inner-bg">
					<div class="field-box"><input type="text" name="full_name" id="full_name_popup" class="newtextboxbg"  value="Type your First and Last Name here" onfocus=" if (this.value == 'Type your First and Last Name here') { this.value = ''; }" onblur="if (this.value == '') { this.value='Type your First and Last Name here';} "  /></div>
					<div id="div_email_popup" class="field-box"><input type="text" name="email" id="email_popup" class="newtextboxbg" value="Type your Work email address here"  onfocus="EmailPopupFocus();" onblur="EmailPopupBlur();" /></div>
					<div class="text-box">We will send you <?=com_db_output($contact_row['first_name']);?> <?=com_db_output($contact_row['last_name']);?>'s contact details shortly to the email you provided. <br /> We take your <a href="<?=HTTP_SERVER?>privacy-policy.html" class="newlink">email privacy</a> seriously.</div>
				</div>
				<div class="lower-bg"><input name="popup" type="image" src="css/images/contact-details-buttn.jpg" /></div>
			</form>	
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