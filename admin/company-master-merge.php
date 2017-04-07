<?php
require('includes/include_top.php');

$action = $_REQUEST['action'];
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';
if($action == 'FindDuplicates')
{
    $comp_one_url = $_REQUEST['comp_one_url'];		 // name , url
    $comp_two_url = $_REQUEST['comp_two_url'];

    if($comp_one_url != '' && $comp_two_url != '')
    {
        $search_qry='';
        //if($dup_opt == 'name')
        //{
        //    $search_qry .= " c.company_name = '".$dup_text."'";
        //}
        //elseif($dup_opt == 'url')
        //{
        $search_qry .= " c.company_website in('".$comp_one_url."','".$comp_two_url."')";
        //}

        $sql_query = "select * from " . TABLE_COMPANY_MASTER . " as c where  ". $search_qry." order by c.company_id desc";
        //echo "<br>Q: ".$sql_query;	
        $exe_data=com_db_query($sql_query);
        $num_rows=com_db_num_rows($exe_data);
        $total_data = $num_rows;	
        //echo "<br>Rows: ".$num_rows;
        $comp_1 = array();
        $comp_2 = array();
        $c = 0;
        while ($data_sql = com_db_fetch_array($exe_data)) 
        {
            $arr_name = "comp_".$c;
            
            $comps[$c]['company_id'] = $data_sql['company_id'];
            $comps[$c]['company_name'] = $data_sql['company_name'];
            $comps[$c]['company_website'] = $data_sql['company_website'];
            $comps[$c]['company_logo'] = $data_sql['company_logo'];
            $comps[$c]['company_revenue'] = $data_sql['company_revenue'];
            $comps[$c]['company_employee'] = $data_sql['company_employee'];
            $comps[$c]['company_industry'] = $data_sql['company_industry'];
            $comps[$c]['ind_group_id'] = $data_sql['ind_group_id'];
            $comps[$c]['industry_id'] = $data_sql['industry_id'];
            
            $comps[$c]['address'] = $data_sql['address'];
            $comps[$c]['address2'] = $data_sql['address2'];
            $comps[$c]['city'] = $data_sql['city'];
            $comps[$c]['state'] = $data_sql['state'];
            $comps[$c]['country'] = $data_sql['country'];
            $comps[$c]['zip_code'] = $data_sql['zip_code'];
            $comps[$c]['phone'] = $data_sql['phone'];
            $comps[$c]['fax'] = $data_sql['fax'];
            $comps[$c]['about_company'] = $data_sql['about_company'];
            
            $comps[$c]['linkedin_link'] = $data_sql['linkedin_link'];
            $comps[$c]['twitter_link'] = $data_sql['twitter_link'];
            
            $comps[$c]['leadership_page'] = $data_sql['leadership_page'];
            $comps[$c]['email_pattern'] = $data_sql['email_pattern_id'];
            $comps[$c]['email_domain'] = $data_sql['email_domain'];
            $comps[$c]['mail_server_settings'] = $data_sql['mail_server_settings'];
            
            $c++;
        }
    }	
}

