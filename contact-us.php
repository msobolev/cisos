<?php
include("includes/include-top.php");
$page_content = com_db_output(com_db_GetValue("select page_content from " . TABLE_PAGE_CONTENT . " where page_name='".$current_page."'"));

if($_REQUEST['action']=='send') {
	
	if(($_SESSION['securitycode'] == $_POST['securitycode']) && (!empty($_SESSION['securitycode'])) ) {

      unset($_SESSION['securitycode']);
	  $name=$_POST['flname'];
	  $website=$_POST['website'];
	  $from=$_POST['email'];
	  $phone=$_POST['phone'];
	  $msg=nl2br($_POST['msg']);
	  
	 	$adminInfo = "select * from ". TABLE_ADMIN_SETTINGS ." where setting_id ='1'";
		$adminResult = com_db_query($adminInfo);
		$adminRow = com_db_fetch_array($adminResult);
		
		$from_admin = $adminRow['site_email_from'];
		$to_admin = $adminRow['site_email_address'];
		
		$site_owner_name = com_db_output($adminRow['site_owner_name']);
		$site_owner_position = com_db_output($adminRow['site_owner_position']);
		
		$site_domain_name = com_db_output($adminRow['site_domain_name']);
		$site_phone_number = com_db_output($adminRow['site_phone_number']);
		$site_company_address = com_db_output($adminRow['site_company_address']);
		$site_company_city  = com_db_output($adminRow['site_company_city']);
		$site_company_state = com_db_output($adminRow['site_company_state']);
		$site_company_zip = com_db_output($adminRow['site_company_zip']);
		
		$fromEmailSent='<table border="0" cellpadding="0" cellspacing="0">
							<tr><td align="left">'.$site_owner_name.'</td></tr>
							<tr><td align="left">'.$site_owner_position.'</td></tr>
							<tr><td align="left">'.$site_domain_name.'</td></tr>
							<tr><td align="left">'.$site_company_address.'</td></tr>
							<tr><td align="left">'.$site_company_city.', '.$site_company_state.'</td></tr>
							<tr><td align="left">'.$site_company_zip.'</td></tr>
							<tr><td align="left">'.$site_phone_number.'</td></tr>
							<tr><td align="left">'.$from_admin.'</td></tr>
						</table>';
	  
	  $subject = "CTOsOnTheMove.com :: One visitor have posted his/her info from 'Contact Me'.";
	  	
	  $message = '<table width="70%" cellspacing="0" cellpadding="3" >
					<tr>
						<td align="left" colspan="2"><b>Sender Details:</b></td>
					</tr>
					<tr>
						<td align="left"><b>Name:</b></td>
						<td align="left">'.$name.'</td>
					</tr>';
	  if($website!=''){
	  	$message .=	'<tr>
						<td align="left"><b>Website:</b></td>
						<td align="left">'.$website.'</td>
					</tr>';
	  
	  }
	  if($from!=''){
	    $message .=	'<tr>
						<td align="left"><b>Email:</b></td>
						<td align="left">'.$from.'</td>
					</tr>';
	  
	  }
	  if($phone!=''){
	  	$message .=	'<tr>
						<td align="left"><b>Phone:</b></td>
						<td align="left">'.$phone.'</td>
					</tr>';
	  
	  }
	  if($msg!=''){
	  	$message .=	'<tr>
						<td align="left"><b>Message:</b></td>
						<td align="left">'.$msg.'</td>
					</tr>';
	  
	  }
		$message .='<tr>
						<td align="left" colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<td align="left" colspan="2">'.$fromEmailSent.'</td>
					</tr>';
					
	$message .=	'</table>';
	
	@send_email($to_admin, $subject, $message, $from); 
	@send_email('info@ctosonthemove.com', $subject, $message, $from);
	 
	$dname=com_db_input($name);
	$dwebsite=com_db_input($website);
	$dphone=com_db_input($phone);
	$dfrom=com_db_input($from);
	$dmsg=com_db_input($msg);
	$add_date = date('Y-m-d');
	com_db_query("insert into " . TABLE_CONTACT_US . " (name,website,phone,email,message,add_date) values ('$dname','$dwebsite','$dphone','$dfrom','$dmsg','$add_date')");
   
   } else {
      
	$msg_error=MSG_EROR; 
	  
   }

}

