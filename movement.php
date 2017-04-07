<?PHP 

include("includes/include-top.php");


$dim_url = explode('/', $_SERVER['REQUEST_URI']);

$movement_url =$dim_url[sizeof($dim_url)-1];

$isPresentURL = com_db_GetValue("select move_id from ".TABLE_MOVEMENT_MASTER." where movement_url='".$movement_url."'"); 

if( $isPresentURL=='' ){

	$move_id = $_REQUEST['movement_id'];

	if($move_id !=''){

		$movement_url = com_db_GetValue("select movement_url from ".TABLE_MOVEMENT_MASTER." where move_id='".$move_id."'"); 

	}

	$url_arr = split('-at-',$movement_url);

	if(sizeof($url_arr)<=1 ){

	$url_arr = split('-from-',$movement_url);

	} 

	$url_arr_sub = split('-',$url_arr[0]);

	$now_url = $url_arr_sub[0].'-'.$url_arr_sub[1].'%'.preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '-', ''), $url_arr[1]);

	$movement_url = com_db_GetValue("select movement_url from ".TABLE_MOVEMENT_MASTER." where movement_url like '".$now_url."'"); 

	if($movement_url !=''){

		com_redirect($movement_url);

	}elseif( $movement_url =='' ){

		$url ='not-found.php';

		com_redirect($url);

	}

}



$movementQuery = 'select mm.move_id,mm.personal_id,mm.company_id,mm.title,mm.what_happened,mm.headline,mm.movement_type,s.source,mm.announce_date,cm.company_website,cm.company_name,cm.about_company,cm.industry_id,pm.first_name,pm.last_name,pm.email,pm.phone,pm.about_person from ' 

					.TABLE_MOVEMENT_MASTER . ' as mm, '

					.TABLE_PERSONAL_MASTER. ' as pm, ' 

					.TABLE_COMPANY_MASTER . ' as cm, '

					.TABLE_INDUSTRY . ' as i, '

					.TABLE_SOURCE . ' as s					

					where mm.company_id=cm.company_id and mm.personal_id=pm.personal_id and mm.source_id=s.id and mm.movement_url = "'.$movement_url.'"';

$movementResult = com_db_query($movementQuery);

$mmRow = com_db_fetch_array($movementResult);

$a_date = @explode('-',$mmRow['announce_date']);

$announce_date = date("F d, Y", mktime(0,0,0,$a_date[1],$a_date[2],$a_date[0]));



$comp_domain_name='';

if($mmRow['company_website'] !=''){

	$comp   = array("http://wwww.", "www.","https://www.","http://","https://");

	$comp_domain_name = str_replace($comp,'',$mmRow['company_website']);

	$comp_domain_name =' @'. $comp_domain_name;

}	

$notCurrent = $mmRow['not_current'];

$PageTitle = $PageTitle.$comp_domain_name.' CTOsOnTheMove';

$movement_type = $mmRow['movement_type'];

$PageKeywords=com_db_output($mmRow['first_name']).' '.com_db_output($mmRow['last_name']).', '.com_db_output($mmRow['title']).', '.com_db_output($mmRow['company_name']).', email, '.$comp_domain_name.', CTOsOnTheMove, '.$mt_type;

$PageDescription='Looking for '.com_db_output($mmRow['first_name']).' '.com_db_output($mmRow['last_name']).', '.com_db_output($mmRow['title']).' at '.com_db_output($mmRow['company_name']).'? Contact '.com_db_output($mmRow['first_name']).' today at updated'.$comp_domain_name.' email, phone and address here at '.com_db_output($mmRow['first_name'])."'s profile at CTOsOnTheMove";



include_once('includes/header_new.php');

?>

