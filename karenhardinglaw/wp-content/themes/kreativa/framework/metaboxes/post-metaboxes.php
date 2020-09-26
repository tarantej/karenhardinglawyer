<?php
function kreativa_post_metadata() {
	$mtheme_sidebar_options = kreativa_generate_sidebarlist("post");

	$mtheme_imagepath =  get_template_directory_uri() . '/framework/options/images/metaboxes/';

	$mtheme_post_metapack=array();

	$mtheme_post_metapack['main'] = array(
		'id' => 'common-pagemeta-box',
		'title' => esc_html__('General Page Metabox','kreativa'),
		'page' => 'post',
		'context' => 'normal',
		'priority' => 'core',
		'fields' => array(
			array(
				'name' => esc_html__('Page Settings','kreativa'),
				'id' => 'pagemeta_page_section_id',
				'type' => 'break',
				'sectiontitle' => esc_html__('Page Settings','kreativa'),
				'std' => ''
				),
			array(
				'name' => esc_html__('Attach Images','kreativa'),
				'id' => 'pagemeta_image_attachments',
				'std' => esc_html__('Upload Images','kreativa'),
				'type' => 'image_gallery',
				'desc' => '<div class="metabox-note">'.esc_html__('Attach images to this page/post.','kreativa').'</div>'
				),
			array(
				'name' => esc_html__('Author Bio','kreativa'),
				'id' => 'pagemeta_post_authorbio',
				'std' => 'rightsidebar',
				'desc' => esc_html__('Display Author Bio','kreativa'),
				'type' => 'select',
				'options' => array(
					'default' => esc_html__('Theme options default','kreativa'),
					'activate' => esc_html__('Activate','kreativa'),
					'disable' => esc_html__('Disable','kreativa')
					)
				),
			array(
				'name' => esc_html__('Page Settings','kreativa'),
				'id' => 'pagemeta_page_section_id',
				'type' => 'break',
				'sectiontitle' => esc_html__('Page Settings','kreativa'),
				'std' => ''
				),
			array(
				'name' => esc_html__('Page Layout','kreativa'),
				'id' => 'pagemeta_sep_page_options',
				'type' => 'seperator',
				),
			array(
				'name' => esc_html__('Page Style','kreativa'),
				'id' => 'pagemeta_pagestyle',
				'type' => 'image',
				'std' => 'rightsidebar',
				'desc' => esc_html__('Note: Edge to Edge - same as 100% Width Template','kreativa'),
				'options' => array(
					'rightsidebar' => $mtheme_imagepath . 'page-right-sidebar.png',
					'leftsidebar' => $mtheme_imagepath . 'page-left-sidebar.png',
					'nosidebar' => $mtheme_imagepath . 'page-no-sidebar.png',
					'edge-to-edge' => $mtheme_imagepath . 'page-edge-to-edge.png')
				),
			array(
				'name' => esc_html__('Choice of Sidebar','kreativa'),
				'id' => 'pagemeta_sidebar_choice',
				'type' => 'select',
				'desc' => esc_html__('For Sidebar Active Pages and Posts','kreativa'),
				'options' => $mtheme_sidebar_options
				),
			array(
				'name' => esc_html__('Page Settings','kreativa'),
				'id' => 'pagemeta_page_title_seperator',
				'type' => 'seperator',
				),
			array(
				'name' => esc_html__('Switch Menu','kreativa'),
				'id' => 'pagemeta_menu_choice',
				'type' => 'select',
				'desc' => esc_html__('Select a different menu for this page','kreativa'),
				'options' => kreativa_generate_menulist()
				),
			array(
				'name' => esc_html__('Page Title','kreativa'),
				'id' => 'pagemeta_page_title',
				'type' => 'select',
				'desc' => esc_html__('Page Title','kreativa'),
				'std' => 'default',
				'options' => array(
					'default' => esc_html__('Default','kreativa'),
					'show' => esc_html__('Show','kreativa'),
					'hide' => esc_html__('Hide','kreativa')
					)
				),
			array(
				'name' => esc_html__('Page Background','kreativa'),
				'id' => 'pagemeta_sep-page_backgrounds',
				'type' => 'seperator',
				),
			array(
				'name' =>  esc_html__('Display Page Media','kreativa'),
				'id' => 'pagemeta_meta_background_choice',
				'type' => 'select',
				'target' => 'backgroundslideshow_choices',
				'desc' => '<div class="metabox-note">'.esc_html__('Attach 1 image to display one image or Multiples images to display slideshow','kreativa').'</div>',
				'options' => ''
			),
			array(
				'name' => esc_html__('Page Media using Fullscreen Video Post','kreativa'),
				'id' => 'pagemeta_video_bgfullscreenpost',
				'type' => 'select',
				'target' => 'fullscreen_video_bg',
				'desc' => '<div class="metabox-note">'.esc_html__('Based on Display media choice','kreativa').'</div>',
				'options' => ''
			),
			array(
				'name' => esc_html__('Page Color','kreativa'),
				'id' => 'pagemeta_pagebackground_color',
				'type' => 'color',
				'desc' => esc_html__('Page color','kreativa'),
				'std' => ''
				),
			array(
				'name' => esc_html__('Page Opacity','kreativa'),
				'id' => 'pagemeta_pagebackground_opacity',
				'type' => 'select',
				'desc' => esc_html__('Set Page color and adjust opacity to apply opacity.','kreativa'),
				'std' => 'default',
				'options' => array(
					'default' => esc_html__('Default','kreativa'),
					'zero' => esc_html__('Transparent','kreativa'),
					'25' => esc_html__('25%','kreativa'),
					'50' => esc_html__('50%','kreativa'),
					'75' => esc_html__('75%','kreativa'),
					'100' => esc_html__('Opaque','kreativa')
				)
			)
		)
);

$mtheme_post_metapack['video'] = array(
	'id' => 'video-meta-box',
	'title' => esc_html__('Video Metabox','kreativa'),
	'page' => 'post',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => esc_html__('HTML5 Video','kreativa'),
			'id' => 'pagemeta_video_meta_section1_id',
			'type' => 'break',
			'sectiontitle' => esc_html__('HTML5 Video','kreativa'),
			'std' => ''
			),
		array(
			'name' => esc_html__('M4V File URL','kreativa'),
			'id' => 'pagemeta_video_m4v_file',
			'type' => 'text',
			'std' => '',
			'desc' => esc_html__('Enter M4V File URL ( Required )','kreativa')
			),
		array(
			'name' => esc_html__('OGV File URL','kreativa'),
			'id' => 'pagemeta_video_ogv_file',
			'type' => 'text',
			'std' => '',
			'desc' => esc_html__('Enter OGV File URL','kreativa')
			),
		array(
			'name' => esc_html__('Poster Image','kreativa'),
			'id' => 'pagemeta_video_poster_file',
			'type' => 'upload',
			'target' => 'image',
			'std' => '',
			'desc' => esc_html__('Poster Image','kreativa')
			),
		array(
			'name' => esc_html__('Video Hosts','kreativa'),
			'id' => 'pagemeta_video_meta_section2_id',
			'type' => 'break',
			'std' => '',
			'sectiontitle' => esc_html__('Video Hosts','kreativa')
			),
		array(
			'name' => esc_html__('Youtube Video ID','kreativa'),
			'id' => 'pagemeta_video_youtube_id',
			'type' => 'text',
			'std' => '',
			'desc' => esc_html__('Youtube video ID','kreativa')
			),
		array(
			'name' => esc_html__('Vimeo Video ID','kreativa'),
			'id' => 'pagemeta_video_vimeo_id',
			'type' => 'text',
			'std' => '',
			'desc' => esc_html__('Vimeo video ID','kreativa')
			),
		array(
			'name' => esc_html__('Daily Motion Video ID','kreativa'),
			'id' => 'pagemeta_video_dailymotion_id',
			'type' => 'text',
			'std' => '',
			'desc' => esc_html__('Daily Motion video ID','kreativa')
			),
		array(
			'name' => esc_html__('Google Video ID','kreativa'),
			'id' => 'pagemeta_video_google_id',
			'type' => 'text',
			'std' => '',
			'desc' => esc_html__('Google video ID','kreativa')
			),
		array(
			'name' => esc_html__('Video Embed Code','kreativa'),
			'id' => 'pagemeta_video_embed_code',
			'type' => 'textarea',
			'std' => '',
			'desc' => esc_html__('Video Embed code. You can grab embed codes from hosted video sites.','kreativa')
			)
		)
	);

