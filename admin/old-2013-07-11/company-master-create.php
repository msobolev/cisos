<?php
require('includes/include_top.php');
$action = $_REQUEST['action'];
if($action == 'CompanyMasterCreate'){
	$companyQuery ="SELECT distinct(company_website) FROM ".TABLE_CONTACT." WHERE done='0' and company_website like '%www.%' limit 0,300";
	$companyResult = com_db_query($companyQuery);
	while($cRow = com_db_fetch_array($companyResult)){
		$thisCQuery = "SELECT company_name,	company_website, company_revenue, company_employee,	company_industry, ind_group_id,	industry_id, leadership_page, email_pattern , address, address2, city, state, country, zip_code, about_company, add_date, create_by, status FROM ". TABLE_CONTACT." WHERE company_website ='".$cRow['company_website']."' order by add_date desc limit 0,1";
		$thisCResult = com_db_query($thisCQuery);
		$tcRow  = com_db_fetch_array($thisCResult);
			
		$company_name = com_db_input($tcRow['company_name']);
		$company_website = com_db_input($tcRow['company_website']);
		$company_revenue = com_db_input($tcRow['company_revenue']);
		$company_employee = com_db_input($tcRow['company_employee']);
		$company_industry = com_db_input($tcRow['company_industry']);
		$industry_id = $company_industry;
		$ind_group_id = com_db_GetValue("select parent_id from " . TABLE_INDUSTRY . " where industry_id = '".$company_industry."'");
		
		$address = com_db_input($tcRow['address']);
		$address2 = com_db_input($tcRow['address2']);
		$city = com_db_input($tcRow['city']);
		$state = com_db_input($tcRow['state']);
		$country = com_db_input($tcRow['country']);
		$zip_code = com_db_input($tcRow['zip_code']);
		
		$about_company = com_db_input($tcRow['about_company']);
		$leadership_page = com_db_output($tcRow['leadership_page']);
		$email_pattern = com_db_output($tcRow['email_pattern']); 
		
		//$facebook_link = com_db_input($_POST['facebook_link']);
		//$linkedin_link = com_db_input($_POST['linkedin_link']);
		//$twitter_link = com_db_input($_POST['twitter_link']);
		//$googleplush_link = com_db_input($_POST['googleplush_link']);
				
		//$publish = '0';
		$create_by = 'Admin';
		$status = '0';
		$add_date = date('Y-m-d');
		
		$query = "insert into " . TABLE_COMPANY_MASTER . "
		(company_name, company_website, company_revenue, company_employee, company_industry, ind_group_id, industry_id,leadership_page,email_pattern, address, address2, city, state, country, zip_code, about_company, facebook_link ,linkedin_link ,twitter_link, googleplush_link, add_date, create_by, status) 
		values ('$company_name', '$company_website', '$company_revenue', '$company_employee', '$company_industry', '$ind_group_id', '$industry_id', '$leadership_page','$email_pattern','$address', '$address2', '$city', '$state', '$country', '$zip_code','$about_company','$facebook_link','$linkedin_link','$twitter_link','$googleplush_link','$add_date','$create_by','$status')";
		com_db_query($query);
		com_db_query("update ".TABLE_CONTACT." set done=1 where company_website='".$cRow['company_website']."'");
	}
	$comQuery ="SELECT distinct(company_website) FROM ".TABLE_CONTACT." WHERE done='0' and company_website like '%www.%'";
	$comResult = com_db_query($comQuery);
	if($comResult){
		$company_num_rows = com_db_num_rows($comResult);
	}	
}else{
	$companyQuery ="SELECT distinct(company_website) FROM ".TABLE_CONTACT." WHERE done='0' and company_website like '%www.%'";
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
			<form name="topicform" action="company-master-create.php?action=CompanyMasterCreate&selected_menu=master" method="post">
			<table width="100%" align="center" cellpadding="0" cellspacing="0">
			  <tr><td>&nbsp;</td></tr>
              <tr><td><b>Remnants Company Present: <?=$company_num_rows?></b> </td></tr>
              <tr><td>&nbsp;</td></tr>
              <tr>
				<td align="center"><input type="submit" name="cmCreate" id="cmCreate" value="Company Master Create" /></td>
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