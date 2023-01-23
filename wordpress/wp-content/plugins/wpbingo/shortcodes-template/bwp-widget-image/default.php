<div class="bwp-widget-banner <?php echo esc_attr($layout);?>">
	<?php  if($image): ?>	
	<div class="bg-banner">		
		<div class="banner-wrapper banners">
			<div class="bwp-image">
				<?php  if($link): ?>
				<a href="<?php echo esc_url($link);?>">
						<img src="<?php echo esc_url($image); ?>" alt=""></a>
				<?php endif;?>
			</div>
			<div class="content-banner">
				<?php if( $subtitle) : ?>
					<div class="bwp-image-subtitle">
						<?php if(isset($subtitle) && $subtitle){?>						
							<?php echo ($subtitle); ?>							
						<?php }?>
					</div>	
				<?php endif;?>
				<?php if( $title1) : ?>
				<h3 class="title-banner"><?php echo esc_html( $title1 ); ?></h3>
				<?php endif; ?>
				<?php if( $description ) : ?>
					<div class="bwp-image-desc">
						<?php if(isset($description) && $description){ ?>
							<?php echo ($description); ?>
						<?php }?>
					</div>
				<?php endif;?>
				<?php if($label): ?>
					<a class="bwp-image-btn" href="<?php echo esc_url($link);?>"><?php echo esc_html($label);?></a>
				<?php endif;?>
			</div>
		</div>
	</div>
	<?php endif;?>
</div>
