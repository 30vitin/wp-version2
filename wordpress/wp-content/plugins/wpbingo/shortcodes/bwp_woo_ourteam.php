<?php
	add_shortcode( 'bwp_woo_ourteam', 'bwp_woo_ourteam_shortcode');
	add_action( 'vc_before_init', 'bwp_woo_ourteam_shortcode_load');

	/**
		* Add Vc Params
	**/
	function bwp_woo_ourteam_shortcode_load(){
		
		vc_map( array(
			"name" => __( "Wpbingo Our Team", "wpbingo" ),
			"base" => "bwp_woo_ourteam",
			"category" => __( "Wpbingo Shortcode", "wpbingo"),
			"params" => array(
			array(
				"type" => "textfield",
				"heading" => __( "Title", "wpbingo" ),
				"param_name" => "title1",
				"value" => 'Wpbingo Our Team',
				"description" => __( "Title", "wpbingo" )
			),
			array(
				"type" => "textfield",
				"heading" => __( "Number Of Our Team", "wpbingo" ),
				"param_name" => "numberposts",
				"value" => 5,
				"description" => __( "Number Of Our Team", "wpbingo" )
			),
			array(
				"type" => "textfield",
				"heading" => __( "Length Description", "wpbingo" ),
				"param_name" => "length",
				"value" => 45,
				"description" => __( "Number Of Products", "wpbingo" )
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
	   ) );
	   
	    if (!class_exists('WPBakeryShortCode_Woo_Ourteam')) {
			class WPBakeryShortCode_Woo_Ourteam extends WPBakeryShortCode {
			}
		}		   
	}
	/**
		** Add Shortcode
	**/
	function bwp_woo_ourteam_shortcode( $atts, $content = null ){
		extract( shortcode_atts(
			array(
				'title1' => '',
				'numberposts' => 5,
				'length' => 45,
				'columns' => 3,
				'columns1' => 3,
				'columns2' => 3,
				'columns3' => 1,
				'columns4' => 1,
				'layout'  => 'default',
			), $atts )
		);
		ob_start();	
		if( $layout == 'default' ){
			include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-woo-ourteam/default.php' );
		}
		
		$content = ob_get_clean();
		
		return $content;
	}
?>