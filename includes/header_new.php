<?php if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en-US" xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
	<title><?PHP if($current_page!='vigilant-appoints.php'){echo 'CTOsOnTheMove.com ::';}?> <?=$PageTitle;?></title>
	<meta name="keywords" content="<?=$PageKeywords?>" />
	<meta name="description" content="<?=$PageDescription?>" />
	<?=header('Content-type: text/html; charset=UTF-8');?>
	<link rel="shortcut icon" href="images/favicon.jpg" type="image/x-icon" />
    <?PHP if($current_page=='movement.php'){ ?>
    <link rel="stylesheet" href="css/style_movement.css" type="text/css" media="all" />
    <?PHP }else{?>
	<link rel="stylesheet" href="css/style_new.css" type="text/css" media="all" />
    <?PHP } ?>
	<!--[if IE 6]>
		<link rel="stylesheet" href="css/ie6.css" type="text/css" media="all" />
	<![endif]-->
	<!--[if lte IE 6]>
	<style type="text/css">
	.white_content .inner .close-buttn {
	background:none;
	filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='css/images/close-buttn.png' ,sizingMethod='crop');
	}
	</style>
	<![endif]-->
	<!--[if lt IE 6]>
	 <style type="text/css">
	 img { behavior: url(css/images/iepngfix.htc) }
	 </style>
	<![endif]-->
	<?PHP
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
	$isSignupPopup = com_db_GetValue("select status from ". TABLE_POPUP_ONOFF);
	if(($_SESSION['sess_is_user'] != 1) && ($isSignupPopup=='On') && $notCurrent!='Yes'){
	 	$box_status = 'block';
		$delay_time = com_db_GetValue("select delay_time from ". TABLE_POPUP_ONOFF);
	}else{
		$box_status = 'none';
		$delay_time=0;
	}
	
	?>
   
	<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
	<script type="text/javascript">
	stLight.options({publisher:'79e0565a-bece-48f3-b13d-487961d5b05c'});
	</script>
	<script type="text/javascript" language="javascript">
	//<![CDATA[
		function SignUpPopUpValidation(){
			var fname=document.getElementById('full_name_popup').value;
			if(fname==''||fname=='Type your First and Last Name here'){
				document.getElementById('full_name_popup').focus();
				return false;
			}
			var email=document.getElementById('email_popup').value;
			if(email==''||email=='Type your Work email address here'){
				document.getElementById('email_popup').focus();
				return false;
			}else{
				var reg=/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
				if(reg.test(email)==false){
				document.getElementById('email_popup').focus();
				return false;
				}else{
					var start_position = email.indexOf('@');
					var email_part = email.substring(start_position);
					var end_position = email_part.indexOf('.');
					var find_part = email_part.substring(0,end_position+1);
					var pemail = new Array();
					pemail = [<?=$banned_domain_array;?>];
					var email_result = include(pemail, find_part);
					if(email_result){
						document.getElementById('div_email_popup').className="field-box-new";
						document.getElementById('email_popup').value ="Type your Work email address here";
						document.getElementById('email_popup').className="textfield-new";
						return false;
					}
				}
			}
		}
		function EmailPopupFocus(){
			var email = document.getElementById('email_popup').value;
			if(email=='Type your Work email address here'){
				document.getElementById('div_email_popup').className="field-box";
				document.getElementById('email_popup').value ="";
				document.getElementById('email_popup').className="newtextboxbg";
			}
		}
		function EmailPopupBlur(){
			var email = document.getElementById('email_popup').value;
			if(email==''){
				document.getElementById('div_email_popup').className="field-box";
				document.getElementById('email_popup').value ="Type your Work email address here";
				document.getElementById('email_popup').className="newtextboxbg";
			}
		}
			
		function SignUpValidation(){
			
			var fname=document.getElementById('full_name_sign').value;
			if(fname=='' || fname=='Type your First and Last Name here'){
				document.getElementById('full_name_sign').focus();
				return false;
			}
			
			var email=document.getElementById('email_sign').value;
                        
                        if(email.indexOf(".edu") > -1)
			{
                            alert('Email address with domain .edu not allowed');
                            document.getElementById('email_sign').focus();
                            return false;
			}
                        
                        
                        
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
					var pemail = new Array();
					pemail = [<?=$banned_domain_array;?>];
					var email_result = include(pemail, find_part);
					if(email_result){
						document.getElementById('div_email_sign').className="textfield-bg-new";
						document.getElementById('email_sign').value ="Type your Work email address here";
						document.getElementById('email_sign').className="textfield-new";
						return false;
					}
				}
			}
		}
		function include(arr, obj) {
		   var arrLen = arr.length;		
		  for(var i=0; i<arrLen; i++) {
			if (arr[i].toUpperCase() == obj.toUpperCase()) return true;
		  }
		}
		function EmailSignFocus(){
			var email = document.getElementById('email_sign').value;
			if(email=='Type your Work email address here'){
				document.getElementById('div_email_sign').className="textfield-bg";
				document.getElementById('email_sign').value ="";
				document.getElementById('email_sign').className="textfield";
			}
		}
		function EmailSignBlur(){
			var email = document.getElementById('email_sign').value;
			if(email==''){
				document.getElementById('div_email_sign').className="textfield-bg";
				document.getElementById('email_sign').value ="Type your Work email address here";
				document.getElementById('email_sign').className="textfield";
			}
		}
		
		function SignUpClose(){
			document.getElementById('fade').style.display='none';
			document.getElementById('light').style.display='none';
		}
		function Start(block_none) {
			var fname = document.getElementById('full_name_sign').value;
			var email = document.getElementById('email_sign').value;
			if(fname=='Type your First and Last Name here' && email=='Type your Work email address here'){
				document.getElementById('light').style.display=block_none;
				document.getElementById('fade').style.display=block_none;
			}
		}

		function doPopup() {
		delay = <?=$delay_time?>;    // time in seconds before popup opens
		timer = setTimeout("Start('<?=$box_status?>')", delay*1000);
		}
		function showHideNew(divID){
			if (document.getElementById(divID).style.display == "none") {
				document.getElementById(divID).style.display = "block";
			} else {
				document.getElementById(divID).style.display = "none";
			}
		}
		function CloseWhihtContent(divID){
			document.getElementById(divID).style.display = "none";
		}
		//window.onload = doPopup;
		//]]>
	</script>
	
