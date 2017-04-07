<?php
//ini_set('display_errors', 1);

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 216000);
ini_set('upload_max_filesize', '6M');


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
	
	
	$dsv = $_POST['dsv'];
	
	if($dsv == 1)
	{
		$xls->Text(2,1,"Contact Data : Download");
		$xls->Text(4,1,"Company ID");
		$xls->Text(4,2,"Company Name");
		$xls->Text(4,3,"Company Website");
		$xls->Text(4,5,"Company Size Revenue");
		$xls->Text(4,6,"Company Size Employees");
		$xls->Text(4,7,"Industry");
		$xls->Text(4,14,"State");
		
		$download_query_string = "select c.company_id,c.company_name,c.company_website,r.name as company_revenue,e.name as company_employee,
							i.title as company_industry,c.ind_group_id,c.industry_id,c.address,c.address2,c.city,s.short_name as state
							 from " 
							.TABLE_COMPANY_MASTER. " as c, " 
							.TABLE_REVENUE_SIZE." as r, "
							.TABLE_EMPLOYEE_SIZE." as e, "
							.TABLE_INDUSTRY." as i, "
							.TABLE_STATE." as s
							where c.company_revenue=r.id and c.company_employee=e.id and c.company_industry=i.industry_id and c.state=s.state_id and  c.status='0'";
		
	}
	else
	{
	
		$xls->Text(2,1,"Contact Data : Download");
		$xls->Text(4,1,"Company ID");
		$xls->Text(4,2,"Company Name");
		$xls->Text(4,3,"Company Website");
		$xls->Text(4,4,"Company Logo");
		$xls->Text(4,5,"Company Size Revenue");
		$xls->Text(4,6,"Company Size Employees");
		$xls->Text(4,7,"Industry");
		$xls->Text(4,8,"Email Pattern");
		$xls->Text(4,9,"Leadership Page");
		$xls->Text(4,10,"Address");
		$xls->Text(4,11,"Address 2");
		$xls->Text(4,12,"City");
		$xls->Text(4,13,"Country");
		$xls->Text(4,14,"State");
		$xls->Text(4,15,"Zip Code");
		$xls->Text(4,16,"Phone");
		$xls->Text(4,17,"Fax");
		$xls->Text(4,18,"About Company");
		$xls->Text(4,19,"Facebook Link");
		$xls->Text(4,20,"Linkedin Link");
		$xls->Text(4,21,"Twitter Link");
		$xls->Text(4,22,"Google+ Link");
		
		
		$download_query_string = "select c.company_id,c.company_name,c.company_website,c.company_logo,r.name as company_revenue,e.name as company_employee,
							i.title as company_industry,c.ind_group_id,c.industry_id,c.leadership_page,c.email_pattern,c.address,c.address2,c.city,s.short_name as state,
							ct.countries_name as country,c.zip_code,c.phone,c.fax,c.about_company,c.facebook_link,c.linkedin_link,c.twitter_link,c.googleplush_link,c.add_date from " 
							.TABLE_COMPANY_MASTER. " as c, " 
							.TABLE_REVENUE_SIZE." as r, "
							.TABLE_EMPLOYEE_SIZE." as e, "
							.TABLE_INDUSTRY." as i, "
							.TABLE_STATE." as s, "
							.TABLE_COUNTRIES." as ct  
							where c.company_revenue=r.id and c.company_employee=e.id and c.company_industry=i.industry_id and c.state=s.state_id and c.country=ct.countries_id and  c.status='0'";
	
		
		
	}
	
	
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
		
		
			if($dsv == 1)
			{
				$company_id = str_replace(',',';',com_db_output($download_row['company_id']));
				$company_name = str_replace(',',';',com_db_output($download_row['company_name']));
				$company_website = str_replace(',',';',com_db_output($download_row['company_website']));
				$company_employee = str_replace(',',';',com_db_output($download_row['company_employee']));
				
				$company_revenue = str_replace(',',';',com_db_output($download_row['company_revenue']));
				$parent_industry =  str_replace(',',';',com_db_GetValue("select title from ".TABLE_INDUSTRY." where industry_id='".$download_row['ind_group_id']."'"));
				$company_industry = $parent_industry.' : '. str_replace(',',';',com_db_output($download_row['company_industry']));
				
				$state = str_replace(',',';',com_db_output($download_row['state']));
				
				$xls->Text($xlsRow,1,"$company_id");	
				$xls->Text($xlsRow,2,"$company_name");
				$xls->Text($xlsRow,3,"$company_website");
				
				$xls->Text($xlsRow,5,"$company_revenue");
				$xls->Text($xlsRow,6,"$company_employee");
				$xls->Text($xlsRow,7,"$company_industry");
				
				$xls->Text($xlsRow,14,"$state");
			}
			else
			{
		
		
				$company_id = str_replace(',',';',com_db_output($download_row['company_id']));
				$company_name = str_replace(',',';',com_db_output($download_row['company_name']));
				$company_website = str_replace(',',';',com_db_output($download_row['company_website']));
				$company_employee = str_replace(',',';',com_db_output($download_row['company_employee']));
				$company_logo = str_replace(',',';',com_db_output($download_row['company_logo']));
				$company_revenue = str_replace(',',';',com_db_output($download_row['company_revenue']));
				$parent_industry =  str_replace(',',';',com_db_GetValue("select title from ".TABLE_INDUSTRY." where industry_id='".$download_row['ind_group_id']."'"));
				$company_industry = $parent_industry.' : '. str_replace(',',';',com_db_output($download_row['company_industry']));
				$leadership_page = str_replace(',',';',com_db_output($download_row['leadership_page']));
				$email_pattern = str_replace(',',';',com_db_output($download_row['email_pattern']));
				$address = str_replace(',',';',com_db_output($download_row['address']));
				$address2 = str_replace(',',';',com_db_output($download_row['address2']));
				$city = str_replace(',',';',com_db_output($download_row['city']));
				$state = str_replace(',',';',com_db_output($download_row['state']));
				$country = str_replace(',',';',com_db_output($download_row['country']));
				$zip_code = str_replace(',',';',com_db_output($download_row['zip_code']));
				$phone = str_replace(',',';',com_db_output($download_row['phone']));
				$fax = str_replace(',',';',com_db_output($download_row['fax']));
				$about_company = str_replace(',',';',strip_tags($download_row['about_company']));
				$facebook_link = str_replace(',',';',com_db_output($download_row['facebook_link']));
				$linkedin_link = str_replace(',',';',com_db_output($download_row['linkedin_link']));
				$twitter_link = str_replace(',',';',com_db_output($download_row['twitter_link']));
				$googleplush_link = str_replace(',',';',com_db_output($download_row['googleplush_link']));
				

			
				$xls->Text($xlsRow,1,"$company_id");	
				$xls->Text($xlsRow,2,"$company_name");
				$xls->Text($xlsRow,3,"$company_website");
				$xls->Text($xlsRow,4,"$company_logo");
				$xls->Text($xlsRow,5,"$company_revenue");
				$xls->Text($xlsRow,6,"$company_employee");
				$xls->Text($xlsRow,7,"$company_industry");
				$xls->Text($xlsRow,8,"$email_pattern");
				$xls->Text($xlsRow,9,"$leadership_page");
				$xls->Text($xlsRow,10,"$address");
				$xls->Text($xlsRow,11,"$address2");
				$xls->Text($xlsRow,12,"$city");
				$xls->Text($xlsRow,13,"$country");
				$xls->Text($xlsRow,14,"$state");
				$xls->Text($xlsRow,15,"$zip_code");
				$xls->Text($xlsRow,16,"$phone");
				$xls->Text($xlsRow,17,"$fax");
				$xls->Text($xlsRow,18,"$about_company");
				$xls->Text($xlsRow,19,"$facebook_link");
				$xls->Text($xlsRow,20,"$linkedin_link");
				$xls->Text($xlsRow,21,"$twitter_link");
				$xls->Text($xlsRow,22,"$googleplush_link");
			}
			$xlsRow++;
			}
		$xls->Output('download-company-'. date('m-d-Y') . '.xls');	
		com_redirect("company-master-export.php?selected_menu=master&msg=" . msg_encode("Companys download successfully"));

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
			
		  <form name="exportfile" method="post" action="company-master-export.php?action=ContactExport">
		  
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
			     <td colspan="2"><input type="checkbox" name="dsv" id="dsv" value="1">Download Shorter Version</td>
			     </tr>
			   <tr>
			   
			   
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