<?php
	// $price =  get_post_meta( $post->ID, 'wpcf-don-gia', true );
	// $discount = get_post_meta( $post->ID, 'wpcf-giam-gia', true );
	$sale_price_info = get_sale_price($post->ID);
?>

<div id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> itemscope itemtype="http://schema.org/CreativeWork">
	<div class="content-first">
		<div class="content-second">
			<div class="page_pd_detail">
				<div class="pd_detail_top">
					<div class="img_detail left col-xs-12 col-sm-5 col-md-4 col-lg-4">
						<div class="img_detail_big">
							<?php 
							$images = get_post_meta($post->ID, "wpcf-hinh-anh-san-pham");
							?>
							<img src="<?php echo $images[0]?>" class="zoom_image" alt="<?php the_title(); ?>" title="<?php the_title(); ?>">
						</div>
					</div>
					<div class="info_detail right col-xs-12  col-sm-7 col-md-8 col-lg-8">
						<h1 class="pd-tit">
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
                    	</h1>
						<div class="price">
	                    	<?php if($sale_price_info['discount']){ ?>
	                        <span class="price-discount" ><?php echo $sale_price_info['price']  ?></span>
	                        <?php } ?>

	                        <span class="price-sale" ><?php echo $sale_price_info['sale_price'] ?></span>
	                    </div>
	                    <?php 
	                    $made_in = get_post_meta( $post->ID, 'wpcf-xuat-xu', true );
	                    if($made_in){
	               		?>
	                    <div class="pd-made-in">
	                        <?php echo 'Xuất xứ: '. $made_in ?>
	                    </div>
	             	   <?php } ?>
	                    <div class="pd-btn">
	                        <a class="order seopressbtn" style="cursor: pointer;" data-toggle="modal" data-target="#myModal">
	                        	Mua hàng
	                        </a>
	                    </div>
		                <div class="pd-sum"> 
		                 <span>Tóm tắt sản phẩm</span>
		                 <p><?php echo get_post_meta($post->ID, "wpcf-tom-tat-san-pham", true) ?>
		                </div>
					</div>
				</div>
			</div>

		</div>
				
		<div class="content-third" itemprop="text">
					
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
					
			<?php
			wp_link_pages( array(
				'before'           => '<p class="pagelinks">' . __( 'Pages:', 'seopress' ),
				'after'            => '</p>',
				'link_before'      => '<span class="pagelinksa">',
				'link_after'       => '</span>',
			) );
			?>
					
		</div>
				
				
	</div>
</div>


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