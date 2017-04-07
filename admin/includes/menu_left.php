<?PHP
// remove below line
$_SESSION['login_access_type'] ='Admin';
?>

<td width="196" align="left" valign="top" class="left-box-bottom-border">
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <?php if($_SESSION['login_access_type']=='Admin'){ ?>
           <tr>
            <td align="left" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                   <td align="center" valign="middle"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                     <tr>
                          <td align="center" valign="middle" class="left">
                          <table width="167" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td align="left" valign="middle"><a href="javascript:ShowMenu('index.php','general');" class="heading-text-a">General</a></td>
                                <td width="13" align="right" valign="middle"><a href="javascript:ShowMenu('index.php','general');"><img src="images/<?php if($_REQUEST['selected_menu']=='general') echo 'up-arrow.jpg'; else echo 'down-arrow.jpg';?>" width="13" height="12" border="0" alt="" title="" /></a></td>
                              </tr>
                          </table></td>
                     </tr>
                   </table></td>
              </tr>
              <tr>
                <td align="left" valign="top">
				
				<div id="general" <?php if($_REQUEST['selected_menu']=='general') echo 'style="display:block;"'; else echo 'style="display:none;"';?>>
				
				<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='index.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                    <td width="159" align="left" valign="middle" class="left-box-text"><a href="index.php?selected_menu=general">Dashboard</a></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='user-dashboard.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                    <td width="159" align="left" valign="middle" class="left-box-text"><a href="user-dashboard.php?selected_menu=general">User Dashboard</a></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='admin_details.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                    <td width="159" align="left" valign="middle" class="left-box-text"><a href="admin_details.php?selected_menu=general">Site Info</a></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='password.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                    <td width="159" align="left" valign="middle" class="left-box-text"><a href="password.php?selected_menu=general">Change Password</a></td>
                  </tr>
                </table></td>
              </tr>
                </table>
				</div>				</td>
              </tr>
            </table></td>
          </tr>
		
        
		   <tr>
            <td align="left" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" valign="middle"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                     <td align="center" valign="middle" class="left-box-text-heading-bg">
                     	<table width="167" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td align="left" valign="middle"><a href="javascript:ShowMenu('user.php','user');" class="heading-text-a">User Manager</a></td>
                            <td width="13" align="right" valign="middle"><a href="javascript:ShowMenu('user.php','user');"><img src="images/<?php if($_REQUEST['selected_menu']=='user') echo 'up-arrow.jpg'; else echo 'down-arrow.jpg';?>" width="13" height="12"  alt="" title="" border="0"/></a></td>
                          </tr>
                        </table>
                    </td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top">
				<div id="menu" <?php if($_REQUEST['selected_menu']=='user') echo 'style="display:block;"'; else echo 'style="display:none;"';?>>
				<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='user.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="user.php?selected_menu=user">User</a></td>
                          </tr>
                      </table></td>
                    </tr>
					<tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='user-download.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="user-download.php?selected_menu=user">User Export</a></td>
                          </tr>
                      </table></td>
                    </tr>
					<tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='user-only-sign-up.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="user-only-sign-up.php?selected_menu=user">User Only Sign Up</a></td>
                          </tr>
                      </table></td>
                    </tr>
					<tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='user-only-sign-up-download.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="user-only-sign-up-download.php?selected_menu=user">User Only Sign Up Export</a></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='user-referred-from.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="user-referred-from.php?selected_menu=user">User Referred From</a></td>
                          </tr>
                      </table></td>
                    </tr>
                	<tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='free-user-alert-send.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="free-user-alert-send.php?selected_menu=user">Free User Alert Send</a></td>
                          </tr>
                      </table></td>
                    </tr>					
                    <tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='user-reg-step.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="user-reg-step.php?selected_menu=user">User Registration step 1</a></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='our-partners.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="our-partners.php?selected_menu=user">Our Partners</a></td>
                          </tr>
                      </table></td>
                    </tr>
					<tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='contact-us.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="contact-us.php?selected_menu=user">Contact Us</a></td>
                          </tr>
                      </table></td>
                    </tr>
					<tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='dataentry-user.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="dataentry-user.php?selected_menu=user">Data Entry User </a></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='delete-user.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="delete-user.php?selected_menu=user">Duplicate Email</a></td>
                          </tr>
                      </table></td>
                    </tr>
                </table>
				</div>				</td>
              </tr>
            </table></td>
          </tr> 
          
           <!--<tr>
            <td align="left" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" valign="middle"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                     <td align="center" valign="middle" class="left-box-text-heading-bg"><table width="167" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="left" valign="middle"><a href="javascript:ShowMenu('contact.php','contact');" class="heading-text-a">Contact Manager</a></td>
            <td width="13" align="right" valign="middle"><a href="javascript:ShowMenu('contact.php','contact');"><img src="images/<?php// if($_REQUEST['selected_menu']=='contact') echo 'up-arrow.jpg'; else echo 'down-arrow.jpg';?>" width="13" height="12"  alt="" title="" border="0"/></a></td>
          </tr>
        </table></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top">
				<div id="menu" <?php// if($_REQUEST['selected_menu']=='contact') echo 'style="display:block;"'; else echo 'style="display:none;"';?>>
				<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
                      <td align="center" valign="middle" <?php// if(basename($_SERVER['PHP_SELF'])=='contact.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="contact.php?selected_menu=contact">Contact Information</a></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td align="center" valign="middle" <?php// if(basename($_SERVER['PHP_SELF'])=='contact-import.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="contact-import.php?selected_menu=contact">Contact Data Import</a></td>
                          </tr>
                      </table></td>
                    </tr>
					<tr>
                      <td align="center" valign="middle" <?php// if(basename($_SERVER['PHP_SELF'])=='contact-update.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="contact-update.php?selected_menu=contact">Contact Data Update</a></td>
                          </tr>
                      </table></td>
                    </tr>
					 <tr>
                      <td align="center" valign="middle" <?php// if(basename($_SERVER['PHP_SELF'])=='contant-export.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="contant-export.php?selected_menu=contact">Contact Data Export</a></td>
                          </tr>
                      </table></td>
                    </tr>
					<tr>
                      <td align="center" valign="middle" <?php// if(basename($_SERVER['PHP_SELF'])=='contact-report.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="contact-report.php?selected_menu=contact">Data Entry - Publish</a></td>
                          </tr>
                      </table></td>
                    </tr>
                </table>
				</div>				</td>
              </tr>
			  
            </table></td>
          </tr>--> 
          
          <tr>
            <td align="left" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" valign="middle"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                     <td align="center" valign="middle" class="left-box-text-heading-bg">
                     <table width="167" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="left" valign="middle">
                            <!-- <a href="javascript:ShowMenu('company-master.php','master');" class="heading-text-a">Company Master Data</a> -->
                            <a href="company-search.php?selected_menu=master" class="heading-text-a">Company Master Data</a>
                        </td>
                        <td width="13" align="right" valign="middle"><a href="javascript:ShowMenu('company-master.php','master');"><img src="images/<?php if($_REQUEST['selected_menu']=='master') echo 'up-arrow.jpg'; else echo 'down-arrow.jpg';?>" width="13" height="12"  alt="" title="" border="0"/></a></td>
                      </tr>
                    </table></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top">
				<div id="menu" <?php if($_REQUEST['selected_menu']=='master') echo 'style="display:block;"'; else echo 'style="display:none;"';?>>
				<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='company-master.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="company-master.php?selected_menu=master">Company Master Information</a></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='company-master-import.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="company-master-import.php?selected_menu=master">Company Master Import</a></td>
                          </tr>
                      </table></td>
                    </tr>
					 <tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='company-master-export.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="company-master-export.php?selected_menu=master">Company Master Data Export</a></td>
                          </tr>
                      </table></td>
                    </tr>
					
					
					
					<tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='company-master-duplicates.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="company-master-duplicates.php?selected_menu=master">Company Master Duplicates</a></td>
                          </tr>
					</table></td>
                    </tr>
					
					
					<tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='company-master-append.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="company-master-append.php?selected_menu=master">Company Master Data Append</a></td>
                          </tr>
					</table></td>
                    </tr>
					
					
					<tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='company-master-mailserver-append.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="company-master-mailserver-append.php?selected_menu=master">Company Master Data Mail Server Setting Append</a></td>
                          </tr>
					</table></td>
                    </tr>
			
                    
                    
                    <tr>
                        <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='company-master-merge.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom">
                            <table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                                    <td width="159" align="left" valign="middle" class="left-box-text"><a href="company-master-merge.php?selected_menu=master">Company Master Merge</a></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <tr>
                        <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='company-master-export-pattern.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom">
                            <table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                                    <td width="159" align="left" valign="middle" class="left-box-text"><a href="company-master-export-pattern.php?selected_menu=master">Company Master Export Pattern</a></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <tr>
                        <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='company-updates.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom">
                            <table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                                    <td width="159" align="left" valign="middle" class="left-box-text"><a href="company-updates.php?selected_menu=master">Company Updates</a></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
					
					<!--<tr>
                      <td align="center" valign="middle" <?php// if(basename($_SERVER['PHP_SELF'])=='company-job-info.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="company-job-info.php?selected_menu=master">Company Job Information</a></td>
                          </tr>
                      </table></td>
                    </tr>-->
                   <!-- <tr>
                      <td align="center" valign="middle" <?php// if(basename($_SERVER['PHP_SELF'])=='company-master-create.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom">
                          <table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                                <td width="159" align="left" valign="middle" class="left-box-text"><a href="company-master-create.php?selected_menu=master">Company Master Create</a></td>
                              </tr>
                          </table>
                      </td>
                    </tr>
                    <tr>
                      <td align="center" valign="middle" <?php// if(basename($_SERVER['PHP_SELF'])=='master-contact.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom">
                          <table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                                <td width="159" align="left" valign="middle" class="left-box-text"><a href="master-contact.php?selected_menu=master">Master Contact Update</a></td>
                              </tr>
                          </table>
                      </td>
                    </tr>-->
                </table>
				</div>	
                </td>
              </tr>
			  
            </table></td>
          </tr>
          
          <tr>
            <td align="left" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" valign="middle"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                     <td align="center" valign="middle" class="left-box-text-heading-bg">
                     <table width="167" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="left" valign="middle"><a href="javascript:ShowMenu('personal-master.php','personal');" class="heading-text-a">Personal Master</a></td>
                        <td width="13" align="right" valign="middle"><a href="javascript:ShowMenu('personal-master.php','personal');"><img src="images/<?php if($_REQUEST['selected_menu']=='personal') echo 'up-arrow.jpg'; else echo 'down-arrow.jpg';?>" width="13" height="12"  alt="" title="" border="0"/></a></td>
                      </tr>
                    </table></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top">
				<div id="menu" <?php if($_REQUEST['selected_menu']=='personal') echo 'style="display:block;"'; else echo 'style="display:none;"';?>>
				<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='personal-master.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="personal-master.php?selected_menu=personal">Personal Master Information</a></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='personal-master-import.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="personal-master-import.php?selected_menu=personal">Personal Master Import</a></td>
                          </tr>
                      </table></td>
                    </tr>
					<tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='personal-master-export.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="personal-master-export.php?selected_menu=personal">Personal Master Export</a></td>
                          </tr>
                      </table></td>
                    </tr>
					
					<tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='personal_filter.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="personal_filter.php?selected_menu=personal">Personal Filter on/off</a></td>
                          </tr>
                      </table></td>
                    </tr>
					
					
					<tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='personal-master-append.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="personal-master-append.php?selected_menu=personal">Personal Master Data Append</a></td>
                          </tr>
                      </table></td>
                    </tr>
					
					

<!--2014-08-09-->
					<tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='personal-image.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="personal-image.php?selected_menu=personal">Image Display on/off</a></td>
                          </tr>
                      </table></td>
                    </tr>
<!--2014-08-09-->


                <tr>            
                    <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='personal-master-merge.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom">
                        <table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                                <td width="159" align="left" valign="middle" class="left-box-text"><a href="personal-master-merge.php?selected_menu=personal">Personal Master Merge</a></td>
                            </tr>
                        </table>
                    </td>
                </tr>



					
                 </table>
				</div>	
                </td>
              </tr>
			  
            </table></td>
          </tr> 
          
          <tr>
            <td align="left" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" valign="middle"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                     <td align="center" valign="middle" class="left-box-text-heading-bg">
                     <table width="167" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="left" valign="middle"><a href="javascript:ShowMenu('movement-master.php','movement');" class="heading-text-a">Movement Master</a></td>
                        <td width="13" align="right" valign="middle"><a href="javascript:ShowMenu('movement-master.php','movement');"><img src="images/<?php if($_REQUEST['selected_menu']=='movement') echo 'up-arrow.jpg'; else echo 'down-arrow.jpg';?>" width="13" height="12"  alt="" title="" border="0"/></a></td>
                      </tr>
                    </table></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top">
				<div id="menu" <?php if($_REQUEST['selected_menu']=='movement') echo 'style="display:block;"'; else echo 'style="display:none;"';?>>
				<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='movement-master.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom">
                          <table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                                <td width="159" align="left" valign="middle" class="left-box-text"><a href="movement-master.php?selected_menu=movement">Movement Master</a></td>
                              </tr>
                          </table>
                      </td>
                    </tr>
                    <tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='movement-data-import.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom">
                          <table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                                <td width="159" align="left" valign="middle" class="left-box-text"><a href="movement-data-import.php?selected_menu=movement">Movement Data Import</a></td>
                              </tr>
                          </table>
                      </td>
                    </tr>
                    <tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='movement-export.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom">
                          <table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                                <td width="159" align="left" valign="middle" class="left-box-text"><a href="movement-export.php?selected_menu=movement">Movement Data Export</a></td>
                              </tr>
                          </table>
                      </td>
                    </tr>
                    <tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='movement-merge.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom">
                          <table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                                <td width="159" align="left" valign="middle" class="left-box-text"><a href="movement-merge.php?selected_menu=movement">Movement Merge</a></td>
                              </tr>
                          </table>
                      </td>
                    </tr>
                </table>
				</div>	
                </td>
              </tr>
			  
            </table></td>
          </tr> 
          
          <tr>
            <td align="left" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" valign="middle"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                     <td align="center" valign="middle" class="left-box-text-heading-bg"><table width="167" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="left" valign="middle"><a href="javascript:ShowMenu('industries.php','industries');" class="heading-text-a">Industries Manager</a></td>
                        <td width="13" align="right" valign="middle"><a href="javascript:ShowMenu('industries.php','industries');"><img src="images/<?php if($_REQUEST['selected_menu']=='industries') echo 'up-arrow.jpg'; else echo 'down-arrow.jpg';?>" width="13" height="12"  alt="" title="" border="0"/></a></td>
                      </tr>
                    </table></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top">
				<div id="menu" <?php if($_REQUEST['selected_menu']=='industries') echo 'style="display:block;"'; else echo 'style="display:none;"';?>>
				<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='industries.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="industries.php?selected_menu=industries">Industries</a></td>
                          </tr>
                      </table></td>
                    </tr>
                    
                </table>
				</div>				</td>
              </tr>
            </table></td>
          </tr>
         
		  
		 <tr>
            <td align="left" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" valign="middle"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                     <td align="center" valign="middle" class="left-box-text-heading-bg"><table width="167" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="left" valign="middle"><a href="javascript:ShowMenu('subscription.php','subscription');" class="heading-text-a">Subscription Manager</a></td>
                        <td width="13" align="right" valign="middle"><a href="javascript:ShowMenu('subscription.php','subscription');"><img src="images/<?php if($_REQUEST['selected_menu']=='subscription') echo 'up-arrow.jpg'; else echo 'down-arrow.jpg';?>" width="13" height="12"  alt="" title="" border="0"/></a></td>
                      </tr>
                    </table></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top">
				<div id="subscription" <?php if($_REQUEST['selected_menu']=='subscription') echo 'style="display:block;"'; else echo 'style="display:none;"';?>>
				<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='subscription.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="subscription.php?selected_menu=subscription">View Subscription</a></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='free-subscription.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="free-subscription.php?selected_menu=subscription">Special Offers</a></td>
                          </tr>
                      </table></td>
                    </tr>
					<tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='subscription-alert.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="subscription-alert.php?selected_menu=subscription">Subscription Alert</a></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='alert-price.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="alert-price.php?selected_menu=subscription">Alert Price</a></td>
                          </tr>
                      </table></td>
                    </tr>
                </table>
				</div>				</td>
              </tr>
            </table></td>
          </tr>
		  <tr>
          </tr>
          
		 <tr>
            <td align="left" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" valign="middle"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                     <td align="center" valign="middle" class="left-box-text-heading-bg"><table width="167" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="left" valign="middle"><a href="javascript:ShowMenu('news.php','news');" class="heading-text-a">News Manager</a></td>
                        <td width="13" align="right" valign="middle"><a href="javascript:ShowMenu('news.php','news');"><img src="images/<?php if($_REQUEST['selected_menu']=='news') echo 'up-arrow.jpg'; else echo 'down-arrow.jpg';?>" width="13" height="12"  alt="" title="" border="0"/></a></td>
                      </tr>
                    </table></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top">
				<div id="news" <?php if($_REQUEST['selected_menu']=='news') echo 'style="display:block;"'; else echo 'style="display:none;"';?>>
				<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='news.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="news.php?selected_menu=news">View News</a></td>
                          </tr>
                      </table></td>
                    </tr>
                </table>
				</div>				</td>
              </tr>
            </table></td>
          </tr>
		  <tr>
          </tr>
		  
		  <tr>
            <td align="left" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" valign="middle"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                     <td align="center" valign="middle" class="left-box-text-heading-bg"><table width="167" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="left" valign="middle"><a href="javascript:ShowMenu('domain-entry.php','domain');" class="heading-text-a">Domain Manager</a></td>
                        <td width="13" align="right" valign="middle"><a href="javascript:ShowMenu('domain-entry.php','domain');"><img src="images/<?php if($_REQUEST['selected_menu']=='domain') echo 'up-arrow.jpg'; else echo 'down-arrow.jpg';?>" width="13" height="12"  alt="" title="" border="0"/></a></td>
                      </tr>
                    </table></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top">
				<div id="news" <?php if($_REQUEST['selected_menu']=='domain') echo 'style="display:block;"'; else echo 'style="display:none;"';?>>
				<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='domain-entry.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="domain-entry.php?selected_menu=domain">Banned Domain</a></td>
                          </tr>
                      </table></td>
                    </tr>
                </table>
				</div>				</td>
              </tr>
            </table></td>
          </tr>
		  <tr>
          </tr>
		  
		 <tr>
            <td align="left" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" valign="middle">
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                     <td align="center" valign="middle" class="left-box-text-heading-bg"><table width="167" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="left" valign="middle"><a href="javascript:ShowMenu('create-sitemap.php','sitemap');" class="heading-text-a">Sitemap Manager</a></td>
                        <td width="13" align="right" valign="middle"><a href="javascript:ShowMenu('create-sitemap.php','sitemap');"><img src="images/<?php if($_REQUEST['selected_menu']=='faq') echo 'up-arrow.jpg'; else echo 'down-arrow.jpg';?>" width="13" height="12"  alt="" title="" border="0"/></a></td>
                      </tr>
                    </table></td>
                    </tr>
                </table></td>
              </tr>
              
              <tr>
                <td align="left" valign="top">
				<div id="sitemap" <?php if($_REQUEST['selected_menu']=='sitemap') echo 'style="display:block;"'; else echo 'style="display:none;"';?>>
				<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='create-sitemap.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="create-sitemap.php?selected_menu=sitemap">Sitemap Create</a></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='create-sitemap-company.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="create-sitemap-company.php?selected_menu=sitemap">Company Sitemap Create</a></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='create-sitemap-personal.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="create-sitemap-personal.php?selected_menu=sitemap">Personal Sitemap Create</a></td>
                          </tr>
                      </table></td>
                    </tr>
                </table>
				</div>				</td>
              </tr>
            </table></td>
          </tr>
		  <tr>
          </tr>
          
		 <tr>
            <td align="left" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" valign="middle"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                     <td align="center" valign="middle" class="left-box-text-heading-bg"><table width="167" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="left" valign="middle"><a href="javascript:ShowMenu('faq.php','faq');" class="heading-text-a">Faq Manager</a></td>
                        <td width="13" align="right" valign="middle"><a href="javascript:ShowMenu('faq.php','faq');"><img src="images/<?php if($_REQUEST['selected_menu']=='faq') echo 'up-arrow.jpg'; else echo 'down-arrow.jpg';?>" width="13" height="12"  alt="" title="" border="0"/></a></td>
                      </tr>
                    </table></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top">
				<div id="news" <?php if($_REQUEST['selected_menu']=='faq') echo 'style="display:block;"'; else echo 'style="display:none;"';?>>
				<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='faq.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="faq.php?selected_menu=faq">View Faq</a></td>
                          </tr>
                      </table></td>
                    </tr>
                </table>
				</div>				</td>
              </tr>
            </table></td>
          </tr>
		  <tr>
          </tr>
		
          <tr>
            <td align="left" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" valign="middle"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                     <td align="center" valign="middle" class="left-box-text-heading-bg"><table width="167" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="left" valign="middle"><a href="javascript:ShowMenu('social.php','social');" class="heading-text-a">Social Link Manager</a></td>
                        <td width="13" align="right" valign="middle"><a href="javascript:ShowMenu('social.php','social');"><img src="images/<?php if($_REQUEST['selected_menu']=='social') echo 'up-arrow.jpg'; else echo 'down-arrow.jpg';?>" width="13" height="12"  alt="" title="" border="0"/></a></td>
                      </tr>
                    </table></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top">
				<div id="news" <?php if($_REQUEST['selected_menu']=='social') echo 'style="display:block;"'; else echo 'style="display:none;"';?>>
				<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='social.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="social.php?selected_menu=social">Social Link</a></td>
                          </tr>
                      </table></td>
                    </tr>
                </table>
				</div>				</td>
              </tr>
            </table></td>
          </tr>
		  
        
		  <tr>
            <td align="left" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" valign="middle"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                     <td align="center" valign="middle" class="left-box-text-heading-bg"><table width="167" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="left" valign="middle"><a href="javascript:ShowMenu('autoresponders.php','autoresponders');" class="heading-text-a">Autoresponders</a></td>
                        <td width="13" align="right" valign="middle"><a href="javascript:ShowMenu('autoresponders.php','autoresponders');"><img src="images/<?php if($_REQUEST['selected_menu']=='autoresponders') echo 'up-arrow.jpg'; else echo 'down-arrow.jpg';?>" width="13" height="12"  alt="" title="" border="0"/></a></td>
                      </tr>
                    </table></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top">
				<div id="news" <?php if($_REQUEST['selected_menu']=='autoresponders') echo 'style="display:block;"'; else echo 'style="display:none;"';?>>
				<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='autoresponders.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="autoresponders.php?selected_menu=autoresponders">Autoresponders</a></td>
                          </tr>
                      </table></td>
                    </tr>
                </table>
				</div>				</td>
              </tr>
            </table></td>
          </tr>
          
		  <tr>
            <td align="left" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" valign="middle"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                     <td align="center" valign="middle" class="left-box-text-heading-bg"><table width="167" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="left" valign="middle"><a href="javascript:ShowMenu('demo-email.php','demoemail');" class="heading-text-a">Demo Email</a></td>
                        <td width="13" align="right" valign="middle"><a href="javascript:ShowMenu('demo-email.php','demoemail');"><img src="images/<?php if($_REQUEST['selected_menu']=='demoemail') echo 'up-arrow.jpg'; else echo 'down-arrow.jpg';?>" width="13" height="12"  alt="" title="" border="0"/></a></td>
                      </tr>
                    </table></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top">
				<div id="news" <?php if($_REQUEST['selected_menu']=='demoemail') echo 'style="display:block;"'; else echo 'style="display:none;"';?>>
				<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='demo-email.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="demo-email.php?selected_menu=demoemail">Demo Email</a></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='demo-email-details.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="demo-email-details.php?selected_menu=demoemail">Demo Email Details</a></td>
                          </tr>
                      </table></td>
                    </tr>
					
					
					<tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='executive-demo-email.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="executive-demo-email.php?selected_menu=demoemail">Executive Demo Email</a></td>
                          </tr>
                      </table></td>
                    </tr>
					
					
					<tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='executive-demo-email-details.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="executive-demo-email-details.php?selected_menu=demoemail">Executive Demo Email Details</a></td>
                          </tr>
                      </table></td>
                    </tr>
					
                        
                    <tr>
                        <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='top-a-email.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom">
                            <table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                                    <td width="159" align="left" valign="middle" class="left-box-text"><a href="top-a-email.php?selected_menu=demoemail">Demo Summary</a></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
			
                    
                    <tr>
                        <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='summary-email-details.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom">
                            <table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                                    <td width="159" align="left" valign="middle" class="left-box-text"><a href="summary-email-details.php?selected_menu=demoemail">Demo Summary Details</a></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
				
                    
                    
                    
                    
                    
                    
					
                </table>
				</div>				</td>
              </tr>
            </table></td>
          </tr>
          
           <tr>
            <td align="left" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" valign="middle"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                     <td align="center" valign="middle" class="left-box-text-heading-bg"><table width="167" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="left" valign="middle"><a href="javascript:ShowMenu('weekly-update-details.php','weeklyupdate');" class="heading-text-a">Weekly Update</a></td>
                        <td width="13" align="right" valign="middle"><a href="javascript:ShowMenu('weekly-update-details.php','weeklyupdate');"><img src="images/<?php if($_REQUEST['selected_menu']=='weeklyupdate') echo 'up-arrow.jpg'; else echo 'down-arrow.jpg';?>" width="13" height="12"  alt="" title="" border="0"/></a></td>
                      </tr>
                    </table></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top">
				<div id="news" <?php if($_REQUEST['selected_menu']=='weeklyupdate') echo 'style="display:block;"'; else echo 'style="display:none;"';?>>
				<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='weekly-update-details.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="weekly-update-details.php?selected_menu=weeklyupdate">Weekly Update Details</a></td>
                          </tr>
                      </table></td>
                    </tr>
                </table>
				</div>				</td>
              </tr>
            </table></td>
          </tr>
          
          <tr>
            <td align="left" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" valign="middle"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                     <td align="center" valign="middle" class="left-box-text-heading-bg"><table width="167" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="left" valign="middle"><a href="javascript:ShowMenu('team.php','team');" class="heading-text-a">Team Manager</a></td>
                        <td width="13" align="right" valign="middle"><a href="javascript:ShowMenu('team.php','team');"><img src="images/<?php if($_REQUEST['selected_menu']=='team') echo 'up-arrow.jpg'; else echo 'down-arrow.jpg';?>" width="13" height="12"  alt="" title="" border="0"/></a></td>
                      </tr>
                    </table></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top">
				<div id="content" <?php if($_REQUEST['selected_menu']=='team') echo 'style="display:block;"'; else echo 'style="display:none;"';?>>
				<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="center" valign="middle"<?php if(basename($_SERVER['PHP_SELF'])=='team.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="team.php?selected_menu=team">Our Team</a></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='advisors.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="advisors.php?selected_menu=team">Advisors</a></td>
                          </tr>
                      </table></td>
                    </tr>
                </table>
				</div>	</td>
              </tr>
            </table></td>
          </tr>
		  
		  <tr>
            <td align="left" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" valign="middle"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                     <td align="center" valign="middle" class="left-box-text-heading-bg"><table width="167" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="left" valign="middle"><a href="javascript:ShowMenu('page_content.php','content');" class="heading-text-a">Content Manager</a></td>
                        <td width="13" align="right" valign="middle"><a href="javascript:ShowMenu('page_content.php','content');"><img src="images/<?php if($_REQUEST['selected_menu']=='content') echo 'up-arrow.jpg'; else echo 'down-arrow.jpg';?>" width="13" height="12"  alt="" title="" border="0"/></a></td>
                      </tr>
                    </table></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top">
				<div id="content" <?php if($_REQUEST['selected_menu']=='content') echo 'style="display:block;"'; else echo 'style="display:none;"';?>>
				<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="center" valign="middle"<?php if(basename($_SERVER['PHP_SELF'])=='page_content.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="page_content.php?selected_menu=content">Page Content</a></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='metatag.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="metatag.php?selected_menu=content">Page Meta Tag</a></td>
                          </tr>
                      </table></td>
                    </tr>
                </table>
				</div>				</td>
              </tr>
            </table></td>
          </tr>
		 
          <tr>
            <td align="left" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" valign="middle"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                     <td align="center" valign="middle" class="left-box-text-heading-bg"><table width="167" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="left" valign="middle"><a href="javascript:ShowMenu('white-paper.php','others');" class="heading-text-a">Others Manager</a></td>
                        <td width="13" align="right" valign="middle"><a href="javascript:ShowMenu('white-paper.php','others');"><img src="images/<?php if($_REQUEST['selected_menu']=='others') echo 'up-arrow.jpg'; else echo 'down-arrow.jpg';?>" width="13" height="12"  alt="" title="" border="0"/></a></td>
                      </tr>
                    </table></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top">
				<div id="content" <?php if($_REQUEST['selected_menu']=='others') echo 'style="display:block;"'; else echo 'style="display:none;"';?>>
				<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="center" valign="middle"<?php if(basename($_SERVER['PHP_SELF'])=='white-paper.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="white-paper.php?selected_menu=others">White Paper</a></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='slider-show.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="slider-show.php?selected_menu=others">Slider Show</a></td>
                          </tr>
                      </table></td>
                    </tr>
					 <tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='potential-clients.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="potential-clients.php?selected_menu=others">Potential Clients</a></td>
                          </tr>
                      </table></td>
                    </tr>
					<tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='management-change.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="management-change.php?selected_menu=others">Management Change</a></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='revenue-size.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="revenue-size.php?selected_menu=others">Size of Revenue</a></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='emp-size.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="emp-size.php?selected_menu=others">Employee Size</a></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='title.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="title.php?selected_menu=others">Title</a></td>
                          </tr>
                      </table></td>
                    </tr>
					 <tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='source.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="source.php?selected_menu=others">Source</a></td>
                          </tr>
                      </table></td>
                    </tr>
					<tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='countries.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="countries.php?selected_menu=others">Countries</a></td>
                          </tr>
                      </table></td>
                    </tr>
					<tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='state.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="state.php?selected_menu=others">State</a></td>
                          </tr>
                      </table></td>
                    </tr>
					<tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='logo.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="logo.php?selected_menu=others">Logo</a></td>
                          </tr>
                      </table></td>
                    </tr>
					<tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='landing-page.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="landing-page.php?selected_menu=others">Landing Page</a></td>
                          </tr>
                      </table></td>
                    </tr>
					<tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='backup.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="backup.php?selected_menu=others">Backup</a></td>
                          </tr>
                      </table></td>
                    </tr>
					<tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='sign-up-popup.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="sign-up-popup.php?selected_menu=others">Sign Up Pop Up</a></td>
                          </tr>
                      </table></td>
                    </tr>
                </table>
				</div></td>
              </tr>
            </table></td>
          </tr>
        
          <tr>
            <td align="left" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" valign="middle"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                     <td align="center" valign="middle" class="left-box-text-heading-bg"><table width="167" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="left" valign="middle"><a href="javascript:ShowMenu('user-advance-search.php','search&action=SearchUser');" class="heading-text-a">Adv. Search Manager</a></td>
                        <td width="13" align="right" valign="middle"><a href="javascript:ShowMenu('user-advance-search.php','search&action=SearchUser');"><img src="images/<?php if($_REQUEST['selected_menu']=='search') echo 'up-arrow.jpg'; else echo 'down-arrow.jpg';?>" width="13" height="12"  alt="" title="" border="0"/></a></td>
                      </tr>
                    </table></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top">
				<div id="news" <?php if($_REQUEST['selected_menu']=='search') echo 'style="display:block;"'; else echo 'style="display:none;"';?>>
				<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='user-advance-search.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="user-advance-search.php?action=SearchUser&selected_menu=search">User Search Information</a></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td align="center" valign="middle" <?php if(basename($_SERVER['PHP_SELF'])=='visitors-advance-search.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                            <td width="159" align="left" valign="middle" class="left-box-text"><a href="visitors-advance-search.php?action=SearchUser&selected_menu=search">Visitors Search Information</a></td>
                          </tr>
                      </table></td>
                    </tr>
                </table>
				</div>				</td>
              </tr>
            </table></td>
          </tr>
          
          <tr>
            <td align="left" valign="top">
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="center" valign="middle">
                    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                         <td align="center" valign="middle" class="left-box-text-heading-bg">
                             <table width="167" border="0" align="center" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td align="left" valign="middle"><a href="javascript:ShowMenu('staff.php','staff');" class="heading-text-a">Staff Manager</a></td>
                                    <td width="13" align="right" valign="middle"><img src="images/<?php if($_REQUEST['selected_menu']=='staff') echo 'up-arrow.jpg'; else echo 'down-arrow.jpg';?>" width="13" height="12"  alt="" title="" onclick="ShowMenu('staff.php','staff');" /></td>
                                  </tr>
                              </table>
                            </td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">
                    <div id="staff" <?php if($_REQUEST['selected_menu']=='staff') echo 'style="display:block;"'; else echo 'style="display:none;"';?>>
                    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td align="center" valign="middle"<?php if(basename($_SERVER['PHP_SELF'])=='staff.php') echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                                <td width="159" align="left" valign="middle" class="left-box-text"><a href="staff.php?selected_menu=staff">Staff</a></td>
                              </tr>
                          </table></td>
                        </tr>
                    </table>
                    </div>
                    </td>
                  </tr>
                </table>
            </td>
          </tr>
		  
		  
		  
		  <!-- Invoice link starts-->
		  
		  <tr>
            <td align="left" valign="top">
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="center" valign="middle">
                    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                         <td align="center" valign="middle" class="left-box-text-heading-bg">
                             <table width="167" border="0" align="center" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td align="left" valign="middle"><a href="javascript:ShowMenu('invoice-static-settings.php','invoice&action=edit');" class="heading-text-a">Invoices</a></td>
                                    <td width="13" align="right" valign="middle"><img src="images/<?php if($_REQUEST['selected_menu']=='invoice') echo 'up-arrow.jpg'; else echo 'down-arrow.jpg';?>" width="13" height="12"  alt="" title="" onclick="ShowMenu('invoice-static-settings.php','invoice');" /></td>
                                  </tr>
                              </table>
                            </td>
                        </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">
                    <div id="invoice" <?php if($_REQUEST['selected_menu']=='invoice') echo 'style="display:block;"'; else echo 'style="display:none;"';?>>
                    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td align="center" valign="middle"<?php if(basename($_SERVER['PHP_SELF'])=='invoice-settings.php' || strpos($_SERVER['PHP_SELF'],'invoice-settings.php?selected_menu=invoice&p=1&iID') > -1) echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom"><table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                                <td width="159" align="left" valign="middle" class="left-box-text"><a href="invoice-settings.php?selected_menu=invoice">User Invoices</a></td>
                              </tr>
                          </table></td>
                        </tr>
                    </table>
                    </div>
                    </td>
                  </tr>
                </table>
            </td>
          </tr>
		  
		  <!-- Invoice link ends-->
		  
		  
        <!-- Profiles link starts-->
        <tr>
            <td align="left" valign="top">
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" valign="middle">
                            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" valign="middle" class="left-box-text-heading-bg">
                                        <table width="167" border="0" align="center" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td align="left" valign="middle"><a href="javascript:ShowMenu('profiles.php','profile');" class="heading-text-a">Profiles</a></td>
                                                <td width="13" align="right" valign="middle"><img src="images/<?php if($_REQUEST['selected_menu']=='profile') echo 'up-arrow.jpg'; else echo 'down-arrow.jpg';?>" width="13" height="12"  alt="" title="" onclick="ShowMenu('profiles.php','profile');" /></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top">
                            <div id="invoice" <?php if($_REQUEST['selected_menu']=='profile') echo 'style="display:block;"'; else echo 'style="display:none;"';?>>
                                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td align="center" valign="middle"<?php if(basename($_SERVER['PHP_SELF'])=='email-log.php' || strpos($_SERVER['PHP_SELF'],'email-log.php?selected_menu=profile&p=1&iID') > -1) echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom">
                                            <table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                                                    <td width="159" align="left" valign="middle" class="left-box-text"><a href="email-log.php?selected_menu=profile">Email Log</a></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>          
                  
                  
                  
                  
                  
          
		  <?PHP }elseif($_SESSION['login_access_type']=='User'){ ?>
          <tr>
            <td align="left" valign="top">
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <?php 
				  $main_menu=1;
				  $menuQuery = "select mm.* from ".TABLE_USER_MENU_ALLOW." uma, ".TABLE_MAIN_MENU." mm where mm.mm_id=uma.mm_id and uma.user_id='".$_SESSION['login_id']."' order by mm.sort";
				  $menuResult = com_db_query($menuQuery);
				  while($menuRow = com_db_fetch_array($menuResult)){
				  ?>
                  <tr>
                    <td align="center" valign="middle">
                    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                         <td align="center" valign="middle" <?PHP if($main_menu==1){echo 'class="left"';}else{echo 'class="left-box-text-heading-bg"';} ?>>
                             <table width="167" border="0" align="center" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td align="left" valign="middle"><a href="javascript:ShowMenu('<?=$menuRow['page_name']?>','<?=$menuRow['group_name']?>');" class="heading-text-a"><?=$menuRow['mm_name']?></a></td>
                                    <td width="13" align="right" valign="middle"><img src="images/<?php if($_REQUEST['selected_menu']==$menuRow['group_name']) echo 'up-arrow.jpg'; else echo 'down-arrow.jpg';?>" width="13" height="12"  alt="" title="" onclick="ShowMenu('<?=$menuRow['page_name']?>','<?=$menuRow['group_name']?>');" /></td>
                                  </tr>
                              </table>
                            </td>
                        </tr>
                    </table></td>
                  </tr>
                  
                  <tr>
                    <td align="left" valign="top">
                    <div <?php if($_REQUEST['selected_menu']==$menuRow['group_name']) echo 'style="display:block;"'; else echo 'style="display:none;"';?>>
                    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                      <?php 
					  $submenuQuery = "select sm.* from ".TABLE_USER_SUB_MENU_ALLOW." usma, ".TABLE_SUB_MENU." sm where (sm.mm_id=usma.mm_id and usma.sm_id=sm.sm_id) and usma.user_id='".$_SESSION['login_id']."' and usma.mm_id='".$menuRow['mm_id']."'";
					  $submenuResult = com_db_query($submenuQuery);
					  while($smRow = com_db_fetch_array($submenuResult)){
					  ?>
                        <tr>
                          <td align="center" valign="middle"<?php if(basename($_SERVER['PHP_SELF'])==$smRow['page_name']) echo 'bgcolor="#f1f7fb"'; else echo 'bgcolor="#eeeeee"';?> class="white-border-bottom">
                              <table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td width="11" align="left" valign="middle"><img src="images/arrow.gif" width="3" height="6"  alt="" title=""/></td>
                                    <td width="159" align="left" valign="middle" class="left-box-text"><a href="<?=$smRow['page_name']?>?selected_menu=<?=$menuRow['group_name']?>"><?=$smRow['sm_name']?></a></td>
                                  </tr>
                              </table>
                          </td>
                        </tr>
                      <?PHP } ?>  
                    </table>
                    </div>
                    </td>
                  </tr>
                 <?PHP $main_menu++;
				 } ?>
                </table>
            </td>
          </tr>
          <?PHP } ?>
       
		  <tr>
            <td align="left" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" valign="middle"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                     <td align="center" valign="middle" class="left-box-text-heading-bg"><table width="167" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="left" valign="middle"><a href="javascript:ShowMenu('logout.php','logout');" class="heading-text-a">Log Out</a></td>
                        <td width="13" align="right" valign="middle"><a href="javascript:ShowMenu('logout.php','logout');"><img src="images/<?php if($_REQUEST['selected_menu']=='logout') echo 'up-arrow.jpg'; else echo 'down-arrow.jpg';?>" width="13" height="12"  alt="" title="" border="0"/></a></td>
                      </tr>
                    </table></td>
                    </tr>
                </table></td>
              </tr>
              
            </table></td>
         </tr>
		  
  </table></td>