<?php
	$product_class_name = "product container-fluid"; 	
	global $category;
    $pro_per_catogory = 8;
    if(empty($category)){
        global $cat_id;
        $pro_per_catogory = 0;        
        $args = array( 
            'post_type' => 'san-pham',
            'cat' => $cat_id
        );
    }else{
        $cat_id = $category->term_id;
        $args = array( 
            'post_type' => 'san-pham',
            'cat' => $cat_id,
            'meta_query' => array(
                array(
                    'key' => 'wpcf-hien-thi-trang-chu',
                    'value' => 1,
                    'compare' => '='
            ))

        );
    }
    $temp = $wp_query;
    $wp_query = null;
    $wp_query = new WP_Query($args);
    $count = 0;
?>

    <ul class='veritem clearfix' id="cat-<?php echo $cat_id ?>" >
<?php
    	
	    while ($wp_query->have_posts()) : 
	    	$wp_query->the_post(); 
	        if($pro_per_catogory != 0 && $count == $pro_per_catogory){
	            break;
	    	}
	    	$count++;
	    	$price =  get_post_meta( $post->ID, 'wpcf-don-gia', true );
	    	$discount = get_post_meta( $post->ID, 'wpcf-giam-gia', true );
	    	$sale_price_info = cal_pro_price($price, $discount);
?>		
        	<li>
                <div class="pd-img">
                	<?php if($sale_price_info['discount']){ ?>
                	<span class="pd-promotion"><?php echo '-'. $discount . '%'?></span>
                    <?php } ?>
                    <a href="<?php the_permalink(); ?>">
                        <?php 
                        the_post_thumbnail( array('class' => 'product-thumb') ); 
                        ?>
                    </a>
                </div>
                <div class="pd-ctn">
                    <h2 class="pd-tit">
                    	<a href="<?php the_permalink(); ?>"><?php the_title(); ?> 
                    	</a>
                		<?php if(get_post_meta($post->ID, "wpcf-san-pham-moi")[0] == 1) { ?>
                    	<span>	
                    		<img class="pro_new_icon" src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon_pro_new.gif">
                    	</span>
                    	<?php } ?>

                    	<?php if(get_post_meta($post->ID, "wpcf-san-pham-hot")[0] == 1) { ?>
                    	<span>	
                    		<img class="pro_new_icon" src="<?php echo get_stylesheet_directory_uri(); ?>/images/icon_pro_hot.gif">
                    	</span>
                    	<?php } ?>

                    </h2>
                    <div class="price">
                    	<?php if($sale_price_info['discount']){ ?>
                        <span class="price-sale" ><?php echo convert2VND($price) ?></span>
                        <?php } ?>

                        <span class="price-discount" ><?php echo $sale_price_info['sale_price'] ?></span>
                    </div>
               		<?php /*
                    $made_in = get_post_meta( $post->ID, 'wpcf-xuat-xu', true );
                    if($made_in){
               		*/?>
                    <!-- <div class="pd-made-in"> -->
                        <?php// echo 'Xuất xứ: '. $made_in ?>
                    <!-- </div> -->
                    <?php //} 
                    get_template_part( 'template-parts/contact', 'order' );
                    ?>
                    <div class="pd-text"> <?php echo get_post_meta($post->ID, "wpcf-tom-tat-san-pham", true) ?> </div>
                </div>
       		</li>
		<?php endwhile; 
        if($count == 0){
        ?>
            <div class="pd-text">
                <span><?php echo 'Sản phẩm đang được cập nhật...' ?></span>
            </div>
        <?php } ?>
	</ul>
<?php
    $wp_query = null;
    $wp_query = $temp;  // Reset
?>