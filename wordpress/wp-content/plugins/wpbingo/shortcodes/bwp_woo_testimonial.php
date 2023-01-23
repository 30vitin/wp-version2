<?php
class bwp_widget_testimonial extends WP_Widget {
	public function __construct() {
		$widget_ops = array(
			'classname' => 'bwp_widget_testimonial',
			'description' => __( 'Wpbingo Add Testimonial.', "wpbingo" ),
			'customize_selective_refresh' => true,
		);
		
		$control_ops = array( 'width' => 400, 'height' => 350 );
		parent::__construct( 'bwp_widget_testimonial', __( 'Wpbingo Testimonial', "wpbingo" ), $widget_ops, $control_ops );
		
		add_shortcode( 'bwp_woo_testimonial', array( $this, 'bwp_woo_testimonial_shortcode' ) );
		
		/* Create Vc_map */
		if ( class_exists('Vc_Manager') && class_exists( 'WooCommerce' ) ) {
			add_action( 'vc_before_init', array( $this, 'bwp_woo_testimonial_shortcode_load' ) );
		}	
	}
	/**
		* Add Vc Params
	**/
	function bwp_woo_testimonial_shortcode_load(){
		
		vc_map( array(
			"name" => __( "Wpbingo Testimonial", "wpbingo" ),
			"base" => "bwp_woo_testimonial",
			"category" => __( "Wpbingo Shortcode", "wpbingo"),
			"params" => array(
			array(
				"type" => "textfield",
				"heading" => __( "Title", "wpbingo" ),
				"param_name" => "title1",
				"value" => 'Wpbingo Testimonial Widget',
				"description" => __( "Title", "wpbingo" )
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
					"heading" => __( "Show Pagination", "wpbingo" ),
					"param_name" => "show_pag",
					"value" => array( 'Yes' => 'true','No' => 'false'),
					"description" => __( "Show Pagination", "wpbingo" )
				),
			 array(
					"type" => "textfield",
					"heading" => __( "Length Excerpt", "wpbingo" ),
					"param_name" => "length",
					"value" => 25,
					"description" => __( "Length Excerpt(Only Use For Layout Slider 1)", "wpbingo" ),
				),	
			array(
				"type" => "dropdown",
				"heading" => __( "Layout", "wpbingo" ),
				"param_name" => "layout",
				"value" => array( 'Layout Default' => 'default' , 'Slider' => 'slider' , 'Slider 1' => 'slider1'),
				"description" => __( "Select Layout", "wpbingo" )
			 ),
		  )
	   ) );
	}
	/**
		** Add Shortcode
	**/
	function bwp_woo_testimonial_shortcode( $atts, $content = null ){
		extract( shortcode_atts(
			array(
				'title1' => '',
				'columns' => 3,
				'columns1' => 3,
				'columns2' => 3,
				'columns3' => 1,
				'columns4' => 1,
				'length'	=> 25,	
				'show_pag'  => 'true',
				'layout'  => 'default',
			), $atts )
		);
		ob_start();	
		if( $layout == 'default' ){
			include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-woo-testimonial/default.php' );
		}elseif( $layout == 'slider' ){
			include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-woo-testimonial/slider.php' );
		}elseif( $layout == 'slider1' ){
			include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-woo-testimonial/slider1.php' );
		}

		$content = ob_get_clean();
		
		return $content;
	}
	
