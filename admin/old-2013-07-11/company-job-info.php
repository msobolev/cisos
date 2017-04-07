<?php
require('includes/include_top.php');

$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 20;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';

if($action == 'CompanySearchResult'){
	
	$company_id	= $_POST['search_company_id'];
	$job_title	= $_POST['search_job_title'];
	$from_date	= $_POST['from_date'];
	$to_date 	= $_POST['to_date'];
	
	$search_qry='';
	if($company_id!=''){
		$search_qry .= " cji.company_id = '".$company_id."'";
	}
	if($job_title!=''){
		if($search_qry==''){
			$search_qry .= " cji.job_title = '".$job_title."'";
		}else{
			$search_qry .= " and cji.job_title = '".$job_title."'";
		}	
	}
	
	if($from_date!='' && strlen($from_date)==10 && $to_date !='' && strlen($to_date)==10){
		$fdt = explode('/',$from_date);
		$fdate = $fdt[2].'-'.$fdt[0].'-'.$fdt[1];
		$tdt = explode('/',$to_date);
		$tdate = $tdt[2].'-'.$tdt[0].'-'.$tdt[1];
		if($search_qry==''){
			$search_qry .= " cji.post_date >= '".$fdate."' and cji.post_date <='".$tdate."'";
		}else{
			$search_qry .= " and cji.post_date >= '".$fdate."' and cji.post_date <='".$tdate."'";
		}
	}
		
	
	if($search_qry==''){
		$sql_query = "select cji.*,c.company_name from " .TABLE_COMPANY_JOB_INFO." cji,". TABLE_COMPANY_MASTER . " as c order by c.company_id desc";
	}else{
		$sql_query = "select cji.*,c.company_name from " .TABLE_COMPANY_JOB_INFO." cji,". TABLE_COMPANY_MASTER . " as c where cji.company_id=c.company_id and ". $search_qry." order by c.company_id desc";
	}
	$_SESSION['sess_admin_search_query'] = $sql_query;
}elseif($action=='AdvSearch'){
	$sql_query = $_SESSION['sess_admin_search_query'];
}else{
	$sql_query = "select cji.*,c.company_name from " .TABLE_COMPANY_JOB_INFO." cji,". TABLE_COMPANY_MASTER . " as c where cji.company_id=c.company_id order by cji.job_id desc";
}

/***************** FOR PAGIN ***********************/
$starting_point = $items_per_page * ($p - 1);
/****************** END PAGIN ***********************/
$main_page = 'company-job-info.php';

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
		 	com_redirect("company-job-info.php?p=" . $p . "&selected_menu=master&msg=" . msg_encode("Job deleted successfully"));
		
		break;
		
	  case 'alldelete':
	   		$job_id = $_POST['nid'];
			for($i=0; $i< sizeof($job_id) ; $i++){
				com_db_query("delete from " . TABLE_COMPANY_JOB_INFO . " where job_id = '" . $job_id[$i] . "'");
			}
		 	com_redirect("company-job-info.php?p=" . $p . "&selected_menu=master&msg=" . msg_encode("Job deleted successfully"));
		
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
	  		com_redirect("company-job-info.php?p=". $p ."&jID=" . $jID . "&selected_menu=master&msg=" . msg_encode("Company update successfully"));
		 
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
	  		com_redirect("company-job-info.php?p=" . $p . "&selected_menu=master&msg=" . msg_encode("New job added successfully"));
		 
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
	case 'activate':
     		
	   		$status=$_GET['status'];
			if($status==0){
				$query = "update " . TABLE_COMPANY_JOB_INFO . " set status = '1' where job_id = '" . $jID . "'";
			}else{
				$query = "update " . TABLE_COMPANY_JOB_INFO . " set status = '0' where job_id = '" . $jID . "'";
			}	
			com_db_query($query);
	  		com_redirect("company-job-info.php?p=". $p ."&jID=" . $jID . "&selected_menu=master&msg=" . msg_encode("Job update successfully"));
			
		break;
				
    }
	


include("includes/header.php");
?>
<style>
	.MsgShowText{
		font-family:Arial;
		font-size:12px;
		color:#900;
		font-weight:bold;
	}
