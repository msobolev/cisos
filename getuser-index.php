<?php
require('includes/include-top.php');
$q = $_GET["q"];
$type = $_GET['type'];
	
if($type=='IPSR'){

	$ind_list = $_GET['ind'];
	$revenue = $_GET['rev'];
	$employee = $_GET['emp'];
	$state_list = $_GET['st'];
	$islog = $_GET['islog'];
	//revenue
	$rev = explode("||",$revenue);
	$st_rev = $rev[0];
	$stRev = explode(" ",$st_rev);
	if(trim($stRev[1]) == 'bil'){
		$st_rev = 1000;
	}elseif(trim($stRev[1]) == 'mil'){
		$st_rev = substr($stRev[0],1,strlen($stRev[0])-1);
	}else{
		$st_rev = substr($stRev[0],0,1);
	}
	
	$strev_sec = explode(">",$rev[1]);
	if(count($strev_sec)==2){
		$endRev = $strev_sec[1];
	}elseif(count($strev_sec)==1){
		$endRev = $strev_sec[0];
	}
	
	$endRev = explode(" ",$endRev);
	if(trim($endRev[1])== 'bil'){
		$end_rev = 1000;
	}elseif(trim($endRev[1])== 'mil'){
		$end_rev = substr($endRev[0],1,strlen($endRev[0])-1);
	}else{
		$end_rev = substr($endRev[0],0,1);
	}
	
	$revResult = com_db_query("select id,name from ".TABLE_REVENUE_SIZE." where from_range>='" . $st_rev. "' and from_range <='".$end_rev."' order by id");
	$rev_list =''; 
	while($revRow = com_db_fetch_array($revResult)){
		if($rev_list ==''){
			$rev_list = $revRow['id'];
		}else{
			$rev_list .= ",". $revRow['id'];
		} 
	}
	
	
	//employee
	if($employee !=''){
		$emp = explode("||",$employee);
		$st_emp = $emp[0];
		
		$stemp_sec = explode(">",$emp[1]);
		if(count($stemp_sec)==2){
			$end_emp = $stemp_sec[1];
		}elseif(count($stemp_sec)==1){
			$end_emp = $stemp_sec[0];
		}
		$endEmp = explode("K",$end_emp);
		if(count($endEmp)==2){
			$end_emp = $endEmp[0]*1000;
		}elseif(count($endEmp)==1){
			$end_emp = $endEmp[0];
		}
		
		$empResult = com_db_query("select id,name from ".TABLE_EMPLOYEE_SIZE." where from_range>='" . $st_emp. "' and from_range <='".$end_emp."'");
		$emp_list =''; 
		while($empRow = com_db_fetch_array($empResult)){
			if($emp_list ==''){
				$emp_list = $empRow['id'];
			}else{
				$emp_list .= ",". $empRow['id'];
			} 
		}
	}
	
	$searchString='';	
	if($ind_list !=''){
		$searchString = " cm.ind_group_id in (".$ind_list.") ";
	}
	if($rev_list !=''){
		if($searchString ==''){
			$searchString = " cm.company_revenue in (".$rev_list.") ";
		}else{
			$searchString .= " and cm.company_revenue in (".$rev_list.") ";
		}	
	}
	if($emp_list !=''){
		if($searchString ==''){
			$searchString = " cm.company_employee in (".$emp_list.") ";
		}else{
			$searchString .= " and cm.company_employee in (".$emp_list.") ";
		}	
	}
	if($state_list !=''){
		if($searchString ==''){
			$searchString = " cm.state in (".$state_list.") ";
		}else{
			$searchString .= " and cm.state in (".$state_list.") ";
		}	
	}
		
	$last_ann_date = com_db_GetValue("select max(announce_date) from ".TABLE_MOVEMENT_MASTER." where status=0 order by announce_date desc");
	$ladt = explode("-",$last_ann_date);
	$last30Day = date("Y-m-d",mktime(0,0,0,$ladt[1],($ladt[2]-30),$ladt[0]));
	
	if($searchString==''){
	 	$movementQuery = "select mm.title,mm.movement_url,mm.personal_id,mm.company_id,mm.announce_date,pm.first_name,pm.last_name from ".TABLE_MOVEMENT_MASTER." as mm, ".TABLE_PERSONAL_MASTER." as pm, ".TABLE_COMPANY_MASTER." as cm where mm.personal_id=pm.personal_id and mm.status=0 and mm.announce_date>='".$last30Day."' order by mm.announce_date desc";
	}else{
	 	$movementQuery = "select mm.title,mm.movement_url,mm.personal_id,mm.company_id,mm.announce_date,pm.first_name,pm.last_name from ".TABLE_MOVEMENT_MASTER." as mm, ".TABLE_PERSONAL_MASTER." as pm, ".TABLE_COMPANY_MASTER." as cm where mm.personal_id=pm.personal_id and mm.company_id=cm.company_id and mm.status=0 and ".$searchString." and mm.announce_date>='".$last30Day."' order by mm.announce_date desc";
	}
	
	$movementResult = com_db_query($movementQuery);
	if($movementResult){
		$num_rows = com_db_num_rows($movementResult);
	}
	$search_movement = $num_rows .'###';
	if($num_rows > 0){
		$ind=1;
		
		while($moveRow = com_db_fetch_array($movementResult)){
			$adt = explode("-",$moveRow['announce_date']);
			$adt_format = date("d-M-Y",mktime(0,0,0,$adt[1],$adt[2],$adt[0]));
			$adt_now = explode("-",$adt_format);
			
			$HL =explode(' ', com_db_output($moveRow['first_name'].' '.$moveRow['last_name']).' was Appointed as '.com_db_output($moveRow['title']));
			$headline='';
			for($h=0; $h<sizeof($HL); $h++){
				if(strlen($headline)<=55){
					$headline .= $HL[$h].' ';
				}	
			}
			$headline .= '<a href="'.HTTP_SERVER.$conRow['movement_url'].'">more></a>';
			if($islog == 1){ 
				$isLink = $moveRow['movement_url'];
			}else{
				$isLink = 'provide-contact-information.php';
			}				
			if($ind < ($num_rows-6)){
			
				$search_movement .='<div id="DivCnt_'.$ind.'" class="main_content" style="display:none;">
										<div class="dateleft1">
											<div class="datebg_new">
												<strong>'.$adt_now[0].'</strong><span>'.$adt_now[1].'</span>
											</div>
										</div>
										<div class="dateleft2">'.$headline.'</div>
										<div class="dateleft3"><a href="'.HTTP_SERVER.$isLink.'">Get Contact Details</a></div>
										<div style="clear:both;"></div>
									</div>';
		   } else{
				if($ind == ($num_rows-6) || $ind==1){ 
					$div_class = 'buebg';
				}elseif($ind%2 == 0){
					$div_class = 'whitebg1';
				}else{
					$div_class = 'grybg1';
				}	
				
				$search_movement .='<div id="DivCnt_'.$ind.'" class="main_content '.$div_class.'">
										<div class="dateleft1">
											<div class="datebg_new">
												<strong>'.$adt_now[0].'</strong><span>'.$adt_now[1].'</span>
											</div>
										</div>
										<div class="dateleft2">'.$headline.'</div>
										<div class="dateleft3"><a href="'.HTTP_SERVER.$isLink.'">Get Contact Details</a></div>
										<div style="clear:both;"></div>
									</div>';
			
			} 
			
			$ind++;					
							
		}
	}else{
		$search_movement .= '<br><br><b><h3>Please adjust your search parameters to widen your search.</h3></b>';
	}
	echo $search_movement;					
}

?> 