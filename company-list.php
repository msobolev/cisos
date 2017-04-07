<?php
include("includes/include-top.php");
$page_content = com_db_output(com_db_GetValue("select page_content from " . TABLE_PAGE_CONTENT . " where page_name='".$current_page."'"));

$action = $_REQUEST['action'];
$char = $_REQUEST['char'];
if($action=='CName' && $char !=''){
	$list_query = "select mm.movement_url,cm.company_name,cm.company_id from " . TABLE_MOVEMENT_MASTER . " mm, ".TABLE_COMPANY_MASTER." cm where mm.company_id=cm.company_id and mm.movement_url<>'' and cm.company_name like '".$char."%'";
	$list_result = com_db_query($list_query);
	if($list_result){
		$list_of_number = com_db_num_rows($list_result);
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
    <tr><td colspan="2">&nbsp;</td></tr><!-- heading start --> 
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
      <td align="left"  valign="top">&nbsp;</td>
      <td align="center" valign="top" class="registration-page-bg"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td align="center" valign="top"><table width="928" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td align="left" valign="top"  class="directry-heading-caption-text"><strong><?=$page_content?></strong><br /><br /></td>
            </tr>
            <tr>
              <td align="left" valign="top">&nbsp;</td>
            </tr>
            <tr>
              <td align="left" valign="top">
                        <div  class="directry-link-text">
                            <ul>
                            <?PHP 
                            if($list_of_number > 0 )
                            {
                                while($list_row = com_db_fetch_array($list_result))
                                {
                                    $dim_url = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''), com_db_output($list_row['company_name'])).'_Company_'.$list_row['company_id'];
                                    echo '<li><a href="'.HTTP_SERVER.$dim_url.'">'.str_replace('&','&amp;',$list_row['company_name']).'</a></li>';
                                }
                            }
			  ?>
				</ul>
			 </div>
			  </td>
            </tr>
            <tr>
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