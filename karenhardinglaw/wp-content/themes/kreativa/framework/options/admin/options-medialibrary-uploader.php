<?php

/**
 * WooThemes Media Library-driven AJAX File Uploader Module (2010-11-05)
 *
 * Slightly modified for use in the Options Framework.
 */

if ( is_admin() ) {
	// Load additional css and js for image uploads on the Options Framework page
	$of_page= 'toplevel_page_options-framework';
}

/**
 * Media Uploader Using the WordPress Media Library.
 *
 * Parameters:
 * - string $_id - A token to identify this field (the name).
 * - string $_value - The value of the field, if present.
 * - string $_mode - The display mode of the field.
 * - string $_desc - An optional description of the field.
 * - int $_postid - An optional post id (used in the meta boxes).
 *
 * Dependencies:
 * - kreativa_mlu_get_silentpost()
 */

// retrieves the attachment ID from the file URL
function kreativa_get_image_id_from_url($image_url) {
	global $wpdb;
	$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url )); 
	if ( isSet($attachment[0]) ) {
    	return $attachment[0];
	} else {
		return false;
	}
}
if ( ! function_exists( 'kreativa_medialibrary_uploader' ) ) {

	function kreativa_medialibrary_uploader( $_id, $_value, $_mode = 'full', $_desc = '', $_postid = 0, $_name = '') {
	
		$optionsframework_settings = get_option('optionsframework');
		
		// Gets the unique option id
		$option_name = $optionsframework_settings['id'];
	
		$output = '';
		$id = '';
		$class = '';
		$int = '';
		$value = '';
		$name = '';
		
		$id = strip_tags( strtolower( $_id ) );
		// Change for each field, using a "silent" post. If no post is present, one will be created.
		//$int = optionsframework_mlu_get_silentpost( $id );
		
		// If a value is passed and we don't have a stored value, use the value that's passed through.
		if ( $_value != '' && $value == '' ) {
			$value = $_value;
		}
		
		if ($_name != '') {
			$name = $option_name.'['.$id.']['.$_name.']';
		}
		else {
			$name = $option_name.'['.$id.']';
		}
		
		if ( $value ) { $class = ' has-file'; }
		$output .= '<input id="' . esc_attr($id) . '" class="upload' . esc_attr($class) . '" type="text" name="'.esc_attr($name).'" value="' . esc_attr($value) . '" />' . "\n";
		$output .= '<input id="upload_' . esc_attr($id) . '" class="upload_button button" type="button" value="' . esc_html__( 'Upload','kreativa' ) . '" rel="' . esc_attr($int) . '" />' . "\n";
		
		if ( $_desc != '' ) {
			$output .= '<span class="of_metabox_desc">' . $_desc . '</span>' . "\n";
		}
		
		$output .= '<div class="screenshot" id="' . esc_attr($id) . '_image">' . "\n";
		
		if ( $value != '' ) {
			$remove = '<span class="mlu_remove button"><i class="fa fa-times"></i></span>';
			$image = preg_match( '/(^.*\.jpg|jpeg|png|gif|ico*)/i', $value );
			if ( $image ) {
				$image_url_id = kreativa_get_image_id_from_url($value);
				$image_thumbnail_url = wp_get_attachment_image_src( $image_url_id , "thumbnail" , true );
				if ($image_thumbnail_url) {					
					$output .= '<img src="' . esc_url( $image_thumbnail_url[0] ) . '" alt="" />'.$remove.'';
				}
			} else {
				$parts = explode( "/", $value );
				for( $i = 0; $i < sizeof( $parts ); ++$i ) {
					$title = $parts[$i];
				}

				// No output preview if it's not an image.			
				$output .= '';
			
				// Standard generic output if it's not an image.	
				$title = esc_html__( 'View File', 'kreativa' );
				$output .= '<div class="no_image"><span class="file_link"><a href="' . esc_url( $value ) . '" target="_blank" rel="external">'.$title.'</a></span>' . $remove . '</div>';
			}	
		}
		$output .= '</div>' . "\n";
		return $output;
	}	
}