<?php

/**
 * Generates the tabs that are used in the options menu
 */

function kreativa_tabs() {
	$counter = 0;
	$optionsframework_settings = get_option('optionsframework');
	$options =kreativa_options();
	$menu = '';

	foreach ($options as $value) {
		$counter++;
		// Heading for Navigation
		$subheading_class="";
		if ( isSet($value['subheading']) ) {
				$subheading_class="nav-tab-subheading";
		}
		$the_tab_icon = '';
		if ( isSet($value['icon']) ) {
				$the_tab_icon='<i class="options-tab-icon '.$value['icon'].'"></i>';
		}
		if ($value['type'] == "heading") {
			$id = ! empty( $value['id'] ) ? $value['id'] : $value['name'];
			$jquery_click_hook = preg_replace('/[^a-zA-Z0-9._\-]/', '', strtolower($id) );
			$jquery_click_hook = "of-option-" . $jquery_click_hook;
			$menu .= '<a id="'.  esc_attr( $jquery_click_hook ) . '-tab" class="nav-tab '.esc_attr($subheading_class).'" title="' . esc_attr( $value['name'] ) . '" href="' . esc_attr( '#'.  $jquery_click_hook ) . '">' .$the_tab_icon. esc_html( $value['name'] ) . '</a>';
		}
	}

	return $menu;
}
/**
 * Generates the options fields that are used in the form.
 */

