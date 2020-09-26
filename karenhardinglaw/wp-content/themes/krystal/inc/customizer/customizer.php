<?php
/**
 * Krystal Theme Customizer
 *
 * @package krystal
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */

if ( ! function_exists( 'krystal_customize_register' ) ) :
function krystal_customize_register( $wp_customize ) {

    require( get_template_directory() . '/inc/customizer/custom-controls/control-custom-content.php' ); 
    // Add custom controls.
    require get_parent_theme_file_path( 'inc/customizer/custom-controls/info/class-info-control.php' );
    require get_parent_theme_file_path( 'inc/customizer/custom-controls/info/class-title-info-control.php' );
    require get_parent_theme_file_path( 'inc/customizer/custom-controls/toggle-button/class-login-designer-toggle-control.php' );
    require get_parent_theme_file_path( 'inc/customizer/custom-controls/radio-images/class-radio-image-control.php' );

    // Register the custom control type.
    $wp_customize->register_control_type( 'Krystal_Toggle_Control' ); 


    // Display Site Title and Tagline
    $wp_customize->add_setting( 
        'kr_display_site_title_tagline', 
        array(
            'default'           => true,
            'type'              => 'theme_mod',
            'sanitize_callback' => 'krystal_sanitize_checkbox',
        ) 
    );

    $wp_customize->add_control( 
        new Krystal_Toggle_Control( $wp_customize, 'kr_display_site_title_tagline', 
        array(
            'label'       => esc_html__( 'Display Site Title and Tagline', 'krystal' ),
            'section'     => 'title_tagline',
            'type'        => 'toggle',
            'settings'    => 'kr_display_site_title_tagline',
        ) 
    )); 

    // General Settings
    $wp_customize->add_section(
        'krystal_general_settings',
        array (
            'priority'      => 25,
            'capability'    => 'edit_theme_options',
            'theme_supports'=> '',
            'title'         => esc_html__( 'General Settings', 'krystal' )
        )
    );

    // Info label
    $wp_customize->add_setting( 
        'kr_label_home_background_section', 
        array(
            'sanitize_callback' => 'krystal_sanitize_title',
        ) 
    );

    $wp_customize->add_control( 
        new Krystal_Title_Info_Control( $wp_customize, 'kr_label_home_background_section', 
        array(
            'label'       => esc_html__( 'Choose whether to disable the home background section or not', 'krystal' ),
            'section'     => 'krystal_general_settings',
            'type'        => 'title',
            'settings'    => 'kr_label_home_background_section',
        ) 
    ));

    // Enable/disable section
    $wp_customize->add_setting(
        'kr_home_disable_section',
        array(
            'type' => 'theme_mod',
            'default'           => false,
            'sanitize_callback' => 'krystal_sanitize_checkbox_selection'
        )
    );

    $wp_customize->add_control(
        new Krystal_Toggle_Control( $wp_customize, 'kr_home_disable_section', 
        array(
            'settings'      => 'kr_home_disable_section',
            'section'       => 'krystal_general_settings',
            'type'          => 'toggle',
            'label'         => esc_html__( 'Disable Home Background Image Section:', 'krystal' ),
        )
    ));

    // Info label
    $wp_customize->add_setting( 
        'kr_label_home_background_selection_section', 
        array(
            'sanitize_callback' => 'krystal_sanitize_title',
        ) 
    );

    $wp_customize->add_control( 
        new Krystal_Title_Info_Control( $wp_customize, 'kr_label_home_background_selection_section', 
        array(
            'label'       => esc_html__( 'Home Background Selection', 'krystal' ),
            'section'     => 'krystal_general_settings',
            'type'        => 'title',
            'settings'    => 'kr_label_home_background_selection_section',
            'active_callback'    => 'krystal_home_bg_enable',
        ) 
    ));

    // Background selection
    $wp_customize->add_setting(
        'kr_home_bg_radio',
        array(
            'type' => 'theme_mod',
            'default'           => 'image',
            'sanitize_callback' => 'krystal_sanitize_radio_pagebg_selection'
        )
    );

    $wp_customize->add_control(
        'kr_home_bg_radio',
        array(
            'settings'      => 'kr_home_bg_radio',
            'section'       => 'krystal_general_settings',
            'type'          => 'radio',
            'label'         => esc_html__( 'Choose Home Background Color or Background Image:', 'krystal' ),
            'description'   => esc_html__('This setting will change the Home background area.', 'krystal'),
            'choices' => array(
                            'color' => esc_html__('Background Color','krystal'),
                            'image' => esc_html__('Background Image','krystal'),
                            ),
            'active_callback'    => 'krystal_home_bg_enable',
        )
    );

    // Background color
    $wp_customize->add_setting(
        'kr_home_bg_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#555555',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_home_bg_color',
        array(
        'label'      => esc_html__( 'Select Background Color', 'krystal' ),
        'description'   => esc_html__('This setting will add background color if Background Color was selected above.', 'krystal'),
        'section'    => 'krystal_general_settings',
        'settings'   => 'kr_home_bg_color',
        'active_callback'  => 'krystal_home_bg_color_enable',

        ) )
    );

    // Home Background Image 
    $wp_customize->add_setting(
        'kr_theme_home_bg',
        array(
            'type' => 'theme_mod',
            'sanitize_callback' => 'krystal_sanitize_image'
        )
    );

    $wp_customize->add_control(
      new WP_Customize_Image_Control(
          $wp_customize,
          'kr_theme_home_bg',
          array(
              'settings'      => 'kr_theme_home_bg',
              'section'       => 'krystal_general_settings',
              'label'         => esc_html__( 'Home Background Image', 'krystal' ),
              'description'   => esc_html__( 'This setting will add background image if Background Image was selected above.', 'krystal' ),
              'active_callback'  => 'krystal_home_bg_image_enable',
          )
      )
    );

    // Info label
    $wp_customize->add_setting( 
        'kr_label_home_background_content_section', 
        array(
            'sanitize_callback' => 'krystal_sanitize_title',
        ) 
    );

    $wp_customize->add_control( 
        new Krystal_Title_Info_Control( $wp_customize, 'kr_label_home_background_content_section', 
        array(
            'label'       => esc_html__( 'Home Background Content', 'krystal' ),
            'section'     => 'krystal_general_settings',
            'type'        => 'title',
            'settings'    => 'kr_label_home_background_content_section',
            'active_callback'    => 'krystal_home_bg_enable',
        ) 
    ));

    // Home Section Heading text 
    $wp_customize->add_setting(
        'kr_home_heading_text',
        array(            
            'default'           => esc_html__('ENTER YOUR HEADING HERE','krystal'),
            'sanitize_callback' => 'krystal_sanitize_textarea',
            'transport' => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'kr_home_heading_text',
        array(
            'settings'      => 'kr_home_heading_text',
            'section'       => 'krystal_general_settings',
            'type'          => 'textarea',
            'label'         => esc_html__( 'Heading Text', 'krystal' ),
            'description'   => esc_html__( 'heading for the home section', 'krystal' ),
            'active_callback'    => 'krystal_home_bg_enable',
        )
    );

    $wp_customize->selective_refresh->add_partial( 'kr_home_heading_text', array(
        'selector'            => '.slide-bg-section h1',   
        'settings'            => 'kr_home_heading_text',     
        'render_callback'     => 'krystal_home_heading_text_render_callback',
        'fallback_refresh'    => false, 
    ));

    // Home Section SubHeading text
    $wp_customize->add_setting(
        'kr_home_subheading_text',
        array(            
            'default'           => esc_html__('ENTER YOUR SUBHEADING HERE','krystal'),
            'sanitize_callback' => 'krystal_sanitize_textarea',
            'transport' => 'postMessage',
        )
    );

    $wp_customize->add_control(
        'kr_home_subheading_text',
        array(
            'settings'      => 'kr_home_subheading_text',
            'section'       => 'krystal_general_settings',
            'type'          => 'textarea',
            'label'         => esc_html__( 'SubHeading Text', 'krystal' ),
            'description'   => esc_html__( 'Subheading for the home section', 'krystal' ),
            'active_callback'    => 'krystal_home_bg_enable',
        )
    );

    $wp_customize->selective_refresh->add_partial( 'kr_home_subheading_text', array(
        'selector'            => '.slide-bg-section p',   
        'settings'            => 'kr_home_subheading_text',     
        'render_callback'     => 'krystal_home_subheading_text_render_callback',
        'fallback_refresh'    => false, 
    ));

    // Home Section Button text 
    $wp_customize->add_setting(
        'kr_home_button_text',
        array( 
            'type' => 'theme_mod',           
            'default'           => '',
            'sanitize_callback' => 'krystal_sanitize_html',
            
        )
    );

    $wp_customize->add_control(
        'kr_home_button_text',
        array(
            'settings'      => 'kr_home_button_text',
            'section'       => 'krystal_general_settings',
            'type'          => 'textbox',
            'label'         => esc_html__( 'Button Text', 'krystal' ),
            'description'   => esc_html__( 'Button text for the home section', 'krystal' ),
            'active_callback'    => 'krystal_home_bg_enable',
        )
    );  


    // Home Section Button url 
    $wp_customize->add_setting(
        'kr_home_button_url',
        array(
            'type' => 'theme_mod',
            'default'           => '',
            'sanitize_callback' => 'krystal_sanitize_url'
        )
    );

    $wp_customize->add_control(
        'kr_home_button_url',
        array(
            'settings'      => 'kr_home_button_url',
            'section'       => 'krystal_general_settings',
            'type'          => 'textbox',
            'label'         => esc_html__( 'Button URL', 'krystal' ),
            'description'   => esc_html__( 'Button URL for the home section, you can paste youtube or vimeo video url also', 'krystal' ),
            'active_callback'    => 'krystal_home_bg_enable',
        )
    );


    // Home Section Button2 text
    $wp_customize->add_setting(
        'kr_home_button2_text',
        array(
            'type' => 'theme_mod',
            'default'           => '',
            'sanitize_callback' => 'krystal_sanitize_html'
        )
    );

    $wp_customize->add_control(
        'kr_home_button2_text',
        array(
            'settings'      => 'kr_home_button2_text',
            'section'       => 'krystal_general_settings',
            'type'          => 'textbox',
            'label'         => esc_html__( 'Button 2 Text', 'krystal' ),
            'description'   => esc_html__( 'Button 2 text for the home section', 'krystal' ),
            'active_callback'    => 'krystal_home_bg_enable',
        )
    );


    // Home Section Button2 url 
    $wp_customize->add_setting(
        'kr_home_button2_url',
        array(
            'type' => 'theme_mod',
            'default'           => '',
            'sanitize_callback' => 'krystal_sanitize_url'
        )
    );

    $wp_customize->add_control(
        'kr_home_button2_url',
        array(
            'settings'      => 'kr_home_button2_url',
            'section'       => 'krystal_general_settings',
            'type'          => 'textbox',
            'label'         => esc_html__( 'Button 2 URL', 'krystal' ),
            'description'   => esc_html__( 'Button 2 URL for the home section, you can paste youtube or vimeo video url also', 'krystal' ),
            'active_callback'    => 'krystal_home_bg_enable',
        )
    );

    // text position
    $wp_customize->add_setting(
        'kr_home_text_position',
        array(
            'type' => 'theme_mod',
            'default'           => 'center',
            'sanitize_callback' => 'krystal_sanitize_home_text_position_radio_selection'
        )
    );

    $wp_customize->add_control(
        'kr_home_text_position',
        array(
            'settings'      => 'kr_home_text_position',
            'section'       => 'krystal_general_settings',
            'type'          => 'radio',
            'label'         => esc_html__( 'Select Text Position:', 'krystal' ),
            'description'   => '',
            'choices' => array(
                            'left' =>esc_html__( 'Left', 'krystal' ),
                            'center' =>esc_html__( 'Center', 'krystal' ),
                            'right' => esc_html__( 'Right', 'krystal' ),                            
                            ),
            'active_callback'    => 'krystal_home_bg_enable',
        )
    );

    // Info label
    $wp_customize->add_setting( 
        'kr_label_home_background_parallax_scroll', 
        array(
            'sanitize_callback' => 'krystal_sanitize_title',
        ) 
    );

    $wp_customize->add_control( 
        new Krystal_Title_Info_Control( $wp_customize, 'kr_label_home_background_parallax_scroll', 
        array(
            'label'       => esc_html__( 'Parallax Scroll', 'krystal' ),
            'section'     => 'krystal_general_settings',
            'type'        => 'title',
            'settings'    => 'kr_label_home_background_parallax_scroll',
            'active_callback'    => 'krystal_home_bg_enable',
        ) 
    ));

    // Parallax Scroll for background image 
    $wp_customize->add_setting(
        'kr_home_parallax',
        array(
            'type' => 'theme_mod',
            'default'           => true,
            'sanitize_callback' => 'krystal_sanitize_checkbox_selection'
        )
    );

    $wp_customize->add_control(
        new Krystal_Toggle_Control( $wp_customize, 'kr_home_parallax', 
        array(
            'settings'      => 'kr_home_parallax',
            'section'       => 'krystal_general_settings',
            'type'          => 'toggle',
            'label'         => esc_html__( 'Enable Parallax Scroll:', 'krystal' ),
            'description'   => esc_html__( 'Choose whether to show a parallax scroll feature for the Home Background image', 'krystal' ),
            'active_callback'    => 'krystal_home_bg_enable',         
        )
    ));

    // Info label
    $wp_customize->add_setting( 
        'kr_label_home_background_dark_overlay', 
        array(
            'sanitize_callback' => 'krystal_sanitize_title',
        ) 
    );

    $wp_customize->add_control( 
        new Krystal_Title_Info_Control( $wp_customize, 'kr_label_home_background_dark_overlay', 
        array(
            'label'       => esc_html__( 'Dark Overlay', 'krystal' ),
            'section'     => 'krystal_general_settings',
            'type'        => 'title',
            'settings'    => 'kr_label_home_background_dark_overlay',
            'active_callback'    => 'krystal_home_bg_enable',
        ) 
    ));

    // Enable Dark Overlay
    $wp_customize->add_setting(
        'kr_home_dark_overlay',
        array(
            'type' => 'theme_mod',
            'default'           => true,
            'sanitize_callback' => 'krystal_sanitize_checkbox_selection'
        )
    );

    $wp_customize->add_control(
        new Krystal_Toggle_Control( $wp_customize, 'kr_home_dark_overlay', 
        array(
            'settings'      => 'kr_home_dark_overlay',
            'section'       => 'krystal_general_settings',
            'type'          => 'toggle',
            'label'         => esc_html__( 'Enable Dark Overlay:', 'krystal' ),
            'description'   => esc_html__( 'Choose whether to show a dark overlay over background image', 'krystal' ),
            'active_callback'    => 'krystal_home_bg_enable',           
        )
    ));

    // Info label
    $wp_customize->add_setting( 
        'kr_label_home_background_blog_hp', 
        array(
            'sanitize_callback' => 'krystal_sanitize_title',
        ) 
    );

    $wp_customize->add_control( 
        new Krystal_Title_Info_Control( $wp_customize, 'kr_label_home_background_blog_hp', 
        array(
            'label'       => esc_html__( 'Blog Homepage', 'krystal' ),
            'section'     => 'krystal_general_settings',
            'type'        => 'title',
            'settings'    => 'kr_label_home_background_blog_hp',
        ) 
    ));

    // Blog Homepage
    $wp_customize->add_setting(
        'kr_blog_homepage',
        array(
            'type' => 'theme_mod',
            'default'           => false,
            'sanitize_callback' => 'krystal_sanitize_checkbox_selection'
        )
    );

    $wp_customize->add_control(
        new Krystal_Toggle_Control( $wp_customize, 'kr_blog_homepage', 
        array(
            'settings'      => 'kr_blog_homepage',
            'section'       => 'krystal_general_settings',
            'type'          => 'toggle',
            'label'         => esc_html__( 'Use this for Blog Homepage:', 'krystal' ),
            'description'   => esc_html__( 'Check this if you are having a Blog as front page', 'krystal' ),           
        )
    ));

    //Header Styles
    $wp_customize->add_section(
        'kr_header_styles_settings',
        array (
            'priority'      => 25,
            'capability'    => 'edit_theme_options',
            'theme_supports'=> '',
            'title'         => esc_html__( 'Header Styles', 'krystal' )
        )
    );

    // Info label
    $wp_customize->add_setting( 
        'kr_label_header_styles', 
        array(
            'sanitize_callback' => 'krystal_sanitize_title',
        ) 
    );

    $wp_customize->add_control( 
        new Krystal_Title_Info_Control( $wp_customize, 'kr_label_header_styles', 
        array(
            'label'       => esc_html__( 'Header Styles', 'krystal' ),
            'section'     => 'kr_header_styles_settings',
            'type'        => 'title',
            'settings'    => 'kr_label_header_styles',
        ) 
    ));
    
    $wp_customize->add_setting(
        'kr_header_styles',
        array(
            'type' => 'theme_mod',
            'default'           => 'style1',
            'sanitize_callback' => 'krystal_sanitize_header_style_radio_selection'
        )
    );

    $wp_customize->add_control(
        'kr_header_styles',
        array(
            'settings'      => 'kr_header_styles',
            'section'       => 'kr_header_styles_settings',
            'type'          => 'radio',
            'label'         => esc_html__( 'Choose Header Style:', 'krystal' ),
            'description'   => '',
            'choices' => array(
                            'style1' => esc_html__('Header Style1 - This will show full background image as header with menu over the image', 'krystal'),
                            'style2' => esc_html__('Header Style2 - This header style will show background image below menu', 'krystal'),
                            ),
        )
    );
    

    //Sticky Header Settings
    $wp_customize->add_section(
        'krystal_sticky_header_settings',
        array (
            'priority'      => 25,
            'capability'    => 'edit_theme_options',
            'theme_supports'=> '',
            'title'         => esc_html__( 'Sticky Header Settings', 'krystal' )
        )
    );

    // Info label
    $wp_customize->add_setting( 
        'kr_label_sticky_header_settings', 
        array(
            'sanitize_callback' => 'krystal_sanitize_title',
        ) 
    );

    $wp_customize->add_control( 
        new Krystal_Title_Info_Control( $wp_customize, 'kr_label_sticky_header_settings', 
        array(
            'label'       => esc_html__( 'Sticky Header Settings', 'krystal' ),
            'section'     => 'krystal_sticky_header_settings',
            'type'        => 'title',
            'settings'    => 'kr_label_sticky_header_settings',
        ) 
    ));

    //enable sticky menu
    $wp_customize->add_setting(
        'kr_sticky_menu',
        array(
            'type' => 'theme_mod',
            'default'           => true,
            'sanitize_callback' => 'krystal_sanitize_checkbox_selection'
        )
    );

    $wp_customize->add_control(
        new Krystal_Toggle_Control( $wp_customize, 'kr_sticky_menu', 
        array(
            'settings'      => 'kr_sticky_menu',
            'section'       => 'krystal_sticky_header_settings',
            'type'          => 'toggle',
            'label'         => esc_html__( 'Enable Sticky Header Feature:', 'krystal' ),
            'description'   => esc_html__( 'Choose whether to enable a sticky header feature for the site', 'krystal' ),            
        )
    ));

    // Info label
    $wp_customize->add_setting( 
        'kr_label_sticky_header_logo', 
        array(
            'sanitize_callback' => 'krystal_sanitize_title',
        ) 
    );

    $wp_customize->add_control( 
        new Krystal_Title_Info_Control( $wp_customize, 'kr_label_sticky_header_logo', 
        array(
            'label'       => esc_html__( 'Sticky Header Logo', 'krystal' ),
            'section'     => 'krystal_sticky_header_settings',
            'type'        => 'title',
            'settings'    => 'kr_label_sticky_header_logo',
            'active_callback' => 'krystal_sticky_header_enable',
        ) 
    ));

    // Mobile logo
    $wp_customize->add_setting(
        'kr_alt_logo',
        array(
            'type' => 'theme_mod',
            'sanitize_callback' => 'krystal_sanitize_image'
        )
    );

    $wp_customize->add_control(
      new WP_Customize_Image_Control(
          $wp_customize,
          'kr_alt_logo',
          array(
              'settings'      => 'kr_alt_logo',
              'section'       => 'krystal_sticky_header_settings',
              'label'         => esc_html__( 'Logo for Sticky Header', 'krystal' ),
              'description'   => esc_html__( 'Upload logo for Sticky Header. Recommended height is 45px', 'krystal' ),
              'active_callback' => 'krystal_sticky_header_enable',
          )
      )
    );

    // Scroll Down Settings //
    $wp_customize->add_section(
        'krystal_scrolldown_settings',
        array (
            'priority'      => 25,
            'capability'    => 'edit_theme_options',
            'theme_supports'=> '',
            'title'         => esc_html__( 'Scroll Down Settings', 'krystal' )
        )
    );  

    // Info label
    $wp_customize->add_setting( 
        'kr_label_scroll_down_settings', 
        array(
            'sanitize_callback' => 'krystal_sanitize_title',
        ) 
    );

    $wp_customize->add_control( 
        new Krystal_Title_Info_Control( $wp_customize, 'kr_label_scroll_down_settings', 
        array(
            'label'       => esc_html__( 'Scroll Down Settings', 'krystal' ),
            'section'     => 'krystal_scrolldown_settings',
            'type'        => 'title',
            'settings'    => 'kr_label_scroll_down_settings',
        ) 
    ));

    $wp_customize->add_setting(
        'kr_home_scroll_down',
        array(
            'type' => 'theme_mod',
            'default'           => true,
            'sanitize_callback' => 'krystal_sanitize_checkbox_selection'
        )
    );

    $wp_customize->add_control(
        new Krystal_Toggle_Control( $wp_customize, 'kr_home_scroll_down', 
        array(
            'settings'      => 'kr_home_scroll_down',
            'section'       => 'krystal_scrolldown_settings',
            'type'          => 'toggle',
            'label'         => esc_html__( 'Enable Home scroll Feature:', 'krystal' ),
            'description'   => esc_html__( 'Choose whether to enable a scroll down feature for the Home section', 'krystal' ),           
        )
    ));

    // Info label
    $wp_customize->add_setting( 
        'kr_label_scroll_down_button_url', 
        array(
            'sanitize_callback' => 'krystal_sanitize_title',
        ) 
    );

    $wp_customize->add_control( 
        new Krystal_Title_Info_Control( $wp_customize, 'kr_label_scroll_down_button_url', 
        array(
            'label'       => esc_html__( 'Scroll Down Button URL', 'krystal' ),
            'section'     => 'krystal_scrolldown_settings',
            'type'        => 'title',
            'settings'    => 'kr_label_scroll_down_button_url',
            'active_callback'    => 'krystal_scroll_down_enable',
        ) 
    ));


    // Scroll Button url //
    $wp_customize->add_setting(
        'kr_scroll_button_url',
        array(
            'type' => 'theme_mod',
            'default'           => '',
            'sanitize_callback' => 'krystal_sanitize_url'
        )
    );

    $wp_customize->add_control(
        'kr_scroll_button_url',
        array(
            'settings'      => 'kr_scroll_button_url',
            'section'       => 'krystal_scrolldown_settings',
            'type'          => 'textbox',
            'label'         => esc_html__( 'Scroll Button URL', 'krystal' ),
            'description'   => esc_html__( 'Scroll Button URL for the home section', 'krystal' ),
            'active_callback'    => 'krystal_scroll_down_enable',
        )
    );

    // Page settings
    $wp_customize->add_section(
        'krystal_page_settings',
        array (
            'priority'      => 25,
            'capability'    => 'edit_theme_options',
            'theme_supports'=> '',
            'title'         => esc_html__( 'Page Settings', 'krystal' )
        )
    );

    // Info label
    $wp_customize->add_setting( 
        'kr_label_page_title_hide_settings', 
        array(
            'sanitize_callback' => 'krystal_sanitize_title',
        ) 
    );

    $wp_customize->add_control( 
        new Krystal_Title_Info_Control( $wp_customize, 'kr_label_page_title_hide_settings', 
        array(
            'label'       => esc_html__( 'Hide Page Title', 'krystal' ),
            'section'     => 'krystal_page_settings',
            'type'        => 'title',
            'settings'    => 'kr_label_page_title_hide_settings',
        ) 
    ));

    // Hide page title section
    $wp_customize->add_setting(
        'kr_page_title_section_hide',
        array(
            'type' => 'theme_mod',
            'default'           => false,
            'sanitize_callback' => 'krystal_sanitize_checkbox_selection'
        )
    );

    $wp_customize->add_control(
        new Krystal_Toggle_Control( $wp_customize, 'kr_page_title_section_hide', 
        array(
            'settings'      => 'kr_page_title_section_hide',
            'section'       => 'krystal_page_settings',
            'type'          => 'toggle',
            'label'         => esc_html__( 'Hide Page Title Section:', 'krystal' ),
            'description'   => '',           
        )
    ));

    // Info label
    $wp_customize->add_setting( 
        'kr_label_page_title_bg_settings', 
        array(
            'sanitize_callback' => 'krystal_sanitize_title',
        ) 
    );

    $wp_customize->add_control( 
        new Krystal_Title_Info_Control( $wp_customize, 'kr_label_page_title_bg_settings', 
        array(
            'label'       => esc_html__( 'Page Title Background', 'krystal' ),
            'section'     => 'krystal_page_settings',
            'type'        => 'title',
            'settings'    => 'kr_label_page_title_bg_settings',
            'active_callback' => 'krystal_page_title_disable',
        ) 
    ));

    // Background selection
    $wp_customize->add_setting(
        'kr_page_bg_radio',
        array(
            'type' => 'theme_mod',
            'default'           => 'color',
            'sanitize_callback' => 'krystal_sanitize_radio_pagebg_selection'
        )
    );

    $wp_customize->add_control(
        'kr_page_bg_radio',
        array(
            'settings'      => 'kr_page_bg_radio',
            'section'       => 'krystal_page_settings',
            'type'          => 'radio',
            'label'         => esc_html__( 'Choose Page Title Background Color or Background Image:', 'krystal' ),
            'description'   => esc_html__('This setting will change the background of the page title area.', 'krystal'),
            'choices' => array(
                            'color' => esc_html__('Background Color','krystal'),
                            'image' => esc_html__('Background Image','krystal'),
                            ),
            'active_callback' => 'krystal_page_title_disable',
        )
    );

    // Background color
    $wp_customize->add_setting(
        'kr_page_bg_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#555555',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'kr_page_bg_color',
            array(
                'label'      => esc_html__( 'Select Background Color', 'krystal' ),
                'description'   => esc_html__('This setting will add background color to the page title area if Background Color was selected above.', 'krystal'),
                'section'    => 'krystal_page_settings',
                'settings'   => 'kr_page_bg_color',
                'active_callback' => 'krystal_page_title_color_enable',
            )
        )
    );

    // Background Image
    $wp_customize->add_setting(
        'kr_page_bg_image',
        array(
            'type' => 'theme_mod',
            'sanitize_callback' => 'krystal_sanitize_image'
        )
    );

    $wp_customize->add_control(
      new WP_Customize_Image_Control(
          $wp_customize,
          'kr_page_bg_image',
          array(
              'settings'      => 'kr_page_bg_image',
              'section'       => 'krystal_page_settings',
              'label'         => esc_html__( 'Select Background Image for Page', 'krystal' ),
              'description'   => esc_html__('This setting will add background image to the page title area if Background Image was selected above.', 'krystal'),
              'active_callback' => 'krystal_page_title_image_enable',
          )
      )
    );

    // Info label
    $wp_customize->add_setting( 
        'kr_label_page_title_parallax_settings', 
        array(
            'sanitize_callback' => 'krystal_sanitize_title',
        ) 
    );

    $wp_customize->add_control( 
        new Krystal_Title_Info_Control( $wp_customize, 'kr_label_page_title_parallax_settings', 
        array(
            'label'       => esc_html__( 'Parallax Settings', 'krystal' ),
            'section'     => 'krystal_page_settings',
            'type'        => 'title',
            'settings'    => 'kr_label_page_title_parallax_settings',
            'active_callback' => 'krystal_page_title_disable',
        ) 
    ));

    // Parallax Scroll for background image 
    $wp_customize->add_setting(
        'kr_page_bg_parallax',
        array(
            'type' => 'theme_mod',
            'default'           => true,
            'sanitize_callback' => 'krystal_sanitize_checkbox_selection'
        )
    );

    $wp_customize->add_control(
        new Krystal_Toggle_Control( $wp_customize, 'kr_page_bg_parallax', 
        array(
            'settings'      => 'kr_page_bg_parallax',
            'section'       => 'krystal_page_settings',
            'type'          => 'toggle',
            'label'         => esc_html__( 'Enable Parallax Scroll:', 'krystal' ),
            'description'   => esc_html__( 'Choose whether to show a parallax scroll feature for the Page Background image', 'krystal' ), 
            'active_callback' => 'krystal_page_title_disable',          
        )
    ));

    // Info label
    $wp_customize->add_setting( 
        'kr_label_page_title_dark_overlay', 
        array(
            'sanitize_callback' => 'krystal_sanitize_title',
        ) 
    );

    $wp_customize->add_control( 
        new Krystal_Title_Info_Control( $wp_customize, 'kr_label_page_title_dark_overlay', 
        array(
            'label'       => esc_html__( 'Dark Overlay Settings', 'krystal' ),
            'section'     => 'krystal_page_settings',
            'type'        => 'title',
            'settings'    => 'kr_label_page_title_dark_overlay',
            'active_callback' => 'krystal_page_title_disable',
        ) 
    ));

    // Enable Dark Overlay
    $wp_customize->add_setting(
        'kr_page_dark_overlay',
        array(
            'type' => 'theme_mod',
            'default'           => false,
            'sanitize_callback' => 'krystal_sanitize_checkbox_selection'
        )
    );

    $wp_customize->add_control(
        new Krystal_Toggle_Control( $wp_customize, 'kr_page_dark_overlay', 
        array(
            'settings'      => 'kr_page_dark_overlay',
            'section'       => 'krystal_page_settings',
            'type'          => 'toggle',
            'label'         => esc_html__( 'Enable Dark Overlay:', 'krystal' ),
            'description'   => esc_html__( 'Choose whether to show a dark overlay over page header background', 'krystal' ), 
            'active_callback' => 'krystal_page_title_disable',          
        )
    ));

    // Info label
    $wp_customize->add_setting( 
        'kr_label_page_title_spacing', 
        array(
            'sanitize_callback' => 'krystal_sanitize_title',
        ) 
    );

    $wp_customize->add_control( 
        new Krystal_Title_Info_Control( $wp_customize, 'kr_label_page_title_spacing', 
        array(
            'label'       => esc_html__( 'Page Title Spacing', 'krystal' ),
            'section'     => 'krystal_page_settings',
            'type'        => 'title',
            'settings'    => 'kr_label_page_title_spacing',
            'active_callback' => 'krystal_page_title_disable',
        ) 
    ));

    // page title height from top //
    $wp_customize->add_setting(
        'kr_pagetitle_hft',
        array(
            'type' => 'theme_mod',
            'default'           => '125',
            'sanitize_callback' => 'absint'
        )
    );

    $wp_customize->add_control(
        'kr_pagetitle_hft',
        array(
            'settings'      => 'kr_pagetitle_hft',
            'section'       => 'krystal_page_settings',
            'type'          => 'textbox',
            'label'         => esc_html__( 'Page Title Height from Top(px)', 'krystal' ),
            'description'   => esc_html__( 'This will add top padding to the page title. Do not write px or em', 'krystal' ),
            'active_callback' => 'krystal_page_title_disable',
        )
    );

    // page title height from bottom //
    $wp_customize->add_setting(
        'kr_pagetitle_hfb',
        array(
            'type' => 'theme_mod',
            'default'           => '125',
            'sanitize_callback' => 'absint'
        )
    );

    $wp_customize->add_control(
        'kr_pagetitle_hfb',
        array(
            'settings'      => 'kr_pagetitle_hfb',
            'section'       => 'krystal_page_settings',
            'type'          => 'textbox',
            'label'         => esc_html__( 'Page Title Height from Bottom(px)', 'krystal' ),
            'description'   => esc_html__( 'This will add bottom padding to the page title. Do not write px or em', 'krystal' ),
            'active_callback' => 'krystal_page_title_disable',
        )
    );
          

    // Color Settings 
    $wp_customize->add_section(
        'krystal_color_settings',
        array (
            'priority'      => 25,
            'capability'    => 'edit_theme_options',
            'theme_supports'=> '',
            'title'         => esc_html__( 'Color Settings', 'krystal' )
        )
    );

    // Info label
    $wp_customize->add_setting( 
        'kr_label_color_settings', 
        array(
            'sanitize_callback' => 'krystal_sanitize_title',
        ) 
    );

    $wp_customize->add_control( 
        new Krystal_Title_Info_Control( $wp_customize, 'kr_label_color_settings', 
        array(
            'label'       => esc_html__( 'Color Settings', 'krystal' ),
            'section'     => 'krystal_color_settings',
            'type'        => 'title',
            'settings'    => 'kr_label_color_settings',
        ) 
    ));        

    
    // Link Color
    $wp_customize->add_setting(
        'kr_link_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#444444',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_link_color',
        array(
        'label'      => esc_html__( 'Links Color', 'krystal' ),
        'section'    => 'krystal_color_settings',
        'settings'   => 'kr_link_color',
        ) )
    );

    // Link Hover Color
    $wp_customize->add_setting(
        'kr_link_hover_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#000000',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_link_hover_color',
        array(
        'label'      => esc_html__( 'Links Hover Color', 'krystal' ),
        'section'    => 'krystal_color_settings',
        'settings'   => 'kr_link_hover_color',
        ) )
    );

    // Heading Color
    $wp_customize->add_setting(
        'kr_heading_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#444444',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_heading_color',
        array(
        'label'      => esc_html__( 'Headings Color', 'krystal' ),
        'section'    => 'krystal_color_settings',
        'settings'   => 'kr_heading_color',
        ) )
    );

    // Heading Hover Color
    $wp_customize->add_setting(
        'kr_heading_hover_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#000000',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_heading_hover_color',
        array(
        'label'      => esc_html__( 'Heading Hover Color', 'krystal' ),
        'section'    => 'krystal_color_settings',
        'settings'   => 'kr_heading_hover_color',
        ) )
    );


    // Buttons Color
    $wp_customize->add_setting(
        'kr_button_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#444444',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_button_color',
        array(
        'label'      => esc_html__( 'Buttons Color', 'krystal' ),
        'section'    => 'krystal_color_settings',
        'settings'   => 'kr_button_color',
        ) )
    );

    // Buttons Hover Color
    $wp_customize->add_setting(
        'kr_button_hover_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#000000',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_button_hover_color',
        array(
        'label'      => esc_html__( 'Buttons Hover Color', 'krystal' ),
        'section'    => 'krystal_color_settings',
        'settings'   => 'kr_button_hover_color',
        ) )
    );    


    // Transparent Buttons Hover Color
    $wp_customize->add_setting(
        'kr_trans_button_hover_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#000000',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_trans_button_hover_color',
        array(
        'label'      => esc_html__( 'Transparent Buttons Hover Color', 'krystal' ),
        'section'    => 'krystal_color_settings',
        'settings'   => 'kr_trans_button_hover_color',
        ) )
    );

    // Info label
    $wp_customize->add_setting( 
        'kr_label_menu_color_settings', 
        array(
            'sanitize_callback' => 'krystal_sanitize_title',
        ) 
    );

    $wp_customize->add_control( 
        new Krystal_Title_Info_Control( $wp_customize, 'kr_label_menu_color_settings', 
        array(
            'label'       => esc_html__( 'Top Menu', 'krystal' ),
            'section'     => 'krystal_color_settings',
            'type'        => 'title',
            'settings'    => 'kr_label_menu_color_settings',
        ) 
    )); 

    // Top menu color
    $wp_customize->add_setting(
        'kr_top_menu_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_top_menu_color',
        array(
        'label'      => esc_html__( 'Top Menu Color', 'krystal' ),
        'section'    => 'krystal_color_settings',
        'settings'   => 'kr_top_menu_color',
        ) )
    );

    // Top menu button background color
    $wp_customize->add_setting(
        'kr_top_menu_button_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#5b9dd9',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_top_menu_button_color',
        array(
        'label'      => esc_html__( 'Top Menu Button Color', 'krystal' ),
        'section'    => 'krystal_color_settings',
        'settings'   => 'kr_top_menu_button_color',
        ) )
    );

    // Top menu button text color
    $wp_customize->add_setting(
        'kr_top_menu_button_text_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#fff',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_top_menu_button_text_color',
        array(
        'label'      => esc_html__( 'Top Menu Button Text Color', 'krystal' ),
        'section'    => 'krystal_color_settings',
        'settings'   => 'kr_top_menu_button_text_color',
        ) )
    );

    // Menu dropdown color
    $wp_customize->add_setting(
        'kr_top_menu_dd_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#dd3333',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_top_menu_dd_color',
        array(
        'label'      => esc_html__( 'Menu Dropdown Background Color', 'krystal' ),
        'section'    => 'krystal_color_settings',
        'settings'   => 'kr_top_menu_dd_color',
        ) )
    );

    // Info label
    $wp_customize->add_setting( 
        'kr_label_home_bg_color_settings', 
        array(
            'sanitize_callback' => 'krystal_sanitize_title',
        ) 
    );

    $wp_customize->add_control( 
        new Krystal_Title_Info_Control( $wp_customize, 'kr_label_home_bg_color_settings', 
        array(
            'label'       => esc_html__( 'Home Background Section', 'krystal' ),
            'section'     => 'krystal_color_settings',
            'type'        => 'title',
            'settings'    => 'kr_label_home_bg_color_settings',
        ) 
    )); 

    // Home Background Image text color
    $wp_customize->add_setting(
        'kr_home_bg_image_text_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_home_bg_image_text_color',
        array(
        'label'      => esc_html__( 'Home Background Image Text Color', 'krystal' ),
        'section'    => 'krystal_color_settings',
        'settings'   => 'kr_home_bg_image_text_color',
        ) )
    );

    // Info label
    $wp_customize->add_setting( 
        'kr_label_page_bg_color_settings', 
        array(
            'sanitize_callback' => 'krystal_sanitize_title',
        ) 
    );

    $wp_customize->add_control( 
        new Krystal_Title_Info_Control( $wp_customize, 'kr_label_page_bg_color_settings', 
        array(
            'label'       => esc_html__( 'Page Background Section', 'krystal' ),
            'section'     => 'krystal_color_settings',
            'type'        => 'title',
            'settings'    => 'kr_label_page_bg_color_settings',
        ) 
    )); 

    // Page Background Image text color
    $wp_customize->add_setting(
        'kr_page_bg_image_text_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_page_bg_image_text_color',
        array(
        'label'      => esc_html__( 'Page Background Image Text Color', 'krystal' ),
        'section'    => 'krystal_color_settings',
        'settings'   => 'kr_page_bg_image_text_color',
        ) )
    );

    // Info label
    $wp_customize->add_setting( 
        'kr_label_cf_color_settings', 
        array(
            'sanitize_callback' => 'krystal_sanitize_title',
        ) 
    );

    $wp_customize->add_control( 
        new Krystal_Title_Info_Control( $wp_customize, 'kr_label_cf_color_settings', 
        array(
            'label'       => esc_html__( 'Contact Form', 'krystal' ),
            'section'     => 'krystal_color_settings',
            'type'        => 'title',
            'settings'    => 'kr_label_cf_color_settings',
        ) 
    )); 

    // Contact form label color
    $wp_customize->add_setting(
        'kr_cf_label_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#555555',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_cf_label_color',
        array(
        'label'      => esc_html__( 'Contact Form Label Color', 'krystal' ),
        'section'    => 'krystal_color_settings',
        'settings'   => 'kr_cf_label_color',
        ) )
    );

    // Contact form text color
    $wp_customize->add_setting(
        'kr_cf_text_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#555555',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_cf_text_color',
        array(
        'label'      => esc_html__( 'Contact Form Text Color', 'krystal' ),
        'section'    => 'krystal_color_settings',
        'settings'   => 'kr_cf_text_color',
        ) )
    );

    // Contact form elements bg color
    $wp_customize->add_setting(
        'kr_cf_bg_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#555',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_cf_bg_color',
        array(
        'label'      => esc_html__( 'Contact Form Elements Background Color', 'krystal' ),
        'section'    => 'krystal_color_settings',
        'settings'   => 'kr_cf_bg_color',
        ) )
    );

    // Contact form button color
    $wp_customize->add_setting(
        'kr_cf_button_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#555555',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_cf_button_color',
        array(
        'label'      => esc_html__( 'Contact Form Button Color', 'krystal' ),
        'section'    => 'krystal_color_settings',
        'settings'   => 'kr_cf_button_color',
        ) )
    );

    // Contact form button hover color
    $wp_customize->add_setting(
        'kr_cf_button_bg_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#555555',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_cf_button_bg_color',
        array(
        'label'      => esc_html__( 'Contact Form Button Hover Color', 'krystal' ),
        'section'    => 'krystal_color_settings',
        'settings'   => 'kr_cf_button_bg_color',
        ) )
    );
    
     //Blog Settings
    $wp_customize->add_section(
        'krystal_blog_settings',
        array (
            'priority'      => 25,
            'capability'    => 'edit_theme_options',
            'theme_supports'=> '',
            'title'         => esc_html__( 'Blog Settings', 'krystal' )
        )
    );

    // Info label
    $wp_customize->add_setting( 
        'kr_label_blog_settings', 
        array(
            'sanitize_callback' => 'krystal_sanitize_title',
        ) 
    );

    $wp_customize->add_control( 
        new Krystal_Title_Info_Control( $wp_customize, 'kr_label_blog_settings', 
        array(
            'label'       => esc_html__( 'Blog Settings', 'krystal' ),
            'section'     => 'krystal_blog_settings',
            'type'        => 'title',
            'settings'    => 'kr_label_blog_settings',
        ) 
    ));   

    // Blog Sidebar
    $wp_customize->add_setting(
        'kr_blog_sidebar',
        array(
            'type' => 'theme_mod',
            'default'           => 'right',
            'sanitize_callback' => 'krystal_sanitize_blog_sidebar_radio_selection'
        )
    );

    $wp_customize->add_control(
        'kr_blog_sidebar',
        array(
            'settings'      => 'kr_blog_sidebar',
            'section'       => 'krystal_blog_settings',
            'type'          => 'radio',
            'label'         => esc_html__( 'Select sidebar position:', 'krystal' ),
            'description'   => '',
            'choices' => array(
                            'right' => esc_html__( 'Right', 'krystal' ),
                            'left' =>esc_html__( 'Left', 'krystal' ),
                            ),
        )
    );

    //Form Settings
    $wp_customize->add_section(
        'krystal_form_settings',
        array (
            'priority'      => 25,
            'capability'    => 'edit_theme_options',
            'theme_supports'=> '',
            'title'         => esc_html__( 'Form Settings', 'krystal' )
        )
    ); 

    // Info label
    $wp_customize->add_setting( 
        'kr_label_form_settings', 
        array(
            'sanitize_callback' => 'krystal_sanitize_title',
        ) 
    );

    $wp_customize->add_control( 
        new Krystal_Title_Info_Control( $wp_customize, 'kr_label_form_settings', 
        array(
            'label'       => esc_html__( 'Form Settings', 'krystal' ),
            'section'     => 'krystal_form_settings',
            'type'        => 'title',
            'settings'    => 'kr_label_form_settings',
        ) 
    ));

    // Form Elements Style
    $wp_customize->add_setting(
        'kr_form_elem_settings_style',
        array(
            'type' => 'theme_mod',
            'default'           => 'default',
            'sanitize_callback' => 'krystal_sanitize_form_elem_radio_selection'
        )
    );

    $wp_customize->add_control(
        'kr_form_elem_settings_style',
        array(
            'settings'      => 'kr_form_elem_settings_style',
            'section'       => 'krystal_form_settings',
            'type'          => 'radio',
            'label'         => esc_html__( 'Select Form Elements Style:', 'krystal' ),
            'description'   => '',
            'choices' => array(
                            'default' => esc_html__( 'Default Style', 'krystal' ),
                            'bg' =>esc_html__( 'Solid Background Style', 'krystal' ),
                            ),
        )
    );

    // Info label
    $wp_customize->add_setting( 
        'kr_label_form_full_width_settings', 
        array(
            'sanitize_callback' => 'krystal_sanitize_title',
        ) 
    );

    $wp_customize->add_control( 
        new Krystal_Title_Info_Control( $wp_customize, 'kr_label_form_full_width_settings', 
        array(
            'label'       => esc_html__( 'Full Width Form', 'krystal' ),
            'section'     => 'krystal_form_settings',
            'type'        => 'title',
            'settings'    => 'kr_label_form_full_width_settings',
        ) 
    ));

    // Form width
    $wp_customize->add_setting(
        'kr_form_width_setting',
        array(
            'type' => 'theme_mod',
            'default'           => false,
            'sanitize_callback' => 'krystal_sanitize_checkbox_selection'
        )
    );

    $wp_customize->add_control(
        new Krystal_Toggle_Control( $wp_customize, 'kr_form_width_setting', 
        array(
            'settings'      => 'kr_form_width_setting',
            'section'       => 'krystal_form_settings',
            'type'          => 'toggle',
            'label'         => esc_html__( 'Enable Full Width Form', 'krystal' ),
            'description'   => '',           
        )
    ));
   

    //Footer Settings
    $wp_customize->add_section(
        'krystal_footer_settings',
        array (
            'priority'      => 25,
            'capability'    => 'edit_theme_options',
            'theme_supports'=> '',
            'title'         => esc_html__( 'Footer Settings', 'krystal' )
        )
    );

    // Info label
    $wp_customize->add_setting( 
        'kr_label_footer_settings', 
        array(
            'sanitize_callback' => 'krystal_sanitize_title',
        ) 
    );

    $wp_customize->add_control( 
        new Krystal_Title_Info_Control( $wp_customize, 'kr_label_footer_settings', 
        array(
            'label'       => esc_html__( 'Footer Settings', 'krystal' ),
            'section'     => 'krystal_footer_settings',
            'type'        => 'title',
            'settings'    => 'kr_label_footer_settings',
        ) 
    ));

    // Copyright text
    $wp_customize->add_setting(
        'kr_copyright_text',
        array(
            'type' => 'theme_mod',
            'default'           => esc_html__('Copyrights 2020 krystal. All Rights Reserved','krystal'),
            'sanitize_callback' => 'krystal_sanitize_textarea'
        )
    );

    $wp_customize->add_control(
        'kr_copyright_text',
        array(
            'settings'      => 'kr_copyright_text',
            'section'       => 'krystal_footer_settings',
            'type'          => 'textarea',
            'label'         => esc_html__( 'Footer copyright text', 'krystal' ),
            'description'   => esc_html__( 'Copyright text to be displayed in the footer. No HTML allowed', 'krystal' )
        )
    );

    // Info label
    $wp_customize->add_setting( 
        'kr_label_footer_widgets_settings', 
        array(
            'sanitize_callback' => 'krystal_sanitize_title',
        ) 
    );

    $wp_customize->add_control( 
        new Krystal_Title_Info_Control( $wp_customize, 'kr_label_footer_widgets_settings', 
        array(
            'label'       => esc_html__( 'Footer Widgets', 'krystal' ),
            'section'     => 'krystal_footer_settings',
            'type'        => 'title',
            'settings'    => 'kr_label_footer_widgets_settings',
        ) 
    ));

    // Footer widgets
    $wp_customize->add_setting(
        'kr_footer_widgets',
        array(
            'type' => 'theme_mod',
            'default'           => '4',
            'sanitize_callback' => 'krystal_sanitize_footer_widgets_radio_selection'
        )
    );

    $wp_customize->add_control(
        'kr_footer_widgets',
        array(
            'settings'      => 'kr_footer_widgets',
            'section'       => 'krystal_footer_settings',
            'type'          => 'radio',
            'label'         => esc_html__( 'Number of Footer Widgets:', 'krystal' ),
            'description'   => '',
            'choices' => array(
                            '3' => esc_html__( '3', 'krystal' ),
                            '4' =>esc_html__( '4', 'krystal' ),
                            ),
        )
    );

    // Info label
    $wp_customize->add_setting( 
        'kr_label_footer_color_settings', 
        array(
            'sanitize_callback' => 'krystal_sanitize_title',
        ) 
    );

    $wp_customize->add_control( 
        new Krystal_Title_Info_Control( $wp_customize, 'kr_label_footer_color_settings', 
        array(
            'label'       => esc_html__( 'Footer Color Settings', 'krystal' ),
            'section'     => 'krystal_footer_settings',
            'type'        => 'title',
            'settings'    => 'kr_label_footer_color_settings',
        ) 
    ));   

    // Footer background color
    $wp_customize->add_setting(
        'kr_footer_bg_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#000000',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_footer_bg_color',
        array(
        'label'      => esc_html__( 'Footer Background Color', 'krystal' ),
        'section'    => 'krystal_footer_settings',
        'settings'   => 'kr_footer_bg_color',
        ) )
    );    
   

    // Footer Content Color
    $wp_customize->add_setting(
        'kr_footer_content_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_footer_content_color',
        array(
        'label'      => esc_html__( 'Footer Content Color', 'krystal' ),
        'section'    => 'krystal_footer_settings',
        'settings'   => 'kr_footer_content_color',
        ) )
    );  

    // Footer links Color
    $wp_customize->add_setting(
        'kr_footer_links_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#b3b3b3',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        $wp_customize,
        'kr_footer_links_color',
        array(
        'label'      => esc_html__( 'Footer Links Color', 'krystal' ),
        'section'    => 'krystal_footer_settings',
        'settings'   => 'kr_footer_links_color',
        ) )
    );

    // Preloader Settings
    $wp_customize->add_section(
        'krystal_preloader_settings',
        array (
            'priority'      => 25,
            'capability'    => 'edit_theme_options',
            'theme_supports'=> '',
            'title'         => esc_html__( 'Preloader Settings', 'krystal' )
        )
    );

    // Info label
    $wp_customize->add_setting( 
        'kr_label_preloader_settings', 
        array(
            'sanitize_callback' => 'krystal_sanitize_title',
        ) 
    );

    $wp_customize->add_control( 
        new Krystal_Title_Info_Control( $wp_customize, 'kr_label_preloader_settings', 
        array(
            'label'       => esc_html__( 'Preloader Settings', 'krystal' ),
            'section'     => 'krystal_preloader_settings',
            'type'        => 'title',
            'settings'    => 'kr_label_preloader_settings',
        ) 
    ));

    // Preloader Enable radio button 
    $wp_customize->add_setting(
        'kr_preloader_display',
        array(
            'type' => 'theme_mod',
            'default'           => true,
            'sanitize_callback' => 'krystal_sanitize_checkbox_selection'
        )
    );

    $wp_customize->add_control(
        new Krystal_Toggle_Control( $wp_customize, 'kr_preloader_display', 
        array(
            'settings'      => 'kr_preloader_display',
            'section'       => 'krystal_preloader_settings',
            'type'          => 'toggle',
            'label'         => esc_html__( 'Enable Preloader for site:', 'krystal' ),
            'description'   => esc_html__( 'Choose whether to show a preloader before a site opens', 'krystal' ),            
        )
    ));

    // Info label
    $wp_customize->add_setting( 
        'kr_label_preloader_image_settings', 
        array(
            'sanitize_callback' => 'krystal_sanitize_title',
        ) 
    );

    $wp_customize->add_control( 
        new Krystal_Title_Info_Control( $wp_customize, 'kr_label_preloader_image_settings', 
        array(
            'label'       => esc_html__( 'Preloader Image Settings', 'krystal' ),
            'section'     => 'krystal_preloader_settings',
            'type'        => 'title',
            'settings'    => 'kr_label_preloader_image_settings',
            'active_callback' => 'krystal_preloader_enable',
        ) 
    ));

    // Image for preloader 
    $wp_customize->add_setting(
        'kr_preloader_image',
        array(
            'type' => 'theme_mod',
            'sanitize_callback' => 'krystal_sanitize_image'
        )
    );

    $wp_customize->add_control(
      new WP_Customize_Image_Control(
          $wp_customize,
          'kr_preloader_image',
          array(
              'settings'      => 'kr_preloader_image',
              'section'       => 'krystal_preloader_settings',
              'label'         => esc_html__( 'Preloader Image', 'krystal' ),
              'description'   => esc_html__( 'Upload image for preloader', 'krystal' ),
              'active_callback' => 'krystal_preloader_enable',
          )
      )
    );    
   
}
endif;

add_action( 'customize_register', 'krystal_customize_register' );



//customizer helper
get_template_part( 'inc/customizer/customizer-helpers' );

//data sanitization
get_template_part( 'inc/customizer/data-sanitization' );


/**
 * Enqueue the customizer stylesheet.
 */
if ( ! function_exists( 'krystal_enqueue_customizer_stylesheets' ) ) :
function krystal_enqueue_customizer_stylesheets() {
    wp_register_style( 'krystal-customizer-css', get_template_directory_uri() . '/inc/customizer/assets/customizer.css', NULL, NULL, 'all' );
    wp_enqueue_style( 'krystal-customizer-css' );
}
endif;

add_action( 'customize_controls_print_styles', 'krystal_enqueue_customizer_stylesheets' );
