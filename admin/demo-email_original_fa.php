<?php
require('includes/include_top.php');

$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 20;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';

$sql_query = "select p.personal_id,p.first_name,p.last_name,p.person_tigger_name,p.add_date  from " . TABLE_PERSONAL_MASTER." p where p.demo_email=1 and p.person_tigger_name <>'' order by p.add_date desc";
/***************** FOR PAGIN ***********************/
$starting_point = $items_per_page * ($p - 1);
/****************** END PAGIN ***********************/
$main_page = 'demo-email.php';

$exe_query=com_db_query($sql_query);
$num_rows=com_db_num_rows($exe_query);
$total_data = $num_rows;

/************ FOR PAGIN **************/
$sql_query .= " LIMIT $starting_point,$items_per_page";
$exe_data = com_db_query($sql_query);

$numRows = com_db_num_rows($exe_data);
/************ END ********************/
$adminInfo = "select * from ". TABLE_ADMIN_SETTINGS ." where setting_id ='1'";
$adminResult = com_db_query($adminInfo);
$adminRow = com_db_fetch_array($adminResult);

$from_admin = $adminRow['site_email_from'];
$to_admin = $adminRow['site_email_address'];

$site_phone_number = com_db_output($adminRow['site_phone_number']);
$site_company_address = com_db_output($adminRow['site_company_address']);
$site_company_city  = com_db_output($adminRow['site_company_city']);
$site_company_state = com_db_output($adminRow['site_company_state']);
$site_company_zip = com_db_output($adminRow['site_company_zip']);
$pID = (isset($_GET['pID']) ? $_GET['pID'] : $select_data[0]);

