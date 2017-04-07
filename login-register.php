<?php
include("includes/include-top.php");
$fpaction = $_REQUEST['fpaction'];

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
        <!-- content start -->
        <tr>
            <td align="left"  valign="top">&nbsp;</td>
            <td align="center" valign="top">
                <table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center" valign="top">
                        <table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="left" valign="middle" class="advance-search-page-heading-bg">
                                    <table width="960" border="0" align="left" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td>&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td align="left" valign="middle" class="forgot-password-title-text">Login or Register</td>
                                        </tr>

                                        <tr>
                                            <td align="center" valign="middle">&nbsp;</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="center" valign="top" class="registration-page-bg">

                        <table width="675" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="left" valign="top"><img src="images/specer.gif" width="1" height="30" alt="" title="" /></td>
                            </tr>
                            <tr>
                                <td align="left" valign="top" class="forgot-password-box-text"><p>Please <a href="<?=HTTP_SERVER?>provide-contact-information.php">signup</a> or <a href="<?=HTTP_SERVER?>login.php">login</a> for search</p></td>
                            </tr>

                            <tr>
                                <td align="left" valign="top"><img src="images/specer.gif" width="1" height="60" alt="" title="" /></td>
                            </tr>

                            <tr>
                                <td align="center" valign="top">&nbsp;</td>
                            </tr>
                          </table>

                      </td>
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