<?php
/*
  $Id: rss.php,v 1.22 2007/04/13 13:04:02 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

include("includes/include-top.php");


//$navigation->remove_current_page();

/*$connection = mysql_connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD) or die('Couldn\'t make connection.');
// Select database
$db = mysql_select_db(DB_DATABASE, $connection) or die(mysql_error());

// If the language is not specified
if ($_GET['language'] == '') {
  $lang_query = tep_db_query('select languages_id, code from ' . TABLE_LANGUAGES . ' where directory = \'' . $language . '\'');
} else {
  $cur_language = tep_db_output($_GET['language']);
  $lang_query = tep_db_query('select languages_id, code from ' . TABLE_LANGUAGES . ' where code = \'' . $cur_language . '\'');
}

// Recover the code (fr, en, etc) and the id (1, 2, etc) of the current language
if (tep_db_num_rows($lang_query)) {
  $lang_a = tep_db_fetch_array($lang_query);
    $lang_code = $lang_a['code'];
    $lang_id = $lang_a['languages_id'];
}*/

// If the default of your catalog is not what you want in your RSS feed, then
// please change this three constants:
// Enter an appropriate title for your website
define(RSS_TITLE, 'CTOs On The Move');
// Enter your main shopping cart link
define(WEBLINK, HTTP_SERVER);
// Enter a description of your shopping cart
define(DESCRIPTION, 'CTOs On The Move');
/////////////////////////////////////////////////////////////
//That's it.  No More Editing (Unless you renamed DB tables or need to switch
//to SEO links (Apache Rewrite URL)
/////////////////////////////////////////////////////////////

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
Header('Content-Type: application/xml');
echo '<?xml version="1.0" encoding="UTF-8" ?>' . "\n";
echo '<?xml-stylesheet href="style-rss.css" type="text/css"?>' . "\n";
echo '<!-- RSS for ' . $store_name . ', generated on ' . date(r) . ' -->' . "\n";
?>
<rss version="2.0">
<channel>
<title><?php echo $rss_title; ?></title>
<link><?php echo $weblink; ?></link>
<description><?php echo $description; ?></description>
<!--<webMaster><?php //echo $email_address; ?></webMaster>
--><language><?php echo 'en-us';//$lang_code; ?></language>
<lastBuildDate><?php echo date(r); ?></lastBuildDate>
<image>
  <url><?php echo $weblink . '/images/rss_logo.jpg';?></url>
  <title><?php echo $rss_title; ?></title>
  <link><?php echo $weblink;?></link>
  <description><?php echo $description; ?></description>
</image>
<docs>http://blogs.law.harvard.edu/tech/rss</docs>
<?php

// Create SQL statement
/*$category = $_GET['cPath'];
$ecommerce = $_GET['ecommerce'];
if ($category != '') {
  // Check to see if we are in a subcategory
  if (strrpos($category, '_') > 0) {
    $category = substr($category, strrpos($category, '_') + 1, strlen($category));
  }
  $catTable = ", products_to_categories pc ";
  $catWhere = 'p.products_id = pc.products_id AND pc.categories_id = \'' . $category . '\' AND ';
}

$sql = "SELECT p.products_id, p.products_price, p.products_tax_class_id, p.products_model, 
               p.products_image, p.products_date_added, pd.products_name, pd.products_description,
               m.manufacturers_name, cd.categories_name
        FROM products p
             $catTable
        LEFT JOIN products_description pd
               ON pd.products_id = p.products_id
              AND pd.language_id = '$lang_id'
        LEFT JOIN manufacturers m
               ON m.manufacturers_id = p.manufacturers_id
        LEFT JOIN products_to_categories p2c
               ON p2c.products_id=p.products_id
        LEFT JOIN categories_description cd
               ON p2c.categories_id = cd.categories_id
              AND cd.language_id = '$lang_id'
        WHERE $catWhere
              p.products_status=1 AND 
              p.products_to_rss=1
        GROUP BY p.products_id
        ORDER BY p.products_id DESC
        LIMIT " . MAX_RSS_ARTICLES;

// Execute SQL query and get result
*/
//$sql_result = mysql_query($sql,$connection) or die("Couldn\'t execute query:<br />$sql");

$sql = "select first_name,last_name,new_title,email,headline,full_body,contact_url,company_website,company_name,announce_date from ".TABLE_CONTACT. " where announce_date <>'' and status=0 limit 0,20";
$sql_result = com_db_query($sql);

