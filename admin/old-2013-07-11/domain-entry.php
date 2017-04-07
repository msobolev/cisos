<?php
require('includes/include_top.php');
$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 20;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';


$sql_query = "select * from " . TABLE_BANNED_DOMAIN . " order by domain_id desc";
/***************** FOR PAGIN ***********************/
$starting_point = $items_per_page * ($p - 1);
/****************** END PAGIN ***********************/
$main_page = 'domain-entry.php';

$exe_query=com_db_query($sql_query);
$num_rows=com_db_num_rows($exe_query);
$total_data = $num_rows;

/************ FOR PAGIN **************/
$sql_query .= " LIMIT $starting_point,$items_per_page";
$exe_data = com_db_query($sql_query);

$numRows = com_db_num_rows($exe_data);
/************ END ********************/


$dID = (isset($_GET['dID']) ? $_GET['dID'] : $select_data[0]);

    switch ($action) {
		
	  case 'delete':
	   		
			com_db_query("delete from " . TABLE_BANNED_DOMAIN . " where domain_id = '" . $dID . "'");
		 	com_redirect("domain-entry.php?p=" . $p . "&selected_menu=domain&msg=" . msg_encode("Domain deleted successfully"));
		
		break;
		
	  case 'alldelete':
	   		$domain_id = $_POST['nid'];
			for($i=0; $i< sizeof($domain_id) ; $i++){
				com_db_query("delete from " . TABLE_BANNED_DOMAIN . " where domain_id = '" . $domain_id[$i] . "'");
			}
		 	com_redirect("domain-entry.php?p=" . $p . "&selected_menu=domain&msg=" . msg_encode("Domain deleted successfully"));
		
		break;	
		
	  case 'edit':
     		
	   		$query_edit=com_db_query("select * from " . TABLE_BANNED_DOMAIN . " where domain_id = '" . $dID . "'");
	  		$data_edit=com_db_fetch_array($query_edit);
			$domain_name=com_db_output($data_edit['domain_name']);
			
			
			
		break;	
		
		case 'editsave':
			
			$domain_name=com_db_input($_POST['domain_name']);
						
			$query = "update " . TABLE_BANNED_DOMAIN . " set domain_name = '" . $domain_name . "' where domain_id = '" . $dID . "'";
			com_db_query($query);
	  		com_redirect("domain-entry.php?p=". $p ."&dID=" . $dID . "&selected_menu=domain&msg=" . msg_encode("Domain update successfully"));
		 
		break;		
		
	  
		
	case 'addsave':
			
			$domain_name=com_db_input($_POST['domain_name']);
						
			$added=date('Y-m-d');
			
			$query = "insert into " . TABLE_BANNED_DOMAIN . " (domain_name, add_date, status) values ('$domain_name', '$added', '0')";
			com_db_query($query);
	  		com_redirect("domain-entry.php?p=" . $p . "&selected_menu=domain&msg=" . msg_encode("Domain added successfully"));
		 
		break;	
		
	case 'detailes':
			
			$query_edit=com_db_query("select * from " . TABLE_BANNED_DOMAIN . " where domain_id = '" . $dID . "'");
	  		$data_edit=com_db_fetch_array($query_edit);
			
			$domain_name=com_db_output($data_edit['domain_name']);
						
			$add_date =explode('-',$data_edit['add_date']);
			$post_date = date('d, M Y',mktime(0,0,0,date($add_date[1]),date($add_date[2]),date($add_date[0])));
			
		break;	
	case 'activate':
     		
	   		$status=$_GET['status'];
			if($status==0){
				$query = "update " . TABLE_BANNED_DOMAIN . " set status = '1' where domain_id = '" . $dID . "'";
			}else{
				$query = "update " . TABLE_BANNED_DOMAIN . " set status = '0' where domain_id = '" . $dID . "'";
			}	
			com_db_query($query);
	  		com_redirect("domain-entry.php?p=". $p ."&dID=" . $dID . "&selected_menu=domain&msg=" . msg_encode("Domain update successfully"));
			
		break;
				
    }
	


