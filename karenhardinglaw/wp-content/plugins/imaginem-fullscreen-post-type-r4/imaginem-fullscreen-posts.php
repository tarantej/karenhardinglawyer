<?php
/*
Plugin Name: iMaginem Fullscreen Post Creater r4
Plugin URI: http://www.imaginemthemes.com/plugins/mthemeshortcodes
Description: Imaginem Themes Fullscreen Custom Post Types.
Version: 1.0
Author: iMaginem
Author URI: http://www.imaginemthemes.com
*/

class mtheme_Fullscreen_Posts {

    function __construct() 
    {
		require_once ( plugin_dir_path( __FILE__ ) . 'fullscreen-post-sorter.php');
        add_action('init', array(&$this, 'init'));
        add_action('admin_init', array(&$this, 'admin_init'));
        add_filter("manage_edit-mtheme_featured_columns", array(&$this, 'mtheme_fullscreen_edit_columns'));
		add_action("manage_posts_custom_column",  array(&$this, 'mtheme_fullscreen_custom_columns'));
	}

	/*
	* Portfolio Admin columns
	*/
	function mtheme_fullscreen_custom_columns($column){
	    global $post;
	    $custom = get_post_custom();
		$image_url=wp_get_attachment_thumb_url( get_post_thumbnail_id( $post->ID ) );
		
		$full_image_id = get_post_thumbnail_id(($post->ID), 'thumbnail'); 
		$full_image_url = wp_get_attachment_image_src($full_image_id,'full');  
		$full_image_url = $full_image_url[0];

		$mtheme_shortname = "sceneone";
	    switch ($column)
	    {
	        case "featured_image":
	            if ( isSet($image_url) && $image_url<>"" ) {
	            echo '<a class="thickbox" href="'.$full_image_url.'"><img src="'.$image_url.'" width="40px" height="40px" alt="featured" /></a>';
	            }
	            break;
	        case "fullscreen_type":
	            if ( isset($custom["pagemeta_fullscreen_type"][0]) ) { echo $custom["pagemeta_fullscreen_type"][0]; }
	            break;
	        case "fullscreengallery":
	            echo get_the_term_list($post->ID, 'fullscreengallery', '', ', ','');
	            break;
	    }
	}

	function mtheme_fullscreen_edit_columns($columns){
	    $columns = array(
	        "cb" => "<input type=\"checkbox\" />",
	        "title" => __('Featured Title','mthemelocal'),
	        "fullscreengallery" => __('Categories','mthemelocal'),
	        "fullscreen_type" => __('Fullscreen Type','mthemelocal'),
	        "featured_image" => __('Image','mthemelocal')
	    );
	 
	    return $columns;
	}
	
	/**
	 * Registers TinyMCE rich editor buttons
	 *
	 * @return	void
	 */
	function init()
	{
		
	    $args = array(
	        'label' => __('Fullscreen Pages','mthemelocal'),
	        'description' => __('Manage your Fullscreen posts','mthemelocal'),
	        'singular_label' => __('Fullscreen','mthemelocal'),
	        'public' => true,
	        'show_ui' => true,
	        'capability_type' => 'post',
	        'hierarchical' => false,
	        'menu_position' => 5,
	        'menu_icon' => plugin_dir_url( __FILE__ ) . 'images/fullscreen.png',
	        'rewrite' => array('slug' => 'fullscreen'),//Use a slug like "work" or "project" that shouldnt be same with your page name
	        'supports' => array('title', 'thumbnail','revisions')//Boxes will be shown in the panel
	       );
	 
	    register_post_type( 'mtheme_featured' , $args );
	    register_taxonomy("fullscreengallery", array("mtheme_featured"), array("hierarchical" => true, "label" => "Fullscreen Categories", "singular_label" => "Fullscreen Category", "rewrite" => true));
		 
		/*
		* Hooks for the Portfolio and Featured viewables
		*/
	}
	/**
	 * Enqueue Scripts and Styles
	 *
	 * @return	void
	 */
	function admin_init()
	{
		if( is_admin() ) {
			// Load only if in a Post or Page Manager	
			if ('edit.php' == basename($_SERVER['PHP_SELF'])) {
				//wp_enqueue_script('jquery-ui-sortable');
				wp_enqueue_script('thickbox');
				wp_enqueue_style('thickbox');
				wp_enqueue_style( 'mtheme-fullscreen-sorter-CSS',  plugin_dir_url( __FILE__ ) . '/css/style.css', false, '1.0', 'all' );
				if ( isSet($_GET["page"]) ) {
					if ( $_GET["page"] == "fullscreen-post-sorter.php" ) {
						wp_enqueue_script("post-sorter-JS", plugin_dir_url( __FILE__ ) . "js/post-sorter.js", array( 'jquery' ), "1.0");
					}
				}
			}
		}
	}
    
}
$mtheme_fullscreen_post_type = new mtheme_Fullscreen_Posts();
?>