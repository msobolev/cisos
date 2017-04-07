<?php


/*  PHP Paypal IPN Integration Class Demonstration File
 *  4.16.2005 - Micah Carrick, email@micahcarrick.com
 *
 *  This file demonstrates the usage of paypal.class.php, a class designed  
 *  to aid in the interfacing between your website, paypal, and the instant
 *  payment notification (IPN) interface.  This single file serves as 4 
 *  virtual pages depending on the "action" varialble passed in the URL. It's
 *  the processing page which processes form data being submitted to paypal, it
 *  is the page paypal returns a user to upon success, it's the page paypal
 *  returns a user to upon canceling an order, and finally, it's the page that
 *  handles the IPN request from Paypal.
 *
 *  I tried to comment this file, aswell as the acutall class file, as well as
 *  I possibly could.  Please email me with questions, comments, and suggestions.
 *  See the header of paypal.class.php for additional resources and information.
*/

// Setup class
include("includes/include-top.php"); 
require_once('paypal.class.php');  // include the class file
$p = new paypal_class;             // initiate an instance of the class
//$p->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';   // testing paypal url
$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';     // paypal url
            
// setup a variable for this script (ie: 'http://www.micahcarrick.com/paypal.php')
$this_script = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

// if there is not action variable, set the default action of 'process'
if (empty($_GET['action'])) $_GET['action'] = 'process';  