</style>
<script type="text/javascript">
function confirm_del(nid,p){
	var agree=confirm("Job will be deleted. \n Do you want to continue?");
	if (agree)
		window.location = "company-job-info.php?selected_menu=master&jID=" + nid + "&p=" + p + "&action=delete";
	else
		window.location = "company-job-info.php?selected_menu=master&jID=" + nid + "&p=" + p ;
}

function CheckAll(numRows){
	if(document.getElementById('all').checked){
		for(i=1; i<=numRows; i++){
			var job_id='job_id-'+ i;
			document.getElementById(job_id).checked=true;
		}
	} else {
		for(i=1; i<=numRows; i++){
			var job_id='job_id-'+ i;
			document.getElementById(job_id).checked=false;
		}
	}
}

function AllDelete(numRows){

	var flg=0;
	for(i=1; i<=numRows; i++){
			var job_id='job_id-'+ i;
			if(document.getElementById(job_id).checked){
				flg=1;
			}	
		}
	if(flg==0){
		alert("Please checked atlist one checkbox for delete.");
		document.getElementById('job_id-1').focus();
		return false;
	} else {
		var agree=confirm("Job will be deleted. \n Do you want to continue?");
		if (agree)
			 document.topicform.submit();
		else
			window.location = "company-job-info.php?selected_menu=master";
	}	

}

function confirm_artivate(nid,p,status){
	if(status=='1'){
		var msg="Job will be active. \n Do you want to continue?";
	}else{
		var msg="Job will be Inactive. \n Do you want to continue?";
	}
	var agree=confirm(msg);
	if (agree)
		window.location = "company-job-info.php?selected_menu=master&jID=" + nid + "&p=" + p + "&status=" + status + "&action=activate";
	else
		window.location = "company-job-info.php?selected_menu=master&jID=" + nid + "&p=" + p ;
}

function CompanySearch(){
	window.location ='company-job-info.php?action=CompanySearch&selected_menu=master';
}
function Download_XLS(company_id){
	window.location ="singal-company-download-xls.php?company_id="+company_id;
}

</script>
<!--<script language="JavaScript" src="includes/editor.js"></script>-->
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>

<script type="text/javascript" language="javascript" src="selectuser.js"></script>
 <tr>
    <td align="left" valign="top" bgcolor="#FFFFFF">
	
	<div id="light" class="white_content" style="display:<? if($action=='CompanySearch'){ echo 'block';} else { echo 'none'; } ?>;">
		<div id="spiffycalendar" class="text"></div>
		<link rel="stylesheet" type="text/css" href="includes/javascript/spiffyCal/spiffyCal_v2_1.css">
		<script language="JavaScript" src="includes/javascript/spiffyCal/spiffyCal_v2_1.js"></script>
		<script language="javascript"><!--
		  var dateAvailableFrom = new ctlSpiffyCalendarBox("dateAvailableFrom", "frmSearch", "from_date","btnDate1","",scBTNMODE_CUSTOMBLUE);
		  var dateAvailableTo = new ctlSpiffyCalendarBox("dateAvailableTo", "frmSearch", "to_date","btnDate2","",scBTNMODE_CUSTOMBLUE);	
		//--></script>
		<form name="frmSearch" id="frmSearch" method="post" action="company-job-info.php?selected_menu=master&action=CompanySearchResult">
		<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1">
		  <tr>
			<td align="left" colspan="2" valign="top"><img src="images/specer.gif" width="1" height="50" alt="" title="" /> </td>
		  </tr>
          <tr><td colspan="2">&nbsp;</td></tr>
		  <tr>
			<td align="left" valign="top" >Company Name:</td>
			<td align="left" valign="top">
            	<select name="search_company_id" id="search_company_id">
                    <option value="">Any Company Name</option>
                    <?=selectComboBox("select company_id,company_name from ".TABLE_COMPANY_MASTER." where status='0' order by company_name",'')?>
                </select>
            </td>
		  </tr>
          <tr>
			<td align="center" valign="top">&nbsp;</td>
			<td align="center" valign="top">&nbsp;</td>
		  </tr>
		  <tr>
			<td align="left" valign="top">Job Title:</td>
			<td align="left" valign="top"><input type="text" name="search_job_title" id="search_job_title" /></td>
		  </tr>
		  <tr>
			<td align="center" valign="top">&nbsp;</td>
			<td align="center" valign="top">&nbsp;</td>
		  </tr>
		  <tr>
			<td align="left" valign="top">Date Posted:</td>
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
			<td align="center" valign="top">&nbsp;</td>
			<td align="center" valign="top">&nbsp;</td>
		  </tr>
		  <tr>
			<td align="center" valign="top">&nbsp;</td>
		  	<td align="left" valign="top"><input type="submit" value="Search" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='company-job-info.php?selected_menu=master'" /></td>
		  </tr>
		  <tr>
			<td align="center" valign="top">&nbsp;</td>
			<td align="center" valign="top">&nbsp;</td>
		  </tr>
		</table>
		</form>
	</div>
	<div id="fade" class="black_overlay" style="display:<? if($action=='CompanySearch'){ echo 'block';} else { echo 'none'; } ?>;"></div>
	
	
	<table width="975" border="0" align="center" cellpadding="0" cellspacing="0">

      <tr>
		<?php
		include("includes/menu_left.php");
		?>
		<td width="10" align="left" valign="top">&nbsp;</td>
        <td width="769" align="left" valign="top">

