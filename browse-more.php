<?php
include("includes/include-top.php");
$type=$_REQUEST['type'];
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
    <!-- content start -->
   <tr>
      <td align="left"  valign="top">&nbsp;</td>
      <td align="left" valign="top"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
	  	  	      <tr>
        <td align="left" valign="top"><img src="images/specer.gif" width="1" height="22" alt="" title="" /></td>
      </tr>
    <tr>
      <td align="left" valign="middle"   class="nav_bg">
			<ul>
            <li ><a href="<?=HTTP_SERVER?>index.php" title="Search"><em><b>SEARCH</b></em></a></li>
            <li><a href="<?=HTTP_SERVER?>browse.php" title="Browse"   class="active"><em><b>BROWSE</b></em></a></li>
            <li><a href="<?=HTTP_SERVER?>alert.php" title="Alert"><em><b>ALERT</b></em></a></li>
            </ul>				</td>
      </tr>
        <tr>
          <td align="left" valign="top"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
			
              <td width="737" align="center" valign="top">
			  <table width="737" border="0" cellspacing="0" cellpadding="0">
                     <tr>
                              <td align="left" valign="top"><img src="images/specer.gif" width="1" height="7" alt="" title="" /></td>
                      </tr>
                         <tr>			  
                        <td align="left" valign="top"><img src="images/browse-box-top-new.jpg" width="735" height="14"  alt="" title=""/></td>
                        </tr>
                      <tr>
                        <td height="460" align="center" valign="top" class="browse-box-new-inner-bg"><table width="681" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="left" valign="top"><table width="400" border="0" align="left" cellpadding="0" cellspacing="0">
                          <tr>
                            <td align="left" valign="top"><img src="images/specer.gif" width="1" height="8" alt="" title="" /></td>
                          </tr>
                          <tr>
                            <td align="left" valign="top"   class="browse-page-content-heading-text">
							<?
							if($type=='Revenue'){
								echo 'Size (Revenue)';
							}elseif($type=='Employee'){
								echo 'Size (Employees)';
							}elseif($type=='TimePeriod'){
								echo 'Time Period';
							}else{
								echo $type;
							}	
							?>
							:</td>
                          </tr>
                          <tr>
                            <td align="left" valign="top"><img src="images/specer.gif" width="1" height="18" alt="" title="" /></td>
                          </tr>
                          <tr>
                            <td align="left" valign="top"  class="browse-page-content-link-text">
								<?
								if($type=='Industry'){
									$industry_result = com_db_query("select * from " . TABLE_INDUSTRY . " where parent_id = '0' order by title");
								?>
								<table width="410" border="0" align="left" cellpadding="0" cellspacing="0">
									<? while($ind_row = com_db_fetch_array($industry_result)){
								   $tot_cnt = com_db_GetValue("select count(move_id) as cnt from " . TABLE_MOVEMENT_MASTER . " as mm,". TABLE_COMPANY_MASTER." as cm,".TABLE_PERSONAL_MASTER." as pm where mm.company_id = cm.company_id and mm.personal_id=pm.personal_id and cm.ind_group_id = '". $ind_row['industry_id']."' and mm.status='0'");
								   ?>
									<tr>
									  <td align="left" valign="top">
									  <div class="browse-page-content-link-box1">
										  	<div class="left-text-box1"><a href="<?=HTTP_SERVER?>search-result.php?action=Industry&amp;IndGroupID=<?=$ind_row['industry_id']?>"><?=str_replace('&','&amp;', $ind_row['title']);?></a></div>
											<div class="right-text-box1">(<?=$tot_cnt;?>)</div>
									  </div></td>
									</tr>
									<? } ?>
								</table>
								<? }elseif($type=='Geography'){
							  	  $state_result = com_db_query("select * from " . TABLE_STATE . " order by state_name");
								?>
								<table width="410" border="0" align="left" cellpadding="0" cellspacing="0">
									<? 
									while($state_row = com_db_fetch_array($state_result)){
								   	$tot_cnt = com_db_GetValue("select count(move_id) as cnt from " . TABLE_MOVEMENT_MASTER . " as mm,". TABLE_COMPANY_MASTER." as cm,".TABLE_PERSONAL_MASTER." as pm where (mm.company_id = cm.company_id and mm.personal_id=pm.personal_id) and mm.status='0' and cm.state = '". $state_row['state_id']."'");
								   ?>
									<tr>
									  <td align="left" valign="top">
									  <div class="browse-page-content-link-box1">
										  	<div class="left-text-box1"><a href="<?=HTTP_SERVER?>search-result.php?action=Geography&amp;stateName=<?=$state_row['state_id']?>"><?=$state_row['state_name']?></a></div>
											<div class="right-text-box1">(<?=$tot_cnt;?>)</div>
									  </div></td>
									</tr>
									<? } ?>
								</table>
								<? }elseif($type=='Title'){
							  	  $title_result = com_db_query("select * from " . TABLE_TITLE . " where title<>'Other' order by title");
								?>
								<table width="410" border="0" align="left" cellpadding="0" cellspacing="0">
									<? 
									 $title_list='';
									 while($title_row = com_db_fetch_array($title_result)){
									   $tot_cnt = com_db_GetValue("select count(move_id) as cnt from " . TABLE_MOVEMENT_MASTER . " where status='0' and title = '". $title_row['title']."'");
									   if($title_list==''){
									   		$title_list = "'". $title_row['title']."'";
									   }else{
									   		$title_list .= ",'". $title_row['title']."'";
									   }
								   ?>
									<tr>
									  <td align="left" valign="top">
									  <div class="browse-page-content-link-box1">
										  	<div class="left-text-box1"><a href="<?=HTTP_SERVER?>search-result.php?action=Title&amp;titleName=<?=$title_row['title']?>"><?=$title_row['title']?></a></div>
											<div class="right-text-box1">(<?=$tot_cnt;?>)</div>
									  </div></td>
									</tr>
									<? } ?>
									<tr>
									  <td align="left" valign="top">
									  <? $other_tot_cnt = com_db_GetValue("select count(move_id) as cnt from " . TABLE_MOVEMENT_MASTER . " where status='0' and title not in (". $title_list.")");?>
									  <div class="browse-page-content-link-box1">
										  	<div class="left-text-box1"><a href="<?=HTTP_SERVER?>search-result.php?action=Title&amp;titleName=Other">Other</a></div>
											<div class="right-text-box1">(<?=$other_tot_cnt;?>)</div>
									  </div></td>
									</tr>
								</table>
								<? }elseif($type=='Revenue'){
							  	  $revenue_result = com_db_query("select * from " . TABLE_REVENUE_SIZE . " where 1 order by from_range");
								?>
								<table width="410" border="0" align="left" cellpadding="0" cellspacing="0">
									<? 
									 while($revenue_row = com_db_fetch_array($revenue_result)){
									   $tot_cnt = com_db_GetValue("select count(move_id) as cnt from " . TABLE_MOVEMENT_MASTER . " as mm,". TABLE_COMPANY_MASTER." as cm,".TABLE_PERSONAL_MASTER." as pm where mm.company_id = cm.company_id and mm.personal_id=pm.personal_id and cm.company_revenue = '".$revenue_row['id']."' and mm.status='0'");
								   ?>
									<tr>
									  <td align="left" valign="top">
									  <div class="browse-page-content-link-box1">
										  	<div class="left-text-box1"><a href="<?=HTTP_SERVER?>search-result.php?action=Revenue_Size&amp;rev_size_id=<?=$revenue_row['id']?>"><?=$revenue_row['name']?></a></div>
											<div class="right-text-box1">(<?=$tot_cnt;?>)</div>
									  </div></td>
									</tr>
									<? } ?>
								</table>
								<? }elseif($type=='Employee'){
							  	  $emp_result = com_db_query("select * from " . TABLE_EMPLOYEE_SIZE . " where 1 order by from_range");
								?>
								<table width="410" border="0" align="left" cellpadding="0" cellspacing="0">
									<? 
									while($emp_row = com_db_fetch_array($emp_result)){
									   $tot_cnt = com_db_GetValue("select count(move_id) as cnt from " . TABLE_MOVEMENT_MASTER . " as mm,". TABLE_COMPANY_MASTER." as cm,".TABLE_PERSONAL_MASTER." as pm where mm.company_id = cm.company_id and mm.personal_id=pm.personal_id and cm.company_employee = '".$emp_row['id']."' and mm.status='0'");
								   ?>
									<tr>
									  <td align="left" valign="top">
									  <div class="browse-page-content-link-box1">
										  	<div class="left-text-box1"><a href="<?=HTTP_SERVER?>search-result.php?action=Employee_Size&amp;emp_size_id=<?=$emp_row['id'];?>"><?=$emp_row['name']?></a></div>
											<div class="right-text-box1">(<?=$tot_cnt;?>)</div>
									  </div></td>
									</tr>
									<? } ?>
								</table>
								<? }elseif($type=='TimePeriod'){
							  	  $last_day = date('Y-m-d',mktime(0,0,0,date("m"),date("d")-1,date("Y")));
								  $last_day_cnt = com_db_GetValue("select count(move_id) as cnt from " . TABLE_MOVEMENT_MASTER . " where announce_date <= '".$last_day."' and announce_date >='". $last_day."' and status='0'");
								  $last_week = date('Y-m-d', mktime(0,0,0,date("m"),date("d")-6-date('N', mktime(0, 0, 0, date("m"), date("d"), date("Y"))),date("Y")));
								  $last_week_to = date('Y-m-d', mktime(0,0,0,date("m"),date("d")-date('N', mktime(0, 0, 0, date("m"), date("d"), date("Y"))),date("Y")));
								  $last_week_cnt = com_db_GetValue("select count(move_id) as cnt from " . TABLE_MOVEMENT_MASTER . " where announce_date >= '".$last_week."' and announce_date <= '".$last_week_to."' and status='0'");
								  $last_month = date('Y-m-d',mktime(0,0,0,date("m")-1,1,date("Y")));
								  $last_month_to = date('Y-m-d',mktime(0,0,0,date("m")-1,date('t',mktime(0,0,0,(date("m")-1),1,date("y"))),date("Y")));
								  $last_month_cnt = com_db_GetValue("select count(move_id) as cnt from " . TABLE_MOVEMENT_MASTER . " where announce_date >= '".$last_month."' and announce_date <= '".$last_month_to."' and status='0'");
								  $next_year = date('Y-m-d',mktime(0,0,0,1,1,date("Y")+1));
								  $next_year_to = date('Y-m-d',mktime(0,0,0,12,31,date("Y")+1));
								  $next_year_cnt = com_db_GetValue("select count(move_id) as cnt from " . TABLE_MOVEMENT_MASTER . " where announce_date >= '".$next_year."' and announce_date <= '".$next_year_to."' and status='0'");
								 
								?>
								<table width="410" border="0" align="left" cellpadding="0" cellspacing="0">
									<tr>
									  <td align="left" valign="top">
									  <div class="browse-page-content-link-box1">
										  	<div class="left-text-box1"><a href="<?=HTTP_SERVER?>search-result.php?action=Time_Period&from=<?=$last_day?>&amp;to=<?=$last_day?>">Since Yesterday</a></div>
											<div class="right-text-box1">(<?=$last_day_cnt?>)</div>
									  </div></td>
									</tr>
									<tr>
									  <td align="left" valign="top">
									  <div class="browse-page-content-link-box1">
										  	<div class="left-text-box1"><a href="<?=HTTP_SERVER?>search-result.php?action=Time_Period&from=<?=$last_week?>&amp;to=<?=$last_week_to?>">Last Week</a></div>
											<div class="right-text-box1">(<?=$last_week_cnt?>)</div>
									  </div></td>
									</tr>
									<tr>
									  <td align="left" valign="top">
									  <div class="browse-page-content-link-box1">
										  	<div class="left-text-box1"><a href="<?=HTTP_SERVER?>search-result.php?action=Time_Period&from=<?=$last_month?>&amp;to=<?=$last_month_to?>">Last Month</a></div>
											<div class="right-text-box1">(<?=$last_month_cnt?>)</div>
									  </div></td>
									</tr>
									<tr>
									  <td align="left" valign="top">
									  <div class="browse-page-content-link-box1">
										  	<div class="left-text-box1"><a href="<?=HTTP_SERVER?>search-result.php?action=Time_Period&from=<?=$next_year?>&amp;to=<?=$next_year_to?>">Next Year</a></div>
											<div class="right-text-box1">(<?=$next_year_cnt?>)</div>
									  </div></td>
									</tr>
									<?
									$min_date = com_db_GetValue("select min(announce_date) as cnt from " . TABLE_MOVEMENT_MASTER." where announce_date !='0000-00-00' and status='0'");
								  	$minY = explode('-',$min_date);
								  	$min_year = $minY[0];
									$yy=date("Y");
									for($q=$yy ; $q >= $min_year ; $q--){
									$year_from = date('Y-m-d',mktime(0,0,0,1,1,$q));
								  	$year_to = date('Y-m-d',mktime(0,0,0,12,31,$q));
								  	$this_year_cnt = com_db_GetValue("select count(move_id) as cnt from " . TABLE_MOVEMENT_MASTER . " where announce_date >= '".$year_from."' and announce_date <= '".$year_to."' and status='0'");
									if($q==date("Y")){	
								  	 	$year_caption = "This Year";
									}elseif($q==date("Y")-1){
										$year_caption = "Last Year";
									}else{
										$year_caption = "Year ".$q ;
									}
									 ?>
									 <tr>
									  <td align="left" valign="top">
									  <div class="browse-page-content-link-box1">
										  	<div class="left-text-box1"><a href="<?=HTTP_SERVER?>search-result.php?action=Time_Period&from=<?=$year_from?>&amp;to=<?=$year_to?>"><?=$year_caption?></a></div>
											<div class="right-text-box1">(<?=$this_year_cnt?>)</div>
									  </div></td>
									</tr>
									 <?
									}
									?>
								</table>
								<? } ?>							</td>
                          </tr>
                        </table></td>
                      </tr>
                    
                      
                    </table></td>
                  <tr>
                     <tr>
                    <td align="left" valign="top"><img src="images/browse-box-bottom-new.jpg" width="735" height="10"   alt="" title=""/></td>
                    </tr>
                </table>

			 
			  </td>
             
              <td width="235" align="left" valign="top"><table width="235" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                          <td align="left" valign="top"><img src="images/specer.gif" width="1" height="10" alt="" title="" /></td>
                  </tr>
				   <?php if($_SESSION['sess_user_id'] == '' ){ ?>
                   <tr>
                	<td align="left" valign="top">
                    <script type="text/javascript" language="javascript">
						
						function SignUpValidationNew(){
								
								var fname=document.getElementById('full_name_sign').value;
								if(fname=='' || fname=='Type your First and Last Name here'){
									document.getElementById('full_name_sign').focus();
									return false;
								}
								
								var email=document.getElementById('email_sign').value;
								if(email=='' || email=='Type your Work email address here'){
									document.getElementById('email_sign').focus();
									return false;
								}else{
									var reg=/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
									if(reg.test(email)==false){
										document.getElementById('email_sign').focus();
										return false;
									}else{
										var start_position = email.indexOf('@');
										var email_part = email.substring(start_position);
										var end_position = email_part.indexOf('.');
										var find_part = email_part.substring(0,end_position+1);
										var pemail = [<?=$banned_domain_array;?>];
										//['@yahoo.','@gmail.','@hotmail.','@msn.','@aol.'];
										var email_result = include(pemail, find_part);
										if(email_result){
											document.getElementById('email_sign').value ="Type your Work email address here";
											return false;
										}
									}
								}
							}
							
							function include(arr, obj) {
							  for(var i=0; i<arr.length; i++) {
								if (arr[i].toUpperCase() == obj.toUpperCase()) return true;
							  }
							}
					</script>
					<form name="sign_up" method="post" action="movement-next.php?action=BrowsePage" onsubmit="return SignUpValidationNew();" style="border:0px;margin:0px;padding:0px;">
					<input type="hidden" name="referring_links" id="referring_links" value="<?=$current_page?>"/>
                    <table width="235" border="0" align="center" cellpadding="0" cellspacing="0">
					   
					   <tr>
						<td align="center" valign="top" class="sign-up-box-bg"><table width="195" border="0" align="center" cellpadding="0" cellspacing="0">
					   
						   <tr>
							<td align="left" valign="top"><img src="images/specer.gif" width="1" height="15" alt="" title="" /></td>
						  </tr>
						  <tr>
							<td align="left" valign="middle" class="sign-up-box-bg-text">Sign up for free</td>
						  </tr>
						  <tr>
							<td align="left" valign="top"><img src="images/specer.gif" width="1" height="8" alt="" title="" /></td>
						  </tr>
						  <tr>
							<td align="left" valign="middle"><input name="full_name" id="full_name_sign" type="text" size="30"  value="Type your First and Last Name here" class="text-field-text" onfocus=" if (this.value == 'Type your First and Last Name here') { this.value = ''; }" onblur="if (this.value == '') { this.value='Type your First and Last Name here';} "  /></td>
						  </tr>
						  <tr>
							<td align="left" valign="top"><img src="images/specer.gif" width="1" height="8" alt="" title="" /></td>
						  </tr>
						  <tr>
							<td align="left" valign="middle"><input name="email" id="email_sign" type="text" size="30" value="Type your Work email address here" class="text-field-text" onfocus=" if (this.value == 'Type your Work email address here') { this.value = ''; }" onblur="if (this.value == '') { this.value='Type your Work email address here';} "  /></td>
						  </tr>
						  <tr>
						  <td align="left" valign="top"><img src="images/specer.gif" width="1" height="9" alt="" title="" /></td>
						  </tr>
						  <tr>
							<td align="center" valign="top">
								<input name="image" type="image" onmouseover="this.src='images/sign-up-buttn-blue-h.jpg'" onmouseout="this.src='images/sign-up-buttn-blue.jpg'" value="Sign Up" src="images/sign-up-buttn-blue.jpg" class="sign-up_buttn" alt="Sign Up" style="border:0px;"/>
							</td>
						  </tr>
                    		
                    </table></td>
                  </tr>
                  <tr>
                    <td align="center" valign="top"><img src="images/sign-up-box-bottom-bg.jpg" width="235" height="26" alt="" title="" /></td>
                  </tr>
				  
                </table>
				</form>
				</td>
              </tr>
			 
              <tr>
                 <td align="left" valign="top"><table width="235" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="center" valign="top" class="download-box-bg"><table width="195" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td align="left" valign="top"><img src="images/specer.gif" width="1" height="20" alt="" title="" /></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle" class="sign-up-box-bg-text">Download a White Paper</td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"><img src="images/specer.gif" width="1" height="23" alt="" title="" /></td>
                        </tr>

                        <tr>
                          <td align="center" valign="top"> <a href="<?=HTTP_SERVER?>white-paper.php">         
						  <input name="image" type="image" onmouseover="this.src='images/select-buttn-h.jpg'" onmouseout="this.src='images/select-buttn.jpg'" value="Sign Up" src="images/select-buttn.jpg" class="select_buttn" alt="Select" style="border:0px;"/></a>
						  </td>
                        </tr>
               
                    </table></td>
                  </tr>
                  <tr>
                    <td align="center" valign="top"><img src="images/sign-up-box-bottom-bg.jpg" width="235" height="26" alt="" title="" /></td>
                  </tr>
                </table></td>
              </tr>
			   <? } ?>
                  <tr>
                      <td align="left" valign="top"><table width="235" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="230" align="center" valign="top"  class="download-box-bg"><table width="230" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="left" valign="top">
						<? if($_SESSION['sess_is_user'] != 1){ $twitter_hight = 45;}else{$twitter_hight = 390;}?>
						<script type="text/javascript" src="http://widgets.twimg.com/j/2/widget.js"></script>
                            <script type="text/javascript">
								new TWTR.Widget({
								  version: 2,
								  type: 'profile',
								  rpp: 5,
								  interval: 6000,
								  width: 236,
								  height:<?=$twitter_hight;?>,
								  theme: {
									shell: {
									  background: '#307faa',
									  color: '#ffffff'
									},
									tweets: {
									  background: '#f3faff',
									  color: '#3b5998',
									  links: '#3b5998'
									}
								  },
								  features: {
									scrollbar: true,
									loop: false,
									live: false,
									hashtags: true,
									timestamp: true,
									avatars: false,
									behavior: 'all'
								  }
								}).render().setUser('CTOsOnTheMove').start();
								</script></td>
                      </tr>
                   
                    </table></td>
                  </tr>
                
                </table></td>
                  </tr>
              </table></td>
            </tr>
          </table></td>
        </tr>
      </table></td>
      <td align="left"  valign="top">&nbsp;</td>
    </tr>
	</table>
    </div>
    <!-- content end-->
<?php      
include(DIR_INCLUDES."footer-content-page.php");
?>