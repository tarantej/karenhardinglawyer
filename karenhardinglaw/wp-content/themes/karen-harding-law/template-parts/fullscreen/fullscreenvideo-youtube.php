<?php
$featured_page=kreativa_get_active_fullscreen_post();
if (defined('ICL_LANGUAGE_CODE')) { // WPML Specific
    $_type  = get_post_type($featured_page);
    $featured_page = icl_object_id($featured_page, $_type, true, ICL_LANGUAGE_CODE);
}
$fullscreen_infobox='';
$custom = get_post_custom($featured_page);
if (isSet($custom["pagemeta_fullscreen_infobox"][0])) $fullscreen_infobox=$custom["pagemeta_fullscreen_infobox"][0];
if (isSet($custom["pagemeta_youtubevideo"][0])) $youtube=$custom["pagemeta_youtubevideo"][0];
?>
<div id="backgroundvideo" class="youtube-fullscreen-player" data-id="<?php echo esc_attr($youtube); ?>">
</div>