<?php
chdir(dirname( __FILE__ ));

require('includes/include-top.php');



com_db_query("insert into ".TABLE_CRONJOB_INFO." (page_name,start_date_time) values ('auto-sitemap-all-page','".date("Y-m-d : H:i:s")."')");

$update_id= com_db_insert_id();



//Newly create main Sitemap



$added=date('Y-m-d');

$url_query = "select page_name,sitemap_order from " .TABLE_META_TAG ." where sitemap_order <>'' order by sitemap_order";

$url_result = com_db_query($url_query);

if($url_result){

	$file_name = 'sitemapallpage.xml';

	$sitemap_name = 'sitemapallpage.xml';

	$fp=fopen($file_name,"w");

	$tot_url = '<?xml version="1.0" encoding="UTF-8"?>'."\n".

				'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

	$tot_url .= "<url>

					<loc>".HTTP_SITE_URL."</loc>

					<lastmod>".date('Y-m-d')."</lastmod>

					<changefreq>daily</changefreq>

					<priority>0.0</priority>

				 </url>\n";

	while($url_row = com_db_fetch_array($url_result)){

		$tot_url .= "<url>

						<loc>".HTTP_SITE_URL.$url_row['page_name']."</loc>

						<lastmod>".date('Y-m-d')."</lastmod>

						<changefreq>daily</changefreq>

						<priority>".$url_row['sitemap_order']."</priority>

					 </url>\n";

	}

	//reminder priority

	$url_query1 = "select page_name,sitemap_order from " .TABLE_META_TAG ." where page_name <>'Default' and sitemap_order=''";

	$url_result1 = com_db_query($url_query1);

	while($url_row = com_db_fetch_array($url_result1)){

		$tot_url .= "<url>

						<loc>".HTTP_SITE_URL.$url_row['page_name']."</loc>

						<lastmod>".date('Y-m-d')."</lastmod>

						<changefreq>daily</changefreq>

					 </url>\n";

	}			

	$tot_url .= '</urlset>';

	fwrite($fp, $tot_url);

	fclose($fp);

}

//submit movement url file in the sitemap

$url_query = "select sitemap_name from " .TABLE_SITEMAP ;

$url_result = com_db_query($url_query);



$com_query = "select sitemap_name from " .TABLE_SITEMAP_COMPANY ;

$com_result = com_db_query($com_query);



$per_query = "select sitemap_name from " .TABLE_SITEMAP_PERSONAL ;

$per_result = com_db_query($per_query);



$file_name = 'sitemap.xml';

$fp=fopen($file_name,"w");

$tot_url = '<?xml version="1.0" encoding="UTF-8"?>'."\n".

			'<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

$tot_url .= '<sitemap><loc>'.HTTP_SITE_URL.$sitemap_name."</loc><lastmod>".date('Y-m-d')."</lastmod></sitemap>"."\n";			

while($url_row = com_db_fetch_array($url_result)){

	$tot_url .= '<sitemap><loc>'.HTTP_SITE_URL.$url_row['sitemap_name']."</loc><lastmod>".date('Y-m-d')."</lastmod></sitemap>"."\n";

}

while($com_row = com_db_fetch_array($com_result)){

	$tot_url .= '<sitemap><loc>'.HTTP_SITE_URL.$com_row['sitemap_name']."</loc><lastmod>".date('Y-m-d')."</lastmod></sitemap>"."\n";

}

while($per_row = com_db_fetch_array($per_result)){

	$tot_url .= '<sitemap><loc>'.HTTP_SITE_URL.$per_row['sitemap_name']."</loc><lastmod>".date('Y-m-d')."</lastmod></sitemap>"."\n";

}			

$tot_url .= '</sitemapindex>';

fwrite($fp, $tot_url);

fclose($fp);

	

mysql_query("update ".TABLE_CRONJOB_INFO." set end_date_time='".date("Y-m-d : H:i:s")."' where id='".$update_id."'");

mysql_query("insert into " .TABLE_CRONJOB_NEW. " (page_name,start_date_time) values ('auto-sitemap-all-page','".date("Y-m-d : H:i:s")."')");


?>
