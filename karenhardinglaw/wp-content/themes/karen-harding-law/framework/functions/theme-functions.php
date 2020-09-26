<?php
// Password form
add_action('kreativa_display_password_form','kreativa_display_password_form_action');
function kreativa_display_password_form_action() {
	echo '<div id="password-protected" class="clearfix">';
	echo '<div class="is-animated animated blurIn"><i class="ion-ios-locked-outline"></i></div>';
	echo '<div class="is-animated animated flipInX">';
	echo '<div class="entry-content password-form-padding">';
	do_action('kreativa_demo_password');
	echo get_the_password_form();
	echo '</div>';
	echo '</div>';
	echo '</div>';
}
function kreativa_social_screen_modal() {
echo '<div id="social-modal">';
	echo '<div class="social-modal-outer">';
		echo '<div class="social-modal-inner">';
			echo '<div class="social-modal-text">';
				echo '<span class="social-modal-cross"><i class="ion-ios-close-empty"></i></span>';
				get_template_part('/includes/share','page');
			echo '</div>';
		echo '</div>';
	echo '</div>';
echo '</div>';
}
add_action( 'kreativa_social_screen', 'kreativa_social_screen_modal');
function kreativa_contextmenu_msg_enable() {
	$rightclicktext = kreativa_get_option_data('rightclick_disabletext');
	echo '<div id="dimmer"><div class="dimmer-outer"><div class="dimmer-inner"><div class="dimmer-text">'.$rightclicktext.'</div></div></div></div>';
}
function kreativa_display_elementloader() {
	$start_loading_tag = '';
	$end_loading_tag = '';
	return $start_loading_tag . '<div class="loading-spinner">
	<div class="loading-right-side">
		<div class="loading-bar"></div>
	</div>
	<div class="loading-left-side">
		<div class="loading-bar"></div>
	</div>
</div>' . $end_loading_tag;
}
/**
 * [kreativa_language_selector_flags description]
 * @return [type] [description]
 */
function kreativa_language_selector_flags(){
	if ( function_exists('icl_get_languages') ) {
	    $languages = icl_get_languages('skip_missing=0&orderby=code');
	    if(!empty($languages)){
	        echo '<div class="wpml-flags-language-list"><ul>';
	        foreach($languages as $l){
	        	if(!$l['active']) { echo '<li class="selectable">'; } else { echo '<li class="non-selectable language-active">'; }
	            
	            if($l['country_flag_url']){
	                if(!$l['active']) { echo '<a href="'.$l['url'].'">'; }
	                echo '<img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" />';
	                if(!$l['active']) { echo '</a>'; }
	            }
	            if(!$l['active']) { echo '<a href="'.$l['url'].'">'; }
	            echo icl_disp_language($l['native_name']);
	            if(!$l['active']) { echo '</a>'; }
	            echo '</li>';
	        }
	        echo '</ul></div>';
	    }
	}
}
/**
 * [kreativa_is_in_demo description]
 * @param  boolean $output [description]
 * @return [type]          [description]
 */
