<?php
require('includes/include_top.php');
$download_id = $_REQUEST['dID'];
$download_query = "select c.first_name,c.last_name,c.new_title,c.company_name,c.email,c.address from " . TABLE_CONTACT . " c, " . TABLE_DOWNLOAD . " d, ". TABLE_DOWNLOAD_TRANS . " dt where d.download_id=dt.download_id and c.contact_id=dt.contact_id and d.download_id='".$download_id."'";
$download_result = com_db_query($download_query);
?>

<table border="0" cellpadding="2" cellspacing="2">
  <tr bgcolor="#9999CC">
  	<td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;"><strong>#</strong></td>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;"><strong>Name</strong></td>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;"><strong>Title</strong></td>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;"><strong>Company</strong></td>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;"><strong>Email</strong></td>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;"><strong>Address</strong></td>
  </tr>
  <?
  $i=1;
  while($download_row = com_db_fetch_array($download_result)){
  ?>
  <tr>
	<td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;"><?=$i;?>.&nbsp;</td>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;"><?=$download_row['first_name'].' '.$download_row['last_name'];?></td>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;"><?=$download_row['new_title'];?></td>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;"><?=$download_row['company_name'];?></td>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;"><?=$download_row['email'];?></td>
    <td style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:12px;;"><?=$download_row['address'];?></td>
  </tr>
  <? $i++;
  	} ?>
</table>
