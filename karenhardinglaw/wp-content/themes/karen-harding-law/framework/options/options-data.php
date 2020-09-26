<?php
/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 *  
 */
function kreativa_options() {
	
	// Pull all Google Fonts using API into an array
	//$fontArray = unserialize($fontsSeraliazed);
	$options_fonts = kreativa_google_fonts();
	
	// Pull all the categories into an array
	$options_categories = array(); 
	array_push($options_categories, "All Categories");
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
    	$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	// Pull all the pages into an array
	$options_pages = array();
	array_push($options_pages, "Not Selected"); 
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	if ($options_pages_obj) {
		foreach ($options_pages_obj as $page) {
			$options_pages[$page->ID] = $page->post_title;
		}
	}
	
	// Pull all the Featured into an array
	$featured_pages = get_posts('post_type=mtheme_featured&orderby=title&numberposts=-1&order=ASC');
	if ($featured_pages) {
		foreach($featured_pages as $key => $list) {
			$custom = get_post_custom($list->ID);
			if ( isset($custom["fullscreen_type"][0]) ) { 
				$slideshow_type=' ('.$custom["fullscreen_type"][0].')'; 
			} else {
			$slideshow_type="";
			}
			$options_featured[$list->ID] = $list->post_title . $slideshow_type;
		}
	} else {
		$options_featured[0]="Featured pages not found.";
	}
	
	// Pull all the Featured into an array
	$bg_slideshow_pages = kreativa_get_select_target_options('fullscreen_slideshow_posts');
	
	// Pull all the Portfolio into an array
	$portfolio_pages = get_posts('post_type=mtheme_portfolio&orderby=title&numberposts=-1&order=ASC');
	if ($portfolio_pages) {
		foreach($portfolio_pages as $key => $list) {
			$custom = get_post_custom($list->ID);
			$portfolio_list[$list->ID] = $list->post_title;
		}
	}
		
	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/framework/options/images/';
	$theme_imagepath =  get_template_directory_uri() . '/images/';
	$predefined_background_imagepath =  get_template_directory_uri() . '/images/titlebackgrounds/';
		
	$options = array();
		
$options[] = array( "name"			=> esc_html__("General", "kreativa" ),
					"icon"			=> 'fa fa-cog',
					"type"			=> "heading");

	$options[] = array( "name"			=> esc_html__( "Theme Style", "kreativa" ),
						"desc"			=> esc_html__( "Styles found in theme root : style.css / style-light.css", 'kreativa' ),
						"id"			=> "theme_style",
						"std"			=> "light",
						"type"			=> "images",
						"options"	=> array(
							'light'		=> $imagepath . 'options/light.png',
							'dark' 		=> $imagepath . 'options/dark.png')
						);

	$options[] = array( "name" => __( "Menu type", 'kreativa' ),
						"desc" => __( "Menu type", 'kreativa' ),
						"id" => "header_menu_type",
						"std" => "vertical-menu",
						"type" => "images",
						"options" => array(
							'vertical-menu'	=> $imagepath . 'options/vertical-menu.png',
							'left-detatched'	=> $imagepath . 'options/left-logo-menu.png')
						);

	$options[] = array( "name"			=> esc_html__( "Disable Comments in Pages", 'kreativa' ),
						"desc"			=> esc_html__( "Disables comments in pages even if comments are enabled in page settings.", 'kreativa' ),
						"id"			=> "disable_pagecomments",
						"std"			=> "0",
						"type"			=> "checkbox");

	$options[] = array( "name"			=> esc_html__( "Add Facebook Opengraph Meta tags", 'kreativa' ),
						"desc"			=> esc_html__( "Adds meta tags to recognize featured image , title and decription used in posts and pages.", 'kreativa' ),
						"id"			=> "opengraph_status",
						"std"			=> "0",
						"type"			=> "checkbox");

$options[] = array( "name"			=> esc_html__("Under Construction", "kreativa" ),
					"icon"			=> 'fa fa-wrench',
					"type"			=> "heading");

	$options[] = array( "name"			=> esc_html__( "Enable Maintenance Mode", 'kreativa' ),
						"desc"			=> esc_html__( "Note: Maintenance screen is not active for administrators. Admins will need to logout to see maintenance screen.", 'kreativa' ),
						"id"			=> "maintenance_mode",
						"std"			=> "0",
						"type"			=> "checkbox");

	$options[] = array( "name"			=> esc_html__( "Upload Maintenance screen background.", 'kreativa' ),
						"desc"			=> esc_html__( "Upload Maintenance screen background.", 'kreativa' ),
						"id"			=> "maintenance_bg",
						"type"			=> "upload");

		$options[] = array( "name"			=> esc_html__( "Text color", "kreativa" ),
							"desc"			=> esc_html__( "Text color", "kreativa" ),
							"id"			=> "maintenance_color",
							"std"			=> "",
							"type"			=> "color");

	$options[] = array( "name" => esc_html__("Under Construction Message", "kreativa" ),
						"desc" => esc_html__("Under construction message.", "kreativa" ),
						"id" => "maintenance_text",
						"std" => "We are under construction and will be back soon.",
						"type" => "textarea");

$options[] = array( "name"			=> esc_html__("API's", "kreativa" ),
					"icon"			=> 'fa fa-cogs',
					"type"			=> "heading");

	$options[] = array( "name"			=> esc_html__("Google Map API Key. Required to display Google map","kreativa"),
						"desc"			=> esc_html__("Goole map now requires an API key to display google maps. How to get a ","kreativa") . "<a target='_blank' href='https://developers.google.com/maps/documentation/javascript/get-api-key'>Google Map API Key</a>",
						"id"			=> "googlemap_apikey",
						"std"			=> "",
						"class"			=> "tiny",
						"type"			=> "text");

	$options[] = array( "name"			=> esc_html__("Instagram Token. Required to display Instagram","kreativa"),
						"desc"			=> esc_html__("The Instagram API requires a Token to display user authenticated photos. How to get ","kreativa")."<a target='_blank' href='http://imaginem.co/instagram-token/'>Instagram Token</a>",
						"id"			=> "insta_token",
						"std"			=> "",
						"class"			=> "tiny",
						"type"			=> "text");

	$options[] = array( "name" => esc_html__( "Instagram Image limit", "kreativa" ),
						"desc" => esc_html__( "Instagram Image limit", "kreativa" ),
						"id" => "insta_image_limit",
						"std" => "20",
						"min" => "1",
						"max" => "20",
						"step" => "0",
						"unit" => 'images',
						"type" => "text");

	$options[] = array( "name" => esc_html__( "Instagram Transition", 'kreativa' ),
						"desc" => esc_html__( "Instagram Transition type", 'kreativa' ),
						"id" => "insta_transition",
						"std" => "random",
						"type" => "select",
						"class" => "mini",
						"options" => array(
								'false' => 'Disable Slideshow',
								'random' => 'Random',
								'fadeInOut' => 'fadeInOut',
								'slideLeft' => 'slideLeft',
								'slideRight' => 'slideRight',
								'slideTop' => 'slideTop',
								'slideBottom' => 'slideBottom',
								'rotateLeft' => 'rotateLeft',
								'rotateRight' => 'rotateRight',
								'rotateTop' => 'rotateTop',
								'rotateBottom' => 'rotateBottom',
								'scale' => 'scale',
								'rotate3d' => 'rotate3d',
								'rotateLeftScale' => 'rotateLeftScale',
								'rotateRightScale' => 'rotateRightScale',
								'rotateTopScale' => 'rotateTopScale',
								'rotateBottomScale' => 'rotateBottomScale')
						);

	$options[] = array( "name"			=> esc_html__("Instagram label to display","kreativa"),
						"desc"			=> esc_html__("Instagram label to display","kreativa"),
						"id"			=> "insta_username",
						"std"			=> "",
						"class"			=> "tiny",
						"type"			=> "text");

	$options[] = array( "name"			=> esc_html__("Enable Footer Instagram","kreativa"),
						"desc"			=> esc_html__("Enable Footer Instagram Carousel","kreativa"),
						"id"			=> "instagram_footer",
						"std"			=> "1",
						"type"			=> "checkbox");

	$options[] = array( "name" => esc_html__("Custom CSS", "kreativa" ),
					"icon"			=> 'fa fa-cogs',
					"type" => "heading");

	$options[] = array( "name" => esc_html__("Custom CSS", "kreativa" ),
						"desc" => esc_html__("You can include custom CSS to this field. eg. .entry-title h1 { font-family: 'Lobster', cursive; }", "kreativa" ),
						"id" => "custom_css",
						"std" => '',
						"class" => "big",
						"type" => "textarea");

	$options[] = array( "name" => esc_html__("Mobile Specific CSS", "kreativa" ),
						"desc" => esc_html__("Only for mobile specific CSS. eg. .entry-title h1 { font-family: 'Lobster', cursive; }", "kreativa" ),
						"id" => "mobile_css",
						"std" => '',
						"class" => "big",
						"type" => "textarea");


$options[] = array( "name"			=> esc_html__("Vertical Menu Logo", "kreativa" ),
					"icon"			=> 'fa fa-diamond',
					"type"			=> "heading");

	$options[] = array( "name"			=> esc_html__( "Vertical Menu Logo", 'kreativa' ),
						"desc"			=> esc_html__( "Upload logo for header", 'kreativa' ),
						"id"			=> "vmain_logo",
						"type"			=> "upload");

	$options[] = array( "name"			=> esc_html__( "Vertical Menu Logo Width", 'kreativa' ),
						"desc"			=> esc_html__( "Vertical Menu Logo width in pixels", 'kreativa' ),
						"id"			=> "vlogo_width",
						"min"			=> "0",
						"max"			=> "2000",
						"step"			=> "0",
						"unit"			=> 'pixels',
						"std"			=> "300",
						"type"			=> "text");

	$options[] = array( "name"			=> esc_html__( "Top Space", 'kreativa' ),
						"desc"			=> esc_html__( "Top spacing for logo ( 0 sets default )", 'kreativa' ),
						"id"			=> "vlogo_topmargin",
						"min"			=> "0",
						"max"			=> "200",
						"step"			=> "0",
						"unit"			=> 'pixels',
						"std"			=> "0",
						"type"			=> "text");

	$options[] = array( "name"			=> esc_html__( "Left Space", 'kreativa' ),
						"desc"			=> esc_html__( "Left spacing for logo ( 0 sets default )", 'kreativa' ),
						"id"			=> "vlogo_leftmargin",
						"min"			=> "0",
						"max"			=> "200",
						"step"			=> "0",
						"unit"			=> 'pixels',
						"std"			=> "0",
						"type"			=> "text");

$options[] = array( "name"			=> __("Horizontal Menu Logo", "kreativa" ),
					"icon"			=> 'fa fa-diamond',
					"type"			=> "heading");

	$options[] = array( "name"			=> __( "Horizontal Menu Logo", 'kreativa' ),
						"desc"			=> __( "Logo for menu.", 'kreativa' ),
						"id"			=> "main_logo",
						"type"			=> "upload");

	$options[] = array( "name"			=> __( "Logo Height", 'kreativa' ),
						"desc"			=> __( "Logo Height in pixels. Width will be adjusted with height proportion.", 'kreativa' ),
						"id"			=> "logo_height",
						"min"			=> "0",
						"max"			=> "2000",
						"step"			=> "0",
						"unit"			=> 'pixels',
						"std"			=> "53",
						"type"			=> "text");
						
	$options[] = array( "name"			=> __( "Top Space", 'kreativa' ),
						"desc"			=> __( "Top spacing for logo ( 0 sets default )", 'kreativa' ),
						"id"			=> "logo_topmargin",
						"min"			=> "0",
						"max"			=> "200",
						"step"			=> "0",
						"unit"			=> 'pixels',
						"std"			=> "24",
						"type"			=> "text");

	$options[] = array( "name"			=> __( "Left Space", 'kreativa' ),
						"desc"			=> __( "Left spacing for logo ( 0 sets default )", 'kreativa' ),
						"id"			=> "logo_leftmargin",
						"min"			=> "0",
						"max"			=> "200",
						"step"			=> "0",
						"unit"			=> 'pixels',
						"std"			=> "60",
						"type"			=> "text");

	$options[] = array( "name"			=> __( "Right Space", 'kreativa' ),
						"desc"			=> __( "Right spacing for logo ( 0 sets default )", 'kreativa' ),
						"id"			=> "logo_rightmargin",
						"min"			=> "0",
						"max"			=> "200",
						"step"			=> "0",
						"unit"			=> 'pixels',
						"std"			=> "50",
						"type"			=> "text");

$options[] = array( "name"			=> esc_html__("Responsive Logo", "kreativa" ),
					"icon"			=> 'fa fa-diamond',
					"type"			=> "heading");

	$options[] = array( "name"			=> esc_html__( "Responsive/Mobile Logo", 'kreativa' ),
						"desc"			=> esc_html__( "Upload logo for responsive layout.", 'kreativa' ),
						"id"			=> "responsive_logo",
						"type"			=> "upload");

	$options[] = array( "name"			=> esc_html__( "Responsive Logo Width", 'kreativa' ),
						"desc"			=> esc_html__( "Responsive Logo width in pixels", 'kreativa' ),
						"id"			=> "responsive_logo_width",
						"min"			=> "0",
						"max"			=> "2000",
						"step"			=> "0",
						"unit"			=> 'pixels',
						"std"			=> "0",
						"type"			=> "text");

	$options[] = array( "name"			=> esc_html__( "Responsive Logo Top Space", 'kreativa' ),
						"desc"			=> esc_html__( "Top spacing for logo ( 0 sets default )", 'kreativa' ),
						"id"			=> "responsive_logo_topmargin",
						"min"			=> "0",
						"max"			=> "200",
						"step"			=> "0",
						"unit"			=> 'pixels',
						"std"			=> "0",
						"type"			=> "text");

$options[] = array( "name"			=> esc_html__("Footer Logo", "kreativa" ),
					"icon"			=> 'fa fa-diamond',
					"type"			=> "heading");

	$options[] = array( "name"			=> esc_html__( "Footer Logo", 'kreativa' ),
						"desc"			=> esc_html__( "Upload logo for footer.", 'kreativa' ),
						"id"			=> "footer_logo",
						"type"			=> "upload");

	$options[] = array( "name"			=> esc_html__( "Footer Logo Width", 'kreativa' ),
						"desc"			=> esc_html__( "Footer Logo width in pixels", 'kreativa' ),
						"id"			=> "footer_logo_width",
						"min"			=> "0",
						"max"			=> "2000",
						"step"			=> "0",
						"unit"			=> 'pixels',
						"std"			=> "0",
						"type"			=> "text");

$options[] = array( "name"			=> esc_html__("WP Login Logo", "kreativa" ),
					"icon"			=> 'fa fa-diamond',
					"type"			=> "heading");
						
	$options[] = array( "name"			=> esc_html__( "Custom WordPress Login Page Logo", 'kreativa' ),
						"desc"			=> esc_html__( "Upload logo for WordPress Login Page", 'kreativa' ),
						"id"			=> "wplogin_logo",
						"type"			=> "upload");

	$options[] = array( "name"			=> esc_html__( "WP Login logo Width", 'kreativa' ),
						"desc"			=> esc_html__( "Define Logo width in pixels", 'kreativa' ),
						"id"			=> "wplogin_width",
						"min"			=> "0",
						"max"			=> "2000",
						"step"			=> "0",
						"unit"			=> 'pixels',
						"std"			=> "300",
						"type"			=> "text");

	$options[] = array( "name"			=> esc_html__( "WP Login logo Height", 'kreativa' ),
						"desc"			=> esc_html__( "Define Logo height in pixels", 'kreativa' ),
						"id"			=> "wplogin_height",
						"min"			=> "0",
						"max"			=> "2000",
						"step"			=> "0",
						"unit"			=> 'pixels',
						"std"			=> "300",
						"type"			=> "text");

	$options[] = array( "name" => esc_html__("Right Click", "kreativa" ),
					"icon"			=> 'fa fa-times',
					"type" => "heading");

	$options[] = array( "name" => esc_html__("Disable Right Click", "kreativa" ),
						"desc" => esc_html__("Disable right clicking.", "kreativa" ),
						"id" => "rightclick_disable",
						"std" => "0",
						"type" => "checkbox");

	$options[] = array( "name" => esc_html__("Right Click Message", "kreativa" ),
						"desc" => esc_html__("This text appears in the popup when right click is disabled.", "kreativa" ),
						"id" => "rightclick_disabletext",
						"std" => "You can enable/disable right clicking from Theme Options and customize this message too.",
						"type" => "textarea");

	$options[] = array(	"name"			=> esc_html__("Message font","kreativa"),
						"desc"			=> esc_html__("Select font for message","kreativa"),
						"id"			=> "rcm_font",
						"std"			=> 'Default Font',
						"type"			=> "selectgooglefont",
						"class"			=> "small", //mini, tiny, small
						"options"			=> $options_fonts);	

		$options[] = array( "name"			=> esc_html__( "Message text color", "kreativa" ),
							"desc"			=> esc_html__( "Message text color", "kreativa" ),
							"id"			=> "rcm_textcolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> esc_html__( "Background color", "kreativa" ),
							"desc"			=> esc_html__( "Background color", "kreativa" ),
							"id"			=> "rcm_bgcolor",
							"std"			=> "",
							"type"			=> "color");

	$options[] = array( "name"			=> esc_html__("Message title size", "kreativa" ),
						"desc"			=> esc_html__("Message title size in pixels. eg. 19", "kreativa" ),
						"id"			=> "rcm_size",
						"std"			=> "",
						"class"			=> "small",
						"type"			=> "text");

	$options[] = array( "name"			=> esc_html__("Message title letter spacing", "kreativa" ),
						"desc"			=> esc_html__("Message title letter spacing in pixels. eg. 1", "kreativa" ),
						"id"			=> "rcm_letterspacing",
						"std"			=> "",
						"class"			=> "small",
						"type"			=> "text");

	$options[] = array( "name"			=> esc_html__("Message title weight", "kreativa" ),
						"desc"			=> esc_html__("Message title weight. eg. 100, 200, 300, 400, 500, 600, 700, 800, 900", "kreativa" ),
						"id"			=> "rcm_weight",
						"std"			=> "",
						"class"			=> "small",
						"type"			=> "text");

$options[] = array( "name"			=> esc_html__("Background", "kreativa" ),
					"icon"			=> 'fa fa-home',
					"type"			=> "heading");	
						
	$options[] = array( "name" => esc_html__( "Background color", 'kreativa' ),
						"desc" => esc_html__( "No color selected by default.", 'kreativa' ),
						"id" => "general_background_color",
						"std" => "",
						"type" => "color");

	$options[] = array( "name" => esc_html__( "General Background Fullscreen Slideshow Page", 'kreativa' ),
						"desc" => esc_html__( "General Background Fullscreen Slideshow Page.", 'kreativa' ),
						"id" => "general_bgslideshow",
						"std" => "",
						"type" => "selectyper",
						"class" => "small",
						"options" => $bg_slideshow_pages);
						
	$options[] = array( "name" => esc_html__( "Background image ( required for archive pages )", 'kreativa' ),
						"desc" => esc_html__( "Upload background image", 'kreativa' ),
						"id" => "general_background_image",
						"type" => "upload");

		$options[] = array( "name" => esc_html__( "Apply Archive Page Opacity/Color to all", 'kreativa' ),
							"desc" => esc_html__( "Apply Archive Page opacity to all pages.", 'kreativa' ),
							"id" => "page_opacity_customize",
							"std" => "0",
							"type" => "checkbox");

		$options[] = array( "name"			=> esc_html__( "Archive Page color", "kreativa" ),
							"desc"			=> esc_html__( "Archive Page color", "kreativa" ),
							"id"			=> "page_background",
							"std"			=> "",
							"type"			=> "color");

			$options[] = array( "name" => esc_html__( "Archive Page opacity ( default 85 )", 'kreativa' ),
								"desc" => esc_html__( "Archive Page opacity", 'kreativa' ),
								"id" => "page_background_opacity",
								"min" => "0",
								"max" => "100",
								"step" => "0",
								"unit" => '%',
								"std" => "85",
								"type" => "text");

$options[] = array( "name" => esc_html__("Fullscreen Homepage", "kreativa" ),
					"icon"			=> 'fa fa-home',
					"type" => "heading");

	$options[] = array( "name" => esc_html__( "Enable Fullscreen Hompage", 'kreativa' ),
						"desc" => esc_html__( "Enable fullscreen homepage. Please ensure wp-admin > Settings > Readings is not set to any static pages.", 'kreativa' ),
						"id" => "fullcscreen_henable",
						"std" => "0",
						"type" => "checkbox");

	$options[] = array( "name" => esc_html__( "Select Fullscreen Home", 'kreativa' ),
						"desc" => esc_html__( "Requires existing fullscreen posts.", 'kreativa' ),
						"id" => "fullcscreen_hselected",
						"std" => "",
						"type" => "selectyper",
						"class" => "small",
						"options" => kreativa_get_select_target_options('fullscreen_posts')
						);

$options[] = array( "name" => esc_html__("Fullscreen Media", "kreativa" ),
					"icon"			=> 'fa fa-paint-brush',
					"type" => "heading");
					
	$options[] = array( "name" => "Audio Settings",
						"type" => "info");
					
	$options[] = array( "name" => esc_html__( "Loop Audio Clip", 'kreativa' ),
						"desc" => esc_html__( "Loop the audio clip for fullscreen slideshows", 'kreativa' ),
						"id" => "audio_loop",
						"std" => "1",
						"type" => "checkbox");
						
	$options[] = array( "name" => esc_html__( "On-start volume", 'kreativa' ),
						"desc" => esc_html__( "Volume to start with", 'kreativa' ),
						"id" => "audio_volume",
						"min" => "1",
						"max" => "100",
						"step" => "0",
						"unit" => '%',
						"std" => "75",
						"type" => "text");
						
	$options[] = array( "name" => esc_html__("Slideshow Settings", "kreativa" ),
						"type" => "info");

	$options[] = array( "name" => esc_html__("Disable Slideshow Progress Bar", "kreativa" ),
						"desc" => esc_html__("Disable slideshow progress bar", "kreativa" ),
						"id" => "hprogressbar_disable",
						"std" => "1",
						"type" => "checkbox");

		$options[] = array( "name" => esc_html__("Disable Slideshow Play button", "kreativa" ),
							"desc" => esc_html__("Disable slideshow play button", "kreativa" ),
							"id" => "hplaybutton_disable",
							"std" => "0",
							"type" => "checkbox");

		$options[] = array( "name" => esc_html__("Disable Slideshow Navigation Arrows", "kreativa" ),
							"desc" => esc_html__("Disable navigation arrows", "kreativa" ),
							"id" => "hnavigation_disable",
							"std" => "0",
							"type" => "checkbox");

		$options[] = array( "name" => esc_html__("Disable Slideshow Control bar", "kreativa" ),
							"desc" => esc_html__("Disable slideshow Control bar", "kreativa" ),
							"id" => "hcontrolbar_disable",
							"std" => "0",
							"type" => "checkbox");
						
	// 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left					
	$options[] = array( "name" => esc_html__( "Transition", 'kreativa' ),
						"desc" => esc_html__( "Transition type", 'kreativa' ),
						"id" => "slideshow_transition",
						"std" => "1",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => array(
							'1' => "Fade",
							'2' => "Slide Top",
							'3' => "Slide Right",
							'4' => "Slide Bottom",
							'5' => "Slide Left",
							'6' => "Carousel Right",
							'7' => "Carousel Left",
							'0' => "None")
						);
						
	$options[] = array( "name" => esc_html__( "Auto Play Slideshow", 'kreativa' ),
						"desc" => esc_html__( "Auto start slideshow on load", 'kreativa' ),
						"id" => "slideshow_autoplay",
						"std" => "1",
						"type" => "checkbox");
						
	$options[] = array( "name" => esc_html__( "Pause on last slide", 'kreativa' ),
						"desc" => esc_html__( "Pause on end of slideshow", 'kreativa' ),
						"id" => "slideshow_pause_on_last",
						"std" => "0",
						"type" => "checkbox");
						
	$options[] = array( "name" => esc_html__( "Pause on hover", 'kreativa' ),
						"desc" => esc_html__( "Pause slideshow on hover", 'kreativa' ),
						"id" => "slideshow_pause_hover",
						"std" => "0",
						"type" => "checkbox");
						
	$options[] = array( "name" => esc_html__( "Vertical center", 'kreativa' ),
						"desc" => esc_html__( "Vertical center images", 'kreativa' ),
						"id" => "slideshow_vertical_center",
						"std" => "1",
						"type" => "checkbox");
						
	$options[] = array( "name" => esc_html__( "Horizontal center", 'kreativa' ),
						"desc" => esc_html__( "Horizontal center images", 'kreativa' ),
						"id" => "slideshow_horizontal_center",
						"std" => "1",
						"type" => "checkbox");
						
	$options[] = array( "name" => esc_html__( "Fit portrait", 'kreativa' ),
						"desc" => esc_html__( "Portrait images will not exceed browser height", 'kreativa' ),
						"id" => "slideshow_portrait",
						"std" => "1",
						"type" => "checkbox");
						
	$options[] = array( "name" => esc_html__( "Fit Landscape", 'kreativa' ),
						"desc" => esc_html__( "Landscape images will not exceed browser width", 'kreativa' ),
						"id" => "slideshow_landscape",
						"std" => "0",
						"type" => "checkbox");
						
	$options[] = array( "name" => esc_html__( "Fit Always", 'kreativa' ),
						"desc" => esc_html__( "Image will never exceed browser width or height.", 'kreativa' ),
						"id" => "slideshow_fit_always",
						"std" => "0",
						"type" => "checkbox");
						
	$options[] = array( "name" => esc_html__( "Slide Interval", "kreativa" ),
						"desc" => esc_html__( "Length between transitions", "kreativa" ),
						"id" => "slideshow_interval",
						"min" => "500",
						"max" => "20000",
						"step" => "0",
						"unit" => 'ms',
						"std" => "8000",
						"type" => "text");
						
	$options[] = array( "name" => esc_html__( "Transition speed", "kreativa" ),
						"desc" => esc_html__( "Speed of transition", "kreativa" ),
						"id" => "slideshow_transition_speed",
						"std" => "1000",
						"min" => "500",
						"max" => "20000",
						"step" => "0",
						"unit" => 'ms',
						"type" => "text");

$options[] = array( "name" => esc_html__("404", "kreativa" ),
					"icon"			=> 'fa fa-question',
					"type" => "heading");

		$options[] = array( "name" => esc_html__( "404 Background image ( for page not found. Optional )", 'kreativa' ),
							"desc" => esc_html__( "Upload background image", 'kreativa' ),
							"id" => "general_404_image",
							"type" => "upload");
						
		$options[] = array( "name"			=> esc_html__("404 Page title", "kreativa" ),
						"desc"			=> esc_html__("404 Page not Found!", "kreativa" ),
						"id"			=> "404_title",
						"std"			=> "",
						"class"			=> "small",
						"type"			=> "text");

		$options[] = array( "name"			=> esc_html__( "404 Title color", "kreativa" ),
							"desc"			=> esc_html__( "404 Title color", "kreativa" ),
							"id"			=> "text_404_color",
							"std"			=> "",
							"type"			=> "color");

$options[] = array( "name"			=> esc_html__("Events", "kreativa" ),
					"icon"			=> 'fa fa-paper-plane-o',
					"type"			=> "heading");

	$options[] = array( "name" => esc_html__( "Events Time format", 'kreativa' ),
						"desc" => esc_html__( "Events Time format", 'kreativa' ),
						"id" => "events_time_format",
						"std" => "true",
						"type" => "select",
						"class" => "mini", //mini, tiny, small
						"options" => array(
							'conventional' => "AM/PM",
							'24hr' => "24 Hrs")
						);

	$options[] = array( "name"			=> esc_html__("Event gallery title","kreativa"),
						"desc"			=> esc_html__("Event gallery title","kreativa"),
						"id"			=> "event_gallery_title",
						"std"			=> "Events",
						"class"			=> "tiny",
						"type"			=> "text");

	$options[] = array(	"name"			=> esc_html__("Prefered events archive page", "kreativa" ),
						"desc"			=> esc_html__("Prefered events archive page.", "kreativa" ),
						"id"			=> "events_archive_page",
						"std"			=> '',
						"type"			=> "selectyper",
						"class"			=> "small", //mini, tiny, small
						"options"			=> $options_pages);

	$options[] = array( "name"			=> esc_html__("Number of thumbnail columns for Events archive listing", "kreativa" ),
						"desc"			=> esc_html__("Affects events archives. eg. Browsing Events category links.", "kreativa" ),
						"id"			=> "event_achivelisting",
						"min"			=> "1",
						"max"			=> "4",
						"step"			=> "0",
						"unit"			=> 'columns',
						"std"			=> "3",
						"type"			=> "text");

	$options[] = array( "name"			=> esc_html__("Postponed message","kreativa"),
						"desc"			=> esc_html__("Message for postponed events","kreativa"),
						"id"			=> "events_postponed_msg",
						"std"			=> "Event Postponed",
						"class"			=> "tiny",
						"type"			=> "text");

	$options[] = array( "name"			=> esc_html__("Cancelled message","kreativa"),
						"desc"			=> esc_html__("Message for cancelled events","kreativa"),
						"id"			=> "events_cancelled_msg",
						"std"			=> "Event Cancelled",
						"class"			=> "tiny",
						"type"			=> "text");

	$options[] = array( "name"			=> esc_html__("Event Time Text","kreativa"),
						"desc"			=> esc_html__("Text to use for Event time","kreativa"),
						"id"			=> "events_time_text",
						"std"			=> "When",
						"class"			=> "tiny",
						"type"			=> "text");

	$options[] = array( "name"			=> esc_html__("Event Location Text","kreativa"),
						"desc"			=> esc_html__("Text to use for Event location","kreativa"),
						"id"			=> "events_location_text",
						"std"			=> "Where",
						"class"			=> "tiny",
						"type"			=> "text");

	$options[] = array( "name"			=> esc_html__("Event Price Text","kreativa"),
						"desc"			=> esc_html__("Text to use for Event price","kreativa"),
						"id"			=> "events_price_text",
						"std"			=> "Cost",
						"class"			=> "tiny",
						"type"			=> "text");

$options[] = array( "name"			=> esc_html__("Portfolios", "kreativa" ),
					"icon"			=> 'fa fa-th',
					"type"			=> "heading");
					
	$options[] = array( "name"			=> esc_html__("Enable comments", "kreativa" ),
						"desc"			=> esc_html__("Enable comments for portfolio items. Switching off will disable comments and comment information on portfolio thumbnails.", "kreativa" ),
						"id"			=> "portfolio_comments",
						"std"			=> "0",
						"type"			=> "checkbox");

	$options[] = array( "name"			=> esc_html__( "Default portfolio archive list orientation", "kreativa" ),
						"desc"			=> esc_html__( "Default portfolio archive list orientation", 'kreativa' ),
						"id"			=> "portfolio_archive_format",
						"std"			=> "landscape",
						"type"			=> "select",
						"options"	=> array(
							'landscape'		=> 'Landscape',
							'portrait' 		=> 'Portrait')
						);

	$options[] = array(	"name"			=> esc_html__("Prefered portfolio archive page", "kreativa" ),
						"desc"			=> esc_html__("Prefered portfolio archive page.", "kreativa" ),
						"id"			=> "portfolio_archive_page",
						"std"			=> '',
						"type"			=> "selectyper",
						"class"			=> "small", //mini, tiny, small
						"options"			=> $options_pages);

	$options[] = array( "name"			=> esc_html__("Number of thumbnail columns for Portfolio archive listing", "kreativa" ),
						"desc"			=> esc_html__("Affects portfolio archives. eg. Browsing portfolio category links.", "kreativa" ),
						"id"			=> "portfolio_achivelisting",
						"min"			=> "1",
						"max"			=> "4",
						"step"			=> "0",
						"unit"			=> 'columns',
						"std"			=> "3",
						"type"			=> "text");

	$options[] = array( "name"			=> esc_html__("Enable Recent Portfolio blocks", "kreativa" ),
						"desc"			=> esc_html__("Enable recent portfolio block in portfolio details page.", "kreativa" ),
						"id"			=> "portfolio_recently",
						"std"			=> "1",
						"type"			=> "checkbox");

	$options[] = array( "name"			=> esc_html__( "Display recent portfolio orientation", "kreativa" ),
						"desc"			=> esc_html__( "Display recent portfolio orientation", 'kreativa' ),
						"id"			=> "portfolio_related_format",
						"std"			=> "landscape",
						"type"			=> "select",
						"options"	=> array(
							'landscape'		=> 'Landscape',
							'portrait' 		=> 'Portrait')
						);

	$options[] = array( "name"			=> esc_html__("Portfolio permalink slug (Important Note below)","kreativa"),
						"desc"			=> esc_html__("Slug name used in portfolio permalink. IMPORTANT NOTE: After changing this please make sure to flush the old cache by visiting wp-admin > Settings > Permalinks","kreativa"),
						"id"			=> "portfolio_permalink_slug",
						"std"			=> "project",
						"class"			=> "tiny",
						"type"			=> "text");

	$options[] = array( "name"			=> esc_html__("Portfolio refered as ( Singular )","kreativa"),
						"desc"			=> esc_html__("Text name to refer portfolio as a singular ( one item )","kreativa"),
						"id"			=> "portfolio_singular_refer",
						"std"			=> "Project",
						"class"			=> "tiny",
						"type"			=> "text");

	$options[] = array( "name"			=> esc_html__("Portfolio refered as ( Plural )","kreativa"),
						"desc"			=> esc_html__("Text name to refer portfolio as plural ( many items )","kreativa"),
						"id"			=> "portfolio_plural_refer",
						"std"			=> "Projects",
						"class"			=> "tiny",
						"type"			=> "text");

	$options[] = array( "name"			=> esc_html__("Portfolio carousel heading","kreativa"),
						"desc"			=> esc_html__("Portfolio carousel heading displayed in single post page","kreativa"),
						"id"			=> "portfolio_carousel_heading",
						"std"			=> "In Portfolios",
						"class"			=> "tiny",
						"type"			=> "text");

	$options[] = array( "name"			=> esc_html__("Filter tag for all Items","kreativa"),
						"desc"			=> esc_html__("Displays as a filterable tag in place of all items","kreativa"),
						"id"			=> "portfolio_allitems",
						"std"			=> "All Projects",
						"class"			=> "tiny",
						"type"			=> "text");

$options[] = array( "name"			=> esc_html__("Proofing", "kreativa" ),
					"icon"			=> 'fa fa-th',
					"type"			=> "heading");

	$options[] = array( "name"			=> esc_html__( "Proofing Gallery image ID", "kreativa" ),
						"desc"			=> esc_html__( "Proofing Gallery image ID", 'kreativa' ),
						"id"			=> "proofing_image_id",
						"std"			=> "default",
						"type"			=> "select",
						"options"	=> array(
							'default'		=> 'Default',
							'filename'		=> 'File Name',
							'imagetitle' 		=> 'Image Title')
						);

	$options[] = array( "name"			=> esc_html__( "Default proofing archive list orientation", "kreativa" ),
						"desc"			=> esc_html__( "Default proofing archive list orientation", 'kreativa' ),
						"id"			=> "proofing_archive_format",
						"std"			=> "landscape",
						"type"			=> "select",
						"options"	=> array(
							'landscape'		=> 'Landscape',
							'portrait' 		=> 'Portrait')
						);

	$options[] = array( "name"			=> esc_html__("Number of thumbnail columns for Proofing archive listing", "kreativa" ),
						"desc"			=> esc_html__("Affects proofing archives. eg. Browsing proofing category links.", "kreativa" ),
						"id"			=> "proofing_achivelisting",
						"min"			=> "1",
						"max"			=> "4",
						"step"			=> "0",
						"unit"			=> 'columns',
						"std"			=> "3",
						"type"			=> "text");

$options[] = array( "name"			=> esc_html__("Blog", "kreativa" ),
					"icon"			=> 'fa fa-th',
					"type"			=> "heading");
					
	$options[] = array( "name"			=> esc_html__("Display Fullpost Archives", "kreativa" ),
						"desc"			=> esc_html__("Display fullpost archives", "kreativa" ),
						"id"			=> "postformat_fullcontent",
						"std"			=> "0",
						"type"			=> "checkbox");

	$options[] = array( "name"			=> esc_html__("Display Author Bio", "kreativa" ),
						"desc"			=> esc_html__("Display Author Bio", "kreativa" ),
						"id"			=> "author_bio",
						"std"			=> "0",
						"type"			=> "checkbox");

	$options[] = array( "name"			=> esc_html__("Read more text", "kreativa" ),
						"desc"			=> esc_html__("Enter text for Read more", "kreativa" ),
						"id"			=> "read_more",
						"std"			=> "Continue reading",
						"class"			=> "small",
						"type"			=> "text");

$options[] = array( "name"			=> esc_html__("Page Title", "kreativa" ),
					"icon"			=> 'fa fa-header',
					"type"			=> "heading");

	$options[] = array( "name"			=> esc_html__("Hide Page title", "kreativa" ),
						"desc"			=> esc_html__("Hide Page title from all pages", "kreativa" ),
						"id"			=> "hide_pagetitle",
						"std"			=> "0",
						"type"			=> "checkbox");

	$options[] = array( "name"			=> esc_html__( "Page title background color", "kreativa" ),
						"desc"			=> esc_html__( "Page title background color", "kreativa" ),
						"id"			=> "pagetitle_bgcolor",
						"std"			=> "",
						"type"			=> "color");

	$options[] = array( "name"			=> esc_html__( "Page title color", "kreativa" ),
						"desc"			=> esc_html__( "Page title color", "kreativa" ),
						"id"			=> "pagetitle_color",
						"std"			=> "",
						"type"			=> "color");

	$options[] = array( "name"			=> esc_html__("Page title size", "kreativa" ),
						"desc"			=> esc_html__("Page title size in pixels. eg. 42", "kreativa" ),
						"id"			=> "pagetitle_size",
						"std"			=> "",
						"class"			=> "small",
						"type"			=> "text");

	$options[] = array( "name"			=> esc_html__("Page title letter spacing", "kreativa" ),
						"desc"			=> esc_html__("Page title letter spacing in pixels. eg. 6", "kreativa" ),
						"id"			=> "pagetitle_letterspacing",
						"std"			=> "",
						"class"			=> "small",
						"type"			=> "text");

	$options[] = array( "name"			=> esc_html__("Page title weight", "kreativa" ),
						"desc"			=> esc_html__("Page title weight. eg. 100, 200, 300, 400, 500, 600, 700, 800, 900", "kreativa" ),
						"id"			=> "pagetitle_weight",
						"std"			=> "",
						"class"			=> "small",
						"type"			=> "text");

$options[] = array( "name"			=> esc_html__("Menu Text", "kreativa" ),
					"icon"			=> 'fa fa-text-height',
					"type"			=> "heading");

	$options[] = array( "name"			=> esc_html__("Capitalize Menu", "kreativa" ),
						"desc"			=> esc_html__("Capitalize Menu", "kreativa" ),
						"id"			=> "menu_text_capitalize",
						"std"			=> "0",
						"type"			=> "checkbox");

	$options[] = array( "name"			=> esc_html__("Menu text size", "kreativa" ),
						"desc"			=> esc_html__("Menu text size. eg. 14", "kreativa" ),
						"id"			=> "hmenu_text_size",
						"std"			=> "",
						"class"			=> "small",
						"type"			=> "text");

	$options[] = array( "name"			=> esc_html__("Menu text letter spacing", "kreativa" ),
						"desc"			=> esc_html__("Menu text letter spacing in pixels. eg. 2", "kreativa" ),
						"id"			=> "hmenu_text_letterspacing",
						"std"			=> "",
						"class"			=> "small",
						"type"			=> "text");

	$options[] = array( "name"			=> esc_html__("Menu text weight", "kreativa" ),
						"desc"			=> esc_html__("Menu text weight. eg. 100, 200, 300, 400, 500, 600, 700, 800, 900", "kreativa" ),
						"id"			=> "hmenu_text_weight",
						"std"			=> "",
						"class"			=> "small",
						"type"			=> "text");

	$options[] = array( "name"			=> __("Horizontal Menu item gap", "kreativa" ),
						"desc"			=> __("Horizontal Menu item gap. eg. 20", "kreativa" ),
						"id"			=> "hmenu_item_gap",
						"std"			=> "",
						"class"			=> "small",
						"type"			=> "text");

$options[] = array( "name"			=> esc_html__("Content Text", "kreativa" ),
					"icon"			=> 'fa fa-text-height',
					"type"			=> "heading");

		$options[] = array( "name"			=> esc_html__("Content Font Size", "kreativa" ),
						"desc"			=> esc_html__("Contents font size in pixels.", "kreativa" ),
						"id"			=> "pagecontent_fontsize",
						"std"			=> "",
						"class"			=> "small",
						"type"			=> "text");

		$options[] = array( "name"			=> esc_html__("Content line height", "kreativa" ),
						"desc"			=> esc_html__("Contents line height in pixels.", "kreativa" ),
						"id"			=> "pagecontent_lineheight",
						"std"			=> "",
						"class"			=> "small",
						"type"			=> "text");

		$options[] = array( "name"			=> esc_html__("Content letter spacing", "kreativa" ),
						"desc"			=> esc_html__("Content letter spacing in pixels.", "kreativa" ),
						"id"			=> "pagecontent_letterspacing",
						"std"			=> "",
						"class"			=> "small",
						"type"			=> "text");

		$options[] = array( "name"			=> esc_html__("Content font weight", "kreativa" ),
						"desc"			=> esc_html__("Content font weight.(100,200,300,400,500,600,700,800,900)", "kreativa" ),
						"id"			=> "pagecontent_fontweight",
						"std"			=> "",
						"class"			=> "small",
						"type"			=> "text");

$options[] = array( "name"			=> esc_html__("Lightbox", "kreativa" ),
					"icon"			=> 'fa fa-star',
					"type"			=> "heading");

	$options[] = array( "name"			=> esc_html__("Disable Lightbox fullscreen button", "kreativa" ),
						"desc"			=> esc_html__("Disable Lightbox fullscreen", "kreativa" ),
						"id"			=> "disable_lightbox_fullscreen",
						"std"			=> "0",
						"type"			=> "checkbox");

	$options[] = array( "name"			=> esc_html__("Disable Lightbox actual size toggle", "kreativa" ),
						"desc"			=> esc_html__("Disable Lightbox actual size toggle", "kreativa" ),
						"id"			=> "disable_lightbox_sizetoggle",
						"std"			=> "0",
						"type"			=> "checkbox");

	$options[] = array( "name"			=> esc_html__("Disable Lightbox zoom controls", "kreativa" ),
						"desc"			=> esc_html__("Disable Lightbox zoom controls", "kreativa" ),
						"id"			=> "disable_lightbox_zoomcontrols",
						"std"			=> "0",
						"type"			=> "checkbox");

	$options[] = array( "name"			=> esc_html__("Disable Lightbox autoplay button", "kreativa" ),
						"desc"			=> esc_html__("Disable Lightbox autoplay button", "kreativa" ),
						"id"			=> "disable_lightbox_autoplay",
						"std"			=> "0",
						"type"			=> "checkbox");

	$options[] = array( "name"			=> esc_html__("Disable Lightbox count button", "kreativa" ),
						"desc"			=> esc_html__("Disable Lightbox count button", "kreativa" ),
						"id"			=> "disable_lightbox_count",
						"std"			=> "0",
						"type"			=> "checkbox");

	$options[] = array( "name" => esc_html__( "Lightbox Transition", 'kreativa' ),
						"desc" => esc_html__( "Lightbox Transition", 'kreativa' ),
						"id" => "lightbox_transition",
						"std" => "true",
						"type" => "select",
						"class" => "mini",
						"options" 	=> array(
							'lg-slide'                       => 'Slide',
							'lg-fade'                        => 'Fade',
							'lg-zoom-in'                     => 'Zoom in',
							'lg-zoom-in-big'                 => 'Zoom in Big', 
							'lg-zoom-out'                    => 'Zoom Out',
							'lg-zoom-out-big'                => 'Zoom Out big', 
							'lg-zoom-out-in'                 => 'Zoom Out in',
							'lg-zoom-in-out'                 => 'Zoom in Out',
							'lg-soft-zoom'                   => 'Soft Zoom', 
							'lg-scale-up'                    => 'Scale Up', 
							'lg-slide-circular'              => 'Slide Circular', 
							'lg-slide-circular-vertical'     => 'Slide Circular vertical', 
							'lg-slide-vertical'              => 'Slide Vertical', 
							'lg-slide-vertical-growth'       => 'Slide Vertical growth', 
							'lg-slide-skew-only'             => 'Slide Skew only', 
							'lg-slide-skew-only-rev'         => 'Slide Skew only reverse',
							'lg-slide-skew-only-y'           => 'Slide Skew only y', 
							'lg-slide-skew-only-y-rev'       => 'Slide Skew only y reverse',
							'lg-slide-skew'                  => 'Slide Skew', 
							'lg-slide-skew-rev'              => 'Slide Skew reverse',
							'lg-slide-skew-cross'            => 'Slide Skew cross', 
							'lg-slide-skew-cross-rev'        => 'Slide Skew cross reverse',
							'lg-slide-skew-ver'              => 'Slide Skew vertically', 
							'lg-slide-skew-ver-rev'          => 'Slide Skew vertically reverse',
							'lg-slide-skew-ver-cross'        => 'Slide Skew vertically cross', 
							'lg-slide-skew-ver-cross-rev'    => 'Slide Skew vertically cross reverse',
							'lg-lollipop'                    => 'Lollipop', 
							'lg-lollipop-rev'                => 'Lollipop reverse',
							'lg-rotate'                      => 'Rotate', 
							'lg-rotate-rev'                  => 'Rotate reverse',
							'lg-tube'                        => 'Tube',
							)
						);

	$options[] = array( "name"			=> esc_html__("Disable Lightbox title", "kreativa" ),
						"desc"			=> esc_html__("Disable Lightbox title", "kreativa" ),
						"id"			=> "disable_lightbox_title",
						"std"			=> "0",
						"type"			=> "checkbox");

	$options[] = array( "name"			=> esc_html__( "Lightbox background color", "kreativa" ),
						"desc"			=> esc_html__( "Lightbox background color", "kreativa" ),
						"id"			=> "lightbox_bgcolor",
						"std"			=> "",
						"type"			=> "color");

	$options[] = array( "name"			=> esc_html__( "Lightbox element background color", "kreativa" ),
						"desc"			=> esc_html__( "Lightbox element background color", "kreativa" ),
						"id"			=> "lightbox_elementbgcolor",
						"std"			=> "",
						"type"			=> "color");

	$options[] = array( "name"			=> esc_html__( "Lightbox element color", "kreativa" ),
						"desc"			=> esc_html__( "Lightbox element color", "kreativa" ),
						"id"			=> "lightbox_elementcolor",
						"std"			=> "",
						"type"			=> "color");

$options[] = array( "name"			=> esc_html__("Sidebars", "kreativa" ),
					"icon"			=> 'fa fa-newspaper-o',
					"type"			=> "heading");

	$max_sidebars = kreativa_get_max_sidebars();
	for ($sidebar_count=1; $sidebar_count <= $max_sidebars; $sidebar_count++ ) {

	$options[] = array( "name"			=> esc_html__("Sidebar ", "kreativa" ) . $sidebar_count,
							"type"			=> "info");
						
		$options[] = array( "name"			=> esc_html__("Sidebar Name", "kreativa" ),
						"desc"			=> esc_html__("Activate sidebars by naming them.", "kreativa" ),
						"id"			=> "mthemesidebar-".$sidebar_count,
						"std"			=> "",
						"class"			=> "small",
						"type"			=> "text");

		$options[] = array( "name"			=> esc_html__("Sidebar Description", "kreativa" ),
						"desc"			=> esc_html__("A small description to display inside the widget to easily identify it. Widget description is only shown in admin mode inside the widget.", "kreativa" ),
						"id"			=> "theme_sidebardesc".$sidebar_count,
						"std"			=> "",
						"class"			=> "small",
						"type"			=> "text");
	}

$options[] = array( "name"			=> esc_html__("Accent Color", "kreativa" ),
				"icon"			=> 'fa fa-paint-brush',
				"type"			=> "heading",
				"subheading"			=> 'header_section_order');

		$options[] = array( "name"			=> esc_html__( "Accent color sitewide", "kreativa" ),
							"desc"			=> esc_html__( "Accent color sitewide", "kreativa" ),
							"id"			=> "accent_color",
							"std"			=> "",
							"type"			=> "color");

$options[] = array( "name"			=> esc_html__("Vertical Menu Color", "kreativa" ),
				"icon"			=> 'fa fa-paint-brush',
				"type"			=> "heading",
				"subheading"			=> 'header_section_order');

	$options[] = array( "name"			=> esc_html__( "Use an image as Vertical menu background", 'kreativa' ),
						"desc"			=> esc_html__( "Use an image as Vertical menu background", 'kreativa' ),
						"id"			=> "verticalmenu_bgimage",
						"type"			=> "upload");

		$options[] = array( "name"			=> esc_html__( "Menu background color", "kreativa" ),
							"desc"			=> esc_html__( "Menu background color", "kreativa" ),
							"id"			=> "vmenubar_bgcolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> esc_html__( "Menu link color", "kreativa" ),
							"desc"			=> esc_html__( "Menu link color", "kreativa" ),
							"id"			=> "vmenubar_linkcolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> esc_html__( "Menu horizontal lines", "kreativa" ),
							"desc"			=> esc_html__( "Menu horizontal lines", "kreativa" ),
							"id"			=> "vmenubar_hlinecolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> esc_html__( "Menu link hover color", "kreativa" ),
							"desc"			=> esc_html__( "Menu link hover color", "kreativa" ),
							"id"			=> "vmenubar_linkhovercolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> esc_html__( "Opened Menu link color", "kreativa" ),
							"desc"			=> esc_html__( "Opened Menu link color", "kreativa" ),
							"id"			=> "vmenubar_linkactivecolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> esc_html__( "Social icon color", "kreativa" ),
							"desc"			=> esc_html__( "Social icon color", "kreativa" ),
							"id"			=> "vmenubar_socialcolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> esc_html__( "Footer text color", "kreativa" ),
							"desc"			=> esc_html__( "Footer text color", "kreativa" ),
							"id"			=> "vmenubar_footercolor",
							"std"			=> "",
							"type"			=> "color");

$options[] = array( "name"			=> __("Horizontal Menu Color", "kreativa" ),
				"icon"			=> 'fa fa-paint-brush',
				"type"			=> "heading",
				"subheading"			=> 'header_section_order');

		$options[] = array( "name"			=> __( "Menu color", "kreativa" ),
							"desc"			=> __( "Menu color", "kreativa" ),
							"id"			=> "menubar_backgroundcolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name" => __( "Menu bar opacity ( default 80 )", 'kreativa' ),
							"desc" => __( "Note: Only applies if a color is set as menu color", 'kreativa' ),
							"id" => "menubar_backgroundopacity",
							"min" => "0",
							"max" => "100",
							"step" => "0",
							"unit" => '%',
							"std" => "85",
							"type" => "text");

		$options[] = array( "name"			=> __( "Menu link color", "kreativa" ),
							"desc"			=> __( "Menu link color", "kreativa" ),
							"id"			=> "menu_linkcolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> __( "Menu link hover color", "kreativa" ),
							"desc"			=> __( "Menu link hover color", "kreativa" ),
							"id"			=> "menu_linkhovercolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> __( "Current menu link color", "kreativa" ),
							"desc"			=> __( "Current menu link color", "kreativa" ),
							"id"			=> "currentmenu_linkcolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> __( "Submenu background color", "kreativa" ),
							"desc"			=> __( "Submenu  background color", "kreativa" ),
							"id"			=> "menusubcat_bgcolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> __( "Submenu link color", "kreativa" ),
							"desc"			=> __( "Submenu link color", "kreativa" ),
							"id"			=> "menusubcat_linkcolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> __( "Submenu link hover color", "kreativa" ),
							"desc"			=> __( "Submenu link hover color", "kreativa" ),
							"id"			=> "menusubcat_linkhovercolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> __( "Submenu link underline color", "kreativa" ),
							"desc"			=> __( "Submenu link underline color", "kreativa" ),
							"id"			=> "menusubcat_linkunderlinecolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> __( "Current Submenu link color", "kreativa" ),
							"desc"			=> __( "Current Submenu link color", "kreativa" ),
							"id"			=> "currentmenusubcat_linkcolor",
							"std"			=> "",
							"type"			=> "color");
		
$options[] = array( "name"			=> esc_html__("Responsive Menu", "kreativa" ),
				"icon"			=> 'fa fa-paint-brush',
				"type"			=> "heading",
				"subheading"			=> 'header_section_order');

		$options[] = array( "name"			=> esc_html__( "Responsive Menu bar color", "kreativa" ),
							"desc"			=> esc_html__( "Responsive Menu bar color", "kreativa" ),
							"id"			=> "mobilemenubar_bgcolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> esc_html__( "Responsive Menu toggle icon color", "kreativa" ),
							"desc"			=> esc_html__( "Responsive Menu toggle icon color", "kreativa" ),
							"id"			=> "mobilemenubar_togglecolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> esc_html__( "Responsive Menu background color", "kreativa" ),
							"desc"			=> esc_html__( "Responsive Menu background color", "kreativa" ),
							"id"			=> "mobilemenu_bgcolor",
							"std"			=> "",
							"type"			=> "color");

	$options[] = array( "name"			=> esc_html__( "Use an image as Responsive menu background", 'kreativa' ),
						"desc"			=> esc_html__( "Use an image as Responsive menu background", 'kreativa' ),
						"id"			=> "mobilemenu_bgimage",
						"type"			=> "upload");

		$options[] = array( "name"			=> esc_html__( "Responsive Menu text and icon color", "kreativa" ),
							"desc"			=> esc_html__( "Responsive Menu text and icon color", "kreativa" ),
							"id"			=> "mobilemenu_texticons",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> esc_html__( "Responsive Menu hover color", "kreativa" ),
							"desc"			=> esc_html__( "Responsive Menu hover color", "kreativa" ),
							"id"			=> "mobilemenu_hover",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> esc_html__( "Responsive Opened Menu color", "kreativa" ),
							"desc"			=> esc_html__( "Responsive Opened Menu color", "kreativa" ),
							"id"			=> "mobilemenu_active",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> esc_html__( "Responsive Menu line colors", "kreativa" ),
							"desc"			=> esc_html__( "Responsive Menu line colors", "kreativa" ),
							"id"			=> "mobilemenu_linecolors",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> esc_html__( "Responsive Footer text colors", "kreativa" ),
							"desc"			=> esc_html__( "Responsive Footer text colors", "kreativa" ),
							"id"			=> "mobilemenu_footercolors",
							"std"			=> "",
							"type"			=> "color");

$options[] = array( "name"				=> esc_html__("Page Color", "kreativa" ),
					"icon"			=> 'fa fa-paint-brush',
					"type"				=> "heading",
					"subheading"		=> 'header_section_order');

		$options[] = array( "name"			=> esc_html__( "Page background color", "kreativa" ),
							"desc"			=> esc_html__( "Page background color", "kreativa" ),
							"id"			=> "page_bgcolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> esc_html__( "Page contents color", "kreativa" ),
							"desc"			=> esc_html__( "Page contents color", "kreativa" ),
							"id"			=> "page_contentscolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> esc_html__( "Page contents heading color", "kreativa" ),
							"desc"			=> esc_html__( "Page contents heading color", "kreativa" ),
							"id"			=> "page_contentsheading",
							"std"			=> "",
							"type"			=> "color");

$options[] = array( "name"				=> esc_html__("Sidebar Color", "kreativa" ),
					"icon"			=> 'fa fa-paint-brush',
					"type"				=> "heading",
					"subheading"		=> 'header_section_order');

		$options[] = array( "name"			=> esc_html__( "Sidebar heading color", "kreativa" ),
							"desc"			=> esc_html__( "Sidebar heading color", "kreativa" ),
							"id"			=> "sidebar_headingcolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> esc_html__( "Sidebar link color", "kreativa" ),
							"desc"			=> esc_html__( "Sidebar link color", "kreativa" ),
							"id"			=> "sidebar_linkcolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> esc_html__( "Sidebar text color", "kreativa" ),
							"desc"			=> esc_html__( "Sidebar text color", "kreativa" ),
							"id"			=> "sidebar_textcolor",
							"std"			=> "",
							"type"			=> "color");

		$options[] = array( "name"			=> esc_html__( "Sidebar backgrounds", "kreativa" ),
							"desc"			=> esc_html__( "Sidebar backgrounds", "kreativa" ),
							"id"			=> "sidebar_bgcolor",
							"std"			=> "",
							"type"			=> "color");

	$options[] = array( "name" => "Footer Color",
					"icon"			=> 'fa fa-paint-brush',
					"type" => "heading",
					"subheading" => 'header_section_order');

		$options[] = array( "name" => "Footer background",
							"desc" => "Footer background",
							"id" => "footer_bgcolor",
							"std" => "",
							"type" => "color");

	$options[] = array( "name" => "Footer text color",
						"desc" => "Footer text color",
						"id" => "footer_text",
						"std" => "",
						"type" => "color");

	$options[] = array( "name" => "Footer text link color",
						"desc" => "Footer text link color",
						"id" => "footer_link",
						"std" => "",
						"type" => "color");

	$options[] = array( "name" => "Footer text link hover color",
						"desc" => "Footer text link hover color",
						"id" => "footer_linkhover",
						"std" => "",
						"type" => "color");

	$options[] = array( "name" => "Footer icon color",
						"desc" => "Footer icon color",
						"id" => "footer_iconcolor",
						"std" => "",
						"type" => "color");

						
$options[] = array( "name"			=> esc_html__("Fonts", "kreativa" ),
					"icon"			=> 'fa fa-font',
					"type"			=> "heading");
					
$options[] = array( "name"			=> esc_html__("Enable Google Web Fonts", "kreativa" ),
					"desc"			=> esc_html__("Enable Google Web fonts", "kreativa" ),
					"id"			=> "default_googlewebfonts",
					"std"			=> "0",
					"type"			=> "checkbox");

	$options[] = array(	"name"			=> esc_html__("Slideshow Title font","kreativa"),
						"desc"			=> esc_html__("Select font for slideshow title","kreativa"),
						"id"			=> "super_title",
						"std"			=> 'Default Font',
						"type"			=> "selectgooglefont",
						"class"			=> "small", //mini, tiny, small
						"options"			=> $options_fonts);	

	$options[] = array(	"name"			=> esc_html__("Slideshow Caption font","kreativa"),
						"desc"			=> esc_html__("Select font for slideshow caption","kreativa"),
						"id"			=> "super_caption",
						"std"			=> 'Default Font',
						"type"			=> "selectgooglefont",
						"class"			=> "small", //mini, tiny, small
						"options"			=> $options_fonts);

	$options[] = array(	"name"			=> esc_html__("Hero image title","kreativa"),
						"desc"			=> esc_html__("Select font for hero title","kreativa"),
						"id"			=> "hero_title",
						"std"			=> 'Default Font',
						"type"			=> "selectgooglefont",
						"class"			=> "small", //mini, tiny, small
						"options"			=> $options_fonts);	
						
	$options[] = array(	"name"			=> esc_html__("Menu Font", "kreativa" ),
						"desc"			=> esc_html__("Select menu font", "kreativa" ),
						"id"			=> "menu_font",
						"std"			=> '',
						"type"			=> "selectgooglefont",
						"class"			=> "small", //mini, tiny, small
						"options"			=> $options_fonts);
						
	$options[] = array(	"name"			=> esc_html__("Heading Font (applies to all headings)", "kreativa" ),
						"desc"			=> esc_html__("Select heading font", "kreativa" ),
						"id"			=> "heading_font",
						"std"			=> '',
						"type"			=> "selectgooglefont",
						"class"			=> "small", //mini, tiny, small
						"options"			=> $options_fonts);	
						
	$options[] = array(	"name"			=> esc_html__("Contents", "kreativa" ),
						"desc"			=> esc_html__("Select font for headings inside posts and pages", "kreativa" ),
						"id"			=> "page_contents",
						"std"			=> '',
						"type"			=> "selectgooglefont",
						"class"			=> "small", //mini, tiny, small
						"options"			=> $options_fonts);

$options[] = array( "name"			=> esc_html__("Custom Font", "kreativa" ),
					"icon"			=> 'fa fa-font',
					"type"			=> "heading",
					"subheading"			=> 'default_googlewebfonts');

	$options[] = array( "name"			=> esc_html__("Font Embed Code", "kreativa" ),
						"desc"			=> esc_html__("eg. &lt;link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'&gt;", "kreativa" ),
						"id"			=> "custom_font_embed",
						"std"			=> '',
						"type"			=> "textarea");

	$options[] = array( "name"			=> esc_html__("CSS Codes for Custom Font", "kreativa" ),
						"desc"			=> esc_html__("eg. .entry-title h1 { font-family: 'Lobster', cursive; }", "kreativa" ),
						"id"			=> "custom_font_css",
						"std"			=> '',
						"type"			=> "textarea");

$options[] = array( "name"			=> esc_html__("WPML", "kreativa" ),
					"icon"			=> 'fa fa-globe',
					"type"			=> "heading");

	$options[] = array( "name"			=> esc_html__( "Enable Built-in WPML language selector", 'kreativa' ),
						"desc"			=> esc_html__( "Enable Built-in WPML language selector", 'kreativa' ),
						"id"			=> "wpml_lang_selector_enable",
						"std"			=> "0",
						"type"			=> "checkbox");

$options[] = array( "name"			=> esc_html__("WooCommerce", "kreativa" ),
					"icon"			=> 'fa fa-shopping-cart',
					"type"			=> "heading");

		$options[] = array( "name"			=> esc_html__("WooCommerce Shop default title", "kreativa" ),
						"desc"			=> esc_html__("Shop title for WooCommerce shop. ( default 'Shop' ).", "kreativa" ),
						"id"			=> "mtheme_woocommerce_shoptitle",
						"std"			=> "Shop",
						"class"			=> "small",
						"type"			=> "text");

	$options[] = array( "name"			=> esc_html__( "Shop Archive with sidebar", 'kreativa' ),
						"desc"			=> esc_html__( "Display shop archive with sidebar", 'kreativa' ),
						"id"			=> "mtheme_wooarchive_sidebar",
						"std"			=> "0",
						"type"			=> "checkbox");
						
$options[] = array( "name"			=> esc_html__("Footer", "kreativa" ),
					"icon"			=> 'fa fa-arrows-h',
					"type"			=> "heading");
					
	$options[] = array( "name"			=> esc_html__("Vertical Menu footer Copyright text", "kreativa" ),
						"desc"			=> esc_html__("Enter vertical menu copyright text", "kreativa" ),
						"id"			=> "footer_vmenu",
						"std"			=> "All rights reserved<br/>Copyright &copy;2017<br/>Photography Wordpress",
						"type"			=> "textarea");

	$options[] = array( "name"			=> esc_html__("Page footer Copyright text", "kreativa" ),
						"desc"			=> esc_html__("Enter your copyright and other texts to display in page footer", "kreativa" ),
						"id"			=> "footer_copyright",
						"std"			=> "Copyright &copy; 2017",
						"type"			=> "textarea");

$options[] = array( "name"			=> esc_html__("Export", "kreativa" ),
					"icon"			=> 'fa fa-upload',
					"type"			=> "heading");

	$options[] = array( "name"			=> esc_html__("Export Options ( Copy this ) Read-Only.", "kreativa" ),
						"desc"			=> esc_html__("Select All, copy and store your theme options backup. You can use these value to import theme options settings.", "kreativa" ),
						"id"			=> "exportpack",
						"std"			=> '',
						"class"			=> "big",
						"type"			=> "exporttextarea");

$options[] = array( "name"			=> esc_html__("Import Options", "kreativa" ),
					"icon"			=> 'fa fa-download',
					"type"			=> "heading",
					"subheading"		=> 'exportpack');

	$options[] = array( "name"			=> esc_html__("Import Options ( Paste and Save )", "kreativa" ),
						"desc"			=> esc_html__("CAUTION: Copy and Paste the Export Options settings into the window and Save to apply theme options settings.", "kreativa" ),
						"id"			=> "importpack",
						"std"			=> '',
						"class"			=> "big",
						"type"			=> "importtextarea");

	return $options;
}
?>