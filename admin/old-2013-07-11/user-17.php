<?php
require('includes/include_top.php');

$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 20;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';

if($action == 'UserSearchResult' || $_SESSION['sess_action']=='UserSearchResult'){
	if($action == 'UserSearchResult'){
		$first_name	= $_POST['sfirst_name'];
		$last_name	= $_POST['slast_name'];
		$title		= $_POST['stitle'];
		$company	= $_POST['scompany'];
		$status		= $_POST['sstatus'];
		$level		= $_POST['slevel'];
		$form_date	= $_POST['from_date'];
		$to_date	= $_POST['to_date'];
		
		$_SESSION['sess_first_name'] = $first_name;
		$_SESSION['sess_last_name'] = $last_name;
		$_SESSION['sess_title'] = $title;
		$_SESSION['sess_company'] = $company;
		$_SESSION['sess_status'] = $status;
		$_SESSION['sess_level'] = $level;
		$_SESSION['sess_form_date'] = $form_date;
		$_SESSION['sess_to_date'] = $to_date;
		$_SESSION['sess_action'] = $action;
	}else{
		$first_name	= $_SESSION['sess_first_name'];
		$last_name	= $_SESSION['sess_last_name'];
		$title		= $_SESSION['sess_title'];
		$company	= $_SESSION['sess_company'];
		$status		= $_SESSION['sess_status'];
		$level		= $_SESSION['sess_level'];
		$form_date	= $_SESSION['sess_form_date'];
		$to_date	= $_SESSION['sess_to_date'];
	}
	$search_qry='';
	if($first_name!=''){
		$search_qry .= " first_name like '".$first_name."%'";
	}
	if($last_name!=''){
		if($search_qry==''){
			$search_qry .= " last_name like '".$last_name."%'";
		}else{
			$search_qry .= " and last_name like '".$last_name."%'";
		}	
	}
	if($title!=''){
		if($search_qry==''){
			$search_qry .= " title ='".$title."'";
		}else{
			$search_qry .= " and title ='".$title."%'";
		}	
	}
	if($company!=''){
		if($search_qry==''){
			$search_qry .= " company_name = '".$company."'";
		}else{
			$search_qry .= " and company_name = '".$company."'";
		}	
	}
	
	if($status!=''){
		if($search_qry==''){
			$search_qry .= " status = '".$status."'";
		}else{
			$search_qry .= " and status = '".$status."'";
		}	
	}
	if($level!=''){
		if($search_qry==''){
			$search_qry .= " level = '".$level."'";
		}else{
			$search_qry .= " and level = '".$level."'";
		}	
	}
	if($from_date!='' && strlen($from_date)==10 && $to_date !='' && strlen($to_date)==10){
		$fdt = explode('/',$from_date);
		$fdate = $fdt[2].'-'.$fdt[0].'-'.$fdt[1];
		$tdt = explode('/',$to_date);
		$tdate = $tdt[2].'-'.$tdt[0].'-'.$tdt[1];
		if($search_qry==''){
			$search_qry .= " res_date >= '".$fdate."' and res_date <='".$tdate."'";
		}else{
			$search_qry .= " and res_date >= '".$fdate."' and res_date <='".$tdate."'";
		}	
	}
	if($search_qry==''){
		$sql_query = "select * from " . TABLE_USER . " order by user_id desc";
	}else{
		$sql_query = "select * from " . TABLE_USER . " where ". $search_qry." order by user_id desc";
	}

}else{
	$sql_query = "select * from " . TABLE_USER . " order by user_id desc";
	$_SESSION['sess_action']='';
}


//$sql_query = "select * from " . TABLE_USER . " order by user_id desc";
/***************** FOR PAGIN ***********************/
$starting_point = $items_per_page * ($p - 1);
/****************** END PAGIN ***********************/
$main_page = 'user.php';

$exe_query=com_db_query($sql_query);
$num_rows=com_db_num_rows($exe_query);
$total_data = $num_rows;

/************ FOR PAGIN **************/
$sql_query .= " LIMIT $starting_point,$items_per_page";
$exe_data = com_db_query($sql_query);

$numRows = com_db_num_rows($exe_data);
/************ END ********************/


