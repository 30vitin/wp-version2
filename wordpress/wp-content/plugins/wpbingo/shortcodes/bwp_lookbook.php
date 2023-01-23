<?php
	add_shortcode( 'bwp_lookbook', 'bwp_lookbook_shortcode');
	add_action( 'vc_before_init', 'bwp_lookbook_shortcode_load');

	/**
		* Add Vc Params
	**/
	function bwp_lookbook_shortcode_load(){
		global $wpdb;
		$terms = array();
		
		$lookbooks = $wpdb->get_results("SELECT id, name FROM `" . $wpdb->prefix . LOOKBOOK_TABLE . "`",ARRAY_A );	
		if($lookbooks){
			foreach($lookbooks as $lookbook)	
				$terms[$lookbook['name']]	= $lookbook['id'];
		}
		vc_map( array(
			"name" => __( "Wpbingo Lookbook", "wpbingo" ),
			"base" => "bwp_lookbook",
			"category" => __( "Wpbingo Shortcode", "wpbingo"),
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => __( "Title", "wpbingo" ),
					"param_name" => "title1",
					"value" => 'Wpbingo Lookbook',
					"description" => __( "Title", "wpbingo" )
				),	
				array(
					'heading'     => esc_html__( 'Content', 'wpbingo'),
					'type'        => 'textarea',
					'param_name'  => 'desc',
				),				
				array(
					"type" => "checkbox",
					"heading" => __( "Lookbook", "wpbingo" ),
					"param_name" => "lookbook",
					"value" => $terms,
					"description" => __( "Choosen Lookbook", "wpbingo" )
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
					"value" => array( 'Default' => 'default', 'Default Left' => 'default-left', 'Default Right' => 'default-right', 'Layout Slider' => 'slider'),
					"description" => __( "Layout", "wpbingo" )
				 ),
			)
		));	   
	}
	/**
		** Add Shortcode
	**/
	function bwp_lookbook_shortcode( $atts, $content = null ){
		extract( shortcode_atts(
			array(
				'title1' 	=> '',
				'desc' 	=> '',
				'class' 	=> '',
				'lookbook'	=> array(),
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
		if( $layout == 'default-left' || $layout == 'default-right' || $layout == 'default' )
			include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-lookbook/default.php' );
		elseif( $layout == 'slider' )
			include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-lookbook/slider.php' );
		$content = ob_get_clean();
		
		return $content;
	}
?>