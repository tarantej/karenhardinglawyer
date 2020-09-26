<?php
function kreativa_generate_background_css ($the_image) {
	$background_tag = false;
	if ($the_image) {
		if ($the_image<>"") {
			$background_tag = '.site-back-cover { background-image: url('.esc_url($the_image).'); }';
		}
	}
	if ( is_404() ) {
		$background_tag .= '.error404 .container-wrapper{ background: none; }';
	}
	return $background_tag;
}
$dynamic_css='';
if ( is_singular() ) {
	$bg_choice= get_post_meta( get_the_id(), 'kreativa_meta_background_choice', true);
	$image_link=kreativa_featured_image_link( get_the_id() );

	$page_data = get_post_custom( get_the_id() );
	if (isSet($page_data['pagemeta_pagestyle'][0])) {
		$pagestyle = $page_data['pagemeta_pagestyle'][0];
		if ($pagestyle=="split-page") {
			$split_page_image_url = kreativa_featured_image_link( get_the_id() );
			if ( isSet($split_page_image_url) ) {
				$dynamic_css .= '.split-page-image { background-image: url('.esc_url($split_page_image_url).'); }';
			}
		}
	}
	if ( post_password_required () && is_singular('mtheme_events') ) {
		$image_link=kreativa_featured_image_link( get_the_id() );
		$dynamic_css .= kreativa_generate_background_css ($image_link);
	}
	if ( post_password_required () && is_singular('mtheme_portfolio') ) {
		$image_link=kreativa_featured_image_link( get_the_id() );
		$dynamic_css .= kreativa_generate_background_css ($image_link);
	}
}
if ( is_404() ) {
	$bg_choice= "featured_image";
	$image_link = kreativa_get_option_data('general_404_image');

	$text_404_color = kreativa_get_option_data('text_404_color');
	$dynamic_css .= '
	.mtheme-404-wrap .mtheme-404-error-message1,
	.entry-content .mtheme-404-wrap h4,
	.mtheme-404-wrap .mtheme-404-icon i,
	.mtheme-404-wrap #searchbutton i,
	.mtheme-404-wrap #searchform input { color:'.$text_404_color.';}';

	$dynamic_css .= kreativa_change_class('.mtheme-404-wrap #searchform input','border-color',$text_404_color,'');
}
$site_in_maintenance = kreativa_maintenance_check();
if ( $site_in_maintenance ) {
	$maintenance_image_link= kreativa_get_option_data('maintenance_bg');
	$dynamic_css .= kreativa_generate_background_css ($maintenance_image_link);
}
$maintenance_color=kreativa_get_option_data('maintenance_color');
if ($maintenance_color) {
	$dynamic_css .= "
	.site-maintenance-text {
	color:".$maintenance_color.";
	}
	";
}
if (!isSet($bg_choice) ) {
	$bg_choice="options_image";
}

if (isSet($fullscreen_slideshowpost)) {
	if ($fullscreen_slideshowpost != "none" && $fullscreen_slideshowpost<>"") {
		$bg_choice="Fullscreen Post Slideshow";
	}
}
if ( is_archive() || is_search() ) {
	if (!isSet( $_GET['photostock'] ) ) {
		$image_link= kreativa_get_option_data('general_background_image');
		$dynamic_css .= kreativa_generate_background_css ($image_link);
	}
}

if ( kreativa_page_is_woo_shop() ) {
	$woo_shop_post_id = get_option( 'woocommerce_shop_page_id' );
	$bg_choice= get_post_meta($woo_shop_post_id, 'pagemeta_meta_background_choice', true);
	$image_link=kreativa_featured_image_link($woo_shop_post_id);
}
if ( is_singular('mtheme_proofing') ) {
	$client_id = get_post_meta( get_the_id() , 'pagemeta_client_names', true);
	if ( isSet($client_id) ) {
		if ( post_password_required($client_id) ) {
			$client_background_image_id = get_post_meta( $client_id , 'pagemeta_client_background_image', true);
			if (isSet($client_background_image_id)) {
				$image_link=$client_background_image_id;
				$dynamic_css .= kreativa_generate_background_css ($image_link);
			}
		}
	}
}
if ( is_singular('mtheme_clients') ) {
	if ( post_password_required() ) {
		$bg_choice="featured_image";
		$client_background_image_id = get_post_meta( get_the_id() , 'pagemeta_client_background_image', true);
		if (isSet($client_background_image_id)) {
			$image_link=$client_background_image_id;
			$dynamic_css .= kreativa_generate_background_css ($image_link);
		} else {
			$image_link = '';
		}
	}
}
if ( !kreativa_is_fullscreen_home()) {
	if ($bg_choice != "none") {
		switch ($bg_choice) {
			case "featured_image" :
				$dynamic_css .= kreativa_generate_background_css ($image_link);
			break;
		}
	}
}
if ( is_singular('mtheme_featured') ) {
	if ( post_password_required() ) {
		$bg_choice="featured_image";
		$image_link=kreativa_featured_image_link(get_the_id());
	}
}
?>
<?php
$heading_classes='
button,
.woocommerce .product h1,
.woocommerce .product h2,
.woocommerce .product h3,
.woocommerce .product h4,
.woocommerce .product h5,
.woocommerce .product h6,
.entry-title-wrap h1,
.entry-content h1,
.entry-content h2,
.entry-content h3,
.entry-content h4,
.entry-content h5,
.entry-content h6,
.blog-grid-element-content .work-details h4,
.blog-grid-element-content .work-details h4 a,
.gridblock-grid-element .boxtitle-hover a,
.homemenu .sf-menu .mega-item .children-depth-0 h6,
.work-details h4 a,
.work-details h4,
.proofing-client-title,
.comment-reply-title,
.woocommerce ul.products li.product h3,
.woocommerce-page ul.products li.product h3,
h1,
h2,
h3,
h4,
h5,
h6,
.sidebar h3,
.entry-title h1,
.portfolio-end-block h2.section-title';

$page_contents_classes='
body,
input,textarea,
.pricing-wrap,
.pricing-table .pricing-row,
.entry-content,
.mtheme-button,
.sidebar-widget,
ul.vertical_images .vertical-images-title,
.section-description, .entry-title-subheading,
#password-protected label,
.wpcf7-form p,
.homemenu .sf-menu .megamenu-textbox,
.mtheme-lightbox .lg-sub-html
';

$hero_title_class = '.hero-text-wrap .hero-title,.hero-text-wrap .hero-subtitle';

$slideshow_title_classes = '.slideshow_title, .static_slideshow_title';
$slideshow_caption_classes = '.slideshow_caption, .static_slideshow_caption';
//Font
if (kreativa_get_option_data('default_googlewebfonts')) {
	$dynamic_css .= kreativa_apply_font ( "page_contents" , $page_contents_classes );
	$dynamic_css .= kreativa_apply_font ( "heading_font" , $heading_classes );
	$dynamic_css .= kreativa_apply_font ( "menu_font" , ".homemenu .sf-menu a, .homemenu .sf-menu,.homemenu .sf-menu ul li a,.responsive-mobile-menu ul.mtree > li > a,.responsive-mobile-menu,.vertical-menu ul.mtree,.vertical-menu ul.mtree a,.vertical-menu ul.mtree > li > a" );
	$dynamic_css .= kreativa_apply_font ( "super_title" , $slideshow_title_classes );
	$dynamic_css .= kreativa_apply_font ( "super_caption" , $slideshow_caption_classes );
	$dynamic_css .= kreativa_apply_font ( "hero_title" , $hero_title_class );
}

