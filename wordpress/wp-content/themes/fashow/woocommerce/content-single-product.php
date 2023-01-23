<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly
	}
	do_action( 'woocommerce_before_single_product' );
	if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	}
	$fashow_settings = fashow_global_settings();	
	
	get_template_part('breadcrumb');
?>

<div id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="row">
		<div class="bwp-single-product <?php echo esc_attr(fashow_image_single_product()->product_layout_thumb); ?>"
			data-product_layout_thumb 	= 	"<?php echo esc_attr(fashow_image_single_product()->product_layout_thumb); ?>" 
			data-zoom_scroll 			=	"<?php echo esc_attr((isset($fashow_settings['zoom-scroll']) && $fashow_settings['zoom-scroll']) ? 'true' : 'false'); ?>" 
			data-zoom_contain_lens 		=	"<?php echo esc_attr((isset($fashow_settings['zoom-contain-lens']) && $fashow_settings['zoom-contain-lens']) ? 'true' : 'false'); ?>" 
			data-zoomtype 				=	"<?php echo esc_attr(( isset($fashow_settings['zoom-type']) && $fashow_settings['zoom-type']) ? ($fashow_settings['zoom-type']) : 'inner'); ?>" 
			data-lenssize 				= 	"<?php echo esc_attr(isset($fashow_settings['zoom-lens-size']) ? ($fashow_settings['zoom-lens-size']) : '200'); ?>" 
			data-lensshape 				= 	"<?php echo esc_attr(isset($fashow_settings['zoom-lens-shape']) ? ($fashow_settings['zoom-lens-shape']) : 'zoom-lens-shape'); ?>" 
			data-lensborder 			= 	"<?php echo esc_attr(isset($fashow_settings['zoom-lens-border']) ? ($fashow_settings['zoom-lens-border']) : '10'); ?>"
			data-bordersize 			= 	"<?php echo esc_attr(isset($fashow_settings['zoom-border']) ? ($fashow_settings['zoom-border']) : '2'); ?>"
			data-bordercolour 			= 	"<?php echo esc_attr(isset($fashow_settings['zoom-border-color']) ? ($fashow_settings['zoom-border-color']) : '#252525'); ?>"
			data-popup 					= 	"<?php echo esc_attr(isset($fashow_settings['product-image-popup'] ) && ($fashow_settings['product-image-popup']) ? 'true' : 'false'); ?>">	
			<div class="bwp-single-image col-md-5 col-sm-12 col-xs-12">
				<?php
					/**
					 * woocommerce_before_single_product_summary hooked
					 *
					 * @hooked woocommerce_show_product_sale_flash - 10
					 * @hooked woocommerce_show_product_images - 20
					 */

					do_action( 'woocommerce_before_single_product_summary' );
				?>
			</div>
			<div class="bwp-single-info col-md-7 col-sm-12 col-xs-12 ">
				<div class="summary entry-summary">
				<?php
					/**
					 * woocommerce_single_product_summary hook
					 *
					 * @hooked woocommerce_template_single_title - 5
					 * @hooked woocommerce_template_single_rating - 10
					 * @hooked woocommerce_template_single_price - 10
					 * @hooked woocommerce_template_single_excerpt - 20
					 * @hooked woocommerce_template_single_add_to_cart - 30
					 * @hooked woocommerce_template_single_meta - 40
					 * @hooked woocommerce_template_single_sharing - 50
					 */
					do_action( 'woocommerce_single_product_summary' );
				?>
						<?php  ?>

				</div><!-- .summary -->
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
		<?php
			/**
			 * woocommerce_after_single_product_summary hook
			 *
			 * @hooked woocommerce_output_product_data_tabs - 10
			 * @hooked woocommerce_upsell_display - 15
			 * @hooked woocommerce_output_related_products - 20
			 */
			do_action( 'woocommerce_after_single_product_summary' );
		?>

	<meta itemprop="url" content="<?php esc_url(the_permalink()); ?>" />
	
</div><!-- #product-<?php the_ID(); ?> -->


<?php do_action( 'woocommerce_after_single_product' ); ?>