// Format results by row
while ($row = com_db_fetch_array($sql_result)) {
  $link = $row['contact_url'];

  $added = date(r,strtotime($row['announce_date']));


  // Setting and cleaning the data
  $name = $row['headline'];
  $desc = $row['full_body'];

  // Encoding to UTF-8
  $name = utf8_encode ($name);
  $desc = utf8_encode ($desc);
  $link = utf8_encode ($link);

 /* $manufacturer = $row['manufacturers_name'];
  $manufacturer = utf8_encode ($manufacturer);
  $price = tep_add_tax($row['products_price'], tep_get_tax_rate($row['products_tax_class_id']));
  if( $discount = tep_get_products_special_price($id) ) {
    $offer = tep_add_tax($discount, tep_get_tax_rate($row['products_tax_class_id']));
  } else {
    $offer = '';
  }*/

  $cat_name = $row['new_title'];

  // Encoding to UTF-8
  $cat_name = utf8_encode ($cat_name);

  // Setting the URLs to the images and buttons
  /*$relative_image_url = tep_image(DIR_WS_IMAGES . $image, $name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'style="float: left; margin: 0px 8px 8px 0px;"');
  $relative_image_url = str_replace('">', '', $relative_image_url);
  $relative_image_url = str_replace('<img src="', '', $relative_image_url);
  $image_url = HTTP_SERVER . DIR_WS_CATALOG . $relative_image_url;

  $relative_buy_url = tep_image_button('button_shopping_cart.gif', IMAGE_BUTTON_IN_CART, 'style="margin: 0px;"');
  $relative_buy_url = str_replace('">', '', $relative_buy_url);
  $relative_buy_url = str_replace('<img src="', '', $relative_buy_url);
  $buy_url = HTTP_SERVER . DIR_WS_CATALOG . $relative_buy_url;

  $relative_button_url = tep_image_button('button_more_info.gif', IMAGE_BUTTON_MORE_INFO, 'style="margin: 0px;"');
  $relative_button_url = str_replace('">', '', $relative_button_url);
  $relative_button_url = str_replace('<img src="', '', $relative_button_url);
  $button_url = HTTP_SERVER . DIR_WS_CATALOG . $relative_button_url;*/


  // http://www.w3.org/TR/REC-xml/#dt-chardata
  // The ampersand character (&) and the left angle bracket (<) MUST NOT appear in their literal form
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
  //echo '  <category>' . $cat_name . '</category>' . "\n";
  echo '  <link>'.'http://www.ctosonthemove.com/' . $link . '</link>' . "\n";
  echo '  <description>'; // . "\n";
 /* if ($ecommerce=='' && $image != '') {
    echo '<![CDATA[<a href="' . $link . '"><img src="' . $image_url . '"></a>]]>';
  }*/
  echo $desc;
 /* if ($ecommerce=='') {
    echo '<![CDATA[<br><br><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, tep_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $id) . '"><img src="' . $buy_url . '" border="0"></a>&nbsp;]]>';
    echo '<![CDATA[<a href="' . $link . '"><img src="' . $button_url . '" border="0"></a>]]>' . "\n";
  }*/
  echo '</description>' . "\n";
  //echo '  <guid>' . $link . '</guid>' . "\n";
  echo '  <pubDate>' . $added . '</pubDate>' . "\n";
  /*if($ecommerce!='') {
    echo '  <media:thumbnail url="' . $image_url . '">' . $image_url . '</media:thumbnail>' . "\n";
    echo '  <ecommerce:SKU>' . $id . '</ecommerce:SKU>' . "\n";
    echo '  <ecommerce:listPrice currency="' . DEFAULT_CURRENCY . '">' . $price . '</ecommerce:listPrice>' . "\n";
    if ($offer) {
      echo '  <ecommerce:offerPrice currency="' . DEFAULT_CURRENCY . '">' . $offer . '</ecommerce:offerPrice>' . "\n";
    }
    echo '  <ecommerce:manufacturer>' . $manufacturer . '</ecommerce:manufacturer>' . "\n";
  }*/
  echo '</item>' . "\n";
}
// Free resources and close connection
//mysql_free_result($sql_result);
//mysql_close($connection);
?>
</channel>
</rss>
