<?php
require('includes/include_top.php');

$search_id = $_REQUEST['sID'];
$search_query = "select * from " . TABLE_SEARCH_HISTORY . " where search_id ='".$search_id."'";
$search_result = com_db_query($search_query);
$search_row = com_db_fetch_array($search_result);
?>

<table border="0" cellpadding="2" cellspacing="2">
  <tr>
  	<td colspan="3" style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;"><strong>Chose Executive:</strong></td>
  </tr>
  <tr>
  	<td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;">First Name:</td>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;">&nbsp;</td>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;"><?=$search_row['first_name'];?></td>
  </tr>
 
  <tr>
	<td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;">Last Name:</td>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;">&nbsp;</td>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;"><?=$search_row['last_name'];?></td>
  </tr>
  <tr>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;">Title:</td>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;">&nbsp;</td>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;"><?=$search_row['title'];?></td>
  </tr>
  <tr>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;">Management Change Type:</td>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;">&nbsp;</td>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;"><?=com_db_GetValue("select name from ".TABLE_MANAGEMENT_CHANGE." where id='".$search_row['management']."'");?></td>
  </tr>
  <tr>
  	<td colspan="3" style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;"><strong>Chose Location:</strong></td>
  </tr>
  <tr>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;">Country:</td>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;">&nbsp;</td>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;"><?=com_db_GetValue("select countries_name from ".TABLE_COUNTRIES." where countries_id='".$search_row['country']."'");?></td>
  </tr>
  <tr>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;">State:</td>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;">&nbsp;</td>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;"><? if($search_row['state'] !=''){echo com_db_GetValue("select short_name from ".TABLE_STATE." where state_id in (".$search_row['state'].")");}?></td>
  </tr>
  <tr>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;">City</td>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;">&nbsp;</td>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;"><?=$search_row['city'];?></td>
  </tr>
  <tr>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;">Zip Code:</td>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;">&nbsp;</td>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;"><?=$search_row['zip_code'];?></td>
  </tr>
  <tr>
  	<td colspan="3" style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;"><strong>Chose Company:</strong></td>
  </tr>
  <tr>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;">Company:</td>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;">&nbsp;</td>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;"><?=$search_row['company'];?></td>
  </tr>
  <tr>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;">Industry</td>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;">&nbsp;</td>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;"><?=com_db_GetValue("select title from ".TABLE_INDUSTRY." where industry_id='".$search_row['industry']."'");?></td>
  </tr>
  <tr>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;">Size ($Revenue):</td>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;">&nbsp;</td>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;"><?=com_db_GetValue("select name from ".TABLE_REVENUE_SIZE." where id='".$search_row['revenue_size']."'");?></td>
  </tr>
  <tr>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;">Size (Employees):</td>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;">&nbsp;</td>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;"><?=com_db_GetValue("select name from ".TABLE_EMPLOYEE_SIZE." where id='".$search_row['employee_size']."'");?></td>
  </tr>
  <tr>
  	<td colspan="3" style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;"><strong>Chose Time Period:</strong></td>
  </tr>
  <tr>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;">Date:</td>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;">&nbsp;</td>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;">
		<?=$search_row['time_period'];?><br>
		<? 
		if($search_row['from_date'] !='0000-00-00' && $search_row['to_date'] != '0000-00-00'){
			echo 'From : '.$search_row['from_date'] .' To :'.$search_row['to_date'];
		} 
		?>
	
	</td>
  </tr>
</table>
