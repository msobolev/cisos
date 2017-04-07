<?php
require('includes/include_top.php');
//include('includes/include_editor.php');

//URL CREATE
$fixDate = '2012-03-28';
$url_query = "SELECT * FROM " . TABLE_CONTACT. " WHERE add_date >= '".$fixDate."' and (contact_url='' OR contact_url=NULL)";
//$url_query = "SELECT * FROM " . TABLE_CONTACT. " WHERE contact_url='' OR contact_url=NULL";
$url_result = com_db_query($url_query);
if($url_result){
	while($url_row = com_db_fetch_array($url_result)){
		$url_company_name = trim(com_db_output($url_row['company_name']));
		$url_company_name = str_replace(' ','-',$url_company_name);
		$mmc = com_db_GetValue("select name from ". TABLE_MANAGEMENT_CHANGE. " where id='".$url_row['movement_type']."'");
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
		
		$ntt = com_db_output($url_row['new_title']);
		$ntt = str_replace(' ','-', $ntt);
		
		$contact_url = trim($url_row['first_name']).'-'.trim($url_row['last_name']).'-'.$url_company_name.'-'.$ntt.'-'.$url_mmc;
		
		$contact_url = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '-', ''), $contact_url);
		com_db_query("UPDATE " . TABLE_CONTACT . " SET contact_url = '".com_db_input($contact_url)."' where contact_id='".$url_row['contact_id'] ."'");
	}
}

//For before data

$url_query1 = "SELECT * FROM " . TABLE_CONTACT. " WHERE add_date < '".$fixDate."' and (contact_url='' OR contact_url=NULL)";
//$url_query = "SELECT * FROM " . TABLE_CONTACT. " WHERE contact_url='' OR contact_url=NULL";
$url_result1 = com_db_query($url_query1);
if($url_result1){
	while($url_row = com_db_fetch_array($url_result1)){
		$url_company_name = trim(com_db_output($url_row['company_name']));
		$url_company_name = str_replace(' ','-',$url_company_name);
		$mmc = com_db_GetValue("select name from ". TABLE_MANAGEMENT_CHANGE. " where id='".$url_row['movement_type']."'");
		$mmc1 = strtoupper($mmc);
		if($mmc1 == 'APPOINTMENT' || $mmc1 == 'LATERAL MOVE'){
			$url_mmc='Appointed';
		}elseif($mmc1 =='PROMOTION'){
			$url_mmc='Promoted-to';
		}elseif($mmc1 =='RETIREMENT'){
			$url_mmc='Retired-as';
		}elseif($mmc1 =='RESIGNATION'){
			$url_mmc='Resigned-as';
		}elseif($mmc1 =='TERMINATION'){
			$url_mmc='was-terminated-as';
		}else{
			$url_mmc='Job-Opening';
		}		
		
		$ntt = com_db_output($url_row['new_title']);
		$ntt = str_replace(' ','-', $ntt);
		
		if($mmc1 =='RETIREMENT'){
			$contact_url = trim($url_row['first_name']).'-'.trim($url_row['last_name']).'-'.$url_mmc.'-'.$ntt.'-from-'. $url_company_name;
		}else{
			$contact_url = trim($url_row['first_name']).'-'.trim($url_row['last_name']).'-'.$url_mmc.'-'.$ntt.'-at-'. $url_company_name;
		}
		
		$contact_url = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '-', ''), $contact_url);
		com_db_query("UPDATE " . TABLE_CONTACT . " SET contact_url = '".com_db_input($contact_url)."' where contact_id='".$url_row['contact_id'] ."'");
	}
}



$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 20;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';

if($action == 'ContactSearchResult'){
	$first_name		= $_POST['first_name'];
	$last_name		= $_POST['last_name'];
	$title			= $_POST['title'];
	$company		= $_POST['company'];
	$industry 		= $_POST['industry'];
	$state			= $_POST['state'];
	$status			= $_POST['status'];
	$from_date		= $_POST['from_date'];
	$to_date 		= $_POST['to_date'];
	$country		= $_POST['country'];
	$movement_type 	= $_POST['movement_type'];
	
	$search_qry='';
	if($first_name!=''){
		$search_qry .= " c.first_name like '".$first_name."%'";
	}
	if($last_name!=''){
		if($search_qry==''){
			$search_qry .= " c.last_name like '".$last_name."%'";
		}else{
			$search_qry .= " and c.last_name like '".$last_name."%'";
		}	
	}
	if($title!=''){
		if($search_qry==''){
			$search_qry .= " c.new_title ='".$title."'";
		}else{
			$search_qry .= " and c.new_title ='".$title."%'";
		}	
	}
	if($company!=''){
		if($search_qry==''){
			$search_qry .= " c.company_name = '".$company."'";
		}else{
			$search_qry .= " and c.company_name = '".$company."'";
		}	
	}
	if($industry!=''){
		if($search_qry==''){
			$search_qry .= " c.company_industry = '".$industry."'";
		}else{
			$search_qry .= " and c.company_industry = '".$industry."'";
		}	
	}
	if($state!=''){
		if($search_qry==''){
			$search_qry .= " c.state = '".$state."'";
		}else{
			$search_qry .= " and c.state = '".$state."'";
		}	
	}
	if($status!=''){
		if($search_qry==''){
			$search_qry .= " c.status = '".$status."'";
		}else{
			$search_qry .= " and c.status = '".$status."'";
		}	
	}
	if($from_date!='' && strlen($from_date)==10 && $to_date !='' && strlen($to_date)==10){
		$fdt = explode('/',$from_date);
		$fdate = $fdt[2].'-'.$fdt[0].'-'.$fdt[1];
		$tdt = explode('/',$to_date);
		$tdate = $tdt[2].'-'.$tdt[0].'-'.$tdt[1];
		/*if($search_qry==''){
			$search_qry .= " c.add_date >= '".$fdate."' and c.add_date <='".$tdate."'";
		}else{
			$search_qry .= " and c.add_date >= '".$fdate."' and c.add_date <='".$tdate."'";
		}	*/
		if($search_qry==''){
			$search_qry .= " c.effective_date >= '".$fdate."' and c.effective_date <='".$tdate."'";
		}else{
			$search_qry .= " and c.effective_date >= '".$fdate."' and c.effective_date <='".$tdate."'";
		}
	}
	if($country!=''){
		if($search_qry==''){
			$search_qry .= " c.country = '".$country."'";
		}else{
			$search_qry .= " and c.country = '".$country."'";
		}	
	}
	if($movement_type!=''){
		if($search_qry==''){
			$search_qry .= " c.movement_type = '".$movement_type."'";
		}else{
			$search_qry .= " and c.movement_type = '".$movement_type."'";
		}	
	}
	
	
	if($search_qry==''){
		$sql_query = "select c.contact_id,c.first_name,c.middle_name,c.last_name,c.company_name,c.effective_date,c.status,c.new_title from " . TABLE_CONTACT . " as c order by c.contact_id desc";
	}else{
		$sql_query = "select c.contact_id,c.first_name,c.middle_name,c.last_name,c.company_name,c.effective_date,c.status,c.new_title from " . TABLE_CONTACT . " as c where  ". $search_qry." order by c.contact_id desc";
	}
	$_SESSION['sess_admin_search_query'] = $sql_query;
}elseif($action=='AdvSearch'){
	$sql_query = $_SESSION['sess_admin_search_query'];
}else{
	$sql_query = "select c.contact_id,c.first_name,c.middle_name,c.last_name,c.company_name,c.effective_date,c.status,c.new_title from " . TABLE_CONTACT . " as c order by c.contact_id desc";
}

/***************** FOR PAGIN ***********************/
$starting_point = $items_per_page * ($p - 1);
/****************** END PAGIN ***********************/
$main_page = 'contact.php';

$exe_query=com_db_query($sql_query);
$num_rows=com_db_num_rows($exe_query);
$total_data = $num_rows;

/************ FOR PAGIN **************/
$sql_query .= " LIMIT $starting_point,$items_per_page";
$exe_data = com_db_query($sql_query);

$numRows = com_db_num_rows($exe_data);
/************ END ********************/


