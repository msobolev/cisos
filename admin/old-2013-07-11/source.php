<?php
require('includes/include_top.php');

$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 20;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';


$sql_query = "select * from " . TABLE_SOURCE . " order by id desc";
/***************** FOR PAGIN ***********************/
$starting_point = $items_per_page * ($p - 1);
/****************** END PAGIN ***********************/
$main_page = 'source.php';

$exe_query=com_db_query($sql_query);
$num_rows=com_db_num_rows($exe_query);
$total_data = $num_rows;

/************ FOR PAGIN **************/
$sql_query .= " LIMIT $starting_point,$items_per_page";
$exe_data = com_db_query($sql_query);

$numRows = com_db_num_rows($exe_data);
/************ END ********************/


$tID = (isset($_GET['tID']) ? $_GET['tID'] : $select_data[0]);

    switch ($action) {
		
	  case 'delete':
	   		
			com_db_query("delete from " . TABLE_SOURCE . " where id = '" . $tID . "'");
		 	com_redirect("source.php?p=" . $p . "&selected_menu=others&msg=" . msg_encode("Source deleted successfully"));
		
		break;
		
	  case 'alldelete':
	   		$id = $_POST['nid'];
			for($i=0; $i< sizeof($id) ; $i++){
				com_db_query("delete from " . TABLE_SOURCE . " where id = '" . $id[$i] . "'");
			}
		 	com_redirect("source.php?p=" . $p . "&selected_menu=others&msg=" . msg_encode("Source deleted successfully"));
		
		break;	
		
	  case 'edit':
     		
	   		$query_edit = com_db_query("select * from " . TABLE_SOURCE . " where id = '" . $tID . "'");
	  		$data_edit = com_db_fetch_array($query_edit);
			$source = com_db_output($data_edit['source']);
			
		break;	
		
		case 'editsave':
			
			$source = com_db_input($_POST['source']);
			
			$modify_date = date('Y-m-d');
			
			$query = "update " . TABLE_SOURCE . " set source = '" . $source . "', modify_date = '".$modify_date."' where id = '" . $tID . "'";
			com_db_query($query);
			
			com_redirect("source.php?p=". $p ."&tID=" . $tID . "&selected_menu=others&msg=" . msg_encode("Source update successfully"));
		 
		break;		
		
	  
		
	case 'addsave':
			
			$source = com_db_input($_POST['source']);
			$add_date = date('Y-m-d');
			
			$query = "insert into " . TABLE_SOURCE . " (source, add_date, status) values ('$source', '$add_date', '0')";
			com_db_query($query);
					
			com_redirect("source.php?p=" . $p . "&selected_menu=others&msg=" . msg_encode("Source added successfully"));
		 
		break;	
		
	case 'detailes':
			
			$query_edit=com_db_query("select * from " . TABLE_SOURCE . " where id = '" . $tID . "'");
	  		$data_edit=com_db_fetch_array($query_edit);
			
			$source = com_db_output($data_edit['source']);
			$add_date =explode('-',$data_edit['add_date']);
			$post_date = date('d, M Y',mktime(0,0,0,date($add_date[1]),date($add_date[2]),date($add_date[0])));
			
		break;	
	case 'activate':
     		
	   		$status=$_GET['status'];
			if($status==0){
				$query = "update " . TABLE_SOURCE . " set status = '1' where id = '" . $tID . "'";
			}else{
				$query = "update " . TABLE_SOURCE . " set status = '0' where id = '" . $tID . "'";
			}	
			com_db_query($query);
	  		com_redirect("source.php?p=". $p ."&tID=" . $tID . "&selected_menu=others&msg=" . msg_encode("Source update successfully"));
			
		break;
				
    }
	


include("includes/header.php");
?>
<script type="text/javascript">
function confirm_del(nid,p){
	var agree=confirm("Source will be deleted. \n Do you want to continue?");
	if (agree)
		window.location = "source.php?selected_menu=others&tID=" + nid + "&p=" + p + "&action=delete";
	else
		window.location = "source.php?selected_menu=others&tID=" + nid + "&p=" + p ;
}

function CheckAll(numRows){
	if(document.getElementById('all').checked){
		for(i=1; i<=numRows; i++){
			var id='id-'+ i;
			document.getElementById(id).checked=true;
		}
	} else {
		for(i=1; i<=numRows; i++){
			var id='id-'+ i;
			document.getElementById(id).checked=false;
		}
	}
}

function AllDelete(numRows){

	var flg=0;
	for(i=1; i<=numRows; i++){
			var id='id-'+ i;
			if(document.getElementById(id).checked){
				flg=1;
			}	
		}
	if(flg==0){
		alert("Please checked atlist one checkbox for delete.");
		document.getElementById('id-1').focus();
		return false;
	} else {
		var agree=confirm("Source will be deleted. \n Do you want to continue?");
		if (agree)
			 document.topicform.submit();
		else
			window.location = "source.php?selected_menu=others";
	}	

}

