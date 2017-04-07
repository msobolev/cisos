<?php
require('includes/include_top.php');

$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 20;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';

if($action == 'MovementSearchResult'){
	$title			= $_POST['search_title'];
	
        //$company_id		= $_POST['search_company_id'];
        $company_id = "";
        if($_POST['search_company_id'] != '')
        {
            //echo "select group_concat(company_id) as company_id from " . TABLE_COMPANY_MASTER . " where company_name LIKE '%" . $_POST['search_company_id'] . "%'";
            $company_id_query = "select group_concat(company_id) as company_id from " . TABLE_COMPANY_MASTER . " where company_name LIKE '%" . $_POST['search_company_id'] . "%'";
            $company_id_res = com_db_query($company_id_query);
            $company_id_data = com_db_fetch_array($company_id_res);
            $company_id = $company_id_data['company_id'];
            
            //echo "<br>company_id: ".$company_id;
        }    
        
	//$personal_id	= $_POST['search_personal_id'];
        $personal_id	= "";
        if($_POST['search_personal_first'] != '' || $_POST['search_personal_middle'] != '' || $_POST['search_personal_last'] != '')
        {
            $name_where_clause = "";
            if($_POST['search_personal_first'] != '')
            {
                $name_where_clause .= " first_name LIKE '" . $_POST['search_personal_first']."'";
            }  
            
            if($_POST['search_personal_middle'] != '')
            {
                if($name_where_clause != '')
                    $name_where_clause .= " AND middle_name LIKE '" . $_POST['search_personal_middle']."'";    
                else    
                    $name_where_clause .= " middle_name LIKE '" . $_POST['search_personal_middle']."'";
            }  
            if($_POST['search_personal_last'] != '')
            {
                if($name_where_clause != '')
                    $name_where_clause .= " AND last_name LIKE '" . $_POST['search_personal_last']."'";    
                else    
                    $name_where_clause .= " last_name LIKE '" . $_POST['search_personal_last']."'";
            } 
            
            if($name_where_clause != '')
                $name_where_clause = " where 1=1 and ".$name_where_clause ;
            
            //echo "select group_concat(personal_id) as personal_id from " . TABLE_PERSONAL_MASTER . " where first_name LIKE '" . $_POST['search_personal_first'] . "' Or middle_name LIKE '".$_POST['search_personal_middle']."' or last_name LIKE '".$_POST['search_personal_last']."'";
            //$personal_id = com_db_query("select group_concat(personal_id) as personal_id from " . TABLE_PERSONAL_MASTER . " where first_name LIKE '%" . $_POST['search_personal_id'] . "%' Or middle_name LIKE '%".$_POST['search_personal_id']."%' or last_name LIKE '%".$_POST['search_personal_id']."%'");
            //$personal_id_query = "select group_concat(personal_id) as personal_id from " . TABLE_PERSONAL_MASTER . " where first_name LIKE '" . $_POST['search_personal_first'] . "' Or middle_name LIKE '".$_POST['search_personal_middle']."' or last_name LIKE '".$_POST['search_personal_last']."'";
            $personal_id_query = "select group_concat(personal_id) as personal_id from " . TABLE_PERSONAL_MASTER . $name_where_clause;
            //echo "<br>personal_id_query: ".$personal_id_query;
            $personal_id_res = com_db_query($personal_id_query);
            $personal_id_data = com_db_fetch_array($personal_id_res);
            $personal_id = $personal_id_data['personal_id'];
            
            //echo "<br>personal_id: ".$personal_id;
            
        } 
        
        
	$from_date			= $_POST['from_date'];
	$to_date 			= $_POST['to_date'];
	
	$search_qry='';
	if($title!=''){
		$search_qry .= " m.title = '".$title."'";
	}
	if($company_id!=''){
		if($search_qry==''){
			//$search_qry .= " m.company_id = '".$company_id."'";
                        $search_qry .= " m.company_id in (".$company_id.")";
		}else{
			//$search_qry .= " and m.company_id = '".$company_id."'";
                        $search_qry .= " and m.company_id in (".$company_id.")";
		}	
	}
	if($personal_id!=''){
		if($search_qry==''){
			//$search_qry .= " m.personal_id = '".$personal_id."'";
                        $search_qry .= " m.personal_id in (".$personal_id.")";
		}else{
			//$search_qry .= " and m.personal_id = '".$personal_id."'";
                        $search_qry .= " and m.personal_id in (".$personal_id.")";
		}	
	}
	if($from_date!='' && strlen($from_date)==10 && $to_date !='' && strlen($to_date)==10){
		$fdt = explode('/',$from_date);
		$fdate = $fdt[2].'-'.$fdt[0].'-'.$fdt[1];
		$tdt = explode('/',$to_date);
		$tdate = $tdt[2].'-'.$tdt[0].'-'.$tdt[1];
		if($search_qry==''){
			$search_qry .= " m.announce_date >= '".$fdate."' and m.announce_date <='".$tdate."'";
		}else{
			$search_qry .= " and m.announce_date >= '".$fdate."' and m.announce_date <='".$tdate."'";
		}
	}
		
	
	if($search_qry==''){
		$sql_query = "select m.*,c.company_name,p.first_name,p.last_name from " . TABLE_MOVEMENT_MASTER . " as m,".TABLE_PERSONAL_MASTER." as p,".TABLE_COMPANY_MASTER." as c where m.company_id=c.company_id and m.personal_id=p.personal_id order by add_date desc";
	}else{
		$sql_query = "select m.*,c.company_name,p.first_name,p.last_name from " . TABLE_MOVEMENT_MASTER . " as m,".TABLE_PERSONAL_MASTER." as p,".TABLE_COMPANY_MASTER." as c where m.company_id=c.company_id and m.personal_id=p.personal_id and ".$search_qry." order by add_date desc";
	}
	$_SESSION['sess_admin_search_query'] = $sql_query;
}elseif($action=='AdvSearch'){
	$sql_query = $_SESSION['sess_admin_search_query'];
}else{
	$sql_query = "select m.*,c.company_name,p.first_name,p.last_name from " . TABLE_MOVEMENT_MASTER . " as m,".TABLE_PERSONAL_MASTER." as p,".TABLE_COMPANY_MASTER." as c where m.company_id=c.company_id and m.personal_id=p.personal_id order by add_date desc";
}
//echo "<br>sql_query: ".$sql_query; 
//die();
/***************** FOR PAGIN ***********************/
$starting_point = $items_per_page * ($p - 1);
/****************** END PAGIN ***********************/
$main_page = 'movement-master.php';

