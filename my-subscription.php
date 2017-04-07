<?php
include("includes/include-top.php");
$action = $_REQUEST['action'];
$divID = $_REQUEST['divID'];
$mode = $_REQUEST['mode'];
$alert_id = $_REQUEST['alert_id'];
$card_id = $_REQUEST['card_id'];
$userID = $_REQUEST['userID'];
$id = $_REQUEST['id'];

switch($action){

	case 'SubscriptionLevel':
		  $subscription_level = $_POST['subscription_level'];
		  	com_redirect("choose-subscription.php?resID=".$userID);
		  break;
		  
	case 'SubscriptionStatus':
		  $subscription_status = $_POST['subscription_status'];
		  if($subscription_status=='Active'){
		  	  $status = 0;
		  }elseif($subscription_status=='Inactive'){
			  $status = 1;
		  }
		  
		 //Email send
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
						
		 $subscription_email_send = com_db_query("select first_name,last_name,email from " .TABLE_USER ." where user_id='".$_SESSION['sess_user_id']."'");
		 $subscription_email_send_row = com_db_fetch_array($subscription_email_send);
		 $user_email = $subscription_email_send_row['email'];
		 $first_name = $subscription_email_send_row['first_name'];
		 $last_name = $subscription_email_send_row['last_name'];
		 
		  if($status == '1'){
			 //for admin email
			$admin_mail_result =com_db_query("select * from " .TABLE_AUTORESPONDERS. " where type='Admin' and autoresponder_for='User canceled registration'");
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
								<td align="left">'.$user_email.'</td>
							</tr>
							<tr>
								<td align="left" colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td align="left" colspan="2">'.$fromEmailSent.'</td>
							</tr>';
			 
			$message .=	'</table>';
			@send_email($to_admin, $admin_subject, $message, $from_admin); 
		
		//for user email
		  $user_mail_result =com_db_query("select * from " .TABLE_AUTORESPONDERS. " where type='User' and autoresponder_for='User canceled registration'");
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
		@send_email($user_email, $subject, $message, $from_admin);
		}
		if($status == '0'){
			//for Admin
			$admin_mail_result =com_db_query("select * from " .TABLE_AUTORESPONDERS. " where type='Admin' and autoresponder_for='user renewed the subscription'");
			$admin_mail_row = com_db_fetch_array($admin_mail_result);
			$admin_subject = "CTOsOnTheMove.com :: ".$admin_mail_row['subject'];
			$admin_body1 = com_db_output($admin_mail_row['body1']);
			$admin_body2 = com_db_output($admin_mail_row['body2']);
	
			  $message = '<a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'index.php"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/logo.jpg"  alt="Logo" width="196" height="32" border="0" title="Logo" /></a>&nbsp;
			  			<table width="70%" cellspacing="0" cellpadding="3" >
							
							<tr>
								<td align="left" colspan="2">'.$admin_body1." ".$admin_body2.'</td> 
							</tr>
							<tr>
								<td align="left"><b>Name:</b></td>
								<td align="left">'.$first_name.' '.$last_name.'</td>
							</tr>
							<tr>
								<td align="left"><b>Email:</b></td>
								<td align="left">'.$user_email.'</td>
							</tr>
							<tr>
								<td align="left" colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td align="left" colspan="2">'.$fromEmailSent.'</td>
							</tr>';
			 
			$message .=	'</table>';
			@send_email($to_admin, $admin_subject, $message, $from_admin); 
			 //for user			  
			  $user_mail_result =com_db_query("select * from " .TABLE_AUTORESPONDERS. " where type='User' and autoresponder_for='user renewed the subscription'");
			  $user_mail_row = com_db_fetch_array($user_mail_result);
			  
			  $subject = "CTOsOnTheMove.com :: ".$user_mail_row['subject'];
			  			
			  $message = ' <a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'index.php"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/logo.jpg"  alt="Logo" width="196" height="32" border="0" title="Logo" /></a>&nbsp;
			  				<table width="70%" cellspacing="0" cellpadding="3" >
								<tr>
									<td align="left" colspan="2"><b>Dear '.$first_name.',</b>'.com_db_output($user_mail_row['body1']).' '.com_db_output($user_mail_row['body2']).'</td>
								</tr>
								<tr>
									<td align="left" colspan="2">&nbsp;</td>
								</tr>
								<tr>
									<td align="left" colspan="2">'.$fromEmailSent.'</td>
								</tr>';
			 
			$message .=	'</table>';
			@send_email($user_email, $subject, $message, $from_admin);
		
		}

		  com_db_query("update " . TABLE_USER . " set status ='".$status."' where user_id='".$userID."'");
		  break;
		  
	case 'SubscriptionExpDate':
		  $exp_dt = explode('/', $_POST['sub_exp_date']);
		  $sub_exp_date = $exp_dt[2]."-".$exp_dt[0]."-".$exp_dt[1];
		  com_db_query("update " . TABLE_USER . " set exp_date ='".$sub_exp_date."' where user_id='".$userID."'");
		  break;
		  	  
	case 'SubscriptionEmailFrequency':
		  $email_update_fequency = $_POST['email_update_fequency'];
		  com_db_query("update " . TABLE_USER . " set update_frequency ='".$email_update_fequency."' where user_id='".$userID."'");
		  break;	
	
	case 'AlertLevel':
		  $alert_level = $_POST['alert_level'];
		  com_db_query("update " . TABLE_ALERT . " set level ='".$alert_level."' where alert_id='".$alert_id."'");
		  break;
		  
	case 'AlertStatus':
		  $alert_status = $_POST['alert_status'];
		  if($alert_status =='Active'){
		      $status = 0;
		  }elseif($alert_status=='Inactive'){
			  $status = 1;
		  }
		  com_db_query("update " . TABLE_ALERT . " set status ='".$status."' where alert_id='".$alert_id."'");
		  break;
		  
	case 'AlertExpDate':
	   	  $exp_dt = explode('/', $_POST['alert_exp_date']);
		  $alert_exp_date = $exp_dt[2]."-".$exp_dt[0]."-".$exp_dt[1];
		  com_db_query("update " . TABLE_ALERT . " set exp_date ='".$alert_exp_date."' where alert_id='".$alert_id."'");
		  break;	  	  
		  	  	  
			
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
    <!-- heading start -->
	<tr>
      <td align="left"  valign="top">&nbsp;</td>
      <td align="left" valign="top">
	  <table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
	       <tr>
        	<td align="left" valign="top" class="header-nav"><a href="<?=HTTP_SERVER?>index.php">Home</a>  /  <a href="#" class="active"><?=$PageTitle;?></a></td>
      	   </tr>
   		   <tr>
      		<td align="left" valign="top"><img src="images/specer.gif" width="1" height="10" alt="" title="" /></td>
      	   </tr>
           <tr>
      		<td align="left" valign="middle" class="registration-page-heading-bg">
				<table width="960" border="0" align="left" cellpadding="0" cellspacing="0">
        			<tr>
					  <td>&nbsp;</td>
					</tr>
					<tr>
					  <td align="left" valign="middle" class="my-profile-page-title-text"><a href="<?=HTTP_SERVER?>my-profile.php">My Profile</a>&nbsp;&nbsp;&nbsp;&nbsp;<strong>&nbsp;<a href="<?=HTTP_SERVER?>my-subscription.php">My Subscription&nbsp;</a>&nbsp;</strong>&nbsp;&nbsp;&nbsp;<a href="<?=HTTP_SERVER?>my-alert.php">My Alerts</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=HTTP_SERVER?>alert.php">Add New Alert</a>&nbsp;&nbsp;&nbsp;&nbsp;
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
      			</table>
			</td>
      	</tr>
	    <tr>
      		<td align="left" valign="top" class="registration-page-bg"><img src="images/my-subscription-down-arrow.jpg" width="202" height="21"  alt="" title="" /></td>
        </tr>
        </table>
	  </td>
      <td align="left"  valign="top">&nbsp;</td>
    </tr>
    <!-- heading end -->
    <!-- content start -->
   	<tr>
      <td align="left"  valign="top">&nbsp;</td>
      <td align="center" valign="top" class="registration-page-bg"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
         <td align="left" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td align="center" valign="top"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="114" align="left" valign="top">&nbsp;</td>
              <td align="left" valign="top">
			  
			  
				  <table width="641" border="0" align="left" cellpadding="0" cellspacing="0">
				  		<tr>
							<td  align="left" valign="top">
								<?php
								$subscription_result = com_db_query("select * from ".TABLE_USER." where user_id='".$_SESSION['sess_user_id']."'");	
								$subscription_row = com_db_fetch_array($subscription_result);
								?>
								<div id="sub-level-change" style="display:<?PHP if($divID == 'sub-level-save'){echo 'none';}else{ echo 'block';}?>;">
								
								<table width="99%" align="left" cellpadding="0" cellspacing="0">
									<tr>
										<td width="258" height="36" align="left" valign="top" class="content-text"><strong>Subscription Level:</strong></td>
										<td width="164" align="left" valign="top" class="form-content-text"><?=$subscription_row['level']?>	</td>
										<td width="112" align="left" valign="top" <?PHP if($mode=='Edit'){ echo 'class="deactive-button"';}else{ echo 'class="active-button"';}?>>
											<?PHP if($mode!='Edit'){?>
											<a href="javascript:MySubscriptionChange('sub-level-save','<?=$subscription_row['subscription_id'];?>','SubscriptionLevel','<?=$mode;?>');">
											<?PHP }else{ ?>
											<a href="#">
											<?PHP } ?>
											Change<img src="images/white-arrow-small.gif" width="12" height="9" alt="" title=""  border="0"/></a></td>
										<td width="107" align="left" valign="top" class="deactive-button"><a href="#">Save&nbsp;<img src="images/white-arrow-small.gif" width="12" height="9" alt="" title=""  border="0"/></a></td>
								  </tr>
								</table>
								</div>
								<div id="sub-level-save" style="display:<?PHP if($divID == 'sub-level-save'){echo 'block';}else{ echo 'none';}?>;">
								<form name="frmSubscriptionLevel" id="frmSubscriptionLevel" method="post" action="my-subscription.php?userID=<?=$subscription_row['user_id']?>&action=SubscriptionLevel">
								<table width="99%" align="left" cellpadding="0" cellspacing="0">
									<tr>
										<td width="258" height="36" align="left" valign="top" class="content-text"><strong>Subscription Level:</strong></td>
										<td width="164" align="left" valign="top" class="form-content-text">
										 
										  
										   <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" class="my_div_small">
												<tr>
												  <td valign="top">
														<input type="text" name="subscription_level" id="subscription_level" class="text-new-100" value="<?=$subscription_row['level']?>" style="margin-top:0px; border:0px solid #000000; color:#737373;" onfocus="MyCombo_Open('div_subscription_level');fieldHighlightCombo2('subscription_level');" onblur="fieldLosslightCombo2('subscription_level');" size="13"/>
														<img src="images/down.png" align="right" width="20" height="20" onclick="MyCombo_Open('div_subscription_level');"/></td>
												</tr>
												<tr>
													<td valign="top">
														<div id="div_subscription_level" class="middle" style="display:none; position:absolute;">
															<a href="javascript:TextboxValueChange('subscription_level','div_subscription_level','Paid');">Paid</a><br />
															<a href="javascript:TextboxValueChange('subscription_level','div_subscription_level','Free');">Free</a><br />
														</div>								
														</td>
												</tr>
											</table>
										  
										</td>
										<td width="112" align="left" valign="top"  class="deactive-button"><a href="#">Change<img src="images/white-arrow-small.gif" width="12" height="9" alt="" title=""  border="0"/></a></td>
										<td width="107" align="left" valign="top" <?PHP if($mode=='Edit' && $divID =='sub-level-save' ){ echo 'class="active-button"';}else{ echo 'class="deactive-button"';}?>><a href="javascript:FormValueSubmit('frmSubscriptionLevel');">Save <img src="images/white-arrow-small.gif" width="12" height="9" alt="" title=""  border="0"/></a></td>
									  </tr>
								</table>
								</form>
								</div>
							</td>
						</tr>
					  	<tr>
							<td>
								<div id="sub-status-change" style="display:<?PHP if($divID == 'sub-status-save'){echo 'none';}else{ echo 'block';}?>;">
								<table width="99%" align="left" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td width="258" height="36" align="left" valign="top" class="content-text"><strong>Status:</strong></td>
										<td width="164" align="left" valign="top" class="form-content-text"><?PHP if($subscription_row['status']=='0'){echo 'Active';}else{echo 'Inactive';} ?> </td>
										  <td width="112" align="left" valign="top" <?PHP if($mode=='Edit'){ echo 'class="deactive-button"';}else{ echo 'class="active-button"';}?>>
										  	<?PHP if($mode!='Edit'){?>
												<a href="javascript:MySubscriptionChange('sub-status-save','<?=$subscription_row['subscription_id']?>','SubscriptionLevel','<?=$mode?>')">
											<?PHP }else{?>
												<a href="#">
											<?PHP } ?>
											Change<img src="images/white-arrow-small.gif" width="12" height="9" alt="" title=""  border="0"/></a></td>
										  <td width="107" align="left" valign="top" class="deactive-button"><a href="#">Save<img src="images/white-arrow-small.gif" width="12" height="9" alt="" title=""  border="0"/></a></td>
									 </tr>
								</table>
								</div>
								<div id="sub-status-save" style="display:<?PHP if($divID == 'sub-status-save'){echo 'block';}else{ echo 'none';}?>;">
								<form name="frmSubscription" id="frmSubscriptionStatus" method="post" action="my-subscription.php?userID=<?=$subscription_row['user_id']?>&action=SubscriptionStatus">
								<table width="99%" align="left" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td width="258" height="36" align="left" valign="top" class="content-text"><strong>Status:</strong></td>
										<td width="164" align="left" valign="top" class="form-content-text">
										  
										    <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" class="my_div_small">
												<tr>
												  <td valign="top">
														<input type="text" name="subscription_status" id="subscription_status" class="text-new-100" value="<?PHP if($subscription_row['status']=='0'){echo 'Active';}else{echo 'Inactive';} ?>" style="margin-top:0px; border:0px solid #000000; color:#737373;" onfocus="MyCombo_Open('div_subscription_status');fieldHighlightCombo2('subscription_status');" onblur="fieldLosslightCombo2('subscription_status');" size="13"/>
														<img src="images/down.png" align="right" width="20" height="20" onclick="MyCombo_Open('div_subscription_status');"/></td>
												</tr>
												<tr>
													<td valign="top">
														<div id="div_subscription_status" class="middle" style="display:none; position:absolute;">
															<a href="javascript:TextboxValueChange('subscription_status','div_subscription_status','Active');">Active</a><br />
															<a href="javascript:TextboxValueChange('subscription_status','div_subscription_status','Inactive');">Inactive</a><br />
														</div>								
														</td>
												</tr>
											</table>
											
										  </td>
										  <td width="112" align="left" valign="top"  class="deactive-button"><a href="#">Change<img src="images/white-arrow-small.gif" width="12" height="9" alt="" title=""  border="0"/></a></td>
										  <td width="107" align="left" valign="top"  <?PHP if($mode=='Edit' && $divID =='sub-status-save' ){ echo 'class="active-button"';}else{ echo 'class="deactive-button"';}?>><a href="javascript:FormValueSubmit('frmSubscriptionStatus');">Save<img src="images/white-arrow-small.gif" width="12" height="9" alt="" title=""  border="0"/></a></td>
									 </tr>
								</table>
								</form>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<?php
								$exp_dt = explode("-",$subscription_row['exp_date']);
								$expiry_date = $exp_dt[1]."/".$exp_dt[2]."/".$exp_dt[0];
								?>
								<div id="sub-exp-date-change" style="display:<?PHP if($divID == 'sub-exp-date-save'){echo 'none';}else{ echo 'block';}?>;">
								<table width="99%" align="left" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td width="258" height="36" align="left" valign="top" class="content-text"><strong>Expiration Date:</strong></td>
										<td width="164" height="36" align="left" valign="middle"  class="form-content-text"><?=$expiry_date?></td>
										<td width="112" align="left" valign="middle" <?PHP if($mode=='Edit'){ echo 'class="deactive-button"';}else{ echo 'class="active-button"';}?>>
										 
										<?PHP if($mode!='Edit'){?>
										<a href="javascript:MySubscriptionChange('sub-exp-date-save','<?=$subscription_row['subscription_id'];?>','SubscriptionExpDate','<?=$mode;?>');">
										<?PHP }else{ ?>
										<a href="#">
										<?PHP } ?>
										Change<img src="images/white-arrow-small.gif" width="12" height="9" alt="" title=""  border="0"/></a></td>
										<td width="107" align="left" valign="middle"  class="deactive-button"><a href="#">Save<img src="images/white-arrow-small.gif" width="12" height="9" alt="" title=""  border="0"/></a></td>
									  </tr>
									 
								</table>
								</div>
								<div id="sub-exp-date-save" style="display:<?PHP if($divID == 'sub-exp-date-save'){echo 'block';}else{ echo 'none';}?>;">
								<form name="frmExpDate" id="frmExpDate" method="post" action="my-subscription.php?userID=<?=$subscription_row['user_id']?>&&action=SubscriptionExpDate">
								<table width="99%" align="left" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td width="258" height="36" align="left" valign="top" class="content-text"><strong>Expiration Date:</strong></td>
										<td width="164" height="36" align="left" valign="middle"  class="form-content-text">
										  <input type="text" name="sub_exp_date" id="sub_exp_date"  value="<?=$expiry_date?>" class="list-field-small"  onfocus=" if (this.value == '12/31/2013') { this.value = ''; };fieldHighlightCombo3('ex_date2');" onblur="if (this.value == '') { this.value='12/31/2013';};fieldLosslightCombo3('ex_date2');"/>
										</td>
										<td width="112" align="left" valign="middle"  class="deactive-button"><a href="#">Change<img src="images/white-arrow-small.gif" width="12" height="9" alt="" title=""  border="0"/></a></td>
										<td width="107" align="left" valign="middle"  <?PHP if($mode=='Edit' && $divID =='sub-exp-date-save' ){ echo 'class="active-button"';}else{ echo 'class="deactive-button"';}?>><a href="javascript:FormValueSubmit('frmExpDate');">Save<img src="images/white-arrow-small.gif" width="12" height="9" alt="" title=""  border="0"/></a></td>
									  </tr>
									  
								</table>
								</form>
								</div>
							</td>
						</tr>	
						<tr>
							<td>
								<div id="sub-email-frequency-change" style="display:<?PHP if($divID == 'sub-email-frequency-save'){echo 'none';}else{ echo 'block';}?>;">
								<table width="99%" align="left" cellpadding="0" cellspacing="0" border="0">
									
									  <tr>
										<td width="258" height="41" align="left" valign="top" class="content-text"><strong>Email Update Frequency:</strong></td>
										<td width="164" align="left" valign="top" class="form-content-text"><?=$subscription_row['update_frequency']?></td>
										<td width="112" align="left" valign="top" <?PHP if($mode=='Edit'){ echo 'class="deactive-button"';}else{ echo 'class="active-button"';}?>>
											<?PHP if($mode!='Edit'){?>
											<a href="javascript:MySubscriptionChange('sub-email-frequency-save','<?=$subscription_row['subscription_id'];?>','SubscriptionEmailFrequency','<?=$mode;?>');">
											<?PHP }else{ ?>
											<a href="#">
											<?PHP } ?>
											Change<img src="images/white-arrow-small.gif" width="12" height="9" alt="" title=""  border="0"/></a></td>
										<td width="107" align="left" valign="top"  class="deactive-button"><a href="#">Save<img src="images/white-arrow-small.gif" width="12" height="9" alt="" title=""  border="0"/></a></td>
									  </tr>
								</table>
								</div>
								<div id="sub-email-frequency-save" style="display:<?PHP if($divID == 'sub-email-frequency-save'){echo 'block';}else{ echo 'none';}?>;">
								<form name="frmEmailFrequency" id="frmEmailFrequency" method="post" action="my-subscription.php?userID=<?=$subscription_row['user_id']?>&action=SubscriptionEmailFrequency">
								<table width="99%" align="left" cellpadding="0" cellspacing="0" border="0">
									
									  <tr>
										<td width="258" height="41" align="left" valign="top" class="content-text"><strong>Email Update Frequency:</strong></td>
										<td width="164" align="left" valign="top" class="form-content-text">
											
											 <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" class="my_div_small">
												<tr>
												  <td valign="top">
														<input type="text" name="email_update_fequency" id="email_update_fequency" class="text-new-100" value="<?=$subscription_row['update_frequency']?>" style="margin-top:0px; border:0px solid #000000; color:#737373;" onfocus="MyCombo_Open('div_email_update_fequency');fieldHighlightCombo2('email_update_fequency');" onblur="fieldLosslightCombo2('email_update_fequency');" size="13"/>
														<img src="images/down.png" align="right" width="20" height="20" onclick="MyCombo_Open('div_email_update_fequency');"/></td>
												</tr>
												<tr>
													<td valign="top">
														<div id="div_email_update_fequency" class="middle" style="display:none; position:absolute;">
															<?=DivContentLoad('div_email_update_fequency','email_update_fequency','name',TABLE_EMAIL_UPDATE)?>
														</div>								
														</td>
												</tr>
											</table>
										</td>
										<td width="112" align="left" valign="top"  class="deactive-button"><a href="#">Change<img src="images/white-arrow-small.gif" width="12" height="9" alt="" title=""  border="0"/></a></td>
										<td width="107" align="left" valign="top" <?PHP if($mode=='Edit' && $divID =='sub-email-frequency-save' ){ echo 'class="active-button"';}else{ echo 'class="deactive-button"';}?>><a href="javascript:FormValueSubmit('frmEmailFrequency');">Save<img src="images/white-arrow-small.gif" width="12" height="9" alt="" title=""  border="0"/></a></td>
									  </tr>
								</table>
								</form>
								</div>
							</td>
						</tr>
						<tr><td height="41" align="left" valign="middle">&nbsp;</td>
						<?php
						$alert_result = com_db_query("select * from ".TABLE_ALERT." where user_id='".$_SESSION['sess_user_id']."' order by add_date desc");	
						if($alert_result){
							$alert_num = com_db_num_rows($alert_result);
						}
						if($alert_num){	
						$alert_row = com_db_fetch_array($alert_result);
						?>
						<tr>
							<td>
								
								<div id="alert-level-change" style="display:<?PHP if($divID == 'alert-level-save'){echo 'none';}else{ echo 'block';}?>;">
								<table width="99%" align="left" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td width="258" height="36" align="left" valign="top" class="content-text"><strong>Alert Level:</strong></td>
										<td width="164" height="41" align="left" valign="top" class="form-content-text"><?=$alert_row['level']?> </td>
										<td width="112" align="left" valign="top" <?PHP if($mode=='Edit'){ echo 'class="deactive-button"';}else{ echo 'class="active-button"';}?>>
											
											<?PHP if($mode!='Edit'){?>
											<a href="javascript:MySubscriptionChange('alert-level-save','<?=$alert_row['alert_id'];?>','AlertLevel','<?=$mode;?>');">
											<?PHP }else{ ?>
											<a href="#">
											<?PHP } ?>
											Change<img src="images/white-arrow-small.gif" width="12" height="9" alt="" title=""  border="0"/></a></td>
										<td width="107" align="left" valign="top" class="deactive-button"><a href="#">Save<img src="images/white-arrow-small.gif" width="12" height="9" alt="" title=""  border="0"/></a></td>
									  </tr>
								</table>
								</div>
								<div id="alert-level-save" style="display:<?PHP if($divID == 'alert-level-save'){echo 'block';}else{ echo 'none';}?>;">
								<form name="frmAlertLevel" id="frmAlertLevel" method="post" action="my-subscription.php?alert_id=<?=$alert_row['alert_id'];?>&action=AlertLevel">
								<table width="99%" align="left" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td width="258" height="36" align="left" valign="top" class="content-text"><strong>Alert Level:</strong></td>
										<td width="164" height="41" align="left" valign="top" class="form-content-text">      
											
											 <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" class="my_div_small">
												<tr>
												  <td valign="top">
														<input type="text" name="alert_level" id="alert_level" class="text-new-100" value="<?=$alert_row['level'];?>" style="margin-top:0px; border:0px solid #000000; color:#737373;" onfocus="MyCombo_Open('div_alert_level');fieldHighlightCombo2('alert_level');" onblur="fieldLosslightCombo2('alert_level');" size="13"/>
														<img src="images/down.png" align="right" width="20" height="20" onclick="MyCombo_Open('div_alert_level');"/></td>
												</tr>
												<tr>
													<td valign="top">
														<div id="div_alert_level" class="middle" style="display:none; position:absolute;">
															<a href="javascript:TextboxValueChange('alert_level','div_alert_level','Paid');">Paid</a><br />
															<a href="javascript:TextboxValueChange('alert_level','div_alert_level','Free');">Free</a><br />
														</div>								
														</td>
												</tr>
											</table>
										 </td>
										 <td width="112" align="left" valign="top" class="deactive-button"><a href="#">Change<img src="images/white-arrow-small.gif" width="12" height="9" alt="" title=""  border="0"/></a></td>
										<td width="107" align="left" valign="top" <?PHP if($mode=='Edit' && $divID =='alert-level-save' ){ echo 'class="active-button"';}else{ echo 'class="deactive-button"';}?>><a href="javascript:FormValueSubmit('frmAlertLevel');">Save<img src="images/white-arrow-small.gif" width="12" height="9" alt="" title=""  border="0"/></a></td>
									  </tr>
								</table>
								</form>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div id="alert-status-change" style="display:<?PHP if($divID == 'alert-status-save'){echo 'none';}else{ echo 'block';}?>;">
								<table width="99%" align="left" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td width="258" height="36" align="left" valign="top" class="content-text"><strong>Status:</strong></td>
										<td width="164" align="left" valign="top" class="form-content-text"><?PHP if($alert_row['status']=='0'){echo 'Active';}else{echo 'Inactive';} ?></td>
										<td width="112" align="left" valign="top"  <?PHP if($mode=='Edit'){ echo 'class="deactive-button"';}else{ echo 'class="active-button"';}?>>
											<?PHP if($mode!='Edit'){?>
											<a href="javascript:MySubscriptionChange('alert-status-save','<?=$alert_row['alert_id'];?>','AlertStatus','<?=$mode;?>');">
											<?PHP }else{ ?>
											<a href="#">
											<?PHP } ?>
											Change<img src="images/white-arrow-small.gif" width="12" height="9" alt="" title=""  border="0"/></a></td>
										<td width="107" align="left" valign="top"  class="deactive-button"><a href="#">Save<img src="images/white-arrow-small.gif" width="12" height="9" alt="" title=""  border="0"/></a></td>
								  </tr>
								</table>
								</div>
								<div id="alert-status-save" style="display:<?PHP if($divID == 'alert-status-save'){echo 'block';}else{ echo 'none';}?>;">
								<form name="frmAlertStatus" id="frmAlertStatus" method="post" action="my-subscription.php?alert_id=<?=$alert_row['alert_id'];?>&action=AlertStatus">
								<table width="99%" align="left" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td width="258" height="36" align="left" valign="top" class="content-text"><strong>Status:</strong></td>
										<td width="164" align="left" valign="top" class="form-content-text">
										  
										   <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" class="my_div_small">
												<tr>
												  <td valign="top">
														<input type="text" name="alert_status" id="alert_status" class="text-new-100" value="<?PHP if($alert_row['status']=='0'){echo 'Active';}else{echo 'Inactive';} ?>" style="margin-top:0px; border:0px solid #000000; color:#737373;" onfocus="MyCombo_Open('div_alert_status');fieldHighlightCombo2('alert_status');" onblur="fieldLosslightCombo2('alert_status');" size="13"/>
														<img src="images/down.png" align="right" width="20" height="20" onclick="MyCombo_Open('div_alert_status');"/></td>
												</tr>
												<tr>
													<td valign="top">
														<div id="div_alert_status" class="middle" style="display:none; position:absolute;">
															<a href="javascript:TextboxValueChange('alert_status','div_alert_status','Active');">Active</a><br />
															<a href="javascript:TextboxValueChange('alert_status','div_alert_status','Inactive');">Inactive</a><br />
														</div>								
														</td>
												</tr>
											</table>
										 </td>
										<td width="112" align="left" valign="top"  class="deactive-button"><a href="#">Change<img src="images/white-arrow-small.gif" width="12" height="9" alt="" title=""  border="0"/></a></td>
										<td width="107" align="left" valign="top" <?PHP if($mode=='Edit' && $divID =='alert-status-save' ){ echo 'class="active-button"';}else{ echo 'class="deactive-button"';}?>><a href="javascript:FormValueSubmit('frmAlertStatus');">Save<img src="images/white-arrow-small.gif" width="12" height="9" alt="" title=""  border="0"/></a></td>
									  </tr>
								</table>
								</form>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<?php
								$exp_dt = explode('-', $alert_row['exp_date']);
								$expiry_date = $exp_dt[1]."/".$exp_dt[2]."/".$exp_dt[0];
								?>
								<div id="alert-exp-date-change" style="display:<?PHP if($divID == 'alert-exp-date-save'){echo 'none';}else{ echo 'block';}?>;">
								<table width="99%" align="left" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td  width="258" height="36" align="left" valign="middle" class="content-text"><strong>Expiration Date:</strong></td>
										<td  width="164" height="36" align="left" valign="middle" class="form-content-text"><?=$expiry_date?></td>
										<td width="112" align="left" valign="middle" <?PHP if($mode=='Edit'){ echo 'class="deactive-button"';}else{ echo 'class="active-button"';}?>>
										
											<?PHP if($mode!='Edit'){?>
											<a href="javascript:MySubscriptionChange('alert-exp-date-save','<?=$alert_row['alert_id'];?>','AlertExpDate','<?=$mode;?>');">
											<?PHP }else{ ?>
											<a href="#">
											<?PHP } ?>
											Change<img src="images/white-arrow-small.gif" width="12" height="9" alt="" title=""  border="0"/></a></td>
										<td width="107" align="left" valign="middle"  class="deactive-button"><a href="#">Save<img src="images/white-arrow-small.gif" width="12" height="9" alt="" title=""  border="0"/></a></td>
									</tr>	
								</table>
								</div>
								<div id="alert-exp-date-save" style="display:<?PHP if($divID == 'alert-exp-date-save'){echo 'block';}else{ echo 'none';}?>;">
								<form name="frmAlertExpDate" id="frmAlertExpDate" method="post" action="my-subscription.php?alert_id=<?=$alert_row['alert_id']?>&action=AlertExpDate">
								<table width="99%" align="left" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td width="258" height="36" align="left" valign="middle" class="content-text"><strong>Expiration Date:</strong></td>
										<td width="164" height="36" align="left" valign="middle">
											<span class="form-content-text">
											  <input type="text" name="alert_exp_date" id="alert_exp_date" value="<?=$expiry_date?>" class="list-field-small"  onfocus="fieldHighlightCombo3('alert_exp_date');" onblur="fieldLosslightCombo3('alert_exp_date');"/>
											</span>
										</td>
										<td width="112" align="left" valign="middle" class="deactive-button"><a href="#">Change<img src="images/white-arrow-small.gif" width="12" height="9" alt="" title=""  border="0"/></a></td>
										<td width="107" align="left" valign="middle"  <?PHP if($mode=='Edit' && $divID =='alert-exp-date-save' ){ echo 'class="active-button"';}else{ echo 'class="deactive-button"';}?>><a href="javascript:FormValueSubmit('frmAlertExpDate');">Save<img src="images/white-arrow-small.gif" width="12" height="9" alt="" title=""  border="0"/></a></td>
									</tr>
								</table>
								</form>
								</div>
							</td>
						</tr>
						<tr><td height="41" align="left" valign="middle">&nbsp;</td>
						<?PHP } ?>	
						
						
						<tr>
							<td>
										
							</td>
						</tr>
					  
				  </table>
				  
				  
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
    <!-- content end-->
<?php      
include(DIR_INCLUDES."footer.php");
?>