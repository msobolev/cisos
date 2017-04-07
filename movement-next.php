<?php
include("includes/include-top.php");
$full_name = $_POST['full_name'];
$fullname = explode(' ',$full_name);
$first_name = $fullname[0];

$email = $_POST['email'];
$movement_id = $_REQUEST['mid'];
$personal_id = $_REQUEST['personal_id'];
$action = $_REQUEST['action'];
session_register('sess_referring_links');
$_SESSION['sess_referring_links'] = $_POST['referring_links'];
if($action=='PersonalProfile'){
	$movement_id = $personal_id;
}
if($email !=''){
	$dom_name = explode("@",$email);
	$dname = explode(".", $dom_name[1]);
	$domain_name ='@'.$dname[0]."." ;
	$eda = str_replace("'","", $banned_domain_array);
	$banned_email_array = explode(",", $eda);
	for($dm = 0; $dm < sizeof($banned_email_array); $dm++){
		if(strtoupper($domain_name)==strtoupper($banned_email_array[$dm])){
			if($action=='MovementAppoints'){
				$url = "movement.php?movement_id=".$movement_id;
			}elseif($action=='PersonalProfile'){
				$url = "personal-profile.php?personal_id=".$personal_id;
			}elseif($action=='BrowsePage'){
				$url = 'browse.php';
			}elseif($action=='HomePage'){
				$url = 'index.php';
			}
		}
	}
	if($url !=''){
		com_redirect($url);
	}
}
$isPresent = com_db_GetValue("SELECT  email FROM ". TABLE_VIGILANT_SIGN_UP." WHERE email = '".$email."' or email='".$_REQUEST['nemail']."'");
if($isPresent !=''){
	com_redirect('signup-present.php');
}


if($full_name != '' && $email != ''){
    
    $red_url = HTTP_SERVER."choose-signup-subscription.php?action=NextStep&nemail=".$email."&nfname=".$full_name."&nmid=".$movement_id."&isp=".$isPresent;
    header( 'Location: '.$red_url ) ;
    

?>
<!--
	<html>
		<body>
        <form name="frmAutoSignup" method="post" class="af-form-wrapper" action="http://www.aweber.com/scripts/addlead.pl"  >
		<input type="hidden" name="meta_web_form_id" value="1463965186" />
		<input type="hidden" name="meta_split_id" value="" />
		<input type="hidden" name="listname" value="itleadgen" />
-->                
                
                
                
		<!--<input type="hidden" name="redirect" value="http://www.aweber.com/thankyou-coi.htm?m=text" id="redirect_ab52aa3bd5ddf4f668dab4fcc3000531" />-->
        <!--<input type="hidden" name="redirect" value="http://localhost:90/ananga/cto-new/choose-signup-subscription.php?action=NextStep&nemail=<?//=$email;?>&nfname=<?//=$full_name;?>&nmid=<?//=$movement_id?>" id="redirect_b8044a7d0a8cfea05d776e4548d6d2b8" /> -->       
		
                
                
                
<!--                
                <input type="hidden" name="redirect" value="<?=HTTP_SERVER?>choose-signup-subscription.php?action=NextStep&nemail=<?=$email;?>&nfname=<?=$full_name;?>&nmid=<?=$movement_id?>&isp=<?=$isPresent?>" id="redirect_b8044a7d0a8cfea05d776e4548d6d2b8" />		
		<input type="hidden" name="meta_adtracking" value="My_Web_Form" />
		<input type="hidden" name="meta_message" value="1" />
		<input type="hidden" name="meta_required" value="name,email" />
		<input type="hidden" name="meta_tooltip" value="" />
		<input id="awf_field-30038383" type="hidden" name="name" value="<?=$full_name?>" />
		<input id="awf_field-30038384" type="hidden" name="email" value="<?=$email?>" tabindex="501"  />
		</form>
		<script type="text/javascript" language="javascript">
			document.frmAutoSignup.submit();
		</script>
               
                
		</body>
	</html>
 -->


	<?PHP
}

?>