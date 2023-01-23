<?php

function wp_yappy_payment()
{
	require_once(dirname(__FILE__) . '/YappyPayment.php');

	add_action('admin_notices', function()
	{
	$logo = plugins_url('yappy-bg-para-woocommerce/assets/logo-bg-landscape.png', PLUGIN_PATH);
	$yappyPayment = new YappyPayment();

		if( $yappyPayment->needs_setup() ) {
			$text = "<img style='float:left;' src='$logo' alt='BG-logo'><p>Estás a pocos pasos de aceptar Yappy como método de pago en tu tienda. Ve a <a href='admin.php?page=wc-settings&tab=checkout&section=yappy_payment'>Configuraciones</a> para completar el proceso.</p>";
			echo "<div class='notice notice-bg notice-info is-dismissible'><p>$text</p></div>";
		}

	});

	function wp_yappybg_add($methods)
	{
		$methods[] = 'YappyPayment';
		return $methods;
	}

	add_filter('woocommerce_payment_gateways', 'wp_yappybg_add');
}

add_action('plugins_loaded', 'wp_yappy_payment');