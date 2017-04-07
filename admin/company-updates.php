<?php
require('includes/include_top.php');

$btnAdd=='';

$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 20;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;

$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';
$find = (isset($_GET['find']) ? $_GET['find'] : '');

$sql_query = "select cu.uid as pid,cm.* from ".TABLE_COMPANY_MASTER." as cm,cto_company_master_updates as cu where cu.company_id = cm.company_id";
  /***************** FOR PAGIN ***********************/
$starting_point = $items_per_page * ($p - 1);
/****************** END PAGIN ***********************/
$main_page = 'company-updates.php';

//echo "<br>sql_query: ".$sql_query;


$exe_query=com_db_query($sql_query);
$num_rows=com_db_num_rows($exe_query);
$total_data = $num_rows;

/************ FOR PAGIN **************/
$sql_query .= " LIMIT $starting_point,$items_per_page";
$exe_data = com_db_query($sql_query);

$numRows = com_db_num_rows($exe_data);
/************ END ********************/
$sID = (isset($_GET['sID']) ? $_GET['sID'] : '');

switch ($action) 
{
    case 'delete':
        $query_del = "DELETE from cto_company_master_updates where uid = $sID";
        echo "<br>query_del: ".$query_del;
        $query_del_rs = com_db_query($query_del);
        com_redirect("company-updates.php?p=" . $p . "&selected_menu=staff&msg=" . msg_encode("Record deleted successfully"));
    break;
    
    case 'view':
        //$query_view = "SELECT * from cto_company_master_updates as cu,".TABLE_COMPANY_MASTER." as cm where cu.company_id = cm.company_id and  uid = $sID";
        $query_view = "SELECT * from cto_company_master_updates as cu where uid = $sID";
        //echo "<br>Query view: ".$query_view;
        $query_view_rs = com_db_query($query_view);
        $data_view = com_db_fetch_array($query_view_rs);
        //echo "<pre>data_view: ";   print_r($data_view);   echo "</pre>";
        
        $company_id = com_db_output($data_view['company_id']);
        $company_name = com_db_output($data_view['company_name']);
        $company_website = com_db_output($data_view['company_website']);
        $address = com_db_output($data_view['address']);
        $city = com_db_output($data_view['city']);
        $state = com_db_output($data_view['state']);
        if($state != '')
            $state = com_get_state_name($state);
        
        //echo "<br>State: ".$state;
        //echo "<pre>state arr: ";   print_r($state);   echo "</pre>";
        
        $zip_code = com_db_output($data_view['zip_code']);    
        $phone = com_db_output($data_view['phone']);    
        $company_employee = com_db_output($data_view['company_employee']); 
        if($company_employee != '')
            $company_employee = com_get_employee($company_employee);
        
        $company_industry = com_db_output($data_view['company_industry']);  
        if($company_industry != '')
            $company_industry = com_get_industry($company_industry);
        
        
        $company_revenue = com_db_output($data_view['company_revenue']);    
        if($company_revenue != '')
            $company_revenue = com_get_revenue($company_revenue);
        
        
        
        $company_q = "SELECT company_name from cto_company_master where company_id = $company_id";
        //echo "<br>Query view: ".$query_view;
        $company_rs = com_db_query($company_q);
        $company_view = com_db_fetch_array($company_rs);
        //echo "<pre>data_view: ";   print_r($data_view);   echo "</pre>";
        
        $company_updates_for = com_db_output($company_view['company_name']);
        
        
    break;
    
    case 'accept':
        //echo "<pre>REQUEST: ";   print_r($_REQUEST);   echo "</pre>";
        $selected_update = $_REQUEST['sID'];
        
        
        $query_view = "SELECT * from cto_company_master_updates as cu where uid = $selected_update";
        //echo "<br>Query view: ".$query_view;
        $query_view_rs = com_db_query($query_view);
        $data_view = com_db_fetch_array($query_view_rs);
        //echo "<pre>data_view: ";   print_r($data_view);   echo "</pre>";
        
        $company_name = com_db_output($data_view['company_name']);
        $company_website = com_db_output($data_view['company_website']);
        $address = com_db_output($data_view['address']);
        $city = com_db_output($data_view['city']);
        $state = com_db_output($data_view['state']);
        $zip_code = com_db_output($data_view['zip_code']);
        $phone = com_db_output($data_view['phone']);
        $company_employee = com_db_output($data_view['company_employee']);
        $company_revenue = com_db_output($data_view['company_revenue']);
        $company_id = com_db_output($data_view['company_id']);
        
        
        $update_comp_query = "UPDATE " . TABLE_COMPANY_MASTER . " set company_name = '".$company_name."',company_website='".$company_website."',address='".$address."',city='".$city."',state='".$state."',zip_code='".$zip_code."',phone='".$phone."',company_employee='".$company_employee."',company_revenue='".$company_revenue."' where company_id ='".$company_id."'";
	com_db_query($update_comp_query);
        
        com_redirect("company-updates.php?p=" . $p . "&selected_menu=master&msg=" . msg_encode("Staff deleted successfully"));
    break;

    case 'delete':
         com_db_query("delete from " . TABLE_ADMIN . " where admin_id = '" . $sID . "'");
         com_redirect("company-updates.php?p=" . $p . "&selected_menu=master&msg=" . msg_encode("Staff deleted successfully"));
    break;
	  
}
	
