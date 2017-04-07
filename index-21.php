<?php
include("includes/include-top.php");

$action = $_REQUEST['action'];
if($action == 'Activate'){
	$activate_id= $_REQUEST['act_id'];
	$activate_query = "update " . TABLE_USER . " set status = '0' where user_id='".$activate_id."'";
	com_db_query($activate_query);
	$user_name = com_db_GetValue("select concat(first_name,' ',last_name) from " . TABLE_USER . " where user_id='".$activate_id."'");
	session_register('sess_is_user','sess_user_id' , 'sess_username');
	$_SESSION['sess_is_user'] = 1;
	$_SESSION['sess_user_id'] = $activate_id;
	$_SESSION['sess_username'] = $user_name;
}
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
		$url = "provide-contact-information.php?action=back&resID=".$_SESSION['sess_user_id'];
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
	<title><? if($current_page!='vigilant-appoints.php'){echo 'CTOsOnTheMove.com ::';}?> <?=$PageTitle;?></title>
	<meta name="keywords" content="<?=$PageKeywords?>" />
	<meta name="description" content="<?=$PageDescription?>" />

	<link rel="shortcut icon" href="css_new/images/favicon.jpg" />
	<link rel="stylesheet" href="css_new/jquery.jscrollpane.css" type="text/css" media="all" />
	<link rel="stylesheet" href="css_new/ui-lightness/jquery-ui-1.8.19.custom.css" type="text/css" media="all" />
	<link rel="stylesheet" href="css_new/style-index.css" type="text/css" media="all" />
	
	<script src="js_new/jquery-1.7.1.min.js" type="text/javascript"></script>
	<script src="js_new/jquery.jcarousel.js" type="text/javascript"></script>
	<script src="js_new/jquery.mousewheel.js" type="text/javascript"></script>
	<script src="js_new/jquery.jscrollpane.js" type="text/javascript"></script>
	<script src="js_new/jquery-ui-1.8.19.custom.min.js" type="text/javascript"></script>
	<script src="js_new/functions.js" type="text/javascript"></script>
	<script src="js_new/script.js" type="text/javascript"></script>
	<script type="text/javascript">
			//<![CDATA[
			
			var cnt=6;
		
			function ContentDivControl(){
				var tot_cnt = document.getElementById('total_cnt_number').value;
				
				if(tot_cnt > 6){
					var showDivStart = tot_cnt - cnt;
					
					if(showDivStart == 0 || tot_cnt <= 6){
						cnt=5;
						showDivStart = tot_cnt - cnt;
					}
					for(pp=1; pp<=tot_cnt; pp++){
						var closeDiv = 'DivCnt_' + pp;
						document.getElementById(closeDiv).style.display="none";
					}
					
					for(cc=0; cc<=5; cc++){
						if(cc==0){
							var start_div = 'DivCnt_' + showDivStart;
						}
						var opDiv = 'DivCnt_' + showDivStart;
						document.getElementById(opDiv).style.display="block";
						if(cc==0){
							document.getElementById(start_div).style.backgroundColor="#e9f6ff";
						}else if(cc%2==0){
							document.getElementById(opDiv).style.backgroundColor="#f7f7f7";
						}else{
							document.getElementById(opDiv).style.backgroundColor="#ffffff";
						}
						showDivStart++;
					}
					fadeEffect.init(start_div, 1);
					fadeEffect.init(start_div, 0);
					fadeEffect.init(start_div, 1);
					cnt++;
				}else{
					fadeEffect.init('DivCnt_1', 1);
					fadeEffect.init('DivCnt_1', 0);
					fadeEffect.init('DivCnt_1', 1);
					
				}	
			}
			
			function ContactShow() {
				setInterval("ContentDivControl()", 3000);
			}
			//]]>		
		</script>
  		<script type="text/javascript">
			(function() {
			window._pa = window._pa || {};
			// _pa.orderId = "myUser@email.com"; // OPTIONAL: include your user's email address or order ID
			// _pa.revenue = "19.99"; // OPTIONAL: include dynamic purchase value for the conversion
			// _pa.onLoadEvent = "sign_up"; // OPTIONAL: name of segment/conversion to be fired on script load
			var pa = document.createElement('script'); pa.type = 'text/javascript'; pa.async = true;
			pa.src = ('https:' == document.location.protocol ? 'https:' : 'http:') + "//tag.perfectaudience.com/serve/506dfecacd65350002000023.js";
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(pa, s);
			})();
		</script>

