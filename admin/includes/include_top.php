<?php

// removed in php 5.4, need local implementation
    function session_register(){ 
        $args = func_get_args(); 
        foreach ($args as $key){ 
            $_SESSION[$key]=$GLOBALS[$key]; 
        } 
    } 
    function session_is_registered($key){ 
        return isset($_SESSION[$key]); 
    } 
    function session_unregister($key){ 
        unset($_SESSION[$key]); 
    } 

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

//Admin login/forgotton password function
  require(DIR_FUNCTIONS . 'password_func.php');

  
  
  
// define how the session functions will be used
  require(DIR_FUNCTIONS . 'sessions.php');
  
// lets start our session
  com_session_start();


  $current_page = basename($PHP_SELF);



// default open navigation menu
  if (!session_is_registered('selected_menu')) {
    session_register('selected_menu');
    $selected_menu = 'index';
  }

  if (isset($_GET['selected_menu'])) {
    $selected_menu = $_GET['selected_menu'];
	$_SESSION['selected_menu'] = $selected_menu;
  }
  $selected_menu = $_SESSION['selected_menu'];
  


 if (basename($_SERVER['PHP_SELF']) != 'login.php' && basename($_SERVER['PHP_SELF']) != 'password_forgotten.php') { 
   com_admin_check_login(); 
}

if($_SESSION['login_access_type']=='User' && !($current_page =='logout.php' || $current_page =='index-staff.php')){
	$cpm_id = com_db_GetValue("select sm_id from ".TABLE_SUB_MENU." where page_name='".$current_page."'");
	$is_currant_page = com_db_GetValue("select usma_id from ".TABLE_USER_SUB_MENU_ALLOW." where user_id='".$_SESSION['login_id']."' and sm_id='".$cpm_id."'");
	if($is_currant_page==''){
		com_redirect('index-staff.php?selected_menu=general');
	}else{
		$btnResult = com_db_query("select madd,medit,mdelete,mstatus from ".TABLE_USER_SUB_MENU_ALLOW." where user_id='".$_SESSION['login_id']."' and sm_id='".$cpm_id."'");
		$btnRow = com_db_fetch_array($btnResult);
		$btnAdd = $btnRow['madd'];
		$btnEdit = $btnRow['medit'];
		$btnDelete = $btnRow['mdelete'];
		$btnStatus = $btnRow['mstatus'];
	}
}else{
	$btnAdd = 'Yes';
	$btnEdit = 'Yes';
	$btnDelete = 'Yes';
	$btnStatus = 'Yes';
}
?>