//Logo
$logo_height=kreativa_get_option_data('logo_height');
if ($logo_height) {
	$dynamic_css .= '.menu-is-horizontal .logo img { height: '.$logo_height.'px; }';
}
$logo_topmargin=kreativa_get_option_data('logo_topmargin');
if ($logo_topmargin) {
	$dynamic_css .= '.menu-is-horizontal .logo img { top: '.$logo_topmargin.'px; }';
}
$logo_leftmargin=kreativa_get_option_data('logo_leftmargin');
if ($logo_leftmargin) {
	$dynamic_css .= '.menu-is-horizontal .logo img { margin-left: '.$logo_leftmargin.'px; }';
}
$logo_rightmargin=kreativa_get_option_data('logo_rightmargin');
if ($logo_rightmargin) {
	$dynamic_css .= '.menu-is-horizontal .logo img { margin-right: '.$logo_rightmargin.'px; }';
}
//StockPhoto background archive
$stockphoto_header_archiveimage=kreativa_get_option_data('stockphoto_header_archiveimage');
if ($stockphoto_header_archiveimage<>"") {
	$dynamic_css .= '.archive .stockheader-wrap, .tax-phototag .stockheader-wrap, .searching-for-photostock-term .stockheader-wrap { background-image: url('.esc_url($stockphoto_header_archiveimage).'); }';
}
$general_background_color= kreativa_get_option_data('general_background_color');
if ( $general_background_color<>"" ) {
	$dynamic_css .= 'body { background-color: '.$general_background_color.'; }';
}
//Vertical Menu Logo
$verticalmenu_bgimage=kreativa_get_option_data('verticalmenu_bgimage');
if ($verticalmenu_bgimage) {
	$dynamic_css .= 'body .vertical-menu,body.theme-is-light .vertical-menu { background-image: url('.esc_url($verticalmenu_bgimage).'); }';
}
$vlogo_width=kreativa_get_option_data('vlogo_width');
if ($vlogo_width) {
	$dynamic_css .= '.vertical-logoimage { width: '.$vlogo_width.'px; }';
}
$vlogo_topmargin=kreativa_get_option_data('vlogo_topmargin');
if ($vlogo_topmargin) {
	$dynamic_css .= '.vertical-logoimage { margin-top: '.$vlogo_topmargin.'px; }';
}
$vlogo_leftmargin=kreativa_get_option_data('vlogo_leftmargin');
if ($vlogo_leftmargin) {
	$dynamic_css .= '.vertical-logoimage { margin-left: '.$vlogo_leftmargin.'px; }';
}
$responsive_logo_width = kreativa_get_option_data('responsive_logo_width');
if ($responsive_logo_width) {
	$dynamic_css .= '.logo-mobile .logoimage { width: '.$responsive_logo_width.'px; }';
	$dynamic_css .= '.logo-mobile .logoimage { height: auto; }';
}
$responsive_logo_topmargin = kreativa_get_option_data('responsive_logo_topmargin');
if ($responsive_logo_topmargin) {
	$dynamic_css .= '.logo-mobile .logoimage { top: '.$responsive_logo_topmargin.'px; }';
}

$accent_item_color = '
.entry-content > a:hover,
.entry-content p > a:hover,
.project-details a,
.post-single-tags a:hover,
.post-meta-category a:hover,
.post-single-meta a:hover,
.post-navigation a:hover,
.entry-post-title h2 a:hover,
.comment-reply-title small a,
.header-shopping-cart a:hover,
#gridblock-filter-select i,
.entry-content .blogpost_readmore a,
.pricing-table .pricing_highlight .pricing-price,
#wp-calendar tfoot td#prev a,
#wp-calendar tfoot td#next a,
.sidebar-widget .widget_nav_menu a:hover,
.footer-widget .widget_nav_menu a:hover,
.entry-content .faq-toggle-link:before,
.mtheme-knowledgebase-archive ul li:before,
.like-vote-icon,
.readmore-service a,
.work-details h4,
.work-details h4 a:hover,
.service-content h4 a:hover,
.postsummarywrap a:hover,
.toggle-menu-list li a:hover,
.ui-accordion-header:hover .ui-accordion-header-icon:after,
#footer a:hover,
.nav-previous a:hover,
.nav-next a:hover,
.nav-lightbox a:hover,
.entry-content .entry-post-title h2 a:hover,
.woocommerce .mtheme-woocommerce-description-wrap a.add_to_cart_button:hover,
.woocommerce ul.products li.product h3 a:hover,
.woocommerce-page ul.products li.product h3 a:hover,
.woocommerce .woocommerce-info a,
.woocommerce .related h2:hover,
.woocommerce .upsells h2:hover,
.woocommerce .cross-sells h2:hover,
.tagcloud a:hover,
#footer .tagcloud a:hover,
.entry-content .ui-accordion-header:hover .ui-accordion-header-icon:after,
#events_list .recentpost_info .recentpost_title:hover,
#recentposts_list .recentpost_info .recentpost_title:hover,
#popularposts_list .popularpost_info .popularpost_title:hover,
.mtheme-events-carousel .slideshow-box-title a:hover,
.woocommerce .product_meta a:hover,
ul.mtree li.mtree-open > a:hover,
ul.mtree li.mtree-open > a,
ul.mtree li.mtree-active > a:hover,
.header-is-simple.theme-is-light .simple-menu ul.mtree li.mtree-open > a,
.header-is-simple.theme-is-light .responsive-mobile-menu ul.mtree li.mtree-open > a,
.header-is-simple.theme-is-light .simple-menu ul.mtree li.mtree-open > a:hover,
.header-is-simple.theme-is-light .responsive-mobile-menu ul.mtree li.mtree-open > a:hover,
.theme-is-light .simple-menu ul.mtree li.mtree-open > a,
.theme-is-light .responsive-mobile-menu ul.mtree li.mtree-open > a,
ul.mtree li.mtree-active > a,
.entry-content .service-content h4 a:hover,
.slideshow-box-content .slideshow-box-title a:hover,
.project-details-link a:hover,
.entry-content .text-is-dark a:hover,
.event-icon-sep,
.header-is-opaque .social-sharing-toggle:hover i,
.header-is-opaque.fullscreen-slide-dark .social-sharing-toggle:hover i,
.header-is-opaque .stickymenu-zone .social-sharing-toggle:hover i,
.mtheme-lightbox .lg-toolbar .lg-icon:hover,
.mtheme-lightbox .lg-actions .lg-next:hover,
.mtheme-lightbox .lg-actions .lg-prev:hover,
.cart-elements .cart-title:hover,
.theme-is-light .vertical-menu ul.mtree li.mtree-open > a,
#gridblock-filters li a:hover';

