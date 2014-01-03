<?php
/**
 * The template for displaying full-width pages.
 *
 * Template Name: Full Width
 *
 * @package   Lattice
 * @version   1.0
 * @since     1.0
 * @author	  Sunny Ratilal
 * @copyright Copyright (c) 2013, Sunny Ratilal.
 */
?>

<?php get_header(); ?>

	<?php the_post(); ?>

	<section class="single-download-title-block">
		<div class="inside">
			<h1 class="single-download-title"><?php the_title(); ?></h1>
		</div><!-- /.inside -->
	</section><!-- /.single-download-title-block -->

	<?php rewind_posts(); ?>

	<section class="main clearfix">
		<div class="container clearfix">
			<section class="content">
				<?php
				while ( have_posts() ) {
					the_post();
				?>
					<article <?php post_class(); ?> id="post-<?php echo get_the_ID(); ?>">
						<?php the_content(); ?>
					</article><!-- /#post-<?php echo get_the_ID(); ?> -->
				<?php
				} // end while
				?>
			</section><!-- /.content -->

		</div><!-- /.container -->
	</section><!-- /.main -->

<?php get_footer(); ?>