$cID = (isset($_GET['cID']) ? $_GET['cID'] : $select_data[0]);

    switch ($action) {
		
	  case 'delete':
	   		
			com_db_query("delete from " . TABLE_CONTACT . " where contact_id = '" . $cID . "'");
		 	com_redirect("contact.php?p=" . $p . "&selected_menu=contact&msg=" . msg_encode("Contact deleted successfully"));
		
		break;
		
	  case 'alldelete':
	   		$contact_id = $_POST['nid'];
			for($i=0; $i< sizeof($contact_id) ; $i++){
				com_db_query("delete from " . TABLE_CONTACT . " where contact_id = '" . $contact_id[$i] . "'");
			}
		 	com_redirect("contact.php?p=" . $p . "&selected_menu=contact&msg=" . msg_encode("Contact deleted successfully"));
		
		break;	
		
	  case 'edit':
     		
	   		$query_edit=com_db_query("select * from " . TABLE_CONTACT . " where contact_id = '" . $cID . "'");
	  		$data_edit=com_db_fetch_array($query_edit);
			
			$first_name = com_db_output($data_edit['first_name']);
			$middle_name = com_db_output($data_edit['middle_name']);
			$last_name = com_db_output($data_edit['last_name']);
			$new_title = com_db_output($data_edit['new_title']);
			
			$email = com_db_output($data_edit['email']);
			$phone = com_db_output($data_edit['phone']);
			$contact_url = com_db_output($data_edit['contact_url']);
			
			$company_name = com_db_output($data_edit['company_name']);
			$company_website = com_db_output($data_edit['company_website']);
			$company_revenue = com_db_output($data_edit['company_revenue']);
			$company_employee = com_db_output($data_edit['company_employee']);
			$company_industry = com_db_output($data_edit['company_industry']);
			
			$address = com_db_output($data_edit['address']);
			$address2 = com_db_output($data_edit['address2']);
			$city = com_db_output($data_edit['city']);
			$state = com_db_output($data_edit['state']);
			$country = com_db_output($data_edit['country']);
			$zip_code = com_db_output($data_edit['zip_code']);
			
		
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
			$source = com_db_output($data_edit['source']);
			$headline = com_db_output($data_edit['headline']);
			$full_body = preg_replace('/<br( )?(\/)?>/i', "\r", $data_edit['full_body']);
			$short_url = com_db_output($data_edit['short_url']);
			$movement_type = com_db_output($data_edit['movement_type']);
			$what_happened = com_db_output($data_edit['what_happened']);
			$about_person = com_db_output($data_edit['about_person']);
			$about_company = com_db_output($data_edit['about_company']);
			$more_link = com_db_output($data_edit['more_link']);
			$not_current = com_db_output($data_edit['not_current']);
			$new_position = com_db_output($data_edit['new_position']);
			$new_person = com_db_output($data_edit['new_person']);
			$leadership_page = com_db_output($data_edit['leadership_page']);
			$email_pattern = com_db_output($data_edit['email_pattern']); 
			$lin_url = com_db_output($data_edit['lin_url']);
		break;	
		
		case 'editsave':
			
			$first_name = com_db_input($_POST['first_name']);
			$middle_name = com_db_input($_POST['middle_name']);
			$last_name = com_db_input($_POST['last_name']);
			$new_title = com_db_input($_POST['new_title']);
			
			$email = com_db_input($_POST['email']);
			$phone = com_db_input($_POST['phone']);
			$contact_url = com_db_input($_POST['contact_url']);
			
			$company_name = com_db_input($_POST['company_name']);
			$company_website = com_db_input($_POST['company_website']);
			$company_revenue = com_db_input($_POST['company_revenue']);
			$company_employee = com_db_input($_POST['company_employee']);
			$company_industry = com_db_input($_POST['company_industry']);
			$industry_id = $company_industry;//com_db_GetValue("select industry_id from " . TABLE_INDUSTRY . " where title = '".$company_industry."'");
			$ind_group_id = com_db_GetValue("select parent_id from " . TABLE_INDUSTRY . " where industry_id = '".$company_industry."'");
			
			$address = com_db_input($_POST['address']);
			$address2 = com_db_input($_POST['address2']);
			$city = com_db_input($_POST['city']);
			$state = com_db_input($_POST['state']);
			$country = com_db_input($_POST['country']);
			$zip_code = com_db_input($_POST['zip_code']);
			
			$ann_date = explode('/',$_POST['announce_date']);//mmddyyyy
			$announce_date = $ann_date[2].'-'.$ann_date[0].'-'.$ann_date[1];
			$eff_date = explode('/',$_POST['effective_date']);
			$effective_date = $eff_date[2].'-'.$eff_date[0].'-'.$eff_date[1];
			$source = com_db_input($_POST['source']);
			$headline = com_db_input($_POST['headline']);
			$rep   = array("\r\n", "\n","\r");
			$full_body = str_replace($rep,'<br />',$_POST['full_body']);
			$short_url = com_db_input($_POST['short_url']);
			$movement_type = com_db_input($_POST['movement_type']);
			$what_happened = com_db_input($_POST['what_happened']);
			$about_person = com_db_input($_POST['about_person']);
			$about_company = com_db_input($_POST['about_company']);
			$more_link = com_db_input($_POST['more_link']);
			
			$not_current = com_db_input($_POST['not_current']);
			$new_position = com_db_input($_POST['new_position']);
			$new_person = com_db_input($_POST['new_person']);
			
			$leadership_page = com_db_output($_POST['leadership_page']);
			$email_pattern = com_db_output($_POST['email_pattern']); 
			$lin_url = com_db_output($_POST['lin_url']);
			$status_active = $_POST['status_active'];
			$modify_date = date('Y-m-d');
			if($status_active =='1' ){
				$query = "update " . TABLE_CONTACT . " set first_name = '" . $first_name . "', middle_name ='".$middle_name."', last_name = '" . $last_name . "', new_title = '" . $new_title . "', email = '".$email."', phone = '".$phone."', 
				contact_url = '".$contact_url."', lin_url='".$lin_url."', company_name = '" . $company_name ."', company_website = '".$company_website."', company_revenue = '".$company_revenue."', company_employee = '".$company_employee."', company_industry = '".$company_industry."',  ind_group_id = '".$ind_group_id."', industry_id = '".$industry_id."',
				leadership_page ='".$leadership_page."',email_pattern = '".$email_pattern."', address = '" . $address ."', address2 = '".$address2."', city = '".$city."', state = '".$state."', country = '".$country."', zip_code = '".$zip_code."',
				announce_date = '" . $announce_date ."', effective_date = '".$effective_date."', source = '".$source."', headline = '".$headline."', full_body = '".$full_body."', short_url = '".$short_url."',
				movement_type = '" . $movement_type ."', what_happened = '".$what_happened."', about_person = '".$about_person."', about_company = '".$about_company."', more_link = '".$more_link."', not_current ='".$not_current."', new_position='".$new_position."', new_person='".$new_person."',
				modify_date = '".$modify_date."', status='0'  where contact_id = '" . $cID . "'";
			}else{
				$query = "update " . TABLE_CONTACT . " set first_name = '" . $first_name . "', middle_name ='".$middle_name."', last_name = '" . $last_name . "', new_title = '" . $new_title . "', email = '".$email."', phone = '".$phone."', 
				contact_url = '".$contact_url."', lin_url='".$lin_url."', company_name = '" . $company_name ."', company_website = '".$company_website."', company_revenue = '".$company_revenue."', company_employee = '".$company_employee."', company_industry = '".$company_industry."',  ind_group_id = '".$ind_group_id."', industry_id = '".$industry_id."',
				leadership_page ='".$leadership_page."',email_pattern = '".$email_pattern."', address = '" . $address ."', address2 = '".$address2."', city = '".$city."', state = '".$state."', country = '".$country."', zip_code = '".$zip_code."',
				announce_date = '" . $announce_date ."', effective_date = '".$effective_date."', source = '".$source."', headline = '".$headline."', full_body = '".$full_body."', short_url = '".$short_url."',
				movement_type = '" . $movement_type ."', what_happened = '".$what_happened."', about_person = '".$about_person."', about_company = '".$about_company."', more_link = '".$more_link."', not_current ='".$not_current."', new_position='".$new_position."', new_person='".$new_person."',
				modify_date = '".$modify_date."'  where contact_id = '" . $cID . "'";
			}
			com_db_query($query);
	  		com_redirect("contact.php?p=". $p ."&cID=" . $cID . "&selected_menu=contact&msg=" . msg_encode("Contact update successfully"));
		 
		break;		
		
	  
		
	case 'addsave':
			
			$first_name = com_db_input($_POST['first_name']);
			$middle_name = com_db_input($_POST['middle_name']);
			$last_name = com_db_input($_POST['last_name']);
			$new_title = com_db_input($_POST['new_title']);
			
			$email = com_db_input($_POST['email']);
			$phone = com_db_input($_POST['phone']);
			$contact_url = com_db_input($_POST['contact_url']);
			
			$company_name = com_db_input($_POST['company_name']);
			$company_website = com_db_input($_POST['company_website']);
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
			
			$ann_date = explode('/',$_POST['announce_date']);
			$announce_date = $ann_date[2].'-'.$ann_date[0].'-'.$ann_date[1];
			$eff_date = explode('/',$_POST['effective_date']);
			$effective_date = $eff_date[2].'-'.$eff_date[0].'-'.$eff_date[1];
			$source = com_db_input($_POST['source']);
			$headline = com_db_input($_POST['headline']);
			$rep   = array("\r\n", "\n","\r");
			$full_body = str_replace($rep,'<br />',$_POST['full_body']);
			$short_url = com_db_input($_POST['short_url']);
			$movement_type = com_db_input($_POST['movement_type']);
			$what_happened = com_db_input($_POST['what_happened']);
			$about_person = com_db_input($_POST['about_person']);
			$about_company = com_db_input($_POST['about_company']);
			$more_link = com_db_input($_POST['more_link']);
			$not_current = com_db_input($_POST['not_current']);
			$new_position = com_db_input($_POST['new_position']);
			$new_person = com_db_input($_POST['new_person']);
			
			$leadership_page = com_db_output($_POST['leadership_page']);
			$email_pattern = com_db_output($_POST['email_pattern']); 
			$lin_url = com_db_output($_POST['lin_url']);
			
			$publish = '0';
			$create_by = 'Admin';
			$status = '0';
			$add_date = date('Y-m-d');
			
			$query = "insert into " . TABLE_CONTACT . "
			(first_name, middle_name, last_name, new_title, email, phone, company_name, contact_url,lin_url,company_website, company_revenue, company_employee, company_industry, ind_group_id, industry_id,leadership_page,email_pattern, address, address2, city, state, country, zip_code, announce_date, effective_date, source, headline, full_body,short_url, movement_type, what_happened,about_person, about_company, more_link,not_current,new_position,new_person,add_date, publish,create_by, status) 
			values ('$first_name', '$middle_name', '$last_name', '$new_title', '$email', '$phone', '$company_name', '$contact_url', '$lin_url', '$company_website', '$company_revenue', '$company_employee', '$company_industry', '$ind_group_id', '$industry_id', '$leadership_page','$email_pattern','$address', '$address2', '$city', '$state', '$country', '$zip_code', '$announce_date', '$effective_date', '$source', '$headline', '$full_body','$short_url', '$movement_type', '$what_happened', '$about_person', '$about_company', '$more_link','$not_current','$new_position','$new_person','$add_date', '$publish', '$create_by', '$status')";
			com_db_query($query);
	  		com_redirect("contact.php?p=" . $p . "&selected_menu=contact&msg=" . msg_encode("New Contact added successfully"));
		 
		break;	
		
	case 'detailes':
			$query_edit ="select c.first_name,c.middle_name,c.last_name,c.new_title,c.email,c.phone,c.contact_url,
							c.company_name,c.company_website,r.name as company_revenue,e.name as company_employee,
							i.title as company_industry,c.address,c.address2,c.city,s.short_name as state,
							ct.countries_name as country,c.zip_code,c.announce_date,c.effective_date,
							so.source as source,c.headline,c.full_body,c.short_url,m.name as movement_type,
							c.what_happened,c.about_person,c.about_company,c.more_link,c.not_current,
							c.new_position,c.new_person,c.leadership_page,c.email_pattern,c.lin_url,c.add_date from " 
							.TABLE_CONTACT. " as c, " 
							.TABLE_REVENUE_SIZE." as r, "
							.TABLE_EMPLOYEE_SIZE." as e, "
							.TABLE_INDUSTRY." as i, "
							.TABLE_STATE." as s, "
							.TABLE_COUNTRIES." as ct, "
							.TABLE_SOURCE." as so, "
							.TABLE_MANAGEMENT_CHANGE." as m 
							where c.company_revenue=r.id and c.company_employee=e.id and c.company_industry=i.industry_id and c.state=s.state_id and c.country=ct.countries_id and c.source=so.id and c.movement_type=m.id and c.contact_id = '" . $cID . "'";
			
			$query_edit_result=com_db_query($query_edit);
	  		$data_edit=com_db_fetch_array($query_edit_result);
			
			$first_name = com_db_output($data_edit['first_name']);
			$middle_name = com_db_output($data_edit['middle_name']);
			$last_name = com_db_output($data_edit['last_name']);
			$new_title = com_db_output($data_edit['new_title']);
			
			$email = com_db_output($data_edit['email']);
			$phone = com_db_output($data_edit['phone']);
			$contact_url = com_db_output($data_edit['contact_url']);
			
			$company_name = com_db_output($data_edit['company_name']);
			$company_website = com_db_output($data_edit['company_website']);
			$company_revenue = com_db_output($data_edit['company_revenue']);
			$company_employee = com_db_output($data_edit['company_employee']);
			$company_industry = com_db_output($data_edit['company_industry']);
						
			$address = com_db_output($data_edit['address']);
			$address2 = com_db_output($data_edit['address2']);
			$city = com_db_output($data_edit['city']);
			$state = com_db_output($data_edit['state']);
			$country = com_db_output($data_edit['country']);
			$zip_code = com_db_output($data_edit['zip_code']);
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
			
			$source = com_db_output($data_edit['source']);
			$headline = com_db_output($data_edit['headline']); 
			$full_body = com_db_output($data_edit['full_body']);
			$short_url = com_db_output($data_edit['short_url']);
			$movement_type = com_db_output($data_edit['movement_type']);
			$what_happened = com_db_output($data_edit['what_happened']);
			$about_person = com_db_output($data_edit['about_person']);
			$about_company = com_db_output($data_edit['about_company']);
			$more_link = com_db_output($data_edit['more_link']);
			$not_current = com_db_output($data_edit['not_current']);
			$new_position = com_db_output($data_edit['new_position']);
			$new_person = com_db_output($data_edit['new_person']);
			$add_date =explode('-',$data_edit['add_date']);
			$leadership_page = com_db_output($data_edit['leadership_page']);
			$email_pattern = com_db_output($data_edit['email_pattern']); 
			$lin_url = com_db_output($data_edit['lin_url']);
			//var_dump($add_date);
			//echo $data_edit['add_date'];
			//$post_date = date('d, M Y',mktime(0,0,0,date($add_date[1]),date($add_date[2]),date($add_date[0])));
			
		break;	
	case 'activate':
     		
	   		$status=$_GET['status'];
			if($status==0){
				$query = "update " . TABLE_CONTACT . " set status = '1' where contact_id = '" . $cID . "'";
			}else{
				$query = "update " . TABLE_CONTACT . " set status = '0' where contact_id = '" . $cID . "'";
			}	
			com_db_query($query);
	  		com_redirect("contact.php?p=". $p ."&cID=" . $cID . "&selected_menu=contact&msg=" . msg_encode("Contact update successfully"));
			
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
	var agree=confirm("Contact will be deleted. \n Do you want to continue?");
	if (agree)
		window.location = "contact.php?selected_menu=contact&cID=" + nid + "&p=" + p + "&action=delete";
	else
		window.location = "contact.php?selected_menu=contact&cID=" + nid + "&p=" + p ;
}

