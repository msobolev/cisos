<?php
include("includes/include-top.php");
$action = $_REQUEST['action'];
$uID = $_SESSION['sess_user_id'];
$msg = $_REQUEST['msg'];
if($action == 'ChangePassword'){
	$pass = $_POST['pass'];
	$user_update = "UPDATE " . TABLE_USER . "  set password = '$pass'  where user_id = '".$uID."'";
	com_db_query($user_update);
	$url = "my-change-password.php?msg=Your password successfully change";
	com_redirect($url);
}
$profile_result = com_db_query("select * from " . TABLE_USER . " where user_id='".$_SESSION['sess_user_id']."'");
$profile_row = com_db_fetch_array($profile_result);

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
        <td align="left" valign="top" class="header-nav"><a href="<?=HTTP_SERVER?>index.php">Home</a>  /  <a href="#" class="active"><?=$PageTitle;?></a></td>
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
          <td align="left" valign="middle" class="my-profile-page-title-text"><strong><a href="<?=HTTP_SERVER?>my-profile.php">My Profile</a></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=HTTP_SERVER?>my-subscription.php">My Subscription&nbsp;</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=HTTP_SERVER?>my-alert.php">My Alerts</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=HTTP_SERVER?>alert.php">Add New Alert</a>&nbsp;&nbsp;&nbsp;&nbsp;
		  <a href="<?=HTTP_SERVER?>my-change-password.php">Change Password</a>
		  <?PHP
		  $user_invoices = this_user_invoices();
		  if(sizeof($user_invoices) > 0)
		  {	 
		  ?>
		  &nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=HTTP_SERVER?>my-invoices.php">Invoices</a>
		  <?PHP
		  }
		  ?>
		  </td>
        </tr>
      </table></td>
      </tr>
	    <tr>
      <td align="left" valign="top" class="registration-page-bg"><img src="images/change-password-blue-down-arrow.jpg" width="502" height="21"  alt="" title="" /></td>
      </tr>
      </table></td>
      <td align="left"  valign="top">&nbsp;</td>
    </tr>
    <!-- heading end -->
    <!-- content start -->
   	<tr>
      <td align="left"  valign="top">&nbsp;</td>
      <td align="center" valign="top" class="registration-page-bg"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" valign="top" class="mgs-successfull-text"><strong><?=$msg;?>&nbsp;</strong></td>
        </tr>
        <tr>
          <td align="center" valign="top"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="114" align="left" valign="top">&nbsp;</td>
			  <td align="left" valign="top">
			  	 
				  	 <form name="frmChangePassword" id="frmChangePassword" method="post" action="my-change-password.php?action=ChangePassword">
					 <table width="500" border="0" align="left" cellpadding="0" cellspacing="0">
						<tr>
						  <td width="164" height="41" align="left" valign="top" class="content-text"><strong> Full Name :</strong></td>
						  <td width="336" height="41" align="left" valign="top" class="content-text"><?=$profile_row['first_name']?>&nbsp;<?=$profile_row['last_name']?></td>
						</tr>
						<!--<tr>
						  <td width="125" height="41" align="left" valign="top" class="content-text"><strong>Old Password  :</strong></td>
						  <td height="41" align="left" valign="top" class="content-text"><input type="password" name="old_pass" id="old_pass" /></td>
						</tr>-->
						<tr>
						  <td width="164" height="41" align="left" valign="top" class="content-text"><strong> New Password  :</strong></td>
						  <td height="41" align="left" valign="top" class="content-text"><input type="password" name="pass" id="pass" /></td>
						</tr>
						<tr>
						  <td width="164" height="41" align="left" valign="top" class="content-text"><strong> Re-type Password  :</strong></td>
						  <td height="41" align="left" valign="top" class="content-text"><input type="password" name="repass" id="repass" /></td>
						</tr>
						<tr>
						  <td height="41" align="left" valign="middle">&nbsp;</td>
						  <td height="41" align="left" valign="middle"><table width="200" border="0" align="left" cellpadding="0" cellspacing="0">
							<tr>
							  <td align="center" valign="middle" class="edit-buttn"><a href="javascript:ChangePasswordSubmit();" onclick="return ChangePasswordSubmit();">Save<img src="images/white-arrow-small.gif" width="12" height="9" alt="" title=""  border="0"/></a></td>
							  <td align="center" valign="middle">&nbsp;</td>
							</tr>
						  </table></td>
						</tr>
					  </table>
			    </form>
					 
			  </td>
            </tr>
            <tr>
              <td width="114" align="left" valign="top">&nbsp;</td>
              <td align="left" valign="top">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td align="center" valign="top"><img src="images/registration-page-bottom-bg.jpg" width="960" height="11" alt="" title="" /></td>
        </tr>
      </table></td>
      <td align="left"  valign="top">&nbsp;</td>
    </tr>
    </table>
    </div>
    <!-- content end-->
<?php      
include(DIR_INCLUDES."footer-content-page.php");
?>