<?php
require('includes/include_top.php');

$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 20;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$action = $_REQUEST['action'];
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';
if($action=='SearchUser'){
	$_SESSION['sess_action'] = '';
	$_SESSION['sess_from_date'] = '';
	$_SESSION['sess_to_date'] = '';	
}
if($action == 'UserAdvanceSearchResult' || $_SESSION['sess_action']=='UserAdvanceSearchResult'){
	$from_date = $_POST['from_date'];
	$to_date = $_POST['to_date'];
	
	if($from_date !='' ){
		$fd = explode('/',$from_date);
		if(strlen($from_date)==10 && is_numeric($fd[2]) && is_numeric($fd[1]) && is_numeric($fd[0])){
			$from_date = $fd[2].'-'.$fd[0].'-'.$fd[1];
		}else{
			com_redirect("user-advance-search.php?selected_menu=search&msg=" . msg_encode("Please enter valid date format ".$check));
		}	
	}
	if($to_date !=''){
		$td = explode('/',$to_date);
		if(strlen($to_date)==10 && is_numeric($td[2]) && is_numeric($td[1]) && is_numeric($td[0])){
			$to_date = $td[2].'-'.$td[0].'-'.$td[1];
		}else{
			com_redirect("user-advance-search.php?selected_menu=search&msg=" . msg_encode("Please enter valid date format"));
		}	
	}
	if($action == 'UserAdvanceSearchResult'){
		$_SESSION['sess_from_date'] = $from_date;
		$_SESSION['sess_to_date'] = $to_date;
		$_SESSION['sess_action'] = $action;
	}else{
		$from_date	= $_SESSION['sess_from_date'];
		$to_date	= $_SESSION['sess_to_date'];
	}
	
	
	if($from_date!='' && $to_date !=''){
		$search_query = "select sh.*,concat(u.first_name,' ',u.last_name) as full_name from ".TABLE_SEARCH_HISTORY." sh,".TABLE_USER." u where sh.user_id=u.user_id and sh.add_date >='".$from_date."' and sh.add_date <='".$to_date."' order by sh.add_date desc";
	}else{
		$search_query = "select sh.*,concat(u.first_name,' ',u.last_name) as full_name from ".TABLE_SEARCH_HISTORY." sh,".TABLE_USER." u where sh.user_id=u.user_id order by sh.add_date desc";
	}
	
	/***************** FOR PAGIN ***********************/
	$starting_point = $items_per_page * ($p - 1);
	/****************** END PAGIN ***********************/
	$main_page = 'user-advance-search.php';
	$sql_query = $search_query;
	$exe_query=com_db_query($sql_query);
	$num_rows=com_db_num_rows($exe_query);
	$total_data = $num_rows;
	
	/************ FOR PAGIN **************/
	$sql_query .= " LIMIT $starting_point,$items_per_page";
	$exe_data = com_db_query($sql_query);
	
	$numRows = com_db_num_rows($exe_data);
	/************ END ********************/
		
}

include("includes/header.php");
?>

