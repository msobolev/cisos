<?php
// This funstion validates a plain text password with an
// encrpyted password
  function com_validate_password($plain, $encrypted) {
    if (($plain != '') && ($encrypted != '')) {
      if (md5($plain) == $encrypted) {
        return true;
      }else{
	  	return false;
	  }
   }
  } 


// This function makes a new password from a plaintext password. 
  function com_encrypt_password($plain) {
    $password = '';
    $password = md5($plain);

    return $password;
  }
?>