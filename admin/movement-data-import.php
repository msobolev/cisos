<?php
// LATEST VERSION
//If the email does not exist in the "Persons Database"
//(1.1a) If there is an existing movement with the same FirstName, LastName, CompanyUrl and Type - it is probably a duplicate, DO NOT UPLOAD

// My addition: Email doesnt exist in the "Persons Database" and no to (1.1a) then Adding in Persons Database and then adding a movement


function validateDate($date, $format = 'n/j/Y H:i:s')
{
	$full_date = $date." 00:00:00";
	$d = DateTime::createFromFormat($format, $full_date);
	return $d && $d->format($format) == $full_date;
}


//var_dump(validateDate('4/6/2010')); # true
//var_dump(validateDate('12/02/2014')); # false

//die();

ini_set('auto_detect_line_endings', true);
require('includes/include_top.php');



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

function check_phone($number)
{
	$regex = "/^(\d[\s.]?)?[\(\[\s.]{0,2}?\d{3}[\)\]\s.]{0,2}?\d{3}[\s.]?\d{4}$/i";
	$number = trim($number);
	if(preg_match( $regex, $number ))
	{
		if(strlen($number) == 12 && strpos($number, ' ') == '')
		{
			return true;	//echo "<br>".$number . ': True'; 
		}	
		else
		{
			return false;  //echo "<br>".$number . ': False'; 
		}	
	}
	else
	{
		return false;//echo "<br>".$number . ': False'; 
	}	

}	


