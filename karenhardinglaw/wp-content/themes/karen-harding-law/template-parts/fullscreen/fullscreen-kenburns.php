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
if ( $featured_page <>"" ) { 

$filter_image_ids = kreativa_get_custom_attachments ( $featured_page );
kreativa_populate_slide_ui_colors($featured_page);
if ($filter_image_ids) {
?>
<div class="kenburns-preloader"></div>
<div id="kenburns-container">
<?php		
	// Loop through the images
	foreach ( $filter_image_ids as $attachment_id) {
		$attachment = get_post( $attachment_id );
		if (isSet($attachment->guid)) {
		$imageURI = $attachment->guid;
			echo kreativa_display_post_image (
				$post->ID,
				$have_image_url=$imageURI,
				$link=false,
				$type="full",
				$post->post_title,
				$class="kenburns-images"
			);
		}
	}
?>
</div>
<?php
// Static Titles and Description block
$static_description='';
$static_title='';
$static_link_text='';
$slideshow_link='';
$slideshow_title='';
$slideshow_caption='';
$fullscreen_infobox='';
$static_url='';
$slideshow_titledes="enable";
$custom = get_post_custom($featured_page);
if (isSet($custom["pagemeta_static_title"][0])) $static_title=$custom["pagemeta_static_title"][0];
if (isSet($custom["pagemeta_static_description"][0])) $static_description=$custom["pagemeta_static_description"][0];
if (isSet($custom["pagemeta_static_link_text"][0])) $static_link_text=$custom["pagemeta_static_link_text"][0];
if (isSet($custom["pagemeta_static_url"][0])) $static_url=$custom["pagemeta_static_url"][0];
if (isSet($custom["pagemeta_fullscreen_infobox"][0])) $fullscreen_infobox=$custom["pagemeta_fullscreen_infobox"][0];
if (isSet($custom["pagemeta_slideshow_titledesc"][0])) $slideshow_titledesc=$custom["pagemeta_slideshow_titledesc"][0];

$slideshow_no_description='';
if ( $static_description =='' ) {
	$slideshow_no_description = "slideshow_text_shift_up";
}
$slideshow_no_description_no_title='';
if ( $static_description =='' && $static_title =='' ) {
	$slideshow_no_description_no_title = "slideshow_text_shift_up";
}

$static_msg_display = false;

if ($static_link_text) $slideshow_link ='<div class="static_slideshow_content_link '.$slideshow_no_description_no_title.'"><a class="positionaware-button" href="'.esc_url($static_url).'">'. esc_attr($static_link_text) .'<span></span></a></div>';
	if ($static_title) $slideshow_title ='<h1 class="static_slideshow_title '.$slideshow_no_description.' slideshow_title_animation">'. esc_attr($static_title) .'</h1>';
if ($static_description) $slideshow_caption ='<div class="static_slideshow_caption">'. do_shortcode( $static_description ) .'</div>';

if ( $static_link_text != '' || $static_title != '' || $static_description != '' || $static_url != '' ) {
	$static_msg_display = true;
	if ( $slideshow_titledesc == "enable" ) {
			echo '<div id="static_slidecaption" class="slideshow-content-wrap">' .$slideshow_title . $slideshow_caption . $slideshow_link . '</div>';
	}
}
?>
<?php
get_template_part( '/template-parts/fullscreen/audio', 'player' );
// If Ends here for the Featured Page
}
}
?>
<?php
//End Password Check
}
?>
<?php get_footer(); ?>