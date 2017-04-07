<?php
require('includes/include_top.php');








//$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 20;
$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 2000;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';

//$sql_query .= " UNION select '' as personal_id, '' as first_name,'' as last_name, Jobs as person_tigger_name, '' as add_date, cji.*,c.company_name from " .TABLE_COMPANY_JOB_INFO." cji,". TABLE_COMPANY_MASTER . " as c order by c.company_id desc";

$sql_query = "select p.personal_id,p.first_name,p.last_name,p.person_tigger_name,p.add_date,'' as company_name,'' as company_id  from " . TABLE_PERSONAL_MASTER." p where p.demo_email=1 and p.person_tigger_name <>''";

//$sql_query .= " UNION select cji.job_id as personal_id, cji.job_title as first_name,'' as last_name, 'Jobs' as person_tigger_name, '' as add_date 
//from " .TABLE_COMPANY_JOB_INFO." cji,". TABLE_COMPANY_MASTER . " as c where c.company_id = cji.company_id";

$sql_query .= " UNION select cji.job_id as personal_id, cji.job_title as first_name,'' as last_name, 'Jobs' as person_tigger_name, '1935-05-05' as add_date,c.company_name as company_name, c.company_id as company_id 
from " .TABLE_COMPANY_JOB_INFO." cji,". TABLE_COMPANY_MASTER . " as c where c.company_id = cji.company_id and c.demo_job = 1";

$sql_query .= " UNION select cf.funding_id as personal_id, cf.funding_amount as first_name,'' as last_name, 'Funding' as person_tigger_name, '1930-05-05' as add_date,c.company_name as company_name,c.company_id as company_id
from " .TABLE_COMPANY_FUNDING." cf,". TABLE_COMPANY_MASTER . " as c where c.company_id = cf.company_id and c.demo_funding = 1";


$sql_query .= " order by add_date desc";

//echo $sql_query;
//die();
/***************** FOR PAGIN ***********************/
$starting_point = $items_per_page * ($p - 1);
/****************** END PAGIN ***********************/
$main_page = 'demo-email.php';

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



if($_REQUEST['multiple_del'] == 1)
{    
    //echo "<pre>nid: ";	print_r($_POST['nid']);	echo "</pre>";
    $action = "";
    $person_id_del = $_POST['nid'];
    $all_person_id_del = implode(",",$person_id_del);
    $tot_personID_del = sizeof($_POST['nid']);
    //echo "<br>tot_personID_del: ".$tot_personID_del;
    if($tot_personID_del > 0)
    {    
        for($p=0;$p<$tot_personID_del;$p++)
        {
            $perQueryUpdate = "update ".TABLE_PERSONAL_MASTER." set demo_email =0, 	person_tigger_name='',all_trigger_id = 0 where personal_id='".$person_id_del[$p]."'";
            com_db_query($perQueryUpdate);
        }
    }
    
    $job_id_del = $_POST['jid'];
    $all_job_id_del = implode(",",$job_id_del);
    $tot_jobID_del = sizeof($all_job_id_del);

    if($tot_jobID_del > 0)
    {    
        for($j=0;$j<$tot_jobID_del;$j++)
        {
            $query_del_job = com_db_query("select company_id from " . TABLE_COMPANY_JOB_INFO . " where job_id = '" . $job_id_del[$j] . "'");
            $data_del_job  = com_db_fetch_array($query_del_job);
            $company_id_del = com_db_output($data_del_job['company_id']);
            
            
            $jobQueryUpdate = "DELETE FROM ".TABLE_DEMO_JOB_INFO." where company_id='".$company_id_del."'";
            com_db_query($jobQueryUpdate);
            
            if($company_id_del != '')
            {    
                //delete_from_ctos($job_id_del[$j],$company_id_del,'job'); // funding_id , company_id
                if($type == 'funding')
		{
                    $result = mysql_query("DELETE from cto_company_funding_website where company_id = '".$company_id."' and funding_id = '".$funding_id."' and website='HR'",$cto);
		}
		if($type == 'job')
		{
                    $result = mysql_query("DELETE from cto_company_job_website where company_id = '".$company_id."' and website='HR'",$cto);
		}
                
                
                
            }    
        }
    }
    
    $funding_id_del = $_POST['fid'];
    $all_funding_id_del = implode(",",$funding_id_del);
    $tot_fundingID_del = sizeof($_POST['fid']);
    
    if($tot_fundingID_del > 0)
    {
        $funding_del_cto_arr = array();
        for($f=0;$f<$tot_fundingID_del;$f++)
        {
            $query_del_funding = com_db_query("select company_id from " . TABLE_COMPANY_FUNDING . " where funding_id = '" . $funding_id_del[$f] . "'");
            
            $data_del_funding  = com_db_fetch_array($query_del_funding);
            $company_id_del = com_db_output($data_del_funding['company_id']);
            
            if($company_id_del != '')
            {    
                $funding_del_cto_arr[$funding_id_del[$f]] = $company_id_del;
            }    
            
            $perQueryUpdate = "";
            $perQueryUpdate = "DELETE FROM ".TABLE_COMPANY_FUNDING." where funding_id='".$funding_id_del[$f]."'";
            
            com_db_query($perQueryUpdate);
            
        }
        $fund_del_cto_count = sizeof($funding_del_cto_arr);
        if($fund_del_cto_count > 0)
        {
            foreach($funding_del_cto_arr as $funding_id_cto => $comp_id_cto)
            {
                //delete_from_ctos($funding_id_cto,$comp_id_cto,'funding'); // funding_id , company_id
                if($type == 'funding')
		{
                    $result = mysql_query("DELETE from cto_company_funding_website where company_id = '".$company_id."' and funding_id = '".$funding_id."' and website='HR'",$cto);
		}
		if($type == 'job')
		{
                    $result = mysql_query("DELETE from cto_company_job_website where company_id = '".$company_id."' and website='HR'",$cto);
		}
            }
        }
    } 
    com_redirect("demo-email.php?selected_menu=demoemail&msg=" . msg_encode("Selected records are deleted"));
}



