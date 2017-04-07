<?php
// https://www.ctosonthemove.com/admin/invoice-settings.php?action=add
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
	   		
			com_db_query("delete from " . TABLE_INVOICES . " where user_id = '" . $dID . "'");
		 	com_redirect("invoice-settings.php?p=" . $p . "&selected_menu=invoice&msg=" . msg_encode("Invoice deleted successfully"));
		
		break;
		
	  case 'alldelete':
	   		$domain_id = $_POST['nid'];
			for($i=0; $i< sizeof($domain_id) ; $i++){
				com_db_query("delete from " . TABLE_INVOICES . " where invoice_id = '" . $domain_id[$i] . "'");
			}
		 	com_redirect("invoice-settings.php?p=" . $p . "&selected_menu=invoice&msg=" . msg_encode("Invoice deleted successfully"));
		
		break;	
		
	  case 'edit':
     		
	   		//$query_edit=com_db_query("select * from " . TABLE_INVOICES . " where invoice_id = '" . $dID . "'");
			
			$query_check_user = com_db_query("select * from " . TABLE_INVOICES . " where user_id = '" . $dID . "'");
			
			//echo "<br>query_check_user: ".$query_check_user;
			
	  		//$check_user_edit = com_db_fetch_array($query_check_user);
			$user_num_rows=com_db_num_rows($query_check_user);
			//echo "<br>user_num_rows: ".$user_num_rows;
			if($user_num_rows > 0)
			{
				//echo "<br>within if ";
				$query_edit=com_db_query("select * from " . TABLE_INVOICES . " where user_id = '" . $dID . "'");
				$data_edit=com_db_fetch_array($query_edit);
				
				$user_id=com_db_output($data_edit['user_id']);
				
				if($user_id != '')
				{
					$to_name=com_db_output($data_edit['to_name']);
					$to_title=com_db_output($data_edit['to_title']);
					$to_company_name=com_db_output($data_edit['to_company_name']);
					$to_address=com_db_output($data_edit['to_address']);
					$to_city=com_db_output($data_edit['to_city']);
					$to_state=com_db_output($data_edit['to_state']);
					$to_zip_code=com_db_output($data_edit['to_zip_code']);
					$payment_amount=com_db_output($data_edit['payment_amount']);
					$payment_method=com_db_output($data_edit['payment_method']);
					$invoice_no=com_db_output($data_edit['invoice_no']);
					$invoice_no_step=com_db_output($data_edit['invoice_no_step']);
					if($data_edit['payment_due_date'] !='0000-00-00')
					{
						$eidt = explode('-',$data_edit['payment_due_date']);
						$payment_due_date = $eidt[1].'/'.$eidt[2].'/'.$eidt[0];
					}
					else
					{
						$payment_due_date ='';
					}
					
					if($data_edit['appear_date'] !='0000-00-00')
					{
						$eadt = explode('-',$data_edit['appear_date']);
						$appear_date = $eadt[1].'/'.$eadt[2].'/'.$eadt[0];
					}
					else
					{
						$appear_date ='';
					}
					
				}
			}	
			else
			{
				//echo "<br>within else ";
				$payment_due_date ='';
				$appear_date ='';
			}
			//echo "user_id: ".$user_id;
			//if($user_id != '')
			if($dID != '')
			{
				//echo "<br>select first_name, last_name from " . TABLE_USER . " where user_id = '" . $user_id . "'";
				$query_user=com_db_query("select first_name, last_name from " . TABLE_USER . " where user_id = '" . $dID . "'");
				$data_user=com_db_fetch_array($query_user);
				
				$first_name=com_db_output($data_user['first_name']);
				$last_name=com_db_output($data_user['last_name']);
			}
			//echo "<br>first_name: ".$first_name;
			//echo "<br>last_name: ".$last_name;
			
			//$payment_due_date=com_db_output($data_edit['payment_due_date']);
			
			
			
			
		break;	
		
		case 'editsave':
			//echo "<pre>_POST: ";	print_r($_POST);	echo "</pre>";
			//$domain_name=com_db_input($_POST['domain_name']);
			
			$to_name		=	com_db_input($_POST['to_name']);
			$to_title			=	com_db_input($_POST['to_title']);
			$to_company_name	=	com_db_input($_POST['to_company_name']);
			$to_address	=	com_db_input($_POST['to_address']);
			$to_city	=	com_db_input($_POST['to_city']);
			$to_state	=	com_db_input($_POST['to_state']);
			$to_zip_code	=	com_db_input($_POST['to_zip_code']);
			$payment_amount	=	com_db_input($_POST['payment_amount']);
			$payment_method	=	com_db_input($_POST['payment_method']);
			$invoice_no	=	com_db_input($_POST['invoice_no']);
			$invoice_no_step	=	com_db_input($_POST['invoice_no_step']);
			
			$due_date	=	com_db_input($_POST['due_date']);
			//echo "<br>due_date: ".$due_date; 
			$idt = explode('/',$due_date);
			//echo "<pre>idt: ";	print_r($idt);	echo "</pre>";
			$payment_due_date = $idt[2].'-'.$idt[0].'-'.$idt[1];
			//echo "<br>payment_due_date: ".$payment_due_date; 
			
			$appear_date_txt	=	com_db_input($_POST['appear_date']);
			$adt = explode('/',$appear_date_txt);
			$appear_date = $adt[2].'-'.$adt[0].'-'.$adt[1];
			
			
			$dID		=	com_db_input($_GET['iID']);
			
			$added			=	date('Y-m-d');
			$status			= 	1;
			
			
			
			
			$query_check_user = com_db_query("select * from " . TABLE_INVOICES . " where user_id = '" . $dID . "'");
	  		//$check_user_edit = com_db_fetch_array($query_check_user);
			$user_num_rows=com_db_num_rows($query_check_user);
			/*
			while($indus_row = com_db_fetch_array($query_check_user))
			{
			}
			*/
			if($user_num_rows > 0)
			{
				$query = "update " . TABLE_INVOICES . " set to_name = '" . $to_name . "',to_title='".$to_title."',to_company_name='".$to_company_name."',to_address='".$to_address."',to_city='".$to_city."',to_state='".$to_state."',to_zip_code='".$to_zip_code."',payment_amount='".$payment_amount."',payment_method='".$payment_method."',invoice_no='".$invoice_no."',invoice_no_step='".$invoice_no_step."',payment_due_date='".$payment_due_date."',appear_date='".$appear_date."' where user_id = '" . $dID . "'";
				//echo "<br>query: ".$query;
				com_db_query($query);
			}
			else
			{
				$query = "insert into " . TABLE_INVOICES . " (user_id,to_name,to_title,to_company_name,to_address,to_city,to_state,to_zip_code,payment_amount,payment_method,invoice_no,invoice_no_step,payment_due_date,appear_date, add_date, status) values ('$dID','$to_name','$to_title','$to_company_name','$to_address','$to_city','$to_state','$to_zip_code','$payment_amount','$payment_method','$invoice_no','$invoice_no_step','$payment_due_date','$appear_date','$added','$status')";
				//echo "<br>query: ".$query;
				com_db_query($query);
			}
			//echo "<br>query: ".$query; 
			//die();
	  		com_redirect("invoice-settings.php?p=". $p ."&dID=" . $dID . "&selected_menu=invoice&msg=" . msg_encode("Invoice updated successfully"));
		 
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
			$invoice_no	=	com_db_input($_POST['invoice_no']);
			$invoice_no_step	=	com_db_input($_POST['invoice_no_step']);
			
			$due_date	=	com_db_input($_POST['due_date']);
			$idt = explode('/',$due_date);
			$idate = $idt[2].'-'.$idt[0].'-'.$idt[1];
			
			$appear_date	=	com_db_input($_POST['appear_date']);
			$adt = explode('/',$appear_date);
			$adate = $adt[2].'-'.$adt[0].'-'.$adt[1];

			
			
			$added			=	date('Y-m-d');
			$status			= 	1;
			
			$query = "insert into " . TABLE_INVOICES . " (to_name,to_title,to_company_name,to_address,to_city,to_state,to_zip_code,payment_amount,payment_method,invoice_no,invoice_no_step,payment_due_date,appear_date, add_date, status) values ('$to_name','$to_title','$to_company_name','$to_address','$to_city','$to_state','$to_zip_code','$payment_amount','$payment_method','$invoice_no','$invoice_no_step','$idate','$adate','$added','$status')";
			//echo "<br>query:".$query;
			//die();
			
			com_db_query($query);
	  		com_redirect("invoice-settings.php?p=" . $p . "&selected_menu=invoice&msg=" . msg_encode("Invoice added successfully"));
		 
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
	  		com_redirect("invoice-settings.php?p=". $p ."&dID=" . $dID . "&selected_menu=invoice&msg=" . msg_encode("Invoice updated successfully"));
			
		break;
				
    }
	


