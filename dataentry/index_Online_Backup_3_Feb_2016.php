<?php
//ini_set('display_errors',1);
//ini_set('display_startup_errors',1);
//error_reporting(-1);

require('../includes/configuration.php');
//include('includes/include_editor.php');
include('../includes/only_dataentry_include-top.php');

$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 20;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';

if($action == 'MovementSearchResult'){
	$title			= $_POST['search_title'];
	$company_name	= $_POST['search_company_name'];
	$company_url	= $_POST['search_company_url'];
	$first_name		= $_POST['search_first_name'];
	$last_name		= $_POST['search_last_name'];
	$from_date		= $_POST['from_date'];
	$to_date 		= $_POST['to_date'];
	
	$search_qry='';
	if($title!=''){
		$search_qry .= " m.title = '".$title."'";
	}
	if($company_name!=''){
		if($search_qry==''){
			$search_qry .= " c.company_name = '".$company_name."'";
		}else{
			$search_qry .= " and m.company_name = '".$company_name."'";
		}	
	}
	if($company_url!=''){
		if($search_qry==''){
			$search_qry .= " c.company_website like '%".$company_url."'";
		}else{
			$search_qry .= " and m.company_website like '%".$company_url."'";
		}	
	}
	if($first_name!=''){
		if($search_qry==''){
			$search_qry .= " p.first_name = '".$first_name."'";
		}else{
			$search_qry .= " and p.first_name = '".$first_name."'";
		}	
	}
	if($last_name!=''){
		if($search_qry==''){
			$search_qry .= " p.last_name = '".$last_name."'";
		}else{
			$search_qry .= " and p.last_name = '".$last_name."'";
		}	
	}
	if($from_date!='' && strlen($from_date)==10 && $to_date !='' && strlen($to_date)==10){
		$fdt = explode('/',$from_date);
		$fdate = $fdt[2].'-'.$fdt[0].'-'.$fdt[1];
		$tdt = explode('/',$to_date);
		$tdate = $tdt[2].'-'.$tdt[0].'-'.$tdt[1];
		if($search_qry==''){
			$search_qry .= " m.announce_date >= '".$fdate."' and m.announce_date <='".$tdate."'";
		}else{
			$search_qry .= " and m.announce_date >= '".$fdate."' and m.announce_date <='".$tdate."'";
		}
	}
		
	
	if($search_qry==''){
		$sql_query = "select m.*,c.company_name,p.first_name,p.last_name from " . TABLE_MOVEMENT_MASTER . " as m,".TABLE_PERSONAL_MASTER." as p,".TABLE_COMPANY_MASTER." as c where m.company_id=c.company_id and m.personal_id=p.personal_id order by add_date desc";
	}else{
		$sql_query = "select m.*,c.company_name,p.first_name,p.last_name from " . TABLE_MOVEMENT_MASTER . " as m,".TABLE_PERSONAL_MASTER." as p,".TABLE_COMPANY_MASTER." as c where m.company_id=c.company_id and m.personal_id=p.personal_id and ".$search_qry." order by add_date desc";
	}
	$_SESSION['sess_admin_search_query'] = $sql_query;
}elseif($action=='AdvSearch'){
	$sql_query = $_SESSION['sess_admin_search_query'];
}else{
	$sql_query = "select m.*,c.company_name,p.first_name,p.last_name from " . TABLE_MOVEMENT_MASTER . " as m,".TABLE_PERSONAL_MASTER." as p,".TABLE_COMPANY_MASTER." as c where m.company_id=c.company_id and m.personal_id=p.personal_id order by add_date desc";
}		
/***************** FOR PAGIN ***********************/
$starting_point = $items_per_page * ($p - 1);
/****************** END PAGIN ***********************/
$main_page = 'index.php';

$exe_query=com_db_query($sql_query);
$num_rows=com_db_num_rows($exe_query);
$total_data = $num_rows;

/************ FOR PAGIN **************/
$sql_query .= " LIMIT $starting_point,$items_per_page";
$exe_data = com_db_query($sql_query);

$numRows = com_db_num_rows($exe_data);
/************ END ********************/


