<div class="post-format-media">
<?php
$posthead_size="kreativa-gridblock-full";

$posthead_size="kreativa-gridblock-full";

$blogpost_style= get_post_meta($post->ID, 'pagemeta_pagestyle', true);
if ($blogpost_style == "nosidebar") {
	$posthead_size="kreativa-gridblock-full";
}
if (in_the_loop()) {
	$posthead_size="kreativa-gridblock-full";
}

$height= get_post_meta($post->ID, 'pagemeta_meta_gallery_height', true);

if ( shortcode_exists( 'slideshowcarousel' ) ) {
	echo do_shortcode('[slideshowcarousel thumbnails="false" lightbox="true" title="true" imagesize='.$posthead_size.']');
}
?>
</div>