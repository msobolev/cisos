<?php
/**
 * @package WordPress
 * @subpackage Chunk
 */
?>

		<div <?php post_class(); ?> id="post">
			<div class="entry-meta">
				<div class="date"><a href="<?php the_permalink(); ?>"><?php the_time( 'M d Y' ); ?></a></div>
				<?php if ( comments_open() || ( '0' != get_comments_number() && ! comments_open() ) ) : ?>
				<div class="comments"><?php comments_popup_link( __( 'Leave a comment', 'quintus' ), __( '1 Comment', 'quintus' ), __( '% Comments', 'chunk' ) ); ?></div>
				<?php endif; ?>
				<span class="cat-links"><?php the_category( ', ' ); ?></span>
				<?php edit_post_link( __( 'Edit', 'chunk' ), '<span class="edit-link">', '</span>' ); ?>
			</div>
			<div class="main">
				<?php
					// Let's get all the post content
					$link_content = $post->post_content;

					// And let's find the first url in the post content
					$link_url = chunk_url_grabber();

					// Let's make the title a link if there's a link in this link post
					if ( ! empty( $link_url ) ) :
				?>
				<h2 class="entry-title"><a href="<?php echo $link_url; ?>"><?php the_title(); ?></a></h2>
				<?php else : ?>
				<h2 class="entry-title"><?php the_title(); ?></h2>
				<?php endif; ?>

				<?php
				// Sometimes links need descriptions and sometimes they don't ...

				// Let's compare the length of the first url with the length of the post content.
				// If they're one and the same we don't really need to show the post content BECAUSE ...
				// that's just a url and we're already using that url as a href for the title link above BUT ...
				// if they're NOT the same I think we should show that content.
				if ( strlen( $link_url ) != strlen( $link_content ) ) :

				// Let's make any bare URL a clickable link, too.
				add_filter( 'the_content', 'make_clickable' );
				?>
				<div class="entry-content">
					<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'chunk' ) ); ?>
					<?php wp_link_pages( array( 'before' => '<p class="page-link"><span>' . __( 'Pages:', 'chunk' ) . '</span>', 'after' => '</p>' ) ); ?>
				</div>
				<?php endif; ?>
				<?php the_tags( '<span class="tag-links">' . __( 'Tagged ', 'chunk' ) . '', ', ', '</span>' ); ?>
			</div>
		</div>

		<?php comments_template( '', true ); ?>