<?php
require('../includes/configuration.php');
include('../includes/only_dataentry_include-top.php');

$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';

ini_set('auto_detect_line_endings', true);

function generate_email_address($fn,$mn,$ln,$email_domain,$pattern)
{
    //$email_domain = "gw.com";

    $first_name_initial = "";
    $middle_name_initial = "";
    $last_name_initial = "";
    $generated_email = "";
    //$fn = "faraz";
    //$mn = "Ch";
    //$ln = "aleem";
    //$pattern = $_GET['p'];

    if($pattern == 1 || $pattern == 9 ||  $pattern == 10 || $pattern == 12 || $pattern == 14 || $pattern == 15 || $pattern == 16 || $pattern == 17 || $pattern == 18 || $pattern == 19 || $pattern == 20 || $pattern == 24 || $pattern == 26 || $pattern == 27 || $pattern == 28)
    //if(strpos($pattern,'First name initial') > -1 )
    {
            $first_name_initial = substr($fn, 0, 1);

    }
    if($pattern == 5 || $pattern == 12 ||  $pattern == 27 || $pattern == 28)
    //if(strpos($pattern,'initial of last name') > -1)
    {
            $last_name_initial = substr($ln, 0, 1);

    }

    if($pattern == 14 || $pattern == 22 ||  $pattern == 23 || $pattern == 28)
    //if(strpos($pattern,'middle name initial') > -1)
    {
            $middle_name_initial = substr($mn, 0, 1);

    }



    if($pattern == 1)
    {
            $generated_email = $first_name_initial.$ln;
    }
    elseif($pattern == 2)
    {
            $generated_email = $fn.".".$ln;
    }
    elseif($pattern == 3)
    {
            $generated_email = $fn;
    }
    elseif($pattern == 4)
    {
            $generated_email = $fn.$last_name_initial;
    }
    elseif($pattern == 5)
    {
            $generated_email = $fn."_".$ln;
    }
    elseif($pattern == 6)
    {
            $generated_email = $ln;
    }
    elseif($pattern == 7)
    {
            $generated_email = $fn.$ln;
    }
    elseif($pattern == 8)
    {
            $generated_email = $ln.$first_name_initial;
    }
    elseif($pattern == 9)
    {
            $generated_email =  $first_name_initial.".".$ln;
    }
    elseif($pattern == 10)
    {
            $generated_email = $ln.".".$fn;
    }
    elseif($pattern == 11)
    {
            $generated_email = $last_name_initial.$fn;
    }
    elseif($pattern == 12)
    {
            $generated_email = $fn."-".$ln;
    }
    elseif($pattern == 13) // seems wrong in xls
    {
            $generated_email = $first_name_initial.$first_name_initial.$ln;
    }
    elseif($pattern == 14)
    {
            $generated_email = $first_name_initial.substr($fn, 0, 2);
    }
    elseif($pattern == 15)
    {
            $generated_email = $first_name_initial.substr($fn, 0, 5);
    }
    elseif($pattern == 16)
    {
            $generated_email = $first_name_initial.substr($fn, 0, 4);
    }
    elseif($pattern == 17)
    {
            $generated_email = $first_name_initial.substr($fn, 0, 3);
    }
    elseif($pattern == 18)
    {
            $generated_email = $first_name_initial.substr($fn, 0, 7);
    }
    elseif($pattern == 19)
    {
            $generated_email = $first_name_initial.substr($fn, 0, 6);
    }
    elseif($pattern == 20)
    {
            $generated_email = $ln."_".$fn;
    }
    elseif($pattern == 21)
    {
            $generated_email = $fn.".".$middle_name_initial.".".$ln;
    }
    elseif($pattern == 22)
    {
            $generated_email = $fn."_".$middle_name_initial."_".$ln;
    }
    elseif($pattern == 23)
    {
            $generated_email = $ln.".".$first_name_initial;
    }
    elseif($pattern == 24)
    {
            $generated_email = $ln."_".substr($fn, 0, 2);
    }
    elseif($pattern == 25)
    {
            $generated_email =  $first_name_initial."_".$ln;
    }
    elseif($pattern == 26)
    {
            $generated_email = $first_name_initial.$last_name_initial;
    }
    elseif($pattern == 27)
    {
            $generated_email = $first_name_initial.$middle_name_initial.$last_name_initial;
    }

    $complete_email_address = $generated_email."@".$email_domain;
    $complete_email_address = trim($complete_email_address);
    //echo $complete_email_address;
    return $complete_email_address;
		
}
//echo "FUNCT: ".getting_email_pattern("far","ch","alee","dssd.com","dfdds@gmail.com");
//die();

