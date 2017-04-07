<?php
require('includes/include_top.php');
//News
$total_news = com_db_GetValue("select count(news_id) from " . TABLE_NEWS);
$total_news_active = com_db_GetValue("select count(news_id) from " . TABLE_NEWS ." where status ='0'");
$total_news_inactive = com_db_GetValue("select count(news_id) from " . TABLE_NEWS ." where status ='1'");

//FAQ
$total_faq = com_db_GetValue("select count(faq_id) from " . TABLE_FAQ);
$total_faq_active = com_db_GetValue("select count(faq_id) from " . TABLE_FAQ ." where status ='0'");
$total_faq_inactive = com_db_GetValue("select count(faq_id) from " . TABLE_FAQ ." where status ='1'");

include("includes/header.php");
?>

 <tr>
    <td align="left" valign="top" bgcolor="#FFFFFF">
	<table width="975" border="0" align="center" cellpadding="0" cellspacing="0">
       <tr>
		<?php
		include("includes/menu_left.php");
		?>
		<td width="10" align="left" valign="top">&nbsp;</td>
        <td width="769" align="center" valign="top">
        <table width="733" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="left" valign="top"><img src="images/dashboard-text.jpg" width="165" height="52"  alt="" title="" /></td>
          </tr>
          <tr>
            <td align="left" valign="top"><table width="733" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="314" align="left" valign="top">
                	<table width="314" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="center" valign="middle" class="small-box-heading-bg"><table width="280" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="18" align="left" valign="middle" class="heading-text"><img src="images/blue-down-arrow.jpg" width="12" height="7"   alt="" title="" /></td>
                            <td width="174" align="right" valign="middle" class="title-text">LATEST FAQ </td>
                            <td width="44" align="right" valign="middle"><img src="images/camera-icon.jpg" width="28" height="24"   alt="" title="" /></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td align="center" valign="top" class="small-box-border">
					  
					  <table width="280" border="0" align="center" cellpadding="4" cellspacing="0">
                          <tr>
                            <td width="144" align="left" valign="middle">&nbsp;</td>
                            <td width="120" align="left" valign="middle">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle" class="small-box-heading-text"><b>Faq inventory:</b></td>
                            <td align="left" valign="middle">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle" class="small-box-heading-text">Total:</td>
                            <td align="left" valign="middle"><?=$total_faq;?></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle" class="small-box-heading-text">Active:</td>
                            <td align="left" valign="middle"><?=$total_faq_active;?></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle" class="small-box-heading-text">Disabled:</td>
                            <td align="left" valign="middle"><?=$total_faq_inactive;?></td>
                          </tr>
                          <tr>
                            <td align="left" valign="middle"><img src="images/spacer.gif" width="1" height="22" alt="" title="" /></td>
                            <td align="left" valign="middle"><img src="images/spacer.gif" width="1" height="22" alt="" title="" /></td>
                          </tr>
                      </table>
					  
					</td>
                    </tr>
                </table>
                </td>
                <td align="left" valign="top">&nbsp;</td>
                <td width="384" align="left" valign="top"><table width="384" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="center" valign="middle" class="big-box-heading-bg"><table width="348" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td width="18" align="left" valign="middle" class="heading-text"><img src="images/blue-down-arrow.jpg" width="12" height="7"   alt="" title="" /></td>
                            <td width="174" align="right" valign="middle" class="title-text">LATEST CTOSONTHEMOVE NEWS</td>
                            <td width="44" align="right" valign="middle"><img src="images/user-icon.jpg" width="24" height="28"   alt="" title="" /></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td align="center" valign="top" class="small-box-border"><table width="350" border="0" align="center" cellpadding="4" cellspacing="0" >
                        <tr>
                          <td width="185" align="left" valign="middle">&nbsp;</td>
                          <td width="149" align="left" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="small-box-heading-text"><b>Press/News inventory:</b></td>
                          <td align="left" valign="middle" class="small-box-heading-text"><b><u></u></b></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="small-box-heading-text">Total:</td>
                          <td align="left" valign="middle" class="small-box-heading-text"><?=$total_news;?></td>
                        </tr>
                       
                        <tr>
                          <td align="left" valign="middle" class="small-box-heading-text">Active:</td>
                          <td align="left" valign="middle" class="small-box-heading-text"><?=$total_news_active;?></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="small-box-heading-text">Disabled:</td>
                          <td align="left" valign="middle" class="small-box-heading-text"><?=$total_news_inactive;?></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle">&nbsp;</td>
                          <td align="left" valign="middle">&nbsp;</td>
                        </tr>
                      </table></td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
          
        </table>
        </td>
      </tr>
    </table>
	</td>
  </tr>
<?php
include("includes/footer.php");
?>