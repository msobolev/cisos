<?php
require('../includes/configuration.php');
include('../includes/only_dataentry_include-top.php');

$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 20;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';

if($action == 'SearchResult'){
	$first_name		= $_POST['search_first_name'];
	$last_name		= $_POST['search_last_name'];
	$email			= $_POST['search_email'];
	$phone			= $_POST['search_phone'];
	$from_date		= $_POST['from_date'];
	$to_date 		= $_POST['to_date'];
	
	$search_qry='';
	if($first_name!=''){
		$search_qry .= " first_name = '".$first_name."'";
	}
	if($last_name!=''){
		if($search_qry==''){
			$search_qry .= " last_name = '".$last_name."'";
		}else{
			$search_qry .= " and last_name = '".$last_name."'";
		}	
	}
	
	if($state!=''){
		if($search_qry==''){
			$search_qry .= " c.state = '".$state."'";
		}else{
			$search_qry .= " and c.state = '".$state."'";
		}	
	}
	if($email!=''){
		if($search_qry==''){
			$search_qry .= " email = '".$email."'";
		}else{
			$search_qry .= " and email = '".$email."'";
		}	
	}
	
	if($from_date!='' && strlen($from_date)==10 && $to_date !='' && strlen($to_date)==10){
		$fdt = explode('/',$from_date);
		$fdate = $fdt[2].'-'.$fdt[0].'-'.$fdt[1];
		$tdt = explode('/',$to_date);
		$tdate = $tdt[2].'-'.$tdt[0].'-'.$tdt[1];
		if($search_qry==''){
			$search_qry .= " add_date >= '".$fdate."' and add_date <='".$tdate."'";
		}else{
			$search_qry .= " and add_date >= '".$fdate."' and add_date <='".$tdate."'";
		}
	}
	
	if($search_qry==''){
		$sql_query = "select * from " . TABLE_PERSONAL_MASTER . " order by personal_id desc";
	}else{
		$sql_query = "select * from " . TABLE_PERSONAL_MASTER . " where  ". $search_qry." order by personal_id desc";
	}
}else{
	$sql_query = "select pm.personal_id,pm.first_name,pm.middle_name,pm.last_name,pm.email,pm.phone,pm.status,pm.add_date from " . TABLE_PERSONAL_MASTER . " as pm where status = 1 order by pm.personal_id desc";
}
echo $sql_query;		
die();
/***************** FOR PAGIN ***********************/
$starting_point = $items_per_page * ($p - 1);
/****************** END PAGIN ***********************/
$main_page = 'personal.php';

$exe_query=com_db_query($sql_query);
$num_rows=com_db_num_rows($exe_query);
$total_data = $num_rows;

/************ FOR PAGIN **************/
$sql_query .= " LIMIT $starting_point,$items_per_page";
$exe_data = com_db_query($sql_query);

$numRows = com_db_num_rows($exe_data);
/************ END ********************/