$mtheme_post_metapack['audio'] = array(
	'id' => 'audio-meta-box',
	'title' => esc_html__('Audio Metabox','kreativa'),
	'page' => 'post',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => esc_html__('Audio Embed code','kreativa'),
			'id' => 'pagemeta_audio_meta_section1_id',
			'type' => 'break',
			'sectiontitle' => esc_html__('Audio Embed code','kreativa'),
			'std' => ''
			),
		array(
			'name' => esc_html__('Audio Embed code','kreativa'),
			'id' => 'pagemeta_audio_embed',
			'type' => 'textarea',
			'std' => '',
			'desc' => esc_html__('eg. Soundcloud embed code','kreativa')
			),
		array(
			'name' => esc_html__('HTML5 Audio','kreativa'),
			'id' => 'pagemeta_audio_meta_section2_id',
			'type' => 'break',
			'sectiontitle' => esc_html__('HTML5 Audio','kreativa'),
			'std' => ''
			),
		array(
			'name' => esc_html__('MP3 file','kreativa'),
			'id' => 'pagemeta_meta_audio_mp3',
			'type' => 'text',
			'std' => '',
			'desc' => esc_html__('Please provide full url. eg. http://www.domain.com/path/audiofile.mp3','kreativa')
			),
		array(
			'name' => esc_html__('M4A file','kreativa'),
			'id' => 'pagemeta_meta_audio_m4a',
			'type' => 'text',
			'std' => '',
			'desc' => esc_html__('Please provide full url. eg. <code>http://www.domain.com/path/audiofile.m4a','kreativa')
			),
		array(
			'name' => esc_html__('OGA file','kreativa'),
			'id' => 'pagemeta_meta_audio_ogg',
			'type' => 'text',
			'std' => '',
			'desc' => esc_html__('Please provide full url. eg. http://www.domain.com/path/audiofile.ogg','kreativa')
			)
		)
	);

