<?php
require('includes/include_top.php');

$action = (isset($_GET['action']) ? $_GET['action'] : '');


$page_meta_query = com_db_query("select * from " . TABLE_META_TAG ." order by page_name");
$page_meta = com_db_fetch_array($page_meta_query);
$pID = (isset($_GET['pID'])) ? $_GET['pID'] : $page_meta['id'];

  switch ($action) {
    case 'edit':
	  $page_meta_query = com_db_query("select * from " . TABLE_META_TAG . " where id = '" . (int)$pID . "'");
      $page_meta = com_db_fetch_array($page_meta_query);
	  
	  break;
	  
	case 'save':
	  com_db_query("update " . TABLE_META_TAG . " set page_title ='".com_db_input($_POST['page_title'])."', meta_keyword = '" . com_db_input($_POST['meta_keyword']) . "', meta_desc = '".com_db_input($_POST['meta_desc'])."' where id = '" . (int)$pID . "'");
	  com_redirect("metatag.php?selected_menu=content&pID=". $pID . "&msg=" . msg_encode("Page meta tag is updated successfully"));
	  
	  break;
	
	default:
	   $page_meta_query = com_db_query("select * from " . TABLE_META_TAG ." order by page_name");
	   break;
	
  }

include("includes/header.php");
?>

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
                  <td align="left" valign="middle" class="heading-text"><span class="pageHeading">Manage Page Meta Tag</span></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box">
			
			<form name="topicform" action="metatag.php" method="post">
			<table width="100%" align="left" cellpadding="0" cellspacing="0">
			  <tr>
			  	<td width="29" align="left" valign="middle" class="right-border-text">#</td>
				<td height="30" valign="middle" class="right-border-text"><span class="right-box-title-text">Page Name </span></td>
				<td width="624" align="left" valign="middle" class="right-border-text"><span class="right-box-title-text">Page Title </span></td>
				<td width="136" height="30" align="center" valign="middle" class="left-border"><div align="center"><span class="right-box-title-text">Action</span></div></td>
			  </tr>
				<?php
			 if(com_db_num_rows($page_meta_query)>0) {
			 	$i=1;
				while($data = com_db_fetch_array($page_meta_query)) {
				
				?>
				<tr align="left">
					<td width="29" align="left" valign="top" class="right-border-text"><?=$i?></td>
					<td width="172" align="left" valign="top" class="right-border-text"><?=com_db_output($data['page_name'])?></td>
					<td width="624" align="left" valign="top" class="right-border-text"><?=com_db_output($data['page_title'])?></td>
					<td width="136" align="center" class="right-border" valign="top">
					<a href="#"><img src="images/small-edit-icon.gif" width="16" height="16" alt="Edit" title="Edit" border="0" onclick="window.location='metatag.php?selected_menu=content&pID=<?=$data['id']?>&action=edit'"></a><br />
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
                  <td width="30%" align="left" valign="middle" class="heading-text">Manage Page Meta Tag</td>
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
				<table width="100%" align="center" cellpadding="0" cellspacing="0">
			   <tr>
			  <td align="left" valign="top" class="right-border-box">
				<table width="96%" border="0" cellspacing="5" cellpadding="5">
				  <form action="metatag.php?selected_menu=content&pID=<?php echo $pID ?>&action=save" method="post">
				  <tr>
				  	<td width="15%" valign="top" class="page-text" align="left">Page Name:</td>
					<td align="left" valign="top" class="page-text"><strong><?php echo $page_meta['page_name']; ?></strong></td>
				  </tr>
				  <tr>
					<td width="15%" valign="top" class="page-text">Page Title:</td>
				    <td width="85%" align="left"><input type="text" name="page_title" size="60" value="<?php echo com_db_output($page_meta['page_title']);?>" /></td>
				  </tr>
				  <tr>
					<td valign="top" class="page-text">Meta Keyword: </td>
					<td valign="top" align="left"><textarea name="meta_keyword" cols="50" rows="6"><?php echo com_db_output($page_meta['meta_keyword']);?></textarea></td>
				  </tr>
                  <tr>
					<td valign="top" class="page-text">Meta Description: </td>
					<td valign="top" align="left"><textarea name="meta_desc" cols="50" rows="6"><?php echo com_db_output($page_meta['meta_desc']);?></textarea></td>
				  </tr>
				  <tr>
					<td align="left">&nbsp;</td>
					<td height="25" align="left"><input type="submit" class="submitButton" value="Save">&nbsp;
				    <input name="button" type="button" class="submitButton"onclick="window.location='metatag.php?selected_menu=content&pID=<?=$pID;?>'" value="Cancel" /></td>
				  </tr>
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
	</table>
  </td>
</tr>
<?php }
include("includes/footer.php");
?>