$uID = (isset($_GET['uID']) ? $_GET['uID'] : $select_data[0]);

    switch ($action) {
		
	  case 'delete':
	   		
			com_db_query("delete from " . TABLE_USER . " where user_id = '" . $uID . "'");
			$_SESSION['sess_action']='';
		 	com_redirect("user.php?p=" . $p . "&selected_menu=user&msg=" . msg_encode("User deleted successfully"));
		
		break;
		
	  case 'alldelete':
	   		$user_id = $_POST['nid'];
			$_SESSION['sess_action']='';
			for($i=0; $i< sizeof($user_id) ; $i++){
				com_db_query("delete from " . TABLE_USER . " where user_id = '" . $user_id[$i] . "'");
			}
		 	com_redirect("user.php?p=" . $p . "&selected_menu=user&msg=" . msg_encode("User deleted successfully"));
		
		break;	
		
	  case 'edit':
     		
	   		$query_edit=com_db_query("select * from " . TABLE_USER . " where user_id = '" . $uID . "'");
	  		$data_edit=com_db_fetch_array($query_edit);
			
			$first_name=com_db_output($data_edit['first_name']);
			$last_name=com_db_output($data_edit['last_name']);
			$title=com_db_output($data_edit['title']);
			$company=com_db_output($data_edit['company_name']);
			$phone = com_db_output($data_edit['phone']);
			$email=com_db_output($data_edit['email']);
			$password = com_db_output($data_edit['password']);
			$rdt = explode('-',$data_edit['res_date']);
			$reg_date = date('m/d/Y',mktime(0,0,0,$rdt[1],$rdt[2],$rdt[0]));
			$edt = explode('-',$data_edit['exp_date']);
			$exp_date = date('m/d/Y',mktime(0,0,0,$edt[1],$edt[2],$edt[0]));
			$sub_status = $data_edit['status'];
			$subscription_id = $data_edit['subscription_id'];
			$_SESSION['sess_action']='';
		break;	
		
		case 'editsave':
			
			$first_name = com_db_input($_POST['first_name']);
			$last_name = com_db_input($_POST['last_name']);
			$title = com_db_input($_POST['title']);
			$company_name = com_db_input($_POST['company_name']);
			$phone = com_db_input($_POST['phone']);
			$email = com_db_input($_POST['email']);
			$password = com_db_input($_POST['password']);
			$modify_date = date('Y-m-d');
			$rdt = $_POST['reg_date'];
			if($rdt !='' && strlen($rdt)==10){
				$rdt = explode('/',$rdt);
				$reg_date = date('Y-m-d',mktime(0,0,0,$rdt[0],$rdt[1],$rdt[2]));
			}else{
				$reg_date = '';
			}
			$edt = $_POST['exp_date'];
			if($edt !='' && strlen($edt)==10){
				$edt = explode('/',$edt);
				$exp_date = date('Y-m-d',mktime(0,0,0,$edt[0],$edt[1],$edt[2]));
			}else{
				$exp_date = '';
			}
			$sub_status = $_POST['sub_status'];
			$subscription_id = $_POST['subscription_id'];
			/*$sub_level = $_POST['sub_level'];*/
			if($subscription_id=='1'){
				$sub_level='Free';
			}else{
				$sub_level='Paid';
			}
			
			$Free_Paid = com_db_GetValue("select level from " .TABLE_USER." where user_id='".$uID."'");
			
			$query = "update " . TABLE_USER . " set first_name = '" . $first_name . "',  last_name = '" . $last_name . "', title = '" . $title . "', company_name = '".$company_name."', phone = '".$phone."', email='".$email."', password = '" . $password ."', modify_date = '".$modify_date."', exp_date='".$exp_date."',res_date='".$reg_date."',subscription_id='".$subscription_id."', status='".$sub_status."', level ='".$sub_level."'  where user_id = '" . $uID . "'";
			com_db_query($query);
			
			if($Free_Paid != $sub_level){
				$query = "update " . TABLE_USER . " set payment_by = 'Admin' where user_id = '" . $uID . "'";
				com_db_query($query);
				com_db_query("insert into ".TABLE_ADMIN_PAYMENT_RECIVE."(user_id,level,date_time,add_date)values('$uID','$sub_level','".time()."','".date('Y_m-d')."')");
			}
			$_SESSION['sess_action']='';
	  		com_redirect("user.php?p=". $p ."&uID=" . $uID . "&selected_menu=user&msg=" . msg_encode("User update successfully"));
		 
		break;		
		
	  
		
	case 'addsave':
			
			$first_name = com_db_input($_POST['first_name']);
			$last_name = com_db_input($_POST['last_name']);
			$title = com_db_input($_POST['title']);
			$company_name = com_db_input($_POST['company_name']);
			$phone = com_db_input($_POST['phone']);
			$email = com_db_input($_POST['email']);
			$password = com_db_input($_POST['password']);
			$exp_date = date('Y-m-d',mktime(0,0,0,date("m"),date("d"),date("Y")+5));
			
			$added = date('Y-m-d');
			$_SESSION['sess_action']='';
			$query = "insert into " . TABLE_USER . " (first_name, last_name, title, company_name, phone, email, password, subscription_id, exp_date, res_date, accept, status) values ('$first_name', '$last_name', '$title','$company_name','$phone','$email','$password','1','$exp_date','$added','1','0')";
			com_db_query($query);
			$_SESSION['sess_action']='';
	  		com_redirect("user.php?p=" . $p . "&selected_menu=user&msg=" . msg_encode("New news added successfully"));
		 
		break;	
		
	case 'detailes':
			
			$query_edit=com_db_query("select * from " . TABLE_USER . " where user_id = '" . $uID . "'");
	  		$data_edit=com_db_fetch_array($query_edit);
			
			$first_name = com_db_output($data_edit['first_name']);
			$last_name = com_db_output($data_edit['last_name']);
			$title = com_db_output($data_edit['title']);
			$company_name = com_db_output($data_edit['company_name']);
			$phone = com_db_output($data_edit['phone']);
			$email = com_db_output($data_edit['email']);
			$password = com_db_output($data_edit['password']);
			$subscription_name = com_db_GetValue("select subscription_name from " . TABLE_SUBSCRIPTION . " where sub_id = '". $data_edit['subscription_id'] ."'");
			$add_date =explode('-',$data_edit['res_date']);
			$post_date = date('d, M Y',mktime(0,0,0,date($add_date[1]),date($add_date[2]),date($add_date[0])));
			$rdt = explode('-',$data_edit['res_date']);
			$reg_date = date('m/d/Y',mktime(0,0,0,$rdt[1],$rdt[2],$rdt[0]));
			$edt = explode('-',$data_edit['exp_date']);
			$exp_date = date('m/d/Y',mktime(0,0,0,$edt[1],$edt[2],$edt[0]));
			if($data_edit['status']==0){
				$sub_status='Active';
			}else{
				$sub_status='Not Active';
			}	
			$sub_level=$data_edit['level'];
			$_SESSION['sess_action']='';
			
		break;	
	case 'activate':
     		
	   		$status=$_GET['status'];
			if($status==0){
				$query = "update " . TABLE_USER . " set status = '1' where user_id = '" . $uID . "'";
			}else{
				$query = "update " . TABLE_USER . " set status = '0' where user_id = '" . $uID . "'";
			}	
			com_db_query($query);
			$_SESSION['sess_action']='';
	  		com_redirect("user.php?p=". $p ."&uID=" . $uID . "&selected_menu=user&msg=" . msg_encode("User update successfully"));
			
		break;
	case 'AlertConfirm':
     		
	   	$title 				= $_POST['title'];
		if($title =='Type in the Title'){$title ='';}
		$management 		= $_POST['management'];
		$country			= $_POST['country'];
		$state				= $_POST['state'];
		$city				= $_POST['city'];
		if($city =='Type in the City'){$city ='';}
		$zip_code			= $_POST['zip_code'];
		if($zip_code =='Type in the Zip code'){	$zip_code='';}
		$company			= $_POST['company'];
		if($company =='Type in the Company Name'){$company='';}
		$industry			= $_POST['industry'];
		$revenue_size		= $_POST['revenue_size'];
		$employee_size		= $_POST['employee_size'];
		$delivery_schedule 	= $_POST['delivery_schedule'];
		$monthly_budget		= $_POST['monthly_budget'];
		$_SESSION['sess_action']='';	
		break;	
	case 'CreateAlert':
     	
	   	$title 				= $_POST['title'];
		if($title =='Type in the Title'){$title ='';}
		$management 		= $_POST['management'];
		$country			= $_POST['country'];
		$state				= $_POST['state'];
		$city				= $_POST['city'];
		if($city =='Type in the City'){$city ='';}
		$zip_code			= $_POST['zip_code'];
		if($zip_code =='Type in the Zip code'){	$zip_code='';}
		$company			= $_POST['company'];
		if($company =='Type in the Company Name'){$company='';}
		$industry			= $_POST['industry'];
		$revenue_size		= $_POST['revenue_size'];
		$employee_size		= $_POST['employee_size'];
		$delivery_schedule 	= $_POST['delivery_schedule'];
		$monthly_budget		= $_POST['monthly_budget'];
		$_SESSION['sess_action']='';
		break;		
	
    }
	


include("includes/header.php");
?>
<script type="text/javascript">
function confirm_del(nid,p){
	var agree=confirm("User will be deleted. \n Do you want to continue?");
	if (agree)
		window.location = "user.php?selected_menu=user&uID=" + nid + "&p=" + p + "&action=delete";
	else
		window.location = "user.php?selected_menu=user&uID=" + nid + "&p=" + p ;
}

function CheckAll(numRows){
	if(document.getElementById('all').checked){
		for(i=1; i<=numRows; i++){
			var user_id='user_id-'+ i;
			document.getElementById(user_id).checked=true;
		}
	} else {
		for(i=1; i<=numRows; i++){
			var user_id='user_id-'+ i;
			document.getElementById(user_id).checked=false;
		}
	}
}

function AllDelete(numRows){

	var flg=0;
	for(i=1; i<=numRows; i++){
			var user_id='user_id-'+ i;
			if(document.getElementById(user_id).checked){
				flg=1;
			}	
		}
	if(flg==0){
		alert("Please checked atlist one checkbox for delete.");
		document.getElementById('user_id-1').focus();
		return false;
	} else {
		var agree=confirm("User will be deleted. \n Do you want to continue?");
		if (agree)
			 document.topicform.submit();
		else
			window.location = "user.php?selected_menu=user";
	}	

}

function confirm_artivate(nid,p,status){
	if(status=='1'){
		var msg="User will be active. \n Do you want to continue?";
	}else{
		var msg="User will be Inactive. \n Do you want to continue?";
	}
	var agree=confirm(msg);
	if (agree)
		window.location = "user.php?selected_menu=user&uID=" + nid + "&p=" + p + "&status=" + status + "&action=activate";
	else
		window.location = "user.php?selected_menu=user&uID=" + nid + "&p=" + p ;
}