if($action=='delete'){
	$perQueryUpdate = "update ".TABLE_PERSONAL_MASTER." set demo_email =0, 	person_tigger_name='',all_trigger_id = 0 where personal_id='".$pID."'";
	com_db_query($perQueryUpdate);
	com_redirect("demo-email.php?selected_menu=demoemail&msg=" . msg_encode("Selected Person delete from Demo Email"));
}elseif($action =='DemoEmailCreate'){
	  $trigger = $_POST['selected_trigger'];
	  $person_id = $_POST['nid'];
	  $all_person_id = implode(",",$person_id);
	  $tot_personID = sizeof($all_person_id);
	  
	  //Image & Email check
	  $pfQuery = "select * from ".TABLE_PERSONAL_FILTER_ONOFF." where filter_onoff='ON'";
	  $pfResult = com_db_query($pfQuery);
	  $pfString='';
	  while($pfRow = com_db_fetch_array($pfResult)){
		  if($pfRow['filter_name']=='Personal Image Checking' &&  $pfRow['filter_onoff']=='ON'){
			  if($pfString==''){
				  $pfString = ' personal_image <> ""';
			  }else{
				  $pfString .= ' and personal_image <> ""';
			  }
		  }elseif($pfRow['filter_name']=='Personal Email Checking' &&  $pfRow['filter_onoff']=='ON'){
			 if($pfString==''){
				$pfString = ' (email<>"" and email<>"n/a" and email<>"N/A")';
			 }else{
				$pfString .= ' and (email<>"" and email<>"n/a" and email<>"N/A")';
			 }
		  }
	  }
	  
	  if($tot_personID > 0){
		  if($pfString==''){
		  	$perQuery = "select first_name,last_name,email,personal_image,personal_id,demo_email,person_tigger_name,all_trigger_id from ".TABLE_PERSONAL_MASTER." where personal_id in (".$all_person_id.")";
		  }else{
		  	$perQuery = "select first_name,last_name,email,personal_image,personal_id,demo_email,person_tigger_name,all_trigger_id from ".TABLE_PERSONAL_MASTER." where ".$pfString." and personal_id in (".$all_person_id.")";
		  }
		  
		  $perResult = com_db_query($perQuery);
	  	  if($perResult){
			  $perNumRows = com_db_num_rows($perResult);
		  }
		  $appointments_id_list='';
		  $awards_id_list='';
		  $board_id_list='';
		  $media_id_list='';
		  $publication_id_list='';
		  $speaking_id_list='';
		  $person_info = array();
		  $person_id_info = array();
		  $p=0;	
		  if($perNumRows>0){
			  
			  while($perRow = com_db_fetch_array($perResult)){
			  	//Appointments
				if($perRow['person_tigger_name']=='Appointments'){
					if($appointments_id_list==''){
						$appointments_id_list = $perRow['all_trigger_id'];
					}else{
						$appointments_id_list .= ",".$perRow['all_trigger_id'];
					}
				}
				//Awards
				if($perRow['person_tigger_name']=='Awards'){
					if($awards_id_list==''){
						$awards_id_list=$perRow['all_trigger_id'];
					}else{
						$awards_id_list .= ",".$perRow['all_trigger_id'];
					}
				}
				//Board
				if($perRow['person_tigger_name']=='Board'){
					if($board_id_list==''){
						$board_id_list=$perRow['all_trigger_id'];
					}else{
						$board_id_list .= ",".$perRow['all_trigger_id'];
					}
				}
				//Media Mention
				if($perRow['person_tigger_name']=='Media Mention'){
					if($media_id_list==''){
						$media_id_list=$perRow['all_trigger_id'];
					}else{
						$media_id_list .= ",".$perRow['all_trigger_id'];
					}
				}
				//Publication
				if($perRow['person_tigger_name']=='Publication'){
					if($publication_id_list==''){
						$publication_id_list=$perRow['all_trigger_id'];
					}else{
						$publication_id_list .= ",".$perRow['all_trigger_id'];
					}
				}
				//Speaking
				if($perRow['person_tigger_name']=='Speaking'){
					if($speaking_id_list==''){
						$speaking_id_list=$perRow['all_trigger_id'];
					}else{
						$speaking_id_list .= ",".$perRow['all_trigger_id'];
					}
				}
				//
				  $person_id = $perRow['personal_id'];
				  $pFirstName = trim(com_db_output($perRow['first_name']));
				  $pLastName = trim(com_db_output($perRow['last_name']));	
				  $personalURL = trim($pFirstName).'_'.trim($pLastName).'_Exec_'.$person_id;
				  
				  $personal_image = $perRow['personal_image'];
				  if($personal_image !=''){
					  $personal_image_path = HTTP_SITE_URL.'personal_photo/small/'.$personal_image;
				  }else{
					  $personal_image_path = HTTP_SITE_URL.'personal_photo/small/no_image_information.png';
				  }
				  
				if(sizeof($person_id_info)==0){
					$person_id_info[] = $person_id;
					$personal_image = $perRow['personal_image'];
					if($personal_image !=''){
						$person_info[$p]['pimage'] = $personal_image;
					}else{
						$person_info[$p]['pimage'] = 'no_image_information.png';
					}
					$person_info[$p]['purl'] = $personalURL;
					$person_info[$p]['pname'] = substr($pFirstName.' '.$pLastName,0,12);
					$p++;
				}elseif(!in_array ($person_id,$person_id_info)){
					$person_id_info[] = $person_id;
					$personal_image = $perRow['personal_image'];
					if($personal_image !=''){
						$person_info[$p]['pimage'] = $personal_image;
					}else{
						$person_info[$p]['pimage'] = 'no_image_information.png';
					}
					$person_info[$p]['purl'] = $personalURL;
					$person_info[$p]['pname'] = substr($pFirstName.' '.$pLastName,0,12);
					$p++;
				}
			  }
		  }
		  	$totPerson = sizeof($person_info);
				
			$table1 = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>';
			for($q=0;$q<4;$q++){
				if($person_info[$q]['pname'] !=''){
					$table1 .='<td valign="top">
									<div class="img" style="font-size:0pt; line-height:0pt; text-align:left">
										<a href="'.HTTP_SITE_URL.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTP_SITE_URL.'personal_photo/small/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" height="80" /></a>
									</div>
									<div class="thumb-name" style="color:#ffffff; font-family:Arial; font-size:11px; line-height:17px; text-align:center; background-color:#333333">'.$person_info[$q]['pname'].'</div>
									<div style="font-size:0pt; line-height:0pt; height:1px; background:#ffffff; "><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
								</td>
								<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"></td>';
				}else{
					$table1 .='<td valign="top">
									<div class="img" style="font-size:0pt; line-height:0pt; text-align:left;width:80px;">
										&nbsp;
									</div>
									<div class="thumb-name" style="color:#ffffff; font-family:Arial; font-size:11px; line-height:17px; text-align:center;>&nbsp;</div>
									<div style="font-size:0pt; line-height:0pt; height:1px; ">&nbsp;</div>
								</td>
								<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"></td>';
				}
			}
			$table1 .= '</tr>
					 </table>';
		   
		   $table2 = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>';
			for($q=4;$q<8;$q++){
				if($person_info[$q]['pname'] !=''){
					$table2 .='<td valign="top">
									<div class="img" style="font-size:0pt; line-height:0pt; text-align:left">
										<a href="'.HTTP_SITE_URL.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTP_SITE_URL.'personal_photo/small/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" height="80" /></a>
									</div>
									<div class="thumb-name" style="color:#ffffff; font-family:Arial; font-size:11px; line-height:17px; text-align:center; background-color:#333333">'.$person_info[$q]['pname'].'</div>
									<div style="font-size:0pt; line-height:0pt; height:1px; background:#ffffff; "><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
								</td>
								<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"></td>';
				}else{
					$table2 .='<td valign="top">
									<div class="img" style="font-size:0pt; line-height:0pt; text-align:left;width:80px;">
										&nbsp;
									</div>
									<div class="thumb-name" style="color:#ffffff; font-family:Arial; font-size:11px; line-height:17px; text-align:center;>&nbsp;</div>
									<div style="font-size:0pt; line-height:0pt; height:1px; ">&nbsp;</div>
								</td>
								<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"></td>';
				}
			}
			$table2 .= '</tr>
					 </table>';	
			
			$table3 = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>';
			for($q=8;$q<12;$q++){
				if($person_info[$q]['pname'] !=''){
					$table3 .='<td valign="top">
									<div class="img" style="font-size:0pt; line-height:0pt; text-align:left">
										<a href="'.HTTP_SITE_URL.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTP_SITE_URL.'personal_photo/small/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" height="80" /></a>
									</div>
									<div class="thumb-name" style="color:#ffffff; font-family:Arial; font-size:11px; line-height:17px; text-align:center; background-color:#333333">'.$person_info[$q]['pname'].'</div>
									<div style="font-size:0pt; line-height:0pt; height:1px; background:#ffffff; "><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
								</td>
								<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"></td>';
				}else{
					$table3 .='<td valign="top">
									<div class="img" style="font-size:0pt; line-height:0pt; text-align:left;width:80px;">
										&nbsp;
									</div>
									<div class="thumb-name" style="color:#ffffff; font-family:Arial; font-size:11px; line-height:17px; text-align:center;>&nbsp;</div>
									<div style="font-size:0pt; line-height:0pt; height:1px; ">&nbsp;</div>
								</td>
								<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"></td>';
				}
			}
			$table3 .= '</tr>
					 </table>';
		   
		   $table4 = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>';
			for($q=12;$q<16;$q++){
				if($person_info[$q]['pname'] !=''){
					$table4 .='<td valign="top">
									<div class="img" style="font-size:0pt; line-height:0pt; text-align:left">
										<a href="'.HTTP_SITE_URL.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTP_SITE_URL.'personal_photo/small/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" height="80" /></a>
									</div>
									<div class="thumb-name" style="color:#ffffff; font-family:Arial; font-size:11px; line-height:17px; text-align:center; background-color:#333333">'.$person_info[$q]['pname'].'</div>
									<div style="font-size:0pt; line-height:0pt; height:1px; background:#ffffff; "><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
								</td>
								<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"></td>';
				}else{
					$table4 .='<td valign="top">
									<div class="img" style="font-size:0pt; line-height:0pt; text-align:left;width:80px;">
										&nbsp;
									</div>
									<div class="thumb-name" style="color:#ffffff; font-family:Arial; font-size:11px; line-height:17px; text-align:center;>&nbsp;</div>
									<div style="font-size:0pt; line-height:0pt; height:1px; ">&nbsp;</div>
								</td>
								<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"></td>';
				}
			}
			$table4 .= '</tr>
					 </table>';			 		 
				
			
			if($totPerson<=8){
				$perImgName = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
								   <tr>
										<td valign="top" class="column">
											'.$table1.'
										</td>
										<td valign="top" class="column">
											'.$table2.'
										</td>
									</tr>
								</table>';
			}elseif($totPerson>8){
				$perImgName = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
								   <tr>
										<td valign="top" class="column">
											'.$table1.'
										</td>
										<td valign="top" class="column">
											'.$table2.'
										</td>
									</tr>
									<tr>
										<td valign="top" class="column">
											'.$table3.'
										</td>
										<td valign="top" class="column">
											'.$table4.'
										</td>
									</tr>
								</table>';
			}
			
			$person_image_name = '<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SITE_URL.'images/box_top.jpg" alt="" border="0" width="660" height="5" /></div></div>
									<table width="100%" border="0" cellspacing="0" cellpadding="0" class="w320">
										<tr>
											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
											<td>
												<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#333333">
													<tr>
														<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="20">
                                                        	<div style="font-size:0pt; line-height:0pt; height:50px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="50" style="height:50px" alt="" /></div>
                                                            <div style="font-size:0pt; line-height:0pt; height:11px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="11" style="height:11px" alt="" /></div>
                                                         </td>
														<td class="h1" style="color:#ffffff; font-family:Arial; font-size:20px; line-height:24px; text-align:left; font-weight:normal">Reach out and engage your clients and prospects now:</td>
														<td align="right" width="200" class="btn-container2">
															<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">
																<tr>
																	<td>
																		<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">
																			<tr>
																				<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1">
																					<div class="hide-for-mobile">
																						<div style="font-size:0pt; line-height:0pt; height:40px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="40" style="height:40px" alt="" /></div>
                                                                                	</div>
																					<div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="0" alt="" /></div>
                                                                                </td>
																				<td class="btn2" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="170"><a href="mailto:ctos_alerts@aweber.com?subject=free CIO alerts&body=please add me to the free CIO alert list"" target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Get Free Updates &rsaquo;</span></a></td>
																			</tr>
																		</table>
																	</td>
																</tr>
															</table>
														</td>
														<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="10"></td>
													</tr>
												</table>
												
												<table width="100%" border="0" cellspacing="0" cellpadding="1" bgcolor="#ffffff" class="w320">
													<tr>
														<td>
														'.$perImgName.'
														</td>
													</tr>
												</table>
											</td>
											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
										</tr>
									</table>
									<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SITE_URL.'images/box_bottom.jpg" alt="" border="0" width="660" height="5" /></div></div>';
	  }
	  
	  
	$email_alert_id  = time();
	$messageHead = '<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#eaeaea">
								<tr>
								  <td align="center" valign="top">
									<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" class="w320">
										<tr>
											<td align="center">
												<table width="650" border="0" cellspacing="0" cellpadding="0" class="w320">
													<tr>
														<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div style="font-size:0pt; line-height:0pt; height:45px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="45" style="height:45px" alt="" /></div></td>
														<td class="column2"><div class="top" style="color:#7a7a7a; font-family:Arial; font-size:11px; line-height:18px; text-align:left">Having trouble viewing this email? <a href="'.HTTP_SITE_URL.'demo-email-show.php?emailid='.$email_alert_id.'" target="_blank" class="link-top" style="color:#5c97d8; text-decoration:underline"><span class="link-top" style="color:#5c97d8; text-decoration:underline">View it in your browser</span></a></div></td>
														<td align="right" class="column2">
															<table border="0" cellspacing="0" cellpadding="0">
																<tr>
																	<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="8"><img src="'.HTTP_SITE_URL.'images/bullet1.jpg" alt="" border="0" width="2" height="3" /></td>
																	<td class="top" style="color:#7a7a7a; font-family:Arial; font-size:11px; line-height:18px; text-align:left"><a href="'.HTTP_SITE_URL.'demo-email-show.php?emailid='.$email_alert_id.'" target="_blank" class="link-top" style="color:#5c97d8; text-decoration:underline"><span class="link-top" style="color:#5c97d8; text-decoration:underline">Online version</span></a></td>
																	<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="17"></td>	
																	<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="8"><img src="'.HTTP_SITE_URL.'images/bullet1.jpg" alt="" border="0" width="2" height="3" /></td>
																	<td class="top" style="color:#7a7a7a; font-family:Arial; font-size:11px; line-height:18px; text-align:left"><a href="mailto:<Please enter your friend email id?subject=Congrats&amp;body=Congrats%20on%20your%20recent%20appointment" target="_blank" class="link-top" style="color:#5c97d8; text-decoration:underline"><span class="link-top" style="color:#5c97d8; text-decoration:underline">Forward to a friend</span></a></td>
																</tr>
															</table>
														</td>
														<td class="mobile-space" style="font-size:0pt; line-height:0pt; text-align:left"></td>
													</tr>
												</table>
												<div style="font-size:0pt; line-height:0pt; height:1px; background:#cfcfcf; "><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
						
											</td>
										</tr>
									</table>
									<div style="font-size:0pt; line-height:0pt; height:30px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="30" style="height:30px" alt="" /></div>
						
									<table width="100%" border="0" cellspacing="0" cellpadding="0" class="w320">
										<tr>
											<td align="center">
												<table width="650" border="0" cellspacing="0" cellpadding="0" class="w320">
													<tr>
														<td class="img" style="font-size:0pt; line-height:0pt; text-align:left"><a href="'.HTTP_SITE_URL.'index.php" target="_blank"><img src="'.HTTP_SITE_URL.'images/email-alert-logo.jpg" width="267" height="25" alt="" border="0" /></a></td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
									<div style="font-size:0pt; line-height:0pt; height:30px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="30" style="height:30px" alt="" /></div>
									<table width="100%" border="0" cellspacing="0" cellpadding="0" class="w320">
										<tr>
											<td align="center">
												<table width="660" border="0" cellspacing="0" cellpadding="0" class="w320">
													<tr>
														<td align="center">';
	$from_admin = com_db_GetValue("select site_email_from from ".TABLE_ADMIN_SETTINGS ." where setting_id ='1'");
	$messageFooter = '
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>
										
										<div style="font-size:0pt; line-height:0pt; height:15px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="15" style="height:35px" alt="" /></div>
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td align="center" width="670" class="btn-container3">
													<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">
														<tr>
															<td>
																<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">
																	<tr>
																		<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1">
																			<div class="hide-for-mobile">
																				<div style="font-size:0pt; line-height:0pt; height:40px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="40" style="height:40px" alt="" /></div>
																			</div>
																			<div style="font-size:0pt; line-height:0pt;" class="mobile-br-40"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="0" alt="" /></div>
																		</td>
																		<td class="btn3" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="670"><a href="mailto:ctos_alerts@aweber.com?subject=free CIO alerts&body=please add me to the free CIO alert list"" target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Get Email Updates on CIOs'."'".' Appointments, Speaking Engagements, and Industry Awards &rsaquo;</span></a></td>
																	</tr>
																</table>
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>
										<div style="font-size:0pt; line-height:0pt; height:35px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="35" style="height:35px" alt="" /></div>
			
										<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#333333" class="w320">
											<tr>
												<td class="footer" style="color:#adadad; font-family:Arial; font-size:12px; line-height:18px; text-align:center">
													<div class="hide-for-mobile">
														<div style="font-size:0pt; line-height:0pt; height:1px; background:#d2d2d2; "><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
							
														<div style="font-size:0pt; line-height:0pt; height:1px; background:#ffffff; "><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
							
													</div>
													<div style="font-size:0pt; line-height:0pt; height:30px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="30" style="height:30px" alt="" /></div>
							
													<strong style="font-size: 15px; line-height: 19px; color:#e0e0e0">Actionable Information Advisory Inc., '.$site_company_address.', '.$site_company_state.', '. $site_company_zip.'</strong>
													<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>
							
													This daily newsletter was sent to '.$from_admin.' from Company Name because you subscribed.<br />
													Rather not receive our newsletter anymore? <a href="#" target="_blank" class="link3-u" style="color:#adadad; text-decoration:underline"><span class="link3-u" style="color:#adadad; text-decoration:underline">Unsubscribe instantly</span></a>.
							
													<div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:50px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="50" style="height:50px" alt="" /></div></div>
													<div style="font-size:0pt; line-height:0pt;" class="mobile-br-25"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="0" alt="" /></div>
							
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>';	
	$triggers_name = $trigger;	
	//Appointments
	if($appointments_id_list !=''){
		$app_query = "select mm.*,pm.first_name,pm.last_name,pm.email,pm.personal_image,cm.company_name from ".TABLE_MOVEMENT_MASTER." mm, ".TABLE_PERSONAL_MASTER." pm, ".TABLE_COMPANY_MASTER." cm where (mm.company_id=cm.company_id and mm.personal_id=pm.personal_id) and mm.move_id in (".$appointments_id_list.")";	
		$app_result = com_db_query($app_query);
		  if($app_result){
				$numRows = com_db_num_rows($app_result);
		  }
		  $cnt=1;
		  $messageSrt='';
		  $messageEmail='';	
		  //$effective_date_within_60day = date("Y-m-d",mktime(0,0,0,date("m"),(date("d")-60),date("Y"))); 
		  while($email_row = com_db_fetch_array($app_result)){
			  	
				  $person_id = $email_row['personal_id'];
				  $pFirstName = trim(com_db_output($email_row['first_name']));
				  $pLastName = trim(com_db_output($email_row['last_name']));	
				  $personalURL = trim($pFirstName).'_'.trim($pLastName).'_Exec_'.$person_id;
				  
				  if($email_row['effective_date'] > $effective_date_within_60day){
					  if($email_row['movement_type']==1){
						 $movement = ' was Appointed as ';
					  }elseif($email_row['movement_type']==2){
						  $movement = ' was Promoted to ';
					  }elseif($email_row['movement_type']==3){
						  $movement = ' Retired as ';
					  }elseif($email_row['movement_type']==4){
						  $movement = ' Resigned as '; 
					  }elseif($email_row['movement_type']==5){
						  $movement = ' was Terminated as ';
					  }elseif($email_row['movement_type']==6){
						  $movement = ' was Appointed to ';
					  }elseif($email_row['movement_type']==7){
						  $movement = ' Job Opening ';
					  }
					  
					  $heading = com_db_output($email_row['first_name'].' '.$email_row['last_name'].$movement.$email_row['title'].' at '.$email_row['company_name']);
					  $personal_image = $email_row['personal_image'];
					  if($personal_image !=''){
						  $personal_image_path = HTTP_SITE_URL.'personal_photo/small/'.$personal_image;
					  }else{
						  $personal_image_path = HTTP_SITE_URL.'personal_photo/small/no_image_information.png';
					  }
					  					  
					  if($email_row['more_link'] ==''){
							$messageSrt .='<table width="100%" border="0" cellspacing="0" cellpadding="20">
												<tr>
													<td>
														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTP_SITE_URL.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>
																<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">
																	'.$heading.'
																	<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>
																	<table width="100%" border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td align="left">
																				<table border="0" cellspacing="0" cellpadding="0">
																					<tr>
																						<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTP_SITE_URL.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>
																						<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SITE_URL.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
																						<td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>
																						<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"></td>
																						<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"></td>
																					</tr>
																				</table>
																			</td>
																		</tr>
																	</table>
																</td>
																<td align="right" width="170" class="btn-container">
																	<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">
																		<tr>
																			<td>
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">
																					<tr>
																						<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div></div>
																						<div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="0" alt="" /></div>
																						 </td>
																						<td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$email_row['email'].'?subject=Congrats&amp;body=Congrats on your appointment" target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>
																					</tr>
																				</table>
																			</td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
											<div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>';
					  		
					  }else{
							$messageSrt .='<table width="100%" border="0" cellspacing="0" cellpadding="20">
												<tr>
													<td>
														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTP_SITE_URL.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>
																<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">
																	'.$heading.'
																	<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>
																	<table width="100%" border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td align="left">
																				<table border="0" cellspacing="0" cellpadding="0">
																					<tr>
																						<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTP_SITE_URL.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>
																						<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SITE_URL.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
																						<td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>
																						<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.$email_row['more_link'].'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Source</span></a></td>
																						<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SITE_URL.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
																					</tr>
																				</table>
																			</td>
																		</tr>
																	</table>
																</td>
																<td align="right" width="170" class="btn-container">
																	<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">
																		<tr>
																			<td>
																				<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">
																					<tr>
																						<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div></div>
																						<div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="0" alt="" /></div>
																						 </td>
																						<td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$email_row['email'].'?subject=Congrats on your appointment" target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>
																					</tr>
																				</table>
																			</td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
											<div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>';
					  		
					  }
				  }
						
				}//end while
				if($messageSrt!=''){
					$message = '<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SITE_URL.'images/box_top.jpg" alt="" border="0" width="660" height="5" /></div></div>
									<table width="100%" border="0" cellspacing="0" cellpadding="0" class="w320">
										<tr>
											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
											<td>
												<table width="100%" border="0" cellspacing="0" cellpadding="1" bgcolor="#c7c7c7">
													<tr>
														<td>
															<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
																<tr>
																	<td>
																		
																		<div style="font-size:0pt; line-height:0pt; height:1px; background:#4785ca; "><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>

																		<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#5f9bde">
																			<tr>
																				<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="20"><div style="font-size:0pt; line-height:0pt; height:50px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="50" style="height:50px" alt="" /></div>
																					<div style="font-size:0pt; line-height:0pt; height:4px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="4" style="height:4px" alt="" /></div>
																				</td>
																				<td class="h2" style="color:#ffffff; font-family:Arial; font-size:18px; line-height:22px; text-align:left; font-weight:bold">Appointments and Promotions</td>
																			</tr>
																		</table>
																		<div style="font-size:0pt; line-height:0pt; height:1px; background:#4785ca; "><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
																		'.$messageSrt.'
																	</td>
																</tr>
															</table>
														</td>
													</tr>
												</table>
											</td>
											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
										</tr>
									</table>
									<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SITE_URL.'images/box_bottom.jpg" alt="" border="0" width="660" height="5" /></div></div>
									<div style="font-size:0pt; line-height:0pt; height:20px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="20" style="height:20px" alt="" /></div>';
				}
	}
	
	//for personal speaking 
	if($speaking_id_list !=''){
		$psQuery = "select ps.*,pm.first_name,pm.last_name,pm.email,pm.personal_image from ".TABLE_PERSONAL_SPEAKING." ps, ".TABLE_PERSONAL_MASTER." pm where ps.personal_id=pm.personal_id and ps.event_date >'".date("Y-m-d")."' and ps.speaking_id in (".$speaking_id_list.") order by ps.add_date desc";	
		$psResult = com_db_query($psQuery);	
		if($psResult){
			$psNumRow = com_db_num_rows($psResult);	
			if($psNumRow>0){
				$message .='<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SITE_URL.'images/box_top.jpg" alt="" border="0" width="660" height="5" /></div></div>
							<table width="100%" border="0" cellspacing="0" cellpadding="0" class="w320">
								<tr>
									<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
									<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
									<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
									<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
									<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
									<td>
										<table width="100%" border="0" cellspacing="0" cellpadding="1" bgcolor="#c7c7c7">
											<tr>
												<td>
												
													<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
														<tr>
															<td>
																
																<div style="font-size:0pt; line-height:0pt; height:1px; background:#4785ca; "><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
							
																<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#5f9bde">
																	<tr>
																		<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="20"><div style="font-size:0pt; line-height:0pt; height:50px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="50" style="height:50px" alt="" /></div>
																			<div style="font-size:0pt; line-height:0pt; height:4px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="4" style="height:4px" alt="" /></div>
																		</td>
																		<td class="h2" style="color:#ffffff; font-family:Arial; font-size:18px; line-height:22px; text-align:left; font-weight:bold">Speaking Engagements</td>
																	</tr>
																</table>';
				$sp=1;
				while($psRow = com_db_fetch_array($psResult)){
						$person_id = $psRow['personal_id'];
						$pFirstName = com_db_output($psRow['first_name']);
						$pLastName = com_db_output($psRow['last_name']);	
						$personalURL = trim($pFirstName).'_'.trim($pLastName).'_Exec_'.$person_id;
									
						$event_date = $psRow['event_date'];
						$edt = explode('-',$event_date);
						if($psRow['role']=='Speaker' || $psRow['role']=='Panelist'){
							$speakingRole = 'speak';
						}else{
							$speakingRole = $psRow['role'];
						}
						if($event_date=='0000-00-00'){
							$speaking = ' scheduled to '.$speakingRole.' at '.com_db_output($psRow['event']);
						}elseif($event_date > date("Y-m-d")){
							$speaking = ' scheduled to '.$speakingRole.' at '.com_db_output($psRow['event']).' on '.date("M j, Y",mktime(0,0,0,$edt[1],$edt[2],$edt[0]));
						}else{
							$speaking = ' scheduled to "' .$speakingRole.' at the '.com_db_output($psRow['event']);
						}
						$personal_image = $psRow['personal_image'];
						if($personal_image !=''){
						  $personal_image_path = HTTP_SITE_URL.'personal_photo/small/'.$personal_image;
						}else{
						  $personal_image_path = HTTP_SITE_URL.'personal_photo/small/no_image_information.png';
						}
						if($psRow['speaking_link'] !=''){
							$message .=' <div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
										<table width="100%" border="0" cellspacing="0" cellpadding="20">
											<tr>
												<td>
													<table width="100%" border="0" cellspacing="0" cellpadding="0">
														<tr>
															<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTP_SITE_URL.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>
															<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">
																'.$pFirstName.' '.$pLastName.' '.$speaking.'
																<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>
	
																<table width="100%" border="0" cellspacing="0" cellpadding="0">
																	<tr>
																		<td align="left">
																			<table border="0" cellspacing="0" cellpadding="0">
																				<tr>
																					<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTP_SITE_URL.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>
																					<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SITE_URL.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
																					<td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>
																					<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.$psRow['speaking_link'].'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Source</span></a></td>
																					<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SITE_URL.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
																				</tr>
																			</table>
																		</td>
																	</tr>
																</table>
															</td>
															<td align="right" width="170" class="btn-container">
																<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">
																	<tr>
																		<td>
																			<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">
																				<tr>
																					<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div>
																					</div><div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="0" alt="" /></div>
																					</td>
																					<td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$psRow['email'].'?subject=Congrats&amp;body=I noticed you are speaking at an industry event and decided to reach out." target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>
																				</tr>
																			</table>
																		</td>
																	</tr>
																</table>
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>';
							
						}else{
							$message .=' <div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
										<table width="100%" border="0" cellspacing="0" cellpadding="20">
											<tr>
												<td>
													<table width="100%" border="0" cellspacing="0" cellpadding="0">
														<tr>
															<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTP_SITE_URL.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>
															<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">
																'.$pFirstName.' '.$pLastName.' '.$speaking.'
																<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>
	
																<table width="100%" border="0" cellspacing="0" cellpadding="0">
																	<tr>
																		<td align="left">
																			<table border="0" cellspacing="0" cellpadding="0">
																				<tr>
																					<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTP_SITE_URL.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>
																					<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SITE_URL.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
																					<td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>
																					<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"></td>
																					<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"></td>
																				</tr>
																			</table>
																		</td>
																	</tr>
																</table>
															</td>
															<td align="right" width="170" class="btn-container">
																<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">
																	<tr>
																		<td>
																			<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">
																				<tr>
																					<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div>
																					</div><div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="0" alt="" /></div>
																					</td>
																					<td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$psRow['email'].'?subject=I noticed you are speaking at an industry event and decided to reach out." target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>
																				</tr>
																			</table>
																		</td>
																	</tr>
																</table>
															</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>';
							
						}
					$sp++;
				}
				
			$message .=' 	</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
							</tr>
						</table>
						<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SITE_URL.'images/box_bottom.jpg" alt="" border="0" width="660" height="5" /></div></div>
						<div style="font-size:0pt; line-height:0pt; height:20px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="20" style="height:20px" alt="" /></div>';
			
			}
		 }
	}
	if($media_id_list !=''){
		$pmmQuery = "select pmm.*,pm.first_name,pm.last_name,pm.email,pm.personal_image from ".TABLE_PERSONAL_MEDIA_MENTION." pmm, ".TABLE_PERSONAL_MASTER." pm where pmm.personal_id=pm.personal_id and pmm.mm_id in (".$media_id_list.") order by pmm.add_date desc";	
		$pmmResult = com_db_query($pmmQuery);	
		if($pmmResult){
		$pmmNumRow = com_db_num_rows($pmmResult);	
		if($pmmNumRow>0){
			$message .='<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SITE_URL.'images/box_top.jpg" alt="" border="0" width="660" height="5" /></div></div>
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="w320">
							<tr>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
								<td>
									<table width="100%" border="0" cellspacing="0" cellpadding="1" bgcolor="#c7c7c7">
										<tr>
											<td>
												<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
													<tr>
														<td>
														
															<div style="font-size:0pt; line-height:0pt; height:1px; background:#4785ca; "><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
						
															<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#5f9bde">
																<tr>
																	<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="20"><div style="font-size:0pt; line-height:0pt; height:50px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="50" style="height:50px" alt="" /></div>
																	<div style="font-size:0pt; line-height:0pt; height:4px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="4" style="height:4px" alt="" /></div>
																	</td>
																	<td class="h2" style="color:#ffffff; font-family:Arial; font-size:18px; line-height:22px; text-align:left; font-weight:bold">Media Mentions</td>
																</tr>
															</table>';
															
				$med=1;
				while($pmmRow = com_db_fetch_array($pmmResult)){
					$person_id = $pmmRow['personal_id'];
					$pFirstName = com_db_output($pmmRow['first_name']);
					$pLastName = com_db_output($pmmRow['last_name']);	
					$personalURL = trim($pFirstName).'_'.trim($pLastName).'_Exec_'.$person_id;
					$pub_date = $pmmRow['pub_date'];
					$pdt = explode('-',$pub_date);
					if($pub_date=='0000-00-00'){
						$media_mention = ' was quoted by '.com_db_output($pmmRow['publication']);
					}elseif($pub_date < date("Y-m-d")){
						$media_mention = ' was quoted by '.com_db_output($pmmRow['publication']).' on '.date("M j, Y",mktime(0,0,0,$pdt[1],$pdt[2],$pdt[0]));
					}else{
						$media_mention = ' is "' .com_db_output($pmmRow['quote']).'" by '.com_db_output($pmmRow['publication']);
					}
					$personal_image = $pmmRow['personal_image'];
					if($personal_image !=''){
					  $personal_image_path = HTTP_SITE_URL.'personal_photo/small/'.$personal_image;
					}else{
					  $personal_image_path = HTTP_SITE_URL.'personal_photo/small/no_image_information.png';
					}
					if($pmmRow['media_link'] !=''){
						$message .=	'<div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
									 <table width="100%" border="0" cellspacing="0" cellpadding="20">
										<tr>
											<td>
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTP_SITE_URL.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>
														<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">
															'.$pFirstName.' '.$pLastName.' '.$media_mention.'
															<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>

															<table width="100%" border="0" cellspacing="0" cellpadding="0">
																<tr>
																	<td align="left">
																		<table border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTP_SITE_URL.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>
																				<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SITE_URL.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
																				<td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>
																				<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.$pmmRow['media_link'].'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Source</span></a></td>
																				<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SITE_URL.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
																			</tr>
																		</table>
																	</td>
																</tr>
															</table>
														</td>
														<td align="right" width="170" class="btn-container">
															<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">
																<tr>
																	<td>
																		<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">
																			<tr>
																				<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div>
																				</div><div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="0" alt="" /></div>
																				</td>
																				<td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$pmmRow['email'].'?subject=Congrats&amp;body=I noticed you were recently quoted in media and decided to reach out." target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>
																			</tr>
																		</table>
																	</td>
																</tr>
															</table>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>';
						
					}else{
						$message .=	'<div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
									 <table width="100%" border="0" cellspacing="0" cellpadding="20">
										<tr>
											<td>
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTP_SITE_URL.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>
														<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">
															'.$pFirstName.' '.$pLastName.' '.$media_mention.'
															<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>

															<table width="100%" border="0" cellspacing="0" cellpadding="0">
																<tr>
																	<td align="left">
																		<table border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTP_SITE_URL.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>
																				<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SITE_URL.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
																				<td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>
																				<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"></td>
																				<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"></td>
																			</tr>
																		</table>
																	</td>
																</tr>
															</table>
														</td>
														<td align="right" width="170" class="btn-container">
															<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">
																<tr>
																	<td>
																		<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">
																			<tr>
																				<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div>
																				</div><div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="0" alt="" /></div>
																				</td>
																				<td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$pmmRow['email'].'?subject=I noticed you were recently quoted in media and decided to reach out." target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>
																			</tr>
																		</table>
																	</td>
																</tr>
															</table>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>';
					}
				
				$med++;
				}
			$message .=' 								</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
							</tr>
						</table>
						<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SITE_URL.'images/box_bottom.jpg" alt="" border="0" width="660" height="5" /></div></div>
						
						<div style="font-size:0pt; line-height:0pt; height:20px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="20" style="height:20px" alt="" /></div>';	
			
			}
		}
	}
	//for personal Industry Awards
	if($awards_id_list !=''){		
		$paQuery = "select pa.*,pm.first_name,pm.last_name,pm.email,pm.personal_image from ".TABLE_PERSONAL_AWARDS." pa, ".TABLE_PERSONAL_MASTER." pm where pa.personal_id=pm.personal_id and pa.awards_id in (".$awards_id_list.") order by pa.add_date desc";	
		$paResult = com_db_query($paQuery);	
		if($paResult){
		$paNumRow = com_db_num_rows($paResult);	
		if($paNumRow>0){
			$message .='<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SITE_URL.'images/box_top.jpg" alt="" border="0" width="660" height="5" /></div></div>
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="w320">
						<tr>
							<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
							<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
							<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
							<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
							<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
							<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="1" bgcolor="#c7c7c7">
									<tr>
										<td>
											<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
												<tr>
													<td>
														
														<div style="font-size:0pt; line-height:0pt; height:1px; background:#4785ca; "><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
						
														<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#5f9bde">
															<tr>
																<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="20"><div style="font-size:0pt; line-height:0pt; height:50px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="50" style="height:50px" alt="" /></div>
																<div style="font-size:0pt; line-height:0pt; height:4px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="4" style="height:4px" alt="" /></div>
																</td>
																<td class="h2" style="color:#ffffff; font-family:Arial; font-size:18px; line-height:22px; text-align:left; font-weight:bold">Industry Awards</td>
															</tr>
														</table>';

			$ind=1;
			while($paRow = com_db_fetch_array($paResult)){
					$person_id = $paRow['personal_id'];
					$pFirstName = com_db_output($paRow['first_name']);
					$pLastName = com_db_output($paRow['last_name']);	
					$personalURL = trim($pFirstName).'_'.trim($pLastName).'_Exec_'.$person_id;
					$awards_date = $paRow['awards_date'];
					$adt = explode('-',$awards_date);
					$personal_image = $paRow['personal_image'];
					if($personal_image !=''){
					  $personal_image_path = HTTP_SITE_URL.'personal_photo/small/'.$personal_image;
					}else{
					  $personal_image_path = HTTP_SITE_URL.'personal_photo/small/no_image_information.png';
					}
					$awards = ' received a "'.com_db_output($paRow['awards_title']).'" award from '.com_db_output($paRow['awards_given_by']);
					
					if($paRow['awards_link'] !=''){
						$message .='<div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
									<table width="100%" border="0" cellspacing="0" cellpadding="20">
									<tr>
										<td>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTP_SITE_URL.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>
													<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">
														'.$pFirstName.' '.$pLastName.' '.$awards.'
														<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>

														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td align="left">
																	<table border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTP_SITE_URL.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>
																			<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SITE_URL.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
																			<td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>
																			<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.$paRow['awards_link'].'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Source</span></a></td>
																			<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SITE_URL.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
													<td align="right" width="170" class="btn-container">
														<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">
															<tr>
																<td>
																	<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">
																		<tr>
																			<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div>
																			</div><div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="0" alt="" /></div>
																			</td>
																			<td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$paRow['email'].'?subject=Congrats&amp;body=Congrats on your recent award" target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>';
						
					}else{
						$message .='<div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
									<table width="100%" border="0" cellspacing="0" cellpadding="20">
									<tr>
										<td>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTP_SITE_URL.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>
													<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">
														'.$pFirstName.' '.$pLastName.' '.$awards.'
														<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>

														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td align="left">
																	<table border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTP_SITE_URL.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>
																			<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SITE_URL.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
																			<td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>
																			<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"></td>
																			<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"></td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
													<td align="right" width="170" class="btn-container">
														<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">
															<tr>
																<td>
																	<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">
																		<tr>
																			<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div>
																			</div><div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="0" alt="" /></div>
																			</td>
																			<td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$paRow['email'].'?subject=Congrats&amp;body=Congrats on your recent award" target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>';
					}
					
				$ind++;	
				}
				
			$message .=' </td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
							<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
							<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
							<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
							<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
							<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
						</tr>
						</table>
						<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SITE_URL.'images/box_bottom.jpg" alt="" border="0" width="660" height="5" /></div></div>
						
						<div style="font-size:0pt; line-height:0pt; height:20px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="20" style="height:20px" alt="" /></div>';	
			
			}
		}
	}
	//for personal publication
	if($publication_id_list !=''){
		$ppQuery = "select pp.*,pm.first_name,pm.last_name,pm.email,pm.personal_image from ".TABLE_PERSONAL_PUBLICATION." pp, ".TABLE_PERSONAL_MASTER." pm where pp.personal_id=pm.personal_id and pp.publication_id in (".$publication_id_list.") order by pp.add_date desc";	
		$ppResult = com_db_query($ppQuery);	
		if($ppResult){
		$ppNumRow = com_db_num_rows($ppResult);	
		if($ppNumRow>0){
			$message .='<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SITE_URL.'images/box_top.jpg" alt="" border="0" width="660" height="5" /></div></div>
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="w320">
							<tr>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
								<td>
									<table width="100%" border="0" cellspacing="0" cellpadding="1" bgcolor="#c7c7c7">
										<tr>
											<td>
												<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
													<tr>
														<td>
															
															<div style="font-size:0pt; line-height:0pt; height:1px; background:#4785ca; "><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
						
															<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#5f9bde">
																<tr>
																	<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="20"><div style="font-size:0pt; line-height:0pt; height:50px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="50" style="height:50px" alt="" /></div>
																	<div style="font-size:0pt; line-height:0pt; height:4px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="4" style="height:4px" alt="" /></div>
																	</td>
																	<td class="h2" style="color:#ffffff; font-family:Arial; font-size:18px; line-height:22px; text-align:left; font-weight:bold">Publications</td>
																</tr>
															</table>';
	  
			
			$pub=1;												
			while($ppRow = com_db_fetch_array($ppResult)){
				$person_id = $ppRow['personal_id'];
				$pFirstName = com_db_output($ppRow['first_name']);
				$pLastName = com_db_output($ppRow['last_name']);	
				$personalURL = trim($pFirstName).'_'.trim($pLastName).'_Exec_'.$person_id;
				
				$publication = ' wrote "'.com_db_output($ppRow['title']).'"';
				$personal_image = $ppRow['personal_image'];
				if($personal_image !=''){
				  $personal_image_path = HTTP_SITE_URL.'personal_photo/small/'.$personal_image;
				}else{
				  $personal_image_path = HTTP_SITE_URL.'personal_photo/small/no_image_information.png';
				}
				if($ppRow['link'] !=''){
					$message .=' <div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
								<table width="100%" border="0" cellspacing="0" cellpadding="20">
									<tr>
										<td>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTP_SITE_URL.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>
													<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">
														'.$pFirstName.' '.$pLastName.' '.$publication.'
														<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>

														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td align="left">
																	<table border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTP_SITE_URL.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>
																			<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SITE_URL.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
																			<td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>
																			<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.$ppRow['link'].'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Source</span></a></td>
																			<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SITE_URL.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
													<td align="right" width="170" class="btn-container">
														<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">
															<tr>
																<td>
																	<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">
																		<tr>
																			<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div>
																			</div><div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="0" alt="" /></div>
																			</td>
																			<td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$ppRow['email'].'?subject=I saw you recent publication and decided to reach out" target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>';
				}else{
					$message .=' <div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
								 <table width="100%" border="0" cellspacing="0" cellpadding="20">
									<tr>
										<td>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTP_SITE_URL.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>
													<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">
														'.$pFirstName.' '.$pLastName.' '.$publication.'
														<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>

														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td align="left">
																	<table border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTP_SITE_URL.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>
																			<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SITE_URL.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
																			<td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>
																			<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"></td>
																			<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"></td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
													<td align="right" width="170" class="btn-container">
														<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">
															<tr>
																<td>
																	<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">
																		<tr>
																			<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div>
																			</div><div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="0" alt="" /></div>
																			</td>
																			<td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$ppRow['email'].'?subject=I saw you recent publication and decided to reach out" target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>';
				}
			$pub++;	
			}
		$message .=' 	</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
						<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
						<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
						<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
						<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
						<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
					</tr>
				</table>
				<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SITE_URL.'images/box_bottom.jpg" alt="" border="0" width="660" height="5" /></div></div>
				
				<div style="font-size:0pt; line-height:0pt; height:20px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="20" style="height:20px" alt="" /></div>';
		}
	 }
	}
	//for personal Board Appointments
	if($board_id_list !=''){
		$pbQuery = "select pb.*,pm.first_name,pm.last_name,pm.email,pm.personal_image from ".TABLE_PERSONAL_BOARD." pb, ".TABLE_PERSONAL_MASTER." pm where pb.personal_id=pm.personal_id and pb.board_id in (".$board_id_list.") order by pb.add_date desc";	
		$pbResult = com_db_query($pbQuery);	
		if($pbResult){
		$pbNumRow = com_db_num_rows($pbResult);	
		if($pbNumRow>0){
			$message .='<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SITE_URL.'images/box_top.jpg" alt="" border="0" width="660" height="5" /></div></div>
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="w320">
							<tr>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
								<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
								<td>
									<table width="100%" border="0" cellspacing="0" cellpadding="1" bgcolor="#c7c7c7">
										<tr>
											<td>
												<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
													<tr>
														<td>
															<div style="font-size:0pt; line-height:0pt; height:1px; background:#4785ca; "><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
															<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#5f9bde">
																<tr>
																	<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="20"><div style="font-size:0pt; line-height:0pt; height:50px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="50" style="height:50px" alt="" /></div>
																	<div style="font-size:0pt; line-height:0pt; height:4px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="4" style="height:4px" alt="" /></div>
																	</td>
																	<td class="h2" style="color:#ffffff; font-family:Arial; font-size:18px; line-height:22px; text-align:left; font-weight:bold">Board Appointments</td>
																</tr>
															</table>';
			
			$app=1;																				
			while($pbRow = com_db_fetch_array($pbResult)){
				$person_id = $pbRow['personal_id'];
				$pFirstName = com_db_output($pbRow['first_name']);
				$pLastName = com_db_output($pbRow['last_name']);	
				$personalURL = trim($pFirstName).'_'.trim($pLastName).'_Exec_'.$person_id;
				
				$boards = ' was appointed as a member of "'.com_db_output($pbRow['board_info']).'"';
				$personal_image = $pbRow['personal_image'];
				if($personal_image !=''){
				  $personal_image_path = HTTP_SITE_URL.'personal_photo/small/'.$personal_image;
				}else{
				  $personal_image_path = HTTP_SITE_URL.'personal_photo/small/no_image_information.png';
				}
				if($pbRow['board_link'] !=''){
					$message .='<div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
								<table width="100%" border="0" cellspacing="0" cellpadding="20">
									<tr>
										<td>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTP_SITE_URL.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>
													<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">
														'.$pFirstName.' '.$pLastName.' '.$boards.'
														<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>

														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td align="left">
																	<table border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTP_SITE_URL.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>
																			<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SITE_URL.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
																			<td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>
																			<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.$pbRow['board_link'].'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Source</span></a></td>
																			<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SITE_URL.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
													<td align="right" width="170" class="btn-container">
														<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">
															<tr>
																<td>
																	<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">
																		<tr>
																			<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div>
																			</div><div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="0" alt="" /></div>
																			</td>
																			<td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$pbRow['email'].'?subject=Congrats&amp;body=Congrats on your recent Board appointment" target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>';
				}else{
					$message .='<div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
								<table width="100%" border="0" cellspacing="0" cellpadding="20">
									<tr>
										<td>
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTP_SITE_URL.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>
													<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">
														'.$pFirstName.' '.$pLastName.' '.$boards.'
														<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>

														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td align="left">
																	<table border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTP_SITE_URL.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>
																			<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SITE_URL.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
																			<td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>
																			<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"></td>
																			<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"></td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
													<td align="right" width="170" class="btn-container">
														<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">
															<tr>
																<td>
																	<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">
																		<tr>
																			<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div>
																			</div><div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="0" alt="" /></div>
																			</td>
																			<td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$pbRow['email'].'?subject=Congrats on your recent Board appointment" target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>
																		</tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>';
				}
			$app++;	
			}
		$message .=' 								</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
							<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
							<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
							<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
							<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
							<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
						</tr>
					</table>
					<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SITE_URL.'images/box_bottom.jpg" alt="" border="0" width="660" height="5" /></div></div>
					
					<div style="font-size:0pt; line-height:0pt; height:20px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="20" style="height:20px" alt="" /></div>';	
		}
		
	 }	
	}
	  $message = $messageHead.$person_image_name.$message.$messageFooter;
	  $demoEmail = com_db_input($message);
	  $emailDetails = com_db_input($message);
	  $email_id = $email_alert_id;
	  $add_date = date("Y-m-d");
	  $all_person_id = implode(",", $person_id_info);
	  $demoEmailQuery = "INSERT INTO " . TABLE_DEMO_EMAIL_INFO . "(all_move_id, all_person_id, sent_email, email_details,email_id,triggers_name,add_date) values('".$all_move_id."','". $all_person_id."','$demoEmail','$emailDetails','$email_id','$triggers_name','".$add_date."')";	
	  com_db_query($demoEmailQuery);
	  com_redirect("demo-email.php?selected_menu=demoemail&msg=" . msg_encode("Demo Email Successfully created"));

}
	
