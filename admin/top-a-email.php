<?php
//ini_set('display_errors',1);
//ini_set('display_startup_errors',1);
//error_reporting(-1);

//echo "<pre>REQUEST: ";	print_r($_request);	echo "</pre>";
//echo "<pre>POST: ";	print_r($_POST);	echo "</pre>";

require('includes/include_top.php');

//$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 20;
$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 800;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';

//$sql_query .= " UNION select '' as personal_id, '' as first_name,'' as last_name, Jobs as person_tigger_name, '' as add_date, cji.*,c.company_name from " .TABLE_COMPANY_JOB_INFO." cji,". TABLE_COMPANY_MASTER . " as c order by c.company_id desc";

$sql_query = "select p.personal_id,p.first_name,p.last_name,p.add_date,'' as company_name,'' as company_id,top_appointments  from " . TABLE_PERSONAL_MASTER." as p,".TABLE_TOP_APPOINTMENTS." as ta where (p.personal_id = ta.personal_id) order by ta.top_appointments asc";


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
$site_domain_name = $adminRow['site_domain_name'];

$site_phone_number = com_db_output($adminRow['site_phone_number']);
$site_company_address = com_db_output($adminRow['site_company_address']);
$site_company_city  = com_db_output($adminRow['site_company_city']);
$site_company_state = com_db_output($adminRow['site_company_state']);
$site_company_zip = com_db_output($adminRow['site_company_zip']);
$pID = (isset($_GET['pID']) ? $_GET['pID'] : $select_data[0]);


//echo "<br>multiple_del: ".$_REQUEST['multiple_del'];
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
        //echo "<pre>person_id_del Array: ";	print_r($person_id_del);	echo "</pre>";
        for($p=0;$p<$tot_personID_del;$p++)
        {
            $perQueryUpdate = "update ".TABLE_PERSONAL_MASTER." set demo_email =0, 	person_tigger_name='',all_trigger_id = 0 where personal_id='".$person_id_del[$p]."'";
            //echo "<br>Update personal Q: ".$perQueryUpdate;
            com_db_query($perQueryUpdate);
        }
    }
    
    $job_id_del = $_POST['jid'];
    $all_job_id_del = implode(",",$job_id_del);
    $tot_jobID_del = sizeof($all_job_id_del);

    //echo "<pre>REQ job ids to delete: ";	print_r($job_id_del);	echo "</pre>";

    if($tot_jobID_del > 0)
    {    
        for($j=0;$j<$tot_jobID_del;$j++)
        {
            //echo "<br>Job ID: ".$job_id_del[$j];
            $query_del_job = com_db_query("select company_id from " . TABLE_COMPANY_JOB_INFO . " where job_id = '" . $job_id_del[$j] . "'");
            $data_del_job  = com_db_fetch_array($query_del_job);
            $company_id_del = com_db_output($data_del_job['company_id']);
            
            //echo "<br>Job company ID: ".$company_id_del;
            $jobQueryUpdate = "DELETE FROM ".TABLE_DEMO_JOB_INFO." where company_id='".$company_id_del."'";
            //echo "<br>Delete job Q: ".$jobQueryUpdate;
            com_db_query($jobQueryUpdate);
            
            //delete_from_ctos($pID,$this_company_id,'job'); // funding_id , company_id

            //echo "<br>Job ID: ".$job_id_del[$j];
            //echo "<br>Job company ID: ".$company_id_del;
            if($company_id_del != '')
                delete_from_ctos($job_id_del[$j],$company_id_del,'job'); // funding_id , company_id
        }
    }
    
    $funding_id_del = $_POST['fid'];
    $all_funding_id_del = implode(",",$funding_id_del);
    $tot_fundingID_del = sizeof($_POST['fid']);
    
    //echo "<pre>REQ Data: ";	print_r($_REQUEST);	echo "</pre>";
    //echo "<br>tot_fundingID_del count: ".$tot_fundingID_del;
    
    if($tot_fundingID_del > 0)
    {
        $funding_del_cto_arr = array();
        for($f=0;$f<$tot_fundingID_del;$f++)
        {
            //echo "<br><br>select company_id from " . TABLE_COMPANY_FUNDING . " where funding_id = '" . $funding_id_del[$f] . "'";
            $query_del_funding = com_db_query("select company_id from " . TABLE_COMPANY_FUNDING . " where funding_id = '" . $funding_id_del[$f] . "'");
            
            
            $data_del_funding  = com_db_fetch_array($query_del_funding);
            //echo "<br>after query ";
            $company_id_del = com_db_output($data_del_funding['company_id']);
            
            if($company_id_del != '')
            {    
                $funding_del_cto_arr[$funding_id_del[$f]] = $company_id_del;
            }    
            
            $perQueryUpdate = "";
            $perQueryUpdate = "DELETE FROM ".TABLE_COMPANY_FUNDING." where funding_id='".$funding_id_del[$f]."'";
            //echo "<br>Funding delete: ".$perQueryUpdate;
            com_db_query($perQueryUpdate);
            
        }
        
        $fund_del_cto_count = sizeof($funding_del_cto_arr);
        if($fund_del_cto_count > 0)
        {
            foreach($funding_del_cto_arr as $funding_id_cto => $comp_id_cto)
            {
                delete_from_ctos($funding_id_cto,$comp_id_cto,'funding'); // funding_id , company_id
            }
        }
    } 
    com_redirect("top-a-email.php?selected_menu=demoemail&msg=" . msg_encode("Selected records are deleted"));
}

