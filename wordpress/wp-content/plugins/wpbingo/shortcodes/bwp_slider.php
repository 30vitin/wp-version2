<?php
/**
 * Wpbingo Add Slider Widget
 * Plugin URI: http://www.wpbingo.com
 * Version: 1.0
 * This Widget help you to show images of product as a beauty tab reponsive slideshow
 */
class bwp_widget_slider extends WP_Widget {
	
	public function __construct() {
		$widget_ops = array(
			'classname' => 'bwp_widget_slider',
			'description' => __( 'Wpbingo Add Slider.', "wpbingo" ),
			'customize_selective_refresh' => true,
		);
		
		$control_ops = array( 'width' => 400, 'height' => 350 );
		parent::__construct( 'bwp_widget_slider', __( 'Wpbingo Slider', "wpbingo" ), $widget_ops, $control_ops );
		
		add_shortcode( 'bwp_slider', array( $this, 'bwp_slider_shortcode' ) );
		
		/* Create Vc_map */
		if ( class_exists('Vc_Manager') && class_exists( 'WooCommerce' ) ) {
			add_action( 'vc_before_init', array( $this, 'bwp_slider_shortcode_load' ) );
		}	
	}

	/**
		* Add Vc Params
	**/
	function bwp_slider_shortcode_load(){
		$terms = array();
		$args = array(
			'post_type' => 'bwp_slider',
			'posts_per_page' => -1,
			'post_status' => 'publish'
		);
		$query = new WP_Query();
		$sliders =  $query->query($args);
		if($sliders){
			foreach($sliders as $slider)	
			$terms[$slider->post_title]	= $slider->post_name;
		}
		vc_map( array(
			"name" => __( "Wpbingo Slider", "wpbingo" ),
			"base" => "bwp_slider",
			"category" => __( "Wpbingo Shortcode", "wpbingo"),
			"params" => array(
				array(
					"type" => "textfield",
					"heading" => __( "Title", "wpbingo" ),
					"param_name" => "title1",
					"value" => 'Wpbingo Slider',
					"description" => __( "Title", "wpbingo" )
				),	
				array(
					"type" => "textfield",
					"heading" => __( "Extra Class", "wpbingo" ),
					"param_name" => "class",
					"value" => '',
					"description" => __( "Title", "wpbingo" )
				),					
				array(
					"type" => "checkbox",
					"heading" => __( "Slider", "wpbingo" ),
					"param_name" => "slider",
					"value" => $terms,
					"description" => __( "Choosen Slider", "wpbingo" )
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
					"type" => "dropdown",
					"heading" => __( "Layout", "wpbingo" ),
					"param_name" => "layout",
					"value" => array( 
						'Layout Default' => 'default',
						'Layout Default 2' => 'default2',
					),
					"description" => __( "Layout", "wpbingo" )
				 ),			 
			)
		));	   
	}
	/**
		** Add Shortcode
	**/
	function bwp_slider_shortcode( $atts, $content = null ){
		extract( shortcode_atts(
			array(
				'title1' 	=> '',
				'class' 	=> '',
				'slider'	=> '',
				'show_nav'  => 'true',
				'show_pag'  => 'true',
				'item_row'=> 1,
				'columns' => 4,
				'columns1' => 4,
				'columns2' => 3,
				'columns3' => 2,
				'columns4' => 1,				
				'layout'  	=> 'default',
			), $atts )
		);
		ob_start();	
		include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-slider/default.php' );
		$content = ob_get_clean();
		
		return $content;
	}
	
	public function widget( $args, $instance ) {
		$title1 = 	apply_filters( 'widget_title', empty( $instance['title1'] ) ? '' : $instance['title1'], $instance, $this->id_base );
		$class 	= 	( $instance['class'] ) ? $instance['class'] : '';
		$slider		= 	( $instance['slider'] ) ? implode(",", $instance['slider']) : '';
		$show_nav	= 	( $instance['show_nav'] ) ? $instance['show_nav'] : 1;
		$show_pag	= 	( $instance['show_pag'] ) ? $instance['show_pag'] : 1;
		$item_row	= 	( $instance['item_row'] ) ? $instance['item_row'] : 1;
		$columns	= 	( $instance['columns'] ) ? $instance['columns'] : 1;
		$columns1	= 	( $instance['columns1'] ) ? $instance['columns1'] : 1;
		$columns2	= 	( $instance['columns2'] ) ? $instance['columns2'] : 1;
		$columns3	= 	( $instance['columns3'] ) ? $instance['columns3'] : 1;
		$columns4	= 	( $instance['columns4'] ) ? $instance['columns4'] : 1;		
		$layout		= 	( $instance['layout'] ) ? $instance['layout'] : 'default';
		echo $args['before_widget'];
		if( $layout == 'default' )
			include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-slider/default.php' );
		
		echo $args['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title1'] = sanitize_text_field( $new_instance['title1'] );
		$instance['class'] = sanitize_text_field( $new_instance['class'] );
		if ( array_key_exists('slider', $new_instance) ){
			if ( is_array($new_instance['slider']) ){
				$instance['slider'] = array_map( 'strval', $new_instance['slider'] );
			} else {
				$instance['slider'] = $new_instance['slider'];
			}
		}else{
			$instance['slider'] = '';
		}		
		$instance['layout'] = sanitize_text_field( $new_instance['layout'] );
		$instance['show_nav'] = $new_instance['show_nav'];
		$instance['show_pag'] = $new_instance['show_pag'];
		$instance['item_row'] = intval($new_instance['item_row']);
		$instance['columns'] = intval($new_instance['columns']);
		$instance['columns1'] = intval($new_instance['columns1']);
		$instance['columns2'] = intval($new_instance['columns2']);
		$instance['columns3'] = intval($new_instance['columns3']);
		$instance['columns4'] = intval($new_instance['columns4']);
		return $instance;
	}

