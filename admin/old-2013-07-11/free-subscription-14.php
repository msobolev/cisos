<?php
require('includes/include_top.php');

$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = isset($_REQUEST["msg"]) ? msg_decode($_REQUEST["msg"]) : "";

$sql_query = "SELECT * FROM " . TABLE_FREE_SUBSCRIPTION_ONOFF . " ORDER BY sub_id";
$exe_query = com_db_query($sql_query);

$sID = isset($_REQUEST["sID"]) ? $_REQUEST["sID"] : $data_sql['sub_id'];

  switch ($action) {
    case 'edit':
	  $subscription_query = com_db_query("select * from " . TABLE_FREE_SUBSCRIPTION_ONOFF . " where sub_id = '" . (int)$sID . "'");
      $subscription_row = com_db_fetch_array($subscription_query);
    
	  break;
	  
	case 'editsave':
		$amount = com_db_input($_POST['amount']);
		$on_off = com_db_input($_POST['on_off']);
		
		
		com_db_query("update " . TABLE_FREE_SUBSCRIPTION_ONOFF . " set amount = '" . $amount . "', on_off ='".$on_off."' where sub_id = '" . (int)$sID . "'");
      	
		com_redirect("free-subscription.php?selected_menu=subscription&sID=". $sID . "&msg=" . msg_encode("Subscription is updated successfully"));
	
	  break;
	  
		  
    case 'details':
	  $subscription_query = com_db_query("select * from " . TABLE_FREE_SUBSCRIPTION_ONOFF . " where sub_id = '" . (int)$sID . "'");
      $subscription_row = com_db_fetch_array($subscription_query);
	  
	  break;
	  
    default:
	   $subscription_query = com_db_query("select * from " . TABLE_FREE_SUBSCRIPTION_ONOFF );
	   
       break;
  }



include("includes/header.php");
?>
<script language="JavaScript" src="includes/editor.js"></script>
 <tr>
    <td align="left" valign="top" bgcolor="#FFFFFF"><table width="975" border="0" align="center" cellpadding="0" cellspacing="0">

      <tr>
		<?php
		include("includes/menu_left.php");
		?>
		<td width="10" align="left" valign="top">&nbsp;</td>
        <td width="769" align="left" valign="top">

