<?php
require('includes/include_top.php');

$action = $_REQUEST['action'];
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';
if($action == 'MovementExport'){
	$new_title = $_POST['new_title'];
	$from_date = $_POST['from_date'];
	$to_date = $_POST['to_date'];
	$sortby = $_POST['orderby'];
	$state	= $_POST['state']; //remove
	if($from_date !='' ){
		$fd = explode('/',$from_date);
		if(strlen($from_date)==10 && is_numeric($fd[2]) && is_numeric($fd[1]) && is_numeric($fd[0])){
			$from_date = $fd[2].'-'.$fd[0].'-'.$fd[1];
		}else{
			com_redirect("movement-export.php?selected_menu=movement&msg=" . msg_encode("Please enter valid date format ".$check));
		}	
	}
	if($to_date !=''){
		$td = explode('/',$to_date);
		if(strlen($to_date)==10 && is_numeric($td[2]) && is_numeric($td[1]) && is_numeric($td[0])){
			$to_date = $td[2].'-'.$td[0].'-'.$td[1];
		}else{
			com_redirect("movement-export.php?selected_menu=movement&msg=" . msg_encode("Please enter valid date format"));
		}	
	}
	
	require('php_xls.php');
	
	$xls=new PHP_XLS();             //create excel object
	$xls->AddSheet('sheet 1');      //add a work sheet
	
	$xls->SetActiveStyle('center');
	
	$xls->Text(2,1,"Contact Data : Download");
	$xls->Text(4,1,"Move ID");
	$xls->Text(4,2,"First Name");
	$xls->Text(4,3,"Middle Initial");
	$xls->Text(4,4,"Last Name");
	$xls->Text(4,5,"Person Email");
	$xls->Text(4,6,"Person Phone");
	$xls->Text(4,7,"About Person");
	
	$xls->Text(4,8,"Title");
	$xls->Text(4,9,"Headline");
	$xls->Text(4,10,"Company Name");
	$xls->Text(4,11,"Company Website");
	$xls->Text(4,12,"Industry");
	$xls->Text(4,13,"Address");
	$xls->Text(4,14,"City");
	$xls->Text(4,15,"State");
	$xls->Text(4,16,"Zip Code");
	$xls->Text(4,17,"Country");
	$xls->Text(4,18,"Phone");
	$xls->Text(4,19,"Fax");
	
	$xls->Text(4,20,"Date of announcement");
	$xls->Text(4,21,"Effective Date");
	$xls->Text(4,22,"Movement Type");
	$xls->Text(4,23,"The full text of the press release");
	$xls->Text(4,24,"Link");
	$xls->Text(4,25,"Company Size Employees");
	$xls->Text(4,26,"Company Size Revenue");
	$xls->Text(4,27,"Source");
	$xls->Text(4,28,"Short Url");
	$xls->Text(4,29,"What Happened");
	$xls->Text(4,30,"About Company");
	$xls->Text(4,31,"More Link");
	$xls->Text(4,32,"Movement URL");
	$xls->Text(4,33,"Not Current?");
	
	$download_query_string = "select pm.first_name,pm.middle_name,pm.last_name,pm.email as person_email,pm.phone as person_phone,pm.about_person,
							mm.move_id,mm.title,mm.headline,cm.company_name,cm.company_website,i.title as company_industry,cm.ind_group_id,cm.industry_id,
							cm.address,cm.address2,cm.city,s.short_name as state,ct.countries_name as country,cm.zip_code,cm.phone,cm.fax,
							cm.about_company,m.name as movement_type,mm.announce_date,mm.effective_date,mm.full_body,mm.link,so.source,
							r.name as company_revenue,e.name as company_employee,mm.short_url,mm.what_happened,mm.more_link,
							mm.movement_url,mm.not_current,mm.add_date from " 
							.TABLE_MOVEMENT_MASTER. " as mm, "
							.TABLE_PERSONAL_MASTER. " as pm, "
							.TABLE_COMPANY_MASTER. " as cm, "
							.TABLE_REVENUE_SIZE." as r, "
							.TABLE_EMPLOYEE_SIZE." as e, "
							.TABLE_INDUSTRY." as i, "
							.TABLE_STATE." as s, "
							.TABLE_COUNTRIES." as ct, "
							.TABLE_SOURCE." as so, "
							.TABLE_MANAGEMENT_CHANGE." as m 
							where (mm.company_id=cm.company_id and mm.personal_id=pm.personal_id and mm.source_id=so.id and mm.movement_type=m.id and cm.company_revenue=r.id and cm.company_employee=e.id and cm.company_industry=i.industry_id and cm.state=s.state_id and cm.country=ct.countries_id)";
	
		if($new_title==''){
			if($from_date!='' && $to_date !=''){
				$download_query = $download_query_string ."	and announce_date >='".$from_date."' and announce_date <='".$to_date."'";
			}else{
				$download_query = $download_query_string ;
			}
		}elseif($new_title=='Other'){
			 $other_query = com_db_query("select title from ".TABLE_TITLE." where title<>'Other'");
			 $title_list='';
			 while($other_row=com_db_fetch_array($other_query)){
			 	if($title_list==''){
			 		$title_list = "'".$other_row['title']."'";
				}else{
					$title_list .= ",'".$other_row['title']."'";
				}
			 }
			 if($from_date!='' && $to_date !=''){	
			 	$download_query = $download_query_string ." and mm.title not in (" . $title_list . ") and mm.announce_date >='".$from_date."' and mm.announce_date <='".$to_date."'";
			 }else{
			 	$download_query = $download_query_string ." and mm.title not in (" . $title_list . ")";
			 }
		}else{
			 if($from_date!='' && $to_date !=''){	
			 	$download_query = $download_query_string ." and mm.title = '" . $new_title . "' and mm.announce_date >='".$from_date."' and mm.announce_date <='".$to_date."'";
			 }else{
			 	$download_query = $download_query_string ." and mm.title = '" . $new_title . "'";
			 }
		}
		//Add Query
		if(is_array($state) && $state !=''){
			$state_list = implode(",",$state);
			if($state_list !=''){
				$download_query = $download_query . " and cm.state in (".$state_list.")";
			}
		}
		if($sortby !=''){
			$download_query = $download_query .' order by cm.'.$sortby;
		}
		//echo $download_query;	
		$result=com_db_query($download_query);
	   
		$xlsRow = 5;
		while($download_row=com_db_fetch_array($result)) {
			++$i;
			$move_id = str_replace(',',';',com_db_output($download_row['move_id']));
			$first_name = str_replace(',',';',com_db_output($download_row['first_name']));
			$middle_name = str_replace(',',';',com_db_output($download_row['middle_name']));
			$last_name = str_replace(',',';',com_db_output($download_row['last_name']));
			$person_email = str_replace(',',';',com_db_output($download_row['person_email']));
			$person_phone = str_replace(',',';',com_db_output($download_row['person_phone']));
			$about_person = str_replace(',',';',strip_tags($download_row['about_person']));
			$title = str_replace(',',';',com_db_output($download_row['title']));
			$headline = str_replace(',',';',com_db_output($download_row['headline']));
			$company_name = str_replace(',',';',com_db_output($download_row['company_name']));
			$company_website = str_replace(',',';',com_db_output($download_row['company_website']));
			$parent_industry =  str_replace(',',';',com_db_GetValue("select title from ".TABLE_INDUSTRY." where industry_id='".$download_row['ind_group_id']."'"));
			$company_industry = $parent_industry.' : '. str_replace(',',';',com_db_output($download_row['company_industry']));
			$address = str_replace(',',';',com_db_output($download_row['address'].' '.$download_row['address2']));
			$city = str_replace(',',';',com_db_output($download_row['city']));
			$state = str_replace(',',';',com_db_output($download_row['state']));
			$zip_code = str_replace(',',';',com_db_output($download_row['zip_code']));
			$country = str_replace(',',';',com_db_output($download_row['country']));
			$phone = str_replace(',',';',$download_row['phone']);
			$fax = str_replace(',',';',$download_row['fax']);
			
			$announce_date = $download_row['announce_date'];
			$adate = explode('-',$announce_date);
			$announce_date = $adate[1].'/'.$adate[2].'/'.$adate[0];
			
			$effective_date = $download_row['effective_date'];
			$edate = explode('-',$effective_date);
			$effective_date = $edate[1].'/'.$edate[2].'/'.$edate[0];
			
			$movement_type = str_replace(',',';',com_db_output($download_row['movement_type']));
			$full_body = str_replace(',',';',str_replace('<br />','&&&', strip_tags($download_row['full_body'])));
			$link = str_replace(',',';',com_db_output($download_row['link']));
			$company_employee = str_replace(',',';',com_db_output($download_row['company_employee']));
			$company_revenue = str_replace(',',';',com_db_output($download_row['company_revenue']));
			$source = str_replace(',',';',com_db_output($download_row['source']));
			$short_url = str_replace(',',';',com_db_output($download_row['short_url']));
			$what_happened = str_replace(',',';',strip_tags($download_row['what_happened']));
			$about_company = str_replace(',',';',strip_tags($download_row['about_company']));
			$more_link = str_replace(',',';',com_db_output($download_row['more_link']));
			$movement_url = $download_row['movement_url'];
			$not_current = $download_row['not_current'];
			
			$xls->Text($xlsRow,1,"$move_id");
			$xls->Text($xlsRow,2,"$first_name");
			$xls->Text($xlsRow,3,"$middle_name");
			$xls->Text($xlsRow,4,"$last_name");
			$xls->Text($xlsRow,5,"$person_email");
			$xls->Text($xlsRow,6,"$person_phone");
			$xls->Text($xlsRow,7,"$about_person");
			
			$xls->Text($xlsRow,8,"$title");
			$xls->Text($xlsRow,9,"$headline");
			$xls->Text($xlsRow,10,"$company_name");
			$xls->Text($xlsRow,11,"$company_website");
			$xls->Text($xlsRow,12,"$company_industry");
			$xls->Text($xlsRow,13,"$address");
			$xls->Text($xlsRow,14,"$city");
			$xls->Text($xlsRow,15,"$state");
			$xls->Text($xlsRow,16,"$zip_code");
			$xls->Text($xlsRow,17,"$country");
			$xls->Text($xlsRow,18,"$phone");
			$xls->Text($xlsRow,19,"$fax");
			
			$xls->Text($xlsRow,20,"$announce_date");
			$xls->Text($xlsRow,21,"$effective_date");
			$xls->Text($xlsRow,22,"$movement_type");
			$xls->Text($xlsRow,23,"$full_body");
			$xls->Text($xlsRow,24,"$link");
			$xls->Text($xlsRow,25,"$company_employee");
			$xls->Text($xlsRow,26,"$company_revenue");
			$xls->Text($xlsRow,27,"$source");
			$xls->Text($xlsRow,28,"$short_url");
			$xls->Text($xlsRow,29,"$what_happened");
			$xls->Text($xlsRow,20,"$about_company");
			$xls->Text($xlsRow,31,"$more_link");
			$xls->Text($xlsRow,32,"$movement_url");
			$xls->Text($xlsRow,33,"$not_current");
			
			$xlsRow++;
			}
		$xls->Output('download-movement-'. date('m-d-Y') . '.xls');	
		com_redirect("movement-export.php?selected_menu=movement&msg=" . msg_encode("Movement data download successfully"));

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
		  <form name="exportfile" method="post" action="movement-export.php?action=MovementExport">
		  
			<table width="60%" border="0" cellspacing="0" cellpadding="5">
			  <tr><td colspan="2" height="20">&nbsp;</td></tr>
			
			  <tr>
				<td width="20%" align="left" valign="top" class="page-text">Title:</td>
				<td width="80%" align="left" valign="top">
					<select name="new_title" id="new_title">
					<option value="">ALL</option>
					<?=selectComboBox("select title,title from ".TABLE_TITLE." where status='0' and title !='' order by id",'')?>
					</select>				</td>
			  </tr>
             
			   <tr>
				<td colspan="2"> Announce Date</td>
				
			  </tr>
			   <tr>
			     <td align="left" valign="top" class="page-text">&nbsp;From Date:</td>
			     <td align="left" valign="top" class="page-text"><input type="text" name="from_date" id="from_date" size="17" value="" />
						<a href="javascript:NewCssCal('from_date','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a> (mm/dd/yyyy)</td>
			    </tr>
				<tr>
				 <td align="left" valign="top" class="page-text">&nbsp;To Date:</td>
				 <td align="left" valign="top" class="page-text"> <input type="text" name="to_date" id="to_date" size="17" value="" />
						<a href="javascript:NewCssCal('to_date','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a> (mm/dd/yyyy)</td>
				</tr>
				<tr>
				 <td align="left" valign="top" class="page-text">&nbsp;State:</td>
				 <td align="left" valign="top" class="page-text">
				 	<select name="state[]" id="state" multiple="multiple" style="width:127px;">
					<option value="">All</option>
					<?=selectComboBox("select state_id,short_name from ". TABLE_STATE ." order by short_name" ,"");?>
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
				</tr>
				
			   <tr>
			     <td>&nbsp;</td>
			     <td align="left" valign="top">&nbsp;</td>
			     </tr>
			   <tr>
			     <td>&nbsp;</td>
			     <td align="left" valign="top"><input type="submit" name="Submit" value="Export Movement" class="submitButton" /></td>
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