	public function widget( $args, $instance ) {
		$title1 = 	apply_filters( 'widget_title', empty( $instance['title1'] ) ? '' : $instance['title1'], $instance, $this->id_base );
		$show_pag	= 	( $instance['show_pag'] ) ? $instance['show_pag'] : 1;
		$columns	= 	( $instance['columns'] ) ? $instance['columns'] : 1;
		$columns1	= 	( $instance['columns1'] ) ? $instance['columns1'] : 1;
		$columns2	= 	( $instance['columns2'] ) ? $instance['columns2'] : 1;
		$columns3	= 	( $instance['columns3'] ) ? $instance['columns3'] : 1;
		$columns4	= 	( $instance['columns4'] ) ? $instance['columns4'] : 1;		
		$layout		= 	( $instance['layout'] ) ? $instance['layout'] : 'default';
		echo $args['before_widget'];
		if( $layout == 'default' ){
			include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-woo-testimonial/default.php' );
		}elseif( $layout == 'slider' ){
			include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-woo-testimonial/slider.php' );
		}elseif( $layout == 'slider1' ){
			include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-woo-testimonial/slider1.php' );
		}
		
		
		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title1'] = sanitize_text_field( $new_instance['title1'] );		
		$instance['layout'] = sanitize_text_field( $new_instance['layout'] );
		$instance['show_pag'] = $new_instance['show_pag'];
		$instance['columns'] = intval($new_instance['columns']);
		$instance['columns1'] = intval($new_instance['columns1']);
		$instance['columns2'] = intval($new_instance['columns2']);
		$instance['columns3'] = intval($new_instance['columns3']);
		$instance['columns4'] = intval($new_instance['columns4']);
		return $instance;
	}

