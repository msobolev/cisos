<?php
/*
Copyright (C) 2008 Halmat Ferello

Released under the GPL v.2, http://www.gnu.org/copyleft/gpl.html

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/

global $wp_js;

/* thanks to italianstyle */
if (defined('ABSPATH') && file_exists(ABSPATH . 'wp-includes/pluggable.php')) {
    require_once(ABSPATH . 'wp-includes/pluggable.php');
}

function wp_js_encode_string($string)
{
	return urlencode(base64_encode($string));
}

function wp_js_decode_string($string)
{
	return base64_decode(urldecode($string));
}

function wp_js_is_expired($filename)
{
	global $wp_js;
	$filename = wp_js_filename($filename);
	if ( (mktime() - @filemtime('cache/'.$filename)) >= $wp_js['cache'] ) return TRUE;
	return FALSE;
}

function wp_js_filename($filename, $ext = '.js')
{
	return md5($filename).$ext;
}


function wp_js_create_file($filename, $string, $pre_path = null)
{
	$filename = $pre_path.'cache/'.$filename;
	
	if ( ! $fp = @fopen($filename, 'w+')) return false;
	
	flock($fp, LOCK_EX);
	fwrite($fp, $string);
	flock($fp, LOCK_UN);
	fclose($fp);
	
	// change file mode
    chmod($filename, 0755);

	return TRUE;
}

function wp_js_is_directory_writable($directory) {
	$filename = $directory . '/' . 'tmp_file_' . time();
	$fh = @fopen($filename, 'w');
	if (!$fh) {
		return false;
	}
	
	$written = fwrite($fh, "test");
	fclose($fh);
	unlink($filename);
	if ($written) {
		return true;
	} else {
		return false;
	}
}

function wp_js_activation($update = FALSE)
{
	if ($update == TRUE) {
		update_option('wp_js_activation', $_REQUEST['wp_js_activation']);
		$activation = get_option('wp_js_activation');
	} else if ( ! ($activation = get_option('wp_js_activation')) ) {
		$activation = 'on';
		add_option('wp_js_activation', $activation);
	} else {
		$activation = get_option('wp_js_activation');
	}
	return $activation;
}

function wp_js_within_posts_activation($update = FALSE)
{
	if ($update == TRUE) {
		update_option('wp_js_within_posts_activation', $_REQUEST['wp_js_within_posts_activation']);
		$activation = get_option('wp_js_within_posts_activation');
	} else if ( ! ($activation = get_option('wp_js_within_posts_activation')) ) {
		$activation = 'on';
		add_option('wp_js_within_posts_activation', $activation);
	} else {
		$activation = get_option('wp_js_within_posts_activation');
	}
	return $activation;
}

function wp_js_read_file($filename)
{	
	if ( !file_exists($filename) ) return FALSE;
	
	clearstatcache();
	
	if (filesize($filename) > 0) return file_get_contents($filename);
}

function wp_js_setting($array = null)
{
	if ($array)  {
		wp_js_create_file('wp-js-settings.txt', wp_js_encode_string(serialize($array)), ABSPATH.PLUGINDIR.'/wp-js/');
	} else {
		return unserialize(wp_js_decode_string(wp_js_read_file('cache/wp-js-settings.txt')));
	}
}

function wp_js_directory_map($dir, $needle = '.txt$', $top_level_only = TRUE)
{
	if ($handle = @opendir($dir)) {
		$array = array();
		while (false !== ($file = readdir($handle))) {
			
			if ( substr($file, 0, 1) != "." && $file != "Thumb.db") {
				if( is_dir($dir.$file) && $top_level_only === FALSE ) {
					$array[$file] = wp_js_directory_map($dir.$file."/", $needle, $top_level_only);
				} else if (eregi($needle, $file) && !eregi('wp-js-settings.txt', $file)) {
					$array[] = $file;
				}
			}
			
		}
		closedir($handle);
		
		foreach ($array as $key => $value) if (empty($value)) unset($array[$key]);
		
		return (!empty($array)) ? $array : null;
	}
	
	return FALSE;
}

function wp_js_delete($dir = WP_JS_CACHE_PATH) 
{
  if ($handle = opendir("$dir")) {
	
   while (false !== ($item = readdir($handle))) {
	
     if ($item != "." && $item != "..") {
	
       if (is_dir("$dir/$item")) {
         wp_js_delete("$dir/$item");
       } else {
         unlink("$dir/$item");
       } //else

     } //if

   } //while

   closedir($handle);

   //rmdir($dir);	
  } //if

}

function wp_js_cache_time()
{
	if( ! ($cache_time = get_option('wp_js_cache_time')) && !$_REQUEST['wp_js_edit_expiry'] ) {
		$cache_time = 3600;
		add_option('wp_js_cache_time', $cache_time);
	}
	return $cache_time;
}

function wp_js_modified_time($update = FALSE)
{
	if ($update == TRUE) {
		update_option('wp_js_modified_time', mktime());
	} else if( ! ($modified_time = get_option('wp_js_modified_time'))) {
		$modified_time = mktime();
		add_option('wp_js_modified_time', $modified_time);
	}
	return $modified_time;
}

?>