<?php
require('includes/include-top.php');
$q = $_GET["q"];
$type = $_GET['type'];
$oldValue = $_GET['oldValue'];

if($type=='Add'){
	$email = com_db_GetValue("SELECT  email FROM ". TABLE_USER." WHERE email = '".$q."'");
	if($email !=''){
		echo 'the email already exists in our system, <a href="'.HTTP_SERVER.'login.php">login here</a>';
	}
}

if($type=='EmailEdit'){
	$email = com_db_GetValue("SELECT  email FROM ". TABLE_USER." WHERE email = '".$q."' and email <>'".$oldValue."'");
	if($email !=''){
		echo 'the email already exists in our system, <a href="'.HTTP_SERVER.'login.php">login here</a>';
	}
}

if($type=='SignUpEmailSend'){
	$email = $_REQUEST['email'];
	$full_name = $_REQUEST['fname'];
	$fn = explode(' ',$full_name);
	$contact_id = $_REQUEST['contact_id'];
	$isPresent = $_REQUEST['isPresent'];
	$first_name = $fn[0];
	sleep(50);
	
	
	
	if($email !='' && $contact_id !='' && $isPresent==''){
	
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
							<tr><td align="left">'.$site_company_state.', '.$site_company_zip.'</td></tr>
							<tr><td align="left">'.$site_phone_number.'</td></tr>
							<tr><td align="left">'.$from_admin.'</td></tr>
						</table>';
						
	$admin_mail_result =com_db_query("select * from " .TABLE_AUTORESPONDERS. " where type='Admin' and autoresponder_for='Get This Contact Free'");
	$admin_mail_row = com_db_fetch_array($admin_mail_result);
	  
	  $subject = "CTOsOnTheMove.com :: ".com_db_output($admin_mail_row['subject']);
		
	  $message = '<a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'index.php"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/logo.jpg"  alt="Logo" width="196" height="32" border="0" title="Logo" /></a>&nbsp;
				  <table width="70%" cellspacing="0" cellpadding="3">
					<tr>
						<td align="left" colspan="2">'.com_db_output($admin_mail_row['body1']).' '.com_db_output($admin_mail_row['body2']).'</td>
					</tr>
					<tr>
						<td align="left"><b>Name:</b></td>
						<td align="left">'.$full_name.'</td>
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
	@send_email($to_admin, $subject, $message, $email); 

	//for user email
	$isPagePersonProfile = com_db_GetValue("select referring_links from ".TABLE_USER." where email='".$email."'");
	if($isPagePersonProfile=='personal-profile.php'){
		$contact_id = com_db_GetValue("select move_id from ".TABLE_MOVEMENT_MASTER." where personal_id='".$contact_id."'");
	}
		$contact_query = "select mm.move_id,mm.title,mm.announce_date,mm.what_happened,mm.movement_url,mm.effective_date,mm.announce_date,mm.headline,mm.full_body,mm.short_url,mm.more_link,
						pm.first_name,pm.middle_name,pm.last_name,pm.email,pm.phone,pm.about_person,cm.company_name,
						cm.company_website,cm.address,cm.address2,cm.city,cm.zip_code,cm.phone as cphone,
						cm.fax,cm.about_company,m.name as movement_type,so.source as source,
						s.short_name as state,ct.countries_name as country,i.title as company_industry,
						r.name as company_revenue,e.name as company_employee from " 
						.TABLE_MOVEMENT_MASTER. " as mm, "
						.TABLE_PERSONAL_MASTER. " as pm, "
						.TABLE_COMPANY_MASTER. " as cm, " 
						.TABLE_MANAGEMENT_CHANGE." as m, "
						.TABLE_SOURCE." as so, "
						.TABLE_STATE." as s, "
						.TABLE_COUNTRIES." as ct, "
						.TABLE_INDUSTRY." as i, "
						.TABLE_REVENUE_SIZE." as r, "
						.TABLE_EMPLOYEE_SIZE." as e    
						where (mm.company_id=cm.company_id and mm.personal_id=pm.personal_id and mm.status ='0' and mm.movement_type=m.id and mm.source_id=so.id) 
						and (cm.state=s.state_id and cm.country=ct.countries_id and cm.industry_id=i.industry_id and cm.company_revenue=r.id and cm.company_employee=e.id) and mm.move_id ='".$contact_id."'";
						
		  $contact_result = com_db_query($contact_query);
		  $contact_row = com_db_fetch_array($contact_result);
		  	
		 		  
		  $user_mail_result =com_db_query("select * from " .TABLE_AUTORESPONDERS. " where type='User' and autoresponder_for='Get This Contact Free'");
		  $user_mail_row = com_db_fetch_array($user_mail_result);
		  
		  $subject = $first_name." / ".$user_mail_row['subject'].' - CTOsOnTheMove';
		  $to_email = $email;
		  $message = '<a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'index.php"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/logo.jpg"  alt="Logo" width="196" height="32" border="0" title="Logo" /></a>&nbsp;
		  				<table width="60%" cellspacing="0" cellpadding="3" >
							<tr>
								<td align="left" colspan="2"><font size="24"><b>Hi '.$first_name.',</b></font></td>
							</tr>
							<tr>
								<td align="left" colspan="2">'.com_db_output($user_mail_row['body1']).' '.com_db_output($user_mail_row['body2']).'</td>
							</tr>
							<tr><td align="left" colspan="2">&nbsp;</td></tr>
							<tr>
								<td align="left" colspan="2">Further, if at any point you\'d be interested in getting access to </td>
							</tr>
							<tr><td align="left" colspan="2">&nbsp;</td></tr>
							<tr>
								<td align="left" colspan="2"> -	our database with 14,000+ contact details of CIOs, CTOs, and other senior IT executives; </td>
							</tr>
							<tr>
								<td align="left" colspan="2"> -	as well as monthly update on 100-150 of them who just changed jobs, with new emails</td>
							</tr>
							<tr><td align="left" colspan="2">&nbsp;</td></tr>
							<tr>
								<td align="left" colspan="2"> please drop me a line at ms@ctosonthemove.com with “subscription” in the subject line and I will send you further details.</td>
							</tr>
							<tr><td align="left" colspan="2">&nbsp;</td></tr>
							<tr>
								<td align="left" colspan="2"> Now, here is the profile you requested:</td>
							</tr>
							
							<tr>
								<td align="left"><b>Name:</b></td>
								<td align="left">'.com_db_output($contact_row['first_name']).' '.com_db_output($contact_row['last_name']).'</td>
							</tr>
							<tr>
								<td align="left"><b>Address:</b></td>
								<td align="left">'.com_db_output($contact_row['address']).' '.com_db_output($contact_row['address2']).'</td>
							</tr>
							<tr>
								<td align="left"><b>City:</b></td>
								<td align="left">'.com_db_output($contact_row['city']).'</td>
							</tr>
							<tr>
								<td align="left"><b>State:</b></td>
								<td align="left">'.com_db_output($contact_row['state']).'</td>
							</tr>
							<tr>
								<td align="left"><b>Zip Code:</b></td>
								<td align="left">'.com_db_output($contact_row['zip_code']).'</td>
							</tr>
							<tr>
								<td align="left"><b>Country:</b></td>
								<td align="left">'.com_db_output($contact_row['country']).'</td>
							</tr>
							<tr>
								<td align="left"><b>Email:</b></td>
								<td align="left">'.com_db_output($contact_row['email']).'</td>
							</tr>
							<tr>
								<td align="left"><b>Phone:</b></td>
								<td align="left">'.com_db_output($contact_row['phone']).'</td>
							</tr>
							<tr>
								<td align="left"><b>Industry:</b></td>
								<td align="left">'.com_db_output($contact_row['company_industry']).'</td>
							</tr>
							<tr>
								<td align="left"><b>What happened?:</b></td>
								<td align="left">'.com_db_output($contact_row['what_happened']).'</td>
							</tr>
							<tr>
								<td align="left"><b>About the person:</b></td>
								<td align="left">'.com_db_output($contact_row['about_person']).'</td>
							</tr>
							<tr>
								<td align="left"><b>About the Company:</b></td>
								<td align="left">'.com_db_output($contact_row['about_company']).'</td>
							</tr>
							<tr>
								<td align="left"><b>Info source:</b></td>
								<td align="left">'.com_db_output($contact_row['source']).'</td>
							</tr>
							<tr>
								<td align="left" colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td align="left" colspan="2">Finally: every week we publish details of new appointments of CIOs, CTOs and other senior IT executives. It is a free resource, just sign up on our blog here: http://blog.ctosonthemove.com/</td>
							</tr>
							<tr>
								<td align="left">&nbsp;</td>
							</tr>
							<tr>
								<td align="left">'.$fromEmailSent.'</td>
							</tr>';
		 
			 $message .=	'</table>';
			 
		@send_email($to_email, $subject, $message, $from_admin);
		//insert vigilant sign up
		$contact_url = HTTP_SERVER.DIR_WS_HTTP_FOLDER.com_db_output($contact_row['movement_url']);
		$vigilant_sign_up_query ="insert into ".TABLE_VIGILANT_SIGN_UP."(full_name,email,contact_url,add_date)values('$full_name','$email','".$contact_url."','".date('Y-m-d')."')";
		com_db_query($vigilant_sign_up_query);
	}

	if($email !='' && $contact_id =='' && $isPresent==''){
		//for admin email
		//$to_admin = com_db_GetValue("select site_email_address from ". TABLE_ADMIN_SETTINGS ." where setting_id ='1'" );
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
							<tr><td align="left">'.$site_company_state.', '.$site_company_zip.'</td></tr>
							<tr><td align="left">'.$site_phone_number.'</td></tr>
							<tr><td align="left">'.$from_admin.'</td></tr>
						</table>';
						
		$admin_mail_result =com_db_query("select * from " .TABLE_AUTORESPONDERS. " where type='Admin' and autoresponder_for='Get This Contact Free'");
		$admin_mail_row = com_db_fetch_array($admin_mail_result);
		  
		  $subject = "CTOsOnTheMove.com :: ".com_db_output($admin_mail_row['subject']);
			
		  $message = '<a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'index.php"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/logo.jpg"  alt="Logo" width="196" height="32" border="0" title="Logo" /></a>&nbsp;
					  <table width="70%" cellspacing="0" cellpadding="3">
						<tr>
							<td align="left" colspan="2">'.com_db_output($admin_mail_row['body1']).' '.com_db_output($admin_mail_row['body2']).'</td>
						</tr>
						<tr>
							<td align="left"><b>Name:</b></td>
							<td align="left">'.$full_name.'</td>
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
		@send_email($to_admin, $subject, $message, $email); 
		$other_sign_up_query ="insert into ".TABLE_VIGILANT_SIGN_UP."(full_name,email,add_date)values('$full_name','$email','".date('Y-m-d')."')";
		com_db_query($other_sign_up_query);
	}
}

?> 