</head>
<body onload="doPopup();" <?PHP if($current_page=='vigilant-appoints.php' && $_SESSION['sess_is_user'] != 1){echo 'class="new-body-bg1"';} ?> >
	<!-- ClickTale Top part -->
	<script type="text/javascript">
    var WRInitTime=(new Date()).getTime();
    </script>
    <!-- ClickTale end of Top part -->

    <img src="http://ad.retargeter.com/seg?add=570782&amp;t=2" width="1" height="1" />
    
	<div id="fade" class="black_overlay_new" style="display:none;"></div>
	<!-- Header -->
	<?PHP if($current_page != 'movement.php'){ ?>
		<div id="header">
			<div class="shell">
				<h1 id="logo"><a class="notext" href="<?=HTTP_SERVER?>index.php">CTOs on the Move</a></h1>
				<div id="login-info-box">
					<?PHP if($_SESSION['sess_is_user'] == 1){ 
							echo  $_SESSION['sess_username'] .': <a href="'.HTTP_SERVER.'my-profile.php">Profile</a>: <a href="logout.php">Logout</a>';
						}
					?>
				</div>
			</div>
		</div>
	<?PHP }elseif($_SESSION['sess_is_user'] == 1){ ?>
	
			<div class="topheader-whitebg">
				<div id="header">
					<div class="shell">
						<h1 id="logo"><a class="notext" href="<?=HTTP_SERVER?>index.php">CTOs on the Move</a></h1>
						<div id="login-info-box">
							<?PHP if($_SESSION['sess_is_user'] == 1){ 
								echo  $_SESSION['sess_username'] .': <a href="'.HTTP_SERVER.'my-profile.php">Profile</a>: <a href="logout.php">Logout</a>';
								}
							?>				
						</div>
					</div>
				</div>
			</div>
		
	<?PHP } ?>
	<!-- end Header -->