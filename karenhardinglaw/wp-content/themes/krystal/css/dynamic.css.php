<?php
/**
 * Krystal: Dynamic CSS Stylesheet
 * 
 */

function krystal_dynamic_css_stylesheet() {    
 
    $link_color= sanitize_hex_color(get_theme_mod( 'kr_link_color','#444444' ));
    $link_hover_color= sanitize_hex_color(get_theme_mod( 'kr_link_hover_color','#000000' ));    

    $heading_color= sanitize_hex_color(get_theme_mod( 'kr_heading_color','#444444' ));
    $heading_hover_color= sanitize_hex_color(get_theme_mod( 'kr_heading_hover_color','#000000' ));    
    
    $trans_button_hover_color= sanitize_hex_color(get_theme_mod( 'kr_trans_button_hover_color','#000000'));

    $button_color= sanitize_hex_color(get_theme_mod( 'kr_button_color','#444444' ));
    $button_hover_color= sanitize_hex_color(get_theme_mod( 'kr_button_hover_color','#444444' ));

    $port_image_hover_color= sanitize_hex_color(get_theme_mod( 'kr_port_image_hover_color','#444444' ));   

    $footer_bg_color= sanitize_hex_color(get_theme_mod( 'kr_footer_bg_color','#000000' ));   
    $footer_content_color= sanitize_hex_color(get_theme_mod( 'kr_footer_content_color','#ffffff' ));   
    $footer_links_color= sanitize_hex_color(get_theme_mod( 'kr_footer_links_color','#b3b3b3' ));  

    $top_menu_color= sanitize_hex_color(get_theme_mod( 'kr_top_menu_color','#ffffff' ));    
    $top_menu_button_color= sanitize_hex_color(get_theme_mod( 'kr_top_menu_button_color','#5b9dd9' ));
    $top_menu_button_text_color= sanitize_hex_color(get_theme_mod( 'kr_top_menu_button_text_color','#fff' ));
    $top_menu_dd_color= sanitize_hex_color(get_theme_mod( 'kr_top_menu_dd_color','#dd3333' ));


    $home_bg_image_text_color= sanitize_hex_color(get_theme_mod( 'kr_home_bg_image_text_color','#ffffff' ));      
    $page_bg_image_text_color= sanitize_hex_color(get_theme_mod( 'kr_page_bg_image_text_color','#ffffff' ));      

    $pagetitle_hft= absint(get_theme_mod( 'kr_pagetitle_hft','150' ));       
    $pagetitle_hfb= absint(get_theme_mod( 'kr_pagetitle_hfb','125' ));       

    $preloader_image=esc_url(get_theme_mod( 'kr_preloader_image' )); 

    //contact form color
    $cf_label_color= sanitize_hex_color(get_theme_mod( 'kr_cf_label_color','#555555'));       
    $cf_text_color= sanitize_hex_color(get_theme_mod( 'kr_cf_text_color','#555555'));       
    $cf_bg_color= sanitize_hex_color(get_theme_mod( 'kr_cf_bg_color','#555'));
    $cf_button_color= sanitize_hex_color(get_theme_mod( 'kr_cf_button_color','#555555'));             
    $cf_button_bg_color= sanitize_hex_color(get_theme_mod( 'kr_cf_button_bg_color','#555555'));    
    
 
    


    $css = '


    a{        
        color: ' . $link_color . '; 
        vertical-align: top;
    }

    a:hover{
        color: ' . $link_hover_color . '; 
        
    }  

    h1,h2,h3,h4,h5,h6{        
        color: ' . $heading_color . '; 
    }

    h1:hover,
    h2:hover,
    h3:hover,
    h4:hover,
    h5:hover,
    h6:hover{
        color: ' . $heading_hover_color . ';    
    }

    button.trans:hover, 
    button.trans:focus, 
    button.trans:active{
        background: ' . $trans_button_hover_color . ' !important;    
        color: #fff !important;    
    }  

    #commentform input[type=submit]:hover,
    #commentform input[type=submit]:focus{
        background: ' . $trans_button_hover_color . ' !important;
        border: 1px solid ' . $trans_button_hover_color . ' !important;
        color: #fff !important;
        transition: all 0.3s ease-in-out; 
    }

    a.trans:hover,
    a.trans:focus{
        background: ' . $trans_button_hover_color . ' !important;
        border: 1px solid ' . $trans_button_hover_color . ' !important;
        color: #fff !important;
        transition: all 0.3s ease-in-out;
    }

    .slide-bg-section .read-more a:hover,
    .slide-bg-section .read-more a:focus,
    .slider-buttons a:hover,
    .slider-buttons a:focus{
        background: ' . $trans_button_hover_color . ' !important;
        border: 1px solid ' . $trans_button_hover_color . ' !important;
        color: #fff !important;
        transition: all 0.3s ease-in-out;
    }

    .btn-default{
        background: ' . $button_color . ' !important;
        border: 1px solid ' . $button_color . ' !important;
    }

    .btn-default:hover,
    .btn-default:focus{
        background: ' . $button_hover_color . ' !important;
    }

    .slider-buttons a .btn-default{
        background:none !important;
    }

    .dropdown-menu > li > a:hover, 
    .dropdown-menu > li > a:focus{
        background: ' . $top_menu_dd_color . ' !important;
        border-top-left-radius: 4px;
        border-top-right-radius: 4px;
    }

    .dropdown-menu > .active > a, 
    .dropdown-menu > .active > a:hover, 
    .dropdown-menu > .active > a:focus{
        background: ' . $top_menu_dd_color . ' !important;   
    }

    .pagination .nav-links .current{
        background: ' . $link_color . ' !important;
    }

    .isotope #filter li.selected a, 
    .isotope #filter li a:hover {
        color: ' . $link_color . ' !important;
    }

    [class^=\'imghvr-fold\']:after, 
    [class^=\'imghvr-fold\']:before, 
    [class*=\' imghvr-fold\']:after, 
    [class*=\' imghvr-fold\']:before{
        background-color: ' . $port_image_hover_color . ' !important;
    }

    [class^=\'imghvr-\'] figcaption, [class*=\' imghvr-\'] figcaption {    
        background-color: ' . $port_image_hover_color . ' !important;
    }

    footer#footer {        
        background: ' . $footer_bg_color . ';
        color: ' . $footer_content_color . ';
    }

    footer h4{
        color: ' . $footer_content_color . ';   
    }

    footer#footer a,
    footer#footer a:hover{
        color: ' . $footer_links_color . ';      
    }

    .section-title.page-title{
        padding-top: ' . $pagetitle_hft . 'px;
        padding-bottom: ' . $pagetitle_hfb . 'px;
    }

    header.menu-wrapper nav ul li a,
    header.menu-wrapper.style-2 nav ul li a,
    .site-title a, .site-title a:hover, .site-title a:focus, .site-title a:visited,
    p.site-description,
    .navbar-toggle{
        color: ' . $top_menu_color . ';      
    }

    header.menu-wrapper.fixed nav ul li a,
    header.menu-wrapper.style-2.fixed nav ul li a{
        color: #555;
    }

    .main-menu li.menu-button > a {
        background-color: ' . $top_menu_button_color . ';
        color: ' . $top_menu_button_text_color . ' !important;        
    }

    .main-menu li.menu-button > a:active,
    .main-menu li.menu-button > a:hover {
        background-color: ' . $top_menu_button_color . ';
        color: ' . $top_menu_button_text_color . ' !important;
    }

    header.menu-wrapper.fixed nav ul li.menu-button a, 
    header.menu-wrapper.style-2.fixed nav ul li.menu-button a{
        color: ' . $top_menu_button_text_color . ' !important;   
        background: ' . $top_menu_button_color . ';
    }

    .slide-bg-section h1,
    .slide-bg-section,
    .slide-bg-section .read-more a{
        color: ' . $home_bg_image_text_color . ' !important;         
    }

    .slide-bg-section .read-more a,
    .scroll-down .mouse{
        border: 1px solid ' . $home_bg_image_text_color . ' !important;         
    }

    .scroll-down .mouse > *{
        background: ' . $home_bg_image_text_color . ' !important;         
    }

    .section-title h1,
    .bread-crumb, .bread-crumb span{
        color: ' . $page_bg_image_text_color . ';            
    }

    form.wpcf7-form input,
    form.wpcf7-form textarea,
    form.wpcf7-form radio,
    form.wpcf7-form checkbox,
    form.wpcf7-form select{
        background: transparent;
        border: none;
        border-bottom: 1px solid ' . $cf_text_color .';
        color: ' . $cf_text_color .';
    }  

    form.wpcf7-form select{
        padding-left: 20px;
        margin-top: 20px;
    }

    form.wpcf7-form input::placeholder,
    form.wpcf7-form textarea::placeholder{
        color: ' . $cf_text_color .';   
    }

    form.wpcf7-form input[type="submit"]{
        color: ' . $cf_button_color .';
        background: none;
        border: 1px solid ' . $cf_button_color . ' !important;
    }

    form.wpcf7-form input[type="submit"]:hover,
    form.wpcf7-form input[type="submit"]:focus{
        background: ' . $cf_button_bg_color . ' !important;
        color: #fff;
        border: 1px solid ' . $cf_button_bg_color . ' !important;
    }

    form.wpcf7-form label{
        color: ' . $cf_label_color . ';               
    }

';

if("" != esc_url(get_theme_mod( 'kr_preloader_image' ))) {
    $css .='     
        #pre-loader{
            height: 100px;
            width: 100px;
            background: url(' . $preloader_image . ') no-repeat !important;
        }
    ';  
}
else{
    $css .='     
        .loader-wrapper{
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
        }

        #pre-loader {
            height: 30px;
            width: 30px;
            display: inline-block;
            background: transparent;
            border-radius: 50%;
            border-width: 4px;
            border-style: solid;
            border-color: #d0d0d0 #d0d0d0 #000 #d0d0d0;
            -webkit-animation: 1s linear 0s normal none infinite running spinner_preloader;
            -moz-animation: 1s linear 0s normal none infinite running spinner_preloader;
            animation: 1s linear 0s normal none infinite running spinner_preloader;
        }
    ';
}

