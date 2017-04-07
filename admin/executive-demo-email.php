<?php
require('includes/include_top.php');

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

//$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 20;
$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 200;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';

//$sql_query .= " UNION select '' as personal_id, '' as first_name,'' as last_name, Jobs as person_tigger_name, '' as add_date, cji.*,c.company_name from " .TABLE_COMPANY_JOB_INFO." cji,". TABLE_COMPANY_MASTER . " as c order by c.company_id desc";

// Getting persons who has executive awards, speaking , publications etc
$executive_persons_id = "''";
$sql_executive_person_query = "select group_concat(personal_id) as person_ids FROM ".TABLE_PERSONAL_MASTER." where executive_email = 1";
$executive_Result = com_db_query($sql_executive_person_query);
$executive_Row = com_db_fetch_array($executive_Result);	  
$executive_persons_id = $executive_Row['person_ids'];
	  
/*
$sql_query = "select p.personal_id,p.first_name,p.last_name,p.executive_tigger_name as person_tigger_name,p.add_date,'' as company_name,'' as start_date  from " 
.TABLE_PERSONAL_MASTER. " as p, "
.TABLE_EXECUTIVE_AWARDS. " as aw, "
.TABLE_EXECUTIVE_BOARD. " as b, "
.TABLE_EXECUTIVE_PUBLICATION. " as pub, "
.TABLE_EXECUTIVE_SPEAKING. " as es  where (p.personal_id = es.personal_id or p.personal_id = pub.personal_id or p.personal_id = aw.personal_id or p.personal_id = b.personal_id) and p.personal_id in('".$executive_persons_id."')";
*/

$sql_query = "";
if($executive_persons_id != '')
{
	$sql_query = "select p.personal_id,b.board_id as type_id,p.first_name,p.last_name,'Board' as person_tigger_name,b.board_date as add_date,'' as company_name,'' as start_date  from " 
	.TABLE_PERSONAL_MASTER. " as p, "
	.TABLE_EXECUTIVE_BOARD. " as b  where (p.personal_id = b.personal_id) and p.personal_id in(".$executive_persons_id.")";
	$sql_query .= " UNION select p.personal_id,a.awards_id as type_id,p.first_name,p.last_name,'Award' as person_tigger_name,a.awards_date as add_date,'' as company_name,'' as start_date  from " 
	.TABLE_PERSONAL_MASTER. " as p, "
	.TABLE_EXECUTIVE_AWARDS. " as a  where (p.personal_id = a.personal_id) and p.personal_id in(".$executive_persons_id.")";
	$sql_query .= " UNION select p.personal_id,es.speaking_id as type_id,p.first_name,p.last_name,'Speaking' as person_tigger_name,es.event_date as add_date,'' as company_name,'' as start_date  from " 
	.TABLE_PERSONAL_MASTER. " as p, "
	.TABLE_EXECUTIVE_SPEAKING. " as es  where (p.personal_id = es.personal_id) and p.personal_id in(".$executive_persons_id.")";
	$sql_query .= " UNION select p.personal_id,pub.publication_id as type_id,p.first_name,p.last_name,'Publication' as person_tigger_name,pub.publication_date as add_date,'' as company_name,'' as start_date  from " 
	.TABLE_PERSONAL_MASTER. " as p, "
	.TABLE_EXECUTIVE_PUBLICATION. " as pub  where (p.personal_id = pub.personal_id) and p.personal_id in(".$executive_persons_id.")";
	$sql_query .= " UNION select p.personal_id,med.mm_id as type_id,p.first_name,p.last_name,'Media Mention' as person_tigger_name,med.pub_date as add_date,'' as company_name,'' as start_date  from " 
	.TABLE_PERSONAL_MASTER. " as p, "
	.TABLE_EXECUTIVE_MEDIA_MENTION. " as med  where (p.personal_id = med.personal_id) and p.personal_id in(".$executive_persons_id.")";
	$sql_query .= " UNION select p.personal_id,app.appointment_id as type_id,p.first_name,p.last_name,'Appointment' as person_tigger_name,app.add_date as add_date,'' as company_name,'' as start_date  from " 
	.TABLE_PERSONAL_MASTER. " as p, "
	.TABLE_EXECUTIVE_APPOINTMENT. " as app  where (p.personal_id = app.personal_id) and p.personal_id in(".$executive_persons_id.")";
}
//echo $sql_query."<br><br>";
//die();
//$sql_query .= " UNION select cji.job_id as personal_id, cji.job_title as first_name,'' as last_name, 'Jobs' as person_tigger_name, '' as add_date 
//from " .TABLE_COMPANY_JOB_INFO." cji,". TABLE_COMPANY_MASTER . " as c where c.company_id = cji.company_id";

if($sql_query != '')
{
	$sql_query .= " UNION";
}


$sql_query .= " select cji.job_id as personal_id,'' as type_id, cji.job_title as first_name,'' as last_name, 'Jobs' as person_tigger_name, '' as add_date,c.company_name as company_name,'' as start_date  
from " .TABLE_COMPANY_EXECUTIVE_JOB_INFO." cji,". TABLE_COMPANY_MASTER . " as c where c.company_id = cji.company_id";

$sql_query .= " UNION select event_id as personal_id,'' as type_id,event_name as first_name,'' as last_name, 'Events' as person_tigger_name,'' as add_date,'' as company_name,event_start_date as start_date from ".TABLE_EVENTS." where demo_event=1";

$sql_query .= " order by add_date desc";

//echo $sql_query;
//die();


/***************** FOR PAGIN ***********************/
$starting_point = $items_per_page * ($p - 1);
/****************** END PAGIN ***********************/
$main_page = 'executive-demo-email.php';

$exe_query=com_db_query($sql_query);
$num_rows=com_db_num_rows($exe_query);
$total_data = $num_rows;

/************ FOR PAGIN **************/
$sql_query .= " LIMIT $starting_point,$items_per_page";
$exe_data = com_db_query($sql_query);

$numRows = com_db_num_rows($exe_data);
/************ END ********************/
$adminInfo = "select * from ". TABLE_ADMIN_SETTINGS ." where setting_id ='1'";
$adminResult = com_db_query($adminInfo);
$adminRow = com_db_fetch_array($adminResult);

$from_admin = $adminRow['site_email_from'];
$to_admin = $adminRow['site_email_address'];

$site_phone_number = com_db_output($adminRow['site_phone_number']);
$site_company_address = com_db_output($adminRow['site_company_address']);
$site_company_city  = com_db_output($adminRow['site_company_city']);
$site_company_state = com_db_output($adminRow['site_company_state']);
$site_company_zip = com_db_output($adminRow['site_company_zip']);
$pID = (isset($_GET['pID']) ? $_GET['pID'] : $select_data[0]);

if($action=='delete'){ 
	//echo "<br>within deletion case demo_email_type: ".$demo_email_type;
	$demo_email_type = $_GET['type'];
	if($demo_email_type == 'Board')
	{
		$perQueryDelete = "DELETE FROM ".TABLE_EXECUTIVE_BOARD." where board_id='".$pID."'";
		
	}
	if($demo_email_type == 'Award')
	{
		$perQueryDelete = "DELETE FROM ".TABLE_EXECUTIVE_AWARDS." where awards_id='".$pID."'";
		
	}
	if($demo_email_type == 'Speaking')
	{
		$perQueryDelete = "DELETE FROM ".TABLE_EXECUTIVE_SPEAKING." where speaking_id='".$pID."'";
		
	}
	if($demo_email_type == 'Publication')
	{
		$perQueryDelete = "DELETE FROM ".TABLE_EXECUTIVE_PUBLICATION." where publication_id='".$pID."'";
		//echo "<br>Pub Q: ".$perQueryDelete; 
		
	}
	if($demo_email_type == 'Media Mention')
	{
		$perQueryDelete = "DELETE FROM ".TABLE_EXECUTIVE_MEDIA_MENTION." where mm_id='".$pID."'";
		
	}
	if($demo_email_type == 'Jobs')
	{
		$perQueryDelete = "DELETE FROM ".TABLE_COMPANY_EXECUTIVE_JOB_INFO." where job_id='".$pID."'";
		
	}
	if($demo_email_type == 'Events')
	{
		$perQueryDelete = "DELETE FROM ".TABLE_EVENTS." where event_id='".$pID."'";
		
	}
	if($demo_email_type == 'Appointment')
	{
		$perQueryDelete = "DELETE FROM ".TABLE_EXECUTIVE_APPOINTMENT." where appointment_id='".$pID."'";
		
	}
	 //echo "<br>before deletion query";
	com_db_query($perQueryDelete);
	 //echo "<br>after deletion query";
	
	//$perQueryUpdate = "update ".TABLE_PERSONAL_MASTER." set executive_email =0, 	executive_tigger_name='' where personal_id='".$pID."'";
	//com_db_query($perQueryUpdate);
	com_redirect("executive-demo-email.php?selected_menu=demoemail&msg=" . msg_encode("Selected record deleted from Executive Demo Email"));
	
	
}

