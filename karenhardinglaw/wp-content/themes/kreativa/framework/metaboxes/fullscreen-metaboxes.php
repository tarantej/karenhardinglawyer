<?php
/**
 *
 * @param $form_fields array, fields to include in attachment form
 * @param $post object, attachment record in database
 * @return $form_fields, modified form fields
 */

function kreativa_attachment_fields_fullscreen_link( $form_fields, $post ) {
	$form_fields['mtheme_attachment_fullscreen_url'] = array(
		'label' => esc_html__('Button Link URL','kreativa'),
		'input' => 'text',
		'value' => get_post_meta( $post->ID, 'mtheme_attachment_fullscreen_url', true ),
		'helps' => esc_html__('Fullscreen Slideshow, Swiper Slide, Thumbnail Gallery & Photowall links','kreativa'),
		);

	$form_fields['mtheme_attachment_fullscreen_link'] = array(
		'label' => esc_html__('Button Text','kreativa'),
		'input' => 'text',
		'value' => get_post_meta( $post->ID, 'mtheme_attachment_fullscreen_link', true ),
		'helps' => esc_html__('Fullscreen Slideshow, Swiper Slide & Photowall Button text','kreativa'),
		);

	$form_fields['mtheme_attachment_purchase_url'] = array(
		'label' => esc_html__('Purchase URL','kreativa'),
		'input' => 'text',
		'value' => get_post_meta( $post->ID, 'mtheme_attachment_purchase_url', true ),
		'helps' => esc_html__('Purchase link.','kreativa'),
		);

	$form_fields["mtheme_attachment_fullscreen_color"]["label"] = esc_html__("UI color ( Slideshow images )",'kreativa');
	$form_fields["mtheme_attachment_fullscreen_color"]["input"] = "html";
	$form_fields['mtheme_attachment_fullscreen_color']['html'] = "<select name='attachments[{$post->ID}][mtheme_attachment_fullscreen_color]'>";
	$form_fields['mtheme_attachment_fullscreen_color']['html'] .= '<option '.selected(get_post_meta($post->ID, "mtheme_attachment_fullscreen_color", true), 'bright',false).' value="bright">Bright</option>';
	$form_fields['mtheme_attachment_fullscreen_color']['html'] .= '<option '.selected(get_post_meta($post->ID, "mtheme_attachment_fullscreen_color", true), 'dark',false).' value="dark">Dark</option>';
	$form_fields['mtheme_attachment_fullscreen_color']['html'] .= '</select>';

	return $form_fields;
}

add_filter( 'attachment_fields_to_edit', 'kreativa_attachment_fields_fullscreen_link', 10, 2 );

/**
 *
 * @param $post array, the post data for database
 * @param $attachment array, attachment fields from $_POST form
 * @return $post array, modified post data
 */

function kreativa_attachment_fields_fullscreen_link_save( $post, $attachment ) {
	if( isset( $attachment['mtheme_attachment_fullscreen_link'] ) )
		update_post_meta( $post['ID'], 'mtheme_attachment_fullscreen_link', $attachment['mtheme_attachment_fullscreen_link'] );

	if( isset( $attachment['mtheme_attachment_fullscreen_url'] ) )
		update_post_meta( $post['ID'], 'mtheme_attachment_fullscreen_url', esc_url( $attachment['mtheme_attachment_fullscreen_url'] ) );

	if( isset( $attachment['mtheme_attachment_purchase_url'] ) )
		update_post_meta( $post['ID'], 'mtheme_attachment_purchase_url', esc_url( $attachment['mtheme_attachment_purchase_url'] ) );

	if( isset( $attachment['mtheme_attachment_fullscreen_color'] ) )
		update_post_meta( $post['ID'], 'mtheme_attachment_fullscreen_color', $attachment['mtheme_attachment_fullscreen_color'] );

	return $post;
}

add_filter( 'attachment_fields_to_save', 'kreativa_attachment_fields_fullscreen_link_save', 10, 2 );

