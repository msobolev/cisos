<?php
include("includes/include-top.php");

if($_SESSION['sess_user_id'] != '')
{
    setcookie ("searchuser", "", time() - 3600); 
}    
else
{    
    if(!isset($_COOKIE['searchuser'])) 
    {
        $cookie_name = "searchuser";
        //echo "<br>In if";
        $cookie_value = "1";
        setcookie($cookie_name, $cookie_value, time()+3600); // 86400 = 1 day
        //echo "<br>Cookie Val: '" . $cookie_value . "'";
    } 
    else
    {
        //echo "<br>In else";
        $cookie_value = $_COOKIE['searchuser'];
        $cookie_value = $cookie_value+1;
        setcookie('searchuser', $cookie_value, time()+3600); // 86400 = 1 day
        //echo "<br>Cookie Val: '" . $cookie_value . "'";
        if($cookie_value > 3)
        {
            $url ='pricing.html';
//            com_redirect($url);
        }    

    }
}   



$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : com_db_GetValue("select per_page from ". TABLE_PAGING . " order by per_page");
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$fld=$_REQUEST['fld'];
$ad=$_REQUEST['ad'];
						
$isSubscriptionID = com_db_GetValue("select subscription_id from " . TABLE_USER . " where user_id='".$_SESSION['sess_user_id']."'");

if($isSubscriptionID=='1'){
	$search_count = com_db_GetValue("select count(user_id) as cnt from " . TABLE_SEARCH_HISTORY . " where user_id='".$_SESSION['sess_user_id']."' and add_date like '".date('Y')."-".date("m")."-%'");
	$sd_pre_month = com_db_GetValue("select search_database from " . TABLE_SUBSCRIPTION . " where sub_id='".$isSubscriptionID."'");
	if($search_count >= $sd_pre_month || !is_numeric($sd_pre_month)){
		$url ='notifications.php';
		com_redirect($url);
	}
}elseif($isSubscriptionID=='2'){
	$search_count = com_db_GetValue("select count(user_id) as cnt from " . TABLE_SEARCH_HISTORY . " where user_id='".$_SESSION['sess_user_id']."' and add_date like '".date('Y')."-".date("m")."-%'");
	$sd_pre_month = com_db_GetValue("select search_database from " . TABLE_SUBSCRIPTION . " where sub_id='".$isSubscriptionID."'");
	if($search_count >= $sd_pre_month || !is_numeric($sd_pre_month)){
		$url ='notifications.php';
		//com_redirect($url);
	}
}elseif($isSubscriptionID=='3'){
	$search_count = com_db_GetValue("select count(user_id) as cnt from " . TABLE_SEARCH_HISTORY . " where user_id='".$_SESSION['sess_user_id']."' and add_date like '".date('Y')."-".date("m")."-%'");
	$sd_pre_month = com_db_GetValue("select search_database from " . TABLE_SUBSCRIPTION . " where sub_id='".$isSubscriptionID."'");
	if($search_count >= $sd_pre_month  || !is_numeric($sd_pre_month)){
		$url ='notifications.php';
		com_redirect($url);
	}
}

// For jobs
//echo "<br>PG: ".$_REQUEST['pg'];
if(isset($_REQUEST['pg']) && $_REQUEST['pg'] =='pg'){
	//$jobs = isset($jobs) ? $_POST['jobs'] : $_SESSION['sess_jobs'];
	if(isset($_REQUEST['jobs']))
		$jobs = $_REQUEST['jobs'];
	elseif(isset($_SESSION['sess_jobs']))
		$jobs = $_SESSION['sess_jobs'];
	else
		$jobs = "";
		
}else{
	//$jobs = isset($jobs) ? $_POST['jobs'] : '';
	
	if(isset($_REQUEST['jobs']))
		$jobs = $_REQUEST['jobs'];
	else
		$jobs = "";
	
}

if(isset($_REQUEST['pg']) && $_REQUEST['pg'] =='pg'){
	//$jobs = isset($jobs) ? $_POST['jobs'] : $_SESSION['sess_jobs'];
	if(isset($_REQUEST['fundings']))
		$fundings = $_REQUEST['fundings'];
	elseif(isset($_SESSION['sess_fundings']))
		$fundings = $_SESSION['sess_fundings'];
	else
		$fundings = "";
		
}else{
	//$jobs = isset($jobs) ? $_POST['jobs'] : '';
	
	if(isset($_REQUEST['fundings']))
		$fundings = $_REQUEST['fundings'];
	else
		$fundings = "";
	
}

//echo "<pre>_REQUEST: ";	print_r($_REQUEST);	echo "</pre>";
//echo "<br>Jobs in post ONE: ".$_POST['jobs'];
//echo "<br>Jobs in post TWO: ".$jobs;
//die();
$jobs_join = "";
$jobs_join_condition = "";

$fundings_join = "";
$fundings_join_condition = "";

//$jobs = 1;
if($jobs == 1)
{
	//$jobs_join_table = TABLE_COMPANY_JOB_INFO." as cj, ";
	$jobs_join_condition = " and cm.company_id = cj.company_id"; 
	$job_select = "cj.job_title as job_title,cj.add_date as job_add_date,";
}

if($fundings == 1)
{
	//$jobs_join_table = TABLE_COMPANY_JOB_INFO." as cj, ";
	$fundings_join_condition = " and cm.company_id = cf.company_id"; 
	$job_select = "";
}

if($jobs == 1)
{
	 $main_query = "select cj.job_title as title,cm.company_name, cm.company_website,cj.add_date as job_add_date,i.title as company_industry from "
	 .TABLE_COMPANY_MASTER. " as cm, " 
	 .TABLE_INDUSTRY." as i, "
	 .TABLE_COMPANY_JOB_INFO." as cj
	where (cm.industry_id=i.industry_id and cm.company_id = cj.company_id)";
	 
}
else
{
    $funding_select = "";
    if($fundings == 1)
    {
        //date of funding, amount, and url
        $funding_select = ",cf.funding_date as funding_date,cf.funding_amount as funding_amount,cf.funding_source as funding_Source";   
    }
    
    
    
 $main_query = "select mm.move_id,mm.title,mm.announce_date,mm.what_happened,mm.movement_url,mm.effective_date,mm.announce_date,mm.headline,mm.movement_type,mm.full_body,mm.short_url,mm.more_link,
				pm.personal_id,pm.first_name,pm.middle_name,pm.last_name,pm.email,pm.phone,pm.about_person,cm.company_name,
				cm.company_website,cm.address,cm.address2,cm.city,cm.zip_code,cm.phone as cphone,
				cm.fax,cm.about_company,m.name as movement_name,so.source as source,cm.company_urls,
				s.short_name as state,ct.countries_name as country,i.title as company_industry,
				r.name as company_revenue,e.name as company_employee".$funding_select." from " 
				.TABLE_MOVEMENT_MASTER. " as mm, "
				.TABLE_PERSONAL_MASTER. " as pm, "
				.TABLE_COMPANY_MASTER. " as cm, " 
				.TABLE_MANAGEMENT_CHANGE." as m, "
				.TABLE_SOURCE." as so, "
				.TABLE_STATE." as s, "
				.TABLE_COUNTRIES." as ct, "
				.TABLE_INDUSTRY." as i, "
				.TABLE_REVENUE_SIZE." as r, "
				;
			if($jobs == 1)
			{
				$main_query .= TABLE_COMPANY_JOB_INFO." as cj, ";
			}
			if($fundings == 1)
			{
				$main_query .= TABLE_COMPANY_FUNDING." as cf, ";
			}			
		$main_query .= TABLE_EMPLOYEE_SIZE." as e    
				where (mm.company_id=cm.company_id and mm.personal_id=pm.personal_id and mm.status ='0' and mm.movement_type=m.id and mm.source_id=so.id ".$jobs_join_condition.$fundings_join_condition.") 
				and (cm.state=s.state_id and cm.country=ct.countries_id and cm.industry_id=i.industry_id and cm.company_revenue=r.id and cm.company_employee=e.id) and pm.status = 0";	
}	
	
	
	//echo "<br>main_query: ".$main_query;		die();			
