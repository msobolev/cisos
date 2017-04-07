<?php
require('includes/include_top.php');

$company_id = $_REQUEST['company_id'];
if($company_id != ''){
	require('php_xls.php');
	
	$xls=new PHP_XLS();             //create excel object
	$xls->AddSheet('sheet 1');      //add a work sheet
	
	$xls->SetActiveStyle('center');
	
	$xls->Text(2,1,"Contact Data : Download");
	$xls->Text(4,1,"Company ID");
	$xls->Text(4,2,"Company Name");
	$xls->Text(4,3,"Company Website");
	$xls->Text(4,4,"Company Logo");
	$xls->Text(4,5,"Company Size Revenue");
	$xls->Text(4,6,"Company Size Employees");
	$xls->Text(4,7,"Industry");
	$xls->Text(4,8,"Email Pattern");
	$xls->Text(4,9,"Leadership Page");
	$xls->Text(4,10,"Address");
	$xls->Text(4,11,"Address 2");
	$xls->Text(4,12,"City");
	$xls->Text(4,13,"Country");
	$xls->Text(4,14,"State");
	$xls->Text(4,15,"Zip Code");
	$xls->Text(4,16,"Phone");
	$xls->Text(4,17,"Fax");
	$xls->Text(4,18,"About Company");
	$xls->Text(4,19,"Facebook Link");
	$xls->Text(4,20,"Linkedin Link");
	$xls->Text(4,21,"Twitter Link");
	$xls->Text(4,22,"Google+ Link");		

	
	
	
	$download_query_string = "select c.company_id,c.company_name,c.company_website,c.company_logo,r.name as company_revenue,e.name as company_employee,
							i.title as company_industry,c.ind_group_id,c.industry_id,c.address,c.address2,c.city,s.short_name as state,
							ct.countries_name as country,c.zip_code,c.phone,c.fax,c.about_company,c.leadership_page,c.email_pattern,
							c.facebook_link,c.linkedin_link,c.twitter_link,c.googleplush_link,c.add_date from " 
							.TABLE_COMPANY_MASTER. " as c, " 
							.TABLE_REVENUE_SIZE." as r, "
							.TABLE_EMPLOYEE_SIZE." as e, "
							.TABLE_INDUSTRY." as i, "
							.TABLE_STATE." as s, "
							.TABLE_COUNTRIES." as ct ";
							
		$download_query = $download_query_string ."	where c.company_revenue=r.id and c.company_employee=e.id and c.company_industry=i.industry_id and c.state=s.state_id and c.country=ct.countries_id and  c.company_id='".$company_id."'";
			
		//echo $download_query;	
		$result=com_db_query($download_query);
	   
		$xlsRow = 5;
		while($download_row=com_db_fetch_array($result)) {
			++$i;
			
			$company_id = str_replace(',',';',com_db_output($download_row['company_id']));
			
			$company_name = str_replace(',',';',com_db_output($download_row['company_name']));
			$company_website = str_replace(',',';',com_db_output($download_row['company_website']));
			$company_logo = str_replace(',',';',com_db_output($download_row['company_logo']));
			$parent_industry =  str_replace(',',';',com_db_GetValue("select title from ".TABLE_INDUSTRY." where industry_id='".$download_row['ind_group_id']."'"));
			$company_industry = $parent_industry.' : '. str_replace(',',';',com_db_output($download_row['company_industry']));
			$address = str_replace(',',';',com_db_output($download_row['address']));
			$address2 = str_replace(',',';',com_db_output($download_row['address2']));
			$city = str_replace(',',';',com_db_output($download_row['city']));
			$state = str_replace(',',';',com_db_output($download_row['state']));
			$zip_code = str_replace(',',';',com_db_output($download_row['zip_code']));
			$phone = str_replace(',',';',com_db_output($download_row['phone']));
			$fax = str_replace(',',';',com_db_output($download_row['fax']));
			$country = str_replace(',',';',com_db_output($download_row['country']));
			$company_employee = str_replace(',',';',com_db_output($download_row['company_employee']));
			$company_revenue = str_replace(',',';',com_db_output($download_row['company_revenue']));
			$about_company = str_replace(',',';',strip_tags($download_row['about_company']));
			$leadership_page = str_replace(',',';',com_db_output($download_row['leadership_page']));
			$email_patternc = str_replace(',',';',com_db_output($download_row['email_patternc']));
			$facebook_link = str_replace(',',';',com_db_output($download_row['facebook_link']));
			$linkedin_link = str_replace(',',';',com_db_output($download_row['linkedin_link']));
			$twitter_link = str_replace(',',';',com_db_output($download_row['twitter_link']));
			$googleplush_link = str_replace(',',';',com_db_output($download_row['googleplush_link']));
			
			$xls->Text($xlsRow,1,"$company_id");
			$xls->Text($xlsRow,2,"$company_name");
			$xls->Text($xlsRow,3,"$company_website");
			$xls->Text($xlsRow,4,"$company_logo");
			$xls->Text($xlsRow,5,"$company_revenue");
			$xls->Text($xlsRow,6,"$company_employee");
			$xls->Text($xlsRow,7,"$company_industry");
			$xls->Text($xlsRow,8,"$email_patternc");
			$xls->Text($xlsRow,9,"$leadership_page");
			$xls->Text($xlsRow,10,"$address");
			$xls->Text($xlsRow,11,"$address2");
			$xls->Text($xlsRow,12,"$city");
			$xls->Text($xlsRow,13,"$country");
			$xls->Text($xlsRow,14,"$state");
			$xls->Text($xlsRow,15,"$zip_code");
			$xls->Text($xlsRow,16,"$phone");
			$xls->Text($xlsRow,17,"$fax");
			$xls->Text($xlsRow,18,"$about_company");
			$xls->Text($xlsRow,19,"$facebook_link");
			$xls->Text($xlsRow,20,"$linkedin_link");
			$xls->Text($xlsRow,21,"$twitter_link");
			$xls->Text($xlsRow,22,"$googleplush_link");
			
			$xlsRow++;
			}
		$xls->Output('download-company-'.$company_id.'-'. date('m-d-Y') . '.xls');	

}
?>