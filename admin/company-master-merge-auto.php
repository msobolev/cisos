<?php
ini_set('max_execution_time', 12000);
ini_set('upload_max_filesize', '6M');
ini_set('auto_detect_line_endings', true);

require('includes/include_top.php');

$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';
$error_list = (isset($_GET['error_list'])) ? msg_decode($_GET['error_list']) : '';

//echo "<pre>FILES: ";   print_r($_FILES);   echo "</pre>";

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
                        $columnheadings = 1;	
                        $filecontents = file ($destination_file);
                        //caption start
                        //$col_fld_cap = array('Company Name','Company Website','Company Logo','Company Revenue','Company Employees','Industry','Email Pattern','Leadership Page','Address','Address 2','City','Country','State','Zip Code','Phone','Fax','About Company','Facebook Link','Linkedin Link','Twitter Link','Google+ Link');
                        $col_fld_cap = array('company_name','company_website','company_logo','company_revenue','company_employees','company_industry','email_pattern','leadership_page','address','address2','city','country','state','zip_code','phone','fax','about_company','facebook_link','linkedin_link','twitter_link','googleplush_link','email_domain','mail_server_settings','email_pattern_id');
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
                            com_redirect("company-master-append.php?selected_menu=master&msg=" . msg_encode($msg));	
                        }
                         */

                        
                        //caption end
                        for($i=$columnheadings; $i<sizeof($filecontents); $i++) 
                        {
                            $strQuery = '';
                            $strQuery1 = '';
                            $strQuery2 = '';
                            $newString = $filecontents[$i];
                            $newArray = explode(',', $newString);
                            // echo "<pre>newArray: ";   print_r($newArray);   echo "</pre>"; 
                            if(sizeof($newArray)== 2)
                            {
                                $company_id_one = trim($newArray[0]);
                                $company_id_two = trim($newArray[1]);
                                
                                echo "<br><br><br>company_id_one: ".$company_id_one;
                                echo "<br>company_id_two: ".$company_id_two;
                                
                                
                                $company_id_one = trim($newArray[0]);
                                $company_id_two = trim($newArray[1]);
                                
                                
                                
                                $moveNumQuery = "select count(*) as companies_move_num from ".TABLE_MOVEMENT_MASTER." where company_id in ('".$company_id_one."','".$company_id_two."')";
                                //echo "<br>moveNumQuery: ".$moveNumQuery;
                                
                                $moResult = com_db_query($moveNumQuery);
                                $moRow = com_db_fetch_array($moResult);
                                $companies_move_num = $moRow['companies_move_num'];
                                echo "<br>company_move_count: ".$companies_move_num;
                                
                                if($companies_move_num == 0)
                                {
                                    $jobsNumQuery = "select count(*) as companies_jobs_num from ".TABLE_COMPANY_JOB_INFO." where company_id in ('".$company_id_one."','".$company_id_two."')";
                                    //echo "<br>moveNumQuery: ".$moveNumQuery;
                                
                                    $joResult = com_db_query($jobsNumQuery);
                                    $joRow = com_db_fetch_array($joResult);
                                    $companies_jobs_num = $joRow['companies_jobs_num'];
                                    echo "<br>companies_jobs_num: ".$companies_jobs_num;
                                    
                                    if($companies_jobs_num == 0)
                                    {
                                        $fundingsNumQuery = "select count(*) as companies_fundings_num from ".TABLE_COMPANY_FUNDING." where company_id in ('".$company_id_one."','".$company_id_two."')";
                                        //echo "<br>moveNumQuery: ".$moveNumQuery;
                                
                                        $fuResult = com_db_query($fundingsNumQuery);
                                        $fuRow = com_db_fetch_array($fuResult);
                                        $companies_fundings_num = $fuRow['companies_fundings_num'];
                                        echo "<br>companies_fundings_num: ".$companies_fundings_num;
                                    
                                        
                                        
                                        $sql_query = "select * from " . TABLE_COMPANY_MASTER . " as c where company_id in ('".$company_id_one."','".$company_id_two."') order by c.company_id desc";
                                        //echo "<br>Q: ".$sql_query;	
                                        $exe_data=com_db_query($sql_query);
                                        $num_rows=com_db_num_rows($exe_data);
                                        $total_data = $num_rows;	
                                        //echo "<br>Rows: ".$num_rows;
                                        $comp_1 = array();
                                        $comp_2 = array();
                                        $c = 0;
                                        while ($data_sql = com_db_fetch_array($exe_data)) 
                                        {
                                            $arr_name = "comp_".$c;

                                            $comps[$c]['company_id'] = $data_sql['company_id'];
                                            $comps[$c]['company_name'] = $data_sql['company_name'];
                                            $comps[$c]['company_website'] = $data_sql['company_website'];
                                            $comps[$c]['company_logo'] = $data_sql['company_logo'];
                                            $comps[$c]['company_revenue'] = $data_sql['company_revenue'];
                                            $comps[$c]['company_employee'] = $data_sql['company_employee'];
                                            $comps[$c]['company_industry'] = $data_sql['company_industry'];
                                            $comps[$c]['ind_group_id'] = $data_sql['ind_group_id'];
                                            $comps[$c]['industry_id'] = $data_sql['industry_id'];

                                            $comps[$c]['address'] = $data_sql['address'];
                                            $comps[$c]['address2'] = $data_sql['address2'];
                                            $comps[$c]['city'] = $data_sql['city'];
                                            $comps[$c]['state'] = $data_sql['state'];
                                            $comps[$c]['country'] = $data_sql['country'];
                                            $comps[$c]['zip_code'] = $data_sql['zip_code'];
                                            $comps[$c]['phone'] = $data_sql['phone'];
                                            $comps[$c]['fax'] = $data_sql['fax'];
                                            $comps[$c]['about_company'] = $data_sql['about_company'];

                                            $comps[$c]['linkedin_link'] = $data_sql['linkedin_link'];
                                            $comps[$c]['twitter_link'] = $data_sql['twitter_link'];

                                            $comps[$c]['leadership_page'] = $data_sql['leadership_page'];
                                            $comps[$c]['email_pattern'] = $data_sql['email_pattern_id'];
                                            $comps[$c]['email_domain'] = $data_sql['email_domain'];
                                            $comps[$c]['mail_server_settings'] = $data_sql['mail_server_settings'];

                                            $c++;
                                        }
                                        
                                        //$result = array_intersect( $comps[0],  $comps[1]);
                                        //print_r($result);
                                        //echo "<pre>Intersection: ";	print_r($result);	echo "</pre>";
                                     
                                        
                                        //array_diff
                                        $result = array_diff( $comps[0],  $comps[1]);
                                        //print_r($result);
                                        echo "<pre>array_diff: ";	print_r($result);	echo "</pre>";
                                        
                                        
                                        $only_keys = array_keys($result);
                                        echo "<pre>only_keys: ";	print_r($only_keys);	echo "</pre>";
                                     
                                        if(count($result) == 1 && $only_keys[0] == 'company_id')
                                        {
                                            $det_srt = "delete from " . TABLE_COMPANY_MASTER . " where company_id = '" . $company_id_one . "'";
                                            echo "<br>det_srt: ".$det_srt;
                                            
                                            com_db_query($det_srt);
                                            
                                            com_db_query("insert into ".TABLE_COMPANY_UPDATE_INFO."(page_name,query_string,add_date,cmo_status,cfo_status,clo_status,hre_status) values('admin-company-master','".com_db_input($det_srt)."','".date("Y-m-d:H:i:s")."','1','1','1','1')");
                                        }    
                                        
                                        
                                    }
                                    
                                }    
                                
                                
                                
                                
                                /*
                                $strQuery = "UPDATE " . TABLE_COMPANY_MASTER . " SET ";
                                $strQuery1 .= " ";
                                //$p=0;
                                $companyQuery = "";
                                $strQuery1 = "";
                                $strQuery2 = "";
                                $import_company_val = com_db_input(str_replace(';',',',trim($newArray[1])));
                                $strQuery1 .= $col." = '" . $import_company_val ."'";

                                $import_company_id = com_db_input(str_replace(';',',',trim($newArray[0])));
                                $strQuery2  = " WHERE ".$id_col." = ".$import_company_id;

                                $companyQuery = $strQuery.$strQuery1.$strQuery2;
                                //echo "<br><br><br><br>Str Q: ".$companyQuery;
                                com_db_query($companyQuery);


                                com_db_query("insert into ". TABLE_COMPANY_UPDATE_INFO."(page_name,query_string,add_date) values('admin-company-append','".com_db_input($companyQuery)."','".date("Y-m-d:H:i:s")."')");
                                */

                            }
                            else
                            {
                                    //die();
                                $msg = "File column numbers is ".sizeof($newArray).', But Import required is 2 columns';
                                com_redirect("company-master-merge-auto.php?selected_menu=master&msg=" . msg_encode($msg));	
                            }
                        } 
                        $msg = "Data successfully appended.";
                        //com_redirect("company-master-merge-auto.php?selected_menu=master&msg=" . msg_encode($msg));	
                    }
                    else
                    {
                        $msg = "File not imported.";
                        com_redirect("company-master-merge-auto.php?selected_menu=master&msg=" . msg_encode($msg));	
                    }	

                }
                else
                {
                    $msg = "Please select the .CSV file.";
                    com_redirect("company-master-merge-auto.php?selected_menu=master&msg=" . msg_encode($msg));	
                }	
            }
        }
        else
        {
            $msg = "Please select file.";
            com_redirect("company-master-merge-auto.php?selected_menu=master&msg=" . msg_encode($msg));
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
				  <td width="85%" valign="middle" class="message" align="left"><?=$msg?></td>
                 
                </tr>
              </table></td>
          </tr>
		 
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box">
		
		  <form name="importfile" method="post" action="company-master-merge-auto.php?selected_menu=master&action=save" enctype="multipart/form-data" onsubmit="return checkForm();">	
			<table width="60%" border="0" cellspacing="0" cellpadding="5">
			  <tr>
			  	<td colspan="2" height="20" align="right" class="page-text">
					<a href="download-company-append-info.php?type=Sample">Sample CSV Download</a>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="download-company-pattern-info.php?type=Sample">Sample Email Pattern CSV Download</a>
				</td></tr>
			  <tr>
			  <tr>
			  	<td colspan="2" height="20" class="page-text">&nbsp;<?PHP if($error_list !=''){ echo '<b>Error List below :</b><br />'.$error_list.'<br />';} ?></td></tr>
			  <tr>
				<td width="15%" align="left" valign="top" class="page-text">&nbsp;&nbsp;&nbsp;&nbsp;File</td>
				<td width="85%" align="left" valign="top">
				  <input type="file" name="data_file" id="data_file" size="50" /></td>
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