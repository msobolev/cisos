<?php
/**
 * @package WordPress
 * @subpackage Chunk
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 580;

/**
 * Make theme available for translation
 * Translations can be filed in the /languages/ directory
 */
load_theme_textdomain( 'chunk', get_template_directory_uri() . '/languages' );

$locale = get_locale();
$locale_file = get_template_directory_uri() . "/languages/$locale.php";
if ( is_readable( $locale_file ) )
	require_once( $locale_file );

/**
 * Add feed links to head
 */
add_theme_support( 'automatic-feed-links' );

/**
 * This theme uses wp_nav_menu() in one location.
 */
register_nav_menus( array(
	'primary' => __( 'Main Menu', 'chunk' ),
) );

/**
 * Enable Post Formats
 */
add_theme_support( 'post-formats', array( 'aside', 'gallery', 'image', 'quote', 'link', 'audio', 'chat', 'video' ) );

/**
 * Add custom background support.
 */
add_custom_background();

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function chunk_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'chunk_page_menu_args' );

/**
 * Register our footer widget area
 */
function chunk_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Footer', 'chunk' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'chunk_widgets_init' );

/**
 * Custom Header.
 */
define( 'HEADER_TEXTCOLOR', '000' );

// By leaving empty, we default to random image rotation.
define( 'HEADER_IMAGE', '' );

define( 'HEADER_IMAGE_WIDTH', 800 );
define( 'HEADER_IMAGE_HEIGHT', 140 );

add_custom_image_header( 'chunk_header_style', 'chunk_admin_header_style' );

/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 */
function chunk_admin_header_style() {
?>
	<style type="text/css">
        #headimg {
            width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
            height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
        }
        #heading,
        #headimg h1,
        #headimg #desc {
        	display: none;
        }
    </style>
<?php
}

/**
 * Styles the header image and text displayed on the blog.
 */
function chunk_header_style() {

	// If no custom options for text are set, let's bail
	// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value
	if ( HEADER_TEXTCOLOR == get_header_textcolor() )
		return;
	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == get_header_textcolor() ) :
	?>
		#site-title,
		#site-description {
			position: absolute !important;
			clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
		#header {
			min-height: 0;
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		#site-title a {
			color: #<?php echo get_header_textcolor(); ?> !important;
		}
	<?php endif; ?>
	</style>
	<?php
}

/**
 * Enqueue font styles.
 */
function chunk_fonts() {
	wp_enqueue_style( 'oswald', 'http://fonts.googleapis.com/css?family=Oswald' );
}
add_action( 'wp_enqueue_scripts', 'chunk_fonts' );

/**
 * Audio player.
 */
function chunk_scripts() {
	if ( ! is_singular() || ( is_singular() && 'audio' == get_post_format() ) )
		wp_enqueue_script( 'audio-player', get_template_directory_uri() . '/js/audio-player.js', array( 'jquery' ), '20110823' );
}
add_action( 'wp_enqueue_scripts', 'chunk_scripts' );

function chunk_add_audio_support() {
	if ( ! is_singular() || ( is_singular() && 'audio' == get_post_format() ) ) {
?>
		<script type="text/javascript">
			AudioPlayer.setup( "<?php echo get_template_directory_uri(); ?>/swf/player.swf", {
				bg: "e4e4e4",
				leftbg: "e4e4e4",
				rightbg: "e4e4e4",
				track: "222222",
				text: "555555",
				lefticon: "eeeeee",
				righticon: "eeeeee",
				border: "e4e4e4",
				tracker: "eb374b",
				loader: "666666"
			});
		</script>
<?php }
}
add_action( 'wp_head', 'chunk_add_audio_support' );

/**
 * Return the URL for the first link found in this post.
 *
 * @param string the_content Post content, falls back to current post content if empty.
 * @return string|bool URL or false when no link is present.
 */
function chunk_url_grabber( $the_content = '' ) {
	if ( empty( $the_content ) )
		$the_content = get_the_content();
	if ( ! preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', $the_content, $matches ) )
		return false;

	return esc_url_raw( $matches[1] );
}

/**
 * Return the first audio file found for a post.
 *
 * @param int post_id ID for parent post
 * @return boolean|string Path to audio file
 */
function chunk_audio_grabber( $post_id ) {
	global $wpdb;

	$first_audio = $wpdb->get_var( $wpdb->prepare( "SELECT guid FROM $wpdb->posts WHERE post_parent = %d AND post_type = 'attachment' AND INSTR(post_mime_type, 'audio') ORDER BY menu_order ASC LIMIT 0,1", (int) $post_id ) );

	if ( ! empty( $first_audio ) )
		return $first_audio;

	return false;
}