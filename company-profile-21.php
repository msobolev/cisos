<?
include("includes/include-top.php");

$dim_url = explode('/', $_SERVER['REQUEST_URI']);
$company_url =$dim_url[sizeof($dim_url)-1];
$company_arr = explode("_",$company_url);
$comsize = sizeof($company_arr);
$company_id = $company_arr[$comsize-1];
if(trim($company_id)==''){
	$url ='not-found.php';
	com_redirect($url);
}elseif(trim($company_id)!=''){
	$isCompanyID = com_db_GetValue("select company_id from ".TABLE_COMPANY_MASTER." where company_id='".$company_id."'");
	if($isCompanyID==''){
		$url ='not-found.php';
		com_redirect($url);
	}
}
$companyQuery = 'select cm.*,rs.name as revenue,es.name as employee,s.short_name,ind.title,s.state_name,c.countries_name,c.countries_iso_code_3 from '					
				.TABLE_COMPANY_MASTER. ' as cm, '
				.TABLE_REVENUE_SIZE. ' as rs, '
				.TABLE_EMPLOYEE_SIZE. ' as es, '
				.TABLE_INDUSTRY. ' as ind, '
				.TABLE_STATE. ' as s, '
				.TABLE_COUNTRIES. ' as c' 
				.' where cm.company_revenue=rs.id and cm.company_employee=es.id and cm.state = s.state_id and cm.country=c.countries_id and cm.industry_id=ind.industry_id and cm.company_id = "'.$company_id.'"';
$companyResult = com_db_query($companyQuery);
$companyRow = com_db_fetch_array($companyResult);
$company_address = com_db_output($companyRow['address'].' '.$companyRow['address2'].', '.$companyRow['short_name'].', '.$companyRow['countries_iso_code_3'].', '.$companyRow['zip_code']);
$comp_domain_name='';
if($companyRow['company_website'] !=''){
	$comp   = array("http://wwww.", "www.","https://www.","http://","https://");
	$comp_domain_name = str_replace($comp,'',$companyRow['company_website']);
	$comp_domain_name =' @'. $comp_domain_name;
}	

$PageTitle = com_db_output($companyRow['company_name']).', '.com_db_output($companyRow['city']).', '.com_db_output($companyRow['short_name']);
$PageKeywords=com_db_output($companyRow['company_name']).', Email, '.$comp_domain_name.', executives, ceo, cfo, vp, address, addresses, e-mail, management';
$PageDescription="CTOsOnTheMove's profile for ".com_db_output($companyRow['company_name']).' with executive profiles for CEO, CIO, CFO, CMO info including email address, '.$comp_domain_name.', linkedin, biography';
?>
<?php if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<title><?=$PageTitle;?></title>
	<meta name="keywords" content="<?=$PageKeywords?>" />
	<meta name="description" content="<?=$PageDescription?>" />
    
	<link rel="stylesheet" href="css/company-personal-style.css" type="text/css" media="all" />
	<link rel="shortcut icon" type="image/x-icon" href="css_new/images/favicon.jpg" />

	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css' />
	<link href='http://fonts.googleapis.com/css?family=Bitter:400,400italic,700' rel='stylesheet' type='text/css' />

	<!--<script src="js/jquery-1.7.2.min.js" type="text/javascript"></script>-->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" type="text/javascript"></script>
    <script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<script src="js/functions.js" type="text/javascript"></script>
    <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>
<script>
var geocoder2 = new google.maps.Geocoder();

var geocoder;
var map;
var marker;  
  

