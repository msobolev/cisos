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
if($type=='CompanyInformationMovementShowEdit'){
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
	$companyQuery ="select * from ".TABLE_COMPANY_MASTER." where company_id='".$q."'";
	$companyResult = com_db_query($companyQuery);
	if($companyResult){
	$numRow = com_db_num_rows($companyResult);
	}
	if($numRow >0){
		$companyRow = com_db_fetch_array($companyResult);
		$company_website = com_db_output($companyRow['company_website']);
		$company_name = com_db_output($companyRow['company_name']);
		$company_logo = com_db_output($companyRow['company_logo']);	
		//$company_revenue = com_db_output($companyRow['company_revenue']);
		//$company_employee = com_db_output($companyRow['company_employee']);
		//$company_industry = com_db_output($companyRow['company_industry']);
		
		$company_revenue = com_db_output(com_db_GetValue("select name from ".TABLE_REVENUE_SIZE." where id='".$companyRow['company_revenue']."'"));
		$company_employee = com_db_output(com_db_GetValue("select name from ".TABLE_EMPLOYEE_SIZE." where id='".$companyRow['company_employee']."'"));
		$company_industry = com_db_output(com_db_GetValue("select title from ".TABLE_INDUSTRY." where industry_id='".$companyRow['company_industry']."'"));
		
		
		
		$ind_group_id = com_db_output($companyRow['ind_group_id']);
		$leadership_page = com_db_output($companyRow['leadership_page']);
		$email_pattern = com_db_output($companyRow['email_pattern']);
		$address = com_db_output($companyRow['address']);
		$address2 = com_db_output($companyRow['address2']);
		$city = com_db_output($companyRow['city']);
		//$state = com_db_output($companyRow['state']);
		$state = com_db_output(com_db_GetValue("select state_name from ".TABLE_STATE." where state_id='".$companyRow['state']."'"));
		//$country = com_db_output($companyRow['country']);
		$country = com_db_output(com_db_GetValue("select countries_name from ".TABLE_COUNTRIES." where countries_id='".$companyRow['country']."'"));
		$zip_code = com_db_output($companyRow['zip_code']);
		$phone = com_db_output($companyRow['phone']);
		$fax = com_db_output($companyRow['fax']);
		$about_company = com_db_output($companyRow['about_company']);
		$facebook_link = com_db_output($companyRow['facebook_link']); 
		$linkedin_link = com_db_output($companyRow['linkedin_link']);
		$twitter_link = com_db_output($companyRow['twitter_link']);
		$googleplush_link = com_db_output($companyRow['googleplush_link']);
		
		$email_domain = com_db_output($companyRow['email_domain']);
		//$email_pattern_id = com_db_output($companyRow['email_pattern_id']);
		//echo "select email_pattern from ".TABLE_EMAIL_PATTERNS." where pattern_id='".$companyRow['email_pattern_id']."'";
		$email_pattern = com_db_output(com_db_GetValue("select email_pattern from ".TABLE_EMAIL_PATTERNS." where pattern_id='".$companyRow['email_pattern_id']."'"));
		$email_pattern_id = $companyRow['email_pattern_id'];
		
		$mail_server_settings_db = com_db_output($companyRow['mail_server_settings']);
		
		
			if($company_logo !=''){
				//$company_logo = '<img src="../company_logo/small/'.$company_logo.'"><br><input type="file" name="company_logo" id="company_logo" />';
				$company_logo = '<img src="../company_logo/small/'.$company_logo.'">';
			}
			//else{
			//	$company_logo = '<input type="file" name="company_logo" id="company_logo" />';
			//}
			
			
			//$company_revenue = com_db_output(com_db_GetValue("select name from ".TABLE_REVENUE_SIZE." where id='".$companyRow['company_revenue']."'"));
			/*
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
			 		

			if($email_pattern_id == '')		
			{
				$email_pattern_select ='<select name="company_email_pattern" id="company_email_pattern" style="width:206px;" disabled>'
						.selectComboBox("select pattern_id,email_pattern from  ".TABLE_EMAIL_PATTERNS,$email_pattern_id).
						'<option selected value="none">None</option>
						</select>';	
			}	
			else	
			{
				
				$email_pattern_select ='<select name="company_email_pattern" id="company_email_pattern" style="width:206px;" disabled>'
						.selectComboBox("select pattern_id,email_pattern from  ".TABLE_EMAIL_PATTERNS,$email_pattern_id).
						'<option value="none">None</option>
						</select>';		 
			}
			*/
			
			
			$company_email_domain = $email_domain;
			$company_email_pattern = $email_pattern; //$email_pattern_select;
			
			//$mail_server_settings = mail_server_settings_ComboBox($mail_server_settings_db,'',"disabled"); 
			$mail_server_settings = $mail_server_settings_db;
			
			//$all_result = $company_website."###".$company_name.'###'.$company_logo.'###'.$company_revenue.'###'.$company_employee.'###'.$company_industry1.'###'.$leadership_page.'###'.$email_pattern.'###'.$address.'###'.$address2.'###'.$city.'###'.$country1.'###'.$state.'###'.$zip_code.'###'.$phone.'###'.$fax.'###'.$about_company.'###'.$facebook_link.'###'.$linkedin_link.'###'.$twitter_link.'###'.$googleplush_link;
			//$all_result = $company_website."###".$company_name.'###'.$company_logo.'###'.$company_revenue.'###'.$company_employee.'###'.$company_industry1.'###'.$leadership_page.'###'.$email_pattern.'###'.$address.'###'.$address2.'###'.$city.'###'.$country1.'###'.$state.'###'.$zip_code.'###'.$phone.'###'.$fax.'###'.$about_company.'###'.$facebook_link.'###'.$linkedin_link.'###'.$twitter_link.'###'.$googleplush_link.'###'.$company_email_domain.'###'.$company_email_pattern.'###'.$mail_server_settings;
			$all_result = $company_website."###".$company_name.'###'.$company_logo.'###'.$company_revenue.'###'.$company_employee.'###'.$company_industry.'###'.$leadership_page.'###'.$email_pattern.'###'.$address.'###'.$address2.'###'.$city.'###'.$country.'###'.$state.'###'.$zip_code.'###'.$phone.'###'.$fax.'###'.$about_company.'###'.$facebook_link.'###'.$linkedin_link.'###'.$twitter_link.'###'.$googleplush_link.'###'.$company_email_domain.'###'.$company_email_pattern.'###'.$mail_server_settings.'###'.$email_pattern_id;
			
	}else{
		
			$company_logo = '<input type="file" name="company_logo" id="company_logo" />';
			
			$company_revenue = '<select name="company_revenue" id="company_revenue" style="width:206px;">'
									.selectComboBox("select id,name from ".TABLE_REVENUE_SIZE." where status='0' order by from_range",'').
									'<option value="Any">Any</option>
								</select>';
			 
			$company_employee = '<select name="company_employee" id="company_employee" style="width:206px;">'
									.selectComboBox("select id,name from ".TABLE_EMPLOYEE_SIZE ." where status='0' order by from_range",'').
									'<option value="Any">Any</option>
								 </select>';
	
							$industry_result = com_db_query("select * from " . TABLE_INDUSTRY ." where status='0' and parent_id = '0' order by title");
								
			$company_industry1 ='<select name="company_industry" id="company_industry" >
									<option value="">All</option>';
									while($indus_row = com_db_fetch_array($industry_result)){
										$company_industry1 .='<optgroup label="'.$indus_row['title'].'">'
										.selectComboBox("select industry_id,title from ". TABLE_INDUSTRY ." where status='0' and parent_id ='".$indus_row['industry_id']."' order by title" ,'');
										$company_industry1 .='</optgroup>';
									 } 
			$company_industry1 .= 	'<option value="Any">Any</option>
								</select>';
							
			$country1 = '<select name="country" id="country" style="width:206px;" onchange="StateChangeAdd('."'country'".');">'
							.selectComboBox("select countries_id,countries_name from ".TABLE_COUNTRIES." where countries_id=223",'223');	
			$country1 .= 	selectComboBox("select countries_id,countries_name from ".TABLE_COUNTRIES." where countries_id<>223 order by countries_name",'').
							'<option value="Any">Any</option>
						</select>';	
			$state ='<select name="state" id="state" style="width:206px;">'
						.selectComboBox("select state_id,short_name from ".TABLE_STATE." order by short_name",'').
						'<option value="Any">Any</option>
					 </select>';						
			
			$all_result =  $company_logo.'###'.$company_revenue.'###'.$company_employee.'###'.$company_industry1.'###'.$country1.'###'.$state;
	}
	echo $all_result;
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
if($type=='PersonalCompanyNameShow'){ //Personal & Company name List show
	$personType = $_REQUEST['person_type'];
	$fn=explode(" ",$q);
	
	$fname = $fn[0];
	$mname = $fn[1];
	$lname = $fn[2];
	$pcInfoShow='';
	if($personType == 'New'){
		if(sizeof($fn)==1){
			$pcQuery ="select personal_id,first_name,middle_name,last_name,email,phone from ".TABLE_PERSONAL_MASTER." where first_name like '".$fname."%'";
		}elseif(sizeof($fn)==2){
			$pcQuery ="select personal_id,first_name,middle_name,last_name,email,phone from ".TABLE_PERSONAL_MASTER." where first_name = '".$fname."' and (middle_name like '".$mname."%' or last_name like '".$mname."%')";
		}else{
			$pcQuery ="select personal_id,first_name,middle_name,last_name,email,phone from ".TABLE_PERSONAL_MASTER." where first_name = '".$fname."' and middle_name ='".$mname."' and last_name like '".$lname."%'";
		}
		
		$pcResult = com_db_query($pcQuery);
		if($pcResult){
			$numRow = com_db_num_rows($pcResult);
		}
		if($numRow>0){
			$pcInfoShow='<div class="PersonalCompanyListShow">
							<ul>';
			while($pcRow = com_db_fetch_array($pcResult)){
				$pcInfoShow  .='<li class="nameList"><a href="javascript:;" onclick="PersonalID('."'".$pcRow['personal_id']."','".com_db_output($pcRow['first_name'].' '.$pcRow['middle_name'].' '.$pcRow['last_name']) ."','".$pcRow['email']."','".$pcRow['phone']."'".');">'.com_db_output($pcRow['first_name'].' '.$pcRow['middle_name'].' '.$pcRow['last_name']).'</a></li>';
			}
			$pcInfoShow .= '</ul>
						</div>';			
		}
	}else{
		if(sizeof($fn)==1){
			$pcQuery ="select pm.personal_id,cm.company_id,pm.first_name,pm.middle_name,pm.last_name,cm.company_name from ".TABLE_MOVEMENT_MASTER." mm,".TABLE_COMPANY_MASTER." cm,". TABLE_PERSONAL_MASTER." pm where (mm.personal_id=pm.personal_id and mm.company_id=cm.company_id) and pm.first_name like '".$fname."%'";
		}elseif(sizeof($fn)==2){
			$pcQuery ="select pm.personal_id,cm.company_id,pm.first_name,pm.middle_name,pm.last_name,cm.company_name from ".TABLE_MOVEMENT_MASTER." mm,".TABLE_COMPANY_MASTER." cm,". TABLE_PERSONAL_MASTER." pm where (mm.personal_id=pm.personal_id and mm.company_id=cm.company_id) and pm.first_name = '".$fname."' and (pm.middle_name like '".$mname."%' or pm.last_name like '".$mname."%')";
		}else{
			$pcQuery ="select pm.personal_id,cm.company_id,pm.first_name,pm.middle_name,pm.last_name,cm.company_name from ".TABLE_MOVEMENT_MASTER." mm,".TABLE_COMPANY_MASTER." cm,". TABLE_PERSONAL_MASTER." pm where (mm.personal_id=pm.personal_id and mm.company_id=cm.company_id) and pm.first_name = '".$fname."' and pm.middle_name ='".$mname."' and pm.last_name like '".$lname."%'";
		}
		$pcResult = com_db_query($pcQuery);
		if($pcResult){
			$numRow = com_db_num_rows($pcResult);
		}
		if($numRow>0){
			$pcInfoShow='<div class="PersonalCompanyListShow">
							<ul>';
			while($pcRow = com_db_fetch_array($pcResult)){
				$pcInfoShow  .='<li class="nameList"><a href="javascript:;" onclick="PersonalID('."'".$pcRow['personal_id']."','".com_db_output($pcRow['first_name'].' '.$pcRow['middle_name'].' '.$pcRow['last_name'])."')".';">'.com_db_output($pcRow['first_name'].' '.$pcRow['middle_name'].' '.$pcRow['last_name'].' '.$pcRow['company_name']).'</a></li>';
			}
			$pcInfoShow .='</ul>
						</div>';
		}
	}
	echo $pcInfoShow;
}

if($type=='CompanyNameShow'){ //Company name List show
	$url=$q;
	if($url !=''){
		$companyQuery ="select company_id,company_name,company_website from ".TABLE_COMPANY_MASTER." where company_website REGEXP('".$url."')";
	}else{
		$companyQuery ="select company_id,company_name,company_website from ".TABLE_COMPANY_MASTER." where company_website !='' order by company_name";
	}
	$companyResult = com_db_query($companyQuery);
	if($companyResult){
		$num_row = com_db_num_rows($companyResult);
	}
	$companyInfoShow='';
	if($num_row>0){
		$companyInfoShow = '<table width="100%" cellpadding="2" cellspacing="2" border="0">';
		while($cRow = com_db_fetch_array($companyResult)){
			$companyInfoShow  .='<tr>
								  <td align="left" class="nameList" valign="top"><a href="javascript:;" onclick="CompanyID('."'".$cRow['company_id']."','".$cRow['company_website']."'".');">'.com_db_output($cRow['company_website']).'</a></td>	
								</tr>';	
		}
		$companyInfoShow .='</table>';
	}
	echo $companyInfoShow;
}
if($type=='CompanyNameShowMovement'){ //Company name List show in Movement
	$url=$q;
	if($url !=''){
		//$companyQuery ="select company_id,company_name,company_website from ".TABLE_COMPANY_MASTER." where company_website REGEXP('".$url."')";
		$companyQuery ="select company_id,company_name,company_website from ".TABLE_COMPANY_MASTER." where company_website like '%".$url."%'";
	}else{
		$companyQuery ="select company_id,company_name,company_website from ".TABLE_COMPANY_MASTER." where company_website !='' order by company_name";
	}
	$companyResult = com_db_query($companyQuery);
	if($companyResult){
		$num_row = com_db_num_rows($companyResult);
	}
	$companyInfoShow='';
	if($num_row>0){
		$companyInfoShow = '<div class="PersonalCompanyListShow">
								<table width="100%" cellpadding="2" cellspacing="2" border="0">';
		while($cRow = com_db_fetch_array($companyResult)){
			$companyInfoShow  .='<tr>
								  <td align="left" class="nameList" valign="top"><a href="javascript:;" onclick="CompanyInformationMovement('."'".$cRow['company_id']."'".');">'.com_db_output($cRow['company_website']).'</a></td>	
								</tr>';	
		}
		$companyInfoShow .='</table>
						   </div>';
	}
	echo $companyInfoShow;
}
if($type=='PersonalCompanyNameShowMovement'){ //Personal & Company name List show in movement page
	$personType = $_REQUEST['person_type'];
	$fn=explode(" ",$q);
	$fname = $fn[0];
	$mname = $fn[1];
	$lname = $fn[2];
	$pcInfoShow='';
	if($personType == 'New'){
		if(sizeof($fn)==1){
			$pcQuery ="select personal_id,first_name,middle_name,last_name,email,phone from ".TABLE_PERSONAL_MASTER." where first_name like '".$fname."%'";
		}elseif(sizeof($fn)==2){
			$pcQuery ="select personal_id,first_name,middle_name,last_name,email,phone from ".TABLE_PERSONAL_MASTER." where first_name = '".$fname."' and (middle_name like '".$mname."%' or last_name like '".$mname."%')";
		}else{
			$pcQuery ="select personal_id,first_name,middle_name,last_name,email,phone from ".TABLE_PERSONAL_MASTER." where first_name = '".$fname."' and middle_name ='".$mname."' and last_name like '".$lname."%'";
		}
		
		$pcResult = com_db_query($pcQuery);
		if($pcResult){
			$numRow = com_db_num_rows($pcResult);
		}
		if($numRow>0){
			$pcInfoShow='<div class="PersonalCompanyListShow">
							<ul>';
			while($pcRow = com_db_fetch_array($pcResult)){
				$pcInfoShow  .='<li class="nameList"><a href="javascript:;" onclick="OnlyPersonalInformation('."'".$pcRow['personal_id']."'".');">'.com_db_output($pcRow['first_name'].' '.$pcRow['middle_name'].' '.$pcRow['last_name']).'</a></li>';
			}
			$pcInfoShow .= '</ul>
						</div>';			
		}
	}else{
		if(sizeof($fn)==1){
			$pcQuery ="select pm.personal_id,cm.company_id,pm.first_name,pm.middle_name,pm.last_name,cm.company_name from ".TABLE_MOVEMENT_MASTER." mm,".TABLE_COMPANY_MASTER." cm,". TABLE_PERSONAL_MASTER." pm where (mm.personal_id=pm.personal_id and mm.company_id=cm.company_id) and pm.first_name like '".$fname."%'";
		}elseif(sizeof($fn)==2){
			$pcQuery ="select pm.personal_id,cm.company_id,pm.first_name,pm.middle_name,pm.last_name,cm.company_name from ".TABLE_MOVEMENT_MASTER." mm,".TABLE_COMPANY_MASTER." cm,". TABLE_PERSONAL_MASTER." pm where (mm.personal_id=pm.personal_id and mm.company_id=cm.company_id) and pm.first_name = '".$fname."' and (pm.middle_name like '".$mname."%' or pm.last_name like '".$mname."%')";
		}else{
			$pcQuery ="select pm.personal_id,cm.company_id,pm.first_name,pm.middle_name,pm.last_name,cm.company_name from ".TABLE_MOVEMENT_MASTER." mm,".TABLE_COMPANY_MASTER." cm,". TABLE_PERSONAL_MASTER." pm where (mm.personal_id=pm.personal_id and mm.company_id=cm.company_id) and pm.first_name = '".$fname."' and pm.middle_name ='".$mname."' and pm.last_name like '".$lname."%'";
		}
		$pcResult = com_db_query($pcQuery);
		if($pcResult){
			$numRow = com_db_num_rows($pcResult);
		}
		if($numRow>0){
			$pcInfoShow='<div class="PersonalCompanyListShow">
							<ul>';
			while($pcRow = com_db_fetch_array($pcResult)){
				$pcInfoShow  .='<li class="nameList"><a href="javascript:;" onclick="PersonalCompanyInformation('."'".$pcRow['personal_id']."','".$pcRow['company_id']."'".');">'.com_db_output($pcRow['first_name'].' '.$pcRow['middle_name'].' '.$pcRow['last_name'].' '.$pcRow['company_name']).'</a></li>';
			}
			$pcInfoShow .='</ul>
						</div>';
		}
	}
	if($numRow>0){
		echo $numRow.'###'.$pcInfoShow;
	}
}

if($type=='PersonalCompanyDetailsShow'){ //Personal & Company details Movement page
	$person_id = $_REQUEST['pid'];
	$company_id = $_REQUEST['cid'];
	
	$personQuery ="select personal_id,first_name,middle_name,last_name,email,phone,personal_image,facebook_link,linkedin_link,twitter_link,googleplush_link,about_person from ".TABLE_PERSONAL_MASTER." where personal_id='".$person_id."'";
	$personResult = com_db_query($personQuery);
	if($personResult){
		$personNumRow = com_db_num_rows($personResult);
	}
	if($personNumRow>0){
		$personRow = com_db_fetch_array($personResult);
		
		$first_name = com_db_output($personRow['first_name']);
		$middle_name = com_db_output($personRow['middle_name']);
		$last_name= com_db_output($personRow['last_name']);
		$person_email = com_db_output($personRow['email']);
		$person_phone = com_db_output($personRow['phone']);
		$person_photo = com_db_output($personRow['personal_image']);
		$person_facebook_link = com_db_output($personRow['facebook_link']);
		$person_linkedin_link = com_db_output($personRow['linkedin_link']);
		$person_twitter_link = com_db_output($personRow['twitter_link']);
		$person_googleplush_link = com_db_output($personRow['googleplush_link']);
		if($person_photo !=''){
			$person_photo = '<img src="../personal_photo/small/'.$person_photo.'"><br><input type="file" name="person_photo" id="person_photo" />';
		}else{
			$person_photo = '<input type="file" name="person_photo" id="person_photo" />';
		}
		$about_person = com_db_output($personRow['about_person']);
	}
	$companyQuery = "select * from ".TABLE_COMPANY_MASTER." where company_id='".$company_id."'";
	$companyResult = com_db_query($companyQuery);
	if($companyResult){
	$numRow = com_db_num_rows($companyResult);
	}
	if($numRow >0 && $personNumRow>0){
		$companyRow = com_db_fetch_array($companyResult);
		$company_website = com_db_output($companyRow['company_website']);
		$company_name = com_db_output($companyRow['company_name']);
		$company_logo = com_db_output($companyRow['company_logo']);	
		$company_revenue = com_db_output($companyRow['company_revenue']);
		$company_employee = com_db_output($companyRow['company_employee']);
		$company_industry = com_db_output($companyRow['company_industry']);
		$ind_group_id = com_db_output($companyRow['ind_group_id']);
		$leadership_page = com_db_output($companyRow['leadership_page']);
		$email_pattern = com_db_output($companyRow['email_pattern']);
		$address = com_db_output($companyRow['address']);
		$address2 = com_db_output($companyRow['address2']);
		$city = com_db_output($companyRow['city']);
		$state = com_db_output($companyRow['state']);
		$country = com_db_output($companyRow['country']);
		$zip_code = com_db_output($companyRow['zip_code']);
		$phone = com_db_output($companyRow['phone']);
		$fax = com_db_output($companyRow['fax']);
		$about_company = com_db_output($companyRow['about_company']);
		$facebook_link = com_db_output($companyRow['facebook_link']); 
		$linkedin_link = com_db_output($companyRow['linkedin_link']);
		$twitter_link = com_db_output($companyRow['twitter_link']);
		$googleplush_link = com_db_output($companyRow['googleplush_link']);
			if($company_logo !=''){
				$company_logo = '<img src="../company_logo/small/'.$company_logo.'"><br><input type="file" name="company_logo" id="company_logo" />';
			}else{
				$company_logo = '<input type="file" name="company_logo" id="company_logo" />';
			}
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
			
			$all_result =  $first_name.'###'.$middle_name.'###'.$last_name.'###'.$person_email.'###'.$person_phone.'###'.$person_photo.'###'.$about_person.'###'.$company_website.'###'.$company_name.'###'.$company_logo.'###'.$company_revenue.'###'.$company_employee.'###'.$company_industry1.'###'.$leadership_page.'###'.$email_pattern.'###'.$address.'###'.$address2.'###'.$city.'###'.$country1.'###'.$state.'###'.$zip_code.'###'.$phone.'###'.$fax.'###'.$about_company.'###'.$facebook_link.'###'.$linkedin_link.'###'.$twitter_link.'###'.$googleplush_link.'###'.$person_facebook_link.'###'.$person_linkedin_link.'###'.$person_twitter_link.'###'.$person_googleplush_link;
			
	}else{
		
			$personal_photo ='<input type="file" name="person_photo" id="person_photo" />';
			
			$company_logo = '<input type="file" name="company_logo" id="company_logo" />';
			
			$company_revenue = '<select name="company_revenue" id="company_revenue" style="width:206px;">'
									.selectComboBox("select id,name from ".TABLE_REVENUE_SIZE." where status='0' order by from_range",'').
									'<option value="Any">Any</option>
								</select>';
			 
			$company_employee = '<select name="company_employee" id="company_employee" style="width:206px;">'
									.selectComboBox("select id,name from ".TABLE_EMPLOYEE_SIZE ." where status='0' order by from_range",'').
									'<option value="Any">Any</option>
								 </select>';
	
							$industry_result = com_db_query("select * from " . TABLE_INDUSTRY ." where status='0' and parent_id = '0' order by title");
								
			$company_industry1 ='<select name="company_industry" id="company_industry" >
									<option value="">All</option>';
									while($indus_row = com_db_fetch_array($industry_result)){
										$company_industry1 .='<optgroup label="'.$indus_row['title'].'">'
										.selectComboBox("select industry_id,title from ". TABLE_INDUSTRY ." where status='0' and parent_id ='".$indus_row['industry_id']."' order by title" ,'');
										$company_industry1 .='</optgroup>';
									 } 
			$company_industry1 .= 	'<option value="Any">Any</option>
								</select>';
							
			$country1 = '<select name="country" id="country" style="width:206px;" onchange="StateChangeAdd('."'country'".');">'
							.selectComboBox("select countries_id,countries_name from ".TABLE_COUNTRIES." where countries_id=223",'223');	
			$country1 .= 	selectComboBox("select countries_id,countries_name from ".TABLE_COUNTRIES." where countries_id<>223 order by countries_name",'').
							'<option value="Any">Any</option>
						</select>';	
			$state ='<select name="state" id="state" style="width:206px;">'
						.selectComboBox("select state_id,short_name from ".TABLE_STATE." order by short_name",'').
						'<option value="Any">Any</option>
					 </select>';						
			
			$all_result = $personal_photo .'###'. $company_logo.'###'.$company_revenue.'###'.$company_employee.'###'.$company_industry1.'###'.$country1.'###'.$state;
	}
	echo $all_result;
}
if($type=='PersonNameWithCompany'){
	$first_name = $_REQUEST['fname'];
	$middle_name = $_REQUEST['mname'];
	$last_name = $_REQUEST['lname'];
	$pcQuery = "select pm.first_name,pm.middle_name,pm.last_name,cm.company_name from ".TABLE_MOVEMENT_MASTER." mm, ".TABLE_PERSONAL_MASTER." pm, ".TABLE_COMPANY_MASTER." cm where (mm.company_id=cm.company_id and mm.personal_id=pm.personal_id) and pm.first_name='".$first_name."' and middle_name='".$middle_name."' and last_name='".$last_name."'";
	$pcResult = com_db_query($pcQuery);
	$pcRow = com_db_fetch_array($pcResult);
	if($pcRow['first_name'] !='' && $pcRow['last_name'] !='' && $pcRow['company_name'] !=''){
		echo '<span style="color:red;">"'.com_db_output($pcRow['first_name'].' '.$pcRow['middle_name'].' '.$pcRow['last_name'].' from '.$pcRow['company_name']).'? Already exists in the database"</span>';
	}
}
if($type=='CompanyAlreadyPresent'){
	$company_website = $_REQUEST['cwebsite'];
	
	$cQuery = "select company_id from ".TABLE_COMPANY_MASTER." where company_website like '%".$company_website."'";
	
	$cResult = com_db_query($cQuery);
	$cRow = com_db_fetch_array($cResult);
	if($cRow['company_id'] !=''){
		echo '<span style="color:red;">Company already present</span>';
	}
        else
        {
            $sQuery = "select company_id from ".TABLE_COMPANY_WEBSITES." where company_website like '%".$company_website."'";

            $sResult = com_db_query($sQuery);
            $sRow = com_db_fetch_array($sResult);
            if($sRow['company_id'] !=''){
                    echo '<span style="color:red;">Company already present</span>';
            } 
            
            
        }    
}
if($type=='OnlyPersonalInfoShow'){
	$personal_id = $_REQUEST['personal_id'];
	
	$pQuery = "select personal_id,first_name,middle_name,last_name,email,phone,personal_image,facebook_link,linkedin_link,twitter_link,googleplush_link,about_person from ".TABLE_PERSONAL_MASTER." where personal_id ='".$personal_id."'";
	
	$pResult = com_db_query($pQuery);
	$pRow = com_db_fetch_array($pResult);
	$first_name = com_db_output($pRow['first_name']);
	$middle_name = com_db_output($pRow['middle_name']);
	$last_name = com_db_output($pRow['last_name']);
	$personal_email = com_db_output($pRow['email']);
	$personal_phone = com_db_output($pRow['phone']);
	$personal_photo = com_db_output($pRow['personal_image']);
	$facebook_link = com_db_output($pRow['facebook_link']);
	$linkedin_link = com_db_output($pRow['linkedin_link']);
	$twitter_link = com_db_output($pRow['twitter_link']);
	$googleplush_link = com_db_output($pRow['googleplush_link']);
		 	
	if($personal_photo !=''){
		$personal_photo = '<img src="../personal_photo/small/'.$personal_photo.'"><br><input type="file" name="person_photo" id="person_photo" />';
	}else{
		$personal_photo = '<input type="file" name="person_photo" id="person_photo" />';
	}
	$about_person = com_db_output($pRow['about_person']);
	
	echo $all_result =$first_name .'###'.$middle_name .'###'. $last_name .'###'.$personal_email .'###'. $personal_phone.'###'.$personal_photo.'###'.$about_person.'###'.$facebook_link.'###'.$linkedin_link.'###'.$twitter_link.'###'.$googleplush_link;
}

if($type=='PersonalCompanyNameShowMovementInFisrtName'){ //Personal & Company name List show in movement page at first name
	$personType = $_REQUEST['person_type'];
	$first_name = $_REQUEST['first_name'];
	$last_name = $_REQUEST['last_name'];
	$pcInfoShow='';
	if($personType == 'New'){
		if($first_name !='' && $last_name ==''){
			$pcQuery ="select personal_id,first_name,middle_name,last_name from ".TABLE_PERSONAL_MASTER." where first_name like '".$first_name."%'";
		}elseif($first_name =='' && $last_name !=''){
			$pcQuery ="select personal_id,first_name,middle_name,last_name from ".TABLE_PERSONAL_MASTER." where last_name like '".$last_name."%')";
		}elseif($first_name !='' && $last_name !=''){
			$pcQuery ="select personal_id,first_name,middle_name,last_name from ".TABLE_PERSONAL_MASTER." where first_name = '".$first_name."' and last_name like '".$last_name."%'";
		}
		
		$pcResult = com_db_query($pcQuery);
		if($pcResult){
			$numRow = com_db_num_rows($pcResult);
		}
		if($numRow>0){
			$pcInfoShow='<div style=" float: right;margin-right: 350px;margin-top: -30px;"><a href="javascript:;" onclick="personListBoxClose();"><img src="../images/close-buttn1.png" alt=""></a></div>
						 <div class="PersonalCompanyListShow">
							
							<ul>';
			while($pcRow = com_db_fetch_array($pcResult)){
				$pcInfoShow  .='<li class="nameList"><a href="javascript:;" onclick="OnlyPersonalInformation('."'".$pcRow['personal_id']."'".');">'.com_db_output($pcRow['first_name'].' '.$pcRow['middle_name'].' '.$pcRow['last_name']).'</a></li>';
			}
			$pcInfoShow .= '</ul>
						</div>';			
		}
	}else{
		if($first_name !='' && $last_name ==''){
			$pcQuery ="select pm.personal_id,cm.company_id,pm.first_name,pm.middle_name,pm.last_name,cm.company_name from ".TABLE_MOVEMENT_MASTER." mm,".TABLE_COMPANY_MASTER." cm,". TABLE_PERSONAL_MASTER." pm where (mm.personal_id=pm.personal_id and mm.company_id=cm.company_id) and pm.first_name like '".$first_name."%'";
		}elseif($first_name =='' && $last_name !=''){
			$pcQuery ="select pm.personal_id,cm.company_id,pm.first_name,pm.middle_name,pm.last_name,cm.company_name from ".TABLE_MOVEMENT_MASTER." mm,".TABLE_COMPANY_MASTER." cm,". TABLE_PERSONAL_MASTER." pm where (mm.personal_id=pm.personal_id and mm.company_id=cm.company_id) and pm.last_name like '".$last_name."%'";
		}elseif($first_name !='' && $last_name !=''){
			$pcQuery ="select pm.personal_id,cm.company_id,pm.first_name,pm.middle_name,pm.last_name,cm.company_name from ".TABLE_MOVEMENT_MASTER." mm,".TABLE_COMPANY_MASTER." cm,". TABLE_PERSONAL_MASTER." pm where (mm.personal_id=pm.personal_id and mm.company_id=cm.company_id) and pm.first_name = '".$first_name."' and pm.last_name like '".$last_name."%'";
		}
		$pcResult = com_db_query($pcQuery);
		if($pcResult){
			$numRow = com_db_num_rows($pcResult);
		}
		if($numRow>0){
			$pcInfoShow='<div style=" float: right;margin-right: 350px;margin-top: -30px;"><a href="javascript:;" onclick="personListBoxClose();"><img src="../images/close-buttn1.png" alt=""></a></div>
  						 <div class="PersonalCompanyListShow">
							<ul>';
			while($pcRow = com_db_fetch_array($pcResult)){
				$pcInfoShow  .='<li class="nameList"><a href="javascript:;" onclick="PersonalCompanyInformation('."'".$pcRow['personal_id']."','".$pcRow['company_id']."'".');">'.com_db_output($pcRow['first_name'].' '.$pcRow['middle_name'].' '.$pcRow['last_name'].' '.$pcRow['company_name']).'</a></li>';
			}
			$pcInfoShow .='</ul>
						</div>';
		}
	}
	if($numRow>0){
		echo $numRow.'###'.$pcInfoShow;
	}
}

if($type=='MovementUrlCreateShow'){
	$first_name = trim(com_db_input($_REQUEST['first_name']));
	$last_name = trim(com_db_input($_REQUEST['last_name']));
	$company_name = trim(com_db_input($_REQUEST['company_name']));
	$company_name = str_replace(' ','-',$company_name);
	$movement_type = trim(com_db_input($_REQUEST['movement_type']));
	$title = trim(com_db_input($_REQUEST['title']));
	$mmc = com_db_GetValue("select name from ". TABLE_MANAGEMENT_CHANGE. " where id='".$movement_type."'");
	$mmc1 = strtoupper($mmc);
	if($mmc1 == 'APPOINTMENT' || $mmc1 == 'LATERAL MOVE'){
		$url_mmc='Appointed';
	}elseif($mmc1 =='PROMOTION'){
		$url_mmc='Promoted';
	}elseif($mmc1 =='RETIREMENT'){
		$url_mmc='Retired';
	}elseif($mmc1 =='RESIGNATION'){
		$url_mmc='Resigned';
	}elseif($mmc1 =='TERMINATION'){
		$url_mmc='Terminated';
	}else{
		$url_mmc='Job-Opening';
	}		
	$url_mmc = trim($url_mmc);
	$ntt = $title;
	$ntt = str_replace(' ','-', $ntt);
	
	$movement_url_create = trim($first_name).'-'.trim($last_name).'-'.trim($company_name).'-'.trim($ntt).'-'.trim($url_mmc);
	
	$movement_url = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '-', ''), $movement_url_create);
	
	echo trim($movement_url);
}

