<?php
// https://www.ctosonthemove.com/admin/invoice-static-settings.php?action=edit
require('includes/include_top.php');
$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 20;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';


$sql_query = "select * from " . TABLE_BANNED_DOMAIN . " order by domain_id desc";
/***************** FOR PAGIN ***********************/
$starting_point = $items_per_page * ($p - 1);
/****************** END PAGIN ***********************/
$main_page = 'invoice-settings.php';

$exe_query=com_db_query($sql_query);
$num_rows=com_db_num_rows($exe_query);
$total_data = $num_rows;

/************ FOR PAGIN **************/
$sql_query .= " LIMIT $starting_point,$items_per_page";
$exe_data = com_db_query($sql_query);

$numRows = com_db_num_rows($exe_data);
/************ END ********************/


$dID = (isset($_GET['iID']) ? $_GET['iID'] : $select_data[0]);


include("includes/header.php");
?>
<script type="text/javascript">


</script>

 <tr>
    <td align="left" valign="top" bgcolor="#FFFFFF">
        <table width="975" border="0" align="center" cellpadding="0" cellspacing="0">

            <tr>
            <?php
            include("includes/menu_left.php");
            ?>
                
                <link rel="stylesheet" type="text/css" href="includes/javascript/spiffyCal/spiffyCal_v2_1.css">
		<script language="JavaScript" src="includes/javascript/spiffyCal/spiffyCal_v2_1.js"></script>
		<script language="javascript"><!--
		  var dateAvailableFrom = new ctlSpiffyCalendarBox("dateAvailableFrom", "frmSearch", "from_date","btnDate1","",scBTNMODE_CUSTOMBLUE);
		  var dateAvailableTo = new ctlSpiffyCalendarBox("dateAvailableTo", "frmSearch", "to_date","btnDate2","",scBTNMODE_CUSTOMBLUE);	
		//--></script>
                
                
		<td width="10" align="left" valign="top">&nbsp;</td>
                <td width="769" align="left" valign="top">
                    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                            <td align="center" valign="middle" class="right">
                                <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="19%" align="left" valign="middle" class="heading-text">Company Search</td>
                                        <td width="51%" valign="middle" class="message" align="left"><?=$msg?></td>
                                        <td width="3%" align="right" valign="middle">
                                        <!-- <a href="#"> 
                                            <img src="images/search-icon.jpg" border="0" width="25" height="28"  alt="Search Company" title="Search Company" onclick="CompanySearch('CompanySearch');"  />-->
                                        <a href="company-search.php?selected_menu=master"> 
                                            <img src="images/search-icon.jpg" border="0" width="25" height="28"  alt="Search Company" title="Search Company"   />
                                        </a>
                                        </td>
                                        <td width="6%" align="left" valign="middle" class="nav-text">Search</td>
                                        <?PHP if($btnAdd=='Yes'){ ?>
                                        <td width="4%" align="right" valign="middle"><a href="#"><img src="images/add-icon.jpg" border="0" width="25" height="28" alt="Add Company" title="Add Company" onclick="window.location='company-master.php?action=add&selected_menu=master'"  /></a></td>
                                        <td width="7%" align="left" valign="middle" class="nav-text">Add New </td>
                                        <?PHP }
                                                        if($btnDelete=='Yes'){ ?>
                                        <td width="4%" align="right" valign="middle"><a href="#"><img src="images/delete-icon.jpg" border="0" width="25" height="28"  alt="Delete Company" title="Delete Company" onclick="AllDelete('<?=$numRows?>');"  /></a></td>
                                        <td width="6%" align="left" valign="middle" class="nav-text">Delete</td>
                                        <?PHP } ?>    
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" valign="top" class="right-bar-content-border-box">
                                <table width="100%" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td align="left" valign="top" class="right-border-box">
                                        <!--start iner table  -->
                                            <table width="95%" align="left" cellpadding="5" cellspacing="5" border="0">
                                            <form name="frmSearch" id="frmSearch" method="post" action="company-master.php?selected_menu=master&action=CompanySearchResult">
		
                                                <tr>
                                                    <td width="30%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Company Name:</td>
                                                    <td width="66%" align="left" valign="top">
                                                        <input name="search_company_name" id="search_company_name" />
                                                    </td>	
                                                </tr>
		
                                                <tr>
                                                    <td width="30%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Company Url:</td>
                                                    <td width="66%" align="left" valign="top">
                                                        <input name="search_company_url" id="search_company_url" />
                                                    </td>	
                                                </tr>
		
                                                <tr>
                                                    <td width="30%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Industry:</td>
                                                    <td width="66%" align="left" valign="top">
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
                                                                <?PHP } ?>

                                                        </select>
                                                    </td>	
                                                </tr>

                                                <tr>
                                                    <td width="30%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;State:</td>
                                                    <td width="66%" align="left" valign="top">
                                                        <select name="search_state" id="search_state" >
                                                            <option value="">All</option>
                                                            <?=selectComboBox("select state_id,short_name from ". TABLE_STATE ." where country_id ='223'" ,"");?>
                                                        </select>
                                                    </td>	
                                                </tr>
		
                                                <tr>
                                                    <td width="30%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Country:</td>
                                                    <td width="66%" align="left" valign="top">
                                                        <select name="search_country" id="search_country" >
                                                                <option value="">All</option>
                                                                <?=selectComboBox("select countries_id,countries_name from ". TABLE_COUNTRIES ." where countries_name='United States'" ,"");?>
                                                                <?=selectComboBox("select countries_id,countries_name from ". TABLE_COUNTRIES ." order by countries_name" ,"");?>
                                                        </select>
                                                    </td>	
                                                </tr>

                                                <tr>
                                                    <td width="30%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Date Entered:</td>
                                                    <td width="66%" align="left" valign="top">
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
                                                    <td width="30%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Size ($ Revenue):</td>
                                                    <td width="66%" align="left" valign="top">
                                                        <select name="search_company_revenue" id="search_company_revenue"/>
                                                                <option value="">All</option>
                                                                                <?=selectComboBox("select id,name from ".TABLE_REVENUE_SIZE." where status='0' order by from_range",'')?>
                                                        </select>	
                                                    </td>	
                                                </tr>

                                                <tr>
                                                    <td width="30%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;Size (Employees):</td>
                                                    <td width="66%" align="left" valign="top">
                                                        <select name="search_company_employee" id="search_company_employee" />
                                                                <option value="">All</option>
                                                                                <?=selectComboBox("select id,name from ".TABLE_EMPLOYEE_SIZE." where status='0' order by from_range",'')?>
                                                        </select>	
                                                    </td>	
                                                </tr>


		
                                                <tr>
                                                    <td align="left" valign="top">&nbsp;</td>
                                                    <td align="left" valign="top">
                                                        <input type="submit" value="Search" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='company-master.php?selected_menu=master'" />
                                                    </td>
                                                </tr>
                                            </form>
                                            </table>
                                            <!-- end inner table -->
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
          </tr>
        </table>		
		
  	  		
<?php

include("includes/footer.php");
?>