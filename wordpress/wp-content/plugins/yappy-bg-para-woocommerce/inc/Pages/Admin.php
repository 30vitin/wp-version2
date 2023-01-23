<?php

namespace Inc\Pages;

class Admin
{

    public function add_admin_pages()
    {
        add_menu_page(
            'Pagos BG',
            'Pagos BG',
            'manage_options',
            'yappy_bg_para_woocommerce',
            array($this, 'admin_index'),
            plugins_url('yappy-bg-para-woocommerce/assets/yappy-ico.svg', PLUGIN_PATH),
            null
        );
    }

    public function admin_index()
    {
        // render html
        require_once(PLUGIN_PATH . 'templates/admin.phtml');
    }
}