function confirm_artivate(nid,p,status){
	if(status=='1'){
		var msg="Source will be active. \n Do you want to continue?";
	}else{
		var msg="Source will be Inactive. \n Do you want to continue?";
	}
	var agree=confirm(msg);
	if (agree)
		window.location = "source.php?selected_menu=others&tID=" + nid + "&p=" + p + "&status=" + status + "&action=activate";
	else
		window.location = "source.php?selected_menu=others&tID=" + nid + "&p=" + p ;
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
                  <td width="30%" align="left" valign="middle" class="heading-text">Source Manager</td>
                  <td width="34%" align="left" valign="middle" class="message"><?=$msg?></td>
                  <td width="8%" align="right" valign="middle"><a href="#"><img src="images/add-icon.jpg" border="0" width="25" height="28" alt="Add Source" source="Add Source" onclick="window.location='source.php?action=add&selected_menu=others'"  /></a></td>
                  <td width="8%" align="left" valign="middle" class="nav-text">Add New </td>
                  <td width="4%" align="right" valign="middle"><a href="#"><img src="images/delete-icon.jpg" border="0" width="25" height="28"  alt="Delete Source" source="Delete Source" onclick="AllDelete('<?=$numRows?>');"  /></a></td>
                  <td width="8%" align="left" valign="middle" class="nav-text">Delete</td>
                </tr>
              </table></td>
          </tr>
       
          <tr>
            <td align="left" valign="top" class="right-bar-content-border">
			<form name="topicform" action="source.php?action=alldelete&selected_menu=others" method="post">
			<table width="100%" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="34" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-source-text">#</span></td>
				<td width="36" height="30" align="center" valign="middle" class="right-border">
				<input type="checkbox" name="all" id="all" onclick="CheckAll('<?=$numRows?>');" /></td>
				<td width="473" height="30" align="center" valign="middle" class="right-border"><span class="right-box-source-text">Source</span> </td>
				<td width="182" height="30" align="center" valign="middle" class="right-border"><span class="right-box-source-text">Date</span> </td>
				<td width="236" height="30" align="center" valign="middle" class="left-border"><div align="center"><span class="right-box-source-text">Action</span></div></td>
			  </tr>
			<?php
			
			if($total_data>0) {
				$i=1;
				while ($data_sql = com_db_fetch_array($exe_data)) {
				$added_date = $data_sql['add_date'];
				$status = $data_sql['status'];
				
			?>          
			  <tr>
				<td height="30" align="center" valign="middle" class="right-border-left"><?=$i;?></td>
				<td height="30" align="center" valign="middle" class="right-border"><input type="checkbox" id="id-<?=$i;?>" name="nid[]" value="<?=$data_sql['id'];?>" /></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><a href="source.php?action=detailes&selected_menu=others&tID=<?=$data_sql['id'];?>"><?=com_db_output($data_sql['source'])?></a></td>
				<td height="30" align="center" valign="middle" class="right-border"><?=$added_date;?></td>
				<td height="30" align="center" valign="middle" class="left-border">
					<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr> 
					  	<?php if($status==0){ ?>
					   	<td width="29%" align="center" valign="middle"><a href="#"><img src="images/icon/active-icon.gif" width="16" height="16" alt="" source="" border="0" onclick="confirm_artivate('<?=$data_sql['id'];?>','<?=$p;?>','<?=$status;?>');" /></a><br />
					   	  Status</td>
					   	<?php } elseif($status==1){ ?>
					   	<td width="24%" align="center" valign="middle"><a href="#"><img src="images/icon/inactive-icon.gif" width="16" height="16" alt="" source="" border="0" onclick="confirm_artivate('<?=$data_sql['id'];?>','<?=$p;?>','<?=$status;?>');" /></a><br />
					   	  Status</td>
						<?php } ?>
						<td width="23%" align="center" valign="middle"><a href="#"><img src="images/small-edit-icon.gif" width="16" height="16" alt="Edit" source="Edit" border="0" onclick="window.location='source.php?selected_menu=others&p=<?=$p;?>&tID=<?=$data_sql['id'];?>&action=edit'" /></a><br />
						  Edit</td>
						<td width="24%" align="center" valign="middle"><a href="#"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" source="Delete" border="0" onclick="confirm_del('<?=$data_sql['id'];?>','<?=$p;?>')" /></a><br />
						  Delete</td>
					  </tr>
					</table>				</td>
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
                  <td width="50%" align="left" valign="middle" class="heading-text">Source Manager :: Edit </td>
				  
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
			<form name="DateTest" method="post" action="source.php?action=editsave&selected_menu=others&tID=<?=$tID;?>&p=<?=$p;?>" enctype="multipart/form-data" onsubmit="return chk_form();">
            <tr>
			  <td width="15%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Source:</td>
			  <td width="85%" align="left" valign="top">
				<input type="text" name="source" id="source" size="35" value="<?=$source;?>" />			  </td>	
			</tr>
			
			<tr><td align="left" valign="top">&nbsp;</td><td align="left" valign="top"><input type="submit" value="Update Source" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='source.php?p=<?=$p;?>&tID=<?=$tID;?>&selected_menu=others'" /></td></tr>
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
	var source=document.getElementById('source').value;
	if(source==''){
	alert("Please enter news source.");
	document.getElementById('source').focus();
	return false;
	}

}
</script>
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">Source Manager :: Add</td>
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
		<form name="DateTest" method="post" action="source.php?action=addsave&p=<?=$p;?>" onsubmit="return chk_form();">
        <tr>
		  <td width="15%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Source:</td>
		  <td width="90%" align="left" valign="top">
			<input type="text" name="source" id="source" size="35" value="" />		  </td>	
		</tr>
		
		<tr><td align="left" valign="top">&nbsp;</td><td align="left" valign="top"><input type="submit" value="Add Source" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='source.php?p=<?=$p;?>&tID=<?=$tID;?>&selected_menu=others'" /></td></tr>
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
                  <td width="50%" align="left" valign="middle" class="heading-text">Source Manager ::  Details </td>
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
			  <td align="left" valign="top" class="page-text"><strong><?=$source;?></strong><br /><br /><?=$post_date?><br /><br />
			  Source : <?=$source?><br /></td>
			</tr>
			<tr>
				<!--<td align="left" valign="top">&nbsp;</td> -->
				<td align="left" valign="top"><input type="button" class="submitButton" value="Back" onclick="window.location='source.php?p=<?=$p;?>&tID=<?=$tID;?>&selected_menu=others'" /></td>
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