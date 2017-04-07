<?php
require('includes/include-top.php');
require('php_xls.php');

$xls=new PHP_XLS();                  //create excel object
$xls->AddSheet('sheet 1');      //add a work sheet

$xls->SetActiveStyle('center');

$xls->Text(2,1,"Search Result : Download");

$xls->Text(4,1,"Sl.No.");
$xls->Text(4,2,"First Name");
$xls->Text(4,3,"Last Name");
$xls->Text(4,4,"Title");
$xls->Text(4,5,"E-Mail");
$xls->Text(4,6,"Phone");
$xls->Text(4,7,"Company Name");
$xls->Text(4,8,"Company Website");
$xls->Text(4,9,"Company Size – Revenue");
$xls->Text(4,10,"Company Size – Employees");
$xls->Text(4,11,"Company Industry");
$xls->Text(4,12,"Address");
$xls->Text(4,13,"Address 2");

$xls->Text(4,14,"City");
$xls->Text(4,15,"State");
$xls->Text(4,16,"Country");
$xls->Text(4,17,"Zip Code");
$xls->Text(4,18,"Announce Date");
$xls->Text(4,19,"Effective Date");
$xls->Text(4,20,"Source");
$xls->Text(4,21,"Headline");
$xls->Text(4,22,"Full Body");
$xls->Text(4,23,"Short Url");
$xls->Text(4,24,"Movement Type");
$xls->Text(4,25,"What Happened");
$xls->Text(4,26,"About Person");
$xls->Text(4,27,"About Company");
$xls->Text(4,28,"More Link");

$action = $_REQUEST['action'];
if($action=='fromTop'){
	$selected_contact_list = $_REQUEST['selected_contact_list'];
	if($selected_contact_list !=''){
		$sel_contact_list = $selected_contact_list;
	}
}
if($action=='fromBottom'){
	$selected_contact_list_bottom = $_REQUEST['selected_contact_list_bottom'];
	if($selected_contact_list_bottom !=''){
		$sel_contact_list = $selected_contact_list_bottom;
	}
}	

if($sel_contact_list!='' && $sel_contact_list!='ALL'){
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
						and (cm.state=s.state_id and cm.country=ct.countries_id and cm.industry_id=i.industry_id and cm.company_revenue=r.id and cm.company_employee=e.id) and mm.move_id in (".$sel_contact_list.")";
									
}elseif($sel_contact_list=='ALL'){
	$download_query = com_db_output($_REQUEST['txtquery']);
}else{
	$download_query = com_db_output($_REQUEST['txtquery']);
}
$download_query = $download_query.' order by cm.company_revenue';

$totalDownloadContact = com_db_GetValue("select count(dt.contact_id) from ".TABLE_DOWNLOAD_TRANS." as dt, ".TABLE_DOWNLOAD." as d where d.download_id=dt.download_id and d.add_date like '".date('Y-m')."%' and d.user_id='".$_SESSION['sess_user_id']."'");
$isSubscriptionID = com_db_GetValue("select subscription_id from " . TABLE_USER . " where user_id='".$_SESSION['sess_user_id']."'");
if($isSubscriptionID=='1' || $isSubscriptionID=='2' || $isSubscriptionID=='3'){
	$pc_pre_month = com_db_GetValue("select download_contacts from " . TABLE_SUBSCRIPTION . " where sub_id='".$isSubscriptionID."'");
	if($totalDownloadContact >= $pc_pre_month){
		$url ='notifications.php';
		com_redirect($url);
	}
	$result=com_db_query($download_query);
	$nowDownloadCount = com_db_num_rows($result);
	if($nowDownloadCount+$totalDownloadContact > $pc_pre_month){
		if($totalDownloadContact < $pc_pre_month){
			$nowDownloadableContact = $pc_pre_month - $totalDownloadContact;
		}else{
			$url ='notifications.php';
			com_redirect($url);
		}
	 $download_query = $download_query .' limit 0,'.$nowDownloadableContact; 		
	 $result=com_db_query($download_query);	
	}
}else{
	$result=com_db_query($download_query);
}
   
	$xlsRow = 5;
	$download_info_query = "insert into " . TABLE_DOWNLOAD . "(user_id,add_date) values ('".$_SESSION['sess_user_id']."','".date('Y-m-d')."')";
	com_db_query($download_info_query);
	$download_id = com_db_insert_id();
	while($download_row=com_db_fetch_array($result)) {
		
		$download_trans_query = "insert into " . TABLE_DOWNLOAD_TRANS . "(download_id,contact_id) values ('$download_id','".$download_row['move_id']."')";
		com_db_query($download_trans_query);
		
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
		$headline = com_db_output($download_row['headline']);
		$full_body = str_replace('<br />','&&&', $download_row['full_body']);
		$full_body = com_db_output($full_body);
		$short_url = com_db_output($download_row['short_url']);
		$movement_type = com_db_output($download_row['movement_name']);
		$what_happened = com_db_output(strip_tags($download_row['what_happened']));
		$about_person = com_db_output(strip_tags($download_row['about_person']));
		$about_company = com_db_output(strip_tags($download_row['about_company']));
		$more_link = com_db_output($download_row['more_link']);
		
		$xls->Text($xlsRow,1,"$i");
		$xls->Text($xlsRow,2,"$first_name");
		$xls->Text($xlsRow,3,"$last_name");
		$xls->Text($xlsRow,4,"$title");
		$xls->Text($xlsRow,5,"$email");
		$xls->Text($xlsRow,6,"$phone");
		$xls->Text($xlsRow,7,"$company_name");
		$xls->Text($xlsRow,8,"$company_website");
		$xls->Text($xlsRow,9,"$company_revenue");
		$xls->Text($xlsRow,10,"$company_employee");
		$xls->Text($xlsRow,11,"$company_industry");
		$xls->Text($xlsRow,12,"$address");
		$xls->Text($xlsRow,13,"$address2");
		$xls->Text($xlsRow,14,"$city");
		$xls->Text($xlsRow,15,"$state");
		$xls->Text($xlsRow,16,"$country");
		$xls->Text($xlsRow,17,"$zip_code");
		$xls->Text($xlsRow,18,"$announce_date");
		$xls->Text($xlsRow,19,"$effective_date");
		$xls->Text($xlsRow,20,"$source");
		$xls->Text($xlsRow,21,"$headline");
		$xls->Text($xlsRow,22,"$full_body");
		$xls->Text($xlsRow,23,"$short_url");
		$xls->Text($xlsRow,24,"$movement_type");
		$xls->Text($xlsRow,25,"$what_happened");
		$xls->Text($xlsRow,26,"$about_person");
		$xls->Text($xlsRow,27,"$about_company");
		$xls->Text($xlsRow,28,"$more_link");
		
		$xlsRow++;
		}
	$xls->Output('search-result-'. date('m-d-Y') . '.xls');	

?>