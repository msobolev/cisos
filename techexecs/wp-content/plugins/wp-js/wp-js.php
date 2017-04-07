<?php
/*
Plugin Name: WP JS
Plugin URI: http://www.halmatferello.com/lab/wp-js/
Description: Automatically GZIP your JS files and applies jsmin algorithm. Also add JavaScript files to specific posts/pages.
Author: Halmat Ferello
Author URI: http://www.halmatferello.com
Version: 2.0.6

Copyright (C) 2008 Halmat Ferello

Released under the GPL v.2, http://www.gnu.org/copyleft/gpl.html

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/

include_once('wp-js-functions.php');

define('WP_JS_VERSION', '2.0.6');
define('WP_JS_URL', get_option('siteurl').'/'.PLUGINDIR.'/wp-js');
define('WP_JS_PATH', ABSPATH.PLUGINDIR.'/wp-js');
define('WP_JS_CACHE_PATH', WP_JS_PATH.'/cache/');

define('TEMPLATEURL', get_theme_root_uri().'/'.get_stylesheet());

if ( !is_dir(WP_JS_CACHE_PATH) ) @mkdir(WP_JS_CACHE_PATH);

if (!defined('WP_ADMIN')) {
	wp_js_setting(array(
		'u' => TEMPLATEURL,
		'p' => get_theme_root().'/'.get_stylesheet(),
		'c' => wp_js_cache_time()
	));
}

function wp_js($file, $echo = true)
{
	if (!file_exists(WP_JS_CACHE_PATH.'wp-js-settings.txt')) {
		$url_array = array(
			'c' => wp_js_cache_time(),
			'u' => TEMPLATEURL,
			'p' => TEMPLATEPATH
		);
	}
	
	$wp_js_attributes = wp_js_url($url_array);
	
	if (wp_js_activation() == 'on') {
		$string = get_settings('siteurl') . '/wp-content/plugins/wp-js/wp-js-compress.php?f=' . $file. $wp_js_attributes . '&amp;t='.wp_js_modified_time();
	} else if (wp_js_activation() == 'off') {
		$string = TEMPLATEURL.'/' . $file;
	}
	
	if ($echo == true) {
		echo $string;
	} else {
		return $string;
	}
}

function wp_js_url($array)
{
	if (count($array) > 0) {
		$string = '';
		foreach ($array as $key => $value) {
			$string .= "&amp;".$key."=".wp_js_encode_string($value);
		}
		return $string;
	} else {
		return FALSE;
	}
}

function wp_js_file_structure()
{
	$js_files = wp_js_directory_map(WP_JS_CACHE_PATH);
	if (count($js_files) > 0 && !empty($js_files)) {
?>
<p>JavaScript files cached (/wp-content/themes/<?php echo get_stylesheet(); ?>):</p>
<ul>
		<?php foreach ($js_files as $file): ?>
		<?php
			$files_within_array = unserialize(file_get_contents(WP_JS_CACHE_PATH.$file));
		?>
			<li>
				<?php if (count($files_within_array) > 1): ?><strong>(Grouped)</strong>
					<ul>
						<?php foreach ($files_within_array as $js_file):?><li><?php echo $js_file; ?></li><?php endforeach ?>
					</ul>
				<?php else: ?>
					<?php foreach ($files_within_array as $js_file): echo $js_file;?><?php endforeach ?>
				<?php endif ?>
			</li>
		<?php endforeach ?>
</ul>
<?php
	} else {
		echo "<p><strong>No JavaScript files are cached.</strong></p>";
	}
}

function wp_js_admin()
{		
	if ($_REQUEST['wp_js_clear_cache']) {
		if (wp_js_is_directory_writable(WP_JS_CACHE_PATH)) {
			wp_js_delete();
		} else {
			$_REQUEST['wp_js_message'] = 'Unable to clear cache.';
		}
	}
	
	if ($_REQUEST['wp_js_edit_expiry']) {
		wp_js_modified_time(TRUE);
		update_option('wp_js_cache_time', $_REQUEST['wp_js_cache_time']);
	}
	if ($_REQUEST['wp_js_activation']) {
		wp_js_activation(true);
	}
	if ($_REQUEST['wp_js_within_posts_activation']) {
		wp_js_within_posts_activation(true);
	}
	
	$cache_time = wp_js_cache_time();

	?>
	
	<style type="text/css" media="screen">
		fieldset {
			border: 1px solid #aaa;
			padding: 12px;
		}
		fieldset#activate-within-posts, fieldset#expiry-time, fieldset#clear-cache {
			margin-top: 12px;
		}
	</style>
	
	<?php if ($_REQUEST['wp_js_message']) : ?>
		<div id="message" class="updated fade"><p><?php echo $_REQUEST['wp_js_message']; ?></p></div>
	<?php endif; ?>
	
	<div id="wp-js" class="wrap">
		<h2 style="margin: 8px 0; padding-top: 0">WP JS <?php echo WP_JS_VERSION; ?></h2>
		
		<p style="color:#1CCD00;">URLs must be relative to your current theme.<br />For example: <code>wp_js('file.js')</code> = <?php echo TEMPLATEURL; ?>/file.js</p>
		
		<fieldset id="activate"> 
		<legend>Activate</legend>
		<p>Turn the plugin on / off. wp_js() will still work but no caching or compressing is applied.</p>
		<?php
		echo '<form name="wp_js_active" action="'. $_SERVER["REQUEST_URI"] . '" method="post">';
		if (wp_js_activation() == 'on') {
			echo '<label for="wp_js_activation_on"><input type="radio" id="wp_js_activation_on" name="wp_js_activation" value="on" checked="checked" /> On</label>';
		} else {
			echo '<label for="wp_js_activation_on"><input type="radio" id="wp_js_activation_on" name="wp_js_activation" value="on" /> On</label>';
		}
		if (wp_js_activation() == 'off') {
			echo ' <label for="wp_js_activation_off"><input type="radio" name="wp_js_activation" id="wp_js_activation_off" value="off" checked="checked" /> Off</label><br />';
		} else {
			echo ' <label for="wp_js_activation_off"><input type="radio" name="wp_js_activation" id="wp_js_activation_off" value="off" /> Off</label><br />';
		}
		echo '<div class="submit"><input type="submit" value="Change activation &raquo;" name="wp_js_active" /></div>';
		echo '<input type="hidden" name="wp_js_message" value="Plugin activation changed.">';
		wp_nonce_field('wp-cache');
		echo "</form>\n";
		?></fieldset>
		
		
		<fieldset id="activate-within-posts">
		<legend>Activate within posts</legend>
		<p>Allows you to add JavaScript files to specific posts/pages.</p>
		<?php
		echo '<form name="wp_js_within_posts_activation" action="'. $_SERVER["REQUEST_URI"] . '" method="post">';
		if (wp_js_within_posts_activation() == 'on') {
			echo '<label for="wp_js_within_posts_activation_on"><input type="radio" id="wp_js_within_posts_activation_on" name="wp_js_within_posts_activation" value="on" checked="checked" /> On</label>';
		} else {
			echo '<label for="wp_js_within_posts_activation_on"><input type="radio" id="wp_js_within_posts_activation_on" name="wp_js_within_posts_activation" value="on" /> On</label>';
		}
		if (wp_js_within_posts_activation() == 'off') {
			echo ' <label for="wp_js_within_posts_activation_off"><input type="radio" name="wp_js_within_posts_activation" id="wp_js_within_posts_activation_off" value="off" checked="checked" /> Off</label><br />';
		} else {
			echo ' <label for="wp_js_within_posts_activation_off"><input type="radio" name="wp_js_within_posts_activation" id="wp_js_within_posts_activation_off" value="off" /> Off</label><br />';
		}
		echo '<div class="submit"><input type="submit" value="Change activation &raquo;" name="wp_js_active" /></div>';
		echo '<input type="hidden" name="wp_js_message" value="Plugin within posts activation changed.">';
		wp_nonce_field('wp-cache');
		echo "</form>\n";
		?></fieldset>
		
		
		<fieldset id="expiry-time">
		<legend>Expiry Time</legend>
		<p>Set the time for when the browser downloads a fresh copy of your JavaScript files.</p>
		<?php
		echo '<form name="wp_js_edit_expiry" action="'. $_SERVER["REQUEST_URI"] . '" method="post">';
		echo '<label for="wp_expiry">Expire time:</label> ';
		echo '<input type="text" size="6" name="wp_js_cache_time" value="'.$cache_time.'" /> seconds<br />';
		echo '<div class="submit"><input type="submit" value="Change expiration &raquo;" name="wp_js_edit_expiry" /></div>';
		echo '<input type="hidden" name="wp_js_message" value="Cache expiry changed">';
		wp_nonce_field('wp-cache');
		echo "</form>\n";
		?></fieldset>
		
		<fieldset id="clear-cache"> 
		<legend>Clear cache</legend>
		
		<?php if (!wp_js_is_directory_writable(WP_JS_CACHE_PATH)): ?>
			<p style="border: 1px solid #f00; padding: 2px; color: #f00;"><strong>Cache not available</strong><br/>The <code>wp-js</code> folder <strong>is not writable</strong>. Please change the plugin folder permissions to <code>777</code>.</p>
		<?php endif ?>
		
		<p>Clear your cache if you have updated your JavaScript files.</p>
		<?php wp_js_file_structure(); ?>
		<?php
		echo '<form name="wp_js_clear_cache" action="'. $_SERVER["REQUEST_URI"] . '" method="post">';
		echo '<div class="submit"><input type="submit" value="Clear Cache" name="wp_js_clear_cache" /></div>';
		echo '<input type="hidden" name="wp_js_message" value="Cached cleared">';
		wp_nonce_field('wp-cache');
		echo "</form>\n";
		?></fieldset>
	</div><?php
}

 // Admin Panel   
function wp_js_add_pages()
{
	add_options_page('WP JS options', 'WP JS', 8, __FILE__, 'wp_js_admin');            
}

// Add Options Page
add_action('admin_menu', 'wp_js_add_pages');

if (wp_js_within_posts_activation() == 'on') {
	include_once('wp-js-files-list.php');
}


?>