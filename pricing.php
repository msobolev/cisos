<?php

include("includes/include-top.php");

$sub_query = "select * from " . TABLE_SUBSCRIPTION ;
$sub_result = com_db_query($sub_query);
while($sub_row = com_db_fetch_array($sub_result)){
	if($sub_row['subscription_name'] == 'Basic'){
		$basic_sub_id = $sub_row['sub_id'];
		$basic_subscription_name = com_db_output($sub_row['subscription_name']);
		$basic_sub_header = com_db_output($sub_row['sub_header']);
		$basic_sub_footer = com_db_output($sub_row['sub_footer']);
		$basic_email_updates = com_db_output($sub_row['email_updates']);
		$basic_search_database = com_db_output($sub_row['search_database']);
		$basic_download_contacts = com_db_output($sub_row['download_contacts']);
 		$basic_users = com_db_output($sub_row['users']);
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
		$standard_users = com_db_output($sub_row['users']);
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
		$professional_users = com_db_output($sub_row['users']);
		$professional_price = com_db_output($sub_row['price']);
		$professional_amount = $sub_row['amount'];
	}
}
?>

<?PHP
$log_history_query="select * from " .TABLE_LOGIN_HISTORY." where last_respond_time >0 and add_date = '".date('Y-m-d')."' and log_status='Login'";
$log_history_result = com_db_query($log_history_query);
while($log_history_row = com_db_fetch_array($log_history_result)){
	if($log_history_row['last_respond_time'] > 0)
	$tot_off_time = time()-$log_history_row['last_respond_time'];
	if($tot_off_time > 600){
		$log_history_update = "update ".TABLE_LOGIN_HISTORY." set log_status='Logout', logout_time='".time()."' where add_date = '".date('Y-m-d')."' and log_status='Login' and user_id='".$log_history_row['user_id']."'";
		com_db_query($log_history_update);
	}
}
if($_SESSION['sess_payment'] == 'Not Complited'){
	if($current_page == 'provide-contact-information.php' || $current_page == 'choose-subscription.php' || $current_page == 'submit-payment.php'){
	//not redirect;
	}else{
		echo $url = "provide-contact-information.php?action=back&resID=".$_SESSION['sess_user_id'];
		com_redirect($url);
	}
}
if ($_SESSION['sess_user_id'] !='' and $_SESSION['sess_user_id'] > 0 ){
	
	$log_history_update = "update ".TABLE_LOGIN_HISTORY." set last_respond_time='".time()."' where add_date = '".date('Y-m-d')."' and log_status='Login' and user_id='".$_SESSION['sess_user_id']."'";
	com_db_query($log_history_update);
}
$asin = $_REQUEST['asin'];
?>	

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en-US" xmlns="http://www.w3.org/1999/xhtml" dir="ltr">

<head>
	<title><?PHP echo 'CISOsOnTheMove.com ::';?> Pricing</title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
 	<link rel="shortcut icon" href="css_pn/images/favicon.ico?v=<?php echo microtime(true); ?>" />
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css' />
	<link href='https://fonts.googleapis.com/css?family=Bitter:400,400italic,700' rel='stylesheet' type='text/css' />

	<link rel="stylesheet" href="css_pn/style.css?v=<?php echo microtime(true); ?>" type="text/css" media="all"/>

   	<script src="css_pn/js/jquery-1.11.0.min.js" type="text/javascript"></script>
	<script src="css_pn/js/functions.js" type="text/javascript"></script>
<script>

</script>
 </head>

<body>
	<div class="header">
		<div class="shell clearfix">
			<a href="#" class="logo">CISOs On The Move</a>

			<div class="header-inner clearfix">

<!--		     <div class="header-actions">
					<a href="#" class="btn-secondary btn-blue">Login</a>
				</div>
