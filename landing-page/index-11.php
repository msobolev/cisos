<?php
require('../includes/configuration.php');
include('../includes/only_landing_page_include-top.php');

if(isset($_REQUEST["submit"]) && !empty($_POST["email"])){
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$email = $_POST['email'];
	$message = $_POST['message'];
	
	$admin_subject ='Contact Us from Landing Page';
	$to_admin = com_db_GetValue("select site_email_address from ". TABLE_ADMIN_SETTINGS ." where setting_id ='1'" );
		
	  $email_msg = '<a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'index.php"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/logo.jpg"  alt="Logo" width="196" height="32" border="0" title="Logo" /></a>&nbsp;
					<table width="70%" cellspacing="0" cellpadding="3" >
						<tr>
							<td align="left"><b>Contact Us from Landing Page</b></td> 
						</tr>
						<tr>
							<td align="left">Name: '.$fname.' '.$lname.'</td> 
						</tr>
						<tr>
							<td align="left">Email: '.$email.'</td> 
						</tr>
						<tr>
							<td align="left">Message: '.$message.'</td> 
						</tr>';
	 
		$email_msg .=	'</table>';

		@send_email($to_admin, $admin_subject, $email_msg, $email);
}

$lp_url = explode('/', $_SERVER['REQUEST_URI']);
$lp_name = $lp_url[sizeof($lp_url)-1];

$lp_query = com_db_query("select * from " . TABLE_LANDING_PAGE . " where lp_name = '".$lp_name."'");

if($lp_query){
	$lp_num = com_db_num_rows($lp_query);
}else{
	$lp_num =0;
}	
if($lp_num==0){
	$lp_query = com_db_query("select * from " . TABLE_LANDING_PAGE . " ORDER BY RAND() LIMIT 1");
}
$lp_row = com_db_fetch_array($lp_query);
$lp_logo = com_db_output($lp_row['lp_logo']);
$lp_caption = com_db_output($lp_row['lp_caption']);
$lp_img_title = com_db_output($lp_row['lp_img_title']);
$lp_image = com_db_output($lp_row['lp_image']);
$lp_img_desc = com_db_output($lp_row['lp_img_desc']);
$lp_content_title = com_db_output($lp_row['lp_content_title']);
$lp_content_desc = com_db_output($lp_row['lp_content_desc']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>CTOsOnTheMove.com</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" language="javascript">
	function ContactUsValidation(){
		var fname = document.getElementById('fname').value;	
		if(fname == ''){
			alert('Please enter your first name');
			document.getElementById('fname').focus();
			return false;
		}
		var lname = document.getElementById('lname').value;	
		if(lname == ''){
			alert('Please enter your last name');
			document.getElementById('lname').focus();
			return false;
		}
		var email = document.getElementById('email').value;	
		if(email == ''){
			alert('Please enter your email');
			document.getElementById('email').focus();
			return false;
		}
		var emailRegEx = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		if(!email.match(emailRegEx)){
			alert('Please enter valid email');	
			document.getElementById('email').focus();
			return false;	
		}
		
	}
</script>
</head>

<body>
<table width="1002" border="0" align="center" cellpadding="0" cellspacing="0">

  <tr>
    <td width="21" align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top" class="top-header-bg"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="left" valign="top"><img src="images/specer.gif" width="1" height="38" alt="" title="" /></td>
      </tr>
      <tr>
        <td align="center" valign="top"><table width="928" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="196" align="left" valign="top"><a href="index.html"><img src="logo/<?=$lp_logo?>"  alt="Logo" border="0" title="Logo" /></a></td>
            <td align="left" valign="top">&nbsp;</td>
            <td width="137" align="left" valign="top" class="login-register-bg">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    
      <tr>
          <td align="left" valign="top"><img src="images/specer.gif" width="1" height="33" alt="" title="" /></td>
      </tr>
 
   
    </table></td>
  </tr>
</table></td>
    <td width="21" align="left" valign="top">&nbsp;</td>
  </tr>
    <tr>
      <td align="left"  valign="top">&nbsp;</td>
      <td align="left" valign="top"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">

      <tr>
      <td align="left" valign="middle" class="landing-page-heading-bg"><table width="960" border="0" align="left" cellpadding="0" cellspacing="0">
     
        <tr>
          <td align="left" valign="middle" class="landing-page-title-text"><?=$lp_caption?></td>
        </tr>
      </table></td>
      </tr>
	
      </table></td>
      <td align="left"  valign="top">&nbsp;</td>
    </tr>

    <tr>
      <td align="left"  valign="top">&nbsp;</td>
      <td align="center" valign="top" class="registration-page-bg"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td align="center" valign="top"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="262" align="center" valign="top"><table width="262" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="center" valign="top"><table width="230" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="top" class="left-box-text"><?=$lp_img_title?></td>
                </tr>
                <tr>
                <td align="left" valign="top"><img src="images/specer.gif" width="1" height="8" alt="" title="" /></td>
                </tr>
              
                <tr>
                  <td height="23" align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="top"><img src="img_file/<?=$lp_image?>"  alt="" title="" /></td>
                </tr>
                <tr>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="top" class="content-text"><?=$lp_img_desc?></td>
                </tr>
                <tr>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
              </table></td>
                </tr>
              </table></td>
              <td width="471" align="left" valign="top"><table width="450" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="left" valign="top" class="left-box-text">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="top" class="left-box-text"><?=$lp_content_title?></td>
                </tr>
                <tr>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="top" class="content-text"><?=$lp_content_desc?></td>
                </tr>
                <tr>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
				
              </table></td>
              <td width="227" align="left" valign="top"><table width="227" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="center" valign="top">
				  
				  <form name="frmContact" action="" method="post" onsubmit="return ContactUsValidation();">
				  <table width="202" border="0" align="center" cellpadding="2" cellspacing="0">
                    <tr>
                      <td width="198" align="left" valign="middle">&nbsp;</td>
                    </tr>
                    <tr>
                      <td align="left" valign="top" class="contact-form-box-text"><h4>Contact Us </h4></td>
				   </tr>
				   <tr>
					<td align="left" valign="top">&nbsp;</td>
				   </tr>
              
                    <tr>
                      <td align="left" valign="middle" class="contact-form-box-text">First Name</td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="contact-form-box-text">
					  <input name="fname" id="fname" type="text" size="30"  value="" /></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="contact-form-box-text">Last Name</td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="contact-form-box-text"> <input name="lname" id="lname" type="text" size="30"  value="" /></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="contact-form-box-text">Email (we will keep your email completely private)</td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="contact-form-box-text"> <input name="email" id="email" type="text" size="30"  value="" /></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="contact-form-box-text">Message</td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="contact-form-box-text">
                      <textarea name="message" id="message" cols="23" rows="4" ></textarea>                      </td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle"><input type="submit" name="submit" value="SUBMIT" /></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle">&nbsp;</td>
                    </tr>
                  </table>
				  </form>
				  </td>
                </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td align="center" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td align="center" valign="top">&nbsp;</td>
        </tr>
      </table></td>
      <td align="left"  valign="top">&nbsp;</td>
    </tr>
</table>

</body>
</html>

