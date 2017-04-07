<?php
include("includes/include-top.php");

include(DIR_INCLUDES."header-content-page.php");

//send_email_admin();
?>	 
    <!-- heading start -->
 <div style="margin:0 auto; width:960px;">
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	 <tr>
        <td colspan="2" align="left" valign="top" class="caption-text">
		<?=com_db_GetValue("select page_content from " .TABLE_PAGE_CONTENT . " where page_name='index.php' and page_title='Page Heading'")?>
		</td>
    </tr>
    <tr><td colspan="2">&nbsp;</td></tr>
 
    <!-- content start -->
  <tr>
    <td width="21" align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top"><table width="608" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
       <td width="605" align="left" valign="top"><img src="<?=HTTP_SITE_URL?>images/specer.gif" width="1" height="50" alt="" title="" /></td>
      </tr>
	  <tr>
       <td align="center" valign="top" class="not-found">Page not found</td>
      </tr>
	   <tr>
       <td align="left" valign="top"><img src="<?=HTTP_SITE_URL?>images/specer.gif" width="1" height="15" alt="" title="" /></td>
      </tr>
      <tr>
        <td align="center" valign="top" class="not-found-text">We were unable to find the page that you requested. We may have moved it recently, or changed its name. Use the link below to help locate the information that you are looking for or use <a href="<?=HTTP_SITE_URL?>site-map.php">Site Map</a></td>
      </tr>
      <tr>
      <td align="left" valign="top"><img src="<?=HTTP_SITE_URL?>images/specer.gif" width="1" height="100" alt="" title="" /></td>
      </tr>
    </table></td>
  </tr>
</table></td>
    <td width="21" align="left" valign="top">&nbsp;</td>
  </tr>
  <!-- content end-->
  
<tr>
      <td align="left"  valign="top">&nbsp;</td>
      <td align="left" valign="top"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
  	 
	   <tr>
        <td align="left" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" valign="top" class="copyright-text">Copyright &copy; <?=date("Y");?> CTOsOnTheMove. All rights reserved.</td>
      </tr>
      <tr>
        <td align="center" valign="top">&nbsp;</td>
      </tr>
      </table></td>
      <td align="left"  valign="top">&nbsp;</td>
    </tr>
</table>
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
