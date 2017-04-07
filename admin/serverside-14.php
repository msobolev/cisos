<?php
require('includes/include_top.php');

$action = $_GET['action'];
switch($action){
	case 'LoginTodayUser':
			$login_user_today = $_GET['loginToday'];
			if($login_user_today>0){
				$userQuery = "select user_id, first_name, last_name, email,password from ".TABLE_USER. " where status=0 and user_id in (select distinct(user_id) from " . TABLE_LOGIN_HISTORY." where add_date ='".date("Y-m-d")."')";									
				$userResult = com_db_query($userQuery);
				if($userResult){
					$userNumRows = com_db_num_rows($userResult);
				}
				$name = array();
				$email =  array();
				$password =  array();
				while($uRow = com_db_fetch_array($userResult)){
					array_push($name,com_db_output($uRow['first_name'].' '.$uRow['last_name']));
					array_push($email,com_db_output($uRow['email']));
					array_push($password,com_db_output($uRow['password']));
				}
				$all_data = array(
								  "name" => $name,
								  "email" => $email,
								  "password" => $password
								  );
				print json_encode($all_data);
			}else{
				print json_encode(array("error"=>"User not Available"));
			}
		break;	

	case 'LoginLastweekUser':
			$login_user_lastweek = $_GET['loginLastweek'];
			if($login_user_lastweek>0){
				$userQuery = "select user_id, first_name, last_name, email,password from ".TABLE_USER. " where status=0 and user_id in (select distinct(user_id) from " . TABLE_LOGIN_HISTORY." where add_date <='".date("Y-m-d")."' and add_date>='".date("Y-m-d",mktime(0,0,0,date("m"),date("d")-6,date("Y")))."')";									
				$userResult = com_db_query($userQuery);
				if($userResult){
					$userNumRows = com_db_num_rows($userResult);
				}
				$name = array();
				$email =  array();
				$password =  array();
				while($uRow = com_db_fetch_array($userResult)){
					array_push($name,com_db_output($uRow['first_name'].' '.$uRow['last_name']));
					array_push($email,com_db_output($uRow['email']));
					array_push($password,com_db_output($uRow['password']));
				}
				$all_data = array(
								  "name" => $name,
								  "email" => $email,
								  "password" => $password
								  );
				print json_encode($all_data);
			} else{
				print json_encode(array("error"=>"User not Available"));
			}
		break;
		
	case 'LoginLastmonthUser':
			$login_user_lastmonth = $_GET['loginLastmonth'];
			if($login_user_lastmonth>0){
				$userQuery = "select user_id, first_name, last_name, email,password from ".TABLE_USER. " where status=0 and user_id in (select distinct(user_id) from " . TABLE_LOGIN_HISTORY." where add_date <='".date("Y-m-d")."' and add_date>='".date("Y-m-d",mktime(0,0,0,date("m"),date("d")-30,date("Y")))."')";									
				$userResult = com_db_query($userQuery);
				if($userResult){
					$userNumRows = com_db_num_rows($userResult);
				}
				$name = array();
				$email =  array();
				$password =  array();
				while($uRow = com_db_fetch_array($userResult)){
					array_push($name,com_db_output($uRow['first_name'].' '.$uRow['last_name']));
					array_push($email,com_db_output($uRow['email']));
					array_push($password,com_db_output($uRow['password']));
				}
				$all_data = array(
								  "name" => $name,
								  "email" => $email,
								  "password" => $password
								  );
				print json_encode($all_data);
			} else{
				print json_encode(array("error"=>"User not Available"));
			}
		break;	
		
	case 'SearchToday':
			$search_user_today = $_GET['search_user_today'];
			if($search_user_today>0){
				$userQuery = "select u.first_name as fisrtname, u.last_name as lastname,sh.* from ".TABLE_USER. " as u," .TABLE_SEARCH_HISTORY. " as sh where u.user_id=sh.user_id and u.status=0 and sh.add_date ='".date("Y-m-d")."' group by sh.user_id";
				$userResult = com_db_query($userQuery);
				if($userResult){
					$user_num_rows = com_db_num_rows($userResult);
				}
				if($user_num_rows>0){
					$name = array();
					$searchinfo =  array();
					while($uRow = com_db_fetch_array($userResult)){
						array_push($name,com_db_output($uRow['fisrtname'].' '.$uRow['lastname']));
						
						$searchQuery = "select * from ".TABLE_SEARCH_HISTORY. " where add_date ='".date("Y-m-d")."' and user_id='".$uRow['user_id']."' order by search_id";
						$searchResult = com_db_query($searchQuery);
						$scnt = 1;
						$searchString='';
						while($sRow = com_db_fetch_array($searchResult)){
							$searchString .=' Search '.$scnt. ': ';
							$searchStr='';
							
							if($sRow['first_name'] !=''){
								if($searchStr==''){	$searchStr = 'First Name: ' .$sRow['first_name'];}else{$searchStr .= 'Fisrt Name: ' .$sRow['first_name'];}
							}
							if($sRow['last_name'] !=''){
								if($searchStr==''){	$searchStr = 'Last Name: ' .$sRow['last_name'];}else{$searchStr .= ', Last Name: ' .$sRow['last_name'];}
							}
							if($sRow['title'] !=''){
								if($searchStr==''){	$searchStr = 'Title: ' .$sRow['title'];}else{$searchStr .= ', Title: ' .$sRow['title'];}
							}
							if($sRow['management'] !=''){
								$mResult = com_db_query("select name from ".TABLE_MANAGEMENT_CHANGE." where id in(".$sRow['management'].")");
								$mStr='';
								while($mRow = com_db_fetch_array($mResult)){
									if($mStr==''){
										$mStr = $mRow['name'];
									}else{
										$mStr .= ', '.$mRow['name'];
									}
								}
								if($searchStr==''){	$searchStr = 'Management Type: ' .$mStr;}else{$searchStr .= ', Management Type: ' .$mStr;}
							}
							if($sRow['country'] !=''){
								$cResult = com_db_query("select countries_name from ".TABLE_COUNTRIES." where countries_id in(".$sRow['country'].")");
								$cStr='';
								while($cRow = com_db_fetch_array($cResult)){
									if($cStr==''){
										$cStr = $cRow['countries_name'];
									}else{
										$cStr .= ', '.$cRow['countries_name'];
									}
								}
								if($searchStr==''){	$searchStr = 'Countries: ' .$cStr;}else{$searchStr .= ', Countries: ' .$cStr;}
							}
							if($sRow['state'] !=''){
								$sResult = com_db_query("select state_name from ".TABLE_STATE." where state_id in(".$sRow['state'].")");
								$sStr='';
								while($stRow = com_db_fetch_array($sResult)){
									if($sStr==''){
										$sStr = $stRow['state_name'];
									}else{
										$sStr .= ', '.$stRow['state_name'];
									}
								}
								if($searchStr==''){	$searchStr = 'State: ' .$sStr;}else{$searchStr .= ', State: ' .$sStr;}
							}
							
							if($sRow['city'] !=''){
								if($searchStr==''){	$searchStr = 'City: ' .$sRow['city'];}else{$searchStr .= ', City: ' .$sRow['city'];}
							}
							if($sRow['zip_code'] !=''){
								if($searchStr==''){	$searchStr = 'Zip Code: ' .$sRow['zip_code'];}else{$searchStr .= ', Zip Code: ' .$sRow['zip_code'];}
							}
							if($sRow['company'] !=''){
								if($searchStr==''){	$searchStr = 'Company: ' .$sRow['company'];}else{$searchStr .= ', Company: ' .$sRow['company'];}
							}
							if($sRow['industry'] !=''){
								$iResult = com_db_query("select title from ".TABLE_INDUSTRY." where industry_id in(".$sRow['industry'].")");
								$iStr='';
								while($iRow = com_db_fetch_array($iResult)){
									if($iStr==''){
										$iStr = $iRow['title'];
									}else{
										$iStr .= ', '.$iRow['title'];
									}
								}
								if($searchStr==''){	$searchStr = 'Industry: ' .$iStr;}else{$searchStr .= ', Industry: ' .$iStr;}
							}
							if($sRow['revenue_size'] !=''){
								$rResult = com_db_query("select name from ".TABLE_REVENUE_SIZE." where id in(".$sRow['revenue_size'].")");
								$rStr='';
								while($rRow = com_db_fetch_array($rResult)){
									if($rStr==''){
										$rStr = $rRow['name'];
									}else{
										$rStr .= ', '.$rRow['name'];
									}
								}
								if($searchStr==''){	$searchStr = 'Revenue Size: ' .$rStr;}else{$searchStr .= ', Revenue Size: ' .$rStr;}
							}
							if($sRow['employee_size'] !=''){
								$eResult = com_db_query("select name from ".TABLE_EMPLOYEE_SIZE." where id in(".$sRow['employee_size'].")");
								$eStr='';
								while($eRow = com_db_fetch_array($eResult)){
									if($eStr==''){
										$eStr = $eRow['name'];
									}else{
										$eStr .= ', '.$eRow['name'];
									}
								}
								if($searchStr==''){	$searchStr = 'Employee Size: ' .$eStr;}else{$searchStr .= ', Employee Size: ' .$eStr;}
							}
							if($sRow['time_period'] !=''){
								if($sRow['time_period']=='Enter Date Range...'){
									if($searchStr==''){	$searchStr = 'Date: From ' .$sRow['from_date'].' To '.$sRow['to_date'];}else{$searchStr .= ', Date: From ' .$sRow['from_date'].' To '.$sRow['to_date'];}
								}else{
									if($searchStr==''){	$searchStr = 'Date: From ' .$sRow['from_date'].' To '.$sRow['to_date'];}else{$searchStr .= ', Date: From ' .$sRow['from_date'].' To '.$sRow['to_date'];}
								}
							}
							
							if($searchStr==''){
								$searchString .= 'All' ."<br>";
							}else{
								$searchString .= $searchStr ."<br>";
							}
							$scnt++;
						}
						array_push($searchinfo,com_db_output($searchString));
						$searchString='';
					}
					$all_data = array(
									  "name" => $name,
									  "searchinfo" => $searchinfo
									  );
					print json_encode($all_data);
				}
			} else{
				print json_encode(array("error"=>"Search not Available"));
			}
		break;	
		
	case 'SearchLastweek':
			$search_user_lastweek = $_GET['search_user_lastweek'];
			if($search_user_lastweek>0){
				$userQuery = "select u.first_name as fisrtname, u.last_name as lastname,sh.* from ".TABLE_USER. " as u," .TABLE_SEARCH_HISTORY. " as sh where u.user_id=sh.user_id and u.status=0 and sh.add_date <='".date("Y-m-d")."' and sh.add_date>='".date("Y-m-d",mktime(0,0,0,date("m"),date("d")-6,date("Y")))."' group by sh.user_id";
				$userResult = com_db_query($userQuery);
				if($userResult){
					$user_num_rows = com_db_num_rows($userResult);
				}
				if($user_num_rows>0){
				$name = array();
					$searchinfo =  array();
					while($uRow = com_db_fetch_array($userResult)){
						array_push($name,com_db_output($uRow['fisrtname'].' '.$uRow['lastname']));
						
						$searchQuery = "select * from ".TABLE_SEARCH_HISTORY. " where add_date <='".date("Y-m-d")."' and add_date>='".date("Y-m-d",mktime(0,0,0,date("m"),date("d")-6,date("Y")))."' and user_id='".$uRow['user_id']."' order by search_id";
						$searchResult = com_db_query($searchQuery);
						$scnt = 1;
						$searchString='';
						while($sRow = com_db_fetch_array($searchResult)){
							$searchString .=' Search '.$scnt. ': ';
							$searchStr='';
							
							if($sRow['first_name'] !=''){
								if($searchStr==''){	$searchStr = 'First Name: ' .$sRow['first_name'];}else{$searchStr .= 'Fisrt Name: ' .$sRow['first_name'];}
							}
							if($sRow['last_name'] !=''){
								if($searchStr==''){	$searchStr = 'Last Name: ' .$sRow['last_name'];}else{$searchStr .= ', Last Name: ' .$sRow['last_name'];}
							}
							if($sRow['title'] !=''){
								if($searchStr==''){	$searchStr = 'Title: ' .$sRow['title'];}else{$searchStr .= ', Title: ' .$sRow['title'];}
							}
							if($sRow['management'] !=''){
								$mResult = com_db_query("select name from ".TABLE_MANAGEMENT_CHANGE." where id in(".$sRow['management'].")");
								$mStr='';
								while($mRow = com_db_fetch_array($mResult)){
									if($mStr==''){
										$mStr = $mRow['name'];
									}else{
										$mStr .= ', '.$mRow['name'];
									}
								}
								if($searchStr==''){	$searchStr = 'Management Type: ' .$mStr;}else{$searchStr .= ', Management Type: ' .$mStr;}
							}
							if($sRow['country'] !=''){
								$cResult = com_db_query("select countries_name from ".TABLE_COUNTRIES." where countries_id in(".$sRow['country'].")");
								$cStr='';
								while($cRow = com_db_fetch_array($cResult)){
									if($cStr==''){
										$cStr = $cRow['countries_name'];
									}else{
										$cStr .= ', '.$cRow['countries_name'];
									}
								}
								if($searchStr==''){	$searchStr = 'Countries: ' .$cStr;}else{$searchStr .= ', Countries: ' .$cStr;}
							}
							if($sRow['state'] !=''){
								$sResult = com_db_query("select state_name from ".TABLE_STATE." where state_id in(".$sRow['state'].")");
								$sStr='';
								while($stRow = com_db_fetch_array($sResult)){
									if($sStr==''){
										$sStr = $stRow['state_name'];
									}else{
										$sStr .= ', '.$stRow['state_name'];
									}
								}
								if($searchStr==''){	$searchStr = 'State: ' .$sStr;}else{$searchStr .= ', State: ' .$sStr;}
							}
							
							if($sRow['city'] !=''){
								if($searchStr==''){	$searchStr = 'City: ' .$sRow['city'];}else{$searchStr .= ', City: ' .$sRow['city'];}
							}
							if($sRow['zip_code'] !=''){
								if($searchStr==''){	$searchStr = 'Zip Code: ' .$sRow['zip_code'];}else{$searchStr .= ', Zip Code: ' .$sRow['zip_code'];}
							}
							if($sRow['company'] !=''){
								if($searchStr==''){	$searchStr = 'Company: ' .$sRow['company'];}else{$searchStr .= ', Company: ' .$sRow['company'];}
							}
							if($sRow['industry'] !=''){
								$iResult = com_db_query("select title from ".TABLE_INDUSTRY." where industry_id in(".$sRow['industry'].")");
								$iStr='';
								while($iRow = com_db_fetch_array($iResult)){
									if($iStr==''){
										$iStr = $iRow['title'];
									}else{
										$iStr .= ', '.$iRow['title'];
									}
								}
								if($searchStr==''){	$searchStr = 'Industry: ' .$iStr;}else{$searchStr .= ', Industry: ' .$iStr;}
							}
							if($sRow['revenue_size'] !=''){
								$rResult = com_db_query("select name from ".TABLE_REVENUE_SIZE." where id in(".$sRow['revenue_size'].")");
								$rStr='';
								while($rRow = com_db_fetch_array($rResult)){
									if($rStr==''){
										$rStr = $rRow['name'];
									}else{
										$rStr .= ', '.$rRow['name'];
									}
								}
								if($searchStr==''){	$searchStr = 'Revenue Size: ' .$rStr;}else{$searchStr .= ', Revenue Size: ' .$rStr;}
							}
							if($sRow['employee_size'] !=''){
								$eResult = com_db_query("select name from ".TABLE_EMPLOYEE_SIZE." where id in(".$sRow['employee_size'].")");
								$eStr='';
								while($eRow = com_db_fetch_array($eResult)){
									if($eStr==''){
										$eStr = $eRow['name'];
									}else{
										$eStr .= ', '.$eRow['name'];
									}
								}
								if($searchStr==''){	$searchStr = 'Employee Size: ' .$eStr;}else{$searchStr .= ', Employee Size: ' .$eStr;}
							}
							if($sRow['time_period'] !=''){
								if($sRow['time_period']=='Enter Date Range...'){
									if($searchStr==''){	$searchStr = 'Date: From ' .$sRow['from_date'].' To '.$sRow['to_date'];}else{$searchStr .= ', Date: From ' .$sRow['from_date'].' To '.$sRow['to_date'];}
								}else{
									if($searchStr==''){	$searchStr = 'Date: From ' .$sRow['from_date'].' To '.$sRow['to_date'];}else{$searchStr .= ', Date: From ' .$sRow['from_date'].' To '.$sRow['to_date'];}
								}
							}
							
							if($searchStr==''){
								$searchString .= 'All' ."<br>";
							}else{
								$searchString .= $searchStr ."<br>";
							}
							$scnt++;
						}
						array_push($searchinfo,com_db_output($searchString));
						$searchString='';
					}
					$all_data = array(
									  "name" => $name,
									  "searchinfo" => $searchinfo
									  );
					print json_encode($all_data);
				}
			} else{
				print json_encode(array("error"=>"Search not Available"));
			}
		break;	
	
	case 'SearchLastmonth':
			$search_user_lastmonth = $_GET['search_user_lastmonth'];
			if($search_user_lastmonth>0){
				$userQuery = "select u.first_name as fisrtname, u.last_name as lastname,sh.* from ".TABLE_USER. " as u," .TABLE_SEARCH_HISTORY. " as sh where u.user_id=sh.user_id and u.status=0 and sh.add_date <='".date("Y-m-d")."' and sh.add_date>='".date("Y-m-d",mktime(0,0,0,date("m"),date("d")-30,date("Y")))."' group by sh.user_id";
				$userResult = com_db_query($userQuery);
				if($userResult){
					$user_num_rows = com_db_num_rows($userResult);
				}
				if($user_num_rows>0){
					$name = array();
					$searchinfo =  array();
					while($uRow = com_db_fetch_array($userResult)){
					array_push($name,com_db_output($uRow['fisrtname'].' '.$uRow['lastname']));
					
					$searchQuery = "select * from ".TABLE_SEARCH_HISTORY. " where add_date <='".date("Y-m-d")."' and add_date>='".date("Y-m-d",mktime(0,0,0,date("m"),date("d")-30,date("Y")))."' and user_id='".$uRow['user_id']."' order by search_id";
					$searchResult = com_db_query($searchQuery);
					$scnt = 1;
					$searchString='';
					while($sRow = com_db_fetch_array($searchResult)){
						$searchString .=' Search '.$scnt. ': ';
						$searchStr='';
						
						if($sRow['first_name'] !=''){
							if($searchStr==''){	$searchStr = 'First Name: ' .$sRow['first_name'];}else{$searchStr .= 'Fisrt Name: ' .$sRow['first_name'];}
						}
						if($sRow['last_name'] !=''){
							if($searchStr==''){	$searchStr = 'Last Name: ' .$sRow['last_name'];}else{$searchStr .= ', Last Name: ' .$sRow['last_name'];}
						}
						if($sRow['title'] !=''){
							if($searchStr==''){	$searchStr = 'Title: ' .$sRow['title'];}else{$searchStr .= ', Title: ' .$sRow['title'];}
						}
						if($sRow['management'] !=''){
							$mResult = com_db_query("select name from ".TABLE_MANAGEMENT_CHANGE." where id in(".$sRow['management'].")");
							$mStr='';
							while($mRow = com_db_fetch_array($mResult)){
								if($mStr==''){
									$mStr = $mRow['name'];
								}else{
									$mStr .= ', '.$mRow['name'];
								}
							}
							if($searchStr==''){	$searchStr = 'Management Type: ' .$mStr;}else{$searchStr .= ', Management Type: ' .$mStr;}
						}
						if($sRow['country'] !=''){
							$cResult = com_db_query("select countries_name from ".TABLE_COUNTRIES." where countries_id in(".$sRow['country'].")");
							$cStr='';
							while($cRow = com_db_fetch_array($cResult)){
								if($cStr==''){
									$cStr = $cRow['countries_name'];
								}else{
									$cStr .= ', '.$cRow['countries_name'];
								}
							}
							if($searchStr==''){	$searchStr = 'Countries: ' .$cStr;}else{$searchStr .= ', Countries: ' .$cStr;}
						}
						if($sRow['state'] !=''){
							$sResult = com_db_query("select state_name from ".TABLE_STATE." where state_id in(".$sRow['state'].")");
							$sStr='';
							while($stRow = com_db_fetch_array($sResult)){
								if($sStr==''){
									$sStr = $stRow['state_name'];
								}else{
									$sStr .= ', '.$stRow['state_name'];
								}
							}
							if($searchStr==''){	$searchStr = 'State: ' .$sStr;}else{$searchStr .= ', State: ' .$sStr;}
						}
						
						if($sRow['city'] !=''){
							if($searchStr==''){	$searchStr = 'City: ' .$sRow['city'];}else{$searchStr .= ', City: ' .$sRow['city'];}
						}
						if($sRow['zip_code'] !=''){
							if($searchStr==''){	$searchStr = 'Zip Code: ' .$sRow['zip_code'];}else{$searchStr .= ', Zip Code: ' .$sRow['zip_code'];}
						}
						if($sRow['company'] !=''){
							if($searchStr==''){	$searchStr = 'Company: ' .$sRow['company'];}else{$searchStr .= ', Company: ' .$sRow['company'];}
						}
						if($sRow['industry'] !=''){
							$iResult = com_db_query("select title from ".TABLE_INDUSTRY." where industry_id in(".$sRow['industry'].")");
							$iStr='';
							while($iRow = com_db_fetch_array($iResult)){
								if($iStr==''){
									$iStr = $iRow['title'];
								}else{
									$iStr .= ', '.$iRow['title'];
								}
							}
							if($searchStr==''){	$searchStr = 'Industry: ' .$iStr;}else{$searchStr .= ', Industry: ' .$iStr;}
						}
						if($sRow['revenue_size'] !=''){
							$rResult = com_db_query("select name from ".TABLE_REVENUE_SIZE." where id in(".$sRow['revenue_size'].")");
							$rStr='';
							while($rRow = com_db_fetch_array($rResult)){
								if($rStr==''){
									$rStr = $rRow['name'];
								}else{
									$rStr .= ', '.$rRow['name'];
								}
							}
							if($searchStr==''){	$searchStr = 'Revenue Size: ' .$rStr;}else{$searchStr .= ', Revenue Size: ' .$rStr;}
						}
						if($sRow['employee_size'] !=''){
							$eResult = com_db_query("select name from ".TABLE_EMPLOYEE_SIZE." where id in(".$sRow['employee_size'].")");
							$eStr='';
							while($eRow = com_db_fetch_array($eResult)){
								if($eStr==''){
									$eStr = $eRow['name'];
								}else{
									$eStr .= ', '.$eRow['name'];
								}
							}
							if($searchStr==''){	$searchStr = 'Employee Size: ' .$eStr;}else{$searchStr .= ', Employee Size: ' .$eStr;}
						}
						if($sRow['time_period'] !=''){
							if($sRow['time_period']=='Enter Date Range...'){
								if($searchStr==''){	$searchStr = 'Date: From ' .$sRow['from_date'].' To '.$sRow['to_date'];}else{$searchStr .= ', Date: From ' .$sRow['from_date'].' To '.$sRow['to_date'];}
							}else{
								if($searchStr==''){	$searchStr = 'Date: From ' .$sRow['from_date'].' To '.$sRow['to_date'];}else{$searchStr .= ', Date: From ' .$sRow['from_date'].' To '.$sRow['to_date'];}
							}
						}
						
						if($searchStr==''){
							$searchString .= 'All' ."<br>";
						}else{
							$searchString .= $searchStr ."<br>";
						}
						$scnt++;
					}
					array_push($searchinfo,com_db_output($searchString));
					$searchString='';
				}
					$all_data = array(
									  "name" => $name,
									  "searchinfo" => $searchinfo
									  );
					print json_encode($all_data);
				}
			} else{
				print json_encode(array("error"=>"Search not Available"));
			}
		break;
			
	case 'DownloadToday':
			$download_user_today = $_GET['download_user_today'];
			if($download_user_today>0){
				$userQuery = "select user_id, first_name, last_name from ".TABLE_USER. " where status=0 and user_id in (select distinct(user_id) from " . TABLE_DOWNLOAD." where add_date ='".date("Y-m-d")."')";									
				$userResult = com_db_query($userQuery);
				if($userResult){
					$userNumRows = com_db_num_rows($userResult);
				}
				$name = array();
				$donloadinfo =  array();
				while($uRow = com_db_fetch_array($userResult)){
					array_push($name,com_db_output($uRow['first_name'].' '.$uRow['last_name']));
					$downloadQuery = "select * from ".TABLE_DOWNLOAD. " where add_date ='".date("Y-m-d")."' and user_id='".$uRow['user_id']."' order by download_id";
					$downloadResult = com_db_query($downloadQuery);
					$scnt = 1;
					$downloadString='';
					while($dRow = com_db_fetch_array($downloadResult)){
						$totalContactDownload = com_db_GetValue("select count(contact_id) from ".TABLE_DOWNLOAD_TRANS." where download_id='".$dRow['download_id']."'");
						$downloadString .=' Download '.$scnt. ': Total download '.$totalContactDownload.' contacts <br>';
						$scnt++;
					}
					array_push($downloadinfo,com_db_output($downloadString));
					$downloadString='';
				}
				$all_data = array(
								  "name" => $name,
								  "donloadinfo" => $donloadinfo
								  );
				print json_encode($all_data);
			} else{
				print json_encode(array("error"=>"User not Available"));
			}
		break;	
		
	case 'DownloadLastweek':
			$download_user_lastweek = $_GET['download_user_lastweek'];
			if($download_user_lastweek>0){
				$userQuery = "select user_id, first_name, last_name from ".TABLE_USER. " where status=0 and user_id in (select distinct(user_id) from " . TABLE_DOWNLOAD." where add_date <='".date("Y-m-d")."' and add_date>='".date("Y-m-d",mktime(0,0,0,date("m"),date("d")-6,date("Y")))."')";									
				$userResult = com_db_query($userQuery);
				if($userResult){
					$userNumRows = com_db_num_rows($userResult);
				}
				$name = array();
				$downloadinfo =  array();
				while($uRow = com_db_fetch_array($userResult)){
					array_push($name,com_db_output($uRow['first_name'].' '.$uRow['last_name']));
					$downloadQuery = "select * from ".TABLE_DOWNLOAD. " where add_date <='".date("Y-m-d")."' and add_date>='".date("Y-m-d",mktime(0,0,0,date("m"),date("d")-6,date("Y")))."' and user_id='".$uRow['user_id']."' order by download_id";
					$downloadResult = com_db_query($downloadQuery);
					$scnt = 1;
					$downloadString='';
					while($dRow = com_db_fetch_array($downloadResult)){
						$totalContactDownload = com_db_GetValue("select count(contact_id) from ".TABLE_DOWNLOAD_TRANS." where download_id='".$dRow['download_id']."'");
						$downloadString .=' Download '.$scnt. ': Total download '.$totalContactDownload.' contacts <br>';
						$scnt++;
					}
					array_push($downloadinfo,com_db_output($downloadString));
					$downloadString='';
				}
				$all_data = array(
								  "name" => $name,
								  "downloadinfo" => $downloadinfo
								  );
				print json_encode($all_data);
			} else{
				print json_encode(array("error"=>"User not Available"));
			}
		break;	
		
	case 'DownloadLastmonth':
			$download_user_lastmonth = $_GET['download_user_lastmonth'];
			if($download_user_lastmonth>0){
				$userQuery = "select user_id, first_name, last_name from ".TABLE_USER. " where status=0 and user_id in (select distinct(user_id) from " . TABLE_DOWNLOAD." where add_date <='".date("Y-m-d")."' and add_date>='".date("Y-m-d",mktime(0,0,0,date("m"),date("d")-30,date("Y")))."')";									
				$userResult = com_db_query($userQuery);
				if($userResult){
					$userNumRows = com_db_num_rows($userResult);
				}
				$name = array();
				$downloadinfo =  array();
				while($uRow = com_db_fetch_array($userResult)){
					array_push($name,com_db_output($uRow['first_name'].' '.$uRow['last_name']));
					$downloadQuery = "select * from ".TABLE_DOWNLOAD. " where add_date <='".date("Y-m-d")."' and add_date>='".date("Y-m-d",mktime(0,0,0,date("m"),date("d")-30,date("Y")))."' and user_id='".$uRow['user_id']."' order by download_id";
					$downloadResult = com_db_query($downloadQuery);
					$scnt = 1;
					$downloadString='';
					while($dRow = com_db_fetch_array($downloadResult)){
						$totalContactDownload = com_db_GetValue("select count(contact_id) from ".TABLE_DOWNLOAD_TRANS." where download_id='".$dRow['download_id']."'");
						$downloadString .=' Download '.$scnt. ': Total download '.$totalContactDownload.' contacts <br>';
						$scnt++;
					}
					array_push($downloadinfo,com_db_output($downloadString));
					$downloadString='';
				}
				$all_data = array(
								  "name" => $name,
								  "downloadinfo" => $downloadinfo
								  );
				print json_encode($all_data);
			} else{
				print json_encode(array("error"=>"User not Available"));
			}
		break;	
		
	case 'LoginTodayUserIn':
			$login_user_today_in = $_GET['loginTodayIn'];
			if($login_user_today_in>0){
				$userQuery = "select user_id, first_name, last_name, email from ".TABLE_USER. " where status=0 and user_id not in (select distinct(user_id) from " . TABLE_LOGIN_HISTORY." where add_date ='".date("Y-m-d")."')";									
				$userResult = com_db_query($userQuery);
				if($userResult){
					$userNumRows = com_db_num_rows($userResult);
				}
				$name = array();
				$email =  array();
				while($uRow = com_db_fetch_array($userResult)){
					array_push($name,com_db_output($uRow['first_name'].' '.$uRow['last_name']));
					array_push($email,com_db_output($uRow['email']));
				}
				$all_data = array(
								  "name" => $name,
								  "email" => $email
								  );
				print json_encode($all_data);
			}else{
				print json_encode(array("error"=>"User not Available"));
			}
		break;	
		
	case 'LoginLastweekUserIn':
			$login_user_lastweek_in = $_GET['loginLastweekIn'];
			if($login_user_lastweek_in>0){
				$userQuery = "select user_id, first_name, last_name, email from ".TABLE_USER. " where status=0 and user_id not in (select distinct(user_id) from " . TABLE_LOGIN_HISTORY." where add_date <='".date("Y-m-d")."' and add_date>='".date("Y-m-d",mktime(0,0,0,date("m"),date("d")-6,date("Y")))."')";									
				$userResult = com_db_query($userQuery);
				if($userResult){
					$userNumRows = com_db_num_rows($userResult);
				}
				$name = array();
				$email =  array();
				while($uRow = com_db_fetch_array($userResult)){
					array_push($name,com_db_output($uRow['first_name'].' '.$uRow['last_name']));
					array_push($email,com_db_output($uRow['email']));
				}
				$all_data = array(
								  "name" => $name,
								  "email" => $email
								  );
				print json_encode($all_data);
			}else{
				print json_encode(array("error"=>"User not Available"));
			}
		break;	
		
	case 'LoginLastmonthUserIn':
			$login_user_lastweek_in = $_GET['loginLastmonthIn'];
			if($login_user_lastweek_in>0){
				$userQuery = "select user_id, first_name, last_name, email from ".TABLE_USER. " where status=0 and user_id not in (select distinct(user_id) from " . TABLE_LOGIN_HISTORY." where add_date <='".date("Y-m-d")."' and add_date>='".date("Y-m-d",mktime(0,0,0,date("m"),date("d")-30,date("Y")))."')";									
				$userResult = com_db_query($userQuery);
				if($userResult){
					$userNumRows = com_db_num_rows($userResult);
				}
				$name = array();
				$email =  array();
				while($uRow = com_db_fetch_array($userResult)){
					array_push($name,com_db_output($uRow['first_name'].' '.$uRow['last_name']));
					array_push($email,com_db_output($uRow['email']));
				}
				$all_data = array(
								  "name" => $name,
								  "email" => $email
								  );
				print json_encode($all_data);
			}else{
				print json_encode(array("error"=>"User not Available"));
			}
		break;	
		
	case 'SearchTodayIn':
			$search_user_today_in = $_GET['search_user_today_in'];
			if($search_user_today_in>0){
				$userQuery = "select user_id, first_name, last_name, email from ".TABLE_USER. " where status=0 and user_id not in (select distinct(user_id) from " . TABLE_SEARCH_HISTORY." where add_date ='".date("Y-m-d")."')";									
				$userResult = com_db_query($userQuery);
				if($userResult){
					$userNumRows = com_db_num_rows($userResult);
				}
				$name = array();
				$email =  array();
				while($uRow = com_db_fetch_array($userResult)){
					array_push($name,com_db_output($uRow['first_name'].' '.$uRow['last_name']));
					array_push($email,com_db_output($uRow['email']));
				}
				$all_data = array(
								  "name" => $name,
								  "email" => $email
								  );
				print json_encode($all_data);
			}else{
				print json_encode(array("error"=>"User not Available"));
			}
		break;	
	
	case 'SearchLastweekIn':
			$search_user_lastweek_in = $_GET['search_user_lastweek_in'];
			if($search_user_lastweek_in>0){
				$userQuery = "select user_id, first_name, last_name, email from ".TABLE_USER. " where status=0 and user_id not in (select distinct(user_id) from " . TABLE_SEARCH_HISTORY." where add_date <='".date("Y-m-d")."' and add_date>='".date("Y-m-d",mktime(0,0,0,date("m"),date("d")-6,date("Y")))."')";									
				$userResult = com_db_query($userQuery);
				if($userResult){
					$userNumRows = com_db_num_rows($userResult);
				}
				$name = array();
				$email =  array();
				while($uRow = com_db_fetch_array($userResult)){
					array_push($name,com_db_output($uRow['first_name'].' '.$uRow['last_name']));
					array_push($email,com_db_output($uRow['email']));
				}
				$all_data = array(
								  "name" => $name,
								  "email" => $email
								  );
				print json_encode($all_data);
			}else{
				print json_encode(array("error"=>"User not Available"));
			}
		break;	
		
	case 'SearchLastmonthIn':
			$search_user_lastmonth_in = $_GET['search_user_lastmonth_in'];
			if($search_user_lastmonth_in>0){
				$userQuery = "select user_id, first_name, last_name, email from ".TABLE_USER. " where status=0 and user_id not in (select distinct(user_id) from " . TABLE_SEARCH_HISTORY." where add_date <='".date("Y-m-d")."' and add_date>='".date("Y-m-d",mktime(0,0,0,date("m"),date("d")-30,date("Y")))."')";									
				$userResult = com_db_query($userQuery);
				if($userResult){
					$userNumRows = com_db_num_rows($userResult);
				}
				$name = array();
				$email =  array();
				while($uRow = com_db_fetch_array($userResult)){
					array_push($name,com_db_output($uRow['first_name'].' '.$uRow['last_name']));
					array_push($email,com_db_output($uRow['email']));
				}
				$all_data = array(
								  "name" => $name,
								  "email" => $email
								  );
				print json_encode($all_data);
			}else{
				print json_encode(array("error"=>"User not Available"));
			}
		break;	
		
	case 'DownloadTodayIn':
			$download_user_today_in = $_GET['download_user_today_in'];
			if($download_user_today_in>0){
				$userQuery = "select user_id, first_name, last_name, email from ".TABLE_USER. " where status=0 and user_id not in (select distinct(user_id) from " . TABLE_DOWNLOAD." where add_date ='".date("Y-m-d")."')";									
				$userResult = com_db_query($userQuery);
				if($userResult){
					$userNumRows = com_db_num_rows($userResult);
				}
				$name = array();
				$email =  array();
				while($uRow = com_db_fetch_array($userResult)){
					array_push($name,com_db_output($uRow['first_name'].' '.$uRow['last_name']));
					array_push($email,com_db_output($uRow['email']));
				}
				$all_data = array(
								  "name" => $name,
								  "email" => $email
								  );
				print json_encode($all_data);
			}else{
				print json_encode(array("error"=>"User not Available"));
			}
		break;	
		
	case 'DownloadLastweekIn':
			$download_user_lastweek_in = $_GET['download_user_lastweek_in'];
			if($download_user_lastweek_in>0){
				$userQuery = "select user_id, first_name, last_name, email from ".TABLE_USER. " where status=0 and user_id not in (select distinct(user_id) from " . TABLE_DOWNLOAD." where add_date <='".date("Y-m-d")."' and add_date>='".date("Y-m-d",mktime(0,0,0,date("m"),date("d")-6,date("Y")))."')";									
				$userResult = com_db_query($userQuery);
				if($userResult){
					$userNumRows = com_db_num_rows($userResult);
				}
				$name = array();
				$email =  array();
				while($uRow = com_db_fetch_array($userResult)){
					array_push($name,com_db_output($uRow['first_name'].' '.$uRow['last_name']));
					array_push($email,com_db_output($uRow['email']));
				}
				$all_data = array(
								  "name" => $name,
								  "email" => $email
								  );
				print json_encode($all_data);
			}else{
				print json_encode(array("error"=>"User not Available"));
			}
		break;	
	
	case 'DownloadLastmonthIn':
			$download_user_lastmonth_in = $_GET['download_user_lastmonth_in'];
			if($download_user_lastmonth_in>0){
				$userQuery = "select user_id, first_name, last_name, email from ".TABLE_USER. " where status=0 and user_id not in (select distinct(user_id) from " . TABLE_DOWNLOAD." where add_date <='".date("Y-m-d")."' and add_date>='".date("Y-m-d",mktime(0,0,0,date("m"),date("d")-30,date("Y")))."')";									
				$userResult = com_db_query($userQuery);
				if($userResult){
					$userNumRows = com_db_num_rows($userResult);
				}
				$name = array();
				$email =  array();
				while($uRow = com_db_fetch_array($userResult)){
					array_push($name,com_db_output($uRow['first_name'].' '.$uRow['last_name']));
					array_push($email,com_db_output($uRow['email']));
				}
				$all_data = array(
								  "name" => $name,
								  "email" => $email
								  );
				print json_encode($all_data);
			}else{
				print json_encode(array("error"=>"User not Available"));
			}
		break;			
	
	//
	case 'TodayAlertSend':
			$user_today_alert = $_GET['user_today_alert'];
			if($user_today_alert>0){
				$day_end = mktime(0,10,10,date("m"),date("d"),date("Y"));
				$day_start = mktime(23,50,50,date("m"),date("d"),date("Y"));
				
				$userQuery = "select u.user_id,u.first_name,u.last_name from ".TABLE_USER. " u,".TABLE_ALERT_SEND_INFO." asi where u.user_id = asi.user_id and asi.sent_date >='".$day_start."' and asi.sent_date <='".$day_end."' group by asi.user_id";									
				$userResult = com_db_query($userQuery);
				if($userResult){
					$userNumRows = com_db_num_rows($userResult);
				}
				$name = array();
				$email =  array();
				while($uRow = com_db_fetch_array($userResult)){
					array_push($name,com_db_output($uRow['first_name'].' '.$uRow['last_name']));
					
					$alertQuery = "select email_id,sent_date from ".TABLE_ALERT_SEND_INFO." where user_id='".$uRow['user_id']."' and sent_date >='".$day_start."' and sent_date <='".$day_end."' order by sent_date";									
					$alertResult = com_db_query($alertQuery);
					$sendDateStr='';
					while($alertRow = com_db_fetch_array($alertResult)){
						if($sendDateStr==''){
							$sendDateStr = '<a href="'.HTTP_SITE_URL.'alert-email-show.php?emailid='.$alertRow['email_id'].'" target="_blank">'.date("m/d/Y",$alertRow['sent_date']).'</a>';
						}else{
							$sendDateStr .= ', <a href="'.HTTP_SITE_URL.'alert-email-show.php?emailid='.$alertRow['email_id'].'" target="_blank">'.date("m/d/Y",$alertRow['sent_date']).'</a>';
						}
					}
					
					array_push($email,$sendDateStr);
				}
				$all_data = array(
								  "name" => $name,
								  "email" => $email
								  );
				print json_encode($all_data);
			}else{
				print json_encode(array("error"=>"User not Available"));
			}
		break;	
		
	case 'LastweekAlertSend':
			$user_lastweek_alert = $_GET['user_lastweek_alert'];
			if($user_lastweek_alert>0){
				$lastweek_end = mktime(0,10,10,date("m"),date("d")-1,date("Y"));
				$lastweek_start = mktime(23,50,50,date("m"),date("d")-6,date("Y"));

				
				$userQuery = "select u.user_id,u.first_name,u.last_name from ".TABLE_USER. " u,".TABLE_ALERT_SEND_INFO." asi where u.user_id = asi.user_id and asi.sent_date >='".$lastweek_start."' and asi.sent_date <='".$lastweek_end."' group by asi.user_id";									
				$userResult = com_db_query($userQuery);
				if($userResult){
					$userNumRows = com_db_num_rows($userResult);
				}
				$name = array();
				$email =  array();
				while($uRow = com_db_fetch_array($userResult)){
					array_push($name,com_db_output($uRow['first_name'].' '.$uRow['last_name']));
					
					$alertQuery = "select email_id,sent_date from ".TABLE_ALERT_SEND_INFO." where user_id='".$uRow['user_id']."' and sent_date >='".$lastweek_start."' and sent_date <='".$lastweek_end."' order by sent_date";									
					$alertResult = com_db_query($alertQuery);
					$sendDateStr='';
					while($alertRow = com_db_fetch_array($alertResult)){
						if($sendDateStr==''){
							$sendDateStr = '<a href="'.HTTP_SITE_URL.'alert-email-show.php?emailid='.$alertRow['email_id'].'" target="_blank">'.date("m/d/Y",$alertRow['sent_date']).'</a>';
						}else{
							$sendDateStr .= ', <a href="'.HTTP_SITE_URL.'alert-email-show.php?emailid='.$alertRow['email_id'].'" target="_blank">'.date("m/d/Y",$alertRow['sent_date']).'</a>';
						}
					}
					
					array_push($email,$sendDateStr);
				}
				$all_data = array(
								  "name" => $name,
								  "email" => $email
								  );
				print json_encode($all_data);
			}else{
				print json_encode(array("error"=>"User not Available"));
			}
		break;	
	
	case 'LastmonthAlertSend':
			$user_lastmonth_alert = $_GET['user_lastmonth_alert'];
			if($user_lastmonth_alert>0){
				$lastmonth_end = mktime(0,10,10,date("m"),date("d")-1,date("Y"));
				$lastmonth_start = mktime(23,50,50,date("m"),date("d")-30,date("Y"));
				
				$userQuery = "select u.user_id,u.first_name,u.last_name from ".TABLE_USER. " u,".TABLE_ALERT_SEND_INFO." asi where u.user_id = asi.user_id and asi.sent_date >='".$lastmonth_start."' and asi.sent_date <='".$lastmonth_end."' group by asi.user_id";									
				$userResult = com_db_query($userQuery);
				if($userResult){
					$userNumRows = com_db_num_rows($userResult);
				}
				$name = array();
				$email =  array();
				while($uRow = com_db_fetch_array($userResult)){
					array_push($name,com_db_output($uRow['first_name'].' '.$uRow['last_name']));
					
					$alertQuery = "select email_id,sent_date from ".TABLE_ALERT_SEND_INFO." where user_id='".$uRow['user_id']."' and sent_date >='".$lastmonth_start."' and sent_date <='".$lastmonth_end."' order by sent_date";									
					$alertResult = com_db_query($alertQuery);
					$sendDateStr='';
					while($alertRow = com_db_fetch_array($alertResult)){
						if($sendDateStr==''){
							$sendDateStr = '<a href="'.HTTP_SITE_URL.'alert-email-show.php?emailid='.$alertRow['email_id'].'" target="_blank">'.date("m/d/Y",$alertRow['sent_date']).'</a>';
						}else{
							$sendDateStr .= ', <a href="'.HTTP_SITE_URL.'alert-email-show.php?emailid='.$alertRow['email_id'].'" target="_blank">'.date("m/d/Y",$alertRow['sent_date']).'</a>';
						}
					}
					
					array_push($email,$sendDateStr);
				}
				$all_data = array(
								  "name" => $name,
								  "email" => $email
								  );
				print json_encode($all_data);
			}else{
				print json_encode(array("error"=>"User not Available"));
			}
		break;							
}
?>