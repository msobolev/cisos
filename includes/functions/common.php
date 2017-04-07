<?php

// removed in php 5.4, need local implementation
function session_register(){
	$args = func_get_args();
	foreach ($args as $key){
		$_SESSION[$key]=$GLOBALS[$key];
	}
}
function session_is_registered($key){
	return isset($_SESSION[$key]);
}
function session_unregister($key){
	unset($_SESSION[$key]);
}

//Check Admin login

function com_admin_check_login() {

  global $PHP_SELF, $login_groups_id;

  if (!session_is_registered('login_id')){

    com_redirect('login.php');

  } else {

	$filename = basename( $PHP_SELF );

  }  

}

function com_user_admin_check_login() {

  global $PHP_SELF, $login_groups_id;

  if (!session_is_registered('user_login_id')){

    com_redirect('login.php');

  } else {

	$filename = basename( $PHP_SELF );

  }  

}

// Redirect to another page or site

 function com_redirect($url) {

    header('Location: ' . $url);

    exit;

  }





// TABLES: countries

  function com_get_countries($default = '') {

    $countries_array = array();

    if ($default) {

      $countries_array[] = array('id' => '',

                                 'text' => $default);

    }

    $countries_query = mysql_query("select countries_id, countries_name from " . TABLE_COUNTRIES . " order by countries_name");

    while ($countries = mysql_fetch_array($countries_query)) {

      $countries_array[] = array('id' => $countries['countries_id'],

                                 'text' => $countries['countries_name']);

    }



    return $countries_array;

  }



////

function com_get_country_name($country_id) {

    $country_query = mysql_query("select countries_name from " . TABLE_COUNTRIES . " where countries_id = '" . (int)$country_id . "'");



    if (!mysql_num_rows($country_query)) {

      return $country_id;

    } else {

      $country = mysql_fetch_array($country_query);

      return $country['countries_name'];

    }

  }



///////////////////////////////////////////////////////////////////////////////////////////////////////////



	function com_show_short_desc($description , $length = 100 , $concat_str = '...'){

		return substr($description , 0 , $length) . $concat_str;

	}





 function msg_encode($msg,$encode_type=1){

		switch($encode_type){

			case 1:

				return base64_encode($msg);

			  break;

			  

			default:

			

			  break; 

		}   	

	

	

	}

	function msg_decode($msg,$decode_type=1){

		switch($decode_type){

			case 1:

				return base64_decode($msg);

			  break;

			  

			default:

			

			  break;  	

		}

	

	}



///////////////////////////////////////////////////////////////////////////////////

function com_open_window($path,$width = '',$height = ''){

		if(file_exists($path)&& is_file($path)){

			$properties = getimagesize($path);

			$org_width = $properties[0];

			$org_height = $properties[1];

			$img_width = $org_width;

			$img_height = $org_height;

			

			if($height != ''){

				if($org_height >= $height){ 

					$img_width = ($org_width/$org_height)*$height;

					$img_height = $height;

				}else{

					$img_width = $org_width;

					$img_height = $org_height;

				}

			}

			

			if($width != ''){

				if($org_width >= $width){ 

					$img_height = ($org_height/$org_width)*$width;

					$img_width = $width;

				}else{

					$img_width = $org_width;

					$img_height = $org_height;

				}

			}

			

			

			if(($width != '')&&($height != '')){

					$img_width = $width;

					$img_height = $height;



			}

			

			

			//$window_img = '<img src="'. $path .'" border="0" width="' . $img_width . '" height="' . $img_height . '">'; 

			

			//$window_img = '<img src="'. $path .'" border="0" width="' . $img_width . '" height="' . $img_height . '">';  

			

			$window_img = "window.open('" . $path . "' , 'test' , 'width=" . $img_width . ",height=" . $img_height . "')";

  }else{

  		$window_img = "";

  }

  return $window_img;



	

}



function com_setImage($path,$width = '',$height = '',$extra=''){

	if(file_exists($path)&& is_file($path)){

			$properties = getimagesize($path);

			$org_width = $properties[0];

			$org_height = $properties[1];

			$img_width = $org_width;

			$img_height = $org_height;

			

			if($height != ''){

				if($org_height >= $height){ 

					$img_width = ($org_width/$org_height)*$height;

					$img_height = $height;

				}else{

					$img_width = $org_width;

					$img_height = $org_height;

				}

			}

			

			if($width != ''){

				if($org_width >= $width){ 

					$img_height = ($org_height/$org_width)*$width;

					$img_width = $width;

				}else{

					$img_width = $org_width;

					$img_height = $org_height;

				}

			}

			

			

			if(($width != '')&&($height != '')){

					$img_width = $width;

					$img_height = $height;



			}

			

			

			$get_img = '<img src="'. $path .'" border="0" width="' . $img_width . '" height="' . $img_height . '" ' . $extra .  ' />';  

  }else{

  		$get_img = "";

  }

  return $get_img;



}





##================= Email Function :: Start================##



function send_email($to, $subject, $message, $from){

	



	$headers  = 'MIME-Version: 1.0' . "\r\n";

	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	$headers .= 'From: ' . $from . "\r\n";



	return mail($to, $subject, $message, $headers);





}




function send_email_mailer($to_admin, $subject, $message, $email,$full_name='')
{
	require_once('PHPMailer/class.phpmailer.php');
	$mail                = new PHPMailer();

	$mail->IsSMTP(); // telling the class to use SMTP
	$mail->SMTPAuth      = true;                  // enable SMTP authentication
	$mail->SMTPKeepAlive = true;                  // SMTP connection will not close after each email sent
	$mail->Host          = "smtpout.secureserver.net";//"relay-hosting.secureserver.net"; // sets the SMTP server relay-hosting.secureserver.net smtpout.secureserver.net
	$mail->Port          = 25;    // 80, 3535, 25, 465 (SSL)      // 26 set the SMTP port for the GMAIL server
	$mail->Username      = "rts_email_sent@ctosonthemove.com"; // SMTP account username
	$mail->Password      = "rts0214";        // SMTP account password
	$mail->SetFrom('rts_email_sent@ctosonthemove.com', 'ctosonthemove.com');
	//$mail->AddReplyTo($from_admin, 'ctosonthemove.com');

	$mail->Subject       = $subject;

	$emailContent = $message; 

	$mail->MsgHTML($emailContent);
	$mail->AddAddress($to_admin, $full_name);

	if(!$mail->Send()) 
	{
	//	$str_error ="Mailer Error (" . str_replace("@", "&#64;", $email) . ') ' . $mail->ErrorInfo;
	}
	else
	{
	//	echo "<br><br>Email send";
	}
	return;
}




##================= Email Function :: End================##



/**********  Pagination *********************/

function new_number_pages($main_page, $page_now, $total_items, $max_pages = "15", $max_per_page = "25", $extra = "")

{

	$max_pages--;

	$total_pages = (int) floor($total_items/$max_per_page);

	if(($total_items % $max_per_page)) {

		$total_pages++;

	}



	$low_page = $page_now - floor($max_pages/2);

	

	if($low_page < 1) {

		$low_page = 1;

	}

	$high_page = $low_page + $max_pages;

	if($high_page > $total_pages) {

		$high_page = $total_pages;

		if($total_pages > $max_pages) {

			$low_page = $high_page - $max_pages;

		}

	}

	

	

	$output = "";

	$output.="<a href='".$main_page."?p=".(1).$extra."' class='pag-first'>First</a>";

	if ($total_pages > 1) {

		if($page_now > 1)

		{

			//$output.="Page [<a href='".$main_page."?p=1".$extra."'>1</a>] &nbsp;&nbsp;";

			

			$output.="<a href='".$main_page."?p=".($page_now-1).$extra."' class='pag-back'>Back</a>";

			if(($low_page -1) > -1)

			{

				$output.="<a href='".$main_page."?p=".($low_page).$extra."' class='pag-dots'>...</a>";

			}

			//$output.="<a href='".$main_page."?p=".($page_now-1).$extra."'>&laquo; Prev</a> &nbsp;&nbsp;";

		} 

		else

		{

			$output.="<a href='#' class='pag-back'>Back</a>";

		}

		for($i=$low_page;$i<=$high_page;$i++) {

			if($i==$page_now)

			{

				$output.="<a href='#' class='current'>" . $i . "</a>";

			} else {

				if($i > $total_pages) {

					$output .= " ".$i;

				} else {

					$output.=" <a href='".$main_page."?p=".$i.$extra."' class=pagelink>".$i."</a>";

					//$output.="<a href='".$main_page."?p=".$i.$extra."'>".$i."</a>";

				}

			}

		}

		//$output= substr($output,0, -1);

		if($page_now<$total_pages)

		{

			

			if(($high_page -1) > -1)

			{

				$output.="<a href='".$main_page."?p=".($high_page).$extra."' class='pag-dots'>...</a>";

			}

			$output.="<a href='".$main_page."?p=".($page_now+1).$extra."' class='pag-next'>Next</a>";

			

			//$output.="&nbsp;&nbsp; <a href='".$main_page."?p=".($page_now+1).$extra."'> Next &raquo;</a> ";

			//$output.= "&nbsp;&nbsp; <a href='".$main_page."?p=".$total_pages.$extra."'>[$total_pages]</a>";

		} else {

			//$output.="&nbsp;&nbsp; Next &raquo; &nbsp;&nbsp; [$total_pages]";

			

			$output.="<a href='".$main_page."?p=".($page_now+1).$extra."' class='pag-next'>Next</a>";

		}

		$output.="<a href='".$main_page."?p=".($total_pages).$extra."' class='pag-last'>Last</a>";

		return $output;

	} 

}



function number_pages($main_page, $page_now, $total_items, $max_pages = "15", $max_per_page = "25", $extra = "")

