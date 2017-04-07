<?php
require('includes/include_top.php');

$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 20;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';
/***************** FOR PAGIN ***********************/
$starting_point = $items_per_page * ($p - 1);
/****************** END PAGIN ***********************/


if($action == 'MovementSearchResult'){
	$search_company_name = $_POST['search_company_name'];
	$search_company_website = $_POST['search_company_website'];
	$person_first_name	= $_POST['search_person_fname'];
	$person_last_name= $_POST['search_person_lname'];
		
	$search_qry='';
	if($search_company_name!=''){
		$search_qry .= " c.company_name = '".$search_company_name."'";
	}
	if($search_company_website!=''){
		if($search_qry==''){
			$search_qry .= " c.company_website = '".$search_company_website."'";
		}else{
			$search_qry .= " and c.company_website = '".$search_company_website."'";
		}	
	}
	if($person_first_name!=''){
		if($search_qry==''){
			$search_qry .= " p.first_name = '".$person_first_name."'";
		}else{
			$search_qry .= " and p.first_name = '".$person_first_name."'";
		}	
	}
		
	if($person_last_name!=''){
		if($search_qry==''){
			$search_qry .= " p.last_name = '".$person_last_name."'";
		}else{
			$search_qry .= " and p.last_name = '".$person_last_name."'";
		}	
	}
			
	if($search_qry==''){
		$sql_query = "select m.*,c.company_name,p.first_name,p.last_name from " . TABLE_MOVEMENT_MASTER . " as m,".TABLE_PERSONAL_MASTER." as p,".TABLE_COMPANY_MASTER." as c where m.company_id=c.company_id and m.personal_id=p.personal_id order by add_date desc";
	}else{
		$sql_query = "select m.*,c.company_name,p.first_name,p.last_name from " . TABLE_MOVEMENT_MASTER . " as m,".TABLE_PERSONAL_MASTER." as p,".TABLE_COMPANY_MASTER." as c where m.company_id=c.company_id and m.personal_id=p.personal_id and ".$search_qry." order by add_date desc";
	}
	//echo $sql_query;
	$main_page = 'movement-merge.php';
	
	$exe_query=com_db_query($sql_query);
	$num_rows=com_db_num_rows($exe_query);
	$total_data = $num_rows;
	
	/************ FOR PAGIN **************/
	$sql_query .= " LIMIT $starting_point,$items_per_page";
	$exe_data = com_db_query($sql_query);
	$numRows = com_db_num_rows($exe_data);
	/************ END ********************/

}
if($action=='detailes'){
	$query_edit=com_db_query("select * from " . TABLE_MOVEMENT_MASTER . " where move_id = '" . $mID . "'");
	$data_edit=com_db_fetch_array($query_edit);
	
	$company_id = com_db_output($data_edit['company_id']);
	$personal_id = com_db_output($data_edit['personal_id']);
	$title = com_db_output($data_edit['title']);
	if($data_edit['announce_date'] !='0000-00-00'){
		$andt = explode('-',$data_edit['announce_date']);
		$announce_date = $andt[1].'/'.$andt[2].'/'.$andt[0];
	}else{
		$announce_date ='';
	}
	if($data_edit['effective_date'] !='0000-00-00'){
		$andt = explode('-',$data_edit['effective_date']);
		$effective_date = $andt[1].'/'.$andt[2].'/'.$andt[0];
	}else{
		$effective_date ='';
	}
	$headline = com_db_output($data_edit['headline']);
	$full_body = preg_replace('/<br( )?(\/)?>/i', "\r", $data_edit['full_body']);
	$short_url = com_db_output($data_edit['short_url']);
	$movement_type = com_db_output($data_edit['movement_type']);
	$what_happened = com_db_output($data_edit['what_happened']);
	$movement_type = com_db_output($data_edit['movement_type']);
	$source_id = com_db_output($data_edit['source_id']);
	$movement_url = com_db_output($data_edit['movement_url']);
	$more_link = com_db_output($data_edit['more_link']);
	$not_current = com_db_output($data_edit['not_current']);
}
if($action=='MovementMerge'){
	$selected_move_id_arr = $_POST['selected_move_id'];
	$unique_select = $_POST['unique_select'];
	for($m=0; $m < sizeof($selected_move_id_arr); $m++){
		if($selected_move_id_arr[$m]==$unique_select){
			//echo '<br>'.$unique_select.'Unique<br>';
		}else{
			$delInsQuery = "insert into ".TABLE_MOVEMENT_MASTER_DELETE. " select * from ".TABLE_MOVEMENT_MASTER." where move_id='".$selected_move_id_arr[$m]."'";
			com_db_query($delInsQuery);
			$delQuery ="delete from ". TABLE_MOVEMENT_MASTER." where move_id='".$selected_move_id_arr[$m]."'"; 
			com_db_query($delQuery);
		}
	}
	com_redirect("movement-merge.php?p=" . $p . "&selected_menu=movement&msg=" . msg_encode("Movement merge successfully"));
}