elseif($action == 'merge')
{
    //echo "<pre>Merge Form data: ";   print_r($_POST);       echo "</pre>";   
    
    
    $company_name = $_POST['company_name'];
    $company_website = $_POST['company_website'];
    $company_logo = $_POST['company_logo'];
    $company_revenue = $_POST['company_revenue'];
    $company_employee = $_POST['company_employee'];
    $company_industry = $_POST['company_industry'];
    $ind_group_id = $_POST['ind_group_id'];
    //$industry_id = $_POST['industry_id'];
    $industry_id = $_POST['company_industry'];
    
    if($industry_id != '')
    {
        $query_get_p = com_db_query("select parent_id from " . TABLE_INDUSTRY . " where industry_id = '" . $industry_id . "'");
        $data_p = com_db_fetch_array($query_get_p);
        $ind_group_id = com_db_output($data_p['parent_id']);
    }    
    
    
    $leadership_page = $_POST['leadership_page'];
    $email_pattern = $_POST['email_pattern'];
    $email_domain = $_POST['email_domain'];
    $mail_server_settings = $_POST['mail_server_settings'];
    $address = $_POST['address'];
    $address2 = $_POST['address2'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country  = $_POST['country'];
    $zip_code = $_POST['zip_code'];
    $phone = $_POST['phone'];
    $fax = $_POST['fax'];
    $about_company = $_POST['about_company'];

    $linkedin_link = $_POST['linkedin_link'];
    $twitter_link = $_POST['twitter_link'];
    
    $facebook_link = $_POST['facebook_link'];
    $googleplush_link = $_POST['googleplush_link'];
    
    $add_date = date('Y-m-d');
    
        
    
    
    //$table_fields = "company_name,company_website,company_revenue,company_employee,address,address2,city,state,country,zip_code,phone,fax,about_company,facebook_link,linkedin_link,twitter_link,googleplush_link,email_domain,mail_server_settings,email_pattern_id";
    //$table_values = "";
    
    /*
    $query = "insert into " . TABLE_COMPANY_MASTER . "
        (company_name, company_website, company_revenue, company_employee, company_industry, ind_group_id, industry_id,leadership_page,email_pattern_id,email_domain,mail_server_settings, address, address2, city, state, country, zip_code, phone, fax, about_company, facebook_link ,linkedin_link ,twitter_link, googleplush_link, add_date, create_by,admin_id, status) 
        values ('$company_name', '$company_website', '$company_revenue', '$company_employee', '$company_industry', '$ind_group_id', '$industry_id', '$leadership_page','$email_pattern','$email_domain','$mail_server_settings','$address', '$address2', '$city', '$state', '$country', '$zip_code','$phone','$fax','$about_company','$facebook_link','$linkedin_link','$twitter_link','$googleplush_link','$add_date','$create_by','$login_id','$status')";
        com_db_query($query);
        com_db_query("insert into ".TABLE_COMPANY_UPDATE_INFO."(page_name,query_string,add_date) values('admin-company-master','".com_db_input($query)."','".date("Y-m-d:H:i:s")."')");
    */  
    
    $query = "insert into " . TABLE_COMPANY_MASTER . "
        (company_name, company_website,company_logo, company_revenue, company_employee, company_industry, ind_group_id, industry_id,leadership_page,email_pattern_id,email_domain,mail_server_settings, address, address2, city, state, country, zip_code, phone, fax, about_company, facebook_link ,linkedin_link ,twitter_link, googleplush_link, add_date,sitemap_status) 
        values ('$company_name', '$company_website', '$company_logo', '$company_revenue', '$company_employee', '$company_industry', '$ind_group_id', '$industry_id', '$leadership_page','$email_pattern','$email_domain','$mail_server_settings','$address', '$address2', '$city', '$state', '$country', '$zip_code','$phone','$fax','$about_company','$facebook_link','$linkedin_link','$twitter_link','$googleplush_link','$add_date','1')";
        com_db_query($query);
        //com_db_query("insert into ".TABLE_COMPANY_UPDATE_INFO."(page_name,query_string,add_date) values('admin-company-master','".com_db_input($query)."','".date("Y-m-d:H:i:s")."')");
    $insert_id = com_db_insert_id();
    
    com_db_query("insert into ".TABLE_COMPANY_UPDATE_INFO."(page_name,query_string,add_date) values('admin-company-master','".com_db_input($query)."','".date("Y-m-d:H:i:s")."')");
    
    
    
    //if(isset($_POST['jobs']) && $_POST['jobs'] != '')
    if(isset($_POST['jobs']))    
    {
        $companies_job_count = count($_POST['jobs']);
        
        for($j=0;$j<$companies_job_count;$j++)
        {
            //$old_company_job_id = substr($_POST['jobs'],4,strlen($_POST['jobs']));
            $old_company_job_id = $_POST['jobs'][$j];

            $merge_jobs_query = "UPDATE " . TABLE_COMPANY_JOB_INFO . " set company_id = '" . $insert_id . "' WHERE company_id = '" .$old_company_job_id."'";
            //echo "<br><br>Updating jobs for merge: ".$merge_jobs_query;
            com_db_query($merge_jobs_query);
            
            
            $merge_jobs_websites_query = "UPDATE " . TABLE_COMPANY_JOB_WEBSITE . " set company_id = '" . $insert_id . "' WHERE company_id = '" .$old_company_job_id."'";
            //echo "<br><br>Updating job websites for merge: ".$merge_jobs_websites_query;
            
            com_db_query($merge_jobs_websites_query);
            
            
        }    
    }    
    
    
    //if(isset($_POST['fundings']) && $_POST['fundings'] != '')
    if(isset($_POST['fundings']))    
    {
        $companies_fundings_count = count($_POST['fundings']);
        
        //$old_company_funding_id = substr($_POST['fundings'],8,strlen($_POST['fundings']));
        
        for($f=0;$f<$companies_fundings_count;$f++)
        {
        
            $old_company_funding_id = $_POST['fundings'][$f];
            $merge_funding_query = "UPDATE " . TABLE_COMPANY_FUNDING . " set company_id = '" . $insert_id . "' WHERE company_id = '" .$old_company_funding_id."'";
            //echo "<br><br>Updating fundings for merge: ".$merge_funding_query;
            com_db_query($merge_funding_query);
            
            
            $merge_funding_websites_query = "UPDATE " . TABLE_COMPANY_FUNDING_WEBSITE . " set company_id = '" . $insert_id . "' WHERE company_id = '" .$old_company_funding_id."'";
            //echo "<br><br>Updating funding websites for merge: ".$merge_funding_websites_query;
            com_db_query($merge_funding_websites_query);
            
        }    
    }    

    
    //if(isset($_POST['movements']) && $_POST['movements'] != '')
    if(isset($_POST['movements']))    
    {
        $companies_movements_count = count($_POST['movements']);
        
        for($m=0;$m<$companies_movements_count;$m++)
        {
            //$old_company_movement_id = substr($_POST['movements'],10,strlen($_POST['movements']));
            $old_company_movement_id = $_POST['movements'][$m];
            
            $merge_movement_query = "UPDATE " . TABLE_MOVEMENT_MASTER . " set company_id = '" . $insert_id . "' WHERE company_id = '" .$old_company_movement_id."'";
            //echo "<br><br>Updating movements for merge: ".$merge_movement_query;
            com_db_query($merge_movement_query);
        }    
    }
    
    $comp_one_id = $_POST['comp_one_id'];
    com_db_query("delete from " . TABLE_COMPANY_MASTER . " where company_id = '" . $comp_one_id . "'");
    $det_srt= "delete from " . TABLE_COMPANY_MASTER . " where company_id = '" . $comp_one_id . "'";
    com_db_query("insert into ".TABLE_COMPANY_UPDATE_INFO."(page_name,query_string,add_date) values('admin-company-master','".com_db_input($det_srt)."','".date("Y-m-d:H:i:s")."')");
    

    $comp_two_id = $_POST['comp_two_id'];
    com_db_query("delete from " . TABLE_COMPANY_MASTER . " where company_id = '" . $comp_two_id . "'");
    $det_srt= "delete from " . TABLE_COMPANY_MASTER . " where company_id = '" . $comp_two_id . "'";
    com_db_query("insert into ".TABLE_COMPANY_UPDATE_INFO."(page_name,query_string,add_date) values('admin-company-master','".com_db_input($det_srt)."','".date("Y-m-d:H:i:s")."')");

    com_redirect("company-master-merge.php?p=" . $p . "&msg=" . msg_encode("companies merged successfully"));
    
}

elseif($action == 'primarySetup')
{
    $primary_comp = $_GET['primary'];
    $secondary_comp = $_GET['secondary'];
    //echo "===Here";

    $updateExecsQuery = "update ".TABLE_MOVEMENT_MASTER." set company_id = '".$primary_comp."'  where company_id in(".$secondary_comp.")";
    //echo "<br>Q: ".$updateQuery; die();
    com_db_query($updateExecsQuery);

    $updateJobQuery = "update ".TABLE_COMPANY_JOB_INFO." set company_id = '".$primary_comp."'  where company_id in(".$secondary_comp.")";
    //echo "<br>Q: ".$updateQuery; die();
    com_db_query($updateJobQuery);

    $msg = "Made the selected company as primary.";
    com_redirect("company-master-duplicates.php?selected_menu=master&msg=" . msg_encode($msg));	
}
//echo "<pre>comps: ";   print_r($comps);   echo "</pre>";
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
                                    <td width="25%" align="left" valign="middle" class="heading-text">Duplicate Companies</td>
                                    <td width="75%" valign="middle" class="message" align="left"><?=$msg?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                    <td align="left" valign="top" class="right-bar-content-border-box">
                        
                            <table width="90%" border="0" cellspacing="0" cellpadding="5">
                                <form name="exportfile" method="post" action="company-master-merge.php?action=FindDuplicates">
                                
                                
                                    
                                <tr><td colspan="2" height="20">&nbsp;</td></tr>
                                <tr>
                                    <td width="170" align="left" valign="top">Enter Company 1 URL:</td>
                                    <td align="left" valign="top">
                                        <input type="text" name="comp_one_url" id="comp_one_url" size="30" value="<?=$_REQUEST['comp_one_url']?>" />
                                    </td>
                                </tr>


                                <tr>
                                    <td width="170" align="left" valign="top">Enter Company 2 URL:</td>
                                    <td align="left" valign="top">
                                        <input type="text" name="comp_two_url" id="comp_two_url" size="30" value="<?=$_REQUEST['comp_two_url']?>" />
                                    </td>
                                </tr>

                                <tr>
                                    <td>&nbsp;</td>
                                    <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td align="left" valign="top"><input type="submit" name="Submit" value="Find Companies" class="submitButton" /></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                </form>
                                <?PHP
                                //echo "<br>Num_rows:".$num_rows;
                                if($num_rows > 1)
                                {
                                    $sql_query_comp_ids = "select group_concat(c.company_id) as comp_ids from " . TABLE_COMPANY_MASTER . " as c where  ". $search_qry." order by c.company_id desc";
                                    //echo "<br>group_concat Q: ".$sql_query_comp_ids;	
                                    $exe_data_comp_ids = com_db_query($sql_query_comp_ids);
                                    $data_concat_comp_ids = com_db_fetch_array($exe_data_comp_ids);
                                    $comp_ids = $data_concat_comp_ids['comp_ids'];
                                    //echo "<br>comp_ids: ".$comp_ids;

                                ?>
                                <tr>
                                <!-- <td>
                                         <table width="90%" border="0" cellspacing="0" cellpadding="5">
                                          <tr> -->
                                    <td colspan="2"><h2>Companies</h2></td>
                                </tr>	

                                <tr>
                                    <td colspan="2">
                                        <form method="post" action="company-master-merge.php?action=merge">
                                        
                                        <input type="hidden" name="comp_one_id" id="comp_one_id" value="<?=$comps[0]['company_id']?>">    
                                        <input type="hidden" name="comp_two_id" id="comp_two_id" value="<?=$comps[1]['company_id']?>">    
                                            
                                        <table width="100%" cellpadding="5">
                                            
                                            <?PHP
                                            //while ($data_sql = com_db_fetch_array($exe_data)) 
                                            //for($r=0;$r<2;$r++)        
                                            //{

                                                //echo "<pre>data_sql ARR:";	print_r($data_sql); echo "</pre>";
                                            $removed_this_id = "";
                                            $comp_id = $data_sql['company_id'];
                                            $comp_name = $data_sql['company_name'];
                                            $comp_web = $data_sql['company_website'];
                                            //echo "<br><br><br>comp_id: ".$comp_id;
                                            //echo "<br>comp_ids".$comp_ids;
                                            $removed_this_id = str_replace($comp_id,"",$comp_ids);
                                            $removed_this_id = str_replace(",,",",",$removed_this_id);
                                            $removed_this_id = trim($removed_this_id,",");
                                            //echo "<br>After this removal: ".$removed_this_id;
                                            ?>

                                            <tr>
                                                <td width="200">Company Name</td>
                                                <td><?=$comps[0]['company_name']?></td>
                                                <td><input type="radio" name="company_name" value="<?=$comps[0]['company_name']?>"></td>
                                                <td><?=$comps[1]['company_name']?></td>
                                                <td><input type="radio" name="company_name" value="<?=$comps[1]['company_name']?>"></td>
                                            </tr>

                                                                                            <tr>
                                            <td>Company Website</td>
                                                <td><?=$comps[0]['company_website']?></td>
                                                <td><input type="radio" name="company_website" value="<?=$comps[0]['company_website']?>"></td>
                                                <td><?=$comps[1]['company_website']?></td>
                                                <td><input type="radio" name="company_website" value="<?=$comps[1]['company_website']?>"></td>
                                            </tr>
                                           
                                            
                                            
                                            <td>Company Logo</td>
                                            <td>
                                                <img src="<?=HTTPS_SITE_URL?>company_logo/thumb/<?=$comps[0]['company_logo']?>" alt="" />
                                            </td>
                                                <td><input type="radio" name="company_logo" value="<?=$comps[0]['company_logo']?>"></td>
                                                <td>
                                                    <img src="<?=HTTPS_SITE_URL?>company_logo/thumb/<?=$comps[1]['company_logo']?>" alt="" />
                                                </td>
                                                <td><input type="radio" name="company_logo" value="<?=$comps[1]['company_logo']?>"></td>
                                            </tr>
                                            
                                            
                                            
                                            <!--
                                            <td>Company Logo</td>
                                                <td><?=$comps[0]['company_revenue']?></td>
                                                <td><input type="radio" name="company_revenue" value="<?=$comps[0]['company_revenue']?>"></td>
                                                <td><?=$comps[1]['company_revenue']?></td>
                                                <td><input type="radio" name="company_revenue" value="<?=$comps[1]['company_revenue']?>"></td>
                                            </tr>
                                            -->
                                            
                                            <td>Company Revenue</td>
                                                <td><?=$comps[0]['company_revenue']?></td>
                                                <td><input type="radio" name="company_revenue" value="<?=$comps[0]['company_revenue']?>"></td>
                                                <td><?=$comps[1]['company_revenue']?></td>
                                                <td><input type="radio" name="company_revenue" value="<?=$comps[1]['company_revenue']?>"></td>
                                            </tr>

                                            
                                            <td>Company Employee</td>
                                                <td><?=$comps[0]['company_employee']?></td>
                                                <td><input type="radio" name="company_employee" value="<?=$comps[0]['company_employee']?>"></td>
                                                <td><?=$comps[1]['company_employee']?></td>
                                                <td><input type="radio" name="company_employee" value="<?=$comps[1]['company_employee']?>"></td>
                                            </tr>
                                            
                                            <!--
                                            <td>Company Employee</td>
                                                <td><?=$comps[0]['company_employee']?></td>
                                                <td><input type="radio" name="company_employee" value="<?=$comps[0]['company_employee']?>"></td>
                                                <td><?=$comps[1]['company_employee']?></td>
                                                <td><input type="radio" name="company_employee" value="<?=$comps[1]['company_employee']?>"></td>
                                            </tr>
                                            -->
                                            
                                            <td>Company Industry</td>
                                                <td><?=$comps[0]['company_industry']?></td>
                                                <td><input type="radio" name="company_industry" value="<?=$comps[0]['company_industry']?>"></td>
                                                <td><?=$comps[1]['company_industry']?></td>
                                                <td><input type="radio" name="company_industry" value="<?=$comps[1]['company_industry']?>"></td>
                                            </tr>
                                            
                                            <!--
                                            <td>Company Group</td>
                                                <td><?=$comps[0]['ind_group_id']?></td>
                                                <td><input type="radio" name="ind_group_id" value="<?=$comps[0]['ind_group_id']?>"></td>
                                                <td><?=$comps[1]['ind_group_id']?></td>
                                                <td><input type="radio" name="ind_group_id" value="<?=$comps[1]['ind_group_id']?>"></td>
                                            </tr>
                                            -->
                                            
                                            <td>Address</td>
                                                <td><?=$comps[0]['address']?></td>
                                                <td><input type="radio" name="address" value="<?=$comps[0]['address']?>"></td>
                                                <td><?=$comps[1]['address']?></td>
                                                <td><input type="radio" name="address" value="<?=$comps[1]['address']?>"></td>
                                            </tr>
                                            
                                            <td>Address2</td>
                                                <td><?=$comps[0]['address2']?></td>
                                                <td><input type="radio" name="address2" value="<?=$comps[0]['address2']?>"></td>
                                                <td><?=$comps[1]['address2']?></td>
                                                <td><input type="radio" name="address2" value="<?=$comps[1]['address2']?>"></td>
                                            </tr>
                                            
                                            
                                            <td>City</td>
                                                <td><?=$comps[0]['city']?></td>
                                                <td><input type="radio" name="city" value="<?=$comps[0]['city']?>"></td>
                                                <td><?=$comps[1]['city']?></td>
                                                <td><input type="radio" name="city" value="<?=$comps[1]['city']?>"></td>
                                            </tr>
                                            
                                            <td>State</td>
                                                <td><?=$comps[0]['state']?></td>
                                                <td><input type="radio" name="state" value="<?=$comps[0]['state']?>"></td>
                                                <td><?=$comps[1]['state']?></td>
                                                <td><input type="radio" name="state" value="<?=$comps[1]['state']?>"></td>
                                            </tr>
                                            
                                            <td>Country</td>
                                                <td><?=$comps[0]['country']?></td>
                                                <td><input type="radio" name="country" value="<?=$comps[0]['country']?>"></td>
                                                <td><?=$comps[1]['country']?></td>
                                                <td><input type="radio" name="country" value="<?=$comps[1]['country']?>"></td>
                                            </tr>
                                            
                                            <td>Zip Code</td>
                                                <td><?=$comps[0]['zip_code']?></td>
                                                <td><input type="radio" name="zip_code" value="<?=$comps[0]['zip_code']?>"></td>
                                                <td><?=$comps[1]['zip_code']?></td>
                                                <td><input type="radio" name="zip_code" value="<?=$comps[1]['zip_code']?>"></td>
                                            </tr>
                                            
                                            
                                            <td>Phone</td>
                                                <td><?=$comps[0]['phone']?></td>
                                                <td><input type="radio" name="phone" value="<?=$comps[0]['phone']?>"></td>
                                                <td><?=$comps[1]['phone']?></td>
                                                <td><input type="radio" name="phone" value="<?=$comps[1]['phone']?>"></td>
                                            </tr>
                                            
                                            <td>Fax</td>
                                                <td><?=$comps[0]['fax']?></td>
                                                <td><input type="radio" name="fax" value="<?=$comps[0]['fax']?>"></td>
                                                <td><?=$comps[1]['fax']?></td>
                                                <td><input type="radio" name="fax" value="<?=$comps[1]['fax']?>"></td>
                                            </tr>
                                            
                                            
                                            <td>About Company</td>
                                                <td><?=$comps[0]['about_company']?></td>
                                                <td><input type="radio" name="about_company" value="<?=$comps[0]['about_company']?>"></td>
                                                <td><?=$comps[1]['about_company']?></td>
                                                <td><input type="radio" name="about_company" value="<?=$comps[1]['about_company']?>"></td>
                                            </tr>
                                            
                                            
                                            <td>LinkedIn Link</td>
                                                <td><?=$comps[0]['linkedin_link']?></td>
                                                <td><input type="radio" name="linkedin_link" value="<?=$comps[0]['linkedin_link']?>"></td>
                                                <td><?=$comps[1]['linkedin_link']?></td>
                                                <td><input type="radio" name="linkedin_link" value="<?=$comps[1]['linkedin_link']?>"></td>
                                            </tr>
                                            
                                            
                                            <td>Twitter Link</td>
                                                <td><?=$comps[0]['twitter_link']?></td>
                                                <td><input type="radio" name="twitter_link" value="<?=$comps[0]['twitter_link']?>"></td>
                                                <td><?=$comps[1]['twitter_link']?></td>
                                                <td><input type="radio" name="twitter_link" value="<?=$comps[1]['twitter_link']?>"></td>
                                            </tr>
                                            
                                            <tr>
                                                <td>Leadership Page</td>
                                                <td><?=$comps[0]['leadership_page']?></td>
                                                <td><input type="radio" name="leadership_page" value="<?=$comps[0]['leadership_page']?>"></td>
                                                <td><?=$comps[1]['leadership_page']?></td>
                                                <td><input type="radio" name="leadership_page" value="<?=$comps[1]['leadership_page']?>"></td>
                                            </tr>

                                            <tr>
                                                <td>Email Pattern</td>
                                                <td><?=$comps[0]['email_pattern']?></td>
                                                <td><input type="radio" name="email_pattern" value="<?=$comps[0]['email_pattern']?>"></td>
                                                <td><?=$comps[1]['email_pattern']?></td>
                                                <td><input type="radio" name="email_pattern" value="<?=$comps[1]['email_pattern']?>"></td>
                                            </tr>
                                            
                                            <tr>
                                                <td>Email Domain</td>
                                                <td><?=$comps[0]['email_domain']?></td>
                                                <td><input type="radio" name="email_domain" value="<?=$comps[0]['email_domain']?>"></td>
                                                <td><?=$comps[1]['email_domain']?></td>
                                                <td><input type="radio" name="email_domain" value="<?=$comps[1]['email_domain']?>"></td>
                                            </tr>

                                            <tr>
                                                <td>Mail Server Settings</td>
                                                <td><?=$comps[0]['mail_server_settings']?></td>
                                                <td><input type="radio" name="mail_server_settings" value="<?=$comps[0]['mail_server_settings']?>"></td>
                                                <td><?=$comps[1]['mail_server_settings']?></td>
                                                <td><input type="radio" name="mail_server_settings" value="<?=$comps[1]['mail_server_settings']?>"></td>
                                            </tr>
                                            
                                            
                                            
                                            
                                            <td>Jobs</td>
                                                <td>of company <?=$comps[0]['company_name']?></td>
                                                <td><input type="checkbox" name="jobs[]" value="<?=$comps[0]['company_id']?>"></td>
                                                <td>of company <?=$comps[1]['company_name']?></td>
                                                <td><input type="checkbox" name="jobs[]" value="<?=$comps[1]['company_id']?>"></td>
                                            </tr>
                                            
                                            
                                            
                                            
                                            <td>Fundings</td>
                                                <td>of company <?=$comps[0]['company_name']?></td>
                                                <td><input type="checkbox" name="fundings[]" value="<?=$comps[0]['company_id']?>"></td>
                                                <td>of company <?=$comps[1]['company_name']?></td>
                                                <td><input type="checkbox" name="fundings[]" value="<?=$comps[1]['company_id']?>"></td>
                                            </tr>
                                            
                                            
                                            <td>Movements</td>
                                                <td>of company <?=$comps[0]['company_name']?></td>
                                                <td><input type="checkbox" name="movements[]" value="<?=$comps[0]['company_id']?>"></td>
                                                <td>of company <?=$comps[1]['company_name']?></td>
                                                <td><input type="checkbox" name="movements[]" value="<?=$comps[1]['company_id']?>"></td>
                                            </tr>
                                            
                                            
                                            <!--
                                            <td>Fax</td>
                                                <td><?=$comps[0]['fax']?></td>
                                                <td><input type="radio" name="fax" value="<?=$comps[0]['fax']?>"></td>
                                                <td><?=$comps[1]['fax']?></td>
                                                <td><input type="radio" name="fax" value="<?=$comps[1]['fax']?>"></td>
                                            </tr>
                                            -->
                                            
                                            
                                            <tr>
                                                <td style="text-align:center;padding:20px;" colspan="4"><input type="submit" value="Merge" ></td>
                                            </tr>
                                                
                                            <?PHP
                                            //}
                                            ?> 
                                        </table>
                                        </form>
                                    </td>
                                </tr>	
                                      <!-- </table>

                                </td>
                          </tr> -->

                                <?PHP
                                }
                                elseif(isset($num_rows) && $num_rows == 0)
                                {
                                ?>
                                      <td colspan="2">No duplicates found.</td>
                                <?PHP
                                }
                                ?>
                            </table>
                        
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