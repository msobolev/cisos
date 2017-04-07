<?php
include("includes/include-top.php");

$action = $_REQUEST['action'];
if($action=='SearchEdit'){
	$first_name = ($_POST['first_name']) ? $_POST['first_name'] : $_SESSION['sess_first_name'];
	$last_name = ($_POST['last_name']) ? $_POST['last_name'] : $_SESSION['sess_last_name'];
	$title = ($_POST['title']) ? $_POST['title'] : $_SESSION['sess_title'];
	$management = ($_POST['management']) ? explode(',', $_POST['management']) : explode(',', $_SESSION['sess_management']);
	
	$country = ($_POST['country']) ? explode(',', $_POST['country']) : explode(',', $_SESSION['sess_country']);
	$state = ($_POST['state']) ? explode(',', $_POST['state']) : explode(',', $_SESSION['sess_state']);
	$city = ($_POST['city']) ? $_POST['city'] : $_SESSION['sess_city'];
	$zip_code = ($_POST['zip_code']) ? $_POST['zip_code'] : $_SESSION['sess_zip_code'];
	
	$company = ($_POST['company']) ? $_POST['company'] : $_SESSION['sess_company'];
	$company_website = ($_POST['company_website']) ? preg_replace('/<br( )?(\/)?>/i', "\r", $_POST['company_website']) : preg_replace('/<br( )?(\/)?>/i', "\r",$_SESSION['sess_company_website']);
	
	$industry = ($_POST['industry']) ? explode(',', $_POST['industry']) : explode(',', $_SESSION['sess_industry']);
	$revenue_size = ($_POST['revenue_size']) ? explode(',', $_POST['revenue_size']) : explode(',', $_SESSION['sess_revenue_size']);
	$employee_size = ($_POST['employee_size']) ? explode(',', $_POST['employee_size']) : explode(',', $_SESSION['sess_employee_size']);
	
	$speaking = ($_POST['speaking']) ? $_POST['speaking'] : $_SESSION['sess_speaking'];
	$awards = ($_POST['awards']) ? $_POST['awards'] : $_SESSION['sess_awards'];
	$publication = ($_POST['publication']) ? $_POST['publication'] : $_SESSION['sess_publication'];
	$media_mentions = ($_POST['media_mentions']) ? $_POST['media_mentions'] : $_SESSION['sess_media_mentions'];
	$board = ($_POST['board']) ? $_POST['board'] : $_SESSION['sess_board'];
	
	$time_period = ($_POST['time_period']) ? $_POST['time_period'] : $_SESSION['sess_time_period'];
	$from_date = ($_POST['from_date']) ? $_POST['from_date'] : $_SESSION['sess_from_date'];
	$to_date = ($_POST['to_date']) ? $_POST['to_date'] : $_SESSION['sess_to_date'];
	
	$jobs = ($_POST['jobs']) ? $_POST['jobs'] : $_SESSION['sess_jobs'];
	$fundings = ($_POST['fundings']) ? $_POST['fundings'] : $_SESSION['sess_fundings'];
}
$search_msg = $_REQUEST['search_msg'];

include(DIR_INCLUDES."header-content-page.php");

?>
	
