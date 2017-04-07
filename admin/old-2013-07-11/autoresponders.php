<?php
require('includes/include_top.php');

$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = isset($_REQUEST["msg"]) ? msg_decode($_REQUEST["msg"]) : "";

$sql_query = "SELECT * FROM " . TABLE_AUTORESPONDERS;
$exe_query = com_db_query($sql_query);

$aID = isset($_REQUEST["aID"]) ? $_REQUEST["aID"] : $data_sql['auto_id'];

  switch ($action) {
    case 'edit':
	  $page_content_query = com_db_query("select * from " . TABLE_AUTORESPONDERS . " where auto_id = '" . (int)$aID . "'");
      $page_content = com_db_fetch_array($page_content_query);
    
	  break;
	  
	case 'save':
	  $autoresponder_for = $_POST['autoresponder_for'];
	  
	  com_db_query("update " . TABLE_AUTORESPONDERS . " set subject = '" . com_db_input($_POST['subject']) . "', body1='".com_db_input($_POST['body1'])."', link_caption='".com_db_input($_POST['link_caption'])."', body2 ='".com_db_input($_POST['body2'])."' where auto_id = '" . (int)$aID . "'");
      com_redirect("autoresponders.php?selected_menu=autoresponders&aID=". $aID . "&msg=" . msg_encode("Page content is updated successfully"));
	
	  break;
	  
	case 'pagedetails':
	  $page_content_query = com_db_query("select * from " . TABLE_AUTORESPONDERS . " where auto_id = '" . (int)$aID . "'");
      $page_content = com_db_fetch_array($page_content_query);
	  
	  break;
	  
    default:
	   $page_content_query = com_db_query("select * from " . TABLE_AUTORESPONDERS );
	   
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
                  <td align="left" valign="middle" class="heading-text"><span class="pageHeading">Manage Autoresponders </span></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box">
			
			<form name="topicform" action="autoresponders.php" method="post">
			<table width="100%" align="left" cellpadding="0" cellspacing="0">
			  <tr>
			  	<td width="29" align="left" valign="middle" class="right-border-text">#</td>
				<td width="388" height="30" valign="middle" class="right-border">
					<span class="right-box-title-text">Autoresponder for </span>
				 </td>
                 <td width="94" height="30" valign="middle" class="right-border">
				 	<span class="right-box-title-text">Email Send</span>
				 </td>
				 <td width="350" height="30" valign="middle" class="right-border">
				 	<span class="right-box-title-text">Subject</span>
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
					<td width="388" align="left" valign="top" class="right-border-text"><a href="autoresponders.php?selected_menu=autoresponders&action=pagedetails&aID=<?=$data['auto_id'];?>"><?=com_db_output($data['autoresponder_for'])?></a></td>
					<td width="94" align="left" valign="top" class="right-border-text"><?=com_db_output($data['type'])?></td>
					<td width="350" align="left" valign="top" class="right-border-text"><?=com_db_output($data['subject'])?></td>
                    <td width="100" align="center" class="right-border" valign="top">
					<a href="#"><img src="images/small-edit-icon.gif" width="16" height="16" alt="Edit" title="Edit" border="0" onclick="window.location='autoresponders.php?selected_menu=autoresponders&aID=<?=$data['auto_id']?>&action=edit'"></a><br />
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
                  <td width="30%" align="left" valign="middle" class="heading-text"><span class="pageHeading">Manage Autoresponders</span></td>
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
				  <form action="<?php echo $current_page; ?>?selected_menu=autoresponders&aID=<?php echo $aID ?>&action=save" method="post">
				  
                  <tr>
                    <td width="18%" align="left" class="page-text">E-mail Send To:</td>
                    <td width="1%" align="left" class="page-text">&nbsp;</td>
                    <td width="81%" align="left" class="page-text"><strong><?=$page_content['type']?></strong></td>
                  </tr>
				  <tr><td colspan="3">&nbsp;</td></tr>
				  <tr>
                    <td width="18%" align="left" class="page-text">Autoresponder For:</td>
                    <td width="1%" align="left" class="page-text">&nbsp;</td>
                    <td width="81%" align="left" class="page-text"><strong><?=$page_content['autoresponder_for']?></strong></td>
                  </tr>
				  <tr><td colspan="3">&nbsp;</td></tr>
				  <tr>
                    <td width="18%" align="left" class="page-text">Subject:</td>
                    <td width="1%" align="left" class="page-text">&nbsp;</td>
                    <td width="81%" align="left" class="page-text"><input name="subject" size="80" id="subject" value="<?=$page_content['subject']?>" /></td>
                  </tr>
				  <tr><td colspan="3">&nbsp;</td></tr>
				  <tr>
                    <td width="18%" align="left" class="page-text">Text Body1:</td>
                    <td width="1%" align="left" class="page-text">&nbsp;</td>
                    <td width="81%" align="left" class="page-text"><input name="body1" size="80" id="body1" value="<?=$page_content['body1']?>" /></td>
                  </tr>
				  <tr><td colspan="3">&nbsp;</td></tr>
				  <tr>
                    <td width="18%" align="left" class="page-text">Link caption:</td>
                    <td width="1%" align="left" class="page-text">&nbsp;</td>
                    <td width="81%" align="left" class="page-text"><input name="link_caption" size="80" id="link_caption" value="<?=$page_content['link_caption']?>" /></td>
                  </tr>
				  <tr><td colspan="3">&nbsp;</td></tr>
				  <tr>
                    <td width="18%" align="left" class="page-text">Text Body2:</td>
                    <td width="1%" align="left" class="page-text">&nbsp;</td>
                    <td width="81%" align="left" class="page-text"><input name="body2" size="80" id="body2" value="<?=$page_content['body2']?>" /></td>
                  </tr>
				  <tr><td colspan="3">&nbsp;</td></tr>
				  <tr>
                  	<td colspan="2">&nbsp;</td>
					<td height="25" align="left" colspan="3"><input type="submit" value="Save" class="submitButton">&nbsp;<input type="button" value="Cancel" class="submitButton" onclick="window.location='autoresponders.php?selected_menu=autoresponders&aID=<?=$aID;?>'" /></td>
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
                  <td width="30%" align="left" valign="middle" class="heading-text">Manage <span class="pageHeading">Autoresponders</span></td>
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
					  <tr><td width="19%">&nbsp;</td>
					    <td width="81%">&nbsp;</td>
					  </tr>
                      <tr align="left"> 
						<td height="25" align="left" class="page-text"><b>Email Send To : </b></td>
					    <td align="left" class="page-text"><b><?php echo $page_content['type']; ?></b></td>
                      </tr>
					  <tr> 
						<td height="25" align="left" class="page-text"><b>Autoresponder For : </b></td>
					    <td align="left" class="page-text"><?=com_db_output($page_content['autoresponder_for'])?></td>
					  </tr>
					  <tr> 
						<td height="25" align="left" class="page-text"><b>Subject : </b></td>
					    <td align="left" class="page-text"><?=com_db_output($page_content['subject'])?></td>
					  </tr>
					   <tr> 
						<td height="25" align="left" class="page-text"><b>Email Body : </b></td>
					    <td align="left" class="page-text">
							<?=com_db_output($page_content['body1'])?>
					      	&nbsp;
					      	<a href="#"><?=com_db_output($page_content['link_caption'])?></a>
					      	&nbsp;
				         	<?=com_db_output($page_content['body2'])?></td>
				      </tr>
					  <tr><td>&nbsp;</td>
					    <td>&nbsp;</td>
					  </tr>
					  <tr><td><input type="button" value="Back" class="submitButton" onclick="window.location='autoresponders.php?selected_menu=autoresponders'" /></td>
					    <td>&nbsp;</td>
					  </tr>
					<tr><td>&nbsp;</td>
					  <td>&nbsp;</td>
					</tr>
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