$accent_item_background = '
#gridblock-filters li .is-active:after,
#gridblock-filters li a:focus:after,
#gridblock-filters a:focus:after';

$accent_color=kreativa_get_option_data('accent_color');
if ($accent_color) {
	$dynamic_css .= kreativa_change_class($accent_item_color,"color",$accent_color,'');
	$dynamic_css .= kreativa_change_class($accent_item_background,"background-color",$accent_color,'');
}
// Menu colors

$menubar_backgroundcolor=kreativa_get_option_data('menubar_backgroundcolor');
$menubar_backgroundcolor_rgb=kreativa_hex2RGB($menubar_backgroundcolor,true);

$menubar_backgroundopacity ="0.8";
$sticky_menubar_backgroundopacity ="0.8";
$custom_menubar_backgroundopacity=kreativa_get_option_data('menubar_backgroundopacity');
if (isSet($custom_menubar_backgroundopacity) &&  $custom_menubar_backgroundopacity<>"") {
	$menubar_backgroundopacity=$custom_menubar_backgroundopacity/100;
}

$stickymenubar_backgroundopacity=kreativa_get_option_data('stickymenubar_backgroundopacity');
if (isSet($stickymenubar_backgroundopacity) &&  $stickymenubar_backgroundopacity<>"") {
	$sticky_menubar_backgroundopacity=$stickymenubar_backgroundopacity/100;
}

if ($menubar_backgroundcolor<>"") {
	$dynamic_css .= '.menu-is-horizontal .mainmenu-navigation { background:rgba('. $menubar_backgroundcolor_rgb .','.$menubar_backgroundopacity.'); }';
}
$menu_linkcolor=kreativa_get_option_data('menu_linkcolor');
if ($menu_linkcolor) {
	$dynamic_css .= kreativa_change_class('.menu-social-header .social-header-wrap ul li.social-icon i, .social-sharing-toggle , .menu-social-header .social-header-wrap ul li.contact-text a',"color",$menu_linkcolor,'');
	$dynamic_css .= kreativa_change_class('.homemenu > ul > li > a',"color",$menu_linkcolor,'');
	$dynamic_css .= kreativa_change_class('.homemenu .sf-menu li.menu-item a:before',"border-color",$menu_linkcolor,'');
}
$menu_linkhovercolor=kreativa_get_option_data('menu_linkhovercolor');
if ($menu_linkhovercolor) {
	$dynamic_css .= kreativa_change_class('.mobile-social-header .social-header-wrap ul li.social-icon:hover i, .social-sharing-toggle:hover i, .fullscreen-slide-dark .social-sharing-toggle:hover i, .stickymenu-zone .social-sharing-toggle:hover i, .mobile-social-header .social-header-wrap ul li.contact-text:hover a, .menu-social-header .social-header-wrap ul li.social-icon:hover i, .menu-social-header .social-header-wrap ul li.contact-text:hover a',"color",$menu_linkhovercolor,'');
	$dynamic_css .= kreativa_change_class('.homemenu ul li a:hover, .header-cart i:hover,.sticky-menu-activate .homemenu ul li a:hover,.stickymenu-zone.sticky-menu-activate .homemenu ul li a:hover',"color",$menu_linkhovercolor,'');
	$dynamic_css .= kreativa_change_class('.homemenu .sf-menu li.menu-item a:before',"border-color",$menu_linkhovercolor,'');
}

$menu_titlelinkhover_color=kreativa_get_option_data('menu_titlelinkhover_color');
if ($menu_titlelinkhover_color) {
	$dynamic_css .= kreativa_change_class('.mainmenu-navigation .homemenu ul li a:hover',"color",$menu_titlelinkhover_color,'');
}

$menusubcat_bgcolor=kreativa_get_option_data('menusubcat_bgcolor');
if ($menusubcat_bgcolor) {
	$dynamic_css .= kreativa_change_class('.homemenu .sf-menu .mega-item .children-depth-0, .homemenu ul ul',"background",$menusubcat_bgcolor,'');
}

$currentmenu_linkcolor=kreativa_get_option_data('currentmenu_linkcolor');
if ($currentmenu_linkcolor) {
	$dynamic_css .= kreativa_change_class('.homemenu > ul > li.current-menu-item > a,.homemenu .sub-menu li.current-menu-item > a,.mainmenu-navigation .homemenu > ul > li.current-menu-item > a',"color",$currentmenu_linkcolor,'');
}
$currentmenusubcat_linkcolor=kreativa_get_option_data('currentmenusubcat_linkcolor');
if ($currentmenusubcat_linkcolor) {
	$dynamic_css .= kreativa_change_class('.mainmenu-navigation .homemenu ul ul li.current-menu-item > a',"color",$currentmenusubcat_linkcolor,'');
}

$menusubcat_linkcolor=kreativa_get_option_data('menusubcat_linkcolor');
if ($menusubcat_linkcolor) {
	$dynamic_css .= kreativa_change_class('.mainmenu-navigation .homemenu ul ul li a',"color",$menusubcat_linkcolor,'');
}

$menusubcat_linkhovercolor=kreativa_get_option_data('menusubcat_linkhovercolor');
if ($menusubcat_linkhovercolor) {
	$dynamic_css .= kreativa_change_class('.mainmenu-navigation .homemenu ul ul li:hover>a',"color",$menusubcat_linkhovercolor,'');
}
$menusubcat_linkunderlinecolor=kreativa_get_option_data('menusubcat_linkunderlinecolor');
if ($menusubcat_linkunderlinecolor) {
	$dynamic_css .= kreativa_change_class('.homemenu ul.sub-menu > li.menu-item',"border-color",$menusubcat_linkunderlinecolor,'');
}
$menu_parentactive_color=kreativa_get_option_data('menu_parentactive_color');
if ($menu_parentactive_color) {
	$dynamic_css .= kreativa_change_class('.homemenu li.current-menu-item a:before, .homemenu li.current-menu-ancestor a:before ',"background-color",$menu_parentactive_color,'');
}
$menu_search_color=kreativa_get_option_data('menu_search_color');
if ($menu_search_color) {
	$dynamic_css .= kreativa_change_class('.header-search i.icon-search,.header-search i.icon-remove',"color",$menu_search_color,'');
}
$menu_search_hovercolor=kreativa_get_option_data('menu_search_hovercolor');
if ($menu_search_hovercolor) {
	$dynamic_css .= kreativa_change_class('.header-search i.icon-search:hover,.header-search i.icon-remove:hover',"color",$menu_search_hovercolor,'');
}

// Share modal 
$share_bgcolor=kreativa_get_option_data('share_bgcolor');
$share_bgcolor_rgba=kreativa_hex2RGB($share_bgcolor,true);
if ($share_bgcolor) {
	$dynamic_css .= '#social-modal { background:rgba('. $share_bgcolor_rgba .',0.8); }';
}
$share_iconcolor=kreativa_get_option_data('share_iconcolor');
if ($share_iconcolor) {
	$dynamic_css .= kreativa_change_class('#social-modal .page-share li i,.social-modal-cross',"color",$share_iconcolor,'');
}