$action =isset($_REQUEST['action']) ? $_REQUEST['action'] : $_SESSION['sess_action'];
$pg =isset($_REQUEST['pg']) ? $_REQUEST['pg'] : '';
if($action=='AdvanceSearch'){
	$first_name = $_POST['first_name'];
	$first_name = isset($first_name) ? $_POST['first_name'] : $_SESSION['sess_first_name'];
	$last_name = $_POST['last_name'];
	$last_name = isset($last_name) ? $_POST['last_name'] : $_SESSION['sess_last_name'];
	$title = $_POST['title'];
	$title = isset($title) ? $_POST['title'] : $_SESSION['sess_title'];
	$management = $_POST['management'];
	if($pg =='pg'){
		$management = isset($management) ? implode(',',$_POST['management']) : $_SESSION['sess_management'];
	}else{
		$management = isset($management) ? implode(',',$_POST['management']) : '';
	}
	$country = $_POST['country'];
	if($pg =='pg'){
		$country = isset($country) ? implode(',',$_POST['country']) : $_SESSION['sess_country'];
	}else{
		$country = isset($country) ? implode(',',$_POST['country']) : '';
	}
	$state = $_POST['state'];
	if($pg =='pg'){
		$state = isset($state) ? implode(',',$_POST['state']) : $_SESSION['sess_state'];
	}else{
		$state = isset($state) ? implode(',',$_POST['state']) : '';
	}
	$city = $_POST['city'];
	$city = isset($city) ? $_POST['city'] : '';
	$zip_code = $_POST['zip_code'];
	$zip_code = isset($zip_code) ? $_POST['zip_code'] : '';
	$company = $_POST['company'];
	$company = isset($company) ? $_POST['company'] : '';
	$company_website = $_REQUEST['company_website'];
	$company_website = isset($company_website) ? $_REQUEST['company_website'] : '';
	$industry = $_POST['industry'];
	//echo "<br>company_website: ".$company_website;
        
        $company_website_pgint = "";
        $company_website_pgint = "&company_website=".$company_website;
        
        
        if($pg =='pg'){
		$industry = isset($industry) ? implode(',',$_POST['industry']) : $_SESSION['sess_industry'];
	}else{
		$industry = isset($industry) ? implode(',',$_POST['industry']) : '';
	}
	$revenue_size = $_POST['revenue_size'];
	if($pg =='pg'){
		$revenue_size = isset($revenue_size) ? implode(',',$_POST['revenue_size']) : $_SESSION['sess_revenue_size'];
	}else{
		$revenue_size = isset($revenue_size) ? implode(',',$_POST['revenue_size']) : '';
	}
	$employee_size = $_POST['employee_size'];
	if($pg =='pg'){
		$employee_size = isset($employee_size) ? implode(',',$_POST['employee_size']) : $_SESSION['sess_employee_size'];
	}else{
		$employee_size = isset($employee_size) ? implode(',',$_POST['employee_size']) : '';
	}
	$speaking = $_POST['speaking'];
	if($pg =='pg'){
		$speaking = isset($speaking) ? $_POST['speaking'] : $_SESSION['sess_speaking'];
	}else{
		$speaking = isset($speaking) ? $_POST['speaking'] : '';
	}
	$awards = $_POST['awards'];
	if($pg =='pg'){
		$awards = isset($awards) ? $_POST['awards'] : $_SESSION['sess_awards'];
	}else{
		$awards = isset($awards) ? $_POST['awards'] : '';
	}
	$publication = $_POST['publication'];
	if($pg =='pg'){
		$publication = isset($publication) ? $_POST['publication'] : $_SESSION['sess_publication'];
	}else{
		$publication = isset($publication) ? $_POST['publication'] : '';
	}
	$media_mentions = $_POST['media_mentions'];
	if($pg =='pg'){
		$media_mentions = isset($media_mentions) ? $_POST['media_mentions'] : $_SESSION['sess_media_mentions'];
	}else{
		$media_mentions = isset($media_mentions) ? $_POST['media_mentions'] : '';
	}
	$board = $_POST['board'];
	if($pg =='pg'){
		$board = isset($board) ? $_POST['board'] : $_SESSION['sess_board'];
	}else{
		$board = isset($board) ? $_POST['board'] : '';
	}
	$time_period = $_POST['time_period'];
	$time_period = isset($time_period) ? $_POST['time_period'] : $_SESSION['sess_time_period'];
	$from_date = $_POST['from_date'];
	$adv_from_date = isset($from_date) ? $_POST['from_date'] : $_SESSION['sess_from_date'];
	$to_date = $_POST['to_date'];
	$adv_to_date = isset($to_date) ? $_POST['to_date'] : $_SESSION['sess_to_date'];
	
	if($time_period !='' && $time_period !='Any Date Range' ){
		
		if($time_period == '8'){
			$fd = explode('/', $adv_from_date);//mm/dd/yyyy
			$td = explode('/',$adv_to_date);
			$from_date = $fd[2].'-'.$fd[0].'-'.$fd[1];//yyyy/mm/dd
			$to_date = $td [2].'-'.$td [0].'-'.$td [1];
		}else{
			if($time_period=='1'){//In the Last Day
				$from_date = date('Y-m-d',mktime(0,0,0,date("m"),date("d")-1,date("Y")));
				$to_date = date('Y-m-d',mktime(0,0,0,date("m"),date("d")-1,date("Y")));
			}elseif($time_period=='2'){//In the Last Week
				$from_date = date('Y-m-d', mktime(0,0,0,date("m"),date("d")-6-date('N', mktime(0, 0, 0, date("m"), date("d"), date("Y"))),date("Y")));
				$to_date = date('Y-m-d', mktime(0,0,0,date("m"),date("d")-date('N', mktime(0, 0, 0, date("m"), date("d"), date("Y"))),date("Y")));
			}elseif($time_period=='3'){//In the Last 1 Month
				$from_date = date('Y-m-d',mktime(0,0,0,date("m")-1,1,date("Y")));
				$to_date = date('Y-m-d',mktime(0,0,0,date("m")-1,date('t'),date("Y")));
			}elseif($time_period=='4'){//In the Last 3 Months
				$from_date = date('Y-m-d',mktime(0,0,0,date("m")-3,1,date("Y")));
				$to_date = date('Y-m-d',mktime(0,0,0,date("m")-1,date('t'),date("Y")));
			}elseif($time_period=='5'){//In the Last 6 Months
				$from_date = date('Y-m-d',mktime(0,0,0,date("m")-6,1,date("Y")));
				$to_date = date('Y-m-d',mktime(0,0,0,date("m")-1,date('t'),date("Y")));
			}elseif($time_period=='6'){//In the Last Year
				$from_date = date('Y-m-d',mktime(0,0,0,1,1,date("Y")-1));
				$to_date = date('Y-m-d',mktime(0,0,0,12,31,date("Y")-1));
			}elseif($time_period=='7'){//In the Last 2 Years
				$from_date =  date('Y-m-d',mktime(0,0,0,1,1,date("Y")-2));
				$to_date = date('Y-m-d',mktime(0,0,0,12,31,date("Y")-1));
			}	
			
		}
	}
	
	$awardsQuery = "select distinct(personal_id) from ".TABLE_PERSONAL_AWARDS	." where personal_id>0 and status=0";
	$awardsResult = com_db_query($awardsQuery);
	$awardsStr = '';
	while($aRow = com_db_fetch_array($awardsResult)){
		if ($awardsStr==''){
			$awardsStr = $aRow['personal_id'];
		}else{
			$awardsStr .= ','.$aRow['personal_id'];
		}
	}
	$boardQuery = "select distinct(personal_id) from ".TABLE_PERSONAL_BOARD." where personal_id>0 and status=0";
	$boardResult = com_db_query($boardQuery);
	$boardStr = '';
	while($bRow = com_db_fetch_array($boardResult)){
		if ($boardStr==''){
			$boardStr = $bRow['personal_id'];
		}else{
			$boardStr .= ','.$bRow['personal_id'];
		}
	}
	
	$mediaQuery = "select distinct(personal_id) from ".TABLE_PERSONAL_MEDIA_MENTION." where personal_id>0 and status=0";
	$mediaResult = com_db_query($mediaQuery);
	$mediaStr = '';
	while($mRow = com_db_fetch_array($mediaResult)){
		if ($mediaStr==''){
			$mediaStr = $mRow['personal_id'];
		}else{
			$mediaStr .= ','.$mRow['personal_id'];
		}
	}
	$publicationQuery = "select distinct(personal_id) from ".TABLE_PERSONAL_PUBLICATION." where personal_id>0 and status=0";
	$publicationResult = com_db_query($publicationQuery);
	$pubStr = '';
	while($pRow = com_db_fetch_array($publicationResult)){
		if ($pubStr==''){
			$pubStr = $pRow['personal_id'];
		}else{
			$pubStr .= ','.$pRow['personal_id'];
		}
	}
	if($time_period !='' && $time_period !='Any Date Range'){
		$speakingQuery = "select distinct(personal_id) from ".TABLE_PERSONAL_SPEAKING." where personal_id>0 and event_date >= '" . $from_date . "' and event_date <= '" . $to_date . "' and status=0";
	}else{
		$speakingQuery = "select distinct(personal_id) from ".TABLE_PERSONAL_SPEAKING." where personal_id>0 and event_date>'".date("Y-m-d")."' and status=0";
	}
	$speakingResult = com_db_query($speakingQuery);
	$speakingStr = '';
	while($sRow = com_db_fetch_array($speakingResult)){
		if ($speakingStr==''){
			$speakingStr = $sRow['personal_id'];
		}else{
			$speakingStr .= ','.$sRow['personal_id'];
		}
	}

	
	$all_str='';
	if($first_name !=''){
		$all_str = " pm.first_name = '" . $first_name . "'";
	}
	if($last_name !=''){
		if($all_str == ''){
			$all_str = " pm.last_name = '" . $last_name . "'";
		}else{
			$all_str .= " and pm.last_name = '" . $last_name . "'";
		}	
	}
	if($title !=''){
		if($all_str == ''){
			$all_str = " mm.title = '" . $title . "'";
		}else{
			$all_str .= " and mm.title = '" . $title . "'";
		}	
	}
	
	if($management!='' && $management!='Any'){
		$management_now = explode(',',$management);
		$management_str='';
		for($mm=0;$mm<sizeof($management_now);$mm++){
			if($management_now[$mm] !=''){
				if($management_str ==''){
					$management_str .= " ( mm.movement_type = '" . $management_now[$mm] . "'";
				}else{
					$management_str .= " or mm.movement_type = '" . $management_now[$mm] . "'";
				}
			}		
		}
		if($management_str !=''){
			$management_str .=' ) ';
		}
		
		if($all_str == ''){
			$all_str = $management_str;
		}else{
			$all_str .= " and ". $management_str;
		}	
	}
	
	if($country!='' && $country!='Any'){
		$country_now = explode(',',$country);
		$country_str='';
		for($cc=0;$cc<sizeof($country_now);$cc++){
			if($country_now[$cc] !=''){
				if($country_str ==''){
					$country_str .= " ( cm.country = '" . $country_now[$cc] . "'";
				}else{
					$country_str .= " or cm.country = '" . $country_now[$cc] . "'";
				}
			}		
		}
		if($country_str !=''){
			$country_str .=' ) ';
		}
		
		if($all_str == ''){
			$all_str = $country_str;
		}else{
			$all_str .= " and " . $country_str;
		}	
	}
	if($state!='' && $state!='Any' ){
		$state_now = explode(',',$state);
		$state_str='';
		for($ss=0;$ss<sizeof($state_now);$ss++){
			if($state_now[$ss] !=''){
				if($state_str ==''){
					$state_str .= " ( cm.state = '" . $state_now[$ss] . "'";
				}else{
					$state_str .= " or cm.state = '" . $state_now[$ss] . "'";
				}
			}		
		}
		if($state_str !=''){
			$state_str .=' ) ';
		}
		if($all_str == ''){
			$all_str =  $state_str ;
		}else{
			$all_str .= " and ". $state_str ;
		}	
	}
	
	if($city !='' ){
		if($all_str == ''){
			$all_str = " cm.city = '" . $city . "'";
		}else{
			$all_str .= " and cm.city = '" . $city . "'";
		}	
	}
	if($zip_code !='' ){
		if($all_str == ''){
			$all_str = " cm.zip_code = '" . $zip_code . "'";
		}else{
			$all_str .= " and cm.zip_code = '" . $zip_code . "'";
		}	
	}
	if($company!='e.g. Microsoft' && $company !='' ){
		if($all_str == ''){
			$all_str = " cm.company_name like '" . $company . "%'";
		}else{
			$all_str .= " and cm.company_name like '" . $company . "%'";
		}	
	}
        //echo "<br>company_website two : ".$company_website;
	if($company_website !='')
        {
            //echo "<br>withinin if two";
            $rep   = array("\r\n", "\n","\r");
            $company_website	= str_replace($rep, "<br />", $_REQUEST['company_website']);
            
            
            if(strpos($company_website,"<br />") > 0)
            {
                //echo "<br>in if two";
                $webArr = explode("<br />",$company_website);
                //echo "<pre>webArr";   print_r($webArr);   echo "</pre>";
                $webStr='';
                for($wb=0; $wb < sizeof($webArr); $wb++)
                {
                    if($webArr[$wb] !='')
                    {
                        if($webStr =='')
                        {
                            //$webStr = " (cm.company_website like '%".$webArr[$wb]."') ";
                            $webStr = " (cm.company_website like '%".$webArr[$wb]."' OR cm.company_urls like '%".$webArr[$wb]."%') ";
                        }
                        else
                        {
                            //$webStr .= " or (cm.company_website like '%".$webArr[$wb]."') ";
                            $webStr .= " or (cm.company_website like '%".$webArr[$wb]."' OR cm.company_urls like '%".$webArr[$wb]."%') ";
                        }
                    }
                }
            }
            elseif($company_website != '')
            {    
                //echo "<br>in elseif";
                //$webStr = $company_website;
                $webStr = " (cm.company_website like '%".$company_website."' OR cm.company_urls like '%".$company_website."%') ";
            } 
            
            
            
            /*
            $webArr = explode("<br />",$company_website);
            $webStr='';
            for($wb=0; $wb < sizeof($webArr); $wb++)
            {
                if($webArr[$wb] !=''){
                        if($webStr ==''){
                              $webStr = " (cm.company_website like '%".$webArr[$wb]."') ";
                        }else{
                              $webStr .= " or (cm.company_website like '%".$webArr[$wb]."') ";
                        }
                }
              }
             */
              if($webStr !=''){
                     if($all_str==''){
                             $all_str =" (".$webStr.")";
                     }else{
                             $all_str .=" and (".$webStr.")";
                     }
              } 
	  }
	  $engagementStr='';
	 if($awards ==1 && $awardsStr !=''){
		 if($engagementStr==''){
			 $engagementStr =" pm.personal_id in (".$awardsStr.")";
		 }else{
			 $engagementStr .=" or pm.personal_id in (".$awardsStr.")";
		 }
	  }
	  if($board ==1 && $boardStr !=''){
		 if($engagementStr==''){
			 $engagementStr =" pm.personal_id in (".$boardStr.")";
		 }else{
			 $engagementStr .=" or pm.personal_id in (".$boardStr.")";
		 }
	  }
	  if($media_mentions ==1 && $mediaStr !=''){
		 if($engagementStr==''){
			 $engagementStr =" pm.personal_id in (".$mediaStr.")";
		 }else{
			 $engagementStr .=" or pm.personal_id in (".$mediaStr.")";
		 }
	  }
	  if($publication ==1 && $pubStr !=''){
		 if($engagementStr==''){
			 $engagementStr =" pm.personal_id in (".$pubStr.")";
		 }else{
			 $engagementStr .=" or pm.personal_id in (".$pubStr.")";
		 }
	  }
	  if($speaking ==1 && $speakingStr !=''){
		 if($engagementStr==''){
			 $engagementStr =" pm.personal_id in (".$speakingStr.")";
		 }else{
			 $engagementStr .=" or pm.personal_id in (".$speakingStr.")";
		 }
	  }
	  if($all_str == '' && $engagementStr!=''){
	  		$all_str = " (".$engagementStr.") ";
	  }elseif($engagementStr!=''){
	  		$all_str .= " and (".$engagementStr.") ";
	  }
	  
	if($industry!='' && $industry!='Any' ){
		$industry_now = explode(',',$industry);
		$industry_str='';
		for($ii=0;$ii<sizeof($industry_now);$ii++){
			if($industry_now[$ii] !=''){
				if($industry_str ==''){
					$industry_str .= " ( cm.industry_id = '" . $industry_now[$ii] . "'";
				}else{
					$industry_str .= " or cm.industry_id = '" . $industry_now[$ii] . "'";
				}
			}		
		}
		if($industry_str !=''){
			$industry_str .=' ) ';
		}
		
		if($all_str == ''){
			$all_str = $industry_str;
		}else{
			$all_str .= " and " .$industry_str;
		}	
	}

	if($revenue_size!='' && $revenue_size!='Any' ){
		$revenue_size_now = explode(',',$revenue_size);
		$revenue_size_str='';
		for($ii=0;$ii<sizeof($revenue_size_now);$ii++){
			if($revenue_size_now[$ii] !=''){
				if($revenue_size_str ==''){
					$revenue_size_str .= " ( cm.company_revenue = '" . $revenue_size_now[$ii] . "'";
				}else{
					$revenue_size_str .= " or cm.company_revenue = '" . $revenue_size_now[$ii] . "'";
				}
			}		
		}
		if($revenue_size_str !=''){
			$revenue_size_str .=' ) ';
		}
		
		if($all_str == ''){
			$all_str = $revenue_size_str;
		}else{
			$all_str .= " and " .$revenue_size_str;
		}
	}
	if($employee_size!='' && $employee_size!='Any'){
		$employee_size_now = explode(',',$employee_size);
		$employee_size_str='';
		for($ii=0;$ii<sizeof($employee_size_now);$ii++){
			if($employee_size_now[$ii] !=''){
				if($employee_size_str ==''){
					$employee_size_str .= " ( cm.company_employee = '" . $employee_size_now[$ii] . "'";
				}else{
					$employee_size_str .= " or cm.company_employee = '" . $employee_size_now[$ii] . "'";
				}
			}		
		}
		if($employee_size_str !=''){
			$employee_size_str .=' ) ';
		}
		
		if($all_str == ''){
			$all_str = $employee_size_str;
		}else{
			$all_str .= " and " .$employee_size_str;
		}
	}
	
	if($time_period !='' && $time_period !='Any Date Range' && $speaking !=1){
		
		/*if($time_period == '8'){
			$fd = explode('/', $adv_from_date);//mm/dd/yyyy
			$td = explode('/',$adv_to_date);
			$from_date = $fd[2].'-'.$fd[0].'-'.$fd[1];//yyyy/mm/dd
			$to_date = $td [2].'-'.$td [0].'-'.$td [1];
		}else{
			if($time_period=='1'){//In the Last Day
				$from_date = date('Y-m-d',mktime(0,0,0,date("m"),date("d")-1,date("Y")));
				$to_date = date('Y-m-d',mktime(0,0,0,date("m"),date("d")-1,date("Y")));
			}elseif($time_period=='2'){//In the Last Week
				$from_date = date('Y-m-d', mktime(0,0,0,date("m"),date("d")-6-date('N', mktime(0, 0, 0, date("m"), date("d"), date("Y"))),date("Y")));
				$to_date = date('Y-m-d', mktime(0,0,0,date("m"),date("d")-date('N', mktime(0, 0, 0, date("m"), date("d"), date("Y"))),date("Y")));
			}elseif($time_period=='3'){//In the Last 1 Month
				$from_date = date('Y-m-d',mktime(0,0,0,date("m")-1,1,date("Y")));
				$to_date = date('Y-m-d',mktime(0,0,0,date("m")-1,date('t'),date("Y")));
			}elseif($time_period=='4'){//In the Last 3 Months
				$from_date = date('Y-m-d',mktime(0,0,0,date("m")-3,1,date("Y")));
				$to_date = date('Y-m-d',mktime(0,0,0,date("m")-1,date('t'),date("Y")));
			}elseif($time_period=='5'){//In the Last 6 Months
				$from_date = date('Y-m-d',mktime(0,0,0,date("m")-6,1,date("Y")));
				$to_date = date('Y-m-d',mktime(0,0,0,date("m")-1,date('t'),date("Y")));
			}elseif($time_period=='6'){//In the Last Year
				$from_date = date('Y-m-d',mktime(0,0,0,1,1,date("Y")-1));
				$to_date = date('Y-m-d',mktime(0,0,0,12,31,date("Y")-1));
			}elseif($time_period=='7'){//In the Last 2 Years
				$from_date =  date('Y-m-d',mktime(0,0,0,1,1,date("Y")-2));
				$to_date = date('Y-m-d',mktime(0,0,0,12,31,date("Y")-1));
			}	
			
		}*/
		
		if($all_str == ''){
			$all_str = " mm.announce_date >= '" . $from_date . "' and mm.announce_date <= '" . $to_date . "'";
		}else{
			$all_str .= " and mm.announce_date >= '" . $from_date . "' and mm.announce_date <= '" . $to_date . "'";
		}	
	}
	
	if($all_str != ''){
		 $sql_query = $main_query." and ".$all_str;
	}else{
		 $sql_query = $main_query;
	}
	//echo $sql_query; die();
}elseif($action =='Search'){

	$industry = $_POST['industry'];
	$revenue = $_POST['revenue'];
	$employee = $_POST['employee'];
	$state_id = $_POST['state_id'];
	
	if(count($industry)>0){
		$list_ind = implode(",",$industry);
		
		$ind_result = com_db_query("select industry_id from ".TABLE_INDUSTRY." where parent_id in(" .$list_ind.")");
		$all_ind='';
		while($indRow = com_db_fetch_array($ind_result)){
			if($all_ind == ''){
				$all_ind = $indRow['industry_id'];
			}else{
				$all_ind .= ','.$indRow['industry_id'];
			}
		}
		
		if($all_ind == ''){
			$all_ind = $list_ind;
		}else{
			$all_ind .= ','.$all_ind;
		}
	}
	
	//revenue
	$rev = explode("#",$revenue);
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
	
	//echo $rev_list;
	
	//employee
	if($employee !=''){
		$emp = explode("#",$employee);
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
		//$emp_list;
	}
	if(count($state_id)>0){
		$list_state = implode(",",$state_id);
	}
	
	$searchString='';	
	if($all_ind !=''){
		$searchString = " c.industry_id in (".$all_ind.") ";
	}
	if($rev_list !=''){
		if($searchString ==''){
			$searchString = " c.company_revenue in (".$rev_list.") ";
		}else{
			$searchString .= " and c.company_revenue in (".$rev_list.") ";
		}	
	}
	if($emp_list !=''){
		if($searchString ==''){
			$searchString = " c.company_employee in (".$emp_list.") ";
		}else{
			$searchString .= " and c.company_employee in (".$emp_list.") ";
		}	
	}
	if($list_state !=''){
		if($searchString ==''){
			$searchString = " c.state in (".$list_state.") ";
		}else{
			$searchString .= " and c.state in (".$list_state.") ";
		}	
	}
	if($searchString==''){
		 $sql_query = $main_query;
	}else{
		 $sql_query = $main_query . ' and '. $searchString;
	}	
	//echo $sql_query;
	
}elseif($action =='Industry'){
	$IndGroupID = ($_REQUEST['IndGroupID']) ? $_REQUEST['IndGroupID'] : $_SESSION['sess_IndGroupID'];
	$sql_query = $main_query ." and cm.ind_group_id = '".$IndGroupID. "'";
	$industry = com_db_GetVAlue("select title from " . TABLE_INDUSTRY." where industry_id='".$IndGroupID."' and status ='0'");
}elseif($action =='Geography'){
	$stateName = ($_REQUEST['stateName']) ? $_REQUEST['stateName'] : $_SESSION['sess_stateName'];
	$sql_query = $main_query ." and cm.state = '".$stateName."' ";
	$state = $stateName;
}elseif($action =='Title'){
	$titleName = ($_REQUEST['titleName']) ? $_REQUEST['titleName'] : $_SESSION['sess_titleName'];
	if($titleName=='Other'){
		 $title_result = com_db_query("select * from " . TABLE_TITLE . " where title<>'Other' order by title");
		 $title_list='';
		 while($title_row = com_db_fetch_array($title_result)){
		   $tot_cnt = com_db_GetValue("select count(move_id) as cnt from " . TABLE_MOVEMENT_MASTER . " where status='0' and title = '". $title_row['title']."'");
		   if($title_list==''){
				$title_list = "'". $title_row['title']."'";
		   }else{
				$title_list .= ",'". $title_row['title']."'";
		   }
		 }  
		$sql_query = $main_query ." and mm.title not in (".$title_list.")";   
	}else{
		$sql_query = $main_query ." and mm.title = '".$titleName."'";
	}				
	$title = $titleName;
}elseif($action =='Revenue_Size'){
	$rev_size_id = ($_REQUEST['rev_size_id']) ? $_REQUEST['rev_size_id'] : $_SESSION['sess_rev_size_id'];
	$sql_query = $main_query ." and cm.company_revenue = '".$rev_size_id."'";
}elseif($action =='Employee_Size'){
	$emp_size_id = ($_REQUEST['emp_size_id']) ? $_REQUEST['emp_size_id'] : $_SESSION['sess_emp_size_id'];
	$sql_query = $main_query ." and cm.company_employee = '".$emp_size_id."'";
}elseif($action =='Time_Period'){
	$from = ($_REQUEST['from']) ? $_REQUEST['from'] : $_SESSION['sess_from'];
	$to = ($_REQUEST['to']) ? $_REQUEST['to'] : $_SESSION['sess_to'];
	$sql_query = $main_query ." and mm.announce_date >= '".$from."' and mm.announce_date <='".$to."'";
}




