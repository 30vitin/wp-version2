<?php

namespace Inc\Base;

/**
 *
 */
class Enqueue
{
    public function register()
    {
        add_action('admin_enqueue_scripts', array($this, 'enqueue'));
        add_action('wp_enqueue_scripts', array($this, 'wp_enqueue'));
    }

    public function enqueue()
    {
        wp_enqueue_style('yappy_bg_para_woocommerce_admin_style', PLUGIN_URL . '/assets/admin_bg-payment.css');
        wp_enqueue_script('yappy_bg_para_woocommerce_admin_script', PLUGIN_URL . '/assets/admin_bg-payment.js', array('jquery'), 1, 'true');
    }

    public function wp_enqueue()
    {
        wp_enqueue_script('jquery');
        add_action('wp_head', array($this, 'myplugin_ajaxurl'));
        wp_enqueue_style('yappy_bg_para_woocommerce_wp_style', PLUGIN_URL . '/assets/wp_bg-payment.css');
        wp_enqueue_script('yappy_bg_para_woocommerce_wp_script', PLUGIN_URL . '/assets/bg-payment.js');
    }

    public function myplugin_ajaxurl()
    {

        echo '<script type="text/javascript">
                var ajaxurl = "' . admin_url('admin-ajax.php') . '";
              </script>';
    }
}
