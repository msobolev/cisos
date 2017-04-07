<?php
include("includes/include-top.php");

$sub_query = "select * from " . TABLE_SUBSCRIPTION ;
$sub_result = com_db_query($sub_query);
while($sub_row = com_db_fetch_array($sub_result)){
	if($sub_row['subscription_name'] == 'Free'){
		$free_sub_id = $sub_row['sub_id'];
		$free_subscription_name = com_db_output($sub_row['subscription_name']);
		$free_sub_header = com_db_output($sub_row['sub_header']);
		$free_sub_footer = com_db_output($sub_row['sub_footer']);
		$free_email_updates = com_db_output($sub_row['email_updates']);
		$free_search_database = com_db_output($sub_row['search_database']);
		$free_download_contacts = com_db_output($sub_row['download_contacts']);
		$free_price = com_db_output($sub_row['price']);
		$free_amount = $sub_row['amount'];
	}elseif($sub_row['subscription_name'] == 'Basic'){
		$basic_sub_id = $sub_row['sub_id'];
		$basic_subscription_name = com_db_output($sub_row['subscription_name']);
		$basic_sub_header = com_db_output($sub_row['sub_header']);
		$basic_sub_footer = com_db_output($sub_row['sub_footer']);
		$basic_email_updates = com_db_output($sub_row['email_updates']);
		$basic_search_database = com_db_output($sub_row['search_database']);
		$basic_download_contacts = com_db_output($sub_row['download_contacts']);
		$basic_price = com_db_output($sub_row['price']);
		$basic_amount = $sub_row['amount'];
	}elseif($sub_row['subscription_name'] == 'Standard'){
		$standard_sub_id = $sub_row['sub_id'];
		$standard_subscription_name = com_db_output($sub_row['subscription_name']);
		$standard_sub_header = com_db_output($sub_row['sub_header']);
		$standard_sub_footer = com_db_output($sub_row['sub_footer']);
		$standard_email_updates = com_db_output($sub_row['email_updates']);
		$standard_search_database = com_db_output($sub_row['search_database']);
		$standard_download_contacts = com_db_output($sub_row['download_contacts']);
		$standard_price = com_db_output($sub_row['price']);
		$standard_amount = $sub_row['amount'];
	}elseif($sub_row['subscription_name'] == 'Professional'){
		$professional_sub_id = $sub_row['sub_id'];
		$professional_subscription_name = com_db_output($sub_row['subscription_name']);
		$professional_sub_header = com_db_output($sub_row['sub_header']);
		$professional_sub_footer = com_db_output($sub_row['sub_footer']);
		$professional_email_updates = com_db_output($sub_row['email_updates']);
		$professional_search_database = com_db_output($sub_row['search_database']);
		$professional_download_contacts = com_db_output($sub_row['download_contacts']);
		$professional_price = com_db_output($sub_row['price']);
		$professional_amount = $sub_row['amount'];
	}
}
include(DIR_INCLUDES."header.php");
?>	 
    <!-- heading start -->
