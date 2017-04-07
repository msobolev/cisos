<?php
require('../includes/configuration.php');
include('../includes/only_dataentry_include-top.php');

$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 20;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';

if($action == 'SearchResult'){
	
	
	$personal_id		= $_POST['search_personal_id'];
	$board_info		= $_POST['search_board_info'];
	
	$search_qry='';
	if($personal_id!=''){
		$search_qry .= " pb.personal_id = '".$personal_id."'";
	}
	if($job_title!=''){
		if($search_qry==''){
			$search_qry .= " pb.board_info like '".$board_info."%'";
		}else{
			$search_qry .= " and pb.board_info like '".$board_info."%'";
		}	
	}
	
	
	if($search_qry==''){
		$sql_query = "select pm.first_name,pm.last_name,pb.* from " . TABLE_PERSONAL_MASTER . " pm, ".TABLE_PERSONAL_BOARD." pb where pm.personal_id=pb.personal_id order by board_id desc";

	}else{
		$sql_query = "select pm.first_name,pm.last_name,pb.* from " . TABLE_PERSONAL_MASTER . " pm, ".TABLE_PERSONAL_BOARD." pb where (pm.personal_id=pb.personal_id) and ".$search_qry." order by board_id desc";
	}

}else{
		$sql_query = "select pm.first_name,pm.last_name,pb.* from " . TABLE_PERSONAL_MASTER . " pm, ".TABLE_PERSONAL_BOARD." pb where pm.personal_id=pb.personal_id order by board_id desc";
}
//echo $sql_query;		
/***************** FOR PAGIN ***********************/
$starting_point = $items_per_page * ($p - 1);
/****************** END PAGIN ***********************/
$main_page = 'boards.php';

$exe_query=com_db_query($sql_query);
$num_rows=com_db_num_rows($exe_query);
$total_data = $num_rows;

/************ FOR PAGIN **************/
$sql_query .= " LIMIT $starting_point,$items_per_page";
$exe_data = com_db_query($sql_query);

$numRows = com_db_num_rows($exe_data);
/************ END ********************/


$bID = (isset($_GET['bID']) ? $_GET['bID'] : $select_data[0]);

    switch ($action) {
		
	  case 'delete':
	   		
			com_db_query("delete from " . TABLE_PERSONAL_BOARD . " where board_id = '" . $bID . "'");
		 	com_redirect("boards.php?p=" . $p . "&msg=" . msg_encode("Personal Boards deleted successfully"));
		
		break;	
	  case 'edit':
     		
	   		$query_edit=com_db_query("select * from " . TABLE_PERSONAL_BOARD . " where board_id = '" . $bID . "'");
	  		$data_edit=com_db_fetch_array($query_edit);
			
			$personal_id = com_db_output($data_edit['personal_id']);
			$board_info = com_db_output($data_edit['board_info']);
			$bdt = explode('-',$data_edit['board_date']);
			$board_date = 	$bdt[1].'/'.$bdt[2].'/'.$bdt[0];
			$board_link = com_db_output($data_edit['board_link']);
			
		break;	
		
		case 'editsave':
			
			$personal_id = com_db_input($_POST['personal_id']);
			$board_info = com_db_input($_POST['board_info']);
			$bdt = explode('/',$_POST['board_date']);//mmddyyyy
			$board_date = $bdt[2].'-'.$bdt[0].'-'.$bdt[1];
			$board_link = com_db_input($_POST['board_link']);
			$modify_date = date('Y-m-d');
			
			$query = "update " . TABLE_PERSONAL_BOARD . " set personal_id = '" . $personal_id ."', board_info = '".$board_info."',board_date='".$board_date."',board_link='".$board_link."' where board_id = '" . $bID . "'";
			
			com_db_query($query);
	  		com_redirect("boards.php?p=". $p ."&bID=" . $bID . "&msg=" . msg_encode("Personal boards update successfully"));
		 
		break;		
		
	  
		
	case 'addsave':
			
			$personal_id = com_db_input($_POST['personal_id']);
			$board_info = com_db_input($_POST['board_info']);
			$bdt = explode('/',$_POST['board_date']);//mmddyyyy
			$board_date = $bdt[2].'-'.$bdt[0].'-'.$bdt[1];
			$board_link = com_db_input($_POST['board_link']);
			$status = '0';
			$add_date = date('Y-m-d');
			
			$query = "insert into " . TABLE_PERSONAL_BOARD . "
			(personal_id, board_info,board_date, board_link, add_date, status) 
			values ('$personal_id', '$board_info','$board_date','$board_link','$add_date','$status')";
			com_db_query($query);
	  		com_redirect("boards.php?p=" . $p . "&msg=" . msg_encode("Personal New Boards added successfully"));
		 
		break;	
		
	case 'detailes':
			$query_edit ="select pm.first_name,pm.last_name,pb.* from " 
							.TABLE_PERSONAL_MASTER. " as pm, " 
							.TABLE_PERSONAL_BOARD." as pb														
							where pm.personal_id=pb.personal_id and pb.board_id = '" . $bID . "'";
			
			$query_edit_result=com_db_query($query_edit);
	  		$data_edit=com_db_fetch_array($query_edit_result);
			
			$full_name = com_db_output($data_edit['first_name'].' '.$data_edit['last_name']);
			$board_info = com_db_output($data_edit['board_info']);
			$bdt = explode('-',$data_edit['board_date']);
			$board_date = 	$bdt[1].'/'.$bdt[2].'/'.$bdt[0];
			$board_link = com_db_output($data_edit['board_link']);
			$add_date =explode('-',$data_edit['add_date']);
			
		break;	
	
				
    }
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CTOsOnTheMove.com</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<!--<link href="../css/combo-box.css" rel="stylesheet" type="text/css" />-->
<link rel="shortcut icon" href="../images/favicon.jpg" type="image/x-icon" />
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="only-dataentry.js"></script>
  
