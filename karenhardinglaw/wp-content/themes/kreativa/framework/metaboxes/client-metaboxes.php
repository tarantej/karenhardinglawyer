<?php
function kreativa_client_metadata() {

	$mtheme_sidebar_options = kreativa_generate_sidebarlist("client");

	require_once( get_template_directory() . '/framework/options/google-fonts.php');
	$options_fonts = kreativa_google_fonts();

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

	$mtheme_imagepath =  get_template_directory_uri() . '/framework/options/images/metaboxes/';
	$mtheme_imagepath_alt =  get_template_directory_uri() . '/framework/options/images/';

	$mtheme_client_box = array(
		'id' => 'clientmeta-box',
		'title' => esc_html__('Client Metabox','kreativa'),
		'page' => 'page',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Client Settings','kreativa'),
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
				'desc' => '<div class="metabox-note">'.esc_html__('Attach images. Images can be used to generate fullscreen slideshows using Page settings.','kreativa').'</div>'
				),
			array(
				'name' => esc_html__('Client Notice','kreativa'),
				'id' => 'pagemeta_client_notice',
				'type' => 'notice',
				'std' => '',
				'desc' => esc_html__('Add a Password to this client page to password protect all proofing galleries associated with the client.','kreativa')
				),
			array(
				'name' => esc_html__('Client Name','kreativa'),
				'id' => 'pagemeta_client_name',
				'type' => 'text',
				'desc' => esc_html__('Client Name.','kreativa'),
				'std' => ''
				),
			array(
				'name' => esc_html__('Description for client','kreativa'),
				'id' => 'pagemeta_client_desc',
				'type' => 'textarea',
				'desc' => esc_html__('This description is displayed for client.','kreativa'),
				'std' => ''
				),
			array(
				'name' => esc_html__('Header Settings','kreativa'),
				'id' => 'pagemeta_sep_page_title',
				'type' => 'seperator',
				),
			array(
				'name' => esc_html__('Background Image for Client Password Page','kreativa'),
				'id' => 'pagemeta_client_background_image',
				'type' => 'upload',
				'target' => 'image',
				'std' => '',
				'desc' => '<div class="metabox-note">'.esc_html__('Upload or provide full url of background. eg. http://www.domain.com/path/image.jpg','kreativa').'</div>'
				),
			array(
				'name' => esc_html__('Switch Menu','kreativa'),
				'id' => 'pagemeta_menu_choice',
				'type' => 'select',
				'desc' => esc_html__('Select a different menu for this page','kreativa'),
				'options' => kreativa_generate_menulist()
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
	return $mtheme_client_box;
}
add_action("admin_init", "kreativa_clientitemmetabox_init");
function kreativa_clientitemmetabox_init(){
	add_meta_box("mtheme_clientInfo-meta", esc_html__("Client Options","kreativa"), "kreativa_clientitem_metaoptions", "mtheme_clients", "normal", "low");
}
/*
* Meta options for client post type
*/
function kreativa_clientitem_metaoptions(){
	$mtheme_client_box = kreativa_client_metadata();
	kreativa_generate_metaboxes( $mtheme_client_box,get_the_id() );
}
?>