{

	

	$max_pages--;

	$total_pages = (int) floor($total_items/$max_per_page);

	if(($total_items % $max_per_page)) {

		$total_pages++;

	}



	$low_page = $page_now - floor($max_pages/2);

	if($low_page < 1) {

		$low_page = 1;

	}

	$high_page = $low_page + $max_pages;

	if($high_page > $total_pages) {

		$high_page = $total_pages;

		if($total_pages > $max_pages) {

			$low_page = $high_page - $max_pages;

		}

	}

	

	$output = "Pages :";

	if ($total_pages > 1) {

		if($page_now > 1)

		{

			

			$output.='<a href="'. $main_page.'?p='.($page_now-1).$extra .'">&lt;&lt; Previous</a>';

			

		} else {

			

			$output.='&nbsp;&lt;&lt; Previous';

		}

		

		

			//$output.='<p>';

		

		for($i=$low_page;$i<=$high_page;$i++) {

			if($i==$page_now)

			{

				$output.='<a href="#" class="active">' . $i . '</a>';

			} else {

				if($i > $total_pages) {

					$output .= " ".$i;

				} else {

					$output.='<a href="'.$main_page.'?p='.$i.$extra.'">'.$i.'</a>';

				}

			}

		}

		//$output= substr($output,0, -1);

		

		//$output.='</p>';

		

		if($page_now<$total_pages)

		{

			$output.='<a href="'.$main_page.'?p='.($page_now+1).$extra. '">Next &gt;&gt;</a>';

			

		} else {

			$output.='Next &gt;&gt;';

		}

		return $output;

	} 

}





function number_pages_list($main_page, $page_now, $total_items, $max_pages = "15", $max_per_page = "25", $extra = "")

{



	$max_pages--;

	$total_pages = (int) floor($total_items/$max_per_page);

	if(($total_items % $max_per_page)) {

		$total_pages++;

	}



	$low_page = $page_now - floor($max_pages/2);

	if($low_page < 1) {

		$low_page = 1;

	}

	$high_page = $low_page + $max_pages;

	if($high_page > $total_pages) {

		$high_page = $total_pages;

		if($total_pages > $max_pages) {

			$low_page = $high_page - $max_pages;

		}

	}

	

	$output = "";

	

	if ($total_pages > 1) {

		if($page_now > 1)

		{

			$output.="<a href='".($page_now-1).'-'.$main_page.$extra."'> &lt; pre</a>";

		} else {

			//$output.= "<a href='#'> &lt; pre</a>";

			$output.= "&lt; pre";

		}

		for($i=$low_page;$i<=$high_page;$i++) {

			if($i==$page_now)

			{

				$output.='<a class="active" href="#"><u>' . $i . '</u></a>';

			} else {

				if($i > $total_pages) {

					$output .= "<a href='" . $i . "'></a>";

				} else {

					$output.="<a href='".$i.'-'.$main_page.$extra."'>" . $i . "</a>";

				}

			}

		}

		if($page_now<$total_pages)

		{

			$output.="<a href='".($page_now+1).'-'.$main_page.$extra."'>next &gt;</a>";

		} else {

			//$output .= "<a href='#'>next &gt;</a>";

			$output .= "next &gt;";

		}

		

		return $output;

	} 

}





/**************** Pagination ***************/



function createThumb($imgSource, $imgDestination, $thumbWidth, $thumbHeight='')

{

	$img_ext = explode('.', basename($imgSource));

	$ext=strtoupper($img_ext[count($img_ext)-1]);

	

	if($ext=='JPG' || $ext=='JPEG'){

		$src = imagecreatefromjpeg($imgSource);

	}elseif($ext=='GIF'){

		$src = imagecreatefromgif($imgSource);

	}

	$w = imagesx($src);

	$h = imagesy($src);



	$ratio = $w / $thumbWidth;

	if($thumbHeight==''){

		$thumbHeight = $h * $ratio;

	}else{

		$thumbHeight=$thumbHeight;

	}	



	$thumb = imagecreate($thumbWidth, $thumbHeight);

	imagecopyresized($thumb, $src, 0, 0, 0, 0, $thumbWidth, $thumbHeight,imagesx($thumb), imagesy($thumb));

	

	if($ext=='JPG' || $ext=='JPEG'){

		imagejpeg($thumb, $imgDestination);

	}elseif($ext=='GIF'){

		imagegif($thumb, $imgDestination);

	}	

}



function selectComboBox($sql,$selected_id){

	$exe_query = com_db_query($sql);

	while($data_sql = com_db_fetch_row($exe_query)){

		if($selected_id == $data_sql[0]){

			$selected_str = ' selected="selected"';

		}else{

			$selected_str = '';

		}

		$all_option .= '<option value="'.$data_sql[0].'" '.$selected_str.'>'.$data_sql[1].'</option>' . "\r\n";

	}

	return 	$all_option;

}



function MultiSelectionComboBox($sql,$selected_id_arr){

	$exe_query = com_db_query($sql);

	while($data_sql = com_db_fetch_row($exe_query)){

		if(in_array($data_sql[0],$selected_id_arr)){

			$selected_str = ' selected="selected"';

		}else{

			$selected_str = '';

		}

		$all_option .= '<option value="'.$data_sql[0].'" '.$selected_str.'>'.$data_sql[1].'</option>' . "\r\n";

	}

	return 	$all_option;

}





// The HTML href link wrapper function

  function com_href_link($page = '', $parameters = '') {

    global $request_type, $session_started, $SID;



	if (!com_not_null($page)) {

	  die('<br><br><font color="#ff0000"><b>Error!</b></font><br><br><b>Unable to determine the page link!<br><br>');

	}



	  if (ENABLE_SSL == true) {

		$link = HTTPS_SERVER . DIR_WS_HTTPS_FOLDER;

	  } else {

		$link = HTTP_SERVER . DIR_WS_HTTP_FOLDER;

	  }

    



    if (com_not_null($parameters)) {

      $link .= $page . '?' . htmlspecialchars($parameters);

      //$separator = '&';

    } else {

      $link .= $page;

      //$separator = '?';

    }

    return $link;

  }

  

  function com_not_null($value) {

    if (is_array($value)) {

      if (sizeof($value) > 0) {

        return true;

      } else {

        return false;

      }

    } else {

      if ( (is_string($value) || is_int($value)) && ($value != '') && ($value != 'NULL') && (strlen(trim($value)) > 0)) {

        return true;

      } else {

        return false;

      }

    }

  }

  

  

 

 function com_mounth_format($date) {

 	$date_arr=explode('-', $date);

 	$get_month=$date_arr[1];

	if($get_month=='01')

 		$month='January';

	elseif($get_month=='02')

		$month='February';

	elseif($get_month=='03')

		$month='March';

	elseif($get_month=='04')

		$month='April';	

	elseif($get_month=='05')

		$month='May';

	elseif($get_month=='06')

		$month='Jun';

	elseif($get_month=='07')

		$month='July';

	elseif($get_month=='08')

		$month='Augst';

	elseif($get_month=='09')

		$month='September';	

	elseif($get_month=='10')

		$month='October';

	elseif($get_month=='11')

		$month='November';	

	elseif($get_month=='12')

		$month='December';	

		

	$new_date_format=$month . ' ' . $date_arr[2] . ', '. 	$date_arr[0];

	return $new_date_format;

								

 } 

//Add 2009-09-15



function ShowBanner($title,$width){

		$banner_query ="select * from " . TABLE_BANNER . " where banner_title = '" . $title . "'"; 

		$banner_result = com_db_query($banner_query);

		$banner_row=com_db_fetch_array($banner_result);

		$path='uploade-file/banner/'.$banner_row['banner_img'];

		$link=$banner_row['banner_link'];

		if($link=='')

			$banner_show=com_setImage($path,$width,'','alt="" title=""');

		else 

			$banner_show='<a href="http://'. $link .'" target="_blank">' . com_setImage($path,$width,'','alt="" title=""') . '</a>';



		echo $banner_show;

}



//recursive function that prints categories as a nested html unorderd list

//Category_Subcategory_Show();

	/*$query = com_db_query("select * from " .TABLE_CATEGORIES );

	while ( $row = com_db_fetch_array($query) )

	{

		$menu_array[$row['categories_id']] = array('categories_name' => $row['categories_name'],'parent_id' => $row['parent_id']);

	}



	generate_menu(0);*/

		

function generate_menu($parent)

  {

    $has_childs = false;



	//this prevents printing 'ul' if we don't have subcategories for this category

    global $menu_array;

    //use global array variable instead of a local variable to lower stack memory requierment

    foreach($menu_array as $key => $value)

        {

			if ($value['parent_id'] == $parent) 

			{       

				//if this is the first child print '<ul>'                       

				if ($has_childs === false)

				{

					//don't print '<ul>' multiple times                             

					$has_childs = true;

					echo '<ul>';

				}

				echo '<li><a href="'.com_href_link(FILENAME_DEFAULT,'catID='.$key ).'">' . $value['categories_name'] . '</a>';

				generate_menu($key);

				//call function again to generate nested list for subcategories belonging to this category

				echo '</li>';

			}



        }

        if ($has_childs === true) echo '</ul>';

}

//Category & subcategory show



function get_category_tree($selected_id=0){

		global $table_name;

		$nav_query = com_db_query("SELECT * FROM " . TABLE_CATEGORIES . " WHERE parent_id ='0' ORDER BY sort_order");

		$tree = "";					// Clear the directory tree

						// Child level depth.

		$top_level_on = 1;			// What top-level category are we on?

			// Define the exclusion array

		global $exclude,$depth; 

		array_push($exclude, 0);	// Put a starting value in it

		

		while ( $nav_row = com_db_fetch_array($nav_query) )

		{

			$goOn = 1;			// Resets variable to allow us to continue building out the tree.

			for($x = 0; $x < count($exclude); $x++ )		// Check to see if the new item has been used

			{

				if ( $exclude[$x] == $nav_row['categories_id'] )

				{

					$goOn = 0;

					break;				// Stop looking b/c we already found that it's in the exclusion list and we can't continue to process this node

				}

			}

			if ( $goOn == 1 )

			{	

				if($selected_id == $nav_row['categories_id']){ $selected_str = "selected"; }else{ $selected_str = "";}

				$tree .= '<option value="' . $nav_row['categories_id'] . '" style="color:#000000; background-color:#D6E4F0" ' . $selected_str . '>' . $nav_row['categories_name'] . "</option>";				// Process the main tree node

				array_push($exclude, $nav_row['categories_id']);		// Add to the exclusion list

				if ( $nav_row['categories_id'] < 6 )

				{ $top_level_on = $nav_row['categories_id']; }

				

				$tree .= build_child($nav_row['categories_id'],$selected_id);		// Start the recursive function of building the child tree

			}

		}

	return $tree;

}





