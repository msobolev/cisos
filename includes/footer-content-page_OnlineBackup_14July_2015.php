<div class="footer-inner">
    <div class="shell">
        <div class="footer-cols clearfix">
            <div class="foo-col foo-col1">
                <h2>About Us</h2>
                <ul>
					<li><a href="<?=HTTP_SERVER?>why-cto.html">Why CTOsOnTheMove</a></li>
                    <li><a href="<?=HTTP_SERVER?>team.html">The Team</a></li>
					<li><a href="<?=HTTP_SERVER?>partners.html">Partners</a></li>
					<li><a href="<?=HTTP_SERVER?>press-news.html">Press / News</a></li>
                    <li><a href="<?=HTTP_SERVER?>faq.html">FAQ</a></li>
				</ul>
            </div><!-- /.foo-col foo-col1 -->

            <div class="foo-col foo-col1">
                <h2>Resources</h2>
                <ul>
                    <li><a href="<?=HTTP_SERVER?>terms-use.html">Terms of Use</a></li>
					<li><a href="<?=HTTP_SERVER?>copyright-policy.html">Copyright Policy</a></li>
                    <li><a href="<?=HTTP_SERVER?>privacy-policy.html">Privacy Policy</a></li>
                    <li><a href="<?=HTTP_SERVER?>pricing.html">Pricing</a></li>
					<li><a href="<?=HTTP_SERVER?>site-map.html">Site Map</a></li>
				</ul>
            </div><!-- /.foo-col foo-col1 -->

            <div class="foo-col foo-col1">
                <h2>Connect</h2>
                <ul class="ico-social">
                    <li><a href="<?=com_db_GetValue("select social_url from " .TABLE_SOCIAL_LINK . " where social_name='Blog'");?>" class="ico-blog">Read our Blog</a></li>
					<li><a href="<?=com_db_GetValue("select social_url from " .TABLE_SOCIAL_LINK . " where social_name='Twitter'");?>" class="ico-twitter">Follow us on Twitter</a></li>
					<li><a href="<?=com_db_GetValue("select social_url from " .TABLE_SOCIAL_LINK . " where social_name='Facebook'");?>" class="ico-facebook">Become a fan on Facebook</a></li>
					<li><a href="<?=com_db_GetValue("select social_url from " .TABLE_SOCIAL_LINK . " where social_name='Linkedin'");?>" class="ico-linkedin">Connect with us on LinkedIn</a></li>
					<li><a href="<?=HTTP_SERVER?>contact-us.html" class="ico-mail">Contact Us</a></li>
                </ul>
            </div><!-- /.foo-col foo-col1 -->
        </div><!-- /.footer-cols -->

        <p class="copyright">&copy; <?=date("Y");?> CTOsOnTheMove. All rights reserved.</p><!-- /.copyright -->
    </div><!-- /.shell -->
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
