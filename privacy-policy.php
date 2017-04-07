<?php
include("includes/include-top.php");
$page_content = com_db_output(com_db_GetValue("select page_content from " . TABLE_PAGE_CONTENT . " where page_name='".$current_page."'"));
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
    <tr><td colspan="2">&nbsp;</td></tr	 
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
      <td align="left" valign="top"><img src="images/blue-down-arrow.gif" width="235" height="13"  alt="" title="" /></td>
      </tr>	  

      </table></td>
      <td align="left"  valign="top">&nbsp;</td>
    </tr>
    <!-- heading end -->
    <!-- content start -->
    <tr>
        <td width="21" align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top">
            <table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" valign="top">
                   <table width="928" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                       <td align="left" valign="top"><?=$page_content?></td>
                      </tr>
                   </table>
                </td>
              </tr>
            </table>
        </td>
        <td width="21" align="left" valign="top">&nbsp;</td>
     </tr>
  	<tr><td colspan="2">&nbsp;</td></tr>
 </table>
    </div>
    <!-- content end-->
<?php      
include(DIR_INCLUDES."footer-content-page.php");
?>