switch ($_GET['action']) {
    
   case 'process':      // Process and order...

      // There should be no output at this point.  To process the POST data,
      // the submit_paypal_post() function will output all the HTML tags which
      // contains a FORM which is submited instantaneously using the BODY onload
      // attribute.  In other words, don't echo or printf anything when you're
      // going to be calling the submit_paypal_post() function.
 
      // This is where you would have your form validation  and all that jazz.
      // You would take your POST vars and load them into the class like below,
      // only using the POST values instead of constant string expressions.
 
      // For example, after ensureing all the POST variables from your custom
      // order form are valid, you might have:
      //
      // $p->add_field('first_name', $_POST['first_name']);
      // $p->add_field('last_name', $_POST['last_name']);
      
      $p->add_field('business', 'Mike_Sobolev@yahoo.com');//YOUR PAYPAL (OR SANDBOX) EMAIL ADDRESS HERE!//ananga_1275462143_biz@gmail.com
      $p->add_field('return', $this_script.'?action=success');
      $p->add_field('cancel_return', $this_script.'?action=cancel');
      $p->add_field('notify_url', $this_script.'?action=ipn');
      $p->add_field('item_name', 'Paypal Test Transaction');
      //$p->add_field('amount', '0');

      $p->submit_paypal_post(); // submit the fields to paypal
      //$p->dump_fields();      // for debugging, output a table of all the fields
      break;
      
   case 'success':      // Order was successful...
   
      // This is where you would probably want to thank the user for their order
      // or what have you.  The order information at this point is in POST 
      // variables.  However, you don't want to "process" the order until you
      // get validation from the IPN.  That's where you would have the code to
      // email an admin, update the database with payment status, activate a
      // membership, etc.  
 
      //echo "<html><head><title>Success</title></head><body><h3>Thank you for your order.</h3>";
	  $user_email = msg_decode($_REQUEST['eml']);
	  $user_password = msg_decode($_REQUEST['pw']);
      	foreach ($_POST as $key => $value) { 
			 if($key=='txn_type'){ $txn_type = $value;}
			 if($key=='subscr_id'){ $subscr_id = $value;}
			 if($key=='first_name'){ $first_name = $value;}
			 if($key=='last_name'){ $last_name = $value;}
			 if($key=='address_street'){ $address_street = $value;}
			 if($key=='address_city'){ $address_city = $value;}
			 if($key=='address_state'){ $address_state = $value;}
			 if($key=='address_zip'){ $address_zip = $value;}
			 if($key=='address_country'){ $address_country = $value;}
			 if($key=='business'){ $business_email = $value;}
			 if($key=='payer_email'){ 
				$payer_email = $value;
				$to	= $value;
				}
			 if($key=='receiver_email'){ $receiver_email = $value;}
			 if($key=='payer_id'){ $payer_id = $value;}
			 if($key=='subscr_date'){ $subscr_date = $value;}
			 if($key=='address_status'){ $address_status = $value;}
			 if($key=='mc_currency'){ $currency = $value;}
			 if($key=='verify_sign'){ $verify_sign = $value;}
			 if($key=='period3'){ $period = $value;}
			 if($key=='payment_date'){ $payment_date = $value;}
		   }
		   
	    $subscription_id = $_SESSION['sess_sub_choose'];
		$amount = com_db_GetValue("select amount from " . TABLE_SUBSCRIPTION . " where sub_id='".$subscription_id."'");
		if($amount > 0){
			$level = 'Paid';	
		}else{
			$level = 'Free';
		}
		
		$exp_date = date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('y')+10));
		$reg_date = date('Y-m-d');
		$res_query = "insert into ".TABLE_USER." (first_name,last_name,email,password,subscription_id,exp_date,res_date,level,payment_by,status) values ('$first_name','$last_name','$user_email','$user_password','$subscription_id','$exp_date','$reg_date','$level','User','0')";
		com_db_query($res_query);
		$res_id = com_db_insert_id();
		
		$payment_query = "insert into " . TABLE_PAYMENT . " (payment_type,user_id,first_name,last_name,transaction_id,add_date) values ('Registration','$res_id','$first_name','$last_name','$subscr_id','$reg_date')";
		com_db_query($payment_query);
		$payment_id = com_db_insert_id();
		
		$billing_query = "insert into " . TABLE_BILLING_ADDRESS . " (payment_id,user_id,address,address_cont,city,state,zip_code,country,add_date) values ('$payment_id','$res_id','$address_street','$address_cont','$address_city','$address_state','$address_zip','$address_country','$reg_date')";
		com_db_query($billing_query);
		
		session_unregister('sess_sub_choose');
		
		$url = 'sub-thank-you.php?ragName='.$first_name.' '.$last_name;
		com_redirect($url); 
      //echo "</body></html>";
      
      // You could also simply re-direct them to another page, or your own 
      // order status page which presents the user with the status of their
      // order based on a database (which can be modified with the IPN code 
      // below).
      
      break;
      
   case 'cancel':       // Order was canceled...

      // The order was canceled before being completed.
 
      //echo "<html><head><title>Canceled</title></head><body><h3>The order was canceled.</h3>";
     // echo "</body></html>";
	  $url = 'index.php';
	  com_redirect($url);
      
      break;
      
   case 'ipn':          // Paypal is calling page for IPN validation...
   
      // It's important to remember that paypal calling this script.  There
      // is no output here.  This is where you validate the IPN data and if it's
      // valid, update your database to signify that the user has payed.  If
      // you try and use an echo or printf function here it's not going to do you
      // a bit of good.  This is on the "backend".  That is why, by default, the
      // class logs all IPN data to a text file.
      $user_email = msg_decode($_REQUEST['eml']);
	  $user_password = msg_decode($_REQUEST['pw']);
      if ($p->validate_ipn()) {
          
         foreach ($p->ipn_data as $key => $value) { 
		 
		 if($key=='txn_type'){ $txn_type = $value;}
		 if($key=='subscr_id'){ $subscr_id = $value;}
		 if($key=='first_name'){ $first_name = $value;}
		 if($key=='last_name'){ $last_name = $value;}
		 if($key=='address_street'){ $address_street = $value;}
		 if($key=='address_city'){ $address_city = $value;}
		 if($key=='address_state'){ $address_state = $value;}
		 if($key=='address_zip'){ $address_zip = $value;}
		 if($key=='address_country'){ $address_country = $value;}
		 if($key=='business'){ $business_email = $value;}
		 if($key=='payer_email'){ 
		 	$payer_email = $value;
			$to	= $value;
			}
		 if($key=='receiver_email'){ $receiver_email = $value;}
		 if($key=='payer_id'){ $payer_id = $value;}
		 if($key=='subscr_date'){ $subscr_date = $value;}
		 if($key=='address_status'){ $address_status = $value;}
		 if($key=='mc_currency'){ $currency = $value;}
		 if($key=='verify_sign'){ $verify_sign = $value;}
		 if($key=='period3'){ $period = $value;}
		 if($key=='payment_date'){ $payment_date = $value;}
		 
		 }
		$subscription_id = $_SESSION['sess_sub_choose'];
		$amount = com_db_GetValue("select amount from " . TABLE_SUBSCRIPTION . " where sub_id='".$subscription_id."'");
		if($amount > 0){
			$level = 'Paid';	
		}else{
			$level = 'Free';
		}
	
		$exp_date = date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('y')+10));
		$reg_date = date('Y-m-d');
		$res_query = "insert into ".TABLE_USER." (first_name,last_name,email,password,subscription_id,exp_date,res_date,level,payment_by,status) values ('$first_name','$last_name','$user_email','$user_password','$subscription_id','$exp_date','$reg_date','$level','User','0')";
		com_db_query($res_query);
		$res_id = com_db_insert_id();
		
		$payment_query = "insert into " . TABLE_PAYMENT . " (payment_type,user_id,first_name,last_name,transaction_id,add_date) values ('Registration','$res_id','$first_name','$last_name','$subscr_id','$reg_date')";
		com_db_query($payment_query);
		$payment_id = com_db_insert_id();
		
		$billing_query = "insert into " . TABLE_BILLING_ADDRESS . " (payment_id,user_id,address,address_cont,city,state,zip_code,country,add_date) values ('$payment_id','$res_id','$address_street','$address_cont','$address_city','$address_state','$address_zip','$address_country','$reg_date')";
		com_db_query($billing_query);
		
		session_unregister('sess_sub_choose');
		
		$url = 'sub-thank-you.php?ragName='.$first_name.' '.$last_name;
		com_redirect($url); 
      }
      break;
 }     

?>