function UserSearch(){
	window.location ='user.php?action=UserSearch&selected_menu=user';
}
function PaymentShow(pi){
	document.getElementById(pi).style.display='block';
}
function PaymentClose(pi){
	document.getElementById(pi).style.display='none';
}
</script>

 <tr>
    <td align="left" valign="top" bgcolor="#FFFFFF">
	
	<div id="light" class="white_content" style="display:<? if($action=='UserSearch'){ echo 'block';} else { echo 'none'; } ?>;">
		<div id="spiffycalendar" class="text"></div>
		<link rel="stylesheet" type="text/css" href="includes/javascript/spiffyCal/spiffyCal_v2_1.css">
		<script language="JavaScript" src="includes/javascript/spiffyCal/spiffyCal_v2_1.js"></script>
		<script language="javascript"><!--
		  var dateAvailableFrom = new ctlSpiffyCalendarBox("dateAvailableFrom", "frmSearch", "from_date","btnDate1","",scBTNMODE_CUSTOMBLUE);
		  var dateAvailableTo = new ctlSpiffyCalendarBox("dateAvailableTo", "frmSearch", "to_date","btnDate2","",scBTNMODE_CUSTOMBLUE);	
		//--></script>
		<form name="frmSearch" id="frmSearch" method="post" action="user.php?selected_menu=user&action=UserSearchResult">
		<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
		  <tr>
			<td align="left" colspan="2" valign="top"><img src="images/specer.gif" width="1" height="20" alt="" title="" /> </td>
		  </tr>
		  <tr>
			<td width="26%" align="left" valign="top" >First Name:</td>
			<td width="74%" align="left" valign="top"><input name="sfirst_name" id="sfirst_name" /></td>
		  </tr>
		  <tr>
			<td align="left" valign="top">Last Name:</td>
			<td align="left" valign="top"><input name="slast_name" id="slast_name" /></td>
		  </tr>
		   <tr>
			<td align="left" valign="top">Title:</td>
			<td align="left" valign="top"><input name="stitle" id="stitle" /></td>
		  </tr>
		   <tr>
			<td align="left" valign="top">Company:</td>
			<td align="left" valign="top"><input name="scompany" id="scompany" /></td>
		  </tr>
		  <tr>
			<td align="left" valign="top">Status:</td>
			<td align="left" valign="top">
				<select name="sstatus" id="sstatus" >
					<option value="">All</option>
					<option value="0">Active</option>
					<option value="1">Inactive</option>
				</select>			</td>
		  </tr>
		  <tr>
			<td align="left" valign="top">Level:</td>
			<td align="left" valign="top">
				<select name="slevel" id="slevel" >
					<option value="">All</option>
					<option value="Free">Free</option>
					<option value="Paid">Paid</option>
				</select>			</td>
		  </tr>
		  <tr>
			<td align="left" valign="top">Date Joined:</td>
			<td align="left" valign="top">
				From:<script language="javascript">dateAvailableFrom.writeControl(); dateAvailableFrom.dateFormat="MM/dd/yyyy";</script>
				</td>
		  </tr>
		   <tr>
			<td align="center" valign="top">&nbsp;</td>
			<td align="left" valign="top">
				To:&nbsp;&nbsp;&nbsp;<script language="javascript">dateAvailableTo.writeControl(); dateAvailableTo.dateFormat="MM/dd/yyyy";</script>
			</td>
		  </tr>
		  
		  <tr>
			<td align="left" colspan="2" valign="top"><img src="images/specer.gif" width="1" height="20" alt="" title="" /> </td>
		  </tr>
		  <tr>
			<td align="center" valign="top">&nbsp;</td>
		  	<td align="left" valign="top"><input type="submit" value="Search" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='user.php?selected_menu=user'" /></td>
		  </tr>
		  <tr>
			<td align="left" colspan="2" valign="top"><img src="images/specer.gif" width="1" height="100" alt="" title="" /> </td>
		  </tr>
		</table>
		</form>
	</div>
	<div id="fade" class="black_overlay" style="display:<? if($action=='UserSearch'){ echo 'block';} else { echo 'none'; } ?>;"></div>
	
	<table width="975" border="0" align="center" cellpadding="0" cellspacing="0">

      <tr>
		<?php
		include("includes/menu_left.php");
		?>
		<td width="10" align="left" valign="top">&nbsp;</td>
        <td width="769" align="left" valign="top">

