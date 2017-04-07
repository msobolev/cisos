<?php
require('includes/include_top.php');

$action = $_REQUEST['action'];
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';
if($action == 'UserDataExport'){
	$from_date = $_POST['from_date'];
	$to_date = $_POST['to_date'];
	$status = $_POST['status'];
	
	if($from_date !='' ){
		$fd = explode('/',$from_date);
		if(strlen($from_date)==10 && is_numeric($fd[2]) && is_numeric($fd[1]) && is_numeric($fd[0])){
			$from_date = $fd[2].'-'.$fd[0].'-'.$fd[1];
		}else{
			com_redirect("user-download.php?selected_menu=user&msg=" . msg_encode("Please enter valid date format ".$check));
		}	
	}
	if($to_date !=''){
		$td = explode('/',$to_date);
		if(strlen($to_date)==10 && is_numeric($td[2]) && is_numeric($td[1]) && is_numeric($td[0])){
			$to_date = $td[2].'-'.$td[0].'-'.$td[1];
		}else{
			com_redirect("user-download.php?selected_menu=user&msg=" . msg_encode("Please enter valid date format"));
		}	
	}
	
	require('php_xls.php');
	
	$xls=new PHP_XLS();             //create excel object
	$xls->AddSheet('sheet 1');      //add a work sheet
	
	$xls->SetActiveStyle('center');
	
	$xls->Text(2,1,"User Data : Download");
	
	$xls->Text(4,1,"User ID");
	$xls->Text(4,2,"First Name");
	$xls->Text(4,3,"Last Name");
	$xls->Text(4,4,"Company Name");
	$xls->Text(4,5,"Phone");
	$xls->Text(4,6,"Email");
	$xls->Text(4,7,"Expire Date");
	$xls->Text(4,8,"Register Date");
	$xls->Text(4,9,"Sub Type");
	$xls->Text(4,10,"Total Login");
	$xls->Text(4,11,"Total Searches");
	$xls->Text(4,12,"Total Downloads");
	
	
	
		
		if($from_date!='' && $to_date !='' && $status !=''){
			$download_query = "select * from ".TABLE_USER." where  res_date >='".$from_date."' and res_date <='".$to_date."' and status='".$status."'";
		}elseif($from_date!='' && $to_date !='' && $status ==''){
			$download_query = "select * from ".TABLE_USER." where  res_date >='".$from_date."' and res_date <='".$to_date."'";
		}elseif($status !=''){
			$download_query = "select * from ".TABLE_USER." where  status='".$status."'";
		}else{
			$download_query = "select * from ".TABLE_USER;
		}
		
		
		//echo $download_query;	
		$result=com_db_query($download_query);
	   
		$xlsRow = 5;
		while($download_row=com_db_fetch_array($result)) {
			++$i;
			$user_id = str_replace(',',';',com_db_output($download_row['user_id']));
			$first_name = str_replace(',',';',com_db_output($download_row['first_name']));
			$last_name = str_replace(',',';',com_db_output($download_row['last_name']));
			$company_name = str_replace(',',';',com_db_output($download_row['company_name']));
			$phone = str_replace(',',';',com_db_output($download_row['phone']));
			$email = str_replace(',',';',com_db_output($download_row['email']));
			
			$expDt = $download_row['exp_date'];
			if($expDt !=''){
				$expDt = explode('-',$expDt);
				$exp_date = $expDt[1].'/'.$expDt[2].'/'.$expDt[0];
			}else{
				$exp_date ='';
			}
			$resDt = $download_row['res_date'];
			if($resDt !=''){
				$resDt = explode('-',$resDt);
				$res_date = $resDt[1].'/'.$resDt[2].'/'.$resDt[0];
			}else{
				$res_date='';
			}
			$subscription_name = com_db_GetValue("select subscription_name from " . TABLE_SUBSCRIPTION . " where sub_id='".$download_row['subscription_id']."'");
			$total_login = com_db_GetValue("select count(user_id) from " . TABLE_LOGIN_HISTORY . " where user_id='".$download_row['user_id']."'");
			$total_search = com_db_GetValue("select count(user_id) from " . TABLE_SEARCH_HISTORY . " where user_id='".$download_row['user_id']."'");
			$total_download = com_db_GetValue("select count(user_id) from " . TABLE_DOWNLOAD . " where user_id='".$download_row['user_id']."'");
			
			$xls->Text($xlsRow,1,"$user_id");
			$xls->Text($xlsRow,2,"$first_name");
			$xls->Text($xlsRow,3,"$last_name");
			$xls->Text($xlsRow,4,"$company_name");
			$xls->Text($xlsRow,5,"$phone");
			$xls->Text($xlsRow,6,"$email");
			$xls->Text($xlsRow,7,"$exp_date");
			$xls->Text($xlsRow,8,"$res_date");
			$xls->Text($xlsRow,9,"$subscription_name");
			$xls->Text($xlsRow,10,"$total_login");
			$xls->Text($xlsRow,11,"$total_search");
			$xls->Text($xlsRow,12,"$total_download");
			
			$xlsRow++;
			}
		$xls->Output('download-user-data-'. date('m-d-Y') . '.xls');	
		com_redirect("user-download.php?selected_menu=user&msg=" . msg_encode("User data download successfully"));

}

