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
$fullscreen_infobox='';
$custom = get_post_custom($featured_page);
if (isSet($custom["pagemeta_html5_poster"][0])) $html5_poster=$custom["pagemeta_html5_poster"][0];
if (isSet($custom["pagemeta_html5_mp4"][0])) $html5_mp4=$custom["pagemeta_html5_mp4"][0];
if (isSet($custom["pagemeta_html5_webm"][0])) $html5_webm=$custom["pagemeta_html5_webm"][0];
if (isSet($custom["pagemeta_html5_ogv"][0])) $html5_ogv=$custom["pagemeta_html5_ogv"][0];
if (isSet($custom["pagemeta_fullscreen_infobox"][0])) $fullscreen_infobox=$custom["pagemeta_fullscreen_infobox"][0];

$video_control_bar=kreativa_get_option_data('video_control_bar');
$fullscreen_menu_toggle=kreativa_get_option_data('fullscreen_menu_toggle');
$fullscreen_menu_toggle_nothome=kreativa_get_option_data('fullscreen_menu_toggle_nothome');
?>
<div id="backgroundvideo" class="html5-background-video">
<video autoplay loop id="videocontainer" class="video-js vjs-default-skin" preload="auto" width="100%" height="100%" poster="<?php echo esc_url($html5_poster); ?>">
	<source src="<?php echo esc_attr($html5_webm); ?>" type="video/webm">
	<source src="<?php echo esc_attr($html5_mp4); ?>" type="video/mp4">
	<source src="<?php echo esc_attr($html5_ogv); ?>" type="video/ogg">
</video>
</div>
<?php get_footer(); ?>