
<?php
$widget_id = isset( $widget_id ) ? $widget_id : 'bwp_woo_slider_'.rand().time();

$default = array();
if( $category != '' ){
	$default = array(
		'post_type' => 'product',
		'tax_query' => array(
		array(
			'taxonomy'  => 'product_cat',
			'field'     => 'slug',
			'terms'     => $category ) ),
		'orderby' => $orderby,
		'order' => $order,
		'post_status' => 'publish',
		'showposts' => $numberposts
	);
}else{
	$default = array(
		'post_type' => 'product',		
		'orderby' => $orderby,
		'order' => $order,
		'post_status' => 'publish',
		'showposts' => $numberposts
	);
}
$list = new WP_Query( $default );
$count = $list->post_count;
$j = 1;
do_action( 'before' ); 
if ( $list -> have_posts() ){ ?>
	<div id="<?php echo $widget_id; ?>" class="bwp-woo-slider  woo-slider-default <?php echo esc_attr($class); ?> <?php if(empty($title1)) echo 'no-title'; ?>">
		<?php if($title1) { ?>
		<div class="title-block">			
			<?php if($description) { ?>
			<div class="page-description"><?php echo $description; ?></div>
			<?php } ?>    
			<h2><?php echo $title1; ?></h2>
		</div> 
		<?php } ?>
		<div class="content-product-list">	
			<div class="slider products-list grid slick-carousel" data-nav="<?php echo esc_attr($show_nav);?>" data-columns4="<?php echo $columns4; ?>" data-columns3="<?php echo $columns3; ?>" data-columns2="<?php echo $columns2; ?>" data-columns1="<?php echo $columns1; ?>" data-columns="<?php echo $columns; ?>">	
			<?php while($list->have_posts()): $list->the_post();global $product, $post, $wpdb, $average; ?>
				<?php	if( ($j == 1) ||  ( $j % $item_row  == 1 ) || ( $item_row == 1 )) { ?>
					<div class="item-product">
				<?php } ?>	
					<?php include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'content-product.php'); ?>
				<?php if( ($j == $count) || ($j % $item_row == 0) || ($item_row == 1)){?> 
					</div><!-- #post-## -->
				<?php  } $j++;?>
					
			<?php endwhile; wp_reset_postdata();?>
			</div>
		</div>
	</div>
	<?php
	}
?>