<?php
/**
 * Wpbingo Woo Tab Slider Widget
 * Plugin URI: http://www.wpbingo.com
 * Version: 1.0
 * This Widget help you to show images of product as a beauty tab reponsive slideshow
 */
if ( !class_exists('bwp_woo_recent_post_widget') ) {
	class bwp_woo_recent_post_widget extends WP_Widget {

		/**
		 * Widget setup.
		 */
		function __construct() {
			/* Widget settings. */
			$widget_ops = array( 'classname' => 'bwp_woo_recent_post_widget', 'description' => __('Wpbingo Recent Post Widget', "wpbingo" ) );

			/* Widget control settings. */
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'bwp_woo_recent_post_widget' );

			/* Create the widget. */
			parent::__construct( 'bwp_woo_recent_post_widget', __('Wpbingo Recent Post', "wpbingo" ), $widget_ops, $control_ops );
					
			add_shortcode( 'woo_recent_post_widget', array( $this, 'bwp_recent_post_widget' ) );
			
			/* Create Vc_map */
			if ( class_exists('Vc_Manager') && class_exists( 'WooCommerce' ) ) {
				add_action( 'vc_before_init', array( $this, 'bwp_recent_post_widget_load' ) );
			}
		}

		/**
			* Add Vc Params
		**/
		function bwp_recent_post_widget_load(){
			$categories = array( __( 'All Categories', 'wpbingo' ) => '' );
			$cats    = get_categories();
			if ( is_array( $cats ) ) {
				foreach ( $cats as $cat ) {
					$categories[ $cat->name ] = $cat->term_id;
				}
			}		
			
			vc_map( array(
				"name" => __( "Wpbingo Recent Post", "wpbingo" ),
				"base" => "woo_recent_post_widget",
				"category" => __( "Wpbingo Shortcode", "wpbingo"),
				"params" => array(
				array(
					"type" => "textfield",
					"heading" => __( "Title", "wpbingo" ),
					"param_name" => "title1",
					"value" => 'Wpbingo Recent Post Widget',
					"description" => __( "Title", "wpbingo" )
				),
				 array(
					'param_name'    => 'category',
					'type'          => 'dropdown',
					'value'         => $categories, 
					'heading'       => __('Categories', 'wpbingo')
				 ),				
				array(
					"type" => "textfield",
					"heading" => __( "Limit", "wpbingo" ),
					"param_name" => "limit",
					"value" => 8,
					"description" => __( "Limit", "wpbingo" )
				),
				array(
					"type" => "textfield",
					"heading" => __( "Length Excerpt", "wpbingo" ),
					"param_name" => "length",
					"value" => 25,
					"description" => __( "Length Excerpt", "wpbingo" )
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
					"heading" => __( "Layout", "wpbingo" ),
					"param_name" => "layout",
					"value" => array( 'Default' => 'default',
									  'Slider' => 'slider',
									  'Slider Layout 2' => 'slider2',
									  'Slider Layout 3' => 'slider3',
									  'Slider Layout 4' => 'slider4',
									  'Slider Layout 5' => 'slider5',
									  'Slider Layout 6' => 'slider6',
									  'Slider Layout 7' => 'slider7',
									  'Slider Layout 8' => 'slider8',
									  'Slider Layout 9' => 'slider9',
									  'Sidebar' => 'sidebar'),
					"description" => __( "Layout", "wpbingo" )
				 ),
			  )
		   ) );
		}
		/**
			** Add Shortcode
		**/
		function bwp_recent_post_widget( $atts, $content = null ){
			extract( shortcode_atts(
				array(
					'title1'   => '',
					'category' => '',
					'limit'	   => 8,
					'length'	=> 25,	
					'item_row' => 1,	
					'columns'  => 3,
					'columns1' => 3,
					'columns2' => 3,
					'columns3' => 1,
					'columns4' => 1,
					'show_nav'  => 'true',
					'show_pag'  => 'true',					
					'layout'   => 'default',
				), $atts )
			);
			ob_start();	
			if( $layout == 'default' ) {
				include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-woo-recent-post-widget/default.php' );
			}
			elseif( $layout == 'slider') {
				include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-woo-recent-post-widget/slider.php' );
			}
			elseif( $layout == 'slider2') {
				include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-woo-recent-post-widget/slider2.php' );
			}
			elseif( $layout == 'slider3') {
				include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-woo-recent-post-widget/slider3.php' );
			}
			elseif( $layout == 'slider4') {
				include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-woo-recent-post-widget/slider4.php' );
			}
			elseif( $layout == 'slider5') {
				include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-woo-recent-post-widget/slider5.php' );
			}
			elseif( $layout == 'slider6') {
				include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-woo-recent-post-widget/slider6.php' );
			}
			elseif( $layout == 'slider7') {
				include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-woo-recent-post-widget/slider7.php' );
			}
			elseif( $layout == 'slider8') {
				include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-woo-recent-post-widget/slider8.php' );
			}
			elseif( $layout == 'slider9') {
				include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-woo-recent-post-widget/slider9.php' );
			}
			elseif( $layout == 'sidebar') {
				include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-woo-recent-post-widget/sidebar.php' );
			}			
			
			$content = ob_get_clean();
			
			return $content;
		}
		
		public function widget( $args, $instance ) {
			/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
			extract($args);
			echo $before_widget;
			$title1 = apply_filters( 'widget_title', empty( $instance['title1'] ) ? '' : $instance['title1'], $instance, $this->id_base );
			$limit		 = 	( $instance['limit'] ) ? $instance['limit'] : 5;
			$category		 = 	( $instance['category'] ) ? $instance['category'] : '';
			$item_row	 = 	( $instance['item_row'] ) ? $instance['item_row'] : 1;
			$length		 = 	( $instance['length'] ) ? $instance['length'] : 25;
			$columns		 = 	( $instance['columns'] ) ? $instance['columns'] : 1;
			$columns1		 = 	( $instance['columns1'] ) ? $instance['columns1'] : 1;
			$columns2		 = 	( $instance['columns2'] ) ? $instance['columns2'] : 1;
			$columns3		 = 	( $instance['columns3'] ) ? $instance['columns3'] : 1;
			$columns4		 = 	( $instance['columns4'] ) ? $instance['columns4'] : 1;
			$layout		 = 	( $instance['layout'] ) ? $instance['layout'] : 'default';
			
			if( $instance['layout'] == 'default' ){
				include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-woo-recent-post-widget/default.php' );
			}
			elseif($instance['layout'] == 'default2'){
				include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-woo-recent-post-widget/default2.php' );	
			}	
			elseif($instance['layout'] == 'sidebar'){
				include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-woo-recent-post-widget/sidebar.php' );	
			}			
			elseif($instance['layout'] == 'slider'){
				include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-woo-recent-post-widget/slider.php' );	
			}
			
			echo $after_widget;
		}		
		
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;

			// strip tag on text field
			$instance['title1'] = strip_tags( $new_instance['title1'] );
			if ( array_key_exists('category', $new_instance) ){
				if ( is_array($new_instance['category']) ){
					$instance['category'] = array_map( 'intval', $new_instance['category'] );
				} else {
					$instance['category'] = intval($new_instance['category']);
				}
			}
			if ( array_key_exists('limit', $new_instance) ){
				$instance['limit'] = intval( $new_instance['limit'] );
			}	
			if ( array_key_exists('item_row', $new_instance) ){
				$instance['item_row'] = intval( $new_instance['item_row'] );
			}				
			if ( array_key_exists('length', $new_instance) ){
				$instance['length'] = intval( $new_instance['length'] );
			}
			if ( array_key_exists('columns', $new_instance) ){
				$instance['columns'] = intval( $new_instance['columns'] );
			}
			if ( array_key_exists('columns1', $new_instance) ){
				$instance['columns1'] = intval( $new_instance['columns1'] );
			}
			if ( array_key_exists('columns2', $new_instance) ){
				$instance['columns2'] = intval( $new_instance['columns2'] );
			}
			if ( array_key_exists('columns3', $new_instance) ){
				$instance['columns3'] = intval( $new_instance['columns3'] );
			}
			if ( array_key_exists('columns4', $new_instance) ){
				$instance['columns4'] = intval( $new_instance['columns4'] );
			}
			
			$instance['layout'] = strip_tags( $new_instance['layout'] );
			
						
			
			return $instance;
		}	

	public function bwp_trim_words( $text, $num_words = 30, $more = null ) {
		$text = strip_shortcodes( $text);
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]&gt;', $text);
		return wp_trim_words($text, $num_words, $more);
	}	
		
	function category_select( $field_name, $opts = array(), $field_value = null ){
		$default_options = array(
				'multiple' => false,
				'disabled' => false,
				'size' => 5,
				'class' => 'widefat',
				'required' => false,
				'autofocus' => false,
				'form' => false,
		);
		$opts = wp_parse_args($opts, $default_options);
	
		if ( (is_string($opts['multiple']) && strtolower($opts['multiple'])=='multiple') || (is_bool($opts['multiple']) && $opts['multiple']) ){
			$opts['multiple'] = 'multiple';
			if ( !is_numeric($opts['size']) ){
				if ( intval($opts['size']) ){
					$opts['size'] = intval($opts['size']);
				} else {
					$opts['size'] = 5;
				}
			}
		} else {
			// is not multiple
			unset($opts['multiple']);
			unset($opts['size']);
			if (is_array($field_value)){
				$field_value = array_shift($field_value);
			}
			if (array_key_exists('allow_select_all', $opts) && $opts['allow_select_all']){
				unset($opts['allow_select_all']);
				$allow_select_all = '<option value="0">All Categories</option>';
			}
		}
	
		if ( (is_string($opts['disabled']) && strtolower($opts['disabled'])=='disabled') || is_bool($opts['disabled']) && $opts['disabled'] ){
			$opts['disabled'] = 'disabled';
		} else {
			unset($opts['disabled']);
		}
	
		if ( (is_string($opts['required']) && strtolower($opts['required'])=='required') || (is_bool($opts['required']) && $opts['required']) ){
			$opts['required'] = 'required';
		} else {
			unset($opts['required']);
		}
	
		if ( !is_string($opts['form']) ) unset($opts['form']);
	
		if ( !isset($opts['autofocus']) || !$opts['autofocus'] ) unset($opts['autofocus']);
	
		$opts['id'] = $this->get_field_id($field_name);
	
		$opts['name'] = $this->get_field_name($field_name);
		if ( isset($opts['multiple']) ){
			$opts['name'] .= '[]';
		}
		$select_attributes = '';
		foreach ( $opts as $an => $av){
			$select_attributes .= "{$an}=\"{$av}\" ";
		}
		
		$categories = get_categories();
		$all_category_ids = array();
		foreach ($categories as $cat) $all_category_ids[] = (int)$cat->term_id;
		
		$is_valid_field_value = is_numeric($field_value) && in_array($field_value, $all_category_ids);
		if (!$is_valid_field_value && is_array($field_value)){
			$intersect_values = array_intersect($field_value, $all_category_ids);
			$is_valid_field_value = count($intersect_values) > 0;
		}
		if (!$is_valid_field_value){
			$field_value = '0';
		}
	
		$select_html = '<select ' . $select_attributes . '>';
		if (isset($allow_select_all)) $select_html .= $allow_select_all;
		foreach ($categories as $cat){
			$select_html .= '<option value="' . $cat->term_id . '"';
			if ($cat->term_id == $field_value || (is_array($field_value)&&in_array($cat->term_id, $field_value))){ $select_html .= ' selected="selected"';}
			$select_html .=  '>'.$cat->name.'</option>';
		}
		$select_html .= '</select>';
		return $select_html;
	}
	
	
	public function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array();
		$instance = wp_parse_args( (array) $instance, $defaults ); 		
		         
		$title1 = isset( $instance['title1'] )    ? 	strip_tags($instance['title1']) : '';
		$categoryid = isset( $instance['category'] )    ? $instance['category'] : '';
		$number     = isset( $instance['limit'] ) ? intval($instance['limit']) : 5;
		$item_row     = isset( $instance['item_row'] ) ? intval($instance['item_row']) : 1;
		$length     = isset( $instance['length'] ) ? intval($instance['length']) : 20;
		$columns     = isset( $instance['columns'] )      ? intval($instance['columns']) : 1;
		$columns1     = isset( $instance['columns1'] )      ? intval($instance['columns1']) : 1;
		$columns2     = isset( $instance['columns2'] )      ? intval($instance['columns2']) : 1;
		$columns3     = isset( $instance['columns3'] )      ? intval($instance['columns3']) : 1;
		$columns4     = isset( $instance['columns4'] )      ? intval($instance['columns4']) : 1;
		$layout   = isset( $instance['layout'] ) ? strip_tags($instance['layout']) : 'default';                
		?>		
		<p>
			<label for="<?php echo $this->get_field_id('title1'); ?>"><?php _e('Title', "wpbingo")?></label>
			<br />
			<input class="widefat" id="<?php echo $this->get_field_id('title1'); ?>" name="<?php echo $this->get_field_name('title1'); ?>"
				type="text"	value="<?php echo esc_attr($title1); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category', 'wpbingo')?></label>
			<br />
			<?php echo $this->category_select('category', array('allow_select_all' => true), $categoryid); ?>
		</p>		
		<p>
			<label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e('Number of Posts', "wpbingo")?></label>
			<br />
			<input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>"
				type="text"	value="<?php echo esc_attr($number); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('item_row'); ?>"><?php _e('Number row of Posts', "wpbingo")?></label>
			<br />
			<input class="widefat" id="<?php echo $this->get_field_id('item_row'); ?>" name="<?php echo $this->get_field_name('item_row'); ?>"
				type="text"	value="<?php echo esc_attr($item_row); ?>" />
		</p>		
		<p>
			<label for="<?php echo $this->get_field_id('length'); ?>"><?php _e('Excerpt length (in words): ', "wpbingo")?></label>
			<br />
			<input class="widefat"
				id="<?php echo $this->get_field_id('length'); ?>" name="<?php echo $this->get_field_name('length'); ?>" type="text" 
				value="<?php echo esc_attr($length); ?>" />
		</p>  
		<?php $number = array('1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6); ?>
		<p>
			<label for="<?php echo $this->get_field_id('columns'); ?>"><?php _e('Number of Columns >1200px: ', "wpbingo")?></label>
			<br />
			<select class="widefat"
				id="<?php echo $this->get_field_id('columns'); ?>"
				name="<?php echo $this->get_field_name('columns'); ?>">
				<?php
				$option ='';
				foreach ($number as $key => $value) :
					$option .= '<option value="' . $value . '" ';
					if ($value == $columns){
						$option .= 'selected="selected"';
					}
					$option .=  '>'.$key.'</option>';
				endforeach;
				echo $option;
				?>
			</select>
		</p> 
		
		<p>
			<label for="<?php echo $this->get_field_id('columns1'); ?>"><?php _e('Number of Columns on 992px to 1199px: ', "wpbingo")?></label>
			<br />
			<select class="widefat"
				id="<?php echo $this->get_field_id('columns1'); ?>"
				name="<?php echo $this->get_field_name('columns1'); ?>">
				<?php
				$option ='';
				foreach ($number as $key => $value) :
					$option .= '<option value="' . $value . '" ';
					if ($value == $columns1){
						$option .= 'selected="selected"';
					}
					$option .=  '>'.$key.'</option>';
				endforeach;
				echo $option;
				?>
			</select>
		</p> 
		
		<p>
			<label for="<?php echo $this->get_field_id('columns2'); ?>"><?php _e('Number of Columns on 768px to 991px: ', "wpbingo")?></label>
			<br />
			<select class="widefat"
				id="<?php echo $this->get_field_id('columns2'); ?>"
				name="<?php echo $this->get_field_name('columns2'); ?>">
				<?php
				$option ='';
				foreach ($number as $key => $value) :
					$option .= '<option value="' . $value . '" ';
					if ($value == $columns2){
						$option .= 'selected="selected"';
					}
					$option .=  '>'.$key.'</option>';
				endforeach;
				echo $option;
				?>
			</select>
		</p> 
		
		<p>
			<label for="<?php echo $this->get_field_id('columns3'); ?>"><?php _e('Number of Columns on 480px to 767px: ', "wpbingo")?></label>
			<br />
			<select class="widefat"
				id="<?php echo $this->get_field_id('columns3'); ?>"
				name="<?php echo $this->get_field_name('columns3'); ?>">
				<?php
				$option ='';
				foreach ($number as $key => $value) :
					$option .= '<option value="' . $value . '" ';
					if ($value == $columns3){
						$option .= 'selected="selected"';
					}
					$option .=  '>'.$key.'</option>';
				endforeach;
				echo $option;
				?>
			</select>
		</p> 
		
		<p>
			<label for="<?php echo $this->get_field_id('columns4'); ?>"><?php _e('Number of Columns in 480px or less than: ', "wpbingo")?></label>
			<br />
			<select class="widefat"
				id="<?php echo $this->get_field_id('columns4'); ?>"
				name="<?php echo $this->get_field_name('columns4'); ?>">
				<?php
				$option ='';
				foreach ($number as $key => $value) :
					$option .= '<option value="' . $value . '" ';
					if ($value == $columns4){
						$option .= 'selected="selected"';
					}
					$option .=  '>'.$key.'</option>';
				endforeach;
				echo $option;
				?>
			</select>
		</p> 
		
		<p>
			<label for="<?php echo $this->get_field_id('layout'); ?>"><?php _e("Template", "wpbingo")?></label>
			<br/>
			<select class="widefat"
				id="<?php echo $this->get_field_id('layout'); ?>"	name="<?php echo $this->get_field_name('layout'); ?>">
				<option value="default" <?php if ($layout=='default'){?> selected="selected"
				<?php } ?>>
					<?php echo esc_html__('Default', "wpbingo");?>
				</option>	
				<option value="default2" <?php if ($layout=='default2'){?> selected="selected"
				<?php } ?>>
					<?php echo esc_html__('Default 2', "wpbingo");?>
				</option>	
				<option value="sidebar" <?php if ($layout=='sidebar'){?> selected="selected"
				<?php } ?>>
					<?php echo esc_html__('Sidebar', "wpbingo");?>
				</option>				
				<option value="slider" <?php if ($layout=='slider'){?> selected="selected"
				<?php } ?>>
					<?php echo esc_html__('Slider', "wpbingo");?>
				</option>					
			</select>
		</p>           
	<?php
	}		
			
	}
}
?>