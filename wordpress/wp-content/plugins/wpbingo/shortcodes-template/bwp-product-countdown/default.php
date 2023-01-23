<?php
$class_col_lg = ($columns == 5) ? '2-4'  : (12/$columns);
$class_col_md = ($columns1 == 5) ? '2-4'  : (12/$columns1);
$class_col_sm = ($columns2 == 5) ? '2-4'  : (12/$columns2);
$class_col_xs = ($columns3 == 5) ? '2-4'  : (12/$columns3);
$attributes = 'col-lg-'.$class_col_lg .' col-md-'.$class_col_md .' col-sm-'.$class_col_sm .' col-xs-'.$class_col_xs; 
do_action( 'before' ); 
if ( $list -> have_posts() ){ ?>
	<div class="bwp-countdown default <?php echo esc_attr($class); ?> <?php if(empty($title1)) echo 'no-title'; ?>">
		<?php if($title1) { ?>
		<div class="block-title">
			<h2><?php echo $title1; ?></h2>
			<?php if($description) { ?>
			<div class="page-description"><?php echo $description; ?></div>
			<?php } ?>       
		</div> 
		<?php } ?>         
		<div class="container">	
		<?php while($list->have_posts()): $list->the_post();?>
			<?php
			global $product, $post, $wpdb, $average;
			$start_time = get_post_meta( $post->ID, '_sale_price_dates_from', true );
			$countdown_time = get_post_meta( $post->ID, '_sale_price_dates_to', true );		
			$orginal_price = get_post_meta( $post->ID, '_regular_price', true );	
			$sale_price = get_post_meta( $post->ID, '_sale_price', true );	
			$symboy = get_woocommerce_currency_symbol( get_woocommerce_currency() );
			$date = bwp_timezone_offset( $countdown_time );
			$attributes = array(	
				'title' => $image_title,
				'class'	=>	"single-image-countdown",
				'alt'	=> 'image-countdown'
			);			
			?>
			<div class="item-product">
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<div class="products-thumb">
								<?php if ( has_post_thumbnail() ) { ?>
										<div class="image-product-thumb">
											<?php echo get_the_post_thumbnail( $post->ID, 'shop_catalog', $attributes ); ?>
										</div>	
								<?php  } ?>
								<div class="item-countdown">
									<div class="product-countdown"  data-date="<?php echo esc_attr( $date ); ?>" data-price="<?php echo esc_attr( $symboy.$orginal_price ); ?>" data-sttime="<?php echo esc_attr( $start_time ); ?>" data-cdtime="<?php echo esc_attr( $countdown_time ); ?>" data-id="<?php echo 'product_'.$widget_id.$post->ID; ?>"></div>
								</div>						
							</div>	
						</div>
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<div class="products-content">			
								<h3 class="product-title"><a href="<?php esc_url(the_permalink()); ?>"><?php esc_html(the_title()); ?></a></h3>										
								<div class="price-rating">
									<?php
										/**
										 * woocommerce_after_shop_loop_item_title hook
										 *
										 * @hooked woocommerce_template_loop_rating - 5
										 * @hooked woocommerce_template_loop_price - 10
										 */
										do_action( 'woocommerce_after_shop_loop_item_title' ); 
									?>
								</div>
								<?php
									wpbingo_get_excerpt_product($length);
									if(function_exists("fashow_woocommerce_template_loop_add_to_cart")){ 
										fashow_woocommerce_template_loop_add_to_cart();
									}
									if ( in_array( 'yith-woocommerce-wishlist/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ){
										echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );
									}
									wpbingo_countdown_thumbnail();
								?>
								<?php if(!empty($link_all)){?>
									<a href="<?php echo esc_url($link_all); ?>" class="view-all">
										<?php echo esc_html__("View All Items","wpbingo"); ?>
									</a>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			<?php endwhile; wp_reset_postdata();?>
		</div>	
	</div>
	<?php
	}
?>