<?php
/**
 * The template for display "No posts found" message
 *
 * @package Lattice
 * @since	1.0
 * @version	1.0
 */
?>

<article id="post-0" class="type-post post">
	<h2 class="entry-title"><?php _e( 'Nothing Found', 'lattice' ); ?></h2>

	<?php if ( is_home() && current_user_can( 'publish_posts' ) ) { ?>

		<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'lattice' ), admin_url( 'post-new.php' ) ); ?></p>

	<?php } elseif ( is_search() ) { ?>

		<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'lattice' ); ?></p>
		<?php get_search_form(); ?>

	<?php } else { ?>

		<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'lattice' ); ?></p>
		<?php get_search_form(); ?>

	<?php } // end if ?>
</article><!-- #post-0 -->