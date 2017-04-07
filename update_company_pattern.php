<?php
//ini_set('display_errors',1);
//ini_set('display_startup_errors',1);
//error_reporting(-1);

//include("includes/include-top.php");
//die("2");

// INFORMATION
// On 24th Aug , there are 7306 companies having email_pattern_id IS NULL AND email_domain !=  ''


function com_db_input($string) 
{
    return addslashes($string);
}

function getting_email_pattern($fn,$mn,$ln,$e_domain,$c_email)
{
    //echo "<br>HHH";
    //$fn = "faraz";
    //$mn = "haf";
    //$ln = "aleem";
    //$e_domain = "@nxb.com.pk";
    //$c_email = $_GET['email'];//"faraz.aleem@nxb.com.pk";

    //echo "<br>First name: ".$fn;
    //echo "<br>Middle name: ".$mn;
    //echo "<br>Last name: ".$ln;
    //echo "<br>Email: ".$c_email;

    $c_email = trim($c_email);

    $first_name_initial = substr($fn, 0, 1);
    $middle_name_initial = substr($mn, 0, 1);
    $last_name_initial = substr($ln, 0, 1);
    $e_domain = "@".$e_domain;

    //echo "<br>first_name: ".$fn.":";
    //echo "<br>middle_name: ".$mn.":";
    //echo "<br>last_name: ".$ln.":";
    //echo "<br>email_domain: ".$e_domain.":";
    //echo "<br>email_to_check: ".$c_email.":";
    //echo $fn.".".$ln.$e_domain .'=='. $c_email;

    //echo "<br><br>".$fn.".".$ln.$e_domain;

    //echo "<br>first_name_initial: ".$first_name_initial;
    //echo "<br>ln: ".$ln;
    //echo "<br>first_name_initial: ".$first_name_initial;


    $pattern = '';
    if($first_name_initial.$ln.$e_domain == $c_email)
    {
            $pattern = 1;
    }
    elseif($fn.".".$ln.$e_domain == $c_email)
    {
            //echo "<br><br>In two: ".$fn.".".$ln.$e_domain;
            $pattern = 2;
    }
    elseif($fn.$e_domain == $c_email)
    {
            $pattern = 3;
    }
    elseif($fn.$last_name_initial.$e_domain == $c_email)
    {
            $pattern = 4;
    }
    elseif($fn."_".$ln.$e_domain == $c_email)
    {
            $pattern = 5;
    }
    elseif($ln.$e_domain == $c_email)
    {
            $pattern = 6;
    }
    elseif($fn.$ln.$e_domain == $c_email)
    {
            $pattern = 7;
    }
    elseif($ln.$first_name_initial.$e_domain == $c_email)
    {
            $pattern = 8;
    }
    elseif($first_name_initial.".".$ln.$e_domain == $c_email)
    {
            $pattern = 9;
    }
    elseif($ln.".".$fn.$e_domain == $c_email)
    {
            $pattern = 10;
    }
    elseif($last_name_initial.$fn.$e_domain == $c_email)
    {
            $pattern = 11;
    }
    elseif($fn."-".$ln.$e_domain == $c_email)
    {
            $pattern = 12;
    }
    elseif($first_name_initial.$first_name_initial.$ln.$e_domain == $c_email)
    {
            $pattern = 13;
    }
    elseif($first_name_initial.substr($fn, 0, 2).$e_domain == $c_email)
    {
            $pattern = 14;
    }
    elseif($first_name_initial.substr($fn, 0, 5).$e_domain == $c_email)
    {
            $pattern = 15;
    }
    elseif($first_name_initial.substr($fn, 0, 4).$e_domain == $c_email)
    {
            $pattern = 16;
    }
    elseif($first_name_initial.substr($fn, 0, 3).$e_domain == $c_email)
    {
            $pattern = 17;
    }
    elseif($first_name_initial.substr($fn, 0, 7).$e_domain == $c_email)
    {
            $pattern = 18;
    }
    elseif($first_name_initial.substr($fn, 0, 6).$e_domain == $c_email)
    {
            $pattern = 19;
    }
    elseif($ln."_".$fn.$e_domain == $c_email)
    {
            $pattern = 20;
    }
    elseif($fn.".".$middle_name_initial.".".$ln.$e_domain == $c_email)
    {
            $pattern = 21;
    }
    elseif($fn."_".$middle_name_initial."_".$ln.$e_domain == $c_email)
    {
            $pattern = 22;
    }
    elseif($ln.".".$first_name_initial == $c_email)
    {
            $pattern = 23;
    }
    elseif($ln."_".substr($fn, 0, 2) == $c_email)
    {
            $pattern = 24;
    }
    elseif($first_name_initial."_".$ln == $c_email)
    {
            $pattern = 25;
    }
    elseif($first_name_initial.$last_name_initial == $c_email)
    {
            $pattern = 26;
    }
    elseif($first_name_initial.$middle_name_initial.$last_name_initial == $c_email)
    {
            $pattern = 27;
    }
    return $pattern;
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$common_domain_clause = " AND (email not like '%@gmail.com' AND email not like '%@hotmail.com' AND email not like '%@yahoo.com' AND email not like '%@msn.com' AND  email not like '%@aol.com')";

$cto = mysql_connect("10.132.233.131","ctou2","ToC@!mvCo23") or die("Database CTO ONE ERROR ");
mysql_select_db("ctou2",$cto) or die ("ERROR: Database not found ");


echo "<br>Comp Q: select company_id,email_domain from cto_company_master where email_pattern_id is null and email_domain != '' order by company_id desc LIMIT 0,500";
$companyResult = mysql_query("select company_id,email_domain from cto_company_master where email_pattern_id is null and email_domain != '' order by company_id desc LIMIT 0,500",$cto);



$companies_num_rows = mysql_num_rows($companyResult);
//echo "<br>companies_num_rows: ".$companies_num_rows;
$cnt = 0;
while($companyRow = mysql_fetch_array($companyResult))
{
    $new_pattern_id = '';
    $email_domain = '';
    $this_company_id = $companyRow['company_id'];
    $this_company_email_domain = $companyRow['email_domain'];
    //echo "<br><br><br>this_company_email_domain top: ".$this_company_email_domain;
    //echo "<br>Personal Q: select pm.first_name , pm.last_name,pm.middle_name,pm.email,cm.email_domain from cto_movement_master as mm,cto_personal_master as pm,cto_company_master as cm where (mm.company_id = cm.company_id and mm.personal_id = pm.personal_id) and pm.email_verified = 'yes' and cm.company_id ='".$this_company_id."' $common_domain_clause";
    $personal_res = mysql_query("select pm.first_name , pm.last_name,pm.middle_name,pm.email,cm.email_domain from cto_movement_master as mm,cto_personal_master as pm,cto_company_master as cm where (mm.company_id = cm.company_id and mm.personal_id = pm.personal_id) and pm.email_verified = 'yes' and cm.company_id ='".$this_company_id."' $common_domain_clause",$cto);
    $personal_num_rows = mysql_num_rows($personal_res);
    //echo "<br>Personal count: ".$personal_num_rows;
    
    if($personal_num_rows > 0)
    {
        $personalRow = mysql_fetch_array($personal_res);   
        $at_pos = strpos($personalRow['email'],"@")+1;
        $email_domain = substr($personalRow['email'],$at_pos,strlen($personalRow['email']));
        $new_pattern_id = getting_email_pattern(strtolower($personalRow['first_name']),strtolower($personalRow['middle_name']),strtolower($personalRow['last_name']),$email_domain,$personalRow['email']);
    }
    else
    {
        $hre = mysql_connect("10.132.225.160","hre2","htXP%th@71",TRUE) or die("Database HR ONE ERROR ");
        mysql_select_db("hre2",$hre) or die ("ERROR: Database not found ");
        
        
        $personal_res_hr = mysql_query("select pm.first_name , pm.last_name,pm.middle_name,pm.email,cm.email_domain from hre_movement_master as mm,hre_personal_master as pm,hre_company_master as cm where (mm.company_id = cm.company_id and mm.personal_id = pm.personal_id) and pm.email_verified = 'yes' and cm.company_id ='".$this_company_id."' $common_domain_clause",$hre);
        $personal_num_rows_hr = mysql_num_rows($personal_res_hr);
        //echo "<br>Personal_res_hr: ".$personal_res_hr;
        if($personal_num_rows_hr > 0)
        {
            $personalRow_hr = mysql_fetch_array($personal_res_hr);   
            $at_pos_hr = strpos($personalRow_hr['email'],"@")+1;
            $email_domain = substr($personalRow_hr['email'],$at_pos_hr,strlen($personalRow_hr['email']));
            $new_pattern_id = getting_email_pattern(strtolower($personalRow_hr['first_name']),strtolower($personalRow_hr['middle_name']),strtolower($personalRow_hr['last_name']),$email_domain,$personalRow_hr['email']);
            //echo "<br>new_pattern_id_hr: ".$new_pattern_id;
        }
        else
        {
            $cfo = mysql_connect("10.132.233.66","cfo2","cV!kJ201Ze",TRUE) or die("Database CFO ONE ERROR ");
            mysql_select_db("cfo2",$cfo) or die ("ERROR: Database not found ");
        
        
            $personal_res_cfo = mysql_query("select pm.first_name , pm.last_name,pm.middle_name,pm.email,cm.email_domain from cfo_movement_master as mm,cfo_personal_master as pm,cfo_company_master as cm where (mm.company_id = cm.company_id and mm.personal_id = pm.personal_id) and pm.email_verified = 'yes' and cm.company_id ='".$this_company_id."' $common_domain_clause",$cfo);
            $personal_num_rows_cfo = mysql_num_rows($personal_res_cfo);
            //echo "<br>Personal_res_cfo: ".$personal_res_cfo;
            if($personal_num_rows_cfo > 0)
            {
                $personalRow_cfo = mysql_fetch_array($personal_res_cfo);   
                $at_pos_cfo = strpos($personalRow_cfo['email'],"@")+1;
                $email_domain = substr($personalRow_cfo['email'],$at_pos_cfo,strlen($personalRow_cfo['email']));
                $new_pattern_id = getting_email_pattern(strtolower($personalRow_cfo['first_name']),strtolower($personalRow_cfo['middle_name']),strtolower($personalRow_cfo['last_name']),$email_domain,$personalRow_cfo['email']);
                //echo "<br>new_pattern_id_cfo: ".$new_pattern_id;
            }
            else
            {
                $clo = mysql_connect("10.132.233.67","clo2","dtBO#7310",TRUE) or die("Database ERROR".mysql_error());
                mysql_select_db("clo2",$clo) or die ("ERROR: Database not found ");
        
        
                $personal_res_clo = mysql_query("select pm.first_name , pm.last_name,pm.middle_name,pm.email,cm.email_domain from clo_movement_master as mm,clo_personal_master as pm,clo_company_master as cm where (mm.company_id = cm.company_id and mm.personal_id = pm.personal_id) and pm.email_verified = 'yes' and cm.company_id ='".$this_company_id."' $common_domain_clause",$clo);
                $personal_num_rows_clo = mysql_num_rows($personal_res_clo);
                //echo "<br>Personal_res_clo: ".$personal_res_clo;
                if($personal_num_rows_clo > 0)
                {
                    $personalRow_clo = mysql_fetch_array($personal_res_clo);   
                    $at_pos_clo = strpos($personalRow_clo['email'],"@")+1;
                    $email_domain = substr($personalRow_clo['email'],$at_pos_clo,strlen($personalRow_clo['email']));
                    $new_pattern_id = getting_email_pattern(strtolower($personalRow_clo['first_name']),strtolower($personalRow_clo['middle_name']),strtolower($personalRow_clo['last_name']),$email_domain,$personalRow_clo['email']);
                    //echo "<br>new_pattern_id_clo: ".$new_pattern_id;
                }
                else
                {
                    $cmo = mysql_connect("10.132.232.238","cmo1","mocos!cm123",TRUE) or die("Database ERROR ");
                    mysql_select_db("cmo1",$cmo) or die ("ERROR: Database not found ");
        
        
                    $personal_res_cmo = mysql_query("select pm.first_name , pm.last_name,pm.middle_name,pm.email,cm.email_domain from cmo_movement_master as mm,cmo_personal_master as pm,cmo_company_master as cm where (mm.company_id = cm.company_id and mm.personal_id = pm.personal_id) and pm.email_verified = 'yes' and cm.company_id ='".$this_company_id."' $common_domain_clause",$cmo);
                    $personal_num_rows_cmo = mysql_num_rows($personal_res_cmo);
                    //echo "<br>Personal_res_cmo: ".$personal_res_cmo;
                    if($personal_num_rows_cmo > 0)
                    {
                        $personalRow_cmo = mysql_fetch_array($personal_res_cmo);   
                        $at_pos_cmo = strpos($personalRow_cmo['email'],"@")+1;
                        $email_domain = substr($personalRow_cmo['email'],$at_pos_cmo,strlen($personalRow_cmo['email']));
                        $new_pattern_id = getting_email_pattern(strtolower($personalRow_cmo['first_name']),strtolower($personalRow_cmo['middle_name']),strtolower($personalRow_cmo['last_name']),$email_domain,$personalRow_cmo['email']);
                        //echo "<br>new_pattern_id_cmo: ".$new_pattern_id;
                    }
                }    
            }    
        }    
    }
    
    
    if($new_pattern_id != '' && $this_company_id != '')
    {
        echo "<br><br>New_pattern_id: ".$new_pattern_id;
        echo "<br>This_company_id: ".$this_company_id;
        
        
        $email_domain_update = "";
        //echo "<br>this_company_email_domain bottom: ".$this_company_email_domain;
        if($this_company_email_domain == '' && $email_domain != '')
        {
            $email_domain_update = ",email_domain = '$email_domain'";
        }    
        
        $update_pattern = "UPDATE cto_company_master set email_pattern_id = $new_pattern_id $email_domain_update where company_id = $this_company_id";
        echo "<br>Update Pattern Q: ".$update_pattern;
        $comp_update_query = mysql_query($update_pattern,$cto);

        //$personal_res = mysql_query("select pm.first_name , pm.last_name,pm.middle_name,pm.email,cm.email_domain from cto_movement_master as mm,cto_personal_master as pm,cto_company_master as cm where (mm.company_id = cm.company_id and mm.personal_id = pm.personal_id) and pm.email_verified = 'yes' and cm.company_id ='".$this_company_id."'",$cto);
        
        //echo "<br>Company update info: ".TABLE_COMPANY_UPDATE_INFO;
        
        //com_db_query("insert into ".TABLE_COMPANY_UPDATE_INFO."(page_name,query_string,add_date) values('dataentry-company','".com_db_input($update_pattern)."','".date("Y-m-d:H:i:s")."')",$cto);
        
        $comp_update_query = "insert into cto_company_update_info(page_name,query_string,add_date) values('update-pattern-cron','".com_db_input($update_pattern)."','".date("Y-m-d:H:i:s")."')";
        echo "<br>comp_update_query: ".$comp_update_query;
        $comp_update_query_res = mysql_query($comp_update_query,$cto);
        
    }    
       
}



?>