function kreativa_is_in_demo( $output = false ) {
	$output = false;
	if ( function_exists('kreativa_demo_panel_init') ) {
		$output = true;
	} else {
		$output = false;
	}
	return $output;
}
add_action( 'kreativa_page_necessities', 'kreativa_page_necessities_build');
function kreativa_page_necessities_build( $got_page_id=false ) {
	if ( is_singular() ) {
		if (!$got_page_id) {
			$page_data = get_post_custom( get_the_id() );
		}
		if (isSet($page_data['pagemeta_pagestyle'][0])) {
			$pagestyle = $page_data['pagemeta_pagestyle'][0];
			if ($pagestyle=="split-page") {
				echo '<div class="split-page-image"></div>';
			}
		}
	}
}
function kreativa_menu_is_vertical ($output = false) {
	$output = false;
	$header_menu_type = kreativa_get_option_data('header_menu_type');
	if (kreativa_is_in_demo()) {
		if ( false != kreativa_demo_get_data('menu_type') ) {
			$header_menu_type = kreativa_demo_get_data('menu_type');
		}
	}
	if ($header_menu_type=="vertical-menu" || $header_menu_type=="vertical-menu-right" ) {
		$output = true;
	}	
	return $output;
}
function kreativa_menu_is_horizontal ($output = false) {
	$output = false;
	$header_menu_type = kreativa_get_option_data('header_menu_type');
	if (kreativa_is_in_demo()) {
		if ( false != kreativa_demo_get_data('menu_type') ) {
			$header_menu_type = kreativa_demo_get_data('menu_type');
		}
	}
	if ($header_menu_type=="left-detatched" ) {
		$output = true;
	}	
	return $output;
}
function kreativa_page_supports_fullscreen( $got_page_id=false ) {
	$status = false;
	if (!$got_page_id) {
		$got_page_id = get_the_id();
	}

	if (kreativa_is_fullscreen_post()) {
		$status = true;
	}

	$custom = get_post_custom( $got_page_id );
	if ( isSet($custom[ "pagemeta_fullscreen_type"][0]) ) {
		$fullscreen_type = $custom[ "pagemeta_fullscreen_type"][0];
		if ($fullscreen_type=="photowall" || $fullscreen_type=="carousel" || $fullscreen_type=="swiperslides" ) {
				$status = false;
		}
	}
	if ( post_password_required() ) {
		$status = false;
	}

	return $status;
}
function kreativa_get_background_choice( $got_page_id=false ) {

	$kreativa_background_choice = false;

	if ($got_page_id) {
		$kreativa_background_choice= get_post_meta( $got_page_id, 'pagemeta_meta_background_choice', true);
		if (!isSet($kreativa_background_choice) ) {
			$kreativa_background_choice="none";
		}
		$site_in_maintenance = kreativa_maintenance_check();
		if ( $site_in_maintenance ) {
			$kreativa_background_choice="none";
		}
	}

	return $kreativa_background_choice;
}
function kreativa_maintenance_check() {
	global $current_user;

	$site_in_maintenance	= kreativa_get_option_data( 'maintenance_mode' );
	$manage_options			= current_user_can( 'manage_options' );

	$maintenance = false;
	$maintenance_mode = false;

	if ( $site_in_maintenance && $manage_options == false ) {
		$maintenance = true;
	} else {
		$maintenance = false;
		if (kreativa_is_in_demo()) {
			if ( false != kreativa_demo_get_data('maintenance_mode') ) {
				$maintenance_mode = kreativa_demo_get_data('maintenance_mode');
			}
			if ($maintenance_mode=="active") {
				$maintenance = true;
			}
		}
	}
	return $maintenance;
}
function kreativa_generate_swiperscript($preset_page_id=false){
	$header_menu_type = kreativa_get_option_data('header_menu_type');
	if (kreativa_is_in_demo()) {
		if ( false != kreativa_demo_get_data('menu_type') ) {
			$header_menu_type = kreativa_demo_get_data('menu_type');
		}
	}
	$featured_page = kreativa_get_active_fullscreen_post();
	$count=0;
	if ($preset_page_id) {
		$featured_page = $preset_page_id;
	}
	if (defined('ICL_LANGUAGE_CODE')) { // this is to not break code in case WPML is turned off, etc.
	    $_type  = get_post_type($featured_page);
	    $featured_page = icl_object_id($featured_page, $_type, true, ICL_LANGUAGE_CODE);
	}
	$filter_image_ids = kreativa_get_custom_attachments ( $featured_page );

	foreach ( $filter_image_ids as $attachment_id) {
		$attachment = get_post( $attachment_id );
		if (isSet($attachment->guid)) {
			$imageURI = $attachment->guid;

			$thumb_imagearray = wp_get_attachment_image_src( $attachment->ID , 'kreativa-gridblock-full', false);
			$thumb_imageURI = $thumb_imagearray[0];

			if ($thumb_imageURI<>"") {
				$count++;
			}
		}
	}

	$mid0_show_slides = 1;
	$mid1_show_slides = 1;
	$mid2_show_slides = 1;
	$min_show_slides = 1;
	$max_show_slides = $count;
	if ( $count > 2  ) {
		$mid0_show_slides = 3;
		$mid1_show_slides = 2;
		$mid2_show_slides = 2;
		$min_show_slides = 1;
	}
	if ( $count > 3  ) {
		$max_show_slides = 3;
		if ( kreativa_menu_is_vertical() ) {
			$max_show_slides = 3;
			$mid0_show_slides = 3;
			$mid1_show_slides = 2;
			$mid2_show_slides = 2;
			$min_show_slides = 1;
		}
	}
	$output = "jQuery(document).ready(function($){
		var swiper = new Swiper('.swiper-container', {
	    pagination: '.swiper-pagination',
	    paginationClickable: true,
	    loop: false,
	    autoplay: 6000,
	    speed: 1000,
	    grabCursor: true,
	    nextButton: '.swiper-button-next',
	    prevButton: '.swiper-button-prev',
	    slidesPerView: ".esc_js($max_show_slides).",
	    spaceBetween: 0,
	    breakpoints: {
	        1600: {
	            slidesPerView:".esc_js($mid0_show_slides).",
	            spaceBetween: 0
	        },
	        1400: {
	            slidesPerView:".esc_js($mid1_show_slides).",
	            spaceBetween: 0
	        },
	        1024: {
	            slidesPerView:".esc_js($mid2_show_slides).",
	            spaceBetween: 0
	        },
	        768: {
	            slidesPerView:".esc_js($min_show_slides).",
	            spaceBetween: 0
	        },
	        640: {
	            slidesPerView:".esc_js($min_show_slides).",
	            spaceBetween: 0
	        },
	        320: {
	            slidesPerView:".esc_js($min_show_slides).",
	            spaceBetween: 0
		        }
		    }
		});
	});";

	return $output;
}
function kreativa_proofing_is_password_protected() {
	$protection_status = false;
	$custom = get_post_custom( get_the_ID() );
	if (isset($custom['pagemeta_client_names'][0])) $client_id=$custom['pagemeta_client_names'][0];

	if ( post_password_required($client_id) ) {
		$protection_status = true;
	}

	return $protection_status;
}
function kreativa_demo_password_show() {
	if (kreativa_is_in_demo()) {
		return false;
	}
}
add_action( 'kreativa_demo_password', 'kreativa_demo_password_show');
function kreativa_preloader_enable() {
	echo '<div class="preloader-cover-screen">';
		$main_logo=kreativa_get_option_data('vmain_logo');
		echo '<div class="preloader-wrap">';
				echo '<div class="preloader-inner">';
echo '<div class="spinner-wrapper">
<svg class="spinner" viewBox="0 0 50 50">
  <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
</svg>
</div>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
}
function kreativa_screencover_enable() {
	echo '<div class="fullscreen-screencover"></div>';
}
add_action( 'kreativa_screencover', 'kreativa_screencover_enable');
function kreativa_display_client_details($client_id , $title = false , $desc = false , $eventdetails = false , $proofing_id = false , $pagetitle = false ) {

	if ( isSet($client_id) ) {
		$post_thumbnail_id = get_post_thumbnail_id( $client_id );
		$image_data = wp_get_attachment_image_src( $post_thumbnail_id, 'kreativa-gridblock-square-big', false );
		$image_link = $image_data[0];
		$client_data = get_post_custom($client_id);
		$proofing_data = get_post_custom( $proofing_id );
		$client_name = '';
		$client_desc = '';
		if (isset($proofing_data['pagemeta_proofing_startdate'][0])) $proofing_startdate=$proofing_data['pagemeta_proofing_startdate'][0];
		if (isset($proofing_data['pagemeta_proofing_location'][0])) $proofing_location=$proofing_data['pagemeta_proofing_location'][0];
		if (isset($client_data['pagemeta_client_name'][0])) {
			$client_name=$client_data['pagemeta_client_name'][0];
		}
		if (isset($client_data['pagemeta_client_desc'][0])) {
			$client_desc=$client_data['pagemeta_client_desc'][0];
		}

		$client_info = '<div class="proofing-client-wrap is-animated animated fadeInUpSlight">';
		
			$client_info .= '<div class="proofing-client-image"><img src="'.$image_link.'" alt="client" /></div>';
			$client_info .= '<div class="proofing-client-info-wrap">';
				if ($pagetitle) {
					$client_info .= '<div class="proofing-client-title is-animated animated flipInX"><h1>'.get_the_title( get_the_id() ).'</h1></div>';
				}
				if ($title) {
					$client_info .= '<div class="proofing-client-title is-animated animated flipInX">'.$client_name.'</div>';
				}
				if ( is_singular('mtheme_proofing') || is_singular('mtheme_clients') ) {

					$password_protected = false;
					if ( is_singular('mtheme_proofing') ) {
						$client_id_check = get_post_meta( get_the_id() , 'pagemeta_client_names', true);
						if ( isSet($client_id_check) ) {
							if ( post_password_required($client_id_check) ) {
								$password_protected = true;
							}
						}
					}
					if ( is_singular('mtheme_clients') ) {
						if ( post_password_required() ) {
							$password_protected = true;
						}
					}
					if ( !$password_protected ) {
						if ($desc) {
							$client_info .= '<div class="proofing-client-desc is-animated animated flipInX">'.$client_desc.'</div>';
						}
					}
				}
				if ($eventdetails) {
					$client_info .= '<ul class="event-details event-date-time">';
					if ( isSet($proofing_startdate) && $proofing_startdate<>"" ) {
						$client_info .= '<li><i class="feather-icon-clock"></i>' .$proofing_startdate.'</li>';
					}
					if ( isSet($proofing_location) && $proofing_location<>"" ) {
						$client_info .= '<li><i class="feather-icon-map"></i>' .$proofing_location.'</li>';
					}
					$client_info .= '</ul>';
				}
			$client_info .= '</div>';
		$client_info .= '</div>';
	}

	return $client_info;

}
function kreativa_get_client_name($client_id) {

	if ( isSet($client_id) ) {
		$client_data = get_post_custom($client_id);
		$client_name = '';
		if (isset($client_data['pagemeta_client_name'][0])) {
			$client_name=$client_data['pagemeta_client_name'][0];
		}
	}

	return $client_name;

}
function kreativa_generate_supersized_script($preset_page_id=false,$isbackground=false){
	$featured_page = kreativa_get_active_fullscreen_post();

	if ($isbackground) {
		$bg_choice = kreativa_get_background_choice( get_the_id() );

		if ($bg_choice != "none") {
			$preset_page_id = false;
			switch ($bg_choice) {
				case "options_slideshow" :
					$theme_options_set_background_slideshow = kreativa_get_option_data('general_bgslideshow');
					$preset_page_id = $theme_options_set_background_slideshow;
				break;
				case "image_attachments" :
					$preset_page_id = get_the_ID();
				break;			}
		}
	}

	if ($preset_page_id) {
		$featured_page = $preset_page_id;
	}
	if (defined('ICL_LANGUAGE_CODE')) { // this is to not break code in case WPML is turned off, etc.
	    $_type  = get_post_type($featured_page);
	    $featured_page = icl_object_id($featured_page, $_type, true, ICL_LANGUAGE_CODE);
	}
	//The Image IDs
	$filter_image_ids = kreativa_get_custom_attachments ( $featured_page );
	//Slideshow Settings
	$slideshow_autoplay=kreativa_get_option_data('slideshow_autoplay');
	$slideshow_pause_on_last=kreativa_get_option_data('slideshow_pause_on_last');
	$slideshow_pause_hover=kreativa_get_option_data('slideshow_pause_hover');
	$slideshow_random=kreativa_get_option_data('slideshow_random');
	$slideshow_interval=kreativa_get_option_data('slideshow_interval');
	$slideshow_transition=kreativa_get_option_data('slideshow_transition');
	$slideshow_transition_speed=kreativa_get_option_data('slideshow_transition_speed');
	$slideshow_portrait=kreativa_get_option_data('slideshow_portrait');
	$slideshow_landscape=kreativa_get_option_data('slideshow_landscape');
	$slideshow_fit_always=kreativa_get_option_data('slideshow_fit_always');
	$slideshow_vertical_center=kreativa_get_option_data('slideshow_vertical_center');
	$slideshow_horizontal_center=kreativa_get_option_data('slideshow_horizontal_center');
	$fullscreen_menu_toggle=kreativa_get_option_data('fullscreen_menu_toggle');
	$fullscreen_menu_toggle_nothome=kreativa_get_option_data('fullscreen_menu_toggle_nothome');
	$rootpath= get_stylesheet_directory_uri();

	if (! $slideshow_autoplay) $slideshow_autoplay=0;
	if (! $slideshow_pause_on_last) $slideshow_pause_on_last=0;
	if (! $slideshow_pause_hover) $slideshow_pause_hover=0;
	if (! $slideshow_fit_always) $slideshow_fit_always=0;
	if (! $slideshow_portrait) $slideshow_portrait=0;
	if (! $slideshow_landscape) $slideshow_landscape=0;
	if (! $slideshow_vertical_center) $slideshow_vertical_center=0;
	if (! $slideshow_horizontal_center) $slideshow_horizontal_center=0;

	$supersized_image_path = get_template_directory_uri() . '/images/supersized/';
	$slideshow_thumbnails="";

	$featured_linked=false;
	$attatchmentURL="";
	$postLink="";
	$thelimit=-1;
	$count=0;

	if (defined('ICL_LANGUAGE_CODE')) { // this is to not break code in case WPML is turned off, etc.
	    $_type  = get_post_type($featured_page);
	    $featured_page = icl_object_id($featured_page, $_type, true, ICL_LANGUAGE_CODE);
	}
	$page_background_class = '';
	// Don't Populate list if no Featured page is set
	if ( $featured_page <>"" ) {
		if ($filter_image_ids) {
		$slideshow_thumbnails_status="0";
		if ($slideshow_thumbnails=="thumbnails") {
			$slideshow_thumbnails_status="1";
		}
		// Static Titles and Description block
		$fullscreen_type='';
		$static_description='';
		$static_title='';
		$static_link_text='';
		$slideshow_link='';
		$slideshow_title='';
		$slideshow_caption='';
		$static_url='';
		$fullscreen_infobox='';
		$cover_style='';
		$slideshow_titledesc='enable';
		$custom = get_post_custom($featured_page);
		if (isSet($custom["pagemeta_fullscreen_type"][0])) $fullscreen_type = $custom[ "pagemeta_fullscreen_type"][0];
		if (isSet($custom["pagemeta_static_title"][0])) $static_title=$custom["pagemeta_static_title"][0];
		if (isSet($custom["pagemeta_static_description"][0])) $static_description=$custom["pagemeta_static_description"][0];
		if (isSet($custom["pagemeta_static_link_text"][0])) $static_link_text=$custom["pagemeta_static_link_text"][0];
		if (isSet($custom["pagemeta_static_url"][0])) $static_url=$custom["pagemeta_static_url"][0];
		if (isSet($custom["pagemeta_fullscreen_infobox"][0])) $fullscreen_infobox=$custom["pagemeta_fullscreen_infobox"][0];
		if (isSet($custom["pagemeta_slideshow_titledesc"][0])) $slideshow_titledesc=$custom["pagemeta_slideshow_titledesc"][0];
		if (isSet($custom["pagemeta_cover_style"][0])) $cover_style=$custom["pagemeta_cover_style"][0];

		$slideshow_no_description='';
		if ( $static_description =='' ) {
			$slideshow_no_description = "slideshow_text_shift_up";
		}
		$slideshow_no_description_no_title='';
		if ( $static_description =='' && $static_title =='' ) {
			$slideshow_no_description_no_title = "slideshow_text_shift_up";
		}

		$static_msg_display = false;

		if ($static_link_text) $slideshow_link ='<div class="static_slideshow_content_link '.$slideshow_no_description_no_title.'"><a class="positionaware-button" href="'.esc_url($static_url).'">'. esc_attr($static_link_text) .'<span></span></a><i class="fa fa-</div>';
			if ($static_title) $slideshow_title ='<h1 class="static_slideshow_title '.$slideshow_no_description.' slideshow_title_animation">'. esc_attr($static_title) .'</h1>';
		if ($static_description) $slideshow_caption ='<div class="static_slideshow_caption">'. do_shortcode( $static_description ) .'</div>';

		if ( $static_link_text != '' || $static_title != '' || $static_description != '' || $static_url != '' ) {
			$static_msg_display = true;
		}
		if (isSet($filter_image_ids) && is_array($filter_image_ids)) {
			ob_start();
		?>
		jQuery(function($){	
			jQuery.supersized({
				slideshow               :   1,
				autoplay				:	<?php echo esc_js($slideshow_autoplay); ?>,
				start_slide             :   1,
				image_path				:	'<?php echo esc_js($supersized_image_path); ?>',
				stop_loop				:	<?php echo esc_js($slideshow_pause_on_last); ?>,
				random					: 	0,
				slide_interval          :   <?php echo esc_js($slideshow_interval); ?>,
				transition              :   <?php echo esc_js($slideshow_transition); ?>,
				transition_speed		:	<?php echo esc_js($slideshow_transition_speed); ?>,
				new_window				:	0,
				pause_hover             :   <?php echo esc_js($slideshow_pause_hover); ?>,
				keyboard_nav            :   1,
				performance				:	2,
				image_protect			:	0,			   
				min_width		        :   0,
				min_height		        :   0,
				vertical_center         :   <?php echo esc_js($slideshow_vertical_center); ?>,
				horizontal_center       :   <?php echo esc_js($slideshow_horizontal_center); ?>,
				fit_always				:	<?php echo esc_js($slideshow_fit_always); ?>,
				fit_portrait         	:   <?php echo esc_js($slideshow_portrait); ?>,
				fit_landscape			:   <?php echo esc_js($slideshow_landscape); ?>,
				slide_links				:	'blank',
				thumb_links				:	1,
				thumbnail_navigation    :   <?php echo esc_js($slideshow_thumbnails_status); ?>,
				slides 					:  	[
		<?php
			foreach ( $filter_image_ids as $attachment_id) {
					$attachment = get_post( $attachment_id );
					if ( isSet($attachment )) {
						$alt = get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true );
						$caption = $attachment->post_excerpt;
						//$href = get_permalink( $attachment->ID ),
						$imageURI = wp_get_attachment_image_src( $attachment_id, 'full', false );
						$imageURI = $imageURI[0];
						$imageTitle = $attachment->post_title;
						$imageDesc = $attachment->post_content;

						$thumb_imageURI = '';

						$link_text = ''; $link_url = ''; $slideshow_link = ''; $slideshow_color='';
						$link_text = get_post_meta( $attachment->ID, 'mtheme_attachment_fullscreen_link', true );
						$link_url = get_post_meta( $attachment->ID, 'mtheme_attachment_fullscreen_url', true );
						$slide_color = get_post_meta( $attachment->ID, 'mtheme_attachment_fullscreen_color', true );


						// If linking is On
						if ($featured_linked == 1 || $featured_linked == true) {
							$attatchmentURL = get_attachment_link($image->ID);
						}
						// Count
						$count++;
						if ($count>1) { echo ","; }
						$slideshow_title="";
						$slideshow_caption="";
						//Find and replace all new lines to BR tags
						$find   = array("\r\n", "\n", "\r");
						$replace = '<br />';
						$imageDesc = str_replace($find, $replace , $imageDesc);
						$imageDesc = esc_js($imageDesc);

						if (!$slide_color) {
							$slide_color="bright";
						}
						$slideshow_color = '<div class="fullscreen-slideshow-color" data-color="'.esc_attr($slide_color).'"></div>';

						if ( !$static_msg_display ) {
							// If static message is not filled in page meta fields
							$slideshow_no_description='';
							if ( !$imageDesc ) {
								$slideshow_no_description = "slideshow_text_shift_up";
							}
							$slideshow_no_description_no_title='';
							if ( !$imageDesc && !$imageTitle ) {
								$slideshow_no_description_no_title = "slideshow_text_shift_up";
							}
							if ( $fullscreen_type != "particles" && $fullscreen_type != "coverphoto" ) {
								if ($link_text) $slideshow_link ='<div class="slideshow_content_links '.$slideshow_no_description_no_title.'"><a class="positionaware-button" href="'.esc_url($link_url).'">'. esc_attr($link_text) .'<span><i class="indicate-arrow feather-icon-arrow-right"></i></span></a></div>';
						 		if ($imageTitle) $slideshow_title ='<h1 class="slideshow_title '.$slideshow_no_description.' slideshow_title_animation">'. esc_attr($imageTitle) .'</h1>';
								if ($imageDesc) $slideshow_caption ='<div class="slideshow_caption">'. do_shortcode( $imageDesc ) .'</div>';

								$slideshow_display_code = '<div class="slideshow-content-wrap'.$page_background_class.'">' .$slideshow_title . $slideshow_caption . $slideshow_link . '</div>';
							} else {

								if ( !isSet($slide_ui_color)) {
									$slide_ui_color='';
								}
								if ($link_text) $slideshow_link='<div class="static_slideshow_content_link '.$slideshow_no_description_no_title.'"><a class="positionaware-button" href="'.$link_url.'">'. esc_attr($link_text) .'<span><i class="indicate-arrow feather-icon-arrow-right"></i></span></a></div>';
								if ($imageTitle) $slideshow_title='<div class="slideshow_title '.$slideshow_no_description.'">'. esc_attr($imageTitle) .'</div>';
								if ($imageDesc) $slideshow_caption='<div class="slideshow_caption">'. do_shortcode($imageDesc) .'</div>';
											$slideshow_caption = '<div class="coverphoto-outer-wrap fullscreen-slide-'.$slide_ui_color.'"><div id="coverphoto-text-wrap" class="slideshow-content-wrap fullscreen-coverphoto-outer coverphoto-type-'.$cover_style.'"><div class="fullscreen-coverphoto-inner coverphoto-text-container">' . $slideshow_title . $slideshow_caption . $slideshow_link . "</div></div></div>";

								$slideshow_display_code = $slideshow_caption;
							}
						} else {
							// Empty if static message is filled in page settings
							$slideshow_color='';
							$slideshow_link='';
							$slideshow_title='';
							$slideshow_caption='';
							$slideshow_display_code = '';
						}

						if ( $slideshow_titledesc == "disable" || $static_msg_display ) {
							$slideshow_display_code='';
						}

						if ( $isbackground ) {
							$slideshow_display_code='';
						}
						
						echo "{image : '".esc_url($imageURI)."', title : '". $slideshow_color . $slideshow_display_code . "', thumb : '".esc_url($thumb_imageURI)."', url : ''}";
					}
				} ?>
				],
				progress_bar			:	1,					
				mouse_scrub				:	1
			});
			if ($.fn.swipe) {
				jQuery(".page-is-fullscreen #supersized,.page-is-not-fullscreen #supersized").swipe({
				  excludedElements: "button, input, select, textarea, .noSwipe",
				  swipeLeft: function() {
				    jQuery("#nextslide").trigger("click");
				  },
				  swipeRight: function() {
				    jQuery("#prevslide").trigger("click");
				  }
				});
			}
		});<?php
			$mtheme_slideshow_supersized_script = ob_get_contents();
			ob_end_clean();
			return $mtheme_slideshow_supersized_script;
			} else {
				return false;
			}
		}
	}
}
function kreativa_has_password($id) {
	$checking_for_password = get_post($id);
	if(!empty($checking_for_password->post_password)){
		return true;
	}
	return false;
}
function kreativa_demo_get_data( $get ) {
	$demoswitch=false;
	if (kreativa_is_in_demo()) {
		if ( isSet($_GET[$get] )) {
			$demoswitch=array();
			if ( isSet($_GET['theme_style'] )) { 
				$demo_skin = $_GET['theme_style'];
				if ($demo_skin == "light") {
					$demoswitch['theme_style']="light";
				}
				if ($demo_skin == "dark") {
					$demoswitch['theme_style'] = "dark";
				}
			}
			if ( isSet($_GET['woo_style'] )) { 
				$woo_style = $_GET['woo_style'];
				if ($woo_style == "withsidebar") {
					$demoswitch['woo_style']="1";
				}
				if ($woo_style == "fullwidth") {
					$demoswitch['woo_style'] = "0";
				}
			}
			if ( isSet($_GET['menu_type'] )) { 
				$menu_type = $_GET['menu_type'];
				if ($menu_type == "horizontal") {
					$demoswitch['menu_type']="left-detatched";
				}
				if ($menu_type == "vertical") {
					$demoswitch['menu_type'] = "menu_type";
				}
			}
			if (isSet($_GET['maintenance_mode'])) {
				$maintenance_mode = $_GET['maintenance_mode'];
				if ($maintenance_mode == "active") {
					$demoswitch['maintenance_mode'] = "active";
				}
			}
			if(isSet($get) && isSet($demoswitch[$get])) {
				$demoswitch = $demoswitch[$get];
				return $demoswitch;
			} else {
				return false;
			}
		}
	}
}
function kreativa_page_has_background() {
	$page_background = false;
	if ( is_singular() ) {
	// Background slideshow or image
		$bg_choice = get_post_meta( get_the_id() , 'pagemeta_meta_background_choice', true);
	}
	if ( isSet($bg_choice) ) {
		switch ($bg_choice) { 
			case "featured_image" :
			case "custom_url" :
			case "options_image" :
			case "options_slideshow" :
			case "image_attachments" :
			case "fullscreen_post" :
			case "video_background" :
				$page_background = true;
			break;
			default :
				$page_background = false;
		}
	}
	return $page_background;
}
function kreativa_page_is_woo_shop() {
	$woo_shop_post_id = false;
	if ( class_exists( 'woocommerce' ) ) {
		if ( is_shop () ) {
			$woo_shop_post_id = get_option( 'woocommerce_shop_page_id' );
		}
	}
	return $woo_shop_post_id;
}

