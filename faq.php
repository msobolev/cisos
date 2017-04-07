<?php
include("includes/include-top.php");
$faq_sql=com_db_query("select * from " . TABLE_FAQ . " where status = '0'");
$faq_sql1=com_db_query("select * from " . TABLE_FAQ . " where status = '0'");

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
      <td align="left" valign="top">
          <table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
             <tr>
                <td align="left" valign="top" class="header-nav"><a href="<?=HTTP_SERVER?>index.html">Home</a>  /  <a href="#" class="active"><?=$PageTitle;?></a></td>
             </tr>
             <tr>
                <td align="left" valign="top"><img src="images/specer.gif" width="1" height="10" alt="" title="" /></td>
              </tr>
              <tr>
                  <td align="left" valign="middle" class="registration-page-heading-bg">
                      <table width="960" border="0" align="left" cellpadding="0" cellspacing="0">
                        <tr>
                          <td>&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="registration-page-title-text"><?=$PageTitle;?></td>
                        </tr>
                      </table>
                   </td>
              </tr>
              <tr>
                <td align="left" valign="top" class="registration-page-bg"><img src="images/blue-down-arrow.jpg" width="235" height="13"  alt="" title="" /></td>
              </tr>
          </table>
      </td>
      <td align="left"  valign="top">&nbsp;</td>
    </tr>
    <!-- heading end -->
    <!-- content start -->
    <tr>
    <td width="21" align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top" class="registration-page-bg">
    <table width="928" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="left" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td align="left" valign="top" class="faq-link-text" style="padding-left:35px;">
            <ol>
              <?php
                $i=1;
                 while($dataFaq=com_db_fetch_array($faq_sql)){
                ?>
                 <li><a href="#faq<?=$i?>"><?=com_db_output($dataFaq['question'])?></a></li>
                <?php
                 $i++;
                 }
                ?>
              </ol>
          </td>
      </tr>
      <tr>
        <td align="center" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td align="left" valign="top" class="faq-content-text">
			<?php
				$l=1;
				 while($data=com_db_fetch_array($faq_sql1)){
				 ?>
				 <p><strong><?=$l?>. <?=com_db_output($data['question'])?><a name="faq<?=$l?>" id="faq<?=$l?>"></a></strong></p>
				 <p><?=com_db_output($data['answer'])?></p>
				 <?php
				 $l++;
				 }
			?>		</td>
      	 </tr>
	     <tr>
	       <td align="center" valign="top">&nbsp;</td>
         </tr>
	     <tr>
	       <td align="center" valign="top"><table width="620" border="0" align="left" cellpadding="0" cellspacing="0">
             <tr>
               <td align="left" valign="middle" class="faq-ask-bg"><table width="620" border="0" align="left" cellpadding="0" cellspacing="0">
                 <tr>
                   <td width="364" align="left" valign="middle">Didn&rsquo;t find an answer you were looking for?</td>
                   <td width="256" align="left" valign="middle"><table width="106" border="0" align="left" cellpadding="0" cellspacing="0">
                       <tr>
                         <td align="center" valign="top" class="ask_buttn"><a href="<?=HTTP_SERVER?>contact-us.php">Ask us<img src="images/white-arrow.gif" width="12" height="9" alt=""  title="" border="0"/></a></td>
                       </tr>
                   </table></td>
                 </tr>

               </table></td>
             </tr>
           </table></td>
      	 </tr>
	     <tr>
        	<td align="center" valign="top">&nbsp;</td>
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