$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';
$error_list = (isset($_GET['error_list'])) ? msg_decode($_GET['error_list']) : '';
    switch ($action) {
      case 'save':
	  
	  
			$dup_count = 0;
			$rec_uploaded = 0;
			$rec_rejected = 0; 
			$dup_count_file = fopen("duplicate_movements.csv", "w") ;
			
			$rec_uploaded_file = fopen("rec_uploaded_movements.csv", "w"); 
			$rec_rejected_file = fopen("rec_rejected_movements.csv", "w");
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
							//caption start
							//$col_fld_cap = array('First Name','Middle Initial','Last Name','Title','Headline','Company Name','Company Website','Industry','Address','City','State','Zip Code','Country','Phone','Email','Date of announcement','Effective Date','Type','The full text of the press release','Link','Company Size Employees','Company Size Revenue','Source','Short Url','What Happened','About Person','About Company','More Link','Contact URL','Not Current?');
							//$col_fld_cap = array('First Name','Middle Initial','Last Name','Email','Phone','About Person','Title','Headline','Company Name','Company Website','Date of announcement','Effective Date','Type','The full text of the press release','Link','Source','Short Url','What Happened','More Link','Movement-URL','Not Current?');$col_fld_cap = array('First Name','Middle Initial','Last Name','Email','Phone','About Person','Title','Headline','Company Name','Company Website','Date of announcement','Effective Date','Type','The full text of the press release','Link','Source','Short Url','What Happened','More Link','Movement-URL','Not Current?');
							//$col_fld_cap = array('First Name','Middle Initial','Last Name','Title','Headline','Company Website','Email','Date of announcement','Effective Date','Type','The full text of the press release','Link','Source','Short Url','What Happened','About Person','More Link','Contact URL','Not Current?');							
							$col_fld_cap = array('First Name','Middle Initial','Last Name','Email','About Person','Title','Headline','Company Website','Date of announcement','Effective Date','Type','The full text of the press release','Link','Source','Short Url','What Happened','More Link','Movement URL','Not Current?');							
                                                        //$col_fld_cap = array('First Name','Middle Initial','Last Name','Title','Email','Announcement Date','Effective Date','What Happened','Company Website','About Person');							
							$capnewString = $filecontents[0];
							$capnewArray = explode(',', $capnewString);
							$cap=0;
							$cap_flag = 0;
							$error_list='';
							foreach($capnewArray as $capkey => $capvalue){
								if(strtoupper(trim($capnewArray[$cap])) != strtoupper(trim($col_fld_cap[$cap]))){
								//echo "<br><br>File heading: ".strtoupper(trim($capnewArray[$cap]));
								//echo "<br>Code heading: ".strtoupper(trim($col_fld_cap[$cap]));
									$error_list .= '&nbsp;&nbsp;Required field name is "'.trim($col_fld_cap[$cap]).'" not "'.trim($capnewArray[$cap]).'"<br />';
									$cap_flag = 1;
								}
								$cap++;
							}
							
							if($cap_flag==1){
								$msg = "Column name not matching in your CSV file, please check the column heading.";
								com_redirect("movement-data-import.php?selected_menu=movement&msg=" . msg_encode($msg)."&error_list=".msg_encode($error_list));
							}
							//caption end
							for($i=$columnheadings; $i<sizeof($filecontents); $i++) { 
								$strQuery = '';
								$strQuery1 = '';
								$strQuery2 = '';
								$newString = $filecontents[$i];
								$newArray = explode(',', $newString);
								//echo "<pre>newArray: ";	print_r($newArray);	echo "</pre>";
								$this_rejecteded_recs = "";
								$this_rec_rejected = 0;
								$this_dup_count = 0;

								if(sizeof($newArray)== 19)
								{ 
									$p=0;
									foreach($newArray as $key => $value)
									{
										if($p==0)
										{
											$import_first_name = trim(com_db_input(str_replace(';',',',trim($newArray[$p]))));
											
											if(strlen($import_first_name) == 1)
											{
												$this_rejecteded_recs = "First Name is not valid($import_first_name)";
												$rec_rejected++;
												$this_rec_rejected++;
											}
											
											
										}elseif($p==1 && $this_rec_rejected == 0){
											$import_middle_name = com_db_input(str_replace(';',',',trim($newArray[$p])));
										}elseif($p==2 && $this_rec_rejected == 0){
											$import_last_name = com_db_input(str_replace(';',',',trim($newArray[$p])));
											
											if(strlen($import_last_name) == 1)
											{
												$this_rejecteded_recs = "Last Name is not valid($import_last_name)";
												$rec_rejected++;
												$this_rec_rejected++;
											}
											
										}
										
										elseif($p==3){
											$import_email= com_db_input(str_replace(';',',',trim($newArray[$p])));
										}
										elseif($p==4){
											$import_about_person = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$import_about_person = str_replace('&&&','<br />', $import_about_person);
										}
										
										elseif($p==5){	
											$import_title = com_db_input(str_replace(';',',',trim($newArray[$p])));
										}
										elseif($p==6){	
											$import_headline = com_db_input(str_replace(';',',',trim($newArray[$p])));
										}
										elseif($p==7 && $this_rec_rejected == 0){	
											$import_company_website = com_db_input(str_replace(';',',',trim($newArray[$p])));
											
											if(check_url($import_company_website) == 0)
											{
												$this_rejecteded_recs = "Company Website is not valid ($import_company_website)";
												$rec_rejected++;
												$this_rec_rejected++;
											}
											
											
											//$rep   = array("http://", "https://","www.","/");
											//$import_company_website ="www.". str_replace($rep,'',$import_company_website);

										}
										
										elseif($p==8 && $this_rec_rejected == 0){
										
											$rec_announ_date = $newArray[$p];
											$date_check = validateDate($rec_announ_date);
											if($date_check == 1)
											{
												$ann_date = explode('/',trim($newArray[$p]));
												$import_announcement_date = $ann_date[2].'-'.$ann_date[0].'-'.$ann_date[1];
											}
											else
											{
												$this_rejecteded_recs = "Annoucement date format is not valid";
												$rec_rejected++;
												$this_rec_rejected++;
											}
											
										}elseif($p==9 && $this_rec_rejected == 0){
										
											$rec_effec_date = $newArray[$p];
											$date_effec_check = validateDate($rec_effec_date);
											if($date_effec_check == 1)
											{
												$eff_date = explode('/',trim($newArray[$p]));
												$import_effective_date = $eff_date[2].'-'.$eff_date[0].'-'.$eff_date[1];
											}
											else
											{
												$this_rejecteded_recs = "Effective date format is not valid";
												$rec_rejected++;
												$this_rec_rejected++;
											}
											
										}elseif($p==10 && $this_rec_rejected == 0){
											$import_movement_type = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$movement_type_id = com_db_GetValue("select id from " . TABLE_MANAGEMENT_CHANGE . " where name = '".$import_movement_type."'");
											if($movement_type_id==''){
												//$ins_query_movement_type = "insert into " . TABLE_MANAGEMENT_CHANGE ."(name)value('".$import_movement_type."')";
												//com_db_query($ins_query_movement_type);
												//$movement_type_id = com_db_insert_id();
												
												$this_rejecteded_recs = "Movement type is not valid";
												$rec_rejected++;
												$this_rec_rejected++;
												
											}	
											else
											{
												$import_movement_type = $movement_type_id;	
											}
										}
										
										elseif($p==11){
											$import_full_body = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$import_full_body = str_replace('&&&','<br />', $import_full_body);
										}elseif($p==12){
											$import_link = com_db_input(str_replace(';',',',trim($newArray[$p])));
										}
										
										elseif($p==13 && $this_rec_rejected == 0){
											$import_source = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$source_id = com_db_GetValue("select id from " . TABLE_SOURCE . " where source = '".$import_source."'");
											if($source_id==''){
												$this_rejecteded_recs = "Source is not valid";
												$rec_rejected++;
												$this_rec_rejected++;
											}
											else
											{
												$import_source=$source_id;
											}	
										}elseif($p==14){
											$import_short_url = com_db_input(str_replace(';',',',trim($newArray[$p])));
										}elseif($p==15){
											$import_what_happened = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$import_what_happened = str_replace('&&&','<br />', $import_what_happened);
										}
										
										
										
										
										
										
										
									
										
										elseif($p==16){
											$import_more_link = com_db_input(str_replace(';',',',trim($newArray[$p])));
										}elseif($p==17){
											$import_movement_url = com_db_input(str_replace(';',',',trim($newArray[$p])));
										}elseif($p==18){
											$import_not_current = com_db_input(str_replace(';',',',trim($newArray[$p])));
										}
										
										$p++;
									}
										$add_date = date("Y-m-d");
										$create_by="Admin";
										$login_id = '1';
										$status ='0';
										
										//$import_title
                                                                                //echo "<br>import_title: ".$import_title;
                                                                                $ciso_update = '';
                                                                                $ciso_user = 0;
                                                                                $import_title_lower = strtolower($import_title);
                                                                                $ciso_filters = array('CISO','ciso','Chief Information Security Officer','information security','cyber security','technology security','IT security','chief information security officer','Information Security','Cyber Security','Technology Security');
                                                                                foreach($ciso_filters as $kw)
                                                                                {
                                                                                    $kw = strtolower($kw);
                                                                                    //echo "<br>kw: ".$kw;
                                                                                    if(strpos($import_title_lower,$kw) > -1)
                                                                                    {
                                                                                        $ciso_user = 1;
                                                                                    }        
                                                                                }
                                                                                
                                                                                if($ciso_user == 1)
                                                                                {
                                                                                    //echo "<br>within if";
                                                                                    $ciso_user_col = ",ciso_user";
                                                                                    $ciso_user_clause = ",".$ciso_user;

                                                                                    $ciso_update = 'ciso_user = 1';
                                                                                }
                                                                                else
                                                                                {
                                                                                    $ciso_update = 'ciso_user = 0';
                                                                                }            
										//echo "<br>ciso_update: ".$ciso_update;
										//die();
										//echo "<br><br>Query: select company_id from ".TABLE_COMPANY_MASTER." where company_website='".$import_company_website."'";
										$company_id = com_db_GetValue("select company_id from ".TABLE_COMPANY_MASTER." where company_website='".$import_company_website."'");
										//echo "<br>FAR company_id in primary: ".$company_id;
											// checking for secondary and tertiary URLs
											if($company_id==''){
												$company_id = com_db_GetValue("select company_id from ".TABLE_COMPANY_WEBSITES." where company_website='".$import_company_website."'");
												//echo "<br>FAR company_id in secondary: ".$company_id;
											}
											
											
											
											
											if($company_id==''){
											
												//echo "<br>FAR Rejected cuz company doesnt exist";
												$this_rejecteded_recs = "Company websites donesn't exists in Company DB";
												$rec_rejected++;
												$this_rec_rejected++;
												
											}
										
										
										//echo "<br>this_rejecteded_recs: ".$this_rejecteded_recs;
										if($this_rejecteded_recs == '')
										{
											//echo "<br>In insert:".$import_company_website;
											$this_company_uploaded = 0;
											$this_person_uploaded = 0;
											$this_movement_uploaded = 0;
											
											//Company master
											//echo "<br>Company select Q:<br>select company_id from ".TABLE_COMPANY_MASTER." where company_website='".$import_company_website."'";
											
											

											//Personal master
											// checking if email exists in personal DB
											$person_id_for_email = com_db_GetValue("select personal_id from ".TABLE_PERSONAL_MASTER." where email='".$import_email."'");
											//echo "<br><br>FA person_id_for_email".$person_id_for_email;
											if($person_id_for_email == '')
											{
												
                                                                                            //echo "<br>FAR within ifffff";
                                                                                            $personal_id = com_db_GetValue("select pm.personal_id from "
                                                                                            .TABLE_PERSONAL_MASTER." as pm, "
                                                                                            .TABLE_COMPANY_MASTER. " as cm, "
                                                                                            .TABLE_MOVEMENT_MASTER. " as mm, "
                                                                                            .TABLE_MANAGEMENT_CHANGE." as m												
                                                                                            where (mm.company_id=cm.company_id and mm.personal_id=pm.personal_id and mm.movement_type = m.id and cm.company_website = '".$import_company_website."') and (first_name='".$import_first_name."'  and last_name='".$import_last_name."')");//and (phone='".$import_phone."' or email='".$import_email."')
                                                                                            //echo "<br>FAR after Q";
                                                                                            if($personal_id!='')
                                                                                            {
                                                                                                $dup_count++;
                                                                                                $this_dup_count++;
                                                                                            }	
                                                                                            else
                                                                                            {
                                                                                                // add the movement	, for this adding person first
                                                                                                //echo "<br>FAR within elseeee ifffff";
                                                                                                $perInsQuery = "insert into " . TABLE_PERSONAL_MASTER . "
                                                                                                (first_name, middle_name, last_name, email, phone, about_person, add_date, create_by, admin_id, status $ciso_user_col) 
                                                                                                values ('$import_first_name','$import_middle_name','$import_last_name','$import_email','$import_phone','$import_about_person','$add_date','$create_by','$login_id','$status', $ciso_user)";
                                                                                                com_db_query($perInsQuery);
                                                                                                $personal_id = com_db_insert_id();

                                                                                                $this_person_uploaded = 1;

                                                                                                //echo "<br>FAR Insert movement ONE";

                                                                                                $movIndQuery = "insert into " . TABLE_MOVEMENT_MASTER . "
                                                                                                (company_id, personal_id, title, headline, announce_date, effective_date, full_body,link,short_url,what_happened, movement_type, source_id, more_link, not_current, movement_url, add_date, create_by, admin_id, status,source_bulk_upload) 
                                                                                                values ('$company_id', '$personal_id', '$import_title','$import_headline','$import_announcement_date', '$import_effective_date','$import_full_body','$import_link','$import_short_url','$import_what_happened','$import_movement_type','$import_source','$import_more_link','$import_not_current','$import_movement_url', '$add_date', '$create_by','$login_id','$status',1)";
                                                                                                com_db_query($movIndQuery);
                                                                                                $move_id = com_db_insert_id();
                                                                                                $this_movement_uploaded = 1;	
                                                                                                //$uploaded_recs++;
                                                                                                $rec_uploaded++;
                                                                                                //$uploaded_recs .= "Move ID(".$move_id."):Company Name(".$import_company_name."):Person First Name(".$import_first_name."):Import Title(".$import_title.")\n";
                                                                                                $uploaded_recs .= "Move ID(".$move_id."):Company Website(".$import_company_website."):Person First Name(".$import_first_name.")\n";

                                                                                            }
											}
											
											else
											{
                                                                                            //echo "<br>FAR in elsee 421";
												$checking_contact_url = com_db_GetValue("select move_id from ".TABLE_MOVEMENT_MASTER." where personal_id = ".$person_id_for_email." and movement_url='".$import_movement_url."'");
												
                                                                                                //echo "<br>FAR in elsee 423:".$checking_contact_url;
                                                                                                
                                                                                                if($checking_contact_url==''){
													

													
													$movIndQuery = "insert into " . TABLE_MOVEMENT_MASTER . "
													(company_id, personal_id, title, headline, announce_date, effective_date, full_body,link,short_url,what_happened, movement_type, source_id, more_link, not_current, movement_url, add_date, create_by, admin_id, status,source_bulk_upload) 
													values ('$company_id', '$person_id_for_email', '$import_title','$import_headline','$import_announcement_date', '$import_effective_date','$import_full_body','$import_link','$import_short_url','$import_what_happened','$import_movement_type','$import_source','$import_more_link','$import_not_current','$import_movement_url', '$add_date', '$create_by','$login_id','$status',1)";
													
													//echo "<br>FAR Q: ".$movIndQuery;
													
													com_db_query($movIndQuery);
												
													$this_movement_uploaded = 1;	

													
													$uploaded_recs .= "Move ID(".$move_id."):Company Website(".$import_company_website."):Person First Name(".$import_first_name."):Import Title(".$import_title.")\n";
													$rec_uploaded++;
													
												}
												else
												{
													$dup_recs .= "Duplicate Move ID:".$checking_contact_url." ,First Name:".$import_first_name." ,Title:".$import_title."\n";
													//echo "<br>FAR In dup THIS SHD EXIST NOW , STATEMENT: ".$dup_recs;
													$dup_count++;
													$this_dup_count++;
												
												}

											}
											
											//movement master
											//$movement_id = com_db_GetValue("select move_id from ".TABLE_MOVEMENT_MASTER." where movement_url='".$import_movement_url."'"); 
											if($movement_id==''){}
										}	
										elseif($this_rejecteded_recs != '')
										{
											//echo "<br>FAR In else if :".$import_company_website;	
											//$dup_recs = "Duplicate Move ID:".$checking_contact_url." ,First Name:".$import_first_name." ,Title:".$import_title;
											$rejecteded_recs .= "First Name:".$import_first_name." ,Title:".$import_title." ,Company Website: ".$import_company_website." ,Reason:".$this_rejecteded_recs."\n";
											//echo $rejecteded_recs;
											//die("FA within else IF");
										}
										
										//echo "<br>Out of if and else if";
										}else{
										 //echo "<br>FAR Within size else "; 
											 //$msg = "File column numbers is ".sizeof($newArray).', But Import required is 30 columns';
											 //$msg = "Upload file format:      [X]";
											// com_redirect("movement-data-import.php?selected_menu=movement&msg=" . msg_encode($msg));	
											 
											$import_company_name = com_db_input(str_replace(';',',',trim($newArray[8])));
											
											$rec_rejected++;
											$this_rec_rejected++;
											
											$this_rejecteded_recs = "Row column numbers is ".sizeof($newArray)." but Import row required is 21 columns";
											$rejecteded_recs .= $import_company_name.":".$this_rejecteded_recs."\n";
											 
										}
							}
							//$msg = "File successfully imported.";
							
							//echo "<br>FAR Before writing";
							fwrite($dup_count_file,$dup_recs);
							fwrite($rec_uploaded_file,$uploaded_recs);
							fwrite($rec_rejected_file,$rejecteded_recs);
							$msg = "<table><tr><td colspan=2><strong>Status:</strong></td></tr><tr><td>Upload file format:</td><td>[V]</td></tr>";
							$msg .= "<tr><td>Duplicates found:</td><td>".$dup_count."&nbsp;<a href=\"download-file.php?file_name=duplicate_movements.csv\">File</a></td></tr>"; 
							$msg .= "<tr><td>Records uploaded:</td><td>     ".$rec_uploaded."&nbsp;<a href=\"download-file.php?file_name=rec_uploaded_movements.csv\">File</a></td></tr>";
							$msg .= "<tr><td>Records rejected:</td><td>     ".$rec_rejected."&nbsp;<a href=\"download-file.php?file_name=rec_rejected_movements.csv\">File</a></td></tr></table>";
							
							//echo $msg;
							
							fclose($dup_count_file);
							fclose($rec_uploaded_file);
							fclose($rec_rejected_file);
							
							//com_redirect("movement-data-import.php?selected_menu=movement&msg=" . msg_encode($msg));	
							}
						else
							{
							$msg = "File not imported.";
							com_redirect("movement-data-import.php?selected_menu=movement&msg=" . msg_encode($msg));	
							}	
						
						}else{
							$msg = "Please select the .CSV file.";
							com_redirect("movement-data-import.php?selected_menu=movement&msg=" . msg_encode($msg));	
						}	
					}
				}
				else
				{
					$msg = "Please select file.";
					com_redirect("movement-data-import.php?selected_menu=movement&msg=" . msg_encode($msg));
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
		
		  <form name="importfile" method="post" action="movement-data-import.php?selected_menu=movement&action=save" enctype="multipart/form-data" onsubmit="return checkForm();">	
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
			  	<td colspan="2" height="20" align="right" class="page-text"><a style="color:#1F37EF; text-decoration:underline;" href="download-movement-info.php?type=Sample">Sample CSV Download</a></td></tr>
			  <tr>
			  <tr>
			  	<td colspan="2" height="20" class="page-text">&nbsp;<?PHP if($error_list !=''){ echo '<b>Error List below :</b><br />'.$error_list.'<br />';} ?></td></tr>
			  <tr>
				<td width="15%" align="left" valign="top" class="page-text">&nbsp;&nbsp;&nbsp;&nbsp;File</td>
				<td width="85%" align="left" valign="top">
				  <input type="file" name="data_file" id="data_file" size="50" />    </td>
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