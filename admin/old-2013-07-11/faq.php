<?php
require('includes/include_top.php');
include('includes/include_editor.php');

$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 20;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';


$sql_query = "select * from " . TABLE_FAQ . " order by faq_id desc";
/***************** FOR PAGIN ***********************/
$starting_point = $items_per_page * ($p - 1);
/****************** END PAGIN ***********************/
$main_page = 'faq.php';

$exe_query=com_db_query($sql_query);
$num_rows=com_db_num_rows($exe_query);
$total_data = $num_rows;

/************ FOR PAGIN **************/
$sql_query .= " LIMIT $starting_point,$items_per_page";
$exe_data = com_db_query($sql_query);

$numRows = com_db_num_rows($exe_data);
/************ END ********************/


$fID = (isset($_GET['fID']) ? $_GET['fID'] : $select_data[0]);

    switch ($action) {
		
	  case 'delete':
	   		
			com_db_query("delete from " . TABLE_FAQ . " where faq_id = '" . $fID . "'");
		 	com_redirect("faq.php?p=" . $p . "&selected_menu=faq&msg=" . msg_encode("Faq deleted successfully"));
		
		break;
		
	  case 'alldelete':
	   		$faq_id = $_POST['nid'];
			for($i=0; $i< sizeof($faq_id) ; $i++){
				com_db_query("delete from " . TABLE_FAQ . " where faq_id = '" . $faq_id[$i] . "'");
			}
		 	com_redirect("faq.php?p=" . $p . "&selected_menu=faq&msg=" . msg_encode("Faq deleted successfully"));
		
		break;	
		
	  case 'edit':
     		
	   		$query_edit=com_db_query("select * from " . TABLE_FAQ . " where faq_id = '" . $fID . "'");
	  		$data_edit=com_db_fetch_array($query_edit);
			$question=com_db_output($data_edit['question']);
			$answer=com_db_output($data_edit['answer']);
			
			
		break;	
		
		case 'editsave':
			
			$question=com_db_input($_POST['question']);
			$answer=com_db_input($_POST['answer']);
			
			$query = "update " . TABLE_FAQ . " set question = '" . $question . "',  answer = '" . $answer . "' where faq_id = '" . $fID . "'";
			com_db_query($query);
	  		com_redirect("faq.php?p=". $p ."&fID=" . $fID . "&selected_menu=faq&msg=" . msg_encode("Faq update successfully"));
		 
		break;		
		
	  
		
	case 'addsave':
			
			$question=com_db_input($_POST['question']);
			$answer=com_db_input($_POST['answer']);
			
			$added=date('Y-m-d');
			
			$query = "insert into " . TABLE_FAQ . " (question, answer, add_date, status) values ('$question', '$answer', '$added', '0')";
			com_db_query($query);
	  		com_redirect("faq.php?p=" . $p . "&selected_menu=faq&msg=" . msg_encode("Faq added successfully"));
		 
		break;	
		
	case 'detailes':
			
			$query_edit=com_db_query("select * from " . TABLE_FAQ . " where faq_id = '" . $fID . "'");
	  		$data_edit=com_db_fetch_array($query_edit);
			
			$answer=com_db_output($data_edit['answer']);
			$question=com_db_output($data_edit['question']);
			$add_date =explode('-',$data_edit['add_date']);
			$post_date = date('d, M Y',mktime(0,0,0,date($add_date[1]),date($add_date[2]),date($add_date[0])));
			
		break;	
	case 'activate':
     		
	   		$status=$_GET['status'];
			if($status==0){
				$query = "update " . TABLE_FAQ . " set status = '1' where faq_id = '" . $fID . "'";
			}else{
				$query = "update " . TABLE_FAQ . " set status = '0' where faq_id = '" . $fID . "'";
			}	
			com_db_query($query);
	  		com_redirect("faq.php?p=". $p ."&fID=" . $fID . "&selected_menu=faq&msg=" . msg_encode("Faq update successfully"));
			
		break;
				
    }
	


include("includes/header.php");
?>
<script type="text/javascript">
function confirm_del(nid,p){
	var agree=confirm("Faq will be deleted. \n Do you want to continue?");
	if (agree)
		window.location = "faq.php?selected_menu=faq&fID=" + nid + "&p=" + p + "&action=delete";
	else
		window.location = "faq.php?selected_menu=faq&fID=" + nid + "&p=" + p ;
}