//echo $sql_query; die();
$_SESSION['sess_action'] = $action;
$_SESSION['sess_first_name'] = $first_name;
$_SESSION['sess_last_name'] = $last_name;
$_SESSION['sess_title'] = $title;
$_SESSION['sess_management'] = $management;
$_SESSION['sess_country'] = $country;	
$_SESSION['sess_state'] = $state;
$_SESSION['sess_city'] = $city;
$_SESSION['sess_zip_code'] = $zip_code;
$_SESSION['sess_company'] = $company;

$_SESSION['sess_company_website'] = $company_website;
$_SESSION['sess_speaking'] = $speaking;
$_SESSION['sess_awards'] = $awards;
$_SESSION['sess_publication'] = $publication;
$_SESSION['sess_media_mentions'] = $media_mentions;
$_SESSION['sess_board'] = $board;

$_SESSION['sess_industry'] = $industry;
$_SESSION['sess_revenue_size'] = $revenue_size;
$_SESSION['sess_employee_size'] = $employee_size;
$_SESSION['sess_time_period'] = $time_period;
$_SESSION['sess_txtsearch'] = $txtsrc;
$_SESSION['sess_IndGroupID'] = $IndGroupID;
$_SESSION['sess_stateName'] = $stateName;
$_SESSION['sess_titleName'] = $titleName;
$_SESSION['sess_emp_size_id'] = $emp_size_id;
$_SESSION['sess_rev_size_id'] = $rev_size_id;
$_SESSION['sess_from'] = $from;
$_SESSION['sess_to'] = $to;
$_SESSION['sess_from_date'] = $adv_from_date;
$_SESSION['sess_to_date'] = $adv_to_date;