function kreativa_fields() {

	global $allowedtags;
	$optionsframework_settings = get_option('optionsframework');
	
	// Get the theme name so we can display it up top
	$themename = wp_get_theme(STYLESHEETPATH . '/style.css');

	$themename = $themename['Name'];

	// Gets the unique option id
	if (isset($optionsframework_settings['id'])) {
		$option_name = $optionsframework_settings['id'];
	}
	else {
		$option_name = 'optionsframework';
	};

	$settings = get_option($option_name);
    $options = kreativa_options();
        
    $counter = 0;
	$menu = '';
	$output = '';
	
	foreach ($options as $value) {
	   
		$counter++;
		$val = '';
		$select_value = '';
		$checked = '';
		
		
		// Wrap all options
		if ( ($value['type'] != "heading") && ($value['type'] != "info") ) {

			// Keep all ids lowercase with no spaces
			$value['id'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', strtolower($value['id']) );

			$id = 'section-' . esc_attr( $value['id'] );

			$class = 'section section-theme-options theme-options-clearfix';
			if ( isset( $value['type'] ) ) {
				$class .= ' section-' . esc_attr( $value['type'] );
			}
			if ( isset( $value['class'] ) ) {
				$class .= ' ' . esc_attr( $value['class'] );
			}

			$output .= '<div id="' . esc_attr( $id ) .'" class="' . esc_attr( $class ) . '">'."\n";
			$output .= '<div class="section-block">';
			$output .= '<h4 class="heading">' . esc_html( $value['name'] ) . '</h4>' . "\n";
			$explain_value = '';
			if ( isset( $value['desc'] ) ) {
				$explain_value = $value['desc'];
				$output .= '<div class="explain">' . $explain_value . '</div>'."\n";
			}
			$output .= '</div>';
			$output .= '<div class="option">' . "\n" . '<div class="controls">' . "\n";
		 }
		
		// Set default value to $val
		if ( isset( $value['std']) ) {
			$val = $value['std'];
		}
		
		// If the option is already saved, ovveride $val
		if ( ($value['type'] != 'heading') && ($value['type'] != 'info')) {
			if ( isset($settings[($value['id'])]) ) {
					$val = $settings[($value['id'])];
					// Striping slashes of non-array options
					if (!is_array($val)) {
						$val = stripslashes($val);
					}
			}
		}
		
		if ( isset( $value['id']) ) {
			$val=get_option( 'mtheme_' .  $value['id'] );
		}
		
		switch ( $value['type'] ) {


		case 'iconpicker':

				$output .= '<input class="of-input regular-text" type="hidden" id="' . esc_attr( $value['id'] ) . '" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" value="';
				if( isset( $val ) ) { 
					//$output .=  esc_attr( $options['icon1'] );
					$output .=  esc_attr( $val );
				}
				$output .= '"/>';
				$output .= '<div id="preview_icon_picker_example_icon1" data-target="#' . esc_attr( $value['id'] ) . '" class="button icon-picker ';
				if( isset( $val ) ) {
					$output .= $val;
				}
				$output .= '"></div>';

				break;
		
		// Basic text input
		case 'text':
			
			if ( isset($value['unit']) ) {
				$output .= '<div class="ranger-min-max-wrap"><span class="ranger-min-value">'.esc_attr($value['min']).'</span>';
				$output .= '<span class="ranger-max-value">'.esc_attr($value['max']).'</span></div>';
				$output .= '<div id="' . esc_attr( $value['id'] ) . '_slider"></div>';
				$output .= '<div class="ranger-bar">';
			}
			
			$output .= '<input id="' . esc_attr( $value['id'] ) . '" class="of-input" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" type="text" value="' . esc_attr( $val ) . '"';
			
			if ( isset($value['unit']) ) {
				if (isset($value['min'])) {
					$output .= ' min="' . esc_attr($value['min']);
				}
				if (isset($value['max'])) {
					$output .= '" max="' . esc_attr($value['max']);
				}
				if (isset($value['step'])) {
					$output .= '" step="' . esc_attr($value['step']);
				}
				$output .= '" />';
				if (isset($value['unit'])) {
					$output .= '<span>' . esc_attr($value['unit']) . '</span>';
				}
				$output .= '</div>';
			} else {
				$output .= ' />';
			}

			if ($value['id']=="insta_token" && $val<>"") {
				$output .= '<div id="reset-instagram-cache" class="reset-instagram-cache">Reset instagram cache</div>';
			}
			
		break;

		case 'dragdrop_sorter':
		break;

		case 'exporttextarea':

			$cols = '8';
			$ta_value = '';
			
			if(isset($value['options'])){
				$ta_options = $value['options'];
				if(isset($ta_options['cols'])){
					$cols = $ta_options['cols'];
				} else { $cols = '8'; }
			}
			
			if ( !is_serialized($val) ) {
				if ( is_array($val) ) {
					$val = serialize($val);
				} else {
					$val = stripslashes( $val );
				}
			}

			$textarea_class="";
			if (isSet($value['class'])) {
				$textarea_class=$value['class'];
			}

			$output .= '<textarea readonly id="' . esc_attr( $value['id'] ) . '" class="of-input opt-textbox-'.esc_attr($textarea_class).'" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" cols="'. esc_attr( $cols ) . '" rows="8">' . esc_textarea($val) . '</textarea>';
			
		break;

		case 'importtextarea':

			$cols = '8';
			$ta_value = '';
			
			if(isset($value['options'])){
				$ta_options = $value['options'];
				if(isset($ta_options['cols'])){
					$cols = $ta_options['cols'];
				} else { $cols = '8'; }
			}
			
			if ( !is_serialized($val) ) {
				if ( is_array($val) ) {
					$val = serialize($val);
				} else {
					$val = stripslashes( $val );
				}
			}

			$textarea_class="";
			if (isSet($value['class'])) {
				$textarea_class=$value['class'];
			}

			$output .= '<textarea id="' . esc_attr( $value['id'] ) . '" class="of-input opt-textbox-'.esc_attr($textarea_class).'" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" cols="'. esc_attr( $cols ) . '" rows="8">' . esc_textarea($val) . '</textarea>';
			$output .= '<div><input type="submit" class="button button-secondary button-large" name="import" value="'.esc_html__('Import Options','kreativa').'" /></div>';

		break;

		// Textarea
		case 'textarea':
			$cols = '8';
			$ta_value = '';
			
			if(isset($value['options'])){
				$ta_options = $value['options'];
				if(isset($ta_options['cols'])){
					$cols = $ta_options['cols'];
				} else { $cols = '8'; }
			}
			
			if ( !is_serialized($val) ) {
				if ( is_array($val) ) {
					$val = serialize($val);
				} else {
					$val = stripslashes( $val );
				}
			}

			if ( is_serialized($val) ) {
				$readonly_mode ="readonly";
			} else {
				$readonly_mode="";
			}

			$textarea_class="";
			if (isSet($value['class'])) {
				$textarea_class=$value['class'];
			}
			
			$output .= '<textarea '.$readonly_mode.' id="' . esc_attr( $value['id'] ) . '" class="of-input opt-textbox-'.esc_attr($textarea_class).'" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" cols="'. esc_attr( $cols ) . '" rows="8">' . esc_textarea($val) . '</textarea>';
		break;
		
		// Select Box
		case ($value['type'] == 'select'):
			$output .= '<select class="of-input" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" id="' . esc_attr( $value['id'] ) . '">';
			
			foreach ($value['options'] as $key => $option ) {
				$selected = '';
				 if( $val != '' ) {
					 if ( $val == $key) { $selected = ' selected="selected"';} 
			     }
				 $output .= '<option'. $selected .' value="' . esc_attr( $key ) . '">' . esc_html( $option ) . '</option>';
			 } 
			 $output .= '</select>';
		break;

		// Select Box
		case 'selectyper':
			$output .= '<select class="chosen-select not-of-input" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" id="' . esc_attr( $value['id'] ) . '">';
			
			foreach ($value['options'] as $key => $option ) {
				$selected = '';
				 if( $val != '' ) {
					 if ( $val == $key) { $selected = ' selected="selected"';} 
			     }
				 $output .= '<option'. $selected .' value="' . esc_attr( $key ) . '">' . esc_html( $option ) . '</option>';
			 } 
			 $output .= '</select>';
		break;

		// Select Box
		case 'selectgooglefont':
			$output .= '<select class="chosen-select not-of-input google_font_select" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" id="' . esc_attr( $value['id'] ) . '">';
			
			foreach ($value['options'] as $key => $option ) {
				$selected = '';
				 if( $val != '' ) {
					 if ( $val == $key) { $selected = ' selected="selected"';} 
			     }
				 $output .= '<option'. $selected .' data-font="' . esc_attr( $option ) . '" value="' . esc_attr( $key ) . '">' . esc_html( $option ) . '</option>';
			 } 
			 $output .= '</select>';

			$googlefont_text = 'abcdefghijklmnopqrstuvwxyz ABCDEFGHIJKLMNOPQRSTUVWXYZ 0123456789';

			$hide = " hide";
			if ($key != "none" && $key != "") {
				$hide = "";
			} 

			$output .= '<p class="'.esc_attr( $value['id'].'_googlefont_previewer google_font_preview'.$hide ).'">'. esc_html( $googlefont_text ) .'</p>';
		break;

		//Sorter
		case 'sorter':
		
			$blog_url = home_url();
			$sort_order = $value['order'];
			$sort_val = explode(",", $sort_order);
			$count=0;
		
			$output .= '<img src="'. esc_url( $blog_url .'/wp-admin/images/loading.gif ' ) . '" id="loading-animation" />';
			$output .= '<ul id="home-list">';
			
			for ($count=0; $count<=6; $count++) {
				foreach ($value['options'] as $key => $option ) {
					if ($sort_val[$count]==$key) {
						$output .= '<li id="' . esc_attr($key) . '">' . esc_attr($option) . '</li>';
					}
				}
			}
			
			$output .= '</ul>';
		break;

		
		// Radio Box
		case "radio":
			$name = $option_name .'['. $value['id'] .']';
			foreach ($value['options'] as $key => $option) {
				$id = $option_name . '-' . $value['id'] .'-'. $key;
				$output .= '<input class="of-input of-radio" type="radio" name="' . esc_attr( $name ) . '" id="' . esc_attr( $id ) . '" value="'. esc_attr( $key ) . '" '. checked( $val, $key, false) .' /><label for="' . esc_attr( $id ) . '">' . esc_html( $option ) . '</label>';
			}
		break;
		
		// Image Selectors
		case "images":
			$name = $option_name .'['. $value['id'] .']';
			foreach ( $value['options'] as $key => $option ) {
				$selected = '';
				$checked = '';
				if ( $val != '' ) {
					if ( $val == $key ) {
						$selected = ' of-radio-img-selected';
						$checked = ' checked="checked"';
					}
				}
				$output .= '<input type="radio" id="' . esc_attr( $value['id'] .'_'. $key) . '" class="of-radio-img-radio" value="' . esc_attr( $key ) . '" name="' . esc_attr( $name ) . '" '. $checked .' />';
				$output .= '<div class="of-radio-img-label">' . esc_html( $key ) . '</div>';
				$output .= '<img src="' . esc_url( $option ) . '" alt="' . esc_attr($option) .'" class="of-radio-img-img' . $selected .'" onclick="document.getElementById(\''. esc_attr($value['id'] .'_'. $key) .'\').checked=true;" />';
			}
		break;
		
		// Checkbox
		case "checkbox":
		$output .= '<div class="toggle-wrap"><div class="togglebox">';
			$output .= '<input id="chkbx' . esc_attr( $value['id'] ) . '" class="checkbox of-input" type="checkbox" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" '. checked( $val, 1, false) .' /><label for="chkbx' . esc_attr( $value['id'] ) . '"><b></b></label></div></div>';
			
		break;
		
		// Multicheck
		case "multicheck":
			foreach ($value['options'] as $key => $option) {
				$checked = '';
				$label = $option;
				$option = preg_replace('/[^a-zA-Z0-9._\-]/', '', strtolower($key));

				$id = $option_name . '-' . $value['id'] . '-'. $option;
				$name = $option_name . '[' . $value['id'] . '][' . $option .']';

			    if ( isset($val[$option]) ) {
					$checked = checked($val[$option], 1, false);
				}

				$output .= '<input id="' . esc_attr( $id ) . '" class="checkbox of-input" type="checkbox" name="' . esc_attr( $name ) . '" ' . $checked . ' /><label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . '</label>';
			}
		break;
		
		// Color picker
		case "color":
			$output .= '<div id="' . esc_attr( $value['id'] . '_picker' ) . '" class="colorSelector"><div style="' . esc_attr( 'background-color:' . $val ) . '"></div></div>';
			$output .= '<input class="colorSwatch of-color" name="' . esc_attr( $option_name . '[' . $value['id'] . ']' ) . '" id="' . esc_attr( $value['id'] ) . '" type="text" value="' . esc_attr( $val ) . '" />';
		break;
		
		// Uploader
		case "upload":
			$output .= kreativa_medialibrary_uploader( $value['id'], $val, null ); // New AJAX Uploader using Media Library	
		break;
		
		// Typography
		case 'typography':
		
			unset( $font_size, $font_style, $font_face, $font_color );
		
			$typography_defaults = array(
				'size' => '',
				'face' => '',
				'style' => '',
				'color' => ''
			);
			
			$typography_stored = wp_parse_args( $val, $typography_defaults );
			
			$typography_options = array(
				'sizes' => of_recognized_font_sizes(),
				'faces' => of_recognized_font_faces(),
				'styles' => of_recognized_font_styles(),
				'color' => true
			);
			
			if ( isset( $value['options'] ) ) {
				$typography_options = wp_parse_args( $value['options'], $typography_options );
			}

			// Font Size
			if ( $typography_options['sizes'] ) {
				$font_size = '<select class="of-typography of-typography-size" name="' . esc_attr( $option_name . '[' . $value['id'] . '][size]' ) . '" id="' . esc_attr( $value['id'] . '_size' ) . '"
                                                onchange="options_font_preview(\'' . esc_attr( $value['id'] . '_size' ) . '\', \'' . esc_attr($value['id']) . '_preview'. '\', \'font-size\');return true;">';
				$sizes = $typography_options['sizes'];
				foreach ( $sizes as $i ) {
					$size = $i . 'px';
					$font_size .= '<option value="' . esc_attr( $size ) . '" ' . selected( $typography_stored['size'], $size, false ) . '>' . esc_html( $size ) . '</option>';
				}
				$font_size .= '</select>';
			}

			// Font Face
			if ( $typography_options['faces'] ) {
				$font_face = '<select class="of-typography of-typography-face" name="' . esc_attr( $option_name . '[' . $value['id'] . '][face]' ) . '" id="' . esc_attr( $value['id'] . '_face' ) . '" 
                                                onchange="options_font_preview(\'' . esc_attr( $value['id'] . '_face' ) . '\', \'' . esc_attr($value['id']) . '_preview'. '\', \'font-family\');return true;">';
				$faces = $typography_options['faces'];
				foreach ( $faces as $key => $face ) {
					$font_face .= '<option value="' . esc_attr( $key ) . '" ' . selected( $typography_stored['face'], $key, false ) . '>' . esc_html( $face ) . '</option>';
				}
				$font_face .= '</select>';
			}

			// Font Styles
			if ( $typography_options['styles'] ) {
				$font_style = '<select class="of-typography of-typography-style" name="'.esc_attr( $option_name.'['.$value['id'].'][style]' ). '" id="'. $value['id'].'_style"
                                                onchange="options_font_preview(\'' . esc_attr( $value['id'] . '_style' ) . '\', \'' . esc_attr($value['id']) . '_preview'. '\', \'font-style\');return true;">';
				$styles = $typography_options['styles'];
				foreach ( $styles as $key => $style ) {
					$font_style .= '<option value="' . esc_attr( $key ) . '" ' . selected( $typography_stored['style'], $key, false ) . '>'. $style .'</option>';
				}
				$font_style .= '</select>';
			}

			// Font Color
			if ( $typography_options['color'] ) {
				$font_color = '<div id="' . esc_attr( $value['id'] ) . '_color_picker" class="colorSelector"><div style="' . esc_attr( 'background-color:' . $typography_stored['color'] ) . '"></div></div>';
				$font_color .= '<input class="of-color of-typography of-typography-color" name="' . esc_attr( $option_name . '[' . $value['id'] . '][color]' ) . '" id="' . esc_attr( $value['id'] . '_color' ) . '" type="text" value="' . esc_attr( $typography_stored['color'] ) . '" />';
			}
	
			// Allow modification/injection of typography fields
			$typography_fields = compact( 'font_size', 'font_face', 'font_style', 'font_color' );
			$typography_fields = apply_filters( 'of_typography_fields', $typography_fields, $typography_stored, $option_name, $value );
			$output .= implode( '', $typography_fields );

                        
			break;
		
		// Background
		case 'background':
			
			$background = $val;
			
			// Background Color		
			$output .= '<div id="' . esc_attr( $value['id'] ) . '_color_picker" class="colorSelector"><div style="' . esc_attr( 'background-color:' . $background['color'] ) . '"></div></div>';
			$output .= '<input class="of-color of-background of-background-color" name="' . esc_attr( $option_name . '[' . $value['id'] . '][color]' ) . '" id="' . esc_attr( $value['id'] . '_color' ) . '" type="text" value="' . esc_attr( $background['color'] ) . '" />';
			
			// Background Image - New AJAX Uploader using Media Library
			if (!isset($background['image'])) {
				$background['image'] = '';
			}
			
			$output .= kreativa_medialibrary_uploader( $value['id'], $background['image'], null, '',0,'image');
			$class = 'of-background-properties';
			if ( '' == $background['image'] ) {
				$class .= ' hide';
			}
			$output .= '<div class="' . esc_attr( $class ) . '">';
			
			// Background Repeat
			$output .= '<select class="of-background of-background-repeat" name="' . esc_attr( $option_name . '[' . $value['id'] . '][repeat]'  ) . '" id="' . esc_attr( $value['id'] . '_repeat' ) . '">';
			$repeats = of_recognized_background_repeat();
			
			foreach ($repeats as $key => $repeat) {
				$output .= '<option value="' . esc_attr( $key ) . '" ' . selected( $background['repeat'], $key, false ) . '>'. esc_html( $repeat ) . '</option>';
			}
			$output .= '</select>';
			
			// Background Position
			$output .= '<select class="of-background of-background-position" name="' . esc_attr( $option_name . '[' . $value['id'] . '][position]' ) . '" id="' . esc_attr( $value['id'] . '_position' ) . '">';
			$positions = of_recognized_background_position();
			
			foreach ($positions as $key=>$position) {
				$output .= '<option value="' . esc_attr( $key ) . '" ' . selected( $background['position'], $key, false ) . '>'. esc_html( $position ) . '</option>';
			}
			$output .= '</select>';
			
			// Background Attachment
			$output .= '<select class="of-background of-background-attachment" name="' . esc_attr( $option_name . '[' . $value['id'] . '][attachment]' ) . '" id="' . esc_attr( $value['id'] . '_attachment' ) . '">';
			$attachments = of_recognized_background_attachment();
			
			foreach ($attachments as $key => $attachment) {
				$output .= '<option value="' . esc_attr( $key ) . '" ' . selected( $background['attachment'], $key, false ) . '>' . esc_html( $attachment ) . '</option>';
			}
			$output .= '</select>';
			$output .= '</div>';
		
		break;	
		
		// Info
		case "info":
			$class = 'section';
			if ( isset( $value['type'] ) ) {
				$class .= ' section-' . esc_attr($value['type']);
			}
			if ( isset( $value['class'] ) ) {
				$class .= ' ' . esc_attr($value['class']);
			}

			if ( isset($value['name']) ) {
				$output .= '<h5>' . esc_html( $value['name'] ) . '</h5>' . "\n";
			}
			if ( isset($value['desc']) ) {
				$output .= $value['desc'] . "\n";
			}
		break;                       
		
		// Heading for Navigation
		case "heading":
			if ($counter >= 2) {
			   $output .= '</div>'."\n";
			}
			$jquery_click_hook = preg_replace('/[^a-zA-Z0-9._\-]/', '', strtolower($value['name']) );
			$jquery_click_hook = "of-option-" . $jquery_click_hook;
			$menu .= '<a id="'.  esc_attr( $jquery_click_hook ) . '-tab" class="nav-tab" title="' . esc_attr( $value['name'] ) . '" href="' . esc_attr( '#'.  $jquery_click_hook ) . '">' . esc_html( $value['name'] ) . '</a>';
			$the_tab_icon = '';
			if ( isSet($value['icon']) ) {
					$the_tab_icon='<i class="options-tab-icon '.$value['icon'].'"></i>';
			}
			$output .= '<div class="group" id="' . esc_attr( $jquery_click_hook ) . '">';
			$output .= '<h3>' .$the_tab_icon. esc_html( $value['name'] ) . '</h3>' . "\n";
			break;
		}

		if ( ( $value['type'] != "heading" ) && ( $value['type'] != "info" ) ) {
				$output .= '<br/>';
			$output .= '</div>';
			$output .= '<div class="clear"></div></div></div>'."\n";
		}
	}
    $output .= '</div>';
    return $output;
}