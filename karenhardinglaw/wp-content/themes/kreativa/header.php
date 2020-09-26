<?php
/*
* @ Header
*/
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php
	wp_head();
	?>
</head>
<body <?php body_class(); ?>>
<?php
$site_in_maintenance = kreativa_maintenance_check();
do_action('kreativa_contextmenu_msg');
if ( !kreativa_menu_is_horizontal() ) {
	echo kreativa_display_elementloader();
}
do_action('kreativa_preloader');
do_action('kreativa_page_necessities');
//Mobile menu
if ( !kreativa_is_fullscreen_home() && !is_404() ) {
	if (!$site_in_maintenance) {
		get_template_part('/includes/background/background','display');
	}
}
if ( kreativa_is_fullscreen_home() ) {
	if (!$site_in_maintenance) {
		$featured_page=kreativa_get_active_fullscreen_post();
		$custom = get_post_custom( $featured_page );
		if ( isSet($custom[ "pagemeta_fullscreen_type"][0]) ) {
			$fullscreen_type = $custom[ "pagemeta_fullscreen_type"][0];
			if ($fullscreen_type=="photowall" || $fullscreen_type=="carousel" ) {
				get_template_part('/includes/background/background','display');
			}
		}
	}
}
do_action('kreativa_social_screen');
if (is_page_template('template-blank.php')) {

	$site_layout_width='fullwidth';

} else {
	if (!$site_in_maintenance) {
		get_template_part('template-parts/menu/mobile','menu');
		//Header Navigation elements
		get_template_part('template-parts/header','navigation');
		//get_template_part('template-parts/menu/vertical','menu');
	}
}

echo '<div id="home" class="container-wrapper container-fullwidth">';
if (!kreativa_is_fullscreen_post()) {
	echo '<div class="vertical-menu-body-container">';
}
if (!is_page_template('template-blank.php') && !kreativa_is_fullscreen_post() ) {
	if (!$site_in_maintenance) {
		get_template_part('template-parts/header','title');
	}
}
$post_type = get_post_type( get_the_ID() );
$custom = get_post_custom( get_the_ID() );
$mtheme_pagestyle='';
if (isset($custom['pagemeta_pagestyle'][0])) { $mtheme_pagestyle=$custom['pagemeta_pagestyle'][0]; }
if (!kreativa_is_fullscreen_post()) {
	echo '<div class="container clearfix">';
}
?>