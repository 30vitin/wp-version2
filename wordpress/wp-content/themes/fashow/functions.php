<?php

define('fashow_version','1.1.1'); 
if (!isset($content_width)) { $content_width = 940; }

require_once( get_template_directory().'/inc/class-tgm-plugin-activation.php' );
require_once (get_template_directory().'/inc/plugin-requirement.php');
require_once(get_template_directory().'/inc/function.php' );
require_once( get_template_directory().'/inc/loader.php' );
require_once(get_template_directory().'/inc/megamenu/megamenu.php' );
include_once(get_template_directory().'/inc/megamenu/mega_menu_custom_walker.php' );
include_once( get_template_directory().'/inc/menus.php' );
include_once(get_template_directory().'/inc/template-tags.php' );
require_once( get_template_directory().'/inc/woocommerce.php' );
require_once(get_template_directory().'/inc/admin/functions.php' );
require_once( get_template_directory().'/inc/admin/theme_options.php' );

function fashow_custom_css() {
	$fashow_settings = fashow_global_settings();
	if (!is_admin()) {
		wp_enqueue_style( 'fashow-style-template', get_template_directory_uri().'/css/template.css'); 
		ob_start(); 
		include( get_template_directory().'/inc/custom_css.php' ); 
		$content = ob_get_clean();
		$content = str_replace(array("\r\n", "\r"), "\n", $content);
		$csss = explode("\n", $content);
		$custom_css = array();
		foreach ($csss as $i => $css) { if(!empty($css)) $custom_css[] = trim($css); }
		wp_add_inline_style( 'fashow-style-template', implode($custom_css) );  
	}
}

add_action('wp_enqueue_scripts', 'fashow_custom_css' );

function fashow_custom_js() {
	if (!is_admin()) {
		wp_enqueue_script( 'fashow-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery'), null, true );
		ob_start(); 
		include( get_template_directory().'/inc/custom_js.php' ); 
		$content = ob_get_clean();
		$content = str_replace(array("\r\n", "\r"), "\n", $content);
		$jsss = explode("\n", $content);
		$custom_js = array();
		foreach ($jsss as $i => $js) { if(!empty($js)) $custom_js[] = trim($js);}
			wp_add_inline_script( 'fashow-script', implode($custom_js) );
	}
}

add_action('wp_enqueue_scripts', 'fashow_custom_js' );








