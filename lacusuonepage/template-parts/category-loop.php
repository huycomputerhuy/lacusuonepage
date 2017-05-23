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

    	function product_price($priceFloat) {
			$symbol = 'VNĐ';
			$symbol_thousand = '.';
			$decimal_place = 0;
			$price = number_format($priceFloat, $decimal_place, '', $symbol_thousand);
			return $price.$symbol;
		}

		function convert_price($price){
			// TODO: need to improve
			if (is_numeric($element)) {
				$price = str_replace('.', '', $price);  
				return str_replace(',', '', $price);  
			}else{
				return 0;
			}
		}

	    while ($wp_query->have_posts()) : 
	    	$wp_query->the_post(); 
	        if($count == $pro_per_catogory){
	            break;
	    	}
	    	$count++;
	    	$price =  get_post_meta( $post->ID, 'wpcf-don-gia', true );
	    	$discount = get_post_meta( $post->ID, 'wpcf-giam-gia', true );
	    	$sale_price = $price;
	    	if($discount){
	    		$sale_price = $price * ($discount/100);
	    	}
?>		
        	<li>
                <div class="pd-img">
                    <?php the_post_thumbnail( array('class' => 'product-thumb') ); ?>
                </div>
                <div class="pd-ctn">
                    <h2 class="pd-tit">
                    	<a href="<?php the_permalink(); ?>"><?php the_title(); ?> 
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

                    	</a>
                    </h2>
                    <div class="info">

                        <p style="margin-top: 5px;"><?php echo get_post_meta( $post->ID, 'wpcf-don-gia', true ); ?></p>

                        <p class="product-status"><?php echo get_post_meta( $post->ID, 'wpcf-xuat-xu', true ); ?></p>
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