<?php
require('includes/include_top.php');


$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 20;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;

$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';
$find = (isset($_GET['find']) ? $_GET['find'] : '');

$sql_query = "select * from " . TABLE_ADMIN . " where access_type='User' order by admin_id";
  /***************** FOR PAGIN ***********************/
$starting_point = $items_per_page * ($p - 1);
/****************** END PAGIN ***********************/
$main_page = 'staff.php';

$exe_query=com_db_query($sql_query);
$num_rows=com_db_num_rows($exe_query);
$total_data = $num_rows;

/************ FOR PAGIN **************/
$sql_query .= " LIMIT $starting_point,$items_per_page";
$exe_data = com_db_query($sql_query);

$numRows = com_db_num_rows($exe_data);
/************ END ********************/
$sID = (isset($_GET['sID']) ? $_GET['sID'] : '');

   switch ($action) {
	   
	   case 'addsave':
	
		$first_name = com_db_input($_POST['first_name']);
		$last_name = com_db_input($_POST['last_name']);
		$upassword = trim($_POST['password']);
		$ucpassword = trim($_POST['cpassword']);
		$email_address = com_db_input($_POST['email_address']);
		if($upassword!=$ucpassword){
			com_redirect("staff.php?selected_menu=staff&e=y&msg=" . msg_encode("Your password and confirm password are not equal."));	
		}
		
		
		$add_date = date("Y-m-d H:i:s");
		
		com_db_query("insert into " . TABLE_ADMIN . " (admin_firstname,admin_lastname,admin_email_address, admin_password, password, access_type, admin_created) values ('$first_name','$last_name','$email_address', '".md5($ucpassword)."','".$ucpassword."','User', '$add_date')");
		$staff_id = com_db_insert_id();
		
		$user_id = $staff_id;
		$mm_id_arr = $_POST['mm_id'];
		$add_date = date("Y-m-d");
		
		for($i=0; $i< sizeof($mm_id_arr);$i++){
			$inserQuery = "insert into ".TABLE_USER_MENU_ALLOW." (user_id,mm_id,add_date,status) values('$user_id','".$mm_id_arr[$i]."','$add_date','0')";
			com_db_query($inserQuery);
			$uma_id = com_db_insert_id();
			$mm_id = $mm_id_arr[$i];
			$mmid = 'sm_id_'.$mm_id;
			$sm_id_arr = $_POST[$mmid];
			for($j=0;$j< sizeof($sm_id_arr);$j++){
				$sm_add = 'smid_add_'.$sm_id_arr[$j];
				$madd = $_POST[$sm_add];
				$sm_edit = 'smid_edit_'.$sm_id_arr[$j];
				$medit = $_POST[$sm_edit];
				$sm_del = 'smid_del_'.$sm_id_arr[$j];
				$mdel = $_POST[$sm_del];
				$sm_status = 'smid_status_'.$sm_id_arr[$j];
				$mstatus = $_POST[$sm_status];
				
				$inserQuery = "insert into ".TABLE_USER_SUB_MENU_ALLOW." (uma_id,user_id,mm_id,sm_id,madd,medit,mdelete,mstatus) values('$uma_id','$user_id','".$mm_id_arr[$i]."','".$sm_id_arr[$j]."','$madd','$medit','$mdel','$mstatus')";
				com_db_query($inserQuery);
			}
		}

		com_redirect("staff.php?selected_menu=staff&msg=" . msg_encode("Staff added successfully"));
		
	   break;
	   
	   
	   case 'edit':

		$edit_sql = com_db_query("select * from " . TABLE_ADMIN . " where admin_id = '" . $sID . "'");
		$edit_data = com_db_fetch_array($edit_sql);
		
		$query_edit = com_db_query("select * from " . TABLE_USER_MENU_ALLOW . " where user_id = '" . $sID . "'");
	  	$data_edit = com_db_fetch_array($query_edit);
		
		
	   break;

	   case 'editsave':
		$upassword = trim($_POST['password']);
		$ucpassword = trim($_POST['cpassword']);
		
		if($upassword!=$ucpassword){
			com_redirect("staff.php?selected_menu=staff&e=y&p=".$p."&sID=".$sID."&action=edit&msg=" . msg_encode("Your password and confirm password are not equal."));	
		}
		
		$first_name = com_db_input($_POST['first_name']);
		$last_name = com_db_input($_POST['last_name']);
		$email_address = com_db_input($_POST['email_address']);
		$modify_date = date("Y-m-d H:i:s");
		
		com_db_query("update " . TABLE_ADMIN . " set admin_password = '" . md5($ucpassword) . "', password ='".$ucpassword."', admin_firstname = '" . $first_name . "', admin_lastname = '" . $last_name . "', admin_email_address = '" . $email_address . "', admin_modified = '" . $modify_date . "' where admin_id = '" . $sID . "'");
		$user_id = $sID;
		$del_main_menu = "delete from ".TABLE_USER_MENU_ALLOW." where user_id='".$user_id."'";
		com_db_query($del_main_menu);
		$del_sub_main_menu = "delete from ".TABLE_USER_SUB_MENU_ALLOW." where user_id='".$user_id."'";
		com_db_query($del_sub_main_menu);
		
		$mm_id_arr = $_POST['mm_id'];
		$add_date = date("Y-m-d");
		
		for($i=0; $i< sizeof($mm_id_arr);$i++){
			$inserQuery = "insert into ".TABLE_USER_MENU_ALLOW." (user_id,mm_id,add_date,status) values('$user_id','".$mm_id_arr[$i]."','$add_date','0')";
			com_db_query($inserQuery);
			$uma_id = com_db_insert_id();
			$mm_id = $mm_id_arr[$i];
			$mmid = 'sm_id_'.$mm_id;
			$sm_id_arr = $_POST[$mmid];
			for($j=0;$j< sizeof($sm_id_arr);$j++){
				$sm_add = 'smid_add_'.$sm_id_arr[$j];
				$madd = $_POST[$sm_add];
				$sm_edit = 'smid_edit_'.$sm_id_arr[$j];
				$medit = $_POST[$sm_edit];
				$sm_del = 'smid_del_'.$sm_id_arr[$j];
				$mdel = $_POST[$sm_del];
				$sm_status = 'smid_status_'.$sm_id_arr[$j];
				$mstatus = $_POST[$sm_status];
				$sm_re = 'smid_re_'.$sm_id_arr[$j];
				$mre = $_POST[$sm_re];
				$sm_send = 'smid_send_'.$sm_id_arr[$j];
				$msend = $_POST[$sm_send];
				$inserQuery = "insert into ".TABLE_USER_SUB_MENU_ALLOW." (uma_id,user_id,mm_id,sm_id,madd,medit,mdelete,mstatus,mrearrange,msendactivation) values('$uma_id','$user_id','".$mm_id_arr[$i]."','".$sm_id_arr[$j]."','$madd','$medit','$mdel','$mstatus','$mre','$msend')";
				com_db_query($inserQuery);
			}
		}
		
		com_redirect("staff.php?p=" . $p . "&selected_menu=staff&msg=" . msg_encode("Staff update successfully"));
		
	   break;
	  
	   case 'delete':
	   
	   	com_db_query("delete from " . TABLE_ADMIN . " where admin_id = '" . $sID . "'");
		com_db_query("delete from " . TABLE_USER_MENU_ALLOW . " where user_id = '" . $sID . "'");
		com_db_query("delete from " . TABLE_USER_SUB_MENU_ALLOW . " where user_id = '" . $sID . "'");
		
	    com_redirect("staff.php?p=" . $p . "&selected_menu=staff&msg=" . msg_encode("Staff deleted successfully"));
	   
	   break;
	  
    }
	
