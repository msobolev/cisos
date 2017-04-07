<?php
include("includes/include-top.php");
$news_sql=com_db_query("select * from " . TABLE_NEWS . " where status = '0'");
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
        <td align="left" valign="top" class="header-nav"><a href="<?=HTTP_SERVER?>index.html">Home</a>  /  <a href="<?=HTTP_SERVER?>press-news.html" class="active"><?=$PageTitle;?></a></td>
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
          <td align="center" valign="top"><table width="860" border="0" align="center" cellpadding="0" cellspacing="0">
            <?php
			$i=1;
			while($data_news=com_db_fetch_array($news_sql)){
			$data=explode("-",$data_news['add_date']);
			?><tr>
              <td width="599" align="left" valign="middle" class="content-text"><?php echo $data[1] . '/' . $data[2] . '/' . $data[0] . '  ' . com_db_output($data_news['news_title']);?> </td>
              <td width="261" align="left" valign="top">
				 <div id="more_<?=$i?>" style="display:block">
				  <table width="100" border="0" align="left" cellpadding="0" cellspacing="0">
				   <tr>
					<td align="center" valign="top" class="more_bottom">
					<a href="javascript:Show_News('news_<?php echo $i?>','less_<?=$i?>','more_<?=$i?>');">More<img src="images/white-arrow.gif" width="12" height="9" alt="" title="" border="0"/></a>
					</td>
				   </tr>
				 </table>
				 </div>
				
				 <div id="less_<?=$i?>" style="display:none">
				  <table width="100" border="0" align="left" cellpadding="0" cellspacing="0">
				   <tr>
					<td align="center" valign="top" class="less_buttn">
					<a href="javascript:Hide_News('news_<?php echo $i?>','less_<?=$i?>','more_<?=$i?>');"><img src="images/white-back-arrow.gif" width="12" height="9" alt="" title="" border="0" />&nbsp;Less</a>
					</td>
				   </tr>
				 </table>
				 </div>
			 </td>
            </tr>
            
			<tr>
              <td align="left" valign="middle" class="content-text" colspan="2"><div id="news_<?php echo $i?>" style="display:none;"><?php echo com_db_output($data_news['news_details']);?></div></td>
            </tr>
			
            <tr>
              <td align="left" valign="middle" class="content-text">&nbsp;</td>
              <td align="left" valign="top">&nbsp;</td>
            </tr>
			
           <?php
		   $i++;
		   }
		   ?> 
		  
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