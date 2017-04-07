<?php

require('../includes/configuration.php');
include('../includes/only_dataentry_include-top.php');

$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 20;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';

if($action == 'SearchResult'){
	$company_name		= $_POST['search_company_name'];
	$company_url		= $_POST['search_company_url'];
	$industry 			= $_POST['search_industry'];
	$state				= $_POST['search_state'];
	$country			= $_POST['search_country'];
	$from_date			= $_POST['from_date'];
	$to_date 			= $_POST['to_date'];
	$company_revenue 	= $_POST['search_company_revenue'];
	$company_employee	= $_POST['search_company_employee'];
	
	$search_qry='';
	if($company_name!=''){
		$search_qry .= " c.company_name = '".$company_name."'";
	}
	if($company_url!=''){
		if($search_qry==''){
			$search_qry .= " c.company_website = '".$company_url."'";
		}else{
			$search_qry .= " and c.company_website = '".$company_url."'";
		}	
	}
	if($industry!=''){
		if($search_qry==''){
			$search_qry .= " c.industry_id ='".$industry."'";
		}else{
			$search_qry .= " and c.industry_id ='".$industry."'";
		}	
	}
	
	if($state!=''){
		if($search_qry==''){
			$search_qry .= " c.state = '".$state."'";
		}else{
			$search_qry .= " and c.state = '".$state."'";
		}	
	}
	if($country!=''){
		if($search_qry==''){
			$search_qry .= " c.country = '".$country."'";
		}else{
			$search_qry .= " and c.country = '".$country."'";
		}	
	}
	
	if($from_date!='' && strlen($from_date)==10 && $to_date !='' && strlen($to_date)==10){
		$fdt = explode('/',$from_date);
		$fdate = $fdt[2].'-'.$fdt[0].'-'.$fdt[1];
		$tdt = explode('/',$to_date);
		$tdate = $tdt[2].'-'.$tdt[0].'-'.$tdt[1];
		if($search_qry==''){
			$search_qry .= " c.add_date >= '".$fdate."' and c.add_date <='".$tdate."'";
		}else{
			$search_qry .= " and c.add_date >= '".$fdate."' and c.add_date <='".$tdate."'";
		}
	}
	if($company_revenue!=''){
		if($search_qry==''){
			$search_qry .= " c.company_revenue = '".$company_revenue."'";
		}else{
			$search_qry .= " and c.company_revenue = '".$company_revenue."'";
		}	
	}
	if($company_employee!=''){
		if($search_qry==''){
			$search_qry .= " c.company_employee = '".$company_employee."'";
		}else{
			$search_qry .= " and c.company_employee = '".$company_employee."'";
		}	
	}

	if($search_qry==''){
		$sql_query = "select c.company_id,c.company_name,c.company_website,c.status,c.add_date from " . TABLE_COMPANY_MASTER . " as c order by c.company_id desc";
	}else{
		$sql_query = "select c.company_id,c.company_name,c.company_website,c.status,c.add_date from " . TABLE_COMPANY_MASTER . " as c where  ". $search_qry." order by c.company_id desc";
	}	
}else{
	$sql_query = "select c.company_id,c.company_name,c.company_website,c.status,c.add_date from " . TABLE_COMPANY_MASTER . " as c order by c.company_id desc";
}
//echo $sql_query;		
/***************** FOR PAGIN ***********************/
$starting_point = $items_per_page * ($p - 1);
/****************** END PAGIN ***********************/
$main_page = 'company.php';




