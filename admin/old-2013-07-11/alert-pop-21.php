<?php
require('includes/include_top.php');
$uID = $_REQUEST['uID'];
$action = $_REQUEST['action'];
$msg = isset($_REQUEST['msg'])? msg_decode($_REQUEST['msg']) : '';
switch ($action){
	case 'activate':
			$status=$_GET['status'];
			$aID = $_GET['aID'];
			if($status==0){
				$query = "update " . TABLE_ALERT . " set status = '1' where alert_id = '" . $aID . "'";
			}else{
				$query = "update " . TABLE_ALERT . " set status = '0' where alert_id = '" . $aID . "'";
			}
			com_db_query($query);
			com_redirect("alert-pop.php?uID=" . $uID . "&msg=" . msg_encode("User Alert update successfully"));
		break;
		
	case 'AlertDelete':
			$aID = $_GET['aID'];
			$delQuery = "delete from ".TABLE_ALERT." where alert_id='".$aID."'";
			com_db_query($delQuery);
			com_redirect("alert-pop.php?uID=" . $uID . "&msg=" . msg_encode("User Alert delete successfully"));	
		break;
	case 'AlertEdit':
		$aID = $_REQUEST['aID'];
		$uID = $_REQUEST['uID'];
		$alertQuery = "select * from ".TABLE_ALERT." where user_id='".$uID."' and alert_id='".$aID."'";
		$alertResult = com_db_query($alertQuery);
		$altRow = com_db_fetch_array($alertResult);
		$title 				= $altRow['title'];
		$management 		= $altRow['type'];
		$country			= $altRow['country'];
		$state				= $altRow['state'];
		$city				= $altRow['city'];
		$zip_code			= $altRow['zip_code'];
		$company			= $altRow['company'];
		$industry			= $altRow['industry_id'];
		$revenue_size		= $altRow['revenue_size'];
		$employee_size		= $altRow['employee_size'];
		$delivery_schedule 	= $altRow['delivery_schedule'];
		$monthly_budget		= $altRow['monthly_budget'];
		break;

	case 'EditAlertSave':
		$aID = $_REQUEST['aID'];
		$title = com_db_input($_POST['title']);
		if($title == 'Type in the Title'){
			$title = '';
		}
		$type = $_POST['management'];
		$country = $_POST['country'];
		$state = $_POST['state'];
		$city = com_db_input($_POST['city']);
		if($city == 'Type in the City'){
			$city = '';
		}
		$zip_code = com_db_input($_POST['zip_code']);
		if($zip_code =='Type in the Zip code'){
			$zip_code = '';
		}
		$company = com_db_input($_POST['company']);
		if($company =='Type in the Company Name'){
			$company ='';
		}
		$industry_id = com_db_input($_POST['industry']);
		$revenue_size = com_db_input($_POST['revenue_size']);
		$employee_size = com_db_input($_POST['employee_size']);
		$delivery_schedule = $_POST['delivery_schedule'];
		$alert_date=date('Y-m-d',mktime(0,0,0,date('m'),date('d')+1,date('Y')));
		$monthly_budget = $_POST['monthly_budget'];
		$add_date = date('Y-m-d');
		$exp_date =date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('Y')+10));
		$user_id = $uID;
		$alert_query = "update " . TABLE_ALERT . " set title ='".$title."',type ='".$type."',country='".$country."',state='".$state."',city='".$city."',zip_code='".$zip_code."',company='".$company."',industry_id='".$industry_id."',revenue_size='".$revenue_size."',employee_size='".$employee_size."',delivery_schedule='".$delivery_schedule."', 	modify_date='".date('Y-m-d')."' where alert_id='".$aID."'";
		com_db_query($alert_query);
					
		com_redirect("alert-pop.php?uID=" . $uID . "&msg=" . msg_encode("User Alert update successfully"));	
		com_redirect($url);
					 	
}			

$user_name = com_db_GetValue("select concat(first_name,' ',last_name) as full_name from ". TABLE_USER." where user_id='".$uID."'");
$alert_query = "select * from " . TABLE_ALERT . " where user_id ='".$uID."'";
$alert_result = com_db_query($alert_query);

