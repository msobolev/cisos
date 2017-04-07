<? 
include("includes/include-top.php");
 
$dim_url = explode('/', $_SERVER['REQUEST_URI']);
$personal_url =$dim_url[sizeof($dim_url)-1];
$personal_arr = explode("_",$personal_url);
$persize = sizeof($personal_arr);
$personal_id = $personal_arr[$persize-1];

if(trim($personal_id)==''){
	$personal_id = $_REQUEST['personal_id'];
	$isPersonalID = com_db_GetValue("select personal_id from ".TABLE_PERSONAL_MASTER." where personal_id='".$personal_id."'");
	if($isPersonalID==''){
		$url ='not-found.php';
		com_redirect($url);
	}
}elseif(trim($personal_id)!=''){
	$isPersonalID = com_db_GetValue("select personal_id from ".TABLE_PERSONAL_MASTER." where personal_id='".$personal_id."'");
	if($isPersonalID==''){
		$url ='not-found.php';
		com_redirect($url);
	}
}

$personal_query = 'select mm.company_id,mm.title,mm.announce_date,pm.*,cm.company_name,ind_group_id,cm.industry_id,cm.company_website,cm.about_company from '					
					.TABLE_MOVEMENT_MASTER . ' as mm, '
					.TABLE_PERSONAL_MASTER . ' as pm, '
					.TABLE_COMPANY_MASTER. ' as cm  
					where mm.personal_id=pm.personal_id and mm.company_id=cm.company_id and pm.personal_id = "'.$personal_id.'" order by mm.announce_date desc';
$personal_result = com_db_query($personal_query);
$personal_row = com_db_fetch_array($personal_result);

$comp_domain_name='';
if($personal_row['company_website'] !=''){
	$comp   = array("http://wwww.", "www.","https://www.","http://","https://");
	$comp_domain_name = str_replace($comp,'',$personal_row['company_website']);
	$comp_domain_name =' @'. $comp_domain_name;
}	

$PageTitle = com_db_output($personal_row['first_name']).' '.com_db_output($personal_row['last_name']).' | '.preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array(' ', ' ', ' '),com_db_output($personal_row['company_name'])).' | Email, '.com_db_output($personal_row['title']).', '.$comp_domain_name;
$movement_type = $personal_row['movement_type'];
$PageKeywords=com_db_output($personal_row['first_name']).' '.com_db_output($personal_row['last_name']).', '.com_db_output($personal_row['company_name']).', Email, '.com_db_output($personal_row['title']).', '.$comp_domain_name.', bio, e-mail, executive, phone, address, addresses';
$PageDescription=com_db_output($personal_row['first_name']).' '.com_db_output($personal_row['last_name']).' is '.com_db_output($personal_row['title']).' of '.com_db_output($personal_row['company_name']).'. CTOsOnTheMove profile includes an email address, @url, linkedin, biography';