	public function form( $instance ) {
		$instance = wp_parse_args( 
							$instance, 
							array( 
								'title1' => '',
								'class' => '',
								'show_nav' => 'true',
								'show_pag' => 'true',
								'item_row' => 1,
								'columns' => 1,
								'columns1' => 1,
								'columns2' => 1,
								'columns3' => 1,
								'columns4' => 1,								
								'layout' => 'default',
							)
					);
		$title1 = sanitize_text_field( $instance['title1'] );
		$show_pag   	= isset( $instance['show_pag'] ) ? strip_tags($instance['show_pag']) : 'true';
		$columns   		= isset( $instance['columns'] ) ? intval($instance['columns']) : 1;
		$columns1   	= isset( $instance['columns1'] ) ? intval($instance['columns1']) : 1;
		$columns2   	= isset( $instance['columns2'] ) ? intval($instance['columns2']) : 1;
		$columns3   	= isset( $instance['columns3'] ) ? intval($instance['columns3']) : 1;
		$columns4   	= isset( $instance['columns4'] ) ? intval($instance['columns4']) : 1;
		$layout   		= isset( $instance['layout'] ) ? strip_tags($instance['layout']) : 'default';
        ?>
		<p>
			<label for="<?php echo $this->get_field_id('title1'); ?>"><?php echo _e('Title:', "wpbingo"); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title1'); ?>" name="<?php echo $this->get_field_name('title1'); ?>" type="text" value="<?php echo esc_attr($title1); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('show_pag'); ?>"><?php echo _e("Show Pagination", "wpbingo" );?></label>
			<br/>
			<select class="widefat"
				id="<?php echo $this->get_field_id('show_pag'); ?>"	name="<?php echo $this->get_field_name('show_pag'); ?>">
				<option value="true" <?php if ($show_pag=='true'){?> selected="selected" <?php } ?>>
					<?php echo _e('True', "wpbingo");?>	
				</option>
				<option value="false" <?php if ($show_pag=='false'){?> selected="selected" <?php } ?>>
					<?php echo _e('False', "wpbingo");?>	
				</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('columns'); ?>"><?php echo _e("Number of Columns >1200px:", "wpbingo" );?></label>
			<br/>
			<select class="widefat"
				id="<?php echo $this->get_field_id('columns'); ?>"	name="<?php echo $this->get_field_name('columns'); ?>">
				<option value="1" <?php if ($columns==1){?> selected="selected" <?php } ?>>1</option>
				<option value="2" <?php if ($columns==2){?> selected="selected" <?php } ?>>2</option>
				<option value="3" <?php if ($columns==3){?> selected="selected" <?php } ?>>3</option>
				<option value="4" <?php if ($columns==4){?> selected="selected" <?php } ?>>4</option>
				<option value="5" <?php if ($columns==5){?> selected="selected" <?php } ?>>5</option>
				<option value="6" <?php if ($columns==6){?> selected="selected" <?php } ?>>6</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('columns1'); ?>"><?php echo _e("Number of Columns on 992px to 1199px:", "wpbingo" );?></label>
			<br/>
			<select class="widefat"
				id="<?php echo $this->get_field_id('columns1'); ?>"	name="<?php echo $this->get_field_name('columns1'); ?>">
				<option value="1" <?php if ($columns1==1){?> selected="selected" <?php } ?>>1</option>
				<option value="2" <?php if ($columns1==2){?> selected="selected" <?php } ?>>2</option>
				<option value="3" <?php if ($columns1==3){?> selected="selected" <?php } ?>>3</option>
				<option value="4" <?php if ($columns1==4){?> selected="selected" <?php } ?>>4</option>
				<option value="5" <?php if ($columns1==5){?> selected="selected" <?php } ?>>5</option>
				<option value="6" <?php if ($columns1==6){?> selected="selected" <?php } ?>>6</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('columns2'); ?>"><?php echo _e("Number of Columns on 768px to 991px:", "wpbingo" );?></label>
			<br/>
			<select class="widefat"
				id="<?php echo $this->get_field_id('columns2'); ?>"	name="<?php echo $this->get_field_name('columns2'); ?>">
				<option value="1" <?php if ($columns2==1){?> selected="selected" <?php } ?>>1</option>
				<option value="2" <?php if ($columns2==2){?> selected="selected" <?php } ?>>2</option>
				<option value="3" <?php if ($columns2==3){?> selected="selected" <?php } ?>>3</option>
				<option value="4" <?php if ($columns2==4){?> selected="selected" <?php } ?>>4</option>
				<option value="5" <?php if ($columns2==5){?> selected="selected" <?php } ?>>5</option>
				<option value="6" <?php if ($columns2==6){?> selected="selected" <?php } ?>>6</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('columns3'); ?>"><?php echo _e("Number of Columns on 480px to 767px:", "wpbingo" );?></label>
			<br/>
			<select class="widefat"
				id="<?php echo $this->get_field_id('columns3'); ?>"	name="<?php echo $this->get_field_name('columns3'); ?>">
				<option value="1" <?php if ($columns3==1){?> selected="selected" <?php } ?>>1</option>
				<option value="2" <?php if ($columns3==2){?> selected="selected" <?php } ?>>2</option>
				<option value="3" <?php if ($columns3==3){?> selected="selected" <?php } ?>>3</option>
				<option value="4" <?php if ($columns3==4){?> selected="selected" <?php } ?>>4</option>
				<option value="5" <?php if ($columns3==5){?> selected="selected" <?php } ?>>5</option>
				<option value="6" <?php if ($columns3==6){?> selected="selected" <?php } ?>>6</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('columns4'); ?>"><?php echo _e("Number of Columns in 480px or less than:", "wpbingo" );?></label>
			<br/>
			<select class="widefat"
				id="<?php echo $this->get_field_id('columns4'); ?>"	name="<?php echo $this->get_field_name('columns4'); ?>">
				<option value="1" <?php if ($columns4==1){?> selected="selected" <?php } ?>>1</option>
				<option value="2" <?php if ($columns4==2){?> selected="selected" <?php } ?>>2</option>
				<option value="3" <?php if ($columns4==3){?> selected="selected" <?php } ?>>3</option>
				<option value="4" <?php if ($columns4==4){?> selected="selected" <?php } ?>>4</option>
				<option value="5" <?php if ($columns4==5){?> selected="selected" <?php } ?>>5</option>
				<option value="6" <?php if ($columns4==6){?> selected="selected" <?php } ?>>6</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('layout'); ?>"><?php echo _e("Template", "wpbingo" );?></label>
			<br/>
			<select class="widefat"
				id="<?php echo $this->get_field_id('layout'); ?>"	name="<?php echo $this->get_field_name('layout'); ?>">
				<option value="default" <?php if ($layout=='default'){?> selected="selected" <?php } ?>>
					<?php echo _e('Default', "wpbingo")?>		
				</option>
				<option value="slider" <?php if ($layout=='slider'){?> selected="selected" <?php } ?>>
					<?php echo _e('Slider', "wpbingo")?>	
				</option>
				<option value="slider1" <?php if ($layout=='slider1'){?> selected="selected" <?php } ?>>
					<?php echo _e('Slider 1', "wpbingo")?>
				</option>				
			</select>
		</p>
		<?php
	}
}	
?>