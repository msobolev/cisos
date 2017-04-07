<?php
require('../includes/configuration.php');
include('../includes/only_dataentry_include-top.php');

$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 20;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';

	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CTOsOnTheMove.com</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="../images/favicon.jpg" type="image/x-icon" />
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="only-dataentry.js"></script>
  
<script type="text/javascript" src="../js/datetimepicker_css.js" language="javascript"></script>  

<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="selectuser.js" language="javascript"></script>
</head>
<body>
<table width="1002" border="0" align="center" cellpadding="0" cellspacing="0">

  <tr>
    <td width="21" align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">
        <table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center" valign="top" class="top-header-bg">
                <table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top">
                        <? include_once("includes/top-menu.php"); ?>
                    </td>
                  </tr>
                  <tr>
                    <td align="center" valign="top"><table width="928" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="196" align="left" valign="top"><a href="company.php"><img src="<?=HTTP_SERVER.DIR_WS_HTTP_FOLDER.DIR_IMAGES?>logo.jpg"  alt="Logo" width="196" height="32" border="0" title="Logo" /></a></td>
                        <td width="478" align="left" valign="top">&nbsp;</td>
                        <td width="254" align="right" valign="top" >
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="login-register-text"><a href="#"><strong><?=$_SESSION['user_login_name']?></strong></a> | <a href="logout.php"><strong>Logout</strong></a>				</tr>
                            </table>
                        </td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                   <td align="left" valign="top" class="caption-text">We Enable You to Sell More IT Faster by Providing Unique, Responsive and Actionable Sales Leads</td>
                  </tr>
                  <tr>
                    <td align="right" valign="top">
                        <table width="95%" height="33" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="81%" align="center" valign="middle"><span class="right-box-title-text"><?=$msg?></span></td>
                              
                              <td width="3%" align="right" valign="middle"><a href="#"><img src="images/search-icon.jpg" border="0" width="25" height="28"  alt="Search Contact" title="Search Contact" onclick="CompanySearch('CompanySearch');"  /></a></td>
                              <td width="5%" align="left" valign="middle" class="nav-text">Search</td>
                              <td align="left" valign="middle"><a href="#"><img src="images/folder-icon.jpg" border="0" width="22" height="22" alt="Directory" title="Directory" onclick="window.location='company.php?action=Directory'"  /></a></td>
                              <td align="left" valign="middle" class="nav-text">Directory</td>
                              <td width="3%" align="right" valign="middle"><a href="#"><img src="<?=HTTP_SERVER.DIR_WS_HTTP_FOLDER.DIR_IMAGES?>add-icon.jpg" border="0" width="25" height="28" alt="Add Contact" title="Add Contact" onclick="window.location='company.php?action=add'"  /></a></td>
                              <td width="8%" align="left" valign="middle" class="nav-text">Add New</td>
                            </tr>
                        </table>
                    </td>
                  </tr>
                </table>
            </td>
          </tr>
        </table>
    </td>
    <td width="21" align="left" valign="top">&nbsp;</td>
  </tr>
  
    <tr>
      <td align="left"  valign="top">&nbsp;</td>
      <td align="center" valign="top"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center" valign="top"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td align="left" valign="middle" class="advance-search-page-heading-bg"><table width="960" border="0" align="left" cellpadding="0" cellspacing="0">
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="middle" class="press-release-page-title-text">Company : </td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><img src="<?=HTTP_SERVER.DIR_WS_HTTP_FOLDER.DIR_IMAGES?>specer.gif" width="1" height="10" alt="" title="" /></td>
                  </tr>
              
              </table></td>
            </tr>
          </table></td>
        </tr>
		
		
		
		
		
		
		
		
		
		
