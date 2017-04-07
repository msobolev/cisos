<?php
require('includes/include_top.php');

$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 20;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';

if($action == 'CompanySearchResult'){
	
	$company_name		= $_POST['search_company_name'];
	$company_url		= $_POST['search_company_url'];
	$industry 			= $_POST['search_industry'];
	$state				= $_POST['search_state'];
	$country			= $_POST['search_country'];
	$from_date			= $_POST['from_date'];
	$to_date 			= $_POST['to_date'];
	$company_revenue 	= $_POST['search_company_revenue'];
	$company_employee	= $_POST['search_company_employee'];
	
	$search_qry='';
	if($company_name!=''){
		$search_qry .= " c.company_name = '".$company_name."'";
	}
	if($company_url!=''){
		if($search_qry==''){
			$search_qry .= " c.company_website = '".$company_url."'";
		}else{
			$search_qry .= " and c.company_website = '".$company_url."'";
		}	
	}
	if($industry!=''){
		if($search_qry==''){
			$search_qry .= " c.industry_id ='".$industry."'";
		}else{
			$search_qry .= " and c.industry_id ='".$industry."'";
		}	
	}
	
	if($state!=''){
		if($search_qry==''){
			$search_qry .= " c.state = '".$state."'";
		}else{
			$search_qry .= " and c.state = '".$state."'";
		}	
	}
	if($country!=''){
		if($search_qry==''){
			$search_qry .= " c.country = '".$country."'";
		}else{
			$search_qry .= " and c.country = '".$country."'";
		}	
	}
	
	if($from_date!='' && strlen($from_date)==10 && $to_date !='' && strlen($to_date)==10){
		$fdt = explode('/',$from_date);
		$fdate = $fdt[2].'-'.$fdt[0].'-'.$fdt[1];
		$tdt = explode('/',$to_date);
		$tdate = $tdt[2].'-'.$tdt[0].'-'.$tdt[1];
		if($search_qry==''){
			$search_qry .= " c.add_date >= '".$fdate."' and c.add_date <='".$tdate."'";
		}else{
			$search_qry .= " and c.add_date >= '".$fdate."' and c.add_date <='".$tdate."'";
		}
	}
	if($company_revenue!=''){
		if($search_qry==''){
			$search_qry .= " c.company_revenue = '".$company_revenue."'";
		}else{
			$search_qry .= " and c.company_revenue = '".$company_revenue."'";
		}	
	}
	if($company_employee!=''){
		if($search_qry==''){
			$search_qry .= " c.company_employee = '".$company_employee."'";
		}else{
			$search_qry .= " and c.company_employee = '".$company_employee."'";
		}	
	}
	
	
	if($search_qry==''){
		$sql_query = "select c.company_id,c.company_name,c.company_website,c.status,c.add_date from " . TABLE_COMPANY_MASTER . " as c order by c.company_id desc";
	}else{
		$sql_query = "select c.company_id,c.company_name,c.company_website,c.status,c.add_date from " . TABLE_COMPANY_MASTER . " as c where  ". $search_qry." order by c.company_id desc";
	}
	$_SESSION['sess_admin_search_query'] = $sql_query;
}elseif($action=='AdvSearch'){
	$sql_query = $_SESSION['sess_admin_search_query'];
}else{
	$sql_query = "select c.company_id,c.company_name,c.company_website,c.status,c.add_date from " . TABLE_COMPANY_MASTER . " as c order by c.company_id desc";
}

/***************** FOR PAGIN ***********************/
$starting_point = $items_per_page * ($p - 1);
/****************** END PAGIN ***********************/
$main_page = 'company-master.php';

$exe_query=com_db_query($sql_query);
$num_rows=com_db_num_rows($exe_query);
$total_data = $num_rows;

/************ FOR PAGIN **************/
$sql_query .= " LIMIT $starting_point,$items_per_page";
$exe_data = com_db_query($sql_query);

$numRows = com_db_num_rows($exe_data);
/************ END ********************/


