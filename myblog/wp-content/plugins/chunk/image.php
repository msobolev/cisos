<?php
/**
 * @package WordPress
 * @subpackage Chunk
 */

get_header(); ?>

	<div id="contents">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<div <?php post_class(); ?> id="post">
					<div class="entry-meta">
						<div class="date"><a href="<?php the_permalink(); ?>"><?php the_time( 'M d Y' ); ?></a></div>
						<?php if ( comments_open() || ( '0' != get_comments_number() && ! comments_open() ) ) : ?>
						<div class="comments"><?php comments_popup_link( __( 'Leave a comment', 'quintus' ), __( '1 Comment', 'quintus' ), __( '% Comments', 'chunk' ) ); ?></div>
						<?php endif; ?>
						<span class="cat-links">
							<?php
									$metadata = wp_get_attachment_metadata();
									printf( __( '<a href="%1$s" title="Link to full-size image">%2$s &times; %3$s</a> in <a href="%4$s" title="Return to %5$s" rel="gallery">%5$s</a>', 'chunk' ),
										wp_get_attachment_url(),
										$metadata['width'],
										$metadata['height'],
										get_permalink( $post->post_parent ),
										get_the_title( $post->post_parent )
									);
								?>
						</span>
						<?php edit_post_link( __( 'Edit', 'chunk' ), '<span class="edit-link">', '</span>' ); ?>
						<div class="navigation">
							<div class="nav-previous"><?php previous_image_link( array( 60, 60 ) ); ?></div>
							<div class="nav-next"><?php next_image_link( array( 60, 60 ) ); ?></div>
						</div>
					</div>
					<div class="main">
						<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'chunk' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
						<div class="entry-content">
							<?php
								/**
								 * Grab the IDs of all the image attachments in a gallery so we can get the URL of the next adjacent image in a gallery,
								 * or the first image (if we're looking at the last image in a gallery), or, in a gallery of one, just the link to that image file
								 */
								$attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
								foreach ( $attachments as $k => $attachment ) {
									if ( $attachment->ID == $post->ID )
										break;
								}
								$k++;
								// If there is more than 1 attachment in a gallery
								if ( count( $attachments ) > 1 ) {
									if ( isset( $attachments[ $k ] ) )
										// get the URL of the next image attachment
										$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
									else
										// or get the URL of the first image attachment
										$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
								} else {
									// or, if there's only 1 image, get the URL of the image
									$next_attachment_url = wp_get_attachment_url();
								}
							?>
							<p>
								<a href="<?php echo $next_attachment_url; ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment"><?php	echo wp_get_attachment_image( $post->ID, array( 580, 580 ) ); ?></a>
							</p>

							<?php if ( ! empty( $post->post_excerpt ) ) : ?>
							<p><?php the_excerpt(); ?></p>
							<?php endif; ?>

							<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'chunk' ) ); ?>
							<?php wp_link_pages( array( 'before' => '<p class="page-link"><span>' . __( 'Pages:', 'chunk' ) . '</span>', 'after' => '</p>' ) ); ?>
						</div>
						<?php the_tags( '<span class="tag-links"><strong>' . __( 'Tagged', 'chunk' ) . '</strong> ', ', ', '</span>' ); ?>
					</div>
				</div>

				<?php comments_template( '', true ); ?>

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

<?php get_footer(); ?>