<?php
include("includes/include-top.php");

$action = $_REQUEST['action'];
if($action=='ReadAlert'){
		$title 				= $_POST['title'];
		if($title=='e.g. Chief Information Officer'){
			$title ='';
		}
		$management 		= $_POST['management'];
		if($management>0){
			$management_type = com_db_output(com_db_GetValue("select name from " .TABLE_MANAGEMENT_CHANGE. " where id='".$management."'"));
		}
		$country			= $_POST['country'];
		if($country>0){
			$country_name = com_db_output(com_db_GetValue("select countries_name from " .TABLE_COUNTRIES. " where countries_id='".$country."'"));
		}
		$state_arr			= $_POST['state'];
		if(sizeof($state_arr)>0 && $state_arr[0] !=''){
			$state_id_arr = implode(",",$state_arr);
			$stateQuery = "select short_name from " .TABLE_STATE. " where state_id in (".$state_id_arr.")";
			$stateResult = com_db_query($stateQuery);
			$state_list = '';
			while($stateRow = com_db_fetch_array($stateResult)){
				if($state_list==''){
					$state_list = $stateRow['short_name'];
				}else{
					$state_list .= "<br>". $stateRow['short_name'];
				}
			}
		}
		$city				= $_POST['city'];
		
		$zip_code			= $_POST['zip_code'];
		if($zip_code =='Zip Code'){
			$zip_code='';
		}
		$company			= $_POST['company'];
		if($company =='e.g. Microsoft'){
			$company='';
		}
		$rep   = array("\r\n", "\n","\r");
		$company_website	= str_replace($rep, "<br />", $_POST['company_website']);
		
		$industry_arr		= $_POST['industry'];
		if(sizeof($industry_arr)>0 && $industry_arr[0] !=''){
			$industry_id_arr = implode(",",$industry_arr);
			$industryQuery = "select title from " .TABLE_INDUSTRY. " where industry_id in (".$industry_id_arr.")";
			$industryResult = com_db_query($industryQuery);
			$industry_list = '';
			while($industryRow = com_db_fetch_array($industryResult)){
				if($industry_list==''){
					$industry_list = $industryRow['title'];
				}else{
					$industry_list .= "<br>". $industryRow['title'];
				}
			}
		}
		$revenue_size_arr	= $_POST['revenue_size'];
		if(sizeof($revenue_size_arr)>0 && $revenue_size_arr[0] !=''){
			$revenue_size_id_arr = implode(",",$revenue_size_arr);
			$revenueQuery = "select name from " .TABLE_REVENUE_SIZE. " where id in (".$revenue_size_id_arr.")";
			$revenueResult = com_db_query($revenueQuery);
			$revenue_size_list = '';
			while($revenueRow = com_db_fetch_array($revenueResult)){
				if($revenue_size_list==''){
					$revenue_size_list = $revenueRow['name'];
				}else{
					$revenue_size_list .= "<br>". $revenueRow['name'];
				}
			}
		}
		
		$employee_size_arr	= $_POST['employee_size'];
		if(sizeof($employee_size_arr)>0 && $employee_size_arr[0] !=''){
			$employee_size_id_arr = implode(",",$employee_size_arr);
			$employeeQuery = "select name from " .TABLE_EMPLOYEE_SIZE. " where id in (".$employee_size_id_arr.")";
			$employeeResult = com_db_query($employeeQuery);
			$employeee_size_list = '';
			while($employeeRow = com_db_fetch_array($employeeResult)){
				if($employee_size_list==''){
					$employee_size_list = $employeeRow['name'];
				}else{
					$employee_size_list .= "<br>". $employeeRow['name'];
				}
			}
		}
		$speaking = $_POST['speaking'];
		$awards = $_POST['awards'];
		$publication = $_POST['publication'];
		$media_mentions = $_POST['media_mentions'];
		$board = $_POST['board'];
		
		$delivery_schedule 	= $_POST['delivery_schedule'];
		
		$jobs 	= $_POST['jobs'];
		$fundings 	= $_POST['fundings'];
		
}elseif($action=='AlertBack'){
		$title 				= $_POST['title'];
		$management 		= $_POST['management'];
		$country			= $_POST['country'];
		
		$state_id_arr		= explode(",", $_POST['state']);
		$city				= $_POST['city'];
		$zip_code			= $_POST['zip_code'];
		$company			= $_POST['company'];
		$company_website	=  $_POST['company_website'];
		$industry_id_arr		= explode(",",$_POST['industry']);
		$revenue_size_id_arr	= explode(",", $_POST['revenue_size']);
		
		$employee_size_id_arr	= explode(",",$_POST['employee_size']);
		
		$speaking = $_POST['speaking'];
		$awards = $_POST['awards'];
		$publication = $_POST['publication'];
		$media_mentions = $_POST['media_mentions'];
		$board = $_POST['board'];
		$delivery_schedule 	= $_POST['delivery_schedule'];
		
		$jobs 	= $_POST['jobs'];
		$fundings 	= $_POST['fundings'];
	
}

