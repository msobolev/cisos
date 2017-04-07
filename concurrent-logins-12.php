<?php
include("includes/include-top.php");
$fpaction = $_REQUEST['fpaction'];

if($fpaction == 'MailSent'){
	$email = $_POST['email'];
	$user_query = "select * from " . TABLE_USER ." where email = '".$email."'";
	$user_result = com_db_query($user_query);
	if($user_result){
		$row_count = com_db_num_rows($user_result);
		if($row_count > 0){
			$user_row = com_db_fetch_array($user_result);
			$user_name = $user_row['first_name'];
			$password = $user_row['password'];
			
			$to = $email;
			//$from = com_db_GetValue("select site_email_from from " . TABLE_ADMIN_SETTINGS);
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
			$site_company_state = com_db_output($adminRow['site_company_state']);
			$site_company_zip = com_db_output($adminRow['site_company_zip']);
			
			$fromEmailSent='<table border="0" cellpadding="0" cellspacing="0">
								<tr><td align="left">'.$site_owner_name.'</td></tr>
								<tr><td align="left">'.$site_owner_position.'</td></tr>
								<tr><td align="left">'.$site_domain_name.'</td></tr>
								<tr><td align="left">'.$site_company_address.'</td></tr>
								<tr><td align="left">'.$site_company_state.'</td></tr>
								<tr><td align="left">'.$site_company_zip.'</td></tr>
								<tr><td align="left">'.$site_phone_number.'</td></tr>
								<tr><td align="left">'.$from_admin.'</td></tr>
							</table>';
			
	  
	  		$user_mail_result =com_db_query("select * from " .TABLE_AUTORESPONDERS. " where type='User' and autoresponder_for='user forgot login/password'");
		  	$user_mail_row = com_db_fetch_array($user_mail_result);
		  
	  		$subject = "CTOsOnTheMove.com :: ".$user_mail_row['subject'];
	 	
	  		$message = '<a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'index.php"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/logo.jpg"  alt="Logo" width="196" height="32" border="0" title="Logo" /></a>&nbsp;
						<table width="70%" cellspacing="0" cellpadding="3" >
						
							<tr>
								<td align="left"><b>Dear '.$user_name.',</b></td>
							</tr>
							<tr>
								<td align="left">'.com_db_output($user_mail_row['body1']).' ' .com_db_output($user_mail_row['body2']).'</td>
							</tr>
							<tr>
								<td align="left">Your Login : '.$email.'</td>
							</tr>
							<tr>
								<td align="left">Your Password : '.$password.'</td>
							</tr>
							<tr>
								<td align="left"">&nbsp;</td>
							</tr>
							<tr>
								<td align="left">'.$fromEmailSent.'</td>
							</tr>';
			  
			$message .=	'</table>';
			
			@send_email($to, $subject, $message, $from_admin); 
			
			$url = "forgot-password.php?fpaction=InboxMail";
			com_redirect($url);
		}else{
			$url = "forgot-password.php?fpaction=NotFound";
			com_redirect($url);
		}	
	}	
}

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
	 
    <!-- content start -->
    <tr>
      <td align="left"  valign="top">&nbsp;</td>
      <td align="center" valign="top"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" valign="top"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td align="left" valign="middle" class="advance-search-page-heading-bg"><table width="960" border="0" align="left" cellpadding="0" cellspacing="0">
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle" class="forgot-password-title-text">Concurrent  Logins?</td>
                  </tr>
               
                  <tr>
                    <td align="center" valign="middle">&nbsp;</td>
                  </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td align="center" valign="top" class="registration-page-bg">
		  
			<table width="675" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
				  <td align="left" valign="top"><img src="images/specer.gif" width="1" height="30" alt="" title="" /></td>
				</tr>
				<tr>
				  <td align="left" valign="top" class="forgot-password-box-text"><p>This login/password combination is already in use. Please <a href="<?=HTTP_SERVER?>provide-contact-information.php">signup</a> for your own account here</p>                </td>
				</tr>
	
				<tr>
				  <td align="left" valign="top"><img src="images/specer.gif" width="1" height="60" alt="" title="" /></td>
				</tr>
				<tr>
				  <td align="center" valign="top">
				  <div id="ForgotPass" style="display:none;">
					  <form name="frm_pass" id="frm_pass" method="post" action="forgot-password.php?fpaction=MailSent">
					  <table width="675" border="0" align="center" cellpadding="0" cellspacing="0">
						<tr>
						  <td width="462" align="left" valign="middle"><input type="text" name="email" id="email" class="forgot-password-text-field" value='Type in your email address, associated with your profile'  onfocus=" if (this.value == 'Type in your email address, associated with your profile') { this.value = ''; }" onblur="if (this.value == '') { this.value='Type in your email address, associated with your profile';} " /></td>
						 <td width="466" align="left" valign="middle"><table width="107" border="0" align="left" cellpadding="0" cellspacing="0">
							<tr>
							  <td align="center" valign="top" class="inner-page-search-buttn"><a href="javascript:FormValueSubmit('frm_pass');">Send</a></td>
							</tr>
						  </table></td>
						</tr>
					  </table>
					  </form>
				  </div>
				  </td>
				</tr>
				<tr>
				  <td align="center" valign="top">&nbsp;</td>
				</tr>
			  </table>
		   
		  </td>
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