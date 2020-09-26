<?php
if (isset( $post->ID )) {
	$get_video_from_page_id= get_post_meta( $post->ID, 'pagemeta_video_bgfullscreenpost', true);
	$custom = get_post_custom($get_video_from_page_id);
}
if ( kreativa_page_is_woo_shop() ) {
	$woo_shop_post_id = get_option( 'woocommerce_shop_page_id' );
	$get_video_from_page_id= get_post_meta( $woo_shop_post_id, 'pagemeta_video_bgfullscreenpost', true);
	$custom = get_post_custom($get_video_from_page_id);
}
$featured_page=$get_video_from_page_id;
$fullscreen_eventbox='';
$custom = get_post_custom($featured_page);
if (isSet($custom["pagemeta_fullscreen_eventbox"][0])) $fullscreen_eventbox=$custom["pagemeta_fullscreen_eventbox"][0];
if (isSet($custom["pagemeta_youtubevideo"][0])) $youtube=$custom["pagemeta_youtubevideo"][0];

$pagemedia_is_background = true;
?>
<?php
// For mobile display fallback image instead of youtube as background.
// Fallback image is the featured image of fullscreen youtube post.
if ( !wp_is_mobile() && $pagemedia_is_background ) {
?>
<div id="backgroundvideo" class="youtube-fullscreen-background-player youtube-fullscreen-player" data-id="<?php echo esc_attr($youtube); ?>">
</div>
<?php
} else {
	if ( has_post_thumbnail()) :
		$fallback_image = kreativa_featured_image_link( $featured_page );
	 	?>
	 	<div id="backgroundvideo-fallback" style="background-image:url(<?php echo esc_url($fallback_image); ?>);"></div>
	 <?php
	 endif;	
}
?>