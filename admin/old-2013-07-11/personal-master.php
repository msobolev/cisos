<?php
require('includes/include_top.php');

$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 20;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';

if($action == 'PersonalSearchResult'){
	
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
	$_SESSION['sess_admin_search_query'] = $sql_query;
}elseif($action=='AdvSearch'){
	$sql_query = $_SESSION['sess_admin_search_query'];
}else{
	$sql_query = "select pm.personal_id,pm.first_name,pm.middle_name,pm.last_name,pm.email,pm.phone,pm.status,pm.add_date from " . TABLE_PERSONAL_MASTER . " as pm order by pm.personal_id desc";
}
/***************** FOR PAGIN ***********************/
$starting_point = $items_per_page * ($p - 1);
/****************** END PAGIN ***********************/
$main_page = 'personal-master.php';

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
			com_db_query("delete from " . TABLE_PERSONAL_AWARDS . " where personal_id = '" . $pID . "'");
			com_db_query("delete from " . TABLE_PERSONAL_BOARD . " where personal_id = '" . $pID . "'");
			com_db_query("delete from " . TABLE_PERSONAL_MEDIA_MENTION . " where personal_id = '" . $pID . "'");
			com_db_query("delete from " . TABLE_PERSONAL_PUBLICATION . " where personal_id = '" . $pID . "'");
			com_db_query("delete from " . TABLE_PERSONAL_SPEAKING . " where personal_id = '" . $pID . "'");
		 	com_redirect("personal-master.php?p=" . $p . "&selected_menu=personal&msg=" . msg_encode("Personal Information deleted successfully"));
		
		break;
		
	  case 'alldelete':
	   		$personal_id = $_POST['nid'];
			for($i=0; $i< sizeof($personal_id) ; $i++){
				com_db_query("delete from " . TABLE_PERSONAL_MASTER . " where personal_id = '" . $personal_id[$i] . "'");
				com_db_query("delete from " . TABLE_PERSONAL_AWARDS . " where personal_id = '" . $personal_id[$i] . "'");
				com_db_query("delete from " . TABLE_PERSONAL_BOARD . " where personal_id = '" . $personal_id[$i] . "'");
				com_db_query("delete from " . TABLE_PERSONAL_MEDIA_MENTION . " where personal_id = '" . $personal_id[$i] . "'");
				com_db_query("delete from " . TABLE_PERSONAL_PUBLICATION . " where personal_id = '" . $personal_id[$i] . "'");
				com_db_query("delete from " . TABLE_PERSONAL_SPEAKING . " where personal_id = '" . $personal_id[$i] . "'");
			}
		 	com_redirect("personal-master.php?p=" . $p . "&selected_menu=personal&msg=" . msg_encode("Personal Information deleted successfully"));
		
		break;
			
		/* case 'jobdelete':
			$job_id = $_REQUEST['cjID'];
			com_db_query("delete from " . TABLE_COMPANY_JOB_INFO . " where personal_id = '" . $pID . "' and job_id='".$job_id."'");
		 	com_redirect("personal-master.php?selected_menu=personal&action=detailes&pID=".$pID);
		
		break;	*/
		
	  case 'edit':
     		
	   		$query_edit=com_db_query("select * from " . TABLE_PERSONAL_MASTER . " where personal_id = '" . $pID . "'");
	  		$data_edit=com_db_fetch_array($query_edit);
			
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
			$about_person = com_db_output($data_edit['about_person']);
			$personal = com_db_output($data_edit['personal']);
			$edu_ugrad_degree = com_db_output($data_edit['edu_ugrad_degree']);
			$edu_ugrad_specialization = com_db_output($data_edit['edu_ugrad_specialization']); 
			$edu_ugrad_college = com_db_output($data_edit['edu_ugrad_college']);
			$edu_ugrad_year = com_db_output($data_edit['edu_ugrad_year']);
			$edu_grad_degree = com_db_output($data_edit['edu_grad_degree']);
			$edu_grad_specialization = com_db_output($data_edit['edu_grad_specialization']); 
			$edu_grad_college = com_db_output($data_edit['edu_grad_college']);
			$edu_grad_year = com_db_output($data_edit['edu_grad_year']);
			
			/*$awards_title  = com_db_output($data_edit['awards_title']);
			$awards_given_by  = com_db_output($data_edit['awards_given_by']);
			$adt = explode('-',$data_edit['awards_date']);
			$awards_date = 	$adt[1].'/'.$adt[2].'/'.$adt[0];*/
			
		break;	
		
		case 'editsave':
			$first_name = com_db_input($_POST['first_name']);
			$middle_name = com_db_input($_POST['middle_name']);
			$last_name = com_db_input($_POST['last_name']);
			$email = com_db_input($_POST['email']);
			$phone = com_db_input($_POST['phone']);
			$lin_url = com_db_input($_POST['lin_url']);
			
			$facebook_link = com_db_input($_POST['facebook_link']);
			$linkedin_link = com_db_input($_POST['linkedin_link']);
			$twitter_link = com_db_input($_POST['twitter_link']);
			$googleplush_link = com_db_input($_POST['googleplush_link']);
			
			$about_person = com_db_input($_POST['about_person']);
			$personal = com_db_input($_POST['personal']);
			
			$edu_ugrad_degree = com_db_input($_POST['edu_ugrad_degree']);
			$edu_ugrad_specialization = com_db_input($_POST['edu_ugrad_specialization']);
			$edu_ugrad_college = com_db_input($_POST['edu_ugrad_college']);
			$edu_ugrad_year = com_db_input($_POST['edu_ugrad_year']);
			$edu_grad_degree = com_db_input($_POST['edu_grad_degree']);
			$edu_grad_specialization = com_db_input($_POST['edu_grad_specialization']);
			$edu_grad_college = com_db_input($_POST['edu_grad_college']);
			$edu_grad_year = com_db_input($_POST['edu_grad_year']);
			
			/*$awards_title = com_db_output($_POST['awards_title']);
			$awards_given_by = com_db_output($_POST['awards_given_by']); 
			$adt = explode('/',$_POST['awards_date']);//mmddyyyy
			$awards_date = $adt[2].'-'.$adt[0].'-'.$adt[1];*/
			$modify_date = date('Y-m-d');
			$login_id = $_SESSION['login_id'];
			$create_by = $_SESSION['login_access_type'];
			// company_id='".$company_id."',title = '".$title."', contact_url ='".$contact_url."',
			$query = "update " . TABLE_PERSONAL_MASTER . " set first_name = '" . $first_name ."', middle_name = '".$middle_name."', last_name = '".$last_name."', email = '".$email."', phone = '".$phone."',
			lin_url = '".$lin_url."', facebook_link = '" . $facebook_link ."', linkedin_link='".$linkedin_link."', twitter_link = '".$twitter_link."', googleplush_link = '".$googleplush_link."', about_person = '".$about_person."', 
			personal = '".$personal."', edu_ugrad_degree = '".$edu_ugrad_degree."', edu_ugrad_specialization = '".$edu_ugrad_specialization."', edu_ugrad_college = '".$edu_ugrad_college."', edu_ugrad_year = '".$edu_ugrad_year."',
			edu_grad_degree = '".$edu_grad_degree."', edu_grad_specialization = '".$edu_grad_specialization."', edu_grad_college = '".$edu_grad_college."', edu_grad_year = '".$edu_grad_year."',
			modify_date = '".$modify_date."',create_by='".$create_by."',admin_id='".$login_id."' where personal_id = '" . $pID . "'";
			com_db_query($query);
			
			$insert_id = $pID;
			$image = $_FILES['image']['tmp_name'];
			  
			if($image!=''){
				if(is_uploaded_file($image)){
					$org_img = $_FILES['image']['name'];
					$exp_file = explode("." , $org_img);
					$get_ext = $exp_file[count($exp_file) - 1];
					if(strtolower($get_ext)=="jpg" || strtolower($get_ext)=="gif" || strtolower($get_ext)=="jpeg" || strtolower($get_ext)=="png"){
						$org_image_name=$exp_file[0].'-'.time().'.'.$get_ext;
						$destination_image = '../personal_photo/org/' . $org_image_name;
						if(move_uploaded_file($image , $destination_image)){
							/*$org_size=getimagesize($destination_image);
							$width=$org_size[0];
							if($width > 200) {
								$t_width=200;
								$ex_width=$org_size[0]-200;	
								$per_width=$ex_width/$org_size[0]*100;
								$height=$org_size[1];
								$ex_heaight=$height/100*$per_width;
								$t_heaight=$height-$ex_heaight;
							} else {
								$t_width=$org_size[0];
								$t_heaight=$org_size[1];
							}*/
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
			
			//Awards insert
			$awards_title_arr = $_POST['awards_title'];
			$awards_given_by_arr = $_POST['awards_given_by'];
			$awards_date_arr = $_POST['awards_date'];
			
			com_db_query("delete from ".TABLE_PERSONAL_AWARDS." where personal_id='".$pID."'");
			for($j=0; $j<sizeof($awards_title_arr);$j++){
				$awards_title 	= $awards_title_arr[$j];
				$awards_given_by 	= $awards_given_by_arr[$j];
				$awards_date 	= $awards_date_arr[$j];
				$adt = explode('/',$awards_date);//mmddyyyy
				$awards_date = $adt[2].'-'.$adt[0].'-'.$adt[1];
				
				$status = '0';
				$add_date = date('Y-m-d');
				if($awards_title !=''){
					$query = "insert into " . TABLE_PERSONAL_AWARDS . "
					(personal_id, awards_title,awards_given_by,awards_date,add_date, status) 
					values ('$insert_id', '$awards_title','$awards_given_by','$awards_date','$add_date','$status')";
					com_db_query($query);
				}
			}
			
			//Board insert
			$board_info_arr = $_POST['board_info'];
			com_db_query("delete from ".TABLE_PERSONAL_BOARD." where personal_id='".$pID."'");
			for($j=0; $j<sizeof($board_info_arr);$j++){
				$board_info 	= $board_info_arr[$j];
				$status = '0';
				$add_date = date('Y-m-d');
				if($board_info !=''){
					$query = "insert into " . TABLE_PERSONAL_BOARD . "
					(personal_id, board_info, add_date, status) 
					values ('$insert_id', '$board_info','$add_date','$status')";
					com_db_query($query);
				}
			}
			
			//Speaking insert
			$role_arr = $_POST['role'];
			$topic_arr = $_POST['topic'];
			$event_arr = $_POST['event'];
			$event_date_arr = $_POST['event_date'];
			com_db_query("delete from ".TABLE_PERSONAL_SPEAKING." where personal_id='".$pID."'");
			for($j=0; $j<sizeof($role_arr);$j++){
				$role 	= $role_arr[$j];
				$topic	= $topic_arr[$j];
				$event	= $event_arr[$j];
				$edt_date 	= explode('/',$event_date_arr[$j]);//mmddyyyy
				$event_date 	= $edt_date[2].'-'.$edt_date[0].'-'.$edt_date[1];
				$status = '0';
				$add_date = date('Y-m-d');
				if($role !=''){
					$query = "insert into " . TABLE_PERSONAL_SPEAKING . "
					(personal_id, role, topic, event, event_date, add_date, status) 
					values ('$insert_id', '$role', '$topic', '$event', '$event_date','$add_date','$status')";
					com_db_query($query);
				}
			}
			
			//Media Mention insert
			$publication_arr = $_POST['publication'];
			$quote_arr = $_POST['quote'];
			$pub_date_arr = $_POST['pub_date'];
			com_db_query("delete from ".TABLE_PERSONAL_MEDIA_MENTION." where personal_id='".$pID."'");
			for($j=0; $j<sizeof($publication_arr);$j++){
				$publication 	= $publication_arr[$j];
				$quote 	= $quote_arr[$j];
				$pdt_date 	= explode('/',$pub_date_arr[$j]);//mmddyyyy
				$pub_date 	= $pdt_date[2].'-'.$pdt_date[0].'-'.$pdt_date[1];
				$status = '0';
				$add_date = date('Y-m-d');
				if($publication !=''){
					$query = "insert into " . TABLE_PERSONAL_MEDIA_MENTION . "
					(personal_id, publication, quote, pub_date, add_date, status) 
					values ('$insert_id', '$publication', '$quote', '$pub_date','$add_date','$status')";
					com_db_query($query);
				}
			}
			
			//Publication insert
			$title_arr = $_POST['pub_title'];
			$link_arr = $_POST['pub_link'];
			com_db_query("delete from ".TABLE_PERSONAL_PUBLICATION." where personal_id='".$pID."'");
			for($j=0; $j<sizeof($title_arr);$j++){
				$title 	= $title_arr[$j];
				$link 	= $link_arr[$j];
				$status = '0';
				$add_date = date('Y-m-d');
				if($title !=''){
					$query = "insert into " . TABLE_PERSONAL_PUBLICATION . "
					(personal_id, title, link, add_date, status) 
					values ('$insert_id', '$title', '$link','$add_date','$status')";
					com_db_query($query);
				}
			}
			
	  		com_redirect("personal-master.php?p=". $p ."&pID=" . $pID . "&selected_menu=personal&msg=" . msg_encode("Personal info update successfully"));
		 
		break;		
		
	  
		
	case 'addsave':
			$first_name = com_db_input($_POST['first_name']);
			$middle_name = com_db_input($_POST['middle_name']);
			$last_name = com_db_input($_POST['last_name']);
			$email = com_db_input($_POST['email']);
			$phone = com_db_input($_POST['phone']);
			$lin_url = com_db_input($_POST['lin_url']);
			
			$facebook_link = com_db_input($_POST['facebook_link']);
			$linkedin_link = com_db_input($_POST['linkedin_link']);
			$twitter_link = com_db_input($_POST['twitter_link']);
			$googleplush_link = com_db_input($_POST['googleplush_link']);
			
			$about_person = com_db_input($_POST['about_person']);
			$personal = com_db_input($_POST['personal']);
			
			$edu_ugrad_degree = com_db_input($_POST['edu_ugrad_degree']);
			$edu_ugrad_specialization = com_db_input($_POST['edu_ugrad_specialization']);
			$edu_ugrad_college = com_db_input($_POST['edu_ugrad_college']);
			$edu_ugrad_year = com_db_input($_POST['edu_ugrad_year']);
			$edu_grad_degree = com_db_input($_POST['edu_grad_degree']);
			$edu_grad_specialization = com_db_input($_POST['edu_grad_specialization']);
			$edu_grad_college = com_db_input($_POST['edu_grad_college']);
			$edu_grad_year = com_db_input($_POST['edu_grad_year']);
			
			/*$awards_title = com_db_output($_POST['awards_title']);
			$awards_given_by = com_db_output($_POST['awards_given_by']); 
			$adt = explode('/',$_POST['awards_date']);//mmddyyyy
			$awards_date = $adt[2].'-'.$adt[0].'-'.$adt[1];*/

			$login_id = $_SESSION['login_id'];
			$create_by = $_SESSION['login_access_type'];
			$status = '0';
			$add_date = date('Y-m-d');
			//title, contact_url , company_id//'$title','$contact_url' ,'$company_id',
			$query = "insert into " . TABLE_PERSONAL_MASTER . "
			(first_name, middle_name, last_name, email, phone,lin_url,facebook_link, linkedin_link, twitter_link, googleplush_link, about_person, personal,edu_ugrad_degree, 
			edu_ugrad_specialization, edu_ugrad_college, edu_ugrad_year, edu_grad_degree ,edu_grad_specialization ,edu_grad_college, edu_grad_year,add_date, create_by,admin_id, status) 
			values ('$first_name','$middle_name','$last_name','$email','$phone','$lin_url','$facebook_link','$linkedin_link','$twitter_link','$googleplush_link','$about_person','$personal','$edu_ugrad_degree',
			'$edu_ugrad_specialization','$edu_ugrad_college','$edu_ugrad_year','$edu_grad_degree','$edu_grad_specialization','$edu_grad_college','$edu_grad_year','$add_date','$create_by','$login_id','$status')";
			com_db_query($query);
			
			$insert_id = com_db_insert_id();
			$image = $_FILES['image']['tmp_name'];
			  
			if($image!=''){
				if(is_uploaded_file($image)){
					$org_img = $_FILES['image']['name'];
					$exp_file = explode("." , $org_img);
					$get_ext = $exp_file[count($exp_file) - 1];
					if(strtolower($get_ext)=="jpg" || strtolower($get_ext)=="gif" || strtolower($get_ext)=="jpeg" || strtolower($get_ext)=="png"){
						$org_image_name=$exp_file[0].'-'.time().'.'.$get_ext;
						$destination_image = '../personal_photo/org/' . $org_image_name;
						if(move_uploaded_file($image , $destination_image)){
							/*$org_size=getimagesize($destination_image);
							$width=$org_size[0];
							if($width > 193) {
								$t_width=193;
								$ex_width=$org_size[0]-193;	
								$per_width=$ex_width/$org_size[0]*100;
								$height=$org_size[1];
								$ex_heaight=$height/100*$per_width;
								$t_heaight=$height-$ex_heaight;
							} else {
								$t_width=$org_size[0];
								$t_heaight=$org_size[1];
							}*/
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
		 //Awards insert
			$awards_title_arr = $_POST['awards_title'];
			$awards_given_by_arr = $_POST['awards_given_by'];
			$awards_date_arr = $_POST['awards_date'];
			
			for($j=0; $j<sizeof($awards_title_arr);$j++){
				$awards_title 	= $awards_title_arr[$j];
				$awards_given_by 	= $awards_given_by_arr[$j];
				$awards_date 	= $awards_date_arr[$j];
				$adt = explode('/',$awards_date);//mmddyyyy
				$awards_date = $adt[2].'-'.$adt[0].'-'.$adt[1];
				
				$status = '0';
				$add_date = date('Y-m-d');
				if($awards_title !=''){
					$query = "insert into " . TABLE_PERSONAL_AWARDS . "
					(personal_id, awards_title,awards_given_by,awards_date,add_date, status) 
					values ('$insert_id', '$awards_title','$awards_given_by','$awards_date','$add_date','$status')";
					com_db_query($query);
				}
			}
			//Board insert
			$board_info_arr = $_POST['board_info'];
			
			for($j=0; $j<sizeof($board_info_arr);$j++){
				$board_info 	= $board_info_arr[$j];
				$status = '0';
				$add_date = date('Y-m-d');
				if($board_info !=''){
					$query = "insert into " . TABLE_PERSONAL_BOARD . "
					(personal_id, board_info, add_date, status) 
					values ('$insert_id', '$board_info','$add_date','$status')";
					com_db_query($query);
				}
			}
			
			//Speaking insert
			$role_arr = $_POST['role'];
			$topic_arr = $_POST['topic'];
			$event_arr = $_POST['event'];
			$event_date_arr = $_POST['event_date'];
			for($j=0; $j<sizeof($role_arr);$j++){
				$role 	= $role_arr[$j];
				$topic	= $topic_arr[$j];
				$event	= $event_arr[$j];
				$edt_date 	= explode('/',$event_date_arr[$j]);//mmddyyyy
				$event_date 	= $edt_date[2].'-'.$edt_date[0].'-'.$edt_date[1];
				$status = '0';
				$add_date = date('Y-m-d');
				if($role !=''){
					$query = "insert into " . TABLE_PERSONAL_SPEAKING . "
					(personal_id, role, topic, event, event_date, add_date, status) 
					values ('$insert_id', '$role', '$topic', '$event', '$event_date','$add_date','$status')";
					com_db_query($query);
				}
			}
			
			//Media Mention insert
			$publication_arr = $_POST['publication'];
			$quote_arr = $_POST['quote'];
			$pub_date_arr = $_POST['pub_date'];
			for($j=0; $j<sizeof($publication_arr);$j++){
				$publication 	= $publication_arr[$j];
				$quote 	= $quote_arr[$j];
				$pdt_date 	= explode('/',$pub_date_arr[$j]);//mmddyyyy
				$pub_date 	= $pdt_date[2].'-'.$pdt_date[0].'-'.$pdt_date[1];
				$status = '0';
				$add_date = date('Y-m-d');
				if($publication !=''){
					$query = "insert into " . TABLE_PERSONAL_MEDIA_MENTION . "
					(personal_id, publication, quote, pub_date, add_date, status) 
					values ('$insert_id', '$publication', '$quote', '$pub_date','$add_date','$status')";
					com_db_query($query);
				}
			}
			
			//Publication insert
			$title_arr = $_POST['pub_title'];
			$link_arr = $_POST['pub_link'];
			for($j=0; $j<sizeof($title_arr);$j++){
				$title 	= $title_arr[$j];
				$link 	= $link_arr[$j];
				$status = '0';
				$add_date = date('Y-m-d');
				if($title !=''){
					$query = "insert into " . TABLE_PERSONAL_PUBLICATION . "
					(personal_id, title, link, add_date, status) 
					values ('$insert_id', '$title', '$link','$add_date','$status')";
					com_db_query($query);
				}
			}
	  		com_redirect("personal-master.php?p=" . $p . "&selected_menu=personal&msg=" . msg_encode("New Person added successfully"));
		 
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
			$about_person = com_db_output($data_edit['about_person']);
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
			
		break;	
	case 'activate':
     		
	   		$status=$_GET['status'];
			if($status==0){
				$query = "update " . TABLE_PERSONAL_MASTER . " set status = '1' where personal_id = '" . $pID . "'";
			}else{
				$query = "update " . TABLE_PERSONAL_MASTER . " set status = '0' where personal_id = '" . $pID . "'";
			}	
			com_db_query($query);
	  		com_redirect("personal-master.php?p=". $p ."&pID=" . $pID . "&selected_menu=personal&msg=" . msg_encode("Personal update successfully"));
			
		break;
				
    }
	


include("includes/header.php");
?>
<style>
	.MsgShowText{
		font-family:Arial;
		font-size:12px;
		color:#900;
		font-weight:bold;
	}
</style>
<script type="text/javascript">
function confirm_del(nid,p){
	var agree=confirm("Personal master will be deleted. \n Do you want to continue?");
	if (agree)
		window.location = "personal-master.php?selected_menu=personal&pID=" + nid + "&p=" + p + "&action=delete";
	else
		window.location = "personal-master.php?selected_menu=personal&pID=" + nid + "&p=" + p ;
}

function confirm_job_delete(cid,jid){
	var agree=confirm("Personal master will be deleted. \n Do you want to continue?");
	if (agree)
		window.location = "personal-master.php?selected_menu=personal&pID="+cid+"&cjID=" + jid + "&action=jobdelete";
	else
		window.location = "personal-master.php?selected_menu=personal&pID=" + cid + "&action=detailes";
}

function CheckAll(numRows){
	if(document.getElementById('all').checked){
		for(i=1; i<=numRows; i++){
			var personal_id='personal_id-'+ i;
			document.getElementById(personal_id).checked=true;
		}
	} else {
		for(i=1; i<=numRows; i++){
			var personal_id='personal_id-'+ i;
			document.getElementById(personal_id).checked=false;
		}
	}
}

function AllDelete(numRows){

	var flg=0;
	for(i=1; i<=numRows; i++){
			var personal_id='personal_id-'+ i;
			if(document.getElementById(personal_id).checked){
				flg=1;
			}	
		}
	if(flg==0){
		alert("Please checked atlist one checkbox for delete.");
		document.getElementById('personal_id-1').focus();
		return false;
	} else {
		var agree=confirm("Personal master will be deleted. \n Do you want to continue?");
		if (agree)
			 document.topicform.submit();
		else
			window.location = "personal-master.php?selected_menu=personal";
	}	

}

function confirm_artivate(nid,p,status){
	if(status=='1'){
		var msg="Personal master will be active. \n Do you want to continue?";
	}else{
		var msg="Personal master will be Inactive. \n Do you want to continue?";
	}
	var agree=confirm(msg);
	if (agree)
		window.location = "personal-master.php?selected_menu=personal&pID=" + nid + "&p=" + p + "&status=" + status + "&action=activate";
	else
		window.location = "personal-master.php?selected_menu=personal&pID=" + nid + "&p=" + p ;
}

function PersonalSearch(){
	window.location ='personal-master.php?action=PersonalSearch&selected_menu=personal';
}
function Download_XLS(personal_id){
	window.location ="singal-personal-download-xls.php?personal_id="+personal_id;
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
  newdiv.innerHTML = "<table border='0' width='100%' cellpadding='2' cellspacing='2'><tr><td width='25%' class='page-text'>Awards Title:</td><td width='75%'><input type='text' name='awards_title[]'></td></tr><tr><td class='page-text'>Awards Given By:</td><td><input type='text' name='awards_given_by[]' value=''></td></tr><tr><td class='page-text'>Awards Date:</td><td><input type='text' name='awards_date[]' id=" + pdt + " value=''>&nbsp;<a href=\"javascript:NewCssCal('"+pdt+"','mmddyyyy','arrow')\"><img src=\"images/calender-icon.gif\" alt='' width='22' height='14' border='0'/></a></td></tr><tr><td>&nbsp;</td><td><a href=\"javascript:;\" onclick=\"removeElementAwards(\'"+divIdName+"\')\">Remove the above Awards?</a></td></tr></table>";
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
  var pdt = 'post_date'+num;
  newdiv.setAttribute("id",divIdName);
  newdiv.innerHTML = "<table border='0' width='100%' cellpadding='2' cellspacing='2'><tr><td width='25%' class='page-text'>Board Info:</td><td width='75%'><input type='text' name='board_info[]'></td></tr><tr><td>&nbsp;</td><td><a href=\"javascript:;\" onclick=\"removeElementBoard(\'"+divIdName+"\')\">Remove the above Board?</a></td></tr></table>";
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
  newdiv.innerHTML = "<table border='0' width='100%' cellpadding='2' cellspacing='2'><tr><td width='25%' class='page-text'>Role:</td><td width='75%'><input type='text' name='role[]'></td></tr><tr><td class='page-text'>Topic:</td><td><input type='text' name='topic[]' value=''></td></tr><tr><td valign='top' class='page-text'>Event:</td><td><input type='text' name='event[]' ></td></tr><tr><td class='page-text'>Date:</td><td><input type='text' name='event_date[]' id=" + pdt + " value=''>&nbsp;<a href=\"javascript:NewCssCal('"+pdt+"','mmddyyyy','arrow')\"><img src=\"images/calender-icon.gif\" alt='' width='22' height='14' border='0'/></a></td></tr><tr><td>&nbsp;</td><td><a href=\"javascript:;\" onclick=\"removeElementSpeaking(\'"+divIdName+"\')\">Remove the above speaking?</a></td></tr></table>";
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
  newdiv.innerHTML = "<table border='0' width='100%' cellpadding='2' cellspacing='2'><tr><td class='page-text'>Date:</td><td><input type='text' name='pub_date[]' id=" + pdt + " value=''>&nbsp;<a href=\"javascript:NewCssCal('"+pdt+"','mmddyyyy','arrow')\"><img src=\"images/calender-icon.gif\" alt='' width='22' height='14' border='0'/></a></td></tr><tr><td width='25%' class='page-text'>Publication:</td><td width='75%'><input type='text' name='publication[]'></td></tr><tr><td class='page-text'>Quote:</td><td><input type='text' name='quote[]' value=''></td></tr><tr><td>&nbsp;</td><td><a href=\"javascript:;\" onclick=\"removeElementMedia(\'"+divIdName+"\')\">Remove the above Media?</a></td></tr></table>";
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
  newdiv.setAttribute("id",divIdName);
  newdiv.innerHTML = "<table border='0' width='100%' cellpadding='2' cellspacing='2'><tr><td width='25%' class='page-text'>Title:</td><td width='75%'><input type='text' name='pub_title[]'></td></tr><tr><td class='page-text'>Link:</td><td><input type='text' name='pub_link[]' value=''></td></tr><tr><td>&nbsp;</td><td><a href=\"javascript:;\" onclick=\"removeElementPublication(\'"+divIdName+"\')\">Remove the above Publication?</a></td></tr></table>";
  ni.appendChild(newdiv);
}

function removeElementPublication(divNum) {
  var d = document.getElementById('myDivPublication');
  var olddiv = document.getElementById(divNum);
  d.removeChild(olddiv);
}
</script>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>

<script type="text/javascript" language="javascript" src="selectuser.js"></script>

 <tr>
    <td align="left" valign="top" bgcolor="#FFFFFF">
	
	<div id="light" class="white_content" style="display:<? if($action=='PersonalSearch'){ echo 'block';} else { echo 'none'; } ?>;">
		<div id="spiffycalendar" class="text"></div>
		<link rel="stylesheet" type="text/css" href="includes/javascript/spiffyCal/spiffyCal_v2_1.css">
		<script language="JavaScript" src="includes/javascript/spiffyCal/spiffyCal_v2_1.js"></script>
		<script language="javascript"><!--
		  var dateAvailableFrom = new ctlSpiffyCalendarBox("dateAvailableFrom", "frmSearch", "from_date","btnDate1","",scBTNMODE_CUSTOMBLUE);
		  var dateAvailableTo = new ctlSpiffyCalendarBox("dateAvailableTo", "frmSearch", "to_date","btnDate2","",scBTNMODE_CUSTOMBLUE);	
		//--></script>
		<form name="frmSearch" id="frmSearch" method="post" action="personal-master.php?selected_menu=personal&action=PersonalSearchResult">
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
		  	<td align="left" valign="top"><input type="submit" value="Search" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="Cancel" onclick="window.location='personal-master.php?selected_menu=personal'" /></td>
		  </tr>
		  <tr>
			<td align="center" valign="top">&nbsp;</td>
			<td align="center" valign="top">&nbsp;</td>
		  </tr>
		</table>
		</form>
	</div>
	<div id="fade" class="black_overlay" style="display:<? if($action=='PersonalSearch'){ echo 'block';} else { echo 'none'; } ?>;"></div>
	
	
	<table width="975" border="0" align="center" cellpadding="0" cellspacing="0">

      <tr>
		<?php
		include("includes/menu_left.php");
		?>
		<td width="10" align="left" valign="top">&nbsp;</td>
        <td width="769" align="left" valign="top">

<?php if(($action == '') || ($action == 'save') || ($action =='PersonalSearch') || $action =='PersonalSearchResult' || $action =='AdvSearch'){	?>			

		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
          <tr>
            <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="19%" align="left" valign="middle" class="heading-text">Personal Manager</td>
                  <td width="51%" align="left" valign="middle" class="message"><?=$msg?></td>
				  <td width="3%" align="right" valign="middle"><a href="#"><img src="images/search-icon.jpg" border="0" width="25" height="28"  alt="Search" title="Search"  onclick="PersonalSearch('PersonalSearch');" /></a></td>
				  <td width="6%" align="left" valign="middle" class="nav-text">Search</td>
                  <? if($btnAdd=='Yes'){ ?>
                  <td width="4%" align="right" valign="middle"><a href="#"><img src="images/add-icon.jpg" border="0" width="25" height="28" alt="Add Person" title="Add Person" onclick="window.location='personal-master.php?action=add&selected_menu=personal'"  /></a></td>
                  <td width="7%" align="left" valign="middle" class="nav-text">Add New </td>
                  <? }
				  if($btnDelete=='Yes'){ ?>
                  <td width="4%" align="right" valign="middle"><a href="#"><img src="images/delete-icon.jpg" border="0" width="25" height="28"  alt="Delete Person" title="Delete Person" onclick="AllDelete('<?=$numRows?>');"  /></a></td>
                  <td width="6%" align="left" valign="middle" class="nav-text">Delete</td>
                  <? } ?>
                </tr>
              </table></td>
          </tr>
       
          <tr>
            <td align="left" valign="top" class="right-bar-content-border">
			<form name="topicform" action="personal-master.php?action=alldelete&selected_menu=personal" method="post">
			<table width="100%" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="22" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-title-text">#</span></td>
				<td width="28" height="30" align="center" valign="middle" class="right-border">
				<input type="checkbox" name="all" id="all" onclick="CheckAll('<?=$numRows?>');" /></td>
				<td width="142" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Personal Name</span> </td>
				<td width="168" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Email</span> </td>
                <td width="108" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Phone</span> </td>
                <td width="75" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Add Date</span> </td>
                <td width="224" height="30" align="center" valign="middle" class="left-border"><div align="center"><span class="right-box-title-text">Action</span></div></td>
			  </tr>
			<?php
			
			if($total_data>0) {
				$i=$starting_point+1;
				while ($data_sql = com_db_fetch_array($exe_data)) {
				$add_date = $data_sql['add_date'];
				$status = $data_sql['status'];
			?>          
			  <tr>
				<td height="30" align="center" valign="middle" class="right-border-left"><?=$i;?></td>
				<td height="30" align="center" valign="middle" class="right-border"><input type="checkbox" id="personal_id-<?=$i;?>" name="nid[]" value="<?=$data_sql['personal_id'];?>" /></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><a href="personal-master.php?action=detailes&p=<?=$p?>&selected_menu=personal&pID=<?=$data_sql['personal_id'];?>"><?=com_db_output($data_sql['first_name']).' '.com_db_output($data_sql['last_name'])?></a></td>
                <td height="30" align="left" valign="middle" class="right-border-text"><?=com_db_output($data_sql['email'])?></td>
                <td height="30" align="left" valign="middle" class="right-border-text"><?=com_db_output($data_sql['phone'])?></td>
                <td height="30" align="center" valign="middle" class="right-border"><?=$add_date;?></td>
				<td height="30" align="center" valign="middle" class="left-border">
					<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr> 
					  	<td width="37%" align="center" valign="middle"><a href="#"><img src="images/icon/xls-small-icon.gif" width="16" height="16" alt="" title="" border="0"  onclick="Download_XLS('<?=$data_sql['personal_id'];?>');" /></a><br />
					   	  .xls&nbsp;Download</td>
					  <? if($btnStatus=='Yes'){ 
						 	if($status==0){ ?>
					   	<td width="18%" align="center" valign="middle"><a href="#"><img src="images/icon/active-icon.gif" width="16" height="16" alt="" title="" border="0" onclick="confirm_artivate('<?=$data_sql['personal_id'];?>','<?=$p;?>','<?=$status;?>');" /></a><br />
					   	  Status</td>
					   	<?php } elseif($status==1){ ?>
					   	<td width="16%" align="center" valign="middle"><a href="#"><img src="images/icon/inactive-icon.gif" width="16" height="16" alt="" title="" border="0" onclick="confirm_artivate('<?=$data_sql['personal_id'];?>','<?=$p;?>','<?=$status;?>');" /></a><br />
					   	  Status</td>
						<?php }
					   }
					   if($btnEdit=='Yes'){ ?>
						<td width="12%" align="center" valign="middle"><a href="#"><img src="images/small-edit-icon.gif" width="16" height="16" alt="Edit" title="Edit" border="0" onclick="window.location='personal-master.php?selected_menu=personal&p=<?=$p;?>&pID=<?=$data_sql['personal_id'];?>&action=edit'"/></a><br />
						  Edit</td>
                       <? } 
					   if($btnDelete=='Yes'){ ?>  
						<td width="17%" align="center" valign="middle"><a href="#"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" title="Delete" border="0" onclick="confirm_del('<?=$data_sql['personal_id'];?>','<?=$p;?>')" /></a><br />
						  Delete</td>
                       <? } ?>   
					  </tr>
					</table>				</td>
         	</tr> 
			<?php
			$i++;
				}
			
			}
			?>     
         </table> 
		</form>
		
		
		
		
		</td>
          </tr>
        </table>
</td>
      </tr>
    </table></td>
  </tr>
 <tr>
    <td align="center" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
     
      <tr>
        <td width="666" align="right" valign="top"><table width="200" border="0" align="right" cellpadding="0" cellspacing="0">
          <tr>
		<?php 
		if($action=='PersonalSearchResult' || $action == 'AdvSearch'){
			$extra_feture = '&selected_menu=personal&action=AdvSearch';
		}else{
			$extra_feture = '&selected_menu=personal';
		}
		echo number_pages($main_page, $p, $total_data, 8, $items_per_page,$extra_feture);?>		  
          </tr>
        </table></td>
        <td width="314" align="center" valign="bottom">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  
<?php } elseif($action=='edit'){ ?>	
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

</script>		

		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">Personal Manager :: Edit Personal </td>
				  
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top"  class="right-bar-content-border-box"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="celter" valign="top">
		 <!--start iner table  -->
		 <form name="frmDataEdit" id="frmDataEdit" method="post" enctype="multipart/form-data" action="personal-master.php?action=editsave&selected_menu=personal&pID=<?=$pID;?>&p=<?=$p;?>" onsubmit="return chk_form();">
			<table width="95%" align="center" cellpadding="5" cellspacing="5" border="0">
			
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
                      <td width="75%" align="left" valign="top"><input type="text" name="email" id="email" size="30" value="<?=$email?>" /> </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">Phone:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="phone" id="phone" size="30" value="<?=$phone?>" /> </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">LIN Url:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="lin_url" id="lin_url" size="30" value="<?=$lin_url?>" /> </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">Headshot Photo:</td>
                      <td width="75%" align="left" valign="top"><img src="../personal_photo/small/<?=$personal_image?>" height="80" width="80" /><br /><input type="file" name="image" id="image" /> </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">About Person (bio):</td>
                      <td width="75%" align="left" valign="top"><!--<input type="text" name="about_person" id="about_person" size="30" value="<?//=$about_person?>" />--> 
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
			  <td align="left" class="heading-text-a">>>Awards</td>	
			</tr>
            <tr>
			  <td align="left">
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
                         	<td>&nbsp;</td>
                         	<td><a href="javascript:;" onclick="removeElementBoard('my<?=$awards?>DivAwards')">Remove the above Awards?</a></td></tr>
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
					?>
                    <div id="my<?=$board?>DivBoard">
              		<table width="100%" cellpadding="2" cellspacing="2" border="0">
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Board Info:</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="board_info[]" value="<?=$boardRow['board_info'];?>" /></td>	
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
                          <td width="75%" align="left" valign="top"><input type="text" name="role[]" value="<?=$spRow['role'];?>" /></td>	
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
                          <td width="75%" align="left" valign="top"><input type="text" name="post_date[]" value='<?=com_db_output($mediaRow['publication'])?>' /></td>	
                         </tr>
                         <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Quote:</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="quote[]" value='<?=com_db_output($mediaRow['quote']);?>' /></td>	
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
					?>
                    <div id="my<?=$pub?>DivPublication">
              		<table width="100%" cellpadding="2" cellspacing="2" border="0">
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Title:</td>
                          <td width="75%" align="left" valign="top"><input type="text" name="pub_title[]" value="<?=$pubRow['title'];?>" /></td>	
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
            	<td align="center">
                	<table width="50%" border="0" cellpadding="4" cellspacing="4">
                    	<tr>
                        	<td width="22%"><input type="submit" value="Update Personal" class="submitButton" /></td>
                            <td width="78%"><input type="button" class="submitButton" value="Cancel" onclick="window.location='personal-master.php?p=<?=$p;?>&pID=<?=$pID;?>&selected_menu=personal'" /></td>
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
        </table></td>
          </tr>
        </table>
		
<?php		
} elseif($action=='add'){
?>		
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

</script>
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">Personal Manager :: Add Personal </td>
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="left" valign="top" class="right-border-box">
		 <!--start iner table  -->
		 <form name="DateTest" method="post" enctype="multipart/form-data" action="personal-master.php?action=addsave&selected_menu=personal&pID=<?=$pID;?>&p=<?=$p;?>" onsubmit="return chk_form_Add();">
		  <table width="95%" align="left" cellpadding="5" cellspacing="5" border="0">
			
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
                      <td width="75%" align="left" valign="top"><input type="text" name="last_name" id="last_name" size="30" value="" /> </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">Email:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="email" id="email" size="30" value="" /> </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">Phone:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="phone" id="phone" size="30" value="" /> </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">LIN Url:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="lin_url" id="lin_url" size="30" value="" /> </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">Headshot Photo:</td>
                      <td width="75%" align="left" valign="top"><input type="file" name="image" id="image" /> </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">About Person (bio):</td>
                      <td width="75%" align="left" valign="top"><!--<input type="text" name="about_person" id="about_person" size="30" value="" />--> 
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
            	<td align="center">
                	<table width="50%" border="0" cellpadding="4" cellspacing="4">
                    	<tr><td><input type="submit" value="Add Person" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="Cancel" onclick="window.location='personal-master.php?p=<?=$p;?>&uID=<?=$uID;?>&selected_menu=personal'" /></td></tr>
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
        </table></td>
          </tr>
        </table>		
<?php
} elseif($action=='detailes'){
?>		
  	  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
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
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">Phone:</td>
                      <td width="75%" align="left" valign="top"><?=$phone;?>  </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">LIN Url:</td>
                      <td width="75%" align="left" valign="top"><?=$lin_url;?></td>	
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
                    	<? while($boardRow = com_db_fetch_array($boardResult)){ ?>
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">&nbsp;</td>
                          <td width="75%" align="left" valign="top"><?=com_db_output($boardRow['board_info'])?></td>	
                        </tr>
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
				
            ?>
            <tr>
			  <td align="left" width="100%">
              	  	<table width="100%" cellpadding="2" cellspacing="2" border="0">
                    	
                        <tr>
                          <td width="25%" align="left" class="page-text" valign="top">Title:</td>
                          <td width="75%" align="left" valign="top"><?=com_db_output($pubRow['title'])?></td>	
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
                    	<tr><td><input type="button" class="submitButton" value="Back" onclick="window.location='personal-master.php?p=<?=$p;?>&selected_menu=personal'" /></td></tr>
                    </table>
                </td>
             </tr>
            </table></td>
		 </tr>
        </table></td>
          </tr>
     </table>		
<?php
}
include("includes/footer.php");
?>