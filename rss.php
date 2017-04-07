<?php
include("includes/include-top.php");

define(RSS_TITLE, "CTOs On The Move");
// Enter your main shopping cart link
define(WEBLINK, HTTP_SERVER);
// Enter a description of your shopping cart
define(DESCRIPTION, "CTOs On The Move");

$store_name = STORE_NAME;
$rss_title = RSS_TITLE;
$weblink = WEBLINK;
$description = DESCRIPTION;
//$email_address = STORE_OWNER_EMAIL_ADDRESS;

// Encoding to UTF-8
$store_name =  utf8_encode ($store_name);
$rss_title =  utf8_encode ($rss_title);
$weblink =  utf8_encode ($weblink);
$description =  utf8_encode ($description);
$email_address =  utf8_encode ($email_address);

// Begin sending of the data
 header('Content-Type: application/xml');
echo '<?xml version="1.0" encoding="UTF-8" ?>' . "\n";
echo '<?xml-stylesheet href="http://www.w3.org/2000/08/w3c-synd/style.css" type="text/css"?>' . "\n";
echo '<!-- RSS for ' . $store_name . ', generated on ' . date(r) . ' -->' . "\n";
?>
<rss version="2.0"
xmlns:ecommerce="http://shopping.discovery.com/erss/"
xmlns:media="http://search.yahoo.com/mrss/">
<channel>
<title><?php echo $rss_title; ?></title>
<link><?php echo $weblink;?></link>
<description><?php echo $description; ?></description>
<webMaster><?php echo $email_address; ?></webMaster>
<language><?php echo 'En'; ?></language>
<lastBuildDate><?php echo date(r); ?></lastBuildDate>
<image>
  <url><?php echo $weblink . '/images/logo.jpg';?></url>
  <title><?php echo $rss_title; ?></title>
  <link><?php echo $weblink;?></link>
  <description><?php echo $description; ?></description>
</image>
<docs>http://blogs.law.harvard.edu/tech/rss</docs>
<?php

$sql = "select first_name,last_name,new_title,email,headline,full_body,contact_url,company_website,company_name from ".TABLE_CONTACT. " where status=0 limit 0,20";
$sql_result = com_db_query($sql);
// Format results by row
while ($row = com_db_fetch_array($sql_result)) {
  $contact_url = HTTP_SERVER.DIR_WS_HTTP_FOLDER.$row['contact_url'];

  $link = $contact_url;

  $added = date(r,strtotime($row['announce_date']));

  // Setting and cleaning the data
  $name = $row['headline'];
  $desc = $row['full_body'];

  // Encoding to UTF-8
  $name = utf8_encode ($name);
  $desc = utf8_encode ($desc);
  $link = utf8_encode ($link);

  $cat_name = $row['new_title'];

  // Encoding to UTF-8
  $cat_name = utf8_encode ($cat_name);

  $name = str_replace('&','&amp;',$name);
  $desc = str_replace('&','&amp;',$desc);
  $link = str_replace('&','&amp;',$link);
  $cat_name = str_replace('&','&amp;',$cat_name);

  $name = str_replace('<','&lt;',$name);
  $desc = str_replace('<','&lt;',$desc);
  $link = str_replace('<','&lt;',$link);
  $cat_name = str_replace('<','&lt;',$cat_name);

  $name = str_replace('>','&gt;',$name);
  $desc = str_replace('>','&gt;',$desc);
  $link = str_replace('>','&gt;',$link);
  $cat_name = str_replace('>','&gt;',$cat_name);

  // Writing the output
  echo '<item>' . "\n";
  echo '  <title>' . $name . '</title>' . "\n";
  echo '  <category>' . $cat_name . '</category>' . "\n";
  echo '  <link>' . $link . '</link>' . "\n";
  echo '  <description>'; 
  echo $desc;
  echo '</description>' . "\n";
  echo '  <guid>' . $link . '</guid>' . "\n";
  echo '  <pubDate>' . $added . '</pubDate>' . "\n";
  echo '</item>' . "\n";
}
?>
</channel>
</rss>