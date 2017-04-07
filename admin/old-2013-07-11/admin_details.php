<?php
require('includes/include_top.php');

$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';

	
	switch ($action) {
      case 'save':
	  		$store_name			= com_db_input($_POST['store_name']);
			$owner_name			= com_db_input($_POST['owner_name']);
			$site_owner_position= com_db_input($_POST['site_owner_position']);
	  		$company_name 		= com_db_input($_POST['company_name']);
			$company_address 	= com_db_input($_POST['company_address']);
			$city				= com_db_input($_POST['city']);
			$state				= com_db_input($_POST['state']);
			$zip				= com_db_input($_POST['zip']);
			$country			= com_db_input($_POST['country']);
			$zone				= com_db_input($_POST['zone']);		
			$phone_number 		= com_db_input($_POST['phone_number']);
			$fax_number 		= com_db_input($_POST['fax_number']);
			$domain_name 		= com_db_input($_POST['domain_name']);
			$email_address 		= com_db_input($_POST['email_address']);
			$email_from			= com_db_input($_POST['email_from']);
			
			
			$sql_query = "UPDATE " . TABLE_ADMIN_SETTINGS . " SET
						site_store_name 		= '$store_name',
						site_owner_name 		= '$owner_name',
						site_owner_position 		= '$site_owner_position',
						site_company_name 		= '$company_name',
						site_company_address 	= '$company_address',
						site_company_city 		= '$city',
						site_company_state 		= '$state',
						site_company_zip 		= '$zip',
						site_company_country 	= '$country',
						site_zone 				= '$zone',
						site_phone_number 		= '$phone_number',
						site_fax_number 		= '$fax_number',
						site_domain_name 		= '$domain_name',
						site_email_address 		= '$email_address',
						site_email_from 		= '$email_from'
						WHERE setting_id=1";
			
			$exe_query = com_db_query($sql_query);
			
			com_redirect("admin_details.php?selected_menu=general&msg=" . msg_encode("Information is updated successfully"));
			
			
	  	break;
		
	}
	


	$query = com_db_query("select * from " . TABLE_ADMIN_SETTINGS);
	$data = com_db_fetch_array($query);
	
	$store_name			= com_db_output($data['site_store_name']);
	$owner_name			= com_db_output($data['site_owner_name']);
	$site_owner_position= com_db_output($data['site_owner_position']);
	$company_name 		= com_db_output($data['site_company_name']);
	$company_address 	= com_db_output($data['site_company_address']);
	$city				= com_db_output($data['site_company_city']);
	$state				= com_db_output($data['site_company_state']);
	$zip				= com_db_output($data['site_company_zip']);
	$country			= com_db_output($data['site_company_country']);
	$zone				= com_db_output($data['site_zone']);
	$phone_number 		= com_db_output($data['site_phone_number']);
	$fax_number 		= com_db_output($data['site_fax_number']);
	$domain_name 		= com_db_output($data['site_domain_name']);
	$email_address 		= com_db_output($data['site_email_address']);
	$email_from			= com_db_output($data['site_email_from']);
	



