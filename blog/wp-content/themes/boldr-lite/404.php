<?php
/**
 *
 * BoldR Lite WordPress Theme by Iceable Themes | http://www.iceablethemes.com
 *
 * Copyright 2013-2014 Mathieu Sarrasin - Iceable Media
 *
 * 404 Page Template
 *
 */
?>

<?php get_header(); ?>

	<div class="container" id="main-content">

		<h1 class="page-title"><?php _e('404', 'boldr'); ?></h1>

		<div id="page-container" class="left with-sidebar">

			<h2><?php _e('Page Not Found', 'boldr'); ?></h2>
			<p><?php _e('What you are looking for isn\'t here...', 'boldr'); ?></p>
			<p><?php _e('Maybe a search will help ?', 'boldr'); ?></p>
			<?php get_search_form(); ?>

		</div>
		<!-- End page container -->

		<div id="sidebar-container" class="right">
			<ul id="sidebar">
			   <?php dynamic_sidebar( 'sidebar' ); ?>
			</ul>
		</div>		
		<!-- End sidebar -->
	</div>
	<!-- End main content -->
<?php get_footer(); ?>