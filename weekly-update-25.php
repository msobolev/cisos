<?php
require('includes/include-top.php');

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

$startWeekDate = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-7,date("Y")));	
echo $app_query = "select mm.move_id,mm.personal_id,mm.effective_date,mm.movement_type,mm.title,mm.more_link,pm.first_name,pm.last_name,pm.email,pm.personal_image,cm.company_name from ".TABLE_MOVEMENT_MASTER." mm, ".TABLE_PERSONAL_MASTER." pm, ".TABLE_COMPANY_MASTER." cm where (mm.company_id=cm.company_id and mm.personal_id=pm.personal_id) and pm.personal_image<>'' and (pm.email<>'' and pm.email<>'n/a' and pm.email<>'N/A') and mm.add_date>='".$startWeekDate."'";	
$app_query .= " LIMIT 0,32";

$perResult = com_db_query($app_query);
$perNumRows = com_db_num_rows($perResult);
$totPerson = $perNumRows;

if($perNumRows > 0){
		
		  $person_info = array();
		  $person_id_info = array();
		  $p=0;	
		  
		  $totMoveID='';	
		  $totPersonID='';
		  while($perRow = com_db_fetch_array($perResult)){
			  if($totPersonID==''){
				$totMoveID = $perRow['move_id'];
				$totPersonID = $perRow['personal_id'];
			  }else{
				$totMoveID .= ','.$perRow['move_id'];
				$totPersonID .= ','.$perRow['personal_id'];
			  }	
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
			
			$table5 = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>';
			for($q=16;$q<20;$q++){
				if($person_info[$q]['pname'] !=''){
					$table5 .='<td valign="top">
									<div class="img" style="font-size:0pt; line-height:0pt; text-align:left">
										<a href="'.HTTP_SITE_URL.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTP_SITE_URL.'personal_photo/small/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" height="80" /></a>
									</div>
									<div class="thumb-name" style="color:#ffffff; font-family:Arial; font-size:11px; line-height:17px; text-align:center; background-color:#333333">'.$person_info[$q]['pname'].'</div>
									<div style="font-size:0pt; line-height:0pt; height:1px; background:#ffffff; "><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
								</td>
								<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"></td>';
				}else{
					$table5 .='<td valign="top">
									<div class="img" style="font-size:0pt; line-height:0pt; text-align:left;width:80px;">
										&nbsp;
									</div>
									<div class="thumb-name" style="color:#ffffff; font-family:Arial; font-size:11px; line-height:17px; text-align:center;>&nbsp;</div>
									<div style="font-size:0pt; line-height:0pt; height:1px; ">&nbsp;</div>
								</td>
								<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"></td>';
				}
			}
			$table5 .= '</tr>
					 </table>';	
			
			$table6 = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>';
			for($q=20;$q<24;$q++){
				if($person_info[$q]['pname'] !=''){
					$table6 .='<td valign="top">
									<div class="img" style="font-size:0pt; line-height:0pt; text-align:left">
										<a href="'.HTTP_SITE_URL.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTP_SITE_URL.'personal_photo/small/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" height="80" /></a>
									</div>
									<div class="thumb-name" style="color:#ffffff; font-family:Arial; font-size:11px; line-height:17px; text-align:center; background-color:#333333">'.$person_info[$q]['pname'].'</div>
									<div style="font-size:0pt; line-height:0pt; height:1px; background:#ffffff; "><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
								</td>
								<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"></td>';
				}else{
					$table6 .='<td valign="top">
									<div class="img" style="font-size:0pt; line-height:0pt; text-align:left;width:80px;">
										&nbsp;
									</div>
									<div class="thumb-name" style="color:#ffffff; font-family:Arial; font-size:11px; line-height:17px; text-align:center;>&nbsp;</div>
									<div style="font-size:0pt; line-height:0pt; height:1px; ">&nbsp;</div>
								</td>
								<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"></td>';
				}
			}
			$table6 .= '</tr>
					 </table>';
			$table7 = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>';
			for($q=24;$q<28;$q++){
				if($person_info[$q]['pname'] !=''){
					$table7 .='<td valign="top">
									<div class="img" style="font-size:0pt; line-height:0pt; text-align:left">
										<a href="'.HTTP_SITE_URL.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTP_SITE_URL.'personal_photo/small/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" height="80" /></a>
									</div>
									<div class="thumb-name" style="color:#ffffff; font-family:Arial; font-size:11px; line-height:17px; text-align:center; background-color:#333333">'.$person_info[$q]['pname'].'</div>
									<div style="font-size:0pt; line-height:0pt; height:1px; background:#ffffff; "><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
								</td>
								<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"></td>';
				}else{
					$table7 .='<td valign="top">
									<div class="img" style="font-size:0pt; line-height:0pt; text-align:left;width:80px;">
										&nbsp;
									</div>
									<div class="thumb-name" style="color:#ffffff; font-family:Arial; font-size:11px; line-height:17px; text-align:center;>&nbsp;</div>
									<div style="font-size:0pt; line-height:0pt; height:1px; ">&nbsp;</div>
								</td>
								<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"></td>';
				}
			}
			$table7 .= '</tr>
					 </table>';	
			
			$table8 = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>';
			for($q=28;$q<32;$q++){
				if($person_info[$q]['pname'] !=''){
					$table8 .='<td valign="top">
									<div class="img" style="font-size:0pt; line-height:0pt; text-align:left">
										<a href="'.HTTP_SITE_URL.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTP_SITE_URL.'personal_photo/small/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" height="80" /></a>
									</div>
									<div class="thumb-name" style="color:#ffffff; font-family:Arial; font-size:11px; line-height:17px; text-align:center; background-color:#333333">'.$person_info[$q]['pname'].'</div>
									<div style="font-size:0pt; line-height:0pt; height:1px; background:#ffffff; "><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
								</td>
								<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"></td>';
				}else{
					$table8 .='<td valign="top">
									<div class="img" style="font-size:0pt; line-height:0pt; text-align:left;width:80px;">
										&nbsp;
									</div>
									<div class="thumb-name" style="color:#ffffff; font-family:Arial; font-size:11px; line-height:17px; text-align:center;>&nbsp;</div>
									<div style="font-size:0pt; line-height:0pt; height:1px; ">&nbsp;</div>
								</td>
								<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"></td>';
				}
			}
			$table8 .= '</tr>
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
			}elseif($totPerson>8 && $totPerson<=16){
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
			}elseif($totPerson>8 && $totPerson<=24){
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
									<tr>
										<td valign="top" class="column">
											'.$table5.'
										</td>
										<td valign="top" class="column">
											'.$table6.'
										</td>
									</tr>
								</table>';
			}elseif($totPerson>24){
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
									<tr>
										<td valign="top" class="column">
											'.$table5.'
										</td>
										<td valign="top" class="column">
											'.$table6.'
										</td>
									</tr>
									<tr>
										<td valign="top" class="column">
											'.$table7.'
										</td>
										<td valign="top" class="column">
											'.$table8.'
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
	 
	 	//
		//for Appointments
		if($totPersonID !=''){
		  $person_query = "select mm.personal_id,mm.effective_date,mm.movement_type,mm.title,mm.more_link,pm.first_name,pm.last_name,pm.email,pm.personal_image,cm.company_name from ".TABLE_MOVEMENT_MASTER." mm, ".TABLE_PERSONAL_MASTER." pm, ".TABLE_COMPANY_MASTER." cm where (mm.company_id=cm.company_id and mm.personal_id=pm.personal_id) and pm.personal_image<>'' and (pm.email<>'' and pm.email<>'n/a' and pm.email<>'N/A') and mm.personal_id in (".$totPersonID.") limit 0,10";
		  $person_result = com_db_query($person_query);
		  if($person_result){
				$numRows = com_db_num_rows($person_result);
		  }
		  $cnt=1;
		  $messageSrt='';
		  $messageEmail='';	
		  //$effective_date_within_60day = date("Y-m-d",mktime(0,0,0,date("m"),(date("d")-60),date("Y"))); 
		  while($pRow = com_db_fetch_array($person_result)){
			  	
				  $person_id = $pRow['personal_id'];
				  $pFirstName = trim(com_db_output($pRow['first_name']));
				  $pLastName = trim(com_db_output($pRow['last_name']));	
				  $personalURL = trim($pFirstName).'_'.trim($pLastName).'_Exec_'.$person_id;
				  
				  //if($pRow['effective_date'] > $effective_date_within_60day){
					  if($pRow['movement_type']==1){
						 $movement = ' was Appointed as ';
					  }elseif($pRow['movement_type']==2){
						  $movement = ' was Promoted to ';
					  }elseif($pRow['movement_type']==3){
						  $movement = ' Retired as ';
					  }elseif($pRow['movement_type']==4){
						  $movement = ' Resigned as '; 
					  }elseif($pRow['movement_type']==5){
						  $movement = ' was Terminated as ';
					  }elseif($pRow['movement_type']==6){
						  $movement = ' was Appointed to ';
					  }elseif($pRow['movement_type']==7){
						  $movement = ' Job Opening ';
					  }
					  
					  $heading = com_db_output($pRow['first_name'].' '.$pRow['last_name'].$movement.$pRow['title'].' at '.$pRow['company_name']);
					  $personal_image = $pRow['personal_image'];
					  if($personal_image !=''){
						  $personal_image_path = HTTP_SITE_URL.'personal_photo/small/'.$personal_image;
					  }else{
						  $personal_image_path = HTTP_SITE_URL.'personal_photo/small/no_image_information.png';
					  }
					  					  
					  if($pRow['more_link'] ==''){
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
				  //}
						
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
				
				//for personal speaking
				if($totPersonID !=''){
					$psQuery = "select ps.*,pm.first_name,pm.last_name,pm.email,pm.personal_image from ".TABLE_PERSONAL_SPEAKING." ps, ".TABLE_PERSONAL_MASTER." pm where ps.personal_id=pm.personal_id and ps.event_date >'".date("Y-m-d")."' and ps.personal_id in (".$totPersonID.") order by ps.add_date desc limit 0,10";	
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
				
				//for personal Media mention
				if($totPersonID !=''){
					$pmmQuery = "select pmm.*,pm.first_name,pm.last_name,pm.email,pm.personal_image from ".TABLE_PERSONAL_MEDIA_MENTION." pmm, ".TABLE_PERSONAL_MASTER." pm where pmm.personal_id=pm.personal_id and pmm.personal_id in (".$totPersonID.") order by pmm.add_date desc limit 0,10";	
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
				if($totPersonID !=''){		
					$paQuery = "select pa.*,pm.first_name,pm.last_name,pm.email,pm.personal_image from ".TABLE_PERSONAL_AWARDS." pa, ".TABLE_PERSONAL_MASTER." pm where pa.personal_id=pm.personal_id and pa.personal_id in (".$totPersonID.") order by pa.add_date desc limit 0,10";	
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
				if($totPersonID !=''){
		$ppQuery = "select pp.*,pm.first_name,pm.last_name,pm.email,pm.personal_image from ".TABLE_PERSONAL_PUBLICATION." pp, ".TABLE_PERSONAL_MASTER." pm where pp.personal_id=pm.personal_id and pp.personal_id in (".$totPersonID.") order by pp.add_date desc limit 0,10";	
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
				if($totPersonID !=''){
		$pbQuery = "select pb.*,pm.first_name,pm.last_name,pm.email,pm.personal_image from ".TABLE_PERSONAL_BOARD." pb, ".TABLE_PERSONAL_MASTER." pm where pb.personal_id=pm.personal_id and pb.personal_id in (".$totPersonID.") order by pb.add_date desc";	
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
				
	    }
		
		$messageHead = '<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#eaeaea">
								<tr>
								  <td align="center" valign="top">
									<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" class="w320">
										<tr>
											<td align="center">
												<table width="650" border="0" cellspacing="0" cellpadding="0" class="w320">
													<tr>
														<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div style="font-size:0pt; line-height:0pt; height:45px"><img src="'.HTTP_SITE_URL.'images/empty.gif" width="1" height="45" style="height:45px" alt="" /></div></td>
														<td class="column2"><div class="top" style="color:#7a7a7a; font-family:Arial; font-size:11px; line-height:18px; text-align:left">Having trouble viewing this email? <a href="'.HTTP_SITE_URL.'weekly/weekly-update-'.date("Y-m-d").'" target="_blank" class="link-top" style="color:#5c97d8; text-decoration:underline"><span class="link-top" style="color:#5c97d8; text-decoration:underline">View it in your browser</span></a></div></td>
														<td align="right" class="column2">
															<table border="0" cellspacing="0" cellpadding="0">
																<tr>
																	<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="8"><img src="'.HTTP_SITE_URL.'images/bullet1.jpg" alt="" border="0" width="2" height="3" /></td>
																	<td class="top" style="color:#7a7a7a; font-family:Arial; font-size:11px; line-height:18px; text-align:left"><a href="'.HTTP_SITE_URL.'weekly-update-'.date("Y-m-d").'" target="_blank" class="link-top" style="color:#5c97d8; text-decoration:underline"><span class="link-top" style="color:#5c97d8; text-decoration:underline">Online version</span></a></td>
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
														<td width="42%" class="img" style="font-size:0pt; line-height:0pt; text-align:left"><a href="'.HTTP_SITE_URL.'index.php" target="_blank"><img src="'.HTTP_SITE_URL.'images/email-alert-logo.jpg" width="267" height="25" alt="" border="0" /></a></td>
														<td text-align:left" class="h2" style="color:#365f91; font-family:Arial; font-size:22px; padding-top:10px; line-height:22px; text-align:left; font-weight:bold">: Weekly Update</td>
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
							
		$message = $messageHead.$person_image_name.$message.$messageFooter;
		$weely_update_details = com_db_input($message);
		
		$add_date = date("Y-m-d");
		$weekly_update_id = 'weekly-update-'.$add_date;
		$weeklyUpdateQuery = "INSERT INTO " . TABLE_WEEKLY_UPDATE_DETAILS . "(all_move_id, all_person_id, weely_update_details, weekly_update_id,add_date) values('$totMoveID','$totPersonID','$weely_update_details','$weekly_update_id','$add_date')";	
		com_db_query($weeklyUpdateQuery);
	  }
	echo 'Weekly Update Complited';							
?>