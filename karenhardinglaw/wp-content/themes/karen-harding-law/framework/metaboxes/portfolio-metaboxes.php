<?php
function kreativa_portfolio_metadata() {
	$mtheme_sidebar_options = kreativa_generate_sidebarlist("portfolio");
	
	$bg_slideshow_pages = get_posts('post_type=mtheme_featured&orderby=title&numberposts=-1&order=ASC');

	if ($bg_slideshow_pages) {
		$options_bgslideshow['none'] = "Not Selected";
		foreach($bg_slideshow_pages as $key => $list) {
			$custom = get_post_custom($list->ID);
			if ( isset($custom["fullscreen_type"][0]) ) { 
				$slideshow_type=$custom["fullscreen_type"][0]; 
			} else {
				$slideshow_type="";
			}
			if ($slideshow_type<>"Fullscreen-Video") {
				$options_bgslideshow[$list->ID] = $list->post_title;
			}
		}
	} else {
		$options_bgslideshow[0]="Featured pages not found.";
	}

	$mtheme_imagepath =  get_template_directory_uri() . '/framework/options/images/metaboxes/';
	$mtheme_imagepath_alt =  get_template_directory_uri() . '/framework/options/images/';

	$mtheme_portfolio_box = array(
		'id' => 'portfoliometa-box',
		'title' => esc_html__('Portfolio Metabox','kreativa'),
		'page' => 'page',
		'context' => 'normal',
		'priority' => 'core',
		'fields' => array(
			array(
				'name' => esc_html__('Portfolio Settings','kreativa'),
				'id' => 'pagemeta_portfolio_section_id',
				'type' => 'break',
				'sectiontitle' => esc_html__('Portfolio Settings','kreativa'),
				'std' => ''
				),
			array(
				'name' => esc_html__('Portfolio Options','kreativa'),
				'id' => 'pagemeta_sep_page_options',
				'type' => 'seperator',
				),
			array(
				'name' => esc_html__('Attach Images','kreativa'),
				'id' => 'pagemeta_image_attachments',
				'std' => esc_html__('Upload Images','kreativa'),
				'type' => 'image_gallery',
				'desc' => '<div class="metabox-note">'.esc_html__('Attach images to this page/post.','kreativa').'</div>'
				),
			array(
				'name' => esc_html__('Description for gallery thumbnail ( Portfolio Gallery )','kreativa'),
				'id' => 'pagemeta_thumbnail_desc',
				'type' => 'textarea',
				'desc' => esc_html__('This description is displayed below each thumbnail.','kreativa'),
				'std' => ''
				),
			array(
				'name' => esc_html__('Gallery thumbnail options','kreativa'),
				'id' => 'pagemeta_sep_page_options',
				'type' => 'seperator',
				),
			array(
				'name' => esc_html__('Gallery thumbnail link type','kreativa'),
				'id' => 'pagemeta_thumbnail_linktype',
				'type' => 'image',
				'std' => 'Lightbox',
				'desc' => esc_html__('Link type of portfolio image in portfolio galleries.','kreativa'),
				'options' => array(
					'Lightbox_DirectURL' => $mtheme_imagepath . 'portfolio-link-direct-lightbox.png',
					'Lightbox' => $mtheme_imagepath . 'portfolio-link-lightbox.png',
					'Customlink' => $mtheme_imagepath . 'portfolio-link-customlink.png',
					'DirectURL' => $mtheme_imagepath . 'portfolio-link-direct.png'
					)
				),
			array(
				'name' => esc_html__('Fill for Lightbox Video','kreativa'),
				'id' => 'pagemeta_lightbox_video',
				'heading' => 'subhead',
				'class'=> 'portfoliolinktype',
				'type' => 'text',
				'desc' => esc_html__('To display a Lightbox Video. Eg: http://www.youtube.com/watch?v=D78TYCEG4 , http://vimeo.com/172881','kreativa'),
				'std' => ''
				),
			array(
				'name' => esc_html__('Fill for Custom Link','kreativa'),
				'id' => 'pagemeta_customlink',
				'heading' => 'subhead',
				'class'=> 'portfoliolinktype',
				'type' => 'text',
				'desc' => esc_html__('For any link with full url','kreativa'),
				'std' => ''
				),
			array(
				'name' => esc_html__('Custom Thumbnail. (optional)','kreativa'),
				'id' => 'pagemeta_customthumbnail',
				'type' => 'upload',
				'target' => 'image',
				'desc' => esc_html__('Thumbnail URL.','kreativa'),
				'std' => ''
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
				'id' => 'pagemeta_header_section_id',
				'type' => 'break',
				'sectiontitle' => esc_html__('Page Settings','kreativa'),
				'std' => ''
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
					'0' => esc_html__('Transparent','kreativa'),
					'25' => esc_html__('25%','kreativa'),
					'50' => esc_html__('50%','kreativa'),
					'75' => esc_html__('75%','kreativa'),
					'100' => esc_html__('Opaque','kreativa')
				)
			)
		)
);
return $mtheme_portfolio_box;
}
add_action("admin_init", "kreativa_portfolioitemmetabox_init");
function kreativa_portfolioitemmetabox_init(){
	add_meta_box("mtheme_portfolioInfo-meta", esc_html__("Portfolio Options","kreativa"), "kreativa_portfolioitem_metaoptions", "mtheme_portfolio", "normal", "low");
}
/*
* Meta options for Portfolio post type
*/
function kreativa_portfolioitem_metaoptions(){
	$mtheme_portfolio_box = kreativa_portfolio_metadata();
	kreativa_generate_metaboxes($mtheme_portfolio_box,get_the_id());
}
?>