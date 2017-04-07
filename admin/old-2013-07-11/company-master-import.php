<?php
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
							$col_fld_cap = array('Company Name','Company Website','Company Logo','Company Size Revenue','Company Size Employees','Industry','Email Pattern','Leadership Page','Address','Address 2','City','Country','State','Zip Code','Phone','Fax','About Company','Facebook Link','Linkedin Link','Twitter Link','Google+ Link');
							$capnewString = $filecontents[0];
							$capnewArray = explode(',', $capnewString);
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
							//caption end
							for($i=$columnheadings; $i<sizeof($filecontents); $i++) {
								$strQuery = '';
								$strQuery1 = '';
								$strQuery2 = '';
								$newString = $filecontents[$i];
								$newArray = explode(',', $newString);

								if(sizeof($newArray)== 21){
									$col_fld = array('company_name','company_website','company_logo','company_revenue','company_employee','company_industry','ind_group_id','industry_id','email_pattern','leadership_page','address','address2','city','country','state','zip_code','phone','fax','about_company','facebook_link','linkedin_link','twitter_link','googleplush_link','add_date');
								
									$strQuery = "INSERT INTO " . TABLE_COMPANY_MASTER . " (";
									
									foreach($col_fld as $key => $value){
									$strQuery .= $value.',';
									}
									
									$strQuery1 .= substr($strQuery,0, -1);
									$strQuery1 .= ") values (";
									$p=0;
									
									foreach($newArray as $key => $value){
										
										if($p==0){
											$import_company_name = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$strQuery1 .= "'" . $import_company_name ."',";
										}elseif($p==1){
											$import_company_website = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$strQuery1 .= "'" . $import_company_website ."',";	
										}elseif($p==2){
											$import_company_logo = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$strQuery1 .= "'" . $import_company_logo ."',";
										}elseif($p==3){	
											$import_revenue_type = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$revenue_size_id = com_db_GetValue("select id from " . TABLE_REVENUE_SIZE . " where name = '".$import_revenue_type."'");
											if($revenue_size_id==''){
												$ins_query_revenue = "insert into " . TABLE_REVENUE_SIZE ."(name)value('".$import_revenue_type."')";
												com_db_query($ins_query_revenue);
												$revenue_size_id = com_db_insert_id();
											}
											$strQuery1 .= "'" . $revenue_size_id ."',";
										}elseif($p==4){	
											$import_employee_size = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$employee_size_id = com_db_GetValue("select id from " . TABLE_EMPLOYEE_SIZE. " where name = '".$import_employee_size."'");
											if($employee_size_id==''){
												$ins_employee_size = "insert into " . TABLE_EMPLOYEE_SIZE ."(name)value('".$import_employee_size."')";
												com_db_query($ins_employee_size);
												$employee_size_id = com_db_insert_id();
											}
											$strQuery1 .= "'" . $employee_size_id ."',";
											
										}elseif($p==5){
											$tot_ind = explode(':',$newArray[$p]);
											$ind_group_id = com_db_GetValue("select industry_id from " . TABLE_INDUSTRY . " where title = '".str_replace(';',',',trim($tot_ind[0]))."'");
											if(sizeof($tot_ind)==2){
												$ind_group_id = com_db_GetValue("select industry_id from " . TABLE_INDUSTRY . " where title = '".str_replace(';',',',trim($tot_ind[0]))."'");
												$industry_id = com_db_GetValue("select industry_id from " . TABLE_INDUSTRY . " where title = '".str_replace(';',',',trim($tot_ind[1]))."'");
												$industry_name = com_db_output(str_replace(';',',', trim($tot_ind[1])));
												$industry_group_name = com_db_output(str_replace(';',',', trim($tot_ind[0])));
												if($ind_group_id =='' ){
													$ind_query_ins = "insert into " . TABLE_INDUSTRY ."(parent_id,title,add_date)value('0','".$industry_group_name."','".time()."')";
													com_db_query($ind_query_ins);
													$ind_group_id = com_db_insert_id();
													$ind_query_ins = "insert into " . TABLE_INDUSTRY ."(parent_id,title,add_date)value('".$ind_group_id."','".$industry_name."','".time()."')";
													com_db_query($ind_query_ins);
													$industry_id = com_db_insert_id();
												}elseif($ind_group_id !='' && $industry_id ==''){
													$ind_query_ins = "insert into " . TABLE_INDUSTRY ."(parent_id,title,add_date)value('".$ind_group_id."','".$industry_name."','".time()."')";
													com_db_query($ind_query_ins);
													$industry_id = com_db_insert_id();
												}
											}else{
												$ind_group_id ='0';
												$industry_id = com_db_GetValue("select industry_id from " . TABLE_INDUSTRY . " where title = '".str_replace(';',',',trim($tot_ind[0]))."'");
												$industry_name =com_db_output(str_replace(';',',', trim($tot_ind[0])));
											}	
											$strQuery1 .= "'" . $industry_id ."','" . $ind_group_id ."','". $industry_id ."',";
										}elseif($p==6){
											$import_email_pattern = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$strQuery1 .= "'" . $import_email_pattern ."',";	
										}elseif($p==7){
											$import_leadership_page = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$strQuery1 .= "'" . $import_leadership_page ."',";
										}elseif($p==8){
											$import_address = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$strQuery1 .= "'" . $import_address ."',";	
										}elseif($p==9){
											$import_address2 = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$strQuery1 .= "'" . $import_address2 ."',";	
										}elseif($p==10){
											$import_city = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$strQuery1 .= "'" . $import_city ."',";	
										}elseif($p==11){
											$import_country = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$country_id = com_db_GetValue("select countries_id from " . TABLE_COUNTRIES . " where countries_iso_code_3 = '".$import_country."' or countries_name='".$import_country."'");
											if($country_id==''){
												$ins_query_country = "insert into " . TABLE_COUNTRIES ."(countries_name)value('".$import_country."')";
												com_db_query($ins_query_country);
												$country_id = com_db_insert_id();
											}
											$strQuery1 .= "'" . $country_id ."',";	
										}elseif($p==12){
											$import_state = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$state_id = com_db_GetValue("select state_id from " . TABLE_STATE . " where short_name = '".$import_state."'");
											if($state_id==''){
												$ins_query_state = "insert into " . TABLE_STATE ."(short_name)value('".$import_state."')";
												com_db_query($ins_query_state);
												$state_id = com_db_insert_id();
											}
											$strQuery1 .= "'" . $state_id ."',";							
										}elseif($p==13){
											$import_zip_code = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$strQuery1 .= "'" . $import_zip_code ."',";	
										}elseif($p==14){
											$import_phone = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$strQuery1 .= "'" . $import_phone ."',";	
										}elseif($p==15){
											$import_fax = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$strQuery1 .= "'" . $import_fax ."',";	
										}elseif($p==16){
											$import_about_company = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$strQuery1 .= "'" . $import_about_company ."',";
										}elseif($p==17){
											$import_facebook_link = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$strQuery1 .= "'" . $import_facebook_link ."',";
										}elseif($p==18){
											$import_linkedin_link = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$strQuery1 .= "'" . $import_linkedin_link ."',";
										}elseif($p==19){
											$import_twitter_link = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$strQuery1 .= "'" . $import_twitter_link ."',";
										}elseif($p==20){
											$import_googleplush_link = com_db_input(str_replace(';',',',trim($newArray[$p])));
											$strQuery1 .= "'" . $import_googleplush_link ."',";
										}
										
										$p++;
									}
									$strQuery2 .= substr($strQuery1,0, -1);
									$strQuery2 .= ",'".date('Y-m-d')."')";
									$isCompanyWebsite = com_db_GetValue("select company_id from ".TABLE_COMPANY_MASTER." where company_website='".$import_company_website."'");
										if($isCompanyWebsite>0){
											$modify_date = date('Y-m-d');
											$update_contact = "update ".TABLE_COMPANY_MASTER." set company_name='".$import_company_name."',company_logo='".$import_company_logo."',company_revenue='".$revenue_size_id ."', company_employee='".$employee_size_id."',
															   company_industry='".$industry_id."',ind_group_id='". $ind_group_id."',industry_id='".$industry_id."',leadership_page='".$import_leadership_page."',email_pattern='".$import_email_pattern."',address='".$address."',
															   address2='".$address2."',city='".$import_city."',state='".$state_id."',country='".$country_id."',zip_code='".$import_zip_code."',phone='".$import_phone."',fax='".$import_fax."',about_company='".$import_about_company."',facebook_link='".$import_facebook_link."',
															   linkedin_link='".$import_linkedin_link."',twitter_link='".$import_twitter_link."',googleplush_link='".$import_googleplush_link."',modify_date='".$modify_date."' where company_id='".$isCompanyWebsite."'";
											com_db_query($update_contact);
										}else{
											com_db_query($strQuery2);
										}
									}else{
									 $msg = "File column numbers is ".sizeof($newArray).', But Import required is 21 columns';
									 com_redirect("company-master-import.php?selected_menu=master&msg=" . msg_encode($msg));	
									}
							}
							$msg = "File successfully imported.";
							com_redirect("company-master-import.php?selected_menu=master&msg=" . msg_encode($msg));	
							}
						else
							{
							$msg = "File not imported.";
							com_redirect("company-master-import.php?selected_menu=master&msg=" . msg_encode($msg));	
							}	
						
						}else{
							$msg = "Please select the .CSV file.";
							com_redirect("company-master-import.php?selected_menu=master&msg=" . msg_encode($msg));	
						}	
					}
				}
				else
				{
					$msg = "Please select file.";
					com_redirect("company-master-import.php?selected_menu=master&msg=" . msg_encode($msg));
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
		
		  <form name="importfile" method="post" action="company-master-import.php?selected_menu=master&action=save" enctype="multipart/form-data" onsubmit="return checkForm();">	
			<table width="60%" border="0" cellspacing="0" cellpadding="5">
			  <tr>
			  	<td colspan="2" height="20" align="right" class="page-text"><a href="download-company-info.php?type=Sample">Sample CSV Download</a></td></tr>
			  <tr>
			  <tr>
			  	<td colspan="2" height="20" class="page-text">&nbsp;<? if($error_list !=''){ echo '<b>Error List below :</b><br />'.$error_list.'<br />';} ?></td></tr>
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