$cID = (isset($_GET['cID']) ? $_GET['cID'] : $select_data[0]);

    switch ($action) {
		
	  case 'delete':
	   		
			com_db_query("delete from " . TABLE_COMPANY_MASTER . " where company_id = '" . $cID . "'");
		 	com_redirect("company-master.php?p=" . $p . "&selected_menu=master&msg=" . msg_encode("Company deleted successfully"));
		
		break;
		
	  case 'alldelete':
	   		$company_id = $_POST['nid'];
			for($i=0; $i< sizeof($company_id) ; $i++){
				com_db_query("delete from " . TABLE_COMPANY_MASTER . " where company_id = '" . $company_id[$i] . "'");
			}
		 	com_redirect("company-master.php?p=" . $p . "&selected_menu=master&msg=" . msg_encode("Company deleted successfully"));
		
		break;	
		
	  case 'edit':
     		
	   		$query_edit=com_db_query("select * from " . TABLE_COMPANY_MASTER . " where company_id = '" . $cID . "'");
	  		$data_edit=com_db_fetch_array($query_edit);
			
			$company_name = com_db_output($data_edit['company_name']);
			$company_website = com_db_output($data_edit['company_website']);
			$company_logo = com_db_output($data_edit['company_logo']);
			$company_revenue = com_db_output($data_edit['company_revenue']);
			$company_employee = com_db_output($data_edit['company_employee']);
			$company_industry = com_db_output($data_edit['company_industry']);
			
			$address = com_db_output($data_edit['address']);
			$address2 = com_db_output($data_edit['address2']);
			$city = com_db_output($data_edit['city']);
			$state = com_db_output($data_edit['state']);
			$country = com_db_output($data_edit['country']);
			$zip_code = com_db_output($data_edit['zip_code']);
			
			$about_company = com_db_output($data_edit['about_company']);
			$leadership_page = com_db_output($data_edit['leadership_page']);
			$email_pattern = com_db_output($data_edit['email_pattern']); 
			
			$facebook_link = com_db_output($data_edit['facebook_link']);
			$linkedin_link = com_db_output($data_edit['linkedin_link']);
			$twitter_link = com_db_output($data_edit['twitter_link']);
			$googleplush_link = com_db_output($data_edit['googleplush_link']);
			
		break;	
		
		case 'editsave':
			$company_name = com_db_input($_POST['company_name']);
			$company_website = com_db_input($_POST['company_website']);
			$company_revenue = com_db_input($_POST['company_revenue']);
			$company_employee = com_db_input($_POST['company_employee']);
			$company_industry = com_db_input($_POST['company_industry']);
			$industry_id = $company_industry;
			$ind_group_id = com_db_GetValue("select parent_id from " . TABLE_INDUSTRY . " where industry_id = '".$company_industry."'");
			
			$address = com_db_input($_POST['address']);
			$address2 = com_db_input($_POST['address2']);
			$city = com_db_input($_POST['city']);
			$state = com_db_input($_POST['state']);
			$country = com_db_input($_POST['country']);
			$zip_code = com_db_input($_POST['zip_code']);

			$about_company = com_db_input($_POST['about_company']);
			$leadership_page = com_db_output($_POST['leadership_page']);
			$email_pattern = com_db_output($_POST['email_pattern']); 
			
			$facebook_link = com_db_input($_POST['facebook_link']);
			$linkedin_link = com_db_input($_POST['linkedin_link']);
			$twitter_link = com_db_input($_POST['twitter_link']);
			$googleplush_link = com_db_input($_POST['googleplush_link']);
			
			$modify_date = date('Y-m-d');
			
			$query = "update " . TABLE_COMPANY_MASTER . " set company_name = '" . $company_name ."', company_revenue = '".$company_revenue."', company_employee = '".$company_employee."', company_industry = '".$company_industry."',  ind_group_id = '".$ind_group_id."', industry_id = '".$industry_id."',
			leadership_page ='".$leadership_page."',email_pattern = '".$email_pattern."', address = '" . $address ."', address2 = '".$address2."', city = '".$city."', state = '".$state."', country = '".$country."', zip_code = '".$zip_code."',
			about_company = '".$about_company."', facebook_link = '".$facebook_link."', linkedin_link = '".$linkedin_link."', twitter_link = '".$twitter_link."', googleplush_link = '".$googleplush_link."', modify_date = '".$modify_date."' where company_id = '" . $cID . "'";
			com_db_query($query);
			
			$image = $_FILES['company_logo']['tmp_name'];
			  
			if($image!=''){
				if(is_uploaded_file($image)){
					$org_img = $_FILES['company_logo']['name'];
					$exp_file = explode("." , $org_img);
					$get_ext = $exp_file[count($exp_file) - 1];
					if(strtolower($get_ext)=="jpg" || strtolower($get_ext)=="gif" || strtolower($get_ext)=="jpge" || strtolower($get_ext)=="png"){
						$org_image_name=$exp_file[0].'-'.time().'.'.$get_ext;
						$destination_image = '../company_logo/' . $org_image_name;
						if(move_uploaded_file($image , $destination_image)){
								
							/*$org_size=getimagesize($destination_image);
							$width=$org_size[0];
							if($width > 193) {
								$t_width=193;
								$ex_width=$org_size[0]-193;	
								$per_width=$ex_width/$org_size[0]*100;
								$height=$org_size[1];
								$ex_heaight=$height/100*$per_width;
								$t_heaight=$height-$ex_heaight;
							} else {
								$t_width=$org_size[0];
								$t_heaight=$org_size[1];
							}
							
							$small_image='../team_photo/thumb/' . $org_image_name;
							make_thumb($destination_image, $small_image,$t_width,$t_heaight);
							*/
							$query = "UPDATE " . TABLE_COMPANY_MASTER . " SET company_logo = '" . $org_image_name . "' WHERE company_id = '" . $cID."'";
							com_db_query($query);
						}
					}	
				}	
			}
			
	  		com_redirect("company-master.php?p=". $p ."&cID=" . $cID . "&selected_menu=master&msg=" . msg_encode("Company update successfully"));
		 
		break;		
		
	  
		
	case 'addsave':
			$company_name = com_db_input($_POST['company_name']);
			$company_website = com_db_input($_POST['company_website']);
			$company_revenue = com_db_input($_POST['company_revenue']);
			$company_employee = com_db_input($_POST['company_employee']);
			$company_industry = com_db_input($_POST['company_industry']);
			$industry_id = $company_industry;
			$ind_group_id = com_db_GetValue("select parent_id from " . TABLE_INDUSTRY . " where industry_id = '".$company_industry."'");
			
			$address = com_db_input($_POST['address']);
			$address2 = com_db_input($_POST['address2']);
			$city = com_db_input($_POST['city']);
			$state = com_db_input($_POST['state']);
			$country = com_db_input($_POST['country']);
			$zip_code = com_db_input($_POST['zip_code']);
			
			$about_company = com_db_input($_POST['about_company']);
			$leadership_page = com_db_output($_POST['leadership_page']);
			$email_pattern = com_db_output($_POST['email_pattern']); 
			
			$facebook_link = com_db_input($_POST['facebook_link']);
			$linkedin_link = com_db_input($_POST['linkedin_link']);
			$twitter_link = com_db_input($_POST['twitter_link']);
			$googleplush_link = com_db_input($_POST['googleplush_link']);
					
			$publish = '0';
			$create_by = 'Admin';
			$status = '0';
			$add_date = date('Y-m-d');
			
			$query = "insert into " . TABLE_COMPANY_MASTER . "
			(company_name, company_website, company_revenue, company_employee, company_industry, ind_group_id, industry_id,leadership_page,email_pattern, address, address2, city, state, country, zip_code, about_company, facebook_link ,linkedin_link ,twitter_link, googleplush_link, add_date, create_by, status) 
			values ('$company_name', '$company_website', '$company_revenue', '$company_employee', '$company_industry', '$ind_group_id', '$industry_id', '$leadership_page','$email_pattern','$address', '$address2', '$city', '$state', '$country', '$zip_code','$about_company','$facebook_link','$linkedin_link','$twitter_link','$googleplush_link','$add_date','$create_by','$status')";
			com_db_query($query);
			
			$insert_id = com_db_insert_id();
			$image = $_FILES['company_logo']['tmp_name'];
			  
			if($image!=''){
				if(is_uploaded_file($image)){
					$org_img = $_FILES['company_logo']['name'];
					$exp_file = explode("." , $org_img);
					$get_ext = $exp_file[count($exp_file) - 1];
					if(strtolower($get_ext)=="jpg" || strtolower($get_ext)=="gif" || strtolower($get_ext)=="jpge" || strtolower($get_ext)=="png"){
						$org_image_name=$exp_file[0].'-'.time().'.'.$get_ext;
						$destination_image = '../company_logo/' . $org_image_name;
						if(move_uploaded_file($image , $destination_image)){
								
							/*$org_size=getimagesize($destination_image);
							$width=$org_size[0];
							if($width > 193) {
								$t_width=193;
								$ex_width=$org_size[0]-193;	
								$per_width=$ex_width/$org_size[0]*100;
								$height=$org_size[1];
								$ex_heaight=$height/100*$per_width;
								$t_heaight=$height-$ex_heaight;
							} else {
								$t_width=$org_size[0];
								$t_heaight=$org_size[1];
							}
							
							$small_image='../team_photo/thumb/' . $org_image_name;
							make_thumb($destination_image, $small_image,$t_width,$t_heaight);*/
							
							$query = "UPDATE " . TABLE_COMPANY_MASTER . " SET company_logo = '" . $org_image_name . "' WHERE company_id = '" . $insert_id ."'";
							com_db_query($query);
						}
					}	
				}	
			}
	  		com_redirect("company-master.php?p=" . $p . "&selected_menu=master&msg=" . msg_encode("New Company added successfully"));
		 
		break;	
		
	case 'detailes':
			$query_edit ="select c.company_name,c.company_website,c.company_logo,r.name as company_revenue,e.name as company_employee,
							i.title as company_industry,c.address,c.address2,c.city,s.short_name as state,
							ct.countries_name as country,c.zip_code,c.about_company,c.leadership_page,c.email_pattern,c.facebook_link,c.linkedin_link,c.twitter_link,c.googleplush_link,c.add_date from " 
							.TABLE_COMPANY_MASTER. " as c, " 
							.TABLE_REVENUE_SIZE." as r, "
							.TABLE_EMPLOYEE_SIZE." as e, "
							.TABLE_INDUSTRY." as i, "
							.TABLE_STATE." as s, "
							.TABLE_COUNTRIES." as ct							
							where c.company_revenue=r.id and c.company_employee=e.id and c.company_industry=i.industry_id and c.state=s.state_id and c.country=ct.countries_id and c.company_id = '" . $cID . "'";
			
			$query_edit_result=com_db_query($query_edit);
	  		$data_edit=com_db_fetch_array($query_edit_result);
			
			$company_name = com_db_output($data_edit['company_name']);
			$company_website = com_db_output($data_edit['company_website']);
			$company_logo = com_db_output($data_edit['company_logo']);
			$company_revenue = com_db_output($data_edit['company_revenue']);
			$company_employee = com_db_output($data_edit['company_employee']);
			$company_industry = com_db_output($data_edit['company_industry']);
						
			$address = com_db_output($data_edit['address']);
			$address2 = com_db_output($data_edit['address2']);
			$city = com_db_output($data_edit['city']);
			$state = com_db_output($data_edit['state']);
			$country = com_db_output($data_edit['country']);
			$zip_code = com_db_output($data_edit['zip_code']);
			
			$leadership_page = com_db_output($data_edit['leadership_page']);
			$email_pattern = com_db_output($data_edit['email_pattern']); 
			$about_company = com_db_output($data_edit['about_company']);
			
			$facebook_link = com_db_output($data_edit['facebook_link']);
			$linkedin_link = com_db_output($data_edit['linkedin_link']);
			$twitter_link = com_db_output($data_edit['twitter_link']);
			$googleplush_link = com_db_output($data_edit['googleplush_link']);
			
			$add_date =explode('-',$data_edit['add_date']);
			
		break;	
	case 'activate':
     		
	   		$status=$_GET['status'];
			if($status==0){
				$query = "update " . TABLE_COMPANY_MASTER . " set status = '1' where company_id = '" . $cID . "'";
			}else{
				$query = "update " . TABLE_COMPANY_MASTER . " set status = '0' where company_id = '" . $cID . "'";
			}	
			com_db_query($query);
	  		com_redirect("company-master.php?p=". $p ."&cID=" . $cID . "&selected_menu=master&msg=" . msg_encode("Company update successfully"));
			
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
	var agree=confirm("Company will be deleted. \n Do you want to continue?");
	if (agree)
		window.location = "company-master.php?selected_menu=master&cID=" + nid + "&p=" + p + "&action=delete";
	else
		window.location = "company-master.php?selected_menu=master&cID=" + nid + "&p=" + p ;
}

