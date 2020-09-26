<?php
if ( has_post_thumbnail() ) {
	echo '<div class="post-format-media">';

$posthead_size="kreativa-gridblock-full";
$single_height='';

$posthead_size="kreativa-gridblock-full";

$blogpost_style= get_post_meta($post->ID, 'pagemeta_pagestyle', true);
if ($blogpost_style == "nosidebar") {
	$posthead_size="kreativa-gridblock-full";
}

if (in_the_loop()) {
	$posthead_size="kreativa-gridblock-full";
}

$lightbox_status= get_post_meta($post->ID, 'pagemeta_meta_lightbox', true);
$image_link=kreativa_featured_image_link($post->ID);

$open_link = false;
if ($image_link<>"") {
	if ($lightbox_status=="enabled_lightbox") {
		echo '<a class="lightbox-active lightbox-image postformat-image-lightbox" data-src="'. esc_url( $image_link ) .'" href="'. esc_url( $image_link ) .'">';
		echo '<span class="lightbox-indicate"><i class="feather-icon-maximize"></i></span>';
		$open_link = true;
	} else {
		echo '<a href="'. esc_url( get_permalink() ) .'">';
		$open_link = true;
	}
}
echo kreativa_display_post_image (
	$post->ID,
	$have_image_url=false,
	$link=false,
	$type=$posthead_size,
	$post->post_title,
	$class="postformat-image" 
);
if ($open_link) {
	echo '</a>';
}
	echo '</div>';
}
?>