if($action=='delete')
{

    $section_type = (isset($_GET['section_type']) ? $_GET['section_type'] : '');
    $this_personal_id = (isset($_GET['pID']) ? $_GET['pID'] : '');

    
    $perQueryDelete = "delete from ".TABLE_TOP_APPOINTMENTS." where personal_id = '".$pID."' and top_appointments = '$section_type'";
    com_db_query($perQueryDelete);
    
    //echo $perQueryUpdate;
    com_redirect("top-a-email.php?selected_menu=demosummary&msg=" . msg_encode("Selected Person delete from Demo Email"));
}

elseif($action =='DemoEmailCreate')
{
    
    // Setting variable so that salesforce button appears
    $_GET['show_sf'] = 1;
    $addLeadText = "Add&nbsp;as&nbsp;a&nbsp;Lead&#013;(Only&nbsp;for&nbsp;Ent&nbsp;license)";
    
	//echo "<pre>REQ Data: ";	print_r($_REQUEST);	echo "</pre>";
	//echo "<pre>FAR UNDO POST Data: ";	print_r($_POST);	echo "</pre>";
	
        
        
    $all_person_id = "";    
    $trigger = $_POST['selected_trigger'];
    $a_person_id = $_POST['aid'];
    $b_person_id = $_POST['bid'];
    $c_person_id = $_POST['cid'];
    $d_person_id = $_POST['did'];
    $all_person_id .= implode(",",$a_person_id);
    if($all_person_id != '')
        $all_person_id .= ',';
    $all_person_id .= implode(",",$b_person_id);
    if($all_person_id != '')
        $all_person_id .= ',';
    $all_person_id .= implode(",",$c_person_id);
    if($all_person_id != '')
        $all_person_id .= ',';
    $all_person_id .= implode(",",$d_person_id);
    $tot_personID = sizeof($all_person_id);
    
    $all_person_id = trim($all_person_id,",");
    //echo "<br>all_person_id: ".$all_person_id;
    //die();
    
    //echo "<pre>tot_personID";   print_r($tot_personID); echo "</pre>";
    
    //Image & Email check
    $pfQuery = "select * from ".TABLE_PERSONAL_FILTER_ONOFF." where filter_onoff='ON'";
    $pfResult = com_db_query($pfQuery);
    $pfString='';
    while($pfRow = com_db_fetch_array($pfResult))
    {
        if($pfRow['filter_name']=='Personal Image Checking' &&  $pfRow['filter_onoff']=='ON')
        {
            if($pfString=='')
            {
                $pfString = ' personal_image <> ""';
            }
            else
            {
                $pfString .= ' and personal_image <> ""';
            }
        }
        elseif($pfRow['filter_name']=='Personal Email Checking' &&  $pfRow['filter_onoff']=='ON')
        {
            if($pfString=='')
            {
                $pfString = ' (email<>"" and email<>"n/a" and email<>"N/A")';
            }
            else
            {
                $pfString .= ' and (email<>"" and email<>"n/a" and email<>"N/A")';
            }
        }
    }
	  

    
    
    
    
    
    //die();
    
    if($tot_personID > 0)
    {
        $perNumRows = 0;
        if($all_person_id != '')
        {
            if($pfString=='')
            {
                $perQuery = "select first_name,last_name,email,personal_image,personal_id,demo_email,person_tigger_name,all_trigger_id from ".TABLE_PERSONAL_MASTER." where personal_id in (".$all_person_id.")";
            }
            else
            {
                $perQuery = "select first_name,last_name,email,personal_image,personal_id,demo_email,person_tigger_name,all_trigger_id from ".TABLE_PERSONAL_MASTER." where ".$pfString." and personal_id in (".$all_person_id.")";
            }
          //echo "<br>FAR perQuery: ".$perQuery;
          //die();

            $perResult = com_db_query($perQuery);
            if($perResult)
            {
                $perNumRows = com_db_num_rows($perResult);
            }
        } 
        $appointments_id_list='';
        $section_two_id_list = '';
        
        
        $person_info = array();
        $person_id_info = array();
        $p=0;	
        
        
        // New code
        //$appointments_id_list = $all_person_id;
        
        //$a_person_id = $_POST['aid'];
        $s_person_str .= implode(",",$a_person_id);
        $b_person_str .= implode(",",$b_person_id);
        $c_person_str .= implode(",",$c_person_id);
        $d_person_str .= implode(",",$d_person_id);
        
        
        if($perNumRows>0)
        {
            while($perRow = com_db_fetch_array($perResult))
            {
                
                if(in_array($perRow['personal_id'],$a_person_id))
                    $person_list = 'in_a';
                elseif(in_array($perRow['personal_id'],$b_person_id))
                    $person_list = 'in_b';    
                
                
                //$perRow['person_tigger_name'] = ;

                //if($perRow['person_tigger_name']=='Appointments')
                if($person_list = 'in_a' && $perRow['all_trigger_id'] != '')
                {
                    if($appointments_id_list=='')
                    {
                        $appointments_id_list = $perRow['all_trigger_id'];
                    }
                    else
                    {
                        $appointments_id_list .= ",".$perRow['all_trigger_id'];
                    }
                }
                
                
                if($person_list = 'in_b' && $perRow['all_trigger_id'] != '')
                {
                    if($section_two_id_list=='')
                    {
                        $section_two_id_list = $perRow['all_trigger_id'];
                    }
                    else
                    {
                        $section_two_id_list .= ",".$perRow['all_trigger_id'];
                    }
                }
                
                
                //echo "<br>appointments_id_list: ".$appointments_id_list;    
                //echo "<br>section two list: ".$section_two_id_list;    
                //
                $person_id = $perRow['personal_id'];
                $pFirstName = trim(com_db_output($perRow['first_name']));
                $pLastName = trim(com_db_output($perRow['last_name']));	
                $personalURL = trim($pFirstName).'_'.trim($pLastName).'_Exec_'.$person_id;

                $personal_image = $perRow['personal_image'];
                if($personal_image !='')
                {
                    $personal_image_path = HTTPS_SITE_URL.'personal_photo/small/'.$personal_image;
                }
                else
                {
                    $personal_image_path = HTTPS_SITE_URL.'personal_photo/small/no_image_information.png';
                }

                if(sizeof($person_id_info)==0)
                {
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
                elseif(!in_array ($person_id,$person_id_info))
                {
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
		  
		  
        //echo "<pre>FAR UNDO person_info: ";	print_r($person_info);	echo "</pre>";
        //die();
		  
        $totPerson = sizeof($person_info);
        //echo "<br>FAR tot person: ".$totPerson;
        //die();			
        $table1 = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>';
        for($q=0;$q<4;$q++)
        {
            if($person_info[$q]['pname'] !='')
            {
                    $table1 .='<td valign="top">
                    <div class="img" style="font-size:0pt; line-height:0pt; text-align:left;width:80px;height:80px;position:relative;">';

                    if($person_info[$q]['type'] == 'Company')
                    {
                        //$table1 .='<a href="'.HTTPS_SITE_URL.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTPS_SITE_URL.'company_logo/small/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" height="80" /></a>';
                        $table1 .='<a href="'.HTTPS_SITE_URL.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTP_CTO_URL.'company_logo/org/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" style="position:absolute; margin:auto; top:0px; right:0px; bottom:0px; left:0px;"  /></a>';
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
		   
        $table2 = '<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>';
        for($q=4;$q<8;$q++)
        {
            if($person_info[$q]['pname'] !='')
            {
                $table2 .='<td valign="top">
                    <div class="img" style="font-size:0pt; line-height:0pt; text-align:left;width:80px;height:80px;position:relative;">';
                    if($person_info[$q]['type'] == 'Company')
                    {
                        //$table2 .='<a href="'.HTTPS_SITE_URL.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTPS_SITE_URL.'company_logo/small/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" height="80" /></a>';
                        $table2 .='<a href="'.HTTPS_SITE_URL.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTP_CTO_URL.'company_logo/org/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" style="position:absolute; margin:auto; top:0px; right:0px; bottom:0px; left:0px;" /></a>';
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
                $table2 .= '</tr></table>';	
					 
			
			$table3 = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>';
			for($q=8;$q<12;$q++){
				if($person_info[$q]['pname'] !=''){
					$table3 .='<td valign="top">
									<div class="img" style="font-size:0pt; line-height:0pt; text-align:left;width:80px;height:80px;position:relative;">';
									if($person_info[$q]['type'] == 'Company')
									{  
										//$table3 .='<a href="'.HTTPS_SITE_URL.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTPS_SITE_URL.'company_logo/small/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" height="80" /></a>';
										$table3 .='<a href="'.HTTPS_SITE_URL.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTP_CTO_URL.'company_logo/org/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" style="position:absolute; margin:auto; top:0px; right:0px; bottom:0px; left:0px;" /></a>';
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
										$table4 .='<a href="'.HTTPS_SITE_URL.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTP_CTO_URL.'company_logo/org/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" style="position:absolute; margin:auto; top:0px; right:0px; bottom:0px; left:0px;" /></a>';
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
														<td class="column2"><div class="top" style="color:#7a7a7a; font-family:Arial; font-size:11px; line-height:18px; text-align:left">Having trouble viewing this email? <a href="'.HTTPS_SITE_URL.'summary-email-show.php?emailid='.$email_alert_id.'" target="_blank" class="link-top" style="color:#5c97d8; text-decoration:underline"><span class="link-top" style="color:#5c97d8; text-decoration:underline">View it in your browser</span></a></div></td>
														<td align="right" class="column2">
															<table border="0" cellspacing="0" cellpadding="0">
																<tr>
																	<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="8"><img src="'.HTTPS_SITE_URL.'images/bullet1.jpg" alt="" border="0" width="2" height="3" /></td>
																	<td class="top" style="color:#7a7a7a; font-family:Arial; font-size:11px; line-height:18px; text-align:left"><a href="'.HTTPS_SITE_URL.'summary-email-show.php?emailid='.$email_alert_id.'" target="_blank" class="link-top" style="color:#5c97d8; text-decoration:underline"><span class="link-top" style="color:#5c97d8; text-decoration:underline">Online version</span></a></td>
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
													Rather not receive our newsletter anymore? <a href="mailto:unsub@alertfetch.com" target="_blank" class="link3-u" style="color:#adadad; text-decoration:underline"><span class="link3-u" style="color:#adadad; text-decoration:underline">Unsubscribe instantly</span></a>.
							
													<div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:50px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="50" style="height:50px" alt="" /></div></div>
													<div style="font-size:0pt; line-height:0pt;" class="mobile-br-25"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="0" alt="" /></div>
							
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>';	
	$triggers_name = $trigger;	
        
        
        //echo "<br>appointments_id_list line 638: ".$appointments_id_list; 
        // TODO - add loop outside which will run 4 times for each section
        
        
        $messageSrt='';
        $messageEmail='';
        
        //for($c=0;$c<4;$c++)
        //{
        $c = 0; 
        $appointments_id_list = "";
        if($c == 0)
        {
            if(count($a_person_id) > 0)
                $appointments_id_list = implode(",",$a_person_id);
        } 
        elseif($c == 1)
        {
            if(count($b_person_id) > 0)
                $appointments_id_list = implode(",",$b_person_id);
        } 
        elseif($c == 2)
        {
            if(count($c_person_id) > 0)
                $appointments_id_list = implode(",",$c_person_id);
        }
        elseif($c == 3)
        {
            if(count($d_person_id) > 0)
                $appointments_id_list = implode(",",$d_person_id);
        }

        echo "<br><br><br>c: ".$c;
        echo "<br>appointments_id_list: ".$appointments_id_list;


        //Appointments
        if($appointments_id_list !='')
        {
            $already_added_personal_sec1 = array();
            $app_query = "select mm.*,pm.first_name,pm.last_name,pm.email,pm.personal_image,cm.company_name,pm.phone from ".TABLE_MOVEMENT_MASTER." mm, ".TABLE_PERSONAL_MASTER." pm, ".TABLE_COMPANY_MASTER." cm where (mm.company_id=cm.company_id and mm.personal_id=pm.personal_id) and pm.personal_id in (".$appointments_id_list.") order by move_id desc";	
            echo "<br>app_query: ".$app_query; 
            $app_result = com_db_query($app_query);
            if($app_result)
            {
                $numRows = com_db_num_rows($app_result);
            }
            echo "<br>numRows: ".$numRows; 
            $cnt=1;

            //$effective_date_within_60day = date("Y-m-d",mktime(0,0,0,date("m"),(date("d")-60),date("Y"))); 
            while($email_row = com_db_fetch_array($app_result))
            {
                
                if(!in_array($email_row['personal_id'],$already_added_personal_sec1))
                {
                    $already_added_personal_sec1[] = $email_row['personal_id'];
                    $person_id = $email_row['personal_id'];
                    $pFirstName = trim(com_db_output($email_row['first_name']));
                    $pLastName = trim(com_db_output($email_row['last_name']));	
                    $personalURL = trim($pFirstName).'_'.trim($pLastName).'_Exec_'.$person_id;

                    if($email_row['effective_date'] > $effective_date_within_60day)
                    {
                            if($email_row['movement_type']==1)
                            {
                                $movement = ' was Appointed as ';
                            }
                            elseif($email_row['movement_type']==2)
                            {
                                $movement = ' was Promoted to ';
                            }
                            elseif($email_row['movement_type']==3)
                            {
                                $movement = ' Retired as ';
                            }
                            elseif($email_row['movement_type']==4)
                            {
                                  $movement = ' Resigned as '; 
                            }
                            elseif($email_row['movement_type']==5)
                            {
                                $movement = ' was Terminated as ';
                            }
                            elseif($email_row['movement_type']==6)
                            {
                                $movement = ' was Appointed to ';
                            }
                            elseif($email_row['movement_type']==7)
                            {
                                $movement = ' Job Opening ';
                            }

                            $heading = com_db_output($email_row['first_name'].' '.$email_row['last_name'].$movement.$email_row['title'].' at '.$email_row['company_name']);
                            $personal_image = $email_row['personal_image'];
                            if($personal_image !='')
                            {
                                $personal_image_path = HTTPS_SITE_URL.'personal_photo/small/'.$personal_image;
                            }
                            else
                            {
                                $personal_image_path = HTTPS_SITE_URL.'personal_photo/small/no_image_information.png';
                            }

                            if($email_row['more_link'] =='')
                            {
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

                            }
                            else
                            {
                                $sf = "";
                                if($_GET['show_sf'] == 1) // Speaking Engagements Sectopm
                                {    
                                    $sf_company_name = $email_row['company_name'];
                                    $sf_title = $email_row['title'];
                                    $sf_email = $email_row['email'];
                                    $sf_phone = $email_row['phone'];
                                    //$email_row['title']
                                    //$email_row['email']
                                    //echo "<pre>psRow:";   print_r($psRow);   echo "</pre>"; die();
                                    $sf = "<td width=70></td><td class=links><a target=_blank href=".HTTPS_SITE_URL."salesforce/oauth.php?fname=".urlencode($pFirstName)."&lname=".urlencode($pLastName)."&company_name=".urlencode($sf_company_name)."&title=".urlencode($sf_title)."&email=".urlencode($sf_email)."&phone=".urlencode($sf_phone)."><img width=18px height=18px title=".$addLeadText." src=".HTTPS_SITE_URL."images/salesforce.png></a></td>";
                                }

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
                                                                                '.$sf.'        
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
                if($messageSrt!='')
                {
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
                                                                        <td class="h2" style="color:#ffffff; font-family:Arial; font-size:18px; line-height:22px; text-align:left; font-weight:bold">Top Appointments - Senior HR Executives</td>
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
        }
        
        
        
        // Section two starts
        $messageSrt_2 = '';
        //$section_two_id_list = "";
        $section_two_id_list = implode(",",$b_person_id);
        //echo "<br>section_two_id_list for section two: ".$section_two_id_list;
        if($section_two_id_list !='')
        {
            //$app_query = "select mm.*,pm.first_name,pm.last_name,pm.email,pm.personal_image,cm.company_name,pm.phone from ".TABLE_MOVEMENT_MASTER." mm, ".TABLE_PERSONAL_MASTER." pm, ".TABLE_COMPANY_MASTER." cm where (mm.company_id=cm.company_id and mm.personal_id=pm.personal_id) and mm.move_id in (".$section_two_id_list.")";	
            $app_query = "select distinct mm.personal_id,mm.*,pm.first_name,pm.last_name,pm.email,pm.personal_image,cm.company_name,pm.phone from ".TABLE_MOVEMENT_MASTER." mm, ".TABLE_PERSONAL_MASTER." pm, ".TABLE_COMPANY_MASTER." cm where (mm.company_id=cm.company_id and mm.personal_id=pm.personal_id) and pm.personal_id in (".$section_two_id_list.") order by move_id desc";	
            echo "<br>app_query 975: ".$app_query; 
            $app_result = com_db_query($app_query);
            if($app_result)
            {
                $numRows = com_db_num_rows($app_result);
            }
            echo "<br>numRows: ".$numRows; 
            $cnt=1;
            $already_added_personal = array();
            //$effective_date_within_60day = date("Y-m-d",mktime(0,0,0,date("m"),(date("d")-60),date("Y"))); 
            while($email_row = com_db_fetch_array($app_result))
            {
                if(!in_array($email_row['personal_id'],$already_added_personal))
                {        
                $already_added_personal[] = $email_row['personal_id'];
                
                $person_id = $email_row['personal_id'];
                $pFirstName = trim(com_db_output($email_row['first_name']));
                $pLastName = trim(com_db_output($email_row['last_name']));	
                $personalURL = trim($pFirstName).'_'.trim($pLastName).'_Exec_'.$person_id;

                if($email_row['effective_date'] > $effective_date_within_60day)
                {
                        if($email_row['movement_type']==1)
                        {
                            $movement = ' was Appointed as ';
                        }
                        elseif($email_row['movement_type']==2)
                        {
                            $movement = ' was Promoted to ';
                        }
                        elseif($email_row['movement_type']==3)
                        {
                            $movement = ' Retired as ';
                        }
                        elseif($email_row['movement_type']==4)
                        {
                              $movement = ' Resigned as '; 
                        }
                        elseif($email_row['movement_type']==5)
                        {
                            $movement = ' was Terminated as ';
                        }
                        elseif($email_row['movement_type']==6)
                        {
                            $movement = ' was Appointed to ';
                        }
                        elseif($email_row['movement_type']==7)
                        {
                            $movement = ' Job Opening ';
                        }

                        $heading = com_db_output($email_row['first_name'].' '.$email_row['last_name'].$movement.$email_row['title'].' at '.$email_row['company_name']);
                        $personal_image = $email_row['personal_image'];
                        if($personal_image !='')
                        {
                            $personal_image_path = HTTPS_SITE_URL.'personal_photo/small/'.$personal_image;
                        }
                        else
                        {
                            $personal_image_path = HTTPS_SITE_URL.'personal_photo/small/no_image_information.png';
                        }

                        if($email_row['more_link'] =='')
                        {
                            $messageSrt_2 .='<table width="100%" border="0" cellspacing="0" cellpadding="20">
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

                        }
                        else
                        {
                            $sf = "";
                            if($_GET['show_sf'] == 1) // Speaking Engagements Sectopm
                            {    
                                $sf_company_name = $email_row['company_name'];
                                $sf_title = $email_row['title'];
                                $sf_email = $email_row['email'];
                                $sf_phone = $email_row['phone'];
                                //$email_row['title']
                                //$email_row['email']
                                //echo "<pre>psRow:";   print_r($psRow);   echo "</pre>"; die();
                                $sf = "<td width=70></td><td class=links><a target=_blank href=".HTTPS_SITE_URL."salesforce/oauth.php?fname=".urlencode($pFirstName)."&lname=".urlencode($pLastName)."&company_name=".urlencode($sf_company_name)."&title=".urlencode($sf_title)."&email=".urlencode($sf_email)."&phone=".urlencode($sf_phone)."><img width=18px height=18px title=".$addLeadText." src=".HTTPS_SITE_URL."images/salesforce.png></a></td>";
                            }

                            $messageSrt_2 .='<table width="100%" border="0" cellspacing="0" cellpadding="20">
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
                                                                            '.$sf.'        
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
                } // Ending If condition - don't add same personal twice

            }//end while
            if($messageSrt_2!='')
            {
                $message .= '<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/box_top.jpg" alt="" border="0" width="660" height="5" /></div></div>
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
                                                                    <td class="h2" style="color:#ffffff; font-family:Arial; font-size:18px; line-height:22px; text-align:left; font-weight:bold">Top Appointments - Recruiting Executives</td>
                                                                </tr>
                                                            </table>
                                                            <div style="font-size:0pt; line-height:0pt; height:1px; background:#4785ca; "><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
                                                            '.$messageSrt_2.'
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
        // Section two ends
        
        
        // Section three starts
        $messageSrt_3 = '';
        //$section_two_id_list = "";
        $section_three_id_list = implode(",",$c_person_id);
        //echo "<br>section_three_id_list for section three: ".$section_three_id_list;
        if($section_three_id_list !='')
        {
            //$app_query = "select mm.*,pm.first_name,pm.last_name,pm.email,pm.personal_image,cm.company_name,pm.phone from ".TABLE_MOVEMENT_MASTER." mm, ".TABLE_PERSONAL_MASTER." pm, ".TABLE_COMPANY_MASTER." cm where (mm.company_id=cm.company_id and mm.personal_id=pm.personal_id) and mm.move_id in (".$section_two_id_list.")";	
            $app_query = "select distinct mm.personal_id,mm.*,pm.first_name,pm.last_name,pm.email,pm.personal_image,cm.company_name,pm.phone from ".TABLE_MOVEMENT_MASTER." mm, ".TABLE_PERSONAL_MASTER." pm, ".TABLE_COMPANY_MASTER." cm where (mm.company_id=cm.company_id and mm.personal_id=pm.personal_id) and pm.personal_id in (".$section_three_id_list.") order by move_id desc";	
            //echo "<br>app_query: ".$app_query; 
            $app_result = com_db_query($app_query);
            if($app_result)
            {
                $numRows = com_db_num_rows($app_result);
            }
            //echo "<br>numRows: ".$numRows; 
            $cnt=1;
            $already_added_personal = array();
            //$effective_date_within_60day = date("Y-m-d",mktime(0,0,0,date("m"),(date("d")-60),date("Y"))); 
            while($email_row = com_db_fetch_array($app_result))
            {
                if(!in_array($email_row['personal_id'],$already_added_personal))
                {        
                $already_added_personal[] = $email_row['personal_id'];
                
                $person_id = $email_row['personal_id'];
                $pFirstName = trim(com_db_output($email_row['first_name']));
                $pLastName = trim(com_db_output($email_row['last_name']));	
                $personalURL = trim($pFirstName).'_'.trim($pLastName).'_Exec_'.$person_id;

                if($email_row['effective_date'] > $effective_date_within_60day)
                {
                        if($email_row['movement_type']==1)
                        {
                            $movement = ' was Appointed as ';
                        }
                        elseif($email_row['movement_type']==2)
                        {
                            $movement = ' was Promoted to ';
                        }
                        elseif($email_row['movement_type']==3)
                        {
                            $movement = ' Retired as ';
                        }
                        elseif($email_row['movement_type']==4)
                        {
                              $movement = ' Resigned as '; 
                        }
                        elseif($email_row['movement_type']==5)
                        {
                            $movement = ' was Terminated as ';
                        }
                        elseif($email_row['movement_type']==6)
                        {
                            $movement = ' was Appointed to ';
                        }
                        elseif($email_row['movement_type']==7)
                        {
                            $movement = ' Job Opening ';
                        }

                        $heading = com_db_output($email_row['first_name'].' '.$email_row['last_name'].$movement.$email_row['title'].' at '.$email_row['company_name']);
                        $personal_image = $email_row['personal_image'];
                        if($personal_image !='')
                        {
                            $personal_image_path = HTTPS_SITE_URL.'personal_photo/small/'.$personal_image;
                        }
                        else
                        {
                            $personal_image_path = HTTPS_SITE_URL.'personal_photo/small/no_image_information.png';
                        }

                        if($email_row['more_link'] =='')
                        {
                            $messageSrt_3 .='<table width="100%" border="0" cellspacing="0" cellpadding="20">
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

                        }
                        else
                        {
                            $sf = "";
                            if($_GET['show_sf'] == 1) // Speaking Engagements Sectopm
                            {    
                                $sf_company_name = $email_row['company_name'];
                                $sf_title = $email_row['title'];
                                $sf_email = $email_row['email'];
                                $sf_phone = $email_row['phone'];
                                //$email_row['title']
                                //$email_row['email']
                                //echo "<pre>psRow:";   print_r($psRow);   echo "</pre>"; die();
                                $sf = "<td width=70></td><td class=links><a target=_blank href=".HTTPS_SITE_URL."salesforce/oauth.php?fname=".urlencode($pFirstName)."&lname=".urlencode($pLastName)."&company_name=".urlencode($sf_company_name)."&title=".urlencode($sf_title)."&email=".urlencode($sf_email)."&phone=".urlencode($sf_phone)."><img width=18px height=18px title=".$addLeadText." src=".HTTPS_SITE_URL."images/salesforce.png></a></td>";
                            }

                            $messageSrt_3 .='<table width="100%" border="0" cellspacing="0" cellpadding="20">
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
                                                                            '.$sf.'        
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
                } // Ending If condition - don't add same personal twice

            }//end while
            if($messageSrt_3!='')
            {
                $message .= '<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/box_top.jpg" alt="" border="0" width="660" height="5" /></div></div>
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
                                                                    <td class="h2" style="color:#ffffff; font-family:Arial; font-size:18px; line-height:22px; text-align:left; font-weight:bold">Top Appointments - Benefits Executives</td>
                                                                </tr>
                                                            </table>
                                                            <div style="font-size:0pt; line-height:0pt; height:1px; background:#4785ca; "><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
                                                            '.$messageSrt_3.'
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
        // Section three ends
        
        
        // Section four starts
        $messageSrt_4 = '';
        //$section_two_id_list = "";
        $section_four_id_list = implode(",",$d_person_id);
        //echo "<br>section_four_id_list for section four: ".$section_four_id_list;
        if($section_four_id_list !='')
        {
            //$app_query = "select mm.*,pm.first_name,pm.last_name,pm.email,pm.personal_image,cm.company_name,pm.phone from ".TABLE_MOVEMENT_MASTER." mm, ".TABLE_PERSONAL_MASTER." pm, ".TABLE_COMPANY_MASTER." cm where (mm.company_id=cm.company_id and mm.personal_id=pm.personal_id) and mm.move_id in (".$section_two_id_list.")";	
            $app_query = "select distinct mm.personal_id,mm.*,pm.first_name,pm.last_name,pm.email,pm.personal_image,cm.company_name,pm.phone from ".TABLE_MOVEMENT_MASTER." mm, ".TABLE_PERSONAL_MASTER." pm, ".TABLE_COMPANY_MASTER." cm where (mm.company_id=cm.company_id and mm.personal_id=pm.personal_id) and pm.personal_id in (".$section_four_id_list.") order by move_id desc";	
            //echo "<br>app_query: ".$app_query; 
            $app_result = com_db_query($app_query);
            if($app_result)
            {
                $numRows = com_db_num_rows($app_result);
            }
            //echo "<br>numRows: ".$numRows; 
            $cnt=1;
            $already_added_personal = array();
            //$effective_date_within_60day = date("Y-m-d",mktime(0,0,0,date("m"),(date("d")-60),date("Y"))); 
            while($email_row = com_db_fetch_array($app_result))
            {
                if(!in_array($email_row['personal_id'],$already_added_personal))
                {        
                $already_added_personal[] = $email_row['personal_id'];
                
                $person_id = $email_row['personal_id'];
                $pFirstName = trim(com_db_output($email_row['first_name']));
                $pLastName = trim(com_db_output($email_row['last_name']));	
                $personalURL = trim($pFirstName).'_'.trim($pLastName).'_Exec_'.$person_id;

                if($email_row['effective_date'] > $effective_date_within_60day)
                {
                        if($email_row['movement_type']==1)
                        {
                            $movement = ' was Appointed as ';
                        }
                        elseif($email_row['movement_type']==2)
                        {
                            $movement = ' was Promoted to ';
                        }
                        elseif($email_row['movement_type']==3)
                        {
                            $movement = ' Retired as ';
                        }
                        elseif($email_row['movement_type']==4)
                        {
                              $movement = ' Resigned as '; 
                        }
                        elseif($email_row['movement_type']==5)
                        {
                            $movement = ' was Terminated as ';
                        }
                        elseif($email_row['movement_type']==6)
                        {
                            $movement = ' was Appointed to ';
                        }
                        elseif($email_row['movement_type']==7)
                        {
                            $movement = ' Job Opening ';
                        }

                        $heading = com_db_output($email_row['first_name'].' '.$email_row['last_name'].$movement.$email_row['title'].' at '.$email_row['company_name']);
                        $personal_image = $email_row['personal_image'];
                        if($personal_image !='')
                        {
                            $personal_image_path = HTTPS_SITE_URL.'personal_photo/small/'.$personal_image;
                        }
                        else
                        {
                            $personal_image_path = HTTPS_SITE_URL.'personal_photo/small/no_image_information.png';
                        }

                        if($email_row['more_link'] =='')
                        {
                            $messageSrt_4 .='<table width="100%" border="0" cellspacing="0" cellpadding="20">
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

                        }
                        else
                        {
                            $sf = "";
                            if($_GET['show_sf'] == 1) // Speaking Engagements Sectopm
                            {    
                                $sf_company_name = $email_row['company_name'];
                                $sf_title = $email_row['title'];
                                $sf_email = $email_row['email'];
                                $sf_phone = $email_row['phone'];
                                //$email_row['title']
                                //$email_row['email']
                                //echo "<pre>psRow:";   print_r($psRow);   echo "</pre>"; die();
                                $sf = "<td width=70></td><td class=links><a target=_blank href=".HTTPS_SITE_URL."salesforce/oauth.php?fname=".urlencode($pFirstName)."&lname=".urlencode($pLastName)."&company_name=".urlencode($sf_company_name)."&title=".urlencode($sf_title)."&email=".urlencode($sf_email)."&phone=".urlencode($sf_phone)."><img width=18px height=18px title=".$addLeadText." src=".HTTPS_SITE_URL."images/salesforce.png></a></td>";
                            }

                            $messageSrt_4 .='<table width="100%" border="0" cellspacing="0" cellpadding="20">
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
                                                                            '.$sf.'        
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
                } // Ending If condition - don't add same personal twice

            }//end while
            if($messageSrt_4!='')
            {
                $message .= '<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTPS_SITE_URL.'images/box_top.jpg" alt="" border="0" width="660" height="5" /></div></div>
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
                                                                    <td class="h2" style="color:#ffffff; font-family:Arial; font-size:18px; line-height:22px; text-align:left; font-weight:bold">Top Appointments - Learning and Development Executives</td>
                                                                </tr>
                                                            </table>
                                                            <div style="font-size:0pt; line-height:0pt; height:1px; background:#4785ca; "><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
                                                            '.$messageSrt_4.'
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
        // Section four ends
        
        
        //}
	
	
        $message = $messageHead.$person_image_name.$message.$messageFooter;
          
        //echo "<br>message: ".$message;
          
        $demoEmail = com_db_input($message);
        $emailDetails = com_db_input($message);
        $email_id = $email_alert_id;
        $add_date = date("Y-m-d");
        $all_person_id = implode(",", $person_id_info);
        $demoEmailQuery = "INSERT INTO " . TABLE_DEMO_SUMMARY_EMAIL_INFO . "(all_move_id, all_person_id, sent_email, email_details,email_id,triggers_name,add_date) values('".$all_move_id."','". $all_person_id."','$demoEmail','$emailDetails','$email_id','$triggers_name','".$add_date."')";	
        com_db_query($demoEmailQuery);
        com_redirect("top-a-email.php?selected_menu=demoemail&msg=" . msg_encode("Summary Demo Email Successfully created"));

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

function AllRecored(numRows)
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
        var agree=confirm("Selected person will be demo email. \n Do you want to continue?");
        if (agree)
            document.topicform.submit();
        else
            window.location = "top-a-email.php?selected_menu=demoemail";
    }	

}

function confirm_del(nid,section_type,company_id,type)
{
    var agree=confirm("Person will be deleted from Demo summary. \n Do you want to continue?");
    if (agree)
    {
        window.location = "top-a-email.php?selected_menu=demoemail&pID=" + nid + "&action=delete&section_type="+section_type;
    }
    else
    {
        window.location = "top-a-email.php?selected_menu=demoemail&pID=" + nid + "&p=" + p ;
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
            window.location = "top-a-email.php?selected_menu=demoemail";
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
            
            <!--
            <form name="delform" action="demo-email.php?action=DeleteMultipleRecord&selected_menu=demoemail" method="post"></form>
            </form>
            -->

        <form name="topicform" action="top-a-email.php?action=DemoEmailCreate&selected_menu=demoemail" method="post">
            <input type="hidden" name="multiple_del" id="multiple_del" value="">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
                <tr>
                    <td align="center" valign="middle" class="right">
                        <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="19%" align="left" valign="middle" class="heading-text">Top Appointment</td>
                                <td width="50%" align="left" valign="middle" class="message"><?=$msg?></td>
                                <td width="31%" align="left" valign="middle">
                                    <!-- <input type="button" value="Delete" onclick="AllRecored_del('<?=$numRows?>');" >
                                    &nbsp;&nbsp; -->
                                    <input type="button" value="Generate Summary Demo Email" onclick="AllRecored('<?=$numRows?>');" >
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td align="left" valign="top" class="right-bar-content-border">
                        <table width="100%" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="22" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-title-text">#</span></td>
                                <td width="20" height="30" align="center" valign="middle" class="right-border">
                                <input type="checkbox" name="all" id="all" onclick="CheckAll('<?=$numRows?>');" /></td>
                                <td width="110" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Person Name</span> </td>
                                <td width="127" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Type</span> </td>
                                <td width="84" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Add Date</span> </td>
                                <td width="67" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Action</span> </td>
                            </tr>
                            <?php
                            $jobs_row = 0;
                            $funding_row = 0;
                            if($total_data>0) 
                            {
                                $i=$starting_point+1;
                                $select_trigger='';
                                while ($data_sql = com_db_fetch_array($exe_data)) 
                                {
                                    $top_appointments = $data_sql['top_appointments'];

                                    if($top_appointments == 1)
                                    {    
                                        $app_type = "Senior HR Executives";
                                        $arr_name = 'a';
                                    }    
                                    elseif($top_appointments == 2)
                                    {    
                                        $app_type = "Recruiting Executives";
                                        $arr_name = 'b';
                                    }    
                                    elseif($top_appointments == 3)
                                    {    
                                        $app_type = "Benefits Executives";
                                        $arr_name = 'c';
                                    }    
                                    elseif($top_appointments == 4)
                                    {    
                                        $app_type = "Learning and Development Executives";    
                                        $arr_name = 'd';
                                    }    

                              ?>          
                            <tr>
                                <td height="30" align="center" valign="middle" class="right-border-left"><?=$i;?></td>
                                <td height="30" align="center" valign="middle" class="right-border"><input type="checkbox" id="person_id-<?=$i;?>" name="<?=$arr_name?>id[]" value="<?=$data_sql['personal_id'];?>" /></td>
                                <td height="30" align="left" valign="middle" class="right-border-text"><?=com_db_output($data_sql['first_name'].' '.$data_sql['last_name'])?></td>
                                <td height="30" align="left" valign="middle" class="right-border-text"><?=$app_type?></td>
                                <td height="30" align="center" valign="middle" class="right-border"><?=$add_date;?></td>
                                <td height="30" align="center" valign="middle" class="right-border"><a href="#"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" title="Delete" border="0" onclick="confirm_del('<?=$data_sql['personal_id'];?>','<?=$top_appointments;?>','','')" /></a><br />
                                    Delete
                                </td>
                            </tr> 
                              <?php

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