function CheckAll(numRows){
	if(document.getElementById('all').checked){
		for(i=1; i<=numRows; i++){
			var contact_id='contact_id-'+ i;
			document.getElementById(contact_id).checked=true;
		}
	} else {
		for(i=1; i<=numRows; i++){
			var contact_id='contact_id-'+ i;
			document.getElementById(contact_id).checked=false;
		}
	}
}

function AllDelete(numRows){

	var flg=0;
	for(i=1; i<=numRows; i++){
			var contact_id='contact_id-'+ i;
			if(document.getElementById(contact_id).checked){
				flg=1;
			}	
		}
	if(flg==0){
		alert("Please checked atlist one checkbox for delete.");
		document.getElementById('contact_id-1').focus();
		return false;
	} else {
		var agree=confirm("Contact will be deleted. \n Do you want to continue?");
		if (agree)
			 document.topicform.submit();
		else
			window.location = "contact.php?selected_menu=contact";
	}	

}

function confirm_artivate(nid,p,status){
	if(status=='1'){
		var msg="Contact will be active. \n Do you want to continue?";
	}else{
		var msg="Contact will be Inactive. \n Do you want to continue?";
	}
	var agree=confirm(msg);
	if (agree)
		window.location = "contact.php?selected_menu=contact&cID=" + nid + "&p=" + p + "&status=" + status + "&action=activate";
	else
		window.location = "contact.php?selected_menu=contact&cID=" + nid + "&p=" + p ;
}

function ContactSearch(){
	window.location ='contact.php?action=ContactSearch&selected_menu=contact';
}
function Download_XLS(contact_id){
	window.location ="singal-contact-download-xls.php?contact_id="+contact_id;
}

