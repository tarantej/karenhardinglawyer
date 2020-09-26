<?php
/*
Plugin Name: iMaginem Photo Proofing r4
Plugin URI: http://www.imaginemthemes.com/plugins/proofing
Description: Imaginem Photo Proofing.
Version: 1.0
Author: iMaginem
Author URI: http://www.imaginemthemes.com
*/

class mtheme_Proofing_Posts {

    function __construct() 
    {	
    	//require_once ( plugin_dir_path( __FILE__ ) . 'proofing-post-sorter.php');
        add_action('init', array(&$this, 'init'));
        add_action('admin_init', array(&$this, 'admin_init'));

        add_filter("manage_edit-mtheme_proofing_columns", array(&$this, 'mtheme_proofing_edit_columns'));
		add_filter('manage_posts_custom_column' , array(&$this, 'mtheme_proofing_custom_columns'));
	}

	// Kbase lister
	function mtheme_proofing_edit_columns($columns){
	    $new_columns = array(
	        "mproofing_section" => __('Proofing Category','mthemelocal'),
	        "proofing_image" => __('Image','mthemelocal'),
	        "proofing_client" => __('Client','mthemelocal')
	    );
	 
	    return array_merge($columns, $new_columns);
	}
	function mtheme_proofing_custom_columns($columns) {
		global $post;
	    $custom = get_post_custom();
		$image_url=wp_get_attachment_thumb_url( get_post_thumbnail_id( $post->ID ) );
		
		$full_image_id = get_post_thumbnail_id(($post->ID), 'fullimage'); 
		$full_image_url = wp_get_attachment_image_src($full_image_id,'fullimage');  
		$full_image_url = $full_image_url[0];

	    switch ($columns)
	    {
	        case "proofing_image":
				if ( iSset($image_url) && $image_url<>"") {
	            echo '<a class="thickbox" href="'.$full_image_url.'"><img src="'.$image_url.'" width="60px" height="60px" alt="featured" /></a>';
				}
	            break;
	        case "mproofing_section":
	            echo get_the_term_list( get_the_id(), 'proofingsection', '', ', ','' );
	            break;
	        case "proofing_client":
	            if (isSet($custom['pagemeta_client_names'][0])) $client_id=$custom['pagemeta_client_names'][0];
	            if ( isSet($client_id) ) {
	            	$client_data = get_post_custom($client_id);

					$client_image_url=wp_get_attachment_thumb_url( get_post_thumbnail_id( $client_id ) );
					if ( iSset($client_image_url) && $client_image_url<>"" ) {
		            	echo '<a class="thickbox" title="'.get_the_title($client_id).'" href="'.get_the_permalink($client_id).'"><img src="'.$client_image_url.'" width="60px" height="60px" alt="featured" /></a>';
					}
	            }
	            break;
	    } 
	}
	/*
	* kbase Admin columns
	*/
	
	/**
	 * Registers TinyMCE rich editor buttons
	 *
	 * @return	void
	 */
	function init()
	{
		/*
		* Register Featured Post Manager
		*/
		//add_action('init', 'mtheme_featured_register');
		//add_action('init', 'mtheme_kbase_register');//Always use a shortname like "mtheme_" not to see any 404 errors
		/*
		* Register kbase Post Manager
		*/


	    $args = array(
            'labels' => array(
                'name' => 'Photo Proofing',
                'menu_name' => 'Photo Proofing',
                'singular_name' => 'Photo Proofing',
                'all_items' => 'All Proofings',
                'add_new' => 'Add New Proofing'
            ),
	        'singular_label' => __('mproofing','mthemelocal'),
	        'public' => true,
	        'publicly_queryable' => true,
	        'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
	        'capability_type' => 'post',
	        'hierarchical' => false,
	        'has_archive' =>true,
			'menu_position' => 6,
	    	'menu_icon' => plugin_dir_url( __FILE__ ) . 'images/kbase.png',
	        'rewrite' => array('slug' => 'proofing'),//Use a slug like "work" or "project" that shouldnt be same with your page name
	        'supports' => array('title', 'author','excerpt','editor', 'comments', 'thumbnail','revisions')//Boxes will be shown in the panel
	       );
	 
	    register_post_type( 'mtheme_proofing' , $args );
		/*
		* Add Taxonomy for kbase 'Type'
		*/
	    register_taxonomy( 'proofingsection', array( 'mtheme_proofing' ),
	        array(
	            'labels' => array(
	                'name' => 'Proofing Categories',
	                'menu_name' => 'Proofing Categories',
	                'singular_name' => 'Proofing Category',
	                'all_items' => 'Proofing Categories'
	            ),
	            'public' => true,
	            'hierarchical' => true,
	            'show_ui' => true,
	            'rewrite' => array( 'slug' => 'mtheme_proofing-section', 'hierarchical' => true, 'with_front' => false ),
	        )
	    );

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
				//wp_enqueue_style( 'mtheme-proofing-sorter-CSS',  plugin_dir_url( __FILE__ ) . '/css/style.css', false, '1.0', 'all' );
				if ( isSet($_GET["page"]) ) {
					if ( $_GET["page"] == "proofing-post-sorter.php" ) {
						//wp_enqueue_script("post-sorter-JS", plugin_dir_url( __FILE__ ) . "js/post-sorter.js", array( 'jquery' ), "1.0");
					}
				}
			}
		}
	}
    
}
$mtheme_proofing_post_type = new mtheme_Proofing_Posts();
?>
<?php
class mtheme_Clients_Posts {

