<?php
chdir(dirname( __FILE__ ));
require('includes/include-top.php');



com_db_query("insert into ".TABLE_CRONJOB_INFO." (page_name,start_date_time) values ('auto-sitemap-company','".date("Y-m-d : H:i:s")."')");

$update_id= com_db_insert_id();



//All company Sitemap delete

$perResult = com_db_query("select * from " . TABLE_SITEMAP_COMPANY);			

while($perRow = com_db_fetch_array($perResult)){

	$file_name = $perRow['sitemap_name'];

	if(file_exists($file_name)){

		unlink($file_name);

	}

}

com_db_query("TRUNCATE TABLE ".TABLE_SITEMAP_COMPANY);



//Newly create company Sitemap



$added=date('Y-m-d');

			

$url_query = "select company_name,company_id from " .TABLE_COMPANY_MASTER ." where status='0' order by company_name";

$url_result = com_db_query($url_query);

$count_url = 1;

$num_of_file = 1;

$file_name = 'sitemapcompany'.$num_of_file.'.xml';

$sitemap_name = 'sitemapcompany'.$num_of_file.'.xml';

$fp=fopen($file_name,"w");

$tot_url = '<?xml version="1.0" encoding="UTF-8"?>'."\n".

			'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

			



$num_of_file++;

while($url_row = com_db_fetch_array($url_result)){

	if($count_url == '1000'){

		$count_url = 1;	

		$file_name = 'sitemapcompany'.$num_of_file.'.xml';

		$sitemap_name = 'sitemapcompany'.$num_of_file.'.xml';

		$fp=fopen($file_name,"w");

		$num_of_file++;

		

	}

	$company_name = com_db_output($url_row['company_name']);

	$comURL = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''),$company_name).'_Company_'.$url_row['company_id'];

	

	$tot_url .= '<url><loc>'.HTTP_SITE_URL.$comURL."</loc><changefreq>daily</changefreq></url>\n";

	$count_url++;

	com_db_query("update " .TABLE_COMPANY_MASTER." set sitemap_status='1' where company_id='".$url_row['company_id']."'");

	if($count_url >= 1000){

		$tot_url .= '</urlset>';

		fwrite($fp, $tot_url);

		fclose($fp);

		$query = "insert into " . TABLE_SITEMAP_COMPANY . " (sitemap_name, add_date) values ('$sitemap_name', '$added')";

		com_db_query($query);

		$tot_url = '<?xml version="1.0" encoding="UTF-8"?>'."\n".

			'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

	}

}

if($count_url < 1000){

	$tot_url .= '</urlset>';

	fwrite($fp, $tot_url);

	fclose($fp);

	$query = "insert into " . TABLE_SITEMAP_COMPANY . " (sitemap_name, add_date) values ('$sitemap_name', '$added')";

	com_db_query($query);

}



mysql_query("update ".TABLE_CRONJOB_INFO." set end_date_time='".date("Y-m-d : H:i:s")."' where id='".$update_id."'");


mysql_query("insert into ".TABLE_CRONJOB_NEW ."  (page_name,start_date_time) values ('auto-sitemap-company','".date("Y-m-d : H:i:s")."')");

 
?>