function build_child($oldID,$selected_id)			// Recursive function to get all of the children...unlimited depth

		{	

			$tempTree = '';

			$tempTreeSpace = '';

			global $exclude, $depth;			// Refer to the global array defined at the top of this script

			global $table_name;

			

			$child_query = com_db_query("SELECT * FROM `" . TABLE_CATEGORIES . "` WHERE parent_id=" . $oldID ." ORDER BY sort_order");

			while ( $child = com_db_fetch_array($child_query) )

			{

				if ( $child['categories_id'] != $child['parent_id'] )

				{	$tempTreeSpace = '';

					for ( $c=0;$c<$depth;$c++ )			// Indent over so that there is distinction between levels

					{ 

						$tempTreeSpace .= "&nbsp;&nbsp;";

					}

					if($selected_id == $child['categories_id']){ $selected_str = "selected"; }else{ $selected_str = "";}

					$tempTree .= '<option value="' . $child['categories_id'] . '" ' . $selected_str . '>' . $tempTreeSpace . '- ' . $child['categories_name'] . '</option>';

					

					$depth++;		// Incriment depth b/c we're building this child's child tree  (complicated yet???)

					$tempTree .= build_child($child['categories_id'],$selected_id);	// Add to the temporary local tree

					$depth--;		// Decrement depth b/c we're done building the child's child tree.

					array_push($exclude, $child['categories_id']);		// Add the item to the exclusion list

				}

			}

			

			return $tempTree;	// Return the entire child tree

		}	

		

/****************************************************************************/

$exclude = array();

$depth = 1;	



function get_category_tree_normal($selected_id=0){

		global $table_name;

		$nav_query = com_db_query("SELECT * FROM " . TABLE_CATEGORIES . " WHERE parent_id='0' ORDER BY sort_order");

		$tree = "";					// Clear the directory tree

						// Child level depth.

		$top_level_on = 1;			// What top-level category are we on?

			// Define the exclusion array

		global $exclude,$depth; 

		array_push($exclude, 0);	// Put a starting value in it

		

		while ( $nav_row = com_db_fetch_array($nav_query) )

		{

			$goOn = 1;			// Resets variable to allow us to continue building out the tree.

			for($x = 0; $x < count($exclude); $x++ )		// Check to see if the new item has been used

			{

				if ( $exclude[$x] == $nav_row['categories_id'] )

				{

					$goOn = 0;

					break;				// Stop looking b/c we already found that it's in the exclusion list and we can't continue to process this node

				}

			}

			if ( $goOn == 1 )

			{	

				if($selected_id == $nav_row['categories_id']){ $selected_str = "selected"; }else{ $selected_str = "";}

				//org $tree .= '<li ><a href="list.php?cat_id=' . $nav_row['categories_id'] . '">' . $nav_row['categories_name'] . "</a></li>";				// Process the main tree node	

				$tree .= '<a href="'.com_href_link(FILENAME_DEFAULT,'catID='.$nav_row['categories_id']). '">' . $nav_row['categories_name'] . "</a><br>";				// Process the main tree node							

				array_push($exclude, $nav_row['categories_id']);		// Add to the exclusion list

				if ( $nav_row['categories_id'] < 6 )

				{ $top_level_on = $nav_row['categories_id']; }

				

				$tree .= build_child_normal($nav_row['categories_id'],$selected_id);		// Start the recursive function of building the child tree

			}

		}

		return $tree;

	}





		

function build_child_normal($oldID,$selected_id)			// Recursive function to get all of the children...unlimited depth

		{	

			$tempTree = '';

			$tempTreeSpace = '';

			global $exclude, $depth;			// Refer to the global array defined at the top of this script

			global $table_name;

			

			$child_query = com_db_query("SELECT * FROM `" . TABLE_CATEGORIES . "` WHERE parent_id=" . $oldID ." ORDER BY sort_order");

			while ( $child = com_db_fetch_array($child_query) )

			{

				if ( $child['cat_id'] != $child['parent_id'] )

				{	$tempTreeSpace = '';

					for ( $c=0;$c<$depth;$c++ )			// Indent over so that there is distinction between levels

					{ 

						$tempTreeSpace .= "&nbsp;&nbsp;";

					}

					if($selected_id == $child['cat_id']){ $selected_str = "selected"; }else{ $selected_str = "";}

					//org $tempTree .= '<li><a href="list.php?cat_id=' . $child['categories_id'] . '" >' . $tempTreeSpace . '- ' . $child['categories_name'] . '</a></li>';

					$tempTree .=  $tempTreeSpace . '- <a href="'.com_href_link(FILENAME_DEFAULT,'catID='.$child['categories_id']) . '" >' .  $child['categories_name'] . '</a><br>';

					$depth++;		// Incriment depth b/c we're building this child's child tree  (complicated yet???)

					$tempTree .= build_child_normal($child['categories_id'],$selected_id);	// Add to the temporary local tree

					$depth--;		// Decrement depth b/c we're done building the child's child tree.

					array_push($exclude, $child['categories_id']);		// Add the item to the exclusion list

				}

			}

			

			return $tempTree;	// Return the entire child tree

		}

		

function DotLine($totChar,$charLen){

		   $tot_len = ($totChar - $charLen);

		   $dot_line = '';

		   for($ii=0; $ii<$tot_len ; $ii++){

			$dot_line .= '.';

		   }

		return $dot_line;

	}





function ComboBoxListValue($sql){

	$cmd_result = com_db_query($sql);

	if(cmd_result){

		$num_row=com_db_num_rows($cmd_result);

	}else{

		$num_row=0;

	}

	$cmdList = ' [ ';

	if($num_row > 0){

		while($cmd_row = com_db_fetch_row($cmd_result)){

			$cmdList .= "'".com_db_output($cmd_row[0])."', ";

		}

	}else{

		$cmdList .= "'None', ";

	}

	$cmdList = substr($cmdList,0,strlen($cmdList)-2);

	$cmdList .= ", 'Any' ]";

	return $cmdList;

}

function ComboBoxListValueAmount($sql){

	$cmd_result = com_db_query($sql);

	if(cmd_result){

		$num_row=com_db_num_rows($cmd_result);

	}else{

		$num_row=0;

	}

	$cmdList = ' [ ';

	if($num_row > 0){

		while($cmd_row = com_db_fetch_row($cmd_result)){

			$cmdList .= "'$".com_db_output($cmd_row[0])."', ";

		}

	}else{

		$cmdList .= "'None', ";

	}

	$cmdList = substr($cmdList,0,strlen($cmdList)-2);

	$cmdList .= ' ]';

	return $cmdList;

}

function ComboBoxIndustryValue(){

	$cmd_result = com_db_query("select industry_id,title from ".TABLE_INDUSTRY." where parent_id='0' order by industry_id");

	if(cmd_result){

		$num_row=com_db_num_rows($cmd_result);

	}else{

		$num_row=0;

	}

	$cmdList = ' [ ';

	if($num_row > 0){

		while($cmd_row = com_db_fetch_array($cmd_result)){

			$cmdList .= "'<b>".com_db_output($cmd_row['title'])."</b>', ";

			$cmd_sub_result = com_db_query("select title from ".TABLE_INDUSTRY." where parent_id='".$cmd_row['industry_id']."'");

			if(cmd_sub_result){

				$num_sub_row=com_db_num_rows($cmd_sub_result);

			}else{

				$num_sub_row=0;

			}

			if($num_sub_row>0){

				while($cmd_sub_row = com_db_fetch_row($cmd_sub_result)){

					$cmdList .= "'".com_db_output($cmd_sub_row[0])."', ";

				}	

			}

		}

	}else{

		$cmdList .= "'None', ";

	}

	$cmdList = substr($cmdList,0,strlen($cmdList)-2);

	$cmdList .= ",'Any' ]";

	return $cmdList;

}



function DivContentLoad($divID,$tbID,$fName,$TableName){

	$cmb_query = "select ".$fName." from " . $TableName." order by ".$fName;

	$cmb_result = com_db_query($cmb_query);

	$cmb_list='';

	while($cmb_row = com_db_fetch_array($cmb_result)){

			$cmb_list .='<a href="javascript://" onclick="TextboxValueChange('."'".$tbID."','".$divID."','".$cmb_row[$fName]."'".');DatePeriodControl();">'.$cmb_row[$fName].'</a><br />';

		}

	if($tbID =='email_update' || $tbID =='email_update_fequency' || $tbID =='delivery_schedule'){

		//not add;

	}else{		

		$cmb_list .='<a href="javascript://" onclick="TextboxValueChange('."'".$tbID."','".$divID."','Any'".');DatePeriodControl();">Any</a><br />';	

	}

	return $cmb_list;

	 

	}

function DivContentLoadCountry($divID,$tbID,$fName,$TableName){

	$cmb_query = "select ".$fName." from " . $TableName." where countries_name<>'United States' order by ".$fName;

	$cmb_result = com_db_query($cmb_query);

	$cmb_list='<a href="javascript://" onclick="TextboxValueChange('."'".$tbID."','".$divID."','United States'".')">United States</a><br />';

	while($cmb_row = com_db_fetch_array($cmb_result)){

			$cmb_list .='<a href="javascript://" onclick="TextboxValueChange('."'".$tbID."','".$divID."','".$cmb_row[$fName]."'".');DatePeriodControl();">'.$cmb_row[$fName].'</a><br />';

		}

	//$cmb_list .='<a href="javascript://" onclick="TextboxValueChange('."'".$tbID."','".$divID."','Any'".');">Any</a><br />';	

	return $cmb_list;

	}	

function DivContentLoadPrice($divID,$tbID,$fName,$TableName){

	$cmb_query = "select ".$fName." from " . $TableName ." order by ap_amount asc";

	$cmb_result = com_db_query($cmb_query);

	$cmb_list='';

	while($cmb_row = com_db_fetch_array($cmb_result)){

			if($cmb_row[$fName] >0 ){

				$cmb_list .='<a href="javascript://" onclick="TextboxValueChange('."'".$tbID."','".$divID."','$".$cmb_row[$fName]."'".');DatePeriodControl();">$'.$cmb_row[$fName].'</a><br />';

			}else{

				$cmb_list .='<a href="javascript://" onclick="TextboxValueChange('."'".$tbID."','".$divID."','$".$cmb_row[$fName]."'".');DatePeriodControl();">'.$cmb_row[$fName].'</a><br />';

			}

		}

	return $cmb_list;

	 

	}

