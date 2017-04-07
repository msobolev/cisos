<?php
/**
 *
 * BoldR Lite WordPress Theme by Iceable Themes | http://www.iceablethemes.com
 *
 * Copyright 2013-2014 Mathieu Sarrasin - Iceable Media
 *
 * Theme's Function
 *
 */

/*
 * Set default $content_width
 */
if ( ! isset( $content_width ) )
	$content_width = 590;

/* Adjust $content_width depending on the page being displayed */
function boldr_content_width() {
	global $content_width;
	if ( is_singular() && !is_page() )
		$content_width = 595;
	if ( is_page() )
		$content_width = 680;
	if ( is_page_template( 'page-full-width.php' ) )
		$content_width = 920;
}
add_action( 'template_redirect', 'boldr_content_width' );

/*
 * Setup and registration functions
 */
function boldr_setup(){
	/* Translation support
	 * Translations can be added to the /languages directory.
	 * A .pot template file is included to get you started
	 */
	load_theme_textdomain('boldr', get_template_directory() . '/languages');

	/* Feed links support */
	add_theme_support( 'automatic-feed-links' );

	/* Register menus */
	register_nav_menu( 'primary', 'Navigation menu' );
	register_nav_menu( 'footer-menu', 'Footer menu' );

	/* Post Thumbnails Support */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 260, 260, true );

	/* Custom header support */
	add_theme_support( 'custom-header',
						array(	'header-text' => false,
								'width' => 920,
								'height' => 370,
								'flex-height' => true,
								)
					);

	/* Custom background support */
	add_theme_support( 'custom-background',
						array(	'default-color' => '333333',
								'default-image' => get_template_directory_uri() . '/img/black-leather.png',
								)
					);

}
add_action('after_setup_theme', 'boldr_setup');

/*
 * Page title
 */
function boldr_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'boldr' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'boldr_wp_title', 10, 2 );

/*
 * Add a home link to wp_page_menu() ( wp_nav_menu() fallback )
 */
function boldr_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) )
		$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'boldr_page_menu_args' );

/*
 * Add parent Class to parent menu items
 */
function boldr_add_menu_parent_class( $items ) {
	$parents = array();
	foreach ( $items as $item ) {
		if ( $item->menu_item_parent && $item->menu_item_parent > 0 ) {
			$parents[] = $item->menu_item_parent;
		}
	}
	foreach ( $items as $item ) {
		if ( in_array( $item->ID, $parents ) ) {
			$item->classes[] = 'menu-parent-item'; 
		}
	}
	return $items;    
}
add_filter( 'wp_nav_menu_objects', 'boldr_add_menu_parent_class' );

/*
 * The automatically generated fallback menu is not responsive.
 * Add an admin notice to warn users who did not set a primary menu
 * and make this notice dismissable so it is less intrusive.
 */

function boldr_admin_notice(){
	global $current_user;
	$user_id = $current_user->ID;
	/* Display notice if primary menu is not set and user did not dismiss the notice */
    if  ( !has_nav_menu( 'primary' ) && !get_user_meta($user_id, 'boldr_ignore_notice' ) ):
	    echo '<div class="updated"><p><strong>BoldR Lite Notice:</strong> you have not set your primary menu yet, and your site is currently using a fallback menu which is not responsive. Please take a minute to <a href="'.admin_url('nav-menus.php').'">set your menu now</a>!';
	    printf(__('<a href="%1$s" style="float:right">Dismiss</a>'), '?boldr_notice_ignore=0');
	    echo '</p></div>';
    endif;
}
add_action('admin_notices', 'boldr_admin_notice');

function boldr_notice_ignore() {
	global $current_user;
	$user_id = $current_user->ID;
	/* If user clicks to ignore the notice, add that to their user meta */
	if ( isset($_GET['boldr_notice_ignore']) && '0' == $_GET['boldr_notice_ignore'] ):		
		add_user_meta($user_id, 'boldr_ignore_notice', true, true);
	endif;
}
add_action('admin_init', 'boldr_notice_ignore');

