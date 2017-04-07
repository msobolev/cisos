<?php
require('../includes/configuration.php');
include('../includes/only_dataentry_include-top.php');

$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 20;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';

if($action == 'SearchResult'){

	$title		= $_POST['search_title'];
	
	$search_qry =' where 1 = 1 and ';
	if($title!=''){
		$search_qry .= " event_name like '".$title."%'";
	}
		$sql_query = "select * from " . TABLE_EVENTS . " $search_qry order by event_id desc";

}else{ 
		//$sql_query = "select pm.first_name,pm.last_name,pp.* from " . TABLE_PERSONAL_MASTER . " pm, ".TABLE_PERSONAL_PUBLICATION." pp where pm.personal_id=pp.personal_id order by publication_id desc";
		$sql_query = "SELECT * from ".TABLE_EVENTS;
}
//echo $sql_query;		
/***************** FOR PAGIN ***********************/
$starting_point = $items_per_page * ($p - 1);
/****************** END PAGIN ***********************/
$main_page = 'events.php';

$exe_query=com_db_query($sql_query);
$num_rows=com_db_num_rows($exe_query);
$total_data = $num_rows;

/************ FOR PAGIN **************/
$sql_query .= " LIMIT $starting_point,$items_per_page";
$exe_data = com_db_query($sql_query);

$numRows = com_db_num_rows($exe_data);
/************ END ********************/


