<?php
require('includes/include_top.php');

$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 5;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';


$sql_query = "select * from " . TABLE_INDUSTRY . " where parent_id = 0 order by add_date desc";
/***************** FOR PAGIN ***********************/
$starting_point = $items_per_page * ($p - 1);
/****************** END PAGIN ***********************/
$main_page = 'industries.php';

$exe_query=com_db_query($sql_query);
$num_rows=com_db_num_rows($exe_query);
$total_data = $num_rows;

/************ FOR PAGIN **************/
$sql_query .= " LIMIT $starting_point,$items_per_page";
$exe_data = com_db_query($sql_query);

$numRows = com_db_num_rows($exe_data);
/************ END ********************/


$mID = (isset($_REQUEST['mID']) ? $_REQUEST['mID'] : $select_data[0]);
$pID = (isset($_REQUEST['pID']) ? $_REQUEST['pID'] : $select_data[0]);

    switch ($action) {
		
	  case 'delete':
	   		
			com_db_query("delete from " . TABLE_INDUSTRY . " where industry_id = '" . $mID . "'");
		 	com_redirect("industries.php?p=" . $p . "&selected_menu=industries&msg=" . msg_encode("Data deleted successfully"));
		
		break;
		
	  case 'alldelete':
	   		
			$industry_id = $_POST['mid'];
			for($i=0; $i< sizeof($industry_id) ; $i++){
				
				com_db_query("delete from " . TABLE_INDUSTRY . " where industry_id = '" . $industry_id[$i] . "'");
			}
		 	com_redirect("industries.php?p=" . $p . "&selected_menu=industries&msg=" . msg_encode("Industries deleted successfully"));
		
		break;	
		
	  case 'edit':
     		
	   		$query_edit=com_db_query("select * from " . TABLE_INDUSTRY . " where industry_id = '" . $mID . "'");
	  		$data_edit=com_db_fetch_array($query_edit);
			
			$content=com_db_output($data_edit['content']);
			$title=com_db_output($data_edit['title']);
			$parent_id=com_db_output($data_edit['parent_id']);
			
		break;	
		
		case 'editsave':
			
			$title=com_db_input($_POST['title']);
			$content=com_db_input($_POST['content']);
			
			$query = "update " . TABLE_INDUSTRY . " set parent_id = '" . $pID . "', title = '" . $title . "', content = '" . $content . "' where industry_id = '" . $mID . "'";
			com_db_query($query);
	  		com_redirect("industries.php?p=". $p ."&mID=" . $mID . "&selected_menu=industries&msg=" . msg_encode("Industries update successfully"));
		 
		break;		
		
	  
		
	case 'addsave':
			
			$title=com_db_input($_POST['title']);
			$content=com_db_input($_POST['content']);
			
			$added=time();
			
			$query = "insert into " . TABLE_INDUSTRY . " (parent_id, title, content, add_date, status) values ('$pID', '$title', '$content', '$added', '0')";
			com_db_query($query);
	  		com_redirect("industries.php?p=" . $p . "&selected_menu=industries&msg=" . msg_encode("New Industries added successfully"));
		 
		break;	
		
	case 'detailes':
			
			$query_edit=com_db_query("select * from " . TABLE_INDUSTRY . " where industry_id = '" . $mID . "'");
	  		$data_edit=com_db_fetch_array($query_edit);
			
			$content=com_db_output($data_edit['content']);
			$title=com_db_output($data_edit['title']);
			$post_date=date('d, M Y',($data_edit['add_date']));
			
		break;	
	case 'activate':
     		
	   		$status=$_GET['status'];
			if($status==0){
				$query = "update " . TABLE_INDUSTRY . " set status = '1' where industry_id = '" . $mID . "'";
			}else{
				$query = "update " . TABLE_INDUSTRY . " set status = '0' where industry_id = '" . $mID . "'";
			}	
			com_db_query($query);
	  		com_redirect("industries.php?p=". $p ."&mID=" . $mID . "&selected_menu=industries&msg=" . msg_encode("Industries update successfully"));
			
		break;
	
    }
	


