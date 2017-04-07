<?php if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><? if($current_page!='movement.php'){echo 'CTOsOnTheMove.com ::';}?> <?=$PageTitle;?></title>
<meta name="keywords" content="<?=$PageKeywords?>" />
<meta name="description" content="<?=$PageDescription?>" />
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
<link href="<?=DIR_CSS?>style.css" rel="stylesheet" type="text/css" />

<? if($current_page=='advance-search.php' || $current_page=='search-result.php' || $current_page=='alert.php'){ ?>
<link rel="stylesheet" href="css/ui-lightness/jquery-ui-1.10.3.custom.min.css" type="text/css" media="all" />
<link rel="stylesheet" href="css/chosen.css" type="text/css" media="all" />
<link rel="stylesheet" href="css/style-search-alert.css" type="text/css" media="all" />
<? if($current_page=='alert.php'){ ?>
<style>
	#chooseidm011{
	background: url("css/images/select-arrow.png") no-repeat scroll 140px center #FFFFFF;
    width: 164px !important;
	}
	#choosedrop011 {
		width: 164px !important;
	}
</style>
<? } ?>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css' />
<link href='http://fonts.googleapis.com/css?family=Bitter:400,400italic,700' rel='stylesheet' type='text/css' />

<script src="js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="js/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
<script src="js/jquery.radios.checkboxes.js" type="text/javascript"></script>
<script src="js/chosen.jquery.js" type="text/javascript"></script>
<script src="js/functions.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=DIR_JS?>validation.js" language="javascript"></script>
<script type="text/javascript">
	 $(function() {
	$( "#downloadbtn" ).mouseover(function() {
		$('#downloadshow').css({'display':'block'});
	}).mouseout(function() {
		$( "#downloadshow" ).mouseover(function() {
			$('#downloadshow').css({'display':'block'});
			});
			$( "#downloadshow" ).mouseout(function() {
			$('#downloadshow').css({'display':'none'});
			});
		$('#downloadshow').css({'display':'none'});
	});
	/* alert */
	$( "#setupalertbtn" ).mouseover(function() {
		$('#downloadshow1').css({'display':'block'});
	}).mouseout(function() {
		$( "#downloadshow1" ).mouseover(function() {
			$('#downloadshow1').css({'display':'block'});
			});
			$( "#downloadshow1" ).mouseout(function() {
			$('#downloadshow1').css({'display':'none'});
			});
		$('#downloadshow1').css({'display':'none'});
	});
	
	});
</script>
<? }else{ ?>
<link href="<?=DIR_CSS?>style-content-page.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?=DIR_JS?>validation.js" language="javascript"></script>

<!--
<link href="<?//=DIR_CSS?>combo-box.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?//=DIR_JS?>combo-js.js" language="javascript"></script>
<script type="text/javascript" src="<?//=DIR_JS?>validation.js" language="javascript"></script>
<script type="text/javascript" src="<?//=DIR_JS?>datetimepicker_css.js" language="javascript"></script>
<script type="text/javascript" src="<?//=DIR_JS?>combo-box.js"></script>
-->
<? } ?>
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
$search_msg=$_REQUEST['search_msg'];
?>	
</head>
<body>
<!-- ClickTale Top part -->
<script type="text/javascript">
var WRInitTime=(new Date()).getTime();
</script>
<!-- ClickTale end of Top part -->

