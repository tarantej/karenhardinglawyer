<?php
/**
 *  loop that displays a page.
 */
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
					<?php
					if ( !kreativa_get_option_data('disable_pagecomments') ) {
						if ( comments_open() ) {
							echo '<div class="commentform-wrap">';
							comments_template();
							echo '</div>';
						}
					}
					?>
					
		</div><!-- .entry-content -->

	<?php endwhile; else: ?>
<?php endif; ?>