$mID = (isset($_GET['mID']) ? $_GET['mID'] : $select_data[0]);

   /* switch ($action) {
		
	  case 'delete':
	   		
			com_db_query("delete from " . TABLE_MOVEMENT_MASTER . " where move_id = '" . $mID . "'");
		 	com_redirect("movement-merge.php?p=" . $p . "&selected_menu=movement&msg=" . msg_encode("Movement deleted successfully"));
		
		break;
		
	  case 'alldelete':
	   		$move_id = $_POST['nid'];
			for($i=0; $i< sizeof($move_id) ; $i++){
				com_db_query("delete from " . TABLE_MOVEMENT_MASTER . " where move_id = '" . $move_id[$i] . "'");
			}
		 	com_redirect("movement-merge.php?p=" . $p . "&selected_menu=movement&msg=" . msg_encode("Movement deleted successfully"));
		
		break;
			
		
	  case 'edit':
     		
	   		$query_edit=com_db_query("select * from " . TABLE_MOVEMENT_MASTER . " where move_id = '" . $mID . "'");
	  		$data_edit=com_db_fetch_array($query_edit);
			
			$company_id = com_db_output($data_edit['company_id']);
			$personal_id = com_db_output($data_edit['personal_id']);
			$title = com_db_output($data_edit['title']);
			if($data_edit['announce_date'] !='0000-00-00'){
				$andt = explode('-',$data_edit['announce_date']);
				$announce_date = $andt[1].'/'.$andt[2].'/'.$andt[0];
			}else{
				$announce_date ='';
			}
			if($data_edit['effective_date'] !='0000-00-00'){
				$andt = explode('-',$data_edit['effective_date']);
				$effective_date = $andt[1].'/'.$andt[2].'/'.$andt[0];
			}else{
				$effective_date ='';
			}
			$headline = com_db_output($data_edit['headline']);
			$full_body = preg_replace('/<br( )?(\/)?>/i', "\r", $data_edit['full_body']);
			$short_url = com_db_output($data_edit['short_url']);
			$movement_type = com_db_output($data_edit['movement_type']);
			$what_happened = com_db_output($data_edit['what_happened']);
			$movement_type = com_db_output($data_edit['movement_type']);
			$source_id = com_db_output($data_edit['source_id']);
			$movement_url = com_db_output($data_edit['movement_url']);
			$more_link = com_db_output($data_edit['more_link']);
			$not_current = com_db_output($data_edit['not_current']);
			
		break;	
		
		case 'editsave':
			$company_id = com_db_input($_POST['company_id']);
			$personal_id = com_db_input($_POST['personal_id']);
			$title = com_db_input($_POST['title']);
			$ann_date = explode("/",$_POST['announce_date']);
			$announce_date = $ann_date[2]."-".$ann_date[0]."-".$ann_date[1];
			$eff_date = explode('/',$_POST['effective_date']);
			$effective_date = $eff_date[2].'-'.$eff_date[0].'-'.$eff_date[1];
			$headline = com_db_input($_POST['headline']);
			$rep   = array("\r\n", "\n","\r");
			$full_body = str_replace($rep,'<br />',$_POST['full_body']);
			$short_url = com_db_input($_POST['short_url']);		
			$what_happened = strip_tags($_POST['what_happened']);
			$movement_type = com_db_input($_POST['movement_type']);
			$source_id = com_db_input($_POST['source_id']);
			$movement_url = com_db_input($_POST['movement_url']);
			$more_link = com_db_input($_POST['more_link']);
			$not_current = com_db_input($_POST['not_current']);
			$phone =  com_db_input($_POST['phone']);
			$fax =  com_db_input($_POST['fax']);
			$login_id = $_SESSION['login_id'];
			$create_by = $_SESSION['login_access_type'];
			$query = "update " . TABLE_MOVEMENT_MASTER . " set company_id = '" . $company_id ."', personal_id = '".$personal_id."', title = '".$title."', announce_date = '".$announce_date."', effective_date = '".$effective_date."', headline = '".$headline."', full_body = '".$full_body."', short_url = '".$short_url."', what_happened='".$what_happened."', movement_type='".$movement_type."', source_id='".$source_id."', movement_url='".$movement_url."', more_link = '".$more_link."', not_current ='".$not_current."',create_by='".$create_by."',admin_id='".$login_id."' where move_id = '" . $mID . "'";
			com_db_query($query);
			
			com_db_query("update ".TABLE_COMPANY_MASTER." set phone='".$phone."' , fax ='".$fax."' where company_id='".$company_id."'");
			$updateQuery= "update ".TABLE_COMPANY_MASTER." set phone='".$phone."' , fax ='".$fax."' where company_id='".$company_id."'";
			com_db_query("insert into ".TABLE_COMPANY_UPDATE_INFO."(page_name,query_string,add_date) values('admin-movement-master','".com_db_input($updateQuery)."','".date("Y-m-d:H:i:s")."')");
	  		com_redirect("movement-merge.php?p=". $p ."&mID=" . $mID . "&selected_menu=movement&msg=" . msg_encode("Movement update successfully"));
		 
		break;		
		
	  
		
	case 'addsave':
			$company_id = com_db_input($_POST['company_id']);
			$personal_id = com_db_input($_POST['personal_id']);
			$title = com_db_input($_POST['title']);
			$ann_date = explode("/",$_POST['announce_date']);
			$announce_date = $ann_date[2]."-".$ann_date[0]."-".$ann_date[1];
			$eff_date = explode('/',$_POST['effective_date']);
			$effective_date = $eff_date[2].'-'.$eff_date[0].'-'.$eff_date[1];
			$headline = com_db_input($_POST['headline']);
			$rep   = array("\r\n", "\n","\r");
			$full_body = str_replace($rep,'<br />',$_POST['full_body']);
			$short_url = com_db_input($_POST['short_url']);
			$movement_url = com_db_input($_POST['movement_url']);
			$what_happened = strip_tags($_POST['what_happened']);
			$movement_type = com_db_input($_POST['movement_type']);
			$source_id = com_db_input($_POST['source_id']);
			$phone =  com_db_input($_POST['phone']);
			$fax =  com_db_input($_POST['fax']);
			$more_link = com_db_input($_POST['more_link']);
			$not_current = com_db_input($_POST['not_current']);
			$login_id = $_SESSION['login_id'];
			$create_by = $_SESSION['login_access_type'];
			$status = '0';
			$add_date = date('Y-m-d');
			
			$query = "insert into " . TABLE_MOVEMENT_MASTER . "
			(company_id, personal_id, title, announce_date,effective_date,headline,full_body,short_url, what_happened, movement_type, source_id, movement_url, more_link, not_current, add_date, create_by, admin_id, status) 
			values ('$company_id', '$personal_id', '$title', '$announce_date','$effective_date','$headline','$full_body','$short_url','$what_happened','$movement_type','$source_id','$movement_url','$more_link','$not_current', '$add_date', '$create_by','$login_id','$status')";
			com_db_query($query);
			
			com_db_query("update ".TABLE_COMPANY_MASTER." set phone='".$phone."' , fax ='".$fax."' where company_id='".$company_id."'");
			$updateQuery= "update ".TABLE_COMPANY_MASTER." set phone='".$phone."' , fax ='".$fax."' where company_id='".$company_id."'";
			com_db_query("insert into ".TABLE_COMPANY_UPDATE_INFO."(page_name,query_string,add_date) values('admin-movement-master','".com_db_input($updateQuery)."','".date("Y-m-d:H:i:s")."')");
							
	  		com_redirect("movement-merge.php?p=" . $p . "&selected_menu=movement&msg=" . msg_encode("New mevement added successfully"));
		 
		break;	
		
	case 'detailes':
			$query_edit=com_db_query("select * from " . TABLE_MOVEMENT_MASTER . " where move_id = '" . $mID . "'");
	  		$data_edit=com_db_fetch_array($query_edit);
			
			$company_id = com_db_output($data_edit['company_id']);
			$personal_id = com_db_output($data_edit['personal_id']);
			$title = com_db_output($data_edit['title']);
			if($data_edit['announce_date'] !='0000-00-00'){
				$andt = explode('-',$data_edit['announce_date']);
				$announce_date = $andt[1].'/'.$andt[2].'/'.$andt[0];
			}else{
				$announce_date ='';
			}
			if($data_edit['effective_date'] !='0000-00-00'){
				$andt = explode('-',$data_edit['effective_date']);
				$effective_date = $andt[1].'/'.$andt[2].'/'.$andt[0];
			}else{
				$effective_date ='';
			}
			$headline = com_db_output($data_edit['headline']);
			$full_body = preg_replace('/<br( )?(\/)?>/i', "\r", $data_edit['full_body']);
			$short_url = com_db_output($data_edit['short_url']);
			$movement_type = com_db_output($data_edit['movement_type']);
			$what_happened = com_db_output($data_edit['what_happened']);
			$movement_type = com_db_output($data_edit['movement_type']);
			$source_id = com_db_output($data_edit['source_id']);
			$movement_url = com_db_output($data_edit['movement_url']);
			$more_link = com_db_output($data_edit['more_link']);
			$not_current = com_db_output($data_edit['not_current']);
			
		break;	
	case 'activate':
     		
	   		$status=$_GET['status'];
			if($status==0){
				$query = "update " . TABLE_MOVEMENT_MASTER . " set status = '1' where move_id = '" . $mID . "'";
			}else{
				$query = "update " . TABLE_MOVEMENT_MASTER . " set status = '0' where move_id = '" . $mID . "'";
			}	
			com_db_query($query);
	  		com_redirect("movement-merge.php?p=". $p ."&mID=" . $mID . "&selected_menu=movement&msg=" . msg_encode("Movement update successfully"));
			
		break;
				
    }*/
	
