<?php
// Queue parent style followed by child/customized style
    
    require_once (get_template_directory() . '/inc/init.php');
    require_once( '/inc/core/lacusu-options.php');

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

    function cal_pro_price($price, $discount_percent, $discount_vnd){
        $sale_price = convert_price($price);
        $discount_vnd = convert_price($discount_vnd);
        $sale_price_info['discount'] = false;
        if(!empty($discount_vnd)){
            $sale_price_info['discount'] = true;
            $sale_price_info['price'] =  convert2VND($sale_price);

            $sale_price = $sale_price - $discount_vnd;

            $discount_num = round(($discount_vnd * 100) / $sale_price, 2);

            $sale_price_info['discount_num'] =  $discount_num;
        }else{
            if(!empty($discount_percent)){
                $sale_price_info['discount'] = true;
                $sale_price_info['price'] =  convert2VND($sale_price);
                $sale_price = $sale_price - $sale_price * ($discount_percent/100);
                $sale_price_info['discount_num'] =  round($discount_percent, 2);
            }
        }
        $sale_price_info['sale_price'] =  convert2VND($sale_price);

        return $sale_price_info;
    }

    function get_sale_price ($pro_id) {
        $price =  get_post_meta( $pro_id, 'wpcf-don-gia', true );
        $discount_percent = get_post_meta( $pro_id, 'wpcf-giam-gia', true );
        $discount_vnd = get_post_meta( $pro_id, 'wpcf-giam-gia-vnd', true );
        return cal_pro_price($price, $discount_percent, $discount_vnd);
    }


    function get_image_ids($post_id, $field_name) {
     
        $images = (array) get_post_meta($post_id, $field_name, false); // cast to array in case there is only one item
        $ids = array();

        global $wpdb;

        foreach($images as $img) {
        $query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$img'";
        $id = $wpdb->get_var($query);
        $ids[] = $id;
        }

        // return implode(",",$ids);
        return $ids;
    }

    function get_attachment_meta( $attachment_id ) {

        $attachment = get_post( $attachment_id );
        return array(
            'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
            'caption' => $attachment->post_excerpt,
            'description' => $attachment->post_content,
            'href' => get_permalink( $attachment->ID ),
            'src' => $attachment->guid,
            'title' => $attachment->post_title
        );
    }

    // lacusu Breadcrumb.
    function lacusu_breadcrumbs()
    {
        $custom_taxonomy = 'product_type';

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
    
?>