$mtheme_post_metapack['link'] = array(
	'id' => 'link-meta-box',
	'title' => esc_html__('Link Metabox','kreativa'),
	'page' => 'post',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => esc_html__('Link URL','kreativa'),
			'id' => 'pagemeta_meta_link',
			'type' => 'text',
			'std' => '',
			'desc' => esc_html__('Please provide full url. eg. http://www.domain.com/path/','kreativa')
			)
		)
	);

$mtheme_post_metapack['image'] = array(
	'id' => 'image-meta-box',
	'title' => esc_html__('Image Metabox','kreativa'),
	'page' => 'post',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => esc_html__('Enable Lightbox','kreativa'),
			'id' => 'pagemeta_meta_lightbox',
			'type' => 'select',
			'options' => array(
				'enabled_lightbox' => esc_html__('Enable Lightbox','kreativa'),
				'disable_lightbox' => esc_html__('Disable Lighbox','kreativa')
				)
			)
		)
	);

$mtheme_post_metapack['quote'] = array(
	'id' => 'quote-meta-box',
	'title' => esc_html__('Quote Metabox','kreativa'),
	'page' => 'post',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => esc_html__('Quote','kreativa'),
			'id' => 'pagemeta_meta_quote',
			'type' => 'textarea',
			'std' => '',
			'desc' => esc_html__('Enter quote here','kreativa')
			),
		array(
			'name' => esc_html__('Author','kreativa'),
			'id' => 'pagemeta_meta_quote_author',
			'type' => 'text',
			'std' => '',
			'desc' => esc_html__('Author','kreativa')
			)
		)
	);
