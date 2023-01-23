<?php
/**
 * Wpbingo Add Video
 * Plugin URI: http://www.wpbingotheme.com
 * Version: 1.0
 * This Widget help you to show images of product as a beauty tab reponsive slideshow
 */

	add_shortcode( 'woo_video', 'bwp_video' );
	
	/* Create Vc_map */
	if ( class_exists('Vc_Manager')) {
		add_action( 'vc_before_init', 'bwp_video_load' );
	}

	function bwp_video_load(){
		
		vc_map( array(
			"name" => __( "Wpbingo Video", 'wpbingo' ),
			"base" => "woo_video",
			"category" => __( "Wpbingo Shortcode", 'wpbingo'),
			"params" => array(
			array(
				"type" => "textfield",
				"heading" => __( "Title", 'wpbingo' ),
				"param_name" => "title1",
				"value" => 'Wpbingo Video',
				"description" => __( "Title", 'wpbingo' )
			),
			array(
				"type" => "textfield",
				"heading" => __( "Extra Class", 'wpbingo' ),
				"param_name" => "class",
				"value" => '',
				"description" => __( "Extra Class", 'wpbingo' )
			),			
			array(
				"type" => "textfield",
				"heading" => __( "Video Link", 'wpbingo' ),
				"param_name" => "link",
				"value" => '#'
			),
			array(
				"type" => "attach_image",
				"class" => "",
				"heading" => __( "Image", 'wpbingo'),
				"param_name" => "image",
				"value" => "",
				"description" => __( "Select image from media library",'wpbingo')
			),			
			array(
				"type" => "dropdown",
				"heading" => __( "Style", 'wpbingo' ),
				"param_name" => "layout",
				"value" => array( 
					'Style Default' => 'default', 
				),
				"description" => __( "Select Style", 'wpbingo' )
			 ),
		  )
	   ) );
	}
	/**
		** Add Shortcode
	**/
	function bwp_video( $atts, $content = null ){
		extract( shortcode_atts(
			array(
				'title1' => '',
				'class' => '',
				'link' => '#',
				'image' => '',
				'layout'  => 'default',
			), $atts )
		);

		if($image){
			$image = wp_get_attachment_image_src( $image,'full');
			$image = $image[0];		
		}	
		ob_start();	

		if( $layout == 'default' ){
			include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-video/default.php' );		
		}

		$content = ob_get_clean();
		
		return $content;
	}
