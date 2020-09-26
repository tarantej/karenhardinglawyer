<div class="responsive-menu-wrap">
	<nav id="mobile-toggle-menu" class="mobile-toggle-menu mobile-toggle-menu-close">
		<span class="mobile-toggle-menu-trigger"><span>Menu</span></span>
	</nav>
	<div class="mobile-menu-toggle">
				<div class="logo-mobile">
						<?php
						$main_logo=kreativa_get_option_data('vmain_logo');
						$responsive_logo=kreativa_get_option_data('responsive_logo');
						$theme_style=kreativa_get_option_data('theme_style');

						if ($main_logo<>"" && $responsive_logo=="") {
							$responsive_logo = $main_logo;
						}

						if (kreativa_is_in_demo()) {
							if ( false != kreativa_demo_get_data('theme_style') ) {
								$theme_style = kreativa_demo_get_data('theme_style');
							}
						}

						if ($responsive_logo<>"") {
							$mobile_logo = '<img class="custom-responsive-logo logoimage" src="'.esc_url($responsive_logo).'" alt="logo" />';
						} else {
							if ( $theme_style == "light" ) {
								$mobile_logo = '<img class="logoimage" src="'.esc_url(get_template_directory_uri() . '/images/logo_responsive.png').'" alt="logo" />';
							} else {
								$mobile_logo = '<img class="logoimage" src="'.esc_url(get_template_directory_uri() . '/images/logo_responsive_alt.png').'" alt="logo" />';
							}
						}
						$home_url_path = home_url('/');
						echo '<a href="'.esc_url($home_url_path).'">' . $mobile_logo . '</a>';
						?>
				</div>
	</div>
</div>
<div class="responsive-menu-overlay"></div>
<div class="responsive-mobile-menu">
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
	$custom_menu_call = '';
	$user_choice_of_menu = get_post_meta( get_the_id() , 'pagemeta_menu_choice', true);
	if ( kreativa_page_is_woo_shop() ) {
		$woo_shop_post_id = get_option( 'woocommerce_shop_page_id' );
		$user_choice_of_menu = get_post_meta( $woo_shop_post_id , 'pagemeta_menu_choice', true);
	}
	if ( isSet($user_choice_of_menu) && $user_choice_of_menu <> "default") {
		$custom_menu_call = $user_choice_of_menu;
	}
	// Responsive menu conversion to drop down list
	if ( function_exists('wp_nav_menu') ) { 
		wp_nav_menu( array(
		 'container' =>false,
		 'theme_location' => 'mobile_menu',
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
	$allowedtags = array(
	    'a' => array(
	        'href' => true,
	        'title' => true,
	    ),
	    'br' => array(),
	    'b' => array(),
	    'strong' => array(),
	);
	if ( is_active_sidebar( 'social_header' ) || $footer_vmenu<>"" ) {
	?>
	<div class="vertical-footer-wrap">
		<?php
		if ( is_active_sidebar( 'mobile_social_header' ) ) {
		?>
		<div class="fullscreen-footer-social">
			<div class="login-socials-wrap clearfix">
			<?php
			dynamic_sidebar('mobile_social_header');
			?>
			</div>
		</div>
		<?php
		}
		?>
		<div class="vertical-footer-copyright"><?php echo wp_kses($footer_vmenu, $allowedtags); ?></div>
	</div>
	<?php
	}
	?>
	<div class="cleafix"></div>
</div>