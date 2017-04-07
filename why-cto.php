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

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />

	<title><?PHP echo 'CTOsOnTheMove.com ::';?> <?=$PageTitle;?></title>

    <meta name="keywords" content="<?=$PageKeywords?>" />

    <meta name="description" content="<?=$PageDescription?>" />

	<link rel="stylesheet" href="css/company-personal-style.css" type="text/css" media="all" />

	<link rel="shortcut icon" type="image/x-icon" href="css_new/images/favicon.jpg" />

    

	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css' />

	<link href='http://fonts.googleapis.com/css?family=Bitter:400,400italic,700' rel='stylesheet' type='text/css' />



	<script src="js/jquery-1.7.2.min.js" type="text/javascript"></script>

	<script src="js/functions.js" type="text/javascript"></script>

	<link rel="stylesheet" href="css_pn/style.css?w=<?php echo microtime(true); ?>" type="text/css" media="all"/>
 	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css' />
	<link href='http://fonts.googleapis.com/css?family=Bitter:400,400italic,700' rel='stylesheet' type='text/css' />
	<script src="js/jquery-1.11.0.min.js" type="text/javascript"></script>
	<script src="js/functions_new.js" type="text/javascript"></script>

<style>
.section p { padding-bottom: 0px; }
</style>

</head>

