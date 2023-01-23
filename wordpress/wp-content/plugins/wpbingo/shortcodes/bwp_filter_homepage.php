<?php	
	add_shortcode( 'bwp_filter_homepage', 'bwp_filter_homepage_shortcode');
	add_action( 'vc_before_init', 'bwp_filter_homepage_shortcode_load');
		/* Ajax Call*/
	add_action( 'wp_ajax_bwp_filter_homepage_callback', 'bwp_filter_homepage_callback');
	add_action( 'wp_ajax_nopriv_bwp_filter_homepage_callback', 'bwp_filter_homepage_callback');
	/**
		* Add Vc Params
	**/
	function bwp_filter_homepage_callback(){
		global $wpdb;
		$dir =	WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-filter-homepage/default_ajax.php';
		include $dir;
	}	
	
	function bwp_filter_homepage_shortcode_load(){
		$terms = get_terms( 'product_cat', array( 'parent' => 0, 'hide_empty' => false ) );
		if( count( $terms ) == 0 ){
			return ;
		}
		$term = array( __( 'All Category Product', 'js_composer' ) => 'all' );
		foreach( $terms as $cat ){
			$term[$cat->name] = $cat->slug;
		}		
		
		vc_map( array(
			"name" => __( "Wpbingo Filter Homepage", "wpbingo" ),
			"base" => "bwp_filter_homepage",
			"category" => __( "Wpbingo Shortcode", "wpbingo"),
			"params" => array(
			array(
				"type" => "textfield",
				"heading" => __( "Title", 'wpbingo' ),
				"param_name" => "title1",
				"value" => '',
				"description" => __( "Title", 'wpbingo' )
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
				"type" => "textfield",
				"heading" => __( "Number Of Products", "wpbingo" ),
				"param_name" => "numberposts",
				"value" => 8,
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
				"heading" => __( "Show Navigation", "wpbingo" ),
				"param_name" => "show_nav",
				"value" => array('No' => 'false','Yes' => 'true'),
				"description" => __( "Show Navigation", "wpbingo" ),
				'dependency' => array(
					'element' => 'layout',
					'value'	=> array("tab_category_slider","tab_product_slider"),
				),				
			),
			array(
				"type" => "dropdown",
				"heading" => __( "Order Product", "wpbingo" ),
				"param_name" => "select_order",
				"value" => array('Latest' => 'date', 'Top Rating' => 'rating', 'Best Selling' => 'popularity', 'Featured' => 'featured'),
				"description" => __( "Select Order Product", "wpbingo" ),
				'dependency' => array(
					'element' => 'layout',
					'value'	=> array("tab_category_default","tab_category_slider")
				)
			),
			array(
				"type" => "checkbox",
				"heading" => __( "Category", "wpbingo" ),
				"param_name" => "category",
				"value" => $term,
				"description" => __( "Select Categories", "wpbingo" ),
				'dependency' => array(
					'element' => 'layout',
					'value'	=> array("default","loadmore","tab_category_default","tab_category_slider")
				)				
			),
			array(
				"type" => "dropdown",
				"heading" => __( "Category", "wpbingo" ),
				"param_name" => "select_category",
				"value" => $term,
				"description" => __( "Select Categories", "wpbingo" ),
				'dependency' => array(
					'element' => 'layout',
					'value'	=> array("tab_product_default","tab_product_slider")
				)	
			),
			array(
				"type" => "checkbox",
				"heading" => __( "Order Product", "wpbingo" ),
				"param_name" => "checkbox_order",
				"value" => array('Latest' => 'date', 'Top Rating' => 'rating', 'Best Selling' => 'popularity', 'Featured' => 'featured'),
				"description" => __( "Select Order Product", "wpbingo" ),
				'dependency' => array(
					'element' => 'layout',
					'value'	=> array("tab_product_default","tab_product_slider","loadmore")
				)				
			),
			array(
				"type" => "dropdown",
				"heading" => __( "Number row per column", "wpbingo" ),
				"param_name" => "item_row",
				"value" =>array(1,2,3),
				"description" => __( "Number row per column", "wpbingo" ),
				'dependency' => array(
					'element' => 'layout',
					'value'	=> array("tab_category_slider")
				)				
			),
			array(
				"type" => "dropdown",
				"heading" => __( "Template", "wpbingo" ),
				"param_name" => "layout",
				"value" => array( 	'Filter Homepage' => 'default',
									'Load More' => 'loadmore',
									'Tab Category' => 'tab_category_default',
									'Tab Category Slider' => 'tab_category_slider',
									'Tab Product' => 'tab_product_default',
									'Tab Product Slider' => 'tab_product_slider'
								),
				"description" => __( "Layout", "wpbingo" )
			)		
		  )
	   ) );

	    if (!class_exists('WPBakeryShortCode_Bwp_Filter_Homepage')) {
			class WPBakeryShortCode_Bwp_Filter_Homepage extends WPBakeryShortCode {
			}
		}	 	   
	   
	}
	/**
		** Add Shortcode
	**/
	function bwp_filter_homepage_shortcode( $atts, $content = null ){
		extract( shortcode_atts(
			array(
				'title1' => '',	
				'description' => '',
				'class' => '',
				'category' => '',
				'select_category' => 'all',	
				'numberposts' => 8,
				'columns' => 4,
				'columns1' => 4,
				'columns2' => 3,
				'columns3' => 2,
				'columns4' => 1,
				'show_nav'	=> 'false',
				'select_order' => 'date',
				'checkbox_order' => '',
				'item_row'	=> 1,
				'layout'  => 'default',
			), $atts )
		);
		ob_start();	
		
		if( $layout == 'default' ){
			include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-filter-homepage/default.php' );
		}elseif( $layout == 'loadmore' ){
			include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-filter-homepage/loadmore.php' );
		}elseif( $layout == 'tab_category_default' ){
			include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-filter-homepage/tab-category/default.php' );
		}elseif( $layout == 'tab_category_slider' ){
			include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-filter-homepage/tab-category/slider.php' );
		}elseif( $layout == 'tab_product_default' ){
			include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-filter-homepage/tab-product/default.php' );
		}elseif( $layout == 'tab_product_slider' ){
			include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-filter-homepage/tab-product/slider.php' );
		}
		
		$content = ob_get_clean();
		
		return $content;
	}
	
	function woocommerce_filter_homepage_price($default_min_price,$default_max_price){	 
		$currency_symbol = get_woocommerce_currency_symbol();
		echo '
		<div class="bwp-filter-price">
		    <h6>'.esc_html__('Choose Price').'</h6>
			<div class="bwp_slider_price" data-min="'.$default_min_price.'" data-max="'.$default_max_price.'"></div>
			<div class="price-input">
				<span>'.esc_html__('Range : ').'</span>
				'.$currency_symbol.'<span class="text-price-filter text-price-filter-min-text">'.$default_min_price.'</span> -
				'.$currency_symbol.'<span class="text-price-filter text-price-filter-max-text">'.$default_max_price.'</span>	
				<input class="price-filter-min-text hidden"  type="text" value="'.$default_min_price.'">
				<input class="price-filter-max-text hidden"  type="text" value="'.$default_max_price.'">
			</div>
		</div>';
	}	
	function woocommerce_filter_homepage_atribute(){
		$attribute_taxonomies = wc_get_attribute_taxonomies();	
		foreach( $attribute_taxonomies as $att ){
			$taxonomy   = 	wc_attribute_taxonomy_name( $att->attribute_name );
			$orderby 	=	$att->attribute_orderby;
			if($orderby ){
				switch ( $orderby ) {
					case 'name' :
						$get_terms_args['orderby']    = 'name';
						$get_terms_args['menu_order'] = false;
					break;
					case 'id' :
						$get_terms_args['orderby']    = 'id';
						$get_terms_args['order']      = 'ASC';
						$get_terms_args['menu_order'] = false;
					break;
					case 'menu_order' :
						$get_terms_args['menu_order'] = 'ASC';
					break;
				}
			}else{
				$get_terms_args    = array();
			}
			$tax_query = array();
			$get_terms_args['tax_query'] = $tax_query;
			$terms = get_terms( $taxonomy, $get_terms_args );
			if(count($terms)>0):?>
			<div class="bwp-filter-<?php echo esc_attr($att->attribute_name);?>">
				<h6><?php echo esc_html__('Choose ','wpbingo'); ?><?php echo ucfirst( $att->attribute_name ); ?></h6>
				<?php 								
					if(isset($att->attribute_type) && $att->attribute_type == "color"){?>	
						<ul class="<?php echo esc_attr( 'pa_'.$att->attribute_name ); ?>">
							<?php			
								foreach( $terms as $term ){
										$color = get_term_meta( $term->term_id, 'color', true ); 
										echo '<li data-value="'. esc_attr( $term -> slug ) .'">';
												echo '<span class="color" style="background-color:'.esc_attr($color).';"></span>';
												echo '<span>'. esc_html( $term->name ) .'</span>';
										echo '</li> ';
								} ?>
						</ul>						
					<?php }else{?>
						<ul class="<?php echo esc_attr( 'pa_'.$att->attribute_name ); ?>">
							<?php			
								foreach( $terms as $term ){
										echo '<li data-value="'. esc_attr( $term -> slug ) .'">';
												echo '<span>'. esc_html( $term->name ) .'</span>';
										echo '</li> ';
								} ?>
						</ul>
				<?php } ?>
			</div>
			<?php endif;
		}		
	}
	
	function get_filtered_homepage_price($meta_query,$tax_query) {
		global $wpdb, $wp_the_query;
		
		$meta_query = new WP_Meta_Query( $meta_query );
		$tax_query  = new WP_Tax_Query( $tax_query );

		$meta_query_sql = $meta_query->get_sql( 'post', $wpdb->posts, 'ID' );
		$tax_query_sql  = $tax_query->get_sql( $wpdb->posts, 'ID' );

		$sql  = "SELECT min( CAST( price_meta.meta_value AS UNSIGNED ) ) as min_price, max( CAST( price_meta.meta_value AS UNSIGNED ) ) as max_price FROM {$wpdb->posts} ";
		$sql .= " LEFT JOIN {$wpdb->postmeta} as price_meta ON {$wpdb->posts}.ID = price_meta.post_id " . $tax_query_sql['join'] . $meta_query_sql['join'];
		$sql .= " 	WHERE {$wpdb->posts}.post_type = 'product'
					AND {$wpdb->posts}.post_status = 'publish'
					AND price_meta.meta_key IN ('" . implode( "','", array_map( 'esc_sql', apply_filters( 'woocommerce_price_filter_meta_keys', array( '_price' ) ) ) ) . "')
					AND price_meta.meta_value > '' ";
		$sql .= $tax_query_sql['where'] . $meta_query_sql['where'];

		return $wpdb->get_row( $sql );
	}
	
	function woocommerce_filter_homepage_brand(){
		$terms = get_terms( 'product_brand', array( 'parent' => '', 'hide_empty' => 0 ) );
		if( count( $terms ) > 0 ){ ?>
			<div class="bwp-filter-brand">
				<h6><?php echo  esc_html__( 'Choose Brands', 'wpbingo' ); ?></h6>
				<ul class="filter-brand">
				<?php foreach( $terms as $term ){
					echo '<li data-value="'. esc_attr( $term -> slug ) .'">';
							echo '<span>'. esc_html( $term->name ) .'</span>';
					echo '</li> ';				
				} ?>
				</ul>
			</div>
		<?php }
	}
	
?>