include("includes/header.php");
?>

<script type="text/javascript">
function confirm_del(sID,p){
	var agree=confirm("Staff will be deleted. \n Do you want to continue?");
	if (agree)
		window.location = "staff.php?selected_menu=staff&sID=" + sID + "&p=" + p + "&action=delete";
	else
		window.location = "staff.php?selected_menu=staff&sID=" + sID + "&p=" + p;
}


</script>
<script type="text/javascript">
function UsercheckSearchForm(){
	var str=document.getElementById('str').value;
	if(str==''){
		alert("Please enter email or name or phone.");
		document.getElementById('str').focus();
		return false;
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
            <td align="center" valign="middle" class="right"><table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="44%" align="left" valign="middle" class="heading-text">Staff Maneger</td>
                  <?php if($btnAdd=='Yes'){ ?>
                  <td width="46%" align="right" valign="middle"><a href="#"><img src="images/add-icon.jpg" border="0" width="25" height="28" alt="Add New" title="Add New" onclick="window.location='staff.php?action=add&selected_menu=staff&sID=<?=$sID;?>'"  /></a></td>
                  <td width="10%" align="left" valign="middle" class="nav-text">Add New</td>
                  <?php } ?>
                </tr>
              </table></td>
          </tr>
       
          <tr>
            <td align="left" valign="top" class="right-bar-content-border">
			<form name="topicform" action="staff.php?selected_menu=staff" method="post">
			<table width="100%" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="18" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-title-text">#</span></td>
				<td width="100" height="30" align="left" valign="middle" class="right-border"><span class="right-box-title-text">Full Name</span> </td>
                <td width="117" height="30" align="left" valign="middle" class="right-border"><span class="page-text">Email/Login ID</span></td>
				<td width="81" height="30" align="left" valign="middle" class="right-border"><span class="right-box-title-text">Password</span> </td>
				<td width="54" height="30" align="left" valign="middle" class="right-border"><span class="right-box-title-text">Type</span> </td> 
				<td width="79" height="30" align="left" valign="middle" class="right-border"><span class="right-box-title-text">Add Date</span></td>
				<td width="84" height="30" align="center" valign="middle" class="left-border"><div align="center"><span class="right-box-title-text">Action</span></div></td>
			  </tr>
			<?php
			
			if($total_data>0) {
				
				$i=1;
				while ($data_sql = com_db_fetch_array($exe_data)) {
					$status = $data_sql['status'];
					$add_dt = explode(' ',$data_sql['admin_created']);
					$add_date = $add_dt[0];
			?>          
			  <tr>
				<td height="30" align="center" valign="middle" class="right-border-left"><?=$i;?></td>
				<td height="30" align="center" valign="middle" class="right-border-text"><?=com_db_output($data_sql['admin_firstname'].' '.$data_sql['admin_lastname'])?></td>
                <td height="30" align="center" valign="middle" class="right-border-text"><?=$data_sql['admin_email_address']?></td>
				<td height="30" align="center" valign="middle" class="right-border-text"><?=$data_sql['password']?></td>
                <td height="30" align="center" valign="middle" class="right-border-text"><?=$data_sql['access_type']?></td>
				<td height="30" align="center" valign="middle" class="right-border-text"><?=$add_date;?></td>
				<td height="30" align="center" valign="middle" class="left-border">
					<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr>
                      	 <?php if($btnEdit=='Yes'){ ?>
						<td width="62%" align="center" valign="middle"><a href="#"><img src="images/small-edit-icon.gif" width="16" height="16" alt="Edit" title="Edit" border="0" onclick="window.location='staff.php?selected_menu=staff&p=<?=$p;?>&sID=<?=$data_sql['admin_id'];?>&action=edit'" /></a><br />
						  Edit</td>
                      	<?php } 
					  	if($btnDelete=='Yes'){ ?>    
						<td width="38%" align="center" valign="middle"><a href="#"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" title="Delete" border="0" onclick="confirm_del('<?=$data_sql['admin_id'];?>','<?=$p;?>')" /></a><br />
						  Delete</td>
					  	<?php } ?>	
					  </tr>
					</table></td>
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
	
	var fname=document.getElementById('first_name').value;
	if(fname==''){
		alert("Please enter staff first name.");
		document.getElementById('first_name').focus();
		return false;
	}
	var lname=document.getElementById('last_name').value;
	if(lname==''){
		alert("Please enter staff last name.");
		document.getElementById('last_name').focus();
		return false;
	}
	var email=document.getElementById('email').value;
	if(email==''){
		alert("Please enter email.");
		document.getElementById('email').focus();
		return false;
	}
	var password=document.getElementById('password').value;
	if(password==''){
		alert("Please enter password.");
		document.getElementById('password').focus();
		return false;
	}
	if(password!=''){
		var cpassword=document.getElementById('cpassword').value;
		if(cpassword==''){
			alert("Please enter confirm password.");
			document.getElementById('cpassword').focus();
			return false;
		}
		if(password!=cpassword){
			alert("Your password and confirm password are not equal.");
			document.getElementById('cpassword').focus();
			return false;
		}
	}
}


function ShowCategoryMenuDiv(id){
	var menuval = document.form_data.category_menu.checked;
	if(menuval==true){
		document.getElementById(id).style.display="block";
	}else if(menuval==false){
		document.getElementById(id).style.display="none";
	}
}

function ShowAddMenuDiv(id){
	var menuval = document.form_data.add_menu.checked;
	if(menuval==true){
		document.getElementById(id).style.display="block";
	}else if(menuval==false){
		document.getElementById(id).style.display="none";
	}

}

function ShowBannerMenuDiv(id){
	var menuval = document.form_data.banner_menu.checked;
	if(menuval==true){
		document.getElementById(id).style.display="block";
	}else if(menuval==false){
		document.getElementById(id).style.display="none";
	}
}

function ShowCityMenuDiv(id){
	var menuval = document.form_data.city_menu.checked;
	if(menuval==true){
		document.getElementById(id).style.display="block";
	}else if(menuval==false){
		document.getElementById(id).style.display="none";
	}
}

function ShowUserMenuDiv(id){
	var menuval = document.form_data.user_menu.checked;
	if(menuval==true){
		document.getElementById(id).style.display="block";
	}else if(menuval==false){
		document.getElementById(id).style.display="none";
	}
}

function ShowFaqMenuDiv(id){
	var menuval = document.form_data.faq_menu.checked;
	if(menuval==true){
		document.getElementById(id).style.display="block";
	}else if(menuval==false){
		document.getElementById(id).style.display="none";
	}

}
function ShowContentMenuDiv(id){
	var menuval = document.form_data.content_menu.checked;
	if(menuval==true){
		document.getElementById(id).style.display="block";
	}else if(menuval==false){
		document.getElementById(id).style.display="none";
	}

}



</script>
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">Staff :: Edit </td>
				  
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top"  class="right-bar-content-border-box"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="left" valign="top">
		 <!--start iner table  -->
			<table width="99%" align="left" cellpadding="3" cellspacing="3" border="0">
			<form name="form_data" method="post" action="staff.php?selected_menu=staff&action=editsave&sID=<?=$sID;?>&p=<?=$p;?>" onsubmit="return chk_form();">
				<tr>
				  <td width="20%" align="left" valign="top" class="page-text">&nbsp;&nbsp;&nbsp;First Name:</td>
				  <td width="80%" colspan="2" align="left" valign="top" class="page-text">
					<input type="text" name="first_name" id="first_name" value="<?=$edit_data['admin_firstname']?>" size="30" />
				  </td>	
				</tr>
                <tr>
				  <td width="20%" align="left" valign="top" class="page-text">&nbsp;&nbsp;&nbsp;Last Name:</td>
				  <td width="80%" colspan="2" align="left" valign="top" class="page-text">
					<input type="text" name="last_name" id="last_name" value="<?=$edit_data['admin_lastname']?>" size="30" />
				  </td>	
				</tr>
                <tr>
				  <td width="20%" align="left" valign="top" class="page-text">&nbsp;&nbsp;&nbsp;Email/Login ID:</td>
				  <td align="left" valign="top" class="page-text" colspan="2">
					<input type="text" name="email_address" id="email_address" size="30" value="<?=com_db_output($edit_data['admin_email_address'])?>" />
				  </td>	
				</tr>
				<tr>
				  <td width="20%" align="left" valign="top" class="page-text">&nbsp;&nbsp;&nbsp;Password:</td>
				  <td align="left" valign="top" class="page-text" colspan="2">
					<input type="text" name="password" id="password" value="<?=$edit_data['password']?>" size="30" />
				  </td>
				</tr>
				
				<tr>
				  <td width="20%" align="left" valign="top" class="page-text">&nbsp;&nbsp;&nbsp;Confirm Password:</td>
				  <td align="left" valign="top" class="page-text" colspan="2">
					<input type="text" name="cpassword" id="cpassword" value="<?=$edit_data['password']?>" size="30" />
				  </td>
				</tr>
				
				<tr>
                	<td colspan="3">
                    	<table width="100%" border="0" cellpadding="2" cellspacing="2">
                        	<tr style="background-color:#CCC;">
                                <td width="28%" class="page-text" align="left"><b>Main Menu</b></td>
                                <td width="31%" class="page-text" align="left"><b>Sub Menu</b></td>
                                <td width="41%" class="page-text" align="center"><b>Action</b></td>
                            </tr>
                            <?php
                            $mmResult = com_db_query("select * from ".TABLE_MAIN_MENU);
                            while($mmRow = com_db_fetch_array($mmResult)){
                                $mmIsAccess = com_db_GetValue("select uma_id from ".TABLE_USER_MENU_ALLOW." where mm_id='".$mmRow['mm_id']."' and user_id='".$sID."'");
                             ?>
                            <tr>
                                <td align="left" valign="top" class="page-text"><input type="checkbox" name="mm_id[]" value="<?php echo $mmRow['mm_id'];?>" <?php if($mmIsAccess !=''){echo 'checked="checked"';} ?> /><?php echo $mmRow['mm_name'];?></td>
                                <td colspan="2">
                                    <table width="100%" cellpadding="1" cellspacing="1" border="0">
                                        <?php
                                        $smResult = com_db_query("select * from ".TABLE_SUB_MENU." where mm_id='".$mmRow['mm_id']."'");
                                        while($smRow = com_db_fetch_array($smResult)){
                                            $sub_arr =explode("#",com_db_GetValue("select concat(sm_id,'#',madd,'#',medit,'#',mdelete,'#',mstatus,'#',mrearrange,'#',msendactivation) from ".TABLE_USER_SUB_MENU_ALLOW." where user_id='".$sID."' and sm_id='".$smRow['sm_id']."' and mm_id='".$mmRow['mm_id']."'"));
                                            $smIsAccess = $sub_arr[0];
                                            $isAdd = $sub_arr[1];
                                            $isEdit = $sub_arr[2];
                                            $isDelete = $sub_arr[3];
                                            $isStatus = $sub_arr[4];
											$isReArrange = $sub_arr[5];
											$isSendActivation = $sub_arr[6];
                                         ?>
                                        <tr>
                                            <td width="53%" class="page-text"><input type="checkbox" name="sm_id_<?php echo $mmRow['mm_id'];?>[]" value="<?php echo $smRow['sm_id'];?>" <?php if($smIsAccess !=''){echo 'checked="checked"';} ?>/><?php echo $smRow['sm_name'];?></td>
                                            <td width="10%" class="page-text"><input type="checkbox" name="smid_add_<?php echo $smRow['sm_id'];?>" <?php if($smRow['sm_add']!='Yes'){echo 'disabled="disabled"';}?> value="Yes" <?php if($isAdd =='Yes'){echo 'checked="checked"';} ?>/>Add</td>
                                            <td width="9%" class="page-text"><input type="checkbox" name="smid_edit_<?php echo $smRow['sm_id'];?>" <?php if($smRow['sm_edit']!='Yes'){echo 'disabled="disabled"';}?> value="Yes" <?php if($isEdit =='Yes'){echo 'checked="checked"';} ?>/>Edit</td>
                                            <td width="14%" class="page-text"><input type="checkbox" name="smid_del_<?php echo $smRow['sm_id'];?>" <?php if($smRow['sm_delete']!='Yes'){echo 'disabled="disabled"';}?> value="Yes" <?php if($isDelete =='Yes'){echo 'checked="checked"';} ?>/>Delete</td>
                                            <td width="14%" class="page-text"><input type="checkbox" name="smid_status_<?php echo $smRow['sm_id'];?>" <?php if($smRow['sm_status']!='Yes'){echo 'disabled="disabled"';}?> value="Yes" <?php if($isStatus =='Yes'){echo 'checked="checked"';} ?>/>Status</td>
                                       </tr>
                                       <tr><td colspan="7" style="height:10px;"></td></tr>
                                        <?php } ?>	
                                    </table>						</td>
                            </tr>
                            <tr><td colspan="3" style="height:5px;border-top:1px solid #999;"></td></tr>
                            <?php } ?>
                        </table>
                    </td>
                </tr>    
			<tr><td align="left" valign="top">&nbsp;</td><td align="left" valign="top" colspan="2"><input type="submit" value="Update Staff" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="Cancel" onclick="window.location='staff.php?p=<?=$p;?>&pID=<?=$pID;?>&selected_menu=staff&sID=<?=$sID;?>'" /></td></tr>
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
	var fname=document.getElementById('first_name').value;
	if(fname==''){
		alert("Please enter first name.");
		document.getElementById('first_name').focus();
		return false;
	}
	var lname=document.getElementById('last_name').value;
	if(lname==''){
		alert("Please enter last name.");
		document.getElementById('last_name').focus();
		return false;
	}
	var email=document.getElementById('email_address').value;
	if(email==''){
		alert("Please enter email.");
		document.getElementById('email_address').focus();
		return false;
	}
	var password=document.getElementById('password').value;
	if(password==''){
		alert("Please enter password.");
		document.getElementById('password').focus();
		return false;
	}
	
	if(password!=''){
		
		var cpassword=document.getElementById('cpassword').value;
		if(cpassword==''){
			alert("Please enter confirm password.");
			document.getElementById('cpassword').focus();
			return false;
		}
		if(password!=cpassword){
			alert("Your password and confirm password are not equal.");
			document.getElementById('cpassword').focus();
			return false;
		}
	}
}



</script>
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">Staff :: Add New</td>
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="left" valign="top" class="right-border-box">
		 <!--start iner table  -->
         <form name="form_data" method="post" action="staff.php?selected_menu=staff&action=addsave&p=<?=$p;?>" onsubmit="return chk_form();">
		  <table width="100%" align="left" cellpadding="3" cellspacing="3" border="0">
		<!--<tr>
		  <td width="20%" align="left" valign="top" class="page-text">&nbsp;&nbsp;&nbsp;Username:</td>
		  <td width="80%" colspan="2" align="left" valign="top" class="page-text">
			<input type="text" name="username" id="username" size="30" onBlur="UsernameCheck();" /><br />
			<div id="div_err_username"><span class="error-text"><?=$msg?></span></div>
		  </td>	
		</tr>-->
        <tr>
		  <td width="20%" align="left" valign="top" class="page-text">&nbsp;&nbsp;&nbsp;First Name:</td>
		  <td align="left" valign="top" class="page-text" colspan="2">
			<input type="text" name="first_name" id="first_name" size="30" />
		  </td>	
		</tr>
         <tr>
		  <td width="20%" align="left" valign="top" class="page-text">&nbsp;&nbsp;&nbsp;Last Name:</td>
		  <td align="left" valign="top" class="page-text" colspan="2">
			<input type="text" name="last_name" id="last_name" size="30" />
		  </td>	
		</tr>
        <tr>
		  <td width="20%" align="left" valign="top" class="page-text">&nbsp;&nbsp;&nbsp;Email/Login ID:</td>
		  <td align="left" valign="top" class="page-text" colspan="2">
			<input type="text" name="email_address" id="email_address" size="30" />
		  </td>	
		</tr>
		<tr>
		  <td width="20%" align="left" valign="top" class="page-text">&nbsp;&nbsp;&nbsp;Password:</td>
		  <td align="left" valign="top" class="page-text" colspan="2">
			<input type="text" name="password" id="password" size="30" />
		  </td>
		</tr>
		<tr>
		  <td width="20%" align="left" valign="top" class="page-text">&nbsp;&nbsp;&nbsp;Confirm Password:</td>
		  <td align="left" valign="top" class="page-text" colspan="2">
			<input type="text" name="cpassword" id="cpassword" size="30" />
		  </td>
		</tr>
		
        <tr>
            <td colspan="3">
                <table width="100%" border="0" cellpadding="2" cellspacing="2">
                    <tr style="background-color:#CCC;">
                        <td width="27%" class="page-text" align="left"><b>Main Menu</b></td>
                        <td width="31%" class="page-text" align="left"><b>Sub Menu</b></td>
                        <td width="42%" class="page-text" align="center"><b>Action</b></td>
                    </tr>
                    <?php
                    $mmResult = com_db_query("select * from ".TABLE_MAIN_MENU);
                    while($mmRow = com_db_fetch_array($mmResult)){
                     ?>
                    <tr>
                        <td align="left" valign="top" class="page-text"><input type="checkbox" name="mm_id[]" value="<?php echo $mmRow['mm_id'];?>" /><?php echo $mmRow['mm_name'];?></td>
                        <td colspan="2">
                            <table width="100%" cellpadding="1" cellspacing="1" border="0">
                                <?php
                                $smResult = com_db_query("select * from ".TABLE_SUB_MENU." where mm_id='".$mmRow['mm_id']."'");
                                while($smRow = com_db_fetch_array($smResult)){
                                 ?>
                                <tr>
                                    <td width="51%" class="page-text"><input type="checkbox" name="sm_id_<?php echo $mmRow['mm_id'];?>[]" value="<?php echo $smRow['sm_id'];?>"/><?php echo $smRow['sm_name'];?></td>
                                    <td width="11%" class="page-text"><input type="checkbox" name="smid_add_<?php echo $smRow['sm_id'];?>" <?php if($smRow['sm_add']!='Yes'){echo 'disabled="disabled"';}?> value="Yes"/>Add</td>
                                    <td width="10%" class="page-text"><input type="checkbox" name="smid_edit_<?php echo $smRow['sm_id'];?>" <?php if($smRow['sm_edit']!='Yes'){echo 'disabled="disabled"';}?> value="Yes"/>Edit</td>
                                    <td width="14%" class="page-text"><input type="checkbox" name="smid_del_<?php echo $smRow['sm_id'];?>" <?php if($smRow['sm_delete']!='Yes'){echo 'disabled="disabled"';}?> value="Yes"/>Delete</td>
                                    <td width="14%" class="page-text"><input type="checkbox" name="smid_status_<?php echo $smRow['sm_id'];?>" <?php if($smRow['sm_status']!='Yes'){echo 'disabled="disabled"';}?> value="Yes"/>Status</td>
                                </tr>
                                <tr><td colspan="7" style="height:10px;"></td></tr>
                                <?php } ?>	
                            </table>
                        </td>
                    </tr>
                    <tr><td colspan="3" style="height:5px;border-top:1px solid #999;"></td></tr>
                    <?php } ?>
                </table>
            </td>
        </tr>
		<tr><td align="left" valign="top">&nbsp;</td><td align="left" valign="top" colspan="2"><input type="submit" value="Add new staff" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="Cancel" onclick="window.location='staff.php?p=<?=$p;?>&selected_menu=staff'" /></td></tr>
		</table>
        </form>
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