// Vertical Menu
$vmenubar_bgcolor=kreativa_get_option_data('vmenubar_bgcolor');
$vmenubar_bgcolor_rgba=kreativa_hex2RGB($vmenubar_bgcolor,true);
if ($vmenubar_bgcolor) {
	$more_menuClasses = '.theme-is-light .vertical-menu, .theme-is-light .simple-menu, .theme-is-light .responsive-mobile-menu,';
	$more_menuClasses .= '.theme-is-dark .vertical-menu, .theme-is-dark .simple-menu, .theme-is-dark .responsive-mobile-menu';
	$dynamic_css .= $more_menuClasses .' { background:rgba('. $vmenubar_bgcolor_rgba .',1); }';
}
$vmenubar_linkcolor=kreativa_get_option_data('vmenubar_linkcolor');
if ($vmenubar_linkcolor) {
	$dynamic_css .= kreativa_change_class('.theme-is-light .vertical-menu ul.mtree li li a,.theme-is-dark .vertical-menu ul.mtree li li a,.theme-is-light .vertical-menu ul.mtree a,.theme-is-dark .vertical-menu ul.mtree a,.vertical-menu ul.mtree > li > a, .vertical-menu ul.mtree li.mtree-node > a:before,.theme-is-light .vertical-menu ul.mtree li.mtree-node > a::before,.vertical-menu ul.mtree a',"color",$vmenubar_linkcolor,'');
}
$vmenubar_linkhovercolor=kreativa_get_option_data('vmenubar_linkhovercolor');
if ($vmenubar_linkhovercolor) {
	$dynamic_css .= kreativa_change_class('.vertical-menu ul.mtree li > a:hover,.vertical-menu .social-header-wrap ul li.social-icon:hover i',"color",$vmenubar_linkhovercolor,'');
}
$vmenubar_linkactivecolor=kreativa_get_option_data('vmenubar_linkactivecolor');
if ($vmenubar_linkactivecolor) {
	$dynamic_css .= kreativa_change_class('.vertical-menu ul.mtree li.mtree-active.mtree-open > a,.vertical-menu ul.mtree li.mtree-active.mtree-open > a:hover',"color",$vmenubar_linkactivecolor,'');
}
$vmenubar_socialcolor=kreativa_get_option_data('vmenubar_socialcolor');
if ($vmenubar_socialcolor) {
	$dynamic_css .= kreativa_change_class('.vertical-menu .social-header-wrap ul li.social-icon i,.vertical-menu .social-header-wrap ul li.contact-text,.vertical-menu .social-header-wrap ul li.contact-text a',"color",$vmenubar_socialcolor,'');
}
$vmenubar_copyrightcolor=kreativa_get_option_data('vmenubar_copyrightcolor');
if ($vmenubar_copyrightcolor) {
	$dynamic_css .= kreativa_change_class('.vertical-footer-wrap .fullscreen-footer-info',"color",$vmenubar_copyrightcolor,'');
	$dynamic_css .= '.vertical-footer-wrap .fullscreen-footer-info { border-top-color:'. $vmenubar_copyrightcolor .'; }';
}
$vmenubar_hlinecolor=kreativa_get_option_data('vmenubar_hlinecolor');
if ($vmenubar_hlinecolor) {
	$dynamic_css .= '.vertical-menu ul.mtree a,ul.mtree li.mtree-node > ul > li:last-child { border-bottom-color:'. $vmenubar_hlinecolor .'; }';
}
$vmenubar_footercolor=kreativa_get_option_data('vmenubar_footercolor');
if ($vmenubar_footercolor) {
	$dynamic_css .= '.vertical-footer-copyright,vertical-footer-copyright a,vertical-footer-copyright a:hover { color:'. $vmenubar_footercolor .'; }';
}

$footer_logo_width=kreativa_get_option_data('footer_logo_width');
if ($footer_logo_width) {
	if ($footer_logo_width<>"0") {
		$dynamic_css .= '.footer-logo-image { width:'. $footer_logo_width .'px; }';
	}
}

$vmenu_active_itemcolor=kreativa_get_option_data('vmenu_active_itemcolor');
if ($vmenu_active_itemcolor) {
	$dynamic_css .= kreativa_change_class('ul.mtree li.mtree-open > a:hover, ul.mtree li.mtree-open > a',"color",$vmenu_active_itemcolor,'');
}
$vmenu_itemcolor=kreativa_get_option_data('vmenu_itemcolor');
if ($vmenu_itemcolor) {
	$dynamic_css .= kreativa_change_class('ul.mtree a',"color",$vmenu_itemcolor,'');
}
$vmenu_hover_itemcolor=kreativa_get_option_data('vmenu_hover_itemcolor');
if ($vmenu_hover_itemcolor) {
	$dynamic_css .= kreativa_change_class('ul.mtree li> a:hover,ul.mtree li.mtree-active > a:hover,ul.mtree li.mtree-active > a',"color",$vmenu_hover_itemcolor,'');
}
$vmenu_search_itemcolor=kreativa_get_option_data('vmenu_search_itemcolor');
if ($vmenu_search_itemcolor) {
	$dynamic_css .= kreativa_change_class('.menu-is-vertical .header-search i',"color",$vmenu_search_itemcolor,'');
}
$vmenubar_socialcolor=kreativa_get_option_data('vmenubar_socialcolor');
if ($vmenubar_socialcolor) {
	$dynamic_css .= kreativa_change_class('.menu-is-vertical .vertical-footer-wrap .social-icon a, .menu-is-vertical .vertical-footer-wrap .social-icon i, .menu-is-vertical .vertical-footer-wrap .social-header-wrap ul li.social-icon i, .menu-is-vertical .vertical-footer-wrap .social-header-wrap ul li.contact-text a',"color",$vmenubar_socialcolor,'');
}


// Slideshow Color

