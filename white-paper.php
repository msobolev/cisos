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
    <tr>
      <td align="left"  valign="top">&nbsp;</td>
      <td align="left" valign="top"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
	       <tr>
        <td align="left" valign="top" class="header-nav"><a href="<?=HTTP_SERVER?>index.php">Home</a>  /  <a href="#" class="active">Whitepapers </a></td>
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
          <td align="left" valign="middle" class="registration-page-title-text">Whitepapers </td>
        </tr>
      </table></td>
      </tr>
	     <tr>
      <td align="left" valign="top"><img src="images/blue-down-arrow.jpg" width="235" height="13"  alt="" title="" /></td>
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
		  
			  <table width="860" border="0" align="center" cellpadding="0" cellspacing="0">
				 <?php 
				  $download_result = com_db_query("select * from " . TABLE_WHITE_PAPER . " where status='0'");
				  while($download_row = com_db_fetch_array($download_result)){
				  ?>
				<tr>
				  <td width="408" height="34" align="left" valign="middle" class="content-text"><a href="white_paper/<?=$download_row['download_path']?>" rel="nofollow"><u><?=$download_row['paper_name'];?></u></a></td>
				  <td width="452" align="left" valign="top">
					  <table width="106" border="0" align="left" cellpadding="0" cellspacing="0">
						<tr>
						  <td align="center" valign="top" class="download_bottom"><a href="<?=HTTP_SERVER?>download.php?id=<?=$download_row['paper_id']?>&type=wp">DOWNLOAD</a></td>
						</tr>
					  </table>
				    </td>
				</tr>
				<tr>
				  <td align="left" valign="middle" class="content-text">&nbsp;</td>
				  <td align="left" valign="top" class="content-text">&nbsp;</td>
				</tr>
				<?PHP } ?>
				
			  </table>
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