?>
<html>
<link href="style.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="includes/validation.js"></script>
<script language="javascript" type="text/javascript">
	function confirm_artivate(aid,uid,status){
	if(status=='1'){
		var msg="Alert will be active. \n Do you want to continue?";
	}else{
		var msg="Alert will be Inactive. \n Do you want to continue?";
	}
	var agree=confirm(msg);
	if (agree)
		window.location = "alert-pop.php?aID=" + aid + "&uID=" + uid + "&status=" + status + "&action=activate";
	else
		window.location = "alert-pop.php?action=Status&aID=" + aid + "&uID=" + uid ;
}
function confirm_del(aid,uid){
	var agree=confirm("Alert will be deleted. \n Do you want to continue?");
	if (agree)
		window.location = "alert-pop.php?aID="+aid+"&uID=" + uid + "&action=AlertDelete";
	else
		window.location = "alert-pop.php?&uID=" + uid ;
}

</script>
<body>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" >
	  <tr>
		<td align="center" valign="middle" class="right">
		 <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
            	<td width="50%" align="center"><strong><span class="right-box-title-text"><?=$user_name?></span></strong> </td>
                <td width="50%" align="center"><strong><span class="right-box-title-text"><?=$msg?></span></strong> </td>
			</tr>
		  </table>
		  </td>
	  </tr>
       
          <tr>
            <td align="left" valign="top" class="right-bar-content-border">
			<? if($action=='' or $action=='activate'){?>
			<form name="topicform" action="alert-pop.php" method="post">
			<table width="100%" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="24" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-title-text">#</span></td>
				
				<td width="217" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Title</span></td>
				<td width="95" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Type</span> </td>
                <td width="220" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Company</span></td>
				<td width="95" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Sent Email Details.</span> </td>
				<td width="114" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Delivery Schedule</span></td>
				<td width="103" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Expiration Date</span></td>
				<td width="81" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Create Date</span> </td>
                <td width="89" height="30" align="center" valign="middle" class="left-border"><div align="center"><span class="right-box-title-text">Action</span></div></td>
			  </tr>
			<?php
		
				$i=1;
				while ($data_sql = com_db_fetch_array($alert_result)) {
				$title = com_db_output($data_sql['title']);//com_db_GetValue("select title from ".TABLE_TITLE." where id ='".$data_sql['title']."'");
				$type = com_db_GetValue("select name from ".TABLE_MANAGEMENT_CHANGE." where id ='".$data_sql['type']."'");
				$company = $data_sql['company'];
				$delivery_schedule = $data_sql['delivery_schedule'];
				$added_date = $data_sql['add_date'];
				$exp_date = $data_sql['exp_date'];
				$alert_id = $data_sql['alert_id'];
				$status = $data_sql['status'];
				$tot_mail_send = com_db_GetValue("select count(alert_id) as cnt from " . TABLE_ALERT_SEND_INFO." where alert_id='".$data_sql['alert_id']."'");
			?>          
			  <tr>
				<td height="30" align="center" valign="middle" class="right-border-left"><?=$i;?></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><?=$title?></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><?=$type;?>&nbsp;</td>
				<td height="30" align="center" valign="middle" class="right-border-text"><?=$company;?>&nbsp;</td>
				<td height="30" align="center" valign="middle" class="right-border-text">
					<? if($tot_mail_send > 0){ ?>
					<a href="alert-pop.php?action=EmailDetails&uID=<?=$uID?>&alert_id=<?=$alert_id?>">Alert Email (<?=$tot_mail_send?>)</a>
					<? }else{ ?>
						Alert Email
					<? } ?> 
				</td>
                <td height="30" align="center" valign="middle" class="right-border">&nbsp;<?=$delivery_schedule?></td>
				<td height="30" align="left" valign="middle" class="right-border"><?=$exp_date?></td>
                <td height="30" align="center" valign="middle" class="right-border"><?=$added_date;?></td>
				<td height="30" align="center" valign="middle" class="left-border">
					<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr> 
					  	<?php if($status==0){ ?>
					   	<td width="29%" align="center" valign="middle" class="page-text"><a href="#"><img src="images/icon/active-icon.gif" width="16" height="16" alt="" title="" border="0" onClick="confirm_artivate('<?=$data_sql['alert_id'];?>','<?=$uID;?>','<?=$status;?>');" /></a><br />
					   	  Status</td>
					   	<?php } elseif($status==1){ ?>
					   	<td width="24%" align="center" valign="middle" class="page-text"><a href="#"><img src="images/icon/inactive-icon.gif" width="16" height="16" alt="" title="" border="0" onClick="confirm_artivate('<?=$data_sql['alert_id'];?>','<?=$uID;?>','<?=$status;?>');" /></a><br />
					   	  Status</td>
						<?php } ?>
                       <td width="23%" align="center" valign="middle" class="page-text"><a href="#"><img src="images/small-edit-icon.gif" width="16" height="16" alt="Edit" title="Edit" border="0" onClick="window.location='alert-pop.php?&aID=<?=$data_sql['alert_id'];?>&uID=<?=$data_sql['user_id'];?>&action=AlertEdit'" /></a><br />
						  Edit</td>
						<td width="24%" align="center" valign="middle" class="page-text"><a href="#"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" title="Delete" border="0" onClick="confirm_del('<?=$data_sql['alert_id'];?>','<?=$data_sql['user_id'];?>')" /></a><br />
						  Delete</td>
					  </tr>
					</table></td>
         	</tr> 
			<?php
			$i++;
				}
			
			?>     
         </table> 
		</form>
		<? }elseif($action=='EmailDetails'){ 
			$alert_id = $_REQUEST['alert_id'];
			$alert_title = com_db_GetValue("select title from " .TABLE_ALERT." where alert_id='".$alert_id."'");
			$alert_info_query = "select * from " . TABLE_ALERT_SEND_INFO . " where alert_id='".$alert_id."' order by sent_date desc" ;
			$alert_info_result = com_db_query($alert_info_query);
			if($alert_info_result){
				$alert_info_num = com_db_num_rows($alert_info_result);
			}
		?>
			<table width="100%" cellspacing="0" cellpadding="3" border="1" style="border-collapse:collapse; border:1px solid #86BFE8" bordercolor="#86BFE8" class="alert_email_content">
			  <tr>
				<td col colspan="3" height="30" align="center" valign="middle" class="alert_email_content11">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="75%" align="center"><?=$alert_title?></td>
							<td width="25%" align="right"><a href="alert-pop.php?uID=<?=$uID?>">Back to Alert</a></td>
						</tr>
				  </table>
				</td>
              </tr>	
			  <tr>
				<td width="33" height="30" align="center" valign="middle"><span class="right-box-title-text">#</span></td>
				<td width="764" height="30" align="center" valign="middle"><span class="right-box-title-text">Email Details </span></td>
				<td width="122" height="30" align="center" valign="middle"><span class="right-box-title-text">Email Send Date</span> </td>
              </tr>
			<?php
				if($alert_info_num > 0){
					$i=1;
					while ($alert_info_row = com_db_fetch_array($alert_info_result)) {
					$email_content = com_db_output($alert_info_row['email_content']);
					$sent_date = date('Y-m-d',$alert_info_row['sent_date']);
				?>          
				  <tr>
					<td height="30" align="center" valign="top" class="alert_email_content"><b><?=$i;?></b></td>
					<td height="30" align="left" valign="middle" class="alert_email_content11"><?=$email_content?></td>
					<td height="30" align="center" valign="top" class="alert_email_content"><b><?=$sent_date;?></b></td>
				  </tr> 
				<?php
					$i++;
					}
				}else{?>
				 <tr>
					<td colspan="3" height="30" align="left" valign="middle">Email not Sent yet</td>
				  </tr> 
				<? } ?>
			
         </table>
		<? }elseif($action=='AlertEdit'){ ?>
        	<table width="100%" cellspacing="0" cellpadding="3" border="1" style="border-collapse:collapse; border:1px solid #86BFE8" bordercolor="#86BFE8" class="alert_email_content">
			  <tr>
              	<td>
        		<form name="frm_alert" id="frm_alert" method="post" action="alert-pop.php?action=EditAlertSave&uID=<?=$uID?>&aID=<?=$aID?>">
			  <table width="673" border="0" align="center" cellpadding="0" cellspacing="0" >
				<tr>
				  <td align="left" valign="top">&nbsp;</td>
				</tr>
				
				<tr>
				  <td align="center" valign="top"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr>
						<td align="left" valign="top" class="page-text"><b>Chose Executive:</b></td>
					  </tr>
				  </table></td>
				</tr>
				
				<tr>
				  <td align="center" valign="middle">
				 
				  <table width="490" border="0" align="center" cellpadding="2" cellspacing="0">
					  <tr>
						<td width="204" height="27" align="left" class="page-text" valign="middle">Title:</td>
						<td width="278" align="left" valign="middle"><input name="title" type="text" id="title" size="46" value="<? if($title==''){echo 'Type in the Title';}else{echo $title;}?>" class="list-field" onFocus=" if (this.value == 'Type in the Title') { this.value = ''; };" onBlur="if (this.value == '') { this.value='Type in the Title';};"/>
					    </td>
					  </tr>
					  <tr>
						<td width="204" height="27" align="left" class="page-text" valign="middle">Management Change Type:</td>
						<td width="278" align="left" valign="middle">
							<select name="management" id="management" style="width:300px;">
								<option value="">Any</option>
								<?=selectComboBox("select id,name from ".TABLE_MANAGEMENT_CHANGE,$management)?>
							</select>	
							
						</td>
					  </tr>
				  </table></td>
				</tr>
				<tr>
				  <td align="left" valign="top">&nbsp;</td>
				</tr>
				<tr>
				  <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr>
						<td align="left" valign="top" class="page-text"><b>Chose Location:</b></td>
					  </tr>
				  </table></td>
				</tr>
				
				<tr>
				  <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="2" cellspacing="0">
					<tr>
					  <td width="232" height="27" align="left" valign="middle" class="page-text">Country:</td>
					  <td width="251" align="left" valign="middle">
					  	<select name="country" id="country" style="width:300px;">
							<?=selectComboBox("select countries_id,countries_name from ".TABLE_COUNTRIES,$country)?>
						</select>
						
					 </td>
					</tr>
					<tr>
					  <td width="232" height="27" align="left" valign="middle" class="page-text">State:</td>
					  <td width="251"  align="left" valign="middle">
					  	<select name="state" id="state" style="width:300px;">
							<option value="">Any</option>
							<?=selectComboBox("select state_id,short_name from ".TABLE_STATE,$state)?>
						</select>
									  
					  </td>
					</tr>
					<tr>
					  <td width="232" height="27" align="left" valign="middle" class="page-text">City:</td>
					  <td width="251" height="27" align="left" valign="middle"><input name="city" type="text" id="city" size="46" value="<? if($city==''){echo 'Type in the City';}else{echo $city;}?>" class="list-field" onFocus=" if (this.value == 'Type in the City') { this.value = ''; };" onBlur="if (this.value == '') { this.value='Type in the City';};"/></td>
					</tr>
					<tr>
					  <td width="232" height="27" align="left" valign="middle" class="page-text">Zip Code: </td>
					  <td width="251" height="27" align="left" valign="middle"><input name="zip_code" type="text" id="zip_code" size="46" value="<? if($zip_code==''){echo 'Type in the Zip code';}else{echo $zip_code;}?>" class="list-field" onFocus=" if (this.value == 'Type in the Zip code') { this.value = ''; };" onBlur="if (this.value == '') { this.value='Type in the Zip code';};"/></td>
					</tr>
				  </table></td>
				</tr>
				
				<tr>
				  <td align="left" valign="top">&nbsp;</td>
				</tr>
				<tr>
				  <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr>
						<td align="left" valign="top" class="page-text"><b>Chose Company:</b></td>
					  </tr>
				  </table></td>
				</tr>
				
				<tr>
				  <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="2" cellspacing="0">
					<tr>
					  <td width="232" height="27" align="left" valign="middle" class="page-text">Company:</td>
					  <td width="247" height="27" align="left" valign="middle"><input name="company" type="text" id="company" size="46" value="<? if($company==''){echo 'Type in the Company Name';}else{echo $company;}?>" class="list-field" onFocus=" if (this.value == 'Type in the Company Name') { this.value = ''; };AllComboDivCloseAlert('');fieldHighlight('company');" onBlur="if (this.value == '') { this.value='Type in the Company Name';};fieldLosslight('company');"/></td>
					</tr>
					<tr>
					  <td width="232" height="27" align="left" valign="middle" class="page-text">Industry:</td>
					  <td width="247"  align="left" valign="top">
					  	<?php
						$industry_result = com_db_query("select * from " . TABLE_INDUSTRY ." where parent_id = '0' order by industry_id");
						?>
						<select name="industry" id="industry" style="width:300px;">
							<option value="">All</option>
							<?php
							while($indus_row = com_db_fetch_array($industry_result)){
							?>
							<optgroup label="<?=$indus_row['title']?>">
							<?=selectComboBox("select industry_id,title from ". TABLE_INDUSTRY ." where parent_id ='".$indus_row['industry_id']."'" ,$industry);?>
							</optgroup>
							<? } ?>
							<option value="Any">Any</option>
						</select>
					  </td>
					</tr>
					<tr>
					  <td width="232" height="27" align="left" valign="middle" class="page-text">Size ($Revenue):</td>
					  <td width="247"  align="left" valign="middle">
					  	   <select name="revenue_size" id="revenue_size" style="width:300px;">
								<option value="">Any</option>
								<?=selectComboBox("select id,name from ".TABLE_REVENUE_SIZE." order by from_range",$revenue_size)?>
							</select>
					 </td>
					</tr>
					<tr>
					  <td width="232" height="27" align="left" valign="middle" class="page-text">Size (Employees):</td>
					  <td width="247"  align="left" valign="top">
					  		<select name="employee_size" id="employee_size" style="width:300px;">
								<option value="">Any</option>
								<?=selectComboBox("select id,name from ".TABLE_EMPLOYEE_SIZE." order by from_range",$employee_size)?>
							</select>
						
					  </td>
					</tr>
				  </table></td>
				</tr>
				<tr>
				  <td align="left" valign="top">&nbsp;</td>
				</tr>
				<tr>
				  <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr>
						<td align="left" valign="top" class="page-text"><b>Chose Frequency and Budget:</b></td>
					  </tr>
				  </table></td>
				</tr>
				
				<tr>
				  <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0">
				   
					  <tr>
						<td align="left" valign="top"><table width="490" border="0" align="center" cellpadding="2" cellspacing="0">
							<tr>
								<td width="209" height="27" align="left" valign="middle" class="page-text">Email Alerts will be delivered:</td>
								 <td width="273"  align="left" valign="middle">
									<select name="delivery_schedule" id="delivery_schedule" style="width:300px;">
										<option value="">Any</option>
										<?=selectComboBox("select name, name from " . TABLE_EMAIL_UPDATE. " order by id",$delivery_schedule)?>
									</select>
								
							  </td>
							</tr>
						</table></td>
					  </tr>
					  <tr>
						 <td align="left" valign="top"><img src="images/specer.gif" width="1" height="8" alt="" title="" /></td>
					  </tr>
					 <!-- <tr>
						<td align="left" valign="top" class="page-text">There is a $45 one-time set up fee per alert, and $4.5 per  each alert delivered to your inbox, up to a monthly budget that you set up.  </td>
					  </tr>
					  <tr>
					   <td align="left" valign="top"><img src="images/specer.gif" width="1" height="8" alt="" title="" /></td>
					  </tr>
					  <tr>
						<td align="left" valign="top"><table width="490" border="0" align="center" cellpadding="2" cellspacing="0">
							<tr>
							  <td width="212" height="26" align="left" valign="middle" class="page-text">Chose&nbsp;your&nbsp;monthly&nbsp;budget:</td>
							  <td width="270"  align="left" valign="top">
							  		<? //$buget_query = "select ap_name, ap_name from " . TABLE_ALERT_PRICE ." order by ap_amount";	
									   //$buget_result = com_db_query($buget_query);
									   ?>
								 	<select name="monthly_budget" id="monthly_budget" style="width:300px;">
										<option value="">Any</option>
										<?
										/*while($buget_row=com_db_fetch_array($buget_result)){
											if($buget_row['ap_name']=='Unlimited'){
												if($buget_row['ap_name']==$monthly_budget){
													echo '<option value="'.$buget_row['ap_name'].'" selected="selected">'.$buget_row['ap_name'].'</option>';
												}else{
													echo '<option value="'.$buget_row['ap_name'].'">'.$buget_row['ap_name'].'</option>';
												}
											}else{
												if('$'.$buget_row['ap_name']==$monthly_budget){
													echo '<option value="$'.$buget_row['ap_name'].'" selected="selected">$'.$buget_row['ap_name'].'</option>';
												}else{
													echo '<option value="$'.$buget_row['ap_name'].'">$'.$buget_row['ap_name'].'</option>';
												}
											}
										}*/
										?>
									</select>
							 </td>
							</tr>
						</table></td>
					  </tr>
				  </table></td>
				</tr>-->
				<tr>
				  <td align="center" valign="middle">&nbsp;</td>
				</tr>
				<tr>
				  <td align="center" valign="middle"><table width="146" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
					  <td align="center" valign="top"><input type="submit" name="createAlert" value="Edit Alert" /></a></td>
					</tr>
				  </table></td>
				</tr>
		
			  </table>
			  </form>
              	</td>
               </tr>
            </table>    
        <? } ?>
	</td>
  </tr>
  <tr><td>&nbsp;</td></tr>
</table>
</body>
</html>