<img src="http://ad.retargeter.com/px?id=61366&amp;t=2" width="1" height="1" />
<?php 
if($_SESSION['sess_user_id'] =='' && ($current_page=='advance-search.php' || $current_page=='search-result.php' || $current_page=='ITExecutivesDirectory.php' || $current_page=='logout.php' || $current_page=='contact-us.php' || $current_page=='team.php' || $current_page=='why-cto.php' || $current_page=='partners.php' || $current_page=='press-news.php' || $current_page=='white-paper.php' || $current_page=='faq.php' || $current_page=='executives-list.php' || $current_page=='company-list.php')){
?>
<script type="text/javascript" src="//www.hellobar.com/hellobar.js"></script>
<script type="text/javascript">
new HelloBar(53072,87093);
</script>
<?php } ?>
<? if($current_page!='movement.php'){ ?>
<div id="light" class="white_content" style="display:<? if($search_msg=='Result Not Found'){ echo 'block';} else { echo 'none'; } ?>;">
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="left" valign="top"><img src="images/specer.gif" width="1" height="50" alt="" title="" /> </td>
      </tr>
      <tr>
        <td align="center" valign="top">&nbsp;</td>
      </tr>
	   <tr>
        <td align="center" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" valign="top" >There are no matching results. Please <a href="javascript:;" onclick="document.frmADVSEdit.submit();">edit your search</a>
        	<form name="frmADVSEdit" method="post" action="advance-search.php?action=SearchEdit">
                <input type="hidden" name="first_name" value="<?=$first_name?>" />
                <input type="hidden" name="last_name" value="<?=$last_name?>" />
                <input type="hidden" name="title" value="<?=$title?>" />
                <input type="hidden" name="management" value="<?=$management?>" />
                <input type="hidden" name="country" value="<?=$country?>" />
                <input type="hidden" name="state" value="<?=$state?>" />
                <input type="hidden" name="city" value="<?=$city?>" />
                <input type="hidden" name="zip_code" value="<?=$zip_code?>" />
                <input type="hidden" name="company" value="<?=$company?>" />
                <input type="hidden" name="company_website" value="<?=$company_website?>" />
                <input type="hidden" name="industry" value="<?=$industry?>" />
                <input type="hidden" name="revenue_size" value="<?=$revenue_size?>" />
                <input type="hidden" name="employee_size" value="<?=$employee_size?>" />
                <input type="hidden" name="time_period" value="<?=$time_period?>" />
                <input type="hidden" name="from_date" value="<?=$_POST['from_date'];?>" />
                <input type="hidden" name="to_date" value="<?=$_POST['to_date'];?>" />
                <input type="hidden" name="speaking" value="<?=$speaking;?>" />
                <input type="hidden" name="awards" value="<?=$awards;?>" />
                <input type="hidden" name="publication" value="<?=$publication;?>" />
                <input type="hidden" name="media_mentions" value="<?=$media_mentions;?>" />
                <input type="hidden" name="board" value="<?=$board;?>" />
            </form>
        </td>
      </tr>
      <tr>
        <td align="center" valign="top">&nbsp;</td>
      </tr>
	   <tr>
        <td align="center" valign="top">&nbsp;</td>
      </tr>
	   <tr>
        <td align="center" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" valign="top"><a href="<?=$_REQUEST['burl'];?>"><img src="images/back-buttn.jpg" width="107" height="45" border="0" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'" alt="Back" title="Back"/></a></td>
      </tr>
      <tr>
        <td align="center" valign="top">&nbsp;</td>
      </tr>
    </table>
</div>
<div id="light-free" class="white_content_free" style="display:<? if($user_info=='FreeUser'){ echo 'block';} else { echo 'none'; } ?>;">
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="left" valign="top"><img src="images/specer.gif" width="1" height="50" alt="" title="" /> </td>
      </tr>
      <tr>
        <td align="left" valign="top" >Please upgrade your account now. It is $85/month and you can cancel any time</td>
      </tr>
      <tr>
        <td align="center" valign="top">&nbsp;</td>
      </tr>
	   <tr>
        <td align="center" valign="top">&nbsp;</td>
      </tr>
	   <tr>
        <td align="center" valign="top">&nbsp;</td>
      </tr>
     
	  <tr>
          <td align="center" valign="top"><table width="214" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td align="center" valign="top">&nbsp;</td>
              <td align="center" valign="top">&nbsp;</td>
              <td align="center" valign="top" class="next-buttn">
			  <a href="<?=HTTP_SERVER?>choose-subscription.php?res_id=<?=$_SESSION['sess_user_id'];?>">Next&nbsp;<img src="images/next-arrow-big.gif" width="11" height="11" alt=""  title="" border="0" onclick = "document.getElementById('light-free').style.display='none';document.getElementById('fade-free').style.display='none'"/></a></td>
            </tr>
          </table></td>
        </tr>
      <tr>
        <td align="center" valign="top">&nbsp;</td>
      </tr>
    </table>
</div>
<div id="fade" class="black_overlay" style="display:<? if($search_msg=='Result Not Found'){ echo 'block';} else { echo 'none'; } ?>;"></div>
<div id="fade-free" class="black_overlay" style="display:<? if($user_info=='FreeUser'){ echo 'block';} else { echo 'none'; } ?>;"></div>
<? } ?>

<div class="header">
    <div class="shell">
    	<? if($current_page=='advance-search.php' || $current_page=='search-result.php' || $current_page=='alert.php'){ ?>
        <h1 id="new-logo" style="padding-left:0px;"><a href="<?=HTTP_SERVER?>index.php">CTOs on the Move</a></h1>
		<? }else{ ?>
        <h1 id="new-logo"><a href="<?=HTTP_SERVER?>index.php">CTOs on the Move</a></h1>
        <? } ?>
        <div class="header-right">
            <? if($_SESSION['sess_is_user'] == 1){ ?>
                    <a href="<?=HTTP_SERVER?>logout.php" class="login-btn">Log Out</a>
                    <div id="navigation">
                        <ul>
                           <li><a href="<?=HTTP_SERVER?>index.php">Home</a></li>
                           <li><a href="<?=HTTP_SERVER?>team.html">About us</a></li>
                           <li><?=$_SESSION['sess_username']?>:&nbsp;<a href="<?=HTTP_SERVER?>my-profile.php">Profile</a></li>
                        </ul>
                    </div>
            <? }else{ ?>
                    <a href="<?=HTTP_SERVER?>login.php" class="login-btn">Login</a>
                    <div id="navigation">
                        <ul>
                           <li><a href="<?=HTTP_SERVER?>index.php">Home</a></li>
                           <li><a href="<?=HTTP_SERVER?>why-cto.html">How it Works</a></li>
                           <li><a href="<?=HTTP_SERVER?>team.html">About us</a></li>
                           <li><a href="<?=HTTP_SERVER?>pricing.html">Pricing</a></li>
                        </ul>
                    </div>
            <? } ?>
            <!-- /navigation -->
        </div>
        <!-- /header-right -->
    </div>
    <!-- /shell -->
</div>