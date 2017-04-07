<?php
require('../includes/configuration.php');
include('../includes/only_dataentry_include-top.php');

$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 20;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';

if($action == 'SearchResult'){
	
	
	//$company_id		= $_POST['search_company_id'];
	$company_name		= $_POST['search_company_name'];
	$job_title		= $_POST['search_job_title'];
	
	$search_qry='';
	/*
	if($company_id!=''){
		$search_qry .= " cji.company_id = '".$company_id."'";
	}
	*/
	if($company_name!=''){
		$search_qry .= " cm.company_name = '".$company_name."'";
	}
	
	if($job_title!=''){
		if($search_qry==''){
			$search_qry .= " cji.job_title like '".$job_title."%'";
		}else{
			$search_qry .= " and cji.job_title like '".$job_title."%'";
		}	
	}
	
	/*if($from_date!='' && strlen($from_date)==10 && $to_date !='' && strlen($to_date)==10){
		$fdt = explode('/',$from_date);
		$fdate = $fdt[2].'-'.$fdt[0].'-'.$fdt[1];
		$tdt = explode('/',$to_date);
		$tdate = $tdt[2].'-'.$tdt[0].'-'.$tdt[1];
		if($search_qry==''){
			$search_qry .= " add_date >= '".$fdate."' and add_date <='".$tdate."'";
		}else{
			$search_qry .= " and add_date >= '".$fdate."' and add_date <='".$tdate."'";
		}	
	}*/
	
	if($search_qry==''){
		$sql_query = "select cm.company_name,cji.* from " . TABLE_COMPANY_MASTER . " cm, ".TABLE_COMPANY_JOB_INFO." cji where cm.company_id=cji.company_id order by job_id desc";
	}else{
		$sql_query = "select cm.company_name,cji.* from " . TABLE_COMPANY_MASTER . " cm, ".TABLE_COMPANY_JOB_INFO." cji where (cm.company_id=cji.company_id) and ".$search_qry." order by job_id desc";
	}

}else{
		$sql_query = "select cm.company_name,cji.* from " . TABLE_COMPANY_MASTER . " cm, ".TABLE_COMPANY_JOB_INFO." cji where cm.company_id=cji.company_id order by job_id desc";
}		
/***************** FOR PAGIN ***********************/
$starting_point = $items_per_page * ($p - 1);
/****************** END PAGIN ***********************/
$main_page = 'job.php';

$exe_query=com_db_query($sql_query);
$num_rows=com_db_num_rows($exe_query);
$total_data = $num_rows;

/************ FOR PAGIN **************/
$sql_query .= " LIMIT $starting_point,$items_per_page";
$exe_data = com_db_query($sql_query);

$numRows = com_db_num_rows($exe_data);
/************ END ********************/