include("includes/header.php");
?>

<script type="text/javascript">
function confirm_del(nid,p){
	var agree=confirm("Movement will be deleted. \n Do you want to continue?");
	if (agree)
		window.location = "movement-merge.php?selected_menu=movement&mID=" + nid + "&p=" + p + "&action=delete";
	else
		window.location = "movement-merge.php?selected_menu=movement&mID=" + nid + "&p=" + p ;
}

function CheckAll(numRows){
	if(document.getElementById('all').checked){
		for(i=1; i<=numRows; i++){
			var move_id='move_id-'+ i;
			document.getElementById(move_id).checked=true;
		}
	} else {
		for(i=1; i<=numRows; i++){
			var move_id='move_id-'+ i;
			document.getElementById(move_id).checked=false;
		}
	}
}

function AllMerge(){

	var mid = document.getElementById('unique_select').value;
	if(mid==''){
		alert("Please select atleast one option.");
		return false;
	} else {
		var agree=confirm("Merge records... \n Do you want to continue?");
		if (agree)
			 document.topicform.submit();
		else
			window.location = "movement-merge.php?selected_menu=movement";
	}	

}
function NotDeleteedMoveID(mid){
	document.getElementById('unique_select').value=mid;
}
function MovementSearch(){
	window.location ='movement-merge.php?action=MovementSearch&selected_menu=movement';
}

