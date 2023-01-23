<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    throw new Exception("There is a problem trying to uninstall the plugin...");
}

delete_option('woocommerce_yappy_payment_settings');