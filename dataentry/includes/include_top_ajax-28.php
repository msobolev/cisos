<?php
// Set the level of error reporting
  error_reporting(E_ALL & ~E_NOTICE);
  
// include the list of project database tables
  require("includes/". 'configuration.php');  
  
// include the list of project database tables
  require("includes/". 'define-tables.php');  


// include the database functions
  require("includes/functions/". 'database.php');

// make a connection to the database... now
  com_db_connect() or die('Unable to connect to database server!');

 
// define our common functions used application-wide
  require("includes/functions/". 'common.php');


?>