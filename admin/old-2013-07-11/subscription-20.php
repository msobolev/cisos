<?php
require('includes/include_top.php');
include('includes/include_editor.php');

$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = isset($_REQUEST["msg"]) ? msg_decode($_REQUEST["msg"]) : "";

$sql_query = "SELECT * FROM " . TABLE_SUBSCRIPTION . "  ORDER BY sub_id";
$exe_query = com_db_query($sql_query);

$sID = isset($_REQUEST["sID"]) ? $_REQUEST["sID"] : $data_sql['sub_id'];

  switch ($action) {
    case 'edit':
	  $subscription_query = com_db_query("select * from " . TABLE_SUBSCRIPTION . " where sub_id = '" . (int)$sID . "'");
      $subscription_row = com_db_fetch_array($subscription_query);
    
	  break;
	  
	case 'editsave':
		$benefits = com_db_input($_POST['benefits']);
		$best = com_db_input($_POST['best']);
		$price = com_db_input($_POST['price']);
		$amount = com_db_input($_POST['amount']);
		
	  	com_db_query("update " . TABLE_SUBSCRIPTION . " set benefits = '" . $benefits . "', best ='".$best."', price = '".$price."', amount = '".$amount."'   where sub_id = '" . (int)$sID . "'");
      	com_redirect("subscription.php?selected_menu=subscription&sID=". $sID . "&msg=" . msg_encode("Subscription is updated successfully"));
	
	  break;
	  
		  
    case 'details':
	  $subscription_query = com_db_query("select * from " . TABLE_SUBSCRIPTION . " where sub_id = '" . (int)$sID . "'");
      $subscription_row = com_db_fetch_array($subscription_query);
	  
	  break;
	  
    default:
	   $subscription_query = com_db_query("select * from " . TABLE_SUBSCRIPTION );
	   
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
                  <td align="left" valign="middle" class="heading-text"><span class="pageHeading">Manage Subscription</span></td>
				  <!--<td width="8%" align="right" valign="middle"><a href="#"><img src="images/add-icon.jpg" border="0" width="25" height="28" alt="Add News" title="Add New" onclick="window.location='subscription.php?action=add&selected_menu=subscription'"  /></a></td>
                  <td width="8%" align="left" valign="middle" class="nav-text">Add New</td>-->
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box">
			
			<form name="topicform" action="subscription.php" method="post">
			<table width="100%" align="left" cellpadding="0" cellspacing="0">
			  <tr>
			  	<td width="26" align="left" valign="middle" class="right-border-text">#</td>
				<td width="201" height="30" valign="middle" class="right-border">
					<table width="74%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td><span class="right-box-title-text">&nbsp;Subscription Name </span></td>
						</tr>
					</table>
				 </td>
                 <td width="348" height="30" valign="middle" class="right-border">
					<table width="32%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td><span class="right-box-title-text">Benefits</span></td>
						</tr>
					</table>
				 </td>
                 <td width="262" height="30" valign="middle" class="right-border">
					<table width="37%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td><span class="right-box-title-text">&nbsp;Price </span></td>
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
					<td width="201" align="left" valign="top" class="right-border-text"><a href="subscription.php?selected_menu=subscription&action=details&sID=<?=$data['sub_id'];?>"><?=com_db_output($data['subscription_name'])?></a></td>
					<td width="348" align="left" valign="top" class="right-border-text"><?=com_db_output($data['benefits'])?></td>
                    <td width="262" align="left" valign="top" class="right-border-text"><?=com_db_output($data['price'])?></td>
                    <td width="124" align="center" class="right-border" valign="top">
					<a href="#"><img src="images/small-edit-icon.gif" width="16" height="16" alt="Edit" title="Edit" border="0" onclick="window.location='subscription.php?selected_menu=subscription&sID=<?=$data['sub_id']?>&action=edit'"></a><br />
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
                  <td width="30%" align="left" valign="middle" class="heading-text"><span class="pageHeading">Manage Subscription</span></td>
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
			
				<table width="96%" border="0" cellspacing="2" cellpadding="2">
				  <tr> 
					<td height="25" colspan="2">&nbsp;</td>
				  </tr>
				  <form action="<?php echo $current_page; ?>?selected_menu=subscription&sID=<?php echo $sID ?>&action=editsave" method="post">
                  <tr>
                  	<td align="left"><span class="page-text">Subscription Name:</span></td>
                    <td width="82%" align="left"><b><?=$subscription_row['subscription_name']?></b></td>
                  </tr>
				  <tr><td colspan="2">&nbsp;</td></tr>
				  <tr>
				   <td width="18%" valign="top" align="left"><span class="page-text">Benefits:</span></td>
	  <td height="25" align="left">
                  		<textarea name="benefits" cols="30" rows="4" id="benefits"><?=$subscription_row['benefits']?></textarea>                  </td>
				  </tr>
				  <tr><td colspan="2">&nbsp;</td></tr>
				  <tr>
				   <td width="18%" valign="top" align="left"><span class="page-text">Best if you are:</span></td>
	  <td height="25" align="left">
                  		<textarea name="best" cols="30" rows="4" id="best"><?=$subscription_row['best']?></textarea>                  </td>
				  </tr>
				  <tr><td colspan="2">&nbsp;</td></tr>
				  <tr>
				   <td width="18%" valign="top" align="left"><span class="page-text">Price:</span></td>
	  				<td height="25" align="left">
                  		<textarea name="price" cols="30" rows="4" id="price"><?=$subscription_row['price']?></textarea>                  </td>
				  </tr>
				  
				  <tr>
                  	<td width="18%" valign="top" align="left"><span class="page-text">Only Price:</span></td>
					<td height="25" align="left"><input type="text" name="amount" value="<?=$subscription_row['amount'];?>"/></td>
				  </tr>
                  <tr><td colspan="2">&nbsp;</td></tr>
                  <tr>
                  	<td width="18%" valign="top" align="left">&nbsp;</td>
					<td height="25" align="left"><input type="button" value="Cancel" class="submitButton" onclick="window.location='subscription.php?selected_menu=subscription&sID=<?=$sID;?>'" />&nbsp;<input type="submit" value="Save" class="submitButton"></td>
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
                  <td width="30%" align="left" valign="middle" class="heading-text">Manage <span class="right-box-title-text">Subscription</span></td>
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
						<td height="25" align="left" class="page-text"><b>Subscription Name: </b></td>
					 	<td>&nbsp;</td>
                        <td><b><?php echo $subscription_row['subscription_name']; ?></b></td>
                      </tr>
					  <tr> 
						<td height="25" align="left" class="page-text"><b>Benefits:</b></td>
                        <td>&nbsp;</td>
                        <td><?php echo $subscription_row['benefits']; ?></b></td>
					  </tr>
					  <tr>
                      	<td height="25" align="left" class="page-text"><b>Best:</b></td>
                        <td>&nbsp;</td>
						<td class="page-text"><?=com_db_output($subscription_row['best'])?></td>
					  </tr>
                      <tr>
                      	<td height="25" align="left" class="page-text"><b>Price:</b></td>
                        <td>&nbsp;</td>
						<td class="page-text"><?=com_db_output($subscription_row['price'])?></td>
					  </tr>
                      <tr>
                      	<td height="25" align="left" class="page-text"><b>Only Price:</b></td>
                        <td>&nbsp;</td>
						<td class="page-text"><?=$subscription_row['amount']?></td>
					  </tr>
                      
					  <tr><td colspan="3">&nbsp;</td></tr>
					  <tr><td colspan="3"><input type="button" value="Back" class="submitButton" onclick="window.location='subscription.php?selected_menu=subscription'" /></td></tr>
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
