<?php
// https://www.ctosonthemove.com/admin/invoice-static-settings.php?action=edit
require('includes/include_top.php');
$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 20;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';


$sql_query = "select * from " . TABLE_BANNED_DOMAIN . " order by domain_id desc";
/***************** FOR PAGIN ***********************/
$starting_point = $items_per_page * ($p - 1);
/****************** END PAGIN ***********************/
$main_page = 'invoice-settings.php';

$exe_query=com_db_query($sql_query);
$num_rows=com_db_num_rows($exe_query);
$total_data = $num_rows;

/************ FOR PAGIN **************/
$sql_query .= " LIMIT $starting_point,$items_per_page";
$exe_data = com_db_query($sql_query);

$numRows = com_db_num_rows($exe_data);
/************ END ********************/


$dID = (isset($_GET['iID']) ? $_GET['iID'] : $select_data[0]);

    switch ($action) {
		
	  case 'delete':
	   		
			com_db_query("delete from " . TABLE_INVOICES . " where domain_id = '" . $dID . "'");
		 	com_redirect("invoice-static-settings.php?p=" . $p . "&selected_menu=domain&msg=" . msg_encode("Domain deleted successfully"));
		
		break;
		
	  case 'alldelete':
	   		$domain_id = $_POST['nid'];
			for($i=0; $i< sizeof($domain_id) ; $i++){
				com_db_query("delete from " . TABLE_INVOICES . " where domain_id = '" . $domain_id[$i] . "'");
			}
		 	com_redirect("invoice-static-settings.php?p=" . $p . "&selected_menu=domain&msg=" . msg_encode("Domain deleted successfully"));
		
		break;	
		
	  case 'edit':
     		//echo "<br>Table name: select * from " . TABLE_INVOICES_STATIC_DETAILS;
	   		$query_edit=com_db_query("select * from " . TABLE_INVOICES_STATIC_DETAILS);
	  		$data_edit=com_db_fetch_array($query_edit);
			$site_website=com_db_output($data_edit['site_website']);
			$site_address=com_db_output($data_edit['site_address']);
			$site_city=com_db_output($data_edit['site_city']);
			$site_zip_code=com_db_output($data_edit['site_zip_code']);
			$from_name=com_db_output($data_edit['from_name']);
			$from_title=com_db_output($data_edit['from_title']);
			
			$payable_to_name=com_db_output($data_edit['payable_to_name']);
			$payable_to_address=com_db_output($data_edit['payable_to_address']);
			$payable_to_city=com_db_output($data_edit['payable_to_city']);
			$payable_to_zip_code=com_db_output($data_edit['payable_to_zip_code']);
			
			
		break;	
		
		case 'editsave':
			
			$site_website=com_db_input($_POST['site_website']);
			$site_address=com_db_input($_POST['site_address']);
			$site_city=com_db_input($_POST['site_city']);
			$site_zip_code=com_db_input($_POST['site_zip_code']);
			$from_name=com_db_input($_POST['from_name']);
			$from_title=com_db_input($_POST['from_title']);
			
			$payable_to_name=com_db_input($_POST['payable_to_name']);
			$payable_to_address=com_db_input($_POST['payable_to_address']);
			$payable_to_city=com_db_input($_POST['payable_to_city']);
			$payable_to_zip_code=com_db_input($_POST['payable_to_zip_code']);
						
			//$query = "update " . TABLE_INVOICES_STATIC_DETAILS . " set site_website = '" . $site_website . "',site_address='".$site_address."',site_city='".$site_city."',site_zip_code='".$site_zip_code."',from_name='".$from_name." where domain_id = '" . $dID . "'";
			$query = "update " . TABLE_INVOICES_STATIC_DETAILS . " set site_website = '" . $site_website . "',site_address='".$site_address."',site_city='".$site_city."',site_zip_code='".$site_zip_code."',from_name='".$from_name."',from_title='".$from_title."',payable_to_name='".$payable_to_name."',payable_to_address='".$payable_to_address."',payable_to_city='".$payable_to_city."',payable_to_zip_code='".$payable_to_zip_code."'";
			//echo "<br>Edit Case: ".$query;
			com_db_query($query);
	  		com_redirect("invoice-static-settings.php?action=edit&p=". $p ."&dID=" . $dID . "&selected_menu=invoice&msg=" . msg_encode("Settings updated successfully"));
		 
		break;		
		
	  
		
	case 'addsave':
			
			$to_name		=	com_db_input($_POST['to_name']);
			$to_title			=	com_db_input($_POST['to_title']);
			$to_company_name	=	com_db_input($_POST['to_company_name']);
			$to_address	=	com_db_input($_POST['to_address']);
			$to_city	=	com_db_input($_POST['to_city']);
			$to_state	=	com_db_input($_POST['to_state']);
			$to_zip_code	=	com_db_input($_POST['to_zip_code']);
			$payment_amount	=	com_db_input($_POST['payment_amount']);
			$payment_method	=	com_db_input($_POST['payment_method']);
						
			$added			=	date('Y-m-d');
			$status			= 	1;
			
			$query = "insert into " . TABLE_INVOICES . " (to_name,to_title,to_company_name,to_address,to_city,to_state,to_zip_code,payment_amount,payment_method, add_date, status) values ('$to_name','$to_title','$to_company_name','$to_address','$to_city','$to_state','$to_zip_code','$payment_amount','$payment_method','$added','$status')";
			//echo "<br>query:".$query;
			//die();
			
			com_db_query($query);
	  		//com_redirect("invoice-settings.php?p=" . $p . "&selected_menu=domain&msg=" . msg_encode("Domain added successfully"));
		 
		break;	
		
	case 'detailes':
			
			$query_edit=com_db_query("select * from " . TABLE_INVOICES . " where invoice_id = '" . $dID . "'");
	  		$data_edit=com_db_fetch_array($query_edit);
			
			$to_name=com_db_output($data_edit['to_name']);
			$to_title=com_db_output($data_edit['to_title']);
			$to_company_name=com_db_output($data_edit['to_company_name']);
			$to_address=com_db_output($data_edit['to_address']);
			
						
			$add_date =explode('-',$data_edit['add_date']);
			$post_date = date('d, M Y',mktime(0,0,0,date($add_date[1]),date($add_date[2]),date($add_date[0])));
			
		break;	
	case 'activate':
     		
	   		$status=$_GET['status'];
			if($status==0){
				$query = "update " . TABLE_INVOICES . " set status = '1' where domain_id = '" . $dID . "'";
			}else{
				$query = "update " . TABLE_INVOICES . " set status = '0' where domain_id = '" . $dID . "'";
			}	
			com_db_query($query);
	  		com_redirect("invoice-settings.php?p=". $p ."&dID=" . $dID . "&selected_menu=invoice&msg=" . msg_encode("Domain update successfully"));
			
		break;
				
    }
	


