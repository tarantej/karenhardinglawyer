<div class="vertical-menu-outer">
<div class="vertical-menu-wrap">
<div class="vertical-menu clearfix">
	<div class="vertical-logo-wrap">
			<?php
			$vmain_logo=kreativa_get_option_data('vmain_logo');
			$theme_style=kreativa_get_option_data('theme_style');
			if (kreativa_is_in_demo()) {
				if ( false != kreativa_demo_get_data('theme_style') ) {
					$theme_style = kreativa_demo_get_data('theme_style');
				}
			}

			if ( $vmain_logo <> "" ) {
					$menu_logo = '<img class="vertical-logoimage" src="'.esc_url($vmain_logo).'" alt="logo" />';
			} else {
					if ($theme_style=="dark") {
						$menu_logo = '<img class="vertical-logoimage" src="'.esc_url(get_template_directory_uri() . '/images/logo_dark_v.png').'" alt="logo" />';
					} else {
						$menu_logo = '<img class="vertical-logoimage" src="'.esc_url(get_template_directory_uri() . '/images/logo_bright_v.png').'" alt="logo" />';
					}
			}
			$home_url_path = home_url('/');
			echo '<a href="'.esc_url($home_url_path).'">' . $menu_logo . '</a>';
			?>
	</div>
	<?php
	$wpml_lang_selector_enable= kreativa_get_option_data('wpml_lang_selector_enable');
	if ($wpml_lang_selector_enable) {
		if ( function_exists('icl_object_id') ) {
	?>
	<div class="mobile-wpml-lang-selector-wrap">
		<?php do_action('icl_language_selector'); ?>
	</div>
	<?php
		}
	}
	?>
	<nav>
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
	// Responsive menu conversion to drop down list
	if ( function_exists('wp_nav_menu') ) { 
		wp_nav_menu( array(
		 'container' =>false,
		 'theme_location' => 'main_menu',
		 'menu' => $custom_menu_call,
		 'menu_class' => 'mtree',
		 'echo' => true,
		 'before' => '',
		 'after' => '',
		 'link_before' => '',
		 'link_after' => '',
		 'depth' => 0,
		 'fallback_cb' => 'mtheme_nav_fallback'
		 )
		);
	}
	?>
	</nav>

	<?php
	$footer_vmenu = nl2br( kreativa_get_option_data( 'footer_vmenu' ) );
	if ( is_active_sidebar( 'social_header' ) || $footer_vmenu<>"" ) {
	?>
	<div class="vertical-footer-wrap">
		<?php
		if ( is_active_sidebar( 'social_header' ) ) {
		?>
		<div class="fullscreen-footer-social">
			<div class="login-socials-wrap clearfix">
			<?php
			dynamic_sidebar('social_header');
			?>
			</div>
		</div>
		<?php
		}
		$footer_vmenu = nl2br( kreativa_get_option_data( 'footer_vmenu' ) );
		$allowedtags = array(
		    'a' => array(
		        'href' => true,
		        'title' => true,
		    ),
		    'br' => array(),
		    'b' => array(),
		    'strong' => array(),
		);
		?>
		<div class="vertical-footer-copyright"><?php echo wp_kses($footer_vmenu, $allowedtags); ?></div>
	</div>
	<?php
	}
	if ( kreativa_page_supports_fullscreen() ) {
		echo '<div class="slideshow-control-item mtheme-fullscreen-toggle fullscreen-toggle-off"><i class="feather-icon-plus"></i></div>';
	}
	?>
</div>
</div>
</div>
<?php
if ( kreativa_page_supports_fullscreen() ) {
	echo '<div class="slideshow-control-item mtheme-fullscreen-toggle fullscreen-toggle-offcamera fullscreen-toggle-off"><i class="feather-icon-plus"></i></div>';
}
?>