</script>
<!--<script language="JavaScript" src="includes/editor.js"></script>-->
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>

<script type="text/javascript" language="javascript" src="selectuser.js"></script>
 <tr>
    <td align="left" valign="top" bgcolor="#FFFFFF">
	
	<div id="light" class="white_content" style="display:<? if($action=='ContactSearch'){ echo 'block';} else { echo 'none'; } ?>;">
		<div id="spiffycalendar" class="text"></div>
		<link rel="stylesheet" type="text/css" href="includes/javascript/spiffyCal/spiffyCal_v2_1.css">
		<script language="JavaScript" src="includes/javascript/spiffyCal/spiffyCal_v2_1.js"></script>
		<script language="javascript"><!--
		  var dateAvailableFrom = new ctlSpiffyCalendarBox("dateAvailableFrom", "frmSearch", "from_date","btnDate1","",scBTNMODE_CUSTOMBLUE);
		  var dateAvailableTo = new ctlSpiffyCalendarBox("dateAvailableTo", "frmSearch", "to_date","btnDate2","",scBTNMODE_CUSTOMBLUE);	
		//--></script>
		<form name="frmSearch" id="frmSearch" method="post" action="contact.php?selected_menu=contact&action=ContactSearchResult">
		<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1">
		  <tr>
			<td align="left" colspan="2" valign="top"><img src="images/specer.gif" width="1" height="50" alt="" title="" /> </td>
		  </tr>
		  <tr>
			<td align="left" valign="top" >First Name:</td>
			<td align="left" valign="top"><input name="first_name" id="first_name" /></td>
		  </tr>
		  <tr>
			<td align="left" valign="top">Last Name:</td>
			<td align="left" valign="top"><input name="last_name" id="last_name" /></td>
		  </tr>
		   <tr>
			<td align="left" valign="top">Title:</td>
			<td align="left" valign="top"><input name="title" id="title" />
				<!--<select name="title" id="title" >
					<option value="">All</option>
					<?//=selectComboBox("select id,title from ". TABLE_TITLE ." where status ='0' order by title" ,"");?>
				</select>-->
			</td>
		  </tr>
		   <tr>
			<td align="left" valign="top">Company:</td>
			<td align="left" valign="top"><input name="company" id="company" /></td>
		  </tr>
		  <tr>
			<td align="left" valign="top">Industry:</td>
			<td align="left" valign="top">
				<?php
				$industry_result = com_db_query("select * from " . TABLE_INDUSTRY ." where status='0' and parent_id = '0' order by title");
				?>
				<select name="industry" id="industry" >
					<option value="">All</option>
					<?php
					while($indus_row = com_db_fetch_array($industry_result)){
					?>
					<optgroup label="<?=$indus_row['title']?>">
					<?=selectComboBox("select industry_id,title from ". TABLE_INDUSTRY ." where status='0' and parent_id ='".$indus_row['industry_id']."' order by title" ,"");?>
					</optgroup>
					<? } ?>
					
				</select>
			</td>
		  </tr>
		  <tr>
			<td align="left" valign="top">State:</td>
			<td align="left" valign="top">
				<select name="state" id="sec_state" >
					<option value="">All</option>
					<?=selectComboBox("select state_id,short_name from ". TABLE_STATE ." where country_id ='223'" ,"");?>
				</select>	
			</td>
		  </tr>
		  <tr>
			<td align="left" valign="top">Status:</td>
			<td align="left" valign="top">
				<select name="status" id="status" >
					<option value="">All</option>
					<option value="0">Active</option>
					<option value="1">Inactive</option>
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
			<td align="left" valign="top">Country:</td>
			<td align="left" valign="top">
				<select name="country" id="sec_country" >
					<option value="">All</option>
					<?=selectComboBox("select countries_id,countries_name from ". TABLE_COUNTRIES ." where countries_name='United States'" ,"");?>
					<?=selectComboBox("select countries_id,countries_name from ". TABLE_COUNTRIES ." order by countries_name" ,"");?>
				</select>	
			</td>
		  </tr>
		  <tr>
			<td align="left" valign="top">Movement Type:</td>
			<td align="left" valign="top">
				<select name="movement_type" id="movement_type" >
					<option value="">All</option>
					<?=selectComboBox("select id,name from ". TABLE_MANAGEMENT_CHANGE ." where status='0' order by name","");?>
				</select>	
			</td>
		  </tr>
		   <tr>
			<td align="center" valign="top">&nbsp;</td>
			<td align="center" valign="top">&nbsp;</td>
		  </tr>
		  <tr>
			<td align="center" valign="top">&nbsp;<!--<a href=""><img src="images/back-buttn.jpg" width="107" height="45" border="0" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'"/></a>--></td>
		  	<td align="left" valign="top"><input type="submit" value="Search" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='contact.php?selected_menu=contact'" /></td>
		  </tr>
		  <tr>
			<td align="center" valign="top">&nbsp;</td>
			<td align="center" valign="top">&nbsp;</td>
		  </tr>
		</table>
		</form>
	</div>
	<div id="fade" class="black_overlay" style="display:<? if($action=='ContactSearch'){ echo 'block';} else { echo 'none'; } ?>;"></div>
	
	
	<table width="975" border="0" align="center" cellpadding="0" cellspacing="0">

      <tr>
		<?php
		include("includes/menu_left.php");
		?>
		<td width="10" align="left" valign="top">&nbsp;</td>
        <td width="769" align="left" valign="top">