function initialize() { 
	var latLng = new google.maps.LatLng('40.761998', '-73.97254599999997'); 
//GoogleMap type
    var googlemaps_type = google.maps.MapTypeId.ROADMAP;

  map = new google.maps.Map(document.getElementById('map_canvas'), {
    zoom: 15,
    center: latLng,
	scrollwheel: false,

	mapTypeId: googlemaps_type
    //mapTypeId: google.maps.MapTypeId.ROADMAP
	//mapTypeId: google.maps.MapTypeId.SATELLITE
	//mapTypeId: google.maps.MapTypeId.HYBRID
	//mapTypeId: google.maps.MapTypeId.TERRAIN
  });
 
   //GEOCODER
  geocoder = new google.maps.Geocoder();

  marker = new google.maps.Marker({
    position: latLng,
    map: map,
    draggable: true
  });

  // Update current position info.
  updateMarkerPosition(latLng);
  geocodePosition(latLng);
  
  // Add dragging event listeners.
  google.maps.event.addListener(marker, 'dragstart', function() {
    updateMarkerAddress('Dragging...');
  });
  
  google.maps.event.addListener(marker, 'drag', function() {
    updateMarkerStatus('Dragging...');
    updateMarkerPosition(marker.getPosition());
  });
  
  google.maps.event.addListener(marker, 'dragend', function() {
    updateMarkerStatus('Drag ended');
    geocodePosition(marker.getPosition());
  });
}


function updateMarkerStatus(str) {
  document.getElementById('markerStatus').innerHTML = str;
}

function updateMarkerPosition(latLng) {
	jQuery('#lat').val(latLng.lat());
	jQuery('#lng').val(latLng.lng());
}

function updateMarkerAddress(str) {
  document.getElementById('address').innerHTML = str;
}

function codeAddress() {
    var address = document.getElementById("address").value;
	 geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
	  //alert(results[0].geometry.location);
        map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
            map: map,
            position: results[0].geometry.location,
            draggable: true
        });
      } else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    });
  }
  
function doPopup() {
	delay = 1;    // time in seconds before popup opens
	timer = setTimeout("codeAddress();", delay*40);
	}
function Show_Profile(profileShow,profileClose,less,more){
	document.getElementById(profileShow).style.display='block';
	document.getElementById(profileClose).style.display='none';
	document.getElementById(more).style.display='none';
	document.getElementById(less).style.display='block';
}
function Hide_Profile(profileShow,profileClose,less,more){
	document.getElementById(profileShow).style.display='none';
	document.getElementById(profileClose).style.display='block';
	document.getElementById(more).style.display='block';
	document.getElementById(less).style.display='none';
}
	
function ShowJobDetails(jobDetailsID){
	if(document.getElementById(jobDetailsID).style.display=='none'){
		document.getElementById(jobDetailsID).style.display='block';
	}else{
		document.getElementById(jobDetailsID).style.display='none';
	}
}	
</script>