    function __construct() 
    {
		//require_once ( plugin_dir_path( __FILE__ ) . 'clients-post-sorter.php');
		
        add_action('init', array(&$this, 'init'));
        add_filter("manage_edit-mtheme_clients_columns", array(&$this, 'mtheme_clients_edit_columns'));
		//add_action("manage_posts_custom_column",  array(&$this, 'mtheme_clients_custom_columns'));
		add_action("manage_mtheme_clients_posts_custom_column",  array(&$this, 'mtheme_clients_custom_columns'));
	}

	/*
	* Clients Admin columns
	*/
	function mtheme_clients_custom_columns($column){
		global $post;
		$image_url=wp_get_attachment_thumb_url( get_post_thumbnail_id( $post->ID ) );
		
		$full_image_id = get_post_thumbnail_id(($post->ID), 'thumbnail'); 
		$full_image_url = wp_get_attachment_image_src($full_image_id,'thumbnail');  
		$full_image_url = $full_image_url[0];

		if (!defined('MTHEME')) {
			$mtheme_shortname = "mtheme_p2";
			define('MTHEME', $mtheme_shortname);
		}
	    switch ($column)
	    {
	        case "clients_image":
				if ( isset($image_url) && $image_url<>"") {
	            echo '<a class="thickbox" href="'.esc_url($full_image_url).'"><img src="'.esc_url($image_url).'" width="60px" height="60px" alt="featured" /></a>';
				}
	            break;
	    } 
	}

	function mtheme_clients_edit_columns($columns){

	    $columns = array(
	        "cb" => "<input type=\"checkbox\" />",
	        "title" => __('Client Title','mthemelocal'),
			"clients_image" => __('Image','mthemelocal')
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
		/*
		* Register Featured Post Manager
		*/
		//add_action('init', 'mtheme_featured_register');
		//add_action('init', 'mtheme_clients_register');//Always use a shortname like "mtheme_" not to see any 404 errors
		/*
		* Register Clients Post Manager
		*/
	    $mtheme_clients_slug="clients";
	    if (function_exists('of_get_option')) {
	    	$mtheme_clients_slug = of_get_option('clients_permalink_slug');
		}
	    if ( $mtheme_clients_slug=="" || !isSet($mtheme_clients_slug) ) {
	        $mtheme_clients_slug="clients";
	    }
	    $mtheme_clients_singular_refer = "Clients";
	    if (function_exists('of_get_option')) {
	    	$mtheme_clients_singular_refer = of_get_option('clients_singular_refer');
		}
		if ( $mtheme_clients_singular_refer == '' ) {
			$mtheme_clients_singular_refer= 'Clients';
		}
	    $args = array(
            'labels' => array(
                'name' => 'Clients',
                'menu_name' => 'Clients',
                'singular_name' => 'Clients',
                'all_items' => 'All Clients',
                'add_new' => 'Add New Client'
            ),
	        'singular_label' => __('Client','mthemelocal'),
	        'public' => true,
	        'show_ui' => true,
	        'capability_type' => 'post',
	        'hierarchical' => true,
	        'has_archive' =>false,
			'show_in_menu' => 'edit.php?post_type=mtheme_proofing',
	        'rewrite' => array('slug' => $mtheme_clients_slug),//Use a slug like "work" or "clients" that shouldnt be same with your page name
	        'supports' => array('title','thumbnail','revisions')//Boxes will be shown in the panel
	       );
	 
	    register_post_type( 'mtheme_clients' , $args );
		 
		/*
		* Hooks for the Clients and Featured viewables
		*/
	}
    
}
$mtheme_clients_post_type = new mtheme_Clients_Posts();
?>