-->				
				<!-- /.header-actions -->

				<div class="nav">
					<ul>
						<li>
							<a href="<?=HTTP_SERVER?>index.php">Home</a>
						</li>

						<li>
						    <a href="<?=HTTP_SERVER?>advance-search.php">Search</a> 
						</li>

						<li>
							<a href="<?=HTTP_SERVER?>team.html">About us</a>
						</li>
  						
						<?PHP if($_SESSION['sess_is_user'] == 1){ ?>
					     <li><?=$_SESSION['sess_username']?>:&nbsp;<a href="<?=HTTP_SERVER?>my-profile.php">Profile</a></li>
					     <li><a href="<?=HTTP_SERVER?>logout.php" class="btn"><span>Log Out</span></a></li>
 						<?PHP }else{ ?>
					     <!-- <li><a href="<?=HTTP_SERVER?>price-new.php">Pricing</a></li> -->
                                             <li><a href="<?=HTTP_SERVER?>pricing.html">Pricing</a></li>
					     <li><a href="<?=HTTP_SERVER?>login.php" class="btn"><span>Login</span></a></li>
						<?php } ?>
						
					</ul>
				</div><!-- /.nav -->
			</div><!-- /.header-inner -->
		</div><!-- /.shell -->
	</div><!-- /.header -->

	<div class="section section-grey section-slogan">
		<div class="shell">
			<h2 class="slogan">Get Updated Emails of IT Security Execs Who Recently Changed Jobs to Instantly Engage Them as Your Prospective Clients.</h2><!-- /.slogan -->
		</div><!-- /.shell -->		
	</div><!-- /.section section-grey section-slogan -->

	<div class="section section-logos">
		<div class="shell">
			<h2>CISOs On The Move is Trusted by</h2>

			<ul class="list-logos clearfix">
				<li>
					<a href="#">
						<img src="css_pn/images/l1.png" alt="" />
					</a>
				</li>

				<li>
					<a href="#">
						<img src="css_pn/images/l2.png" alt="" />
					</a>
				</li>

				<li>
					<a href="#">
						<img src="css_pn/images/l3.png" alt="" />
					</a>
				</li>

				<li>
					<a href="#">
						<img src="css_pn/images/l4.png" alt="" />
					</a>
				</li>

				<li>
					<a href="#">
						<img src="css_pn/images/l5.png" alt="" />
					</a>
				</li>

				<li>
					<a href="#">
						<img src="css_pn/images/l6.png" alt="" />
					</a>
				</li>

				<li>
					<a href="#">
						<img src="css_pn/images/l7.png" alt="" />
					</a>
				</li>

				<li>
					<a href="#">
						<img src="css_pn/images/l8.png" alt="" />
					</a>
				</li>

				<li>
					<a href="#">
						<img src="css_pn/images/l9.png" alt="" />
					</a>
				</li>

				<li>
					<a href="#">
						<img src="css_pn/images/10.png" alt="" />
					</a>
				</li>

				<li>
					<a href="#">
						<img src="css_pn/images/11.png" alt="" />
					</a>
				</li>

				<li>
					<a href="#">
						<img src="css_pn/images/12.png" alt="" />
					</a>
				</li>
			</ul><!-- /.list-logos -->
		</div><!-- /.shell -->
	</div><!-- /.section section-logos -->

	<div class="section section-offers">
		<span class="stars-sep"></span>

		<div class="shell">
				<script type="text/ecmascript">
			    function SubscriptionSelect(subid){
				document.getElementById('radio_sub_id_two').value = subid;
				document.getElementById('frmChooscSub_two').submit();
			}
		</script>
	<form method="post" name="frmChooscSub" id="frmChooscSub_two" action="res-price-process.php?action=ChoosePricing">
        	 <input type="hidden" name="referring_links" id="referring_links" value="<?=$current_page?>"/>
        	 <input type="hidden" name="radio_sub_id" id="radio_sub_id_two" />
			
			<div class="cols-holder clearfix">
				<div class="col col-0">
					<div class="offer offer-primary">
						<div class="offer-head">
							<p><strong>Double the response rate</strong> of sales leads you engage and… at the same time <strong>cut sales cycle</strong> in half</p>
					
							<span class="white-arrow"></span>
						</div><!-- /.offer-head -->

						<div class="offer-body">
							<ul>
								<li>
									Users
									<a href="#" class="question-ico">
										<span class="balloon">
											<span class="top">&nbsp;</span>
											<span class="center">Every week you will receive a short update highlighting new appointments and promotions among senior Marketing execs.</span>
											<span class="bottom">&nbsp;</span>
										</span>
									</a>
								</li>
					
								<li>
									Email Updates

									<a href="#" class="question-ico">
										<span class="balloon">
											<span class="top">&nbsp;</span>
											<span class="center">Get instant access to a database with thousands of Marketing executives, including their updated contact details: email, phone, address, etc.</span>
											<span class="bottom">&nbsp;</span>
										</span>
									</a>
								</li>
					
								<li>
									Download Contacts

									<a href="#" class="question-ico">
										<span class="balloon">
											<span class="top">&nbsp;</span>
											<span class="center">Including emails, address, company size (# of employees and $ revenues, industry taxonomy and relevant information about the executive and the company</span>
											<span class="bottom">&nbsp;</span>
										</span>
									</a>
								</li>

								<li>
									Concierge Service

									<a href="#" class="question-ico">
										<span class="balloon">
											<span class="top">&nbsp;</span>
											<span class="center">
<!--											Including emails, address, company size (# of employees and $ revenues, industry taxonomy and relevant information about the executive and the company
-->											We send special gifts on your behalf to important potential clients on special occasions like appointments or industry awards
											</span>
											<span class="bottom">&nbsp;</span>
										</span>
									</a>
								</li>
							</ul>
						</div><!-- /.offer-body -->
					</div><!-- /.offer offer-primary -->
				</div><!-- /.col -->

				<div class="col col-1">
					<div class="offer offer-enterprise">
						<div class="offer-head">
							<h2>Enterprise</h2>
							
							<p>
								Call
								<strong>908.768.2664</strong>
							</p>			
						</div><!-- /.offer-head -->
						
						<div class="offer-info">
							<p>For robust <strong>enterprise teams with a broad market</strong></p>
						</div><!-- /.offer-info -->
						
						<div class="offer-body">
							<p><strong>Unlimited</strong></p>

							<p><span class="check-ico"></span></p>

							<p><strong>Unlimited</strong></p>

							<p><span class="check-ico"></span></p>
						</div><!-- /.offer-body -->

						<div class="offer-actions">
 							<a  href="mailto:ms@cmosonthemove.com?subject=interested in enterprise package"  class="btn-orange-small">Get started</a> 
 						</div><!-- /.offer-actions -->
					</div><!-- /.offer -->
				</div><!-- /.col -->

				<div class="col col-2">
					<div class="offer offer-professional">
						<div class="offer-head">
							<h2>Professional</h2>
											
							<strong>
								$<?php echo $professional_amount?>
								<span>per month <br /> <!--*billed annually--></span>
							</strong>
						</div><!-- /.offer-head -->
						
						<div class="offer-info">
							<p>For experienced <strong>teams looking for accelerated growth</strong></p>
						</div><!-- /.offer-info -->
						
						<div class="offer-body">
							<p><strong><?php echo $professional_users; ?></strong></p>
							
						   <?php 
							$ps_img_class='';
							if(strtolower($professional_email_updates)=='yes'){ 
							$ps_img_class="check-ico";
							}else{
							$ps_img_class="x-ico";
							}
							?>

							<p><span class="<?php echo $ps_img_class; ?>"></span></p>

							<p><strong><?PHP if(!ctype_digit($professional_download_contacts)){echo $professional_download_contacts;}else{ echo $professional_download_contacts.' profiles / month';}?></strong></p>
											
							<p><span class="x-ico"></span></p>
						</div><!-- /.offer-body -->

						<div class="offer-actions"> 
							<a href="javascript:;" onclick="SubscriptionSelect('<?=$professional_sub_id?>');" class="btn-orange-small">Get started</a>
						</div><!-- /.offer-actions -->
					</div><!-- /.offer -->
				</div><!-- /.col -->
			
				<div class="col col-3">
					<div class="offer offer-standard">
						<div class="offer-head">
							<h2>Standard</h2>
				
							<strong>
								$<?php echo $standard_amount?>
								<span>per month <br /> <!--*billed annually--></span>
							</strong>
						</div><!-- /.offer-head -->
						
						<div class="offer-info">
							<p>For <strong>teams</strong> focusing on <strong>aggressively expanding</strong> their target maket</p>
						</div><!-- /.offer-info -->
						
						<div class="offer-body">
							<p><strong><?php echo $standard_users; ?></strong></p>
						   <?php 
							$st_img_class='';
							if(strtolower($standard_email_updates)=='yes'){ 
							$st_img_class="check-ico";
							}else{
							$st_img_class="x-ico";
							}
							?>

							<p><span class="<?php echo $st_img_class; ?>"></span></p>
 							<!--<p><strong>300</strong> profiles/month</p>-->
							<p><?PHP if(!ctype_digit($standard_download_contacts)){echo $standard_download_contacts;}else{ echo $standard_download_contacts.' profiles / month';}?></p>
 							<p><span class="x-ico"></span></p>
						</div><!-- /.offer-body -->

						<div class="offer-actions"> 
							<a href="javascript:;" onclick="SubscriptionSelect('<?php echo $standard_sub_id?>');" class="btn-orange-small">Get started</a>
						</div><!-- /.offer-actions -->
					</div><!-- /.offer offer-standard -->
				</div><!-- /.col -->
			
				<div class="col col-4">
					<div class="offer offer-basic">
						<div class="offer-head">
							<h2>Basic</h2>
				
							<strong>
								$<?php echo $basic_amount?>
								<span>per month <br /> <!--*billed annually--></span>
							</strong>
						</div><!-- /.offer-head -->
						
						<div class="offer-info">
							<p>For <strong>niche players</strong> (focused geo, industry target)</p>
						</div><!-- /.offer-info -->
						
						<div class="offer-body">
							<p><strong><?php echo $basic_users; ?></strong></p>
							
							
							<?php 
							$bc_img_class='';
							if(strtolower($basic_email_updates)=='yes'){ 
							$bc_img_class="check-ico";
							}else{
							$bc_img_class="x-ico";
							}
							?>
   							<p><span class="<?php echo  $bc_img_class;?>" ></span></p>
 							<!--<p><strong>300</strong> profiles/month</p>-->
							<p><?PHP if(!ctype_digit($basic_download_contacts)){echo $basic_download_contacts;}else{ echo $basic_download_contacts.' profiles / month';}?></p>
 							<p><span class="x-ico"></span></p>
						</div><!-- /.offer-body -->

						<div class="offer-actions">
							<a href="javascript:;" onclick="SubscriptionSelect('<?php echo $basic_sub_id;?>');" class="btn-orange-small">Get started</a>
						</div><!-- /.offer-actions -->
					</div><!-- /.offer offer-basic -->
				</div><!-- /.col -->
			</div>
			
			</form>
			
			<!-- /.cols-holder -->

			<div class="section-foot">
				<p>
					Subscribe now with confidence: You have our 60-day money back guarantee<br />

					<strong>No minimum term - cancel anytime</strong>
				</p>
			</div><!-- /.section-foot -->
		</div><!-- /.shell -->
	</div><!-- /.section sectio-offers -->

	<div class="section section-testimonials">
		<span class="stars-sep"></span>

		<div class="shell">
			<h2>Our Clients Say</h2>

			<div class="cols clearfix">
				<div class="col col-1of2">
					<ul class="testimonials clearfix">
						<li class="testimonial">
							<div class="testimonial-image">
								<span class="testimonial-mask"></span>

								<img src="css_pn/images/person-img1.jpg" alt="" />
							</div><!-- /.testimonial-image -->

							<div class="testimonial-content">
								<blockquote>
									<!--<p>Telwares' primary audience is the CTO and CIO community - and accurate, timely information is mission critical to our success. CTOsOnTheMove has helped us to quickly take advantage of opportunities with key IT leaders, creating real client engagements and extraordinary return on investment.</p>-->
							<p>Telwares’ primary audience is the CISO community – and accurate, timely information is mission critical to our success. CISOsOnTheMove has helped us quickly take advantage of opportunities with key marketing leaders, creating real client engagements and extraordinary return on investment.</p>
									<p class="testimonial-author">Michael Voellinger</p><!-- /.testimonial-author -->
								
									<p>
										<a href="#" class="partner-logo">
											<img src="css_pn/images/partner-logo-telwares.jpg" alt="" />
										</a>
									</p>
								</blockquote>
							</div><!-- /.testimonial-content -->
						</li><!-- /.testimonial -->
						
						<li class="testimonial">
							<div class="testimonial-image">
								<span class="testimonial-mask"></span>

								<img src="css_pn/images/person-img2.jpg" alt="" />
							</div><!-- /.testimonial-image -->

							<div class="testimonial-cotnent">
								<blockquote>
									<p>CISOsOnTheMove is our secret lead generation weapon…</p>
							
									<p class="testimonial-author">Gary Claytor</p><!-- /.testimonial-author -->
									
									<p>
										<a href="#" class="partner-logo">
											<img src="css_pn/images/partner-logo-advisors.jpg" alt="" />
										</a>
									</p>
								</blockquote>
							</div><!-- /.testimonial-cotnent -->
						</li><!-- /.testimonial -->
					</ul><!-- /.testimonials -->
				</div><!-- /.col col-1of2 -->

				<div class="col col-1of2">
					<ul class="testimonials clearfix">
						<li class="testimonial">
							<div class="testimonial-image">
								<span class="testimonial-mask"></span>

								<img src="css_pn/images/person-img3.jpg" alt="" />
							</div><!-- /.testimonial-image -->

							<div class="testimonial-content">
								<blockquote>
									<p>CISOsOnTheMove has become a valuable piece of our lead generation portfolio, providing high quality candidates at a fraction of the cost of traditional lead generation sources.</p>
							
									<p class="testimonial-author">Jennifer Sipala, Marketing Director</p><!-- /.testimonial-author -->
									
									<p>
										<a href="#" class="partner-logo">
											<img src="css_pn/images/partner-logo-unitrends.jpg" alt="" />
										</a>
									</p>
								</blockquote>
							</div><!-- /.testimonial-content -->
						</li><!-- /.testimonial -->
						
						<li class="testimonial">
							<div class="testimonial-image">
								<span class="testimonial-mask"></span>

								<img src="css_pn/images/person-img4.jpg" alt="" />
							</div><!-- /.testimonial-image -->

							<div class="testimonial-content">
								<blockquote>
									<p>Our company is very judicious with our marketing dollars. I cannot think of another provider of real-time leads for  CISOs that offers as good a value for our investment. The annual subscription paid for itself in 2 months</p>
							
									<p class="testimonial-author">Steve Marx, Regional Sales Manager</p><!-- /.testimonial-author -->
									
									<p>
										<a href="#" class="partner-logo">
											<img src="css_pn/images/partner-logo-palamida.jpg" alt="" />
										</a>
									</p>
								</blockquote>
							</div><!-- /.testimonial-content -->
						</li><!-- /.testimonial -->
					</ul><!-- /.testimonials -->
				</div><!-- /.col col-1of2 -->
			</div><!-- /.cols -->
		</div><!-- /.shell -->
	</div><!-- /.section section-testimonials -->

	<div class="section section-blue">
		<div class="shell">
			<h2>Our 100% Triple Ironclad No-Risk Guarantee:</h2>

			<h4>You are fully protected by our 100% no-risk guarantee.</h4>

			<div class="section-body clearfix">
				<div class="badge">
					<img src="css_pn/images/badge-ico.png" alt="" />
				</div><!-- /.badge -->

				<div class="section-content">
					<ol class="list-numbers">
						<li>
							<strong class="num">1.</strong>

							If you don’t increase your leads, sales opportunities and close new clients within the next <strong>60 days</strong>, just let us know we will send you a prompt refund.
						</li>

						<li>
							<strong class="num">2.</strong>

							If at any point in time, you decide that CISOsOnTheMove is not a good fit for you, we will <strong>immediately stop</strong> your subscription. You are not locked-in into annual contracts. No penalties. 
						</li>

						<li>
							<strong class="num">3.</strong>

							If you don’t close at least 1 new client with the actionable real-time leads we provide within 1 year from signup – we will fully <strong>refund your annual subscription.</strong>

							<br /><br />

							No questions asked.	
						</li>
					</ol><!-- /.list-numbers -->
				</div><!-- /.section-content -->
			</div><!-- /.section-body -->
		</div><!-- /.shell -->
	</div><!-- /.section section-blue -->

	<div class="section section-questions">
		<span class="stars-sep"></span>

		<div class="shell">
			<h2>Questions You May Ask:</h2>

			<div class="lists-questions clearfix">
				<ul class="list-questions">
					<li>
						<h5>Can I upgrade/downgrade my subscription?</h5>

						<p>Yes, you can change your subscription at any time.</p>
					</li>

					<li>
						<h5>Am I locked into a contract?</h5>

						<p>No! You can cancel any time you want without any fees or penalties.</p>
					</li>

					<li>
						<h5>How do I contact support?</h5>

						<p>Just drop us a line at <a href="mailto:support@cisosonthemove.com">support@cisosonthemove.com</a> and we will get on it right away.</p>
					</li>

					<li>
						<h5>Where do you get your data?</h5>

						<p>We track in real-time over 50,000 news sources – press releases, company announcements, SEC filings, social media, etc. This fire hose of data is then analyzed, de-duped, updated with contact details and industry taxonomy so that it is immediately actionable for you.</p>
					</li>

				<!--	<li>
						<h5>Can I cancel my subscription anytime?</h5>

						<p>Yes, you can stop the subscription at any time. Just drop us a line here.</p>
					</li>-->

			<!--		<li>
						<h5>Are there any penalties or fees for cancellation?</h5>

						<p>Absolutely not. There are no fees or penalties for cancellation.</p>
					</li>-->

					<li>
						<h5>Does your database include emails and phone numbers?</h5>

						<p>Yes</p>
					</li>

					<li>
						<h5>What if I need to talk to a human being?</h5>

						<p>If you can't find answers on our website or have an urgent question, call Misha Sobolev at 646.812.6814</p>
					</li>

					<li>
						<h5>How long have you been in business?</h5>

						<p>We were founded in 2009.</p>
					</li>

					<li>
						<h5>Where are you based?</h5>

						<p>We are based in New York City and our research team is in Hyderabad, India.</p>
					</li>

					<li>
						<h5>What do I get with subscription?</h5>

						<p>The two main deliverables are 1) regular email updates when CISOs change jobs, including their updated emails and 2) full unlimited access to 14,000+ profiles of senior IT Security executives for searching/browsing/downloading.</p>
					</li>

					<li>
						<h5>How safe is my credit card information?</h5>

						<p>We do not store any credit card information. It was passed seamlessly to our payment gateway provider – PayPal.</p>
					</li>
				</ul><!-- /.list-questions -->

				<ul class="list-questions">
					<li>
						<h5>Who is this service for?</h5>

