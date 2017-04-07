<?php
require('includes/include_top.php');

$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 20;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';


$sql_query = "select * from " . TABLE_PARTNERS . " order by add_date desc";
/***************** FOR PAGIN ***********************/
$starting_point = $items_per_page * ($p - 1);
/****************** END PAGIN ***********************/
$main_page = 'our-partners.php';

$exe_query=com_db_query($sql_query);
$num_rows=com_db_num_rows($exe_query);
$total_data = $num_rows;

/************ FOR PAGIN **************/
$sql_query .= " LIMIT $starting_point,$items_per_page";
$exe_data = com_db_query($sql_query);

$numRows = com_db_num_rows($exe_data);
/************ END ********************/


$pID = (isset($_GET['pID']) ? $_GET['pID'] : $select_data[0]);

    switch ($action) {
		
	  case 'delete':
	   		
			com_db_query("delete from " . TABLE_PARTNERS . " where partners_id = '" . $pID . "'");
		 	com_redirect("our-partners.php?p=" . $p . "&selected_menu=user&msg=" . msg_encode("Partner deleted successfully"));
		
		break;
		
	  case 'alldelete':
	   		$partners_id = $_POST['nid'];
			for($i=0; $i< sizeof($partners_id) ; $i++){
				com_db_query("delete from " . TABLE_PARTNERS . " where partners_id = '" . $partners_id[$i] . "'");
			}
		 	com_redirect("our-partners.php?p=" . $p . "&selected_menu=user&msg=" . msg_encode("Partner deleted successfully"));
		
		break;	
		
	  case 'detailes':
			
			$query_edit=com_db_query("select * from " . TABLE_PARTNERS . "  where partners_id = '" . $pID . "'");
	  		$data_edit=com_db_fetch_array($query_edit);
			$add_date =explode('-',$data_edit['add_date']);
			$post_date = date('d, M Y',mktime(0,0,0,date($add_date[1]),date($add_date[2]),date($add_date[0])));
			$name = com_db_output($data_edit['name']);
			$website = com_db_output($data_edit['website']);
			$phone = com_db_output($data_edit['phone']);
			$email = com_db_output($data_edit['email']);
			$content = com_db_output($data_edit['message']);
			
		break;	
					
    }
	


include("includes/header.php");
?>
<script type="text/javascript">
function confirm_del(nid,p){
	var agree=confirm("Partner will be deleted. \n Do you want to continue?");
	if (agree)
		window.location = "our-partners.php?selected_menu=user&pID=" + nid + "&p=" + p + "&action=delete";
	else
		window.location = "our-partners.php?selected_menu=user&pID=" + nid + "&p=" + p ;
}

function CheckAll(numRows){
	if(document.getElementById('all').checked){
		for(i=1; i<=numRows; i++){
			var partners_id='partners_id-'+ i;
			document.getElementById(partners_id).checked=true;
		}
	} else {
		for(i=1; i<=numRows; i++){
			var partners_id='partners_id-'+ i;
			document.getElementById(partners_id).checked=false;
		}
	}
}

function AllDelete(numRows){

	var flg=0;
	for(i=1; i<=numRows; i++){
			var partners_id='partners_id-'+ i;
			if(document.getElementById(partners_id).checked){
				flg=1;
			}	
		}
	if(flg==0){
		alert("Please checked atlist one checkbox for delete.");
		document.getElementById('partners_id-1').focus();
		return false;
	} else {
		var agree=confirm("Partner will be deleted. \n Do you want to continue?");
		if (agree)
			 document.topicform.submit();
		else
			window.location = "our-partners.php?selected_menu=user";
	}	

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
                  <td width="30%" align="left" valign="middle" class="heading-text">Partner Manager</td>
                  <td width="34%" align="left" valign="middle" class="message"><?=$msg?></td>
                  <? if($btnDelete=='Yes'){ ?>
                  <td width="4%" align="right" valign="middle"><a href="#"><img src="images/delete-icon.jpg" border="0" width="25" height="28"  alt="Delete Partner" countries="Delete Partner" onclick="AllDelete('<?=$numRows?>');"  /></a></td>
                  <td width="8%" align="left" valign="middle" class="nav-text">Delete</td>
                  <? } ?>
                </tr>
              </table></td>
          </tr>
       
          <tr>
            <td align="left" valign="top" class="right-bar-content-border">
			<form name="topicform" action="our-partners.php?action=alldelete&selected_menu=user" method="post">
			<table width="100%" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="37" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-title-text">#</span></td>
				<td width="29" height="30" align="center" valign="middle" class="right-border">
				<input type="checkbox" name="all" id="all" onclick="CheckAll('<?=$numRows?>');" /></td>
				<td width="250" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Partner Name</span></td>
				<td width="239" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Website</span></td>
				<td width="99" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Phone</span> </td>
				<td width="170" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">E-mail</span> </td>
				<td width="83" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Date</span> </td>
				<td width="54" height="30" align="center" valign="middle" class="left-border"><div align="center"><span class="right-box-title-text">Action</span></div></td>
			  </tr>
			<?php
			
			if($total_data>0) {
				$i=1;
				while ($data_sql = com_db_fetch_array($exe_data)) {
				$adddate = explode('-',$data_sql['add_date']);
				$add_date = $adddate[1].'/'.$adddate[2].'/'.$adddate[0]
				
			?>          
			  <tr>
				<td height="30" align="center" valign="middle" class="right-border-left"><?=$i;?></td>
				<td height="30" align="center" valign="middle" class="right-border"><input type="checkbox" id="partners_id-<?=$i;?>" name="nid[]" value="<?=$data_sql['partners_id'];?>" /></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><a href="our-partners.php?action=detailes&selected_menu=user&pID=<?=$data_sql['partners_id'];?>"><?=com_db_output($data_sql['name'])?></a></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><?=com_db_output($data_sql['website'])?></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><?=com_db_output($data_sql['phone'])?></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><?=com_db_output($data_sql['email'])?></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><?=$add_date?></td>
				<td height="30" align="center" valign="middle" class="left-border">
					<table width="45" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr> 
					<? if($btnDelete=='Yes'){ ?>	
						<td align="center" valign="middle"><a href="#"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" countries="Delete" border="0" onclick="confirm_del('<?=$data_sql['partners_id'];?>','<?=$p;?>')" /></a><br />
						  Delete</td>
                    <? } ?>     
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
		<?php echo number_pages($main_page, $p, $total_data, 8, $items_per_page,'&selected_menu=user');?>		  
          </tr>
        </table></td>
        <td width="314" align="center" valign="bottom">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  
<?php } elseif($action=='detailes'){
?>		
  	  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">Partner Manager ::  Details </td>
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
            <tr>
			  <td align="left" valign="top" class="page-text">
			  	<strong><?=$name;?></strong><br /><br />
				<strong><?=$post_date;?></strong><br /><br />
			     Website : <?=$website?><br /><br />
			     Phone : <?=$phone?><br /><br />
			     Email : <?=$email?><br /><br />
				 Message : <?=$content;?><br /><br />
				</td>
			</tr>
			<tr>
				<td align="left" valign="top"><input type="button" class="submitButton" value="Back" onclick="window.location='our-partners.php?p=<?=$p;?>&pID=<?=$pID;?>&selected_menu=user'" /></td>
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