if(false===get_theme_mod( 'kr_sticky_menu',true)) {
    $css .='        
         header.menu-wrapper.fixed{ 
            display:none !important;
        }           
    ';  
}

if(false===get_theme_mod( 'kr_home_dark_overlay',true)) {
    $css .='        
         #parallax-bg #slider-inner:before{            
            background: none !important;    
            opacity: 0.8;            
        }           
    ';  
}

if(true===get_theme_mod( 'kr_home_disable_section',false)) {
    $css .='        
        #parallax-bg,
        .home-color-section{            
            display: none;            
        } 

        .page .page-content-area{
            margin: 0;
        }      

        .woocommerce .page-content-area,
        .woocommerce-page .page-content-area{
            margin: 70px 0;
        }          

        .elementor-editor-active header.menu-wrapper{
            z-index: 0;
        }

        .elementor-editor-active header.menu-wrapper.fixed{
            display: none;
        }

        .home .page-content-area{
            margin: 0;
        }
    ';  
}

if(true===get_theme_mod( 'kr_page_dark_overlay',false)) {
    $css .='        
         .page-title .img-overlay{
            background: rgba(0,0,0,.5);
            color: #fff;
        }          
    ';  
}

if(true===get_theme_mod( 'kr_blog_homepage',false)) {
    $css .='        
         #parallax-bg #slider-inner{
           height: 70vh;
        }

        section.home-color-section{
            height: 70vh;
        }

        .slide-bg-section{
            height: calc(70vh - 5px);
        } 

        body{
            background: #fbfbfb;
        }

        article{
            margin: 70px 0;
            background: #fff;
            padding: 1px 30px;            
            box-shadow: 0px 0px 3px 0px #c5c5c5;
            -moz-box-shadow: 0px 0px 3px 0px #c5c5c5;
            -webkit-box-shadow: 0px 0px 3px 0px #c5c5c5;
        }

        article .blog-wrapper{
            margin: 0;
            padding-top: 30px;
            padding-right: 0;
        }

        .widget-area .widget{
            margin: 5px 0;
            background: #fff;
            padding: 20px 20px;            
            box-shadow: 0px 0px 3px 0px #c5c5c5;
            -moz-box-shadow: 0px 0px 3px 0px #c5c5c5;
            -webkit-box-shadow: 0px 0px 3px 0px #c5c5c5;
        }

        aside h4.widget-title{
            font-size: 15px;
        }

        .widget li a{
            color: #555;
        }

        .widget-area{
            margin:70px 0;
        }

        body.page{
            background: #fff;
        }

        .page-content-area article{
            box-shadow: none;
            -moz-box-shadow: none;
            -webkit-box-shadow: none;
        }
    ';  
}