$_SESSION['sess_jobs'] = $jobs;
$_SESSION['sess_fundings'] = $fundings;


$sql_query_down = $sql_query;
/***************** FOR PAGIN ***********************/
$starting_point = $items_per_page * ($p - 1);
/****************** END PAGIN ***********************/
$main_page = 'search-result.php';

//$exe_query=com_db_query($sql_query);

$sql_query .= ' and pm.ciso_user = 1';

//echo "<br>sql_query: ".$sql_query;
//die();
$exe_query = mysqli_query($link,$sql_query);

if($exe_query === false)
{
    //echo "<br>In if";
    //echo "<br>Error"; die();
    $num_rows = 0;
}
else
{
    //echo "<br>In else";
    $num_rows = com_db_num_rows($exe_query);
    //echo "<br>num_rows: ".$num_rows;
    $total_data = $num_rows;
    $tot_search_result = $num_rows;
}    
//die();
if($num_rows == 0){
	if($action =='AdvanceSearch'){
		$url = 'advance-search.php?burl=advance-search.php&search_msg=Result Not Found';
		com_redirect($url);
	}elseif($action =='Search'){
		$url = 'index.php?burl=index.php&search_msg=Result Not Found';
		com_redirect($url);
	}elseif($action =='Industry' || $action =='Geography' || $action=='Title' || $action == 'Employee_Size' || $action == 'Revenue_Size' || $action == 'Time_Period'){
		$url = 'browse.php?burl=browse.php&search_msg=Result Not Found';
		com_redirect($url);
	}
}

