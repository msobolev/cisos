<?php
include("includes/include-top.php");
$page_content = com_db_output(com_db_GetValue("select page_content from " . TABLE_PAGE_CONTENT . " where page_name='".$current_page."'"));

$disable_page = 1;
if($disable_page == 0)
{
	$list_query = "select mm.movement_url,pm.first_name,pm.last_name from " . TABLE_MOVEMENT_MASTER . " mm, ".TABLE_PERSONAL_MASTER." pm where mm.personal_id=pm.personal_id order by last_name";

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
      <td align="left"  valign="top">&nbsp;</td>
      <td align="center" valign="top" class="registration-page-bg"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td align="center" valign="top"><table width="928" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td align="left" valign="top"  class="directry-heading-caption-text"><strong>Our complete list of business professionals is coming soon.<? //=$page_content?></strong><br /><br /></td>
            </tr>
            <tr>
              <td align="left" valign="top">&nbsp;</td>
            </tr>
			
			
			<?PHP
			if($disable_page == 0)
			{
			?>
			
            <tr>
              <td align="left" valign="top">
			  <div  class="directry-link-text-new">
			  <ul>
				 <? 
				  if($list_of_number > 0 ){
						while($list_row = com_db_fetch_array($list_result)){
							$dim_url = $list_row['movement_url'];
							echo '<li><a href="'.HTTP_SERVER.$dim_url.'">'.com_db_output($list_row['last_name']).' '.com_db_output($list_row['first_name']).'</a></li>';
						}
					}
				  ?> 
				</ul>
			 </div>
			  </td>
            </tr>
			
			<?PHP
			}
			?>
			
			
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