$pID = (isset($_GET['pID']) ? $_GET['pID'] : $select_data[0]);

    switch ($action) {
		
	  case 'delete':
	   		
			com_db_query("delete from " . TABLE_PERSONAL_MASTER . " where personal_id = '" . $pID . "'");
			com_db_query("delete from " . TABLE_MOVEMENT_MASTER . " where personal_id = '" . $pID . "'");
			com_db_query("delete from " . TABLE_PERSONAL_AWARDS . " where personal_id = '" . $pID . "'");
			com_db_query("delete from " . TABLE_PERSONAL_BOARD . " where personal_id = '" . $pID . "'");
			com_db_query("delete from " . TABLE_PERSONAL_MEDIA_MENTION . " where personal_id = '" . $pID . "'");
			com_db_query("delete from " . TABLE_PERSONAL_PUBLICATION . " where personal_id = '" . $pID . "'");
			com_db_query("delete from " . TABLE_PERSONAL_SPEAKING . " where personal_id = '" . $pID . "'");
			
			com_redirect("personal.php?p=" . $p . "&msg=" . msg_encode("Personal deleted successfully"));
		
		break;
		
	  case 'jobdelete':
			$job_id = $_REQUEST['cjID'];
			com_db_query("delete from " . TABLE_COMPANY_JOB_INFO . " where company_id = '" . $pID . "' and job_id='".$job_id."'");
		 	com_redirect("personal.php?action=detailes&pID=".$pID);
		
		break;	
			
	  case 'edit':
     		
	   		$query_edit=com_db_query("select * from " . TABLE_COMPANY_MASTER . " where company_id = '" . $pID . "'");
	  		$data_edit=com_db_fetch_array($query_edit);
			
			$query_edit=com_db_query("select * from " . TABLE_PERSONAL_MASTER . " where personal_id = '" . $pID . "'");
	  		$data_edit=com_db_fetch_array($query_edit);
			
			$first_name = com_db_output($data_edit['first_name']);
			$middle_name = com_db_output($data_edit['middle_name']);
			$last_name = com_db_output($data_edit['last_name']);
			$email = rtrim(com_db_output($data_edit['email']));
			$verified_image = com_db_output($data_edit['verified_image']);
			$email_verified = com_db_output($data_edit['email_verified']);
			if($data_edit['email_verified_date'] =='0000-00-00'){
				$email_verified_date = '';
			}else{
				$ev_dt = explode("-",$data_edit['email_verified_date']);
				$email_verified_date = $ev_dt[1]."/".$ev_dt[2]."/".$ev_dt[0];
			}
			$phone = com_db_output($data_edit['phone']);
			$lin_url = com_db_output($data_edit['lin_url']);
			$personal_image = com_db_output($data_edit['personal_image']);
			$facebook_link = com_db_output($data_edit['facebook_link']);
			$linkedin_link = com_db_output($data_edit['linkedin_link']);
			$twitter_link = com_db_output($data_edit['twitter_link']);
			$googleplush_link = com_db_output($data_edit['googleplush_link']);
			$about_person = $data_edit['about_person'];
			$personal = com_db_output($data_edit['personal']);
			$edu_ugrad_degree = com_db_output($data_edit['edu_ugrad_degree']);
			$edu_ugrad_specialization = com_db_output($data_edit['edu_ugrad_specialization']); 
			$edu_ugrad_college = com_db_output($data_edit['edu_ugrad_college']);
			$edu_ugrad_year = com_db_output($data_edit['edu_ugrad_year']);
			$edu_grad_degree = com_db_output($data_edit['edu_grad_degree']);
			$edu_grad_specialization = com_db_output($data_edit['edu_grad_specialization']); 
			$edu_grad_college = com_db_output($data_edit['edu_grad_college']);
			$edu_grad_year = com_db_output($data_edit['edu_grad_year']);
			$demo_email = com_db_output($data_edit['demo_email']);
			$person_tigger_name = com_db_output($data_edit['person_tigger_name']);
			
			$executive_email = com_db_output($data_edit['executive_email']);
			$executive_tigger_name = com_db_output($data_edit['executive_tigger_name']);

			$add_to_funding = com_db_output($data_edit['add_to_funding']);
			
		break;	
		
		case 'editsave':
			
			$first_name = rtrim(com_db_input($_POST['first_name']));
			$middle_name = com_db_input($_POST['middle_name']);
			$last_name = rtrim(com_db_input($_POST['last_name']));
			$email = rtrim(com_db_input($_POST['email']));
			$phone = com_db_input($_POST['phone']);
			$lin_url = com_db_input($_POST['lin_url']);
			
			$facebook_link = com_db_input($_POST['facebook_link']);
			$linkedin_link = com_db_input($_POST['linkedin_link']);
			$twitter_link = com_db_input($_POST['twitter_link']);
			$googleplush_link = com_db_input($_POST['googleplush_link']);
			
			$about_person = strip_tags($_POST['about_person']);
			$personal = com_db_input($_POST['personal']);
			
			$edu_ugrad_degree = com_db_input($_POST['edu_ugrad_degree']);
			$edu_ugrad_specialization = com_db_input($_POST['edu_ugrad_specialization']);
			$edu_ugrad_college = com_db_input($_POST['edu_ugrad_college']);
			$edu_ugrad_year = com_db_input($_POST['edu_ugrad_year']);
			$edu_grad_degree = com_db_input($_POST['edu_grad_degree']);
			$edu_grad_specialization = com_db_input($_POST['edu_grad_specialization']);
			$edu_grad_college = com_db_input($_POST['edu_grad_college']);
			$edu_grad_year = com_db_input($_POST['edu_grad_year']);
			$demo_email = com_db_input($_POST['demo_email']);
			$person_tigger_name = com_db_input($_POST['person_tigger_name']);
			
			$executive_email = com_db_input($_POST['executive_email']);
			$executive_tigger_name = com_db_input($_POST['executive_tigger_name']);
			
			$add_to_funding = com_db_input($_POST['add_to_funding']);
			
			
			//echo "<br>FAR executive_email: ".$executive_email;
			//echo "<br>FAR executive_tigger_name: ".$executive_tigger_name;
			
			$modify_date = date('Y-m-d');
			$email_verified = com_db_input($_POST['email_verified']);
			if($email_verified =='Yes'){
				$email_verified_date=date('Y-m-d');
			}else{
				$email_verified_date='';
			}
			
			$modify_date = date('Y-m-d');
			$create_by = $_SESSION['user_login_name'];
			$login_id = $_SESSION['user_login_id'];

			$query = "update " . TABLE_PERSONAL_MASTER . " set first_name = '" . $first_name ."', middle_name = '".$middle_name."', last_name = '".$last_name."', email = '".$email."',email_verified='".$email_verified."',email_verified_date='".$email_verified_date."', phone = '".$phone."',
			lin_url = '".$lin_url."', facebook_link = '" . $facebook_link ."', linkedin_link='".$linkedin_link."', twitter_link = '".$twitter_link."', googleplush_link = '".$googleplush_link."', about_person = '".$about_person."', 
			personal = '".$personal."', edu_ugrad_degree = '".$edu_ugrad_degree."', edu_ugrad_specialization = '".$edu_ugrad_specialization."', edu_ugrad_college = '".$edu_ugrad_college."', edu_ugrad_year = '".$edu_ugrad_year."',
			edu_grad_degree = '".$edu_grad_degree."', edu_grad_specialization = '".$edu_grad_specialization."', edu_grad_college = '".$edu_grad_college."', edu_grad_year = '".$edu_grad_year."',
			modify_date = '".$modify_date."',create_by='".$create_by."',admin_id='".$login_id."',demo_email='".$demo_email."',person_tigger_name='".$person_tigger_name."',executive_tigger_name='".$executive_tigger_name."',executive_email='".$executive_email."',add_to_funding='".$add_to_funding."' where personal_id = '" . $pID . "'";
			com_db_query($query);
			
			//echo "<br>FAR person update Q: ".$query;
			
			$insert_id = $pID;
			$image = $_FILES['image']['tmp_name'];
			  
			if($image!=''){
				if(is_uploaded_file($image)){
					$org_img = $_FILES['image']['name'];
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
							
							$query = "UPDATE " . TABLE_PERSONAL_MASTER . " SET personal_image = '" . $org_image_name . "' WHERE personal_id = '" . $pID ."'";
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
							$query = "UPDATE " . TABLE_PERSONAL_MASTER . " SET verified_image = '" . $org_image_name . "' WHERE personal_id = '" . $insert_id ."'";
							com_db_query($query);
						}
					}	
				}	
			}
			
			//Appointments insert
			if($executive_email !='' && $executive_tigger_name == 'Appointments')
			{
				$ppointment_add_date = date('Y-m-d');
				$query = "insert into " . TABLE_EXECUTIVE_APPOINTMENT . "
				(personal_id,add_date) 
				values ('$insert_id','".$ppointment_add_date."')";
				com_db_query($query);
			}
			
			
			
			//Awards insert
			$awards_title_arr = $_POST['awards_title'];
			$awards_given_by_arr = $_POST['awards_given_by'];
			$awards_date_arr = $_POST['awards_date'];
			$awards_link_arr = $_POST['awards_link'];
			com_db_query("delete from ".TABLE_PERSONAL_AWARDS." where personal_id='".$pID."'");
			if($executive_email !='' && $executive_tigger_name == 'Awards')
			{
				com_db_query("delete from ".TABLE_EXECUTIVE_AWARDS." where personal_id='".$pID."'");
			}
			for($j=0; $j<sizeof($awards_title_arr);$j++){
				$awards_title 	= $awards_title_arr[$j];
				$awards_given_by 	= $awards_given_by_arr[$j];
				$awards_date 	= $awards_date_arr[$j];
				$adt = explode('/',$awards_date);//mmddyyyy
				$awards_date = $adt[2].'-'.$adt[0].'-'.$adt[1];
				$awards_link 	= $awards_link_arr[$j];
				$status = '0';
				$add_date = date('Y-m-d');
				if($awards_title !=''){
					$query = "insert into " . TABLE_PERSONAL_AWARDS . "
					(personal_id, awards_title,awards_given_by,awards_date,awards_link,add_date, status) 
					values ('$insert_id', '$awards_title','$awards_given_by','$awards_date','$awards_link','$add_date','$status')";
					com_db_query($query);
					
					//echo "<br>FAR before exe awards insert ";
					if($executive_email !='' && $executive_tigger_name == 'Awards')
					{
						//echo "<br>FAR within exe awards insert ";
						$query = "insert into " . TABLE_EXECUTIVE_AWARDS . "
					(personal_id, awards_title,awards_given_by,awards_date,awards_link,add_date, status) 
					values ('$insert_id', '$awards_title','$awards_given_by','$awards_date','$awards_link','$add_date','$status')";
					com_db_query($query);
					}
					
				}

			}
			
			//Board insert
			$board_info_arr = $_POST['board_info'];
			$board_date_arr = $_POST['board_date'];
			$board_link_arr = $_POST['board_link'];
			com_db_query("delete from ".TABLE_PERSONAL_BOARD." where personal_id='".$pID."'");
			
			if($executive_email !='' && $executive_tigger_name == 'Board')
			{	
				//echo "<br>FAR Deleting current board";
				com_db_query("delete from ".TABLE_EXECUTIVE_BOARD." where personal_id='".$pID."'");
			}
			
			for($j=0; $j<sizeof($board_info_arr);$j++){
				$board_info 	= $board_info_arr[$j];
				$board_date 	= $board_date_arr[$j];
				$bdt = explode('/',$board_date);//mmddyyyy
				$board_date = $bdt[2].'-'.$bdt[0].'-'.$bdt[1];
				$board_link 	= $board_link_arr[$j];
				$status = '0';
				$add_date = date('Y-m-d');
				if($board_info !=''){
					$query = "insert into " . TABLE_PERSONAL_BOARD . "
					(personal_id, board_info,board_date,board_link,add_date, status) 
					values ('$insert_id', '$board_info','$board_date','$board_link','$add_date','$status')";
					com_db_query($query);
					
					
					//echo "<br>FAR before entering new board";
					if($executive_email !='' && $executive_tigger_name == 'Board')
					{
						//echo "<br>FAR within entering new board";
						$query = "insert into " . TABLE_EXECUTIVE_BOARD . "
					(personal_id, board_info,board_date,board_link,add_date, status) 
					values ('$insert_id', '$board_info','$board_date','$board_link','$add_date','$status')";
					com_db_query($query);
					}
					
					
				}
			}
			
			//Speaking insert
			$role_arr = $_POST['role'];
			$topic_arr = $_POST['topic'];
			$event_arr = $_POST['event'];
			$event_date_arr = $_POST['event_date'];
			$speaking_link_arr = $_POST['speaking_link'];
			com_db_query("delete from ".TABLE_PERSONAL_SPEAKING." where personal_id='".$pID."'");
			
			if($executive_email !='' && $executive_tigger_name == 'Speaking')
			{
				com_db_query("delete from ".TABLE_EXECUTIVE_SPEAKING." where personal_id='".$pID."'");
			}
			
			for($j=0; $j<sizeof($role_arr);$j++){
				$role 	= $role_arr[$j];
				$topic	= $topic_arr[$j];
				$event	= $event_arr[$j];
				$edt_date 	= explode('/',$event_date_arr[$j]);//mmddyyyy
				$event_date 	= $edt_date[2].'-'.$edt_date[0].'-'.$edt_date[1];
				$speaking_link = $speaking_link_arr[$j];
				$status = '0';
				$add_date = date('Y-m-d');
				if($role !=''){
					$query = "insert into " . TABLE_PERSONAL_SPEAKING . "
					(personal_id, role, topic, event, event_date, speaking_link, add_date, status) 
					values ('$insert_id', '$role', '$topic', '$event', '$event_date','$speaking_link','$add_date','$status')";
					com_db_query($query);
					
					
					if($executive_email !='' && $executive_tigger_name == 'Speaking')
					{
						$query = "insert into " . TABLE_EXECUTIVE_SPEAKING . "
					(personal_id, role, topic, event, event_date, speaking_link, add_date, status) 
					values ('$insert_id', '$role', '$topic', '$event', '$event_date','$speaking_link','$add_date','$status')";
					com_db_query($query);
					}
					
				}
			}
			
			//Media Mention insert
			$publication_arr = $_POST['publication'];
			$quote_arr = $_POST['quote'];
			$pub_date_arr = $_POST['pub_date'];
			$media_link_arr = $_POST['media_link'];
			com_db_query("delete from ".TABLE_PERSONAL_MEDIA_MENTION." where personal_id='".$pID."'");
			if($executive_email !='' && $executive_tigger_name == 'Publication')
			{
				com_db_query("delete from ".TABLE_EXECUTIVE_MEDIA_MENTION." where personal_id='".$pID."'");
			}
			for($j=0; $j<sizeof($publication_arr);$j++){
				$publication 	= $publication_arr[$j];
				$quote 	= $quote_arr[$j];
				$pdt_date 	= explode('/',$pub_date_arr[$j]);//mmddyyyy
				$pub_date 	= $pdt_date[2].'-'.$pdt_date[0].'-'.$pdt_date[1];
				$media_link 	= $media_link_arr[$j];
				$status = '0';
				$add_date = date('Y-m-d');
				if($publication !=''){
					$query = "insert into " . TABLE_PERSONAL_MEDIA_MENTION . "
					(personal_id, publication, quote, pub_date, media_link, add_date, status) 
					values ('$insert_id', '$publication', '$quote', '$pub_date','$media_link','$add_date','$status')";
					com_db_query($query);
					
					
					if($executive_email !='' && $executive_tigger_name == 'Media Mention')
					{
						$query = "insert into " . TABLE_EXECUTIVE_MEDIA_MENTION . "
					(personal_id, publication, quote, pub_date, media_link, add_date, status) 
					values ('$insert_id', '$publication', '$quote', '$pub_date','$media_link','$add_date','$status')";
					com_db_query($query);
					}
					
				}
			}
			
			//Publication insert
			$title_arr = $_POST['pub_title'];
			$publication_date_arr = $_POST['publication_date'];
			$link_arr = $_POST['pub_link'];
			com_db_query("delete from ".TABLE_PERSONAL_PUBLICATION." where personal_id='".$pID."'");
			if($executive_email !='' && $executive_tigger_name == 'Publication')
			{
				com_db_query("delete from ".TABLE_EXECUTIVE_PUBLICATION." where personal_id='".$pID."'");
			}
			for($j=0; $j<sizeof($title_arr);$j++){
				$title 	= $title_arr[$j];
				$pdt_date 	= explode('/',$publication_date_arr[$j]);//mmddyyyy
				$publication_date 	= $pdt_date[2].'-'.$pdt_date[0].'-'.$pdt_date[1];
				$link 	= $link_arr[$j];
				$status = '0';
				$add_date = date('Y-m-d');
				if($title !=''){
					$query = "insert into " . TABLE_PERSONAL_PUBLICATION . "
					(personal_id, title,publication_date,link, add_date, status) 
					values ('$insert_id', '$title','$publication_date', '$link','$add_date','$status')";
					com_db_query($query);
					
					if($executive_email !='' && $executive_tigger_name == 'Publication')
					{
						$query = "insert into " . TABLE_EXECUTIVE_PUBLICATION . "
					(personal_id, title,publication_date,link, add_date, status) 
					values ('$insert_id', '$title','$publication_date', '$link','$add_date','$status')";
					com_db_query($query);
					}
					
					
				}
			}
			if($demo_email !='' && $person_tigger_name!=''){
				$demo_email = com_db_input($_POST['demo_email']);
				$person_tigger_name = com_db_input($_POST['person_tigger_name']);
				switch($person_tigger_name){
					case 'Appointments':
						$moveid = com_db_GetValue("select move_id from ".TABLE_MOVEMENT_MASTER." mm, ".TABLE_PERSONAL_MASTER." pm where mm.personal_id=pm.personal_id and pm.personal_id='".$pID."' order by effective_date desc");
						if($moveid > 0 && $moveid != ''){
							com_db_query("update ".TABLE_PERSONAL_MASTER." set all_trigger_id ='".$moveid."' where personal_id = '" . $pID . "'");
						}
						break;
					case 'Awards':
						$awards_id = com_db_GetValue("select awards_id from ".TABLE_PERSONAL_AWARDS." where personal_id='".$pID."' order by awards_date desc");
						if($awards_id > 0 && $awards_id != ''){
							com_db_query("update ".TABLE_PERSONAL_MASTER." set all_trigger_id ='".$awards_id."' where personal_id = '" . $pID . "'");
						}
						break;
					case 'Board':
						$board_id = com_db_GetValue("select board_id from ".TABLE_PERSONAL_BOARD." where personal_id='".$pID."' order by board_date desc");
						if($board_id > 0 && $board_id != ''){
							com_db_query("update ".TABLE_PERSONAL_MASTER." set all_trigger_id ='".$board_id."' where personal_id = '" . $pID . "'");
						}
						break;
					case 'Media Mention':
						$mm_id = com_db_GetValue("select mm_id from ".TABLE_PERSONAL_MEDIA_MENTION." where personal_id='".$pID."' order by pub_date desc");
						if($mm_id > 0 && $mm_id != ''){
							com_db_query("update ".TABLE_PERSONAL_MASTER." set all_trigger_id ='".$mm_id."' where personal_id = '" . $pID . "'");
						}
						break;
					case 'Speaking':
						$speaking_id = com_db_GetValue("select speaking_id from ".TABLE_PERSONAL_SPEAKING." where personal_id='".$pID."' and event_date >'".date("Y-m-d")."' order by event_date desc");
						if($speaking_id > 0 && $speaking_id != ''){
							com_db_query("update ".TABLE_PERSONAL_MASTER." set all_trigger_id ='".$speaking_id."' where personal_id = '" . $pID . "'");
						}else{
							com_db_query("update ".TABLE_PERSONAL_MASTER." set demo_email= 0,person_tigger_name ='' where personal_id = '" . $pID . "'");
						}
						break;
					case 'Publication':
						$publication_id = com_db_GetValue("select publication_id from ".TABLE_PERSONAL_PUBLICATION." where personal_id='".$pID."' order by publication_date desc");
						if($publication_id > 0 && $publication_id != ''){
							com_db_query("update ".TABLE_PERSONAL_MASTER." set all_trigger_id ='".$publication_id."' where personal_id = '" . $pID . "'");
						}
						break;
				}
			}
	  		com_redirect("personal.php?p=". $p ."&pID=" . $pID . "&msg=" . msg_encode("Personal update successfully"));
		 
		break;		
		
	  
		
	case 'addsave':
			
			$first_name = rtrim(com_db_input($_POST['first_name']));
			$middle_name = com_db_input($_POST['middle_name']);
			$last_name = rtrim(com_db_input($_POST['last_name']));
			$email = rtrim(com_db_input($_POST['email']));
			$phone = com_db_input($_POST['phone']);
			$lin_url = com_db_input($_POST['lin_url']);
			
			$facebook_link = com_db_input($_POST['facebook_link']);
			$linkedin_link = com_db_input($_POST['linkedin_link']);
			$twitter_link = com_db_input($_POST['twitter_link']);
			$googleplush_link = com_db_input($_POST['googleplush_link']);
			
			$about_person = strip_tags($_POST['about_person']);
			$personal = com_db_input($_POST['personal']);
			
			$edu_ugrad_degree = com_db_input($_POST['edu_ugrad_degree']);
			$edu_ugrad_specialization = com_db_input($_POST['edu_ugrad_specialization']);
			$edu_ugrad_college = com_db_input($_POST['edu_ugrad_college']);
			$edu_ugrad_year = com_db_input($_POST['edu_ugrad_year']);
			$edu_grad_degree = com_db_input($_POST['edu_grad_degree']);
			$edu_grad_specialization = com_db_input($_POST['edu_grad_specialization']);
			$edu_grad_college = com_db_input($_POST['edu_grad_college']);
			$edu_grad_year = com_db_input($_POST['edu_grad_year']);
			$demo_email = com_db_input($_POST['demo_email']);
			$person_tigger_name = com_db_input($_POST['person_tigger_name']);
			
			$executive_email = com_db_input($_POST['executive_email']);
			$executive_tigger_name = com_db_input($_POST['executive_tigger_name']);
			
			$add_to_funding = com_db_input($_POST['add_to_funding']);
			
			$create_by = $_SESSION['user_login_name'];
			$login_id = $_SESSION['user_login_id'];
			$status = '0';
			$add_date = date('Y-m-d');
			
			$email_verified = com_db_input($_POST['email_verified']);
			if($email_verified=='Yes'){
				$email_verified_date = date('Y-m-d');
			}else{
				$email_verified_date='';
			}
			
			$query = "insert into " . TABLE_PERSONAL_MASTER . "
			(first_name, middle_name, last_name, email,email_verified, email_verified_date, phone,lin_url,facebook_link, linkedin_link, twitter_link, googleplush_link, about_person, personal,edu_ugrad_degree, 
			edu_ugrad_specialization, edu_ugrad_college, edu_ugrad_year, edu_grad_degree ,edu_grad_specialization ,edu_grad_college, edu_grad_year,add_date, create_by,admin_id, demo_email, person_tigger_name, status,executive_tigger_name,executive_email,add_to_funding) 
			values ('$first_name','$middle_name','$last_name','$email','$email_verified','$email_verified_date','$phone','$lin_url','$facebook_link','$linkedin_link','$twitter_link','$googleplush_link','$about_person','$personal','$edu_ugrad_degree',
			'$edu_ugrad_specialization','$edu_ugrad_college','$edu_ugrad_year','$edu_grad_degree','$edu_grad_specialization','$edu_grad_college','$edu_grad_year','$add_date','$create_by','$login_id','$demo_email','$person_tigger_name','$status','$executive_tigger_name','$executive_email','$add_to_funding')";
			com_db_query($query);
			
			$insert_id = com_db_insert_id();
			$image = $_FILES['image']['tmp_name'];
			if($image!=''){
				if(is_uploaded_file($image)){
					$org_img = $_FILES['image']['name'];
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
							
							$query = "UPDATE " . TABLE_PERSONAL_MASTER . " SET personal_image = '" . $org_image_name . "' WHERE personal_id = '" . $insert_id ."'";
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
							$query = "UPDATE " . TABLE_PERSONAL_MASTER . " SET verified_image = '" . $org_image_name . "' WHERE personal_id = '" . $insert_id ."'";
							com_db_query($query);
						}
					}	
				}	
			}
			
			//Appointments insert
			if($executive_email !='' && $executive_tigger_name == 'Appointments')
			{
				$ppointment_add_date = date('Y-m-d');
				$query = "insert into " . TABLE_EXECUTIVE_APPOINTMENT . "
				(personal_id,add_date) 
				values ('$insert_id','".$ppointment_add_date."')";
				com_db_query($query);
			}
			
			
			//Awards insert
			$awards_title_arr = $_POST['awards_title'];
			$awards_given_by_arr = $_POST['awards_given_by'];
			$awards_date_arr = $_POST['awards_date'];
			$awards_link_arr = $_POST['awards_link'];
			for($j=0; $j<sizeof($awards_title_arr);$j++){
				$awards_title 	= $awards_title_arr[$j];
				$awards_given_by 	= $awards_given_by_arr[$j];
				$awards_date 	= $awards_date_arr[$j];
				$adt = explode('/',$awards_date);//mmddyyyy
				$awards_date = $adt[2].'-'.$adt[0].'-'.$adt[1];
				$awards_link 	= $awards_link_arr[$j];
				
				$status = '0';
				$add_date = date('Y-m-d');
				if($awards_title !=''){
					$query = "insert into " . TABLE_PERSONAL_AWARDS . "
					(personal_id, awards_title,awards_given_by,awards_date,awards_link,add_date, status) 
					values ('$insert_id', '$awards_title','$awards_given_by','$awards_date','$awards_link','$add_date','$status')";
					com_db_query($query);
					
					
					if($executive_email !='' && $executive_tigger_name == 'Awards')
					{
						$query = "insert into " . TABLE_EXECUTIVE_AWARDS . "
						(personal_id, awards_title,awards_given_by,awards_date,awards_link,add_date, status) 
						values ('$insert_id', '$awards_title','$awards_given_by','$awards_date','$awards_link','$add_date','$status')";
						com_db_query($query);
					}
					
				}
			}
			//Board insert
			$board_info_arr = $_POST['board_info'];
			$board_date_arr = $_POST['board_date'];
			$board_link_arr = $_POST['board_link'];
			for($j=0; $j<sizeof($board_info_arr);$j++){
				$board_info 	= $board_info_arr[$j];
				$board_date 	= $board_date_arr[$j];
				$bdt = explode('/',$board_date);//mmddyyyy
				$board_date = $bdt[2].'-'.$bdt[0].'-'.$bdt[1];
				$board_link 	= $board_link_arr[$j];
				$status = '0';
				$add_date = date('Y-m-d');
				if($board_info !=''){
					$query = "insert into " . TABLE_PERSONAL_BOARD . "
					(personal_id, board_info, board_date, board_link, add_date, status) 
					values ('$insert_id', '$board_info','$board_date','$board_link','$add_date','$status')";
					com_db_query($query);
					
					
					if($executive_email !='' && $executive_tigger_name == 'Board')
					{
						$query = "insert into " . TABLE_EXECUTIVE_BOARD . "
						(personal_id, board_info, board_date, board_link, add_date, status) 
						values ('$insert_id', '$board_info','$board_date','$board_link','$add_date','$status')";
						com_db_query($query);
					}
				}
			}
			
			//Speaking insert
			$role_arr = $_POST['role'];
			$topic_arr = $_POST['topic'];
			$event_arr = $_POST['event'];
			$event_date_arr = $_POST['event_date'];
			$speaking_link_arr = $_POST['speaking_link'];
			for($j=0; $j<sizeof($role_arr);$j++){
				$role 	= $role_arr[$j];
				$topic	= $topic_arr[$j];
				$event	= $event_arr[$j];
				$edt_date 	= explode('/',$event_date_arr[$j]);//mmddyyyy
				$event_date 	= $edt_date[2].'-'.$edt_date[0].'-'.$edt_date[1];
				$speaking_link	= $speaking_link_arr[$j];
				$status = '0';
				$add_date = date('Y-m-d');
				if($role !=''){
					$query = "insert into " . TABLE_PERSONAL_SPEAKING . "
					(personal_id, role, topic, event, event_date, speaking_link, add_date, status) 
					values ('$insert_id', '$role', '$topic', '$event', '$event_date','$speaking_link','$add_date','$status')";
					com_db_query($query);
					
					
					if($executive_email !='' && $executive_tigger_name == 'Speaking')
					{
						$query = "insert into " . TABLE_EXECUTIVE_SPEAKING . "
						(personal_id, role, topic, event, event_date, speaking_link, add_date, status) 
						values ('$insert_id', '$role', '$topic', '$event', '$event_date','$speaking_link','$add_date','$status')";
						com_db_query($query);
					}	
				}
			}
			
			//Media Mention insert
			$publication_arr = $_POST['publication'];
			$quote_arr = $_POST['quote'];
			$pub_date_arr = $_POST['pub_date'];
			$media_link_arr = $_POST['media_link'];
			for($j=0; $j<sizeof($publication_arr);$j++){
				$publication 	= $publication_arr[$j];
				$quote 	= $quote_arr[$j];
				$pdt_date 	= explode('/',$pub_date_arr[$j]);//mmddyyyy
				$pub_date 	= $pdt_date[2].'-'.$pdt_date[0].'-'.$pdt_date[1];
				$media_link 	= $media_link_arr[$j];
				$status = '0';
				$add_date = date('Y-m-d');
				if($publication !=''){
					$query = "insert into " . TABLE_PERSONAL_MEDIA_MENTION . "
					(personal_id, publication, quote, pub_date, media_link, add_date, status) 
					values ('$insert_id', '$publication', '$quote', '$pub_date','$media_link','$add_date','$status')";
					com_db_query($query);
					
					
					if($executive_email !='' && $executive_tigger_name == 'Media Mention')
					{
						$query = "insert into " . TABLE_EXECUTIVE_MEDIA_MENTION . "
						(personal_id, publication, quote, pub_date, media_link, add_date, status) 
						values ('$insert_id', '$publication', '$quote', '$pub_date','$media_link','$add_date','$status')";
						com_db_query($query);
					}		
				}
			}
			
			//Publication insert
			$title_arr = $_POST['pub_title'];
			$publication_date_arr = $_POST['publication_date'];
			$link_arr = $_POST['pub_link'];
			for($j=0; $j<sizeof($title_arr);$j++){
				$title 	= $title_arr[$j];
				$pdt_date 	= explode('/',$publication_date_arr[$j]);//mmddyyyy
				$publication_date 	= $pdt_date[2].'-'.$pdt_date[0].'-'.$pdt_date[1];
				$link 	= $link_arr[$j];
				$status = '0';
				$add_date = date('Y-m-d');
				if($title !=''){
					$query = "insert into " . TABLE_PERSONAL_PUBLICATION . "
					(personal_id, title, publication_date, link, add_date, status) 
					values ('$insert_id', '$title','$publication_date', '$link','$add_date','$status')";
					com_db_query($query);
					
					
					if($executive_email !='' && $executive_tigger_name == 'Publication')
					{
						$query = "insert into " . TABLE_EXECUTIVE_PUBLICATION . "
					(personal_id, title, publication_date, link, add_date, status) 
					values ('$insert_id', '$title','$publication_date', '$link','$add_date','$status')";
					com_db_query($query);
					}
					
				}
				
				
			}
			
			if($demo_email !='' && $person_tigger_name!=''){
				$demo_email = com_db_input($_POST['demo_email']);
				$person_tigger_name = com_db_input($_POST['person_tigger_name']);
				switch($person_tigger_name){
					case 'Appointments':
						$moveid = com_db_GetValue("select move_id from ".TABLE_MOVEMENT_MASTER." mm, ".TABLE_PERSONAL_MASTER." pm where mm.personal_id=pm.personal_id and pm.personal_id='".$insert_id."' order by effective_date desc");
						if($moveid > 0 && $moveid != ''){
							com_db_query("update ".TABLE_PERSONAL_MASTER." set all_trigger_id ='".$moveid."' where personal_id = '" . $insert_id . "'");
						}
						break;
					case 'Awards':
						$awards_id = com_db_GetValue("select awards_id from ".TABLE_PERSONAL_AWARDS." where personal_id='".$insert_id."' order by awards_date desc");
						if($awards_id > 0 && $awards_id != ''){
							com_db_query("update ".TABLE_PERSONAL_MASTER." set all_trigger_id ='".$awards_id."' where personal_id = '" . $insert_id . "'");
						}
						break;
					case 'Board':
						$board_id = com_db_GetValue("select board_id from ".TABLE_PERSONAL_BOARD." where personal_id='".$insert_id."' order by board_date desc");
						if($board_id > 0 && $board_id != ''){
							com_db_query("update ".TABLE_PERSONAL_MASTER." set all_trigger_id ='".$board_id."' where personal_id = '" . $insert_id . "'");
						}
						break;
					case 'Media Mention':
						$mm_id = com_db_GetValue("select mm_id from ".TABLE_PERSONAL_MEDIA_MENTION." where personal_id='".$insert_id."' order by pub_date desc");
						if($mm_id > 0 && $mm_id != ''){
							com_db_query("update ".TABLE_PERSONAL_MASTER." set all_trigger_id ='".$mm_id."' where personal_id = '" . $insert_id . "'");
						}
						break;
					case 'Speaking':
						$speaking_id = com_db_GetValue("select speaking_id from ".TABLE_PERSONAL_SPEAKING." where personal_id='".$insert_id."' and event_date >'".date("Y-m-d")."' order by event_date desc");
						if($speaking_id > 0 && $speaking_id != ''){
							com_db_query("update ".TABLE_PERSONAL_MASTER." set all_trigger_id ='".$speaking_id."' where personal_id = '" . $insert_id . "'");
						}else{
							com_db_query("update ".TABLE_PERSONAL_MASTER." set demo_email= 0,person_tigger_name ='' where personal_id = '" . $insert_id . "'");
						}
						break;
					case 'Publication':
						$publication_id = com_db_GetValue("select publication_id from ".TABLE_PERSONAL_PUBLICATION." where personal_id='".$insert_id."' order by publication_date desc");
						if($publication_id > 0 && $publication_id != ''){
							com_db_query("update ".TABLE_PERSONAL_MASTER." set all_trigger_id ='".$publication_id."' where personal_id = '" . $insert_id . "'");
						}
						break;
				}
			}
			
			// executive emails
			// FAR code , commented for now
			/*
			if($executive_email !='' && $executive_tigger_name!=''){
				$executive_email = com_db_input($_POST['executive_email']);
				$executive_tigger_name = com_db_input($_POST['executive_tigger_name']);
				switch($executive_tigger_name){
					case 'Appointments':
						$moveid = com_db_GetValue("select move_id from ".TABLE_MOVEMENT_MASTER." mm, ".TABLE_PERSONAL_MASTER." pm where mm.personal_id=pm.personal_id and pm.personal_id='".$insert_id."' order by effective_date desc");
						if($moveid > 0 && $moveid != ''){
							com_db_query("update ".TABLE_PERSONAL_MASTER." set all_trigger_id ='".$moveid."' where personal_id = '" . $insert_id . "'");
						}
						break;
					case 'Awards':
						$awards_id = com_db_GetValue("select awards_id from ".TABLE_PERSONAL_AWARDS." where personal_id='".$insert_id."' order by awards_date desc");
						if($awards_id > 0 && $awards_id != ''){
							com_db_query("update ".TABLE_PERSONAL_MASTER." set all_trigger_id ='".$awards_id."' where personal_id = '" . $insert_id . "'");
						}
						break;
					case 'Board':
						$board_id = com_db_GetValue("select board_id from ".TABLE_PERSONAL_BOARD." where personal_id='".$insert_id."' order by board_date desc");
						if($board_id > 0 && $board_id != ''){
							com_db_query("update ".TABLE_PERSONAL_MASTER." set all_trigger_id ='".$board_id."' where personal_id = '" . $insert_id . "'");
						}
						break;
					case 'Media Mention':
						$mm_id = com_db_GetValue("select mm_id from ".TABLE_PERSONAL_MEDIA_MENTION." where personal_id='".$insert_id."' order by pub_date desc");
						if($mm_id > 0 && $mm_id != ''){
							com_db_query("update ".TABLE_PERSONAL_MASTER." set all_trigger_id ='".$mm_id."' where personal_id = '" . $insert_id . "'");
						}
						break;
					case 'Speaking':
						$speaking_id = com_db_GetValue("select speaking_id from ".TABLE_PERSONAL_SPEAKING." where personal_id='".$insert_id."' and event_date >'".date("Y-m-d")."' order by event_date desc");
						if($speaking_id > 0 && $speaking_id != ''){
							com_db_query("update ".TABLE_PERSONAL_MASTER." set all_trigger_id ='".$speaking_id."' where personal_id = '" . $insert_id . "'");
						}else{
							com_db_query("update ".TABLE_PERSONAL_MASTER." set demo_email= 0,person_tigger_name ='' where personal_id = '" . $insert_id . "'");
						}
						break;
					case 'Publication':
						$publication_id = com_db_GetValue("select publication_id from ".TABLE_PERSONAL_PUBLICATION." where personal_id='".$insert_id."' order by publication_date desc");
						if($publication_id > 0 && $publication_id != ''){
							com_db_query("update ".TABLE_PERSONAL_MASTER." set all_trigger_id ='".$publication_id."' where personal_id = '" . $insert_id . "'");
						}
						break;
				}
			}
			*/
			
			
	  		com_redirect("personal.php?p=" . $p . "&msg=" . msg_encode("Personal added successfully"));
		 
		break;	
		
	case 'detailes':
			$query_edit ="select * from " .TABLE_PERSONAL_MASTER. " where personal_id = '" . $pID . "'";
			
			$query_edit_result=com_db_query($query_edit);
	  		$data_edit=com_db_fetch_array($query_edit_result);
			
			$first_name = com_db_output($data_edit['first_name']);
			$middle_name = com_db_output($data_edit['middle_name']);
			$last_name = com_db_output($data_edit['last_name']);
			$email = com_db_output($data_edit['email']);
			$phone = com_db_output($data_edit['phone']);
			$lin_url = com_db_output($data_edit['lin_url']);
			$personal_image = com_db_output($data_edit['personal_image']);
			$facebook_link = com_db_output($data_edit['facebook_link']);
			$linkedin_link = com_db_output($data_edit['linkedin_link']);
			$twitter_link = com_db_output($data_edit['twitter_link']);
			$googleplush_link = com_db_output($data_edit['googleplush_link']);
			$about_person = $data_edit['about_person'];
			$personal = com_db_output($data_edit['personal']);
			$edu_ugrad_degree = com_db_output($data_edit['edu_ugrad_degree']);
			$edu_ugrad_specialization = com_db_output($data_edit['edu_ugrad_specialization']); 
			$edu_ugrad_college = com_db_output($data_edit['edu_ugrad_college']);
			$edu_ugrad_year = com_db_output($data_edit['edu_ugrad_year']);
			$edu_grad_degree = com_db_output($data_edit['edu_grad_degree']);
			$edu_grad_specialization = com_db_output($data_edit['edu_grad_specialization']); 
			$edu_grad_college = com_db_output($data_edit['edu_grad_college']);
			$edu_grad_year = com_db_output($data_edit['edu_grad_year']);
			
			$awards_title  = com_db_output($data_edit['awards_title']);
			$awards_given_by  = com_db_output($data_edit['awards_given_by']);
			$adt = explode('-',$data_edit['awards_date']);
			$awards_date = 	$adt[1].'/'.$adt[2].'/'.$adt[0];		
			$add_date =explode('-',$data_edit['add_date']);
			
			$email_validation_api_result = com_db_output($data_edit['email_validation_api_result']);
			
			
		break;	
		
	  case 'activate':
     		
	   		
	   		$status=$_GET['status'];
			if($status==0){
				$query = "update " . TABLE_PERSONAL_MASTER . " set status = '1' where personal_id = '" . $pID . "'";
			}else{
				$query = "update " . TABLE_PERSONAL_MASTER . " set status = '0' where personal_id = '" . $pID . "'";
			}	
			com_db_query($query);
			
	  		com_redirect("personal.php?p=". $p ."&pID=" . $pID . "&msg=" . msg_encode("Personal update successfully"));
			
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
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="only-dataentry.js"></script>
  
