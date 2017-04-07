<?php
//require_once 'vsword/VsWord.php'; 
//VsWord::autoLoad();


//header("Content-type: application/vnd.ms-word");
//header("Content-Disposition: attachment;Filename=Invoice.doc");

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);



require('fpdf/fpdf.php');

$font_family = 'Arial';
$font_size = '10';
$break_height_big = '9';
$break_height = '5';

$hre = mysql_connect("localhost","ctou2","ToC@!mvCo23",TRUE) or die("Database ERROR ");
mysql_select_db("ctou2",$hre) or die ("ERROR: Database not found ");

//select * from hre_invoices as hi,hre_user as u where u.user_id = hi.user_id and appear_date <= now()
$invoice_q = "select * from cto_invoices as hi,cto_user as u where u.user_id = hi.user_id and appear_date <= now()";
echo "<br>invoice_q: ".$invoice_q;
$find_invoices_query = mysql_query($invoice_q);
if($find_invoices_query)
{
    $invoice_num = mysql_num_rows($find_invoices_query);
    echo "<br>invoice_num: ".$invoice_num;
    if($invoice_num > 0)
    {
        // Invoice related static details
        $invoice_static_details = mysql_query("select * from cto_invoices_static_details");
        $invoiceStaticRow = mysql_fetch_array($invoice_static_details);
        $site_website = $invoiceStaticRow['site_website'];
        $site_address = $invoiceStaticRow['site_address'];
        $site_city = $invoiceStaticRow['site_city'];
        $site_zip_code = $invoiceStaticRow['site_zip_code'];
        $payable_to_name = $invoiceStaticRow['payable_to_name'];

        $from_name = $invoiceStaticRow['from_name'];
        $from_title = $invoiceStaticRow['from_title'];
        
        
        //$invoice_row = mysql_fetch_array($find_invoices_query);
        while($invoice_row = mysql_fetch_array($find_invoices_query))
        {    
            //$invoice_dates[] = $final;
            
            $sequence = 0;
            
            $appear_date = $invoice_row['appear_date'];
            $due_date = $invoice_row['payment_due_date'];

            $user_id = $invoice_row['user_id'];

            
            $to_name = $invoice_row['to_name'];
            $to_company_name = $invoice_row['to_company_name'];
            $to_title = $invoice_row['to_title'];
            $to_address = $invoice_row['to_address'];
            $to_city = $invoice_row['to_city'];
            $to_state = $invoice_row['to_state'];
            $to_zip_code = $invoice_row['to_zip_code'];
            $payment_amount = $invoice_row['payment_amount'];
            $payment_method = $invoice_row['payment_method'];
            $invoice_no = $invoice_row['invoice_no'];
            $invoice_no_step = $invoice_row['invoice_no_step'];
            $payment_due_date = $invoice_row['payment_due_date'];

            
            
            
            //$month_d = substr($payment_due_date,5,2)+1;
            //$year = substr($payment_due_date,0,4);
            //$due_din = substr($payment_due_date,8,2);
            //$due_date = $month_d."/".$due_din."/".$year;

            
            
            
            
            echo "<br>user_id: ".$user_id;

            $d1 = new DateTime($appear_date);
            $d2 = new DateTime(date("Y-m-d"));
            //$d2 = new DateTime($due_date);
            $no_of_months = $d1->diff($d2)->m;
            echo "<br>no of months: ".$no_of_months;
            $count = 0;
            for($i = 0; $i<$no_of_months+1;$i++)
            //for($i = 0; $i<2;$i++)
            {
                
                
                echo "<br>invoice_no: ".$invoice_no;
                echo "<br>invoice_no_step: ".$invoice_no_step;
            
            
                //$invoice_no = ($sequence*$invoice_no_step)+$invoice_no;
                if($i == 0)
                    $invoice_no = $invoice_no;
                else    
                    $invoice_no = $invoice_no_step+$invoice_no;
                $sequence++;
                echo "<br>invoice_no after: ".$invoice_no;
                
                
                
                $file_name = '';
                $time_2 = strtotime($appear_date);
                $final = date("Y-m-d", strtotime("+$i month", $time_2));
                $invoice_dates[] = $final;
                
                echo "<br>final: ".$final;
                
                
                $time=strtotime($final);
                $month=date("M",$time);
                $year=date("Y",$time);
                $month_d=date("m",$time);
                
                echo "<br>month_d: ".$month_d;
                
                $due_din = substr($payment_due_date,8,2);
                $due_date = $month_d."/".$due_din."/".$year;
                
                //$file_name = $user_id."_".$final.'.docx';
                $file_name = $user_id."_".$final.'.pdf';
                $display_name = $final;
                
                $count++;
                
                
                $check_exist_q = "select * from cto_saved_invoices where user_id = $user_id and invoice_file = '$file_name'";
                $exist_res = mysql_query($check_exist_q);
                echo "<br>check_exist_q: ".$check_exist_q;
                $exist_num = mysql_num_rows($exist_res);
                echo "<br>exist_num: ".$exist_num;
                if($exist_num == 0)
                {
                    echo "<br>Within line<br>";
                    if(1 == 2)
                    {    
                        $output = "";
                        $output .= "<html>";
                        $output .= "<body style=font-size:10pt;>";
                        //$output .= "<div width=300px align=center style=\"\"><span style=\"color:#CDCDCD;font-size:24px;\">".$site_website."</span><br><strong>INVOICE # $invoice_no</strong></div><br>";

                        //$output .= "<div width=300px align=center><span style=color:#CDCDCD;font-size:24px;><font size=24px>".$site_website."</font></span><br><br><strong>INVOICE # $invoice_no</strong></div><br>";
                        $output .= "<center><span style=font-size:17px;color:#999999>".$site_website."</span><hr><br><b>INVOICE # $invoice_no</b></center><br>";
                        $output .= "<b>TO:</b><br><br>";
                        if($to_name != '')
                            $output .= "$to_name<br>";
                        if($to_title != '')
                            $output .= "$to_title<br>";	
                        if($to_company_name != '')	
                            $output .= "$to_company_name<br>";
                        if($to_address != '')		
                            $output .= "$to_address<br>";
                        if($to_city != '')		
                            $output .= "$to_city, ";
                        if($to_state != '')		
                            $output .= "$to_state";
                        if($to_zip_code != '')		
                            $output .= " $to_zip_code<br>";	

                        /*
                        $output .= "<table width=600 cellpadding=0 cellspacing=0 border=0 style\"=border:1px solid #FFFFFF;\"><tr><td><br><br><b>FROM:</b><br><br></td><td width=166 rowspan=6><img width=166 height=145 src=https://www.hrexecsonthemove.com/vsword/img1.jpg></td></tr>";
                        if($from_name != '')
                            $output .= "<tr><td>".$from_name."</td></tr>";
                        if($from_title != '')
                            $output .= "<tr><td>".$from_title."</td></tr>";
                        if($site_website != '')
                            $output .= "<tr><td>".$site_website."</td></tr>";
                        if($to_address != '')
                            $output .= "<tr><td>".$to_address."</td></tr>";
                        if($to_city != '')
                            $output .= "<tr><td>".$to_city.", ".$to_state." ".$to_zip_code."</td></tr>";
                        $output .= "</table>";
                         */


                        $output .= "<div style=\"float:left;width:400px;border:none;\"><br><br><b>FROM:</b><br>";
                        if($from_name != '')
                            $output .= "<br>".$from_name."";
                        if($from_title != '')
                            $output .= "<br>".$from_title."";
                        if($site_website != '')
                            $output .= "<br>".$site_website."";
                        if($to_address != '')
                            $output .= "<br>".$to_address."";
                       if($to_city != '')
                            $output .= "<br>".$to_city.", ".$to_state." ".$to_zip_code."";

                        $output .= "</div>";
                        $output .= "<div style=\"float:left;width=150;height:300px;border:none;\">";
                        $output .= "<img border=0 width=166 height=145 src=https://www.hrexecsonthemove.com/vsword/img1.jpg>";
                        $output .= "</div>";


                        //$output .= "<div style=\"float:left;border:1px solid;width=100%;\">";

                        $output .= "<br><b>RE:</b><br><br>";
                        //echo "Subscription to $site_website - ".date("M")." ".date("o");
                        $output .= "Subscription to $site_website - ".$month." ".$year;
                        $output .= "<br><br><b>PAYMENT AMOUNT:</b><br>";
                        $output .= "<br>US$".$payment_amount." / month";
                        $output .= "<br><br><b>PAYMENT DUE:</b><br><br>";
                        $output .= $due_date."";
                        $output .= "<br><br><b>PAYMENT METHOD:</b><br><br>";
                        $output .= str_replace("_"," ",$payment_method)."";
                        $output .= "<br><br><b>PAYABLE TO:</b><br><br>";
                        if($payable_to_name != '')
                            $output .= $payable_to_name."<br>";
                        if($site_address != '')
                            $output .= $site_address."<br>";
                        if($site_city != '')
                            $output .= $site_city.", ";
                        if($site_zip_code != '')
                            $output .= $site_zip_code;
                        $output .= "<br><br><b>SUBSCRIPTION LEVEL:</b><br><br>Premium Subscription, including:<br>";
                        $output .= "<br>- Full Search functionality of CHROs, and other HR executives on the sales lead database";
                        $output .= "<br>- Full download  functionality";
                        $output .= "<br>- 1 monthly summary update on management changes among CHROs, VPs and Directors of HR";
                        $output .= "<br><br><br><br><br><br><br><center>".$site_website."<br>".$site_address."<br>".$site_city.", ".$site_zip_code."</center>";
                        //$output .= "</div>";
                        $output .= "</body>";
                        $output .= "</html>";
                        echo "<br><br>Output: ".$output;
                    }
                    
                    if(1 == 1) // PDF
                    {
                        echo "<br><br>Within pdf generation<br>";
                        $pdf = new FPDF();
                        $pdf->AddPage();
                        
                        
                        $pdf->SetTextColor(36,36,36);
                        $pdf->SetFont($font_family,'',17);
                        $pdf->Cell(0,0,$site_website,0,0,'C');
                        $pdf->SetLineWidth(1);
                        $pdf->line(0,14,500,14);

                        $pdf->SetTextColor(0,0,0);
                        $pdf->SetFont($font_family,'',$font_size);
                        $pdf->Ln($break_height_big);
                        $pdf->SetFont($font_family,'B',$font_size);
                        $pdf->Cell(0,0,'INVOICE # '.$invoice_no,0,0,'C');
                        $pdf->Ln($break_height_big);
                        $pdf->SetFont($font_family,'',$font_size);

                        $pdf->SetFont($font_family,'B',$font_size);
                        $pdf->Cell(0,0,'TO:',0,0,'L');
                        $pdf->Ln($break_height_big);

                        $pdf->SetFont($font_family,'',$font_size);
                        $pdf->Cell(0,0,$to_name,0,0,'L');
                        $pdf->Ln($break_height);


                        $pdf->Cell(0,0,$to_title,0,0,'L');
                        $pdf->Ln($break_height);

                        $pdf->Cell(0,0,$to_company_name,0,0,'L');
                        $pdf->Ln($break_height);

                        $pdf->Cell(0,0,$to_address,0,0,'L');
                        $pdf->Ln($break_height);

                        $pdf->Cell(0,0,$to_city.', '.$to_state." ".$to_zip_code,0,0,'L');
                        $pdf->Ln($break_height);

                        $pdf->Ln($break_height_big);



                        $pdf->Image('vsword/img1.jpg',140,50,0,0,'JPG');
                        //$pdf->Image('https://www.hrexecsonthemove.com/vsword/img1.jpg');




                        $pdf->SetFont($font_family,'B',$font_size);
                        $pdf->Cell(0,0,'FROM:',0,0,'L');
                        $pdf->Ln($break_height_big);

                        $pdf->SetFont($font_family,'',$font_size);
                        $pdf->Cell(0,0,$from_name,0,0,'L');
                        $pdf->Ln($break_height);

                        $pdf->Cell(0,0,$from_title,0,0,'L');
                        $pdf->Ln($break_height);

                        $pdf->Cell(0,0,$site_website,0,0,'L');
                        $pdf->Ln($break_height);

                        $pdf->Cell(0,0,$to_address,0,0,'L');
                        $pdf->Ln($break_height);

                        $pdf->Cell(0,0,$to_city.", ".$to_state." ".$to_zip_code,0,0,'L');

                        $pdf->Ln($break_height_big);

                        $pdf->SetFont($font_family,'B',$font_size);
                        $pdf->Cell(0,0,'RE:',0,0,'L');
                        $pdf->Ln($break_height_big);

                        $pdf->SetFont($font_family,'',$font_size);
                        $pdf->Cell(0,0,'Subscription to '.$site_website." - ".date("M")." ".date("o"),0,0,'L');
                        $pdf->Ln($break_height_big);

                        $pdf->SetFont($font_family,'B',$font_size);
                        $pdf->Cell(0,0,'PAYMENT AMOUNT:',0,0,'L');
                        $pdf->Ln($break_height_big);

                        $pdf->SetFont($font_family,'',$font_size);
                        $pdf->Cell(0,0,'US$'.$payment_amount,0,0,'L');
                        //$pdf->Ln($break_height);

                        $pdf->Ln($break_height_big);

                        $pdf->SetFont($font_family,'B',$font_size);
                        $pdf->Cell(0,0,'PAYMENT DUE:',0,0,'L');
                        $pdf->Ln($break_height_big);

                        $pdf->SetFont($font_family,'',$font_size);
                        $pdf->Cell(0,0,$due_date,0,0,'L');
                        $pdf->Ln($break_height_big);

                        //$pdf->Ln($break_height_big);
                        $pdf->SetFont($font_family,'B',$font_size);
                        $pdf->Cell(0,0,'PAYMENT METHOD:',0,0,'L');
                        //$pdf->Ln($break_height);

                        $pdf->Ln($break_height_big);

                        $pdf->SetFont($font_family,'',$font_size);
                        $pdf->Cell(0,0,str_replace("_"," ",$payment_method),0,0,'L');
                        $pdf->Ln($break_height_big);

                        $pdf->SetFont($font_family,'B',$font_size);
                        $pdf->Cell(0,0,'PAYABLE TO:',0,0,'L');
                        $pdf->Ln($break_height_big);

                        $pdf->SetFont($font_family,'',$font_size);
                        $pdf->Cell(0,0,$payable_to_name,0,0,'L');
                        $pdf->Ln($break_height);

                        $pdf->Cell(0,0,$site_address,0,0,'L');
                        $pdf->Ln($break_height);

                        $pdf->Cell(0,0, $site_city.", ".$site_zip_code,0,0,'L');


                        $pdf->Ln($break_height_big);

                        $pdf->SetFont($font_family,'B',$font_size);
                        $pdf->Cell(0,0,'SUBSCRIPTION LEVEL:',0,0,'L');
                        $pdf->Ln($break_height_big);

                        $pdf->SetFont($font_family,'',$font_size);
                        $pdf->Cell(0,0,'Premium Subscription, including:',0,0,'L');

                        $pdf->Ln($break_height_big);

                        $pdf->Cell(0,0,'- Full Search functionality of CHROs, and other HR executives on the sales lead database',0,0,'L');
                        $pdf->Ln($break_height);

                        $pdf->Cell(0,0,'- Full download  functionality',0,0,'L');
                        $pdf->Ln($break_height);

                        $pdf->Cell(0,0,'- 1 monthly summary update on management changes among CHROs, VPs and Directors of HR',0,0,'L');
                        $pdf->Ln($break_height);


                        $pdf->Ln('20');

                        $pdf->SetLineWidth(1);
                        $pdf->line(40,257,170,257);

                        $pdf->Cell(0,0,$site_website,0,0,'C');
                        $pdf->Ln($break_height);
                        $pdf->Cell(0,0,$site_address,0,0,'C');
                        $pdf->Ln($break_height);
                        $pdf->Cell(0,0,$site_city.", ".$site_zip_code,0,0,'C');
                        $pdf->Ln($break_height);
                        
                        $filename = "/var/www/html/vsword/invoices/$file_name";
                        //file_put_contents($filename, $output);
                        $pdf->Output('F',$filename);
                        
                    }    
                    
                    
                    
                    
                    //$doc = new VsWord(); 
                    //$parser = new HtmlParser($doc);
                    
                    /*
                    $parser->parse( '<h1>Hello world!</h1>'.$user_id );
                    $parser->parse( '<h3>Hello world!</h3>' );
                    $parser->parse( '<p>Hello world!</p>' );
                    $parser->parse( '<h2>Header table</h2> <table> <tr><td>Coll 1</td><td>Coll 2</td></tr> </table>' );
                     */
                    //$parser->parse( $output );
                    //$doc->saveAs( 'vsword/invoices/'.$file_name );
                    

                    //$filename = "/var/www/html/vsword/invoices/$file_name";
                    //file_put_contents($filename, $output);
                    
                    $insert_invoice_q = "INSERT into cto_saved_invoices(user_id,invoice_file,display_name) values('$user_id','$file_name','$display_name')";
                    echo "<br>insert_invoice_q: ".$insert_invoice_q;
                    $insert_invoice = mysql_query($insert_invoice_q);
                    
                    
                    
                }    
                
            }
            echo "<pre>invoice_dates: ";   print_r($invoice_dates);   echo "</pre>";
        }
        
    }
}


/*
VsWord::autoLoad();

$doc = new VsWord(); 
$parser = new HtmlParser($doc);
$parser->parse( '<h1>Hello world!</h1>' );
$parser->parse( '<h3>Hello world!</h3>' );
$parser->parse( '<p>Hello world!</p>' );
$parser->parse( '<h2>Header table</h2> <table> <tr><td>Coll 1</td><td>Coll 2</td></tr> </table>' );
$parser->parse( $html );
$doc->saveAs( 'vsword/invoices/outputFromCron.docx' );
*/

//echo "<br><br><a href=vsword/outputFromCron.docx>Download file</a>";

?>
