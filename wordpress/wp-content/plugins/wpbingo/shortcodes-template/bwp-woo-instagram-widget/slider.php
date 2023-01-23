<?php if($image_instagram){ ?>
<div class="bwp-instagram <?php echo esc_html( $layout ); ?> <?php echo esc_attr($padding); ?>">
 <div class="block">
 	<?php if(isset($title1) && $title1) {?>
		<div class="instagram-title">
			<?php
				echo '<h2>'. esc_html($title1) .'</h2>';
			?>
		</div>
	<?php } ?>
	<div class="block_content ">
		<div class="slick-carousel content_instagram" data-nav="<?php echo esc_attr($show_nav);?>" data-dots="<?php echo esc_attr($show_pag);?>" data-columns4="<?php echo $columns4; ?>" data-columns3="<?php echo $columns3; ?>" data-columns2="<?php echo $columns2; ?>" data-columns1="<?php echo $columns1; ?>" data-columns="<?php echo $columns; ?>" >
		<?php $items = explode(",",$image_instagram);
		$j=0;
		foreach($items as $item){
			$item = wp_get_attachment_image_src( $item,'full');
			$image = $item[0]; ?>
			<?php	if( ( $j % $item_row ) == 0 && $item_row !=1) { ?>
				<div class="item-instagram">
			<?php } ?>
			<div class="image-instagram">
				<a class="instagram" href="<?php echo esc_url($link) ?>">
					<img src="<?php echo esc_url($image); ?>" alt="">
				</a>
			</div>
			<?php if((($j + 1) % $item_row == 0 ) && $item_row !=1  ){?>
				</div>
			<?php  } $j++;?>
		<?php } ?>
		</div>
	</div>
 </div>
</div>
<?php }?>
