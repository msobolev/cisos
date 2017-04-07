<?php
//ini_set('display_errors', 1);

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 216000);
ini_set('upload_max_filesize', '6M');

require('includes/include_top.php');

$action = $_REQUEST['action'];
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';
if($action == 'ContactExport')
{ 
    require('php_xls.php');
	
    $xls=new PHP_XLS();             //create excel object
    $xls->AddSheet('sheet 1');      //add a work sheet

    $xls->SetActiveStyle('center');
	
    $xls->Text(2,1,"Company Data : Download");
    $xls->Text(4,1,"Company Name");
    $xls->Text(4,2,"Company Website");
    $xls->Text(4,3,"Email Domain");
    $xls->Text(4,4,"Email Pattern");
		
    $download_query = "select c.company_name,c.company_website,c.email_domain,c.email_pattern_id from " .TABLE_COMPANY_MASTER. " as c  where email_pattern_id > 0";
							 
    $result=com_db_query($download_query);
    $xlsRow = 5;
    while($download_row=com_db_fetch_array($result)) 
    {
        $company_name = str_replace(',',';',com_db_output($download_row['company_name']));
        $company_website = str_replace(',',';',com_db_output($download_row['company_website']));
        $email_domain = str_replace(',',';',com_db_output($download_row['email_domain']));
        $email_pattern_id = str_replace(',',';',com_db_output($download_row['email_pattern_id']));

        $xls->Text($xlsRow,1,"$company_name");
        $xls->Text($xlsRow,2,"$company_website");

        $xls->Text($xlsRow,3,"$email_domain");
        $xls->Text($xlsRow,4,"$email_pattern_id");
			
        $xlsRow++;
    }
    $xls->Output('download-company-pattern-'. date('m-d-Y') . '.xls');	
    com_redirect("company-master-exportpattern.php?selected_menu=master&msg=" . msg_encode("Companies download successfully"));

}

include("includes/header.php");
?>

<tr>
    <td align="left" valign="top" bgcolor="#FFFFFF">
        <table width="975" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
		<?php
		include("includes/menu_left.php");
		?>
                <td width="10" align="left" valign="top">&nbsp;</td>
                <td width="769" align="left" valign="top">
	
                    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                            <td align="center" valign="middle" class="right">
                                <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="18%" align="left" valign="middle" class="heading-text">Export .XLS file</td>
                                        <td width="82%" valign="middle" class="message" align="left"><?=$msg?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" valign="top" class="right-bar-content-border-box">

                                <form name="exportfile" method="post" action="company-master-export-pattern.php?action=ContactExport">
                                    <table width="90%" border="0" cellspacing="0" cellpadding="5">
                                        <tr><td colspan="2" height="20">&nbsp;</td></tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td align="left" valign="top"><input type="submit" name="Submit" value="Export Companies with pattern" class="submitButton" /></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td align="left" valign="top">&nbsp;</td>
                                        </tr>
                                    </table>
                                </form>
                            </td>
                        </tr>
                    </table>
		
                </td>
            </tr>
        </table>
    </td>
</tr>	 
		
 <?php
include("includes/footer.php");
?> 