if($_SESSION['sess_user_id'] !='' && ($action =='AdvanceSearch' || $action =='Search')){
	$user_id = $_SESSION['sess_user_id'];
	$search_type = $action;
	$add_date = date('Y-m-d');
	if($first_name=='Type in the first name'){ $first_name='';}
	if($last_name=='Type in the last name'){ $last_name='';}
	if($title=='Type in the title'){ $title='';}
	if($city=='Type in the City'){ $city='';}
	if($zip_code=='Type in the Zip code'){ $zip_code='';}
	if($company=='Type in the Company Name'){ $company='';}
	if($time_period=='Any'){ $time_period='';}
	if($txtsrc == "Type in CTO/CIO's name, company, title ... ..."){ $search_string ='';}else{$search_string = $txtsrc;}
		$search_history = "insert into ". TABLE_SEARCH_HISTORY . " (user_id,search_type,search_string,first_name,last_name,title,management,country,state,city,zip_code,company,company_website,industry,revenue_size,employee_size,speaking,awards,publication,media_mention,board,time_period,from_date,to_date,tot_search_result,add_date)
		values('$user_id','$search_type','$search_string','$first_name','$last_name','$title','$management','$country','$state','$city','$zip_code','$company','$company_website','$industry','$revenue_size','$employee_size','$speaking','$awards','$publication','$media_mentions','$board','$time_period','$from_date','$to_date','$tot_search_result','$add_date')";
		com_db_query($search_history);
}elseif($_SESSION['sess_user_id'] =='' && ($action =='AdvanceSearch' || $action =='Search')){
	$user_id = 0;//visitors // not user
	$search_type = $action;
	$add_date = date('Y-m-d');
	if($first_name=='Type in the first name'){ $first_name='';}
	if($last_name=='Type in the last name'){ $last_name='';}
	if($title=='Type in the title'){ $title='';}
	if($city=='Type in the City'){ $city='';}
	if($zip_code=='Type in the Zip code'){ $zip_code='';}
	if($company=='Type in the Company Name'){ $company='';}
	if($time_period=='Any'){ $time_period='';}
	if($txtsrc == "Type in CTO/CIO's name, company, title ... ..."){ $search_string ='';}else{$search_string = $txtsrc;}
	
        
        if($speaking == '')
            $speaking = 0;
        if($publication == '')
            $publication = 0;
        if($media_mentions == '')
            $media_mentions = 0;
        if($board == '')
            $board = 0;
        if($from_date == '')
            $from_date = null;
        if($to_date == '')
            $to_date = null;
        if($time_period == '')
            $time_period = 0;
        
        
        
        
        $session_id = com_session_id();	
	$search_history = "insert into ". TABLE_SEARCH_HISTORY_VISITORS . " (user_id,search_type,search_string,first_name,last_name,title,management,country,state,city,zip_code,company,company_website,industry,revenue_size,employee_size,speaking,awards,publication,media_mention,board,time_period,from_date,to_date,tot_search_result,session_id,add_date)
	values('$user_id','$search_type','$search_string','$first_name','$last_name','$title','$management','$country','$state','$city','$zip_code','$company','$company_website','$industry','$revenue_size','$employee_size','$speaking','$awards','$publication','$media_mentions','$board','$time_period','$from_date','$to_date','$tot_search_result','$session_id','$add_date')";
	com_db_query($search_history);
}
/************ FOR PAGIN **************/
if($fld==''){
	$sql_query .= " LIMIT $starting_point,$items_per_page";
}else{
	$sql_query .= " order by ".$fld." LIMIT $starting_point,$items_per_page";
}

