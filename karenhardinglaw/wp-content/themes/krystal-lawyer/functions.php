<?php 


/**
 *  Defining Constants
 */

// Core Constants
define('KRYSTAL_LAWYER_REQUIRED_PHP_VERSION', '5.6' );
define('KRYSTAL_LAWYER_THEME_AUTH','https://www.spiraclethemes.com/');
define('KRYSTAL_LAWYER_THEME_URL','https://www.spiraclethemes.com/krystal-lawyer-free-wordpress-theme/');
define('KRYSTAL_LAWYER_THEME_PRO_URL','https://www.spiraclethemes.com/krystal-premium-wordpress-theme/');
define('KRYSTAL_LAWYER_THEME_DOC_URL','https://www.spiraclethemes.com/krystal-documentation/');
define('KRYSTAL_LAWYER_THEME_VIDEOS_URL','https://www.spiraclethemes.com/krystal-video-tutorials/');
define('KRYSTAL_LAWYER_THEME_SUPPORT_URL','https://wordpress.org/support/theme/krystal-lawyer/');
define('KRYSTAL_LAWYER_THEME_RATINGS_URL','https://wordpress.org/support/theme/krystal-lawyer/reviews/');
define('KRYSTAL_LAWYER_THEME_CHANGELOGS_URL','https://themes.trac.wordpress.org/log/krystal-lawyer/');
define('KRYSTAL_LAWYER_THEME_CONTACT_URL','https://www.spiraclethemes.com/contact-us/');


/**
* Check for minimum PHP version requirement 
*
*/
function krystal_lawyer_check_theme_setup( $oldtheme_name, $oldtheme ){
  // Compare versions.
  if ( version_compare(phpversion(), KRYSTAL_LAWYER_REQUIRED_PHP_VERSION, '<') ) :
  // Theme not activated info message.
  add_action( 'admin_notices', 'krystal_lawyer_php_admin_notice' );
  function krystal_lawyer_php_admin_notice() {
    ?>
      <div class="update-nag">
          <?php esc_html_e( 'You need to update your PHP version to a minimum of 5.6 to run Krystal Lawyer WordPress Theme.', 'krystal-lawyer' ); ?> <br />
          <?php esc_html_e( 'Actual version is:', 'krystal-lawyer' ) ?> <strong><?php echo phpversion(); ?></strong>, <?php esc_html_e( 'required is', 'krystal-lawyer' ) ?> <strong><?php echo KRYSTAL_LAWYER_REQUIRED_PHP_VERSION; ?></strong>
      </div>
    <?php
  }
  // Switch back to previous theme.
  switch_theme( $oldtheme->stylesheet );
    return false;
  endif;
}
add_action( 'after_switch_theme', 'krystal_lawyer_check_theme_setup', 10, 2  );


/**
* Krystal Lawyer theme functions
*/	

add_action( 'after_setup_theme', 'krystal_lawyer_theme_setup', 99 );
function krystal_lawyer_theme_setup(){
    remove_action( 'admin_menu', 'krystal_add_menu' );
	  add_action('wp_enqueue_scripts', 'krystal_lawyer_load_scripts');
}

function krystal_lawyer_load_scripts() {	
	  wp_register_style( 'krystal-lawyer-load-style' , trailingslashit(get_stylesheet_directory_uri()).'style.css', false, '1.1.0', 'screen');
	  wp_enqueue_style( 'krystal-lawyer-load-style' );
    wp_enqueue_style( 'krystal-lawyer-woocommerce-css' , trailingslashit(get_stylesheet_directory_uri()).'css/woocommerce-style.css', false, '1.1.0', 'screen');
}


/** 
* WooCommerce Support
*/

function krystal_lawyer_wc_support() {
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );

    // register footer social menu
    register_nav_menus( array(
      'footer-social' => esc_html__( 'Footer Social Menu', 'krystal-lawyer' ),
    ) );
}
add_action( 'after_setup_theme', 'krystal_lawyer_wc_support' );


/** 
* Register Widget Area
*/

function krystal_lawyer_widgets_init() {
    register_sidebar( array(
        'name'          => esc_html__( 'Woocommerce Sidebar', 'krystal-lawyer' ),
        'id'            => 'woosidebar',
        'description'   => esc_html__( 'Add widgets here.', 'krystal-lawyer' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h5 class="widget-title">',
        'after_title'   => '</h5>',
    ) ); 

}
add_action( 'widgets_init', 'krystal_lawyer_widgets_init' );


/**
 * Custom product search form
*/
 
if ( !function_exists('krystal_lawyer_product_search_form') ) :
function krystal_lawyer_product_search_form( $form ) {
    $form = '<form role="search" method="get" id="searchform" class="searchform" action="' . esc_url(home_url( '/' )) . '" >
    <div class="search">
        <input type="text" value="' . get_search_query() . '" class="product-search" name="s" id="s" placeholder="'. esc_attr__('Search products.','krystal-lawyer'). '">
        <label for="searchsubmit" class="search-icon"><i class="fa fa-search"></i></label>
        <input type="hidden" name="post_type" value="product" />
        <input type="submit" id="searchsubmit" value="'. esc_attr__( 'Search','krystal-lawyer' ) .'" />
      </div>
    </form>';
    return $form;
}
endif;
add_filter( 'get_product_search_form', 'krystal_lawyer_product_search_form', 100 );


/**
 * Display dynamic CSS.
 */

function krystal_lawyer_dynamic_css_wrap() {
    require_once( get_stylesheet_directory(). '/css/dynamic.css.php' );
    ?>
       <style type="text/css" id="krystal-lawyer-theme-dynamic-style">
          <?php echo krystal_lawyer_dynamic_css_stylesheet(); ?>
       </style>
    <?php 
}
add_action( 'wp_head', 'krystal_lawyer_dynamic_css_wrap' );


/**
* Admin scripts
*/

if ( ! function_exists( 'krystal_lawyer_admin_scripts' ) ) :
function krystal_lawyer_admin_scripts($hook) {
    if('appearance_page_krystal-lawyer-theme-info' != $hook)
       return;  
    wp_enqueue_style( 'krystal-lawyer-info-css', trailingslashit(get_stylesheet_directory_uri()).'css/krystal-lawyer-theme-info.css', false );  
}
endif;
add_action( 'admin_enqueue_scripts', 'krystal_lawyer_admin_scripts' );


/** 
* Plugins Required
*/
add_action( 'tgmpa_register', 'krystal_lawyer_register_required_plugins' );
function krystal_lawyer_register_required_plugins() {
    $plugins = array(      
      array(
          'name'               => 'WooCommerce',
          'slug'               => 'woocommerce',
          'source'             => '',
          'required'           => false,          
          'force_activation'   => false,
      ) 
    );

    $config = array(
            'id'           => 'krystal-lawyer',
            'default_path' => '',
            'menu'         => 'tgmpa-install-plugins',
            'has_notices'  => true,
            'dismissable'  => true,
            'dismiss_msg'  => '',
            'is_automatic' => false,
            'message'      => '',
            'strings'      => array()
    );
  tgmpa( $plugins, $config );
}

//include info
require_once( get_stylesheet_directory(). '/inc/theme-info.php' );

//include customizer
require_once( get_stylesheet_directory(). '/inc/customizer/customizer.php' );

//include WooCommerce functions
require_once( get_stylesheet_directory(). '/inc/woocommerce-functions.php' );

//include footer social widget
require_once( get_stylesheet_directory(). '/inc/widgets/footer-social-widget.php' );

?>