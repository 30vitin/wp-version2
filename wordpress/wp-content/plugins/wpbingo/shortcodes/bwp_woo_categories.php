<?php
class bwp_widget_woo_categories extends WP_Widget {
	
	public function __construct() {
		$widget_ops = array(
			'classname' => 'bwp_widget_woo_categories',
			'description' => __( 'Wpbingo Add Categories Woocommerce.', "wpbingo" ),
			'customize_selective_refresh' => true,
		);
		$control_ops = array( 'width' => 400, 'height' => 350 );
		parent::__construct( 'bwp_widget_woo_categories', __( 'Wpbingo Woo Categories', "wpbingo" ), $widget_ops, $control_ops );
		
		add_shortcode( 'bwp_woo_categories', array( $this, 'bwp_woo_categories_shortcode' ));
		/* Create Vc_map */
		if ( class_exists('Vc_Manager') && class_exists( 'WooCommerce' ) ) {
			add_action( 'vc_before_init', array( $this, 'bwp_woo_categories_shortcode_load'));
		}		
	}
	
	/**
	* Add Vc Params
	**/
	
	function bwp_woo_categories_shortcode_load(){
		$terms = get_terms( 'product_cat', array( 'hide_empty' => false ) );
		if( count( $terms ) == 0 ){
			return ;
		}
		foreach( $terms as $cat ){
			$term[$cat->name] = $cat -> slug;
		}
		vc_map( 
			array(
				"name" => __( "Wpbingo Woo Categories", "wpbingo" ),
				"base" => "bwp_woo_categories",
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
						"heading" => __( "Subtitle", "wpbingo" ),
						"param_name" => "subtitle",
						"value" => '',
						"description" => __( "Subtitle", "wpbingo" )
					),	
					array(
						"type" => "checkbox",
						"heading" => __( "Categories", "wpbingo" ),
						"param_name" => "category",
						"value" => $term,
						"description" => __( "Select Categories", "wpbingo" )
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
						"heading" => __( "Show Name Categories", "wpbingo" ),
						"param_name" => "show_name",
						"value" => array( 'True' => 1, 'False' => 0 ),
						"description" => __( "Show Name Categories", "wpbingo" )
					),	
					array(
						"type" => "dropdown",
						"heading" => __( "Show Count Product Categories", "wpbingo" ),
						"param_name" => "show_count",
						"value" => array( 'True' => 1, 'False' => 0 ),
						"description" => __( "Show Count Product Categories", "wpbingo" )
					),	
					array(
						"type" => "dropdown",
						"heading" => __( "Show Image Categories", "wpbingo" ),
						"param_name" => "show_thumbnail",
						"value" => array( 'True' => 1, 'False' => 0 ),
						"description" => __( "Show Image Categories", "wpbingo" )
					),		
					array(
						"type" => "dropdown",
						"heading" => __( "Show Thumbnail Categories", "wpbingo" ),
						"param_name" => "show_thumbnail1",
						"value" => array( 'True' => 1, 'False' => 0 ),
						"description" => __( "Show Thumbnail  Categories", "wpbingo" )
					),
					array(
						"type" => "dropdown",
						"heading" => __( "Show Icon Categories", "wpbingo" ),
						"param_name" => "show_icon",
						"value" => array( 'True' => 1, 'False' => 0 ),
						"description" => __( "Show Icon  Categories", "wpbingo" )
					),			 
					array(
						"type" => "dropdown",
						"heading" => __( "Show Navigation", "wpbingo" ),
						"param_name" => "show_nav",
						"value" => array('No' => 'false','Yes' => 'true'),
						"description" => __( "Show Navigation", "wpbingo" ),
						'dependency' => array(
							'element' => 'layout',
							'value'	=> array("slider","slider_2"),
						)				
					),
					array(
						"type" => "attach_image",
						"class" => "",
						"heading" => __( "Image", "wpbingo"),
						"param_name" => "image",
						"value" => "",
						"description" => __( "Select image from media library","wpbingo"),
						'dependency' => array(
							'element' => 'layout',
							'value'	=> array("default2"),
						)
					),
					array(
						"type" => "dropdown",
						"heading" => __( "Layout", "wpbingo" ),
						"param_name" => "layout",
						"value" => array( 
											'Layout Default' => 'default',
											'Layout Default 2' => 'default2',
											'Layout Default 3' => 'default3',
											'Slider' => 'slider',
											'Slider 2' => 'slider_2',
											'Slider 3' => 'slider_3',
											'Slider 4' => 'slider_4'
										),
						"description" => __( "Layout", "wpbingo" )
					)			 
				)
			)
		);
	}
		/**
			** Add Shortcode
		**/
	function bwp_woo_categories_shortcode( $atts, $content = null ){
		extract( shortcode_atts(
			array(
				'title1' => '',	
				'subtitle' => '',				
				'orderby' => '',
				'category' => '',
				'item_row' => 1,
				'numberposts' => 5,
				'columns' => 4,
				'columns1' => 4,
				'columns2' => 3,
				'columns3' => 2,
				'columns4' => 1,
				'show_name' => 1,
				'show_count' => 1,
				'show_thumbnail' => 1,
				'show_thumbnail1' => 1,
				'show_icon' => 0,
				'show_nav'	=> 'false',
				'image' => '',
				'layout'  => 'default',
			), $atts )
		);
		if($image){
			$image = wp_get_attachment_image_src( $image,'full');
			$image = $image[0];		
		}
		ob_start();	
		
		if( $layout == 'default' ){
			include( WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-woo-categories/default.php' );	
		}elseif( $layout == 'default2' ){
			include( WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-woo-categories/default2.php' );
		}elseif( $layout == 'default3' ){
			include( WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-woo-categories/default3.php' );
		}elseif( $layout == 'slider' ){
			include( WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-woo-categories/slider.php' );
		}elseif( $layout == 'slider_2' ){
			include( WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-woo-categories/slider_2.php' );
		}elseif( $layout == 'slider_3' ){
			include( WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-woo-categories/slider_3.php' );
		}elseif( $layout == 'slider_4' ){
			include( WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-woo-categories/slider_4.php' );
		}
		$content = ob_get_clean();
		
		return $content;
	}
	
	public function widget( $args, $instance ) {
		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title1 = apply_filters( 'widget_title', empty( $instance['title1'] ) ? '' : $instance['title1'], $instance, $this->id_base );
		$layout		 = 	( $instance['layout'] ) ? $instance['layout'] : 'default';
		$category		 = 	( isset($instance['category']) &&  $instance['category']) ? $instance['category'] : array();
		
		echo $args['before_widget'];
		include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-woo-categories/default.php' );
		
		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title1'] = sanitize_text_field( $new_instance['title1'] );
		$instance['layout'] = sanitize_text_field( $new_instance['layout'] );
		if ( array_key_exists('category', $new_instance) ){
			if ( is_array($new_instance['category']) ){
				$instance['category'] = $new_instance['category'];
			} else {
				$instance['category'] =	array("all");
			}
		} else {
				$instance['category'] =	array("all");
		}
		
		return $instance;
	}

	/**
	 * Outputs the Text widget settings form.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$instance = wp_parse_args( 
							$instance, 
							array( 'title1' => '','layout' => 'default') 
					);
		$terms =	get_terms( 'product_cat', array( 'hide_empty' => false));			
		$categories 			= isset( $instance['category']  ) 		? $instance['category'] : array();		
		$title1 = sanitize_text_field( $instance['title1'] );
		$layout   	= isset( $instance['layout'] ) ? strip_tags($instance['layout']) : 'default';
        ?>
		<p><label for="<?php echo $this->get_field_id('title1'); ?>"><?php _e('Title:', "wpbingo"); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title1'); ?>" name="<?php echo $this->get_field_name('title1'); ?>" type="text" value="<?php echo esc_attr($title1); ?>" />
		</p>
		<?php if($terms) : ?>
		<p>
			<label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category', 'wpbingo')?></label>
			<br />
			<select multiple class="widefat" 
				id="<?php echo $this->get_field_id('category'); ?>"	name="<?php echo $this->get_field_name('category').'[]'; ?>">
				<?php foreach($terms as $term){ ?>
				<option value="<?php echo esc_attr($term->slug); ?>" <?php if (in_array($term->slug, $categories)){?> selected="selected" <?php } ?>>
					<?php echo esc_attr($term->name); ?>
				</option>
				<?php } ?>	
			</select>
		</p>
		<?php endif; ?>
		<p>
			<label for="<?php echo $this->get_field_id('layout'); ?>"><?php _e("Template", "wpbingo" )?></label>
			<br/>
			<select class="widefat"
				id="<?php echo $this->get_field_id('layout'); ?>"	name="<?php echo $this->get_field_name('layout'); ?>">
				<option value="default" <?php if ($layout=='default'){?> selected="selected" <?php } ?>>
					<?php _e('Default', "wpbingo")?>		
				</option>	
				<option value="default2" <?php if ($layout=='default2'){?> selected="selected" <?php } ?>>
					<?php _e('Default 2', "wpbingo")?>		
				</option>			
			</select>
		</p>
		<?php
	}	
}