<script type="text/javascript" src="../js/datetimepicker_css.js" language="javascript"></script>  
<script type="text/javascript">


function  checkBuysideDemo()
{
	document.getElementById("executive_email").checked = true;
}


function PersonalSearch(){
	window.location ='personal.php?action=PersonalSearch';
}

function ExecutiveTiggerOnOff(){
				if(document.getElementById('executive_email').checked){
					document.getElementById('executive_tigger').style.visibility="visible";
				}else{
					document.getElementById('executive_tigger').style.visibility="hidden";
				}
			}



function confirm_del(nid,p){
	var agree=confirm("Personal will be deleted. \n Do you want to continue?");
	if (agree)
		window.location = "personal.php?pID=" + nid + "&p=" + p + "&action=delete";
	else
		window.location = "personal.php?pID=" + nid + "&p=" + p ;
}

function confirm_artivate(nid,p,status){
	if(status=='1'){
		var msg="Personal master will be active. \n Do you want to continue?";
	}else{
		var msg="Personal master will be Inactive. \n Do you want to continue?";
	}
	var agree=confirm(msg);
	if (agree)
		window.location = "personal.php?pID=" + nid + "&p=" + p + "&status=" + status + "&action=activate";
	else
		window.location = "personal.php?pID=" + nid + "&p=" + p ;
}
function PersonalSearch(){
	window.location ='personal.php?action=PersonalSearch';
}
</script>
<script>
function addEventAwards() {
  var ni = document.getElementById('myDivAwards');
  var numi = document.getElementById('theValueAwards');
  var num = (document.getElementById("theValueAwards").value -1)+ 2;
  numi.value = num;
  var divIdName = "my"+num+"DivAwards";
  var newdiv = document.createElement('div');
  var pdt = 'awards_date'+num;
  newdiv.setAttribute("id",divIdName);
  newdiv.innerHTML = "<table border='0' width='100%' cellpadding='2' cellspacing='2'><tr><td width='25%' class='page-text'>Awards Title:</td><td width='75%'><input type='text' name='awards_title[]'></td></tr><tr><td class='page-text'>Awards Given By:</td><td><input type='text' name='awards_given_by[]' value=''></td></tr><tr><td class='page-text'>Awards Date:</td><td><input type='text' name='awards_date[]' id=" + pdt + " value=''>&nbsp;<a href=\"javascript:NewCssCal('"+pdt+"','mmddyyyy','arrow')\"><img src=\"images/calender-icon.gif\" alt='' width='22' height='14' border='0'/></a></td></tr><tr><td class='page-text'>Link:</td><td><input type='text' name='awards_link[]' value=''></td></tr><tr><td>&nbsp;</td><td><a href=\"javascript:;\" onclick=\"removeElementAwards(\'"+divIdName+"\')\">Remove the above Awards?</a></td></tr></table>";
  ni.appendChild(newdiv);
}
function removeElementAwards(divNum) {
  var d = document.getElementById('myDivAwards');
  var olddiv = document.getElementById(divNum);
  d.removeChild(olddiv);
}

