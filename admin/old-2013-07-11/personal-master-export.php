<?php
require('includes/include_top.php');

$action = $_REQUEST['action'];
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';
if($action == 'PersonalDataExport'){
	//$title = $_POST['title'];
	$from_date = $_POST['from_date'];
	$to_date = $_POST['to_date'];

	if($from_date !='' ){
		$fd = explode('/',$from_date);
		if(strlen($from_date)==10 && is_numeric($fd[2]) && is_numeric($fd[1]) && is_numeric($fd[0])){
			$from_date = $fd[2].'-'.$fd[0].'-'.$fd[1];
		}else{
			com_redirect("personal-master-export.php?selected_menu=contact&msg=" . msg_encode("Please enter valid date format ".$check));
		}	
	}
	if($to_date !=''){
		$td = explode('/',$to_date);
		if(strlen($to_date)==10 && is_numeric($td[2]) && is_numeric($td[1]) && is_numeric($td[0])){
			$to_date = $td[2].'-'.$td[0].'-'.$td[1];
		}else{
			com_redirect("personal-master-export.php?selected_menu=contact&msg=" . msg_encode("Please enter valid date format"));
		}	
	}
	
	require('php_xls.php');
	
	$xls=new PHP_XLS();             //create excel object
	$xls->AddSheet('sheet 1');      //add a work sheet
	
	$xls->SetActiveStyle('center');

	$xls->Text(2,1,"Personal Data : Download");
	$xls->Text(4,1,"First Name");
	$xls->Text(4,2,"Middle Initial");
	$xls->Text(4,3,"Last Name");
	$xls->Text(4,4,"Email");
	$xls->Text(4,5,"Phone");
	$xls->Text(4,6,"LIN Url");
	$xls->Text(4,7,"Personal Image");
	$xls->Text(4,8,"About Person (bio)");
	$xls->Text(4,9,"Personal");
	$xls->Text(4,10,"Facebook Link");
	$xls->Text(4,11,"Linkedin Link");
	$xls->Text(4,12,"Twitter Link");
	$xls->Text(4,13,"Google+ Link");
	$xls->Text(4,14,"Undergrad Degree");
	$xls->Text(4,15,"Undergrad Specialization");
	$xls->Text(4,16,"Undergrad College");
	$xls->Text(4,17,"Undergrad Graduation Year");
	$xls->Text(4,18,"Grad Degree");
	$xls->Text(4,19,"Grad Specialization");
	$xls->Text(4,20,"Grad College");
	$xls->Text(4,21,"Grad Graduation Year");
	//$xls->Text(4,22,"Awards Title");
	//$xls->Text(4,23,"Awards Given By");
	//$xls->Text(4,24,"Awards Date");	
	
	
	$download_query_string = "select * from ".TABLE_PERSONAL_MASTER; 
							
		//if($title==''){
			if($from_date!='' && $to_date !=''){
				$download_query = $download_query_string ."	where status='0' and add_date >='".$from_date."' and add_date <='".$to_date."'";
			}else{
				$download_query = $download_query_string ."	where status='0'";
			}
		
		$result=com_db_query($download_query);
	   
		$xlsRow = 5;
		while($download_row=com_db_fetch_array($result)) {
			++$i;
			
			$first_name = str_replace(',',';',com_db_output($download_row['first_name']));
			$middle_name = str_replace(',',';',com_db_output($download_row['middle_name']));
			$last_name = str_replace(',',';',com_db_output($download_row['last_name']));
			$email = str_replace(',',';',com_db_output($download_row['email']));
			$phone = str_replace(',',';',com_db_output($download_row['phone']));
			$lin_url = str_replace(',',';',com_db_output($download_row['lin_url']));
			$personal_image = str_replace(',',';',com_db_output($download_row['personal_image']));
			$facebook_link = str_replace(',',';',com_db_output($download_row['facebook_link']));
			$linkedin_link = str_replace(',',';',com_db_output($download_row['linkedin_link']));
			$twitter_link = str_replace(',',';',com_db_output($download_row['twitter_link']));
			$googleplush_link = str_replace(',',';',com_db_output($download_row['googleplush_link']));
			$about_person = str_replace(',',';',com_db_output(strip_tags($download_row['about_person'])));
			$personal = str_replace(',',';',com_db_output($download_row['personal']));
			$edu_ugrad_degree = str_replace(',',';',com_db_output($download_row['edu_ugrad_degree']));
			$edu_ugrad_specialization = str_replace(',',';',com_db_output($download_row['edu_ugrad_specialization']));
			$edu_ugrad_college = str_replace(',',';',com_db_output($download_row['edu_ugrad_college']));
			$edu_ugrad_year = str_replace(',',';',com_db_output($download_row['edu_ugrad_year']));
			$edu_grad_degree = str_replace(',',';',com_db_output($download_row['edu_grad_degree']));
			$edu_grad_specialization = str_replace(',',';',com_db_output($download_row['edu_grad_specialization']));
			$edu_grad_college = str_replace(',',';',com_db_output($download_row['edu_grad_college']));
			$edu_grad_year = str_replace(',',';',com_db_output($download_row['edu_grad_year']));
			//$awards_title = str_replace(',',';',com_db_output($download_row['awards_title']));
			//$awards_given_by = str_replace(',',';',com_db_output($download_row['awards_given_by']));
			//$adate = explode('-',$download_row['awards_date']);
			//$awards_date = $adate[1].'/'.$adate[2].'/'.$adate[0];
			
			$xls->Text($xlsRow,1,"$first_name");
			$xls->Text($xlsRow,2,"$middle_name");
			$xls->Text($xlsRow,3,"$last_name");
			$xls->Text($xlsRow,4,"$email");
			$xls->Text($xlsRow,5,"$phone");
			$xls->Text($xlsRow,6,"$lin_url");
			$xls->Text($xlsRow,7,"$personal_image");
			$xls->Text($xlsRow,8,"$about_person");
			$xls->Text($xlsRow,9,"$personal");
			$xls->Text($xlsRow,10,"$facebook_link");
			$xls->Text($xlsRow,11,"$linkedin_link");
			$xls->Text($xlsRow,12,"$twitter_link");
			$xls->Text($xlsRow,13,"$googleplush_link");
			$xls->Text($xlsRow,14,"$edu_ugrad_degree");
			$xls->Text($xlsRow,15,"$edu_ugrad_specialization");
			$xls->Text($xlsRow,16,"$edu_ugrad_college");
			$xls->Text($xlsRow,17,"$edu_ugrad_year");
			$xls->Text($xlsRow,18,"$edu_grad_degree");
			$xls->Text($xlsRow,19,"$edu_grad_specialization");
			$xls->Text($xlsRow,20,"$edu_grad_college");
			$xls->Text($xlsRow,21,"$edu_grad_year");
			//$xls->Text($xlsRow,22,"$awards_title");
			//$xls->Text($xlsRow,23,"$awards_given_by");
			//$xls->Text($xlsRow,24,"$awards_date");
			
			$xlsRow++;
			}
		$xls->Output('download-personal-master-'. date('m-d-Y') . '.xls');	

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
		  <form name="exportfile" method="post" action="personal-master-export.php?action=PersonalDataExport">
		  
			<table width="60%" border="0" cellspacing="0" cellpadding="5">
			  <tr><td colspan="2" height="20">&nbsp;</td></tr>
			
			  <!--<tr>
				<td width="20%" align="left" valign="top" class="page-text">&nbsp;Title:</td>
				<td width="80%" align="left" valign="top">
					<select name="title" id="title">
					<option value="">ALL</option>
					<?//=selectComboBox("select title,title from ".TABLE_TITLE." where status='0' and title !='' order by id",'')?>
					</select>				</td>
			  </tr>-->
             
			   <tr>
				<td colspan="2">&nbsp;Insert Date</td>
				
			  </tr>
			   <tr>
			     <td align="left" valign="top" class="page-text">&nbsp;&nbsp;&nbsp;From Date:</td>
			     <td align="left" valign="top" class="page-text"><input type="text" name="from_date" id="from_date" size="17" value="" />
						<a href="javascript:NewCssCal('from_date','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a> (mm/dd/yyyy)</td>
			    </tr>
				<tr>
				 <td align="left" valign="top" class="page-text">&nbsp;&nbsp;&nbsp;To Date:</td>
				 <td align="left" valign="top" class="page-text"> <input type="text" name="to_date" id="to_date" size="17" value="" />
						<a href="javascript:NewCssCal('to_date','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a> (mm/dd/yyyy)</td>
				</tr>
				<!--<tr>
				 <td align="left" valign="top" class="page-text">&nbsp;State:</td>
				 <td align="left" valign="top" class="page-text">
				 	<select name="state[]" id="state" multiple="multiple" style="width:127px;">
					<option value="">All</option>
					<?//=selectComboBox("select state_id,short_name from ". TABLE_STATE ." where country_id ='223'" ,"");?>
					</select>
				 </td>
				</tr>
				<tr>
				 <td align="left" valign="top" class="page-text">&nbsp;Sort By:</td>
				 <td align="left" valign="top" class="page-text">
				 	<select name="orderby" id="orderby">
						<option value="">--Select--</option>
						<option value="company_revenue">Revenue Size</option>
						<option value="company_employee">Employees Size</option>
					</select>	
				 </td>
				</tr>-->
				
			   <tr>
			     <td>&nbsp;</td>
			     <td align="left" valign="top">&nbsp;</td>
			     </tr>
			   <tr>
			     <td>&nbsp;</td>
			     <td align="left" valign="top"><input type="submit" name="Submit" value="Export Personal Data" class="submitButton" /></td>
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