<?php if(($action == '') || ($action == 'save') || ($action =='CompanySearch') || $action =='CompanySearchResult' || $action =='AdvSearch'){	?>			

		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
          <tr>
            <td align="center" valign="middle" class="right"><table width="97%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="21%" align="left" valign="middle" class="heading-text">Company Job Manager</td>
                  <td width="49%" align="left" valign="middle" class="message"><?=$msg?></td>
				  <td width="3%" align="right" valign="middle"><a href="#"><img src="images/search-icon.jpg" border="0" width="25" height="28"  alt="Search Job" title="Search Job" onclick="CompanySearch('CompanySearch');"  /></a></td>
				  <td width="6%" align="left" valign="middle" class="nav-text">Search</td>
                  <td width="4%" align="right" valign="middle"><a href="#"><img src="images/add-icon.jpg" border="0" width="25" height="28" alt="Add Job" title="Add Job" onclick="window.location='company-job-info.php?action=add&selected_menu=master'"  /></a></td>
                  <td width="7%" align="left" valign="middle" class="nav-text">Add New </td>
                  <td width="4%" align="right" valign="middle"><a href="#"><img src="images/delete-icon.jpg" border="0" width="25" height="28"  alt="Delete Job" title="Delete Job" onclick="AllDelete('<?=$numRows?>');"  /></a></td>
                  <td width="6%" align="left" valign="middle" class="nav-text">Delete</td>
                </tr>
              </table></td>
          </tr>
       
          <tr>
            <td align="left" valign="top" class="right-bar-content-border">
			<form name="topicform" action="company-job-info.php?action=alldelete&selected_menu=master" method="post">
			<table width="100%" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="24" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-title-text">#</span></td>
				<td width="32" height="30" align="center" valign="middle" class="right-border">
				<input type="checkbox" name="all" id="all" onclick="CheckAll('<?=$numRows?>');" /></td>
				<td width="188" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Job Title</span> </td>
				<td width="198" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Company Name</span> </td>
				<td width="166" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Posted Date</span> </td>
                <td width="159" height="30" align="center" valign="middle" class="left-border"><div align="center"><span class="right-box-title-text">Action</span></div></td>
			  </tr>
			<?php
			
			if($total_data>0) {
				$i=$starting_point+1;
				while ($data_sql = com_db_fetch_array($exe_data)) {
				$post_date = $data_sql['post_date'];
				$add_date = $data_sql['add_date'];
				$status = $data_sql['status'];
			?>          
			  <tr>
				<td height="30" align="center" valign="middle" class="right-border-left"><?=$i;?></td>
				<td height="30" align="center" valign="middle" class="right-border"><input type="checkbox" id="job_id-<?=$i;?>" name="nid[]" value="<?=$data_sql['job_id'];?>" /></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><a href="company-job-info.php?action=detailes&p=<?=$p?>&selected_menu=master&jID=<?=$data_sql['job_id'];?>"><?=com_db_output($data_sql['job_title'])?></a></td>
                <td height="30" align="left" valign="middle" class="right-border-text"><?=com_db_output($data_sql['company_name'])?></td>
                <td height="30" align="center" valign="middle" class="right-border"><?=$post_date;?></td>
                <td height="30" align="center" valign="middle" class="left-border">
                  <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr> 
                      <?php if($status==0){ ?>
                      <td width="25%" align="center" valign="middle"><a href="#"><img src="images/icon/active-icon.gif" width="16" height="16" alt="" title="" border="0" onclick="confirm_artivate('<?=$data_sql['job_id'];?>','<?=$p;?>','<?=$status;?>');" /></a><br />
                        Status</td>
                      <?php } elseif($status==1){ ?>
                      <td width="25%" align="center" valign="middle"><a href="#"><img src="images/icon/inactive-icon.gif" width="16" height="16" alt="" title="" border="0" onclick="confirm_artivate('<?=$data_sql['job_id'];?>','<?=$p;?>','<?=$status;?>');" /></a><br />
                        Status</td>
                      <?php } ?>
                      <td width="21%" align="center" valign="middle"><a href="#"><img src="images/small-edit-icon.gif" width="16" height="16" alt="Edit" title="Edit" border="0" onclick="window.location='company-job-info.php?selected_menu=master&p=<?=$p;?>&jID=<?=$data_sql['job_id'];?>&action=edit'" /></a><br />
                        Edit</td>
                      <td width="29%" align="center" valign="middle"><a href="#"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" title="Delete" border="0" onclick="confirm_del('<?=$data_sql['job_id'];?>','<?=$p;?>')" /></a><br />
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
		<?php 
		if($action=='CompanySearchResult' || $action == 'AdvSearch'){
			$extra_feture = '&selected_menu=master&action=AdvSearch';
		}else{
			$extra_feture = '&selected_menu=master';
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
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">Cotact Manager :: Edit Company </td>
				  
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top"  class="right-bar-content-border-box"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="celter" valign="top">
		 <!--start iner table  -->
		 <form name="frmDataEdit" id="frmDataEdit" method="post" action="company-job-info.php?action=editsave&selected_menu=master&jID=<?=$jID;?>&p=<?=$p;?>" onsubmit="return chk_form();">
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
                            <td width="83%"><input type="button" class="submitButton" value="Cancel" onclick="window.location='company-job-info.php?p=<?=$p;?>&uID=<?=$uID;?>&selected_menu=master'" /></td>
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
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">Job Manager :: Add Company Job</td>
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="left" valign="top" class="right-border-box">
		 <!--start iner table  -->
		 <form name="DateTest" method="post" action="company-job-info.php?action=addsave&selected_menu=master&jID=<?=$jID;?>&p=<?=$p;?>" onsubmit="return chk_form_Add();">
		  <table width="95%" align="left" cellpadding="5" cellspacing="5" border="0">
			
           
            <tr>
			  <td align="left">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
					<tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Company Name:</td>
                      <td width="75%" align="left" valign="top">
                        <select name="company_id" id="company_id" style="width:206px;">
                        	<option value="">Select Company Name</option>
                        	<?=selectComboBox("select company_id,company_name from ".TABLE_COMPANY_MASTER." where status='0' order by company_name","")?>
                        </select>
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
                    	<tr><td><input type="submit" value="Add Job" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='company-job-info.php?p=<?=$p;?>&uID=<?=$uID;?>&selected_menu=master'" /></td></tr>
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
                  <td width="75%" align="left" valign="top"><?=$company_name?></td>	
                </tr>
                <tr>
                  <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Job Title:</td>
                  <td width="75%" align="left" valign="top"><?=$job_title?></td>	
                </tr>
                <tr>
                  <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Posted Date:</td>
                  <td width="75%" align="left" valign="top"><?=$post_date?></td>	
                </tr>
                <tr>
                  <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Location:</td>
                  <td width="75%" align="left" valign="top"><?=$location?></td>	
                </tr>
                <tr>
                  <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Description:</td>
                  <td width="75%" align="left" valign="top"><?=$description?></td>	
                </tr>
			</table>
		 <!-- end inner table -->
		  </td>
		 </tr>
		 <tr>
            	<td align="center">
                	<table width="50%" border="0" cellpadding="4" cellspacing="4">
                    	<tr><td><input type="button" class="submitButton" value="Back" onclick="window.location='company-job-info.php?p=<?=$p;?>&selected_menu=master'" /></td></tr>
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