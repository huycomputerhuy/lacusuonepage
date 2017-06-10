<?php
// Queue parent style followed by child/customized style
    
    require_once get_template_directory() . '/inc/init.php';

    add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles', PHP_INT_MAX);

    function theme_enqueue_styles() {
        wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css');
        wp_enqueue_style( 'parent-bootstrap-style', get_template_directory_uri() . '/css/bootstrap.css');
        wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/styles/child-style.css', array( 'parent-style' ) );
        wp_enqueue_style( 'child-style-alo', get_stylesheet_directory_uri() . '/styles/alo.css', array( 'parent-style' ) );
    }


    function convert2VND($priceFloat) {
            $priceFloat = convert_price($priceFloat);
            $symbol = ' VNĐ';
            $symbol_thousand = '.';
            $decimal_place = 0;
            $price = number_format($priceFloat, $decimal_place, '', $symbol_thousand);
            return $price.$symbol;
        };

    function convert_price($price){
        // TODO: need to improve
        $price = str_replace('.', '', $price);  
        $price = str_replace(',', '', $price);  
        if (is_numeric($price)) {
           return $price;
        }else{
            return 0;
        }
    }

    function cal_pro_price($price, $discountPer){
        $sale_price = convert_price($price);
        $sale_price_info['discount'] = false;
        if($discountPer){
            $sale_price_info['discount'] = true;
            $sale_price_info['price'] =  convert2VND($sale_price);
            $sale_price = $sale_price - $sale_price * ($discountPer/100);
            $sale_price_info['discount_num'] =  $discountPer;
        }
        $sale_price_info['sale_price'] =  convert2VND($sale_price);

        return $sale_price_info;
    }

    function get_sale_price ($pro_id) {
        $price =  get_post_meta( $pro_id, 'wpcf-don-gia', true );
        $discount = get_post_meta( $pro_id, 'wpcf-giam-gia', true );
        return cal_pro_price($price, $discount);
    }

    // lacusu Breadcrumb.
    function lacusu_breadcrumbs()
    {
        $custom_taxonomy = '';

        // Get the query & post information
        global $post,$wp_query;
           
        // Do not display on the homepage
        if ( !is_front_page() )
        {
           
            // Build the breadcrums
            echo '<ul class="breadcrumb small">';
               
            // Home page
            echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . __( 'Home', 'seopress' ) . '</a></li>';
               
           if ( is_home() )
           {
               echo '<li class="active">' . __( 'Blog', 'seopress' ) . '</li>';
           }
           elseif ( is_archive() && !is_tax() && !is_category() && !is_tag() && !is_year() && !is_month() && !is_day() && !is_author() )
           {
               // If post is a custom post type
                $post_type = get_post_type();
                  
                // If it is a custom post type display name and link
                if( $post_type != 'post' )
                {
                      
                    $post_type_object = get_post_type_object($post_type);
                    $post_type_archive = get_post_type_archive_link($post_type);
                  
                    echo '<li class="active">' . esc_attr( $post_type_object->labels->name ) . '</li>';
                  
                }

           }
           elseif ( is_archive() && is_tax() && !is_category() && !is_tag() )
           {
                // If post is a custom post type
                $post_type = get_post_type();
                  
                // If it is a custom post type display name and link
                if( $post_type != 'post' )
                {
                      
                    $post_type_object = get_post_type_object($post_type);
                    $post_type_archive = get_post_type_archive_link($post_type);
                  
                    echo '<li><a href="' . esc_url( $post_type_archive ) . '">' . esc_attr( $post_type_object->labels->name ) . '</a></li>';
                  
                }
                  
                $custom_tax_name = get_queried_object()->name;
                echo '<li class="active">' . esc_attr( $custom_tax_name ) . '</li>';
                  
            }
            elseif ( is_single() )
            {
                  
                // If post is a custom post type
                $post_type = get_post_type();
                  
                // If it is a custom post type display name and link
                if( $post_type != 'post' )
                {
                      
                    $post_type_object = get_post_type_object( $post_type );
                    $post_type_archive = get_post_type_archive_link( $post_type );
                    
                    //lacusu comment
                    // echo '<li><a href="' . esc_url( $post_type_archive ) . '">' . esc_attr( $post_type_object->labels->name ) . '</a></li>';
                  
                }
                  
                // Get post category info
                $category = get_the_category();
                $last_category = '';
                 
                if( !empty( $category ) )
                {
                  
                    // Get last category post is in
                    $pre_last_category = array_values( $category );
                    $last_category = end( $pre_last_category );
                      
                    // Get parent any categories and create array
                    $get_cat_parents = rtrim( get_category_parents( $last_category->term_id, true, ',' ),',' );
                    $cat_parents = explode( ',', $get_cat_parents );
                      
                    // Loop through parent categories and store in variable $cat_display
                    $cat_display = '';
                    foreach( $cat_parents as $parents )
                    {
                        $cat_display .= '<li>'.  wp_kses_post( $parents ) .'</li>';
                    }
                 
                }
                  
                // If it's a custom post type within a custom taxonomy
                
                $taxonomy_exists = taxonomy_exists( $custom_taxonomy );
                if( empty( $last_category ) && !empty( $custom_taxonomy ) && $taxonomy_exists )
                {
                       
                    $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                    $cat_id         = $taxonomy_terms[0]->term_id;
                    $cat_nicename   = $taxonomy_terms[0]->slug;
                    $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                    $cat_name       = $taxonomy_terms[0]->name;
                   
                }
                  
                // Check if the post is in a category
                if( !empty( $last_category ) )
                {
                    echo $cat_display; //already escaped
                    
                    //no need to escape core functions
                    echo '<li class="active">' . get_the_title() . '</li>';
                      
                // Else if post is in a custom taxonomy
                }
                elseif( !empty( $cat_id ) )
                {
                      
                    echo '<li><a href="' . esc_url( $cat_link ) . '">' . esc_attr( $cat_name ) . '</a></li>';
                    echo '<li class="active">' . get_the_title() . '</li>';
                  
                }
                else
                {
                      
                    echo '<li class="active">' . get_the_title() . '</li>';
                      
                }
                  
            }
            elseif ( is_category() )
            {
                   
                // Category page
                echo '<li class="active">' . __( 'Category: ', 'seopress' ) . single_cat_title( '', false ) . '</li>';
                   
            }
            elseif ( is_page() )
            {
                   
                // Standard page
                if( $post->post_parent )
                {
                       
                    // If child page, get parents 
                    $anc = get_post_ancestors( $post->ID );
                       
                    // Get parents in the right order
                    $anc = array_reverse($anc);
                       
                    // Parent page loop
                    $parents = '';
                    foreach ( $anc as $ancestor )
                    {
                        $parents .= '<li><a href="' . esc_url( get_permalink( $ancestor ) ) . '">' . get_the_title( $ancestor ) . '</a></li>';
                    }
                       
                    // Display parent pages
                    echo $parents;
                       
                    // Current page
                    echo '<li class="active">' . get_the_title() . '</li>';
                       
                }
                else
                {   
                    // Just display current page if not parents
                    echo '<li class="active">' . get_the_title() . '</li>';
                       
                }
                   
            }
            elseif ( is_tag() )
            {
                   
                // Tag page
                   
                // Get tag information
                $term_id        = get_query_var('tag_id');
                $taxonomy       = 'post_tag';
                $args           = 'include=' . $term_id;
                $terms          = get_terms( $taxonomy, $args );
                $get_term_id    = $terms[0]->term_id;
                $get_term_slug  = $terms[0]->slug;
                $get_term_name  = $terms[0]->name;
                   
                // Display the tag name
                echo '<li class="active">' . __( 'Tag: ', 'seopress' ) . esc_attr( $get_term_name ) . '</li>';
               
            }
            elseif ( is_day() )
            {
                   
                // Day archive
                   
                // Year link
                echo '<li><a href="' . get_year_link( get_the_time('Y') ) . '">' . get_the_time('Y') . '</a></li>';
                   
                // Month link
                echo '<li><a href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '">' . get_the_time('F') . '</a></li>';
                   
                // Day display
                echo '<li class="active">' . get_the_time('jS') . ' ' . get_the_time('F') . '</li>';
                   
            }
            elseif ( is_month() )
            {
                   
                // Month Archive
                   
                // Year link
                echo '<li><a href="' . get_year_link( get_the_time('Y') ) . '">' . get_the_time('Y') . '</a></li>';
                   
                // Month display
                echo '<li class="active">' . get_the_time('F') . '</li>';
                   
            }
            elseif ( is_year() )
            {

                // Display year archive
                echo '<li class="active">' . get_the_time('Y') . '</li>';
                   
            }
            elseif ( is_author() )
            {
                   
                // Auhor archive
                
                // Display author name
                echo '<li class="active">' . __( 'Author: ', 'seopress' ) . get_the_author() . '</li>';
               
            }
            elseif ( get_query_var( 'paged' ) )
            {
                // Paginated archives
                echo '<li class="active">' . __( 'Page: ', 'seopress' ) . get_query_var( 'paged' ) . '</li>';
            }
            elseif ( is_search() )
            {
               
                // Search results page
                echo '<li class="active">' . __( 'Search: ', 'seopress' ) . get_search_query() . '</li>'; 
            }
            elseif ( is_404() )
            {
                //error 404 page
                echo '<li class="active">' . __( 'Error 404', 'seopress' ) . '</li>';
            }
            else
            {
                echo '<li class="active">' . __( 'Untitled', 'seopress' ) . '</li>';
            }
           
            echo '</ul>';
               
        }
    }
    //Theme option definition
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
        'title'          => esc_attr__( 'Lacusu::Phone Contact', 'seopress' ),
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
    //End of phone contact
    //Color settings
    //color link
    Kirki::add_section( 'lacusu_color_link', array(
        'title'          => esc_attr__( 'Lacusu::Font - Color Link', 'seopress' ),
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
        'label'       => esc_attr__( 'Default Color of Mouse Over Links', 'seopress' ),
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
    //End color link
    //color Top Header
    Kirki::add_section( 'lacusu_color_top_header_sec', array(
        'title'          => esc_attr__( 'Lacusu::Font - Color Top Header', 'seopress' ),
        'panel'          => 'lacusu_options', // Not typically needed.
        'priority'       => 1,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '', // Rarely needed.
    ) );

    Kirki::add_field( 'seopress_config', array(
        'type'        => 'color',
        'settings'    => 'lacusu_color_top_header',
        'label'       => esc_attr__( 'Color of Top Hearder', 'seopress' ),
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
        'label'       => esc_attr__( 'Color of Top Hearder Text', 'seopress' ),
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
    //End Color Top Header
    //Color header
    Kirki::add_section( 'lacusu_color_header_sec', array(
        'title'          => esc_attr__( 'Lacusu::Font - Color Header', 'seopress' ),
        'panel'          => 'lacusu_options', // Not typically needed.
        'priority'       => 1,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '', // Rarely needed.
    ) );

    Kirki::add_field( 'seopress_config', array(
        'type'        => 'color',
        'settings'    => 'seopress_info_pro_clr',
        'label'       => esc_attr__( 'Color of Hearder', 'seopress' ),
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
        'label'       => esc_attr__( 'Color of Hearder Text', 'seopress' ),
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
        'label'       => esc_attr__( 'Color of Site Title', 'seopress' ),
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
        'label'       => esc_attr__( 'Color of Tagline', 'seopress' ),
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
    //End Color header
    //Color navbar
    Kirki::add_section( 'lacusu_color_navbar_sec', array(
        'title'          => esc_attr__( 'Lacusu::Font - Color Navigation Bar', 'seopress' ),
        'panel'          => 'lacusu_options', // Not typically needed.
        'priority'       => 1,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '', // Rarely needed.
    ) );

    Kirki::add_field( 'seopress_config', array(
        'type'        => 'color',
        'settings'    => 'lacusu_color_navbar',
        'label'       => esc_attr__( 'Color of Navigation Bar', 'seopress' ),
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
        'label'       => esc_attr__( 'Color of Hovering Navigation Bar', 'seopress' ),
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
        'label'       => esc_attr__( 'Color of Navigation Bar Text', 'seopress' ),
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

    //End Color navbar
    //Color Footer
    Kirki::add_section( 'lacusu_color_footer_sec', array(
        'title'          => esc_attr__( 'Lacusu::Font - Color Footer', 'seopress' ),
        'panel'          => 'lacusu_options', // Not typically needed.
        'priority'       => 1,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '', // Rarely needed.
    ) );

    Kirki::add_field( 'seopress_config', array(
        'type'        => 'color',
        'settings'    => 'lacusu_color_footer_copyright',
        'label'       => esc_attr__( 'Color of Footer', 'seopress' ),
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
        'label'       => esc_attr__( 'Color of Footer Text', 'seopress' ),
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

    //End Color Footer
    //Color button
    Kirki::add_section( 'lacusu_color_button_sec', array(
        'title'          => esc_attr__( 'Lacusu::Font - Color Button', 'seopress' ),
        'panel'          => 'lacusu_options', // Not typically needed.
        'priority'       => 1,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '', // Rarely needed.
    ) );

    Kirki::add_field( 'seopress_config', array(
        'type'        => 'color',
        'settings'    => 'lacusu_color_button',
        'label'       => esc_attr__( 'Color of button', 'seopress' ),
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
        'label'       => esc_attr__( 'Color of Hovering button', 'seopress' ),
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
        'label'       => esc_attr__( 'Color of Button Text', 'seopress' ),
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

    //End Color button
    //Color widget
    Kirki::add_section( 'lacusu_color_widget_title_sec', array(
        'title'          => esc_attr__( 'Lacusu::Font - Color Widget Title', 'seopress' ),
        'panel'          => 'lacusu_options', // Not typically needed.
        'priority'       => 1,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '', // Rarely needed.
    ) );
    Kirki::add_field( 'seopress_config', array(
        'type'        => 'color',
        'settings'    => 'lacusu_color_widget_title',
        'label'       => esc_attr__( 'Color of  Widget Title', 'seopress' ),
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
        'label'       => esc_attr__( 'Color of Widget Title Text', 'seopress' ),
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
        'label'       => esc_attr__( 'Color of Widget Title Text Size (px)', 'seopress' ),
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
    //End color widget
    //Color site menu button
    Kirki::add_section( 'lacusu_color_site_menu_button_sec', array(
        'title'          => esc_attr__( 'Lacusu::Font - Color Site Menu Button', 'seopress' ),
        'panel'          => 'lacusu_options', // Not typically needed.
        'priority'       => 1,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '', // Rarely needed.
    ) );

    Kirki::add_field( 'seopress_config', array(
        'type'        => 'color',
        'settings'    => 'lacusu_color_site_menu_button',
        'label'       => esc_attr__( 'Color of button', 'seopress' ),
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
        'label'       => esc_attr__( 'Color of Hovering button', 'seopress' ),
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

    //Color back-to-top-show button
    Kirki::add_section( 'lacusu_color_back_top_button_sec', array(
        'title'          => esc_attr__( 'Lacusu::Font - Color Back to Top Button', 'seopress' ),
        'panel'          => 'lacusu_options', // Not typically needed.
        'priority'       => 1,
        'capability'     => 'edit_theme_options',
        'theme_supports' => '', // Rarely needed.
    ) );

    Kirki::add_field( 'seopress_config', array(
        'type'        => 'color',
        'settings'    => 'lacusu_color_back_top_button',
        'label'       => esc_attr__( 'Color of button', 'seopress' ),
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
        'label'       => esc_attr__( 'Color of Hovering button', 'seopress' ),
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
    //End Color backto top button
    //Color Alo icon button
    // Kirki::add_section( 'lacusu_color_alo_icon_sec', array(
    //     'title'          => esc_attr__( 'Lacusu::Font - Color Alo Icon', 'seopress' ),
    //     'panel'          => 'lacusu_options', // Not typically needed.
    //     'priority'       => 1,
    //     'capability'     => 'edit_theme_options',
    //     'theme_supports' => '', // Rarely needed.
    // ) );

    // Kirki::add_field( 'seopress_config', array(
    //     'type'        => 'color',
    //     'settings'    => 'lacusu_color_alo_icon_button_hover',
    //     'label'       => esc_attr__( 'Color of Hovering button', 'seopress' ),
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
    //     'label'       => esc_attr__( 'Color of button', 'seopress' ),
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
    //End Color button
    //End of Color settings
?>