if($action=='delete'){

	$type = (isset($_GET['type']) ? $_GET['type'] : '');
	if($type == 'funding')
		$perQueryUpdate = "DELETE FROM ".TABLE_COMPANY_FUNDING." where funding_id='".$pID."'";
	elseif($type == 'job')
		$perQueryUpdate = "DELETE FROM ".TABLE_COMPANY_JOB_INFO." set demo_job =0 where company_id='".$pID."'";
	else		
		$perQueryUpdate = "update ".TABLE_PERSONAL_MASTER." set demo_email =0, 	person_tigger_name='',all_trigger_id = 0 where personal_id='".$pID."'";
	com_db_query($perQueryUpdate);
	com_redirect("demo-email.php?selected_menu=demoemail&msg=" . msg_encode("Selected Person delete from Demo Email"));
}elseif($action =='DemoEmailCreate'){


	//echo "<pre>REQ Data: ";	print_r($_REQUEST);	echo "</pre>";
	//echo "<pre>FAR UNDO POST Data: ";	print_r($_POST);	echo "</pre>";
	//die();



	  $trigger = $_POST['selected_trigger'];
	  $person_id = $_POST['nid'];
	  $all_person_id = implode(",",$person_id);
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
	  
		$job_id = $_POST['jid'];
		$all_job_id = implode(",",$job_id);
		$tot_jobID = sizeof($all_job_id);
	  
	  
		 $funding_id = $_POST['fid'];
	  $all_funding_id = implode(",",$funding_id);
	  $tot_fundingID = sizeof($all_funding_id);
	  
	  
		//echo "<br>all_person_id: ".$all_person_id;
	  
		if($tot_personID > 0 || ($all_job_id !='') || ($all_funding_id !='')){
		$perNumRows = 0;
		if($all_person_id != '')
		{
		  if($pfString==''){
			$perQuery = "select first_name,last_name,email,personal_image,personal_id,demo_email,person_tigger_name,all_trigger_id from ".TABLE_PERSONAL_MASTER." where personal_id in (".$all_person_id.")";
		  }else{
			$perQuery = "select first_name,last_name,email,personal_image,personal_id,demo_email,person_tigger_name,all_trigger_id from ".TABLE_PERSONAL_MASTER." where ".$pfString." and personal_id in (".$all_person_id.")";
		  }
		  //echo "<br>FAR perQuery: ".$perQuery;
		  //die();
		  
		  $perResult = com_db_query($perQuery);
		  if($perResult){
			  $perNumRows = com_db_num_rows($perResult);
		  }
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
				if($perRow['person_tigger_name']=='Appointments'){
					if($appointments_id_list==''){
						$appointments_id_list = $perRow['all_trigger_id'];
					}else{
						$appointments_id_list .= ",".$perRow['all_trigger_id'];
					}
				}
				//Awards
				if($perRow['person_tigger_name']=='Awards'){
					if($awards_id_list==''){
						$awards_id_list=$perRow['all_trigger_id'];
					}else{
						$awards_id_list .= ",".$perRow['all_trigger_id'];
					}
				}
				//Board
				if($perRow['person_tigger_name']=='Board'){
					if($board_id_list==''){
						$board_id_list=$perRow['all_trigger_id'];
					}else{
						$board_id_list .= ",".$perRow['all_trigger_id'];
					}
				}
				//Media Mention
				if($perRow['person_tigger_name']=='Media Mention'){
					if($media_id_list==''){
						$media_id_list=$perRow['all_trigger_id'];
					}else{
						$media_id_list .= ",".$perRow['all_trigger_id'];
					}
				}
				//Publication
				if($perRow['person_tigger_name']=='Publication'){
					if($publication_id_list==''){
						$publication_id_list=$perRow['all_trigger_id'];
					}else{
						$publication_id_list .= ",".$perRow['all_trigger_id'];
					}
				}
				//Speaking
				if($perRow['person_tigger_name']=='Speaking'){
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
					$p++;
				}
			  }
		  }
		  
		  //echo "<br>all_funding_id: ".$all_funding_id;
		  if($all_funding_id !='')
			{
				$fundingPicQuery = "SELECT funding_id,funding_amount,company_name,company_logo,cm.company_id,funding_date,funding_source from
					".TABLE_COMPANY_FUNDING." as cf,
					".TABLE_COMPANY_MASTER." as cm
					where cm.company_id = cf.company_id and cf.funding_id in(". $all_funding_id.")";
				//echo "<br>fundingPicQuery: ".$fundingPicQuery;
				$fundingPicResult = com_db_query($fundingPicQuery);		
				
				while($fundingPicRow = com_db_fetch_array($fundingPicResult))
				{
					
					$company_funding_id = $fundingPicRow['company_id'];
					$company_funding_name = substr($fundingPicRow['company_name'],0,12); //$eventsPicRow['event_name'];
					
					$company_funding_logo = $fundingPicRow['company_logo'];
					$company_funding_name_full = $fundingPicRow['company_name'];
					
					$source = $fundingPicRow['source'];
					
					//echo "<br>event_logo: ".$job_company_logo;		
					
					if($company_funding_logo != '' && !in_array ($company_funding_id,$person_id_info))
					{
						//echo "<br>Updating personal array for events";
						$person_id_info[] = $company_funding_id;
						$person_info[$p]['pimage'] = $company_funding_logo;
						$person_info[$p]['pname'] = $company_funding_name;
						
						$dim_url = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''), com_db_output($company_funding_name_full)).'_Company_'.$company_funding_id;
						
						$person_info[$p]['purl'] = $dim_url;
						$person_info[$p]['type'] = "Company";
						$p++;
					}
				}
			}
		  
		  
		  
			

			//echo "<br>all_job_id: ".$all_job_id;	
			
			if($all_job_id !='')
			{
				$jobsPicQuery = "SELECT job_id,job_title,company_name,company_logo,cji.company_id,cji.source as source from
					".TABLE_COMPANY_JOB_INFO." as cji,
					".TABLE_COMPANY_MASTER." as cm
					where cm.company_id = cji.company_id and cji.job_id in(". $all_job_id.")";
				$jobsPicResult = com_db_query($jobsPicQuery);		
				
				while($jobsPicRow = com_db_fetch_array($jobsPicResult))
				{
					
					$job_id = $jobsPicRow['company_id'];
					$job_name = substr($jobsPicRow['job_title'],0,12); //$eventsPicRow['event_name'];
					
					$job_company_logo = $jobsPicRow['company_logo'];
					$job_company_name = $jobsPicRow['company_name'];
					$job_company_id = $jobsPicRow['company_id'];
					$source = $jobsPicRow['source'];
					
					//echo "<br>event_logo: ".$job_company_logo;		
					
					if($job_company_logo != '' && !in_array ($job_id,$person_id_info))
					{
						//echo "<br>Updating personal array for events";
						$person_id_info[] = $job_id;
						$person_info[$p]['pimage'] = $job_company_logo;
						$person_info[$p]['pname'] = $job_name;
						
						$dim_url = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''), com_db_output($job_company_name)).'_Company_'.$job_company_id;
						
						$person_info[$p]['purl'] = $dim_url;
						$person_info[$p]['type'] = "Company";
						
						//company_logo/small/'.$person_info[$q]['pimage']
						
						//$personal_image_path = HTTPS_SITE_URL.'company_logo/small/'.$company_logo;
						
						
						$org_personal_image_path = HTTPS_SITE_URL.'company_logo/org/'.$person_info[$q]['pimage'];
						//$org_personal_image_path = $person_info[$q]['pimage'];
						//echo "<br>org_personal_image_path: ".$org_personal_image_path;
						
						
						$company_logo_resized = getImageXY($org_personal_image_path,80);
						
						$person_info[$q]['pimage'] = $company_logo_resized;
						$p++;
					}
				}
			}	
		  
		  //echo "<pre>FAR UNDO person_info: ";	print_r($person_info);	echo "</pre>";
		  
		  //die();
		  
		  
		  
		  	$totPerson = sizeof($person_info);
			//echo "<br>FAR tot person: ".$totPerson;
			//die();			
			$table1 = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>';
			for($q=0;$q<4;$q++){
				if($person_info[$q]['pname'] !=''){
					$table1 .='<td valign="top">
									<div class="img" style="font-size:0pt; line-height:0pt; text-align:left;width:80px;height:80px;position:relative;">';
										
									if($person_info[$q]['type'] == 'Company')
									{
										//$table1 .='<a href="'.HTTPS_SITE_URL.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTPS_SITE_URL.'company_logo/small/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" height="80" /></a>';
										$table1 .='<a href="'.HTTPS_SITE_URL.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTPS_SITE_URL.'company_logo/org/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" style="position:absolute; margin:auto; top:0px; right:0px; bottom:0px; left:0px;"  /></a>';
									}	
									else
										$table1 .='<a href="'.HTTPS_SITE_URL.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTPS_SITE_URL.'personal_photo/small/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" height="80" /></a>';
									$table1 .='</div>
									<div class="thumb-name" style="color:#ffffff; font-family:Arial; font-size:11px; line-height:17px; text-align:center; background-color:#333333">'.$person_info[$q]['pname'].'</div>
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
									if($person_info[$q]['type'] == 'Company')
									{
										//$table2 .='<a href="'.HTTPS_SITE_URL.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTPS_SITE_URL.'company_logo/small/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" height="80" /></a>';
										$table2 .='<a href="'.HTTPS_SITE_URL.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTPS_SITE_URL.'company_logo/org/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" style="position:absolute; margin:auto; top:0px; right:0px; bottom:0px; left:0px;" /></a>';
									}
									else
										$table2 .='<a href="'.HTTPS_SITE_URL.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTPS_SITE_URL.'personal_photo/small/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" height="80" /></a>';
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
									if($person_info[$q]['type'] == 'Company')
									{  
										//$table3 .='<a href="'.HTTPS_SITE_URL.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTPS_SITE_URL.'company_logo/small/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" height="80" /></a>';
										$table3 .='<a href="'.HTTPS_SITE_URL.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTPS_SITE_URL.'company_logo/org/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" style="position:absolute; margin:auto; top:0px; right:0px; bottom:0px; left:0px;" /></a>';
									}
									else
										$table3 .='<a href="'.HTTPS_SITE_URL.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTPS_SITE_URL.'personal_photo/small/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" height="80" /></a>';									
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
									if($person_info[$q]['type'] == 'Company')
									{
										//$table4 .='<a href="'.HTTPS_SITE_URL.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTPS_SITE_URL.'company_logo/small/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" height="80" /></a>';
										$table4 .='<a href="'.HTTPS_SITE_URL.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTPS_SITE_URL.'company_logo/org/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" style="position:absolute; margin:auto; top:0px; right:0px; bottom:0px; left:0px;" /></a>';
									}
									else
										$table4 .='<a href="'.HTTPS_SITE_URL.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTPS_SITE_URL.'personal_photo/small/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" height="80" /></a>';
									$table4 .='</div>
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
														<td class="h1" style="color:#ffffff; font-family:Arial; font-size:20px; line-height:24px; text-align:left; font-weight:normal">Reach out and engage your clients and prospects now:</td>
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
														<td class="column2"><div class="top" style="color:#7a7a7a; font-family:Arial; font-size:11px; line-height:18px; text-align:left">Having trouble viewing this email? <a rel="nofollow" href="'.HTTPS_SITE_URL.'demo-email-show.php?emailid='.$email_alert_id.'" target="_blank" class="link-top" style="color:#5c97d8; text-decoration:underline"><span class="link-top" style="color:#5c97d8; text-decoration:underline">View it in your browser</span></a></div></td>
														<td align="right" class="column2">
															<table border="0" cellspacing="0" cellpadding="0">
																<tr>
																	<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="8"><img src="'.HTTPS_SITE_URL.'images/bullet1.jpg" alt="" border="0" width="2" height="3" /></td>
																	<td class="top" style="color:#7a7a7a; font-family:Arial; font-size:11px; line-height:18px; text-align:left"><a href="'.HTTPS_SITE_URL.'demo-email-show.php?emailid='.$email_alert_id.'" target="_blank" class="link-top" style="color:#5c97d8; text-decoration:underline"><span class="link-top" style="color:#5c97d8; text-decoration:underline">Online version</span></a></td>
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
														<td class="img" style="font-size:0pt; line-height:0pt; text-align:left"><a href="'.HTTPS_SITE_URL.'index.php" target="_blank"><img src="'.HTTPS_SITE_URL.'images/email-alert-logo.jpg" width="267" height="25" alt="" border="0" /></a></td>
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
																		<td class="btn3" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="670"><a href="mailto:ctos_alerts@aweber.com?subject=free CIO alerts&body=please add me to the free CIO alert list"" target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none"></span></a></td>
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
							
													This newsletter was sent to you by CTOsOnTheMove.<br />
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
	if($appointments_id_list !=''){
		$app_query = "select mm.*,pm.first_name,pm.last_name,pm.email,pm.personal_image,cm.company_name from ".TABLE_MOVEMENT_MASTER." mm, ".TABLE_PERSONAL_MASTER." pm, ".TABLE_COMPANY_MASTER." cm where (mm.company_id=cm.company_id and mm.personal_id=pm.personal_id) and mm.move_id in (".$appointments_id_list.")";	
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
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">
																					<tr>
																						<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div></div>
																						<div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="0" alt="" /></div>
																						 </td>
																						<td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$email_row['email'].'?subject=Congrats&amp;body=Congrats on your appointment" target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>
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
																						<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTPS_SITE_URL.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>
																						<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
																						<td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>
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
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">
																					<tr>
																						<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div></div>
																						<div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="0" alt="" /></div>
																						 </td>
																						<td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$email_row['email'].'?subject=Congrats on your appointment" target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>
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
	if($speaking_id_list !=''){
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
							
                                                
                                                //echo "<br>personalURL: ".$personalURL;
                                                
                                                
                                                
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
						
						
						// Getting company name for this personal
						$speaker_company_name = "";
						$companyNameQuery = "SELECT cm.company_name from
						".TABLE_COMPANY_MASTER." as cm,
						".TABLE_MOVEMENT_MASTER." as mm,
						".TABLE_PERSONAL_MASTER." as pm
						where (cm.company_id = mm.company_id and mm.personal_id = pm.personal_id) and mm.personal_id = $person_id";
						//echo "<br><br>Query to get speker company:".$companyNameQuery;

						$cnResult = com_db_query($companyNameQuery);
						$cnRowsCount = com_db_num_rows($cnResult);	
						if($cnRowsCount > 0)
						{
							$cnRow = com_db_fetch_array($cnResult);
							$speaker_company_name = " (".$cnRow['company_name'].")";
						}
						//echo "<br>speaker_company_name:".$speaker_company_name;
						
						if($psRow['speaking_link'] !=''){
							$message .=' <div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
										<table width="100%" border="0" cellspacing="0" cellpadding="20">
											<tr>
												<td>
													<table width="100%" border="0" cellspacing="0" cellpadding="0">
														<tr>
															<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTPS_SITE_URL.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>
															<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">
																'.$pFirstName.' '.$pLastName.$speaker_company_name.' '.$speaking.'
																<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>
	
																<table width="100%" border="0" cellspacing="0" cellpadding="0">
																	<tr>
																		<td align="left">
																			<table border="0" cellspacing="0" cellpadding="0">
																				<tr>
																					<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTPS_SITE_URL.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>
																					<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
																					<td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>
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
																			<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">
																				<tr>
																					<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div>
																					</div><div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="0" alt="" /></div>
																					</td>
																					<td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$psRow['email'].'?subject=Congrats&amp;body=I noticed you are speaking at an industry event and decided to reach out." target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>
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
							
						}else{
							$message .=' <div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
										<table width="100%" border="0" cellspacing="0" cellpadding="20">
											<tr>
												<td>
													<table width="100%" border="0" cellspacing="0" cellpadding="0">
														<tr>
															<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTPS_SITE_URL.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>
															<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">
																'.$pFirstName.' '.$pLastName.$speaker_company_name.' '.$speaking.'
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
																			<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">
																				<tr>
																					<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div>
																					</div><div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="0" alt="" /></div>
																					</td>
																					<td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$psRow['email'].'?subject=I noticed you are speaking at an industry event and decided to reach out." target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>
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
	if($media_id_list !=''){
		$pmmQuery = "select pmm.*,pm.first_name,pm.last_name,pm.email,pm.personal_image from ".TABLE_PERSONAL_MEDIA_MENTION." pmm, ".TABLE_PERSONAL_MASTER." pm where pmm.personal_id=pm.personal_id and pmm.mm_id in (".$media_id_list.") order by pmm.add_date desc";	
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
						$media_mention = ' quoted "' .com_db_output($pmmRow['quote']).'" by '.com_db_output($pmmRow['publication']);
					}
					$personal_image = $pmmRow['personal_image'];
					if($personal_image !=''){
					  $personal_image_path = HTTPS_SITE_URL.'personal_photo/small/'.$personal_image;
					}else{
					  $personal_image_path = HTTPS_SITE_URL.'personal_photo/small/no_image_information.png';
					}
					
					// Getting company name for this personal
						$speaker_company_name = "";
						$companyNameQuery = "SELECT cm.company_name from
						".TABLE_COMPANY_MASTER." as cm,
						".TABLE_MOVEMENT_MASTER." as mm,
						".TABLE_PERSONAL_MASTER." as pm
						where (cm.company_id = mm.company_id and mm.personal_id = pm.personal_id) and mm.personal_id = $person_id";
						//echo "<br><br>Query to get speker company:".$companyNameQuery;

						$cnResult = com_db_query($companyNameQuery);
						$cnRowsCount = com_db_num_rows($cnResult);	
						if($cnRowsCount > 0)
						{
							$cnRow = com_db_fetch_array($cnResult);
							$speaker_company_name = " (".$cnRow['company_name'].")";
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
															'.$pFirstName.' '.$pLastName.$speaker_company_name.' '.$media_mention.'
															<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>

															<table width="100%" border="0" cellspacing="0" cellpadding="0">
																<tr>
																	<td align="left">
																		<table border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTPS_SITE_URL.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>
																				<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
																				<td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>
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
																		<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">
																			<tr>
																				<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div>
																				</div><div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="0" alt="" /></div>
																				</td>
																				<td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$pmmRow['email'].'?subject=Congrats&amp;body=I noticed you were recently quoted in media and decided to reach out." target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>
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
						
					}else{
						$message .=	'<div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
									 <table width="100%" border="0" cellspacing="0" cellpadding="20">
										<tr>
											<td>
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTPS_SITE_URL.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>
														<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">
															'.$pFirstName.' '.$pLastName.$speaker_company_name.' '.$media_mention.'
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
																		<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">
																			<tr>
																				<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div>
																				</div><div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="0" alt="" /></div>
																				</td>
																				<td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$pmmRow['email'].'?subject=I noticed you were recently quoted in media and decided to reach out." target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>
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
	if($awards_id_list !=''){		
		$paQuery = "select pa.*,pm.first_name,pm.last_name,pm.email,pm.personal_image from ".TABLE_PERSONAL_AWARDS." pa, ".TABLE_PERSONAL_MASTER." pm where pa.personal_id=pm.personal_id and pa.awards_id in (".$awards_id_list.") order by pa.add_date desc";	
		$paResult = com_db_query($paQuery);	
		if($paResult){
		$paNumRow = com_db_num_rows($paResult);	
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
																			<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTPS_SITE_URL.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>
																			<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
																			<td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>
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
																	<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">
																		<tr>
																			<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div>
																			</div><div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="0" alt="" /></div>
																			</td>
																			<td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$paRow['email'].'?subject=Congrats&amp;body=Congrats on your recent award" target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>
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
																	<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">
																		<tr>
																			<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div>
																			</div><div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="0" alt="" /></div>
																			</td>
																			<td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$paRow['email'].'?subject=Congrats&amp;body=Congrats on your recent award" target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>
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
		}
	}
	//for personal publication
	if($publication_id_list !=''){
		$ppQuery = "select pp.*,pm.first_name,pm.last_name,pm.email,pm.personal_image from ".TABLE_PERSONAL_PUBLICATION." pp, ".TABLE_PERSONAL_MASTER." pm where pp.personal_id=pm.personal_id and pp.publication_id in (".$publication_id_list.") order by pp.add_date desc";	
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
				
				// Getting company name for this personal
				$speaker_company_name = "";
				$companyNameQuery = "SELECT cm.company_name from
				".TABLE_COMPANY_MASTER." as cm,
				".TABLE_MOVEMENT_MASTER." as mm,
				".TABLE_PERSONAL_MASTER." as pm
				where (cm.company_id = mm.company_id and mm.personal_id = pm.personal_id) and mm.personal_id = $person_id";
				//echo "<br><br>Query to get speker company:".$companyNameQuery;

				$cnResult = com_db_query($companyNameQuery);
				$cnRowsCount = com_db_num_rows($cnResult);	
				if($cnRowsCount > 0)
				{
					$cnRow = com_db_fetch_array($cnResult);
					$speaker_company_name = " (".$cnRow['company_name'].")";
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
														'.$pFirstName.' '.$pLastName.$speaker_company_name.' '.$publication.'
														<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>

														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td align="left">
																	<table border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTPS_SITE_URL.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>
																			<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
																			<td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>
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
																	<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">
																		<tr>
																			<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div>
																			</div><div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="0" alt="" /></div>
																			</td>
																			<td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$ppRow['email'].'?subject=I saw you recent publication and decided to reach out" target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>
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
				}else{
					$message .=' <div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
								 <table width="100%" border="0" cellspacing="0" cellpadding="20">
									<tr>
										<td>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTPS_SITE_URL.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>
													<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">
														'.$pFirstName.' '.$pLastName.$speaker_company_name.' '.$publication.'
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
																	<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">
																		<tr>
																			<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div>
																			</div><div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="0" alt="" /></div>
																			</td>
																			<td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$ppRow['email'].'?subject=I saw you recent publication and decided to reach out" target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>
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
	if($board_id_list !=''){
		$pbQuery = "select pb.*,pm.first_name,pm.last_name,pm.email,pm.personal_image from ".TABLE_PERSONAL_BOARD." pb, ".TABLE_PERSONAL_MASTER." pm where pb.personal_id=pm.personal_id and pb.board_id in (".$board_id_list.") order by pb.add_date desc";	
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
				
				// Getting company name for this personal
				$speaker_company_name = "";
				$companyNameQuery = "SELECT cm.company_name from
				".TABLE_COMPANY_MASTER." as cm,
				".TABLE_MOVEMENT_MASTER." as mm,
				".TABLE_PERSONAL_MASTER." as pm
				where (cm.company_id = mm.company_id and mm.personal_id = pm.personal_id) and mm.personal_id = $person_id";
				//echo "<br><br>Query to get speker company:".$companyNameQuery;

				$cnResult = com_db_query($companyNameQuery);
				$cnRowsCount = com_db_num_rows($cnResult);	
				if($cnRowsCount > 0)
				{
					$cnRow = com_db_fetch_array($cnResult);
					$speaker_company_name = " (".$cnRow['company_name'].")";
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
														'.$pFirstName.' '.$pLastName.$speaker_company_name.' '.$boards.'
														<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>

														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td align="left">
																	<table border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTPS_SITE_URL.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>
																			<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
																			<td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>
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
																	<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">
																		<tr>
																			<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div>
																			</div><div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="0" alt="" /></div>
																			</td>
																			<td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$pbRow['email'].'?subject=Congrats&amp;body=Congrats on your recent Board appointment" target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>
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
				}else{
					$message .='<div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
								<table width="100%" border="0" cellspacing="0" cellpadding="20">
									<tr>
										<td>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTPS_SITE_URL.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>
													<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">
														'.$pFirstName.' '.$pLastName.$speaker_company_name.' '.$boards.'
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
																	<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">
																		<tr>
																			<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div>
																			</div><div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="0" alt="" /></div>
																			</td>
																			<td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$pbRow['email'].'?subject=Congrats on your recent Board appointment" target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>
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
	  if($all_job_id !=''){
		$jobsQuery = "SELECT job_id,job_title,company_name,company_logo,cji.company_id,cji.source as source from
					".TABLE_COMPANY_JOB_INFO." as cji,
					".TABLE_COMPANY_MASTER." as cm
					where cm.company_id = cji.company_id and cji.job_id in(". $all_job_id.")";
					
		//echo "<br>jobsQuery: ".$jobsQuery;			
		$jobsResult = com_db_query($jobsQuery);	
		if($jobsResult){
		$jobsNumRow = com_db_num_rows($jobsResult);	
		//echo "<br>jobsNumRow: ".$jobsNumRow;		
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
													//$t_width = 80;
													//$t_height = 80;
													//$thumb_image= $company_logo;
													//$destination_image = '../company_logo/demoemail/' . $company_logo;
													//make_thumb($destination_image, $thumb_image,$t_width,$t_height);
												
													//echo "<br>thumb_image: ".$thumb_image;
													//echo "<br>destination_image: ".$destination_image;
													//die();
													
													
													
													$personal_image_path = HTTPS_SITE_URL.'company_logo/small/'.$company_logo;
													
													$org_personal_image_path = HTTPS_SITE_URL.'company_logo/org/'.$company_logo;
													//echo "<br>org_personal_image_path: ".$org_personal_image_path;
													$company_logo_resized = getImageXY($org_personal_image_path,80);
													//echo "<br><br><br>company_logo_resized: ".$company_logo_resized;
													//die();
													//$messageJob .='<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="125"><a href="'.HTTPS_SITE_URL.$dim_url.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0"  /></a></td>';
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
																			<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTPS_SITE_URL.$dim_url.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>
																			<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
																			<td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>
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
	
	// for jobs ENDS
	
	
	
	
	//FA - for funding STARTS

	 
	  $messageFunding = "";
	  if($all_funding_id !=''){
		$fundingQuery = "SELECT funding_id,funding_amount,company_name,company_logo,cm.company_id,funding_date,funding_source from
					".TABLE_COMPANY_FUNDING." as cf,
					".TABLE_COMPANY_MASTER." as cm
					where cm.company_id = cf.company_id and cf.funding_id in(". $all_funding_id.")";
		//echo "<br>fundingQuery: ".$fundingQuery;			
					
		$fundingResult = com_db_query($fundingQuery);	
		if($fundingResult){
		$fundingNumRow = com_db_num_rows($fundingResult);	
		if($fundingNumRow>0){
			$messageFunding .='<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/box_top.jpg" alt="" border="0" width="660" height="5" /></div></div>
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
																	<td class="h2" style="color:#ffffff; font-family:Arial; font-size:18px; line-height:22px; text-align:left; font-weight:bold">Recent Funding</td>
																</tr>
															</table>';
	  
			
			$pub=1;												
			while($fundingRow = com_db_fetch_array($fundingResult)){
				$person_id = $fundingRow['personal_id'];
				$funding_amount = com_db_output($fundingRow['funding_amount']);
				//$funding_date = com_db_output($fundingRow['funding_date']);	
				
				$fdt = explode('-',$fundingRow['funding_date']);
				$funding_date = 	$fdt[1].'/'.$fdt[2].'/'.$fdt[0];
				
				
				$funding_source = com_db_output($fundingRow['funding_source']);
				
				$companyName = com_db_output($fundingRow['company_name']);	
				$companyID = com_db_output($fundingRow['company_id']);	
				$companyLogo = com_db_output($fundingRow['company_logo']);	
				
				$dim_url = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''), $companyName).'_Company_'.$companyID;
				
				
				// Extracting decision maker
				$fundingPersonQuery = "SELECT pm.personal_id,pm.first_name,pm.last_name,pm.email,pm.personal_image,mm.title,cm.company_name from
					".TABLE_COMPANY_MASTER." as cm,
					".TABLE_MOVEMENT_MASTER." as mm,
					".TABLE_PERSONAL_MASTER." as pm
					where (cm.company_id = mm.company_id and mm.personal_id = pm.personal_id) and pm.add_to_funding = 1 and cm.company_id = $companyID";
				
				
				//echo "<br>fundingPersonQuery: ".$fundingPersonQuery; die();
				$fundingPersonResult = com_db_query($fundingPersonQuery);	
			if($fundingPersonResult){
				$fundingPersonNumRow = com_db_num_rows($fundingPersonResult);	
				if($fundingPersonNumRow > 0)
				{
					$fundingPersonRow = com_db_fetch_array($fundingPersonResult);
					$person_first_name = $fundingPersonRow['first_name'];
					$person_last_name = $fundingPersonRow['last_name'];
					$person_email = $fundingPersonRow['email'];
					$personal_id = $fundingPersonRow['personal_id'];
					$person_funding_title = $fundingPersonRow['title'];
					$company_name_funding = $fundingPersonRow['company_name'];
					
					$personalFundingURL = trim($person_first_name).'_'.trim($person_last_name).'_Exec_'.$personal_id;
					
					
					$personal_image = $fundingPersonRow['personal_image'];
				  if($personal_image !=''){
					  $personal_funding_image_path = HTTPS_SITE_URL.'personal_photo/small/'.$personal_image;
				  }else{
					  $personal_funding_image_path = HTTPS_SITE_URL.'personal_photo/small/no_image_information.png';
				  }
					
					
				}
			}
				
				
				
				//$personalURL = trim($pFirstName).'_'.trim($pLastName).'_Exec_'.$person_id;
				
				//$publication = ' wrote "'.com_db_output($fundingRow['title']).'"';
				//$personal_image = $fundingRow['personal_image'];
				
				
					$messageFunding .=' <div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
								 <table width="100%" border="0" cellspacing="0" cellpadding="20">
									<tr>
										<td>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr>';
													if($companyLogo != '')
													{
														//$company_image_path = HTTPS_SITE_URL.'company_logo/small/'.$companyLogo;
														
														$org_company_image_path = HTTPS_SITE_URL.'company_logo/org/'.$companyLogo;
														//echo "<br>org_personal_image_path: ".$org_personal_image_path;
														$company_logo_resized_funding = getImageXY($org_company_image_path,80);
														
														//$messageFunding .='<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTPS_SITE_URL.$dim_url.'" target="_blank"><img src="'.$company_image_path.'" alt="" border="0" width="81" height="81" /></a></td>';
														$messageFunding .='<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTPS_SITE_URL.$dim_url.'" target="_blank">"'.$company_logo_resized_funding.'"</a></td>';
													}
													else
													{
														$messageFunding .='<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105">&nbsp;</td>';
													}
														$messageFunding .='<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">
														'.$companyName.' raised '.$funding_amount.' on '.$funding_date.'
														<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>

														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td align="left">
																	<table border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTPS_SITE_URL.$dim_url.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>
																			<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
																			<td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>
																			<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.$funding_source.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Source</span></a></td>
																			<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
																			
																			
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
													<td align="right" width="170" class="btn-container">';
															
													$messageFunding .='</td>
												</tr>';
												//if($person_email != '')
												if($fundingPersonNumRow > 0)
												{
													$messageFunding .='<tr><td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left;padding-top:14px;" valign="top" width="105"><a href="'.HTTPS_SITE_URL.$personalFundingURL.'" target="_blank"><img src="'.$personal_funding_image_path.'" alt="" border="0" width="81" height="81" /></a></td>
																	<td style="font-family:Arial; font-size:15px;">'.$person_first_name.' '.$person_last_name.', '.$person_funding_title.' at '.$company_name_funding.', is the decision maker</td>
																	<td width="175" align="right"><table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">
																		<tr>
																			<td>
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">
																					<tr>
																						<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div></div>
																						<div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="0" alt="" /></div>
																						 </td>
																						<td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$person_email.'?subject=Congrats&amp;body=Congrats on your appointment" target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>
																					</tr>
																				</table>
																			</td>
																		</tr>
																	</table>
																</td></tr>';
												}
												
											$messageFunding .=' </table>
										</td>
									</tr>
								</table>';
				
			$pub++;	
			}
		$messageFunding .=' 	</td>
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
	
	// for funding ENDS
	
	
	
	
	  $message = $messageHead.$person_image_name.$message.$messageFunding.$messageJob.$messageFooter;
	  $demoEmail = com_db_input($message);
	  $emailDetails = com_db_input($message);
	  $email_id = $email_alert_id;
	  $add_date = date("Y-m-d");
	  $all_person_id = implode(",", $person_id_info);
	  $demoEmailQuery = "INSERT INTO " . TABLE_DEMO_EMAIL_INFO . "(all_move_id, all_person_id, sent_email, email_details,email_id,triggers_name,add_date) values('".$all_move_id."','". $all_person_id."','$demoEmail','$emailDetails','$email_id','$triggers_name','".$add_date."')";	
	  com_db_query($demoEmailQuery);
	  com_redirect("demo-email.php?selected_menu=demoemail&msg=" . msg_encode("Demo Email Successfully created"));

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
			var funding_id='funding_id-'+ i;
			
			if(document.getElementById(person_id))
				document.getElementById(person_id).checked=true;
			else
			if(document.getElementById(job_id))
				document.getElementById(job_id).checked=true;
			else
			if(document.getElementById(funding_id))
				document.getElementById(funding_id).checked=true;	
		}
	} else {
		for(i=st; i<=end; i++){
			var person_id='person_id-'+ i;
			var job_id='job_id-'+ i;
			var funding_id='funding_id-'+ i;
			if(document.getElementById(person_id))
				document.getElementById(person_id).checked=false;
			else
			if(document.getElementById(job_id))
				document.getElementById(job_id).checked=false;	
			else
			if(document.getElementById(funding_id))
				document.getElementById(funding_id).checked=false;	
		}
	}
}

function AllRecored(numRows){

	var flg=0;
	for(i=1; i<=numRows; i++){
			var person_id='person_id-'+ i;
			var job_id='job_id-'+ i;
			var funding_id='funding_id-'+ i;
			if(document.getElementById(person_id) && document.getElementById(person_id).checked){
				flg=1;
			}	
			else
			if(document.getElementById(job_id) && document.getElementById(job_id).checked){
				flg=1;
			}
			else
			if(document.getElementById(funding_id) && document.getElementById(funding_id).checked){
				flg=1;
			}
		}
	if(flg==0){
		alert("Please checked atlist one checkbox for delete.");
		document.getElementById('person_id-1').focus();
		return false;
	} else {
		var agree=confirm("Selected person will be demo email. \n Do you want to continue?");
		if (agree)
			 document.topicform.submit();
		else
			window.location = "demo-email.php?selected_menu=demoemail";
	}	

}

function confirm_del(nid,p,type){
	var agree=confirm("Person will be deleted from Demo email. \n Do you want to continue?");
	if (agree){
		window.location = "demo-email.php?selected_menu=demoemail&pID=" + nid + "&p=" + p + "&action=delete"+"&type="+type;
	}else{
		window.location = "demo-email.php?selected_menu=demoemail&pID=" + nid + "&p=" + p ;
	}
}


function AllRecored_del(numRows)
{

    var flg=0;
    for(i=1; i<=numRows; i++)
    {
        var person_id='person_id-'+ i;
        var job_id='job_id-'+ i;
        var funding_id='funding_id-'+ i;
        if(document.getElementById(person_id) && document.getElementById(person_id).checked){
            flg=1;
        }	
        else
        if(document.getElementById(job_id) && document.getElementById(job_id).checked){
            flg=1;
        }
        else
        if(document.getElementById(funding_id) && document.getElementById(funding_id).checked){
            flg=1;
        }
    }
    if(flg==0)
    {
        alert("Please checked atleast one checkbox for delete.");
        document.getElementById('person_id-1').focus();
        return false;
    } 
    else 
    {
        var agree=confirm("Selected records will be deleted. \n Do you want to continue?");
        if (agree)
        {
            
            document.getElementById("multiple_del").value=1;
            document.topicform.submit();
        }         
        else
                window.location = "demo-email.php?selected_menu=demoemail";
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

<?php 


if(($action == '') || $action == 'save'){	?>			

		<form name="topicform" action="demo-email.php?action=DemoEmailCreate&selected_menu=demoemail" method="post">
		<input type="hidden" name="multiple_del" id="multiple_del" value="">
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
          <tr>
            <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="19%" align="left" valign="middle" class="heading-text">Demo Email Manager</td>
                    <td width="50%" align="left" valign="middle" class="message"><?=$msg?></td>
                    <td width="31%" align="left" valign="middle">
                        <input type="button" value="Delete" onclick="AllRecored_del('<?=$numRows?>');" >
                        &nbsp;&nbsp;
                        <input type="button" value="Generate Demo Email" onclick="AllRecored('<?=$numRows?>');" ></td>
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
			$funding_row = 0; 
                        //echo "<br>total_data: ".$total_data;
                        //echo "<br>total_data: ".$total_data;
                        //echo "<br>Query: ".$sql_query;
			if($total_data>0) {
				$i=$starting_point+1;
				$select_trigger='';
				while ($data_sql = com_db_fetch_array($exe_data)) {
				$add_date = $data_sql['add_date'];
				//echo "<br>within";
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
                <td height="30" align="center" valign="middle" class="right-border"><a href="#"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" title="Delete" border="0" onclick="confirm_del('<?=$data_sql['personal_id'];?>','<?=$p;?>','job')" /></a><br />
						  Delete</td>
         	</tr> 
				<?PHP
				}
				elseif($data_sql['person_tigger_name'] == 'Funding')
				{
					if($funding_row == 0)
					{
				?>
						
						<tr>
				<td width="22" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-title-text"></span></td>
				<td width="20" height="30" align="center" valign="middle" class="right-border">
				&nbsp;</td>
				<td width="110" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Company Name</span> </td>
                <td width="127" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Engagement Triggers</span> </td>
                <td width="84" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Amount</span> </td>
                <td width="67" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Action</span> </td>
			  </tr>
						
						
						<?PHP
						$funding_row++;
					}
				?>
				<tr>
				<td height="30" align="center" valign="middle" class="right-border-left"><?=$i;?></td>
				<td height="30" align="center" valign="middle" class="right-border"><input type="checkbox" id="funding_id-<?=$i;?>" name="fid[]" value="<?=$data_sql['personal_id'];?>" /></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><?=com_db_output($data_sql['company_name'])?></td>
                <td height="30" align="left" valign="middle" class="right-border-text">Funding</td>
				<td height="30" align="center" valign="middle" class="right-border"><?=com_db_output($data_sql['first_name'])?></td>
                <td height="30" align="center" valign="middle" class="right-border"><a href="#"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" title="Delete" border="0" onclick="confirm_del('<?=$data_sql['personal_id'];?>','<?=$p;?>','funding')" /></a><br />
						  Delete</td>
         	</tr> 
				<?PHP
				}
				else
				{
				
			?>          
			  <tr>
				<td height="30" align="center" valign="middle" class="right-border-left"><?=$i;?></td>
				<td height="30" align="center" valign="middle" class="right-border"><input type="checkbox" id="person_id-<?=$i;?>" name="nid[]" value="<?=$data_sql['personal_id'];?>" /></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><?=com_db_output($data_sql['first_name'].' '.$data_sql['last_name'])?></td>
                <td height="30" align="left" valign="middle" class="right-border-text"><?=com_db_output($data_sql['person_tigger_name'])?></td>
				<td height="30" align="center" valign="middle" class="right-border"><?=$add_date;?></td>
                <td height="30" align="center" valign="middle" class="right-border"><a href="#"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" title="Delete" border="0" onclick="confirm_del('<?=$data_sql['personal_id'];?>','<?=$p;?>','')" /></a><br />
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