function DivContentIndustryLoad($divID,$tbID,$fName,$TableName){

	$cmd_result = com_db_query("select industry_id,title from ".TABLE_INDUSTRY." where parent_id='0' order by industry_id");

	if(cmd_result){

		$num_row=com_db_num_rows($cmd_result);

	}else{

		$num_row=0;

	}

	$cmdList = '';

	if($num_row > 0){

		while($cmd_row = com_db_fetch_array($cmd_result)){

			$cmdList .= "<b>".com_db_output($cmd_row['title'])."</b><br />";

			$cmd_sub_result = com_db_query("select title from ".TABLE_INDUSTRY." where parent_id='".$cmd_row['industry_id']."'");

			if(cmd_sub_result){

				$num_sub_row=com_db_num_rows($cmd_sub_result);

			}else{

				$num_sub_row=0;

			}

			if($num_sub_row>0){

				while($cmd_sub_row = com_db_fetch_array($cmd_sub_result)){

					$cmdList .= '<a href="javascript://" onclick="TextboxValueChange('."'".$tbID."','".$divID."','".$cmd_sub_row['title']."'".');">'.$cmd_sub_row['title'].'</a><br />';

				}	

			}

		}

	}

	$cmdList .= '<a href="javascript://" onclick="TextboxValueChange('."'".$tbID."','".$divID."','Any'".');">Any</a><br />';

	return $cmdList;

}	

function DivContentLoadWithOrder($divID,$tbID,$fName,$orderFieldName,$TableName){

	$cmb_query = "select ".$fName." from " . $TableName." order by ".$orderFieldName;

	$cmb_result = com_db_query($cmb_query);

	$cmb_list='';

	while($cmb_row = com_db_fetch_array($cmb_result)){

			$cmb_list .='<a href="javascript://" onclick="TextboxValueChange('."'".$tbID."','".$divID."','".$cmb_row[$fName]."'".');DatePeriodControl();">'.$cmb_row[$fName].'</a><br />';

		}

	if($tbID =='email_update' || $tbID =='email_update_fequency' || $tbID =='delivery_schedule'){

		//not add;

	}else{		

		$cmb_list .='<a href="javascript://" onclick="TextboxValueChange('."'".$tbID."','".$divID."','Any'".');DatePeriodControl();">Any</a><br />';	

	}

	return $cmb_list;

	 

	}

	

function make_thumb($img_name, $filename,$new_w,$new_h=0)

	{

		$ext=strtolower(getExtension($img_name));

		if(!strcmp("jpg",$ext) || !strcmp("jpeg",$ext))

			$src_img=imagecreatefromjpeg($img_name);

		if(!strcmp("png",$ext))

			$src_img=imagecreatefrompng($img_name);

		if(!strcmp("gif",$ext))

			$src_img=imagecreatefromgif($img_name);	

			

		$old_x=imagesx($src_img);	

		$old_y=imagesy($src_img);

		$_array['width']=$old_x;

		$_array['height']=$old_y;

		

		$thumb_w=$new_w;

		if($new_w>$old_x){

			$thumb_w=$new_w;

			}

		if($new_w<$old_x){

			$thumb_w=$new_w;

			}	

		if((int)$new_h==0){

			$thumb_h=round(($thumb_w*$old_y)/$old_x);

			}

		else

			{

			$thumb_h=$new_h;

			}		

		$dst_img=imagecreatetruecolor($thumb_w,$thumb_h);

		imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y);

		if(!strcmp("png",$ext))

			imagepng($dst_img,$filename);

		elseif(!strcmp("gif",$ext))	

			imagegif($dst_img,$filename);

		else

			imagejpeg($dst_img,$filename);

			

		imagedestroy($dst_img);

		imagedestroy($src_img);		

		

	}	

		

function getExtension($str)

	{

		$i=strrpos($str,".");

		if(!$i) {return "";}

		$l=strlen($str)-$i;

		$ext=substr($str,$i+1,$l);

		return $ext;

	}
	
	
function addDate($days){
$date = date('Y-m-j');
$duration=$days.' day';
$newdate = strtotime ( $duration , strtotime ( $date ) ) ;
$newdate = date ( 'Y-m-j' , $newdate );
return $newdate;
}

function subDate($days){
$date = date('Y-m-j');
$duration='-'.$days.' day';
$newdate = strtotime ( $duration , strtotime ( $date ) ) ;
$newdate = date ( 'Y-m-j' , $newdate );
return $newdate;
}

//add date from your date
function addDate_fromdate($days,$date){
//$date = date('Y-m-j');
$duration=$days.' day';
$newdate = strtotime ( $duration , strtotime ( $date ) ) ;
$newdate = date ( 'Y-m-j' , $newdate );
return $newdate;
}

//subtract date from your date
function subDate_fromdate($days,$date){
//$date = date('Y-m-j');
$duration='-'.$days.' day';
$newdate = strtotime ( $duration , strtotime ( $date ) );
$newdate = date ( 'Y-m-j' , $newdate );
return $newdate;
}
					
