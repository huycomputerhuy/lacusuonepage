<?php
    //Theme option definition
    //set logo in customizer header
    function lacusu_configuration_sample_styling( $config )
    {
        return wp_parse_args( array(
            'logo_image'   => get_stylesheet_directory_uri() . '/images/lacusu_logo_theme_options.png',
            'description'  => __( 'A child theme of <a target="_blank" href="http://ewptheme.com/">SEOPress</a>.', 'seopress' ),
        ), $config );
    }
    add_filter( 'kirki/config', 'lacusu_configuration_sample_styling' );

    //the main panel
    Kirki::add_panel( 'lacusu_options', array(
        'priority'    => 1,
        'title'       => esc_attr__( 'Lacusu Options', 'seopress' ),
        'description' => esc_attr__( 'All options of lacusu child theme', 'seopress' ),
    ) );
    //the main panel END
    //Custom right footer
    Kirki::add_field( 'seopress_config', array(
        'type'        => 'editor',
        'settings'    => 'seopress_info_footer_right',
        'label'       => esc_attr__( 'Lacusu::Footer Right Content', 'seopress' ),
        'description' => esc_attr__( 'Content of Footer Right Side', 'seopress' ),
        'section'     => 'footer_copy_options',
        'default'     => '<p><a href="#">Terms of Use - Privacy Policy</a></p>',
        'priority'    => 1,
        'transport' => 'postMessage',
        'js_vars'   => array(
            array(
                'element'  => '.cprtrgh_ctmzr',
                'function' => 'html',
            ),
        ),
    ) );
    //phone contact
    Kirki::add_section( 'lacusu_phone_contact', array(
        'title'          => esc_attr__( 'Phone Contact', 'seopress' ),
        'panel'          => 'lacusu_options', // Not typically needed.
        'priority'       => 1,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '', // Rarely needed.
    ) );

    Kirki::add_field( 'seopress_config', array(
        'type'        => 'text',
        'settings'    => 'lacusu_phone_num_alo',
        'label'       => esc_attr__( 'Phone number for ALO ICON', 'seopress' ),
        'description' => esc_attr__( 'Edit phone number in ALO ICON', 'seopress' ),
        'section'     => 'lacusu_phone_contact',
        'default'     => '0901463986',
        'priority'    => 10,
    ) );

    Kirki::add_field( 'seopress_config', array(
        'type'        => 'text',
        'settings'    => 'lacusu_massgage_alo',
        'label'       => esc_attr__( 'Massage for ALO ICON', 'seopress' ),
        'description' => esc_attr__( 'Edit massage in ALO ICON', 'seopress' ),
        'section'     => 'lacusu_phone_contact',
        'default'     => 'Gọi chúng tôi ngay!',
        'priority'    => 10,
    ) );
    Kirki::add_field( 'seopress_config', array(
        'type'        => 'editor',
        'settings'    => 'lacusu_order_contact',
        'label'       => esc_attr__( 'Order information', 'seopress' ),
        'description' => esc_attr__( 'Edit order information. Ex. tel:0901463986', 'seopress' ),
        'section'     => 'lacusu_phone_contact',
        'default'     => '<span>Vui lòng gọi </span><a href="tel:0901463986">0901463986</a><span> hoặc </span><a href="tel:0948855439">0948855439</a>',
        'priority'    => 10,
    ) );
    //End of phone contact
    //Color settings
    //color link
    Kirki::add_section( 'lacusu_color_link', array(
        'title'          => esc_attr__( 'Font - Color of Link', 'seopress' ),
        'panel'          => 'lacusu_options', // Not typically needed.
        'priority'       => 1,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '', // Rarely needed.
    ) );

    Kirki::add_field( 'seopress_config', array(
        'type'        => 'color',
        'settings'    => 'seopress_default_a_color',
        'label'       => esc_attr__( 'Default Color of Links', 'seopress' ),
        'section'     => 'lacusu_color_link',
        'default'     => '#337ab7',
        'choices'     => array(
            'alpha' => true,
        ),
        'priority'    => 10,
        'output' => array(
            array(
                'element'  => 'body a, .woocommerce .woocommerce-breadcrumb a, .woocommerce .star-rating span',
                'property' => 'color',
            ),
            array(
                'element'  => '.widget_sidebar_main ul li::before',
                'property' => 'color',
            ),
            array(
                'element'  => '.navigation.pagination .nav-links .page-numbers, .navigation.pagination .nav-links .page-numbers:last-child',
                'property' => 'border-color',
            ),
        ),
        'transport' => 'auto',
    ) );

    Kirki::add_field( 'seopress_config', array(
        'type'        => 'color',
        'settings'    => 'seopress_default_a_mover_color',
        'label'       => esc_attr__( 'Default Color of of Mouse Over Links', 'seopress' ),
        'section'     => 'lacusu_color_link',
        'default'     => '#23527c',
        'choices'     => array(
            'alpha' => true,
        ),
        'priority'    => 10,
        'output' => array(
            array(
                'element'  => 'body a:hover, .woocommerce .woocommerce-breadcrumb a:hover',
                'property' => 'color',
            ),
            array(
                'element'  => '.widget_sidebar_main ul li:hover::before',
                'property' => 'color',
            ),
        ),
        'transport' => 'auto',
    ) );
    Kirki::add_field( 'seopress_config', array(
        'type'        => 'number',
        'settings'    => 'seopress_default_a_color_size',
        'label'       => esc_attr__( 'Size of text (px)', 'seopress' ),
        'section'     => 'lacusu_color_link',
        'default'     => '16',
        'choices'     => array(
            'alpha' => true,
        ),
        'priority'    => 10,
        'output' => array(
            array(
                'element'  => 'body a, .woocommerce .woocommerce-breadcrumb a, .woocommerce .star-rating span',
                'property' => 'font-size',
                'suffix' => 'px'
            ),
            array(
                'element'  => '.widget_sidebar_main ul li::before',
                'property' => 'font-size',
                'suffix' => 'px'
            )
        ),
        'transport' => 'auto',
    ) );
    //End color of link
    //color of Top Header
    Kirki::add_section( 'lacusu_color_top_header_sec', array(
        'title'          => esc_attr__( 'Font - Color of Top Header', 'seopress' ),
        'panel'          => 'lacusu_options', // Not typically needed.
        'priority'       => 1,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '', // Rarely needed.
    ) );

    Kirki::add_field( 'seopress_config', array(
        'type'        => 'color',
        'settings'    => 'lacusu_color_top_header',
        'label'       => esc_attr__( 'Color of of Top Hearder', 'seopress' ),
        'section'     => 'lacusu_color_top_header_sec',
        'default'     => '#337ab7',
        'choices'     => array(
            'alpha' => true,
        ),
        'priority'    => 10,
        'output' => array(
            array(
                'element'  => '.bgtoph',
                'property' => 'background-color',
            )
        ),
        'transport' => 'auto',
    ) );

    Kirki::add_field( 'seopress_config', array(
        'type'        => 'color',
        'settings'    => 'lacusu_color_top_header_text',
        'label'       => esc_attr__( 'Color of of Top Hearder Text', 'seopress' ),
        'section'     => 'lacusu_color_top_header_sec',
        'default'     => '#ffffff',
        'choices'     => array(
            'alpha' => true,
        ),
        'priority'    => 10,
        'output' => array(
            array(
                'element'  => '.bgtoph, .bgtoph a, .bgtoph-icon-clr ',
                'property' => 'color',
            ),
            array(
                'element'  => '.bgtoph-icon-clr ',
                'property' => 'border-color',
            )
        ),
        'transport' => 'auto',
    ) );
    Kirki::add_field( 'seopress_config', array(
        'type'        => 'number',
        'settings'    => 'lacusu_color_top_header_text_size',
        'label'       => esc_attr__( 'Size of text (px)', 'seopress' ),
        'section'     => 'lacusu_color_top_header_sec',
        'default'     => '15',
        'choices'     => array(
            'alpha' => true,
        ),
        'priority'    => 10,
        'output' => array(
            array(
                'element'  => '.bgtoph, .bgtoph a, .bgtoph-icon-clr',
                'property' => 'font-size',
                'suffix' => 'px'
            )
        ),
        'transport' => 'auto',
    ) );
    //End Color of Top Header
    //Color of header
    Kirki::add_section( 'lacusu_color_header_sec', array(
        'title'          => esc_attr__( 'Font - Color of Header', 'seopress' ),
        'panel'          => 'lacusu_options', // Not typically needed.
        'priority'       => 1,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '', // Rarely needed.
    ) );

    Kirki::add_field( 'seopress_config', array(
        'type'        => 'color',
        'settings'    => 'seopress_info_pro_clr',
        'label'       => esc_attr__( 'Color of of Hearder', 'seopress' ),
        'section'     => 'lacusu_color_header_sec',
        'default'     => '#ffffff',
        'choices'     => array(
            'alpha' => true,
        ),
        'priority'    => 10,
        'output' => array(
            array(
                'element'  => '.headermain',
                'property' => 'background-color',
            )
        ),
        'transport' => 'auto',
    ) );

    Kirki::add_field( 'seopress_config', array(
        'type'        => 'color',
        'settings'    => 'seopress_info_pro_clr_text',
        'label'       => esc_attr__( 'Color of of Hearder Text', 'seopress' ),
        'section'     => 'lacusu_color_header_sec',
        'default'     => '#000000',
        'choices'     => array(
            'alpha' => true,
        ),
        'priority'    => 10,
        'output' => array(
            array(
                'element'  => '.headermain a',
                'property' => 'color',
            )
        ),
        'transport' => 'auto',
    ) );

    Kirki::add_field( 'seopress_config', array(
        'type'        => 'color',
        'settings'    => 'lacusu_site_name_text',
        'label'       => esc_attr__( 'Color of of Site Title', 'seopress' ),
        'section'     => 'lacusu_color_header_sec',
        'default'     => '#000000',
        'choices'     => array(
            'alpha' => true,
        ),
        'priority'    => 10,
        'output' => array(
            array(
                'element'  => '.headermain a h3',
                'property' => 'color',
            )
        ),
        'transport' => 'auto',
    ) );

     Kirki::add_field( 'seopress_config', array(
        'type'        => 'color',
        'settings'    => 'lacusu_tagline_text',
        'label'       => esc_attr__( 'Color of of Tagline', 'seopress' ),
        'section'     => 'lacusu_color_header_sec',
        'default'     => '#000000',
        'choices'     => array(
            'alpha' => true,
        ),
        'priority'    => 10,
        'output' => array(
            array(
                'element'  => '.headermain a p',
                'property' => 'color',
            )
        ),
        'transport' => 'auto',
    ) );

    Kirki::add_field( 'seopress_config', array(
        'type'        => 'number',
        'settings'    => 'lacusu_site_title_size',
        'label'       => esc_attr__( 'Size of Site Title (px)', 'seopress' ),
        'section'     => 'lacusu_color_header_sec',
        'default'     => '16',
        'choices'     => array(
            'alpha' => true,
        ),
        'priority'    => 10,
        'output' => array(
            array(
                'element'  => '.headermain a h3',
                'property' => 'font-size',
                'suffix' => 'px !important'
            )
        ),
        'transport' => 'auto',
    ) );

    Kirki::add_field( 'seopress_config', array(
        'type'        => 'number',
        'settings'    => 'lacusu_tagline_size',
        'label'       => esc_attr__( 'Size of tagline (px)', 'seopress' ),
        'section'     => 'lacusu_color_header_sec',
        'default'     => '16',
        'choices'     => array(
            'alpha' => true,
        ),
        'priority'    => 10,
        'output' => array(
            array(
                'element'  => '.headermain a p',
                'property' => 'font-size',
                'suffix' => 'px'
            )
        ),
        'transport' => 'auto',
    ) );
    //End Color of header
    //Color of navbar
    Kirki::add_section( 'lacusu_color_navbar_sec', array(
        'title'          => esc_attr__( 'Font - Color of Navigation Bar', 'seopress' ),
        'panel'          => 'lacusu_options', // Not typically needed.
        'priority'       => 1,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '', // Rarely needed.
    ) );

    Kirki::add_field( 'seopress_config', array(
        'type'        => 'color',
        'settings'    => 'lacusu_color_navbar',
        'label'       => esc_attr__( 'Color of of Navigation Bar', 'seopress' ),
        'section'     => 'lacusu_color_navbar_sec',
        'default'     => '#337ab7',
        'choices'     => array(
            'alpha' => true,
        ),
        'priority'    => 10,
        'output' => array(
            array(
                'element'  => '#navbar, #navbar ul.dropdown-menu',
                'property' => 'background-color',
            )
        ),
        'transport' => 'auto',
    ) );

    Kirki::add_field( 'seopress_config', array(
        'type'        => 'color',
        'settings'    => 'lacusu_color_navbar_hover',
        'label'       => esc_attr__( 'Color of of Hovering Navigation Bar', 'seopress' ),
        'section'     => 'lacusu_color_navbar_sec',
        'default'     => '#e7e7e7',
        'choices'     => array(
            'alpha' => true,
        ),
        'priority'    => 10,
        'output' => array(
            array(
                'element'  => '#navbar ul.dropdown-menu li:hover a, #navbar ul.dropdown-menu .current-menu-item a, #navbar .current-menu-item, #navbar .menu-item-type-custom:hover, #navbar .menu-item-type-post_type:hover, #navbar .menu-item-type-taxonomy:hover, #navbar ul li.current-menu-parent',
                'property' => 'background-color',
                'suffix'   => ' !important'
            )
        ),
        'transport' => 'auto',
    ) );

    Kirki::add_field( 'seopress_config', array(
        'type'        => 'color',
        'settings'    => 'lacusu_color_navbar_text',
        'label'       => esc_attr__( 'Color of of Navigation Bar Text', 'seopress' ),
        'section'     => 'lacusu_color_navbar_sec',
        'default'     => '#ffffff',
        'choices'     => array(
            'alpha' => true,
        ),
        'priority'    => 10,
        'output' => array(
            array(
                'element'  => '#navbar ul li a, #navbar ul.dropdown-menu li a',
                'property' => 'color',
                'suffix'   => ' !important'
            )
        ),
        'transport' => 'auto',
    ) );

    Kirki::add_field( 'seopress_config', array(
        'type'        => 'number',
        'settings'    => 'lacusu_navbar_size',
        'label'       => esc_attr__( 'Size of text (px)', 'seopress' ),
        'section'     => 'lacusu_color_navbar_sec',
        'default'     => '18',
        'choices'     => array(
            'alpha' => true,
        ),
        'priority'    => 10,
        'output' => array(
            array(
                'element'  => '#navbar ul li a, #navbar ul.dropdown-menu li a',
                'property' => 'font-size',
                'suffix' => 'px'
            )
        ),
        'transport' => 'auto',
    ) );

    //End Color of navbar
    //Color of Footer
    Kirki::add_section( 'lacusu_color_footer_sec', array(
        'title'          => esc_attr__( 'Font - Color of Footer', 'seopress' ),
        'panel'          => 'lacusu_options', // Not typically needed.
        'priority'       => 1,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '', // Rarely needed.
    ) );

    Kirki::add_field( 'seopress_config', array(
        'type'        => 'color',
        'settings'    => 'lacusu_color_footer_copyright',
        'label'       => esc_attr__( 'Color of of Footer', 'seopress' ),
        'section'     => 'lacusu_color_footer_sec',
        'default'     => '#060606',
        'choices'     => array(
            'alpha' => true,
        ),
        'priority'    => 10,
        'output' => array(
            array(
                'element'  => '.footer-copyright',
                'property' => 'background-color',
            )
        ),
        'transport' => 'auto',
    ) );

    Kirki::add_field( 'seopress_config', array(
        'type'        => 'color',
        'settings'    => 'lacusu_color_footer_copyright_text',
        'label'       => esc_attr__( 'Color of of Footer Text', 'seopress' ),
        'section'     => 'lacusu_color_footer_sec',
        'default'     => '#a7a7a7',
        'choices'     => array(
            'alpha' => true,
        ),
        'priority'    => 10,
        'output' => array(
            array(
                'element'  => '.footer-copyright',
                'property' => 'color',
            )
        ),
        'transport' => 'auto',
    ) );

    Kirki::add_field( 'seopress_config', array(
        'type'        => 'number',
        'settings'    => 'lacusu_footer_size',
        'label'       => esc_attr__( 'Size of text (px)', 'seopress' ),
        'section'     => 'lacusu_color_footer_sec',
        'default'     => '15',
        'choices'     => array(
            'alpha' => true,
        ),
        'priority'    => 10,
        'output' => array(
            array(
                'element'  => '.footer-copyright',
                'property' => 'font-size',
                'suffix' => 'px'
            )
        ),
        'transport' => 'auto',
    ) );

    //End Color of Footer
    //Color of button
    Kirki::add_section( 'lacusu_color_button_sec', array(
        'title'          => esc_attr__( 'Font - Color of Button', 'seopress' ),
        'panel'          => 'lacusu_options', // Not typically needed.
        'priority'       => 1,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '', // Rarely needed.
    ) );

    Kirki::add_field( 'seopress_config', array(
        'type'        => 'color',
        'settings'    => 'lacusu_color_button',
        'label'       => esc_attr__( 'Color of of button', 'seopress' ),
        'section'     => 'lacusu_color_button_sec',
        'default'     => '#337ab7',
        'choices'     => array(
            'alpha' => true,
        ),
        'priority'    => 10,
        'output' => array(
            array(
                'element'  => '.seopressbtn',
                'property' => 'background-color',
            )
        ),
        'transport' => 'auto',
    ) );

    Kirki::add_field( 'seopress_config', array(
        'type'        => 'color',
        'settings'    => 'lacusu_color_button_hover',
        'label'       => esc_attr__( 'Color of of Hovering button', 'seopress' ),
        'section'     => 'lacusu_color_button_sec',
        'default'     => '#286090',
        'choices'     => array(
            'alpha' => true,
        ),
        'priority'    => 10,
        'output' => array(
            array(
                'element'  => '.seopressbtn:hover',
                'property' => 'background-color',
            )
        ),
        'transport' => 'auto',
    ) );

    Kirki::add_field( 'seopress_config', array(
        'type'        => 'color',
        'settings'    => 'lacusu_color_button_text',
        'label'       => esc_attr__( 'Color of of Button Text', 'seopress' ),
        'section'     => 'lacusu_color_button_sec',
        'default'     => '#ffffff',
        'choices'     => array(
            'alpha' => true,
        ),
        'priority'    => 10,
        'output' => array(
            array(
                'element'  => '.seopressbtn',
                'property' => 'color',
            )
        ),
        'transport' => 'auto',
    ) );

    Kirki::add_field( 'seopress_config', array(
        'type'        => 'number',
        'settings'    => 'lacusu_button_text_size',
        'label'       => esc_attr__( 'Size of text (px)', 'seopress' ),
        'section'     => 'lacusu_color_button_sec',
        'default'     => '14',
        'choices'     => array(
            'alpha' => true,
        ),
        'priority'    => 10,
        'output' => array(
            array(
                'element'  => '.seopressbtn',
                'property' => 'font-size',
                'suffix' => 'px'
            )
        ),
        'transport' => 'auto',
    ) );

    //End Color of button
    //Color of widget
    Kirki::add_section( 'lacusu_color_widget_title_sec', array(
        'title'          => esc_attr__( 'Font - Color of Widget Title', 'seopress' ),
        'panel'          => 'lacusu_options', // Not typically needed.
        'priority'       => 1,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '', // Rarely needed.
    ) );
    Kirki::add_field( 'seopress_config', array(
        'type'        => 'color',
        'settings'    => 'lacusu_color_widget_title',
        'label'       => esc_attr__( 'Color of of  Widget Title', 'seopress' ),
        'section'     => 'lacusu_color_widget_title_sec',
        'default'     => '#337ab7',
        'choices'     => array(
            'alpha' => true,
        ),
        'priority'    => 10,
        'output' => array(
            array(
                'element'  => '.widget_sidebar_main .right-widget-title',
                'property' => 'background-color',
            )
        ),
        'transport' => 'auto',
    ) );

    Kirki::add_field( 'seopress_config', array(
        'type'        => 'color',
        'settings'    => 'lacusu_color_widget_title_text',
        'label'       => esc_attr__( 'Color of of Widget Title Text', 'seopress' ),
        'section'     => 'lacusu_color_widget_title_sec',
        'default'     => '#ffffff',
        'choices'     => array(
            'alpha' => true,
        ),
        'priority'    => 10,
        'output' => array(
            array(
                'element'  => '.widget_sidebar_main .right-widget-title',
                'property' => 'color',
            )
        ),
        'transport' => 'auto',
    ) );

    Kirki::add_field( 'seopress_config', array(
        'type'        => 'number',
        'settings'    => 'lacusu_color_widget_title_text_size',
        'label'       => esc_attr__( 'Color of of Widget Title Text Size (px)', 'seopress' ),
        'section'     => 'lacusu_color_widget_title_sec',
        'default'     => '16',
        'choices'     => array(
            'alpha' => true,
        ),
        'priority'    => 10,
        'output' => array(
            array(
                'element'  => '.widget_sidebar_main .right-widget-title',
                'property' => 'font-size',
                'suffix' => 'px !important'
            )
        ),
        'transport' => 'auto',
    ) );
    //End color of widget
    //Color of site menu button
    Kirki::add_section( 'lacusu_color_site_menu_button_sec', array(
        'title'          => esc_attr__( 'Font - Color of Site Menu Button', 'seopress' ),
        'panel'          => 'lacusu_options', // Not typically needed.
        'priority'       => 1,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '', // Rarely needed.
    ) );

    Kirki::add_field( 'seopress_config', array(
        'type'        => 'color',
        'settings'    => 'lacusu_color_site_menu_button',
        'label'       => esc_attr__( 'Color of of button', 'seopress' ),
        'section'     => 'lacusu_color_site_menu_button_sec',
        'default'     => '#337ab7',
        'choices'     => array(
            'alpha' => true,
        ),
        'priority'    => 10,
        'output' => array(
            array(
                'element'  => '.side-menu-menu-button',
                'property' => 'background-color',
            )
        ),
        'transport' => 'auto',
    ) );

    Kirki::add_field( 'seopress_config', array(
        'type'        => 'color',
        'settings'    => 'lacusu_color_site_menu_button_hover',
        'label'       => esc_attr__( 'Color of of Hovering button', 'seopress' ),
        'section'     => 'lacusu_color_site_menu_button_sec',
        'default'     => '#286090',
        'choices'     => array(
            'alpha' => true,
        ),
        'priority'    => 10,
        'output' => array(
            array(
                'element'  => '.side-menu-menu-button:hover',
                'property' => 'background-color',
            )
        ),
        'transport' => 'auto',
    ) );
    //End site nemu button

    //Color of back-to-top-show button
    Kirki::add_section( 'lacusu_color_back_top_button_sec', array(
        'title'          => esc_attr__( 'Font - Color of Back to Top Button', 'seopress' ),
        'panel'          => 'lacusu_options', // Not typically needed.
        'priority'       => 1,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '', // Rarely needed.
    ) );

    Kirki::add_field( 'seopress_config', array(
        'type'        => 'color',
        'settings'    => 'lacusu_color_back_top_button',
        'label'       => esc_attr__( 'Color of of button', 'seopress' ),
        'section'     => 'lacusu_color_back_top_button_sec',
        'default'     => '#337ab7',
        'choices'     => array(
            'alpha' => true,
        ),
        'priority'    => 10,
        'output' => array(
            array(
                'element'  => '.back-to-top-show',
                'property' => 'background-color',
                'suffix' => '!important'
            )
        ),
        'transport' => 'auto',
    ) );

    Kirki::add_field( 'seopress_config', array(
        'type'        => 'color',
        'settings'    => 'lacusu_color_back_top_button_hover',
        'label'       => esc_attr__( 'Color of of Hovering button', 'seopress' ),
        'section'     => 'lacusu_color_back_top_button_sec',
        'default'     => '#286090',
        'choices'     => array(
            'alpha' => true,
        ),
        'priority'    => 10,
        'output' => array(
            array(
                'element'  => '.back-to-top-show:hover',
                'property' => 'background-color',
                'suffix' => '!important'
            )
        ),
        'transport' => 'auto',
    ) );
    //End Color of backto top button
    //Color of Alo icon button
    // Kirki::add_section( 'lacusu_color_alo_icon_sec', array(
    //     'title'          => esc_attr__( 'Font - Color of Alo Icon', 'seopress' ),
    //     'panel'          => 'lacusu_options', // Not typically needed.
    //     'priority'       => 1,
    //     'capability'     => 'edit_theme_options',
    //     'theme_supports' => '', // Rarely needed.
    // ) );

    // Kirki::add_field( 'seopress_config', array(
    //     'type'        => 'color',
    //     'settings'    => 'lacusu_color_alo_icon_button_hover',
    //     'label'       => esc_attr__( 'Color of of Hovering button', 'seopress' ),
    //     'section'     => 'lacusu_color_alo_icon_sec',
    //     'default'     => 'rgba(0, 175, 242, 0.5)',
    //     'choices'     => array(
    //         'alpha' => true,
    //     ),
    //     'priority'    => 10,
    //     'output' => array(
    //         array(
    //             'element'  => '.quick-alo-ph-circle, .quick-alo-ph-circle-fill, .quick-alo-ph-img-circle',
    //             'property' => 'background-color'
    //         ),
    //         array(
    //             'element'  => '.quick-alo-phone.quick-alo-green .quick-alo-ph-img-circle',
    //             'property' => 'background-color'
    //         ),
    //         array(
    //             'element'  => '.quick-alo-phone.quick-alo-hover .quick-alo-ph-circle-fill,.quick-alo-phone:hover .quick-alo-ph-circle-fill',
    //             'property' => 'background-color'
    //         )
    //     ),
    //     'transport' => 'auto',
    // ) );

    // Kirki::add_field( 'seopress_config', array(
    //     'type'        => 'color',
    //     'settings'    => 'lacusu_color_alo_icon_button',
    //     'label'       => esc_attr__( 'Color of of button', 'seopress' ),
    //     'section'     => 'lacusu_color_alo_icon_sec',
    //     'default'     => 'rgba(117, 235, 80, 0.5)',
    //     'choices'     => array(
    //         'alpha' => true,
    //     ),
    //     'priority'    => 10,
    //     'output' => array(
    //         array(
    //             'element'  => '.quick-alo-ph-circle:hover, .quick-alo-ph-circle-fill:hover, .quick-alo-ph-img-circle:hover',
    //             'property' => 'background-color'
    //         ),
    //         array(
    //             'element'  => '.quick-alo-phone.quick-alo-green:hover .quick-alo-ph-img-circle:hover',
    //             'property' => 'background-color'
    //         ),
    //         array(
    //             'element'  => '.quick-alo-phone.quick-alo-green.quick-alo-hover .quick-alo-ph-circle, .quick-alo-phone.quick-alo-green:hover .quick-alo-ph-circle',
    //             'property' => 'background-color'
    //         ),
    //         array(
    //             'element'  => '.quick-alo-phone.quick-alo-green.quick-alo-hover .quick-alo-ph-circle-fill,.quick-alo-phone.quick-alo-green:hover .quick-alo-ph-circle-fill',
    //             'property' => 'background-color'
    //         )
    //     ),
    //     'transport' => 'auto',
    // ) );
    //End Color of button
    //End of Color settings
?>