<tr>
      <td align="left"  valign="top">&nbsp;</td>
      <td align="left" valign="top">
	  <table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
	       <tr>
			<td align="left" valign="top" class="header-nav"><a href="index.html">Home</a>  /  <a href="#" class="active"><?=$PageTitle;?></a></td>
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
			  <td align="left" valign="middle" class="registration-page-title-text"><?=$PageTitle;?> </td>
			</tr>
		  </table></td>
		  </tr>
			 <tr>
		  <td align="left" valign="top"><img src="images/blue-down-arrow.jpg" width="235" height="13"  alt="" title="" /></td>
		  </tr>

      </table>
	  </td>
      <td align="left"  valign="top">&nbsp;</td>
    </tr>
    <!-- heading end -->
    <!-- content start -->
	
   <tr>
    <td width="21" align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top" bgcolor="#FFFFFF">
		<div id="main">
		<form method="post" name="frmChooscSub" id="frmChooscSub" action="res-price-process.php?action=ChoosePricing">
		<!-- Shell -->
		<div class="shell-new">
		<div class="shell-new-inner">
			
			<!-- Content -->
			<div class="content">
						
			<div id="wrapper">
			<!-- shell -->
				<div class="shell-new">
					<div class="main-heading">
						<div>
						<span class="yellow">Get Updated Emails of IT Execs Who Recently Changed Jobs to Instantly <br /> 
					  Engage Them as Your Prospective Clients</span>
					  	</div>
				  </div>
					<!-- END heading-->
					<!-- table -->
					<div>
						<div class="pagerepeat">
							<div class="left1">
								<div class="top-border">
								<?
								   $sub_alert_result =com_db_query("select * from ".TABLE_SUBSCRIPTION_ALERT);
								   while($saRow = com_db_fetch_array($sub_alert_result)){
										if($saRow['caption_name'] =='Email Updates'){
											 $email_update_alert = com_db_output($saRow['description']);
										}
										if($saRow['caption_name'] =='Search of the Database'){
											$search_database_alert = com_db_output($saRow['description']);
										}
										if($saRow['caption_name'] =='Download Contacts'){
											$download_contacts_alert = com_db_output($saRow['description']);
										}
									}	
								   ?>
									<div class="left3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
									  <tr>
										<td height="77" align="center" valign="middle">&nbsp;</td>
									  </tr>
									  <tr>
										<td height="50" align="left" valign="middle" class="chose1 text3">Chose if you’d like to: </td>
									  </tr>
									  <tr>
										<td height="51" align="left" valign="middle" class="top-border text3"><!--Email Updates&nbsp; <img src="css/images/question.png" alt="" />-->
										<p><strong>Email Updates</strong>
											<a href="#" class="question"><img src="css/images/question.png" alt="" />
												<span class="balloon">
													<span class="top">&nbsp;</span>
													<span class="center"><?=$email_update_alert?></span>
													<span class="bottom">&nbsp;</span>												</span>											</a>										</p>
										</td>
									  </tr>
									  <tr>
										<td height="50" align="left" valign="middle" class="chose1 text3"><!--Database Searches&nbsp; <img src="css/images/question.png" alt="" />-->
										<p><strong>Database Searches</strong>
											<a href="#" class="question"><img src="css/images/question.png" alt="" />
												<span class="balloon">
													<span class="top">&nbsp;</span>
													<span class="center"><?=$search_database_alert?></span>
													<span class="bottom">&nbsp;</span>												</span>											</a>										</p>
										</td>
									  </tr>
									  <tr>
										<td height="50" align="left" valign="middle" class="top-border text3"><!--Download Contacts&nbsp; <img src="css/images/question.png" alt="" />-->
										<p><strong>Download Contacts</strong>
											<a href="#" class="question"><img src="css/images/question.png" alt="" />
											<span class="balloon">
												<span class="top">&nbsp;</span>
												<span class="center"><?=$download_contacts_alert?></span>
												<span class="bottom">&nbsp;</span>
											</span>
											</a>
										</p>
										</td>
									  </tr>
									  
									</table>
									</div>
									<div id="DivFree" class="left4">
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
										  <tr>
											<td height="77" align="center" valign="middle" class="bigtext1">Free <br />
											<span class="text1">$<?=$free_amount?></span><span class="text2">/MONTH</span></td>
										  </tr>
										  <tr>
											<td height="50" align="center" valign="middle" class="chose1 subscription-text"><?=$free_sub_header?></td>
										  </tr>
										  <tr>
											<td height="51" align="center" valign="middle" class="top-border"><? if(strtolower($free_email_updates)=='yes'){echo '<img src="css/images/check.png" alt="" />';}else{echo '<img src="css/images/red-cross.gif" alt="" />';}?></td>
										  </tr>
										  <tr>
											<td height="50" align="center" valign="middle" class="chose1"><? if(!ctype_digit($free_search_database)){echo $free_search_database;}else{ echo $free_search_database.' searches / month';}?></td>
										  </tr>
										  <tr>
											<td height="50" align="center" valign="middle" class="top-border"><? if(!ctype_digit($free_download_contacts)){echo $free_download_contacts;}else{ echo $free_download_contacts.' profiles / month';}?></td>
										  </tr>
										 
										</table>
									</div>
									<div id="DivBasic" class="left4">
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
										  <tr>
											<td height="77" align="center" valign="middle" class="bigtext1">Basic <br />
											<span class="text1">$<?=$basic_amount?></span><span class="text2">/MONTH</span></td>
										  </tr>
										  <tr>
											<td height="50" align="center" valign="middle" class="chose1 subscription-text"><?=$basic_sub_header?></td>
										  </tr>
										  <tr>
											<td height="51" align="center" valign="middle" class="top-border"><? if(strtolower($basic_email_updates)=='yes'){echo '<img src="css/images/check.png" alt="" />';}else{echo '<img src="css/images/red-cross.gif" alt="" />';}?></td>
										  </tr>
										  <tr>
											<td height="50" align="center" valign="middle" class="chose1"><? if(!ctype_digit($basic_search_database)){echo $basic_search_database;}else{ echo $basic_search_database.' searches / month';}?></td>
										  </tr>
										  <tr>
											<td height="50" align="center" valign="middle" class="top-border"><? if(!ctype_digit($basic_download_contacts)){echo $basic_download_contacts;}else{ echo $basic_download_contacts.' profiles / month';}?></td>
										  </tr>
										 
										</table>
									</div>
									<div id="DivStandard" class="left4 left4_select">
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
										  <tr>
											<td height="77" align="center" valign="middle" class="bigtext1">Standard <br />
											<span class="text1">$<?=$standard_amount?></span><span class="text2">/MONTH</span></td>
										  </tr>
										  <tr>
											<td height="50" align="center" valign="middle" class="chose1 subscription-text"><?=$standard_sub_header?></td>
										  </tr>
										  <tr>
											<td height="51" align="center" valign="middle" class="top-border"><? if(strtolower($standard_email_updates)=='yes'){echo '<img src="css/images/check.png" alt="" />';}else{echo '<img src="css/images/red-cross.gif" alt="" />';}?></td>
										  </tr>
										  <tr>
											<td height="50" align="center" valign="middle" class="chose1"><? if(!ctype_digit($standard_search_database)){echo $standard_search_database;}else{ echo $standard_search_database.' searches / month';}?></td>
										  </tr>
										  <tr>
											<td height="50" align="center" valign="middle" class="top-border"><? if(!ctype_digit($standard_download_contacts)){echo $standard_download_contacts;}else{ echo $standard_download_contacts.' profiles / month';}?></td>
										  </tr>
										 
										</table>
									</div>
									<div id="DivProfessional" class="left4">
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
										  <tr>
											<td height="77" align="center" valign="middle" class="bigtext1">Professional <br />
											<span class="text1">$<?=$professional_amount?></span><span class="text2">/MONTH</span></td>
										  </tr>
										  <tr>
											<td height="50" align="center" valign="middle" class="chose1 subscription-text"><?=$professional_sub_header?></td>
										  </tr>
										  <tr>
											<td height="51" align="center" valign="middle" class="top-border"><? if(strtolower($professional_email_updates)=='yes'){echo '<img src="css/images/check.png" alt="" />';}else{echo '<img src="css/images/red-cross.gif" alt="" />';}?></td>
										  </tr>
										  <tr>
											<td height="50" align="center" valign="middle" class="chose1"><? if(!ctype_digit($professional_search_database)){echo $professional_search_database;}else{ echo $professional_search_database.' searches / month';}?></td>
										  </tr>
										  <tr>
											<td height="50" align="center" valign="middle" class="top-border"><? if(!ctype_digit($professional_download_contacts)){echo $professional_download_contacts;}else{ echo $professional_download_contacts.' profiles / month';}?></td>
										  </tr>
										 
										</table>
									</div>
									<div style="clear:both;"></div>
								</div>
								<div class="chose chose-new-text1">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
									<td width="130" height="49" align="left" valign="middle">Chose</td>
									<td width="163" align="center" valign="middle"><input name="radio_sub_id" type="radio" value="<?=$free_sub_id?>" onclick="SubscriptionSelect('DivFree')" class="redio-button"/></td>
									<td width="163" align="center" valign="middle"><input type="radio" name="radio_sub_id" value="<?=$basic_sub_id?>" onclick="SubscriptionSelect('DivBasic')" class="redio-button"/></td>
									<td width="163" align="center" valign="middle"><input type="radio" name="radio_sub_id" value="<?=$standard_sub_id?>" checked="checked" onclick="SubscriptionSelect('DivStandard')" class="redio-button"/></td>
									<td width="163" align="center" valign="middle"><input type="radio" name="radio_sub_id" value="<?=$professional_sub_id?>" onclick="SubscriptionSelect('DivProfessional')" class="redio-button"/></td>
								  </tr>
								</table>
								</div>
							</div>
							<div class="left2">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
									<td height="130" align="center" valign="middle"><img src="css/images/certificat.png" alt="" width="120" height="120" /></td>
								  </tr>
								  <tr>
									<td align="left" valign="top" class="padding1 newfont1"><p class="padding2">If you are not fully satisfied by our service and let us know within 30 days of signing up we will <span class="text4">fully refund your subscription fee</span>, no questions asked!</p>
											  <p>Your subscription is <span class="text4">absolutely risk-free</span> – you have nothing to lose.</p></td>
								  </tr>
								</table>
							</div>
							<div style="clear:both;"></div>
						</div>
						<div class="chose-subscription"><input type="image" src="css/images/chose-subscription.jpg" value="" name="" /></div>
					</div>
					<!-- END table-->
					<!-- gray-box -->
					<div class="gray-box-new1">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<td align="left" valign="top" class="newtext2">Frequently Asked Questions:</td>
						  </tr>
						  <tr>
							<td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
							  <tr>
								<td width="434" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
									<td align="left" valign="top" class="newtext3">Can I Upgrade / Downgrade my Subscription</td>
								  </tr>
								  <tr>
									<td align="left" valign="top" class="newtext4">Yes, you can change your subscription at any time.</td>
								  </tr>
								</table></td>
								<td width="40" align="left" valign="top">&nbsp;</td>
								<td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
									<td align="left" valign="top" class="newtext3">Can I cancel my subscription anytime?</td>
								  </tr>
								  <tr>
									<td align="left" valign="top" class="newtext4">Yes, you can stop the subscription at any time. Just drop us an <a href="mailto:support@ctosonthemove.com" class="small-link">email here</a>.</td>
								  </tr>
								</table></td>
							  </tr>
							  <tr>
								<td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
									<td align="left" valign="top" class="newtext3">Am I locked into a contract?</td>
								  </tr>
								  <tr>
									<td align="left" valign="top" class="newtext4">No! You can cancel any time you want without any fees or penalties.</td>
								  </tr>
								</table></td>
								<td align="left" valign="top">&nbsp;</td>
								<td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
									<td align="left" valign="top" class="newtext3">Are there any fees or penalties for cancelation?</td>
								  </tr>
								  <tr>
									<td align="left" valign="top" class="newtext4">Absolutely not. There are no fees or penalties for cancelation.</td>
								  </tr>
								</table></td>
							  </tr>
							  <tr>
								<td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
									<td align="left" valign="top" class="newtext3">How do I contact support?</td>
								  </tr>
								  <tr>
									<td align="left" valign="top" class="newtext4">Just drop us a line at <a href="mailto:support@ctosonthemove.com" class="small-link">support@ctosonthemove.com</a> we will get on it right away.</td>
								  </tr>
								</table></td>
								<td align="left" valign="top">&nbsp;</td>
								<td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
									<td align="left" valign="top" class="newtext3">Does your database include emails &amp; phone numbers?</td>
								  </tr>
								  <tr>
									<td align="left" valign="top" class="newtext4">Yes!</td>
								  </tr>
								</table></td>
							  </tr>
							  <tr>
								<td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
									<td align="left" valign="top" class="newtext3">How do you get your data?</td>
								  </tr>
								  <tr>
									<td align="left" valign="top" class="newtext5">We track in real-time over 50,000 various news sources – press releases, company announcements, SEC filings, social media, etc. This fire hose of data is then analyzed, de-duped, updated with contact details and industry taxonomy so it is immediately actionable for you.</td>
								  </tr>
								</table></td>
								<td align="left" valign="top">&nbsp;</td>
								<td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
								  <tr>
									<td align="left" valign="top" class="newtext3">Who uses your data?</td>
								  </tr>
								  <tr>
									<td align="left" valign="top" class="newtext5">Fortune 500 technology companies, worldwide technology consultancies and research organizations, leading providers of cloud solutions, hosting companies, advisors… we have a long list of happy clients.</td>
								  </tr>
								</table></td>
							  </tr>
							</table></td>
						  </tr>
						</table>
					</div>
					<!-- END gray-box-->
				</div>
				<!-- END shell-->	
			</div>
			
			
			</div>
			<!-- Content -->
			
			<div class="cl">&nbsp;</div>
				
		</div>
		</div>
		<!-- end Shell -->
		</form>
	</div>
	</td>
    <td width="21" align="left" valign="top">&nbsp;</td>
  </tr>
    <!-- content end-->
   <!-- footer link start -->
<?php include(DIR_INCLUDES."footer-link.php");?>
   <!-- footer link end -->
<?php      
include(DIR_INCLUDES."footer.php");
?>