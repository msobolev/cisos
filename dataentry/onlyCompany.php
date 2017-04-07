<?PHP
//echo "TestCompany";
require('includes/include_top_ajax.php');
$q = $_GET["q"];
$url=$q;
if($url !='')
{
        //$companyQuery ="select company_id,company_name,company_website from ".TABLE_COMPANY_MASTER." where company_website REGEXP('".$url."')";
    //$companyQuery ="select company_id,company_name,company_website from ".TABLE_COMPANY_MASTER." where company_website like '".$url."%'";
    $companyQuery ="select company_id,company_name,company_website,company_urls from ".TABLE_COMPANY_MASTER." where company_website like '".$url."%' OR company_urls like '".$url."'";
}
else
{
    $companyQuery ="select company_id,company_name,company_website from ".TABLE_COMPANY_MASTER." where company_website !='' order by company_name";
}
$companyResult = com_db_query($companyQuery);
if($companyResult)
{
    $num_row = com_db_num_rows($companyResult);
}
$companyInfoShow='';
if($num_row>0)
{
    $companyInfoShow = '<div class="PersonalCompanyListShow">
    <table width="100%" cellpadding="2" cellspacing="2" border="0">';
    while($cRow = com_db_fetch_array($companyResult)){
        
        //if($cRow['company_website'])
        //if($cRow['company_website'] == $url)
        $show_val = $cRow['company_website']." (".$cRow['company_urls'].")";
        //$show_val = $cRow['company_website'];
        //else
        //    $show_val = $cRow['company_urls'];
        /*
        $companyInfoShow  .='<tr>
            <td align="left" class="nameList" valign="top"><a href="javascript:;" onclick="CompanyInformationMovement('."'".$cRow['company_id']."'".');">'.com_db_output($cRow['company_website']).'</a></td>	
        </tr>';	
         */
        
        $companyInfoShow  .='<tr>
            <td align="left" class="nameList" valign="top"><a href="javascript:;" onclick="CompanyInformationMovement('."'".$cRow['company_id']."'".');">'.com_db_output($show_val).'</a></td>	
        </tr>';	

        
        
    }
    $companyInfoShow .='</table>
    </div>';
}
echo $companyInfoShow;


?>