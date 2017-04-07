<?php
ini_set('track_errors', 1);
require('includes/include_top.php');

//$url = $_GET['url']; //"www.example.com";

//$phoneNumber = $_GET['ph'];//"333.999.1234";
//if (preg_match('/^\(\d{3}\) \d{3}-\d{4}\$/', $phoneNumber))
//if(preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $phoneNumber)) 
//if(preg_match("/^\(\d{3}\) \d{3}-\d{4}$/", $phoneNumber)) 

/*
$options['options'] = array('regexp' => '/^\(\d{3}\) \d{3}-\d{4}$/');
$valid = filter_input( INPUT_POST, $phoneNumber, FILTER_VALIDATE_REGEXP, $options);
echo "<br>Valid: ".$valid;
if($valid == 1)
	echo "<br>Correct".$phoneNumber;
else
	echo "<br>InCorrect:".$phoneNumber;	
*/	
	
	
function check_phone($number)
{
	$regex = "/^(\d[\s.]?)?[\(\[\s.]{0,2}?\d{3}[\)\]\s.]{0,2}?\d{3}[\s.]?\d{4}$/i";
	$number = trim($number);
	//echo "<br>FA Within func: ".$number;
	if(preg_match( $regex, $number ))
	{
		//echo "<br>FA num length: ".strlen($number);
		//echo "<br>Strpos: ".strpos($number, ' ');
		if(strlen($number) == 12 && strpos($number, ' ') == '')
		{
			//echo "<br>if if one";
			return true;	//echo "<br>".$number . ': True'; 
		}	
		else
		{
			//echo "<br>if else one";
			return false;  //echo "<br>".$number . ': False'; 
		}	
	}
	else
	{
		//echo "<br>if else two";
		return false;//echo "<br>".$number . ': False'; 
	}	

}		


function check_url($check_url)
{
$url = $check_url;
//echo "<br>URL: ".$url;
$pre_check = 1;
$post_url = substr($url,strlen($url)-4,4); 
$pre_url = substr($url,0,4); 
if($pre_url == 'http' || $pre_url == 'www.')
	$pre_check = 0;

//if(!filter_var($url, FILTER_VALIDATE_URL,FILTER_FLAG_QUERY_REQUIRED))
if($post_url == '.com' && $pre_check == 0)
	{
		return 1; // correct URL
	}
	else
	{
		return 0;
	}
}  

//echo "RES:".check_url($_GET['url']);
//die();

function get_file_link($file_name)
{
	//$file_name = "path/to/filename.csv";
    header('Content-Type: text/csv; charset=utf-8');
    header("Content-Disposition: attachment; filename=".$file_name);
    @readfile($file_name);
}
	



