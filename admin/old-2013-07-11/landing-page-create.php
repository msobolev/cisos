<?
require('includes/include_top.php');
$lp_id = $_REQUEST['lpID'];
$main_url = $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
$main_url = substr($main_url,0,strlen($main_url)-strlen('admin/landing-page-create.php'));

$cr_dir = 'download'.rand(100,5000);
mkdir('../landing-page/'.$cr_dir,0777);
mkdir('../landing-page/'.$cr_dir.'/css',0777);
mkdir('../landing-page/'.$cr_dir.'/images',0777);

copy('../landing-page/css/style.css','../landing-page/'.$cr_dir.'/css/style.css');
copy('../landing-page/images/blue-bar-top-bg.jpg','../landing-page/'.$cr_dir.'/images/blue-bar-top-bg.jpg');
copy('../landing-page/images/specer.gif','../landing-page/'.$cr_dir.'/images/specer.gif');
copy('../landing-page/images/title-text-bottom-border.jpg','../landing-page/'.$cr_dir.'/images/title-text-bottom-border.jpg');

$lp_query = com_db_query("select * from " . TABLE_LANDING_PAGE . " where lp_id = '".$lp_id."'");

$lp_row = com_db_fetch_array($lp_query);
$lp_logo = com_db_output($lp_row['lp_logo']);
$lp_caption = com_db_output($lp_row['lp_caption']);
$lp_img_title = com_db_output($lp_row['lp_img_title']);
$lp_image = com_db_output($lp_row['lp_image']);
$lp_img_desc = com_db_output($lp_row['lp_img_desc']);
$lp_content_title = com_db_output($lp_row['lp_content_title']);
$lp_content_desc = com_db_output($lp_row['lp_content_desc']);
$lp_fname = com_db_output($lp_row['lp_fname']);
$lp_lname = com_db_output($lp_row['lp_lname']);
$lp_email = com_db_output($lp_row['lp_email']);
$lp_message = com_db_output($lp_row['lp_message']);

if(file_exists('../landing-page/logo/'.$lp_logo)){
	copy('../landing-page/logo/'.$lp_logo,'../landing-page/'.$cr_dir.'/images/'.$lp_logo);
}
if(file_exists('../landing-page/img_file/'.$lp_image)){
	copy('../landing-page/img_file/'.$lp_image,'../landing-page/'.$cr_dir.'/images/'.$lp_image);
}	


$to_admin = com_db_GetValue("select site_email_address from ". TABLE_ADMIN_SETTINGS ." where setting_id ='1'" );