<script type="text/javascript" src="../js/datetimepicker_css.js" language="javascript"></script>  
<script type="text/javascript">

function BoardsSearch(){
	window.location ='boards.php?action=BoardsSearch';
}
function confirm_del(nid,p){
	var agree=confirm("Boards will be deleted. \n Do you want to continue?");
	if (agree)
		window.location = "boards.php?bID=" + nid + "&p=" + p + "&action=delete";
	else
		window.location = "boards.php?bID=" + nid + "&p=" + p ;
}
</script>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="selectuser.js" language="javascript"></script>
</head>
<body>
<div id="light" class="white_content" style="display:<? if($action=='BoardsSearch'){ echo 'block';} else { echo 'none'; } ?>; height:auto;">
		<!--<div id="spiffycalendar" class="text"></div>
		<link rel="stylesheet" type="text/css" href="includes/javascript/spiffyCal/spiffyCal_v2_1.css">
		<script language="JavaScript" src="includes/javascript/spiffyCal/spiffyCal_v2_1.js"></script>
		<script language="javascript">
		  var dateAvailableFrom = new ctlSpiffyCalendarBox("dateAvailableFrom", "frmSearch", "from_date","btnDate1","",scBTNMODE_CUSTOMBLUE);
		  var dateAvailableTo = new ctlSpiffyCalendarBox("dateAvailableTo", "frmSearch", "to_date","btnDate2","",scBTNMODE_CUSTOMBLUE);	
		</script>-->
		<form name="frmSearch" id="frmSearch" method="post" action="boards.php?action=SearchResult">
		<table width="90%" border="0" align="center" cellpadding="1" cellspacing="1">
		  <tr>
			<td align="left" colspan="2" valign="top"><img src="images/specer.gif" width="1" height="50" alt="" title="" /> </td>
		  </tr>
		  <tr>
			<td align="left" valign="top">Personal Name:</td>
			<td align="left" valign="top">
            	<select name="search_personal_id" id="search_personal_id" style="width:206px;">
                    <option value="">Select Personal Name</option>
                   <?=selectComboBox("select personal_id,concat(first_name,' ',last_name) as name from ".TABLE_PERSONAL_MASTER." where status='0' order by first_name,last_name","")?>
                </select>
              </td>
		  </tr>
          <tr>
			<td align="center" valign="top">&nbsp;</td>
			<td align="center" valign="top">&nbsp;</td>
		  </tr>
		  <tr>
			<td align="left" valign="top">Board Info:</td>
			<td align="left" valign="top"><input name="search_board_info" id="search_board_info" size="35" /></td>
		  </tr>
		  
		  
		 <!-- <tr>
			<td align="left" valign="top">Date Entered:</td>
			<td align="left" valign="top">
				From:<script language="javascript">dateAvailableFrom.writeControl(); dateAvailableFrom.dateFormat="MM/dd/yyyy";</script>
			</td>
		  </tr>
		   <tr>
			<td align="center" valign="top">&nbsp;</td>
			<td align="left" valign="top">
				To:&nbsp;&nbsp;&nbsp;<script language="javascript">dateAvailableTo.writeControl(); dateAvailableTo.dateFormat="MM/dd/yyyy";</script>
			</td>
		  </tr>-->
		 
		   <tr>
			<td align="center" valign="top">&nbsp;</td>
			<td align="center" valign="top">&nbsp;</td>
		  </tr>
		  <tr>
			<td align="center" valign="top">&nbsp;
		  	<td align="left" valign="top"><input type="submit" value="Search" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="Cancel" onclick="window.location='boards.php'" /></td>
		  </tr>
		  <tr>
			<td align="center" valign="top">&nbsp;</td>
			<td align="center" valign="top">&nbsp;</td>
		  </tr>
		</table>
		</form>
	</div>
	<div id="fade" class="black_overlay" style="display:<? if($action=='BoardsSearch'){ echo 'block';} else { echo 'none'; } ?>;"></div>



