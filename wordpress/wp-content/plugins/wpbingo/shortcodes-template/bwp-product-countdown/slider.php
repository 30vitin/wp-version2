<?php

do_action( 'before' ); 
if ( $list -> have_posts() ){ ?>
	<div id="<?php echo $widget_id; ?>" class="bwp-countdown slider <?php echo esc_attr($class); ?> <?php if(empty($title1)) echo 'no-title'; ?>">       
		<?php if($title1) { ?>
		<div class="block-title">
			<?php if($description) { ?>
			<div class="page-description"><?php echo $description; ?></div>
			<?php } ?> 
			<h2><?php echo $title1; ?></h2>   
		</div> 
		<?php } ?>
		<div class="content-product-list">	
			<div class="slider slider-for products-list grid slick-carousel" data-asnavfor=".slider-nav" data-dots="<?php echo esc_attr($show_pag);?>" data-nav="<?php echo esc_attr($show_nav);?>" data-columns4="<?php echo $columns4; ?>" data-columns3="<?php echo $columns3; ?>" data-columns2="<?php echo $columns2; ?>" data-columns1="<?php echo $columns1; ?>" data-columns="<?php echo $columns; ?>">	
			<?php while($list->have_posts()): $list->the_post();?>
				<?php
				global $product, $post, $wpdb, $average;
				$start_time = get_post_meta( $post->ID, '_sale_price_dates_from', true );
				$countdown_time = get_post_meta( $post->ID, '_sale_price_dates_to', true );	
				$orginal_price = get_post_meta( $post->ID, '_regular_price', true );	
				$sale_price = get_post_meta( $post->ID, '_sale_price', true );	
				$symboy = get_woocommerce_currency_symbol( get_woocommerce_currency() );
				$date = bwp_timezone_offset( $countdown_time );
				?>
				<div class="item-product">	
					<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<div class="products-thumb">
								<?php
								/**
								 * woocommerce_before_shop_loop_item_title hook
								 *
								 * @hooked woocommerce_show_product_loop_sale_flash - 10
								 * @hooked woocommerce_template_loop_product_thumbnail - 10
								 */
								if ( has_post_thumbnail() ) {
										$feat_image_url = wp_get_attachment_url( get_post_thumbnail_id()); ?>
										<div class="image-product-thumb">
											<img src="<?php echo esc_url($feat_image_url); ?>" class="image-attachment-product" alt="">
										</div>	
								<?php  } ?>						
							</div>	
						</div>
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<div class="products-countdown-right">	
								<div class="item-countdown">
									<div class="product-countdown"  
										data-day="<?php echo esc_html__("Days","wpbingo"); ?>"
										data-hour="<?php echo esc_html__("Hours","wpbingo"); ?>"
										data-min="<?php echo esc_html__("Mins","wpbingo"); ?>"
										data-sec="<?php echo esc_html__("Secs","wpbingo"); ?>"	
										data-date="<?php echo esc_attr( $date ); ?>"  
										data-sttime="<?php echo esc_attr( $start_time ); ?>" 
										data-cdtime="<?php echo esc_attr( $countdown_time ); ?>" 
										data-id="<?php echo $widget_id; ?>">
									</div>
								</div>	
								<div class="products-content">			
									<h3 class="product-title"><a href="<?php esc_url(the_permalink()); ?>"><?php esc_html(the_title()); ?></a></h3>										
									<?php
										/**
										 * woocommerce_after_shop_loop_item_title hook
										 *
										 * @hooked woocommerce_template_loop_rating - 5
										 * @hooked woocommerce_template_loop_price - 10
										 */    
										remove_action( 'woocommerce_after_shop_loop_item_title', 'favou_atribute_color', 5 ); 
										do_action( 'woocommerce_after_shop_loop_item_title' );
										wpbingo_get_excerpt_product($length);
										favou_woocommerce_template_loop_add_to_cart();
										favou_add_loop_wishlist_link();
									?>		
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php endwhile; wp_reset_postdata();?>
			</div>
		</div>
	</div>
	<?php
}
?>