include("includes/header.php");
?>

<script type="text/javascript">

function CheckAll(numRows){
	var st = parseInt(<?=($starting_point+1)?>);
	var end = parseInt(<?=($starting_point+$items_per_page)?>);
	if(document.getElementById('all').checked){
		for(i=st; i<=end; i++){
			var person_id='person_id-'+ i;
			document.getElementById(person_id).checked=true;
		}
	} else {
		for(i=st; i<=end; i++){
			var person_id='person_id-'+ i;
			document.getElementById(person_id).checked=false;
		}
	}
}

function AllRecored(numRows){

	var flg=0;
	for(i=1; i<=numRows; i++){
			var person_id='person_id-'+ i;
			if(document.getElementById(person_id).checked){
				flg=1;
			}	
		}
	if(flg==0){
		alert("Please checked atlist one checkbox for delete.");
		document.getElementById('person_id-1').focus();
		return false;
	} else {
		var agree=confirm("Selected person will be demo email. \n Do you want to continue?");
		if (agree)
			 document.topicform.submit();
		else
			window.location = "demo-email.php?selected_menu=demoemail";
	}	

}

function confirm_del(nid,p){
	var agree=confirm("Person will be deleted from Demo email. \n Do you want to continue?");
	if (agree){
		window.location = "demo-email.php?selected_menu=demoemail&pID=" + nid + "&p=" + p + "&action=delete";
	}else{
		window.location = "demo-email.php?selected_menu=demoemail&pID=" + nid + "&p=" + p ;
	}
}
</script>

 <tr>
    <td align="left" valign="top" bgcolor="#FFFFFF">
	<table width="975" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
		<?php
		include("includes/menu_left.php");
		?>
		<td width="10" align="left" valign="top">&nbsp;</td>
        <td width="769" align="left" valign="top">

