<?php
/*
* Footer
*/
?>
<?php
$display_footer = true;
$display_instagram = true;
if (is_page_template('template-blank.php')) {
	$display_footer = false;
	$display_instagram = false;
}
if ( post_password_required() ) {
	$display_footer = false;
	$display_instagram = false;
}
if ( kreativa_is_fullscreen_post() ) {
	$display_footer = false;
	$display_instagram = false;
}
if ( is_singular('mtheme_proofing') ) {
	$display_footer = true;
	$display_instagram = false;
}
$site_in_maintenance = kreativa_maintenance_check();
if ($site_in_maintenance) {
	$display_footer = false;
	$display_instagram = false;
}
$instagram_footer = kreativa_get_option_data('instagram_footer');
if ($instagram_footer) {
	$display_instagram = true;
} else {
	$display_instagram = false;
}
if ( is_singular('mtheme_proofing') ) {
	$display_instagram = false;
	$client_id = get_post_meta( get_the_id() , 'pagemeta_client_names', true);
	$proofing_status = get_post_meta( get_the_id() , 'pagemeta_proofing_status', true);
	if ( isSet($client_id) ) {
		if ( post_password_required($client_id) ) {
			$display_footer = false;
		}
	}
	if ( isSet($proofing_status) ) {
		if ( $proofing_status=="inactive" ) {
			$display_footer = false;
		}
	}
}
if ( is_archive() ) {
	$display_footer = true;
	$display_instagram = true;
}
if ( is_404() ) {
	$display_footer = false;
	$display_instagram = false;
}
if ( is_search() ) {
	$display_footer = true;
	$display_instagram = false;
}
?>
</div>
<?php
if (isset($custom['pagemeta_pagestyle'][0])) {
	$mtheme_pagestyle=$custom['pagemeta_pagestyle'][0];
}
$portfolio_itemcarousel = "enable";
if (isset($custom['pagemeta_portfolio_itemcarousel'][0])) {
	$portfolio_itemcarousel=$custom['pagemeta_portfolio_itemcarousel'][0];
	if ( $portfolio_itemcarousel == "default" ) {
		$portfolio_itemcarousel = "enable";
	}
}
if (is_singular('mtheme_portfolio') ) {
	do_action('kreativa_display_portfolio_single_navigation');
	if ( ! post_password_required() ) {
		if (kreativa_get_option_data('portfolio_recently') && $portfolio_itemcarousel=="enable" ) {
	?>
	<div class="portfolio-end-block clearfix">
		<div class="portfolio-section-heading section-align-center">
			<h2 class="section-title"><?php echo kreativa_get_option_data('portfolio_carousel_heading'); ?></h2>
		</div>
		<?php
		$orientation = kreativa_get_option_data('portfolio_related_format');
		if ($orientation == 'portrait') {
			$column_slots = 4;
		} else {
			$column_slots = 4;
		}
		echo do_shortcode('[workscarousel pagination="false" format="'.$orientation.'" worktype_slug="" boxtitle="true" category_display="false" columns="'.$column_slots.'"]');
		?>
	</div>
	<?php
		}
	}
}
if ( $display_footer ) {
if ( $display_instagram ) {
	?>
<div class="footer-end-block clearfix">
		<?php
		$insta_username = kreativa_get_option_data('insta_username');
		if ($insta_username<>"") {
		?>
		<h3 class="instagram-username"><a href="https://instagram.com/<?php echo esc_attr($insta_username); ?>"><i class="fa fa-instagram"></i> <?php echo esc_html($insta_username); ?></a></h3>
		<?php
		}
		?>
	<?php
	$columns = 6;
	$token = kreativa_get_option_data('insta_token');
	if ( isSet($token) ) {
		if ( shortcode_exists('insta_carousel') ) {
			$insta_image_limit = kreativa_get_option_data('insta_image_limit');
			if ( !isSet($insta_image_limit) || $insta_image_limit==0 ) {
				$insta_image_limit = 6;
			}
			echo do_shortcode('[insta_carousel count="'.$insta_image_limit.'" columns="'.$columns.'" token="'.$token.'"]');
		}
	}
	?>
</div>
<?php
}
?>
<div id="copyright" class="footer-container">
<div class="footer-logo">
		<?php
		$footer_logo=kreativa_get_option_data('footer_logo');
		$theme_style = kreativa_get_option_data('theme_style');

		if (kreativa_is_in_demo()) {
			if ( false != kreativa_demo_get_data('theme_style') ) {
				$theme_style = kreativa_demo_get_data('theme_style');
			}
		}

		if ($footer_logo<>"") {
			$footer_logo_tag = '<img class="custom-footer-logo footer-logo-image" src="'.esc_url($footer_logo).'" alt="footer-logo" />';
		} else {
			if ( $theme_style == "light" ) {
				$footer_logo_tag = '<img class="footer-logo-image" src="'.esc_url(get_template_directory_uri() . '/images/logo_responsive.png').'" alt="footer-logo" />';
			} else {
				$footer_logo_tag = '<img class="footer-logo-image" src="'.esc_url(get_template_directory_uri() . '/images/logo_responsive_alt.png').'" alt="footer-logo" />';
			}
		}
		echo $footer_logo_tag;
		?>
</div>
<?php
$footer_info = stripslashes_deep( kreativa_get_option_data('footer_copyright') );
echo do_shortcode( $footer_info );
if ( kreativa_menu_is_horizontal() ) {
$footer_vmenu = nl2br( kreativa_get_option_data( 'footer_vmenu' ) );
$allowedtags = array(
    'a' => array(
        'href' => true,
        'title' => true,
    ),
    'br' => array(),
    'b' => array(),
    'strong' => array(),
);
?>
<div class="horizontal-footer-copyright"><?php echo wp_kses($footer_vmenu, $allowedtags); ?></div>
</div>
<?php
}
}
?>
<?php
if (!kreativa_is_fullscreen_post()) {
		echo '</div>';
	echo '</div>';
}
?>
<div class="site-back-cover"></div>
<?php
do_action ( 'kreativa_starting_footer' );
wp_footer();
?>
</body>
</html>