<?php
/*
Name: Options Framework
URI: http://www.wptheming.com
Description: A framework for building theme options.
Version: 1.0
Author: Devin Price
Author URI: http://www.wptheming.com
License: GPLv2
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

/* Basic plugin definitions */

if ( !function_exists( 'add_action' ) ) {
	exit;
}

/* If the user can't edit theme options, no use running this plugin */

add_action('init', 'kreativa_rolescheck' );

function kreativa_rolescheck () {
	if ( current_user_can( 'edit_theme_options' ) ) {
		// If the user can edit theme options, let the fun begin!
		add_action( 'admin_menu', 'kreativa_add_page');
		add_action( 'admin_init', 'kreativa_init' );
	}
}
/* 
 * Creates the settings in the database by looping through the array
 * we supplied in options.php.  This is a neat way to do it since
 * we won't have to save settings for headers, descriptions, or arguments.
 *
 * Read more about the Settings API in the WordPress codex:
 * http://codex.wordpress.org/Settings_API
 *
 */

function kreativa_save_options() {
	$countarray=0;
	$export_options=array();

	$optionsframework_settings = get_option('optionsframework');
	// Gets the unique option id
	$option_name = $optionsframework_settings['id'];

	$options = kreativa_options();

	foreach($options as $value) {

		$save_value= '';
		$hold_save_value= '';
	
		if ( isset($value['id'] ) && ! empty($value['id']) ) {
			
			if (isset($_POST[$option_name][$value['id']])) {
			
				$hold_save_value = $_POST[$option_name][ $value['id']];
				
				if ( $value['type']=="text" ) {
					$hold_save_value = stripslashes_deep ( $hold_save_value );
				}
				
				if ( !isset ($option) ) $option="";
				
				if ($value['type'] == "dragdrop_sorter") {
					$sort_array = $hold_save_value;
					$save_value=array();
					foreach($sort_array as $sortkey => $sortstate) {
						$save_value[] = $sortkey;
					}

				} else {
					$save_value = apply_filters( 'of_sanitize_' . $value['type'], $hold_save_value, $option );
				}
			
			}
			
			if ($value['type']=="checkbox") {
				if ( isset( $_POST[$option_name][ $value['id'] ] ) ) {
					$save_value = '1';
				} else {
					$save_value = false;
				}
			}
			// Skip the export pack and import pack values. Store everything else.
			if ( $value['id']!="exportpack" && $value['id']!="importpack") {

				update_option( 'mtheme_' . $value['id'], $save_value  );
				
				if ($value['type'] == "dragdrop_sorter") {
					$export_options[] =  array($value['id'] => $save_value);

				} else {
					$export_options[] =  array($value['id'] => $save_value);
				}
			}
		}
		
	}

	//echo "Alright";

	$exportpack = serialize($export_options);
	update_option( 'mtheme_exportpack', $exportpack  );

	echo serialize($export_options);

	die();
}
add_action('wp_ajax_mtheme_save_options','kreativa_save_options');

function kreativa_insta_reset() {

	$token = kreativa_get_option_data('insta_token');
	delete_transient( 'instagram-media-mtheme-'.sanitize_title_with_dashes( $token ) );
	die('insta cache renewed!');
}
add_action('wp_ajax_mtheme_insta_reset','kreativa_insta_reset');