<table width="1002" border="0" align="center" cellpadding="0" cellspacing="0">

  <tr>
    <td width="21" align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">
        <table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center" valign="top" class="top-header-bg">
                <table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top">
                        <? include_once("includes/top-menu.php"); ?>
                    </td>
                  </tr>
                  <tr>
                    <td align="center" valign="top"><table width="928" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="196" align="left" valign="top"><a href="boards.php"><img src="<?=HTTP_SERVER.DIR_WS_HTTP_FOLDER.DIR_IMAGES?>logo.jpg"  alt="Logo" width="196" height="32" border="0" title="Logo" /></a></td>
                        <td width="478" align="left" valign="top">&nbsp;</td>
                        <td width="254" align="right" valign="top" >
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="login-register-text"><a href="#"><strong><?=$_SESSION['user_login_name']?></strong></a> | <a href="logout.php"><strong>Logout</strong></a>				</tr>
                            </table>
                        </td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                   <td align="left" valign="top" class="caption-text">We Enable You to Sell More IT Faster by Providing Unique, Responsive and Actionable Sales Leads</td>
                  </tr>
                  <tr>
                    <td align="right" valign="top">
                        <table width="95%" height="33" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="81%" align="center" valign="middle"><span class="right-box-title-text"><?=$msg?></span></td>
                              
                              <td width="3%" align="right" valign="middle"><a href="#"><img src="images/search-icon.jpg" border="0" width="25" height="28"  alt="Search Contact" title="Search Contact" onclick="BoardsSearch('BoardsSearch');"  /></a></td>
                              <td width="5%" align="left" valign="middle" class="nav-text">Search</td>
                              <td align="left" valign="middle"><a href="#"><img src="images/folder-icon.jpg" border="0" width="22" height="22" alt="Directory" title="Directory" onclick="window.location='boards.php?action=Directory'"  /></a></td>
                              <td align="left" valign="middle" class="nav-text">Directory</td>
                              <td width="3%" align="right" valign="middle"><a href="#"><img src="<?=HTTP_SERVER.DIR_WS_HTTP_FOLDER.DIR_IMAGES?>add-icon.jpg" border="0" width="25" height="28" alt="Add Contact" title="Add Contact" onclick="window.location='boards.php?action=add'"  /></a></td>
                              <td width="8%" align="left" valign="middle" class="nav-text">Add New</td>
                            </tr>
                        </table>
                    </td>
                  </tr>
                </table>
            </td>
          </tr>
        </table>
    </td>
    <td width="21" align="left" valign="top">&nbsp;</td>
  </tr>
  
    <tr>
      <td align="left"  valign="top">&nbsp;</td>
      <td align="center" valign="top"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" valign="top"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td align="left" valign="middle" class="advance-search-page-heading-bg"><table width="960" border="0" align="left" cellpadding="0" cellspacing="0">
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle" class="press-release-page-title-text">Personal Boards : </td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><img src="<?=HTTP_SERVER.DIR_WS_HTTP_FOLDER.DIR_IMAGES?>specer.gif" width="1" height="10" alt="" title="" /></td>
                  </tr>
              
              </table></td>
            </tr>
          </table></td>
        </tr>