function addEventBoard() {
  var ni = document.getElementById('myDivBoard');
  var numi = document.getElementById('theValueBoard');
  var num = (document.getElementById("theValueBoard").value -1)+ 2;
  numi.value = num;
  var divIdName = "my"+num+"DivBoard";
  var newdiv = document.createElement('div');
  var pdt = 'board_date'+num;
  newdiv.setAttribute("id",divIdName);
  newdiv.innerHTML = "<table border='0' width='100%' cellpadding='2' cellspacing='2'><tr><td width='25%' class='page-text'>Board Info:</td><td width='75%'><input type='text' name='board_info[]'></td></tr><tr><td class='page-text'>Date:</td><td><input type='text' name='board_date[]' id=" + pdt + " value=''>&nbsp;<a href=\"javascript:NewCssCal('"+pdt+"','mmddyyyy','arrow')\"><img src=\"images/calender-icon.gif\" alt='' width='22' height='14' border='0'/></a></td></tr><tr><td width='25%' class='page-text'>Link:</td><td width='75%'><input type='text' name='board_link[]'></td></tr><tr><td>&nbsp;</td><td><a href=\"javascript:;\" onclick=\"removeElementBoard(\'"+divIdName+"\')\">Remove the above Board?</a></td></tr></table>";
  ni.appendChild(newdiv);
}
function removeElementBoard(divNum) {
  var d = document.getElementById('myDivBoard');
  var olddiv = document.getElementById(divNum);
  d.removeChild(olddiv);
}

function addEventSpeaking() {
  var ni = document.getElementById('myDivSpeaking');
  var numi = document.getElementById('theValueSpeaking');
  var num = (document.getElementById("theValueSpeaking").value -1)+ 2;
  numi.value = num;
  var divIdName = "my"+num+"DivSpeaking";
  var newdiv = document.createElement('div');
  var pdt = 'event_date'+num;
  newdiv.setAttribute("id",divIdName);
  newdiv.innerHTML = "<table border='0' width='100%' cellpadding='2' cellspacing='2'><tr><td width='25%' class='page-text'>Role:</td><td width='75%'><select name='role[]' style='width:147px;'><option value=''>Select Role</option><option value='Speaker'>Speaker</option><option value='Panelist'>Panelist</option><option value='Keynote'>Keynote</option></select></td></tr><tr><td class='page-text'>Topic:</td><td><input type='text' name='topic[]' value=''></td></tr><tr><td valign='top' class='page-text'>Event:</td><td><input type='text' name='event[]' ></td></tr><tr><td class='page-text'>Date:</td><td><input type='text' name='event_date[]' id=" + pdt + " value=''>&nbsp;<a href=\"javascript:NewCssCal('"+pdt+"','mmddyyyy','arrow')\"><img src=\"images/calender-icon.gif\" alt='' width='22' height='14' border='0'/></a></td></tr><tr><td class='page-text'>Link:</td><td><input type='text' name='speaking_link[]' value=''></td></tr><tr><td>&nbsp;</td><td><a href=\"javascript:;\" onclick=\"removeElementSpeaking(\'"+divIdName+"\')\">Remove the above speaking?</a></td></tr></table>";
  ni.appendChild(newdiv);
}
function removeElementSpeaking(divNum) {
  var d = document.getElementById('myDivSpeaking');
  var olddiv = document.getElementById(divNum);
  d.removeChild(olddiv);
}

