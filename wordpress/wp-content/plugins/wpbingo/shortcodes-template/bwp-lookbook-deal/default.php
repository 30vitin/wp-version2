<?php
global $wpdb;
if($lookbook_deal){ ?>
	<div class="bwp-lookbook-deal bwp-lookbook">
		<?php
		$item = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT
					*
				FROM
					`" . $wpdb->prefix . LOOKBOOK_TABLE . "`
				WHERE
					id = %d",
				$lookbook_deal
			),
			ARRAY_A
		);
		if(!empty($item)){?>
			<div class="row">
				<div class="col-md-6">
					<div class="bwp-content-lookbook-infor">
						<?php if($title1) { ?>
						<div class="block-title">
							<h2><?php echo $title1; ?></h2>
							<?php if($description) { ?>
							<div class="desc-lookbook"><?php echo esc_html( $description ); ?></div>
							<?php } ?>       
						</div> 
						<?php } ?>	
						<div class="countdown-deal">
							<?php
								$start_time = time();
								$countdown_time = strtotime($time_deal);
								$date = bwp_timezone_offset( $countdown_time );
							?>
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
						<?php if($desc) { ?>
						<div class="desc-lookbook"><?php echo wp_kses_post( $desc ); ?></div>
						<?php } ?> 
						<?php  if($link): ?>
						<a href="<?php echo esc_url($link);?>"><?php echo esc_html__('Shop now','wpbingo');?></a>
						<?php endif;?>
					</div> 
				</div>
				<div class="col-md-6 text-center">
					<div class="bwp-content-lookbook">
						<img src="<?php echo esc_url(LOOKBOOK_UPLOAD_URL_IMAGE . '/'.UPLOAD_FOLDER_NAME.'/' . $item[0]['image']); ?>" alt="<?php echo esc_html($item[0]['name']); ?>"/>
						<?php
							$pins = ($item[0]['pins']) ? $item[0]['pins'] : "";
							if($pins){
								$pins = json_decode($pins);
								foreach($pins as $key => $pin){
									$style = "";
									$left = round(($pin->left/$pin->img_width)*100, 2);
									$top = round(($pin->top/$pin->img_height)*100, 2);
									
									if($left > 50)
										$style .= " right:33px;";
									else
										$style .= " left:33px;";

									if($top > 50)
										$style .= " bottom:10px;";
									else
										$style .= " top:10px;";									
									?>
									<div class="item-lookbook" style="height:<?php echo esc_attr($pin->height)?>px;width:<?php echo esc_attr($pin->width)?>px;left:<?php echo esc_attr($left)?>%;top:<?php echo esc_attr($top)?>%">
										<span class="number-lookbook"><?php echo esc_attr($key +1); ?></span>
										<?php 
										if (!empty($pin->slug)){
											$result = get_posts(array(
												'name' => $pin->slug,
												'posts_per_page' => 1,
												'post_type' => 'product',
												'post_status' => 'publish'
											));
											if(isset($result[0]) && $result[0]){
												$post_data = $result[0];
												$id_product = $post_data->ID;
												$product = new WC_Product( $id_product );
												$product_url = get_permalink($id_product);
												$url = wp_get_attachment_image_src( get_post_thumbnail_id($id_product),'shop_catalog');															
												$img_block = (!empty($url[0])) ? '<img src="' . $url[0] . '" alt=""/>' : ''; ?>
												<div class="content-lookbook" style="<?php echo esc_attr($style); ?>">
													<div class="item-thumb">
														<a href="<?php echo esc_url($product_url); ?>"><?php echo wp_kses_post($img_block); ?></a>
													</div>
													<div class="content-lookbook-bottom">
														<div class="item-title">
															<a href="<?php echo esc_url($product_url); ?>"><?php echo $product->get_title(); ?></a>
														</div>
														<?php if ( $rating_html = wc_get_rating_html( $product->get_average_rating() ) ) { ?>
															<div class="rating">
																<?php echo wc_get_rating_html( $product->get_average_rating() ); ?>
																<div class="review-count">
																	<?php echo $product->get_review_count();?><?php echo esc_html__(' reviews','wpbingo');?>
																</div>
															</div>
														<?php }else{ ?>
															<div class="rating none">
																<div class="star-rating none"></div>
															</div>
														<?php } ?>
														<div class="price">
															<?php echo $product->get_price_html(); ?>
														</div>
													</div>
												</div>
											<?php }	
										} ?>
									</div>
									<?php
								}
							} ?>						
					</div>	
				</div>	
			</div>			
		<?php } ?>
	</div>
<?php }?>