</head>
<body onload="ContactShow();">
<img src="http://ad.retargeter.com/seg?add=570783&amp;t=2" alt="" width="1" height="1" />
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
		<h2>Actionable Real-Time Sales Leads for Technology Companies</h2>
	</div>	
</div>
<!-- End of Header -->
	
<!-- Main -->
<div id="main">
	<div class="shell">
		<div id="top-content">
			<div class="banner">
			<?	$total_movement = com_db_GetValue("select count(move_id) from ".TABLE_MOVEMENT_MASTER." where status=0");
				$last_date = date("Y-m-d",mktime(0,0,0,date("m"),(date("d")-50),date(Y)));//30
				$total_30day_movement = com_db_GetValue("select count(move_id) from ".TABLE_MOVEMENT_MASTER." where effective_date >'".$last_date."' and status=0");
			?>
				<div class="number">
					<span><?=$total_30day_movement?></span>				
				</div>
				<div class="cnt">
					<h3>Senior IT Executives who changed jobs in the last 30 days – out of  <span class="darkbg"><?=number_format($total_movement,0,0,",")?></span>  CIOs, CTOs in our database.</h3>
					<a href="<?=HTTP_SERVER?>provide-contact-information.php" class="banner-btn">Engage them now as potential clients</a>
				</div>
			</div>
			<div class="pic-slider">
				<ul>
				<?  $slide_result = com_db_query("select caption,image_path from ".TABLE_SLIDER_SHOW." where status=0");
					while($slideRow = com_db_fetch_array($slide_result)){
					?>
					<li><img src="<?=HTTP_SERVER?>slide_photo/small/<?=$slideRow['image_path']?>" alt="<?=com_db_output($slideRow['caption'])?>" title="<?=com_db_output($slideRow['caption'])?>" /></li>
				<? } ?>
				</ul>
			</div>
			<div class="cl">&nbsp;</div>
		</div>
		<!--<div width="961" style="border:1px solid green;" >&nbsp;</div>-->
		<!-- /#top-cntent -->
		
		<div id="content">
			<div class="content">
				<h3>CIOs and CTOs Recent Appointments and Promotions:</h3>
				<div class="listing">
					<div id="DivContactListing" class="table" >
						
						<?
						$last_add_date = com_db_GetValue("select max(announce_date) from ".TABLE_MOVEMENT_MASTER." where status=0 order by announce_date desc");
						$ladt = explode("-",$last_add_date);
						$last30Day = date("Y-m-d",mktime(0,0,0,$ladt[1],($ladt[2]-50),$ladt[0]));//30
						
						$movementResult = com_db_query("select m.title,m.movement_url,m.personal_id,m.announce_date,p.first_name,p.last_name,m.company_id from ".TABLE_MOVEMENT_MASTER." as m, ".TABLE_PERSONAL_MASTER." as p where m.personal_id=p.personal_id and m.status=0 and m.announce_date>='".$last30Day."' order by announce_date desc");
						if($movementResult){
							$per_num_rows = com_db_num_rows($movementResult);
						}
						$rem_contact = $per_num_rows-6;
						$ind=1;
						while($moveRow = com_db_fetch_array($movementResult)){
							$adt = explode("-",$moveRow['announce_date']);
							$adt_format = date("d-M-Y",mktime(0,0,0,$adt[1],$adt[2],$adt[0]));
							$adt_now = explode("-",$adt_format);
							$HL =explode(' ', com_db_output($moveRow['first_name'].' '.$moveRow['last_name']).' was Appointed as '.com_db_output($moveRow['title']));
							$headline ='';
							for($h=0; $h<sizeof($HL); $h++){
								if(strlen($headline)<=55){
									$headline .= $HL[$h].' ';
								}	
							}
							$headline .= ' <a href="'.HTTP_SERVER.$moveRow['movement_url'].'">more></a>';
							if($ind < ($per_num_rows-6)){
							?>
								
								<div id="DivCnt_<?=$ind?>" class="main_content" style="display:none;">
									<div class="dateleft1">
										<div class="datebg_new">
											<strong><?=$adt_now[0]?></strong><span><?=$adt_now[1]?></span>
                                            <strong></strong>
										</div>
									</div>
									<div class="dateleft2"><?=$headline?></div>
									<div class="dateleft3"><a href="<?=HTTP_SERVER?><? if($_SESSION['sess_is_user'] == 1){ echo $moveRow['movement_url'];}else{echo 'provide-contact-information.php';}?>">Get Contact Details</a></div>
									<div style="clear:both;"></div>
								</div>
						<?  } else{
								if($ind == ($per_num_rows-6)){ 
									$div_class = 'buebg';
								}elseif($ind%2 == 0){
									$div_class = 'whitebg1';
								}else{
									$div_class = 'grybg1';
								}	
								?>
								<div id="DivCnt_<?=$ind?>" class="main_content <?=$div_class;?>">
									<div class="dateleft1">
										<div class="datebg_new">
											<strong><?=$adt_now[0]?></strong><span><?=$adt_now[1]?></span>
                                            <strong></strong>
										</div>
									</div>
									<div class="dateleft2"><?=$headline;?></div>
									<div class="dateleft3"><a href="<?=HTTP_SERVER?><? if($_SESSION['sess_is_user'] == 1){ echo $perRow['movement_url'];}else{echo 'provide-contact-information.php';}?>">Get Contact Details</a></div>
									<div style="clear:both;"></div>
								</div>
								<?
							} 
						$ind++;
						} ?>
					</div>
					<input type="hidden" name="total_cnt_number" id="total_cnt_number" value="<?=$per_num_rows?>" />
					<div class="banner">
						<a href="<?=HTTP_SERVER?>provide-contact-information.php" class="banner-btn">GET STARTED NOW </a>
						<h3>Get Their Updated Contact Details Now</h3>
					</div>
				</div>
			</div>
			<div class="aside">
				<h3>Filter Updates By:</h3>
				<script type="text/javascript" src="selectuser-index.js"></script>
				<div id="filters">
				
					<form name="frmSearch" method="post" action="">
                    	<input type="hidden" name="islogin" id="islogin" value="<?=$_SESSION['sess_is_user']?>" />
						<div class="row">
							<div class="section">
								<h4>Industry</h4>
								<div class="check-section">
									<?
									$ind=1;
									$industry_result = com_db_query("select industry_id,title from " . TABLE_INDUSTRY ." where parent_id='0' and status=0");
									$tot_ind_num = com_db_num_rows($industry_result);
									while($ind_group_row = com_db_fetch_array($industry_result)){ ?>
									<div class="row">
										<span class="ch-field"><input type="checkbox" name="industry[]" id="industry_<?=$ind;?>" value="<?=$ind_group_row['industry_id']?>" /></span>
										<label class="ch-label"><?=str_replace("&","&amp;", com_db_output($ind_group_row['title']))?></label>
										<div class="cl">&nbsp;</div>
									</div>
									<? 
									$ind++;
									} ?>	
									<input type="hidden" name="ind_num" id="ind_num" value="<?=$tot_ind_num?>" />
								</div>
							</div>
							<div class="section">
								<h4>Revenue <span class="gray"><span class="val1">0</span>  - <span class="val2">>$1 bil</span></span></h4>
								<div class="val-slider revenue-slider">
									
								</div>
								<input type="hidden" name="revenue" id="revenue" value="0||>$1 bil" />
							</div>
							<div class="section">
								<h4>Employees <span class="gray"><span class="val1">1</span> - <span class="val2">>100K</span></span></h4>
								<div class="val-slider employee-slider">
									
								</div>
								<input type="hidden" name="employee" id="employee" value="1||>100K" />
							</div>
							<div class="section">
								<h4>Geography</h4>
								
								<div class="check-section sec2">
									<?
									$st=1;
									$country_result = com_db_query("select countries_id,countries_name from " . TABLE_COUNTRIES ." where countries_id=223 or countries_id=38 order by countries_name desc");
									while($country_row = com_db_fetch_array($country_result)){ 
									$count_state = com_db_GetValue("select count(state_id) from " . TABLE_STATE ." where country_id='".$country_row['countries_id']."' ");
									$tot_state_num = $tot_state_num + $count_state
									?>				
									<div class="row">
										<span class="ch-field"><input type="checkbox" name="country_name" id="country_name_<?=$country_row['countries_id']?>" value="<?=$country_row['countries_id']?>" onclick="CountryCheck('<?=$country_row['countries_id']?>','<?=$count_state?>');"/></span>
										<label class="ch-label"><?=com_db_output($country_row['countries_name'])?></label>
										<div class="cl">&nbsp;</div>
									</div>
									<div class="fieldset">
										<?
										$state_result = com_db_query("select state_id,state_name from " . TABLE_STATE ." where country_id='".$country_row['countries_id']."' order by short_name");
										while($state_row = com_db_fetch_array($state_result)){ 
										?>			
											<div class="row">
												<span class="ch-field"><input type="checkbox" name="state_id[]" id="state_<?=$st;?>" value="<?=$state_row['state_id']?>" /></span>
												<label class="ch-label"><?=$state_row['state_name']?></label>
												<div class="cl">&nbsp;</div>
											</div>
										<? 
										$st++;	
										} ?>
									</div>
									<? } ?>
									<input type="hidden" name="state_num" id="state_num" value="<?=$tot_state_num?>" />
								</div>	
								
							</div>
							
						</div>
					</form>
				</div>
			</div>
			<div class="cl">&nbsp;</div>
			<div class="partners">
				<h2>CTOsOnTheMove Provides Real Time Sales Leads to the Best Technology Companies: </h2>
				<div class="wrap">
					<?
					$pcResult = com_db_query("select * from ".TABLE_POTENTIAL_CLIENTS." where status=0");
					while($pcRow = com_db_fetch_array($pcResult)){
					?>
					<a href="<?=$pcRow['site_url']?>" rel="nofollow"><img src="<?=HTTP_SERVER?>clients_logo/<?=$pcRow['image_path']?>" alt="<?=$pcRow['caption']?>" title="<?=$pcRow['caption']?>" /></a>
					<? } ?>
				</div>
				<h2 class="invert"><span>We Connect You with Your Potential Clients</span></h2>
			</div>
		</div>
		<!-- /#content -->
		<div id="bottom-content">
			<div class="col">
				<h3>What You Get</h3>
				<ul class="service">
					<li>
						<img src="css_new/images/i1.png" class="icon" alt="" />
						<h4>Full Access to Database</h4>
						<p>Search, browse and download CIO profiles with their contact details in real-time. 14,000 profiles of decision makers at your finger tips.</p>
					</li>
					<li>
						<img src="css_new/images/i2.png" class="icon" alt="" />
						<h4>Timely Updates</h4>
						<p>Get real-time updates when CIOs, CTOs and VPs of Technology/Information Services get appointed or promoted, with updated contact details.</p>
					</li>
					<li>
						<img src="css_new/images/i3.png" class="icon" alt="" />
						<h4>Sales Growth</h4>
						<p>Engage new potential clients and expand your business relationship with existing customers when they are most likely to be researching buying decisions.</p>
					</li>
				</ul>
			</div>
			<div class="col">
				<h3>What Our Clients Say</h3>
				<div class="testimonials">
					<div class="item">
						<div class="entry">
							<div class="entry-i">
								<p>“CTOsOnTheMove has helped us to quickly take advantage of opportunities with key IT leaders, creating real client engagements and extraordinary return on investment."</p>
							</div>
						</div>
						<div class="author">
							<img src="css_new/images/Michael-Voellinger.jpg" alt="" />
							<p>Michael Voellinger, EVP</p>
							<p class="gray">Telwares</p>
							<div class="cl">&nbsp;</div>
						</div>
					</div>
					<div class="item type2">
						<div class="entry">
							<div class="entry-i">
								<p>“CTOsOnTheMove has become a valuable piece of our lead generation portfolio, providing high quality candidates at a fraction of the cost of traditional lead generation sources.”</p>
							</div>
						</div>
						<div class="author">
							<img src="css_new/images/Jennifer-Sipala.jpg" alt="" />
							<p>Jennifer Sipala, Marketing Director</p>
							<p class="gray">Unitrends</p>
							<div class="cl">&nbsp;</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col">
				<h3>What to Browse for Free</h3>
				<ul class="service type2">
					<li>
						<img src="css_new/images/i4.png"  class="icon" alt="" />
						<h4>IT Executive Directory</h4>
						<p>
						<?
						for($i=65; $i<=90; $i++){
							$char_cnt = com_db_GetValue("select count(pm.first_name) as cnt from " .TABLE_MOVEMENT_MASTER ." mm, ". TABLE_PERSONAL_MASTER . " pm where mm.personal_id=pm.personal_id and pm.first_name like '".chr($i)."%'");
							if($char_cnt > 0){
								echo '<a href="'.HTTP_SERVER.'executives-list.php?action=EName&amp;char='.chr($i).'">'.chr($i).'</a> ';
							}	
						}
						?>
						</p>
					</li>
					<li>
						<img src="css_new/images/i5.png" class="icon"  alt="" />
						<h4>Company Directory</h4>
						<p>
						<?
						for($c=65; $c<=90; $c++){
							$char_cnt = com_db_GetValue("select count(cm.company_name) as cnt from " . TABLE_MOVEMENT_MASTER . " mm, ".TABLE_COMPANY_MASTER." cm where mm.company_id=cm.company_id and cm.company_name like '".chr($c)."%'");
							if($char_cnt > 0){
								echo '<a href="'.HTTP_SERVER.'company-list.php?action=CName&amp;char='.chr($c).'">'.chr($c).'</a> ';
							}	
						}
						?>	
						</p>
					</li>
				</ul>
			</div>
			<div class="cl">&nbsp;</div>
		</div>
		<!-- /#bottom-content -->
	</div>	
