
<div class="bwp-policy <?php echo esc_attr($layout); ?>">
	<?php  if($image): ?>
		<div class="policy-icon">
			<img src="<?php echo esc_url($image); ?>" alt="">
		</div>
	<?php endif;?>
	<?php if( $title1 || $desc ) : ?>
		<div class="policy-info">
			<?php if(isset($title1) && $title1) : ?>
				<h4 class="title-policy"><a href="<?php echo isset($link) ? esc_url($link) : "#" ;?>"><?php echo esc_html( $title1 ); ?></a></h4>
			<?php endif; ?>
			<?php if( $desc) : ?>
				<div class="desc-policy"><?php echo esc_html( $desc ); ?></div>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</div><!-- .bwp-policy -->
