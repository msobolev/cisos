<?php
include("includes/include-top.php");
$action = $_REQUEST['action'];
$uID = $_SESSION['sess_user_id'];
$msg = $_REQUEST['msg'];
include(DIR_INCLUDES."header-content-page.php");

//$invoices_query = com_db_query("select * from " . TABLE_INVOICES . " where user_id='".$_SESSION['sess_user_id']."'");
//$invoices_num_rows=com_db_num_rows($invoices_query);

$user_invoices = this_user_invoices();
//echo "<pre>user_invoices: ";   print_r($user_invoices);   echo "</pre>";
?>	 
    <!-- heading start -->
 <div style="margin:0 auto; width:960px;">
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	 <tr>
        <td colspan="2" align="left" valign="top" class="caption-text">
		<? //=com_db_GetValue("select page_content from " .TABLE_PAGE_CONTENT . " where page_name='index.php' and page_title='Page Heading'")?>
		</td>
    </tr>
    <tr><td colspan="2">&nbsp;</td></tr>
	
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
          <td align="left" valign="middle" class="my-profile-page-title-text"><strong><a href="<?=HTTP_SERVER?>my-profile.php">My Profile</a></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=HTTP_SERVER?>my-subscription.php">My Subscription&nbsp;</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=HTTP_SERVER?>my-alert.php">My Alerts</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=HTTP_SERVER?>alert.php">Add New Alert</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=HTTP_SERVER?>my-change-password.php">Change Password</a>
		  <?PHP
		  $user_invoices = this_user_invoices();
		  if(sizeof($user_invoices) > 0)
		  {	 
		  ?>
		  &nbsp;&nbsp;&nbsp;<strong>&nbsp;<a href="<?=HTTP_SERVER?>my-invoices.php">Invoices</a></strong>
		  <?PHP
		  }
		  ?>
		 </td>
        </tr>
      </table></td>
      </tr>
	    <tr>
      <td align="left" valign="top" class="registration-page-bg"><img src="images/change-password-blue-down-arrow.jpg" width="502" height="21"  alt="" title="" /></td>
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
          <td align="center" valign="top" class="mgs-successfull-text"><strong><?=$msg;?>&nbsp;</strong></td>
        </tr>
        <tr>
          <td align="center" valign="top"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="114" align="left" valign="top">&nbsp;</td>
			  <td align="left" valign="top">
			  	 
				  	 
					 <table width="500" border="0" align="left" cellpadding="0" cellspacing="0">
					<?PHP	
					 //if($invoices_num_rows>0) 
					//{
					//	while ($invoices_rows = com_db_fetch_array($invoices_query)) 
					//	{
					if(sizeof($user_invoices) > 0)
					{
                                            $sequence = 0;
                                            for($j=0;$j<sizeof($user_invoices);$j++)
                                            {
                                                /*
                                                if($user_invoices[$j] != '')
                                                {

                                                        $time=strtotime($user_invoices[$j]);
                                                        $month=date("M",$time);
                                                        $year=date("Y",$time);
                                                        $month_d=date("m",$time);

                                                ?>
                                                    <tr>
                                                      <td height="41" align="left" valign="top" class="content-text">
                                                            <a href="<?=HTTP_SERVER?>my-invoice.php?month=<?=$month?>&month_d=<?=$month_d?>&year=<?=$year?>&sequence=<?=$sequence?>">Invoice for <?=$user_invoices[$j]?></a>
                                                      </td>
                                                    </tr>
                                                <?PHP	
                                                        $sequence++;
                                                }
                                                 */

                                            ?>
                                            <tr>
                                                <td height="41" align="left" valign="top" class="content-text">
                                                   <!-- <a href="<?=HTTP_SERVER?>my-invoice.php?month=<?=$month?>&month_d=<?=$month_d?>&year=<?=$year?>&sequence=<?=$sequence?>">Invoice for <?=$user_invoices[$j]?></a> -->
                                                    <a target="_blank" href="<?="vsword/invoices/".$_SESSION['sess_user_id']."_".$user_invoices[$j].".pdf"?>">Invoice for <?=$user_invoices[$j]?></a>
                                             </td>
                                           </tr>
                                            <?PHP


                                            }
					}
					?>
						
						<tr>
						  <td height="41" align="left" valign="middle">&nbsp;</td>
						  <td height="41" align="left" valign="middle"></td>
						</tr>
					  </table>
			    
					 
			  </td>
            </tr>
            <tr>
              <td width="114" align="left" valign="top">&nbsp;</td>
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