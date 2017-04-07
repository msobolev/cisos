<? 
include("includes/include-top.php");

$dim_url = explode('/', $_SERVER['REQUEST_URI']);
$vigilant_url =$dim_url[sizeof($dim_url)-1];
$isPresentURL = com_db_GetValue("select contact_id from ".TABLE_CONTACT." where contact_url='".$vigilant_url."'"); 
if( $isPresentURL=='' ){
	$contact_id = $_REQUEST['contact_id'];
	if($contact_id !=''){
		$vigilant_url = com_db_GetValue("select contact_url from ".TABLE_CONTACT." where contact_id='".$contact_id."'"); 
	}
	$url_arr = split('-at-',$vigilant_url);
	if(sizeof($url_arr)<=1 ){
	$url_arr = split('-from-',$vigilant_url);
	} 
	$url_arr_sub = split('-',$url_arr[0]);
	$now_url = $url_arr_sub[0].'-'.$url_arr_sub[1].'%'.preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '-', ''), $url_arr[1]);
	$vigilant_url = com_db_GetValue("select contact_url from ".TABLE_CONTACT." where contact_url like '".$now_url."'"); 
	if($vigilant_url !=''){
		com_redirect($vigilant_url);
	}elseif( $vigilant_url =='' ){
		$url ='not-found.php';
		com_redirect($url);
	}
}

$contact_query = 'select c.contact_id,c.first_name,c.last_name,c.headline,c.company_name,c.company_website,c.about_company,
					c.what_happened,c.about_person,c.address,c.address2,c.zip_code,c.email,c.phone,c.city,c.new_title,c.announce_date,
					i.title as company_industry,s.short_name as state,ct.countries_name as country,so.source as source,m.name as movement_type,c.not_current,c.new_position,c.new_person from ' 
					.TABLE_CONTACT . ' as c, '
					.TABLE_COUNTRIES. ' as ct, ' 
					.TABLE_INDUSTRY . ' as i, '
					.TABLE_STATE . ' as s, '
					.TABLE_SOURCE . ' as so, '
					.TABLE_MANAGEMENT_CHANGE . ' as m
					where c.industry_id=i.industry_id and c.state=s.state_id and c.source=so.id and c.country=ct.countries_id and c.movement_type=m.id and c.contact_url = "'.$vigilant_url.'"';
$contact_result = com_db_query($contact_query);
$contact_row = com_db_fetch_array($contact_result);
$a_date = explode('-',$contact_row['announce_date']);
$announce_date = date("F d, Y", mktime(0,0,0,$a_date[1],$a_date[2],$a_date[0]));

$comp_domain_name='';
if($contact_row['company_website'] !=''){
	$comp   = array("http://wwww.", "www.","https://www.","http://","https://");
	$comp_domain_name = str_replace($comp,'',$contact_row['company_website']);
	$comp_domain_name =' @'. $comp_domain_name;
}	
$notCurrent = $contact_row['not_current'];
$PageTitle = $PageTitle.$comp_domain_name.' CTOsOnTheMove';
$movement_type = $contact_row['movement_type'];
$PageKeywords=com_db_output($contact_row['first_name']).' '.com_db_output($contact_row['last_name']).', '.com_db_output($contact_row['movement_type']).', '.com_db_output($contact_row['company_name']).', email, '.$comp_domain_name.', CTOsOnTheMove, '.$mt_type;
$PageDescription='Looking for '.com_db_output($contact_row['first_name']).' '.com_db_output($contact_row['last_name']).', '.com_db_output($contact_row['new_title']).' at '.com_db_output($contact_row['company_name']).'? Contact '.com_db_output($contact_row['first_name']).' today at updated'.$comp_domain_name.' email, phone and address here at '.com_db_output($contact_row['first_name'])."'s profile at CTOsOnTheMove";