if('bg'===esc_attr(get_theme_mod('kr_form_elem_settings_style','default'))) {
    $css .='        
        form.wpcf7-form input,
        form.wpcf7-form textarea,
        form.wpcf7-form radio,
        form.wpcf7-form checkbox,
        form.wpcf7-form select{
            background: ' . $cf_bg_color .';
            border: none !important;
            border-radius: 4px;
        }  

        form input[type="submit"]{
            color: ' . $cf_text_color .';
            background: none;
            border: 1px solid ' . $cf_bg_color . ' !important;
            border-radius: 45px;
        }
    ';
}
else{
    $css .='        
        form.wpcf7-form input,
        form.wpcf7-form textarea,
        form.wpcf7-form radio,
        form.wpcf7-form checkbox,
        form.wpcf7-form select{
            background: transparent;
            border-bottom: 1px solid ' . $cf_bg_color .' !important;
            border-radius: 0;
        }

        form input[type="submit"]{
            border-radius: 45px;
        }
    ';
}

if(true===get_theme_mod('kr_form_width_setting',false)) {
    $css .='        
        form.wpcf7-form {
            width: 100%;
            margin: auto;
        }
    ';
}

if(true===get_theme_mod( 'kr_page_title_section_hide',false) && "style1" === esc_attr(get_theme_mod( 'kr_header_styles','style1'))) {
    $css .='        
        .page #primary,
        .archive #primary,
        .blog #primary,
        .single #primary,
        .search #primary,
        .error404 #primary{
            margin-top: 100px;
        }

        .home #primary{
            margin-top: 0;
        }
    ';   
}