if($type=='DublicateMovementUrlShow'){
	$first_name = trim(com_db_input($_REQUEST['first_name']));
	$last_name = trim(com_db_input($_REQUEST['last_name']));
	$company_name = trim(com_db_input($_REQUEST['company_name']));
	$company_name = str_replace(' ','-',$company_name);
	$movement_type = trim(com_db_input($_REQUEST['movement_type']));
	$title = trim(com_db_input($_REQUEST['title']));
	$mmc = com_db_GetValue("select name from ". TABLE_MANAGEMENT_CHANGE. " where id='".$movement_type."'");
	$mmc1 = strtoupper($mmc);
	if($mmc1 == 'APPOINTMENT' || $mmc1 == 'LATERAL MOVE'){
		$url_mmc='Appointed';
	}elseif($mmc1 =='PROMOTION'){
		$url_mmc='Promoted';
	}elseif($mmc1 =='RETIREMENT'){
		$url_mmc='Retired';
	}elseif($mmc1 =='RESIGNATION'){
		$url_mmc='Resigned';
	}elseif($mmc1 =='TERMINATION'){
		$url_mmc='Terminated';
	}else{
		$url_mmc='Job-Opening';
	}		
	$url_mmc = trim($url_mmc);
	$ntt = $title;
	$ntt = str_replace(' ','-', $ntt);
	
	$movement_url_create = trim($first_name).'-'.trim($last_name).'-'.trim($company_name).'-'.trim($ntt).'-'.trim($url_mmc);
	
	$movement_url = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '-', ''), $movement_url_create);
	
	$isMovementUrlPresent = com_db_GetValue("select move_id from ".TABLE_MOVEMENT_MASTER." where movement_url='".$movement_url."'");
	if($isMovementUrlPresent>0){
		echo '<samp style="color:red;">This entry already exists in the database</span>';
	}
}
if($type=='PersonalDetailsShow'){
	$pemail = trim(com_db_input($_REQUEST['pemail']));
	$call_from = trim(com_db_input($_REQUEST['call_from']));
	$personQuery = "select * from ".TABLE_PERSONAL_MASTER." where email<>'' and email='".$pemail."'";
	$personalResult = com_db_query($personQuery);
	if($personalResult){
		$numRows = com_db_num_rows($personalResult);
		$personRow = com_db_fetch_array($personalResult);
	}
	if($personRow['email_verified']=='Yes'){
		$email_verified = $personRow['email_verified'];
	}else{
		$email_verified = 'No';
	}
	if($personRow['email_verified_date'] !='0000-00-00'){
		$ev_date = explode('-',$personRow['email_verified_date']);
		$email_verified_date = $ev_date[1].'/'. $ev_date[2].'/'. $ev_date[0];
	}else{
		$email_verified_date='';
	}
	$pcQuery = "select mm.title,mm.effective_date,cm.company_name,mc.name from ".TABLE_MOVEMENT_MASTER." mm, ".TABLE_COMPANY_MASTER." cm,".TABLE_MANAGEMENT_CHANGE." mc where mm.company_id=cm.company_id and mm.movement_type=mc.id and mm.personal_id='".$personRow['personal_id']."'" ;
	$pcResult = com_db_query($pcQuery);
	while($pcRow = com_db_fetch_array($pcResult)){
		$present_company_info .= com_db_output($pcRow['name'].' as '.$pcRow['title'].' at ' .$pcRow['company_name']).'<br>';
	}
	if($numRows>0){
		$showPersinalDetails   ='<img src="'.HTTP_CTO_URL.'/images/close-buttn1.png" style="border:0px solid red; float:right;margin-top:-26px;margin-right:-22px;cursor:pointer;" onclick="ClosePersonalDetails();" />
								<table width="100%" border="0" cellpadding="2" cellspacing="2">
									<tr>
										<td><img src="'.HTTP_CTO_URL.'/verivied_image/small/'.$personRow['verified_image'].'" /></td>
									</tr>
								</table>';
	}else{
		$showPersinalDetails='<img src="'.HTTP_CTO_URL.'/images/close-buttn1.png" style="border:0px solid red; float:right;margin-top:-26px;margin-right:-22px;cursor:pointer;" onclick="ClosePersonalDetails();" />
							  <samp style="color:red;"><b>This email not found in the database</b></span>';
	}
	if($call_from=='movement_entry'){
		$showPersinalDetails = '<div style="padding:10px;width:350px;margin-top:220px;margin-right:30px;right:0;border:2px solid #666;position:absolute;background-color:#CCC;z-index:9999;">'.$showPersinalDetails.'</div>';
	}elseif($call_from=='personal_entry'){
		$showPersinalDetails = '<div style="padding:10px;width:350px;margin-top:150px;margin-right:30px;right:0;border:2px solid #666;position:absolute;background-color:#CCC;z-index:9999;">'.$showPersinalDetails.'</div>';
	}
	echo $email_verified.'###'.$email_verified_date.'###'.$showPersinalDetails;	
}

