<?php
require('includes/include_top.php');

$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';


$sql_query = "select * from " . TABLE_POPUP_ONOFF ;

$exe_query = com_db_query($sql_query);

$pID = (isset($_GET['pID']) ? $_GET['pID'] : $select_data[0]);

    switch ($action) {
		case 'edit':
     		
	   		$query_edit=com_db_query("select * from " . TABLE_POPUP_ONOFF . " where id = '" . $pID . "'");
	  		$data_edit=com_db_fetch_array($query_edit);
			
		break;	
	  		
		case 'editsave':
			com_db_query("update " . TABLE_POPUP_ONOFF . " set status='".$_POST['popup_status']."', delay_time='".$_POST['delay_time']."' where id='".$pID."'");
	  		com_redirect("sign-up-popup.php?p=". $p ."&pID=" . $pID . "&selected_menu=others&msg=" . msg_encode("Sign up pop up update successfully"));
		break;		

	
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

<?php if(($action == '') || ($action == 'save')){	?>			

		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
          <tr>
            <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="30%" align="left" valign="middle" class="heading-text">Sign up pop up Manager</td>
                  <td width="34%" align="left" valign="middle" class="message"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
       
          <tr>
            <td align="left" valign="top" class="right-bar-content-border">
			<form name="topicform" action="sign-up-popup.php?action=alldelete&selected_menu=other" method="post">
			<table width="100%" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="36" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-title-text">#</span></td>
				<td width="441" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Popup Status</span> </td>
                <td width="300" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Delay Time</span> </td>
				<td width="184" height="30" align="center" valign="middle" class="left-border"><div align="center"><span class="right-box-title-text">Action</span></div></td>
			  </tr>
			<?php
			while ($data_sql = com_db_fetch_array($exe_query)) {
			?>          
			  <tr>
				<td height="30" align="center" valign="middle" class="right-border-left">1</td>
				<td height="30" align="left" valign="middle" class="right-border-text"><? if ($data_sql['status']=='On'){ echo 'On';}else{ echo 'Off';} ?></td>
                <td height="30" align="left" valign="middle" class="right-border-text"><?=$data_sql['delay_time']?> Seconds</td>
                <td height="30" align="center" valign="middle" class="left-border">
					<table width="55%" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr> 
						<td width="33%" align="center" valign="middle"><a href="#"><img src="images/small-edit-icon.gif" width="16" height="16" alt="Edit" title="Edit" border="0" onclick="window.location='sign-up-popup.php?selected_menu=others&p=<?=$p;?>&pID=<?=$data_sql['id'];?>&action=edit'" /></a><br />
						  Edit</td>
					  </tr>
					</table>				</td>
         	</tr> 
			<?php
			$i++;
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
 
  
<?php } elseif($action=='edit'){ ?>	
	

		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">Sign up pop up  Manager :: Edit </td>
				  
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
			<form name="frmPropertie" id="frmPropertie" method="post" action="sign-up-popup.php?action=editsave&selected_menu=others&pID=<?=$pID;?>&p=<?=$p;?>" enctype="multipart/form-data">
			<tr>
			  <td width="14%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Status  :</td>
			  <td width="86%" align="left" valign="top" class="page-text">
					<input type="radio" name="popup_status" <? if($data_edit['status']=='On'){ echo 'checked="checked"';} ?> value="On" /> On &nbsp;
					<input type="radio" name="popup_status" <? if($data_edit['status']=='Off'){ echo 'checked="checked"';} ?> value="Off" /> Off &nbsp;
			  </td>	
			</tr>
            <tr>
			  <td width="14%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Delay Time  :</td>
			  <td width="86%" align="left" valign="top" class="page-text"><input type="text" name="delay_time" id="delay_time" size="10" value="<?=$data_edit['delay_time']?>" /> </td>	
			</tr>
			<tr><td align="left" valign="top">&nbsp;</td><td align="left" valign="top"><input type="submit" value="Update pop up" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='sign-up-popup.php?p=<?=$p;?>&pID=<?=$pID;?>&selected_menu=others'" /></td></tr>
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
}
include("includes/footer.php");
?>