$mID = (isset($_GET['mID']) ? $_GET['mID'] : $select_data[0]);

    switch ($action) {
		
	  case 'delete':
	   		
			com_db_query("delete from " . TABLE_MOVEMENT_MASTER . " where move_id = '" . $mID . "'");
		 	com_redirect("index.php?p=" . $p . "&msg=" . msg_encode("Movement deleted successfully"));
		
		break;
		
	  case 'edit':
     		
	   		$query_edit=com_db_query("select * from " . TABLE_MOVEMENT_MASTER . " where move_id = '" . $mID . "'");
	  		$data_edit=com_db_fetch_array($query_edit);
			
			$company_id = com_db_output($data_edit['company_id']);
			$personal_id = com_db_output($data_edit['personal_id']);
			$title = com_db_output($data_edit['title']);
			if($data_edit['announce_date'] !='0000-00-00'){
				$andt = explode('-',$data_edit['announce_date']);
				$announce_date = $andt[1].'/'.$andt[2].'/'.$andt[0];
			}else{
				$announce_date ='';
			}
			if($data_edit['effective_date'] !='0000-00-00'){
				$andt = explode('-',$data_edit['effective_date']);
				$effective_date = $andt[1].'/'.$andt[2].'/'.$andt[0];
			}else{
				$effective_date ='';
			}
			$headline = com_db_output($data_edit['headline']);
			$full_body = preg_replace('/<br( )?(\/)?>/i', "\r", $data_edit['full_body']);
			$short_url = com_db_output($data_edit['short_url']);
			$movement_type = com_db_output($data_edit['movement_type']);
			$what_happened = $data_edit['what_happened'];
			$movement_type = com_db_output($data_edit['movement_type']);
			$source_id = com_db_output($data_edit['source_id']);
			$movement_url = com_db_output($data_edit['movement_url']);
			$more_link = com_db_output($data_edit['more_link']);
			$not_current = com_db_output($data_edit['not_current']);
		break;	
		
		case 'editsave':
			
			//$company_id = com_db_input($_POST['company_id']);
			//$personal_id = com_db_input($_POST['personal_id']);
			$title = com_db_input($_POST['title']);
			$ann_date = explode("/",$_POST['announce_date']);
			$announce_date = $ann_date[2]."-".$ann_date[0]."-".$ann_date[1];
			$eff_date = explode('/',$_POST['effective_date']);
			$effective_date = $eff_date[2].'-'.$eff_date[0].'-'.$eff_date[1];
			$headline = com_db_input($_POST['headline']);
			$rep   = array("\r\n", "\n","\r");
			$full_body = str_replace($rep,'<br />',$_POST['full_body']);
			$short_url = com_db_input($_POST['short_url']);		
			$what_happened = strip_tags($_POST['what_happened']);
			$movement_type = com_db_input($_POST['movement_type']);
			$source_id = com_db_input($_POST['source_id']);
			$movement_url = com_db_input($_POST['movement_url']);
			$more_link = com_db_input($_POST['more_link']);
			$not_current = com_db_input($_POST['not_current']);
			$phone =  com_db_input($_POST['phone']);
			$fax =  com_db_input($_POST['fax']);
			$create_by = $_SESSION['user_login_name'];
			$login_id = $_SESSION['user_login_id'];
			
			$company_id = com_db_GetValue("select company_id from ".TABLE_MOVEMENT_MASTER." where move_id = '" . $mID . "'");
			
			$query = "update " . TABLE_MOVEMENT_MASTER . " set title = '".$title."', announce_date = '".$announce_date."', effective_date = '".$effective_date."', headline = '".$headline."', full_body = '".$full_body."', short_url = '".$short_url."', what_happened='".$what_happened."', movement_type='".$movement_type."', source_id='".$source_id."', movement_url='".$movement_url."', more_link = '".$more_link."', not_current ='".$not_current."',create_by='".$create_by."',admin_id='".$login_id."' where move_id = '" . $mID . "'";
			com_db_query($query);
			
			com_db_query("update ".TABLE_COMPANY_MASTER." set phone='".$phone."' , fax ='".$fax."' where company_id='".$company_id."'");
			
			$update_query = "update ".TABLE_COMPANY_MASTER." set phone='".$phone."' , fax ='".$fax."' where company_id='".$company_id."'" ;
			
			com_db_query("insert into ".TABLE_COMPANY_UPDATE_INFO."(page_name,query_string,add_date) values('dataentry-index','".com_db_input($update_query)."','".date("Y-m-d:H:i:s")."')");

	  		com_redirect("index.php?p=". $p ."&mID=" . $mID . "&msg=" . msg_encode("Movement update successfully"));
		 
		break;		
		
	case 'addsave':
			echo "<pre>POST AT START:";	print_r($_POST);	echo "</pre>";
			//die();
                        
                        if($_POST['company_id_auto'] != '')
                            $_POST['company_id'] = com_db_input($_POST['company_id_auto']);
                        
                        $company_id = com_db_input($_POST['company_id']);
                        
                        //echo "<br>company_id:".$company_id;
                        //die();
                        
			$personal_id = com_db_input($_POST['personal_id']);
			$title = com_db_input($_POST['title']);
			$first_name = com_db_input($_POST['first_name']);
			$middle_name = com_db_input($_POST['middle_name']);
			$last_name = com_db_input($_POST['last_name']);
                        
                        $_POST['person_email'] = trim($_POST['person_email']);
                        
			$person_email = com_db_input($_POST['person_email']);
			$person_phone = com_db_input($_POST['person_phone']);
			$about_person = strip_tags($_POST['about_person']);
			$person_facebook_link = com_db_input($_POST['person_facebook_link']);
			$person_linkedin_link = com_db_input($_POST['person_linkedin_link']);
			$person_twitter_link = com_db_input($_POST['person_twitter_link']);
			$person_googleplush_link = com_db_input($_POST['person_googleplush_link']);
			$ann_date = explode("/",$_POST['announce_date']);
			$announce_date = $ann_date[2]."-".$ann_date[0]."-".$ann_date[1];
			$eff_date = explode('/',$_POST['effective_date']);
			$effective_date = $eff_date[2].'-'.$eff_date[0].'-'.$eff_date[1];
			$headline = com_db_input($_POST['headline']);
			$rep   = array("\r\n", "\n","\r");
			$full_body = str_replace($rep,'<br />',$_POST['full_body']);
			$short_url = com_db_input($_POST['short_url']);
			$movement_url = com_db_input($_POST['movement_url']);
			$what_happened = strip_tags($_POST['what_happened']);
			$movement_type = com_db_input($_POST['movement_type']);
			$source_id = com_db_input($_POST['source_id']);
			$phone =  com_db_input($_POST['phone']);
			$fax =  com_db_input($_POST['fax']);
			$more_link = com_db_input($_POST['more_link']);
			$not_current = com_db_input($_POST['not_current']);
			$create_by = $_SESSION['user_login_name'];
			$login_id = $_SESSION['user_login_id'];
			$status = '0';
			$add_date = date('Y-m-d');
			$company_website = com_db_input($_POST['company_website']);
			$rep   = array("http://", "https://","www.","/");
			$company_website ="www.". str_replace($rep,'',$company_website);
			$email_verified = com_db_input($_POST['email_verified']);
			if($email_verified =='Yes'){
				$email_verified_date = date('Y-m-d');
			}else{
				$email_verified_date='';
			}
                        
                        
                        $before_date = subDate('30');
                        $today_date = date ('Y-m-j');
                        if($announce_date > $before_date && $announce_date < $today_date)
                            $allow_buffer_queue = 1;
                        else
                            $allow_buffer_queue = 0;
                        
                        
			//Personal information
			if(trim($movement_url) !='')
                        {
                            $isMovementID = com_db_GetValue("select move_id from ".TABLE_MOVEMENT_MASTER." where movement_url='".$movement_url."'");
                            if($company_id != '')
                            {
                                $company_name_full = com_db_GetValue("select company_name from ".TABLE_COMPANY_MASTER." where company_id='".$company_id."'");
                                //$company_name_full = $company_name;
                            }
                            
			}
                        else
                        {
                            
                            $company_name = com_db_input($_POST['company_name']);

                            $company_name_full = $_POST['searched_company_name'];
                            $company_name = str_replace(' ','-',$company_name);


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
                            $isMovementID = com_db_GetValue("select move_id from ".TABLE_MOVEMENT_MASTER." where movement_url='".$movement_url."'");
			}
			if($isMovementID ==''){
				$isPersonalID = com_db_GetValue("select personal_id from ".TABLE_PERSONAL_MASTER." where first_name='".$first_name."' and middle_name='".$middle_name."' and last_name='".$last_name."'");
				if($isPersonalID =='' || $_POST['person_option'] == 'New'){
			
					$query = "insert into " . TABLE_PERSONAL_MASTER . "
					(first_name, middle_name, last_name, email,email_verified, email_verified_date, phone,facebook_link,linkedin_link,twitter_link,googleplush_link,about_person, add_date, create_by,admin_id, status) 
					values ('$first_name', '$middle_name', '$last_name', '$person_email','$email_verified','$email_verified_date','$person_phone','$person_facebook_link','$person_linkedin_link','$person_twitter_link','$person_googleplush_link','$about_person','$add_date','$create_by','$login_id','$status')";
					com_db_query($query);
					$personal_id = com_db_insert_id();
					$image = $_FILES['person_photo']['tmp_name'];
					if($image!=''){
						if(is_uploaded_file($image)){
							$org_img = $_FILES['person_photo']['name'];
							$exp_file = explode("." , $org_img);
							$get_ext = $exp_file[count($exp_file) - 1];
							if(strtolower($get_ext)=="jpg" || strtolower($get_ext)=="gif" || strtolower($get_ext)=="jpeg" || strtolower($get_ext)=="png"){
								$new_exp_file = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''),$exp_file[0]);
								$org_image_name = $new_exp_file.'-'.time().'.'.$get_ext;
								$destination_image = '../personal_photo/org/' . $org_image_name;
								if(move_uploaded_file($image , $destination_image)){
									$thumb_image='../personal_photo/thumb/' . $org_image_name;
									make_thumb($destination_image, $thumb_image,200,200);
									
									$small_image='../personal_photo/small/' . $org_image_name;
									make_thumb($destination_image, $small_image,80,80);
									
									$query = "UPDATE " . TABLE_PERSONAL_MASTER . " SET personal_image = '" . $org_image_name . "' WHERE personal_id = '" . $personal_id ."'";
									com_db_query($query);
								}
							}	
						}	
					}
					
					$verified_image = $_FILES['verified_image']['tmp_name'];  
					if($verified_image!=''){
						if(is_uploaded_file($verified_image)){
							$org_img = $_FILES['verified_image']['name'];
							$exp_file = explode("." , $org_img);
							$get_ext = $exp_file[count($exp_file) - 1];
							if(strtolower($get_ext)=="jpg" || strtolower($get_ext)=="gif" || strtolower($get_ext)=="jpeg" || strtolower($get_ext)=="png"){
								$new_exp_file = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''),$exp_file[0]);
								$org_image_name = $new_exp_file.'-'.time().'.'.$get_ext;
								$destination_image = '../verivied_image/org/' . $org_image_name;
								if(move_uploaded_file($verified_image , $destination_image)){
									$thumb_image='../verivied_image/small/' . $org_image_name;
									$org_size=getimagesize($destination_image);
									$width = $org_size[0];
									$height = $org_size[1];
									if($width>350){
										$t_width='350';
										$t_height='';
									} else {
										$t_width=$width;
										$t_height=$height;
									}
									make_thumb($destination_image, $thumb_image,$t_width,$t_height);
									$query = "UPDATE " . TABLE_PERSONAL_MASTER . " SET verified_image = '" . $org_image_name . "' WHERE personal_id = '" . $personal_id ."'";
									com_db_query($query);
								}
							}	
						}	
					}
				}
				else{
					$personal_id = $isPersonalID;
					if($movement_type==3 || $movement_type==4 || $movement_type==5){
						com_db_query("update ".TABLE_PERSONAL_MASTER." set email = 'N/A',verified_image='', email_verified='',email_verified_date='' where personal_id='".$personal_id."'");
					}else{
						com_db_query("update ".TABLE_PERSONAL_MASTER." set email = '".$person_email."',email_verified='".$email_verified."',email_verified_date='".$email_verified_date."',phone='".$person_phone."',facebook_link='".$person_facebook_link."',linkedin_link='".$person_linkedin_link."',twitter_link='".$person_twitter_link."',googleplush_link='".$person_googleplush_link."' where personal_id='".$personal_id."'");
					}
					$image = $_FILES['personal_photo']['tmp_name'];
					if($image!=''){
						if(is_uploaded_file($image)){
							$org_img = $_FILES['personal_photo']['name'];
							$exp_file = explode("." , $org_img);
							$get_ext = $exp_file[count($exp_file) - 1];
							if(strtolower($get_ext)=="jpg" || strtolower($get_ext)=="gif" || strtolower($get_ext)=="jpeg" || strtolower($get_ext)=="png"){
								$new_exp_file = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''),$exp_file[0]);
								$org_image_name = $new_exp_file.'-'.time().'.'.$get_ext;
								$destination_image = '../personal_photo/org/' . $org_image_name;
								if(move_uploaded_file($image , $destination_image)){
									$thumb_image='../personal_photo/thumb/' . $org_image_name;
									make_thumb($destination_image, $thumb_image,200,200);
									
									$small_image='../personal_photo/small/' . $org_image_name;
									make_thumb($destination_image, $small_image,80,80);
									
									$query = "UPDATE " . TABLE_PERSONAL_MASTER . " SET personal_image = '" . $org_image_name . "' WHERE personal_id = '" . $personal_id ."'";
									com_db_query($query);
								}
							}	
						}	
					}
					
					$verified_image = $_FILES['verified_image']['tmp_name'];  
					if($verified_image!=''){
						if(is_uploaded_file($verified_image)){
							$org_img = $_FILES['verified_image']['name'];
							$exp_file = explode("." , $org_img);
							$get_ext = $exp_file[count($exp_file) - 1];
							if(strtolower($get_ext)=="jpg" || strtolower($get_ext)=="gif" || strtolower($get_ext)=="jpeg" || strtolower($get_ext)=="png"){
								$new_exp_file = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''),$exp_file[0]);
								$org_image_name = $new_exp_file.'-'.time().'.'.$get_ext;
								$destination_image = '../verivied_image/org/' . $org_image_name;
								if(move_uploaded_file($verified_image , $destination_image)){
									$thumb_image='../verivied_image/small/' . $org_image_name;
									$org_size=getimagesize($destination_image);
									$width = $org_size[0];
									$height = $org_size[1];
									if($width>350){
										$t_width='350';
										$t_height='';
									} else {
										$t_width=$width;
										$t_height=$height;
									}
									make_thumb($destination_image, $thumb_image,$t_width,$t_height);
									$query = "UPDATE " . TABLE_PERSONAL_MASTER . " SET verified_image = '" . $org_image_name . "' WHERE personal_id = '" . $personal_id ."'";
									com_db_query($query);
								}
							}	
						}	
					}
				}

				//company information
				$isCompanyID = com_db_GetValue("select company_id from ".TABLE_COMPANY_MASTER." where company_website='".$company_website."'");
				if($isCompanyID>0){
					$company_id = $isCompanyID;
				}else{
				
				/*
				
					$company_name = com_db_input($_POST['company_name']);
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
							
					$publish = '0';
					
					$create_by = $_SESSION['user_login_name'];
					$login_id = $_SESSION['user_login_id'];
					$status = '0';
					$add_date = date('Y-m-d');
					
					$query = "insert into " . TABLE_COMPANY_MASTER . "
					(company_name, company_website, company_revenue, company_employee, company_industry, ind_group_id, industry_id,leadership_page,email_pattern, address, address2, city, state, country, zip_code, phone, fax, about_company, facebook_link ,linkedin_link ,twitter_link, googleplush_link, add_date, create_by,admin_id, status) 
					values ('$company_name', '$company_website', '$company_revenue', '$company_employee', '$company_industry', '$ind_group_id', '$industry_id', '$leadership_page','$email_pattern','$address', '$address2', '$city', '$state', '$country', '$zip_code','$phone','$fax','$about_company','$facebook_link','$linkedin_link','$twitter_link','$googleplush_link','$add_date','$create_by','$login_id','$status')";
					com_db_query($query);
					$company_id = com_db_insert_id();
					
					$comInsertQuery = "insert into " . TABLE_COMPANY_MASTER . "
					(company_id,company_name, company_website, company_revenue, company_employee, company_industry, ind_group_id, industry_id,leadership_page,email_pattern, address, address2, city, state, country, zip_code, phone, fax, about_company, facebook_link ,linkedin_link ,twitter_link, googleplush_link, add_date, create_by,admin_id, status) 
					values ('$company_id','$company_name', '$company_website', '$company_revenue', '$company_employee', '$company_industry', '$ind_group_id', '$industry_id', '$leadership_page','$email_pattern','$address', '$address2', '$city', '$state', '$country', '$zip_code','$phone','$fax','$about_company','$facebook_link','$linkedin_link','$twitter_link','$googleplush_link','$add_date','$create_by','$login_id','$status')";
					
					com_db_query("insert into ".TABLE_COMPANY_UPDATE_INFO."(page_name,query_string,add_date) values('dataentry-index','".com_db_input($comInsertQuery)."','".date("Y-m-d:H:i:s")."')");
					
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
									
									$query = "UPDATE " . TABLE_COMPANY_MASTER . " SET company_logo = '" . $org_image_name . "' WHERE company_id = '" . $company_id ."'";
									com_db_query($query);
								}
							}	
						}	
					}
				*/
				
				}
				//
                                
                                //echo "<pre>POST BEFORE STATE:";	print_r($_POST);	echo "</pre>";
                                
				$company_name = $_POST['searched_company_name'];
				$city = $_POST['searched_company_city'];
				$state_full_name = $_POST['searched_company_state'];
				
				$state_query = "select short_name from " . TABLE_STATE . " where state_name = '".$state_full_name."' LIMIT 0,1";
				//echo "<br>state_query: ".$state_query;
                                $state_result = com_db_query($state_query);
				while($state_row = com_db_fetch_array($state_result)) 
				{
					$state 			= $state_row['short_name'];
					
				}
						
						
				
				$headline = $first_name." ".$last_name." was ".$url_mmc." as ".$title." at ".$company_name;
				$what_happened = $city.", ".$state."-based ".$company_name." ".$url_mmc." ".$first_name." ".$last_name." as ".$title;
				
				//echo "<br>Headline: ".$headline;
				//echo "<br>what_happened: ".$what_happened;
				//die();
				
				$query = "insert into " . TABLE_MOVEMENT_MASTER . "
				(company_id, personal_id, title, announce_date,effective_date,headline,full_body,short_url, what_happened, movement_type, source_id, movement_url, more_link, not_current, add_date, create_by, admin_id, status) 
				values ('$company_id', '$personal_id', '$title', '$announce_date','$effective_date','$headline','$full_body','$short_url','$what_happened','$movement_type','$source_id','$movement_url','$more_link','$not_current', '$add_date', '$create_by','$login_id','$status')";
				com_db_query($query);
				
				com_db_query("update ".TABLE_COMPANY_MASTER." set phone='".$phone."' , fax ='".$fax."' where company_id='".$company_id."'");
				
				
				if($_POST['executiveEmailSend'] == 1)
				{
					if($_POST['email_verified'] == 'Yes')
					{
						
						$email_domain = com_db_input($_POST['company_email_domain']);
						//echo "<br>first_name: ".$first_name;
						//echo "<br>middle_name: ".$middle_name;
						//echo "<br>last_name: ".$last_name;
						//echo "<br>email_domain: ".$email_domain;
						//echo "<br>person_email: ".$person_email;
						
						$new_pattern_id = getting_email_pattern($first_name,$middle_name,$last_name,$email_domain,$person_email);
						//echo "<br>new_pattern_id: ".$new_pattern_id;
						
						$grade = "A";
						
						$company_info_query = "select company_id,email_pattern_id from " . TABLE_COMPANY_MASTER . " where company_website = '".$company_website."' LIMIT 0,1";
						
						//echo "<br>company_website: ".$company_website;
						//echo "<br>this_company_id: ".$this_company_id;
						
						$company_info_result = com_db_query($company_info_query);
						while($company_info_row = com_db_fetch_array($company_info_result)) 
						{
							$this_company_id 			= $company_info_row['company_id'];
							$this_company_pattern_id 	= $company_info_row['email_pattern_id'];
						}
						if($this_company_pattern_id == 0 || $this_company_pattern_id == '' )
						{
							//echo "<br>witnin if";
							$upd_query = "UPDATE " . TABLE_COMPANY_MASTER." SET email_pattern_id = $new_pattern_id where company_website = '".$company_website."'";
							//echo "<br>Update Q";
							$upd_result = com_db_query($upd_query);
							
						}	
						else
						{
							//echo "<br>witnin else";
							com_db_query("INSERT into ".TABLE_COMPANY_EMAIL_PATTERN_HISTORY."(company_id,email_pattern_id,result,add_date) values('".$this_company_id."','".$new_pattern_id."','".$grade."','".date("Y-m-d:H:i:s")."')");	
						}
					}
					
				}
				
                                
                                
                                $adminInfo = "select buffer_api from ". TABLE_ADMIN_SETTINGS ." where setting_id ='1'";
                                $adminResult = com_db_query($adminInfo);
                                $adminRow = com_db_fetch_array($adminResult);

                                $buffer_api = $adminRow['buffer_api'];
                                
                                
                                //echo "<br>movement_type: ".$movement_type;
                                //echo "<br>allow_buffer_queue: ".$allow_buffer_queue;
                                //echo "<br>buffer_api: ".$buffer_api;
                                
                                if(($movement_type==1 || $movement_type==2) && $allow_buffer_queue == 1 && $buffer_api == 1)
                                {
                                    //echo "<br>Within if";
                                    // check whether company have funding 
                                    // then check movement date is within last two months
                                    // if yes then push status to buffer
                                    // Congrats {FirstName} {LastName} on {Company} raising{$Amount}! {source link}
                                    
                                    
                                    //echo "<br>movement_type: ".$movement_type;
                                    
                                    $this_movement_type = "";
                                    if($movement_type == 1)
                                        $this_movement_type = 'appointments';
                                    elseif($movement_type == 2)
                                        $this_movement_type = 'promotions';
                                    
                                    $first_name = trim($first_name);
                                    $last_name = trim($last_name);
                                    
                                    /*
                                    echo "<br>this_movement_type: ".$this_movement_type;
                                    echo "<br>first_name: ".$first_name;
                                    echo "<br>last_name: ".$last_name;
                                    echo "<br>title: ".$title;
                                    echo "<br>company_name_full: ".$company_name_full;
                                    echo "<br>movement_type: ".$movement_type;
                                    echo "<br>more_link: ".$more_link;
                                     */

                                    $status_pattern = get_converted_status($this_movement_type,$first_name,$last_name,$title,$company_name_full,$movement_type,$more_link);
                                    
                                    //$_SESSION['text']   = rawurlencode($status_pattern);
                                    $_SESSION['p']      = $p;
                                    $_SESSION['type']   = "movement";   
                                
                                    $auth_url = LOGIN_URI
                                    . "/oauth2/authorize?response_type=code&client_id="
                                    . CLIENT_ID . "&redirect_uri=" . urlencode(REDIRECT_URI);
                                    
                                    $token_url = "https://api.bufferapp.com/1/updates/create.json?access_token=".ONE_ACCESS_TOKEN;
                                    $text = rawurlencode($status_pattern);
                                    
                                    $params = 'text='.$text.'&profile_ids[]=4f770e76512f7e160600001f'; // CTO twitter

                                    $curl = curl_init($token_url);
                                    curl_setopt($curl, CURLOPT_HEADER, false);
                                    //curl_setopt($curl, CURLOPT_HEADER, $headr);
                                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                                    curl_setopt($curl, CURLOPT_POST, true);
                                    curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
                                    $json_response = curl_exec($curl);
                                    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                                    
                                    
                                    /*
                                    // Facebook
                                    $params = 'text='.$text.'&profile_ids[]=5697c23e11d06c077812241c'; // hrexecs
                                    $curl = curl_init($token_url);
                                    curl_setopt($curl, CURLOPT_HEADER, false);
                                    //curl_setopt($curl, CURLOPT_HEADER, $headr);
                                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                                    curl_setopt($curl, CURLOPT_POST, true);
                                    curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
                                    $json_response = curl_exec($curl);
                                    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);


                                    // LinkedIn
                                    $params = 'text='.$text.'&profile_ids[]=5697fecdfce486952d534d52'; // hrexecs
                                    $curl = curl_init($token_url);
                                    curl_setopt($curl, CURLOPT_HEADER, false);
                                    //curl_setopt($curl, CURLOPT_HEADER, $headr);
                                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                                    curl_setopt($curl, CURLOPT_POST, true);
                                    curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
                                    $json_response = curl_exec($curl);
                                    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                                    */
                                    
                                    
                                    //echo "<pre>";   print_r();echo "</pre>";
                                    //echo "<br>Params: ".$params;
                                    //echo "<br>Status: ".$status;
                                    //echo "<br>json_response: ".$json_response;
                                    
                                    
                                    $fundingInfo = "select funding_amount,funding_source from ". TABLE_COMPANY_FUNDING ." where company_id = ".$company_id;
                                    //echo "<br>fundingInfo: ".$fundingInfo;
                                    $fundingResult = com_db_query($fundingInfo);
                                    $fundingRow = com_db_fetch_array($fundingResult);

                                    if(count($fundingRow) > 0 && $fundingRow['funding_amount'] != '' && $fundingRow['funding_source'] != '')
                                    {
                                        $funding_amount = $fundingRow['funding_amount'];
                                        $funding_source = $fundingRow['funding_source'];

                                        //echo "<br>announce_date: ".$announce_date;
                                        $before_funding_date = subDate('60');
                                        //echo "<br>before_date: ".$before_date;

                                        if($announce_date > $before_funding_date)
                                        {
                                            
                                            $status_pattern_funding = ""; 
                                            //  Congrats {FirstName} {LastName} on {Company} raising{$Amount}! {source link}
                                            $status_pattern_funding = "Congrats $first_name $last_name on $company_name_full raising $funding_amount! $funding_source";
                                            //echo "<br>status_pattern_funding: ".$status_pattern_funding;
                                            $token_url = "https://api.bufferapp.com/1/updates/create.json?access_token=".ONE_ACCESS_TOKEN;
                                            $text = rawurlencode($status_pattern_funding);

                                            
                                            // Twitter
                                            $params = 'text='.$text.'&profile_ids[]=4f770e76512f7e160600001f'; // CTO twitter
                                            $curl = curl_init($token_url);
                                            curl_setopt($curl, CURLOPT_HEADER, false);
                                            //curl_setopt($curl, CURLOPT_HEADER, $headr);
                                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                                            curl_setopt($curl, CURLOPT_POST, true);
                                            curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
                                            $json_response = curl_exec($curl);
                                            $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                                            
                                            /*
                                            // Facebook
                                            $params = 'text='.$text.'&profile_ids[]=5697c23e11d06c077812241c'; // hrexecs
                                            $curl = curl_init($token_url);
                                            curl_setopt($curl, CURLOPT_HEADER, false);
                                            //curl_setopt($curl, CURLOPT_HEADER, $headr);
                                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                                            curl_setopt($curl, CURLOPT_POST, true);
                                            curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
                                            $json_response = curl_exec($curl);
                                            $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                                            
                                            
                                            // LinkedIn
                                            $params = 'text='.$text.'&profile_ids[]=5697fecdfce486952d534d52'; // hrexecs
                                            $curl = curl_init($token_url);
                                            curl_setopt($curl, CURLOPT_HEADER, false);
                                            //curl_setopt($curl, CURLOPT_HEADER, $headr);
                                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                                            curl_setopt($curl, CURLOPT_POST, true);
                                            curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
                                            $json_response = curl_exec($curl);
                                            $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                                            */

                                        }
                                    }
                                    //com_redirect("index.php?p=" . $p . "&selected_menu=contact&msg=" . msg_encode("New Movement added successfully"));
                                }
                                
				com_redirect("index.php?p=" . $p . "&selected_menu=contact&msg=" . msg_encode("New Movement added successfully"));
			}
                        else
                        {
                            com_redirect("index.php?p=" . $p . "&selected_menu=contact&msg=" . msg_encode("New Movement Already Present "));
			}
		break;	
		
	case 'detailes':
			
	  		$query_edit=com_db_query("select * from " . TABLE_MOVEMENT_MASTER . " where move_id = '" . $mID . "'");
	  		$data_edit=com_db_fetch_array($query_edit);
			
			$company_id = com_db_output($data_edit['company_id']);
			$personal_id = com_db_output($data_edit['personal_id']);
			$title = com_db_output($data_edit['title']);
			if($data_edit['announce_date'] !='0000-00-00'){
				$andt = explode('-',$data_edit['announce_date']);
				$announce_date = $andt[1].'/'.$andt[2].'/'.$andt[0];
			}else{
				$announce_date ='';
			}
			if($data_edit['effective_date'] !='0000-00-00'){
				$andt = explode('-',$data_edit['effective_date']);
				$effective_date = $andt[1].'/'.$andt[2].'/'.$andt[0];
			}else{
				$effective_date ='';
			}
			$headline = com_db_output($data_edit['headline']);
			$full_body = preg_replace('/<br( )?(\/)?>/i', "\r", $data_edit['full_body']);
			$short_url = com_db_output($data_edit['short_url']);
			$movement_type = com_db_output($data_edit['movement_type']);
			$what_happened = com_db_output($data_edit['what_happened']);
			$movement_type = com_db_output($data_edit['movement_type']);
			$source_id = com_db_output($data_edit['source_id']);
			$movement_url = com_db_output($data_edit['movement_url']);
			$more_link = com_db_output($data_edit['more_link']);
			$not_current = com_db_output($data_edit['not_current']);
			
		break;	
	case 'activate':
     		
	   		$status=$_GET['status'];
			if($status==0){
				$query = "update " . TABLE_MOVEMENT_MASTER . " set status = '1' where move_id = '" . $mID . "'";
			}else{
				$query = "update " . TABLE_MOVEMENT_MASTER . " set status = '0' where move_id = '" . $mID . "'";
			}	
			com_db_query($query);
	  		com_redirect("index.php?action=Directory&p=". $p ."&mID=" . $mID . "&msg=" . msg_encode("Movement update successfully"));
			
		break;
				
    }
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CTOsOnTheMove.com</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/combo-box.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="../images/favicon.jpg" type="image/x-icon" />
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="only-dataentry.js"></script>
  