if($type=='GenerateEmail'){

	$first_name = $_GET["first_name"];
	$middle_name = $_GET["middle_name"];
	$last_name = $_GET["last_name"];
	$email_pattern_id = $_GET["email_pattern_id"];
	$email_domain = $_GET["email_domain"];
	echo generate_email_address($first_name,$middle_name,$last_name,$email_domain,$email_pattern_id);
	//echo '<select name="state" id="state" style="width:206px;">';
	//echo selectComboBox("select state_id,short_name from ".TABLE_STATE." where country_id="."'".$q."'"." order by short_name","");
	//echo '<option value="Any">Any</option>';
	//echo '</select>';
}

if($type=='ValidateEmail'){

	
	$person_email = $_GET["person_email"];
	$first_name = $_GET["first_name"];
	$middle_name = $_GET["middle_name"];
	$last_name = $_GET["last_name"];
	$email_domain = $_GET["email_domain"];
	$email_pattern = $_GET["email_pattern"];
	$company_website = $_GET["company_website"];
	$email_pattern_id = $_GET["email_pattern_id"];
	//echo "<br>email_domain: ".$email_domain;
	validate_email_address($person_email,$first_name,$middle_name,$last_name,$email_domain,$email_pattern,$company_website,$email_pattern_id);
	
	
	
	//echo '<select name="state" id="state" style="width:206px;">';
	//echo selectComboBox("select state_id,short_name from ".TABLE_STATE." where country_id="."'".$q."'"." order by short_name","");
	//echo '<option value="Any">Any</option>';
	//echo '</select>';
}