function csv_to_array($input, $delimiter=',')
{
    $header = null;
    $data = array();
    $csvData = str_getcsv($input, "\n");

    foreach($csvData as $csvLine){
        if(is_null($header)) $header = explode($delimiter, $csvLine);
        else{

            $items = explode($delimiter, $csvLine);

            for($n = 0, $m = count($header); $n < $m; $n++){
                $prepareData[$header[$n]] = $items[$n];
            }

            $data[] = $prepareData;
        }
    }

    return $data;
}

function csv_to_array2($filename='', $delimiter=',')
{
	if(!file_exists($filename) || !is_readable($filename))
		return FALSE;
	
	$header = NULL;
	$data = array();
	if (($handle = fopen($filename, 'r')) !== FALSE)
	{
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
            {
                if(!$header)
                        $header = $row;
                else
                        $data[] = array_combine($header, $row);
            }
            fclose($handle);
	}
	return $data;
}


switch ($action) 
{
    case 'save':
	  	
        $data_file = $_FILES['data_file']['tmp_name'];

        if($data_file!='')
        {
            if(is_uploaded_file($data_file))
            {
                $org_file = $_FILES['data_file']['name'];
                $exp_file = explode("." , $org_file);
                $new_file_name = str_replace(' ','_',$org_file);
                $new_file_name = str_replace('+','_',$new_file_name);
                $new_file_name = date('YmdHms').'_'.$new_file_name;
                $get_ext = $exp_file[sizeof($exp_file) - 1];
                if($get_ext=='csv')
                {


                    $destination_file = '../UploadsFiles/' . $new_file_name; //$org_file;
                    if(move_uploaded_file($data_file , $destination_file))
                    {
                        //$columnheadings = 1;	
                        $columnheadings = 0;	
                        //$filecontents = file ($destination_file);
                        
                        $filecontents = csv_to_array2($destination_file);
                        //echo "<pre>filecontents: ";	print_r($filecontents);	echo "</pre>";
                        //die();
                        //caption start
                        //$col_fld_cap = array('Company Name','Company Website','Company Logo','Company Revenue','Company Employees','Industry','Email Pattern','Leadership Page','Address','Address 2','City','Country','State','Zip Code','Phone','Fax','About Company','Facebook Link','Linkedin Link','Twitter Link','Google+ Link');
                        $col_fld_cap = array('first_name','last_name','title','company_url');
                        $capnewString = $filecontents[0];
                        $capnewArray = explode(',', $capnewString);

                        $id_col = "company_id";//$capnewArray[0];
                        $col = trim($capnewArray[1]);
                        //echo "<pre>";	print_r($col_fld_cap);	echo "</pre>";
                        //echo "<br><br>Col:".$col.":"; 
                        
                        /*
                        if (in_array($col, $col_fld_cap)) 
                        {
                            //echo "wtihn iff";
                        }
                        else
                        {
                            //echo "<br>Within else";die();
                            $msg = "Field in csv file doesn't mached with any column of DB table.";
                            com_redirect("quick_loader.php?selected_menu=master&msg=" . msg_encode($msg));	
                        }
                        */
                        
                        //echo "<br>Before for loop";
                        //echo "<br>columnheadings: ".$columnheadings;
                        //echo "<br>size of filecontents: ".sizeof($filecontents);
                            //caption end
                        for($i=$columnheadings; $i<sizeof($filecontents); $i++) 
                        {
                            $strQuery = '';
                            $strQuery1 = '';
                            $strQuery2 = '';
                            $newString = $filecontents[$i];
                            //$newArray = explode(',', $newString);
                            
                            $newArray = $newString;
                            
                            $personal_insert_id = "";
                            

                            if(sizeof($newArray)== 4)
                            {
                                //echo "<pre>newArray: ";   print_r($newArray);   echo "</pre>";
                                //$companyQuery = $strQuery.$strQuery1.$strQuery2;
                                //echo "<br><br><br><br>Str Q: ".$companyQuery;
                                //com_db_query($companyQuery);
                                
                                //$sql_query = "";
                                //$exe_query = com_db_query($sql_query);
                                //$num_rows = com_db_num_rows($exe_query);
                                
                                $f_name = "";
                                $l_name = "";
                                
                                $import_company_url = com_db_input(str_replace(';',',',trim($newArray['company_url'])));
                                $import_first_name = com_db_input(str_replace(';',',',trim($newArray['first_name'])));
                                $import_last_name = com_db_input(str_replace(';',',',trim($newArray['last_name'])));
                                $import_title = com_db_input(str_replace(';',',',trim($newArray['title'])));
                                
                                $today_date = date ('Y-m-j');
                                
                                //$get_comp_query = "select count(*) as rec_count from " . TABLE_COMPANY_MASTER . " where company_website = '".$import_company_url."'";
                                $get_comp_query = "select company_id,email_pattern_id,company_name,phone,email_domain from " . TABLE_COMPANY_MASTER . " where company_website = '".$import_company_url."'";
                                //echo "<br>sql_get_query: ".$get_comp_query;
                                $get_comp_res = com_db_query($get_comp_query);
                                $comp_count = com_db_num_rows($get_comp_res);
                                $about_person_auto = "";
                                //$comp_count = com_db_output($comp_res['rec_count']);
                                //echo "<br>comp_count: ".$comp_count;
                                
                                $email_pattern_id = "";
                                $company_id = "";
                                $company_name = "";
                                $company_phone = "";
                                $company_email_domain = "";
                                // Company exist
                                if($comp_count > 0)
                                {
                                    
                                    $comp_res = com_db_fetch_array($get_comp_res);
                                    $email_pattern_id = $comp_res['email_pattern_id'];
                                    $company_id = $comp_res['company_id'];
                                    $company_name = $comp_res['company_name'];
                                    $company_phone = $comp_res['phone'];
                                    $company_email_domain = $comp_res['email_domain'];

                                    //$get_pattern_query = "select email_pattern_id from " . TABLE_COMPANY_MASTER . " where company_website = '".$import_company_url."'";
                                    //echo "<br>sql_get_pattern_query: ".$get_pattern_query;
                                    //$get_pattern_res = com_db_query($get_pattern_query);
                                    //$pattern_res = com_db_fetch_array($get_pattern_res);
                                    //$email_pattern_id = com_db_output($pattern_res['email_pattern_id']);
                                    
                                    $generated_email = "";
                                    
                                   // echo "<br>First name : ".$import_first_name;
                                   // echo "<br>Last name : ".$import_last_name;
                                   // echo "<br>Email domain : ".$company_email_domain;
                                   // echo "<br>Email pattern : ".$email_pattern_id;
                                    
                                    
                                    $f_name = str_replace(" ", "", $import_first_name);
                                    $l_name = str_replace(" ", "", $import_last_name);
                                    
                                    if($email_pattern_id != '' && $email_pattern_id != '0' && $company_email_domain != '')
                                        $generated_email = generate_email_address($f_name,"",$l_name,$company_email_domain,$email_pattern_id);
                                   // echo "<br>generated_email : ".$generated_email;
                                    
                                    $personal_status_off = 0;
                                        $move_status_off = 0;
                                    if($generated_email == '')
                                    {
                                        $personal_status_off = 1;
                                        $move_status_off = 1;
                                    }
                                    
                                    
                                    
                                    $get_personal_query = "select count(*) as personal_rec_count from " . TABLE_PERSONAL_MASTER . " where first_name = '".$import_first_name."' and last_name = '".$import_last_name."'";
                                    //echo "<br>sql_get_query: ".$get_personal_query;
                                    $get_personal_res = com_db_query($get_personal_query);
                                    $personal_res = com_db_fetch_array($get_personal_res);

                                    $personal_count = com_db_output($personal_res['personal_rec_count']);
                                    //echo "<br>personal_count: ".$personal_count;
                                    
                                    $company_name = com_db_input($company_name);
                                    
                                    $about_person_auto = $import_first_name.' '.$import_last_name.' is '.$import_title.' at '.$company_name.'. Previously, '.$import_first_name.' held various senior IT leadership roles in the industry.';
                                    //echo "<br>about_person_auto: ".$about_person_auto;
                                    if($email_pattern_id == '' ||  $email_pattern_id == '0')
                                    {
                                       // company exists, but a pattern doesn't 
                                       // the script will create a record, make it inactive and leave the email field empty. 
                                    
                                       if($personal_count == 0)
                                       {
                                           // company exists, but a pattern doesn't
                                           // the script will create a record, make it inactive and leave the email field empty.
                                           // Case 3
                                            $add_user_query = "INSERT into " . TABLE_PERSONAL_MASTER . "(first_name, last_name,status,quick_loader_result,about_person,phone,add_date,email,create_by) values('$import_first_name','$import_last_name',1,'email_bounce','$about_person_auto','$company_phone','$today_date','$generated_email','quick_load')";
                                            //echo "<br>cae 3 add_user_query: ".$add_user_query;
                                            com_db_query($add_user_query);
                                            $personal_insert_id = com_db_insert_id();

                                            
                                            $add_movement_query = "insert into " . TABLE_MOVEMENT_MASTER . "(personal_id, company_id,title,effective_date,announce_date,movement_type,source_id,add_date,status,create_by) values('$personal_insert_id','$company_id','$import_title','$today_date','$today_date',1,2,'$today_date',1,'quick_load')";
                                            //echo "<br>add_movement_query: ".$add_movement_query;
                                            com_db_query($add_movement_query);
                                       }
                                       else
                                       {
                                           // If the company exists, the same person exists, no email patter
                                           // the script will generate an inactive record with empty email field
                                           
                                            $add_user_query = "INSERT into " . TABLE_PERSONAL_MASTER . "(first_name, last_name,status,quick_loader_result,about_person,phone,add_date,email,create_by) values('$import_first_name','$import_last_name',1,'email_bounce','$about_person_auto','$company_phone','$today_date','$generated_email','quick_load')";
                                            //echo "<br>line 372 add_user_query: ".$add_user_query;
                                            com_db_query($add_user_query);
                                            $personal_insert_id = com_db_insert_id();


                                            $add_movement_query = "insert into " . TABLE_MOVEMENT_MASTER . "(personal_id, company_id,title,effective_date,announce_date,movement_type,source_id,add_date,status,create_by) values('$personal_insert_id','$company_id','$import_title','$today_date','$today_date',1,2,'$today_date',1,'quick_load')";
                                            //echo "<br>add_movement_query: ".$add_movement_query;
                                            com_db_query($add_movement_query);
                                       }    
                                        
                                    }   
                                    else
                                    { // PATTERN EXISTS
                                        if($personal_count > 0) // CASE WHEN COMPANY,PATTERN AND PERSON EXISTS , then the script will autogenerate the profile, but make it inactive. 
                                        {
                                            // if the company, pattern and person exist, then the script will autogenerate the profile, but make it inactive
                                            $add_user_query = "INSERT into " . TABLE_PERSONAL_MASTER . "(first_name, last_name,status,quick_loader_result,about_person,phone,add_date,email,create_by) values('$import_first_name','$import_last_name',1,'email_bounce','$about_person_auto','$company_phone','$today_date','$generated_email','quick_load')";
                                            //echo "<br>line 389 add_user_query: ".$add_user_query;
                                            com_db_query($add_user_query);
                                            $personal_insert_id = com_db_insert_id();
                                            
                                            
                                            $add_movement_query = "insert into " . TABLE_MOVEMENT_MASTER . "(personal_id, company_id,title,effective_date,announce_date,movement_type,source_id,add_date,status,create_by) values('$personal_insert_id','$company_id','$import_title','$today_date','$today_date',1,2,'$today_date',1,'quick_load')";
                                            //echo "<br>add_movement_query: ".$add_movement_query;
                                            com_db_query($add_movement_query);
                                        }
                                        else
                                        {
                                            // TODO - script will auto-generate the new record(movement and personal) with the email and make the profile active.
                                            $add_user_query = "INSERT into " . TABLE_PERSONAL_MASTER . "(first_name, last_name,status,quick_loader_result,about_person,phone,add_date,email,create_by) values('$import_first_name','$import_last_name',$personal_status_off,'email_bounce','$about_person_auto','$company_phone','$today_date','$generated_email','quick_load')";
                                            //echo "<br>line 402 add_user_query: ".$add_user_query;
                                            com_db_query($add_user_query);
                                            $personal_insert_id = com_db_insert_id();
                                            
                                            
                                            $add_movement_query = "insert into " . TABLE_MOVEMENT_MASTER . "(personal_id, company_id,title,effective_date,announce_date,movement_type,source_id,add_date,create_by) values('$personal_insert_id','$company_id','$import_title','$today_date','$today_date',1,2,'$today_date','quick_load')";
                                            //echo "<br>add_movement_query: ".$add_movement_query;
                                            com_db_query($add_movement_query);
                                            
                                        }    
                                    }    
                                }
                                else
                                {
                                    // If the company doesn't exist, then the script will create a record without a company and make it inactive.
                                    $add_user_query = "INSERT into " . TABLE_PERSONAL_MASTER . "(first_name, last_name,status,quick_loader_result,about_person,phone,add_date,email,create_by) values('$import_first_name','$import_last_name',1,'email_bounce','$about_person_auto','$company_phone','$today_date','$generated_email','quick_load')";
                                    //echo "<br>line 418 add_user_query: ".$add_user_query;
                                    com_db_query($add_user_query);
                                    $personal_insert_id = com_db_insert_id();


                                    $add_movement_query = "insert into " . TABLE_MOVEMENT_MASTER . "(personal_id, company_id,title,effective_date,announce_date,movement_type,source_id,add_date,status,create_by) values('$personal_insert_id','','$import_title','$today_date','$today_date',1,2,'$today_date',1,'quick_load')";
                                    //echo "<br>add_movement_query: ".$add_movement_query;
                                    com_db_query($add_movement_query);
                                }    
                                
                                
                            }
                            else
                            {
                                $msg = "File column numbers is ".sizeof($newArray).', But Import required is 2 columns';
                                //com_redirect("quick_loader.php?selected_menu=master&msg=" . msg_encode($msg));	
                            }
                        } 
                        $msg = "Data successfully appended.";
                        com_redirect("quick_loader.php?selected_menu=master&msg=" . msg_encode($msg));	
                    }
                    else
                    {
                        $msg = "File not imported.";
                        com_redirect("quick_loader.php?selected_menu=master&msg=" . msg_encode($msg));	
                    }	

                }
                else
                {
                    $msg = "Please select the .CSV file.";
                    com_redirect("quick_loader.php?selected_menu=master&msg=" . msg_encode($msg));	
                }	
            }
        }
        else
        {
            $msg = "Please select file.";
            com_redirect("quick_loader.php?selected_menu=master&msg=" . msg_encode($msg));
        }
    break;
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CTOsOnTheMove.com</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<!--<link href="../css/combo-box.css" rel="stylesheet" type="text/css" />-->
<link rel="shortcut icon" href="../images/favicon.jpg" type="image/x-icon" />
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="only-dataentry.js"></script>
  
<script type="text/javascript" src="../js/datetimepicker_css.js" language="javascript"></script>  


<script type="text/javascript" src="selectuser.js" language="javascript"></script>
</head>
<body>


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
                        <?PHP include_once("includes/top-menu.php"); ?>
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
                        <span class="right-box-title-text"><?=$msg?></span>
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
                    <td align="left" valign="middle" class="press-release-page-title-text">Quick Loader : </td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><img src="<?=HTTP_SERVER.DIR_WS_HTTP_FOLDER.DIR_IMAGES?>specer.gif" width="1" height="10" alt="" title="" /></td>
                  </tr>
              
              </table></td>
            </tr>
          </table></td>
        </tr>
	
        <tr>
            <td align="center" valign="top">
		 
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                
                
                <tr>
                    <td style="padding-top:10px;text-align:center;"><a href="download-quick-loader-info.php?type=Sample">Sample CSV Download</a></td>
                </tr>    
                
                
                
                
                <tr>
                    <td align="left" valign="top">
                        <table width="100%" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="left" valign="top" class="right-border-box">
                                    <form name="frmDataAdd" id="frmDataAdd" method="post" action="quick_loader.php?action=save" enctype="multipart/form-data">
                                        <table width="100%" align="left" cellpadding="5" cellspacing="5" border="0">
                                            <tr>
                                                <td align="left">
                                                    <table width="100%" cellpadding="4" cellspacing="4" border="0">
                                                      <tr>
                                                        <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;File:</td>
                                                        <td width="75%" align="left" valign="top">
                                                            <input type="file" name="data_file" id="data_file" size="50" />
                                                        </td>	
                                                      </tr>

                                                    </table>
                                                </td>	
                                            </tr>
                                            <tr>
                                                <td align="center">
                                                        <table width="50%" border="0" cellpadding="4" cellspacing="4">
                                                        <tr><td><input type="submit" value="Process" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="Cancel" onclick="window.location='events.php?p=<?=$p;?>'" /></td></tr>
                                                    </table>
                                                </td>
                                            </tr>
            
                                        </table>
                                    </form>
                                </td>
                            </tr>
                        </table>
                    </td>
		 </tr>
            </table>
        </td>
    </tr>
	

		
      </table></td>
      <td align="left"  valign="top">&nbsp;</td>
    </tr>

	<?PHP include_once("includes/footer-menu.php"); ?>
    
    <tr>
      <td align="left"  valign="top">&nbsp;</td>
      <td align="left" valign="top">
        <table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td align="center" valign="top" class="copyright-text">Copyright &copy; <?=date("Y");?> HREXECsonthemove. All rights reserved.</td>
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
