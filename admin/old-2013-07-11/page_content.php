<?php
require('includes/include_top.php');
include('includes/include_editor.php');

$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = isset($_REQUEST["msg"]) ? msg_decode($_REQUEST["msg"]) : "";

$sql_query = "SELECT * FROM " . TABLE_PAGE_CONTENT . "  ORDER BY p_id";
$exe_query = com_db_query($sql_query);

$pID = isset($_REQUEST["pID"]) ? $_REQUEST["pID"] : $data_sql['p_id'];

  switch ($action) {
    case 'edit':
	  $page_content_query = com_db_query("select * from " . TABLE_PAGE_CONTENT . " where p_id = '" . (int)$pID . "'");
      $page_content = com_db_fetch_array($page_content_query);
    
	  break;
	  
	case 'save':
	  com_db_query("update " . TABLE_PAGE_CONTENT . " set page_title ='" . com_db_input($_POST['page_title']) . "', page_content = '" . com_db_input($_POST['page_desc']) . "' where p_id = '" . (int)$pID . "'");
      com_redirect("page_content.php?selected_menu=content&pID=". $pID . "&msg=" . msg_encode("Page content is updated successfully"));
	
	  break;
	  
	case 'addsave':  
	  
	  	$name=$_POST['pname'];
		$pname=str_replace(' ', '-', $name);
		$page_title=com_db_input($_POST['page_title']);
		$page_desc=com_db_input($_POST['page_desc']);
		$orgname=$pname . '.php';
		/*$file='../uploade-image/new.php';
		$newfile='../'. $orgname;
		copy($file, $newfile);*/
		com_db_query("insert into " . TABLE_PAGE_CONTENT . " (page_name,page_title,page_content) values ('$orgname','$page_title','$page_desc')");
		com_db_query("insert into " . TABLE_META_TAG . " (page_name) values ('$orgname')");
		
      	com_redirect("page_content.php?selected_menu=content&pID=". $pID . "&msg=" . msg_encode("New page added successfully"));
	  
	  break;
	  
    case 'pagedetails':
	  $page_content_query = com_db_query("select page_name, page_content from " . TABLE_PAGE_CONTENT . " where p_id = '" . (int)$pID . "'");
      $page_content = com_db_fetch_array($page_content_query);
	  
	  break;
	  
    default:
	   $page_content_query = com_db_query("select * from " . TABLE_PAGE_CONTENT );
	   
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
                  <td align="left" valign="middle" class="heading-text"><span class="pageHeading">Manage Page Content</span></td>
				  <td width="8%" align="right" valign="middle"><a href="#"><img src="images/add-icon.jpg" border="0" width="25" height="28" alt="Add News" title="Add New" onclick="window.location='page_content.php?action=add&selected_menu=content'"  /></a></td>
                  <td width="8%" align="left" valign="middle" class="nav-text">Add New</td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box">
			
			<form name="topicform" action="page_content.php" method="post">
			<table width="100%" align="left" cellpadding="0" cellspacing="0">
			  <tr>
			  	<td width="29" align="left" valign="middle" class="right-border-text">#</td>
				<td width="388" height="30" valign="middle" class="right-border">
					<table width="27%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td><span class="right-box-title-text">Page Name </span></td>
						</tr>
					</table>
				 </td>
                 <td width="400" height="30" valign="middle" class="right-border">
					<table width="32%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td><span class="right-box-title-text">Page Heading </span></td>
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
					<td width="388" align="left" valign="top" class="right-border-text"><a href="page_content.php?selected_menu=content&action=pagedetails&pID=<?=$data['p_id'];?>"><?=com_db_output($data['page_name'])?></a></td>
					<td width="400" align="left" valign="top" class="right-border-text"><a href="page_content.php?selected_menu=content&action=pagedetails&pID=<?=$data['p_id'];?>"><?=com_db_output($data['page_title'])?></a></td>
                    <td width="144" align="center" class="right-border" valign="top">
					<a href="#"><img src="images/small-edit-icon.gif" width="16" height="16" alt="Edit" title="Edit" border="0" onclick="window.location='page_content.php?selected_menu=content&pID=<?=$data['p_id']?>&action=edit'"></a><br />
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
                  <td width="30%" align="left" valign="middle" class="heading-text"><span class="pageHeading">Manage Page Content</span></td>
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
				  <tr align="left"> 
					<td height="25" colspan="2" align="left">&nbsp;<b><?php echo $page_content['page_name']; ?></b></td>
				  </tr>
				  <tr> 
					<td height="25" colspan="2">&nbsp;</td>
				  </tr>
				  <form action="<?php echo $current_page; ?>?selected_menu=content&pID=<?php echo $pID ?>&action=save" method="post">
				  
                  <tr><td align="left" colspan="2" class="page-text">Page Title</td></tr>
                  <tr>
                  	<td align="left">&nbsp;</td>
                    <td width="96%" align="left"><input name="page_title" size="80" id="page_title" value="<?=$page_content['page_title']?>" /></td>
                  </tr>
				  <tr><td colspan="2">&nbsp;</td></tr>
				  <tr><td  class="page-text" colspan="2" align="left">Page Content </td></tr>
				  <tr><td colspan="2">&nbsp;</td></tr>
				  <tr>
				   <td width="4%" valign="top" align="left">&nbsp;</td>
				  <td height="25" align="left"><div id="loading"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1">Please wait<br>						<br>
					  </font><strong><font color="#993300" face="Verdana, Arial, Helvetica, sans-serif" >Editor 
					  Loading......</font></strong><br>
					  <br></div> <div id="fck" style="">  
					  <!---------------------------->
					  
						<?php
						$oFCKeditor = new FCKeditor('page_desc') ;
						$oFCKeditor->BasePath	= $sBasePath ;
						$oFCKeditor->ToolbarSet = ''; // Basic
						$oFCKeditor->Width  = '87%';
						$oFCKeditor->Height  = '400';       
						$oFCKeditor->Value		= com_db_output($page_content['page_content']) ;
						$oFCKeditor->Create() ;
						
						?>
					</div></td>
				  </tr>
				  <tr><td colspan="2">&nbsp;</td></tr>
				  <tr>
					<td height="25" align="left" colspan="2"><div id="butt" style="display:none;"><input type="submit" value="Save" class="submitButton">&nbsp;<input type="button" value="Cancel" class="submitButton" onclick="window.location='page_content.php?selected_menu=content&pID=<?=$pID;?>'" /></div></td>
				  </tr>
				  <tr><td colspan="2">&nbsp;</td></tr>
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
                  <td width="30%" align="left" valign="middle" class="heading-text">Manage Page Content</td>
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
						<td height="25" align="left" class="page-text"><b>Page Name: <?php echo $page_content['page_name']; ?></b></td>
					  </tr>
					  <tr><td>&nbsp;</td></tr>
					  <tr> 
						<td height="25" align="left" class="page-text"><b>Page Content:</b></td>
					  </tr>
					  <tr>
						<td class="page-text"><?=com_db_output($page_content['page_content'])?></td>
					  </tr>
					  <tr><td>&nbsp;</td></tr>
					  <tr><td><input type="button" value="Back" class="submitButton" onclick="window.location='page_content.php?selected_menu=content'" /></td></tr>
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
} elseif($action=='add'){
?>
<script type="text/javascript">
function pagecheck(){
	var pname=document.getElementById('pname').value;
	if(pname==''){
		alert('Please enter page name');
		document.getElementById('pname').focus();
		return false;
	}

}
</script>
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right">
			  <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="30%" align="left" valign="middle" class="heading-text"><span class="pageHeading">Manage Page Content</span></td>
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
				  <tr align="left"> 
					<td height="25" colspan="2" align="left">&nbsp;<b><?php echo $page_content['page_name']; ?></b></td>
				  </tr>
				  <tr> 
					<td height="25" colspan="2">&nbsp;</td>
				  </tr>
				  <form action="<?php echo $current_page; ?>?selected_menu=content&pID=<?php echo $pID ?>&action=addsave" method="post" onsubmit="return pagecheck();">
				  &nbsp;
				  
				  <tr><td align="left" colspan="2" class="page-text">Page Name</td></tr>
                  <tr>
                  	<td align="left">&nbsp;</td>
                    <td width="96%" align="left"><input type="text" name="pname" id="pname" />.php</td>
                  </tr>
				  
                  <tr><td align="left" colspan="2" class="page-text">Page Title</td></tr>
                  <tr>
                  	<td align="left">&nbsp;</td>
                    <td width="96%" align="left"><input name="page_title" size="80" id="page_title" /></td>
                  </tr>
				  <tr><td colspan="2">&nbsp;</td></tr>
				  <tr><td  class="page-text" colspan="2" align="left">Page Content </td></tr>
				  <tr><td colspan="2">&nbsp;</td></tr>
				  <tr>
				   <td width="4%" valign="top" align="left">&nbsp;</td>
				  <td height="25" align="left"><div id="loading"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1">Please wait<br>						<br>
					  </font><strong><font color="#993300" face="Verdana, Arial, Helvetica, sans-serif" >Editor 
					  Loading......</font></strong><br>
					  <br></div> <div id="fck" style="">  
					  <!---------------------------->
					  
						<?php
						$oFCKeditor = new FCKeditor('page_desc') ;
						$oFCKeditor->BasePath	= $sBasePath ;
						$oFCKeditor->ToolbarSet = ''; // Basic
						$oFCKeditor->Width  = '87%';
						$oFCKeditor->Height  = '400';       
						$oFCKeditor->Value		= '' ;
						$oFCKeditor->Create() ;
						
						?>
					</div></td>
				  </tr>
				  <tr><td colspan="2">&nbsp;</td></tr>
				  <tr>
					<td height="25" align="left" colspan="2"><div id="butt" style="display:block;"><input type="submit" value="Save" class="submitButton">&nbsp;<input type="button" value="Cancel" class="submitButton" onclick="window.location='page_content.php?selected_menu=content&pID=<?=$pID;?>'" /></div></td>
				  </tr>
				  <tr><td colspan="2">&nbsp;</td></tr>
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




<?php
}
include("includes/footer.php");
?>