<?php if(($action == '') || ($action == 'save') || ($action == 'UserSearch') || ($action == 'UserSearchResult')){	?>			

		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
          <tr>
            <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="16%" align="left" valign="middle" class="heading-text">User Manager</td>
                  <td width="53%" align="left" valign="middle" class="message"><?=$msg?></td>
				  <td width="4%" align="right" valign="middle"><a href="#"><img src="images/search-icon.jpg" border="0" width="25" height="28"  alt="Search User" title="Search User" onclick="UserSearch('UserSearch');"  /></a></td>
				  <td width="6%" align="left" valign="middle" class="nav-text">Search</td>
                  <td width="4%" align="right" valign="middle"><a href="#"><img src="images/add-icon.jpg" border="0" width="25" height="28" alt="Add User" title="Add User" onclick="window.location='user.php?action=add&selected_menu=user'"  /></a></td>
                  <td width="7%" align="left" valign="middle" class="nav-text">Add New </td>
                  <td width="4%" align="right" valign="middle"><a href="#"><img src="images/delete-icon.jpg" border="0" width="25" height="28"  alt="Delete User" title="Delete User" onclick="AllDelete('<?=$numRows?>');"  /></a></td>
                  <td width="6%" align="left" valign="middle" class="nav-text">Delete</td>
                </tr>
              </table></td>
          </tr>
       
          <tr>
            <td align="left" valign="top" class="right-bar-content-border">
			<form name="topicform" action="user.php?action=alldelete&selected_menu=user" method="post">
			<table width="100%" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="22" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-title-text">#</span></td>
				<td width="31" height="30" align="center" valign="middle" class="right-border">
				<input type="checkbox" name="all" id="all" onclick="CheckAll('<?=$numRows?>');" /></td>
				<td width="189" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Name</span> </td>
				<td width="99" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Subscription</span> </td>
                <td width="138" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Alert</span> </td>
				<td width="78" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Tot. Login</span> </td>
				<td width="105" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Tot. Download</span></td>
				<td width="84" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Tot. Search</span></td>
				<td width="74" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Date</span> </td>
                <td width="141" height="30" align="center" valign="middle" class="left-border"><div align="center"><span class="right-box-title-text">Action</span></div></td>
			  </tr>
			<?php
			
			if($total_data>0) {
				$i=1;
				while ($data_sql = com_db_fetch_array($exe_data)) {
				$added_date = $data_sql['res_date'];
				$status = $data_sql['status'];
				$subscription_name = com_db_GetValue("select subscription_name from " . TABLE_SUBSCRIPTION . " where sub_id='".$data_sql['subscription_id']."'");
				$tot_alert = com_db_GetValue("select count(alert_id) as cnt from " .TABLE_ALERT ." where user_id='".$data_sql['user_id']."'");
			?>          
			  <tr>
				<td height="30" align="center" valign="middle" class="right-border-left"><?=$i;?></td>
				<td height="30" align="center" valign="middle" class="right-border"><input type="checkbox" id="user_id-<?=$i;?>" name="nid[]" value="<?=$data_sql['user_id'];?>" /></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><a href="user.php?action=detailes&selected_menu=user&uID=<?=$data_sql['user_id'];?>"><?=com_db_output($data_sql['first_name']).' '.com_db_output($data_sql['last_name'])?></a></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><?=$subscription_name;?>
					
				</td>
				<td height="30" align="center" valign="middle" class="right-border-text">
				<? if($tot_alert > 0){ ?>
				<a href="user.php?action=CreateAlert&selected_menu=user&uID=<?=$data_sql['user_id'];?>">Create Alert</a> (<?=$tot_alert?>)<br />
				<a href="javascript:popupAlert('alert-pop.php?uID=<?=$data_sql['user_id'];?>')">Change Status</a>
				<? } else { 
				echo '<a href="user.php?action=CreateAlert&selected_menu=user&uID='.$data_sql['user_id'].'">Create Alert</a>';
					} ?>
				</td>
                <td height="30" align="center" valign="middle" class="right-border"><a href="user.php?action=TotalLogin&selected_menu=user&uID=<?=$data_sql['user_id'];?>"><?=com_db_GetValue("select count(user_id) from " . TABLE_LOGIN_HISTORY . " where user_id='".$data_sql['user_id']."'")?></a></td>
				<td height="30" align="left" valign="middle" class="right-border"><a href="user.php?action=TotalDownload&selected_menu=user&uID=<?=$data_sql['user_id'];?>"><?=com_db_GetValue("select count(user_id) from " . TABLE_DOWNLOAD . " where user_id='".$data_sql['user_id']."'")?></a></td>
				<td height="30" align="left" valign="middle" class="right-border"><a href="user.php?action=TotalSearch&selected_menu=user&uID=<?=$data_sql['user_id'];?>"><?=com_db_GetValue("select count(user_id) from " . TABLE_SEARCH_HISTORY . " where user_id='".$data_sql['user_id']."'")?></a></td>
                <td height="30" align="center" valign="middle" class="right-border"><?=$added_date;?></td>
				<td height="30" align="center" valign="middle" class="left-border">
					<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr> 
					  	<?php if($status==0){ ?>
					   	<td width="29%" align="center" valign="middle"><a href="#"><img src="images/icon/active-icon.gif" width="16" height="16" alt="" title="" border="0" onclick="confirm_artivate('<?=$data_sql['user_id'];?>','<?=$p;?>','<?=$status;?>');" /></a><br />
					   	  Status</td>
					   	<?php } elseif($status==1){ ?>
					   	<td width="24%" align="center" valign="middle"><a href="#"><img src="images/icon/inactive-icon.gif" width="16" height="16" alt="" title="" border="0" onclick="confirm_artivate('<?=$data_sql['user_id'];?>','<?=$p;?>','<?=$status;?>');" /></a><br />
					   	  Status</td>
						<?php } ?>
						<td width="23%" align="center" valign="middle"><a href="#"><img src="images/small-edit-icon.gif" width="16" height="16" alt="Edit" title="Edit" border="0" onclick="window.location='user.php?selected_menu=user&p=<?=$p;?>&uID=<?=$data_sql['user_id'];?>&action=edit'" /></a><br />
						  Edit</td>
						<td width="24%" align="center" valign="middle"><a href="#"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" title="Delete" border="0" onclick="confirm_del('<?=$data_sql['user_id'];?>','<?=$p;?>')" /></a><br />
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
		<?php echo number_pages($main_page, $p, $total_data, 8, $items_per_page,'&selected_menu=user');?>		  
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

}
</script>		

		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">User Manager :: Edit User </td>
				  
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
			<form name="DateTest" method="post" action="user.php?action=editsave&selected_menu=user&uID=<?=$uID;?>&p=<?=$p;?>" onsubmit="return chk_form();">
			<tr>
			  <td width="22%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;First Name:</td>
			  <td width="78%" align="left" valign="top">
				<input type="text" name="first_name" id="first_name" size="45" value="<?=$first_name;?>" />
			  </td>	
			</tr>
			<tr>
			  <td width="22%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Last Name:</td>
			  <td width="78%" align="left" valign="top">
				<input type="text" name="last_name" id="last_name" size="45" value="<?=$last_name;?>" />
			  </td>	
			</tr>
			<tr>
			  <td width="22%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Title:</td>
			  <td width="78%" align="left" valign="top">
				<input type="text" name="title" id="title" size="45" value="<?=$title;?>" />
			  </td>	
			</tr>
            <tr>
			  <td width="22%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Company:</td>
			  <td width="78%" align="left" valign="top">
				<input type="text" name="company_name" id="company_name" size="45" value="<?=$company;?>" />
			  </td>	
			</tr>
            <tr>
			  <td width="22%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Phone:</td>
			  <td width="78%" align="left" valign="top">
				<input type="text" name="phone" id="phone" size="45" value="<?=$phone;?>" />
			  </td>	
			</tr>
            <tr>
			  <td width="22%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;E-mail:</td>
			  <td width="78%" align="left" valign="top">
				<input type="text" name="email" id="email" size="45" value="<?=$email;?>" />
			  </td>	
			</tr>
            <tr>
			  <td width="22%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Password:</td>
			  <td width="78%" align="left" valign="top">
				<input type="text" name="password" id="password" size="45" value="<?=$password;?>" />
			  </td>	
			</tr>
            <tr>
			  <td width="22%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Re-Password:</td>
			  <td width="78%" align="left" valign="top">
				<input type="text" name="re_password" id="re_password" size="45" value="<?=$password;?>" />
			  </td>	
			</tr>
			<tr>
			  <td width="22%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Registration Date:</td>
			  <td width="78%" align="left" valign="top">
				<input type="text" name="reg_date" id="reg_date" size="15" value="<?=$reg_date;?>" />
				<a href="javascript:NewCssCal('reg_date','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a>						
			  </td>	
			</tr>
			<tr>
			  <td width="22%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Expiration date:</td>
			  <td width="78%" align="left" valign="top" class="page-text">
				<input type="text" name="exp_date" id="exp_date" size="15" value="<?=$exp_date;?>" />
				<a href="javascript:NewCssCal('exp_date','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a>						
			  </td>	
			</tr>
			<tr>
			  <td width="22%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Subscription status:</td>
			  <td width="78%" align="left" valign="top" class="page-text">
			  	<input type="radio" name="sub_status" <? if($sub_status=='0'){echo 'checked="checked"';}?> value="0" />Active <br /><input type="radio" name="sub_status" <? if($sub_status=='1'){echo 'checked="checked"';}?> value="1"/>Not Active
			  </td>	
			</tr>
			<tr>
			  <td width="22%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Subscription level:</td>
			  <td width="78%" align="left" valign="top" class="page-text">
			  	<input type="radio" name="subscription_id" <? if($subscription_id=='1'){echo 'checked="checked"';}?> value="1" />Free <br />
				<input type="radio" name="subscription_id" <? if($subscription_id=='2'){echo 'checked="checked"';}?> value="2" />Basic<br />
				<input type="radio" name="subscription_id" <? if($subscription_id=='3'){echo 'checked="checked"';}?> value="3" />Standard<br />
				<input type="radio" name="subscription_id" <? if($subscription_id=='4'){echo 'checked="checked"';}?> value="4" />Professional
			  </td>	
			</tr>
			
			<tr><td align="left" valign="top">&nbsp;</td><td align="left" valign="top"><input type="submit" value="Update user" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='user.php?p=<?=$p;?>&uID=<?=$uID;?>&selected_menu=user'" /></td></tr>
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

}
</script>
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">User Manager :: Add User </td>
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
			<form name="DateTest" method="post" action="user.php?action=addsave&selected_menu=user&uID=<?=$uID;?>&p=<?=$p;?>" onsubmit="return chk_form();">
			<tr>
			  <td width="18%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;First Name:</td>
			  <td width="77%" align="left" valign="top">
				<input type="text" name="first_name" id="first_name" size="45" value="" />
			  </td>	
			</tr>
			<tr>
			  <td width="18%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Last Name:</td>
			  <td width="77%" align="left" valign="top">
				<input type="text" name="last_name" id="last_name" size="45" value="" />
			  </td>	
			</tr>
			<tr>
			  <td width="18%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Title:</td>
			  <td width="77%" align="left" valign="top">
				<input type="text" name="title" id="title" size="45" value="" />
			  </td>	
			</tr>
            <tr>
			  <td width="18%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Company:</td>
			  <td width="77%" align="left" valign="top">
				<input type="text" name="company_name" id="company_name" size="45" value="" />
			  </td>	
			</tr>
            <tr>
			  <td width="18%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Phone:</td>
			  <td width="77%" align="left" valign="top">
				<input type="text" name="phone" id="phone" size="45" value="" />
			  </td>	
			</tr>
            <tr>
			  <td width="18%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;E-mail:</td>
			  <td width="77%" align="left" valign="top">
				<input type="text" name="email" id="email" size="45" value="" />
			  </td>	
			</tr>
            <tr>
			  <td width="18%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Password:</td>
			  <td width="77%" align="left" valign="top">
				<input type="text" name="password" id="password" size="45" value="" />
			  </td>	
			</tr>
            <tr>
			  <td width="18%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Re-Password:</td>
			  <td width="77%" align="left" valign="top">
				<input type="text" name="re_password" id="re_password" size="45" value="" />
			  </td>	
			</tr>
			<tr><td align="left" valign="top">&nbsp;</td><td align="left" valign="top"><input type="submit" value="Add User" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='user.php?p=<?=$p;?>&uID=<?=$uID;?>&selected_menu=user'" /></td></tr>
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
                  <td width="50%" align="left" valign="middle" class="heading-text">User Manager :: User Details </td>
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
			  <td width="21%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;First Name:</td>
			  <td width="79%" align="left" valign="top"><?=$first_name;?> </td>	
			</tr>
			<tr>
			  <td width="21%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Last Name:</td>
			  <td width="79%" align="left" valign="top"><?=$last_name;?> </td>	
			</tr>
			<tr>
			  <td width="21%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Title:</td>
			  <td width="79%" align="left" valign="top"><?=$title;?> </td>	
			</tr>
            <tr>
			  <td width="21%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Company:</td>
			  <td width="79%" align="left" valign="top"><?=$company_name;?> </td>	
			</tr>
            <tr>
			  <td width="21%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Phone:</td>
			  <td width="79%" align="left" valign="top"><?=$phone;?> </td>	
			</tr>
            <tr>
			  <td width="21%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;E-mail:</td>
			  <td width="79%" align="left" valign="top"><?=$email;?></td>	
			</tr>
            <tr>
			  <td width="21%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Password:</td>
			  <td width="79%" align="left" valign="top"><?=$password;?></td>	
			</tr>
            <tr>
			  <td width="21%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Registration Date:</td>
			  <td width="79%" align="left" valign="top"><?=$reg_date;?></td>	
			</tr>
			<tr>
			  <td width="21%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Expiration date:</td>
			  <td width="79%" align="left" valign="top"><?=$exp_date;?></td>	
			</tr>
			<tr>
			  <td width="21%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Subscription Status:</td>
			  <td width="79%" align="left" valign="top"><?=$sub_status;?></td>	
			</tr>
			<tr>
			  <td width="21%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Subscription Level:</td>
			  <td width="79%" align="left" valign="top"><?=$subscription_name;?></td>	
			</tr>
			<tr>
				<td align="left" valign="top">&nbsp;</td> 
				<td align="left" valign="top"><input type="button" class="submitButton" value="Back" onclick="window.location='user.php?p=<?=$p;?>&uID=<?=$uID;?>&selected_menu=user'" /></td>
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
}elseif($action=='TotalLogin'){
?>		
  	  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">User Manager :: Login Details </td>
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="left" valign="top" class="right-border">
		 <!--start iner table  -->
		 <?php
		 $login_result = com_db_query("select * from " .TABLE_LOGIN_HISTORY . " where user_id='".$uID."'");
		 if($login_result){
		 	$login_num = com_db_num_rows($login_result);
		 }else{
		 	$login_num=0;
		 }
		 ?>
         	 
          <table width="55%" align="left" cellpadding="5" cellspacing="5" border="0">
			<tr>
			  <td colspan="4" align="left" class="page-text" valign="top">&nbsp;</td>
			</tr>
			<tr>
			  <td width="23%" align="left" class="page-text" valign="top"><span class="right-box-title-text">Date</span></td>
			  <td width="24%" align="left" valign="top" class="page-text"><span class="right-box-title-text">Login Time</span></td>	
			  <td width="25%" align="left" valign="top" class="page-text"><span class="right-box-title-text">Logout Time</span></td>
			  <td width="28%" align="left" valign="top" class="page-text"><span class="right-box-title-text">Access Time</span></td>
			</tr>
			<? if($login_num > 0){
				while($login_row = com_db_fetch_array($login_result)){
				$login_time = $login_row['login_time'];
				$logout_time = $login_row['logout_time'];
				$acc_hour = 0;
				$acc_min = '00';
				if($logout_time > 0){
				$acc_time = $logout_time -  $login_time;
				$acc_hour = floor($acc_time/3600);
				$acc_min =floor(floor($acc_time%3600)/60);
				if(strlen($acc_min)==1){
						$acc_min = '0'.$acc_min;
					}
				}
			?>
			<tr>
			  <td width="23%" align="left" class="page-text" valign="top"><?=$login_row['add_date']?></td>
			  <td width="24%" align="left" valign="top" class="page-text"><?=date('H:i',$login_time)?></td>	
			  <td width="25%" align="left" valign="top" class="page-text"><?=date('H:i',$logout_time)?></td>
			  <td width="28%" align="left" valign="top" class="page-text"><?=$acc_hour.'-'.$acc_min?></td>
			</tr>
			<? 		} 
				}else{	?>
			<tr>
			  <td colspan="4" align="left" class="page-text" valign="top">Record not found</td>
			</tr>
			<? } ?>	
			<tr>
				<td align="left" valign="top">&nbsp;</td> 
				<td align="left" valign="top"><input type="button" class="submitButton" value="Back" onclick="window.location='user.php?p=<?=$p;?>&uID=<?=$uID;?>&selected_menu=user'" /></td>
			    <td align="left" valign="top">&nbsp;</td>
			    <td align="left" valign="top">&nbsp;</td>
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
}elseif($action=='TotalDownload'){
?>		
  	  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">User Manager :: Download Details </td>
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="left" valign="top" class="right-border">
		 <!--start iner table  -->
         <?php
		 $download_result = com_db_query("select * from " .TABLE_DOWNLOAD . " where user_id='".$uID."'");
		 if($download_result){
		 	$download_num = com_db_num_rows($download_result);
		 }else{
		 	$download_num=0;
		 }
		 ?>
          <table width="20%" align="left" cellpadding="5" cellspacing="5" border="0">
			<tr>
			  <td colspan="2" align="left" class="page-text" valign="top">&nbsp;</td>
			</tr>
			<tr>
			  <td width="14%" align="left" valign="top"><span class="right-box-title-text">#</span></td>
			  <td width="86%" align="left" valign="top"><span class="right-box-title-text">&nbsp;&nbsp;Date</span></td>	
			</tr>
			<? if($download_num > 0){
				$dd=1;
				while($download_row = com_db_fetch_array($download_result)){
				$download_date = $download_row['add_date'];
			?>
		
			<tr>
			  <td width="14%" align="left" valign="top" class="left-box-text"><?=$dd;?></td>
			  <td width="86%" align="left" valign="top" class="left-box-text"><a href="javascript:popupDownload('popup-download.php?dID=<?=$download_row['download_id']?>')"><?=$download_date?></a></td>	
			 
			</tr>
			<? 	$dd++;
					} 
				}else{	?>
			<tr>
			  <td colspan="2" align="left" class="page-text" valign="top">Record not found</td>
			</tr>
			<? } ?>	
			
			<tr>
				<td align="left" valign="top">&nbsp;</td> 
				<td align="left" valign="top"><input type="button" class="submitButton" value="Back" onclick="window.location='user.php?p=<?=$p;?>&uID=<?=$uID;?>&selected_menu=user'" /></td>
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
}elseif($action=='TotalSearch'){
?>		
  	  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">User Manager :: Search Details </td>
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="left" valign="top" class="right-border">
		 <!--start iner table  -->
         	 
           <?php
		 $search_result = com_db_query("select * from " .TABLE_SEARCH_HISTORY . " where user_id='".$uID."'");
		 if($search_result){
		 	$search_num = com_db_num_rows($search_result);
		 }else{
		 	$search_num=0;
		 }
		 ?>
          <table width="55%" align="left" cellpadding="5" cellspacing="5" border="0">
			<tr>
			  <td colspan="4" align="left" class="page-text" valign="top">&nbsp;</td>
			</tr>
			<tr>
			  <td width="10%" align="left" valign="top"><span class="right-box-title-text">#</span></td>
			  <td width="20%" align="left" valign="top"><span class="right-box-title-text">&nbsp;&nbsp;Date</span></td>	
			  <td width="30%" align="left" valign="top"><span class="right-box-title-text">&nbsp;&nbsp;Search Type</span></td>
			  <td width="40%" align="left" valign="top"><span class="right-box-title-text">&nbsp;&nbsp;Search Details</span></td>
			</tr>
			<? if($search_num > 0){
				$ss=1;
				while($search_row = com_db_fetch_array($search_result)){
				$search_date = $search_row['add_date'];
				if($search_row['search_type'] =='Search'){
					$search_type='Search';
				}else{
					$search_type='Advance Search';
				}
			?>
		
			<tr>
			  <td width="10%" align="left" valign="top" class="left-box-text"><?=$ss;?></td>
			  <td width="20%" align="left" valign="top" class="left-box-text"><?=$search_date?></td>	
			  <td width="30%" align="left" valign="top" class="left-box-text"><?=$search_type?></td>
			  <td width="40%" align="left" valign="top" class="left-box-text">
			  	<? if($search_type=='Search'){
				 		echo $search_row['search_string'];
				   }else{
					?>
			  		<a href="javascript:popupSearch('popup-search.php?sID=<?=$search_row['search_id']?>')">Advance Search Details</a>
			  	<? } ?>	
			  </td>
			</tr>
			<? 	$ss++;
					} 
				}else{	?>
			<tr>
			  <td colspan="4" align="left" class="page-text" valign="top">Record not found</td>
			</tr>
			<? } ?>	
			
			<tr>
				<td align="left" valign="top">&nbsp;</td> 
				<td align="left" valign="top"><input type="button" class="submitButton" value="Back" onclick="window.location='user.php?p=<?=$p;?>&uID=<?=$uID;?>&selected_menu=user'" /></td>
				<td align="left" valign="top">&nbsp;</td>
				<td align="left" valign="top">&nbsp;</td>
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
}elseif($action=='CreateAlert'){
?>
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">User Manager :: Create Alert </td>
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="left" valign="top" class="right-border">
		 <!--start iner table  -->
         	
			 <form name="frm_alert" id="frm_alert" method="post" action="user.php?action=AlertConfirm&selected_menu=user&uID=<?=$uID?>">
			  <table width="673" border="0" align="center" cellpadding="0" cellspacing="0" >
				<tr>
				  <td align="left" valign="top">&nbsp;</td>
				</tr>
				
				<tr>
				  <td align="center" valign="top"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr>
						<td align="left" valign="top"><b>Chose Executive:</b></td>
					  </tr>
				  </table></td>
				</tr>
				<tr>
				  <td align="center" valign="middle"><img src="images/line.gif" width="673" height="19"  alt="" title="" /></td>
				</tr>
				<tr>
				  <td align="center" valign="middle">
				 
				  <table width="490" border="0" align="center" cellpadding="2" cellspacing="0">
					  <tr>
						<td width="204" height="27" align="left" valign="middle">Title:</td>
						<td width="278" align="left" valign="middle"><input name="title" type="text" id="title" size="46" value="<? if($title==''){echo 'Type in the Title';}else{echo $title;}?>" class="list-field" onfocus=" if (this.value == 'Type in the Title') { this.value = ''; };" onblur="if (this.value == '') { this.value='Type in the Title';};"/>
					    </td>
					  </tr>
					  <tr>
						<td width="204" height="27" align="left" valign="middle">Management Change Type:</td>
						<td width="278" align="left" valign="middle">
							<select name="management" id="management" style="width:300px;">
								<option value="">Any</option>
								<?=selectComboBox("select name,name from ".TABLE_MANAGEMENT_CHANGE,$management)?>
							</select>	
							
						</td>
					  </tr>
				  </table></td>
				</tr>
				<tr>
				  <td align="left" valign="top">&nbsp;</td>
				</tr>
				<tr>
				  <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr>
						<td align="left" valign="top"><b>Chose Location:</b></td>
					  </tr>
				  </table></td>
				</tr>
				<tr>
				  <td align="left" valign="middle"><img src="images/line.gif" width="673" height="19"  alt="" title="" /></td>
				</tr>
				<tr>
				  <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="2" cellspacing="0">
					<tr>
					  <td width="232" height="27" align="left" valign="middle">Country:</td>
					  <td width="251" align="left" valign="middle">
					  	<select name="country" id="country" style="width:300px;">
							<?=selectComboBox("select countries_name,countries_name from ".TABLE_COUNTRIES,'United States')?>
						</select>
						
					 </td>
					</tr>
					<tr>
					  <td width="232" height="27" align="left" valign="middle">State:</td>
					  <td width="251"  align="left" valign="middle">
					  	<select name="state" id="state" style="width:300px;">
							<option value="">Any</option>
							<?=selectComboBox("select short_name,short_name from ".TABLE_STATE,'')?>
						</select>
									  
					  </td>
					</tr>
					<tr>
					  <td width="232" height="27" align="left" valign="middle" class="list-field-text">City:</td>
					  <td width="251" height="27" align="left" valign="middle"><input name="city" type="text" id="city" size="46" value="<? if($city==''){echo 'Type in the City';}else{echo $city;}?>" class="list-field" onfocus=" if (this.value == 'Type in the City') { this.value = ''; };" onblur="if (this.value == '') { this.value='Type in the City';};"/></td>
					</tr>
					<tr>
					  <td width="232" height="27" align="left" valign="middle" class="list-field-text">Zip Code: </td>
					  <td width="251" height="27" align="left" valign="middle"><input name="zip_code" type="text" id="zip_code" size="46" value="<? if($zip_code==''){echo 'Type in the Zip code';}else{echo $zip_code;}?>" class="list-field" onfocus=" if (this.value == 'Type in the Zip code') { this.value = ''; };" onblur="if (this.value == '') { this.value='Type in the Zip code';};"/></td>
					</tr>
				  </table></td>
				</tr>
				
				<tr>
				  <td align="left" valign="top">&nbsp;</td>
				</tr>
				<tr>
				  <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr>
						<td align="left" valign="top"><b>Chose Company:</b></td>
					  </tr>
				  </table></td>
				</tr>
				<tr>
				  <td align="center" valign="middle"><img src="images/line.gif" width="673" height="19"  alt="" title="" /></td>
				</tr>
				<tr>
				  <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="2" cellspacing="0">
					<tr>
					  <td width="232" height="27" align="left" valign="middle">Company:</td>
					  <td width="247" height="27" align="left" valign="middle"><input name="company" type="text" id="company" size="46" value="<? if($company==''){echo 'Type in the Company Name';}else{echo $company;}?>" class="list-field" onfocus=" if (this.value == 'Type in the Company Name') { this.value = ''; };AllComboDivCloseAlert('');fieldHighlight('company');" onblur="if (this.value == '') { this.value='Type in the Company Name';};fieldLosslight('company');"/></td>
					</tr>
					<tr>
					  <td width="232" height="27" align="left" valign="middle">Industry:</td>
					  <td width="247"  align="left" valign="top">
					  	<?php
						$industry_result = com_db_query("select * from " . TABLE_INDUSTRY ." where parent_id = '0' order by industry_id");
						?>
						<select name="industry" id="industry" style="width:300px;">
							<option value="">All</option>
							<?php
							while($indus_row = com_db_fetch_array($industry_result)){
							?>
							<optgroup label="<?=$indus_row['title']?>">
							<?=selectComboBox("select title,title from ". TABLE_INDUSTRY ." where parent_id ='".$indus_row['industry_id']."'" ,$industry);?>
							</optgroup>
							<? } ?>
							<option value="Any">Any</option>
						</select>
					  </td>
					</tr>
					<tr>
					  <td width="232" height="27" align="left" valign="middle">Size ($Revenue):</td>
					  <td width="247"  align="left" valign="middle">
					  	   <select name="revenue_size" id="revenue_size" style="width:300px;">
								<option value="">Any</option>
								<?=selectComboBox("select name,name from ".TABLE_REVENUE_SIZE." order by from_range",$revenue_size)?>
							</select>
					 </td>
					</tr>
					<tr>
					  <td width="232" height="27" align="left" valign="middle" class="list-field-text">Size (Employees):</td>
					  <td width="247"  align="left" valign="top">
					  		<select name="employee_size" id="employee_size" style="width:300px;">
								<option value="">Any</option>
								<?=selectComboBox("select name,name from ".TABLE_EMPLOYEE_SIZE." order by from_range",$employee_size)?>
							</select>
						
					  </td>
					</tr>
				  </table></td>
				</tr>
				<tr>
				  <td align="left" valign="top">&nbsp;</td>
				</tr>
				<tr>
				  <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr>
						<td align="left" valign="top"><b>Chose Frequency and Budget:</b></td>
					  </tr>
				  </table></td>
				</tr>
				<tr>
				  <td align="center" valign="middle"><img src="images/line.gif" width="673" height="19"  alt="" title="" /></td>
				</tr>
				<tr>
				  <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0">
				   
					  <tr>
						<td align="left" valign="top"><table width="490" border="0" align="center" cellpadding="2" cellspacing="0">
							<tr>
								<td width="209" height="27" align="left" valign="middle">Email Alerts will be delivered:</td>
								 <td width="273"  align="left" valign="middle">
									<select name="delivery_schedule" id="delivery_schedule" style="width:300px;">
										<option value="">Any</option>
										<?=selectComboBox("select name, name from " . TABLE_EMAIL_UPDATE. " order by id",$delivery_schedule)?>
									</select>
								
							  </td>
							</tr>
						</table></td>
					  </tr>
					  <!--<tr>
						 <td align="left" valign="top"><img src="images/specer.gif" width="1" height="8" alt="" title="" /></td>
					  </tr>
					  <tr>
						<td align="left" valign="top">There is a $45 one-time set up fee per alert, and $4.5 per  each alert delivered to your inbox, up to a monthly budget that you set up.  </td>
					  </tr>
					  <tr>
					   <td align="left" valign="top"><img src="images/specer.gif" width="1" height="8" alt="" title="" /></td>
					  </tr>
					  <tr>
						<td align="left" valign="top"><table width="490" border="0" align="center" cellpadding="2" cellspacing="0">
							<tr>
							  <td width="212" height="26" align="left" valign="middle" class="list-field-text">Chose&nbsp;your&nbsp;monthly&nbsp;budget:</td>
							  <td width="270"  align="left" valign="top">
							  		<? //$buget_query = "select ap_name, ap_name from " . TABLE_ALERT_PRICE ." order by ap_amount";	
									   //$buget_result = com_db_query($buget_query);
									   ?>
								 	<select name="monthly_budget" id="monthly_budget" style="width:300px;">
										<option value="">Any</option>
										<?
										/*while($buget_row=com_db_fetch_array($buget_result)){
											if($buget_row['ap_name']=='Unlimited'){
												if($buget_row['ap_name']==$monthly_budget){
													echo '<option value="'.$buget_row['ap_name'].'" selected="selected">'.$buget_row['ap_name'].'</option>';
												}else{
													echo '<option value="'.$buget_row['ap_name'].'">'.$buget_row['ap_name'].'</option>';
												}
											}else{
												if('$'.$buget_row['ap_name']==$monthly_budget){
													echo '<option value="$'.$buget_row['ap_name'].'" selected="selected">$'.$buget_row['ap_name'].'</option>';
												}else{
													echo '<option value="$'.$buget_row['ap_name'].'">$'.$buget_row['ap_name'].'</option>';
												}
											}
										}*/
										?>
									</select>
								  
							 </td>
							</tr>
						</table></td>
					  </tr>
				  </table></td>
				</tr>-->
				<tr>
				  <td align="center" valign="middle">&nbsp;</td>
				</tr>
				<tr>
				  <td align="center" valign="middle"><table width="146" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
					  <td align="center" valign="top"><input type="submit" name="createAlert" value="Create Alert" /></a></td>
					</tr>
				  </table></td>
				</tr>
		
				<tr>
				  <td align="center" valign="middle">&nbsp;</td>
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
}elseif($action=='AlertConfirm'){
?>
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">User Manager :: Alert Confirm </td>
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="left" valign="top" class="right-border">
		 <!--start iner table  -->
         	 
        	<table width="673" border="0" align="center" cellpadding="0" cellspacing="0" >
				<tr>
				  <td align="left" valign="top">&nbsp;</td>
				</tr>
				<tr>
				  <td align="center" valign="top"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr>
						<td align="left" valign="top"><b>Chose Executive:</b></td>
					  </tr>
				  </table></td>
				</tr>
				<tr>
				  <td align="center" valign="middle"><img src="images/line.gif" width="673" height="19"  alt="" title="" /></td>
				</tr>
				<tr>
				  <td align="center" valign="middle">
				 
				  <table width="490" border="0" align="center" cellpadding="2" cellspacing="0">
					  <tr>
						<td width="232" height="27" align="left" valign="middle">Title:</td>
						<td width="250" align="left" valign="middle"><?=$title?> </td>
					  </tr>
					  <tr>
						<td width="232" height="27" align="left" valign="middle">Management Change Type:</td>
						<td width="250" align="left" valign="middle"><?=$management?></td>
					  </tr>
				  </table></td>
				</tr>
				<tr>
				  <td align="left" valign="top">&nbsp;</td>
				</tr>
				<tr>
				  <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr>
						<td align="left" valign="top"><b>Chose Location:</b></td>
					  </tr>
				  </table></td>
				</tr>
				<tr>
				  <td align="left" valign="middle"><img src="images/line.gif" width="673" height="19"  alt="" title="" /></td>
				</tr>
				<tr>
				  <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="2" cellspacing="0">
					<tr>
					  <td width="232" height="27" align="left" valign="middle">Country:</td>
					  <td width="251" align="left" valign="top"><?=$country?></td>
					</tr>
					<tr>
					  <td width="232" height="27" align="left" valign="middle">State:</td>
					  <td width="251"  align="left" valign="top"><?=$state?></td>
					</tr>
					<tr>
					  <td width="232" height="27" align="left" valign="middle">City:</td>
					  <td width="251" height="27" align="left" valign="middle"><?=$city?></td>
					</tr>
					<tr>
					  <td width="232" height="27" align="left" valign="middle">Zip Code: </td>
					  <td width="251" height="27" align="left" valign="middle"><?=$zip_code?></td>
					</tr>
				  </table></td>
				</tr>
				<tr>
				  <td align="left" valign="top">&nbsp;</td>
				</tr>
				<tr>
				  <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr>
						<td align="left" valign="top"><b>Chose Company:</b></td>
					  </tr>
				  </table></td>
				</tr>
				<tr>
				  <td align="center" valign="middle"><img src="images/line.gif" width="673" height="19"  alt="" title="" /></td>
				</tr>
				<tr>
				  <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="2" cellspacing="0">
					<tr>
					  <td width="232" height="27" align="left" valign="middle">Company:</td>
					  <td width="247" height="27" align="left" valign="middle"><?=$company?></td>
					</tr>
					<tr>
					  <td width="232" height="27" align="left" valign="middle">Industry:</td>
					  <td width="247"  align="left" valign="top"><?=$industry?></td>
					</tr>
					<tr>
					  <td width="232" height="27" align="left" valign="middle">Size ($Revenue):</td>
					  <td width="247"  align="left" valign="top"><?=$revenue_size?></td>
					</tr>
					<tr>
					  <td width="232" height="27" align="left" valign="middle">Size (Employees):</td>
					  <td width="247"  align="left" valign="top"><?=$employee_size?></td>
					</tr>
				  </table></td>
				</tr>
				<tr>
				  <td align="left" valign="top">&nbsp;</td>
				</tr>
				<tr>
				  <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr>
						<td align="left" valign="top"><b>Chose Frequency and Budget:</b></td>
					  </tr>
				  </table></td>
				</tr>
				<tr>
				  <td align="center" valign="middle"><img src="images/line.gif" width="673" height="19"  alt="" title="" /></td>
				</tr>
				<tr>
				  <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0">
				   
					  <tr>
						<td align="left" valign="top"><table width="490" border="0" align="center" cellpadding="2" cellspacing="0">
							<tr>
								<td width="232" height="27" align="left" valign="middle">Email Alerts will be delivered:</td>
								 <td width="251"  align="left" valign="top"><?=$delivery_schedule?></td>
							</tr>
						</table></td>
					  </tr>
					  					  
					  <!--<tr>
					   <td align="left" valign="top"><img src="images/specer.gif" width="1" height="8" alt="" title="" /></td>
					  </tr>
					  <tr>
						<td align="left" valign="top"><table width="490" border="0" align="center" cellpadding="2" cellspacing="0">
							<tr>
							  <td width="232" height="26" align="left" valign="middle" class="list-field-text">Chose&nbsp;your&nbsp;monthly&nbsp;budget:</td>
							  <td width="251"  align="left" valign="top" class="list-field-text"><?//=$monthly_budget?></td>
							</tr>
						</table></td>
					  </tr>-->
				  </table></td>
				</tr>
				<tr>
				  <td align="center" valign="middle">&nbsp;</td>
				</tr>
				<tr>
				  <td align="center" valign="middle">
						<table width="214" border="0" align="center" cellpadding="0" cellspacing="0">
							<tr>
							  <td align="center" valign="top">
							  <form name="frmAlertBack" id="frmAlertBack" method="post" action="user.php?action=CreateAlert&selected_menu=user&uID=<?=$uID?>">
							  <table border="0" align="center" cellpadding="0" cellspacing="0">
							  	<tr><td>
									<input type="hidden" name="title" value="<?=$title?>"/>
									<input type="hidden" name="management" id="management" value="<?=$management?>"/>
									<input type="hidden" name="country" id="country" value="<?=$country?>"/>
									<input type="hidden" name="state" id="state" value="<?=$state?>"/>
									<input type="hidden" name="city" id="city" value="<?=$city?>"/>
									<input type="hidden" name="zip_code" id="zip_code" value="<?=$zip_code?>"/>
									<input type="hidden" name="company" id="company" value="<?=$company?>"/>
									<input type="hidden" name="industry" id="industry" value="<?=$industry?>"/>
									<input type="hidden" name="revenue_size" id="revenue_size" value="<?=$revenue_size?>"/>
									<input type="hidden" name="employee_size" id="employee_size" value="<?=$employee_size?>"/>
									<input type="hidden" name="delivery_schedule" id="delivery_schedule" value="<?=$delivery_schedule?>"/>
									<input type="hidden" name="monthly_budget" id="monthly_budget" value="<?=$monthly_budget?>"/>
								</td></tr>
								<tr>
									<td align="center" valign="top" class="more_bottom">
							  		<input type="submit" name"AlertBack" value="Back" />
								
								</td>
								</tr>
							   </table>	
							   </form>
							  </td>
							  <td align="center" valign="top">&nbsp;</td>
							  <td align="center" valign="top">
							  	 <form name="frmAlertConfirm" id="frmAlertConfirm" method="post" action="alert-pro.php?action=AlertCreate&selected_menu=user&uID=<?=$uID?>">
							  	<table border="0" align="center" cellpadding="0" cellspacing="0">
							  	<tr><td>
							 
							  		<input type="hidden" name="title" value="<?=$title?>"/>
									<input type="hidden" name="management" id="management" value="<?=$management?>"/>
									<input type="hidden" name="country" id="country" value="<?=$country?>"/>
									<input type="hidden" name="state" id="state" value="<?=$state?>"/>
									<input type="hidden" name="city" id="city" value="<?=$city?>"/>
									<input type="hidden" name="zip_code" id="zip_code" value="<?=$zip_code?>"/>
									<input type="hidden" name="company" id="company" value="<?=$company?>"/>
									<input type="hidden" name="industry" id="industry" value="<?=$industry?>"/>
									<input type="hidden" name="revenue_size" id="revenue_size" value="<?=$revenue_size?>"/>
									<input type="hidden" name="employee_size" id="employee_size" value="<?=$employee_size?>"/>
									<input type="hidden" name="delivery_schedule" id="delivery_schedule" value="<?=$delivery_schedule?>"/>
									<input type="hidden" name="monthly_budget" id="monthly_budget" value="<?=$monthly_budget?>"/>
								</td>
								</tr>
								<tr>
									<td align="center" valign="top" class="more_bottom">	
							  		<input type="submit" name"AlertCreate" value="Confirm" />
									</td>
									</tr>
								</table>	
							  </form>
							  </td>
							</tr>
						  </table>
					</td>
				</tr>
		
				<tr>
				  <td align="center" valign="middle">&nbsp;</td>
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
<?
}

include("includes/footer.php");
?>