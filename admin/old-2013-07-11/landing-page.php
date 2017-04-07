<?php
require('includes/include_top.php');
include('includes/include_editor.php');

$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 20;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';


$sql_query = "select * from " . TABLE_LANDING_PAGE . " order by lp_id desc";
/***************** FOR PAGIN ***********************/
$starting_point = $items_per_page * ($p - 1);
/****************** END PAGIN ***********************/
$main_page = 'landing-page.php';

$exe_query=com_db_query($sql_query);
$num_rows=com_db_num_rows($exe_query);
$total_data = $num_rows;

/************ FOR PAGIN **************/
$sql_query .= " LIMIT $starting_point,$items_per_page";
$exe_data = com_db_query($sql_query);

$numRows = com_db_num_rows($exe_data);
/************ END ********************/


$lpID = (isset($_GET['lpID']) ? $_GET['lpID'] : $select_data[0]);

    switch ($action) {
		
	  case 'delete':
	   		
			com_db_query("delete from " . TABLE_LANDING_PAGE . " where lp_id = '" . $lpID . "'");
		 	com_redirect("landing-page.php?p=" . $p . "&selected_menu=others&msg=" . msg_encode("Landing Page deleted successfully"));
		
		break;
		
	  case 'alldelete':
	   		$lp_id = $_POST['nid'];
			for($i=0; $i< sizeof($lp_id) ; $i++){
				com_db_query("delete from " . TABLE_LANDING_PAGE . " where lp_id = '" . $lp_id[$i] . "'");
			}
		 	com_redirect("landing-page.php?p=" . $p . "&selected_menu=others&msg=" . msg_encode("Landing Page deleted successfully"));
		
		break;	
		
	  case 'edit':
     		
	   		$query_edit = com_db_query("select * from " . TABLE_LANDING_PAGE . " where lp_id = '" . $lpID . "'");
	  		$data_edit = com_db_fetch_array($query_edit);
			$lp_name = com_db_output($data_edit['lp_name']);
			$lp_logo = com_db_output($data_edit['lp_logo']);
			$lp_caption = com_db_output($data_edit['lp_caption']);
			$lp_img_title = com_db_output($data_edit['lp_img_title']);
			$lp_image = com_db_output($data_edit['lp_image']);
			$lp_img_desc = com_db_output($data_edit['lp_img_desc']);
			$lp_content_title = com_db_output($data_edit['lp_content_title']);
			$lp_content_desc = com_db_output($data_edit['lp_content_desc']);
			$lp_fname=com_db_output($data_edit['lp_fname']);
			$lp_lname=com_db_output($data_edit['lp_lname']);
			$lp_email=com_db_output($data_edit['lp_email']);
			$lp_message=com_db_output($data_edit['lp_message']);
			
		break;	
		
		case 'editsave':
			
			$lp_name=com_db_input($_POST['lp_name']);
			$lp_caption=com_db_input($_POST['lp_caption']);
			$lp_img_title=com_db_input($_POST['lp_img_title']);
			$lp_img_desc=com_db_input($_POST['lp_img_desc']);
			$lp_content_title=com_db_input($_POST['lp_content_title']);
			$lp_content_desc=com_db_input($_POST['lp_content_desc']);
			$lp_fname=com_db_input($_POST['lp_fname']);
			$lp_lname=com_db_input($_POST['lp_lname']);
			$lp_email=com_db_input($_POST['lp_email']);
			$lp_message=com_db_input($_POST['lp_message']);
			
						
			$query = "update " . TABLE_LANDING_PAGE . " set lp_name = '" . $lp_name . "',  lp_caption = '" . $lp_caption . "', lp_img_title ='".$lp_img_title."', lp_img_desc = '".$lp_img_desc."', lp_content_title ='".$lp_content_title."', lp_content_desc ='".$lp_content_desc."', lp_fname = '" . $lp_fname . "', lp_lname = '" . $lp_lname . "', lp_email = '" . $lp_email . "', lp_message = '" . $lp_message . "' where lp_id = '" . $lpID . "'";
			com_db_query($query);
			
			$image = $_FILES['lp_logo']['tmp_name'];
			  
			if($image!=''){
				if(is_uploaded_file($image)){
					$org_img = $_FILES['lp_logo']['name'];
					$exp_file = explode("." , $org_img);
					$get_ext = $exp_file[count($exp_file) - 1];
					if($get_ext=="jpg" || $get_ext=="gif" || $get_ext=="jpge"){
						$org_image_name=$exp_file[0].'-'.time().'.'.$get_ext;
						$destination_image = '../landing-page/logo/org/' . $org_image_name;
						if(move_uploaded_file($image , $destination_image)){
								
							$org_size=getimagesize($destination_image);
							$width=$org_size[0];
							if($width > 196) {
								$t_width=196;
								$ex_width=$org_size[0]-196;	
								$per_width=$ex_width/$org_size[0]*100;
								$height=$org_size[1];
								$ex_heaight=$height/100*$per_width;
								$t_heaight=$height-$ex_heaight;
							} else {
								$t_width=$org_size[0];
								$t_heaight=$org_size[1];
							}
							
							$small_image='../landing-page/logo/' . $org_image_name;
							make_thumb($destination_image, $small_image,$t_width,$t_heaight);
							
							$query = "UPDATE " . TABLE_LANDING_PAGE . " SET lp_logo = '" . $org_image_name . "' where lp_id = '" . $lpID . "'";
							com_db_query($query);
						}
					}	
				}	
			}
			$image = $_FILES['lp_image']['tmp_name'];
			if($image!=''){
				if(is_uploaded_file($image)){
					$org_img = $_FILES['lp_image']['name'];
					$exp_file = explode("." , $org_img);
					$get_ext = $exp_file[count($exp_file) - 1];
					if($get_ext=="jpg" || $get_ext=="gif" || $get_ext=="jpge"){
						$org_image_name=$exp_file[0].'-'.time().'.'.$get_ext;
						$destination_image = '../landing-page/img_file/org/' . $org_image_name;
						if(move_uploaded_file($image , $destination_image)){
								
							$org_size=getimagesize($destination_image);
							$width=$org_size[0];
							if($width > 190) {
								$t_width=190;
								$ex_width=$org_size[0]-190;	
								$per_width=$ex_width/$org_size[0]*100;
								$height=$org_size[1];
								$ex_heaight=$height/100*$per_width;
								$t_heaight=$height-$ex_heaight;
							} else {
								$t_width=$org_size[0];
								$t_heaight=$org_size[1];
							}
							
							$small_image='../landing-page/img_file/' . $org_image_name;
							make_thumb($destination_image, $small_image,$t_width,$t_heaight);
							
							$query = "UPDATE " . TABLE_LANDING_PAGE . " SET lp_image = '" . $org_image_name . "' where lp_id = '" . $lpID . "'";
							com_db_query($query);
						}
					}	
				}	
			}
			
	  		com_redirect("landing-page.php?p=". $p ."&lpID=" . $lpID . "&selected_menu=others&msg=" . msg_encode("Landing Page update successfully"));
		 
		break;		
		
	  
		
	case 'addsave':
			
			$lp_name=com_db_input($_POST['lp_name']);
			$lp_caption=com_db_input($_POST['lp_caption']);
			$lp_img_title=com_db_input($_POST['lp_img_title']);
			$lp_img_desc=com_db_input($_POST['lp_img_desc']);
			$lp_content_title=com_db_input($_POST['lp_content_title']);
			$lp_content_desc=com_db_input($_POST['lp_content_desc']);
			$lp_fname=com_db_input($_POST['lp_fname']);
			$lp_lname=com_db_input($_POST['lp_lname']);
			$lp_email=com_db_input($_POST['lp_email']);
			$lp_message=com_db_input($_POST['lp_message']);
			
			
			
			
			$add_date=date('Y-m-d');
			
			$query = "insert into " . TABLE_LANDING_PAGE . " (lp_name, lp_caption, lp_img_title, lp_img_desc, lp_content_title, lp_content_desc, lp_fname, lp_lname, lp_email, lp_message, add_date) values ('$lp_name', '$lp_caption', '$lp_img_title', '$lp_img_desc', '$lp_content_title', '$lp_content_desc', '$lp_fname', '$lp_lname', '$lp_email', '$lp_message', '$add_date')";
			com_db_query($query);
			$insert_id = com_db_insert_id();
			$image = $_FILES['lp_logo']['tmp_name'];
			  
			if($image!=''){
				if(is_uploaded_file($image)){
					$org_img = $_FILES['lp_logo']['name'];
					$exp_file = explode("." , $org_img);
					$get_ext = $exp_file[count($exp_file) - 1];
					if($get_ext=="jpg" || $get_ext=="gif" || $get_ext=="jpge"){
						$org_image_name=$exp_file[0].'-'.time().'.'.$get_ext;
						$destination_image = '../landing-page/logo/org/' . $org_image_name;
						if(move_uploaded_file($image , $destination_image)){
								
							$org_size=getimagesize($destination_image);
							$width=$org_size[0];
							if($width > 196) {
								$t_width=196;
								$ex_width=$org_size[0]-196;	
								$per_width=$ex_width/$org_size[0]*100;
								$height=$org_size[1];
								$ex_heaight=$height/100*$per_width;
								$t_heaight=$height-$ex_heaight;
							} else {
								$t_width=$org_size[0];
								$t_heaight=$org_size[1];
							}
							
							$small_image='../landing-page/logo/' . $org_image_name;
							make_thumb($destination_image, $small_image,$t_width,$t_heaight);
							
							$query = "UPDATE " . TABLE_LANDING_PAGE . " SET lp_logo = '" . $org_image_name . "' WHERE lp_id = '" . $insert_id ."'";
							com_db_query($query);
						}
					}	
				}	
			}
			$image = $_FILES['lp_image']['tmp_name'];
			if($image!=''){
				if(is_uploaded_file($image)){
					$org_img = $_FILES['lp_image']['name'];
					$exp_file = explode("." , $org_img);
					$get_ext = $exp_file[count($exp_file) - 1];
					if($get_ext=="jpg" || $get_ext=="gif" || $get_ext=="jpge"){
						$org_image_name=$exp_file[0].'-'.time().'.'.$get_ext;
						$destination_image = '../landing-page/img_file/org/' . $org_image_name;
						if(move_uploaded_file($image , $destination_image)){
								
							$org_size=getimagesize($destination_image);
							$width=$org_size[0];
							if($width > 190) {
								$t_width=190;
								$ex_width=$org_size[0]-190;	
								$per_width=$ex_width/$org_size[0]*100;
								$height=$org_size[1];
								$ex_heaight=$height/100*$per_width;
								$t_heaight=$height-$ex_heaight;
							} else {
								$t_width=$org_size[0];
								$t_heaight=$org_size[1];
							}
							
							$small_image='../landing-page/img_file/' . $org_image_name;
							make_thumb($destination_image, $small_image,$t_width,$t_heaight);
							
							$query = "UPDATE " . TABLE_LANDING_PAGE . " SET lp_image = '" . $org_image_name . "' WHERE lp_id = '" . $insert_id ."'";
							com_db_query($query);
						}
					}	
				}	
			}
			
	  	 	com_redirect("landing-page.php?p=" . $p . "&selected_menu=others&msg=" . msg_encode("Landing Page added successfully"));
		 
		break;	
		
	case 'detailes':
			
			$query_edit = com_db_query("select * from " . TABLE_LANDING_PAGE . " where lp_id = '" . $lpID . "'");
	  		$data_edit = com_db_fetch_array($query_edit);
			$lp_name = com_db_output($data_edit['lp_name']);
			$lp_logo = com_db_output($data_edit['lp_logo']);
			$lp_caption = com_db_output($data_edit['lp_caption']);
			$lp_img_title = com_db_output($data_edit['lp_img_title']);
			$lp_image = com_db_output($data_edit['lp_image']);
			$lp_img_desc = com_db_output($data_edit['lp_img_desc']);
			$lp_content_title = com_db_output($data_edit['lp_content_title']);
			$lp_content_desc = com_db_output($data_edit['lp_content_desc']);
			$lp_fname = com_db_output($data_edit['lp_fname']);
			$lp_lname = com_db_output($data_edit['lp_lname']);
			$lp_email = com_db_output($data_edit['lp_email']);
			$lp_message = com_db_output($data_edit['lp_message']);
			
			
		break;	
	
    }
	


