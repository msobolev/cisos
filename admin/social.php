<?php
require('includes/include_top.php');

$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = isset($_REQUEST["msg"]) ? msg_decode($_REQUEST["msg"]) : "";

$sql_query = "SELECT * FROM " . TABLE_SOCIAL_LINK . "  ORDER BY social_id";
$exe_query = com_db_query($sql_query);

$sID = isset($_REQUEST["sID"]) ? $_REQUEST["sID"] : $data_sql['social_id'];

  switch ($action) {
    case 'edit':
	  $page_content_query = com_db_query("select * from " . TABLE_SOCIAL_LINK . " where social_id = '" . (int)$sID . "'");
      $page_content = com_db_fetch_array($page_content_query);
    
	  break;
	  
	case 'save':
	  com_db_query("update " . TABLE_SOCIAL_LINK . " set social_url = '" . com_db_input($_POST['social_url']) . "' where social_id = '" . (int)$sID . "'");
      com_redirect("social.php?selected_menu=social&sID=". $sID . "&msg=" . msg_encode("Page content is updated successfully"));
	
	  break;
	  
	case 'pagedetails':
	  $page_content_query = com_db_query("select * from " . TABLE_SOCIAL_LINK . " where social_id = '" . (int)$sID . "'");
      $page_content = com_db_fetch_array($page_content_query);
	  
	  break;
	  
    default:
	   $page_content_query = com_db_query("select * from " . TABLE_SOCIAL_LINK );
	   
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
                  <td align="left" valign="middle" class="heading-text"><span class="pageHeading">Manage Social Link</span></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box">
			
			<form name="topicform" action="social.php" method="post">
			<table width="100%" align="left" cellpadding="0" cellspacing="0">
			  <tr>
			  	<td width="29" align="left" valign="middle" class="right-border-text">#</td>
				<td width="388" height="30" valign="middle" class="right-border">
					<table width="27%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td><span class="right-box-title-text">Social Name </span></td>
						</tr>
					</table>
				 </td>
                 <td width="400" height="30" valign="middle" class="right-border">
					<table width="32%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td><span class="right-box-title-text">Social Link</span></td>
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
					<td width="29" align="left" valign="top" class="right-border-text"><?=$i;?></td>
					<td width="388" align="left" valign="top" class="right-border-text"><a href="social.php?selected_menu=social&action=pagedetails&sID=<?=$data['social_id'];?>"><?=com_db_output($data['social_name'])?></a></td>
					<td width="400" align="left" valign="top" class="right-border-text"><?=com_db_output($data['social_url'])?></td>
                    <? if($btnEdit=='Yes'){ ?>
                    <td width="144" align="center" class="right-border" valign="top">
					<a href="#"><img src="images/small-edit-icon.gif" width="16" height="16" alt="Edit" title="Edit" border="0" onclick="window.location='social.php?selected_menu=social&sID=<?=$data['social_id']?>&action=edit'"></a><br />
					Edit
					</td>
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

<?php } elseif($action=='edit'){ ?>
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right">
			  <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="30%" align="left" valign="middle" class="heading-text"><span class="pageHeading">Manage Social Link</span></td>
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
					<td height="25" colspan="3">&nbsp;</td>
				  </tr>
				  <form action="<?php echo $current_page; ?>?selected_menu=social&sID=<?php echo $sID ?>&action=save" method="post">
				  
                  <tr>
                    <td width="12%" align="left" class="page-text">Social Name:</td>
                    <td width="1%" align="left" class="page-text">&nbsp;</td>
                    <td width="87%" align="left" class="page-text"><strong><?=$page_content['social_name']?></strong></td>
                  </tr>
                  
				  <tr><td colspan="3">&nbsp;</td></tr>
				  <tr>
				    <td  class="page-text" align="left">URL Name :</td>
                    <td align="left" class="page-text">&nbsp;</td>
                    <td align="left" class="page-text"><input name="social_url" size="80" id="social_url" value="<?=$page_content['social_url']?>" /></td>
				  </tr>
				  
				  <tr><td colspan="3">&nbsp;</td></tr>
				  <tr>
                  	<td colspan="2">&nbsp;</td>
					<td height="25" align="left" colspan="3"><input type="submit" value="Save" class="submitButton">&nbsp;<input type="button" value="Cancel" class="submitButton" onclick="window.location='social.php?selected_menu=social&sID=<?=$sID;?>'" /></td>
				  </tr>
				  <tr><td colspan="3">&nbsp;</td></tr>
				  <tr>
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

<?php } elseif($action=='pagedetails'){ ?>
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right">
			  <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="30%" align="left" valign="middle" class="heading-text">Manage Social Link</td>
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
					  <tr><td>&nbsp;</td></tr>
                      <tr align="left"> 
						<td height="25" align="left" class="page-text"><b>Social Name: <?php echo $page_content['social_name']; ?></b></td>
					  </tr>
					  <tr> 
						<td height="25" align="left" class="page-text"><b>Social URL: </b> <?=com_db_output($page_content['social_url'])?></td>
					  </tr>
					  <tr><td>&nbsp;</td></tr>
					  <tr><td><input type="button" value="Back" class="submitButton" onclick="window.location='social.php?selected_menu=social'" /></td></tr>
					<tr><td>&nbsp;</td></tr>
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