if($type=='updateEmailDomain'){
	//echo "Update Email domain";
	$currentEmailDomain = $_GET["currentEmailDomain"];
	$newEmailDomain = $_GET["newEmailDomain"];
	$updateEmailDomainQuery = "UPDATE ".TABLE_COMPANY_MASTER." SET email_domain = '".$newEmailDomain."' where email_domain='".$currentEmailDomain."'";
	//echo "<br>Q: ".$updateEmailDomainQuery;
	$updateEmailDomainResult = com_db_query($updateEmailDomainQuery);
	
	//$to = "faraz.aleem@nxb.com.pk";
	//$subject = "Test subject";
	//$message = "Test Message";
	//$from = "faraz.aia@nxvt.com";
	$subject = "Email Domain of company changed from ".$currentEmailDomain." to ".$newEmailDomain;
	$message = "This is an alert email to tell Email Domain of company changed from ".$currentEmailDomain." to ".$newEmailDomain." on Data-entry portal of CTOS.";
	//$from = "";
	
	//send_email($to, $subject, $message, $from);
	
	$to_admin      = "admin@ctosothemove.com";//'faraz_aleem@hotmail.com';
	$email = '';
	$full_name = '';

	//$subject = 'the subject within fun';
	//$message = 'hello';
	//echo "just before";
	//$response_email_send = send_email_mailer_dataentry($to_admin, $subject, $message, $email,$full_name='');
	//echo "After response: ".$response_email_send;
	
	
	
	
	// sending email starts
	require_once('../PHPMailer/class.phpmailer.php');
	$mail                = new PHPMailer();

	$mail->IsSMTP(); // telling the class to use SMTP
	$mail->SMTPAuth      = true;                  // enable SMTP authentication
	$mail->SMTPKeepAlive = true;                  // SMTP connection will not close after each email sent
	$mail->Host          = "smtpout.secureserver.net";//"relay-hosting.secureserver.net"; // sets the SMTP server relay-hosting.secureserver.net smtpout.secureserver.net
	$mail->Port          = 25;    // 80, 3535, 25, 465 (SSL)      // 26 set the SMTP port for the GMAIL server
	$mail->Username      = "rts_email_sent@ctosonthemove.com"; // SMTP account username
	$mail->Password      = "rts0214";        // SMTP account password
	$mail->SetFrom('rts_email_sent@ctosonthemove.com', 'ctosonthemove.com');
	//$mail->AddReplyTo($from_admin, 'ctosonthemove.com');

	$mail->Subject       = $subject;

	$emailContent = $message; 

	$mail->MsgHTML($emailContent);
	$mail->AddAddress($to_admin, $full_name);

	if(!$mail->Send()) 
	{
		//$result ="Mailer Error (" . str_replace("@", "&#64;", $email) . ') ' . $mail->ErrorInfo;
	}
	else
	{
		//$result = "Email send";
	}
	// sending email ends
	
	echo $subject;
	//echo "Email Domain is changed and email send to Admin.";
}

