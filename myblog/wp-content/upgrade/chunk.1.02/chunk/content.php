<?php
/**
 * @package WordPress
 * @subpackage Chunk
 */
?>

		<div <?php post_class(); ?> id="post">
			<div class="entry-meta">
				<?php if ( ! is_page() ) : ?>
				<div class="date"><a href="<?php the_permalink(); ?>"><?php the_time( 'M d Y' ); ?></a></div>
				<?php endif; ?>
				<?php if ( comments_open() || ( '0' != get_comments_number() && ! comments_open() ) ) : ?>
				<div class="comments"><?php comments_popup_link( __( 'Leave a comment', 'quintus' ), __( '1 Comment', 'quintus' ), __( '% Comments', 'chunk' ) ); ?></div>
				<?php endif; ?>
				<span class="cat-links"><?php the_category( ', ' ); ?></span>
				<?php edit_post_link( __( 'Edit', 'chunk' ), '<span class="edit-link">', '</span>' ); ?>
			</div>
			<div class="main">
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'chunk' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
				<div class="entry-content">
					<?php wp_link_pages( array( 'before' => '<p class="page-link"><span>' . __( 'Pages:', 'chunk' ) . '</span>', 'after' => '</p>' ) ); ?>
					<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'chunk' ) ); ?>
				</div>
				<?php the_tags( '<span class="tag-links"><strong>' . __( 'Tagged', 'chunk' ) . '</strong> ', ', ', '</span>' ); ?>
			</div>
		</div>

		<?php comments_template( '', true ); ?>