add_action('wp_ajax_nopriv_kreativa_proofing_checker', 'kreativa_proofing_checker');
add_action('wp_ajax_kreativa_proofing_checker', 'kreativa_proofing_checker');

function kreativa_proofing_checker()
{
	$nonce = $_POST['nonce'];
 
    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        die ('x');

    $mtheme_proofing_status="unchecked";

    if ( isSet($_POST['mtheme_proofing_status']) ) {
    	$mtheme_proofing_status = $_POST['mtheme_proofing_status'];
    }
		
	$image_id = $_POST['image_id'];
	if($mtheme_proofing_status=="unchecked") {
		if (!kreativa_is_in_demo()) {
			update_post_meta($image_id, "checked", "true");
		}
		echo "checked" .":" . $image_id;
	} else {
		if (!kreativa_is_in_demo()) {
			update_post_meta($image_id, "checked", "false");
		}
		echo "unchecked" .":" . $image_id;		
	}
	exit;
}

add_action('wp_ajax_nopriv_kreativa_post_like_vote', 'kreativa_post_like_vote');
add_action('wp_ajax_kreativa_post_like_vote', 'kreativa_post_like_vote');
function kreativa_post_like_vote() {

	$nonce = $_POST['nonce'];
 
    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        die ('x');
		
	if (isSet( $_POST['post_id'] )) {

		$ip = $_SERVER['REMOTE_ADDR'];
		$post_id = $_POST['post_id'];
		$meta_IP = get_post_meta($post_id, "voted_IP");
		$voted_IP = $meta_IP[0];

		if(!is_array($voted_IP)){
			$voted_IP = array();
		}
		
		$meta_count = get_post_meta($post_id, "votes_count", true);

		if(!kreativa_hasAlreadyVoted($post_id))
		{
			$voted_IP[$ip] = time();

			update_post_meta($post_id, "voted_IP", $voted_IP);
			update_post_meta($post_id, "votes_count", ++$meta_count);
			
			echo esc_html($meta_count) .":" . esc_html($post_id);
		}
		else
			echo "already";
	}
	exit;
}
function kreativa_hasAlreadyVoted($post_id) {
	$meta_IP = get_post_meta($post_id, "voted_IP");
	if (isSet($meta_IP[0])) {
		$voted_IP = $meta_IP[0];
		if(!is_array($voted_IP)) {
			$voted_IP = array();
		}
		$ip = $_SERVER['REMOTE_ADDR'];

		if( in_array($ip, array_keys($voted_IP)) ) {

			$time = $voted_IP[$ip];
			$now = time();
			
			$ipcheck_minutes= 0;
			$ipcheck_hours= 0;
			$ipcheck_days= 7;
			
			//Convert to seconds
			$minutes_seconds= $ipcheck_minutes * 60;
			if ( $ipcheck_hours <> 0 ) { $hours_seconds = $ipcheck_hours * 3600; } else { $hours_seconds=0; }
			if ( $ipcheck_days <> 0 ) { $days_seconds = $ipcheck_days * 86400; } else { $days_seconds=0; }
			
			//Add time limit in seconds
			$ipcheck_timelimit=$minutes_seconds + $hours_seconds + $days_seconds;
			$elapsed_time = round(($now - $time) / $ipcheck_timelimit);
			//Time limit check
			if(  $elapsed_time > 1 ) {
				return false;
			}
				
			return true;
		}
	}
	
	return false;
}
function kreativa_display_like_link($post_id) {
	$vote_count = get_post_meta($post_id, "votes_count", true);
	// delete_post_meta($post_id, "votes_count");
	// delete_post_meta($post_id, "voted_IP");
	
	if (! $vote_count) $vote_count="0";

	$votedclass = '';
	if(kreativa_hasAlreadyVoted($post_id)) {
		$votedclass="alreadyvoted";
	}

	$output = '<div class="mtheme-post-like '.$votedclass.'">';
	$output .= '<div class="post-link-count-wrap" data-count_id="'.$post_id.'"><span class="post-like-count">' . $vote_count . '</span></div>';
	if(kreativa_hasAlreadyVoted($post_id)) {
		$output .= ' <span class="mtheme-like like-vote-icon voted animation-standby animated"><i class="vote-like-icon ion-ios-heart"></i></span>';
	} else {
		$output .= '<span class="vote-ready" data-post_id="'.$post_id.'">
					<span class="mtheme-like like-vote-icon like-notvoted animation-standby animated"><i class="vote-like-icon ion-ios-heart-outline"></i></span>
					</span>';
	}
	$output .= '</div>';
	
	return $output;
}
// Demo Data Fetcher
function kreativa_demo_data_fetch( $get_this ) {
	$got_data='';
	if ( isSet( $get_this )) { 
		$active_feature = $get_this;
		if ($active_feature == "middle") {
			$got_data = "header-middle";
		}
		if ($active_feature == "minimal") {
			$got_data = "minimal-header";
		}
		if ($active_feature == "topcenter") {
			$got_data = "header-center";
		}
		if ($active_feature == "left") {
			$got_data = "header-left";
		}
		if ($active_feature == "boxed-middle") {
			$got_data = "boxed-header-middle";
		}
		if ($active_feature == "boxed-left") {
			$got_data = "boxed-header-left";
		}
		if ($active_feature == "vertical") {
			$got_data = "vertical-menu";
		}
		if ($active_feature == "shop_fullwidth") {
			$got_data = "shop_fullwidth";
		}
		if ($active_feature == "themeskin") {
			$got_data = "themeskin";
		}
	}
	return $got_data;
}
// Open Graph Meta tags
function kreativa_add_og_metatags() {
	global $post;
	$og_meta_added = false;

	if ( is_home() && kreativa_is_fullscreen_home() ) {

		echo sprintf( '<meta property="og:title" content="%s"/>', get_bloginfo('name') );	
		echo '<meta property="og:type" content="article"/>';
		echo sprintf( '<meta property="og:url" content="%s"/>', get_home_url() );
		echo sprintf( '<meta property="og:site_name" content="%s"/>', get_bloginfo('name') );
		echo sprintf( '<meta property="og:description" content="%s"/>', get_bloginfo('description') );

		$featured_page=kreativa_get_active_fullscreen_post();
		if (defined('ICL_LANGUAGE_CODE')) {
		    $_type  = get_post_type($featured_page);
		    $featured_page = icl_object_id($featured_page, $_type, true, ICL_LANGUAGE_CODE);
		}
		if( has_post_thumbnail( $featured_page ) ) { 
			$og_image = wp_get_attachment_image_src( get_post_thumbnail_id( $featured_page ), 'full' );
			echo sprintf( '<meta property="og:image" content="%s"/>', esc_url( $og_image[0] ) );
		}
		$og_meta_added = true;
	}


	if ( is_singular() && $og_meta_added==false ) {
		echo sprintf( '<meta property="og:title" content="%s"/>', strip_tags( str_replace( array( '"', "'" ), array( '&quot;', '&#39;' ), $post->post_title ) ) );		
		echo '<meta property="og:type" content="article"/>';
		echo sprintf( '<meta property="og:url" content="%s"/>', get_permalink() );
		echo sprintf( '<meta property="og:site_name" content="%s"/>', get_bloginfo('name') );
		echo sprintf( '<meta property="og:description" content="%s"/>', kreativa_shortentext( esc_html( $post->post_excerpt ), 50 ) );
		if( ! has_post_thumbnail( $post->ID ) ) { 
			$main_logo=kreativa_get_option_data('main_logo');
			$vmain_logo=kreativa_get_option_data('vmain_logo');
			if ($main_logo=="" && $vmain_logo<>"") {
				$main_logo = $vmain_logo;
			}
			if (isSet($main_logo) && $main_logo!=='') {
				echo sprintf( '<meta property="og:image" content="%s"/>', esc_url($main_logo) );
			}
		} else {
			$og_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
			echo sprintf( '<meta property="og:image" content="%s"/>', esc_url( $og_image[0] ) );
		}
	}
}
function kreativa_opengraph_doctype( $output ) {
	return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
}
function kreativa_trim_sentence($desc="",$charlength=20) {
	$excerpt = $desc;

	$the_text="";

	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			$the_text = mb_substr( $subex, 0, $excut );
		} else {
			$the_text = $subex;
		}
		$the_text .= '[...]';
	} else {
		$the_text = $excerpt;
	}
	return $the_text;
}
function kreativa_country_list($output_type="select",$selected=""){
	$countries = array
	(
		'none' => "Choose Country",
		'AF' => 'Afghanistan',
		'AX' => 'Aland Islands',
		'AL' => 'Albania',
		'DZ' => 'Algeria',
		'AS' => 'American Samoa',
		'AD' => 'Andorra',
		'AO' => 'Angola',
		'AI' => 'Anguilla',
		'AQ' => 'Antarctica',
		'AG' => 'Antigua And Barbuda',
		'AR' => 'Argentina',
		'AM' => 'Armenia',
		'AW' => 'Aruba',
		'AU' => 'Australia',
		'AT' => 'Austria',
		'AZ' => 'Azerbaijan',
		'BS' => 'Bahamas',
		'BH' => 'Bahrain',
		'BD' => 'Bangladesh',
		'BB' => 'Barbados',
		'BY' => 'Belarus',
		'BE' => 'Belgium',
		'BZ' => 'Belize',
		'BJ' => 'Benin',
		'BM' => 'Bermuda',
		'BT' => 'Bhutan',
		'BO' => 'Bolivia',
		'BA' => 'Bosnia And Herzegovina',
		'BW' => 'Botswana',
		'BV' => 'Bouvet Island',
		'BR' => 'Brazil',
		'IO' => 'British Indian Ocean Territory',
		'BN' => 'Brunei Darussalam',
		'BG' => 'Bulgaria',
		'BF' => 'Burkina Faso',
		'BI' => 'Burundi',
		'KH' => 'Cambodia',
		'CM' => 'Cameroon',
		'CA' => 'Canada',
		'CV' => 'Cape Verde',
		'KY' => 'Cayman Islands',
		'CF' => 'Central African Republic',
		'TD' => 'Chad',
		'CL' => 'Chile',
		'CN' => 'China',
		'CX' => 'Christmas Island',
		'CC' => 'Cocos (Keeling) Islands',
		'CO' => 'Colombia',
		'KM' => 'Comoros',
		'CG' => 'Congo',
		'CD' => 'Congo, Democratic Republic',
		'CK' => 'Cook Islands',
		'CR' => 'Costa Rica',
		'CI' => 'Cote D\'Ivoire',
		'HR' => 'Croatia',
		'CU' => 'Cuba',
		'CY' => 'Cyprus',
		'CZ' => 'Czech Republic',
		'DK' => 'Denmark',
		'DJ' => 'Djibouti',
		'DM' => 'Dominica',
		'DO' => 'Dominican Republic',
		'EC' => 'Ecuador',
		'EG' => 'Egypt',
		'SV' => 'El Salvador',
		'GQ' => 'Equatorial Guinea',
		'ER' => 'Eritrea',
		'EE' => 'Estonia',
		'ET' => 'Ethiopia',
		'FK' => 'Falkland Islands (Malvinas)',
		'FO' => 'Faroe Islands',
		'FJ' => 'Fiji',
		'FI' => 'Finland',
		'FR' => 'France',
		'GF' => 'French Guiana',
		'PF' => 'French Polynesia',
		'TF' => 'French Southern Territories',
		'GA' => 'Gabon',
		'GM' => 'Gambia',
		'GE' => 'Georgia',
		'DE' => 'Germany',
		'GH' => 'Ghana',
		'GI' => 'Gibraltar',
		'GR' => 'Greece',
		'GL' => 'Greenland',
		'GD' => 'Grenada',
		'GP' => 'Guadeloupe',
		'GU' => 'Guam',
		'GT' => 'Guatemala',
		'GG' => 'Guernsey',
		'GN' => 'Guinea',
		'GW' => 'Guinea-Bissau',
		'GY' => 'Guyana',
		'HT' => 'Haiti',
		'HM' => 'Heard Island & Mcdonald Islands',
		'VA' => 'Holy See (Vatican City State)',
		'HN' => 'Honduras',
		'HK' => 'Hong Kong',
		'HU' => 'Hungary',
		'IS' => 'Iceland',
		'IN' => 'India',
		'ID' => 'Indonesia',
		'IR' => 'Iran, Islamic Republic Of',
		'IQ' => 'Iraq',
		'IE' => 'Ireland',
		'IM' => 'Isle Of Man',
		'IL' => 'Israel',
		'IT' => 'Italy',
		'JM' => 'Jamaica',
		'JP' => 'Japan',
		'JE' => 'Jersey',
		'JO' => 'Jordan',
		'KZ' => 'Kazakhstan',
		'KE' => 'Kenya',
		'KI' => 'Kiribati',
		'KR' => 'Korea',
		'KW' => 'Kuwait',
		'KG' => 'Kyrgyzstan',
		'LA' => 'Lao People\'s Democratic Republic',
		'LV' => 'Latvia',
		'LB' => 'Lebanon',
		'LS' => 'Lesotho',
		'LR' => 'Liberia',
		'LY' => 'Libyan Arab Jamahiriya',
		'LI' => 'Liechtenstein',
		'LT' => 'Lithuania',
		'LU' => 'Luxembourg',
		'MO' => 'Macao',
		'MK' => 'Macedonia',
		'MG' => 'Madagascar',
		'MW' => 'Malawi',
		'MY' => 'Malaysia',
		'MV' => 'Maldives',
		'ML' => 'Mali',
		'MT' => 'Malta',
		'MH' => 'Marshall Islands',
		'MQ' => 'Martinique',
		'MR' => 'Mauritania',
		'MU' => 'Mauritius',
		'YT' => 'Mayotte',
		'MX' => 'Mexico',
		'FM' => 'Micronesia, Federated States Of',
		'MD' => 'Moldova',
		'MC' => 'Monaco',
		'MN' => 'Mongolia',
		'ME' => 'Montenegro',
		'MS' => 'Montserrat',
		'MA' => 'Morocco',
		'MZ' => 'Mozambique',
		'MM' => 'Myanmar',
		'NA' => 'Namibia',
		'NR' => 'Nauru',
		'NP' => 'Nepal',
		'NL' => 'Netherlands',
		'AN' => 'Netherlands Antilles',
		'NC' => 'New Caledonia',
		'NZ' => 'New Zealand',
		'NI' => 'Nicaragua',
		'NE' => 'Niger',
		'NG' => 'Nigeria',
		'NU' => 'Niue',
		'NF' => 'Norfolk Island',
		'MP' => 'Northern Mariana Islands',
		'NO' => 'Norway',
		'OM' => 'Oman',
		'PK' => 'Pakistan',
		'PW' => 'Palau',
		'PS' => 'Palestinian Territory, Occupied',
		'PA' => 'Panama',
		'PG' => 'Papua New Guinea',
		'PY' => 'Paraguay',
		'PE' => 'Peru',
		'PH' => 'Philippines',
		'PN' => 'Pitcairn',
		'PL' => 'Poland',
		'PT' => 'Portugal',
		'PR' => 'Puerto Rico',
		'QA' => 'Qatar',
		'RE' => 'Reunion',
		'RO' => 'Romania',
		'RU' => 'Russian Federation',
		'RW' => 'Rwanda',
		'BL' => 'Saint Barthelemy',
		'SH' => 'Saint Helena',
		'KN' => 'Saint Kitts And Nevis',
		'LC' => 'Saint Lucia',
		'MF' => 'Saint Martin',
		'PM' => 'Saint Pierre And Miquelon',
		'VC' => 'Saint Vincent And Grenadines',
		'WS' => 'Samoa',
		'SM' => 'San Marino',
		'ST' => 'Sao Tome And Principe',
		'SA' => 'Saudi Arabia',
		'SN' => 'Senegal',
		'RS' => 'Serbia',
		'SC' => 'Seychelles',
		'SL' => 'Sierra Leone',
		'SG' => 'Singapore',
		'SK' => 'Slovakia',
		'SI' => 'Slovenia',
		'SB' => 'Solomon Islands',
		'SO' => 'Somalia',
		'ZA' => 'South Africa',
		'GS' => 'South Georgia And Sandwich Isl.',
		'ES' => 'Spain',
		'LK' => 'Sri Lanka',
		'SD' => 'Sudan',
		'SR' => 'Suriname',
		'SJ' => 'Svalbard And Jan Mayen',
		'SZ' => 'Swaziland',
		'SE' => 'Sweden',
		'CH' => 'Switzerland',
		'SY' => 'Syrian Arab Republic',
		'TW' => 'Taiwan',
		'TJ' => 'Tajikistan',
		'TZ' => 'Tanzania',
		'TH' => 'Thailand',
		'TL' => 'Timor-Leste',
		'TG' => 'Togo',
		'TK' => 'Tokelau',
		'TO' => 'Tonga',
		'TT' => 'Trinidad And Tobago',
		'TN' => 'Tunisia',
		'TR' => 'Turkey',
		'TM' => 'Turkmenistan',
		'TC' => 'Turks And Caicos Islands',
		'TV' => 'Tuvalu',
		'UG' => 'Uganda',
		'UA' => 'Ukraine',
		'AE' => 'United Arab Emirates',
		'GB' => 'United Kingdom',
		'US' => 'United States',
		'UM' => 'United States Outlying Islands',
		'UY' => 'Uruguay',
		'UZ' => 'Uzbekistan',
		'VU' => 'Vanuatu',
		'VE' => 'Venezuela',
		'VN' => 'Viet Nam',
		'VG' => 'Virgin Islands, British',
		'VI' => 'Virgin Islands, U.S.',
		'WF' => 'Wallis And Futuna',
		'EH' => 'Western Sahara',
		'YE' => 'Yemen',
		'ZM' => 'Zambia',
		'ZW' => 'Zimbabwe',
	);
	$country_list = false;
	if ($output_type=="select") {
		$country_list="";
		foreach ($countries as $key => $option) {
		    if ($selected==$key) {
		    	$country_selected='selected="selected"';
		    } else {
		    	$country_selected="";
		    }
			$country_list .= '<option value="'. esc_attr($key) .'" '.$country_selected.'>'. esc_attr($option) . '</option>';
		}
	}
	if ($output_type=="display") {
		if (array_key_exists($selected,$countries)) {
			$country_list = $countries[$selected];
		}
	}
	return $country_list;
}
// Get single image slide color
function kreativa_get_first_slide_ui_color($get_slideshow_from_page_id) {
		// Store slide data for jQuery
	$filter_image_ids = kreativa_get_custom_attachments ( $get_slideshow_from_page_id );
	if ($filter_image_ids){
		$slide_counter=0;
		$last_slide_count = count($filter_image_ids) - 1;
		foreach ( $filter_image_ids as $attachment_id) {
				$attachment = get_post( $attachment_id );
				$slide_color = get_post_meta( $attachment->ID, 'mtheme_attachment_fullscreen_color', true );
				if (!$slide_color) { $slide_color="bright";}
				break;
		}
	}
	return $slide_color;
}
// Will be called from slideshow script
function kreativa_populate_slide_ui_colors($get_slideshow_from_page_id) {
		// Store slide data for jQuery
	$filter_image_ids = kreativa_get_custom_attachments ( $get_slideshow_from_page_id );
	if ($filter_image_ids){
		$slide_counter=0;
		$last_slide_count = count($filter_image_ids) - 1;
		echo '<ul id="slideshow-data" data-lastslide="'.$last_slide_count.'">';
		foreach ( $filter_image_ids as $attachment_id) {
				$attachment = get_post( $attachment_id );

				if ( isSet($attachment->ID) ) {
					$fullURI = wp_get_attachment_image_src( $attachment_id, 'full', false );
					$fullURI = $fullURI[0];

					$thumbnailURI = wp_get_attachment_image_src( $attachment_id, 'thumbnail', false );
					$thumbnailURI = $thumbnailURI[0];

					$thumbnail_title = '';
					if (isSet($attachment->post_title)) {
						$thumbnail_title = apply_filters('the_title',$attachment->post_title);
					}
					
					$slide_color = get_post_meta( $attachment->ID, 'mtheme_attachment_fullscreen_color', true );
					if (!$slide_color) { $slide_color="bright";}
					echo '<li class="slide-'.$slide_counter.'" data-slide="'.$slide_counter.'" data-color="'.$slide_color.'" data-src="'.$fullURI.'" data-thumbnail="'.$thumbnailURI.'" data-title="'.$thumbnail_title.'"></li>';
					$slide_counter++;
				}
		}
		echo '</ul>';
	}
}
function kreativa_get_slideshow_count($get_slideshow_from_page_id) {
	$count = false;
		// Store slide data for jQuery
	$filter_image_ids = kreativa_get_custom_attachments ( $get_slideshow_from_page_id );
	if ($filter_image_ids){
		$slide_counter=0;
		$count = count($filter_image_ids);
	}
	return $count;
}
function kreativa_get_custom_post_nav( $custom_type = "mtheme_portfolio" ) {
	// get_posts in same custom taxonomy
	$postlist_args = array(
	'posts_per_page' => -1,
	'orderby' => 'menu_order',
	'order' => 'ASC',
	'post_type' => $custom_type // this can be your post type
	);
	$postlist = get_posts( $postlist_args );

	// get ids of posts retrieved from get_posts
	$ids = array();
	foreach ($postlist as $thepost) {
	$ids[] = $thepost->ID;
	}

	// get and echo previous and next post in the same taxonomy
	$thisindex = array_search(get_the_id(), $ids);

	$custom_post_navigation = array();
	if (isSet($ids[$thisindex-1])) {
		$custom_post_navigation['prev'] = $ids[$thisindex-1];
	}
	if (isSet($ids[$thisindex+1])) {
		$custom_post_navigation['next'] = $ids[$thisindex+1];
	}
	return $custom_post_navigation;
}
function kreativa_get_option_data( $name, $default = false ) {
	
	$opt_value=get_option( 'mtheme_' .  $name );
	if ( isset( $opt_value ) ) {
		return $opt_value;
	}
	return $default;
}
function kreativa_set_fontawesome ( $fallback_icon , $the_icon , $get_css_code ) {
	if ($get_css_code) {

		$fontawesome_icons = array ( 'fa-glass' => '\\f000', 'fa-music' => '\\f001', 'fa-search' => '\\f002', 'fa-envelope-o' => '\\f003', 'fa-heart' => '\\f004', 'fa-star' => '\\f005', 'fa-star-o' => '\\f006', 'fa-user' => '\\f007', 'fa-film' => '\\f008', 'fa-th-large' => '\\f009', 'fa-th' => '\\f00a', 'fa-th-list' => '\\f00b', 'fa-check' => '\\f00c', 'fa-times' => '\\f00d', 'fa-search-plus' => '\\f00e', 'fa-search-minus' => '\\f010', 'fa-power-off' => '\\f011', 'fa-signal' => '\\f012', 'fa-cog' => '\\f013', 'fa-trash-o' => '\\f014', 'fa-home' => '\\f015', 'fa-file-o' => '\\f016', 'fa-clock-o' => '\\f017', 'fa-road' => '\\f018', 'fa-download' => '\\f019', 'fa-arrow-circle-o-down' => '\\f01a', 'fa-arrow-circle-o-up' => '\\f01b', 'fa-inbox' => '\\f01c', 'fa-play-circle-o' => '\\f01d', 'fa-repeat' => '\\f01e', 'fa-refresh' => '\\f021', 'fa-list-alt' => '\\f022', 'fa-lock' => '\\f023', 'fa-flag' => '\\f024', 'fa-headphones' => '\\f025', 'fa-volume-off' => '\\f026', 'fa-volume-down' => '\\f027', 'fa-volume-up' => '\\f028', 'fa-qrcode' => '\\f029', 'fa-barcode' => '\\f02a', 'fa-tag' => '\\f02b', 'fa-tags' => '\\f02c', 'fa-book' => '\\f02d', 'fa-bookmark' => '\\f02e', 'fa-print' => '\\f02f', 'fa-camera' => '\\f030', 'fa-font' => '\\f031', 'fa-bold' => '\\f032', 'fa-italic' => '\\f033', 'fa-text-height' => '\\f034', 'fa-text-width' => '\\f035', 'fa-align-left' => '\\f036', 'fa-align-center' => '\\f037', 'fa-align-right' => '\\f038', 'fa-align-justify' => '\\f039', 'fa-list' => '\\f03a', 'fa-outdent' => '\\f03b', 'fa-indent' => '\\f03c', 'fa-video-camera' => '\\f03d', 'fa-picture-o' => '\\f03e', 'fa-pencil' => '\\f040', 'fa-map-marker' => '\\f041', 'fa-adjust' => '\\f042', 'fa-tint' => '\\f043', 'fa-pencil-square-o' => '\\f044', 'fa-share-square-o' => '\\f045', 'fa-check-square-o' => '\\f046', 'fa-arrows' => '\\f047', 'fa-step-backward' => '\\f048', 'fa-fast-backward' => '\\f049', 'fa-backward' => '\\f04a', 'fa-play' => '\\f04b', 'fa-pause' => '\\f04c', 'fa-stop' => '\\f04d', 'fa-forward' => '\\f04e', 'fa-fast-forward' => '\\f050', 'fa-step-forward' => '\\f051', 'fa-eject' => '\\f052', 'fa-chevron-left' => '\\f053', 'fa-chevron-right' => '\\f054', 'fa-plus-circle' => '\\f055', 'fa-minus-circle' => '\\f056', 'fa-times-circle' => '\\f057', 'fa-check-circle' => '\\f058', 'fa-question-circle' => '\\f059', 'fa-info-circle' => '\\f05a', 'fa-crosshairs' => '\\f05b', 'fa-times-circle-o' => '\\f05c', 'fa-check-circle-o' => '\\f05d', 'fa-ban' => '\\f05e', 'fa-arrow-left' => '\\f060', 'fa-arrow-right' => '\\f061', 'fa-arrow-up' => '\\f062', 'fa-arrow-down' => '\\f063', 'fa-share' => '\\f064', 'fa-expand' => '\\f065', 'fa-compress' => '\\f066', 'fa-plus' => '\\f067', 'fa-minus' => '\\f068', 'fa-asterisk' => '\\f069', 'fa-exclamation-circle' => '\\f06a', 'fa-gift' => '\\f06b', 'fa-leaf' => '\\f06c', 'fa-fire' => '\\f06d', 'fa-eye' => '\\f06e', 'fa-eye-slash' => '\\f070', 'fa-exclamation-triangle' => '\\f071', 'fa-plane' => '\\f072', 'fa-calendar' => '\\f073', 'fa-random' => '\\f074', 'fa-comment' => '\\f075', 'fa-magnet' => '\\f076', 'fa-chevron-up' => '\\f077', 'fa-chevron-down' => '\\f078', 'fa-retweet' => '\\f079', 'fa-shopping-cart' => '\\f07a', 'fa-folder' => '\\f07b', 'fa-folder-open' => '\\f07c', 'fa-arrows-v' => '\\f07d', 'fa-arrows-h' => '\\f07e', 'fa-bar-chart-o' => '\\f080', 'fa-twitter-square' => '\\f081', 'fa-facebook-square' => '\\f082', 'fa-camera-retro' => '\\f083', 'fa-key' => '\\f084', 'fa-cogs' => '\\f085', 'fa-comments' => '\\f086', 'fa-thumbs-o-up' => '\\f087', 'fa-thumbs-o-down' => '\\f088', 'fa-star-half' => '\\f089', 'fa-heart-o' => '\\f08a', 'fa-sign-out' => '\\f08b', 'fa-linkedin-square' => '\\f08c', 'fa-thumb-tack' => '\\f08d', 'fa-external-link' => '\\f08e', 'fa-sign-in' => '\\f090', 'fa-trophy' => '\\f091', 'fa-github-square' => '\\f092', 'fa-upload' => '\\f093', 'fa-lemon-o' => '\\f094', 'fa-phone' => '\\f095', 'fa-square-o' => '\\f096', 'fa-bookmark-o' => '\\f097', 'fa-phone-square' => '\\f098', 'fa-twitter' => '\\f099', 'fa-facebook' => '\\f09a', 'fa-github' => '\\f09b', 'fa-unlock' => '\\f09c', 'fa-credit-card' => '\\f09d', 'fa-rss' => '\\f09e', 'fa-hdd-o' => '\\f0a0', 'fa-bullhorn' => '\\f0a1', 'fa-bell' => '\\f0f3', 'fa-certificate' => '\\f0a3', 'fa-hand-o-right' => '\\f0a4', 'fa-hand-o-left' => '\\f0a5', 'fa-hand-o-up' => '\\f0a6', 'fa-hand-o-down' => '\\f0a7', 'fa-arrow-circle-left' => '\\f0a8', 'fa-arrow-circle-right' => '\\f0a9', 'fa-arrow-circle-up' => '\\f0aa', 'fa-arrow-circle-down' => '\\f0ab', 'fa-globe' => '\\f0ac', 'fa-wrench' => '\\f0ad', 'fa-tasks' => '\\f0ae', 'fa-filter' => '\\f0b0', 'fa-briefcase' => '\\f0b1', 'fa-arrows-alt' => '\\f0b2', 'fa-users' => '\\f0c0', 'fa-link' => '\\f0c1', 'fa-cloud' => '\\f0c2', 'fa-flask' => '\\f0c3', 'fa-scissors' => '\\f0c4', 'fa-files-o' => '\\f0c5', 'fa-paperclip' => '\\f0c6', 'fa-floppy-o' => '\\f0c7', 'fa-square' => '\\f0c8', 'fa-bars' => '\\f0c9', 'fa-list-ul' => '\\f0ca', 'fa-list-ol' => '\\f0cb', 'fa-strikethrough' => '\\f0cc', 'fa-underline' => '\\f0cd', 'fa-table' => '\\f0ce', 'fa-magic' => '\\f0d0', 'fa-truck' => '\\f0d1', 'fa-pinterest' => '\\f0d2', 'fa-pinterest-square' => '\\f0d3', 'fa-google-plus-square' => '\\f0d4', 'fa-google-plus' => '\\f0d5', 'fa-money' => '\\f0d6', 'fa-caret-down' => '\\f0d7', 'fa-caret-up' => '\\f0d8', 'fa-caret-left' => '\\f0d9', 'fa-caret-right' => '\\f0da', 'fa-columns' => '\\f0db', 'fa-sort' => '\\f0dc', 'fa-sort-desc' => '\\f0dd', 'fa-sort-asc' => '\\f0de', 'fa-envelope' => '\\f0e0', 'fa-linkedin' => '\\f0e1', 'fa-undo' => '\\f0e2', 'fa-gavel' => '\\f0e3', 'fa-tachometer' => '\\f0e4', 'fa-comment-o' => '\\f0e5', 'fa-comments-o' => '\\f0e6', 'fa-bolt' => '\\f0e7', 'fa-sitemap' => '\\f0e8', 'fa-umbrella' => '\\f0e9', 'fa-clipboard' => '\\f0ea', 'fa-lightbulb-o' => '\\f0eb', 'fa-exchange' => '\\f0ec', 'fa-cloud-download' => '\\f0ed', 'fa-cloud-upload' => '\\f0ee', 'fa-user-md' => '\\f0f0', 'fa-stethoscope' => '\\f0f1', 'fa-suitcase' => '\\f0f2', 'fa-bell-o' => '\\f0a2', 'fa-coffee' => '\\f0f4', 'fa-cutlery' => '\\f0f5', 'fa-file-text-o' => '\\f0f6', 'fa-building-o' => '\\f0f7', 'fa-hospital-o' => '\\f0f8', 'fa-ambulance' => '\\f0f9', 'fa-medkit' => '\\f0fa', 'fa-fighter-jet' => '\\f0fb', 'fa-beer' => '\\f0fc', 'fa-h-square' => '\\f0fd', 'fa-plus-square' => '\\f0fe', 'fa-angle-double-left' => '\\f100', 'fa-angle-double-right' => '\\f101', 'fa-angle-double-up' => '\\f102', 'fa-angle-double-down' => '\\f103', 'fa-angle-left' => '\\f104', 'fa-angle-right' => '\\f105', 'fa-angle-up' => '\\f106', 'fa-angle-down' => '\\f107', 'fa-desktop' => '\\f108', 'fa-laptop' => '\\f109', 'fa-tablet' => '\\f10a', 'fa-mobile' => '\\f10b', 'fa-circle-o' => '\\f10c', 'fa-quote-left' => '\\f10d', 'fa-quote-right' => '\\f10e', 'fa-spinner' => '\\f110', 'fa-circle' => '\\f111', 'fa-reply' => '\\f112', 'fa-github-alt' => '\\f113', 'fa-folder-o' => '\\f114', 'fa-folder-open-o' => '\\f115', 'fa-smile-o' => '\\f118', 'fa-frown-o' => '\\f119', 'fa-meh-o' => '\\f11a', 'fa-gamepad' => '\\f11b', 'fa-keyboard-o' => '\\f11c', 'fa-flag-o' => '\\f11d', 'fa-flag-checkered' => '\\f11e', 'fa-terminal' => '\\f120', 'fa-code' => '\\f121', 'fa-reply-all' => '\\f122', 'fa-star-half-o' => '\\f123', 'fa-location-arrow' => '\\f124', 'fa-crop' => '\\f125', 'fa-code-fork' => '\\f126', 'fa-chain-broken' => '\\f127', 'fa-question' => '\\f128', 'fa-info' => '\\f129', 'fa-exclamation' => '\\f12a', 'fa-superscript' => '\\f12b', 'fa-subscript' => '\\f12c', 'fa-eraser' => '\\f12d', 'fa-puzzle-piece' => '\\f12e', 'fa-microphone' => '\\f130', 'fa-microphone-slash' => '\\f131', 'fa-shield' => '\\f132', 'fa-calendar-o' => '\\f133', 'fa-fire-extinguisher' => '\\f134', 'fa-rocket' => '\\f135', 'fa-maxcdn' => '\\f136', 'fa-chevron-circle-left' => '\\f137', 'fa-chevron-circle-right' => '\\f138', 'fa-chevron-circle-up' => '\\f139', 'fa-chevron-circle-down' => '\\f13a', 'fa-html5' => '\\f13b', 'fa-css3' => '\\f13c', 'fa-anchor' => '\\f13d', 'fa-unlock-alt' => '\\f13e', 'fa-bullseye' => '\\f140', 'fa-ellipsis-h' => '\\f141', 'fa-ellipsis-v' => '\\f142', 'fa-rss-square' => '\\f143', 'fa-play-circle' => '\\f144', 'fa-ticket' => '\\f145', 'fa-minus-square' => '\\f146', 'fa-minus-square-o' => '\\f147', 'fa-level-up' => '\\f148', 'fa-level-down' => '\\f149', 'fa-check-square' => '\\f14a', 'fa-pencil-square' => '\\f14b', 'fa-external-link-square' => '\\f14c', 'fa-share-square' => '\\f14d', 'fa-compass' => '\\f14e', 'fa-caret-square-o-down' => '\\f150', 'fa-caret-square-o-up' => '\\f151', 'fa-caret-square-o-right' => '\\f152', 'fa-eur' => '\\f153', 'fa-gbp' => '\\f154', 'fa-usd' => '\\f155', 'fa-inr' => '\\f156', 'fa-jpy' => '\\f157', 'fa-rub' => '\\f158', 'fa-krw' => '\\f159', 'fa-btc' => '\\f15a', 'fa-file' => '\\f15b', 'fa-file-text' => '\\f15c', 'fa-sort-alpha-asc' => '\\f15d', 'fa-sort-alpha-desc' => '\\f15e', 'fa-sort-amount-asc' => '\\f160', 'fa-sort-amount-desc' => '\\f161', 'fa-sort-numeric-asc' => '\\f162', 'fa-sort-numeric-desc' => '\\f163', 'fa-thumbs-up' => '\\f164', 'fa-thumbs-down' => '\\f165', 'fa-youtube-square' => '\\f166', 'fa-youtube' => '\\f167', 'fa-xing' => '\\f168', 'fa-xing-square' => '\\f169', 'fa-youtube-play' => '\\f16a', 'fa-dropbox' => '\\f16b', 'fa-stack-overflow' => '\\f16c', 'fa-instagram' => '\\f16d', 'fa-flickr' => '\\f16e', 'fa-adn' => '\\f170', 'fa-bitbucket' => '\\f171', 'fa-bitbucket-square' => '\\f172', 'fa-tumblr' => '\\f173', 'fa-tumblr-square' => '\\f174', 'fa-long-arrow-down' => '\\f175', 'fa-long-arrow-up' => '\\f176', 'fa-long-arrow-left' => '\\f177', 'fa-long-arrow-right' => '\\f178', 'fa-apple' => '\\f179', 'fa-windows' => '\\f17a', 'fa-android' => '\\f17b', 'fa-linux' => '\\f17c', 'fa-dribbble' => '\\f17d', 'fa-skype' => '\\f17e', 'fa-foursquare' => '\\f180', 'fa-trello' => '\\f181', 'fa-female' => '\\f182', 'fa-male' => '\\f183', 'fa-gittip' => '\\f184', 'fa-sun-o' => '\\f185', 'fa-moon-o' => '\\f186', 'fa-archive' => '\\f187', 'fa-bug' => '\\f188', 'fa-vk' => '\\f189', 'fa-weibo' => '\\f18a', 'fa-renren' => '\\f18b', 'fa-pagelines' => '\\f18c', 'fa-stack-exchange' => '\\f18d', 'fa-arrow-circle-o-right' => '\\f18e', 'fa-arrow-circle-o-left' => '\\f190', 'fa-caret-square-o-left' => '\\f191', 'fa-dot-circle-o' => '\\f192', 'fa-wheelchair' => '\\f193', 'fa-vimeo-square' => '\\f194', 'fa-try' => '\\f195', 'fa-plus-square-o' => '\\f196', 'fa-space-shuttle' => '\\f197', 'fa-slack' => '\\f198', 'fa-envelope-square' => '\\f199', 'fa-wordpress' => '\\f19a', 'fa-openid' => '\\f19b', 'fa-university' => '\\f19c', 'fa-graduation-cap' => '\\f19d', 'fa-yahoo' => '\\f19e', 'fa-google' => '\\f1a0', 'fa-reddit' => '\\f1a1', 'fa-reddit-square' => '\\f1a2', 'fa-stumbleupon-circle' => '\\f1a3', 'fa-stumbleupon' => '\\f1a4', 'fa-delicious' => '\\f1a5', 'fa-digg' => '\\f1a6', 'fa-pied-piper' => '\\f1a7', 'fa-pied-piper-alt' => '\\f1a8', 'fa-drupal' => '\\f1a9', 'fa-joomla' => '\\f1aa', 'fa-language' => '\\f1ab', 'fa-fax' => '\\f1ac', 'fa-building' => '\\f1ad', 'fa-child' => '\\f1ae', 'fa-paw' => '\\f1b0', 'fa-spoon' => '\\f1b1', 'fa-cube' => '\\f1b2', 'fa-cubes' => '\\f1b3', 'fa-behance' => '\\f1b4', 'fa-behance-square' => '\\f1b5', 'fa-steam' => '\\f1b6', 'fa-steam-square' => '\\f1b7', 'fa-recycle' => '\\f1b8', 'fa-car' => '\\f1b9', 'fa-taxi' => '\\f1ba', 'fa-tree' => '\\f1bb', 'fa-spotify' => '\\f1bc', 'fa-deviantart' => '\\f1bd', 'fa-soundcloud' => '\\f1be', 'fa-database' => '\\f1c0', 'fa-file-pdf-o' => '\\f1c1', 'fa-file-word-o' => '\\f1c2', 'fa-file-excel-o' => '\\f1c3', 'fa-file-powerpoint-o' => '\\f1c4', 'fa-file-image-o' => '\\f1c5', 'fa-file-archive-o' => '\\f1c6', 'fa-file-audio-o' => '\\f1c7', 'fa-file-video-o' => '\\f1c8', 'fa-file-code-o' => '\\f1c9', 'fa-vine' => '\\f1ca', 'fa-codepen' => '\\f1cb', 'fa-jsfiddle' => '\\f1cc', 'fa-life-ring' => '\\f1cd', 'fa-circle-o-notch' => '\\f1ce', 'fa-rebel' => '\\f1d0', 'fa-empire' => '\\f1d1', 'fa-git-square' => '\\f1d2', 'fa-git' => '\\f1d3', 'fa-hacker-news' => '\\f1d4', 'fa-tencent-weibo' => '\\f1d5', 'fa-qq' => '\\f1d6', 'fa-weixin' => '\\f1d7', 'fa-paper-plane' => '\\f1d8', 'fa-paper-plane-o' => '\\f1d9', 'fa-history' => '\\f1da', 'fa-circle-thin' => '\\f1db', 'fa-header' => '\\f1dc', 'fa-paragraph' => '\\f1dd', 'fa-sliders' => '\\f1de', 'fa-share-alt' => '\\f1e0', 'fa-share-alt-square' => '\\f1e1', 'fa-bomb' => '\\f1e2', );
			
		if ( $the_icon !='fa fa-blank' && !empty($the_icon) && isSet($the_icon) ) {

			$two_piece_fallback_array = explode(' ',$fallback_icon);
			$css_fallback_name = $two_piece_fallback_array[1];
			
			$two_piece_given_array = explode(' ',$the_icon);
			$css_given_name = $two_piece_given_array[1];

			if ( array_key_exists ($css_given_name, $fontawesome_icons)) {
				return $fontawesome_icons[$css_given_name];
			} else {
				return $fontawesome_icons[$css_fallback_name];
			}
		}

	} else {
		if ( $the_icon !='fa fa-blank' && !empty($the_icon) && isSet($the_icon) ) {
		    return $the_icon;
		} else {
		    return $fallback_icon;
		}
	}
}
/*-------------------------------------------------------------------------*/
/* Ajax Portfolio callback function */
/*-------------------------------------------------------------------------*/
function kreativa_get_ajaxportfolio() {
	$mtheme_thepostID = $_POST['post_id'];

	$custom = get_post_custom($mtheme_thepostID);
	$portfolio_cats = get_the_terms( $mtheme_thepostID, 'types' );
	$video_url="";
	$thumbnail="";
	$link_url="";
	$portfolio_page_header="";
	$description="";
	$portfoliotype="view";
	if ( isset($custom['pagemeta_lightbox_video'][0]) ) { $video_url=$custom['pagemeta_lightbox_video'][0]; $portfoliotype="video"; }
	if ( isset($custom['pagemeta_customthumbnail'][0]) ) { $thumbnail=$custom['pagemeta_customthumbnail'][0]; }
	if ( isset($custom['pagemeta_customlink'][0]) ) { $link_url=$custom['pagemeta_customlink'][0];  $portfoliotype="link"; }
	if ( isset($custom['pagemeta_video_embed'][0]) ) { $portfoliotype="portfolio_videoembed"; }
	if ( isset($custom['pagemeta_portfoliotype'][0]) ) { $portfolio_page_header=$custom['pagemeta_portfoliotype'][0]; }

	if ( isset($custom['pagemeta_clientname'][0]) ) $portfolio_client=$custom['pagemeta_clientname'][0];
	if ( isSet($custom['pagemeta_projectlink'][0]) ) $portfolio_projectlink=$custom['pagemeta_projectlink'][0];
	if (isset($custom['pagemeta_skills_required'][0])) $portfolio_skills_required=$custom['pagemeta_skills_required'][0];

	if ( isset($custom['pagemeta_thumbnail_desc'][0]) ) { 
		$description=$custom['pagemeta_thumbnail_desc'][0];
	}
	if (isSet($description)) {
		$description = apply_filters('the_content', $description);
	}
?>
<div id="ajax-gridblock-content" class="clearfix">
	<div class="entry-content clearfix">
		<div class="portfolio-header-left two-column float-left">
			<div class="ajax-gridblock-image-wrap">
			<?php
			echo kreativa_display_post_image (
				$mtheme_thepostID,
				$have_image_url=false,
				$link=false,
				$type="kreativa-gridblock-full",
				$post_title=get_the_title(),
				$class=""
			);
			?>
			</div>
		</div>
	
	<?php if ( post_password_required($mtheme_thepostID) ) { ?>
		<div class="ajax-protected">
			<i class="ion-ios-locked-outline"></i>
		<h2 class="project-heading">
			<?php echo esc_attr( get_the_title($mtheme_thepostID) ); ?>
		</h2>
		<?php
		echo '<a href="'.esc_url( get_permalink($mtheme_thepostID) ).'"><div class="mtheme-button">'. esc_html__('Unlock Project','kreativa').'</div></a>';
		?>
		</div>
	<?php } else { ?>
	<div class="portfolio-details-section portfolio-header-right float-right">
		<div class="portfolio-details-section-inner portfolio-header-right-inner">
			<div class="entry-content gridblock-contents-wrap">
				<div class="ajax-gridblock-data text-is-bright">

					<?php if ( ! post_password_required($mtheme_thepostID) ) { ?>
					<?php
					if ( isset($custom['pagemeta_customlink'][0]) ) {
						$linkedto = $custom['pagemeta_customlink'][0];
					} else {
						$linkedto = get_permalink($mtheme_thepostID);
					}
					?>
					<h2 class="project-heading"><?php echo get_the_title($mtheme_thepostID); ?></h2>
					<div class="ajax-gridblock-description">
					<?php
					$allowedtags = array(
					    'a' => array(
					        'href' => true,
					        'title' => true,
					    ),
					    'abbr' => array(
					        'title' => true,
					    ),
					    'acronym' => array(
					        'title' => true,
					    ),
					    'b' => array(),
					    'blockquote' => array(
					        'cite' => true,
					    ),
					    'cite' => array(),
					    'code' => array(),
					    'del' => array(
					        'datetime' => true,
					    ),
					    'em' => array(),
					    'i' => array(),
					    'q' => array(
					        'cite' => true,
					    ),
					    'strike' => array(),
					    'strong' => array(),
					);
					echo wp_kses($description, $allowedtags);
					?>
					</div>
					<?php
					if ($linkedto<>"") {
						echo '<a href="'.esc_url($linkedto).'">
						<div class="mtheme-button">'. esc_html( kreativa_get_option_data('ajax_portfolio_viewtext') ) .'</div>
						</a>';
					}
					?>
					<?php } ?>

				</div>
			</div>
		</div>
	</div>
	<?php
	}
	?>
</div>
<?php
	die();
}
add_action( 'wp_ajax_ajaxportfolio', 'kreativa_get_ajaxportfolio' );
add_action( 'wp_ajax_nopriv_ajaxportfolio', 'kreativa_get_ajaxportfolio' );
/*-------------------------------------------------------------------------*/
/* Ajax contact form callback function */
/*-------------------------------------------------------------------------*/
function kreativa_mail_ajaxcontactform(){
	//Change the #emailTo to your email address
	$emailTo = kreativa_get_option_data('ctemplate_email');
	$subject = $_REQUEST['subject'];
	$name=$_REQUEST['name'];
	$email=$_REQUEST['email'];
	$msg=$_REQUEST['msg'];
	
	$headers   = array();
	$headers[] = "MIME-Version: 1.0";
	$headers[] = "Content-type: text/plain; charset=iso-8859-1";
	$headers[] = "From: ".$name." <".$email.">";
	$headers[] = "Reply-To: ".$name." <".$email.">";
	$headers[] = "Subject: {$subject}";
	$headers[] = "X-Mailer: PHP/".phpversion();
	
	$body = "Name: $name \r\nEmail: $email \r\nMessage: $msg";
	
	$sendmail=wp_mail($emailTo, $subject, $body, implode("\r\n", $headers));
	
	if ($sendmail) {
		echo "Processed! OK!";
	}
}
add_action( 'wp_ajax_mailcontactform', 'kreativa_mail_ajaxcontactform' );
add_action( 'wp_ajax_nopriv_mailcontactform', 'kreativa_mail_ajaxcontactform' );
function kreativa_is_knowledgebase_page() {
		$found = false;
		$pageheader_searchform= get_post_meta(get_the_id(), 'pagemeta_pageheader_searchform', true);
		if ( is_singular('mtheme_knowledgebase') || $pageheader_searchform=="kbase_search" || isSet( $_GET['mtheme_knowledgebase_search'] ) || is_tax('kbsection') ) {
			$found=true;
		}
		return $found;
}
function kreativa_is_faq_page() {
		$found = false;
		$pageheader_searchform= get_post_meta(get_the_id(), 'pagemeta_pageheader_searchform', true);
		if ( is_singular('mtheme_faq') || $pageheader_searchform == 'faq_search' || isSet( $_GET['mtheme_faq_search'] ) || is_tax('mfaqcategory') ) {
			$found=true;
		}
		return $found;
}
function kreativa_excerpt_max_charlength($charlength) {
	$excerpt = get_the_excerpt();
	$charlength++;

	$the_text="";

	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			$the_text = mb_substr( $subex, 0, $excut );
		} else {
			$the_text = $subex;
		}
		$the_text .= '[...]';
	} else {
		$the_text = $excerpt;
	}
	return $the_text;
}
//Get page header status
function kreativa_get_page_header_status() {
	$page_header_status = "Show";
	$page_header_status= get_post_meta(get_the_id(), 'pagemeta_pagetitle_header', true);
	return $page_header_status;
}
//Revolution Slider selector populate
function kreativa_rev_slider_selectors() {
	global $wpdb;
	$mtheme_revslides=array();
	$mtheme_revslides['mtheme-none-selected'] = 'Not Selected';
	if(function_exists('rev_slider_shortcode')) {
		$query_sliders = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'revslider_sliders');
		if(isSet($query_sliders)) {
			foreach($query_sliders as $slides) {
				$mtheme_revslides[$slides->alias] = $slides->alias;
			}
		}
	}
	return $mtheme_revslides;
}
// Check fullscreen type
function kreativa_is_fullscreen_home() {
	$fullscreen_check = kreativa_get_option_data('fullcscreen_henable');
	if ( is_home() && $fullscreen_check=="1" ) {
		return true;
	} else {
		return false;
	}
}
function kreativa_get_fullscreen_type() {
	$fullscreen_type=false;
	$fullscreen_check = kreativa_get_option_data('fullcscreen_henable');
	if ( is_home() && $fullscreen_check=="1" ) {
		$custom = get_post_custom( kreativa_get_option_data('fullcscreen_hselected') );
	} else{
		$custom = get_post_custom( get_the_id() );
	}
	if ( isSet($custom[ "pagemeta_fullscreen_type"][0]) ) {
		$fullscreen_type = $custom[ "pagemeta_fullscreen_type"][0];
	}
	return $fullscreen_type;
}
// Check if it's a fullscreen post
function kreativa_is_fullscreen_post(){
	$fullscreen_post_check = false;
	if ( is_singular( 'mtheme_featured' ) ) {
		$fullscreen_post_check = true;
	}
	if ( is_singular( 'mtheme_photostory' ) ) {
		$fullscreen_post_check = true;
	}
	$fullscreen_check = kreativa_get_option_data('fullcscreen_henable');
	if ( is_home() && $fullscreen_check=="1" ) {
		$fullscreen_post_check = true;
	}
	return $fullscreen_post_check;
}
// Get active fullscreen post
function kreativa_get_active_fullscreen_post() {
	$fullscreen_check = kreativa_get_option_data('fullcscreen_henable');
	if ( is_home() && $fullscreen_check=="1" ) {
		$fullscreen_page_id=kreativa_get_option_data('fullcscreen_hselected');
	} else {
		$fullscreen_page_id=get_the_id();
	}
	return $fullscreen_page_id;
}
/*
Check fullscreen type and return the correct page.
*/
if (!function_exists('kreativa_get_fullscreen_file')) {
	function kreativa_get_fullscreen_file($fullscreen_type) {
		$fullscreen_load=false;
		switch ($fullscreen_type) {
			case "photowall" :
				$fullscreen_load = 'photowall';
			break;

			case "kenburns" :
				$fullscreen_load = 'kenburns';
			break;

			case "particles" :
				$fullscreen_load = 'particles';
			break;

			case "coverphoto" :
				$fullscreen_load = 'coverphoto';
			break;

			case "fotorama" :
				$fullscreen_load = 'fotorama';
			break;

			case "carousel" :
				$fullscreen_load = 'carousel';
			break;
			
			case "slideshow" :
				$fullscreen_load = 'supersized';
			break;
			
			case "video" :
				$fullscreen_load = 'video';
			break;
			case "revslider" :
				$fullscreen_load = 'revslider';
			break;
			case "swiperslides" :
				$fullscreen_load = 'swiperslides';
			break;
			default:
			break;
		}
		return $fullscreen_load;
	}
}
// Get Attached images applied with custom script
function kreativa_get_custom_attachments( $page_id ) {
	$filter_image_ids = false;
	$the_image_ids = get_post_meta( $page_id , '_mtheme_image_ids');
	if ($the_image_ids) {
		$filter_image_ids = explode(',', $the_image_ids[0]);
		return $filter_image_ids;
	}
}
// Get Attached images applied with custom script
function kreativa_get_pagemeta_infobox_set( $page_id ) {
	$filter_image_ids = false;
	$the_image_ids = get_post_meta( $page_id , 'pagemeta_infoboxes');
	if ($the_image_ids) {
		$filter_image_ids = explode(',', $the_image_ids[0]);
		return $filter_image_ids;
	}
}
function kreativa_extract_googlefont_data( $got_font ) {
	if ($got_font) {
		$font_pieces = explode(":", $got_font);		
		$font_css_name = $font_pieces[0];
		$font_name = str_replace (" ","+", $font_pieces[0] );
		
		if (isset ($font_pieces[1]) ) {
			$font_variants = $font_pieces[1];
			$font_variants = str_replace ("|",",", $font_pieces[1] );
		} else {
			$font_variants="";
		}
		if (isset ($font_pieces[2]) ) {
			$font_subsets = $font_pieces[2];
			$font_subsets = str_replace ("|",",", $font_pieces[2] );
			$font_subsets = '&subset='.$font_subsets;
		} else {
			$font_subsets="";
		}
		if( is_ssl() ) {
			$protocol = 'https';
		} else {
			$protocol = 'http';
		}
		$font_url = $protocol . '://fonts.googleapis.com/css?family='.$font_name . ':' . $font_variants . $font_subsets;
		$google_font['variants'] = $font_variants;
		$google_font['cssname'] = $font_css_name;
		$google_font['name'] = $font_name;
		$google_font['url'] = $font_url;
		return $google_font;
	}
}
// Enqueque Font
function kreativa_enqueue_font ( $sectionName ) {
	$got_font=kreativa_get_option_data($sectionName);
	if ($got_font) {
		$font_pieces = explode(":", $got_font);		
		$font_name = $font_pieces[0];
		$font_name = str_replace (" ","+", $font_pieces[0] );
		
		if (isset ($font_pieces[1]) ) {
			$font_variants = $font_pieces[1];
			$font_variants = str_replace ("|",",", $font_pieces[1] );
		} else {
			$font_variants="";
		}
		if (isset ($font_pieces[2]) ) {
			$font_subsets = $font_pieces[2];
			$font_subsets = str_replace ("|",",", $font_pieces[2] );
			$font_subsets = '&subset='.$font_subsets;
		} else {
			$font_subsets="";
		}

		if( is_ssl() ) {
			$protocol = 'https';
		} else {
			$protocol = 'http';
		}

		$font_url = $protocol . '://fonts.googleapis.com/css?family='.$font_name . ':' . $font_variants . $font_subsets;
		$google_font['name'] = $font_name;
		$google_font['url'] = $font_url;
		return $google_font;
	}
	
}
//Apply Font used by Dynamic_CSS
function kreativa_apply_font ( $fontName , $fontClasses ) {

	$got_font=kreativa_get_option_data($fontName, $fontClasses);
	
	if ($got_font) {
		$font_pieces = explode(":", $got_font);
		$font_name = $font_pieces[0];
		$dynamic_css = $fontClasses . "{ font-family:'" . $font_name . "'; }";
		return $dynamic_css;
	}

}
//Change Class called from Dynamic_CSS
function kreativa_change_class ( $class,$property,$value,$important) {
	if ( $important!='' ) { 
		$important =" !".$important;
	}
	$output_value = "{". $property .":".$value.$important.";}";
	$dynamic_css = $class . $output_value;
	return $dynamic_css;
}
// Displays alt text based on ID
function kreativa_get_alt_text($attatchmentID) {
	$alt = get_post_meta($attatchmentID, '_wp_attachment_image_alt', true);
	return $alt;
}
// Excerpt Limit
function kreativa_excerpt_limit($limit) {
      $excerpt = explode(' ', get_the_excerpt(), $limit);
      if (count($excerpt)>=$limit) {
        array_pop($excerpt);
        $excerpt = implode(" ",$excerpt).'...';
      } else {
        $excerpt = implode(" ",$excerpt);
      } 
      $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
      return $excerpt;
    }

    function kreativa_content_limit($limit) {
      $content = explode(' ', get_the_content(), $limit);
      if (count($content)>=$limit) {
        array_pop($content);
        $content = implode(" ",$content).'...';
      } else {
        $content = implode(" ",$content);
      } 
      $content = preg_replace('/\[.+\]/','', $content);
      $content = apply_filters('the_content', $content); 
      $content = str_replace(']]>', ']]&gt;', $content);
      return $content;
    }
