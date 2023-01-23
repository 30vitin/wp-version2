<?php
/***** Active Plugin ********/

add_action( 'tgmpa_register', 'fashow_register_required_plugins' );
function fashow_register_required_plugins() {
    $plugins = array(
		array(
            'name'               => esc_html__('Woocommerce', 'fashow'), 
            'slug'               => 'woocommerce', 
            'required'           => false
        ),		
		array(
            'name'               => esc_html__('Visual Composer', 'fashow'), 
            'slug'               => 'js_composer', 
            'source'             => get_template_directory() . '/plugins/js_composer.zip',
            'required'           => true, 
        ),
		array(
            'name'               => esc_html__('Revolution Slider', 'fashow'), 
			'slug'               => 'revslider',
			'source'             => get_template_directory() . '/plugins/revslider.zip', 
			'required'           => true, 
        ),
		array(
            'name'               => esc_html__('Wpbingo Core', 'fashow'), 
            'slug'               => 'wpbingo', 
            'source'             => get_template_directory() . '/plugins/wpbingo.zip',
            'required'           => true, 
        ),			
		array(
            'name'               => esc_html__('Redux Framework', 'fashow'), 
            'slug'               => 'redux-framework', 
            'required'           => false
        ),			
		array(
            'name'      		 => esc_html__('Contact Form 7', 'fashow'),
            'slug'     			 => 'contact-form-7',
            'required' 			 => false
        ),
		array(
            'name'     			 => esc_html__('YITH Woocommerce Wishlist', 'fashow'),
            'slug'      		 => 'yith-woocommerce-wishlist',
            'required' 			 => false
        ),
		array(
            'name'     			 => esc_html__('YITH WooCommerce Featured Video', 'fashow'),
            'slug'      		 => 'yith-woocommerce-featured-video',
            'required' 			 => false
        ),		
		array(
            'name'     			 => esc_html__('WooCommerce Variation Swatches', 'fashow'),
            'slug'      		 => 'variation-swatches-for-woocommerce',
            'required' 			 => false
        ), 		
    );
    $config = array();

    tgmpa( $plugins, $config );

}	