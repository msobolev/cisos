<?php
require('includes/include_top.php');

$contact_id = $_REQUEST['contact_id'];
if($contact_id != ''){
	
	require('php_xls.php');
	
	$xls=new PHP_XLS();             //create excel object
	$xls->AddSheet('sheet 1');      //add a work sheet
	
	$xls->SetActiveStyle('center');
	
	$xls->Text(2,1,"Contact Data : Download");
	$xls->Text(4,1,"First Name");
	$xls->Text(4,2,"Middle Initial");
	$xls->Text(4,3,"Last Name");
	$xls->Text(4,4,"Title");
	$xls->Text(4,5,"Headline");
	$xls->Text(4,6,"Company Name");
	$xls->Text(4,7,"Company Website");
	$xls->Text(4,8,"Industry");
	$xls->Text(4,9,"Address");
	$xls->Text(4,10,"City");
	$xls->Text(4,11,"State");
	$xls->Text(4,12,"Zip Code");
	$xls->Text(4,13,"Country");
	$xls->Text(4,14,"Phone");
	$xls->Text(4,15,"Email");
	
	$xls->Text(4,16,"Date of announcement");
	$xls->Text(4,17,"Effective Date");
	$xls->Text(4,18,"Type");
	$xls->Text(4,19,"The full text of the press release");
	$xls->Text(4,20,"Link");
	$xls->Text(4,21,"Company Size Employees");
	$xls->Text(4,22,"Company Size Revenue");
	$xls->Text(4,23,"Source");
	$xls->Text(4,24,"Short Url");
	$xls->Text(4,25,"What Happened");
	$xls->Text(4,26,"About Person");
	$xls->Text(4,27,"About Company");
	$xls->Text(4,28,"More Link");
	$xls->Text(4,29,"Contact URL");
	
	$download_query_string = "select c.first_name,c.middle_name,c.last_name,c.new_title,c.email,c.phone,c.contact_url,
							c.company_name,c.company_website,r.name as company_revenue,e.name as company_employee,
							i.title as company_industry,c.ind_group_id,c.industry_id,c.address,c.address2,c.city,s.short_name as state,
							ct.countries_name as country,c.zip_code,c.announce_date,c.effective_date,
							so.source as source,c.headline,c.full_body,c.short_url,m.name as movement_type,
							c.what_happened,c.about_person,c.about_company,c.more_link,c.add_date from " 
							.TABLE_CONTACT. " as c, " 
							.TABLE_REVENUE_SIZE." as r, "
							.TABLE_EMPLOYEE_SIZE." as e, "
							.TABLE_INDUSTRY." as i, "
							.TABLE_STATE." as s, "
							.TABLE_COUNTRIES." as ct, "
							.TABLE_SOURCE." as so, "
							.TABLE_MANAGEMENT_CHANGE." as m ";
	
		
		$download_query = $download_query_string ."	where c.company_revenue=r.id and c.company_employee=e.id and c.company_industry=i.industry_id and c.state=s.state_id and c.country=ct.countries_id and c.source=so.id and c.movement_type=m.id and  c.contact_id='".$contact_id."'";
			
		//echo $download_query;	
		$result=com_db_query($download_query);
	   
		$xlsRow = 5;
		while($download_row=com_db_fetch_array($result)) {
			++$i;
			$first_name = str_replace(',',';',com_db_output($download_row['first_name']));
			$middle_name = str_replace(',',';',com_db_output($download_row['middle_name']));
			$last_name = str_replace(',',';',com_db_output($download_row['last_name']));
			$title = str_replace(',',';',com_db_output($download_row['new_title']));
			$headline = str_replace(',',';',com_db_output($download_row['headline']));
			$company_name = str_replace(',',';',com_db_output($download_row['company_name']));
			$company_website = str_replace(',',';',com_db_output($download_row['company_website']));
			$parent_industry =  str_replace(',',';',com_db_GetValue("select title from ".TABLE_INDUSTRY." where industry_id='".$download_row['ind_group_id']."'"));
			$company_industry = $parent_industry.' : '. str_replace(',',';',com_db_output($download_row['company_industry']));
			$address = str_replace(',',';',com_db_output($download_row['address'].' '.$download_row['address2']));
			$city = str_replace(',',';',com_db_output($download_row['city']));
			$state = str_replace(',',';',com_db_output($download_row['state']));
			$zip_code = str_replace(',',';',com_db_output($download_row['zip_code']));
			$country = str_replace(',',';',com_db_output($download_row['country']));
			$phone = str_replace(',',';',$download_row['phone']);
			$email = str_replace(',',';',$download_row['email']);
			
			$announce_date = $download_row['announce_date'];
			$adate = explode('-',$announce_date);
			$announce_date = $adate[1].'/'.$adate[2].'/'.$adate[0];
			
			$effective_date = $download_row['effective_date'];
			$edate = explode('-',$effective_date);
			$effective_date = $edate[1].'/'.$edate[2].'/'.$edate[0];
			
			$movement_type = str_replace(',',';',com_db_output($download_row['movement_type']));
			$full_body = str_replace(',',';',str_replace('<br />','&&&', $download_row['full_body']));
			$link = str_replace(',',';',com_db_output($download_row['link']));
			$company_employee = str_replace(',',';',com_db_output($download_row['company_employee']));
			$company_revenue = str_replace(',',';',com_db_output($download_row['company_revenue']));
			$source = str_replace(',',';',com_db_output($download_row['source']));
			$short_url = str_replace(',',';',com_db_output($download_row['short_url']));
			$what_happened = str_replace(',',';',com_db_output($download_row['what_happened']));
			$about_person = str_replace(',',';',com_db_output($download_row['about_person']));
			$about_company = str_replace(',',';',com_db_output($download_row['about_company']));
			$more_link = str_replace(',',';',com_db_output($download_row['more_link']));
			$contact_url = $download_row['contact_url'];
			
			$xls->Text($xlsRow,1,"$first_name");
			$xls->Text($xlsRow,2,"$middle_name");
			$xls->Text($xlsRow,3,"$last_name");
			$xls->Text($xlsRow,4,"$title");
			$xls->Text($xlsRow,5,"$headline");
			$xls->Text($xlsRow,6,"$company_name");
			$xls->Text($xlsRow,7,"$company_website");
			$xls->Text($xlsRow,8,"$company_industry");
			$xls->Text($xlsRow,9,"$address");
			$xls->Text($xlsRow,10,"$city");
			$xls->Text($xlsRow,11,"$state");
			$xls->Text($xlsRow,12,"$zip_code");
			$xls->Text($xlsRow,13,"$country");
			$xls->Text($xlsRow,14,"$phone");
			$xls->Text($xlsRow,15,"$email");
			$xls->Text($xlsRow,16,"$announce_date");
			$xls->Text($xlsRow,17,"$effective_date");
			$xls->Text($xlsRow,18,"$movement_type");
			$xls->Text($xlsRow,19,"$full_body");
			$xls->Text($xlsRow,20,"$link");
			$xls->Text($xlsRow,21,"$company_employee");
			$xls->Text($xlsRow,22,"$company_revenue");
			$xls->Text($xlsRow,23,"$source");
			$xls->Text($xlsRow,24,"$short_url");
			$xls->Text($xlsRow,25,"$what_happened");
			$xls->Text($xlsRow,26,"$about_person");
			$xls->Text($xlsRow,27,"$about_company");
			$xls->Text($xlsRow,28,"$more_link");
			$xls->Text($xlsRow,29,"$contact_url");
			
			$xlsRow++;
			}
		$xls->Output('download-contact-'.$contact_id.'-'. date('m-d-Y') . '.xls');	

}
?>