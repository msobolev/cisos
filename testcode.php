<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--<html xmlns="http://www.w3.org/1999/xhtml">-->
<html lang="en" itemscope itemtype="http://schema.org/Person">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
</head>	
<body>
<?PHP

$keys = array('','key1','key2','key3');
$this_key_counter = 0;
$current_key = 1;
$key = $keys[1];
for($i=0;$i<50;$i++)
{
    /*
    if($i % 5 == 0)
    {   
        $remainder = $i % 5;
        $key = "key_one";
    }    
    elseif($i % 10 == 0)
    {
        $remainder = $i % 10;
        $key = "key_two";
    }    
    elseif($i % 15 == 0)
    {
        $remainder = $i % 15;
        $key = "key_three";
    }
    */
    $this_key_counter++;
    if($this_key_counter == 6)
    {
        $this_key_counter = 1;
        if($current_key == 1)
        {    
            $current_key = 2;
            $key = $keys[$current_key];
        }    
        elseif($current_key == 2)
        {    
            $current_key = 3;
            $key = $keys[$current_key];
        }    
        elseif($current_key == 3)
        {    
            $current_key = 1;
            $key = $keys[$current_key];
        }    
        
    }    
    
    
    echo "<br><br>i= ".$i; 
    //echo "&nbsp;&nbsp;&nbsp;&nbsp;remainder= ".$remainder; 
    echo "&nbsp;&nbsp;&nbsp;&nbsp;This_key_counter= ".$this_key_counter; 
    echo "&nbsp;&nbsp;&nbsp;&nbsp;Current_key= ".$current_key; 
    echo "&nbsp;&nbsp;&nbsp;&nbsp;key= ".$key; 
    
}
die();
//$str = "SWOT Analysis of the Digital Ecosystem – Weaknesses and Threats";
//echo stripslashes($str);


//error_reporting(E_ALL);
//ini_set('display_errors',1);
//ini_set('display_startup_errors',1);


/*
$email = "faraz_aleem@hotmail.com";
$subject = "Test sub";
$message = "Test msg";

$returnaddress = "farazaleem@gmail.com";
mail($email, $subject, $message,"From: $returnaddress\n". "Reply-To: $returnaddress\n". "Return-Path: $returnaddress");
echo "<br>Email send 1";





$headers = "From: farazaleem@gmail.com\r\nReply-To: farazaleem@gmail.com";
$additional = "-farazaleem@gmail.com";
mail("faraz_aleem@hotmail.com", "Subject", "Message",$headers, $additional); 
echo "<br>Email send 2";
*/


// the message
$msg = "First line of textSecond line of text";
// use wordwrap() if lines are longer than 70 characters
//$msg = wordwrap($msg,70);
// send email
$ret = mail("faraz_aleem@hotmail.com","My subject",$msg);
if($ret) 
{
    echo "<br>Send";
}    
else
{    
    echo "<br>Failed";
}    
echo "<br>Email send 3";


$to      = 'faraz_aleem@hotmail.com';
$subject = 'the subject';
$message = 'hello';
$headers = 'From: admin@ctosonthemove.com' . "\r\n" .
    'Reply-To: admin@ctosonthemove.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);
echo "<br>Email send 4";

die();

?>
<a href="invoices/test-invoice.doc">Invoice for 2016-04-19</a>    
<?PHP    
die();
$filename = 'invoices/test-invoice.doc';
                $handle = fopen($filename, 'w');
                $somecontent = "<b>This is test content</b><br><br>Second line<br><br>";
                $somecontent .=  "<div width=300px align=center style=\"\"><span style=\"color:#CDCDCD;font-size:24px;\">faraztest.com</span><br><strong>INVOICE # 33445</strong></div><br>";
                fwrite($handle, $somecontent);
                fclose($handle);
                
                die();



function get_months($date1, $date2) 
{
	$time1 = strtotime($date1);
	$time2 = strtotime($date2);
	$my = date('mY', $time2);

	$months = array(date('F Y', $time1));

	while($time1 < $time2) {
	$time1 = strtotime(date('Y-m-d', $time1).' +1 month');
	if(date('mY', $time1) != $my && ($time1 < $time2))
	$months[] = date('F Y', $time1);
	}

	$months[] = date('F Y', $time2);
	return $months;
}