include("includes/header.php");
?>
<script type="text/javascript">
function confirm_del(nid,p){
	var agree=confirm("Domain will be deleted. \n Do you want to continue?");
	if (agree)
		window.location = "invoice-settings.php?selected_menu=domain&dID=" + nid + "&p=" + p + "&action=delete";
	else
		window.location = "invoice-settings.php?selected_menu=domain&dID=" + nid + "&p=" + p ;
}

function CheckAll(numRows){
	if(document.getElementById('all').checked){
		for(i=1; i<=numRows; i++){
			var domain_id='domain_id-'+ i;
			document.getElementById(domain_id).checked=true;
		}
	} else {
		for(i=1; i<=numRows; i++){
			var domain_id='domain_id-'+ i;
			document.getElementById(domain_id).checked=false;
		}
	}
}

function AllDelete(numRows){

	var flg=0;
	for(i=1; i<=numRows; i++){
			var domain_id='domain_id-'+ i;
			if(document.getElementById(domain_id).checked){
				flg=1;
			}	
		}
	if(flg==0){
		alert("Please checked atlist one checkbox for delete.");
		document.getElementById('domain_id-1').focus();
		return false;
	} else {
		var agree=confirm("Domain will be deleted. \n Do you want to continue?");
		if (agree)
			 document.topicform.submit();
		else
			window.location = "invoice-settings.php?selected_menu=invoice";
	}	

}

