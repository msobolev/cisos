<?php
require('includes/include_top.php');
include('includes/include_editor.php');

$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 20;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';


$sql_query = "select * from " . TABLE_TEAM_ADVISORS . " where type='Team' order by ta_id desc";
/***************** FOR PAGIN ***********************/
$starting_point = $items_per_page * ($p - 1);
/****************** END PAGIN ***********************/
$main_page = 'team.php';

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
	   		
			com_db_query("delete from " . TABLE_TEAM_ADVISORS . " where ta_id = '" . $tID . "'");
		 	com_redirect("team.php?p=" . $p . "&selected_menu=team&msg=" . msg_encode("Team deleted successfully"));
		
		break;
		
	  case 'alldelete':
	   		$ta_id = $_POST['nid'];
			for($i=0; $i< sizeof($ta_id) ; $i++){
				com_db_query("delete from " . TABLE_TEAM_ADVISORS . " where ta_id = '" . $ta_id[$i] . "'");
			}
		 	com_redirect("team.php?p=" . $p . "&selected_menu=team&msg=" . msg_encode("Team deleted successfully"));
		
		break;	
		
	  case 'edit':
     		
	   		$query_edit=com_db_query("select * from " . TABLE_TEAM_ADVISORS . " where ta_id = '" . $tID . "'");
	  		$data_edit=com_db_fetch_array($query_edit);
			$name=com_db_output($data_edit['name']);
			$designation=com_db_output($data_edit['designation']);
			$details=com_db_output($data_edit['details']);
			$image_path = $data_edit['image_path'];
			
		break;	
		
		case 'editsave':
			
			$name=com_db_input($_POST['name']);
			$designation=com_db_input($_POST['designation']);
			$details=com_db_input($_POST['details']);
			
			$query = "update " . TABLE_TEAM_ADVISORS . " set name = '" . $name . "',designation='".$designation."',  details = '" . $details . "' where ta_id = '" . $tID . "'";
			com_db_query($query);
			
			$image = $_FILES['image']['tmp_name'];
			  
			if($image!=''){
				if(is_uploaded_file($image)){
					$org_img = $_FILES['image']['name'];
					$exp_file = explode("." , $org_img);
					$get_ext = $exp_file[count($exp_file) - 1];
					if(strtolower($get_ext)=="jpg" || strtolower($get_ext)=="gif" || strtolower($get_ext)=="jpeg" || strtolower($get_ext)=="png"){
						$new_exp_file = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''),$exp_file[0]);
						$org_image_name = $new_exp_file.'-'.time().'.'.$get_ext;
						$destination_image = '../team_photo/org/' . $org_image_name;
						if(move_uploaded_file($image , $destination_image)){
								
							$org_size=getimagesize($destination_image);
							$width=$org_size[0];
							if($width > 150) {
								$t_width=150;
								$ex_width=$org_size[0]-150;	
								$per_width=$ex_width/$org_size[0]*100;
								$height=$org_size[1];
								$ex_heaight=$height/100*$per_width;
								$t_heaight=$height-$ex_heaight;
							} else {
								$t_width=$org_size[0];
								$t_heaight=$org_size[1];
							}
							
							$small_image='../team_photo/thumb/' . $org_image_name;
							make_thumb($destination_image, $small_image,$t_width,$t_heaight);
							
							$query = "UPDATE " . TABLE_TEAM_ADVISORS . " SET image_path = '" . $org_image_name . "' WHERE ta_id = '" . $tID ."'";
							com_db_query($query);
						}
					}	
				}	
			}
			
	  		com_redirect("team.php?p=". $p ."&tID=" . $tID . "&selected_menu=team&msg=" . msg_encode("Team update successfully"));
		 
		break;		
		
	  
		
	case 'addsave':
			
			$name=com_db_input($_POST['name']);
			$details=com_db_input($_POST['details']);
			$added=date('Y-m-d');
			
			$query = "insert into " . TABLE_TEAM_ADVISORS . " (name, designation, details, type, add_date, status) values ('$name', '$designation', '$details', 'Team', '$added', '0')";
			com_db_query($query);
			$insert_id = com_db_insert_id();
			$image = $_FILES['image']['tmp_name'];
			  
			if($image!=''){
				if(is_uploaded_file($image)){
					$org_img = $_FILES['image']['name'];
					$exp_file = explode("." , $org_img);
					$get_ext = $exp_file[count($exp_file) - 1];
					if(strtolower($get_ext)=="jpg" || strtolower($get_ext)=="gif" || strtolower($get_ext)=="jpeg" || strtolower($get_ext)=="png"){
						$new_exp_file = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''),$exp_file[0]);
						$org_image_name = $new_exp_file.'-'.time().'.'.$get_ext;
						$destination_image = '../team_photo/org/' . $org_image_name;
						if(move_uploaded_file($image , $destination_image)){
								
							$org_size=getimagesize($destination_image);
							$width=$org_size[0];
							if($width > 150) {
								$t_width=150;
								$ex_width=$org_size[0]-150;	
								$per_width=$ex_width/$org_size[0]*100;
								$height=$org_size[1];
								$ex_heaight=$height/100*$per_width;
								$t_heaight=$height-$ex_heaight;
							} else {
								$t_width=$org_size[0];
								$t_heaight=$org_size[1];
							}
							
							$small_image='../team_photo/thumb/' . $org_image_name;
							make_thumb($destination_image, $small_image,$t_width,$t_heaight);
							
							$query = "UPDATE " . TABLE_TEAM_ADVISORS . " SET image_path = '" . $org_image_name . "' WHERE ta_id = '" . $insert_id ."'";
							com_db_query($query);
						}
					}	
				}	
			}
			
	  	 	com_redirect("team.php?p=" . $p . "&selected_menu=team&msg=" . msg_encode("Team added successfully"));
		 
		break;	
		
	case 'detailes':
			
			$query_edit=com_db_query("select * from " . TABLE_TEAM_ADVISORS . " where ta_id = '" . $tID . "'");
	  		$data_edit=com_db_fetch_array($query_edit);
			
			$name=com_db_output($data_edit['name']);
			$designation=com_db_output($data_edit['designation']);
			$details=com_db_output($data_edit['details']);
			$add_date =explode('-',$data_edit['add_date']);
			$post_date = date('d, M Y',mktime(0,0,0,date($add_date[1]),date($add_date[2]),date($add_date[0])));
			$image_path = $data_edit['image_path'];
		break;	
	case 'activate':
     		
	   		$status=$_GET['status'];
			if($status==0){
				$query = "update " . TABLE_TEAM_ADVISORS . " set status = '1' where ta_id = '" . $tID . "'";
			}else{
				$query = "update " . TABLE_TEAM_ADVISORS . " set status = '0' where ta_id = '" . $tID . "'";
			}	
			com_db_query($query);
	  		com_redirect("team.php?p=". $p ."&tID=" . $tID . "&selected_menu=team&msg=" . msg_encode("Team update successfully"));
			
		break;
				
    }
	