include_once('includes/header_new.php');
?>
<!-- Intro -->
	<div class="new-body-bg1">
			<div class="shell-new-header">
				<div class="intro">
					<div class="shell">
						<h2><?=com_db_output($contact_row['headline'])?></h2>
						<p class="shell-left">Date of management change: <?=$announce_date;?>&nbsp;
                        <span id="button_1"></span>
                        <script type="text/javascript" language="javascript">
						//<![CDATA[
                        stLight.options({
                                publisher:'insert-your-key-here',
                                headerbg:'#DDDE3E'
                            });
                                    
                        stWidget.addEntry({
                            "service":"sharethis",
                            "element":document.getElementById('button_1'),
                            "url":"http://sharethis.com",
                            "title":"sharethis",
                            "type":"chicklet",
                            "text":"Share"    
                            });
                            /*
                                service is sharethis,facebook,digg etc
                                type button,chicklet,custom,vcount,hcount
                                text this is the displaytext, this is the alternative method to be w3c compliant
                            
                            */
							//]]>
                        </script>
                        </p>
						<div class="small-popup">
							<div id="white_content" class="white_content-new" style="display:none;">
								<div class="inner">
									<div class="top-bg1">
									<div class="close-buttn1"><a href="javascript:;" onclick="CloseWhihtContent('white_content');"><img src="css/images/blank.gif" alt="" border="0" title="" width="30" height="30" /></a></div>
									<div class="heading">This person is no longer there<br /><br />
										You can see this person's <a href="<?=com_db_output($contact_row['new_position']);?>" target="_blank">new <br />
										position here.</a><br /><br />
										You can see the <?=com_db_output($contact_row['company_name'])?>'s <a href="<?=com_db_output($contact_row['new_person']);?>" target="_blank">new <br />
										<?=com_db_output($contact_row['new_title']);?> here</a>
									</div>
									</div>
								</div>
							</div>
							<div id="update_alert" class="small-popup-inner" style="display:<? if($contact_row['not_current']=='Yes'){echo 'block';}else{echo 'none';}?>;"><a href="javascript:;" onmouseover="showHideNew('white_content')">Update: This person is no longer there</a></div>
							<div class="small-popup-inner-new"><a href="index.php"><img src="css/images/small-logo.png" alt="" width="109" height="23" border="0" title="" /></a></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<!-- end Intro -->
	<!-- Main -->
	<div id="main">
		<!-- Shell -->
		<div class="shell">
			<!-- Content -->
			<div class="content">
				<div class="entry">
					<div class="image"></div>
					<div class="entry-content">
						<h3 class="company-info">What Happened?</h3>
						<p><?=com_db_output($contact_row['what_happened']);?></p>
					</div>
					<div class="cl">&nbsp;</div>
				</div>
				<div class="entry">
					<div class="image1"></div>
					<div class="entry-content">
						<h3 class="company-info">About the Company</h3>
						<p><?=com_db_output($contact_row['about_company']);?></p>
					</div>
					<div class="cl">&nbsp;</div>
				</div>
				<div class="entry">
					<div class="image2"></div>
					<div class="entry-content">
						<h3 class="company-info">About the Person</h3>
						<p><?=com_db_output($contact_row['about_person']);?></p>
					</div>
					<div class="cl">&nbsp;</div>
				</div>
				<div class="entry">
					<div class="image3"></div>
					<div class="entry-content last">
						<h3 class="company-info">Info Source</h3>
						<p><?=trim(com_db_output($contact_row['source']));?></p>
					</div>
					<div class="cl">&nbsp;</div>
				</div>
			</div>
			<!-- Content -->
			<!-- Sidebar -->
			<div class="sidebar">
				<!-- Box -->
				<div class="box">
						<div class="box-t"></div>
						<div class="box-m">
							<h4><img src="css/images/side-img.png" width="31" height="23" alt="image" />Short Profile</h4>
							<div class="cl">&nbsp;</div>
							<p><span class="first">Name:</span> <span class="second"><?=com_db_output($contact_row['first_name']).' '.com_db_output($contact_row['last_name'])?></span></p>
							<p><span class="first">Title:</span> <span class="second"><?=com_db_output($contact_row['new_title']);?></span></p>
							<p><span class="first">Company:</span> <span class="second"><?=str_replace('&','&amp;',com_db_output($contact_row['company_name']));?></span></p>
							<p><span class="first">Industry:</span> <span class="second"><?=str_replace('&','&amp;', com_db_output($contact_row['company_industry']));?></span></p>
						</div>
					<div class="box-t1"></div>
				</div>
				<!-- end Box -->
				<!-- Box -->
				<div class="box last">
					
						<div class="box-t"></div>
						<div class="box-m">
							<h4><img src="css/images/side-img.png" width="31" height="23" alt="image" />Full Contact Info</h4>
							<div class="cl">&nbsp;</div>
							<?  if($_SESSION['sess_is_user'] != 1){
									echo '<p><span class="first">Email:</span> <span class="second">';
									$cemail= explode('@',com_db_output($contact_row['email']));
									if(strlen($cemail[0])>0){
										for($p=0;$p<strlen($cemail[0]);$p++){
											echo '*';
										}
									echo '@';	
									}
									echo $cemail[1].'&nbsp;</span></p>';
									echo '<p><span class="first">Phone:</span><span class="second">';
									$cphone=explode('.',com_db_output($contact_row['phone']));
									if(strlen($cphone[0])>0){
										echo '.';
										for($p=0;$p<strlen($cphone[0]);$p++){
												echo '*';
											}
									}	
									if(strlen($cphone[1])>0){
										echo '.';
										for($p=0;$p<strlen($cphone[1]);$p++){
												echo '*';
											}
									}
									if(strlen($cphone[2])>0){
										echo '.';
										for($p=0;$p<strlen($cphone[2]);$p++){
												if($p==1 || $p==2){
													echo $cphone[2][$p];
												}else{
													echo '*';
												}
											}
									}
									echo '&nbsp;</span></p>';
									echo '<p class="last">To get full contact details, please <a href="login.php">sign in</a> or</p>';
									?>
										<div class="sign-up-box">
										<form name="sign_up" id="sign_up" method="post" action="vigilant-next.php?action=VigilantAppoints&amp;cid=<?=$contact_row['contact_id']?>" onsubmit="return SignUpValidation();">
										<div class="top1"><img src="css/images/spacer.gif" alt="image" width="1" height="6" /></div>
										<div class="middle">
										<div class="inner-signup-new"><div class="title">Sign Up Now</div>
										<div class="title1">It&prime;s free!</div></div>
										<div class="textfield-bg"><input name="full_name" id="full_name_sign" type="text" class="textfield"  value="Type your First and Last Name here" onfocus=" if (this.value == 'Type your First and Last Name here') { this.value = ''; }" onblur="if (this.value == '') { this.value='Type your First and Last Name here';} "  /></div>
										<div id="div_email_sign" class="textfield-bg"><input name="email" id="email_sign" type="text"  class="textfield" value="Type your Work email address here"  onfocus="EmailSignFocus();" onblur="EmailSignBlur();" /></div>
										<div><input name="submit" type="submit" class="next-buttn" value="" /></div>
										</div>
										<div class="bottom1"><img src="css/images/orrenge-box-bottom.jpg" alt="image" width="269" height="9" /></div>
										</form>
										</div>
										<div class="cl">&nbsp;</div>
										<div class="newtext1">Your email is safe with us: see our <a href="privacy-policy.html" class="newlink1">privacy policy</a></div>
								<?				
								}elseif($_SESSION['sess_is_user'] == 1){
									echo '<p><span class="first">Email:</span> <span class="second">'.com_db_output($contact_row['email']).'&nbsp;</span></p>';
									echo '<p><span class="first">Phone:</span><span class="second">'.com_db_output($contact_row['phone']).'&nbsp;</span></p>';
									echo '<p><span class="first">Address:</span><span class="second">'.com_db_output($contact_row['address']).'</span></p>';
									echo '<p><span class="first">City:</span><span class="second">'.com_db_output($contact_row['city']).'&nbsp;</span></p>';
									echo '<p><span class="first">State:</span><span class="second">'.com_db_output($contact_row['state']).'&nbsp;</span></p>';
									echo '<p><span class="first">Zip:</span><span class="second">'.com_db_output($contact_row['zip_code']).'&nbsp;</span></p>';
									echo '<p><span class="first">Country:</span><span class="second">'.com_db_output($contact_row['country']).'&nbsp;</span></p>';
								}	
								?>
						</div>	
				<div class="box-t1"></div>	
				</div>
				<!-- end Box -->
			</div>
			<!-- end Sidebar -->
			<div class="cl">&nbsp;</div>
			<!-- Info -->
			<div class="info">
				<div class="info-b">
					<div class="info-t">
						<p>Other IT executives who recently changed jobs as well: 
						  <?
							$list_query = "select * from " . TABLE_CONTACT . " where status='0' order by rand() limit 11";
							$list_result = com_db_query($list_query);
							if($list_result){
								$list_of_number = com_db_num_rows($list_result);
							}
							$executives_list='';
							while($list_row = com_db_fetch_array($list_result)){
								$cID = $list_row['contact_id'];
								$dim_url = $list_row['contact_url'];
								if($executives_list ==''){
									$executives_list = '<a href="'.$dim_url.'">'.com_db_output($list_row['last_name']).' '.com_db_output($list_row['first_name']).'</a>';
								}else{
									$executives_list .= ', <a href="'.$dim_url.'">'.com_db_output($list_row['last_name']).' '.com_db_output($list_row['first_name']).'</a>';
								}
							}
							echo $executives_list;
						  ?>
						</p>
						<p>You can find the <a href="ITExecutivesDirectory.html">full directory of IT executives here</a>.</p>
                        <p>How would you like to connect with 15,000+ IT executives in charge of $ millions in IT budgets? <a href="pricing.html">Find details here</a>.</p>
					</div>
				</div>
			</div>
			<!-- end Info -->
		</div>
		<!-- end Shell -->
	</div>
	<!-- end Main -->
<? include_once('includes/footer_new.php');?>	
