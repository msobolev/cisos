<?php
require('includes/include_top.php');

$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 30;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';

$sql_query = "select * from " . TABLE_USER." WHERE move_id > 0 and level='' order by res_date desc";

/***************** FOR PAGIN ***********************/
$starting_point = $items_per_page * ($p - 1);
/****************** END PAGIN ***********************/
$main_page = 'free-user-alert-send.php';

$exe_query=com_db_query($sql_query);
$num_rows=com_db_num_rows($exe_query);
$total_data = $num_rows;

/************ FOR PAGIN **************/
$sql_query .= " LIMIT $starting_point,$items_per_page";
$exe_data = com_db_query($sql_query);

$numRows = com_db_num_rows($exe_data);
/************ END ********************/


$uID = (isset($_GET['uID']) ? $_GET['uID'] : '');

    switch ($action) {
		
	  case 'FreeUserAlertSend':
	   		
			$moveID = $_REQUEST['moveid'];
			
			$isAlertPresent = com_db_GetValue("select user_id from " . TABLE_SEARCH_HISTORY_VISITORS . " where user_id='".$uID."' order by search_id desc" );
			if($isAlertPresent > 0){
				$alert_query = "select * from " . TABLE_SEARCH_HISTORY_VISITORS . " where user_id='".$uID."' order by search_id desc" ;
				$alert_result = com_db_query($alert_query);
				$alert_row = com_db_fetch_array($alert_result);
	     		
				/*$user_email = com_db_GetValue("select email from " .TABLE_USER . " where user_id='".$alert_row['user_id']."'");
				  $user_first_name = com_db_GetValue("select first_name from " .TABLE_USER . " where user_id='".$alert_row['user_id']."'");
				  $alert_create_date = $alert_row['add_date'];
				 //for user
				  $sent_contact_result = com_db_query("select contact_id from " .TABLE_ALERT_SEND_INFO." where alert_id='".$alert_row['alert_id']."' and user_id='".$alert_row['user_id']."'");
				  $sent_contact_id='';
				  while($sent_contact_row = com_db_fetch_array($sent_contact_result)){
					  if($sent_contact_id=='' && $sent_contact_row['contact_id'] !=''){
						$sent_contact_id = $sent_contact_row['contact_id'];	
					  }elseif($sent_contact_row['contact_id'] !=''){
						$sent_contact_id .=','.$sent_contact_row['contact_id'];
					  }	
				  }*/
		  
				$message ='';
				$message_info = '';
				$cnt=1;
				
				$alert_metch_str='';
				
				if($alert_row['title'] !=''){
				  $alert_metch_str = " mm.title='".$alert_row['title']."'";
				}
				
				if($alert_row['type'] !=''){
				  if($alert_metch_str==''){
					$alert_metch_str = " mm.movement_type='".$alert_row['type']."'";
				  }else{
					$alert_metch_str .=" and mm.movement_type='".$alert_row['type']."'";
				  }
				}
				
				if($alert_row['country'] !=''){
				 if($alert_metch_str==''){
					 $alert_metch_str ="cm.country='".$alert_row['country']."'";
				 }else{
					 $alert_metch_str .=" and cm.country='".$alert_row['country']."'";
				 }
				}
				
				if($alert_row['state'] !=''){
				 if($alert_metch_str==''){
					 $alert_metch_str =" cm.state in (".$alert_row['state'].")";
				 }else{
					 $alert_metch_str .=" and cm.state in (".$alert_row['state'].")";
				 }
				}
				
				if($alert_row['city'] !='' || $alert_row['zip_code'] !='' ){
				 if($alert_metch_str==''){
					 if($alert_row['city'] !='' && $alert_row['zip_code'] !=''){
						$alert_metch_str =" ( cm.city='".$alert_row['city']."' or cm.zip_code='".$alert_row['zip_code']."')";
					 }elseif($alert_row['city'] !=''){
						 $alert_metch_str =" ( cm.city='".$alert_row['city']."')";
					 }elseif($alert_row['zip_code'] !=''){
						 $alert_metch_str = " ( cm.zip_code='".$alert_row['zip_code']."')";
					 }
				 }else{
					 if($alert_row['city'] !='' && $alert_row['zip_code'] !=''){
						$alert_metch_str .=" and ( cm.city='".$alert_row['city']."' or cm.zip_code='".$alert_row['zip_code']."')";
					 }elseif($alert_row['city'] !=''){
						 $alert_metch_str .=" and ( cm.city='".$alert_row['city']."')";
					 }elseif($alert_row['zip_code'] !=''){
						 $alert_metch_str .=" and ( cm.zip_code='".$alert_row['zip_code']."')";
					 }
				 }
				}
				
				if($alert_row['company_name'] !=''){
				 if($alert_metch_str==''){
					 $alert_metch_str =" cm.company_name='".$alert_row['company']."'";
				 }else{
					 $alert_metch_str .=" and cm.company_name='".$alert_row['company']."'";
				 }
				}
				if($alert_row['company_website'] !=''){
				  $webArr = explode("<br />",$alert_row['company_website']);
				  $webStr='';
				  for($wb=0; $wb < sizeof($webArr); $wb++){
					  if($webStr ==''){
						$webStr = " (cm.company_website like '%".$webArr[$wb]."') ";
					  }else{
						$webStr .= " or (cm.company_website like '%".$webArr[$wb]."') ";
					  }
				  }
				  if($webStr !=''){
					 if($alert_metch_str==''){
						 $alert_metch_str =" (".$webStr.")";
					 }else{
						 $alert_metch_str .=" and (".$webStr.")";
					 }
				  } 
				}
				
				if($alert_row['industry_id'] !=''){
				 if($alert_metch_str==''){
					 $alert_metch_str =" cm.industry_id in (".$alert_row['industry_id'].")";
				 }else{
					 $alert_metch_str .=" and cm.industry_id in (".$alert_row['industry_id'].")";
				 }
				}
				if($alert_row['revenue_size'] !=''){
				 if($alert_metch_str==''){
					 $alert_metch_str =" cm.company_revenue in (".$alert_row['revenue_size'].")";
				 }else{
					 $alert_metch_str .=" and cm.company_revenue in (".$alert_row['revenue_size'].")";
				 }
				}
				if($alert_row['employee_size'] !=''){
				 if($alert_metch_str==''){
					 $alert_metch_str =" cm.company_employee in (".$alert_row['employee_size'].")";
				 }else{
					 $alert_metch_str .=" and cm.company_employee in (".$alert_row['employee_size'].")";
				 }
				}
				if($alert_row['awards'] ==1 && $awardsStr !=''){
				 if($alert_metch_str==''){
					 $alert_metch_str =" pm.personal_id in (".$awardsStr.")";
				 }else{
					 $alert_metch_str .=" and pm.personal_id in (".$awardsStr.")";
				 }
				}
				if($alert_row['board'] ==1 && $boardStr !=''){
				 if($alert_metch_str==''){
					 $alert_metch_str =" pm.personal_id in (".$boardStr.")";
				 }else{
					 $alert_metch_str .=" and pm.personal_id in (".$boardStr.")";
				 }
				}
				if($alert_row['media_mention'] ==1 && $mediaStr !=''){
				 if($alert_metch_str==''){
					 $alert_metch_str =" pm.personal_id in (".$mediaStr.")";
				 }else{
					 $alert_metch_str .=" and pm.personal_id in (".$mediaStr.")";
				 }
				}
				if($alert_row['publication'] ==1 && $pubStr !=''){
				 if($alert_metch_str==''){
					 $alert_metch_str =" pm.personal_id in (".$pubStr.")";
				 }else{
					 $alert_metch_str .=" and pm.personal_id in (".$pubStr.")";
				 }
				}
				if($alert_row['speaking'] ==1 && $speakingStr !=''){
				 if($alert_metch_str==''){
					 $alert_metch_str =" pm.personal_id in (".$speakingStr.")";
				 }else{
					 $alert_metch_str .=" and pm.personal_id in (".$speakingStr.")";
				 }
				}
				 
				
				$download_query = "select mm.move_id,mm.personal_id,mm.title,mm.announce_date,mm.what_happened,mm.movement_url,mm.effective_date,mm.announce_date,mm.headline,mm.full_body,mm.short_url,mm.more_link,
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
				where (mm.company_id=cm.company_id and mm.personal_id=pm.personal_id and mm.status ='0' and mm.movement_url <>'' and mm.movement_type=m.id and mm.source_id=so.id) 
				and (cm.state=s.state_id and cm.country=ct.countries_id and cm.industry_id=i.industry_id and cm.company_revenue=r.id and cm.company_employee=e.id)";				
			
				if($alert_metch_str !=''){
				  $download_query = $download_query." and ".$alert_metch_str;
				}
			}else{		  
		  
				$movementQuery = "select mm.title,mm.movement_type,pm.first_name,pm.last_name,cm.company_revenue,cm.company_employee,cm.company_industry from ".TABLE_MOVEMENT_MASTER." mm, ".TABLE_COMPANY_MASTER." cm, ".TABLE_PERSONAL_MASTER." pm where mm.personal_id=pm.personal_id and mm.company_id=cm.company_id and mm.move_id='".$moveID."'";
				$movementResult = com_db_query($movementQuery);
				$moveRow = com_db_fetch_array($movementResult);
				
				$view_title=$moveRow['title'];
				$view_firstname=$moveRow['first_name'];
				$view_lastname=$moveRow['last_name'];
				
				$title=$moveRow['title'];
				$movement_type=$moveRow['movement_type'];
				$company_revenue=$moveRow['company_revenue'];
				$company_employee=$moveRow['company_employee'];
				$company_industry=$moveRow['company_industry'];
				
				$download_query = "select mm.move_id,mm.title,mm.announce_date,mm.what_happened,mm.movement_url,mm.effective_date,mm.announce_date,mm.headline,mm.full_body,mm.short_url,mm.more_link,
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
				and (cm.state=s.state_id and cm.country=ct.countries_id and cm.industry_id=i.industry_id and cm.company_revenue=r.id and cm.company_employee=e.id)
				and ((mm.title='".$title."' and cm.company_industry='".$company_industry."') and (mm.movement_type='".$movement_type."' or cm.company_revenue='".$company_revenue."' or cm.company_employee='".$company_employee."'))";
					
			}

				$download_query = $download_query .' order by move_id desc limit 0,5'; 		
				$result=com_db_query($download_query);
				$i=0;
			   
			    $sep = "\t";        //tabbed character
				//$filename = "E:\\xampp\\htdocs\\ananga\\cto-new\\admin\\free_user_alert\\cto-alert-".$uID.".xls"; 
				$filename = "/home/content/m/s/o/msobolevftp1/html/admin/free_user_alert/cto-alert-".$uID.".xls"; 
				$fp = fopen($filename, "w");
				
				$schema_insert_rows = "";
				//printing column names
				$schema_insert_rows.="Search Result : Download" . $sep; 
				$schema_insert_rows.="\n";
				fwrite($fp, $schema_insert_rows);
				
				$schema_insert_rows = "";
				$schema_insert_rows.="Sl.No." . $sep; 
				$schema_insert_rows.="First Name" . $sep; 
				$schema_insert_rows.="Last Name" . $sep; 
				$schema_insert_rows.="Title" . $sep; 
				$schema_insert_rows.="E-Mail" . $sep;
				$schema_insert_rows.="Phone" . $sep;
				$schema_insert_rows.="Company Name" . $sep;
				$schema_insert_rows.="Company Website" . $sep;
				$schema_insert_rows.="Company Size – Revenue" . $sep;
				$schema_insert_rows.="Company Size – Employees" . $sep;
				$schema_insert_rows.="Company Industry" . $sep;
				$schema_insert_rows.="Address" . $sep;
				$schema_insert_rows.="Address 2" . $sep;
				$schema_insert_rows.="City" . $sep;
				$schema_insert_rows.="State" . $sep;
				$schema_insert_rows.="Country" . $sep;
				$schema_insert_rows.="Zip Code" . $sep;
				$schema_insert_rows.="Announce Date" . $sep;
				$schema_insert_rows.="Effective Date" . $sep;
				$schema_insert_rows.="Headline" . $sep;
				$schema_insert_rows.="Short Url" . $sep;
				$schema_insert_rows.="Movement Type" . $sep;
				$schema_insert_rows.="\n";
				fwrite($fp, $schema_insert_rows);

				while($download_row=com_db_fetch_array($result)) {
				++$i;
				$first_name = com_db_output($download_row['first_name']);
				$last_name = com_db_output($download_row['last_name']);
				$title = com_db_output($download_row['title']);
				$email = com_db_output($download_row['email']);
				$phone = com_db_output($download_row['phone']);
				$company_name = com_db_output($download_row['company_name']);
				$company_website = com_db_output($download_row['company_website']);
				$company_revenue = com_db_output($download_row['company_revenue']);
				$company_employee = com_db_output($download_row['company_employee']);
				$company_industry = com_db_output($download_row['company_industry']);
				$address = com_db_output($download_row['address']);
				$address2 = com_db_output($download_row['address2']);
				$city = com_db_output($download_row['city']);
				$state = com_db_output($download_row['state']);
				$country = com_db_output($download_row['country']);
				$zip_code = com_db_output($download_row['zip_code']);
						
				$announce_date = $download_row['announce_date'];
				$adate = explode('-',$announce_date);
				$announce_date = $adate[1].'/'.$adate[2].'/'.$adate[0];
				
				$effective_date = $download_row['effective_date'];
				$edate = explode('-',$effective_date);
				$effective_date = $edate[1].'/'.$edate[2].'/'.$edate[0];
				
				$source = com_db_output($download_row['source']);
				$headline = strip_tags($download_row['headline']);
				$movement_type = com_db_output($download_row['movement_type']);
				
				$schema_insert_rows = "";
				$schema_insert_rows.= $i. $sep; 
				$schema_insert_rows.= $first_name . $sep; 
				$schema_insert_rows.= $last_name . $sep; 
				$schema_insert_rows.= $title . $sep; 
				$schema_insert_rows.= $email . $sep;
				$schema_insert_rows.= $phone . $sep;
				$schema_insert_rows.= $company_name. $sep;
				$schema_insert_rows.= $company_website . $sep;
				$schema_insert_rows.= $company_revenue . $sep;
				$schema_insert_rows.= $company_employee . $sep;
				$schema_insert_rows.= $company_industry . $sep;
				$schema_insert_rows.= $address . $sep;
				$schema_insert_rows.= $address2 . $sep;
				$schema_insert_rows.= $city . $sep;
				$schema_insert_rows.= $state . $sep;
				$schema_insert_rows.= $country  . $sep;
				$schema_insert_rows.= $zip_code . $sep;
				$schema_insert_rows.= $announce_date . $sep;
				$schema_insert_rows.= $effective_date . $sep;
				$schema_insert_rows.= $source . $sep;
				$schema_insert_rows.= $headline . $sep;
				$schema_insert_rows.= $movement_type . $sep;
				$schema_insert_rows.="\n";
				fwrite($fp, $schema_insert_rows);
				}
			
			fclose($fp);
			
			$adminInfo = "select * from ". TABLE_ADMIN_SETTINGS ." where setting_id ='1'";
			$adminResult = com_db_query($adminInfo);
			$adminRow = com_db_fetch_array($adminResult);
			
			$from = $adminRow['site_email_from'];
						
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
								<tr><td align="left">'.$from.'</td></tr>
							</table>';
			$userQuery = "select first_name,email from ".TABLE_USER." where user_id='".$uID."'";
			$userResult = com_db_query($userQuery);
			$userRow = com_db_fetch_array($userResult);
			$user_first_name = $userRow['first_name'];
			$to = $userRow['email'];
			
			$message = '<a href="'.HTTP_SITE_URL.'index.php"><img src="'.HTTP_SITE_URL.'images/logo.jpg"  alt="Logo" width="196" height="32" border="0" title="Logo" /></a>&nbsp;
						<table width="70%" cellspacing="0" cellpadding="3" >
							<tr>
								<td align="left" colspan="2"><b>Hi '.$user_first_name.', </b></td>
							</tr>
							<tr>
								<td align="left" colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td align="left" colspan="2">You downloaded contact details of ('.$view_firstname.' '.$view_lastname.' of '.$view_title.'), and I wanted to send you 5 more similar contacts, see attached. I hope this is helpful.</td>
							</tr>
							<tr>
								<td align="left" colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td align="left" colspan="2">'.$fromEmailSent.'</td>
							</tr>';
	 
			$message .=	'</table>';
			
			//echo $message;
						
			$subject ='Free similar alert message';
			///home/content/m/s/o/msobolevftp1/html/admin/free_user_alert/
			$file_name = "/home/content/m/s/o/msobolevftp1/html/admin/free_user_alert/cto-alert-".$uID.".xls"; 	
			sendmsg($to, $subject, $message, $from, $file_name, 'xls');
			com_db_query("update ".TABLE_USER." set last_send_date='".date("Y-m-d")."' where user_id='".$uID."'");
			
		 	com_redirect("free-user-alert-send.php?p=" . $p . "&selected_menu=user&msg=" . msg_encode("Free user alert send successfully"));
		
		break;
		
	  case 'detailes':
			
			$query_edit=com_db_query("select * from " . TABLE_USER . "  where user_id = '" . $uID . "'");
	  		$data_edit=com_db_fetch_array($query_edit);
			$add_date =explode('-',$data_edit['res_date']);
			$post_date = date('d, M Y',mktime(0,0,0,date($add_date[1]),date($add_date[2]),date($add_date[0])));
			$full_name = com_db_output($data_edit['first_name'].' '.$data_edit['last_name']);
			$contact_url = com_db_GetValue("select movement_url from ".TABLE_MOVEMENT_MASTER. " where move_id='".$data_edit['move_id']."'");
			$email = com_db_output($data_edit['email']);
			
		break;	
					
    }
	