$exe_query=com_db_query($sql_query);
$num_rows=com_db_num_rows($exe_query);
$total_data = $num_rows;

/************ FOR PAGIN **************/
$sql_query .= " LIMIT $starting_point,$items_per_page";
$exe_data = com_db_query($sql_query);

$numRows = com_db_num_rows($exe_data);
/************ END ********************/


$mID = (isset($_GET['mID']) ? $_GET['mID'] : $select_data[0]);

    switch ($action) {
		
	  case 'delete':
	   		
			com_db_query("delete from " . TABLE_MOVEMENT_MASTER . " where move_id = '" . $mID . "'");
		 	com_redirect("movement-master.php?p=" . $p . "&selected_menu=movement&msg=" . msg_encode("Movement deleted successfully"));
		
		break;
		
	  case 'alldelete':
	   		$move_id = $_POST['nid'];
			for($i=0; $i< sizeof($move_id) ; $i++){
				com_db_query("delete from " . TABLE_MOVEMENT_MASTER . " where move_id = '" . $move_id[$i] . "'");
			}
		 	com_redirect("movement-master.php?p=" . $p . "&selected_menu=movement&msg=" . msg_encode("Movement deleted successfully"));
		
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
	  		com_redirect("movement-master.php?p=". $p ."&mID=" . $mID . "&selected_menu=movement&msg=" . msg_encode("Movement update successfully"));
		 
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
							
	  		com_redirect("movement-master.php?p=" . $p . "&selected_menu=movement&msg=" . msg_encode("New mevement added successfully"));
		 
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
	  		com_redirect("movement-master.php?p=". $p ."&mID=" . $mID . "&selected_menu=movement&msg=" . msg_encode("Movement update successfully"));
			
		break;
				
    }
	