?>
<?php if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--<html xmlns="http://www.w3.org/1999/xhtml">-->
<html lang="en" itemscope itemtype="http://schema.org/Person">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<title><?=$PageTitle;?></title>
    <meta property="og:type" content="profile"/>
	<meta property="og:title" content="<?=com_db_output($personal_row['first_name']).' '.com_db_output($personal_row['last_name'])?>"/>
	<meta property="og:url" content="<?=HTTP_SERVER.$personal_url;?>"/>
	
	<meta name="keywords" content="<?=$PageKeywords?>" />
	<meta name="description" content="<?=$PageDescription?>" />
    <meta property="profile:first_name" content="<?=com_db_output($personal_row['first_name'])?>"/>
	<meta property="profile:last_name" content="<?=com_db_output($personal_row['last_name'])?>"/>
	<meta property="og:image" content="<?=HTTP_SERVER?>personal_photo/thumb/<?=$personal_row['personal_image']?>" />
	<meta itemprop="image" content="<?=HTTP_SERVER?>personal_photo/thumb/<?=$personal_row['personal_image']?>" />
    
	<link rel="stylesheet" href="css/company-personal-style.css" type="text/css" media="all" />
	<link rel="shortcut icon" type="image/x-icon" href="css_new/images/favicon.jpg" />

	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css' />
	<link href='http://fonts.googleapis.com/css?family=Bitter:400,400italic,700' rel='stylesheet' type='text/css' />

	<!--<script src="js/jquery-1.7.2.min.js" type="text/javascript"></script>
	<script src="js/functions.js" type="text/javascript"></script>-->
	<script type="text/javascript" language="javascript">
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
						document.getElementById('email_sign').value ="Type your Work email address here";
						document.getElementById('email_sign').className="field_red";
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
				document.getElementById('email_sign').value ="";
				document.getElementById('email_sign').className="field";
			}
		}
		function EmailSignBlur(){
			var email = document.getElementById('email_sign').value;
			if(email==''){
				document.getElementById('email_sign').value ="Type your Work email address here";
				document.getElementById('email_sign').className="field_red";
			}
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

	</script>
</head>
<body>
	<div class="header">
		<div class="shell clearfix">
			<h1 id="new-logo"><a href="<?=HTTP_SERVER?>index.php">CTOs on the Move</a></h1>

			<div class="header-right">
				<div id="navigation">
                   <ul>
                        <?php if($current_page !='index.php'){ ?>
                        <li><a href="<?=HTTP_SERVER?>index.php">Home</a></li>
                        <? } ?>
                        <li><a href="<?=HTTP_SERVER?>advance-search.php">Search</a></li>
                        <li><a href="<?=HTTP_SERVER?>team.html">About Us</a></li>
                        <? if($_SESSION['sess_is_user'] == 1){ ?>
                        <li><?=$_SESSION['sess_username']?>:&nbsp;<a href="<?=HTTP_SERVER?>my-profile.php">Profile</a></li>
                        <li><a href="<?=HTTP_SERVER?>logout.php" class="btn"><span>Log Out</span></a></li>
                        <? }else{ ?>
                        <li><a href="<?=HTTP_SERVER?>pricing.html">Pricing</a></li>
                        <li><a href="<?=HTTP_SERVER?>login.php" class="btn"><span>Login</span></a></li>
                        <? } ?>
                    </ul>
                 </div>   
				<!-- /navigation -->
			</div>
			<!-- /header-right -->
		</div>
		<!-- /shell -->
	</div>
	<!-- /header -->

	<div class="profile">
		<div class="profile-heading">
			<div class="shell clearfix">
				<div class="social-media clearfix">
                	<? if($personal_row['linkedin_link'] !='' || $personal_row['googleplush_link'] !='' || $personal_row['twitter_link'] !='' || $personal_row['facebook_link'] !=''){
						$linkedin = explode('//', $personal_row['linkedin_link']);
						if(sizeof($linkedin)>1){
							$linkedin_url = $linkedin[0].'//'.$linkedin[1];
						}else{
							$linkedin_url = 'http://'.$linkedin[0];
						}
						$googleplush = explode('//', $personal_row['googleplush_link']);
						if(sizeof($googleplush)>1){
							$googleplush_url = $googleplush[0].'//'.$googleplush[1];
						}else{
							$googleplush_url = 'http://'.$googleplush[0];
						}
						$twitter = explode('//', $personal_row['twitter_link']);
						if(sizeof($twitter)>1){
							$twitter_url = $twitter[0].'//'.$twitter[1];
						}else{
							$twitter_url = 'http://'.$twitter[0];
						}
						$facebook = explode('//', $personal_row['facebook_link']);
						if(sizeof($facebook)>1){
							$facebook_url = $facebook[0].'//'.$facebook[1];
						}else{
							$facebook_url = 'http://'.$facebook[0];
						}
						?>
					<p>Social Media:</p>
                    <? if($personal_row['linkedin_link'] !=''){ ?><a href="<?=$linkedin_url?>" class="linkedin-icon" rel="nofollow">linkedin</a><? } ?>
					<? if($personal_row['googleplush_link'] !=''){ ?><a href="<?=$googleplush_url;?>" class="google-icon" rel="nofollow">google</a><? } ?>
					<? if($personal_row['twitter_link'] !=''){ ?><a href="<?=$twitter_url;?>" class="twitter-icon" rel="nofollow">twitter</a><? } ?>
					<? if($personal_row['facebook_link'] !=''){ ?><a href="<?=$facebook_url;?>" class="facebook-icon" rel="nofollow">facebook</a><? } ?>
                    <? } ?>
				</div>
				<!-- /social-media -->

				<div class="profile-name">
					<h2><?=com_db_output($personal_row['first_name'].' '.$personal_row['last_name']);?></h2>
					<h4><?=com_db_output($personal_row['title'].' at '.$personal_row['company_name']);?></h4>
				</div>
			</div>
			<!-- /shell -->
		</div>
		<!-- /profile-heading -->
		<div class="profile-cnt">
			<div class="shell clearfix">
				<div class="profile-description">
				<?php 
				$imageStatus='';$ImageDisplay='';
				if(isset($_SESSION['sess_user_id'])){
				$imageStatus = com_db_GetValue("select 	filter_onoff  from ". TABLE_PERSONAL_IMAGE_ONOFF ." where 	filter_id='1'");
 				}else{
				$imageStatus = com_db_GetValue("select 	filter_onoff  from ". TABLE_PERSONAL_IMAGE_ONOFF ." where 	filter_id='2'");
				}
				$ImageDisplay=trim($imageStatus);
   				?>
                  	<? if($personal_row['personal_image']!='' &&  $ImageDisplay=='ON'){ ?>
					<div class="profile-img" style="background-color:#FFF;"><img src="<?=HTTP_CTO_URL?>personal_photo/thumb/<?=$personal_row['personal_image']?>" alt="<?=com_db_output($personal_row['first_name'].' '.$personal_row['last_name']);?>" title="<?=com_db_output($personal_row['first_name'].' '.$personal_row['last_name'])?>" height="200px" width="200px" style="position:absolute;top:0;bottom:0;margin:auto;"/></div>
                    <? }else{ echo '<br>';}?>
					<!-- /profile-img -->
					<div class="cl">&nbsp;</div>
                    <?=$personal_row['about_person']?>
				</div>

				<div class="profile-info">
					<h4>PROFILE</h4>
					<? 
					$pemail= explode('@',com_db_output($personal_row['email']));
					$email_str='';
					if(strlen($pemail[0])>0){
						/*for($p=0;$p<strlen($pemail[0]);$p++){
							$email_str .= '*';
						}*/
						for($p=0;$p<4;$p++){
							$email_str .= '*';
						}
					$email_str .= '@'.$pemail[1];	
					}
					
					$pphone=explode('.',com_db_output($personal_row['phone']));
					$phone_str = '';
					if(strlen($pphone[0])>0){
						$phone_str ='.';
						for($p=0;$p<strlen($pphone[0]);$p++){
								$phone_str .='*';
							}
					}	
					if(strlen($pphone[1])>0){
						$phone_str .= '.';
						for($p=0;$p<strlen($pphone[1]);$p++){
								$phone_str .= '*';
							}
					}
					if(strlen($pphone[2])>0){
						$phone_str .= '.';
						for($p=0;$p<strlen($pphone[2]);$p++){
							if($p==1 || $p==2){
								$phone_str .= $pphone[2][$p];
							}else{
								$phone_str .= '*';
							}
						}
					}
					?> 
					<ul class='table-list'>
						<li><strong>Name:</strong> <?=com_db_output($personal_row['first_name'].' '.$personal_row['last_name']);?></li>
						<li><strong>Title:</strong><?=com_db_output($personal_row['title'])?></li>
						<li><strong>Company:</strong><a href="<?=HTTP_SERVER?><?=preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''), com_db_output($personal_row['company_name'])).'_Company_'.$personal_row['company_id']?>"><?=com_db_output($personal_row['company_name']);?></a></li>
						<li><strong>Industry:</strong><?=com_db_output(com_db_GetValue("select title from ".TABLE_INDUSTRY." where industry_id='".$personal_row['industry_id']."'"));?></li>
						<? if($_SESSION['sess_is_user'] != 1){ ?>
                        <li><strong>Email:</strong><?=$email_str;?></li>
						<li><strong>Phone:</strong><?=$phone_str?></li>
                        <? }elseif($_SESSION['sess_is_user'] == 1){ ?>
                        <li><strong>Email:</strong><?=com_db_output($personal_row['email']);?></li>
						<li><strong>Phone:</strong><?=com_db_output($personal_row['phone'])?></li>
                        <? } ?>
					</ul>
					<?PHP
						
					if($_SESSION['sess_user_id'] == '')
					{
					?>
					<p>To get full contact details, please <a href='<?=HTTP_SERVER?>login.php'>sign in</a> or</p>

					<div class="sign-form">
						<h3>Sign Up Now <span class="free-logo"></span></h3>
						<form name="sign_up" id="sign_up" method="post" action="movement-next.php?action=PersonalProfile&amp;personal_id=<?=$personal_row['personal_id']?>" onsubmit="return SignUpValidation();">
							<input type="hidden" name="referring_links" id="referring_links" value="<?=$current_page?>"/>
                            <p><input type="text" name="full_name" id="full_name_sign" class="field" value="Type your First and Last Name here" title="Type your First and Last Name here" onfocus=" if (this.value == 'Type your First and Last Name here') { this.value = ''; }" onblur="if (this.value == '') { this.value='Type your First and Last Name here';} " /></p>
							<p><input type="text" name="email" id="email_sign" class="field" value="Type your Work email address here" title="Type your Work email address here" onfocus="EmailSignFocus();" onblur="EmailSignBlur();"/></p>
							<p><input type="submit" value="Get Contact Details Now" class="submit-button" /></p>
						</form>
					</div>
					<?PHP
					}
					?>
					<!-- /sign-form -->
				</div>
			</div>
			<!-- /shell -->
		</div>
		<!-- /profile-cnt -->
	</div>
	<!-- /profile -->

	<div class="interests">
		<div class="shell">
        	<?
			$appQuery = 'select mm.title,mm.announce_date,mm.movement_url,mm.headline,mm.movement_type,pm.personal_id,pm.first_name,pm.last_name,pm.add_date,cm.company_name from '					
						.TABLE_MOVEMENT_MASTER . ' as mm, '
						.TABLE_PERSONAL_MASTER . ' as pm, '
						.TABLE_COMPANY_MASTER. ' as cm  
						where mm.personal_id=pm.personal_id and mm.company_id=cm.company_id and mm.personal_id ='."'".$personal_row['personal_id']."' order by mm.announce_date desc";
			$appResult = com_db_query($appQuery);
			if($appResult){
				$app_num_rows = com_db_num_rows($appResult);
			}
			?>
			<ul>
            	<?
				if($app_num_rows>0){
					$app=1; 
				 while($appRow = com_db_fetch_array($appResult)){
					 $annDt = explode("-",$appRow['announce_date']);
					 $announce_date =  $annDt[1].'/'. $annDt[2].'/'. $annDt[0];
				?>
				<li>
					<div class="heading">
						<h5><span class="ico app-ico"></span>Appointment #<?=$app;?></h5>
					</div>
					<div class="interest-cnt">
                    	 <?php 
							  if($appRow['movement_type']==1){
								 $movement = ' was Appointed as ';
							  }elseif($appRow['movement_type']==2){
								  $movement = ' was Promoted to ';
							  }elseif($appRow['movement_type']==3){
								  $movement = ' Retired as ';
							  }elseif($appRow['movement_type']==4){
								  $movement = ' Resigned as '; 
							  }elseif($appRow['movement_type']==5){
								  $movement = ' was Terminated as ';
							  }elseif($appRow['movement_type']==6){
								  $movement = ' was Appointed to ';
							  }elseif($appRow['movement_type']==7){
								  $movement = ' Job Opening ';
							  }
						 ?>
						<p><?=com_db_output($appRow['first_name']).$movement.com_db_output($appRow['title'])?> at <?=com_db_output($appRow['company_name'])?> on <?=$announce_date;?> <br /><a href='<?=HTTP_SERVER?><?=com_db_output($appRow['movement_url'])?>'>More Info</a></p>
					</div>
				</li>
                <? 
				$app++;
					}
				} ?>
				<? if($personal_row['edu_ugrad_degree'] !='' || $personal_row['edu_grad_degree']){ ?>
				<li>
					<div class="heading">
						<h5><span class="ico education-ico"></span>Education</h5>
					</div>
					<div class="interest-cnt">
						<p>
                        <? if($personal_row['edu_ugrad_degree'] !='' ){ 
                        	echo  com_db_output($personal_row['first_name'].' received a '. $personal_row['edu_ugrad_degree'].' in '.$personal_row['edu_ugrad_specialization'].' from '.$personal_row['edu_ugrad_college']);
							if($personal_row['edu_ugrad_year']>0){echo ' in '.$personal_row['edu_ugrad_year'];};
						   } 
						   if($personal_row['edu_grad_degree'] !='' && $personal_row['edu_ugrad_degree'] !='' ){    
							echo com_db_output(' and '.$personal_row['edu_grad_degree'].' in '.$personal_row['edu_grad_specialization'].' from '.$personal_row['edu_grad_college']);
                          	if($personal_row['edu_grad_year']>0){echo ' in '.$personal_row['edu_grad_year'];};
						  }elseif($personal_row['edu_grad_degree'] !='' && $personal_row['edu_ugrad_degree'] ==''){
						  	echo com_db_output($personal_row['first_name'].' received a '.$personal_row['edu_grad_degree'].' in '.$personal_row['edu_grad_specialization'].' from '.$personal_row['edu_grad_college']);
                          	if($personal_row['edu_grad_year']>0){echo ' in '.$personal_row['edu_grad_year'];};
						  }
                        ?>   
                        </p>
					</div>
				</li>
                <? } ?>
                <? if($personal_row['personal'] !=''){ ?>
				<li>
					<div class="heading">
						<h5><span class="ico personal-ico"></span>Personal</h5>
					</div>
					<div class="interest-cnt">
						<p><?=com_db_output($personal_row['personal'])?></p>
					</div>
				</li>
                <? } ?>
                <? 
				 $awardsQuery = "select * from ".TABLE_PERSONAL_AWARDS." where personal_id='".$personal_row['personal_id']."' order by awards_id";
				 $awardsResult = com_db_query($awardsQuery);
				 if($awardsResult){
					 $awards_num_rows = com_db_num_rows($awardsResult);
				 }
				 
				if($awards_num_rows > 0){ ?>
				<li>
					<div class="heading">
						<h5><span class="ico awards-ico"></span>Awards</h5>
					</div>
					<div class="interest-cnt">
						
                        <? 	$awards=1;
							while($awardsRow = com_db_fetch_array($awardsResult)){
								$awards_date = $awardsRow['awards_date'];
				 				$awards_dt = explode("-", $awards_date);
									
								if($awards==1){
									echo $personal_row['first_name'].' was selected as the '.$awardsRow['awards_title'].' by the '.$awardsRow['awards_given_by'].' in '.$awards_dt[0].'.';
								}else{
									echo ' '.$personal_row['first_name'].' was selected as the '.$awardsRow['awards_title'].' by the '.$awardsRow['awards_given_by'].' in '.$awards_dt[0].'.';
								}
								$awards++;
							}
                        ?>
                    </div>
				</li>
                <? } ?>
                 <? 
				 $boardsQuery = "select board_info from ".TABLE_PERSONAL_BOARD." where personal_id='".$personal_row['personal_id']."' order by board_id";
				 $boardsResult = com_db_query($boardsQuery);
				 if($boardsResult){
					 $boards_num_rows = com_db_num_rows($boardsResult);
				 }
				if($boards_num_rows > 0){ ?>
				<li>
					<div class="heading">
						<h5><span class="ico boards-ico"></span>Boards</h5>
					</div>
					<div class="interest-cnt">
                    	<p>
                    	<? 	$boards=1;
							while($boardsRow = com_db_fetch_array($boardsResult)){
								if($boards==1){
									echo $personal_row['first_name'].' is a member of the '. com_db_output($boardsRow['board_info']).'.';
								}else{
									echo ' He is also a member of the '. com_db_output($boardsRow['board_info']).'. ';
								}
								$boards++;
							}
                        ?>
                        </p>
					</div>
				</li>
				<? } ?>
                <? 
				 $speakingQuery = "select role,topic,event,event_date from ".TABLE_PERSONAL_SPEAKING." where personal_id='".$personal_row['personal_id']."' order by speaking_id";
				 $speakingResult = com_db_query($speakingQuery);
				 if($speakingResult){
					 $speaking_num_rows = com_db_num_rows($speakingResult);
				 }
				if($speaking_num_rows > 0){ ?>
				<li>
					<div class="heading">
						<h5><span class="ico speaking-ico"></span>Speaking</h5>
					</div>
					<div class="interest-cnt">
                    	<ul class="testClass">
                    	<? 	$speaking=1;
							while($speakingRow = com_db_fetch_array($speakingResult)){
								$event_date = explode("-", $speakingRow['event_date']);
								$eventDate = date("M d, Y",mktime(0,0,0,$event_date[1],$event_date[2],$event_date[0]));
								echo "<li>";
									if($speakingRow['role']=='Speaker'){
										//if($_GET['debug'] == 1)
										//{
											//$_SESSION['login_id']
											//echo "<pre>_SESSION:";	print_r($_SESSION); echo "</pre>";
											$today = date("M d, Y");	
											$opening_date = new DateTime($speakingRow['event_date']);
											$current_date = new DateTime();
											//if($event_date < $today)
											
											// below is working code
											if($opening_date < $current_date)
											{
												//echo "--- SPOKE ---";
												$lang_speak = "spoke";
											}	
											else	
											{
												//echo "--- WILL SPEAK ---";
												$lang_speak = "will speak";
											}	
												
										//}
										//echo $personal_row['first_name'].' was a '.com_db_output($speakingRow['role']).' at '.com_db_output($speakingRow['event']).' on '.$eventDate.', on the topic of "'. com_db_output($speakingRow['topic']).'"';
										echo $personal_row['first_name'].' '.$lang_speak.' at '.com_db_output($speakingRow['event']).' on '.$eventDate.', on the topic of "'. com_db_output($speakingRow['topic']).'"';										
									}elseif($speakingRow['role']=='Keynote'){
										echo $personal_row['first_name'].' delivered a '.com_db_output($speakingRow['role']).' "'.com_db_output($speakingRow['topic']).'" at '.com_db_output($speakingRow['event']). ' on '. $eventDate;
									}elseif($speakingRow['role']=='Panelist'){
										echo $personal_row['first_name'].' spoke on a Panel '.'"'.com_db_output($speakingRow['topic']).'" at '.com_db_output($speakingRow['event']). ' on '. $eventDate;
									}
								echo "</li>";
								$speaking++;
							}
                        ?>
                        </ul>
					</div>
				</li>
                <? } ?>
                 <? 
				 $mediaQuery = "select publication,quote,pub_date from ".TABLE_PERSONAL_MEDIA_MENTION." where personal_id='".$personal_row['personal_id']."' order by mm_id";
				 $mediaResult = com_db_query($mediaQuery);
				 if($mediaResult){
					 $media_num_rows = com_db_num_rows($mediaResult);
				 }
				if($media_num_rows > 0){ ?>
				<li>
					<div class="heading">
						<h5><span class="ico media-ico"></span>Media Mentions</h5>
					</div>
					<div class="interest-cnt">
                    	<p>
                    	<? 	$media=1;
							while($mediaRow = com_db_fetch_array($mediaResult)){
								$pub_dt= explode("-", $mediaRow['pub_date']);
								$pub_date = date("F j, Y",mktime(0,0,0,$pub_dt[1],$pub_dt[2],$pub_dt[0]));
								if($media==1){
									echo '<b>On '.$pub_date.', '.com_db_output($personal_row['first_name']).' was quoted by '. com_db_output($mediaRow['publication']).':</b><br><em>'.com_db_output($mediaRow['quote']).'</em><br>';
								}else{
									echo '<br><b>On '.$pub_date.', '.com_db_output($personal_row['first_name']).' was quoted by '. com_db_output($mediaRow['publication']).':</b><br><em>'.com_db_output($mediaRow['quote']).'</em><br>';
								}
								$media++;
							}
                        ?>
                        </p>
					</div>
				</li>
                <? } ?>
                <? 
				 $publicationsQuery = "select title,link from ".TABLE_PERSONAL_PUBLICATION." where personal_id='".$personal_row['personal_id']."' order by publication_id";
				 $publicationsResult = com_db_query($publicationsQuery);
				 if($publicationsResult){
					 $publications_num_rows = com_db_num_rows($publicationsResult);
				 }
				if($publications_num_rows > 0){ ?>
				<li>
					<div class="heading">
						<h5><span class="ico publication-ico"></span>Publications</h5>
					</div>
					<div class="interest-cnt">
                    	<p>
                    	<? 	$publications=1;
							while($publicationsRow = com_db_fetch_array($publicationsResult)){
								if($publications==1){
									echo $personal_row['first_name'].' published "<a href="'.$publicationsRow['link'].'">'. com_db_output($publicationsRow['title']).'</a>". ';
								}else{
									echo '<br>'.$personal_row['first_name'].' published "<a href="'.$publicationsRow['link'].'">'. com_db_output($publicationsRow['title']).'</a>". ';
								}
								$publications++;
							}
                        ?>
                        </p>
					</div>
				</li>
                <? } ?>
                <? 		
				if($personal_row['about_company'] !=''){ ?>
				<li>
					<div class="heading">
						<h5><span class="ico company-ico"></span>About Company <em><?=com_db_output($personal_row['company_name'])?></em></h5>
					</div>
					<div class="interest-cnt">
						    <? 
							$abcom =explode(" ", $personal_row['about_company']);
							$aboutCompany='';
							if(sizeof($abcom)>30){
								for($j=0;$j<30;$j++){
									if($aboutCompany==''){
										$aboutCompany= $abcom[$j];
									}else{
										$aboutCompany .= " ".$abcom[$j];
									}
								}
								$aboutCompany .= " ...";
							}else{
								$aboutCompany= $personal_row['about_company'];
							}
							$i=1;
							?>
                        	<div id="profile_shot_<?php echo $i?>"><?php echo $aboutCompany;?></div>
                        	<? if(sizeof($abcom)>30){?>
                            <div id="profile_<?php echo $i?>" style="display:none;"><?php echo $personal_row['about_company'];?></div>
                        	<div id="more_<?=$i?>" style="display:block">
                              <a href="javascript:Show_Profile('profile_<?php echo $i?>','profile_shot_<?php echo $i?>','less_<?=$i?>','more_<?=$i?>');">More >></a>
                             </div>
                             <div id="less_<?=$i?>" style="display:none">
                             <a href="javascript:Hide_Profile('profile_<?php echo $i?>','profile_shot_<?php echo $i?>','less_<?=$i?>','more_<?=$i?>');">&lt;&lt;Less</a>
                            </div>
                            <? } ?>
					</div>
				</li>
                <? } ?>
			</ul>
		</div>
		<!-- /shell -->
	</div>
	<!-- /interests -->

	<div class="list-profiles">
		<div class="shell clearfix">
        	<?php //same company other Executives
			 $exeQuery = "select mm.personal_id,mm.title,pm.first_name, pm.last_name, pm.personal_image from ".TABLE_MOVEMENT_MASTER." as mm,".TABLE_PERSONAL_MASTER." as pm where mm.personal_id=pm.personal_id and mm.company_id='".$personal_row['company_id']."' and mm.personal_id <>'".$personal_id."' ORDER BY RAND() LIMIT 5";
			 $exeResult = com_db_query($exeQuery);
			 if($exeResult){
				 $exe_num_rows = com_db_num_rows($exeResult);
			 }
			if($exe_num_rows > 0){ 
			?>
			<div class="more-profiles">
				<h4>
					Other Executives<br />
					at <?=com_db_output($personal_row['company_name'])?></em>:
				</h4>
				<? while($exeRow = com_db_fetch_array($exeResult)){ ?>
				<div class="person">
                	<? if($exeRow['personal_image'] !='') { ?>
					<div class="person-img">
						<img src="<?=HTTP_CTO_URL?>personal_photo/small/<?=$exeRow['personal_image']?>" alt="<?=com_db_output($exeRow['first_name'].' '.$exeRow['last_name']);?>" />
					</div>
                    <? }else{ ?>
                    <div class="person-img">&nbsp;</div>
                    <? } ?>
					<div class="person-cnt">
						<h5><a href="<?=HTTP_SERVER?><?=com_db_output($exeRow['first_name'].'_'.$exeRow['last_name'])?>_Exec_<?=$exeRow['personal_id']?>"><?=com_db_output($exeRow['first_name'].' '.$exeRow['last_name'])?></a></h5>
						<p><?=com_db_output($exeRow['title'])?> at <?=com_db_output($personal_row['company_name'])?></p>
					</div>
				</div>
				<!-- /person -->
				<? } ?>
				
			</div>
            <? } ?>
            <?php //same Industry other Executives
			 $exeIndQuery = "select pm.personal_id,pm.first_name,pm.last_name,pm.personal_image,cm.company_name from ".TABLE_MOVEMENT_MASTER ." as mm, ".TABLE_PERSONAL_MASTER." as pm, ".TABLE_COMPANY_MASTER." as cm where mm.company_id=cm.company_id and mm.personal_id=pm.personal_id and pm.personal_id <>'".$personal_id."' and  cm.industry_id ='".$personal_row['industry_id']."' ORDER BY RAND() LIMIT 5";
			 $exeIndResult = com_db_query($exeIndQuery);
			 if($exeIndResult){
				 $exeInd_num_rows = com_db_num_rows($exeIndResult);
			 }
			if($exeInd_num_rows > 0){ 
				$industry_name = com_db_output(com_db_GetValue("select title from ".TABLE_INDUSTRY." where industry_id='".$personal_row['industry_id']."'"));
			?>
			<div class="more-profiles">
				<h4>
					Other Executives<br />
					in the <?=$industry_name?> Industry
				</h4>
				<? while($exeIndRow = com_db_fetch_array($exeIndResult)){ ?>
				<div class="person">
                	<? if($exeIndRow['personal_image'] !='') { ?>
					<div class="person-img">
						<img src="<?=HTTP_CTO_URL?>personal_photo/small/<?=$exeIndRow['personal_image']?>" alt="" />
					</div>
                    <? }else{ ?>
                    <div class="person-img">&nbsp;</div>
                    <? } ?>
					<div class="person-cnt">
						<h5><a href="<?=HTTP_SERVER?><?=com_db_output($exeIndRow['first_name'].'_'.$exeIndRow['last_name'])?>_Exec_<?=$exeIndRow['personal_id']?>"><?=com_db_output($exeIndRow['first_name'].' '.$exeIndRow['last_name'])?></a></h5>
						<p><?=com_db_output($exeIndRow['title'])?> at <?=com_db_output($exeIndRow['company_name'])?></p>
					</div>
				</div>
				<!-- /person -->
				<? } ?>
			</div>
            <? } ?>
		</div>
		<!-- /shell -->
	</div>
	<!-- /list-profiles -->

	<!-- Footer -->
	<div id="footer">
		<div class="shell">
			<p class="copy">© <?=date("Y");?> CTOsOnTheMove. All rights reserved.</p>
		</div>
	</div>
	<!-- End of Footer -->
	
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
