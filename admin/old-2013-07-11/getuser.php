<?php
require('includes/include_top.php');
$q = $_GET["q"];
$type = $_GET['type'];

if($type=='AddState'){
	echo '<select name="state" id="state" style="width:206px;">';
	echo selectComboBox("select state_id,short_name from ".TABLE_STATE." where country_id="."'".$q."'"." order by short_name","");
	echo '<option value="Any">Any</option>';
	echo '</select>';
}
if($type=='EditState'){
	echo '<select name="state" id="state" style="width:206px;">';
	echo selectComboBox("select state_id,short_name from ".TABLE_STATE." where country_id="."'".$q."'"." order by short_name","");
	echo '<option value="Any">Any</option>';
	echo '</select>';
}
if($type=='AddCompanyInfo'){
	$isPresentUrl = com_db_GetValue("select company_website from ".TABLE_CONTACT." where company_website='".$q."'");
	if($isPresentUrl !=''){
		$company_details_result = com_db_query("select email_pattern,phone,company_name,company_revenue,company_employee,company_industry,ind_group_id,address,address,address2,city,state,country,zip_code,about_company from ".TABLE_CONTACT." where company_website='".$q."'");
		$cd_row = com_db_fetch_array($company_details_result);
		$email_pattern = com_db_output($cd_row['email_pattern']);
		$phone = com_db_output($cd_row['phone']);
		$company_name = com_db_output($cd_row['company_name']);
		$company_revenue = $cd_row['company_revenue'];
		$company_employee = $cd_row['company_employee'];
		$company_industry = $cd_row['company_industry'];
		$ind_group_id = $cd_row['ind_group_id'];
		$address = com_db_output($cd_row['address']);
		$address2 = com_db_output($cd_row['address2']);
		$city =  com_db_output($cd_row['city']);
		$state = $cd_row['state'];
		$country = $cd_row['country'];
		$zip_code = com_db_output($cd_row['zip_code']);
		$about_company = com_db_output($cd_row['about_company']);
		
		$company_revenue = '<select name="company_revenue" id="company_revenue" style="width:206px;">'
								.selectComboBox("select id,name from ".TABLE_REVENUE_SIZE." where status='0' order by from_range",$company_revenue).
								'<option value="Any">Any</option>
							</select>';
		 
		$company_employee = '<select name="company_employee" id="company_employee" style="width:206px;">'
								.selectComboBox("select id,name from ".TABLE_EMPLOYEE_SIZE ." where status='0' order by from_range",$company_employee).
								'<option value="Any">Any</option>
							 </select>';

							$industry_result = com_db_query("select * from " . TABLE_INDUSTRY ." where status='0' and parent_id = '0' order by title");
							
		$company_industry1 ='<select name="company_industry" id="company_industry" >
								<option value="">All</option>';
								while($indus_row = com_db_fetch_array($industry_result)){
									$company_industry1 .='<optgroup label="'.$indus_row['title'].'">'
									.selectComboBox("select industry_id,title from ". TABLE_INDUSTRY ." where status='0' and parent_id ='".$indus_row['industry_id']."' order by title" ,$company_industry);
									$company_industry1 .='</optgroup>';
								 } 
		$company_industry1 .= 	'<option value="Any">Any</option>
							</select>';
						
		$country1 = '<select name="country" id="country" style="width:206px;" onchange="StateChangeAdd('."'country'".');">'
						.selectComboBox("select countries_id,countries_name from ".TABLE_COUNTRIES." where countries_id=223",$country);	
		$country1 .= 	selectComboBox("select countries_id,countries_name from ".TABLE_COUNTRIES." where countries_id<>223 order by countries_name",$country).
						'<option value="Any">Any</option>
					</select>';	
		$state ='<select name="state" id="state" style="width:206px;">'
					.selectComboBox("select state_id,short_name from ".TABLE_STATE." order by short_name",$state).
					'<option value="Any">Any</option>
				 </select>';						
		
		$all_result =  $email_pattern.'###'.$phone.'###'.$company_name.'###'.$company_revenue.'###'.$company_employee.'###'.$company_industry1.'###'.$address.'###'.$address2.'###'.$city.'###'.$country1.'###'.$state.'###'.$zip_code.'###'.$about_company;
		echo $all_result;
	}
}
?> 