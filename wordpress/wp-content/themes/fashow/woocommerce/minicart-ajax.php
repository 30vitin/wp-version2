<?php 
if ( !class_exists('Woocommerce') ) { 
	return false;
}
global $woocommerce; ?>
<div id="cart" class="dropdown cart-edited mini-cart top-cart ">
	<a class="cart-icon"  data-delay="0" href="/cart" title="<?php esc_attr_e('View your shopping cart', 'fashow'); ?>">
		<i class="ion ion-bag"></i>
		<?php echo sprintf(_n(' <span class="mini-cart-items">%d</span> ', ' <span class="mini-cart-items">%d</span> ', $woocommerce->cart->cart_contents_count, 'fashow'), $woocommerce->cart->cart_contents_count);?>
		<span class="small-text text-green">$<?php echo number_format($woocommerce->cart->cart_contents_total+$woocommerce->cart->tax_total,2);?></span>

	</a>
	<div class="cart-popup">
		<?php woocommerce_mini_cart(); ?>
	</div>
</div>
