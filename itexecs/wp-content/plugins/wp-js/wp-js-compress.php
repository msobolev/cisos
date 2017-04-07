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

include_once('wp-js-functions.php');

if( isset($_GET['f']) ) {
	
	$wp_js['file'] = $_GET['f'];
	$wp_js['file_array'] = explode(',', trim($_GET['f']));
	$wp_js['count'] = count($wp_js['file']);
	
	if ($wp_js['settings'] = wp_js_setting()) {
		$wp_js['url'] = $wp_js['settings']['u'].'/';
		$wp_js['path'] = $wp_js['settings']['p'].'/';
		$wp_js['cache'] = $wp_js['settings']['c'];
	} else {
		$wp_js['url'] = wp_js_decode_string($_GET['u']).'/';
		$wp_js['path'] = wp_js_decode_string($_GET['p']).'/';
		$wp_js['cache'] = wp_js_decode_string($_GET['c']);
	}
	
	if(extension_loaded('zlib') && substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')){
		ob_start('ob_gzhandler');
		header('Content-Encoding: gzip');
	} else {
		ob_start();
	}
	
	header("Content-type: text/javascript; charset: UTF-8");
	header("Cache-Control: max-age=".$wp_js['cache']);
	header("Expires: " .gmdate("D, d M Y H:i:s", time() + $wp_js['cache']) . " GMT");
	
	if (!wp_js_is_expired($wp_js['file']) && @file_exists('cache/'.wp_js_filename($wp_js['file']))) {
			include('cache/'.wp_js_filename($wp_js['file']));
	 } else {
		ob_start("wp_js_clean");

		foreach ($wp_js['file_array'] as $filename) {
			
			if (eregi('wp\-config\.php', $filename)) exit;
			
			if(@file_exists($wp_js['path'].trim($filename))) { 
				include($wp_js['path'].trim($filename));
			} else {
				echo('File:'.__FILE__.'<br/>');
				echo("File not found: ".$filename);
			}
		}

		ob_end_flush();
	 }
	ob_end_flush();
	exit(); 
}

function wp_js_clean($buffer) {
	global $wp_js;
	
	require_once('jsmin.php');
	
	$buffer = jsmin($buffer);
	
	if (wp_js_is_directory_writable('cache')) {
		wp_js_create_file(wp_js_filename($wp_js['file']), $buffer);
		wp_js_create_file(wp_js_filename($wp_js['file'], '.txt'), serialize($wp_js['file_array']));
	}

	
	return $buffer;
}

?>