if($type=='SendExecutiveEmail'){
	
	
	//echo "<br>HHH"; die();
	$full_name = '';
	$result = '';
	$entered_person_email = $_GET["entered_person_email"];
	$sql_query = "select * from " . TABLE_EXECUTIVE_DEMO_EMAIL_INFO." order by add_date desc LIMIT 0,1";
	//echo "<br>sql_query: ".$sql_query;
	$exe_data = com_db_query($sql_query);

	$numRows = com_db_num_rows($exe_data);
	//echo "<br>numRows: ".$numRows;
	if($numRows > 0)
	{
		while ($data_sql = com_db_fetch_array($exe_data)) 
		{
			$add_date 		= $data_sql['add_date'];
			$email_details 	= $data_sql['email_details'];
			//$add_date = $data_sql['add_date'];
			//$add_date = $data_sql['add_date'];
			
			// sending email starts
			require_once('../PHPMailer/class.phpmailer.php');
			$mail                = new PHPMailer();

			$mail->IsSMTP(); // telling the class to use SMTP
			$mail->SMTPAuth      = true;                  // enable SMTP authentication
			$mail->SMTPKeepAlive = true;                  // SMTP connection will not close after each email sent
			$mail->Host          = "smtpout.secureserver.net";//"relay-hosting.secureserver.net"; // sets the SMTP server relay-hosting.secureserver.net smtpout.secureserver.net
			$mail->Port          = 80;  //25;    // 80, 3535, 25, 465 (SSL)      // 26 set the SMTP port for the GMAIL server
			$mail->Username      = "rts_email_sent@ctosonthemove.com"; // SMTP account username
			$mail->Password      = "rts0214";        // SMTP account password
			//$mail->SetFrom('rts_email_sent@ctosonthemove.com', 'ctosonthemove.com');
			//$mail->SetFrom('ms@ctosonthemove.com', 'ctosonthemove.com');
			//$mail->SetFrom('info@ctosonthemove.com', 'ctosonthemove.com');
                        //$mail->SetFrom('info@ctosonthemove.com', 'ctosonthemove.com');
                        
                        ////$mail->SetFrom('farazaleem@gmail.com');
			
                        //$mail->SetFrom('rts_email_sent@ctosonthemove.com', 'ctosonthemove.com'); // This seems to be working
                        //$mail->SetFrom('updates@actionablenews.com', 'ctosonthemove.com');
                        
                        $mail->SetFrom('info@ctosonthemove.com', 'ctosonthemove.com');
                        
                        
                        
                        
                        $mail->AddReplyTo('ms@ctosonthemove.com', 'ctosonthemove.com');
                        
                        ////$mail->AddReplyTo($from_admin, 'ctosonthemove.com');
                        //$mail->AddReplyTo('agentpet1@gmail.com', 'ctosonthemove.com');
			
                        $mail->Subject       = "Executive Email";
                        //$mail->Sender = 'farazaleem@gmail.com';
			//$emailContent = $message; 
			//$email_details = "Test content";	
			//echo "<br>entered_person_email: ".$entered_person_email;
			//echo "<br>email_details: ".$email_details;
			
			$mail->MsgHTML($email_details);
			$mail->AddAddress($entered_person_email, $full_name);
			
			if(!$mail->Send()) 
			{
				//$result ="Mailer Error (" . str_replace("@", "&#64;", $email) . ') ' . $mail->ErrorInfo;
				$result = "Eror In Executive Email Sending";
			}
			else
			{
				$result = "Executive Email Send";
			}
			
		}
	}
	echo $result;	
}

