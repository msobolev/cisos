<?php
require('includes/include_top.php');

$personal_id = $_REQUEST['personal_id'];
if($personal_id != ''){
	require('php_xls.php');
	
	$xls=new PHP_XLS();             //create excel object
	$xls->AddSheet('sheet 1');      //add a work sheet
	
	$xls->SetActiveStyle('center');
	
	$xls->Text(2,1,"Personal Data : Download");
	$xls->Text(4,1,"Personal ID");
	$xls->Text(4,2,"First Name");
	$xls->Text(4,3,"Middle Initial");
	$xls->Text(4,4,"Last Name");
	$xls->Text(4,5,"Email");
	$xls->Text(4,6,"Phone");
	$xls->Text(4,7,"LIN Url");
	$xls->Text(4,8,"Personal Image");
	$xls->Text(4,9,"About Person (bio)");
	$xls->Text(4,10,"Personal");
	$xls->Text(4,11,"Facebook Link");
	$xls->Text(4,12,"Linkedin Link");
	$xls->Text(4,13,"Twitter Link");
	$xls->Text(4,14,"Google+ Link");
	$xls->Text(4,15,"Undergrad Degree");
	$xls->Text(4,16,"Undergrad Specialization");
	$xls->Text(4,17,"Undergrad College");
	$xls->Text(4,18,"Undergrad Graduation Year");
	$xls->Text(4,19,"Grad Degree");
	$xls->Text(4,20,"Grad Specialization");
	$xls->Text(4,21,"Grad College");
	$xls->Text(4,22,"Grad Graduation Year");
	

	
	$download_query_string = "select * from " .TABLE_PERSONAL_MASTER."	where personal_id='".$personal_id."'";
							
	$result=com_db_query($download_query_string);
	   
		$xlsRow = 5;
		while($download_row=com_db_fetch_array($result)) {
			++$i;
			$personal_id = str_replace(',',';',com_db_output($download_row['personal_id']));	
			$first_name = str_replace(',',';',com_db_output($download_row['first_name']));
			$middle_name = str_replace(',',';',com_db_output($download_row['middle_name']));
			$last_name = str_replace(',',';',com_db_output($download_row['last_name']));
			$email = str_replace(',',';',com_db_output($download_row['email']));
			$phone = str_replace(',',';',com_db_output($download_row['phone']));
			$lin_url = str_replace(',',';',com_db_output($download_row['lin_url']));
			$personal_image = str_replace(',',';',com_db_output($download_row['personal_image']));
			$facebook_link = str_replace(',',';',com_db_output($download_row['facebook_link']));
			$linkedin_link = str_replace(',',';',com_db_output($download_row['linkedin_link']));
			$twitter_link = str_replace(',',';',com_db_output($download_row['twitter_link']));
			$googleplush_link = str_replace(',',';',com_db_output($download_row['googleplush_link']));
			$about_person = str_replace(',',';',strip_tags($download_row['about_person']));
			$personal = str_replace(',',';',com_db_output($download_row['personal']));
			$edu_ugrad_degree = str_replace(',',';',com_db_output($download_row['edu_ugrad_degree']));
			$edu_ugrad_specialization = str_replace(',',';',com_db_output($download_row['edu_ugrad_specialization']));
			$edu_ugrad_college = str_replace(',',';',com_db_output($download_row['edu_ugrad_college']));
			$edu_ugrad_year = str_replace(',',';',com_db_output($download_row['edu_ugrad_year']));
			$edu_grad_degree = str_replace(',',';',com_db_output($download_row['edu_grad_degree']));
			$edu_grad_specialization = str_replace(',',';',com_db_output($download_row['edu_grad_specialization']));
			$edu_grad_college = str_replace(',',';',com_db_output($download_row['edu_grad_college']));
			$edu_grad_year = str_replace(',',';',com_db_output($download_row['edu_grad_year']));
			
			$xls->Text($xlsRow,1,"$personal_id");
			$xls->Text($xlsRow,2,"$first_name");
			$xls->Text($xlsRow,3,"$middle_name");
			$xls->Text($xlsRow,4,"$last_name");
			$xls->Text($xlsRow,5,"$email");
			$xls->Text($xlsRow,6,"$phone");
			$xls->Text($xlsRow,7,"$lin_url");
			$xls->Text($xlsRow,8,"$personal_image");
			$xls->Text($xlsRow,9,"$about_person");
			$xls->Text($xlsRow,10,"$personal");
			$xls->Text($xlsRow,11,"$facebook_link");
			$xls->Text($xlsRow,12,"$linkedin_link");
			$xls->Text($xlsRow,13,"$twitter_link");
			$xls->Text($xlsRow,14,"$googleplush_link");
			$xls->Text($xlsRow,15,"$edu_ugrad_degree");
			$xls->Text($xlsRow,16,"$edu_ugrad_specialization");
			$xls->Text($xlsRow,17,"$edu_ugrad_college");
			$xls->Text($xlsRow,18,"$edu_ugrad_year");
			$xls->Text($xlsRow,19,"$edu_grad_degree");
			$xls->Text($xlsRow,20,"$edu_grad_specialization");
			$xls->Text($xlsRow,21,"$edu_grad_college");
			$xls->Text($xlsRow,22,"$edu_grad_year");
			
			
			$xlsRow++;
			}
		$xls->Output('download-personal-'.$personal_id.'-'. date('m-d-Y') . '.xls');	

}

?>