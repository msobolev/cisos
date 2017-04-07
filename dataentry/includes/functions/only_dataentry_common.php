<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function getSiteUsers($comp_url)
  {
     // $comp_url = $_GET['comp_url'];
    
    $compQuery = "select company_id,email_domain from ".TABLE_COMPANY_MASTER." where company_website ='".$comp_url."'";
	
    $compResult = com_db_query($compQuery);
    $compRow = com_db_fetch_array($compResult);
    $company_id = com_db_output($compRow['company_id']);
    $email_domain = com_db_output($compRow['email_domain']);

    //echo "<br>company_id: ".$company_id;
    //echo "<br>email_domain: ".$email_domain;

    $matched_val = "";
    if($email_domain != '')
        $matched_val = $email_domain;
    elseif($comp_url != '')
    {
        $extracted_domain = str_replace("www.", "", $comp_url);
        $matched_val = $extracted_domain;
    }    
    //10.132.225.160
    $hre = mysql_connect("10.132.225.160","hre2","htXP%th@71",TRUE) or die("Databasee ERROR:".mysql_error());
    mysql_select_db("hre2",$hre) or die ("ERROR: Database not found ");
    
    $first_name = "NO VAL";
    $current_funding_person_id = "";
    //$moveResult = mysql_query("select personal_id from hre_personal_master where personal_id=57159",$hre);
    $personalsResult = mysql_query("select personal_id,first_name,last_name,add_to_funding from hre_personal_master where email like '%".$matched_val."%' and personal_image != '' and email != ''",$hre);
    
    //echo "<br><br>select personal_id,first_name,last_name from hre_personal_master where email like '%".$matched_val."%' and personal_image != '' and email != ''";
    
    $numPersonal = com_db_num_rows($personalsResult);
    if($numPersonal > 0)
    {
        $output = "<select name=personalForFunding id=personalForFunding><option>Select Funding Person</option>";
        while($personalRow = mysql_fetch_array($personalsResult))
        {
            //echo "<pre>personalRow: ";   print_r($personalRow);   echo "</pre>";
            
            $personal_id = $personalRow['personal_id'];    
            $first_name = $personalRow['first_name'];
            $last_name = $personalRow['last_name'];
            $full_name = $first_name." ".$last_name;
            $add_to_funding = $personalRow['add_to_funding'];
            
            if($add_to_funding == 1) 
            {
                $current_funding_person_id = $personal_id;
                $selected = "selected"; 
            }    
            else 
                echo $selected = "";
            
            //echo "<br><br>first_name: ".$first_name;
            //echo "<br>last_name: ".$last_name;
            //echo "<br>full_name: ".$full_name;
            $output .= "<option $selected value=".$personal_id.">".$full_name."</option>";
        }
        $output .= "</select>";
        
        /*
        if($current_funding_person_id != '')
        {
            $output .= "&nbsp;&nbsp;<span onclick=remove_funding_person(".$current_funding_person_id.")>Remove Funding person</span>";
        } 
        */   
    }    
    mysql_close($hre);
    return $output;
  }
  
  
  ?>