return $mtheme_post_metapack;
}
add_action('admin_init', 'kreativa_add_boxes');

// Add meta box
function kreativa_add_boxes() {
	$mtheme_post_metapack = kreativa_post_metadata();
	add_meta_box($mtheme_post_metapack['main']['id'], $mtheme_post_metapack['main']['title'], 'kreativa_common_show_box', $mtheme_post_metapack['main']['page'], $mtheme_post_metapack['main']['context'], $mtheme_post_metapack['main']['priority']);
	add_meta_box($mtheme_post_metapack['video']['id'], $mtheme_post_metapack['video']['title'], 'kreativa_video_show_box', $mtheme_post_metapack['video']['page'], $mtheme_post_metapack['video']['context'], $mtheme_post_metapack['video']['priority']);
	add_meta_box($mtheme_post_metapack['link']['id'], $mtheme_post_metapack['link']['title'], 'kreativa_link_show_box', $mtheme_post_metapack['link']['page'], $mtheme_post_metapack['link']['context'], $mtheme_post_metapack['link']['priority']);
	add_meta_box($mtheme_post_metapack['image']['id'], $mtheme_post_metapack['image']['title'], 'kreativa_image_show_box', $mtheme_post_metapack['image']['page'], $mtheme_post_metapack['image']['context'], $mtheme_post_metapack['image']['priority']);
	add_meta_box($mtheme_post_metapack['quote']['id'], $mtheme_post_metapack['quote']['title'], 'kreativa_quote_show_box', $mtheme_post_metapack['quote']['page'], $mtheme_post_metapack['quote']['context'], $mtheme_post_metapack['quote']['priority']);
	add_meta_box($mtheme_post_metapack['audio']['id'], $mtheme_post_metapack['audio']['title'], 'kreativa_audio_show_box', $mtheme_post_metapack['audio']['page'], $mtheme_post_metapack['audio']['context'], $mtheme_post_metapack['audio']['priority']);
}

// Callback function to show fields in meta box
function kreativa_video_show_box() {
	$mtheme_post_metapack = kreativa_post_metadata();
	$mtheme_video_meta_box = $mtheme_post_metapack['video'];
	kreativa_generate_metaboxes($mtheme_video_meta_box, get_the_id() );
}

function kreativa_audio_show_box() {
	$mtheme_post_metapack = kreativa_post_metadata();
	$mtheme_audio_meta_box = $mtheme_post_metapack['audio'];
	kreativa_generate_metaboxes($mtheme_audio_meta_box, get_the_id() );
}

function kreativa_common_show_box() {
	$mtheme_post_metapack = kreativa_post_metadata();
	$mtheme_common_meta_box = $mtheme_post_metapack['main'];
	kreativa_generate_metaboxes($mtheme_common_meta_box,get_the_id());
}

function kreativa_link_show_box() {
	$mtheme_post_metapack = kreativa_post_metadata();
	$mtheme_link_meta_box = $mtheme_post_metapack['link'];
	kreativa_generate_metaboxes($mtheme_link_meta_box, get_the_id() );
}

function kreativa_image_show_box() {
	$mtheme_post_metapack = kreativa_post_metadata();
	$mtheme_image_meta_box = $mtheme_post_metapack['image'];
	kreativa_generate_metaboxes($mtheme_image_meta_box, get_the_id() );
}

function kreativa_quote_show_box() {
	$mtheme_post_metapack = kreativa_post_metadata();
	$mtheme_quote_meta_box = $mtheme_post_metapack['quote'];
	kreativa_generate_metaboxes($mtheme_quote_meta_box, get_the_id() );
}
?>