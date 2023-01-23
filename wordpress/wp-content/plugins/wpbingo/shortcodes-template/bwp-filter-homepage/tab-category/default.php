<?php   
if( $category && !is_array( $category ) ){
	$arr_category = explode( ',', $category ); 	
	$numberposts = (int)$numberposts;
	$class_col_lg = ($columns == 5) ? '2-4'  : (12/$columns);
	$class_col_md = ($columns1 == 5) ? '2-4'  : (12/$columns1);
	$class_col_sm = ($columns2 == 5) ? '2-4'  : (12/$columns2);
	$class_col_xs = ($columns3 == 5) ? '2-4'  : (12/$columns3);
	$class_col = 'col-lg-'.$class_col_lg .' col-md-'.$class_col_md .' col-sm-'.$class_col_sm .' col-xs-'.$class_col_xs; 	
	$cat_selected = '';	
?>
<div class="bwp-filter-homepage tab-category-default <?php echo esc_attr($class); ?>" data-class_col = "<?php echo esc_attr($class_col); ?>" data-numberposts = "<?php echo esc_attr($numberposts); ?>" data-atributes="<?php echo esc_attr($atributes); ?>">
	<div class="bwp-filter-heading">
		<?php if(isset($title1) && $title1) { ?>
		<div class="title-block">
			<?php if($description) { ?>
			<div class="page-description"><?php echo $description; ?></div>
			<?php } ?> 
			<h2><?php echo esc_html($title1); ?></h2>
		</div>
		<?php } ?>
		<div class="category-nav">
			<ul class="filter-category">
			<?php
				foreach($arr_category as $key => $cat){	?>
						<?php if($cat == 'all'){?>
							<li class="<?php if( ( $key + 1 ) == 1 ){echo 'active'; $cat_selected = $cat;}?>" data-value="<?php echo esc_attr($cat); ?>">
								<span><?php echo esc_html__( "All", 'wpbingo'); ?></span>
							</li>
						<?php }else{?>
							<?php 
							$terms = get_term_by('slug', $cat, 'product_cat');		
							if($terms) : ?>
							<li class="<?php if( ( $key + 1 ) == 1 ){echo 'active'; $cat_selected = $cat;}?>" data-value="<?php echo esc_attr($cat); ?>">
								<span><?php echo $terms->name; ?></span>
							</li>	
							<?php endif; ?>		
						<?php }?>			
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="bwp-filter-content">
		<?php
		$args = array(
			'post_type' 			=> 'product',
			'post_status' 			=> 'publish',
			'posts_per_page' 		=> $numberposts,	
		);
		$tax_query = array();
		if($cat_selected != 'all'){
			$tax_query[] = array(
							'taxonomy'	=> 'product_cat',
							'field'		=> 'slug',
							'terms'		=> $cat_selected );
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