<?php
/**
 * @package WordPress
 * @subpackage Chunk
 */

get_header(); ?>

	<?php if ( is_archive() ) : ?>
	<div class="page-title">
		<h2>
		<?php if ( is_day() ) : ?>
			<?php printf( __( 'Posted on %s &hellip;', 'chunk' ), '<span>' . get_the_date() . '</span>' ); ?>
		<?php elseif ( is_month() ) : ?>
			<?php printf( __( 'Posted in %s &hellip;', 'chunk' ), '<span>' . get_the_date( 'F Y' ) . '</span>' ); ?>
		<?php elseif ( is_year() ) : ?>
			<?php printf( __( 'Posted in %s &hellip;', 'chunk' ), '<span>' . get_the_date( 'Y' ) . '</span>' ); ?>
		<?php elseif( is_author() ) : ?>
			<?php printf( __( 'Posted by %s &hellip;', 'chunk' ), '<span>' . get_the_author() . '</span>' ); ?>
		<?php elseif ( is_category() ) : ?>
			<?php printf( __( 'Filed under %s &hellip;', 'chunk' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?>
		<?php elseif ( is_tag() ) : ?>
			<?php printf( __( 'Tagged with %s &hellip;', 'chunk' ), '<span>' . single_tag_title( '', false ) . '</span>' ); ?>
		<?php endif; ?>
		</h2>
	</div>
	<?php endif; ?>
	<?php if ( is_search() ) : ?>
	<div class="page-title">
		<h2>
			<?php printf( __( 'Matches for: &ldquo;%s&rdquo; &hellip;', 'chunk' ), '<span>' . get_search_query() . '</span>' ); ?>
		</h2>
	</div>
	<?php endif; ?>

	<div id="contents">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', get_post_format() ); ?>

			<?php endwhile; ?>
		<?php else : ?>

		<div class="hentry error404">
			<div class="postbody text">
				<h1><?php _e( 'Nothing Found', 'chunk' ); ?></h1>
				<div class="content">
					<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'chunk' ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .content -->
			</div><!-- .postbody -->
		</div>

		<?php endif; ?>
	</div><!-- #contents -->

	<div class="navigation">
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'chunk' ) ); ?></div>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'chunk' ) ); ?></div>
	</div>

<?php get_footer(); ?>