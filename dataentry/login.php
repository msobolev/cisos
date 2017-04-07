<?php
require('../includes/configuration.php');
include('../includes/only_dataentry_include-top.php');

  $errorStr = "";

	if(isset($_POST['email_address']) && isset($_POST['password'])) {
		 $email_address = com_db_input($_POST['email_address']);
    	 $password = com_db_input($_POST['password']);
	// Check if email exists
	
    $check_admin_query = mysql_query("select * from " . TABLE_DATA_ENTRY_USER . " where login_name = '" . com_db_input($email_address) . "' and status='0'");
    if (!mysql_num_rows($check_admin_query)) {
      $_GET['login'] = 'fail';
	  $errorStr = "Invalid username/password";
    } else {
      $check_admin = mysql_fetch_array($check_admin_query);
	  // Check that password is good
      if (!com_validate_password($password, $check_admin['password'])) {
        $_GET['login'] = 'fail';
		$errorStr = "Invalid username/password";
      }else {
		$user_login_id = $check_admin['user_id'];
        $user_login_name = $check_admin['login_name'];
        
		session_register('user_login_id');
        session_register('user_login_name');
		$_SESSION['user_login_id']=$user_login_id;
		$_SESSION['user_login_name']=$user_login_name;
		com_redirect('index.php');
	  }
	}	
	}
    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>CTOsOnTheMove.com :: Admin Control Panel</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script language="JavaScript">
function admin_login_check()
  {
  if(document.admin_login.email_address.value == "" )
     {
	 alert("Please enter admin username");
	 document.admin_login.email_address.focus();
	 return false;
	 }
  
  if(document.admin_login.password.value == "" )
     {
	 alert("Please enter admin password");
	 document.admin_login.password.focus();
	 return false;
	 }
     return true;
  }
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top" class="main"><table width="676" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><img src="images/spacer.gif" width="1" height="50" alt=""  title=""/></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="676" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="133" align="left" valign="top"><img src="images/bearing-icon.jpg" width="133" height="120" alt=""  title="" /></td>
        <td width="272" align="left" valign="top"><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td align="left" valign="top"><img src="images/spacer.gif" width="1" height="18" alt=""  title=""/></td>
          </tr>
          <tr>
            <td align="left" valign="top"><h1>ENTRY  PANEL</h1></td>
          </tr>
          <tr>
           <td align="left" valign="top"><img src="images/spacer.gif" width="1" height="6" alt=""  title=""/></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="bold-text">Administration <a href="#">LOGIN! </a></td>
          </tr>
          <tr>
            <td align="left" valign="top"><img src="images/spacer.gif" width="1" height="6" alt=""  title=""/></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="text">Use a valid User Name and Pasword to give<br />asccess to the administrator Back-end</td>
          </tr>
        </table></td>
        <td width="271" align="left" valign="top">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top"><table width="676" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="133" align="left" valign="top">&nbsp;</td>
        <td width="461" align="left" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="left" valign="top"><img src="images/admin-box-top.jpg" width="461" height="27" alt=""  title=""  /></td>
          </tr>
		  
          <tr>
            <td align="left" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="22" align="left" valign="top" class="admin-box-left-border">&nbsp;</td>
                <td align="center" valign="top" bgcolor="#FFFFFF" class="form-text">
				
				<form name="admin_login" method="post" action="login.php">
				<table width="300" border="0" align="center" cellpadding="4" cellspacing="0">
                  <tr>
                    <td align="center" valign="middle" height="82" colspan="2">
				   <?php
					if($errorStr != ''){
				   		echo '<span class="errWhiteTxt"><img src="images/icon/error.jpg" width="25" height="25">&nbsp;&nbsp;&nbsp;&nbsp;' . $errorStr . '</span>';
				   }
				   ?>				  </td>
                  </tr>
                  <tr>
                    <td width="73" align="left" valign="middle">User name</td>
                    <td width="211" align="left" valign="middle">
                        <input type="text" name="email_address" id="email_address"  class="input-text-field"/>                    </td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle">Password</td>
                    <td align="left" valign="middle"><input type="password" name="password" id="password"  class="input-text-field"/></td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle">&nbsp;</td>
                    <td align="right" valign="middle">
                        <input type="image" name="imageField" src="images/login-buttn.jpg" />                    </td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle"><img src="images/spacer.gif" width="1" height="50" alt=""  title=""/></td>
                    <td align="left" valign="middle"><img src="images/spacer.gif" width="1" height="50" alt=""  title=""/></td>
                  </tr>
                </table>
				</form>
				
				</td>
                <td width="39" align="left" valign="bottom" class="admin-box-right-border"><img src="images/admin-box-right-border-bg.jpg" width="39" height="174" alt="" title=""  /></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td align="left" valign="top"><img src="images/admin-box-bottom.jpg" width="461" height="36" alt=""  title=""  /></td>
          </tr>
        </table></td>
        <td width="82" align="left" valign="top">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
</table></td>
  </tr>
</table>

</body>
</html>