include("includes/header.php");
?>
<script type="text/javascript">
function confirm_del(nid,p){
	var agree=confirm("Domain will be deleted. \n Do you want to continue?");
	if (agree)
		window.location = "domain-entry.php?selected_menu=domain&dID=" + nid + "&p=" + p + "&action=delete";
	else
		window.location = "domain-entry.php?selected_menu=domain&dID=" + nid + "&p=" + p ;
}

function CheckAll(numRows){
	if(document.getElementById('all').checked){
		for(i=1; i<=numRows; i++){
			var domain_id='domain_id-'+ i;
			document.getElementById(domain_id).checked=true;
		}
	} else {
		for(i=1; i<=numRows; i++){
			var domain_id='domain_id-'+ i;
			document.getElementById(domain_id).checked=false;
		}
	}
}

function AllDelete(numRows){

	var flg=0;
	for(i=1; i<=numRows; i++){
			var domain_id='domain_id-'+ i;
			if(document.getElementById(domain_id).checked){
				flg=1;
			}	
		}
	if(flg==0){
		alert("Please checked atlist one checkbox for delete.");
		document.getElementById('domain_id-1').focus();
		return false;
	} else {
		var agree=confirm("Domain will be deleted. \n Do you want to continue?");
		if (agree)
			 document.topicform.submit();
		else
			window.location = "domain-entry.php?selected_menu=domain";
	}	

}