function CheckAll(numRows){
	if(document.getElementById('all').checked){
		for(i=1; i<=numRows; i++){
			var company_id='company_id-'+ i;
			document.getElementById(company_id).checked=true;
		}
	} else {
		for(i=1; i<=numRows; i++){
			var company_id='company_id-'+ i;
			document.getElementById(company_id).checked=false;
		}
	}
}

function AllDelete(numRows){

	var flg=0;
	for(i=1; i<=numRows; i++){
			var company_id='company_id-'+ i;
			if(document.getElementById(company_id).checked){
				flg=1;
			}	
		}
	if(flg==0){
		alert("Please checked atlist one checkbox for delete.");
		document.getElementById('company_id-1').focus();
		return false;
	} else {
		var agree=confirm("Company will be deleted. \n Do you want to continue?");
		if (agree)
			 document.topicform.submit();
		else
			window.location = "company-master.php?selected_menu=master";
	}	

}

function confirm_artivate(nid,p,status){
	if(status=='1'){
		var msg="Company will be active. \n Do you want to continue?";
	}else{
		var msg="Company will be Inactive. \n Do you want to continue?";
	}
	var agree=confirm(msg);
	if (agree)
		window.location = "company-master.php?selected_menu=master&cID=" + nid + "&p=" + p + "&status=" + status + "&action=activate";
	else
		window.location = "company-master.php?selected_menu=master&cID=" + nid + "&p=" + p ;
}

