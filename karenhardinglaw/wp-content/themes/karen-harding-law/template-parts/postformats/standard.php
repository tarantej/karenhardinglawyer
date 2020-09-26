<?php
if ( has_post_thumbnail() ) {
	echo '<div class="post-format-media">';

	global $mtheme_pagelayout_type;
	$single_height='';
	$posthead_size="kreativa-gridblock-full";

	$blogpost_style= get_post_meta($post->ID, 'pagemeta_pagestyle', true);
	if ($blogpost_style == "nosidebar") {
		$posthead_size="kreativa-gridblock-full";
	}

	if ( $mtheme_pagelayout_type=="fullwidth" ) {
		$posthead_size="kreativa-gridblock-full";
	}

	if ( $mtheme_pagelayout_type=="two-column" ) {
		$posthead_size="kreativa-gridblock-full";
	}

	if (in_the_loop()) {
		$posthead_size="kreativa-gridblock-full";
	}

	echo '<a class="postsummaryimage" href="'. esc_url( get_permalink() ) .'">';
	// Show Image	
	echo kreativa_display_post_image (
		$post->ID,
		$have_image_url=false,
		$link=false,
		$type=$posthead_size,
		$post->post_title,
		$class="" 
	);
	echo '</a>';
	echo '</div>';
}
?>