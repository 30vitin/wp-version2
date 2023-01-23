<?php
/**
 * Wpbingo Call to action
 * Plugin URI: http://www.wpbingo.com
 * Version: 1.0
 * This Widget help you to show images of product as a beauty tab reponsive slideshow
 */
	
	add_shortcode( 'bwp_cta', 'bwp_cta_shortcode' );
	add_action( 'vc_before_init', 'bwp_cta_shortcode_load' );

	/**
		* Add Vc Params
	**/
	function bwp_cta_shortcode_load(){
		
		vc_map( array(
			"name" => esc_html__( "Wpbingo Call to action", 'wpbingo'),
			"base" => "bwp_cta",
			"category" => esc_html__( "Wpbingo Shortcode", 'wpbingo'),
			"params" => array(
			array(
				"type" => "textfield",
				"heading" => esc_html__( "Title", 'wpbingo'),
				"param_name" => "title1",
				'admin_label' => true,
			),
			array(
				"type" => "attach_image",
				"class" => "",
				"heading" => esc_html__( "Image", 'wpbingo'),
				"param_name" => "image",
				"value" => "",
				"description" => esc_html__( "Select image from media library",'wpbingo')
			),
			array(
				'heading'     => esc_html__( 'Button label', 'wpbingo'),
				'type'        => 'textfield',
				'param_name'  => 'label',
				'value'		  => esc_html__( 'Join now', 'wpbingo'),
			),
			array(
				'heading'     => esc_html__( 'Button link', 'wpbingo'),
				'type'        => 'textfield',
				'param_name'  => 'link',
				'value'		  => esc_html__( '#', 'wpbingo'),
			),
		  )
	   ) );
	}
	/**
		** Add Shortcode
	**/
	function bwp_cta_shortcode( $atts, $content = null ){
		extract( shortcode_atts(
			array(
				'title1'   => '',
				'label'    => esc_html__( 'Join now', 'wpbingo'),
				'link'     => '#',
				'image'    => '',
			), $atts )
		);
		if($image){
			$image = wp_get_attachment_image_src( $image,'full');
			$image = $image[0];
		}	
		ob_start();	

		include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-cta/default.php' );
		
		$content = ob_get_clean();
		
		return $content;
	}	
?>