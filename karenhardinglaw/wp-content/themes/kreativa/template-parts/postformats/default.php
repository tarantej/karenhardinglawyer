<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<?php
	get_template_part( 'template-parts/postformats/post','contents' );
?>
<?php
	// Author bio.
	if ( is_single() ) {
		$display_authorbio=false;
		if ( kreativa_get_option_data('author_bio') ) {
			$display_authorbio=true;
		}
		$post_authorbio_status= get_post_meta($post->ID, 'pagemeta_post_authorbio', true);
		if ($post_authorbio_status == 'activate') {
			$display_authorbio=true;
		}
		if ($display_authorbio) {
			get_template_part( 'template-parts/author','bio' );
		}
	}
?>
</div>