/*
 * Register Sidebar and Footer widgetized areas
 */
function boldr_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Default Sidebar', 'boldr' ),
		'id'            => 'sidebar',
		'description'   => '',
	    'class'         => '',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
		)
	);
	
	register_sidebar( array(
		'name'          => __( 'Footer', 'boldr' ),
		'id'            => 'footer-sidebar',
		'description'   => '',
	    'class'         => '',
		'before_widget' => '<li id="%1$s" class="one-fourth widget %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'boldr_widgets_init' );


/*
 * Enqueue CSS styles
 */
function boldr_styles() {

	$template_directory_uri = get_template_directory_uri(); // Parent theme URI
	$stylesheet_directory = get_stylesheet_directory(); // Current theme directory
	$stylesheet_directory_uri = get_stylesheet_directory_uri(); // Current theme URI

	$responsive_mode = boldr_get_option('responsive_mode');
	
	if ($responsive_mode != 'off'):
		$stylesheet = '/css/boldr.min.css';
	else:
		$stylesheet = '/css/boldr-unresponsive.min.css';
	endif;

	/* Child theme support:
	 * Enqueue child-theme's versions of stylesheet in /css if they exist,
	 * or the parent theme's version otherwise
	 */
	if ( @file_exists( $stylesheet_directory . $stylesheet ) )
		wp_register_style( 'boldr', $stylesheet_directory_uri . $stylesheet );
	else
		wp_register_style( 'boldr', $template_directory_uri . $stylesheet );				

	// Always enqueue style.css from the current theme
	wp_register_style( 'style', $stylesheet_directory_uri . '/style.css');

	wp_enqueue_style( 'boldr' );
	wp_enqueue_style( 'style' );

	// Google Webfonts
	wp_enqueue_style( 'Oswald-webfonts', "//fonts.googleapis.com/css?family=Oswald:400italic,700italic,400,700&subset=latin,latin-ext", array(), null );
	wp_enqueue_style( 'PTSans-webfonts', "//fonts.googleapis.com/css?family=PT+Sans:400italic,700italic,400,700&subset=latin,latin-ext", array(), null );

}
add_action('wp_enqueue_scripts', 'boldr_styles');

/*
 * Register editor style
 */
function boldr_editor_styles() {
	add_editor_style();
}
add_action( 'init', 'boldr_editor_styles' );

/*
 * Enqueue Javascripts
 */
function boldr_scripts() {
	wp_enqueue_script('boldr', get_template_directory_uri() . '/js/boldr.min.js', array('jquery'));
    /* Threaded comments support */
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
}
add_action('wp_enqueue_scripts', 'boldr_scripts');


/*
 * Remove "rel" tags in category links (HTML5 invalid)
 */
function boldr_remove_rel_cat( $text ) {
	$text = str_replace(' rel="category"', "", $text); return $text;
}
add_filter( 'the_category', 'boldr_remove_rel_cat' );

/*
 * Fix for a known issue with enclosing shortcodes and wpautop
 * (wpautop tends to add empty <p> or <br> tags before and/or after enclosing shortcodes)
 * Thanks to Johann Heyne
 */
function boldr_shortcode_empty_paragraph_fix($content) {
	$array = array (
		'<p>['    => '[', 
		']</p>'   => ']', 
		']<br />' => ']',
	);
	$content = strtr($content, $array);
	return $content;
}
add_filter('the_content', 'boldr_shortcode_empty_paragraph_fix');

/*
 * Improved version of clean_pre
 * Based on a work by Emrah Gunduz
 */
function boldr_protect_pre($pee) {
	$pee = preg_replace_callback('!(<pre[^>]*>)(.*?)</pre>!is', 'boldr_eg_clean_pre', $pee );
	return $pee;
}

function boldr_eg_clean_pre($matches) {
	if ( is_array($matches) )
		$text = $matches[1] . $matches[2] . "</pre>";
	else
		$text = $matches;
	$text = str_replace('<br />', '', $text);
	return $text;
}
add_filter( 'the_content', 'boldr_protect_pre' );

/*
 * Customize "read more" links on index view
 */
function boldr_excerpt_more( $more ) {
	global $post;
	return '<div class="read-more"><a href="'. get_permalink( get_the_ID() ) . '">'. __("Read More", 'boldr') .'</a></div>';
}
add_filter( 'excerpt_more', 'boldr_excerpt_more' );

/*
 * Rewrite and replace wp_trim_excerpt() so it adds a relevant read more link
 * when the <!--more--> or <!--nextpage--> quicktags are used
 * This new function preserves every features and filters from the original wp_trim_excerpt
 */
function boldr_trim_excerpt($text = '') {
	global $post;
	$raw_excerpt = $text;
	if ( '' == $text ) {
		$text = get_the_content('');
		$text = strip_shortcodes( $text );
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]&gt;', $text);
		$excerpt_length = apply_filters('excerpt_length', 55);
		$excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
		$text = wp_trim_words( $text, $excerpt_length, $excerpt_more );

		/* If the post_content contains a <!--more--> OR a <!--nextpage--> quicktag
		 * AND the more link has not been added already
		 * then we add it now
		 */
		if ( ( preg_match('/<!--more(.*?)?-->/', $post->post_content ) || preg_match('/<!--nextpage-->/', $post->post_content ) ) && strpos($text,$excerpt_more) === false ) {
		 $text .= $excerpt_more;
		}
		
	}
	return apply_filters('boldr_trim_excerpt', $text, $raw_excerpt);
}
remove_filter( 'get_the_excerpt', 'wp_trim_excerpt' );
add_filter( 'get_the_excerpt', 'boldr_trim_excerpt' );

/*
 * Create dropdown menu (used in responsive mode)
 * Requires a custom menu to be set (won't work with fallback menu)
 */
function boldr_dropdown_nav_menu () {
	$menu_name = 'primary';
	if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
		if ($menu = wp_get_nav_menu_object( $locations[ $menu_name ] ) ) {
		$menu_items = wp_get_nav_menu_items($menu->term_id);
		$menu_list = '<select id="dropdown-menu">';
		$menu_list .= '<option value="">Menu</option>';
		foreach ( (array) $menu_items as $key => $menu_item ) {
			$title = $menu_item->title;
			$url = $menu_item->url;
			if($url != "#" ) $menu_list .= '<option value="' . $url . '">' . $title . '</option>';
		}
		$menu_list .= '</select>';
   		// $menu_list now ready to output
   		echo $menu_list;    
		}
    } 
}

/*
 * Find whether post page needs comments pagination links (used in comments.php)
 */
function boldr_page_has_comments_nav() {
	global $wp_query;
	return ($wp_query->max_num_comment_pages > 1);
}

function boldr_page_has_next_comments_link() {
	global $wp_query;
	$max_cpage = $wp_query->max_num_comment_pages;
	$cpage = get_query_var( 'cpage' );	
	return ( $max_cpage > $cpage );
}

function boldr_page_has_previous_comments_link() {
	$cpage = get_query_var( 'cpage' );	
	return ($cpage > 1);
}

/*
 * Find whether attachement page needs navigation links (used in single.php)
 */
function boldr_adjacent_image_link($prev = true) {
    global $post;
    $post = get_post($post);
    $attachments = array_values(get_children("post_parent=$post->post_parent&post_type=attachment&post_mime_type=image&orderby=\"menu_order ASC, ID ASC\""));

    foreach ( $attachments as $k => $attachment )
        if ( $attachment->ID == $post->ID )
            break;

    $k = $prev ? $k - 1 : $k + 1;

    if ( isset($attachments[$k]) )
        return true;
	else
		return false;
}

/*
 * Framework Elements
 */
include_once('functions/icefit-options/settings.php'); // Admin Settings Panel

?>