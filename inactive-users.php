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
$mail->Subject       = "List of Inactive Users on CTO";



function subDate($days)
{
    $date = date('Y-m-j');
    $duration='-'.$days.' day';
    $newdate = strtotime ( $duration , strtotime ( $date ) ) ;
    $newdate = date ( 'Y-m-j' , $newdate );
    return $newdate;
}

$hre = mysql_connect("localhost","ctou2","ToC@!mvCo23") or die("Database CTO ONE ERROR ");
mysql_select_db("ctou2",$hre) or die ("ERROR: Database not found ");


//$hre = mysql_connect("localhost","hre2","htXP%th@71",TRUE) or die("Database ERROR ");
//mysql_select_db("hre2",$hre) or die ("ERROR: Database not found ");

$before_date = subDate('7');

$companyResult = mysql_query("select first_name,last_name,email,res_date from cto_user where status = 1 and res_date > '".$before_date."'",$hre);
//echo "<br>select first_name,last_name,email,res_date from cto_user where status = 1 and res_date > '".$before_date."'";
//echo "<br><br>";
$cnt = 0;

$msg = "Below is list of inactive user for past week on CTO:<br><br>";
while($companyRow = mysql_fetch_array($companyResult))
{
    $first_name = $companyRow['first_name'];
    $last_name = $companyRow['last_name'];
    $email = $companyRow['email'];
    $res_date = $companyRow['res_date'];
    
    $msg .= "<br>Name: ".$first_name." ".$last_name."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Email: ".$email."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Registration Date: ".$res_date;
    
}


$emailContent = $msg;
$email = 'misha.sobolev@gmail.com';
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

//echo "<br>MSG: ".$msg;


?>