$pID = (isset($_GET['pID']) ? $_GET['pID'] : $select_data[0]);

    switch ($action) {
		
	  case 'delete':
	   		
			com_db_query("delete from " . TABLE_EVENTS . " where event_id = '" . $pID . "'");
		 	com_redirect("events.php?p=" . $p . "&msg=" . msg_encode("Event deleted successfully"));
		
		break;	
	  case 'edit':
     		
	   		$query_edit=com_db_query("select * from " . TABLE_EVENTS . " where event_id = '" . $pID . "'");
	  		$data_edit=com_db_fetch_array($query_edit);
			
			$event_id = com_db_output($data_edit['event_id']);
			$event_title = com_db_output($data_edit['event_name']);
			
			if($data_edit['event_start_date'] == '0000-00-00')
			{
				$event_start_date = "";
			}
			else
			{
				$pdt = explode('-',$data_edit['event_start_date']);
				$event_start_date = 	$pdt[1].'/'.$pdt[2].'/'.$pdt[0];
			}
			
			$event_location = com_db_output($data_edit['event_location']);
			$event_link = com_db_output($data_edit['event_source']);
			$event_logo = com_db_output($data_edit['event_logo']);
			$demo_event = com_db_output($data_edit['demo_event']);
			
		break;	
		
		case 'editsave':
			//echo "<pre>POST: ";	print_r($_POST);	echo "</pre>";
			$personal_id = com_db_input($_POST['personal_id']);
			$title = com_db_input($_POST['title']);
			$pdt = explode('/',$_POST['event_date']);//mmddyyyy
			$event_date = $pdt[2].'-'.$pdt[0].'-'.$pdt[1];
			$location = com_db_input($_POST['event_location']);
			$link = com_db_input($_POST['event_link']);
			//$demo_event = 0;
			//if(isset($_POST['demo_event']) && $_POST['demo_event'] != '')
			$demo_event = $_POST['demo_event'];
			if($demo_event == 'on')
				$demo_event = 1;
				
			
			
			$query = "update " . TABLE_EVENTS . " set event_location = '" . $location ."', event_name = '".$title."',event_start_date='".$event_date."',event_source='".$link."',demo_event='".$demo_event."' where event_id = '" . $pID . "'";
			//echo "<br>Update Q: ".$query;
			//die();
			$insert_id = $pID;
			$image = $_FILES['image']['tmp_name'];
			  
			if($image!=''){
				if(is_uploaded_file($image)){
					$org_img = $_FILES['image']['name'];
					$exp_file = explode("." , $org_img);
					$get_ext = $exp_file[count($exp_file) - 1];
					if(strtolower($get_ext)=="jpg" || strtolower($get_ext)=="gif" || strtolower($get_ext)=="jpeg" || strtolower($get_ext)=="png"){
						$new_exp_file = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''),$exp_file[0]);
						$org_image_name = $new_exp_file.'-'.time().'.'.$get_ext;
						$destination_image = '../event_photo/org/' . $org_image_name;
						if(move_uploaded_file($image , $destination_image)){
							$thumb_image='../event_photo/thumb/' . $org_image_name;
							make_thumb($destination_image, $thumb_image,200,200);
							
							$small_image='../event_photo/small/' . $org_image_name;
							make_thumb($destination_image, $small_image,80,80);
							
							$query = "UPDATE " . TABLE_EVENTS . " SET event_logo = '" . $org_image_name . "' WHERE event_id = '" . $pID ."'";
							com_db_query($query);
						}
					}	
				}	
			}
			com_db_query($query);
	  		com_redirect("events.php?p=". $p ."&pID=" . $pID . "&msg=" . msg_encode("Event update successfully"));
		 
		break;		
		
	  
		
	case 'addsave':
			
			
			$name = com_db_input($_POST['name']);
			$pdt = explode('/',$_POST['event_date']);//mmddyyyy
			$event_start_date = $pdt[2].'-'.$pdt[0].'-'.$pdt[1];
			$location = com_db_input($_POST['event_location']);
			$link = com_db_input($_POST['event_link']);
			$status = '0';
			$add_date = date('Y-m-d');
			$demo_event = com_db_input($_POST['demo_event']);
			
			$query = "insert into " . TABLE_EVENTS . "
			(event_name, event_start_date,event_location,event_source, add_date, status,demo_event) 
			values ('$name','$event_start_date','$location','$link','$add_date','$status','$demo_event')";
			com_db_query($query);
			
			
			$insert_id = com_db_insert_id();
			$image = $_FILES['image']['tmp_name'];
			
			if($image!=''){ 
				if(is_uploaded_file($image)){ echo "<br>Line 117";
					$org_img = $_FILES['image']['name'];
					$exp_file = explode("." , $org_img);
					$get_ext = $exp_file[count($exp_file) - 1];
					if(strtolower($get_ext)=="jpg" || strtolower($get_ext)=="gif" || strtolower($get_ext)=="jpeg" || strtolower($get_ext)=="png"){
						$new_exp_file = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''),$exp_file[0]);
						$org_image_name = $new_exp_file.'-'.time().'.'.$get_ext;
						$destination_image = '../event_photo/org/' . $org_image_name;
						if(move_uploaded_file($image , $destination_image)){
							$thumb_image='../event_photo/thumb/' . $org_image_name;
							make_thumb($destination_image, $thumb_image,200,200);
							
							$small_image='../event_photo/small/' . $org_image_name;
							make_thumb($destination_image, $small_image,80,80);
							
							$query = "UPDATE " . TABLE_EVENTS . " SET event_logo = '" . $org_image_name . "' WHERE event_id = '" . $insert_id ."'";
							com_db_query($query);
						}
					}	
				}	
			}
			
	  		com_redirect("events.php?p=" . $p . "&msg=" . msg_encode("Event added successfully"));
		 
		break;	
		
	case 'details':
		
			$query_edit ="select * from ".TABLE_EVENTS." where event_id = '" . $pID . "'";
			
			$query_edit_result=com_db_query($query_edit);
	  		$data_edit=com_db_fetch_array($query_edit_result);
			
			//$title = com_db_output($data_edit['title']);
			$title = com_db_output($data_edit['event_name']);
			$pdt = explode('-',$data_edit['event_start_date']);
			$event_date = 	$pdt[1].'/'.$pdt[2].'/'.$pdt[0];
			$location = com_db_input($data_edit['event_location']);
			$link = com_db_output($data_edit['event_source']);
			$event_logo = com_db_output($data_edit['event_logo']);
			
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
	window.location ='events.php?action=BoardsSearch';
}
function confirm_del(nid,p){
	var agree=confirm("Event will be deleted. \n Do you want to continue?");
	if (agree)
	{
		
		window.location = "events.php?pID=" + nid + "&p=" + p + "&action=delete";
	}	
	else
	{
		window.location = "events.php?pID=" + nid + "&p=" + p ;
	}	
}

