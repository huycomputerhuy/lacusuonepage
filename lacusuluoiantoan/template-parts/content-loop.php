<div id="post-<?php the_ID(); ?>" <?php post_class('clearfix postsloop'); ?> itemscope itemtype="http://schema.org/CreativeWork">
	<li class="lacusu-normal-post">
		<div class="lacusu-ct-left">
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				<?php 
				if( has_post_thumbnail() )
				{
					the_post_thumbnail( 'post-thumbnail', array( 'class' => 'lacusu-ct-img' ) );
				}else{
				?>
					<img alt="<?php the_title();?>"/>
				<?php } ?>
			</a>
		</div>
		<div class="lacusu-ct-right">
			<h2 class="lacusu-ct-the-title" itemprop="headline"><a class="entry-title" rel="bookmark" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" ><?php the_title(); ?></a></h2>
			<?php
			if( get_theme_mod( 'excerpt_or_content', 'excerpt' ) == 'content' )
			{
				the_content();
			}
			else
			{
				the_excerpt();
			}
			?>
		</div>
		<!-- <div> -->
			<?php
			if( get_theme_mod( 'seopress_posts_meta_disply', '1' ) == 1 ) {
				seopress_entry_meta();
			}
			?>
		<!-- </div> -->
	</li>
</div>
