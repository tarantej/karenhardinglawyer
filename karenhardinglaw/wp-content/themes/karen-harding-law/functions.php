<?php
/**
 * @Functions
 * 
 */
?>
<?php
/*-------------------------------------------------------------------------*/
/* Theme name settings which is shared to some functions */
/*-------------------------------------------------------------------------*/
// Minimum contents area
if ( ! isset( $content_width ) ) { $content_width = 756; }
function kreativa_rewrite_flush() {
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'kreativa_rewrite_flush' );
/*-------------------------------------------------------------------------*/
/* Load Theme Options */
/*-------------------------------------------------------------------------*/
require_once (get_template_directory() . '/framework/options/options-caller.php');
/*-------------------------------------------------------------------------*/
/* Theme Setup */
/*-------------------------------------------------------------------------*/
if ( !function_exists( 'kreativa_setup' ) ) {
	function kreativa_setup() {
		//Add Background Support
		add_theme_support( 'custom-background' );

		// Adds RSS feed links to <head> for posts and comments.
		add_theme_support( 'automatic-feed-links' );
		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );
		// Register Menu
		register_nav_menu( 'main_menu', 'Main Menu' );
		register_nav_menu( 'mobile_menu', 'Mobile Menu' );
		/*-------------------------------------------------------------------------*/
		/* Internationalize for easy localizing */
		/*-------------------------------------------------------------------------*/
		load_theme_textdomain( 'kreativa', get_template_directory() . '/languages' );
		$locale = get_locale();
		$locale_file = get_template_directory() . "/languages/$locale.php";
		if ( is_readable( $locale_file ) ) {
			require_once( $locale_file );
		}
		/*
		 * This theme styles the visual editor to resemble the theme style and column width.
		 */
		add_editor_style( array( 'css/editor-style.css' ) );
		/*-------------------------------------------------------------------------*/
		/* Add Post Thumbnails */
		/*-------------------------------------------------------------------------*/
		add_theme_support( 'post-thumbnails' );
		// This theme supports Post Formats.
		add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio') );
		
		set_post_thumbnail_size( 150, 150, true ); // Default thumbnail size
		add_image_size('kreativa-gridblock-square-big', 750, 750, true ); // Square
		add_image_size('kreativa-gridblock-tiny', 160, 160,true); // Sidebar Thumbnails
		add_image_size('kreativa-gridblock-events', 534, 392,true); // Events
		add_image_size('kreativa-gridblock-large', 746, 548,true); // Portfolio
		add_image_size('kreativa-gridblock-large-portrait', 560,763,true); // Portrait
		add_image_size('kreativa-gridblock-full', 1400, '',true); // Fullwidth
		add_image_size('kreativa-gridblock-full-medium', 800, '', true ); // Medium

		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		if ( kreativa_get_option_data('rightclick_disable') ) {
			add_action( 'kreativa_contextmenu_msg', 'kreativa_contextmenu_msg_enable');
		}
	}
}
add_action( 'after_setup_theme', 'kreativa_setup' );
// Permit eot,woff,ttf,and svg mime types for upload
add_filter('upload_mimes', 'kreativa_permit_font_uploading');
function kreativa_permit_font_uploading( $existing_mimes=array() ) {
	$existing_mimes['eot'] = 'font/eot';
	$existing_mimes['woff'] = 'font/woff';
	$existing_mimes['ttf'] = 'font/ttf';
	$existing_mimes['svg'] = 'font/svg';
	return $existing_mimes;
}
/*-------------------------------------------------------------------------*/
/* Load Framework sections
/*-------------------------------------------------------------------------*/
require_once (get_template_directory() . '/framework/functions/theme-functions.php');
// Under Construction and Coming Soon
add_action( 'template_redirect', 'kreativa_underconstruction' );
function kreativa_underconstruction() {
	$site_in_maintenance = kreativa_maintenance_check();
	if ( $site_in_maintenance ) {
		get_template_part( 'site','maintenance' );
		die();
	}
}
function kreativa_get_max_sidebars() {
	$max_sidebars = 50;
	return $max_sidebars;
}
add_action('kreativa_display_portfolio_single_navigation','kreativa_display_portfolio_single_navigation_action');
function kreativa_display_portfolio_single_navigation_action() {
	if (is_singular('mtheme_portfolio') || is_singular('mtheme_events')) {

		if ( is_singular('mtheme_portfolio') ) {
			$mtheme_post_archive_link = get_post_type_archive_link( 'mtheme_portfolio' );
			$theme_options_mtheme_post_arhive_link = kreativa_get_option_data('portfolio_archive_page');
			$portfolio_nav = kreativa_get_custom_post_nav();
		}
		if ( is_singular('mtheme_events') ) {
			$mtheme_post_archive_link = get_post_type_archive_link( 'mtheme_events' );
			$theme_options_mtheme_post_arhive_link = kreativa_get_option_data('events_archive_page');
			$portfolio_nav = kreativa_get_custom_post_nav($custom_type="mtheme_events");
		}
		if ($theme_options_mtheme_post_arhive_link!=0) {
			$mtheme_post_archive_link = get_page_link($theme_options_mtheme_post_arhive_link);
		}
		if (isSet($portfolio_nav['prev'])) {
			$previous_portfolio = $portfolio_nav['prev'];
		}
		if (isSet($portfolio_nav['next'])) {
			$next_portfolio = $portfolio_nav['next'];
		}
?>
	
	<div class="portfolio-nav-wrap">
		<nav>
			<div class="portfolio-nav">
				<span class="portfolio-nav-item portfolio-prev">
				<?php
				if (isSet($portfolio_nav['prev'])) {
				?>
					<a href="<?php echo esc_url( get_permalink( $previous_portfolio ) ); ?>"><i class="feather-icon-rewind"></i></a>
				<?php
				} else {
				?>
					<span><i class="feather-icon-rewind"></i></span>
				<?php
				}
				?>
				</span>
				<span class="portfolio-nav-item portfolio-nav-archive">
					<a href="<?php echo esc_url( $mtheme_post_archive_link ); ?>"><i class="feather-icon-grid"></i></a>
				</span>
				<span class="portfolio-nav-item portfolio-next">
				<?php
				if (isSet($portfolio_nav['next'])) {
				?>
					<a href="<?php echo esc_url( get_permalink( $next_portfolio ) ); ?>"><i class="feather-icon-fast-forward"></i></a>
				<?php
				} else {
				?>
					<span><i class="feather-icon-fast-forward"></i></span>
				<?php
				}
				?>
				</span>
			</div>
		</nav>
	</div>
	
<?php
	}
}
add_action('kreativa_display_photostory_single_navigation','kreativa_display_photostory_single_navigation_action');
function kreativa_display_photostory_single_navigation_action() {
	if (is_singular('mtheme_photostory')) {

		$mtheme_post_archive_link = get_post_type_archive_link( 'mtheme_photostory' );
		$theme_options_mtheme_post_arhive_link = kreativa_get_option_data('photostory_archive_page');
		if ($theme_options_mtheme_post_arhive_link!=0) {
			$mtheme_post_archive_link = get_page_link($theme_options_mtheme_post_arhive_link);
		}

		$portfolio_nav = kreativa_get_custom_post_nav("mtheme_photostory");
		if (isSet($portfolio_nav['prev'])) {
			$previous_portfolio = $portfolio_nav['prev'];
		}
		if (isSet($portfolio_nav['next'])) {
			$next_portfolio = $portfolio_nav['next'];
		}
?>
<nav>
	<div class="portfolio-nav-wrap">
		<div class="portfolio-nav">
			<?php
			if (isSet($portfolio_nav['prev'])) {
			?>
			<span title="<?php esc_html_e('Previous','kreativa'); ?>" class="portfolio-nav-item portfolio-prev">
				<a href="<?php echo esc_url( get_permalink( $previous_portfolio ) ); ?>"><i class="feather-icon-rewind"></i></a>
			</span>
			<?php
			}
			?>
			<span title="<?php esc_html_e('Gallery','kreativa'); ?>" class="portfolio-nav-item portfolio-nav-archive">
				<a href="<?php echo esc_url( $mtheme_post_archive_link ); ?>"><i class="feather-icon-grid"></i></a>
			</span>
			<?php
			if (isSet($portfolio_nav['next'])) {
			?>
			<span title="<?php esc_html_e('Next','kreativa'); ?>" class="portfolio-nav-item portfolio-next">
				<a href="<?php echo esc_url( get_permalink( $next_portfolio ) ); ?>"><i class="feather-icon-fast-forward"></i></a>
			</span>
			<?php
			}
			?>
		</div>
	</div>
</nav>
<?php
	}
}
/*-------------------------------------------------------------------------*/
/* Admin JS and CSS */
/*-------------------------------------------------------------------------*/
function kreativa_custom_login_logo() {
	$wp_login_width = kreativa_get_option_data('wplogin_width');
	$wplogin_height = kreativa_get_option_data('wplogin_height');
	if ( $wp_login_width == 0 || $wp_login_width == '' ) {
		$wp_login_width = '320';
	}
	if ( $wplogin_height == 0 || $wplogin_height == '' ) {
		$wplogin_height = '220';
	}
	if ( kreativa_get_option_data('wplogin_logo') ) {
		echo '<style type="text/css">#login h1 a { width:'.esc_attr($wp_login_width).'px; height:'.esc_attr($wplogin_height).'px; background-size:'.esc_attr($wp_login_width).'px !important; background-image:url('.kreativa_get_option_data('wplogin_logo').')  !important; }</style>';  
	}
}
add_action('login_enqueue_scripts',  'kreativa_custom_login_logo');
if ( is_admin() ) {
	function kreativa_admin_post_style_scripts() {
		if ( function_exists('get_current_screen') ) {
			$current_admin_screen = get_current_screen();
		}
		if (isSet($current_admin_screen)) {

			wp_register_script( 'kreativa-of-medialibrary-uploader', get_template_directory_uri() . '/framework/options/admin/js/of-medialibrary-uploader.js', array( 'jquery' ) );
				
			if ($current_admin_screen->base == "post") {
				wp_enqueue_style("kreativa-admin-styles", get_template_directory_uri() ."/framework/admin/css/style.css",false, 'screen' );
				wp_enqueue_style("flatpickr", get_template_directory_uri() ."/framework/admin/js/flatpickr/flatpickr.min.css", array( 'kreativa-admin-styles' ), false, 'screen' );
				wp_enqueue_script("flatpickr", get_template_directory_uri() ."/framework/admin/js/flatpickr/flatpickr.js", array( 'jquery' ),null, true );
				wp_enqueue_script("kreativa-admin-common", get_template_directory_uri() ."/framework/admin/js/admin-common.js", array( 'jquery' ),null, true );
				wp_enqueue_style( 'wp-color-picker');
				wp_enqueue_script('wp-color-picker');
				wp_enqueue_script("kreativa-admin-postmeta", get_template_directory_uri()."/framework/admin/js/postmetaboxes.js", array( 'jquery' ),null, true );

				wp_enqueue_script( 'kreativa-of-medialibrary-uploader' );
				wp_enqueue_media();

				$post_gallery_ids = get_post_meta( get_the_ID(), '_mtheme_image_ids', true );
				wp_localize_script( 'jquery', 'kreativa_admin_vars', array(
				    'post_id' => get_the_ID(),
				    'post_gallery' => $post_gallery_ids,
				    'nonce' => wp_create_nonce( 'kreativa-nonce-metagallery' )
				));
			}
			if ($current_admin_screen->base == "appearance_page_options-framework") {
				wp_enqueue_script( 'kreativa-of-medialibrary-uploader' );
				wp_enqueue_media();
				wp_enqueue_style('kreativa-admin-style', get_template_directory_uri() . '/framework/options/admin/css/admin-style.css');
				wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/fonts/font-awesome/css/font-awesome.min.css', array( 'kreativa-admin-style' ), false, 'screen' );
				wp_enqueue_style( 'ion-icons', get_template_directory_uri() . '/css/fonts/ionicons/css/ionicons.min.css', array( 'kreativa-admin-style' ), false, 'screen' );
				wp_enqueue_style( 'wp-color-picker');
				wp_enqueue_script('wp-color-picker');
				wp_enqueue_script('jquery-ui-core');
				wp_enqueue_script( 'kreativa-options-custom', get_template_directory_uri() . '/framework/options/admin/js/options-custom.js', array( 'wp-color-picker' ), false, true );
				wp_enqueue_script('jquery-ui-sortable');
				wp_enqueue_script('jquery-ui-slider');
				wp_enqueue_script("kreativa-init-script", get_template_directory_uri() . '/framework/options/admin/js/init.js', array( 'jquery' ), "1.0");
    		}
		}
	}
	add_action('admin_enqueue_scripts', 'kreativa_admin_post_style_scripts');
}
/*
Register Fonts
*/
if ( !function_exists('kreativa_fonts_url') ) {
	function kreativa_fonts_url() {
	    $font_url = '';
	    
	    /*
	    Translators: If there are characters in your language that are not supported
	    by chosen font(s), translate this to 'off'. Do not translate into your own language.
	     */

	    if ( 'off' !== _x( 'on', 'Google font: on or off', 'kreativa' ) ) {
	        $font_url = add_query_arg( 'family', urlencode( 'Open Sans:300,300i,400,400i,600,600i,700,700i,800,800i|Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i|PT Mono' ), "//fonts.googleapis.com/css" );
	    }
	    return $font_url;
	}
}
function kreativa_function_scripts_styles() {
	/*-------------------------------------------------------------------------*/
	/* Register Scripts and Styles
	/*-------------------------------------------------------------------------*/
	// 
	/* Common Styles */
	wp_enqueue_style( 'kreativa-MainStyle', get_stylesheet_directory_uri() . '/style.css',false, 'screen' );

	wp_register_script( 'jquery-jplayer', get_template_directory_uri() . '/js/html5player/jquery.jplayer.min.js', array( 'jquery' ),null, true );
	wp_register_style( 'jquery-jplayer', get_template_directory_uri() . '/css/html5player/jplayer.dark.css', array( 'kreativa-MainStyle' ), false, 'screen' );

	// Touch Swipe
	wp_enqueue_script( 'jquery-velocity', get_template_directory_uri() . '/js/velocity.min.js', array( 'jquery' ),null, true );
	wp_register_script( 'jquery-touchSwipe', get_template_directory_uri() . '/js/jquery.touchSwipe.min.js', array( 'jquery' ),null, true );

	// Modernizer
	wp_register_script( 'jquery-modernizr', get_template_directory_uri() . '/js/modernizr.custom.47002.js', array( 'jquery' ),null, true );
	// Grid Rotator
    wp_register_script( 'jquery-grid-rotator', get_template_directory_uri() . '/js/jquery.gridrotator.js', array( 'jquery-modernizr' ), null,true );
	wp_register_script( 'jquery-classie', get_template_directory_uri() . '/js/classie.js', array( 'jquery' ),null, true );

	// Owl Carousel
	wp_register_script( 'owlcarousel', get_template_directory_uri() . '/js/owlcarousel/owl.carousel.min.js', array( 'jquery' ), null,true );
	wp_register_style( 'owlcarousel', get_template_directory_uri() . '/css/owlcarousel/owl.carousel.css', array( 'kreativa-MainStyle' ), false, 'screen' );
	
	// Donut Chart
	wp_register_script( 'jquery-donutchart', get_template_directory_uri() . '/js/jquery.donutchart.js', array( 'jquery' ),null, true );

	wp_register_script( 'jquery-typed', get_template_directory_uri() . '/js/typed.js', array( 'jquery' ),null, true );

	wp_enqueue_script( 'kreativa-verticalmenu', get_template_directory_uri() . '/js/menu/verticalmenu.js', array( 'jquery' ),null, true );

	// WayPoint
	wp_register_script( 'jquery-waypoints', get_template_directory_uri() . '/js/waypoints/waypoints.min.js', array( 'jquery' ),null, true );

	// Before after
	wp_register_script( 'jquery-event-move', get_template_directory_uri() . '/js/beforeafter/jquery.event.move.js', array( 'jquery' ),null, true );
	wp_register_script( 'jquery-twentytwenty', get_template_directory_uri() . '/js/beforeafter/jquery.twentytwenty.js', array( 'jquery' ),null, true );

    wp_register_script( 'jquery-odometer', get_template_directory_uri() . '/js/odometer.min.js', array( 'jquery' ),null, true );

	if( is_ssl() ) {
		$protocol = 'https';
	} else {
		$protocol = 'http';
	}

    // Google Maps Loader
	$googlemap_apikey=kreativa_get_option_data('googlemap_apikey');
	if (!isSet($googlemap_apikey)) {
		$googlemap_apikey = '';
	}
    wp_register_script( 'googlemaps-api', $protocol . '://maps.google.com/maps/api/js?key='.$googlemap_apikey, array( 'jquery' ),null, false );

    // iSotope
    wp_register_script( 'isotope', get_template_directory_uri() . '/js/jquery.isotope.min.js', array( 'jquery' ), null,true );

    // Tubular
    wp_register_script( 'jquery-tubular', get_template_directory_uri() . '/js/jquery.tubular.1.0.js', array( 'jquery' ), null,true );

	wp_register_script( 'video-js', get_template_directory_uri() . '/js/videojs/video.js', array( 'jquery' ),null, true );
	wp_register_style( 'video-js', get_template_directory_uri() . '/js/videojs/video-js.css', array( 'kreativa-MainStyle' ), false, 'screen' );	

	// PhotoWall INIT
    wp_register_script( 'kreativa-photowall_init', get_template_directory_uri() . '/js/photowall.js', array( 'jquery' ), null,true );
    wp_register_script( 'jquery-tilt', get_template_directory_uri() . '/js/tilt.jquery.js', array( 'jquery' ), null,true );

	// Kenburns
    wp_register_script( 'jquery-slideshowify', get_template_directory_uri() . '/js/kenburns/jquery.slideshowify.js', array( 'jquery' ), null,true );

    wp_register_script( 'kreativa-carousel', get_template_directory_uri() . '/js/hcarousel.js', array( 'jquery' ), null,true );
	// Kenburns INIT
    wp_register_script( 'kreativa-kenburns-init', get_template_directory_uri() . '/js/kenburns/kenburns.init.js', array( 'jquery' ), null,true );
	// jQTransit
    wp_register_script( 'jquery-transit', get_template_directory_uri() . '/js/kenburns/jquery.transit.min.js', array( 'jquery' ), null,true );

    // Particles
    wp_register_script( 'jquery-particles', get_template_directory_uri() . '/js/particles/particles.min.js', array( 'jquery' ), null,true );
    wp_register_script( 'kreativa-particles_draw_default', get_template_directory_uri() . '/js/particles/draw-default.js', array( 'jquery' ), null,true );
    wp_register_script( 'kreativa-particles_draw_stars', get_template_directory_uri() . '/js/particles/draw-stars.js', array( 'jquery' ), null,true );
    wp_register_script( 'kreativa-particles_draw_snow', get_template_directory_uri() . '/js/particles/draw-snow.js', array( 'jquery' ), null,true );
    wp_register_script( 'kreativa-particles_draw_grab', get_template_directory_uri() . '/js/particles/draw-grab.js', array( 'jquery' ), null,true );
    wp_register_script( 'kreativa-particles_draw_move', get_template_directory_uri() . '/js/particles/draw-move.js', array( 'jquery' ), null,true );

    // Supersized
    wp_register_script( 'jquery-supersized', get_template_directory_uri() . '/js/supersized/supersized.3.2.7.min.js', array( 'jquery' ), null,true );
    wp_register_script( 'jquery-supersized-shutter', get_template_directory_uri() . '/js/supersized/supersized.shutter.js', array( 'jquery' ), null,true );
    wp_register_style( 'jquery-supersized', get_template_directory_uri() . '/css/supersized/supersized.css',array( 'kreativa-MainStyle' ),false, 'screen' );

	// Responsive Style
	wp_register_style( 'kreativa-ResponsiveCSS', get_template_directory_uri() . '/css/responsive.css',array( 'kreativa-MainStyle' ),false, 'screen' );

	// Dynamic Styles
	wp_register_style( 'kreativa-Dynamic_CSS', get_template_directory_uri() . '/css/dynamic_css.php',array( 'kreativa-MainStyle' ),false, 'screen' );

/*-------------------------------------------------------------------------*/
/* Start Loading
/*-------------------------------------------------------------------------*/
	wp_enqueue_script( 'jquery-superfish', get_template_directory_uri() . '/js/menu/superfish.js', array( 'jquery' ),null, true );

	$ligthbox_transition=kreativa_get_option_data('lightbox_transition');
	$ligthbox_transition_js = 'lg-slide';
	if ( isSet($ligthbox_transition) && $ligthbox_transition<>"") {
		$ligthbox_transition_js = $ligthbox_transition;
	}
	wp_localize_script('jquery', 'kreativa_vars' , array(
		'mtheme_uri' => esc_url( get_template_directory_uri() ),
		'lightbox_transition' => esc_js($ligthbox_transition_js)
	));
	wp_enqueue_script( 'jquery-nicescroll', get_template_directory_uri() . '/js/jquery.nicescroll.min.js', array( 'jquery' ), null,true );
	wp_register_script( 'jquery-lightgallery', get_template_directory_uri() . '/js/lightbox/js/lightgallery.min.js', array( 'jquery' ),null, true );
	wp_register_script( 'jquery-lightgallery-video', get_template_directory_uri() . '/js/lightbox/js/lg-video.min.js', array( 'jquery-lightgallery' ),null, true );
	wp_register_script( 'jquery-lightgallery-autoplay', get_template_directory_uri() . '/js/lightbox/js/lg-autoplay.min.js', array( 'jquery-lightgallery' ),null, true );
	wp_register_script( 'jquery-lightgallery-zoom', get_template_directory_uri() . '/js/lightbox/js/lg-zoom.min.js', array( 'jquery-lightgallery' ),null, true );
	wp_register_script( 'jquery-lightgallery-thumbnails', get_template_directory_uri() . '/js/lightbox/js/lg-thumbnail.min.js', array( 'jquery-lightgallery' ),null, true );
	wp_register_script( 'jquery-lightgallery-fullscreen', get_template_directory_uri() . '/js/lightbox/js/lg-fullscreen.min.js', array( 'jquery-lightgallery' ),null, true );
	wp_register_style( 'jquery-lightgallery', get_template_directory_uri() . '/js/lightbox/css/lightgallery.css', array( 'kreativa-MainStyle' ), false, 'screen' );
	wp_register_style( 'jquery-lightgallery-transitions', get_template_directory_uri() . '/js/lightbox/css/lg-transitions.min.css', array( 'jquery-lightgallery' ), false, 'screen' );

	wp_register_script( 'jquery-fotorama', get_template_directory_uri() . '/js/fotorama/fotorama.js', array( 'jquery' ),null, true );
	wp_register_style( 'jquery-fotorama', get_template_directory_uri() . '/js/fotorama/fotorama.css', array( 'kreativa-MainStyle' ), false, 'screen' );

	wp_register_script( 'jquery-swiper', get_template_directory_uri() . '/js/swiper.jquery.min.js', array( 'jquery' ),null, true );
	wp_register_style( 'jquery-swiper', get_template_directory_uri() . '/css/swiper.css', array( 'kreativa-MainStyle' ), false, 'screen' );
	wp_register_style( 'kreativa-elements', get_template_directory_uri() . '/css/elements.css', array( 'kreativa-MainStyle' ), false, 'screen' );

	wp_enqueue_script( 'jquery-easing', get_template_directory_uri() . '/js/jquery.easing.min.js', array( 'jquery' ),null, true );
	wp_enqueue_script( 'kreativa-portfolioloader', get_template_directory_uri() . '/js/page-elements.js', array( 'jquery' ), null,true );
	wp_localize_script('kreativa-portfolioloader', 'ajax_var', array(
		'url' => esc_url( admin_url('admin-ajax.php') ),
		'nonce' => wp_create_nonce('ajax-nonce')
	));
	wp_enqueue_script( 'jquery-fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array( 'jquery' ), null,true );

	wp_enqueue_script ('jquery-waypoints');
	wp_enqueue_script ('imagesloaded');
	wp_enqueue_script('hoverIntent');
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-tooltip');

	wp_enqueue_script ('owlcarousel');
	wp_enqueue_style ('owlcarousel');

    wp_enqueue_script( 'jquery-nicescroll' );
    wp_enqueue_script( 'jquery-modernizr' );
	wp_enqueue_script ('jquery-grid-rotator');
    wp_enqueue_script( 'jquery-classie' );
    
    if ( !wp_is_mobile() ) {
		wp_enqueue_script( 'jquery-jarallax', get_template_directory_uri() . '/js/jarallax/jarallax.js', array( 'jquery' ), null,true );
	}

    wp_enqueue_script( 'jquery-lightgallery' );
    wp_enqueue_style( 'jquery-lightgallery' );
    wp_enqueue_style( 'jquery-lightgallery-transitions' );
    wp_enqueue_script( 'jquery-lightgallery-video' );
    wp_enqueue_script( 'jquery-lightgallery-autoplay' );
    wp_enqueue_script( 'jquery-lightgallery-zoom' );
    wp_enqueue_script( 'jquery-lightgallery-thumbnails' );
    wp_enqueue_script( 'jquery-lightgallery-fullscreen' );

	wp_enqueue_script( 'kreativa-common', get_template_directory_uri() . '/js/common.js', array( 'jquery' ),null, true );

	// Get Theme Style
	$theme_style=kreativa_get_option_data('theme_style');
	if (kreativa_is_in_demo()) {
		if ( false != kreativa_demo_get_data('theme_style') ) {
			$theme_style = kreativa_demo_get_data('theme_style');
		}
	}

	if ($theme_style=="dark") {
		wp_enqueue_style( 'kreativa-Dark', get_stylesheet_directory_uri() . '/style-dark.css', array( 'kreativa-MainStyle' ), 'screen' );
	}
	wp_enqueue_style( 'kreativa-Animations', get_template_directory_uri() . '/css/animations.css', array( 'kreativa-MainStyle' ), false, 'screen' );

	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/fonts/font-awesome/css/font-awesome.min.css', array( 'kreativa-MainStyle' ), false, 'screen' );
	wp_enqueue_style( 'ion-icons', get_template_directory_uri() . '/css/fonts/ionicons/css/ionicons.min.css', array( 'kreativa-MainStyle' ), false, 'screen' );
	wp_enqueue_style( 'et-fonts', get_template_directory_uri() . '/css/fonts/et-fonts/et-fonts.css', array( 'kreativa-MainStyle' ), false, 'screen' );
	wp_enqueue_style( 'feather-webfonts', get_template_directory_uri() . '/css/fonts/feather-webfont/feather.css', array( 'kreativa-MainStyle' ), false, 'screen' );
	wp_enqueue_style( 'fontello', get_template_directory_uri() . '/css/fonts/fontello/css/fontello.css', array( 'kreativa-MainStyle' ), false, 'screen' );
	wp_enqueue_style( 'simple-line-icons', get_template_directory_uri() . '/css/fonts/simple-line-icons/simple-line-icons.css', array( 'kreativa-MainStyle' ), false, 'screen' );

	//*** End of Common Script and Style Loads **//

	// Conditional Owl Slideshow
	if ( is_archive() || is_single() || is_search() || is_home() || is_page_template('template-bloglist.php') || is_page_template('template-bloglist-small.php') || is_page_template('template-bloglist_fullwidth.php') || is_page_template('template-gallery-posts.php') ) {
			wp_enqueue_script ('owlcarousel');
			wp_enqueue_style ('owlcarousel');
	}
	if ( is_singular('mtheme_portfolio') || is_singular('mtheme_gallery') ) {
		wp_enqueue_script ('jquery-event-move');
		wp_enqueue_script ('jquery-twentytwenty');
	}
	if ( is_singular('mtheme_gallery') ) {
		wp_enqueue_script ('jquery-fotorama');
		wp_enqueue_style ('jquery-fotorama');
	}
	if(is_single()) {
		wp_enqueue_script ('owlcarousel');
		wp_enqueue_style ('owlcarousel');
	}
	// Conditional Load jPlayer
	if ( is_archive() || is_single() || is_search() || is_home() || kreativa_is_fullscreen_home() || is_page_template('template-bloglist.php') || is_page_template('template-bloglist-small.php') || is_page_template('template-bloglist_fullwidth.php') || is_page_template('template-video-posts.php') || is_page_template('template-audio-posts.php') ) {
			wp_enqueue_script ('jquery-jplayer');
			wp_enqueue_style ('jquery-jplayer');
	}

	// Load Dynamic Styles last to over-ride all
	require_once ( get_template_directory() . '/css/dynamic_css.php' );
	wp_enqueue_style( 'kreativa-fonts', kreativa_fonts_url(), array(), '1.0.0' );
	wp_add_inline_style( 'kreativa-ResponsiveCSS', $dynamic_css );


	// Generate Background Script for Slideshow
	if ( !kreativa_is_fullscreen_home() && !kreativa_is_fullscreen_post() && is_singular() ) {
		$bg_choice= get_post_meta(get_the_id(), 'pagemeta_meta_background_choice', true);
		$custom_bg_image_url= get_post_meta(get_the_id(), 'pagemeta_meta_background_url', true);
		$image_link=kreativa_featured_image_link(get_the_id());

		if ( kreativa_page_is_woo_shop() ) {
			$woo_shop_post_id = get_option( 'woocommerce_shop_page_id' );
			$bg_choice= get_post_meta($woo_shop_post_id, 'pagemeta_meta_background_choice', true);
			$custom_bg_image_url= get_post_meta($woo_shop_post_id, 'pagemeta_meta_background_url', true);
			$image_link=kreativa_featured_image_link($woo_shop_post_id);
		}

		if ( !post_password_required () && !is_singular('mtheme_clients') ) {
			$supersized_script = kreativa_generate_supersized_script( $get_slideshow_from_page_id = false, $isbackground = true );
			wp_add_inline_script('jquery-supersized-shutter',$supersized_script);
		}
	}

	if ( kreativa_is_fullscreen_post() ) {

		$featured_page=kreativa_get_active_fullscreen_post();
		
		if ( post_password_required ($featured_page) ) {
			// If password protected
			$password_featured_image_link=kreativa_featured_image_link($featured_page);
			if (isSet($password_featured_image_link)) {
				wp_add_inline_style( 'kreativa-ResponsiveCSS','.site-back-cover { background-image: url('.esc_url($password_featured_image_link).'); }' );
			}
		} else {

			$custom = get_post_custom( $featured_page );
			if ( isSet($custom[ "pagemeta_fullscreen_type"][0]) ) {
				$fullscreen_type = $custom[ "pagemeta_fullscreen_type"][0];
			}
			if ( isSet($custom[ "pagemeta_fullscreentitlefont_meta"][0]) ) {
				$fullscreentitlefont_meta = $custom[ "pagemeta_fullscreentitlefont_meta"][0];
				$slideshowtitle_meta_font = kreativa_extract_googlefont_data($fullscreentitlefont_meta);
				wp_enqueue_style( $slideshowtitle_meta_font['name'], $slideshowtitle_meta_font['url'] , array( 'kreativa-MainStyle' ), null, 'screen' );
				wp_add_inline_style( 'kreativa-ResponsiveCSS', ".slideshow_title, .static_slideshow_title, .coverphoto-text-container .slideshow_title, .coverphoto-text-container .static_slideshow_title { font-family: ".$slideshowtitle_meta_font['cssname']."; }" );
			}
			if ( isSet($custom[ "pagemeta_fullscreentitlesize_meta"][0]) ) {
				$fullscreentitlesize_meta = $custom[ "pagemeta_fullscreentitlesize_meta"][0];
				if ($fullscreentitlesize_meta<>"") {
					wp_add_inline_style( 'kreativa-ResponsiveCSS', ".slideshow_title, .static_slideshow_title { font-size: ".$fullscreentitlesize_meta."px;line-height:".$fullscreentitlesize_meta."px; }" );
				}
			}
			if ( isSet($custom[ "pagemeta_fullscreentitlespacing_meta"][0]) ) {
				$fullscreentitlespacing_meta = $custom[ "pagemeta_fullscreentitlespacing_meta"][0];
				if ($fullscreentitlespacing_meta<>"") {
					wp_add_inline_style( 'kreativa-ResponsiveCSS', ".slideshow_title, .static_slideshow_title { letter-spacing: ".$fullscreentitlespacing_meta."px; }" );
				}
			}
			if ( isSet($custom[ "pagemeta_fullscreentitlelineheight_meta"][0]) ) {
				$fullscreentitlelineheight_meta = $custom[ "pagemeta_fullscreentitlelineheight_meta"][0];
				if ($fullscreentitlelineheight_meta<>"") {
					wp_add_inline_style( 'kreativa-ResponsiveCSS', ".slideshow_title, .static_slideshow_title { line-height: ".$fullscreentitlelineheight_meta."px; }" );
				}
			}
			if (is_singular('mtheme_photostory')) {
				$fullscreen_type="fotorama";
			}
			$site_in_maintenance = kreativa_maintenance_check();
			if ( $site_in_maintenance ) {
				$fullscreen_type="";
			}
			if (isSet($fullscreen_type)) {
				switch ($fullscreen_type) {

					case "photowall" :
						wp_enqueue_script ('kreativa-photowall_init');
						wp_enqueue_script ('isotope');
						wp_add_inline_style( 'kreativa-ResponsiveCSS', "body{position:absolute;top:0;left:0;height:100%;width:100%;min-height:100%;min-width:100%;}" );
					break;

					case "kenburns" :
						wp_enqueue_script ('jquery-slideshowify');
						wp_enqueue_script ('jquery-transit');
						wp_enqueue_script ('kreativa-kenburns-init');
						wp_enqueue_style ('jquery-supersized');
						wp_add_inline_style( 'kreativa-ResponsiveCSS', "body{position:absolute;top:0;left:0;height:100%;width:100%;min-height:100%;min-width:100%;}" );
					break;

					case "coverphoto" :
						wp_enqueue_script ('jquery-supersized');
						wp_enqueue_script ('jquery-supersized-shutter');
						wp_enqueue_style ('jquery-supersized');
						wp_enqueue_script ('jquery-touchSwipe');
						wp_add_inline_style( 'kreativa-ResponsiveCSS', "body{position:absolute;top:0;left:0;height:100%;width:100%;min-height:100%;min-width:100%;}" );
						$supersized_script = kreativa_generate_supersized_script();
						wp_add_inline_script('jquery-supersized-shutter',$supersized_script);
					break;

					case "particles" :
						wp_enqueue_script ('jquery-supersized');
						wp_enqueue_script ('jquery-supersized-shutter');
						wp_enqueue_style ('jquery-supersized');
						wp_enqueue_script ('jquery-particles');
						if ( isSet($custom[ "pagemeta_particle_type"][0]) ) {
							$particle_type = $custom[ "pagemeta_particle_type"][0];
							if ($particle_type=="default") {
								wp_enqueue_script ('kreativa-particles_draw_default');
							}
							if ($particle_type=="stars") {
								wp_enqueue_script ('kreativa-particles_draw_stars');
							}
							if ($particle_type=="snow") {
								wp_enqueue_script ('kreativa-particles_draw_snow');
							}
							if ($particle_type=="grab") {
								wp_enqueue_script ('kreativa-particles_draw_grab');
							}
							if ($particle_type=="move") {
								wp_enqueue_script ('kreativa-particles_draw_move');
							}
						}
						wp_add_inline_style( 'kreativa-ResponsiveCSS', "body{position:absolute;top:0;left:0;height:100%;width:100%;min-height:100%;min-width:100%;}" );
						$supersized_script = kreativa_generate_supersized_script();
						wp_add_inline_script('jquery-supersized-shutter',$supersized_script);
					break;

					case "fotorama" :
						wp_enqueue_script ('jquery-fotorama');
						wp_enqueue_style ('jquery-fotorama');
						if ( isSet($custom[ "pagemeta_fotorama_thumbnails"][0]) ) {
							$fotorama_thumbnails = $custom[ "pagemeta_fotorama_thumbnails"][0];
							if ($fotorama_thumbnails=="disable") {
								wp_add_inline_style( 'kreativa-ResponsiveCSS', ".fotorama__nav-wrap { display: none !important; }" );
							}
						}
					break;

					case "swiperslides" :
						wp_enqueue_script ('jquery-swiper');
						wp_enqueue_style ('jquery-swiper');
						wp_add_inline_style( 'kreativa-ResponsiveCSS', "body{position:absolute;top:0;left:0;height:100%;width:100%;min-height:100%;min-width:100%;}" );
						$swiperslides = kreativa_generate_swiperscript();
						wp_add_inline_script('jquery-swiper',$swiperslides);
					break;

					case "carousel" :
						wp_enqueue_script ('kreativa-carousel');
						wp_enqueue_script ('jquery-touchSwipe');
						wp_add_inline_style( 'kreativa-ResponsiveCSS', "body{position:absolute;top:0;left:0;height:100%;width:100%;min-height:100%;min-width:100%;overflow:hidden;}" );
					break;
					
					case "slideshow" :
					case "Slideshow-plus-captions" :
						wp_enqueue_script ('jquery-supersized');
						wp_enqueue_script ('jquery-supersized-shutter');
						wp_enqueue_style ('jquery-supersized');
						wp_enqueue_script ('jquery-touchSwipe');
						wp_add_inline_style( 'kreativa-ResponsiveCSS', "body{position:absolute;top:0;left:0;height:100%;width:100%;min-height:auto;min-width:100%;}" );
						$supersized_script = kreativa_generate_supersized_script();
						wp_add_inline_script('jquery-supersized-shutter',$supersized_script);
					break;
					
					case "video" :
						if (isSet($custom["pagemeta_youtubevideo"][0])) {
							wp_enqueue_script ('jquery-tubular');
						}
						if (isSet($custom["pagemeta_vimeovideo"][0])) {
							wp_add_inline_style( 'kreativa-MainStyle', "body{height:1px;}" );
						}
						if ( isSet($custom["pagemeta_html5_mp4"][0]) || isSet($custom["pagemeta_html5_webm"][0]) ) {
							wp_enqueue_script('video-js');
							wp_enqueue_style('video-js');
							wp_add_inline_style( 'kreativa-ResponsiveCSS', "body{position:absolute;top:0;left:0;height:100%;width:100%;min-height:100%;min-width:100%;}" );
						}
					break;

					default:

					break;
				}
			}
		}

	}

	wp_enqueue_script ('jquery-tilt');

	if ( is_404() ) {
		wp_enqueue_script ('isotope');
	}
	if ( is_search() && isSet( $_GET['photostock'] ) ) {
		wp_enqueue_script ('isotope');
	}

	// Conditional Load jQueries
	if(kreativa_got_shortcode('tabs') || kreativa_got_shortcode('accordion')) {
	    wp_enqueue_script('jquery-ui-core');
	    wp_enqueue_script('jquery-ui-tabs');
	    wp_enqueue_script('jquery-ui-accordion');
	}

	if(kreativa_got_shortcode('beforeafter') ) {
		wp_enqueue_script ('jquery-event-move');
		wp_enqueue_script ('jquery-twentytwenty');
	}

	if(kreativa_got_shortcode('portfoliogrid') || is_page_template('template-eventgallery.php') || is_page_template('template-photostorygallery.php') || kreativa_got_shortcode('thumbnails') || is_post_type_archive() || is_tax() || is_singular('mtheme_gallery') || is_singular('mtheme_proofing')) {
		wp_enqueue_script ('isotope');
	}

	if(kreativa_got_shortcode('count')) { 
		wp_enqueue_script ('jquery-odometer');
	}
	//Counter
	if(kreativa_got_shortcode('counter')) {  
		wp_enqueue_script ('jquery-donutchart');
	}
	//Caraousel
	if(kreativa_got_shortcode('workscarousel')) {
		wp_enqueue_script ('owlcarousel');
		wp_enqueue_style ('owlcarousel');
	}
	if(kreativa_got_shortcode('woocommerce_carousel_bestselling')) {
		wp_enqueue_script ('owlcarousel');
		wp_enqueue_style ('owlcarousel');
	}
	if(kreativa_got_shortcode('map')) {
		wp_enqueue_script ('googlemaps-api');
	}

	if( kreativa_got_shortcode('woocommerce_featured_slideshow') || kreativa_got_shortcode('blogcarousel') || kreativa_got_shortcode('slideshowcarousel') || kreativa_got_shortcode('recent_blog_slideshow') || kreativa_got_shortcode('recent_portfolio_slideshow') || kreativa_got_shortcode('portfoliogrid') || kreativa_got_shortcode('testimonials') ) {
		wp_enqueue_script ('owlcarousel');
		wp_enqueue_style ('owlcarousel');
	}

	if( kreativa_got_shortcode('audioplayer') || kreativa_got_shortcode('bloglist') || kreativa_got_shortcode('blogtimeline') || kreativa_got_shortcode('recentblog') ) {
		wp_enqueue_script ('jquery-jplayer');
		wp_enqueue_style ('jquery-jplayer');
	}

	if( kreativa_got_shortcode('carousel_group') ) {
		wp_enqueue_script ('owlcarousel');
		wp_enqueue_style ('owlcarousel');
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() ) {
	// Background slideshow or image
		$bg_choice = get_post_meta( get_the_id() , 'pagemeta_meta_background_choice', true);
	}
	// Load scripts based on Background Image / Slideshow Choice
	if ( is_archive() || is_search() || is_404() ) {
		$bg_choice="default";
	}
	if ( is_home() ) {
			$bg_choice="default";
	}
	if ( kreativa_is_fullscreen_post() ) {
			$bg_choice="background_color";
	}
	if ( kreativa_page_is_woo_shop() ) {
		$woo_shop_post_id = get_option( 'woocommerce_shop_page_id' );
		$bg_choice = get_post_meta( $woo_shop_post_id , 'pagemeta_meta_background_choice', true);
	}
	if ( post_password_required () && is_singular('mtheme_clients') ) {
		$bg_choice = "none";
	}
	if ( isSet($bg_choice) ) {
		switch ($bg_choice) { 
			case "featured_image" :
			case "custom_url" :
			case "options_image" :
				// Showing an image
			break;
			case "options_slideshow" :
			case "image_attachments" :
			case "fullscreen_post" :
				wp_enqueue_script ('jquery-supersized');
				wp_enqueue_script ('jquery-supersized-shutter');
				wp_enqueue_style ('jquery-supersized');
				wp_enqueue_script ('jquery-touchSwipe');
			break;
			case "video_background" :
				$current_page_check = get_post_custom(get_the_id());
				if ( kreativa_page_is_woo_shop() ) {
					$woo_shop_post_id = get_option( 'woocommerce_shop_page_id' );
					$current_page_check = get_post_custom( $woo_shop_post_id );
				}
				if (isSet($current_page_check["pagemeta_video_bgfullscreenpost"][0])) {
					$background_video_id = $current_page_check["pagemeta_video_bgfullscreenpost"][0];
					$background_video_type = get_post_custom($background_video_id);
					if (isSet($background_video_type["pagemeta_html5_mp4"][0])) {
						wp_enqueue_script('video-js');
						wp_enqueue_style('video-js');
					}
					if (isSet($background_video_type["pagemeta_youtubevideo"][0])) {
						wp_enqueue_script ('jquery-tubular');
					}
				}
			break;

			case "background_color" :
			break;

			default :
			break;
		}
	}
	
	$pagecolor_set = false;

	if ( is_archive() ) {
		$page_bg_color_themeoptions = kreativa_get_option_data('page_background');
		$page_bg_opacity_themeoptions = kreativa_get_option_data('page_background_opacity');

		$final_page_bgcolor_rgba=kreativa_hex2RGB($page_bg_color_themeoptions,true);
		$page_opacity = $page_bg_opacity_themeoptions / 100;

		if (isSet($final_page_bgcolor_rgba) && $final_page_bgcolor_rgba<>"") {
			$apply_pagebackground_color = '.container-wrapper,.fullscreen-protected #password-protected { background: rgba('. $final_page_bgcolor_rgba .','.$page_opacity.'); }';
			wp_add_inline_style( 'kreativa-ResponsiveCSS', $apply_pagebackground_color );
		}

		$pagecolor_set = true;
	}

	if ( is_singular() ) {
		// Set Opacity from Page

		$page_bg_color = get_post_meta( get_the_id() , 'pagemeta_pagebackground_color', true);
		$page_opacity = get_post_meta( get_the_id() , 'pagemeta_pagebackground_opacity', true);

		$page_opacity_customize = kreativa_get_option_data('page_opacity_customize');
		if ($page_opacity_customize) {
			$page_bg_color = kreativa_get_option_data('page_background');
			$page_opacity = kreativa_get_option_data('page_background_opacity');
		}

		if ( isSet($page_bg_color) && isSet($page_opacity) ) {
			if ( $page_bg_color<>"" ) {
				if ($page_opacity=="default") {
					$page_opacity = "90";
				}

				if ( kreativa_page_is_woo_shop() ) {
					$woo_shop_post_id = get_option( 'woocommerce_shop_page_id' );
					// Set Opacity from Page
					$page_opacity = get_post_meta( $woo_shop_post_id, 'pagemeta_pagebackground_opacity', true);
					$page_bg_color = get_post_meta( $woo_shop_post_id , 'pagemeta_pagebackground_color', true);

				}
				if ( kreativa_is_fullscreen_post() ) {
					if ( isSet($page_bg_color)) {
						$apply_background_color = 'body.page-is-fullscreen,#supersized li { background:'.$page_bg_color.'; }';
						wp_add_inline_style( 'kreativa-ResponsiveCSS', $apply_background_color );
					}
				} else {
					if ( isSet($page_opacity) && $page_opacity<>"default" && $page_opacity<>"" && isSet($page_bg_color) ) {
						// Page background color is set
						if ($page_bg_color<>"") {
							$final_page_bgcolor = $page_bg_color;
							// Convert color to rgba
							$final_page_bgcolor_rgba=kreativa_hex2RGB($final_page_bgcolor,true);
							$page_opacity = $page_opacity / 100;

							if (isSet($final_page_bgcolor_rgba) && $final_page_bgcolor_rgba<>"") {
								$apply_pagebackground_color = '.container-wrapper,.fullscreen-protected #password-protected { background: rgba('. $final_page_bgcolor_rgba .','.$page_opacity.'); }';
								wp_add_inline_style( 'kreativa-ResponsiveCSS', $apply_pagebackground_color );
							}
						}
					}
				}
			}
		}
	}

	// Embed a font
	if ( kreativa_get_option_data('custom_font_embed')<>"" ) {
		echo stripslashes_deep( kreativa_get_option_data('custom_font_embed') );
	}
	if ( kreativa_get_option_data('custom_font_css')<>"" ) {
		$custom_font_css = stripslashes_deep( kreativa_get_option_data('custom_font_css') );
		wp_add_inline_style( 'kreativa-MainStyle', $custom_font_css );
	}

	if( is_ssl() ) {
		$protocol = 'https';
	} else {
		$protocol = 'http';
	}

	// ******* Load Responsive and Custom Styles
	wp_enqueue_style ('kreativa-ResponsiveCSS');
	// ******* No more styles will be loaded after this line

	// Load Fonts
	// This enqueue method through the function prevent any double loading of fonts.
	$rcm_font = kreativa_enqueue_font ("rcm_font");
	if ($rcm_font['name'] != "Default+Font" ) {
		wp_enqueue_style( $rcm_font['name'], $rcm_font['url'] , array( 'kreativa-MainStyle' ), null, 'screen' );
	}
	$page_contents = kreativa_enqueue_font ("page_contents");
	if ($page_contents['name'] != "Default+Font") {
		wp_enqueue_style( $page_contents['name'], $page_contents['url'] , array( 'kreativa-MainStyle' ), null, 'screen' );
	}

	$super_title = kreativa_enqueue_font ("super_title");
	if ($super_title['name'] != "Default+Font") {
		wp_enqueue_style( $super_title['name'], $super_title['url'] , array( 'kreativa-MainStyle' ), null, 'screen' );
	}

	$super_caption = kreativa_enqueue_font ("super_caption");
	if ($super_caption['name'] != "Default+Font") {
		wp_enqueue_style( $super_caption['name'], $super_caption['url'] , array( 'kreativa-MainStyle' ), null, 'screen' );
	}

	$hero_title = kreativa_enqueue_font ("hero_title");
	if ($hero_title['name'] != "Default+Font") {
		wp_enqueue_style( $hero_title['name'], $hero_title['url'] , array( 'kreativa-MainStyle' ), null, 'screen' );
	}

	$heading_font = kreativa_enqueue_font ("heading_font");
	if ($heading_font['name'] != "Default+Font") {
		wp_enqueue_style( $heading_font['name'] , $heading_font['url'] , array( 'kreativa-MainStyle' ), null, 'screen' );
	}

	$menu_font = kreativa_enqueue_font ("menu_font");
	if ($menu_font['name'] != "Default+Font") {
		wp_enqueue_style( $menu_font['name'], $menu_font['url'] , array( 'kreativa-MainStyle' ), null, 'screen' );
	}

	$hero_font = kreativa_enqueue_font ("hero_title");
	if ($hero_font['name'] != "Default+Font") {
		wp_enqueue_style( $hero_font['name'], $hero_font['url'] , array( 'kreativa-MainStyle' ), null, 'screen' );
	}

}
add_action( 'wp_enqueue_scripts', 'kreativa_function_scripts_styles' );
// Pagination for Custom post type singular portfoliogallery
add_filter('redirect_canonical','kreativa_disable_redirect_canonical');
function kreativa_disable_redirect_canonical( $redirect_url ) {
    if ( is_singular( 'portfoliogallery' ) ) {
		$redirect_url = false;
	}
    return $redirect_url;
}

add_filter( 'option_posts_per_page', 'kreativa_tax_filter_posts_per_page' );
function kreativa_tax_filter_posts_per_page( $value ) {
    return (is_tax('types')) ? 1 : $value;
}
function kreativa_stock_search( $query ) {
	
    if ( $query->is_tax('phototag') && !is_admin() ) {
	        $limit = kreativa_get_option_data('stockphoto_limit');
	        if ($limit=="") {
	            $limit = "12";
	        }
			$term = get_queried_object();
			if (!isSet($term->name) ) {
				$term_archive='';
			} else {
				$term_archive = $term->name;
			}
			$query->set( 'post_type', array( 'attachment' ) );
			$query->set( 'post_mime_type', array( 'image' ) );
			$query->set( 'post_status', array( 'publish', 'inherit' ) );
			$query->set( 'posts_per_page', $limit );
			$taxquery = array(
                array(
                    'taxonomy' => 'phototag',
                    'field' => 'slug',
                    'terms' => $term_archive,
                    'operator' => 'IN'
                ));
			$query->set( 'tax_query', $taxquery );
    }
    if ( $query->is_search && !is_admin() ) {
    	if (isSet( $_GET['photostock'] )) {

	        $limit = kreativa_get_option_data('stockphoto_limit');
	        if ($limit=="") {
	            $limit = "12";
	        }
			$query->set( 'post_type', array( 'attachment' ) );
			$query->set( 'post_mime_type', array( 'image' ) );
			$query->set( 'post_status', array( 'publish', 'inherit' ) );
			$query->set( 'posts_per_page', $limit );
			$taxquery = array(
			    array(
			        'taxonomy' => 'phototag',
			        'operator'=> 'EXISTS'
			    ));
			$query->set( 'tax_query', $taxquery );
   		}
    }
	return $query;
}
add_filter( 'pre_get_posts', 'kreativa_stock_search' );
// Add to Body Class
function kreativa_body_class( $classes ) {

	if ( wp_is_mobile() ) {
		$classes[] = "parallax-is-off";
	}

	if (isSet( $_GET['photostock'] )) {
		$classes[] = "edge-to-edge";
		$classes[] = "searching-photostock";
		if ( isSet( $_GET['s'] ) && $_GET['s']<>"" ) {
			$classes[] = "searching-for-photostock-term";
		}
	}
	if ( is_tax('phototag') ) {
		$classes[] = "edge-to-edge";
		$classes[] = "searching-photostock";
	}

	$site_in_maintenance = kreativa_maintenance_check();
	if ( $site_in_maintenance ) {
		$classes[] = "site-in-maintenance-mode";
	}

	$classes[] = "fullscreen-mode-off";

	if ( kreativa_page_has_background() ) {
		$classes[] = "page-has-full-background";
	}

	if ( kreativa_get_option_data('rightclick_disable') ) {
		$classes[] = 'rightclick-block';
	}
	if ( ! is_multi_author() ) {
		$classes[] = 'single-author';
	}

	if ( class_exists( 'woocommerce' ) ) {
		if ( is_shop() || is_product_category() ) {
			$shop_layout = false;
			$shop_layout = kreativa_get_option_data('mtheme_wooarchive_sidebar');
			if (kreativa_is_in_demo()) {
				if ( false != kreativa_demo_get_data('woo_style') ) {
					$shop_layout = kreativa_demo_get_data('woo_style');
				}
			}
			if ( $shop_layout ) {
				$classes[] = 'wooshop-has-sidebar-archive';
			} else {
				$classes[] = 'wooshop-no-sidebar-archive';
			}
		}
	}

	if ( !is_archive() ) {
		if ( post_password_required() ) {
			$classes[] = 'mtheme-password-required';
		}
	}

	$skin_style = kreativa_get_option_data('theme_style');
	if (kreativa_is_in_demo()) {
		if ( false != kreativa_demo_get_data('theme_style') ) {
			$skin_style = kreativa_demo_get_data('theme_style');
		}
	}
	$classes[] = 'theme-is-' . $skin_style;
	if ( kreativa_is_in_demo() ) {
		$classes[] = 'demo';
	}
	if ( ! has_nav_menu( "main_menu" ) ) {
		$classes[] = 'mtheme-menu-inactive';
	}

	$header_menu_type = kreativa_get_option_data('header_menu_type');
	if (kreativa_is_in_demo()) {
		if ( false != kreativa_demo_get_data('menu_type') ) {
			$header_menu_type = kreativa_demo_get_data('menu_type');
		}
	}
	
	switch ($header_menu_type) {
		case 'left-detatched':
			$classes[] = 'left-logo';
			$classes[] = 'menu-is-horizontal';
			break;
		case 'vertical-menu':
			$classes[] = 'menu-is-vertical';
			break;
		
		default:
			$classes[] = 'menu-is-vertical';
			break;
	}

	$page_data = get_post_custom( get_the_id() );

	if ( kreativa_is_fullscreen_post() ) {
		$classes[] = 'page-is-fullscreen';
		$fullscreen_type_class = kreativa_get_fullscreen_type();
		if (!isSet($fullscreen_type_class) || $fullscreen_type_class=="") {
			$fullscreen_type_class="unknown-type";
		} else {
			if ( $fullscreen_type_class == "fotorama" ) {
				$fotorama_custom = get_post_custom( kreativa_get_active_fullscreen_post() );
				if (isSet($fotorama_custom["pagemeta_fotorama_fill"][0])) {
					$fotorama_fill_mode=$fotorama_custom["pagemeta_fotorama_fill"][0];
					if ( isSet($fotorama_fill_mode) ) {
						$classes[] =  'fotorama-style-'.$fotorama_fill_mode;
					}
				}
			}
			if ( $fullscreen_type_class == "video" ) {
				$video_custom = get_post_custom( kreativa_get_active_fullscreen_post() );
				if (isSet($video_custom["kreativa_youtubevideo"][0])) {
					$classes[] =  'fullscreen-video-type-youtube';
				}
				if (isSet($video_custom["kreativa_vimeovideo"][0])) {
					$classes[] =  'fullscreen-video-type-vimeo';
				}
				if ( isSet($video_custom["kreativa_html5_mp4"][0]) || isSet($video_custom["kreativa_html5_wemb"][0]) ) {
					$classes[] =  'fullscreen-video-type-html5';
				}
			}
		}
		if (is_singular('mtheme_photostory')) {
			$fullscreen_type_class="fotorama";
		}
		$classes[] =  'fullscreen-'.$fullscreen_type_class;

		$featured_page = kreativa_get_active_fullscreen_post();
		if (defined('ICL_LANGUAGE_CODE')) { // this is to not break code in case WPML is turned off, etc.
		    $_type  = get_post_type($featured_page);
		    $featured_page = icl_object_id($featured_page, $_type, true, ICL_LANGUAGE_CODE);
		}

	} else {
		$classes[] = 'page-is-not-fullscreen';
	}

	if ( is_archive() ) {
		$classes[] = 'header-is-default';
	}

	$classes[] = 'fullscreen-ui-switchable';

	$hide_pagetitle=kreativa_get_option_data('hide_pagetitle');
	if ($hide_pagetitle=="1") {
		$classes[] = 'page-has-no-title-sidewide';
	}

	if ( is_singular() || kreativa_is_fullscreen_home() ) {

		$header_page_id = get_the_id();
		if ( kreativa_is_fullscreen_home() ) {
			$header_page_id =kreativa_get_active_fullscreen_post();
		}

		$page_opacity = get_post_meta( get_the_id() , 'pagemeta_pagebackground_opacity', true);
		$page_bg_color = get_post_meta( get_the_id() , 'pagemeta_pagebackground_color', true);

		if ( isSet($page_opacity) && $page_opacity<>"default" && $page_opacity<>"100" && $page_opacity<>"" ) {
			$page_transparency_class = 'page-is-transparent';
		} else {
			$page_transparency_class = 'page-is-opaque';
		}

		$bg_choice= get_post_meta(get_the_id(), 'pagemeta_meta_background_choice', true);
		if ( isSet($bg_choice) && $bg_choice=="none") {
			$classes[] = 'page-media-not-set';
		}

		if ( isSet($page_transparency_class) ) {
			$classes[] = $page_transparency_class;
		}

		$page_title = get_post_meta( get_the_id() , 'pagemeta_page_title', true);

		if ( is_singular('mtheme_proofing') ) {
			$client_id = get_post_meta( get_the_id() , 'pagemeta_client_names', true);
			$proofing_status = get_post_meta( get_the_id() , 'pagemeta_proofing_status', true);
			if ( isSet($client_id) ) {
				if ( post_password_required($client_id) ) {
					$classes[] = 'password-protected-client-mode';
				}
			}
			if ( isSet($proofing_status) ) {
				$classes[] = 'proofing-status-'.$proofing_status;
			}
		}
		if ( is_singular('mtheme_clients') ) {
			if ( post_password_required() ) {
				$classes[] = 'password-protected-client-mode';
			}
		}
		if ( isSet($page_title) && $page_title == "hide") {
			$classes[] = 'page-has-no-title';
		}
		if ( isSet($page_title) && $page_title == "show") {
			$classes[] = 'page-has-title';
		}
	}

	$classes[] = 'theme-fullwidth';
	$classes[] = 'body-dashboard-push';

	$footerwidget_status = kreativa_get_option_data('footerwidget_status');
	if ($footerwidget_status) {
		$classes[] = 'footer-is-on';
	} else {
		$classes[] = 'footer-is-off';
	}

	if ( is_singular() ) {

		$isactive = get_post_meta( get_the_id(), "mtheme_pb_isactive", true );
		if (isSet($isactive) && $isactive==1) {
			$classes[] = 'pagebuilder-active';
		} else {
			$classes[] = 'pagebuilder-not-active';
		}

		if (isSet($page_data['pagemeta_pagestyle'][0])) {
			$pagestyle = $page_data['pagemeta_pagestyle'][0];
			if ($pagestyle=="rightsidebar") {
				$classes[] = "rightsidebar";
				$classes[] = "page-has-sidebar";
			}
			if ($pagestyle=="leftsidebar") {
				$classes[] = "leftsidebar";
				$classes[] = "page-has-sidebar";
			}
			if ($pagestyle=="nosidebar") {
				$classes[] = "nosidebar";
			}
			if ($pagestyle=="edge-to-edge") {
				$classes[] = "edge-to-edge";
			}
		} else {
			$classes[] = "sidebar-not-set";
		}
	}

	return $classes;
}
add_filter( 'body_class', 'kreativa_body_class' );
//@ Page Menu
function kreativa_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'kreativa_page_menu_args' );
/*-------------------------------------------------------------------------*/
/* Excerpt Lenght */
/*-------------------------------------------------------------------------*/
function kreativa_excerpt_length($length) {
	return 80;
}
add_filter('excerpt_length', 'kreativa_excerpt_length');
// Open Graph
if( kreativa_get_option_data('opengraph_status') ) {
	add_filter('language_attributes', 'kreativa_opengraph_doctype');
	add_action( 'wp_head', 'kreativa_add_og_metatags', 5 );
}
/**
 * Register Sidebars.
 */
