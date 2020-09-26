<?php
/**
 * Kenburns
 */
get_header();
$featured_page = kreativa_get_active_fullscreen_post();
if (defined('ICL_LANGUAGE_CODE')) { // this is to not break code in case WPML is turned off, etc.
    $_type  = get_post_type($featured_page);
    $featured_page = icl_object_id($featured_page, $_type, true, ICL_LANGUAGE_CODE);
}
$count=0;
if ( post_password_required($featured_page) ) {
	get_template_part( 'password', 'box' );
} else {
// Don't Populate list if no Featured page is set
//The Image IDs
$custom = get_post_custom($featured_page);
$slideshow_titledesc='';
if (isSet($custom["pagemeta_fotorama_fill"][0])) {
	$fotorama_fill=$custom["pagemeta_fotorama_fill"][0];
}
if (isSet($custom["pagemeta_slideshow_titledesc"][0])) $slideshow_titledesc=$custom["pagemeta_slideshow_titledesc"][0];
if ($slideshow_titledesc<>"enable") {
	$slideshow_titledesc="disabled";
}
if ( $featured_page <>"" ) { 

$filter_image_ids = kreativa_get_custom_attachments ( $featured_page );
kreativa_populate_slide_ui_colors($featured_page);
if ($filter_image_ids) {
?>
<div id="fotorama-container-wrap">
<?php
echo do_shortcode('[fotorama titledesc="'.$slideshow_titledesc.'" filltype="'.$fotorama_fill.'" pageid='.$featured_page.']');
?>
</div>
<?php
}
}
//End Password Check
}
?>
<?php get_footer(); ?>