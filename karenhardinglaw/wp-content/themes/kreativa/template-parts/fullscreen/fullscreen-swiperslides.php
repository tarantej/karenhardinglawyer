<?php
/**
 * Carousel
 */
get_header();
$carousel_text='';
$slideshow_titledesc='enable';
$featured_page=kreativa_get_active_fullscreen_post();
if (defined('ICL_LANGUAGE_CODE')) { // this is to not break code in case WPML is turned off, etc.
    $_type  = get_post_type($featured_page);
    $featured_page = icl_object_id($featured_page, $_type, true, ICL_LANGUAGE_CODE);
}
$custom = get_post_custom($featured_page);
if ( isSet($custom[ "pagemeta_carousel_text"][0]) ) {
	$carousel_text = $custom[ "pagemeta_carousel_text"][0];
}
if (isSet($custom["pagemeta_slideshow_titledesc"][0])) $slideshow_titledesc=$custom["pagemeta_slideshow_titledesc"][0];

$count=0;
if ( post_password_required($featured_page) ) {
	get_template_part( 'password', 'box' );
} else {
// Don't Populate list if no Featured page is set
//The Image IDs
if ( $featured_page <>"" ) { 

$filter_image_ids = kreativa_get_custom_attachments ( $featured_page );
if ($filter_image_ids) {
	$count=0;
	$captions='';
	$carousel='';
?>
<!-- Slider main container -->
<div class="swiper-container">
    <!-- Additional required wrapper -->
    <div class="swiper-wrapper">
    <!-- Slides -->
<?php		
	// Loop through the images
	foreach ( $filter_image_ids as $attachment_id) {
		$attachment = get_post( $attachment_id );
		if (isSet($attachment->ID)) {
			$imageURI = $attachment->guid;
			$thumb_imagearray = wp_get_attachment_image_src( $attachment->ID , 'kreativa-gridblock-full', false);
			$thumb_imageURI = $thumb_imagearray[0];

			$imageTitle = apply_filters('the_title',$attachment->post_title);
			$imageDesc = apply_filters('the_content',$attachment->post_content);

			$link_text = ''; $link_url = ''; $slideshow_link = ''; $slideshow_color='';
			$link_text = get_post_meta( $attachment->ID, 'mtheme_attachment_fullscreen_link', true );
			$link_url = get_post_meta( $attachment->ID, 'mtheme_attachment_fullscreen_url', true );
			$slide_color = get_post_meta( $attachment->ID, 'mtheme_attachment_fullscreen_color', true );

			if ( !isSet($slide_color) || $slide_color=="") {
				$slide_color="bright";
			}

			if ($thumb_imageURI<>"") {
				$count++;

		        echo '<div class="swiper-slide slide-color-'.$slide_color.'" style="background-image: url('.esc_url($thumb_imageURI).'); background-size: cover; background-position: 50% 0%;">';
		        if ($slideshow_titledesc=="enable") {
		        	echo '<div class="swiper-contents">';
				        echo '<div class="swiper-title">' . $imageTitle . '</div>';
				        echo '<div class="swiper-desc">' . $imageDesc . '</div>';
			        if ($slide_color=="dark") {
			        	$button_color = "bright";
			        } else {
			        	$button_color = "dark";
			        }
			        if ($link_url<>"" && $link_text<>"") {
						echo '<div class="button-shortcode '.$button_color.'"><a title="" href="'.esc_url($link_url).'"><div class="mtheme-button">'. esc_attr($link_text) .'</div></a></div>';
					}
					echo '</div>';
				}
		        echo '</div>';
			}
		}
	}
?>
    </div>
    <?php if ($count>4) { ?>
    <!-- If we need navigation buttons -->
    <div class="swiper-button-prev"><i class="feather-icon-arrow-left"></i></div>
    <div class="swiper-button-next"><i class="feather-icon-arrow-right"></i></div>
    <?php } ?>
</div>
<?php
// If Ends here for the Featured Page
}
}
?>
<?php
//End Password Check
}
?>
<?php get_footer(); ?>