</div>
<!-- End of Main -->

<!-- Footer -->
<div id="footer">
	<div class="shell">
		<div class="cols">
			<div class="col">
				<h4>About Us</h4>
				<ul>
					<li><a href="<?=HTTP_SERVER?>why-cto.html">Why CTOsOnTheMove</a></li>
					<li><a href="<?=HTTP_SERVER?>pricing.html">Pricing</a></li>
					<li><a href="<?=HTTP_SERVER?>team.html">The Team</a></li>
					<li><a href="<?=HTTP_SERVER?>partners.html">Partners</a></li>
					<li><a href="<?=HTTP_SERVER?>press-news.html">Press / News</a></li>
				</ul>
			</div>
			<div class="col">
				<h4>Resources</h4>
				<ul>
					<li><a href="<?=HTTP_SERVER?>advance-search.php">Advanced Search</a></li>
					<li><a href="<?=HTTP_SERVER?>browse.php">Browse</a></li>
					<li><a href="<?=HTTP_SERVER?>white-paper.html">White Papers</a></li>
					<li><a href="<?=HTTP_SERVER?>faq.html">FAQ</a></li>
					<li><a href="<?=HTTP_SERVER?>privacy-policy.html">Privacy Policy</a></li>
				</ul>
			</div>
			<div class="col last">
				<h4>Connect</h4>
				<ul>
					<li><a href="<?=com_db_GetValue("select social_url from " .TABLE_SOCIAL_LINK . " where social_name='Blog'");?>"><img src="css_new/images/s1.png" alt="" />Read our Blog</a></li>
					<li><a href="<?=com_db_GetValue("select social_url from " .TABLE_SOCIAL_LINK . " where social_name='Twitter'");?>"><img src="css_new/images/s2.png" alt="" />Follow us on Twitter</a></li>
					<li><a href="<?=com_db_GetValue("select social_url from " .TABLE_SOCIAL_LINK . " where social_name='Facebook'");?>"><img src="css_new/images/s3.png" alt="" />Become a fan on Facebook</a></li>
					<li><a href="<?=com_db_GetValue("select social_url from " .TABLE_SOCIAL_LINK . " where social_name='Linkedin'");?>"><img src="css_new/images/s4.png" alt="" />Connect with us on LinkedIn</a></li>
					<li><a href="<?=HTTP_SERVER?>contact-us.html"><img src="css_new/images/s5.png" alt="" />Contact Us</a></li>
				</ul>
			</div>
			<div class="cl">&nbsp;</div>
		</div>
		<p class="copy">© <?=date("Y");?> CTOsOnTheMove. All rights reserved.&nbsp;&nbsp;<a href="<?=HTTP_SERVER?>terms-use.html" style="text-decoration:underline; color:#000;">Terms of Service</a></p>
	</div>	
</div>
<!-- End of Footer -->
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