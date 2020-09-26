<?php

if ( !function_exists( 'kreativa_init' ) ) {

/*-----------------------------------------------------------------------------------*/
/* Options Framework Theme
/*-----------------------------------------------------------------------------------*/
require_once (get_template_directory() . '/framework/options/admin/options-framework.php');

}
/**
* A unique identifier is defined to store the options in the database and reference them from the theme.
* By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
* If the identifier changes, it'll appear as if the options have been reset.
* 
*/
function kreativa_option_name() {
	$themename="mtheme_responsive";

	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);
}
require_once (get_template_directory() . '/framework/options/options-data.php');
//Homepage Sortable AJAX
function kreativa_save_home_order() {
	$order=$_POST['order'];
	update_option('kreativa_home_order',$order);
	die(1);
}
add_action('wp_ajax_home_sort', 'kreativa_save_home_order');
?>