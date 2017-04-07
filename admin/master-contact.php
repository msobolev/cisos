<?php
require('includes/include_top.php');
$action = $_REQUEST['action'];
if($action == 'MasterContactUpdate'){
	$companyQuery ="SELECT * FROM ".TABLE_COMPANY_MASTER." where done=0 limit 0,300";
	$companyResult = com_db_query($companyQuery);
	while($cRow = com_db_fetch_array($companyResult)){
		$company_name = com_db_input($cRow['company_name']);
		$company_website = com_db_input($cRow['company_website']);
		$company_revenue = com_db_input($cRow['company_revenue']);
		$company_employee = com_db_input($cRow['company_employee']);
		$company_industry = com_db_input($cRow['company_industry']);
		$industry_id = $company_industry;
		$ind_group_id = com_db_GetValue("select parent_id from " . TABLE_INDUSTRY . " where industry_id = '".$company_industry."'");
		
		$address = com_db_input($cRow['address']);
		$address2 = com_db_input($cRow['address2']);
		$city = com_db_input($tcRow['city']);
		$state = com_db_input($cRow['state']);
		$country = com_db_input($cRow['country']);
		$zip_code = com_db_input($cRow['zip_code']);
		
		$about_company = com_db_input($cRow['about_company']);
		$leadership_page = com_db_output($cRow['leadership_page']);
		$email_pattern = com_db_output($cRow['email_pattern']); 
		
		$query = "update " . TABLE_CONTACT . " set company_name='".$company_name."',company_revenue='".$company_revenue."',
		company_employee='".$company_employee."',company_industry='".$company_industry."',ind_group_id='".$ind_group_id."',
		industry_id='".$industry_id."',leadership_page='".$leadership_page."',email_pattern='".$email_pattern."',
		address='".$address."',address2='".$address2."',city='".$city."',state='".$state."',country='".$country."',
		zip_code='".$zip_code."',about_company='".$about_company."' where company_website ='".$company_website."'";
		com_db_query($query);
		com_db_query("update ".TABLE_COMPANY_MASTER." set done=1 where company_website='".$cRow['company_website']."'");
	}
	$comQuery ="SELECT distinct(company_website) FROM ".TABLE_COMPANY_MASTER." WHERE done='0'";
	$comResult = com_db_query($comQuery);
	if($comResult){
		$company_num_rows = com_db_num_rows($comResult);
	}	
}else{
	$companyQuery ="SELECT distinct(company_website) FROM ".TABLE_COMPANY_MASTER." WHERE done='0'";
	$companyResult = com_db_query($companyQuery);
	if($companyResult){
		$company_num_rows = com_db_num_rows($companyResult);
	}
}

include("includes/header.php");
?>

 <tr>
    <td align="left" valign="top" bgcolor="#FFFFFF">
	
	
	<table width="975" border="0" align="center" cellpadding="0" cellspacing="0">

      <tr>
		<?php
		include("includes/menu_left.php");
		?>
		<td width="10" align="left" valign="top">&nbsp;</td>
        <td width="769" align="left" valign="top">

		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
          <tr>
            <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="19%" align="left" valign="middle" class="heading-text">Company Manager</td>
                  <td width="51%" align="left" valign="middle" class="message"><?=$msg?></td>
                </tr>
              </table></td>
          </tr>
       
          <tr>
            <td align="left" valign="top" class="right-bar-content-border">
			<form name="topicform" action="master-contact.php?action=MasterContactUpdate&selected_menu=master" method="post">
			<table width="100%" align="center" cellpadding="0" cellspacing="0">
			  <tr><td>&nbsp;</td></tr>
              <tr><td><b>Remnants Company Present: <?=$company_num_rows?></b> </td></tr>
              <tr><td>&nbsp;</td></tr>
              <tr>
				<td align="center"><input type="submit" name="cmCreate" id="cmCreate" value="Master Contact Update" /></td>
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