<?php
function kreativa_proofing_metadata() {
	$mtheme_sidebar_options = kreativa_generate_sidebarlist("proofing");

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

	$client_names = get_posts('post_type=mtheme_clients&orderby=title&numberposts=-1&order=ASC');
	if ($client_names) {
		$options_client_names['none'] = "Not Selected";
		foreach($client_names as $key => $list) {
			$custom = get_post_custom($list->ID);
			$options_client_names[$list->ID] = $list->post_title;
		}
	} else {
		$options_client_names[0]="Featured pages not found.";
	}

	$mtheme_imagepath =  get_template_directory_uri() . '/framework/options/images/metaboxes/';
	$mtheme_imagepath_alt =  get_template_directory_uri() . '/framework/options/images/';

	$mtheme_proofing_box = array(
		'id' => 'proofingmeta-box',
		'title' => esc_html__('Proofing Metabox','kreativa'),
		'page' => 'page',
		'context' => 'normal',
		'priority' => 'core',
		'fields' => array(
			array(
				'name' => esc_html__('Proofing Settings','kreativa'),
				'id' => 'pagemeta_proofing_section_id',
				'type' => 'break',
				'sectiontitle' => esc_html__('Proofing Settings','kreativa'),
				'std' => ''
				),
			array(
				'name' => esc_html__('Attach Images','kreativa'),
				'id' => 'pagemeta_image_attachments',
				'std' => esc_html__('Upload Images','kreativa'),
				'type' => 'image_gallery',
				'desc' => '<div class="metabox-note">'.esc_html__('Attach images for proofing.','kreativa').'</div>'
				),
			array(
				'name' => __('Proofing: Selected images and filenames','mthemelocal'),
				'id' => 'pagemeta_selected_proofing_images',
				'std' => '',
				'type' => 'selected_proofing_images',
				'desc' => __('<div class="metabox-note">Use to locate images from a large collection.</div>','mthemelocal')
			),
			array(
				'name' => esc_html__('Proofing Grid Columns','kreativa'),
				'id' => 'pagemeta_proofing_column',
				'type' => 'select',
				'desc' => esc_html__('Page opacity','kreativa'),
				'std' => 'default',
				'options' => array(
					'4' => esc_html__('4','kreativa'),
					'3' => esc_html__('3','kreativa'),
					'2' => esc_html__('2','kreativa'),
					'1' => esc_html__('1','kreativa')
				)
			),
			array(
				'name' => esc_html__('Proofing Grid Format','kreativa'),
				'id' => 'pagemeta_proofing_format',
				'type' => 'select',
				'desc' => esc_html__('Page opacity','kreativa'),
				'std' => 'default',
				'options' => array(
					'landscape' => esc_html__('Landscape','kreativa'),
					'masonary' => esc_html__('Masonry','kreativa'),
					'portrait' => esc_html__('Portrait','kreativa')
				)
			),
			array(
				'name' => esc_html__('Assign a Client','kreativa'),
				'id' => 'pagemeta_client_names',
				'type' => 'select',
				'target' => 'client_names',
				'desc' => '<div class="metabox-note">'.esc_html__('Note :Select client PhotoProofing is for.','kreativa').'</div>',
				'options' => ''
				),
			array(
				'name' => esc_html__('Proofing Status','kreativa'),
				'id' => 'pagemeta_proofing_status',
				'class' => 'proofing_status',
				'type' => 'select',
				'desc' => esc_html__('Proofing Status','kreativa'),
				'options' => array(
					'active' => esc_html__('Active','kreativa'),
					'lock' => esc_html__('Lock','kreativa'),
					'download' => esc_html__('Locked for Download','kreativa'),
					'inactive' => esc_html__('Disable','kreativa')
					),
				),
			array(
				'name' => esc_html__('Proofing Date','kreativa'),
				'id' => 'pagemeta_proofing_startdate',
				'type' => 'datepicker',
				'class' => 'textsmall',
				'heading' => 'subhead',
				'desc' => esc_html__('Start date','kreativa'),
				'std' => ''
				),
			array(
				'name' => esc_html__('Location','kreativa'),
				'id' => 'pagemeta_proofing_location',
				'type' => 'text',
				'heading' => 'subhead',
				'desc' => esc_html__('Location','kreativa'),
				'std' => ''
				),
			array(
				'name' => esc_html__('Download Link','kreativa'),
				'id' => 'pagemeta_proofing_download',
				'type' => 'text',
				'class' => 'textsmall',
				'heading' => 'subhead',
				'desc' => esc_html__('Zipped link for client image download','kreativa'),
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
				'desc' => esc_html__('Set Page background color and adjust opacity to apply opacity.','kreativa'),
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
return $mtheme_proofing_box;
}
add_action("admin_init", "kreativa_proofingitemmetabox_init");
function kreativa_proofingitemmetabox_init(){
	add_meta_box("kreativa_proofingInfo-meta", esc_html__("Proofing Options","kreativa"), "kreativa_proofingitem_metaoptions", "mtheme_proofing", "normal", "low");
}
/*
* Meta options for Proofing post type
*/
function kreativa_proofingitem_metaoptions(){
	$mtheme_proofing_box = kreativa_proofing_metadata();
	kreativa_generate_metaboxes($mtheme_proofing_box,get_the_id());
}
?>