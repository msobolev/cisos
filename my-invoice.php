<?PHP
//ini_set('display_errors',1);
//ini_set('display_startup_errors',1);
//error_reporting(-1);
include("includes/include-top.php");

$year = $_GET['year'];
$month = $_GET['month'];
$month_d = $_GET['month_d'];
$sequence = $_GET['sequence'];

$invoice_result = com_db_query("select * from " . TABLE_INVOICES . " where user_id='".$_SESSION['sess_user_id']."'");


if($invoice_result)
{
	$this_user_invoices = com_db_num_rows($invoice_result);	
	if($this_user_invoices > 0)
	{
		
		$invoice_static_details = com_db_query("select * from " . TABLE_INVOICES_STATIC_DETAILS);
		$invoiceStaticRow = com_db_fetch_array($invoice_static_details);
		$site_website = $invoiceStaticRow['site_website'];
		$site_address = $invoiceStaticRow['site_address'];
		$site_city = $invoiceStaticRow['site_city'];
		$site_zip_code = $invoiceStaticRow['site_zip_code'];
		$payable_to_name = $invoiceStaticRow['payable_to_name'];
                
		$from_name = $invoiceStaticRow['from_name'];
		$from_title = $invoiceStaticRow['from_title'];
		
		/*
                $filename = 'test-invoice.doc';
                $handle = fopen($filename, 'w');
                $somecontent = "This is test content";
                fwrite($handle, $somecontent);
                fclose($handle);
                */
                
                $fcont = "";
                
		header("Content-type: application/vnd.ms-word");
		header("Content-Disposition: attachment;Filename=Invoice-".$month."-".$year.".doc");

		echo "<html>";
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
		echo "<body>";
		//echo "<span style=\"font-size:16px;text-decoration:underline;\">My first document</span>";
		

	
	
	
		$invoiceRow = com_db_fetch_array($invoice_result);
		$to_name = $invoiceRow['to_name'];
		$to_company_name = $invoiceRow['to_company_name'];
		$to_title = $invoiceRow['to_title'];
		$to_address = $invoiceRow['to_address'];
		$to_city = $invoiceRow['to_city'];
		$to_state = $invoiceRow['to_state'];
		$to_zip_code = $invoiceRow['to_zip_code'];
		$payment_amount = $invoiceRow['payment_amount'];
		$payment_method = $invoiceRow['payment_method'];
		$invoice_no = $invoiceRow['invoice_no'];
		$invoice_no_step = $invoiceRow['invoice_no_step'];
		$payment_due_date = $invoiceRow['payment_due_date'];
		
		$due_din = substr($payment_due_date,8,2);
		$due_date = $month_d."/".$due_din."/".$year;
		
		
		$invoice_no = ($sequence*$invoice_no_step)+$invoice_no;
		
		echo "<div width=300px align=center style=\"\"><span style=\"color:#CDCDCD;font-size:24px;\">".$site_website."</span><br><strong>INVOICE # $invoice_no</strong></div><br>";
                $fcont .=  "<div width=300px align=center style=\"\"><span style=\"color:#CDCDCD;font-size:24px;\">".$site_website."</span><br><strong>INVOICE # $invoice_no</strong></div><br>";
                
		echo "<b>TO:</b><br>";
		$fcont .=  "<b>TO:</b><br>";
                
		if($to_name != '')
                {    
                    echo "$to_name<br>";
                }        
		if($to_title != '')
                {    
                    echo "$to_title, ";	
                }    
		if($to_company_name != '')	
                {    
                    echo "$to_company_name<br>";
                }
                if($to_address != '')		
                {    
                    echo "$to_address<br>";
                }    
		if($to_city != '')		
                {    
                    echo "$to_city, ";
                }    
		if($to_state != '')		
                {    
                    echo "$to_state";
                }    
		if($to_zip_code != '')
                {    
                    echo " $to_zip_code<br>";	
                }    
		
		echo "<br><br>";
		
		echo "<b>FROM:</b><br>";
		if($from_name != '')
			echo $from_name."<br>";
		if($from_title != '')
			echo $from_title."<br>";
		if($site_website != '')
			echo $site_website."<br>";	
		if($site_address != '')
			echo $site_address."<br>";
		if($site_city != '')
			echo $site_city."";	
		if($site_zip_code != '')
			echo ", ".$site_zip_code."<br>";		
			
		
		echo "<br>";
		
		echo "<b>RE:</b><br>";
		//echo "Subscription to $site_website - ".date("M")." ".date("o");
		echo "Subscription to $site_website - ".$month." ".$year;
		
		
		
		echo "<br><br>";
		echo "<b>PAYMENT AMOUNT:</b><br>";
		echo "US$".$payment_amount." / month";
		
		echo "<br><br>";
		echo "<b>PAYMENT DUE:</b><br>";
		echo $due_date."";
		
		echo "<br><br>";
		echo "<b>PAYMENT METHOD:</b><br>";
		echo str_replace("_"," ",$payment_method)."";
		
		echo "<br><br>";
		echo "<b>PAYABLE TO:</b><br>";
		
		//echo "Actionable Information Advisory<br>40 E 38th st, 5th Floor<br>New York, NY 10016";
                if($payable_to_name != '')
                    echo $payable_to_name."<br>";
                
                if($site_address != '')
                    echo $site_address."<br>";
                
                if($site_city != '')
                    echo $site_city;
                if($site_zip_code != '')
                    echo ", ".$site_zip_code;
		
		echo "<br><br>";
		echo "<b>SUBSCRIPTION LEVEL:</b><br>";
		
		echo "Premium Subscription, including:<br><br>";
		echo "<ul>";
		echo "<li>Full Search functionality of CHROs, and other HR executives on the sales lead database</li>";
		echo "<li>Full download  functionality</li>";
		echo "<li>1 monthly summary update on management changes among CHROs, VPs and Directors of HR</li>";
		echo "</ul>";
		
		echo "<br>";
		
		echo "<div width=300px align=center style=\"\"><span style=\"color:#CDCDCD;\">".$site_website."<br>".$site_address."<br>".$site_city.", ".$site_zip_code."</span><br></div>";
		
		echo "</body>";
		echo "</html>";
		
	}
}





/*
include("fpdf/fpdf.php");
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',36);
$pdf->Cell(40,10,'Hello World!');
$pdf->Output();
*/








?>