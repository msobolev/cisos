<?php
require('includes/include_top.php');

$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 20;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';


$sql_query = "select * from " . TABLE_SLIDER_SHOW . " order by image_id desc";
/***************** FOR PAGIN ***********************/
$starting_point = $items_per_page * ($p - 1);
/****************** END PAGIN ***********************/
$main_page = 'slider-show.php';

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
	   		
			com_db_query("delete from " . TABLE_SLIDER_SHOW . " where image_id = '" . $pID . "'");
		 	com_redirect("slider-show.php?p=" . $p . "&selected_menu=others&msg=" . msg_encode("Image deleted successfully"));
		
		break;
		
	  case 'alldelete':
	   		$image_id = $_POST['nid'];
			for($i=0; $i< sizeof($image_id) ; $i++){
				com_db_query("delete from " . TABLE_SLIDER_SHOW . " where image_id = '" . $image_id[$i] . "'");
			}
		 	com_redirect("slider-show.php?p=" . $p . "&selected_menu=others&msg=" . msg_encode("Image deleted successfully"));
		
		break;	
		
	  case 'edit':
     		
	   		$query_edit=com_db_query("select * from " . TABLE_SLIDER_SHOW . " where image_id = '" . $pID . "'");
	  		$data_edit=com_db_fetch_array($query_edit);
			$caption = com_db_output($data_edit['caption']);
			$image_path = com_db_output($data_edit['image_path']);
			
			
		break;	
		
		case 'editsave':
			
			$caption=com_db_input($_POST['caption']);
			$modify_date = date('Y-m-d');
			
			$query = "update " . TABLE_SLIDER_SHOW . " set caption = '" . $caption . "' where image_id = '" . $pID . "'";
			com_db_query($query);
			
			$image = $_FILES['image']['tmp_name'];
			  
			if($image!=''){
				if(is_uploaded_file($image)){
					$org_img = $_FILES['image']['name'];
					$exp_file = explode("." , $org_img);
					$get_ext = $exp_file[count($exp_file) - 1];
					if(strtolower($get_ext)=="jpg" || strtolower($get_ext)=="gif" || strtolower($get_ext)=="jpeg"){
						$org_image_name=$exp_file[0].'-'.time().'.'.$get_ext;
						$destination_image = '../slide_photo/org/' . $org_image_name;
						if(move_uploaded_file($image , $destination_image)){
							
							$t_width = 198;
							$t_height = 181;
							
							$small_image='../slide_photo/small/' . $org_image_name;
							make_thumb($destination_image, $small_image,$t_width,$t_height);
							
							$query = "UPDATE " . TABLE_SLIDER_SHOW . " SET image_path = '" . $org_image_name . "' WHERE image_id = '" . $pID ."'";
							com_db_query($query);
						}
					}	
				}	
			}
			
			com_redirect("slider-show.php?p=". $p ."&pID=" . $pID . "&selected_menu=others&msg=" . msg_encode("Image update successfully"));
		 
		break;		
		
	  
		
	case 'addsave':
			$caption=com_db_input($_POST['caption']);
			$add_date = date('Y-m-d');
			$query = "insert into " . TABLE_SLIDER_SHOW . " (caption, add_date, status) values ('$caption', '$add_date', '0')";
			com_db_query($query);
			$insert_id = com_db_insert_id();
			$image = $_FILES['image']['tmp_name'];
			if($image!=''){
				if(is_uploaded_file($image)){
					$org_img = $_FILES['image']['name'];
					$exp_file = explode("." , $org_img);
					$get_ext = $exp_file[count($exp_file) - 1];
					if(strtolower($get_ext)=="jpg" || strtolower($get_ext)=="gif" || strtolower($get_ext)=="jpeg"){
						$org_image_name=$exp_file[0].'-'.time().'.'.$get_ext;
						$destination_image = '../slide_photo/org/' . $org_image_name;
						if(move_uploaded_file($image , $destination_image)){
							$t_width = 198;
							$t_height = 181;
							$small_image='../slide_photo/small/' . $org_image_name;
							make_thumb($destination_image, $small_image,$t_width,$t_height);
							$query = "UPDATE " . TABLE_SLIDER_SHOW . " SET image_path = '" . $org_image_name . "' WHERE image_id = '" . $insert_id ."'";
							com_db_query($query);
						}
					}	
				}	
			}
			com_redirect("slider-show.php?p=" . $p . "&selected_menu=others&msg=" . msg_encode("Image added successfully"));
		 
		break;	
		
	case 'detailes':
			
			$query_edit=com_db_query("select * from " . TABLE_SLIDER_SHOW . " where image_id = '" . $pID . "'");
	  		$data_edit=com_db_fetch_array($query_edit);
			
			$caption=com_db_output($data_edit['caption']);
			$add_date =explode('-',$data_edit['add_date']);
			$post_date = date('d, M Y',mktime(0,0,0,date($add_date[1]),date($add_date[2]),date($add_date[0])));
			
		break;	
	case 'activate':
     		
	   		$status=$_GET['status'];
			if($status==0){
				$query = "update " . TABLE_SLIDER_SHOW . " set status = '1' where image_id = '" . $pID . "'";
			}else{
				$query = "update " . TABLE_SLIDER_SHOW . " set status = '0' where image_id = '" . $pID . "'";
			}	
			com_db_query($query);
	  		com_redirect("slider-show.php?p=". $p ."&pID=" . $pID . "&selected_menu=others&msg=" . msg_encode("Image update successfully"));
			
		break;
				
    }
	


