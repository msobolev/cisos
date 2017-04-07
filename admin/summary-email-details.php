<?php
require('includes/include_top.php');

$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 20;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';

$sql_query = "select * from " . TABLE_DEMO_SUMMARY_EMAIL_INFO." order by add_date desc";

/***************** FOR PAGIN ***********************/
$starting_point = $items_per_page * ($p - 1);
/****************** END PAGIN ***********************/
$main_page = 'summary-email-details.php';

$exe_query=com_db_query($sql_query);
$num_rows=com_db_num_rows($exe_query);
$total_data = $num_rows;

/************ FOR PAGIN **************/
$sql_query .= " LIMIT $starting_point,$items_per_page";
$exe_data = com_db_query($sql_query);

$numRows = com_db_num_rows($exe_data);
/************ END ********************/

$mID = (isset($_GET['mID']) ? $_GET['mID'] : $select_data[0]);
if($action=='DemoEmailCode' || $action == 'DemoEmailShow'){
	$info_id = $_REQUEST['emailid'];
	$emailCode = com_db_output(com_db_Getvalue("select sent_email from ".TABLE_DEMO_SUMMARY_EMAIL_INFO." where info_id='".$info_id."'"));
}
if($action=='delete'){
	com_db_query("delete from " . TABLE_DEMO_SUMMARY_EMAIL_INFO . " where info_id = '" . $mID . "'");
	com_redirect("summary-email-details.php?p=" . $p . "&selected_menu=demoemail&msg=" . msg_encode("Demo Email deleted successfully"));
}
	
include("includes/header.php");
?>
<script type="text/javascript" language="javascript">
	function confirm_del(nid,p){
	var agree=confirm("Demo email will be deleted. \n Do you want to continue?");
	if (agree)
		window.location = "summary-email-details.php?selected_menu=demoemail&mID=" + nid + "&p=" + p + "&action=delete";
	else
		window.location = "summary-email-details.php?selected_menu=demoemail&mID=" + nid + "&p=" + p ;
	}
</script>
 <tr>
    <td align="left" valign="top" bgcolor="#FFFFFF">
	<table width="975" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
		<?php
		include("includes/menu_left.php");
		?>
		<td width="10" align="left" valign="top">&nbsp;</td>
        <td width="769" align="left" valign="top">

<?php if(($action == '') || $action == 'save'){	?>			

		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
          <tr>
            <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="29%" align="left" valign="middle" class="heading-text">Demo Email Details</td>
                  <td width="51%" align="left" valign="middle" class="message"><?=$msg?></td>
                  <td width="20%" align="left" valign="middle">&nbsp;</td>
                </tr>
              </table></td>
          </tr>
       
          <tr>
            <td align="left" valign="top" class="right-bar-content-border">
			<form name="topicform" action="summary-email-details.php?action=DemoEmailCreate&selected_menu=demoemail" method="post">
			<table width="100%" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="19" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-title-text">#</span></td>
				<td width="123" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Demo Email Show</span> </td>
                <td width="207" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Demo Email Code Show</span> </td>
                <td width="133" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Full Demo Email</span> </td>
                <td width="86" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Create Date</span> </td>
                <td width="55" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Action</span> </td>
			  </tr>
			<?php
			
			if($total_data>0) 
                        {
                            $i=$starting_point+1;
                            while ($data_sql = com_db_fetch_array($exe_data)) 
                            {
                                $add_date = $data_sql['add_date'];
			?>          
                            <tr>
				<td height="30" align="center" valign="middle" class="right-border-left"><?=$i;?></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><a href="summary-email-details.php?action=DemoEmailShow&selected_menu=demoemail&emailid=<?=$data_sql['info_id'];?>">Demo Email Show</a></td>
                                <td height="30" align="left" valign="middle" class="right-border-text"><a href="summary-email-details.php?action=DemoEmailCode&selected_menu=demoemail&emailid=<?=$data_sql['info_id'];?>">Demo email code copy for email</a></td>
                                <td height="30" align="left" valign="middle" class="right-border-text"><a href="<?=HTTP_SITE_URL."summary-email-show.php?emailid=".$data_sql['email_id'];?>" target="_blank">Details form website</a></td>
                                <td height="30" align="center" valign="middle" class="right-border"><?=$add_date;?></td>
                                <td height="30" align="center" valign="middle" class="right-border"><a href="#"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" title="Delete" border="0" onclick="confirm_del('<?=$data_sql['info_id'];?>','<?=$p;?>')" /></a><br />
                                Delete</td>
                            </tr> 
			<?php
                                $i++;
                            }
			}
			?>     
         </table> 
		</form>
		
		</td>
          </tr>
        </table>
		</td>
      </tr>
    </table></td>
  </tr>
 <tr>
    <td align="center" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
     
      <tr>
        <td width="666" align="right" valign="top"><table width="200" border="0" align="right" cellpadding="0" cellspacing="0">
          <tr>
		<?=number_pages($main_page, $p, $total_data, 8, $items_per_page,"&selected_menu=demoemail");?>		  
          </tr>
        </table></td>
        <td width="314" align="center" valign="bottom">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  
<?php }elseif($action=='DemoEmailShow'){ ?>
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">Demo Email  ::  Details </td>
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="left" valign="top" class="right-border">
		 <!--start iner table  -->
			<table width="98%" align="center" cellpadding="5" cellspacing="5" border="0">
            <tr>
			  <td align="left" valign="top" class="page-text">Demo Email Show: </td>
			</tr>
            <tr>
			  <td align="left" valign="top" class="page-text"><?=$emailCode?></td>
			</tr>
			<tr>
				<td align="left" valign="top"><input type="button" class="submitButton" value="Back" onclick="window.location='summary-email-details.php?selected_menu=demoemail'" /></td>
			</tr>
			
			</table>
		 <!-- end inner table -->
		  </td>
		 </tr>
            </table></td>
		 </tr>
        </table></td>
          </tr>
     </table>
	
<?PHP }elseif($action=='DemoEmailCode'){ ?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">Demo Email  ::  Details </td>
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="left" valign="top" class="right-border">
		 <!--start iner table  -->
			<table width="98%" align="center" cellpadding="5" cellspacing="5" border="0">
            <tr>
			  <td align="left" valign="top" class="page-text">Demo Email Code: </td>
			</tr>
            <tr>
			  <td align="left" valign="top" class="page-text"><textarea name="emailcode" id="emailcode" cols="90" rows="25"><?=$emailCode?></textarea></td>
			</tr>
			<tr>
				<td align="left" valign="top"><input type="button" class="submitButton" value="Back" onclick="window.location='demo-email-details.php?selected_menu=demoemail'" /></td>
			</tr>
			
			</table>
		 <!-- end inner table -->
		  </td>
		 </tr>
            </table></td>
		 </tr>
        </table></td>
          </tr>
     </table>
<?PHP }
 
include("includes/footer.php");
?>