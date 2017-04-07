<?php
// define path parameters
  define('DIR_INCLUDES', 'includes/');
  define('DIR_FUNCTIONS', DIR_INCLUDES . 'functions/');
  define('DIR_MENU', DIR_INCLUDES . 'menu/');
  define('DIR_CLASSES', DIR_INCLUDES . 'classes/');
  define('DIR_MODULES', DIR_INCLUDES . 'modules/');
// define our database connection
  define('DB_SERVER', 'localhost'); //Server Name
  define('DB_SERVER_USERNAME', 'ctou2');//User Name
  //define('DB_SERVER_PASSWORD', 'wTjP!399RD');//Password
  //define('DB_SERVER_PASSWORD', 'fAPs321az');//Password
  define('DB_SERVER_PASSWORD', 'ToC@!mvCo23');//Password
  define('DB_DATABASE', 'ctou2');//Database name


// database table prefix
  define('DB_TABLE_PREFIX' , 'cto_');

// Site url
  define('HTTP_SITE_URL' , "http://" . $_SERVER['HTTP_HOST'] . "/");
  //define('HTTPS_SITE_URL' , "https://" . $_SERVER['HTTP_HOST'] . "/");
  
  define('HTTPS_SITE_URL' , "http://" . $_SERVER['HTTP_HOST'] . "/");
  
?>