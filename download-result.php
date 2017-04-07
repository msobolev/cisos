<?php
require('includes/include-top.php');
require('php_xls.php');

$xls=new PHP_XLS();                  //create excel object
$xls->AddSheet('sheet 1');      //add a work sheet

$xls->SetActiveStyle('center');

$xls->Text(2,1,"M A N A G E M E N T      C H A N G E S");

$xls->Text(4,1,"First Name");
$xls->Text(4,2,"Last Name");
$xls->Text(4,3,"Title");
$xls->Text(4,4,"E-Mail");
$xls->Text(4,5,"Phone");
$xls->Text(4,6,"Company Name");
$xls->Text(4,7,"Company Website");
$xls->Text(4,8,"Company Size � Revenue");
$xls->Text(4,9,"Company Size � Employees");
$xls->Text(4,10,"Company Industry");
$xls->Text(4,11,"Address");
$xls->Text(4,12,"Address 2");

$xls->Text(4,13,"City");
$xls->Text(4,14,"State");
$xls->Text(4,15,"Country");
$xls->Text(4,16,"Zip Code");
$xls->Text(4,17,"Announce Date");
$xls->Text(4,18,"Effective Date");
$xls->Text(4,19,"Source");
$xls->Text(4,20,"Headline");
$xls->Text(4,21,"Full Body");
$xls->Text(4,22,"Short Url");
$xls->Text(4,23,"Movement Type");
$xls->Text(4,24,"What Happened");
$xls->Text(4,25,"About Person");
$xls->Text(4,26,"About Company");
$xls->Text(4,27,"Source URL");

$xls->Text(4,28,"Funding Date");
$xls->Text(4,29,"Funding Amount");
$xls->Text(4,30,"Funding Source");

$action = $_REQUEST['action'];
$engagement_triggers = $_POST['engagement_triggers'];
if($action=='fromTop'){
	$selected_contact_list = $_REQUEST['selected_contact_list'];
	if($selected_contact_list !=''){
		$sel_contact_list = $selected_contact_list;
	}
}