include("includes/header.php");
?>

 <tr>
    <td align="left" valign="top" bgcolor="#FFFFFF"><table width="975" border="0" align="center" cellpadding="0" cellspacing="0">

      <tr>
		<?php
		include("includes/menu_left.php");
		?>
		<td width="10" align="left" valign="top">&nbsp;</td>
        <td width="769" align="left" valign="top">

<?php if(($action == '') || ($action == 'save')){	?>			

		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
          <tr>
            <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="32%" align="left" valign="middle" class="heading-text">User Coming From Sign Up</td>
                  <td width="68%" align="left" valign="middle" class="message"><?=$msg?></td>
                  <? if($btnDelete=='Yes'){ ?>
                  <? } ?>
                </tr>
              </table></td>
          </tr>
       
          <tr>
            <td align="left" valign="top" class="right-bar-content-border">
            <script type="text/javascript" language="javascript">
				function SendAlertEmail(uid,moveid,page){
					var url = "free-user-alert-send.php?action=FreeUserAlertSend&selected_menu=user&uID="+uid+"&moveid="+moveid+"&p="+page;
					window.location=url;
				}
			</script>
			<form name="topicform" action="free-user-alert-send.php?action=alldelete&selected_menu=user" method="post">
			<table width="100%" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="31" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-title-text">#</span></td>
				<td width="189" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">User Name</span></td>
				<td width="205" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">E-mail</span> </td>
                <td width="132" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Last Alert Send Date</span> </td>
				<td width="79" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Date</span> </td>
				<td width="131" height="30" align="center" valign="middle" class="left-border"><div align="center"><span class="right-box-title-text">Action</span></div></td>
			  </tr>
			<?php
			
			if($total_data>0) {
				$i=1;
				while ($data_sql = com_db_fetch_array($exe_data)) {
				$adddate = explode('-',$data_sql['res_date']);
				$add_date = $adddate[1].'/'.$adddate[2].'/'.$adddate[0];
				if($data_sql['last_send_date'] !='0000-00-00'){
					$sdt = explode('-',$data_sql['last_send_date']);
					$last_send_date = $sdt[1].'/'.$sdt[2].'/'.$sdt[0];
				}
			?>          
			  <tr>
				<td height="30" align="center" valign="middle" class="right-border-left"><?=$i;?></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><a href="free-user-alert-send.php?action=detailes&selected_menu=user&uID=<?=$data_sql['user_id'];?>"><?=com_db_output($data_sql['first_name'].' '.$data_sql['last_name'])?></a></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><?=com_db_output($data_sql['email'])?></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><?=$last_send_date?></td>
                <td height="30" align="left" valign="middle" class="right-border-text"><?=$add_date?></td>
				<td height="30" align="center" valign="middle" class="left-border">
					<table width="45" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr> 
						<td align="center" valign="middle"><input type="button" name="AlertSend" value="Send Alert E-mail" onclick="SendAlertEmail('<?=$data_sql['user_id'];?>','<?=$data_sql['move_id']?>','<?=$p?>');" /></td>
					  </tr>
					</table>				</td>
         	</tr> 
			<?php
			$i++;
				}
			
			}
			?>     
         </table> 
		</form>
		
		</td>
          </tr>
        </table>
</td>
      </tr>
    </table></td>
  </tr>
 <tr>
    <td align="center" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
     
      <tr>
        <td width="666" align="right" valign="top"><table width="200" border="0" align="right" cellpadding="0" cellspacing="0">
          <tr>
		<?php echo number_pages($main_page, $p, $total_data, 8, $items_per_page,'&selected_menu=user');?>		  
          </tr>
        </table></td>
        <td width="314" align="center" valign="bottom">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  
<?php } elseif($action=='detailes'){
?>		
  	  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">User Only Sign Up  Manager ::  Details </td>
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="left" valign="top" class="right-border">
		 <!--start iner table  -->
			<table width="98%" align="center" cellpadding="5" cellspacing="5" border="0">
            <tr>
			  <td align="left" valign="top" class="page-text">
			  	<strong><?=$full_name;?></strong><br /><br />
				<strong><?=$post_date;?></strong><br /><br />
				 Movement Url : <a href="<?=HTTP_SITE_URL.$contact_url?>" target="_blank"><?=$contact_url?></a><br /><br />
			     Email : <?=$email?><br /><br />
				</td>
			</tr>
			<tr>
				<td align="left" valign="top"><input type="button" class="submitButton" value="Back" onclick="window.location='free-user-alert-send.php?p=<?=$p;?>&uID=<?=$uID;?>&selected_menu=user'" /></td>
			</tr>
			
			</table>
		 <!-- end inner table -->
		  </td>
		 </tr>
            </table></td>
		 </tr>
        </table></td>
          </tr>
     </table>		
<?php
}
include("includes/footer.php");

function sendmsg($to, $subject, $msgtext, $from, $file, $type)
{
$att_file_name ="cto-free-alert.xls";
$fp = fopen($file,"rb");
$fcontent = fread($fp ,filesize($file));
fclose($fp);
$content = chunk_split(base64_encode($fcontent));
$sep = strtoupper(md5(uniqid(time())));
$name = basename($file);
$header = "From: $from\nReply-To: $from\n";
$header .= "MIME-Version: 1.0\n";
$header .= "Content-Type: multipart/mixed; boundary=$sep
\n";
$body .= "--$sep\n";
$body .= "Content-Type:text/html; charset=\"iso-8859-1\"\n";
$body .= "Content-Transfer-Encoding: 8bit\n\n";
$body .= "$msgtext\n";
$body .= "--$sep\n";
$body .= "Content-Type: application/vnd.ms-excel; name=\"$att_file_name\"\n";
$body .= "Content-Transfer-Encoding: base64\n";
//$body .= "Content-type: application/vnd.ms-excel";
$body .= "Content-Disposition: attachment; filename=
\"$att_file_name
\"\n";
$body .= "$content\n";
$body .= "--$sep--";
mail($to, $subject, $body, $header);
}
?>