$slideshow_title=kreativa_get_option_data('slideshow_title');
if ($slideshow_title) {
	$dynamic_css .= kreativa_change_class( '.slideshow_title', "color",$slideshow_title,'' );
}
$slideshow_captiontxt=kreativa_get_option_data('slideshow_captiontxt');
if ($slideshow_captiontxt) {
	$dynamic_css .= kreativa_change_class( '#slidecaption .slideshow_caption', "color",$slideshow_captiontxt,'' );
}
$slideshow_buttontxt=kreativa_get_option_data('slideshow_buttontxt');
if ($slideshow_buttontxt) {
	$dynamic_css .= kreativa_change_class( '.slideshow_content_link a, .static_slideshow_content_link a', "color",$slideshow_buttontxt,'' );
}
$slideshow_buttonborder=kreativa_get_option_data('slideshow_buttonborder');
if ($slideshow_buttonborder) {
	$dynamic_css .= kreativa_change_class( '.slideshow_content_link a, .static_slideshow_content_link a', "border-color",$slideshow_buttonborder,'' );
}
$slideshow_buttonhover_text=kreativa_get_option_data('slideshow_buttonhover_text');
if ($slideshow_buttonhover_text) {
	$dynamic_css .= kreativa_change_class( '.slideshow_content_link a:hover, .static_slideshow_content_link a:hover', "color",$slideshow_buttonhover_text,'' );
}
$slideshow_buttonhover_bg=kreativa_get_option_data('slideshow_buttonhover_bg');
if ($slideshow_buttonhover_bg) {
	$dynamic_css .= kreativa_change_class( '.slideshow_content_link a:hover, .static_slideshow_content_link a:hover', "background-color",$slideshow_buttonhover_bg,'' );
	$dynamic_css .= kreativa_change_class( '.slideshow_content_link a:hover, .static_slideshow_content_link a:hover', "border-color",$slideshow_buttonhover_bg,'' );
}
$slideshow_captionbg=kreativa_get_option_data('slideshow_captionbg');
$slideshow_captionbg_rgb=kreativa_hex2RGB($slideshow_captionbg,true);
if ($slideshow_captionbg) {
	$dynamic_css .= "#slidecaption {
background: -moz-linear-gradient(top,  rgba(0,0,0,0) 0%, rgba(".$slideshow_captionbg_rgb.",0.55) 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(0,0,0,0)), color-stop(100%,rgba(".$slideshow_captionbg_rgb.",0.55)));
background: -webkit-linear-gradient(top,  rgba(0,0,0,0) 0%,rgba(".$slideshow_captionbg_rgb.",0.55) 100%);
background: -o-linear-gradient(top,  rgba(0,0,0,0) 0%,rgba(".$slideshow_captionbg_rgb.",0.55) 100%);
background: -ms-linear-gradient(top,  rgba(0,0,0,0) 0%,rgba(".$slideshow_captionbg_rgb.",0.55) 100%);
background: linear-gradient(to bottom,  rgba(0,0,0,0) 0%,rgba(".$slideshow_captionbg_rgb.",0.55) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='".$slideshow_captionbg."', endColorstr='".$slideshow_captionbg."',GradientType=0 );
}";
}
$slideshow_transbar=kreativa_get_option_data('slideshow_transbar');
$slideshow_transbar_rgb=kreativa_hex2RGB($slideshow_transbar,true);
if ($slideshow_transbar) {
	$dynamic_css .= "
	#progress-bar {
	background:".$slideshow_transbar.";
	}
	";
}
$slideshow_currthumbnail=kreativa_get_option_data('slideshow_currthumbnail');
if ($slideshow_currthumbnail) {
	$dynamic_css .= kreativa_change_class( 'ul#thumb-list li.current-thumb', "border-color",$slideshow_currthumbnail,'');
}

$menu_text_capitalize=kreativa_get_option_data('menu_text_capitalize');
if ($menu_text_capitalize) {
	$dynamic_css .= '.homemenu .sf-menu a,.vertical-menu,.vertical-menu a { text-transform: uppercase; }';
}
$hmenu_text_size=kreativa_get_option_data('hmenu_text_size');
if ($hmenu_text_size<>"") {
	$dynamic_css .= '.homemenu ul li a,.homemenu ul ul li a,.vertical-menu ul.mtree a, .simple-menu ul.mtree a, .responsive-mobile-menu ul.mtree a, .header-is-simple .responsive-mobile-menu ul.mtree a,.vertical-menu ul.mtree ul.sub-menu a { font-size:'.$hmenu_text_size.'px;}';
	$dynamic_css .= '.vertical-menu ul.mtree a, .simple-menu ul.mtree a, .responsive-mobile-menu ul.mtree a, .header-is-simple .responsive-mobile-menu ul.mtree a,.vertical-menu ul.mtree ul.sub-menu a { line-height:'.$hmenu_text_size.'px;}';
}
$hmenu_text_letterspacing=kreativa_get_option_data('hmenu_text_letterspacing');
if ($hmenu_text_letterspacing<>"") {
	$dynamic_css .= '.homemenu ul li a,.homemenu ul ul li a,.vertical-menu ul.mtree a, .simple-menu ul.mtree a, .responsive-mobile-menu ul.mtree a, .header-is-simple .responsive-mobile-menu ul.mtree a,.vertical-menu ul.mtree ul.sub-menu a { letter-spacing:'.$hmenu_text_letterspacing.'px;}';
}
$hmenu_text_weight=kreativa_get_option_data('hmenu_text_weight');
if ($hmenu_text_weight<>"") {
	$dynamic_css .= '.homemenu ul li a,.homemenu ul ul li a,.vertical-menu ul.mtree a, .simple-menu ul.mtree a, .responsive-mobile-menu ul.mtree a, .header-is-simple .responsive-mobile-menu ul.mtree a,.vertical-menu ul.mtree ul.sub-menu a { font-weight:'.$hmenu_text_weight.';}';
}

$hmenu_item_gap=kreativa_get_option_data('hmenu_item_gap');
if ($hmenu_item_gap<>"") {
	$dynamic_css .= '.homemenu .sf-menu li{ margin-left:'.$hmenu_item_gap.'px;}';
}

$page_opacity_customize=kreativa_get_option_data('page_opacity_customize');
if ($page_opacity_customize) {
	$dynamic_css .= '.container-wrapper, .fullscreen-protected #password-protected { background:'.$page_opacity_customize.'; }';
}
$page_bgcolor=kreativa_get_option_data('page_bgcolor');
if ($page_bgcolor) {
	$dynamic_css .= '.container-wrapper, .fullscreen-protected #password-protected,#fotorama-container-wrap { background:'.$page_bgcolor.'; }';
}
$page_contentscolor=kreativa_get_option_data('page_contentscolor');
if ($page_contentscolor) {
	$dynamic_css .= kreativa_change_class( '.gridblock-four .work-description, .gridblock-three .work-description, .gridblock-two .work-description, .gridblock-one .work-description, .slideshow-box-info .work-description, .entry-content .smaller-content, .entry-content, .woocommerce #tab-description p, .woocommerce .entry-summary div[itemprop="description"], .blog-details-section .the-month, .post-meta-time-archive, #password-protected p, .post-password-form p, #password-protected label, #gridblock-filters .griblock-filters-subcats a, .person h4.staff-position, .gridblock-parallax-wrap .work-description,.woocommerce .entry-summary div[itemprop="description"],.entry-content,.entry-content .pullquote-left,.entry-content .pullquote-right,.entry-content .pullquote-center', "color",$page_contentscolor,'' );
}
$page_contentsheading=kreativa_get_option_data('page_contentsheading');
if ($page_contentsheading) {
$content_headings = '
.woocommerce div.product .product_title,
.woocommerce #content div.product .product_title,
.woocommerce-page div.product .product_title,
.woocommerce-page #content div.product .product_title,
.entry-content h1,
.entry-content h2,
.entry-content h3,
.entry-content h4,
.entry-content h5,
.entry-content h6,
h1.entry-title,
.entry-content h1.section-title,
.work-details h4,
.work-details h4 a,
.client-company a:hover,
.portfolio-share li a:hover,
.min-search .icon-search:hover,
.entry-content .entry-post-title h2 a,
ul.gridblock-listbox .work-details h4 a:hover
';
	$dynamic_css .= kreativa_change_class( $content_headings, "color",$page_contentsheading,'' );
}

