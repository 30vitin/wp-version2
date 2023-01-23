<?php
/**
	* Wpbingo Woocommerce Slider
	* Register Widget Woocommerce Slider
	* @author 		wpbingo
	* @version     1.0.0
**/
		
		add_shortcode( 'woo_slide', 'bwp_woo_slider_shortcode');
		add_action( 'vc_before_init', 'bwp_woo_slider_shortcode_load' );
		add_action( 'wp_ajax_bwp_load_more_callback', 'bwp_load_more_callback' );
		add_action( 'wp_ajax_nopriv_bwp_load_more_callback', 'bwp_load_more_callback' );	
		
		function bwp_load_more_callback(){
			global $wpdb;
			$dir =	WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-product-list/default_ajax.php';
			include $dir;
		}			
		/**
		* Add Vc Params
		**/
		function bwp_woo_slider_shortcode_load(){
			$terms = get_terms( 'product_cat', array( 'parent' => 0, 'hide_empty' => false ) );
			if( count( $terms ) == 0 ){
				return ;
			}
			$term = array( __( 'All Categories', "wpbingo" ) => '' );
			foreach( $terms as $cat ){
				$term[$cat->name] = $cat -> slug;
			}
			vc_map( array(
			  "name" => __( "Wpbingo Products List", "wpbingo" ),
			  "base" => "woo_slide",
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
					"heading" => __( "Description", "wpbingo" ),
					"param_name" => "description",
					"value" => '',
					"description" => __( "Description", "wpbingo" )
				 ),
				 array(
					"type" => "textfield",
					"heading" => __( "Extra Class", 'wpbingo' ),
					"param_name" => "class",
					"value" => '',
					"description" => __( "Extra Class", 'wpbingo' )
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
					"heading" => __( "Source Product", "wpbingo" ),
					"param_name" => "source",
					"value" => array( 'Default' => 'default', 'Featured Product ' => 'featured','Sale Product' => 'sale', 'Top Rating' => 'toprating', 'Best Sales' => 'bestsales', 'Child Category' => 'childcat'),
					"description" => __( "Source Product", "wpbingo" )
				 ),				 
				 array(
					"type" => "dropdown",
					"heading" => __( "Order By", "wpbingo" ),
					"param_name" => "orderby",
					"value" => array('Name' => 'name', 'Author' => 'author', 'Date' => 'date', 'Title' => 'title', 'Modified' => 'modified', 'Parent' => 'parent', 'ID' => 'ID', 'Random' =>'rand', 'Comment Count' => 'comment_count'),
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
					"heading" => __( "Number Of Products", "wpbingo" ),
					"param_name" => "numberposts",
					"value" => 5,
					"description" => __( "Number Of Products", "wpbingo" )
				 ),
				 array(
					"type" => "dropdown",
					"heading" => __( "Number row per column", "wpbingo" ),
					"param_name" => "item_row",
					"value" =>array(1,2,3,4,5),
					"description" => __( "Number row per column", "wpbingo" )
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
					"type" => "attach_image",
					"class" => "",
					"heading" => __( "Banner", "wpbingo"),
					"param_name" => "banner",
					"value" => "",
					"description" => __( "Select image from media library","wpbingo")
				),				 
				array(
					"type" => "textfield",
					"heading" => __( "Link Banner", "wpbingo" ),
					"param_name" => "link",
					"value" => '#'
				),				 
				array(
					"type" => "dropdown",
					"heading" => __( "Show Navigation", "wpbingo" ),
					"param_name" => "show_nav",
					"value" => array('No' => 'false','Yes' => 'true'),
					"description" => __( "Show Navigation", "wpbingo" ),
					'dependency' => array(
						'element' => 'layout',
						'value'	=> array("slider","slider2"),
					)					
				),
				array(
					"type" => "dropdown",
					"heading" => __( "Show Pagination", "wpbingo" ),
					"param_name" => "show_pag",
					"value" => array( 'Yes' => 'true','No' => 'false'),
					"description" => __( "Show Pagination", "wpbingo" ),
					'dependency' => array(
						'element' => 'layout',
						'value'	=> array("slider2"),
					)
				),				
				array(
					"type" => "dropdown",
					"heading" => __( "Layout", "wpbingo" ),
					"param_name" => "layout",
					"value" => array( 
						'Default' => 'default', 
						'Default 2' => 'default2', 
						'Slider' => 'slider',
						'Slider 2' => 'slider2',
						'Load More'  => 'loadmore'
					),
					"description" => __( "Source Product", "wpbingo" )
				)			
			  )
		   ) );
		}
		/**
			** Add Shortcode
		**/
		function bwp_woo_slider_shortcode( $atts, $content = null ){
			extract( shortcode_atts(
				array(
					'title1' => '',
					'description' => '',	
					'class' => '',				
					'orderby' => '',
					'order'	=> '',
					'category' => '',
					'numberposts' => 5,
					'length' => 25,
					'item_row'=> 1,
					'columns' => 4,
					'columns1' => 4,
					'columns2' => 3,
					'columns3' => 2,
					'columns4' => 1,
					'show_nav'	=> 'false',
					'show_pag'  => 'true',
					'source'  => 'default',
					'banner' => '',
					'link' => '#',					
					'layout'  => 'default',
				), $atts )
			);
			
			if($banner){
				$banner = wp_get_attachment_image_src( $banner,'full');
				$banner = $banner[0];		
			}	
		
			ob_start();		
			
			switch ($source) {
			case 'default':
				$default = array();
				if( $category){
					$default = array(
						'post_type' => 'product',
						'tax_query' => array(
						array(
							'taxonomy'  => 'product_cat',
							'field'     => 'slug',
							'terms'     => $category ) ),
						'orderby' => $orderby,
						'order' => $order,
						'post_status' => 'publish',
						'showposts' => $numberposts
					);
				}else{
					$default = array(
						'post_type' => 'product',		
						'orderby' => $orderby,
						'order' => $order,
						'post_status' => 'publish',
						'showposts' => $numberposts
					);
				}
				$widget_id = 'bwp_default_'.rand().time();
				$widget_class = 'bwp_list_default';
				$list = new WP_Query( $default );
				break;
			case 'featured':
				if( $category){
					$default = array(
					'post_type'				=> 'product',
					'post_status' 			=> 'publish',
					'tax_query'	=> array(
						array(
							'taxonomy'	=> 'product_cat',
							'field'		=> 'slug',
							'terms'		=> $category)),
							'ignore_sticky_posts'	=> 1,
							'posts_per_page' 		=> $numberposts,
							'orderby' 				=> $orderby,
							'order' 				=> $order,
							'meta_query'			=> array(
								array(
									'key' 		=> '_visibility',
									'value' 	=> array('catalog', 'visible'),
									'compare'	=> 'IN'
								),
								array(
									'key' 		=> '_featured',
									'value' 	=> 'yes'
								)
							)
					);
				}else{
					$default = array(
						'post_type'				=> 'product',
						'post_status' 			=> 'publish',
						'ignore_sticky_posts'	=> 1,
						'posts_per_page' 		=> $numberposts,
						'orderby' 				=> $orderby,
						'order' 				=> $order,
						'meta_query'			=> array(
							array(
								'key' 		=> '_visibility',
								'value' 	=> array('catalog', 'visible'),
								'compare'	=> 'IN'
							),
							array(
								'key' 		=> '_featured',
								'value' 	=> 'yes'
							)
						)
					);
				}
				$widget_id = 'bwp_featured_'.rand().time();
				$widget_class = 'bwp_list_featured';
				$list = new WP_Query( $default );
				break;
			case 'toprating':
				if( $category){
				$default = array(
					'post_type'		=> 'product',
					'tax_query' => array(
						array(
							'taxonomy'	=> 'product_cat',
							'field'		=> 'slug',
							'terms'		=> $category,
							'operator' 	=> 'IN'
						)
					),
					'post_status' 	=> 'publish',
					'no_found_rows' => 1,					
					'showposts' 	=> $numberposts						
				);
				}else{
					$default = array(
						'post_type'		=> 'product',		
						'post_status' 	=> 'publish',
						'no_found_rows' => 1,					
						'showposts' 	=> $numberposts						
					);
				}
				$default['meta_query'] = WC()->query->get_meta_query();
				add_filter( 'posts_clauses', 'order_by_rating_post_clauses' );
				$widget_id = 'bwp_toprated_'.rand().time();
				$widget_class = 'bwp_list_toprated';
				$list = new WP_Query( $default );
				break;
			case 'sale':
				if( $category){
					$default = array(
						'post_type' 			=> 'product',
						'tax_query' => array(
							array(
								'taxonomy'	=> 'product_cat',
								'field'	=> 'slug',
								'terms'	=> $category,
								'operator' => 'IN'
							)
						),
						'meta_query'	=> array(
							'relation' => 'OR',
							array( // Simple products type
								'key'           => '_sale_price',
								'value'         => 0,
								'compare'       => '>',
								'type'          => 'numeric'
							),
							array( // Variable products type
								'key'           => '_min_variation_sale_price',
								'value'         => 0,
								'compare'       => '>',
								'type'          => 'numeric'
							)
						),			
						'post_status' 			=> 'publish',
						'ignore_sticky_posts'   => 1,
						'showposts'				=> $numberposts
					);
				}else{
					$default = array(
						'post_type' 			=> 'product',		
						'post_status' 			=> 'publish',
						'ignore_sticky_posts'   => 1,
						'showposts'				=> $numberposts,
						'meta_query'	=> array(
							'relation' => 'OR',
							array( // Simple products type
								'key'           => '_sale_price',
								'value'         => 0,
								'compare'       => '>',
								'type'          => 'numeric'
							),
							array( // Variable products type
								'key'           => '_min_variation_sale_price',
								'value'         => 0,
								'compare'       => '>',
								'type'          => 'numeric'
							)
						)
					);
				}
				$widget_id = 'bwp_sale_product_'.rand().time();
				$widget_class = 'bwp_sale_product';
				$list = new WP_Query( $default );
				break;				
			case 'bestsales':
				if( $category){
					$default = array(
						'post_type' 			=> 'product',
						'tax_query' => array(
							array(
								'taxonomy'	=> 'product_cat',
								'field'	=> 'slug',
								'terms'	=> $category,
								'operator' => 'IN'
							)
						),
						'post_status' 			=> 'publish',
						'ignore_sticky_posts'   => 1,
						'paged'	=> 1,
						'showposts'				=> $numberposts,
						'meta_key' 		 		=> 'total_sales',
						'orderby' 		 		=> 'meta_value_num',
						'meta_query' 			=> array(
							array(
								'key' 		=> '_visibility',
								'value' 	=> array( 'catalog', 'visible' ),
								'compare' 	=> 'IN'
							)
						)
					);
				}else{
					$default = array(
						'post_type' 			=> 'product',		
						'post_status' 			=> 'publish',
						'ignore_sticky_posts'   => 1,
						'showposts'				=> $numberposts,
						'meta_key' 		 		=> 'total_sales',
						'orderby' 		 		=> 'meta_value_num',
						'meta_query' 			=> array(
							array(
								'key' 		=> '_visibility',
								'value' 	=> array( 'catalog', 'visible' ),
								'compare' 	=> 'IN'
							)
						)
					);
				}
				$widget_id = 'bwp_bestsales_'.rand().time();
				$widget_class = 'bwp_list_bestsales';
				$list = new WP_Query( $default );
				break;
				case 'childcat':
				$default = array();
				$default = array(
					'post_type' => 'product',
					'tax_query' => array(
					array(
						'taxonomy'  => 'product_cat',
						'field'     => 'slug',
						'terms'     => $category ) ),
					'orderby' => $orderby,
					'order' => $order,
					'post_status' => 'publish',
					'showposts' => $numberposts
				);
				$term = get_term_by( 'slug', $category, 'product_cat' );
				$widget_id = 'bwp_childcat_'.rand().time();	
				$list = new WP_Query( $default );				
				break;
			}
			
			if( $layout == 'default' ){
				include( WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-product-list/default.php' );				
			}
			elseif( $layout == 'default2' ){
				include( WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-product-list/default_2.php' );			
			}elseif( $layout == 'slider' ){
				include( WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-product-list/slider.php' );			
			}elseif( $layout == 'slider2' ){
				include( WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-product-list/slider_2.php' );			
			}elseif( $layout == 'loadmore' ){
				$args_count 	= 	$default;	
				$args_count['showposts'] 	= 	-1;
				$wp_query_count = new WP_Query($args_count);	
				$total = $wp_query_count->post_count;
				include( WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-product-list/loadmore.php' );
			}		
			$content = ob_get_clean();
			
			return $content;
		}
?>