function kreativa_init() {

	// Include the required files
	require_once ( get_template_directory() . '/framework/options/admin/options-interface.php');
	require_once ( get_template_directory() . '/framework/options/admin/options-medialibrary-uploader.php');
	require_once( get_template_directory() . '/framework/options/' . 'google-fonts.php');
	require_once ( get_template_directory() . '/framework/options/' . 'options-data.php');
	
	$kreativa_settings = get_option('optionsframework' );
	
	// Updates the unique option id in the database if it has changed
	kreativa_option_name();
	
	// Gets the unique id, returning a default if it isn't defined
	if ( isset($kreativa_settings['id']) ) {
		$option_name = $kreativa_settings['id'];
	}
	else {
		$option_name = 'optionsframework';
	}
	
	
	//Check if theme has data
	$theme_data_status = get_option( $option_name . '_init');
	
	if ($theme_data_status<>"") {
		//OK
		} else {
		kreativa_setdefaults();
		update_option( $option_name . '_init', '1'  );
	}
	if ( isSet($_POST['mtheme_options_nonce']) ) {
	if ( empty($_POST) || !wp_verify_nonce($_POST['mtheme_options_nonce'], 'importing-theme-options') ) {
		// Don't pass me by
		print 'Sorry, your nonce did not verify.';
	} else {

		if (isset( $_POST['import'] )) {
			$options = kreativa_options();

			// IMPORT user entered export data pack.
			$importpack=array();
			$importpack = $_POST[$option_name]['importpack'];

			if ( $importpack<>"" && is_serialized($importpack) ) {

				add_settings_error( 'options-framework', 'restore_defaults', esc_html__( 'Options Imported!', 'kreativa' ), 'updated fade' );

				$update_values = false;
				$import_value = "";
				$importpack =  stripslashes_deep($importpack);
				$imported_values = array();
				$imported_values = unserialize($importpack);
				//var_export($imported_values);
				foreach($imported_values as $key => $value) {

					foreach($value as $store_key => $store_value) {

						update_option('mtheme_' . $store_key, $store_value );

						if ( is_array($store_value) && $store_key=="header_section_order" ) {

							foreach($store_value as $home_key => $home_value) {

							}
						}
					}
				}


			    update_option( 'mtheme_exportpack', $importpack );
			} elseif ( $importpack<>"" && !is_serialized($importpack) ) {
				add_settings_error( 'options-framework', 'restore_defaults', esc_html__( 'Invalid Import', 'kreativa' ), 'error fade' );
			} else {
				add_settings_error( 'options-framework', 'restore_defaults', esc_html__( 'Saved Settings!', 'kreativa' ), 'updated fade' );
			}
		}



		if (isset( $_POST['update'] )) {
			$clean = array();
			$options = kreativa_options();
			$exportpack="array(";
			$update_values = true;

		if ($update_values) {

			$countarray=0;
			$export_options=array();
			foreach($options as $value) {
			
				if ( isset($value['id'] ) && ! empty($value['id']) ) {
					
					if (isset($_POST[$option_name][$value['id']])) {
					
						$hold_save_value = $_POST[$option_name][ $value['id']];
						
						if ( $value['type']=="text" ) {
							$hold_save_value = stripslashes_deep ( $hold_save_value );
						}
						
						if ( !isset ($option) ) $option="";
						
						if ($value['type'] == "dragdrop_sorter") {
							$sort_array = $hold_save_value;
							$save_value=array();
							foreach($sort_array as $sortkey => $sortstate) {
								$save_value[] = $sortkey;
							}

						} else {
							$save_value = apply_filters( 'of_sanitize_' . $value['type'], $hold_save_value, $option );
						}
					
					}
					
					if ($value['type']=="checkbox") {
						if ( isset( $_POST[$option_name][ $value['id'] ] ) ) {
							$save_value = '1';
						} else {
							$save_value = false;
						}
					}
					// Skip the export pack and import pack values. Store everything else.
					if ( $value['id']!="exportpack" && $value['id']!="importpack") {

						update_option( 'mtheme_' . $value['id'], $save_value  );
						
						if ($value['type'] == "dragdrop_sorter") {
							$export_options[] =  array($value['id'] => $save_value);

						} else {
							$export_options[] =  array($value['id'] => $save_value);
						}
					}
				}
				
			}

			$exportpack = serialize($export_options);
			update_option( 'mtheme_exportpack', $exportpack  );
		}

		}
		
		if ( isset( $_POST['reset'] ) ) {
			kreativa_setdefaults();
		}
	} // End of Nonce Check
	}
	
}

/* 
 * Adds default options to the database if they aren't already present.
 * May update this later to load only on plugin activation, or theme
 * activation since most people won't be editing the options.php
 * on a regular basis.
 *
 * http://codex.wordpress.org/Function_Reference/add_option
 *
 */
 
 
