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
							$col_fld_cap = array('First Name','Last Name','Title','Company Name','Headline','What Happened','About Person','About Company');
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
								com_redirect("contact-update.php?selected_menu=contact&msg=" . msg_encode($msg)."&error_list=".msg_encode($error_list));
							}
							//caption end
							for($i=$columnheadings; $i<sizeof($filecontents); $i++) {
								$strQuery = '';
								
								$newString = $filecontents[$i];
								$newArray = explode(',', $newString);

								if(sizeof($newArray)== 8){
									$col_fld = array('first_name','last_name','new_title','company_name','headline','what_happened','about_person','about_company');
								
									$p=0;
									
									foreach($newArray as $key => $value){
										if($p==0){
											$update_first_name = com_db_input(str_replace(';',',',trim($newArray[$p])));
										}elseif($p==1){
											$update_last_name = com_db_input(str_replace(';',',',trim($newArray[$p])));
										}elseif($p==2){
											$update_title = com_db_input(str_replace(';',',',trim($newArray[$p])));
										}elseif($p==3){
											$update_company_name = com_db_input(str_replace(';',',',trim($newArray[$p])));
										}elseif($p==4){
											$update_headline = com_db_input(str_replace(';',',',trim($newArray[$p])));
										}elseif($p==5){
											$update_what_happened = com_db_input(str_replace(';',',',trim($newArray[$p])));
										}elseif($p==6){
											$update_about_person = com_db_input(str_replace(';',',',trim($newArray[$p])));
										}elseif($p==7){
											$update_about_company = com_db_input(str_replace(';',',',trim($newArray[$p])));
										}	
										$p++;
									}
									
								   $strQuery = "update ".TABLE_CONTACT. " set headline='".$update_headline."', what_happened='".$update_what_happened."', about_person='".$update_about_person."', about_company='".$update_about_company."' where first_name='".$update_first_name."' and last_name='".$update_last_name."' and new_title='".$update_title."' and company_name ='".$update_company_name."'";
									com_db_query($strQuery);
									}else{
									 $msg = "File column numbers is ".sizeof($newArray).', But Import required is 8 columns';
									 com_redirect("contact-update.php?selected_menu=contact&msg=" . msg_encode($msg));	
									}
								
							}
							$msg = "File successfully imported.";
							com_redirect("contact-update.php?selected_menu=contact&msg=" . msg_encode($msg));	
							}
						else
							{
							$msg = "File not imported.";
							com_redirect("contact-update.php?selected_menu=contact&msg=" . msg_encode($msg));	
							}	
						
						}else{
							$msg = "Please select the .CSV file.";
							com_redirect("contact-update.php?selected_menu=contact&msg=" . msg_encode($msg));	
						}	
					}
				}
				else
				{
					$msg = "Please select file.";
					com_redirect("contact-update.php?selected_menu=contact&msg=" . msg_encode($msg));
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
                  <td width="15%" align="left" valign="middle" class="heading-text">Update csv file</td>
				  <td width="85%" valign="middle" class="message" align="left"><?=$msg?></td>
                 
                </tr>
              </table></td>
          </tr>
		 
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box">
		
		  <form name="importfile" method="post" action="contact-update.php?selected_menu=contact&action=save" enctype="multipart/form-data" onsubmit="return checkForm();">	
			<table width="60%" border="0" cellspacing="0" cellpadding="5">
			  <tr>
			  	<td colspan="2" height="20" align="right" class="page-text"><a href="download.php?type=Sample-upadte">Sample CSV Download</a></td></tr>
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