$footer_bgcolor=kreativa_get_option_data('footer_bgcolor');
if ($footer_bgcolor) {
	$dynamic_css .= kreativa_change_class( '.footer-section,#copyright.footer-container', "background",$footer_bgcolor,'' );
}
$footer_iconcolor=kreativa_get_option_data('footer_iconcolor');
if ($footer_iconcolor) {
	$dynamic_css .= kreativa_change_class( '#footer .social-icon i', "color",$footer_iconcolor,'important' );
}
$footer_text=kreativa_get_option_data('footer_text');
if ($footer_text) {
	$dynamic_css .= kreativa_change_class( '#copyright,.footer-section,.footer-section .sidebar,.footer-section .contact_address_block .about_info', "color",$footer_text,'' );
}
$footer_link=kreativa_get_option_data('footer_link');
if ($footer_link) {
	$dynamic_css .= kreativa_change_class( '#copyright a,.footer-section a,.footer-section .sidebar-widget a', "color",$footer_link,'' );
}
$footer_linkhover=kreativa_get_option_data('footer_linkhover');
if ($footer_linkhover) {
	$dynamic_css .= kreativa_change_class( '#copyright a:hover,.footer-section a:hover,.footer-section .sidebar-widget a:hover', "color",$footer_linkhover,'' );
}
$footer_hline=kreativa_get_option_data('footer_hline');
if ($footer_hline) {
	$dynamic_css .= kreativa_change_class( '#footer.sidebar ul li', "border-top-color",$footer_hline,'' );
}



$fullscreen_toggle_color = kreativa_get_option_data('fullscreen_toggle_color');
if ($fullscreen_toggle_color) {
	$dynamic_css .= kreativa_change_class( '.menu-toggle',"color", $fullscreen_toggle_color,'' );
}
$fullscreen_toggle_bg = kreativa_get_option_data('fullscreen_toggle_bg');
if ($fullscreen_toggle_bg) {
	$dynamic_css .= kreativa_change_class( '.menu-toggle',"background-color", $fullscreen_toggle_bg,'' );
	$dynamic_css .= kreativa_change_class( '.menu-toggle:after',"border-color", $fullscreen_toggle_bg,'' );
}

$fullscreen_toggle_hovercolor = kreativa_get_option_data('fullscreen_toggle_hovercolor');
if ($fullscreen_toggle_hovercolor) {
	$dynamic_css .= kreativa_change_class( '.menu-toggle:hover',"color", $fullscreen_toggle_hovercolor,'' );
}

$fullscreen_toggle_hoverbg = kreativa_get_option_data('fullscreen_toggle_hoverbg');
if ($fullscreen_toggle_hoverbg) {
	$dynamic_css .= kreativa_change_class( '.menu-toggle:hover',"background-color", $fullscreen_toggle_hoverbg,'' );
	$dynamic_css .= kreativa_change_class( '.menu-toggle:hover:after',"border-color", $fullscreen_toggle_hoverbg,'' );
}

$footer_copyrightbg=kreativa_get_option_data('footer_copyrightbg');
$footer_copyrightbg_rgb=kreativa_hex2RGB($footer_copyrightbg,true);
if ($footer_copyrightbg) {
	$dynamic_css .= '#copyright { background:rgba('. $footer_copyrightbg_rgb .',0.8); }';
}
$footer_copyrighttext=kreativa_get_option_data('footer_copyrighttext');
if ($footer_copyrighttext) {
	$dynamic_css .= kreativa_change_class( '#copyright', "color",$footer_copyrighttext,'' );
}


$sidebar_headingcolor=kreativa_get_option_data('sidebar_headingcolor');
if ($sidebar_headingcolor) {
	$dynamic_css .= kreativa_change_class( '.sidebar h3', "color",$sidebar_headingcolor,'' );
}
$sidebar_linkcolor=kreativa_get_option_data('sidebar_linkcolor');
if ($sidebar_linkcolor) {
	$dynamic_css .= kreativa_change_class( '#recentposts_list .recentpost_info .recentpost_title, #popularposts_list .popularpost_info .popularpost_title,.sidebar a', "color",$sidebar_linkcolor,'' );
}
$sidebar_bgcolor=kreativa_get_option_data('sidebar_bgcolor');
if ($sidebar_bgcolor) {
	$dynamic_css .= kreativa_change_class( '.sidebar-wrap, .sidebar-wrap-single', "background",$sidebar_bgcolor,'' );
}
$sidebar_textcolor=kreativa_get_option_data('sidebar_textcolor');
if ($sidebar_textcolor) {
	$dynamic_css .= kreativa_change_class( '.contact_address_block .about_info, .sidebar-widget #searchform i, #recentposts_list p, #popularposts_list p,.sidebar-widget ul#recentcomments li,.sidebar', "color",$sidebar_textcolor,'' );
}

if ( kreativa_get_option_data('custom_font_css')<>"" ) {
	$dynamic_css .= kreativa_get_option_data('custom_font_css');
}

$photowall_title_color=kreativa_get_option_data('photowall_title_color');
if ($photowall_title_color) {
$dynamic_css .= kreativa_change_class( '.photowall-title', "color",$photowall_title_color,'' );
}

$photowall_description_color=kreativa_get_option_data('photowall_description_color');
if ($photowall_description_color) {
$dynamic_css .= kreativa_change_class( '.photowall-desc', "color",$photowall_description_color,'' );
}

$photowall_hover_titlecolor=kreativa_get_option_data('photowall_hover_titlecolor');
if ($photowall_hover_titlecolor) {
$dynamic_css .= kreativa_change_class( '.photowall-item:hover .photowall-title', "color",$photowall_hover_titlecolor,'' );
}
$photowall_hover_descriptioncolor=kreativa_get_option_data('photowall_hover_descriptioncolor');
if ($photowall_hover_descriptioncolor) {
$dynamic_css .= kreativa_change_class( '.photowall-item:hover .photowall-desc', "color",$photowall_hover_descriptioncolor,'' );
}

$photowall_description_color=kreativa_get_option_data('photowall_description_color');
if ($photowall_description_color) {
$dynamic_css .= kreativa_change_class( '.photowall-desc', "color",$photowall_description_color,'' );
}

// The icons
$forum_icon_css = kreativa_set_fontawesome('fa fa-cubes' , kreativa_get_option_data('forum_icon') , $get_css_code = true );
if ( isSet($forum_icon_css) ) {
	$dynamic_css .= '
	#bbpress-forums ul.forum li.bbp-forum-info:before {
	content:"'.$forum_icon_css.'";
	}
	';
}

$dynamic_css .= stripslashes_deep( kreativa_get_option_data('custom_css') );

