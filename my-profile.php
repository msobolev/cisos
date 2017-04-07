<?php
include("includes/include-top.php");
$action = $_REQUEST['action'];
$uID = $_SESSION['sess_user_id'];
if($action == 'EditSaveProfile'){
	
	$adminInfo = "select * from ". TABLE_ADMIN_SETTINGS ." where setting_id ='1'";
	$adminResult = com_db_query($adminInfo);
	$adminRow = com_db_fetch_array($adminResult);
	
	$from_admin = $adminRow['site_email_from'];
	$to_admin = $adminRow['site_email_address'];
	
	$site_owner_name = com_db_output($adminRow['site_owner_name']);
	$site_owner_position = com_db_output($adminRow['site_owner_position']);
	
	$site_domain_name = com_db_output($adminRow['site_domain_name']);
	$site_phone_number = com_db_output($adminRow['site_phone_number']);
	$site_company_address = com_db_output($adminRow['site_company_address']);
	$site_company_city  = com_db_output($adminRow['site_company_city']);
	$site_company_state = com_db_output($adminRow['site_company_state']);
	$site_company_zip = com_db_output($adminRow['site_company_zip']);
	
	$fromEmailSent='<table border="0" cellpadding="0" cellspacing="0">
						<tr><td align="left">'.$site_owner_name.'</td></tr>
						<tr><td align="left">'.$site_owner_position.'</td></tr>
						<tr><td align="left">'.$site_domain_name.'</td></tr>
						<tr><td align="left">'.$site_company_address.'</td></tr>
						<tr><td align="left">'.$site_company_city.', '.$site_company_state.'</td></tr>
						<tr><td align="left">'.$site_company_zip.'</td></tr>
						<tr><td align="left">'.$site_phone_number.'</td></tr>
						<tr><td align="left">'.$from_admin.'</td></tr>
					</table>';
	
	$first_name = com_db_input($_POST['first_name']);
	$last_name = com_db_input($_POST['last_name']);
	$title = com_db_input($_POST['title']);
	$company_name = com_db_input($_POST['company_name']);
	$phone = com_db_input($_POST['phone']);
	$email = com_db_input($_POST['email']);
	if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)){ 
		$url = "my-profile.php?action=EditProfile";
		com_redirect($url);
	 }
	 
	 elseif(strpos($email,".edu") > - 1)
	 {
		$url = "my-profile.php?action=EditProfile";
		com_redirect($url);
	 }
	 
	$user_update = "UPDATE " . TABLE_USER . "  set first_name = '$first_name', last_name = '$last_name', title = '$title', company_name = '$company_name', phone = '$phone', email = '$email'  where user_id = '".$uID."'";
	com_db_query($user_update);
	
	//for user email
		  $user_mail_result =com_db_query("select * from " .TABLE_AUTORESPONDERS. " where type='User' and autoresponder_for='user updated profile'");
		  $user_mail_row = com_db_fetch_array($user_mail_result);
	  
		  $subject = "CTOsOnTheMove.com :: ".$user_mail_row['subject'];
		
		  $message = '<a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'index.php"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/logo.jpg"  alt="Logo" width="196" height="32" border="0" title="Logo" /></a>&nbsp;
		  			 <table width="70%" cellspacing="0" cellpadding="3" >
						<tr>
							<td align="left" colspan="2"><b>Dear '.$first_name.', </b>'.com_db_output($user_mail_row['body1']).' '.com_db_output($user_mail_row['body2']).'</td>
						</tr>
						<tr>
							<td align="left" colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td align="left" colspan="2">'.$fromEmailSent.'</td>
						</tr>';
		 
		$message .=	'</table>';
		@send_email($email, $subject, $message, $from_admin);
	    //for Admin
		$admin_mail_result =com_db_query("select * from " .TABLE_AUTORESPONDERS. " where type='Admin' and autoresponder_for='user updated profile'");
		$admin_mail_row = com_db_fetch_array($admin_mail_result);
		$admin_subject = "CTOsOnTheMove.com :: ".$admin_mail_row['subject'];
		$admin_body1 = com_db_output($admin_mail_row['body1']);
		$admin_body2 = com_db_output($admin_mail_row['body2']);

		  $message = '<a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'index.php"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/logo.jpg"  alt="Logo" width="196" height="32" border="0" title="Logo" /></a>&nbsp;
		  			 <table width="70%" cellspacing="0" cellpadding="3" >
						<tr>
							<td align="left" colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td align="left" colspan="2">'.$admin_body1." ".$admin_body2.'</td> 
						</tr>
						<tr>
							<td align="left"><b>Name:</b></td>
							<td align="left">'.$first_name.' '.$last_name.'</td>
						</tr>
						<tr>
							<td align="left"><b>Email:</b></td>
							<td align="left">'.$email.'</td>
						</tr>
						<tr>
							<td align="left" colspan="2">&nbsp;</td>
						</tr>
						<tr>
							<td align="left" colspan="2">'.$fromEmailSent.'</td>
						</tr>';
		 
		$message .=	'</table>';
		@send_email($to_admin, $admin_subject, $message, $from_admin); 
			
	$url = "my-profile.php?action=EditSave";
	com_redirect($url);
}
$profile_result = com_db_query("select * from " . TABLE_USER . " where user_id='".$_SESSION['sess_user_id']."'");
$profile_row = com_db_fetch_array($profile_result);
include(DIR_INCLUDES."header-content-page.php");
?>	 
    <!-- heading start -->
 <div style="margin:0 auto; width:960px;">
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	 <tr>
        <td colspan="2" align="left" valign="top" class="caption-text">
		<?=com_db_GetValue("select page_content from " .TABLE_PAGE_CONTENT . " where page_name='index.php' and page_title='Page Heading'")?>
		</td>
    </tr>
    <tr><td colspan="2">&nbsp;</td></tr> 
    <!-- heading start -->
    <tr>
      <td align="left"  valign="top">&nbsp;</td>
      <td align="left" valign="top"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
	       <tr>
        <td align="left" valign="top" class="header-nav"><a href="<?=HTTP_SERVER?>index.php">Home</a>  /  <a href="#" class="active"><?=$PageTitle;?></a></td>
      </tr>
   <tr>
      <td align="left" valign="top"><img src="images/specer.gif" width="1" height="10" alt="" title="" /></td>
      </tr>
      <tr>
      <td align="left" valign="middle" class="registration-page-heading-bg"><table width="960" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="left" valign="middle" class="my-profile-page-title-text">
		  <?PHP
		  	$subscriptionID = com_db_GetValue("select subscription_id from ".TABLE_USER." where user_id='".$_SESSION['sess_user_id']."'");
		   ?>
		  <strong><a href="<?=HTTP_SERVER?>my-profile.php">My Profile</a></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  <a href="<?=HTTP_SERVER?>my-subscription.php">My Subscription&nbsp;</a>&nbsp;&nbsp;&nbsp;&nbsp;
		  <?PHP if($subscriptionID != 1){ ?>
		  <a href="<?=HTTP_SERVER?>my-alert.php">My Alerts</a>&nbsp;&nbsp;&nbsp;&nbsp;
		  <a href="<?=HTTP_SERVER?>alert.php">Add New Alert</a>&nbsp;&nbsp;&nbsp;&nbsp;
		  <?PHP } ?>
		  <a href="<?=HTTP_SERVER?>my-change-password.php">Change Password</a>
		  
		  <?PHP
		  $user_invoices = this_user_invoices();
		  if(sizeof($user_invoices) > 0)
		  {	 
		  ?>
		  &nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=HTTP_SERVER?>my-invoices.php">Invoices</a>
		  <?PHP
		  }
		  ?>
		  </td>
        </tr>
      </table></td>
      </tr>
	    <tr>
      <td align="left" valign="top" class="registration-page-bg"><img src="images/my-profile-page-down-arrow.gif" width="114" height="21"  alt="" title="" /></td>
      </tr>
      </table></td>
      <td align="left"  valign="top">&nbsp;</td>
    </tr>
    <!-- heading end -->
    <!-- content start -->
   	<tr>
      <td align="left"  valign="top">&nbsp;</td>
      <td align="center" valign="top" class="registration-page-bg"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td align="center" valign="top"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="114" align="left" valign="top">&nbsp;</td>
			  <td align="left" valign="top">
			  	 <?php
                  if($action == '' || $action=='EditSave'){
                  ?>
				  	 <form name="frm_profile" id="frm_profile" method="post" action="my-profile.php?action=EditProfile">
					 <table width="500" border="0" align="left" cellpadding="0" cellspacing="0">
						<tr>
						  <td width="100" height="41" align="left" valign="top" class="content-text"><strong>First Name :</strong></td>
						  <td width="402" height="41" align="left" valign="top" class="content-text"><?=$profile_row['first_name']?></td>
						</tr>
						<tr>
						  <td width="100" height="41" align="left" valign="top" class="content-text"><strong>Last Name :</strong></td>
						  <td height="41" align="left" valign="top" class="content-text"><?=$profile_row['last_name']?></td>
						</tr>
					
						<tr>
						  <td width="100" height="41" align="left" valign="top" class="content-text"><strong>Company :</strong></td>
						  <td height="41" align="left" valign="top" class="content-text"><?=$profile_row['company_name']?></td>
						</tr>
						<tr>
						  <td width="100" height="41" align="left" valign="top" class="content-text"><strong>Phone :</strong></td>
						  <td height="41" align="left" valign="top" class="content-text"><?=$profile_row['phone']?></td>
						</tr>
						<tr>
						  <td width="100" height="41" align="left" valign="top" class="content-text"><strong>Email :</strong></td>
						  <td height="41" align="left" valign="top" class="content-text"><?=$profile_row['email']?></td>
						</tr>
						<tr>
						  <td height="41" align="left" valign="middle">&nbsp;</td>
						  <td height="41" align="left" valign="middle"><table width="200" border="0" align="left" cellpadding="0" cellspacing="0">
							<tr>
							  <td align="center" valign="middle" class="edit-buttn"><a href="javascript:FormValueSubmit('frm_profile');">Edit<img src="images/white-arrow-small.gif" width="12" height="9" alt="" title=""  border="0"/></a></td>
							  <td align="center" valign="middle">&nbsp;</td>
							  <td align="center" valign="middle" class="save-buttn"><a href="#">Save<img src="images/white-arrow-small.gif" width="12" height="9" alt="" title=""  border="0"/></a></td>
							</tr>
						  </table></td>
						</tr>
					  </table>
					  </form>
					 <?PHP }elseif($action == 'EditProfile'){ ?>
					 	<form name="frm_edit_profile" id="frm_edit_profile" method="post" action="my-profile.php?action=EditSaveProfile">
						<table width="500" border="0" align="left" cellpadding="0" cellspacing="0">
							<tr>
							  <td width="100" height="41" align="left" valign="middle" class="content-text"><strong>First Name :</strong></td>
							  <td width="410" height="41" align="left" valign="middle" class="content-text"><input name="first_name" type="text" id="first_name"  value="<?php if($profile_row['first_name'] == ''){ echo 'Type in your first name';} else { echo $profile_row['first_name'];} ?>" size="46" class="list-field" onfocus="fieldHighlight('first_name');" onblur="if (this.value == '') { this.value='Type in your first name';};fieldLosslight('first_name');"/></td>
							</tr>
							<tr>
							  <td width="100" height="41" align="left" valign="middle" class="content-text"><strong>Last Name :</strong></td>
							  <td height="41" align="left" valign="middle" class="content-text"><input name="last_name" type="text" id="last_name" value="<?php if($profile_row['last_name'] == ''){ echo 'Type in your last name';} else { echo $profile_row['last_name'];} ?>" size="46" class="list-field" onfocus="fieldHighlight('last_name');" onblur="if (this.value == '') { this.value='Type in your last name';};fieldLosslight('last_name');"/></td>
							</tr>
							
							<tr>
							  <td width="100" height="41" align="left" valign="middle" class="content-text"><strong>Company :</strong></td>
							  <td height="41" align="left" valign="middle" class="content-text"><input name="company_name" type="text" id="company_name" value="<?php if($profile_row['company_name'] == ''){ echo 'Type in the company name';} else { echo $profile_row['company_name'];} ?>" size="46" class="list-field" onfocus="fieldHighlight('company_name');" onblur="if (this.value == '') { this.value='Type in the company name';};fieldLosslight('company_name');"/></td>
							</tr>
							<tr>
							  <td width="100" height="41" align="left" valign="middle" class="content-text"><strong>Phone :</strong></td>
							  <td height="41" align="left" valign="middle" class="content-text">
								<input name="phone" type="text" id="phone"  value="<?php if($profile_row['phone'] == ''){ echo 'Type in your phone';} else { echo $profile_row['phone'];} ?>" size="46" class="list-field" onfocus="fieldHighlight('phone');" onblur="if (this.value == '') { this.value='Type in your phone';};fieldLosslight('phone');"/></td>
							</tr>
							<tr>
							  <td width="100" height="41" align="left" valign="middle" class="content-text"><strong>Email :</strong></td>
							  <td height="41" align="left" valign="middle" class="content-text">
								<input name="email" type="text" id="email"  value="<?php if($profile_row['email'] == ''){ echo 'Type in your e-mail address';} else { echo $profile_row['email'];} ?>" size="46" class="list-field" onfocus="fieldHighlight('email');" onblur="if (this.value == '') { this.value='Type in your e-mail address';};fieldLosslight('email');"/></td>
							</tr>
							<tr>
							  <td width="100" height="41" align="left" valign="middle">&nbsp;</td>
							  <td height="41" align="left" valign="middle"><table width="200" border="0" align="left" cellpadding="0" cellspacing="0">
								<tr>
									<td align="center" valign="middle" class="save-buttn"><a href="#">Edit<img src="images/white-arrow-small.gif" width="12" height="9" alt="" title=""  border="0"/></a></td>
								  <td align="center" valign="middle">&nbsp;</td>
								  <td align="center" valign="middle" class="edit-buttn"><a href="javascript:FormValueSubmit('frm_edit_profile');">Save<img src="images/white-arrow-small.gif" width="12" height="9" alt="" title=""  border="0"/></a></td>
								</tr>
							  </table></td>
							</tr>
					  </table>
					  </form>
					 <?PHP } ?>
				</td>
            </tr>
            <tr>
              <td width="114" align="left" valign="top">&nbsp;</td>
              <td align="left" valign="top">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td align="center" valign="top"><img src="images/registration-page-bottom-bg.jpg" width="960" height="11" alt="" title="" /></td>
        </tr>
      </table></td>
      <td align="left"  valign="top">&nbsp;</td>
    </tr>
 </table>
    </div>
    <!-- content end-->
<?php      
include(DIR_INCLUDES."footer-content-page.php");
?>