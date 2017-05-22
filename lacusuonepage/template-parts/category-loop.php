<?php
	$product_class_name = "product container-fluid"; 	
	global $category;
	$cat_id = $category->term_id;
	$cat_name = $category->name;
    $temp = $wp_query;
    $wp_query = null;
    $wp_query = new WP_Query();
    $wp_query->query('cat='.$cat_id.'&post_type=san-pham'.'&paged='.$paged);
    $count = 0;
?>

    <ul class='veritem clearfix' id="post-<?php echo $cat_id ?>" >
<?php
    	$pro_per_catogory = 8;
	    while ($wp_query->have_posts()) : 
	    	$wp_query->the_post(); 
	        if($count == $pro_per_catogory){
	            break;
	    	}
	    	$count++;
?>		
        	<li>
                <div class="pd-img">
                    <?php the_post_thumbnail( array('class' => 'product-thumb') ); ?>
                </div>
                <div class="pd-ctn">
                    <h2 class="pd-tit">
                    	<a href="<?php the_permalink(); ?>"><?php the_title(); ?> </a>
                    </h2>
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
       		</li>
		<?php endwhile; ?>
	</ul>
<?php
    $wp_query = null;
    $wp_query = $temp;  // Reset
?>