<!--						<p>Technology marketers, insides sales teams, contact database manager, technology research organizations, conferences and tradeshows, consultants, executive search professionals, real estate executives with datacenter portfolios, custom software</p>
-->					
<p> ERP and other software companies, BPO and outsourcing companies, IT research companies, custom software development organizations, hardware and software providers, DRP vendors, IT security specialists and more.</p>
</li>

					<li>
						<h5>Would I get my money back if I don't like the service?</h5>

						<p>Yes. If you don't like the service for any reason and let us know within 30 days of your sign up, we will refund 100% of your subscription fee, no questions asked.</p>
					</li>

					<li>
						<h5>Can I share my password?</h5>

						<p>At this point we don't allow concurrent logins, however we offer substantial discounts for corporate packages from 5 licenses and up.</p>
					</li>

					<li>
						<h5>Do you offer a free trial?</h5>

						<p>Currently, we offer a full refund of your subscription fee for 30 days from the moment you sign up, so essentially it is a free trial.</p>
					</li>

					<li>
						<h5>Why should I chose you, and not other company?</h5>

						<p>Many companies will offer you oceans of data however you will soon find for yourself that they cannot accurately track in real-time 20-40 million people.</p>
					</li>

				<!--	<li>
						<h5>Why buy a Swiss Army knife when you really just need a toothpick?</h5>

						<p>If you want to have access to top IT leaders at the moment they are most likely to be researching buying decisions – after they changed jobs – and you don't want to spend a fortune on these insights, try us.</p>
					</li>-->

					<li>
						<h5>Does your feed integrate with Salesforce, Oracle, Dynamics, SugarCRM, etc. ?</h5>

						<p>With a few clicks you can select your target list by company size, geography, title, industry and data of the management change > export into a csv file and > upload to your CRM of choice.</p>
					</li>

					<li>
						<h5>What's so important about management changes?</h5>

						<p>Management change is one of the sales triggers – events that change the status quo for your potential clients and made them aware of needs that your product or service can fill. It could be one of the strongest catalysts for your sales opportunities</p>
					</li>
				</ul><!-- /.list-questions -->
			</div><!-- /.lists-questions -->
		</div><!-- /.shell -->

		<span class="shadow-sep"></span>
	</div><!-- /.section section-questions -->

	<div class="footer">
		<div class="shell">
			<p class="copyright">&copy; <?=date("Y");?> CISOsOnTheMove. All rights reserved.</p><!-- /.copyright -->
		</div><!-- /.shell -->
	</div><!-- /.footer -->
</body>
</html>