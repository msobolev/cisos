<?php
include("includes/include-top.php");

$page_content = com_db_output(com_db_GetValue("select page_content from " . TABLE_PAGE_CONTENT . " where page_name='".$current_page."'"));

if($_REQUEST['action']=='add') {
	
	if(($_SESSION['securitycode'] == $_POST['securitycode']) && (!empty($_SESSION['securitycode']) && (!empty($_POST['securitycode']))) ) {

		unset($_SESSION['securitycode']);
		$name=$_POST['flname'];
		$website=$_POST['website'];
		$from=$_POST['email'];
		$phone=$_POST['phone'];
		$msg=nl2br($_POST['msg']);

		$dname=com_db_input($name);
		$dwebsite=com_db_input($website);
		$dphone=com_db_input($phone);
		$dfrom=com_db_input($from);
		$dmsg=com_db_input($msg);
		$add_date = date('Y-m-d');
		com_db_query("insert into " . TABLE_PARTNERS . " (name,website,phone,email,message,add_date) values ('$dname','$dwebsite','$dphone','$dfrom','$dmsg','$add_date')");
   }else{
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
          <td align="left" valign="middle" class="registration-page-title-text"><?=$PageTitle;?></td>
        </tr>
      </table></td>
      </tr>
	    <tr>
      <td align="left" valign="top" class="registration-page-bg"><img src="images/blue-down-arrow.jpg" width="235" height="13"  alt="" title="" /></td>
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
          <td align="center" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td align="center" valign="top">
		  <?php if($_REQUEST['action']==''){?>
		  
		  <table width="928" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td align="left" valign="top" class="inner-page-bold-text"><strong><?=$page_content?></strong></td>
            </tr>
            <tr>
              <td align="left" valign="top">&nbsp;</td>
            </tr>
            <tr>
              <td align="center" valign="top"><table width="326" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="center" valign="top" bgcolor="#b9e0f6">
				  <form name="myform" id="myform" method="post" action="partners.php?action=add">
				  <table width="305" border="0" align="center" cellpadding="6" cellspacing="0">
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
                      <td align="left" valign="middle" class="content-text"><textarea name="msg" cols="35" id="msg" rows="4" ></textarea>
                      </td>
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
                            <td width="184" align="left" valign="middle"><input name="securitycode" type="text" id="securitycode" size="25" class="text-field-box-small" /></td>
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
                  </table>
				  </form>
				  </td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td align="left" valign="top">&nbsp;</td>
            </tr>
          </table>
		   <?PHP }elseif($_REQUEST['action']=='add'){?>
			
			<table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
				  <td align="left" valign="top"><img src="images/specer.gif" width="1" height="100" alt="" title="" /></td>
				</tr>
				<tr>
				  <td align="left" valign="top" class="alert-confirmation-box-text"><p>Thank You! Someone from our team will get in touch with you shortly</p>
					</td>
				</tr>
				<tr>
				  <td align="left" valign="top"><img src="images/specer.gif" width="1" height="100" alt="" title="" /></td>
				</tr>
				<tr>
				  <td align="center" valign="top">&nbsp;</td>
				</tr>
				<tr>
				  <td align="center" valign="top">&nbsp;</td>
				</tr>
			  </table>
			<?PHP } ?>	
		  
		  </td>
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