<?php
function kreativa_generate_menulist () {
	$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
	$menu_select=false;
	if ( isSet($menus) ) {
		$menu_select = array();
		$menu_select['default'] = esc_html__('Default Menu','kreativa');

		foreach ( $menus as $menu ) {
			$menu_select[$menu->term_id] = $menu->name;
		}
	}
	return $menu_select;
}
function kreativa_generate_sidebarlist( $sidebarlist_type ) {
	$max_sidebars = kreativa_get_max_sidebars();
	if ($sidebarlist_type=="events") {
		$sidebar_options=array();
		$sidebar_options['events_sidebar']='Default Events Sidebar';
		$sidebar_options['default_sidebar']='Default Sidebar';
		for ($sidebar_count=1; $sidebar_count <= $max_sidebars; $sidebar_count++ ) {

			if ( kreativa_get_option_data('mthemesidebar-'.$sidebar_count) <> "" ) {
				$active_sidebar = kreativa_get_option_data('mthemesidebar-'.$sidebar_count);
				$sidebar_options['mthemesidebar-'.$sidebar_count] = $active_sidebar;
			}
		}
	}
	if ($sidebarlist_type=="proofing") {
		$sidebar_options=array();
		$sidebar_options['proofing_sidebar']='Default Proofing Sidebar';
		$sidebar_options['default_sidebar']='Default Sidebar';
		for ($sidebar_count=1; $sidebar_count <= $max_sidebars; $sidebar_count++ ) {

			if ( kreativa_get_option_data('mthemesidebar-'.$sidebar_count) <> "" ) {
				$active_sidebar = kreativa_get_option_data('mthemesidebar-'.$sidebar_count);
				$sidebar_options['mthemesidebar-'.$sidebar_count] = $active_sidebar;
			}
		}
	}
	if ($sidebarlist_type=="portfolio") {
		$sidebar_options=array();
		$sidebar_options['portfolio_sidebar']='Default Portfolio Sidebar';
		$sidebar_options['default_sidebar']='Default Sidebar';
		for ($sidebar_count=1; $sidebar_count <= $max_sidebars; $sidebar_count++ ) {

			if ( kreativa_get_option_data('mthemesidebar-'.$sidebar_count) <> "" ) {
				$active_sidebar = kreativa_get_option_data('mthemesidebar-'.$sidebar_count);
				$sidebar_options['mthemesidebar-'.$sidebar_count] = $active_sidebar;
			}
		}
	}
	if ($sidebarlist_type=="post" || $sidebarlist_type=="page" ) {
		$sidebar_options=array();
		$sidebar_options['default_sidebar']='Default Sidebar';
		if ( class_exists( 'woocommerce' ) ) {
			if ( $sidebarlist_type=="page" ) {
				$sidebar_options['woocommerce_sidebar']='Default WooCommerce Sidebar';
			}
		}
		for ($sidebar_count=1; $sidebar_count <= $max_sidebars; $sidebar_count++ ) {

			if ( kreativa_get_option_data('mthemesidebar-'.$sidebar_count) <> "" ) {
				$active_sidebar = kreativa_get_option_data('mthemesidebar-'.$sidebar_count);
				$sidebar_options['mthemesidebar-'.$sidebar_count] = $active_sidebar;
			}
		}
	}
	if (isSet($sidebar_options)) {
		return $sidebar_options;
	} else {
		return false;
	}
}
function kreativa_generate_metaboxes($meta_data,$post_id) {
	// Use nonce for verification
	echo '<input type="hidden" name="mtheme_meta_box_nonce" value="', wp_create_nonce( 'metabox-nonce' ), '" />';
	
	echo '<div class="metabox-wrapper clearfix">';
	$countcolumns=0;
	foreach ($meta_data['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post_id, $field['id'], true);
		$class="";
		$trigger_element="";
		$trigger="";
		
		$titleclass="is_title";
		if ( isSet($field['heading']) ) {
			if ( $field['heading']=="subhead" ) $titleclass="is_subtitle";
		}

		if (isset($field['class'])) {
			$class = $field['class'];
		}
		if (!isset($field['toggleClass'])) {
			$field['toggleClass']='';
		}
		if (!isset($field['toggleAction'])) {
			$field['toggleAction']='';
		}
		if (isset($field['triggerStatus'])) {
			if ($field['triggerStatus']=="on") $trigger_element="trigger_element";
			$trigger = "<span data-toggleClass='".$field['toggleClass']."' ";
			$trigger .= "data-toggleAction='".$field['toggleAction']."' ";
			$trigger .= "data-toggleID='".$field['id']."' ";
			$trigger .= "data-parentclass='".$field['class']."' ";
			$trigger .= "></span>";
		}

		if ( $field['type']=="nobreak" ) {
			$titleclass .=" is_nobreak";
			if ($field['sectiontitle']<>"") {
			}
			$div_column_open = true;
		}
		if ( $field['type']=="break" ) {
			$titleclass .=" is_break";
			if ( $countcolumns > 0 ) {
				if ( $div_is_open ) {
					echo '</div>';
				}
			}
			$countcolumns++;
			echo '<div class="metabox-column">';
			if ($field['sectiontitle']<>"") {
			}
			$div_column_open = true;
		}
		$div_is_open = true;
		echo '<div class="metabox-fields metaboxtype_', $field['type'] ,' '. $class . " " . $titleclass. " " . $trigger_element .'">',
				$trigger,
				'<div class="metabox_label"><label for="', $field['id'], '"></label></div>';
		if ( isSet($field['type']) ) {
			
			if ( $field['type']!="break" && $field['type']!="break") {
				if ( $field['name']!="" ) {
					echo '<div id="'.$field['id'].'-section-title" class="sectiontitle clearfix">'.$field['name'].'</div>';
				}
			}
			
			switch ($field['type']) {


			case 'selected_proofing_images':
				$filter_image_ids = kreativa_get_custom_attachments ( $post_id );
				$found_selection = false;
				if ( $filter_image_ids ) {

					foreach ( $filter_image_ids as $attachment_id) {
						$mtheme_proofing_status = get_post_meta($attachment_id,'checked',true);
						if ($mtheme_proofing_status=="true") {
							$found_selection = true;
						}
					}

					if ( $found_selection ) {

						echo '<div class="proofing-admin-selection">';
						echo '<ul>';
						foreach ( $filter_image_ids as $attachment_id) {
							$mtheme_proofing_status = get_post_meta($attachment_id,'checked',true);
							if ($mtheme_proofing_status=="true") {
								$thumbnail_imagearray = wp_get_attachment_image_src( $attachment_id , 'thumbnail' , false);
								$thumbnail_imageURI = $thumbnail_imagearray[0];
								echo '<li class="images"><img src="'.$thumbnail_imageURI.'" alt="selected" /></li>';
								$found_selection = true;
							}
						}
						foreach ( $filter_image_ids as $attachment_id) {
							$mtheme_proofing_status = get_post_meta($attachment_id,'checked',true);
							if ($mtheme_proofing_status=="true") {
								echo '<li>' . basename( get_attached_file( $attachment_id ) ) . '</li>';
								$found_selection = true;
							}
						}
						echo '</ul>';
						echo '</div>';
					}
				}

				if (!$found_selection) {
					echo '<div class="proofing-none-selected">';
					_e('No selection found.','kinatrix');
					echo '</div>';
				}


				break;

			case 'image_gallery':
				// SPECIAL CASE:
				// std controls button text; unique meta key for image uploads
				$meta = get_post_meta( $post_id, '_mtheme_image_ids', true );
				$thumbs_output = '';
				$button_text = ($meta) ? esc_html__('Edit Gallery', 'kreativa') : $field['std'];
				if( $meta ) {
					$field['std'] = esc_html__('Edit Gallery', 'kreativa');
					$thumbs = explode(',', $meta);
					$thumbs_output = '';
					foreach( $thumbs as $thumb ) {
						$thumbs_output .= '<li>' . wp_get_attachment_image( $thumb, 'thumbnail' ) . '</li>';
					}
				}

			    echo 
			    	'<td>
			    		<input type="button" class="button" name="' . esc_attr( $field['id'] ) . '" id="mtheme_images_upload" value="' . $button_text .'" />
			    		
			    		<input type="hidden" name="mtheme_meta[_mtheme_image_ids]" id="_mtheme_image_ids" value="' . ($meta ? $meta : 'false') . '" />

			    		<ul class="mtheme-gallery-thumbs">' . $thumbs_output . '</ul>
			    	</td>';

			    break;

			case 'multi_upload':
				// SPECIAL CASE:
				// std controls button text; unique meta key for image uploads
				$meta = get_post_meta( $post_id, esc_attr( $field['id'] ) , true );
				$thumbs_output = '';
				$button_text = ($meta) ? esc_html__('Edit Gallery', 'kreativa') : $field['std'];
				if( $meta ) {
					$field['std'] = esc_html__('Edit Gallery', 'kreativa');
					$thumbs = explode(',', $meta);
					$thumbs_output = '';
					foreach( $thumbs as $thumb ) {
						$thumbs_output .= '<li>' . wp_get_attachment_image( $thumb, 'thumbnail' ) . '</li>';
					}
				}

			    echo 
			    	'<td>
			    		<input type="button" data-galleryid="'.esc_attr( $field['id'] ).'" data-imageset="'.esc_attr($meta).'" class="button meta-multi-upload" name="' . esc_attr( $field['id'] ) . '" value="' . $button_text .'" />
			    		
			    		<input type="hidden" name="'.esc_attr( $field['id'] ).'" id="'.esc_attr( $field['id'] ).'" value="' . ($meta ? $meta : 'false') . '" />

			    		<ul class="mtheme-multi-thumbs multi-gallery-'.esc_attr( $field['id'] ).'">' . $thumbs_output . '</ul>
			    	</td>';

			    break;

				case 'display_image_attachments' :
					$images = get_children( array( 
								'post_parent' => $post_id,
								'post_status' => 'inherit',
								'post_type' => 'attachment',
								'post_mime_type' => 'image',
								'order' => 'ASC',
								'numberposts' => -1,
								'orderby' => 'menu_order' )
								);
					if ($images) {
						foreach ( $images as $id => $image ) {
							$attatchmentID = $image->ID;
							$imagearray = wp_get_attachment_image_src( $attatchmentID , 'thumbnail', false);
							$imageURI = $imagearray[0];
							$imageID = get_post($attatchmentID);
							$imageTitle = $image->post_title;
							echo '<img src="'. esc_url( $imageURI ).'" alt="image" />';
						}
					} else {
						echo esc_html__('No images found.','kreativa');
					}
					break;

				case "seperator":
					echo '<hr/>';

					break;

			// Color picker
				case "color":
					$default_color = '';
					if ( isset($value['std']) ) {
						if ( $val !=  $value['std'] )
							$default_color = ' data-default-color="' .esc_attr( $value['std'] ). '" ';
					}
					$color_value = $meta ? $meta : $field['std'];
					echo '<input name="' . esc_attr( $field['id'] ) . '" id="' . esc_attr( $field['id'] ) . '" class="colorSwatch of-color"  type="text" value="' . esc_attr( $color_value ) . '" />';

					break;

				case 'upload':
					if ($meta!="") {
						echo '<img height="100px" src="'. esc_url( $meta ).'" />';
					}
					echo '<div>';
					$upload_value = $meta ? $meta : $field['std'];
					echo '<input type="text" name="', esc_attr($field['id']), '" id="', esc_attr($field['id']), '" value="' . esc_attr($upload_value) . '" size="30" />';
					echo '<button class="button-shortcodegen-uploader" data-id="' . $field['id'] . '" value="Upload">Upload</button>';
					echo '</div>';
					break;
				case 'text':
					$text_value = $meta ? $meta : $field['std'];
					echo '<input type="text" class="'.$class.'" name="', esc_attr($field['id']), '" id="', esc_attr($field['id']), '" value="' . esc_attr($text_value) . '" size="30" />';
					break;
				case 'timepicker':
					$text_value = $meta ? $meta : $field['std'];
					echo '<select name="'.esc_attr($field['id']).'" id="'.esc_attr($field['id']).'">';
					$start = strtotime('12am');
					for ($i = 0; $i < (24 * 4); $i++) {
					    
					    $tod = $start + ($i * 15 * 60);
					    $display = date('h:i A', $tod);

					    if (substr($display, 0, 2) == '00') {
					        	$display = '12' . substr($display, 2);
					    }
					    if ($meta==$display) {
					    	$timeselected='selected="selected"';
					    } else {
					    	$timeselected="";
					    }

					    $display_user_time = $display;
					    $event_time_format = kreativa_get_option_data('events_time_format');
					    if ($event_time_format == "24hr") {
					    	$display_user_time = date('H:i', $tod);
						}
					    echo '<option value="' . esc_attr($display) . '" '.$timeselected.'>' . esc_attr($display_user_time) . '</option>';
					} 
					echo '</select>';

					break;

				case 'country':
					$text_value = $meta ? $meta : $field['std'];
					echo '<select name="'.esc_attr($field['id']).'" id="'.esc_attr($field['id']).'">';
					echo kreativa_country_list("select",$meta);
					echo '</select>';

					break;
				case 'datepicker':
					$text_value = $meta ? $meta : $field['std'];
					echo '<input type="text" class="'.$class.' datepicker" data-enable-time="true" name="', esc_attr($field['id']), '" id="', esc_attr($field['id']), '" value="' . esc_attr($text_value) . '" size="30" />';
					break;
				case 'textarea':
					$textarea_value = $meta ? $meta : $field['std'];
					echo '<textarea name="', esc_attr($field['id']), '" id="', esc_attr($field['id']), '" cols="60" rows="4" >' . esc_textarea($textarea_value) . '</textarea>';
					break;
				case 'fontselector':
					$class='';
					if (isset($field['target'])) {
						$field['options'] = kreativa_get_select_target_options($field['target']);
					}
					
					echo '<div class="selectbox-type-selector"><select class="chosen-select-metabox metabox_google_font_select" name="', $field['id'], '" id="', $field['id'], '">';
					foreach ($field['options'] as $key => $option) {
						echo '<option  data-font="' . esc_attr( $option ) . '" value="'. esc_attr($key) .'"', $meta == $key ? ' selected="selected"' : '', '>', esc_attr($option) , '</option>';
					}
					echo '</select></div>';

					$googlefont_text = 'abcdefghijklmnopqrstuvwxyz ABCDEFGHIJKLMNOPQRSTUVWXYZ 0123456789';

					$hide = " hide";
					if ($key != "none" && $key != "") {
						$hide = "";
					} 

					echo '<p class="'.esc_attr( $field['id'].'_metabox_googlefont_previewer metabox_google_font_preview'.$hide ).'">'. esc_html( $googlefont_text ) .'</p>';
					
					break;
				case 'select':
					$class='';
					if (isset($field['target'])) {
						$field['options'] = kreativa_get_select_target_options($field['target']);
					}
					echo '<div class="selectbox-type-selector"><select class="chosen-select-metabox" name="', $field['id'], '" id="', $field['id'], '">';
					foreach ($field['options'] as $key => $option) {
						if ($key=='0') { $key = 'All the items'; }
						echo '<option value="'. esc_attr($key) .'"', $meta == $key ? ' selected="selected"' : '', '>', esc_attr($option) , '</option>';
					}
					echo '</select></div>';

					if ( isSet( $field['target'] ) && isSet( $meta ) ) {
						if ($field['target']=="client_names") {
							if ( get_post_type($meta) == 'mtheme_clients' ) {
								if( kreativa_has_password($meta) ){
									echo '<div class="metabox-notice metabox-notice-ok">';
									echo esc_html__('Client selected has password protection.','kreativa');
									echo '<br/><strong>';
									echo esc_html__('Gallery password protected.','kreativa');
									echo '</strong></div>';
								} else {
									echo '<div class="metabox-notice metabox-notice-no-pass">';
									echo esc_html__('Client selected does not have password protection.','kreativa');
									echo '<br/>';
									echo esc_html__('The gallery will be available for everyone.','kreativa');
									echo '<br/><br/>';
									echo esc_html__('Add a password to the Client page to protect the gallery.','kreativa');
									echo '</div>';
								}
							}
						}
					}
					
					break;

				// Basic text input
				case 'range':
					$output="";
					if ( isset($field['unit']) ) {
						echo '<div class="ranger-min-max-wrap"><span class="ranger-min-value">'.$field['min'].'</span>';
						echo '<span class="ranger-max-value">'.$field['max'].'</span></div>';
						echo '<div id="' . esc_attr( $field['id'] ) . '_slider"></div>';
						echo '<div class="ranger-bar">';
					}
					if ( !isSet($meta) || $meta=="" ) { 
						if ($meta==0) {$meta="0";} else {$meta=$field['std'];}
					}
					$meta=floatval($meta);
					echo '<input id="' . esc_attr( $field['id'] ) . '" class="of-input" name="' . esc_attr( $field['id'] ) . '" type="text" value="'.esc_attr($meta).'"';
					
					if ( isset($field['unit']) ) {
						if (isset($field['min'])) {
							echo ' min="' . $field['min'];
						}
						if (isset($field['max'])) {
							echo '" max="' . $field['max'];
						}
						if (isset($field['step'])) {
							echo '" step="' . $field['step'];
						}
						echo '" />';
						if (isset($field['unit'])) {
							echo '<span>' . $field['unit'] . '</span>';
						}
						echo '</div>';
					} else {
						echo ' />';
					}
					
				break;

				case 'radio':
					foreach ($field['options'] as $option) {
						echo '<input type="radio" name="', esc_attr($field['id']), '" value="', esc_attr($option), '"', $meta == $option ? ' checked="checked"' : '', ' />', $option;
					}
					break;

				case 'image':
					$output="";
					foreach ($field['options'] as $key => $option) {
						$selected = '';
						$checked = '';
						if ( $meta == '' ) {
							if ( isSet($field['std']) ) $meta=$field['std'];
							}
						if ( $meta != '' ) {
							if ( $meta == $key ) {
								$selected = ' of-radio-img-selected';
								$checked = ' checked="checked"';
							}
						}
						echo '<input type="radio" id="' . esc_attr( $field['id'] .'_'. $key) . '" class="of-radio-img-radio" value="' . esc_attr( $key ) . '" name="' . esc_attr( $field['id']) . '" '. esc_attr($checked) .' />';
						echo '<div class="of-radio-img-label">' . esc_html( $key ) . '</div>';
						echo '<img data-holder="'.esc_attr($field['id'] .'_'. $key).'" data-value="' . esc_attr( $key ) . '" src="' . esc_url( $option ) . '" alt="' . esc_attr($option) .'" class="metabox-image-radio-selector of-radio-img-img' . esc_attr($selected) .'" />';
					}
					break;

				case 'checkbox':
					echo '<input type="checkbox" name="', esc_attr($field['id']), '" id="', esc_attr($field['id']), '"', $meta ? ' checked="checked"' : '', ' />';
					break;
			}
		}

		$notice_class = '';
		if ( isSet($field['type']) && $field['type']=="notice") {
			$notice_class=" big-notice";
		}
		if ( isSet($field['desc']) ) echo '<div class="metabox-description'.$notice_class.'">', $field['desc'], '</div>';
		echo '</div>';
	}

	if ( isSet($div_column_open) && $div_column_open )  {
		echo '</div>';
	}
	
	echo '</div>';
}


/**
 * Save image ids
 */
function kreativa_save_images() {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		return;
	
	if ( !isset($_POST['ids']) || !isset($_POST['nonce']) || !wp_verify_nonce( $_POST['nonce'], 'kreativa-nonce-metagallery' ) )
		return;
	
	if ( !current_user_can( 'edit_posts' ) ) return;
 
	$ids = strip_tags(rtrim($_POST['ids'], ','));
	update_post_meta($_POST['post_id'], '_mtheme_image_ids', $ids);

	// update thumbs
	$thumbs = explode(',', $ids);
	$thumbs_output = '';
	foreach( $thumbs as $thumb ) {
		echo '<li>' . wp_get_attachment_image( $thumb, 'thumbnail' ) . '</li>';
	}

	die();
}
add_action('wp_ajax_kreativa_save_images', 'kreativa_save_images');
/**
 * Save image ids
 */
function multo_gallery_save_images() {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		return;
	
	if ( !isset($_POST['ids']) || !isset($_POST['nonce']) || !wp_verify_nonce( $_POST['nonce'], 'kreativa-nonce-metagallery' ) )
		return;
	
	if ( !current_user_can( 'edit_posts' ) ) return;
 
	$ids = strip_tags(rtrim($_POST['ids'], ','));
	$galleryid = $_POST['gallerysetid'];
	update_post_meta($_POST['post_id'], $galleryid, $ids);

	$getmeta = get_post_meta( $_POST['post_id'], $galleryid , true );

	// update thumbs
	$thumbs = explode(',', $ids);
	$thumbs_output = '';
	foreach( $thumbs as $thumb ) {
		echo '<li>' . wp_get_attachment_image( $thumb, 'thumbnail' ) . '</li>';
	}

	die();
}
add_action('wp_ajax_multo_gallery_save_images', 'multo_gallery_save_images');
// Save data from meta box
add_action('save_post', 'kreativa_checkdata');
function kreativa_checkdata($post_id) {

	// verify nonce
	if ( isset($_POST['mtheme_meta_box_nonce']) ) {
		if (!wp_verify_nonce($_POST['mtheme_meta_box_nonce'], 'metabox-nonce')) {
			return $post_id;
		}
	}

	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}
	// check permissions
	if ( isset($_POST['post_type']) ) {
		if ('page' == $_POST['post_type']) {
			if (!current_user_can('edit_page', $post_id)) {
				return $post_id;
			}
		} elseif (!current_user_can('edit_post', $post_id)) {
			return $post_id;
		}
	}

	if ( isset($_POST['mtheme_meta_box_nonce']) ) {
		$mtheme_post_type_got =  get_post_type($post_id);

		switch ($mtheme_post_type_got) {
			case 'page':
				$mtheme_common_page_box = kreativa_page_metadata();
				kreativa_savedata($mtheme_common_page_box,$post_id);
				break;
			case 'mtheme_clients':
				$mtheme_client_box = kreativa_client_metadata();
				kreativa_savedata($mtheme_client_box,$post_id);
				break;
			case 'mtheme_events':
				$mtheme_events_box = kreativa_events_metadata();
				kreativa_savedata($mtheme_events_box,$post_id);
				break;
			case 'mtheme_portfolio':
				$mtheme_portfolio_box = kreativa_portfolio_metadata();
				kreativa_savedata($mtheme_portfolio_box,$post_id);
				break;
			case 'mtheme_featured':
				$mtheme_fullscreen_box = kreativa_fullscreen_metadata();
				kreativa_savedata($mtheme_fullscreen_box,$post_id);
				break;
			case 'mtheme_photostory':
				$mtheme_photostory_box = kreativa_photostory_metadata();
				kreativa_savedata($mtheme_photostory_box,$post_id);
				break;
			case 'product':
				$mtheme_woocommerce_box = kreativa_woocommerce_metadata();
				kreativa_savedata($mtheme_woocommerce_box,$post_id);
				break;
			case 'mtheme_proofing':
				$mtheme_proofing_box = kreativa_proofing_metadata();
				kreativa_savedata($mtheme_proofing_box,$post_id);
				break;
			case 'post':
				$mtheme_post_metapack = kreativa_post_metadata();

				kreativa_savedata($mtheme_post_metapack['video'],$post_id);
				kreativa_savedata($mtheme_post_metapack['link'],$post_id);
				kreativa_savedata($mtheme_post_metapack['image'],$post_id);
				kreativa_savedata($mtheme_post_metapack['quote'],$post_id);
				kreativa_savedata($mtheme_post_metapack['audio'],$post_id);
				kreativa_savedata($mtheme_post_metapack['main'],$post_id);
				break;
			
			default:
				# code...
				break;
		}
	}
	
}

	function kreativa_savedata($mtheme_metaboxdata,$post_id) {
		if (is_array($mtheme_metaboxdata['fields'])) {
			foreach ($mtheme_metaboxdata['fields'] as $field) {
				$old = get_post_meta($post_id, $field['id'], true);
				$new = '';
				if ( isset($_POST[$field['id']]) ) {
					$new = $_POST[$field['id']];
				}
				
				if ( isSet($new) ) {
					if ($new && $new != $old) {
						update_post_meta($post_id, $field['id'], $new );
					} elseif ($new=="0") {
						update_post_meta($post_id, $field['id'], $new );
					} elseif ('' == $new && $old) {
						delete_post_meta($post_id, $field['id'], $old );
					}
				}			
			}
		}
	}
?>