</script>

<script type="text/javascript" src="ckeditor/ckeditor.js"></script>

<script type="text/javascript" language="javascript" src="selectuser.js"></script>

 <tr>
    <td align="left" valign="top" bgcolor="#FFFFFF">
     <div id="light" class="white_content" style="display:<? if($action=='MovementSearch'){ echo 'block';} else { echo 'none'; } ?>;">
		<div id="spiffycalendar" class="text"></div>
		<link rel="stylesheet" type="text/css" href="includes/javascript/spiffyCal/spiffyCal_v2_1.css">
		<script language="JavaScript" type="text/javascript" src="includes/javascript/spiffyCal/spiffyCal_v2_1.js"></script>
		<script language="javascript" type="text/javascript"><!--
		  var dateAvailableFrom = new ctlSpiffyCalendarBox("dateAvailableFrom", "frmSearch", "from_date","btnDate1","",scBTNMODE_CUSTOMBLUE);
		  var dateAvailableTo = new ctlSpiffyCalendarBox("dateAvailableTo", "frmSearch", "to_date","btnDate2","",scBTNMODE_CUSTOMBLUE);	
		//--></script>
		<form name="frmSearch" id="frmSearch" method="post" action="movement-merge.php?selected_menu=movement&action=MovementSearchResult">
		<table width="90%" border="0" align="center" cellpadding="1" cellspacing="1">
		  <tr>
			<td align="left" colspan="2" valign="top"><img src="images/specer.gif" width="1" height="50" alt="" title="" /> </td>
		  </tr>
          <tr><td colspan="2">&nbsp;</td></tr>
          <tr><td colspan="2">&nbsp;</td></tr>
		  <tr>
			<td width="32%" align="left" valign="top" >Company Name:</td>
			<td width="68%" align="left" valign="top"><input type="text" name="search_company_name" id="search_company_name" /> </td>
		  </tr>
           <tr><td colspan="2">&nbsp;</td></tr>
          <tr>
			<td width="32%" align="left" valign="top" >Company Website:</td>
			<td width="68%" align="left" valign="top"><input type="text" name="search_company_website" id="search_company_website" /> </td>
		  </tr>
          <tr><td colspan="2">&nbsp;</td></tr>
		  <tr>
			<td align="left" valign="top" >Person First Name:</td>
			<td align="left" valign="top"><input type="text" name="search_person_fname" id="search_person_fname" /></td>
		  </tr>
          <tr><td colspan="2">&nbsp;</td></tr>
          <tr>
			<td align="left" valign="top" >Person Last Name:</td>
			<td align="left" valign="top"><input type="text" name="search_person_lname" id="search_person_lname" /></td>
		  </tr>
		   <tr>
			<td align="center" valign="top">&nbsp;</td>
			<td align="center" valign="top">&nbsp;</td>
		  </tr>
		  <tr>
			<td align="center" valign="top">&nbsp;</td>
		  	<td align="left" valign="top"><input type="submit" value="Search" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="Cancel" onclick="window.location='movement-merge.php?selected_menu=movement'" /></td>
		  </tr>
		  <tr>
			<td align="center" valign="top">&nbsp;</td>
			<td align="center" valign="top">&nbsp;</td>
		  </tr>
		</table>
		</form>
	</div>
	<div id="fade" class="black_overlay" style="display:<? if($action=='MovementSearch'){ echo 'block';} else { echo 'none'; } ?>;"></div>
	
	
	<table width="975" border="0" align="center" cellpadding="0" cellspacing="0">

      <tr>
		<?php
		include("includes/menu_left.php");
		?>
		<td width="10" align="left" valign="top">&nbsp;</td>
        <td width="769" align="left" valign="top">

