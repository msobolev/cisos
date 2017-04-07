<?php
require('includes/include_top.php');

$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 20;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';


$sql_query = "select * from " . TABLE_ALERT_PRICE . " order by ap_id desc";
/***************** FOR PAGIN ***********************/
$starting_point = $items_per_page * ($p - 1);
/****************** END PAGIN ***********************/
$main_page = 'alert-price.php';

$exe_query=com_db_query($sql_query);
$num_rows=com_db_num_rows($exe_query);
$total_data = $num_rows;

/************ FOR PAGIN **************/
$sql_query .= " LIMIT $starting_point,$items_per_page";
$exe_data = com_db_query($sql_query);

$numRows = com_db_num_rows($exe_data);
/************ END ********************/


$apID = (isset($_GET['apID']) ? $_GET['apID'] : $select_data[0]);

    switch ($action) {
		
	  case 'delete':
	   		
			com_db_query("delete from " . TABLE_ALERT_PRICE . " where ap_id = '" . $apID . "'");
		 	com_redirect("alert-price.php?p=" . $p . "&selected_menu=subscription&msg=" . msg_encode("Alert Price deleted successfully"));
		
		break;
		
	  case 'alldelete':
	   		$ap_id = $_POST['nid'];
			for($i=0; $i< sizeof($ap_id) ; $i++){
				com_db_query("delete from " . TABLE_ALERT_PRICE . " where ap_id = '" . $ap_id[$i] . "'");
			}
		 	com_redirect("alert-price.php?p=" . $p . "&selected_menu=subscription&msg=" . msg_encode("Alert Price deleted successfully"));
		
		break;	
		
	  case 'edit':
     		
	   		$query_edit=com_db_query("select * from " . TABLE_ALERT_PRICE . " where ap_id = '" . $apID . "'");
	  		$data_edit=com_db_fetch_array($query_edit);
			
			$ap_name=com_db_output($data_edit['ap_name']);
			$ap_amount=com_db_output($data_edit['ap_amount']);
						
		break;	
		
		case 'editsave':
			
			$ap_name = com_db_input($_POST['ap_name']);
			$ap_amount = com_db_input($_POST['ap_amount']);
			$modify_date = date('Y-m-d');
			
			$query = "update " . TABLE_ALERT_PRICE . " set ap_name = '" . $ap_name . "',  ap_amount = '" . $ap_amount . "', modify_date = '".$modify_date."'  where ap_id = '" . $apID . "'";
			com_db_query($query);
	  		com_redirect("alert-price.php?p=". $p ."&apID=" . $apID . "&selected_menu=subscription&msg=" . msg_encode("Alert Price update successfully"));
		 
		break;		
		
	  
		
	case 'addsave':
			
			$ap_name = com_db_input($_POST['ap_name']);
			$ap_amount = com_db_input($_POST['ap_amount']);
			$add_date = date('Y-m-d');
			
			$query = "insert into " . TABLE_ALERT_PRICE . " (ap_name, ap_amount, add_date, modify_date, status) values ('$ap_name', '$ap_amount', '$add_date','$add_date','0')";
			com_db_query($query);
	  		com_redirect("alert-price.php?p=" . $p . "&selected_menu=subscription&msg=" . msg_encode("Alert price added successfully"));
		 
		break;	
		
	case 'detailes':
			
			$query_edit=com_db_query("select * from " . TABLE_ALERT_PRICE . " where ap_id = '" . $apID . "'");
	  		$data_edit=com_db_fetch_array($query_edit);
			
			$ap_name = com_db_output($data_edit['ap_name']);
			$ap_amount = com_db_output($data_edit['ap_amount']);
						
		break;	
	case 'activate':
     		
	   		$status=$_GET['status'];
			if($status==0){
				$query = "update " . TABLE_ALERT_PRICE . " set status = '1' where ap_id = '" . $apID . "'";
			}else{
				$query = "update " . TABLE_ALERT_PRICE . " set status = '0' where ap_id = '" . $apID . "'";
			}	
			com_db_query($query);
	  		com_redirect("alert-price.php?p=". $p ."&apID=" . $apID . "&selected_menu=subscription&msg=" . msg_encode("Alert Price update successfully"));
			
		break;
				
    }
	


include("includes/header.php");
?>
<script type="text/javascript">
function confirm_del(nid,p){
	var agree=confirm("Alert Price will be deleted. \n Do you want to continue?");
	if (agree)
		window.location = "alert-price.php?selected_menu=subscription&apID=" + nid + "&p=" + p + "&action=delete";
	else
		window.location = "alert-price.php?selected_menu=subscription&apID=" + nid + "&p=" + p ;
}

