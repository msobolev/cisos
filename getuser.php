<?php
require('includes/include-top.php');
$q = $_GET["q"];
$type = $_GET['type'];
$oldValue = $_GET['oldValue'];

if($type=='Add'){
	$email = com_db_GetValue("SELECT  email FROM ". TABLE_USER." WHERE email = '".$q."'");
	if($email !=''){
		echo 'the email already exists in our <br /> system, <strong>loign here</strong>';
	}
}

if($type=='AddRE'){
	$email = com_db_GetValue("SELECT  email FROM ". TABLE_USER." WHERE email = '".$q."'");
	if($email !=''){
		echo 'the email already exists in our <br /> system, <strong>loign here</strong>';
	}
}
if($type=='EmailEdit'){
	$email = com_db_GetValue("SELECT  email FROM ". TABLE_USER." WHERE email = '".$q."' and email <>'".$oldValue."'");
	if($email !=''){
		echo 'the email already exists in our <br /> system, <strong>loign here</strong>';
	}
}

if($type=='EmailEditRE'){
	$email = com_db_GetValue("SELECT  email FROM ". TABLE_USER." WHERE email = '".$q."' and email <>'".$oldValue."'");
	if($email !=''){
		echo 'the email already exists in our <br /> system, <strong>loign here</strong>';
	}
}
if($type=='AddSignUp'){
	$email = com_db_GetValue("SELECT  email FROM ". TABLE_USER." WHERE email = '".$q."'");
	if($email !=''){
		echo 'the email already exists in our <br /> system, <strong>loign here</strong>';
	}
}
if($type=='Edit'){
	$email = com_db_GetValue("SELECT  email FROM ". TABLE_USER." WHERE email = '".$q."'");
	if($email !='' && $oldValue != $email){
		echo 'the email already exists in our <br /> system, <strong>loignhere</strong>';
	}
}

if($type=='Captcha'){
	$code = $_SESSION['securitycode'];
	if($q !=$code){
		echo 'the confirmation code you typed in does not match. Please try again';
	}
}

if($type=='Search'){
	$qry = str_replace(' ','%',$q);
	$search_query = "select c.first_name,c.last_name,c.new_title,c.company_name from " . TABLE_CONTACT . " as c where (c.first_name like '%".$qry."%' or c.last_name like '%".$qry."%' or c.new_title like '%".$qry."%' or c.company_name like '%".$qry."%')" ;
	$search_result = com_db_query($search_query);
	$ser_content = '<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0"  class="live-search-text"> ';
	while($search_row = com_db_fetch_array($search_result)){
		$ser_content .= '<tr>
							<td align="left" valign="top" class="live-search-text"><a href="javascript:SearchSelectResult('."'".$search_row['first_name'].', '.$search_row['last_name'].', '.$search_row['company_name'].', '.$search_row['new_title']."'".');">'.com_db_output($search_row['first_name']).' '.com_db_output($search_row['last_name']).' '.com_db_output($search_row['company_name']).' '.com_db_output($search_row['new_title']).'</a></td>
					  	 </tr>';
	}
	$ser_content .= '</table>';
	echo $ser_content;
}

if($type=='AddProject'){
	$project_name = com_db_GetValue("SELECT project_name FROM ". TABLE_PROJECT." WHERE project_name = '".$q."'");
	if($project_name !=''){
		echo $project_name.' Project name already present';
	}
}

if($type=='EditProject'){
	$project_name = com_db_GetValue("SELECT project_name FROM ". TABLE_PROJECT." WHERE project_name = '".$q."'");
	if($project_name !=$cmodel && $project_name !=''){
		echo $project_name.' Project name already present';
	}
}

if($type=='AddCountry'){
	$sql_result = com_db_query("SELECT  countries_name FROM ". TABLE_COUNTRIES." WHERE countries_name like '".$q."%' order by countries_name");
	while($data_row = com_db_fetch_array($sql_result)){
		echo '<a href="javascript:TextboxValueChange('."'country','div_country','".$data_row['countries_name']."'".');">'.$data_row['countries_name'].'</a><br />';
	}
	$sql_result = com_db_query("SELECT  countries_name FROM ". TABLE_COUNTRIES." WHERE countries_name not like '".$q."%' order by countries_name");
	while($data_row = com_db_fetch_array($sql_result)){
		echo '<a href="javascript:TextboxValueChange('."'country','div_country','".$data_row['countries_name']."'".');">'.$data_row['countries_name'].'</a><br />';
	}
	echo '<a href="javascript:TextboxValueChange('."'country','div_country','Any'".');">Any</a><br />';
}
if($type=='AddState'){
	$sql_result = com_db_query("SELECT  short_name FROM ". TABLE_STATE." WHERE short_name like '".$q."%' order by short_name");
	while($data_row = com_db_fetch_array($sql_result)){
		echo '<a href="javascript:TextboxValueChange('."'state','div_state','".$data_row['short_name']."'".');">'.$data_row['short_name'].'</a><br />';
	}
	$sql_result = com_db_query("SELECT  short_name FROM ". TABLE_STATE." WHERE short_name not like '".$q."%' order by short_name");
	while($data_row = com_db_fetch_array($sql_result)){
		echo '<a href="javascript:TextboxValueChange('."'state','div_state','".$data_row['short_name']."'".');">'.$data_row['short_name'].'</a><br />';
	}
	echo '<a href="javascript:TextboxValueChange('."'state','div_state','Any'".');">Any</a><br />';
}
if($type=='AddManagement'){
	$sql_result = com_db_query("SELECT  name FROM ". TABLE_MANAGEMENT_CHANGE." WHERE name like '".$q."%' order by name");
	while($data_row = com_db_fetch_array($sql_result)){
		echo '<a href="javascript:TextboxValueChange('."'management','div_management','".$data_row['name']."'".');">'.$data_row['name'].'</a><br />';
	}
	$sql_result = com_db_query("SELECT  name FROM ". TABLE_MANAGEMENT_CHANGE." WHERE name not like '".$q."%' order by name");
	while($data_row = com_db_fetch_array($sql_result)){
		echo '<a href="javascript:TextboxValueChange('."'management','div_management','".$data_row['name']."'".');">'.$data_row['name'].'</a><br />';
	}
	echo '<a href="javascript:TextboxValueChange('."'management','div_management','Any'".');">Any</a><br />';
}
if($type=='SignUpEmailManagement'){
	$isPresent = com_db_GetValue("SELECT  email FROM ". TABLE_VIGILANT_SIGN_UP." WHERE email = '".$q."'");
	if($isPresent){
		echo 'This email is already in use. please registration here';
	}else{
		echo '';
	}
}
?> 