// Lightbox
$disable_lightbox_fullscreen=kreativa_get_option_data('disable_lightbox_fullscreen');
if ($disable_lightbox_fullscreen) {
	$dynamic_css .= '.mtheme-lightbox .lg-fullscreen { display:none; }';
}
$disable_lightbox_sizetoggle=kreativa_get_option_data('disable_lightbox_sizetoggle');
if ($disable_lightbox_sizetoggle) {
	$dynamic_css .= '.mtheme-lightbox #lg-actual-size { display:none; }';
}
$disable_lightbox_zoomcontrols=kreativa_get_option_data('disable_lightbox_zoomcontrols');
if ($disable_lightbox_zoomcontrols) {
	$dynamic_css .= '.mtheme-lightbox #lg-zoom-out,.lg-toolbar #lg-zoom-in { display:none; }';
}
$disable_lightbox_autoplay=kreativa_get_option_data('disable_lightbox_autoplay');
if ($disable_lightbox_autoplay) {
	$dynamic_css .= '.mtheme-lightbox .lg-autoplay-button { display:none; }';
}
$disable_lightbox_share=kreativa_get_option_data('disable_lightbox_share');
if ($disable_lightbox_share) {
	$dynamic_css .= '.mtheme-lightbox .lg-share-icon { display:none; }';
}
$disable_lightbox_count=kreativa_get_option_data('disable_lightbox_count');
if ($disable_lightbox_count) {
	$dynamic_css .= '.mtheme-lightbox #lg-counter { display:none; }';
}
$disable_lightbox_title=kreativa_get_option_data('disable_lightbox_title');
if ($disable_lightbox_title) {
	$dynamic_css .= '.mtheme-lightbox .lg-sub-html { display:none !important; }';
}
$lightbox_bgcolor=kreativa_get_option_data('lightbox_bgcolor');
if ($lightbox_bgcolor) {
	$dynamic_css .= '.body .lg-backdrop, .mtheme-lightbox.lg-outer { background:'.$lightbox_bgcolor.'; }';
}
$lightbox_elementbgcolor=kreativa_get_option_data('lightbox_elementbgcolor');
if ($lightbox_elementbgcolor) {
	$dynamic_css .= '.mtheme-lightbox .lg-actions .lg-icon,.mtheme-lightbox .lg-sub-html, .mtheme-lightbox .lg-toolbar { background:'.$lightbox_elementbgcolor.'; }';
}
$lightbox_elementcolor=kreativa_get_option_data('lightbox_elementcolor');
if ($lightbox_elementcolor) {
	$dynamic_css .= '.mtheme-lightbox #lg-counter,.mtheme-lightbox #lg-counter, .mtheme-lightbox .lg-sub-html, .mtheme-lightbox .lg-toolbar .lg-icon, .mtheme-lightbox .lg-actions .lg-next, .mtheme-lightbox .lg-actions .lg-prev { color:'.$lightbox_elementcolor.'; }';
}