function confirm_artivate(nid,p,status){
	if(status=='1'){
		var msg="Domain will be active. \n Do you want to continue?";
	}else{
		var msg="Domain will be Inactive. \n Do you want to continue?";
	}
	var agree=confirm(msg);
	if (agree)
		window.location = "invoice-settings.php?selected_menu=invoice&dID=" + nid + "&p=" + p + "&status=" + status + "&action=activate";
	else
		window.location = "invoice-settings.php?selected_menu=invoice&dID=" + nid + "&p=" + p ;
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
                  <td width="30%" align="left" valign="middle" class="heading-text">Invoices</td>
                  <td width="34%" align="left" valign="middle" class="message"><?=$msg?></td>
                  <? if($btnAdd=='Yes'){ ?>
                  <td width="8%" align="right" valign="middle"><a href="#"><img src="images/add-icon.jpg" border="0" width="25" height="28" alt="Add Domain" name="Add Domain" onclick="window.location='invoice-settings.php?action=add&selected_menu=domain'"  /></a></td>
                  <td width="8%" align="left" valign="middle" class="nav-text">Add New </td>
                  <? }
				  if($btnDelete=='Yes'){ ?>
                  <td width="4%" align="right" valign="middle"><a href="#"><img src="images/delete-icon.jpg" border="0" width="25" height="28"  alt="Delete Domain" name="Delete Domain" onclick="AllDelete('<?=$numRows?>');"  /></a></td>
                  <td width="8%" align="left" valign="middle" class="nav-text">Delete</td>
                 <? } ?>
                </tr>
              </table></td>
          </tr>
       
          <tr>
            <td align="left" valign="top" class="right-bar-content-border">
			<form name="topicform" action="invoice-settings.php?action=alldelete&selected_menu=domain" method="post">
			<table width="100%" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="23" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-domain_name-text">#</span></td>
				<td width="32" height="30" align="center" valign="middle" class="right-border">
				<input type="checkbox" name="all" id="all" onclick="CheckAll('<?=$numRows?>');" /></td>
				<td width="266" height="30" align="center" valign="middle" class="right-border"><div align="left" style="padding-left:10px;"><span class="right-box-title-text">Name</span></div> </td>
				<td width="151" height="30" align="center" valign="middle" class="right-border"><div align="left" style="padding-left:10px;"><span class="right-box-title-text">Company</span></div> </td>
				<td width="163" height="30" align="center" valign="middle" class="left-border"><div align="center"><span class="right-box-title-text">Action</span></div></td>
			  </tr>
			 
			 <?PHP
			 $sql_query = "SELECT invoice_id,to_name,to_company_name FROM ".TABLE_INVOICES;
			 //echo "<br>sql_query: ".$sql_query;
			$exe_query=com_db_query($sql_query);
			$num_rows=com_db_num_rows($exe_query);
			$total_data = $num_rows;
			 if($total_data>0) {
				$i=1;
				while ($data_sql = com_db_fetch_array($exe_query)) {
				$invoice_id = $data_sql['invoice_id'];
				$to_name = $data_sql['to_name'];
				$to_company_name = $data_sql['to_company_name'];
			 ?>
				 <tr>
				<td height="30" align="center" valign="middle" class="right-border-left"><?=$i;?></td>
				<td height="30" align="center" valign="middle" class="right-border"><input type="checkbox" id="invoice_id-<?=$i;?>" name="nid[]" value="<?=$data_sql['invoice_id'];?>" /></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><a href="invoice-settings.php?action=detailes&selected_menu=invoice&iID=<?=$data_sql['invoice_id'];?>"><?=com_db_output($data_sql['to_name'])?></a></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><?=com_db_output($to_company_name);?>
				<td align="left" valign="middle" class="right-border-text"></td>
			   </tr>
			 <?PHP
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
		<?php echo number_pages($main_page, $p, $total_data, 8, $items_per_page);?>		  
          </tr>
        </table></td>
        <td width="314" align="center" valign="bottom">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  
<?php } elseif($action=='edit'){  ?>			

		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">Invoice Static Settings </td>
				  
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top"  class="right-bar-content-border-box"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="left" valign="top">
		 <!--start iner table  -->
			<table width="95%" align="left" cellpadding="5" cellspacing="5" border="0">
			<form name="DateTest" method="post" action="invoice-static-settings.php?action=editsave&selected_menu=domain&dID=<?=$dID;?>&p=<?=$p;?>" onsubmit="return chk_form();">
			<tr>
			  <td width="30%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Website Name:</td>
			  <td width="65%" align="left" valign="top">
				<input type="text" name="site_website" id="site_website" size="40" value="<?=$site_website;?>" />
			  </td>	
			</tr>
			
			<tr>
			  <td width="30%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Site Address:</td>
			  <td width="65%" align="left" valign="top">
				<input type="text" name="site_address" id="site_address" size="40" value="<?=$site_address;?>" />
			  </td>	
			</tr>
			
			
			<tr>
			  <td width="30%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Site City:</td>
			  <td width="65%" align="left" valign="top">
				<input type="text" name="site_city" id="site_city" size="40" value="<?=$site_city;?>" />
			  </td>	
			</tr>
			
			
			<tr>
			  <td width="30%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Site Zip Code:</td>
			  <td width="65%" align="left" valign="top">
				<input type="text" name="site_zip_code" id="site_zip_code" size="40" value="<?=$site_zip_code;?>" />
			  </td>	
			</tr>
			
			
			<tr>
			  <td width="30%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;From Name:</td>
			  <td width="65%" align="left" valign="top">
				<input type="text" name="from_name" id="from_name" size="40" value="<?=$from_name;?>" />
			  </td>	
			</tr>
			
			<tr>
			  <td width="30%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;From Title:</td>
			  <td width="65%" align="left" valign="top">
				<input type="text" name="from_title" id="from_title" size="40" value="<?=$from_title;?>" />
			  </td>	
			</tr>
			
			
			<tr>
			  <td width="30%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Payable To Name:</td>
			  <td width="65%" align="left" valign="top">
				<input type="text" name="payable_to_name" id="payable_to_name" size="40" value="<?=$payable_to_name;?>" />
			  </td>	
			</tr>
			
			
			<tr>
			  <td width="30%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Payable To Address:</td>
			  <td width="65%" align="left" valign="top">
				<input type="text" name="payable_to_address" id="payable_to_address" size="40" value="<?=$payable_to_address;?>" />
			  </td>	
			</tr>
			
			<tr>
			  <td width="30%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Payable To City:</td>
			  <td width="65%" align="left" valign="top">
				<input type="text" name="payable_to_city" id="payable_to_city" size="40" value="<?=$payable_to_city;?>" />
			  </td>	
			</tr>
			
			
			<tr>
			  <td width="30%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Payable To Zip Zode:</td>
			  <td width="65%" align="left" valign="top">
				<input type="text" name="payable_to_zip_code" id="payable_to_zip_code" size="40" value="<?=$payable_to_zip_code;?>" />
			  </td>	
			</tr>
			
			
			
			<tr><td align="left" valign="top">&nbsp;</td><td align="left" valign="top"><input type="submit" value="Update Settings" class="submitButton" />
			<!--&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="button" class="submitButton" value="cancel" onclick="window.location='invoice-settings.php?p=<?=$p;?>&dID=<?=$dID;?>&selected_menu=domain'" />
				-->
			</td></tr>
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
	var site_website=document.getElementById('site_website').value;
	if(site_website==''){
	alert("Please enter website.");
	document.getElementById('site_website').focus();
	return false;
	}

}
</script>
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">Invoice Settings</td>
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
		<form name="DateTest" method="post" action="invoice-settings.php?action=addsave&p=<?=$p;?>" onsubmit="return chk_form();">
		
		<tr>
		  <td width="30%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Name:</td>
		  <td width="66%" align="left" valign="top">
				<input type="text" name="to_name" id="to_name" value="">
		  </td>	
		</tr>
		
		<tr>
		  <td width="30%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Title:</td>
		  <td width="66%" align="left" valign="top">
				<input type="text" name="to_title" id="to_title" value="">
		  </td>	
		</tr>
		
		<tr>
		  <td width="30%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Company Name:</td>
		  <td width="66%" align="left" valign="top">
				<input type="text" name="to_company_name" id="to_company_name" value="">
		  </td>	
		</tr>
		
		<tr>
		  <td width="30%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Address:</td>
		  <td width="66%" align="left" valign="top">
				<input type="text" name="to_address" id="to_address" value="">
		  </td>	
		</tr>
		
		<tr>
		  <td width="30%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;City:</td>
		  <td width="66%" align="left" valign="top">
				<input type="text" name="to_city" id="to_city" value="">
		  </td>	
		</tr>
		
		<tr>
		  <td width="30%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;State:</td>
		  <td width="66%" align="left" valign="top">
				<input type="text" name="to_state" id="to_state" value="">
		  </td>	
		</tr>
		
		
		<tr>
		  <td width="30%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Zip code:</td>
		  <td width="66%" align="left" valign="top">
				<input type="text" name="to_zip_code" id="to_zip_code" value="">
		  </td>	
		</tr>
		
		<tr>
		  <td width="30%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Payment Amount:</td>
		  <td width="66%" align="left" valign="top">
				<input type="text" name="payment_amount" id="payment_amount" value="">
		  </td>	
		</tr>
		
		
		<tr>
		  <td width="30%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Payment Method:</td>
		  <td width="66%" align="left" valign="top">
			<select name="payment_method" id="payment_method">
				<option value="credit_card">Credit Card</option>
				<option value="wire_transfer">Wire Transfer</option>
			</select>
		  </td>	
		</tr>
		
		
		
		
		<tr><td align="left" valign="top">&nbsp;</td><td align="left" valign="top"><input type="submit" value="Add Settings" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='invoice-settings.php?p=<?=$p;?>&dID=<?=$dID;?>&selected_menu=domain'" /></td></tr>
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
                  <td width="50%" align="left" valign="middle" class="heading-text">Invoice Manager :: Invoice Details </td>
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="left" valign="top" class="right-border">
		 <!--start iner table  -->
			  <table width="98%" align="center" cellpadding="5" cellspacing="5" border="0">
			
				<td align="left" valign="top" class="page-text">Name: <?=$to_name;?></td>
				<td align="left" valign="top" class="page-text">Title: <?=$to_title;?></td>
				<td align="left" valign="top" class="page-text">Company: <?=$to_company_name;?></td>
				<td align="left" valign="top" class="page-text">Address: <?=$to_address;?></td>
			</tr>
			
			<tr>
				<td align="left" valign="top"><input type="button" class="submitButton" value="Back" onclick="window.location='invoice-settings.php?p=<?=$p;?>&dID=<?=$dID;?>&selected_menu=domain'" /></td>
			</tr>
			
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
}
include("includes/footer.php");
?>