function confirm_artivate(nid,p,status){
	if(status=='1'){
		var msg="Domain will be active. \n Do you want to continue?";
	}else{
		var msg="Domain will be Inactive. \n Do you want to continue?";
	}
	var agree=confirm(msg);
	if (agree)
		window.location = "domain-entry.php?selected_menu=domain&dID=" + nid + "&p=" + p + "&status=" + status + "&action=activate";
	else
		window.location = "domain-entry.php?selected_menu=domain&dID=" + nid + "&p=" + p ;
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
                  <td width="30%" align="left" valign="middle" class="heading-text">Domain Manager</td>
                  <td width="34%" align="left" valign="middle" class="message"><?=$msg?></td>
                  <td width="8%" align="right" valign="middle"><a href="#"><img src="images/add-icon.jpg" border="0" width="25" height="28" alt="Add Domain" name="Add Domain" onclick="window.location='domain-entry.php?action=add&selected_menu=domain'"  /></a></td>
                  <td width="8%" align="left" valign="middle" class="nav-text">Add New </td>
                  <td width="4%" align="right" valign="middle"><a href="#"><img src="images/delete-icon.jpg" border="0" width="25" height="28"  alt="Delete Domain" name="Delete Domain" onclick="AllDelete('<?=$numRows?>');"  /></a></td>
                  <td width="8%" align="left" valign="middle" class="nav-text">Delete</td>
                </tr>
              </table></td>
          </tr>
       
          <tr>
            <td align="left" valign="top" class="right-bar-content-border">
			<form name="topicform" action="domain-entry.php?action=alldelete&selected_menu=domain" method="post">
			<table width="100%" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="23" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-domain_name-text">#</span></td>
				<td width="32" height="30" align="center" valign="middle" class="right-border">
				<input type="checkbox" name="all" id="all" onclick="CheckAll('<?=$numRows?>');" /></td>
				<td width="266" height="30" align="center" valign="middle" class="right-border"><div align="left" style="padding-left:10px;"><span class="right-box-title-text">Name</span></div> </td>
				<td width="151" height="30" align="center" valign="middle" class="right-border"><div align="left" style="padding-left:10px;"><span class="right-box-title-text">Date</span></div> </td>
				<td width="163" height="30" align="center" valign="middle" class="left-border"><div align="center"><span class="right-box-title-text">Action</span></div></td>
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
				<td height="30" align="center" valign="middle" class="right-border"><input type="checkbox" id="domain_id-<?=$i;?>" name="nid[]" value="<?=$data_sql['domain_id'];?>" /></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><a href="domain-entry.php?action=detailes&selected_menu=domain&dID=<?=$data_sql['domain_id'];?>"><?=com_db_output($data_sql['domain_name'])?></a></td>
				<td height="30" align="center" valign="middle" class="right-border"><?=$added_date;?></td>
				<td height="30" align="center" valign="middle" class="left-border">
					<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr> 
					  	<?php if($status==0){ ?>
					   	<td width="33%" align="center" valign="middle"><a href="#"><img src="images/icon/active-icon.gif" width="16" height="16" alt="" name="" border="0" onclick="confirm_artivate('<?=$data_sql['domain_id'];?>','<?=$p;?>','<?=$status;?>');" /></a><br />
					   	  Status</td>
					   	<?php } elseif($status==1){ ?>
					   	<td width="33%" align="center" valign="middle"><a href="#"><img src="images/icon/inactive-icon.gif" width="16" height="16" alt="" name="" border="0" onclick="confirm_artivate('<?=$data_sql['domain_id'];?>','<?=$p;?>','<?=$status;?>');" /></a><br />
					   	  Status</td>
						<?php } ?>
						<td width="33%" align="center" valign="middle"><a href="#"><img src="images/small-edit-icon.gif" width="16" height="16" alt="Edit" name="Edit" border="0" onclick="window.location='domain-entry.php?selected_menu=domain&p=<?=$p;?>&dID=<?=$data_sql['domain_id'];?>&action=edit'" /></a><br />
						  Edit</td>
						<td width="34%" align="center" valign="middle"><a href="#"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" name="Delete" border="0" onclick="confirm_del('<?=$data_sql['domain_id'];?>','<?=$p;?>')" /></a><br />
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
                  <td width="50%" align="left" valign="middle" class="heading-text">Domain Manager :: Edit Domain </td>
				  
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
			<form name="DateTest" method="post" action="domain-entry.php?action=editsave&selected_menu=domain&dID=<?=$dID;?>&p=<?=$p;?>" onsubmit="return chk_form();">
			<tr>
			  <td width="18%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Name:</td>
			  <td width="77%" align="left" valign="top">
				<input type="text" name="domain_name" id="domain_name" size="40" value="<?=$domain_name;?>" />
			  </td>	
			</tr>
			
			<tr><td align="left" valign="top">&nbsp;</td><td align="left" valign="top"><input type="submit" value="Update Domain" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='domain-entry.php?p=<?=$p;?>&dID=<?=$dID;?>&selected_menu=domain'" /></td></tr>
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
	var domain_name=document.getElementById('domain_name').value;
	if(domain_name==''){
	alert("Please enter user domain_name.");
	document.getElementById('domain_name').focus();
	return false;
	}

}
</script>
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">Domain Manager :: Add Domain </td>
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
		<form name="DateTest" method="post" action="domain-entry.php?action=addsave&p=<?=$p;?>" onsubmit="return chk_form();">
		<tr>
		  <td width="16%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Name:</td>
		  <td width="80%" align="left" valign="top">
			<input type="text" name="domain_name" id="domain_name" size="40" />
		  </td>	
		</tr>
		
		<tr><td align="left" valign="top">&nbsp;</td><td align="left" valign="top"><input type="submit" value="Add Domain" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='domain-entry.php?p=<?=$p;?>&dID=<?=$dID;?>&selected_menu=domain'" /></td></tr>
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
                  <td width="50%" align="left" valign="middle" class="heading-text">Domain Manager :: Domain Details </td>
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
			  <td align="left" valign="top" class="page-text"><strong><?=$domain_name;?></strong><br /><br /><?=$post_date?></td>
			</tr>
			<tr>
				<td align="left" valign="top" class="page-text">Domain Name: <?=$domain_name;?></td>
			</tr>
			
			<tr>
				<td align="left" valign="top"><input type="button" class="submitButton" value="Back" onclick="window.location='domain-entry.php?p=<?=$p;?>&dID=<?=$dID;?>&selected_menu=domain'" /></td>
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