function kreativa_setdefaults() {
	add_settings_error( 'options-framework', 'restore_defaults', esc_html__( 'Default options restored.', 'kreativa' ), 'updated fade' );
	$output = array();
	$options = kreativa_options();
	foreach($options as $value) {
		$default_value="";
		if ( isset($value['id'] ) && ! empty($value['id']) ) {
			
			if (isset( $value['std'] )) {
				$default_value=$value['std'];
			} else {
				if ($value['type']=="checkbox") {
					$default_value = '0';
				} else {
					$default_value = false;
				}
			}
			if ($value['type'] == "dragdrop_sorter") {
				$sort_array = $default_value;
				foreach($sort_array as $sortkey => $sortstate) {
					$default_value[] = $sortkey;
				}

			}
		// Save the options
			delete_option('mtheme_' . $value['id']);
			update_option( 'mtheme_' . $value['id'], $default_value  );

		}
	}
}

/* Add a subpage called "Theme Options" to the appearance menu. */

if ( !function_exists( 'kreativa_add_page' ) ) {
	function kreativa_add_page() {

		$of_page = add_theme_page(
			'Theme Options', 
			'Theme Options', 
			'edit_theme_options', 
			'options-framework',
			'kreativa_page',
			get_template_directory_uri() . '/framework/options/admin/images/options-settings16.png',
			61
			);
	}
}
/* 
 * Builds out the options panel.
 *
 * If we were using the Settings API as it was likely intended we would use
 * do_settings_sections here.  But as we don't want the settings wrapped in a table,
 * we'll call our own custom optionsframework_fields.  See options-interface.php
 * for specifics on how each individual field is generated.
 *
 * Nonces are provided using the settings_fields()
 *
 */

if ( !function_exists( 'kreativa_page' ) ) {
function kreativa_page() {
	?>
		<div class="themeoptions-loading">
			<i class="fa fa-cog fa-spin"></i>
			<?php echo esc_html__('Theme Options Loading','kreativa'); ?>
		</div>
    <div class="theme-options-outer">
    <div class="options_wrap theme-options-clearfix">
	<div id='saveMessage' class='successModal'><?php echo esc_html__('Settings Saved!','kreativa'); ?></div>
	<div id='insta-reset-Message' class='successModal'><?php echo esc_html__('Instagram Cache Reset!','kreativa'); ?></div>
	<div id='insta-error-Message' class='errorModal'><?php echo esc_html__('Instagram Cache Reset Error!','kreativa'); ?></div>
	<div id='errorMessage' class='errorModal'><?php echo esc_html__('Error Saving!','kreativa'); ?></div>
	<form method="post" id="mtheme-admin-options-form"> 
		<?php /* Top buttons */ ?>
		<div id="optionsframework-submit">
			<div class="optionsframework-submit-inner">
				<span>
				<div class="options-title"><span class="mtheme-admin-icon dashicons dashicons-admin-generic"></span><?php echo esc_html__('Theme Options','kreativa'); ?></div>

				</span>
				<div id="submit-options-ajax" class="button-primary topbutton-right"><?php echo esc_html__('Save all Options','kreativa'); ?></div>				
	            <div class="clear"></div>
				<?php settings_errors(); ?>
			</div>
		</div>
	    <div class="nav-tab-wrapper">
	        <?php echo kreativa_tabs(); ?>
	    </div>
	    
	    <div class="metabox-holder">

	    <div id="optionsframework" class="postbox">
			
			<?php settings_fields('optionsframework'); ?>

			<?php echo kreativa_fields(); /* Settings */ ?>
	        
	        <?php /* Bottom buttons */ ?>
	        <div id="optionsframework-reset">
	        	<?php echo '<input type="hidden" name="mtheme_options_nonce" value="', wp_create_nonce('importing-theme-options'), '" />'; ?>

	            <input type="submit" class="reset-button button-secondary" name="reset" value="<?php esc_attr_e( 'Restore Defaults','kreativa' ); ?>" onclick="return confirm( '<?php print esc_js( esc_html__( 'Click OK to reset. Any theme settings will be lost!','kreativa' ) ); ?>' );" />
	            <div class="clear"></div>
			</div>
		
		</div> <!-- / #container -->
		</div>
	</form>
</div>
</div> <!-- / .wrap -->

<?php
}
}