function CheckAll(numRows){
	if(document.getElementById('all').checked){
		for(i=1; i<=numRows; i++){
			var ap_id='ap_id-'+ i;
			document.getElementById(ap_id).checked=true;
		}
	} else {
		for(i=1; i<=numRows; i++){
			var ap_id='ap_id-'+ i;
			document.getElementById(ap_id).checked=false;
		}
	}
}

function AllDelete(numRows){

	var flg=0;
	for(i=1; i<=numRows; i++){
			var ap_id='ap_id-'+ i;
			if(document.getElementById(ap_id).checked){
				flg=1;
			}	
		}
	if(flg==0){
		alert("Please checked atlist one checkbox for delete.");
		document.getElementById('ap_id-1').focus();
		return false;
	} else {
		var agree=confirm("Alert Price will be deleted. \n Do you want to continue?");
		if (agree)
			 document.topicform.submit();
		else
			window.location = "alert-price.php?selected_menu=subscription";
	}	

}

function confirm_artivate(nid,p,status){
	if(status=='1'){
		var msg="Alert Price will be active. \n Do you want to continue?";
	}else{
		var msg="Alert Price will be Inactive. \n Do you want to continue?";
	}
	var agree=confirm(msg);
	if (agree)
		window.location = "alert-price.php?selected_menu=subscription&apID=" + nid + "&p=" + p + "&status=" + status + "&action=activate";
	else
		window.location = "alert-price.php?selected_menu=subscription&apID=" + nid + "&p=" + p ;
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
                  <td width="30%" align="left" valign="middle" class="heading-text">Alert Price Manager</td>
                  <td width="34%" align="left" valign="middle" class="message"><?=$msg?></td>
                  <td width="8%" align="right" valign="middle"><a href="#"><img src="images/add-icon.jpg" border="0" width="25" height="28" alt="Add Alert Price" title="Add Alert Price" onclick="window.location='alert-price.php?action=add&selected_menu=subscription'"  /></a></td>
                  <td width="8%" align="left" valign="middle" class="nav-text">Add New </td>
                  <td width="4%" align="right" valign="middle"><a href="#"><img src="images/delete-icon.jpg" border="0" width="25" height="28"  alt="Delete Alert Price" title="Delete Alert Price" onclick="AllDelete('<?=$numRows?>');"  /></a></td>
                  <td width="8%" align="left" valign="middle" class="nav-text">Delete</td>
                </tr>
              </table></td>
          </tr>
       
          <tr>
            <td align="left" valign="top" class="right-bar-content-border">
			<form name="topicform" action="alert-price.php?action=alldelete&selected_menu=subscription" method="post">
			<table width="100%" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="23" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-title-text">#</span></td>
				<td width="32" height="30" align="center" valign="middle" class="right-border">
				<input type="checkbox" name="all" id="all" onclick="CheckAll('<?=$numRows?>');" /></td>
				<td width="150" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Name</span> </td>
				<td width="150" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Price</span> </td>
				<td width="116" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Date</span> </td>
                <td width="150" height="30" align="center" valign="middle" class="left-border"><div align="center"><span class="right-box-title-text">Action</span></div></td>
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
				<td height="30" align="center" valign="middle" class="right-border"><input type="checkbox" id="ap_id-<?=$i;?>" name="nid[]" value="<?=$data_sql['ap_id'];?>" /></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><a href="alert-price.php?action=detailes&selected_menu=subscription&apID=<?=$data_sql['ap_id'];?>"><?=com_db_output($data_sql['ap_name'])?></a></td>
				<td height="30" align="left" valign="middle" class="right-border-text">$<?=com_db_output($data_sql['ap_amount'])?></td>
                <td height="30" align="center" valign="middle" class="right-border"><?=$added_date;?></td>
				<td height="30" align="center" valign="middle" class="left-border">
					<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr> 
					  	<?php if($status==0){ ?>
					   	<td width="29%" align="center" valign="middle"><a href="#"><img src="images/icon/active-icon.gif" width="16" height="16" alt="" title="" border="0" onclick="confirm_artivate('<?=$data_sql['ap_id'];?>','<?=$p;?>','<?=$status;?>');" /></a><br />
					   	  Status</td>
					   	<?php } elseif($status==1){ ?>
					   	<td width="24%" align="center" valign="middle"><a href="#"><img src="images/icon/inactive-icon.gif" width="16" height="16" alt="" title="" border="0" onclick="confirm_artivate('<?=$data_sql['ap_id'];?>','<?=$p;?>','<?=$status;?>');" /></a><br />
					   	  Status</td>
						<?php } ?>
						<td width="23%" align="center" valign="middle"><a href="#"><img src="images/small-edit-icon.gif" width="16" height="16" alt="Edit" title="Edit" border="0" onclick="window.location='alert-price.php?selected_menu=subscription&p=<?=$p;?>&apID=<?=$data_sql['ap_id'];?>&action=edit'" /></a><br />
						  Edit</td>
						<td width="24%" align="center" valign="middle"><a href="#"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" title="Delete" border="0" onclick="confirm_del('<?=$data_sql['ap_id'];?>','<?=$p;?>')" /></a><br />
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
	var fname=document.getElementById('ap_name').value;
	if(fname==''){
		alert("Please enter first name.");
		document.getElementById('ap_name').focus();
		return false;
	}
	var lname=document.getElementById('ap_amount').value;
	if(lname==''){
		alert("Please enter last name.");
		document.getElementById('ap_amount').focus();
		return false;
	}

}
</script>		

		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">Alert Price Manager :: Edit Alert Price </td>
				  
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
			<form name="DateTest" method="post" action="alert-price.php?action=editsave&selected_menu=subscription&apID=<?=$apID;?>&p=<?=$p;?>" onsubmit="return chk_form();">
			<tr>
			  <td width="18%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Name:</td>
			  <td width="77%" align="left" valign="top">
				<input type="text" name="ap_name" id="ap_name" size="30" value="<?=$ap_name;?>" />			  </td>	
			</tr>
			<tr>
			  <td width="18%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Price:</td>
			  <td width="77%" align="left" valign="top">
				<input type="text" name="ap_amount" id="ap_amount" size="30" value="<?=$ap_amount;?>" />			  </td>	
			</tr>
			<tr><td align="left" valign="top">&nbsp;</td><td align="left" valign="top"><input type="submit" value="Update Alert Price" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='alert-price.php?p=<?=$p;?>&apID=<?=$apID;?>&selected_menu=subscription'" /></td></tr>
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
	var fname=document.getElementById('ap_name').value;
	if(fname==''){
		alert("Please enter first name.");
		document.getElementById('ap_name').focus();
		return false;
	}
	var lname=document.getElementById('ap_amount').value;
	if(lname==''){
		alert("Please enter last name.");
		document.getElementById('ap_amount').focus();
		return false;
	}

}
</script>
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">Alert Price Manager :: Add Alert Price </td>
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
			<form name="DateTest" method="post" action="alert-price.php?action=addsave&selected_menu=subscription&apID=<?=$apID;?>&p=<?=$p;?>" onsubmit="return chk_form();">
			<tr>
			  <td width="18%" align="left" class="page-text" valign="top">&nbsp;&nbsp; Name:</td>
			  <td width="77%" align="left" valign="top">
				<input type="text" name="ap_name" id="ap_name" size="30" value="" />			  </td>	
			</tr>
			<tr>
			  <td width="18%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Price:</td>
			  <td width="77%" align="left" valign="top">
				<input type="text" name="ap_amount" id="ap_amount" size="30" value="" />			  </td>	
			</tr>
			<tr><td align="left" valign="top">&nbsp;</td><td align="left" valign="top"><input type="submit" value="Add Alert Price" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='alert-price.php?p=<?=$p;?>&apID=<?=$apID;?>&selected_menu=subscription'" /></td></tr>
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
                  <td width="50%" align="left" valign="middle" class="heading-text">Alert Price Manager :: Alert Price Details </td>
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="left" valign="top" class="right-border">
		 <!--start iner table  -->
         	 
          <table width="95%" align="left" cellpadding="5" cellspacing="5" border="0">
			<tr>
			  <td colspan="2" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;<strong><?=$post_date;?></strong></td>
			</tr>
			<tr>
			  <td width="14%" align="left" class="page-text" valign="top">&nbsp;&nbsp; Name:</td>
			  <td width="86%" align="left" valign="top"><?=$ap_name;?> </td>	
			</tr>
			<tr>
			  <td width="14%" align="left" class="page-text" valign="top">&nbsp;&nbsp;Price:</td>
			  <td width="86%" align="left" valign="top"><?=$ap_amount;?> </td>	
			</tr>
			<tr>
				<td align="left" valign="top">&nbsp;</td> 
				<td align="left" valign="top"><input type="button" class="submitButton" value="Back" onclick="window.location='alert-price.php?p=<?=$p;?>&apID=<?=$apID;?>&selected_menu=subscription'" /></td>
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