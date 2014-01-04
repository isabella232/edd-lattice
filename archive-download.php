<?php
/**
 * The template file to display the downloads archive.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Lattice
 * @since	1.0
 * @version	1.0
 */
?>

<?php get_header(); ?>

	<section class="single-title-block">
		<div class="inside">
			<h1 class="single-title"><?php echo edd_get_label_plural(); ?></h1>
		</div><!-- /.inside -->
	</section><!-- /.single-download-title-block -->

	<section class="main clearfix">
		<div class="container clearfix">
			<section class="content">
				<?php if ( have_posts() ) { ?>
				<div class="edd_downloads_list edd_download_columns_3">
					<?php
					// Start the Loop.
					while ( have_posts() ) {
						the_post();

						/**
						 * Include the post-specific template for the content.
						 */
						get_template_part( 'content', 'download' );

					} // end while
					?>
				</div><!-- /.edd_downloads_list -->
				<?php
					lattice_page_navigation();
				} else {
					// If no content, include the "No posts found" template.
					get_template_part( 'content', 'none' );
				} // end if
				?>
			</section><!-- /.content -->

			<?php get_sidebar(); ?>
		</div><!-- /.container -->
	</section><!-- /.main -->

<?php get_footer(); ?>