/** 
 * Validate Options.
 *
 * This runs after the submit/reset button has been clicked and
 * validates the inputs.
 *
 * @uses $_POST['reset']
 * @uses $_POST['update']
 */
function kreativa_validate( $input ) {

	/*
	 * Restore Defaults.
	 *
	 * In the event that the user clicked the "Restore Defaults"
	 * button, the options defined in the theme's options.php
	 * file will be added to the option for the active theme.
	 */
	 
	if ( isset( $_POST['reset'] ) ) {
		add_settings_error( 'options-framework', 'restore_defaults', esc_html__( 'Default options restored.', 'kreativa' ), 'updated fade' );
		return kreativa_get_default_values();
	}

	/*
	 * Udpdate Settings.
	 */
	
	if ( isset( $_POST['update'] ) ) {
		$clean = array();
		$options = kreativa_options();
		foreach ( $options as $option ) {

			if ( ! isset( $option['id'] ) ) {
				continue;
			}

			if ( ! isset( $option['type'] ) ) {
				continue;
			}

			$id = preg_replace( '/[^a-zA-Z0-9._\-]/', '', strtolower( $option['id'] ) );

			// Set checkbox to false if it wasn't sent in the $_POST
			if ( 'checkbox' == $option['type'] && ! isset( $input[$id] ) ) {
				$input[$id] = '0';
			}

			// Set each item in the multicheck to false if it wasn't sent in the $_POST
			if ( 'multicheck' == $option['type'] && ! isset( $input[$id] ) ) {
				foreach ( $option['options'] as $key => $value ) {
					$input[$id][$key] = '0';
				}
			}

			// For a value to be submitted to database it must pass through a sanitization filter
			if ( has_filter( 'of_sanitize_' . $option['type'] ) ) {
				$clean[$id] = apply_filters( 'of_sanitize_' . $option['type'], $input[$id], $option );
			}
		}

		add_settings_error( 'options-framework', 'save_options', esc_html__( 'Options saved.', 'kreativa' ), 'updated fade' );
		return $clean;
	}

	/*
	 * Request Not Recognized.
	 */
	
	return kreativa_get_default_values();
}

/**
 * Format Configuration Array.
 *
 * Get an array of all default values as set in
 * options.php. The 'id','std' and 'type' keys need
 * to be defined in the configuration array. In the
 * event that these keys are not present the option
 * will not be included in this function's output.
 *
 * @return    array     Rey-keyed options configuration array.
 *
 * @access    private
 */
 
function kreativa_get_default_values() {
	$output = array();
	$config = kreativa_options();
	foreach ( (array) $config as $option ) {
		if ( ! isset( $option['id'] ) ) {
			continue;
		}
		if ( ! isset( $option['std'] ) ) {
			continue;
		}
		if ( ! isset( $option['type'] ) ) {
			continue;
		}
		update_option ('mtheme_'.$option['std']);
		if ( has_filter( 'of_sanitize_' . $option['type'] ) ) {
			$output[$option['id']] = apply_filters( 'of_sanitize_' . $option['type'], $option['std'], $option );
		}
	}
	//return $output;
}

/**
 * Add Theme Options menu item to Admin Bar.
 */
 
add_action( 'wp_before_admin_bar_render', 'kreativa_adminbar' );
function kreativa_adminbar() {
	
	global $wp_admin_bar;
	
	$wp_admin_bar->add_menu( array(
		'parent' => 'appearance',
		'id' => 'of_theme_options',
		'title' => esc_html__( 'Theme Options','kreativa' ),
		'href' => admin_url( 'themes.php?page=options-framework' )
  ));
}