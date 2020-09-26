<?php
/**
 * Krystal Theme Customizer Helper Functions
 *
 * @package krystal
 */


/**
* Render callback for kr_topbar_phone
*
* 
* @return mixed
*/
if ( ! function_exists( 'krystal_topbar_phone_render_callback' ) ) :
function krystal_topbar_phone_render_callback(){
    return wp_kses_post( get_theme_mod( 'kr_topbar_phone' ) );
}
endif;

/**
* Render callback for kr_home_heading_text
*
* 
* @return mixed
*/
if ( ! function_exists( 'krystal_home_heading_text_render_callback' ) ) :
function krystal_home_heading_text_render_callback() {
    return wp_kses_post( get_theme_mod( 'kr_home_heading_text' ) );
}
endif;

/**
* Render callback for kr_home_subheading_text
*
* 
* @return mixed
*/
if ( ! function_exists( 'krystal_home_subheading_text_render_callback' ) ) :
function krystal_home_subheading_text_render_callback() {
    return wp_kses_post( get_theme_mod( 'kr_home_subheading_text' ) );
}
endif;


/**
 * Check if the color radio enabled or not in home background section
 */
function krystal_home_bg_color_enable( $control ) {
	if ( $control->manager->get_setting( 'kr_home_bg_radio' )->value() == 'color' && $control->manager->get_setting( 'kr_home_disable_section' )->value() == false)  {
		return true;
	} else {
		return false;
	}
}

/**
 * Check if the image radio enabled or not in home background section
 */
function krystal_home_bg_image_enable( $control ) {
	if ( $control->manager->get_setting( 'kr_home_bg_radio' )->value() == 'image' && $control->manager->get_setting( 'kr_home_disable_section' )->value() == false) {
		return true;
	} else {
		return false;
	}
}

/**
 * Check if the color radio enabled or not in page title section
 */
function krystal_page_title_color_enable( $control ) {
	if ( $control->manager->get_setting( 'kr_page_bg_radio' )->value() == 'color' && $control->manager->get_setting( 'kr_page_title_section_hide' )->value() == false) {
		return true;
	} else {
		return false;
	}
}

/**
 * Check if the image radio enabled or not in page title section
 */
function krystal_page_title_image_enable( $control ) {
	if ( $control->manager->get_setting( 'kr_page_bg_radio' )->value() == 'image' && $control->manager->get_setting( 'kr_page_title_section_hide' )->value() == false) {
		return true;
	} else {
		return false;
	}
}

/**
 * Check if the sticky header enabled or not
 */
function krystal_sticky_header_enable( $control ) {
	if ( $control->manager->get_setting( 'kr_sticky_menu' )->value() == true) {
		return true;
	} else {
		return false;
	}
}

/**
 * Check if the scroll down enabled or not
 */
function krystal_scroll_down_enable( $control ) {
	if ( $control->manager->get_setting( 'kr_home_scroll_down' )->value() == true) {
		return true;
	} else {
		return false;
	}
}

/**
 * Check if the home background enabled or not
 */
function krystal_home_bg_enable( $control ) {
	if ( $control->manager->get_setting( 'kr_home_disable_section' )->value() == false) {
		return true;
	} else {
		return false;
	}
}


/**
 * Check if the page title disabled or not
 */
function krystal_page_title_disable( $control ) {
	if ( $control->manager->get_setting( 'kr_page_title_section_hide' )->value() == false) {
		return true;
	} else {
		return false;
	}
}


/**
 * Check if the preloader enabled or not
 */
function krystal_preloader_enable( $control ) {
	if ( $control->manager->get_setting( 'kr_preloader_display' )->value() == true) {
		return true;
	} else {
		return false;
	}
}