include("includes/header.php");
?>
<script type="text/javascript">
function confirm_del(nid,p){
	var agree=confirm("Team will be deleted. \n Do you want to continue?");
	if (agree)
		window.location = "team.php?selected_menu=team&tID=" + nid + "&p=" + p + "&action=delete";
	else
		window.location = "team.php?selected_menu=team&tID=" + nid + "&p=" + p ;
}

function CheckAll(numRows){
	if(document.getElementById('all').checked){
		for(i=1; i<=numRows; i++){
			var ta_id='ta_id-'+ i;
			document.getElementById(ta_id).checked=true;
		}
	} else {
		for(i=1; i<=numRows; i++){
			var ta_id='ta_id-'+ i;
			document.getElementById(ta_id).checked=false;
		}
	}
}

function AllDelete(numRows){

	var flg=0;
	for(i=1; i<=numRows; i++){
			var ta_id='ta_id-'+ i;
			if(document.getElementById(ta_id).checked){
				flg=1;
			}	
		}
	if(flg==0){
		alert("Please checked atlist one checkbox for delete.");
		document.getElementById('ta_id-1').focus();
		return false;
	} else {
		var agree=confirm("Team will be deleted. \n Do you want to continue?");
		if (agree)
			 document.topicform.submit();
		else
			window.location = "team.php?selected_menu=team";
	}	

}

