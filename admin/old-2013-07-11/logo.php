<?php
require('includes/include_top.php');

$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';


$sql_query = "select * from " . TABLE_BANNER ;

$exe_query=com_db_query($sql_query);

$pID = (isset($_GET['pID']) ? $_GET['pID'] : $select_data[0]);

    switch ($action) {
		
	  case 'edit':
     		
	   		$query_edit=com_db_query("select * from " . TABLE_BANNER . " where id = '" . $pID . "'");
	  		$data_edit=com_db_fetch_array($query_edit);
						
			$banner_image = "../images/".com_db_output($data_edit['image_path']);
			
		break;	
		
		case 'editsave':
			
			$image = $_FILES['image']['tmp_name'];
			  if($image!=''){
				if(is_uploaded_file($image)){
					$org_img = $_FILES['image']['name'];
					$exp_file = explode("." , $org_img);
					$get_ext = $exp_file[count($exp_file) - 1];
					if($get_ext=="jpg" || $get_ext=="gif" || $get_ext=="jpeg"){
						$destination_image = '../images/' . $org_img;
						move_uploaded_file($image , $destination_image);
						com_db_query("update " . TABLE_BANNER . " set image_path='".$org_img."' where id='".$pID."'");
					}	
				}	
			}
	  		com_redirect("logo.php?p=". $p ."&pID=" . $pID . "&selected_menu=others&msg=" . msg_encode("Banner posting update successfully"));
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
                  <td width="30%" align="left" valign="middle" class="heading-text">Banner  Manager</td>
                  <td width="34%" align="left" valign="middle" class="message"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
       
          <tr>
            <td align="left" valign="top" class="right-bar-content-border">
			<form name="topicform" action="logo.php?action=alldelete&selected_menu=other" method="post">
			<table width="100%" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="36" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-title-text">#</span></td>
				<td width="741" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Description</span> </td>
				<td width="184" height="30" align="center" valign="middle" class="left-border"><div align="center"><span class="right-box-title-text">Action</span></div></td>
			  </tr>
			<?php
			while ($data_sql = com_db_fetch_array($exe_query)) {
			?>          
			  <tr>
				<td height="30" align="center" valign="middle" class="right-border-left">1</td>
				<td height="30" align="left" valign="middle" class="right-border-text"><img src="../images/<?=com_db_output($data_sql['image_path'])?>" title="Banner" alt="Banner"/></td>
                <td height="30" align="center" valign="middle" class="left-border">
					<table width="55%" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr> 
					  
						<td width="33%" align="center" valign="middle"><a href="#"><img src="images/small-edit-icon.gif" width="16" height="16" alt="Edit" title="Edit" border="0" onclick="window.location='logo.php?selected_menu=others&p=<?=$p;?>&pID=<?=$data_sql['id'];?>&action=edit'" /></a><br />
						  Edit</td>
					  </tr>
					</table>				</td>
         	</tr>
			  <tr>
			    <td height="30" align="center" valign="middle" class="right-border-left">&nbsp;</td>
			    <td height="30" align="center" valign="middle" class="right-border-text">Banner width=196 height=32 and image type .jpg, .gif, .jpeg  </td>
			    <td height="30" align="center" valign="middle" class="left-border">&nbsp;</td>
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
                  <td width="50%" align="left" valign="middle" class="heading-text">Banner Manager :: Edit Banner </td>
				  
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
			<form name="frmPropertie" id="frmPropertie" method="post" action="logo.php?action=editsave&selected_menu=others&pID=<?=$pID;?>&p=<?=$p;?>" enctype="multipart/form-data">
			<tr>
			  <td width="22%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Current Banner  :</td>
			  <td width="78%" align="left" valign="top"><img src="<?=$banner_image;?>" alt="Banner" title="Banner" border="0" /> </td>	
			</tr>
			<tr>
			  <td width="22%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Banner  :</td>
			  <td width="78%" align="left" valign="top">
				<input type="file" name="image" id="image" size="40" />			  </td>	
			</tr>
			<tr><td align="left" valign="top">&nbsp;</td><td align="left" valign="top"><input type="submit" value="Update Banner" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='logo.php?p=<?=$p;?>&pID=<?=$pID;?>&selected_menu=others'" /></td></tr>
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