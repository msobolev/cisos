<?php
  require('includes/include_top.php');
  $errorStr = "";
	$action = $_REQUEST['action'];
	if(isset($_POST['email']) && $action=='ForgotPassword') {
            
		$email = $_POST['email'];
		$isPresentEmail = com_db_GetValue("select site_email_address from " .TABLE_ADMIN_SETTINGS. " where setting_id='1'");
		if($email!= $isPresentEmail){
			$errorStr = "Email not found in the database";
		}else{
			$login_name = com_db_GetValue("select admin_email_address from " .TABLE_ADMIN. " where admin_id='1'");
			$new_password = rand(100000,999999);
			$password = md5($new_password);
			com_db_query("update ". TABLE_ADMIN . " set admin_password ='".$password."' where admin_id='1'");
			$subject = 'Login information';
			$message ='<table width="100%" cellspacing="0" cellpadding="3" border="1" style="border-collapse:collapse; border:1px solid #86BFE8" bordercolor="#86BFE8">
						  <tr>
							<td colspan="2" align="left"><b>Login Details</b></td>
						  </tr>
						  <tr>
							<td align="left">Login Name:</td>
							<td align="left">'.$login_name.'</td>	
						  </tr>
						  <tr>
							<td align="left">Password:</td>
							<td align="left">'.$new_password.'</td>	
						  </tr>
					  </table>';
					 
			@send_email($email, $subject, $message, $email);	  
			$permissionStr = "Please check your mailbox, email send successfully";
		}	
	}
	
	if(isset($_POST['email_address']) && isset($_POST['password'])) {
		$email_address = com_db_input($_POST['email_address']);
		$password = com_db_input($_POST['password']);
		// Check if email exists
                
                
                //echo "<br>Q: select admin_id as login_id, admin_groups_id as login_groups_id,access_type, admin_firstname as login_firstname, admin_email_address as login_email_address, admin_password as login_password, admin_modified as login_modified, admin_logdate as login_logdate, admin_lognum as login_lognum from " . TABLE_ADMIN . " where admin_email_address = '" . com_db_input($email_address) . "'";
		$check_admin_query = mysqli_query($link,"select admin_id as login_id, admin_groups_id as login_groups_id,access_type, admin_firstname as login_firstname, admin_email_address as login_email_address, admin_password as login_password, admin_modified as login_modified, admin_logdate as login_logdate, admin_lognum as login_lognum from " . TABLE_ADMIN . " where admin_email_address = '" . com_db_input($email_address) . "'");
		//echo "<br>mysqli_num_rows: ".mysqli_num_rows($check_admin_query);
                //die();
                if (!mysqli_num_rows($check_admin_query)) 
                {
		  $_GET['login'] = 'fail';
		  $errorStr = "Invalid username/password";
		} 
                else 
                {
                 
		  $check_admin = mysqli_fetch_array($check_admin_query);
		  // Check that password is good
		  
                  if (!com_validate_password($password, $check_admin['login_password'])) 
                {
			$_GET['login'] = 'fail';
			$errorStr = "Invalid username/password";
		  }
                  else 
                      {
                  
			$login_id = $check_admin['login_id'];
			$login_groups_id = $check_admin['login_groups_id'];
			$login_firstname = $check_admin['login_firstname'];
			$login_email_address = $check_admin['login_email_address'];
			$login_logdate = $check_admin['login_logdate'];
			$login_access_type = $check_admin['access_type'];
			$login_lognum = $check_admin['login_lognum'];
			$login_modified = $check_admin['login_modified'];
			
			session_register('login_id');
			session_register('login_groups_id');
			session_register('login_first_name');
			$_SESSION['login_first_name']=$login_firstname;
			$_SESSION['login_access_type']=$login_access_type;
			$_SESSION['login_id']=$login_id;
                        
                        //com_redirect('index.php?selected_menu=general');
                        header('Location: index.php?selected_menu=general' );
                        
                        die();
                        
			//com_redirect('index.php?selected_menu=general');
			if($_SESSION['login_access_type']=='User'){
				com_redirect('index-staff.php?selected_menu=general');
			}else{
				com_redirect('index.php?selected_menu=general');
			}
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
  function ValidationEmail(){
		var email = document.getElementById('email').value;
		if(email =='' ){
			alert('Please enter your email');
			document.getElementById('email').focus();
			return false;
		}
		if(email !=''){
			var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
			   if(reg.test(email) == false) {
				  alert('Invalid E-Mail Address');
				  document.getElementById('email').focus();
				  return false;
			   }
		}
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
            <td align="left" valign="top"><h1>ADMIN PANEL</h1></td>
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
				<div id="LiginDiv" style="display:<?PHP if($action=='ForgotPassword'){echo 'none';}else{echo 'block';}?>;">
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
                    <td align="left" valign="middle">&nbsp;</td>
                    <td align="right" valign="middle"><a href="login.php?action=ForgotPassword">Forgot Password</a> </td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle"><img src="images/spacer.gif" width="1" height="50" alt=""  title=""/></td>
                    <td align="left" valign="middle"><img src="images/spacer.gif" width="1" height="50" alt=""  title=""/> </td>
                  </tr>
                </table>
				</form>
				</div>
				<div id="ForgotPasswordDiv" style="display:<?PHP if($action=='ForgotPassword'){echo 'block';}else{echo 'none';}?>;">
				
				<form name="admin_ForgotPassword" method="post" action="login.php?action=ForgotPassword" onsubmit="return ValidationEmail();">
				<table width="300" border="0" align="center" cellpadding="4" cellspacing="0">
                  <tr>
                    <td align="center" valign="middle" height="82" colspan="2">
				   <?php
					if($errorStr != ''){
				   		echo '<span class="errWhiteTxt"><img src="images/icon/error.jpg" width="25" height="25">&nbsp;&nbsp;&nbsp;&nbsp;' . $errorStr . '</span>';
				   }elseif($permissionStr !=''){
				   		echo '<span class="permissionTxt"><img src="images/icon/permission.gif" width="25" height="25">&nbsp;&nbsp;&nbsp;&nbsp;' . $permissionStr . '</span>';
				   }
				   ?>				  </td>
                  </tr>
                  <tr>
                    <td width="73" align="left" valign="middle">Enter Email: </td>
                    <td width="211" align="left" valign="middle">
                        <input type="text" name="email" id="email" class="input-text-field"/> 
					</td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle">&nbsp;</td>
                    <td align="right" valign="middle">
                        <input type="image" name="imageField" src="images/submit-buttn.gif" /> 
					</td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle"><img src="images/spacer.gif" width="1" height="50" alt=""  title=""/></td>
                    <td align="left" valign="middle"><img src="images/spacer.gif" width="1" height="50" alt=""  title=""/></td>
                  </tr>
                </table>
				</form>
				</div>
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
