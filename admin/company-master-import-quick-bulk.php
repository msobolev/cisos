<?php
//php_value display_errors 1

// uncomment below two lines to see errrors
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

ini_set('max_execution_time', 12000);
//ini_set('post_max_size', '330M');
ini_set('upload_max_filesize', '6M');

$time_start = microtime(true); 

//ini_set('track_errors', 1);

ini_set('auto_detect_line_endings', true);

require('includes/include_top.php');

	
function check_phone($number)
{
	$regex = "/^(\d[\s.]?)?[\(\[\s.]{0,2}?\d{3}[\)\]\s.]{0,2}?\d{3}[\s.]?\d{4}$/i";
	$number = trim($number);
	if(preg_match( $regex, $number ))
	{
		if(strlen($number) == 12 && strpos($number, ' ') == '')
		{

			return true;	
		}	
		else
		{
			return false;
		}	
	}
	else
	{
		return false;
	}	
}		

function check_url($check_url)
{
	$url = $check_url;
	//echo "<br>URL: ".$url;
	$dot_count = substr_count($check_url, '.');
	$pre_check = 1;
	//$post_url = substr($url,strlen($url)-4,4); 
	$pre_url = substr($url,0,4); 
	if($pre_url == 'http' || $pre_url == 'www.')
		$pre_check = 0;

	//if(!filter_var($url, FILTER_VALIDATE_URL,FILTER_FLAG_QUERY_REQUIRED))
	//if($post_url == '.com' && $pre_check == 0)
	if($pre_check == 0 && $dot_count >= 2)
	{
		return 1; // correct URL
	}
	else
	{
		return 0;
	}
}  

// Code to fetch DB tables in array starts
$revenue_query = "select id,name from ".TABLE_REVENUE_SIZE; 
$result_revenue = com_db_query($revenue_query);
$revenue_tbl_arr = array();
while($revenue_row=mysql_fetch_assoc($result_revenue)) 
{
	$revenue_tbl_arr[$revenue_row['id']] = $revenue_row['name'];
}


$employee_query = "select id,name from ".TABLE_EMPLOYEE_SIZE; 
$result_employee = com_db_query($employee_query);
$employee_tbl_arr = array();
while($employee_row=mysql_fetch_assoc($result_employee)) 
{
	$employee_tbl_arr[$employee_row['id']] = $employee_row['name'];
}

$industry_query = "select industry_id,title from ".TABLE_INDUSTRY; 
$result_industry = com_db_query($industry_query);
$industry_tbl_arr = array();
while($industry_row=mysql_fetch_assoc($result_industry)) 
{
	$industry_tbl_arr[$industry_row['industry_id']] = $industry_row['title'];
}

$state_query = "select state_id,short_name from ".TABLE_STATE; 
$result_state = com_db_query($state_query);
$state_tbl_arr = array();
while($state_row=mysql_fetch_assoc($result_state)) 
{
	$state_tbl_arr[$state_row['state_id']] = $state_row['short_name'];
}





