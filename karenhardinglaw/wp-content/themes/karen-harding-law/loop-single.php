<?php
$postformat = get_post_format();
	if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		<div class="post-<?php echo esc_attr($postformat); ?>-wrapper">
			<?php 
			$isactive = get_post_meta( get_the_id(), "mtheme_pb_isactive", true );
			if (isSet($isactive) && $isactive==1) {
				echo '<div class="entry-content">';
				echo do_shortcode('[template id="'.$post->ID.'"]');
				echo '</div>';
			} else {
				get_template_part( 'template-parts/postformats/default' );
			}
			?>
			<?php comments_template(); ?>
		</div>
<?php endwhile; // end of the loop. ?>