<script type="text/javascript" src="../js/datetimepicker_css.js" language="javascript"></script>  
<script type="text/javascript">
function confirm_del(nid,p){
	var agree=confirm("Movement will be deleted. \n Do you want to continue?");
	if (agree)
		window.location = "index.php?mID=" + nid + "&p=" + p + "&action=delete";
	else
		window.location = "index.php?mID=" + nid + "&p=" + p ;
}

function CheckAll(numRows){
	if(document.getElementById('all').checked){
		for(i=1; i<=numRows; i++){
			var move_id='move_id-'+ i;
			document.getElementById(move_id).checked=true;
		}
	} else {
		for(i=1; i<=numRows; i++){
			var move_id='move_id-'+ i;
			document.getElementById(move_id).checked=false;
		}
	}
}

function AllDelete(numRows){

	var flg=0;
	for(i=1; i<=numRows; i++){
			var move_id='move_id-'+ i;
			if(document.getElementById(move_id).checked){
				flg=1;
			}	
		}
	if(flg==0){
		alert("Please checked atlist one checkbox for delete.");
		document.getElementById('move_id-1').focus();
		return false;
	} else {
		var agree=confirm("Movement will be deleted. \n Do you want to continue?");
		if (agree)
			 document.topicform.submit();
		else
			window.location = "index.php";
	}	

}

function confirm_artivate(nid,p,status){
	if(status=='1'){
		var msg="Movement will be active. \n Do you want to continue?";
	}else{
		var msg="Movement will be Inactive. \n Do you want to continue?";
	}
	var agree=confirm(msg);
	if (agree)
		window.location = "index.php?mID=" + nid + "&p=" + p + "&status=" + status + "&action=activate";
	else
		window.location = "index.php?mID=" + nid + "&p=" + p ;
}