elseif($action =='DemoEmailCreate'){

	
	//echo "<pre>events_info: ";	print_r($events_info);	echo "</pre>";
	
	//die();
	
	//echo "<pre>FAR POST Data: ";	print_r($_POST);	echo "</pre>";
	//echo "<pre>FAR AID: ";	print_r($_POST['aid']);	echo "</pre>";
	//die();
	$persoanal_ids = "";
	//$all_personal_ids = array_merge($_POST['aid'], $_POST['bid'],$_POST['sid'],$_POST['pid'],$_POST['mid'],$_POST['appid']);
	if(sizeof($_POST['aid']) > 0)
	{
		$all_awards_ids = implode(",",$_POST['aid']);
		$aw_Query = "select group_concat(personal_id) as personal_id from ".TABLE_EXECUTIVE_AWARDS." where awards_id in (".$all_awards_ids.")";
		$aw_Result = com_db_query($aw_Query);
		$aw_Row = com_db_fetch_array($aw_Result);
		if($persoanal_ids == '')
			$persoanal_ids .= $aw_Row['personal_id'];
		else
			$persoanal_ids .= ",".$aw_Row['personal_id'];
	}
	if(sizeof($_POST['sid']) > 0)
	{
		$all_speaking_ids = implode(",",$_POST['sid']);
		$sp_Query = "select group_concat(personal_id) as personal_id from ".TABLE_EXECUTIVE_SPEAKING." where speaking_id in (".$all_speaking_ids.")";
		$sp_Result = com_db_query($sp_Query);
		$sp_Row = com_db_fetch_array($sp_Result);
		if($persoanal_ids == '')
			$persoanal_ids .= $sp_Row['personal_id'];
		else
			$persoanal_ids .= ",".$sp_Row['personal_id'];	
	}
	
	if(sizeof($_POST['bid']) > 0)
	{
		$all_board_ids = implode(",",$_POST['bid']);
		$bo_Query = "select group_concat(personal_id) as personal_id from ".TABLE_EXECUTIVE_BOARD." where board_id in (".$all_board_ids.")";
		$bo_Result = com_db_query($bo_Query);
		$bo_Row = com_db_fetch_array($bo_Result);
		if($persoanal_ids == '')
			$persoanal_ids .= $bo_Row['personal_id'];
		else
			$persoanal_ids .= ",".$bo_Row['personal_id'];	
	}
	if(sizeof($_POST['pid']) > 0)
	{
		$all_publication_ids = implode(",",$_POST['pid']);
		$pu_Query = "select group_concat(personal_id) as personal_id from ".TABLE_EXECUTIVE_PUBLICATION." where publication_id in (".$all_publication_ids.")";
		$pu_Result = com_db_query($pu_Query);
		$pu_Row = com_db_fetch_array($pu_Result);
		if($persoanal_ids == '')
			$persoanal_ids .= $pu_Row['personal_id'];
		else
			$persoanal_ids .= ",".$pu_Row['personal_id'];	
	}
	
	if(sizeof($_POST['mid']) > 0)
	{
		$all_media_ids = implode(",",$_POST['mid']);
		$me_Query = "select group_concat(personal_id) as personal_id from ".TABLE_EXECUTIVE_MEDIA_MENTION." where mm_id in (".$all_media_ids.")";
		$me_Result = com_db_query($me_Query);
		$me_Row = com_db_fetch_array($me_Result);
		if($persoanal_ids == '')
			$persoanal_ids .= $me_Row['personal_id'];
		else
			$persoanal_ids .= ",".$me_Row['personal_id'];	
	}
	
	if(sizeof($_POST['appid']) > 0)
	{
		$all_appointment_ids = implode(",",$_POST['appid']);
		$ap_Query = "select group_concat(personal_id) as personal_id from ".TABLE_EXECUTIVE_APPOINTMENT." where appointment_id in (".$all_appointment_ids.")";
		$ap_Result = com_db_query($ap_Query);
		$ap_Row = com_db_fetch_array($ap_Result);
		if($persoanal_ids == '')
			$persoanal_ids .= $ap_Row['personal_id'];
		else
			$persoanal_ids .= ",".$ap_Row['personal_id'];	
	}
	
	//$all_event_ids .= implode(",",$_POST['bid']);
	//$all_event_ids .= implode(",",$_POST['sid']);
	//$all_event_ids .= implode(",",$_POST['pid']);
	//$all_event_ids .= implode(",",$_POST['mid']);
	//$all_event_ids .= implode(",",$_POST['appid']);
	
	//, $_POST['bid'],$_POST['sid'],$_POST['pid'],$_POST['mid'],$_POST['appid']);
	//echo "<br>FAR all_event_ids : ".$persoanal_ids;
	//echo "<pre>FAR POST all_personal_ids: ";	print_r($all_personal_ids);	echo "</pre>";
	
	

	  $all_person_id = $persoanal_ids;
	  //echo "<br>all_person_id: ".$all_person_id;
	  //die();
	  $trigger = $_POST['selected_trigger'];
	  //$person_id = $_POST['persons_ids']; //$_POST['nid'];
	  //$all_person_id = implode(",",$person_id);
	  $tot_personID = sizeof($all_person_id);
	  
	  
	  
	  
	  //Image & Email check
	  $pfQuery = "select * from ".TABLE_PERSONAL_FILTER_ONOFF." where filter_onoff='ON'";
	  $pfResult = com_db_query($pfQuery);
	  $pfString='';
	  while($pfRow = com_db_fetch_array($pfResult)){
		  if($pfRow['filter_name']=='Personal Image Checking' &&  $pfRow['filter_onoff']=='ON'){
			  if($pfString==''){
				  $pfString = ' personal_image <> ""';
			  }else{
				  $pfString .= ' and personal_image <> ""';
			  }
		  }elseif($pfRow['filter_name']=='Personal Email Checking' &&  $pfRow['filter_onoff']=='ON'){
			 if($pfString==''){
				$pfString = ' (email<>"" and email<>"n/a" and email<>"N/A")';
			 }else{
				$pfString .= ' and (email<>"" and email<>"n/a" and email<>"N/A")';
			 }
		  }
	  }
	  
	  
	   // For events , getting event images to exists
			$event_id = $_POST['eid'];
			$all_event_id = implode(",",$event_id);
			$tot_eventID = sizeof($all_event_id);
			$events_info = array();
			//echo "<br>First all_event_id : ".$all_event_id;
	  
	  
		$job_id = $_POST['jid'];
			$all_job_id = implode(",",$job_id);
			$tot_jobID = sizeof($all_job_id);
	  
	  
	  
	  //echo "<br>FAR Before Person if block";
	  if(($tot_personID > 0 && $all_person_id != '') || ($all_event_id !='') || ($all_job_id !='')){ //echo "<br>FAR within if";
		  if($all_person_id !=''){
		  	$perQuery = "select first_name,last_name,email,personal_image,personal_id,demo_email,person_tigger_name,all_trigger_id,executive_tigger_name from ".TABLE_PERSONAL_MASTER." where personal_id in (".$all_person_id.")";
		  		  //echo "<br>FAR perQuery: ".$perQuery;
		  //die();
		  
		  $perResult = com_db_query($perQuery);
		 } 
		  //echo "<br>After query";
	  	  if($perResult){
			  $perNumRows = com_db_num_rows($perResult);
		  } 
		  $appointments_id_list='';
		  $awards_id_list='';
		  $board_id_list='';
		  $media_id_list='';
		  $publication_id_list='';
		  $speaking_id_list='';
		  $person_info = array();
		  $person_id_info = array();
		  $p=0;	
		  if($perNumRows>0){
			  
			  while($perRow = com_db_fetch_array($perResult)){
			  //echo "<br>perRow: ".$perRow['person_tigger_name'];
			  	//Appointments
				if($perRow['executive_tigger_name']=='Appointments'){
					if($appointments_id_list==''){
						$appointments_id_list = $perRow['all_trigger_id'];
					}else{
						$appointments_id_list .= ",".$perRow['all_trigger_id'];
					}
				}
				//Awards
				if($perRow['executive_tigger_name']=='Awards'){
				
				/*
					$sql_query = "select group_concat(p.personal_id) from " 
					.TABLE_PERSONAL_MASTER. " as p, "
					.TABLE_EXECUTIVE_AWARDS. " as aw where (p.personal_id = aw.personal_id) and personal_id in (".$all_person_id.")";
				*/
				
				
					/*if($awards_id_list==''){
						$awards_id_list=$perRow['all_trigger_id'];
					}else{
						$awards_id_list .= ",".$perRow['all_trigger_id'];
					}
					*/
				}
				//Board
				if($perRow['executive_tigger_name']=='Board'){
					if($board_id_list==''){
						$board_id_list=$perRow['all_trigger_id'];
					}else{
						$board_id_list .= ",".$perRow['all_trigger_id'];
					}
				}
				//Media Mention
				if($perRow['executive_tigger_name']=='Media Mention'){
					if($media_id_list==''){
						$media_id_list=$perRow['all_trigger_id'];
					}else{
						$media_id_list .= ",".$perRow['all_trigger_id'];
					}
				}
				//Publication
				if($perRow['executive_tigger_name']=='Publication'){
					if($publication_id_list==''){
						$publication_id_list=$perRow['all_trigger_id'];
					}else{
						$publication_id_list .= ",".$perRow['all_trigger_id'];
					}
				}
				//Speaking
				if($perRow['executive_tigger_name']=='Speaking'){
					if($speaking_id_list==''){
						$speaking_id_list=$perRow['all_trigger_id'];
					}else{
						$speaking_id_list .= ",".$perRow['all_trigger_id'];
					}
				}
				//
				  $person_id = $perRow['personal_id'];
				  $pFirstName = trim(com_db_output($perRow['first_name']));
				  $pLastName = trim(com_db_output($perRow['last_name']));	
				  $personalURL = trim($pFirstName).'_'.trim($pLastName).'_Exec_'.$person_id;
				  
				  $personal_image = $perRow['personal_image'];
				  if($personal_image !=''){
					  $personal_image_path = HTTPS_SITE_URL.'personal_photo/small/'.$personal_image;
				  }else{
					  $personal_image_path = HTTPS_SITE_URL.'personal_photo/small/no_image_information.png';
				  }
				  
				if(sizeof($person_id_info)==0){
					$person_id_info[] = $person_id;
					$personal_image = $perRow['personal_image'];
					if($personal_image !=''){
						$person_info[$p]['pimage'] = $personal_image;
					}else{
						$person_info[$p]['pimage'] = 'no_image_information.png';
					}
					$person_info[$p]['purl'] = $personalURL;
					$person_info[$p]['pname'] = substr($pFirstName.' '.$pLastName,0,12);
					$person_info[$p]['type'] = "Person";
					$p++;
				}elseif(!in_array ($person_id,$person_id_info)){
					$person_id_info[] = $person_id;
					$personal_image = $perRow['personal_image'];
					if($personal_image !=''){
						$person_info[$p]['pimage'] = $personal_image;
					}else{
						$person_info[$p]['pimage'] = 'no_image_information.png';
					}
					$person_info[$p]['purl'] = $personalURL;
					$person_info[$p]['pname'] = substr($pFirstName.' '.$pLastName,0,12);
					$person_info[$p]['type'] = "Person";
					$p++;
				}
			  }
		  }
		  
		  
			//echo "<br>all_job_id: ".$all_job_id;

			if($all_job_id !='')
			{
				$jobsPicQuery = "SELECT job_id,job_title,company_name,company_logo,cji.company_id,cji.source as source from
					".TABLE_COMPANY_EXECUTIVE_JOB_INFO." as cji,
					".TABLE_COMPANY_MASTER." as cm
					where cm.company_id = cji.company_id and cji.job_id in(". $all_job_id.")";
				//echo "<br>jobsPicQuery: ".$jobsPicQuery;
				
				$jobsPicResult = com_db_query($jobsPicQuery);		
				
				
				
				while($jobsPicRow = com_db_fetch_array($jobsPicResult))
				{
					
					$job_id = $jobsPicRow['job_id'];
					$job_company_id = $jobsPicRow['company_id'];
					$job_name = substr($jobsPicRow['job_title'],0,12); //$eventsPicRow['event_name'];
					
					$job_company_logo = $jobsPicRow['company_logo'];
					$job_company_name = $jobsPicRow['company_name'];
					$job_company_id = $jobsPicRow['company_id'];
					$source = $jobsPicRow['source'];
					
					//echo "<br>event_logo: ".$event_logo;		
					
					if($job_company_logo != '' && !in_array($job_company_id,$person_id_info))
					{
						//echo "<br>Updating personal array for events";
						$person_id_info[] = $job_company_id;
						$person_info[$p]['pimage'] = $job_company_logo;
						$person_info[$p]['pname'] = $job_name;
						
						$dim_url = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''), com_db_output($job_company_name)).'_Company_'.$job_company_id;
						
						$person_info[$p]['purl'] = $dim_url;
						$person_info[$p]['type'] = "Company";
						
						$org_personal_image_path = HTTPS_SITE_URL.'company_logo/org/'.$person_info[$p]['pimage'];
						$company_logo_resized = getImageXY($org_personal_image_path,80);
						
						$p++;
					}
				}
			}	
		  
		  
		 
			
			if($all_event_id !='')
			{
				$row_id = 0;
				$eventsPicQuery = "SELECT event_id,event_name,event_logo from ".TABLE_EVENTS." where event_id in(". $all_event_id.")";
				//echo "<br>eventsQuery: ".$eventsPicQuery;			
				$eventsPicResult = com_db_query($eventsPicQuery);	
				//$eventsPicRow = com_db_fetch_array($eventsPicResult);
				while($eventsPicRow = com_db_fetch_array($eventsPicResult))
				{
					
					$event_id = $eventsPicRow['event_id'];
					$event_name = substr($eventsPicRow['event_name'],0,12); //$eventsPicRow['event_name'];
					
					$event_logo = $eventsPicRow['event_logo'];
					
					//echo "<br>event_logo: ".$event_logo;		
					
					if($event_logo != '' && !in_array ($event_id,$person_id_info))
					{
						//echo "<br>Updating personal array for events";
						$person_id_info[] = $event_id;
						$person_info[$p]['pimage'] = $event_logo;
						$person_info[$p]['pname'] = $event_name;
						$person_info[$p]['purl'] = "Event";
						$person_info[$p]['type'] = "Event";
					
						//$events_info[$row_id]['title'] = $event_name;
						//$events_info[$row_id]['logo'] = $event_logo;
						//$row_id++;
					}
					$p++;
				}
				
			}
			
		  
		  //echo "<pre>person_info";	print_r($person_info);	echo "</pre>"; die();
		  	$totPerson = sizeof($person_info);
			//echo "<br>FAR tot person: ".$totPerson;
			//die();			
			$table1 = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>';
			for($q=0;$q<4;$q++){
				if($person_info[$q]['pname'] !=''){
					$table1 .='<td valign="top">
									<div class="img" style="font-size:0pt; line-height:0pt; text-align:left;width:80px;height:80px;position:relative;">';
									if($person_info[$q]['type'] == 'Event')
									{
										$table1 .='<img src="'.HTTPS_SITE_URL.'event_photo/small/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" height="80" /></div>';
										
									}
									elseif($person_info[$q]['type'] == 'Company')
									{
										//$table1 .='	<a href="'.HTTPS_SITE_URL.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTPS_SITE_URL.'company_logo/small/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" height="80" /></a></div>';
										$table1 .='	<a href="'.HTTPS_SITE_URL.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTPS_SITE_URL.'company_logo/small/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" style="position:absolute; margin:auto; top:0px; right:0px; bottom:0px; left:0px;" /></a></div>';
										
									}
									else
									{
										$table1 .='	<a href="'.HTTPS_SITE_URL.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTPS_SITE_URL.'personal_photo/small/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" height="80" /></a></div>';
										
									}
									$table1 .='<div class="thumb-name" style="color:#ffffff; font-family:Arial; font-size:11px; line-height:17px; text-align:center; background-color:#333333">'.$person_info[$q]['pname'].'</div>
									<div style="font-size:0pt; line-height:0pt; height:1px; background:#ffffff; "><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
								</td>
								<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"></td>';
				}else{
					$table1 .='<td valign="top">
									<div class="img" style="font-size:0pt; line-height:0pt; text-align:left;width:80px;">
										&nbsp;
									</div>
									<div class="thumb-name" style="color:#ffffff; font-family:Arial; font-size:11px; line-height:17px; text-align:center;>&nbsp;</div>
									<div style="font-size:0pt; line-height:0pt; height:1px; ">&nbsp;</div>
								</td>
								<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"></td>';
				}
			}
			$table1 .= '</tr>
					 </table>';
		   
		   $table2 = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>';
			for($q=4;$q<8;$q++){
				if($person_info[$q]['pname'] !=''){
					$table2 .='<td valign="top">
									<div class="img" style="font-size:0pt; line-height:0pt; text-align:left;width:80px;height:80px;position:relative;">';
									if($person_info[$q]['type'] == 'Event')
									{
										$table2 .='<img src="'.HTTPS_SITE_URL.'event_photo/small/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" height="80" />';
									}
									elseif($person_info[$q]['type'] == 'Company')
									{
										//$table2 .='<a href="'.HTTPS_SITE_URL.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTPS_SITE_URL.'company_logo/small/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" height="80" /></a>';
										$table2 .='<a href="'.HTTPS_SITE_URL.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTPS_SITE_URL.'company_logo/small/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80"  style="position:absolute; margin:auto; top:0px; right:0px; bottom:0px; left:0px;" /></a>';
									}
									else
									{
										$table2 .='<a href="'.HTTPS_SITE_URL.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTPS_SITE_URL.'personal_photo/small/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" height="80" /></a>';
									}									
									$table2 .='</div>
									<div class="thumb-name" style="color:#ffffff; font-family:Arial; font-size:11px; line-height:17px; text-align:center; background-color:#333333">'.$person_info[$q]['pname'].'</div>
									<div style="font-size:0pt; line-height:0pt; height:1px; background:#ffffff; "><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
								</td>
								<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"></td>';
				}else{
					$table2 .='<td valign="top">
									<div class="img" style="font-size:0pt; line-height:0pt; text-align:left;width:80px;">
										&nbsp;
									</div>
									<div class="thumb-name" style="color:#ffffff; font-family:Arial; font-size:11px; line-height:17px; text-align:center;>&nbsp;</div>
									<div style="font-size:0pt; line-height:0pt; height:1px; ">&nbsp;</div>
								</td>
								<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"></td>';
				}
			}
			$table2 .= '</tr>
					 </table>';	
			
			$table3 = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>';
			for($q=8;$q<12;$q++){
				if($person_info[$q]['pname'] !=''){
					$table3 .='<td valign="top">
									<div class="img" style="font-size:0pt; line-height:0pt; text-align:left;width:80px;height:80px;position:relative;">';
									if($person_info[$q]['type'] == 'Event')
									{	
										$table3 .='<img src="'.HTTPS_SITE_URL.'event_photo/small/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" height="80" />';
									}
									elseif($person_info[$q]['type'] == 'Company')
									{
										//$table3 .='<a href="'.HTTPS_SITE_URL.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTPS_SITE_URL.'company_logo/small/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" height="80" /></a>';
										$table3 .='<a href="'.HTTPS_SITE_URL.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTPS_SITE_URL.'company_logo/small/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80"  style="position:absolute; margin:auto; top:0px; right:0px; bottom:0px; left:0px;" /></a>';
									}
									else
									{
										$table2 .='<a href="'.HTTPS_SITE_URL.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTPS_SITE_URL.'personal_photo/small/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" height="80" /></a>';
									}
									$table3 .='</div>
									<div class="thumb-name" style="color:#ffffff; font-family:Arial; font-size:11px; line-height:17px; text-align:center; background-color:#333333">'.$person_info[$q]['pname'].'</div>
									<div style="font-size:0pt; line-height:0pt; height:1px; background:#ffffff; "><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
								</td>
								<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"></td>';
				}else{
					$table3 .='<td valign="top">
									<div class="img" style="font-size:0pt; line-height:0pt; text-align:left;width:80px;">
										&nbsp;
									</div>
									<div class="thumb-name" style="color:#ffffff; font-family:Arial; font-size:11px; line-height:17px; text-align:center;>&nbsp;</div>
									<div style="font-size:0pt; line-height:0pt; height:1px; ">&nbsp;</div>
								</td>
								<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"></td>';
				}
			}
			$table3 .= '</tr>
					 </table>';
		   
		   $table4 = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>';
			for($q=12;$q<16;$q++){
				if($person_info[$q]['pname'] !=''){
					$table4 .='<td valign="top">
									<div class="img" style="font-size:0pt; line-height:0pt; text-align:left;width:80px;height:80px;position:relative;">';
									if($person_info[$q]['type'] == 'Event')
									{
										$table3 .='<img src="'.HTTPS_SITE_URL.'event_photo/small/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" height="80" />';
									}	
									elseif($person_info[$q]['type'] == 'Company')
									{
										//$table3 .='<a href="'.HTTPS_SITE_URL.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTPS_SITE_URL.'company_logo/small/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" height="80" /></a>';
										$table3 .='<a href="'.HTTPS_SITE_URL.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTPS_SITE_URL.'company_logo/small/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80"  style="position:absolute; margin:auto; top:0px; right:0px; bottom:0px; left:0px;" /></a>';
									}
									else
									{
										$table3 .='<a href="'.HTTPS_SITE_URL.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTPS_SITE_URL.'personal_photo/small/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" height="80" /></a>';
									}									
									$table3 .='</div>
									<div class="thumb-name" style="color:#ffffff; font-family:Arial; font-size:11px; line-height:17px; text-align:center; background-color:#333333">'.$person_info[$q]['pname'].'</div>
									<div style="font-size:0pt; line-height:0pt; height:1px; background:#ffffff; "><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
								</td>
								<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"></td>';
				}else{
					$table4 .='<td valign="top">
									<div class="img" style="font-size:0pt; line-height:0pt; text-align:left;width:80px;">
										&nbsp;
									</div>
									<div class="thumb-name" style="color:#ffffff; font-family:Arial; font-size:11px; line-height:17px; text-align:center;>&nbsp;</div>
									<div style="font-size:0pt; line-height:0pt; height:1px; ">&nbsp;</div>
								</td>
								<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"></td>';
				}
			}
			$table4 .= '</tr>
					 </table>';			 		 
				
			
			if($totPerson<=8){
				$perImgName = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
								   <tr>
										<td valign="top" class="column">
											'.$table1.'
										</td>
										<td valign="top" class="column">
											'.$table2.'
										</td>
									</tr>
								</table>';
			}elseif($totPerson>8){
				$perImgName = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
								   <tr>
										<td valign="top" class="column">
											'.$table1.'
										</td>
										<td valign="top" class="column">
											'.$table2.'
										</td>
									</tr>
									<tr>
										<td valign="top" class="column">
											'.$table3.'
										</td>
										<td valign="top" class="column">
											'.$table4.'
										</td>
									</tr>
								</table>';
			}
			
			$person_image_name = '<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/box_top.jpg" alt="" border="0" width="660" height="5" /></div></div>
									<table width="100%" border="0" cellspacing="0" cellpadding="0" class="w320">
										<tr>
											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
											<td>
												<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#333333">
													<tr>
														<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="20">
                                                        	<div style="font-size:0pt; line-height:0pt; height:50px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="50" style="height:50px" alt="" /></div>
                                                            <div style="font-size:0pt; line-height:0pt; height:11px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="11" style="height:11px" alt="" /></div>
                                                         </td>
														<td class="h1" style="color:#ffffff; font-family:Arial; font-size:20px; line-height:24px; text-align:left; font-weight:normal"></td>
														<td align="right" width="200" class="btn-container2">
															
														</td>
														<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="10"></td>
													</tr>
												</table>
												
												<table width="100%" border="0" cellspacing="0" cellpadding="1" bgcolor="#ffffff" class="w320">
													<tr>
														<td>
														'.$perImgName.'
														</td>
													</tr>
												</table>
											</td>
											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
										</tr>
									</table>
									<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/box_bottom.jpg" alt="" border="0" width="660" height="5" /></div></div>';
	  }
	  
	  
	$email_alert_id  = time();
	$messageHead = '<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#eaeaea">
								<tr>
								  <td align="center" valign="top">
									<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" class="w320">
										<tr>
											<td align="center">
												<table width="650" border="0" cellspacing="0" cellpadding="0" class="w320">
													<tr>
														<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div style="font-size:0pt; line-height:0pt; height:45px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="45" style="height:45px" alt="" /></div></td>
														<td class="column2"><div class="top" style="color:#7a7a7a; font-family:Arial; font-size:11px; line-height:18px; text-align:left">Having trouble viewing this email? <a href="'.HTTPS_SITE_URL.'executive-demo-email-show.php?emailid='.$email_alert_id.'" target="_blank" class="link-top" style="color:#5c97d8; text-decoration:underline"><span class="link-top" style="color:#5c97d8; text-decoration:underline">View it in your browser</span></a></div></td>
														<td align="right" class="column2">
															<table border="0" cellspacing="0" cellpadding="0">
																<tr>
																	<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="8"><img src="'.HTTPS_SITE_URL.'images/bullet1.jpg" alt="" border="0" width="2" height="3" /></td>
																	<td class="top" style="color:#7a7a7a; font-family:Arial; font-size:11px; line-height:18px; text-align:left"><a href="'.HTTPS_SITE_URL.'executive-demo-email-show.php?emailid='.$email_alert_id.'" target="_blank" class="link-top" style="color:#5c97d8; text-decoration:underline"><span class="link-top" style="color:#5c97d8; text-decoration:underline">Online version</span></a></td>
																	<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="17"></td>	
																	<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="8"><img src="'.HTTPS_SITE_URL.'images/bullet1.jpg" alt="" border="0" width="2" height="3" /></td>
																	<td class="top" style="color:#7a7a7a; font-family:Arial; font-size:11px; line-height:18px; text-align:left"><a href="mailto:<Please enter your friend email id?subject=Congrats&amp;body=Congrats%20on%20your%20recent%20appointment" target="_blank" class="link-top" style="color:#5c97d8; text-decoration:underline"><span class="link-top" style="color:#5c97d8; text-decoration:underline">Forward to a friend</span></a></td>
																</tr>
															</table>
														</td>
														<td class="mobile-space" style="font-size:0pt; line-height:0pt; text-align:left"></td>
													</tr>
												</table>
												<div style="font-size:0pt; line-height:0pt; height:1px; background:#cfcfcf; "><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
						
											</td>
										</tr>
									</table>
									<div style="font-size:0pt; line-height:0pt; height:30px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="30" style="height:30px" alt="" /></div>
						
									<table width="100%" border="0" cellspacing="0" cellpadding="0" class="w320">
										<tr>
											<td align="center">
												<table width="650" border="0" cellspacing="0" cellpadding="0" class="w320">
													<tr>
														<td class="img" style="font-size:0pt; line-height:0pt; text-align:left"><a href="'.HTTPS_SITE_URL.'index.php" target="_blank"><img src="'.HTTPS_SITE_URL.'images/executive-alert-logo.jpg" width="267" height="25" alt="" border="0" /></a></td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
									<div style="font-size:0pt; line-height:0pt; height:30px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="30" style="height:30px" alt="" /></div>
									<table width="100%" border="0" cellspacing="0" cellpadding="0" class="w320">
										<tr>
											<td align="center">
												<table width="660" border="0" cellspacing="0" cellpadding="0" class="w320">
													<tr>
														<td align="center">';
	$from_admin = com_db_GetValue("select site_email_from from ".TABLE_ADMIN_SETTINGS ." where setting_id ='1'");
	$messageFooter = '
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>
										
										<div style="font-size:0pt; line-height:0pt; height:15px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="15" style="height:35px" alt="" /></div>
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td align="center" width="670" class="btn-container3">
													<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">
														<tr>
															<td>
																<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">
																	<tr>
																		<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1">
																			<div class="hide-for-mobile">
																				<div style="font-size:0pt; line-height:0pt; height:40px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="40" style="height:40px" alt="" /></div>
																			</div>
																			<div style="font-size:0pt; line-height:0pt;" class="mobile-br-40"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="0" alt="" /></div>
																		</td>
																		<td class="btn3" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="670"><span class="link2" style="color:#ffffff; text-decoration:none">This newsletter was sent to you by CIO Executive Updates</span></td>
																	</tr>
																</table>
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>
										<div style="font-size:0pt; line-height:0pt; height:35px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="35" style="height:35px" alt="" /></div>
			
										<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#333333" class="w320">
											<tr>
												<td class="footer" style="color:#adadad; font-family:Arial; font-size:12px; line-height:18px; text-align:center">
													<div class="hide-for-mobile">
														<div style="font-size:0pt; line-height:0pt; height:1px; background:#d2d2d2; "><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
							
														<div style="font-size:0pt; line-height:0pt; height:1px; background:#ffffff; "><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
							
													</div>
													<div style="font-size:0pt; line-height:0pt; height:30px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="30" style="height:30px" alt="" /></div>
							
													<strong style="font-size: 15px; line-height: 19px; color:#e0e0e0">Actionable Information Advisory Inc., '.$site_company_address.', '.$site_company_state.', '. $site_company_zip.'</strong>
													<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>
							
													This daily newsletter was sent to '.$from_admin.' from Company Name because you subscribed.<br />
													Rather not receive our newsletter anymore? <a href="mailto:unsub@ctosonthemove.com" target="_blank" class="link3-u" style="color:#adadad; text-decoration:underline"><span class="link3-u" style="color:#adadad; text-decoration:underline">Unsubscribe instantly</span></a>.
							
													<div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:50px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="50" style="height:50px" alt="" /></div></div>
													<div style="font-size:0pt; line-height:0pt;" class="mobile-br-25"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="0" alt="" /></div>
							
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>';	
	$triggers_name = $trigger;	
	//Appointments
	
	
	$appointment_id = $_POST['appid'];
	$all_appointment_id = implode(",",$appointment_id);
	$tot_speakingID = sizeof($all_appointment_id);
	if($all_appointment_id !=''){
	
		 //find one latest appointment of this user and then add those move_id
		$move_ids = "";
		foreach($appointment_id as $index => $app_id)
		{
			if($app_id != '')
			{
				$personal_query = "SELECT personal_id from ".TABLE_EXECUTIVE_APPOINTMENT." where appointment_id = ".$app_id;
				//echo "<br><br><br>personal_query :".$personal_query;
				$personal_result = com_db_query($personal_query);
				$personal_row = com_db_fetch_array($personal_result);
				//echo "<pre>"; print_r($personal_row); echo "</pre>";
				$personal_id = $personal_row['personal_id'];
				
				//echo "<br>personal_id :".$personal_id;
				
			}
			if($personal_id != '')
			{
				$movement_query = "SELECT move_id from ".TABLE_MOVEMENT_MASTER." where personal_id = ".$personal_id." order by move_id desc limit 0,1";
				//echo "<br>movement_query :".$movement_query;
				$movement_result = com_db_query($movement_query);
				$movement_row = com_db_fetch_array($movement_result);
				$move_ids .= $movement_row['move_id'].",";
				
				//echo "<br>move_ids :".$move_ids;
				
			}
			
			
		}
		
		if($move_ids != '')
			$move_ids = trim($move_ids,",");
				
		$app_query = "select mm.*,pm.first_name,pm.last_name,pm.email,pm.personal_image,cm.company_name from ".TABLE_MOVEMENT_MASTER." mm, ".TABLE_PERSONAL_MASTER." pm, ".TABLE_COMPANY_MASTER." cm, ".TABLE_EXECUTIVE_APPOINTMENT." a where (mm.company_id=cm.company_id and mm.personal_id=pm.personal_id and a.personal_id=pm.personal_id) and a.appointment_id in (".$all_appointment_id.") and mm.move_id in (".$move_ids.") order by move_id desc";	
		//echo "<br><br>app_query: ".$app_query;  
		$app_result = com_db_query($app_query);
		  if($app_result){
				$numRows = com_db_num_rows($app_result);
		  }
		  $cnt=1;
		  $messageSrt='';
		  $messageEmail='';	
		  //$effective_date_within_60day = date("Y-m-d",mktime(0,0,0,date("m"),(date("d")-60),date("Y"))); 
		  while($email_row = com_db_fetch_array($app_result)){
			  	
				  $person_id = $email_row['personal_id'];
				  $pFirstName = trim(com_db_output($email_row['first_name']));
				  $pLastName = trim(com_db_output($email_row['last_name']));	
				  $personalURL = trim($pFirstName).'_'.trim($pLastName).'_Exec_'.$person_id;
				  
				  //echo "<br>effective_date_within_60day: ".$effective_date_within_60day;
				  //echo "<br>movement_type: ".$email_row['movement_type'];
				  //echo "<br>title: ".$email_row['title'];
				  //echo "<br>company_name: ".$email_row['company_name'];
				  
				  if($email_row['effective_date'] > $effective_date_within_60day){ 
					  if($email_row['movement_type']==1){
						 $movement = ' was Appointed as ';
					  }elseif($email_row['movement_type']==2){
						  $movement = ' was Promoted to ';
					  }elseif($email_row['movement_type']==3){
						  $movement = ' Retired as ';
					  }elseif($email_row['movement_type']==4){
						  $movement = ' Resigned as '; 
					  }elseif($email_row['movement_type']==5){
						  $movement = ' was Terminated as ';
					  }elseif($email_row['movement_type']==6){
						  $movement = ' was Appointed to ';
					  }elseif($email_row['movement_type']==7){
						  $movement = ' Job Opening ';
					  }
					  
					  $heading = com_db_output($email_row['first_name'].' '.$email_row['last_name'].$movement.$email_row['title'].' at '.$email_row['company_name']);
					  $personal_image = $email_row['personal_image'];
					  if($personal_image !=''){
						  $personal_image_path = HTTPS_SITE_URL.'personal_photo/small/'.$personal_image;
					  }else{
						  $personal_image_path = HTTPS_SITE_URL.'personal_photo/small/no_image_information.png';
					  }
					  					  
					  if($email_row['more_link'] ==''){
							$messageSrt .='<table width="100%" border="0" cellspacing="0" cellpadding="20">
												<tr>
													<td>
														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTPS_SITE_URL.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>
																<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">
																	'.$heading.'
																	<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>
																	<table width="100%" border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td align="left">
																				<table border="0" cellspacing="0" cellpadding="0">
																					<tr>
																						<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTPS_SITE_URL.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>
																						<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
																						<td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>
																						<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"></td>
																						<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"></td>
																					</tr>
																				</table>
																			</td>
																		</tr>
																	</table>
																</td>
																<td align="right" width="170" class="btn-container">
																	<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">
																		<tr>
																			<td>
																				
																			</td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
											<div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>';
					  		
					  }else{
							$messageSrt .='<table width="100%" border="0" cellspacing="0" cellpadding="20">
												<tr>
													<td>
														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTPS_SITE_URL.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>
																<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">
																	'.$heading.'
																	<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>
																	<table width="100%" border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td align="left">
																				<table border="0" cellspacing="0" cellpadding="0">
																					<tr>
																						
																						<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.$email_row['more_link'].'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Source</span></a></td>
																						<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
																					</tr>
																				</table>
																			</td>
																		</tr>
																	</table>
																</td>
																<td align="right" width="170" class="btn-container">
																	<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">
																		<tr>
																			<td>
																				
																			</td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
											<div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>';
					  		
					  }
				  }
						
				}//end while
				if($messageSrt!=''){
					$message = '<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/box_top.jpg" alt="" border="0" width="660" height="5" /></div></div>
									<table width="100%" border="0" cellspacing="0" cellpadding="0" class="w320">
										<tr>
											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
											<td>
												<table width="100%" border="0" cellspacing="0" cellpadding="1" bgcolor="#c7c7c7">
													<tr>
														<td>
															<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
																<tr>
																	<td>
																		
																		<div style="font-size:0pt; line-height:0pt; height:1px; background:#4785ca; "><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>

																		<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#5f9bde">
																			<tr>
																				<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="20"><div style="font-size:0pt; line-height:0pt; height:50px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="50" style="height:50px" alt="" /></div>
																					<div style="font-size:0pt; line-height:0pt; height:4px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="4" style="height:4px" alt="" /></div>
																				</td>
																				<td class="h2" style="color:#ffffff; font-family:Arial; font-size:18px; line-height:22px; text-align:left; font-weight:bold">Appointments and Promotions</td>
																			</tr>
																		</table>
																		<div style="font-size:0pt; line-height:0pt; height:1px; background:#4785ca; "><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
																		'.$messageSrt.'
																	</td>
																</tr>
															</table>
														</td>
													</tr>
												</table>
											</td>
											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
										</tr>
									</table>
									<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/box_bottom.jpg" alt="" border="0" width="660" height="5" /></div></div>
									<div style="font-size:0pt; line-height:0pt; height:20px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="20" style="height:20px" alt="" /></div>';
				}
	}
	
	//for personal speaking 
	//echo "<br>speaking_id_list: ".$speaking_id_list;
	
	$speaking_id = $_POST['sid'];
	$all_speaking_id = implode(",",$speaking_id);
	$tot_speakingID = sizeof($all_speaking_id);
	
	//if($speaking_id_list !=''){
	if($all_speaking_id !=''){
		$psQuery = "select ps.*,pm.first_name,pm.last_name,pm.email,pm.personal_image from ".TABLE_PERSONAL_SPEAKING." ps, ".TABLE_PERSONAL_MASTER." pm where ps.personal_id=pm.personal_id and ps.event_date >'".date("Y-m-d")."' and ps.speaking_id in (".$speaking_id_list.") order by ps.add_date desc";	
		//echo "<br>psQuery: ".$psQuery;
		$psResult = com_db_query($psQuery);	
		if($psResult){
			$psNumRow = com_db_num_rows($psResult);	
			//echo "<br>psNumRow: ".$psNumRow;
			if($psNumRow>0){
				$message .='<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/box_top.jpg" alt="" border="0" width="660" height="5" /></div></div>
							<table width="100%" border="0" cellspacing="0" cellpadding="0" class="w320">
								<tr>
									<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
									<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
									<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
									<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
									<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
									<td>
										<table width="100%" border="0" cellspacing="0" cellpadding="1" bgcolor="#c7c7c7">
											<tr>
												<td>
												
													<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
														<tr>
															<td>
																
																<div style="font-size:0pt; line-height:0pt; height:1px; background:#4785ca; "><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
							
																<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#5f9bde">
																	<tr>
																		<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="20"><div style="font-size:0pt; line-height:0pt; height:50px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="50" style="height:50px" alt="" /></div>
																			<div style="font-size:0pt; line-height:0pt; height:4px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="4" style="height:4px" alt="" /></div>
																		</td>
																		<td class="h2" style="color:#ffffff; font-family:Arial; font-size:18px; line-height:22px; text-align:left; font-weight:bold">Speaking Engagements</td>
																	</tr>
																</table>';
				$sp=1;
				while($psRow = com_db_fetch_array($psResult)){
						$person_id = $psRow['personal_id'];
						$pFirstName = com_db_output($psRow['first_name']);
						$pLastName = com_db_output($psRow['last_name']);	
						$personalURL = trim($pFirstName).'_'.trim($pLastName).'_Exec_'.$person_id;
									
						$event_date = $psRow['event_date'];
						$edt = explode('-',$event_date);
						if($psRow['role']=='Speaker' || $psRow['role']=='Panelist'){
							$speakingRole = 'speak';
						}else{
							$speakingRole = $psRow['role'];
						}
						if($event_date=='0000-00-00'){
							$speaking = ' scheduled to '.$speakingRole.' at '.com_db_output($psRow['event']);
						}elseif($event_date > date("Y-m-d")){
							$speaking = ' scheduled to '.$speakingRole.' at '.com_db_output($psRow['event']).' on '.date("M j, Y",mktime(0,0,0,$edt[1],$edt[2],$edt[0]));
						}else{
							$speaking = ' scheduled to "' .$speakingRole.' at the '.com_db_output($psRow['event']);
						}
						$personal_image = $psRow['personal_image'];
						if($personal_image !=''){
						  $personal_image_path = HTTPS_SITE_URL.'personal_photo/small/'.$personal_image;
						}else{
						  $personal_image_path = HTTPS_SITE_URL.'personal_photo/small/no_image_information.png';
						}
						if($psRow['speaking_link'] !=''){
							$message .=' <div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
										<table width="100%" border="0" cellspacing="0" cellpadding="20">
											<tr>
												<td>
													<table width="100%" border="0" cellspacing="0" cellpadding="0">
														<tr>
															<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTPS_SITE_URL.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>
															<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">
																'.$pFirstName.' '.$pLastName.' '.$speaking.'
																<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>
	
																<table width="100%" border="0" cellspacing="0" cellpadding="0">
																	<tr>
																		<td align="left">
																			<table border="0" cellspacing="0" cellpadding="0">
																				<tr>
																					
																					<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.$psRow['speaking_link'].'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Source</span></a></td>
																					<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
																				</tr>
																			</table>
																		</td>
																	</tr>
																</table>
															</td>
															<td align="right" width="170" class="btn-container">
																<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">
																	<tr>
																		<td>
																			
																		</td>
																	</tr>
																</table>
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>';
							
						}else{
							$message .=' <div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
										<table width="100%" border="0" cellspacing="0" cellpadding="20">
											<tr>
												<td>
													<table width="100%" border="0" cellspacing="0" cellpadding="0">
														<tr>
															<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTPS_SITE_URL.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>
															<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">
																'.$pFirstName.' '.$pLastName.' '.$speaking.'
																<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>
	
																<table width="100%" border="0" cellspacing="0" cellpadding="0">
																	<tr>
																		<td align="left">
																			<table border="0" cellspacing="0" cellpadding="0">
																				<tr>
																					<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTPS_SITE_URL.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>
																					<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
																					<td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>
																					<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"></td>
																					<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"></td>
																				</tr>
																			</table>
																		</td>
																	</tr>
																</table>
															</td>
															<td align="right" width="170" class="btn-container">
																<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">
																	<tr>
																		<td>
																			
																		</td>
																	</tr>
																</table>
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>';
							
						}
					$sp++;
				}
				
			$message .=' 	</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
							</tr>
						</table>
						<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/box_bottom.jpg" alt="" border="0" width="660" height="5" /></div></div>
						<div style="font-size:0pt; line-height:0pt; height:20px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="20" style="height:20px" alt="" /></div>';
			
			}
		 }
	}
	//echo "<br>message: ".$message; die();
	
	$media_id = $_POST['mid'];
	$all_media_id = implode(",",$media_id);
	$tot_mediaID = sizeof($all_media_id);
	
	if($all_media_id !=''){
		$pmmQuery = "select pmm.*,pm.first_name,pm.last_name,pm.email,pm.personal_image from ".TABLE_EXECUTIVE_MEDIA_MENTION." pmm, ".TABLE_PERSONAL_MASTER." pm where pmm.personal_id=pm.personal_id and pmm.mm_id in (".$all_media_id.") order by pmm.add_date desc";	
		$pmmResult = com_db_query($pmmQuery);	
		if($pmmResult){
		$pmmNumRow = com_db_num_rows($pmmResult);	
		if($pmmNumRow>0){
			$message .='<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/box_top.jpg" alt="" border="0" width="660" height="5" /></div></div>
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="w320">
							<tr>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
								<td>
									<table width="100%" border="0" cellspacing="0" cellpadding="1" bgcolor="#c7c7c7">
										<tr>
											<td>
												<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
													<tr>
														<td>
														
															<div style="font-size:0pt; line-height:0pt; height:1px; background:#4785ca; "><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
						
															<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#5f9bde">
																<tr>
																	<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="20"><div style="font-size:0pt; line-height:0pt; height:50px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="50" style="height:50px" alt="" /></div>
																	<div style="font-size:0pt; line-height:0pt; height:4px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="4" style="height:4px" alt="" /></div>
																	</td>
																	<td class="h2" style="color:#ffffff; font-family:Arial; font-size:18px; line-height:22px; text-align:left; font-weight:bold">Media Mentions</td>
																</tr>
															</table>';
															
				$med=1;
				while($pmmRow = com_db_fetch_array($pmmResult)){
					$person_id = $pmmRow['personal_id'];
					$pFirstName = com_db_output($pmmRow['first_name']);
					$pLastName = com_db_output($pmmRow['last_name']);	
					$personalURL = trim($pFirstName).'_'.trim($pLastName).'_Exec_'.$person_id;
					$pub_date = $pmmRow['pub_date'];
					$pdt = explode('-',$pub_date);
					if($pub_date=='0000-00-00'){
						$media_mention = ' was quoted by '.com_db_output($pmmRow['publication']);
					}elseif($pub_date < date("Y-m-d")){
						$media_mention = ' was quoted by '.com_db_output($pmmRow['publication']).' on '.date("M j, Y",mktime(0,0,0,$pdt[1],$pdt[2],$pdt[0]));
					}else{
						$media_mention = ' is "' .com_db_output($pmmRow['quote']).'" by '.com_db_output($pmmRow['publication']);
					}
					$personal_image = $pmmRow['personal_image'];
					if($personal_image !=''){
					  $personal_image_path = HTTPS_SITE_URL.'personal_photo/small/'.$personal_image;
					}else{
					  $personal_image_path = HTTPS_SITE_URL.'personal_photo/small/no_image_information.png';
					}
					if($pmmRow['media_link'] !=''){
						$message .=	'<div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
									 <table width="100%" border="0" cellspacing="0" cellpadding="20">
										<tr>
											<td>
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTPS_SITE_URL.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>
														<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">
															'.$pFirstName.' '.$pLastName.' '.$media_mention.'
															<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>

															<table width="100%" border="0" cellspacing="0" cellpadding="0">
																<tr>
																	<td align="left">
																		<table border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				
																				<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.$pmmRow['media_link'].'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Source</span></a></td>
																				<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
																			</tr>
																		</table>
																	</td>
																</tr>
															</table>
														</td>
														<td align="right" width="170" class="btn-container">
															<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">
																<tr>
																	<td>
																		
																	</td>
																</tr>
															</table>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>';
						
					}else{
						$message .=	'<div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
									 <table width="100%" border="0" cellspacing="0" cellpadding="20">
										<tr>
											<td>
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTPS_SITE_URL.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>
														<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">
															'.$pFirstName.' '.$pLastName.' '.$media_mention.'
															<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>

															<table width="100%" border="0" cellspacing="0" cellpadding="0">
																<tr>
																	<td align="left">
																		<table border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTPS_SITE_URL.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>
																				<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
																				<td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>
																				<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"></td>
																				<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"></td>
																			</tr>
																		</table>
																	</td>
																</tr>
															</table>
														</td>
														<td align="right" width="170" class="btn-container">
															<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">
																<tr>
																	<td>
																		
																	</td>
																</tr>
															</table>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>';
					}
				
				$med++;
				}
			$message .=' 								</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
							</tr>
						</table>
						<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/box_bottom.jpg" alt="" border="0" width="660" height="5" /></div></div>
						
						<div style="font-size:0pt; line-height:0pt; height:20px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="20" style="height:20px" alt="" /></div>';	
			
			}
		}
	}
	//for personal Industry Awards
	$award_id = $_POST['aid'];
	$all_award_id = implode(",",$award_id);
	$tot_awardID = sizeof($all_award_id);
	if($all_award_id !=''){
	$paQuery = "select pa.*,pm.first_name,pm.last_name,pm.email,pm.personal_image from ".TABLE_EXECUTIVE_AWARDS." pa, ".TABLE_PERSONAL_MASTER." pm where pa.personal_id=pm.personal_id and pa.awards_id in (".$all_award_id.") order by pa.add_date desc";	
	//echo "<br>Awards Query: ";
	$paResult = com_db_query($paQuery);	
	//if($awards_id_list !=''){		
	if($paResult){		
		//$paQuery = "select pa.*,pm.first_name,pm.last_name,pm.email,pm.personal_image from ".TABLE_PERSONAL_AWARDS." pa, ".TABLE_PERSONAL_MASTER." pm where pa.personal_id=pm.personal_id and pa.awards_id in (".$awards_id_list.") order by pa.add_date desc";	
		//$paResult = com_db_query($paQuery);	
		//if($paResult){
		$paNumRow = com_db_num_rows($paResult);	
		//echo "<br>paNumRow: ".$paNumRow; die();
		if($paNumRow>0){
			$message .='<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/box_top.jpg" alt="" border="0" width="660" height="5" /></div></div>
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="w320">
						<tr>
							<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
							<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
							<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
							<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
							<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
							<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="1" bgcolor="#c7c7c7">
									<tr>
										<td>
											<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
												<tr>
													<td>
														
														<div style="font-size:0pt; line-height:0pt; height:1px; background:#4785ca; "><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
						
														<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#5f9bde">
															<tr>
																<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="20"><div style="font-size:0pt; line-height:0pt; height:50px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="50" style="height:50px" alt="" /></div>
																<div style="font-size:0pt; line-height:0pt; height:4px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="4" style="height:4px" alt="" /></div>
																</td>
																<td class="h2" style="color:#ffffff; font-family:Arial; font-size:18px; line-height:22px; text-align:left; font-weight:bold">Industry Awards</td>
															</tr>
														</table>';

			$ind=1;
			while($paRow = com_db_fetch_array($paResult)){
					$person_id = $paRow['personal_id'];
					$pFirstName = com_db_output($paRow['first_name']);
					$pLastName = com_db_output($paRow['last_name']);	
					$personalURL = trim($pFirstName).'_'.trim($pLastName).'_Exec_'.$person_id;
					$awards_date = $paRow['awards_date'];
					$adt = explode('-',$awards_date);
					$personal_image = $paRow['personal_image'];
					if($personal_image !=''){
					  $personal_image_path = HTTPS_SITE_URL.'personal_photo/small/'.$personal_image;
					}else{
					  $personal_image_path = HTTPS_SITE_URL.'personal_photo/small/no_image_information.png';
					}
					$awards = ' received a "'.com_db_output($paRow['awards_title']).'" award from '.com_db_output($paRow['awards_given_by']);
					
					if($paRow['awards_link'] !=''){
						$message .='<div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
									<table width="100%" border="0" cellspacing="0" cellpadding="20">
									<tr>
										<td>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTPS_SITE_URL.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>
													<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">
														'.$pFirstName.' '.$pLastName.' '.$awards.'
														<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>

														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td align="left">
																	<table border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			
																			<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.$paRow['awards_link'].'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Source</span></a></td>
																			<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
													<td align="right" width="170" class="btn-container">
														<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">
															<tr>
																<td>
																	
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>';
						
					}else{
						$message .='<div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
									<table width="100%" border="0" cellspacing="0" cellpadding="20">
									<tr>
										<td>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTPS_SITE_URL.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>
													<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">
														'.$pFirstName.' '.$pLastName.' '.$awards.'
														<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>

														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td align="left">
																	<table border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTPS_SITE_URL.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>
																			<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
																			<td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>
																			<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"></td>
																			<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"></td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
													<td align="right" width="170" class="btn-container">
														<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">
															<tr>
																<td>
																	
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>';
					}
					
				$ind++;	
				}
				
			$message .=' </td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
							<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
							<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
							<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
							<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
							<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
						</tr>
						</table>
						<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/box_bottom.jpg" alt="" border="0" width="660" height="5" /></div></div>
						
						<div style="font-size:0pt; line-height:0pt; height:20px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="20" style="height:20px" alt="" /></div>';	
			
			}
		//}
	}
	}
	//for personal publication
	$publication_id = $_POST['pid'];
	$all_publication_id = implode(",",$publication_id);
	$tot_publicationID = sizeof($all_publication_id);
	
	//if($publication_id_list !=''){
	if($all_publication_id !=''){
		$ppQuery = "select pp.*,pm.first_name,pm.last_name,pm.email,pm.personal_image from ".TABLE_EXECUTIVE_PUBLICATION." pp, ".TABLE_PERSONAL_MASTER." pm where pp.personal_id=pm.personal_id and pp.publication_id in (".$all_publication_id.") order by pp.add_date desc";	
		$ppResult = com_db_query($ppQuery);	
		if($ppResult){
		$ppNumRow = com_db_num_rows($ppResult);	
		if($ppNumRow>0){
			$message .='<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/box_top.jpg" alt="" border="0" width="660" height="5" /></div></div>
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="w320">
							<tr>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
								<td>
									<table width="100%" border="0" cellspacing="0" cellpadding="1" bgcolor="#c7c7c7">
										<tr>
											<td>
												<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
													<tr>
														<td>
															
															<div style="font-size:0pt; line-height:0pt; height:1px; background:#4785ca; "><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
						
															<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#5f9bde">
																<tr>
																	<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="20"><div style="font-size:0pt; line-height:0pt; height:50px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="50" style="height:50px" alt="" /></div>
																	<div style="font-size:0pt; line-height:0pt; height:4px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="4" style="height:4px" alt="" /></div>
																	</td>
																	<td class="h2" style="color:#ffffff; font-family:Arial; font-size:18px; line-height:22px; text-align:left; font-weight:bold">Publications</td>
																</tr>
															</table>';
	  
			
			$pub=1;												
			while($ppRow = com_db_fetch_array($ppResult)){
				$person_id = $ppRow['personal_id'];
				$pFirstName = com_db_output($ppRow['first_name']);
				$pLastName = com_db_output($ppRow['last_name']);	
				$personalURL = trim($pFirstName).'_'.trim($pLastName).'_Exec_'.$person_id;
				
				$publication = ' wrote "'.com_db_output($ppRow['title']).'"';
				$personal_image = $ppRow['personal_image'];
				if($personal_image !=''){
				  $personal_image_path = HTTPS_SITE_URL.'personal_photo/small/'.$personal_image;
				}else{
				  $personal_image_path = HTTPS_SITE_URL.'personal_photo/small/no_image_information.png';
				}
				if($ppRow['link'] !=''){
					$message .=' <div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
								<table width="100%" border="0" cellspacing="0" cellpadding="20">
									<tr>
										<td>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTPS_SITE_URL.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>
													<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">
														'.$pFirstName.' '.$pLastName.' '.$publication.'
														<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>

														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td align="left">
																	<table border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			
																			<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.$ppRow['link'].'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Source</span></a></td>
																			<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
													<td align="right" width="170" class="btn-container">
														<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">
															<tr>
																<td>
																	
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>';
				}else{
					$message .=' <div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
								 <table width="100%" border="0" cellspacing="0" cellpadding="20">
									<tr>
										<td>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTPS_SITE_URL.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>
													<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">
														'.$pFirstName.' '.$pLastName.' '.$publication.'
														<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>

														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td align="left">
																	<table border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTPS_SITE_URL.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>
																			<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
																			<td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>
																			<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"></td>
																			<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"></td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
													<td align="right" width="170" class="btn-container">
														<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">
															<tr>
																<td>
																	
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>';
				}
			$pub++;	
			}
		$message .=' 	</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
						<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
						<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
						<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
						<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
						<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
					</tr>
				</table>
				<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/box_bottom.jpg" alt="" border="0" width="660" height="5" /></div></div>
				
				<div style="font-size:0pt; line-height:0pt; height:20px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="20" style="height:20px" alt="" /></div>';
		}
	 }
	}
	//for personal Board Appointments
	
	$board_id = $_POST['bid'];
	$all_board_id = implode(",",$board_id);
	$tot_boardID = sizeof($all_board_id);
	
	if($all_board_id !=''){
		$pbQuery = "select pb.*,pm.first_name,pm.last_name,pm.email,pm.personal_image from ".TABLE_EXECUTIVE_BOARD." pb, ".TABLE_PERSONAL_MASTER." pm where pb.personal_id=pm.personal_id and pb.board_id in (".$all_board_id.") order by pb.add_date desc";	
		$pbResult = com_db_query($pbQuery);	
		if($pbResult){
		$pbNumRow = com_db_num_rows($pbResult);	
		if($pbNumRow>0){
			$message .='<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/box_top.jpg" alt="" border="0" width="660" height="5" /></div></div>
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="w320">
							<tr>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
								<td>
									<table width="100%" border="0" cellspacing="0" cellpadding="1" bgcolor="#c7c7c7">
										<tr>
											<td>
												<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
													<tr>
														<td>
															<div style="font-size:0pt; line-height:0pt; height:1px; background:#4785ca; "><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
															<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#5f9bde">
																<tr>
																	<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="20"><div style="font-size:0pt; line-height:0pt; height:50px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="50" style="height:50px" alt="" /></div>
																	<div style="font-size:0pt; line-height:0pt; height:4px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="4" style="height:4px" alt="" /></div>
																	</td>
																	<td class="h2" style="color:#ffffff; font-family:Arial; font-size:18px; line-height:22px; text-align:left; font-weight:bold">Board Appointments</td>
																</tr>
															</table>';
			
			$app=1;																				
			while($pbRow = com_db_fetch_array($pbResult)){
				$person_id = $pbRow['personal_id'];
				$pFirstName = com_db_output($pbRow['first_name']);
				$pLastName = com_db_output($pbRow['last_name']);	
				$personalURL = trim($pFirstName).'_'.trim($pLastName).'_Exec_'.$person_id;
				
				$boards = ' was appointed as a member of "'.com_db_output($pbRow['board_info']).'"';
				$personal_image = $pbRow['personal_image'];
				if($personal_image !=''){
				  $personal_image_path = HTTPS_SITE_URL.'personal_photo/small/'.$personal_image;
				}else{
				  $personal_image_path = HTTPS_SITE_URL.'personal_photo/small/no_image_information.png';
				}
				if($pbRow['board_link'] !=''){
					$message .='<div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
								<table width="100%" border="0" cellspacing="0" cellpadding="20">
									<tr>
										<td>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTPS_SITE_URL.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>
													<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">
														'.$pFirstName.' '.$pLastName.' '.$boards.'
														<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>

														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td align="left">
																	<table border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			
																			<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.$pbRow['board_link'].'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Source</span></a></td>
																			<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
													<td align="right" width="170" class="btn-container">
														<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">
															<tr>
																<td>
																	
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>';
				}else{
					$message .='<div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
								<table width="100%" border="0" cellspacing="0" cellpadding="20">
									<tr>
										<td>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTPS_SITE_URL.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>
													<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">
														'.$pFirstName.' '.$pLastName.' '.$boards.'
														<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>

														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td align="left">
																	<table border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTPS_SITE_URL.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>
																			<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
																			<td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>
																			<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"></td>
																			<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"></td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
													<td align="right" width="170" class="btn-container">
														<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">
															<tr>
																<td>
																	
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>';
				}
			$app++;	
			}
		$message .=' 								</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
							<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
							<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
							<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
							<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
							<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
						</tr>
					</table>
					<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/box_bottom.jpg" alt="" border="0" width="660" height="5" /></div></div>
					
					<div style="font-size:0pt; line-height:0pt; height:20px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="20" style="height:20px" alt="" /></div>';	
		}
		
	 }	
	}
	
	
	
	//FA - for jobs STARTS

	  
	  $messageJob = "";
	 // echo "<br>all_job_id: ".$all_job_id;	
	  if($all_job_id !=''){
		$jobsQuery = "SELECT job_id,job_title,company_name,company_logo,cji.company_id,cji.source as source from
					".TABLE_COMPANY_EXECUTIVE_JOB_INFO." as cji,
					".TABLE_COMPANY_MASTER." as cm
					where cm.company_id = cji.company_id and cji.job_id in(". $all_job_id.")";
					
			//echo "<br>jobsQuery: ".$jobsQuery;		
		$jobsResult = com_db_query($jobsQuery);	
		if($jobsResult){
		$jobsNumRow = com_db_num_rows($jobsResult);	
		//echo "<br>jobsNumRow: ".$jobsNumRow;	die();	
		if($jobsNumRow>0){
			$messageJob .='<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/box_top.jpg" alt="" border="0" width="660" height="5" /></div></div>
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="w320">
							<tr>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
								<td>
									<table width="100%" border="0" cellspacing="0" cellpadding="1" bgcolor="#c7c7c7">
										<tr>
											<td>
												<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
													<tr>
														<td>
															<div style="font-size:0pt; line-height:0pt; height:1px; background:#4785ca; "><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
															<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#5f9bde">
																<tr>
																	<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="20"><div style="font-size:0pt; line-height:0pt; height:50px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="50" style="height:50px" alt="" /></div>
																	<div style="font-size:0pt; line-height:0pt; height:4px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="4" style="height:4px" alt="" /></div>
																	</td>
																	<td class="h2" style="color:#ffffff; font-family:Arial; font-size:18px; line-height:22px; text-align:left; font-weight:bold">Jobs</td>
																</tr>
															</table>';
			
			$appJob=1;																				
			while($jobRow = com_db_fetch_array($jobsResult)){
			//echo "<br>In job look";
				$job_id = $jobRow['job_id'];
				$jobTitle = com_db_output($jobRow['job_title']);
				//$jobDescription = com_db_output($jobRow['description']);	
				$companyName = com_db_output($jobRow['company_name']);	
				$companyID = com_db_output($jobRow['company_id']);	
				$company_logo = com_db_output($jobRow['company_logo']);	
				$source = com_db_output($jobRow['source']);	
				
				$dim_url = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''), $companyName).'_Company_'.$companyID;
				//echo '<li><a href="'.HTTP_SERVER.$dim_url.'">'.str_replace('&','&amp;',$list_row['company_name']).'</a></li>';
				
				
				$personalURL = '';
				//$personalURL = trim($pFirstName).'_'.trim($pLastName).'_Exec_'.$person_id;
				
				//$boards = ' was appointed as a member of "'.com_db_output($pbRow['board_info']).'"';
				//$personal_image = $jobRow['personal_image'];
				//if($company_logo !=''){
				//	$personal_image_path = '<a href="'.HTTPS_SITE_URL.$dim_url.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a>';
				  //$personal_image_path = HTTPS_SITE_URL.'company_logo/small/'.$company_logo;
				//}else{
				//	$personal_image_path = "";
				  //$personal_image_path = HTTPS_SITE_URL.'company_logo/small/no_image_information.png';
				//}
				//if($pbRow['board_link'] !=''){
					$messageJob .='<div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
								<table width="100%" border="0" cellspacing="0" cellpadding="20">
									<tr>
										<td>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr>';
												
												if($company_logo !=''){
													$personal_image_path = HTTPS_SITE_URL.'company_logo/small/'.$company_logo;
													
													$org_personal_image_path = HTTPS_SITE_URL.'company_logo/org/'.$company_logo;
													$company_logo_resized = getImageXY($org_personal_image_path,80);
													//$messageJob .='<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTPS_SITE_URL.$dim_url.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>';
													$messageJob .='<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTPS_SITE_URL.$dim_url.'" target="_blank">"'.$company_logo_resized.'"</a></td>';
												}	
												else
												{
													$messageJob .='<td style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105">&nbsp;</td>';
												}												
													
													$messageJob .='<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">
														'.$companyName.' is looking to hire '.$jobTitle.'
														<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>

														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td align="left">
																	<table border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			
																			<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.$source.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Source</span></a></td>
																			<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
													
													
													
													
													
												</tr>
											</table>
										</td>
									</tr>
								</table>';
				//}
			$appJob++;	
			}
		$messageJob .=' 								</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
							<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
							<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
							<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
							<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
							<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
						</tr>
					</table>
					<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/box_bottom.jpg" alt="" border="0" width="660" height="5" /></div></div>
					
					<div style="font-size:0pt; line-height:0pt; height:20px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="20" style="height:20px" alt="" /></div>';	
		}
		
	 }				
					
	}
	//echo "<br>messageJob: ".$messageJob; die();
	// for jobs ENDS
	
	
	
	//FA - for events STARTS
		//echo "<br>Second all_event_id : ".$all_event_id;
	  
	  $messageEvent = "";
	  if($all_event_id !=''){
		$eventsQuery = "SELECT * from
					".TABLE_EVENTS." where event_id in(". $all_event_id.")";
					
		//echo "<br>eventsQuery: ".$eventsQuery;			
		$eventsResult = com_db_query($eventsQuery);	
		
		
		
		if($eventsResult){
		$eventsNumRow = com_db_num_rows($eventsResult);	
		
		//echo "<br>eventsNumRow: ".$eventsNumRow;
		
		if($eventsNumRow>0){
			$messageEvent .='<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/box_top.jpg" alt="" border="0" width="660" height="5" /></div></div>
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="w320">
							<tr>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
								<td>
									<table width="100%" border="0" cellspacing="0" cellpadding="1" bgcolor="#c7c7c7">
										<tr>
											<td>
												<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
													<tr>
														<td>
															<div style="font-size:0pt; line-height:0pt; height:1px; background:#4785ca; "><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
															<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#5f9bde">
																<tr>
																	<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="20"><div style="font-size:0pt; line-height:0pt; height:50px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="50" style="height:50px" alt="" /></div>
																	<div style="font-size:0pt; line-height:0pt; height:4px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="4" style="height:4px" alt="" /></div>
																	</td>
																	<td class="h2" style="color:#ffffff; font-family:Arial; font-size:18px; line-height:22px; text-align:left; font-weight:bold">Conferences and Forums</td>
																</tr>
															</table>';
			
			$appEvent=1;																				
			while($eventRow = com_db_fetch_array($eventsResult)){
			//echo "<br>In job look";
				$event_id = $eventRow['event_id'];
				$eventName = com_db_output($eventRow['event_name']);
				
				$pdt = explode('-',$eventRow['event_start_date']);
				$event_date = 	$pdt[1].'/'.$pdt[2].'/'.$pdt[0];
				
				$eventLocation = com_db_output($eventRow['event_location']);	
				$eventLogo = com_db_output($eventRow['event_logo']);	
				$eventSource = com_db_output($eventRow['event_source']);	
				
				
				
				$personalURL = '';
				
					$messageEvent .='<div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
								<table width="100%" border="0" cellspacing="0" cellpadding="20">
									<tr>
										<td>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr>';
												$event_image_path = "";
												if($eventLogo !=''){
													$event_image_path = HTTPS_SITE_URL.'event_photo/small/'.$eventLogo;
													$messageEvent .='<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><img src="'.$event_image_path.'" alt="" border="0" width="81" height="81" /></td>';
												}	
												else
												{
													$messageEvent .='<td style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105">&nbsp;</td>';
												}												
													
													$messageEvent .='<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">
														'.$eventName.' will take place in '.$eventLocation.' on '.$event_date.'
														<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>

														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td align="left">
																	<table border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			
																			<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.$eventSource.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Source</span></a></td>
																			<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
													
													
													
													
													
												</tr>
											</table>
										</td>
									</tr>
								</table>';
				//}
			$appEvent++;	
			}
		$messageEvent .=' 								</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
							<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
							<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
							<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
							<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
							<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
						</tr>
					</table>
					<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/box_bottom.jpg" alt="" border="0" width="660" height="5" /></div></div>
					
					<div style="font-size:0pt; line-height:0pt; height:20px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="20" style="height:20px" alt="" /></div>';	
		}
		
	 }				
					
	}
	//echo "<br>messageEvent: ".$messageEvent;
	// for events ENDS
	
	
	
	
	
	  $message = $messageHead.$person_image_name.$message.$messageJob.$messageEvent.$messageFooter;
	  $demoEmail = com_db_input($message);
	  $emailDetails = com_db_input($message);
	  $email_id = $email_alert_id;
	  $add_date = date("Y-m-d");
	  $all_person_id = implode(",", $person_id_info);
	  $demoEmailQuery = "INSERT INTO " . TABLE_EXECUTIVE_DEMO_EMAIL_INFO . "(all_move_id, all_person_id, sent_email, email_details,email_id,triggers_name,add_date) values('".$all_move_id."','". $all_person_id."','$demoEmail','$emailDetails','$email_id','$triggers_name','".$add_date."')";	
	  com_db_query($demoEmailQuery);
	  com_redirect("executive-demo-email.php?selected_menu=demoemail&msg=" . msg_encode("Demo Email Successfully created"));

}
	
