<?php
require('includes/include_top.php');

$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 20;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$action = (isset($_REQUEST['action']) ? $_REQUEST['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';
$show_by = (isset($_REQUEST['show_by']) ? $_REQUEST['show_by'] : 'All');
/*if($show_by=='All'){
	$sql_query = "select * from " . TABLE_CONTACT . " order by contact_id desc";
}elseif($show_by=='Admin'){
	$sql_query = "select * from " . TABLE_CONTACT . " where create_by='".$show_by."' or create_by='' order by contact_id desc";
}else{
	$sql_query = "select * from " . TABLE_CONTACT . " where create_by='".$show_by."' order by contact_id desc";
}	*/
//$sql_query = "select * from " . TABLE_CONTACT . " where status='1' and create_by !='Admin' and create_by!='' order by contact_id desc";
$sql_query = "select c.contact_id,c.first_name,c.middle_name,c.last_name,c.company_name,c.effective_date,c.status,c.new_title from " . TABLE_CONTACT . " as c where  c.status='1' and c.create_by !='Admin' and c.create_by!='' order by c.contact_id desc";
/***************** FOR PAGIN ***********************/
$starting_point = $items_per_page * ($p - 1);
/****************** END PAGIN ***********************/
$main_page = 'contact-report.php';

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
	   		
			com_db_query("delete from " . TABLE_CONTACT . " where contact_id = '" . $cID . "'");
		 	com_redirect("contact-report.php?p=" . $p . "&show_by=".$show_by."&selected_menu=contact&msg=" . msg_encode("Contact deleted successfully"));
		
		break;
		
	  case 'alldelete':
	   		$contact_id = $_POST['nid'];
			for($i=0; $i< sizeof($contact_id) ; $i++){
				com_db_query("delete from " . TABLE_CONTACT . " where contact_id = '" . $contact_id[$i] . "'");
			}
		 	com_redirect("contact-report.php?p=" . $p . "&show_by=".$show_by."&selected_menu=contact&msg=" . msg_encode("Contact deleted successfully"));
		
		break;
			
	  case 'allactivate':
	   		$contact_id = $_POST['nid'];
			for($i=0; $i< sizeof($contact_id) ; $i++){
				com_db_query("update " . TABLE_CONTACT . " set status='0' where contact_id = '" . $contact_id[$i] . "'");
			}
		 	com_redirect("contact-report.php?p=" . $p . "&show_by=".$show_by."&selected_menu=contact&msg=" . msg_encode("Contact publish successfully"));
		
		break;	
		 	
	  case 'edit':
     		
	   		$query_edit=com_db_query("select * from " . TABLE_CONTACT . " where contact_id = '" . $cID . "'");
	  		$data_edit=com_db_fetch_array($query_edit);
			
			$first_name = com_db_output($data_edit['first_name']);
			$middle_name = com_db_output($data_edit['middle_name']);
			$last_name = com_db_output($data_edit['last_name']);
			$new_title = com_db_output($data_edit['new_title']);
			
			$email = com_db_output($data_edit['email']);
			$phone = com_db_output($data_edit['phone']);
			
			$company_name = com_db_output($data_edit['company_name']);
			$company_website = com_db_output($data_edit['company_website']);
			$company_revenue = com_db_output($data_edit['company_revenue']);
			$company_employee = com_db_output($data_edit['company_employee']);
			$company_industry = com_db_output($data_edit['company_industry']);
			
			$address = com_db_output($data_edit['address']);
			$address2 = com_db_output($data_edit['address2']);
			$city = com_db_output($data_edit['city']);
			$state = com_db_output($data_edit['state']);
			$country = com_db_output($data_edit['country']);
			$zip_code = com_db_output($data_edit['zip_code']);
			
			$ann_date = explode('-',$data_edit['announce_date']);
			$announce_date = $ann_date[1].'/'.$ann_date[2].'/'.$ann_date[0];
			$eff_date = explode('-',$data_edit['effective_date']);
			$effective_date = $eff_date[1].'/'.$eff_date[2].'/'.$eff_date[0];
			
			$source = com_db_output($data_edit['source']);
			$headline = com_db_output($data_edit['headline']);
			//$full_body = com_db_output($data_edit['full_body']);
			$full_body = preg_replace('/<br( )?(\/)?>/i', "\r", $data_edit['full_body']);
			$short_url = com_db_output($data_edit['short_url']);
			$movement_type = com_db_output($data_edit['movement_type']);
			$what_happened = com_db_output($data_edit['what_happened']);
			$about_person = com_db_output($data_edit['about_person']);
			$about_company = com_db_output($data_edit['about_company']);
			$more_link = com_db_output($data_edit['more_link']);
			
		break;	
		
		case 'editsave':
			
			$first_name = com_db_input($_POST['first_name']);
			$middle_name = com_db_input($_POST['middle_name']);
			$last_name = com_db_input($_POST['last_name']);
			$new_title = com_db_input($_POST['new_title']);
			
			$email = com_db_input($_POST['email']);
			$phone = com_db_input($_POST['phone']);
			
			$company_name = com_db_input($_POST['company_name']);
			$company_website = com_db_input($_POST['company_website']);
			$company_revenue = com_db_input($_POST['company_revenue']);
			$company_employee = com_db_input($_POST['company_employee']);
			$company_industry = com_db_input($_POST['company_industry']);
			$industry_id = com_db_GetValue("select industry_id from " . TABLE_INDUSTRY . " where title = '".$company_industry."'");
			$ind_group_id = com_db_GetValue("select parent_id from " . TABLE_INDUSTRY . " where title = '".$company_industry."'");
			
			$address = com_db_input($_POST['address']);
			$address2 = com_db_input($_POST['address2']);
			$city = com_db_input($_POST['city']);
			$state = com_db_input($_POST['state']);
			$country = com_db_input($_POST['country']);
			$zip_code = com_db_input($_POST['zip_code']);
			
			$ann_date = explode('/',$_POST['announce_date']);//mmddyyyy
			$announce_date = $ann_date[2].'-'.$ann_date[0].'-'.$ann_date[1];
			$eff_date = explode('/',$_POST['effective_date']);
			$effective_date = $eff_date[2].'-'.$eff_date[0].'-'.$eff_date[1];
			$source = com_db_input($_POST['source']);
			$headline = com_db_input($_POST['headline']);
			$rep   = array("\r\n", "\n","\r");
			$full_body = str_replace($rep,'<br />',$_POST['full_body']);
			//$full_body = com_db_input($_POST['full_body']);
			$short_url = com_db_input($_POST['short_url']);
			$movement_type = com_db_input($_POST['movement_type']);
			$what_happened = com_db_input($_POST['what_happened']);
			$about_person = com_db_input($_POST['about_person']);
			$about_company = com_db_input($_POST['about_company']);
			$more_link = com_db_input($_POST['more_link']);
			
			$modify_date = date('Y-m-d');
			
			$query = "update " . TABLE_CONTACT . " set first_name = '" . $first_name . "', middle_name ='".$middle_name."', last_name = '" . $last_name . "', new_title = '" . $new_title . "', email = '".$email."', phone = '".$phone."', 
			company_name = '" . $company_name ."', company_website = '".$company_website."', company_revenue = '".$company_revenue."', company_employee = '".$company_employee."', company_industry = '".$company_industry."',  ind_group_id = '".$ind_group_id."', industry_id = '".$industry_id."',
			address = '" . $address ."', address2 = '".$address2."', city = '".$city."', state = '".$state."', country = '".$country."', zip_code = '".$zip_code."',
			announce_date = '" . $announce_date ."', effective_date = '".$effective_date."', source = '".$source."', headline = '".$headline."', full_body = '".$full_body."', short_url = '".$short_url."',
			movement_type = '" . $movement_type ."', what_happened = '".$what_happened."', about_person = '".$about_person."', about_company = '".$about_company."', more_link = '".$more_link."',
			modify_date = '".$modify_date."'  where contact_id = '" . $cID . "'";
			com_db_query($query);
	  		com_redirect("contact-report.php?p=". $p ."&cID=" . $cID . "&show_by=".$show_by."&selected_menu=contact&msg=" . msg_encode("Contact update successfully"));
		 
		break;		
		
	  
	
		
	case 'detailes':
			$details_query ="select c.first_name,c.middle_name,c.last_name,c.new_title,c.email,c.phone,c.contact_url,
							c.company_name,c.company_website,r.name as company_revenue,e.name as company_employee,
							i.title as company_industry,c.address,c.address2,c.city,s.short_name as state,
							ct.countries_name as country,c.zip_code,c.announce_date,c.effective_date,
							so.source as source,c.headline,c.full_body,c.short_url,m.name as movement_type,
							c.what_happened,c.about_person,c.about_company,c.more_link,c.add_date from " 
							.TABLE_CONTACT. " as c, " 
							.TABLE_REVENUE_SIZE." as r, "
							.TABLE_EMPLOYEE_SIZE." as e, "
							.TABLE_INDUSTRY." as i, "
							.TABLE_STATE." as s, "
							.TABLE_COUNTRIES." as ct, "
							.TABLE_SOURCE." as so, "
							.TABLE_MANAGEMENT_CHANGE." as m 
							where c.company_revenue=r.id and c.company_employee=e.id and c.company_industry=i.industry_id and c.state=s.state_id and c.country=ct.countries_id and c.source=so.id and c.movement_type=m.id and c.contact_id = '" . $cID . "'";
			//$query_edit=com_db_query("select * from " . TABLE_CONTACT . " where contact_id = '" . $cID . "'");
			$query_edit=com_db_query($details_query);
	  		$data_edit=com_db_fetch_array($query_edit);
			
			$first_name = com_db_output($data_edit['first_name']);
			$middle_name = com_db_output($data_edit['middle_name']);
			$last_name = com_db_output($data_edit['last_name']);
			$new_title = com_db_output($data_edit['new_title']);
			
			$email = com_db_output($data_edit['email']);
			$phone = com_db_output($data_edit['phone']);
			
			$company_name = com_db_output($data_edit['company_name']);
			$company_website = com_db_output($data_edit['company_website']);
			$company_revenue = com_db_output($data_edit['company_revenue']);
			$company_employee = com_db_output($data_edit['company_employee']);
			$company_industry = com_db_output($data_edit['company_industry']);
						
			$address = com_db_output($data_edit['address']);
			$address2 = com_db_output($data_edit['address2']);
			$city = com_db_output($data_edit['city']);
			$state = com_db_output($data_edit['state']);
			$country = com_db_output($data_edit['country']);
			$zip_code = com_db_output($data_edit['zip_code']);
			
			$announce_date = com_db_output($data_edit['announce_date']);
			$effective_date = com_db_output($data_edit['effective_date']);
			$source = com_db_output($data_edit['source']);
			$headline = com_db_output($data_edit['headline']);
			$full_body = com_db_output($data_edit['full_body']);
			$short_url = com_db_output($data_edit['short_url']);
			$movement_type = com_db_output($data_edit['movement_type']);
			$what_happened = com_db_output($data_edit['what_happened']);
			$about_person = com_db_output($data_edit['about_person']);
			$about_company = com_db_output($data_edit['about_company']);
			$more_link = com_db_output($data_edit['more_link']);
			
			$add_date =explode('-',$data_edit['add_date']);
			$post_date = date('d, M Y',mktime(0,0,0,date($add_date[1]),date($add_date[2]),date($add_date[0])));
			
		break;	
	case 'activate':
     		
	   		$status=$_GET['status'];
			if($status==0){
				$query = "update " . TABLE_CONTACT . " set status = '1' where contact_id = '" . $cID . "'";
			}else{
				$query = "update " . TABLE_CONTACT . " set status = '0' where contact_id = '" . $cID . "'";
			}	
			com_db_query($query);
	  		com_redirect("contact-report.php?p=". $p ."&cID=" . $cID . "&show_by=".$show_by."&selected_menu=contact&msg=" . msg_encode("Contact update successfully"));
			
		break;
				
    }
	


include("includes/header.php");
?>
<script type="text/javascript">
function confirm_del(nid,p,cby){
	var agree=confirm("Contact will be deleted. \n Do you want to continue?");
	if (agree)
		window.location = "contact-report.php?selected_menu=contact&cID=" + nid + "&show_by=" + cby + "&p=" + p + "&action=delete";
	else
		window.location = "contact-report.php?selected_menu=contact&cID=" + nid + "&show_by=" + cby + "&p=" + p ;
}

function CheckAll(numRows){
	if(document.getElementById('all').checked){
		for(i=1; i<=numRows; i++){
			var contact_id='contact_id-'+ i;
			document.getElementById(contact_id).checked=true;
		}
	} else {
		for(i=1; i<=numRows; i++){
			var contact_id='contact_id-'+ i;
			document.getElementById(contact_id).checked=false;
		}
	}
}

function AllDelete(numRows){
	document.getElementById('action').value='alldelete';
	var flg=0;
	for(i=1; i<=numRows; i++){
			var contact_id='contact_id-'+ i;
			if(document.getElementById(contact_id).checked){
				flg=1;
			}	
		}
	if(flg==0){
		alert("Please checked atlist one checkbox for delete.");
		document.getElementById('contact_id-1').focus();
		return false;
	} else {
		var agree=confirm("Contact will be deleted. \n Do you want to continue?");
		if (agree)
			 document.topicform.submit();
		else
			window.location = "contact-report.php?selected_menu=contact";
	}	

}
function AllActivate(numRows){
	document.getElementById('action').value='allactivate';
	var flg=0;
	for(i=1; i<=numRows; i++){
			var contact_id='contact_id-'+ i;
			if(document.getElementById(contact_id).checked){
				flg=1;
			}	
		}
	if(flg==0){
		alert("Please checked atlist one checkbox for publish.");
		document.getElementById('contact_id-1').focus();
		return false;
	} else {
		var agree=confirm("Contact will be Activate. \n Do you want to continue?");
		if (agree)
			 document.topicform.submit();
		else
			window.location = "contact-report.php?selected_menu=contact";
	}	

}
function confirm_artivate(nid,p,status,cby){
	if(status=='1'){
		var msg="Contact will be active. \n Do you want to continue?";
	}else{
		var msg="Contact will be Inactive. \n Do you want to continue?";
	}
	var agree=confirm(msg);
	if (agree)
		window.location = "contact-report.php?selected_menu=contact&cID=" + nid + "&p=" + p + "&show_by=" + cby + "&status=" + status + "&action=activate";
	else
		window.location = "contact-report.php?selected_menu=contact&cID=" + nid + "&p=" + p + "&show_by=" + cby;
}

function ShowContactCreateBy(){
	var cby = document.getElementById('show_by').value;
	window.location = "contact-report.php?selected_menu=contact&show_by=" + cby;
}

</script>

 <tr>
    <td align="left" valign="top" bgcolor="#FFFFFF"><table width="975" border="0" align="center" cellpadding="0" cellspacing="0">

      <tr>
		<?php
		include("includes/menu_left.php");
		?>
		<td width="10" align="left" valign="top">&nbsp;</td>
        <td width="769" align="left" valign="top">

<?php if(($action == '') || ($action == 'save')){	?>			

		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
          <tr>
            <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="18%" align="left" valign="middle" class="heading-text">Contact Manager</td>
                  <td width="53%" align="center" valign="middle" class="message"><?=$msg?></td>
				 
                  <td width="9%" align="right" valign="middle"><a href="#"><img src="images/icon/publish.gif" width="20" height="25" alt="" title="" border="0" onclick="AllActivate('<?=$numRows?>');" /></a></td>
                  <td width="7%" align="left" valign="middle" class="nav-text">Publish </td>
                  <td width="3%" align="right" valign="middle"><a href="#"><img src="images/delete-icon.jpg" border="0" width="25" height="28"  alt="Delete Contact" title="Delete Contact" onclick="AllDelete('<?=$numRows?>');"  /></a></td>
                  <td width="10%" align="left" valign="middle" class="nav-text">Delete</td>
                </tr>
              </table></td>
          </tr>
       
          <tr>
            <td align="left" valign="top" class="right-bar-content-border">
			<form name="topicform" action="contact-report.php?pselected_menu=contact&p=<?=$p?>&show_by=<?=$show_by?>" method="post">
			<table width="100%" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="28" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-title-text">#</span></td>
				<td width="39" height="30" align="center" valign="middle" class="right-border"><input type="hidden" name="action" id="action"/>
				<input type="checkbox" name="all" id="all" onclick="CheckAll('<?=$numRows?>');" /></td>
				<td width="204" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Name</span> </td>
				<td width="203" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Title</span> </td>
                <td width="151" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Company</span> </td>
				<!--<td width="100" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Create By</span> </td>-->
				<td width="86" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Date</span> </td>
                <td width="150" height="30" align="center" valign="middle" class="left-border"><div align="center"><span class="right-box-title-text">Action</span></div></td>
			  </tr>
			<?php
			
			if($total_data>0) {
				$i=1;
				while ($data_sql = com_db_fetch_array($exe_data)) {
				$add_date = $data_sql['add_date'];
				$status = $data_sql['status'];
				$subscription_name = com_db_GetValue("select subscription_name from " . TABLE_SUBSCRIPTION . " where sub_id='".$data_sql['subscription_id']."'");
			?>          
			  <tr>
				<td height="30" align="center" valign="middle" class="right-border-left"><?=$i;?></td>
				<td height="30" align="center" valign="middle" class="right-border"><input type="checkbox" id="contact_id-<?=$i;?>" name="nid[]" value="<?=$data_sql['contact_id'];?>" /></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><a href="contact-report.php?action=detailes&p=<?=$p?>&selected_menu=contact&cID=<?=$data_sql['contact_id'];?>">
				  <?=com_db_output($data_sql['first_name']).' '.com_db_output($data_sql['last_name'])?>
				</a></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><?=com_db_output($data_sql['new_title'])?></td>
                <td height="30" align="left" valign="middle" class="right-border-text"><?=com_db_output($data_sql['company_name'])?></td>
				<td height="30" align="center" valign="middle" class="right-border"><?=$add_date;?></td>
				<td height="30" align="center" valign="middle" class="left-border">
					<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr> 
					  	<?php if($status==0){ ?>
					   	<td width="29%" align="center" valign="middle"><a href="#"><img src="images/icon/active-icon.gif" width="16" height="16" alt="" title="" border="0" onclick="confirm_artivate('<?=$data_sql['contact_id'];?>','<?=$p;?>','<?=$status;?>','<?=$show_by?>');" /></a><br />
					   	  Status</td>
					   	<?php } elseif($status==1){ ?>
					   	<td width="24%" align="center" valign="middle"><a href="#"><img src="images/icon/inactive-icon.gif" width="16" height="16" alt="" title="" border="0" onclick="confirm_artivate('<?=$data_sql['contact_id'];?>','<?=$p;?>','<?=$status;?>','<?=$show_by?>');" /></a><br />
					   	  Status</td>
						<?php } ?>
						<td width="23%" align="center" valign="middle"><a href="#"><img src="images/small-edit-icon.gif" width="16" height="16" alt="Edit" title="Edit" border="0" onclick="window.location='contact-report.php?selected_menu=contact&p=<?=$p;?>&cID=<?=$data_sql['contact_id'];?>&action=edit&show_by=<?=$show_by?>'" /></a><br />
						  Edit</td>
						<td width="24%" align="center" valign="middle"><a href="#"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" title="Delete" border="0" onclick="confirm_del('<?=$data_sql['contact_id'];?>','<?=$p;?>','<?=$show_by?>')" /></a><br />
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
		<?php echo number_pages($main_page, $p, $total_data, 8, $items_per_page,'&show_by='.$show_by.'&selected_menu=contact');?>		  
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
                  <td width="50%" align="left" valign="middle" class="heading-text">Cotact Manager :: Edit Contact </td>
				  
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top"  class="right-bar-content-border-box"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="celter" valign="top">
		 <!--start iner table  -->
			<table width="95%" align="center" cellpadding="5" cellspacing="5" border="0">
			<form name="DateTest" method="post" action="contact-report.php?action=editsave&selected_menu=contact&cID=<?=$cID;?>&p=<?=$p;?>&show_by=<?=$show_by?>" onsubmit="return chk_form();">
			<tr>
			  <td align="left" class="heading-text-a"><a href="javascript:ContactDivControl('div_executive');">>> Executive</a></td>	
			</tr>
            <tr>
			  <td align="left">
              	<div id="div_executive" style="display:none;">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;First Name:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="first_name" id="first_name" size="30" value="<?=$first_name;?>" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Middle Name:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="middle_name" id="middle_name" size="30" value="<?=$middle_name;?>" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Last Name:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="last_name" id="last_name" size="30" value="<?=$last_name;?>" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;New Title:</td>
                      <td width="75%" align="left" valign="top">
                        <!--<input type="text" name="new_title" id="new_title" size="30" value="<?//=$new_title;?>" />-->
						<select name="new_title" id="new_title" style="width:206px;">
						<option value="Any">Any</option>
						<?=selectComboBox("select id,title from ".TABLE_TITLE." where status='0' order by title",$new_title)?>
						</select>
                      </td>	
                    </tr>
                  </table>
                  </div>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a"> <a href="javascript:ContactDivControl('div_contact_details');">>> Contact Details</a></td>	
			</tr>
            <tr>
			  <td align="left">
              	<div id="div_contact_details" style="display:none;">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Email:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="email" id="email" size="30" value="<?=$email;?>" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Phone:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="phone" id="phone" size="30" value="<?=$phone;?>" />
                      </td>	
                    </tr>
                  </table>
                  </div>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a"><a href="javascript:ContactDivControl('div_company');">>> Company</a></td>	
			</tr>
            <tr>
			  <td align="left">
              	 <div id="div_company" style="display:none;">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;New Company:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="company_name" id="company_name" size="30" value="<?=$company_name;?>" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Website:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="company_website" id="company_website" size="30" value="<?=$company_website;?>" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Size ($Revenue):</td>
                      <td width="75%" align="left" valign="top">
                        <!--<input type="text" name="company_revenue" id="company_revenue" size="30" value="<?//=$company_revenue;?>" />-->
                      	<select name="company_revenue" id="company_revenue" style="width:206px;">
						<?=selectComboBox("select id,name from ".TABLE_REVENUE_SIZE." where status='0' order by from_range",$company_revenue)?>
						<option value="Any">Any</option>
						</select>
					  </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Size (Employees):</td>
                      <td width="75%" align="left" valign="top">
                        <!--<input type="text" name="company_employee" id="company_employee" size="30" value="<?//=$company_employee;?>" />-->
                      	<select name="company_employee" id="company_employee" style="width:206px;">
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
						<select name="company_industry" id="company_industry" >
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
                  </table>
                  </div>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a"><a href="javascript:ContactDivControl('div_location');">>> Location</a></td>	
			</tr>
            <tr>
			  <td align="left">
              	<div id="div_location" style="display:none;">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Address:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="address" id="address" size="30" value="<?=$address;?>" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Address 2:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="address2" id="address2" size="30" value="<?=$address2;?>" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;City:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="city" id="city" size="30" value="<?=$city;?>" />
                      </td>	
                    </tr>
					 <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Country:</td>
                      <td width="75%" align="left" valign="top">
                       <!-- <input type="text" name="country" id="country" size="30" value="<?//=$country;?>" />-->
					   <select name="country" id="country" style="width:206px;" onchange="StateChangeEdit('country');">
						<?=selectComboBox("select countries_id,countries_name from ".TABLE_COUNTRIES." order by countries_name",$country)?>
						<option value="Any">Any</option>
						</select>
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;State:</td>
                      <td width="75%" align="left" valign="top">
                        <!--<input type="text" name="state" id="state" size="30" value="<?//=$state;?>" />-->
						<div id="div_state_edit">
						<select name="state" id="state" style="width:206px;">
						<?=selectComboBox("select state_id,short_name from ".TABLE_STATE." order by short_name",$state)?>
						<option value="Any">Any</option>
						</select>
					  </div> 
                      </td>	
                    </tr>
                   
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Zip Code:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="zip_code" id="zip_code" size="30" value="<?=$zip_code;?>" />
                      </td>	
                    </tr>
                  </table>
                  </div>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a"><a href="javascript:ContactDivControl('div_change_details');">>> Change Details</a></td>	
			</tr>
            <tr>
			  <td align="left">
              	<div id="div_change_details" style="display:none;">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Date of Announcement:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="announce_date" id="announce_date" size="30" value="<?=$announce_date;?>" />
						<a href="javascript:NewCssCal('announce_date','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a>
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Effective Date:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="effective_date" id="effective_date" size="30" value="<?=$effective_date;?>" />
                      	<a href="javascript:NewCssCal('effective_date','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a>
					  </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Source:</td>
                      <td width="75%" align="left" valign="top">
                       <!-- <input type="text" name="source" id="source" size="30" value="<?//=$source;?>" />-->
						<select name="source" id="source" style="width:206px;">
						<?=selectComboBox("select id,source from ".TABLE_SOURCE." where status='0' order by source",$source)?>
						<option value="Any">Any</option>
						</select>
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Headline:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="headline" id="headline" size="30" value="<?=$headline;?>" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Full Body:</td>
                      <td width="75%" align="left" valign="top">
                        <textarea name="full_body" id="full_body" rows="5" cols="30" ><?=$full_body;?></textarea>
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Short url:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="short_url" id="short_url" size="30" value="<?=$short_url;?>" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Movement Type:</td>
                      <td width="75%" align="left" valign="top">
                        <!--<input type="text" name="movement_type" id="movement_type" size="30" value="<?//=$movement_type;?>" />-->
                     	<select name="movement_type" id="movement_type" style="width:206px;">
							<?=selectComboBox("select id,name from ".TABLE_MANAGEMENT_CHANGE." order by name",$movement_type)?>
							<option value="Any">Any</option>
                        </select>
					 </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;What Happened?:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="what_happened" id="what_happened" size="30" value="<?=$what_happened;?>" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;About the Person?:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="about_person" id="about_person" size="30" value="<?=$about_person;?>" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;About the Company?:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="about_company" id="about_company" size="30" value="<?=$about_company;?>" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;More Info Link?:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="more_link" id="more_link" size="30" value="<?=$more_link;?>" />
                      </td>	
                    </tr>
                  </table>
                  </div>
              </td>	
			</tr>
            <tr>
            	<td align="center">
                	<table width="50%" border="0" cellpadding="4" cellspacing="4">
                    	<tr><td><input type="submit" value="Update Contact" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='contact-report.php?p=<?=$p;?>&uID=<?=$uID;?>&selected_menu=contact'" /></td></tr>
                    </table>
                </td>
             </tr>
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
                  <td width="50%" align="left" valign="middle" class="heading-text">Contact Manager :: Add Contact </td>
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
			<form name="DateTest" method="post" action="contact-report.php?action=addsave&selected_menu=contact&cID=<?=$cID;?>&p=<?=$p;?>" onsubmit="return chk_form();">
			<tr>
			  <td align="left" class="heading-text-a">>> Executive</td>	
			</tr>
            <tr>
			  <td align="left">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;First Name:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="first_name" id="first_name" size="30" value="" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Middle Name:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="middle_name" id="middle_name" size="30" value="" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Last Name:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="last_name" id="last_name" size="30" value="" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;New Title:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="new_title" id="new_title" size="30" value="" />
                      </td>	
                    </tr>
                  </table>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a">>> Contact Details</td>	
			</tr>
            <tr>
			  <td align="left">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Email:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="email" id="email" size="30" value="" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Phone:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="phone" id="phone" size="30" value="" />
                      </td>	
                    </tr>
                  </table>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a">>> Company</td>	
			</tr>
            <tr>
			  <td align="left">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;New Company:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="company_name" id="company_name" size="30" value="" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Website:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="company_website" id="company_website" size="30" value="" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Size ($Revenue):</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="company_revenue" id="company_revenue" size="30" value="" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Size (Employees):</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="company_employee" id="company_employee" size="30" value="" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Industry:</td>
                      <td width="75%" align="left" valign="top">
                        
						<?php
						$industry_result = com_db_query("select * from " . TABLE_INDUSTRY ." where parent_id = '0' order by industry_id");
						?>
						<select name="company_industry" id="company_industry" >
							<option value="">All</option>
							<?php
							while($indus_row = com_db_fetch_array($industry_result)){
							?>
							<optgroup label="<?=$indus_row['title']?>">
							<?=selectComboBox("select title,title from ". TABLE_INDUSTRY ." where parent_id ='".$indus_row['industry_id']."'" ,"");?>
							</optgroup>
							<? } ?>
							
						</select>
                      </td>	
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
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;State:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="state" id="state" size="30" value="" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Country:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="country" id="country" size="30" value="" />
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
			  <td align="left" class="heading-text-a">>> Change Details</td>	
			</tr>
            <tr>
			  <td align="left">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Date of Announcement:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="announce_date" id="announce_date" size="30" value="" />
						<a href="javascript:NewCssCal('announce_date','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a>						
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Effective Date:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="effective_date" id="effective_date" size="30" value="" />
						<a href="javascript:NewCssCal('effective_date','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a>
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Headline:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="headline" id="headline" size="30" value="" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Full Body:</td>
                      <td width="75%" align="left" valign="top">
                        <textarea name="full_body" id="full_body" rows="5" cols="23" ></textarea>
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Short url:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="short_url" id="short_url" size="30" value="" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Movement Type:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="movement_type" id="movement_type" size="30" value="" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;What Happened?:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="what_happened" id="what_happened" size="30" value="" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;About the Person?:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="about_person" id="about_person" size="30" value="" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;About the Company?:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="about_company" id="about_company" size="30" value="" />
                      </td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;More Info Link?:</td>
                      <td width="75%" align="left" valign="top">
                        <input type="text" name="more_link" id="more_link" size="30" value="" />
                      </td>	
                    </tr>
                  </table>
              </td>	
			</tr>
            <tr>
            	<td align="center">
                	<table width="50%" border="0" cellpadding="4" cellspacing="4">
                    	<tr><td><input type="submit" value="Add Contact" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='contact-report.php?p=<?=$p;?>&uID=<?=$uID;?>&selected_menu=contact'" /></td></tr>
                    </table>
                </td>
             </tr>
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
                  <td width="50%" align="left" valign="middle" class="heading-text">Contact Manager :: Contact Details </td>
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
			  <td align="left" class="heading-text-a"><a href="javascript:ContactDivControl('div_executive');">>> Executive</a></td>	
			</tr>
            <tr>
			  <td align="left">
              	<div id="div_executive" style="display:none;">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;First Name:</td>
                      <td width="75%" align="left" valign="top"><?=$first_name;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Middle Name:</td>
                      <td width="75%" align="left" valign="top"><?=$middle_name;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Last Name:</td>
                      <td width="75%" align="left" valign="top"><?=$last_name;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;New Title:</td>
                      <td width="75%" align="left" valign="top"><?=$new_title;?></td>	
                    </tr>
                  </table>
                  </div>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a"> <a href="javascript:ContactDivControl('div_contact_details');">>> Contact Details</a></td>	
			</tr>
            <tr>
			  <td align="left">
              	<div id="div_contact_details" style="display:none;">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Email:</td>
                      <td width="75%" align="left" valign="top"><?=$email;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Phone:</td>
                      <td width="75%" align="left" valign="top"><?=$phone;?></td>	
                    </tr>
                  </table>
                  </div>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a"><a href="javascript:ContactDivControl('div_company');">>> Company</a></td>	
			</tr>
            <tr>
			  <td align="left">
              	 <div id="div_company" style="display:none;">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;New Company:</td>
                      <td width="75%" align="left" valign="top"><?=$company_name;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Website:</td>
                      <td width="75%" align="left" valign="top"><?=$company_website;?></td>	
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
                  </table>
                  </div>
              </td>	
			</tr>
            <tr>
			  <td align="left" class="heading-text-a"><a href="javascript:ContactDivControl('div_location');">>> Location</a></td>	
			</tr>
            <tr>
			  <td align="left">
              	<div id="div_location" style="display:none;">
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
			  <td align="left" class="heading-text-a"><a href="javascript:ContactDivControl('div_change_details');">>> Change Details</a></td>	
			</tr>
            <tr>
			  <td align="left">
              	<div id="div_change_details" style="display:none;">
              	  <table width="100%" cellpadding="4" cellspacing="4" border="0">
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Date of Announcement:</td>
                      <td width="75%" align="left" valign="top"><?=$announce_date;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Effective Date:</td>
                      <td width="75%" align="left" valign="top"><?=$effective_date;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Source:</td>
                      <td width="75%" align="left" valign="top"><?=$source;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Headline:</td>
                      <td width="75%" align="left" valign="top"><?=$headline;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Full Body:</td>
                      <td width="75%" align="left" valign="top"><?=$full_body;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Short url:</td>
                      <td width="75%" align="left" valign="top"><?=$short_url;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Movement Type:</td>
                      <td width="75%" align="left" valign="top"><?=$movement_type;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;What Happened?:</td>
                      <td width="75%" align="left" valign="top"><?=$what_happened;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;About the Person?:</td>
                      <td width="75%" align="left" valign="top"><?=$about_person;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;About the Company?:</td>
                      <td width="75%" align="left" valign="top"><?=$about_company;?></td>	
                    </tr>
                    <tr>
                      <td width="25%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;More Info Link?:</td>
                      <td width="75%" align="left" valign="top"><?=$more_link;?></td>	
                    </tr>
                  </table>
                  </div>
              </td>	
			</tr>
            			
			</table>
		 <!-- end inner table -->
		  </td>
		 </tr>
		 <tr>
            	<td align="center">
                	<table width="50%" border="0" cellpadding="4" cellspacing="4">
                    	<tr><td><input type="button" class="submitButton" value="Back" onclick="window.location='contact-report.php?p=<?=$p;?>&selected_menu=contact'" /></td></tr>
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