<div id="spiffycalendar" class="text"></div>
		<link rel="stylesheet" type="text/css" href="includes/javascript/spiffyCal/spiffyCal_v2_1.css">
		<script language="JavaScript" src="includes/javascript/spiffyCal/spiffyCal_v2_1.js"></script>
		<script language="javascript">
		  var dateAvailableFrom = new ctlSpiffyCalendarBox("dateAvailableFrom", "frmSearch", "from_date","btnDate1","",scBTNMODE_CUSTOMBLUE);
		  var dateAvailableTo = new ctlSpiffyCalendarBox("dateAvailableTo", "frmSearch", "to_date","btnDate2","",scBTNMODE_CUSTOMBLUE);	
		</script>
		<form name="frmSearch" id="frmSearch" method="post" action="company.php?action=SearchResult">
		<table width="100%" border="0" align="center" cellpadding="1" cellspacing="1">
		  <tr>
			<td align="left" colspan="2" valign="top">
				<!-- <img src="images/specer.gif" width="1" height="50" alt="" title="" />  -->
			</td>
		  </tr>
          <tr><td colspan="2">&nbsp;</td></tr>
		  <tr>
			<td align="left" valign="top" >Company Name:</td>
			<td align="left" valign="top"><input name="search_company_name" id="search_company_name" /></td>
		  </tr>
		  <tr>
			<td align="left" valign="top">Company Url:</td>
			<td align="left" valign="top"><input name="search_company_url" id="search_company_url" /></td>
		  </tr>
		  
		  <tr>
			<td align="left" valign="top">Industry:</td>
			<td align="left" valign="top">
				<?php
				$industry_result = com_db_query("select * from " . TABLE_INDUSTRY ." where status='0' and parent_id = '0' order by title");
				?>
				<select name="search_industry" id="search_industry" >
					<option value="">All</option>
					<?php
					while($indus_row = com_db_fetch_array($industry_result)){
					?>
					<optgroup label="<?=$indus_row['title']?>">
					<?=selectComboBox("select industry_id,title from ". TABLE_INDUSTRY ." where status='0' and parent_id ='".$indus_row['industry_id']."' order by title" ,"");?>
					</optgroup>
					<? } ?>
					
				</select>
			</td>
		  </tr>
		  <tr>
			<td align="left" valign="top">State:</td>
			<td align="left" valign="top">
				<select name="search_state" id="search_state" >
					<option value="">All</option>
					<?=selectComboBox("select state_id,short_name from ". TABLE_STATE ." where country_id ='223'" ,"");?>
				</select>	
			</td>
		  </tr>
          <tr>
			<td align="left" valign="top">Country:</td>
			<td align="left" valign="top">
				<select name="search_country" id="search_country" >
					<option value="">All</option>
					<?=selectComboBox("select countries_id,countries_name from ". TABLE_COUNTRIES ." where countries_name='United States'" ,"");?>
					<?=selectComboBox("select countries_id,countries_name from ". TABLE_COUNTRIES ." order by countries_name" ,"");?>
				</select>	
			</td>
		  </tr>
		  
		  <tr>
			<td align="left" valign="top">Date Entered:</td>
			<td align="left" valign="top">
				From:<script language="javascript">dateAvailableFrom.writeControl(); dateAvailableFrom.dateFormat="MM/dd/yyyy";</script>
			</td>
		  </tr>
		   <tr>
			<td align="center" valign="top">&nbsp;</td>
			<td align="left" valign="top">
				To:&nbsp;&nbsp;&nbsp;<script language="javascript">dateAvailableTo.writeControl(); dateAvailableTo.dateFormat="MM/dd/yyyy";</script>
			</td>
		  </tr>
		  
		  <tr>
			<td align="left" valign="top">Size ($ Revenue):</td>
			<td align="left" valign="top">
				<select name="search_company_revenue" id="search_company_revenue"/>
                	<option value="">All</option>
					<?=selectComboBox("select id,name from ".TABLE_REVENUE_SIZE." where status='0' order by from_range",'')?>
                </select>	
			</td>
		  </tr>
          <tr>
			<td align="left" valign="top">Size (Employees):</td>
			<td align="left" valign="top">
				<select name="search_company_employee" id="search_company_employee" />
                	<option value="">All</option>
					<?=selectComboBox("select id,name from ".TABLE_EMPLOYEE_SIZE." where status='0' order by from_range",'')?>
                </select>	
			</td>
		  </tr>
		   <tr>
			<td align="center" valign="top">&nbsp;</td>
			<td align="center" valign="top">&nbsp;</td>
		  </tr>
		  <tr>
			<td align="center" valign="top">&nbsp;</td>
		  	<td align="left" valign="top"><input type="submit" value="Search" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='company.php'" /></td>
		  </tr>
		  <tr>
			<td align="center" valign="top">&nbsp;</td>
			<td align="center" valign="top">&nbsp;</td>
		  </tr>
		</table>
		</form>
		
		
		
		
		
		
		
		
		
		
		<? include_once("includes/footer-menu.php"); ?>
    
    <tr>
      <td align="left"  valign="top">&nbsp;</td>
      <td align="left" valign="top">
        <table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td align="center" valign="top" class="copyright-text">Copyright &copy; 2010 CTOsOnTheMove. All rights reserved.</td>
          </tr>
          <tr>
            <td align="center" valign="top">&nbsp;</td>
          </tr>
        </table>
      </td>
      <td align="left"  valign="top">&nbsp;</td>
    </tr>
</table>

</body>
</html>