/////////////////////////////////////
include("includes/header.php");
?>
<script type="text/javascript">
function chk_form(){
	
	if(!validateField(document.form_data.store_name, 'Please enter store name.')){
		return false;
	}
	if(!validateField(document.form_data.email_address, 'Please enter email address .')){
		return false;
	}
	/*if(!isValidEmail(document.form_data.email_address)){
		alert("Please enter valid email");
		document.form_data.email_address.focus();
		return false;
	}*/
	if(!validateField(document.form_data.email_from, 'Please enter email address .')){
		return false;
	}
	/*if(!isValidEmail(document.form_data.email_from)){
		alert("Please enter valid email");
		document.form_data.email_from.focus();
		return false;
	}*/
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
			  <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="18%" align="left" valign="middle" class="heading-text">Site Information </td>
				  <td width="82%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box">
		
			 <form name="form_data" method="post" action="admin_details.php?selected_menu=general&action=save" onsubmit="return chk_form();">
			<table width="60%" border="0" cellspacing="0" cellpadding="5">
		  <tr>
			<td width="32%" align="left" class="page-text">&nbsp;&nbsp;&nbsp;&nbsp;Site  Name <span class="require_fields">*</span> : </td>
			<td width="68%" align="left">
			  <input name="store_name" type="text" id="store_name" value="<?=$store_name?>" />    </td>
		  </tr>
		  <tr>
			<td width="32%" align="left" class="page-text">&nbsp;&nbsp;&nbsp;&nbsp;Owner Name : </td>
			<td width="68%" align="left">
			  <input name="owner_name" type="text" id="owner_name" value="<?=$owner_name?>" />    </td>
		  </tr>
          <tr>
			<td width="32%" align="left" class="page-text">&nbsp;&nbsp;&nbsp;&nbsp;Owner position : </td>
			<td width="68%" align="left">
			  <input name="site_owner_position" type="text" id="site_owner_position" value="<?=$site_owner_position?>" />    </td>
		  </tr>
		   <tr>
			<td width="32%" align="left" class="page-text">&nbsp;&nbsp;&nbsp;&nbsp;Company Name : </td>
			<td width="68%" align="left">
			  <input name="company_name" type="text" id="company_name" value="<?=$company_name?>" />    </td>
		  </tr>
		  <tr>
			<td align="left" valign="top" class="page-text">&nbsp;&nbsp;&nbsp;&nbsp;Address : </td>
			<td align="left"><textarea name="company_address" type="text" id="company_address" rows="5" cols="30"><?=$company_address?></textarea></td>
		  </tr>
		  <tr>
			<td align="left" class="page-text">&nbsp;&nbsp;&nbsp;&nbsp;City : </td>
			<td align="left"><input name="city" type="text" id="city" value="<?=$city?>" /></td>
		  </tr>
		  <tr>
			<td align="left" class="page-text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;State : </td>
			<td align="left"><input name="state" type="text" id="state" value="<?=$state?>" /></td>
		  </tr>
		  <tr>
			<td align="left" class="page-text">&nbsp;&nbsp;&nbsp;&nbsp;Zip : </td>
			<td align="left"><input name="zip" type="text" id="zip" value="<?=$zip?>" /></td>
		  </tr>
		  <tr>
			<td align="left" class="page-text">&nbsp;&nbsp;&nbsp;&nbsp;Country : </td>
			<td align="left"><input name="country" type="text" id="country" value="<?=$country?>" /></td>
		  </tr>
		  <tr>
			<td align="left" class="page-text">&nbsp;&nbsp;&nbsp;&nbsp;Zone : </td>
			<td align="left"><input name="zone" type="text" id="zone" value="<?=$zone?>" /></td>
		  </tr>
		  <tr>
			<td align="left" class="page-text">&nbsp;&nbsp;&nbsp;&nbsp;Phone Number : </td>
			<td align="left"><input name="phone_number" type="text" id="phone_number" value="<?=$phone_number?>" /></td>
		  </tr>
		  <tr>
			<td align="left" class="page-text">&nbsp;&nbsp;&nbsp;&nbsp;Fax Number :</td>
			<td align="left"><input name="fax_number" type="text" id="fax_number" value="<?=$fax_number?>" /></td>
		  </tr>
		  <tr>
			<td align="left" class="page-text">&nbsp;&nbsp;&nbsp;&nbsp;Domain Name <span class="require_fields">*</span> : </td>
			<td align="left" class="page-text">http://www.
			  <input name="domain_name" type="text" id="domain_name" value="<?=$domain_name?>" /></td>
		  </tr>
		  <tr>
			<td align="left" class="page-text">&nbsp;&nbsp;&nbsp;&nbsp;Email Address <span class="require_fields">*</span> :</td>
			<td align="left"><input name="email_address" type="text" id="email_address" value="<?=$email_address?>" /></td>
		  </tr>
		   <tr>
			<td align="left" class="page-text">&nbsp;&nbsp;&nbsp;&nbsp;Email From <span class="require_fields">*</span> : </td>
			<td align="left"><input name="email_from" type="text" id="email_from" value="<?=$email_from?>" /></td>
		  </tr>
		  <tr>
			<td colspan="2" align="left" valign="top">&nbsp;</td>
		  </tr>
		   <tr>
			<td>&nbsp;</td>
			<td align="left"><label>
			  <input type="submit" name="Submit" value="Update" class="submitButton" />
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