include("includes/header.php");

?>

<script type="text/javascript">
function confirm_del(nid,p){
	var agree=confirm("Movement will be deleted. \n Do you want to continue?");
	if (agree)
		window.location = "movement-master.php?selected_menu=movement&mID=" + nid + "&p=" + p + "&action=delete";
	else
		window.location = "movement-master.php?selected_menu=movement&mID=" + nid + "&p=" + p ;
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

function AllDelete(numRows){

	var flg=0;
	for(i=1; i<=numRows; i++){
			var move_id='move_id-'+ i;
			if(document.getElementById(move_id).checked){
				flg=1;
			}	
		}
	if(flg==0){
		alert("Please checked atlist one checkbox for delete.");
		document.getElementById('move_id-1').focus();
		return false;
	} else {
		var agree=confirm("Movement will be deleted. \n Do you want to continue?");
		if (agree)
			 document.topicform.submit();
		else
			window.location = "movement-master.php?selected_menu=movement";
	}	

}

function confirm_artivate(nid,p,status){
	if(status=='1'){
		var msg="Movement will be active. \n Do you want to continue?";
	}else{
		var msg="Movement will be Inactive. \n Do you want to continue?";
	}
	var agree=confirm(msg);
	if (agree)
		window.location = "movement-master.php?selected_menu=movement&mID=" + nid + "&p=" + p + "&status=" + status + "&action=activate";
	else
		window.location = "movement-master.php?selected_menu=movement&mID=" + nid + "&p=" + p ;
}

function MovementSearch(){
	window.location ='movement-master.php?action=MovementSearch&selected_menu=movement';
}

</script>

<script type="text/javascript" src="ckeditor/ckeditor.js"></script>

<script type="text/javascript" language="javascript" src="selectuser.js"></script>

 <tr>
    <td align="left" valign="top" bgcolor="#FFFFFF">
     <div id="light" class="white_content" style="display:<?PHP if($action=='MovementSearch'){ echo 'block';} else { echo 'none'; } ?>;">
		<div id="spiffycalendar" class="text"></div>
		<link rel="stylesheet" type="text/css" href="includes/javascript/spiffyCal/spiffyCal_v2_1.css">
		<script language="JavaScript" type="text/javascript" src="includes/javascript/spiffyCal/spiffyCal_v2_1.js"></script>
		<script language="javascript" type="text/javascript"><!--
		  var dateAvailableFrom = new ctlSpiffyCalendarBox("dateAvailableFrom", "frmSearch", "from_date","btnDate1","",scBTNMODE_CUSTOMBLUE);
		  var dateAvailableTo = new ctlSpiffyCalendarBox("dateAvailableTo", "frmSearch", "to_date","btnDate2","",scBTNMODE_CUSTOMBLUE);	
		//--></script>
		<form name="frmSearch" id="frmSearch" method="post" action="movement-master.php?selected_menu=movement&action=MovementSearchResult">
		<table width="90%" border="0" align="center" cellpadding="1" cellspacing="1">
		  <tr>
			<td align="left" colspan="2" valign="top"><img src="images/specer.gif" width="1" height="50" alt="" title="" /> </td>
		  </tr>
          <tr><td colspan="2">&nbsp;</td></tr>
          <tr>
			<td width="32%" align="left" valign="top" >Title:</td>
			<td width="68%" align="left" valign="top"><input type="text" name="search_title" id="search_title" size="30" /></td>
		  </tr>
          <tr><td colspan="2">&nbsp;</td></tr>
		  <tr>
			<td align="left" valign="top" >Company Name:</td>
			<td align="left" valign="top">
                            <input type="text" name="search_company_id" id="search_company_id" value="">
                        <!--    
                            <select name="search_company_id" id="search_company_id" style="width:208px;">
                            <option value="">--Select Company Name--</option>
                            <?PHP //=selectComboBox("select company_id,company_name from ".TABLE_COMPANY_MASTER." where status=0 order by company_name",'')?>
                            </select>
                        -->
                        
                        </td>
		  </tr>
          <tr><td colspan="2">&nbsp;</td></tr>
		  <tr>
			<td align="left" valign="top" >Person First Name:</td>
			<td align="left" valign="top">
                            <input type="text" name="search_personal_first" id="search_personal_first" value="">
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top">
                            Person Middle Name:
                        </td>
                        <td align="left" valign="top">
                            <input type="text" name="search_personal_middle" id="search_personal_middle" value="">
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top">
                            Person Last Name:
                        </td>
                        <td align="left" valign="top">
                            <input type="text" name="search_personal_last" id="search_personal_last" value="">
                        <!--    
                            <select name="search_personal_id" id="search_personal_id" style="width:208px;">
                            <option value="">--Select Person Name--</option>
                            <?PHP //=selectComboBox("select personal_id,concat(first_name,' ',last_name) as full_name from ".TABLE_PERSONAL_MASTER." where status=0 order by first_name, last_name",'')?>
                            </select>
                        -->
                        </td>
		  </tr>
          <tr><td colspan="2">&nbsp;</td></tr>
		  <tr>
			<td align="left" valign="top">Announcement Date:</td>
			<td align="left" valign="top">
				From:<script language="javascript">dateAvailableFrom.writeControl(); dateAvailableFrom.dateFormat="MM/dd/yyyy";</script>
			</td>
		  </tr>
          <tr><td colspan="2">&nbsp;</td></tr>
		  <tr>
			<td align="center" valign="top">&nbsp;</td>
			<td align="left" valign="top">
				To:&nbsp;&nbsp;&nbsp;<script language="javascript">dateAvailableTo.writeControl(); dateAvailableTo.dateFormat="MM/dd/yyyy";</script>
			</td>
		  </tr>
		   <tr>
			<td align="center" valign="top">&nbsp;</td>
			<td align="center" valign="top">&nbsp;</td>
		  </tr>
		  <tr>
			<td align="center" valign="top">&nbsp;</td>
		  	<td align="left" valign="top"><input type="submit" value="Search" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="Cancel" onclick="window.location='movement-master.php?selected_menu=movement'" /></td>
		  </tr>
		  <tr>
			<td align="center" valign="top">&nbsp;</td>
			<td align="center" valign="top">&nbsp;</td>
		  </tr>
		</table>
		</form>
	</div>
	<div id="fade" class="black_overlay" style="display:<?PHP if($action=='MovementSearch'){ echo 'block';} else { echo 'none'; } ?>;"></div>
	
	
	<table width="975" border="0" align="center" cellpadding="0" cellspacing="0">

      <tr>
		<?php
		include("includes/menu_left.php");
		?>
		<td width="10" align="left" valign="top">&nbsp;</td>
        <td width="769" align="left" valign="top">

<?php 

if(($action == '') || ($action == 'save') || ($action =='MovementSearch') || $action =='MovementSearchResult' || $action =='AdvSearch'){	?>			

		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
          <tr>
            <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="19%" align="left" valign="middle" class="heading-text">Movement Manager</td>
                  <td width="51%" align="left" valign="middle" class="message"><?=$msg?></td>
				  <td width="3%" align="right" valign="middle"><a href="#"><img src="images/search-icon.jpg" border="0" width="25" height="28"  alt="Search" title="Search" onclick="MovementSearch('MovementSearch');"  /></a></td>
				  <td width="6%" align="left" valign="middle" class="nav-text">Search</td>
                  <?PHP if($btnAdd=='Yes'){ ?>
                  <td width="4%" align="right" valign="middle"><a href="#"><img src="images/add-icon.jpg" border="0" width="25" height="28" alt="Add" title="Add" onclick="window.location='movement-master.php?action=add&selected_menu=movement'"  /></a></td>
                  <td width="7%" align="left" valign="middle" class="nav-text">Add New </td>
                  <?PHP }
				   if($btnDelete=='Yes'){ ?>
                  <td width="4%" align="right" valign="middle"><a href="#"><img src="images/delete-icon.jpg" border="0" width="25" height="28"  alt="Delete" title="Delete" onclick="AllDelete('<?=$numRows?>');"  /></a></td>
                  <td width="6%" align="left" valign="middle" class="nav-text">Delete</td>
                  <?PHP } ?>
                </tr>
              </table></td>
          </tr>
       
          <tr>
            <td align="left" valign="top" class="right-bar-content-border">
			<form name="topicform" action="movement-master.php?action=alldelete&selected_menu=movement" method="post">
			<table width="100%" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="23" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-title-text">#</span></td>
				<td width="31" height="30" align="center" valign="middle" class="right-border">
				<input type="checkbox" name="all" id="all" onclick="CheckAll('<?=$numRows?>');" /></td>
				<td width="141" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Person Name</span> </td>
				<td width="178" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Company Name</span> </td>
                <td width="179" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Title</span> </td>
				<td width="78" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Add Date</span> </td>
                <td width="137" height="30" align="center" valign="middle" class="left-border"><div align="center"><span class="right-box-title-text">Action</span></div></td>
			  </tr>
			<?php
			
			if($total_data>0) {
				$i=$starting_point+1;
				while ($data_sql = com_db_fetch_array($exe_data)) {
				$add_date = $data_sql['add_date'];
				$status = $data_sql['status'];
			?>          
			  <tr>
				<td height="30" align="center" valign="middle" class="right-border-left"><?=$i;?></td>
				<td height="30" align="center" valign="middle" class="right-border"><input type="checkbox" id="move_id-<?=$i;?>" name="nid[]" value="<?=$data_sql['move_id'];?>" /></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><a href="movement-master.php?action=detailes&p=<?=$p?>&selected_menu=movement&mID=<?=$data_sql['move_id'];?>"><?=com_db_output($data_sql['first_name'].' '.$data_sql['last_name'])?></a></td>
                <td height="30" align="left" valign="middle" class="right-border-text"><?=com_db_output($data_sql['company_name'])?></td>
                <td height="30" align="left" valign="middle" class="right-border-text"><?=com_db_output($data_sql['title'])?></td>
                <td height="30" align="center" valign="middle" class="right-border"><?=$add_date;?></td>
				<td height="30" align="center" valign="middle" class="left-border">
					<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr> 
					  <?PHP if($btnStatus=='Yes'){ 
                         	if($status==0){ ?>
					   	<td width="31%" align="center" valign="middle"><a href="#"><img src="images/icon/active-icon.gif" width="16" height="16" alt="" title="" border="0" onclick="confirm_artivate('<?=$data_sql['move_id'];?>','<?=$p;?>','<?=$status;?>');" /></a><br />
					   	  Status</td>
					   	<?php } elseif($status==1){ ?>
					   	<td width="25%" align="center" valign="middle"><a href="#"><img src="images/icon/inactive-icon.gif" width="16" height="16" alt="" title="" border="0" onclick="confirm_artivate('<?=$data_sql['move_id'];?>','<?=$p;?>','<?=$status;?>');" /></a><br />
					   	  Status</td>
						<?php } 
					  	}
					   if($btnEdit=='Yes'){ ?>
						<td width="17%" align="center" valign="middle"><a href="#"><img src="images/small-edit-icon.gif" width="16" height="16" alt="Edit" title="Edit" border="0" onclick="window.location='movement-master.php?selected_menu=movement&p=<?=$p;?>&mID=<?=$data_sql['move_id'];?>&action=edit'" /></a><br />
						  Edit</td>
                       <?PHP }
					    if($btnDelete=='Yes'){ ?>   
						<td width="27%" align="center" valign="middle"><a href="#"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" title="Delete" border="0" onclick="confirm_del('<?=$data_sql['move_id'];?>','<?=$p;?>')" /></a><br />
						  Delete</td>
                       <?PHP } ?>   
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
  
<?php } elseif($action=='edit'){ ?>	
<script language="javascript" type="text/javascript">
function chk_form(){
	var title=document.getElementById('title').value;
	
	if(title==''){
		alert("Please enter title.");
		document.getElementById('title').focus();
		return false;
	}
}

</script>		

		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">Movement Manager :: Edit Movement </td>
				  
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top"  class="right-bar-content-border-box"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="celter" valign="top">
		 <!--start iner table  -->
		 <form name="frmDataEdit" id="frmDataEdit" method="post" enctype="multipart/form-data" action="movement-master.php?action=editsave&selected_menu=movement&mID=<?=$mID;?>&p=<?=$p;?>" onsubmit="return chk_form();">
			<table width="95%" align="center" cellpadding="5" cellspacing="5" border="0">
             <tr>
              <td align="left">
                <table width="100%" cellpadding="4" cellspacing="4" border="0">
                  	<tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Title:</b></td>
                        <td width="75%" align="left" valign="top">
                          <input type="text" name="title" id="title" size="30" value="<?=$title;?>"/>
                   	</tr>
                  	<tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Person Name:</b></td>
                        <td width="75%" align="left" valign="top">
                            <select name="personal_id" id="personal_id" style="width:208px;" onchange="PersonalInformationMovement('personal_id');">
                                <option value="">--Select Person Name--</option>
                                <?=selectComboBox("select personal_id,concat(first_name,' ',last_name) as full_name from ".TABLE_PERSONAL_MASTER." where status=0 order by first_name",$personal_id)?>
                            </select>
                        </td>	
                    </tr>
                    <tr>
                      <td align="left" colspan="2">
                      		<?PHP 
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
                            <select name="company_id" id="company_id" style="width:208px;" onchange="CompanyInformationMovement('company_id');">
                                <option value="">--Select Company Name--</option>
                                <?=selectComboBox("select company_id,company_name from ".TABLE_COMPANY_MASTER." where status=0 order by company_name",$company_id)?>
                            </select>
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
                                      <td width="75%" align="left" valign="top"><input type="test" name="phone" id="phone" value="<?=com_db_output($companyRow['phone'])?>"/></td>	
                                    </tr>
                                    <tr>
                                      <td width="25%" align="left" class="page-text" valign="top">Fax:</td>
                                      <td width="75%" align="left" valign="top"><input type="test" name="fax" id="fax" value="<?=com_db_output($companyRow['fax'])?>"/></td>	
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
                        <td width="25%" align="left" class="page-text" valign="top"><b>Announcement Date:</b></td>
                        <td width="75%" align="left" valign="top"><input type="text" name="announce_date" id="announce_date" size="30" value="<?=$announce_date?>"/>
						<a href="javascript:NewCssCal('announce_date','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a></td>	
                    </tr>
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Effective Date:</b></td>
                        <td width="75%" align="left" valign="top"><input type="text" name="effective_date" id="effective_date" size="30" value="<?=$effective_date?>"/>
						<a href="javascript:NewCssCal('effective_date','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a></td>	
                    </tr>
                    
                    <tr>
                      <td width="26%" align="left" class="page-text" valign="top"><b>Headline:</b></td>
                      <td width="50%" align="left" valign="top">
						<input name="headline" id="headline" size="30" value="<?=$headline;?>" />
                      </td>
                    </tr>
                    <tr>
                      <td width="26%" align="left" class="page-text" valign="top"><b>Full Body:</b></td>
                      <td width="50%" align="left" valign="top"><textarea name="full_body" id="full_body" rows="7" cols="40" ><?=$full_body;?></textarea></td>	
                      <td width="24%" align="left" class="MsgShowText" valign="middle">&nbsp;</td>
                    </tr>
                    <tr>
                      <td width="26%" align="left" class="page-text" valign="top"><b>Short url:</b></td>
                      <td width="50%" align="left" valign="top"><input type="text" name="short_url" id="short_url" size="30" value="<?=$short_url;?>"/></td>	
                      <td width="24%" align="left" class="MsgShowText" valign="middle">&nbsp;</td>
                    </tr>
                    
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>What Happened:</b></td>
                        <td width="75%" align="left" valign="top">
                        	<textarea  id="what_happened" name="what_happened"><?=$what_happened?></textarea>
							<script type="text/javascript">
                            //<![CDATA[
                                CKEDITOR.replace('what_happened');
                            //]]>
                            </script>
                        </td>	
                    </tr>
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Movement Type:</b></td>
                        <td width="75%" align="left" valign="top">
                        	<select name="movement_type" id="movement_type" style="width:208px;">
                                <option value="">--Select movement type--</option>
                                <?=selectComboBox("select id,name from ".TABLE_MANAGEMENT_CHANGE." where status=0 order by name",$movement_type)?>
                            </select>
                        </td>	
                    </tr>
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Source:</b></td>
                        <td width="75%" align="left" valign="top">
                        	<select name="source_id" id="source_id" style="width:208px;">
                                <option value="">--Select Source--</option>
                                <?=selectComboBox("select id,source from ".TABLE_SOURCE." where status=0 order by source",$source_id)?>
                            </select>
                        </td>	
                    </tr>
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Movement URL:</b></td>
                        <td width="75%" align="left" valign="top"><input type="text" name="movement_url" id="movement_url" size="70" value="<?=$movement_url?>" /></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top"><b>More Link:</b></td>
                      <td width="75%" align="left" valign="top"><input type="text" name="more_link" id="more_link" size="30" value="<?=$more_link?>" />
                      </td>	
                    </tr>
					<tr>
                      <td width="25%" align="left" class="page-text" valign="top"><b>Not Current?:</b></td>
                      <td width="75%" align="left" valign="top"><input type="checkbox" name="not_current" id="not_current" value="Yes"  <?PHP if($not_current=='Yes'){echo 'checked="checked"';}?>/>
                      </td>	
                    </tr>
                  </table>
                </td>	
            </tr>
            <tr>
            	<td align="center">
                	<table width="50%" border="0" cellpadding="4" cellspacing="4">
                    	<tr>
                        	<td width="22%"><input type="submit" value="Update Movement" class="submitButton" /></td>
                            <td width="78%"><input type="button" class="submitButton" value="Cancel" onclick="window.location='movement-master.php?p=<?=$p;?>&mID=<?=$mID;?>&selected_menu=movement'" /></td>
                        </tr>
                    </table>
                </td>
             </tr>
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
} elseif($action=='add'){
?>		
<script language="javascript" type="text/javascript">
function chk_form_Add(){
	var title=document.getElementById('title').value;
	if(title==''){
		alert("Please enter title.");
		document.getElementById('title').focus();
		return false;
	}
}

</script>
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">Movement Manager :: Add Movement </td>
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="left" valign="top" class="right-border-box">
		 <!--start iner table  -->
		 <form name="DateTest" method="post" enctype="multipart/form-data" action="movement-master.php?action=addsave&selected_menu=movement&mID=<?=$mID;?>&p=<?=$p;?>" onsubmit="return chk_form_Add();">
		  <table width="95%" align="left" cellpadding="5" cellspacing="5" border="0">
            <tr>
              <td align="left">
                <table width="100%" cellpadding="4" cellspacing="4" border="0">
                  	<tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Title:</b></td>
                        <td width="75%" align="left" valign="top">
                          <input type="text" name="title" id="title" size="30" />
                   	</tr>
                  	<tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Person Name:</b></td>
                        <td width="75%" align="left" valign="top">
                            <select name="personal_id" id="personal_id" style="width:208px;" onchange="PersonalInformationMovement('personal_id');">
                                <option value="">--Select Person Name--</option>
                                <?=selectComboBox("select personal_id,concat(first_name,' ',last_name) as full_name from ".TABLE_PERSONAL_MASTER." where status=0 order by first_name",$personal_id)?>
                            </select>
                        </td>	
                    </tr>
                    <tr>
                      <td align="left" colspan="2">
                            <div id="DivPersonalInformationMovementShow"></div>
                      </td>	
                    </tr>
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Company Name:</b></td>
                        <td width="75%" align="left" valign="top">
                            <select name="company_id" id="company_id" style="width:208px;" onchange="CompanyInformationMovement('company_id');">
                                <option value="">--Select Company Name--</option>
                                <?=selectComboBox("select company_id,company_name from ".TABLE_COMPANY_MASTER." where status=0 order by company_name",'')?>
                            </select>
                        </td>	
                    </tr>
                    <tr>
                      <td align="left" colspan="2">
                            <div id="DivCompanyInformationMovementShow"></div>
                      </td>	
                    </tr>
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Announcement Date:</b></td>
                        <td width="75%" align="left" valign="top"><input type="text" name="announce_date" id="announce_date" size="30"/>
						<a href="javascript:NewCssCal('announce_date','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a></td>	
                    </tr>
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Effective Date:</b></td>
                        <td width="75%" align="left" valign="top"><input type="text" name="effective_date" id="effective_date" size="30"/>
						<a href="javascript:NewCssCal('effective_date','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a></td>	
                    </tr>
                     <tr>
                      <td width="25%" align="left" class="page-text" valign="top"><b>Headline:</b></td>
                      <td width="75%" align="left" valign="top"><input type="text" name="headline" id="headline" size="30" value="" /></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top"><b>Full Body:</b></td>
                      <td width="75%" align="left" valign="top"><textarea name="full_body" id="full_body" rows="5" cols="23" ></textarea></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top"><b>Short url:</b></td>
                      <td width="75%" align="left" valign="top"><input type="text" name="short_url" id="short_url" size="30" value="" /></td>	
                    </tr>
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>What Happened:</b></td>
                        <td width="75%" align="left" valign="top">
                         	<textarea  id="what_happened" name="what_happened"></textarea>
							<script type="text/javascript">
                            //<![CDATA[
                                CKEDITOR.replace('what_happened');
                            //]]>
                            </script>
                        </td>	
                    </tr>
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Movement Type:</b></td>
                        <td width="75%" align="left" valign="top">
                        	<select name="movement_type" id="movement_type" style="width:208px;">
                                <option value="">--Select movement type--</option>
                                <?=selectComboBox("select id,name from ".TABLE_MANAGEMENT_CHANGE." where status=0 order by name",'')?>
                            </select>
                        </td>	
                    </tr>
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Source:</b></td>
                        <td width="75%" align="left" valign="top">
                        	<select name="source_id" id="source_id" style="width:208px;">
                                <option value="">--Select Source--</option>
                                <?=selectComboBox("select id,source from ".TABLE_SOURCE." where status=0 order by source",'')?>
                            </select>
                        </td>	
                    </tr>
                    <tr>
                        <td width="25%" align="left" class="page-text" valign="top"><b>Movement URL:</b></td>
                        <td width="75%" align="left" valign="top"><input type="text" name="movement_url" id="movement_url" size="70" /></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top"><b>More Link:</b></td>
                      <td width="75%" align="left" valign="top"><input type="text" name="more_link" id="more_link" size="30" value="" />
                      </td>	
                    </tr>
					<tr>
                      <td width="25%" align="left" class="page-text" valign="top"><b>Not Current?:</b></td>
                      <td width="75%" align="left" valign="top"><input type="checkbox" name="not_current" id="not_current" value="Yes" onclick="CurrentStatusCheck();" />
                      </td>	
                    </tr>
                  </table>
                </td>	
            </tr>
           
            <tr>
            	<td align="center">
                	<table width="50%" border="0" cellpadding="4" cellspacing="4">
                    	<tr><td><input type="submit" value="Add Movement" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="Cancel" onclick="window.location='movement-master.php?p=<?=$p;?>&mID=<?=$mID;?>&selected_menu=movement'" /></td></tr>
                    </table>
                </td>
             </tr>
            
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
} elseif($action=='detailes'){
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
                      		<?PHP 
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
                      		<?PHP
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
                    	<tr><td><input type="button" class="submitButton" value="Back" onclick="window.location='movement-master.php?p=<?=$p;?>&selected_menu=movement'" /></td></tr>
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