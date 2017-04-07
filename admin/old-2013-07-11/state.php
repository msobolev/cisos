<?php
require('includes/include_top.php');

$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 25;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';


$sql_query = "select s.*,c.countries_name from " . TABLE_STATE . " as s, ".TABLE_COUNTRIES ." as c where s.country_id=c.countries_id order by country_id,state_name";
/***************** FOR PAGIN ***********************/
$starting_point = $items_per_page * ($p - 1);
/****************** END PAGIN ***********************/
$main_page = 'state.php';

$exe_query=com_db_query($sql_query);
$num_rows=com_db_num_rows($exe_query);
$total_data = $num_rows;

/************ FOR PAGIN **************/
$sql_query .= " LIMIT $starting_point,$items_per_page";
$exe_data = com_db_query($sql_query);

$numRows = com_db_num_rows($exe_data);
/************ END ********************/


$sID = (isset($_GET['sID']) ? $_GET['sID'] : $select_data[0]);

    switch ($action) {
		
	  case 'delete':
	   		
			com_db_query("delete from " . TABLE_STATE . " where state_id = '" . $sID . "'");
		 	com_redirect("state.php?p=" . $p . "&selected_menu=others&msg=" . msg_encode("State deleted successfully"));
		
		break;
		
	  case 'alldelete':
	   		$state_id = $_POST['nid'];
			for($i=0; $i< sizeof($state_id) ; $i++){
				com_db_query("delete from " . TABLE_STATE . " where state_id = '" . $state_id[$i] . "'");
			}
		 	com_redirect("state.php?p=" . $p . "&selected_menu=others&msg=" . msg_encode("State deleted successfully"));
		
		break;	
		
	  case 'edit':
     		
	   		$query_edit = com_db_query("select * from " . TABLE_STATE . " where state_id = '" . $sID . "'");
	  		$data_edit = com_db_fetch_array($query_edit);
			$country_id = com_db_output($data_edit['country_id']);
			$state_name = com_db_output($data_edit['state_name']);
			$short_name = com_db_output($data_edit['short_name']);
			
		break;	
		
		case 'editsave':
			
			$state_name = com_db_input($_POST['state_name']);
			$short_name = com_db_input($_POST['short_name']);
			$country_id = com_db_input($_POST['country_id']);
			
			$query = "update " . TABLE_STATE . " set state_name = '" . $state_name . "', short_name = '".$short_name."', country_id='" . $country_id . "' where state_id = '" . $sID . "'";
			com_db_query($query);
			
			com_redirect("state.php?p=". $p ."&sID=" . $sID . "&selected_menu=others&msg=" . msg_encode("State update successfully"));
		 
		break;		
		
	  
		
	case 'addsave':
			
			$state_name = com_db_input($_POST['state_name']);
			$short_name = com_db_input($_POST['short_name']);
			$country_id = com_db_input($_POST['country_id']);
			
			$query = "insert into " . TABLE_STATE . " (country_id,state_name,short_name) values ('$country_id','$state_name','$short_name')";
			com_db_query($query);
					
			com_redirect("state.php?p=" . $p . "&selected_menu=others&msg=" . msg_encode("State added successfully"));
		 
		break;	
		
	case 'detailes':
			
			$query_edit=com_db_query("select s.*,c.countries_name from " . TABLE_STATE . " as s, ". TABLE_COUNTRIES . " as c where s.country_id = c.countries_id and state_id = '" . $sID . "'");
	  		$data_edit=com_db_fetch_array($query_edit);
			
			$state_name = com_db_output($data_edit['state_name']);
			$short_name = com_db_output($data_edit['short_name']);
			$country_name = com_db_output($data_edit['countries_name']);
			
		break;	
					
    }
	


include("includes/header.php");
?>
<script type="text/javascript">
function confirm_del(nid,p){
	var agree=confirm("State will be deleted. \n Do you want to continue?");
	if (agree)
		window.location = "state.php?selected_menu=others&sID=" + nid + "&p=" + p + "&action=delete";
	else
		window.location = "state.php?selected_menu=others&sID=" + nid + "&p=" + p ;
}