function kreativa_fullscreen_metadata() {
	// Pull all the Featured into an array
	$bg_slideshow_pages = get_posts('post_type=mtheme_featured&orderby=title&numberposts=-1&order=ASC');

	require_once( get_template_directory() . '/framework/options/google-fonts.php');
	$options_fonts = kreativa_google_fonts();

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

	$portfolio_worktypes = get_categories('taxonomy=types&title_li=');
	$len = count($portfolio_worktypes);
	$portfolio_list_options='';
	$count=0;
	foreach($portfolio_worktypes as $key => $list) {
		$count++;	
		if (isSet($list->slug)) {
			if ( $len == $count ) {
					$portfolio_list_options .= $list->slug;
			} else {
				$portfolio_list_options .= $list->slug . ',';
			}
		}
	}

	$mtheme_imagepath =  get_template_directory_uri() . '/framework/options/images/metaboxes/';
	$mtheme_fullscreen_box = array(
		'id' => 'featuredmeta-box',
		'title' => esc_html__('Fullscreen Metabox','kreativa'),
		'page' => 'page',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Fullscreen Settings','kreativa'),
				'id' => 'pagemeta_page_section_id',
				'type' => 'break',
				'sectiontitle' => esc_html__('Page Settings','kreativa'),
				'std' => ''
				),
			array(
				'name' => esc_html__('Fullscreen Options','kreativa'),
				'id' => 'pagemeta_sep_page_options',
				'type' => 'seperator',
				),
			array(
				'name' => esc_html__('Add Images','kreativa'),
				'id' => 'pagemeta_image_attachments',
				'std' => esc_html__('Upload Images','kreativa'),
				'type' => 'image_gallery',
				'desc' => '<div class="metabox-note">'.esc_html__('Add images from Media Uploader or by uploading new images.','kreativa').'</div>'
				),
			array(
				'name' => esc_html__('Used as Thumbnail gallery description text','kreativa'),
				'id' => 'pagemeta_thumbnail_desc',
				'heading' => 'subhead',
				'type' => 'textarea',
				'desc' => esc_html__('Description to display in thumbnail gallery.','kreativa'),
				'std' => ''
			),
			array(
				'name' => esc_html__('Page Background color','kreativa'),
				'id' => 'pagemeta_pagebackground_color',
				'type' => 'color',
				'desc' => esc_html__('Page background color','kreativa'),
				'std' => ''
				),
			array(
				'name' => esc_html__('Display Titles & Description','kreativa'),
				'id' => 'pagemeta_slideshow_titledesc',
				'type' => 'select',
				'std' => 'enable',
				'desc' => esc_html__('Display title and description','kreativa'),
				'options' => array(
					'enable' => esc_html__('Enable','kreativa'),
					'disable' => esc_html__('Disable','kreativa')
					)
				),
			array(
				'name' => esc_html__('Fullscreen Type','kreativa'),
				'id' => 'pagemeta_fullscreen_type',
				'type' => 'image',
				'triggerStatus'=> 'on',
				'std' => 'slideshow',
				'class' => 'page_type',
				'desc' => esc_html__('Fullscreen page type','kreativa'),
				'options' => array(
					'slideshow' => $mtheme_imagepath . 'fullscreen_slideshow.png',
					'kenburns' => $mtheme_imagepath . 'fullscreen_kenburns.png',
					'photowall' => $mtheme_imagepath . 'fullscreen_photowall.png',
					'video' => $mtheme_imagepath . 'fullscreen_video.png',
					'fotorama' => $mtheme_imagepath . 'fullscreen_fotorama.png',
					'swiperslides' => $mtheme_imagepath . 'fullscreen_swipes.png',
					'revslider' => $mtheme_imagepath . 'fullscreen_revslider.png')
				),
			array(
				'name' => esc_html__('Fotorama Fill mode','kreativa'),
				'id' => 'pagemeta_fotorama_fill',
				'type' => 'select',
				'std' => 'enable',
				'class' => 'page_type-fotorama page_type-trigger',
				'desc' => esc_html__('Fotorama Fill mode','kreativa'),
				'options' => array(
					'cover' => esc_html__('Fill','kreativa'),
					'contain' => esc_html__('Fit','kreativa')
					)
				),
			array(
				'name' => esc_html__('Fotorama Thumbnails','kreativa'),
				'id' => 'pagemeta_fotorama_thumbnails',
				'type' => 'select',
				'std' => 'enable',
				'class' => 'page_type-fotorama page_type-trigger',
				'desc' => esc_html__('Fotorama Thumbnails','kreativa'),
				'options' => array(
					'enable' => esc_html__('Enable','kreativa'),
					'disable' => esc_html__('Disable','kreativa')
					)
				),
			array(
				'name' => esc_html__('Revolution Slider','kreativa'),
				'id' => 'pagemeta_revslider',
				'type' => 'select',
				'class' => 'page_type-revslider page_type-trigger',
				'desc' => esc_html__('Display Revolution Slider','kreativa'),
				'options' => kreativa_rev_slider_selectors()
				),
			array(
				'name' => esc_html__('Title Font','kreativa'),
				'id' => 'pagemeta_sep_page_options',
				'type' => 'seperator',
				'class' => 'page_type-slideshow page_type-kenburns page_type-particles page_type-coverphoto page_type-trigger',
				),
			array(
				'name' => esc_html__('Title font','kreativa'),
				'id' => 'pagemeta_fullscreentitlefont_meta',
				'type' => 'fontselector',
				'class' => 'page_type-slideshow page_type-kenburns page_type-particles page_type-coverphoto page_type-trigger',
				'desc' => esc_html__('Slideshow/Static Title Font','kreativa'),
				'options' => $options_fonts
				),

			array(
				'name' => esc_html__('Title font size','kreativa'),
				'id' => 'pagemeta_fullscreentitlesize_meta',
				'type' => 'text',
				'class' => 'mtextfield-small page_type-slideshow page_type-particles page_type-kenburns page_type-coverphoto page_type-trigger',
				'desc' => esc_html__('Slideshow/Static Title size in pixels. Only numerical value eg. 52','kreativa'),
				'std' => ''
				),
			array(
				'name' => esc_html__('Title line-height','kreativa'),
				'id' => 'pagemeta_fullscreentitlelineheight_meta',
				'type' => 'text',
				'class' => 'mtextfield-small page_type-slideshow page_type-particles page_type-kenburns page_type-coverphoto page_type-trigger',
				'desc' => esc_html__('Slideshow/Static Title letter spacing in pixels. Only numerical value eg. 2','kreativa'),
				'std' => ''
				),
			array(
				'name' => esc_html__('Title letter-spacing','kreativa'),
				'id' => 'pagemeta_fullscreentitlespacing_meta',
				'type' => 'text',
				'class' => 'mtextfield-small page_type-slideshow page_type-particles page_type-kenburns page_type-coverphoto page_type-trigger',
				'desc' => esc_html__('Slideshow/Static Title line height in pixels. Only numerical value eg. 2','kreativa'),
				'std' => ''
				),
			array(
				'name' => esc_html__('Fill to activate Static Text','kreativa'),
				'id' => 'pagemeta_sep_page_options',
				'type' => 'seperator',
				'class'=> 'page_type-slideshow page_type-kenburns page_type-particles page_type-coverphoto page_type-trigger',
				),
			array(
				'name' => esc_html__('For Kenburns & Static Slideshow Text','kreativa'),
				'id' => 'pagemeta_static_title',
				'class'=> 'page_type-slideshow page_type-kenburns page_type-particles page_type-coverphoto page_type-trigger',
				'type' => 'text',
				'desc' => esc_html__('Static Title','kreativa'),
				'std' => ''
				),
			array(
				'name' => '',
				'id' => 'pagemeta_static_description',
				'heading' => 'subhead',
				'class'=> 'page_type-slideshow page_type-kenburns page_type-particles page_type-coverphoto page_type-trigger',
				'type' => 'textarea',
				'desc' => esc_html__('Static Decription','kreativa'),
				'std' => ''
				),
			array(
				'name' => '',
				'id' => 'pagemeta_static_link_text',
				'heading' => 'subhead',
				'class'=> 'page_type-slideshow page_type-kenburns page_type-particles page_type-coverphoto page_type-trigger',
				'type' => 'text',
				'desc' => esc_html__('Static Button Text','kreativa'),
				'std' => ''
				),
			array(
				'name' => '',
				'id' => 'pagemeta_static_url',
				'heading' => 'subhead',
				'class'=> 'page_type-slideshow page_type-kenburns page_type-particles page_type-coverphoto page_type-trigger',
				'type' => 'text',
				'desc' => esc_html__('Static Button Link','kreativa'),
				'std' => ''
				),
			array(
				'name' => esc_html__('For Photowall','kreativa'),
				'id' => 'pagemeta_photowall_type',
				'type' => 'select',
				'std' => 'lightbox',
				'class' => 'page_type-photowall page_type-trigger',
				'desc' => esc_html__('Photowall type','kreativa'),
				'options' => array(
					'lightbox' => esc_html__('Lightbox from Image Attachments','kreativa'),
					'customlinks' => esc_html__('Custom Links from Image Attachments','kreativa'),
					'portfolio' => esc_html__('With Portfolio items','kreativa')
					)
				),
			array(
				'name' => esc_html__('Portfolio Worktypes to populate Photowall ( enter comma seperated slugs )','kreativa') . '<br/><br/><small>' . $portfolio_list_options . '</small>',
				'id' => 'pagemeta_photowall_workstypes',
				'heading' => 'subhead',
				'type' => 'text',
				'std' => '',
				'class' => 'page_type-photowall page_type-trigger',
				'desc' => esc_html__('Enter comma seperated slugs. Leave Blank to list all.','kreativa'),
				),
			array(
				'name' => esc_html__('Page Settings','kreativa'),
				'id' => 'pagemeta_header_section_id',
				'type' => 'break',
				'sectiontitle' => esc_html__('Header Settings','kreativa'),
				'std' => ''
				),
			array(
				'name' => esc_html__('Page Settings','kreativa'),
				'id' => 'pagemeta_sep_page_title',
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
				'name' => '',
				'id' => 'pagemeta_page_section_id',
				'type' => 'nobreak',
				'class'=> 'page_type-slideshow page_type-video page_type-particles page_type-kenburns page_type-coverphoto page_type-trigger',
				'sectiontitle' => esc_html__('Audio & Video Settings','kreativa'),
				'std' => ''
				),
			array(
				'name' => esc_html__('Media Settings','kreativa'),
				'id' => 'pagemeta_sep_page_title',
				'class'=> 'page_type-slideshow page_type-video page_type-particles page_type-kenburns page_type-coverphoto page_type-trigger',
				'type' => 'seperator',
				),
			array(
				'name' => esc_html__('Slideshow Audio files (optional)','kreativa'),
				'id' => 'pagemeta_slideshow_mp3',
				'class'=> 'slideshowaudio page_type-slideshow page_type-particles page_type-kenburns page_type-coverphoto page_type-trigger',
				'type' => 'text',
				'desc' => esc_html__('Enter MP3 file path for Slideshow. ( full url )','kreativa'),
				'std' => ''
				),

			array(
				'name' => '',
				'id' => 'pagemeta_slideshow_oga',
				'heading' => 'subhead',
				'class'=> 'slideshowaudio page_type-slideshow page_type-particles page_type-kenburns page_type-coverphoto page_type-trigger',
				'type' => 'text',
				'desc' => esc_html__('Enter OGA file path for Slideshow ( full url )','kreativa'),
				'std' => ''
				),

			array(
				'name' => '',
				'id' => 'pagemeta_slideshow_m4a',
				'heading' => 'subhead',
				'class'=> 'slideshowaudio page_type-slideshow page_type-particles page_type-kenburns page_type-coverphoto page_type-trigger',
				'type' => 'text',
				'desc' => esc_html__('Enter M4A file path for Slideshow ( full url )','kreativa'),
				'std' => ''
				),
			array(
				'name' => esc_html__('Youtube video ID','kreativa'),
				'id' => 'pagemeta_youtubevideo',
				'class'=> 'fullscreenvideo page_type-video page_type-trigger',
				'type' => 'text',
				'desc' => esc_html__('Youtube IDs eg: ylLzyHk54Z0. Youtube video IDs can be found at the end of youtube url - http://www.youtube.com/watch?v=ylLzyHk54Z0','kreativa'),
				'std' => ''
				),
			array(
				'name' => esc_html__('HTML5 Video','kreativa'),
				'id' => 'pagemeta_html5_poster',
				'class'=> 'html5video page_type-video page_type-trigger',
				'type' => 'upload',
				'desc' => esc_html__('Poster image','kreativa'),
				'std' => ''
				),
			array(
				'name' => '',
				'id' => 'pagemeta_html5_mp4',
				'heading' => 'subhead',
				'class'=> 'html5video page_type-video page_type-trigger',
				'type' => 'text',
				'desc' => esc_html__('MP4 file','kreativa'),
				'std' => ''
				),
			array(
				'name' => '',
				'id' => 'pagemeta_html5_webm',
				'heading' => 'subhead',
				'class'=> 'html5video page_type-video page_type-trigger',
				'type' => 'text',
				'desc' => esc_html__('WEBM file','kreativa'),
				'std' => ''
				),
			array(
				'name' => '',
				'id' => 'pagemeta_html5_ogv',
				'heading' => 'subhead',
				'class'=> 'html5video page_type-video page_type-trigger',
				'type' => 'text',
				'desc' => esc_html__('OGV file','kreativa'),
				'std' => ''
				)
		)
);
return $mtheme_fullscreen_box;
}
add_action("admin_init", "kreativa_fullscreenitemmetabox_init");
function kreativa_fullscreenitemmetabox_init(){
	add_meta_box("mtheme_featured-meta", esc_html__("Featured Options","kreativa"), "kreativa_featured_options", "mtheme_featured", "normal", "low");
}
/*
* Meta options for Portfolio post type
*/
function kreativa_featured_options(){
	$mtheme_fullscreen_box = kreativa_fullscreen_metadata();
	kreativa_generate_metaboxes($mtheme_fullscreen_box, get_the_id() );
}
?>