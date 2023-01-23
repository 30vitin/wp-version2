<?php

/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
get_header();
do_action('woocommerce_before_main_content');
$sidebar_product = fashow_category_sidebar();

?>
<div class="container">
	<div class="main-archive-product row">
		<?php // if ($sidebar_product == 'left' && is_active_sidebar('sidebar-product')) : ?>
			<!--<div class="bwp-sidebar sidebar-product <?php // echo esc_attr(fashow_get_class()->class_sidebar_left); ?>">--->
				<?php //dynamic_sidebar('sidebar-product'); ?>
			<!--</div>-->
		<?php //endif; ?>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
			<div class="bwp-top-bar top clearfix">
				<?php fashow_category_top_bar(); ?>
			</div>
		</div>
		<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 ">
		</div>
		<div class="<?php /*echo esc_attr(fashow_get_class()->class_product_content); */ ?> col-lg-10 col-md-10 col-sm-10 col-xs-10">

			<?php do_action('woocommerce_archive_description'); ?>

			<?php if (apply_filters('fashow_custom_category', $html = '')) { ?>
				<ul class="woocommerce-product-subcategories">
					<?php echo (apply_filters('fashow_custom_category', $html = '')); ?>
				</ul>
			<?php } ?>

			<?php if (have_posts()) : ?>

				<?php if ($sidebar_product == 'full') : ?>
					<div class="bwp-sidebar sidebar-product-filter full">
						<?php dynamic_sidebar('sidebar-product'); ?>
					</div>
				<?php endif; ?>
				<?php woocommerce_product_loop_start(); ?>

				<?php while (have_posts()) : the_post(); ?>

					<?php wc_get_template_part('content', 'product'); ?>

				<?php endwhile;  ?>

				<?php woocommerce_product_loop_end(); ?>

			<?php else : ?>

				<?php wc_get_template('loop/no-products-found.php'); ?>

			<?php endif; ?>

		</div>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
			<div class="bwp-top-bar bottom clearfix">
				<?php fashow_category_bottom(); ?>
			</div>
		</div>
		<?php //if ($sidebar_product == 'right' && is_active_sidebar('sidebar-product')) : ?>
			<!--<div class="bwp-sidebar sidebar-product <?php // echo esc_attr(fashow_get_class()->class_sidebar_right); ?>">-->
				<?php //dynamic_sidebar('sidebar-product'); ?>
			<!--</div>-->
		<?php //endif; ?>
	</div>
</div>
<?php
do_action('woocommerce_after_main_content');
get_footer('shop');
?>
