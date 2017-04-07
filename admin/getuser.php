<?php
require('includes/include_top_ajax.php');
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

if($type=='CompanyInformationShow'){
	$companyQuery ="select c.*,s.state_name,cnt.countries_name from ".TABLE_COMPANY_MASTER." as c, ".TABLE_STATE." as s,".TABLE_COUNTRIES." as cnt where s.state_id=c.state and cnt.countries_id=c.country and c.company_id='".$q."' and status='0'";
	$companyResult = com_db_query($companyQuery);
	$companyRow = com_db_fetch_array($companyResult);
	
	$companyInfoShow = '<table width="100%" cellpadding="2" cellspacing="2" border="0">
							<tr>
							  <td width="25%" align="left" class="page-text" valign="top">Company Website:</td>
							  <td width="75%" align="left" valign="top">'.com_db_output($companyRow['company_website']).'</td>	
							</tr>
							<tr>
							  <td width="25%" align="left" class="page-text" valign="top">Address:</td>
							  <td width="75%" align="left" valign="top">'.com_db_output($companyRow['address']).'<br>'.com_db_output($companyRow['address2']).'</td>	
							</tr>
							<tr>
							  <td width="25%" align="left" class="page-text" valign="top">City:</td>
							  <td width="75%" align="left" valign="top">'.com_db_output($companyRow['city']).'</td>	
							</tr>
							<tr>
							  <td width="25%" align="left" class="page-text" valign="top">State:</td>
							  <td width="75%" align="left" valign="top">'.com_db_output($companyRow['state_name']).'</td>	
							</tr>
							<tr>
							  <td width="25%" align="left" class="page-text" valign="top">Zip Code:</td>
							  <td width="75%" align="left" valign="top">'.com_db_output($companyRow['zip_code']).'</td>	
							</tr>
							<tr>
							  <td width="25%" align="left" class="page-text" valign="top">Country:</td>
							  <td width="75%" align="left" valign="top">'.com_db_output($companyRow['countries_name']).'</td>	
							</tr>
							
							<tr>
							  <td width="25%" align="left" class="page-text" valign="top">About Company:</td>
							  <td width="75%" align="left" valign="top">'.com_db_output($companyRow['about_company']).'</td>	
							</tr>
						</table>';
	echo $companyInfoShow ;				
}

if($type=='CompanyInformationMovementShow'){ //Company at Movement Master
	$companyQuery ="select c.*,s.state_name,cnt.countries_name from ".TABLE_COMPANY_MASTER." as c, ".TABLE_STATE." as s,".TABLE_COUNTRIES." as cnt where s.state_id=c.state and cnt.countries_id=c.country and c.company_id='".$q."' and status='0'";
	$companyResult = com_db_query($companyQuery);
	$companyRow = com_db_fetch_array($companyResult);
	
	$companyInfoShow = '<table width="100%" cellpadding="2" cellspacing="2" border="0">
							<tr>
							  <td width="25%" align="left" class="page-text" valign="top">Company Website:</td>
							  <td width="75%" align="left" valign="top">'.com_db_output($companyRow['company_website']).'</td>	
							</tr>
							<tr>
							  <td width="25%" align="left" class="page-text" valign="top">Address:</td>
							  <td width="75%" align="left" valign="top">'.com_db_output($companyRow['address']).'<br>'.com_db_output($companyRow['address2']).'</td>	
							</tr>
							<tr>
							  <td width="25%" align="left" class="page-text" valign="top">City:</td>
							  <td width="75%" align="left" valign="top">'.com_db_output($companyRow['city']).'</td>	
							</tr>
							<tr>
							  <td width="25%" align="left" class="page-text" valign="top">State:</td>
							  <td width="75%" align="left" valign="top">'.com_db_output($companyRow['state_name']).'</td>	
							</tr>
							<tr>
							  <td width="25%" align="left" class="page-text" valign="top">Country:</td>
							  <td width="75%" align="left" valign="top">'.com_db_output($companyRow['countries_name']).'</td>	
							</tr>
							<tr>
							  <td width="25%" align="left" class="page-text" valign="top">Zip Code:</td>
							  <td width="75%" align="left" valign="top">'.com_db_output($companyRow['zip_code']).'</td>	
							</tr>
							<tr>
							  <td width="25%" align="left" class="page-text" valign="top">Phone:</td>
							  <td width="75%" align="left" valign="top"><input type="test" name="phone" id="phone" value="'.com_db_output($companyRow['phone']).'"/></td>	
							</tr>
							<tr>
							  <td width="25%" align="left" class="page-text" valign="top">Fax:</td>
							  <td width="75%" align="left" valign="top"><input type="test" name="fax" id="fax" value="'.com_db_output($companyRow['fax']).'"/></td>	
							</tr>
							<tr>
							  <td width="25%" align="left" class="page-text" valign="top">About Company:</td>
							  <td width="75%" align="left" valign="top">'.com_db_output($companyRow['about_company']).'</td>	
							</tr>
							
						</table>';
	echo $companyInfoShow ;				
}

if($type=='PersonalInformationMovementShow'){ //Personal at Movement Master
	$personalQuery ="select * from ".TABLE_PERSONAL_MASTER." where personal_id='".$q."' and status='0'";
	$personalResult = com_db_query($personalQuery);
	$personalRow = com_db_fetch_array($personalResult);
	
	$personalInfoShow = '<table width="100%" cellpadding="2" cellspacing="2" border="0">
							<tr>
							  <td width="25%" align="left" class="page-text" valign="top">Person Name:</td>
							  <td width="75%" align="left" valign="top">'.com_db_output($personalRow['first_name'].' '.$personalRow['last_name']).'</td>	
							</tr>
							<tr>
							  <td width="25%" align="left" class="page-text" valign="top">E-Mail:</td>
							  <td width="75%" align="left" valign="top">'.com_db_output($personalRow['email']).'</td>	
							</tr>
							<tr>
							  <td width="25%" align="left" class="page-text" valign="top">Phone:</td>
							  <td width="75%" align="left" valign="top">'.com_db_output($personalRow['phone']).'</td>	
							</tr>
							<tr>
							  <td width="25%" align="left" class="page-text" valign="top">Education (Undergrad):</td>
							  <td width="75%" align="left" valign="top">'.com_db_output($personalRow['edu_ugrad_degree'].' in '.$personalRow['edu_ugrad_specialization'].' from '.$personalRow['edu_ugrad_college'].' in '.$personalRow['edu_ugrad_year']).'</td> 	
							</tr>
							<tr>
							  <td width="25%" align="left" class="page-text" valign="top">Education (Grad):</td>
							  <td width="75%" align="left" valign="top">'.com_db_output($personalRow['edu_grad_degree'].' in '.$personalRow['edu_grad_specialization'].' from '.$personalRow['edu_grad_college'].' in '.$personalRow['edu_grad_year']).'</td>
							</tr>
							<tr>
							  <td width="25%" align="left" class="page-text" valign="top">About Person:</td>
							  <td width="75%" align="left" valign="top">'.com_db_output($personalRow['about_person']).'</td>	
							</tr>
						</table>';
	echo $personalInfoShow ;				
}
?> 