function CheckAll(numRows){
	if(document.getElementById('all').checked){
		for(i=1; i<=numRows; i++){
			var state_id='state_id-'+ i;
			document.getElementById(state_id).checked=true;
		}
	} else {
		for(i=1; i<=numRows; i++){
			var state_id='state_id-'+ i;
			document.getElementById(state_id).checked=false;
		}
	}
}

function AllDelete(numRows){

	var flg=0;
	for(i=1; i<=numRows; i++){
			var state_id='state_id-'+ i;
			if(document.getElementById(state_id).checked){
				flg=1;
			}	
		}
	if(flg==0){
		alert("Please checked atlist one checkbox for delete.");
		document.getElementById('state_id-1').focus();
		return false;
	} else {
		var agree=confirm("State will be deleted. \n Do you want to continue?");
		if (agree)
			 document.topicform.submit();
		else
			window.location = "state.php?selected_menu=others";
	}	

}

function confirm_artivate(nid,p,status){
	if(status=='1'){
		var msg="State will be active. \n Do you want to continue?";
	}else{
		var msg="State will be Inactive. \n Do you want to continue?";
	}
	var agree=confirm(msg);
	if (agree)
		window.location = "state.php?selected_menu=others&sID=" + nid + "&p=" + p + "&status=" + status + "&action=activate";
	else
		window.location = "state.php?selected_menu=others&sID=" + nid + "&p=" + p ;
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
                  <td width="30%" align="left" valign="middle" class="heading-text">State Manager</td>
                  <td width="34%" align="left" valign="middle" class="message"><?=$msg?></td>
                  <td width="8%" align="right" valign="middle"><a href="#"><img src="images/add-icon.jpg" border="0" width="25" height="28" alt="Add State" countries="Add State" onclick="window.location='state.php?action=add&p=<?=$p?>&selected_menu=others'"  /></a></td>
                  <td width="8%" align="left" valign="middle" class="nav-text">Add New </td>
                  <td width="4%" align="right" valign="middle"><a href="#"><img src="images/delete-icon.jpg" border="0" width="25" height="28"  alt="Delete State" countries="Delete State" onclick="AllDelete('<?=$numRows?>');"  /></a></td>
                  <td width="8%" align="left" valign="middle" class="nav-text">Delete</td>
                </tr>
              </table></td>
          </tr>
       
          <tr>
            <td align="left" valign="top" class="right-bar-content-border">
			<form name="topicform" action="state.php?action=alldelete&selected_menu=others" method="post">
			<table width="100%" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="34" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-title-text">#</span></td>
				<td width="36" height="30" align="center" valign="middle" class="right-border">
				<input type="checkbox" name="all" id="all" onclick="CheckAll('<?=$numRows?>');" /></td>
				<td width="273" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">State Name</span></td>
				<td width="150" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Short Name</span></td>
				<td width="159" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Countries</span> </td>
				<td width="200" height="30" align="center" valign="middle" class="left-border"><div align="center"><span class="right-box-title-text">Action</span></div></td>
			  </tr>
			<?php
			
			if($total_data>0) {
				$i=1;
				while ($data_sql = com_db_fetch_array($exe_data)) {
				
				
			?>          
			  <tr>
				<td height="30" align="center" valign="middle" class="right-border-left"><?=$i;?></td>
				<td height="30" align="center" valign="middle" class="right-border"><input type="checkbox" id="state_id-<?=$i;?>" name="nid[]" value="<?=$data_sql['state_id'];?>" /></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><a href="state.php?action=detailes&selected_menu=others&sID=<?=$data_sql['state_id'];?>"><?=com_db_output($data_sql['state_name'])?></a></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><?=com_db_output($data_sql['short_name'])?></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><?=com_db_output($data_sql['countries_name'])?></td>
				<td height="30" align="center" valign="middle" class="left-border">
					<table width="85%" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr> 
						<td width="23%" align="center" valign="middle"><a href="#"><img src="images/small-edit-icon.gif" width="16" height="16" alt="Edit" countries="Edit" border="0" onclick="window.location='state.php?selected_menu=others&p=<?=$p;?>&sID=<?=$data_sql['state_id'];?>&action=edit'" /></a><br />
						  Edit</td>
						<td width="24%" align="center" valign="middle"><a href="#"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" countries="Delete" border="0" onclick="confirm_del('<?=$data_sql['state_id'];?>','<?=$p;?>')" /></a><br />
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
		<?php echo number_pages($main_page, $p, $total_data, 8, $items_per_page,'&selected_menu=others');?>		  
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
                  <td width="50%" align="left" valign="middle" class="heading-text">State Manager :: Edit </td>
				  
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
			<form name="frmState" method="post" action="state.php?action=editsave&selected_menu=others&sID=<?=$sID;?>&p=<?=$p;?>" enctype="multipart/form-data" onsubmit="return chk_form();">
            <tr>
			  <td width="16%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Counties:</td>
			  <td width="84%" align="left" valign="top">
				<select name="country_id" id="country_id">
					<?=selectComboBox("select countries_id, countries_name from " . TABLE_COUNTRIES ." order by countries_name ",$country_id)?>
				</select>
			  </td>	
			</tr>
			<tr>
			  <td width="15%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;State:</td>
			  <td width="85%" align="left" valign="top">
				<input type="text" name="state_name" id="state_name" size="35" value="<?=$state_name;?>" />			  </td>	
			</tr>
			<tr>
			  <td width="15%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;State:</td>
			  <td width="85%" align="left" valign="top">
				<input type="text" name="short_name" id="short_name" size="35" value="<?=$short_name;?>" />			  </td>	
			</tr>
			<tr><td align="left" valign="top">&nbsp;</td><td align="left" valign="top"><input type="submit" value="Update State" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='state.php?p=<?=$p;?>&sID=<?=$sID;?>&selected_menu=others'" /></td></tr>
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
	var countries=document.getElementById('state_name').value;
	if(countries==''){
	alert("Please enter new state.");
	document.getElementById('state_name').focus();
	return false;
	}

}
</script>
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">State Manager :: Add</td>
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
		<form name="frmState" method="post" action="state.php?action=addsave&p=<?=$p;?>" onsubmit="return chk_form();">
       <tr>
		  <td width="16%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Counties:</td>
		  <td width="84%" align="left" valign="top">
		  	<select name="country_id" id="country_id">
				<?=selectComboBox("select countries_id, countries_name from " . TABLE_COUNTRIES ." order by countries_name ","223")?>
			</select>
		  </td>	
		</tr>
	    <tr>
		  <td width="16%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;State:</td>
		  <td width="84%" align="left" valign="top">
			<input type="text" name="state_name" id="state_name" size="35" value="" />		  </td>	
		</tr>
		<tr>
		  <td width="16%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Short:</td>
		  <td width="84%" align="left" valign="top">
			<input type="text" name="short_name" id="short_name" size="35" value="" />		  </td>	
		</tr>
		<tr><td align="left" valign="top">&nbsp;</td><td align="left" valign="top"><input type="submit" value="Add State" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='state.php?p=<?=$p;?>&sID=<?=$sID;?>&selected_menu=others'" /></td></tr>
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
                  <td width="50%" align="left" valign="middle" class="heading-text">State Manager ::  Details </td>
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
			  <td align="left" valign="top" class="page-text"><strong>Countries: <?=$country_name;?></strong><br /><br /><strong> State : <?=$state_name?></strong><br /><br /><strong> Short : <?=$short_name?></strong><br /></td>
			</tr>
			<tr>
				<!--<td align="left" valign="top">&nbsp;</td> -->
				<td align="left" valign="top"><input type="button" class="submitButton" value="Back" onclick="window.location='state.php?p=<?=$p;?>&sID=<?=$sID;?>&selected_menu=others'" /></td>
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