// For Skip links: Transparent header //
if("style1" === esc_attr(get_theme_mod( 'kr_header_styles','style1'))) { 
    if(true===get_theme_mod( 'kr_page_title_section_hide',false)) {
        if(false===get_theme_mod( 'kr_sticky_menu',true)) {
            $css .=' 

                .blog .skiptarget,
                .single .skiptarget {
                    position: absolute;
                    top: 150px;
                }

                .page .skiptarget{
                    position: absolute;
                    top: 100px;
                }
            ';
        }
        else{
            $css .=' 

                .blog .skiptarget,
                .single .skiptarget {
                    position: absolute;
                    top: 150px;
                }

                .page .skiptarget{
                    position: absolute;
                    top: 100px;
                }
            ';
        }
    }
    else{
        if(false===get_theme_mod( 'kr_sticky_menu',true)) {
            $css .='        
                .blog .skiptarget,
                .single .skiptarget{
                    position: absolute;
                    top: 350px;
                }

                .page .skiptarget{
                    position: absolute;
                    top: 330px;
                }
            ';
        }
        else{
            $css .='        
                .blog .skiptarget,
                .single .skiptarget{
                    position: absolute;
                    top: 300px;
                }

                .page .skiptarget{
                    position: absolute;
                    top: 260px;
                }

                .archive .skiptarget,
                .error404 .skiptarget,
                .search .skiptarget {
                    position: absolute;
                    top: 270px;
                }
            ';
        }
    }
}