function confirm_artivate(nid,p,status){
	if(status=='1'){
		var msg="Team will be active. \n Do you want to continue?";
	}else{
		var msg="Team will be Inactive. \n Do you want to continue?";
	}
	var agree=confirm(msg);
	if (agree)
		window.location = "team.php?selected_menu=team&tID=" + nid + "&p=" + p + "&status=" + status + "&action=activate";
	else
		window.location = "team.php?selected_menu=team&tID=" + nid + "&p=" + p ;
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
                  <td width="30%" align="left" valign="middle" class="heading-text">Team Manager</td>
                  <td width="34%" align="left" valign="middle" class="message"><?=$msg?></td>
                  <? if($btnAdd=='Yes'){ ?>
                  <td width="8%" align="right" valign="middle"><a href="#"><img src="images/add-icon.jpg" border="0" width="25" height="28" alt="Add Team" name="Add Team" onclick="window.location='team.php?action=add&selected_menu=team'"  /></a></td>
                  <td width="8%" align="left" valign="middle" class="nav-text">Add New </td>
                  <? }
				  if($btnDelete=='Yes'){ ?>
                  <td width="4%" align="right" valign="middle"><a href="#"><img src="images/delete-icon.jpg" border="0" width="25" height="28"  alt="Delete Team" name="Delete Team" onclick="AllDelete('<?=$numRows?>');"  /></a></td>
                  <td width="8%" align="left" valign="middle" class="nav-text">Delete</td>
                  <? } ?>
                </tr>
              </table></td>
          </tr>
       
          <tr>
            <td align="left" valign="top" class="right-bar-content-border">
			<form name="topicform" action="team.php?action=alldelete&selected_menu=team" method="post">
			<table width="100%" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="23" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-title-text">#</span></td>
				<td width="32" height="30" align="center" valign="middle" class="right-border">
				<input type="checkbox" name="all" id="all" onclick="CheckAll('<?=$numRows?>');" /></td>
				<td width="300" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Name</span> </td>
				<td width="243" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Designation</span> </td>
				<td width="116" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Date</span> </td>
				<td width="247" height="30" align="center" valign="middle" class="left-border"><div align="center"><span class="right-box-title-text">Action</span></div></td>
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
				<td height="30" align="center" valign="middle" class="right-border"><input type="checkbox" id="ta_id-<?=$i;?>" name="nid[]" value="<?=$data_sql['ta_id'];?>" /></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><a href="team.php?action=detailes&selected_menu=team&tID=<?=$data_sql['ta_id'];?>"><?=com_db_output($data_sql['name'])?></a></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><?=com_db_output($data_sql['designation'])?></td>
				<td height="30" align="center" valign="middle" class="right-border"><?=$added_date;?></td>
				<td height="30" align="center" valign="middle" class="left-border">
					<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr> 
					  	<? if($btnStatus=='Yes'){ 
						 	if($status==0){ ?>
					   	<td width="29%" align="center" valign="middle"><a href="#"><img src="images/icon/active-icon.gif" width="16" height="16" alt="" name="" border="0" onclick="confirm_artivate('<?=$data_sql['ta_id'];?>','<?=$p;?>','<?=$status;?>');" /></a><br />
					   	  Status</td>
					   	<?php } elseif($status==1){ ?>
					   	<td width="24%" align="center" valign="middle"><a href="#"><img src="images/icon/inactive-icon.gif" width="16" height="16" alt="" name="" border="0" onclick="confirm_artivate('<?=$data_sql['ta_id'];?>','<?=$p;?>','<?=$status;?>');" /></a><br />
					   	  Status</td>
						<?php } 
						}
						if($btnEdit=='Yes'){ ?>
						<td width="23%" align="center" valign="middle"><a href="#"><img src="images/small-edit-icon.gif" width="16" height="16" alt="Edit" name="Edit" border="0" onclick="window.location='team.php?selected_menu=team&p=<?=$p;?>&tID=<?=$data_sql['ta_id'];?>&action=edit'" /></a><br />
						  Edit</td>
                       <? }
					    if($btnDelete=='Yes'){ ?>  
						<td width="24%" align="center" valign="middle"><a href="#"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" name="Delete" border="0" onclick="confirm_del('<?=$data_sql['ta_id'];?>','<?=$p;?>')" /></a><br />
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
                  <td width="50%" align="left" valign="middle" class="heading-text">Team Manager :: Edit Team </td>
				  
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
			<form name="DateTest" method="post" action="team.php?action=editsave&selected_menu=team&tID=<?=$tID;?>&p=<?=$p;?>" enctype="multipart/form-data" onsubmit="return chk_form();">
			<tr>
			  <td width="22%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Name &amp; Designation:</td>
			  <td width="78%" align="left" valign="top">
				<input type="text" name="name" id="name" size="80" value="<?=$name;?>" />
			  </td>	
			</tr>
            <tr>
			  <td width="22%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Designation:</td>
			  <td width="78%" align="left" valign="top">
				<input type="text" name="designation" id="designation" size="80" value="<?=$designation;?>" />
			  </td>	
			</tr>
            <tr>
			  <td width="22%" align="left" class="page-text" valign="top">&nbsp;&nbsp; Photo:</td>
			  <td width="78%" align="left" valign="top">
              	<?php if(file_exists("../team_photo/thumb/".$image_path) && $image_path !=''){	
                echo '<img src="../team_photo/thumb/'.$image_path.'" title="Team Photo" alt="Team Photo" /><br /><br />';
                 } ?>
				<input type="file" name="image" id="image" />
			  </td>	
			</tr>
			<tr>
			<td  class="page-text" align="left" valign="top">&nbsp;&nbsp;&nbsp;Details:</td>
			<td align="left" valign="top">
			
			<div id="loading"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1">Please wait<br><br>
			  </font><strong><font color="#993300" face="Verdana, Arial, Helvetica, sans-serif" >Editor 
			  Loading......</font></strong><br>
			  <br></div> <div id="fck" style="">  
		  <!---------------------------->
		  
			<?php
			$oFCKeditor = new FCKeditor('details') ;
			$oFCKeditor->BasePath	= $sBasePath ;
			$oFCKeditor->ToolbarSet = ''; // Basic
			$oFCKeditor->Width  = '100%';
			$oFCKeditor->Height  = '400';       
			$oFCKeditor->Value		= $details ;
			$oFCKeditor->Create() ;
			
			?>
				</div>
			</td></tr>
			
			<tr><td align="left" valign="top">&nbsp;</td><td align="left" valign="top"><div id="butt" style="display:none;"><input type="submit" value="Update Team" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='team.php?p=<?=$p;?>&tID=<?=$tID;?>&selected_menu=team'" /></div></td></tr>
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
                  <td width="50%" align="left" valign="middle" class="heading-text">Team Manager :: Add Team </td>
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
		<form name="DateTest" method="post" action="team.php?action=addsave&p=<?=$p;?>" enctype="multipart/form-data" onsubmit="return chk_form();">
		<tr>
		  <td width="22%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Name &amp; Designation:</td>
		  <td width="78%" align="left" valign="top">
			<input type="text" name="name" id="name" size="80" />
		  </td>	
		</tr>
        <tr>
		  <td width="22%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Designation:</td>
		  <td width="78%" align="left" valign="top">
			<input type="text" name="designation" id="designation" size="80" />
		  </td>	
		</tr>
		 <tr>
			  <td width="22%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Photo:</td>
			  <td width="78%" align="left" valign="top">
				<input type="file" name="image" id="image" />
			  </td>	
			</tr>
		<tr>
		<td  class="page-text" align="left" valign="top">&nbsp;&nbsp;&nbsp;Details:</td>
		<td align="left" valign="top">
		<div id="loading"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1">Please wait<br><br>
          </font><strong><font color="#993300" face="Verdana, Arial, Helvetica, sans-serif" >Editor 
          Loading......</font></strong><br>
          <br></div> <div id="fck" style="">  
      <!---------------------------->
      
		<?php
		$oFCKeditor = new FCKeditor('details') ;
		$oFCKeditor->BasePath	= $sBasePath ;
		$oFCKeditor->ToolbarSet = ''; // Basic
		$oFCKeditor->Width  = '100%';
		$oFCKeditor->Height  = '400';       
		$oFCKeditor->Value		= '' ;
		$oFCKeditor->Create() ;
		
		?>
			</div>
		</td></tr>
		
		<tr><td align="left" valign="top">&nbsp;</td><td align="left" valign="top"><div id="butt" style="display:none;"><input type="submit" value="Add Team" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='team.php?p=<?=$p;?>&tID=<?=$tID;?>&selected_menu=team'" /></div></td></tr>
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
                  <td width="50%" align="left" valign="middle" class="heading-text">Team Manager :: Team Details </td>
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
			  <td align="left" valign="top" class="page-text"><strong><?=$name.", ".$designation;?></strong><br /><br /><?=$post_date?></td>
			</tr>
            <tr>
			  <td align="left" valign="top" class="page-text">
			  <?php if(file_exists("../team_photo/thumb/".$image_path) && $image_path !=''){	
                echo '<img src="../team_photo/thumb/'.$image_path.'" title="Team Photo" alt="Team Photo" /><br /><br />';
                 } ?>
              </td>
			</tr>
			<tr>
				<td align="left" valign="top" class="page-text"><?=$details;?></td>
			</tr>
			<tr>
				<!--<td align="left" valign="top">&nbsp;</td> -->
				<td align="left" valign="top"><input type="button" class="submitButton" value="Back" onclick="window.location='team.php?p=<?=$p;?>&tID=<?=$tID;?>&selected_menu=team'" /></td>
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