</head>
<body onLoad="initialize();" onfocus="doPopup();">
	<div class="header">
		<div class="shell clearfix">
			<h1 id="new-logo"><a href="<?=HTTP_SERVER?>index.php">CTOs on the Move</a></h1>

			<div class="header-right">
				<? if($_SESSION['sess_is_user'] == 1){ ?>
				<a href="<?=HTTP_SERVER?>logout.php" class="login-btn">Log Out</a>
				<? }else{ ?>
				<a href="<?=HTTP_SERVER?>login.php" class="login-btn">Login</a>
				<? } ?>
				<div id="navigation">
					<ul>
						<li><a href="<?=HTTP_SERVER?>index.php">Home</a></li>
						<li><a href="<?=HTTP_SERVER?>why-cto.html">How it Works</a></li>
						<li><a href="<?=HTTP_SERVER?>team.html">About us</a></li>
						<li><a href="<?=HTTP_SERVER?>pricing.html">Pricing</a></li>
					</ul>
				</div>
				<!-- /navigation -->
			</div>
			<!-- /header-right -->
		</div>
		<!-- /shell -->
	</div>
	<!-- /header -->

	<div class="profile company-profile">
		<div class="profile-heading">
			<div class="shell clearfix">
				<div class="social-media clearfix">
                	<? if($companyRow['linkedin_link'] !='' || $companyRow['googleplush_link'] !='' || $companyRow['twitter_link'] !='' || $companyRow['facebook_link'] !=''){
						$linkedin = explode('//', $companyRow['linkedin_link']);
						if(sizeof($linkedin)>1){
							$linkedin_url = $linkedin[0].'//'.$linkedin[1];
						}else{
							$linkedin_url = 'http://'.$linkedin[0];
						}
						$googleplush = explode('//', $companyRow['googleplush_link']);
						if(sizeof($googleplush)>1){
							$googleplush_url = $googleplush[0].'//'.$googleplush[1];
						}else{
							$googleplush_url = 'http://'.$googleplush[0];
						}
						$twitter = explode('//', $companyRow['twitter_link']);
						if(sizeof($twitter)>1){
							$twitter_url = $twitter[0].'//'.$twitter[1];
						}else{
							$twitter_url = 'http://'.$twitter[0];
						}
						$facebook = explode('//', $companyRow['facebook_link']);
						if(sizeof($facebook)>1){
							$facebook_url = $facebook[0].'//'.$facebook[1];
						}else{
							$facebook_url = 'http://'.$facebook[0];
						}
						?>
					<p>Social Media:</p>
                    <? if($companyRow['linkedin_link'] !=''){ ?><a href="<?=$linkedin_url;?>" class="linkedin-icon" rel="nofollow">linkedin</a><? } ?>
					<? if($companyRow['googleplush_link'] !=''){ ?><a href="<?=$googleplush_url;?>" class="google-icon" rel="nofollow">google</a><? } ?>
					<? if($companyRow['twitter_link'] !=''){ ?><a href="<?=$twitter_url?>" class="twitter-icon" rel="nofollow">twitter</a><? } ?>
					<? if($companyRow['facebook_link'] !=''){ ?><a href="<?=$facebook_url?>" class="facebook-icon" rel="nofollow">facebook</a><? } ?>
                    <? } ?>
				</div>
				<!-- /social-media -->

				<div class="profile-name">
					<h2><?=com_db_output($companyRow['company_name'])?></h2>
                    <?
					$company_url = $companyRow['company_website'];
					$domain = strstr($company_url, '://');
					if($domain==''){
						$company_website = "http://".$company_url ;
					}else{
						$company_website = $company_url ;
					}
					?>
					<a href="<?=$company_website?>" rel="nofollow"><?=com_db_output($companyRow['company_website'])?></a>
				</div>
			</div>
			<!-- /shell -->
		</div>
		<!-- /profile-heading -->
		<div class="profile-cnt">
			<div class="shell clearfix">
				<div class="profile-description">
                	<? if($companyRow['company_logo'] !='') { ?>
					<div class="profile-img" style="background-color:#FFF;">
						<img src="<?=HTTP_CTO_URL?>company_logo/thumb/<?=$companyRow['company_logo']?>" alt="" style="position:absolute;top:0;bottom:0;margin:auto;"/>
                    </div>
					
                     <? }else{ echo '<br>';}?>
					<!-- /profile-img -->
					<div class="cl">&nbsp;</div>
					<?		$about_company= $companyRow['about_company'];
                        	$about_arr = explode(" ",$about_company);
							$about_company_short='';
							if(sizeof($about_arr)>100){
								for($j=0;$j<100;$j++){
									if($about_company_short==''){
										$about_company_short= $about_arr[$j];
									}else{
										$about_company_short .= " ".$about_arr[$j];
									}
								}
								$about_company_short .= " ...";
							}else{
								$about_company_short= $about_company;
							}
							?>
                        	<div id="divAboutShot"><?php echo $about_company_short;?></div>
                            <? if(sizeof($about_arr)>100){ ?>
                        	<div id="divAboutDescription" style="display:none;"><?php echo $about_company;?></div>
                            <div id="divMore" style="display:block">
                              <a href="javascript:Show_Profile('divAboutDescription','divAboutShot','divLess','divMore');">More>></a>
                             </div>
                            
                             <div id="divLess" style="display:none">
                                <a href="javascript:Hide_Profile('divAboutDescription','divAboutShot','divLess','divMore');">&lt;&lt;Less</a>
                             </div>
                             <? } ?>
					<ul class="company-list">
						<li>
							<strong><span class="ico employ-ico"></span>Number of Employees:</strong>
							<?
							echo $company_employee = $companyRow['employee']
							?>
						</li>
						<li>
							<strong><span class="ico revenue-ico"></span>Annual Revenue:</strong>
                            <?
							echo $company_revenue = $companyRow['revenue'];
							?>
						</li>
					</ul>
					</div>

				<div class="profile-info">					
					<ul class="address-list">
						<li>
							<span class="ico link-ico"></span>
							<a href="<?=$company_website?>" rel="nofollow"><?=com_db_output($companyRow['company_website'])?></a>
						</li>
						<li>
							<span class="ico pin-ico"></span>
							<?=com_db_output($companyRow['address'].' '.$companyRow['address2'])?><br />
							<?=com_db_output($companyRow['city'].', '.$companyRow['short_name'].' '.$companyRow['countries_iso_code_3'].' '.$companyRow['zip_code'])?>
						</li>
                        <? if($companyRow['phone']!=''){?>
						<li>
							<span class="ico phone-ico"></span>
							Phone: <?=com_db_output($companyRow['phone']);?>
						</li>
                        <? } ?>
                         <? if($companyRow['fax']!=''){?>
						<li>
							<span class="ico fax-ico"></span>
							Fax: <?=com_db_output($companyRow['fax']);?>
						</li>
                        <? } ?>
					</ul>

					<div class="map-holder">
                    <input  id="address" name="address" type="hidden" onblur="codeAddress()" value="<?=com_db_output($companyRow['address'].' '.$companyRow['address2'].', '.$companyRow['short_name'].', '.$companyRow['countries_iso_code_3'].', '.$companyRow['zip_code'])?>" />
                    <div id="map_canvas" style="width: 310px; height: 200px;"></div>
                    </div>
					<!-- /map-holder -->
				</div>
			</div>
			<!-- /shell -->
		</div>
		<!-- /profile-cnt -->
	</div>
	<!-- /profile -->

	<div class="company-section table-section">
		<div class="shell">
			<h2>Executives</h2>
			<?
			$perExeQuery ="select mm.personal_id,pm.first_name,pm.last_name,mm.title from ".TABLE_MOVEMENT_MASTER." as mm, ".TABLE_PERSONAL_MASTER." as pm where mm.personal_id=pm.personal_id and mm.company_id='".$company_id."' order by mm.personal_id desc limit 0,5";
			$perExeResult = com_db_query($perExeQuery);
			?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<th>Name</th>
					<th>Title</th>
					<th>Contact Details</th>
				</tr>
                <? while($perExeRow = com_db_fetch_array($perExeResult)){?>
				<tr>
					<td><h5><a href="<?=HTTP_SERVER?><?=com_db_output($perExeRow['first_name'].'_'.$perExeRow['last_name'])."_Exec_".$perExeRow['personal_id']?>"><?=com_db_output($perExeRow['first_name'].' '.$perExeRow['last_name'])?></a></h5></td>
					<td><?=com_db_output($perExeRow['title'])?></td>
					<td><a href="<?=HTTP_SERVER?><?=com_db_output($perExeRow['first_name'].'_'.$perExeRow['last_name'])."_Exec_".$perExeRow['personal_id']?>" class="profile-btn">Profile<span class="arrow"></span></a></td>
				</tr>
				<? } ?>
			</table>
		</div>
		<!-- /shell -->
	</div>
	<!-- /table-section -->
	<?
	$jobQuery = "select * from ".TABLE_COMPANY_JOB_INFO." where company_id='".$company_id."' order by post_date desc limit 0,5";
	$jobResult = com_db_query($jobQuery);
	if($jobResult){
		$job_num_row = com_db_num_rows($jobResult);
	}
	if($job_num_row>0){
	?>
	<div class="company-section jobs-section">
		<div class="shell">
        	
			<h2>Jobs</h2>
			<? 
				if($job_num_row>0){
					$i=1;
					while($jobRow = com_db_fetch_array($jobResult)){
				?>
            		 <? $job_desc =explode(" ", $jobRow['description']);
						$job_description='';
						if(sizeof($job_desc)>50){
							for($j=0;$j<50;$j++){
								if($job_description==''){
									$job_description= $job_desc[$j];
								}else{
									$job_description .= " ".$job_desc[$j];
								}
							}
							$job_description .= " ...";
						}else{
							$job_description= com_db_output($jobRow['description']);
						}
						
					?>
                    <div class="job">
                        <h4><a href="javascript:ShowJobDetails('job_details_<?php echo $i?>');"><?=com_db_output($jobRow['job_title']);?><? if($tot_day_diff<=30){echo '<span class="new-ico"></span>';}?></a></h4>
                        <div id="job_details_<?php echo $i?>" style="display:none;"><?php echo com_db_output($jobRow['description']);?></div>
                        <div class="meta">
                            <strong><?=com_db_output($companyRow['company_name'])?></strong>
                            <small><?=com_db_output($jobRow['location'])?></small>
                        </div>
                        
                        	<div id="job_shot_<?php echo $i?>"><?php echo $job_description;?></div>
                            <? if(sizeof($job_desc)>50){ ?>
                        	<div id="job_<?php echo $i?>" style="display:none;"><?php echo com_db_output($jobRow['description']);?></div>
                            <div id="more_<?=$i?>" style="display:block">
                              <a href="javascript:Show_Profile('job_<?php echo $i?>','job_shot_<?php echo $i?>','less_<?=$i?>','more_<?=$i?>');">More>></a>
                             </div>
                            
                             <div id="less_<?=$i?>" style="display:none">
                                <a href="javascript:Hide_Profile('job_<?php echo $i?>','job_shot_<?php echo $i?>','less_<?=$i?>','more_<?=$i?>');">&lt;&lt;Less</a>
                             </div>
                             <? } ?>
                        <!-- /jobs-options -->
                    </div>
                    <!-- /job -->
				<? 	$i++;
					}
				}else{ ?>
                	<div class="job">
                        <h4>Jobs not available</h4>
                    </div>    
             <? } ?>
		</div>
		<!-- /shell -->
	</div>
	<!-- /jobs-section -->
	<? } ?>
	<div class="company-section companies-list">
		<div class="shell">
			<h2>Similar Companies</h2>
			<?
				$compQuery ="select company_id, company_name, company_website, company_logo, about_company from ".TABLE_COMPANY_MASTER." where company_id !='".$company_id."' and industry_id='".$companyRow['industry_id']."' ORDER BY RAND() LIMIT 5";
				$compResult = com_db_query($compQuery);
				if($compResult){
					$comp_num_rows = com_db_num_rows($compResult);
				}
				if($comp_num_rows>0){
					while($compRow = com_db_fetch_array($compResult)){?>
                    <div class="company">
                    	<? if($compRow['company_logo'] !='') { ?>
                        <div class="company-img">
                            <a href="<?=HTTP_SERVER?><?=preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''), com_db_output($compRow['company_name'])).'_Company_'.$compRow['company_id']?>"><img src="<?=HTTP_CTO_URL?>company_logo/small/<?=$compRow['company_logo'];?>" alt="<?=com_db_output($compRow['company_name']);?>" /></a>
                        </div>
                        <? } ?>
                        <!-- /company-img -->
                        <div class="company-cnt">
                            <h4><a href="<?=HTTP_SERVER?><?=preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''), com_db_output($compRow['company_name'])).'_Company_'.$compRow['company_id']?>"><?=com_db_output($compRow['company_name']);?></a></h4>
        
                            <p>
                               <?=$compRow['about_company'];?>
                            </p>
                        </div>
                        <!-- /company-cnt -->
                    </div>
                    <!-- /company -->
				<? 	}			
			    }else{ ?>
			<div class="company">
				
				<!-- /company-img -->
				<div class="company-cnt">
					<h4>Company not available</h4>
				</div>
				<!-- /company-cnt -->
			</div>
			<!-- /company -->
			<? } ?>
			
			<!-- /company -->
		</div>
		<!-- /shell -->
	</div>
	<!-- /companies-list -->

	<!-- Footer -->
	<div id="footer">
		<div class="shell">
			<p class="copy">© <?=date("Y");?> CTOsOnTheMove. All rights reserved.</p>
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