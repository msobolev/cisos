<?php
include("includes/include-top.php");

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
        <td align="left" valign="top" class="header-nav"><a href="<?=HTTP_SERVER?>index.html">Home</a>  /  <a href="#" class="active"><?=$PageTitle;?></a></td>
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
    <td width="21" align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top" class="registration-page-bg"><table width="928" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="left" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td align="left" valign="top" class="faq-link-text">&nbsp;</td>
      </tr>
      <tr>
        <td align="left" valign="top" class="sitemap-link-text"><a href="<?=HTTP_SERVER?>index.html">Home</a></td>
      </tr>
      <tr>
        <td align="left" valign="top"  class="sitemap-link-text"><table width="475" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="39" align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top"><table width="300" border="0" align="left" cellpadding="0" cellspacing="0">
              <tr>
                <td align="left" valign="top"><table width="300" border="0" align="left" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="19" align="left" valign="top"><img src="images/box-icon.gif" width="15" height="22" alt="" title="" /></td>
                    <td align="left" valign="top">Search</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top"><table width="300" border="0" align="left" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="47" align="left" valign="top"><img src="images/line-box-icon1.gif" width="43" height="27" alt="" title="" /></td>
                    <td width="240" align="left" valign="top"><a href="<?=HTTP_SERVER?>advance-search.php">Advanced Search</a></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top"><table width="300" border="0" align="left" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="19" align="left" valign="top"><img src="images/box-icon.gif" width="15" height="22" alt="" title="" /></td>
                    <td align="left" valign="top">Browse</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top"><table width="300" border="0" align="left" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><img src="images/line-box-icon.gif" width="43" height="24" alt="" title="" /></td>
                    <td align="left" valign="top"><a href="<?=HTTP_SERVER?>browse-more.php?type=Industry">By Industry</a></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><img src="images/line-box-icon.gif" width="43" height="24" alt="" title="" /></td>
                    <td align="left" valign="top"><a href="<?=HTTP_SERVER?>browse-more.php?type=Title">By Title</a></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><img src="images/line-box-icon.gif" width="43" height="24" alt="" title="" /></td>
                    <td align="left" valign="top"><a href="<?=HTTP_SERVER?>browse-more.php?type=TimePeriod">By Date</a></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><img src="images/line-box-icon.gif" width="43" height="24" alt="" title="" /></td>
                    <td align="left" valign="top"><a href="<?=HTTP_SERVER?>browse-more.php?type=Employee">By Size (employees)</a></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><img src="images/line-box-icon.gif" width="43" height="24" alt="" title="" /></td>
                    <td align="left" valign="top"><a href="<?=HTTP_SERVER?>browse-more.php?type=Revenue">By Size ($revenue)</a></td>
                  </tr>
                  <tr>
                    <td width="47" align="left" valign="top"><img src="images/line-box-icon1.gif" width="43" height="27" alt="" title="" /></td>
                    <td width="240" align="left" valign="top"><a href="<?=HTTP_SERVER?>browse-more.php?type=Geography">By Geography </a></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top"><table width="300" border="0" align="left" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="19" align="left" valign="top"><img src="images/blue-box-icon.gif" width="15" height="24" alt="" title="" /></td>
                    <td align="left" valign="top"><a href="<?=HTTP_SERVER?>alert.php">Alerts</a></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top"><table width="300" border="0" align="left" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="19" align="left" valign="top"><img src="images/box-icon.gif" width="15" height="22" alt="" title="" /></td>
                    <td align="left" valign="top">About Us </td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top"><table width="300" border="0" align="left" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><img src="images/line-box-icon.gif" width="43" height="24" alt="" title="" /></td>
                    <td align="left" valign="top"><a href="<?=HTTP_SERVER?>team.html">Team</a></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><img src="images/line-box-icon.gif" width="43" height="24" alt="" title="" /></td>
                    <td align="left" valign="top"><a href="<?=HTTP_SERVER?>why-cto.html">Why CTOsOnTheMove?</a></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><img src="images/line-box-icon.gif" width="43" height="24" alt="" title="" /></td>
                    <td align="left" valign="top"><a href="<?=HTTP_SERVER?>partners.html">Partners</a></td>
                  </tr>
                  <tr>
                    <td width="47" align="left" valign="top"><img src="images/line-box-icon1.gif" width="43" height="27" alt="" title="" /></td>
                    <td width="240" align="left" valign="top"><a href="<?=HTTP_SERVER?>press-news.html">News/Press</a></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top"><table width="300" border="0" align="left" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="19" align="left" valign="top"><img src="images/box-icon.gif" width="15" height="22" alt="" title="" /></td>
                    <td align="left" valign="top">Legal </td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top"><table width="300" border="0" align="left" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><img src="images/line-box-icon.gif" width="43" height="24" alt="" title="" /></td>
                    <td align="left" valign="top"><a href="<?=HTTP_SERVER?>copyright-policy.html">Copyright</a></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><img src="images/line-box-icon.gif" width="43" height="24" alt="" title="" /></td>
                    <td align="left" valign="top"><a href="<?=HTTP_SERVER?>terms-use.html">Terms of Use</a></td>
                  </tr>

                  <tr>
                    <td width="47" align="left" valign="top"><img src="images/line-box-icon1.gif" width="43" height="27" alt="" title="" /></td>
                    <td width="240" align="left" valign="top"> <a href="<?=HTTP_SERVER?>privacy-policy.html">Privacy Policy</a></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top"><table width="300" border="0" align="left" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="19" align="left" valign="top"><img src="images/box-icon.gif" width="15" height="22" alt="" title="" /></td>
                    <td align="left" valign="top">Help</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top"><table width="300" border="0" align="left" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><img src="images/line-box-icon.gif" width="43" height="24" alt="" title="" /></td>
                    <td align="left" valign="top"><a href="<?=HTTP_SERVER?>faq.html">FAQ</a></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><img src="images/line-box-icon.gif" width="43" height="24" alt="" title="" /></td>
                    <td align="left" valign="top"><a href="<?=HTTP_SERVER?>pricing.html">Pricing</a></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><img src="images/line-box-icon.gif" width="43" height="24" alt="" title="" /></td>
                    <td align="left" valign="top"><a href="<?=HTTP_SERVER?>contact-us.html">Contact Us</a></td>
                  </tr>
                  <tr>
                    <td width="47" align="left" valign="top"><img src="images/line-box-icon1.gif" width="43" height="27" alt="" title="" /></td>
                    <td width="240" align="left" valign="top"> <a href="<?=HTTP_SERVER?>site-map.html">Sitemap</a></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top"><table width="300" border="0" align="left" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="19" align="left" valign="top"><img src="images/box-icon.gif" width="15" height="22" alt="" title="" /></td>
                    <td align="left" valign="top">More Info</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top"><table width="300" border="0" align="left" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><img src="images/line-box-icon.gif" width="43" height="24" alt="" title="" /></td>
                    <td align="left" valign="top"><a href="#">Blog</a></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><img src="images/line-box-icon.gif" width="43" height="24" alt="" title="" /></td>
                    <td align="left" valign="top"><a href="<?=com_db_GetValue("select social_url from " .TABLE_SOCIAL_LINK . " where social_name='Twitter'");?>">Follow on Twitter</a></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><img src="images/line-box-icon.gif" width="43" height="24" alt="" title="" /></td>
                    <td align="left" valign="top"><a href="<?=com_db_GetValue("select social_url from " .TABLE_SOCIAL_LINK . " where social_name='Linkedin'");?>">Connect on LinkedIn</a></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><img src="images/line-box-icon.gif" width="43" height="24" alt="" title="" /></td>
                    <td align="left" valign="top"><a href="<?=com_db_GetValue("select social_url from " .TABLE_SOCIAL_LINK . " where social_name='Facebook'");?>">Connect on Facebook</a></td>
                  </tr>
                  <tr>
                    <td width="47" align="left" valign="top"><img src="images/line-box-icon1.gif" width="43" height="27" alt="" title="" /></td>
                    <td width="240" align="left" valign="top"> <a href="<?=HTTP_SERVER?>white-paper.php">Whitepapers</a></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top"><table width="300" border="0" align="left" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="19" align="left" valign="top"><img src="images/box-icon.gif" width="15" height="22" alt="" title="" /></td>
                    <td align="left" valign="top">Registration</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top"><table width="300" border="0" align="left" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><img src="images/line-box-icon.gif" width="43" height="24" alt="" title="" /></td>
                    <td align="left" valign="top"><a href="<?=HTTP_SERVER?>provide-contact-information.php">Provide Personal Information</a></td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><img src="images/line-box-icon.gif" width="43" height="24" alt="" title="" /></td>
                    <td align="left" valign="top"><a href="<?=HTTP_SERVER?>choose-subscription.php">Chose Subscription Options</a></td>
                  </tr>

                  <tr>
                    <td width="47" align="left" valign="top"><img src="images/line-box-icon1.gif" width="43" height="27" alt="" title="" /></td>
                    <td width="240" align="left" valign="top"> <a href="<?=HTTP_SERVER?>submit-payment.php">Submit Payment</a></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top"><table width="300" border="0" align="left" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="19" align="left" valign="top"><img src="images/box-icon.gif" width="15" height="22" alt="" title="" /></td>
                    <td align="left" valign="top">Login</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top"><table width="300" border="0" align="left" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="47" align="left" valign="top"><img src="images/line-box-icon1.gif" width="43" height="27" alt="" title="" /></td>
                    <td width="240" align="left" valign="top"><a href="<?=HTTP_SERVER?><? if($_SESSION['sess_is_user'] != 1){ echo 'Javascript:;';}else{echo 'my-profile.php';}?>" onclick="LoginPage();" target="top">User Profile</a></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
              <tr>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td align="left" valign="top">&nbsp;</td>
      </tr>
    </table></td>
    <td width="21" align="left" valign="top">&nbsp;</td>
  </tr>
</table>
    </div>
    <!-- content end-->
<?php      
include(DIR_INCLUDES."footer-content-page.php");
?>