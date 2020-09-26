<?php
function kreativa_woocommerce_metadata() {
$mtheme_sidebar_options = kreativa_generate_sidebarlist("portfolio");

$mtheme_imagepath =  get_template_directory_uri() . '/framework/options/images/metaboxes/';

$mtheme_woocommerce_box = array(
	'id' => 'woocommercemeta-box',
	'title' => esc_html__('Woocommerce Metabox','kreativa'),
	'page' => 'page',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
			array(
				'name' => esc_html__('Page Options','kreativa'),
				'id' => 'pagemeta_page_section_id',
				'type' => 'break',
				'sectiontitle' => esc_html__('Page Options','kreativa'),
				'std' => ''
				),
			array(
				'name' => esc_html__('Page Options','kreativa'),
				'id' => 'pagemeta_sep_page_options',
				'type' => 'seperator',
				),
			array(
				'name' => esc_html__('Attach Images','kreativa'),
				'id' => 'pagemeta_image_attachments',
				'std' => esc_html__('Upload Images','kreativa'),
				'type' => 'image_gallery',
				'desc' => '<div class="metabox-note">'.esc_html__('Attach images. Images can be used to generate fullscreen slideshows using Page settings.','kreativa').'</div>'
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
				'name' => esc_html__('Page Background / Top Media','kreativa'),
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
return $mtheme_woocommerce_box;
}
add_action("admin_init", "kreativa_woocommerceitemmetabox_init");
function kreativa_woocommerceitemmetabox_init(){
	add_meta_box("mtheme_woocommerceInfo-meta", esc_html__("WooCommerce Options","kreativa"), "kreativa_woocommerceitem_metaoptions", "product", "normal", "low");
}
/*
* Meta options for Portfolio post type
*/
function kreativa_woocommerceitem_metaoptions(){
	$mtheme_woocommerce_box = kreativa_woocommerce_metadata();
	kreativa_generate_metaboxes($mtheme_woocommerce_box,get_the_id());
}
?>