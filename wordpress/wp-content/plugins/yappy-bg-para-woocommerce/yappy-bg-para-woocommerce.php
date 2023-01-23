<?php

/**
 * Plugin Name: Botón de Pago Yappy para WooCommerce
 * Plugin URI: https://www.bgeneral.com/
 * Description: El checkout oficial de Yappy de Banco General para WooCommerce. Recibe pagos con Yappy directamente en tu tienda.
 * Version: W1.1.678
 * Author: Banco General S.A.
 * Author URI:  https://www.bgeneral.com
 * Domain Path: /languages
 * License: MIT
 * Text Domain: yappy-bg-para-woocommerce
 * Requires PHP: 7.0
 * WC requires at least: 3.0.0
 * WC tested up to: 5.1.0
 **/

if (!defined('ABSPATH')) {
    throw new Exception("There is a problem trying to install Yappy plugin...");
}

include('env.php');

define('BG_WOOCOMMERCE_VERSION', '4.0');
define('BG_PHP_VERSION', '7.0');
define('BG_WORDPRESS_VERSION', '5.2');
define('PLUGIN_PATH', plugin_dir_path(__FILE__));
define('PLUGIN_URL', plugin_dir_url(__FILE__));
define('PLUGIN_NAME', plugin_basename(__FILE__));
define('PLUGIN_VERSION', get_plugin_version());

if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    return;
}

if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once(dirname(__FILE__) . '/vendor/autoload.php');
}

function get_plugin_version()
{
    if (!function_exists('get_plugin_data')) {
        require_once(ABSPATH . 'wp-admin/includes/plugin.php');
    }

    $plugin_data = get_plugin_data(__FILE__);
    return  $plugin_data['Version'];
}

function notice_bg_message($version, $option)
{
    if (is_admin()) {
        $text = "El Botón de Pago Yappy requiere la versión $version o mayor de $option. Por favor actualiza el $option";
        add_action('admin_notices', function () use ($text, $option) {
            $update_page = esc_url(self_admin_url('update-core.php'));
            $update_link = "";
            if ($option === 'WooCommerce' || $option === 'Wordpress') {
                $update_link = "<a href='$update_page'>Actualizar</a>";
            }
            echo "<div class='notice notice-error'><p>$text $update_link</p></div>";
        });
    }
}

if (!version_compare($wp_version, BG_WORDPRESS_VERSION, ">=")) {
    notice_bg_message(BG_WOOCOMMERCE_VERSION, 'Wordpress');
}

if (class_exists('WooCommerce')) {
    global $woocommerce;
    if (!version_compare($woocommerce->version, BG_WOOCOMMERCE_VERSION, ">=")) {
        notice_bg_message(BG_WOOCOMMERCE_VERSION, 'WooCommerce');
    }
}

if (!version_compare(PHP_VERSION, BG_PHP_VERSION, ">=")) {
    notice_bg_message(BG_PHP_VERSION, 'PHP');
}

function activate()
{
    Inc\Base\Activate::activate();
}

register_activation_hook(__FILE__, 'activate');

function deactive()
{
    Inc\Base\Deactivate::deactivate();
}

register_deactivation_hook(__FILE__, 'deactive');

if (class_exists('Inc\\Init')) {
    Inc\Init::register_services();
    // load woocommerce configuration of yappy plugin
    require_once('woocommerce.php');
}


$updateChecker = Puc_v4_Factory::buildUpdateChecker(
    'https://bgx-digital-prod-ecommerce-plugins.s3.amazonaws.com/woocommerce/updates/details.json', // this is the link that handles the plugin version
    __FILE__,
    'yappy-bg-para-woocommerce',
    1 //Time in hours to verify updates
);
