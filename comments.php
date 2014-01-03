<?php
/**
 * The template for displaying comments.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Lattice
 * @since	1.0
 * @version	1.0
 */
?>

<?php
	if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && 'comments.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
		die ( 'This file cannot be loaded directly.' );
	} // end if
?>

<?php global $post; ?>

<?php if ( post_password_required() ) { ?>
	<div id="comments">
		<h3 class="nopassword"><?php _e( 'This post is password protected. Enter the password to view comments.', 'lattice' ); ?></h3>
	</div><!-- #comments -->
	<?php return; ?>
<?php } // end if ?>


<?php if ( have_comments() ) { ?>
	<div id="comments" class="clearfix">
		<h3><?php lattice_comments_title(); ?></h3>
		<div id="comments-list">
			<ol class="comment-list">
				<?php
					$args = array(
						'type'        => 'comment',
						'avatar_size' => 48,
						'callback'    => 'lattice_comment',
					);

					wp_list_comments( $args );
				?>
			</ol><!-- /.comment-list -->
		</div><!-- /#comments-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) { ?>

			<div id="comment-navigation">
				<nav class="navigation comment-nav" role="navigation">
					<?php previous_comments_link( '<i class="fa fa-chevron-left"></i>' . __( 'Previous Comments', 'lattice' ) ); ?>
					<?php next_comments_link( __( 'Newer Comments', 'lattice' ) . '<i class="fa fa-chevron-right"></i>'); ?>
				</nav><!-- /.comment-nav -->
			</div><!-- /#comment-naviation -->

		<?php } // end if ?>
	</div><!-- /#comments -->

<?php } else { ?>

	<?php if ( comments_open() ) { ?>

		<div id="comments" class="clearfix">
			<?php if ( 'download' == get_post_type( $post->ID ) && class_exists( 'EDD_Reviews' ) ) { ?>

				<h3><?php _e( 'No Reviews', 'lattice' ); ?></h3>
				<p><?php printf( __( 'Be the first to review this %s.', 'lattice' ), strtolower( edd_get_label_singular() ) ); ?></p>

			<?php } else { ?>

				<h3><?php _e( 'No Comments', 'lattice' ); ?></h3>
				<p><?php _e( 'Be the first to start the conversation.', 'lattice' ); ?></p>

			<?php } // end if ?>
		</div><!-- /#comments -->

	<?php } // end if ?>

<?php } // end if ?>

<?php comment_form( array( 'format' => 'html5' ) ); ?>