include("includes/header.php");
?>

<tr>
    <td align="left" valign="top" bgcolor="#FFFFFF"><table width="975" border="0" align="center" cellpadding="0" cellspacing="0">

      <tr>
		<?php
		include("includes/menu_left.php");
		?>
        <td width="10" align="left" valign="top">&nbsp;</td>
        <td width="769" align="left" valign="top">
	
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right">
			  <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="18%" align="left" valign="middle" class="heading-text">Export .XLS file</td>
				  <td width="82%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box">
			<div id="spiffycalendar" class="text"></div>
				<link rel="stylesheet" type="text/css" href="includes/javascript/spiffyCal/spiffyCal_v2_1.css">
				<script language="JavaScript" src="includes/javascript/spiffyCal/spiffyCal_v2_1.js"></script>
				<script language="javascript"><!--
				  var dateAvailableFrom = new ctlSpiffyCalendarBox("dateAvailableFrom", "exportfile", "from_date","btnDate1","",scBTNMODE_CUSTOMBLUE);
				  var dateAvailableTo = new ctlSpiffyCalendarBox("dateAvailableTo", "exportfile", "to_date","btnDate2","",scBTNMODE_CUSTOMBLUE);	
				//--></script>	
		  <form name="exportfile" method="post" action="user-download.php?action=UserDataExport">
		  
			<table width="60%" border="0" cellspacing="0" cellpadding="5">
			  <tr><td colspan="2" height="20">&nbsp;</td></tr>
			
			 <!-- <tr>
				<td width="20%" align="left" valign="top" class="page-text">Title:</td>
				<td width="80%" align="left" valign="top">
					<select name="new_title" id="new_title">
					<option value="">ALL</option>
					<?//=selectComboBox("select title,title from ".TABLE_TITLE." where status='0' and title !='' order by id",'')?>
					</select>				</td>
			  </tr>
             -->
			   <tr>
				<td colspan="2"><b>Register Date</b></td>
				
			  </tr>
			   <tr>
			     <td align="left" valign="top" class="page-text">&nbsp;From Date:</td>
			     <td align="left" valign="top" class="page-text"><input type="text" name="from_date" id="from_date" size="12" value="" />
						<a href="javascript:NewCssCal('from_date','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a> (mm/dd/yyyy)	</td>
			    </tr>
				<tr>
				 <td align="left" valign="top" class="page-text">&nbsp;To Date:</td>
				 <td align="left" valign="top" class="page-text"> <input type="text" name="to_date" id="to_date" size="12" value="" />
						<a href="javascript:NewCssCal('to_date','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /> </a> (mm/dd/yyyy)</td>
				</tr>
                <tr>
				 <td align="left" valign="top" class="page-text">&nbsp;Active user:</td>
				 <td align="left" valign="top" class="page-text"> <input type="checkbox" name="status" value="0" /></td>
				</tr>
			   <tr>
			     <td>&nbsp;</td>
			     <td align="left" valign="top">&nbsp;</td>
			     </tr>
			   <tr>
			     <td>&nbsp;</td>
			     <td align="left" valign="top"><input type="submit" name="Submit" value="Export User Data" class="submitButton" /></td>
			     </tr>
			   <tr>
			     <td>&nbsp;</td>
			     <td align="left" valign="top">&nbsp;</td>
			     </tr>
			</table>
			</form>
		</td>
          </tr>
        </table>
		
        </td>
      </tr>
    </table></td>
  </tr>	 
		
 <?php
include("includes/footer.php");
?> 