function addEventMedia() {
  var ni = document.getElementById('myDivMedia');
  var numi = document.getElementById('theValueMedia');
  var num = (document.getElementById("theValueMedia").value -1)+ 2;
  numi.value = num;
  var divIdName = "my"+num+"DivMedia";
  var newdiv = document.createElement('div');
  var pdt = 'pub_date'+num;
  newdiv.setAttribute("id",divIdName);
  newdiv.innerHTML = "<table border='0' width='100%' cellpadding='2' cellspacing='2'><tr><td class='page-text'>Date:</td><td><input type='text' name='pub_date[]' id=" + pdt + " value=''>&nbsp;<a href=\"javascript:NewCssCal('"+pdt+"','mmddyyyy','arrow')\"><img src=\"images/calender-icon.gif\" alt='' width='22' height='14' border='0'/></a></td></tr><tr><td width='25%' class='page-text'>Publication:</td><td width='75%'><input type='text' name='publication[]'></td></tr><tr><td class='page-text'>Quote:</td><td><input type='text' name='quote[]' value=''></td></tr><tr><td class='page-text'>Link:</td><td><input type='text' name='media_link[]' value=''></td></tr><tr><td>&nbsp;</td><td><a href=\"javascript:;\" onclick=\"removeElementMedia(\'"+divIdName+"\')\">Remove the above Media?</a></td></tr></table>";
  ni.appendChild(newdiv);
}

function removeElementMedia(divNum) {
  var d = document.getElementById('myDivMedia');
  var olddiv = document.getElementById(divNum);
  d.removeChild(olddiv);
}

function addEventPublication() {
  var ni = document.getElementById('myDivPublication');
  var numi = document.getElementById('theValuePublication');
  var num = (document.getElementById("theValuePublication").value -1)+ 2;
  numi.value = num;
  var divIdName = "my"+num+"DivPublication";
  var newdiv = document.createElement('div');
  var pdt = 'publication_date'+num;
  newdiv.setAttribute("id",divIdName);
  newdiv.innerHTML = "<table border='0' width='100%' cellpadding='2' cellspacing='2'><tr><td width='25%' class='page-text'>Title:</td><td width='75%'><input type='text' name='pub_title[]'></td></tr><tr><td class='page-text'>Date:</td><td><input type='text' name='publication_date[]' id=" + pdt + " value=''>&nbsp;<a href=\"javascript:NewCssCal('"+pdt+"','mmddyyyy','arrow')\"><img src=\"images/calender-icon.gif\" alt='' width='22' height='14' border='0'/></a></td></tr><tr><td class='page-text'>Link:</td><td><input type='text' name='pub_link[]' value=''></td></tr><tr><td>&nbsp;</td><td><a href=\"javascript:;\" onclick=\"removeElementPublication(\'"+divIdName+"\')\">Remove the above Publication?</a></td></tr></table>";
  ni.appendChild(newdiv);
}

function removeElementPublication(divNum) {
  var d = document.getElementById('myDivPublication');
  var olddiv = document.getElementById(divNum);
  d.removeChild(olddiv);
}
</script>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="selectuser.js" language="javascript"></script>

</head>
<body>
<div id="light" class="white_content" style="display:<? if($action=='PersonalSearch'){ echo 'block';} else { echo 'none'; } ?>; height:auto;">
		<div id="spiffycalendar" class="text"></div>
		<link rel="stylesheet" type="text/css" href="includes/javascript/spiffyCal/spiffyCal_v2_1.css">
		<script language="JavaScript" src="includes/javascript/spiffyCal/spiffyCal_v2_1.js"></script>
		<script language="javascript">
		  var dateAvailableFrom = new ctlSpiffyCalendarBox("dateAvailableFrom", "frmSearch", "from_date","btnDate1","",scBTNMODE_CUSTOMBLUE);
		  var dateAvailableTo = new ctlSpiffyCalendarBox("dateAvailableTo", "frmSearch", "to_date","btnDate2","",scBTNMODE_CUSTOMBLUE);	
		</script>
		<form name="frmSearch" id="frmSearch" method="post" action="personal.php?action=SearchResult">
		<table width="80%" border="0" align="center" cellpadding="1" cellspacing="1">
		  <tr>
			<td align="left" colspan="2" valign="top"><img src="images/specer.gif" width="1" height="50" alt="" title="" /> </td>
		  </tr>
          <tr><td colspan="2">&nbsp;</td></tr>
		  <tr>
			<td align="left" valign="top" >First Name:</td>
			<td align="left" valign="top"><input name="search_first_name" id="search_first_name" /></td>
		  </tr>
		  <tr>
			<td align="left" valign="top">Last Name:</td>
			<td align="left" valign="top"><input name="search_last_name" id="search_last_name" /></td>
		  </tr>
		  <tr>
			<td align="left" valign="top">Email:</td>
			<td align="left" valign="top"><input name="search_email" id="search_email" /></td>
		  </tr>
          <tr>
			<td align="left" valign="top">Phone:</td>
			<td align="left" valign="top"><input name="search_phone" id="search_phone" /></td>
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
			<td align="center" valign="top">&nbsp;</td>
			<td align="center" valign="top">&nbsp;</td>
		  </tr>
		  <tr>
			<td align="center" valign="top">&nbsp;</td>
		  	<td align="left" valign="top"><input type="submit" value="Search" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="Cancel" onclick="window.location='personal.php?selected_menu=personal'" /></td>
		  </tr>
		  <tr>
			<td align="center" valign="top">&nbsp;</td>
			<td align="center" valign="top">&nbsp;</td>
		  </tr>
		</table>
		</form>
	</div>
	<div id="fade" class="black_overlay" style="display:<? if($action=='PersonalSearch'){ echo 'block';} else { echo 'none'; } ?>;"></div>



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
                        <td width="196" align="left" valign="top"><a href="personal.php"><img src="<?=HTTP_SERVER.DIR_WS_HTTP_FOLDER.DIR_IMAGES?>logo.jpg"  alt="Logo" width="196" height="32" border="0" title="Logo" /></a></td>
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
                              
                              <td width="3%" align="right" valign="middle"><a href="#"><img src="images/search-icon.jpg" border="0" width="25" height="28"  alt="Search Contact" title="Search Contact" onclick="PersonalSearch('PersonalSearch');"  /></a></td>
                              <td width="5%" align="left" valign="middle" class="nav-text">Search</td>
                              <td align="left" valign="middle"><a href="#"><img src="images/folder-icon.jpg" border="0" width="22" height="22" alt="Directory" title="Directory" onclick="window.location='personal.php?action=Directory'"  /></a></td>
                              <td align="left" valign="middle" class="nav-text">Directory</td>
                              <td width="3%" align="right" valign="middle"><a href="#"><img src="<?=HTTP_SERVER.DIR_WS_HTTP_FOLDER.DIR_IMAGES?>add-icon.jpg" border="0" width="25" height="28" alt="Add Contact" title="Add Contact" onclick="window.location='personal.php?action=add'"  /></a></td>
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
                    <td align="left" valign="middle" class="press-release-page-title-text">Personal: </td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><img src="<?=HTTP_SERVER.DIR_WS_HTTP_FOLDER.DIR_IMAGES?>specer.gif" width="1" height="10" alt="" title="" /></td>
                  </tr>
              
              </table></td>
            </tr>
          </table></td>
        </tr>
