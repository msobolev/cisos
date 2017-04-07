<?php
/**
 *
 * BoldR Lite WordPress Theme by Iceable Themes | http://www.iceablethemes.com
 *
 * Copyright 2013-2014 Mathieu Sarrasin - Iceable Media
 *
 * Single Post Template
 *
 */
?>

<?php get_header(); ?>

	<div class="container" id="main-content">

		<div id="page-container" class="left with-sidebar">

			<?php if(have_posts()) : ?>
			<?php while(have_posts()) : the_post(); ?>

			<div id="post-<?php the_ID(); ?>" <?php post_class("single-post"); ?>>

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

				<?php if (has_post_thumbnail()) : ?>
				<div class="thumbnail">
					<a href="<?php get_permalink() ?>">
					<?php the_post_thumbnail('large', array('class' => 'scale-with-grid')); ?>
					</a>
				</div>
				<?php endif; ?>

				<div class="post-contents">
					<h3 class="entry-title">
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a>
					</h3>
					<?php if ( has_category() ): ?>
						<div class="post-category"><?php _e('Posted in', 'boldr'); ?> <?php the_category(', '); ?></div>
					<?php endif; ?>
					
					<?php the_content() ?>
					
					<div class="clear"></div>
					<?php $args = array(
						'before'           => '<br class="clear" /><div class="paged_nav">' . __('Pages:', 'boldr'),
						'after'            => '</div>',
						'link_before'      => '<span>',
						'link_after'       => '</span>',
						'next_or_number'   => 'number',
						'nextpagelink'     => __('Next page', 'boldr'),
						'previouspagelink' => __('Previous page', 'boldr'),
						'pagelink'         => '%',
						'echo'             => 1
					);
					wp_link_pages( $args ); ?>

					<?php if (has_tag()) { the_tags('<div class="tags"><span class="the-tags">'.__('Tags', 'boldr').':</span>', '', '</div>'); } ?>


				</div>
				<br class="clear" />

			</div><!-- end div post -->

			<div class="article_nav">

				<?php if ( is_attachment() ):
				// Use image navigation links on attachment pages, post navigation otherwise ?>
					<?php if ( boldr_adjacent_image_link(false) ): // Is there a previous image ? ?>
					<div class="previous"><?php previous_image_link(0, __("Previous Image", 'boldr') ); ?></div>
					<?php endif; ?>
					<?php if ( boldr_adjacent_image_link(true) ): // Is there a next image ? ?>	
					<div class="next"><?php next_image_link(0, __("Next Image",'boldr') ); ?></div>
					<?php endif; ?>
				
				<?php else: ?>

					<?php if ("" != get_adjacent_post( false, "", true ) ): // Is there a previous post? ?>
					<div class="previous"><?php previous_post_link('%link', __("Previous Post", 'boldr') ); ?></div>
					<?php endif; ?>
					<?php if ("" != get_adjacent_post( false, "", false ) ): // Is there a next post? ?>
					<div class="next"><?php next_post_link('%link', __("Next Post", 'boldr') ); ?></div>
					<?php endif; ?>

				<?php endif; ?>

				<br class="clear" />
			</div>


			<?php	// Display comments section only if comments are open or if there are comments already.
			if ( comments_open() || get_comments_number()!=0 ) : ?>
				<hr />
				<!-- comments section -->
				<div class="comments">
				<?php comments_template( '', true ); ?>
				</div>
				<!-- end comments section -->

			<div class="article_nav">
				<?php if ("" != get_adjacent_post( false, "", true ) ): // Is there a previous post? ?>
				<div class="previous"><?php previous_post_link('%link', __("Previous Post", 'boldr') ); ?></div>
				<?php endif; ?>
				<?php if ("" != get_adjacent_post( false, "", false ) ): // Is there a next post? ?>
				<div class="next"><?php next_post_link('%link', __("Next Post", 'boldr') ); ?></div>
				<?php endif; ?>
				<br class="clear" />
			</div>

			<?php endif; ?>

			<?php endwhile; ?>

			<?php else : ?>
		
			<h2><?php _e('Not Found', 'boldr'); ?></h2>
			<p><?php _e('What you are looking for isn\'t here...', 'boldr'); ?></p>

			<?php endif; ?>

		</div>
		<!-- End page container -->
		
		<div id="sidebar-container" class="right">
			<?php get_sidebar(); ?>
		</div>		
		<!-- End sidebar column -->
		

	</div>
	<!-- End main content -->

<?php get_footer(); ?>