include("includes/header.php");
?>
<script type="text/javascript">
function confirm_del(nid,p){
	var agree=confirm("Image will be deleted. \n Do you want to continue?");
	if (agree)
		window.location = "slider-show.php?selected_menu=others&pID=" + nid + "&p=" + p + "&action=delete";
	else
		window.location = "slider-show.php?selected_menu=others&pID=" + nid + "&p=" + p ;
}

function CheckAll(numRows){
	if(document.getElementById('all').checked){
		for(i=1; i<=numRows; i++){
			var image_id='image_id-'+ i;
			document.getElementById(image_id).checked=true;
		}
	} else {
		for(i=1; i<=numRows; i++){
			var image_id='image_id-'+ i;
			document.getElementById(image_id).checked=false;
		}
	}
}

function AllDelete(numRows){

	var flg=0;
	for(i=1; i<=numRows; i++){
			var image_id='image_id-'+ i;
			if(document.getElementById(image_id).checked){
				flg=1;
			}	
		}
	if(flg==0){
		alert("Please checked atlist one checkbox for delete.");
		document.getElementById('image_id-1').focus();
		return false;
	} else {
		var agree=confirm("Image will be deleted. \n Do you want to continue?");
		if (agree)
			 document.topicform.submit();
		else
			window.location = "slider-show.php?selected_menu=others";
	}	

}