</script>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="selectuser.js" language="javascript"></script>
</head>
<body>




<div id="light" class="white_content" style="display:<? if($action=='BoardsSearch'){ echo 'block';} else { echo 'none'; } ?>; height:auto;">


		<form name="frmSearch" id="frmSearch" method="post" action="events.php?action=SearchResult">
		<table width="90%" border="0" align="center" cellpadding="1" cellspacing="1">
		  <tr>
			<td align="left" colspan="2" valign="top"><img src="images/specer.gif" width="1" height="50" alt="" title="" /> </td>
		  </tr>
		  
		  <tr>
			<td align="left" valign="top">Title:</td>
			<td align="left" valign="top"><input name="search_title" id="search_title" size="35" /></td>
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
		  	<td align="left" valign="top"><input type="submit" value="Search" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="Cancel" onclick="window.location='events.php'" /></td>
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
                        <td width="196" align="left" valign="top"><a href="events.php"><img src="<?=HTTP_SERVER.DIR_WS_HTTP_FOLDER.DIR_IMAGES?>logo.jpg"  alt="Logo" width="196" height="32" border="0" title="Logo" /></a></td>
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
                              <td align="left" valign="middle"><a href="#"><img src="images/folder-icon.jpg" border="0" width="22" height="22" alt="Directory" title="Directory" onclick="window.location='events.php?action=Directory'"  /></a></td>
                              <td align="left" valign="middle" class="nav-text">Directory</td>
                              <td width="3%" align="right" valign="middle"><a href="#"><img src="<?=HTTP_SERVER.DIR_WS_HTTP_FOLDER.DIR_IMAGES?>add-icon.jpg" border="0" width="25" height="28" alt="Add Contact" title="Add Contact" onclick="window.location='events.php?action=add'"  /></a></td>
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
                    <td align="left" valign="middle" class="press-release-page-title-text">Event : </td>
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
		  
		  <form name="topicform" id="topicform" method="post" action="events.php?action=alldelete&p=<?=$p?>">
		  	<table width="100%" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="51" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-title-text">#</span></td>
				<td width="265" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Event Name</span> </td>
				<td width="315" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Location</span> </td>
                <td width="169" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Start Date</span> </td>
                <td width="158" height="30" align="center" valign="middle" class="left-border"><div align="center"><span class="right-box-title-text">Action</span></div></td>
			  </tr>
			<?php
			
			if($total_data>0) {
				$i=1;
				while ($data_sql = com_db_fetch_array($exe_data)) {
				//echo "<br>adt: ".$data_sql['event_start_date'];
				if($data_sql['event_start_date'] == '0000-00-00')
				{
					$start_date = "";
				}
				else
				{
					$adt = explode('-',$data_sql['event_start_date']);
					$start_date = date('m/d/Y',mktime(0,0,0,$adt[1],$adt[2],$adt[0]));
				}	
			?>          
			  <tr>
				<td height="30" align="center" valign="middle" class="right-border-left"><?=$i;?></td>
				<td height="30" align="left" valign="middle" class="right-border-text">&nbsp;<a href="events.php?action=details&p=<?=$p?>&pID=<?=$data_sql['event_id'];?>"><?=$data_sql['event_name'];?></a></td>
				<td height="30" align="left" valign="middle" class="right-border-text">&nbsp;<?=com_db_output($data_sql['event_location'])?></td>
                <td height="30" align="center" valign="middle" class="right-border">&nbsp;<?=$start_date;?></td>
				<td height="30" align="center" valign="middle" class="left-border">
					<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr> 
					   	<td width="50%" align="center" valign="middle" class="actionText"><a href="#"><img src="images/small-edit-icon.gif" width="16" height="16" alt="Edit" title="Edit" border="0" onclick="window.location='events.php?&p=<?=$p;?>&pID=<?=$data_sql['event_id'];?>&action=edit'" /></a><br />
						  Edit</td>
						<td width="50%" align="center" valign="middle" class="actionText"><a href="#"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" title="Delete" border="0" onclick="confirm_del('<?=$data_sql['event_id'];?>','<?=$p;?>')" /></a><br />
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
				//var cid=document.getElementById('personal_id').value;
				/*
				if(cid==''){
					alert("Please select personal name.");
					document.getElementById('personal_id').focus();
					return false;
				}
				*/
				var name = document.getElementById('name').value;
				if(name == ''){
					alert("Please enter name");
					document.getElementById('name').focus();
					return false;
				}
			}
		</script>
		 
          <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" style="background-color:#CCC;height:30px;">
              <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="left" valign="middle" class="heading-text">Event Manager :: Add Event</td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="left" valign="top" class="right-border-box">
		 <!--start iner table  -->
		 
		 <?PHP
		// if($_GET['e'] == 1)
		// {
		 ?>
		 
		  <form name="frmDataAdd" id="frmDataAdd" method="post" action="events.php?action=addsave" enctype="multipart/form-data" onsubmit="return  chk_form_Add();">
		  <table width="100%" align="left" cellpadding="5" cellspacing="5" border="0">
            <tr>
			  <td align="left">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
					
					<tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Name:</td>
                      <td width="75%" align="left" valign="top">
                       	<input type="text" name="name" id="name" size="30" value="" />
                      </td>	
                    </tr>	
					
					
					<tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Start Date:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="event_date" id="event_date" size="30" value="<?=$publication_date?>" />&nbsp;<a href="javascript:NewCssCal('event_date','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a></td>	
                    </tr>
					
					
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Location:</td>
                      <td width="75%" align="left" valign="top">
                       	<input type="text" name="event_location" id="event_location" size="30" value="" />
                      </td>	
                    </tr>
                    
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Link:</td>
                      <td width="75%" align="left" valign="top">
                       	<input type="text" name="event_link" id="event_link" size="30" value="" />
                      </td>	
                    </tr>
					
					
					<tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Event Logo:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="file" name="image" id="image" /> 
						&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="demo_event" id="demo_event" value="1" <? if ($demo_event==1){echo 'checked="checked"';} ?> /> Add to demo
                      </td>	
                    </tr>
					
                  </table>
              </td>	
			</tr>
            <tr>
            	<td align="center">
                	<table width="50%" border="0" cellpadding="4" cellspacing="4">
                    	<tr><td><input type="submit" value="Add Event" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="Cancel" onclick="window.location='events.php?p=<?=$p;?>'" /></td></tr>
                    </table>
                </td>
             </tr>
            
			</table>
		  </form>
		  
		  <?PHP
		  //}
		  if(1 == 2)
		  {
		  ?>
		  
			<table width="100%" align="left" cellpadding="5" cellspacing="5" border="0">
            <tr>
			  <td align="left"><h2>Coming Soon</h2></td>
			 </tr>
			</table>	
		  
		  
		  <?PHP
		  }
		  ?>
		  
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
				//var pid=document.getElementById('personal_id').value;
				/*
				if(pid==''){
					alert("Please select event name.");
					document.getElementById('personal_id').focus();
					return false;
				}
				*/
				var title=document.getElementById('title').value;
				if(title==''){
					alert("Please enter event name");
					document.getElementById('title').focus();
					return false;
				}
			
			}
			
			</script>		
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" style="background-color:#CCC;height:30px;">
              <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="left" valign="middle" class="heading-text">Event Manager :: Edit Event </td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top"  class="right-bar-content-border-box"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="celter" valign="top">
		 <!--start iner table  -->
		<form name="frmDataEdit" id="frmDataEdit" method="post" action="events.php?action=editsave&pID=<?=$pID;?>&p=<?=$p;?>" enctype="multipart/form-data" onsubmit="return  chk_form();">
		  <table width="100%" align="center" cellpadding="5" cellspacing="5" border="0">
			
            <tr>
			  <td align="left">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    
                    
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Name:</td>
                      <td width="75%" align="left" valign="top">
                       	<input type="text" name="title" id="title" size="30" value="<?=$event_title?>" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Start Date:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="event_date" id="event_date" size="30" value="<?=$event_start_date?>" />&nbsp;<a href="javascript:NewCssCal('event_date','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a></td>	
                    </tr>
					
					
					<tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Location:</td>
                      <td width="75%" align="left" valign="top">
                       	<input type="text" name="event_location" id="event_location" size="30" value="<?=$event_location?>" />
                      </td>	
                    </tr>
					
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Link:</td>
                      <td width="75%" align="left" valign="top">
                       	<input type="text" name="event_link" id="event_link" size="30" value="<?=$event_link?>" />
                      </td>	
                    </tr>
					
					<tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Event Logo:</td>
                      <td width="75%" align="left" valign="top">
					  <?PHP
					  if($event_logo != '')
					  {
					  ?>
                       	<img src="../event_photo/small/<?=$event_logo?>" height="80" width="80" /><br />
					<?PHP
					}
					?>					
						<input type="file" name="image" id="image" />
						&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="demo_event" id="demo_event" <? if ($demo_event==1){echo 'checked="checked"';} ?> /> Add to demo
                      </td>	
					  
					  
                    </tr>
					
					
                   
                  </table>
              </td>	
			</tr>
           
            <tr>
            	<td align="center">
                	<table width="50%" border="0" cellpadding="4" cellspacing="4">
                    	<tr>
                        	<td width="17%"><input type="submit" value="Update Event" class="submitButton" /></td>
                            <td width="83%"><input type="button" class="submitButton" value="Cancel" onclick="window.location='events.php?p=<?=$p;?>'" /></td>
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
	
	<? }elseif($action=='details'){?>
		 <tr>
          <td align="center" valign="top">
		  
		  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" style="background-color:#CCC;height:30px;"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="left" valign="middle" class="heading-text">Event Manager :: Event Details </td>
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
                  <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Name:</td>
                  <td width="75%" align="left" valign="top" class="page-text"><?=$title?></td>	
                </tr>
                
                <tr>
                  <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Start Date:</td>
                  <td width="75%" align="left" valign="top" class="page-text"><?=$event_date?></td>	
                </tr>
				
				<tr>
                  <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Location:</td>
                  <td width="75%" align="left" valign="top" class="page-text"><?=$location?></td>	
                </tr>
				
				
                <tr>
                  <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Link:</td>
                  <td width="75%" align="left" valign="top" class="page-text"><?=$link?></td>	
                </tr>
				
				<tr>
                  <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Event Logo:</td>
                  <td width="75%" align="left" valign="top" class="page-text">
				  <?PHP
				  if($event_logo != '')
				  {
				  ?>
					<img src="../event_photo/small/<?=$event_logo?>" height="80" width="80" />
				<?PHP
				}
				?>
				<!-- &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="demo_event" id="demo_event" value="1" <? if ($demo_event==1){echo 'checked="checked"';} ?> /> Add to demo	-->			 
				  </td>	
                </tr>
				
				
			</table>
		 <!-- end inner table -->
		  </td>
		 </tr>
		 <tr>
            	<td align="center">
                	<table width="50%" border="0" cellpadding="4" cellspacing="4">
                    	<tr><td><input type="button" class="submitButton" value="Back" onclick="window.location='events.php?p=<?=$p;?>'" /></td></tr>
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
