<?php
include("includes/include-top.php");

$action = $_REQUEST['action'];
$alert_id = $_REQUEST['altID'];
if($action=='StatusChange'){
	$status = $_REQUEST['status'];
	if($status=='1'){
		$alert_update = "update " . TABLE_ALERT . " set status = '0' where alert_id='".$alert_id."'" ;
	}elseif($status=='0'){
		$alert_update = "update " . TABLE_ALERT . " set status = '1' where alert_id='".$alert_id."'" ;
	}
	com_db_query($alert_update);
}elseif($action=='DeleteAlert'){
	$alert_delete = "delete from " . TABLE_ALERT . " where alert_id='".$alert_id."'" ;
	com_db_query($alert_delete);
}elseif($action=='AlertSave'){
	
	$industry_arr		= $_POST['industry'];
	if(sizeof($industry_arr)>0 && $industry_arr[0] >0){
		$industry_id = implode(",",$industry_arr);
	}else{
		$industry_id ='';
	}
	$revenue_size_arr = $_POST['revenue_size'];
	if(sizeof($revenue_size_arr)>0 && $revenue_size_arr[0] >0){
		$revenue_size = implode(",",$revenue_size_arr);
	}else{
		$revenue_size ='';
	}
	$employee_size_arr	= $_POST['employee_size'];
	if(sizeof($employee_size_arr)>0 && $employee_size_arr[0] >0){
		$employee_size = implode(",",$employee_size_arr);
	}else{
		$employee_size = '';
	}
		
	$title = com_db_input($_POST['title']);
	$country = $_POST['country'];
	$state_arr			= $_POST['state'];
	if(sizeof($state_arr)>0 && trim($state_arr[0]) >0){
		$state = implode(",",$state_arr);
	}else{
		$state='';
	}
	$delivery_schedule = $_POST['delivery_schedule'];
	$alert_date=date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('Y')));
	$alert_modify_date = date('Y-m-d');
	$alert_update = " update " . TABLE_ALERT . " set title ='".$title."', country ='" . $country . "', state ='" . $state ."', industry_id ='". $industry_id ."', revenue_size ='".$revenue_size."', employee_size ='" . $employee_size . "', delivery_schedule = '".$delivery_schedule."', alert_date='".$alert_date."', modify_date='".$alert_modify_date."' where alert_id='".$alert_id."'";
	com_db_query($alert_update);
}
include(DIR_INCLUDES."header-content-page.php");
?>	 
    <!-- heading start -->
 <div style="margin:0 auto; width:960px;">
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	 <tr>
        <td colspan="2" align="left" valign="top" class="caption-text">
		<?=com_db_GetValue("select page_content from " .TABLE_PAGE_CONTENT . " where page_name='index.php' and page_title='Page Heading'")?>
		</td>
    </tr>
    <tr><td colspan="2">&nbsp;</td></tr>
	 
    <!-- heading start -->
    <tr>
      <td align="left"  valign="top">&nbsp;</td>
      <td align="left" valign="top"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
	       <tr>
        <td align="left" valign="top" class="header-nav"><a href="<?=HTTP_SERVER?>index.html">Home</a>  /  <a href="#" class="active"><?=$PageTitle;?></a></td>
      </tr>
   <tr>
      <td align="left" valign="top"><img src="images/specer.gif" width="1" height="10" alt="" title="" /></td>
      </tr>
      <tr>
      <td align="left" valign="middle" class="registration-page-heading-bg"><table width="960" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="left" valign="middle" class="my-profile-page-title-text"><a href="<?=HTTP_SERVER?>my-profile.php">My Profile</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=HTTP_SERVER?>my-subscription.php">My Subscription&nbsp;</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=HTTP_SERVER?>my-alert.php"><strong>My Alerts</strong></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=HTTP_SERVER?>alert.php">Add New Alert</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="<?=HTTP_SERVER?>my-change-password.php">Change Password</a>
			<?PHP
			 $user_invoices = this_user_invoices();
			 if(sizeof($user_invoices) > 0)
			 {	 
			  ?>
			  &nbsp;&nbsp;&nbsp;&nbsp;<a href="<?=HTTP_SERVER?>my-invoices.php">Invoices</a>
			  <?PHP
			 }
			  ?>
		  </td>
        </tr>
      </table></td>
      </tr>
	    <tr>
      <td align="left" valign="top"  class="registration-page-bg"><img src="images/my-alert-blue-down-arrow.jpg" width="288" height="21"  alt="" title="" /></td>
      </tr>
      </table></td>
      <td align="left"  valign="top">&nbsp;</td>
    </tr>
    <!-- heading end -->
    <!-- content start -->
   	<tr>
      <td align="left"  valign="top">&nbsp;</td>
      <td align="center" valign="top" class="registration-page-bg"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
         <td align="left" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td align="center" valign="top">
		  <SCRIPT type=text/javascript>
			
			function setVisible(divid)
			{
				document.getElementById(divid).style.display='block';
			}
			function setClose(divid)
			{
				document.getElementById(divid).style.display='none';
			}
			</SCRIPT>
			 
		  <script type="text/javascript" src="selectuser.js" language="javascript"></script>
		  <form name="frmMyAlert" id="frmMyAlert" method="post" action="my-alert.php?action=<?PHP if($action=='EditSave'){echo 'AlertSave&altID='.$alert_id;}?>">
		  
		  <table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="250"  height="53" align="center" valign="middle" bgcolor="#2C86B7" class="my-alert-white-heading-text"> Alert </td>
              <td width="168"  height="53" align="center" valign="middle" bgcolor="#2C86B7" class="my-alert-white-heading-text">Settings </td>
              <td width="108" height="53" align="center" valign="middle" bgcolor="#2C86B7" class="my-alert-white-heading-text">Delivery</td>
              <td width="107" height="53" align="center" valign="middle" bgcolor="#2C86B7" class="my-alert-white-heading-text"> Created </td>
              <td width="116" align="center" valign="middle" bgcolor="#2C86B7" class="my-alert-white-heading-text">Status </td>
              <td width="196" align="center" valign="middle" bgcolor="#2C86B7" class="my-alert-white-heading-text"> Change</td>
            </tr>
			<?PHP
			
			$alert_query ="select * from " . TABLE_ALERT . " where user_id='".$_SESSION['sess_user_id']."'";
			$alert_result = com_db_query($alert_query);
			if($alert_result){
				$alert_num_row = com_db_num_rows($alert_result);
			}else{
				$alert_num_row =0;
			}
			if($alert_num_row>0){
			while($alert_row = com_db_fetch_array($alert_result)){
			$add_dt = explode('-', $alert_row['add_date']);
			$add_date = $add_dt[1].'/'.$add_dt[2].'/'.$add_dt[0];
			if($alert_row['status']==0){
				$alert_status = 'Active';
				$alert_caption = 'Pause';
			}else{
				$alert_status = 'Paused';
				$alert_caption = 'Resume';
			}
			//$alert_title = com_db_GetValue("select title from ".TABLE_TITLE." where id='".$alert_row['title']."'");
			$alert_title = com_db_output($alert_row['title']);
			?>
            <tr>
              <td width="210" height="36" align="center" valign="top" bgcolor="#CBDFE8" class="my-alert-text"><?=$alert_title;?></td>
              <td width="170" height="36" align="center" valign="top" bgcolor="#EDEDED" class="my-alert-text">
			  	<?php
				if($action=='EditSave' && $alert_id==$alert_row['alert_id']){
					$industry_id_arr = explode(",", $alert_row['industry_id']);
					$revenue_size_id_arr = explode(",", $alert_row['revenue_size']);
					$employee_size_id_arr = explode(",", $alert_row['employee_size']);
					$title = com_db_output($alert_row['title']);
					$country = $alert_row['country'];
					$state_id_arr = explode(",",$alert_row['state']);
					?>
					<table width="168" border="0" align="center" cellpadding="2" cellspacing="0">
						<tr>
						  <td width="168" align="left" valign="top">
							 <?PHP $indQuery = "select industry_id,title from ".TABLE_INDUSTRY." where status=0 and parent_id=0";
                                $indResult = com_db_query($indQuery);
                            ?>
                            <select name="industry[]" id="industry" multiple="multiple" style="width:200px;color:#666;">
                                <option value="">Any</option>
                                <?PHP while($indRow = com_db_fetch_array($indResult)){ ?>
                                <optgroup label="<?=com_db_output($indRow['title'])?>">
                                    <?=MultiSelectionComboBox("select industry_id,title from ".TABLE_INDUSTRY." where status=0 and parent_id='".$indRow['industry_id']."'",$industry_id_arr)?>
                                </optgroup>
                                <?PHP } ?>
                            </select>
						  </td>
						</tr>
						<tr>
						  <td align="left" valign="top">
						  <select name="revenue_size[]" id="revenue_size" multiple="multiple" style="width:200px;color:#666;">
                            <option value="">Any</option>
                            <?=MultiSelectionComboBox("select id,name from ".TABLE_REVENUE_SIZE." order by from_range",$revenue_size_id_arr)?>
                          </select>
						  </td>
						</tr>
						<tr>
						  <td align="left" valign="top">
						   <select name="employee_size[]" id="employee_size" multiple="multiple" style="width:200px;color:#666;">
                                <option value="">Any</option>
                                <?=MultiSelectionComboBox("select id,name from ".TABLE_EMPLOYEE_SIZE." order by from_range",$employee_size_id_arr)?>
                            </select>
						  </td>
						</tr>
						<tr>
						  <td align="left" valign="top">
						 	<input type="text" name="title" id="title" class="text-new-158" style="color:#737373;width:195px;" onfocus="fieldHighlightTextboxIndAlert('title');" value="<?=$title;?>" onblur="fieldLosslightTextboxIndAlert('title');"/>
						  </td>
						</tr>
						<tr>
						  <td align="left" valign="top">
						 	 <select name="country" id="country" style="width:200px;color:#666;">
                                <option value="">Any</option>
                                <?=selectComboBox("select countries_id,countries_name from ".TABLE_COUNTRIES." order by countries_name",$country)?>
                             </select>
						  </td>
						</tr>
						<tr>
						  <td align="left" valign="top">
						  	<select name="state[]" id="state" multiple="multiple" style="width:200px;color:#666;">
                                <option value="">Any</option>
                                <?=MultiSelectionComboBox("select state_id,short_name from ".TABLE_STATE." order by short_name",$state_id_arr)?>
                            </select>	
						  </td>
						</tr>
						<tr><td>&nbsp;</td></tr>
				  </table>
			  
			  <?PHP
				}else{
					if($alert_row['industry_id'] !=''){
						$industryResult = com_db_query("select title from " . TABLE_INDUSTRY . " where industry_id in (".$alert_row['industry_id'].")");
						while($indRow = com_db_fetch_array($industryResult)){
							echo com_db_output($indRow['title']).'<br />';
						}
					}
					if($alert_row['revenue_size'] !=''){
						$revResult =com_db_query("select name from ".TABLE_REVENUE_SIZE. " where id in (".$alert_row['revenue_size'].")");
						while($revRow = com_db_fetch_array($revResult)){
							echo com_db_output($revRow['name']).'<br />';
						}
					}
					if($alert_row['employee_size'] !=''){
						$empResult = com_db_query("select name from ".TABLE_EMPLOYEE_SIZE. " where id in (".$alert_row['employee_size'].")");
						while($empRow = com_db_fetch_array($empResult)){
							echo com_db_output($empRow['name']).'<br />';
						}
					}
					$title = com_db_output($alert_row['title']);
						echo $title.'<br />';
					$country = com_db_GetValue("select countries_name from ".TABLE_COUNTRIES. " where countries_id='".$alert_row['country']."'");
						echo $country.'<br />';
					if($alert_row['state'] !=''){
						$stateResult = com_db_query("select short_name from ".TABLE_STATE. " where state_id in (".$alert_row['state'].")");
						while($stRow = com_db_fetch_array($stateResult)){
							echo com_db_output($stRow['short_name']).'<br />';
						}
					}
				}	
				?>
			  </td>
              <td width="108" height="36" align="left" valign="top" bgcolor="#CBDFE8" class="my-alert-text">
			  <?PHP if($action=='EditSave' && $alert_id==$alert_row['alert_id']){ ?>
				 
				  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
				  	<tr> <td>
						 <select name="delivery_schedule" id="delivery_schedule" style="width:100px;color:#666;">
                            <option value="">Any</option>
                            <?=selectComboBox("select name,name from ".TABLE_EMAIL_UPDATE." order by id",$alert_row['delivery_schedule'])?>
                         </select>
					  </td>
				    </tr>
				  </table>	  	
			 <?PHP }else{ 
			   		echo $alert_row['delivery_schedule'];
				}	
			   ?>
			  
			  </td>
              <td width="107" height="36" align="center" valign="top" bgcolor="#EDEDED" class="my-alert-text"><?=$add_date?> </td>
              <td width="116" align="center" valign="top" bgcolor="#CBDFE8" class="my-alert-text"><?=$alert_status?></td>
              <td width="186" align="center" valign="top" bgcolor="#EDEDED" class="my-alert-text">
			  	<strong>
					<?PHP if($action=='EditSave' && $alert_id==$alert_row['alert_id']){?>
					<a href="javascript:FormValueSubmit('frmMyAlert');">Save</a> &ndash; 
					<?PHP }else{ ?>
					<a href="<?=HTTP_SERVER?>my-alert.php?action=EditSave&altID=<?=$alert_row['alert_id'];?>">Edit</a> &ndash; 
					<?PHP } ?>
					<a href="<?=HTTP_SERVER?>my-alert.php?action=StatusChange&altID=<?=$alert_row['alert_id'];?>&status=<?=$alert_row['status'];?>"><?=$alert_caption;?> </a>- 
					<a href="javascript:setVisible('alert_popup_<?=$alert_row['alert_id']?>');">Delete</a></strong>
			  	<div id="alert_popup_<?=$alert_row['alert_id'];?>" class="new-alert-popup" style="display:none;">
					<div id="alert_popup_box_<?=$alert_row['alert_id'];?>" class="new-my-alert-popup-box">
					<div class="top"></div>
						<div class="middle">
							<div class="bold-text">Are you sure?</div>
							<div class="ok"><a href="<?=HTTP_SERVER?>my-alert.php?action=DeleteAlert&altID=<?=$alert_row['alert_id']?>">OK</a></div>
							<div class="cancel"><a href="javascript:setClose('alert_popup_<?=$alert_row['alert_id'];?>');">Cancel</a></div>
						</div>
					<div class="bottom"></div>
					</div>
				</div>
				
			  </td>
            </tr>
			<?PHP } 
			}else{
			?>
			<tr>
              <td colspan="6" height="36" align="center" valign="top" bgcolor="#EDEDED" class="my-alert-text"><strong>Alert not found</strong></td>
            </tr>
			
			<?PHP } ?>
           			
          </table>
		  </form>
		  
		  </td>
        </tr>
        <tr>
          <td align="center" valign="top"><img src="images/registration-page-bottom-bg.jpg" width="960" height="11" alt="" title="" /></td>
        </tr>
      </table></td>
      <td align="left"  valign="top">&nbsp;</td>
    </tr>
    <!-- content end-->
   
<?php      
include(DIR_INCLUDES."footer.php");
?>