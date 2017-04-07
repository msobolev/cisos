<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$msg = "First line of textSecond line of text";
// use wordwrap() if lines are longer than 70 characters
//$msg = wordwrap($msg,70);
// send email
$ret = mail("faraz_aleem@hotmail.com","My subject",$msg);
if(!$ret) 
{
    echo "<br>Failed";
    echo "<pre>"; print_r(error_get_last());   echo "</pre>";
    
    
}    
echo "<br>Email send 3";



$to = "faraz_aleem@hotmail.com";
$subject = "My subject";
$txt = "Hello world!";
$headers = "From: admin@ctosonthemove.com" . "\r\n" .
"CC: admin@ctosonthemove.com";

mail($to,$subject,$txt,$headers);
echo "<pre>"; print_r(error_get_last());   echo "</pre>";
echo "<br>Email send 4";

/*
$to      = 'faraz_aleem@hotmail.com';
$subject = 'the subject';
$message = 'hello';
$headers = 'From: admin@ctosonthemove.com' . "\r\n" .
    'Reply-To: admin@ctosonthemove.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);
echo "<br>Email send 4";
*/


?>