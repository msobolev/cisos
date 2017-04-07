<?php

// define path parameters



  define('HTTP_SERVER', "http://" . $_SERVER['HTTP_HOST'] . "/");

  define('HTTPS_SERVER', "https://" . $_SERVER['HTTP_HOST'] . "/");

  define('ENABLE_SSL', true);

  

   //define folder

  define('DIR_WS_HTTP_FOLDER', '');

  define('DIR_WS_HTTPS_FOLDER', '');

  define('DIR_INCLUDES', 'includes/');

  define('DIR_FUNCTIONS', DIR_INCLUDES. '/functions/');

  define('DIR_CSS','css/');

  define('DIR_JS','js/');

  define('DIR_IMAGES','images/');

  define('DIR_TEAM_IMAGE','team_photo/thumb/');

  define('DIR_WHITE_PAPER','white_paper/');

  

// define our database connection

  //define('DB_SERVER', 'localhost'); //Server Name
  define('DB_SERVER', '10.132.233.131');
  //define('DB_SERVER', 'http://104.131.33.75'); //Server Name

  define('DB_SERVER_USERNAME', 'ctou2');//User Name

  //define('DB_SERVER_PASSWORD', 'wTjP!399RD');//Password
  //define('DB_SERVER_PASSWORD', 'fAPs321az');//Password
  define('DB_SERVER_PASSWORD', 'ToC@!mvCo23');//Password

  define('DB_DATABASE', 'ctou2');//Database name

  

// database table prefix

  define('DB_TABLE_PREFIX' , 'cto_');

// Site url

 define('HTTP_SITE_URL' , "https://" . $_SERVER['HTTP_HOST'] . "/");

 define('HTTP_CTO_URL' , "https://" . $_SERVER['HTTP_HOST'] . "/");

//meta tag
 
// hrexecbuff 
define("CLIENT_ID", "56090522e5e36e86624319f6");
define("CLIENT_SECRET", "75e96fc8c61f9ee06085a4ce94980afb");
//define("REDIRECT_URI", "https://www.ctosonthemove.com/advance-search.php");
define("REDIRECT_URI", "https://www.hrexecsonthemove.com/bufferapi/oauth_callback.php");
//define("LOGIN_URI", "https://login.salesforce.com");
define("LOGIN_URI", "https://bufferapp.com");
 
define("ONE_ACCESS_TOKEN", "1/da139bf9b4858e0213bbfefb5f801571"); 
define("HREXECS_TWITTER_PROFILE_ID", "559671d305b60c5c335af3b9");  

?>