<body>

	<div class="header">

		<div class="shell clearfix">

			<h1 id="new-logo"><a href="<?=HTTP_SERVER?>index.php">CTOs on the Move</a></h1>



			<div class="header-right">

				<div id="navigation">

                   <ul>

                        <?php if($current_page !='index.php'){ ?>

                        <li><a href="<?=HTTP_SERVER?>index.php">Home</a></li>

                        <?PHP } ?>

                        <li><a href="<?=HTTP_SERVER?>advance-search.php">Search</a></li>

                        <li><a href="<?=HTTP_SERVER?>team.html">About Us</a></li>

                        <?PHP if($_SESSION['sess_is_user'] == 1){ ?>

                        <li><?=$_SESSION['sess_username']?>:&nbsp;<a href="<?=HTTP_SERVER?>my-profile.php">Profile</a></li>

                        <li><a href="<?=HTTP_SERVER?>logout.php" class="btn"><span>Log Out</span></a></li>

                        <?PHP }else{ ?>

                        <li><a href="<?=HTTP_SERVER?>pricing.html">Pricing</a></li>

                        <li><a href="<?=HTTP_SERVER?>login.php" class="btn"><span>Login</span></a></li>

                        <?PHP } ?>

                    </ul>

                 </div>   

				<!-- /navigation -->

			</div>

			<!-- /header-right -->

		</div>

		<!-- /shell -->

	</div>

	<!-- /header -->

	<div class="section intro-section">

		<img src="css/images/intro-img.jpg" alt="" class="wide-img" />



		<div class="shell">

			<h2>IT Marketers!</h2>

			<h3>

				Would You Like to Get Instant Access to 15,000+ IT Executives with $$$ budgets… for only $3/day??

			</h3>



			<p>

				Learn about this "secret lead generation weapon" used by Gartner, HP, AMD, Telwares and other titans<br />

				of the technology industry that explodes the sales pipeline and pays for itself on day one.

			</p>

		</div>

		<!-- /shell -->

	</div>

	<!-- /section -->

	<div class="section trusted-partners">

		<div class="shell">			

			<div class="logos">

				<h3>CTOsOnTheMove is Trusted by</h3>



				<a href="#"><img src="css/images/amd-logo.jpg" alt="" /></a>

				<a href="#"><img src="css/images/amazon-logo.jpg" alt="" /></a>

				<a href="#"><img src="css/images/verdiem-logo.jpg" alt="" /></a>

				<a href="#"><img src="css/images/gartner-logo.jpg" alt="" /></a>

				<a href="#"><img src="css/images/group-logo.jpg" alt="" /></a>

				<a href="#"><img src="css/images/aotmp-logo.jpg" alt="" /></a>

				<a href="#"><img src="css/images/mind-logo.jpg" alt="" /></a>

				<a href="#"><img src="css/images/opsource-logo.jpg" alt="" /></a>

				<a href="#"><img src="css/images/coraid-logo.jpg" alt="" /></a>

				<a href="#"><img src="css/images/microgen-logo.jpg" alt="" /></a>

				<a href="#"><img src="css/images/telwares-logo.jpg" alt="" /></a>

				<a href="#"><img src="css/images/unitrends-logo.jpg" alt="" /></a>

			</div>

			<!-- /logos -->

		</div>

		<!-- /shell -->

	</div>

	<!-- /section -->

	<div class="section section-gr ask-you-sec">

		<div class="shell">

			<h2>First let me ask you</h2>

			<p class="italic-txt">

				Are you tired of rejection? Of reaching out to hundreds of prospects and getting NOTHING back? Of being pushed to the side by competitors who win business with a solution that's WORSE than yours? I know how it feels… I was in your shoes once. 

			</p>

			<span class="down-arrow"></span>

		</div>

		<!-- /shell -->

	</div>

	<!-- /section -->



	<div class="section solution-section">

		<div class="shell">

			<h4>

				Because of this pain I created the Secret <br />

				<strong>Lead Generation Solution</strong> for You:

			</h4>



			<a href="#" class="logo-heading">CTOsOnTheMove</a>



			<h5>Your Sales Trigger Event Subscription</h5>



			<p>

				Every time an IT executive changes a job, you get an alert that a particular<br />

				IT budget may be in play.

			</p>



		</div>

		<!-- /shell -->

		<span class="shadow-sep"></span>

	</div>

	<!-- /section -->

	<div class="section steps-section">

		<div class="shell">

			<h2>Here's how CTOsOnTheMove works:</h2>



			<div class="steps clearfix">

				<div class="step">

					<span class="step-ico icon1"></span>

					<h5>Step 1</h5>



					<p>

						Your potential client appoints<br />

						a new CIO

					</p>

				</div>

				<!-- /step -->



				<div class="step">

					<span class="step-ico icon2"></span>

					<span class="black-arrow-step"></span>

					<h5>Step 2</h5>



					<p>

						CTOsOnTheMove sends you a real-time email alert and the updated email of<br /> that IT executive

					</p>

				</div>

				<!-- /step -->



				<div class="step">

					<span class="step-ico icon3"></span>

					<span class="black-arrow-step"></span>

					<h5>Step 3</h5>



					<p>

						You engage that IT executive in a<br />

						meaningful business conversation<br />

						leading to a sale

					</p>

				</div>

				<!-- /step -->

			</div>

			<!-- /steps -->



			<p>…all that before your competition realizes that this particular IT budget was in play!</p>

		</div>

		<!-- /shell -->

		<span class="shadow-sep"></span>

	</div>

	<!-- /section -->

	 <?PHP

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

	<div class="section">

    	<script type="text/ecmascript">

			function SubscriptionSelect(subid){

				document.getElementById('radio_sub_id_one').value = subid;

				document.getElementById('frmChooscSub_one').submit();

			}

		</script>

		<form method="post" name="frmChooscSub" id="frmChooscSub_one" action="res-price-process.php?action=ChoosePricing">

        	<input type="hidden" name="referring_links" id="referring_links" value="<?=$current_page?>"/>

        	 <input type="hidden" name="radio_sub_id" id="radio_sub_id_one" />

			<div class="shell">

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
											<span class="center">Every week you will receive a short update highlighting new appointments and promotions among senior IT execs.</span>
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
											<span class="center">We send special gifts on your behalf to important potential clients on special occasions like appointments or industry awards</span>
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

			<!-- /cols-holder -->



			<p class="subscribe">

				Subscribe now with confidence: You have our 60-day money back guarantee

				<strong>No minimum term - cancel anytime</strong>

			</p>



			<p>We will show you details in a second…</p>



			<p>

				Meanwhile, no matter what other people tell you, in sales there are no easy solutions. It's always grind.<br />

				However if you grind it out in smart way, you get results. <br />

				If not – the only thing you'd have to show at the end of the day is feeling tired. Without knowing, we are ramming our<br />

				heads against the wall of ...

			</p>

		</div>

        </form>

		<!-- /shell -->

	</div>

	<!-- /section -->

	<div class="section problems-section">

		<div class="shell clearfix">

			<h2>The Seven Problems</h2>

			<h3>With "Traditional" Lead Generation Process</h3>



			<!-- <div class="holder"> -->

				<div class="note-box">

					<div class="note-top"></div><!-- /note-head -->

					<div class="note-center">

						<div class="note-cnt">

							<h3>H--vers' story...</h3>



							<p>Several years ago I was at company that relied heavily on large contact databases.</p>



							<p>One day I was on a conference call where a saleswoman from a large database company who was pitching our company on a subscription:</p>



							<p>

								<span class="italic-txt">"We have over 40 million contacts in our database"</span> – she bragged…

							</p>



							<p>

								<span class="italic-txt">"How long does it take you to update your database when a certain executive is appointed to another job or promoted?"</span>  – I asked…

							</p>



							<p>

								<span class="italic-txt">"… well… up to 6 months…"</span> – she said.

							</p>

							

							<p>

								At that point I tuned out and went back to my minesweeper epic battle.

							</p>

						</div>

						<!-- /note-cnt -->

					</div>

					<!-- /note-cnt -->

					<div class="note-bottom"></div><!-- /note-bottom -->

				</div>

				<!-- /note-box -->



				<div class="problem">

					<span class="num">#1</span>



					<h5>Everyone is chasing the same set of leads.</h5>



					<p>Have you heard of H--overs?</p>



					<p>Of course, they have a database with 40+ million contacts, and probably thousands of customers.</p>



					<p>Now is it a good thing? These thousands of customers are essentially chasing the same pool of leads.</p>



					<p>So if you are an IT executive with budget authority, how many canned pitches you think you get a day? 10? 20? How about 30+?</p>



					<p>So clearly this doesn't work.</p>

				</div>

				<!-- /problem -->



				<div class="problem">

					<span class="num">#2</span>



					<h5>Generic sales pitches</h5>



					<p>I don't know about you, but most of sales pitches I see go something along the lines: "Hey, IT executive! In case you need ______ , we are the best."</p>



					<p>This is not personalized and not contextual. Hence, it doesn't work.</p>

				</div>

				<!-- /problem -->

			<!-- </div> -->

			<!-- /holder -->



			<div class="problem">

				<span class="num">#3</span>

				<h5>Lots of marketing activity, yet no results</h5>



				<p>According to Pareto law, no more than 20% of your leads will turn into clients. If your sales funnel is a little bit complex, this number is actually lower – i.e. you lose 80% of leads at each step of your conversion funnel.</p>



				<p>Most of marketing activities that don't recognize the context to identify and exploit sales trigger events, spent (i.e. waste) inordinate amount of effort on leads who are obviously  in the "never gonna happen" pile.</p>



				<p>This leads to busy activity – emailing, social media'ing, promoting … with no readily measurable results. No accountability.</p>

			</div>

			<!-- /problem -->



			<div class="problem">

				<span class="num">#4</span>

				<h5>Marketing spent is not an investment but a liability</h5>



				<p>Here is the thinking…</p>



				<p>If I get pitched unskillfully by a certain person and company, I begin to transfer this negative impression onto this company's product or service, thus diminishing the future chances of my ever becoming their client.</p>



				<p>In plain English: marketing and sales tools used incorrectly may not only NOT bring results, they can actually hurt your future sales.</p>

			</div>

			<!-- /problem -->



			<div class="problem">

				<span class="num">#5</span>

				<h5>Rushing to sell</h5>



				<p>Have you heard this before "People buy from people they know"?</p>



				<p>Why's this so?</p>



				<p>Well, it turns out the familiarity or even appearances of it, is often time the best proxy for trust.</p>



				<p>Unfortunately, too many over-eager sales people rush to pitch, forgetting that the natural, more efficient and infinitely more successful sequence is <strong>Like Me => Know Me => Trust Me => Pay Me</strong>.</p>



				<p>Starting with "Pay Me" gets you nowhere in a hurry.</p>



				<p>I know, I've tried.</p>

			</div>

			<!-- /problem -->



			<div class="problem">

				<span class="num">#6</span>

				<h5>Not real-time context-aware</h5>



				<p>I just finished a workout… I am thirsty… if you offer me a cold coconut water pack, I will pay you 2x the price.</p>



				<p>If you offer the same pack after a few days and say "hey, I know you were thirsty several days ago, how about a cold drink?"</p>



				<p>Not as effective.</p>



				<p>The reality is even worse: most sales professionals are not even listening to the explosion of publicly available actionable insights on their prospective clients.</p>

			</div>

			<!-- /problem -->



			<div class="problem">

				<span class="num">#7</span>

				<h5>Focused on carpet-bombing vs. sharp-shooting</h5>



				<p>Focused on carpet-bombing vs. sharp-shooting:</p>



				<p>"It is a numbers game"… "every "no" brings you closer to a "yes" – well this may have been true 50 years ago, 20 years ago… even 5 years ago.</p>



				<p>But today… with velocity of technological change, over-abundance of options, and exponentially increasing information-overloading assault on our senses what are you going to do if you are on your 1000th "no" and there not a "yes" in sight?</p>



				<p>There was never a solution that removed all these problems.</p>

			</div>

			<!-- /problem -->

		</div>

		<!-- /shell -->



		<span class="stars-sep"></span>

	</div>

	<!-- /section -->

	<div class="section soulution-section">

		<div class="shell">

			<h3>There was never a solution that removed all these problems.</h3>

			<h2>Until now…</h2>



			<span class="lamp-icon"></span>



			<p>

				Now, how would you like it if instead you could reach out to IT executives who changed jobs yesterday and today are likely assessing their strategy for the next year?<br />



				Before their phones start ringing and email inbox starts overflowing with competitors' emails?<br />

				Would you like that?<br />

				Well, now you can.

			</p>

		</div>

		<!-- /shell -->



		<span class="stars-sep"></span>

	</div>

	<!-- /section -->



	<div class="section">

		<div class="shell">

			<p class="italic-txt">

				We had to index 5,000+ news sources including online media, press release publishers, SEC filings, social media sites.<br />

				…then we had to invest in sophisticated tools to mine, enrich, de-dupe and append this unstructured data with contact details (emails and phone numbers), industry taxonomy, geo details, company size data and more. …so that to turn this ocean of unstructured data into actionable, real-time insights that will supercharge your sales growth from day one.<br />

				Yes, you can probably build all this by yourself – it'd take you 1 year and approximately $100K in investment and you'll probably have to hire someone to maintain it – another $60K/year. <br />

				Or you can save all the hassle, expense and time investment by subscribing to CTOsOnTheMove:<br />

				You'd ask, why did we do all that? 

			</p>

		</div>

		<!-- /shell -->

	</div>

	<!-- /section -->



	<div class="section section-gr important-section">

		<div class="shell">

			<h2>Because It Is Important:</h2>

			<div class="entries">

				<div class="entry">

					<span class="num">1.</span>



					<p>

						Your contact database goes <a href="#">obsolete at a rate of 30% a year</a> or faster. 3 years and you can toss it. <strong>Your Prospects Move Every Day!</strong>

					</p>

				</div>

				<!-- /entry -->



				<div class="entry">

					<span class="num">2.</span>



					<p>

						The more you know about your leads in <strong>real-time</strong> the faster you can communicate a <a href="#">relevant, appropriated and customized sales message</a> to them. One can argue, this tactic helped Obama win the election.

					</p>

				</div>

				<!-- /entry -->

			</div>

			<!-- /entries -->



			<div class="entries">

				<div class="entry">

					<span class="num">3.</span>



					<p>

						Most of your competitors use humongous contact databases that take months to update. By using <a href='#'>real-time insights</a>, you get in front of <strong>IT decision makers</strong> who are still in a blind spot for your competition.

					</p>

				</div>

				<!-- /entry -->



				<div class="entry">

					<span class="num">4.</span>



					<p>

						Newly appointed executives are likely to exploring various technology options to implement the new IT mandate they were hired to execute.

					</p>

				</div>

				<!-- /entry -->

			</div>

			<!-- /entries -->



			<div class="entries">

				<div class="entry">

					<span class="num">5.</span>



					<p>

						Previous IT vendor-client relationship are not as strong and can be disrupted by a <strong>proactive and aggressive challenger</strong>.

					</p>

				</div>

				<!-- /entry -->



				<div class="entry">

					<span class="num">6.</span>



					<p>All this means: <a href="#">higher open, response and engagement rates</a> for you!</p>

				</div>

				<!-- /entry -->

			</div>

			<!-- /entries -->

		</div>

		<!-- /shell -->

	</div>

	<!-- /section -->



	<div class="section offer-section">

		<div class="shell">

			<h4>Because it is so important, here's our offer for you:</h4>

			<h2>

				Increase your leads, sales opportunities and clients<br />

				within the next 30 days... or your money back:

			</h2>

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
											<span class="center">Every week you will receive a short update highlighting new appointments and promotions among senior IT execs.</span>
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
											<span class="center">We send special gifts on your behalf to important potential clients on special occasions like appointments or industry awards</span>
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

			<!-- /cols-holder -->



			<p class="subscribe">

				Subscribe now with confidence: You have our 60-day money back guarantee

				<strong>No minimum term - cancel anytime</strong>

			</p>

		</div>

		<!-- /shell -->

	</div>

	<!-- /section -->



	<div class="section subscribe-section">

		<div class="shell">

			<h2>When You Subscribe Today, You Will Get Instant Access to:</h2>



			<div class="widgets-holder">

				<div class="widget">

					<a href="#" class="img-link">

						<img src="css/images/subscribe-img1.jpg" alt="" />

					</a>



					<p>1. Weekly Email Highlighting Select Appointments of IT Executives</p>

				</div>

				<!-- /widget -->



				<div class="widget">

					<a href="#" class="img-link">

						<img src="css/images/subscribe-img2.jpg" alt="" />

					</a>



					<p>2.Monthly Email With a Full Report on 100+ Newly Appointed CIOs and CTOs</p>

				</div>

				<!-- /widget -->



				<div class="widget">

					<a href="#" class="img-link">

						<img src="css/images/subscribe-img3.jpg" alt="" />

					</a>



					<p>3. Full Searching, Browsing and Downloading Access to the Contact Database</p>

				</div>

				<!-- /widget -->

			</div>

			<!-- /widgets-holder -->

		</div>

		<!-- /shell -->

	</div>

	<!-- /section -->



	<div class="section featured-section">

		<div class="shell">

			<h2>In Addition, You Will Also Get:</h2>

			<div class="featured-holder">

				<div class="feature">

					<span class="icons access-icon"></span>



					<h5>Instant Access to the Database</h5>



					<p>To 15,000+ profiles of CIOs, CTOs and other senior IT executives, complete with up-to-date <a href="#">emails</a> and phone numbers, industry taxonomy, geo, size, type of management change, source of information, full copy of the press release and more….</p>

				</div>

				<!-- /feature -->



				<div class="feature">

					<span class="icons mail-icon"></span>



					<h5>Weekly and Monthly Spotlight updates</h5>



					<p>Who got appointed, promoted, moved laterally among your prospective clients, with links to updated contact details, press releases and more, delivered to you by email.</p>

				</div>

				<!-- /feature -->

			</div>

			<!-- /featured-holder -->



			<div class="featured-holder">

				<div class="feature">

					<span class="icons upload-icon"></span>



					<h5>Easy Upload</h5>



					<p>Do you search, download leads, upload to Salesforce or any CRM you might be using. You are done!... and you own the leads.</p>

				</div>

				<!-- /feature -->



				<div class="feature">

					<span class="icons search-icon"></span>



					<h5>Search and Browse</h5>



					<p>Unlimited (based on subscription plan) searching, browsing and downloading from the ever growing database of IT executives.</p>

				</div>

				<!-- /feature -->

			</div>

			<!-- /featured-holder -->



			<div class="featured-holder">

				<div class="feature">

					<span class="icons support-icon"></span>



					<h5>Support</h5>



					<p>Constant phone and email support. Product tutorials and guides, best practices on email marketing, event marketing, lead generation, trigger events and more. Benchmarks and best practices from Fortune 500 and other clients of CTOsOnTheMove.</p>

				</div>

				<!-- /feature -->



				<div class="feature">

					<span class="icons update-icon"></span>



					<h5>Real-Time Updates</h5>



					<p>We track 5,000+ news sources, publications, SEC filings, social media and blogosphere for real time insights on appointments, promotions and lateral moves of CIOs, CTOs and other senior IT executives.</p>



					<p>

						These insights are appended with new contact details, industry taxonomy and other contextual details that make them instantly actionable and impactful for your sales and marketing campaigns.

					</p>

				</div>

				<!-- /feature -->

			</div>

			<!-- /featured-holder -->



			<div class="featured-holder">

				<div class="feature">

					<span class="icons tools-icon"></span>



					<h5>Tools, Detailed How-To Guides</h5>



					<p>You get instant access to details best practices and case studies in content marketing, email lead generation, B2B lead gen guides for LinkedIn, Twitter and Facebook and much, much more…</p>

				</div>

				<!-- /feature -->



				<div class="feature">

					<span class="icons custom-icon"></span>



					<h5>Custom Lead Generation Solutions</h5>



					<p>Including multi-modal access to your target audience, email marketing, online workshops, and live events. Contact us for details.</p>

				</div>

				<!-- /feature -->

			</div>

			<!-- /featured-holder -->



			<p>Imagine what life is going to be like when, it is so easy,  you can be on the phone or email with your prospective client in under 3 minutes.</p>



			<p>

				…with one click you get instant easy access to a database with 15,000+ IT executives<br />

				….Long sales cycles? Unresponsive prospects? No problem!

			</p>



		</div>

		<!-- /shell -->

		<span class="shadow-sep"></span>

	</div>

	<!-- /section -->



	<div class="section increase-widget">

		<div class="shell">

			<h2>

				Increase your leads, sales opportunities and clients <br />

				within the next 30 days… or your money back:

			</h2>

			<script type="text/ecmascript">

				function SubscriptionSelect(subid){

					document.getElementById('radio_sub_id_three').value = subid;

					document.getElementById('frmChooscSub_three').submit();

				}

			</script>

			<form method="post" name="frmChooscSub" id="frmChooscSub_three" action="res-price-process.php?action=ChoosePricing">

            	<input type="hidden" name="referring_links" id="referring_links" value="<?=$current_page?>"/>

				<input type="hidden" name="radio_sub_id" id="radio_sub_id_three" />

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
											<span class="center">Every week you will receive a short update highlighting new appointments and promotions among senior IT execs.</span>
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
											<span class="center">We send special gifts on your behalf to important potential clients on special occasions like appointments or industry awards</span>
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

			<!-- /cols-holder -->



			<p class="subscribe">

				Subscribe now with confidence: You have our 60-day money back guarantee

				<strong>No minimum term - cancel anytime</strong>

			</p>



		</div>

		<!-- /shell -->

		<span class="stars-sep"></span>

	</div>

	<!-- /section -->



	<div class="section logos-section">

		<div class="shell">

			<h2>

				Small Business and Large IT Companies Rely on<br />

				CTOsOnTheMove Every Day

			</h2>



			<p>to generate real-time, relevant, responsive and highly actionable sales leads:</p>



			<div class="cols-holder clearfix">

				<div class="colnew">

					<img src="css/images/sap-c-logo.jpg" alt="" />

					<img src="css/images/pem-c-logo.jpg" alt="" />

					<img src="css/images/softserve-c-logo.jpg" alt="" /> 

					<img src="css/images/conexiam-c-logo.jpg" alt="" />

					<img src="css/images/seamgen-c-logo.jpg" alt="" />

					<img src="css/images/norex-c-logo.jpg" alt="" />

					<img src="css/images/verdiem-c-logo.jpg" alt="" />

				</div>

				<!-- /col -->

				<div class="colnew">

					<img src="css/images/hp-c-logo.jpg" alt="" />

					<img src="css/images/cast-c-logo.jpg" alt="" />

					<img src="css/images/ratify-c-logo.jpg" alt="" />

					<img src="css/images/synergy-c-logo.jpg" alt="" />

					<img src="css/images/mindtree-c-logo.jpg" alt="" />

					<img src="css/images/coraid-c-logo.jpg" alt="" />

					<img src="css/images/virtual-c-logo.jpg" alt="" />

				</div>

				<!-- /col -->

				<div class="colnew">

					<img src="css/images/microgen-c-logo.jpg" alt="" />

					<img src="css/images/amd-c-logo.jpg" alt="" />

					<img src="css/images/amazon-c-logo.jpg" alt="" />

					<img src="css/images/gearstream-c-logo.jpg" alt="" />

					<img src="css/images/telwares-c-logo.jpg" alt="" />

					<img src="css/images/451group-c-logo.jpg" alt="" />

					<img src="css/images/mindhift-c-logo.jpg" alt="" />

				</div>

				<!-- /col -->



				<div class="colnew">

					<img src="css/images/gartner-c-logo.jpg" alt="" />

					<img src="css/images/netscout-c-logo.jpg" alt="" />

					<img src="css/images/windsor-c-logo.jpg" alt="" />

					<img src="css/images/pcswireless-c-logo.jpg" alt="" />

					<img src="css/images/advisors-c-logo.jpg" alt="" />

					<img src="css/images/research-c-logo.jpg" alt="" />

					<img src="css/images/opsource-c-logo.jpg" alt="" />

				</div>

				<!-- /col -->

			</div>

			<!-- /cols-holder -->



			<span class="stars-sep"></span>

		</div>

		<!-- /shell -->

	</div>

	<!-- /section -->



	<div class="section testimonials-section">

		<div class="shell">

			<h2>

				Still not sure if CTOsOnTheMove Can Help You?<br />

				See What These Subscribers Are Saying…

			</h2>



			<div class="testimonials-holder">

				<div class="testimonial">

					<div class="testimonial-img">

						<span class="mask"></span>

						<img src="css/images/person-img1.jpg" alt="" />

					</div>

					<!-- /testimonial-img -->



					<blockquote>

						<p>Telwares' primary audience is the CTO and CIO community - and accurate, timely information is mission critical to our success. CTOsOnTheMove has helped us to quickly take advantage of opportunities with key IT leaders, creating real client engagements and extraordinary return on investment.</p>



						<p class="author">Michael Voellinger</p>



						<a href="#" class="partner-logo"><img src="css/images/partner-logo-telwares.jpg" alt="" /></a>

					</blockquote>

				</div>

				<!-- /testimonial -->



				<div class="testimonial">

					<div class="testimonial-img">

						<span class="mask"></span>

						<img src="css/images/person-img2.jpg" alt="" />

					</div>

					<!-- /testimonial-img -->



					<blockquote>

						<p>CTOsOnTheMove is our secret lead generation weapon…</p>



						<p class="author">Gary Claytor</p>



						<a href="#" class="partner-logo"><img src="css/images/partner-logo-advisors.jpg" alt="" /></a>

					</blockquote>

				</div>

				<!-- /testimonial -->

			</div>

			<!-- /testimonials-holder -->



			<div class="testimonials-holder">

				<div class="testimonial">

					<div class="testimonial-img">

						<span class="mask"></span>

						<img src="css/images/person-img3.jpg" alt="" />

					</div>

					<!-- /testimonial-img -->



					<blockquote>

						<p>CTOsOnTheMove has become a valuable piece of our lead generation portfolio, providing high quality candidates at a fraction of the cost of traditional lead generation sources.</p>



						<p class="author">Jennifer Sipala, Marketing Director</p>



						<a href="#" class="partner-logo"><img src="css/images/partner-logo-unitrends.jpg" alt="" /></a>

					</blockquote>

				</div>

				<!-- /testimonial -->



				<div class="testimonial">

					<div class="testimonial-img">

						<span class="mask"></span>

						<img src="css/images/person-img4.jpg" alt="" />

					</div>

					<!-- /testimonial-img -->



					<blockquote>

						<p>Our company is very judicious with our marketing dollars. I cannot think of another provider of real-time leads for CIOs and CTOs that offers as good a value for our investment. The annual subscription paid for itself in 2 months</p>



						<p class="author">Steve Marx, Regional Sales Manager</p>



						<a href="#" class="partner-logo"><img src="css/images/partner-logo-palamida.jpg" alt="" /></a>

					</blockquote>

				</div>

				<!-- /testimonial -->

			</div>

			<!-- /testimonials-holder -->



			<span class="shadow-sep"></span>

		</div>

		<!-- /shell -->

	</div>

	<!-- /section -->



	<div class="section">

		<div class="shell">

			<h3>

				Get Started Today and Discover How CTOsOnTheMove Can Help You <br />

				Increase your leads, sales opportunities or clients within <br />

				the next 30 days… or your money back.

			</h3>

			<script type="text/ecmascript">

				function SubscriptionSelect(subid){

					document.getElementById('radio_sub_id_four').value = subid;

					document.getElementById('frmChooscSub_four').submit();

				}

			</script>

			<form method="post" name="frmChooscSub" id="frmChooscSub_four" action="res-price-process.php?action=ChoosePricing">

            	<input type="hidden" name="referring_links" id="referring_links" value="<?=$current_page?>"/>

				<input type="hidden" name="radio_sub_id" id="radio_sub_id_four" />

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
											<span class="center">Every week you will receive a short update highlighting new appointments and promotions among senior IT execs.</span>
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
											<span class="center">We send special gifts on your behalf to important potential clients on special occasions like appointments or industry awards</span>
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

			<!-- /cols-holder -->



			<p class="subscribe">

				Subscribe now with confidence: You have our 60-day money back guarantee

				<strong>No minimum term - cancel anytime</strong>

			</p>



			<h4>

				We connect you the right person, at the right time, with the right message <br />

				and through right medium, so that you can close more <br />

				paying clients easier and faster.

			</h4>

		</div>

		<!-- /shell -->

	</div>

	<!-- /section -->



	<div class="section section-gr">

		<div class="shell clearfix">

			<h3>

				Sign up today and boost your lead generation<br />

				in 30 days – Guaranteed!

			</h3>



			<h5>Subscribe to CTOsOnTheMove so that you can…</h5>



			<div class="note-box">

				<div class="note-top"></div><!-- /note-head -->

				<div class="note-center">

					<div class="note-cnt">

						<h3>

							"Can't Live<br />

							Without You…"

						</h3>



						<p>Recently I received an email from Gary.</p>



						<p>He was actually one of my favorite clients - always engaging and ready to give feedback. Then three weeks ago I received this:</p>



						<p>

							<span class="italic-txt">

								"Hey Misha,<br />

								Thanks for the monthly update. Btw, please send the next one to my new email at garyc@###.com - I am changing gigs, however I taking CTOsOnTheMove with me. Best, -GC"

							</span>

						</p>



						<p>... I was ecstatic!</p>



						<p>Not only he loved the service, he was taking it to the new company. How awesome. I was on cloud nine, until two weeks ago I received this:</p>



						<p>

							<span class="italic-txt">

								"Hey Misha,<br />

								Bad news - my new VP is on a cost-cutting path and unfort he just nixed my subscription. I will miss you guys and hope in 6 month time we can have another go. Sorry, man. GC"

							</span>

						</p>



						<p>... I was devastated - my champion was leaving! I offered a discount and a cheaper plan, to no avail. I was feeling blue, until last week I received this:</p>

						

						<p>

							<span class="italic-txt">"Misha - can't live without you guys. Sign me back up. Just put it on my card and I will figure something out. GC"</span>

						</p>



						<p>Whoa! We are back in business! Needless to say, I almost teared up at this point.  As stories go, I couldn't have imagined a happier ending.</p>

					</div>

					<!-- /note-cnt -->

				</div>

				<!-- /note-cnt -->

				<div class="note-bottom"></div><!-- /note-bottom -->

			</div>

			<!-- /note-box -->



			<div class="listing">

				<ul>

					<li>

						<span class="list-arrow"></span>Get in front of <a href="#">IT decision makers</a> before your competition does</li>



					<li>

						<span class="list-arrow"></span>

						<strong><a href="#">Engage them</a> when they are most likely to be in the midst of information gathering, i.e. before they start selecting vendors.</strong>

					</li>



					<li>

						<span class="list-arrow"></span>Jump in at the best time: during management changes on top when legacy vendor client relationships are weaken.</li>

					

					<li>

						<span class="list-arrow"></span>

						<strong>Get <a href="#">weekly email updates</a> on new appointments, promotions and lateral moves of CIOs, CTOs and other senior IT executives.</strong>

					</li>



					<li>

						<span class="list-arrow"></span><a href="#">Beat your competition</a> to the punch – talk to your prospective buyers the same day the received an appointment or promotion and months (!) before their contact details are updated in all mass industry databases</li>



					<li>

						<span class="list-arrow"></span>

						<strong>Get access to open CIO jobs so that you can 1) prepare your pitch when this position gets filled and 2) hook-up your best clients with jobs… they will be forever grateful to you.</strong>

					</li>



					<li>

						<span class="list-arrow"></span>

						Search <a href='#'>14,000+ profiles of CIOs, CTOs and other IT decision makers</a> at your convenience.

					</li>



					<li>

						<span class="list-arrow"></span>

						<strong>Define your searches by geography, industry, company size, prospect's title, date and other parameters.</strong>

					</li>



					<li>

						<span class="list-arrow"></span>

						Own the data forever.

					</li>



					<li>

						<span class="list-arrow"></span>

						<strong>Get instant access to insights on how to identify, engage and convert new prospects into paying clients in record time, with specific steps and tactics.</strong>

					</li>



					<li>

						<span class="list-arrow"></span>

						Access a treasure trove of case studies, benchmarks and best practices of Gartner, Amazon Web Services, SAP, HP, Telwares and scores of other clients of CTOsOnTheMove.

					</li>



					<li>

						<span class="list-arrow"></span>

						<strong>Get this service that pays for itself: even 1 client a year will give you 20x return on your investment in CTOsOnTheMove, or your money back (see Our Guarantee).</strong>

					</li>



					<li>

						<span class="list-arrow"></span>

						Get instant access to specific email templates, phone scripts, and other marketing tactics to get your prospects to <strong>Know</strong> your solution, to <strong>Trust</strong> you as an expert and to <strong>Buy</strong> from you, eventually.

					</li>

				</ul>



				<p>

					Sleep calmly: no annual contracts… join or leave at will with the<br />

					month-to-month subscription and billing.

				</p>

			</div>

			<!-- /listing -->

		</div>

		<!-- /shell -->

	</div>

	<!-- /section -->



	<div class="section">

		<div class="shell clearfix">

			<h2>

				You might be thinking "$<?=$basic_amount?> to <?=$professional_amount?>/month?<br />

				Isn't that expensive?"

			</h2>



			<div class="note-box">

				<div class="note-top"></div><!-- /note-head -->

				<div class="note-center">

					<div class="note-cnt">

						<h3>

							Hunting for a head?

						</h3>



						<p>So I recently had a call with a head hunter. </p>



						<p>No, he didn't want my head. He was placing CIOs and other senior IT executives in their new roles.</p>



						<p>

							He said that his commission from just 1 (!) placement will pay for 10+ years of CTOsOnTheMove subscription. No surprise he was so excited to come on board.

						</p>



						<p>You, however, are in the IT business so the numbers are higher AND it is a recurring revenue stream. I know that sales cycles can be long, still if you close just 1 paying client from CTOsOnTheMove in 1 year, you'd already get a better deal than my headhunter.</p>

					</div>

					<!-- /note-cnt -->

				</div>

				<!-- /note-cnt -->

				<div class="note-bottom"></div><!-- /note-bottom -->

			</div>

			<!-- /note-box -->



			<div class="section-info">

				<h4>No.</h4>



				<p>You want to know what's <strong>expensive</strong>?</p>



				<p>

					<a href="#">Missing out on a sale to a willing buyer</a> on a short sales cycle, just because you didn't reach out to them at the right time. That one sale would pay for your subscription 5x to 20x over.  Now take that ROI to your CFO… 

				</p>



				<p>You know what else is expensive?</p>



				<p>

					<a href="#">Wasting tens of thousands of dollars</a> on marketing and promotion to dead-beat leads with no hope of ever converting them to paying clients. 

				</p>



				<p>This is not a marketing investment… it brings no return.</p>



				<p>

					This is a <span class="italic-txt">marketing liability…</span> it creates "bad-will" with executives and companies who get over-pitched at the wrong time with the wrong message.<br />

					It also steals resources (yes, I am talking about your opportunity cost) from marketing activities that actually bring results. <br />

					Now THAT is expensive.<br />

					And you know what's even more expensive? 

				</p>



				<p>YOUR TIME. You never get it back.</p>



				<p>Now, imagine instead:</p>



				<p>If you only close 1 new client in a year with the leads we provide this little subscription <strong>already paid for itself 5x to 20x.</strong></p>



				<p>Only one (likely, many more).</p>



				<p>Think about that.</p>

			</div>

			<!-- /section-info -->

		</div>

		<!-- /shell -->

	</div>

	<!-- /section -->



	<div class="section section-gr">

		<div class="shell">

			<p class="italic-txt">

				We will be frank with you, you certainly can build this solution yourself – it will take you about a year, easily $100K in payroll, software and maintenance… this is only $1… pay as you go… and if you close only 1 client A YEAR! … If you only close 1 new client – and you will (or we will fully refund your subscription), this will pay 10x to 100x ROI. <br />

				If you don't buy this, you'd need to pour over 100s of press releases, go through data feeds sift CTO (Chief Technology Officer) from CTO (Caribbean Tourist Organization)

			</p>

		</div>

		<!-- /shell -->

	</div>

	<!-- /section -->



	<div class="section resource-section">

		<div class="shell">

			<h2>

				But wait, when you subscribe now, you will<br />

				also get these valuable resources ($785 value):

			</h2>



			<div class="resource">

				<span class="ico graphic-ico"></span>

				<h5>These 7 Must-Have Lead generation guides:</h5>



				<p>Lead generation guides (that we sell separately for $350): – list titles</p>



				<ul>

					<li><span class="list-smallarrow"></span>Social Media lead generation for IT companies (LinkedIn)</li>

					<li><span class="list-smallarrow"></span>Social Media lead generation for IT companies (Twitter)</li>

					<li><span class="list-smallarrow"></span>Social Media lead generation for IT companies (Facebook)</li>

					<li><span class="list-smallarrow"></span>Introduction to Sales Trigger Events</li>

					<li><span class="list-smallarrow"></span>How to explode your lead generation at industry events</li>

					<li><span class="list-smallarrow"></span>How to find new clients from job postings</li>

					<li><span class="list-smallarrow"></span>25 Ways to Find new clients who just changed jobs</li>

				</ul>

			</div>

			<!-- /resource -->



			<div class="resource">

				<span class="ico phone-ico"></span>



				<p>

					<strong>One-on-one 1 hour phone consultation</strong><br />

					on trigger event lead generation ($350 value)

				</p>

			</div>

			<!-- /resource -->



			<div class="resource">

				<span class="ico calendar-ico"></span>



				<p>

					<strong>Personal invitations and discounts</strong><br />

					to select IT industry events, conferences, trade shows and expos we promote. 

				</p>

			</div>

			<!-- /resource -->



		</div>

		<!-- /shell -->

		<span class="shadow-sep"></span>

	</div>

	<!-- /section -->



	<div class="section">

		<div class="shell">

			<h2>Why CTOsOnTheMove is Risk-Free For You to Try:</h2>



			<div class="listing">

				<ul>

					<li><span class="list-arrow"></span>Search, Browse and Download from the database with 15K profiles of CIOs, CTOs, and other IT execs</li>

					<li><span class="list-arrow"></span>Receive weekly highlights</li>

					<li><span class="list-arrow"></span>Receive monthly reports</li>

					<li><span class="list-arrow"></span>Learn from case studies, best practices and secret strategies of top technology companies</li>

				</ul>

			</div>

			<!-- /listing -->



			<p>…and if you aren't absolutely 100% delighted , you're protected by…</p>

		</div>

		<!-- /shell -->

	</div>

	<!-- /section -->



	<div class="section blue-section">

		<div class="shell">

			<h2>Our 100% Triple Ironclad No-Risk Guarantee:</h2>



			<h4>You are fully protected by our 100% no-risk guarantee.</h4>



			<div class="blue-cnt">

				<div class="badge">

					<img src="css/images/badge-ico.png" alt="" />

				</div>

				<!-- /badge -->



				<div class="blue-info">

					<ul>

						<li>

							<strong class="num">1.</strong>

							If you don't increase your leads, sales opportunities and close new clients within the next <strong>60 days</strong>, just let us know we will send you a prompt refund.

						</li>



						<li>

							<strong class="num">2.</strong>

							If at any point in time, you decide that CTOsOnTheMove is not a good fit for you, we will <strong>immediately stop</strong> your subscription. You are not locked-in into annual contracts. No penalties. 

						</li>



						<li>

							<strong class="num">3.</strong>

							If you don't close at least 1 new client with the actionable real-time leads we provide within 1 year from signup – we will fully <strong>refund your annual subscription.</strong>

						</li>

					</ul>



					<p>No questions asked.</p>

				</div>

				<!-- /blue-info -->

			</div>

			<!-- /blue-cnt -->

		</div>

		<!-- /shell -->

	</div>

	<!-- /section -->



	<div class="section">

		<div class="shell">

			<h3>

				Go ahead, <strong>Click the option below</strong> the fits your best <strong>right now</strong><br />

				and get instant access to the actionable, real-time leads<br />

				that will move your business forward.

			</h3>

			<script type="text/ecmascript">

				function SubscriptionSelect(subid){

					document.getElementById('radio_sub_id_five').value = subid;

					document.getElementById('frmChooscSub_five').submit();

				}

			</script>

			<form method="post" name="frmChooscSub" id="frmChooscSub_five" action="res-price-process.php?action=ChoosePricing">

            	<input type="hidden" name="referring_links" id="referring_links" value="<?=$current_page?>"/>

				<input type="hidden" name="radio_sub_id" id="radio_sub_id_five" />

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
											<span class="center">Every week you will receive a short update highlighting new appointments and promotions among senior IT execs.</span>
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
											<span class="center">We send special gifts on your behalf to important potential clients on special occasions like appointments or industry awards</span>
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

			<!-- /cols-holder -->



			<p>

				Subscribe now with confidence: You have our 60-day money back guarantee<br />

				<strong>No minimum term - cancel anytime</strong>

			</p>



		</div>

		<!-- /shell -->

		<span class="shadow-sep"></span>

	</div>

	<!-- /section -->



	<div class="section warning-section">

		<div class="shell">

			<h2>WARNING!!!</h2>



			<div class="red-content">

				<h3>

					Why Some Subscribers Fail to Explode Their Lead Generation

					and Sales with CTOsOnTheMove?

				</h3>



				<div class="red-info clearfix">

					<div class="warning-sign">

						<img src="css/images/warning-ico.png" alt="" />

					</div>



					<div class="red-inner">

						<ul>

							<li><span class="red-arrow"></span>Don't act on real-time leads promptly</li>

							<li><span class="red-arrow"></span>Don't personalize email and phone messages</li>

							<li><span class="red-arrow"></span>Don't take the effort to get to know prospects and their companies</li>

							<li><span class="red-arrow"></span>Don't attempt to build a relationship first, go to pitching right away...</li>

						</ul>



						<p class="msg">

							If you are not ready to commit to your own success,<br />

							do NOT Subscribe to CTOsOnTheMove

						</p>

					</div>

					<!-- /red-inner -->

				</div>

				<!-- /red-info -->

			</div>

			<!-- /red-content -->



			<p>If you are not serious about growing your business, don't subscribe. Seriously.</p>



			<p>If I dragged a buyer to you and you wouldn't want to lift your hand to take his money…. I can't help you. Remember, winners differentiate themselves by "taking massive action". If you are not prepared to work the real-time leads we provide, I implore you – do NOT subscribe. I mean it.</p>



			<p>You see, we are not selling magic bullets here… because frankly, they don't exist.</p>



			<p>We offering you an honest tool that will make you life easier, help you achieve results faster and will help you waste less time and $$$. Wouldn't you want that?</p>



			<p>If you are still here, then chose your option below:</p>

			<script type="text/ecmascript">

				function SubscriptionSelect(subid){

					document.getElementById('radio_sub_id_six').value = subid;

					document.getElementById('frmChooscSub_six').submit();

				}

			</script>

			<form method="post" name="frmChooscSub" id="frmChooscSub_six" action="res-price-process.php?action=ChoosePricing">

            	<input type="hidden" name="referring_links" id="referring_links" value="<?=$current_page?>"/>

				<input type="hidden" name="radio_sub_id" id="radio_sub_id_six" />

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
											<span class="center">Every week you will receive a short update highlighting new appointments and promotions among senior IT execs.</span>
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
											<span class="center">We send special gifts on your behalf to important potential clients on special occasions like appointments or industry awards</span>
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

			<!-- /cols-holder -->



			<p>

				Subscribe now with confidence: You have our 60-day money back guarantee<br />

				<strong>No minimum term - cancel anytime</strong>

			</p>



		</div>

		<!-- /shell -->

		<span class="shadow-sep"></span>

	</div>

	<!-- /section -->



	<div class="section ask-section">

		<div class="shell">

			<h2>Questions You May Ask:</h2>



			<div class="sides-holder clearfix">

				<div class="side">

					<div class="post">

						<h5>Can I upgrade/downgrade my subscription?</h5>



						<p>Yes, you can change your subscription at any time.</p>

					</div>

					<!-- /post -->



					<div class="post">

						<h5>Am I locked into a contract?</h5>



						<p>No! You can cancel any time you want without any fees or penalties.</p>

					</div>

					<!-- /post -->



					<div class="post">

						<h5>How do I contact support?</h5>



						<p>Just drop us a line at <a href="mailto:support@ctosonthemove.com">support@ctosonthemove.com</a> and we will get on it right away.</p>

					</div>

					<!-- /post -->



					<div class="post">

						<h5>Where do you get your data?</h5>



						<p>We track in real-time over 50,000 news sources – press releases, company announcements, SEC filings, social media, etc. This fire hose of data is then analyzed, de-duped, updated with contact details and industry taxonomy so that it is immediately actionable for you.</p>

					</div>

					<!-- /post -->



					<div class="post">

						<h5>Can I cancel my subscription anytime?</h5>



						<p>Yes, you can stop the subscription at any time. Just drop us a line here.</p>

					</div>

					<!-- /post -->



					<div class="post">

						<h5>Are there any penalties or fees for cancellation?</h5>



						<p>Absolutely not. There are no fees or penalties for cancellation.</p>

					</div>

					<!-- /post -->



					<div class="post">

						<h5>Does your database include emails and phone numbers?</h5>



						<p>Yes</p>

					</div>

					<!-- /post -->



					<div class="post">

						<h5>What if I need to talk to a human being?</h5>



						<p>If you can't find answers on our website or have an urgent question, call Misha Sobolev at 646.812.6814</p>

					</div>

					<!-- /post -->



					<div class="post">

						<h5>How long have you been in business?</h5>



						<p>We were founded in 2009.</p>

					</div>

					<!-- /post -->



					<div class="post">

						<h5>Where are you based?</h5>



						<p>We are based in New York City and our research team is in Hyderabad, India.</p>

					</div>

					<!-- /post -->



					<div class="post">

						<h5>What do I get with subscription?</h5>



						<p>The two main deliverables are 1) regular email updates when CIOs and CTOs change jobs, including their updated emails and 2) full unlimited access to 14,000+ profiles of senior IT executives for searching/browsing/downloading.</p>

					</div>

					<!-- /post -->



					<div class="post">

						<h5>How safe is my credit card information?</h5>



						<p>We do not store any credit card information. It was passed seamlessly to our payment gateway provider – PayPal.</p>

					</div>

					<!-- /post -->

				</div>

				<!-- /side -->



				<div class="side alignright">

					<div class="post">

						<h5>Who is this service for?</h5>



						<p>Technology marketers, insides sales teams, contact database manager, technology research organizations, conferences and tradeshows, consultants, executive search professionals, real estate executives with datacenter portfolios, custom software</p>

					</div>

					<!-- /post -->



					<div class="post">

						<h5>Would I get my money back if I don't like the service?</h5>



						<p>Yes. If you don't like the service for any reason and let us know within 30 days of your sign up, we will refund 100% of your subscription fee, no questions asked.</p>

					</div>

					<!-- /post -->



					<div class="post">

						<h5>Can I share my password?</h5>



						<p>At this point we don't allow concurrent logins, however we offer substantial discounts for corporate packages from 5 licenses and up.</p>

					</div>

					<!-- /post -->



					<div class="post">

						<h5>Do you offer a free trial?</h5>



						<p>Currently, we offer a full refund of your subscription fee for 30 days from the moment you sign up, so essentially it is a free trial.</p>

					</div>

					<!-- /post -->



					<div class="post">

						<h5>Why should I chose you, and not other company?</h5>



						<p>Many companies will offer you oceans of data however you will soon find for yourself that they cannot accurately track in real-time 20-40 million people.</p>

					</div>

					<!-- /post -->



					<div class="post">

						<h5>Why buy a Swiss Army knife when you really just need a toothpick?</h5>



						<p>If you want to have access to top IT leaders at the moment they are most likely to be researching buying decisions – after they changed jobs – and you don't want to spend a fortune on these insights, try us.</p>

					</div>

					<!-- /post -->



					<div class="post">

						<h5>Does your feed integrate with Salesforce, Oracle, Dynamics, SugarCRM, etc. ?</h5>



						<p>With a few clicks you can select your target list by company size, geography, title, industry and data of the management change > export into a csv file and > upload to your CRM of choice.</p>

					</div>

					<!-- /post -->



					<div class="post">

						<h5>What's so important about management changes?</h5>



						<p>Management change is one of the sales triggers – events that change the status quo for your potential clients and made them aware of needs that your product or service can fill. It could be one of the strongest catalysts for your sales opportu</p>

					</div>

					<!-- /post -->

				</div>

				<!-- /side -->

			</div>

			<!-- /sides-holder -->



		</div>

		<!-- /shell -->

		<span class="shadow-sep"></span>

	</div>

	<!-- /section -->



	<div class="section compare-section">

		<div class="shell">

			<h3>"There is a difference between knowing the path and walking the path" </h3>



			<h5>

				I've showed you the path…   are you going to step up? Which side of the<br />

				fence are you on?

			</h5>



			<h6>

				Sign Up by clicking one of the options below, you will be able to review<br />

				everything in the next page:

			</h6>

			<script type="text/ecmascript">

				function SubscriptionSelect(subid){

					document.getElementById('radio_sub_id_seven').value = subid;

					document.getElementById('frmChooscSub_seven').submit();

				}

			</script>

			<form method="post" name="frmChooscSub" id="frmChooscSub_seven" action="res-price-process.php?action=ChoosePricing">

            	<input type="hidden" name="referring_links" id="referring_links" value="<?=$current_page?>"/>

				<input type="hidden" name="radio_sub_id" id="radio_sub_id_seven" />

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
											<span class="center">Every week you will receive a short update highlighting new appointments and promotions among senior IT execs.</span>
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
											<span class="center">We send special gifts on your behalf to important potential clients on special occasions like appointments or industry awards</span>
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

			<!-- /cols-holder -->



			<p>

				Subscribe now with confidence: You have our 60-day money back guarantee<br />

				<strong>No minimum term - cancel anytime</strong>

			</p>



		</div>

		<!-- /shell -->

		<span class="shadow-sep"></span>

	</div>

	<!-- /section -->



	<div class="footer">

		<p>&copy; <?=date("Y");?> CTOsOnTheMove. All rights reserved.</p>

	</div>

	<!-- /footer -->

</body>

</html>