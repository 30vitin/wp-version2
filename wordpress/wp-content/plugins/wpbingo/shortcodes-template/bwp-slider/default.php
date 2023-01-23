<?php if($slider){ $j = 1; ?>
	<div class="bwp-slider <?php echo esc_attr($layout); ?>">
			<div class="slick-carousel slick-carousel-center" data-nav="<?php echo esc_attr($show_nav);?>" data-dots="<?php echo esc_attr($show_pag);?>" data-columns4="<?php echo $columns4; ?>" data-columns3="<?php echo $columns3; ?>" data-columns2="<?php echo $columns2; ?>" data-columns1="<?php echo $columns1; ?>" data-columns="<?php echo $columns; ?>" >
			<?php $items = explode(",",$slider);
			$count = count($items);
			foreach($items as $item){
				$posts = get_posts(array('name' => $item, 'post_type' => 'bwp_slider'));
				if(!empty($posts)){
					foreach($posts as $post){ ?>
						<?php	if( ($j == 1) ||  ( $j % $item_row  == 1 ) || ( $item_row == 1 )) { ?>
							<div class="item-slider">
								<?php } ?>					
								<div class="item">
									<a href="<?php echo esc_url(get_post_meta( $post->ID, 'url', true ));?>">
										<?php echo wp_kses_post(get_the_post_thumbnail($post->ID,'full')); ?>
									</a>
									
									<?php if ( has_excerpt( $post->ID ) ) { ?>
										<div class="content-slider">
											<?php echo wp_kses_post($post->post_excerpt); ?>
										</div>
									<?php } ?>
								</div>
								<?php if( ($j == $count) || ($j % $item_row == 0) || ($item_row == 1)){?> 
							</div><!-- #slider-## -->
						<?php  } $j++;?>						
					<?php }
				}
			}?>
			</div>
	</div>
<?php }?>