include("includes/header.php");
?>

<script type="text/javascript">

function CheckAll(numRows){
	var st = parseInt(<?=($starting_point+1)?>);
	var end = parseInt(<?=($starting_point+$items_per_page)?>);
	if(document.getElementById('all').checked){
		for(i=st; i<=end; i++){
			var person_id='person_id-'+ i;
			var job_id='job_id-'+ i;
			var event_id='event_id-'+ i;
			
			var board_id = 'board_id-'+ i;
			var award_id = 'award_id-'+ i;
			var speaking_id = 'speaking_id-'+ i;
			var publication_id = 'publication_id-'+ i;
			var media_id = 'media_id-'+ i;
			var appointment_id = 'appointment_id-'+ i;
			
			
			if(document.getElementById(person_id))
				document.getElementById(person_id).checked=true;
			else
			if(document.getElementById(job_id))
				document.getElementById(job_id).checked=true;
			else
			if(document.getElementById(event_id))
				document.getElementById(event_id).checked=true;	
				
			
			
			else
			if(document.getElementById(board_id))
				document.getElementById(board_id).checked=true;	
			else
			if(document.getElementById(award_id))
				document.getElementById(award_id).checked=true;		
			else
			if(document.getElementById(speaking_id))
				document.getElementById(speaking_id).checked=true;	
			else
			if(document.getElementById(publication_id))
				document.getElementById(publication_id).checked=true;	
			else
			if(document.getElementById(media_id))
				document.getElementById(media_id).checked=true;	
			else
			if(document.getElementById(appointment_id))
				document.getElementById(appointment_id).checked=true;			
				
		}
	} else {
		for(i=st; i<=end; i++){
			var person_id='person_id-'+ i;
			var job_id='job_id-'+ i;
			var event_id='event_id-'+ i;
			
			var board_id = 'board_id-'+ i;
			var award_id = 'award_id-'+ i;
			var speaking_id = 'speaking_id-'+ i;
			var publication_id = 'publication_id-'+ i;
			var media_id = 'media_id-'+ i;
			var appointment_id = 'appointment_id-'+ i;
			
			if(document.getElementById(person_id))
				document.getElementById(person_id).checked=false;
			else
			if(document.getElementById(job_id))
				document.getElementById(job_id).checked=false;
			else
			if(document.getElementById(event_id))
				document.getElementById(event_id).checked=false;	

			else
			if(document.getElementById(board_id))
				document.getElementById(board_id).checked=false;
			else
			if(document.getElementById(award_id))
				document.getElementById(award_id).checked=false;
			else
			if(document.getElementById(speaking_id))
				document.getElementById(speaking_id).checked=false;
			else
			if(document.getElementById(publication_id))
				document.getElementById(publication_id).checked=false;
			else
			if(document.getElementById(media_id))
				document.getElementById(media_id).checked=false;
			else
			if(document.getElementById(appointment_id))
				document.getElementById(appointment_id).checked=false;		
		}
	}
}


