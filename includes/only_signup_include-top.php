<?php
// Set the level of error reporting
  error_reporting(E_ALL & ~E_NOTICE);
  

// include the list of project database tables
  require("../".DIR_INCLUDES . 'define-tables.php'); 

// include the database functions
  require("../".DIR_FUNCTIONS . 'database.php');
  
// make a connection to the database... now
  com_db_connect() or die('Unable to connect to database server!');

// define our common functions used application-wide
  require("../".DIR_FUNCTIONS . 'common.php');
  require("../".DIR_FUNCTIONS . 'siteuse.php');
  
 // define how the session functions will be used
  require("../".DIR_FUNCTIONS . 'sessions.php');
  
  //Admin login/forgotton password function
  require("../".DIR_FUNCTIONS . 'password_func.php');
// lets start our session
  com_session_start();

  
 $current_page = basename($_SERVER['PHP_SELF']);
  
?>