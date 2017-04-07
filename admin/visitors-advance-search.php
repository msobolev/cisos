<?php
require('includes/include_top.php');

$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 20;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$action = $_REQUEST['action'];
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';
if($action=='SearchUser'){
	$_SESSION['sess_action'] = '';
	$_SESSION['sess_from_date'] = '';
	$_SESSION['sess_to_date'] = '';	
}
if($action == 'VisitorsAdvanceSearchResult' || $_SESSION['sess_action']=='VisitorsAdvanceSearchResult'){
	$from_date = $_POST['from_date'];
	$to_date = $_POST['to_date'];
	
	if($from_date !='' ){
		$fd = explode('/',$from_date);
		if(strlen($from_date)==10 && is_numeric($fd[2]) && is_numeric($fd[1]) && is_numeric($fd[0])){
			$from_date = $fd[2].'-'.$fd[0].'-'.$fd[1];
		}else{
			com_redirect("visitors-advance-search.php?selected_menu=search&msg=" . msg_encode("Please enter valid date format ".$check));
		}	
	}
	if($to_date !=''){
		$td = explode('/',$to_date);
		if(strlen($to_date)==10 && is_numeric($td[2]) && is_numeric($td[1]) && is_numeric($td[0])){
			$to_date = $td[2].'-'.$td[0].'-'.$td[1];
		}else{
			com_redirect("visitors-advance-search.php?selected_menu=search&msg=" . msg_encode("Please enter valid date format"));
		}	
	}
	if($action == 'VisitorsAdvanceSearchResult'){
		$_SESSION['sess_from_date'] = $from_date;
		$_SESSION['sess_to_date'] = $to_date;
		$_SESSION['sess_action'] = $action;
	}else{
		$from_date	= $_SESSION['sess_from_date'];
		$to_date	= $_SESSION['sess_to_date'];
	}
	
	
	if($from_date!='' && $to_date !=''){
		$search_query = "select * from ".TABLE_SEARCH_HISTORY_VISITORS." where add_date >='".$from_date."' and add_date <='".$to_date."' order by search_id desc";
	}else{
		$search_query = "select * from ".TABLE_SEARCH_HISTORY_VISITORS." order by search_id desc";
	}
	
	/***************** FOR PAGIN ***********************/
	$starting_point = $items_per_page * ($p - 1);
	/****************** END PAGIN ***********************/
	$main_page = 'visitors-advance-search.php';
	$sql_query = $search_query;
	$exe_query=com_db_query($sql_query);
	$num_rows=com_db_num_rows($exe_query);
	$total_data = $num_rows;
	
	/************ FOR PAGIN **************/
	$sql_query .= " LIMIT $starting_point,$items_per_page";
	$exe_data = com_db_query($sql_query);
	
	$numRows = com_db_num_rows($exe_data);
	/************ END ********************/
		
}
///
if($action == 'VisitorsUserAlertSend'){
	$uID = $_REQUEST['uID'];
	$sID = $_REQUEST['sID'];
	$isAlertPresent = com_db_GetValue("select user_id from " . TABLE_SEARCH_HISTORY_VISITORS . " where user_id='".$uID."' and search_id='".$sID."' order by search_id desc");
	
	if($isAlertPresent > 0){
		$alert_query = "select * from " . TABLE_SEARCH_HISTORY_VISITORS . " where user_id='".$uID."' and search_id='".$sID."' order by search_id desc" ;
		$alert_result = com_db_query($alert_query);
		$alert_row = com_db_fetch_array($alert_result);
		
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
	}
	//echo $download_query;
	
		$download_query = $download_query .' order by move_id desc limit 0,5'; 		
		$result=com_db_query($download_query);
		$i=0;
	   
		$sep = "\t";        //tabbed character
		//$filename = "E:\\xampp\\htdocs\\ananga\\cto\\admin\\free_user_alert\\cto-alert-".$uID.".xls"; 
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
							<td align="left" colspan="2">You downloaded contact details, and I wanted to send you 5 more similar contacts, see attached. I hope this is helpful.</td>
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
		//$filename = "E:\\xampp\\htdocs\\ananga\\cto\\admin\\free_user_alert\\cto-alert-".$uID.".xls"; 
		$file_name = "/home/content/m/s/o/msobolevftp1/html/admin/free_user_alert/cto-alert-".$uID.".xls"; 	
		sendmsg($to, $subject, $message, $from, $file_name, 'xls');
		com_db_query("update ".TABLE_USER." set last_send_date='".date("Y-m-d")."' where user_id='".$uID."'");
		
		com_redirect("visitors-advance-search.php?p=" . $p . "&selected_menu=search&msg=" . msg_encode("Visitors alert send successfully"));
		
}
///

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
		 <script type="text/javascript" language="javascript">
			function UserSearch(){
				window.location ='visitors-advance-search.php?action=SearchUser&selected_menu=search';
			}
		</script>
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right">
			  <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="32%" align="left" valign="middle" class="heading-text">Visitors Advance Search Information</td>
				  <td width="62%" valign="middle" class="message" align="left"><?=$msg?></td>
                  <td width="6%" valign="middle" class="message" align="left"><a href="javascript:;" onclick="UserSearch();"><img src="images/search-icon.jpg" border="0" width="25" height="28"  alt="Search User" title="Search User" /></a></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box">
            <? if(($action == '' && $_SESSION['sess_action']=='') || $action == 'SearchUser'){?>
			<div id="spiffycalendar" class="text"></div>
				<link rel="stylesheet" type="text/css" href="includes/javascript/spiffyCal/spiffyCal_v2_1.css">
                
				<script language="JavaScript" src="includes/javascript/spiffyCal/spiffyCal_v2_1.js"></script>
				<script language="javascript"><!--
				  var dateAvailableFrom = new ctlSpiffyCalendarBox("dateAvailableFrom", "userSearch", "from_date","btnDate1","",scBTNMODE_CUSTOMBLUE);
				  var dateAvailableTo = new ctlSpiffyCalendarBox("dateAvailableTo", "userSearch", "to_date","btnDate2","",scBTNMODE_CUSTOMBLUE);	
				//--></script>
               	
		  		<form name="userSearch" method="post" action="visitors-advance-search.php?selected_menu=search&action=VisitorsAdvanceSearchResult">
                    <table width="60%" border="0" cellspacing="0" cellpadding="5">
                       <tr><td colspan="2" height="10"></td></tr>
                       <tr>
                        <td colspan="2"><b><span class="heading-text">Advance Search Date</span></b></td>
                       </tr>
                       <tr>
                         <td align="left" valign="top" class="page-text">&nbsp;From Date:</td>
                         <td align="left" valign="top" class="page-text"><input type="text" name="from_date" id="from_date" size="12" value="" />
                                <a href="javascript:NewCssCal('from_date','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a> (mm/dd/yyyy)	</td>
                        </tr>
                        <tr>
                         <td align="left" valign="top" class="page-text">&nbsp;To Date:</td>
                         <td align="left" valign="top" class="page-text"> <input type="text" name="to_date" id="to_date" size="12" value="" />
                                <a href="javascript:NewCssCal('to_date','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a> (mm/dd/yyyy)</td>
                        </tr>
                       <tr>
                         <td>&nbsp;</td>
                         <td align="left" valign="top">&nbsp;</td>
                         </tr>
                       <tr>
                         <td>&nbsp;</td>
                         <td align="left" valign="top"><input type="submit" name="Submit" value="Search Result" class="submitButton" /></td>
                         </tr>
                       <tr>
                         <td>&nbsp;</td>
                         <td align="left" valign="top">&nbsp;</td>
                         </tr>
                    </table>
				</form>
                <? }elseif($action == 'VisitorsAdvanceSearchResult' || $_SESSION['sess_action']=='VisitorsAdvanceSearchResult'){ ?>
                	 <script type="text/javascript" language="javascript">
						function SendAlertEmail(uid,sid,page){
							var url = "visitors-advance-search.php?action=VisitorsUserAlertSend&selected_menu=search&uID="+uid+"&sID="+sid+"&p="+page;
							window.location=url;
						}
					</script>
                	<table width="100%" border="0" cellspacing="3" cellpadding="3">
                      <tr><td colspan="3">&nbsp;</td></tr>
                      <tr>
                      	<td width="1%" bgcolor="#CCCCCC"><b><span class="heading-text">Sl.No</span></b></td>
                        <td width="10%" bgcolor="#CCCCCC"><b><span class="heading-text">Visitors</span></b></td>
                        <td width="65%" bgcolor="#CCCCCC"><b><span class="heading-text">Search Information</span></b></td>
                        <td width="14%" bgcolor="#CCCCCC"><b><span class="heading-text">Tot. Result</span></b></td>
                        <td width="10%" bgcolor="#CCCCCC"><b><span class="heading-text">Action</span></b></td>
                      </tr>
                      <? while($sRow=com_db_fetch_array($exe_data)){ 
					  		$s++;
							$searchStr='';
							
							if($sRow['first_name'] !=''){
								if($searchStr==''){	$searchStr = 'First Name: ' .$sRow['first_name'];}else{$searchStr .= 'Fisrt Name: ' .$sRow['first_name'];}
							}
							if($sRow['last_name'] !=''){
								if($searchStr==''){	$searchStr = 'Last Name: ' .$sRow['last_name'];}else{$searchStr .= ', Last Name: ' .$sRow['last_name'];}
							}
							if($sRow['title'] !=''){
								if($searchStr==''){	$searchStr = 'Title: ' .$sRow['title'];}else{$searchStr .= ', Title: ' .$sRow['title'];}
							}
							if($sRow['management'] !=''){
								$mResult = com_db_query("select name from ".TABLE_MANAGEMENT_CHANGE." where id in(".$sRow['management'].")");
								$mStr='';
								while($mRow = com_db_fetch_array($mResult)){
									if($mStr==''){
										$mStr = $mRow['name'];
									}else{
										$mStr .= ', '.$mRow['name'];
									}
								}
								if($searchStr==''){	$searchStr = 'Management Type: ' .$mStr;}else{$searchStr .= ', Management Type: ' .$mStr;}
							}
							if($sRow['country'] !=''){
								$cResult = com_db_query("select countries_name from ".TABLE_COUNTRIES." where countries_id in(".$sRow['country'].")");
								$cStr='';
								while($cRow = com_db_fetch_array($cResult)){
									if($cStr==''){
										$cStr = $cRow['countries_name'];
									}else{
										$cStr .= ', '.$cRow['countries_name'];
									}
								}
								if($searchStr==''){	$searchStr = 'Countries: ' .$cStr;}else{$searchStr .= ', Countries: ' .$cStr;}
							}
							if($sRow['state'] !=''){
								$sResult = com_db_query("select state_name from ".TABLE_STATE." where state_id in(".$sRow['state'].")");
								$sStr='';
								while($stRow = com_db_fetch_array($sResult)){
									if($sStr==''){
										$sStr = $stRow['state_name'];
									}else{
										$sStr .= ', '.$stRow['state_name'];
									}
								}
								if($searchStr==''){	$searchStr = 'State: ' .$sStr;}else{$searchStr .= ', State: ' .$sStr;}
							}
							
							if($sRow['city'] !=''){
								if($searchStr==''){	$searchStr = 'City: ' .$sRow['city'];}else{$searchStr .= ', City: ' .$sRow['city'];}
							}
							if($sRow['zip_code'] !=''){
								if($searchStr==''){	$searchStr = 'Zip Code: ' .$sRow['zip_code'];}else{$searchStr .= ', Zip Code: ' .$sRow['zip_code'];}
							}
							if($sRow['company'] !=''){
								if($searchStr==''){	$searchStr = 'Company: ' .$sRow['company'];}else{$searchStr .= ', Company: ' .$sRow['company'];}
							}
							if($sRow['industry'] !=''){
								$iResult = com_db_query("select title from ".TABLE_INDUSTRY." where industry_id in(".$sRow['industry'].")");
								$iStr='';
								while($iRow = com_db_fetch_array($iResult)){
									if($iStr==''){
										$iStr = $iRow['title'];
									}else{
										$iStr .= ', '.$iRow['title'];
									}
								}
								if($searchStr==''){	$searchStr = 'Industry: ' .$iStr;}else{$searchStr .= ', Industry: ' .$iStr;}
							}
							if($sRow['revenue_size'] !=''){
								$rResult = com_db_query("select name from ".TABLE_REVENUE_SIZE." where id in(".$sRow['revenue_size'].")");
								$rStr='';
								while($rRow = com_db_fetch_array($rResult)){
									if($rStr==''){
										$rStr = $rRow['name'];
									}else{
										$rStr .= ', '.$rRow['name'];
									}
								}
								if($searchStr==''){	$searchStr = 'Revenue Size: ' .$rStr;}else{$searchStr .= ', Revenue Size: ' .$rStr;}
							}
							if($sRow['employee_size'] !=''){
								$eResult = com_db_query("select name from ".TABLE_EMPLOYEE_SIZE." where id in(".$sRow['employee_size'].")");
								$eStr='';
								while($eRow = com_db_fetch_array($eResult)){
									if($eStr==''){
										$eStr = $eRow['name'];
									}else{
										$eStr .= ', '.$eRow['name'];
									}
								}
								if($searchStr==''){	$searchStr = 'Employee Size: ' .$eStr;}else{$searchStr .= ', Employee Size: ' .$eStr;}
							}
							if($sRow['time_period'] !=''){
								if($sRow['time_period']=='Enter Date Range...'){
									if($searchStr==''){	$searchStr = 'Date: From ' .$sRow['from_date'].' To '.$sRow['to_date'];}else{$searchStr .= ', Date: From ' .$sRow['from_date'].' To '.$sRow['to_date'];}
								}else{
									if($searchStr==''){	$searchStr = 'Date: From ' .$sRow['from_date'].' To '.$sRow['to_date'];}else{$searchStr .= ', Date: From ' .$sRow['from_date'].' To '.$sRow['to_date'];}
								}
							}
							
							if($searchStr==''){
								$searchStr = 'All';
							}
							
							if($sRow['tot_search_result']>0){
								$tot_search_result = $sRow['tot_search_result'];
							}else{
								$tot_search_result ='';
							}
							if($sRow['user_id']>0){
								$userID= $sRow['user_id'];
								$searchID=$sRow['search_id'];
								$VisitorName = com_db_GetValue("select concat(first_name,' ',last_name) as full_name from ".TABLE_USER." where user_id='".$userID."'");
							}else{
								$VisitorName ='';
							}
						
					  ?>
                      <tr>
                         <td valign="top" align="right"><?=$s;?></td>
                         <td valign="top" align="right"><?=$VisitorName;?></td>
                         <td valign="top"><?=com_db_output($searchStr);?></td>
                         <td valign="top" align="right"><?=$tot_search_result;?></td>
                         <td valign="top">
                         	<? if($sRow['user_id']>0){ ?>
                         	<input type="button" value="Send Alert Email" onclick="SendAlertEmail('<?=$sRow['user_id'];?>','<?=$sRow['search_id']?>','<?=$p?>');"/>
                            <? } ?>
                         </td>
                       </tr>
                      <? } ?>  
                       <tr><td colspan="5">&nbsp;</td></tr>
                       <tr>
                       	<td colspan="5">
                        	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="666" align="right" valign="top"><table width="200" border="0" align="right" cellpadding="0" cellspacing="0">
                                  <tr>
                                <?php echo number_pages($main_page, $p, $total_data, 8, $items_per_page,'&selected_menu=search');?>		  
                                  </tr>
                                </table></td>
                                <td width="314" align="center" valign="bottom">&nbsp;</td>
                              </tr>
                            </table>
                       	</td>
                       </tr>
                    </table>
				<? } ?>
			</td>
          </tr>
        </table>
		
        </td>
      </tr>
    </table></td>
  </tr>	 
		
 <?php
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