<?php
/*
Template Name: Main Shop
*/
get_header(); ?>
<?php
     
    // if( class_exists( 'RWMB_Loader' ) )
    // {
    //     if( rwmb_meta( 'seopress_show_breadcrumb' ) == 1 )
    //     {
    //         seopress_press_breadcrumbs();
    //     }
    // }
?>

<div class='col-md-8'">
    <div class="left-content" >
<!-- ---------------show product list-->
        <?php
        $product_class_name = "product container-fluid";

        $pro_per_catogory = 8;
        $categories = get_categories(array(
            'parent' => 0,
            'hide_empty' => 1
        ));
        foreach ($categories as $category){
            $cat_name = $category->cat_name;
            if ($category->count > 0 And $cat_name != 'Uncategorized'){
                $cat_id = $category->term_id;
                $temp = $wp_query;
                $wp_query = null;
                $wp_query = new WP_Query();
                $wp_query->query('cat='.$cat_id.'&post_type=san-pham'.'&paged='.$paged);
                $count = 0;
        ?>
            <div class='panel panel-default' id="category-<?php echo $cat_id; ?>">
                <div class='panel-heading'> 
                    <a href='<?php echo get_category_link($cat_id)?>'><?php echo $cat_name ?></a>
                </div>
                <div  class='panel-body'>
        <?php
                
                while ($wp_query->have_posts()) : $wp_query->the_post(); 
                    if($count == $pro_per_catogory){
                        break;
                    }
                    $count++;

        ?>      
                <div <?php post_class($product_class_name); ?> id="product-<?php the_ID(); ?>">
                    <div class='row' >
                        <div class="col-sm-6">
                            <?php the_post_thumbnail( array('class' => 'product-thumb') ); ?>
                        </div>
                        <div class="col-sm-6">
                           <h3 class="product-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?> </a></h3>
                            <div class="info">
                                <p style="margin-top: 5px;"><?php echo get_post_meta( $post->ID, 'wpcf-don-gia', true ); ?></p>
                                <p class="product-status">
                                    <?php
                                        $product_status = get_post_meta( $post->ID, 'wpcf-xuat-xu', true );
                                        $product_new = get_post_meta($post->ID, "wpcf-san-pham-moi");
                                        if ($product_new[0] == 1) {
                                            echo "<strong style='color:green;'>Hàng mới</strong>";
                                        }
                                        //  else {
                                        //     echo "<strong style='color:red;'>Hết hàng</strong>"; 
                                        // }
                                        $product_hot = get_post_meta($post->ID, "wpcf-san-pham-hot");
                                        if ($product_hot[0] == 1) {
                                            echo "<br/><strong style='color:green;'>HOT</strong>";
                                        }
                                        //  else {
                                        //     echo "<strong style='color:red;'>Hết hàng</strong>"; 
                                        // }
                                        
                                    ?>
                                </p><!--Tình trạng sản phẩm-->
                                <a class="order-button" href="<?php the_permalink();?>">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                    </div>

             <?php endwhile; }?>
            </div>
            </div>
            <?php }?>
        <?php
            $wp_query = null;
            $wp_query = $temp;  // Reset
        ?>
        
<!-----------------show product list-->
        <nav>
            <?php previous_posts_link('&laquo; Mới hơn') ?>
            <?php next_posts_link('Cũ hơn &raquo;') ?>
        </nav>
        </div>
    </div>
<?php get_sidebar( 'page' ); ?>
<?php get_footer(); ?>
