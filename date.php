<?php
/**
 * The template file for the date based archives.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Lattice
 * @since	1.0
 * @version	1.0
 */
?>

<?php get_header(); ?>

	<section class="main clearfix">
		<div class="container clearfix">
			<section class="content">
				<?php
				if ( have_posts() ) :
					// Start the Loop.
					while ( have_posts() ) : the_post();

						/*
						 * Include the post format-specific template for the content. If you want to
						 * use this in a child theme, then include a file called called content-___.php
						 * (where ___ is the post format) and that will be used instead.
						 */
						get_template_part( 'content', get_post_format() );

					endwhile;

					lattice_page_navigation();
				else :
					// If no content, include the "No posts found" template.
					get_template_part( 'content', 'none' );

				endif;
				?>
			</section><!-- /.content -->

			<?php get_sidebar(); ?>
		</div><!-- /.container -->
	</section><!-- /.main -->

<?php get_footer(); ?>