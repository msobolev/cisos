<?php
require('includes/include_top.php');

$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 20;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';


$sql_query = "select * from " . TABLE_WHITE_PAPER . " order by paper_id desc";
/***************** FOR PAGIN ***********************/
$starting_point = $items_per_page * ($p - 1);
/****************** END PAGIN ***********************/
$main_page = 'white-paper.php';

$exe_query=com_db_query($sql_query);
$num_rows=com_db_num_rows($exe_query);
$total_data = $num_rows;

/************ FOR PAGIN **************/
$sql_query .= " LIMIT $starting_point,$items_per_page";
$exe_data = com_db_query($sql_query);

$numRows = com_db_num_rows($exe_data);
/************ END ********************/


$pID = (isset($_GET['pID']) ? $_GET['pID'] : $select_data[0]);

    switch ($action) {
		
	  case 'delete':
	   		
			com_db_query("delete from " . TABLE_WHITE_PAPER . " where paper_id = '" . $pID . "'");
		 	com_redirect("white-paper.php?p=" . $p . "&selected_menu=others&msg=" . msg_encode("White paper deleted successfully"));
		
		break;
		
	  case 'alldelete':
	   		$paper_id = $_POST['nid'];
			for($i=0; $i< sizeof($paper_id) ; $i++){
				com_db_query("delete from " . TABLE_WHITE_PAPER . " where paper_id = '" . $paper_id[$i] . "'");
			}
		 	com_redirect("white-paper.php?p=" . $p . "&selected_menu=others&msg=" . msg_encode("White paper deleted successfully"));
		
		break;	
		
	  case 'edit':
     		
	   		$query_edit=com_db_query("select * from " . TABLE_WHITE_PAPER . " where paper_id = '" . $pID . "'");
	  		$data_edit=com_db_fetch_array($query_edit);
			$paper_name=com_db_output($data_edit['paper_name']);
			$download_path=com_db_output($data_edit['download_path']);
			
			
		break;	
		
		case 'editsave':
			
			$paper_name=com_db_input($_POST['paper_name']);
			$download_path = str_replace(' ','-', $_POST['download_path']);
			$modify_date = date('Y-m-d');
			
			$isPresent = com_db_GetValue("select download_path from ". TABLE_WHITE_PAPER. " where download_path ='".$download_path."' and paper_id <>'".$pID."'");
			if($isPresent ==''){
				$query = "update " . TABLE_WHITE_PAPER . " set paper_name = '" . $paper_name . "', modify_date = '".$modify_date."' where paper_id = '" . $pID . "'";
				com_db_query($query);
				
				$uploadFile = $_FILES['upload_file']['tmp_name'];
			  
				if($uploadFile!=''){
					if(is_uploaded_file($uploadFile)){
						if($download_path ==''){
							$org_file = $_FILES['upload_file']['name'];
						}else{
							$org_file = $download_path ;//$_FILES['upload_file']['name'];
						}	
						//$exp_file = explode("." , $org_file);
						//$get_ext = $exp_file[count($exp_file) - 1];
						//if($get_ext=="jpg" || $get_ext=="gif" || $get_ext=="jpge"){
							//$org_image_name=$exp_file[0].'-'.time().'.'.$get_ext;
							$destination_file = '../white_paper/' . $org_file;
							if(move_uploaded_file($uploadFile , $destination_file)){
								$query = "UPDATE " . TABLE_WHITE_PAPER . " SET download_path = '" . $org_file . "' WHERE paper_id = '" . $pID ."'";
								com_db_query($query);
							}
						//}	
					}	
				}
	  			com_redirect("white-paper.php?p=". $p ."&pID=" . $pID . "&selected_menu=others&msg=" . msg_encode("White paper update successfully"));
		 	}else{
				com_redirect("white-paper.php?p=" . $p . "&selected_menu=others&msg=" . msg_encode("White paper URL allready present"));
			}
		break;		
		
	  
		
	case 'addsave':
			
			$paper_name = com_db_input($_POST['paper_name']);
			$download_path = str_replace(' ','-',$_POST['download_path']);
			$add_date = date('Y-m-d');
			$isPresent = com_db_GetValue("select download_path from ". TABLE_WHITE_PAPER. " where download_path ='".$download_path."'");
			if($isPresent ==''){
				$query = "insert into " . TABLE_WHITE_PAPER . " (paper_name, add_date, status) values ('$paper_name', '$add_date', '0')";
				com_db_query($query);
				$insert_id = com_db_insert_id();
				
				$uploadFile = $_FILES['upload_file']['tmp_name'];
				  
				if($uploadFile!=''){
					if(is_uploaded_file($uploadFile)){
						if($download_path ==''){
							$org_file = $_FILES['upload_file']['name'];
						}else{
							$org_file = $download_path ;//$_FILES['upload_file']['name'];
						}	
						//$exp_file = explode("." , $org_file);
						//$get_ext = $exp_file[count($exp_file) - 1];
						//if($get_ext=="jpg" || $get_ext=="gif" || $get_ext=="jpge"){
							//$org_image_name=$exp_file[0].'-'.time().'.'.$get_ext;
							$destination_file = '../white_paper/' . $org_file;
							if(move_uploaded_file($uploadFile , $destination_file)){
								$query = "UPDATE " . TABLE_WHITE_PAPER . " SET download_path = '" . $org_file . "' WHERE paper_id = '" . $insert_id ."'";
								com_db_query($query);
							}
						//}	
					}	
				}
	  	 		com_redirect("white-paper.php?p=" . $p . "&selected_menu=others&msg=" . msg_encode("White paper added successfully"));
		 	}else{
				com_redirect("white-paper.php?p=" . $p . "&selected_menu=others&msg=" . msg_encode("White paper URL allready present"));
			}
		break;	
		
	case 'detailes':
			
			$query_edit=com_db_query("select * from " . TABLE_WHITE_PAPER . " where paper_id = '" . $pID . "'");
	  		$data_edit=com_db_fetch_array($query_edit);
			
			$paper_name=com_db_output($data_edit['paper_name']);
			$add_date =explode('-',$data_edit['add_date']);
			$post_date = date('d, M Y',mktime(0,0,0,date($add_date[1]),date($add_date[2]),date($add_date[0])));
			$download_path = $data_edit['download_path'];
		break;	
	case 'activate':
     		
	   		$status=$_GET['status'];
			if($status==0){
				$query = "update " . TABLE_WHITE_PAPER . " set status = '1' where paper_id = '" . $pID . "'";
			}else{
				$query = "update " . TABLE_WHITE_PAPER . " set status = '0' where paper_id = '" . $pID . "'";
			}	
			com_db_query($query);
	  		com_redirect("white-paper.php?p=". $p ."&pID=" . $pID . "&selected_menu=others&msg=" . msg_encode("White paper update successfully"));
			
		break;
				
    }
	