<? if($action=='Directory' || $action =='save' || $action=='SearchResult'){	?>	
        <tr>
          <td align="center" valign="top">
		  
		  <form name="topicform" id="topicform" method="post" action="boards.php?action=alldelete&p=<?=$p?>">
		  	<table width="100%" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="51" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-title-text">#</span></td>
				<td width="265" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Person Name</span> </td>
				<td width="315" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Boards Info </span> </td>
                <td width="169" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Date</span> </td>
                <td width="158" height="30" align="center" valign="middle" class="left-border"><div align="center"><span class="right-box-title-text">Action</span></div></td>
			  </tr>
			<?php
			
			if($total_data>0) {
				$i=1;
				while ($data_sql = com_db_fetch_array($exe_data)) {
				$adt = explode('-',$data_sql['add_date']);
				$add_date = date('m/d/Y',mktime(0,0,0,$adt[1],$adt[2],$adt[0]));
			?>          
			  <tr>
				<td height="30" align="center" valign="middle" class="right-border-left"><?=$i;?></td>
				<td height="30" align="left" valign="middle" class="right-border-text">&nbsp;<a href="boards.php?action=detailes&p=<?=$p?>&bID=<?=$data_sql['board_id'];?>"><?=com_db_output($data_sql['first_name'].' '.$data_sql['last_name'])?></a></td>
				<td height="30" align="left" valign="middle" class="right-border-text">&nbsp;<?=com_db_output($data_sql['board_info'])?></td>
                <td height="30" align="center" valign="middle" class="right-border">&nbsp;<?=$add_date;?></td>
				<td height="30" align="center" valign="middle" class="left-border">
					<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr> 
					   	<td width="50%" align="center" valign="middle" class="actionText"><a href="#"><img src="images/small-edit-icon.gif" width="16" height="16" alt="Edit" title="Edit" border="0" onclick="window.location='boards.php?&p=<?=$p;?>&bID=<?=$data_sql['board_id'];?>&action=edit'" /></a><br />
						  Edit</td>
						<td width="50%" align="center" valign="middle" class="actionText"><a href="#"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" title="Delete" border="0" onclick="confirm_del('<?=$data_sql['board_id'];?>','<?=$p;?>')" /></a><br />
						  Delete</td>
					  </tr>
					</table>
               </td>
         	</tr> 
			<?php
			$i++;
				}
			
			}
			?>     
         </table>
		  </form>
		  <br />
		  </td>
        </tr>
		
		<tr>
			<td align="left" valign="top" class="pagination-text">
			<?php echo number_pages($main_page, $p, $total_data, 8, $items_per_page,'&action=Directory&items_per_page='.$items_per_page);?>
			<br /><br />
	  		</td>
		</tr>
	
	<? }elseif($action=='add' || $action ==''){ ?>
		<tr>
          <td align="center" valign="top">
		  <script language="javascript" type="text/javascript">
			function chk_form_Add(){
				var cid=document.getElementById('personal_id').value;
				if(cid==''){
					alert("Please select personal name.");
					document.getElementById('personal_id').focus();
					return false;
				}
				var board=document.getElementById('board_info').value;
				if(board==''){
					alert("Please enter board info.");
					document.getElementById('board_info').focus();
					return false;
				}
			}
		</script>
		 
          <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" style="background-color:#CCC;height:30px;">
              <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">Boards Manager :: Add Personal Boards</td>
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="left" valign="top" class="right-border-box">
		 <!--start iner table  -->
		  <form name="frmDataAdd" id="frmDataAdd" method="post" action="boards.php?action=addsave" onsubmit="return  chk_form_Add();">
		  <table width="100%" align="left" cellpadding="5" cellspacing="5" border="0">
            <tr>
			  <td align="left">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
					<tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Personal Name:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="hidden" name="personal_id" id="personal_id" />
                        <input type="radio" name="person_option" id="person_option_old" checked="checked" value="Old" /><b>Old Person</b> &nbsp;&nbsp;<input type="radio" name="person_option" id="person_option_new" value="New" /><b>New Person</b><br />
                        <input type="text" name="first_last_name" id="first_last_name" size="30" value="Enter First, Middle & Last Name." onfocus=" if (this.value == 'Enter First, Middle & Last Name.') { this.value = ''; }" onblur="if (this.value == '') { this.value='Enter First, Middle & Last Name.';} " onkeyup="PersonalCompanyName('first_last_name');"/>
                        <div id="DivPersonalCompanyNameShow" style="display:none;"></div>
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Boards Info:</td>
                      <td width="75%" align="left" valign="top">
                       	<input type="text" name="board_info" id="board_info" size="30" value="" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Date:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="board_date" id="board_date" size="30" value="<?=$board_date?>" />&nbsp;<a href="javascript:NewCssCal('board_date','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Link:</td>
                      <td width="75%" align="left" valign="top">
                       	<input type="text" name="board_link" id="board_link" size="30" value="" />
                      </td>	
                    </tr>
                  </table>
              </td>	
			</tr>
            <tr>
            	<td align="center">
                	<table width="50%" border="0" cellpadding="4" cellspacing="4">
                    	<tr><td><input type="submit" value="Add Board" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="Cancel" onclick="window.location='boards.php?p=<?=$p;?>'" /></td></tr>
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
        </table>
		  
		  </td>
        </tr>
	<? }elseif($action=='edit'){ ?>
		<tr>
          <td align="center" valign="top">
          <script language="javascript" type="text/javascript">
			function chk_form(){
				var pid=document.getElementById('personal_id').value;
				if(pid==''){
					alert("Please select personal name.");
					document.getElementById('personal_id').focus();
					return false;
				}
				var board=document.getElementById('board_info').value;
				if(board==''){
					alert("Please enter board info.");
					document.getElementById('board_info').focus();
					return false;
				}
			
			}
			
			</script>		
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" style="background-color:#CCC;height:30px;">
              <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">Board Manager :: Edit Personal Board </td>
				  
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top"  class="right-bar-content-border-box"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="celter" valign="top">
		 <!--start iner table  -->
		<form name="frmDataEdit" id="frmDataEdit" method="post" action="boards.php?action=editsave&bID=<?=$bID;?>&p=<?=$p;?>" onsubmit="return  chk_form();">
		  <table width="100%" align="center" cellpadding="5" cellspacing="5" border="0">
			
            <tr>
			  <td align="left">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Personal Name:</td>
                      <td width="75%" align="left" valign="top">
                        <select name="personal_id" id="personal_id" style="width:206px;">
                        	<option value="">Select Personal Name</option>
                        	<?=selectComboBox("select personal_id,concat(first_name,' ',last_name) as name from ".TABLE_PERSONAL_MASTER." where status='0' order by first_name,last_name",$personal_id)?>
                        </select>
                      </td>	
                    </tr>
                    
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Board Info:</td>
                      <td width="75%" align="left" valign="top">
                       	<input type="text" name="board_info" id="board_info" size="30" value="<?=$board_info?>" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Date:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="board_date" id="board_date" size="30" value="<?=$board_date?>" />&nbsp;<a href="javascript:NewCssCal('board_date','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Link:</td>
                      <td width="75%" align="left" valign="top">
                       	<input type="text" name="board_link" id="board_link" size="30" value="<?=$board_link?>" />
                      </td>	
                    </tr>
                  </table>
              </td>	
			</tr>
           
            <tr>
            	<td align="center">
                	<table width="50%" border="0" cellpadding="4" cellspacing="4">
                    	<tr>
                        	<td width="17%"><input type="submit" value="Update Board Info" class="submitButton" /></td>
                            <td width="83%"><input type="button" class="submitButton" value="Cancel" onclick="window.location='boards.php?p=<?=$p;?>'" /></td>
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
        </table>
		  </td>
        </tr>
	
	<? }elseif($action=='detailes'){?>
		 <tr>
          <td align="center" valign="top">
		  
		  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" style="background-color:#CCC;height:30px;"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">Board Manager :: Personal Board Details </td>
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="left" valign="top" class="right-border">
		 <!--start iner table  -->
         	 
         	<table width="100%" align="center" cellpadding="5" cellspacing="5" border="0">
				<tr>
                  <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Personal Name:</td>
                  <td width="75%" align="left" valign="top" class="page-text"><?=$full_name?></td>	
                </tr>
                <tr>
                  <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Board Info:</td>
                  <td width="75%" align="left" valign="top" class="page-text"><?=$board_info?></td>	
                </tr>
                <tr>
                  <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Date:</td>
                  <td width="75%" align="left" valign="top" class="page-text"><?=$board_date?></td>	
                </tr>
                <tr>
                  <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Link:</td>
                  <td width="75%" align="left" valign="top" class="page-text"><?=$board_link?></td>	
                </tr>
			</table>
		 <!-- end inner table -->
		  </td>
		 </tr>
		 <tr>
            	<td align="center">
                	<table width="50%" border="0" cellpadding="4" cellspacing="4">
                    	<tr><td><input type="button" class="submitButton" value="Back" onclick="window.location='boards.php?p=<?=$p;?>'" /></td></tr>
                    </table>
                </td>
             </tr>
            </table></td>
		 </tr>
        </table>
		  
		  </td>
        </tr>
	<? } ?>
		
      </table></td>
      <td align="left"  valign="top">&nbsp;</td>
    </tr>

	<? include_once("includes/footer-menu.php"); ?>
    
    <tr>
      <td align="left"  valign="top">&nbsp;</td>
      <td align="left" valign="top">
        <table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td align="center" valign="top" class="copyright-text">Copyright &copy; 2010 CTOsOnTheMove. All rights reserved.</td>
          </tr>
          <tr>
            <td align="center" valign="top">&nbsp;</td>
          </tr>
        </table>
      </td>
      <td align="left"  valign="top">&nbsp;</td>
    </tr>
</table>

</body>
</html>
