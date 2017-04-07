<?PHP
include("includes/include-top.php");


function com_db_input_this($string) 
{
    return addslashes(trim($string));
}


/*
$dim_url = explode('/', $_SERVER['REQUEST_URI']);
$company_url =$dim_url[sizeof($dim_url)-1];
$company_arr = explode("_",$company_url);
$comsize = sizeof($company_arr);
$company_id = $company_arr[$comsize-1];
*/
$company_id = $_GET['id'];

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


<style>
#comp_update input[type=text]
{
    font-size:16px;
    width:300px;
}

#comp_update select
{
    font-size:16px;
    width:304px;
}
</style>
    
<script>
function check_form()
{
    var f_name = document.getElementById('first_name').value;
    var l_name = document.getElementById('last_name').value;
    var email = document.getElementById('email').value;
    
    var company_name = document.getElementById('company_name').value;
    var company_url = document.getElementById('company_url').value;
    var address = document.getElementById('address').value;
    var city = document.getElementById('city').value;
    var state = document.getElementById('state').value;
    var zip_code = document.getElementById('zip_code').value;
    var phone = document.getElementById('phone').value;
    var company_industry = document.getElementById('company_industry').value;
    var company_revenue = document.getElementById('company_revenue').value;
    var company_employee = document.getElementById('company_employee').value;
    
    //alert("company Name:"+company_name+":");
    //alert("company URL:"+company_url+":");
    //alert("Address:"+address+":");
    
    //alert("City:"+city+":");
    //alert("State:"+state+":");
    
    if(f_name == '' || l_name == '' || email == '')
    {    
        alert("First name, Last Name and Email Fields should be filled");
        return false;
    }
    else
    //if(company_name == '' && company_url == '' && address == '' && city == '' && state == '' && zip_code == '' && phone == '' && company_industry == '' && company_revenue == '' && company_employee == '')
    if(company_name == '' && company_url == '' && address == '' && city == '' && state == '' && zip_code == '' && phone == '' && company_industry == '' && company_revenue == '' && company_employee == '')
    {    
        alert("At least one company related Field should be filled");
        return false;
    }
    else
    {    
        return true;
    }    
        
    //else
    //    return true;
}
</script>    
    
</head>
    
    
<?PHP
$msg = "";
//echo "<pre>REQ: ";   print_r($_REQUEST);   echo "</pre>";
if(isset($_POST['sub_img']) && $_POST['sub_img'] == 1)
{
    //echo "<pre>REQ: ";   print_r($_REQUEST);   echo "</pre>";
    
    $company_id_update = com_db_input_this($_POST['company_id']);
    
    $company_name = com_db_input_this($_POST['company_name']);
    $company_url = com_db_input_this($_POST['company_url']);
    $zip_code = com_db_input_this($_POST['zip_code']);
    $phone = com_db_input_this($_POST['phone']);
    $address = com_db_input_this($_POST['address']);
    $city = com_db_input_this($_POST['city']);
    $state = com_db_input_this($_POST['state']);
    
    $company_industry = com_db_input_this($_POST['company_industry']);
    $company_revenue = com_db_input_this($_POST['company_revenue']);
    $company_employee = com_db_input_this($_POST['company_employee']);
    
    $first_name = com_db_input_this($_POST['first_name']);
    $last_name = com_db_input_this($_POST['last_name']);
    $email = com_db_input_this($_POST['email']);
    
    //$company_name = $_POST['company_name'];
    
    $is_q = "INSERT into cto_company_master_updates(company_id,company_name,company_website,address,city,state,zip_code,phone,company_employee,company_revenue,company_industry,first_name,last_name,email) values('$company_id_update','$company_name','$company_url','$address','$city','$state','$zip_code','$phone','$company_employee','$company_revenue','$company_industry','$first_name','$last_name','$email')";
    $compResult = com_db_query($is_q);
    $msg = "Company details submitted";
}    
?>
    
