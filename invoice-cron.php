<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//chdir(dirname( __FILE__ ));
include("includes/include-top-cron.php");
//echo "<br>Invoice tbl: ".TABLE_INVOICES;

$invoice_dates = array();
$find_invoices_query = com_db_query("select * from ".TABLE_INVOICES." where appear_date <= now()");
//echo "<br>find_invoices_query: select * from ".TABLE_INVOICES." where appear_date <= now()";
if($find_invoices_query)
{
    $invoice_num = com_db_num_rows($find_invoices_query);
    //echo "<br>invoice_num: ".$invoice_num;
    if($invoice_num > 0)
    {
        
        while($invoice_row = com_db_fetch_array($find_invoices_query))
        {
            //$invoice_row = com_db_fetch_array($find_invoices_query);
            $appear_date = $invoice_row['appear_date'];
            $due_date = $invoice_row['payment_due_date'];
            echo "<br><br>appear_date: ".$appear_date;
            $d1 = new DateTime($appear_date);
            //echo "<br>after d1";
            $d2 = new DateTime(date("Y-m-d"));
            //echo "<br>after d2";
            //$d2 = new DateTime($due_date);
            $no_of_months = $d1->diff($d2)->m;
            echo "<br><br><br><br>=============<br><br>no_of_months: ".$no_of_months;
            
            $diff=date_diff($d1,$d2);
            echo "<br><br>diff: ".$diff->format("%Y-%M-%D");
            
            //echo "<br><br>D1: ".$d1;
            //echo "<br><br>D2: ".$d2;

            echo "<pre>D1: ";   print_r($d1);   echo "</pre>";
            echo "<pre>D2: ";   print_r($d2);   echo "</pre>";

            for($i = 0; $i<$no_of_months+1;$i++)
            {
                $time_2 = strtotime($appear_date);
                $final = date("Y-m-d", strtotime("+$i month", $time_2));
                echo "<br>Final: ".$final;
                echo "<br>appear date: ".$appear_date;
                echo "<br>".$final.' > '.$appear_date;
                if($final > $appear_date)
                    $invoice_dates[] = $final;
            }
            echo "<pre>invoice_dates: ";   print_r($invoice_dates);   echo "</pre>";
            
            
            echo "<br><br><br>OPT 2:";
            $months = '';
            $d1->add(new \DateInterval('P1M'));
            while ($d1 <= $d2){
                $months ++;
                $d1->add(new \DateInterval('P1M'));
            }

            echo "<pre>month: ";   print_r($months);   echo "</pre>";
            
            
            
            
            
        }
    }

    

}

?>
