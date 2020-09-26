<?php
/**
*  Sidebar
 */
?>
<?php
$mtheme_pagestyle="rightsidebar";
if ( is_singular() ) {
	$mtheme_pagestyle= get_post_meta(get_the_id(), 'pagemeta_pagestyle', true);
	$floatside="float-left";
	if ($mtheme_pagestyle=="nosidebar") { $floatside=""; }
	if ($mtheme_pagestyle=="rightsidebar") { $floatside="float-left"; }
	if ($mtheme_pagestyle=="leftsidebar") { $floatside="float-right"; }

	if ( !isSet($mtheme_pagestyle) || $mtheme_pagestyle=="" ) {
		$mtheme_pagestyle="rightsidebar";
		$floatside="float-left";
	}
	if ( $mtheme_pagestyle=="edge-to-edge") {
		$floatside='';
		$mtheme_pagestyle='nosidebar';
	}
	$mtheme_sidebar_choice= get_post_meta(get_the_id(), 'pagemeta_sidebar_choice', true);
}
if ( kreativa_page_is_woo_shop() ) {
	$woo_shop_post_id = get_option( 'woocommerce_shop_page_id' );
	$mtheme_sidebar_choice= get_post_meta($woo_shop_post_id, 'pagemeta_sidebar_choice', true);
}
if ( !is_singular() ) {
	if ( kreativa_page_is_woo_shop() ) {
	} else {
		unset($mtheme_sidebar_choice);
	}
}
if ( kreativa_page_is_woo_shop() ) {
	$woo_shop_post_id = get_option( 'woocommerce_shop_page_id' );
	$mtheme_pagestyle = get_post_meta($woo_shop_post_id, 'pagemeta_pagestyle', true);
}
$sidebar_position="sidebar-float-right";
if ($mtheme_pagestyle=="rightsidebar") { $sidebar_position = 'sidebar-float-right'; }
if ($mtheme_pagestyle=="leftsidebar") { $sidebar_position = 'sidebar-float-left'; }
?>
<div id="sidebar" class="sidebar-wrap sidebar-wrap<?php if ( is_single() || is_page() ) { echo "-single"; } ?> <?php echo esc_attr($sidebar_position); ?>">
		<div class="sidebar clearfix">
			<!-- begin Dynamic Sidebar -->
			<?php
			if ( !isset($mtheme_sidebar_choice) || empty($mtheme_sidebar_choice) ) {
				$mtheme_sidebar_choice="default_sidebar";
			}
			if ( class_exists( 'woocommerce' ) ) {
				if (is_shop()) {
					$mtheme_sidebar_choice="woocommerce_sidebar";
				}
			}
			if ( class_exists( 'woocommerce' ) ) {
				if ( is_product_category() ) {
	    			$mtheme_sidebar_choice="woocommerce_sidebar";
	    		}
	    	}
			?>
			<?php
			if ( is_active_sidebar( $mtheme_sidebar_choice ) ) {
				dynamic_sidebar($mtheme_sidebar_choice);
			}
			?>
	</div>
</div>