function this_user_invoices()
{
	$invoice_dates = array();
	$find_invoices_query = com_db_query("select * from ".TABLE_INVOICES." where user_id='6357' and appear_date <= now()");
	if($find_invoices_query)
	{
		$invoice_num = com_db_num_rows($find_invoices_query);
		if($invoice_num > 0)
		{
			$invoice_row = com_db_fetch_array($find_invoices_query);
			$appear_date = $invoice_row['appear_date'];
			$due_date = $invoice_row['payment_due_date'];

			$d1 = new DateTime($appear_date);
			//$d2 = new DateTime(date("Y-m-d"));
			$d2 = new DateTime($due_date);
			$no_of_months = $d1->diff($d2)->m;
			
			for($i = 0; $i<$no_of_months+1;$i++)
			{
				$time_2 = strtotime($appear_date);
				$final = date("Y-m-d", strtotime("+$i month", $time_2));
				$invoice_dates[] = $final;
			}
		}
	}
	echo "<pre>invoice_dates: ";	print_r($invoice_dates);	echo "</pre>";

}





// FOR INVOICE FRONT END
$if = 1;
if($if == 1)
{
	include("includes/include-top.php");
	
	
	this_user_invoices();
	die();
	
	
	//$alert_result = com_db_query("select * from ".TABLE_INVOICES." where user_id='6357' order by add_date desc");	
	echo "select * from ".TABLE_INVOICES." where user_id='6357' and appear_date <= now()";
	$find_invoices_query = com_db_query("select * from ".TABLE_INVOICES." where user_id='6357' and appear_date <= now()");	
	//echo "<br><br>find_invoices_query: ".$find_invoices_query;
	if($find_invoices_query)
	{
		$invoice_num = com_db_num_rows($find_invoices_query);
		if($invoice_num > 0)
		{
			$invoice_row = com_db_fetch_array($find_invoices_query);
			$appear_date = $invoice_row['appear_date'];
			$due_date = $invoice_row['payment_due_date'];
			
			if($_GET['n'] == 1)
			{
				//echo "<br>appear_date: ".$appear_date;
				//echo "<br>month of appear_date: ".substr($appear_date,5,2);
				
				$time = strtotime($appear_date);
				$final = date("Y-m-d", strtotime("+1 month", $time));
				echo "<br>month of final: ".$final;
				$cc = 1;
				$today_date = date("Y-m-d");
				echo "<br>today_date: ".$today_date;
				while($final < $today_date)
				{
					$cc++;
					echo "<br>cc: ".$cc;
					$final = "'".$final."'";
					
					$final = date("Y-m-d", strtotime("+$cc month", $final));
					echo "<br>month of final: ".$final;
				}
				
			}
			//die();
			
			// finding number of invoices
			
			//$date1 = date_create("2013-01-15 17:13:10");
			//$date2 = date_create("2013-03-18 17:21:0");
			
			/*
			if(1 == 2)
			{
			//echo "<br>appear_date before strtotime: ".$appear_date;
			//$appear_date = strtotime($appear_date);
			echo "<br>appear_date after strtotime: ".$appear_date;
			echo "<br>appear_date: ".$appear_date;
			
			//$date1 = new DateTime($appear_date);
			
			
			$newDateObj = DateTime::createFromFormat("d/m/Y", $appear_date);
			$newDate = $newDateObj->format('d/m/Y'); 
			
			
			echo "<br>newDate: ".$newDate;
			
			$date1 = $newDate;
			
			//$date1 = date_create($appear_date." 00:00:00");
			//$date2 = date_create(date("Y-m-d"));
			
			
			
			
			$date2 = date_create(strtotime("now"));
			//strtotime("now"), "\n";
			
			
			echo "<br>date1: ".$date1;
			echo "<br>date2: ".$date2;
			
			$diff=date_diff($date1,$date2);
			
			echo "<pre>";	print_r($diff);	echo "</pre>";
			}
			*/
			
			//$date1 = '2000-01-25';
			//$date2 = '2010-05-27';
			
			/*
			if( 1 == 2)
			{
			$date1 = $appear_date;
			$date2 = date("Y-m-d");
			
			
			echo "<br>date1: ".$date1;
			echo "<br>date2: ".$date2;

			$ts1 = strtotime($date1);
			$ts2 = strtotime($date2);

			$year1 = date('Y', $ts1);
			$year2 = date('Y', $ts2);

			$month1 = date('m', $ts1);
			$month2 = date('m', $ts2);

			$diff = (($year2 - $year1) * 12) + ($month2 - $month1);

			$mon_diff = $month2 - $month1;
			
			echo "<br>diff: ".$diff;
			echo "<br>mon_diff: ".$mon_diff;
			
			}
			*/
			//$date1 = $appear_date;
			//$date2 = date("Y-m-d");

			//echo "<br>date1: ".$date1;
			//echo "<br>date2: ".$date2;	

			//echo "<pre>";	print_r(get_months($date1, $date2)); echo "</pre>";
			//
			$d1 = new DateTime($appear_date);
			//$d2 = new DateTime(date("Y-m-d"));
			$d2 = new DateTime($due_date);
			
			echo "<br><br>D1:";
			var_dump($d1);
			echo "<pre>";	print_r($d1);	echo "</pre>";
			
			echo "<br><br>D2:";
			var_dump($d2);
			echo "<pre>";	print_r($d2);	echo "</pre>";

			
			$no_of_months = $d1->diff($d2)->m;
			echo "<br><br><br>Difference in months: ".$d1->diff($d2)->m;
			echo "<br><br><br>Month: ".$month = date("m",strtotime($appear_date));
			
			$time = strtotime($appear_date);
			echo "<br><br>--->>>time: ".$time;
			
			
			for($i = 0; $i<$no_of_months+1;$i++)
			{	
				echo "<br><br><br><br>i: ".$i;
				echo "<br>appear_date: ".$appear_date;
				$time_2 = strtotime($appear_date);
				echo "<br>time: ".$time_2;
				
				$final = date("Y-m-d", strtotime("+$i month", $time_2));
				echo "<br>month of final in ($i): ".$final;
				
				
				/*
				if($i == 1)
				{
					$final = date("Y-m-d", strtotime("+1 month", $time_2));
					echo "<br>month of final in ($i): ".$final;
				}	
				elseif($i == 2)
				{
					$final = date("Y-m-d", strtotime("+2 month", $time_2));	
					echo "<br>month of final in ($i): ".$final;
				}	
				elseif($i == 3)
				{
					$final = date("Y-m-d", strtotime("+3 month", $time_2));	
					echo "<br>month of final in ($i): ".$final;
				}	
				elseif($i == 4)
				{
					$final = date("Y-m-d", strtotime("+4 month", $time_2));	
					echo "<br>month of final in ($i): ".$final;
				}	
				*/
				
				/*
				echo "<br>Invoice for ".date("m",strtotime($appear_date));
				if($i > 0)
				{
					$increment = 30*$i;
					echo "<br>increment: ".$increment;
					echo "<br>appear_date: ".$appear_date;
					$incemented_date = date($appear_date, strtotime("+$increment days"));
					//$incemented_date = date('Y-m-d',strtotime($date) + );
					echo "<br>incemented_date: ".$incemented_date;
					echo "<br>Invoice for $i: ".date("m",strtotime($incemented_date));
				}	
				else
				{
					echo "<br>Invoice for $i: ".date("m",strtotime($appear_date));
				}
				*/
				//echo $month = date("m",strtotime($appear_date));
			}
			
			
			
			
			
			
			
			
		}
	}
		
	
	//while($indus_row = com_db_fetch_array($industry_result)){
}
echo "<br>appear_date: ".$appear_date;








echo "<br><br><br><br>=========================<br><br><br>";


//
//$date1 = com_db_query("select email_time from ". TABLE_SITE_DOWN." order by email_send_id desc limit 0,1");
//$date2 =  date("Y-m-d:H:i:s");

$date1 = date_create("2013-01-15 17:13:10");
$date2 = date_create("2013-03-18 17:21:0");
$diff=date_diff($date1,$date2);
//echo "Diff: ".$diff;

echo "<pre>";	print_r($diff);	echo "</pre>";
if(1 == 2)
{
	if($diff['h'] == 0 && $diff['i'] > 30)
	{
		echo "<br><br>Send Email";
		//com_db_query("insert into ". TABLE_SITE_DOWN."(email_time) values('".date("Y-m-d:H:i:s")."')");
		com_db_query("insert into ". TABLE_SITE_DOWN."(email_time) values('".$date2."')");
	}
	else
		echo "<br><br>Don't Send Email";

}



?>
</body>
</html>