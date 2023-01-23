<?php global $product, $woocommerce_loop, $post; ?>
<div class="products-entry clearfix product-wapper grid">
	<div class="products-thumb">

		<?php
		/**
		 * woocommerce_before_shop_loop_item_title hook
		 *
		 * @hooked woocommerce_show_product_loop_sale_flash - 10
		 * @hooked woocommerce_template_loop_product_thumbnail - 10
		 */
		do_action('woocommerce_before_shop_loop_item_title');

		?>
		<?php do_action('woocommerce_after_shop_loop_item'); ?>
	</div>
	<div class='product-button'>
		<?php do_action('woocommerce_before_shop_loop_item'); ?>
	</div>
	<div class="products-content">
		<?php // add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );?>

		<?php do_action('woocommerce_after_shop_loop_item_title'); ?>

		<p class="product-title"><a href="<?php esc_url(the_permalink()); ?>"><?php esc_html(the_title()); ?></a></p>

	</div>
</div>
