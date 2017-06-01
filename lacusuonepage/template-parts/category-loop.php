<?php
	$product_class_name = "product container-fluid"; 	
	global $category;
    $pro_per_catogory = 8;
    if(empty($category)){
        global $cat_id;
        $pro_per_catogory = 0;        
    }else{
	   $cat_id = $category->term_id;

    }
	// $cat_name = $category->name;
    $temp = $wp_query;
    $wp_query = null;
    $wp_query = new WP_Query();
    $wp_query->query('cat='.$cat_id.'&post_type=san-pham'.'&paged='.$paged);
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
                    <?php the_post_thumbnail( array('class' => 'product-thumb') ); ?>
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
             	   <?php	//} ?>
                    <div class="pd-btn">
                        <a class="order seopressbtn" style="cursor: pointer;" data-toggle="modal" data-target="#myModal">
                        	Mua hàng
                        </a>
                    </div>
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


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Liên hệ đặt hàng</h4>
      </div>
      <div class="modal-body">
          <span>Vui lòng gọi </span>
          <a href="tel:0901463986">0901463986</a>
          <span> hoặc </span>
          <a href="tel:0948855439">0948855439</a>
        <!-- <p>Hotline 0901463986 - 0948855439</p> -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
      </div>
    </div>

  </div>
</div>