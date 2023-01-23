<?php if($image_gallery){ ?>
	<div class="bwp-gallery <?php echo esc_attr($class); ?>">
		<?php if (isset($title1) && $title1){?>
		<div class="title-block">
			<?php echo '<h2>'. $title1 .'</h2>'; ?>
		</div>	
		<?php } ?>
		<div class="slick-carousel" data-nav="<?php echo esc_attr($show_nav);?>" data-dots="<?php echo esc_attr($show_pag);?>" data-columns4="<?php echo $columns4; ?>" data-columns3="<?php echo $columns3; ?>" data-columns2="<?php echo $columns2; ?>" data-columns1="<?php echo $columns1; ?>" data-columns="<?php echo $columns; ?>" >
		<?php $items = explode(",",$image_gallery);
		foreach($items as $item){
			$item = wp_get_attachment_image_src( $item,'full');
			$image = $item[0]; ?>
			<div class="item">	
				<img src="<?php echo esc_url($image); ?>" alt="">
			</div>
		<?php } ?>
		</div>
	</div>
<?php }?>