$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';
$error_list = (isset($_GET['error_list'])) ? msg_decode($_GET['error_list']) : '';
    switch ($action) {
      case 'save':
	  	
			$dup_count = 0;
			$rec_uploaded = 0;
			$rec_rejected = 0; 
			$dup_count_file = fopen("duplicates.csv", "w") ;
			//if ( !$dup_count_file ) {
			//	echo 'fopen failed. reason: ', $php_errormsg;
			//}
			
			$rec_uploaded_file = fopen("rec_uploaded.csv", "w"); 
			$rec_rejected_file = fopen("rec_rejected.csv", "w");
			$dup_recs = '';
			$uploaded_recs = '';
			$rejecteded_recs = '';
		
			$data_file = $_FILES['data_file']['tmp_name'];
								
			if($data_file!=''){
				if(is_uploaded_file($data_file)){
					$org_file = $_FILES['data_file']['name'];
					$exp_file = explode("." , $org_file);
					$new_file_name = str_replace(' ','_',$org_file);
					$new_file_name = str_replace('+','_',$new_file_name);
					$new_file_name = date('YmdHms').'_'.$new_file_name;
					$get_ext = $exp_file[sizeof($exp_file) - 1];
					if($get_ext=='csv'){
						

						$destination_file = '../UploadsFiles/' . $new_file_name; //$org_file;
						if(move_uploaded_file($data_file , $destination_file)){
							$columnheadings = 1;	
							$filecontents = file ($destination_file);
							//caption start
							//$col_fld_cap = array('Company Name','Company Website','Company Logo','Company Size Revenue','Company Size Employees','Industry','Email Pattern','Leadership Page','Address','Address 2','City','Country','State','Zip Code','Phone','Fax','About Company','Facebook Link','Linkedin Link','Twitter Link','Google+ Link');
							//$col_fld_cap = array('company_name','company_website','company_logo','company_revenue','company_employee','company_industry','ind_group_id','industry_id','email_pattern','leadership_page','address','address2','city','country','state','zip_code','phone','fax','about_company','facebook_link','linkedin_link','twitter_link','googleplush_link','add_date');
							
							
							/*
							$capnewString = $filecontents[0];
							$capnewArray = explode(',', $capnewString);
							$cap=0;
							$cap_flag = 0;
							$error_list='';
							foreach($capnewArray as $capkey => $capvalue){
								if(strtoupper(trim($capnewArray[$cap])) != strtoupper(trim($col_fld_cap[$cap]))){
									$error_list .= '&nbsp;&nbsp;Requered field name is "'.trim($col_fld_cap[$cap]).'" not "'.trim($capnewArray[$cap]).'"<br />';
									$cap_flag = 1;
								}
								$cap++;
							}
							if($cap_flag==1){
								//$msg = "Column name not matching in your CSV file, please check the column heading.";
								$msg = "Upload file format:      [X]";
								com_redirect("company-master-import.php?selected_menu=master&msg=" . msg_encode($msg)."&error_list=".msg_encode($error_list));
							}
							*/
							//caption end
							
							$c_name_truncate = array(", Inc."," Corp.",", LLC");
							
							
							for($i=$columnheadings; $i<sizeof($filecontents); $i++) { 
								$strQuery = '';
								$strQuery1 = '';
								$strQuery2 = '';
								$newString = $filecontents[$i];
								$newArray = explode(',', $newString);
								
								$this_rejecteded_recs = "";
								$this_rec_rejected = 0;
								
								//echo "<pre>newArray : ";	print_r($newArray);	echo "</pre>";
								if(sizeof($newArray)== 21){
									$col_fld = array('company_name','company_website','company_logo','company_revenue','company_employee','company_industry','ind_group_id','industry_id','email_pattern','leadership_page','address','address2','city','country','state','zip_code','phone','fax','about_company','facebook_link','linkedin_link','twitter_link','googleplush_link','add_date');
								
									$strQuery = "INSERT INTO " . TABLE_COMPANY_MASTER . " (";
									
									foreach($col_fld as $key => $value){
										$strQuery .= $value.',';
									}
									
									$strQuery1 .= substr($strQuery,0, -1);
									$strQuery1 .= ") values (";
									$p=0;
									
									foreach($newArray as $key => $value){
										
										if($p==0){
											$import_company_name = com_db_input(str_replace(';',',',trim($newArray[$p])));
											
											foreach($c_name_truncate as $blocked_name)
											{
												if(strpos($import_company_name,$blocked_name) > -1)
												{
													$import_company_name = trim($import_company_name,$blocked_name);
													//echo "<br>updated company name: ".$import_company_name; die();
												}
											}
											
											$strQuery1 .= "'" . $import_company_name ."',";
										}elseif($p==1){
											$import_company_website = com_db_input(str_replace(';',',',trim($newArray[$p])));
											//$rep   = array("http://", "https://","www.","/");
											//$import_company_website ="www.". str_replace($rep,'',$import_company_website);
											//echo "<br>import_company_website: ".$import_company_website;
											//echo "<br>Fileter var: ".filter_var($import_company_website, FILTER_VALIDATE_URL,FILTER_FLAG_PATH_REQUIRED);
											if(!filter_var($import_company_website, FILTER_VALIDATE_URL,FILTER_FLAG_PATH_REQUIRED))
											if(check_url($import_company_website) == 0)
											{
												$this_rejecteded_recs = "Company Website is not valid";
												$rec_rejected++;
												$this_rec_rejected++;
											}
											else
											{
												$strQuery1 .= "'" . $import_company_website ."',";	
											}	
										}elseif($p==2){
											$import_company_logo = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$strQuery1 .= "'" . $import_company_logo ."',";
										}elseif($p==3 && $this_rec_rejected == 0){	
											$import_revenue_type = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$revenue_size_id = com_db_GetValue("select id from " . TABLE_REVENUE_SIZE . " where name = '".$import_revenue_type."'");
											if($revenue_size_id==''){
												//$ins_query_revenue = "insert into " . TABLE_REVENUE_SIZE ."(name,add_date)value('".$import_revenue_type."','".date("Y-m-d")."')";
												//com_db_query($ins_query_revenue);
												//$revenue_size_id = com_db_insert_id();
												
												$this_rejecteded_recs = "Company size revenue is not valid";
												$rec_rejected++;
												$this_rec_rejected++;
												
											}
											else
											{
												$strQuery1 .= "'" . $revenue_size_id ."',";
											}	
										}elseif($p==4 && $this_rec_rejected == 0){	
											$import_employee_size = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$employee_size_id = com_db_GetValue("select id from " . TABLE_EMPLOYEE_SIZE. " where name = '".$import_employee_size."'");
											if($employee_size_id==''){
												//$ins_employee_size = "insert into " . TABLE_EMPLOYEE_SIZE ."(name,add_date)value('".$import_employee_size."','".date("Y-m-d")."')";
												//com_db_query($ins_employee_size);
												//$employee_size_id = com_db_insert_id();
												$this_rejecteded_recs = "Company size is not valid";
												$rec_rejected++;
												$this_rec_rejected++;
											}
											else
											{
												$strQuery1 .= "'" . $employee_size_id ."',";
											}	
										}elseif($p==5 && $this_rec_rejected == 0){
											$tot_ind = explode(':',$newArray[$p]);
											$industry_invalid = 0;
											$ind_group_id = com_db_GetValue("select industry_id from " . TABLE_INDUSTRY . " where title = '".str_replace(';',',',trim($tot_ind[0]))."'");
											if(sizeof($tot_ind)==2){
												$ind_group_id = com_db_GetValue("select industry_id from " . TABLE_INDUSTRY . " where title = '".str_replace(';',',',trim($tot_ind[0]))."'");
												$industry_id = com_db_GetValue("select industry_id from " . TABLE_INDUSTRY . " where title = '".str_replace(';',',',trim($tot_ind[1]))."'");
												$industry_name = com_db_output(str_replace(';',',', trim($tot_ind[1])));
												$industry_group_name = com_db_output(str_replace(';',',', trim($tot_ind[0])));
												if($ind_group_id =='' ){
													//$ind_query_ins = "insert into " . TABLE_INDUSTRY ."(parent_id,title,add_date)value('0','".$industry_group_name."','".time()."')";
													//com_db_query($ind_query_ins);
													//$ind_group_id = com_db_insert_id();
													//$ind_query_ins = "insert into " . TABLE_INDUSTRY ."(parent_id,title,add_date)value('".$ind_group_id."','".$industry_name."','".time()."')";
													//com_db_query($ind_query_ins);
													//$industry_id = com_db_insert_id();
													$industry_invalid = 1;
												}elseif($ind_group_id !='' && $industry_id ==''){
													//$ind_query_ins = "insert into " . TABLE_INDUSTRY ."(parent_id,title,add_date)value('".$ind_group_id."','".$industry_name."','".time()."')";
													//com_db_query($ind_query_ins);
													//$industry_id = com_db_insert_id();
													$industry_invalid = 1;
												}
											}else{
												$ind_group_id ='0';
												$industry_id = com_db_GetValue("select industry_id from " . TABLE_INDUSTRY . " where title = '".str_replace(';',',',trim($tot_ind[0]))."'");
												$industry_name =com_db_output(str_replace(';',',', trim($tot_ind[0])));
											}	
											
											if($industry_invalid == 1)
											{
												$this_rejecteded_recs = "Industry is not valid";
												$rec_rejected++;
												$this_rec_rejected++;
											}
											else
											{
												$strQuery1 .= "'" . $industry_id ."','" . $ind_group_id ."','". $industry_id ."',";
											}	
											
											
										}elseif($p==6){
											$import_email_pattern = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$strQuery1 .= "'" . $import_email_pattern ."',";
										}elseif($p==7){
											$import_leadership_page = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$strQuery1 .= "'" . $import_leadership_page ."',";
										}elseif($p==8){
											$import_address = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$strQuery1 .= "'" . $import_address ."',";
										}elseif($p==9){
											$import_address2 = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$strQuery1 .= "'" . $import_address2 ."',";	
										}elseif($p==10){
											$import_city = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$strQuery1 .= "'" . $import_city ."',";	
										}elseif($p==11 && $this_rec_rejected == 0){
											$import_country = com_db_input(str_replace(';',',',trim($newArray[$p])));
											
											//if($country_id==''){
											$import_country = strtoupper($import_country);
											if($import_country == 'UNITED STATES' || $import_country == 'CANADA'){
												$country_id = com_db_GetValue("select countries_id from " . TABLE_COUNTRIES . " where countries_iso_code_3 = '".$import_country."' or countries_name='".$import_country."'");
												//$ins_query_country = "insert into " . TABLE_COUNTRIES ."(countries_name)value('".$import_country."')";
												//com_db_query($ins_query_country);
												//$country_id = com_db_insert_id();
												
												$strQuery1 .= "'" . $country_id ."',";
											}
											else
											{		
												$this_rejecteded_recs = "Country is not valid";
												$rec_rejected++;
												$this_rec_rejected++;
											}	
										}elseif($p==12 && $this_rec_rejected == 0){
											$import_state = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$state_id = com_db_GetValue("select state_id from " . TABLE_STATE . " where short_name = '".$import_state."'");
											if($state_id==''){
												//$ins_query_state = "insert into " . TABLE_STATE ."(short_name,country_id)value('".$import_state."','".$country_id."')";
												//com_db_query($ins_query_state);
												//$state_id = com_db_insert_id();
												
												$this_rejecteded_recs = "State is not valid";
												$rec_rejected++;
												$this_rec_rejected++;
												
											}
											else
											{
												$strQuery1 .= "'" . $state_id ."',";
											}
										}elseif($p==13 && $this_rec_rejected == 0){
											$import_zip_code = com_db_input(str_replace(';',',',trim($newArray[$p])));
											
											if(strlen($import_zip_code) == 5)
											{
												$strQuery1 .= "'" . $import_zip_code ."',";
											}
											else
											{
												$this_rejecteded_recs = "Zip Code is not valid";
												$rec_rejected++;
												$this_rec_rejected++;
											}
											
										}elseif($p==14){
											$import_phone = com_db_input(str_replace(';',',',trim($newArray[$p])));
											//echo "<br>PH: ".$import_phone;
											//if($import_phone == '' || preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $import_phone)) {
											$phone_check = check_phone($import_phone);
											//echo "<br>phone_check: ".$phone_check;
											if($phone_check == 1)
											{
												//echo "<br>In correct ph: ".$import_phone;
												$strQuery1 .= "'" . $import_phone ."',";
											}
											else
											{
												//echo "<br>In Incorrect ph";
												$this_rejecteded_recs = "Phone is not valid";
												$rec_rejected++;
												$this_rec_rejected++;
											}
											//die("FA");
											
										}elseif($p==15){
											$import_fax = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$strQuery1 .= "'" . $import_fax ."',";
										}elseif($p==16){
											$import_about_company = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$strQuery1 .= "'" . $import_about_company ."',";
										}elseif($p==17 && $this_rec_rejected == 0){
											$import_facebook_link = com_db_input(str_replace(';',',',trim($newArray[$p])));
											//echo "<br>In FB check";
											//$fb_link_pos = strpos($import_facebook_link,"http://www.facebook.com");
											if($import_facebook_link == '' || strpos($import_facebook_link,"https://www.facebook.com") > -1 || strpos($import_facebook_link,"http://www.facebook.com") > -1)
											{	
												
												$strQuery1 .= "'" . $import_facebook_link ."',";
												//echo "<br>In FB check IF: ".$strQuery1;
											}
											else
											{
												//echo "<br>In FB check ELSE";
												$this_rejecteded_recs = "Facebook link is not correct";
												$rec_rejected++;
												$this_rec_rejected++;
											}		

										}elseif($p==18 && $this_rec_rejected == 0){
											$import_linkedin_link = com_db_input(str_replace(';',',',trim($newArray[$p])));
											if($import_linkedin_link == '' || strpos($import_linkedin_link,"https://www.linkedin.com") > -1 || strpos($import_linkedin_link,"http://www.linkedin.com") > -1)
											{	
												$strQuery1 .= "'" . $import_linkedin_link ."',";
											}
											else
											{
												$this_rejecteded_recs = "LinkedIn link is not correct";
												$rec_rejected++;
												$this_rec_rejected++;
											}			
											//echo "<br>this_rejecteded_recs: ".$this_rejecteded_recs;			
											//echo "<br>rec_rejected: ".$rec_rejected;			
										}elseif($p==19 && $this_rec_rejected == 0){
											$import_twitter_link = com_db_input(str_replace(';',',',trim($newArray[$p])));
											
											
											if($import_twitter_link == '' || strpos($import_twitter_link,"https://twitter.com") > -1)
											{	
												$strQuery1 .= "'" . $import_twitter_link ."',";
											}
											else
											{
												$this_rejecteded_recs = "Twitter link is not correct";
												$rec_rejected++;
												$this_rec_rejected++;
											}	
											
											
										}elseif($p==20 && $this_rec_rejected == 0){
											$import_googleplush_link = com_db_input(str_replace(';',',',trim($newArray[$p])));
											
											if($import_googleplush_link == '' || strpos($import_googleplush_link,"https://plus.google.com") > -1)
											{
												$strQuery1 .= "'" . $import_googleplush_link ."',";
											}
											else
											{
												$this_rejecteded_recs = "Google+ link is not correct";
												$rec_rejected++;
												$this_rec_rejected++;
											}											
										}
										
										$p++;
									}
									
									$strQuery2 .= substr($strQuery1,0, -1);
									$strQuery2 .= ",'".date('Y-m-d')."')";
									
									$isCompanyWebsite = com_db_GetValue("select company_id from ".TABLE_COMPANY_MASTER." where company_website='".$import_company_website."' OR company_name = '".$import_company_name."'");
									//echo "<br>isCompanyWebsite: ".$isCompanyWebsite;
									if($isCompanyWebsite == 0)
									{
										//echo "select company_id from ".TABLE_COMPANY_WEBSITES." where company_website='".$import_company_website."'";
										$isCompanyWebsite = com_db_GetValue("select company_id from ".TABLE_COMPANY_WEBSITES." where company_website='".$import_company_website."'");
									}									
									//echo "<br>after isCompanyWebsite: ".$isCompanyWebsite; die();
									//echo "<br>this_rejecteded_recs: ".$this_rejecteded_recs;
									
										if($isCompanyWebsite>0){
											$dup_count++;
											$dup_recs .= $import_company_name."\n";
											 
										/*
											$modify_date = date('Y-m-d');
											$update_contact = "update ".TABLE_COMPANY_MASTER." set company_name='".$import_company_name."',company_logo='".$import_company_logo."',company_revenue='".$revenue_size_id ."', company_employee='".$employee_size_id."',
															   company_industry='".$industry_id."',ind_group_id='". $ind_group_id."',industry_id='".$industry_id."',leadership_page='".$import_leadership_page."',email_pattern='".$import_email_pattern."',address='".$address."',
															   address2='".$address2."',city='".$import_city."',state='".$state_id."',country='".$country_id."',zip_code='".$import_zip_code."',phone='".$import_phone."',fax='".$import_fax."',about_company='".$import_about_company."',facebook_link='".$import_facebook_link."',
															   linkedin_link='".$import_linkedin_link."',twitter_link='".$import_twitter_link."',googleplush_link='".$import_googleplush_link."',modify_date='".$modify_date."' where company_id='".$isCompanyWebsite."'";
											$companyQuery = $update_contact;
											com_db_query($companyQuery);
											com_db_query("insert into ".TABLE_COMPANY_UPDATE_INFO."(page_name,query_string,add_date) values('admin-company-import','".com_db_input($companyQuery)."','".date("Y-m-d:H:i:s")."')");
										*/	
										}
										else
										if($this_rejecteded_recs != ''){
										$rejecteded_recs .= $import_company_name.":".$this_rejecteded_recs."\n";
										//echo $reject_msg;
										
										}
										else{ 
											$companyQuery = $strQuery2;
											//echo "<br>companyQuery: ".$companyQuery;
											com_db_query($companyQuery);
											
											$insert_id = com_db_insert_id();
											
											$comInsQuery = "insert into ".TABLE_COMPANY_MASTER."(company_id,company_name,company_website,company_logo,company_revenue,company_employee,company_industry,ind_group_id,industry_id,email_pattern,leadership_page,address,address2,city,country,state,zip_code,phone,fax,about_company,facebook_link,linkedin_link,twitter_link,googleplush_link,add_date)values('"
											.$insert_id."','".$import_company_name."','".$import_company_website."','".$import_company_logo."','".$revenue_size_id."','".$employee_size_id."','".$industry_id."','".$ind_group_id."','".$industry_id."','".$import_email_pattern."','".$import_leadership_page."','".$address."','".$address2."','".$import_city."','".$country_id."','".$state_id."','".$import_zip_code."',
											'".$import_phone."','".$import_fax."','".$import_about_company."','".$import_facebook_link."','".$import_linkedin_link."','".$import_twitter_link."','".$import_googleplush_link."','".date("Y-m-d")."')";
											
											com_db_query("insert into ".TABLE_COMPANY_UPDATE_INFO."(page_name,query_string,add_date) values('admin-company-import','".com_db_input($comInsQuery)."','".date("Y-m-d:H:i:s")."')");
											
											$rec_uploaded++;
											$uploaded_recs .= $import_company_name."\n";
										}
										
									}else{
									 //$msg = "File column numbers is ".sizeof($newArray).', But Import required is 21 columns';
									 //echo "<br>Size: ".sizeof($newArray)."   "; die("FA");
									 $msg = "Upload file format:      [X]";
									 com_redirect("company-master-import.php?selected_menu=master&msg=" . msg_encode($msg));	
									}
							}
							//$msg = "File successfully imported.";
							
							fwrite($dup_count_file,$dup_recs);
							
							fwrite($rec_uploaded_file,$uploaded_recs);
							
							fwrite($rec_rejected_file,$rejecteded_recs);
							
							$msg = "<table><tr><td colspan=2><strong>Status:</strong></td></tr><tr><td>Upload file format:</td><td>[V]</td></tr>";
							$msg .= "<tr><td>Duplicates found:</td><td>".$dup_count."&nbsp;<a href=\"download-file.php?file_name=duplicates.csv\">File</a></td></tr>"; 
							$msg .= "<tr><td>Records uploaded:</td><td>     ".$rec_uploaded."&nbsp;<a href=\"download-file.php?file_name=rec_uploaded.csv\">File</a></td></tr>";
							$msg .= "<tr><td>Records rejected:</td><td>     ".$rec_rejected."&nbsp;<a href=\"download-file.php?file_name=rec_rejected.csv\">File</a></td></tr></table>";
							
							fclose($dup_count_file);
							fclose($rec_uploaded_file);
							fclose($rec_rejected_file);
							//die("FA");
							//echo "<br>MSG: ".$msg;
							//com_redirect("company-master-import.php?selected_menu=master&msg=" . msg_encode($msg));	
							}
						else
							{
							$msg = "File not imported.";
							com_redirect("company-master-import.php?selected_menu=master&msg=" . msg_encode($msg));	
							}	
						
						}else{
							$msg = "Please select the .CSV file.";
							com_redirect("company-master-import.php?selected_menu=master&msg=" . msg_encode($msg));	
						}	
					}
				}
				else
				{
					$msg = "Please select file.";
					com_redirect("company-master-import.php?selected_menu=master&msg=" . msg_encode($msg));
			}
		break;
    }



