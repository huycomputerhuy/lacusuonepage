<?php
// Queue parent style followed by child/customized style
    add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles', PHP_INT_MAX);

    function theme_enqueue_styles() {
        wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css');
        wp_enqueue_style( 'parent-bootstrap-style', get_template_directory_uri() . '/css/bootstrap.css');
        wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/styles/child-style.css', array( 'parent-style' ) );
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

?>