if($type=='ReverseEngineer'){
	$first_name 					= $_GET["first_name"];
	$middle_name 					= $_GET["middle_name"];
	$last_name 						= $_GET["last_name"];
	$email_domain 					= $_GET["email_domain"];
	$email_to_check 				= $_GET["person_email"];
	
	$current_company_email_pattern 	= $_GET["current_company_email_pattern"];
	$company_website 				= $_GET["company_website"];
	
	$grade = 'A';
	$new_pattern_id = getting_email_pattern($first_name,$middle_name,$last_name,$email_domain,$email_to_check,$current_company_email_pattern);
	//echo "<br>new_pattern_id: ".$new_pattern_id;
	if($new_pattern_id != '')
	{
		$company_info_query = "select company_id,email_pattern_id from " . TABLE_COMPANY_MASTER . " where company_website = '".$company_website."' LIMIT 0,1";
		//echo "<br>company_info_query: ".$company_info_query;
		$company_info_result = com_db_query($company_info_query);
		while($company_info_row = com_db_fetch_array($company_info_result)) 
		{
			$this_company_id 			= $company_info_row['company_id'];
			$this_company_pattern_id 	= $company_info_row['email_pattern_id'];
		}
		if($this_company_pattern_id == 0 || $this_company_pattern_id == '' )
		{
			$upd_query = "UPDATE " . TABLE_COMPANY_MASTER." SET email_pattern_id = $new_pattern_id where company_website = '".$company_website."'";
			$upd_result = com_db_query($upd_query);
			
		}	
		else
		{
			com_db_query("INSERT into ".TABLE_COMPANY_EMAIL_PATTERN_HISTORY."(company_id,email_pattern_id,result,add_date) values('".$this_company_id."','".$new_pattern_id."','".$grade."','".date("Y-m-d:H:i:s")."')");	
		}
		
	}
	echo $email_verified_result = date("m/d/Y")." - valid";
}