$jID = (isset($_GET['jID']) ? $_GET['jID'] : $select_data[0]);

    switch ($action) {
		
	  case 'delete':
	   		
			com_db_query("delete from " . TABLE_COMPANY_JOB_INFO . " where job_id = '" . $jID . "'");
		 	com_redirect("job.php?p=" . $p . "&msg=" . msg_encode("Company Job deleted successfully"));
		
		break;	
	  case 'edit':
     		
	   		$query_edit=com_db_query("select * from " . TABLE_COMPANY_JOB_INFO . " where job_id = '" . $jID . "'");
	  		$data_edit=com_db_fetch_array($query_edit);
			
			$company_id = com_db_output($data_edit['company_id']);
			$job_title = com_db_output($data_edit['job_title']);
			$description = preg_replace('/<br( )?(\/)?>/i', "\r", $data_edit['description']);
			$location = com_db_output($data_edit['location']);
			if($data_edit['post_date'] !='0000-00-00'){
				$ptdt = explode('-',$data_edit['post_date']);
				$post_date = $ptdt[1].'/'.$ptdt[2].'/'.$ptdt[0];
			}else{
				$post_date ='';
			}
		break;	
		
		case 'editsave':
			
			$company_id = com_db_input($_POST['company_id']);
			$job_title = com_db_input($_POST['job_title']);
			$rep   = array("\r\n", "\n","\r");
			$description = str_replace($rep,'<br />',$_POST['description']);
			$location = com_db_input($_POST['location']);
			$pst_date = explode('/',$_POST['post_date']);//mmddyyyy
			$post_date = $pst_date[2].'-'.$pst_date[0].'-'.$pst_date[1];
			$modify_date = date('Y-m-d');
			
			$query = "update " . TABLE_COMPANY_JOB_INFO . " set company_id = '" . $company_id ."', job_title = '".$job_title."', description = '".$description."', location = '".$location."', post_date = '".$post_date."',
					modify_date = '".$modify_date."' where job_id = '" . $jID . "'";
			
			com_db_query($query);
	  		com_redirect("job.php?p=". $p ."&jID=" . $jID . "&msg=" . msg_encode("Company job update successfully"));
		 
		break;		
		
	  
		
	case 'addsave':
			
			$company_id = com_db_input($_POST['company_id']);
			$job_title = com_db_input($_POST['job_title']);
			$rep   = array("\r\n", "\n","\r");
			$description = str_replace($rep,'<br />',$_POST['description']);
			$location = com_db_input($_POST['location']);
			$pst_date = explode('/',$_POST['post_date']);//mmddyyyy
			$post_date = $pst_date[2].'-'.$pst_date[0].'-'.$pst_date[1];
			$status = '0';
			$add_date = date('Y-m-d');
			
			$query = "insert into " . TABLE_COMPANY_JOB_INFO . "
			(company_id, job_title, description, location, post_date, add_date, status) 
			values ('$company_id', '$job_title', '$description', '$location', '$post_date','$add_date','$status')";
			com_db_query($query);
	  		com_redirect("job.php?p=" . $p . "&msg=" . msg_encode("Company New job added successfully"));
		 
		break;	
		
	case 'detailes':
			$query_edit ="select c.company_name,cji.* from " 
							.TABLE_COMPANY_MASTER. " as c, " 
							.TABLE_COMPANY_JOB_INFO." as cji														
							where c.company_id=cji.company_id and cji.job_id = '" . $jID . "'";
			
			$query_edit_result=com_db_query($query_edit);
	  		$data_edit=com_db_fetch_array($query_edit_result);
			
			$company_name = com_db_output($data_edit['company_name']);
			$job_title = com_db_output($data_edit['job_title']);
			$description = com_db_output($data_edit['description']);
			$location = com_db_output($data_edit['location']);
			if($data_edit['post_date'] !='0000-00-00'){
				$ptdt = explode('-',$data_edit['post_date']);
				$post_date = $ptdt[1].'/'.$ptdt[2].'/'.$ptdt[0];
			}else{
				$post_date ='';
			}
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
<link rel="shortcut icon" href="../images/favicon.jpg" type="image/x-icon" />
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="only-dataentry.js"></script>
  
<script type="text/javascript" src="../js/datetimepicker_css.js" language="javascript"></script>  
<script type="text/javascript">

function JobSearch(){
	window.location ='job.php?action=JobSearch';
}
function confirm_del(nid,p){
	var agree=confirm("Job will be deleted. \n Do you want to continue?");
	if (agree)
		window.location = "job.php?jID=" + nid + "&p=" + p + "&action=delete";
	else
		window.location = "job.php?jID=" + nid + "&p=" + p ;
}
</script>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="selectuser.js" language="javascript"></script>
</head>
<body>
<div id="light" class="white_content" style="display:<? if($action=='JobSearch'){ echo 'block';} else { echo 'none'; } ?>; height:auto;">
		<!--<div id="spiffycalendar" class="text"></div>
		<link rel="stylesheet" type="text/css" href="includes/javascript/spiffyCal/spiffyCal_v2_1.css">
		<script language="JavaScript" src="includes/javascript/spiffyCal/spiffyCal_v2_1.js"></script>
		<script language="javascript">
		  var dateAvailableFrom = new ctlSpiffyCalendarBox("dateAvailableFrom", "frmSearch", "from_date","btnDate1","",scBTNMODE_CUSTOMBLUE);
		  var dateAvailableTo = new ctlSpiffyCalendarBox("dateAvailableTo", "frmSearch", "to_date","btnDate2","",scBTNMODE_CUSTOMBLUE);	
		</script>-->
		<form name="frmSearch" id="frmSearch" method="post" action="job.php?action=SearchResult">
		<table width="90%" border="0" align="center" cellpadding="1" cellspacing="1">
		  <tr>
			<td align="left" colspan="2" valign="top"><img src="images/specer.gif" width="1" height="50" alt="" title="" /> </td>
		  </tr>
		  <tr>
			<td align="left" valign="top">Company Name:</td>
			<td align="left" valign="top">
				<!--
            	<select name="search_company_id" id="search_company_id" style="width:206px;">
                    <option value="">Select Company Name</option>
                    <? //=selectComboBox("select company_id,company_name from ".TABLE_COMPANY_MASTER." where status='0' order by company_name","")?>
                </select>
				-->
					<input name="search_company_name" id="search_company_name" style="width:206px;" />
              </td>
		  </tr>
          <tr>
			<td align="center" valign="top">&nbsp;</td>
			<td align="center" valign="top">&nbsp;</td>
		  </tr>
		  <tr>
			<td align="left" valign="top">Job Title:</td>
			<td align="left" valign="top"><input name="search_job_title" id="search_job_title" style="width:206px;" /></td>
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
		  	<td align="left" valign="top"><input type="submit" value="Search" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="Cancel" onclick="window.location='job.php'" /></td>
		  </tr>
		  <tr>
			<td align="center" valign="top">&nbsp;</td>
			<td align="center" valign="top">&nbsp;</td>
		  </tr>
		</table>
		</form>
	</div>
	<div id="fade" class="black_overlay" style="display:<? if($action=='JobSearch'){ echo 'block';} else { echo 'none'; } ?>;"></div>



<table width="1002" border="0" align="center" cellpadding="0" cellspacing="0">

  <tr>
    <td width="21" align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">
        <table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center" valign="top" class="top-header-bg">
                <table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><!--<img src="<?=HTTP_SERVER.DIR_WS_HTTP_FOLDER.DIR_IMAGES?>specer.gif" width="1" height="38" alt="" title="" />-->
                        <? include_once("includes/top-menu.php"); ?>
                    </td>
                  </tr>
                  <tr>
                    <td align="center" valign="top"><table width="928" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="196" align="left" valign="top"><a href="job.php"><img src="<?=HTTP_SERVER.DIR_WS_HTTP_FOLDER.DIR_IMAGES?>logo.jpg"  alt="Logo" width="196" height="32" border="0" title="Logo" /></a></td>
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
                              
                              <td width="3%" align="right" valign="middle"><a href="#"><img src="images/search-icon.jpg" border="0" width="25" height="28"  alt="Search Contact" title="Search Contact" onclick="JobSearch('JobSearch');"  /></a></td>
                              <td width="5%" align="left" valign="middle" class="nav-text">Search</td>
                              <td align="left" valign="middle"><a href="#"><img src="images/folder-icon.jpg" border="0" width="22" height="22" alt="Directory" title="Directory" onclick="window.location='job.php?action=Directory'"  /></a></td>
                              <td align="left" valign="middle" class="nav-text">Directory</td>
                              <td width="3%" align="right" valign="middle"><a href="#"><img src="<?=HTTP_SERVER.DIR_WS_HTTP_FOLDER.DIR_IMAGES?>add-icon.jpg" border="0" width="25" height="28" alt="Add Contact" title="Add Contact" onclick="window.location='job.php?action=add'"  /></a></td>
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
                    <td align="left" valign="middle" class="press-release-page-title-text">Company Jobs : </td>
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
		  
		  <form name="topicform" id="topicform" method="post" action="job.php?action=alldelete&p=<?=$p?>">
		  	<table width="100%" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="34" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-title-text">#</span></td>
				<td width="186" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Company Name</span> </td>
				<td width="221" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Job Title </span> </td>
                <td width="175" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Location</span> </td>
				<td width="115" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Post Date</span> </td>
                <td width="103" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Date</span> </td>
                <td width="124" height="30" align="center" valign="middle" class="left-border"><div align="center"><span class="right-box-title-text">Action</span></div></td>
			  </tr>
			<?php
			
			if($total_data>0) {
				$i=1;
				while ($data_sql = com_db_fetch_array($exe_data)) {
				$pdt = explode('-',$data_sql['post_date']);
				$post_date = date('m/d/Y',mktime(0,0,0,$pdt[1],$pdt[2],$pdt[0]));	
				$adt = explode('-',$data_sql['add_date']);
				$add_date = date('m/d/Y',mktime(0,0,0,$adt[1],$adt[2],$adt[0]));
				$status = $data_sql['status'];
			?>          
			  <tr>
				<td height="30" align="center" valign="middle" class="right-border-left"><?=$i;?></td>
				<td height="30" align="left" valign="middle" class="right-border-text">&nbsp;<a href="job.php?action=detailes&p=<?=$p?>&jID=<?=$data_sql['job_id'];?>"><?=com_db_output($data_sql['company_name'])?></a></td>
				<td height="30" align="left" valign="middle" class="right-border-text">&nbsp;<?=com_db_output($data_sql['job_title'])?></td>
                <td height="30" align="left" valign="middle" class="right-border-text">&nbsp;<?=com_db_output($data_sql['location'])?></td>
				<td height="30" align="center" valign="middle" class="right-border">&nbsp;<?=$post_date;?></td>
                <td height="30" align="center" valign="middle" class="right-border">&nbsp;<?=$add_date;?></td>
				<td height="30" align="center" valign="middle" class="left-border">
					<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr> 
					   	<td width="50%" align="center" valign="middle" class="actionText"><a href="#"><img src="images/small-edit-icon.gif" width="16" height="16" alt="Edit" title="Edit" border="0" onclick="window.location='job.php?&p=<?=$p;?>&jID=<?=$data_sql['job_id'];?>&action=edit'" /></a><br />
						  Edit</td>
						<td width="50%" align="center" valign="middle" class="actionText"><a href="#"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" title="Delete" border="0" onclick="confirm_del('<?=$data_sql['job_id'];?>','<?=$p;?>')" /></a><br />
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
				var cid=document.getElementById('company_id').value;
				if(cid==''){
					alert("Please select company name.");
					document.getElementById('company_id').focus();
					return false;
				}
				var title=document.getElementById('job_title').value;
				if(title==''){
					alert("Please enter title.");
					document.getElementById('job_title').focus();
					return false;
				}
			}
		</script>
		 
          <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" style="background-color:#CCC;height:30px;">
              <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">Job Manager :: Add Company Job</td>
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="left" valign="top" class="right-border-box">
		 <!--start iner table  -->
		  <form name="frmDataAdd" id="frmDataAdd" method="post" action="job.php?action=addsave">
		  <table width="95%" align="left" cellpadding="5" cellspacing="5" border="0">
            <tr>
			  <td align="left">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
					<tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Company Name:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="hidden" name="company_id" id="company_id" />
                        <input type="text" name="company_url" id="company_url" size="30" value="Enter Company url" onfocus=" if (this.value == 'Enter Company url') { this.value = ''; }" onblur="if (this.value == '') { this.value='Enter Company url';} " onkeyup="CompanyName('company_url');"/>
                        <div id="DivCompanyNameShow" class="PersonalCompanyList"></div>
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Job Title:</td>
                      <td width="75%" align="left" valign="top">
                       	<input type="text" name="job_title" id="job_title" size="30" value="" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Posted Date:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="post_date" id="post_date" size="30" value="<?=$post_date;?>" />
						<a href="javascript:NewCssCal('post_date','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a>
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Location:</td>
                      <td width="75%" align="left" valign="top">
                       	<input type="text" name="location" id="location" size="30" value="" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Description:</td>
                      <td width="75%" align="left" valign="top">
                       	<textarea name="description" id="description" cols="23" rows="5"></textarea>
                      </td>	
                    </tr>
                  </table>
              </td>	
			</tr>
            <tr>
            	<td align="center">
                	<table width="50%" border="0" cellpadding="4" cellspacing="4">
                    	<tr><td><input type="submit" value="Add Job" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='job.php?p=<?=$p;?>'" /></td></tr>
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
				var cid=document.getElementById('company_id').value;
				if(cid==''){
					alert("Please select company name.");
					document.getElementById('company_id').focus();
					return false;
				}
				var title=document.getElementById('job_title').value;
				if(title==''){
					alert("Please enter title.");
					document.getElementById('job_title').focus();
					return false;
				}
			
			}
			
			</script>		
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" style="background-color:#CCC;height:30px;">
              <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">Job Manager :: Edit Company Job </td>
				  
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top"  class="right-bar-content-border-box"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="celter" valign="top">
		 <!--start iner table  -->
		<form name="frmDataEdit" id="frmDataEdit" method="post" action="job.php?action=editsave&jID=<?=$jID;?>&p=<?=$p;?>">
		  <table width="95%" align="center" cellpadding="5" cellspacing="5" border="0">
			
            <tr>
			  <td align="left">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Company Name:</td>
                      <td width="75%" align="left" valign="top">
                        <select name="company_id" id="company_id" style="width:206px;">
                        	<option value="">Select Company Name</option>
                        	<?=selectComboBox("select company_id,company_name from ".TABLE_COMPANY_MASTER." where status='0' order by company_name",$company_id)?>
                        </select>
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Job Title:</td>
                      <td width="75%" align="left" valign="top">
                       	<input type="text" name="job_title" id="job_title" size="30" value="<?=$job_title?>" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Posted Date:</td>
                      <td width="75%" align="left" valign="top">
                       	<input type="text" name="post_date" id="post_date" size="30" value="<?=$post_date?>" />
                        <a href="javascript:NewCssCal('post_date','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a>
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Location:</td>
                      <td width="75%" align="left" valign="top">
                       	<input type="text" name="location" id="location" size="30" value="<?=$location?>" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Description:</td>
                      <td width="75%" align="left" valign="top">
                       	<textarea name="description" id="description" cols="23" rows="5"><?=$description?></textarea>
                      </td>	
                    </tr>
                  </table>
              </td>	
			</tr>
           
            <tr>
            	<td align="center">
                	<table width="50%" border="0" cellpadding="4" cellspacing="4">
                    	<tr>
                        	<td width="17%"><input type="submit" value="Update Job" class="submitButton" /></td>
                            <td width="83%"><input type="button" class="submitButton" value="Cancel" onclick="window.location='job.php?p=<?=$p;?>'" /></td>
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
                  <td width="50%" align="left" valign="middle" class="heading-text">Job Manager :: Job Details </td>
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="left" valign="top" class="right-border">
		 <!--start iner table  -->
         	 
         	<table width="95%" align="center" cellpadding="5" cellspacing="5" border="0">
				<tr>
                  <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Company Name:</td>
                  <td width="75%" align="left" valign="top" class="page-text"><?=$company_name?></td>	
                </tr>
                <tr>
                  <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Job Title:</td>
                  <td width="75%" align="left" valign="top" class="page-text"><?=$job_title?></td>	
                </tr>
                <tr>
                  <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Posted Date:</td>
                  <td width="75%" align="left" valign="top" class="page-text"><?=$post_date?></td>	
                </tr>
                <tr>
                  <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Location:</td>
                  <td width="75%" align="left" valign="top" class="page-text"><?=$location?></td>	
                </tr>
                <tr>
                  <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Description:</td>
                  <td width="75%" align="left" valign="top" class="page-text"><?=$description?></td>	
                </tr>
			</table>
		 <!-- end inner table -->
		  </td>
		 </tr>
		 <tr>
            	<td align="center">
                	<table width="50%" border="0" cellpadding="4" cellspacing="4">
                    	<tr><td><input type="button" class="submitButton" value="Back" onclick="window.location='job.php?p=<?=$p;?>'" /></td></tr>
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
