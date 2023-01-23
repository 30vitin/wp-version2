<?php
	add_shortcode( 'bwp_image_gallery', 'bwp_image_gallery_shortcode');
	add_action( 'vc_before_init', 'bwp_image_gallery_shortcode_load');

	/**
		* Add Vc Params
	**/
	function bwp_image_gallery_shortcode_load(){
		vc_map( array(
			"name" => __( "Wpbingo Image Gallery", "wpbingo" ),
			"base" => "bwp_image_gallery",
			"category" => __( "Wpbingo Shortcode", "wpbingo"),
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => __( "Title", "wpbingo" ),
					"param_name" => "title1",
					"value" => 'Wpbingo Image Gallery',
					"description" => __( "Title", "wpbingo" )
				),	
				array(
					"type" => "textfield",
					"heading" => __( "Extra Class", "wpbingo" ),
					"param_name" => "class",
					"value" => '',
					"description" => __( "Title", "wpbingo" )
				),					
				array(
					"type" => "attach_images",
					"class" => "",
					"heading" => __( "Image", "wpbingo"),
					"param_name" => "image_gallery",
					"value" => "",
					"description" => __( "Select image from media library","wpbingo")
				),					
				array(
					"type" => "dropdown",
					"heading" => __( "Show Navigation", "wpbingo" ),
					"param_name" => "show_nav",
					"value" => array( 'Yes' => 'true','No' => 'false'),
					"description" => __( "Show Navigation", "wpbingo" )
				 ),		
				array(
					"type" => "dropdown",
					"heading" => __( "Show Pagination", "wpbingo" ),
					"param_name" => "show_pag",
					"value" => array( 'Yes' => 'true','No' => 'false'),
					"description" => __( "Show Pagination", "wpbingo" )
				),	
				 array(
					"type" => "dropdown",
					"heading" => __( "Number of Columns >1200px: ", "wpbingo" ),
					"param_name" => "columns",
					"value" => array(1,2,3,4,5,6),
					"description" => __( "Number of Columns >1200px:", "wpbingo" )
				 ),
				 array(
					"type" => "dropdown",
					"heading" => __( "Number of Columns on 992px to 1199px:", "wpbingo" ),
					"param_name" => "columns1",
					"value" => array(1,2,3,4,5,6),
					"description" => __( "Number of Columns on 992px to 1199px:", "wpbingo" )
				 ),
				 array(
					"type" => "dropdown",
					"heading" => __( "Number of Columns on 768px to 991px:", "wpbingo" ),
					"param_name" => "columns2",
					"value" => array(1,2,3,4,5,6),
					"description" => __( "Number of Columns on 768px to 991px:", "wpbingo" )
				 ),
				 array(
					"type" => "dropdown",
					"heading" => __( "Number of Columns on 480px to 767px:", "wpbingo" ),
					"param_name" => "columns3",
					"value" => array(1,2,3,4,5,6),
					"description" => __( "Number of Columns on 480px to 767px:", "wpbingo" )
				 ),
				 array(
					"type" => "dropdown",
					"heading" => __( "Number of Columns in 480px or less than:", "wpbingo" ),
					"param_name" => "columns4",
					"value" => array(1,2,3,4,5,6),
					"description" => __( "Number of Columns in 480px or less than:", "wpbingo" )
				 ),					
				array(
					"type" => "dropdown",
					"heading" => __( "Layout", "wpbingo" ),
					"param_name" => "layout",
					"value" => array( 'Layout Default' => 'default'),
					"description" => __( "Layout", "wpbingo" )
				 ),			 
			)
		));	   
	}
	/**
		** Add Shortcode
	**/
	function bwp_image_gallery_shortcode( $atts, $content = null ){
		extract( shortcode_atts(
			array(
				'title1' 	=> '',
				'class' 	=> '',
				'image_gallery'	=> array(),
				'show_nav'  => 'true',
				'show_pag'  => 'true',
				'columns' => 4,
				'columns1' => 4,
				'columns2' => 3,
				'columns3' => 2,
				'columns4' => 1,				
				'layout'  	=> 'default',
			), $atts )
		);
		ob_start();	
		if( $layout == 'default' )
			include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-image-gallery/default.php' );
		$content = ob_get_clean();
		
		return $content;
	}
?>