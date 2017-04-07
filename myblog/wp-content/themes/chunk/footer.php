<?php
/**
 * @package WordPress
 * @subpackage Chunk
 */
?>
	<?php
		/* A sidebar in the footer? Yep. You can can customize
		 * your footer with widgets. Arranged in three per row.
		 */
		get_sidebar( 'footer' );
	?>

	<div id="footer">
		<a href="http://wordpress.org/" rel="generator">Proudly powered by WordPress</a>
<?php printf( __( 'Theme: %1$s by %2$s.', 'chunk' ), 'Chunk', '<a href="http://automattic.com/" rel="designer">Automattic</a>' ); ?>
	</div>

</div>

<?php wp_footer(); ?>

</body>
</html>