if($type=='OnlyGenerateEmailAddress'){
    $first_name     = trim($_GET["first_name"]);
    $middle_name    = trim($_GET["middle_name"]);
    $last_name      = trim($_GET["last_name"]);
    $email_domain   = trim($_GET["email_domain"]);
    $email_pattern  = trim($_GET["email_pattern"]);

    //echo "<br>first_name: ".$first_name;

    $generated_email_address = trim(generate_email_address($first_name,$middle_name,$last_name,$email_domain,$email_pattern));
    echo $generated_email_address;    
    //$new_pattern_id = getting_email_pattern($first_name,$middle_name,$last_name,$email_domain,$email_to_check,$current_company_email_pattern);
}



if($type=='enteredPattern'){
    $person_email = $_GET["person_email"];
    $first_name = $_GET["first_name"];
    $middle_name = $_GET["middle_name"];
    $last_name = $_GET["last_name"];
    $email_domain = $_GET["email_domain"];
    $email_pattern = $_GET["email_pattern"];
    $company_website = $_GET["company_website"];
    $email_pattern_id = $_GET["email_pattern_id"];

    //validate_email_address($person_email,$first_name,$middle_name,$last_name,$email_domain,$email_pattern,$company_website,$email_pattern_id);

    $invalid_pattern_arrays = array();
    $entered_pattern_id = getting_email_pattern($first_name,$middle_name,$last_name,$email_domain,$person_email);

    //echo "<br>entered_pattern_id: ".$entered_pattern_id;

    $invalid_pattern_arrays[] = $entered_pattern_id;
    $success_pattern = "";

    for($c = 1;$c<=27 ;$c++)
    {
        if(!in_array($c,$invalid_pattern_arrays) && $success_pattern == '')
        {

             //echo "<br><br><br>First_name:".$first_name;
             //echo "<br>last_name:".$last_name;
             //echo "<br>email_domain:".$email_domain;
             //echo "<br>C:".$c;

            $email_with_new_pattern = generate_email_address($first_name,$middle_name,$last_name,$email_domain,$c);




            //echo "<br>Checking for pattern ID:".$c;
            //echo "<br>email generated with pattern ID:".$email_with_new_pattern;
            // check for pattern 1 through datavalidation API
            $dataValidationResponse = check_dataValidationAPI($email_with_new_pattern);

            //echo "<br>dataValidationResponse for pattern ID:".$dataValidationResponse;    
            //echo "<br>success_pattern:".$success_pattern;    

            if($dataValidationResponse == 'A+' || $dataValidationResponse == 'A')
            {
                $success_pattern = $c;

                
                // getting current email pattern value
                //$current_pattern_query = "select company_id,email_pattern_id from " . TABLE_COMPANY_MASTER." where company_website = '".$company_website."'";
                //$current_pattern_result = com_db_query($current_pattern_query);
                
                //$current_pattern_row = com_db_fetch_array($current_pattern_result);
                //$current_email_pattern = $current_pattern_row['email_pattern_id'];
                //$this_company_id = $current_pattern_row['company_id'];
                
                
                //if($current_email_pattern == '')
                //{
                    $upd_pattern_query = "UPDATE " . TABLE_COMPANY_MASTER." SET email_pattern_id = $success_pattern where company_website = '".$company_website."'";
                    //echo "<br>upd_pattern_query:".$upd_pattern_query;
                    $upd_pattern_result = com_db_query($upd_pattern_query);
                //}
                //else
                //{
                    //com_db_query("INSERT into ".TABLE_COMPANY_EMAIL_PATTERN_HISTORY."(company_id,email_pattern_id,result,add_date) values('".$this_company_id."','".$success_pattern."','A','".date("Y-m-d:H:i:s")."')");	
                    
                //}    
            }    
        }        
    }
    //echo "<br>success_pattern:".$success_pattern;
    echo "Valid pattern:".$success_pattern;

}


