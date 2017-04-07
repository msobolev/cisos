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

// Redirect to another page or site
  function com_redirect($url) {
	  header('Location: ' . $url);
      exit;
  }

////
// Returns an array with countries
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
  
  
function com_get_state_name($state_id) 
{
    //echo "<br>State Q: select state_name from " . TABLE_STATE . " where state_id = '" . (int)$state_id . "'";
    $state_query = mysql_query("select state_name from " . TABLE_STATE . " where state_id = '" . (int)$state_id . "'");

    if (mysql_num_rows($state_query) > 0) 
    {
        $state = mysql_fetch_array($state_query);
        return $state['state_name'];
    }
}
  

function com_get_employee($employee_id) 
{
    //echo "<br>State Q: select state_name from " . TABLE_STATE . " where state_id = '" . (int)$state_id . "'";
    $emp_query = mysql_query("select name from " . TABLE_EMPLOYEE_SIZE . " where id = '" . (int)$employee_id . "'");

    if (mysql_num_rows($emp_query) > 0) 
    {
        $emp = mysql_fetch_array($emp_query);
        return $emp['name'];
    }
}

function com_get_revenue($revenue_id) 
{
    //echo "<br>State Q: select state_name from " . TABLE_STATE . " where state_id = '" . (int)$state_id . "'";
    $rev_query = mysql_query("select name from " . TABLE_REVENUE_SIZE . " where id = '" . (int)$revenue_id . "'");

    if (mysql_num_rows($rev_query) > 0) 
    {
        $rev = mysql_fetch_array($rev_query);
        return $rev['name'];
    }
}

