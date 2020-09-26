<?php
/**
 * Fullscreen Video
 */
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
if (isSet($custom["pagemeta_html5_poster"][0])) $html5_poster=$custom["pagemeta_html5_poster"][0];
if (isSet($custom["pagemeta_html5_mp4"][0])) $html5_mp4=$custom["pagemeta_html5_mp4"][0];
if (isSet($custom["pagemeta_html5_webm"][0])) $html5_webm=$custom["pagemeta_html5_webm"][0];
if (isSet($custom["pagemeta_html5_ogv"][0])) $html5_ogv=$custom["pagemeta_html5_ogv"][0];

$video_control_bar=kreativa_get_option_data('video_control_bar');

$pagemedia_is_background = true;
?>
<?php
// For mobile display fallback image instead.
// Fallback image is the featured image of fullscreen post.
if ( !wp_is_mobile() && $pagemedia_is_background ) {
?>
<div id="backgroundvideo" class="html5-background-video">
<video loop id="videocontainer" class="video-js vjs-default-skin" preload="auto" width="100%" height="100%" poster="<?php echo esc_url($html5_poster); ?>">
	<source src="<?php echo esc_attr($html5_webm); ?>" type="video/webm">
	<source src="<?php echo esc_attr($html5_mp4); ?>" type="video/mp4">
	<source src="<?php echo esc_attr($html5_ogv); ?>" type="video/ogg">
</video>
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