function confirm_artivate(nid,p,status){
	if(status=='1'){
		var msg="Image will be active. \n Do you want to continue?";
	}else{
		var msg="Image will be Inactive. \n Do you want to continue?";
	}
	var agree=confirm(msg);
	if (agree)
		window.location = "slider-show.php?selected_menu=others&pID=" + nid + "&p=" + p + "&status=" + status + "&action=activate";
	else
		window.location = "slider-show.php?selected_menu=others&pID=" + nid + "&p=" + p ;
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
                  <td width="30%" align="left" valign="middle" class="heading-text">Slider Image  Manager</td>
                  <td width="34%" align="left" valign="middle" class="message"><?=$msg?></td>
                  <td width="8%" align="right" valign="middle"><a href="#"><img src="images/add-icon.jpg" border="0" width="25" height="28" alt="Add Image" caption="Add Image" onclick="window.location='slider-show.php?action=add&selected_menu=others'"  /></a></td>
                  <td width="8%" align="left" valign="middle" class="nav-text">Add New </td>
                  <td width="4%" align="right" valign="middle"><a href="#"><img src="images/delete-icon.jpg" border="0" width="25" height="28"  alt="Delete Image" caption="Delete Image" onclick="AllDelete('<?=$numRows?>');"  /></a></td>
                  <td width="8%" align="left" valign="middle" class="nav-text">Delete</td>
                </tr>
              </table></td>
          </tr>
       
          <tr>
            <td align="left" valign="top" class="right-bar-content-border">
			<form caption="topicform" action="slider-show.php?action=alldelete&selected_menu=others" method="post">
			<table width="100%" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="34" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-title-text">#</span></td>
				<td width="36" height="30" align="center" valign="middle" class="right-border">
				<input type="checkbox" caption="all" image_id="all" onclick="CheckAll('<?=$numRows?>');" /></td>
				<td width="208" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Image</span> </td>
				<td width="400" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Caption</span> </td>
				<td width="130" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Date</span> </td>
				<td width="153" height="30" align="center" valign="middle" class="left-border"><div align="center"><span class="right-box-title-text">Action</span></div></td>
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
				<td height="30" align="center" valign="middle" class="right-border"><input type="checkbox" image_id="image_id-<?=$i;?>" caption="nid[]" value="<?=$data_sql['image_id'];?>" /></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><img src="../slide_photo/small/<?=com_db_output($data_sql['image_path'])?>" width="100" height="100"/></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><?=com_db_output($data_sql['caption'])?></a></td>
				<td height="30" align="center" valign="middle" class="right-border"><?=$added_date;?></td>
				<td height="30" align="center" valign="middle" class="left-border">
					<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr> 
					  	<?php if($status==0){ ?>
					   	<td width="29%" align="center" valign="middle"><a href="#"><img src="images/icon/active-icon.gif" width="16" height="16" alt="" caption="" border="0" onclick="confirm_artivate('<?=$data_sql['image_id'];?>','<?=$p;?>','<?=$status;?>');" /></a><br />
					   	  Status</td>
					   	<?php } elseif($status==1){ ?>
					   	<td width="24%" align="center" valign="middle"><a href="#"><img src="images/icon/inactive-icon.gif" width="16" height="16" alt="" caption="" border="0" onclick="confirm_artivate('<?=$data_sql['image_id'];?>','<?=$p;?>','<?=$status;?>');" /></a><br />
					   	  Status</td>
						<?php } ?>
						<td width="23%" align="center" valign="middle"><a href="#"><img src="images/small-edit-icon.gif" width="16" height="16" alt="Edit" caption="Edit" border="0" onclick="window.location='slider-show.php?selected_menu=others&p=<?=$p;?>&pID=<?=$data_sql['image_id'];?>&action=edit'" /></a><br />
						  Edit</td>
						<td width="24%" align="center" valign="middle"><a href="#"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" caption="Delete" border="0" onclick="confirm_del('<?=$data_sql['image_id'];?>','<?=$p;?>')" /></a><br />
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
                  <td width="50%" align="left" valign="middle" class="heading-text">Slider Image Manager :: Edit </td>
				  
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
			<form caption="DateTest" method="post" action="slider-show.php?action=editsave&selected_menu=others&pID=<?=$pID;?>&p=<?=$p;?>" enctype="multipart/form-data" onsubmit="return chk_form();">
			<tr>
			  <td width="11%" align="left" class="page-text" valign="top">&nbsp;Caption:</td>
			  <td width="89%" align="left" valign="top">
				<input type="text" name="caption" id="caption" size="40" value="<?=$caption;?>" /></td>	
			</tr>
			<tr>
			  <td width="11%" align="left" class="page-text" valign="top">&nbsp;Image:</td>
			  <td width="89%" align="left" valign="top">
			  	<img src="../slide_photo/small/<?=$image_path?>" /><br /><br />
				<input type="file" name="image" id="image" size="40" />
				<p>Image width = 181px and height = 198px, extention must be .gif, .jpg, .jpeg </p></td>	
			</tr>
			<tr><td align="left" valign="top">&nbsp;</td><td align="left" valign="top"><input type="submit" value="Update Image" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='slider-show.php?p=<?=$p;?>&pID=<?=$pID;?>&selected_menu=others'" /></td></tr>
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
	var caption=document.getElementById('caption').value;
	if(caption==''){
	alert("Please enter news caption.");
	document.getElementById('caption').focus();
	return false;
	}

}
</script>
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">Slider Image Manager :: Add</td>
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
		<form caption="DateTest" method="post" action="slider-show.php?action=addsave&p=<?=$p;?>" enctype="multipart/form-data" onsubmit="return chk_form();">
		<tr>
			  <td width="11%" align="left" class="page-text" valign="top">&nbsp;Caption:</td>
			  <td width="89%" align="left" valign="top">
				<input type="text" name="caption" id="caption" size="40"  /></td>	
			</tr>
			<tr>
			  <td width="11%" align="left" class="page-text" valign="top">&nbsp;Image:</td>
			  <td width="89%" align="left" valign="top">
				<input type="file" name="image" id="image" size="40" />
				<p>Image width = 181px and height = 198px,  extention must be .gif, .jpg, .jpeg</p></td>	
			</tr>
		
		<tr><td align="left" valign="top">&nbsp;</td><td align="left" valign="top"><input type="submit" value="Add Image" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='slider-show.php?p=<?=$p;?>&pID=<?=$pID;?>&selected_menu=others'" /></td></tr>
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
} 
include("includes/footer.php");
?>