$email_action = $_REQUEST['actionEmail'];
if($email_action==SearchResult){
	//$title_now 			= explode(',', $_SESSION['sess_title']);
	$title				= $_SESSION['sess_title'];//com_db_output(com_db_GetValue("select title from " .TABLE_TITLE. " where id='".$title_now[0]."'"));
	$management_now		= explode(',',$_SESSION['sess_management']);	
	$management 		= com_db_output(com_db_GetValue("select name from " .TABLE_MANAGEMENT_CHANGE. " where id='".$management_now[0]."'"));
	$country_now		= explode(',',$_SESSION['sess_country']);
	$country			= com_db_output(com_db_GetValue("select countries_name from " .TABLE_COUNTRIES. " where countries_id='".$country_now[0]."'"));
	$state_now			= explode(',',$_SESSION['sess_state']);
	$state				= com_db_output(com_db_GetValue("select short_name from " .TABLE_STATE. " where state_id='".$state_now[0]."'"));
	$city				= $_SESSION['sess_city'];
	$zip_code			= $_SESSION['sess_zip_code'];
	
	$company			= $_SESSION['sess_company'];
	
	$industry_now		= explode(',',$_SESSION['sess_industry']);
	$industry			= com_db_output(com_db_GetValue("select title from " .TABLE_INDUSTRY. " where industry_id='".$industry_now[0]."'"));
	$revenue_size_now	= explode(',',$_SESSION['sess_revenue_size']);
	$revenue_size		= com_db_output(com_db_GetValue("select name from " .TABLE_REVENUE_SIZE. " where id='".$revenue_size_now[0]."'"));
	$employee_size_now	= explode(',',$_SESSION['sess_employee_size']);
	$employee_size		= com_db_output(com_db_GetValue("select name from " .TABLE_EMPLOYEE_SIZE. " where id='".$employee_size_now[0]."'"));
}
include(DIR_INCLUDES."header-content-page.php");
?>	 
    <div class="email-alert" style="padding-top:30px;">
		<div class="page-head">
			<div class="shell">
				<h2>Create an Email Alert</h2>
			</div><!-- /.shell -->
		</div><!-- /.page-head -->	

		<div class="main">
			<div class="shell">
				<div class="alert-form">
				<?PHP if($action =='' || $action == 'AlertBack'){ ?>
			  			<script type="text/javascript" src="selectuser.js" language="javascript"></script>
			 			<form name="frm_alert" id="frm_alert" method="post" action="alert.php?action=ReadAlert">
						<div class="form-content clearfix">
							<div class="fcol fcol2 h490">
								<h3 class="ico-executive">Chose Executive</h3>
								<div class="form-content">
									<div class="fields">
										<div class="row"><label>Title:</label><input type="text" name="title" id="title" title="e.g. Chief Information Officer" value="<?PHP if($title==''){echo 'e.g. Chief Information Officer';}else{echo $title;}?>" class="field" /></div><!-- /.row -->
										<div class="row"><label class="posr-label-select">Management<br /> Change Type:</label>
											<select name="management" id="management">
												<option value="">Any</option>
												<?=selectComboBox("select id,name from ".TABLE_MANAGEMENT_CHANGE." where id in (1,2,6) order by name",$management)?>
											</select>
										</div><!-- /.row -->
									</div><!-- /.fields -->
								</div><!-- /.form-content -->

								<h3 class="ico-executive">Chose location</h3>
								<div class="fields">
									<div class="row"><label>Country</label>
                                    	<?PHP if($country==''){$country='223';}?>
										<select name="country" id="country">
											<?=selectComboBox("select countries_id,countries_name from ".TABLE_COUNTRIES." order by countries_name",$country)?>
										</select>
									</div><!-- /.row -->
									<div class="row select140"><label>State</label>
										<select name="state[]" id="state" multiple data-placeholder="Any">
											<option value="">Any</option>
											<?=MultiSelectionComboBox("select state_id,short_name from ".TABLE_STATE." order by short_name",$state_id_arr)?>
										</select>
										<input name="zip_code" type="text" id="zip_code" title="Zip Code" value="<?PHP if($zip_code==''){echo 'Zip Code';}else{echo $zip_code;}?>" class="field field110 field110a" />
									</div><!-- /.row -->
									<div class="row"><label>City</label><input name="city" type="text" id="city" title="" value="<?=$city?>" class="field" /></div><!-- /.row -->
								</div><!-- /.fields -->
							</div><!-- /.fcol fcol2 -->	

							<div class="fcol fcol2 h490">
								<h3 class="ico-company">Chose Company</h3>
								<div class="fields">
									<div class="row"><label>Company Name</label><input name="company" type="text" id="company" title="e.g. Microsoft" value="<?PHP if($company==''){echo 'e.g. Microsoft';}else{echo $company;}?>" class="field" /></div><!-- /.row -->
									<div class="row row-textarea"><label class="posr-label-textarea" style="padding-right:10px;">Paste URLs (up to 25)<br />of companies you'd <br />like to track</label>
										<textarea name="company_website" id="company_website" class="field-textarea"><?=$company_website?></textarea>
									</div><!-- /.row -->
									<div class="row"><label>Industry</label>
									 	<?PHP 	$indQuery = "select industry_id,title from ".TABLE_INDUSTRY." where status=0 and parent_id=0";
                                            $indResult = com_db_query($indQuery);
                                		 ?>
										<select name="industry[]" id="industry" multiple data-placeholder="Any">
											<?PHP while($indRow = com_db_fetch_array($indResult)){ ?>
                                                <optgroup label="<?=com_db_output($indRow['title'])?>">
                                                    <?=MultiSelectionComboBox("select industry_id,title from ".TABLE_INDUSTRY." where status=0 and parent_id='".$indRow['industry_id']."'",$industry_id_arr)?>
                                                </optgroup>
                                                <?PHP } ?>
										 </select>
									</div><!-- /.row -->
									<div class="row"><label>Size ($ Revenue)</label>
										<select name="revenue_size[]" id="revenue_size" multiple data-placeholder="Any">
											<?=MultiSelectionComboBox("select id,name from ".TABLE_REVENUE_SIZE." where status=0 order by from_range",$revenue_size_id_arr)?>
										</select>
									</div><!-- /.row -->
									<div class="row"><label>Size (Employees)</label>
										<select name="employee_size[]" id="employee_size" multiple data-placeholder="Any">
											<?=MultiSelectionComboBox("select id,name from ".TABLE_EMPLOYEE_SIZE." where status=0 order by from_range",$employee_size_id_arr)?>
										</select>
									</div><!-- /.row -->
								</div><!-- /.fields -->
							</div><!-- /.fcol fcol2 -->	

						</div><!-- /.form-content -->
						<div class="form-bottom clearfix">
							<div class="fcol fcol2 h220" style="height:245px;">
								<h3 class="ico-engagement">Chose Engagement Triggers</h3>
								<div class="row row-checkboxes">
									<div class="checkbox-holder clearfix"><input type="checkbox" value="1" class="checkbox" name="speaking" id="speaking" <?PHP if($speaking==1){echo 'checked="checked"';}else{echo '';}?> /><label for="speaking">Speaking Engagements</label></div><!-- /.checkbox -->
									<div class="checkbox-holder clearfix"><input type="checkbox" value="1" class="checkbox" name="awards" id="awards" <?PHP if($awards==1){echo 'checked="checked"';}else{echo '';}?>/><label for="awards">Industry Awards</label></div><!-- /.checkbox -->
									<div class="checkbox-holder clearfix"><input type="checkbox" value="1" class="checkbox" name="publication" id="publication" <?PHP if($publication==1){echo 'checked="checked"';}else{echo '';}?>/><label for="publication">Publications</label></div><!-- /.checkbox -->
									<div class="checkbox-holder clearfix"><input type="checkbox" value="1" class="checkbox" name="media_mentions" id="media_mentions" <?PHP if($media_mentions==1){echo 'checked="checked"';}else{echo '';}?>/><label for="media_mentions">Media Mentions</label></div><!-- /.checkbox -->
									<div class="checkbox-holder clearfix"><input type="checkbox" value="1" class="checkbox" name="board" id="board" <?PHP if($board==1){echo 'checked="checked"';}else{echo '';}?>/><label for="board">Board Appointments</label></div><!-- /.checkbox -->
									<div class="checkbox-holder clearfix"><input type="checkbox" value="1" class="checkbox" name="jobs" id="jobs" <?PHP if($jobs==1){echo 'checked="checked"';}else{echo '';}?>/><label for="jobs">Jobs</label></div><!-- /.checkbox -->
									<div class="checkbox-holder clearfix"><input type="checkbox" value="1" class="checkbox" name="fundings" id="fundings" <?PHP if($fundings==1){echo 'checked="checked"';}else{echo '';}?>/><label for="fundings">Fundings</label></div><!-- /.checkbox -->
								</div><!-- /.row -->
							</div><!-- /.fcol fcol2 -->

							<div class="fcol fcol2 h220">
								<h3 class="ico-frequency">Chose Frequency</h3>
								<div class="row pt25"><label>Deliver email alerts</label>
									<select name="delivery_schedule" id="delivery_schedule">
										<?=selectComboBox("select name,name from ".TABLE_EMAIL_UPDATE." order by id",$delivery_schedule)?>
									</select>
								</div><!-- /.row -->
								<div class="row clearfix"><input type="submit" value="Create Alert" class="submit" /></div><!-- /.row -->
							</div><!-- /.fcol fcol2 -->
						</div><!-- /.form-bottom -->
					</form>
                 <?PHP }elseif($action=='ReadAlert'){?>
			  		<table width="673" border="0" align="center" cellpadding="0" cellspacing="0" >
                        <tr>
                          <td align="left" valign="top" style="font-size:20px;padding:10px 0 0 10px;">Confirm Your Email Alert</td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                          <td align="center" valign="top"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td align="left" valign="top" class="alert-page-content-heading-text">Chose Executive:</td>
                              </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle"><img src="images/line.gif" width="673" height="19"  alt="" title="" /></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle">
                         
                          <table width="490" border="0" align="center" cellpadding="2" cellspacing="0">
                              <tr>
                                <td width="232" height="27" align="left" valign="middle" class="list-field-text">Title:</td>
                                <td width="250" align="left" valign="top" class="list-field-text"><?=$title?> </td>
                              </tr>
                              <tr>
                                <td width="232" height="27" align="left" valign="middle" class="list-field-text">Management Change Type:</td>
                                <td width="250" align="left" valign="top" class="list-field-text"><?=$management_type?></td>
                              </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"><img src="images/specer.gif" width="1" height="35" alt="" title="" /></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td align="left" valign="top" class="alert-page-content-heading-text">Chose Location:</td>
                              </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle"><img src="images/line.gif" width="673" height="19"  alt="" title="" /></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="2" cellspacing="0">
                            <tr>
                              <td width="232" height="27" align="left" valign="middle" class="list-field-text">Country:</td>
                              <td width="251" align="left" valign="top" class="list-field-text"><?=$country_name?></td>
                            </tr>
                            <tr>
                              <td width="232" height="27" align="left" valign="top" class="list-field-text">State:</td>
                              <td width="251"  align="left" valign="top" class="list-field-text"><?=$state_list?></td>
                            </tr>
                            <tr>
                              <td width="232" height="27" align="left" valign="middle" class="list-field-text">City:</td>
                              <td width="251" height="27" align="left" valign="middle" class="list-field-text"><?=$city?></td>
                            </tr>
                            <tr>
                              <td width="232" height="27" align="left" valign="middle" class="list-field-text">Zip Code: </td>
                              <td width="251" height="27" align="left" valign="middle" class="list-field-text"><?=$zip_code?></td>
                            </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"><img src="images/specer.gif" width="1" height="35" alt="" title="" /></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td align="left" valign="top" class="alert-page-content-heading-text">Chose Company:</td>
                              </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle"><img src="images/line.gif" width="673" height="19"  alt="" title="" /></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="3" cellspacing="0">
                            <tr>
                              <td width="232" height="27" align="left" valign="top" class="list-field-text">Company:</td>
                              <td width="247" height="27" align="left" valign="top" class="list-field-text"><?=$company?></td>
                            </tr>
                            <tr>
                              <td width="232" height="27" align="left" valign="top" class="list-field-text">Include urls of companies <br /> 
                              you'd like to track:</td>
                              <td width="247" height="27" align="left" valign="top" class="list-field-text"><?=$company_website?></td>
                            </tr>
                            <tr>
                              <td width="232" height="27" align="left" valign="top" class="list-field-text">Industry:</td>
                              <td width="247"  align="left" valign="top" class="list-field-text"><?=$industry_list?></td>
                            </tr>
                            <tr>
                              <td width="232" height="27" align="left" valign="top" class="list-field-text">Size ($Revenue):</td>
                              <td width="247"  align="left" valign="top" class="list-field-text"><?=$revenue_size_list?></td>
                            </tr>
                            <tr>
                              <td width="232" height="27" align="left" valign="top" class="list-field-text">Size (Employees):</td>
                              <td width="247"  align="left" valign="top" class="list-field-text"><?=$employee_size_list?></td>
                            </tr>
							
							
							<tr>
                              <td width="232" height="27" align="left" valign="top" class="list-field-text">Jobs:</td>
                              <td width="247"  align="left" valign="top" class="list-field-text"><?PHP if($jobs==1){echo '<img src="css_new/images/check.png" alt="" />';}else{echo '<img src="css_new/images/red-cross.gif" alt="" />';}?></td>
                            </tr>
							
							
							
							<tr>
                              <td width="232" height="27" align="left" valign="top" class="list-field-text">Fundings:</td>
                              <td width="247"  align="left" valign="top" class="list-field-text"><?PHP if($fundings==1){echo '<img src="css_new/images/check.png" alt="" />';}else{echo '<img src="css_new/images/red-cross.gif" alt="" />';}?></td>
                            </tr>
							
							
                          </table></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"><img src="images/specer.gif" width="1" height="35" alt="" title="" /></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td align="left" valign="top" class="alert-page-content-heading-text">Chose Person:</td>
                              </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle"><img src="images/line.gif" width="673" height="19"  alt="" title="" /></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="3" cellspacing="0">
                            <tr>
                              <td width="232" height="27" align="left" valign="top" class="list-field-text">Speaking:</td>
                              <td width="247" height="27" align="left" valign="top" class="list-field-text"><?PHP if($speaking==1){echo '<img src="css_new/images/check.png" alt="" />';}else{echo '<img src="css_new/images/red-cross.gif" alt="" />';}?></td>
                            </tr>
                            <tr>
                              <td width="232" height="27" align="left" valign="top" class="list-field-text">Industry Awards</td>
                              <td width="247" height="27" align="left" valign="top" class="list-field-text"><?PHP if($awards==1){echo '<img src="css_new/images/check.png" alt="" />';}else{echo '<img src="css_new/images/red-cross.gif" alt="" />';}?></td>
                            </tr>
                            <tr>
                              <td width="232" height="27" align="left" valign="top" class="list-field-text">Publications:</td>
                              <td width="247"  align="left" valign="top" class="list-field-text"><?PHP if($publication==1){echo '<img src="css_new/images/check.png" alt="" />';}else{echo '<img src="css_new/images/red-cross.gif" alt="" />';}?></td>
                            </tr>
                            <tr>
                              <td width="232" height="27" align="left" valign="top" class="list-field-text">Media Mentions:</td>
                              <td width="247"  align="left" valign="top" class="list-field-text"><?PHP if($media_mentions==1){echo '<img src="css_new/images/check.png" alt="" />';}else{echo '<img src="css_new/images/red-cross.gif" alt="" />';}?></td>
                            </tr>
                            <tr>
                              <td width="232" height="27" align="left" valign="top" class="list-field-text">Board Appointments:</td>
                              <td width="247"  align="left" valign="top" class="list-field-text"><?PHP if($board==1){echo '<img src="css_new/images/check.png" alt="" />';}else{echo '<img src="css_new/images/red-cross.gif" alt="" />';}?></td>
                            </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"><img src="images/specer.gif" width="1" height="35" alt="" title="" /></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td align="left" valign="top" class="alert-page-content-heading-text">Chose Frequency and Budget:</td>
                              </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle"><img src="images/line.gif" width="673" height="19"  alt="" title="" /></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0">
                           
                              <tr>
                                <td align="left" valign="top"><table width="490" border="0" align="center" cellpadding="2" cellspacing="0">
                                    <tr>
                                        <td width="232" height="27" align="left" valign="middle" class="list-field-text">Email Alerts will be delivered:</td>
                                         <td width="251"  align="left" valign="top" class="list-field-text"><?=$delivery_schedule?></td>
                                    </tr>
                                </table></td>
                              </tr>
                                                  
                              <tr>
                               <td align="left" valign="top"><img src="images/specer.gif" width="1" height="8" alt="" title="" /></td>
                              </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle">
                                <table width="214" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td align="center" valign="top">
                                      <form name="frmAlertBack" id="frmAlertBack" method="post" action="alert.php?action=AlertBack">
                                      <table border="0" align="center" cellpadding="0" cellspacing="0">
                                        <tr><td>
                                            <input type="hidden" name="title" value="<?=$title?>"/>
                                            <input type="hidden" name="management" id="management" value="<?=$management?>"/>
                                            <input type="hidden" name="country" id="country" value="<?=$country?>"/>
                                            <input type="hidden" name="state" id="state" value="<?=$state_id_arr?>"/>
                                            <input type="hidden" name="city" id="city" value="<?=$city?>"/>
                                            <input type="hidden" name="zip_code" id="zip_code" value="<?=$zip_code?>"/>
                                            <input type="hidden" name="company" id="company" value="<?=$company?>"/>
                                            <input type="hidden" name="company_website" id="company_website" value="<?=$_POST['company_website'];?>"/>
                                            <input type="hidden" name="industry" id="industry" value="<?=$industry_id_arr?>"/>
                                            <input type="hidden" name="revenue_size" id="revenue_size" value="<?=$revenue_size_id_arr?>"/>
                                            <input type="hidden" name="employee_size" id="employee_size" value="<?=$employee_size_id_arr?>"/>
                                            <input type="hidden" name="speaking" id="speaking" value="<?=$speaking?>"/>
                                            <input type="hidden" name="awards" id="awards" value="<?=$awards?>"/>
                                            <input type="hidden" name="publication" id="publication" value="<?=$publication?>"/>
                                            <input type="hidden" name="media_mentions" id="media_mentions" value="<?=$media_mentions?>"/>
                                            <input type="hidden" name="board" id="board" value="<?=$board?>"/>
                                            <input type="hidden" name="delivery_schedule" id="delivery_schedule" value="<?=$delivery_schedule?>"/>
											
											 <input type="hidden" name="jobs" id="jobs" value="<?=$jobs?>"/>
											 <input type="hidden" name="fundings" id="fundings" value="<?=$fundings?>"/>
                                            
                                        </td></tr>
                                        <tr>
                                            <td align="center" valign="top" class="more_bottom">
                                            <a href="javascript:FormValueSubmit('frmAlertBack');"> Back</a>
                                        
                                        </td>
                                        </tr>
                                       </table>	
                                       </form>
                                      </td>
                                      <td align="center" valign="top">&nbsp;</td>
                                      <td align="center" valign="top">
                                         <form name="frmAlertConfirm" id="frmAlertConfirm" method="post" action="alert-pro.php?action=AlertCreate">
                                        <table border="0" align="center" cellpadding="0" cellspacing="0">
                                        <tr><td>
                                            <input type="hidden" name="title" value="<?=$title?>"/>
                                            <input type="hidden" name="management" id="management" value="<?=$management?>"/>
                                            <input type="hidden" name="country" id="country" value="<?=$country?>"/>
                                            <input type="hidden" name="state" id="state" value="<?=$state_id_arr?>"/>
                                            <input type="hidden" name="city" id="city" value="<?=$city?>"/>
                                            <input type="hidden" name="zip_code" id="zip_code" value="<?=$zip_code?>"/>
                                            <input type="hidden" name="company" id="company" value="<?=$company?>"/>
                                            <input type="hidden" name="company_website" id="company_website" value="<?=$_POST['company_website'];?>"/>
                                            <input type="hidden" name="industry" id="industry" value="<?=$industry_id_arr?>"/>
                                            <input type="hidden" name="revenue_size" id="revenue_size" value="<?=$revenue_size_id_arr?>"/>
                                            <input type="hidden" name="employee_size" id="employee_size" value="<?=$employee_size_id_arr?>"/>
                                            <input type="hidden" name="speaking" id="speaking" value="<?=$speaking?>"/>
                                            <input type="hidden" name="awards" id="awards" value="<?=$awards?>"/>
                                            <input type="hidden" name="publication" id="publication" value="<?=$publication?>"/>
                                            <input type="hidden" name="media_mentions" id="media_mentions" value="<?=$media_mentions?>"/>
                                            <input type="hidden" name="board" id="board" value="<?=$board?>"/>
                                            <input type="hidden" name="delivery_schedule" id="delivery_schedule" value="<?=$delivery_schedule?>"/>
											
											<input type="hidden" name="jobs" id="jobs" value="<?=$jobs?>"/>
                                            <input type="hidden" name="fundings" id="fundings" value="<?=$fundings?>"/>
                                        </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="top" class="more_bottom">	
                                            <a href="javascript:FormValueSubmit('frmAlertConfirm');"> Confirm</a>
                                            </td>
                                            </tr>
                                        </table>	
                                      </form>
                                      </td>
                                    </tr>
                                  </table>
                            </td>
                        </tr>
                
                        <tr>
                          <td align="center" valign="middle">&nbsp;</td>
                        </tr>
                      </table>
			  <?PHP } ?>   
				</div><!-- /.alert-form -->
			</div><!-- /.shell -->
		</div><!-- /.main -->		
	</div><!-- /.email-alert -->
<?php      
include(DIR_INCLUDES."footer-content-page.php");
?>