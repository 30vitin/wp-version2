<?php

namespace Inc\Base;

class Links
{

    public function register()
    {
        add_filter("plugin_action_links_" . PLUGIN_NAME, array($this, 'settings_link'));
    }

    public function settings_link($links)
    {
        // add custom settings link
        $settings_link = '<a href="admin.php?page=wc-settings&tab=checkout&section=yappy_payment">Settings</a>';
        array_unshift($links, $settings_link);
        return $links;
    }
}
