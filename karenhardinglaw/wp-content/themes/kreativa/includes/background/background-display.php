<?php
if (is_singular()) {
	if (isSet($post->ID)) {
		$bg_choice= get_post_meta($post->ID, 'pagemeta_meta_background_choice', true);
		$custom_bg_image_url= get_post_meta($post->ID, 'pagemeta_meta_background_url', true);
		$image_link=kreativa_featured_image_link($post->ID);
	}
}

$default_bg= kreativa_get_option_data('general_background_image'); // Theme Options set image
$theme_options_set_background_slideshow = kreativa_get_option_data('general_bgslideshow');
$photowall_background_image = kreativa_get_option_data('photowall_background_image');

if (!isSet($bg_choice) ) {
	$bg_choice="options_image";
}
if (isSet($fullscreen_slideshowpost)) {
	if ($fullscreen_slideshowpost != "none" && $fullscreen_slideshowpost<>"") {
		$bg_choice="Fullscreen Post Slideshow";
	}
}
if ( is_archive() || is_search() ) $bg_choice="default";

if ( kreativa_page_is_woo_shop() ) {
	$woo_shop_post_id = get_option( 'woocommerce_shop_page_id' );
	$bg_choice= get_post_meta($woo_shop_post_id, 'pagemeta_meta_background_choice', true);
	$custom_bg_image_url= get_post_meta($woo_shop_post_id, 'pagemeta_meta_background_url', true);
	$image_link=kreativa_featured_image_link($woo_shop_post_id);
}

if ( is_singular('mtheme_proofing') ) {
	$client_id = get_post_meta( get_the_id() , 'pagemeta_client_names', true);
	if ( isSet($client_id) ) {
		if ( post_password_required($client_id) ) {
			$bg_choice="featured_image";
			$image_link=kreativa_featured_image_link(get_the_id());
		}
	}
}
if ( is_singular('mtheme_clients') ) {
	if ( post_password_required() ) {
		$bg_choice="featured_image";
		$client_background_image_id = get_post_meta( get_the_id() , 'pagemeta_client_background_image', true);
		if (isSet($client_background_image_id)) {
			$image_link=$client_background_image_id;
		} else {
			$image_link = '';
		}
	}
}

if ( !kreativa_is_fullscreen_home()) {
	if ($bg_choice != "none") {
		switch ($bg_choice) {
			case "options_slideshow" :
			case "image_attachments" :
			case "fullscreen_post" :
			case "image_featured" :
				if ($bg_choice=="options_slideshow") { $get_slideshow_from_page_id = $theme_options_set_background_slideshow; }
				if ($bg_choice=="image_attachments") { $get_slideshow_from_page_id = get_the_ID(); }
				if ($bg_choice=="image_featured") { $get_slideshow_from_page_id = get_the_ID(); }
				get_template_part( '/includes/background/fullscreen', 'slideshow' );
			break;	
			case "video_background" :
				if (isset( $post->ID )) {
					$get_video_from_page_id= get_post_meta( $post->ID, 'pagemeta_video_bgfullscreenpost', true);
					$custom = get_post_custom($get_video_from_page_id);
					if ( kreativa_page_is_woo_shop() ) {
						$woo_shop_post_id = get_option( 'woocommerce_shop_page_id' );
						$get_video_from_page_id= get_post_meta( $woo_shop_post_id, 'pagemeta_video_bgfullscreenpost', true);
						$custom = get_post_custom($get_video_from_page_id);
					}
					//HTML5
					if (isSet($custom["pagemeta_html5_mp4"][0])) {
						$html5_mp4=$custom["pagemeta_html5_mp4"][0];
					}
					if ( isSet($html5_mp4) ) {
						get_template_part( '/includes/background/fullscreenvideo', 'html5' );
					}
					//Youtube
					if (isSet($custom["pagemeta_youtubevideo"][0])) {
						$youtube_video=$custom["pagemeta_youtubevideo"][0];
					}
					if (isSet($youtube_video) ) {
						get_template_part( '/includes/background/fullscreenvideo', 'youtube' );
					}
				}
			break;
		}
	}
}
?>