// Font size
$copyright_fontsize=kreativa_get_option_data('copyright_fontsize');
if ($copyright_fontsize<>"") {
$dynamic_css .= '
#copyright {
	font-size:'.$copyright_fontsize.'px;
}';
}
$copyright_lineheight=kreativa_get_option_data('copyright_lineheight');
if ($copyright_lineheight<>"") {
$dynamic_css .= '
#copyright {
	line-height:'.$copyright_lineheight.'px;
}';
}
$pagecontent_fontsize=kreativa_get_option_data('pagecontent_fontsize');
if ($pagecontent_fontsize<>"") {
$dynamic_css .= '
.entry-content,
.woocommerce #tab-description p,
.woocommerce .woocommerce-product-details__short-description,
.woocommerce .entry-summary div[itemprop="description"]{
	font-size:'.$pagecontent_fontsize.'px;
}';
}
// Line Height
$pagecontent_lineheight=kreativa_get_option_data('pagecontent_lineheight');
if ($pagecontent_lineheight<>"") {
$dynamic_css .= '
.entry-content,
.woocommerce #tab-description p,
.woocommerce .woocommerce-product-details__short-description,
.woocommerce .entry-summary div[itemprop="description"] {
	line-height:'.$pagecontent_lineheight.'px;
}';
}
// Letter Spacing
$pagecontent_letterspacing=kreativa_get_option_data('pagecontent_letterspacing');
if ($pagecontent_letterspacing<>"") {
$dynamic_css .= '
.entry-content,
.woocommerce #tab-description p,
.woocommerce .woocommerce-product-details__short-description,
.woocommerce .entry-summary div[itemprop="description"] {
	letter-spacing:'.$pagecontent_letterspacing.'px;
}';
}
// Font Weight
$pagecontent_fontweight=kreativa_get_option_data('pagecontent_fontweight');
if ($pagecontent_fontweight<>"") {
$dynamic_css .= '
.entry-content,
.woocommerce #tab-description p,
.woocommerce .woocommerce-product-details__short-description,
.woocommerce .entry-summary div[itemprop="description"] {
	font-weight:'.$pagecontent_fontweight.';
}';
}
//Page Title color
$pagetitle_bgcolor=kreativa_get_option_data('pagetitle_bgcolor');
if ($pagetitle_bgcolor) {
	$dynamic_css .= kreativa_change_class('.entry-title-wrap',"background-color",$pagetitle_bgcolor,'');
}
$pagetitle_color=kreativa_get_option_data('pagetitle_color');
if ($pagetitle_color) {
	$dynamic_css .= kreativa_change_class('h1.entry-title',"color",$pagetitle_color,'');
}
$pagetitle_size=kreativa_get_option_data('pagetitle_size');
if ($pagetitle_size<>"") {
	$dynamic_css .= '.entry-title-wrap h1.entry-title, .single .title-container h1.entry-title { font-size:'.$pagetitle_size.'px; line-height:'.$pagetitle_size.'px; }';
}
$pagetitle_letterspacing=kreativa_get_option_data('pagetitle_letterspacing');
if ($pagetitle_letterspacing<>"") {
	$dynamic_css .= '.entry-title-wrap h1.entry-title, .single .title-container h1.entry-title { letter-spacing:'.$pagetitle_letterspacing.'px; }';
}
$pagetitle_weight=kreativa_get_option_data('pagetitle_weight');
if ($pagetitle_weight<>"") {
	$dynamic_css .= '.entry-title-wrap h1.entry-title, .single .title-container h1.entry-title { font-weight:'.$pagetitle_weight.'; }';
}
//Mobile Menu color
$mobilemenubar_bgcolor=kreativa_get_option_data('mobilemenubar_bgcolor');
if ($mobilemenubar_bgcolor) {
	$dynamic_css .= kreativa_change_class('.theme-is-dark .mobile-menu-toggle,.mobile-menu-toggle,.header-is-simple.theme-is-dark .mobile-menu-icon,.header-is-simple.theme-is-light .mobile-menu-icon',"background-color",$mobilemenubar_bgcolor,'');
}
$mobilemenubar_togglecolor=kreativa_get_option_data('mobilemenubar_togglecolor');
if ($mobilemenubar_togglecolor) {
	$dynamic_css .= kreativa_change_class('.mobile-toggle-menu-trigger span::before, .mobile-toggle-menu-trigger span::after, .mobile-toggle-menu-open .mobile-toggle-menu-trigger span::before, .mobile-toggle-menu-open .mobile-toggle-menu-trigger span::after, .mobile-toggle-menu-trigger span',"background",$mobilemenubar_togglecolor,'');
	$dynamic_css .= kreativa_change_class('.mobile-sharing-toggle',"color",$mobilemenubar_togglecolor,'');
}
$mobilemenu_bgcolor=kreativa_get_option_data('mobilemenu_bgcolor');
if ($mobilemenu_bgcolor) {
	$dynamic_css .= kreativa_change_class('.responsive-mobile-menu,.theme-is-light .responsive-mobile-menu',"background-color",$mobilemenu_bgcolor,'');
	$dynamic_css .= '.theme-is-dark .responsive-mobile-menu #mobile-searchform input { border-color: rgba(255,255,255,0.1); }';
	$dynamic_css .= '.theme-is-light .responsive-mobile-menu #mobile-searchform input { border-color: rgba(0,0,0,0.1); }';
}
$mobilemenu_bgimage=kreativa_get_option_data('mobilemenu_bgimage');
if ($mobilemenu_bgimage) {
	$dynamic_css .= 'body .responsive-mobile-menu,body.theme-is-light .responsive-mobile-menu { background-image: url('.esc_url($mobilemenu_bgimage).'); }';
}
$mobilemenu_texticons=kreativa_get_option_data('mobilemenu_texticons');
$mobilemenu_texticons_rgb=kreativa_hex2RGB($mobilemenu_texticons,true);
if ($mobilemenu_bgcolor) {
	$dynamic_css .= kreativa_change_class('
	.theme-is-light .responsive-mobile-menu ul.mtree li.mtree-node > a::before,
	.theme-is-light .responsive-mobile-menu #mobile-searchform input,
	.theme-is-dark .responsive-mobile-menu #mobile-searchform input,
	.theme-is-light .responsive-mobile-menu ul.mtree li li a,
	.theme-is-light .responsive-mobile-menu ul.mtree li a,
	.header-is-simple.theme-is-light .responsive-mobile-menu ul.mtree li li a,
	.theme-is-dark .responsive-mobile-menu ul.mtree li li a,
	.theme-is-dark .responsive-mobile-menu ul.mtree li a,
	.header-is-simple.theme-is-dark .responsive-mobile-menu ul.mtree li li a,
	.header-is-simple.theme-is-dark .responsive-mobile-menu ul.mtree li a,
	.theme-is-light .responsive-mobile-menu ul.mtree a,
	.header-is-simple.theme-is-light .responsive-mobile-menu ul.mtree a,
	.header-is-simple.theme-is-dark .responsive-mobile-menu ul.mtree a
	',"color",$mobilemenu_texticons,'');
}
$mobilemenu_linecolors=kreativa_get_option_data('mobilemenu_linecolors');
$mobilemenu_linecolors_rgb=kreativa_hex2RGB($mobilemenu_linecolors,true);
if ($mobilemenu_linecolors) {
	$dynamic_css .= kreativa_change_class('.responsive-mobile-menu ul.mtree li.mtree-node > ul > li:last-child,.theme-is-light .responsive-mobile-menu ul.mtree a,.theme-is-dark .responsive-mobile-menu ul.mtree a,.theme-is-light .responsive-mobile-menu #mobile-searchform input,.theme-is-dark .responsive-mobile-menu #mobile-searchform input',"border-color",$mobilemenu_linecolors,'');
	$dynamic_css .= kreativa_change_class('.theme-is-light .responsive-mobile-menu ul.mtree li.mtree-node > a::before,.theme-is-dark .responsive-mobile-menu ul.mtree li.mtree-node > a::before',"color",$mobilemenu_linecolors,'');
}
$mobilemenu_hover=kreativa_get_option_data('mobilemenu_hover');
if ($mobilemenu_hover) {
	$dynamic_css .= kreativa_change_class('
	.theme-is-light .responsive-mobile-menu ul.mtree li li a:hover,
	.theme-is-dark .responsive-mobile-menu ul.mtree li li a:hover,
	.header-is-simple.theme-is-light .responsive-mobile-menu ul.mtree li.mtree-open > a:hover,
	.header-is-simple.theme-is-dark .responsive-mobile-menu ul.mtree li.mtree-open > a:hover,
	.header-is-simple.theme-is-light .responsive-mobile-menu ul.mtree a:hover,
	.header-is-simple.theme-is-dark .responsive-mobile-menu ul.mtree a:hover,
	.header-is-simple.theme-is-light .responsive-mobile-menu ul.mtree li li a:hover,
	.header-is-simple.theme-is-dark .responsive-mobile-menu ul.mtree li li a:hover,
	.theme-is-light .responsive-mobile-menu ul.mtree li > a:hover,
	.theme-is-light .responsive-mobile-menu ul.mtree a:hover,
	.theme-is-dark .responsive-mobile-menu ul.mtree li > a:hover,
	.theme-is-dark .responsive-mobile-menu ul.mtree a:hover',"color",$mobilemenu_hover,'');
}
$mobilemenu_active=kreativa_get_option_data('mobilemenu_active');
if ($mobilemenu_active) {
	$dynamic_css .= kreativa_change_class('
		.header-is-simple.theme-is-light .responsive-mobile-menu ul.mtree li.mtree-open > a,
		.header-is-simple.theme-is-dark .responsive-mobile-menu ul.mtree li.mtree-open > a,
		.theme-is-light .responsive-mobile-menu ul.mtree li.mtree-open > a,
		.theme-is-dark .responsive-mobile-menu ul.mtree li.mtree-open > a',"color",$mobilemenu_active,'');
}
$rcm_font=kreativa_get_option_data('rcm_font');
if ($rcm_font<>"0" && $rcm_font!="Default Font") {
	$dynamic_css .= kreativa_apply_font ( "rcm_font" , '.dimmer-text' );
}
$rcm_size=kreativa_get_option_data('rcm_size');
if ($rcm_size<>"") {
	$dynamic_css .= '.dimmer-text { font-size:'.$rcm_size.'px; }';
}
$rcm_letterspacing=kreativa_get_option_data('rcm_letterspacing');
if ($rcm_letterspacing<>"") {
	$dynamic_css .= '.dimmer-text { letter-spacing:'.$rcm_letterspacing.'px; }';
}
$rcm_weight=kreativa_get_option_data('rcm_weight');
if ($rcm_weight<>"") {
	$dynamic_css .= '.dimmer-text { font-weight:'.$rcm_weight.'; }';
}
$rcm_textcolor=kreativa_get_option_data('rcm_textcolor');
if ($rcm_textcolor) {
	$dynamic_css .= " .dimmer-text { color:".$rcm_textcolor."; }";
}
$rcm_bgcolor=kreativa_get_option_data('rcm_bgcolor');
$rcm_bgcolor_rgb=kreativa_hex2RGB($rcm_bgcolor,true);
if ($rcm_bgcolor) {
	$dynamic_css .= '#dimmer { background:rgba('.$rcm_bgcolor_rgb.',0.8); }';
}

//Mobile Specific
$mobile_css = stripslashes_deep( kreativa_get_option_data('mobile_css') );
if (isSet($mobile_css) && $mobile_css!="") {
$dynamic_css .= '
@media only screen and (max-width: 1024px) {
	'.$mobile_css.'
}
@media only screen and (min-width: 768px) and (max-width: 959px) {
	'.$mobile_css.'
}
@media only screen and (max-width: 767px) {
	'.$mobile_css.'
}
@media only screen and (min-width: 480px) and (max-width: 767px) {
	'.$mobile_css.'
}';
}
?>