include("includes/header.php");
?>
<script type="text/javascript">
function confirm_del(mid,p){
	var agree=confirm("Industries will be deleted. \n Do you want to continue?");
	if (agree)
		window.location = "industries.php?selected_menu=industries&mID=" + mid + "&p=" + p + "&action=delete";
	else
		window.location = "industries.php?selected_menu=industries&mID=" + mid + "&p=" + p ;
}

function confirm_artivate(mid,p,status){
	if(status=='1'){
		var msg="Industries will be active. \n Do you want to continue?";
	}else{
		var msg="Industries will be Inactive. \n Do you want to continue?";
	}
	var agree=confirm(msg);
	if (agree)
		window.location = "industries.php?selected_menu=industries&mID=" + mid + "&p=" + p + "&status=" + status + "&action=activate";
	else
		window.location = "industries.php?selected_menu=industries&mID=" + mid + "&p=" + p ;
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

		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
          <tr>
            <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="32%" align="left" valign="middle" class="heading-text">Industries Manage</td>
                  <td width="45%" align="left" valign="middle" class="message"><?=$msg?></td>
			
                  <td width="3%" align="right" valign="middle"><a href="javascript:void('0')"><img src="images/add-icon.jpg" border="0" width="25" height="28" alt="Add New" title="Add New" onclick="window.location='industries.php?action=add&selected_menu=industries'"  /></a></td>
                  <td width="9%" align="left" valign="middle" class="nav-text">Add New </td>
                  
                </tr>
              </table></td>
          </tr>
       
          <tr>
            <td align="left" valign="top" class="right-bar-content-border">
			<form name="topicform" action="industries.php?action=alldelete&selected_menu=industries" method="post">
			<table width="100%" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="22" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-title-text">#</span></td>
				<td width="527" height="30" align="center" valign="middle" class="right-border"><span class="heading-text">Industries Name</span></td>
				<td width="99" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Date</span> </td>
				<td width="229" height="30" align="center" valign="middle" class="left-border"><div align="center"><span class="right-box-title-text">Action</span></div></td>
			  </tr>
			<?php
			
			if($total_data>0) {
				$i=1;
				while ($data_sql = com_db_fetch_array($exe_data)) {
				$added_date = date('d, M Y',$data_sql['add_date']);
				$status = $data_sql['status'];
				
				
			?>          
			  <tr>
				<td height="30" align="center" valign="middle" class="right-border-left"><?=$i;?></td>
				
				<td height="30" align="left" valign="middle" class="right-border-text"><a href="industries.php?action=detailes&selected_menu=industries&mID=<?=$data_sql['industry_id'];?>"><?=com_db_output($data_sql['title'])?></a></td>
				<td height="30" align="center" valign="middle" class="right-border"><?=$added_date;?></td>
				<td height="30" align="center" valign="middle" class="left-border">
					<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr> 
					  	<?php if($status==0){ ?>
					   	<td width="30%" align="center" valign="middle"><a href="javascript:void('0')"><img src="images/icon/active-icon.gif" width="16" height="16" alt="" title="" border="0" onclick="confirm_artivate('<?=$data_sql['industry_id'];?>','<?=$p;?>','<?=$status;?>');" /></a><br />
					   	  Status</td>
					   	<?php } elseif($status==1){ ?>
					   	<td width="24%" align="center" valign="middle"><a href="javascript:void('0')"><img src="images/icon/inactive-icon.gif" width="16" height="16" alt="" title="" border="0" onclick="confirm_artivate('<?=$data_sql['industry_id'];?>','<?=$p;?>','<?=$status;?>');" /></a><br />
					   	  Status</td>
						<?php } ?>
						<td width="21%" align="center" valign="middle"><a href="javascript:void('0')"><img src="images/small-edit-icon.gif" width="16" height="16" alt="Edit" title="Edit" border="0" onclick="window.location='industries.php?selected_menu=industries&p=<?=$p;?>&mID=<?=$data_sql['industry_id'];?>&action=edit'" /></a><br />
						  Edit</td>
						<td width="25%" align="center" valign="middle"><a href="javascript:void('0')"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" title="Delete" border="0" onclick="confirm_del('<?=$data_sql['industry_id'];?>','<?=$p;?>')" /></a><br />
						  Delete</td>
					  </tr>
					</table>				</td>
         	</tr> 
			<?php
			$i++;
			$sub_menu_query=com_db_query("select * from " . TABLE_INDUSTRY . " where parent_id = '" . $data_sql['industry_id'] . "'");
			$sub_menu_num_rows=com_db_num_rows($sub_menu_query);
			if($sub_menu_num_rows!=0){
			  while($sub_menu_data=com_db_fetch_array($sub_menu_query)){
			  	$sub_added_date = date('d, M Y',$sub_menu_data['add_date']);
				$sub_status = $sub_menu_data['status'];
			?>
			
			
				  <tr>
				<td height="30" align="center" valign="middle" class="right-border-left"><?=$i;?></td>
				<td height="30" align="left" valign="middle" class="right-border-text">&nbsp;&nbsp;&nbsp;&nbsp;<a href="industries.php?action=detailes&selected_menu=industries&mID=<?=$sub_menu_data['industry_id'];?>"><?=com_db_output($sub_menu_data['title'])?></a></td>
				<td height="30" align="center" valign="middle" class="right-border"><?=$sub_added_date;?></td>
				<td height="30" align="center" valign="middle" class="left-border">
					<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr> 
					  	<?php if($status==0){ ?>
					   	<td width="30%" align="center" valign="middle"><a href="javascript:void('0')"><img src="images/icon/active-icon.gif" width="16" height="16" alt="" title="" border="0" onclick="confirm_artivate('<?=$sub_menu_data['industry_id'];?>','<?=$p;?>','<?=$sub_status;?>');" /></a><br />
					   	  Status</td>
					   	<?php } elseif($sub_status==1){ ?>
					   	<td width="24%" align="center" valign="middle"><a href="javascript:void('0')"><img src="images/icon/inactive-icon.gif" width="16" height="16" alt="" title="" border="0" onclick="confirm_artivate('<?=$sub_menu_data['industry_id'];?>','<?=$p;?>','<?=$sub_status;?>');" /></a><br />
					   	  Status</td>
						<?php } ?>
						<td width="22%" align="center" valign="middle"><a href="javascript:void('0')"><img src="images/small-edit-icon.gif" width="16" height="16" alt="Edit" title="Edit" border="0" onclick="window.location='industries.php?selected_menu=industries&p=<?=$p;?>&mID=<?=$sub_menu_data['industry_id'];?>&action=edit'" /></a><br />
						  Edit</td>
						<td width="24%" align="center" valign="middle"><a href="javascript:void('0')"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" title="Delete" border="0" onclick="confirm_del('<?=$sub_menu_data['industry_id'];?>','<?=$p;?>')" /></a><br />
						  Delete</td>
					  </tr>
					</table>				</td>
         	</tr> 
			
			
			<?php
				$i++;
				}
			}
			
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
		<?php echo number_pages($main_page, $p, $total_data, 8, $items_per_page);?>		  
          </tr>
        </table></td>
        <td width="314" align="center" valign="bottom">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  
<?php } elseif($action=='edit'){ ?>			

		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">Industries :: Edit </td>
				  
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top"  class="right-bar-content-border-box"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="left" valign="top">
		 <!--start iner table  -->
			<table width="95%" align="left" cellpadding="5" cellspacing="5" border="0">
			<form name="DateTest" method="post" action="industries.php?selected_menu=industries&action=editsave&mID=<?=$mID;?>&p=<?=$p;?>" onsubmit="return chk_form();">
			
			
			<tr>
			  <td width="20%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;&nbsp;Select <span class="heading-text">Industries</span>:</td>
			  <td width="80%" align="left" valign="top">
			  <select name="pID" id="pID">
			  <option value="0">Main Industries</option>
			  <?php
			  $select_menu_query=com_db_query("select * from " . TABLE_INDUSTRY . " where parent_id = '0'");
			  while($select_menu_data=com_db_fetch_array($select_menu_query)){
			  ?>
			  <option value="<?=$select_menu_data['industry_id'];?>" <?php if($parent_id==$select_menu_data['industry_id']) echo 'selected';?>><?=com_db_output($select_menu_data['title']);?></option>
			  <?php
			  }
			  ?>
			  </select>
			  </td>	
			</tr>
			<tr>
			  <td width="20%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Name:</td>
			  <td width="80%" align="left" valign="top">
				<input type="text" name="title" id="title" size="80" value="<?=$title;?>" />
			  </td>	
			</tr>
			
			<tr><td align="left" valign="top">&nbsp;</td><td align="left" valign="top"><input type="submit" value="Update" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='industries.php?p=<?=$p;?>&mID=<?=$mID;?>&selected_menu=industries'" /></td></tr>
			</form>
			</table>
		 <!-- end inner table -->
		  </td>
		 </tr>
            </table></td>
		 </tr>
        </table></td>
          </tr>
        </table>
		
<?php		
} elseif($action=='add'){
?>		
<script language="javascript" type="text/javascript">
function chk_form(){
	var title=document.getElementById('title').value;
	if(title==''){
	alert("Please enter title.");
	document.getElementById('title').focus();
	return false;
	}

}
</script>
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">Industries :: Add new</td>
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="left" valign="top" class="right-border-box">
		 <!--start iner table  -->
		  <table width="95%" align="left" cellpadding="5" cellspacing="5" border="0">
		<form name="DateTest" method="post" action="industries.php?selected_menu=industries&action=addsave&p=<?=$p;?>" onsubmit="return chk_form();">
		
		<tr>
		  <td width="20%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;&nbsp;Select Industries:</td>
		  <td width="80%" align="left" valign="top">
		  <select name="pID" id="pID">
		  <option value="0">Main Industries</option>
		  <?php
		  $select_menu_query=com_db_query("select * from " . TABLE_INDUSTRY . " where parent_id = '0'");
		  while($select_menu_data=com_db_fetch_array($select_menu_query)){
		  ?>
		  <option value="<?=$select_menu_data['industry_id'];?>"><?=com_db_output($select_menu_data['title']);?></option>
		  <?php
		  }
		  ?>
		  </select>
		  </td>	
		</tr>
		
		<tr>
		  <td width="20%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;&nbsp;Name:</td>
		  <td width="80%" align="left" valign="top">
			<input type="text" name="title" id="title" size="80" />
		  </td>	
		</tr>
		<tr><td align="left" valign="top">&nbsp;</td><td align="left" valign="top"><input type="submit" value="Add Industries" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='industries.php?p=<?=$p;?>&mID=<?=$mID;?>&selected_menu=industries'" /></td></tr>
		</form>
		</table>
		 <!-- end inner table -->
		  </td>
		 </tr>
            </table></td>
		 </tr>
        </table></td>
          </tr>
        </table>		
<?php
} elseif($action=='detailes'){
?>		
  	  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">Industries :: Details </td>
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
			  <td align="left" valign="top" class="page-text"><strong><?=$title;?></strong><br /><br /><?=$post_date?></td>
			</tr>
			<tr>
				<td align="left" valign="top" class="page-text"><?=$content;?></td>
			</tr>
			<tr>
				<!--<td align="left" valign="top">&nbsp;</td> -->
				<td align="left" valign="top"><input type="button" class="submitButton" value="Back" onclick="window.location='industries.php?p=<?=$p;?>&mID=<?=$mID;?>&selected_menu=industries'" /></td>
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
<?php
}
include("includes/footer.php");
?>