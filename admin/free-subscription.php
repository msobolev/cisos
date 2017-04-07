<?php
require('includes/include_top.php');

$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = isset($_REQUEST["msg"]) ? msg_decode($_REQUEST["msg"]) : "";

$sql_query = "SELECT * FROM " . TABLE_FREE_SUBSCRIPTION_ONOFF . " ORDER BY sub_id";
$exe_query = com_db_query($sql_query);

$sID = isset($_REQUEST["sID"]) ? $_REQUEST["sID"] : $data_sql['sub_id'];

  switch ($action) {
    case 'delete':
	  $subscription_query = com_db_query("delete from " . TABLE_FREE_SUBSCRIPTION_ONOFF . " where sub_id = '" . (int)$sID . "'");
      com_redirect("free-subscription.php?selected_menu=subscription&msg=" . msg_encode("Offer subscription is deleted successfully")); 
	  
	  break;
	  
	case 'edit':
	  $subscription_query = com_db_query("select * from " . TABLE_FREE_SUBSCRIPTION_ONOFF . " where sub_id = '" . (int)$sID . "'");
      $subscription_row = com_db_fetch_array($subscription_query);
    
	  break;
	  
	case 'editsave':
		$amount = com_db_input($_POST['amount']);
		$on_off = com_db_input($_POST['on_off']);
		$offer_url = com_db_input($_POST['offer_url']);
		$now_offer_url ='offer-'. $offer_url;
		
		com_db_query("update " . TABLE_FREE_SUBSCRIPTION_ONOFF . " set amount = '" . $amount . "', on_off ='".$on_off."', offer_url='".$now_offer_url."' where sub_id = '" . (int)$sID . "'");
      	
		com_redirect("free-subscription.php?selected_menu=subscription&sID=". $sID . "&msg=" . msg_encode("Offer subscription is updated successfully"));
	
	  break;
	  
	case 'addsave':
		$amount = com_db_input($_POST['amount']);
		$on_off = com_db_input($_POST['on_off']);
		$offer_url = com_db_input($_POST['offer_url']);
		$now_offer_url ='offer-'. $offer_url;
		
		$offerQuery = "insert into ".TABLE_FREE_SUBSCRIPTION_ONOFF." (amount,on_off,offer_url) values ('$amount','$on_off','$now_offer_url')";
		com_db_query($offerQuery);
      	
		com_redirect("free-subscription.php?selected_menu=subscription&msg=" . msg_encode("Offer subscription is added successfully"));
	
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
<script type="text/javascript" language="javascript">
	function confirm_del(sid){
		var agree=confirm("Offer will be deleted. \n Do you want to continue?");
		if (agree)
			window.location = "free-subscription.php?selected_menu=subscription&sID=" + sid + "&action=delete";
		else
			window.location = "free-subscription.php?selected_menu=subscription&sID=" + sid ;
	}
	
</script>
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
                  <td align="left" valign="middle" class="heading-text"><span class="pageHeading">Manage Offer Subscription</span></td>
                  <? if($btnAdd=='Yes'){ ?>
				  <td width="8%" align="right" valign="middle"><a href="#"><img src="images/add-icon.jpg" border="0" width="25" height="28" alt="Add News" title="Add New" onclick="window.location='free-subscription.php?action=add&selected_menu=subscription'"  /></a></td>
                  <td width="8%" align="left" valign="middle" class="nav-text">Add New</td>
                  <? } ?>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box">
			
			<form name="topicform" action="free-subscription.php" method="post">
			<table width="100%" align="left" cellpadding="0" cellspacing="0">
			  <tr>
			  	 <td width="25" align="left" valign="middle" class="right-border-text">#</td>
				 <td width="163" height="30" valign="middle" class="right-border"><span class="right-box-title-text">Subscription Name</span></td>
                 <td width="90" height="30" valign="middle" class="right-border"><span class="right-box-title-text">Price</span></td>
				 <td width="110" height="30" valign="middle" class="right-border"><span class="right-box-title-text">ON/OFF</span></td>
                 <td width="304" height="30" valign="middle" class="right-border"><span class="right-box-title-text">Offer URL</span></td>
				 <td height="30" colspan="2" align="center" valign="middle" class="left-border"><div align="center"><span class="right-box-title-text">Action</span></div></td>
			  </tr>
				<?php
			 if(com_db_num_rows($exe_query)>0) {
			 	$i=1;
				while($data = com_db_fetch_array($exe_query)) {
				
				?>
				<tr align="left">
					<td width="25" align="left" valign="top" class="right-border-text"><?=$i;?></td>
					<td width="163" align="left" valign="top" class="right-border-text"><a href="free-subscription.php?selected_menu=subscription&action=details&sID=<?=$data['sub_id'];?>">Offer Subscription</a></td>
					<td width="90" align="left" valign="top" class="right-border-text">$<?=com_db_output($data['amount'])?></td>
					<td width="110" align="left" valign="top" class="right-border-text"><?=com_db_output($data['on_off'])?></td>
                    <td width="304" align="left" valign="top" class="right-border-text"><?=com_db_output($data['offer_url'])?></td>
                    <? if($btnEdit=='Yes'){ ?>
                    <td width="36" align="center" class="right-border-text" valign="top">
					<a href="#"><img src="images/small-edit-icon.gif" width="16" height="16" alt="Edit" title="Edit" border="0" onclick="window.location='free-subscription.php?selected_menu=subscription&sID=<?=$data['sub_id']?>&action=edit'"></a><br />
					Edit</td>
                    <? } if($btnDelete=='Yes'){ ?>
                    <td width="39" align="center" class="right-border" valign="top"><a href="#"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" title="Delete" border="0" onclick="confirm_del('<?=$data['sub_id'];?>')" /></a><br />
					Delete</td>
                    <? } ?>
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
<?php } elseif($action=='add'){ ?>
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right">
			  <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="30%" align="left" valign="middle" class="heading-text"><span class="pageHeading">Manage Offer Subscription</span></td>
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
				  <form action="<?php echo $current_page; ?>?selected_menu=subscription&sID=<?php echo $sID ?>&action=addsave" method="post">
                  <tr>
                  	<td align="left"><span class="page-text">Subscription Name:</span></td>
                    <td width="72%" align="left"><b>Offer Subscription</b></td>
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
                  	<td width="28%" valign="top" align="left"><span class="page-text">Offer URL:</span></td>
					<td height="25" align="left">offer-<input type="text" name="offer_url" id="offer_url" /></td>
				  </tr>
                  <tr><td colspan="2">&nbsp;</td></tr>
                  <tr>
                  	<td width="28%" valign="top" align="left">&nbsp;</td>
					<td height="25" align="left"><input type="submit" value="Save" class="submitButton"> &nbsp; <input type="button" value="Cancel" class="submitButton" onclick="window.location='free-subscription.php?selected_menu=subscription&sID=<?=$sID;?>'" /></td>
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
<?php } elseif($action=='edit'){ 
	$arr_url = explode('-',$subscription_row['offer_url']);
	$show_url='';
	for($a=1; $a < sizeof($arr_url); $a++){
		if($show_url==''){
			$show_url = $arr_url[$a];
		}else{
			$show_url .='-'. $arr_url[$a];
		}
	}

?>
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right">
			  <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="30%" align="left" valign="middle" class="heading-text"><span class="pageHeading">Manage Offer Subscription</span></td>
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
                    <td width="72%" align="left"><b>Offer Subscription</b></td>
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
                  	<td width="28%" valign="top" align="left"><span class="page-text">Offer URL:</span></td>
					<td height="25" align="left">offer-<input type="text" name="offer_url" id="offer_url" value="<?=$show_url?>" /></td>
				  </tr>
                  <tr><td colspan="2">&nbsp;</td></tr>
                  <tr>
                  	<td width="28%" valign="top" align="left">&nbsp;</td>
					<td height="25" align="left"><input type="submit" value="Save" class="submitButton">&nbsp;<input type="button" value="Cancel" class="submitButton" onclick="window.location='free-subscription.php?selected_menu=subscription&sID=<?=$sID;?>'" /></td>
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
                        <td width="79%"><b>Offer Subscription</b></td>
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
