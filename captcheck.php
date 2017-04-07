<?php
// continue the session so we can access the session variable 
session_start(); 
// Make posted code into upper case, then compare with the stored string 
if($_GET['code'] != $_SESSION['securitycode']) 
{
 	echo '0'; // failed 
} else { 
	echo '1'; // passed 
} 
?>