include("includes/header.php");
?>
<script type="text/javascript">
function confirm_del(nid,p){
	var agree=confirm("White paper will be deleted. \n Do you want to continue?");
	if (agree)
		window.location = "white-paper.php?selected_menu=others&pID=" + nid + "&p=" + p + "&action=delete";
	else
		window.location = "white-paper.php?selected_menu=others&pID=" + nid + "&p=" + p ;
}

function CheckAll(numRows){
	if(document.getElementById('all').checked){
		for(i=1; i<=numRows; i++){
			var paper_id='paper_id-'+ i;
			document.getElementById(paper_id).checked=true;
		}
	} else {
		for(i=1; i<=numRows; i++){
			var paper_id='paper_id-'+ i;
			document.getElementById(paper_id).checked=false;
		}
	}
}

function AllDelete(numRows){

	var flg=0;
	for(i=1; i<=numRows; i++){
			var paper_id='paper_id-'+ i;
			if(document.getElementById(paper_id).checked){
				flg=1;
			}	
		}
	if(flg==0){
		alert("Please checked atlist one checkbox for delete.");
		document.getElementById('paper_id-1').focus();
		return false;
	} else {
		var agree=confirm("White paper will be deleted. \n Do you want to continue?");
		if (agree)
			 document.topicform.submit();
		else
			window.location = "white-paper.php?selected_menu=others";
	}	

}