<?php if(($action == '') || $action == 'save'){	?>			

		<form name="topicform" action="demo-email.php?action=DemoEmailCreate&selected_menu=demoemail" method="post">
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
          <tr>
            <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="31%" align="left" valign="middle" class="heading-text">Demo Email Manager</td>
                  <td width="50%" align="left" valign="middle" class="message"><?=$msg?></td>
                  <td width="19%" align="left" valign="middle"><input type="button" value="Generate Demo Email" onclick="AllRecored('<?=$numRows?>');" ></td>
                </tr>
              </table></td>
          </tr>
       
          <tr>
            <td align="left" valign="top" class="right-bar-content-border">
			<table width="100%" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="22" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-title-text">#</span></td>
				<td width="20" height="30" align="center" valign="middle" class="right-border">
				<input type="checkbox" name="all" id="all" onclick="CheckAll('<?=$numRows?>');" /></td>
				<td width="127" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Person Name</span> </td>
                <td width="127" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Engagement Triggers</span> </td>
                <td width="67" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Add Date</span> </td>
                <td width="67" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Action</span> </td>
			  </tr>
			<?php
			
			if($total_data>0) {
				$i=$starting_point+1;
				$select_trigger='';
				while ($data_sql = com_db_fetch_array($exe_data)) {
				$add_date = $data_sql['add_date'];
			?>          
			  <tr>
				<td height="30" align="center" valign="middle" class="right-border-left"><?=$i;?></td>
				<td height="30" align="center" valign="middle" class="right-border"><input type="checkbox" id="person_id-<?=$i;?>" name="nid[]" value="<?=$data_sql['personal_id'];?>" /></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><?=com_db_output($data_sql['first_name'].' '.$data_sql['last_name'])?></td>
                <td height="30" align="left" valign="middle" class="right-border-text"><?=com_db_output($data_sql['person_tigger_name'])?></td>
				<td height="30" align="center" valign="middle" class="right-border"><?=$add_date;?></td>
                <td height="30" align="center" valign="middle" class="right-border"><a href="#"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" title="Delete" border="0" onclick="confirm_del('<?=$data_sql['personal_id'];?>','<?=$p;?>')" /></a><br />
						  Delete</td>
         	</tr> 
			<?php
			$i++;
				}
			}
			?>     
         </table> 
		</td>
          </tr>
        </table>
        </form>
		</td>
      </tr>
    </table></td>
  </tr>
 <tr>
    <td align="center" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
     
      <tr>
        <td width="666" align="right" valign="top"><table width="200" border="0" align="right" cellpadding="0" cellspacing="0">
          <tr>
		<?=number_pages($main_page, $p, $total_data, 8, $items_per_page,"&selected_menu=demoemail");?>		  
          </tr>
        </table></td>
        <td width="314" align="center" valign="bottom">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  
<?php }
include("includes/footer.php");
?>