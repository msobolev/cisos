<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><? if($current_page!='vigilant-appoints.php'){echo 'CTOsOnTheMove.com ::';}?> Subscription</title>
<meta name="keywords" content="<? //=$PageKeywords?>CTO, subscription" />
<meta name="description" content="<? //=$PageDescription?>subscription" />
<link rel="shortcut icon" href="../images/favicon.jpg" type="image/x-icon" />

<link href="../<?=DIR_CSS?>style.css" rel="stylesheet" type="text/css" />
<link href="../<?=DIR_CSS?>combo-box.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../<?=DIR_JS?>combo-js.js" language="javascript"></script>
<script type="text/javascript" src="../<?=DIR_JS?>validation.js" language="javascript"></script>
<script type="text/javascript" src="../<?=DIR_JS?>datetimepicker_css.js" language="javascript"></script>
<script type="text/javascript" src="../<?=DIR_JS?>combo-box.js"></script>
<script type="text/javascript" language="javascript">
	function LoginPage(){
		window.location="../login.php";
	}
</script>
</head>
<? 
$side_logo = com_db_GetValue("select image_path from ". TABLE_BANNER . " where id='1'");
$search_msg=$_REQUEST['search_msg'];
?>
<body>
<div id="light" class="white_content" style="display:<? if($search_msg=='Result Not Found'){ echo 'block';} else { echo 'none'; } ?>;">
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="left" valign="top"><img src="../images/specer.gif" width="1" height="50" alt="" title="" /> </td>
      </tr>
      <tr>
        <td align="left" valign="top" >There are no matching results. Please <a href="<?=$_REQUEST['burl'];?>">edit your search</a></td>
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
      <tr>
        <td align="center" valign="top"><a href="../<?=$_REQUEST['burl'];?>"><img src="../images/back-buttn.jpg" width="107" height="45" border="0" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'" alt="Back" title="Back"/></a></td>
      </tr>
      <tr>
        <td align="center" valign="top">&nbsp;</td>
      </tr>
    </table>
</div>
<div id="light-free" class="white_content_free" style="display:<? if($user_info=='FreeUser'){ echo 'block';} else { echo 'none'; } ?>;">
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="left" valign="top"><img src="../images/specer.gif" width="1" height="50" alt="" title="" /> </td>
      </tr>
      <tr>
        <td align="left" valign="top" >Please upgrade your account now. It is $85/month and you can cancel any time</td>
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
     
	  <tr>
          <td align="center" valign="top"><table width="214" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td align="center" valign="top">&nbsp;</td>
              <td align="center" valign="top">&nbsp;</td>
              <td align="center" valign="top" class="next-buttn">
			  <a href="../choose-subscription.php?res_id=<?=$_SESSION['sess_user_id'];?>">Next&nbsp;<img src="../images/next-arrow-big.gif" width="11" height="11" alt=""  title="" border="0" onclick = "document.getElementById('light-free').style.display='none';document.getElementById('fade-free').style.display='none'"/></a></td>
            </tr>
          </table></td>
        </tr>
      <tr>
        <td align="center" valign="top">&nbsp;</td>
      </tr>
    </table>
