<?php
	$product_class_name = "product container-fluid"; 	
    $pro_per_catogory = 8;
    if(!is_page_template("shop.php")){
        global $term_id;        
        $args = array( 
            'post_type' => 'san-pham',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_type',
                    'field'    => 'term_id',
                    'terms'    => $term_id
            )),
        );
    }else{
	   global $product_type;
        $term_id = $product_type->term_id;
        $args = array( 
            'post_type' => 'san-pham',
            'posts_per_page' => $pro_per_catogory,
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_type',
                    'field'    => 'term_id',
                    'terms'    => $term_id
            )),
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
    $has_post = false;
?>

    <ul class='veritem clearfix' id="term-id-<?php echo $term_id ?>" >
<?php
    	
	    while ($wp_query->have_posts()) : 
	    	$wp_query->the_post(); 
	    	$has_post = true;
	    	$price =  get_post_meta( $post->ID, 'wpcf-don-gia', true );
            $discount_vnd = get_post_meta( $post->ID, 'wpcf-giam-gia-vnd', true );
            $discount_percent = get_post_meta( $post->ID, 'wpcf-giam-gia', true );
	    	$sale_price_info = cal_pro_price($price, $discount_percent, $discount_vnd);
?>		
        	<li>
                <div class="pd-img">
                	<?php if($sale_price_info['discount']){ ?>
                	<span class="pd-promotion"><?php echo '-'. $sale_price_info[discount_num] . '%'?></span>
                    <?php } ?>
                    <a href="<?php the_permalink(); ?>">
                        <?php
                        $image_ids = get_image_ids($post->ID, 'wpcf-hinh-anh-san-pham');
                        $image_meta = get_attachment_meta($image_ids[0]);
                        ?>
                        <img src="<?php echo $image_meta['src']; ?>" class="zoom_image" alt="<?php echo $image_meta['alt']; ?>" title="<?php echo $image_meta['title']; ?>">
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
        if(!$has_post){
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