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
	
	
	
	function generate_email_address($fn,$mn,$ln,$email_domain,$pattern)
	{
		//$email_domain = "gw.com";

		$first_name_initial = "";
		$middle_name_initial = "";
		$last_name_initial = "";
		$generated_email = "";
		//$fn = "faraz";
		//$mn = "Ch";
		//$ln = "aleem";
		//$pattern = $_GET['p'];
		
		if($pattern == 1 || $pattern == 9 ||  $pattern == 10 || $pattern == 12 || $pattern == 14 || $pattern == 15 || $pattern == 16 || $pattern == 17 || $pattern == 18 || $pattern == 19 || $pattern == 20 || $pattern == 24 || $pattern == 26 || $pattern == 27 || $pattern == 28)
		//if(strpos($pattern,'First name initial') > -1 )
		{
			$first_name_initial = substr($fn, 0, 1);
			
		}
		if($pattern == 5 || $pattern == 12 ||  $pattern == 27 || $pattern == 28)
		//if(strpos($pattern,'initial of last name') > -1)
		{
			$last_name_initial = substr($ln, 0, 1);
			
		}

		if($pattern == 14 || $pattern == 22 ||  $pattern == 23 || $pattern == 28)
		//if(strpos($pattern,'middle name initial') > -1)
		{
			$middle_name_initial = substr($mn, 0, 1);
			
		}



		if($pattern == 1)
		{
			$generated_email = $first_name_initial.$ln;
		}
		elseif($pattern == 2)
		{
			$generated_email = $fn.".".$ln;
		}
		elseif($pattern == 3)
		{
			$generated_email = $fn;
		}
		elseif($pattern == 4)
		{
			$generated_email = $fn.$last_name_initial;
		}
		elseif($pattern == 5)
		{
			$generated_email = $fn."_".$ln;
		}
		elseif($pattern == 6)
		{
			$generated_email = $ln;
		}
		elseif($pattern == 7)
		{
			$generated_email = $fn.$ln;
		}
		elseif($pattern == 8)
		{
			$generated_email = $ln.$first_name_initial;
		}
		elseif($pattern == 9)
		{
			$generated_email =  $first_name_initial.".".$ln;
		}
		elseif($pattern == 10)
		{
			$generated_email = $ln.".".$fn;
		}
		elseif($pattern == 11)
		{
			$generated_email = $last_name_initial.$fn;
		}
		elseif($pattern == 12)
		{
			$generated_email = $fn."-".$ln;
		}
		elseif($pattern == 13) // seems wrong in xls
		{
			$generated_email = $first_name_initial.$first_name_initial.$ln;
		}
		elseif($pattern == 14)
		{
			$generated_email = $first_name_initial.substr($fn, 0, 2);
		}
		elseif($pattern == 15)
		{
			$generated_email = $first_name_initial.substr($fn, 0, 5);
		}
		elseif($pattern == 16)
		{
			$generated_email = $first_name_initial.substr($fn, 0, 4);
		}
		elseif($pattern == 17)
		{
			$generated_email = $first_name_initial.substr($fn, 0, 3);
		}
		elseif($pattern == 18)
		{
			$generated_email = $first_name_initial.substr($fn, 0, 7);
		}
		elseif($pattern == 19)
		{
			$generated_email = $first_name_initial.substr($fn, 0, 6);
		}
		elseif($pattern == 20)
		{
			$generated_email = $ln."_".$fn;
		}
		elseif($pattern == 21)
		{
			$generated_email = $fn.".".$middle_name_initial.".".$ln;
		}
		elseif($pattern == 22)
		{
			$generated_email = $fn."_".$middle_name_initial."_".$ln;
		}
		elseif($pattern == 23)
		{
			$generated_email = $ln.".".$first_name_initial;
		}
		elseif($pattern == 24)
		{
			$generated_email = $ln."_".substr($fn, 0, 2);
		}
		elseif($pattern == 25)
		{
			$generated_email =  $first_name_initial."_".$ln;
		}
		elseif($pattern == 26)
		{
			$generated_email = $first_name_initial.$last_name_initial;
		}
		elseif($pattern == 27)
		{
			$generated_email = $first_name_initial.$middle_name_initial.$last_name_initial;
		}

		$complete_email_address = $generated_email."@".$email_domain;
		$complete_email_address = trim($complete_email_address);
		//echo $complete_email_address;
		return $complete_email_address;
		
		
		
		
	}
	
	
	function validate_email_address($email_to_check,$first_name='',$middle_name='',$last_name='',$email_domain='',$email_pattern='',$company_website='',$email_pattern_id='')
	{
		//open connection
		$ch = curl_init();

		$url = "https://api.datavalidation.com/1.0/rt/".$email_to_check."/?pretty=true";

		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, $url);
	
		//$headr[] = "Authorization:bearer 044a15fe3c511d8af236b21229e17550";
		//$headr[] = "Authorization:bearer 65378a7477ed556bc4489ab286b6237d";
		//$headr[] = "Authorization:bearer cfbbf1b65d1b8abf4fccbed1112c03db";
                //$headr[] = "Authorization:bearer 3f1bd3e74c0e2a661bc6e580e925234a";
                
                $headr[] = "Authorization:bearer 00d1ed7238b2d915738925c3688893ba";
		

		//curl_setopt($ch, CURLOPT_HEADER, "1");
		curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		//execute post
		$result = curl_exec($ch);

		//close connection
		curl_close($ch);

		$email_verified_details = json_decode($result);

		//echo "<pre>email_verified_details: ";	print_r($email_verified_details);	echo "</pre>";
		
		$at_pos = strpos($email_to_check, '@');
		$at_pos = $at_pos+1;
		$only_email_domain = substr($email_to_check,$at_pos,strlen($email_to_check));
		
		
		//echo "<br><br>first_name: ".$first_name;
		//echo "<br>middle_name: ".$middle_name;
		//echo "<br>last_name: ".$last_name;
		//echo "<br>email_domain: ".$email_domain;
		//echo "<br>email_to_check: ".$email_to_check;
		
		$new_pattern_id = getting_email_pattern($first_name,$middle_name,$last_name,$email_domain,$email_to_check);
		
		//echo "<br>new_pattern_id: ".$new_pattern_id;
		//return;
		$this_company_id = '';
		$this_company_pattern_id = '';
		$company_info_query = "select company_id,email_pattern_id from " . TABLE_COMPANY_MASTER . " where company_website = '".$company_website."'";
		
		$company_info_result = com_db_query($company_info_query);
		while($company_info_row = com_db_fetch_array($company_info_result)) 
		{
			$this_company_id 			= $company_info_row['company_id'];
			$this_company_pattern_id 	= $company_info_row['email_pattern_id'];
		}
		
		//echo "<br>Grade: ".$email_verified_details->grade; 
		
		if($this_company_pattern_id > 0) // email pattern exists
		{
			if($email_verified_details->grade == 'A+' || $email_verified_details->grade == 'A')
			{
				com_db_query("INSERT into ".TABLE_COMPANY_EMAIL_PATTERN_HISTORY."(company_id,email_pattern_id,result,add_date) values('".$this_company_id."','".$new_pattern_id."','".$email_verified_details->grade."','".date("Y-m-d:H:i:s")."')");	
				$email_verified_result = date("m/d/Y")." - valid";
			}
			elseif($email_verified_details->grade == 'F')
			{
                            $email_verified_result = date("m/d/Y")." - invalid";
			}
			elseif($email_verified_details->grade == 'B') // Accept-All case
			{
				$upd_query = "UPDATE " . TABLE_COMPANY_MASTER." SET mail_server_settings = 'accept all' where email_domain = '".$only_email_domain."'";
				$upd_result = com_db_query($upd_query);
				$email_verified_result = date("m/d/Y")." - accept all";
				//echo "<br>email_verified_result: ".$email_verified_result; 
			}
			elseif($email_verified_details->grade == 'D') // Unknown
			{
				$email_verified_result = date("m/d/Y")." - unknown";
				/*				
				$email_response = sending_executive_email($email_to_check,'');
				if($email_response == 1)
					$email_verified_result = date("m/d/Y")." - unknown.Executive Email Send";
				else	
					$email_verified_result = date("m/d/Y")." - unknown.Error in Executive Email";
				*/	
			}
			
		}
		elseif($this_company_pattern_id == 0) // No primary pattern exists
		{
			if($email_verified_details->grade == 'A+' || $email_verified_details->grade == 'A')
			{
				$email_verified_result = date("m/d/Y")." - valid";
				if($new_pattern_id != '')
                                {    
                                    $upd_pattern_query = "UPDATE " . TABLE_COMPANY_MASTER." SET email_pattern_id = $new_pattern_id where company_website = '".$company_website."'";
                                    $upd_pattern_result = com_db_query($upd_pattern_query);
                                }
				
			}	
			elseif($email_verified_details->grade == 'F')
			{
                            
                            $upd_query = "UPDATE " . TABLE_COMPANY_MASTER." SET mail_server_settings = 'open' where company_website = '".$company_website."'";
                            //echo "<br>upd_query: ".$upd_query;
                            $upd_result = com_db_query($upd_query);
                            $email_verified_result = date("m/d/Y")." - invalid";
			}
			elseif($email_verified_details->grade == 'B') // Accept-All case
			{
				$upd_query = "UPDATE " . TABLE_COMPANY_MASTER." SET mail_server_settings = 'accept all' where email_domain = '".$only_email_domain."'";
				$upd_result = com_db_query($upd_query);
				$email_verified_result = date("m/d/Y")." - accept all";
				
				
				
			}
			elseif($email_verified_details->grade == 'D')
			{
				$email_verified_result = date("m/d/Y")." - unknown";
			}
			else	
				$email_verified_result = date("m/d/Y")." - undeliverable";
		}
		//echo "<br>email_verified_result: ".$email_verified_result."<br>";
		//return;
		echo $email_verified_result;
	}
	
	// This function is called through ajax
	function mail_server_settings_ComboBox($selected_val = '',$comboWidth = '',$select_opt = '')
	{
		if($selected_val == '')
			$selected_val = 'none';
	$all_option = "";
	$all_option .= '<select name=mail_server_settings id=mail_server_settings '.$select_opt.' style=width:'.$comboWidth.'>';
	if($selected_val == 'accept all')
		$this_selected = "selected";
	else	
		$this_selected = "";
	$all_option .= "<option ".$this_selected." value='accept all'>Accept All</option>";
	
	if($selected_val == 'open')
		$this_selected = "selected";
	else	
		$this_selected = "";
	$all_option .= '<option '.$this_selected .' value=open>Open</option>';
	
	if($selected_val == 'unknown')
		$this_selected = "selected";
	else	
		$this_selected = "";
	$all_option .= '<option '.$this_selected .' value=unknown>Unknown</option>';
	
	if($selected_val == 'none')
		$this_selected = "selected";
	else	
		$this_selected = "";
	$all_option .= '<option '.$this_selected .' value=none>None</option>';
	$all_option .= '</select>';
	return $all_option;
	}
	
	
	function getting_email_pattern($fn,$mn,$ln,$e_domain,$c_email)
	{
		//$fn = "faraz";
		//$mn = "haf";
		//$ln = "aleem";
		//$e_domain = "@nxb.com.pk";
		//$c_email = $_GET['email'];//"faraz.aleem@nxb.com.pk";
		
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
	
	
	function sending_executive_email($to, $full_name='')
	{

		$email_details = "";
		$full_name = "";
		$sql_query = "select * from " . TABLE_EXECUTIVE_DEMO_EMAIL_INFO." order by add_date desc LIMIT 0,1";
		$exe_data = com_db_query($sql_query);

		$numRows = com_db_num_rows($exe_data);
		//echo "<br>numRows: ".$numRows;
		if($numRows > 0)
		{
			while ($data_sql = com_db_fetch_array($exe_data)) 
			{
				$add_date 		= $data_sql['add_date'];
				$email_details 	= $data_sql['email_details'];
			}
		}
		//echo "<br>email_details: ".$email_details;
		require_once('../PHPMailer/class.phpmailer.php');
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

		$subject = "Executive Email";	
		$mail->Subject       = $subject;

		//$emailContent = $message; 
		//echo "<br>to: ".$to;
		$mail->MsgHTML($email_details);
		$mail->AddAddress($to, $full_name);

		if(!$mail->Send()) 
		{
		//	$str_error ="Mailer Error (" . str_replace("@", "&#64;", $email) . ') ' . $mail->ErrorInfo;
			$res = 1;
		}
		else
		{
		//	echo "<br><br>Email send";
			$res = 0;
		}
		return $res;
	}
	

        
        
  function getSiteUsers($comp_url)
  {
     // $comp_url = $_GET['comp_url'];
    
    $compQuery = "select company_id,email_domain from ".TABLE_COMPANY_MASTER." where company_website ='".$comp_url."'";
    //echo "<br>compQuery: ".$compQuery;	
    $compResult = com_db_query($compQuery);
    $compRow = com_db_fetch_array($compResult);
    $company_id = com_db_output($compRow['company_id']);
    $email_domain = com_db_output($compRow['email_domain']);

    //echo "<br>company_id: ".$company_id;
    //echo "<br>email_domain: ".$email_domain;

    $matched_val = "";
    if($email_domain != '')
        $matched_val = "@".$email_domain;
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
    
    //echo "<br><br>select personal_id,first_name,last_name,add_to_funding from hre_personal_master where email like '%".$matched_val."%' and personal_image != '' and email != ''";
    
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
        
  
  

  
  
	
?>