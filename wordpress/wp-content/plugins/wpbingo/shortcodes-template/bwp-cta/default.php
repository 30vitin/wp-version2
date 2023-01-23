<div class="bwp-cta">
	<?php  if($image): ?>
		<img class="icon" src="<?php echo esc_url($image); ?>" alt="">
	<?php endif;?>
	<?php if( $title1) : ?>
		<h4 class="title-cta"><a href="<?php echo esc_url($link);?>"><?php echo esc_html( $title1 ); ?></a></h4>
	<?php endif; ?>

	<?php if( $link || $label ) : ?>
		<a class="button dark cta-button" href="<?php echo esc_url($link);?>"><?php echo esc_html( $label ); ?></a>
	<?php endif; ?>
</div><!-- .bwp-cta -->