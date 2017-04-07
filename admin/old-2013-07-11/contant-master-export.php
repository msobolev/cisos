<?php
require('includes/include_top.php');

$action = $_REQUEST['action'];
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';
if($action == 'ContactExport'){
	$company_revenue = $_POST['company_revenue'];
	$company_employee = $_POST['company_employee'];
	$state	= $_POST['state']; 
	$industry	= $_POST['industry']; 
	
	
	require('php_xls.php');
	
	$xls=new PHP_XLS();             //create excel object
	$xls->AddSheet('sheet 1');      //add a work sheet
	
	$xls->SetActiveStyle('center');
	
	$xls->Text(2,1,"Contact Data : Download");
	$xls->Text(4,1,"Company Name");
	$xls->Text(4,2,"Company Website");
	$xls->Text(4,3,"Company Size Revenue");
	$xls->Text(4,4,"Company Size Employees");
	$xls->Text(4,5,"Industry");
	$xls->Text(4,6,"Email Pattern");
	$xls->Text(4,7,"Leadership Page");
	$xls->Text(4,8,"Address");
	$xls->Text(4,9,"Address 2");
	$xls->Text(4,10,"City");
	$xls->Text(4,11,"Country");
	$xls->Text(4,12,"State");
	$xls->Text(4,13,"Zip Code");
	$xls->Text(4,14,"About Company");
	
	
	$download_query_string = "select c.company_name,c.company_website,r.name as company_revenue,e.name as company_employee,
							i.title as company_industry,c.ind_group_id,c.industry_id,c.leadership_page,c.email_pattern,c.address,c.address2,c.city,s.short_name as state,
							ct.countries_name as country,c.zip_code,c.about_company,c.add_date from " 
							.TABLE_CONTACT_MASTER. " as c, " 
							.TABLE_REVENUE_SIZE." as r, "
							.TABLE_EMPLOYEE_SIZE." as e, "
							.TABLE_INDUSTRY." as i, "
							.TABLE_STATE." as s, "
							.TABLE_COUNTRIES." as ct  
							where c.company_revenue=r.id and c.company_employee=e.id and c.company_industry=i.industry_id and c.state=s.state_id and c.country=ct.countries_id and  c.status='0'";
	
	$download_query='';
	if($company_revenue!=''){
		$download_query .= " c.company_revenue = '".$company_revenue."'";
	}
	if($company_employee!=''){
		if($download_query==''){
			$download_query .= " c.company_employee = '".$company_employee."'";
		}else{
			$download_query .= " and c.company_employee = '".$company_employee."'";
		}	
	}
	if($industry!=''){
		if($download_query==''){
			$download_query .= " c.industry_id ='".$industry."'";
		}else{
			$download_query .= " and c.industry_id ='".$industry."'";
		}	
	}

	if(is_array($state) && $state !=''){
		$state_list = implode(",",$state);
		if($state_list !=''){
			if($download_query==''){
				$download_query .= " c.state in (".$state_list.")";
			}else{
				$download_query .= " and c.state in (".$state_list.")";
			}	
		}
	}
		
	if($download_query ==''){
		$download_query = $download_query_string;
	}else{
		$download_query = $download_query_string." and ".$download_query;
	}
		//echo $download_query;	
		$result=com_db_query($download_query);
	   
		$xlsRow = 5;
		while($download_row=com_db_fetch_array($result)) {
			$company_name = str_replace(',',';',com_db_output($download_row['company_name']));
			$company_website = str_replace(',',';',com_db_output($download_row['company_website']));
			$company_employee = str_replace(',',';',com_db_output($download_row['company_employee']));
			$company_revenue = str_replace(',',';',com_db_output($download_row['company_revenue']));
			$parent_industry =  str_replace(',',';',com_db_GetValue("select title from ".TABLE_INDUSTRY." where industry_id='".$download_row['ind_group_id']."'"));
			$company_industry = $parent_industry.' : '. str_replace(',',';',com_db_output($download_row['company_industry']));
			$leadership_page = str_replace(',',';',com_db_output($download_row['leadership_page']));
			$email_pattern = str_replace(',',';',com_db_output($download_row['email_pattern']));
			$address = str_replace(',',';',com_db_output($download_row['address']));
			$address2 = str_replace(',',';',com_db_output($download_row['address2']));
			$city = str_replace(',',';',com_db_output($download_row['city']));
			$state = str_replace(',',';',com_db_output($download_row['state']));
			$zip_code = str_replace(',',';',com_db_output($download_row['zip_code']));
			$country = str_replace(',',';',com_db_output($download_row['country']));
			$about_company = str_replace(',',';',com_db_output($download_row['about_company']));
				
			$xls->Text($xlsRow,1,"$company_name");
			$xls->Text($xlsRow,2,"$company_website");
			$xls->Text($xlsRow,3,"$company_revenue");
			$xls->Text($xlsRow,4,"$company_employee");
			$xls->Text($xlsRow,5,"$company_industry");
			$xls->Text($xlsRow,6,"$email_pattern");
			$xls->Text($xlsRow,7,"$leadership_page");
			$xls->Text($xlsRow,8,"$address");
			$xls->Text($xlsRow,9,"$address2");
			$xls->Text($xlsRow,10,"$city");
			$xls->Text($xlsRow,11,"$country");
			$xls->Text($xlsRow,12,"$state");
			$xls->Text($xlsRow,13,"$zip_code");
			$xls->Text($xlsRow,14,"$about_company");
			
			$xlsRow++;
			}
		$xls->Output('download-contact-'. date('m-d-Y') . '.xls');	
		com_redirect("contact-export.php?selected_menu=master&msg=" . msg_encode("Contacts download successfully"));

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
	
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right">
			  <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="18%" align="left" valign="middle" class="heading-text">Export .XLS file</td>
				  <td width="82%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box">
			
		  <form name="exportfile" method="post" action="contant-master-export.php?action=ContactExport">
		  
			<table width="90%" border="0" cellspacing="0" cellpadding="5">
			  <tr><td colspan="2" height="20">&nbsp;</td></tr>
			  <tr>
                <td align="left" valign="top">Company Size ($ Revenue):</td>
                <td align="left" valign="top">
                    <select name="company_revenue" id="company_revenue"/>
                        <option value="">All</option>
                        <?=selectComboBox("select id,name from ".TABLE_REVENUE_SIZE." where status='0' order by from_range",'')?>
                    </select>	
                </td>
              </tr>
              <tr>
                <td align="left" valign="top">Company Size (Employees):</td>
                <td align="left" valign="top">
                    <select name="company_employee" id="company_employee" />
                        <option value="">All</option>
                        <?=selectComboBox("select id,name from ".TABLE_EMPLOYEE_SIZE." where status='0' order by from_range",'')?>
                    </select>	
                </td>
              </tr>
              <tr>
                <td align="left" valign="top">Industry:</td>
                <td align="left" valign="top">
                    <?php
                    $industry_result = com_db_query("select * from " . TABLE_INDUSTRY ." where status='0' and parent_id = '0' order by title");
                    ?>
                    <select name="industry" id="industry" >
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
				 <td align="left" valign="top" class="page-text">State:</td>
				 <td align="left" valign="top" class="page-text">
				 	<select name="state[]" id="state" multiple="multiple" style="width:127px;">
					<option value="">All</option>
					<?=selectComboBox("select state_id,short_name from ". TABLE_STATE ." order by short_name" ,"");?>
					</select>
				 </td>
			   </tr>
			   <tr>
			     <td>&nbsp;</td>
			     <td align="left" valign="top">&nbsp;</td>
			     </tr>
			   <tr>
			     <td>&nbsp;</td>
			     <td align="left" valign="top"><input type="submit" name="Submit" value="Export Contant" class="submitButton" /></td>
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
    </table></td>
  </tr>	 
		
 <?php
include("includes/footer.php");
?> 