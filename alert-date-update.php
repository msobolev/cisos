<?php
chdir(dirname( __FILE__ ));
include("includes/include-top.php");

$alert_update_query = "select a.* from " . TABLE_ALERT . " as a, ".TABLE_USER." as u where a.user_id=u.user_id and u.status=0 and a.exp_date >'".date('Y-m-d'). "' and a.status=0 and a.delivery_schedule <>'No Updates'"  ;
$alert_update_result = com_db_query($alert_update_query);
while($alert_update_row = com_db_fetch_array($alert_update_result)){
	  $next_alert_date='';
	  $alert_id = $alert_update_row['alert_id'];
	  if($alert_update_row['delivery_schedule']=='Daily' && $alert_update_row['alert_date'] <= date('Y-m-d')){
			$next_alert_date = date('Y-m-d',mktime(0,0,0,date('m'),date('d')+1,date('Y')));
			$previous_date = $alert_update_row['alert_date'];
	  }elseif($alert_update_row['delivery_schedule']=='Weekly' && ($alert_update_row['alert_date'] == date('Y-m-d') || $alert_update_row['alert_date'] < date('Y-m-d',mktime(0,0,0,date('m'),date('d') - 6,date('Y'))))){
			$next_alert_date = date('Y-m-d',mktime(0,0,0,date('m'),date('d')+7,date('Y')));
			$previous_date = $alert_update_row['alert_date'];
	  }elseif($alert_update_row['delivery_schedule']=='Monthly' && ($alert_update_row['alert_date'] == date('Y-m-d') || $alert_update_row['alert_date'] < date('Y-m-d',mktime(0,0,0,date('m')-1,date('d')+1,date('Y'))))){
			$next_alert_date = date('Y-m-d',mktime(0,0,0,date('m')+1,date('d'),date('Y')));
			$previous_date = $alert_update_row['alert_date'];
	  }
	  if($next_alert_date !=''){
		 com_db_query("update ".TABLE_ALERT." set previous_date='".$previous_date."', alert_date='".$next_alert_date."' where alert_id='".$alert_id."'");
	  }
}
?>
