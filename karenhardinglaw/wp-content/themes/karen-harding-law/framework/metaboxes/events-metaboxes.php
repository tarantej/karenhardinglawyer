<?php
function kreativa_events_metadata() {
	$mtheme_imagepath =  get_template_directory_uri() . '/framework/options/images/metaboxes/';
	$mtheme_imagepath_alt =  get_template_directory_uri() . '/framework/options/images/';

	$mtheme_sidebar_options = kreativa_generate_sidebarlist("events");

	// Pull all the Featured into an array
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

	$mtheme_events_box = array(
		'id' => 'eventsmeta-box',
		'title' => esc_html__('Events Metabox','kreativa'),
		'page' => 'page',
		'context' => 'normal',
		'priority' => 'core',
		'fields' => array(
			array(
				'name' => esc_html__('Event Settings','kreativa'),
				'id' => 'pagemeta_events_section_id',
				'type' => 'break',
				'sectiontitle' => esc_html__('Events Settings','kreativa'),
				'std' => ''
			),
			array(
				'name' => esc_html__('Event Options','kreativa'),
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
				'name' => esc_html__('Gallery description text','kreativa'),
				'id' => 'pagemeta_thumbnail_desc',
				'heading' => 'subhead',
				'type' => 'textarea',
				'desc' => esc_html__('Description text to displayed with evernts gallery thumbnail','kreativa'),
				'std' => ''
			),
			array(
				'name' => esc_html__('Event Status','kreativa'),
				'id' => 'pagemeta_event_notice',
				'class' => 'event_notice',
				'type' => 'select',
				'desc' => esc_html__('Event Status','kreativa'),
				'options' => array(
					'active' => esc_html__('Active','kreativa'),
					'inactive' => esc_html__('Hide from Listings','kreativa'),
					'postponed' => esc_html__('Display as Postponed','kreativa'),
					'cancelled' => esc_html__('Display as Cancelled','kreativa'),
					'pastevent' => esc_html__('Past Event','kreativa')
					),
			),
			array(
				'name' => esc_html__('Event Date','kreativa'),
				'id' => 'pagemeta_event_startdate',
				'type' => 'datepicker',
				'class' => 'textsmall',
				'heading' => 'subhead',
				'desc' => esc_html__('Start date','kreativa'),
				'std' => ''
			),
			array(
				'name' => 'End Date',
				'id' => 'pagemeta_event_enddate',
				'type' => 'datepicker',
				'class' => 'textsmall',
				'heading' => 'subhead',
				'desc' => esc_html__('End date','kreativa'),
				'std' => ''
			),
			array(
				'name' => esc_html__('Venue','kreativa'),
				'id' => 'pagemeta_event_venue_name',
				'type' => 'text',
				'heading' => 'subhead',
				'desc' => esc_html__('Venue Name','kreativa'),
				'std' => ''
			),
			array(
				'name' => '',
				'id' => 'pagemeta_event_venue_street',
				'type' => 'text',
				'heading' => 'subhead',
				'desc' => esc_html__('Street','kreativa'),
				'std' => ''
			),
			array(
				'name' => '',
				'id' => 'pagemeta_event_venue_state',
				'type' => 'text',
				'class' => 'textsmall',
				'heading' => 'subhead',
				'desc' => esc_html__('State','kreativa'),
				'std' => ''
			),
			array(
				'name' => '',
				'id' => 'pagemeta_event_venue_postal',
				'type' => 'text',
				'class' => 'textsmall',
				'heading' => 'subhead',
				'desc' => esc_html__('Zip/Postal Code','kreativa'),
				'std' => ''
			),
			array(
				'name' => '',
				'id' => 'pagemeta_event_venue_country',
				'type' => 'country',
				'heading' => 'subhead',
				'desc' => esc_html__('Event country','kreativa'),
				'std' => ''
			),
			array(
				'name' => '',
				'id' => 'pagemeta_event_venue_phone',
				'type' => 'text',
				'class' => 'textsmall',
				'heading' => 'subhead',
				'desc' => esc_html__('Phone','kreativa'),
				'std' => ''
			),
			array(
				'name' => '',
				'id' => 'pagemeta_event_venue_website',
				'type' => 'text',
				'class' => 'textsmall',
				'heading' => 'subhead',
				'desc' => esc_html__('Website','kreativa'),
				'std' => ''
			),
			array(
				'name' => '',
				'id' => 'pagemeta_event_venue_currency',
				'type' => 'text',
				'class' => 'textsmall',
				'heading' => 'subhead',
				'desc' => esc_html__('Cost Currency Symbol','kreativa'),
				'std' => ''
			),
			array(
				'name' => '',
				'id' => 'pagemeta_event_venue_cost',
				'type' => 'text',
				'class' => 'textsmall',
				'heading' => 'subhead',
				'desc' => esc_html__('Cost Value','kreativa'),
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
				'id' => 'pagemeta_background_section_id',
				'type' => 'break',
				'sectiontitle' => esc_html__('Page Background','kreativa'),
				'std' => ''
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
	return $mtheme_events_box;
}
add_action("admin_init", "kreativa_eventsitemmetabox_init");
function kreativa_eventsitemmetabox_init(){
	add_meta_box("mtheme_eventsInfo-meta", esc_html__("Events Options","kreativa"), "kreativa_eventsitem_metaoptions", "mtheme_events", "normal", "low");
}
/*
* Meta options for Events post type
*/
function kreativa_eventsitem_metaoptions(){
	$mtheme_events_box = kreativa_events_metadata();
	kreativa_generate_metaboxes($mtheme_events_box,get_the_id());
}
?>