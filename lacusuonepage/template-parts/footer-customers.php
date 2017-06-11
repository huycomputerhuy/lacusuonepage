<div class="container-fluid pdt10 pdb10 clearfix">
<?php 
	// $categories = get_categories(array(
	//     'hide_empty' => 1
	// ));
	// if(is_front_page() or in_category($categories)){
	if(is_front_page()){
		echo do_shortcode('[huge_it_portfolio id="1"]'); 
	}
?>
</div>