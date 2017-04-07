<?php if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><? if($current_page!='vigilant-appoints.php'){echo 'CTOsOnTheMove.com ::';}?> <?=$PageTitle;?></title>
<meta name="keywords" content="<?=$PageKeywords?>" />
<meta name="description" content="<?=$PageDescription?>" />
<link rel="shortcut icon" href="images/favicon.jpg" type="image/x-icon" />

<link href="<?=DIR_CSS?>style.css" rel="stylesheet" type="text/css" />
<link href="<?=DIR_CSS?>combo-box.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?=DIR_JS?>combo-js.js" language="javascript"></script>
<script type="text/javascript" src="<?=DIR_JS?>validation.js" language="javascript"></script>
<script type="text/javascript" src="<?=DIR_JS?>datetimepicker_css.js" language="javascript"></script>

<script type="text/javascript" src="<?=DIR_JS?>combo-box.js"></script>

<? if($current_page =='pricing.php'){ ?>
	<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
	<!--[if IE 6]>
		<link rel="stylesheet" href="css/ie6.css" type="text/css" media="all" />
		<script type="text/javascript" src="js/DD_belatedPNG.js"></script>
	<![endif]-->
	<script type="text/javascript" src="js/functions.js"></script>
	<script type="text/javascript" language="javascript">
		function SubscriptionSelect(div_id){
			if(div_id=='DivBasic'){
				document.getElementById('DivBasic').className="left4_select";
				document.getElementById('DivStandard').className="left4";
				document.getElementById('DivProfessional').className="left4";
			}else if(div_id=='DivStandard'){
				document.getElementById('DivBasic').className="left4";
				document.getElementById('DivStandard').className="left4_select";
				document.getElementById('DivProfessional').className="left4";
			}else if(div_id=='DivProfessional'){
				document.getElementById('DivBasic').className="left4";
				document.getElementById('DivStandard').className="left4";
				document.getElementById('DivProfessional').className="left4_select";
			}
		}
	</script>
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
$asin = $_REQUEST['asin'];

?>	
<script type="text/javascript" language="javascript">
	function LoginPage(){
		window.location="login.php";
	}
	function SignUpValidationNew(){
			
			var fname=document.getElementById('full_name_sign').value;
			if(fname=='' || fname=='Type your First and Last Name here'){
				document.getElementById('full_name_sign').focus();
				return false;
			}
			
			var email=document.getElementById('email_sign').value;
			if(email=='' || email=='Type your Work email address here'){
				document.getElementById('email_sign').focus();
				return false;
			}else{
				var reg=/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
				if(reg.test(email)==false){
					document.getElementById('email_sign').focus();
					return false;
				}else{
					var start_position = email.indexOf('@');
					var email_part = email.substring(start_position);
					var end_position = email_part.indexOf('.');
					var find_part = email_part.substring(0,end_position+1);
					var pemail = [<?=$banned_domain_array;?>];
					//['@yahoo.','@gmail.','@hotmail.','@msn.','@aol.'];
					var email_result = include(pemail, find_part);
					if(email_result){
						//document.getElementById('div_email_sign').className="textfield-bg-new";
						document.getElementById('email_sign').value ="Type your Work email address here";
						//document.getElementById('email_sign').className="textfield-new";
						return false;
					}
				}
			}
		}
		
		function include(arr, obj) {
		  for(var i=0; i<arr.length; i++) {
			if (arr[i].toUpperCase() == obj.toUpperCase()) return true;
		  }
		}
</script>
</head>
<? 
$side_logo = com_db_GetValue("select image_path from ". TABLE_BANNER . " where id='1'");
$search_msg=$_REQUEST['search_msg'];
?>
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
        <td align="left" valign="top" >There are no matching results. Please <a href="<?=$_REQUEST['burl'];?>">edit your search</a></td>
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
<table width="1002" border="0" align="center" cellpadding="0" cellspacing="0">

  <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top" class="top-header-bg"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
    
      <tr>
        <td align="center" valign="top">
		<? if($_SESSION['sess_is_user'] != 1){?>
		<table width="928" border="0" align="center" cellpadding="0" cellspacing="0">
		      <tr>
        <td align="left" valign="top"><img src="images/specer.gif" width="1" height="38" alt="" title="" /></td>
      </tr>
          <tr>
            <td width="196" align="left" valign="top"><a href="<?=HTTP_SERVER?>index.php"><img src="images/<?=$side_logo?>"  alt="Logo" width="196" height="32" border="0" title="Logo" /></a></td>
            <td width="555" align="left" valign="top">&nbsp;</td>
            
			<td width="237" align="left" valign="top">
			   <!-- login box -->
				<div id="question_mark" style="display:none; position:absolute; top:75px; width:230px;">
				<table width="235" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top" class="help-popup-bg"><table width="195" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="left" valign="top"><img src="images/specer.gif" width="1" height="5" alt="" title="" /></td>
      </tr>
      <tr>
        <td align="left" valign="middle"  class="help-popup-text">Register to get access to thousands of responsive, actionable and relevant sales leads</td>
      </tr>
  
    </table></td>
  </tr>
</table>
				</div>
			<div class="login_box_in">
						 <div id="reg1" style="display: block;">
							<div class="left1"> <a href="javascript:LoginPage();">Login</a> | <a href="<?=HTTP_SERVER?>provide-contact-information.php">Register</a></div>
							<div class="right1"><a href="javascript://"  onmouseover="question_mark_show('question_mark');" onmouseout="question_mark_close('question_mark');"><img src="images/logi-register-right-icon.jpg" width="19" height="19" border="0" alt="" title=""/></a></div>
						 </div>
						 <div id="reg2" style="display: none;">
							 <form name="frm_login" method="post" action="res-process.php?action=UserLogin">
								 <div class="login_box_middle ">	
									 <div class="row">
										 <div class="n">User name/ Email Address:</div>
										 <div class="v"><input type="text" name="login_email" id="login_email" value="" /></div>
								   </div>
							
									 <div class="row">
										 <div class="n">Password</div>
										 <div class="v"><input type="password" name="login_pass" id="login_pass" value="" /></div>
									 </div>
									
									 <div class="row">
										<div class="login_button">
												  <input name="image" type="image" onmouseover="this.src='images/popup-login-buttn-h.gif'" onmouseout="this.src='images/popup-login-buttn.gif'" value="Login" src="images/popup-login-buttn.gif"  alt="Login"/>
										</div>
										<div class="link"><a href="<?=HTTP_SERVER?>forgot-password.php">Forgot&nbsp;Your&nbsp;password?</a></div>
									</div>
								</div>
							</form>
							<div class="login_box_bottom"></div>
						</div>
				</div>
				
       <!-- // login box -->	
			  </td>
			</tr>
        </table>
	<? }elseif($_SESSION['sess_is_user'] == 1){ ?>
			<table width="928" border="0" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td align="left" valign="top"><img src="images/specer.gif" width="1" height="38" alt="" title="" /></td>
			 </tr>
			  <tr>
				<td width="196" align="left" valign="top"><a href="<?=HTTP_SERVER?>index.php"><img src="images/<?=$side_logo?>"  alt="Logo" width="196" height="32" border="0" title="Logo" /></a></td>
				<td width="495" align="left" valign="top">&nbsp;</td>
				<td width="237" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
				  <tr>
					<td align="right" valign="top" class="login-register-text"><strong><?=$_SESSION['sess_username']?>:&nbsp;<a href="<?=HTTP_SERVER?>my-profile.php">Profile:</a>&nbsp;<a href="<?=HTTP_SERVER?>logout.php">Logout</a></strong></td>
				  </tr>
				</table></td>
			  </tr>
			</table>
			<? } ?>
			</td>
		</tr>
           <tr>
        <td align="left" valign="top" class="caption-text">
		<?=com_db_GetValue("select page_content from " .TABLE_PAGE_CONTENT . " where page_name='index.php' and page_title='Page Heading'")?>
		</td>
      </tr>
  	  <tr>
        <td align="left" valign="top"><img src="images/specer.gif" width="1" height="33" alt="" title="" /></td>
      </tr>

    </table></td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>