<?php if(($action == '') || ($action == 'save')){	?>			

		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right">
			  <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="left" valign="middle" class="heading-text"><span class="pageHeading">Manage Free Subscription</span></td>
				  <!--<td width="8%" align="right" valign="middle"><a href="#"><img src="images/add-icon.jpg" border="0" width="25" height="28" alt="Add News" title="Add New" onclick="window.location='free-subscription.php?action=add&selected_menu=subscription'"  /></a></td>
                  <td width="8%" align="left" valign="middle" class="nav-text">Add New</td>-->
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box">
			
			<form name="topicform" action="free-subscription.php" method="post">
			<table width="100%" align="left" cellpadding="0" cellspacing="0">
			  <tr>
			  	<td width="26" align="left" valign="middle" class="right-border-text">#</td>
				<td width="207" height="30" valign="middle" class="right-border">
					<table width="74%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td><span class="right-box-title-text">&nbsp;Subscription Name </span></td>
						</tr>
					</table>
				 </td>
                 <td width="253" height="30" valign="middle" class="right-border">
					<table width="45%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td><span class="right-box-title-text">Price</span></td>
						</tr>
					</table>
				 </td>
				 <td width="243" height="30" valign="middle" class="right-border">
					<table width="50%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td><span class="right-box-title-text">ON/OFF</span></td>
						</tr>
					</table>
				 </td>
				<td height="30" align="center" valign="middle" class="left-border"><div align="center"><span class="right-box-title-text">Action</span></div></td>
			  </tr>
				<?php
			 if(com_db_num_rows($exe_query)>0) {
			 	$i=1;
				while($data = com_db_fetch_array($exe_query)) {
				
				?>
				<tr align="left">
					<td width="26" align="left" valign="top" class="right-border-text"><?=$i;?></td>
					<td width="207" align="left" valign="top" class="right-border-text"><a href="free-subscription.php?selected_menu=subscription&action=details&sID=<?=$data['sub_id'];?>">Free Subscription</a></td>
					<td width="253" align="left" valign="top" class="right-border-text">$<?=com_db_output($data['amount'])?></td>
					<td width="243" align="left" valign="top" class="right-border-text"><?=com_db_output($data['on_off'])?></td>
                    <td width="98" align="center" class="right-border" valign="top">
					<a href="#"><img src="images/small-edit-icon.gif" width="16" height="16" alt="Edit" title="Edit" border="0" onclick="window.location='free-subscription.php?selected_menu=subscription&sID=<?=$data['sub_id']?>&action=edit'"></a><br />
					Edit
					</td>
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

<?php } elseif($action=='edit'){ ?>
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right">
			  <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="30%" align="left" valign="middle" class="heading-text"><span class="pageHeading">Manage Free Subscription</span></td>
                  <td width="34%" align="left" valign="middle" class="nav-text">&nbsp;</td>
                  <td width="8%" align="right" valign="middle">&nbsp;</td>
                  <td width="8%" align="right" valign="middle" class="nav-text">&nbsp;</td>
                  <td width="4%" align="right" valign="middle">&nbsp;</td>
                  <td width="8%" align="right" valign="middle" class="nav-text">&nbsp;</td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="center" valign="top" class="right-bar-content-border-box">
			
				<table width="96%" border="0" cellspacing="0" cellpadding="0">
				  <tr> 
					<td height="25" colspan="2">&nbsp;</td>
				  </tr>
				  <form action="<?php echo $current_page; ?>?selected_menu=subscription&sID=<?php echo $sID ?>&action=editsave" method="post">
                  <tr>
                  	<td align="left"><span class="page-text">Subscription Name:</span></td>
                    <td width="72%" align="left"><b>Free Subscription</b></td>
                  </tr>
				  <tr><td colspan="2">&nbsp;</td></tr>
				  <tr>
				   <td width="28%" valign="top" align="left"><span class="page-text">Price:</span></td>
	  				<td height="25" align="left">
                  		<input type="text" name="amount" id="amount" value="<?=$subscription_row['amount']?>" size="5"/>  </td>
				  </tr>
				   <tr><td colspan="2">&nbsp;</td></tr>
				  <tr>
                  	<td width="28%" valign="top" align="left"><span class="page-text">On / Off:</span></td>
					<td height="25" align="left">
                    	<select name="on_off" id="on_off">
                        	<option value="ON" <? if($subscription_row['on_off']=='ON'){ echo 'selected="selected"';}?>>ON</option>
                            <option value="OFF" <? if($subscription_row['on_off']=='OFF'){ echo 'selected="selected"';}?>>OFF</option>
                        </select>	
                    </td>
				  </tr>
                  <tr><td colspan="2">&nbsp;</td></tr>
                  <tr>
                  	<td width="28%" valign="top" align="left">&nbsp;</td>
					<td height="25" align="left"><input type="button" value="Cancel" class="submitButton" onclick="window.location='free-subscription.php?selected_menu=subscription&sID=<?=$sID;?>'" />&nbsp;<input type="submit" value="Save" class="submitButton"></td>
				  </tr>
				  <tr><td colspan="2">&nbsp;</td></tr>
				  </form>
				</table>
	</td>
				</tr>
				</table>
			</td>
		</tr>
	</table>
  </td>
</tr>

<?php } elseif($action=='details'){ ?>
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right">
			  <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="30%" align="left" valign="middle" class="heading-text">Manage Free Subscription</td>
                  <td width="34%" align="left" valign="middle" class="nav-text">&nbsp;</td>
                  <td width="8%" align="right" valign="middle">&nbsp;</td>
                  <td width="8%" align="right" valign="middle" class="nav-text">&nbsp;</td>
                  <td width="4%" align="right" valign="middle">&nbsp;</td>
                  <td width="8%" align="right" valign="middle" class="nav-text">&nbsp;</td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="center" valign="top" class="right-bar-content-border-box">
				<table width="96%" border="0" cellspacing="0" cellpadding="0">
					  <tr align="left"> 
						<td width="20%" height="25" align="left" class="page-text"><b>Subscription Name: </b></td>
					 	<td width="1%">&nbsp;</td>
                        <td width="79%"><b>Free Subscription</b></td>
                      </tr>
					  
                      <tr>
                      	<td height="25" align="left" class="page-text"><b>Price:</b></td>
                        <td>&nbsp;</td>
						<td class="page-text"><?=com_db_output($subscription_row['amount'])?></td>
					  </tr>
                      <tr>
                      	<td height="25" align="left" class="page-text"><b>On / Off:</b></td>
                        <td>&nbsp;</td>
						<td class="page-text"><?=$subscription_row['on_off']?></td>
					  </tr>
                      
					  <tr><td colspan="3">&nbsp;</td></tr>
					  <tr><td colspan="3"><input type="button" value="Back" class="submitButton" onclick="window.location='free-subscription.php?selected_menu=subscription'" /></td></tr>
					<tr><td colspan="3">&nbsp;</td></tr>
				</table>
		</td>
				</tr>
				</table>
			</td>
		</tr>
	</table>
  </td>
</tr>

<?php 
} 
include("includes/footer.php");
?>
