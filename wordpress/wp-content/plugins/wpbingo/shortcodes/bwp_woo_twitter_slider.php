<?php	
	add_shortcode( 'bwp_woo_twitter_slider','bwp_woo_twitter_slider_shortcode');

	add_action( 'vc_before_init','bwp_woo_twitter_slider_shortcode_load');

	/**
		* Add Vc Params
	**/
	function bwp_woo_twitter_slider_shortcode_load(){
		$yes_no =  array(
				1 => __('Yes', "wpbingo"),
				0 => __('No', "wpbingo"),
		);
		
		vc_map( array(
			"name" => __( "Wpbingo Twitter Slider", "wpbingo" ),
			"base" => "bwp_woo_twitter_slider",
			"category" => __( "Wpbingo Shortcode", "wpbingo"),
			"params" => array(
			array(
				"type" => "textfield",
				"heading" => __( "Title", "wpbingo" ),
				"param_name" => "title",
				"value" => __("Wpbingo Twitter Slider Widget", "wpbingo" ),
			),
			array(
				"type" => "textfield",
				"heading" => __( "Twitter Name", "wpbingo"),
				"param_name" => "twitter_name",
				"value" => __( "Wpbingo", "wpbingo" ),
			),
			array(
				"type" => "textfield",
				"heading" => __( "Twitter Customer Key", "wpbingo" ),
				"param_name" => "twitter_customer_key",
				"value" => 'vA1kw62CSISJOZKSEpBvNMHPV'
			),	
			array(
				"type" => "textfield",
				"heading" => __( "Twitter Customer Secret", "wpbingo" ),
				"param_name" => "twitter_customer_secret",
				"value" => 'vA1kw62CSISJOZKSEpBvNMHPV'
			),
			array(
				"type" => "textfield",
				"heading" => __( "Twitter Access Token", "wpbingo" ),
				"param_name" => "twitter_access_token",
				"value" => '2811335408-mVDm69N490kUxvIbzBHCNyMJvaOwY2vac0Q1yOn'
			),	
			array(
				"type" => "textfield",
				"heading" => __( "Twitter Access Token Secret", "wpbingo" ),
				"param_name" => "twitter_access_token_secret",
				"value" => 'kyihndCB8UZiT8KLD5YvM6CFxQKGCfGQaiACNfSQFXnCk'
			),
			array(
				"type" => "textfield",
				"heading" => __( "Max Word Text", "wpbingo" ),
				"param_name" => "max_length",
				"value" => 10,
				"description" => __( "Max Word Text", "wpbingo" )
			),										
			array(
				"type" => "textfield",
				"heading" => __( "Limit", "wpbingo" ),
				"param_name" => "limit",
				"value" => 3,
				"description" => __( "Limit", "wpbingo" )
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
				"value" => array( 'Layout Default' => 'default', 'Layout 2' => 'layout2' ),
				"description" => __( "Layout", "wpbingo" )
			 ),
		  )
	   ) );
	   
	    if (!class_exists('WPBakeryShortCode_Woo_Twitter_Slider')) {
			class WPBakeryShortCode_Woo_Twitter_Slider extends WPBakeryShortCode {
			}
		}		   
	   
	}
	/**
		** Add Shortcode
	**/
	function bwp_woo_twitter_slider_shortcode( $atts, $content = null ){
		extract( shortcode_atts(
			array(
				'title' => 'Twitter',
				'twitter_name' => 'wpbingo',
				'twitter_customer_key' => 'vA1kw62CSISJOZKSEpBvNMHPV',
				'twitter_customer_secret' => 'UfmsUTfFipMvPyftIDGHKh6sJRw7YAWoaFFisd2paCYQ419Aak',
				'twitter_access_token'    => '2811335408-mVDm69N490kUxvIbzBHCNyMJvaOwY2vac0Q1yOn',
				'twitter_access_token_secret'    => 'kyihndCB8UZiT8KLD5YvM6CFxQKGCfGQaiACNfSQFXnCk',
				'limit' => 2,
				'max_length'	=> 10,
				'width' => '180px',
				'height' => '200px',
				'limit'  => 3,					
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
			include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-woo-twitter-slider-widget/default.php' );
		}else{
			include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-woo-twitter-slider-widget/theme1.php' );
		}
		
		$content = ob_get_clean();
		
		return $content;
	}
?>