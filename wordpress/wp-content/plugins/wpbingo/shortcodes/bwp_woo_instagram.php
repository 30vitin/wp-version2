<?php
add_shortcode( 'bwp_woo_instagram', 'bwp_woo_instagram_shortcode' );
/* Create Vc_map */
if ( class_exists('Vc_Manager') && class_exists( 'WooCommerce' ) ) {
	add_action( 'vc_before_init', 'bwp_woo_instagram_load' );
}
/**
	* Add Vc Params
**/
function bwp_woo_instagram_load(){
	
	vc_map( array(
		"name" => __( "Wpbingo Instagram", "wpbingo" ),
		"base" => "bwp_woo_instagram",
		"category" => __( "Wpbingo Shortcode", "wpbingo"),
		"params" => array(
		array(
			"type" => "textfield",
			"heading" => __( "Title", "wpbingo" ),
			"param_name" => "title1",
			"value" => 'Wpbingo Instagram Widget',
			"description" => __( "Title", "wpbingo" )
		),			
		array(
			"type" => "attach_images",
			"class" => "",
			"heading" => __( "Image", "wpbingo"),
			"param_name" => "image_instagram",
			"value" => "",
			"description" => __( "Select image from media library","wpbingo")
		),
		array(
			"type" => "textfield",
			"heading" => __( "Link Instagram", "wpbingo" ),
			"param_name" => "link",
			"value" => '#',
			"description" => __( "Link Instagram", "wpbingo" )
		),	
		array(
			"type" => "dropdown",
			"heading" => __( "Number row per column", "wpbingo" ),
			"param_name" => "item_row",
			"value" =>array(1,2,3),
			"description" => __( "Number row per column", "wpbingo" )
		 ),	
		array(
			"type" => "dropdown",
			"heading" => __( "Number of Columns >1200px: ", "wpbingo" ),
			"param_name" => "columns",
			"value" => array(1,2,3,4,5,6,7,8),
			"description" => __( "Number of Columns >1200px:", "wpbingo" )
		 ),
		array(
			"type" => "dropdown",
			"heading" => __( "Number of Columns on 992px to 1199px:", "wpbingo" ),
			"param_name" => "columns1",
			"value" => array(1,2,3,4,5,6,7),
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
			"heading" => __( "Padding", "wpbingo" ),
			"param_name" => "padding",
			"value" => array( 'Yes' => '','No' => 'no-padding'),
			"description" => __( "Padding", "wpbingo" )
		 ),	 
		array(
			"type" => "dropdown",
			"heading" => __( "Layout", "wpbingo" ),
			"param_name" => "layout",
			"value" => array( 'Layout Default' => 'default','Slider' => 'slider' ),
			"description" => __( "Layout", "wpbingo" )
		 ),
	  )
   ) );
}
/**
	** Add Shortcode
**/
function bwp_woo_instagram_shortcode( $atts, $content = null ){
	extract( shortcode_atts(
		array(
			'title1' 	=> '',
			'image_instagram'	=> array(),
			'link'	=> '#',
			'item_row'=> 1,
			'columns' 	=> 3,
			'columns1' 	=> 3,
			'columns2' 	=> 3,
			'columns3' 	=> 1,
			'columns4' 	=> 1,
			'show_nav' 	=> false,
			'show_pag' 	=> false,
			'padding'   => '',
			'layout'  => 'default',
		), $atts )
	);
	ob_start();	
	if( $layout == 'slider'  ){
		include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-woo-instagram-widget/slider.php' );
	}elseif( $layout == 'default' ){
		include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-woo-instagram-widget/default.php' );				
	}
	
	$content = ob_get_clean();
	
	return $content;
}
?>