// Get object/associative array of URL parameters
function getSearchParameters () {
  var prmstr = window.location.search.substr(1);
  return prmstr !== null && prmstr !== "" ? transformToAssocArray(prmstr) : {};
}

// convert parameters from url-style string to associative array
function transformToAssocArray (prmstr) {
  var params = {},
      prmarr = prmstr.split("&");

  for (var i = 0; i < prmarr.length; i++) {
    var tmparr = prmarr[i].split("=");
    params[tmparr[0]] = tmparr[1];
  }
  return params;
}



function AllRecored(numRows){

	var flg=0;
	
	var uriParams = getSearchParameters();
	var this_page = uriParams.p;
	if(this_page > 1)
	{
		var initial_val = 20*(this_page-1)+1;  //$items_per_page * ($p - 1);
		numRows = numRows+initial_val;
	}
	else
		var initial_val = 1;
	
	//alert("Initila val : "+initial_val);
	for(i=initial_val; i<=numRows; i++){ 
	
			
			var person_id='person_id-'+ i;
			var job_id='job_id-'+ i;
			var event_id='event_id-'+ i;
			
			
			var board_id = 'board_id-'+ i;
			var award_id = 'award_id-'+ i;
			var speaking_id = 'speaking_id-'+ i;
			var publication_id = 'publication_id-'+ i;
			var media_id = 'media_id-'+ i;
			var appointment_id = 'appointment_id-'+ i;
			
			//alert("Job Id: "+job_id);
			//alert(document.getElementById(job_id).checked);
			if(document.getElementById(person_id) && document.getElementById(person_id).checked){
				flg=1;
			}	
			else
			if(document.getElementById(job_id) && document.getElementById(job_id).checked){
				flg=1;
			}
			else
			if(document.getElementById(event_id) && document.getElementById(event_id).checked){
				flg=1;
			}
			
			else
			if(document.getElementById(board_id) && document.getElementById(board_id).checked){
				flg=1;
			}
			else
			if(document.getElementById(award_id) && document.getElementById(award_id).checked){
				flg=1;
			}
			else
			if(document.getElementById(speaking_id) && document.getElementById(speaking_id).checked){
				flg=1;
			}
			else
			if(document.getElementById(publication_id) && document.getElementById(publication_id).checked){
				flg=1;
			}
			else
			if(document.getElementById(media_id) && document.getElementById(media_id).checked){
				flg=1;
			}
			else
			if(document.getElementById(appointment_id) && document.getElementById(appointment_id).checked){
				flg=1;
			}
			
		}
	if(flg==0){
		alert("Please checked atleast one checkbox for delete.");
		document.getElementById('person_id-1').focus();
		return false;
	} else {
		var agree=confirm("Selected person will be demo email. \n Do you want to continue?");
		if (agree)
			 document.topicform.submit();
		else
			window.location = "executive-demo-email.php?selected_menu=demoemail";
	}	

}

