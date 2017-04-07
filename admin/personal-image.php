<?php
require('includes/include_top.php');

$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = isset($_REQUEST["msg"]) ? msg_decode($_REQUEST["msg"]) : "";

$sql_query = "SELECT * FROM " . TABLE_PERSONAL_IMAGE_ONOFF . " ORDER BY filter_id";
$exe_query = com_db_query($sql_query);

$fID = isset($_REQUEST["fID"]) ? $_REQUEST["fID"] : $data_sql['filter_id'];

  switch ($action) {
   
	case 'edit':
	  $subscription_query = com_db_query("select * from " . TABLE_PERSONAL_IMAGE_ONOFF . " where filter_id = '" . (int)$fID . "'");
      $filter_row = com_db_fetch_array($subscription_query);
    
	  break;
	  
	case 'editsave':
		$filter_onoff = com_db_input($_POST['filter_onoff']);
		
		com_db_query("update " . TABLE_PERSONAL_IMAGE_ONOFF . " set filter_onoff ='".$filter_onoff."' where filter_id = '" . (int)$fID . "'");
      	
		com_redirect("personal-image.php?selected_menu=personal&fID=". $fID . "&msg=" . msg_encode("Offer subscription is updated successfully"));
	
	  break;
	  
    case 'details':
	  $subscription_query = com_db_query("select * from " . TABLE_PERSONAL_IMAGE_ONOFF . " where filter_id = '" . (int)$fID . "'");
      $filter_row = com_db_fetch_array($subscription_query);
	  
	  break;
	  
    default:
	   $subscription_query = com_db_query("select * from " . TABLE_PERSONAL_IMAGE_ONOFF );
	   
       break;
  }



include("includes/header.php");
?>
<script language="JavaScript" src="includes/editor.js"></script>
<script type="text/javascript" language="javascript">
	function confirm_del(sid){
		var agree=confirm("Offer will be deleted. \n Do you want to continue?");
		if (agree)
			window.location = "personal-image.php?selected_menu=personal&fID=" + sid + "&action=delete";
		else
			window.location = "personal-image.php?selected_menu=personal&fID=" + sid ;
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
                  <td align="left" valign="middle" class="heading-text"><span class="pageHeading">Manage Personal Image Display</span></td>
                 
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box">
			
			<form name="topicform" action="personal-image.php" method="post">
			<table width="100%" align="left" cellpadding="0" cellspacing="0">
			  <tr>
			  	 <td width="51" align="left" valign="middle" class="right-border-text">#</td>
				 <td width="335" height="30" valign="middle" class="right-border"><span class="right-box-title-text">User Type</span></td>
                 <td width="268" height="30" valign="middle" class="right-border"><span class="right-box-title-text">Display Status</span></td>
                 <td height="30" colspan="2" align="center" valign="middle" class="left-border"><div align="center"><span class="right-box-title-text">Action</span></div></td>
			  </tr>
				<?php
			 if(com_db_num_rows($exe_query)>0) {
			 	$i=1;
				while($data = com_db_fetch_array($exe_query)) {
				
				?>
				<tr align="left">
					<td width="51" align="left" valign="top" class="right-border-text"><?=$i;?></td>
					<td width="335" align="left" valign="top" class="right-border-text"><a href="personal-image.php?selected_menu=personal&action=details&fID=<?=$data['filter_id'];?>"><?=com_db_output($data['filter_name'])?></a></td>
					<td width="268" align="left" valign="top" class="right-border-text"><?=com_db_output($data['filter_onoff'])?></td>
                    <td width="69" align="center" class="right-border-text" valign="top">
					<a href="#"><img src="images/small-edit-icon.gif" width="16" height="16" alt="Edit" title="Edit" border="0" onclick="window.location='personal-image.php?selected_menu=personal&fID=<?=$data['filter_id']?>&action=edit'"></a><br />
					Edit</td>
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
<?php } elseif($action=='edit'){ 
?>
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right">
			  <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="30%" align="left" valign="middle" class="heading-text"><span class="pageHeading">Manage Personal Image Display</span></td>
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
				  <form action="<?php echo $current_page; ?>?selected_menu=personal&fID=<?php echo $fID ?>&action=editsave" method="post">
                  <tr>
                  	<td align="left"><span class="page-text">User Type:</span></td>
                    <td width="72%" align="left"><b><?=com_db_output($filter_row['filter_name'])?></b></td>
                  </tr>
				  <tr><td colspan="2">&nbsp;</td></tr>
				  <tr>
                  	<td width="28%" valign="top" align="left"><span class="page-text">Display Status:</span></td>
					<td height="25" align="left">
                    	<select name="filter_onoff" id="filter_onoff">
                        	<option value="ON" <? if($filter_row['filter_onoff']=='ON'){ echo 'selected="selected"';}?>>ON</option>
                            <option value="OFF" <? if($filter_row['filter_onoff']=='OFF'){ echo 'selected="selected"';}?>>OFF</option>
                        </select>	
                    </td>
				  </tr>
                  <tr><td colspan="2">&nbsp;</td></tr>
                  <tr>
                  	<td width="28%" valign="top" align="left">&nbsp;</td>
					<td height="25" align="left"><input type="submit" value="Save" class="submitButton">&nbsp;<input type="button" value="Cancel" class="submitButton" onclick="window.location='personal-image.php?selected_menu=personal&fID=<?=$fID;?>'" /></td>
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
                  <td width="30%" align="left" valign="middle" class="heading-text"><span class="pageHeading">Manage Personal Filter</span></td>
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
						<td width="20%" height="25" align="left" class="page-text"><b>Validation Name: </b></td>
					 	<td width="1%">&nbsp;</td>
                        <td width="79%"><b><?=com_db_output($filter_row['filter_name'])?></b></td>
                      </tr>
                      <tr>
                      	<td height="25" align="left" class="page-text"><b>ON / OFF:</b></td>
                        <td>&nbsp;</td>
						<td class="page-text"><b><?=$filter_row['filter_onoff']?></b></td>
					  </tr>
                      
					  <tr><td colspan="3">&nbsp;</td></tr>
					  <tr><td colspan="3"><input type="button" value="Back" class="submitButton" onclick="window.location='personal-image.php?selected_menu=personal'" /></td></tr>
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