$cID = (isset($_GET['cID']) ? $_GET['cID'] : $select_data[0]);

    switch ($action) {
		
	  case 'delete':
	   		
			com_db_query("delete from " . TABLE_COMPANY_MASTER . " where company_id = '" . $cID . "'");
			com_db_query("delete from " . TABLE_MOVEMENT_MASTER . " where company_id = '" . $cID . "'");
			com_db_query("delete from " . TABLE_COMPANY_JOB_INFO . " where company_id = '" . $cID . "'");
			$det_srt= "delete from " . TABLE_COMPANY_MASTER . " where company_id = '" . $cID . "'";
			com_db_query("insert into ".TABLE_COMPANY_UPDATE_INFO."(page_name,query_string,add_date) values('dataentry-company','".com_db_input($det_srt)."','".date("Y-m-d:H:i:s")."')");
			$del_mov_srt= "delete from " . TABLE_MOVEMENT_MASTER . " where company_id = '" . $cID . "'";
			com_db_query("insert into ".TABLE_MOVEMENT_UPDATE_INFO."(page_name,query_string,add_date) values('dataentry-company','".com_db_input($del_mov_srt)."','".date("Y-m-d:H:i:s")."')");
			
			com_db_query("delete from " . TABLE_COMPANY_WEBSITES . " where company_id = '" . $cID . "'");
			
			com_db_query("delete from " . TABLE_COMPANY_FUNDING . " where company_id = '" . $cID . "'");
			
			com_redirect("company.php?p=" . $p . "&msg=" . msg_encode("Company deleted successfully"));
		
		break;
		
	  case 'jobdelete':
			$job_id = $_REQUEST['cjID'];
			com_db_query("delete from " . TABLE_COMPANY_JOB_INFO . " where company_id = '" . $cID . "' and job_id='".$job_id."'");
		 	com_redirect("company.php?action=detailes&cID=".$cID);
		
		break;	
			
	  case 'edit':
     		
	   		$query_edit=com_db_query("select * from " . TABLE_COMPANY_MASTER . " where company_id = '" . $cID . "'");
	  		$data_edit=com_db_fetch_array($query_edit);
			
			$company_id = com_db_output($data_edit['company_id']);
			$company_name = com_db_output($data_edit['company_name']);
			$company_website = rtrim(com_db_output($data_edit['company_website']));
			$company_logo = com_db_output($data_edit['company_logo']);
			$company_revenue = com_db_output($data_edit['company_revenue']);
			$company_employee = com_db_output($data_edit['company_employee']);
			$company_industry = com_db_output($data_edit['company_industry']);
			
			$address = com_db_output($data_edit['address']);
			$address2 = com_db_output($data_edit['address2']);
			$city = com_db_output($data_edit['city']);
			$state = com_db_output($data_edit['state']);
			$country = com_db_output($data_edit['country']);
			$zip_code = com_db_output($data_edit['zip_code']);
			$phone = com_db_output($data_edit['phone']);
			$fax = com_db_output($data_edit['fax']);
			
			$about_company = $data_edit['about_company'];
			$leadership_page = com_db_output($data_edit['leadership_page']);
			$email_pattern = com_db_output($data_edit['email_pattern']); 
			$email_pattern_id = com_db_output($data_edit['email_pattern_id']); 
                        
                        $email_domain = com_db_output($data_edit['email_domain']); 
			
			$facebook_link = com_db_output($data_edit['facebook_link']);
			$linkedin_link = com_db_output($data_edit['linkedin_link']);
			$twitter_link = com_db_output($data_edit['twitter_link']);
			$googleplush_link = com_db_output($data_edit['googleplush_link']);
			$demo_job = com_db_output($data_edit['demo_job']);
			$demo_email_funding = com_db_output($data_edit['demo_funding']);
			//echo "<br>FAR Undo demo_email_funding:".$demo_email_funding;
			$websiteQuery = "select website from ".TABLE_COMPANY_JOB_WEBSITE." where company_id='".$cID."'";
			$wsResult = com_db_query($websiteQuery);
			$wsArray = array();
			while($wsRow = com_db_fetch_array($wsResult)){
				$wsArray[] = $wsRow['website'];
			}
			
			
			$websiteExeQuery = "select website from ".TABLE_COMPANY_EXECUTIVE_JOB_WEBSITE." where company_id='".$cID."'";
			$bsResult = com_db_query($websiteExeQuery);
			$bsArray = array();
			while($bsRow = com_db_fetch_array($bsResult)){
			
				$bsArray[] = $bsRow['website'];
			}
			
			$websiteFundingQuery = "select website from ".TABLE_COMPANY_FUNDING_WEBSITE." where company_id='".$cID."'";
			
			$wfResult = com_db_query($websiteFundingQuery);
			$wfArray = array();
			while($wfRow = com_db_fetch_array($wfResult)){
			
				$wfArray[] = $wfRow['website'];
			}
			
			
			$company_www = array();
			$sql_comp_www = "select company_website from " . TABLE_COMPANY_WEBSITES . " where company_id = '".$cID."'";
			$exe_query_comp_www = com_db_query($sql_comp_www);
			while($data_sql_comp_www = com_db_fetch_row($exe_query_comp_www)){
				$company_www[] = $data_sql_comp_www[0];
				
			}
			$jobsNumQuery = "select count(*) as company_ids_num from ".TABLE_COMPANY_EXECUTIVE_JOB_INFO." where company_id='".$cID."'";
			
			$jnResult = com_db_query($jobsNumQuery);
			$jnRow = com_db_fetch_array($jnResult);
			$company_job_count = $jnRow['company_ids_num'];
			if($company_job_count > 0)
				$buyside_job = 1;
			
			
		break;	
		
		case 'editsave':
			$buyside_job = 	$_POST['buyside_job'];
			$demo_email_funding = $_POST['demo_email_funding'];
			
			$company_name = com_db_input($_POST['company_name']);
			$company_website = rtrim(com_db_input($_POST['company_website']));
			$rep   = array("http://", "https://","www.","/");
			$company_website ="www.". str_replace($rep,'',$company_website);
			$company_revenue = com_db_input($_POST['company_revenue']);
			$company_employee = com_db_input($_POST['company_employee']);
			$company_industry = com_db_input($_POST['company_industry']);
			$industry_id = $company_industry;
			$ind_group_id = com_db_GetValue("select parent_id from " . TABLE_INDUSTRY . " where industry_id = '".$company_industry."'");
			
			$address = com_db_input($_POST['address']);
			$address2 = com_db_input($_POST['address2']);
			$city = com_db_input($_POST['city']);
			$state = com_db_input($_POST['state']);
			$country = com_db_input($_POST['country']);
			$zip_code = com_db_input($_POST['zip_code']);
			$phone = com_db_input($_POST['phone']);
			$fax = com_db_input($_POST['fax']);

			$about_company = strip_tags($_POST['about_company']);
			$leadership_page = com_db_output($_POST['leadership_page']);
			$email_pattern = com_db_output($_POST['email_pattern']); 
			
			$facebook_link = com_db_input($_POST['facebook_link']);
			$linkedin_link = com_db_input($_POST['linkedin_link']);
			$twitter_link = com_db_input($_POST['twitter_link']);
			$googleplush_link = com_db_input($_POST['googleplush_link']);
			
			$demo_job = 	$_POST['demo_job'];
			$ctositename = 	$_POST['ctositename'];	
			
			$ctositenameFunding = 	$_POST['ctositenameFunding'];
			$ctositenameBuyside = 	$_POST['ctositenameBuyside'];	
			
			$create_by = $_SESSION['user_login_name'];
			$login_id = $_SESSION['user_login_id'];
			$modify_date = date('Y-m-d');
                        
                        
                        $current_email_domain = $_POST['hidden_email_domain'];	
                        echo "<br>current_email_domain: ".$current_email_domain;
                        $email_domain_update = "";
                        if($current_email_domain == '')
                        {    
                            $extracted_domain = get_domain($company_website);
                            $email_domain_update = ",email_domain='".$extracted_domain."'";
                        }    
                        //echo "<br>extracted_domain: ".$extracted_domain;
                        //echo "<br>email_domain_update: ".$email_domain_update;
			
			$query = "update " . TABLE_COMPANY_MASTER . " set company_name = '" . $company_name ."', company_website='".$company_website."', company_revenue = '".$company_revenue."', company_employee = '".$company_employee."', company_industry = '".$company_industry."',  ind_group_id = '".$ind_group_id."', industry_id = '".$industry_id."',
			leadership_page ='".$leadership_page."',email_pattern_id = '".$email_pattern."', address = '" . $address ."', address2 = '".$address2."', city = '".$city."', state = '".$state."', country = '".$country."', zip_code = '".$zip_code."', phone = '".$phone."',fax = '".$fax."',
			about_company = '".$about_company."', facebook_link = '".$facebook_link."', linkedin_link = '".$linkedin_link."', twitter_link = '".$twitter_link."', googleplush_link = '".$googleplush_link."',demo_job='".$demo_job."', modify_date = '".$modify_date."',create_by='".$create_by."',admin_id='".$login_id."',demo_funding='".$demo_email_funding."'$email_domain_update where company_id = '" . $cID . "'";
			//echo "<br>query: ".$query;
                        
                        com_db_query($query);
			
			com_db_query("insert into ".TABLE_COMPANY_UPDATE_INFO."(page_name,query_string,add_date) values('dataentry-company','".com_db_input($query)."','".date("Y-m-d:H:i:s")."')");
			
			
			// Editting multiple websites
			// delete current this company urls
			com_db_query("delete from " . TABLE_COMPANY_WEBSITES . " where company_id = '" . $cID . "'");
			
			$total_sec_www = count($_POST['secondary_websites']);
                        
                        $merge_secondary_companies = array();
                        
			if(isset($_POST['secondary_websites']))
			{
				$total_sec_www = count($_POST['secondary_websites']);
				for($cw=0; $cw < $total_sec_www ;$cw++)
				{
					if($_POST['secondary_websites'][$cw] != '')
					{
						$company_website = $_POST['secondary_websites'][$cw];
                                                
                                                // Check whether this website already exist or not - For merge feature
                                                $this_company_id = com_db_GetValue("select company_id from " . TABLE_COMPANY_MASTER . " where company_website = '".$company_website."'");
                                                echo "<br>Q to find existance of secondary company: ".$this_company_id;
                                                if($this_company_id != '')
                                                {
                                                    $merge_secondary_companies[] = $this_company_id;
                                                }    
                                                
                                                
						com_db_query("insert into ".TABLE_COMPANY_WEBSITES." (company_id,company_website) values('".$cID."','".$company_website."')");
						
					}	
				}
				
			}
                        echo "<pre>merge_secondary_companies: ";   print_r($merge_secondary_companies);   echo "</pre>";
                        
                        
			
			$image = $_FILES['company_logo']['tmp_name'];
			  
			if($image!=''){
				if(is_uploaded_file($image)){
					$org_img = $_FILES['company_logo']['name'];
					$exp_file = explode("." , $org_img);
					$get_ext = $exp_file[count($exp_file) - 1];
					if(strtolower($get_ext)=="jpg" || strtolower($get_ext)=="gif" || strtolower($get_ext)=="jpeg" || strtolower($get_ext)=="png"){
						$new_exp_file = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''),$exp_file[0]);
						$org_image_name = $new_exp_file.'-'.time().'.'.$get_ext;
						$destination_image = '../company_logo/org/' . $org_image_name;
						if(move_uploaded_file($image , $destination_image)){
							$org_size=getimagesize($destination_image);
							$width=$org_size[0];
							if($width > 150) {
								$t_width=150;
								$ex_width=$org_size[0]-150;	
								$per_width=$ex_width/$org_size[0]*100;
								$height=$org_size[1];
								$ex_height=$height/100*$per_width;
								$t_height=$height-$ex_height;
							} else {
								$t_width=$org_size[0];
								$t_height=$org_size[1];
							}
							
							$thumb_image='../company_logo/thumb/' . $org_image_name;
							make_thumb($destination_image, $thumb_image,$t_width,$t_height);
							
							if($width > 120) {
								$t_width=120;
								$ex_width=$org_size[0]-120;	
								$per_width=$ex_width/$org_size[0]*100;
								$height=$org_size[1];
								$ex_height=$height/100*$per_width;
								$t_height=$height-$ex_height;
							} else {
								$t_width=$org_size[0];
								$t_height=$org_size[1];
							}
							
							$small_image='../company_logo/small/' . $org_image_name;
							make_thumb($destination_image, $small_image,$t_width,$t_height);
							
							$query = "UPDATE " . TABLE_COMPANY_MASTER . " SET company_logo = '" . $org_image_name . "' WHERE company_id = '" . $cID."'";
							com_db_query($query);
							com_db_query("insert into ".TABLE_COMPANY_UPDATE_INFO."(page_name,query_string,add_date) values('dataentry-company','".com_db_input($query)."','".date("Y-m-d:H:i:s")."')");
						}
					}	
				}	
			}
			//Job insert
			$job_title_arr = $_POST['job_title'];
			$post_date_arr = $_POST['post_date'];
			$location_arr = $_POST['location'];
			$source_arr = $_POST['source'];
			$description_arr = $_POST['description'];
			com_db_query("delete from ".TABLE_COMPANY_JOB_INFO." where company_id='".$cID."'");
			
			// Need to delete executive email jobs from DB
			com_db_query("delete from ".TABLE_COMPANY_EXECUTIVE_JOB_INFO." where company_id='".$cID."'");
			
			for($j=0; $j<sizeof($job_title_arr);$j++){
				$job_title 	= $job_title_arr[$j];

				$pst_date 	= explode("/",$post_date_arr[$j]);//mmddyyyy
				$post_date 	= $pst_date[2]."-".$pst_date[0]."-".$pst_date[1];
				
				$location	= $location_arr[$j];
				$source		= $source_arr[$j];
				$rep   = array("\r\n", "\n","\r");
				$description = str_replace($rep,'<br />',$description_arr[$j]);
				$status = '0';
				$add_date = date('Y-m-d');
				if($job_title !=''){
					$query = "insert into " . TABLE_COMPANY_JOB_INFO . "
					(company_id, job_title, description, location, post_date, add_date, status,source) 
					values ('$cID', '$job_title', '$description', '$location', '$post_date','$add_date','$status','$source')";
					com_db_query($query);
					
					if($buyside_job == 1)
					{
						$query = "insert into " . TABLE_COMPANY_EXECUTIVE_JOB_INFO . "
					(company_id, job_title, description, location, post_date, add_date, status,source) 
					values ('$cID', '$job_title', '$description', '$location', '$post_date','$add_date','$status','$source')";
					com_db_query($query);
					}
				}
			}
			
			//Funding insert
				$funding_date_arr = $_POST['funding_date'];
				$amount_arr = $_POST['funding_amount'];
				$source_arr = $_POST['funding_source'];

				$added_funding_ids = array();
				com_db_query("delete from " . TABLE_COMPANY_FUNDING . " where company_id = '" . $cID . "'");
				
				for($j=0; $j<sizeof($funding_date_arr);$j++){
					$funding_pst_date 	= explode('/',$funding_date_arr[$j]);//mmddyyyy
					$funding_date 	= $funding_pst_date[2].'-'.$funding_pst_date[0].'-'.$funding_pst_date[1];
					$funding_amount	= $amount_arr[$j];
					$funding_source		= $source_arr[$j];
					
					$status = 1;
					$funding_add_date = date('Y-m-d');
					if($funding_amount !='' && $funding_date != '' && $funding_source != ''){
							$query = "insert into " . TABLE_COMPANY_FUNDING . "
							(company_id, funding_date,funding_amount, funding_add_date, status,funding_source) 
							values ('$cID', '$funding_date', '$funding_amount','$add_date','$status','$funding_source')";
							com_db_query($query);
							
							$funding_insert_id = com_db_insert_id();
							$added_funding_ids[] = $funding_insert_id;
					}
				}
			
			
				com_db_query("delete from ".TABLE_COMPANY_JOB_WEBSITE." where company_id='".$cID."'");
				for($cn=0; sizeof($ctositename) > $cn ;$cn++){
					com_db_query("insert into ".TABLE_COMPANY_JOB_WEBSITE." (company_id,website) values('".$cID."','".$ctositename[$cn]."')");
				}
				
				
				
				com_db_query("delete from ".TABLE_COMPANY_FUNDING_WEBSITE." where company_id='".$cID."'");
				for($cf=0; sizeof($ctositenameFunding) > $cf ;$cf++){
					for($af=0; sizeof($added_funding_ids) > $af ;$af++){
						com_db_query("insert into ".TABLE_COMPANY_FUNDING_WEBSITE." (company_id,funding_id,website) values('".$cID."','".$added_funding_ids[$af]."','".$ctositenameFunding[$cf]."')");
					}	
				}
				com_db_query("delete from ".TABLE_COMPANY_EXECUTIVE_JOB_WEBSITE." where company_id='".$cID."'");	
				for($cbs=0; sizeof($ctositenameBuyside) > $cbs ;$cbs++){
				
					com_db_query("insert into ".TABLE_COMPANY_EXECUTIVE_JOB_WEBSITE." (company_id,website) values('".$cID."','".$ctositenameBuyside[$cbs]."')");
				}
                                
                                
                                // Merge feature
                                if(sizeof($merge_secondary_companies) > 0)
                                {
                                    // changing secondary companies jobs to primary company
                                    foreach($merge_secondary_companies as $index => $second_comp_id)
                                    {    
                                        $merge_jobs_query = "UPDATE " . TABLE_COMPANY_JOB_INFO . " set company_id = '" . $cID . "' WHERE company_id = '" . $second_comp_id."'";
                                        echo "<br>Updating jobs for merge: ".$merge_jobs_query;
                                        com_db_query($merge_jobs_query);
                                        
                                        
                                        $merge_funding_query = "UPDATE " . TABLE_COMPANY_FUNDING . " set company_id = '" . $cID . "' WHERE company_id = '" . $second_comp_id."'";
                                        echo "<br>Updating fundings for merge: ".$merge_funding_query;
                                        com_db_query($merge_funding_query);
                                        
                                        $merge_move_query = "UPDATE " . TABLE_MOVEMENT_MASTER . " set company_id = '" . $cID . "' WHERE company_id = '" . $second_comp_id."'";
                                        echo "<br>Updating move for merge: ".$merge_move_query;
                                        com_db_query($merge_move_query);
                                        
                                        
                                        // Adding in table so that other sites also get updated with this change
                                        $comp_update_query = "UPDATE " . TABLE_MOVEMENT_MASTER . " set company_id = '" . $cID . "' WHERE company_id = '" . $second_comp_id."'";
                                        echo "<br>comp_update_query: ".$comp_update_query;
                                        com_db_query("insert into ".TABLE_MOVEMENT_UPDATE_INFO."(page_name,query_string,add_date) values('dataentry-company','".com_db_input($comp_update_query)."','".date("Y-m-d:H:i:s")."')");
                                        
                                        
                                    }    
                                }
                                
                                
                                
			
	  		com_redirect("company.php?p=". $p ."&cID=" . $cID . "&msg=" . msg_encode("Company update successfully"));
		 
		break;		
	case 'addsave':
			
			$buyside_job = 	$_POST['buyside_job'];	
			$demo_email_funding = $_POST['demo_email_funding'];
			
			$company_name = com_db_input($_POST['company_name']);
			$company_website = rtrim(com_db_input($_POST['company_website']));
			$rep   = array("http://", "https://","www.","/");
			$company_website ="www.". str_replace($rep,'',$company_website);
			$company_revenue = com_db_input($_POST['company_revenue']);
			$company_employee = com_db_input($_POST['company_employee']);
			$company_industry = com_db_input($_POST['company_industry']);
			$industry_id = $company_industry;
			$ind_group_id = com_db_GetValue("select parent_id from " . TABLE_INDUSTRY . " where industry_id = '".$company_industry."'");
			
			$address = com_db_input($_POST['address']);
			$address2 = com_db_input($_POST['address2']);
			$city = com_db_input($_POST['city']);
			$state = com_db_input($_POST['state']);
			$country = com_db_input($_POST['country']);
			$zip_code = com_db_input($_POST['zip_code']);
			$phone = com_db_input($_POST['phone']);
			$fax = com_db_input($_POST['fax']);
			
			$about_company = strip_tags($_POST['about_company']);
			$leadership_page = com_db_output($_POST['leadership_page']);
			$email_pattern = com_db_output($_POST['email_pattern']); 
			
			$facebook_link = com_db_input($_POST['facebook_link']);
			$linkedin_link = com_db_input($_POST['linkedin_link']);
			$twitter_link = com_db_input($_POST['twitter_link']);
			$googleplush_link = com_db_input($_POST['googleplush_link']);
			$demo_job = 	$_POST['demo_job'];
			$ctositename = 	$_POST['ctositename'];	
			
			$ctositenameFunding = 	$_POST['ctositenameFunding'];
			$ctositenameBuyside = 	$_POST['ctositenameBuyside'];			
			
			$publish = '0';
			
			$create_by = $_SESSION['user_login_name'];
			$login_id = $_SESSION['user_login_id'];
			$status = '0';
			$add_date = date('Y-m-d');
			
                        $extracted_domain = get_domain($company_website);
                        
			$isCompanyPresent = com_db_GetValue("select company_id from ".TABLE_COMPANY_MASTER." where company_website='".$company_website."'");
			if($isCompanyPresent ==''){
				$query = "insert into " . TABLE_COMPANY_MASTER . "
				(company_name, company_website, company_revenue, company_employee, company_industry, ind_group_id, industry_id,leadership_page,email_pattern_id, address, address2, city, state, country, zip_code, phone, fax, about_company, facebook_link ,linkedin_link ,twitter_link, googleplush_link,demo_job, add_date, create_by,admin_id, status,demo_funding,email_domain) 
				values ('$company_name', '$company_website', '$company_revenue', '$company_employee', '$company_industry', '$ind_group_id', '$industry_id', '$leadership_page','$email_pattern','$address', '$address2', '$city', '$state', '$country', '$zip_code','$phone','$fax','$about_company','$facebook_link','$linkedin_link','$twitter_link','$googleplush_link','$demo_job','$add_date','$create_by','$login_id','$status','$demo_email_funding','$extracted_domain')";
				com_db_query($query);
				$insert_id = com_db_insert_id();
				
				$companyQuery = "insert into " . TABLE_COMPANY_MASTER . "
				(company_id,company_name, company_website, company_revenue, company_employee, company_industry, ind_group_id, industry_id,leadership_page,email_pattern_id, address, address2, city, state, country, zip_code, phone, fax, about_company, facebook_link ,linkedin_link ,twitter_link, googleplush_link,demo_job, add_date, create_by,admin_id, status,demo_funding) 
				values ('$insert_id','$company_name', '$company_website', '$company_revenue', '$company_employee', '$company_industry', '$ind_group_id', '$industry_id', '$leadership_page','$email_pattern','$address', '$address2', '$city', '$state', '$country', '$zip_code','$phone','$fax','$about_company','$facebook_link','$linkedin_link','$twitter_link','$googleplush_link','$demo_job','$add_date','$create_by','$login_id','$status','$demo_email_funding')";
				
				com_db_query("insert into ".TABLE_COMPANY_UPDATE_INFO."(page_name,query_string,add_date) values('dataentry-company','".com_db_input($companyQuery)."','".date("Y-m-d:H:i:s")."')");
				
				for($cn=0; sizeof($ctositename) > $cn ;$cn++){
					com_db_query("insert into ".TABLE_COMPANY_JOB_WEBSITE." (company_id,website) values('".$insert_id."','".$ctositename[$cn]."')");
				}
				
				for($cf=0; sizeof($ctositenameFunding) > $cf ;$cf++){
					com_db_query("insert into ".TABLE_COMPANY_FUNDING_WEBSITE." (company_id,website) values('".$insert_id."','".$ctositenameFunding[$cf]."')");
				}
				
				for($cbs=0; sizeof($ctositenameBuyside) > $cbs ;$cbs++){
					com_db_query("insert into ".TABLE_COMPANY_EXECUTIVE_JOB_WEBSITE." (company_id,website) values('".$insert_id."','".$ctositenameBuyside[$cbs]."')");
				}
				
				// Adding multiple websites
				$total_sec_www = count($_POST['secondary_websites']);
				if(isset($_POST['secondary_websites']))
				{
                                    $total_sec_www = count($_POST['secondary_websites']);
                                    for($cw=0; $cw < $total_sec_www ;$cw++)
                                    {
                                        if($_POST['secondary_websites'][$cw] != '')
                                        {
                                            $company_website = $_POST['secondary_websites'][$cw];

                                             // Check whether this website already exist or not - For merge feature
                                            $this_company_id = com_db_GetValue("select company_id from " . TABLE_COMPANY_MASTER . " where company_website = '".$company_website."'");
                                            echo "<br>Q to find existance of secondary company: ".$this_company_id;
                                            if($this_company_id != '')
                                            {
                                                $merge_secondary_companies[] = $this_company_id;
                                            }

                                            com_db_query("insert into ".TABLE_COMPANY_WEBSITES." (company_id,company_website) values('".$insert_id."','".$company_website."')");
                                        }	
                                    }
				}
				
				$image = $_FILES['company_logo']['tmp_name'];
				if($image!=''){
					if(is_uploaded_file($image)){
						$org_img = $_FILES['company_logo']['name'];
						$exp_file = explode("." , $org_img);
						$get_ext = $exp_file[count($exp_file) - 1];
						if(strtolower($get_ext)=="jpg" || strtolower($get_ext)=="gif" || strtolower($get_ext)=="jpeg" || strtolower($get_ext)=="png"){
							$new_exp_file = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''),$exp_file[0]);
							$org_image_name = $new_exp_file.'-'.time().'.'.$get_ext;
							$destination_image = '../company_logo/org/' . $org_image_name;
							if(move_uploaded_file($image , $destination_image)){
								$org_size=getimagesize($destination_image);
								$width=$org_size[0];
								if($width > 150) {
									$t_width=150;
									$ex_width=$org_size[0]-150;	
									$per_width=$ex_width/$org_size[0]*100;
									$height=$org_size[1];
									$ex_height=$height/100*$per_width;
									$t_height=$height-$ex_height;
								} else {
									$t_width=$org_size[0];
									$t_height=$org_size[1];
								}
								
								$thumb_image='../company_logo/thumb/' . $org_image_name;
								make_thumb($destination_image, $thumb_image,$t_width,$t_height);
								
								if($width > 120) {
									$t_width=120;
									$ex_width=$org_size[0]-120;	
									$per_width=$ex_width/$org_size[0]*100;
									$height=$org_size[1];
									$ex_height=$height/100*$per_width;
									$t_height=$height-$ex_height;
								} else {
									$t_width=$org_size[0];
									$t_height=$org_size[1];
								}
								
								$small_image='../company_logo/small/' . $org_image_name;
								make_thumb($destination_image, $small_image,$t_width,$t_height);
								
								$query = "UPDATE " . TABLE_COMPANY_MASTER . " SET company_logo = '" . $org_image_name . "' WHERE company_id = '" . $insert_id ."'";
								com_db_query($query);
								com_db_query("insert into ".TABLE_COMPANY_UPDATE_INFO."(page_name,query_string,add_date) values('dataentry-company','".com_db_input($query)."','".date("Y-m-d:H:i:s")."')");
							}
						}	
					}	
				}
				//Job insert
				$job_title_arr = $_POST['job_title'];
				$post_date_arr = $_POST['post_date'];
				$location_arr = $_POST['location'];
				$source_arr = $_POST['source'];
				$description_arr = $_POST['description'];
				for($j=0; $j<sizeof($job_title_arr);$j++){
					$job_title 	= $job_title_arr[$j];
					$pst_date 	= explode('/',$post_date_arr[$j]);//mmddyyyy
					$post_date 	= $pst_date[2].'-'.$pst_date[0].'-'.$pst_date[1];
					$location	= $location_arr[$j];
					$source		= $source_arr[$j];
					$rep   = array("\r\n", "\n","\r");
					$description = str_replace($rep,'<br />',$description_arr[$j]);
					$status = '0';
					$add_date = date('Y-m-d');
					if($job_title !=''){
						$query = "insert into " . TABLE_COMPANY_JOB_INFO . "
						(company_id, job_title, description, location, post_date, add_date, status,source) 
						values ('$insert_id', '$job_title', '$description', '$location', '$post_date','$add_date','$status','$source')";
						com_db_query($query);
						
						
						if($buyside_job == 1)
						{
							$query = "insert into " . TABLE_COMPANY_EXECUTIVE_JOB_INFO . "
						(company_id, job_title, description, location, post_date, add_date, status,source) 
						values ('$insert_id', '$job_title', '$description', '$location', '$post_date','$add_date','$status','$source')";
						com_db_query($query);
						}
					}
				}
				
				//Funding insert
				
				$funding_date_arr = $_POST['funding_date'];
				$amount_arr = $_POST['funding_amount'];
				$source_arr = $_POST['funding_source'];
				
				for($j=0; $j<sizeof($funding_date_arr);$j++){
					
					$funding_pst_date 	= explode('/',$funding_date_arr[$j]);//mmddyyyy
					$funding_date 	= $funding_pst_date[2].'-'.$funding_pst_date[0].'-'.$funding_pst_date[1];
					$funding_amount	= $amount_arr[$j];
					$funding_source		= $source_arr[$j];
					
					$status = 1;
					$add_date = date('Y-m-d');
					if($funding_amount !='' && $funding_date != '' && $funding_source != ''){
						$query = "insert into " . TABLE_COMPANY_FUNDING . "
						(company_id, funding_date,funding_amount, funding_add_date, status,funding_source) 
						values ('$insert_id', '$funding_date', '$funding_amount','$add_date','$status','$funding_source')";
						com_db_query($query);
					}
				}
                                
                                
                                // Merge feature
                                if(sizeof($merge_secondary_companies) > 0)
                                {
                                    // changing secondary companies jobs to primary company
                                    foreach($merge_secondary_companies as $index => $second_comp_id)
                                    {    
                                        $merge_jobs_query = "UPDATE " . TABLE_COMPANY_JOB_INFO . " set company_id = '" . $insert_id . "' WHERE company_id = '" . $second_comp_id."'";
                                        echo "<br>Updating jobs for merge: ".$merge_jobs_query;
                                        com_db_query($merge_jobs_query);
                                        
                                        
                                        $merge_funding_query = "UPDATE " . TABLE_COMPANY_FUNDING . " set company_id = '" . $insert_id . "' WHERE company_id = '" . $second_comp_id."'";
                                        echo "<br>Updating fundings for merge: ".$merge_funding_query;
                                        com_db_query($merge_funding_query);
                                        
                                        $merge_move_query = "UPDATE " . TABLE_MOVEMENT_MASTER . " set company_id = '" . $insert_id . "' WHERE company_id = '" . $second_comp_id."'";
                                        echo "<br>Updating move for merge: ".$merge_move_query;
                                        com_db_query($merge_move_query);
                                        
                                        
                                        // Adding in table so that other sites also get updated with this change
                                        $comp_update_query = "UPDATE " . TABLE_MOVEMENT_MASTER . " set company_id = '" . $insert_id . "' WHERE company_id = '" . $second_comp_id."'";
                                        echo "<br>comp_update_query: ".$comp_update_query;
                                        com_db_query("insert into ".TABLE_MOVEMENT_UPDATE_INFO."(page_name,query_string,add_date) values('dataentry-company','".com_db_input($comp_update_query)."','".date("Y-m-d:H:i:s")."')");
                                        
                                        
                                    }    
                                }
                                
                                
                                
                                
				
				com_redirect("company.php?p=" . $p . "&msg=" . msg_encode("company added successfully"));
			 }else{
				com_redirect("company.php?p=" . $p . "&msg=" . msg_encode("company already present"));
		  	}
		break;	
		
	case 'detailes':
			$query_edit ="select c.company_name,c.company_website,c.company_logo,r.name as company_revenue,e.name as company_employee,
							i.title as company_industry,c.address,c.address2,c.city,s.short_name as state,
							ct.countries_name as country,c.zip_code,c.phone,c.fax,c.about_company,c.leadership_page,c.email_pattern,c.facebook_link,c.linkedin_link,c.twitter_link,c.googleplush_link,c.add_date from " 
							.TABLE_COMPANY_MASTER. " as c, " 
							.TABLE_REVENUE_SIZE." as r, "
							.TABLE_EMPLOYEE_SIZE." as e, "
							.TABLE_INDUSTRY." as i, "
							.TABLE_STATE." as s, "
							.TABLE_COUNTRIES." as ct							
							where c.company_revenue=r.id and c.company_employee=e.id and c.company_industry=i.industry_id and c.state=s.state_id and c.country=ct.countries_id and c.company_id = '" . $cID . "'";
			
			$query_edit_result=com_db_query($query_edit);
	  		$data_edit=com_db_fetch_array($query_edit_result);
			
			$company_name = com_db_output($data_edit['company_name']);
			$company_website = com_db_output($data_edit['company_website']);
			$company_logo = com_db_output($data_edit['company_logo']);
			$company_revenue = com_db_output($data_edit['company_revenue']);
			$company_employee = com_db_output($data_edit['company_employee']);
			$company_industry = com_db_output($data_edit['company_industry']);
						
			$address = com_db_output($data_edit['address']);
			$address2 = com_db_output($data_edit['address2']);
			$city = com_db_output($data_edit['city']);
			$state = com_db_output($data_edit['state']);
			$country = com_db_output($data_edit['country']);
			$zip_code = com_db_output($data_edit['zip_code']);
			$phone = com_db_output($data_edit['phone']);
			$fax = com_db_output($data_edit['fax']);
			
			$leadership_page = com_db_output($data_edit['leadership_page']);
			$email_pattern = com_db_output($data_edit['email_pattern']); 
			$about_company = $data_edit['about_company'];
			
			$facebook_link = com_db_output($data_edit['facebook_link']);
			$linkedin_link = com_db_output($data_edit['linkedin_link']);
			$twitter_link = com_db_output($data_edit['twitter_link']);
			$googleplush_link = com_db_output($data_edit['googleplush_link']);
			
			$add_date =explode('-',$data_edit['add_date']);
			
		break;	
		
	  case 'activate':
     		
	   		$status=$_GET['status'];
			if($status==0){
				$query = "update " . TABLE_COMPANY_MASTER . " set status = '1' where company_id = '" . $cID . "'";
			}else{
				$query = "update " . TABLE_COMPANY_MASTER . " set status = '0' where company_id = '" . $cID . "'";
			}	
			com_db_query($query);
			com_db_query("insert into ".TABLE_COMPANY_UPDATE_INFO."(page_name,query_string,add_date) values('dataentry-company','".com_db_input($query)."','".date("Y-m-d:H:i:s")."')");
	  		com_redirect("company.php?p=". $p ."&cID=" . $cID . "&msg=" . msg_encode("Company update successfully"));
			
		break;	
    }
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CTOsOnTheMove.com</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />

