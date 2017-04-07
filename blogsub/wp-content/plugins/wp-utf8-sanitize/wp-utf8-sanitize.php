<?php
/*
Plugin Name: UTF8 Sanitize
Plugin URI: http://kaloyan.info/blog/wp-utf8-sanitize-plugin/
Description: This plugin is designed to handle the broken characters that might appear on your blog posts, if their content is converted from/to UTF8 and ISO-8859-1.
Author: Kaloyan K. Tsvetkov
Version: 0.5
Author URI: http://kaloyan.info/
*/

/////////////////////////////////////////////////////////////////////////////

/**
* @internal prevent from direct calls
*/
if (!defined('ABSPATH')) {
	return ;
	}

/**
* @internal prevent from second inclusion
*/
if (!class_exists('wp_utf8_sanitize')) {

/////////////////////////////////////////////////////////////////////////////

/**
* "UTF8 Sanitize" WordPress Plugin
*
* @author Kaloyan K. Tsvetkov <kaloyan@kaloyan.info>
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
Class wp_utf8_sanitize {

	// -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- 

	/**
	* Constructor
	*
	* This constructor attaches the needer plugin hook callbacks
	*/
	function wp_utf8_sanitize() {

		$_ = (array) get_option('wp_utf8_sanitize_settings');

		// attach the converstion handlers
		//
		if (@$_['output']) {
			add_filter('the_content',
				array($this, 'sanitize'));
			add_filter('the_excerpt',
				array($this, 'sanitize'));
			add_filter('the_title',
				array($this, 'sanitize'));
			add_filter('single_post_title',
				array($this, 'sanitize'));
			}
		if (@$_['write']) {
			add_filter('content_save_pre',
				array($this, 'sanitize'));
			add_filter('excerpt_save_pre',
				array($this, 'sanitize'));
			add_filter('title_save_pre',
				array($this, 'sanitize'));
			}

		// attach to admin menu
		//
		if (is_admin()) {
			add_action('admin_menu',
				array(&$this, '_menu')
				);
			}
		
		// attach to plugin installation
		//
		add_action(
			'activate_' . str_replace(
				DIRECTORY_SEPARATOR, '/',
				str_replace(
					realpath(ABSPATH . PLUGINDIR) . DIRECTORY_SEPARATOR,
						'', __FILE__
					)
				),
			array(&$this, 'install')
			);
		}
	
	// -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- 
	
	/**
	* Sanitize a text, repairing bad UTF8 entities.
	* @param string $content
	* @return string
	*/
	function sanitize($content) {

// &hellip; , &#8230;
$content = preg_replace('~\xC3\xA2\xE2\x82\xAC\xC2\xA6~', '&hellip;', $content);
$content = preg_replace('~\xC3\x83\xC2\xA2\xC3\xA2\xE2\x80\x9A\xC2\xAC\xC3\x82\xC2\xA6~', '&hellip;', $content);
$content = preg_replace('~\xD0\xB2\xD0\x82\xC2\xA6~', '&hellip;', $content);

// &mdash; , &#8212;
$content = preg_replace('~\xC3\xA2\xE2\x82\xAC\xE2\x80\x9D~', '&mdash;', $content);
$content = preg_replace('~\xC3\x83\xC2\xA2\xC3\xA2\xE2\x80\x9A\xC2\xAC\xC3\xA2\xE2\x82\xAC\xC2\x9D~', '&mdash;', $content);
$content = preg_replace('~\xD0\xB2\xD0\x82\xE2\x80\x9D~', '&mdash;', $content);

// &ndash; , &#8211;
$content = preg_replace('~\xC3\xA2\xE2\x82\xAC\xE2\x80\x9C~', '&ndash;', $content);
$content = preg_replace('~\xC3\x83\xC2\xA2\xC3\xA2\xE2\x80\x9A\xC2\xAC\xC3\xA2\xE2\x82\xAC\xC5\x93~', '&ndash;', $content);
$content = preg_replace('~\xD0\xB2\xD0\x82\xE2\x80\x9C~', '&ndash;', $content);

// &rsquo; , &#8217;
$content = preg_replace('~\xC3\xA2\xE2\x82\xAC\xE2\x84\xA2~', '&rsquo;', $content);
$content = preg_replace('~\xC3\x83\xC2\xA2\xC3\xA2\xE2\x80\x9A\xC2\xAC\xC3\xA2\xE2\x80\x9E\xC2\xA2~', '&rsquo;', $content);
$content = preg_replace('~\xD0\xB2\xD0\x82\xE2\x84\xA2~', '&rsquo;', $content);
$content = preg_replace('~\xD0\xBF\xD1\x97\xD0\x85~', '&rsquo;', $content);

// &lsquo; , &#8216;
$content = preg_replace('~\xC3\xA2\xE2\x82\xAC\xCB\x9C~', '&lsquo;', $content);
$content = preg_replace('~\xC3\x83\xC2\xA2\xC3\xA2\xE2\x80\x9A\xC2\xAC\xC3\x8B\xC5\x93~', '&lsquo;', $content);

// &rdquo; , &#8221;
$content = preg_replace('~\xC3\xA2\xE2\x82\xAC\xC2\x9D~', '&rdquo;', $content);
$content = preg_replace('~\xC3\x83\xC2\xA2\xC3\xA2\xE2\x80\x9A\xC2\xAC\xC3\x82\xC2\x9D~', '&rdquo;', $content);
$content = preg_replace('~\xD0\xB2\xD0\x82\xD1\x9C~', '&rdquo;', $content);

// &ldquo; , &#8220;
$content = preg_replace('~\xC3\xA2\xE2\x82\xAC\xC5\x93~', '&ldquo;', $content);
$content = preg_replace('~\xC3\x83\xC2\xA2\xC3\xA2\xE2\x80\x9A\xC2\xAC\xC3\x85\xE2\x80\x9C~', '&ldquo;', $content);
$content = preg_replace('~\xD0\xB2\xD0\x82\xD1\x9A~', '&ldquo;', $content);

// &trade; , &#8482;
$content = preg_replace('~\xC3\xA2\xE2\x80\x9E\xC2\xA2~', '&trade;', $content);
$content = preg_replace('~\xC3\x83\xC2\xA2\xC3\xA2\xE2\x82\xAC\xC5\xBE\xC3\x82\xC2\xA2~', '&trade;', $content);

// th
$content = preg_replace('~t\xC3\x82\xC2\xADh~', 'th', $content);

// .
$content = preg_replace('~.\xD0\x92+~', '.', $content);
$content = preg_replace('~.\xD0\x92~', '.', $content);

// ,
$content = preg_replace('~\x2C\xD0\x92~', ',', $content);

		return $content;
		}

	// -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- 

	/**
	* Performs the routines required at plugin installation: 
	* in general introducing the settings array
	*/	
	function install() {
		add_option(
			'wp_utf8_sanitize_settings',
				array(
					'write' => 0,
					'output' => 1,
				)
			);
		}

	// -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- --
	
	/**
	* Attach the menu page to the `Options` tab
	*/
	function _menu() {
		add_submenu_page('options-general.php',
			 'UTF8 Sanitize',
			 'UTF8 Sanitize', 8,
			 __FILE__,
			 array($this, 'menu')
			);
		}
		
	/**
	* Handles and renders the menu page
	*/
	function menu() {

		// sanitize referrer
		//
		$_SERVER['HTTP_REFERER'] = preg_replace(
			'~&saved=.*$~Uis','', $_SERVER['HTTP_REFERER']
			);
		
		// information updated ?
		//
		if ($_POST['submit']) {
			
			// save
			//
			update_option(
				'wp_utf8_sanitize_settings',
				$_POST['wp_utf8_sanitize_settings']
				);

			die("<script>document.location.href = '{$_SERVER['HTTP_REFERER']}&saved=settings:" . time() . "';</script>");
			}

		// operation report detected
		//
		if (@$_GET['saved']) {
			
			list($saved, $ts) = explode(':', $_GET['saved']);
			if (time() - $ts < 10) {
				echo '<div class="updated"><p>';
	
				switch ($saved) {
					case 'settings' :
						echo 'Settings saved.';
						break;
					}
	
				echo '</p></div>';
				}
			}

		// read the settings
		//
		$wp_utf8_sanitize_settings = (array) get_option('wp_utf8_sanitize_settings');

?>
<div class="wrap">
	<h2>UTF8 Sanitize</h2>
	<p>For more information please visit the <a href="http://kaloyan.info/blog/wp-utf8-sanitize-plugin/">UTF8 Sanitize</a> homepage.</p>
	<form method="post">
	<fieldset class="options">
		
		<div>Choose where to "fight" brokwn UTF8 characters:</div>
		
		<blockquote>
		<table border="0">
			<tr><td>
			<input <?php echo ($wp_utf8_sanitize_settings[output]) ? 'checked="checked"' : ''; ?> type="checkbox" name="wp_utf8_sanitize_settings[output]" value="1" id="wp_utf8_sanitize_settings_output" />
			</td><td>
			<label for="wp_utf8_sanitize_settings_output"><b>Outputting Posts</b></label><br/>
			</td></tr><tr><td></td><td>
			Cook the posts output to convert the broken UTF8 characters into their correct values.<br/>
			This option will not change the contens of your posts.
			<br/>&nbsp;</td></tr>

			<tr><td>
			<input <?php echo ($wp_utf8_sanitize_settings[write]) ? 'checked="checked"' : ''; ?> type="checkbox" name="wp_utf8_sanitize_settings[write]" value="1" id="wp_utf8_sanitize_settings_write" />
			</td><td>
			<label for="wp_utf8_sanitize_settings_write"><b>Saving Posts</b></label><br/>
			</td></tr><tr><td></td><td>
			Cook the posts before saving them to the databse by converting the broken UTF8 characters into their correct values.<br/>
			This option will change the contens of your posts.
			<br/>&nbsp;</td></tr>

		</table>
		</blockquote>

		<p class="submit" style="text-align:left;"><input type="submit" name="submit" value="Update &raquo;" /></p>
	</fieldset>
	</form>
</div>
<?php
		}
	
	// -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- 

	
	//--end-of-class
	}

}

/////////////////////////////////////////////////////////////////////////////

/**
* Initiating the plugin...
* @see wp_utf8_sanitize
*/
new wp_utf8_sanitize;

?>