<!-- Intro -->

	<div class="new-body-bg1">

			<div class="shell-new-header">

				<div class="intro">

					<div class="shell">

                    	

                        <?PHP

						$headline = com_db_output($mmRow['headline']);

						$full_name = com_db_output(trim($mmRow['first_name']).' '.trim($mmRow['last_name']));

						$first_name = com_db_output(trim($mmRow['first_name']));

						$last_name = com_db_output(trim($mmRow['last_name']));

						$personURL = com_db_output(trim($mmRow['first_name']).'_'.trim($mmRow['last_name']).'_Exec_'.$mmRow['personal_id']);

						

						if(stripos($headline,$full_name)!== false){

							$headline = str_ireplace($full_name, '<a href="'.HTTP_SERVER.$personURL.'">'.$full_name.'</a>', $headline);

						}elseif(stripos($headline,$first_name)!== false){

							$headline = str_ireplace($first_name, '<a href="'.HTTP_SERVER.$personURL.'">'.$first_name.'</a>', $headline);

						}elseif(stripos($headline,$last_name)!== false){

							$headline = str_ireplace($last_name, '<a href="'.HTTP_SERVER.$personURL.'">'.$last_name.'</a>', $headline);

						}else{

							$headline = $headline;

						}

						

						$company_name = com_db_output($mmRow['company_name']);

						$comURL = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''),$company_name).'_Company_'.$mmRow['company_id'];

						

						if(stripos($headline,$company_name)!== false){

							$headline = str_ireplace($company_name, '<a href="'.HTTP_SERVER.$comURL.'">'.$company_name.'</a>', $headline);

						}else{

							$headline = $headline;

						}

						

						?>

                        <h2><?=$headline?></h2>

                       

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

										You can see this person's <a href="<?=com_db_output($mmRow['new_position']);?>" target="_blank">new <br />

										position here.</a><br /><br />

										You can see the <?=com_db_output($mmRow['company_name'])?>'s <a href="<?=com_db_output($mmRow['new_person']);?>" target="_blank">new <br />

										<?=com_db_output($mmRow['title']);?> here</a>

									</div>

									</div>

								</div>

							</div>

							<div id="update_alert" class="small-popup-inner" style="display:<?PHP if($mmRow['not_current']=='Yes'){echo 'block';}else{echo 'none';}?>;"><a href="javascript:;" onmouseover="showHideNew('white_content')">Update: This person is no longer there</a></div>

							<div class="small-popup-inner-new">
                                                            <!-- <a href="<?=HTTP_SERVER?>index.php"><img src="css/images/small-logo.png" alt="" width="109" height="23" border="0" title="" /></a> -->
                                                        </div>

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

						<p><?=$mmRow['what_happened'];?></p> 

					</div>

					<div class="cl">&nbsp;</div>

				</div>

				<div class="entry">

					<div class="image1"></div>

					<div class="entry-content">

                    	<?PHP

						$about_company = $mmRow['about_company'];

						$company_name = com_db_output($mmRow['company_name']);

						$comURL = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''),$company_name).'_Company_'.$mmRow['company_id'];

						

						if(stripos($about_company,$company_name)!== false){

							$about_company = str_ireplace($company_name, '<a href="'.HTTP_SERVER.$comURL.'">'.$company_name.'</a>', $about_company);

						}else{

							$about_company = $about_company;

						}

						?>

						<h3 class="company-info"><a href="<?=HTTP_SERVER.$comURL?>">About the Company</a></h3>

						<p><?=$about_company;?></p>

					</div>

					<div class="cl">&nbsp;</div>

				</div>

				<div class="entry">

					<div class="image2"></div>

					<div class="entry-content">

                    	<?PHP

						$about_person = $mmRow['about_person'];

						$full_name = com_db_output($mmRow['first_name'].' '.$mmRow['last_name']);

						$first_name = trim(com_db_output($mmRow['first_name']));

						$last_name = trim(com_db_output($mmRow['last_name']));

						$personURL = com_db_output(trim($mmRow['first_name']).'_'.trim($mmRow['last_name']).'_Exec_'.$mmRow['personal_id']);

						

						if(stripos($about_person,$full_name)!== false){

							$about_person = str_ireplace($full_name, '<a href="'.HTTP_SERVER.$personURL.'">'.$full_name.'</a>', $about_person);

						}elseif(stripos($about_person,$first_name)!== false){

							$about_person = str_ireplace($first_name, '<a href="'.HTTP_SERVER.$personURL.'">'.$first_name.'</a>', $about_person);

						}elseif(stripos($about_person,$last_name)!== false){

							$about_person = str_ireplace($last_name, '<a href="'.HTTP_SERVER.$personURL.'">'.$last_name.'</a>', $about_person);

						}else{

							$about_person = $about_person;

						}

						?>

						<h3 class="company-info"><a href="<?=HTTP_SERVER?><?=com_db_output(trim($mmRow['first_name']).'_'.trim($mmRow['last_name']).'_Exec_'.$mmRow['personal_id'])?>">About the Person</a></h3>

						<p><?=$about_person;?></p>

					</div>

					<div class="cl">&nbsp;</div>

				</div>

				<div class="entry">

					<div class="image3"></div>

					<div class="entry-content last">

						<h3 class="company-info">Info Source</h3>

						<p><?=trim(com_db_output($mmRow['source']));?></p>

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

							<p><span class="first">Name:</span> <span class="second"><a href="<?=HTTP_SERVER?><?=com_db_output($mmRow['first_name'].'_'.$mmRow['last_name'].'_Exec_'.$mmRow['personal_id'])?>"><?=com_db_output($mmRow['first_name'].' '.$mmRow['last_name']);?></a></span></p>

							<p><span class="first">Title:</span> <span class="second"><?=com_db_output($mmRow['title']);?></span></p>

							<p><span class="first">Company:</span> <span class="second"><a href="<?=HTTP_SERVER?><?=preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''), com_db_output($mmRow['company_name'])).'_Company_'.$mmRow['company_id']?>"><?=str_replace('&','&amp;',com_db_output($mmRow['company_name']));?></a></span></p>

							<p><span class="first">Industry:</span> <span class="second"><?=str_replace('&','&amp;', com_db_output(com_db_GetValue("select title from ".TABLE_INDUSTRY." where industry_id='".$mmRow['industry_id']."'")));?></span></p>

						</div>

					<div class="box-t1"></div>

				</div>

				<!-- end Box -->

				<!-- Box -->

				<div class="box last">

					

						<div class="box-t"></div>

						<div class="box-m">

							<h4><img src="css/images/side-img.png" width="31" height="23" alt="image" />Current Contact Info</h4>

							<div class="cl">&nbsp;</div>

							<?PHP  if($_SESSION['sess_is_user'] != 1){

									echo '<p><span class="first">Email:</span> <span class="second">';

									$cemail= explode('@',com_db_output($mmRow['email']));

									if(strlen($cemail[0])>0){

										for($p=0;$p<strlen($cemail[0]);$p++){

											echo '*';

										}

									echo '@';	

									}

									echo $cemail[1].'&nbsp;</span></p>';

									echo '<p><span class="first">Phone:</span><span class="second">';

									$cphone=explode('.',com_db_output($mmRow['phone']));

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

									echo '<p class="last">To get full contact details, please <a href="'.HTTP_SERVER.'login.php">sign in</a> or</p>';

									?>

										<div class="sign-up-box">

										<form name="sign_up" id="sign_up" method="post" action="movement-next.php?action=MovementAppoints&amp;mid=<?=$mmRow['move_id']?>" onsubmit="return SignUpValidation();">

										<input type="hidden" name="referring_links" id="referring_links" value="<?=$current_page?>"/>

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

										<div class="newtext1">Your email is safe with us: see our <a href="<?=HTTP_SERVER?>privacy-policy.html" class="newlink1">privacy policy</a></div>

								<?PHP				

								}elseif($_SESSION['sess_is_user'] == 1){

									echo '<p><span class="first">Email:</span> <span class="second">'.com_db_output($mmRow['email']).'&nbsp;</span></p>';

									echo '<p><span class="first">Phone:</span><span class="second">'.com_db_output($mmRow['phone']).'&nbsp;</span></p>';

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

						<p>Other IT Security executives who recently changed jobs as well: 

						  <?PHP

							$list_query = "select mm.movement_url,pm.first_name,pm.last_name from " . TABLE_MOVEMENT_MASTER . " mm,".TABLE_PERSONAL_MASTER." pm where mm.personal_id=pm.personal_id and mm.status='0' order by rand() limit 11";

							$list_result = com_db_query($list_query);

							if($list_result){

								$list_of_number = com_db_num_rows($list_result);

							}

							$executives_list='';

							while($list_row = com_db_fetch_array($list_result)){

								$cID = $list_row['move_id'];

								$dim_url = $list_row['movement_url'];

								if($executives_list ==''){

									$executives_list = '<a href="'.HTTP_SERVER.$dim_url.'">'.com_db_output($list_row['last_name']).' '.com_db_output($list_row['first_name']).'</a>';

								}else{

									$executives_list .= ', <a href="'.HTTP_SERVER.$dim_url.'">'.com_db_output($list_row['last_name']).' '.com_db_output($list_row['first_name']).'</a>';

								}

							}

							echo $executives_list;

						  ?>

						</p>

						<p>You can find the <a href="<?=HTTP_SERVER?>ITExecutivesDirectory.html">full directory of IT executives here</a>.</p>

                        <p>How would you like to connect with 15,000+ IT Security executives in charge of $ millions in IT budgets? <a href="<?=HTTP_SERVER?>pricing.html">Find details here</a>.</p>

					</div>

				</div>

			</div>

			<!-- end Info -->

		</div>

		<!-- end Shell -->

	</div>

	<!-- end Main -->

<?PHP include_once('includes/footer_new.php');?>	

