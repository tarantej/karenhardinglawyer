<?php
if ( is_singular() ) {
	$page_title = get_post_meta( get_the_id() , 'pagemeta_page_title', true);
}
if ( is_archive() ) {
	$page_title = "show";
}
if ( !isSet($page_title) ) {
	$page_title="";
}
if ( is_singular('mtheme_proofing') ) {
	$page_title = "hide";
}
if ( is_singular('mtheme_clients') ) {
	$page_title = "hide";
}
$hide_pagetitle=kreativa_get_option_data('hide_pagetitle');
if ($hide_pagetitle=="1") {
	$page_title = "hide";
}
if ( $page_title <> "hide") {
?>
<div class="title-container-outer-wrap">
	<div class="title-container-wrap">
	<div class="title-container clearfix">
		<?php
		do_action('mtheme_before_header_title');
		?>
		<?php
		$mtheme_pagestyle='';
		if (isSet($post->ID)){
			$custom = get_post_custom($post->ID);
		}
		if (isset($custom['pagemeta_pagestyle'][0])) {
			$mtheme_pagestyle=$custom['pagemeta_pagestyle'][0];
		} else {
			$mtheme_pagestyle="rightsidebar";
		}
		if ( is_home() ) { $mtheme_pagestyle="rightsidebar"; }
		if ( is_post_type_archive() ) { $mtheme_pagestyle="fullwidth"; }
		if ( is_tax() ) { $mtheme_pagestyle="fullwidth"; }
		if ($mtheme_pagestyle=="fullwidth" || $mtheme_pagestyle=="edge-to-edge") { $floatside=""; }
		if ($mtheme_pagestyle=="rightsidebar") { $floatside="float-left"; }
		if ($mtheme_pagestyle=="leftsidebar") { $floatside="float-right"; }

		if (isset($custom['pagemeta_pagetitle_style'][0])) {
			$mtheme_pagetitle_style=$custom['pagemeta_pagetitle_style'][0];
		}
		if (isSet($mtheme_pagetitle_style)) {
			$mtheme_pagetitle_style = ' ' . $mtheme_pagetitle_style;
		} else {
			$mtheme_pagetitle_style = '';
		}
		?>
		<div class="entry-title-wrap<?php echo esc_attr($mtheme_pagetitle_style); ?>">
			<h1 class="entry-title">
			<?php if ( is_day() ) : ?>
							<?php printf( esc_html__( 'Daily Archives: %s', 'kreativa' ), get_the_date() ); ?>
			<?php elseif ( is_month() ) : ?>
							<?php printf( esc_html__( 'Monthly Archives: %s', 'kreativa' ), get_the_date( 'F Y' ) ); ?>
			<?php elseif ( is_year() ) : ?>
							<?php printf( esc_html__( 'Yearly Archives: %s', 'kreativa' ), get_the_date( 'Y' ) ); ?>
			<?php elseif ( is_author() ) : ?>
							<?php esc_html_e( 'Author Archives: ', 'kreativa' ); ?> <?php echo get_query_var('author_name'); ?>
			<?php elseif ( is_category() ) : ?>
							<?php printf( esc_html__( 'Category : %s', 'kreativa' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?>
			<?php elseif ( is_tag() ) : ?>
							<?php printf( esc_html__( 'Tag : %s', 'kreativa' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?>
			<?php elseif ( is_search() ) : ?>
							<?php printf( esc_html__( 'Search Results for: %s', 'kreativa' ), '<span>' . get_search_query() . '</span>' ); ?>
			<?php elseif ( is_404() ) : ?>
							<?php esc_html_e( '404 Page not Found!', 'kreativa' ); ?>		
			<?php elseif ( is_home() ) : ?>
							<?php bloginfo('name'); ?>
			<?php elseif ( is_front_page() ) : ?>
							<?php the_title(''); ?>
			<?php elseif ( is_post_type_archive('mtheme_portfolio') ) : ?>
							<?php echo kreativa_get_option_data('portfolio_singular_refer'); ?>
			<?php elseif ( is_post_type_archive('mtheme_gallery') ) : ?>
							<?php echo kreativa_get_option_data('gallery_singular_refer'); ?>
			<?php elseif ( is_post_type_archive('mtheme_events') ) : ?>
							<?php echo kreativa_get_option_data('event_gallery_title'); ?>
			<?php elseif ( is_post_type_archive('mtheme_photostory') ) : ?>
							<?php echo kreativa_get_option_data('story_archive_title'); ?>
			<?php elseif ( is_post_type_archive('mtheme_proofing') ) : ?>
							<?php esc_html_e( 'Proofing Archive', 'kreativa' ); ?>
			<?php elseif ( is_post_type_archive('product') ) : ?>
							<?php echo kreativa_get_option_data('mtheme_woocommerce_shoptitle'); ?>
			<?php elseif ( is_tax() ) : ?>
							<?php
							$term = get_queried_object();
							if (!isSet($term->name) ) {
								$worktype = kreativa_get_option_data('portfolio_singular_refer');
							} else {
								$worktype = $term->name;
							}
							echo esc_html($worktype);
							?>
			<?php else : ?>
							<?php the_title(''); ?>
			<?php endif; ?>
			</h1>
		</div>
		<?php
		do_action('mtheme_after_header_title');
		?>
	</div>
</div>
</div>
<?php
}
?>