<? if($action=='Directory' || $action =='save' || $action=='SearchResult'){	?>	
        <tr>
          <td align="center" valign="top">
		  
		  <form name="topicform" id="topicform" method="post" action="personal.php?action=alldelete&p=<?=$p?>">
		  	<table width="100%" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="51" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-title-text">#</span></td>
				<td width="265" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Personal Name</span></td>
				<td width="165" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Email</span></td>
                <td width="150" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Phone</span></td>
                <td width="169" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Date</span> </td>
                <td width="158" height="30" align="center" valign="middle" class="left-border"><div align="center"><span class="right-box-title-text">Action</span></div></td>
			  </tr>
			<?php
			
			if($total_data>0) {
				$i=1;
				while ($data_sql = com_db_fetch_array($exe_data)) {
				$add_date = $data_sql['add_date'];
				$status = $data_sql['status'];
			?>          
			  <tr>
				<td height="30" align="center" valign="middle" class="right-border-left"><?=$i;?></td>
				<td height="30" align="left" valign="middle" class="right-border-text">&nbsp;<a href="personal.php?action=detailes&p=<?=$p?>&pID=<?=$data_sql['personal_id'];?>"><?=com_db_output($data_sql['first_name'].' '.$data_sql['last_name'])?></a></td>
                <td height="30" align="left" valign="middle" class="right-border-text">&nbsp;<?=com_db_output($data_sql['email'])?></td>
                <td height="30" align="left" valign="middle" class="right-border-text">&nbsp;<?=com_db_output($data_sql['phone'])?></td>
                <td height="30" align="center" valign="middle" class="right-border">&nbsp;<?=$add_date;?></td>
				<td height="30" align="center" valign="middle" class="left-border">
					<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr>
                      	<?	if($status==0){ ?>
					   	<td width="18%" align="center" valign="middle"><a href="#"><img src="images/icon/active-icon.gif" width="16" height="16" alt="" title="" border="0" onclick="confirm_artivate('<?=$data_sql['personal_id'];?>','<?=$p;?>','<?=$status;?>');" /></a><br />
					   	  Status</td>
					   	<? } elseif($status==1){ ?>
					   	<td width="16%" align="center" valign="middle"><a href="#"><img src="images/icon/inactive-icon.gif" width="16" height="16" alt="" title="" border="0" onclick="confirm_artivate('<?=$data_sql['personal_id'];?>','<?=$p;?>','<?=$status;?>');" /></a><br />
					   	  Status</td>
						<? } ?> 
					   	<td width="50%" align="center" valign="middle" class="actionText"><a href="#"><img src="images/small-edit-icon.gif" width="16" height="16" alt="Edit" title="Edit" border="0" onclick="window.location='personal.php?&p=<?=$p;?>&pID=<?=$data_sql['personal_id'];?>&action=edit'" /></a><br />
						  Edit</td>
						<td width="50%" align="center" valign="middle" class="actionText"><a href="#"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" title="Delete" border="0" onclick="confirm_del('<?=$data_sql['personal_id'];?>','<?=$p;?>')" /></a><br />
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
		  <script language="javascript" type="text/javascript">
			function chk_form_Add(){
				var fname=document.getElementById('first_name').value;
				if(fname==''){
					alert("Please enter first name.");
					document.getElementById('first_name').focus();
					return false;
				}
				var lname=document.getElementById('last_name').value;
				if(lname==''){
					alert("Please enter last name.");
					document.getElementById('last_name').focus();
					return false;
				}
			}
			function ClosePersonalDetails(){
				document.getElementById('DivPersonalDetails').style.display="none";
			}
			function ShowEmailVerifiedDate(){
				if(document.getElementById('email_verified').checked){
					var date = '<?=date("m/d/Y");?>';
					document.getElementById('email_verified_date').innerHTML=date;
				}else{
					document.getElementById('email_verified_date').innerHTML='';
				}
			}
			function PersonTiggerOnOff(){
				if(document.getElementById('demo_email').checked){
					document.getElementById('person_tigger').style.visibility="visible";
				}else{
					document.getElementById('person_tigger').style.visibility="hidden";
				}
			}
			</script>

		 
          <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" style="background-color:#CCC;height:30px;">
              <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="left" valign="middle" class="heading-text">Personal Manager :: Add Personal</td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="left" valign="top" class="right-border-box">
		 <!--start iner table  -->
		  <form name="frmDataAdd" id="frmDataAdd" method="post" action="personal.php?action=addsave" enctype="multipart/form-data" onsubmit="return  chk_form_Add();">
		  <table width="95%" align="left" cellpadding="5" cellspacing="5" border="0" style="position:relative;">
            <tr>
			  <td align="left" class="heading-text-a">>>Genaral Information</td>	
			</tr>
            <tr>
			  <td align="left">
              	  <table width="100%" cellpadding="2" cellspacing="2" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">First Name:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="first_name" id="first_name" size="30" /></td>
                    </tr>
					<tr>
                      <td width="25%" align="left" class="page-text" valign="top">Middle  Initial:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="middle_name" id="middle_name" size="30" value="" /> </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">Last Name:</td>
                      <td width="75%" align="left" valign="top">
                      	<input type="text" name="last_name" id="last_name" size="30" value="" onblur="PersonIsPresent();"/>
                        <div id="PersonAlreadyPresent" style="display:none;"></div>
                       </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">Email:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="email" id="email" size="30" />&nbsp;&nbsp;<input type="checkbox" name="email_verified" id="email_verified" value="Yes" onclick="ShowEmailVerifiedDate();" />Verified &nbsp;<span id="email_verified_date" /></span> </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">Email Verified Image:</td>
                      <td width="75%" align="left" valign="top"><input type="file" name="verified_image" id="verified_image" /></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">Phone:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="phone" id="phone" size="30" value="" /> </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">Headshot Photo:</td>
                      <td width="75%" align="left" valign="top"><input type="file" name="image" id="image" /> </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">About Person (bio):</td>
                      <td width="75%" align="left" valign="top">
                      	<textarea  id="about_person" name="about_person"></textarea>
						<script type="text/javascript">
                        //<![CDATA[
                            CKEDITOR.replace('about_person');
                        //]]>
                        </script>
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">Personal:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="personal" id="personal" size="30" value="" /> </td>	
                    </tr>
                  </table>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a">>>Social Media</td>	
			</tr>
            <tr>
			  <td align="left">
              	  <table width="100%" cellpadding="2" cellspacing="2" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">Facebook Link:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="facebook_link" id="facebook_link" size="30" value="" /></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">LinkedIn Link:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="linkedin_link" id="linkedin_link" size="30" value="" /></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">Twitter Link:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="twitter_link" id="twitter_link" size="30" value="" /></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">Google+ Link:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="googleplush_link" id="googleplush_link" size="30" value="" /></td>	
                    </tr>
                  </table>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a">>>Education (Undergrad)</td>	
			</tr>
            <tr>
			  <td align="left">
              	  <table width="100%" cellpadding="2" cellspacing="2" border="0">
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Degree:</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="edu_ugrad_degree" id="edu_ugrad_degree" size="30" value="" /> </td>	
                        </tr>
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Specialization:</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="edu_ugrad_specialization" id="edu_ugrad_specialization" size="30" value="" /> </td>	
                        </tr>
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">College:</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="edu_ugrad_college" id="edu_ugrad_college" size="30" value="" /> </td>	
                        </tr>
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Graduation Year :</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="edu_ugrad_year" id="edu_ugrad_year" size="30" value="" /> </td>	
                        </tr>
                  </table>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a">>>Education (Grad)</td>	
			</tr>
            <tr>
			  <td align="left">
              	  <table width="100%" cellpadding="2" cellspacing="2" border="0">
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Degree:</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="edu_grad_degree" id="edu_grad_degree" size="30" value="" /> </td>	
                        </tr>
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Specialization:</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="edu_grad_specialization" id="edu_grad_specialization" size="30" value="" /> </td>	
                        </tr>
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">College:</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="edu_grad_college" id="edu_grad_college" size="30" value="" /> </td>	
                        </tr>
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Graduation Year :</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="edu_grad_year" id="edu_grad_year" size="30" value="" /> </td>	
                        </tr>
                  </table>
              </td>	
			</tr>
			
			<tr>
			  <td align="right" style="color: #064962;font-family: Arial;font-size:13px;font-weight:bold;padding-right:150px;">
              	<input type="checkbox" name="add_to_funding" id="add_to_funding" value="1"  /> Add to funding?
              </td>	
			</tr>
			
            <tr>
			  <td align="left" class="heading-text-a">>>Awards</td>	
			</tr>
            <tr>
			  <td align="left" style="padding-left:25px;">
              	  	<input type="hidden" value="0" id="theValueAwards" />
                    <div id="myDivAwards"> </div>
                    <p><a href="javascript:;" onClick="addEventAwards();">Add More Awards</a></p>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a">>>Board</td>	
			</tr>
            <tr>
			  <td align="left" style="padding-left:25px;">
              	  	<input type="hidden" value="0" id="theValueBoard" />
                    <div id="myDivBoard"> </div>
                    <p><a href="javascript:;" onClick="addEventBoard();">Add More Board</a></p>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a">>>Speaking</td>	
			</tr>
            <tr>
			  <td align="left" style="padding-left:25px;">
              	  	<input type="hidden" value="0" id="theValueSpeaking" />
                    <div id="myDivSpeaking"> </div>
                    <p><a href="javascript:;" onClick="addEventSpeaking();">Add More Speaking</a></p>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a">>>Media Mention</td>	
			</tr>
            <tr>
			  <td align="left" style="padding-left:25px;">
              	  	<input type="hidden" value="0" id="theValueMedia" />
                    <div id="myDivMedia"> </div>
                    <p><a href="javascript:;" onClick="addEventMedia();">Add More Media</a></p>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a">>>Publication</td>	
			</tr>
            <tr>
			  <td align="left" style="padding-left:25px;">
              	  	<input type="hidden" value="0" id="theValuePublication" />
                    <div id="myDivPublication"> </div>
                    <p><a href="javascript:;" onClick="addEventPublication();">Add More Publication</a></p>
              </td>	
			</tr>
            <tr>
			  <td align="right" style="color: #064962;font-family: Arial;font-size:13px;font-weight:bold;padding-right:150px;">
              	<input type="checkbox" name="demo_email" id="demo_email" value="1" onclick="PersonTiggerOnOff();" /> Include in Demo?
				&nbsp;&nbsp;
				<input type="checkbox" name="executive_email" id="executive_email" value="1" onclick="ExecutiveTiggerOnOff();" /> Include in Buyside Demo?
              	
				<div style="display:block; float:right; width:430px;">
					<div id="person_tigger" style="visibility:hidden;width:200px;float:left;">
						<select name="person_tigger_name" id="person_tigger_name">
							<option value="Appointments">Appointments</option>
							<option value="Awards">Awards</option>
							<option value="Board">Board</option>
							<option value="Media Mention">Media Mention</option>
							<option value="Speaking">Speaking</option>
							<option value="Publication">Publication</option>
						</select>
					</div> 
					
					&nbsp;&nbsp;
					
					<div id="executive_tigger" style="visibility:hidden;width:200px;float:left;">
						<select name="executive_tigger_name" id="executive_tigger_name" onclick="checkBuysideDemo()">
							<option value="Appointments">Buyside Appointments</option>
							<option value="Awards">Buyside Awards</option>
							<option value="Board">Buyside Board</option>
							<option value="Media Mention">Buyside Media Mention</option>
							<option value="Speaking">Buyside Speaking</option>
							<option value="Publication">Buyside Publication</option>
						</select>
					</div> 
				</div> 
              </td>	
			</tr>
            <tr>
            	<td align="center">
                	<table width="50%" border="0" cellpadding="4" cellspacing="4">
                    	<tr><td><input type="submit" value="Add Person" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="Cancel" onclick="window.location='personal.php?p=<?=$p;?>&uID=<?=$uID;?>&selected_menu=personal'" /></td></tr>
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
          <script language="javascript" type="text/javascript">
			function chk_form(){
				var fname=document.getElementById('first_name').value;
				if(fname==''){
					alert("Please enter first name.");
					document.getElementById('first_name').focus();
					return false;
				}
				var lname=document.getElementById('last_name').value;
				if(lname==''){
					alert("Please enter last name.");
					document.getElementById('last_name').focus();
					return false;
				}
			}
			function ClosePersonalDetails(){
				document.getElementById('DivPersonalDetails').style.display="none";
			}
			function ShowEmailVerifiedDate(){
				if(document.getElementById('email_verified').checked){
					var date = '<?=date("m/d/Y");?>';
					document.getElementById('email_verified_date').innerHTML=date;
				}else{
					document.getElementById('email_verified_date').innerHTML='';
				}
			}
			function PersonTiggerOnOff(){
				if(document.getElementById('demo_email').checked){
					document.getElementById('person_tigger').style.visibility="visible";
				}else{
					document.getElementById('person_tigger').style.visibility="hidden";
				}
			}
			</script>
            <form name="frmDataEdit" id="frmDataEdit" method="post" enctype="multipart/form-data" action="personal.php?action=editsave&pID=<?=$pID;?>&p=<?=$p;?>" onsubmit="return chk_form();">
			<table width="95%" align="center" cellpadding="5" cellspacing="5" border="0" style="position:relative">
			 <tr>
            	<td>
                	<? if($verified_image !=''){ ?>
                	<div id="DivPersonalDetails">
                        <div style="padding:10px;width:350px;margin-top:150px;margin-right:30px;right:0;border:2px solid #666;position:absolute;background-color:#CCC;z-index:9999;">
							<img src="<?=HTTP_SITE_URL?>/images/close-buttn1.png" style="border:0px solid red; float:right;margin-top:-26px;margin-right:-22px;cursor:pointer;" onclick="ClosePersonalDetails();" />
                            <img src="../verivied_image/small/<?=$verified_image?>" />
                        </div>
                    </div>
                   <? } ?>
                </td>
            </tr>    
             <tr>
			  <td align="left" class="heading-text-a">>>Genaral Information</td>	
			</tr>
            <tr>
			  <td align="left">
              	  <table width="100%" cellpadding="2" cellspacing="2" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">First Name:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="first_name" id="first_name" size="30" value="<?=$first_name?>" /></td>
                    </tr>
					<tr>
                      <td width="25%" align="left" class="page-text" valign="top">Middle  Initial:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="middle_name" id="middle_name" size="30" value="<?=$middle_name?>" /> </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">Last Name:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="last_name" id="last_name" size="30"  value="<?=$last_name?>" /> </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">Email:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="email" id="email" size="30" value="<?=$email?>" />&nbsp;&nbsp;<input type="checkbox" name="email_verified" id="email_verified" value="Yes" onclick="ShowEmailVerifiedDate();" <? if($email_verified=='Yes'){echo 'checked="checked"'; } ?> />Verified &nbsp;<span id="email_verified_date" /><?=$email_verified_date?></span> </td>
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">Email Verified Image:</td>
                      <td width="75%" align="left" valign="top"><input type="file" name="verified_image" id="verified_image" /></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">Phone:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="phone" id="phone" size="30" value="<?=$phone?>" /> </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">Headshot Photo:</td>
                      <td width="75%" align="left" valign="top"><img src="../personal_photo/small/<?=$personal_image?>" height="80" width="80" /><br /><input type="file" name="image" id="image" /> </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">About Person (bio):</td>
                      <td width="75%" align="left" valign="top"> 
                      	<textarea  id="about_person" name="about_person"><?=$about_person?></textarea>
						<script type="text/javascript">
                        //<![CDATA[
                            CKEDITOR.replace('about_person');
                        //]]>
                        </script>
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">Personal:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="personal" id="personal" size="30" value="<?=$personal?>" /> </td>	
                    </tr>
                  </table>
               
              </td>	
			</tr>
           
            <tr>
			  <td align="left" class="heading-text-a">>>Social Media</td>	
			</tr>
            <tr>
			  <td align="left">
              	  <table width="100%" cellpadding="2" cellspacing="2" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">Facebook Link:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="facebook_link" id="facebook_link" size="30" value="<?=$facebook_link?>" /></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">LinkedIn Link:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="linkedin_link" id="linkedin_link" size="30" value="<?=$linkedin_link?>" /></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">Twitter Link:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="twitter_link" id="twitter_link" size="30" value="<?=$twitter_link?>" /></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">Google+ Link:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="googleplush_link" id="googleplush_link" size="30" value="<?=$googleplush_link?>" /></td>	
                    </tr>
                  </table>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a">>>Education (Undergrad)</td>	
			</tr>
            <tr>
			  <td align="left">
              	  <table width="100%" cellpadding="2" cellspacing="2" border="0">
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Degree:</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="edu_ugrad_degree" id="edu_ugrad_degree" size="30" value="<?=$edu_ugrad_degree?>" /> </td>	
                        </tr>
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Specialization:</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="edu_ugrad_specialization" id="edu_ugrad_specialization" size="30" value="<?=$edu_ugrad_specialization?>" /> </td>	
                        </tr>
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">College:</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="edu_ugrad_college" id="edu_ugrad_college" size="30" value="<?=$edu_ugrad_college?>" /> </td>	
                        </tr>
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Graduation Year :</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="edu_ugrad_year" id="edu_ugrad_year" size="30" value="<?=$edu_ugrad_year?>" /> </td>	
                        </tr>
                  </table>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a">>>Education (Grad)</td>	
			</tr>
            <tr>
			  <td align="left">
              	  <table width="100%" cellpadding="2" cellspacing="2" border="0">
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Degree:</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="edu_grad_degree" id="edu_grad_degree" size="30" value="<?=$edu_grad_degree?>" /> </td>	
                        </tr>
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Specialization:</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="edu_grad_specialization" id="edu_grad_specialization" size="30" value="<?=$edu_grad_specialization?>" /> </td>	
                        </tr>
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">College:</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="edu_grad_college" id="edu_grad_college" size="30" value="<?=$edu_grad_college?>" /> </td>	
                        </tr>
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Graduation Year :</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="edu_grad_year" id="edu_grad_year" size="30" value="<?=$edu_grad_year?>" /> </td>	
                        </tr>
                  </table>
              </td>	
			</tr>
			
			<tr>
			  <td align="right" style="color: #064962;font-family: Arial;font-size:13px;font-weight:bold;padding-right:150px;">
              	<input type="checkbox" name="add_to_funding" id="add_to_funding" value="1" <? if ($add_to_funding==1){echo 'checked="checked"';} ?> /> Add to funding?
              </td>	
			</tr>
			
			
            <tr>
			  <td align="left" class="heading-text-a">>>Awards</td>	
			</tr>
            <tr>
			  <td align="left" style="padding-left:25px;">
                  <? 
					$awardsQuery = "select * from ".TABLE_PERSONAL_AWARDS." where personal_id='".$pID."' order by awards_id";
					$awardsResult = com_db_query($awardsQuery);
					if($awardsResult){
						$awards_num_row = com_db_num_rows($awardsResult);
					}
					?>
              		<input type="hidden" value="<?=$awards_num_row;?>" id="theValueAwards" />
              		<div id="myDivAwards">
              		<? 
					$awards=0;
					while($awardsRow = com_db_fetch_array($awardsResult)){
						$aDt = explode('-',$awardsRow['awards_date']);
						$awards_date = $aDt[1].'/' .$aDt[2].'/'.$aDt[0];
					?>
                    <div id="my<?=$awards?>DivAwards">
              		<table width="100%" cellpadding="2" cellspacing="2" border="0">
                         <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Awards Title:</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="awards_title[]" value='<?=com_db_output($awardsRow['awards_title'])?>' /></td>	
                         </tr>
                         <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Awards Given By:</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="awards_given_by[]" value='<?=com_db_output($awardsRow['awards_given_by']);?>' /></td>	
                         </tr>
                         <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Awards Date:</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="awards_date[]" id="awards_date<?=$awards;?>" value="<?=$awards_date;?>" />
                          	 <a href="javascript:NewCssCal('awards_date<?=$awards;?>','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a>
                          </td>	
                         </tr>
                         <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Link:</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="awards_link[]" value='<?=com_db_output($awardsRow['awards_link']);?>' /></td>	
                         </tr>
                         <tr>
                         	<td>&nbsp;</td>
                         	<td><a href="javascript:;" onclick="removeElementAwards('my<?=$awards?>DivAwards')">Remove the above Awards?</a></td></tr>
                    </table>
                    </div>
                  <? $awards++;
				  	} ?>
              	  	</div>
                    <p><a href="javascript:;" onClick="addEventAwards();">Add More Board</a></p>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a">>>Board</td>	
			</tr>
            <tr>
			  <td align="left" style="padding-left:25px;">
              		<? 
					$boardQuery = "select * from ".TABLE_PERSONAL_BOARD." where personal_id='".$pID."' order by board_id";
					$boardResult = com_db_query($boardQuery);
					if($boardResult){
						$board_num_row = com_db_num_rows($boardResult);
					}
					?>
              		<input type="hidden" value="<?=$board_num_row;?>" id="theValueBoard" />
              		<div id="myDivBoard">
              		<? 
					$board=0;
					while($boardRow = com_db_fetch_array($boardResult)){
						$bDt = explode('-',$boardRow['board_date']);
						$board_date = $bDt[1].'/' .$bDt[2].'/'.$bDt[0];
					?>
                    <div id="my<?=$board?>DivBoard">
              		<table width="100%" cellpadding="2" cellspacing="2" border="0">
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Board Info:</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="board_info[]" value="<?=$boardRow['board_info'];?>" /></td>	
                         </tr>
                         <tr>
                          <td width="25%" align="left" class="page-text" valign="top"> Date:</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="board_date[]" id="board_date<?=$board;?>" value="<?=$board_date;?>" />
                          	 <a href="javascript:NewCssCal('board_date<?=$board;?>','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a>
                          </td>	
                         </tr>
                         <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Link:</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="board_link[]" value="<?=$boardRow['board_link'];?>" /></td>	
                         </tr>
                         <tr>
                         	<td>&nbsp;</td>
                         	<td><a href="javascript:;" onclick="removeElementBoard('my<?=$board?>DivBoard')">Remove the above Board?</a></td></tr>
                    </table>
                    </div>
                  <? $board++;
				  	} ?>
              	  	</div>
                    <p><a href="javascript:;" onClick="addEventBoard();">Add More Board</a></p>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a">>>Speaking</td>	
			</tr>
             <tr>
			  <td align="left" style="padding-left:25px;">
              		<? 
					$spQuery = "select * from ".TABLE_PERSONAL_SPEAKING." where personal_id='".$pID."' order by speaking_id";
					$spResult = com_db_query($spQuery);
					if($spResult){
						$sp_num_row = com_db_num_rows($spResult);
					}
					?>
              		<input type="hidden" value="<?=$sp_num_row;?>" id="theValueSpeaking" />
              		<div id="myDivSpeaking">
              		<? 
					$speaking=0;
					while($spRow = com_db_fetch_array($spResult)){
						$eDt = explode('-',$spRow['event_date']);
						$event_date = $eDt[1].'/' .$eDt[2].'/'.$eDt[0];
					?>
                    <div id="my<?=$speaking?>DivSpeaking">
              		<table width="100%" cellpadding="2" cellspacing="2" border="0">
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Role:</td>
                          <td width="75%" align="left" valign="top"><!--<input type="text" name="role[]" value="<?//=$spRow['role'];?>" />-->
                          	<select name="role[]" style="width:147px;">
                                <option value="">Select Role</option>
                                <option value="Speaker" <? if($spRow['role']=='Speaker'){echo 'selected="selected"';} ?> >Speaker</option>
                                <option value="Panelist" <? if($spRow['role']=='Panelist'){echo 'selected="selected"';} ?>>Panelist</option>
                                <option value="Keynote" <? if($spRow['role']=='Keynote'){echo 'selected="selected"';} ?>>Keynote</option>
                            </select>
                          </td>	
                         </tr>
                         <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Topic:</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="topic[]" value="<?=$spRow['topic']?>" /></td>	
                         </tr>
                         <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Event:</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="event[]" value="<?=$spRow['event'];?>" /></td>	
                         </tr>
                         <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Date:</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="event_date[]" id="event_date<?=$speaking;?>" value="<?=$event_date;?>" />
                          	  <a href="javascript:NewCssCal('event_date<?=$speaking;?>','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a>
                          </td>	
                         </tr>
                          <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Link:</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="speaking_link[]" value="<?=$spRow['speaking_link'];?>" /></td>	
                         </tr>
                         <tr>
                         	<td>&nbsp;</td>
                         	<td><a href="javascript:;" onclick="removeElementSpeaking('my<?=$speaking?>DivSpeaking')">Remove the above Speaking?</a></td></tr>
                    </table>
                    </div>
                  <? $speaking++;
				  	} ?>
              	  	</div>
                    <p><a href="javascript:;" onClick="addEventSpeaking();">Add More Speaking</a></p>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a">>>Media Mention</td>	
			</tr>
            <tr>
			  <td align="left" style="padding-left:25px;">
              		<?
					$mediaQuery = "select * from ".TABLE_PERSONAL_MEDIA_MENTION." where personal_id='".$pID."' order by mm_id";
					$mediaResult = com_db_query($mediaQuery);
					if($mediaResult){
						$media_num_row = com_db_num_rows($mediaResult);
					}
					?>
              		<input type="hidden" value="<?=$media_num_row;?>" id="theValueMedia" />
              		<div id="myDivMedia">
              		<? 
					$media=0;
					while($mediaRow = com_db_fetch_array($mediaResult)){
						$pDt = explode('-',$mediaRow['pub_date']);
						$pub_date = $pDt[1].'/' .$pDt[2].'/'.$pDt[0];
						
					?>
                    <div id="my<?=$media?>DivMedia">
              		<table width="100%" cellpadding="2" cellspacing="2" border="0">
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Date:</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="pub_date[]" id="pub_date<?=$media;?>" value="<?=$pub_date;?>" />
                          	 <a href="javascript:NewCssCal('pub_date<?=$media;?>','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a>
                          </td>	
                         </tr>
                         <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Publication:</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="publication[]" value='<?=com_db_output($mediaRow['publication'])?>' /></td>	
                         </tr>
                         <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Quote:</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="quote[]" value='<?=com_db_output($mediaRow['quote']);?>' /></td>	
                         </tr>
                         <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Link:</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="media_link[]" value='<?=com_db_output($mediaRow['media_link']);?>' /></td>	
                         </tr>
                         <tr>
                         	<td>&nbsp;</td>
                         	<td><a href="javascript:;" onclick="removeElementMedia('my<?=$media?>DivMedia')">Remove the above Media?</a></td></tr>
                    </table>
                    </div>
                  <? $media++;
				  	} ?>
              	  	</div>
                    <p><a href="javascript:;" onClick="addEventMedia();">Add More Media</a></p>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a">>>Publication</td>	
			</tr>
            <tr>
			  <td align="left" style="padding-left:25px;">
              		<?
					$pubQuery = "select * from ".TABLE_PERSONAL_PUBLICATION." where personal_id='".$pID."' order by publication_id";
					$pubResult = com_db_query($pubQuery);
					if($pubResult){
						$pub_num_row = com_db_num_rows($pubResult);
					}
					?>
              		<input type="hidden" value="<?=$pub_num_row;?>" id="theValuePublication" />
              		<div id="myDivPublication">
              		<? 
					
					$pub=0;
					while($pubRow = com_db_fetch_array($pubResult)){
						$pDt = explode('-',$pubRow['publication_date']);
						$publication_date = $pDt[1].'/' .$pDt[2].'/'.$pDt[0];
					?>
                    <div id="my<?=$pub?>DivPublication">
              		<table width="100%" cellpadding="2" cellspacing="2" border="0">
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Title:</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="pub_title[]" value="<?=$pubRow['title'];?>" /></td>	
                         </tr>
                         <tr>
                          <td width="25%" align="left" class="page-text" valign="top"> Date:</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="publication_date[]" id="publication_date<?=$pub;?>" value="<?=$publication_date;?>" />
                          	 <a href="javascript:NewCssCal('publication_date<?=$pub;?>','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a>
                          </td>	
                         </tr>
                         <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Link:</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="pub_link[]" value="<?=$pubRow['link']?>" /></td>
                         </tr>
                         <tr>
                         	<td>&nbsp;</td>
                         	<td><a href="javascript:;" onclick="removeElementPublication('my<?=$pub?>DivPublication')">Remove the above Publication?</a></td></tr>
                    </table>
                    </div>
                  <? $pub++;
				  	} ?>
              	  	</div>
                    <p><a href="javascript:;" onClick="addEventPublication();">Add More Publication</a></p>
              </td>	
			</tr>
            <tr>
			  <td align="right" style="color: #064962;font-family: Arial;font-size:13px;font-weight:bold;padding-right:150px;">
              	<input type="checkbox" name="demo_email" id="demo_email" value="1" <? if ($demo_email==1){echo 'checked="checked"';} ?> onclick="PersonTiggerOnOff();" /> Include in Demo?
              	
				&nbsp;&nbsp;
				<input type="checkbox" name="executive_email" id="executive_email" value="1" <? if ($executive_email==1){echo 'checked="checked"';} ?> onclick="ExecutiveTiggerOnOff();" /> Include in Buyside Demo?
				<div style="display:block; float:right; width:430px;">
					<div id="person_tigger" style="hidden;width:200px;float:left;visibility: <? if ($demo_email==1){echo 'visible';}else{echo 'hidden';}?>;">
						<select name="person_tigger_name" id="person_tigger_name">
							<option value="Appointments" <? if($person_tigger_name=='Appointments'){echo 'selected="selected"'; }?>>Appointments</option>
							<option value="Awards" <? if($person_tigger_name=='Awards'){echo 'selected="selected"'; }?>>Awards</option>
							<option value="Board" <? if($person_tigger_name=='Board'){echo 'selected="selected"'; }?>>Board</option>
							<option value="Media Mention" <? if($person_tigger_name=='Media Mention'){echo 'selected="selected"'; }?>>Media Mention</option>
							<option value="Speaking" <? if($person_tigger_name=='Speaking'){echo 'selected="selected"'; }?>>Speaking</option>
							<option value="Publication" <? if($person_tigger_name=='Publication'){echo 'selected="selected"'; }?>>Publication</option>
						</select>
					</div>  
					
					
					&nbsp;&nbsp;
					
					<div id="executive_tigger" style="width:200px;float:left;visibility: <? if ($executive_email==1){echo 'visible';}else{echo 'hidden';}?>;">
						<select name="executive_tigger_name" id="executive_tigger_name" onclick="checkBuysideDemo()">
							<option value="Appointments">Buyside Appointments</option>
							<option value="Awards">Buyside Awards</option>
							<option value="Board">Buyside Board</option>
							<option value="Media Mention">Buyside Media Mention</option>
							<option value="Speaking">Buyside Speaking</option>
							<option value="Publication">Buyside Publication</option>
						</select>
					</div> 
				</div> 
              </td>	
			</tr>
            <tr>
            	<td align="center">
                	<table width="50%" border="0" cellpadding="4" cellspacing="4">
                    	<tr>
                        	<td width="22%"><input type="submit" value="Update Personal" class="submitButton" /></td>
                            <td width="78%"><input type="button" class="submitButton" value="Cancel" onclick="window.location='personal.php?p=<?=$p;?>&pID=<?=$pID;?>'" /></td>
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
		  
		  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" style="background-color:#CCC;height:30px;"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">Personal Manager :: Personal Details </td>
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box">
            	<table width="98%" align="center" cellpadding="0" cellspacing="0">
           		<tr>
		  			<td align="left" valign="top" >
		 <!--start iner table  -->
		         <table width="100%" align="center" cellpadding="2" cellspacing="2" border="0">
            		 <tr>
                      <td align="left" class="heading-text-a">>>Genaral Information</td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">First Name:</td>
                      <td width="75%" align="left" valign="top"><?=$first_name;?></td>
                    </tr>
					<tr>
                      <td width="25%" align="left" class="page-text" valign="top">Middle  Initial:</td>
                      <td width="75%" align="left" valign="top"><?=$middle_name;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">Last Name:</td>
                      <td width="75%" align="left" valign="top"><?=$last_name;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">Email:</td>
                      <td width="75%" align="left" valign="top"><?=$email;?>  </td>	
                    </tr>
					
					<?PHP
					if($email_validation_api_result != '')
					{
					?>
					<tr>
                      <td width="25%" align="left" class="page-text" valign="top">API Email Validation Result:</td>
                      <td width="75%" align="left" valign="top"><?=$email_validation_api_result;?>  </td>	
                    </tr>
					<?PHP
					}
					?>
					
					
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">Phone:</td>
                      <td width="75%" align="left" valign="top"><?=$phone;?>  </td>	
                    </tr>
                  
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">Headshot Photo:</td>
                      <td width="75%" align="left" valign="top"><img src="../personal_photo/small/<?=$personal_image?>" alt="" width="80" height="80" /></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">About Person (bio):</td>
                      <td width="75%" align="left" valign="top"><?=$about_person;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">Personal:</td>
                      <td width="75%" align="left" valign="top"><?=$personal;?></td>	
                    </tr>
                  </table>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a">>>Social Media</td>	
			</tr>
            <tr>
			  <td align="left">
              	  <table width="100%" cellpadding="2" cellspacing="2" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">Facebook Link:</td>
                      <td width="75%" align="left" valign="top"><?=$facebook_link?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">LinkedIn Link:</td>
                      <td width="75%" align="left" valign="top"><?=$linkedin_link?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">Twitter Link:</td>
                      <td width="75%" align="left" valign="top"><?=$twitter_link?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">Google+ Link:</td>
                      <td width="75%" align="left" valign="top"><?=$googleplush_link?></td>	
                    </tr>
                  </table>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a">>>Education (Undergrad)</td>	
			</tr>
            <tr>
			  <td align="left">
              	  <table width="100%" cellpadding="2" cellspacing="2" border="0">
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Degree:</td>
                          <td width="75%" align="left" valign="top"><?=$edu_ugrad_degree?></td>	
                        </tr>
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Specialization:</td>
                          <td width="75%" align="left" valign="top"><?=$edu_ugrad_specialization?></td>	
                        </tr>
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">College:</td>
                          <td width="75%" align="left" valign="top"><?=$edu_ugrad_college?></td>	
                        </tr>
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Graduation Year :</td>
                          <td width="75%" align="left" valign="top"><?=$edu_ugrad_year?></td>	
                        </tr>
                  </table>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a">>>Education (Grad)</td>	
			</tr>
            <tr>
			  <td align="left">
              	  <table width="100%" cellpadding="2" cellspacing="2" border="0">
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Degree:</td>
                          <td width="75%" align="left" valign="top"><?=$edu_grad_degree?></td>	
                        </tr>
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Specialization:</td>
                          <td width="75%" align="left" valign="top"><?=$edu_grad_specialization?></td>	
                        </tr>
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">College:</td>
                          <td width="75%" align="left" valign="top"><?=$edu_grad_college?></td>	
                        </tr>
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Graduation Year :</td>
                          <td width="75%" align="left" valign="top"><?=$edu_grad_year?></td>	
                        </tr>
                  </table>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a">>>Awards</td>	
			</tr>
            <?  $awardsQuery = "select * from ".TABLE_PERSONAL_AWARDS." where personal_id='".$pID."'";
                $awardsResult = com_db_query($awardsQuery);
                while($awardsRow = com_db_fetch_array($awardsResult)){ 
				$adt = explode('-',$awardsRow['awards_date']);
				$awards_date = $adt[1].'/'.$adt[2].'/'.$adt[0];
            ?>
            <tr>
			  <td align="left" width="100%">
              	  	<table width="100%" cellpadding="2" cellspacing="2" border="0">
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Awards Title:</td>
                          <td width="75%" align="left" valign="top"><?=com_db_output($awardsRow['awards_title'])?></td>	
                        </tr>
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Awards Given By:</td>
                          <td width="75%" align="left" valign="top"><?=com_db_output($awardsRow['awards_given_by'])?></td>	
                        </tr>
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Awards Date:</td>
                          <td width="75%" align="left" valign="top"><?=$awards_date?></td>	
                        </tr>
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Link:</td>
                          <td width="75%" align="left" valign="top"><?=com_db_output($awardsRow['awards_link'])?></td>	
                        </tr>
                    </table>
              </td>	
			</tr>
            <tr><td width="100%">&nbsp;</td></tr>
             <? } ?>
            <tr>
			  <td align="left" class="heading-text-a">>>Board</td>	
			</tr>
            <tr>
			  <td align="left">
              		<?  $boardQuery = "select * from ".TABLE_PERSONAL_BOARD." where personal_id='".$pID."'";
						$boardResult = com_db_query($boardQuery);
					?>
              	  	<table width="100%" cellpadding="2" cellspacing="2" border="0">
                    	<? while($boardRow = com_db_fetch_array($boardResult)){ 
							$bdt = explode('-',$boardRow['board_date']);
							$board_date = $bdt[1].'/'.$bdt[2].'/'.$bdt[0];
						?>
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Board Info</td>
                          <td width="75%" align="left" valign="top"><?=com_db_output($boardRow['board_info'])?></td>	
                        </tr>
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Date:</td>
                          <td width="75%" align="left" valign="top"><?=$board_date?></td>	
                        </tr>
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Link</td>
                          <td width="75%" align="left" valign="top"><?=com_db_output($boardRow['board_link'])?></td>	
                        </tr>
                        <tr><td colspan="2">&nbsp;</td></tr>
                        <? } ?>
                    </table>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a">>>Speaking</td>	
			</tr>
			<?  $spQuery = "select * from ".TABLE_PERSONAL_SPEAKING." where personal_id='".$pID."'";
                $spResult = com_db_query($spQuery);
                while($spRow = com_db_fetch_array($spResult)){ 
				$edt = explode('-',$spRow['event_date']);
				$event_date = $edt[1].'/'.$edt[2].'/'.$edt[0];
            ?>
            <tr>
			  <td align="left" width="100%">
              	  	<table width="100%" cellpadding="2" cellspacing="2" border="0">
                    	
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Role:</td>
                          <td width="75%" align="left" valign="top"><?=com_db_output($spRow['role'])?></td>	
                        </tr>
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Topic:</td>
                          <td width="75%" align="left" valign="top"><?=com_db_output($spRow['topic'])?></td>	
                        </tr>
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Event:</td>
                          <td width="75%" align="left" valign="top"><?=com_db_output($spRow['event'])?></td>	
                        </tr>
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Date:</td>
                          <td width="75%" align="left" valign="top"><?=$event_date?></td>	
                        </tr>
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Link:</td>
                          <td width="75%" align="left" valign="top"><?=com_db_output($spRow['speaking_link'])?></td>	
                        </tr>
                    </table>
              </td>	
			</tr>
            <tr><td width="100%">&nbsp;</td></tr>
             <? } ?>
            <tr>
			  <td align="left" class="heading-text-a">>>Media Mention</td>	
			</tr>
            <?  $mmQuery = "select * from ".TABLE_PERSONAL_MEDIA_MENTION." where personal_id='".$pID."'";
                $mmResult = com_db_query($mmQuery);
                while($mmRow = com_db_fetch_array($mmResult)){ 
				$pdt = explode('-',$mmRow['pub_date']);
				$pub_date = $pdt[1].'/'.$pdt[2].'/'.$pdt[0];
            ?>
            <tr>
			  <td align="left" width="100%">
              	  	<table width="100%" cellpadding="2" cellspacing="2" border="0">
                    	
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Date:</td>
                          <td width="75%" align="left" valign="top"><?=$pub_date?></td>	
                        </tr>
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Publication:</td>
                          <td width="75%" align="left" valign="top"><?=com_db_output($mmRow['publication'])?></td>	
                        </tr>
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Event:</td>
                          <td width="75%" align="left" valign="top"><?=com_db_output($mmRow['quote'])?></td>	
                        </tr>
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Link:</td>
                          <td width="75%" align="left" valign="top"><?=com_db_output($mmRow['media_link'])?></td>	
                        </tr>
                    </table>
              </td>	
			</tr>
            <tr><td width="100%">&nbsp;</td></tr>
             <? } ?>
            <tr>
			  <td align="left" class="heading-text-a">>>Publication</td>	
			</tr>
           <?  $pubQuery = "select * from ".TABLE_PERSONAL_PUBLICATION ." where personal_id='".$pID."'";
                $pubResult = com_db_query($pubQuery);
                while($pubRow = com_db_fetch_array($pubResult)){ 
					$pdt = explode('-',$pubRow['publication_date']);
					$publication_date = $pdt[1].'/'.$pdt[2].'/'.$pdt[0];
            ?>
            <tr>
			  <td align="left" width="100%">
              	  	<table width="100%" cellpadding="2" cellspacing="2" border="0">
                    	
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Title:</td>
                          <td width="75%" align="left" valign="top"><?=com_db_output($pubRow['title'])?></td>	
                        </tr>
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Date:</td>
                          <td width="75%" align="left" valign="top"><?=$publication_date?></td>	
                        </tr>
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Link:</td>
                          <td width="75%" align="left" valign="top"><?=com_db_output($pubRow['link'])?></td>	
                        </tr>
                    </table>
              </td>	
			</tr>
            <tr><td width="100%">&nbsp;</td></tr>
             <? } ?>
             <tr>
            	<td align="center">
                	<table width="50%" border="0" cellpadding="4" cellspacing="4">
                    	<tr><td><input type="button" class="submitButton" value="Back" onclick="window.location='personal.php?p=<?=$p;?>&selected_menu=personal'" /></td></tr>
                    </table>
                </td>
             </tr>
            </table>
            </td>
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
