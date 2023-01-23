<?php

/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 7.0.1
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

global $product;

if (!$product->is_purchasable()) {
	return;
}

?>

<?php
// Availability
$availability      = $product->get_availability();
$availability_html = empty($availability['availability']) ? '' : '<p class="stock ' . esc_attr($availability['class']) . '">' . esc_html($availability['availability']) . '</p>';

echo apply_filters('woocommerce_stock_html', $availability_html, $availability['availability'], $product);
?>

<?php if ($product->is_in_stock()) : ?>

	<?php do_action('woocommerce_before_add_to_cart_form'); ?>

	<form class="cart" method="post" enctype='multipart/form-data'>
		<?php do_action('woocommerce_before_add_to_cart_button');

		echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item); // PHPCS: XSS ok.

		//echo $cart_item['quantity'];
		?>

		<div class="group-form intereactive-hover">
			<label for="cantidad" class="cantidad-text">Cantidad</label>
			<?php
			if (intval($cart_item['quantity']) >= 10) {
			?>
				<input type="number" name="cart[<?php echo $cart_item_key ?>][qty]" class="form-control input-qualit qty" value="<?php echo intval($cart_item['quantity']); ?>">

			<?php

			} else { ?>

				<select name="cart[<?php echo $cart_item_key ?>][qty]" id="" class="form-control selected-qualit qty">
					<option value="1" <?php echo intval($cart_item['quantity']) == 1 ? "selected" : "" ?>>1</option>
					<option value="2" <?php echo intval($cart_item['quantity']) == 2 ? "selected" : "" ?>>2</option>
					<option value="3" <?php echo intval($cart_item['quantity']) == 3 ? "selected" : "" ?>>3</option>
					<option value="4" <?php echo intval($cart_item['quantity']) == 4 ? "selected" : "" ?>>4</option>
					<option value="5" <?php echo intval($cart_item['quantity']) == 5 ? "selected" : "" ?>>5</option>
					<option value="6" <?php echo intval($cart_item['quantity']) == 6 ? "selected" : "" ?>>6</option>
					<option value="7" <?php echo intval($cart_item['quantity']) == 7 ? "selected" : "" ?>>7</option>
					<option value="8" <?php echo intval($cart_item['quantity']) == 8 ? "selected" : "" ?>>8</option>
					<option value="9" <?php echo intval($cart_item['quantity']) == 9 ? "selected" : "" ?>>9</option>
					<option value="10">+ 10</option>

				</select>
				<input type="number" name="cart[<?php echo $cart_item_key ?>][qty]" class="form-control input-qualit qty d-none" value="<?php echo intval($cart_item['quantity']); ?>">


			<?php

			} ?>
		</div>

		<div class="extra-info-section">
			<p>

				<span class="icon-and-text">
					<svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-package" viewBox="0 0 64 64">
						<defs>
							<style>
								.cls-1 {
									fill: none;
									stroke: #000;
									stroke-width: 2px
								}
							</style>
						</defs>
						<path class="cls-1" d="M32 56L9.05 42.88V22.12L32 9l22.95 13.12v20.76L32 56z"></path>
						<path class="cls-1" d="M32 56V35.23l22.95-13.11M32 35.23L9.05 22.12M42.13 14.79L20.52 28.67v8.75"></path>
					</svg>

					<span class="text-icon-svg"> Envio Discreto</span>

				</span>
			</p>
			<p>

				<span class="icon-and-text">
					<svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-circle-checkmark" viewBox="0 0 64 64">
						<defs>
							<style>
								.cls-1 {
									fill: none;
									stroke: #000;
									stroke-width: 2px
								}
							</style>
						</defs>
						<path class="cls-1" d="M52.68 24.48A22 22 0 1 1 47 15.93M21 32l8.5 8.5L57 13"></path>
					</svg>

					<span class="text-icon-svg"> Productos Garantizados</span>

				</span>
			</p>
			<p>
				<span class="icon-and-text">
					<svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-lock" viewBox="0 0 64 64">
						<defs>
							<style>
								.cls-1 {
									fill: none;
									stroke: #000;
									stroke-width: 2px
								}
							</style>
						</defs>
						<path id="svg_2" data-name="svg 2" class="cls-1" d="M20.48 24v-3c0-6.6 5.52-11 11.76-11C39 10 44 15.13 44 21v3"></path>
						<path id="svg_4" data-name="svg 4" class="cls-1" d="M11.62 24h41.25v29.77H11.62z"></path>
						<path class="cls-1" d="M32.24 37v7"></path>
						<circle class="cls-1" cx="32.24" cy="35.5" r="1.5"></circle>
					</svg>
					<span class="text-icon-svg"> Pago Seguros</span>


				</span>

			</p>
		</div>
		<?php
		/*if ( ! $product->is_sold_individually() ) {
	 			woocommerce_quantity_input( array(
	 				'min_value'   => apply_filters( 'woocommerce_quantity_input_min', 1, $product ),
	 				'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->backorders_allowed() ? '' : $product->get_stock_quantity(), $product ),
	 				'input_value' => ( isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : 1 )
	 			) );
	 		}*/
		?>
		<input type="hidden" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" />

		<!--
	 	
	 	<button type="submit" class="single_add_to_cart_button button alt"><?php echo esc_html($product->single_add_to_cart_text()); ?></button>
		-->
		<div class="row col-md-12">

			<button type="submit" class="checkout-button button wp-button-simple">
				Agregar al carrito
			</button>

			<button type="button" class="checkout-button button wp-button-simple btn-buy-now goto-checkout">
				Comprar Ahora
			</button>

		</div>
		<?php //do_action( 'woocommerce_after_add_to_cart_button' ); 
		?>
	</form>

	<?php do_action('woocommerce_after_add_to_cart_form'); ?>

<?php endif; ?>