	public function form( $instance ) {
		$terms = array();
		$args = array(
			'post_type' => 'bwp_slider',
			'posts_per_page' => -1,
			'post_status' => 'publish'
		);
		$query = new WP_Query();
		$sliders =  $query->query($args);	
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
		$class = sanitize_text_field( $instance['class'] );
		$slider		= isset( $instance['slider'] )  && is_array($instance['slider']) ? $instance['slider'] : array();
		$show_nav   	= isset( $instance['show_nav'] ) ? strip_tags($instance['show_nav']) : 'true';
		$show_pag   	= isset( $instance['show_pag'] ) ? strip_tags($instance['show_pag']) : 'true';
		$item_row   	= isset( $instance['item_row'] ) ? intval($instance['item_row']) : 1;
		$columns   		= isset( $instance['columns'] ) ? intval($instance['columns']) : 1;
		$columns1   	= isset( $instance['columns1'] ) ? intval($instance['columns1']) : 1;
		$columns2   	= isset( $instance['columns2'] ) ? intval($instance['columns2']) : 1;
		$columns3   	= isset( $instance['columns3'] ) ? intval($instance['columns3']) : 1;
		$columns4   	= isset( $instance['columns4'] ) ? intval($instance['columns4']) : 1;
		$layout   	= isset( $instance['layout'] ) ? strip_tags($instance['layout']) : 'default';
        ?>
		<p>
			<label for="<?php echo $this->get_field_id('title1'); ?>"><?php echo _e('Title:', "wpbingo"); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title1'); ?>" name="<?php echo $this->get_field_name('title1'); ?>" type="text" value="<?php echo esc_attr($title1); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('class'); ?>"><?php echo _e('Class:', "wpbingo"); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('class'); ?>" name="<?php echo $this->get_field_name('class'); ?>" type="text" value="<?php echo esc_attr($class); ?>" />
		</p>
		<?php if($sliders > 0) : ?>
		<p>
			<label for="<?php echo $this->get_field_id('slider'); ?>"><?php echo _e('Slider', 'wpbingo')?></label>
			<br />
			<select class="widefat"	id="<?php echo $this->get_field_id('slider'); ?>" name="<?php echo $this->get_field_name('slider'); ?>[]" multiple="multiple">
				<?php
				$option ='';
				foreach ( $sliders as $value ) :
					$option .= '<option value="' . $value->post_name  . '" ';
					if ( is_array( $slider ) && in_array( $value->post_name, $slider ) ){
						$option .= 'selected="selected"';
					}
					$option .=  '>'.$value->post_title.'</option>';
				endforeach;
				echo $option;
				?>
			</select>
		</p>
		<?php endif;?>		
		<p>
			<label for="<?php echo $this->get_field_id('show_nav'); ?>"><?php echo _e("Show Navigation", "wpbingo" )?></label>
			<br/>
			<select class="widefat"
				id="<?php echo $this->get_field_id('show_nav'); ?>"	name="<?php echo $this->get_field_name('show_nav'); ?>">
				<option value="true" <?php if ($show_nav=='true'){?> selected="selected" <?php } ?>>
					<?php echo _e('True', "wpbingo");?>	
				</option>
				<option value="false" <?php if ($show_nav=='false'){?> selected="selected" <?php } ?>>
					<?php echo _e('False', "wpbingo");?>	
				</option>				
			</select>
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
			<label for="<?php echo $this->get_field_id('item_row'); ?>"><?php echo _e("Number row per column", "wpbingo" );?></label>
			<br/>
			<select class="widefat"
				id="<?php echo $this->get_field_id('item_row'); ?>"	name="<?php echo $this->get_field_name('item_row'); ?>">
				<option value="1" <?php if ($item_row==1){?> selected="selected" <?php } ?>>1</option>
				<option value="2" <?php if ($item_row==2){?> selected="selected" <?php } ?>>2</option>
				<option value="3" <?php if ($item_row==3){?> selected="selected" <?php } ?>>3</option>
				<option value="4" <?php if ($item_row==4){?> selected="selected" <?php } ?>>4</option>
				<option value="5" <?php if ($item_row==5){?> selected="selected" <?php } ?>>5</option>
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
			</select>
		</p>
		<?php
	}	
}