// Detect User Agent
// Detect special conditions devices
function kreativa_get_device() {
	$iPod = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
	$iPhone = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
	$iPad = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
	$Android= stripos($_SERVER['HTTP_USER_AGENT'],"Android");
	$webOS= stripos($_SERVER['HTTP_USER_AGENT'],"webOS");
	$device_is=false;
	//do something with this information
	if( $iPod || $iPhone ){
	        //were an iPhone/iPod touch -- do something here
		$device_is="ios";
	}else if($iPad){
	        //were an iPad -- do something here
		$device_is="ios";
	}else if($Android){
	        //were an Android device -- do something here
		$device_is="android";
	}else if($webOS){
	        //were a webOS device -- do something here
	}
	return $device_is;
}
// Check if a Shortcode is in a string 
function kreativa_has_shortcode_instring($shortcode,$string) {
	$found=false;
	if ( stripos($string, '[' . $shortcode) !== false ) {
		// we have found the short code
		$found = true;
	}
	return $found;
}
/*
Numbe pads ex. 01 when $n is 2 and number is 1, 001 if $n is 3
if $number is 12 it returns 12 - no changes
*/
function kreativa_number_pad($number,$n) {
	return str_pad((int) $number,$n,"0",STR_PAD_LEFT);
}
/*
Tag Cloud Font size modifier
*/
function kreativa_tag_cloud_filter($args = array()) {
   $args['smallest'] = 10;
   $args['largest'] = 14;
   $args['unit'] = 'px';
   return $args;
}
add_filter('widget_tag_cloud_args', 'kreativa_tag_cloud_filter', 90);
/*-------------------------------------------------------------------------*/
/* Check for shortcode */
/*-------------------------------------------------------------------------*/
// check the current post for the existence of a short code  
function kreativa_got_shortcode($shortcode = '') {  
  	global $post;
	if ( isSet($post->ID) ) {
		$post_to_check = get_post(get_the_ID());  
	}
	// false because we have to search through the post content first  
	$found = false;  
  
	// if no short code was provided, return false  
	if (!$shortcode) {  
		return $found;  
	}
	if ( isset($post_to_check) ) {
		// check the post content for the short code  
		if ( stripos($post_to_check->post_content, '[' . $shortcode) !== false ) {  
			// we have found the short code  
			$found = true;  
		}
	}
  
	// return our final results  
	return $found;  
}
function kreativa_get_select_target_options($type) {
        $list_options = array();
        
        switch($type){
			case 'post':
				$the_list = get_posts('orderby=title&numberposts=-1&order=ASC');
				foreach($the_list as $key => $list) {
					$list_options[$list->ID] = $list->post_title;
				}
				break;
			case 'page':
				$the_list = get_pages('title_li=&orderby=name');
				foreach($the_list as $key => $list) {
					$list_options[$list->ID] = $list->post_title;
				}
				break;
			case 'category':
				$the_list = get_categories('orderby=name&hide_empty=0');
				foreach($the_list as $key => $list) {
					$list_options[$list->term_id] = $list->name;
				}
				break;
			case 'backgroundslideshow_choices':
				$list_options = array(
					'options_slideshow'=>esc_html__('Theme Options set slideshow','kreativa'),
					'image_attachments'=>esc_html__('Slideshow using Image Attachments','kreativa'),
					'video_background'=>esc_html__('Video using Fullscreen post (Youtube/HTML5)','kreativa'),
					'none'=>esc_html__('none','kreativa')
					);
				break;
			case 'portfolio_category':
				$the_list = get_categories('taxonomy=types&title_li=');
				foreach($the_list as $key => $list) {
					$list_options[$list->slug] = $list->name;
				}
				array_unshift($list_options, "All the items");
				break;
			case 'client_names':
				// Pull all the Featured into an array
				$featured_pages = get_posts('post_type=mtheme_clients&orderby=title&numberposts=-1&order=ASC');
				$list_options['none'] = "Not Selected";
				if ($featured_pages) {
					foreach($featured_pages as $key => $list) {
						$list_options[$list->ID] = $list->post_title;
					}
				} else {
					$list_options[0]="Clients not found.";
				}
				break;
			case 'fullscreen_slideshow_posts':
				// Pull all the Featured into an array
				$featured_pages = get_posts('post_type=mtheme_featured&orderby=title&numberposts=-1&order=ASC');
				$list_options['none'] = "Not Selected";
				if ($featured_pages) {
					foreach($featured_pages as $key => $list) {
						$custom = get_post_custom($list->ID);
						if ( isSet($custom[ "pagemeta_fullscreen_type"][0]) ) { 
							$slideshow_type=$custom[ "pagemeta_fullscreen_type"][0]; 
						} else {
							$slideshow_type="";
						}
						if ( $slideshow_type != "video" && $slideshow_type<>"" && $slideshow_type != "photowall" && $slideshow_type != "revslider" ) {
							$list_options[$list->ID] = $list->post_title;
						}
					}
				} else {
					$list_options[0]="Featured pages not found.";
				}
				break;
			case 'fullscreen_video_bg':
				// Pull all the Featured into an array
				$featured_pages = get_posts('post_type=mtheme_featured&orderby=title&numberposts=-1&order=ASC');
				$list_options['none'] = "Not Selected";
				if ($featured_pages) {
					foreach($featured_pages as $key => $list) {
						$custom = get_post_custom($list->ID);
						if ( isSet($custom[ "pagemeta_fullscreen_type"][0]) ) { 
							$slideshow_type=$custom[ "pagemeta_fullscreen_type"][0]; 
						} else {
							$slideshow_type="";
						}
						if ($slideshow_type == "video") {
							if ( isSet($custom[ "pagemeta_html5_mp4"][0]) || isSet($custom[ "pagemeta_youtubevideo"][0]) ) {
								$list_options[$list->ID] = $list->post_title;
							}
						}
					}
				} else {
					$list_options[0]="Featured pages not found.";
				}
				break;
			case 'fullscreen_posts':
				// Pull all the Featured into an array
				$featured_pages = get_posts('post_type=mtheme_featured&orderby=title&numberposts=-1&order=ASC');
				$list_options['none'] = "Not Selected";
				if ($featured_pages) {
					foreach($featured_pages as $key => $list) {
						$custom = get_post_custom($list->ID);
						if ( isset($custom[ "pagemeta_fullscreen_type"][0]) ) { 
							$slideshow_type=$custom[ "pagemeta_fullscreen_type"][0]; 
						} else {
							$slideshow_type="";
						}
						$list_options[$list->ID] = $list->post_title;
					}
				} else {
					$list_options[0]="Featured pages not found.";
				}
				break;
		}
		
		return $list_options;
	}
	
