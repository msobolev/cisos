<?php
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
##================= Email Function :: End================##

/**********  Pagination *********************/
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
?>