function CompanySearch(){
	window.location ='company-master.php?action=CompanySearch&selected_menu=master';
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
		<form name="frmSearch" id="frmSearch" method="post" action="company-master.php?selected_menu=master&action=CompanySearchResult">
		<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1">
		  <tr>
			<td align="left" colspan="2" valign="top"><img src="images/specer.gif" width="1" height="50" alt="" title="" /> </td>
		  </tr>
          <tr><td colspan="2">&nbsp;</td></tr>
		  <tr>
			<td align="left" valign="top" >Company Name:</td>
			<td align="left" valign="top"><input name="search_company_name" id="search_company_name" /></td>
		  </tr>
		  <tr>
			<td align="left" valign="top">Company Url:</td>
			<td align="left" valign="top"><input name="search_company_url" id="search_company_url" /></td>
		  </tr>
		  
		  <tr>
			<td align="left" valign="top">Industry:</td>
			<td align="left" valign="top">
				<?php
				$industry_result = com_db_query("select * from " . TABLE_INDUSTRY ." where status='0' and parent_id = '0' order by title");
				?>
				<select name="search_industry" id="search_industry" >
					<option value="">All</option>
					<?php
					while($indus_row = com_db_fetch_array($industry_result)){
					?>
					<optgroup label="<?=$indus_row['title']?>">
					<?=selectComboBox("select industry_id,title from ". TABLE_INDUSTRY ." where status='0' and parent_id ='".$indus_row['industry_id']."' order by title" ,"");?>
					</optgroup>
					<? } ?>
					
				</select>
			</td>
		  </tr>
		  <tr>
			<td align="left" valign="top">State:</td>
			<td align="left" valign="top">
				<select name="search_state" id="search_state" >
					<option value="">All</option>
					<?=selectComboBox("select state_id,short_name from ". TABLE_STATE ." where country_id ='223'" ,"");?>
				</select>	
			</td>
		  </tr>
          <tr>
			<td align="left" valign="top">Country:</td>
			<td align="left" valign="top">
				<select name="search_country" id="search_country" >
					<option value="">All</option>
					<?=selectComboBox("select countries_id,countries_name from ". TABLE_COUNTRIES ." where countries_name='United States'" ,"");?>
					<?=selectComboBox("select countries_id,countries_name from ". TABLE_COUNTRIES ." order by countries_name" ,"");?>
				</select>	
			</td>
		  </tr>
		  
		  <tr>
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
		  </tr>
		  
		  <tr>
			<td align="left" valign="top">Size ($ Revenue):</td>
			<td align="left" valign="top">
				<select name="search_company_revenue" id="search_company_revenue"/>
                	<option value="">All</option>
					<?=selectComboBox("select id,name from ".TABLE_REVENUE_SIZE." where status='0' order by from_range",'')?>
                </select>	
			</td>
		  </tr>
          <tr>
			<td align="left" valign="top">Size (Employees):</td>
			<td align="left" valign="top">
				<select name="search_company_employee" id="search_company_employee" />
                	<option value="">All</option>
					<?=selectComboBox("select id,name from ".TABLE_EMPLOYEE_SIZE." where status='0' order by from_range",'')?>
                </select>	
			</td>
		  </tr>
		   <tr>
			<td align="center" valign="top">&nbsp;</td>
			<td align="center" valign="top">&nbsp;</td>
		  </tr>
		  <tr>
			<td align="center" valign="top">&nbsp;</td>
		  	<td align="left" valign="top"><input type="submit" value="Search" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='company-master.php?selected_menu=master'" /></td>
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
            <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="19%" align="left" valign="middle" class="heading-text">Company Manager</td>
                  <td width="51%" align="left" valign="middle" class="message"><?=$msg?></td>
				  <td width="3%" align="right" valign="middle"><a href="#"><img src="images/search-icon.jpg" border="0" width="25" height="28"  alt="Search Company" title="Search Company" onclick="CompanySearch('CompanySearch');"  /></a></td>
				  <td width="6%" align="left" valign="middle" class="nav-text">Search</td>
                  <td width="4%" align="right" valign="middle"><a href="#"><img src="images/add-icon.jpg" border="0" width="25" height="28" alt="Add Company" title="Add Company" onclick="window.location='company-master.php?action=add&selected_menu=master'"  /></a></td>
                  <td width="7%" align="left" valign="middle" class="nav-text">Add New </td>
                  <td width="4%" align="right" valign="middle"><a href="#"><img src="images/delete-icon.jpg" border="0" width="25" height="28"  alt="Delete Company" title="Delete Company" onclick="AllDelete('<?=$numRows?>');"  /></a></td>
                  <td width="6%" align="left" valign="middle" class="nav-text">Delete</td>
                </tr>
              </table></td>
          </tr>
       
          <tr>
            <td align="left" valign="top" class="right-bar-content-border">
			<form name="topicform" action="company-master.php?action=alldelete&selected_menu=master" method="post">
			<table width="100%" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="27" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-title-text">#</span></td>
				<td width="37" height="30" align="center" valign="middle" class="right-border">
				<input type="checkbox" name="all" id="all" onclick="CheckAll('<?=$numRows?>');" /></td>
				<td width="250" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Company Name</span> </td>
				<td width="250" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Company URL</span> </td>
				<td width="106" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Add Date</span> </td>
                <td width="244" height="30" align="center" valign="middle" class="left-border"><div align="center"><span class="right-box-title-text">Action</span></div></td>
			  </tr>
			<?php
			
			if($total_data>0) {
				$i=$starting_point+1;
				while ($data_sql = com_db_fetch_array($exe_data)) {
				//$effective_date = $data_sql['effective_date'];
				$add_date = $data_sql['add_date'];
				$status = $data_sql['status'];
				$subscription_name = com_db_GetValue("select subscription_name from " . TABLE_SUBSCRIPTION . " where sub_id='".$data_sql['subscription_id']."'");
			?>          
			  <tr>
				<td height="30" align="center" valign="middle" class="right-border-left"><?=$i;?></td>
				<td height="30" align="center" valign="middle" class="right-border"><input type="checkbox" id="company_id-<?=$i;?>" name="nid[]" value="<?=$data_sql['company_id'];?>" /></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><a href="company-master.php?action=detailes&p=<?=$p?>&selected_menu=master&cID=<?=$data_sql['company_id'];?>"><?=com_db_output($data_sql['company_name'])?></a></td>
                <td height="30" align="left" valign="middle" class="right-border-text"><?=com_db_output($data_sql['company_website'])?></td>
                <td height="30" align="center" valign="middle" class="right-border"><?=$add_date;?></td>
				<td height="30" align="center" valign="middle" class="left-border">
					<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr> 
					  	<td width="37%" align="center" valign="middle"><a href="#"><img src="images/icon/xls-small-icon.gif" width="16" height="16" alt="" title="" border="0" onclick="Download_XLS('<?=$data_sql['company_id'];?>');" /></a><br />
					   	  .xls&nbsp;Download</td>
					  	<?php if($status==0){ ?>
					   	<td width="18%" align="center" valign="middle"><a href="#"><img src="images/icon/active-icon.gif" width="16" height="16" alt="" title="" border="0" onclick="confirm_artivate('<?=$data_sql['company_id'];?>','<?=$p;?>','<?=$status;?>');" /></a><br />
					   	  Status</td>
					   	<?php } elseif($status==1){ ?>
					   	<td width="16%" align="center" valign="middle"><a href="#"><img src="images/icon/inactive-icon.gif" width="16" height="16" alt="" title="" border="0" onclick="confirm_artivate('<?=$data_sql['company_id'];?>','<?=$p;?>','<?=$status;?>');" /></a><br />
					   	  Status</td>
						<?php } ?>
						<td width="12%" align="center" valign="middle"><a href="#"><img src="images/small-edit-icon.gif" width="16" height="16" alt="Edit" title="Edit" border="0" onclick="window.location='company-master.php?selected_menu=master&p=<?=$p;?>&cID=<?=$data_sql['company_id'];?>&action=edit'" /></a><br />
						  Edit</td>
						<td width="17%" align="center" valign="middle"><a href="#"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" title="Delete" border="0" onclick="confirm_del('<?=$data_sql['company_id'];?>','<?=$p;?>')" /></a><br />
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
	var cwebsite=document.getElementById('company_website').value;
	
	if(cwebsite==''){
		alert("Please enter company website name.");
		document.getElementById('company_website').focus();
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
		 <form name="frmDataEdit" id="frmDataEdit" method="post" enctype="multipart/form-data" action="company-master.php?action=editsave&selected_menu=master&cID=<?=$cID;?>&p=<?=$p;?>" onsubmit="return chk_form();">
			<table width="95%" align="center" cellpadding="5" cellspacing="5" border="0">
			
            <tr>
			  <td align="left">
              	 <div id="div_company" style="display:block;">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Company Website:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="company_website" id="company_website" size="30" readonly="readonly" value="<?=$company_website;?>"/>
                      </td>
                    </tr>
					<tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp; Company Name:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="company_name" id="company_name" size="30" value="<?=$company_name;?>"/>
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Company Logo:</td>
                      <td width="75%" align="left" valign="top">
                      <img src="../company_logo/<?=$company_logo?>" alt="Logo" width="100" height="100"/><br />
                      <input type="file" name="company_logo" id="company_logo" /></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Size ($Revenue):</td>
                      <td width="75%" align="left" valign="top">
                     	<select name="company_revenue" id="company_revenue" style="width:206px;"/>
						<?=selectComboBox("select id,name from ".TABLE_REVENUE_SIZE." where status='0' order by from_range",$company_revenue)?>
						<option value="Any">Any</option>
						</select>
					 </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Size (Employees):</td>
                      <td width="75%" align="left" valign="top">
                      	<select name="company_employee" id="company_employee" style="width:206px;"/>
						<?=selectComboBox("select id,name from ".TABLE_EMPLOYEE_SIZE." where status='0' order by from_range",$company_employee)?>
						<option value="Any">Any</option>
						</select>
					  </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Industry:</td>
                      <td width="75%" align="left" valign="top">
                      	<?php
						$industry_result = com_db_query("select * from " . TABLE_INDUSTRY ." where parent_id = '0' and status='0' order by title");
						?>
						<select name="company_industry" id="company_industry" multiple="multiple">
							<option value="">All</option>
							<?php
							while($indus_row = com_db_fetch_array($industry_result)){
							?>
							<optgroup label="<?=$indus_row['title']?>">
							<?=selectComboBox("select industry_id,title from ". TABLE_INDUSTRY ." where parent_id ='".$indus_row['industry_id']."' and status='0' order by title" ,$company_industry);?>
							</optgroup>
							<? } ?>
							<option value="Any">Any</option>
						</select>
					  </td>	
                    </tr>
					<tr>
                      <td align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Leadership Page:</td>
                      <td align="left" valign="top"><input type="text" name="leadership_page" id="leadership_page" size="30" value="<?=$leadership_page?>" /></td>
                    </tr>
                    <tr>
                      <td align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Email Pattern:</td>
                      <td align="left" valign="top"><input type="text" name="email_pattern" id="email_pattern" size="30" value="<?=$email_pattern?>" /></td>
                    </tr>
                  </table>
                  </div>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a"><a href="javascript:CompanyDivControl('div_location');">>> Location</a></td>	
			</tr>
            <tr>
			  <td align="left">
              	<div id="div_location" style="display:block;">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Address:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="address" id="address" size="30" value="<?=$address;?>"/>
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Address 2:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="address2" id="address2" size="30" value="<?=$address2;?>"/>
                      </td>
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;City:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="city" id="city" size="30" value="<?=$city;?>"/>
                      </td>	
                    </tr>
					<tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Country:</td>
                      <td width="75%" align="left" valign="top">
					   <select name="country" id="country" style="width:206px;" onchange="StateChangeEdit('country');"/>
					   	<?=selectComboBox("select countries_id,countries_name from ". TABLE_COUNTRIES ." where countries_id='223'",$country);?>
						<?=selectComboBox("select countries_id,countries_name from ".TABLE_COUNTRIES." order by countries_name",$country)?>
						<option value="Any">Any</option>
						</select>
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;State:</td>
                      <td width="75%" align="left" valign="top">
					  <div id="div_state_edit">
						<select name="state" id="state" style="width:206px;"/>
						<?=selectComboBox("select state_id,short_name from ".TABLE_STATE." where country_id='".$country."' order by short_name",$state)?>
						<option value="Any">Any</option>
						</select>
					  </div> 	
                      </td>	
                    </tr>
                    
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Zip Code:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="zip_code" id="zip_code" size="30" value="<?=$zip_code;?>"/>
                      </td>
                    </tr>
                  </table>
                  </div>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a"><a href="javascript:CompanyDivControl('div_change_details');">>> Company Details</a></td>	
			</tr>
            <tr>
			  <td align="left">
              	<div id="div_change_details" style="display:block;">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                
                    <tr>
                      <td width="26%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;About the Company?:</td>
                      <td width="74%" align="left" valign="top">
                        <textarea  id="about_company" name="about_company"><?=$about_company?></textarea>
						<script type="text/javascript">
                        //<![CDATA[
                            CKEDITOR.replace('about_company');
                        //]]>
                        </script>
                      </td>
                     </tr>
					
					
                  </table>
                  </div>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a">>> Social Media Profiles</td>	
			</tr>
            <tr>
			  <td align="left">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Facebook Link:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="facebook_link" id="facebook_link" size="30" value="<?=$facebook_link?>" /></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;LinkedIn Link:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="linkedin_link" id="linkedin_link" size="30" value="<?=$linkedin_link?>" /></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Twitter Link:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="twitter_link" id="twitter_link" size="30" value="<?=$twitter_link?>" /></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Google+ Link:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="googleplush_link" id="googleplush_link" size="30" value="<?=$googleplush_link?>" /></td>	
                    </tr>
                  </table>
              </td>	
			</tr>
            <tr>
            	<td align="center">
                	<table width="50%" border="0" cellpadding="4" cellspacing="4">
                    	<tr>
                        	<td><input type="submit" value="Update Company" class="submitButton" /></td>
                            <td><input type="button" class="submitButton" value="cancel" onclick="window.location='company-master.php?p=<?=$p;?>&uID=<?=$uID;?>&selected_menu=master'" /></td>
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
	var fname=document.getElementById('company_website').value;
	if(fname==''){
		alert("Please enter company website name.");
		document.getElementById('company_website').focus();
		return false;
	}
}

</script>
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">Company Manager :: Add Company </td>
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="left" valign="top" class="right-border-box">
		 <!--start iner table  -->
		 <form name="DateTest" method="post" enctype="multipart/form-data" action="company-master.php?action=addsave&selected_menu=master&cID=<?=$cID;?>&p=<?=$p;?>" onsubmit="return chk_form_Add();">
		  <table width="95%" align="left" cellpadding="5" cellspacing="5" border="0">
			
            <tr>
			  <td align="left" class="heading-text-a">>> Company</td>	
			</tr>
            <tr>
			  <td align="left">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Company Website:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="company_website" id="company_website" size="30" />
                      	<div id="div_company_website" style="display:none;color:#993300;font-family:Verdana, Arial, Helvetica, sans-serif;">Please wait...</div>					  </td>	
                    </tr>
					<tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Company Name:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="company_name" id="company_name" size="30" value="" /> </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Company Logo:</td>
                      <td width="75%" align="left" valign="top"><input type="file" name="company_logo" id="company_logo" /></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Size ($Revenue):</td>
                      <td width="75%" align="left" valign="top">
                        <div id="div_company_revenue">
							<select name="company_revenue" id="company_revenue" style="width:206px;">
							<?=selectComboBox("select id,name from ".TABLE_REVENUE_SIZE." where status='0' order by from_range","")?>
							<option value="Any">Any</option>
							</select>
						</div>                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Size (Employees):</td>
                      <td width="75%" align="left" valign="top">
                        <div id="div_company_employee">
							<select name="company_employee" id="company_employee" style="width:206px;">
							<?=selectComboBox("select id,name from ".TABLE_EMPLOYEE_SIZE ." where status='0' order by from_range","")?>
							<option value="Any">Any</option>
							</select>
						 </div>					  </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Industry:</td>
                      <td width="75%" align="left" valign="top">
                        <div id="div_company_industry">
						<?php
						$industry_result = com_db_query("select * from " . TABLE_INDUSTRY ." where status='0' and parent_id = '0' order by title");
						?>
						<select name="company_industry" id="company_industry" >
							<option value="">All</option>
							<?php
							while($indus_row = com_db_fetch_array($industry_result)){
							?>
							<optgroup label="<?=$indus_row['title']?>">
							<?=selectComboBox("select industry_id,title from ". TABLE_INDUSTRY ." where status='0' and parent_id ='".$indus_row['industry_id']."' order by title" ,"");?>
							</optgroup>
							<? } ?>
							<option value="Any">Any</option>
						</select>
						</div>                      </td>	
                    </tr>
                    <tr>
                      <td align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Leadership Page:</td>
                      <td align="left" valign="top"><input type="text" name="leadership_page" id="leadership_page" size="30" value="" /></td>
                    </tr>
                    <tr>
                      <td align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Email Pattern:</td>
                      <td align="left" valign="top"><input type="text" name="email_pattern" id="email_pattern" size="30" value="" /></td>
                    </tr>
                  </table>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a">>> Location</td>	
			</tr>
            <tr>
			  <td align="left">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Address:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="address" id="address" size="30" value="" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Address 2:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="address2" id="address2" size="30" value="" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;City:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="city" id="city" size="30" value="" />
                      </td>	
                    </tr>
					<tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Country:</td>
                      <td width="75%" align="left" valign="top">
						<div id="div_country">
							<select name="country" id="country" style="width:206px;" onchange="StateChangeAdd('country');">
							<?=selectComboBox("select countries_id,countries_name from ".TABLE_COUNTRIES."  where countries_id=223",'223')?>
							<?=selectComboBox("select countries_id,countries_name from ".TABLE_COUNTRIES."  where countries_id<>223 order by countries_name",'')?>
							<option value="Any">Any</option>
							</select>
						</div>
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;State:</td>
                      <td width="75%" align="left" valign="top">
					    <div id="div_state_add">
							<select name="state" id="state" style="width:206px;">
							<?=selectComboBox("select state_id,short_name from ".TABLE_STATE." order by short_name","")?>
							<option value="Any">Any</option>
							</select>
						</div>
                      </td>	
                    </tr>
                    
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Zip Code:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="zip_code" id="zip_code" size="30" value="" />
                      </td>	
                    </tr>
                  </table>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a">>> Company Details</td>	
			</tr>
            <tr>
			  <td align="left">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;About the Company?:</td>
                      <td width="75%" align="left" valign="top">
                        <textarea  id="about_company" name="about_company"></textarea>
						<script type="text/javascript">
                        //<![CDATA[
                            CKEDITOR.replace('about_company');
                        //]]>
                        </script>
                      </td>	
                    </tr>
                   
                  </table>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a">>> Social Media Profiles</td>	
			</tr>
            <tr>
			  <td align="left">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Facebook Link:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="facebook_link" id="facebook_link" size="30" value="" /></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;LinkedIn Link:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="linkedin_link" id="linkedin_link" size="30" value="" /></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Twitter Link:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="twitter_link" id="twitter_link" size="30" value="" /></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Google+ Link:</td>
                      <td width="75%" align="left" valign="top"><input type="text" name="googleplush_link" id="googleplush_link" size="30" value="" /></td>	
                    </tr>
                  </table>
              </td>	
			</tr>
            <tr>
            	<td align="center">
                	<table width="50%" border="0" cellpadding="4" cellspacing="4">
                    	<tr><td><input type="submit" value="Add Company" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='company-master.php?p=<?=$p;?>&uID=<?=$uID;?>&selected_menu=master'" /></td></tr>
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
                  <td width="50%" align="left" valign="middle" class="heading-text">Company Manager :: Company Details </td>
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
			  <td align="left" class="heading-text-a"><a href="javascript:CompanyDivControl('div_company');">>> Company</a></td>	
			</tr>
            <tr>
			  <td align="left">
              	 <div id="div_company" style="display:block;">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Company Website:</td>
                      <td width="75%" align="left" valign="top"><?=$company_website;?></td>	
                    </tr>
					<tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Company Name:</td>
                      <td width="75%" align="left" valign="top"><?=$company_name;?></td>	
                    </tr>
                     <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Company Logo:</td>
                      <td width="75%" align="left" valign="top">
                      <img src="../company_logo/<?=$company_logo?>" alt="Logo" width="100" height="100" />
                     </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Size ($Revenue):</td>
                      <td width="75%" align="left" valign="top"><?=$company_revenue;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Size (Employees):</td>
                      <td width="75%" align="left" valign="top"><?=$company_employee;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Industry:</td>
                      <td width="75%" align="left" valign="top"><?=$company_industry;?></td>	
                    </tr>
					 <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Leadership Page:</td>
                      <td width="75%" align="left" valign="top"><?=$leadership_page;?></td>	
                    </tr>
					 <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Email Pattern:</td>
                      <td width="75%" align="left" valign="top"><?=$email_pattern;?></td>	
                    </tr>
                  </table>
                  </div>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a"><a href="javascript:CompanyDivControl('div_location');">>> Location</a></td>	
			</tr>
            <tr>
			  <td align="left">
              	<div id="div_location" style="display:block;">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Address:</td>
                      <td width="75%" align="left" valign="top"><?=$address;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Address 2:</td>
                      <td width="75%" align="left" valign="top"><?=$address2;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;City:</td>
                      <td width="75%" align="left" valign="top"><?=$city;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;State:</td>
                      <td width="75%" align="left" valign="top"><?=$state;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Country:</td>
                      <td width="75%" align="left" valign="top"><?=$country;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Zip Code:</td>
                      <td width="75%" align="left" valign="top"><?=$zip_code;?></td>	
                    </tr>
                  </table>
                  </div>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a"><a href="javascript:CompanyDivControl('div_change_details');">>> Company Details</a></td>	
			</tr>
            <tr>
			  <td align="left">
              	<div id="div_change_details" style="display:block;">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                   
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;About the Company?:</td>
                      <td width="75%" align="left" valign="top"><?=$about_company;?></td>	
                    </tr>
                  </table>
                  </div>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a">>> Social Media Profiles</td>	
			</tr>
            <tr>
			  <td align="left">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Facebook Link:</td>
                      <td width="75%" align="left" valign="top"><?=$facebook_link?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;LinkedIn Link:</td>
                      <td width="75%" align="left" valign="top"><?=$linkedin_link?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Twitter Link:</td>
                      <td width="75%" align="left" valign="top"><?=$twitter_link?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Google+ Link:</td>
                      <td width="75%" align="left" valign="top"><?=$googleplush_link?></td>	
                    </tr>
                  </table>
              </td>	
			</tr>			
			</table>
		 <!-- end inner table -->
		  </td>
		 </tr>
		 <tr>
            	<td align="center">
                	<table width="50%" border="0" cellpadding="4" cellspacing="4">
                    	<tr><td><input type="button" class="submitButton" value="Back" onclick="window.location='company-master.php?p=<?=$p;?>&selected_menu=master'" /></td></tr>
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