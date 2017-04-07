<?php
ob_start();
include("includes/include-top-cron.php");

/*
$get_invoices_query = "select * from ". TABLE_INVOICES ."";
$get_invoices_resut = com_db_query($get_invoices);
while($invoices_row = com_db_fetch_array($get_invoices_resut))
{
	  $first_name = $invoices_row['first_name'];
}
*/


ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);




$doc = new DOMDocument('1.0');
// we want a nice output
$doc->formatOutput = true;

$root = $doc->createElement('html');
$root = $doc->appendChild($root);

$head = $doc->createElement('head');
$head = $root->appendChild($head);

$title = $doc->createElement('title');
$title = $head->appendChild($title);

$text = $doc->createTextNode('This is the title');
$text = $title->appendChild($text);

echo 'Wrote: ' . $doc->saveHTMLFile("invoices/it_3.doc") . ' bytes'; // Wrote: 129 bytes











// $str = "<B>This is the text for the word file created through php programming</B>";

//$fp = fopen("invoices/it.doc", 'w+');

file_put_contents("invoices/it_2.doc","<b>Hello World. Testing!<b>");

die();



//$invoice_result = com_db_query("select * from " . TABLE_INVOICES . " where user_id='".$_SESSION['sess_user_id']."'");
$invoice_result = com_db_query("select * from " . TABLE_INVOICES . " where user_id='6357'");


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
		
		$from_name = $invoiceStaticRow['from_name'];
		
		$word = 0;
		if($word == 1)
		{
			//header("Content-type: application/vnd.ms-word");
			//header('Content-Type: application/octet-stream');
			//header("Content-Disposition: attachment;Filename=invoices/f.doc");
			
			
			
		}
		
		//header("Content-Type: application/vnd.ms-excel");
		
		header('Content-Disposition: attachement;filename="it_2.doc"');
		header('Content-Transfer-Encoding: binary');
		
		
		echo "<html>";
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
		echo "<body>";
		//echo "<span style=\"font-size:16px;text-decoration:underline;\">My first document</span>";
		

		$doc_content = "";
		$fp = fopen("invoices/it.doc", 'w+');
	
		$invoiceRow = com_db_fetch_array($invoice_result);
		$to_name = $invoiceRow['to_name'];
		$to_company_name = $invoiceRow['to_company_name'];
		$to_address = $invoiceRow['to_address'];
		$to_city = $invoiceRow['to_city'];
		$to_state = $invoiceRow['to_state'];
		$to_zip_code = $invoiceRow['to_zip_code'];
		$payment_amount = $invoiceRow['payment_amount'];
		$payment_method = $invoiceRow['payment_method'];
		
		
		$doc_content .= "<div width=300px align=center style=\"\"><span style=\"color:#CDCDCD;font-size:24px;\">".$site_website."</span><br><br>Invoice # 12246</div><br>";
		
		$doc_content .=  "<b>TO:</b><br><br>";
		
		if($to_name != '')
			$doc_content .= "$to_name<br>";
		if($to_company_name != '')	
			$doc_content .= "$to_company_name<br>";
		if($to_address != '')		
			$doc_content .=  "$to_address<br>";
		if($to_city != '')		
			$doc_content .= "$to_city<br>";
		if($to_state != '')		
			$doc_content .= "$to_state";
		if($to_zip_code != '')		
			$doc_content .= ", $to_zip_code<br>";	
		
		$doc_content .=  "<br><br><br>";
		
		$doc_content .=  "<b>FROM:</b><br><br>";
		if($from_name != '')
			$doc_content .= $from_name."<br>";
		if($site_website != '')
			$doc_content .= $site_website."<br>";	
		if($site_address != '')
			$doc_content .= $site_address."<br>";
		if($site_city != '')
			$doc_content .= $site_city."";	
		if($site_zip_code != '')
			$doc_content .= ", ".$site_zip_code."<br>";		
			
		
		$doc_content .= "<br><br><br>";
		
		$doc_content .= "<b>RE:</b><br><br>";
		$doc_content .= "Subscription to $site_website - ".date("M")." ".date("o");
		
		$doc_content .= "<br><br><br>";
		$doc_content .= "<b>PAYMENT AMOUNT:</b><br><br>";
		$doc_content .= $payment_amount."";
		
		$doc_content .= "<br><br><br>";
		$doc_content .= "<b>PAYMENT DUE:</b><br><br>";
		//echo $payment_amount."";
		
		$doc_content .= "<br><br><br>";
		$doc_content .= "<b>PAYMENT METHOD:</b><br><br>";
		$doc_content .= str_replace("_"," ",$payment_method)."";
		
		$doc_content .= "<br><br><br>";
		$doc_content .= "<b>PAYABLE TO:</b><br><br>";
		
		$doc_content .= "Actionable Information Advisory<br>40 E 38th st, 5th Floor<br>New York, NY 10016";
		
		$doc_content .= "<br><br><br>";
		$doc_content .= "<b>SUBSCRIPTION LEVEL:</b><br><br>";
		
		$doc_content .= "Premium Subscription, including:<br><br>";
		$doc_content .= "<ul>";
		$doc_content .= "<li>Full Search functionality of CHROs, and other HR executives on the sales lead database</li>";
		$doc_content .= "<li>Full download  functionality</li>";
		$doc_content .= "<li>1 monthly summary update on management changes among CHROs, VPs and Directors of HR</li>";
		$doc_content .= "</ul>";
		
		$doc_content .= "<br><br><br>";
		
		$doc_content .= "<div width=300px align=center style=\"\"><span style=\"color:#CDCDCD;\">".$site_website."<br>".$site_address."<br>".$site_city.", ".$site_zip_code."</span><br></div><br>";
		
		$doc_content .= "</body>";
		$doc_content .= "</html>";
		
		
		
		
		file_put_contents('it_2.doc', ob_get_contents());
		//header('Content-type: application/msword'); 
		
		
		 fwrite($fp, $doc_content);
			fclose($fp);
		
		
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







ob_end_flush();
?>
