<?php
// Set the level of error reporting
  error_reporting(E_ALL & ~E_NOTICE);
  
// Include application configuration parameters
  require('includes/configuration.php');

// Define the project version
  define('PROJECT_VERSION', 'PMS 1.0'); 
 

// include the list of project database tables
  require(DIR_INCLUDES . 'define_db_tables.php'); 


// include the database functions
  require(DIR_FUNCTIONS . 'database.php');

// make a connection to the database... now
  com_db_connect() or die('Unable to connect to database server!');

 
// define our common functions used application-wide
  require(DIR_FUNCTIONS . 'common.php');


?>