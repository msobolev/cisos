<?php
include_once 'admin_menu_setup.php';
include_once 'admin_add_skin.php';
include_once 'admin_data.php';
include_once 'admin_functions.php';
include_once 'admin_drafts_trash.php';
include_once 'admin_custom.php';
include_once 'admin_statistics.php';
include_once 'admin_general.php';
include_once 'admin_optinbar.php';

add_action( 'admin_enqueue_scripts', 'ois_admin_script');
add_action( 'admin_init', 'ois_admin_style' );

function ois_admin_script() {
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script('jquery-ui');
	wp_enqueue_style('jquery-ui');
	wp_enqueue_script('jquery-ui-slider');
	wp_enqueue_style('jquery-ui-slider');

	$script_url = WP_PLUGIN_URL . '/OptinSkin/admin/js/script.js';
	$script_file = WP_PLUGIN_DIR . '/OptinSkin/admin/js/script.js';
	if ( file_exists($script_file) ) {
		wp_register_script( 'ois_admin_script', $script_url );
		wp_enqueue_script( 'ois_admin_script' );
	}
}

function ois_admin_style() {
	// ENQUEUE BOOTSTRAP
	$style_url = WP_PLUGIN_URL . '/OptinSkin/includes/ois_bootstrap/css/bootstrap.min.css';
	$style_file = WP_PLUGIN_DIR . '/OptinSkin/includes/ois_bootstrap/css/bootstrap.min.css';
	if ( file_exists($style_file) ) {
		wp_register_style( 'ois_bootstrap', $style_url );
		wp_enqueue_style( 'ois_bootstrap' );
	}
	
	$style_url = WP_PLUGIN_URL . '/OptinSkin/admin/css/style.css';
	$style_file = WP_PLUGIN_DIR . '/OptinSkin/admin/css/style.css';
	if ( file_exists($style_file) ) {
		wp_register_style( 'ois_admin_style', $style_url );
		wp_enqueue_style( 'ois_admin_style' );
	}
	// ENQUEUE DESIGN RESET CSS
	$style_file = WP_PLUGIN_DIR . '/OptinSkin/skins/css/ois_reset.css';
	$style_url = WP_PLUGIN_URL . '/OptinSkin/skins/css/ois_reset.css';
	if (file_exists($style_file)) {
		wp_register_style( 'ois_reset', $style_url );
		wp_enqueue_style( 'ois_reset' );
	}
	
	

	/*
	originally I enqueued like this, but it had some problems. Specifically not showing on first run.
// ENQUEUE ALL DESIGN STYLES
	$all_designs = get_option('ois_designs');
	if (!empty($all_designs)) {
		foreach ($all_designs as $design) {
			if ($design['custom'] == 'no'
				&& trim($design['css_url']) != '') {
				$css_url = $design['css_url'];
				$style_id = 'ois_design_' . $design['id'];
				wp_register_style( $style_id , $css_url );
				wp_enqueue_style( $style_id );
			}
		}
	}
*/
	
	

	$google_fonts = get_option('ois_google_fonts');
	if (!empty($google_fonts)) {
		foreach ($google_fonts as $font) {
			$data = explode(' ', $font);
			$title = implode('_', $data);
			$font = implode('+', $data);
			wp_register_style('google_font_' . $title,
				'http://fonts.googleapis.com/css?family=' . $font);
			wp_enqueue_style( 'google_font_' . $title );
		}
	}
}
?>