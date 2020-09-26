<?php
/**
 * Krystal Theme Customizer Data Sanitization
 *
 * @package krystal
 */


/**
 * Sanitize text box.
 *
 * @param string $input
 * @return string
 */
if ( ! function_exists( 'krystal_sanitize_text' ) ) :
function krystal_sanitize_text( $input ) {
    return esc_html( $input );
}
endif;

/**
 * Sanitize radio option buttons
 *
 * @param string $input
 * @return string
 */
if ( ! function_exists( 'krystal_sanitize_radio_selection' ) ) :
function krystal_sanitize_radio_selection( $input ) {
    $valid = array(
        'yes' => esc_html__('Yes', 'krystal'),
        'no' => esc_html__('No', 'krystal'),
     );

     if ( array_key_exists( $input, $valid ) ) {
        return $input;
     } else {
        return '';
     }
}
endif;

/**
 * Sanitize checkbox option buttons
 *
 * @param string $input
 * @return bool
 */
if ( ! function_exists( 'krystal_sanitize_checkbox_selection' ) ) :
function krystal_sanitize_checkbox_selection( $input ) {
    return ( ( isset( $input ) && true == $input ) ? true : false );
}
endif;

/**
 * Sanitize blog sidebar radio option 
 *
 * @param string $input
 * @return string
 */
if ( ! function_exists( 'krystal_sanitize_blog_sidebar_radio_selection' ) ) :
function krystal_sanitize_blog_sidebar_radio_selection(  $input ){
    $valid = array(
        'right' => esc_html__( 'Right', 'krystal' ),  
        'left' =>esc_html__( 'Left', 'krystal' ),      
     );

     if ( array_key_exists( $input, $valid ) ) {
        return $input;
     } else {
        return '';
     }
}
endif;

/**
 * Sanitize Footer Widgets Number select
 *
 * @param string $input
 * @return string
 */
if ( ! function_exists( 'krystal_sanitize_footer_widgets_radio_selection' ) ) :
function krystal_sanitize_footer_widgets_radio_selection( $input ){
    $valid = array(
        '3' => esc_html__( '3', 'krystal' ),
        '4' =>esc_html__( '4', 'krystal' ),
     );

     if ( array_key_exists( $input, $valid ) ) {
        return $input;
     } else {
        return '';
     }
}
endif;

/**
 * Sanitize radio bg option buttons
 *
 * @param string $input
 * @return string
 */
if ( ! function_exists( 'krystal_sanitize_radio_bg_selection' ) ) :
function krystal_sanitize_radio_bg_selection( $input ) {
    $valid = array(        
        'color' => esc_html__('Background Color','krystal'),
        'image' =>  esc_html__('Background Image','krystal'),
     );

     if ( array_key_exists( $input, $valid ) ) {
        return $input;
     } else {
        return '';
     }
}
endif;

/**
 * Sanitize blog style radio option
 *
 * @param string $input
 * @return string
 */
if ( ! function_exists( 'krystal_sanitize_blog_style_radio_selection' ) ) :
function krystal_sanitize_blog_style_radio_selection( $input ) {
    $valid = array(        
        'style1' => esc_html__('Style 1', 'krystal'),
        'style2' => esc_html__('Style 2', 'krystal'),
     );

     if ( array_key_exists( $input, $valid ) ) {
        return $input;
     } else {
        return '';
     }
}
endif;

/**
 * Sanitize Form elements style radio option
 *
 * @param string $input
 * @return string
 */
if ( ! function_exists( 'krystal_sanitize_form_elem_radio_selection' ) ) :
function krystal_sanitize_form_elem_radio_selection( $input ) {
    $valid = array(        
        'default' => esc_html__( 'Default Style', 'krystal' ),
        'bg' =>esc_html__( 'Solid Background Style', 'krystal' ),
     );

     if ( array_key_exists( $input, $valid ) ) {
        return $input;
     } else {
        return '';
     }
}
endif;


/**
 * Sanitize radio pagebg option buttons
 *
 * @param string $input
 * @return string
 */
if ( ! function_exists( 'krystal_sanitize_radio_pagebg_selection' ) ) :
function krystal_sanitize_radio_pagebg_selection( $input ) {
    $valid = array(        
        'color' => esc_html__('Background Color','krystal'),
        'image' =>  esc_html__('Background Image','krystal'),
     );

     if ( array_key_exists( $input, $valid ) ) {
        return $input;
     } else {
        return '';
     }
}
endif;


/**
 * Sanitize Header style radio option
 *
 * @param string $input
 * @return string
 */
if ( ! function_exists( 'krystal_sanitize_header_style_radio_selection' ) ) :
function krystal_sanitize_header_style_radio_selection( $input ) {
    $valid = array(        
        'style1' => esc_html__('Header Style1 - This will show full background image as header with menu over the image', 'krystal'),
        'style2' => esc_html__('Header Style2 - This header style will show background image below menu', 'krystal'),
     );

     if ( array_key_exists( $input, $valid ) ) {
        return $input;
     } else {
        return '';
     }
}
endif;

/**
 * Sanitize home text position radio option
 *
 * @param string $input
 * @return string
 */