include("includes/header.php");
?>

<script type="text/javascript">
function confirm_del(sID,p)
{
    var agree=confirm("Record will be deleted. \n Do you want to continue?");
    if (agree)
        window.location = "company-updates.php?selected_menu=master&sID=" + sID + "&p=" + p + "&action=delete";
    else
        wwwindow.location = "company-updates.php?selected_menu=master&sID=" + sID + "&p=" + p;
}



function UsercheckSearchForm()
{
    var str=document.getElementById('str').value;
    if(str=='')
    {
        alert("Please enter email or name or phone.");
        document.getElementById('str').focus();
        return false;
    }
}
</script>
<tr>
    <td align="left" valign="top" bgcolor="#FFFFFF">
        <table width="975" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <?php
                include("includes/menu_left.php");
                ?>
		<td width="10" align="left" valign="top">&nbsp;</td>
                <td width="769" align="left" valign="top">
<?php 
if(($action == '') || ($action == 'save')){	?>			

                    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
                        <tr>
                            <td align="center" valign="middle" class="right">
                                <table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="44%" align="left" valign="middle" class="heading-text">Company Updates</td>
                                        <?php if($btnAdd=='Yes'){ ?>
                                        <td width="46%" align="right" valign="middle"></td>
                                        <td width="10%" align="left" valign="middle" class="nav-text"></td>
                                      <?php } ?>
                                    </tr>
                                </table>
                            </td>
                        </tr>
       
                        <tr>
                            <td align="left" valign="top" class="right-bar-content-border">
                                <form name="topicform" action="company-updates.php?selected_menu=master" method="post">
                                    <table width="100%" align="center" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td width="18" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-title-text">#</span></td>
                                            <td width="220" height="30" align="left" valign="middle" class="right-border"><span class="right-box-title-text">Current Company Name</span> </td>
                                            <!--
                                            <td width="54" height="30" align="left" valign="middle" class="right-border"><span class="right-box-title-text"></span> </td> 
                                            <td width="79" height="30" align="left" valign="middle" class="right-border"><span class="right-box-title-text"></span></td>
                                            -->
                                            <td width="84" height="30" align="center" valign="middle" class="left-border"><div align="center"><span class="right-box-title-text">Action</span></div></td>
                                        </tr>
                                      <?php

                                        if($total_data>0) 
                                        {

                                            $i=1;
                                            while ($data_sql = com_db_fetch_array($exe_data)) 
                                            {
                                                $status = $data_sql['status'];
                                                $add_dt = explode(' ',$data_sql['admin_created']);
                                                $add_date = $add_dt[0];
                                      ?>          
                                        <tr>
                                            <td height="30" align="center" valign="middle" class="right-border-left"><?=$i;?></td>
                                            <td height="30" align="center" valign="middle" class="right-border-text"><?=com_db_output($data_sql['company_name'])?></td>
                                            <!--
                                            <td height="30" align="center" valign="middle" class="right-border-text"><?=$data_sql['access_type']?></td>
                                            <td height="30" align="center" valign="middle" class="right-border-text"><?=$add_date;?></td>
                                            -->
                                            <td height="30" align="center" valign="middle" class="left-border">
                                                <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                    <?php if($btnEdit=='Yes'){ ?>
                                                        <td width="42w%" align="center" valign="middle"><a href="#"><img src="images/small-edit-icon.gif" width="16" height="16" alt="View" title="View" border="0" onclick="window.location='company-updates.php?selected_menu=master&p=<?=$p;?>&sID=<?=$data_sql['pid'];?>&action=view'" /></a><br />
                                                            View
                                                        </td>
                                                    <?php } 
                                                    ?>
                                                    
                                                    
                                                    <td width="42w%" align="center" valign="middle"><a href="#"><img src="images/small-edit-icon.gif" width="16" height="16" alt="Accept" title="Accept" border="0" onclick="window.location='company-updates.php?selected_menu=master&p=<?=$p;?>&sID=<?=$data_sql['pid'];?>&action=edit'" /></a><br />
                                                            Accept
                                                        </td>
                                                    
                                                    <?PHP
                                                        if($btnDelete=='Yes'){ ?>    
                                                              <td width="28%" align="center" valign="middle"><a href="#"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" title="Delete" border="0" onclick="confirm_del('<?=$data_sql['pid'];?>','<?=$p;?>')" /></a><br />
                                                                Delete</td>
                                                              <?php } ?>	
                                                        </tr>
                                                      </table></td>
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
  
<?php 
} 
elseif($action=='view')
{ 
?>			
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" valign="middle" class="right">
                <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="50%" align="left" valign="middle" class="heading-text">Company Update :: View </td>
                        <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="left" valign="top"  class="right-bar-content-border-box">
                <table width="100%" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="left" valign="top">
                        <!--start iner table  -->
                            <table width="99%" align="left" cellpadding="3" cellspacing="3" border="0">
                                <!-- <form name="form_data" method="post" action="company-updates.php?selected_menu=staff&action=editsave&sID=<?=$sID;?>&p=<?=$p;?>" onsubmit="return chk_form();"> -->
                                    
                                
                                    <tr>
                                        <td height="50" colspan="2">Company Updates for: <b><?=$company_updates_for?></b></td>
                                    </tr>
                                
                                    <tr>
                                        <td width="25%" align="left" valign="top" class="page-text">&nbsp;&nbsp;&nbsp;Company Name:</td>
                                        <td width="75%" align="left" valign="top" class="page-text"><?=$company_name?></td>	
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top" class="page-text">&nbsp;&nbsp;&nbsp;Company Website:</td>
                                        <td align="left" valign="top" class="page-text"><?=$company_website?></td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top" class="page-text">&nbsp;&nbsp;&nbsp;Address:</td>
                                        <td align="left" valign="top" class="page-text"><?=$address?></td>	
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top" class="page-text">&nbsp;&nbsp;&nbsp;City:</td>
                                        <td align="left" valign="top" class="page-text"><?=$city?></td>
                                    </tr>
				
                                    <tr>
                                        <td align="left" valign="top" class="page-text">&nbsp;&nbsp;&nbsp;State:</td>
                                        <td align="left" valign="top" class="page-text"><?=$state?></td>
                                    </tr>
                                    
                                    <tr>
                                        <td align="left" valign="top" class="page-text">&nbsp;&nbsp;&nbsp;Zip Code:</td>
                                        <td align="left" valign="top" class="page-text"><?=$zip_code?></td>
                                    </tr>
                                    
                                    <tr>
                                        <td align="left" valign="top" class="page-text">&nbsp;&nbsp;&nbsp;Phone:</td>
                                        <td align="left" valign="top" class="page-text"><?=$phone?></td>
                                    </tr>
                                    
                                    <tr>
                                        <td align="left" valign="top" class="page-text">&nbsp;&nbsp;&nbsp;Company Employee:</td>
                                        <td align="left" valign="top" class="page-text"><?=$company_employee?></td>
                                    </tr>
                                    
                                    <tr>
                                        <td align="left" valign="top" class="page-text">&nbsp;&nbsp;&nbsp;Company Industry:</td>
                                        <td align="left" valign="top" class="page-text"><?=$company_industry?></td>
                                    </tr>
                                    
                                    <tr>
                                        <td align="left" valign="top" class="page-text">&nbsp;&nbsp;&nbsp;Company Revenue:</td>
                                        <td align="left" valign="top" class="page-text"><?=$company_revenue?></td>
                                    </tr>
                                    
                                    <tr>
                                        <td style="text-align:center;" colspan="2">
                                            <!-- <a href="#"><img src="images/small-edit-icon.gif" width="16" height="16" alt="Accept" title="Accept" border="0" onclick="window.location='company-updates.php?selected_menu=staff&p=<?=$p;?>&sID=<?=$sID;?>&action=accept'" />Accept</a> -->
                                            <input type="button" value="Accept"  onclick="window.location='company-updates.php?selected_menu=master&p=<?=$p;?>&sID=<?=$sID;?>&action=accept'" >
                                        </td>
                                    </tr>
                                    
                                <!-- </form> -->
                            </table>
                            <!-- end inner table -->
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table></td>
          </tr>
        </table>
		
<?php		
} elseif($action=='add'){
?>
	
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">Staff :: Add New</td>
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="left" valign="top" class="right-border-box">
		 <!--start iner table  -->
         <form name="form_data" method="post" action="company-updates.php?selected_menu=master&action=addsave&p=<?=$p;?>" onsubmit="return chk_form();">
		  <table width="100%" align="left" cellpadding="3" cellspacing="3" border="0">
		<!--<tr>
		  <td width="20%" align="left" valign="top" class="page-text">&nbsp;&nbsp;&nbsp;Username:</td>
		  <td width="80%" colspan="2" align="left" valign="top" class="page-text">
			<input type="text" name="username" id="username" size="30" onBlur="UsernameCheck();" /><br />
			<div id="div_err_username"><span class="error-text"><?=$msg?></span></div>
		  </td>	
		</tr>-->
        <tr>
		  <td width="20%" align="left" valign="top" class="page-text">&nbsp;&nbsp;&nbsp;First Name:</td>
		  <td align="left" valign="top" class="page-text" colspan="2">
			<input type="text" name="first_name" id="first_name" size="30" />
		  </td>	
		</tr>
         <tr>
		  <td width="20%" align="left" valign="top" class="page-text">&nbsp;&nbsp;&nbsp;Last Name:</td>
		  <td align="left" valign="top" class="page-text" colspan="2">
			<input type="text" name="last_name" id="last_name" size="30" />
		  </td>	
		</tr>
        <tr>
		  <td width="20%" align="left" valign="top" class="page-text">&nbsp;&nbsp;&nbsp;Email/Login ID:</td>
		  <td align="left" valign="top" class="page-text" colspan="2">
			<input type="text" name="email_address" id="email_address" size="30" />
		  </td>	
		</tr>
		<tr>
		  <td width="20%" align="left" valign="top" class="page-text">&nbsp;&nbsp;&nbsp;Password:</td>
		  <td align="left" valign="top" class="page-text" colspan="2">
			<input type="text" name="password" id="password" size="30" />
		  </td>
		</tr>
		<tr>
		  <td width="20%" align="left" valign="top" class="page-text">&nbsp;&nbsp;&nbsp;Confirm Password:</td>
		  <td align="left" valign="top" class="page-text" colspan="2">
			<input type="text" name="cpassword" id="cpassword" size="30" />
		  </td>
		</tr>
		
        <tr>
            <td colspan="3">
                <table width="100%" border="0" cellpadding="2" cellspacing="2">
                    <tr style="background-color:#CCC;">
                        <td width="27%" class="page-text" align="left"><b>Main Menu</b></td>
                        <td width="31%" class="page-text" align="left"><b>Sub Menu</b></td>
                        <td width="42%" class="page-text" align="center"><b>Action</b></td>
                    </tr>
                    <?php
                    $mmResult = com_db_query("select * from ".TABLE_MAIN_MENU);
                    while($mmRow = com_db_fetch_array($mmResult)){
                     ?>
                    <tr>
                        <td align="left" valign="top" class="page-text"><input type="checkbox" name="mm_id[]" value="<?php echo $mmRow['mm_id'];?>" /><?php echo $mmRow['mm_name'];?></td>
                        <td colspan="2">
                            <table width="100%" cellpadding="1" cellspacing="1" border="0">
                                <?php
                                $smResult = com_db_query("select * from ".TABLE_SUB_MENU." where mm_id='".$mmRow['mm_id']."'");
                                while($smRow = com_db_fetch_array($smResult)){
                                 ?>
                                <tr>
                                    <td width="51%" class="page-text"><input type="checkbox" name="sm_id_<?php echo $mmRow['mm_id'];?>[]" value="<?php echo $smRow['sm_id'];?>"/><?php echo $smRow['sm_name'];?></td>
                                    <td width="11%" class="page-text"><input type="checkbox" name="smid_add_<?php echo $smRow['sm_id'];?>" <?php if($smRow['sm_add']!='Yes'){echo 'disabled="disabled"';}?> value="Yes"/>Add</td>
                                    <td width="10%" class="page-text"><input type="checkbox" name="smid_edit_<?php echo $smRow['sm_id'];?>" <?php if($smRow['sm_edit']!='Yes'){echo 'disabled="disabled"';}?> value="Yes"/>Edit</td>
                                    <td width="14%" class="page-text"><input type="checkbox" name="smid_del_<?php echo $smRow['sm_id'];?>" <?php if($smRow['sm_delete']!='Yes'){echo 'disabled="disabled"';}?> value="Yes"/>Delete</td>
                                    <td width="14%" class="page-text"><input type="checkbox" name="smid_status_<?php echo $smRow['sm_id'];?>" <?php if($smRow['sm_status']!='Yes'){echo 'disabled="disabled"';}?> value="Yes"/>Status</td>
                                </tr>
                                <tr><td colspan="7" style="height:10px;"></td></tr>
                                <?php } ?>	
                            </table>
                        </td>
                    </tr>
                    <tr><td colspan="3" style="height:5px;border-top:1px solid #999;"></td></tr>
                    <?php } ?>
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
}
include("includes/footer.php");
?>