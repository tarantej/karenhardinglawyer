<?php
/**
 * Loop
 *
 */
?>
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<?php
					get_template_part( '/template-parts/post', 'summary' );
				?>

<?php endwhile; // end of the loop. ?>
<?php
get_template_part( '/includes/paginate', 'navigation' );
?>