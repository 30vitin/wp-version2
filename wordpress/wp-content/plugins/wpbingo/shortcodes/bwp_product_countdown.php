<?php
	add_shortcode( 'bwp_product_countdown', 'bwp_product_countdown_shortcode');
	
	add_action( 'vc_before_init','bwp_product_countdown_shortcode_load');
	
	function bwp_product_countdown_shortcode_load(){
		$terms = get_terms( 'product_cat', array( 'parent' => 0, 'hide_empty' => false ) );
		if( count( $terms ) == 0 ){
			return ;
		}
		$term = array( __( 'All Categories', "wpbingo" ) => '' );
		foreach( $terms as $cat ){
			$term[$cat->name] = $cat -> slug;
		}		
		vc_map( array(
		  "name" => __( "Wpbingo Woo Countdown Product", "wpbingo" ),
		  "base" => "bwp_product_countdown",
		  "category" => __( "Wpbingo Shortcode", "wpbingo"),
		  "params" => array(
			array(
				"type" => "textfield",
				"heading" => __( "Title", "wpbingo" ),
				"param_name" => "title1",
				"value" => '',
				"description" => __( "Title", "wpbingo" )
			),
			array(
				"type" => "textfield",
				"heading" => __( "Description", 'wpbingo' ),
				"param_name" => "description",
				"value" => '',
				"description" => __( "Description", 'wpbingo' )
			 ),
			array(
				"type" => "textfield",
				"heading" => __( "Extra Class", "wpbingo" ),
				"param_name" => "class",
				"value" => '',
				"description" => __( "Extra Class", "wpbingo" )
			),			
			array(
				"type" => "dropdown",
				"heading" => __( "Category", "wpbingo" ),
				"param_name" => "category",
				"value" => $term,
				"description" => __( "Select Categories", "wpbingo" )
			),	
			 array(
				"type" => "dropdown",
				"heading" => __( "Order By", "wpbingo" ),
				"param_name" => "orderby",
				"value" => array('Name' => 'name', 'Author' => 'author', 'Date' => 'date', 'Modified' => 'modified', 'Parent' => 'parent', 'ID' => 'ID', 'Random' =>'rand', 'Comment Count' => 'comment_count'),
				"description" => __( "Order By", "wpbingo" )
			 ),
			 array(
				"type" => "dropdown",
				"heading" => __( "Order", "wpbingo" ),
				"param_name" => "order",
				"value" => array('Descending' => 'DESC', 'Ascending' => 'ASC'),
				"description" => __( "Order", "wpbingo" )
			 ),	
			 array(
					"type" => "textfield",
					"heading" => __( "Length Excerpt", "wpbingo" ),
					"param_name" => "length",
					"value" => 150,
					"description" => __( "Length Excerpt", "wpbingo" )
				),			
			 array(
				"type" => "textfield",
				"heading" => __( "Number Of Products", "wpbingo" ),
				"param_name" => "numberposts",
				"value" => 5,
				"description" => __( "Number Of Products", "wpbingo" )
			 ),
			 array(
				"type" => "dropdown",
				"heading" => __( "Number row per column", "wpbingo" ),
				"param_name" => "item_row",
				"value" =>array(1,2,3),
				"description" => __( "Number row per column", "wpbingo" ),
				"std" => 1
			 ),
			 array(
				"type" => "dropdown",
				"heading" => __( "Number of Columns >1200px: ", "wpbingo" ),
				"param_name" => "columns",
				"value" => array(1,2,3,4,5,6),
				"description" => __( "Number of Columns >1200px:", "wpbingo" ),
				"std" => 4
			 ),
			 array(
				"type" => "dropdown",
				"heading" => __( "Number of Columns on 992px to 1199px:", "wpbingo" ),
				"param_name" => "columns1",
				"value" => array(1,2,3,4,5,6),
				"description" => __( "Number of Columns on 992px to 1199px:", "wpbingo" ),
				"std" => 4,
			 ),
			 array(
				"type" => "dropdown",
				"heading" => __( "Number of Columns on 768px to 991px:", "wpbingo" ),
				"param_name" => "columns2",
				"value" => array(1,2,3,4,5,6),
				"description" => __( "Number of Columns on 768px to 991px:", "wpbingo" ),
				"std" => 3
			 ),
			 array(
				"type" => "dropdown",
				"heading" => __( "Number of Columns on 480px to 767px:", "wpbingo" ),
				"param_name" => "columns3",
				"value" => array(1,2,3,4,5,6),
				"description" => __( "Number of Columns on 480px to 767px:", "wpbingo" ),
				"std" => 2
			 ),
			 array(
				"type" => "dropdown",
				"heading" => __( "Number of Columns in 480px or less than:", "wpbingo" ),
				"param_name" => "columns4",
				"value" => array(1,2,3,4,5,6),
				"description" => __( "Number of Columns in 480px or less than:", "wpbingo" ),
				"std" => 1
			 ),		
			array(
				"type" => "dropdown",
				"heading" => __( "Show Navigation", "wpbingo" ),
				"param_name" => "show_nav",
				"value" => array('No' => 'false','Yes' => 'true'),
				"description" => __( "Show Navigation", "wpbingo" ),
				'dependency' => array(
					'element' => 'layout',
					'value'	=> array("slider"),
				)
			 ),	
			 array(
				"type" => "dropdown",
				"heading" => __( "Show Pagination", "wpbingo" ),
				"param_name" => "show_pag",
				"value" => array('No' => 'false','Yes' => 'true'),
				"description" => __( "Show Pagination", "wpbingo" ),
				'dependency' => array(
					'element' => 'layout',
					'value'	=> array("slider"),
				)
			),
			array(
				"type" => "textfield",
				"heading" => __( "Link View All", "wpbingo" ),
				"param_name" => "link_all",
				"value" => '',
				"description" => __( "Link View All", "wpbingo" ),
				'dependency' => array(
					'element' => 'layout',
					'value'	=> array("slider","default"),
				)				
			),		
			array(
				"type" => "dropdown",
				"heading" => __( "Layout", "wpbingo" ),
				"param_name" => "layout",
				"value" => array( 'Layout Default' => 'default','Slider' => 'slider'),
				"description" => __( "Layout", "wpbingo" )
			),
		  )
		));
	   
	    if (!class_exists('WPBakeryShortCode_Bin_Product_Countdown')) {
			class WPBakeryShortCode_Bin_Product_Countdown extends WPBakeryShortCode {
			}
		}	   
	}
	
	/**
		** Add Shortcode
	**/
	function bwp_product_countdown_shortcode( $atts, $content = null ){
		extract( shortcode_atts(
			array(
				'title1' 		=> '',	
				'description' 	=> '',	
				'class' 	=> '',	
				'orderby' 	=> 'name',
				'order'		=> 'DESC',
				'category' 	=> '',
				'length' 	=> 150,
				'numberposts' => 5,
				'item_row'	=> 1,
				'columns' 	=> 4,
				'columns1' 	=> 4,
				'columns2' 	=> 3,
				'columns3' 	=> 2,
				'columns4' 	=> 1,
				'show_nav'	=> 'false',
				'show_pag'  => 'false',
				'link_all' => '',
				'layout'  => 'default',
			), $atts )
		);
		$term_name = esc_html__( 'All Categories', 'wpbingo' );
		$args = array(
			'post_type' => 'product',	
			'meta_query' => array(
				array(
					'key' => '_sale_price',
					'value' => 0,
					'compare' => '>',
					'type' => 'NUMERIC'
				),
				array(
					'key' => '_sale_price_dates_from',
					'value' => time(),
					'compare' => '<',
					'type' => 'NUMERIC'
				),
				array(
					'key' => '_sale_price_dates_to',
					'value' => 0,
					'compare' => '>',
					'type' => 'NUMERIC'
				)
			),
			'orderby' => $orderby,
			'order' => $order,
			'post_status' => 'publish',
			'showposts' => $numberposts	
		);
		if( $category != '' ){
			$term = get_term_by( 'slug', $category, 'product_cat' );
			if( $term ) :
				$term_name = $term->name;
			endif; 
			
			$args['tax_query'] = array(
				array(
					'taxonomy'  => 'product_cat',
					'field'     => 'slug',
					'terms'     => $category ));
		}
		
		$widget_id = 'bwp_countdown_'.rand().time();
		$list = new WP_Query( $args );		
		ob_start();		
		if( $layout == 'default' ){
			include( WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-product-countdown/default.php' );
			
		}	
		elseif( $layout == 'slider' ){
			include( WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-product-countdown/slider.php' );
			
		}				
		$content = ob_get_clean();
		
		return $content;
	}			
?>