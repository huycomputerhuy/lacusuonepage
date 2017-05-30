<?php
// Queue parent style followed by child/customized style
    add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles', PHP_INT_MAX);

    function theme_enqueue_styles() {
        wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css');
        wp_enqueue_style( 'parent-bootstrap-style', get_template_directory_uri() . '/css/bootstrap.css');
        wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/styles/child-style.css', array( 'parent-style' ) );
        // wp_enqueue_style( 'child-style_1', get_stylesheet_directory_uri() . '/styles/tmp.css', array( 'parent-style' ) );
    }
// add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
   
   
    //Remove "catagory" in link
    // add_filter('user_trailingslashit', 'remcat_function');
    // function remcat_function($link) {
    //     return $link;
    //     // return str_replace("/category/", "/", $link);
    // }
    // add_action('init', 'remcat_flush_rules');
    // function remcat_flush_rules() {
    //     global $wp_rewrite;
    //     $wp_rewrite->flush_rules();
    // }
    // add_filter('generate_rewrite_rules', 'remcat_rewrite');
    // function remcat_rewrite($wp_rewrite) {
    //     $new_rules = array('(.+)/page/(.+)/?' => 'index.php?category_name='.$wp_rewrite->preg_index(1).'&paged='.$wp_rewrite->preg_index(2));
    //     $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
    // }

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

?>