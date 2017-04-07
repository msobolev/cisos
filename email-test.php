<?php
//
//require 'PHPMailer-master/PHPMailerAutoload.php';

//mx Record
//smtp.secureserver.net
//mailstore1.secureserver.net

//Host Name
//pop.secureserver.net
//imap.secureserver.net
//smtpout.secureserver.net

/*include("PHPMailer-master/PHPMailerAutoload.php");


$mail = new PHPMailer();

$mail->From     = 'ms@ctosonthemove.com';
$mail->FromName = 'Misha Sobolev';
$mail->Host     = 'smtpout.secureserver.net';//'smtp1.example.com;smtp2.example.com';
$mail->Mailer   = 'smtp';

$body  = "Hello <font size=\"4\">Ananga Samanta</font>, <p>";
$body .= "<i>Your</i> personal photograph to this message.<p>";
$body .= "Sincerely, <br>";
$body .= "phpmailer List manager";
	
$mail->Body    = $body;
$mail->AltBody = $body;
//$mail->addAddress('ramani88@yahoo.co.in', 'Ramani Nayak');
$mail->addAddress('jasbir712@gmail.com', 'Jasbir');
//$mail->addStringAttachment($row['photo'], 'YourPhoto.jpg');

if(!$mail->send())
	echo "There has been a mail error sending to " . 'Jasbir' . "<br>";

// Clear all addresses and attachments for next loop
$mail->clearAddresses();
$mail->clearAttachments();*/

//

//error_reporting(E_ALL);
//error_reporting(E_STRICT);

date_default_timezone_set('America/Toronto');

require_once('PHPMailer/class.phpmailer.php');
//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

$mail                = new PHPMailer();

//$body                = file_get_contents('contents.html');
//$body                = eregi_replace("[\]",'',$body);
$body  = "Hello <font size=\"4\">Ananga Samanta</font>, <p>";
$body .= "<i>Your</i> personal photograph to this message.<p>";
$body .= "Sincerely, <br>";
$body .= "phpmailer List manager";


$mail->IsSMTP(); // telling the class to use SMTP
$mail->SMTPAuth      = true;                  // enable SMTP authentication
$mail->SMTPKeepAlive = true;                  // SMTP connection will not close after each email sent
$mail->Host          = "smtpout.secureserver.net"; // sets the SMTP server
$mail->Port          = 25;    // 465               // 26 set the SMTP port for the GMAIL server
$mail->Username      = "rts_email_sent@ctosonthemove.com"; // SMTP account username
$mail->Password      = "rts0214";        // SMTP account password
$mail->SetFrom('rts_email_sent@ctosonthemove.com', 'List manager');
$mail->AddReplyTo('ms@ctosonthemove.com', 'List manager');

$mail->Subject       = "PHPMailer Test Subject via smtp, basic with authentication";

//@MYSQL_CONNECT("localhost","root","password");
//@mysql_select_db("my_company");
//$query  = "SELECT full_name, email, photo FROM employee WHERE id=$id";
//$result = @MYSQL_QUERY($query);

///while ($row = mysql_fetch_array ($result)) {
  $email = 'ananga73@gmail.com';
  $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
  $mail->MsgHTML($body);
  $mail->AddAddress($email, 'Ananga');
 // $mail->AddStringAttachment($row["photo"], "YourPhoto.jpg");

  if(!$mail->Send()) {
    echo "<br>Mailer Error (" . str_replace("@", "&#64;", $email) . ') ' . $mail->ErrorInfo . '<br />';
  } else {
    echo "<br>Message sent to :" . $row["full_name"] . ' (' . str_replace("@", "&#64;",$email) . ')<br />';
  }
  // Clear all addresses and attachments for next loop
  $mail->ClearAddresses();
  $mail->ClearAttachments();
//}
echo '<strong>Auto email send compiled</strong>';

?>