$lp_page = '<?
			if(isset($_REQUEST["submit"]) && !empty($_POST["email"])){
				$fname = $_POST["fname"];
				$lname = $_POST["lname"];
				$email = $_POST["email"];
				$message = $_POST["message"];
				
				$admin_subject = "Contact Us from Landing Page";
				
				$headers  = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
				$headers .= "From: " . $email . "\r\n";
				
						
				 $email_msg = '."'".'<a href="http://'.$main_url.'index.php"><img src="http://'.$main_url.'images/logo.jpg"  alt="Logo" width="196" height="32" border="0" title="Logo" /></a>&nbsp;
								<table width="70%" cellspacing="0" cellpadding="3" >
									<tr>
										<td align="left"><b>Contact Us from Landing Page</b></td> 
									</tr>
									<tr>
										<td align="left">Name: \'.$fname.\' \'.$lname.\'</td> 
									</tr>
									<tr>
										<td align="left">Email: \'. $email. \'</td> 
									</tr>
									<tr>
										<td align="left">Message: \'.$message. \'</td> 
									</tr>
									
								</table>'."';".'
				 
					
					@mail('."'".$to_admin."'".', $admin_subject, $email_msg , $headers);
			}
			?>
			
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>CTOsOnTheMove.com</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" language="javascript">
	function ContactUsValidation(){
		var fname = document.getElementById("fname").value;	
		if(fname == ""){
			alert("Please enter your first name");
			document.getElementById("fname").focus();
			return false;
		}
		var lname = document.getElementById("lname").value;	
		if(lname == ""){
			alert("Please enter your last name");
			document.getElementById("lname").focus();
			return false;
		}
		var email = document.getElementById("email").value;	
		if(email == ""){
			alert("Please enter your email");
			document.getElementById("email").focus();
			return false;
		}
		var emailRegEx = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		if(!email.match(emailRegEx)){
			alert("Please enter valid email");	
			document.getElementById("email").focus();
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
            <td width="196" align="left" valign="top"><a href="index.html"><img src="images/'.$lp_logo.'"  alt="Logo" border="0" title="Logo" /></a></td>
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
          <td align="left" valign="middle" class="landing-page-title-text">'.$lp_caption.'</td>
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
                  <td align="left" valign="top" class="left-box-text">'.$lp_img_title.'</td>
                </tr>
                <tr>
                <td align="left" valign="top"><img src="images/specer.gif" width="1" height="8" alt="" title="" /></td>
                </tr>
              
                <tr>
                  <td height="23" align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="top"><img src="images/'.$lp_image.'"  alt="" title="" /></td>
                </tr>
                <tr>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="top">'.$lp_img_desc.'</td>
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
                  <td align="left" valign="top" class="left-box-text">'.$lp_content_title.'</td>
                </tr>
                <tr>
                  <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td align="left" valign="top">'.$lp_content_desc.'</td>
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
					  <input name="fname" id="fname" type="text" size="30"  value="'. $lp_fname .'" /></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="contact-form-box-text">Last Name</td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="contact-form-box-text"> <input name="lname" id="lname" type="text" size="30"  value="'. $lp_lname .'" /></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="contact-form-box-text">Email (we will keep your email completely private)</td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="contact-form-box-text"><input name="email" id="email" type="text" size="30"  value="'. $lp_email .'" /></td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="contact-form-box-text">Message</td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle" class="contact-form-box-text">
                      <textarea name="message" id="message" cols="23" rows="4">' . $lp_message . '</textarea>                      </td>
                    </tr>
                    <tr>
                      <td align="left" valign="middle">
					  	<input name="image" type="image" onMouseOver="this.src='."'http://www.ctosonthemove.com/landing-page/images/submit-buttn-h.jpg'".' onMouseOut="this.src='."'http://www.ctosonthemove.com/landing-page/images/submit-buttn.jpg'".' value="Sign Up" src="http://www.ctosonthemove.com/landing-page/images/submit-buttn.jpg"  alt="Sign Up"/>
					  </td>
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
</html>';

$writestring = $lp_page;
$file_path = '../landing-page/'.$cr_dir.'/index.php';
$handle = fopen($file_path, "w");
fwrite($handle, $writestring);
fclose($handle);


$directoryToZip="../landing-page/".$cr_dir.'/'; // This will zip all the file(s) in this present working directory

$outputDir='/'; //Replace "/" with the name of the desired output directory.
$zipName="lp.zip";

include_once("../landing-page/CreateZipFile.inc.php");
$createZipFile = new CreateZipFile;


// Code to Zip a single file
//$createZipFile->addDirectory($outputDir);
//$fileContents=file_get_contents($fileToZip);
//$createZipFile->addFile($fileContents, $outputDir.$fileToZip);


//Code toZip a directory and all its files/subdirectories
$createZipFile->zipDirectory($directoryToZip,$outputDir);

$rand=md5(microtime().rand(0,999999));
$zipName=$rand."_".$zipName;
$fd=fopen($zipName, "wb");
$out=fwrite($fd,$createZipFile->getZippedfile());
fclose($fd);
$createZipFile->forceDownload($zipName);
@unlink($zipName);

	
$rootPath = '../landing-page/'.$cr_dir;

$handle = opendir($rootPath);
while( ($file = @readdir($handle))!==false) {
	if($file !='.' && $file !='..'){
		if(is_file($rootPath.'/'.$file)) {
			@unlink($rootPath.'/'.$file);
		}
	}
}
if(is_file($rootPath.'/css/style.css')){
	@unlink($rootPath.'/css/style.css');
	@rmdir($rootPath.'/css');
}

$rootPathImage = '../landing-page/'.$cr_dir.'/images';
$handle1 = opendir($rootPathImage);
while( ($file = @readdir($handle1))!==false) {
	if($file !='.' && $file !='..'){
		if(is_file($rootPathImage.'/'.$file)) {
			@unlink($rootPathImage.'/'.$file);
		}
	}
}

@rmdir('../landing-page/'.$cr_dir.'/images');	
if(is_dir($rootPath)){
	@rmdir($rootPath.'/images');
	@rmdir($rootPath);
}
?>