function kreativa_posted_on() {
	echo '<div class="post-meta-info">';
	echo '<div class="posted-in">' . esc_html_e('Posted in ','kreativa') . " " .  the_category(', ') ."</div>";
	printf( esc_html__( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'kreativa' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		sprintf( esc_attr__( 'View all posts by %s', 'kreativa' ), get_the_author() ),
		esc_html( get_the_author() )
	);
	echo '<span class="comments">';
	comments_popup_link('No Comments', '1 Comment', '% Comments');
	echo '</span>';
	echo '</div>';
}
/*-------------------------------------------------------------------------*/
/* Shorten text to closest complete word from provided text */
/*-------------------------------------------------------------------------*/
function kreativa_shortentext ($textblock, $textlen) {

	if ($textblock) {
	$output = substr(substr($textblock, 0, $textlen), 0, strrpos(substr($textblock, 0, $textlen), ' '));  
	return $output;
	}
}
/*-------------------------------------------------------------------------*/
/* Show featured image link */
/*-------------------------------------------------------------------------*/
function kreativa_featured_image_link ($ID) {
	if (!isSet($ID)) {
		$ID = get_the_id();
	}
	$image_id = get_post_thumbnail_id($ID, 'full'); 
	$image_url = wp_get_attachment_image_src($image_id,'full');  
	$image_url = $image_url[0];
	return $image_url;
}
/*-------------------------------------------------------------------------*/
/* Show featured image title */
/*-------------------------------------------------------------------------*/
function kreativa_featured_image_title ($ID) {
	$img_title='';
	$image_id = get_post_thumbnail_id($ID);
	$img_obj = get_post($image_id);
	if (isSet($img_obj)){
		$img_title = $img_obj->post_title;
	}
	return $img_title;
}
/*-------------------------------------------------------------------------*/
/* Show attached image real link */
/*-------------------------------------------------------------------------*/
function kreativa_featured_image_real_link ($ID) {
	$image_id = get_post_thumbnail_id($ID, 'full'); 
	$image_url = wp_get_attachment_image_src($image_id,'full');  
	$image_url = $image_url[0];

	return $image_url;
}
/*-------------------------------------------------------------------------*/
/* Resize images and cross check if WP MU using blog ID */
/*-------------------------------------------------------------------------*/
function kreativa_showimage ($image,$link_url,$resize,$height,$width,$quality, $crop, $title,$class) {
	$image_url=$image;
	$output=""; // Set nill
	if ($link_url<>"") {
		$output = '<a href="' . esc_url( $link_url ) . '">';
	}
	if ($resize==true) {
		if ($image) {
			if ($class) {
				$output .= '<img src="'. esc_url( $image_url ) .'" alt="'. esc_attr( $title ) .'" class="'. $class .'"/>';
			} else {
				$output .= '<img src="'. esc_url( $image_url ) .'" alt="'. esc_attr( $title ) .'" />';
			}
		}
	}
	if ($resize==false) {
		if ($image_url) {
			if ($class) {
				$output .= '<img src="'. esc_url( $image_url ) .'" alt="'. esc_attr( $title ) .'" class="'. $class .'"/>';
			} else {
				$output .= '<img src="'. esc_url( $image_url ) .'" alt="'. esc_attr( $title ) .'" />';
			}
		}
	}
	if ($link_url<>"") {
		$output .= '</a>';
	}
	return $output;
}
/*-------------------------------------------------------------------------*/
/* Show featured image */
/* 
@ ID 
@ $height
@ $width
@ quality
@ $crop
@ $title
@ $class
/*-------------------------------------------------------------------------*/
function kreativa_display_post_image ($ID,$have_image_url,$link,$type,$title,$class) {

	if ($type=="") $type="fullsize";
	$output="";
	
	$image_id = get_post_thumbnail_id(($ID), $type); 
	$image_url = wp_get_attachment_image_src($image_id,$type);  
	$image_url = $image_url[0];

	$img_obj = get_post($image_id);
	$img_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
	
	$permalink = get_permalink( $ID );
	
	if ($link==true) {
		$output = '<a href="' . esc_url( $permalink ) . '">';
	}
	
	if ($have_image_url) {
		$img_alt = kreativa_get_alt_text($ID);
		$output .= '<img src="'. esc_url( $have_image_url ) .'" alt="'. esc_attr( $img_alt ) .'" class="'. $class .'"/>';
	} else {
		if ($image_url) {
			if ($class) {
				$output .= '<img src="'. esc_url( $image_url ) .'" alt="'. esc_attr( $img_alt ) .'" class="'. $class .'"/>';
			} else {
				$output .= '<img src="'. esc_url( $image_url ) .'" alt="'. esc_attr( $img_alt ) .'" />';
			}
		}
	}
	
	if ($link==true) {
		$output .= '</a>';
	}
	
	return $output;
}
/*-------------------------------------------------------------------------*/
/* Get Page ID by Slug */
/*-------------------------------------------------------------------------*/
function kreativa_get_page_id($page_slug)
{
	$page_id = get_page_by_path($page_slug);
	if ($page_id) :
		return $page_id->ID;
	else :
		return null;
	endif;
}
/*-------------------------------------------------------------------------*/
/* Get Page ID by Title */
/*-------------------------------------------------------------------------*/
function kreativa_get_page_title_by_id($page_id)
{
	$page = get_post($page_id);
	if ($page) :
		return $page->post_title;
	else :
		return null;
	endif;
}
/*-------------------------------------------------------------------------*/
/* Get Page Link by Title */
/*-------------------------------------------------------------------------*/
function kreativa_get_page_link_by_title($page_title) {
  $page = get_page_by_title($page_title);
  if ($page) :
    return get_permalink( $page->ID );
  else :
    return "#";
  endif;
}
/*-------------------------------------------------------------------------*/
/* Get Page link by Slug */
/*-------------------------------------------------------------------------*/
function kreativa_get_page_link_by_slug($page_slug) {
  $page = get_page_by_path($page_slug);
  if ($page) :
    return get_permalink( $page->ID );
  else :
    return "#";
  endif;
}
/*-------------------------------------------------------------------------*/
/* Get Page link by ID */
/*-------------------------------------------------------------------------*/
function kreativa_get_page_link_by_id($page_id) {
  $page = get_post($page_id);
  if ($page) :
    return get_permalink( $page->ID );
  else :
    return "#";
  endif;
}
/*-------------------------------------------------------------------------*/
/* Get Human Time */
/*-------------------------------------------------------------------------*/
function kreativa_time_since($older_date, $newer_date = false)
	{
	//Script URI: http://binarybonsai.com/wordpress/timesince
	// array of time period chunks
	$chunks = array(
	array(60 * 60 * 24 * 365 , esc_html__('year','kreativa') ),
	array(60 * 60 * 24 * 30 , esc_html__('month','kreativa') ),
	array(60 * 60 * 24 * 7, esc_html__('week','kreativa') ),
	array(60 * 60 * 24 , esc_html__('day','kreativa') ),
	array(60 * 60 , esc_html__('hour','kreativa') ),
	array(60 , esc_html__('minute','kreativa') ),
	);
	
	// $newer_date will equal false if we want to know the time elapsed between a date and the current time
	// $newer_date will have a value if we want to work out time elapsed between two known dates
	$newer_date = ($newer_date == false) ? (time()+(60*60*get_settings("gmt_offset"))) : $newer_date;
	
	// difference in seconds
	$since = $newer_date - $older_date;
	
	// we only want to output two chunks of time here, eg:
	// x years, xx months
	// x days, xx hours
	// so there's only two bits of calculation below:

	// step one: the first chunk
	for ($i = 0, $j = count($chunks); $i < $j; $i++)
		{
		$seconds = $chunks[$i][0];
		$name = $chunks[$i][1];

		// finding the biggest chunk (if the chunk fits, break)
		if (($count = floor($since / $seconds)) != 0)
			{
			break;
			}
		}

	// set output var
	$output = ($count == 1) ? '1 '.$name : "$count {$name}s";

	// step two: the second chunk
	if ($i + 1 < $j)
		{
		$seconds2 = $chunks[$i + 1][0];
		$name2 = $chunks[$i + 1][1];
		
		if (($count2 = floor(($since - ($seconds * $count)) / $seconds2)) != 0)
			{
			// add to output var
			$output .= ($count2 == 1) ? ', 1 '.$name2 : ", $count2 {$name2}s";
			}
		}
	return $output;
}
/***** Numbered Page Navigation (Pagination) Code.
      Tested up to WordPress version 3.1.2 *****/
 
/* Function that Rounds To The Nearest Value.
   Needed for the pagenavi() function */
function kreativa_round_num($num, $to_nearest) {
   /*Round fractions down (http://php.net/manual/en/function.floor.php)*/
   return floor($num/$to_nearest)*$to_nearest;
}
 

// Custom Pagination codes
function kreativa_pagination($pages = '', $range = 4)
{ 
	$pagination='';
     $showitems = ($range * 2)+1; 
 
    global $paged;
	if ( get_query_var('paged') ) {
		$paged = get_query_var('paged');
	} elseif ( get_query_var('page') ) {
		$paged = get_query_var('page');
	} else {
		$paged = 1;
	}
     if(empty($paged)) $paged = 1;
 
     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }  
 
     if(1 != $pages)
     {
         $pagination .= '<div class="pagination-navigation">';
         $pagination .=  "<div class=\"pagination\">";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) $pagination .=  "<a class='pagination-first' href='". esc_url( get_pagenum_link(1) )."'>&laquo;</a>";
         if($paged > 1 && $showitems < $pages) $pagination .=  "<a class='pagination-previous' href='".esc_url( get_pagenum_link($paged - 1) )."'>&lsaquo;</a>";
 
         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 $pagination .=  ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".esc_url( get_pagenum_link($i) )."' class=\"inactive\">".$i."</a>";
             }
         }
 
         if ($paged < $pages && $showitems < $pages) $pagination .=  "<a href=\"".esc_url( get_pagenum_link($paged + 1) )."\">&rsaquo;</a>"; 
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) $pagination .=  "<a href='".esc_url( get_pagenum_link($pages) )."'>&raquo;</a>";
         $pagination .=  "</div>";
         $pagination .=  "</div>";
     }
     return $pagination;
}

