<?php
chdir(dirname( __FILE__ ));
require('includes/include-top.php');



com_db_query("insert into ".TABLE_CRONJOB_INFO." (page_name,start_date_time) values ('auto-sitemap-personal','".date("Y-m-d : H:i:s")."')");

$update_id= com_db_insert_id();



//All Personal Sitemap delete

$perResult = com_db_query("select * from " . TABLE_SITEMAP_PERSONAL);			

while($perRow = com_db_fetch_array($perResult)){

	$file_name = $perRow['sitemap_name'];

	if(file_exists($file_name)){

		unlink($file_name);

	}

}

com_db_query("TRUNCATE TABLE ".TABLE_SITEMAP_PERSONAL);



//Newly create personal Sitemap



$added=date('Y-m-d');

			

$url_query = "select first_name,last_name,personal_id from " .TABLE_PERSONAL_MASTER ." where status='0' order by first_name";

$url_result = com_db_query($url_query);

$count_url = 1;

$num_of_file = 1;

$file_name = 'sitemappersonal'.$num_of_file.'.xml';

$sitemap_name = 'sitemappersonal'.$num_of_file.'.xml';

$fp=fopen($file_name,"w");

$tot_url = '<?xml version="1.0" encoding="UTF-8"?>'."\n".

			'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

			



$num_of_file++;

while($url_row = com_db_fetch_array($url_result)){

	if($count_url == '1000'){

		$count_url = 1;	

		$file_name = 'sitemappersonal'.$num_of_file.'.xml';

		$sitemap_name = 'sitemappersonal'.$num_of_file.'.xml';

		$fp=fopen($file_name,"w");

		$num_of_file++;

		

	}

	$comURL = com_db_output($url_row['first_name'].'_'.$url_row['last_name'].'_Exec_'.$url_row['personal_id']);

	$tot_url .= '<url><loc>'.HTTP_SITE_URL.$comURL."</loc><changefreq>daily</changefreq></url>\n";

	$count_url++;

	com_db_query("update " .TABLE_PERSONAL_MASTER." set sitemap_status='1' where personal_id='".$url_row['personal_id']."'");

	if($count_url >= 1000){

		$tot_url .= '</urlset>';

		fwrite($fp, $tot_url);

		fclose($fp);

		$query = "insert into " . TABLE_SITEMAP_PERSONAL . " (sitemap_name, add_date) values ('$sitemap_name', '$added')";

		com_db_query($query);

		$tot_url = '<?xml version="1.0" encoding="UTF-8"?>'."\n".

			'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

	}

}

if($count_url < 1000){

	$tot_url .= '</urlset>';

	fwrite($fp, $tot_url);

	fclose($fp);

	$query = "insert into " . TABLE_SITEMAP_PERSONAL . " (sitemap_name, add_date) values ('$sitemap_name', '$added')";

	com_db_query($query);

}



mysql_query("update ".TABLE_CRONJOB_INFO." set end_date_time='".date("Y-m-d : H:i:s")."' where id='".$update_id."'");

mysql_query("insert into ".TABLE_CRONJOB_NEW ."  (page_name,start_date_time) values ('auto-sitemap-personal','".date("Y-m-d : H:i:s")."')");


?>
