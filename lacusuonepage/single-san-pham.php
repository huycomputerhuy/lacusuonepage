<?php get_header(); ?>

<?php
if( get_theme_mod( 'seopress_breadcrumbx_setting', '1' ) == '1' )
{
	lacusu_breadcrumbs();
}
?>

<div class="<?php if( get_theme_mod( 'seopress_blog_single_layout', 'rights' ) == 'rights' ) { echo 'col-md-9'; } else { echo 'col-md-12'; } ?>">
	<div class="left-content" >
		
		<?php
		while( have_posts() ) : the_post();
		
			get_template_part( 'template-parts/content', 'san-pham' );
			
			seopress_post_pagination();
			
			comments_template();

		
		endwhile;
		?>
		
	</div>
</div>
<?php if( get_theme_mod( 'seopress_blog_single_layout', 'rights' ) == 'rights' ) { get_sidebar(); } ?>
<?php get_footer(); ?>