</div>
<div id="fade" class="black_overlay" style="display:<? if($search_msg=='Result Not Found'){ echo 'block';} else { echo 'none'; } ?>;"></div>
<div id="fade-free" class="black_overlay" style="display:<? if($user_info=='FreeUser'){ echo 'block';} else { echo 'none'; } ?>;"></div>
<table width="1002" border="0" align="center" cellpadding="0" cellspacing="0">

  <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top" class="top-header-bg"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
    
      <tr>
        <td align="center" valign="top">
		<? if($_SESSION['sess_is_user'] != 1){?>
		<table width="928" border="0" align="center" cellpadding="0" cellspacing="0">
		      <tr>
        <td align="left" valign="top"><img src="../images/specer.gif" width="1" height="38" alt="" title="" /></td>
      </tr>
          <tr>
            <td width="196" align="left" valign="top"><a href="../index.php"><img src="../images/<?=$side_logo?>"  alt="Logo" width="196" height="32" border="0" title="Logo" /></a></td>
            <td width="555" align="left" valign="top">&nbsp;</td>
            
			<td width="237" align="left" valign="top">
			   <!-- login box -->
				<div id="question_mark" style="display:none; position:absolute; top:75px; width:230px;">
				<table width="235" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top" class="help-popup-bg"><table width="195" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="left" valign="top"><img src="../images/specer.gif" width="1" height="5" alt="" title="" /></td>
      </tr>
      <tr>
        <td align="left" valign="middle"  class="help-popup-text">Register to get access to thousands of responsive, actionable and relevant sales leads</td>
      </tr>
  
    </table></td>
  </tr>

</table>
					
				</div>
			<div class="login_box_in">
						 <div id="reg1" style="display: block;">
							<div class="left1"> <a href="javascript:LoginPage();">Login</a> | <a href="../provide-contact-information.php">Register</a></div>
							<div class="right1"><a href="javascript://"  onmouseover="question_mark_show('question_mark');" onmouseout="question_mark_close('question_mark');"><img src="../images/logi-register-right-icon.jpg" width="19" height="19" border="0" alt="" title=""/></a></div>
						 </div>
						 <div id="reg2" style="display: none;">
							 <form name="frm_login" method="post" action="../res-process.php?action=UserLogin">
								 <div class="login_box_middle ">	
									 <div class="row">
										 <div class="n">User name/ Email Address:</div>
										 <div class="v"><input type="text" name="login_email" id="login_email" value="" /></div>
									  </div>
							
									 <div class="row">
										 <div class="n">Password</div>
										 <div class="v"><input type="password" name="login_pass" id="login_pass" value="" /></div>
									 </div>
									
									 <div class="row">
										<div class="login_button">
												  <input name="image" type="image" onmouseover="this.src='../images/popup-login-buttn-h.gif'" onmouseout="this.src='../images/popup-login-buttn.gif'" value="Login" src="../images/popup-login-buttn.gif"  alt="Login"/>
										</div>
										<div class="link"><a href="../forgot-password.php">Forgot&nbsp;Your&nbsp;password?</a></div>
									</div>
								</div>
							</form>
							<div class="login_box_bottom"></div>
						</div>
					</div>
				
       <!-- // login box -->	
				</td>
			</tr>
        </table>
	<? }elseif($_SESSION['sess_is_user'] == 1){ ?>
			<table width="928" border="0" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td align="left" valign="top"><img src="../images/specer.gif" width="1" height="38" alt="" title="" /></td>
			 </tr>
			  <tr>
				<td width="196" align="left" valign="top"><a href="../index.php"><img src="../images/<?=$side_logo?>"  alt="Logo" width="196" height="32" border="0" title="Logo" /></a></td>
				<td width="495" align="left" valign="top">&nbsp;</td>
				<td width="237" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
				  <tr>
					<td align="right" valign="top" class="login-register-text"><strong><?=$_SESSION['sess_username']?>:&nbsp;<a href="../my-profile.php">Profile:</a>&nbsp;<a href="../logout.php">Logout</a></strong></td>
				  </tr>
				</table></td>
			  </tr>
			</table>
			<? } ?>
			</td>
		</tr>
           <tr>
        <td align="left" valign="top" class="caption-text">
		<!--We Enable You to Sell More IT Faster by Providing Unique, Responsive and Actionable Sales Leads-->
		<?=com_db_GetValue("select page_content from " .TABLE_PAGE_CONTENT . " where page_name='index.php' and page_title='Page Heading'")?>
		</td>
      </tr>
  	  <tr>
        <td align="left" valign="top"><img src="../images/specer.gif" width="1" height="33" alt="" title="" /></td>
      </tr>

    </table></td>
    <td align="left" valign="top">&nbsp;</td>
  </tr>