<link rel="shortcut icon" href="../images/favicon.jpg" type="image/x-icon" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
<link href="style.css" rel="stylesheet" type="text/css" />


<!--<link rel="stylesheet" href="css/ui-lightness/jquery-ui-1.10.3.custom.min.css" type="text/css" media="all" /> -->
<link rel="stylesheet" href="css/chosen.css" type="text/css" media="all" />

<!--
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css' />
<link href='http://fonts.googleapis.com/css?family=Bitter:400,400italic,700' rel='stylesheet' type='text/css' />
-->
<!-- <script type="text/javascript" src="ckeditor/ckeditor.js"></script> -->


<script language="javascript">

function confirm_del(nid,p){
	var agree=confirm("Company will be deleted. \n Do you want to continue?");
	if (agree)
		window.location = "company.php?selected_menu=master&cID=" + nid + "&p=" + p + "&action=delete";
	else
		window.location = "company.php?selected_menu=master&cID=" + nid + "&p=" + p ;
}

function confirm_job_delete(cid,jid){
	var agree=confirm("Company job will be deleted. \n Do you want to continue?");
	if (agree)
		window.location = "company.php?cID="+cid+"&cjID=" + jid + "&action=jobdelete";
	else
		window.location = "company.php?cID=" + cid + "&action=detailes";
}

