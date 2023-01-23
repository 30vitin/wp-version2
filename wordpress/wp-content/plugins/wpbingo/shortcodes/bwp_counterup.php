<?php
/**
 * Wpbingo CounterUp
 * Plugin URI: http://www.wpbingo.com
 * Version: 1.0
 * This Widget help you to show images of product as a beauty tab reponsive slideshow
 */
	
	add_shortcode( 'bwp_counterup', 'bwp_counterup_shortcode' );

	/* Create Vc_map */
	add_action( 'vc_before_init', 'bwp_counterup_shortcode_load' );

	/**
		* Add Vc Params
	**/
	function bwp_counterup_shortcode_load(){
		
		vc_map( array(
			"name" => esc_html__( "Wpbingo CounterUp", 'wpbingo'),
			"base" => "bwp_counterup",
			"category" => esc_html__( "Wpbingo Shortcode", 'wpbingo'),
			"params" => array(
			array(
				"type" => "textfield",
				"heading" => esc_html__( "Title", 'wpbingo'),
				"param_name" => "title1",
				'admin_label' => true,
			),
			array(
				'heading'     => esc_html__( 'Number', 'wpbingo'),
				'type'        => 'textfield',
				'param_name'  => 'number',
			),
		  )
	   ) );
	}
	/**
		** Add Shortcode
	**/
	function bwp_counterup_shortcode( $atts, $content = null ){
		extract( shortcode_atts(
			array(
				'title1'   => '',
				'number'   => '',
			), $atts )
		);
		ob_start();	

		include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-counterup/default.php' );
		
		$content = ob_get_clean();
		
		return $content;
	}	
?>