<?php if(($action == '') || ($action == 'save') || ($action =='ContactSearch') || $action =='ContactSearchResult' || $action =='AdvSearch'){	?>			

		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
          <tr>
            <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="16%" align="left" valign="middle" class="heading-text">Contact Manager</td>
                  <td width="55%" align="left" valign="middle" class="message"><?=$msg?></td>
				  <td width="3%" align="right" valign="middle"><a href="#"><img src="images/search-icon.jpg" border="0" width="25" height="28"  alt="Search Contact" title="Search Contact" onclick="ContactSearch('ContactSearch');"  /></a></td>
				  <td width="5%" align="left" valign="middle" class="nav-text">Search</td>
                  <td width="4%" align="right" valign="middle"><a href="#"><img src="images/add-icon.jpg" border="0" width="25" height="28" alt="Add Contact" title="Add Contact" onclick="window.location='contact.php?action=add&selected_menu=contact'"  /></a></td>
                  <td width="7%" align="left" valign="middle" class="nav-text">Add New </td>
                  <td width="4%" align="right" valign="middle"><a href="#"><img src="images/delete-icon.jpg" border="0" width="25" height="28"  alt="Delete Contact" title="Delete Contact" onclick="AllDelete('<?=$numRows?>');"  /></a></td>
                  <td width="6%" align="left" valign="middle" class="nav-text">Delete</td>
                </tr>
              </table></td>
          </tr>
       
          <tr>
            <td align="left" valign="top" class="right-bar-content-border">
			<form name="topicform" action="contact.php?action=alldelete&selected_menu=contact" method="post">
			<table width="100%" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="27" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-title-text">#</span></td>
				<td width="37" height="30" align="center" valign="middle" class="right-border">
				<input type="checkbox" name="all" id="all" onclick="CheckAll('<?=$numRows?>');" /></td>
				<td width="176" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Name</span> </td>
				<td width="211" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Title</span> </td>
                <td width="160" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Company</span> </td>
				
				<td width="106" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Effective Date</span> </td>
                <td width="244" height="30" align="center" valign="middle" class="left-border"><div align="center"><span class="right-box-title-text">Action</span></div></td>
			  </tr>
			<?php
			
			if($total_data>0) {
				$i=$starting_point+1;
				while ($data_sql = com_db_fetch_array($exe_data)) {
				$effective_date = $data_sql['effective_date'];
				$status = $data_sql['status'];
				$subscription_name = com_db_GetValue("select subscription_name from " . TABLE_SUBSCRIPTION . " where sub_id='".$data_sql['subscription_id']."'");
			?>          
			  <tr>
				<td height="30" align="center" valign="middle" class="right-border-left"><?=$i;?></td>
				<td height="30" align="center" valign="middle" class="right-border"><input type="checkbox" id="contact_id-<?=$i;?>" name="nid[]" value="<?=$data_sql['contact_id'];?>" /></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><a href="contact.php?action=detailes&p=<?=$p?>&selected_menu=contact&cID=<?=$data_sql['contact_id'];?>"><?=com_db_output($data_sql['first_name']).' '.com_db_output($data_sql['last_name'])?></a></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><?=com_db_output($data_sql['new_title'])?></td>
                <td height="30" align="left" valign="middle" class="right-border-text"><?=com_db_output($data_sql['company_name'])?></td>
				
                <td height="30" align="center" valign="middle" class="right-border"><?=$effective_date;?></td>
				<td height="30" align="center" valign="middle" class="left-border">
					<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr> 
					  	<td width="37%" align="center" valign="middle"><a href="#"><img src="images/icon/xls-small-icon.gif" width="16" height="16" alt="" title="" border="0" onclick="Download_XLS('<?=$data_sql['contact_id'];?>');" /></a><br />
					   	  .xls&nbsp;Download</td>
					  	<?php if($status==0){ ?>
					   	<td width="18%" align="center" valign="middle"><a href="#"><img src="images/icon/active-icon.gif" width="16" height="16" alt="" title="" border="0" onclick="confirm_artivate('<?=$data_sql['contact_id'];?>','<?=$p;?>','<?=$status;?>');" /></a><br />
					   	  Status</td>
					   	<?php } elseif($status==1){ ?>
					   	<td width="16%" align="center" valign="middle"><a href="#"><img src="images/icon/inactive-icon.gif" width="16" height="16" alt="" title="" border="0" onclick="confirm_artivate('<?=$data_sql['contact_id'];?>','<?=$p;?>','<?=$status;?>');" /></a><br />
					   	  Status</td>
						<?php } ?>
						<td width="12%" align="center" valign="middle"><a href="#"><img src="images/small-edit-icon.gif" width="16" height="16" alt="Edit" title="Edit" border="0" onclick="window.location='contact.php?selected_menu=contact&p=<?=$p;?>&cID=<?=$data_sql['contact_id'];?>&action=edit'" /></a><br />
						  Edit</td>
						<td width="17%" align="center" valign="middle"><a href="#"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" title="Delete" border="0" onclick="confirm_del('<?=$data_sql['contact_id'];?>','<?=$p;?>')" /></a><br />
						  Delete</td>
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
		if($action=='ContactSearchResult' || $action == 'AdvSearch'){
			$extra_feture = '&selected_menu=contact&action=AdvSearch';
		}else{
			$extra_feture = '&selected_menu=contact';
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
	var fname=document.frmDataEdit.first_name.value;
	
	if(fname==''){
		alert("Please enter first name.");
		document.frmDataEdit.first_name.focus();
		return false;
	}
	var lname=document.frmDataEdit.last_name.value;
	if(lname==''){
		alert("Please enter last name.");
		document.frmDataEdit.last_name.focus();
		return false;
	}

}
function CurrentStatusCheck(){
	if(document.getElementById('not_current').checked){
		document.getElementById('div_not_current').style.display='block';
	}else{
		document.getElementById('div_not_current').style.display='none';
	}
}
function UpdateActivate(){
	var fname = document.frmDataEdit.first_name.value;
	var flag=1;
	if((fname =='')){
		flag=0;
		document.getElementById('div_first_name').innerHTML='First Name';
	}else if(fname !=''){
		document.getElementById('div_first_name').innerHTML='';
	}
	
	var lname = document.frmDataEdit.last_name.value;
	if((lname =='')){
		flag=0;
		document.getElementById('div_last_name').innerHTML='Last Name';
	}else if(lname !=''){
		document.getElementById('div_last_name').innerHTML='';
	}
	
	var title = document.frmDataEdit.new_title.value;
	if((title =='')){
		flag=0;
		document.getElementById('div_new_title').innerHTML='Title';
	}else if(title !=''){
		document.getElementById('div_new_title').innerHTML='';
	}
	var cwebsite = document.frmDataEdit.company_website.value;
	if((cwebsite =='')){
		flag=0;
		document.getElementById('div_company_website').innerHTML='Website';
	}else if(cwebsite !=''){
		document.getElementById('div_company_website').innerHTML='';
	}
	var cname = document.frmDataEdit.company_name.value;
	if((cname =='')){
		flag=0;
		document.getElementById('div_company_name').innerHTML='Company Name';
	}else if(cname !=''){
		document.getElementById('div_company_name').innerHTML='';
	}
	
	var crevenue = document.frmDataEdit.company_revenue.value;
	if((crevenue =='Any' || crevenue =='')){
		flag=0;
		document.getElementById('div_company_revenue').innerHTML='Size Revenue';
	}else if(crevenue !='Any' && crevenue !=''){
		document.getElementById('div_company_revenue').innerHTML='';
	}
	
	var cemployee = document.frmDataEdit.company_employee.value;
	if((cemployee =='Any' || cemployee =='')){
		flag=0;
		document.getElementById('div_company_employee').innerHTML='Size Employee';
	}else if(cemployee !='Any' && cemployee !=''){
		document.getElementById('div_company_employee').innerHTML='';
	}

	var cindustry = document.frmDataEdit.company_industry.value;
	if((cindustry =='Any' || cindustry =='')){
		flag=0;
		document.getElementById('div_company_industry').innerHTML='Industry';
	}else if(cindustry !='Any' && cindustry !=''){
		document.getElementById('div_company_industry').innerHTML='';
	}
	var address = document.frmDataEdit.address.value;
	if((address =='Address' || address =='')){
		flag=0;
		document.getElementById('div_address').innerHTML='Address';
	}else if(address !='Address' && address !=''){
		document.getElementById('div_address').innerHTML='';
	}
	
	var city = document.frmDataEdit.city.value;
	if((city =='Type in the City' || city =='')){
		flag=0;
		document.getElementById('div_city').innerHTML='City';
	}else if(city !='Type in the City' && city !=''){
		document.getElementById('div_city').innerHTML='';
	}
	var country = document.frmDataEdit.country.value;
	if((country =='Any' || country =='')){
		flag=0;
		document.getElementById('div_country').innerHTML='Country';
	}else if(country !='Any' && country !=''){
		document.getElementById('div_country').innerHTML='';
	}
	var state = document.frmDataEdit.state.value;
	if((state =='Any' || state =='') ){
		flag=0;
		document.getElementById('div_state').innerHTML='State';
	}else if(state !='Any' && state !=''){
		document.getElementById('div_state').innerHTML='';
	}
	
	var zip = document.frmDataEdit.zip_code.value;
	if((zip =='Type in the Zip code' || zip =='')){
		flag=0;
		document.getElementById('div_zip_code').innerHTML='Zip Code';
	}else if(zip !='Type in the Zip code' && zip !=''){
		document.getElementById('div_zip_code').innerHTML='';
	}
	var adate = document.frmDataEdit.announce_date.value;
	if((adate =='Date of Announcement' || adate =='')){
		flag=0;
		document.getElementById('div_announce_date').innerHTML='Date Announcement';
	}else if(adate !='Date of Announcement' && adate !=''){
		document.getElementById('div_announce_date').innerHTML='';
	}
	var edate = document.frmDataEdit.effective_date.value;
	if((edate =='Effective date' || edate =='') ){
		flag=0;
		document.getElementById('div_effective_date').innerHTML='Date Effective';
	}else if(edate !='Effective date' && edate !=''){
		document.getElementById('div_effective_date').innerHTML='';
	}
	var source = document.frmDataEdit.source.value;
	if((source =='Any' || source =='') ){
		flag=0;
		document.getElementById('div_source').innerHTML='Source';
	}else if(source !='Any' && source !=''){
		document.getElementById('div_source').innerHTML='';
	}
	
	var headline = document.frmDataEdit.headline.value;
	if((headline =='Headline' || headline =='')){
		flag=0;
		document.getElementById('div_headline').innerHTML='Headline';
	}else if(headline !='Headline' && headline !=''){
		document.getElementById('div_headline').innerHTML='';
	}
	
	var mtype = document.frmDataEdit.movement_type.value;
	if((mtype =='Any' || mtype =='')){
		flag=0;
		document.getElementById('div_movement_type').innerHTML='Type';
	}else if(mtype !='Any' && mtype !=''){
		document.getElementById('div_movement_type').innerHTML='';
	}
	/*var what_happened = document.frmDataEdit.what_happened.value;
	if((what_happened =='What happened?' || what_happened =='')){
		flag=0;
		document.getElementById('div_what_happened').innerHTML='What happened';
	}else if(what_happened !='What happened?' && what_happened !=''){
		document.getElementById('div_what_happened').innerHTML='';
	}
	var about_person = document.frmDataEdit.about_person.value;
	if((about_person =='About the Person?' || about_person =='')){
		flag=0;
		document.getElementById('div_about_person').innerHTML='About Person';
	}else if(about_person !='About the Person?' && about_person !=''){
		document.getElementById('div_about_person').innerHTML='';
	}
	var about_company = document.frmDataEdit.about_company.value;
	if((about_company =='About The Company?' || about_company =='')){
		flag=0;
		document.getElementById('div_about_company').innerHTML='About Company';
	}else if(about_company !='About The Company?' && about_company !=''){
		document.getElementById('div_about_company').innerHTML='';
	}*/
	if(flag==1){	
		document.getElementById('ActivateButton').style.display="block";
		document.getElementById('OnlyButton').style.display="none";
	}else{
		document.getElementById('OnlyButton').style.display="block";
		document.getElementById('ActivateButton').style.display="none";
	}
	
}
</script>		

		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">Cotact Manager :: Edit Contact </td>
				  
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top"  class="right-bar-content-border-box"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="celter" valign="top">
		 <!--start iner table  -->
		 <form name="frmDataEdit" id="frmDataEdit" method="post" action="contact.php?action=editsave&selected_menu=contact&cID=<?=$cID;?>&p=<?=$p;?>" onsubmit="return chk_form();">
			<table width="95%" align="center" cellpadding="5" cellspacing="5" border="0">
			
			<tr>
			  <td align="left" class="heading-text-a"><a href="javascript:ContactDivControl('div_executive');">>> Executive</a></td>	
			</tr>
            <tr>
			  <td align="left">
              	<div id="div_executive" style="display:block;">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;First Name*:</td>
                      <td width="50%" align="left" valign="top">
                        <input type="text" name="first_name" id="firstname" size="30" value="<?=$first_name;?>" onblur="UpdateActivate();"/>
                      </td>	
                      <td width="25%" align="left" class="MsgShowText" valign="middle"><div id="div_first_name"></div></td>
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Middle Name:</td>
                      <td width="50%" align="left" valign="top">
                        <input type="text" name="middle_name" id="middle_name" size="30" value="<?=$middle_name;?>" />
                      </td>	
                      <td width="25%" align="left" class="MsgShowText" valign="middle">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Last Name*:</td>
                      <td width="50%" align="left" valign="top">
                        <input type="text" name="last_name" id="lastname" size="30" value="<?=$last_name;?>" onblur="UpdateActivate();"/>
                      </td>	
                      <td width="25%" align="left" class="MsgShowText" valign="middle"><div id="div_last_name"></div></td>
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;New Title*:</td>
                      <td width="50%" align="left" valign="top">
                        <input type="text" name="new_title" id="new_title" size="30" value="<?=$new_title;?>" onblur="UpdateActivate();"/>
                      </td>	
                      <td width="25%" align="left" class="MsgShowText" valign="middle"><div id="div_new_title"></div></td>
                    </tr>
                  </table>
                  </div>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a"> <a href="javascript:ContactDivControl('div_contact_details');">>> Contact Details</a></td>	
			</tr>
            <tr>
			  <td align="left">
              	<div id="div_contact_details" style="display:block;">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Email:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="email" id="email" size="30" value="<?=$email;?>" onblur="UpdateActivate();"/>
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Phone:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="phone" id="phone" size="30" value="<?=$phone;?>" onblur="UpdateActivate();"/>
                      </td>	
                    </tr>
					<tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Contact URL:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="contact_url" id="contact_url" size="30" value="<?=$contact_url?>" onblur="UpdateActivate();"/>
                      </td>	
                    </tr>
					<tr>
					  <td align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;LIN url:</td>
					  <td align="left" valign="top"><input type="text" name="lin_url" id="lin_url" size="30" value="<?=$lin_url?>" onblur="UpdateActivate();"/></td>
					  </tr>
                  </table>
                  </div>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a"><a href="javascript:ContactDivControl('div_company');">>> Company</a></td>	
			</tr>
            <tr>
			  <td align="left">
              	 <div id="div_company" style="display:block;">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Website*:</td>
                      <td width="50%" align="left" valign="top">
                        <input type="text" name="company_website" id="company_website" size="30" value="<?=$company_website;?>" onblur="UpdateActivate();"/>
                      </td>
                      <td width="25%" align="left" class="MsgShowText" valign="middle"><div id="div_company_website"></div></td>
                    </tr>
					<tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;New Company*:</td>
                      <td width="50%" align="left" valign="top">
                        <input type="text" name="company_name" id="company_name" size="30" value="<?=$company_name;?>" onblur="UpdateActivate();"/>
                      </td>	
                      <td width="25%" align="left" class="MsgShowText" valign="middle"><div id="div_company_name"></div></td>
                    </tr>
                    
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Size ($Revenue)*:</td>
                      <td width="50%" align="left" valign="top">
                     	<select name="company_revenue" id="company_revenue" style="width:206px;" onblur="UpdateActivate();"/>
						<?=selectComboBox("select id,name from ".TABLE_REVENUE_SIZE." where status='0' order by from_range",$company_revenue)?>
						<option value="Any">Any</option>
						</select>
					 </td>	
                     <td width="25%" align="left" class="MsgShowText" valign="middle"><div id="div_company_revenue"></div></td>
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Size (Employees)*:</td>
                      <td width="50%" align="left" valign="top">
                      	<select name="company_employee" id="company_employee" style="width:206px;" onblur="UpdateActivate();"/>
						<?=selectComboBox("select id,name from ".TABLE_EMPLOYEE_SIZE." where status='0' order by from_range",$company_employee)?>
						<option value="Any">Any</option>
						</select>
					  </td>	
                      <td width="25%" align="left" class="MsgShowText" valign="middle"><div id="div_company_employee"></div></td>
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Industry*:</td>
                      <td width="50%" align="left" valign="top">
                      	<?php
						$industry_result = com_db_query("select * from " . TABLE_INDUSTRY ." where parent_id = '0' and status='0' order by title");
						?>
						<select name="company_industry" id="company_industry" multiple="multiple" onblur="UpdateActivate();">
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
                      <td width="25%" align="left" class="MsgShowText" valign="middle"><div id="div_company_industry"></div></td>
                    </tr>
					<tr>
                      <td align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Leadership Page:</td>
                      <td align="left" valign="top"><input type="text" name="leadership_page" id="leadership_page" size="30" value="<?=$leadership_page?>" /></td>
                      <td align="left" class="MsgShowText" valign="middle">&nbsp;</td>
                    </tr>
                    <tr>
                      <td align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Email Pattern:</td>
                      <td align="left" valign="top"><input type="text" name="email_pattern" id="email_pattern" size="30" value="<?=$email_pattern?>" /></td>
                      <td align="left" class="MsgShowText" valign="middle">&nbsp;</td>
                    </tr>
                  </table>
                  </div>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a"><a href="javascript:ContactDivControl('div_location');">>> Location</a></td>	
			</tr>
            <tr>
			  <td align="left">
              	<div id="div_location" style="display:block;">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Address*:</td>
                      <td width="50%" align="left" valign="top">
                        <input type="text" name="address" id="address" size="30" value="<?=$address;?>" onblur="UpdateActivate();"/>
                      </td>	
                      <td width="25%" align="left" class="MsgShowText" valign="middle"><div id="div_address"></div></td>
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Address 2:</td>
                      <td width="50%" align="left" valign="top">
                        <input type="text" name="address2" id="address2" size="30" value="<?=$address2;?>" onblur="UpdateActivate();"/>
                      </td>
                      <td width="25%" align="left" class="MsgShowText" valign="middle">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;City*:</td>
                      <td width="50%" align="left" valign="top">
                        <input type="text" name="city" id="city" size="30" value="<?=$city;?>" onblur="UpdateActivate();"/>
                      </td>	
                      <td width="25%" align="left" class="MsgShowText" valign="middle"><div id="div_city"></div></td>
                    </tr>
					<tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Country*:</td>
                      <td width="50%" align="left" valign="top">
					   <select name="country" id="country" style="width:206px;" onchange="StateChangeEdit('country');" onblur="UpdateActivate();"/>
					   	<?=selectComboBox("select countries_id,countries_name from ". TABLE_COUNTRIES ." where countries_id='223'",$country);?>
						<?=selectComboBox("select countries_id,countries_name from ".TABLE_COUNTRIES." order by countries_name",$country)?>
						<option value="Any">Any</option>
						</select>
                      </td>	
                      <td width="25%" align="left" class="MsgShowText" valign="middle"><div id="div_country"></div></td>
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;State*:</td>
                      <td width="50%" align="left" valign="top">
					  <div id="div_state_edit">
						<select name="state" id="state" style="width:206px;" onblur="UpdateActivate();"/>
						<?=selectComboBox("select state_id,short_name from ".TABLE_STATE." where country_id='".$country."' order by short_name",$state)?>
						<option value="Any">Any</option>
						</select>
					  </div> 	
                      </td>	
                       <td width="25%" align="left" class="MsgShowText" valign="middle"><div id="div_state"></div></td>
                    </tr>
                    
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Zip Code*:</td>
                      <td width="50%" align="left" valign="top">
                        <input type="text" name="zip_code" id="zip_code" size="30" value="<?=$zip_code;?>" onblur="UpdateActivate();"/>
                      </td>
                      <td width="25%" align="left" class="MsgShowText" valign="middle"><div id="div_zip_code"></div></td>	
                    </tr>
                  </table>
                  </div>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a"><a href="javascript:ContactDivControl('div_change_details');">>> Change Details</a></td>	
			</tr>
            <tr>
			  <td align="left">
              	<div id="div_change_details" style="display:block;">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="26%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Date of Announcement*:</td>
                      <td width="50%" align="left" valign="top">
                        <input type="text" name="announce_date" id="announce_date" size="30" value="<?=$announce_date;?>" onblur="UpdateActivate();"/>
						<a href="javascript:NewCssCal('announce_date','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a>
                      </td>
                      <td width="24%" align="left" class="MsgShowText" valign="middle"><div id="div_announce_date"></div></td>
                    </tr>
                    <tr>
                      <td width="26%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Effective Date*:</td>
                      <td width="50%" align="left" valign="top">
                        <input type="text" name="effective_date" id="effective_date" size="30" value="<?=$effective_date;?>" onblur="UpdateActivate();"/>
                      	<a href="javascript:NewCssCal('effective_date','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a>
					  </td>	
                      <td width="24%" align="left" class="MsgShowText" valign="middle"><div id="div_effective_date"></div></td>
                    </tr>
                    <tr>
                      <td width="26%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Source*:</td>
                      <td width="50%" align="left" valign="top">
						<select name="source" id="source" style="width:206px;" onblur="UpdateActivate();"/>
						<?=selectComboBox("select id,source from ".TABLE_SOURCE." where status='0' order by source",$source)?>
						<option value="Any">Any</option>
						</select>
                      </td>	
                      <td width="24%" align="left" class="MsgShowText" valign="middle"><div id="div_source"></div></td>
                    </tr>
                    <tr>
                      <td width="26%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Headline*:</td>
                      <td width="50%" align="left" valign="top">
						<textarea name="headline" id="headline" style="width:205px;height:18px;" onblur="UpdateActivate();"/><?=$headline;?></textarea>
                      </td>
                      <td width="24%" align="left" class="MsgShowText" valign="middle"><div id="div_headline"></div></td>	
                    </tr>
                    <tr>
                      <td width="26%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Full Body:</td>
                      <td width="50%" align="left" valign="top">
                        <textarea name="full_body" id="full_body" rows="7" cols="40" ><?=$full_body;?></textarea>
                      </td>	
                      <td width="24%" align="left" class="MsgShowText" valign="middle">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="26%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Short url:</td>
                      <td width="50%" align="left" valign="top">
                        <input type="text" name="short_url" id="short_url" size="30" value="<?=$short_url;?>" onblur="UpdateActivate();"/>
                      </td>	
                      <td width="24%" align="left" class="MsgShowText" valign="middle">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="26%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Movement Type*:</td>
                      <td width="50%" align="left" valign="top">
                      	<select name="movement_type" id="movement_type" style="width:206px;" onblur="UpdateActivate();"/>
							<?=selectComboBox("select id,name from ".TABLE_MANAGEMENT_CHANGE." order by name",$movement_type)?>
							<option value="Any">Any</option>
                        </select>
					  </td>	
                      <td width="24%" align="left" class="MsgShowText" valign="middle"><div id="div_movement_type"></div></td>
                    </tr>
                    <tr>
                      <td width="26%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;What Happened?*:</td>
                      <td colspan="2" align="left" valign="top">
                        <textarea  id="what_happened" name="what_happened"><?=$what_happened?></textarea>
						<script type="text/javascript">
                        //<![CDATA[
                            CKEDITOR.replace('what_happened');
                        //]]>
                        </script>
					  </td>
                     </tr>
                    
                    <tr>
                      <td width="26%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;About the Person?*:</td>
                      <td colspan="2" align="left" valign="top">
                        <textarea  id="about_person" name="about_person"><?=$about_person?></textarea>
						<script type="text/javascript">
                        //<![CDATA[
                            CKEDITOR.replace('about_person');
                        //]]>
                        </script>
                      </td>
                    </tr>
                
                    <tr>
                      <td width="26%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;About the Company?*:</td>
                      <td colspan="2" align="left" valign="top">
                        <textarea  id="about_company" name="about_company"><?=$about_company?></textarea>
						<script type="text/javascript">
                        //<![CDATA[
                            CKEDITOR.replace('about_company');
                        //]]>
                        </script>
                      </td>
                     </tr>
                    <tr>
                      <td width="26%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;More Info Link?:</td>
                      <td width="50%" align="left" valign="top">
                        <input type="text" name="more_link" id="more_link" size="30" value="<?=$more_link;?>" onblur="UpdateActivate();"/>
                      </td>
                      <td width="24%" align="left" class="MsgShowText" valign="middle">&nbsp;</td>	
                    </tr>
					<tr>
                      <td width="26%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Not Current?:</td>
                      <td width="50%" align="left" valign="top"><input type="checkbox" name="not_current" id="not_current" value="Yes" <? if($not_current=='Yes'){echo 'checked="checked"';}?> onclick="CurrentStatusCheck();" />
                      </td>	
                      <td width="24%" align="left" class="MsgShowText" valign="middle">&nbsp;</td>
                    </tr>
					<tr>
                      <td colspan="3" align="left" class="page-text" valign="top">
					  	<div id="div_not_current" style="display:<? if($not_current=='Yes'){echo 'block';}else{echo 'none';}?>;">
							<table width="100%" cellpadding="1" cellspacing="1" border="0">
								<tr>
								  <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;New Position:</td>
								  <td width="75%" align="left" valign="top"><input type="text" name="new_position" id="new_position" size="30" value="<?=$new_position?>" />
								  </td>	
								</tr>
								<tr>
								  <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;New Person:</td>
								  <td width="75%" align="left" valign="top"><input type="text" name="new_person" id="new_person" size="30" value="<?=$new_person?>" />
								  </td>	
								</tr>
							</table>
						</div>
                      </td>	
                    </tr>
                  </table>
                  </div>
              </td>	
			</tr>
            <tr>
            	<td align="center">
                	<input type="hidden" name="status_active" id="status_active" />
                	<table width="50%" border="0" cellpadding="4" cellspacing="4">
                    	<tr>
                        	<td><input type="submit" value="Update Contact" class="submitButton" /></td>
                            <td>
                            	<div id="OnlyButton"><input type="button" value="Update & Activate" class="submitButton"/></div>
                                <div id="ActivateButton" style="display:none;"><input type="submit" value="Update & Activate" class="submitButton" style="color:#FFF;border-color:#900;background-color:#F33;" onclick="document.getElementById('status_active').value='1'"/></div>
                            </td>
                            <td><input type="button" class="submitButton" value="cancel" onclick="window.location='contact.php?p=<?=$p;?>&uID=<?=$uID;?>&selected_menu=contact'" /></td>
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
	var fname=document.DateTest.first_name.value;
	if(fname==''){
		alert("Please enter first name.");
		document.DateTest.first_name.focus();
		return false;
	}
	var lname=document.DateTest.last_name.value;
	if(lname==''){
		alert("Please enter last name.");
		document.DateTest.last_name.focus();
		return false;
	}

}
function CurrentStatusCheck(){
	if(document.getElementById('not_current').checked){
		document.getElementById('div_not_current').style.display='block';
	}else{
		document.getElementById('div_not_current').style.display='none';
	}
}
</script>
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">Contact Manager :: Add Contact </td>
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="left" valign="top" class="right-border-box">
		 <!--start iner table  -->
		 <form name="DateTest" method="post" action="contact.php?action=addsave&selected_menu=contact&cID=<?=$cID;?>&p=<?=$p;?>" onsubmit="return chk_form_Add();">
		  <table width="95%" align="left" cellpadding="5" cellspacing="5" border="0">
			<tr>
			  <td align="left" class="heading-text-a">>> Executive</td>	
			</tr>
            <tr>
			  <td align="left">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;First Name:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="first_name" id="first_name" size="30" value="" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Middle Name:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="middle_name" id="middle_name" size="30" value="" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Last Name:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="last_name" id="last_name" size="30" value="" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;New Title:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="new_title" id="new_title" size="30" value="" />
						<!--<select name="new_title" id="new_title" style="width:206px;">
						<?//=selectComboBox("select id,title from ".TABLE_TITLE ." where status='0' order by title","")?>
						<option value="Any">Any</option>
						</select>-->
                      </td>	
                    </tr>
                  </table>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a">>> Contact Details</td>	
			</tr>
            <tr>
			  <td align="left">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Email:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="email" id="email" size="30" value="" />                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Phone:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="phone" id="phone" size="30" value="" />                      </td>	
                    </tr>
					<tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Contact URL:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="contact_url" id="contact_url" size="30" value="" />                      </td>	
                    </tr>
					<tr>
					  <td align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;LIN url:</td>
					  <td align="left" valign="top"><input type="text" name="lin_url" id="lin_url" size="30" value="" /></td>
					  </tr>
                  </table>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a">>> Company</td>	
			</tr>
            <tr>
			  <td align="left">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Website:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="company_website" id="company_website" size="30" value="" onblur="AddCompanyInfo('company_website');"/>
                      	<div id="div_company_website" style="display:none;color:#993300;font-family:Verdana, Arial, Helvetica, sans-serif;">Please wait...</div>					  </td>	
                    </tr>
					<tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;New Company:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="company_name" id="company_name" size="30" value="" />                      </td>	
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
                    <tr>
                      <td align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Email Pattern:</td>
                      <td align="left" valign="top"><input type="text" name="email_pattern" id="email_pattern" size="30" value="" /></td>
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
                  </table>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a">>> Change Details</td>	
			</tr>
            <tr>
			  <td align="left">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Date of Announcement:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="announce_date" id="announce_date" size="30" value="" />
						<a href="javascript:NewCssCal('announce_date','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a>						
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Effective Date:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="effective_date" id="effective_date" size="30" value="" />
						<a href="javascript:NewCssCal('effective_date','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a>
                      </td>	
                    </tr>
					 <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Source:</td>
                      <td width="75%" align="left" valign="top">
                       <!-- <input type="text" name="source" id="source" size="30" value="" />-->
						<select name="source" id="source" style="width:206px;">
						<?=selectComboBox("select id,source from ".TABLE_SOURCE." where status='0' order by source","")?>
						<option value="Any">Any</option>
						</select>
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Headline:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="headline" id="headline" size="30" value="" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Full Body:</td>
                      <td width="75%" align="left" valign="top">
                        <textarea name="full_body" id="full_body" rows="5" cols="23" ></textarea>
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Short url:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="short_url" id="short_url" size="30" value="" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Movement Type:</td>
                      <td width="75%" align="left" valign="top">
					  	<select name="movement_type" id="movement_type" style="width:206px;">
							<?=selectComboBox("select id,name from ".TABLE_MANAGEMENT_CHANGE." where status='0' order by name","")?>
							<option value="Any">Any</option>
                        </select>
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;What Happened?:</td>
                      <td width="75%" align="left" valign="top">
                        <textarea  id="what_happened" name="what_happened"></textarea>
						<script type="text/javascript">
                        //<![CDATA[
                            CKEDITOR.replace('what_happened');
                        //]]>
                        </script>
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;About the Person?:</td>
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
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;About the Company?:</td>
                      <td width="75%" align="left" valign="top">
                        <textarea  id="about_company" name="about_company"></textarea>
						<script type="text/javascript">
                        //<![CDATA[
                            CKEDITOR.replace('about_company');
                        //]]>
                        </script>
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;More Info Link?:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="more_link" id="more_link" size="30" value="" />
                      </td>	
                    </tr>
					<tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Not Current?:</td>
                      <td width="75%" align="left" valign="top"><input type="checkbox" name="not_current" id="not_current" value="Yes" onclick="CurrentStatusCheck();" />
                      </td>	
                    </tr>
					<tr>
                      <td width="100%" colspan="2" align="left" class="page-text" valign="top">
					  	<div id="div_not_current" style="display:none;">
							<table width="100%" cellpadding="1" cellspacing="1" border="0">
								<tr>
								  <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;New Position:</td>
								  <td width="75%" align="left" valign="top"><input type="text" name="new_position" id="new_position" size="30" value="" />
								  </td>	
								</tr>
								<tr>
								  <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;New Person:</td>
								  <td width="75%" align="left" valign="top"><input type="text" name="new_person" id="new_person" size="30" value="" />
								  </td>	
								</tr>
							</table>
						</div>
                      </td>	
                    </tr>
                  </table>
              </td>	
			</tr>
            <tr>
            	<td align="center">
                	<table width="50%" border="0" cellpadding="4" cellspacing="4">
                    	<tr><td><input type="submit" value="Add Contact" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='contact.php?p=<?=$p;?>&uID=<?=$uID;?>&selected_menu=contact'" /></td></tr>
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
                  <td width="50%" align="left" valign="middle" class="heading-text">Contact Manager :: Contact Details </td>
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
			  <td align="left" class="heading-text-a"><a href="javascript:ContactDivControl('div_executive');">>> Executive</a></td>	
			</tr>
            <tr>
			  <td align="left">
              	<div id="div_executive" style="display:block;">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;First Name:</td>
                      <td width="75%" align="left" valign="top"><?=$first_name;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Middle Name:</td>
                      <td width="75%" align="left" valign="top"><?=$middle_name;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Last Name:</td>
                      <td width="75%" align="left" valign="top"><?=$last_name;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;New Title:</td>
                      <td width="75%" align="left" valign="top"><?=$new_title;?></td>	
                    </tr>
                  </table>
                  </div>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a"> <a href="javascript:ContactDivControl('div_contact_details');">>> Contact Details</a></td>	
			</tr>
            <tr>
			  <td align="left">
              	<div id="div_contact_details" style="display:block;">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Email:</td>
                      <td width="75%" align="left" valign="top"><?=$email;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Phone:</td>
                      <td width="75%" align="left" valign="top"><?=$phone;?></td>	
                    </tr>
					 <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Contact URL:</td>
                      <td width="75%" align="left" valign="top"><?=$contact_url;?></td>	
                    </tr>
					<tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;LIN url:</td>
                      <td width="75%" align="left" valign="top"><?=$lin_url;?></td>	
                    </tr>
					
                  </table>
                  </div>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a"><a href="javascript:ContactDivControl('div_company');">>> Company</a></td>	
			</tr>
            <tr>
			  <td align="left">
              	 <div id="div_company" style="display:block;">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Website:</td>
                      <td width="75%" align="left" valign="top"><?=$company_website;?></td>	
                    </tr>
					<tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;New Company:</td>
                      <td width="75%" align="left" valign="top"><?=$company_name;?></td>	
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
			  <td align="left" class="heading-text-a"><a href="javascript:ContactDivControl('div_location');">>> Location</a></td>	
			</tr>
            <tr>
			  <td align="left">
              	<div id="div_location" style="display:block;">
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
                  </table>
                  </div>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a"><a href="javascript:ContactDivControl('div_change_details');">>> Change Details</a></td>	
			</tr>
            <tr>
			  <td align="left">
              	<div id="div_change_details" style="display:block;">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Date of Announcement:</td>
                      <td width="75%" align="left" valign="top"><?=$announce_date;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Effective Date:</td>
                      <td width="75%" align="left" valign="top"><?=$effective_date;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Source:</td>
                      <td width="75%" align="left" valign="top"><?=$source;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Headline:</td>
                      <td width="75%" align="left" valign="top"><?=$headline;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Full Body:</td>
                      <td width="75%" align="left" valign="top"><?=$full_body;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Short url:</td>
                      <td width="75%" align="left" valign="top"><?=$short_url;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Movement Type:</td>
                      <td width="75%" align="left" valign="top"><?=$movement_type;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;What Happened?:</td>
                      <td width="75%" align="left" valign="top"><?=$what_happened;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;About the Person?:</td>
                      <td width="75%" align="left" valign="top"><?=$about_person;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;About the Company?:</td>
                      <td width="75%" align="left" valign="top"><?=$about_company;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;More Info Link?:</td>
                      <td width="75%" align="left" valign="top"><?=$more_link;?></td>	
                    </tr>
					<tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Not Current?:</td>
                      <td width="75%" align="left" valign="top"><?=$not_current;?></td>	
                    </tr>
					<tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;New Position:</td>
                      <td width="75%" align="left" valign="top"><?=$new_position;?></td>	
                    </tr>
					<tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;New person:</td>
                      <td width="75%" align="left" valign="top"><?=$new_person;?></td>	
                    </tr>
                  </table>
                  </div>
              </td>	
			</tr>
            			
			</table>
		 <!-- end inner table -->
		  </td>
		 </tr>
		 <tr>
            	<td align="center">
                	<table width="50%" border="0" cellpadding="4" cellspacing="4">
                    	<tr><td><input type="button" class="submitButton" value="Back" onclick="window.location='contact.php?p=<?=$p;?>&selected_menu=contact'" /></td></tr>
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