function confirm_artivate(nid,p,status){
	if(status=='1'){
		var msg="Company will be active. \n Do you want to continue?";
	}else{
		var msg="Company will be Inactive. \n Do you want to continue?";
	}
	var agree=confirm(msg);
	if (agree)
		window.location = "company.php?cID=" + nid + "&p=" + p + "&status=" + status + "&action=activate";
	else
		window.location = "company.php?cID=" + nid + "&p=" + p ;
}
</script>


</head>
<body>
<!--
<div id="light" class="white_content" style="display:<? if($action=='CompanySearch'){ echo 'block';} else { echo 'none'; } ?>; height:auto;">
		<div id="spiffycalendar" class="text"></div>
		<link rel="stylesheet" type="text/css" href="includes/javascript/spiffyCal/spiffyCal_v2_1.css">
		<script language="JavaScript" src="includes/javascript/spiffyCal/spiffyCal_v2_1.js"></script>
		<script language="javascript">
		  var dateAvailableFrom = new ctlSpiffyCalendarBox("dateAvailableFrom", "frmSearch", "from_date","btnDate1","",scBTNMODE_CUSTOMBLUE);
		  var dateAvailableTo = new ctlSpiffyCalendarBox("dateAvailableTo", "frmSearch", "to_date","btnDate2","",scBTNMODE_CUSTOMBLUE);	
		</script>
		<form name="frmSearch" id="frmSearch" method="post" action="company.php?action=SearchResult">
		<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1">
		  <tr>
			<td align="left" colspan="2" valign="top">
				
			</td>
		  </tr>
          <tr><td colspan="2">&nbsp;</td></tr>
		  <tr>
			<td align="left" valign="top" >Company Name:</td>
			<td align="left" valign="top"><input name="search_company_name" id="search_company_name" /></td>
		  </tr>
		  <tr>
			<td align="left" valign="top">Company Url:</td>
			<td align="left" valign="top"><input name="search_company_url" id="search_company_url" /></td>
		  </tr>
		  
		  <tr>
			<td align="left" valign="top">Industry:</td>
			<td align="left" valign="top">
				<?php
				//$industry_result = com_db_query("select * from " . TABLE_INDUSTRY ." where status='0' and parent_id = '0' order by title");
				?>
				<select name="search_industry" id="search_industry" >
					<option value="">All</option>
					<?php
					//while($indus_row = com_db_fetch_array($industry_result)){
					?>
					<optgroup label="<? //=$indus_row['title']?>">
					<? //=selectComboBox("select industry_id,title from ". TABLE_INDUSTRY ." where status='0' and parent_id ='".$indus_row['industry_id']."' order by title" ,"");?>
					</optgroup>
					<? //} ?>
					
				</select>
			</td>
		  </tr>
		  <tr>
			<td align="left" valign="top">State:</td>
			<td align="left" valign="top">
				<select name="search_state" id="search_state" >
					<option value="">All</option>
					<? //=selectComboBox("select state_id,short_name from ". TABLE_STATE ." where country_id ='223'" ,"");?>
				</select>	
			</td>
		  </tr>
          <tr>
			<td align="left" valign="top">Country:</td>
			<td align="left" valign="top">
				<select name="search_country" id="search_country" >
					<option value="">All</option>
					<? //=selectComboBox("select countries_id,countries_name from ". TABLE_COUNTRIES ." where countries_name='United States'" ,"");?>
					<? //=selectComboBox("select countries_id,countries_name from ". TABLE_COUNTRIES ." order by countries_name" ,"");?>
				</select>	
			</td>
		  </tr>
		  
		  <tr>
			<td align="left" valign="top">Date Entered:</td>
			<td align="left" valign="top">
				From:<script language="javascript">dateAvailableFrom.writeControl(); dateAvailableFrom.dateFormat="MM/dd/yyyy";</script>
			</td>
		  </tr>
		   <tr>
			<td align="center" valign="top">&nbsp;</td>
			<td align="left" valign="top">
				To:&nbsp;&nbsp;&nbsp;<script language="javascript">dateAvailableTo.writeControl(); dateAvailableTo.dateFormat="MM/dd/yyyy";</script>
			</td>
		  </tr>
		  
		  <tr>
			<td align="left" valign="top">Size ($ Revenue):</td>
			<td align="left" valign="top">
				<select name="search_company_revenue" id="search_company_revenue"/>
                	<option value="">All</option>
					<? //=selectComboBox("select id,name from ".TABLE_REVENUE_SIZE." where status='0' order by from_range",'')?>
                </select>	
			</td>
		  </tr>
          <tr>
			<td align="left" valign="top">Size (Employees):</td>
			<td align="left" valign="top">
				<select name="search_company_employee" id="search_company_employee" />
                	<option value="">All</option>
					<? //=selectComboBox("select id,name from ".TABLE_EMPLOYEE_SIZE." where status='0' order by from_range",'')?>
                </select>	
			</td>
		  </tr>
		   <tr>
			<td align="center" valign="top">&nbsp;</td>
			<td align="center" valign="top">&nbsp;</td>
		  </tr>
		  <tr>
			<td align="center" valign="top">&nbsp;</td>
		  	<td align="left" valign="top"><input type="submit" value="Search" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='company.php'" /></td>
		  </tr>
		  <tr>
			<td align="center" valign="top">&nbsp;</td>
			<td align="center" valign="top">&nbsp;</td>
		  </tr>
		</table>
		</form>
	</div>
	<div id="fade" class="black_overlay" style="display:<? //if($action=='CompanySearch'){ echo 'block';} else { echo 'none'; } ?>;"></div>
