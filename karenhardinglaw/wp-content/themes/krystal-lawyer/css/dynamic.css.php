<?php
/**
 * Krystal Lawyer: Dynamic CSS stylesheet
 * 
 */

function krystal_lawyer_dynamic_css_stylesheet() {    
 
    $top_menu_button_color= sanitize_hex_color(get_theme_mod( 'kr_top_menu_button_color','#b49964' ));
    $top_menu_button_text_color= sanitize_hex_color(get_theme_mod( 'kr_top_menu_button_text_color','#b49964' ));
    $top_menu_color= sanitize_hex_color(get_theme_mod( 'kr_top_menu_color','#555' ));      
    $top_menu_dd_color= sanitize_hex_color(get_theme_mod( 'kr_top_menu_dd_color','#dd3333' ));

    $css = '
    #menu-social-menu.footer-menu li{
        display: inline-block;
    }
';

if(true===get_theme_mod( 'kr_enable_last_menu_button',false)){
    if('style2'===esc_html(get_theme_mod('kr_menu_button_styles','style2'))) {
        $css .='
            nav ul.nav li:last-child > a,
            .res-menu ul.nav li:last-child > a {
                border: 2px solid ' . $top_menu_button_color . ';
                color: ' . $top_menu_button_text_color . ' !important;
                padding: 10px 20px !important;
                font-weight: 400;
            }

            nav ul.nav li .dropdown-menu > li:last-child > a,
            .res-menu ul.nav li .dropdown-menu > li:last-child > a {
                background: none !important;
                border: none !important;
                color: inherit !important;
            }

            nav ul.nav li .dropdown-menu > li > a:hover, 
            .res-menu ul.nav li .dropdown-menu > li > a:hover,
            nav ul.nav li .dropdown-menu > li > a:focus, 
            .res-menu ul.nav li .dropdown-menu > li > a:focus,
            .dropdown-menu > li > a:focus {
                background: ' . $top_menu_dd_color . ' !important;
                color: #fff !important;
            } 

            .res-menu ul.nav li:last-child > a{
                width: 250px;
            }
        ';   
    }
    else{
        $css .='
            nav ul.nav li:last-child > a,
            .res-menu ul.nav li:last-child > a {
                background: ' . $top_menu_button_color . ' !important;
                color: #fff !important;
                padding: 7px 14px !important;
                border-radius: 45px;
            }

            nav ul.nav li .dropdown-menu > li:last-child > a,
            .res-menu ul.nav li .dropdown-menu > li:last-child > a {
                background: none !important;
                border: none !important;
                color: inherit !important;
                border-radius: 0 !important;
            }

            nav ul.nav li .dropdown-menu > li > a:hover, 
            .res-menu ul.nav li .dropdown-menu > li > a:hover,
             nav ul.nav li .dropdown-menu > li > a:focus, 
            .res-menu ul.nav li .dropdown-menu > li > a:focus,
            .dropdown-menu > li > a:focus {
                background: ' . $top_menu_dd_color . ' !important;
                color: #fff !important;
            } 

            .res-menu ul.nav li:last-child > a{
                width: 250px;
            }
        ';
    }
    
}


return apply_filters( 'krystal_lawyer_dynamic_css_stylesheet', $css);

}