<div class="advanced-search" style="padding-top:30px;">
		<div class="page-head">
			<div class="shell">
				<div class="breadcrumbs">
					<a href="<?=HTTP_SERVER?>index.php">Home</a><span></span>Advanced Search
				</div><!-- /.breadcrumbs -->

				<h2>Advanced Search</h2>
			</div><!-- /.shell -->
		</div><!-- /.page-head -->	

		<div class="main">
			<div class="shell">
				<div class="search-form">
					<script type="text/javascript" src="selectuser.js" language="javascript"></script>
                     <script type="text/javascript">
                     	function DivDateContral(){
							var tp = document.getElementById('time_period').value;
							if(tp==8){
								document.getElementById('divCalender').style.display='block';
							}else{
								document.getElementById('divCalender').style.display='none';
							}
						}
                     </script>
          			  <form method="post" name="frmAdvSearch" id="frmAdvSearch" action="search-result.php?action=AdvanceSearch">
						<div class="form-content clearfix">
                        <div class="form-content-custom">
							<div class="fcol fcol1">
								<h3 class="ico-executive">Chose Executive</h3>
								<div class="fields">
									<div class="row"><label>First Name:</label><input type="text" name="first_name" id="first_name" title="" value="<?=$first_name?>" class="field" /></div><!-- /.row -->
									<div class="row"><label>Last Name:</label><input type="text" name="last_name" id="last_name" title="" value="<?=$last_name?>" class="field" /></div><!-- /.row -->
									<div class="row"><label>Title:</label><input type="text" name="title" id="title" title="" value="<?=$title?>" class="field" /></div><!-- /.row -->
									<div class="row"><label>Management Change Type:</label>
                                    <?PHP $management_result = com_db_query("select id,name from " . TABLE_MANAGEMENT_CHANGE ." order by name"); ?>
										<select  name="management[]" id="management" multiple data-placeholder="Any">
										  <?PHP while($management_row = com_db_fetch_array($management_result)){ 
                                                    if(in_array($management_row['id'],$management)){ ?>
                                                    <option value="<?=$management_row['id']?>" selected="selected"><?=$management_row['name']?></option>
                                                 <?PHP }else{ ?>
                                                    <option value="<?=$management_row['id']?>"><?=$management_row['name']?></option>
                                            <?PHP 		} 
                                                }
                                            ?>
										</select>
									</div><!-- /.row -->
								</div><!-- /.fields -->
							</div><!-- /.fcol fcol1 -->	
							</div>
                            
                           <div class="form-content-custom clearfix thick-border-1">
							<div class="fcol fcol1">
								<h3 class="ico-location">Chose location</h3>
								<div class="fields">
									<div class="row"><label>Country</label>
                                    <?PHP $country_result = com_db_query("select countries_id,countries_name from " . TABLE_COUNTRIES ." order by countries_name");?>
										<select name="country[]" id="country" multiple data-placeholder="Any">
											<?PHP while($country_row = com_db_fetch_array($country_result)){ 
														if(in_array($country_row['countries_id'],$country)){ ?>
														<option value="<?=$country_row['countries_id']?>" selected="selected"><?=$country_row['countries_name']?></option>
													 <?PHP }else{ ?>
														<option value="<?=$country_row['countries_id']?>"><?=$country_row['countries_name']?></option>
												<?PHP 		} 
													}
												?>
										</select>
									</div><!-- /.row -->
									<div class="row"><label>State</label>
                                    <?PHP $state_result = com_db_query("select state_id,short_name from " . TABLE_STATE ." order by short_name");?>
										<select name="state[]" id="state" multiple data-placeholder="Any">
											<?PHP while($state_row = com_db_fetch_array($state_result)){ 
													if(in_array($state_row['state_id'],$state)){ ?>
													<option value="<?=$state_row['state_id']?>" selected="selected"><?=$state_row['short_name']?></option>
												 <?PHP }else{ ?>
													<option value="<?=$state_row['state_id']?>"><?=$state_row['short_name']?></option>
											<?PHP 		} 
												}
											?>
										</select>
									</div><!-- /.row -->
									<div class="row"><label>City</label><input type="text" name="city" id="city" title="" value="<?=$city?>" class="field" /></div><!-- /.row -->
									<div class="row"><label>Zip Code:</label><input type="text" name="zip_code" id="zip_code" title="" value="<?=$zip_code?>" class="field" /></div><!-- /.row -->
								</div><!-- /.fields -->
							</div><!-- /.fcol fcol1 -->	
                            
							</div>
                          
							<div class="fcol fcol1-0">
								<h3 class="ico-company">Chose Company</h3>
								<div class="fields">
                                
									
                                <div class="row"><label>Company Name</label><input type="text" name="company" id="company" title="" value="<?=$company?>" class="field" /></div><!-- /.row -->
								<div class="row"><label class="posr-label-textarea-1">Paste URLs (up to 25) of companies you'd like to track</label>
									<textarea name="company_website" id="company_website" class="field-textarea" ><?=$company_website?></textarea>
								</div><!-- /.row -->
									<div class="row"><label>Industry</label>
										<select name="industry[]" id="industry" multiple data-placeholder="Any">
											<?PHP 
											$industry_result = com_db_query("select industry_id,title from " . TABLE_INDUSTRY ." where parent_id='0' and status=0");
											while($ind_group_row = com_db_fetch_array($industry_result)){ ?>
												<optgroup label="<?=$ind_group_row['title']?>"><?=$ind_group_row['title']?>
												<?PHP $industry_list_result = com_db_query("select industry_id,title from " . TABLE_INDUSTRY ." where parent_id='".$ind_group_row['industry_id']."'");
													while($ind_list_row = com_db_fetch_array($industry_list_result)){ 
														if(in_array($ind_list_row['industry_id'],$industry)){ ?>
														<option value="<?=$ind_list_row['industry_id']?>" selected="selected">&nbsp;&nbsp;<?=$ind_list_row['title']?></option>
													 <?PHP }else{ ?>
														<option value="<?=$ind_list_row['industry_id'];?>">&nbsp;&nbsp;<?=$ind_list_row['title'];?></option>
													 <?PHP }
													} ?>
                                                 </optgroup>
											<?PHP } ?>	
										</select>
									</div><!-- /.row -->
									<div class="row"><label>Size ($ Revenue)</label>
										<?PHP $revenue_size_result = com_db_query("select id,name from " .TABLE_REVENUE_SIZE. " where status=0 order by from_range") ;	?>
										<select name="revenue_size[]" id="revenue_size" multiple data-placeholder="Any">
											<?PHP while($revenue_size_row = com_db_fetch_array($revenue_size_result)){ 
													if(in_array($revenue_size_row['id'],$revenue_size)){ ?>
													<option value="<?=$revenue_size_row['id']?>" selected="selected"><?=$revenue_size_row['name']?></option>
												 <?PHP }else{ ?>
													<option value="<?=$revenue_size_row['id']?>"><?=$revenue_size_row['name']?></option>
											<?PHP 		} 
												}
											?>
										</select>
									</div><!-- /.row -->
                                   
									<div class="row"><label>Size (Employees)</label>
										<?PHP $employee_size_result = com_db_query("select id,name from " .TABLE_EMPLOYEE_SIZE. " where status=0 order by from_range");?>
										<select name="employee_size[]" id="employee_size" multiple data-placeholder="Any">
											<?PHP while($employee_size_row = com_db_fetch_array($employee_size_result)){ 
													if(in_array($employee_size_row['id'],$employee_size)){ ?>
													<option value="<?=$employee_size_row['id']?>" selected="selected"><?=$employee_size_row['name']?></option>
												 <?PHP }else{ ?>
													<option value="<?=$employee_size_row['id']?>"><?=$employee_size_row['name']?></option>
											<?PHP 		} 
												}
											?>
										</select>
									</div><!-- /.row -->
								</div><!-- /.fields -->
							</div><!-- /.fcol fcol1 -->	
  						<!-- xddd-->
                            
                        
							<div class="fcol fcol2 h204">
								<h3 class="ico-engagement">Chose Engagement Triggers</h3>
								<div class="row row-checkboxes setmargin ">
									<div class="checkbox-holder clearfix"><input type="checkbox" value="1" name="speaking" class="checkbox" id="speaking" <?PHP if($speaking==1){echo 'checked="checked"';}else{echo '';}?> /><label for="speaking">Speaking Engagements</label></div><!-- /.checkbox -->
									<div class="checkbox-holder clearfix"><input type="checkbox" value="1" name="awards" class="checkbox" id="awards" <?PHP if($awards==1){echo 'checked="checked"';}else{echo '';}?>/><label for="awards">Industry Awards</label></div><!-- /.checkbox -->
									<div class="checkbox-holder clearfix"><input type="checkbox" value="1" name="publication" class="checkbox" id="publication" <?PHP if($publication==1){echo 'checked="checked"';}else{echo '';}?>/><label for="publication">Publications</label></div><!-- /.checkbox -->
									<div class="checkbox-holder clearfix"><input type="checkbox" value="1" name="media_mentions" class="checkbox" id="media_mentions" <?PHP if($media_mentions==1){echo 'checked="checked"';}else{echo '';}?>/><label for="media_mentions">Media Mentions</label></div><!-- /.checkbox -->
									<div class="checkbox-holder clearfix"><input type="checkbox" value="1" name="board" class="checkbox" id="board" <?PHP if($board==1){echo 'checked="checked"';}else{echo '';}?>/><label for="board">Board Appointments</label></div><!-- /.checkbox -->
									<div class="checkbox-holder clearfix"><input type="checkbox" value="1" name="jobs" class="checkbox" id="jobs" <?PHP if($jobs==1){echo 'checked="checked"';}else{echo '';}?>/><label for="jobs">Jobs</label></div><!-- /.checkbox -->
									<div class="checkbox-holder clearfix"><input type="checkbox" value="1" name="fundings" class="checkbox" id="fundings" <?PHP if($fundings==1){echo 'checked="checked"';}else{echo '';}?>/><label for="fundings">Fundings</label></div><!-- /.checkbox -->
								</div><!-- /.row -->
							</div><!-- /.fcol fcol2 -->
							
                            <!--/xddd-->
						</div><!-- /.form-content -->
						<div class="form-bottom clearfix">
							<div class="fcol fcol1">
								<h3 class="ico-location">Chose Time Period:</h3>
								<div class="row">
									<?PHP $date_result = com_db_query("select id,name from " .TABLE_DATE_RENGE. " order by id");?>
									<select name="time_period" id="time_period" data-placeholder="Any" onchange="DivDateContral();">
                                    <option value="">Any Date Range</option>
									<?PHP while($dRow = com_db_fetch_array($date_result)){ 
                                                if($dRow['id']==$time_period){ ?>
                                                <option value="<?=$dRow['id']?>" selected="selected"><?=$dRow['name']?></option>
                                             <?PHP }else{ ?>
                                                <option value="<?=$dRow['id']?>"><?=$dRow['name']?></option>
                                            <?PHP 	} 
                                            }
                                        ?>
									</select>
									<span class="fields-arrow"></span>
								</div><!-- /.row -->
							</div><!-- /.fcol fcol1 -->

							<div id="divCalender" class="fcol fcol1" style="display:<?PHP if($time_period==8){echo 'block;';}else{echo 'none;';}?>">
								<div class="row row-datepicked clearfix">
									<div class="picker-col">
										<label>From:</label><input type="text" name="from_date" id="from_date" title="" value="<?=$from_date?>" class="field field110 datepicker-from" />
										<a href="#" class="ico-datepicker"></a>
									</div><!-- /.picker-col -->
									<div class="picker-col">
										<label>To:</label><input type="text" name="to_date" id="to_date" title="" value="<?=$to_date?>" class="field field110 datepicker-to" />
										<a href="#" class="ico-datepicker"></a>
									</div><!-- /.picker-col -->
								</div><!-- /.row -->
							</div><!-- /.fcol fcol1 -->

							<div class="fcol fcol1" style="float:right;">
								<div class="row clearfix"><input type="submit" value="Search" class="submit" /></div><!-- /.row -->
							</div><!-- /.fcol fcol1 -->
						</div><!-- /.form-bottom -->
					</form>
				</div><!-- /.search-form -->
			</div><!-- /.shell -->
		</div><!-- /.main -->		
	</div><!-- /.advanced-search -->
    
<?php      
include(DIR_INCLUDES."footer-content-page.php");
?>