function kreativa_widgets_init() {
	// Default Sidebar
	register_sidebar(array(
		'name' => esc_html__('Default Sidebar','kreativa'),
		'id' => 'default_sidebar',
		'description' => esc_html__('Default sidebar selected for pages, blog posts and archives.','kreativa'),
		'before_widget' => '<div class="sidebar-widget"><aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	// Default Portfolio Sidebar
	register_sidebar(array(
		'name' => esc_html__('Default Portfolio Sidebar','kreativa'),
		'id' => 'portfolio_sidebar',
		'description' => esc_html__('Default sidebar for portfolio pages.','kreativa'),
		'before_widget' => '<div class="sidebar-widget"><aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));	// Default Portfolio Sidebar
	register_sidebar(array(
		'name' => esc_html__('Default Events Sidebar','kreativa'),
		'id' => 'events_sidebar',
		'description' => esc_html__('Default sidebar for events pages.','kreativa'),
		'before_widget' => '<div class="sidebar-widget"><aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	if ( class_exists( 'woocommerce' ) ) {
		// Default WooCommerce Sidebar
		register_sidebar(array(
			'name' => esc_html__('Default WooCommerce Sidebar','kreativa'),
			'id' => 'woocommerce_sidebar',
			'description' => esc_html__('Default sidebar for woocommerce pages.','kreativa'),
			'before_widget' => '<div class="sidebar-widget"><aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside></div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>',
		));
	}

	// Dynamic Sidebar
	$max_sidebars = kreativa_get_max_sidebars();
	for ($sidebar_count=1; $sidebar_count <= $max_sidebars; $sidebar_count++ ) {
		if ( kreativa_get_option_data('mthemesidebar-'.$sidebar_count) <> "" ) {
			register_sidebar(array(
				'name' => esc_html( kreativa_get_option_data('mthemesidebar-'.$sidebar_count) ),
				'description' => esc_html( kreativa_get_option_data('theme_sidebardesc'.$sidebar_count) ),
				'id' => 'mthemesidebar-' . esc_attr($sidebar_count),
				'before_widget' => '<div class="sidebar-widget"><aside id="%1$s" class="widget %2$s">',
				'after_widget' => '</aside></div>',
				'before_title' => '<h3>',
				'after_title' => '</h3>',
			));
		}
	}

	register_sidebar(array(
		'name' => esc_html__('Menu Social','kreativa'),
		'id' => 'social_header',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
	// Mobile Menu
	register_sidebar(array(
		'name' => esc_html__('Mobile Social','kreativa'),
		'id' => 'mobile_social_header',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));

}
add_action( 'widgets_init', 'kreativa_widgets_init' );
/*-------------------------------------------------------------------------*/
/* Core Libraries */
/*-------------------------------------------------------------------------*/
function kreativa_load_core_libaries() {
	require_once (get_template_directory() . '/framework/admin/tgm/class-tgm-plugin-activation.php');
	require_once (get_template_directory() . '/framework/admin/tgm/tgm-init.php');
}
/*-------------------------------------------------------------------------*/
/* Theme Specific Libraries */
/*-------------------------------------------------------------------------*/
add_action('init','kreativa_load_theme_metaboxes');
function kreativa_load_theme_metaboxes() {
	require_once (get_template_directory() . '/framework/metaboxgen/metaboxgen.php');
	require_once (get_template_directory() . '/framework/metaboxes/page-metaboxes.php');
	require_once (get_template_directory() . '/framework/metaboxes/client-metaboxes.php');
	require_once (get_template_directory() . '/framework/metaboxes/post-metaboxes.php');
	require_once (get_template_directory() . '/framework/metaboxes/portfolio-metaboxes.php');
	require_once (get_template_directory() . '/framework/metaboxes/fullscreen-metaboxes.php');
	require_once (get_template_directory() . '/framework/metaboxes/events-metaboxes.php');
	require_once (get_template_directory() . '/framework/metaboxes/woocommerce-metaboxes.php');
	require_once (get_template_directory() . '/framework/metaboxes/proofing-metaboxes.php');
}
/*-------------------------------------------------------------------------*/
/* Load Constants : Core Libraries : Update Notifier*/
/*-------------------------------------------------------------------------*/
kreativa_load_core_libaries();
/* Custom ajax loader */
add_filter('wpcf7_ajax_loader', 'kreativa_wpcf7_ajax_loader_icon');
function kreativa_wpcf7_ajax_loader_icon () {
	return  get_template_directory_uri() . '/images/preloader.png';
}

// WooCommerce Plugin is active.
if ( class_exists( 'woocommerce' ) ) {
	
	add_theme_support( 'woocommerce' );

	add_action('admin_init','kreativa_update_woocommerce_images');
	function kreativa_update_woocommerce_images() {
		global $pagenow;
		if( is_admin() && isset($_GET['activated']) && 'themes.php' == $pagenow ) {
			update_option('shop_catalog_image_size', array('width' => 300, 'height' => '', 0));
			update_option('shop_single_image_size', array('width' => 500, 'height' => '', 0));
			update_option('shop_thumbnail_image_size', array('width' => 180, 'height' => '', 0));
		}
	}

	add_action( 'woocommerce_before_shop_loop_item_title', 'kreativa_woocommerce_template_loop_second_product_thumbnail', 11 );
	// Display the second thumbnail on Hover
	function kreativa_woocommerce_template_loop_second_product_thumbnail() {
		global $product, $woocommerce;

		$attachment_ids = $product->get_gallery_image_ids();

		if ( $attachment_ids ) {
			$secondary_image_id = $attachment_ids['0'];
			echo wp_get_attachment_image( $secondary_image_id, 'shop_catalog', '', $attr = array( 'class' => 'mtheme-secondary-thumbnail-image attachment-shop-catalog woo-thumbnail-fadeOutUp' ) );
		}
	}

	if ( !is_admin() ) {
		add_filter( 'post_class', 'kreativa_product_has_many_images' );
	}
	// Add class to products that have a gallery
	function kreativa_product_has_many_images( $classes ) {
		global $product;

		$post_type = get_post_type( get_the_ID() );

		if ( $post_type == 'product' ) {

			$attachment_ids = $product->get_gallery_image_ids();
			if ( $attachment_ids ) {
				$secondary_image_id = $attachment_ids['0'];
				$classes[] = 'mtheme-hover-thumbnail';
			}
		}

		return $classes;
	}
	// Remove sidebars from Woocommerce generated pages
	function kreativa_woo_remove_sidebar_shop() {
		$shop_layout = false;
		$shop_layout = kreativa_get_option_data('mtheme_wooarchive_sidebar');
		if (kreativa_is_in_demo()) {
			if ( false != kreativa_demo_get_data('woo_style') ) {
				$shop_layout = kreativa_demo_get_data('woo_style');
			}
		}
		if ( is_shop() && !$shop_layout ) {
	    	remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar');
	    }
	    if ( is_product_category() && !$shop_layout ) {
	    	remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar');
	    }
	    if ( is_product() ) {
	    	remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar');
	    }
	}
	
	add_action('template_redirect', 'kreativa_woo_remove_sidebar_shop');

	add_filter( 'woocommerce_breadcrumb_home_url', 'kreativa_woo_custom_breadrumb_home_url' );
	function kreativa_woo_custom_breadrumb_home_url() {
		$home_url_path = home_url('/shop/');
		$home_url_path = esc_url($home_url_path);
		return $home_url_path;
	}
	function kreativa_woocommerce_category_add_to_products(){

	    $product_cats = wp_get_post_terms( get_the_ID(), 'product_cat' );

	    if ( $product_cats && ! is_wp_error ( $product_cats ) ){

	        $single_cat = array_shift( $product_cats );

	        echo '<h4 itemprop="name" class="product_category_title"><span>'. $single_cat->name . '</span></h4>';

		}
	}
	add_action( 'woocommerce_single_product_summary', 'kreativa_woocommerce_category_add_to_products', 2 );
	add_action( 'woocommerce_before_shop_loop_item_title', 'kreativa_woocommerce_category_add_to_products', 12 );

	function kreativa_remove_cart_button_from_products_arcvhive(){
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
	}

	function kreativa_remove_archive_titles() {
		return false;
	}
	add_filter('woocommerce_show_page_title', 'kreativa_remove_archive_titles');

	add_action( 'wp_enqueue_scripts', 'kreativa_remove_woocommerce_styles', 99 );
	function kreativa_remove_woocommerce_styles() {
		wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
		wp_dequeue_script( 'prettyPhoto-init' );
	}

	// Display 12 products per page.
	add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 12;' ), 20 );

	// Change number or products per row to 3
	add_filter('loop_shop_columns', 'kreativa_loop_columns');
	if (!function_exists('kreativa_loop_columns')) {
		function kreativa_loop_columns() {
			$product_count = 4;
			return $product_count;
		}
	}

	// Remove rating from archives
	function kreativa_remove_ratings_loop(){
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
	}
	add_action('init','kreativa_remove_ratings_loop');

	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
}
?>