include(DIR_INCLUDES."header-content-page.php");
?>	 
    <!-- heading start -->
 <div style="margin:0 auto; width:960px;">
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	 <tr>
        <td colspan="2" align="left" valign="top" class="caption-text">
		<?=com_db_GetValue("select page_content from " .TABLE_PAGE_CONTENT . " where page_name='index.php' and page_title='Page Heading'")?>
		</td>
    </tr>
    <tr><td colspan="2">&nbsp;</td></tr> 
    <!-- heading start -->
    <tr>
      <td align="left"  valign="top">&nbsp;</td>
      <td align="left" valign="top"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
	       <tr>
        <td align="left" valign="top" class="header-nav"><a href="<?=HTTP_SERVER?>index.php">Home</a>  /  <a href="#" class="active"><?=$PageTitle;?> </a></td>
      </tr>
   <tr>
      <td align="left" valign="top"><img src="images/specer.gif" width="1" height="10" alt="" title="" /></td>
      </tr>
      <tr>
      <td align="left" valign="middle" class="registration-page-heading-bg"><table width="960" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="left" valign="middle" class="registration-page-title-text"><?=$PageTitle;?> </td>
        </tr>
      </table></td>
      </tr>
	     <tr>
      <td align="left" valign="top" bgcolor="#f9fcff"><img src="images/blue-down-arrow.jpg" width="235" height="13"  alt="" title="" /></td>
      </tr>

      </table></td>
      <td align="left"  valign="top">&nbsp;</td>
    </tr>
    <!-- heading end -->
    <!-- content input -->
	<?php if($_REQUEST['action']==''){?>
    <tr>
    <td width="21" align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top" bgcolor="#f9fcff">
	
	<table width="896" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
       <td width="326" align="left" valign="top">&nbsp;</td>
       <td width="45" align="left" valign="top">&nbsp;</td>
       <td align="left" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td width="326" align="left" valign="top">
		<form name="myform" id="myform" action="contact-us.php?action=send" method="post" >
		<table width="326" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center" valign="top" bgcolor="#b9e0f6"><table width="305" border="0" align="center" cellpadding="6" cellspacing="0">
                <tr>
                  <td align="left" valign="top"><img src="images/specer.gif" width="1" height="5" alt="" title="" /></td>
                </tr>
                <tr>
                  <td height="20" align="left" valign="middle" class="content-text"><strong>First and Last Name:</strong></td>
                </tr>
                <tr>
                  <td height="20" align="left" valign="middle" class="content-text"><input name="flname" type="text" id="flname" size="44" class="text-field-box" /></td>
                </tr>
                <tr>
                  <td height="20" align="left" valign="middle" class="content-text"><strong>Website:</strong></td>
                </tr>
                <tr>
                  <td height="20" align="left" valign="middle" class="content-text"><input name="website" type="text" id="website" size="44"  class="text-field-box" /></td>
                </tr>
                <tr>
                  <td height="20" align="left" valign="middle" class="content-text"><strong>Email:</strong></td>
                </tr>
                <tr>
                  <td height="20" align="left" valign="middle" class="content-text"><input name="email" type="text" id="email" size="44" class="text-field-box" /></td>
                </tr>
                <tr>
                  <td height="20" align="left" valign="middle" class="content-text"><strong>Phone (optional):</strong></td>
                </tr>
                <tr>
                  <td height="20" align="left" valign="middle" class="content-text"><input name="phone" type="text" id="phone" size="44"  class="text-field-box" /></td>
                </tr>
                <tr>
                  <td height="20" align="left" valign="middle" class="content-text"><strong>Message:</strong></td>
                </tr>
                <tr>
                  <td align="left" valign="middle" class="content-text"><textarea name="msg" id="msg" cols="35" rows="4" ></textarea>                  </td>
                </tr>
                <tr>
                  <td height="20" align="left" valign="middle" class="content-text"><strong>Enter the number you see in the image below.</strong></td>
                </tr>
                <tr>
                  <td align="left" valign="middle" class="content-text">This test is used to prevent automated robots from 
                    posting  comments</td>
                </tr>
                <tr>
                  <td align="left" valign="top"><img src="images/specer.gif" width="1" height="2" alt="" title="" /></td>
                </tr>
             
                <tr>
                  <td align="left" valign="middle" class="content-text">
				  <script type="text/javascript" language="javascript" src="<?=DIR_JS?>captcha.js"></script>
				  <table width="305" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="121" align="left" valign="middle"><img src="captcha.php?width=113&amp;height=35&amp;characters=6" alt="Image" title="Image"/></td>
                      <td width="184" align="left" valign="middle"><input name="securitycode" type="text" id="securitycode" size="25" class="text-field-box-small"  /></td>
                    </tr>
                  </table></td>
                </tr>
           
                <tr>
                  <td align="left" valign="top"><img src="images/specer.gif" width="1" height="2" alt="" title="" /></td>
                </tr>
                <tr>
                  <td align="center" valign="middle"><table width="110" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="center" valign="top" class="submit-buttn"><a href="javascript:FormValueSubmit('myform');" onclick="return checkform();">Submit</a></td>
                    </tr>
                  </table></td>
                </tr>
             
                <tr>
                  <td align="left" valign="top"><img src="images/specer.gif" width="1" height="5" alt="" title="" /></td>
                </tr>
            </table></td>
          </tr>
        </table>
		</form>
		</td>
        <td width="45" align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top">
		<?=$page_content?>
		</td>
      </tr>
      <tr>
        <td width="326" align="left" valign="top">&nbsp;</td>
        <td width="45" align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top">&nbsp;</td>
      </tr>

    </table>
	
	</td>
  </tr>
	</table></td>
    <td width="21" align="left" valign="top">&nbsp;</td>
  </tr>
  <!-- content input end -->
  <?PHP }elseif($_REQUEST['action']=='send'){?>
  <!-- content send start -->
  <tr>
    <td width="21" align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top" class="registration-page-bg"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top"><table width="775" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="left" valign="top"><img src="images/specer.gif" width="1" height="50" alt="" title="" /> </td>
      </tr>
      <tr>
        <td align="left" valign="top" class="alert-confirmation-box-text"><p>Thank you for contacting us. Someone from CISOsOnTheMove&rsquo;s team will <br />
          get back to you shortly.</p>
            </td>
      </tr>
      <tr>
        <td align="center" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" valign="top">&nbsp;</td>
      </tr>
	  
    </table></td>
  </tr>
</table></td>
    <td width="21" align="left" valign="top">&nbsp;</td>
  </tr>
  <!-- content send end -->
  <?PHP } ?>
   </table>
    </div>
    <!-- content end-->
<?php      
include(DIR_INCLUDES."footer-content-page.php");
?>