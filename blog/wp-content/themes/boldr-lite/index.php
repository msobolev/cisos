<?php
/**
 *
 * BoldR Lite WordPress Theme by Iceable Themes | http://www.iceablethemes.com
 *
 * Copyright 2013-2014 Mathieu Sarrasin - Iceable Media
 *
 * Main Index
 *
 */
?>

<?php get_header(); ?>

	<div id="main-content" class="container">

		<?php /* SEARCH CONDITIONAL TITLE */ ?>
		<?php if ( is_search() ) :	?>
		<h1 class="page-title"><?php _e('Search Results for ', 'boldr'); ?>"<?php the_search_query() ?>"</h1>
		<?php endif; ?>
		
		<?php /* TAG CONDITIONAL TITLE */ ?>
		<?php if ( is_tag() ) :	?>			
		<h1 class="page-title"><?php _e('Tag: ', 'boldr'); single_tag_title(); ?></h1>
		<?php endif; ?>
					
		<?php /* CATEGORY CONDITIONAL TITLE */ ?>
		<?php if ( is_category() ) : ?>			
		<h1 class="page-title"><?php _e('Category: ', 'boldr'); single_cat_title(); ?></h1>
		<?php endif; ?>

		<?php /* ARCHIVES CONDITIONAL TITLE */ ?>
		<?php if ( is_day() ) : ?>			
		<h1 class="page-title"><?php _e('Daily archives: ', 'boldr'); echo get_the_time('F jS, Y'); ?></h1>
		<?php endif; ?>	
		<?php if ( is_month() ) : ?>			
		<h1 class="page-title"><?php _e('Monthly archives: ', 'boldr'); echo get_the_time('F, Y'); ?></h1>
		<?php endif; ?>	
		<?php if ( is_year() ) : ?>			
		<h1 class="page-title"><?php _e('Yearly archives: ', 'boldr'); echo get_the_time('Y'); ?></h1>
		<?php endif; ?>	

		<?php /* DEFAULT CONDITIONAL TITLE */ ?>
		<?php if (!is_front_page() && !is_search() && !is_tag() && !is_category() && !is_year() && !is_month() && !is_day() ) { ?>
		<h1 class="page-title"><?php echo get_the_title(get_option('page_for_posts')); ?></h1>
		<?php }	/* is_front_page endif */ ?>

		<div id="page-container" class="left with-sidebar">

		<?php if(have_posts()) : ?>
		<?php while(have_posts()) : the_post(); ?>

			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<div class="postmetadata">
					<span class="meta-date"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark">
						<span class="month"><?php the_time('M'); ?></span>
						<span class="day"><?php the_time('d'); ?></span>
						<span class="year"><?php the_time('Y'); ?></span>
					</a></span>
					
					
					<?php if ( ( comments_open() || get_comments_number()!=0 ) && !post_password_required() ): ?>
					<span class="meta-comments">
						<?php comments_popup_link( __( 'No', 'boldr' ), __( '1', 'boldr' ), __( '%', 'boldr' ), 'comments-count', '' ); ?>
						<?php comments_popup_link( __( 'Comment', 'boldr' ), __( 'Comment', 'boldr' ), __( 'Comments', 'boldr' ), '', __('Comments Off', 'boldr') ); ?>
					</span>
					<?php endif; ?>

					<span class="meta-author"><span><?php _e('by ', 'boldr'); the_author(); ?></span></span>

					<?php edit_post_link(__('Edit', 'boldr'), '<span class="editlink">', '</span>'); ?>
				</div>

				<div class="post-contents">
					<?php if ( '' != get_the_post_thumbnail() ) :  // As recommended from the WP codex, to avoid potential failure of has_post_thumbnail() ?>
					<div class="thumbnail">
						<?php
						echo '<a href="' . get_permalink() . '" title="' . get_the_title() . '">'; ?>
						<?php the_post_thumbnail('post-thumbnail', array('class' => 'scale-with-grid')); ?></a>
					</div>
					<?php endif; ?>
					<h3 class="entry-title">
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a>
					</h3>
					<?php if ( 'post' == get_post_type() ):  // Do not display this for pages ?>
					<div class="post-category"><?php _e('Posted in', 'boldr'); ?> <?php the_category(', '); ?></div>
					<?php endif; ?>
					<div class="post-content">
					<?php if ( get_post_format() || post_password_required() || "Full content" == boldr_get_option('blog_index_shows') ) the_content();
						else the_excerpt();
					if (has_tag()) { the_tags('<br class="clear" /><div class="tags"><span class="the-tags">'.__('Tags', 'boldr').':</span>', '', '</div>'); } ?>

					</div>
				</div>
				<br class="clear" />

			</div><!-- end div post -->

			<hr />

		<?php endwhile;
			else :

				if ( is_search() ): // Empty search results
	
				?><h2><?php _e('Not Found', 'boldr'); ?></h2>
				<p><?php echo sprintf( __('Your search for "%s" did not return any result.', 'boldr'), get_search_query() ); ?><br />
				<?php _e('Would you like to try another search ?', 'boldr'); ?></p>
				<?php get_search_form();
	
				else: // Empty loop (this should never happen!)
	
				?><h2><?php _e('Not Found', 'boldr'); ?></h2>
				<p><?php _e('What you are looking for isn\'t here...', 'boldr'); ?></p>
	
			<?php endif;
		
		endif; ?>

			<div class="page_nav">
				<?php if ( null != get_next_posts_link() ): ?>
				<div class="previous"><?php next_posts_link( __('Previous Posts', 'boldr') ); ?></div>
				<?php endif; ?>
				<?php if ( null != get_previous_posts_link() ): ?>
				<div class="next"><?php previous_posts_link( __('Next Posts', 'boldr') ); ?></div>
				<?php endif; ?>
			</div>

		</div>
		<!-- End page container -->

		<div id="sidebar-container" class="right">
			<?php get_sidebar(); ?>
		</div>		
		<!-- End sidebar -->

	</div>
	<!-- End main content -->

<?php get_footer(); ?>