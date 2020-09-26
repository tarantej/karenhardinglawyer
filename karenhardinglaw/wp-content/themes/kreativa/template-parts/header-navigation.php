<?php
$custom_menu_call = '';
if ( is_singular() ) {
	$user_choice_of_menu = get_post_meta( get_the_id() , 'pagemeta_menu_choice', true);
	if ( kreativa_page_is_woo_shop() ) {
		$woo_shop_post_id = get_option( 'woocommerce_shop_page_id' );
		$user_choice_of_menu = get_post_meta( $woo_shop_post_id , 'pagemeta_menu_choice', true);
	}
	if ( isSet($user_choice_of_menu) && $user_choice_of_menu <> "default") {
		$custom_menu_call = $user_choice_of_menu;
	}
}
$theme_menu_type = kreativa_get_option_data('header_menu_type');
if (kreativa_is_in_demo()) {
	if ( false != kreativa_demo_get_data('menu_type') ) {
		$theme_menu_type = kreativa_demo_get_data('menu_type');
	}
}

$menu_class = "sf-menu";
if ($theme_menu_type=="minimal-menu") {
	$menu_class = "mtree";
}
$the_menu = wp_nav_menu( array(
	'container' =>false,
	'menu' => $custom_menu_call,
	'theme_location' => 'main_menu',
	'menu_class' => $menu_class,
	'echo' => false,
	'before' => '',
	'after' => '',
	'link_before' => '',
	'link_after' => '',
	'depth' => 0,
	'fallback_cb' => 'mtheme_nav_fallback'
	)
);
if ($theme_menu_type == "minimal-menu") {
?>
<div class="simple-menu">
	<?php
	// WPML
	$wpml_lang_selector_enable= kreativa_get_option_data('wpml_lang_selector_enable');
	if ($wpml_lang_selector_enable) {
	?>
	<div class="mobile-wpml-lang-selector-wrap">
		<div class="flags_language_selector"><?php kreativa_language_selector_flags(); ?></div >
	</div>
	<?php
	}
	?>
	<nav>
	<?php
	if ( isSet($the_menu) ) {
		echo $the_menu;
	}
	?>
	</nav>
	<div class="mobile-social-header">
	<?php 
	dynamic_sidebar("mobile_social_header");
	?>
	</div>
	<div class="cleafix"></div>
</div>
<?php
}

function kreativa_main_menu_logo($header_menu_type="header-middle") {
	$header_menu_type = kreativa_get_option_data('header_menu_type');
	if (kreativa_is_in_demo()) {
		if ( false != kreativa_demo_get_data('menu_type') ) {
			$header_menu_type = kreativa_demo_get_data('menu_type');
		}
	}
	$logo_element = '';
	$sticky_main_logo=kreativa_get_option_data('sticky_main_logo');
	$sticky_logo_class='';
	if ($sticky_main_logo<>"") {
		$sticky_logo_class = " sticky-alt-logo-present";
	}
	$logo_element .= '<div class="header-logo-section">';
		$logo_element .= '<div class="logo'.$sticky_logo_class.'">';
			
			$home_url_path = home_url('/');
			$logo_element .= '<a href="'.esc_url($home_url_path).'">';

				$theme_style=kreativa_get_option_data('theme_style');
				if (kreativa_is_in_demo()) {
					if ( false != kreativa_demo_get_data('theme_style') ) {
						$theme_style = kreativa_demo_get_data('theme_style');
					}
				}
				$main_logo=kreativa_get_option_data('main_logo');
				if ( $main_logo <> "" ) {
					$logo_element .= '<img class="logo-theme-main logo-theme-custom" src="'.esc_url($main_logo).'" alt="logo" />';
				} else {
					if ($theme_style=="light") {
						$demo_logo_image = 'logo_responsive.png';
						$logo_element .= '<img class="logo-theme-main logo-theme-primary logo-theme-dark" src="'.get_template_directory_uri() . '/images/'.$demo_logo_image.'" alt="logo" />';
					} else {
						$demo_logo_image = 'logo_responsive_alt.png';
						$logo_element .= '<img class="logo-theme-main logo-theme-primary logo-theme-dark" src="'.get_template_directory_uri() . '/images/'.$demo_logo_image.'" alt="logo" />';
					}
				}

			$logo_element .= '</a>';
		$logo_element .= '</div>';
	$logo_element .= '</div>';
	return $logo_element;
}
if ( kreativa_page_supports_fullscreen() ) {
	echo '<div class="slideshow-control-item mtheme-fullscreen-toggle fullscreen-toggle-off"><i class="feather-icon-plus"></i></div>';
}
if ( !kreativa_menu_is_horizontal() ) {
	get_template_part('template-parts/menu/vertical','menu');
} else {
	?>
	<div class="outer-wrap stickymenu-zone">
	<?php
	$header_menu_top=kreativa_get_option_data('header_menu_top');
	if (kreativa_is_in_demo()) {
		if ( false != kreativa_demo_get_data('headermenutop') ) {
			$header_menu_top = kreativa_demo_get_data('headermenutop');
		}
	}
	?>
	<?php
	// WPML
	$wpml_lang_selector_enable= kreativa_get_option_data('wpml_lang_selector_enable');
	if ($wpml_lang_selector_enable) {
	?>
	<div class="wpml-lang-selector-wrap">
		<div class="flags_language_selector"><?php kreativa_language_selector_flags(); ?></div >
	</div>
	<?php
	}
	?>
		<div class="outer-header-wrap clearfix">
			<nav>
<?php
	$header_menu_type = kreativa_get_option_data('header_menu_type');
	if (kreativa_is_in_demo()) {
		if ( false != kreativa_demo_get_data('menu_type') ) {
			$header_menu_type = kreativa_demo_get_data('menu_type');
		}
	}
	$adjustable = '';
	if ($header_menu_type == "left-logo") {
		$adjustable = "fullpage-item";
	}
?>
				<div class="mainmenu-navigation <?php echo esc_attr($adjustable); ?> clearfix">
						<?php
						$header_menu_type = kreativa_get_option_data('header_menu_type');
						if ($header_menu_type=="" || !isSet($header_menu_type) ) {
							$header_menu_type="split-menu";
						}
						echo kreativa_main_menu_logo($header_menu_type);
						if ($theme_menu_type <> "minimal-menu") {
							if ( has_nav_menu( "main_menu" ) ) {
							?>
								<div class="homemenu">
							<?php
								if ( isSet($the_menu) ) {
									echo $the_menu;
								}
							?>
							</div>
							<?php
							}
						}
						?>
						<div class="menu-social-header">
						<?php 
						dynamic_sidebar("social_header");
						?>
						</div>
				</div>
			</nav>
			<?php
			if ( kreativa_menu_is_horizontal() ) {
				echo kreativa_display_elementloader();
			}
			?>
		</div>
	</div>
	<?php
}
?>