/*
Lighten a colour

$colour = '#ae64fe';
$brightness = 0.5; // 50% brighter
$newColour = colourBrightness($colour,$brightness);

Darken a colour

$colour = '#ae64fe';
$brightness = -0.5; // 50% darker
$newColour = colourBrightness($colour,$brightness);
*/
function kreativa_colourBrightness($hex, $percent) {
	// Work out if hash given
	$hash = '';
	if (stristr($hex,'#')) {
		$hex = str_replace('#','',$hex);
		$hash = '#';
	}
	/// HEX TO RGB
	$rgb = array(hexdec(substr($hex,0,2)), hexdec(substr($hex,2,2)), hexdec(substr($hex,4,2)));
	//// CALCULATE
	for ($i=0; $i<3; $i++) {
		// See if brighter or darker
		if ($percent > 0) {
			// Lighter
			$rgb[$i] = round($rgb[$i] * $percent) + round(255 * (1-$percent));
		} else {
			// Darker
			$positivePercent = $percent - ($percent*2);
			$rgb[$i] = round($rgb[$i] * $positivePercent) + round(0 * (1-$positivePercent));
		}
		// In case rounding up causes us to go to 256
		if ($rgb[$i] > 255) {
			$rgb[$i] = 255;
		}
	}
	//// RBG to Hex
	$hex = '';
	for($i=0; $i < 3; $i++) {
		// Convert the decimal digit to hex
		$hexDigit = dechex($rgb[$i]);
		// Add a leading zero if necessary
		if(strlen($hexDigit) == 1) {
		$hexDigit = "0" . $hexDigit;
		}
		// Append to the hex string
		$hex .= $hexDigit;
	}
	return $hash.$hex;
}

/**
 * Convert a hexa decimal color code to its RGB equivalent
 *
 * @param string $hexStr (hexadecimal color value)
 * @param boolean $returnAsString (if set true, returns the value separated by the separator character. Otherwise returns associative array)
 * @param string $seperator (to separate RGB values. Applicable only if second parameter is true.)
 * @return array or string (depending on second parameter. Returns False if invalid hex color value)
 */                                                                                                
function kreativa_hex2RGB($hexStr, $returnAsString = false, $seperator = ',') {
    $hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
    $rgbArray = array();
    if (strlen($hexStr) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
        $colorVal = hexdec($hexStr);
        $rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
        $rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
        $rgbArray['blue'] = 0xFF & $colorVal;
    } elseif (strlen($hexStr) == 3) { //if shorthand notation, need some string manipulations
        $rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
        $rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
        $rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
    } else {
        return false; //Invalid hex color code
    }
    return $returnAsString ? implode($seperator, $rgbArray) : $rgbArray; // returns the rgb string or the associative array
}
?>