<?php if(($action == '') || ($action == 'save') || ($action =='MovementSearch') || $action =='MovementSearchResult' || $action =='AdvSearch'){	?>			

		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
          <tr>
            <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="21%" align="left" valign="middle" class="heading-text">Movement Merge</td>
                  <td width="52%" align="left" valign="middle" class="message"><?=$msg?></td>
				  <td width="5%" align="right" valign="middle"><a href="#"><img src="images/search-icon.jpg" border="0" width="25" height="28"  alt="Search" title="Search" onclick="MovementSearch('MovementSearch');"  /></a></td>
				  <td width="8%" align="left" valign="middle" class="nav-text">Search</td>
                  <? if($btnDelete=='Yes'){ ?>
                  <td width="7%" align="right" valign="middle"><a href="#"><img src="images/merge-icone.png" border="0"  alt="Merge" title="Merge" onclick="AllMerge('<?=$numRows?>');"  /></a></td>
                  <td width="7%" align="left" valign="middle" class="nav-text">Merge</td>
                  <? } ?>
                </tr>
              </table></td>
          </tr>
       
          <tr>
            <td align="left" valign="top" class="right-bar-content-border">
			<form name="topicform" action="movement-merge.php?action=MovementMerge&selected_menu=movement" method="post">
            <input type="hidden" name="unique_select" id="unique_select" />
			<table width="100%" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="22" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-title-text">#</span></td>
				<td width="94" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Make Unique</span></td>
				<td width="140" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Person Name</span> </td>
				<td width="169" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Company Name</span> </td>
                <td width="152" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Title</span> </td>
				<td width="96" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Effective Date</span> </td>
                <td width="94" height="30" align="center" valign="middle" class="left-border"><div align="center"><span class="right-box-title-text">Add Date</span></div></td>
			  </tr>
			<?php
			
			if($total_data>0) {
				$i=$starting_point+1;
				while ($data_sql = com_db_fetch_array($exe_data)) {
				$add_date = $data_sql['add_date'];
				if($data_sql['effective_date'] !='0000-00-00'){
					//$andt = explode('-',$data_edit['effective_date']);
					//$effective_date = $andt[1].'/'.$andt[2].'/'.$andt[0];
					$effective_date = $data_sql['effective_date'];
				}else{
					$effective_date ='';
				}
			?>          
			  <tr>
				<td height="30" align="center" valign="middle" class="right-border-left"><?=$i;?></td>
				<td height="30" align="center" valign="middle" class="right-border"><input type="hidden" name="selected_move_id[]" value="<?=$data_sql['move_id'];?>" /><input type="radio" name="present_move" value="<?=$data_sql['move_id'];?>" onclick="NotDeleteedMoveID('<?=$data_sql['move_id'];?>')" /></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><a href="movement-merge.php?action=detailes&p=<?=$p?>&selected_menu=movement&mID=<?=$data_sql['move_id'];?>"><?=com_db_output($data_sql['first_name'].' '.$data_sql['last_name'])?></a></td>
                <td height="30" align="left" valign="middle" class="right-border-text"><?=com_db_output($data_sql['company_name'])?></td>
                <td height="30" align="left" valign="middle" class="right-border-text"><?=com_db_output($data_sql['title'])?></td>
                <td height="30" align="center" valign="middle" class="right-border"><?=$effective_date;?></td>
				<td height="30" align="center" valign="middle" class="right-border"><?=$add_date;?></td>
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
		<?php 
		if($action=='MovementSearchResult' || $action == 'AdvSearch'){
			$extra_feture = '&selected_menu=movement&action=AdvSearch';
		}else{
			$extra_feture = '&selected_menu=movement';
		}
		echo number_pages($main_page, $p, $total_data, 8, $items_per_page,$extra_feture);?>		  
          </tr>
        </table></td>
        <td width="314" align="center" valign="bottom">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  
<?php } elseif($action=='detailes'){
?>		
  	  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">Movement Manager :: Movement Details </td>
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box">
            <table width="100%" align="center" cellpadding="0" cellspacing="0">
             <tr>
              <td align="left">
                <table width="100%" cellpadding="4" cellspacing="4" border="0">
                  	<tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Title:</b></td>
                        <td width="75%" align="left" valign="top"><?=$title;?></td>
                    </tr>
                  	<tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Person Name:</b></td>
                        <td width="75%" align="left" valign="top">
                         <?=com_db_output(com_db_GetValue("select concat(first_name,' ',last_name) as full_name from ".TABLE_PERSONAL_MASTER." where status=0 and personal_id='".$personal_id."'"))?>
                        </td>	
                    </tr>
                    <tr>
                      <td align="left" colspan="2">
                      		<? 
							$personalQuery ="select * from ".TABLE_PERSONAL_MASTER." where personal_id='".$personal_id."' and status='0'";
							$personalResult = com_db_query($personalQuery);
							$personalRow = com_db_fetch_array($personalResult);
							?>
                            <div id="DivPersonalInformationMovementShow">
                            	<table width="100%" cellpadding="2" cellspacing="2" border="0">
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">Person Name:</td>
                                      <td width="75%" align="left" valign="top"><?=com_db_output($personalRow['first_name'].' '.$personalRow['last_name'])?></td>	
                                    </tr>
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">E-Mail:</td>
                                      <td width="75%" align="left" valign="top"><?=com_db_output($personalRow['email'])?></td>	
                                    </tr>
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">Phone:</td>
                                      <td width="75%" align="left" valign="top"><?=com_db_output($personalRow['phone'])?></td>	
                                    </tr>
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">Education (Undergrad):</td>
                                      <td width="75%" align="left" valign="top"><?=com_db_output($personalRow['edu_ugrad_degree'].' in '.$personalRow['edu_ugrad_specialization'].' from '.$personalRow['edu_ugrad_college'].' in '.$personalRow['edu_ugrad_year'])?></td> 	
                                    </tr>
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">Education (Grad):</td>
                                      <td width="75%" align="left" valign="top"><?=com_db_output($personalRow['edu_grad_degree'].' in '.$personalRow['edu_grad_specialization'].' from '.$personalRow['edu_grad_college'].' in '.$personalRow['edu_grad_year'])?></td>
                                    </tr>
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">About Person:</td>
                                      <td width="75%" align="left" valign="top"><?=com_db_output($personalRow['about_person'])?></td>	
                                    </tr>
                                </table>
                            </div>
                      </td>	
                    </tr>
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Company Name:</b></td>
                        <td width="75%" align="left" valign="top">
                        <?=com_db_output(com_db_GetValue("select company_name from ".TABLE_COMPANY_MASTER." where status=0 and company_id='".$company_id."'"))?>
                        </td>	
                    </tr>
                    <tr>
                      <td align="left" colspan="2">
                      		<?
							$companyQuery ="select c.*,s.state_name,cnt.countries_name from ".TABLE_COMPANY_MASTER." as c, ".TABLE_STATE." as s,".TABLE_COUNTRIES." as cnt where s.state_id=c.state and cnt.countries_id=c.country and c.company_id='".$company_id."' and status='0'";
							$companyResult = com_db_query($companyQuery);
							$companyRow = com_db_fetch_array($companyResult);
							?>
                            <div id="DivCompanyInformationMovementShow">
                            	<table width="100%" cellpadding="2" cellspacing="2" border="0">
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">Company Website:</td>
                                      <td width="75%" align="left" valign="top"><?=com_db_output($companyRow['company_website'])?></td>	
                                    </tr>
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">Address:</td>
                                      <td width="75%" align="left" valign="top"><?=com_db_output($companyRow['address']).'<br>'.com_db_output($companyRow['address2'])?></td>	
                                    </tr>
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">City:</td>
                                      <td width="75%" align="left" valign="top"><?=com_db_output($companyRow['city'])?></td>	
                                    </tr>
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">State:</td>
                                      <td width="75%" align="left" valign="top"><?=com_db_output($companyRow['state_name'])?></td>	
                                    </tr>
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">Country:</td>
                                      <td width="75%" align="left" valign="top"><?=com_db_output($companyRow['countries_name'])?></td>	
                                    </tr>
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">Zip Code:</td>
                                      <td width="75%" align="left" valign="top"><?=com_db_output($companyRow['zip_code'])?></td>	
                                    </tr>
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">Phone:</td>
                                      <td width="75%" align="left" valign="top"><?=com_db_output($companyRow['phone'])?></td>	
                                    </tr>
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">Fax:</td>
                                      <td width="75%" align="left" valign="top"><?=com_db_output($companyRow['fax'])?></td>	
                                    </tr>
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">About Company:</td>
                                      <td width="75%" align="left" valign="top"><?=com_db_output($companyRow['about_company']);?></td>	
                                    </tr>
                                    
                                </table>
                            </div>
                      </td>	
                    </tr>
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Headline:</b></td>
                        <td width="75%" align="left" valign="top"><?=$headline?></td>	
                    </tr>
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Announcement Date:</b></td>
                        <td width="75%" align="left" valign="top"><?=$announce_date?></td>	
                    </tr>
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Effective Date:</b></td>
                        <td width="75%" align="left" valign="top"><?=$effective_date?></td>	
                    </tr>
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Full Body:</b></td>
                        <td width="75%" align="left" valign="top"><?=$full_body?></td>	
                    </tr>
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Short URL:</b></td>
                        <td width="75%" align="left" valign="top"><?=$short_url?></td>	
                    </tr>
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>What Happened:</b></td>
                        <td width="75%" align="left" valign="top"><?=$what_happened?></td>	
                    </tr>
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Movement Type:</b></td>
                        <td width="75%" align="left" valign="top"><?=com_db_output(com_db_GetValue("select name from ".TABLE_MANAGEMENT_CHANGE." where id ='".$movement_type."'"))?>
                            </select>
                        </td>	
                    </tr>
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Source:</b></td>
                        <td width="75%" align="left" valign="top"><?=com_db_output(com_db_GetValue("select source from ".TABLE_SOURCE." where id='".$source_id."'"))?>
                            </select>
                        </td>	
                    </tr>
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Movement URL:</b></td>
                        <td width="75%" align="left" valign="top"><?=$movement_url?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top"><b>More Link:</b></td>
                      <td width="75%" align="left" valign="top"><?=$more_link;?></td>	
                    </tr>
					<tr>
                      <td width="25%" align="left" class="page-text" valign="top"><b>Not Current?:</b></td>
                      <td width="75%" align="left" valign="top"><?=$not_current;?></td>	
                    </tr>
                  </table>
                </td>	
            </tr>
             <tr>
            	<td align="center">
                	<table width="50%" border="0" cellpadding="4" cellspacing="4">
                    	<tr><td><input type="button" class="submitButton" value="Back" onclick="window.location='movement-merge.php?p=<?=$p;?>&selected_menu=movement'" /></td></tr>
                    </table>
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