include("includes/header.php");
?>
<script type="text/javascript" language="javascript">
function checkForm(){
	
	if(!validateField(document.importfile.data_file, 'Please select import file.')){
		return false;
	}

}
</script>
<tr>
    <td align="left" valign="top" bgcolor="#FFFFFF"><table width="975" border="0" align="center" cellpadding="0" cellspacing="0">

      <tr>
		<?php
		include("includes/menu_left.php");
		?>
        <td width="10" align="left" valign="top">&nbsp;</td>
        <td width="769" align="left" valign="top">
	
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right">
			  <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="15%" align="left" valign="middle" class="heading-text">Import csv file</td>
				  <!-- <td width="85%" valign="middle" class="message" align="left"><?=$msg?></td> -->
				  <td width="85%" valign="middle" class="message" align="left"></td>
                 
                </tr>
              </table></td>
          </tr>
		 
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box">
		
		  <form name="importfile" method="post" action="company-master-import.php?selected_menu=master&action=save" enctype="multipart/form-data" onsubmit="return checkForm();">	
			<table width="60%" border="0" cellspacing="0" cellpadding="5">
			<?PHP
			if($msg != '')
			{
			?>
			  <tr>
				<td colspan="2"><?=$msg?></td>
			  </tr>	
			<?PHP
			}
            ?>			
			  <tr>
			  	<td colspan="2" height="20" align="right" class="page-text"><a href="download-company-info.php?type=Sample">Sample CSV Download</a></td></tr>
			  <tr>
			  <tr>
			  	<td colspan="2" height="20" class="page-text">&nbsp;<? if($error_list !=''){ echo '<b>Error List below :</b><br />'.$error_list.'<br />';} ?></td></tr>
			  <tr>
				<td width="15%" align="left" valign="top" class="page-text">&nbsp;&nbsp;&nbsp;&nbsp;File</td>
				<td width="85%" align="left" valign="top">
				  <input type="file" name="data_file" id="data_file" size="50" /></td>
			  </tr>
             
			   <tr>
				<td>&nbsp;</td>
				<td align="left" valign="top"><label>
				  <input type="submit" name="Submit" value="Import" class="submitButton" />
				</label></td>
			  </tr>
			</table>
			</form>
		</td>
          </tr>
        </table>
		
        </td>
      </tr>
    </table></td>
  </tr>	 
		
 <?php
include("includes/footer.php");
?> 