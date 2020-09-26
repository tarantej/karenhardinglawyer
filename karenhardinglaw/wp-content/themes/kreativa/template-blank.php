<?php
/*
Template Name: Blank Page
*/
?>
<?php get_header(); ?>
<?php
if ( post_password_required() ) {
	
	echo '<div id="password-protected">';

	do_action('kreativa_demo_password');
	echo get_the_password_form();
	echo '</div>';
	
	} else {
	?>
	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
		
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

						<div class="entry-page-wrapper entry-content clearfix">
						<?php
						$isactive = get_post_meta( get_the_id(), "mtheme_pb_isactive", true );
						if (isSet($isactive) && $isactive==1) {
							echo do_shortcode('[template id="'.$post->ID.'"]');
						} else {
							the_content();
							wp_link_pages( array( 'before' => '<div class="page-link">' . esc_html__( 'Pages:', 'kreativa' ), 'after' => '</div>' ) );				
						}
						?>
						</div>
						
			</div><!-- .entry-content -->
		<?php endwhile; else: ?>
	<?php endif; ?>
	<?php
	}
	?>
<?php get_footer(); ?>