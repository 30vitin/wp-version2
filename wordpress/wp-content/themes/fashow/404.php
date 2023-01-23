<?php 
	get_header(); 
	$fashow_settings = fashow_global_settings();
	$background = fashow_get_config('background');
	$bgs = isset($fashow_settings['img-404']['url']) && $fashow_settings['img-404']['url'] ? $fashow_settings['img-404']['url'] : "";
?>
<div class="container">
	<div class="img-404">
		<?php if($bgs){ ?>
			<img src="<?php echo esc_url($bgs); ?>" alt="<?php echo esc_attr__('Image 404','fashow'); ?>">
		<?php }else{ ?>
			<img src="<?php echo esc_url(get_template_directory_uri().'/images/image_404.png'); ?>" alt="<?php echo esc_attr__('Image 404','fashow'); ?>" >							
		<?php } ?>	
	</div>
	<div class="content-page-404">
		<div class="title-error"><?php echo isset($fashow_settings['title-error']) ? $fashow_settings['title-error'] : esc_html__('page not found', 'fashow'); ?></div>
		<div class="text-error"><?php echo isset($fashow_settings['text-error']) ? $fashow_settings['text-error'] : esc_html__('Sorry but we couldn’t find the page you are looking for.', 'fashow'); ?></div>
		<div class="sub-error"><?php echo isset($fashow_settings['sub-error']) ? $fashow_settings['sub-error'] : esc_html__('If difficulties persist, please contact the System Administrator of this site and report the error below...', 'fashow'); ?></div>
		<a class="btn btn-primary" href="<?php echo esc_url( home_url('/') ); ?>"><?php echo isset($fashow_settings['btn-error']) ? esc_html($fashow_settings['btn-error']) : esc_html__('home page', 'fashow'); ?></a>	
	</div> 
</div>
<?php
get_footer();