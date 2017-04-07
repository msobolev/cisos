<?php
require('includes/include_top.php');

$action = $_REQUEST['action'];
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';
if($action == 'UserSignupDataExport'){
	$from_date = $_POST['from_date'];
	$to_date = $_POST['to_date'];
	if($from_date !='' ){
		$fd = explode('/',$from_date);
		if(strlen($from_date)==10 && is_numeric($fd[2]) && is_numeric($fd[1]) && is_numeric($fd[0])){
			$from_date = $fd[2].'-'.$fd[0].'-'.$fd[1];
		}else{
			com_redirect("user-only-sign-up-download.php?selected_menu=user&msg=" . msg_encode("Please enter valid date format ".$check));
		}	
	}
	if($to_date !=''){
		$td = explode('/',$to_date);
		if(strlen($to_date)==10 && is_numeric($td[2]) && is_numeric($td[1]) && is_numeric($td[0])){
			$to_date = $td[2].'-'.$td[0].'-'.$td[1];
		}else{
			com_redirect("user-only-sign-up-download.php?selected_menu=user&msg=" . msg_encode("Please enter valid date format"));
		}	
	}
	
		
		require('php_xls.php');
	
	$xls=new PHP_XLS();             //create excel object
	$xls->AddSheet('sheet 1');      //add a work sheet
	
	$xls->SetActiveStyle('center');
	
	$xls->Text(2,1,"User Data : Download");
	$xls->Text(4,1,"Full Name");
	$xls->Text(4,2,"Email");
	$xls->Text(4,3,"Add Date");
	
	
		
		if($from_date!='' && $to_date !=''){
			$download_query = "select * from ".TABLE_VIGILANT_SIGN_UP." where  add_date >='".$from_date."' and add_date <='".$to_date."'";
		}else{
			$download_query = "select * from ".TABLE_VIGILANT_SIGN_UP;
		}
		
		
		//echo $download_query;	
		$result=com_db_query($download_query);
	   
		$xlsRow = 5;
		while($download_row=com_db_fetch_array($result)) {
			++$i;
			$full_name = str_replace(',',';',com_db_output($download_row['full_name']));
			$email = str_replace(',',';',com_db_output($download_row['email']));
			$resDt = $download_row['add_date'];
			if($resDt !=''){
				$resDt = explode('-',$resDt);
				$res_date = $resDt[1].'/'.$resDt[2].'/'.$resDt[0];
			}else{
				$res_date='';
			}
			
			
			$xls->Text($xlsRow,1,"$full_name");
			$xls->Text($xlsRow,2,"$email");
			$xls->Text($xlsRow,3,"$res_date");
			
			$xlsRow++;
			}
		$xls->Output('user-signup-data-'. date('m-d-Y') . '.xls');	
		com_redirect("user-only-sing-up-download.php?selected_menu=user&msg=" . msg_encode("User data download successfully"));

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
				  var dateAvailableFrom = new ctlSpiffyCalendarBox("dateAvailableFrom", "signup_exportfile", "from_date","btnDate1","",scBTNMODE_CUSTOMBLUE);
				  var dateAvailableTo = new ctlSpiffyCalendarBox("dateAvailableTo", "signup_exportfile", "to_date","btnDate2","",scBTNMODE_CUSTOMBLUE);	
				//--></script>	
		  <form name="signup_exportfile" method="post" action="user-only-sign-up-download.php?action=UserSignupDataExport">
		  
			<table width="60%" border="0" cellspacing="0" cellpadding="5">
			  <tr><td colspan="2" height="20">&nbsp;</td></tr>
			   <tr>
				<td colspan="2"><b>Sign Up  Date</b></td>
				
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
			     <td>&nbsp;</td>
			     <td align="left" valign="top">&nbsp;</td>
			     </tr>
			   <tr>
			     <td>&nbsp;</td>
			     <td align="left" valign="top"><input type="submit" name="Submit" value="Export User Sign Up Data" class="submitButton" /></td>
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