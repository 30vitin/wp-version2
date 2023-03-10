<?php   
if( $select_category && $checkbox_order ){
	if( !is_array( $checkbox_order ) ){
		$checkbox_order = explode( ',', $checkbox_order );
	}	
	$numberposts = (int)$numberposts;
	$class_col_lg = ($columns == 5) ? '2-4'  : (12/$columns);
	$class_col_md = ($columns1 == 5) ? '2-4'  : (12/$columns1);
	$class_col_sm = ($columns2 == 5) ? '2-4'  : (12/$columns2);
	$class_col_xs = ($columns3 == 5) ? '2-4'  : (12/$columns3);
	$class_col = 'col-lg-'.$class_col_lg .' col-md-'.$class_col_md .' col-sm-'.$class_col_sm .' col-xs-'.$class_col_xs;
?>
<div class="bwp-filter-homepage tab-product-default <?php echo esc_attr($class); ?>" data-class_col = "<?php echo esc_attr($class_col); ?>" data-numberposts = "<?php echo esc_attr($numberposts); ?>" data-atributes="<?php echo esc_attr($atributes); ?>">
	<div class="bwp-filter-heading">
		<?php if(isset($title1) && $title1) { ?>
		<div class="title-block">
			<h2><?php echo esc_html($title1); ?></h2>
			<?php if($description) { ?>
			<div class="page-description"><?php echo $description; ?></div>
			<?php } ?> 
		</div>
		<?php } ?>
		<ul class="filter-category hidden">
			<li class="active" data-value="<?php echo esc_attr($select_category); ?>">
				<span><?php echo esc_html($select_category); ?></span>
			</li>	
		</ul>
		<div class="filter-order-by">
			<ul class="filter-orderby">
				<?php $i=0; foreach($checkbox_order as $option){
					$tab_title = '';						
					switch ($option) {
						case 'date':
							$tab_title = __( 'Latest Products', "wpbingo" );
						break;
						case 'popularity':
							$tab_title = __( 'Best Sellers', "wpbingo" );
						break;						
						case 'featured':
							$tab_title = __( 'Featured Products', "wpbingo" );
						break;
						case 'rating':
							$tab_title = __( 'Top Rating', "wpbingo" );
						break;
				} ?>			
				<li data-value="<?php echo esc_attr($option); ?>" <?php if($i == 0) echo 'class="active"'?>><?php echo $tab_title; ?></li>
				<?php $i++;} ?>				
			</ul>
		</div>		
	</div>
	<div class="bwp-filter-content">
		<?php
		$select_order = (isset($checkbox_order[0]) && $checkbox_order[0]) ? $checkbox_order[0] : 'date';
		$args = array(
			'post_type' 			=> 'product',
			'post_status' 			=> 'publish',
			'posts_per_page' 		=> $numberposts,	
		);
		$tax_query = array();
		if($select_category != 'all'){
			$tax_query[] = array(
							'taxonomy'	=> 'product_cat',
							'field'		=> 'slug',
							'terms'		=> $select_category );
		}
		$meta_query = array();
		switch ($select_order) {
			case 'date':
				$args['orderby']	= 'date';
			break;
			case 'rating':
				$meta_query[] = array(
								'key' 			=> '_visibility',
								'value' 		=> array('catalog', 'visible'),
								'compare' 		=> 'IN' );
				add_filter( 'posts_clauses',  'order_by_rating_post_clauses'  );				
			break;
			case 'popularity':
				$args['meta_key']	= 'total_sales';
				$args['orderby']	= 'meta_value_num';
				$meta_query[] = array(
							'key' 		=> '_visibility',
							'value' 	=> array( 'catalog', 'visible' ),
							'compare' 	=> 'IN' );
			break;
			case 'featured':
				$product_visibility_term_ids = wc_get_product_visibility_term_ids();
				$tax_query[] = 	array(
									'taxonomy' => 'product_visibility',
									'field'    => 'term_taxonomy_id',
									'terms'    => $product_visibility_term_ids['featured'],
								);			
			break;
		}	
		$args['tax_query'] = $tax_query;
		$args['meta_query'] = $meta_query;
		$list = new WP_Query( $args );
		?>
		<div class="content products-list grid row">
			<?php while($list->have_posts()): $list->the_post();
				global $product, $post, $wpdb, $average; ?>
				<div class="item-product <?php echo $class_col; ?>">
					<?php include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'content-product.php'); ?>
				</div>
			<?php endwhile; wp_reset_postdata();?>
		</div>
	</div>	
</div>
<?php } ?>