// For Skip links: Default header //
if("style2" === esc_attr(get_theme_mod( 'kr_header_styles','style1'))) { 
    if(true===get_theme_mod( 'kr_page_title_section_hide',false)) {
        if(false===get_theme_mod( 'kr_sticky_menu',true)) {
            $css .=' 

                .blog .skiptarget,
                .single .skiptarget {
                    position: absolute;
                    top: 150px;
                }

                .page .skiptarget{
                    position: absolute;
                    top: 100px;
                }
            ';
        }
        else{
            $css .=' 

                .blog .skiptarget,
                .single .skiptarget {
                    position: absolute;
                    top: 150px;
                }

                .page .skiptarget{
                    position: absolute;
                    top: 100px;
                }
            ';
        }
    }
    else{
        if(false===get_theme_mod( 'kr_sticky_menu',true)) {
            $css .='        
                .blog .skiptarget,
                .single .skiptarget{
                    position: absolute;
                    top: 425px;
                }

                .page .skiptarget{
                    position: absolute;
                    top: 420px;
                }
            ';
        }
        else{
            $css .='        
                .blog .skiptarget,
                .single .skiptarget{
                    position: absolute;
                    top: 300px;
                }

                .page .skiptarget{
                    position: absolute;
                    top: 260px;
                }

                .archive .skiptarget,
                .error404 .skiptarget,
                .search .skiptarget{
                    position: absolute;
                    top: 295px;
                }
            ';
        }
    }
}

// For HomePage Skip links: Transparent header //
if("style1" === esc_attr(get_theme_mod( 'kr_header_styles','style1'))) { 
    if(true===get_theme_mod( 'kr_home_disable_section',false)) {
        if(false===get_theme_mod( 'kr_sticky_menu',true)) {
            $css .='        
                .home .skiptarget{
                    position: absolute;
                    top: 50px;
                }
            ';
        }
        else{
            $css .='        
                .home .skiptarget{
                    position: absolute;
                    top: 50px;
                }
            ';
        }
    }
    else{
        if(false===get_theme_mod( 'kr_sticky_menu',true)) {
            $css .='        
                .home .skiptarget{
                    position: absolute;
                    top: 105vh;
                }
            ';
        }
        else{
            $css .='        
                .home .skiptarget{
                    position: absolute;
                    top: 100vh;
                }
            ';
        }
    }
}

// For HomePage Skip links: Normal header //
if("style2" === esc_attr(get_theme_mod( 'kr_header_styles','style1'))) { 
    if(true===get_theme_mod( 'kr_home_disable_section',false)) {
        if(false===get_theme_mod( 'kr_sticky_menu',true)) {
            $css .='        
                .home .skiptarget{
                    position: absolute;
                    top: 100px;
                }
            ';
        }
        else{
            $css .='        
                .home .skiptarget{
                    position: absolute;
                    top: 100px;;
                }
            ';
        }
    }
    else{
        if(false===get_theme_mod( 'kr_sticky_menu',true)) {
            $css .='        
                .home .skiptarget{
                    position: absolute;
                    top: 115vh;
                }
            ';
        }
        else{
            $css .='        
                .home .skiptarget{
                    position: absolute;
                    top: 95vh;
                }
            ';
        }
    }
}



if(is_active_sidebar('footer-column1') || is_active_sidebar('footer-column2') || is_active_sidebar('footer-column3') || is_active_sidebar('footer-column4')){
    $css .='        
        footer#footer{
            padding-top: 50px;
        }
    ';
}

/*  Main logo spacing */
if ( has_custom_logo() ) {
    $css .='
        h1.site-title {
            margin-top: 0;
        }
    ';
}
else {
    $css .='
        h1.site-title {
            margin-top: 25px;
        }
    ';
}

/*  Sticky logo spacing */
if ( "" != esc_url(get_theme_mod( 'kr_alt_logo' )))  {
    $css .='
        header.fixed h1.site-title {
            margin-top: 0;
        }
    ';
}
else {
    $css .='
        header.fixed h1.site-title {
            margin-top: 25px;
        }
    ';
}


return apply_filters( 'krystal_dynamic_css_stylesheet', $css);
}


?>