include("includes/header.php");
?>
<script type="text/javascript">
function confirm_del(nid,p){
	var agree=confirm("Invoice will be deleted. \n Do you want to continue?");
	if (agree)
		window.location = "invoice-settings.php?selected_menu=invoice&dID=" + nid + "&p=" + p + "&action=delete";
	else
		window.location = "invoice-settings.php?selected_menu=invoice&dID=" + nid + "&p=" + p ;
}

function CheckAll(numRows){
	if(document.getElementById('all').checked){
		for(i=1; i<=numRows; i++){
			var domain_id='invoice_id-'+ i;
			document.getElementById(domain_id).checked=true;
		}
	} else {
		for(i=1; i<=numRows; i++){
			var domain_id='invoice_id-'+ i;
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
		var agree=confirm("Invoice will be deleted. \n Do you want to continue?");
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
                  <td width="8%" align="right" valign="middle">
					<!-- <a href="#"><img src="images/add-icon.jpg" border="0" width="25" height="28" alt="Add Domain" name="Add Domain" onclick="window.location='invoice-settings.php?action=add&selected_menu=domain'"  /></a> -->
				</td>
                  <td width="8%" align="left" valign="middle" class="nav-text">
					<!-- Add New  -->
				</td>
                  <? }
				  $btnDelete = 'NO';
				  if($btnDelete=='Yes'){ ?>
                  <td width="4%" align="right" valign="middle"><a href="#"><img src="images/delete-icon.jpg" border="0" width="25" height="28"  alt="Delete Domain" name="Delete Domain" onclick="AllDelete('<?=$numRows?>');"  /></a></td>
                  <td width="8%" align="left" valign="middle" class="nav-text">Delete</td>
                 <? } ?>
                </tr>
              </table></td>
          </tr>
       
          <tr>
            <td align="left" valign="top" class="right-bar-content-border">
			<form name="topicform" action="invoice-settings.php?action=alldelete&selected_menu=invoice" method="post">
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
			 $sql_query = "SELECT invoice_id,user_id,to_name,to_company_name FROM ".TABLE_INVOICES;
			// echo "<br>sql_query: ".$sql_query;
			$exe_query=com_db_query($sql_query);
			$num_rows=com_db_num_rows($exe_query);
			$total_data = $num_rows;
			 if($total_data>0) {
				$i=1;
				while ($data_sql = com_db_fetch_array($exe_query)) {
				$invoice_id = $data_sql['invoice_id'];
				$to_name = $data_sql['to_name'];
				$to_company_name = $data_sql['to_company_name'];
				$user_id = $data_sql['user_id'];
				//echo "<br>user_id: ".$user_id;
			 ?>
				 <tr>
				<td height="30" align="center" valign="middle" class="right-border-left"><?=$i;?></td>
				<td height="30" align="center" valign="middle" class="right-border"><input type="checkbox" id="user_id-<?=$i;?>" name="nid[]" value="<?=$data_sql['user_id'];?>" /></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><a href="invoice-settings.php?action=detailes&selected_menu=invoice&iID=<?=$data_sql['invoice_id'];?>"><?=com_db_output($data_sql['to_name'])?></a></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><?=com_db_output($to_company_name);?>
				<td align="left" valign="middle" class="right-border-text" style="text-align:center;">
					<a href="#"><img src="images/small-edit-icon.gif" width="16" height="16" alt="Edit" title="Edit" border="0" onclick="window.location='invoice-settings.php?selected_menu=invoice&p=<?=$p;?>&iID=<?=$data_sql['user_id'];?>&action=edit'" /></a>
					&nbsp;&nbsp;&nbsp;
					<a href="#"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" title="Delete" border="0" onclick="window.location='invoice-settings.php?selected_menu=invoice&p=<?=$p;?>&iID=<?=$data_sql['user_id'];?>&action=delete'" /></a>
				</td>
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
  
<?php } elseif($action=='edit'){ ?>			

		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">Invoice Settings :: Edit Invoice </td>
				  
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
			<form name="DateTest" method="post" action="invoice-settings.php?action=editsave&selected_menu=domain&iID=<?=$dID;?>&p=<?=$p;?>" onsubmit="return chk_form();">
			<!-- <input type="hidden" name="" id="" value="<?=$dID?>"> -->
			<tr>
				<td width="30%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;User Name:</td>
				<td width="66%" align="left" valign="top"><?=$first_name." ".$last_name?></td>
			</tr>	
			
			
			<tr>
		  <td width="30%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Name:</td>
		  <td width="66%" align="left" valign="top">
				<input type="text" name="to_name" id="to_name" value="<?=$to_name?>">
		  </td>	
		</tr>
		
		<tr>
		  <td width="30%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Title:</td>
		  <td width="66%" align="left" valign="top">
				<input type="text" name="to_title" id="to_title" value="<?=$to_title?>">
		  </td>	
		</tr>
		
		<tr>
		  <td width="30%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Company Name:</td>
		  <td width="66%" align="left" valign="top">
				<input type="text" name="to_company_name" id="to_company_name" value="<?=$to_company_name?>">
		  </td>	
		</tr>
		
		<tr>
		  <td width="30%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Address:</td>
		  <td width="66%" align="left" valign="top">
				<input type="text" name="to_address" id="to_address" value="<?=$to_address?>">
		  </td>	
		</tr>
		
		<tr>
		  <td width="30%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;City:</td>
		  <td width="66%" align="left" valign="top">
				<input type="text" name="to_city" id="to_city" value="<?=$to_city?>">
		  </td>	
		</tr>
		
		<tr>
		  <td width="30%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;State:</td>
		  <td width="66%" align="left" valign="top">
				<input type="text" name="to_state" id="to_state" value="<?=$to_state?>">
		  </td>	
		</tr>
		
		
		<tr>
		  <td width="30%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Zip code:</td>
		  <td width="66%" align="left" valign="top">
				<input type="text" name="to_zip_code" id="to_zip_code" value="<?=$to_zip_code?>">
		  </td>	
		</tr>
		
		<tr>
		  <td width="30%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Payment Amount:</td>
		  <td width="66%" align="left" valign="top">
				<input type="text" name="payment_amount" id="payment_amount" value="<?=$payment_amount?>">
		  </td>	
		</tr>
		
		
		<tr>
		  <td width="30%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Payment Method:</td>
		  <td width="66%" align="left" valign="top">
			<select name="payment_method" id="payment_method" style="width:173px;">
				<option <?PHP if($payment_method == 'credit_card') echo "selected"; else echo ""; ?> value="credit_card">Credit Card</option>
				<option <?PHP if($payment_method == 'wire_transfer') echo "selected"; else echo ""; ?> value="wire_transfer">Wire Transfer</option>
			</select>
		  </td>	
		</tr>
		
		
		<tr>
		  <td width="30%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Invoice #:</td>
		  <td width="66%" align="left" valign="top">
				<input type="text" name="invoice_no" id="invoice_no" value="<?=$invoice_no?>">
		  </td>	
		</tr>
		
		
		<tr>
		  <td width="30%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Invoice # Step:</td>
		  <td width="66%" align="left" valign="top">
				<input type="text" name="invoice_no_step" id="invoice_no_step" value="<?=$invoice_no_step?>">
		  </td>	
		</tr>
		
		
		<tr>
		  <td width="30%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Due Date:</td>
		  <td width="66%" align="left" valign="top">
				<input type="text" name="due_date" id="due_date" value="<?=$payment_due_date?>">
				<a href="javascript:NewCssCal('due_date','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a>
		  </td>	
		</tr>
		
		<tr>
		  <td width="30%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Appear Date:</td>
		  <td width="66%" align="left" valign="top">
				<input type="text" name="appear_date" id="appear_date" value="<?=$appear_date?>">
				<a href="javascript:NewCssCal('appear_date','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a>
		  </td>	
		</tr>
			
			<tr><td align="left" valign="top">&nbsp;</td><td align="left" valign="top"><input type="submit" value="Update Invoice" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='invoice-settings.php?p=<?=$p;?>&dID=<?=$dID;?>&selected_menu=invoice'" /></td></tr>
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
	var domain_name=document.getElementById('domain_name').value;
	if(domain_name==''){
	alert("Please enter user domain_name.");
	document.getElementById('domain_name').focus();
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
			<select name="payment_method" id="payment_method" style="width:173px;">
				<option value="credit_card">Credit Card</option>
				<option value="wire_transfer">Wire Transfer</option>
			</select>
		  </td>	
		</tr>
		
		
		<tr>
		  <td width="30%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Invoice #:</td>
		  <td width="66%" align="left" valign="top">
				<input type="text" name="invoice_no" id="invoice_no" value="">
		  </td>	
		</tr>
		
		
		<tr>
		  <td width="30%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Invoice # Step:</td>
		  <td width="66%" align="left" valign="top">
				<input type="text" name="invoice_no_step" id="invoice_no_step" value="">
		  </td>	
		</tr>
		
		
		<tr>
		  <td width="30%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Due Date:</td>
		  <td width="66%" align="left" valign="top">
				<input type="text" name="due_date" id="due_date" value="">
				<a href="javascript:NewCssCal('due_date','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a>
		  </td>	
		</tr>
		
		
		<tr>
		  <td width="30%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Appear Date:</td>
		  <td width="66%" align="left" valign="top">
				<input type="text" name="appear_date" id="appear_date" value="">
				<a href="javascript:NewCssCal('appear_date','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a>
		  </td>	
		</tr>
		
		
		
		<tr><td align="left" valign="top">&nbsp;</td><td align="left" valign="top"><input type="submit" value="Add Settings" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='invoice-settings.php?p=<?=$p;?>&dID=<?=$dID;?>&selected_menu=invoice'" /></td></tr>
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
				<td align="left" valign="top"><input type="button" class="submitButton" value="Back" onclick="window.location='invoice-settings.php?p=<?=$p;?>&dID=<?=$dID;?>&selected_menu=invoice'" /></td>
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