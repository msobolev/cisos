<?php

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

require_once('PHPMailer/class.phpmailer.php');

$from_admin = 'ms@hrexecsonthemove.com';
$mail                = new PHPMailer();
$mail->IsSMTP(); // telling the class to use SMTP
$mail->SMTPAuth      = true;                  // enable SMTP authentication
$mail->SMTPKeepAlive = true;                  // SMTP connection will not close after each email sent
$mail->Host          = "smtpout.secureserver.net"; // sets the SMTP server relay-hosting.secureserver.net smtpout.secureserver.net
$mail->Port          = 80;    // 25 465               // 26 set the SMTP port for the GMAIL server
//$mail->Username      = "rts_email_sent@ctosonthemove.com"; // SMTP account username
$mail->Username      = "misha.sobolev@execfile.com";   //"rts_email_sent@hrexecsonthemove.com"; // SMTP account username
$mail->Password      = "ryazan";  //"rts0214";        // SMTP account password
//$mail->SetFrom('rts_email_sent@ctosonthemove.com', 'ctosonthemove.com');
$mail->SetFrom('ms@hrexecsonthemove.com', 'hrexecsonthemove.com');
//$mail->AddReplyTo('ms@ctosonthemove.com', 'ctosonthemove.com');
$mail->AddReplyTo($from_admin, 'hrexecsonthemove.com');
$mail->Subject       = "Report of companies that have different personal pattern";

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




$cto = mysql_connect("10.132.233.131","ctou2","ToC@!mvCo23") or die("Database CTO ONE ERROR ");
mysql_select_db("ctou2",$cto) or die ("ERROR: Database not found ");

$output = "";
//$comp_q = "select cm.email_domain,cm.email_pattern_id from cto_company_master as cm,cto_movement_master as mm,cto_personal_master as pm where pm.personal_id = mm.personal_id and mm.company_id = cm.company_id and email_pattern_id is not null and email_domain != '' and email_pattern_id > 0 order by cm.company_id desc LIMIT 0,5";
$comp_q = "select company_name,company_id,email_domain,email_pattern_id,company_website from cto_company_master where email_pattern_id > 0 and email_domain != ''  order by company_id desc LIMIT 60,300";

//echo "<br>Comp Q: ".$comp_q;

//$companyResult = mysql_query("select company_id,email_domain from cto_company_master where email_pattern_id is null and email_domain != '' order by company_id desc LIMIT 0,500",$cto);

$companyResult = mysql_query($comp_q);

while($companyRow = mysql_fetch_array($companyResult))
{
    //$comp_q = "select pm.email, cm.email_domain,cm.email_pattern_id from cto_company_master as cm,cto_movement_master as mm,cto_personal_master as pm where pm.personal_id = mm.personal_id and mm.company_id = cm.company_id and email_pattern_id is not null and email_domain != '' and email_pattern_id > 0 order by cm.company_id desc LIMIT 0,5";
    $company_id = $companyRow['company_id'];
    //$email = $companyRow['email'];
    $email_domain = $companyRow['email_domain'];
    $email_pattern_id = $companyRow['email_pattern_id'];
    $company_name = $companyRow['company_name'];
    $company_website = $companyRow['company_website'];
    
    $per_q = "select pm.first_name,pm.middle_name,pm.last_name,pm.email from cto_company_master as cm,cto_movement_master as mm,cto_personal_master as pm where cm.company_id = mm.company_id and mm.personal_id = pm.personal_id and cm.company_id = ".$company_id;
    
    
    
    $pResult = mysql_query($per_q);
    
    $p_num_rows = mysql_num_rows($pResult);
    
    //echo "<br><br><br>per_q: ".$per_q."      Rows: ".$p_num_rows."      company pattern: ".$email_pattern_id;
    
    if($p_num_rows > 0) //  && $email_pattern_id > 0
    {    
    
        while($pRow = mysql_fetch_array($pResult))
        {
            $p_email = $pRow['email'];
            
            /*
            echo "<br>First Name: ".$pRow['first_name'];
            echo "<br>Middle Name: ".$pRow['middle_name'];
            echo "<br>Last Name: ".$pRow['last_name'];
            echo "<br>Email domain: ".$email_domain;
            echo "<br>Email: ".$pRow['email'];
             */

            $person_pattern = getting_email_pattern(strtolower($pRow['first_name']),strtolower($pRow['middle_name']),strtolower($pRow['last_name']),strtolower($email_domain),strtolower($pRow['email']));
            
            //echo "<br>personal email: ".$p_email." pattern: ".$person_pattern;
            
            if($person_pattern != $email_pattern_id && $person_pattern != '')
            {
                //$output .= "<br>($company_id) Company Name= '".$company_name."' pattern is ".$email_pattern_id.". However, personal ".$pRow['first_name']." ".$pRow['last_name']." with email= '$p_email' have another email pattern ".$person_pattern;
                $output .= "<br>Company Name= '".$company_name."', URL='".$company_website."', Company pattern= ".$email_pattern_id.", Personal Pattern= ".$person_pattern;
            }    
        }
    }
    
}
//echo "<br><br><br>=============================================<br><br><br>";
echo $output;



$emailContent = $output;
//$email = 'farazaleem@gmail.com';
$email = 'faraz.aia@nxvt.com';
$user_first_name = 'faraz';

$mail->MsgHTML($emailContent);

$mail->AddAddress($email, $user_first_name);

if(!$mail->Send()) 
{
    echo $str_error ="Mailer Error (" . str_replace("@", "&#64;", $email) . ') ' . $mail->ErrorInfo;
    //$inserError = "insert into ".TABLE_MAILER_ERROR."(str_error,email,alert_id,add_date) values('$str_error','$email','$alert_id','".date("Y-m-d")."')";
    //com_db_query($inserError);

} 
$mail->ClearAddresses();


?>