if($sel_contact_list!='')
{   
    //echo "<br>in if";
    $download_query = "select mm.move_id,mm.title,mm.announce_date,mm.what_happened,mm.movement_url,mm.effective_date,mm.announce_date,mm.headline,mm.full_body,mm.short_url,mm.more_link,
        pm.personal_id,pm.first_name,pm.middle_name,pm.last_name,pm.email,pm.phone,pm.about_person,cm.company_name,
        cm.company_website,cm.address,cm.address2,cm.city,cm.zip_code,cm.phone as cphone,
        cm.fax,cm.about_company,m.name as movement_name,so.source as source,
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

}
else
{
    //echo "<br>in else";
    $download_query = com_db_output($_REQUEST['txtquery']);
    $download_query .= ' and pm.ciso_user = 1';
    //echo "download_query: ".$download_query;
}
//die();
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
	$cntResult =  com_db_query($download_query);
	if($cntResult){
		$cntNumRow = com_db_num_rows($cntResult);
		if($cntNumRow>2000){
			$info_add="Yes";
		}
	}
	$download_query = $download_query .' limit 0,2000';
	
	$result=com_db_query($download_query);
}
   
	$xlsRow = 5;
	$download_info_query = "insert into " . TABLE_DOWNLOAD . "(user_id,add_date) values ('".$_SESSION['sess_user_id']."','".date('Y-m-d')."')";
	com_db_query($download_info_query);
	$download_id = com_db_insert_id();
	$person_id_list='';
	while($download_row=com_db_fetch_array($result)) {
		
		$download_trans_query = "insert into " . TABLE_DOWNLOAD_TRANS . "(download_id,contact_id) values ('$download_id','".$download_row['move_id']."')";
		com_db_query($download_trans_query);
		
		if($person_id_list==''){
			$person_id_list = $download_row['personal_id'];
		}else{
			$person_id_list .= ",".$download_row['personal_id'];
		}
		
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
		$movement_name = com_db_output($download_row['movement_name']);
		$what_happened = com_db_output(strip_tags($download_row['what_happened']));
		$about_person = com_db_output(strip_tags($download_row['about_person']));
		$about_company = com_db_output(strip_tags($download_row['about_company']));
		$more_link = com_db_output($download_row['more_link']);
                
                
                $funding_date = "";
                $funding_amount = "";
                $funding_Source = "";
                    
                if($download_row['funding_date'])
                {    
                    $funding_date = com_db_output($download_row['funding_date']);
                }    
                
                if($download_row['funding_amount'])
                {    
                    $funding_amount = com_db_output($download_row['funding_amount']);
                }
                
                if($download_row['funding_Source'])
                {    
                    $funding_Source = com_db_output($download_row['funding_Source']);
                }
		
		$xls->Text($xlsRow,1,"$first_name");
		$xls->Text($xlsRow,2,"$last_name");
		$xls->Text($xlsRow,3,"$title");
		$xls->Text($xlsRow,4,"$email");
		$xls->Text($xlsRow,5,"$phone");
		$xls->Text($xlsRow,6,"$company_name");
		$xls->Text($xlsRow,7,"$company_website");
		$xls->Text($xlsRow,8,"$company_revenue");
		$xls->Text($xlsRow,9,"$company_employee");
		$xls->Text($xlsRow,10,"$company_industry");
		$xls->Text($xlsRow,11,"$address");
		$xls->Text($xlsRow,12,"$address2");
		$xls->Text($xlsRow,13,"$city");
		$xls->Text($xlsRow,14,"$state");
		$xls->Text($xlsRow,15,"$country");
		$xls->Text($xlsRow,16,"$zip_code");
		$xls->Text($xlsRow,17,"$announce_date");
		$xls->Text($xlsRow,18,"$effective_date");
		$xls->Text($xlsRow,19,"$source");
		$xls->Text($xlsRow,20,"$headline");
		$xls->Text($xlsRow,21,"$full_body");
		$xls->Text($xlsRow,22,"$short_url");
		$xls->Text($xlsRow,23,"$movement_name");
		$xls->Text($xlsRow,24,"$what_happened");
		$xls->Text($xlsRow,25,"$about_person");
		$xls->Text($xlsRow,26,"$about_company");
		$xls->Text($xlsRow,27,"$more_link");
                
                $xls->Text($xlsRow,28,"$funding_date");
                $xls->Text($xlsRow,29,"$funding_amount");
                $xls->Text($xlsRow,30,"$funding_Source");
		
		$xlsRow++;
		
		}
		if($engagement_triggers=='Yes' && $person_id_list !=''){
			//Awards
			$download_pa_query = "select pa.*, mm.move_id,mm.title,
									pm.personal_id,pm.first_name,pm.last_name,pm.email,pm.phone,
									cm.company_name,cm.company_website,cm.address,cm.address2,cm.city,cm.zip_code,cm.phone as cphone,
									m.name as movement_type,
									s.short_name as state,ct.countries_name as country,i.title as company_industry,
									r.name as company_revenue,e.name as company_employee from " 
									.TABLE_MOVEMENT_MASTER. " as mm, "
									.TABLE_PERSONAL_MASTER. " as pm, "
									.TABLE_COMPANY_MASTER. " as cm, " 
									.TABLE_MANAGEMENT_CHANGE." as m, "
									.TABLE_STATE." as s, "
									.TABLE_COUNTRIES." as ct, "
									.TABLE_INDUSTRY." as i, "
									.TABLE_REVENUE_SIZE." as r, "
									.TABLE_EMPLOYEE_SIZE." as e ,"
									.TABLE_PERSONAL_AWARDS." as pa   
									where (mm.company_id=cm.company_id and mm.personal_id=pm.personal_id and mm.status ='0' and mm.movement_type=m.id) 
									and (cm.state=s.state_id and cm.country=ct.countries_id and cm.industry_id=i.industry_id and cm.company_revenue=r.id and cm.company_employee=e.id) and (pm.personal_id=pa.personal_id and pa.personal_id>0 and pa.status=0 and pa.personal_id in (".$person_id_list."))";
		
			$result =com_db_query($download_pa_query);
			if($result){
				$paNumRow = com_db_num_rows($result);
			}
			if($paNumRow>0){
				$xlsRow++;
				$xls->Text($xlsRow,1,"A W A R D S");
				$xlsRow=$xlsRow+2;
				$xls->Text($xlsRow,1,"First Name");
				$xls->Text($xlsRow,2,"Last Name");
				$xls->Text($xlsRow,3,"Title");
				$xls->Text($xlsRow,4,"E-Mail");
				$xls->Text($xlsRow,5,"Phone");
				$xls->Text($xlsRow,6,"Company Name");
				$xls->Text($xlsRow,7,"Company Website");
				$xls->Text($xlsRow,8,"Company Size � Revenue");
				$xls->Text($xlsRow,9,"Company Size � Employees");
				$xls->Text($xlsRow,10,"Company Industry");
				$xls->Text($xlsRow,11,"Address");
				$xls->Text($xlsRow,12,"Address 2");
				$xls->Text($xlsRow,13,"City");
				$xls->Text($xlsRow,14,"State");
				$xls->Text($xlsRow,15,"Country");
				$xls->Text($xlsRow,16,"Zip Code");
				$xls->Text($xlsRow,17,"");
				$xls->Text($xlsRow,18,"Awards Date");
				$xls->Text($xlsRow,19,"Awards Title");
				$xls->Text($xlsRow,20,"Award Given By");
				$xls->Text($xlsRow,21,"Link");
				
				$xlsRow++;

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
				
				$awards_date = $download_row['awards_date'];
				$adate = explode('-',$awards_date);
				$awards_date = $adate[1].'/'.$adate[2].'/'.$adate[0];
				$awards_title = com_db_output($download_row['awards_title']);
				$awards_given_by = com_db_output($download_row['awards_given_by']);
				$awards_link = com_db_output($download_row['awards_link']);
				
				$xls->Text($xlsRow,1,"$first_name");
				$xls->Text($xlsRow,2,"$last_name");
				$xls->Text($xlsRow,3,"$title");
				$xls->Text($xlsRow,4,"$email");
				$xls->Text($xlsRow,5,"$phone");
				$xls->Text($xlsRow,6,"$company_name");
				$xls->Text($xlsRow,7,"$company_website");
				$xls->Text($xlsRow,8,"$company_revenue");
				$xls->Text($xlsRow,9,"$company_employee");
				$xls->Text($xlsRow,10,"$company_industry");
				$xls->Text($xlsRow,11,"$address");
				$xls->Text($xlsRow,12,"$address2");
				$xls->Text($xlsRow,13,"$city");
				$xls->Text($xlsRow,14,"$state");
				$xls->Text($xlsRow,15,"$country");
				$xls->Text($xlsRow,16,"$zip_code");
				$xls->Text($xlsRow,17,"");
				$xls->Text($xlsRow,18,"$awards_date");
				$xls->Text($xlsRow,19,"$awards_title");
				$xls->Text($xlsRow,20,"$awards_given_by");
				$xls->Text($xlsRow,21,"$awards_link");
								
				$xlsRow++;
				
				} 
			}
			//Speaking
			  $download_ps_query = "select ps.*, mm.move_id,mm.title,
									pm.personal_id,pm.first_name,pm.last_name,pm.email,pm.phone,
									cm.company_name,cm.company_website,cm.address,cm.address2,cm.city,cm.zip_code,cm.phone as cphone,
									m.name as movement_type,
									s.short_name as state,ct.countries_name as country,i.title as company_industry,
									r.name as company_revenue,e.name as company_employee from " 
									.TABLE_MOVEMENT_MASTER. " as mm, "
									.TABLE_PERSONAL_MASTER. " as pm, "
									.TABLE_COMPANY_MASTER. " as cm, " 
									.TABLE_MANAGEMENT_CHANGE." as m, "
									.TABLE_STATE." as s, "
									.TABLE_COUNTRIES." as ct, "
									.TABLE_INDUSTRY." as i, "
									.TABLE_REVENUE_SIZE." as r, "
									.TABLE_EMPLOYEE_SIZE." as e ,"
									.TABLE_PERSONAL_SPEAKING." as ps   
									where (mm.company_id=cm.company_id and mm.personal_id=pm.personal_id and mm.status ='0' and mm.movement_type=m.id) 
									and (cm.state=s.state_id and cm.country=ct.countries_id and cm.industry_id=i.industry_id and cm.company_revenue=r.id and cm.company_employee=e.id) and (pm.personal_id=ps.personal_id and ps.event_date>'".date("Y-m-d")."' and ps.personal_id>0 and ps.status=0 and ps.personal_id in (".$person_id_list."))";
		
			$result =com_db_query($download_ps_query);
			if($result){
				$psNumRow = com_db_num_rows($result);
			}
			if($psNumRow>0){
				$xlsRow++;
				$xls->Text($xlsRow,1,"S P E A K I N G");
				$xlsRow=$xlsRow+2;
				$xls->Text($xlsRow,1,"First Name");
				$xls->Text($xlsRow,2,"Last Name");
				$xls->Text($xlsRow,3,"Title");
				$xls->Text($xlsRow,4,"E-Mail");
				$xls->Text($xlsRow,5,"Phone");
				$xls->Text($xlsRow,6,"Company Name");
				$xls->Text($xlsRow,7,"Company Website");
				$xls->Text($xlsRow,8,"Company Size � Revenue");
				$xls->Text($xlsRow,9,"Company Size � Employees");
				$xls->Text($xlsRow,10,"Company Industry");
				$xls->Text($xlsRow,11,"Address");
				$xls->Text($xlsRow,12,"Address 2");
				$xls->Text($xlsRow,13,"City");
				$xls->Text($xlsRow,14,"State");
				$xls->Text($xlsRow,15,"Country");
				$xls->Text($xlsRow,16,"Zip Code");
				$xls->Text($xlsRow,17,"");
				$xls->Text($xlsRow,18,"Event Date");
				$xls->Text($xlsRow,19,"Role");
				$xls->Text($xlsRow,20,"Topic");
				$xls->Text($xlsRow,21,"Event");
				$xls->Text($xlsRow,22,"Link");
				$xlsRow++;
				
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
				
				$event_date = $download_row['event_date'];
				$edate = explode('-',$event_date);
				$event_date = $edate[1].'/'.$edate[2].'/'.$edate[0];
				$role = com_db_output($download_row['role']);
				$topic = com_db_output($download_row['topic']);
				$event = com_db_output($download_row['event']);
				$speaking_link = com_db_output($download_row['speaking_link']);
				
				$xls->Text($xlsRow,1,"$first_name");
				$xls->Text($xlsRow,2,"$last_name");
				$xls->Text($xlsRow,3,"$title");
				$xls->Text($xlsRow,4,"$email");
				$xls->Text($xlsRow,5,"$phone");
				$xls->Text($xlsRow,6,"$company_name");
				$xls->Text($xlsRow,7,"$company_website");
				$xls->Text($xlsRow,8,"$company_revenue");
				$xls->Text($xlsRow,9,"$company_employee");
				$xls->Text($xlsRow,10,"$company_industry");
				$xls->Text($xlsRow,11,"$address");
				$xls->Text($xlsRow,12,"$address2");
				$xls->Text($xlsRow,13,"$city");
				$xls->Text($xlsRow,14,"$state");
				$xls->Text($xlsRow,15,"$country");
				$xls->Text($xlsRow,16,"$zip_code");
				$xls->Text($xlsRow,17,"");
				$xls->Text($xlsRow,18,"$event_date");
				$xls->Text($xlsRow,19,"$role");
				$xls->Text($xlsRow,20,"$topic");
				$xls->Text($xlsRow,21,"$event");
				$xls->Text($xlsRow,22,"$speaking_link");
								
				$xlsRow++;
				
				} 
			}
			
			//Media Mention

			  $download_pmm_query = "select pmm.*, mm.move_id,mm.title,
									pm.personal_id,pm.first_name,pm.last_name,pm.email,pm.phone,
									cm.company_name,cm.company_website,cm.address,cm.address2,cm.city,cm.zip_code,cm.phone as cphone,
									m.name as movement_type,
									s.short_name as state,ct.countries_name as country,i.title as company_industry,
									r.name as company_revenue,e.name as company_employee from " 
									.TABLE_MOVEMENT_MASTER. " as mm, "
									.TABLE_PERSONAL_MASTER. " as pm, "
									.TABLE_COMPANY_MASTER. " as cm, " 
									.TABLE_MANAGEMENT_CHANGE." as m, "
									.TABLE_STATE." as s, "
									.TABLE_COUNTRIES." as ct, "
									.TABLE_INDUSTRY." as i, "
									.TABLE_REVENUE_SIZE." as r, "
									.TABLE_EMPLOYEE_SIZE." as e ,"
									.TABLE_PERSONAL_MEDIA_MENTION." as pmm   
									where (mm.company_id=cm.company_id and mm.personal_id=pm.personal_id and mm.status ='0' and mm.movement_type=m.id) 
									and (cm.state=s.state_id and cm.country=ct.countries_id and cm.industry_id=i.industry_id and cm.company_revenue=r.id and cm.company_employee=e.id) and (pm.personal_id=pmm.personal_id and pmm.personal_id>0 and pmm.status=0 and pmm.personal_id in (".$person_id_list."))";
		
			$result =com_db_query($download_pmm_query);
			if($result){
				$pmmNumRow = com_db_num_rows($result);
			}
			if($pmmNumRow>0){
				$xlsRow++;
				$xls->Text($xlsRow,1,"M E D I A    M E N T I O N");
				$xlsRow=$xlsRow+2;
				$xls->Text($xlsRow,1,"First Name");
				$xls->Text($xlsRow,2,"Last Name");
				$xls->Text($xlsRow,3,"Title");
				$xls->Text($xlsRow,4,"E-Mail");
				$xls->Text($xlsRow,5,"Phone");
				$xls->Text($xlsRow,6,"Company Name");
				$xls->Text($xlsRow,7,"Company Website");
				$xls->Text($xlsRow,8,"Company Size � Revenue");
				$xls->Text($xlsRow,9,"Company Size � Employees");
				$xls->Text($xlsRow,10,"Company Industry");
				$xls->Text($xlsRow,11,"Address");
				$xls->Text($xlsRow,12,"Address 2");
				$xls->Text($xlsRow,13,"City");
				$xls->Text($xlsRow,14,"State");
				$xls->Text($xlsRow,15,"Country");
				$xls->Text($xlsRow,16,"Zip Code");
				$xls->Text($xlsRow,17,"");										
				$xls->Text($xlsRow,18,"Date");
				$xls->Text($xlsRow,19,"Quote");
				$xls->Text($xlsRow,20,"Publication");
				$xls->Text($xlsRow,21,"Link");
				$xlsRow++;
				
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
				
				$pub_date = $download_row['pub_date'];
				$pdate = explode('-',$pub_date);
				$pub_date = $pdate[1].'/'.$pdate[2].'/'.$pdate[0];
				$quote = com_db_output($download_row['quote']);
				$publication = com_db_output($download_row['publication']);
				$media_link = com_db_output($download_row['media_link']);
				
				$xls->Text($xlsRow,1,"$first_name");
				$xls->Text($xlsRow,2,"$last_name");
				$xls->Text($xlsRow,3,"$title");
				$xls->Text($xlsRow,4,"$email");
				$xls->Text($xlsRow,5,"$phone");
				$xls->Text($xlsRow,6,"$company_name");
				$xls->Text($xlsRow,7,"$company_website");
				$xls->Text($xlsRow,8,"$company_revenue");
				$xls->Text($xlsRow,9,"$company_employee");
				$xls->Text($xlsRow,10,"$company_industry");
				$xls->Text($xlsRow,11,"$address");
				$xls->Text($xlsRow,12,"$address2");
				$xls->Text($xlsRow,13,"$city");
				$xls->Text($xlsRow,14,"$state");
				$xls->Text($xlsRow,15,"$country");
				$xls->Text($xlsRow,16,"$zip_code");
				$xls->Text($xlsRow,17,"");
				$xls->Text($xlsRow,18,"$pub_date");
				$xls->Text($xlsRow,19,"$quote");
				$xls->Text($xlsRow,20,"$publication");
				$xls->Text($xlsRow,21,"$media_link");
								
				$xlsRow++;
				
				} 
			}
			
			//Publication

			  $download_pp_query = "select pp.*, mm.move_id,mm.title,
									pm.personal_id,pm.first_name,pm.last_name,pm.email,pm.phone,
									cm.company_name,cm.company_website,cm.address,cm.address2,cm.city,cm.zip_code,cm.phone as cphone,
									m.name as movement_type,
									s.short_name as state,ct.countries_name as country,i.title as company_industry,
									r.name as company_revenue,e.name as company_employee from " 
									.TABLE_MOVEMENT_MASTER. " as mm, "
									.TABLE_PERSONAL_MASTER. " as pm, "
									.TABLE_COMPANY_MASTER. " as cm, " 
									.TABLE_MANAGEMENT_CHANGE." as m, "
									.TABLE_STATE." as s, "
									.TABLE_COUNTRIES." as ct, "
									.TABLE_INDUSTRY." as i, "
									.TABLE_REVENUE_SIZE." as r, "
									.TABLE_EMPLOYEE_SIZE." as e ,"
									.TABLE_PERSONAL_PUBLICATION." as pp   
									where (mm.company_id=cm.company_id and mm.personal_id=pm.personal_id and mm.status ='0' and mm.movement_type=m.id) 
									and (cm.state=s.state_id and cm.country=ct.countries_id and cm.industry_id=i.industry_id and cm.company_revenue=r.id and cm.company_employee=e.id) and (pm.personal_id=pp.personal_id and pp.personal_id>0 and pp.status=0 and pp.personal_id in (".$person_id_list."))";
		
			$result =com_db_query($download_pp_query);
			if($result){
				$ppNumRow = com_db_num_rows($result);
			}
			if($ppNumRow>0){
				$xlsRow++;
				$xls->Text($xlsRow,1,"P U B L I C A T I O N S");
				$xlsRow=$xlsRow+2;
				$xls->Text($xlsRow,1,"First Name");
				$xls->Text($xlsRow,2,"Last Name");
				$xls->Text($xlsRow,3,"Title");
				$xls->Text($xlsRow,4,"E-Mail");
				$xls->Text($xlsRow,5,"Phone");
				$xls->Text($xlsRow,6,"Company Name");
				$xls->Text($xlsRow,7,"Company Website");
				$xls->Text($xlsRow,8,"Company Size � Revenue");
				$xls->Text($xlsRow,9,"Company Size � Employees");
				$xls->Text($xlsRow,10,"Company Industry");
				$xls->Text($xlsRow,11,"Address");
				$xls->Text($xlsRow,12,"Address 2");
				$xls->Text($xlsRow,13,"City");
				$xls->Text($xlsRow,14,"State");
				$xls->Text($xlsRow,15,"Country");
				$xls->Text($xlsRow,16,"Zip Code");
				$xls->Text($xlsRow,17,"");										
				$xls->Text($xlsRow,18,"Date");
				$xls->Text($xlsRow,19,"Title");
				$xls->Text($xlsRow,20,"Link");
				
				$xlsRow++;
				
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
				
				$publication_date = $download_row['publication_date'];
				$pdate = explode('-',$publication_date);
				$publication_date = $pdate[1].'/'.$pdate[2].'/'.$pdate[0];
				$title = com_db_output($download_row['title']);
				$link = com_db_output($download_row['link']);
								
				$xls->Text($xlsRow,1,"$first_name");
				$xls->Text($xlsRow,2,"$last_name");
				$xls->Text($xlsRow,3,"$title");
				$xls->Text($xlsRow,4,"$email");
				$xls->Text($xlsRow,5,"$phone");
				$xls->Text($xlsRow,6,"$company_name");
				$xls->Text($xlsRow,7,"$company_website");
				$xls->Text($xlsRow,8,"$company_revenue");
				$xls->Text($xlsRow,9,"$company_employee");
				$xls->Text($xlsRow,10,"$company_industry");
				$xls->Text($xlsRow,11,"$address");
				$xls->Text($xlsRow,12,"$address2");
				$xls->Text($xlsRow,13,"$city");
				$xls->Text($xlsRow,14,"$state");
				$xls->Text($xlsRow,15,"$country");
				$xls->Text($xlsRow,16,"$zip_code");
				$xls->Text($xlsRow,17,"");
				$xls->Text($xlsRow,18,"$publication_date");
				$xls->Text($xlsRow,19,"$title");
				$xls->Text($xlsRow,20,"$link");
								
				$xlsRow++;
				
				} 
			}
			//Board Appointments

			$download_pb_query = "select pb.*, mm.move_id,mm.title,
									pm.personal_id,pm.first_name,pm.last_name,pm.email,pm.phone,
									cm.company_name,cm.company_website,cm.address,cm.address2,cm.city,cm.zip_code,cm.phone as cphone,
									m.name as movement_type,
									s.short_name as state,ct.countries_name as country,i.title as company_industry,
									r.name as company_revenue,e.name as company_employee from " 
									.TABLE_MOVEMENT_MASTER. " as mm, "
									.TABLE_PERSONAL_MASTER. " as pm, "
									.TABLE_COMPANY_MASTER. " as cm, " 
									.TABLE_MANAGEMENT_CHANGE." as m, "
									.TABLE_STATE." as s, "
									.TABLE_COUNTRIES." as ct, "
									.TABLE_INDUSTRY." as i, "
									.TABLE_REVENUE_SIZE." as r, "
									.TABLE_EMPLOYEE_SIZE." as e ,"
									.TABLE_PERSONAL_BOARD." as pb   
									where (mm.company_id=cm.company_id and mm.personal_id=pm.personal_id and mm.status ='0' and mm.movement_type=m.id) 
									and (cm.state=s.state_id and cm.country=ct.countries_id and cm.industry_id=i.industry_id and cm.company_revenue=r.id and cm.company_employee=e.id) and (pm.personal_id=pb.personal_id and pb.personal_id>0 and pb.status=0 and pb.personal_id in (".$person_id_list."))";
		
			$result =com_db_query($download_pb_query);
			if($result){
				$pbNumRow = com_db_num_rows($result);
			}
			if($pbNumRow>0){
				$xlsRow++;
				$xls->Text($xlsRow,1,"B O A R D    A P P O I N T M E N T S");
				$xlsRow=$xlsRow+2;
				$xls->Text($xlsRow,1,"First Name");
				$xls->Text($xlsRow,2,"Last Name");
				$xls->Text($xlsRow,3,"Title");
				$xls->Text($xlsRow,4,"E-Mail");
				$xls->Text($xlsRow,5,"Phone");
				$xls->Text($xlsRow,6,"Company Name");
				$xls->Text($xlsRow,7,"Company Website");
				$xls->Text($xlsRow,8,"Company Size � Revenue");
				$xls->Text($xlsRow,9,"Company Size � Employees");
				$xls->Text($xlsRow,10,"Company Industry");
				$xls->Text($xlsRow,11,"Address");
				$xls->Text($xlsRow,12,"Address 2");
				$xls->Text($xlsRow,13,"City");
				$xls->Text($xlsRow,14,"State");
				$xls->Text($xlsRow,15,"Country");
				$xls->Text($xlsRow,16,"Zip Code");
				$xls->Text($xlsRow,17,"");										
				$xls->Text($xlsRow,18,"Date");
				$xls->Text($xlsRow,19,"Board Info");
				$xls->Text($xlsRow,20,"Link");
				
				$xlsRow++;
				
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
				
				$board_date = $download_row['board_date'];
				$bdate = explode('-',$board_date);
				$board_date = $bdate[1].'/'.$bdate[2].'/'.$bdate[0];
				$board_info = com_db_output($download_row['board_info']);
				$board_link = com_db_output($download_row['board_link']);
								
				$xls->Text($xlsRow,1,"$first_name");
				$xls->Text($xlsRow,2,"$last_name");
				$xls->Text($xlsRow,3,"$title");
				$xls->Text($xlsRow,4,"$email");
				$xls->Text($xlsRow,5,"$phone");
				$xls->Text($xlsRow,6,"$company_name");
				$xls->Text($xlsRow,7,"$company_website");
				$xls->Text($xlsRow,8,"$company_revenue");
				$xls->Text($xlsRow,9,"$company_employee");
				$xls->Text($xlsRow,10,"$company_industry");
				$xls->Text($xlsRow,11,"$address");
				$xls->Text($xlsRow,12,"$address2");
				$xls->Text($xlsRow,13,"$city");
				$xls->Text($xlsRow,14,"$state");
				$xls->Text($xlsRow,15,"$country");
				$xls->Text($xlsRow,16,"$zip_code");
				$xls->Text($xlsRow,17,"");
				$xls->Text($xlsRow,18,"$board_date");
				$xls->Text($xlsRow,19,"$board_info");
				$xls->Text($xlsRow,20,"$board_link");
								
				$xlsRow++;
				
				} 
			}
		}
	$xlsRow = $xlsRow+2;
	if($info_add=="Yes"){
		$xls->Text($xlsRow,2,"N.B.-> Downloading all records at one go is not possible. Please use advanced search filter to download selected record.");
	}
	$xls->Output('search-result-'. date('m-d-Y') . '.xls');	

?>