include("includes/header.php");
?>
<script type="text/javascript">
function confirm_del(nid,p){
	var agree=confirm("Landing Page will be deleted. \n Do you want to continue?");
	if (agree)
		window.location = "landing-page.php?selected_menu=others&lpID=" + nid + "&p=" + p + "&action=delete";
	else
		window.location = "landing-page.php?selected_menu=others&lpID=" + nid + "&p=" + p ;
}

function CheckAll(numRows){
	if(document.getElementById('all').checked){
		for(i=1; i<=numRows; i++){
			var lp_id='lp_id-'+ i;
			document.getElementById(lp_id).checked=true;
		}
	} else {
		for(i=1; i<=numRows; i++){
			var lp_id='lp_id-'+ i;
			document.getElementById(lp_id).checked=false;
		}
	}
}

function AllDelete(numRows){

	var flg=0;
	for(i=1; i<=numRows; i++){
			var lp_id='lp_id-'+ i;
			if(document.getElementById(lp_id).checked){
				flg=1;
			}	
		}
	if(flg==0){
		alert("Please checked atlist one checkbox for delete.");
		document.getElementById('lp_id-1').focus();
		return false;
	} else {
		var agree=confirm("Landing Page will be deleted. \n Do you want to continue?");
		if (agree)
			 document.topicform.submit();
		else
			window.location = "landing-page.php?selected_menu=others";
	}	

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
                  <td width="30%" align="left" valign="middle" class="heading-text">Landing Page Manager</td>
                  <td width="34%" align="left" valign="middle" class="message"><?=$msg?></td>
                  <td width="8%" align="right" valign="middle"><a href="#"><img src="images/add-icon.jpg" border="0" width="25" height="28" alt="Add Landing Page" name="Add Landing Page" onclick="window.location='landing-page.php?action=add&selected_menu=others'"  /></a></td>
                  <td width="8%" align="left" valign="middle" class="nav-text">Add New </td>
                  <td width="4%" align="right" valign="middle"><a href="#"><img src="images/delete-icon.jpg" border="0" width="25" height="28"  alt="Delete Landing Page" name="Delete Landing Page" onclick="AllDelete('<?=$numRows?>');"  /></a></td>
                  <td width="8%" align="left" valign="middle" class="nav-text">Delete</td>
                </tr>
              </table></td>
          </tr>
       
          <tr>
            <td align="left" valign="top" class="right-bar-content-border">
			<form name="topicform" action="landing-page.php?action=alldelete&selected_menu=others" method="post">
			<table width="100%" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="22" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-title-text">#</span></td>
				<td width="31" height="30" align="center" valign="middle" class="right-border">
				<input type="checkbox" name="all" id="all" onclick="CheckAll('<?=$numRows?>');" /></td>
				<td width="197" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Name</span> </td>
				<td width="455" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Content Heading</span> </td>
				<td width="89" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Date</span> </td>
				<td width="167" height="30" align="center" valign="middle" class="left-border"><div align="center"><span class="right-box-title-text">Action</span></div></td>
			  </tr>
			<?php
			
			if($total_data>0) {
				$i=1;
				while ($data_sql = com_db_fetch_array($exe_data)) {
				$added_date = $data_sql['add_date'];
							
			?>          
			  <tr>
				<td height="30" align="center" valign="middle" class="right-border-left"><?=$i;?></td>
				<td height="30" align="center" valign="middle" class="right-border"><input type="checkbox" id="lp_id-<?=$i;?>" name="nid[]" value="<?=$data_sql['lp_id'];?>" /></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><a href="landing-page.php?action=detailes&selected_menu=others&lpID=<?=$data_sql['lp_id'];?>"><?=com_db_output($data_sql['lp_name'])?></a></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><?=com_db_output($data_sql['lp_content_title'])?></td>
				<td height="30" align="center" valign="middle" class="right-border"><?=$added_date;?></td>
				<td height="30" align="center" valign="middle" class="left-border">
					<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr> 
					  	<td width="47%" align="center" valign="middle"><a href="#"><img src="images/green-down-arrow.gif" width="16" height="16" alt="Download" name="Download" border="0" onclick="window.location='landing-page-create.php?lpID=<?=$data_sql['lp_id'];?>'" /></a><br />
						  Download</td>
						<td width="24%" align="center" valign="middle"><a href="#"><img src="images/small-edit-icon.gif" width="16" height="16" alt="Edit" name="Edit" border="0" onclick="window.location='landing-page.php?selected_menu=others&p=<?=$p;?>&lpID=<?=$data_sql['lp_id'];?>&action=edit'" /></a><br />
						  Edit</td>
						<td width="29%" align="center" valign="middle"><a href="#"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" name="Delete" border="0" onclick="confirm_del('<?=$data_sql['lp_id'];?>','<?=$p;?>')" /></a><br />
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
	<script language="javascript" type="text/javascript">
	function chk_form(){
		var name=document.getElementById('lp_name').value;
		if(name==''){
		alert("Please enter page name.");
		document.getElementById('lp_name').focus();
		return false;
		}
	
	}
	</script>
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">Landing Page Manager :: Edit Landing Page </td>
				  
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
			<form name="DateTest" method="post" action="landing-page.php?action=editsave&selected_menu=others&lpID=<?=$lpID;?>&p=<?=$p;?>" enctype="multipart/form-data" onsubmit="return chk_form();">
			<tr>
			  <td width="22%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Page Name:</td>
			  <td width="78%" align="left" valign="top">
				<input type="text" name="lp_name" id="lp_name" size="80" value="<?=$lp_name?>"/>
			  </td>	
			</tr>
			
			 <tr>
				<td width="22%" align="left" class="page-text" valign="top">&nbsp;&nbsp;Logo:</td>
				<td width="78%" align="left" valign="top">
				
				<input type="file" name="lp_logo" id="lp_logo" />
				</td>	
			</tr>
			<tr>
				<td  class="page-text" align="left" valign="top">&nbsp;&nbsp;&nbsp;Page Caption:</td>
				<td align="left" valign="top">
				<div id="loadingc"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1">Please wait<br><br>
				  </font><strong><font color="#993300" face="Verdana, Arial, Helvetica, sans-serif" >Editor 
				  Loading......</font></strong><br>
				  <br></div> <div id="fckc" style="">  
			  <!---------------------------->
			  
				<?php
				$oFCKeditor = new FCKeditor('lp_caption') ;
				$oFCKeditor->BasePath	= $sBasePath ;
				$oFCKeditor->ToolbarSet = ''; // Basic
				$oFCKeditor->Width  = '100%';
				$oFCKeditor->Height  = '250';       
				$oFCKeditor->Value		= $lp_caption ;
				$oFCKeditor->Create() ;
				
				?>
					</div>
				</td>
			</tr>
			<tr>
			  <td width="22%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Image Heading:</td>
			  <td width="78%" align="left" valign="top">
				<input type="text" name="lp_img_title" id="lp_img_title" size="80" value="<?=$lp_img_title?>" />
			  </td>	
			</tr>
			<tr>
			  <td width="22%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Image:</td>
			  <td width="78%" align="left" valign="top">
				<input type="file" name="lp_image" id="lp_image" />
			  </td>	
			</tr>
			<tr>
				<td  class="page-text" align="left" valign="top">&nbsp;&nbsp;&nbsp;Image Details:</td>
				<td align="left" valign="top">
				<div id="loading"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1">Please wait<br><br>
				  </font><strong><font color="#993300" face="Verdana, Arial, Helvetica, sans-serif" >Editor 
				  Loading......</font></strong><br>
				  <br></div> <div id="fck" style="">  
			  <!---------------------------->
			  
				<?php
				$oFCKeditor = new FCKeditor('lp_img_desc') ;
				$oFCKeditor->BasePath	= $sBasePath ;
				$oFCKeditor->ToolbarSet = ''; // Basic
				$oFCKeditor->Width  = '100%';
				$oFCKeditor->Height  = '400';       
				$oFCKeditor->Value		= $lp_img_desc ;
				$oFCKeditor->Create() ;
				
				?>
					</div>
				</td>
			</tr>
			<tr>
			  <td width="22%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Content Heading:</td>
			  <td width="78%" align="left" valign="top">
				<input type="text" name="lp_content_title" id="lp_content_title" size="80" value="<?=$lp_content_title?>"/>
			  </td>	
			</tr>
			<tr>
				<td  class="page-text" align="left" valign="top">&nbsp;&nbsp;&nbsp;Content Details:</td>
				<td align="left" valign="top">
				<div id="fck" style="">  
			  <!---------------------------->
			  
				<?php
				$oFCKeditor = new FCKeditor('lp_content_desc') ;
				$oFCKeditor->BasePath	= $sBasePath ;
				$oFCKeditor->ToolbarSet = ''; // Basic
				$oFCKeditor->Width  = '100%';
				$oFCKeditor->Height  = '400';       
				$oFCKeditor->Value		= $lp_content_desc;
				$oFCKeditor->Create() ;
				
				?>
					</div>
				</td>
			</tr>
			
			
			<tr>
			<td  class="page-text" align="left" valign="top">&nbsp;&nbsp;&nbsp;First name:</td>
			<td align="left" valign="top">
			<input type="text" name="lp_fname" id="lp_fname" value="<?=$lp_fname?>" />
			</td>
		</tr>
		<tr>
			<td  class="page-text" align="left" valign="top">&nbsp;&nbsp;&nbsp;Last name:</td>
			<td align="left" valign="top">
			<input type="text" name="lp_lname" id="lp_lname" value="<?=$lp_lname?>" />
			</td>
		</tr>
		<tr>
			<td  class="page-text" align="left" valign="top">&nbsp;&nbsp;&nbsp;Email:</td>
			<td align="left" valign="top">
			<input type="text" name="lp_email" id="lp_email" value="<?=$lp_email?>" />
			</td>
		</tr>
		<tr>
			<td  class="page-text" align="left" valign="top">&nbsp;&nbsp;&nbsp;Message:</td>
			<td align="left" valign="top">
			<textarea name="lp_message" cols="30" rows="3"><?=$lp_message?></textarea>
			</td>
		</tr>
			
			
			
			<tr><td align="left" valign="top">&nbsp;</td><td align="left" valign="top"><div id="butt" style="display:none;"><input type="submit" value="Update Landing Page" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="Cancel" onclick="window.location='landing-page.php?p=<?=$p;?>&lpID=<?=$lpID;?>&selected_menu=others'" /></div></td></tr>
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
	var name=document.getElementById('lp_name').value;
	if(name==''){
	alert("Please enter page name.");
	document.getElementById('lp_name').focus();
	return false;
	}

}
</script>
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">Landing Page Manager :: Add Landing Page </td>
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
		<form name="DateTest" method="post" action="landing-page.php?action=addsave&p=<?=$p;?>" enctype="multipart/form-data" onsubmit="return chk_form();">
		<tr>
		  <td width="22%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Page Name:</td>
		  <td width="78%" align="left" valign="top">
			<input type="text" name="lp_name" id="lp_name" size="80" />
		  </td>	
		</tr>
		
		 <tr>
		  	<td width="22%" align="left" class="page-text" valign="top">&nbsp;&nbsp;Logo:</td>
		  	<td width="78%" align="left" valign="top">
			<input type="file" name="lp_logo" id="lp_logo" />
		  	</td>	
		</tr>
		<tr>
				<td  class="page-text" align="left" valign="top">&nbsp;&nbsp;&nbsp;Page Caption:</td>
				<td align="left" valign="top">
				<div id="loadingc"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1">Please wait<br><br>
				  </font><strong><font color="#993300" face="Verdana, Arial, Helvetica, sans-serif" >Editor 
				  Loading......</font></strong><br>
				  <br></div> <div id="fckc" style="">  
			  <!---------------------------->
			  
				<?php
				$oFCKeditor = new FCKeditor('lp_caption') ;
				$oFCKeditor->BasePath	= $sBasePath ;
				$oFCKeditor->ToolbarSet = ''; // Basic
				$oFCKeditor->Width  = '100%';
				$oFCKeditor->Height  = '250';       
				$oFCKeditor->Value		= $lp_caption ;
				$oFCKeditor->Create() ;
				
				?>
					</div>
				</td>
			</tr>
		<tr>
		  <td width="22%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Image Heading:</td>
		  <td width="78%" align="left" valign="top">
			<input type="text" name="lp_img_title" id="lp_img_title" size="80" />
		  </td>	
		</tr>
		<tr>
		  <td width="22%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Image:</td>
		  <td width="78%" align="left" valign="top">
		  	<input type="file" name="lp_image" id="lp_image" />
		  </td>	
		</tr>
		<tr>
			<td  class="page-text" align="left" valign="top">&nbsp;&nbsp;&nbsp;Image Details:</td>
			<td align="left" valign="top">
			<div id="loading"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1">Please wait<br><br>
			  </font><strong><font color="#993300" face="Verdana, Arial, Helvetica, sans-serif" >Editor 
			  Loading......</font></strong><br>
			  <br></div> <div id="fck" style="">  
		  <!---------------------------->
		  
			<?php
			$oFCKeditor = new FCKeditor('lp_img_desc') ;
			$oFCKeditor->BasePath	= $sBasePath ;
			$oFCKeditor->ToolbarSet = ''; // Basic
			$oFCKeditor->Width  = '100%';
			$oFCKeditor->Height  = '400';       
			$oFCKeditor->Value		= '' ;
			$oFCKeditor->Create() ;
			
			?>
				</div>
			</td>
		</tr>
		<tr>
		  <td width="22%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Content Heading:</td>
		  <td width="78%" align="left" valign="top">
			<input type="text" name="lp_content_title" id="lp_content_title" size="80" />
		  </td>	
		</tr>
		<tr>
			<td  class="page-text" align="left" valign="top">&nbsp;&nbsp;&nbsp;Content Details:</td>
			<td align="left" valign="top">
			<div id="fck" style="">  
		  <!---------------------------->
		  
			<?php
			$oFCKeditor = new FCKeditor('lp_content_desc') ;
			$oFCKeditor->BasePath	= $sBasePath ;
			$oFCKeditor->ToolbarSet = ''; // Basic
			$oFCKeditor->Width  = '100%';
			$oFCKeditor->Height  = '400';       
			$oFCKeditor->Value		= '' ;
			$oFCKeditor->Create() ;
			
			?>
				</div>
			</td>
		</tr>
		
		<tr>
			<td  class="page-text" align="left" valign="top">&nbsp;&nbsp;&nbsp;First name:</td>
			<td align="left" valign="top">
			<input type="text" name="lp_fname" id="lp_fname" />
			</td>
		</tr>
		<tr>
			<td  class="page-text" align="left" valign="top">&nbsp;&nbsp;&nbsp;Last name:</td>
			<td align="left" valign="top">
			<input type="text" name="lp_lname" id="lp_lname" />
			</td>
		</tr>
		<tr>
			<td  class="page-text" align="left" valign="top">&nbsp;&nbsp;&nbsp;Email:</td>
			<td align="left" valign="top">
			<input type="text" name="lp_email" id="lp_email" />
			</td>
		</tr>
		<tr>
			<td  class="page-text" align="left" valign="top">&nbsp;&nbsp;&nbsp;Message:</td>
			<td align="left" valign="top">
			<textarea name="lp_message" cols="30" rows="3"></textarea>
			</td>
		</tr>
		
		
		
		
		
		
		
		
		
		
		
		<tr><td align="left" valign="top">&nbsp;</td><td align="left" valign="top"><div id="butt" style="display:none;"><input type="submit" value="Add Landing Page" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='landing-page.php?p=<?=$p;?>&lpID=<?=$lpID;?>&selected_menu=others'" /></div></td></tr>
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
                  <td width="50%" align="left" valign="middle" class="heading-text">Landing Page Manager :: Landing Page Details </td>
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="left" valign="top" class="right-border">
		
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td align="left" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td align="center" valign="top" class="top-header-bg-lp"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
				  <tr>
					<td align="left" valign="top"><img src="../images/specer.gif" width="1" height="25" alt="" title="" /></td>
				  </tr>
				  <tr>
					<td align="center" valign="top"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr>
						<td width="150" align="left" valign="top"><a href="index.html"><img src="../landing-page/logo/<?=$lp_logo?>"  alt="Logo" border="0" title="Logo" /></a></td>
						<td align="left" valign="top">&nbsp;</td>
						<td align="left" valign="top" class="login-register-bg-lp">&nbsp;</td>
					  </tr>
					</table></td>
				  </tr>
				  <tr>
					  <td align="left" valign="top"><img src="../images/specer.gif" width="1" height="20" alt="" title="" /></td>
				  </tr>
			 
			   
				</table></td>
			  </tr>
			</table></td>
			  </tr>
				<tr>
				  <td align="left" valign="top"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
			
				  <tr>
				  <td align="left" valign="middle" class="landing-page-heading-bg-lp"><table width="95%" border="0" align="left" cellpadding="0" cellspacing="0">
				 
					<tr>
					  <td align="left" valign="middle" class="landing-page-title-text-lp"><?=$lp_caption?></td>
					</tr>
				  </table></td>
				  </tr>
				
				  </table></td>
			    </tr>
			
				<tr>
				  <td align="center" valign="top" class="registration-page-bg-lp"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
					  <td align="center" valign="top"><img src="../images/specer.gif" width="1" height="5" alt="" title="" /></td>
					</tr>
					<tr>
					  <td align="center" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
						<tr>
						  <td width="32%" align="center" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
							<tr>
							  <td align="center" valign="top"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
							<tr>
							  <td align="left" valign="top">&nbsp;</td>
							</tr>
							<tr>
							  <td align="left" valign="top" class="left-box-text-lp"><?=$lp_img_title?></td>
							</tr>
							<tr>
							<td align="left" valign="top"><img src="../landing-page/images/specer.gif" width="1" height="8" alt="" title="" /></td>
							</tr>
							<tr>
							  <td align="left" valign="top">&nbsp;</td>
							</tr>
							<tr>
							  <td align="left" valign="top"><img src="../landing-page/img_file/<?=$lp_image?>"  alt="" title="" /></td>
							</tr>
							<tr>
							  <td align="left" valign="top">&nbsp;</td>
							</tr>
							<tr>
							  <td align="left" valign="top" class="content-text-lp"><?=$lp_img_desc?></td>
							</tr>
							<tr>
							  <td align="left" valign="top">&nbsp;</td>
							</tr>
						  </table></td>
							</tr>
						  </table></td>
						  <td width="41%" align="left" valign="top"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
							<tr>
							  <td align="left" valign="top" class="left-box-text-lp">&nbsp;</td>
							</tr>
							<tr>
							  <td align="left" valign="top" class="left-box-text-lp"><?=$lp_content_title?></td>
							</tr>
							<tr>
							  <td align="left" valign="top">&nbsp;</td>
							</tr>
							<tr>
							  <td align="left" valign="top" class="content-text-lp"><?=$lp_content_desc?></td>
							</tr>
							<tr>
							  <td align="left" valign="top">&nbsp;</td>
							</tr>
							
						  </table></td>
						  <td width="27%" align="left" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
							<tr>
							  <td align="center" valign="top"><table width="90%" border="0" align="center" cellpadding="2" cellspacing="0">
								<tr>
								  <td align="left" valign="middle">&nbsp;</td>
								</tr>
								<tr>
								  <td align="left" valign="top" class="contact-form-box-text-lp"><h4>Contact Us </h4></td>
						 </tr>
						   <tr>
							<td align="left" valign="top">&nbsp;</td>
							</tr>
						  
								<tr>
								  <td align="left" valign="middle" class="contact-form-box-text-lp">First Name</td>
								</tr>
								<tr>
								  <td align="left" valign="middle" class="contact-form-box-text-lp">
								  <input name="" type="text" size="30"  value="<?=$lp_fname?>" /></td>
								</tr>
								<tr>
								  <td align="left" valign="middle" class="contact-form-box-text-lp">Last Name</td>
								</tr>
								<tr>
								  <td align="left" valign="middle" class="contact-form-box-text-lp"><input name="" type="text" size="30"  value="<?=$lp_lname?>" /></td>
								</tr>
								<tr>
								  <td align="left" valign="middle" class="contact-form-box-text-lp">Email (we will keep your email completely private)</td>
								</tr>
								<tr>
								  <td align="left" valign="middle" class="contact-form-box-text-lp"> <input name="" type="text" size="30"  value="<?=$lp_email?>" /></td>
								</tr>
								<tr>
								  <td align="left" valign="middle" class="contact-form-box-text-lp">Message</td>
								</tr>
								<tr>
								  <td align="left" valign="middle" class="contact-form-box-text-lp">
								  <textarea name="textarea" cols="23" rows="4"><?=$lp_message?></textarea>                      </td>
								</tr>
								<tr>
								  <td align="left" valign="middle"><input name="image" type="image" onMouseOver="this.src='../landing-page/images/submit-buttn-h.jpg'" onMouseOut="this.src='../landing-page/images/submit-buttn.jpg'" value="Sign Up" src="../landing-page/images/submit-buttn.jpg"  alt="Sign Up"/></td>
								</tr>
								<tr>
								  <td align="left" valign="middle">&nbsp;</td>
								</tr>
							  </table></td>
							</tr>
						  </table></td>
						</tr>
					  </table></td>
					</tr>
					<tr>
					  <td align="center" valign="top">&nbsp;</td>
					</tr>
					<tr>
					  <td align="left" valign="top"><input type="button" class="submitButton" value="Back" onclick="window.location='landing-page.php?p=<?=$p;?>&lpID=<?=$lpID;?>&selected_menu=others'" /></td>
					</tr>
					<tr>
					  <td align="center" valign="top">&nbsp;</td>
					</tr>
				  </table></td>
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