function mail_server_settings_ComboBox($selected_val = '',$comboWidth = '',$comboStatus = '')
	{
	$all_option = "";
	$all_option .= '<select name=mail_server_settings id=mail_server_settings '.$comboStatus.' style=width:'.$comboWidth.'>';
	if($selected_val == 'Accept All')
		$this_selected = "selected";
	else	
		$this_selected = "";
	$all_option .= '<option '.$this_selected.' value=Accept All>Accept All</option>';
	
	if($selected_val == 'Open')
		$this_selected = "selected";
	else	
		$this_selected = "";
	$all_option .= '<option '.$this_selected .' value=Open>Open</option>';
	
	if($selected_val == 'Unknown')
		$this_selected = "selected";
	else	
		$this_selected = "";
	$all_option .= '<option '.$this_selected .' value=Unknown>Unknown</option>';
	
	if($selected_val == 'None')
		$this_selected = "selected";
	else	
		$this_selected = "";
	$all_option .= '<option '.$this_selected .'value=None>None</option>';
	$all_option .= '</select>';
	return $all_option;
	}


	function send_email_alert()
	{
	
		$info_file = fopen("site_down_email.txt", "r");

		$last_email_time = fgets($info_file);
		fclose($info_file);
		$cur_time =  date("H");
		
		if($last_email_time != $cur_time)
		{
	
			$to_admin = "faraz_aleem@hotmail.com";
			$subject = "CTOS Website Down";
			$message = "CTOS website is down.";
			$from = "CTOS";
			send_email_mailer($to_admin, $subject, $message, '','');
			
			$info_file_w = fopen("site_down_email.txt", "w");
			fwrite($info_file_w,$cur_time);
			fclose($info_file_w);
		}	
	}
        
        
        function send_email_admin()
	{
	
            //echo "<br>Last page: ".$_SERVER['HTTP_REFERER'];
            
            $to_admin = "faraz_aleem@hotmail.com";
            $subject = "User reached to page not found on CTOs";
            $message = "User reached to page not found on CTOs from: ".$_SERVER['HTTP_REFERER'];
            $from = "CTOS";
            send_email_mailer($to_admin, $subject, $message, '','');
		
	}
        
        
	
	
	function getting_email_pattern($fn,$mn,$ln,$e_domain,$c_email)
	{
            //echo "<br>HHH";
		//$fn = "faraz";
		//$mn = "haf";
		//$ln = "aleem";
		//$e_domain = "@nxb.com.pk";
		//$c_email = $_GET['email'];//"faraz.aleem@nxb.com.pk";
		
                echo "<br>First name: ".$fn;
                echo "<br>Middle name: ".$mn;
                echo "<br>Last name: ".$ln;
                echo "<br>Email: ".$c_email;
            
		$c_email = trim($c_email);
		
		$first_name_initial = substr($fn, 0, 1);
		$middle_name_initial = substr($mn, 0, 1);
		$last_name_initial = substr($ln, 0, 1);
		$e_domain = "@".$e_domain;
		
		//echo "<br>first_name: ".$fn.":";
		//echo "<br>middle_name: ".$mn.":";
		//echo "<br>last_name: ".$ln.":";
		//echo "<br>email_domain: ".$e_domain.":";
		//echo "<br>email_to_check: ".$c_email.":";
		//echo $fn.".".$ln.$e_domain .'=='. $c_email;
		
		//echo "<br><br>".$fn.".".$ln.$e_domain;
		
		//echo "<br>first_name_initial: ".$first_name_initial;
		//echo "<br>ln: ".$ln;
		//echo "<br>first_name_initial: ".$first_name_initial;
		
		
		$pattern = '';
		if($first_name_initial.$ln.$e_domain == $c_email)
		{
			$pattern = 1;
		}
		elseif($fn.".".$ln.$e_domain == $c_email)
		{
			//echo "<br><br>In two: ".$fn.".".$ln.$e_domain;
			$pattern = 2;
		}
		elseif($fn.$e_domain == $c_email)
		{
			$pattern = 3;
		}
		elseif($fn.$last_name_initial.$e_domain == $c_email)
		{
			$pattern = 4;
		}
		elseif($fn."_".$ln.$e_domain == $c_email)
		{
			$pattern = 5;
		}
		elseif($ln.$e_domain == $c_email)
		{
			$pattern = 6;
		}
		elseif($fn.$ln.$e_domain == $c_email)
		{
			$pattern = 7;
		}
		elseif($ln.$first_name_initial.$e_domain == $c_email)
		{
			$pattern = 8;
		}
		elseif($first_name_initial.".".$ln.$e_domain == $c_email)
		{
			$pattern = 9;
		}
		elseif($ln.".".$fn.$e_domain == $c_email)
		{
			$pattern = 10;
		}
		elseif($last_name_initial.$fn.$e_domain == $c_email)
		{
			$pattern = 11;
		}
		elseif($fn."-".$ln.$e_domain == $c_email)
		{
			$pattern = 12;
		}
		elseif($first_name_initial.$first_name_initial.$ln.$e_domain == $c_email)
		{
			$pattern = 13;
		}
		elseif($first_name_initial.substr($fn, 0, 2).$e_domain == $c_email)
		{
			$pattern = 14;
		}
		elseif($first_name_initial.substr($fn, 0, 5).$e_domain == $c_email)
		{
			$pattern = 15;
		}
		elseif($first_name_initial.substr($fn, 0, 4).$e_domain == $c_email)
		{
			$pattern = 16;
		}
		elseif($first_name_initial.substr($fn, 0, 3).$e_domain == $c_email)
		{
			$pattern = 17;
		}
		elseif($first_name_initial.substr($fn, 0, 7).$e_domain == $c_email)
		{
			$pattern = 18;
		}
		elseif($first_name_initial.substr($fn, 0, 6).$e_domain == $c_email)
		{
			$pattern = 19;
		}
		elseif($ln."_".$fn.$e_domain == $c_email)
		{
			$pattern = 20;
		}
		elseif($fn.".".$middle_name_initial.".".$ln.$e_domain == $c_email)
		{
			$pattern = 21;
		}
		elseif($fn."_".$middle_name_initial."_".$ln.$e_domain == $c_email)
		{
			$pattern = 22;
		}
		elseif($ln.".".$first_name_initial == $c_email)
		{
			$pattern = 23;
		}
		elseif($ln."_".substr($fn, 0, 2) == $c_email)
		{
			$pattern = 24;
		}
		elseif($first_name_initial."_".$ln == $c_email)
		{
			$pattern = 25;
		}
		elseif($first_name_initial.$last_name_initial == $c_email)
		{
			$pattern = 26;
		}
		elseif($first_name_initial.$middle_name_initial.$last_name_initial == $c_email)
		{
			$pattern = 27;
		}
		return $pattern;
	}
	
	
	function getImageXY( $image, $imgDimsMax=140) 
	{
		$top = 0;
		$left = 0;

		// COPIED
		/*
		$org_image = HTTPS_SITE_URL.'company_logo/org/'.$image;
		$image = HTTPS_SITE_URL.'company_logo/demoemail/'.$image;
		//copy('foo/test.php', 'bar/test.php');
		copy($org_image, $image);
		*/


		$aspectRatio= 1;    // deafult aspect ratio...keep the image as is.

		// set the default dimensions.
		$imgWidth   = $imgDimsMax;
		$imgHeight  = $imgDimsMax;

		list( $width, $height, $type, $attr ) = getimagesize( $image );

		if( $width == $height ) {
			// if the image is less than ( $imgDimsMax x $imgDimsMax ), use it as is..
			if( $width < $imgDimsMax ) {
				$imgWidth   = $width;
				$imgHeight  = $height;
				$top = $imgDimsMax - $imgWidth;
				$left = $imgDimsMax - $imgWidth;
			}
		} else {
			if( $width > $height ) {
				// set $imgWidth to $imgDimsMax and resize $imgHeight proportionately
				$aspectRatio    = $imgWidth / $width;
				$imgHeight      = floor ( $height * $aspectRatio );
				$top = ( $imgDimsMax - $imgHeight ) / 2;
			} else if( $width < $height ) {
				// set $imgHeight to $imgDimsMax and resize $imgWidth proportionately
				$aspectRatio    = $imgHeight / $height;
				$imgWidth       = floor ( $width * $aspectRatio );
				$left = ( $imgDimsMax - $imgWidth ) / 2;
			}
		}

		//return '<img src="' . $image . '" width="' . $imgWidth . '" height="' . $imgHeight . '" style="position:relative;display:inline;top:'.$top.'px;left:'.$left.'px;" />';
		//return '<img src="' . $image . '" width="' . $imgWidth . '" height="' . $imgHeight . '"  />';
		//return '<img src=' . $image . ' width=80 height=' . $imgHeight . ' style="margin:auto;top:0px;right:0px;bottom:0px;left:0px;position:absolute !important;"  />';
		
		return $image.":HEIGHT:".$imgHeight;
	}
	
	/*
	function this_user_invoices()
	{
            $invoice_dates = array();
            $find_invoices_query = com_db_query("select * from ".TABLE_INVOICES." where user_id='".$_SESSION['sess_user_id']."' and appear_date <= now()");
            //echo "<br>find_invoices_query: select * from ".TABLE_INVOICES." where user_id='".$_SESSION['sess_user_id']."' and appear_date <= now()";
            if($find_invoices_query)
            {
                $invoice_num = com_db_num_rows($find_invoices_query);
                //echo "<br>invoice_num: ".$invoice_num;
                if($invoice_num > 0)
                {
                    $invoice_row = com_db_fetch_array($find_invoices_query);
                    $appear_date = $invoice_row['appear_date'];
                    $due_date = $invoice_row['payment_due_date'];

                    $d1 = new DateTime($appear_date);
                    $d2 = new DateTime(date("Y-m-d"));
                    //$d2 = new DateTime($due_date);
                    $no_of_months = $d1->diff($d2)->m;
                    //echo "<br>no_of_months: ".$no_of_months;
                    for($i = 0; $i<$no_of_months+1;$i++)
                    {
                        $time_2 = strtotime($appear_date);
                        $final = date("Y-m-d", strtotime("+$i month", $time_2));
                        $invoice_dates[] = $final;
                    }
                }
            }
            //echo "<pre>invoice_dates: ";	print_r($invoice_dates);	echo "</pre>";
            return $invoice_dates;
	}
	*/
        
        function this_user_invoices()
{
    $invoice_dates = array();
    //$find_invoices_query = com_db_query("select * from ".TABLE_INVOICES." where user_id='".$_SESSION['sess_user_id']."' and appear_date <= now()");
    
    //echo "select * from hre_saved_invoices where user_id='".$_SESSION['sess_user_id']."'";
    
    $find_invoices_query = com_db_query("select * from cto_saved_invoices where user_id='".$_SESSION['sess_user_id']."'");
    if($find_invoices_query)
    {
        $invoice_num = com_db_num_rows($find_invoices_query);
        if($invoice_num > 0)
        {
            //$invoice_row = com_db_fetch_array($find_invoices_query);
            while ($invoice_row = com_db_fetch_array($find_invoices_query)) 
            {        
                $display_name = $invoice_row['display_name'];
                /*
                $appear_date = $invoice_row['appear_date'];
                $due_date = $invoice_row['payment_due_date'];

                $d1 = new DateTime($appear_date);
                $d2 = new DateTime(date("Y-m-d"));
                //$d2 = new DateTime($due_date);
                $no_of_months = $d1->diff($d2)->m;

                for($i = 0; $i<$no_of_months+1;$i++)
                {
                    $time_2 = strtotime($appear_date);
                    $final = date("Y-m-d", strtotime("+$i month", $time_2));
                    $invoice_dates[] = $final;
                }
                */
                $invoice_dates[] = $display_name;
            }
        }
    }
    //echo "<pre>invoice_dates: ";	print_r($invoice_dates);	echo "</pre>";
    return $invoice_dates;
}
        
        
        
	
	function get_domain($comp_url)
        {
            if(strpos($comp_url,"http://www.") > -1)
            {
                //echo "<br><br>Within http://www. if<br><br>";    
                $comp_url = str_replace("http://www.","",$comp_url);
            }    

            if(strpos($comp_url,"https://www.") > -1)
                $comp_url = str_replace("https://www.","",$comp_url);

            if(strpos($comp_url,"www.") > -1)
            {        
                //echo "<br><br>Within www if<br><br>";
                $comp_url = str_replace("www.","",$comp_url);
            }

            if(strpos($comp_url,"https://") > -1)
            {        
                $comp_url = str_replace("https://","",$comp_url);
            }    

            if(strpos($comp_url,"http://") > -1)
            {
                $comp_url = str_replace("http://","",$comp_url);
            }

            $slach_pos = strpos($comp_url, "/");
            if($slach_pos > 0)
            {
                    $ext_domain = substr($comp_url,0,$slach_pos);	
            }
            else
                     $ext_domain = substr($comp_url,0,strlen($comp_url));	
            return $ext_domain;
        }
        
        
        
        // function used on dataentry/company.php edit case
        function getSiteUsers($comp_url)
  {
     // $comp_url = $_GET['comp_url'];
    
    $compQuery = "select company_id,email_domain from ".TABLE_COMPANY_MASTER." where company_website ='".$comp_url."'";
	
    $compResult = com_db_query($compQuery);
    $compRow = com_db_fetch_array($compResult);
    $company_id = com_db_output($compRow['company_id']);
    $email_domain = com_db_output($compRow['email_domain']);

    //echo "<br>company_id: ".$company_id;
    //echo "<br>email_domain: ".$email_domain;

    $matched_val = "";
    if($email_domain != '')
        $matched_val = $email_domain;
    elseif($comp_url != '')
    {
        $extracted_domain = str_replace("www.", "", $comp_url);
        $matched_val = $extracted_domain;
    }    
    //10.132.225.160
    $hre = mysql_connect("10.132.225.160","hre2","htXP%th@71",TRUE) or die("Databasee ERROR:".mysql_error());
    mysql_select_db("hre2",$hre) or die ("ERROR: Database not found ");
    
    $first_name = "NO VAL";
    $current_funding_person_id = "";
    //$moveResult = mysql_query("select personal_id from hre_personal_master where personal_id=57159",$hre);
    $personalsResult = mysql_query("select personal_id,first_name,last_name,add_to_funding from hre_personal_master where email like '%".$matched_val."%' and personal_image != '' and email != ''",$hre);
    
    //echo "<br><br>select personal_id,first_name,last_name from hre_personal_master where email like '%".$matched_val."%' and personal_image != '' and email != ''";
    
    $numPersonal = com_db_num_rows($personalsResult);
    if($numPersonal > 0)
    {
        $output = "<select name=personalForFunding id=personalForFunding><option>Select Funding Person</option>";
        while($personalRow = mysql_fetch_array($personalsResult))
        {
            //echo "<pre>personalRow: ";   print_r($personalRow);   echo "</pre>";
            
            $personal_id = $personalRow['personal_id'];    
            $first_name = $personalRow['first_name'];
            $last_name = $personalRow['last_name'];
            $full_name = $first_name." ".$last_name;
            $add_to_funding = $personalRow['add_to_funding'];
            
            if($add_to_funding == 1) 
            {
                $current_funding_person_id = $personal_id;
                $selected = "selected"; 
            }    
            else 
                echo $selected = "";
            
            //echo "<br><br>first_name: ".$first_name;
            //echo "<br>last_name: ".$last_name;
            //echo "<br>full_name: ".$full_name;
            $output .= "<option $selected value=".$personal_id.">".$full_name."</option>";
        }
        $output .= "</select>";
        
        /*
        if($current_funding_person_id != '')
        {
            $output .= "&nbsp;&nbsp;<span onclick=remove_funding_person(".$current_funding_person_id.")>Remove Funding person</span>";
        } 
        */   
    }    
    mysql_close($hre);
    return $output;
  }
       
  
  function set_funding_person($site_name,$funding_person_id,$this_company_id)
    {
      //echo "<br>site_name: ".$site_name;
        if($site_name == 'cto')
        {    
            com_db_connect() or die('Unable to connect to database server!');
            
            // Unset current funding person
            $exeUnCtoResult = com_db_query("SELECT mm.personal_id,first_name,last_name
            FROM ".TABLE_COMPANY_MASTER." AS cm, "
            .TABLE_MOVEMENT_MASTER." AS mm," 
            .TABLE_PERSONAL_MASTER." AS pm
            WHERE (cm.company_id = mm.company_id AND pm.personal_id = mm.personal_id)
            AND cm.company_id =".$this_company_id." and add_to_funding = 1");
            
            //$compResult = com_db_query($compQuery);
            $exeUnRow = com_db_fetch_array($exeUnCtoResult);
            $current_funding_person_id = com_db_output($exeUnRow['personal_id']);
            
            $current_funding_person_first_name = com_db_output($exeUnRow['first_name']);
            $current_funding_person_last_name = com_db_output($exeUnRow['last_name']);
            
            $currPersonal = mysql_query("UPDATE ".TABLE_PERSONAL_MASTER." set add_to_funding = 0 where personal_id = '".$current_funding_person_id."'");
            
            //echo "<br>UPDATE ".TABLE_PERSONAL_MASTER." set add_to_funding = 1 where personal_id = '".$funding_person_id."'";
            $personalsResult = mysql_query("UPDATE ".TABLE_PERSONAL_MASTER." set add_to_funding = 1 where personal_id = '".$funding_person_id."'");
            
            
            if($funding_person_id != 'Select Funding Person')
            {
                $getPersonalResult = com_db_query("SELECT first_name,last_name FROM cto_personal_master where personal_id =".$funding_person_id);
                $getPersonalRow = com_db_fetch_array($getPersonalResult);
                $current_funding_person_first_name = com_db_output($getPersonalRow['first_name']);
                $current_funding_person_last_name = com_db_output($getPersonalRow['last_name']);
            
                mysql_close($hre);
                return $current_funding_person_first_name.":".$current_funding_person_last_name;
            }    
            //if (!$personalsResult) 
            //{
            //     echo '<b>Invalid query:</b><br>' . mysql_error() . '<br><br>';
            //}
        } 
      
      
        if($site_name == 'cfo')
        {    
            $cfo = mysql_connect("10.132.233.66","cfo2","cV!kJ201Ze",TRUE) or die("Database ERROR ");
            mysql_select_db("cfo2",$cfo) or die ("ERROR: Database not found ");
            
            
            $exeUnHreResult = com_db_query("SELECT mm.personal_id,first_name,last_name
            FROM cfo_company_master AS cm, 
            cfo_movement_master AS mm, 
            cfo_personal_master AS pm
            WHERE (cm.company_id = mm.company_id AND pm.personal_id = mm.personal_id)
            AND cm.company_id =".$this_company_id." and add_to_funding = 1");
            
            //$compResult = com_db_query($compQuery);
            $exeUnRow = com_db_fetch_array($exeUnHreResult);
            $current_funding_person_id = com_db_output($exeUnRow['personal_id']);
            
            $current_funding_person_first_name = com_db_output($exeUnRow['first_name']);
            $current_funding_person_last_name = com_db_output($exeUnRow['last_name']);

            //echo "<br>current_funding_person_id: ".$current_funding_person_id;
            
            //echo "<br>Unsetting current Funding person Q:UPDATE hre_personal_master set add_to_funding = 0 where personal_id = '".$current_funding_person_id."'";
            
            $currPersonal = mysql_query("UPDATE cfo_personal_master set add_to_funding = 0 where personal_id = '".$current_funding_person_id."'");
            
            
            $personalsResult = mysql_query("UPDATE cfo_personal_master set add_to_funding = 1 where personal_id = '".$funding_person_id."'",$cfo);
            
            if($funding_person_id != 'Select Funding Person')
            {
                $getPersonalResult = com_db_query("SELECT first_name,last_name FROM cfo_personal_master where personal_id =".$funding_person_id);
                $getPersonalRow = com_db_fetch_array($getPersonalResult);
                $current_funding_person_first_name = com_db_output($getPersonalRow['first_name']);
                $current_funding_person_last_name = com_db_output($getPersonalRow['last_name']);
                mysql_close($hre);
                return $current_funding_person_first_name.":".$current_funding_person_last_name;
            }    
        } 
      
        
        if($site_name == 'clo')
        {    
            $clo = mysql_connect("10.132.233.67","clo2","dtBO#7310",TRUE) or die("Database ERROR".mysql_error());
            mysql_select_db("clo2",$clo) or die ("ERROR: Database not found ");
            
            
            $exeUnHreResult = com_db_query("SELECT mm.personal_id,first_name,last_name
            FROM clo_company_master AS cm, 
            clo_movement_master AS mm, 
            clo_personal_master AS pm
            WHERE (cm.company_id = mm.company_id AND pm.personal_id = mm.personal_id)
            AND cm.company_id =".$this_company_id." and add_to_funding = 1");
            
            //$compResult = com_db_query($compQuery);
            $exeUnRow = com_db_fetch_array($exeUnHreResult);
            $current_funding_person_id = com_db_output($exeUnRow['personal_id']);
            

            $current_funding_person_first_name = com_db_output($exeUnRow['first_name']);
            $current_funding_person_last_name = com_db_output($exeUnRow['last_name']);

            //echo "<br>current_funding_person_id: ".$current_funding_person_id;
            
            //echo "<br>Unsetting current Funding person Q:UPDATE hre_personal_master set add_to_funding = 0 where personal_id = '".$current_funding_person_id."'";
            
            $currPersonal = mysql_query("UPDATE clo_personal_master set add_to_funding = 0 where personal_id = '".$current_funding_person_id."'");
            
            $personalsResult = mysql_query("UPDATE clo_personal_master set add_to_funding = 1 where personal_id = '".$funding_person_id."'",$clo);
            
            
            if($funding_person_id != 'Select Funding Person')
            {
                $getPersonalResult = com_db_query("SELECT first_name,last_name FROM clo_personal_master where personal_id =".$funding_person_id);
                $getPersonalRow = com_db_fetch_array($getPersonalResult);
                $current_funding_person_first_name = com_db_output($getPersonalRow['first_name']);
                $current_funding_person_last_name = com_db_output($getPersonalRow['last_name']);
                mysql_close($hre);
                return $current_funding_person_first_name.":".$current_funding_person_last_name;

            }    
        }
        
        if($site_name == 'cmo')
        {    
            $cmo = mysql_connect("10.132.232.238","cmo1","mocos!cm123",TRUE) or die("Database ERROR ");
            mysql_select_db("cmo1",$cmo) or die ("ERROR: Database not found ");
            
            /*echo "<br>CMO Q : SELECT mm.personal_id
            FROM cmo_company_master AS cm, 
            cmo_movement_master AS mm, 
            cmo_personal_master AS pm
            WHERE (cm.company_id = mm.company_id AND pm.personal_id = mm.personal_id)
            AND cm.company_id =".$this_company_id." and add_to_funding = 1";
              
             */
            
            
            $exeUnHreResult = com_db_query("SELECT mm.personal_id,first_name,last_name
            FROM cmo_company_master AS cm, 
            cmo_movement_master AS mm, 
            cmo_personal_master AS pm
            WHERE (cm.company_id = mm.company_id AND pm.personal_id = mm.personal_id)
            AND cm.company_id =".$this_company_id." and add_to_funding = 1");
            
            //$compResult = com_db_query($compQuery);
            $exeUnRow = com_db_fetch_array($exeUnHreResult);
            $current_funding_person_id = com_db_output($exeUnRow['personal_id']);
            
            $current_funding_person_first_name = com_db_output($exeUnRow['first_name']);
            $current_funding_person_last_name = com_db_output($exeUnRow['last_name']);
            
            //echo "<br>current_funding_person_id: ".$current_funding_person_id;
            
            //echo "<br>Unsetting current Funding person Q:UPDATE clo_personal_master set add_to_funding = 0 where personal_id = '".$current_funding_person_id."'";
            
            $currPersonal = mysql_query("UPDATE cmo_personal_master set add_to_funding = 0 where personal_id = '".$current_funding_person_id."'");
            
            //echo "<br>setting new Funding person Q:UPDATE clo_personal_master set add_to_funding = 1 where personal_id = '".$funding_person_id."'";
            
            
            $personalsResult = mysql_query("UPDATE cmo_personal_master set add_to_funding = 1 where personal_id = '".$funding_person_id."'",$cmo);
            
            if($funding_person_id != 'Select Funding Person')
            {
                $getPersonalResult = com_db_query("SELECT first_name,last_name FROM cmo_personal_master where personal_id =".$funding_person_id);
                $getPersonalRow = com_db_fetch_array($getPersonalResult);
                $current_funding_person_first_name = com_db_output($getPersonalRow['first_name']);
                $current_funding_person_last_name = com_db_output($getPersonalRow['last_name']);
                mysql_close($hre);
                return $current_funding_person_first_name.":".$current_funding_person_last_name;
            }    
        }
        
      
      
        if($site_name == 'hr')
        {    
            $hre = mysql_connect("10.132.225.160","hre2","htXP%th@71",TRUE) or die("Databasee ERROR:".mysql_error());
            mysql_select_db("hre2",$hre) or die ("ERROR: Database not found ");
            
            
            // Unset current funding person
            
            $exeUnHreResult = com_db_query("SELECT mm.personal_id
            FROM hre_company_master AS cm, 
            hre_movement_master AS mm, 
            hre_personal_master AS pm
            WHERE (cm.company_id = mm.company_id AND pm.personal_id = mm.personal_id)
            AND cm.company_id =".$this_company_id." and add_to_funding = 1");
            
            //$compResult = com_db_query($compQuery);
            $exeUnRow = com_db_fetch_array($exeUnHreResult);
            $current_funding_person_id = com_db_output($exeUnRow['personal_id']);
            

            //echo "<br>current_funding_person_id: ".$current_funding_person_id;
            
            //echo "<br>Unsetting current Funding person Q:UPDATE hre_personal_master set add_to_funding = 0 where personal_id = '".$current_funding_person_id."'";
            
            $currPersonal = mysql_query("UPDATE hre_personal_master set add_to_funding = 0 where personal_id = '".$current_funding_person_id."'");
            
            
            //echo "<br>New Funding person Q: UPDATE hre_personal_master set add_to_funding = 1 where personal_id = '".$funding_person_id."'";
            $personalsResult = mysql_query("UPDATE hre_personal_master set add_to_funding = 1 where personal_id = '".$funding_person_id."'",$hre);
            
            
            if($funding_person_id != 'Select Funding Person')
            {    
                $getPersonalResult = com_db_query("SELECT first_name,last_name FROM hre_personal_master where personal_id =".$funding_person_id);
                $getPersonalRow = com_db_fetch_array($getPersonalResult);
                $current_funding_person_first_name = com_db_output($getPersonalRow['first_name']);
                $current_funding_person_last_name = com_db_output($getPersonalRow['last_name']);
                mysql_close($hre);
                return $current_funding_person_first_name.":".$current_funding_person_last_name;
            }
        }
    }
    
    
    
    function getExecutives($site_name,$company_id_for_executives)
    {
        if($site_name == 'cto')
        {    
            com_db_connect() or die('Unable to connect to database server!');
            $exeCfoResult = mysql_query("SELECT mm.personal_id,pm.first_name,pm.last_name,pm.add_to_funding
            FROM ".TABLE_COMPANY_MASTER." AS cm, "
            .TABLE_MOVEMENT_MASTER." AS mm," 
            .TABLE_PERSONAL_MASTER." AS pm
            WHERE (cm.company_id = mm.company_id AND pm.personal_id = mm.personal_id)
            AND cm.company_id =".$company_id_for_executives." amd ciso_user != 1 group by personal_id");
            
            /*
            echo "Query: SELECT mm.personal_id,pm.first_name,pm.last_name,pm.add_to_funding
            FROM ".TABLE_COMPANY_MASTER." AS cm, "
            .TABLE_MOVEMENT_MASTER." AS mm," 
            .TABLE_PERSONAL_MASTER." AS pm
            WHERE (cm.company_id = mm.company_id AND pm.personal_id = mm.personal_id)
            AND cm.company_id =".$company_id_for_executives." group by personal_id";
            echo "<br>Query resutl: ".$exeCfoResult;
             */
            
            $numExec = com_db_num_rows($exeCfoResult);
            //$numExec = mysql_num_rows($exeCfoResult);
            
            $cfo_exe = "";
            
            if($numExec > 0)
            {
                // onchange=enableBtn(this.value)
                $cfo_exe .= "<table style=text-align:right;padding-right:150px;width:100%;><tr><td><select  name=cto_funding_exe id=cto_funding_exe onchange=check_selection()>";   /*  onchange=check_selection() */
                $cfo_exe .= "<option>Select Funding Person</option>";
                while($exeCfoRow = mysql_fetch_array($exeCfoResult))
                {
                    //echo "<pre>personalRow: ";   print_r($personalRow);   echo "</pre>";
                    $hr_personal_id = $exeCfoRow['personal_id'];  
                    $hr_first_name = $exeCfoRow['first_name'];  
                    $hr_last_name = $exeCfoRow['last_name'];  
                    $add_to_funding = $exeCfoRow['add_to_funding'];  
                    $funding_selected = ""; 
                    if($add_to_funding == 1)
                    {
                        //$funding_yes = 1;
                        $funding_selected = "selected"; 
                    }       
                    //$cfo_exe_arr[$hr_personal_id] = $hr_first_name." ".$hr_last_name;
                    $cfo_exe .= "<option ".$funding_selected." value=".$hr_personal_id.">".$hr_first_name." ".$hr_last_name."</option>";
                }
                $cfo_exe .= "</select></td><td style=width:45px;>";
                $cfo_exe .= "CTO</td></tr></table>";
                
                
                 
                
                
                
            }    
            //echo "<pre>cfo_exe_arr:";   print_r($cfo_exe_arr);   echo "</pre>";
            
            //echo "<br>cfo_exe: ".$cfo_exe;
            return $cfo_exe;
        }
        
        if($site_name == 'ciso')
        {    
            com_db_connect() or die('Unable to connect to database server!');
            $exeCfoResult = mysql_query("SELECT mm.personal_id,pm.first_name,pm.last_name,pm.add_to_funding
            FROM ".TABLE_COMPANY_MASTER." AS cm, "
            .TABLE_MOVEMENT_MASTER." AS mm," 
            .TABLE_PERSONAL_MASTER." AS pm
            WHERE (cm.company_id = mm.company_id AND pm.personal_id = mm.personal_id)
            AND cm.company_id =".$company_id_for_executives." and ciso_user = 1 group by personal_id");
            
            /*
            echo "Query: SELECT mm.personal_id,pm.first_name,pm.last_name,pm.add_to_funding
            FROM ".TABLE_COMPANY_MASTER." AS cm, "
            .TABLE_MOVEMENT_MASTER." AS mm," 
            .TABLE_PERSONAL_MASTER." AS pm
            WHERE (cm.company_id = mm.company_id AND pm.personal_id = mm.personal_id)
            AND cm.company_id =".$company_id_for_executives." group by personal_id";
            echo "<br>Query resutl: ".$exeCfoResult;
             */
            
            $numExec = com_db_num_rows($exeCfoResult);
            //$numExec = mysql_num_rows($exeCfoResult);
            
            $cfo_exe = "";
            
            if($numExec > 0)
            {
                // onchange=enableBtn(this.value)
                $cfo_exe .= "<table style=text-align:right;padding-right:150px;width:100%;><tr><td><select  name=ciso_funding_exe id=ciso_funding_exe onchange=check_selection()>";   /*  onchange=check_selection() */
                $cfo_exe .= "<option>Select Funding Person</option>";
                while($exeCfoRow = mysql_fetch_array($exeCfoResult))
                {
                    //echo "<pre>personalRow: ";   print_r($personalRow);   echo "</pre>";
                    $hr_personal_id = $exeCfoRow['personal_id'];  
                    $hr_first_name = $exeCfoRow['first_name'];  
                    $hr_last_name = $exeCfoRow['last_name'];  
                    $add_to_funding = $exeCfoRow['add_to_funding'];  
                    $funding_selected = ""; 
                    if($add_to_funding == 1)
                    {
                        //$funding_yes = 1;
                        $funding_selected = "selected"; 
                    }       
                    //$cfo_exe_arr[$hr_personal_id] = $hr_first_name." ".$hr_last_name;
                    $cfo_exe .= "<option ".$funding_selected." value=".$hr_personal_id.">".$hr_first_name." ".$hr_last_name."</option>";
                }
                $cfo_exe .= "</select></td><td style=width:45px;>";
                $cfo_exe .= "CISO</td></tr></table>";
                
                
                 
                
                
                
            }    
            //echo "<pre>cfo_exe_arr:";   print_r($cfo_exe_arr);   echo "</pre>";
            
            //echo "<br>cfo_exe: ".$cfo_exe;
            return $cfo_exe;
        }
        
        
        if($site_name == 'cfo')
        {    
            $cfo = mysql_connect("10.132.233.66","cfo2","cV!kJ201Ze",TRUE) or die("Database ERROR ");
            mysql_select_db("cfo2",$cfo) or die ("ERROR: Database not found ");

            $exeCfoResult = mysql_query("SELECT mm.personal_id,pm.first_name,pm.last_name,pm.add_to_funding
            FROM cfo_company_master AS cm, 
            cfo_movement_master AS mm, 
            cfo_personal_master AS pm
            WHERE (cm.company_id = mm.company_id AND pm.personal_id = mm.personal_id)
            AND cm.company_id =".$company_id_for_executives." group by personal_id",$cfo);
            
            $numExec = com_db_num_rows($exeCfoResult);
            $cfo_exe = "";
            if($numExec > 0)
            {
                $cfo_exe .= "<table style=text-align:right;padding-right:150px;width:100%;><tr><td><select name=cfo_funding_exe id=cfo_funding_exe onchange=check_selection()>";
                $cfo_exe .= "<option>Select Funding Person</option>";
                while($exeCfoRow = mysql_fetch_array($exeCfoResult))
                {
                    //echo "<pre>personalRow: ";   print_r($personalRow);   echo "</pre>";
                    $hr_personal_id = $exeCfoRow['personal_id'];  
                    $hr_first_name = $exeCfoRow['first_name'];  
                    $hr_last_name = $exeCfoRow['last_name'];  
                    $add_to_funding = $exeCfoRow['add_to_funding'];  
                    $funding_selected = ""; 
                    if($add_to_funding == 1)
                           $funding_selected = "selected"; 
                    //$cfo_exe_arr[$hr_personal_id] = $hr_first_name." ".$hr_last_name;
                    $cfo_exe .= "<option ".$funding_selected." value=".$hr_personal_id.">".$hr_first_name." ".$hr_last_name."</option>";
                }
                $cfo_exe .= "</select></td><td style=width:45px;>";
                $cfo_exe .= "CFO</td></tr></table>";
            }    
            //echo "<pre>cfo_exe_arr:";   print_r($cfo_exe_arr);   echo "</pre>";
            mysql_close($cfo);
            //echo "<br>cfo_exe: ".$cfo_exe;
            return $cfo_exe;
        }
        
        
        if($site_name == 'clo') // still untested
        {    
            //$clo = mysql_connect("10.132.233.67","clo2","dtBO#7310",TRUE) or die("Database ERROR LOCAL");
            //mysql_select_db("clo2",$clo) or die ("ERROR: Database not found ");
            
            $clo = mysql_connect("10.132.233.67","clo2","dtBO#7310",TRUE) or die("Database ERROR".mysql_error());
            mysql_select_db("clo2",$clo) or die ("ERROR: Database not found ");
            
            

            $exeCfoResult = mysql_query("SELECT mm.personal_id,pm.first_name,pm.last_name,pm.add_to_funding
            FROM clo_company_master AS cm, 
            clo_movement_master AS mm, 
            clo_personal_master AS pm
            WHERE (cm.company_id = mm.company_id AND pm.personal_id = mm.personal_id)
            AND cm.company_id =".$company_id_for_executives." group by personal_id",$clo);
            
            
            
            $numExec = com_db_num_rows($exeCfoResult);
            $cfo_exe = "";
            //echo "<br>numExec:" . $numExec;
            if($numExec > 0)
            {
                $cfo_exe .= "<table style=text-align:right;padding-right:150px;width:100%;><tr><td><select name=clo_funding_exe id=clo_funding_exe onchange=check_selection()>";
                $cfo_exe .= "<option>Select Funding Person</option>";
                while($exeCfoRow = mysql_fetch_array($exeCfoResult))
                {
                    //echo "<pre>personalRow: ";   print_r($personalRow);   echo "</pre>";
                    $hr_personal_id = $exeCfoRow['personal_id'];  
                    $hr_first_name = $exeCfoRow['first_name'];  
                    $hr_last_name = $exeCfoRow['last_name'];  
                    $add_to_funding = $exeCfoRow['add_to_funding'];  
                    $funding_selected = ""; 
                    if($add_to_funding == 1)
                           $funding_selected = "selected"; 
                    //$cfo_exe_arr[$hr_personal_id] = $hr_first_name." ".$hr_last_name;
                    $cfo_exe .= "<option ".$funding_selected." value=".$hr_personal_id.">".$hr_first_name." ".$hr_last_name."</option>";
                }
                $cfo_exe .= "</select></td><td style=width:45px;>";
                $cfo_exe .= "CLO</td></tr></table>";
            }    
            //echo "<pre>cfo_exe_arr:";   print_r($cfo_exe_arr);   echo "</pre>";
            mysql_close($cfo);
            //echo "<br>cfo_exe: ".$cfo_exe;
            return $cfo_exe;
        }  
        
        
        
        if($site_name == 'cmo') // still untested
        {    
            $cmo = mysql_connect("10.132.232.238","cmo1","mocos!cm123",TRUE) or die("Database ERROR ");
            mysql_select_db("cmo1",$cmo) or die ("ERROR: Database not found ");

            $exeCfoResult = mysql_query("SELECT mm.personal_id,pm.first_name,pm.last_name,pm.add_to_funding
            FROM cmo_company_master AS cm, 
            cmo_movement_master AS mm, 
            cmo_personal_master AS pm
            WHERE (cm.company_id = mm.company_id AND pm.personal_id = mm.personal_id)
            AND cm.company_id =".$company_id_for_executives." group by personal_id",$cmo);
            
            $numExec = com_db_num_rows($exeCfoResult);
            $cfo_exe = "";
            if($numExec > 0)
            {
                $cfo_exe .= "<table style=text-align:right;padding-right:150px;width:100%;><tr><td><select name=cmo_funding_exe id=cmo_funding_exe onchange=check_selection()>";
                $cfo_exe .= "<option>Select Funding Person</option>";
                while($exeCfoRow = mysql_fetch_array($exeCfoResult))
                {
                    //echo "<pre>personalRow: ";   print_r($personalRow);   echo "</pre>";
                    $hr_personal_id = $exeCfoRow['personal_id'];  
                    $hr_first_name = $exeCfoRow['first_name'];  
                    $hr_last_name = $exeCfoRow['last_name'];  
                    $add_to_funding = $exeCfoRow['add_to_funding'];  
                    $funding_selected = ""; 
                    if($add_to_funding == 1)
                           $funding_selected = "selected"; 
                    //$cfo_exe_arr[$hr_personal_id] = $hr_first_name." ".$hr_last_name;
                    $cfo_exe .= "<option ".$funding_selected." value=".$hr_personal_id.">".$hr_first_name." ".$hr_last_name."</option>";
                }
                $cfo_exe .= "</select></td><td style=width:45px;>";
                $cfo_exe .= "CMO</td></tr></table>";
            }    
            //echo "<pre>cfo_exe_arr:";   print_r($cfo_exe_arr);   echo "</pre>";
            mysql_close($cfo);
            //echo "<br>cfo_exe: ".$cfo_exe;
            return $cfo_exe;
        } 
        
        
        if($site_name == 'hr')
        {    
            //$hr_exe_arr = array();
            //$hre = mysql_connect("10.132.225.160","hre2","htXP%th@71",TRUE) or die("Databasee ERROR:".mysql_error());
            //mysql_select_db("hre2",$hre) or die ("ERROR: Database not found ");
            
            $hre = mysql_connect("10.132.225.160","hre2","htXP%th@71",TRUE) or die("Databasee ERROR:".mysql_error());
            mysql_select_db("hre2",$hre) or die ("ERROR: Database not found ");

            $exeHreResult = mysql_query("SELECT mm.personal_id,pm.first_name,pm.last_name,pm.add_to_funding
            FROM hre_company_master AS cm, 
            hre_movement_master AS mm, 
            hre_personal_master AS pm
            WHERE (cm.company_id = mm.company_id AND pm.personal_id = mm.personal_id)
            AND cm.company_id =".$company_id_for_executives." group by personal_id",$hre);
            
            $numHreExec = com_db_num_rows($exeHreResult);
            $hre_exe = "";
            $funding_yes = 0;
            if($numHreExec > 0)
            {
                $hre_exe .= "<table style=text-align:right;padding-right:150px;width:100%;><tr><td><select name=hre_funding_exe id=hre_funding_exe onchange=check_selection()>";
                $hre_exe .= "<option>Select Funding Person</option>";
                while($exeCfoRow = mysql_fetch_array($exeHreResult))
                {
                    //echo "<pre>personalRow: ";   print_r($personalRow);   echo "</pre>";
                    $hr_personal_id = $exeCfoRow['personal_id'];  
                    $hr_first_name = $exeCfoRow['first_name'];  
                    $hr_last_name = $exeCfoRow['last_name'];  
                    $add_to_funding = $exeCfoRow['add_to_funding'];  
                    $funding_selected = ""; 
                    if($add_to_funding == 1)
                    {
                        $funding_yes = 1;
                        $funding_selected = "selected"; 
                    }       
                    //$cfo_exe_arr[$hr_personal_id] = $hr_first_name." ".$hr_last_name;
                    $hre_exe .= "<option ".$funding_selected." value=".$hr_personal_id.">".$hr_first_name." ".$hr_last_name."</option>";
                }
                $hre_exe .= "</select></td><td style=width:45px;>";
                $hre_exe .= "HR</td></tr></table>";
                
                if($funding_yes == 1)
                {
                    com_db_connect() or die('Unable to connect to database server!');
                    $chk_q = "SELECT * from ".TABLE_COMPANY_WEBSITES." where company_id = $company_id_for_executives and website = 'HR'";
                    //echo "<br>chk_q: ".$chk_q;
                    $checkWebsite = mysql_query($chk_q);
                    $numComp = com_db_num_rows($checkWebsite);
                    //echo "<br>numComp: ".$numComp;
                    if($numComp == 0)
                    {
                        $findingComp_q = "SELECT * from ".TABLE_COMPANY_FUNDING." where company_id = $company_id_for_executives";
                        //echo "<br>findingComp_q: ".$findingComp_q;
                        $checkfindingComp = mysql_query($findingComp_q);
                        $getComp = com_db_num_rows($checkfindingComp);
                        //echo "<br>getComp: ".$getComp;
                        if($getComp > 0)
                        {
                            $compRow = mysql_fetch_array($checkfindingComp);
                            $funding_id = $compRow['funding_id'];
                            
                            $stopDup_q = "SELECT * from ".TABLE_COMPANY_FUNDING_WEBSITE." where company_id = $company_id_for_executives and website='HR' and funding_id=$funding_id";
                            //echo "<br>stopDup_q: ".$stopDup_q;
                            $dupComp = mysql_query($stopDup_q);
                            $dupCount = com_db_num_rows($dupComp);
                            //echo "<br>dupCount: ".$dupCount;
                            if($dupCount == 0)
                            {    
                                $insComp = "INSERT into ".TABLE_COMPANY_FUNDING_WEBSITE."(company_id,website,funding_id) VALUES('$company_id_for_executives','HR',$funding_id)";
                                //echo "<br>insComp: ".$insComp;
                                $addinghr = mysql_query($insComp);
                            }    
                        }    
                    }
                }
                
                
            }    
            //echo "<pre>cfo_exe_arr:";   print_r($cfo_exe_arr);   echo "</pre>";
            mysql_close($hre);
            //echo "<br>cfo_exe: ".$cfo_exe;
            return $hre_exe;
            
            
            
            
            
        }    
            
    }
    
    
    
 /*   
    function get_converted_status($pattern_for_type,$first_name = '',$last_name='',$title = '',$company_name='',$type = '',$more_link='',$publication = '',$speaking_event= '')
{
    //echo "<br><br>Within function entered_pattern: ".$entered_pattern;
    
    
    $get_pattern_query ="select * from " . TABLE_BUFFER_PATTERN . " where status_type = '" . $pattern_for_type . "'"; 
    $get_pattern_result = com_db_query($get_pattern_query);
    $get_pattern_row=com_db_fetch_array($get_pattern_result);
    $status_pattern= $get_pattern_row['status_pattern'];
    //echo "<br>DB Status pattern: ".$status_pattern; 
    //echo "<br>more_link: ".$more_link; 
    
    
    $appointment_pattern_arr = explode(" ",$status_pattern);
    //echo "<pre>appointment_pattern_arr: ";   print_r($appointment_pattern_arr);   echo "</pre>";
    
    //$first_name = "far";
    //$last_name = "ch";
    $converted_status = "";
    //$title = "Chief officer";
    //$company_name = "Pepsi";
    if($type == 1)
        $type = "appointed";
    elseif($type == 2)
        $type = "promoted";
    foreach($appointment_pattern_arr as $index => $value)
    {
        //echo "<br>value: ".$value; 
        if(strpos($value,"*") > -1)
        {
            $exact_db_val = substr($value,1,strlen($value)-2);
            $exact_db_val = strtolower($exact_db_val);

            //echo "<br>exact_db_val: ".$exact_db_val;

            if($exact_db_val == 'first_name')
            {
                $converted_status .= $first_name." ";
            }
            elseif($exact_db_val == 'last_name')
            {
                $converted_status .= $last_name." ";
            }
            elseif($exact_db_val == 'title')
            {
                $converted_status .= $title." ";
            }
            elseif($exact_db_val == 'company')
            {
                $converted_status .= $company_name." ";
            }
            elseif($exact_db_val == 'type')
            {
                $converted_status .= $type." ";
            }
            elseif($exact_db_val == 'source')
            {
                $converted_status .= $more_link." ";
            }
            elseif($exact_db_val == 'publication')
            {
                $converted_status .= $publication." ";
            }
            elseif($exact_db_val == 'award')
            {
                $converted_status .= $publication." ";
            }
            elseif($exact_db_val == 'event')
            {
                $converted_status .= $speaking_event." ";
            }
            //elseif($exact_db_val == 'source')
            //{
            //    $converted_status .= ."<a href=>"$type." ";
            //}
        }   
        else
        {
            $converted_status .= $value." ";
        }
        //echo "<br>Converted Appointment status: ".$converted_status;    

    }    
    //$converted_status .= "http://www.faraztestc.com";
    
    return $converted_status;
}
*/    
    
					
?>