<tr>
    <td align="left" valign="top" bgcolor="#FFFFFF"><table width="975" border="0" align="center" cellpadding="0" cellspacing="0">

      <tr>
		<?php
		include("includes/menu_left.php");
		?>
        <td width="10" align="left" valign="top">&nbsp;</td>
        <td width="769" align="left" valign="top">
		 <script type="text/javascript" language="javascript">
			function UserSearch(){
				window.location ='user-advance-search.php?action=SearchUser&selected_menu=search';
			}
		</script>
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right">
			  <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="32%" align="left" valign="middle" class="heading-text">User Advance Search Information</td>
				  <td width="62%" valign="middle" class="message" align="left"><?=$msg?></td>
                  <td width="6%" valign="middle" class="message" align="left"><a href="javascript:;" onclick="UserSearch();"><img src="images/search-icon.jpg" border="0" width="25" height="28"  alt="Search User" title="Search User" /></a></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box">
            <? if(($action == '' && $_SESSION['sess_action']=='') || $action == 'SearchUser'){?>
			<div id="spiffycalendar" class="text"></div>
				<link rel="stylesheet" type="text/css" href="includes/javascript/spiffyCal/spiffyCal_v2_1.css">
                
				<script language="JavaScript" src="includes/javascript/spiffyCal/spiffyCal_v2_1.js"></script>
				<script language="javascript"><!--
				  var dateAvailableFrom = new ctlSpiffyCalendarBox("dateAvailableFrom", "userSearch", "from_date","btnDate1","",scBTNMODE_CUSTOMBLUE);
				  var dateAvailableTo = new ctlSpiffyCalendarBox("dateAvailableTo", "userSearch", "to_date","btnDate2","",scBTNMODE_CUSTOMBLUE);	
				//--></script>
               	
		  		<form name="userSearch" method="post" action="user-advance-search.php?selected_menu=search&action=UserAdvanceSearchResult">
                    <table width="60%" border="0" cellspacing="0" cellpadding="5">
                       <tr><td colspan="2" height="10"></td></tr>
                       <tr>
                        <td colspan="2"><b><span class="heading-text">Advance Search Date</span></b></td>
                       </tr>
                       <tr>
                         <td align="left" valign="top" class="page-text">&nbsp;From Date:</td>
                         <td align="left" valign="top" class="page-text"><input type="text" name="from_date" id="from_date" size="12" value="" />
                                <a href="javascript:NewCssCal('from_date','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a> (mm/dd/yyyy)	</td>
                        </tr>
                        <tr>
                         <td align="left" valign="top" class="page-text">&nbsp;To Date:</td>
                         <td align="left" valign="top" class="page-text"> <input type="text" name="to_date" id="to_date" size="12" value="" />
                                <a href="javascript:NewCssCal('to_date','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a> (mm/dd/yyyy)</td>
                        </tr>
                       <tr>
                         <td>&nbsp;</td>
                         <td align="left" valign="top">&nbsp;</td>
                         </tr>
                       <tr>
                         <td>&nbsp;</td>
                         <td align="left" valign="top"><input type="submit" name="Submit" value="Search Result" class="submitButton" /></td>
                         </tr>
                       <tr>
                         <td>&nbsp;</td>
                         <td align="left" valign="top">&nbsp;</td>
                         </tr>
                    </table>
				</form>
                <? }elseif($action == 'UserAdvanceSearchResult' || $_SESSION['sess_action']=='UserAdvanceSearchResult'){ ?>
                	<table width="100%" border="0" cellspacing="3" cellpadding="3">
                      <tr><td colspan="4">&nbsp;</td></tr>
                      <tr>
                      	<td width="1%" bgcolor="#CCCCCC"><b><span class="heading-text">Sl.No</span></b></td>
                        <td width="14%" bgcolor="#CCCCCC"><b><span class="heading-text">User Name</span></b></td>
                        <td width="71%" bgcolor="#CCCCCC"><b><span class="heading-text">Search Information</span></b></td>
                        <td width="" bgcolor="#CCCCCC"><b><span class="heading-text">Tot. Result</span></b></td>
                      </tr>
                      <? while($sRow=com_db_fetch_array($exe_data)){ 
					  		$s++;
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
								$searchStr = 'All';
							}
							
							if($sRow['tot_search_result']>0){
								$tot_search_result = $sRow['tot_search_result'];
							}else{
								$tot_search_result ='';
							}
						
					  ?>
                      <tr>
                         <td valign="top" align="right"><?=$s;?></td>
                         <td valign="top"><?=com_db_output($sRow['full_name']);?></td>
                         <td valign="top"><?=com_db_output($searchStr);?></td>
                         <td valign="top" align="right"><?=$tot_search_result;?></td>
                       </tr>
                      <? } ?>  
                       <tr><td colspan="4">&nbsp;</td></tr>
                       <tr>
                       	<td colspan="4">
                        	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="666" align="right" valign="top"><table width="200" border="0" align="right" cellpadding="0" cellspacing="0">
                                  <tr>
                                <?php echo number_pages($main_page, $p, $total_data, 8, $items_per_page,'&selected_menu=search');?>		  
                                  </tr>
                                </table></td>
                                <td width="314" align="center" valign="bottom">&nbsp;</td>
                              </tr>
                            </table>
                       	</td>
                       </tr>
                    </table>
				<? } ?>
			</td>
          </tr>
        </table>
		
        </td>
      </tr>
    </table></td>
  </tr>	 
		
 <?php
include("includes/footer.php");
?> 