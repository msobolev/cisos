<tr>
      <td align="left"  valign="top">&nbsp;</td>
      <td align="left" valign="top"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
  	  <? if($current_page=='index.php'){ ?>
	   <tr>
        <td align="left" valign="top">
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td width="43%" align="left" valign="middle" class="directry-heading-text">IT Executives Directory</td>
					<td width="57%" align="left" valign="middle" class="directry-heading-text">Company Directory</td>
				</tr>
				<tr>
					<td align="left" valign="middle" class="pagination-link-text">
					 <?
					for($i=65; $i<=90; $i++){
						$char_cnt = com_db_GetValue("select count(pm.first_name) as cnt from " .TABLE_MOVEMENT_MASTER ." mm, ". TABLE_PERSONAL_MASTER . " pm where mm.personal_id=pm.personal_id and pm.first_name like '".chr($i)."%'");
						if($char_cnt > 0){
							echo '<a href="'.HTTP_SERVER.'executives-list.php?action=EName&amp;char='.chr($i).'">'.chr($i).'</a> ';
						}	
					}
					?>
					</td>
					<td align="left" valign="middle" class="pagination-link-text">
					 <?
					for($c=65; $c<=90; $c++){
						$char_cnt = com_db_GetValue("select count(cm.company_name) as cnt from " . TABLE_MOVEMENT_MASTER . " mm, ".TABLE_COMPANY_MASTER." cm where mm.company_id=cm.company_id and cm.company_name like '".chr($c)."%'");
						if($char_cnt > 0){
							echo '<a href="'.HTTP_SERVER.'company-list.php?action=CName&amp;char='.chr($c).'">'.chr($c).'</a> ';
						}	
					}
					?>						
					</td>
				</tr>	
		  </table>
		</td>
      </tr>
	  <? } ?>
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


<?PHP
if($_SESSION['sess_user_id'] == '')
{    
?>



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

<?PHP
}
?>


</body>
</html>
