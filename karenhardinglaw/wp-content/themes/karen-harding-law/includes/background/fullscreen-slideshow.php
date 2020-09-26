<?php
/**
 * Supersized
 */
?>
<?php
if (isSet($post->ID)) {
	$bg_choice= get_post_meta($post->ID, 'pagemeta_meta_background_choice', true);
	if ($bg_choice=="options_slideshow") { 
		$theme_options_set_background_slideshow = kreativa_get_option_data('general_bgslideshow');
		$get_slideshow_from_page_id = $theme_options_set_background_slideshow;
	}
	if ($bg_choice=="image_attachments") { $get_slideshow_from_page_id = get_the_ID(); }
	if ($bg_choice=="image_featured") { $get_slideshow_from_page_id = get_the_ID(); }
}
if ( kreativa_page_is_woo_shop() ) {
	$woo_shop_post_id = get_option( 'woocommerce_shop_page_id' );
	$bg_choice= get_post_meta($woo_shop_post_id, 'pagemeta_meta_background_choice', true);
	if ($bg_choice=="options_slideshow") { 
		$theme_options_set_background_slideshow = kreativa_get_option_data('general_bgslideshow');
		$get_slideshow_from_page_id = $theme_options_set_background_slideshow;
	}
	if ($bg_choice=="image_attachments") { $get_slideshow_from_page_id = $woo_shop_post_id; }
	if ($bg_choice=="image_featured") { $get_slideshow_from_page_id = $woo_shop_post_id; }
}
$slideshow_pause_on_last=kreativa_get_option_data('slideshow_pause_on_last');
$slideshow_pause_hover=kreativa_get_option_data('slideshow_pause_hover');
$slideshow_random=kreativa_get_option_data('slideshow_random');
$slideshow_interval=kreativa_get_option_data('slideshow_interval');
$slideshow_transition=kreativa_get_option_data('slideshow_transition');
$slideshow_transition_speed=kreativa_get_option_data('slideshow_transition_speed');
$slideshow_portrait=kreativa_get_option_data('slideshow_portrait');
$slideshow_landscape=kreativa_get_option_data('slideshow_landscape');
$slideshow_fit_always=kreativa_get_option_data('slideshow_fit_always');
$slideshow_vertical_center=kreativa_get_option_data('slideshow_vertical_center');
$slideshow_horizontal_center=kreativa_get_option_data('slideshow_horizontal_center');
$fullscreen_menu_toggle=kreativa_get_option_data('fullscreen_menu_toggle');
$fullscreen_menu_toggle_nothome=kreativa_get_option_data('fullscreen_menu_toggle_nothome');
$rootpath= get_stylesheet_directory_uri();

if (! $slideshow_pause_on_last) $slideshow_pause_on_last=0;
if (! $slideshow_pause_hover) $slideshow_pause_hover=0;
if (! $slideshow_fit_always) $slideshow_fit_always=0;
if (! $slideshow_portrait) $slideshow_portrait=0;
if (! $slideshow_landscape) $slideshow_landscape=0;
if (! $slideshow_vertical_center) $slideshow_vertical_center=0;
if (! $slideshow_horizontal_center) $slideshow_horizontal_center=0;

$supersized_image_path = get_template_directory_uri() . '/images/supersized/';
$slideshow_thumbnails="";

$featured_linked=false;
$attatchmentURL="";
$postLink="";
$thelimit=-1;
$count=0;

// Static Titles and Description block
$static_description='';
$static_title='';
$static_link_text='';
$slideshow_link='';
$slideshow_title='';
$slideshow_caption='';
$static_url='';
$fullscreen_infobox='';
$slideshow_titledesc='enable';
$custom = get_post_custom($get_slideshow_from_page_id);
if (isSet($custom["pagemeta_static_title"][0])) $static_title=$custom["pagemeta_static_title"][0];
if (isSet($custom["pagemeta_static_description"][0])) $static_description=$custom["pagemeta_static_description"][0];
if (isSet($custom["pagemeta_static_link_text"][0])) $static_link_text=$custom["pagemeta_static_link_text"][0];
if (isSet($custom["pagemeta_static_url"][0])) $static_url=$custom["pagemeta_static_url"][0];
if (isSet($custom["pagemeta_fullscreen_infobox"][0])) $fullscreen_infobox=$custom["pagemeta_fullscreen_infobox"][0];
if (isSet($custom["pagemeta_slideshow_titledesc"][0])) $slideshow_titledesc=$custom["pagemeta_slideshow_titledesc"][0];

$pagemedia_is_background = true;

$slideshow_no_description='';
if ( $static_description =='' ) {
	$slideshow_no_description = "slideshow_text_shift_up";
}
$slideshow_no_description_no_title='';
if ( $static_description =='' && $static_title =='' ) {
	$slideshow_no_description_no_title = "slideshow_text_shift_up";
}

$static_msg_display = false;
?>