function confirm_del(nid,p,type){
	var agree=confirm("Person will be deleted from Demo email. \n Do you want to continue?");
	if (agree){
		window.location = "executive-demo-email.php?selected_menu=demoemail&pID=" + nid + "&p=" + p + "&action=delete&type="+type;
	}else{
		window.location = "executive-demo-email.php?selected_menu=demoemail&pID=" + nid + "&p=" + p ;
	}
}
</script>

 <tr>
    <td align="left" valign="top" bgcolor="#FFFFFF">
	<table width="975" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
		<?php
		include("includes/menu_left.php");
		?>
		<td width="10" align="left" valign="top">&nbsp;</td>
        <td width="769" align="left" valign="top">

<?php if(($action == '') || $action == 'save'){	?>			

		<form name="topicform" action="executive-demo-email.php?action=DemoEmailCreate&selected_menu=demoemail" method="post">
		<input type="hidden" name="persons_ids" id="persons_ids" value="<?=$executive_persons_id?>">
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
          <tr>
            <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="31%" align="left" valign="middle" class="heading-text">Executives Demo Email Manager</td>
                  <td width="50%" align="left" valign="middle" class="message"><?=$msg?></td>
                  <td width="19%" align="left" valign="middle"><input type="button" value="Generate Executive Demo Email" onclick="AllRecored('<?=$numRows?>');" ></td>
                </tr>
              </table></td>
          </tr>
       
          <tr>
            <td align="left" valign="top" class="right-bar-content-border">
			<table width="100%" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="22" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-title-text">#</span></td>
				<td width="20" height="30" align="center" valign="middle" class="right-border">
				<input type="checkbox" name="all" id="all" onclick="CheckAll('<?=$numRows?>');" /></td>
				<td width="110" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Person Name</span> </td>
                <td width="127" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Engagement Triggers</span> </td>
                <td width="84" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Add Date</span> </td>
                <td width="67" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Action</span> </td>
			  </tr>
			<?php
			$jobs_row = 0;
			$events_row = 0;
			if($total_data>0) {
				$i=$starting_point+1;
				$select_trigger='';
				while ($data_sql = com_db_fetch_array($exe_data)) {
				$add_date = $data_sql['add_date'];
				
				if($data_sql['person_tigger_name'] == 'Jobs')
				{
					if($jobs_row == 0)
					{
						?>
						
						<tr>
				<td width="22" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-title-text"></span></td>
				<td width="20" height="30" align="center" valign="middle" class="right-border">
				&nbsp;</td>
				<td width="110" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Job Title</span> </td>
                <td width="127" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Engagement Triggers</span> </td>
                <td width="84" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Company Name</span> </td>
                <td width="67" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Action</span> </td>
			  </tr>
						
						
						<?PHP
						$jobs_row++;
					}
				?>
				<tr>
				<td height="30" align="center" valign="middle" class="right-border-left"><?=$i;?></td>
				<td height="30" align="center" valign="middle" class="right-border"><input type="checkbox" id="job_id-<?=$i;?>" name="jid[]" value="<?=$data_sql['personal_id'];?>" /></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><?=com_db_output($data_sql['first_name'])?></td>
                <td height="30" align="left" valign="middle" class="right-border-text">Jobs</td>
				<td height="30" align="center" valign="middle" class="right-border"><?=com_db_output($data_sql['company_name'])?></td>
                <td height="30" align="center" valign="middle" class="right-border"><a href="#"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" title="Delete" border="0" onclick="confirm_del('<?=$data_sql['personal_id'];?>','<?=$p;?>','Jobs')" /></a><br />
						  Delete</td>
         	</tr> 
				<?PHP
				}
				elseif($data_sql['person_tigger_name'] == 'Events')
				{
					if($events_row == 0)
					{
				?>
				
				<tr>
				<td width="22" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-title-text">#</span></td>
				<td width="20" height="30" align="center" valign="middle" class="right-border">
				</td>
				<td width="110" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Event Name</span> </td>
                <td width="127" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Engagement Triggers</span> </td>
                <td width="84" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Start Date</span> </td>
                <td width="67" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Action</span> </td>
			  </tr>
				
				
				<?PHP
					$events_row++;
					}
					?>
					
					
					<tr>
				<td height="30" align="center" valign="middle" class="right-border-left"><?=$i;?></td>
				<td height="30" align="center" valign="middle" class="right-border"><input type="checkbox" id="event_id-<?=$i;?>" name="eid[]" value="<?=$data_sql['personal_id'];?>" /></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><?=com_db_output($data_sql['first_name'])?></td>
                <td height="30" align="left" valign="middle" class="right-border-text">Events</td>
				<td height="30" align="center" valign="middle" class="right-border"><?=com_db_output($data_sql['start_date'])?></td>
                <td height="30" align="center" valign="middle" class="right-border"><a href="#"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" title="Delete" border="0" onclick="confirm_del('<?=$data_sql['personal_id'];?>','<?=$p;?>','Events')" /></a><br />
						  Delete</td>
         	</tr> 
					
					
					
					<?PHP
				}
				else
				{
					
				
			?>          
			  <tr>
				<td height="30" align="center" valign="middle" class="right-border-left"><?=$i;?></td>
				<?PHP
				if($data_sql['person_tigger_name'] == 'Board')
				{
				?>
					<td height="30" align="center" valign="middle" class="right-border"><input type="checkbox" id="board_id-<?=$i;?>" name="bid[]" value="<?=$data_sql['type_id'];?>" /></td>
				<?PHP
				}
				
				elseif($data_sql['person_tigger_name'] == 'Award')
				{
				?>
					<td height="30" align="center" valign="middle" class="right-border"><input type="checkbox" id="award_id-<?=$i;?>" name="aid[]" value="<?=$data_sql['type_id'];?>" /></td>
				<?PHP
				}
				elseif($data_sql['person_tigger_name'] == 'Speaking')
				{
				?>
					<td height="30" align="center" valign="middle" class="right-border"><input type="checkbox" id="speaking_id-<?=$i;?>" name="sid[]" value="<?=$data_sql['type_id'];?>" /></td>
				<?PHP 
				}
				elseif($data_sql['person_tigger_name'] == 'Publication')
				{
				?>
					<td height="30" align="center" valign="middle" class="right-border"><input type="checkbox" id="publication_id-<?=$i;?>" name="pid[]" value="<?=$data_sql['type_id'];?>" /></td>
				<?PHP
				}
				elseif($data_sql['person_tigger_name'] == 'Media Mention')
				{
				?>
					<td height="30" align="center" valign="middle" class="right-border"><input type="checkbox" id="media_id-<?=$i;?>" name="mid[]" value="<?=$data_sql['type_id'];?>" /></td>
				<?PHP
				}
				elseif($data_sql['person_tigger_name'] == 'Appointment')
				{
				?>
					<td height="30" align="center" valign="middle" class="right-border"><input type="checkbox" id="appointment_id-<?=$i;?>" name="appid[]" value="<?=$data_sql['type_id'];?>" /></td>
				<?PHP
				}
				?>				
				<td height="30" align="left" valign="middle" class="right-border-text"><?=com_db_output($data_sql['first_name'].' '.$data_sql['last_name'])?></td>
                <td height="30" align="left" valign="middle" class="right-border-text"><?=com_db_output($data_sql['person_tigger_name'])?></td>
				<td height="30" align="center" valign="middle" class="right-border"><?=$add_date;?></td>
                <td height="30" align="center" valign="middle" class="right-border"><a href="#"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" title="Delete" border="0" onclick="confirm_del('<?=$data_sql['type_id'];?>','<?=$p;?>','<?=com_db_output($data_sql['person_tigger_name'])?>')" /></a><br />
						  Delete</td>
         	</tr> 
			<?php
				}
			$i++;
				}
			}
			?>

			
         </table> 
		</td>
          </tr>
        </table>
        </form>
		</td>
      </tr>
    </table></td>
  </tr>
 <tr>
    <td align="center" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
     
      <tr>
        <td width="666" align="right" valign="top"><table width="200" border="0" align="right" cellpadding="0" cellspacing="0">
          <tr>
		<?=number_pages($main_page, $p, $total_data, 8, $items_per_page,"&selected_menu=demoemail");?>		  
          </tr>
        </table></td>
        <td width="314" align="center" valign="bottom">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  
<?php }
include("includes/footer.php");
?>