<?php
$fullscreen_check = kreativa_get_option_data('fullcscreen_henable');
if ($fullscreen_check=="1") {
	get_template_part( '/template-parts/home', 'fullscreen' );
} else {
	get_header();
	$mtheme_pagelayout_type="two-column";
	$floatside="float-left";
	?>
	<div class="contents-wrap <?php echo esc_attr($floatside); ?> two-column">
		<?php
		$sticky_posts = get_option( 'sticky_posts' );
		if ( $sticky_posts ) {
			$args_sticky = array(
			    'post__in'  => $sticky_posts
			);

			$sticky_query = new WP_Query( $args_sticky );
		    ?>
			<div class="entry-content-wrapper post-is-sticky">
			<?php
			if ( $sticky_query->have_posts() ) :
				while ( $sticky_query->have_posts() ) : $sticky_query->the_post();
					get_template_part( '/template-parts/post', 'summary' );
				endwhile;
			endif;
			wp_reset_postdata();
			?>
			</div>
		<?php
		}
		if ( get_query_var('paged') ) {
			$paged = get_query_var('paged');
		} elseif ( get_query_var('page') ) {
			$paged = get_query_var('page');
		} else {
			$paged = 1;
		}
		$default_posts_per_page = get_option( 'posts_per_page' );
		$args = array( 'paged' => $paged,'posts_per_page'=> $default_posts_per_page, 'ignore_sticky_posts'=> 1 );

		$postslist = new WP_Query( $args );
	    if ( $postslist->have_posts() ) :
	        while ( $postslist->have_posts() ) : $postslist->the_post();
	    ?>
			<div class="entry-content-wrapper">
			<?php
			get_template_part( '/template-parts/post', 'summary' );
			?>
			</div>
		<?php
		endwhile;
			echo kreativa_pagination($postslist->max_num_pages);
			wp_reset_postdata();
		endif;
		?>
	</div>
	<?php
	get_sidebar();
	get_footer();
}
?>