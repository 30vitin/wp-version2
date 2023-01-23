<?php
	add_shortcode( 'bwp_lookbook_deal', 'bwp_lookbook_deal_shortcode');
	add_action( 'vc_before_init', 'bwp_lookbook_deal_shortcode_load');

	/**
		* Add Vc Params
	**/
	function bwp_lookbook_deal_shortcode_load(){
		global $wpdb;
		$terms = array();
		
		$lookbook_deals = $wpdb->get_results("SELECT id, name FROM `" . $wpdb->prefix . LOOKBOOK_TABLE . "`",ARRAY_A );	
		if($lookbook_deals){
			foreach($lookbook_deals as $lookbook_deal)	
				$terms[$lookbook_deal['name']]	= $lookbook_deal['id'];
		}
		vc_map( array(
			"name" => __( "Wpbingo Lookbook Deal", "wpbingo" ),
			"base" => "bwp_lookbook_deal",
			"category" => __( "Wpbingo Shortcode", "wpbingo"),
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => __( "Title", "wpbingo" ),
					"param_name" => "title1",
					"value" => 'Wpbingo Lookbook Deal',
					"description" => __( "Title", "wpbingo" )
				),	
				array(
					"type" => "textfield",
					"class" => "",
					"heading" => __( "Description", "wpbingo" ),
					"param_name" => "description",
					"value" => __( "", "wpbingo" ),
					"description" => __( "Description", "wpbingo" )
				 ),
				array(
					'heading'     => esc_html__( 'Content', 'wpbingo'),
					'type'        => 'textarea',
					'param_name'  => 'desc',
				),		
				array(
					"type" => "dropdown",
					"heading" => __( "Lookbook", "wpbingo" ),
					"param_name" => "lookbook_deal",
					"value" => $terms,
					"description" => __( "Choosen Lookbook", "wpbingo" )
				),
				array(
					"type" => "textfield",
					"heading" => __( "Time Coundown", "wpbingo" ),
					"param_name" => "time_deal",
					"description" => __( "Ex : 25-5-2019", "wpbingo" )
				),
				array(
					"type" => "textfield",
					"heading" => __( "Link", "wpbingo" ),
					"param_name" => "link",
					"value" => '#'
				),
				array(
					"type" => "dropdown",
					"heading" => __( "Layout", "wpbingo" ),
					"param_name" => "layout",
					"value" => array( 'Default' => 'default'),
					"description" => __( "Layout", "wpbingo" )
				 ),
			)
		));	   
	}
	/**
		** Add Shortcode
	**/
	function bwp_lookbook_deal_shortcode( $atts, $content = null ){
		extract( shortcode_atts(
			array(
				'title1' 	=> '',
				'description' => '',
				'desc' 	=> '',
				'time_deal' 	=> '25-5-2019',
				'lookbook_deal'	=> '',
				'link' => '#',
				'layout'  	=> 'default',
			), $atts )
		);
		ob_start();	
		$widget_id = 'bwp_lookbook_deal_'.rand().time();
		if( $layout == 'default')
			include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-lookbook-deal/default.php' );
		
		return $content;
	}
?>