function MovementSearch(){
	window.location ='index.php?action=MovementSearch';
}

</script>
<!--<script language="JavaScript" src="includes/editor.js"></script>-->
<script type="text/javascript" src="selectuser.js" language="javascript"></script>
<script type="text/javascript" src="selectusernext.js" language="javascript"></script>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
</head>
<body>
<div id="light" class="white_content" style="display:<? if($action=='MovementSearch'){ echo 'block';} else { echo 'none'; } ?>; height:auto;">
		<div id="spiffycalendar" class="text"></div>
		<link rel="stylesheet" type="text/css" href="includes/javascript/spiffyCal/spiffyCal_v2_1.css">
		<script language="JavaScript" src="includes/javascript/spiffyCal/spiffyCal_v2_1.js"></script>
		<script language="javascript"><!--
		  var dateAvailableFrom = new ctlSpiffyCalendarBox("dateAvailableFrom", "frmSearch", "from_date","btnDate1","",scBTNMODE_CUSTOMBLUE);
		  var dateAvailableTo = new ctlSpiffyCalendarBox("dateAvailableTo", "frmSearch", "to_date","btnDate2","",scBTNMODE_CUSTOMBLUE);	
		//--></script>
		<form name="frmSearch" id="frmSearch" method="post" action="index.php?action=MovementSearchResult">
		<table width="90%" border="0" align="center" cellpadding="1" cellspacing="1">
		  <tr>
			<td align="left" colspan="2" valign="top"><img src="images/specer.gif" width="1" height="50" alt="" title="" /> </td>
		  </tr>
          <tr><td colspan="2">&nbsp;</td></tr>
          <tr>
			<td width="32%" align="left" valign="top" >Title:</td>
			<td width="68%" align="left" valign="top"><input type="text" name="search_title" id="search_title" size="30" /></td>
		  </tr>
          <tr><td colspan="2">&nbsp;</td></tr>
		  <tr>
			<td align="left" valign="top" >Company Name:</td>
			<td align="left" valign="top">
                 <input type="text" name="search_company_name" id="search_company_name" size="30"/>
            </td>
		  </tr>
          <tr><td colspan="2">&nbsp;</td></tr>
          <tr>
			<td align="left" valign="top" >Company URL:</td>
			<td align="left" valign="top">
            <input type="text" name="search_company_url" id="search_company_url" size="30"/>
            </td>
		  </tr>
          <tr><td colspan="2">&nbsp;</td></tr>
		  <tr>
			<td align="left" valign="top" >First Name:</td>
			<td align="left" valign="top"><input type="text" name="search_first_name" id="search_first_name" size="30"/></td>
		  </tr>
          <tr><td colspan="2">&nbsp;</td></tr>
           <tr>
			<td align="left" valign="top" >Last Name:</td>
			<td align="left" valign="top"><input type="text" name="search_last_name" id="search_last_name" size="30"/></td>
		  </tr>
          <tr><td colspan="2">&nbsp;</td></tr>
		  <tr>
			<td align="left" valign="top">Announcement Date:</td>
			<td align="left" valign="top">
				From:<script language="javascript">dateAvailableFrom.writeControl(); dateAvailableFrom.dateFormat="MM/dd/yyyy";</script>
			</td>
		  </tr>
          <tr><td colspan="2">&nbsp;</td></tr>
		  <tr>
			<td align="center" valign="top">&nbsp;</td>
			<td align="left" valign="top">
				To:&nbsp;&nbsp;&nbsp;<script language="javascript">dateAvailableTo.writeControl(); dateAvailableTo.dateFormat="MM/dd/yyyy";</script>
			</td>
		  </tr>
		   <tr>
			<td align="center" valign="top">&nbsp;</td>
			<td align="center" valign="top">&nbsp;</td>
		  </tr>
		  <tr>
			<td align="center" valign="top">&nbsp;</td>
		  	<td align="left" valign="top"><input type="submit" value="Search" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="Cancel" onclick="window.location='index.php'" /></td>
		  </tr>
		  <tr>
			<td align="center" valign="top">&nbsp;</td>
			<td align="center" valign="top">&nbsp;</td>
		  </tr>
		</table>
		</form>
	</div>
	<div id="fade" class="black_overlay" style="display:<? if($action=='MovementSearch'){ echo 'block';} else { echo 'none'; } ?>;"></div>



<table width="1002" border="0" align="center" cellpadding="0" cellspacing="0">

  <tr>
    <td width="21" align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top" class="top-header-bg"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="left" valign="top"><!--<img src="<?=HTTP_SERVER.DIR_WS_HTTP_FOLDER.DIR_IMAGES?>specer.gif" width="1" height="38" alt="" title="" />-->
            <? include_once("includes/top-menu.php"); ?>
        </td>
      </tr>
      <tr>
        <td align="center" valign="top"><table width="928" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="196" align="left" valign="top"><a href="index.php"><img src="<?=HTTP_SERVER.DIR_WS_HTTP_FOLDER.DIR_IMAGES?>logo.jpg"  alt="Logo" width="196" height="32" border="0" title="Logo" /></a></td>
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
				  
				  <td width="3%" align="right" valign="middle"><a href="#"><img src="images/search-icon.jpg" border="0" width="25" height="28"  alt="Search Contact" title="Search Contact" onclick="MovementSearch('MovementSearch');"  /></a></td>
				  <td width="5%" align="left" valign="middle" class="nav-text">Search</td>
				  <td align="left" valign="middle"><a href="#"><img src="images/folder-icon.jpg" border="0" width="22" height="22" alt="Directory" title="Directory" onclick="window.location='index.php?action=Directory'"  /></a></td>
                  <td align="left" valign="middle" class="nav-text">Directory</td>
				  <td width="3%" align="right" valign="middle"><a href="#"><img src="<?=HTTP_SERVER.DIR_WS_HTTP_FOLDER.DIR_IMAGES?>add-icon.jpg" border="0" width="25" height="28" alt="Add Contact" title="Add Contact" onclick="window.location='index.php?action=add'"  /></a></td>
                  <td width="8%" align="left" valign="middle" class="nav-text">Add New</td>
                  <!--<td width="4%" align="right" valign="middle"><a href="#"><img src="<?//=HTTP_SERVER.DIR_WS_HTTP_FOLDER.DIR_IMAGES?>delete-icon.jpg" border="0" width="25" height="28"  alt="Delete Contact" title="Delete Contact" onclick="AllDelete('<?//=$numRows?>');"  /></a></td>
                  <td width="9%" align="left" valign="middle" class="nav-text">Delete</td>-->
                
				</tr>
			</table>
		</td>
      </tr>
      
    </table></td>
  </tr>
