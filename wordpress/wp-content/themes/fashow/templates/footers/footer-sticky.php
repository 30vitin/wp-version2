<?php 
	global $page_id;
	$fashow_settings = fashow_global_settings();
	$footer_style = fashow_get_config('footer_style','');
	$footer_style = (get_post_meta( $page_id,'page_footer_style', true )) ? get_post_meta( $page_id, 'page_footer_style', true ) : $footer_style ;
	$header_style = fashow_get_config('header_style', ''); 
	$header_style  = (get_post_meta( $page_id, 'page_header_style', true )) ? get_post_meta($page_id, 'page_header_style', true ) : $header_style ;
?>	
<?php if($footer_style && (get_post($footer_style))){ ?>
	<footer id="bwp-footer" class="bwp-footer <?php echo esc_attr( get_post($footer_style)->post_name ); ?>">
		<div class="container">
			<?php
				$post_content = get_post( $footer_style )->post_content;
				echo do_shortcode( $post_content );
				fashow_parseShortcodesCustomCss($post_content);						
			?>
		</div>
	</footer>
<?php }else{
	fashow_copyright(); 
}?>
</div><!-- #page -->
<div class="search-overlay">	
<span class="close-search"><i class="ion ion-ios-close-empty"></i></span>	
<div class="container wrapper-search">
	<?php fashow_search_form_product(); ?>		
</div>
</div>
<div class="bwp-quick-view">
</div>
<?php 
$back_active = fashow_get_config('back_active');
if($back_active && $back_active == 1):
?>
<div class="back-top">
<i class="fa fa-angle-double-up"></i>
</div>
<?php endif;?>

<?php if((isset($fashow_settings['show-newletter']) && $fashow_settings['show-newletter']) && is_active_sidebar('newletter-popup-form')) : ?>		
<?php fashow_popup_newsletter(); ?>
<?php endif;  ?>
<?php wp_footer(); ?>