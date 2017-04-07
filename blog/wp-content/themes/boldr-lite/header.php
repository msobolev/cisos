<?php
/**
 *
 * BoldR Lite WordPress Theme by Iceable Themes | http://www.iceablethemes.com
 *
 * Copyright 2013-2014 Mathieu Sarrasin - Iceable Media
 *
 * Header Template
 *
 */
?><!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html <?php language_attributes(); ?>> <!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php $favicon = boldr_get_option('favicon');
if ($favicon): ?><link rel="shortcut icon" href="<?php echo esc_url($favicon); ?>" /><?php endif; ?>
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

	<div id="main-wrap">
		<div id="header">
			<div class="container">
				<div id="logo">
				<a href="<?php echo esc_url( home_url() ); ?>">
				
				<?php $logo_url = boldr_get_option('logo');
			if ( boldr_get_option('header_title') == 'Display Title' || $logo_url == "" ): ?>
				<span class="site-title"><?php bloginfo('name') ?></span>
			<?php else: ?>
				<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php bloginfo('name') ?>">
			<?php endif; ?>
				
				</a>
				</div>
				
				<?php if ( "On" == boldr_get_option('header_tagline') ): ?>
				<div id="tagline">
				<?php bloginfo('description'); ?>
				</div>
				<?php endif; ?>
				
			</div>
		</div><!-- End header -->
	
		<div id="navbar" class="container">
			<div class="menu-container">
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'items_wrap' => '<ul id="%1$s" class="%2$s sf-menu">%3$s</ul>', ) ); ?>
			<?php boldr_dropdown_nav_menu(); ?>
			</div>
			<div id="nav-search">
				<?php get_search_form(); ?>
			</div>
		</div><!-- End navbar -->
		
<?php	if ( get_custom_header()->url ) :
			if ( ( is_front_page() && boldr_get_option('home_header_image') != 'Off' )
				|| ( is_page() && !is_front_page() && boldr_get_option('pages_header_image') != 'Off' )
				|| ( is_single() && boldr_get_option('single_header_image') != 'Off' )
				|| ( !is_front_page() && !is_singular() && boldr_get_option('blog_header_image') != 'Off' )
				|| ( is_404() ) ):
?>

	<div id="header-image" class="container">
		<img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" />
	</div>

<?php	endif;
	endif; ?>