$exe_data = com_db_query($sql_query);

$numRows = com_db_num_rows($exe_data);
/************ END ********************/


include(DIR_INCLUDES."header-content-page.php");
?>	
<input type="hidden" name="hid_jobs" id="hid_jobs" value="<?=$jobs?>">
<div class="search-results">
    <div class="page-head">
        <div class="shell">
            <div class="head-buttons clearfix">
                <?PHP if($_SESSION['sess_is_user'] == 1){
                    $isPaidUser = com_db_GetValue("select level from " .TABLE_USER." where user_id='".$_SESSION['sess_user_id']."'");
					
                ?>
                <ul class="clearfix">
                    <li>
                        <form name="frmResultDownload" method="post" action="download-result.php?action=fromTop">
                            <input type="hidden" name="txtquery" value="<?=$sql_query_down?>" />
                            <input type="hidden" name="selected_contact_list" id="selected_contact_list" />
                            <input type="hidden" name="engagement_triggers" id="engagement_triggers" value="<?PHP if($engagementStr !=''){echo 'Yes';}else{echo 'No';} ?>" />
                            <a href="javascript:ResultDownload();" class="ico-download">Download Results</a>
                        </form>
                    </li>
                    <li><a href="<?=HTTP_SERVER?>alert.php?actionEmail=SearchResult" class="ico-clock">Set Up as an Alert</a></li>
                    <li><a href="<?=HTTP_SERVER?>advance-search.php" class="ico-search">New Search</a></li>
                    <li>
                        <form name="frmSearchEdit" method="post" action="advance-search.php?action=SearchEdit">
                            <input type="hidden" name="first_name" value="<?=$first_name?>" />
                            <input type="hidden" name="last_name" value="<?=$last_name?>" />
                            <input type="hidden" name="title" value="<?=$title?>" />
                            <input type="hidden" name="management" value="<?=$management?>" />
                            <input type="hidden" name="country" value="<?=$country?>" />
                            <input type="hidden" name="state" value="<?=$state?>" />
                            <input type="hidden" name="city" value="<?=$city?>" />
                            <input type="hidden" name="zip_code" value="<?=$zip_code?>" />
                            <input type="hidden" name="company" value="<?=$company?>" />
                            <input type="hidden" name="company_website" value="<?=$company_website?>" />
                            <input type="hidden" name="industry" value="<?=$industry?>" />
                            <input type="hidden" name="revenue_size" value="<?=$revenue_size?>" />
                            <input type="hidden" name="employee_size" value="<?=$employee_size?>" />
                            <input type="hidden" name="time_period" value="<?=$time_period?>" />
                            <input type="hidden" name="from_date" value="<?=$_POST['from_date'];?>" />
                            <input type="hidden" name="to_date" value="<?=$_POST['to_date'];?>" />
                            <input type="hidden" name="speaking" value="<?=$speaking;?>" />
                            <input type="hidden" name="awards" value="<?=$awards;?>" />
                            <input type="hidden" name="publication" value="<?=$publication;?>" />
                            <input type="hidden" name="media_mentions" value="<?=$media_mentions;?>" />
                            <input type="hidden" name="board" value="<?=$board;?>" />
                        	<a href="javascript:SearchFieldEdit();" class="ico-edit">Edit Search</a>
                            </form>
                        </li>
					</ul>
                <?PHP } elseif($_SESSION['sess_is_user'] != 1){?>  
                    <ul class="clearfix">
			<li>
                         <!--popup Download-->
                            <div id="downloadshow" class="popup-outer">
                            <div><div>to access this feature</div>
                            <div>
                                    <span class="popup-nextln">please</span>
                                    <span><a href="<?=HTTP_SERVER?>login.php" class="popup-hreflink">login </a></span>
                                    <span>or</span>
                                    <a href="<?=HTTP_SERVER?>provide-contact-information.php" class="popup-hreflink">register</a></div></div>
                            </div>
                          <!--/popup-->
                          <!--link to popup-->
                        <a href="#" class="ico-download" id="downloadbtn">Download Results</a>
                         <!--link to popup-->
						<li>
                            <!--popup Alert-->
                            <div id="downloadshow1" class="popup-outer1">
                            <div><div>to access this feature</div>
                            <div>
                                    <span class="popup-nextln1">please</span>
                                    <span><a href="<?=HTTP_SERVER?>login.php" class="popup-hreflink1">login </a></span>
                                    <span>or</span>
                                    <a href="<?=HTTP_SERVER?>provide-contact-information.php" class="popup-hreflink1">register</a></div></div>
                            </div>
                            <a href="#" class="ico-clock" id="setupalertbtn">Set Up as an Alert</a>
                          <!--/popup-->
                        </li>
			<li><a href="<?=HTTP_SERVER?>advance-search.php" class="ico-search">New Search</a></li>
			<li>
                        	<form name="frmSearchEdit" method="post" action="advance-search.php?action=SearchEdit">
                            <input type="hidden" name="first_name" value="<?=$first_name?>" />
                            <input type="hidden" name="last_name" value="<?=$last_name?>" />
                            <input type="hidden" name="title" value="<?=$title?>" />
                            <input type="hidden" name="management" value="<?=$management?>" />
                            <input type="hidden" name="country" value="<?=$country?>" />
                            <input type="hidden" name="state" value="<?=$state?>" />
                            <input type="hidden" name="city" value="<?=$city?>" />
                            <input type="hidden" name="zip_code" value="<?=$zip_code?>" />
                            <input type="hidden" name="company" value="<?=$company?>" />
                            <input type="hidden" name="company_website" value="<?=$company_website?>" />
                            <input type="hidden" name="industry" value="<?=$industry?>" />
                            <input type="hidden" name="revenue_size" value="<?=$revenue_size?>" />
                            <input type="hidden" name="employee_size" value="<?=$employee_size?>" />
                            <input type="hidden" name="time_period" value="<?=$time_period?>" />
                            <input type="hidden" name="from_date" value="<?=$_POST['from_date'];?>" />
                            <input type="hidden" name="to_date" value="<?=$_POST['to_date'];?>" />
                            <input type="hidden" name="speaking" value="<?=$speaking;?>" />
                            <input type="hidden" name="awards" value="<?=$awards;?>" />
                            <input type="hidden" name="publication" value="<?=$publication;?>" />
                            <input type="hidden" name="media_mentions" value="<?=$media_mentions;?>" />
                            <input type="hidden" name="board" value="<?=$board;?>" />
                        	<a href="javascript:SearchFieldEdit();" class="ico-edit">Edit Search</a>
                            </form>
                        </li>
					</ul>
                <?PHP } ?>    
				</div><!-- /.head-buttons -->
			</div><!-- /.shell -->
		</div><!-- /.page-head -->	
		<script type="application/javascript">
			function SearchResultSort(action){
				var hid_jobs = document.getElementById('hid_jobs').value;
				//alert("hid_jobs: "+hid_jobs); return false;
				var act_val = document.getElementById('search_order_by').value;
				var url = "search-result.php?action="+action;
				if(act_val=='Date'){
					url = url + "&fld=announce_date";
				}else if(act_val=='Name'){
					url = url + "&fld=first_name";
				}else if(act_val=='Title'){
					url = url + "&fld=title";
				}else if(act_val=='Company'){
					url = url + "&fld=company_name";
				}else if(act_val=='Type'){
					url = url + "&fld=movement_type";
				}
				
				if(hid_jobs == '1'){
					url = url + "&jobs="+hid_jobs;
				}
				
				window.location=url;
			}
		</script>
		<div class="main">
			<div class="shell">
				<div class="search-results-head clearfix">
					<h2>Search Results : <?=$starting_point?> - <?PHP if(($starting_point+$items_per_page)<=$total_data){echo $starting_point+$items_per_page;}else{echo $total_data;}?> of <?=$total_data?></h2>
					
					<div class="sort-field clearfix"><label>Sort by:</label>
					<?PHP
					if($jobs == 1)
					{
					?>
						<select name="search_order_by" id="search_order_by" onchange="SearchResultSort('<?=$action?>');">
							<option value="Date" <?PHP if($fld=='announce_date'){?> selected="selected" <?PHP } ?>>Date</option>
							<option value="Title" <?PHP if($fld=='title'){?> selected="selected" <?PHP } ?>>Title</option>
							<option value="Company" <?PHP if($fld=='company_name'){?> selected="selected" <?PHP } ?>>Company</option>
						</select>
					<?PHP
					}
					else
					{
					?>
						<select name="search_order_by" id="search_order_by" onchange="SearchResultSort('<?=$action?>');">
							<option value="Date" <?PHP if($fld=='announce_date'){?> selected="selected" <?PHP } ?>>Date</option>
							<option value="Name" <?PHP if($fld=='first_name'){?> selected="selected" <?PHP } ?>>Name</option>
							<option value="Title" <?PHP if($fld=='title'){?> selected="selected" <?PHP } ?>>Title</option>
							<option value="Company" <?PHP if($fld=='company_name'){?> selected="selected" <?PHP } ?>>Company</option>
							<option value="Type" <?PHP if($fld=='movement_type'){?> selected="selected" <?PHP } ?>>Type</option>
						</select>
					<?PHP
					}
					?>		
					</div><!-- /.sort-field -->
				</div><!-- /.search-results-head -->

				<div class="results-table">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
					
					
						<?PHP
						if($jobs == 1)
						{
						?>
						<tr>
							<th class="checkbox-holder clearfix" width="105"><input type="checkbox" name="checkboxCtrl" id="checkboxCtrl" value="checkbox" onClick="SearchResultCheckBox('<?=$numRows;?>');"/><label>Date</label></th>
							<th width="330">Title</th>
							<th width="320">Company</th>
							<th></th>
						</tr>
						<?PHP
						}
						else
						{
						?>
					
					
						<tr>
							<th class="checkbox-holder clearfix" width="105"><input type="checkbox" name="checkboxCtrl" id="checkboxCtrl" value="checkbox" onClick="SearchResultCheckBox('<?=$numRows;?>');"/><label>Date</label></th>
							<th width="140">Name</th>
							<th width="190">Title</th>
							<th width="320">Company</th>
							<th>Type</th>
						</tr>
                        <?php
						}
						if($numRows > 0){
							$i=1;
							while($search_row = com_db_fetch_array($exe_data)){
							$cID = $search_row['move_id'];
							if($i%2){
								$bgcolor ='#ededed';
							}else{
								$bgcolor ='#cbdfe8';
							}
							
		
							$dim_url = com_db_output($search_row['movement_url']);			
							
							$personal_url = com_db_output($search_row['first_name'].'_'.$search_row['last_name'].'_Exec_'.$search_row['personal_id']);
							
							
						?>
						<tr>
							
							
						<?PHP	
						
						$com_name = com_db_output($search_row['company_name']);
						if(strlen($com_name)>40)
						{
						   $com_name = substr($com_name,0,40).'...';
						}
						
						
							if($jobs == 1)
							{
									$adt = explode('-',$search_row['job_add_date']);//add_date 
									$add_date = $adt[1].'/'.$adt[2].'/'.$adt[0];
							?>
								<td class="checkbox-holder clearfix"><input type="checkbox" name="resultCheckBox[]" id="resultCheckBox_<?=$i?>" value="<?=$cID?>" onclick="SelectedCheckBoxList('<?=$numRows;?>');"/><label><?=$add_date;?></label></td>
								<td class="td-title"><?=com_db_output($search_row['title'])?></td>
								<td class="td-company">
                            	<strong>
                                	<?PHP 
										  echo $com_name;		
									?>
                            	</strong>
									<?=com_db_output($search_row['company_industry'])?></td>
								</td>
								<td></td>
							<?PHP
							}
							else
							{
								$adt = explode('-',$search_row['announce_date']);//add_date 
								$add_date = $adt[1].'/'.$adt[2].'/'.$adt[0];
							?>
							<td class="checkbox-holder clearfix"><input type="checkbox" name="resultCheckBox[]" id="resultCheckBox_<?=$i?>" value="<?=$cID?>" onclick="SelectedCheckBoxList('<?=$numRows;?>');"/><label><?=$add_date;?></label></td>
							<td><a href="<?=HTTP_SERVER?><?=$personal_url?><?PHP //=$dim_url?>"><strong><?=com_db_output($search_row['first_name'].' '.$search_row['last_name'])?></strong></a></td>
							<td class="td-title"><?=com_db_output($search_row['title'])?></td>
							<td class="td-company">
                            	<strong>
                                	<?PHP 
										  echo $com_name;		
									?>
                            	</strong>
                                <?=com_db_output($search_row['company_industry'])?></td>
                                <?PHP
								$movement_type = $search_row['movement_type'];
								$movement_name = com_db_output($search_row['movement_name']);
								if($movement_type==1){
									$movement_type_bg = 'bg-appointment';
								}elseif($movement_type==2){
									$movement_type_bg = 'bg-promotion';
								}elseif($movement_type==3){
									$movement_type_bg = 'bg-retirement';
								}elseif($movement_type==4){
									$movement_type_bg = 'bg-registration';
								}elseif($movement_type==5){
									$movement_type_bg = 'bg-termination';
								}elseif($movement_type==6){
									$movement_type_bg = 'bg-leteral';
								}elseif($movement_type==7){
									$movement_type_bg = 'bg-opening';
								}else{
									$movement_type_bg = 'bg-opening';
								}
								?>
							<td class="<?=$movement_type_bg?>"><i><?=$movement_name?></i></td>
						<?PHP
						}
						?>						
						</tr>
                        <?PHP 	$i++;
			   			} 
					}			   
			   		?> 
					</table>
				</div><!-- /.results-table -->
				<div class="pagination clearfix">
				<?php echo new_number_pages($main_page, $p, $total_data, 5, $items_per_page,'&pg=pg&fld='.$fld.'&ad='.$ad.$company_website_pgint."&action=".$_SESSION['sess_action']);?> 
                </div>   
			</div><!-- /.shell -->
		</div><!-- /.main -->		
	</div><!-- /.search-results -->
	
<?php      
include(DIR_INCLUDES."footer-content-page.php");
?>