<body onLoad="initialize();" onfocus="doPopup();">
    <div class="header">
        <div class="shell clearfix">
            <h1 id="new-logo"><a href="<?=HTTP_SERVER?>index.php">CTOs on the Move</a></h1>
            <div class="header-right">
                <div id="navigation">
                    <ul>
                        <?php if($current_page !='index.php'){ ?>
                        <li><a href="<?=HTTP_SERVER?>index.php">Home</a></li>
                        <?PHP } ?>
                        <li><a href="<?=HTTP_SERVER?>advance-search.php">Search</a></li>
                        <li><a href="<?=HTTP_SERVER?>team.html">About Us</a></li>
                        <?PHP if($_SESSION['sess_is_user'] == 1){ ?>
                        <li><?=$_SESSION['sess_username']?>:&nbsp;<a href="<?=HTTP_SERVER?>my-profile.php">Profile</a></li>
                        <li><a href="<?=HTTP_SERVER?>logout.php" class="btn"><span>Log Out</span></a></li>
                        <?PHP }else{ ?>
                        <li><a href="<?=HTTP_SERVER?>pricing.html">Pricing</a></li>
                        <li><a href="<?=HTTP_SERVER?>login.php" class="btn"><span>Login</span></a></li>
                        <?PHP } ?>
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
                <?PHP if($companyRow['linkedin_link'] !='' || $companyRow['googleplush_link'] !='' || $companyRow['twitter_link'] !='' || $companyRow['facebook_link'] !=''){
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
                <?PHP if($companyRow['linkedin_link'] !=''){ ?><a href="<?=$linkedin_url;?>" class="linkedin-icon" rel="nofollow">linkedin</a><? } ?>
                    <?PHP if($companyRow['googleplush_link'] !=''){ ?><a href="<?=$googleplush_url;?>" class="google-icon" rel="nofollow">google</a><? } ?>
                    <?PHP if($companyRow['twitter_link'] !=''){ ?><a href="<?=$twitter_url?>" class="twitter-icon" rel="nofollow">twitter</a><? } ?>
                    <?PHP if($companyRow['facebook_link'] !=''){ ?><a href="<?=$facebook_url?>" class="facebook-icon" rel="nofollow">facebook</a><? } ?>
                <?PHP } ?>
                </div>
                    <!-- /social-media -->

                <div class="profile-name">
                    <h2><?=com_db_output($companyRow['company_name'])?></h2>
                <?PHP
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
                <div class="profile-description" style="margin-top:25px;">
                    
                    
                    
                    
                    <form name="comp_update" id="comp_update" method="post" onsubmit="return check_form()">
                    <table>
                        
                        <?PHP
                        if($msg != '')
                        {    
                        ?>
                        <tr>
                            <td style="margin-top:25px;"><h4 style="color:#ff0000"><?=$msg?></h4></td>
                        </tr>    
                        <?PHP
                        }
                        ?>
                        <tr>
                            <td  colspan="2">
                                <h2>Enter your information so we can get in touch with you if we have questions</h2>
                            </td>
                        </tr>    
                                
                        
                        <tr>
                            <td>Your First Name *</td>
                            <td><input id="first_name" name="first_name" type="text"></td>
                        </tr>  
                        
                        <tr>
                            <td>Your Last Name* </td>
                            <td><input id="last_name" name="last_name" type="text"></td>
                        </tr>  
                        
                        <tr>
                            <td>Your Email *</td>
                            <td><input id="email" name="email" type="text"></td>
                        </tr>  
                        
                        
                        
                        <tr>
                            <td style="padding-top:45px;"  colspan="2">
                                <h2>Enter correct information in the fields below</h2>
                            </td>
                        </tr> 
                        
                        <tr>
                            <td>Company Name</td>
                            <td><input id="company_name" name="company_name" type="text"></td>
                        </tr>  
                        
                        <tr>
                            <td>Company Website</td>
                            <td><input id="company_url" name="company_url" type="text"></td>
                        </tr>  
                        
                        <tr>
                            <td>Address</td>
                            <td><input id="address" name="address" type="text"></td>
                        </tr> 
                        
                        
                        <tr>
                            <td>City</td>
                            <td><input id="city" name="city" type="text"></td>
                        </tr>
                        
                        
                        <tr>
                            <td>State</td>
                            <td>
                                <select name="state" id="state">
                                <option value="">Please select</option>
                                <?=selectComboBox("select state_id,short_name from ".TABLE_STATE." order by short_name","")?>
                                
                                </select>
                            </td>    
                        </tr>
                        <tr>
                            <td>Zip Code</td>
                                <td><input id="zip_code" name="zip_code" type="text"></td>
                        </tr>    
                        
                        <tr>
                            <td>Phone</td>
                            <td><input id="phone" name="phone"  type="text"></td>
                        </tr>    
                        
                        <tr>
                            <td>Industry</td>
                            <td>
                                <?php
                                $industry_result = com_db_query("select * from " . TABLE_INDUSTRY ." where status='0' and parent_id = '0' order by title");
                                ?>
                                <select name="company_industry" id="company_industry" >
                                    <option value="">Please select</option>
                                    <?php
                                    while($indus_row = com_db_fetch_array($industry_result)){
                                    ?>
                                    <optgroup label="<?=$indus_row['title']?>">
                                    <?=selectComboBox("select industry_id,title from ". TABLE_INDUSTRY ." where status='0' and parent_id ='".$indus_row['industry_id']."' order by title" ,"");?>
                                    </optgroup>
                                    <?PHP } ?>
                                    <option value="">Please select</option>
                                </select>
                            </td>    
                        </tr>
                        
                        
                        <tr>
                            <td>Size ($Revenue)</td>
                            <td>
                                <select name="company_revenue" id="company_revenue">
                                <option value="">Please select</option>
                                <?=selectComboBox("select id,name from ".TABLE_REVENUE_SIZE." where status='0' order by from_range","")?>
                                </select>
                            </td>    
                        </tr>
                        
                        
                        
                        <tr>
                            <td>Size (Employees)</td>
                            <td>
                                <?php
                                $industry_result = com_db_query("select * from " . TABLE_INDUSTRY ." where status='0' and parent_id = '0' order by title");
                                ?>
                                <select name="company_employee" id="company_employee">
                                <option value="">Please select</option>
                                <?=selectComboBox("select id,name from ".TABLE_EMPLOYEE_SIZE ." where status='0' order by from_range","")?>
                                </select>
                            </td>    
                        </tr>
                        
                        
                        
                        
                        <tr>
                            <td style="padding-top:10px;" align="center" colspan="2">
                                <input name="sub_img" value="1" type="image" src="images/blue-save-buttn.jpg">
                            </td>
                         </td>   
                        
                    </table>
                        <input type="hidden" name="company_id" id="company_id" value="<?=$company_id?>" />     
                    </form>    
                </div>
            </div>
            <!-- /shell -->
        </div>
        <!-- /profile-cnt -->
    </div>
    <!-- /profile -->

	


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