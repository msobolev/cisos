<?php
// all session functions are here

  function com_session_start() {
    return session_start();
  }

  function com_session_register($variable) {
    return session_register($variable);
  }

  function com_session_is_registered($variable) {
    return session_is_registered($variable);
  }

  function com_session_unregister($variable) {
    return session_unregister($variable);
  }

  function com_session_id($sessid = '') {
    if ($sessid != '') {
      return session_id($sessid);
    } else {
      return session_id();
    }
  }
/*
  function com_session_name($name = '') {
    if ($name != '') {
      return session_name($name);
    } else {
      return session_name();
    }
  }
*/

  function com_session_destroy() {
    return session_destroy();
  }


  function com_set_sess_value($variable , $sess_value) {
  	if(com_session_is_registered($variable)){
		com_session_register($variable);
	} else {	
  		com_session_register($variable);				
    }
	$_SESSION[$variable] = $sess_value;
    return true;
  }



?>