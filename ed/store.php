<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$hre  = mysqli_connect("localhost","root","mycisobd123!","ctou2") or die("Database ERROR ");
//mysql_select_db("hre2",$hre) or die ("ERROR: Database not found ");

//echo "<pre>REQ: ";   print_r($_REQUEST);   echo "</pre>";


$to = $_GET['to'];
$from_name = $_GET['from_name'];
$from_email = $_GET['from_email'];

//echo "<br><br>To:".$to."<br><br><br><br>";
$init_p = strpos($from_email,'@')+1;
//echo "<br>init_p: ".$init_p;
//die();
$domain = substr($from_email,$init_p,strlen($from_email));
//echo "<br><br>Domain:".$domain."<br><br><br><br>";


$banned = 0;
$sql_query = "select * from hre_banned_domain";
$exe_data = mysqli_query($hre,$sql_query);
while ($data_sql = mysqli_fetch_array($exe_data)) 
{
    //echo "<br>".$data_sql['domain_name'];
    if($data_sql['domain_name'] == $domain)
    {
        $banned = 1;
    }    
}
//echo "<br>Banned: ".$banned;
if($banned == 1)
{    
    echo 1;
    return;
}    





//echo "<pre>GET: ";   print_r($_GET);   echo "</pre>";
//echo "From Name: ".$from_name;

$ins_q = "INSERT into hre_profile_history(to_email,from_name,from_email) values('".$to."','".$from_name."','".$from_email."')";
$data_rs = mysqli_query($hre,$ins_q);


/*
$email_to      = 'faraz.aia@nxvt.com';
$subject = 'User submitted form on profile page';
$message = 'Below is details of user who filled form on profile page:';
$message .= "\r\n";
$message .= "From Name: ".$from_name;
$message .= "\r\n";
$message .= "From Email: ".$from_email;
$message .= "\r\n";
$message .= "To: ".$to;

$headers = 'From: ms@hrexecsonthemove.com' . "\r\n" .
    'Reply-To: ms@hrexecsonthemove.com' . "\r\n" .
    '';

mail($email_to, $subject, $message, $headers);
*/



$email_details = 'Below is details of user who filled form on profile page:';
$email_details .= "<br><br>";
$email_details .= "From Name: ".$from_name;
$email_details .= "<br><br>";
$email_details .= "From Email: ".$from_email;
$email_details .= "<br><br>";
$email_details .= "To: ".$to;

//$email_details = "test msg";
$email_to      = 'ms@ctosonthemove.com';
$from_admin = "";


require_once('../PHPMailer/class.phpmailer.php');
$mail                = new PHPMailer();

$mail->IsSMTP(); // telling the class to use SMTP
$mail->SMTPAuth      = true;                  // enable SMTP authentication
$mail->SMTPKeepAlive = true;                  // SMTP connection will not close after each email sent
$mail->Host          = "smtpout.secureserver.net";//"relay-hosting.secureserver.net"; // sets the SMTP server relay-hosting.secureserver.net smtpout.secureserver.net
$mail->Port          = 80;    // 80, 3535, 25, 465 (SSL)      // 26 set the SMTP port for the GMAIL server
$mail->Username      = "misha.sobolev@execfile.com"; // SMTP account username
$mail->Password      = "ryazan";        // SMTP account password
//$mail->SetFrom('rts_email_sent@ctosonthemove.com', 'ctosonthemove.com');
//$mail->SetFrom('ms@ctosonthemove.com', 'ctosonthemove.com');
//$mail->SetFrom('info@ctosonthemove.com', 'ctosonthemove.com');
//$mail->AddReplyTo($from_admin, 'ctosonthemove.com');

//$mail->SetFrom('info@ctosonthemove.com', 'ctosonthemove.com'); // WORKING FINE
$mail->SetFrom('ms@hrexecsonthemove.com', 'hrexecsonthemove.com');
//$mail->SetFrom(' updates@actionablenews.com');
$mail->AddReplyTo($from_admin, 'hrexecsonthemove.com');

$mail->Subject       = "User submitted form on profile page";

//$emailContent = $message; 
//$email_details = "Test content";	
//echo "<br>entered_person_email: ".$entered_person_email;
//echo "<br>email_details: ".$email_details;

$mail->MsgHTML($email_details);
$mail->AddAddress($email_to, "FARAZ");

if(!$mail->Send()) 
{
        //$result ="Mailer Error (" . str_replace("@", "&#64;", $email) . ') ' . $mail->ErrorInfo;
        //$result = "Eror In  Email Sending";
}
else
{
        //$result = " Email Send";
}


?>