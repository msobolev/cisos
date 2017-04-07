<?php
require('includes/include_top.php');

$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';

    switch ($action) {
      case 'save':
        $col_fld = array('admin_email_address' => 'email','admin_password' => 'password','admin_firstname' => 'firstname','admin_lastname' => 'lastname');
		
		$strQuery = "";
		$strQuery = "update " . TABLE_ADMIN . " set ";
		
		foreach($col_fld as $key => $value){
			if($value == 'password'){
				if(trim($_POST[$value]) == ""){
					$p_blank = 0;
				}else{
					$p_blank = 1;
				}
				$post_value = com_encrypt_password($_POST[$value]);
			}else{
				$post_value = $_POST[$value];
			}
			
			
			if($value == 'password'){
				if($p_blank == 1){
					$strQuery .= $key . "='" . com_db_input($post_value) . "',";
				}	
			}else{
				$strQuery .= $key . "='" . com_db_input($post_value) . "',";
			}	
		}
		$strQuery = substr($strQuery,0,-1);
		$strQuery .= " where admin_id=1";
		mysql_query($strQuery);
		com_redirect("password.php?selected_menu=general&msg=" . msg_encode("Information is updated successfully"));
		break;
    }


$query = mysql_query("select admin_firstname,admin_lastname,admin_email_address,admin_password from " . TABLE_ADMIN);

	$data = mysql_fetch_array($query);
	$email_address = $data['admin_email_address'];
	$password = $data['admin_password'];
	$firstname = $data['admin_firstname'];
	$lastname = $data['admin_lastname'];


include("includes/header.php");
?>

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
                  <td width="18%" align="left" valign="middle" class="heading-text">Change Password</td>
				  <td width="82%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box">
		
		<form name="frm" method="post" action="password.php?selected_menu=general&action=save">	
			<table width="60%" border="0" cellspacing="0" cellpadding="5">
			  <tr>
				<td width="32%" align="left" valign="top" class="page-text">&nbsp;&nbsp;&nbsp;&nbsp;First Name:</td>
				<td width="68%" align="left" valign="top">
				  <input name="firstname" type="text" id="firstname" value="<?=$firstname?>" />    </td>
			  </tr>
              <tr>
				<td width="32%" align="left" valign="top" class="page-text">&nbsp;&nbsp;&nbsp;&nbsp;Last Name:</td>
				<td width="68%" align="left" valign="top">
				  <input name="lastname" type="text" id="lastname" value="<?=$lastname?>" />    </td>
			  </tr>
              <tr>
				<td width="32%" align="left" valign="top" class="page-text">&nbsp;&nbsp;&nbsp;&nbsp;Username:</td>
				<td width="68%" align="left" valign="top">
				  <input name="email" type="text" id="email" value="<?=$email_address?>" />    </td>
			  </tr>
			  <tr>
				<td align="left" valign="top" class="page-text">&nbsp;&nbsp;&nbsp;&nbsp;Password:</td>
				<td align="left" valign="top"><input name="password" type="password" id="password" value="" /></td>
			  </tr>
			  <tr>
				<td colspan="2" align="left" valign="top" class="page-text">&nbsp;&nbsp;&nbsp;&nbsp;[Leave password field blank for the same password]</td>
			  </tr>
			   <tr>
				<td>&nbsp;</td>
				<td align="left" valign="top"><label>
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