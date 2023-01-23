<?php
	add_shortcode( 'bwp_woo_twitter', 'bwp_woo_twitter_shortcode');
	add_action( 'vc_before_init', 'bwp_woo_twitter_shortcode_load');

	/**
		* Add Vc Params
	**/
	function bwp_woo_twitter_shortcode_load(){
		$yes_no =  array(
				1 => __('Yes', "wpbingo"),
				0 => __('No', "wpbingo"),
		);
		
		vc_map( array(
			"name" => __( "Wpbingo Twitter", "wpbingo" ),
			"base" => "bwp_woo_twitter",
			"category" => __( "Wpbingo Shortcode", "wpbingo"),
			"params" => array(
			array(
				"type" => "textfield",
				"heading" => __( "Title", "wpbingo" ),
				"param_name" => "title1",
				"value" => __("Wpbingo Twitter Widget", "wpbingo" ),
			),
			array(
				"type" => "textfield",
				"heading" => __( "User", "wpbingo" ),
				"param_name" => "twitter_name",
				"value" => __( "Wpbingo", "wpbingo" ),
			),
			array(
				"type" => "textfield",
				"heading" => __( "Twitter Id", "wpbingo" ),
				"param_name" => "twitter_id",
				"value" => '512250912429969409'
			),
			array(
				"type" => "dropdown",
				"heading" => __( "Show Header", "wpbingo" ),
				"param_name" => "show_header",
				"value" => $yes_no,
			 ),	
			array(
				"type" => "dropdown",
				"heading" => __( "Show Footer", "wpbingo" ),
				"param_name" => "show_footer",
				"value" => $yes_no,
			),	
			array(
				"type" => "dropdown",
				"heading" => __( "Show Border", "wpbingo" ),
				"param_name" => "show_border",
				"value" => $yes_no
			),	
			array(
				"type" => "dropdown",
				"heading" => __( "Show Scrollbar", "wpbingo" ),
				"param_name" => "show_scrollbar",
				"value" => $yes_no
			),
			array(
				"type" => "dropdown",
				"heading" => __( "Transparent", "wpbingo" ),
				"param_name" => "transparent",
				"value" => $yes_no
			),	
			array(
				"type" => "dropdown",
				"heading" => __( "Show Replies", "wpbingo" ),
				"param_name" => "show_replies",
				"value" => $yes_no
			),				
			array(
				"type" => "textfield",
				"heading" => __( "Limit", "wpbingo" ),
				"param_name" => "limit",
				"value" => 3,
				"description" => __( "Limit", "wpbingo" )
			),
		  )
	   ) );

	    if (!class_exists('WPBakeryShortCode_Woo_Twitter')) {
			class WPBakeryShortCode_Woo_Twitter extends WPBakeryShortCode {
			}
		}		   
	   
	}
	/**
		** Add Shortcode
	**/
	function bwp_woo_twitter_shortcode( $atts, $content = null ){
		extract( shortcode_atts(
			array(
				'title' => __('Wpbingo Woo Twitter', "wpbingo"),
				'twitter_name' => 'wpbingo',
				'twitter_id' => '512250912429969409',
				'limit' => 2,
				'width' => '180px',
				'height' => '200px',
				'limit'  => 3,
				'show_header' => 0,
				'show_footer' => 0,
				'show_border' => 0,
				'show_scrollbar' => 0,
				'transparent' => 0,
				'show_replies' => 0,					
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
			include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-woo-twitter-widget/default.php' );
		}else{
			include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-woo-twitter-widget/theme1.php' );
		}
		
		$content = ob_get_clean();
		
		return $content;
	}
?>