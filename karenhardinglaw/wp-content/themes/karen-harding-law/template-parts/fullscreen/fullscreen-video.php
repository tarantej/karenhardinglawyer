<?php
/**
 * Fullscreen Video
 */
get_header();
$featured_page=kreativa_get_active_fullscreen_post();
if (defined('ICL_LANGUAGE_CODE')) { // this is to not break code in case WPML is turned off, etc.
    $_type  = get_post_type($featured_page);
    $featured_page = icl_object_id($featured_page, $_type, true, ICL_LANGUAGE_CODE);
}
$custom = get_post_custom($featured_page);
if (isSet($custom["pagemeta_youtubevideo"][0])) $youtube=$custom["pagemeta_youtubevideo"][0];
if (isSet($custom["pagemeta_vimeovideo"][0])) $vimeoID=$custom["pagemeta_vimeovideo"][0];
if (isSet($custom["pagemeta_html5_mp4"][0])) $html5_mp4=$custom["pagemeta_html5_mp4"][0];
if (isSet($custom["pagemeta_html5_wemb"][0])) $html5_wemb=$custom["pagemeta_html5_wemb"][0];

$video_control_bar=kreativa_get_option_data('video_control_bar');
$fullscreen_menu_toggle=kreativa_get_option_data('fullscreen_menu_toggle');
$fullscreen_menu_toggle_nothome=kreativa_get_option_data('fullscreen_menu_toggle_nothome');

if ( post_password_required($featured_page) ) {
	get_template_part( 'password', 'box' );
	} else {
?>
<?php
$vimeo_active=false;
$youtube_active=false;
$html5_active=false;
// Play Youtube and Other Video files
if (isSet($youtube) && !empty($youtube) && !$vimeo_active) {
	$youtube_active=true;
	get_template_part('/template-parts/fullscreen/fullscreenvideo','youtube');
}
if (isSet($html5_mp4) || isSet($html5_mp4)) {
	if (!$vimeo_active && !$youtube_active) {
		$html5_active=true;
		get_template_part('/template-parts/fullscreen/fullscreenvideo','html5');
	}
}
//End password check wrap
}
?>
<?php get_footer(); ?>