function check_dataValidationAPI($email_to_check)
{
    $ch = curl_init();

    $url = "https://api.datavalidation.com/1.0/rt/".$email_to_check."/?pretty=true";

    //set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL, $url);

    //$headr[] = "Authorization:bearer 044a15fe3c511d8af236b21229e17550";
    //$headr[] = "Authorization:bearer 65378a7477ed556bc4489ab286b6237d";
    //$headr[] = "Authorization:bearer cfbbf1b65d1b8abf4fccbed1112c03db";
    //$headr[] = "Authorization:bearer 3f1bd3e74c0e2a661bc6e580e925234a";
    
    $headr[] = "Authorization:bearer 00d1ed7238b2d915738925c3688893ba";

    //curl_setopt($ch, CURLOPT_HEADER, "1");
    curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    //execute post
    $result = curl_exec($ch);

    //close connection
    curl_close($ch);

    $email_verified_details = json_decode($result);
    return $email_verified_details->grade;
}



if($type=='GetSiteUsrs'){ 
    
    echo getSiteUsers($_GET['comp_url']);
    /*
    $comp_url = $_GET['comp_url'];
    
    $compQuery = "select company_id,email_domain from ".TABLE_COMPANY_MASTER." where company_website ='".$comp_url."'";
	
    $compResult = com_db_query($compQuery);
    $compRow = com_db_fetch_array($compResult);
    $company_id = com_db_output($compRow['company_id']);
    $email_domain = com_db_output($compRow['email_domain']);

    //echo "<br>company_id: ".$company_id;
    //echo "<br>email_domain: ".$email_domain;

    $matched_val = "";
    if($email_domain != '')
        $matched_val = $email_domain;
    elseif($comp_url != '')
    {
        $extracted_domain = str_replace("www.", "", $comp_url);
        $matched_val = $extracted_domain;
    }    
    //10.132.225.160
    $hre = mysql_connect("10.132.225.160","hre2","htXP%th@71",TRUE) or die("Databasee ERROR:".mysql_error());
    mysql_select_db("hre2",$hre) or die ("ERROR: Database not found ");
    
    $first_name = "NO VAL";
    //$moveResult = mysql_query("select personal_id from hre_personal_master where personal_id=57159",$hre);
    $personalsResult = mysql_query("select personal_id,first_name,last_name from hre_personal_master where email like '%".$matched_val."%' and personal_image != '' and email != ''",$hre);
    
    //echo "<br><br>select personal_id,first_name,last_name from hre_personal_master where email like '%".$matched_val."%' and personal_image != '' and email != ''";
    
    $numPersonal = com_db_num_rows($personalsResult);
    if($numPersonal > 0)
    {
        $output = "<select name=personalForFunding id=personalForFunding><option>Select Funding Person</option>";
        while($personalRow = mysql_fetch_array($personalsResult))
        {
            //echo "<pre>personalRow: ";   print_r($personalRow);   echo "</pre>";
            
            $personal_id = $personalRow['personal_id'];    
            $first_name = $personalRow['first_name'];
            $last_name = $personalRow['last_name'];
            $full_name = $first_name." ".$last_name;
            //echo "<br><br>first_name: ".$first_name;
            //echo "<br>last_name: ".$last_name;
            //echo "<br>full_name: ".$full_name;
            $output .= "<option value=".$personal_id.">".$full_name."</option>";
        }
        $output .= "</select>";
    }    
    mysql_close($hre);
    echo $output;
      
     */
}

if($type=='SetFundingUser'){ 
    $selected_funding_personal_id = $_GET['selected_funding_personal_id'];
    $email_domain = $_GET['company_domain'];
    
    $matched_val = "";
    if($email_domain != '')
        $matched_val = $email_domain;
    elseif($comp_url != '')
    {
        $extracted_domain = str_replace("www.", "", $comp_url);
        $matched_val = $extracted_domain;
    }    

    
    $hre = mysql_connect("10.132.225.160","hre2","htXP%th@71",TRUE) or die("Databasee ERROR:".mysql_error());
    mysql_select_db("hre2",$hre) or die ("ERROR: Database not found ");
    //echo "<br>update hre_personal_master set add_to_funding = 0 where email like '%@".$matched_val."' and add_to_funding = 1";
    $removePersonalUpdate = mysql_query("update hre_personal_master set add_to_funding = 0 where email like '%@".$matched_val."' and add_to_funding = 1",$hre);
    
    if($selected_funding_personal_id > 0)
    {
        //$moveResult = mysql_query("select personal_id from hre_personal_master where personal_id=57159",$hre);
        $personalsUpdate = mysql_query("update hre_personal_master set add_to_funding = 1 where personal_id = ".$selected_funding_personal_id,$hre);
    
    }    
}


if($type=='SetCompany'){
    $fname = $_GET['fname'];
    $lname = $_GET['lname'];
    $company_id = "";
    $getComp_query = "select cm.company_id,cm.company_name,city,company_website,s.state_name as state from 
                        ".TABLE_PERSONAL_MASTER." as pm,
                        ".TABLE_MOVEMENT_MASTER." as mm,
                        ".TABLE_COMPANY_MASTER." as cm,
                        ".TABLE_STATE." as s     
                        where (pm.personal_id = mm.personal_id and mm.company_id = cm.company_id and cm.state = s.state_id)
                        and first_name = '".$fname."' and last_name = '".$lname."'";
    
    //echo "<br>getComp_query: ".$getComp_query;
    
    $getComp_result = com_db_query($getComp_query);
    $getComp_row = com_db_fetch_array($getComp_result);
    $company_id = $getComp_row['company_id'];
    $company_name = $getComp_row['company_name'];
    $company_city = $getComp_row['city'];
    $company_state = $getComp_row['state'];
    $company_website = $getComp_row['company_website'];
    
    //echo "<br>company_id: ".$company_id;
    
    echo $company_id.":".$company_name.":".$company_city.":".$company_state.":".$company_website;
}

?> 