</table></td>
    <td width="21" align="left" valign="top">&nbsp;</td>
  </tr>
  <? if($action == 'detailes'){
	  	$company_id = com_db_output($data_edit['company_id']);
		$comQuery ="select c.company_name,c.company_website,c.company_logo,r.name as company_revenue,e.name as company_employee,
							i.title as company_industry,c.address,c.address2,c.city,s.short_name as state,
							ct.countries_name as country,c.zip_code,c.phone,c.fax,c.about_company,c.leadership_page,c.email_pattern,c.facebook_link,c.linkedin_link,c.twitter_link,c.googleplush_link,c.add_date from " 
							.TABLE_COMPANY_MASTER. " as c, " 
							.TABLE_REVENUE_SIZE." as r, "
							.TABLE_EMPLOYEE_SIZE." as e, "
							.TABLE_INDUSTRY." as i, "
							.TABLE_STATE." as s, "
							.TABLE_COUNTRIES." as ct							
							where c.company_revenue=r.id and c.company_employee=e.id and c.company_industry=i.industry_id and c.state=s.state_id and c.country=ct.countries_id and c.company_id = '" . $company_id . "'";
		$comResult = com_db_query($comQuery);
		$comRow = com_db_fetch_array($comResult);
		
			$company_name = com_db_output($comRow['company_name']);
			$company_industry = com_db_output($comRow['company_industry']);
			$address = com_db_output($comRow['address'].', '.$comRow['address2']);
			$city = com_db_output($comRow['city']);
			$state = com_db_output($comRow['state']);
			$country = com_db_output($comRow['country']);
			$zip_code = com_db_output($comRow['zip_code']);
			$about_company = com_db_output($comRow['about_company']);
		
		$perQuery ="select * from " .TABLE_PERSONAL_MASTER. " where personal_id = '" . $personal_id . "'";
		$perResult=com_db_query($perQuery);
		$perRow=com_db_fetch_array($perResult);
			
			$first_name = com_db_output($perRow['first_name']);
			$middle_name = com_db_output($perRow['middle_name']);
			$last_name = com_db_output($perRow['last_name']);
			$email = com_db_output($perRow['email']);
			$phone = com_db_output($perRow['phone']);
			$about_person = com_db_output($perRow['about_person']);
	
		$source  = com_db_output(com_db_GetValue("select source from ".TABLE_SOURCE." where id='".$source_id ."'"));
		
	  ?>
  	 <tr>
      <td align="left"  valign="top">&nbsp;</td>
            <td align="left" valign="middle"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">

              <tr>
                <td align="left" valign="middle" class="registration-page-heading-bg"><table width="960" border="0" align="left" cellpadding="0" cellspacing="0">
                    <tr>
                    <td align="left" valign="top"><img src="../images/specer.gif" width="1" height="10" alt="" title="" /></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="registration-page-title-text"><?=$headline?></td>
                    </tr>
					    <tr>
                      <td align="left" valign="middle" class="vagilant-nav-link-text"><table width="95%" border="0" align="left" cellpadding="0" cellspacing="0">
                        <tr>
                          
                          <td align="left" valign="middle">Source: <?=$source?></td>
                         
                        </tr>
                      </table></td>
                    </tr>
                </table></td>
              </tr>
        
            </table></td>
      <td align="left"  valign="top">&nbsp;</td>
    </tr>
    <!-- heading end -->
    <!-- content start -->
   <tr>
      <td align="left"  valign="top">&nbsp;</td>
      <td align="center" valign="top" class="vagilant-page-bg-new"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
         <td align="left" valign="top"><img src="../images/specer.gif" width="1" height="27" alt="" title="" /></td>
        </tr>
        <tr>
          <td align="center" valign="top"><table width="928" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="558" align="left" valign="top"><table width="558" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="left" valign="top"><table width="558" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="left" valign="top"><img src="../images/vigilant-inner-box-top.gif" width="558" height="16"  alt="" title=""/></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top" class="vagilant-box-inner-border"><table width="556" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="199" align="center" valign="middle" bgcolor="#E8E8E8" class="vagilant-box-heading-text">What happened?</td>
                          <td width="357" align="left" valign="middle" class="vagilant-box-arrow"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                              <td align="left" valign="middle" class="vagilant-box-text">
							  <?=$what_happened;?>
							  </td>
                            </tr>
                          </table></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top"><img src="../images/vigilant-inner-box-bottom.gif" width="558" height="16"  alt="" title=""/></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
               
                <tr>
                  <td align="left" valign="top"><table width="558" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="left" valign="top"><img src="../images/vigilant-inner-box-top.gif" width="558" height="16"  alt="" title=""/></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top" class="vagilant-box-inner-border"><table width="556" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="199" align="center" valign="middle" bgcolor="#E8E8E8" class="vagilant-box-heading-text">About the person:</td>
                            <td width="357" align="left" valign="middle" class="vagilant-box-arrow"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                  <td align="left" valign="middle" class="vagilant-box-text">
									<?=$about_person;?>
								  </td>
                                </tr>
                            </table></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top"><img src="../images/vigilant-inner-box-bottom.gif" width="558" height="16"  alt="" title=""/></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="top"><table width="558" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="left" valign="top"><img src="../images/vigilant-inner-box-top.gif" width="558" height="16"  alt="" title=""/></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top" class="vagilant-box-inner-border"><table width="556" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="199" align="center" valign="middle" bgcolor="#E8E8E8" class="vagilant-box-heading-text">About the Company:</td>
                            <td width="357" align="left" valign="middle" class="vagilant-box-arrow"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                  <td align="left" valign="middle" class="vagilant-box-text">
								  <?=$about_company;?>
								  </td>
                                </tr>
                            </table></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top"><img src="../images/vigilant-inner-box-bottom.gif" width="558" height="16"  alt="" title=""/></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="top"><table width="558" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="left" valign="top"><img src="../images/vigilant-inner-box-top.gif" width="558" height="16"  alt="" title=""/></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top" class="vagilant-box-inner-border"><table width="556" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="199" align="center" valign="middle" bgcolor="#E8E8E8" class="vagilant-box-heading-text">Info source:</td>
                            <td width="357" align="left" valign="middle" class="vagilant-box-arrow"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                  <td align="left" valign="middle" class="vagilant-box-text">
								  	 <?=$source;?>
								  </td>
                                </tr>
                            </table></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top"><img src="../images/vigilant-inner-box-bottom.gif" width="558" height="16"  alt="" title=""/></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
             
              </table></td>
              <td width="56" align="left" valign="top"><img src="../images/line-devider.gif" width="56" height="467" /></td>
              <td width="302" align="left" valign="top"><table width="302" border="0" align="left" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="left" valign="top" class="vagilant-right-box-text">Brought to you by:</td>
                </tr>
                <tr>
                  <td align="left" valign="top" class="vagilant-box-blue-heading-text">CTOs On The Move</td>
                </tr>
                <tr>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="top"><img src="../images/vigilant-right-box-devider.gif" width="302" height="29"  alt="" title=""/></td>
                </tr>
                <tr>
                  <td align="left" valign="top">
				  <table width="302" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top" class="vagilant-right-list-box">
	<table width="302" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="100" align="left" valign="top"><b>Name:</b></td>
        <td width="202" align="left" valign="top"><?=$first_name.' ' .$last_name;?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="vagilant-right-list-box"><table width="302" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="100" align="left" valign="top"><b>New Title:</b></td>
        <td width="202" align="left" valign="top"><?=$title?></td>
      </tr>
    </table></td>
  </tr>
  	
  <tr>
    <td align="left" valign="top" class="vagilant-right-list-box"><table width="302" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="100" align="left" valign="top"><b>New Company:</b></td>
        <td width="202" align="left" valign="top"><?=$company_name?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top" class="vagilant-right-list-box"><table width="302" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="100" align="left" valign="top"><b>Industry:</b></td>
        <td width="202" align="left" valign="top"><?=$company_industry?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top" class="vagilant-right-box-text"><strong>Full contact details: </strong></td>
  </tr>
</table>				  </td>
                </tr>
                <tr>
                  <td align="left" valign="top"><img src="../images/vigilant-right-box-devider.gif" width="302" height="29"  alt="" title=""/></td>
                </tr>
              
				<tr>
					<td>	  
				  		<table width="302" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="left" valign="top" class="vagilant-right-list-box"><table width="302" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="100" align="left" valign="top"><b>Address:</b></td>
                            <td width="202" align="left" valign="top"><?=$address?></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top" class="vagilant-right-list-box"><table width="302" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="100" align="left" valign="top"><b>State:</b></td>
                            <td width="202" align="left" valign="top"><?=$state;?></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top" class="vagilant-right-list-box"><table width="302" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="100" align="left" valign="top"><b>Zip:</b></td>
                            <td width="202" align="left" valign="top"><?=$zip_code;?></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top" class="vagilant-right-list-box"><table width="302" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="100" align="left" valign="top"><b>Country:</b></td>
                          <td width="202" align="left" valign="top"><?=$country;?></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top" class="vagilant-right-list-box"><table width="302" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td width="100" align="left" valign="top"><b>Email:</b></td>
                          <td width="202" align="left" valign="top"><?=$email;?></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top" class="vagilant-right-list-box"><table width="302" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="100" align="left" valign="top"><b>Phone:</b></td>
                            <td width="202" align="left" valign="top"><?=$phone;?></td>
                          </tr>
                      </table></td>
                    </tr>

                  </table>
				   </td>
                </tr>
				
                <tr>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
       
          <td align="center" valign="top"><img src="../images/registration-page-bottom-bg.jpg" width="960" height="11" alt="" title="" /></td>
        </tr>
      </table></td>
      <td align="left"  valign="top">&nbsp;</td>
    </tr>
  
  <? } else {?>
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
                    <td align="left" valign="middle" class="press-release-page-title-text">Press Release  : </td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><img src="<?=HTTP_SERVER.DIR_WS_HTTP_FOLDER.DIR_IMAGES?>specer.gif" width="1" height="10" alt="" title="" /></td>
                  </tr>
              
              </table></td>
            </tr>
          </table></td>
        </tr>
<? if($action=='Directory' || $action =='save' || $action=='MovementSearchResult'){	?>	
        <tr>
          <td align="center" valign="top">
		  
		  <form name="topicform" id="topicform" method="post" action="index.php?action=alldelete&p=<?=$p?>">
		  	<table width="100%" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="27" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-title-text">#</span></td>
				<td width="38" height="30" align="center" valign="middle" class="right-border">
				<input type="checkbox" name="all" id="all" onclick="CheckAll('<?=$numRows?>');" /></td>
				<td width="153" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Name</span> </td>
				<td width="198" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Title</span> </td>
                <td width="234" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Company</span> </td>
				<td width="84" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Movement Type</span> </td>
				<td width="64" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Date</span> </td>
                <td width="114" height="30" align="center" valign="middle" class="left-border"><div align="center"><span class="right-box-title-text">Action</span></div></td>
			  </tr>
			<?php
			
			if($total_data>0) {
				$i=1;
				while ($data_sql = com_db_fetch_array($exe_data)) {
				$adt = explode('-',$data_sql['add_date']);
				$add_date = date('m/d/Y',mktime(0,0,0,$adt[1],$adt[2],$adt[0]));
				$status = $data_sql['status'];
				$company_name = com_db_output($data_sql['company_name']);
				$comURL = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''),$company_name).'_Company_'.$data_sql['company_id'];
				$movementType = com_db_GetValue("select name from ".TABLE_MANAGEMENT_CHANGE." where id='".$data_sql['movement_type']."'");
			?>          
			  <tr>
				<td height="30" align="center" valign="middle" class="right-border-left"><?=$i;?></td>
				<td height="30" align="center" valign="middle" class="right-border"><input type="checkbox" id="contact_id-<?=$i;?>" name="nid[]" value="<?=$data_sql['move_id'];?>" /></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><a href="<?=HTTP_SITE_URL.com_db_output($data_sql['first_name'].'_'.$data_sql['last_name'].'_Exec_'.$data_sql['personal_id'])?>" target="_blank"><?=com_db_output($data_sql['first_name']).' '.com_db_output($data_sql['last_name'])?></a></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><a href="<?=HTTP_SITE_URL.$data_sql['movement_url'];?>" target="_blank"><?=com_db_output($data_sql['title'])?></a></td>
                <td height="30" align="left" valign="middle" class="right-border-text"><a href="<?=HTTP_SITE_URL.$comURL;?>" target="_blank"><?=com_db_output($data_sql['company_name'])?></a></td>
				<td height="30" align="center" valign="middle" class="right-border"><?=$movementType;?></td>
                <td height="30" align="center" valign="middle" class="right-border"><?=$add_date;?></td>
				<td height="30" align="center" valign="middle" class="left-border">
					<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr> 
					  	 <?	if($status==0){ ?>
					   	<td width="31%" align="center" valign="middle"><a href="#"><img src="images/icon/active-icon.gif" width="16" height="16" alt="" title="" border="0" onclick="confirm_artivate('<?=$data_sql['move_id'];?>','<?=$p;?>','<?=$status;?>');" /></a><br />
					   	  Status</td>
					   	<?php } elseif($status==1){ ?>
					   	<td width="25%" align="center" valign="middle"><a href="#"><img src="images/icon/inactive-icon.gif" width="16" height="16" alt="" title="" border="0" onclick="confirm_artivate('<?=$data_sql['move_id'];?>','<?=$p;?>','<?=$status;?>');" /></a><br />
					   	  Status</td>
						<? } ?>
					   	<td width="50%" align="center" valign="middle"><a href="#"><img src="images/small-edit-icon.gif" width="16" height="16" alt="Edit" title="Edit" border="0" onclick="window.location='index.php?&p=<?=$p;?>&mID=<?=$data_sql['move_id'];?>&action=edit'" /></a><br />
						  Edit</td>
						<td width="24%" align="center" valign="middle"><a href="#"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" title="Delete" border="0" onclick="confirm_del('<?=$data_sql['move_id'];?>','<?=$p;?>')" /></a><br />
						  Delete</td>
					  </tr>
					</table></td>
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
		  <script language="javascript" type="text/javascript">
			function chk_form_Add()
                        {
                            var first_name=document.getElementById('first_name').value;
                            var last_name=document.getElementById('last_name').value;
                            var movement_type=document.getElementById('movement_type').value;

                            if(movement_type == 4 || movement_type == 5 || movement_type == 6)
                            {
                                xmlhttp=GetXmlHttpObject();
                                if (xmlhttp==null)
                                {
                                    alert ("Browser does not support HTTP Request");
                                    return;
                                }

                                //var sval =document.getElementById(str).value;
                                var url="getuser.php";
                                url=url+"?type=SetCompany&fname="+first_name+"&lname="+last_name;
                                url=url+"&sid="+Math.random();
                                //console.log("URL: "+url);
                                xmlhttp.onreadystatechange=SetCompanyAfter;
                                xmlhttp.open("GET",url,false);
                                xmlhttp.send(null);
                            }    


                            var title=document.getElementById('title').value;
                            var company_name=document.getElementById('company_name').innerHTML;

                            var city=document.getElementById('city').innerHTML;
                            var state=document.getElementById('div_state').innerHTML;

                            //alert("Movement Type:"+movement_type);
                            //alert("First name:"+first_name);
                            //alert("Last name:"+last_name);


                            //alert("Company ID After sett:"+document.getElementById("company_id_auto").value);
                            //return false;

                            if(first_name==''){
                                alert("Please enter first name.");
                                document.getElementById('first_name').focus();
                                return false;
                            }

                            if(last_name==''){
                                alert("Please enter last name.");
                                document.getElementById('last_name').focus();
                                return false;
                            }

                            if(movement_type==''){
                                alert("Please enter movement type.");
                                document.getElementById('movement_type').focus();
                                return false;
                            }

                            if(title==''){
                                alert("Please enter title.");
                                document.getElementById('title').focus();
                                return false;
                            }

                            if(company_name==''){
                                alert("Please enter company name.");
                                //document.getElementById('company_name').focus();
                                return false;
                            }
                            else
                                document.getElementById('searched_company_name').value = company_name;

                            if(city==''){
                                alert("Please enter city.");
                                //document.getElementById('company_name').focus();
                                return false;
                            }
                            else
                                document.getElementById('searched_company_city').value = city;

                            if(state==''){
                                alert("Please enter state.");
                                //document.getElementById('company_name').focus();
                                return false;
                            }
                            else
                                document.getElementById('searched_company_state').value = state;
				
			}
                        
                        function SetCompanyAfter()
                        {
                            if (xmlhttp.readyState==4)
                            {
                                //var current_comp_id = document.getElementById("company_id").value;
                                var current_comp = document.getElementById("company_name").innerHTML;
                                //alert("Current_comp: "+current_comp);
                                if(current_comp == '')
                                {    
                                    //alert("ResponseText: "+xmlhttp.responseText);
                                    var comp_res = xmlhttp.responseText;
                                    //alert("Comp_res: "+comp_res);
                                    var res_arr = comp_res.split(":");
                                    //alert("RES ARR 1: "+res_arr[1]); return false;
                                    document.getElementById("company_id_auto").value = res_arr[0];
                                    document.getElementById("company_name").innerHTML = res_arr[1];
                                    document.getElementById("searched_company_name").innerHTML = res_arr[1];
                                    document.getElementById("city").innerHTML = res_arr[2];
                                    document.getElementById("searched_company_city").value = res_arr[2];
                                    
                                    document.getElementById("div_state").innerHTML = res_arr[3];
                                    document.getElementById("searched_company_state").value = res_arr[3];
                                    
                                    document.getElementById("company_website").value = res_arr[4];
                                }    
                            }
                        }
                        
                        
                        
			function ClosePersonalDetails(){
				document.getElementById('DivPersonalDetails').style.display="none";
			}
			function ShowEmailVerifiedDate()
			{
				var email_send_flag = document.getElementById('executiveEmailSend').value;
				if(email_send_flag == 1)
				{
					var date = '<?=date("m/d/Y");?>';
					//document.getElementById('email_verified_date').innerHTML=date;
							
					document.getElementById('DivValidatedEmail').style.display="inline";	
					document.getElementById("DivValidatedEmail").innerHTML=date+" - valid";
				}

				
				if(1 == 2)
				{
					var email_send_flag = document.getElementById('executiveEmailSend').value;
					if(email_send_flag == 1)
					{
					
						// reverse engineers the patterns and updates the
						xmlhttp=GetXmlHttpObject();
						if (xmlhttp==null)
						{
							alert ("Browser does not support HTTP Request");
							return;
						}
						
						var first_name 				= document.getElementById('first_name').value;
						var middle_name				= document.getElementById('middle_name').value;
						var last_name 				= document.getElementById('last_name').value;
						var company_email_domain 	= document.getElementById('company_email_domain').value;
						var person_email			= document.getElementById('person_email').value;
						
						//var current_email_pattern	= document.getElementById('email_pattern').value;
						
						var cep = document.getElementById("company_email_pattern");
						var current_company_email_pattern = cep.options[cep.selectedIndex].value;
						var company_website	= document.getElementById('company_website').value;
						
						var url="getuser.php";
						url=url+"?type=ReverseEngineer&person_email="+person_email+"&first_name="+first_name+"&middle_name="+middle_name+"&last_name="+last_name+"&email_domain="+company_email_domain+"&current_company_email_pattern="+current_company_email_pattern+"&company_website="+company_website;
						url=url+"&sid="+Math.random();
						//console.log("ELSE URL: "+url);
						//document.getElementById('DivValidatedEmail').innerHTML = '';
						//document.getElementById('validation_wait').style.display='block';
						xmlhttp.onreadystatechange=ShowRevEngResponse;
						xmlhttp.open("GET",url,true);
						xmlhttp.send(null);
						
						
					}
					else
					{
						//alert(document.getElementById('executiveEmailSend').value);
					
						if(document.getElementById('email_verified').checked)
						{
							var date = '<?=date("m/d/Y");?>';
							document.getElementById('email_verified_date').innerHTML=date;
						}
						else
						{
							document.getElementById('email_verified_date').innerHTML='';
						}
					}	
				}	
			}
			
			function ShowRevEngResponse()
			{
				if (xmlhttp.readyState==4)
				{
					alert("Res: "+xmlhttp.responseText);
					document.getElementById('DivValidatedEmail').style.display="inline";	
					document.getElementById("DivValidatedEmail").innerHTML=xmlhttp.responseText;
					
					
					
				}
			}
			
			</script>
		  <form name="frmDataAdd" id="frmDataAdd" method="post" action="index.php?action=addsave" enctype="multipart/form-data" onsubmit="return chk_form_Add();">
		  <input type="hidden" name="searched_company_name" id="searched_company_name" value="">
		  <input type="hidden" name="searched_company_city" id="searched_company_city" value="">
		  <input type="hidden" name="searched_company_state" id="searched_company_state" value="">
                  <input type="hidden" name="company_id_auto" id="company_id_auto" value="">
		  
		  <input type="hidden" name="executiveEmailSend" id="executiveEmailSend" value="">
		  <table width="95%" align="left" cellpadding="5" cellspacing="5" border="0" style="position:relative;">
            <tr>
            	<td>
                	<div id="DivPersonalDetails" style="display:none;">
                       
                    </div>
                </td>
            </tr> 
            <tr>
              <td align="left">
                <table width="100%" cellpadding="4" cellspacing="4" border="0">
                  	<tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Title:</b></td>
                        <td width="75%" align="left" valign="top">
                          <input type="text" name="title" id="title" size="30" />
                   	</tr>
                  	<tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Person Name:</b></td>
                        <td width="75%" align="left" valign="top">
                            <input type="radio" name="person_option" id="person_option_old" checked="checked" value="Old" /><b>Old Person</b> &nbsp;&nbsp;<input type="radio" name="person_option" id="person_option_new" value="New" /><b>New Person</b><br />
                        </td>	
                    </tr>
                    <tr>
                       <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;First Name:</td>
                        <td width="75%" align="left" valign="top">
                            <input type="text" name="first_name" id="first_name" size="30" />
                        </td>
                    </tr>
                    <tr>
                       <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Middle Name:</td>
                        <td width="75%" align="left" valign="top">
                            <input type="text" name="middle_name" id="middle_name" size="30" value=""/>
                        </td>
                    </tr>
                    <tr>
                       <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Last Name:</td>
                        <td width="75%" align="left" valign="top">
                            <input type="text" name="last_name" id="last_name" size="30" onkeyup="PersonalCompanyNameMovementInLastName();"/>
                            <div id="DivPersonalCompanyNameInLastName" style="display:none;"></div>
                        </td>
                    </tr>
                    <tr>
                       <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Email:</td>
                        <td width="75%" align="left" valign="top">
                            <input type="text" name="person_email" id="person_email" size="30" value="" onkeyup="chnageButton()" onblur="PersonalDetailsShow('person_email','movement_entry');"/>&nbsp;&nbsp;<input type="checkbox" name="email_verified" id="email_verified" value="Yes" onclick="ShowEmailVerifiedDate();" />Verified &nbsp;<span id="email_verified_date" /></span><span style="margin-left:30px;" id="DivValidatedEmail"></span>
							<br><br>
							<input type="button" value="Generate Email" onclick="generate_email()" name="generate_email_btn" id="generate_email_btn" disabled>
							&nbsp;&nbsp;&nbsp;<input type="button" value="Validate Email" onclick="validate_email()" name="validate_email_btn" id="validate_email_btn" disabled>
                                                            <input type="button" value="Another Pattern?" onclick="another_pattern()" name="another_pattern_btn" id="another_pattern_btn" style="display:none">
							
							
							<span id="validation_wait" style="display:none;color:#993300;font-family:Verdana, Arial, Helvetica, sans-serif;">Please wait...</span>
							
							<span id="DivGeneratedEmail"></span>
							
						</td>
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Email Verified Image:</td>
                      <td width="75%" align="left" valign="top"><input type="file" name="verified_image" id="verified_image" /></td>	
                    </tr>
					
					<!--
					<tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;<input type="button" value="Generate Email" onclick="generate_email()" name="generate_email_btn" id="generate_email_btn" disabled></td>
                      <td width="75%" align="left" valign="top">
						<span id="DivGeneratedEmail"></span>
					  </td>
                    </tr>
					-->
					
                    <tr>
                       <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Phone:</td>
                        <td width="75%" align="left" valign="top">
                            <input type="text" name="person_phone" id="person_phone" size="30" value=""/>
                        </td>
                    </tr>
                    <tr>
                       <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Person's photo:</td>
                        <td width="75%" align="left" valign="top">
                            <div id="divPersonPhoto">
                              <input type="file" name="person_photo" id="person_photo" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                       <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;About Person:</td>
                        <td width="75%" align="left" valign="top">
                            <div id="divAboutPerson">
                            <textarea  id="about_person" name="about_person"></textarea>
                            <script type="text/javascript">
                            //<![CDATA[
                                CKEDITOR.replace('about_person');
                            //]]>
                            </script>
                        	</div>
                        </td>
                    </tr>
                    <!--                    
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Person Facebook Link:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="person_facebook_link" id="person_facebook_link" size="30" value="" /></td>	
                    </tr>
                    -->
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Person LinkedIn Link:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="person_linkedin_link" id="person_linkedin_link" size="30" value="" /></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Person Twitter Link:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="person_twitter_link" id="person_twitter_link" size="30" value="" /></td>	
                    </tr>
                    
                    <!--
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Person Google+ Link:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="person_googleplush_link" id="person_googleplush_link" size="30" value="" /></td>	
                    </tr>
                    -->
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Company Website:</b></td>
                        <td width="75%" align="left" valign="top">
                        	<input type="hidden" name="company_id" id="company_id" />
                        	<input type="text" name="company_website" id="company_website" size="30" value="Enter Company url" onfocus=" if (this.value == 'Enter Company url') { this.value = ''; }" onblur="if (this.value == '') { this.value='Enter Company url';} " onkeyup="CompanyNameMovement('company_website');"/>
                        	<div id="DivCompanyNameShowMovement" style="display:none;"></div>

                            <!--<input type="text" name="company_website" id="company_website" size="30" onblur="CompanyInformationMovement('company_website');"/>-->
                            <div id="div_company_website" style="display:none;color:#993300;font-family:Verdana, Arial, Helvetica, sans-serif;">Please wait...</div>
                        </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Company Name:</td>
                      <td width="75%" align="left" valign="top">
						<div id="company_name"></div>
					  </td>	
                    </tr>
					
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Company Logo:</td>
                      <td width="75%" align="left" valign="top"><div id="divComapnyLogo"></div>
                      <!--<div id="divComapnyLogo">
                      <input type="file" name="company_logo" id="company_logo" />
                      </div> -->
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Size ($Revenue):</td>
                      <td width="75%" align="left" valign="top"><div id="div_company_revenue"></div></td>
					  <!--
                        <div id="div_company_revenue">
							<select name="company_revenue" id="company_revenue" style="width:206px;">
							<?=selectComboBox("select id,name from ".TABLE_REVENUE_SIZE." where status='0' order by from_range","")?>
							<option value="Any">Any</option>
							</select>
						</div>                      	
						-->
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Size (Employees):</td>
                      <td width="75%" align="left" valign="top">
                        <div id="div_company_employee"></div>
						<!--
							<select name="company_employee" id="company_employee" style="width:206px;">
							<?=selectComboBox("select id,name from ".TABLE_EMPLOYEE_SIZE ." where status='0' order by from_range","")?>
							<option value="Any">Any</option>
							</select>
						 -->	
                        </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Industry:</td>
                      <td width="75%" align="left" valign="top">
                        <div id="div_company_industry"></div> 
						<?php
						//$industry_result = com_db_query("select * from " . TABLE_INDUSTRY ." where status='0' and parent_id = '0' order by title");
						?>
						<!--
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
						-->
						                     </td>	
                    </tr>
                    <tr>
                      <td align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Leadership Page:</td>
                      <td align="left" valign="top"><div id="leadership_page"></div></td>
                    </tr>
					
					
					<tr>
                      <td align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Email Domain:</td>
                      <td align="left" valign="top">
						<div id="company_email_domain"></div>
						<!-- <input type="text" name="company_email_domain" id="company_email_domain" size="30" value="" /> -->
					  </td>
                    </tr>
					
					
                    <tr>
                      <td align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Email Pattern:</td>
                      <td align="left" valign="top">
						<!-- <input type="text" name="email_pattern" id="email_pattern" size="30" value="" /> -->
						<div id="div_company_email_pattern"></div>
						<!--
						<div id="div_company_email_pattern">
						<select name="email_pattern" id="email_pattern" style="width:206px;" disabled>
							<?=selectComboBox("select pattern_id,email_pattern from  cto_email_patterns ","")?>
							
						</select>
						</div>
						-->
						
						<input type="hidden" name="company_email_pattern_id" id="company_email_pattern_id" value="">
					  </td>
                    </tr>
					
					
					
					 <tr>
                      <td align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Mail Server Settings:</td>
                      <td align="left" valign="top">
						<div id="div_company_mail_server_settings"></div>
							<?PHP //echo mail_server_settings_ComboBox('','265px','disabled'); ?>
						
						
						
						
					  </td>
                    </tr>
					
					
					
					
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Address:</td>
                      <td width="75%" align="left" valign="top"><div id="address"></div></td>	
                        <!-- <input type="text" name="address" id="address" size="30" value="" /> -->
                      
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Address 2:</td>
                      <td width="75%" align="left" valign="top"><div id="address2"></div></td>
                        <!-- <input type="text" name="address2" id="address2" size="30" value="" /> -->
                      	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;City:</td>
                      <td width="75%" align="left" valign="top">
						<div id="city"></div>	
                      <!--  <input type="text" name="city" id="city" size="30" value="" /> -->
                      </td>
                    </tr>
					<tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Country:</td>
                      <td width="75%" align="left" valign="top">
						<div id="div_country"></div>
						<!--
							<select name="country" id="country" style="width:206px;" onchange="StateChangeAdd('country');">
							<?=selectComboBox("select countries_id,countries_name from ".TABLE_COUNTRIES."  where countries_id=223",'223')?>
							<?=selectComboBox("select countries_id,countries_name from ".TABLE_COUNTRIES."  where countries_id<>223 order by countries_name",'')?>
							<option value="Any">Any</option>
							</select>
						-->	
						
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;State:</td>
                      <td width="75%" align="left" valign="top">
					    <div id="div_state"></div>
						<!--
							<select name="state" id="state" style="width:206px;">
							<?=selectComboBox("select state_id,short_name from ".TABLE_STATE." order by short_name","")?>
							<option value="Any">Any</option>
							</select>
						-->
                      </td>	
                    </tr>
                    
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Zip Code:</td>
                      <td width="75%" align="left" valign="top"><div id="zip_code"></div></td>	
                       <!-- <input type="text" name="zip_code" id="zip_code" size="30" value="" /> -->
                      
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;General Phone:</td>
                      <td width="75%" align="left" valign="top"><div id="phone"></div>
                        <!--<input type="text" name="phone" id="phone" size="30" value="" /> -->
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Fax:</td>
                      <td width="75%" align="left" valign="top"><div id="fax"></div>
                        <!-- <input type="text" name="fax" id="fax" size="30" value="" /> -->
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;About the Company?:</td>
                      <td width="75%" align="left" valign="top">
						<div id="divAboutCompany"></div>
						<!--
                      <div id="divAboutCompany">
                        <textarea  id="about_company" name="about_company"></textarea>
						<script type="text/javascript">
                        //<![CDATA[
                            CKEDITOR.replace('about_company');
                        //]]>
                        </script>
                      </div>
					  -->
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Company Facebook Link:</td>
                      <td width="75%" align="left" valign="top">
						<div id="facebook_link"></div>
						<!-- <input type="text" name="facebook_link" id="facebook_link" size="30" value="" />	 -->
						</td>
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Company LinkedIn Link:</td>
                      <td width="75%" align="left" valign="top"><div id="linkedin_link"></div>
						<!-- <input type="text" name="linkedin_link" id="linkedin_link" size="30" value="" />	 -->
					  </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;Company&nbsp;Twitter Link:</td>
                      <td width="75%" align="left" valign="top"><div id="twitter_link"></div>
						<!-- <input type="text" name="twitter_link" id="twitter_link" size="30" value="" /> -->
					  </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;Company&nbsp;Google+ Link:</td>
                      <td width="75%" align="left" valign="top">
						<div id="googleplush_link"></div>
						<!-- <input type="text" name="googleplush_link" id="googleplush_link" size="30" value="" /> -->
					  </td>	
                    </tr>
                    <!--<tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Company Name:</b></td>
                        <td width="75%" align="left" valign="top">
                            <select name="company_id" id="company_id" style="width:208px;" onchange="CompanyInformationMovement('company_id');">
                                <option value="">--Select Company Name--</option>
                                <?//=selectComboBox("select company_id,company_name from ".TABLE_COMPANY_MASTER." where status=0 order by company_name",'')?>
                            </select>
                        </td>	
                    </tr>
                    <tr>
                      <td align="left" colspan="2">
                            <div id="DivCompanyInformationMovementShow"></div>
                      </td>	
                    </tr>-->
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Announcement Date:</b></td>
                        <td width="75%" align="left" valign="top"><input type="text" name="announce_date" id="announce_date" size="30"/>
						<a href="javascript:NewCssCal('announce_date','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a></td>	
                    </tr>
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Effective Date:</b></td>
                        <td width="75%" align="left" valign="top"><input type="text" name="effective_date" id="effective_date" size="30"/>
						<a href="javascript:NewCssCal('effective_date','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a></td>	
                    </tr>
					
					
					 <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Movement Type:</b></td>
                        <td width="75%" align="left" valign="top">
                        	<select name="movement_type" id="movement_type" style="width:208px;" onchange="DublicatMovementUrlCreate();">
                                <option value="">--Select movement type--</option>
                                <?=selectComboBox("select id,name from ".TABLE_MANAGEMENT_CHANGE." where status=0 order by name",'')?>
                            </select><br />
                            <div id="divDublicatMovementUrl" style="display:none;"></div>
                        </td>	
                    </tr>
					
					
					<!--
                     <tr>
                      <td width="25%" align="left" class="page-text" valign="top"><b>Headline:</b></td>
                      <td width="75%" align="left" valign="top"><input type="text" name="headline" id="headline" size="30" value="" /></td>	
                    </tr>
					-->
		<!--			
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top"><b>Full Body:</b></td>
                      <td width="75%" align="left" valign="top"><textarea name="full_body" id="full_body" rows="5" cols="23" ></textarea></td>	
                    </tr>
                        
  
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top"><b>Short url:</b></td>
                      <td width="75%" align="left" valign="top"><input type="text" name="short_url" id="short_url" size="30" value="" /></td>	
                    </tr>
			-->		
					<!--
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>What Happened:</b></td>
                        <td width="75%" align="left" valign="top">
                         	<textarea  id="what_happened" name="what_happened"></textarea>
							<script type="text/javascript">
                            //<![CDATA[
                                CKEDITOR.replace('what_happened');
                            //]]>
                            </script>
                        </td>	
                    </tr>
                   -->
				   
				   
				   
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Source:</b></td>
                        <td width="75%" align="left" valign="top">
                        	<select name="source_id" id="source_id" style="width:208px;">
                                <option value="">--Select Source--</option>
                                <?=selectComboBox("select id,source from ".TABLE_SOURCE." where status=0 order by source",'')?>
                            </select>
                        </td>	
                    </tr>
                   
                   <!--
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Movement URL:</b></td>
                        <td width="75%" align="left" valign="top"><input type="text" name="movement_url" id="movement_url" size="70" onfocus="MovementUrlCreate();" /></td>	
                    </tr>
                   -->
                   
                   
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top"><b>More Link:</b></td>
                      <td width="75%" align="left" valign="top"><input type="text" name="more_link" id="more_link" size="30" value="" />
                      </td>	
                    </tr>
					<tr>
                      <td width="25%" align="left" class="page-text" valign="top"><b>Not Current?:</b></td>
                      <td width="75%" align="left" valign="top"><input type="checkbox" name="not_current" id="not_current" value="Yes" onclick="CurrentStatusCheck();" />
                      </td>	
                    </tr>
                  </table>
                </td>	
            </tr>
           
            <tr>
            	<td align="center">
                	<table width="50%" border="0" cellpadding="4" cellspacing="4">
                    	<tr><td><input type="submit" value="Add Movement" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="Cancel" onclick="window.location='index.php?p=<?=$p;?>&mID=<?=$mID;?>'" /></td></tr>
                    </table>
                </td>
             </tr>
            
			</table>
		  </form>
		  
		  </td>
        </tr>
	<? }elseif($action=='edit'){ ?>
		<tr>
          <td align="center" valign="top">
			<script language="javascript" type="text/javascript">
                function chk_form(){
                    var title=document.getElementById('title').value;
                    
                    if(title==''){
                        alert("Please enter title.");
                        document.getElementById('title').focus();
                        return false;
                    }
                }
            </script>		

		  <form name="frmDataEdit" id="frmDataEdit" method="post" action="index.php?action=editsave&mID=<?=$mID;?>&p=<?=$p;?>" onsubmit="return chk_form();">
		  <table width="95%" align="center" cellpadding="5" cellspacing="5" border="0">
             <tr>
              <td align="left">
                <table width="100%" cellpadding="4" cellspacing="4" border="0">
                  	<tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Title:</b></td>
                        <td width="75%" align="left" valign="top">
                          <input type="text" name="title" id="title" size="30" value="<?=$title;?>"/>
                   	</tr>
                  	<!--<tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Person Name:</b></td>
                        <td width="75%" align="left" valign="top">
                            <select name="personal_id" id="personal_id" style="width:208px;" onchange="PersonalInformationMovement('personal_id');">
                                <option value="">--Select Person Name--</option>
                                <?//=selectComboBox("select personal_id,concat(first_name,' ',last_name) as full_name from ".TABLE_PERSONAL_MASTER." where status=0 order by first_name",$personal_id)?>
                            </select>
                        </td>	
                    </tr>-->
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Person Name:</b></td>
                        <td width="75%" align="left" valign="top">&nbsp;</td>	
                    </tr>
                   
                    <tr>
                      <td align="left" colspan="2">
                      		<? 
							$personalQuery ="select * from ".TABLE_PERSONAL_MASTER." where personal_id='".$personal_id."' and status='0'";
							$personalResult = com_db_query($personalQuery);
							$personalRow = com_db_fetch_array($personalResult);
							?>
                            <div id="DivPersonalInformationMovementShow">
                            	<table width="100%" cellpadding="2" cellspacing="2" border="0">
                                   <tr>
                                        <td width="25%" align="left" class="page-text" valign="top">First Name:</td>
                                        <td width="75%" align="left" valign="top"><?=com_db_output($personalRow['first_name'])?></td>	
                                    </tr>
                                     <tr>
                                        <td width="25%" align="left" class="page-text" valign="top">Middle Name:</td>
                                        <td width="75%" align="left" valign="top"><?=com_db_output($personalRow['middle_name'])?></td>	
                                    </tr>
                                     <tr>
                                        <td width="25%" align="left" class="page-text" valign="top">Last Name:</td>
                                        <td width="75%" align="left" valign="top"><?=com_db_output($personalRow['last_name'])?></td>	
                                    </tr>
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">E-Mail:</td>
                                      <td width="75%" align="left" valign="top"><?=com_db_output($personalRow['email'])?></td>	
                                    </tr>
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">Phone:</td>
                                      <td width="75%" align="left" valign="top"><?=com_db_output($personalRow['phone'])?></td>	
                                    </tr>
                                   <!-- <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">Education (Undergrad):</td>
                                      <td width="75%" align="left" valign="top"><?//=com_db_output($personalRow['edu_ugrad_degree'].' in '.$personalRow['edu_ugrad_specialization'].' from '.$personalRow['edu_ugrad_college'].' in '.$personalRow['edu_ugrad_year'])?></td> 	
                                    </tr>
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">Education (Grad):</td>
                                      <td width="75%" align="left" valign="top"><?//=com_db_output($personalRow['edu_grad_degree'].' in '.$personalRow['edu_grad_specialization'].' from '.$personalRow['edu_grad_college'].' in '.$personalRow['edu_grad_year'])?></td>
                                    </tr>
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">About Person:</td>
                                      <td width="75%" align="left" valign="top"><?//=com_db_output($personalRow['about_person'])?></td>	
                                    </tr>-->
                                </table>
                            </div>
                      </td>	
                    </tr>
                    <!--<tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Company Name:</b></td>
                        <td width="75%" align="left" valign="top"><?//=com_db_output($companyRow['company_name'])?>
                            <select name="company_id" id="company_id" style="width:208px;" onchange="CompanyInformationMovementEdit('company_id');">
                                <option value="">--Select Company Name--</option>
                                <?//=selectComboBox("select company_id,company_name from ".TABLE_COMPANY_MASTER." where status=0 order by company_name",$company_id)?>
                            </select>
                        </td>	
                    </tr>-->
                    <tr>
                      <td align="left" colspan="2">
                      		<?
							$companyQuery ="select c.*,s.state_name,cnt.countries_name from ".TABLE_COMPANY_MASTER." as c, ".TABLE_STATE." as s,".TABLE_COUNTRIES." as cnt where s.state_id=c.state and cnt.countries_id=c.country and c.company_id='".$company_id."' and status='0'";
							$companyResult = com_db_query($companyQuery);
							$companyRow = com_db_fetch_array($companyResult);
							?>
                            <div id="DivCompanyInformationMovementShow">
                            	<table width="100%" cellpadding="2" cellspacing="2" border="0">
                                    <tr>
                                        <td width="25%" align="left" class="page-text" valign="top"><b>Company Name:</b></td>
                                        <td width="75%" align="left" valign="top"><?=com_db_output($companyRow['company_name'])?></td>	
                                    </tr>
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">Company Website:</td>
                                      <td width="75%" align="left" valign="top"><?=com_db_output($companyRow['company_website'])?></td>	
                                    </tr>
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">Address:</td>
                                      <td width="75%" align="left" valign="top"><?=com_db_output($companyRow['address']).'<br>'.com_db_output($companyRow['address2'])?></td>	
                                    </tr>
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">City:</td>
                                      <td width="75%" align="left" valign="top"><?=com_db_output($companyRow['city'])?></td>	
                                    </tr>
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">State:</td>
                                      <td width="75%" align="left" valign="top"><?=com_db_output($companyRow['state_name'])?></td>	
                                    </tr>
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">Country:</td>
                                      <td width="75%" align="left" valign="top"><?=com_db_output($companyRow['countries_name'])?></td>	
                                    </tr>
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">Zip Code:</td>
                                      <td width="75%" align="left" valign="top"><?=com_db_output($companyRow['zip_code'])?></td>	
                                    </tr>
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">General Phone:</td>
                                      <td width="75%" align="left" valign="top"><?=com_db_output($companyRow['phone'])?></td>	
                                    </tr>
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">Fax:</td>
                                      <td width="75%" align="left" valign="top"><?=com_db_output($companyRow['fax'])?></td>	
                                    </tr>
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">About Company:</td>
                                      <td width="75%" align="left" valign="top"><?=com_db_output($companyRow['about_company']);?></td>	
                                    </tr>
                                    
                                </table>
                            </div>
                      </td>	
                    </tr>
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Announcement Date:</b></td>
                        <td width="75%" align="left" valign="top"><input type="text" name="announce_date" id="announce_date" size="30" value="<?=$announce_date?>"/>
						<a href="javascript:NewCssCal('announce_date','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a></td>	
                    </tr>
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Effective Date:</b></td>
                        <td width="75%" align="left" valign="top"><input type="text" name="effective_date" id="effective_date" size="30" value="<?=$effective_date?>"/>
						<a href="javascript:NewCssCal('effective_date','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a></td>	
                    </tr>
                    
                    <tr>
                      <td width="26%" align="left" class="page-text" valign="top"><b>Headline:</b></td>
                      <td width="50%" align="left" valign="top">
						<input name="headline" id="headline" size="30" value="<?=$headline;?>" />
                      </td>
                    </tr>
                    
                    <!--
                    <tr>
                      <td width="26%" align="left" class="page-text" valign="top"><b>Full Body:</b></td>
                      <td width="50%" align="left" valign="top"><textarea name="full_body" id="full_body" rows="7" cols="40" ><?=$full_body;?></textarea></td>	
                      <td width="24%" align="left" class="MsgShowText" valign="middle">&nbsp;</td>
                    </tr>
                    
                    
                    
                    <tr>
                      <td width="26%" align="left" class="page-text" valign="top"><b>Short url:</b></td>
                      <td width="50%" align="left" valign="top"><input type="text" name="short_url" id="short_url" size="30" value="<?=$short_url;?>"/></td>	
                      <td width="24%" align="left" class="MsgShowText" valign="middle">&nbsp;</td>
                    </tr>
                    
                    -->
                    
                    
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>What Happened:</b></td>
                        <td width="75%" align="left" valign="top">
                        	<textarea  id="what_happened" name="what_happened"><?=$what_happened?></textarea>
							<script type="text/javascript">
                            //<![CDATA[
                                CKEDITOR.replace('what_happened');
                            //]]>
                            </script>
                        </td>	
                    </tr>
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Movement Type:</b></td>
                        <td width="75%" align="left" valign="top">
                        	<select name="movement_type" id="movement_type" style="width:208px;">
                                <option value="">--Select movement type--</option>
                                <?=selectComboBox("select id,name from ".TABLE_MANAGEMENT_CHANGE." where status=0 order by name",$movement_type)?>
                            </select>
                        </td>	
                    </tr>
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Source:</b></td>
                        <td width="75%" align="left" valign="top">
                        	<select name="source_id" id="source_id" style="width:208px;">
                                <option value="">--Select Source--</option>
                                <?=selectComboBox("select id,source from ".TABLE_SOURCE." where status=0 order by source",$source_id)?>
                            </select>
                        </td>	
                    </tr>
                    
                    <!--
                    
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Movement URL:</b></td>
                        <td width="75%" align="left" valign="top"><input type="text" name="movement_url" id="movement_url" size="70" value="<?=$movement_url?>" /></td>	
                    </tr>
                    -->
                    
                    
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top"><b>More Link:</b></td>
                      <td width="75%" align="left" valign="top"><input type="text" name="more_link" id="more_link" size="30" value="<?=$more_link?>" />
                      </td>	
                    </tr>
					<tr>
                      <td width="25%" align="left" class="page-text" valign="top"><b>Not Current?:</b></td>
                      <td width="75%" align="left" valign="top"><input type="checkbox" name="not_current" id="not_current" value="Yes"  <? if($not_current=='Yes'){echo 'checked="checked"';}?>/>
                      </td>	
                    </tr>
                  </table>
                </td>	
            </tr>
            <tr>
            	<td align="center">
                	<table width="50%" border="0" cellpadding="4" cellspacing="4">
                    	<tr>
                        	<td width="22%"><input type="submit" value="Update Movement" class="submitButton" /></td>
                            <td width="78%"><input type="button" class="submitButton" value="Cancel" onclick="window.location='index.php?p=<?=$p;?>&mID=<?=$mID;?>'" /></td>
                        </tr>
                    </table>
                </td>
             </tr>
			</table>
		  </form>
		  
		  </td>
        </tr>
	
	<? }elseif($action=='detailes'){?>
		 <tr>
          <td align="center" valign="top">
		  
		  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                  	<tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Title:</b></td>
                        <td width="75%" align="left" valign="top"><?=$title;?></td>
                    </tr>
                  	<tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Person Name:</b></td>
                        <td width="75%" align="left" valign="top">
                         <?=com_db_output(com_db_GetValue("select concat(first_name,' ',last_name) as full_name from ".TABLE_PERSONAL_MASTER." where status=0 and personal_id='".$personal_id."'"))?>
                        </td>	
                    </tr>
                    <tr>
                      <td align="left" colspan="2">
                      		<? 
							$personalQuery ="select * from ".TABLE_PERSONAL_MASTER." where personal_id='".$personal_id."' and status='0'";
							$personalResult = com_db_query($personalQuery);
							$personalRow = com_db_fetch_array($personalResult);
							?>
                            <div id="DivPersonalInformationMovementShow">
                            	<table width="100%" cellpadding="2" cellspacing="2" border="0">
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">Person Name:</td>
                                      <td width="75%" align="left" valign="top"><?=com_db_output($personalRow['first_name'].' '.$personalRow['last_name'])?></td>	
                                    </tr>
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">E-Mail:</td>
                                      <td width="75%" align="left" valign="top"><?=com_db_output($personalRow['email'])?></td>	
                                    </tr>
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">Phone:</td>
                                      <td width="75%" align="left" valign="top"><?=com_db_output($personalRow['phone'])?></td>	
                                    </tr>
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">Education (Undergrad):</td>
                                      <td width="75%" align="left" valign="top"><?=com_db_output($personalRow['edu_ugrad_degree'].' in '.$personalRow['edu_ugrad_specialization'].' from '.$personalRow['edu_ugrad_college'].' in '.$personalRow['edu_ugrad_year'])?></td> 	
                                    </tr>
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">Education (Grad):</td>
                                      <td width="75%" align="left" valign="top"><?=com_db_output($personalRow['edu_grad_degree'].' in '.$personalRow['edu_grad_specialization'].' from '.$personalRow['edu_grad_college'].' in '.$personalRow['edu_grad_year'])?></td>
                                    </tr>
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">About Person:</td>
                                      <td width="75%" align="left" valign="top"><?=com_db_output($personalRow['about_person'])?></td>	
                                    </tr>
                                </table>
                            </div>
                      </td>	
                    </tr>
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Company Name:</b></td>
                        <td width="75%" align="left" valign="top">
                        <?=com_db_output(com_db_GetValue("select company_name from ".TABLE_COMPANY_MASTER." where status=0 and company_id='".$company_id."'"))?>
                        </td>	
                    </tr>
                    <tr>
                      <td align="left" colspan="2">
                      		<?
							$companyQuery ="select c.*,s.state_name,cnt.countries_name from ".TABLE_COMPANY_MASTER." as c, ".TABLE_STATE." as s,".TABLE_COUNTRIES." as cnt where s.state_id=c.state and cnt.countries_id=c.country and c.company_id='".$company_id."' and status='0'";
							$companyResult = com_db_query($companyQuery);
							$companyRow = com_db_fetch_array($companyResult);
							?>
                            <div id="DivCompanyInformationMovementShow">
                            	<table width="100%" cellpadding="2" cellspacing="2" border="0">
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">Company Website:</td>
                                      <td width="75%" align="left" valign="top"><?=com_db_output($companyRow['company_website'])?></td>	
                                    </tr>
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">Address:</td>
                                      <td width="75%" align="left" valign="top"><?=com_db_output($companyRow['address']).'<br>'.com_db_output($companyRow['address2'])?></td>	
                                    </tr>
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">City:</td>
                                      <td width="75%" align="left" valign="top"><?=com_db_output($companyRow['city'])?></td>	
                                    </tr>
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">State:</td>
                                      <td width="75%" align="left" valign="top"><?=com_db_output($companyRow['state_name'])?></td>	
                                    </tr>
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">Country:</td>
                                      <td width="75%" align="left" valign="top"><?=com_db_output($companyRow['countries_name'])?></td>	
                                    </tr>
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">Zip Code:</td>
                                      <td width="75%" align="left" valign="top"><?=com_db_output($companyRow['zip_code'])?></td>	
                                    </tr>
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">General Phone:</td>
                                      <td width="75%" align="left" valign="top"><?=com_db_output($companyRow['phone'])?></td>	
                                    </tr>
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">Fax:</td>
                                      <td width="75%" align="left" valign="top"><?=com_db_output($companyRow['fax'])?></td>	
                                    </tr>
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">About Company:</td>
                                      <td width="75%" align="left" valign="top"><?=com_db_output($companyRow['about_company']);?></td>	
                                    </tr>
                                    
                                </table>
                            </div>
                      </td>	
                    </tr>
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Headline:</b></td>
                        <td width="75%" align="left" valign="top"><?=$headline?></td>	
                    </tr>
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Announcement Date:</b></td>
                        <td width="75%" align="left" valign="top"><?=$announce_date?></td>	
                    </tr>
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Effective Date:</b></td>
                        <td width="75%" align="left" valign="top"><?=$effective_date?></td>	
                    </tr>
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Full Body:</b></td>
                        <td width="75%" align="left" valign="top"><?=$full_body?></td>	
                    </tr>
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Short URL:</b></td>
                        <td width="75%" align="left" valign="top"><?=$short_url?></td>	
                    </tr>
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>What Happened:</b></td>
                        <td width="75%" align="left" valign="top"><?=$what_happened?></td>	
                    </tr>
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Movement Type:</b></td>
                        <td width="75%" align="left" valign="top"><?=com_db_output(com_db_GetValue("select name from ".TABLE_MANAGEMENT_CHANGE." where id ='".$movement_type."'"))?>
                            </select>
                        </td>	
                    </tr>
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Source:</b></td>
                        <td width="75%" align="left" valign="top"><?=com_db_output(com_db_GetValue("select source from ".TABLE_SOURCE." where id='".$source_id."'"))?>
                            </select>
                        </td>	
                    </tr>
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Movement URL:</b></td>
                        <td width="75%" align="left" valign="top"><?=$movement_url?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top"><b>More Link:</b></td>
                      <td width="75%" align="left" valign="top"><?=$more_link;?></td>	
                    </tr>
					<tr>
                      <td width="25%" align="left" class="page-text" valign="top"><b>Not Current?:</b></td>
                      <td width="75%" align="left" valign="top"><?=$not_current;?></td>	
                    </tr>
                  </table>
		  
		  </td>
        </tr>
	<? } ?>
		
      </table></td>
      <td align="left"  valign="top">&nbsp;</td>
    </tr>
	<? } ?>
	
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
<script>
function myAboutCompany(){
	CKEDITOR.replace('about_company');
}
</script>
</body>
</html>