if ( ! function_exists( 'krystal_sanitize_home_text_position_radio_selection' ) ) :
function krystal_sanitize_home_text_position_radio_selection( $input ) {
    $valid = array(        
        'left' =>esc_html__( 'Left', 'krystal' ),
        'center' =>esc_html__( 'Center', 'krystal' ),
        'right' => esc_html__( 'Right', 'krystal' ),
     );

     if ( array_key_exists( $input, $valid ) ) {
        return $input;
     } else {
        return '';
     }
}
endif;

/**
 * Sanitize Footer Widget radio option
 *
 * @param string $input
 * @return string
 */
if ( ! function_exists( 'krystal_sanitize_footer_widgets_radio_selection' ) ) :
function krystal_sanitize_footer_widgets_radio_selection( $input ) {
    $valid = array(        
        '3' => esc_html__( '3', 'krystal' ),
        '4' =>esc_html__( '4', 'krystal' ),
     );

     if ( array_key_exists( $input, $valid ) ) {
        return $input;
     } else {
        return '';
     }
}
endif;

/**
 * Sanitize checkbox.
 *
 * @param bool $checked Whether the checkbox is checked.
 * @return bool Whether the checkbox is checked.
 */
if ( ! function_exists( 'krystal_sanitize_checkbox' ) ) :
function krystal_sanitize_checkbox( $checked ) {
    // Boolean check.
    return ( ( isset( $checked ) && true == $checked ) ? true : false );
}
endif;

/**
 * URL sanitization.
 *
 * @see esc_url_raw() https://developer.wordpress.org/reference/functions/esc_url_raw/
 *
 * @param string $url URL to sanitize.
 * @return string Sanitized URL.
 */
if ( ! function_exists( 'krystal_sanitize_url' ) ) :
function krystal_sanitize_url( $url ) {
    return esc_url_raw( $url );
}
endif;

/**
 * Select sanitization
 * @see sanitize_key()               https://developer.wordpress.org/reference/functions/sanitize_key/
 * @see $wp_customize->get_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/get_control/
 *
 * @param string               $input   Slug to sanitize.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return string Sanitized slug if it is a valid choice; otherwise, the setting default.
 */
if ( ! function_exists( 'krystal_sanitize_select' ) ) :
function krystal_sanitize_select( $input, $setting ) {

    // Ensure input is a slug.
    $input = sanitize_key( $input );

    // Get list of choices from the control associated with the setting.
    $choices = $setting->manager->get_control( $setting->id )->choices;

    // If the input is a valid key, return it; otherwise, return the default.
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}
endif;

/**
 * Sanitize textarea.
 *
 * @param string $input
 * @return string
 */
if ( ! function_exists( 'krystal_sanitize_textarea' ) ) :
function krystal_sanitize_textarea( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}
endif;

/**
 * Sanitize image.
 *
 * @param string               $image   Image filename.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return string The image filename if the extension is allowed; otherwise, the setting default.
 */
if ( ! function_exists( 'krystal_sanitize_image' ) ) :
function krystal_sanitize_image( $image, $setting ) {
    /*
     * Array of valid image file types.
     *
     * The array includes image mime types that are included in wp_get_mime_types()
     */
    $mimes = array(
        'jpg|jpeg|jpe' => 'image/jpeg',
        'gif'          => 'image/gif',
        'png'          => 'image/png',
        'bmp'          => 'image/bmp',
        'tif|tiff'     => 'image/tiff',
        'ico'          => 'image/x-icon'
    );
    // Return an array with file extension and mime_type.
    $file = wp_check_filetype( $image, $mimes );
    // If $image has a valid mime_type, return it; otherwise, return the default.
    return ( $file['ext'] ? $image : $setting->default );
}
endif;

/**
 * Sanitize the Sidebar Position value.
 *
 * @param string $position.
 * @return string (left|right).
 */
if ( ! function_exists( 'krystal_sanitize_sidebar_position' ) ) :
function krystal_sanitize_sidebar_position( $position ) {
    if ( ! in_array( $position, array( 'left', 'right' ) ) ) {
        $position = 'right';
    }
    return $position;
}
endif;

/**
 * HTML sanitization
 *
 * @see wp_filter_post_kses() https://developer.wordpress.org/reference/functions/wp_filter_post_kses/
 *
 * @param string $html HTML to sanitize.
 * @return string Sanitized HTML.
 */
if ( ! function_exists( 'krystal_sanitize_html' ) ) :
function krystal_sanitize_html( $html ) {
    return wp_filter_post_kses( $html );
}
endif;

/**
 * CSS sanitization.
 *
 * @see wp_strip_all_tags() https://developer.wordpress.org/reference/functions/wp_strip_all_tags/
 *
 * @param string $css CSS to sanitize.
 * @return string Sanitized CSS.
 */
if ( ! function_exists( 'krystal_sanitize_css' ) ) :
function krystal_sanitize_css( $css ) {
    return wp_strip_all_tags( $css );
}
endif;

/**
 * Title sanitization.
 */
if ( ! function_exists( 'krystal_sanitize_title' ) ) :
function krystal_sanitize_title( $str ) {
    return sanitize_title( $str );  
}
endif;