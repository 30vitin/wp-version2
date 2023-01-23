<?php if($image_instagram){ ?>
<?php
	$class_col_lg = ($columns == 5) ? '2-4'  : (12/$columns);
	$class_col_md = ($columns1 == 5) ? '2-4'  : (12/$columns1);
	$class_col_sm = ($columns2 == 5) ? '2-4'  : (12/$columns2);
	$class_col_xs = ($columns3 == 5) ? '2-4'  : (12/$columns3); 
	$attributes = 'col-lg-'.$class_col_lg .' col-md-'.$class_col_md .' col-sm-'.$class_col_sm .' col-xs-'.$class_col_xs; 	
?>
<div class="bwp-instagram default" >
	<div class="block">
		<?php if(isset($title1) && $title1) { ?>
		<h3 class="widget-title"><?php echo esc_html($title1); ?></h3>
		<?php } ?>
		<div class="block_content">
			<div class="content_instagram row" data-attributes="<?php echo esc_attr($attributes); ?>">
				<?php $items = explode(",",$image_instagram);
				foreach($items as $item){
					$item = wp_get_attachment_image_src( $item,'full');
					$image = $item[0]; ?>
					<div class="image-instagram <?php echo esc_attr($attributes); ?>">
						<a class="instagram" href="<?php echo esc_url($link) ?>">
							<img src="<?php echo esc_url($image); ?>" alt="">
						</a>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<?php }?>