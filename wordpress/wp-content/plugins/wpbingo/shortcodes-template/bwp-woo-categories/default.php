<?php  
if( $category == '' ){
	return ;
}
if(isset($columns) && isset($columns1) && isset($columns2) && isset($columns3)){
	$class_col_lg = ($columns == 5) ? '2-4'  : (12/$columns);
	$class_col_md = ($columns1 == 5) ? '2-4'  : (12/$columns1);
	$class_col_sm = ($columns2 == 5) ? '2-4'  : (12/$columns2);
	$class_col_xs = ($columns3 == 5) ? '2-4'  : (12/$columns3);
	$attributes = 'col-lg-'.$class_col_lg .' col-md-'.$class_col_md .' col-sm-'.$class_col_sm .' col-xs-'.$class_col_xs;
}else{
	$attributes = '';
}

$item_row = (isset($item_row) && $item_row) ? $item_row : 1;
$show_name = (isset($show_name) && $show_name) ? $show_name : 'true'; 
if( !is_array( $category ) ){
	$category = explode( ',', $category );
}
$widget_id = isset( $widget_id ) ? $widget_id : 'category_slide_'.rand().time(); 
?>
<div id="<?php echo $widget_id; ?>" class="bwp-woo-categories <?php echo esc_attr($layout); ?>">
		<?php if( isset($subtitle) && $subtitle) : ?>
			<div class="bwp-categories-subtitle">					
				<?php echo ($subtitle); ?>							
			</div>	
		<?php endif;?>
		<?php if( $title1) : ?>
			<h3 class="bwp-categories-title"><?php echo esc_html( $title1 ); ?></h3>
		<?php endif; ?>
		<div class="content-category row">
			<?php
				foreach( $category as $j => $cat ){
					$term = get_term_by('slug', $cat, 'product_cat');
					if($term) :		
						$thumbnail_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
						$thumbnail_id1 = get_term_meta( $term->term_id, 'thumbnail_id1', true );
						$thumb = wp_get_attachment_url( $thumbnail_id );
						if(!$thumb)
							$thumb = wc_placeholder_img_src();
						
						$thumb1 = $thumbnail_id1;
						if(!$thumb1)
							$thumb1 = wc_placeholder_img_src();
						?>
						<?php	if( ( $j % $item_row ) == 0 ) { ?>
							<div class="item item-product-cat 1<?php echo esc_attr($attributes); ?>">
						<?php } ?>
							<div class="item-inner">
							<?php if($show_name) : ?>
							<div class="item-title">
								<div><?php esc_html_e( 'Shop', 'funivou' ); ?></div>
								<a href="<?php echo get_term_link( $term->term_id, 'product_cat' ); ?>"><?php echo esc_html( $term->name ); ?></a>
							</div>
							<?php endif;?>
							<?php if(isset($show_thumbnail) && $show_thumbnail) : ?>
							<div class="item-image">
								<?php if($thumb) : ?>
									<img src="<?php echo $thumb; ?>" alt="<?php echo $term->slug ;?>" />
								<?php endif ; ?>
							</div>
							<?php endif;?>
							<?php if(isset($show_thumbnail1) && $show_thumbnail1) : ?>
								<div class="item-thumbnail">
									<img src="<?php echo $thumb1; ?>" alt="<?php echo $term->slug ;?>" />
								</div>
							<?php endif;?>
							<?php if(isset($show_count) && $show_count) : ?>
							<div class="item-count">
								<span><?php echo $term->count; ?></span>
							</div>
							<?php endif;?>	
							</div>	
						<?php if( ( $j+1 ) % $item_row == 0 || ( $j+1 ) == count($category) ){?> 
							</div>
						<?php  } ?>
					<?php endif; ?>		
			<?php } ?>
		</div>
	</div>