function confirm_artivate(nid,p,status){
	if(status=='1'){
		var msg="White paper will be active. \n Do you want to continue?";
	}else{
		var msg="White paper will be Inactive. \n Do you want to continue?";
	}
	var agree=confirm(msg);
	if (agree)
		window.location = "white-paper.php?selected_menu=others&pID=" + nid + "&p=" + p + "&status=" + status + "&action=activate";
	else
		window.location = "white-paper.php?selected_menu=others&pID=" + nid + "&p=" + p ;
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
                  <td width="30%" align="left" valign="middle" class="heading-text">White Paper Manager</td>
                  <td width="34%" align="left" valign="middle" class="message"><?=$msg?></td>
                  <? if($btnAdd=='Yes'){ ?>
                  <td width="8%" align="right" valign="middle"><a href="#"><img src="images/add-icon.jpg" border="0" width="25" height="28" alt="Add White paper" name="Add White paper" onclick="window.location='white-paper.php?action=add&selected_menu=others'"  /></a></td>
                  <td width="8%" align="left" valign="middle" class="nav-text">Add New </td>
                  <? }
				  if($btnDelete=='Yes'){ ?>
                  <td width="4%" align="right" valign="middle"><a href="#"><img src="images/delete-icon.jpg" border="0" width="25" height="28"  alt="Delete White paper" name="Delete White paper" onclick="AllDelete('<?=$numRows?>');"  /></a></td>
                  <td width="8%" align="left" valign="middle" class="nav-text">Delete</td>
                  <? } ?>
                </tr>
              </table></td>
          </tr>
       
          <tr>
            <td align="left" valign="top" class="right-bar-content-border">
			<form name="topicform" action="white-paper.php?action=alldelete&selected_menu=others" method="post">
			<table width="100%" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="23" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-title-text">#</span></td>
				<td width="32" height="30" align="center" valign="middle" class="right-border">
				<input type="checkbox" name="all" id="all" onclick="CheckAll('<?=$numRows?>');" /></td>
				<td width="277" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Name</span> </td>
				<td width="324" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Download Path</span> </td>
				<td width="118" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Date</span> </td>
				<td width="187" height="30" align="center" valign="middle" class="left-border"><div align="center"><span class="right-box-title-text">Action</span></div></td>
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
				<td height="30" align="center" valign="middle" class="right-border"><input type="checkbox" id="paper_id-<?=$i;?>" name="nid[]" value="<?=$data_sql['paper_id'];?>" /></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><a href="white-paper.php?action=detailes&selected_menu=others&pID=<?=$data_sql['paper_id'];?>"><?=com_db_output($data_sql['paper_name'])?></a></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><?=$data_sql['download_path']?></td>
				<td height="30" align="center" valign="middle" class="right-border"><?=$added_date;?></td>
				<td height="30" align="center" valign="middle" class="left-border">
					<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr> 
					  	<?php 
						if($btnStatus=='Yes'){
							if($status==0){ ?>
					   	<td width="29%" align="center" valign="middle"><a href="#"><img src="images/icon/active-icon.gif" width="16" height="16" alt="" name="" border="0" onclick="confirm_artivate('<?=$data_sql['paper_id'];?>','<?=$p;?>','<?=$status;?>');" /></a><br />
					   	  Status</td>
					   	<?php } elseif($status==1){ ?>
					   	<td width="24%" align="center" valign="middle"><a href="#"><img src="images/icon/inactive-icon.gif" width="16" height="16" alt="" name="" border="0" onclick="confirm_artivate('<?=$data_sql['paper_id'];?>','<?=$p;?>','<?=$status;?>');" /></a><br />
					   	  Status</td>
						<?php }
						}
						 if($btnEdit=='Yes'){  ?>
						<td width="23%" align="center" valign="middle"><a href="#"><img src="images/small-edit-icon.gif" width="16" height="16" alt="Edit" name="Edit" border="0" onclick="window.location='white-paper.php?selected_menu=others&p=<?=$p;?>&pID=<?=$data_sql['paper_id'];?>&action=edit'" /></a><br />
						  Edit</td>
                        <? } 
						if($btnDelete=='Yes'){ ?>  
						<td width="24%" align="center" valign="middle"><a href="#"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" name="Delete" border="0" onclick="confirm_del('<?=$data_sql['paper_id'];?>','<?=$p;?>')" /></a><br />
						  Delete</td>
                        <? } ?>  
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
                  <td width="50%" align="left" valign="middle" class="heading-text">White Paper Manager :: Edit </td>
				  
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
			<form name="DateTest" method="post" action="white-paper.php?action=editsave&selected_menu=others&pID=<?=$pID;?>&p=<?=$p;?>" enctype="multipart/form-data" onsubmit="return chk_form();">
			<tr>
			  <td width="22%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Name:</td>
			  <td width="78%" align="left" valign="top">
				<input type="text" name="paper_name" id="paper_name" size="40" value="<?=$paper_name;?>" />			  </td>	
			</tr>
			<tr>
			  <td width="22%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;URL:</td>
			  <td width="78%" align="left" valign="top">
				<input type="text" name="download_path" id="download_path" size="40" value="<?=$download_path;?>" />			  </td>	
			</tr>
            <tr>
			  <td width="22%" align="left" class="page-text" valign="top">&nbsp;&nbsp;Upload File:</td>
			  <td width="78%" align="left" valign="top">
              	<? //=$download_path;?><br />
				<input type="file" name="upload_file" id="upload_file" />			  </td>	
			</tr>
			
			<tr><td align="left" valign="top">&nbsp;</td><td align="left" valign="top"><input type="submit" value="Update White paper" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='white-paper.php?p=<?=$p;?>&pID=<?=$pID;?>&selected_menu=others'" /></td></tr>
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
	var name=document.getElementById('name').value;
	if(name==''){
	alert("Please enter news name.");
	document.getElementById('name').focus();
	return false;
	}

}
</script>
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">White Paper Manager :: Add</td>
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
		<form name="DateTest" method="post" action="white-paper.php?action=addsave&p=<?=$p;?>" enctype="multipart/form-data" onsubmit="return chk_form();">
		<tr>
		  <td width="22%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Name:</td>
		  <td width="78%" align="left" valign="top">
			<input type="text" name="paper_name" id="paper_name" size="40" />		  </td>	
		</tr>
		<tr>
		  <td width="22%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;URL:</td>
		  <td width="78%" align="left" valign="top">
			<input type="text" name="download_path" id="download_path" size="40" value="" />			  </td>	
		</tr>
		 <tr>
			  <td width="22%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Upload File:</td>
			  <td width="78%" align="left" valign="top">
				<input type="file" name="upload_file" id="upload_file" />			  </td>	
			</tr>
		
		<tr><td align="left" valign="top">&nbsp;</td><td align="left" valign="top"><input type="submit" value="Add White paper" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='white-paper.php?p=<?=$p;?>&pID=<?=$pID;?>&selected_menu=others'" /></td></tr>
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
                  <td width="50%" align="left" valign="middle" class="heading-text">White Paper Manager ::  Details </td>
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
			  <td align="left" valign="top" class="page-text"><strong><?=$paper_name;?></strong><br /><br /><?=$post_date?></td>
			</tr>
            <tr>
			  <td align="left" valign="top" class="page-text">
			  <?php if(file_exists("../white_paper/".$download_path) && $download_path !=''){	
                echo $download_path.'<br /><br />';
                 } ?>
              </td>
			</tr>
			<tr>
				<td align="left" valign="top" class="page-text"><?=$details;?></td>
			</tr>
			<tr>
				<!--<td align="left" valign="top">&nbsp;</td> -->
				<td align="left" valign="top"><input type="button" class="submitButton" value="Back" onclick="window.location='white-paper.php?p=<?=$p;?>&pID=<?=$pID;?>&selected_menu=others'" /></td>
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