function com_get_industry($industry_id) 
{
    //echo "<br>State Q: select state_name from " . TABLE_STATE . " where state_id = '" . (int)$state_id . "'";
    $ind_query = mysql_query("select title from " . TABLE_INDUSTRY . " where industry_id = '" . (int)$industry_id . "'");

    if (mysql_num_rows($ind_query) > 0) 
    {
        $ind = mysql_fetch_array($ind_query);
        return $ind['title'];
    }
}


  
 function com_get_company_sizes($default = '') {
    $company_sizes_array = array();
    if ($default) {
      $company_sizes_array[] = array('id' => '',
                                 'name' => $default);
    }
    $company_sizes_query = mysql_query("select id, name from " . TABLE_EMPLOYEE_SIZE . " order by name");
    while ($company_sizes = mysql_fetch_array($company_sizes_query)) {
      $company_sizes_array[] = array('id' => $company_sizes['id'],
                                 'name' => $company_sizes['name']);
    }

    return $company_sizes_array;
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
			
			
			$get_img = '<img src="'. $path .'" border="0" width="' . $img_width . '" height="' . $img_height . '" ' . $extra .  ' >';  
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
	
	
	$output = "";
	if ($total_pages > 1) {
		if($page_now > 1)
		{
			//$output.="Page [<a href='".$main_page."?p=1".$extra."'>1</a>] &nbsp;&nbsp;";
			
			$output.="<td align='center' valign='middle' class='pagination-next-prev-text'><strong><a href='".$main_page."?p=".($page_now-1).$extra."'>&lt;&lt;Prev</a></strong></td>";
			
			//$output.="<a href='".$main_page."?p=".($page_now-1).$extra."'>&laquo; Prev</a> &nbsp;&nbsp;";
		} else {
			//$output.="<font class=pagelink>Page [1]  &nbsp;&nbsp; &laquo; prev &nbsp;&nbsp;</font>";
			$output.="<td align='center' valign='middle' class='pagination-next-prev-text'><strong>&lt;&lt;Prev</a></strong></td>";
			
			
		}
		for($i=$low_page;$i<=$high_page;$i++) {
			if($i==$page_now)
			{
				$output.="<td width='15' align='center' valign='middle' class='pagination-text'><a href='#' class='active'>" . $i . "</a></td>";
			} else {
				if($i > $total_pages) {
					$output .= " ".$i." |";
				} else {
					//$output.=" <a href='".$main_page."?p=".$i.$extra."' class=pagelink>".$i."</a> |";
					$output.="<td width='15' align='center' valign='middle' class='pagination-text'><a href='".$main_page."?p=".$i.$extra."'>".$i."</a></td>";
				}
			}
		}
		//$output= substr($output,0, -1);
		if($page_now<$total_pages)
		{
			
			$output.="<td align='center' valign='middle' class='pagination-next-prev-text'><strong><a href='".$main_page."?p=".($page_now+1).$extra."'>Next&gt;&gt;</a></strong></td>";
			//$output.="&nbsp;&nbsp; <a href='".$main_page."?p=".($page_now+1).$extra."'> Next &raquo;</a> ";
			//$output.= "&nbsp;&nbsp; <a href='".$main_page."?p=".$total_pages.$extra."'>[$total_pages]</a>";
		} else {
			//$output.="&nbsp;&nbsp; Next &raquo; &nbsp;&nbsp; [$total_pages]";
			
			$output.="<td align='center' valign='middle' class='pagination-next-prev-text'><strong>Next&gt;&gt;</strong></td>";
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

		if($page_now>1){
			$output.="<a href='".$main_page."?p=".($page_now-1).$extra."' class='prevnext'>� previous</a>";
		}
		for($i=$low_page;$i<=$high_page;$i++) {
			if($i==$page_now)
			{	
				if($high_page==$i){
					$output.='<a href="#" class="active">' . $i . '</a>';
				}else{
					$output.='<a href="#" class="active">' . $i . '</a>|';
				}	
			} else {
				if($high_page==$i){
					$output.="<a href='".$main_page."?p=".$i.$extra."'>".$i."</a>";
				}else{
					$output.="<a href='".$main_page."?p=".$i.$extra."'>".$i."</a>|";
				}	
			}
		}
		if($page_now<$total_pages)
		{
			$output.="<a href='".$main_page."?p=".($page_now+1).$extra."'  class='prevnext'>next �</a>";
		}
		
		return $output;
	} 
}

/**************** Pagination ***************/	


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

function selectComboBox($sql,$selected_id,$type = ''){
	$exe_query = com_db_query($sql);
	while($data_sql = com_db_fetch_row($exe_query)){
		if($selected_id == $data_sql[0]){
			$selected_str = ' selected="selected"';
		}else{
			$selected_str = '';
		}
		
		
		if($type == 'email_pattern')
		{
			$show_format = "";
			if($data_sql[0] == 1)
				$show_format = "1 - JDoe@domain.com";
			elseif($data_sql[0] == 2)
				$show_format = "2 - John.Doe@domain.com";
			elseif($data_sql[0] == 3)
				$show_format = "3 - John@domain.com";
			elseif($data_sql[0] == 4)
				$show_format = "4 - JohnD@domain.com";
			elseif($data_sql[0] == 5)
				$show_format = "5 - John_Doe@domain.com";	
			elseif($data_sql[0] == 6)
				$show_format = "6 - Doe@domain.com";	
			elseif($data_sql[0] == 7)
				$show_format = "7 - JohnDoe@domain.com";	
			elseif($data_sql[0] == 8)
				$show_format = "8 - DoeJ@domain.com";	
			elseif($data_sql[0] == 9)
				$show_format = "9 - J.Doe@domain.com";	
			elseif($data_sql[0] == 10)
				$show_format = "10 - Doe.John@domain.com";			
			elseif($data_sql[0] == 11)
				$show_format = "11 - DJohn@domain.com";	
			elseif($data_sql[0] == 12)
				$show_format = "12 - John-Doe@domain.com";	
			elseif($data_sql[0] == 13)
				$show_format = "13 - JohnMDoe@domain.com";	
			elseif($data_sql[0] == 14)
				$show_format = "14 - JohnDo@domain.com";	
			elseif($data_sql[0] == 15)
				$show_format = "15 - JohnDoe@domain.com";	
			elseif($data_sql[0] == 16)
				$show_format = "16 - JohnDoe@domain.com";	
			elseif($data_sql[0] == 17)
				$show_format = "17 - JohnDoe@domain.com";	
			elseif($data_sql[0] == 18)
				$show_format = "18 - JohnDoe@domain.com";	
			elseif($data_sql[0] == 19)
				$show_format = "19 - JohnDoe@domain.com";	
			elseif($data_sql[0] == 20)
				$show_format = "20 - Doe_John@domain.com";			
			elseif($data_sql[0] == 21)
				$show_format = "21 - John.M.Doe@domain.com";			
			elseif($data_sql[0] == 22)
				$show_format = "22 - John_M_Doe@domain.com";			
			elseif($data_sql[0] == 23)
				$show_format = "23 - Doe.J@domain.com";			
			elseif($data_sql[0] == 24)
				$show_format = "24 - Doe_John@domain.com";			
			elseif($data_sql[0] == 25)
				$show_format = "25 - J_Doe@domain.com";			
			elseif($data_sql[0] == 26)
				$show_format = "26 - JD@domain.com";				
			elseif($data_sql[0] == 27)
				$show_format = "27 - JMD@domain.com";			
			$all_option .= '<option value="'.$data_sql[0].'" '.$selected_str.'>'.$show_format.'</option>' . "\r\n";	
		}
		else	
			$all_option .= '<option value="'.$data_sql[0].'" '.$selected_str.'>'.$data_sql[1].'</option>' . "\r\n";
		
		//$all_option .= '<option value="'.$data_sql[0].'" '.$selected_str.'>'.$data_sql[0].'</option>' . "\r\n";
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

//for backup
function com_set_time_limit($limit) {
    if (!get_cfg_var('safe_mode')) {
      set_time_limit($limit);
    }
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
 function com_session_close() {
    if (PHP_VERSION >= '4.0.4') {
      return session_write_close();
    } elseif (function_exists('session_close')) {
      return session_close();
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
 // Category & Subcategory Show
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
		$nav_query = com_db_query("SELECT * FROM " . TABLE_CATEGORIES . " ORDER BY categories_id");
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
			
			$child_query = com_db_query("SELECT * FROM `" . TABLE_CATEGORIES . "` WHERE parent_id=" . $oldID);
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
		
		
		
		function mail_server_settings_ComboBox($selected_val = '',$comboWidth = '')
	{
		if($selected_val == '')
			$selected_val = 'none';
	$all_option = "";
	$all_option .= '<select name=mail_server_settings id=mail_server_settings style=width:'.$comboWidth.'>';
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
		
		
		
		
	function getImageXY( $image, $imgDimsMax=140 ) {
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
	return '<img src="' . $image . '" width="80" height="' . $imgHeight . '"  />';
}	
		

?>