<?php
/**
*  loop attachment
 */
?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="entry-wrapper entry-content clearfix">
						<?php
						// Show Image
						if ( wp_attachment_is_image() ) :
							?>
							<div class="attachment-page-image">
							<?php
							echo '<a class="lightbox-active lightbox-image postformat-image-lightbox" data-src="'. wp_get_attachment_url() .'" href="'. wp_get_attachment_url() .'">';
							?>
								<?php
								echo kreativa_display_post_image (
									$post->ID,
									$have_image_url=false,
									$link=false,
									$type="fullwidth",
									$post->post_title,
									$class="" 
								);
								?>
							</a>
							<?php the_excerpt(); ?>
							</div>
							<?php
						endif;
						?>
						<div class="navigation">
							<div class="nav-previous">
							<?php previous_image_link( false , '<i class="feather-icon-arrow-left"></i>' ); ?>
							</div>
							<div class="nav-next">
							<?php next_image_link( false , '<i class="feather-icon-arrow-right"></i>' ); ?>
							</div>
						</div><!-- #nav-below -->
			
						

		<div class="always-center">
				<?php
				if ( is_single() && !post_password_required() ) {
					get_template_part('/includes/share','this');
				}
				?>
		</div>
						<?php 
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
						?>
						<div class="clear"></div>			
					</div>
			</div>

<?php endwhile; // end of the loop. ?>