// Code to fetch DB tables in array ends







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
							
							$strQuery = '';
							$strQuery2 = '';
							
							$col_fld = array('company_name','company_website','company_logo','company_revenue','company_employee','company_industry','ind_group_id','industry_id','email_pattern','leadership_page','address','address2','city','country','state','zip_code','phone','fax','about_company','facebook_link','linkedin_link','twitter_link','googleplush_link','add_date');
							$strQuery = "INSERT INTO ".TABLE_COMPANY_MASTER." (";
									
							foreach($col_fld as $key => $value){
								$strQuery .= $value.',';
							}
							
							//$strQuery1 .= substr($strQuery,0, -1);
							//$strQuery1 .= ") values (";
									
								
									
							$strQuery = substr($strQuery,0, -1);
							$strQuery .= ") values ";		
									
									
								//echo "<br><br><br>strQuery at start: ".$strQuery;		
									
							
							$c_name_truncate = array(", Inc."," Corp.",", LLC");
							
							
							
							
							//echo 'Total execution time in seconds before loop start: ' . (microtime(true) - $time_start);
							
							//echo "<br>FA FILE SIZE: ".sizeof($filecontents);
							$uploaded_file_size = sizeof($filecontents);
							for($i=$columnheadings; $i<$uploaded_file_size; $i++) { 
								
								$strQuery1 = '';
								
								$newString = $filecontents[$i];
								$newArray = explode(',', $newString);
								
								$this_rejecteded_recs = "";
								$this_rec_rejected = 0;
								$this_dup_count = 0;
								
								//echo "<pre>newArray : ";	print_r($newArray);	echo "</pre>";
								if(sizeof($newArray)== 21){
									
								$strQuery1 .= "(";
									
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
										}elseif($p==1)
										{
											$import_company_website = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$rep   = array("http://", "https://","www.","/");
											$import_company_website ="www.". str_replace($rep,'',$import_company_website);
											
											//echo "<br><br>import_company_website: ".$import_company_website;
											$website_validity = check_url($import_company_website);
											
											//echo "<br>website_validity: ".$website_validity;
											
											if($website_validity == 0)
											{
												$this_rejecteded_recs = "Company Website is not valid";
												$rec_rejected++;
												$this_rec_rejected++;
											}
											else
											{
												// Checking for duplicate
												
												//echo "<br><br>select company_id from ".TABLE_COMPANY_MASTER." where company_website='".$import_company_website."' OR company_name = '".$import_company_name."'";
												
												$isCompanyWebsite = com_db_GetValue("select company_id from ".TABLE_COMPANY_MASTER." where company_website='".$import_company_website."' OR company_name = '".$import_company_name."'");
												
												//echo "<br>After Q";
												
												if($isCompanyWebsite>0)
												{
													$dup_count++;
													$this_dup_count++;
													$dup_recs .= $isCompanyWebsite.":".$import_company_name."\n";
													 
												
												}
												//elseif($isCompanyWebsite == 0)
												else
												{
													$strQuery1 .= "'" . $import_company_website ."',";	
												}
											}
											
										}elseif($p==2 && $this_dup_count == 0){
											$import_company_logo = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$strQuery1 .= "'" . $import_company_logo ."',";
										}elseif($p==3 && $this_rec_rejected == 0 && $this_dup_count == 0){	
											$import_revenue_type = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$import_revenue_type = str_replace(' ', '', $import_revenue_type);

											if(strpos($import_revenue_type,"M") > -1)
												$import_revenue_type = str_replace("M"," Million",$import_revenue_type);
											elseif(strpos($import_revenue_type,">$1B") > -1)
											{
												$import_revenue_type = str_replace(">$1B",">$1 Billion",$import_revenue_type);		
											}
											elseif(strpos($import_revenue_type,"B") > -1)
												$import_revenue_type = str_replace("M"," Billion",$import_revenue_type);	
												
											
											//$revenue_size_id = com_db_GetValue("select id from " . TABLE_REVENUE_SIZE . " where name = '".$import_revenue_type."'");
											$revenue_size_id = array_search($import_revenue_type,$revenue_tbl_arr,true);
											
											if($revenue_size_id==''){
												$this_rejecteded_recs = "Company size revenue is not valid";
												$rec_rejected++;
												$this_rec_rejected++;
											}
											else
											{
												$strQuery1 .= "'" . $revenue_size_id ."',";
											}	
											
										}elseif($p==4 && $this_rec_rejected == 0 && $this_dup_count == 0){	
											$import_employee_size = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$import_employee_size = str_replace(' ', '', $import_employee_size);

											
											//$employee_size_id = com_db_GetValue("select id from " . TABLE_EMPLOYEE_SIZE. " where name = '".$import_employee_size."'");
											$employee_size_id = array_search($import_employee_size,$employee_tbl_arr,true);
											if($employee_size_id==''){
												
												$this_rejecteded_recs = "Company size is not valid";
												$rec_rejected++;
												$this_rec_rejected++;
											}
											else
											{
												$strQuery1 .= "'" . $employee_size_id ."',";
											}	
										}elseif($p==5 && $this_rec_rejected == 0 && $this_dup_count == 0){
											$tot_ind = explode(':',$newArray[$p]);
											$industry_invalid = 0;
											
											//$ind_group_id = com_db_GetValue("select industry_id from " . TABLE_INDUSTRY . " where title = '".str_replace(';',',',trim($tot_ind[0]))."'");
											if(sizeof($tot_ind)==2){
											
												//$ind_group_id = com_db_GetValue("select industry_id from " . TABLE_INDUSTRY . " where title = '".str_replace(';',',',trim($tot_ind[0]))."'");
												$ind_group_id = array_search(str_replace(';',',',trim($tot_ind[0])),$industry_tbl_arr,true);
												
												
												
												//$industry_id = com_db_GetValue("select industry_id from " . TABLE_INDUSTRY . " where title = '".str_replace(';',',',trim($tot_ind[1]))."'");
												$industry_id = array_search(str_replace(';',',',trim($tot_ind[1])),$industry_tbl_arr,true);
												
												$industry_name = com_db_output(str_replace(';',',', trim($tot_ind[1])));
												$industry_group_name = com_db_output(str_replace(';',',', trim($tot_ind[0])));
												if($ind_group_id =='' ){
													
													$industry_invalid = 1;
												}elseif($ind_group_id !='' && $industry_id ==''){
													
													
													$industry_name = $industry_group_name." Other";
													//$industry_id = com_db_GetValue("select industry_id from " . TABLE_INDUSTRY . " where title = '".$industry_name."'");
													$industry_id = array_search($industry_name,$industry_tbl_arr,true);
													
												}
											}else{
											
												
												$ind_group_id ='0';
												//$industry_id = com_db_GetValue("select industry_id from " . TABLE_INDUSTRY . " where title = '".str_replace(';',',',trim($tot_ind[0]))."'");
												
												$industry_id = array_search(str_replace(';',',',trim($tot_ind[0])),$industry_tbl_arr,true);
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
											
											
										}elseif($p==6 && $this_dup_count == 0){
											$import_email_pattern = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$strQuery1 .= "'" . $import_email_pattern ."',";
										}elseif($p==7 && $this_dup_count == 0){
											$import_leadership_page = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$strQuery1 .= "'" . $import_leadership_page ."',";
										}elseif($p==8 && $this_dup_count == 0){
											$import_address = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$strQuery1 .= "'" . $import_address ."',";
										}elseif($p==9 && $this_dup_count == 0){
											$import_address2 = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$strQuery1 .= "'" . $import_address2 ."',";	
										}elseif($p==10 && $this_dup_count == 0){
											$import_city = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$strQuery1 .= "'" . $import_city ."',";	
										}elseif($p==11 && $this_rec_rejected == 0 && $this_dup_count == 0){
											$import_country = com_db_input(str_replace(';',',',trim($newArray[$p])));
											
											//if($country_id==''){
											$import_country = strtoupper($import_country);
											if($import_country == 'UNITED STATES'){
												//$country_id = com_db_GetValue("select countries_id from " . TABLE_COUNTRIES . " where countries_iso_code_3 = '".$import_country."' or countries_name='".$import_country."'");
												$country_id = 223;
												$strQuery1 .= "'" . $country_id ."',";
											}
											elseif($import_country == 'CANADA')
											{
												$country_id = 38;
												$strQuery1 .= "'" . $country_id ."',";
											}
											else
											{		
												$this_rejecteded_recs = "Country is not valid";
												$rec_rejected++;
												$this_rec_rejected++;
											}	
										}elseif($p==12 && $this_rec_rejected == 0 && $this_dup_count == 0){
											$import_state = com_db_input(str_replace(';',',',trim($newArray[$p])));
											//$state_id = com_db_GetValue("select state_id from " . TABLE_STATE . " where short_name = '".$import_state."'");
											$state_id = array_search($import_state,$state_tbl_arr,true);
											if($state_id==''){

												
												$this_rejecteded_recs = "State is not valid";
												$rec_rejected++;
												$this_rec_rejected++;
												
											}
											else
											{
												$strQuery1 .= "'" . $state_id ."',";
											}
										}elseif($p==13 && $this_rec_rejected == 0 && $this_dup_count == 0){
											$import_zip_code = com_db_input(str_replace(';',',',trim($newArray[$p])));
											
											
											$replace_str = array("\'"); 
											$import_zip_code = str_replace($replace_str, "", $import_zip_code);
											

											if(strlen($import_zip_code) == 0 || strlen($import_zip_code) == 5)
											{
												$strQuery1 .= "'" . $import_zip_code ."',";
											}
											else
											{
												$this_rejecteded_recs = "Zip Code is not valid";
												$rec_rejected++;
												$this_rec_rejected++;
											}
											
										}elseif($p==14 && $this_rec_rejected == 0 && $this_dup_count == 0){
											$import_phone = com_db_input(str_replace(';',',',trim($newArray[$p])));
											if($import_phone == '')
												$phone_check = 1;
											else	
												$phone_check = check_phone($import_phone);
											if($phone_check == 1)
											{
												$strQuery1 .= "'" . $import_phone ."',";
											}
											else
											{
												$this_rejecteded_recs = "Phone is not valid";
												$rec_rejected++;
												$this_rec_rejected++;
											}

											
										}elseif($p==15 && $this_dup_count == 0){
											$import_fax = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$strQuery1 .= "'" . $import_fax ."',";
										}elseif($p==16 && $this_dup_count == 0){
											$import_about_company = com_db_input(str_replace(';',',',trim($newArray[$p])));
											if($import_about_company == '')
											{
												$import_about_company = $import_company_name." is a ".$import_city.", ".$import_state."-based company in the ".$industry_group_name." sector.";
											}
											$strQuery1 .= "'" . $import_about_company ."',";
										}elseif($p==17 && $this_rec_rejected == 0 && $this_dup_count == 0){
											$import_facebook_link = com_db_input(str_replace(';',',',trim($newArray[$p])));
											if($import_facebook_link == '' || strpos($import_facebook_link,"https://www.facebook.com") > -1 || strpos($import_facebook_link,"http://www.facebook.com") > -1)
											{	
												
												$strQuery1 .= "'" . $import_facebook_link ."',";
											}
											else
											{
												$this_rejecteded_recs = "Facebook link is not correct";
												$rec_rejected++;
												$this_rec_rejected++;
											}		

										}elseif($p==18 && $this_rec_rejected == 0 && $this_dup_count == 0){
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
										}elseif($p==19 && $this_rec_rejected == 0 && $this_dup_count == 0){
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
											
											
										}elseif($p==20 && $this_rec_rejected == 0 && $this_dup_count == 0){
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
									
									//$strQuery2 .= substr($strQuery1,0, -1);
									//$strQuery2 .= ",'".date('Y-m-d')."')";
									
									$strQuery1 .= "'".date('Y-m-d')."'),";
									
									

										if($this_dup_count > 0){
										
										//echo '<br>Total execution time in seconds duplicate case: ' . (microtime(true) - $time_start);
										
										}
										else
										if($this_rejecteded_recs != ''){
											$rejecteded_recs .= $import_company_name.":".$this_rejecteded_recs."\n";
											
										//echo '<br>Total execution time in seconds rejection case: ' . (microtime(true) - $time_start);	

										}
										else{ 
										
											$strQuery2 .= $strQuery1;
											$complete_subquery = $strQuery.$strQuery2;
											$complete_subquery = trim($complete_subquery,",");
											
											$rec_uploaded++;
											$uploaded_recs .= $insert_id.":".$import_company_name."\n";
											
											//$companyQuery = $strQuery.$strQuery2;
											
											
											
											//echo "<br><br>strQuery: ".$strQuery;
											
											//echo "<br><br>strQuery2: ".$strQuery2;
											
											//echo "<br><br>companyQuery: ".$companyQuery;
											
											
											
											//echo "<br>companyQuery: ".$companyQuery;
											
											$no_single_q = 1;
											if($no_single_q != 1)
											{
											
												com_db_query($companyQuery);
											
												//echo '<br>Total execution time in seconds after main insert: ' . (microtime(true) - $time_start);	
											
												$insert_id = com_db_insert_id();
											
												$comInsQuery = "insert into ".TABLE_COMPANY_MASTER."(company_id,company_name,company_website,company_logo,company_revenue,company_employee,company_industry,ind_group_id,industry_id,email_pattern,leadership_page,address,address2,city,country,state,zip_code,phone,fax,about_company,facebook_link,linkedin_link,twitter_link,googleplush_link,add_date)values('"
												.$insert_id."','".$import_company_name."','".$import_company_website."','".$import_company_logo."','".$revenue_size_id."','".$employee_size_id."','".$industry_id."','".$ind_group_id."','".$industry_id."','".$import_email_pattern."','".$import_leadership_page."','".$address."','".$address2."','".$import_city."','".$country_id."','".$state_id."','".$import_zip_code."',
												'".$import_phone."','".$import_fax."','".$import_about_company."','".$import_facebook_link."','".$import_linkedin_link."','".$import_twitter_link."','".$import_googleplush_link."','".date("Y-m-d")."')";
												
												com_db_query("insert into ". TABLE_COMPANY_UPDATE_INFO."(page_name,query_string,add_date) values('admin-company-import','".com_db_input($comInsQuery)."','".date("Y-m-d:H:i:s")."')");
												
												//echo '<br>Total execution time in seconds after company cron insert: ' . (microtime(true) - $time_start);	
											}
											
										}
										
									}else{
									 $msg = "Upload file format:      [X]";
									 //com_redirect("company-master-import.php?selected_menu=master&msg=" . msg_encode($msg));	
									 $import_company_name = com_db_input(str_replace(';',',',trim($newArray[0])));
									 
									 $rec_rejected++;
									 $this_rec_rejected++;
									 
									 $this_rejecteded_recs = "Row column numbers is ".sizeof($newArray)." but Import row required is 21 columns";
									 $rejecteded_recs .= $import_company_name.":".$this_rejecteded_recs."\n";
									 //echo "<br>FA Com rejection case: ".$import_company_name.":".$this_rejecteded_recs;
									 
									}
							}
							//$msg = "File successfully imported.";
							//echo "<br>END rec_rejected: ".$rec_rejected;
							//echo '<br><br>Total execution time in seconds after loop: ' . (microtime(true) - $time_start);
							
							if($strQuery2 != '')
							{
								$complete_query = $strQuery.$strQuery2;
								$complete_query = trim($complete_query,",");
								//echo "<br>complete_query: ".$complete_query;
								com_db_query($complete_query);
								
							}
							
							
							
							
							
							fwrite($dup_count_file,$dup_recs);
							
							fwrite($rec_uploaded_file,$uploaded_recs);
							
							fwrite($rec_rejected_file,$rejecteded_recs);
							
							$msg = "<table><tr><td colspan=3><strong>Status:</strong></td></tr><tr><td>Upload file format:</td><td colspan=2>[V]</td></tr>";
							$msg .= "<tr><td>Duplicates found:</td><td>".$dup_count."</td><td><a href=\"download-file.php?file_name=duplicates.csv\">File</a></td></tr>"; 
							$msg .= "<tr><td>Records uploaded:</td><td>     ".$rec_uploaded."</td><td><a href=\"download-file.php?file_name=rec_uploaded.csv\">File</a></td></tr>";
							$msg .= "<tr><td>Records rejected:</td><td>     ".$rec_rejected."</td><td><a href=\"download-file.php?file_name=rec_rejected.csv\">File</a></td></tr></table>";
							
							fclose($dup_count_file);
							fclose($rec_uploaded_file);
							fclose($rec_rejected_file);
							//echo '<br><br>Total execution time in seconds after file writing: ' . (microtime(true) - $time_start);
							//die("FA");
							//echo "<br>MSG: ".$msg;
							//com_redirect("company-master-import.php?selected_menu=master&msg=" . msg_encode($msg));	
							}
						else
							{
							$msg = "File not imported.";
							//com_redirect("company-master-import.php?selected_menu=master&msg=" . msg_encode($msg));	
							}	
						
						}else{
							$msg = "Please select the .CSV file.";
							//com_redirect("company-master-import.php?selected_menu=master&msg=" . msg_encode($msg));	
						}	
					}
				}
				else
				{
					$msg = "Please select file.";
					//com_redirect("company-master-import.php?selected_menu=master&msg=" . msg_encode($msg));
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
		
		  <form name="importfile" method="post" action="company-master-import-quick-bulk.php?selected_menu=master&action=save" enctype="multipart/form-data" onsubmit="return checkForm();">	
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