-->


<table width="1002" border="0" align="center" cellpadding="0" cellspacing="0">

  <tr>
    <td width="21" align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">
        <table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center" valign="top" class="top-header-bg">
                <table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top">
                        <? include_once("includes/top-menu.php"); ?>
                    </td>
                  </tr>
                  <tr>
                    <td align="center" valign="top"><table width="928" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="196" align="left" valign="top"><a href="company.php"><img src="<?=HTTP_SERVER.DIR_WS_HTTP_FOLDER.DIR_IMAGES?>logo.jpg"  alt="Logo" width="196" height="32" border="0" title="Logo" /></a></td>
                        <td width="478" align="left" valign="top">&nbsp;</td>
                        <td width="254" align="right" valign="top" >
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="login-register-text"><a href="#"><strong><?=$_SESSION['user_login_name']?></strong></a> | <a href="logout.php"><strong>Logout</strong></a>				</tr>
                            </table>
                        </td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                   <td align="left" valign="top" class="caption-text">We Enable You to Sell More IT Faster by Providing Unique, Responsive and Actionable Sales Leads</td>
                  </tr>
                  <tr>
                    <td align="right" valign="top">
                        <table width="95%" height="33" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="81%" align="center" valign="middle"><span class="right-box-title-text"><?=$msg?></span></td>
                              
                              <td width="3%" align="right" valign="middle"><a href="#"><img src="images/search-icon.jpg" border="0" width="25" height="28"  alt="Search Contact" title="Search Contact" onclick="CompanySearch('CompanySearch');"  /></a></td>
                              <td width="5%" align="left" valign="middle" class="nav-text">Search</td>
                              <!--<td align="left" valign="middle"><a href="#"><img src="images/folder-icon.jpg" border="0" width="22" height="22" alt="Directory" title="Directory" onclick="window.location='company.php?action=Directory'"  /></a></td>
                              <td align="left" valign="middle" class="nav-text">Directory</td> -->
                              <td width="3%" align="right" valign="middle"><a href="#"><img src="<?=HTTP_SERVER.DIR_WS_HTTP_FOLDER.DIR_IMAGES?>add-icon.jpg" border="0" width="25" height="28" alt="Add Contact" title="Add Contact" onclick="window.location='company.php?action=add'"  /></a></td>
                              <td width="8%" align="left" valign="middle" class="nav-text">Add New</td>
                            </tr>
                        </table>
                    </td>
                  </tr>
                </table>
            </td>
          </tr>
        </table>
    </td>
    <td width="21" align="left" valign="top">&nbsp;</td>
  </tr>
  
    <tr>
      <td align="left"  valign="top">&nbsp;</td>
      <td align="center" valign="top"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" valign="top"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td align="left" valign="middle" class="advance-search-page-heading-bg"><table width="960" border="0" align="left" cellpadding="0" cellspacing="0">
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle" class="press-release-page-title-text">Company : </td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><img src="<?=HTTP_SERVER.DIR_WS_HTTP_FOLDER.DIR_IMAGES?>specer.gif" width="1" height="10" alt="" title="" /></td>
                  </tr>
              
              </table></td>
            </tr>
          </table></td>
        </tr>
        <?PHP 
        if($action=='Directory' || $action =='save' || $action=='SearchResult'){	

        $exe_query=com_db_query($sql_query);
        $num_rows=com_db_num_rows($exe_query);
        $total_data = $num_rows;

        /************ FOR PAGIN **************/
        $sql_query .= " LIMIT $starting_point,$items_per_page";
        $exe_data = com_db_query($sql_query);

        $numRows = com_db_num_rows($exe_data);
        /************ END ********************/


        ?>	
        <tr>
          <td align="center" valign="top">
		  
		  <form name="topicform" id="topicform" method="post" action="company.php?action=alldelete&p=<?=$p?>">
		  	<table width="100%" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="51" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-title-text">#</span></td>
				<td width="265" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Company Name</span></td>
				<td width="165" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Company URL</span></td>
                <td width="150" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">#Job</span></td>
                <td width="169" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Date</span> </td>
                <td width="158" height="30" align="center" valign="middle" class="left-border"><div align="center"><span class="right-box-title-text">Action</span></div></td>
			  </tr>
			<?php
			
			if($total_data>0) {
				$i=1;
				while ($data_sql = com_db_fetch_array($exe_data)) {
				$add_date = $data_sql['add_date'];
				$status = $data_sql['status'];
				$job_count = com_db_GetValue("select count(job_id) from " . TABLE_COMPANY_JOB_INFO . " where company_id='".$data_sql['company_id']."'");
			?>          
			  <tr>
				<td height="30" align="center" valign="middle" class="right-border-left"><?=$i;?></td>
				<td height="30" align="left" valign="middle" class="right-border-text">&nbsp;<a href="company.php?action=detailes&p=<?=$p?>&cID=<?=$data_sql['company_id'];?>"><?=com_db_output($data_sql['company_name'])?></a></td>
                <td height="30" align="left" valign="middle" class="right-border-text">&nbsp;<?=com_db_output($data_sql['company_website'])?></td>
                <td height="30" align="left" valign="middle" class="right-border-text">&nbsp;<?=$job_count;?></td>
                <td height="30" align="center" valign="middle" class="right-border">&nbsp;<?=$add_date;?></td>
				<td height="30" align="center" valign="middle" class="left-border">
					<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr>
                      	<?	if($status==0){ ?>
					   	<td width="18%" align="center" valign="middle"><a href="#"><img src="images/icon/active-icon.gif" width="16" height="16" alt="" title="" border="0" onclick="confirm_artivate('<?=$data_sql['company_id'];?>','<?=$p;?>','<?=$status;?>');" /></a><br />
					   	  Status</td>
					   	<? } elseif($status==1){ ?>
					   	<td width="16%" align="center" valign="middle"><a href="#"><img src="images/icon/inactive-icon.gif" width="16" height="16" alt="" title="" border="0" onclick="confirm_artivate('<?=$data_sql['company_id'];?>','<?=$p;?>','<?=$status;?>');" /></a><br />
					   	  Status</td>
						<? } ?> 
					   	<td width="50%" align="center" valign="middle" class="actionText"><a href="#"><img src="images/small-edit-icon.gif" width="16" height="16" alt="Edit" title="Edit" border="0" onclick="window.location='company.php?&p=<?=$p;?>&cID=<?=$data_sql['company_id'];?>&action=edit'" /></a><br />
						  Edit</td>
						<td width="50%" align="center" valign="middle" class="actionText"><a href="#"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" title="Delete" border="0" onclick="confirm_del('<?=$data_sql['company_id'];?>','<?=$p;?>')" /></a><br />
						  Delete</td>
					  </tr>
					</table>
               </td>
         	</tr> 
			<?php
			$i++;
				}
			
			}
			?>     
         </table>
		  </form>
		  <br />
		  </td>
        </tr>
		
		<tr>
			<td align="left" valign="top" class="pagination-text">
			<?php echo number_pages($main_page, $p, $total_data, 8, $items_per_page,'&action=Directory&items_per_page='.$items_per_page);?>
			<br /><br />
	  		</td>
		</tr>
	
	<? }elseif($action=='add' || $action ==''){ ?>
		<tr>
          <td align="center" valign="top">
		 

		 
          <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" style="background-color:#CCC;height:30px;">
              <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="left" valign="middle" class="heading-text">Company Manager :: Add Company</td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="left" valign="top" class="right-border-box">
		 <!--start iner table  -->
		  <form name="frmDataAdd" id="frmDataAdd" method="post" action="company.php?action=addsave" enctype="multipart/form-data" onsubmit="return  chk_form_Add();">
		  <table width="95%" align="left" cellpadding="5" cellspacing="5" border="0">
			
            <tr>
			  <td align="left" class="heading-text-a">>> Company</td>	
			</tr>
            <tr>
			  <td align="left">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Company Website:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="company_website" id="company_website" size="30" onblur="CompanyIsPresent();" />  
						<?PHP
						//if($_GET['multiple'] == 1)
						//{
						?>
						&nbsp;<br><div style="margin-top:10px;cursor:pointer;color:#064962;text-decoration:underline;" onclick="show_mul_www()" class="page-text" id="add_multiple_websites">Click to add multiple websites</div>  
						<?PHP
						//}
						?>
						<div id="multiple_websites" class="page-text" style="display:none;float:left;width:100%; margin-top:10px;margin-bottom:10px;">Number of Websites: <select id="num_of_www" onchange="show_fields('','','','','')"><option value="0">Select</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option></select></div>
						<div id="multiple_websites_form"></div>
					
						<div id="CompanyAlreadyPresent" style="display:none;"></div>
                      	<div id="div_company_website" style="display:none;color:#993300;font-family:Verdana, Arial, Helvetica, sans-serif;">Please wait...</div>					  </td>	
                    
					
					</tr>
					<tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Company Name:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="company_name" id="company_name" size="30" value="" /> </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Company Logo:</td>
                      <td width="75%" align="left" valign="top"><div id="divCompanyLogo">
                      <input type="file" name="company_logo" id="company_logo" />
                      </div>
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Size ($Revenue):</td>
                      <td width="75%" align="left" valign="top">
                        <div id="div_company_revenue">
							<select name="company_revenue" id="company_revenue" style="width:206px;">
							<?=selectComboBox("select id,name from ".TABLE_REVENUE_SIZE." where status='0' order by from_range","")?>
							<option value="Any">Any</option>
							</select>
						</div>                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Size (Employees):</td>
                      <td width="75%" align="left" valign="top">
                        <div id="div_company_employee">
							<select name="company_employee" id="company_employee" style="width:206px;">
							<?=selectComboBox("select id,name from ".TABLE_EMPLOYEE_SIZE ." where status='0' order by from_range","")?>
							<option value="Any">Any</option>
							</select>
						 </div>					  </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Industry:</td>
                      <td width="75%" align="left" valign="top">
                        <div id="div_company_industry">
						<?php
						$industry_result = com_db_query("select * from " . TABLE_INDUSTRY ." where status='0' and parent_id = '0' order by title");
						?>
						<select name="company_industry" id="company_industry" >
							<option value="">All</option>
							<?php
							while($indus_row = com_db_fetch_array($industry_result)){
							?>
							<optgroup label="<?=$indus_row['title']?>">
							<?=selectComboBox("select industry_id,title from ". TABLE_INDUSTRY ." where status='0' and parent_id ='".$indus_row['industry_id']."' order by title" ,"");?>
							</optgroup>
							<? } ?>
							<option value="Any">Any</option>
						</select>
						</div>                      </td>	
                    </tr>
                    <tr>
                      <td align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Leadership Page:</td>
                      <td align="left" valign="top"><input type="text" name="leadership_page" id="leadership_page" size="30" value="" /></td>
                    </tr>
                  </table>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a">>> Location</td>	
			</tr>
            <tr>
			  <td align="left">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Address:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="address" id="address" size="30" value="" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Address 2:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="address2" id="address2" size="30" value="" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;City:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="city" id="city" size="30" value="" />
                      </td>	
                    </tr>
					<tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Country:</td>
                      <td width="75%" align="left" valign="top">
						<div id="div_country">
							<select name="country" id="country" style="width:206px;" onchange="StateChangeAdd('country');">
							<?=selectComboBox("select countries_id,countries_name from ".TABLE_COUNTRIES."  where countries_id=223",'223')?>
							<?=selectComboBox("select countries_id,countries_name from ".TABLE_COUNTRIES."  where countries_id<>223 order by countries_name",'')?>
							<option value="Any">Any</option>
							</select>
						</div>
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;State:</td>
                      <td width="75%" align="left" valign="top">
					    <div id="div_state_add">
							<select name="state" id="state" style="width:206px;">
							<?=selectComboBox("select state_id,short_name from ".TABLE_STATE." order by short_name","")?>
							<option value="Any">Any</option>
							</select>
						</div>
                      </td>	
                    </tr>
                    
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Zip Code:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="zip_code" id="zip_code" size="30" value="" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Phone:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="phone" id="phone" size="30" value="" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Fax:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="fax" id="fax" size="30" value="" />
                      </td>	
                    </tr>
                  </table>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a">>> Company Details</td>	
			</tr>
            <tr>
			  <td align="left">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;About the Company?:</td>
                      <td width="75%" align="left" valign="top">
                        <textarea  id="about_company" name="about_company" style="width:236px; height:100px;"></textarea>
						<script type="text/javascript">
                        //<![CDATA[
                            //CKEDITOR.replace('about_company');
                        //]]>
                        </script>
                      </td>	
                    </tr>
                  </table>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a">>> Social Media Profiles</td>	
			</tr>
            <tr>
			  <td align="left">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                      <!--
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Facebook Link:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="facebook_link" id="facebook_link" size="30" value="" /></td>	
                    </tr>
                      -->
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;LinkedIn Link:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="linkedin_link" id="linkedin_link" size="30" value="" /></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Twitter Link:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="twitter_link" id="twitter_link" size="30" value="" /></td>	
                    </tr>
                      
                      <!--
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Google+ Link:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="googleplush_link" id="googleplush_link" size="30" value="" /></td>	
                    </tr>
                      -->
                  </table>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a">>> Company Job Information</td>	
			</tr>
            <tr>
			  <td align="left" style="padding-left:25px;">
              	  	<input type="hidden" value="0" id="theValue" />
                    <div id="myDiv"> </div>
                    <p><a href="javascript:;" onClick="addEvent();">Add Job Info</a></p>
              </td>	
			</tr>
            <tr>
			  <td align="right" style="color: #064962;font-family: Arial;font-size:13px;font-weight:bold;padding-right:150px;">
              	<input type="checkbox" name="demo_job" id="demo_job" value="1" <? if ($demo_job==1){echo 'checked="checked"';} ?> onclick="JobTiggerOnOff();" /> Add to demo?
				&nbsp;&nbsp;
				<input type="checkbox" name="buyside_job" id="buyside_job" value="1" <? if ($buyside_job==1){echo 'checked="checked"';} ?>  onclick="ExecutiveJobTiggerOnOff();" /> Add to buyside demo
				
				</td>
            </tr>
            <tr>
                <td align="right" style="color: #064962;font-family: Arial;font-size:13px;font-weight:bold;padding-right:150px;">
              	<div id="divWebsiteTigger" style="display:<? if ($demo_job==1){echo 'block';}else{echo 'none';}?>;">
                	<div class="row">
                        <select name="ctositename[]" id="ctositename" class="websitename" multiple data-placeholder="Please select website">
                            <option value="CTO">CTO</option>
                            <option value="CLO">CLO</option>
                            <option value="CMO">CMO</option>
                            <option value="CFO">CFO</option>
                            <option value="HR">HR</option>
                        </select>
                    </div><!-- /.row -->
                </div>  
				
				
				
				<div id="divBuysideWebsiteTigger" style="display:<? if ($buyside_job==1){echo 'block';}else{echo 'none';}?>;">
                	<div class="row">
                        <select name="ctositenameBuyside[]" id="ctositenameBuyside" class="websitename" multiple data-placeholder="Please select website">
                            <option value="CTO">CTO Buyside</option>
                            <option value="CLO">CLO Buyside</option>
                            <option value="CMO">CMO Buyside</option>
                            <option value="CFO">CFO Buyside</option>
                            <option value="HR">HR Buyside</option>
                        </select>
                    </div><!-- /.row -->
                </div>  
				
				
              </td>	
			</tr>
			
			<!-- Funding rows starts -->
			<tr>
			  <td align="left" class="heading-text-a">>> Funding Information</td>	
			</tr>
            <tr>
			  <td align="left" style="padding-left:25px;">
              		
              	  	<input type="hidden" value="0" id="theFundingValue" />
                    <div id="myFundingDiv"> </div>
                    <p><a href="javascript:;" onClick="addFunding();">Add Funding Info</a></p>
              </td>	
			</tr>
            <tr>
			  <td align="right" style="color: #064962;font-family: Arial;font-size:13px;font-weight:bold;padding-right:150px;">
              	
				
				<input type="checkbox" name="demo_email_funding" id="demo_email_funding" value="1" <? if ($demo_email_funding==1){echo 'checked="checked"';} ?> onclick="fundingTiggerOnOff();" /> Add to demo? <!--   -->
				
				</td>
            </tr>
			
			
			<tr>
                <td align="right" style="color: #064962;font-family: Arial;font-size:13px;font-weight:bold;padding-right:150px;">
              	<div id="divFundingWebsiteTigger" style="display:<? if ($demo_job==1){echo 'block';}else{echo 'none';}?>;">
                	<div class="row">
                        <select name="ctositenameFunding[]" id="ctositenameFunding" class="websitename" multiple data-placeholder="Please select website">
                            <option value="CTO">CTO</option>
                            <option value="CLO">CLO</option>
                            <option value="CMO">CMO</option>
                            <option value="CFO">CFO</option>
                            <option value="HR">HR</option>
                        </select>
                    </div><!-- /.row -->
                </div>  
              </td>	
			</tr>
			
			
			<!-- Funding rows ends -->
			
            <tr>
            	<td align="center">
                	<table width="50%" border="0" cellpadding="4" cellspacing="4">
                    	<tr><td><input type="submit" value="Add Company" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='company.php?p=<?=$p;?>&uID=<?=$uID;?>&selected_menu=master'" /></td></tr>
                    </table>
                </td>
             </tr>
            
			</table>
		  </form>
		 <!-- end inner table -->
		  </td>
		 </tr>
            </table></td>
		 </tr>
        </table>
		  
		  </td>
        </tr>
	<? }elseif($action=='edit'){ ?>
		<tr>
          <td align="center" valign="top">
          		
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" style="background-color:#CCC;height:30px;">
              <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="left" valign="middle" class="heading-text">Company Manager :: Edit Company </td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top"  class="right-bar-content-border-box"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="celter" valign="top">
		 <!--start iner table  -->
		  <form name="frmDataEdit" id="frmDataEdit" method="post" enctype="multipart/form-data" action="company.php?action=editsave&cID=<?=$cID;?>&p=<?=$p;?>" onsubmit="return  chk_form();">
		  <input type="hidden" name="hidden_email_domain" id="hidden_email_domain" value="<?=$email_domain?>">
                  <table width="95%" align="center" cellpadding="5" cellspacing="5" border="0">
			
            <tr>
			  <td align="left">
              	 <div id="div_company" style="display:block;">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Company Website:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="company_website" id="company_website" size="30" readonly="readonly" value="<?=$company_website;?>"/>
						
						&nbsp;<br><div style="margin-top:10px;cursor:pointer;color:#064962;text-decoration:underline;" onclick="show_mul_www()" class="page-text" id="add_multiple_websites">Click to add multiple websites</div>  
						<?PHP
						if(count($company_www) == 0)
							$blk_display = "none";
						else	
							$blk_display = "block";
						?>
						<div id="multiple_websites" class="page-text" style="display:<?=$blk_display?>;float: left; width: 100%; margin-top: 10px; margin-bottom: 10px;">Number of Websites: <select id="num_of_www" onchange="show_fields('<?=$company_www[0]?>','<?=$company_www[1]?>','<?=$company_www[2]?>','<?=$company_www[3]?>','<?=$company_www[4]?>')">
							<option value="0">Select</option><option <? if(count($company_www) == 1) echo "selected"; else echo ""; ?> value="1">1</option><option <? if(count($company_www) == 2) echo "selected"; else echo ""; ?>  value="2">2</option><option <? if(count($company_www) == 3) echo "selected"; else echo ""; ?>  value="3">3</option><option <? if(count($company_www) == 4) echo "selected"; else echo ""; ?> value="4">4</option><option <? if(count($company_www) == 5) echo "selected"; else echo ""; ?> value="5">5</option></select>
						</div>
						
						<div id="multiple_websites_form">
							<?PHP
							if(count($company_www[0]) != '')
							{
							?>
							<div class="page-text" style="margin-top:10px;">Enter secondary website: <input value="<?=$company_www[0]?>" type="text" name="secondary_websites[]"></div>
							<?PHP
							}
							if(count($company_www[1]) != '')
							{
							?>
							<div class="page-text" style="margin-top:10px;">Enter secondary website: <input value="<?=$company_www[1]?>" type="text" name="secondary_websites[]"></div>
							<?PHP
							}
							if(count($company_www[2]) != '')
							{
							?>
							<div class="page-text" style="margin-top:10px;">Enter secondary website: <input value="<?=$company_www[2]?>" type="text" name="secondary_websites[]"></div>
							<?PHP
							}
							if(count($company_www[3]) != '')
							{
							?>
							<div class="page-text" style="margin-top:10px;">Enter secondary website: <input value="<?=$company_www[3]?>" type="text" name="secondary_websites[]"></div>
							<?PHP
							}
							if(count($company_www[4]) != '')
							{
							?>
							<div class="page-text" style="margin-top:10px;">Enter secondary website: <input value="<?=$company_www[4]?>" type="text" name="secondary_websites[]"></div>
							<?PHP
							}
							?>
						</div>
						
                      </td>
                    </tr>
					<tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp; Company Name:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="company_name" id="company_name" size="30" value="<?=$company_name;?>"/>
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Company Logo:</td>
                      <td width="75%" align="left" valign="top">
                      <img src="../company_logo/small/<?=$company_logo?>" alt="Logo" /><br />
                      <input type="file" name="company_logo" id="company_logo" /></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Size ($Revenue):</td>
                      <td width="75%" align="left" valign="top">
                     	<select name="company_revenue" id="company_revenue" style="width:206px;"/>
						<?=selectComboBox("select id,name from ".TABLE_REVENUE_SIZE." where status='0' order by from_range",$company_revenue)?>
						<option value="Any">Any</option>
						</select>
					 </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Size (Employees):</td>
                      <td width="75%" align="left" valign="top">
                      	<select name="company_employee" id="company_employee" style="width:206px;"/>
						<?=selectComboBox("select id,name from ".TABLE_EMPLOYEE_SIZE." where status='0' order by from_range",$company_employee)?>
						<option value="Any">Any</option>
						</select>
					  </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Industry:</td>
                      <td width="75%" align="left" valign="top">
                      	<?php
						$industry_result = com_db_query("select * from " . TABLE_INDUSTRY ." where parent_id = '0' and status='0' order by title");
						?>
						<select name="company_industry" id="company_industry" multiple="multiple">
							<option value="">All</option>
							<?php
							while($indus_row = com_db_fetch_array($industry_result)){
							?>
							<optgroup label="<?=$indus_row['title']?>">
							<?=selectComboBox("select industry_id,title from ". TABLE_INDUSTRY ." where parent_id ='".$indus_row['industry_id']."' and status='0' order by title" ,$company_industry);?>
							</optgroup>
							<? } ?>
							<option value="Any">Any</option>
						</select>
					  </td>	
                    </tr>
					<tr>
                      <td align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Leadership Page:</td>
                      <td align="left" valign="top"><input type="text" name="leadership_page" id="leadership_page" size="30" value="<?=$leadership_page?>" /></td>
                    </tr>
                  </table>
                  </div>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a">>> Location</td>	
			</tr>
            <tr>
			  <td align="left">
              	<div id="div_location" style="display:block;">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Address:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="address" id="address" size="30" value="<?=$address;?>"/>
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Address 2:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="address2" id="address2" size="30" value="<?=$address2;?>"/>
                      </td>
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;City:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="city" id="city" size="30" value="<?=$city;?>"/>
                      </td>	
                    </tr>
					<tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Country:</td>
                      <td width="75%" align="left" valign="top">
					   <select name="country" id="country" style="width:206px;" onchange="StateChangeEdit('country');"/>
					   	<?=selectComboBox("select countries_id,countries_name from ". TABLE_COUNTRIES ." where countries_id='223'",$country);?>
						<?=selectComboBox("select countries_id,countries_name from ".TABLE_COUNTRIES." order by countries_name",$country)?>
						<option value="Any">Any</option>
						</select>
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;State:</td>
                      <td width="75%" align="left" valign="top">
					  <div id="div_state_edit">
						<select name="state" id="state" style="width:206px;"/>
						<?=selectComboBox("select state_id,short_name from ".TABLE_STATE." where country_id='".$country."' order by short_name",$state)?>
						<option value="Any">Any</option>
						</select>
					  </div> 	
                      </td>	
                    </tr>
                    
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Zip Code:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="zip_code" id="zip_code" size="30" value="<?=$zip_code;?>"/>
                      </td>
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Phone:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="phone" id="phone" size="30" value="<?=$phone;?>"/>
                      </td>
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Fax:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="fax" id="fax" size="30" value="<?=$fax;?>"/>
                      </td>
                    </tr>
                  </table>
                  </div>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a">>> Company Details</td>	
			</tr>
            <tr>
			  <td align="left">
              	<div id="div_change_details" style="display:block;">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                
                    <tr>
                      <td width="26%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;About the Company?:</td>
                      <td width="74%" align="left" valign="top">
                        <textarea  id="about_company" name="about_company" style="width:236px; height:100px;"><?=$about_company?></textarea>
						<script type="text/javascript">
                        //<![CDATA[
                            //CKEDITOR.replace('about_company');
                        //]]>
                        </script>
                      </td>
                     </tr>
					
					
                  </table>
                  </div>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a">>> Social Media Profiles</td>	
			</tr>
            <tr>
			  <td align="left">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                      <!--
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Facebook Link:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="facebook_link" id="facebook_link" size="30" value="<?=$facebook_link?>" /></td>	
                    </tr>
                      -->
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;LinkedIn Link:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="linkedin_link" id="linkedin_link" size="30" value="<?=$linkedin_link?>" /></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Twitter Link:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="twitter_link" id="twitter_link" size="30" value="<?=$twitter_link?>" /></td>	
                    </tr>
                      <!--
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Google+ Link:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="googleplush_link" id="googleplush_link" size="30" value="<?=$googleplush_link?>" /></td>	
                    </tr>
                      -->
                  </table>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a">>> Company Job Information</td>	
			</tr>
            <tr>
			  <td align="left" style="padding-left:25px;">
              		<input type="hidden" value="<?=$job;?>" id="theValue" />
              		<div id="myDiv">
              		<? 
					$JobQuery = "select * from ".TABLE_COMPANY_JOB_INFO." where company_id='".$company_id."'";
					$JobResult = com_db_query($JobQuery);
					if($JobResult){
						$job_num_row = com_db_num_rows($JobResult);
					}
					$job=0;
					while($jobRow = com_db_fetch_array($JobResult)){
					
					$jpd = explode('-',$jobRow['post_date']);
					$job_post_date = $jpd[1].'/'.$jpd[2].'/'.$jpd[0];
					//=$jobRow['post_date']
					?>
                    <div id="my<?=$job?>Div">
              		<table width="100%" cellpadding="2" cellspacing="2" border="0">
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Job Title:</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="job_title[]" value="<?=$jobRow['job_title'];?>" /></td>	
                         </tr>
                         <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Posted Date:</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="post_date[]" id="post_date<?=$job;?>" value="<?=$job_post_date?>" />
                        	<a href="javascript:NewCssCal('post_date<?=$job;?>','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a></td>	
                         </tr>
                         <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Location:</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="location[]" value="<?=$jobRow['location'];?>" /></td>	
                         </tr>
						 
						 
						 <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Source:</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="source[]" value="<?=$jobRow['source'];?>" /></td>	
                         </tr>
						 
						 
						 
                         <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Job Title:</td>
                          <td width="75%" align="left" valign="top"><textarea name="description[]" cols="23" rows="5"><?=preg_replace('/<br( )?(\/)?>/i', "\r", $jobRow['description']);?></textarea></td>	
                         </tr>
                         <tr>
                         	<td>&nbsp;</td>
                         	<td><a href="javascript:;" onclick="removeElement('my<?=$job?>Div')">Remove the above Job?</a></td></tr>
                    </table>
                    </div>
                  <? $job++;
				  	} ?>
              	  	</div>
                    <p><a href="javascript:;" onClick="addEvent();">Add Job Info</a></p>
              </td>	
			</tr>
             <tr>
			  <td align="right" style="color: #064962;font-family: Arial;font-size:13px;font-weight:bold;padding-right:150px;">
              	<input type="checkbox" name="demo_job" id="demo_job" value="1" <? if ($demo_job==1){echo 'checked="checked"';} ?> onclick="JobTiggerOnOff();" /> Add to demo?
                &nbsp;&nbsp;
				<input type="checkbox" name="buyside_job" id="buyside_job" value="1" <? if ($buyside_job==1){echo 'checked="checked"';} ?>  onclick="ExecutiveJobTiggerOnOff();" /> Add to buyside demo
				
				</td>
            </tr>
            <tr>
                <td align="right" style="color: #064962;font-family: Arial;font-size:13px;font-weight:bold;padding-right:150px;">
              	<div id="divWebsiteTigger" style="display:<? if ($demo_job==1){echo 'block';}else{echo 'none';}?>;">
                	<div class="row">
                        <select name="ctositename[]" id="ctositename" class="websitename" multiple data-placeholder="Please select website">
                            <option value="CTO" <? if(in_array('CTO',$wsArray)){echo 'selected="selected"';} ?> >CTO</option>
                            <option value="CLO" <? if(in_array('CLO',$wsArray)){echo 'selected="selected"';} ?>>CLO</option>
                            <option value="CMO" <? if(in_array('CMO',$wsArray)){echo 'selected="selected"';} ?>>CMO</option>
                            <option value="CFO" <? if(in_array('CFO',$wsArray)){echo 'selected="selected"';} ?>>CFO</option>
                            <option value="HR" <? if(in_array('HR',$wsArray)){echo 'selected="selected"';} ?>>HR</option>
                        </select>
                    </div><!-- /.row -->
					
					
					<div id="divBuysideWebsiteTigger" style="display:<? if ($buyside_job==1){echo 'block';}else{echo 'none';}?>;">
                	<div class="row">
                        <select name="ctositenameBuyside[]" id="ctositenameBuyside" class="websitename" multiple data-placeholder="Please select website">
                            <option value="CTO" <? if(in_array('CTO',$bsArray)){echo 'selected="selected"';} ?> >CTO Buyside</option>
                            <option value="CLO" <? if(in_array('CLO',$bsArray)){echo 'selected="selected"';} ?> >CLO Buyside</option>
                            <option value="CMO" <? if(in_array('CMO',$bsArray)){echo 'selected="selected"';} ?> >CMO Buyside</option>
                            <option value="CFO" <? if(in_array('CFO',$bsArray)){echo 'selected="selected"';} ?> >CFO Buyside</option>
                            <option value="HR" <? if(in_array('HR',$bsArray)){echo 'selected="selected"';} ?> >HR Buyside</option>
                        </select>
                    </div><!-- /.row -->
                </div>  
					
                </div>  
              </td>	
			</tr>
			
			
			<!-- Funding edit starts -->
			<tr>
			  <td align="left" class="heading-text-a">>> Funding Information</td>	
			</tr>
            <tr>
			  <td align="left" style="padding-left:25px;">
              		<input type="hidden" value="<?=$funding;?>" id="theFundingValue" />
              		<div id="myFundingDiv">
              		<? 
					$FundingQuery = "select * from ".TABLE_COMPANY_FUNDING." where company_id='".$company_id."'";
					$FundingResult = com_db_query($FundingQuery);
					if($FundingResult){
						$funding_num_row = com_db_num_rows($FundingResult);
						//echo "<br>funding_num_row: ".$funding_num_row;
					}
					$funding=0;
					while($fundingRow = com_db_fetch_array($FundingResult)){
					
					$fpd = explode('-',$fundingRow['funding_date']);
					$funding_date = $fpd[1].'/'.$fpd[2].'/'.$fpd[0];
					?>
                    <div id="my<?=$funding?>FundingDiv">
              		<table width="100%" cellpadding="2" cellspacing="2" border="0">
                        
                         <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Date:</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="funding_date[]" id="funding_date<?=$funding;?>" value="<?=$funding_date?>" />
                        	<a href="javascript:NewCssCal('funding_date<?=$funding;?>','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a></td>	
                         </tr>
						 
						 <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Amount:</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="funding_amount[]" value="<?=$fundingRow['funding_amount'];?>" /></td>	
                         </tr>
                         <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Source:</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="funding_source[]" value="<?=$fundingRow['funding_source'];?>" /></td>	
                         </tr>
						 
                         
                         <tr>
                         	<td>&nbsp;</td>
                         	<td><a href="javascript:;" onclick="removeFundingElement('my<?=$funding?>FundingDiv')">Remove the above Funding?</a></td></tr>
                    </table>
                    </div>
                  <? $funding++;
				  	} ?>
              	  	</div>
                    <p><a href="javascript:;" onClick="addFunding();">Add Funding Info</a></p>
              </td>	
			</tr>
			
			
			 <tr>
			  <td align="right" style="color: #064962;font-family: Arial;font-size:13px;font-weight:bold;padding-right:150px;">
				<input type="checkbox" name="demo_email_funding" id="demo_email_funding" value="1" <? if ($demo_email_funding==1){echo 'checked="checked"';} ?>  onclick="fundingTiggerOnOff();" /> Add to demo?
				</td>
            </tr>
			
			<tr>
                <td align="right" style="color: #064962;font-family: Arial;font-size:13px;font-weight:bold;padding-right:150px;">
              	<div id="divFundingWebsiteTigger" style="display:<? if ($demo_email_funding==1){echo 'block';}else{echo 'none';}?>;">
                	<div class="row">
                        <select name="ctositenameFunding[]" id="ctositenameFunding" class="websitename" multiple data-placeholder="Please select website">
                            <option value="CTO" <? if(in_array('CTO',$wfArray)){echo 'selected="selected"';} ?> >CTO</option>
                            <option value="CLO" <? if(in_array('CLO',$wfArray)){echo 'selected="selected"';} ?> >CLO</option>
                            <option value="CMO"<? if(in_array('CMO',$wfArray)){echo 'selected="selected"';} ?> >CMO</option>
                            <option value="CFO"<? if(in_array('CFO',$wfArray)){echo 'selected="selected"';} ?> >CFO</option>
                            <option value="HR"<? if(in_array('HR',$wfArray)){echo 'selected="selected"';} ?> >HR</option>
                        </select>
                    </div><!-- /.row -->
                </div>  
              </td>	
			</tr>
			
			<!-- Funding edit ends -->
			
            <tr>
            	<td align="center">
                	<table width="50%" border="0" cellpadding="4" cellspacing="4">
                    	<tr>
                        	<td width="22%"><input type="submit" value="Update Company" class="submitButton" /></td>
                            <td width="78%"><input type="button" class="submitButton" value="cancel" onclick="window.location='company.php?p=<?=$p;?>&uID=<?=$uID;?>&selected_menu=master'" /></td>
                        </tr>
                    </table>
                </td>
             </tr>
			
			</table>
		  </form>
		 <!-- end inner table -->
		  </td>
		 </tr>
            </table></td>
		 </tr>
        </table>
		  </td>
        </tr>
	
	<? }elseif($action=='detailes'){?>
		 <tr>
          <td align="center" valign="top">
		  
		  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" style="background-color:#CCC;height:30px;"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">Company Manager :: Company Details </td>
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="left" valign="top" class="right-border">
		 <!--start iner table  -->
         	 
         	<table width="95%" align="center" cellpadding="5" cellspacing="5" border="0">
			
            <tr>
			  <td align="left" class="heading-text-a">>> Company Information</td>	
			</tr>
            <tr>
			  <td align="left">
              	 <div id="div_company" style="display:block;">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Company Website:</td>
                      <td width="75%" align="left" valign="top"><?=$company_website;?></td>	
                    </tr>
					<tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Company Name:</td>
                      <td width="75%" align="left" valign="top"><?=$company_name;?></td>	
                    </tr>
                     <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Company Logo:</td>
                      <td width="75%" align="left" valign="top">
                      <img src="../company_logo/small/<?=$company_logo?>" alt="Logo" />
                     </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Size ($Revenue):</td>
                      <td width="75%" align="left" valign="top"><?=$company_revenue;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Size (Employees):</td>
                      <td width="75%" align="left" valign="top"><?=$company_employee;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Industry:</td>
                      <td width="75%" align="left" valign="top"><?=$company_industry;?></td>	
                    </tr>
					 <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Leadership Page:</td>
                      <td width="75%" align="left" valign="top"><?=$leadership_page;?></td>	
                    </tr>
					 <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Email Pattern:</td>
                      <td width="75%" align="left" valign="top"><?=$email_pattern;?></td>	
                    </tr>
                  </table>
                  </div>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a">>> Location</td>	
			</tr>
            <tr>
			  <td align="left">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Address:</td>
                      <td width="75%" align="left" valign="top"><?=$address;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Address 2:</td>
                      <td width="75%" align="left" valign="top"><?=$address2;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;City:</td>
                      <td width="75%" align="left" valign="top"><?=$city;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;State:</td>
                      <td width="75%" align="left" valign="top"><?=$state;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Country:</td>
                      <td width="75%" align="left" valign="top"><?=$country;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Zip Code:</td>
                      <td width="75%" align="left" valign="top"><?=$zip_code;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Phone:</td>
                      <td width="75%" align="left" valign="top"><?=$phone;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Fax:</td>
                      <td width="75%" align="left" valign="top"><?=$fax;?></td>	
                    </tr>
                  </table>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a">>> Company Details</td>	
			</tr>
            <tr>
			  <td align="left">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                   
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;About the Company?:</td>
                      <td width="75%" align="left" valign="top"><?=$about_company;?></td>	
                    </tr>
                  </table>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a">>> Social Media Profiles</td>	
			</tr>
            <tr>
			  <td align="left">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Facebook Link:</td>
                      <td width="75%" align="left" valign="top"><?=$facebook_link?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;LinkedIn Link:</td>
                      <td width="75%" align="left" valign="top"><?=$linkedin_link?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Twitter Link:</td>
                      <td width="75%" align="left" valign="top"><?=$twitter_link?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Google+ Link:</td>
                      <td width="75%" align="left" valign="top"><?=$googleplush_link?></td>	
                    </tr>
                  </table>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a">>> Company Job Information</td>	
			</tr>
            <tr>
			  <td align="center">
              	<table width="100%" cellpadding="2" cellspacing="1" border="0">
                     <tr style="background-color:#CCC;">
                         <td width="20%" align="center" class="page-text" valign="middle"><b>Job Title</b></td>
                         <td width="13%" align="center" class="page-text" valign="middle"><b>Posted Date</b></td>
                         <td width="15%" align="center" class="page-text" valign="middle"><b>Location</b></td>
                         <td width=""    align="center" class="page-text" valign="middle"><b>Description</b></td>
                         <td width="7%" align="center" class="page-text" valign="middle"><b>Action</b></td>
                     </tr>
              		<? 
					$JobQuery = "select * from ".TABLE_COMPANY_JOB_INFO." where company_id='".$cID."'";
					$JobResult = com_db_query($JobQuery);
					if($JobResult){
						$job_num_row = com_db_num_rows($JobResult);
					}
					while($jobRow = com_db_fetch_array($JobResult)){
						if($jobRow['post_date'] !='0000-00-00'){
							$ptdt = explode('-',$jobRow['post_date']);
							$post_date = $ptdt[1].'/'.$ptdt[2].'/'.$ptdt[0];
						}else{
							$post_date ='';
						}
					?>
                    	<tr>
                             <td width="20%" align="left" class="page-text"><?=$jobRow['job_title'];?></td>
                             <td width="10%" align="left" class="page-text"><?=$post_date;?></td>
                             <td width="20%" align="left" class="page-text"><?=$jobRow['location'];?></td>
                             <td width=""    align="left" class="page-text"><?=$jobRow['description'];?></td>
                             <td width="10%" align="center" class="page-text"><a href="#"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" title="Delete" border="0" onclick="confirm_job_delete('<?=$jobRow['company_id'];?>','<?=$jobRow['job_id'];?>')" /></a><br />Delete</td>
                     	</tr>
                  <? } ?>
                  </table>
              </td>	
			</tr>			
			</table>
		 <!-- end inner table -->
		  </td>
		 </tr>
		 <tr>
            	<td align="center">
                	<table width="50%" border="0" cellpadding="4" cellspacing="4">
                    	<tr><td><input type="button" class="submitButton" value="Back" onclick="window.location='company.php?p=<?=$p;?>'" /></td></tr>
                    </table>
                </td>
             </tr>
            </table></td>
		 </tr>
        </table>
		  
		  </td>
        </tr>
	<? } ?>
		
      </table></td>
      <td align="left"  valign="top">&nbsp;</td>
    </tr>

	<? include_once("includes/footer-menu.php"); ?>
    
    <tr>
      <td align="left"  valign="top">&nbsp;</td>
      <td align="left" valign="top">
        <table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td align="center" valign="top" class="copyright-text">Copyright &copy; 2010 CTOsOnTheMove. All rights reserved.</td>
          </tr>
          <tr>
            <td align="center" valign="top">&nbsp;</td>
          </tr>
        </table>
      </td>
      <td align="left"  valign="top">&nbsp;</td>
    </tr>
</table>

</body>
</html>

<script src="js/jquery-1.7.2.min.js" type="text/javascript"></script>
<!-- <script src="js/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script> -->
<!-- <script src="js/jquery.radios.checkboxes.js" type="text/javascript"></script> -->
<script src="js/chosen.jquery.js" type="text/javascript"></script>
<script src="js/functions.js" type="text/javascript"></script>
 
<script type="text/javascript" src="only-dataentry.js"></script>
<script type="text/javascript" src="../js/datetimepicker_css.js" language="javascript"></script>  
<script type="text/javascript" src="selectuser.js" language="javascript"></script>


