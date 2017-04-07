<?php
ini_set('max_execution_time', 12000);
ini_set('upload_max_filesize', '6M');
ini_set('auto_detect_line_endings', true);

require('includes/include_top.php');

$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';
$error_list = (isset($_GET['error_list'])) ? msg_decode($_GET['error_list']) : '';
    switch ($action) {
      case 'save':
	  	
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
							//$col_fld_cap = array('Company Name','Company Website','Company Logo','Company Revenue','Company Employees','Industry','Email Pattern','Leadership Page','Address','Address 2','City','Country','State','Zip Code','Phone','Fax','About Company','Facebook Link','Linkedin Link','Twitter Link','Google+ Link');
							$col_fld_cap = array('company_name','company_website','company_logo','company_revenue','company_employees','company_industry','email_pattern','leadership_page','address','address2','city','country','state','zip_code','phone','fax','about_company','facebook_link','linkedin_link','twitter_link','googleplush_link','email_domain','mail_server_settings','email_pattern_id');
							$capnewString = $filecontents[0];
							$capnewArray = explode(',', $capnewString);
							
							$id_col = "company_id";//$capnewArray[0];
							$col = trim($capnewArray[1]);
							//echo "<pre>";	print_r($col_fld_cap);	echo "</pre>";
							//echo "<br><br>Col:".$col.":"; 
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
							
							
							/* delete lines below
							echo "<pre>New array: "; print_r($capnewArray); echo "</pre>"; die();
							New array: Array
							(
								[0] => RecordID
								[1] => LinkedIn url

							)
							*/
							
							/*
							$cap=0;
							$cap_flag = 0;
							$error_list='';
							foreach($capnewArray as $capkey => $capvalue){
								if(strtoupper(trim($capnewArray[$cap])) != strtoupper(trim($col_fld_cap[$cap]))){
									$error_list .= '&nbsp;&nbsp;Requered field name is "'.trim($col_fld_cap[$cap]).'" not "'.trim($capnewArray[$cap]).'"<br />';
									$cap_flag = 1;
								}
								$cap++;
							}
							if($cap_flag==1){
								$msg = "Column name not matching in your CSV file, please check the column heading.";
								com_redirect("company-master-import.php?selected_menu=master&msg=" . msg_encode($msg)."&error_list=".msg_encode($error_list));
							}
							*/
							
							
							//caption end
							for($i=$columnheadings; $i<sizeof($filecontents); $i++) {
								$strQuery = '';
								$strQuery1 = '';
								$strQuery2 = '';
								$newString = $filecontents[$i];
								$newArray = explode(',', $newString);
// echo "<pre>newArray: ";   print_r($newArray);   echo "</pre>"; 
								if(sizeof($newArray)== 2){
									//$col_fld = array('company_name','company_website','company_logo','company_revenue','company_employee','company_industry','ind_group_id','industry_id','email_pattern','leadership_page','address','address2','city','country','state','zip_code','phone','fax','about_company','facebook_link','linkedin_link','twitter_link','googleplush_link','add_date');
								
									$strQuery = "UPDATE " . TABLE_COMPANY_MASTER . " SET ";
									
									//foreach($col_fld as $key => $value){
									//	$strQuery .= $value.',';
									//}
									//$strQuery .= $capnewArray[1].' = '.;
									
									//$strQuery1 .= substr($strQuery,0, -1);
									//$strQuery1 .= ") values (";
									$strQuery1 .= " ";
									//$p=0;
									$companyQuery = "";
									$strQuery1 = "";
									$strQuery2 = "";
									//foreach($newArray as $key => $value){
										
										//if($p==1){
											$import_company_val = com_db_input(str_replace(';',',',trim($newArray[1])));
											$strQuery1 .= $col." = '" . $import_company_val ."'";
										
											
										//}
										//$p++;
										$import_company_id = com_db_input(str_replace(';',',',trim($newArray[0])));
										$strQuery2  = " WHERE ".$id_col." = ".$import_company_id;
										
										$companyQuery = $strQuery.$strQuery1.$strQuery2;
										//echo "<br><br><br><br>Str Q: ".$companyQuery;
										com_db_query($companyQuery);
										
										
										com_db_query("insert into ". TABLE_COMPANY_UPDATE_INFO."(page_name,query_string,add_date) values('admin-company-append','".com_db_input($companyQuery)."','".date("Y-m-d:H:i:s")."')");
										
									//}
									
									}else{
                                                                        //die();
									 $msg = "File column numbers is ".sizeof($newArray).', But Import required is 2 columns';
									 com_redirect("company-master-append.php?selected_menu=master&msg=" . msg_encode($msg));	
									}
							} 
							$msg = "Data successfully appended.";
							com_redirect("company-master-append.php?selected_menu=master&msg=" . msg_encode($msg));	
							}
						else
							{
							$msg = "File not imported.";
							com_redirect("company-master-append.php?selected_menu=master&msg=" . msg_encode($msg));	
							}	
						
						}else{
							$msg = "Please select the .CSV file.";
							com_redirect("company-master-append.php?selected_menu=master&msg=" . msg_encode($msg));	
						}	
					}
				}
				else
				{
					$msg = "Please select file.";
					com_redirect("company-master-append.php?selected_menu=master&msg=" . msg_encode($msg));
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
		
		  <form name="importfile" method="post" action="company-master-append.php?selected_menu=master&action=save" enctype="multipart/form-data" onsubmit="return checkForm();">	
			<table width="60%" border="0" cellspacing="0" cellpadding="5">
			  <tr>
			  	<td colspan="2" height="20" align="right" class="page-text">
					<a href="download-company-append-info.php?type=Sample">Sample CSV Download</a>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="download-company-pattern-info.php?type=Sample">Sample Email Pattern CSV Download</a>
				</td></tr>
			  <tr>
			  <tr>
			  	<td colspan="2" height="20" class="page-text">&nbsp;<? if($error_list !=''){ echo '<b>Error List below :</b><br />'.$error_list.'<br />';} ?></td></tr>
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