function CheckAll(numRows){
	if(document.getElementById('all').checked){
		for(i=1; i<=numRows; i++){
			var faq_id='faq_id-'+ i;
			document.getElementById(faq_id).checked=true;
		}
	} else {
		for(i=1; i<=numRows; i++){
			var faq_id='faq_id-'+ i;
			document.getElementById(faq_id).checked=false;
		}
	}
}

function AllDelete(numRows){

	var flg=0;
	for(i=1; i<=numRows; i++){
			var faq_id='faq_id-'+ i;
			if(document.getElementById(faq_id).checked){
				flg=1;
			}	
		}
	if(flg==0){
		alert("Please checked atlist one checkbox for delete.");
		document.getElementById('faq_id-1').focus();
		return false;
	} else {
		var agree=confirm("Faq will be deleted. \n Do you want to continue?");
		if (agree)
			 document.topicform.submit();
		else
			window.location = "faq.php?selected_menu=faq";
	}	

}

function confirm_artivate(nid,p,status){
	if(status=='1'){
		var msg="Faq will be active. \n Do you want to continue?";
	}else{
		var msg="Faq will be Inactive. \n Do you want to continue?";
	}
	var agree=confirm(msg);
	if (agree)
		window.location = "faq.php?selected_menu=faq&fID=" + nid + "&p=" + p + "&status=" + status + "&action=activate";
	else
		window.location = "faq.php?selected_menu=faq&fID=" + nid + "&p=" + p ;
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
                  <td width="30%" align="left" valign="middle" class="heading-text">Faq Manager</td>
                  <td width="34%" align="left" valign="middle" class="message"><?=$msg?></td>
                  <td width="8%" align="right" valign="middle"><a href="#"><img src="images/add-icon.jpg" border="0" width="25" height="28" alt="Add Faq" question="Add Faq" onclick="window.location='faq.php?action=add&selected_menu=faq'"  /></a></td>
                  <td width="8%" align="left" valign="middle" class="nav-text">Add New </td>
                  <td width="4%" align="right" valign="middle"><a href="#"><img src="images/delete-icon.jpg" border="0" width="25" height="28"  alt="Delete Faq" question="Delete Faq" onclick="AllDelete('<?=$numRows?>');"  /></a></td>
                  <td width="8%" align="left" valign="middle" class="nav-text">Delete</td>
                </tr>
              </table></td>
          </tr>
       
          <tr>
            <td align="left" valign="top" class="right-bar-content-border">
			<form name="topicform" action="faq.php?action=alldelete&selected_menu=faq" method="post">
			<table width="100%" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="23" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-question-text">#</span></td>
				<td width="32" height="30" align="center" valign="middle" class="right-border">
				<input type="checkbox" name="all" id="all" onclick="CheckAll('<?=$numRows?>');" /></td>
				<td width="543" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Title</span> </td>
				
				<td width="116" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Date</span> </td>
				<td width="247" height="30" align="center" valign="middle" class="left-border"><div align="center"><span class="right-box-title-text">Action</span></div></td>
			  </tr>
			<?php
			
			if($total_data>0) {
				$i=1;
				while ($data_sql = com_db_fetch_array($exe_data)) {
				$added_date = $data_sql['add_date'];
				$status = $data_sql['status'];
				
			?>          
			  <tr>
				<td height="30" align="center" valign="middle" class="right-border-left"><?=$i;?></td>
				<td height="30" align="center" valign="middle" class="right-border"><input type="checkbox" id="faq_id-<?=$i;?>" name="nid[]" value="<?=$data_sql['faq_id'];?>" /></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><a href="faq.php?action=detailes&selected_menu=faq&fID=<?=$data_sql['faq_id'];?>"><?=com_db_output($data_sql['question'])?></a></td>
				
				<td height="30" align="center" valign="middle" class="right-border"><?=$added_date;?></td>
				<td height="30" align="center" valign="middle" class="left-border">
					<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr> 
					  	<?php if($status==0){ ?>
					   	<td width="29%" align="center" valign="middle"><a href="#"><img src="images/icon/active-icon.gif" width="16" height="16" alt="" question="" border="0" onclick="confirm_artivate('<?=$data_sql['faq_id'];?>','<?=$p;?>','<?=$status;?>');" /></a><br />
					   	  Status</td>
					   	<?php } elseif($status==1){ ?>
					   	<td width="24%" align="center" valign="middle"><a href="#"><img src="images/icon/inactive-icon.gif" width="16" height="16" alt="" question="" border="0" onclick="confirm_artivate('<?=$data_sql['faq_id'];?>','<?=$p;?>','<?=$status;?>');" /></a><br />
					   	  Status</td>
						<?php } ?>
						<td width="23%" align="center" valign="middle"><a href="#"><img src="images/small-edit-icon.gif" width="16" height="16" alt="Edit" question="Edit" border="0" onclick="window.location='faq.php?selected_menu=faq&p=<?=$p;?>&fID=<?=$data_sql['faq_id'];?>&action=edit'" /></a><br />
						  Edit</td>
						<td width="24%" align="center" valign="middle"><a href="#"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" question="Delete" border="0" onclick="confirm_del('<?=$data_sql['faq_id'];?>','<?=$p;?>')" /></a><br />
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
                  <td width="50%" align="left" valign="middle" class="heading-text">Faq Manager :: Edit Faq </td>
				  
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
			<form name="DateTest" method="post" action="faq.php?action=editsave&selected_menu=faq&fID=<?=$fID;?>&p=<?=$p;?>" onsubmit="return chk_form();">
			<tr>
			  <td width="18%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Question:</td>
			  <td width="77%" align="left" valign="top">
				<input type="text" name="question" id="question" size="80" value="<?=$question;?>" />
			  </td>	
			</tr>
			<tr>
			<td  class="page-text" align="left" valign="top">&nbsp;&nbsp;&nbsp;Answer:</td>
			<td align="left" valign="top">
			
			<div id="loading"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1">Please wait<br><br>
			  </font><strong><font color="#993300" face="Verdana, Arial, Helvetica, sans-serif" >Editor 
			  Loading......</font></strong><br>
			  <br></div> <div id="fck" style="">  
		  <!---------------------------->
		  
			<?php
			$oFCKeditor = new FCKeditor('answer') ;
			$oFCKeditor->BasePath	= $sBasePath ;
			$oFCKeditor->ToolbarSet = ''; // Basic
			$oFCKeditor->Width  = '100%';
			$oFCKeditor->Height  = '400';       
			$oFCKeditor->Value		= $answer ;
			$oFCKeditor->Create() ;
			
			?>
				</div>
			</td></tr>
			
			<tr><td align="left" valign="top">&nbsp;</td><td align="left" valign="top"><div id="butt" style="display:none;"><input type="submit" value="Update Faq" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='faq.php?p=<?=$p;?>&fID=<?=$fID;?>&selected_menu=faq'" /></div></td></tr>
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
	var question=document.getElementById('question').value;
	if(question==''){
	alert("Please enter news question.");
	document.getElementById('question').focus();
	return false;
	}

}
</script>
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">Faq Manager :: Add Faq </td>
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
		<form name="DateTest" method="post" action="faq.php?action=addsave&p=<?=$p;?>" onsubmit="return chk_form();">
		<tr>
		  <td width="16%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Question:</td>
		  <td width="80%" align="left" valign="top">
			<input type="text" name="question" id="question" size="80" />
		  </td>	
		</tr>
		
		<tr>
		<td  class="page-text" align="left" valign="top">&nbsp;&nbsp;&nbsp;Answer:</td>
		<td align="left" valign="top">
		<div id="loading"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1">Please wait<br><br>
          </font><strong><font color="#993300" face="Verdana, Arial, Helvetica, sans-serif" >Editor 
          Loading......</font></strong><br>
          <br></div> <div id="fck" style="">  
      <!---------------------------->
      
		<?php
		$oFCKeditor = new FCKeditor('answer') ;
		$oFCKeditor->BasePath	= $sBasePath ;
		$oFCKeditor->ToolbarSet = ''; // Basic
		$oFCKeditor->Width  = '100%';
		$oFCKeditor->Height  = '400';       
		$oFCKeditor->Value		= '' ;
		$oFCKeditor->Create() ;
		
		?>
			</div>
		</td></tr>
		
		<tr><td align="left" valign="top">&nbsp;</td><td align="left" valign="top"><div id="butt" style="display:none;"><input type="submit" value="Add Faq" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='faq.php?p=<?=$p;?>&fID=<?=$fID;?>&selected_menu=faq'" /></div></td></tr>
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
                  <td width="50%" align="left" valign="middle" class="heading-text">Faq Manager :: Faq Details </td>
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
			  <td align="left" valign="top" class="page-text"><strong><?=$question;?></strong><br /><br /><?=$post_date?></td>
			</tr>
			<tr>
				<td align="left" valign="top" class="page-text"><?=$answer;?></td>
			</tr>
			<tr>
				<!--<td align="left" valign="top">&nbsp;</td> -->
				<td align="left" valign="top"><input type="button" class="submitButton" value="Back" onclick="window.location='faq.php?p=<?=$p;?>&fID=<?=$fID;?>&selected_menu=faq'" /></td>
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