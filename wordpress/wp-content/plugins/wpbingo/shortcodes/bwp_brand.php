<?php
/**
 * Wpbingo Brand Widget
 * Plugin URI: http://www.wpbingo.com
 * Version: 1.0
 * This Widget help you to show Brand of product as a beauty tab reponsive slideshow
 */
 
class bwp_brand_slider_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function __construct(){
		/* Add Taxonomy and Post type */
		add_action( 'init', array( $this, 'brand_register' ), 5 );
		
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'bwp_brand', 'description' => __('Bin Brand', 'wpbingo') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'bwp_brand' );

		/* Create the widget. */
		parent::__construct( 'bwp_brand', __('Wpbingo Product Brand', 'wpbingo'), $widget_ops, $control_ops );
		
		/* Create Shortcode */
		add_shortcode( 'bwp_brand', array( $this, 'bwp_brand_shortcode' ) );
		
		/* Create Vc_map */
		if (class_exists('Vc_Manager')) {
			add_action( 'vc_before_init', array( $this, 'bwp_brand_shortcode_load' ), 10 );
		}
		
		/* Add Custom field to category product */
		add_action( 'product_brand_add_form_fields', array( $this, 'add_category_fields' ), 100 );
		add_action( 'product_brand_edit_form_fields', array( $this, 'edit_category_fields' ), 100 );
		add_action( 'created_term', array( $this, 'save_category_fields' ), 10, 3 );
		add_action( 'edit_term', array( $this, 'save_category_fields' ), 10, 3 );
		
		// Add columns
		add_filter( 'manage_edit-product_brand_columns', array( $this, 'product_brand_columns' ) );
		add_filter( 'manage_product_brand_custom_column', array( $this, 'product_brand_column' ), 10, 3 );
	}
	function brand_register() {

		register_taxonomy( 'product_brand', array( 'product' ), array( 'hierarchical' => true, 'label' =>  __( 'Brand', 'wpbingo' ), 'singular_label' => __( 'Category Brand', 'wpbingo' ), 'rewrite' => true ) );
	}
	/**
	* Add Vc Params
	**/
	function bwp_brand_shortcode_load(){
		$terms = get_terms( 'product_brand', array( 'parent' => '', 'hide_empty' => 0 ) );
		$term = array();
		if( count( $terms ) > 0 ){			
			foreach( $terms as $cat ){
				$term[$cat->name] = $cat -> slug;
			}
		}
		vc_map( array(
			"name" => __( "Wpbingo Product Brand", "wpbingo" ),
			"base" => "bwp_brand",
			"category" => __( "Wpbingo Shortcode", "wpbingo"),		
		  "params" => array(
			 array(
				"type" => "textfield",
				"class" => "",
				"heading" => __( "Title", "wpbingo" ),
				"param_name" => "title1",
				"value" => '',
				"description" => __( "Title", "wpbingo" )
			 ),
			 array(
				"type" => "textfield",
				"heading" => __( "Extra Class", "wpbingo" ),
				"param_name" => "class",
				"value" => '',
				"description" => __( "Extra Class", "wpbingo" )
			 ),
			 array(
				"type" => "checkbox",
				"class" => "",
				"heading" => __( "Category", "wpbingo" ),
				"param_name" => "category",
				"value" => $term,
				"description" => __( "Select Brands", "wpbingo" )
			 ),
			 array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __( "Number row per column", "wpbingo" ),
				"param_name" => "item_row",
				"value" =>array(1,2,3),
				"description" => __( "Number row per column", "wpbingo" ),
				"std" => 1
			 ),
			 array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __( "Number of Columns >1200px: ", "wpbingo" ),
				"param_name" => "columns",
				"value" => array(1,2,3,4,5,6,7,8,9,10),
				"description" => __( "Number of Columns >1200px:", "wpbingo" ),
				"std" => 4
			 ),
			 array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __( "Number of Columns on 992px to 1199px:", "wpbingo" ),
				"param_name" => "columns1",
				"value" => array(1,2,3,4,5,6,7,8),
				"description" => __( "Number of Columns on 992px to 1199px:", "wpbingo" ),
				"std" => 4
			 ),
			 array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __( "Number of Columns on 768px to 991px:", "wpbingo" ),
				"param_name" => "columns2",
				"value" => array(1,2,3,4,5,6),
				"description" => __( "Number of Columns on 768px to 991px:", "wpbingo" ),
				"std" => 3
			 ),
			 array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __( "Number of Columns on 480px to 767px:", "wpbingo" ),
				"param_name" => "columns3",
				"value" => array(1,2,3,4,5,6),
				"description" => __( "Number of Columns on 480px to 767px:", "wpbingo" ),
				"std" => 2
			 ),
			 array(
				"type" => "dropdown",
				"class" => "",
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
				"value" => array( 'No' => 'false', 'Yes' => 'true'),
				"description" => __( "Show Navigation", "wpbingo" )
			 ),
			  array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __( "Layout", "wpbingo" ),
				"param_name" => "layout",
				"value" => array(
					'Layout Default' => 'default'
				),
				"description" => __( "Layout", "wpbingo" )
			 ),
		  )
	   ) );
	}
	/**
		** Add Shortcode
	**/
	function bwp_brand_shortcode( $atts, $content = null ){
		extract( shortcode_atts(
			array(
				'title1' => '',
				'class' => '',
				'category' => 0,
				'orderby' => 'name',
				'order'	=> 'DESC',
				'item_row'=> 1,
				'columns' => 4,
				'columns1' => 4,
				'columns2' => 3,
				'columns3' => 2,
				'columns4' => 1,	
				'show_nav'  => 'false',	
				'layout'  => 'default'
			), $atts )
		);
		ob_start();		
		if( $layout == 'default' ){
			include( WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-brands/default.php' );
		}

		$content = ob_get_clean();
		
		return $content;
	}
	
	public function bwp_trim_words( $text, $num_words = 30, $more = null ) {
		$text = strip_shortcodes( $text);
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]&gt;', $text);
		return wp_trim_words($text, $num_words, $more);
	}
	/**
		*	Add Custom field on category product
		**/
		public function add_category_fields() { 
			?>
			<div class="form-field">
				<label><?php _e( 'Thumbnail', 'wpbingo' ); ?></label>
				<div id="product_brand_thumbnail" style="float: left; margin-right: 10px;">
					<img class="product_brand_thumbnail_id" src="" style="display: none; width:60px;height:auto;">
				</div>				
				<div style="line-height: 60px;">
					<input type="hidden" id="product_brand_thumbnail_id" name="product_brand_thumbnail_id" value="">
					<input type="button" class="bwp_upload_image_button button" data-image_id="product_brand_thumbnail_id"  value="<?php _e( 'Browse', 'wpbingo' ); ?>">
					<input type="button" class="bwp_remove_image_button button" data-image_id="product_brand_thumbnail_id" value="<?php _e( 'Remove', 'wpbingo' ); ?>">
				</div>
				<div class="clear"></div>
			</div>
			<?php
		}
		
		public function edit_category_fields( $term ) {

			$image = ( get_term_meta( $term->term_id, 'thumbnail_bid', true ) );
			?>
			<tr class="form-field">
				<th scope="row" valign="top"><label><?php _e( 'Thumbnail', 'wpbingo' ); ?></label></th>
				<td>
					<div id="product_brand_thumbnail" style="float: left; margin-right: 10px;">
						<?php if($image){?>
							<img class="product_brand_thumbnail_id" src="<?php echo esc_url( $image ); ?>" style="display: block; width:60px;height:auto;">
						<?php }else{ ?>
							<img class="product_brand_thumbnail_id" src="<?php echo esc_url( $image ); ?>" style="display: none; width:60px;height:auto;">
						<?php } ?>
					</div>
					<div style="line-height: 60px;">
						<input type="hidden" id="product_brand_thumbnail_id" name="product_brand_thumbnail_id" value="<?php echo esc_url( $image ); ?>">
						<input type="button" class="bwp_upload_image_button button" data-image_id="product_brand_thumbnail_id"  value="<?php _e( 'Browse', 'wpbingo' ); ?>">
						<input type="button" class="bwp_remove_image_button button" data-image_id="product_brand_thumbnail_id" value="<?php _e( 'Remove image', 'wpbingo' ); ?>">
					</div>
					<div class="clear"></div>
				</td>
			</tr>
			<?php
		}
		public function save_category_fields( $term_id, $tt_id = '', $taxonomy = '' ) {
			if ( isset( $_POST['product_brand_thumbnail_id'] ) && 'product_brand' === $taxonomy ) {
				update_woocommerce_term_meta( $term_id, 'thumbnail_bid', ( $_POST['product_brand_thumbnail_id'] ) );
			}
		}
	
	/**
	 * Thumbnail column added to category admin.
	 *
	 * @param mixed $columns
	 * @return array
	 */
	public function product_brand_columns( $columns ) {
		$new_columns          = array();
		$new_columns['cb']    = $columns['cb'];
		$new_columns['thumb'] = __( 'Image', 'wpbingo' );

		unset( $columns['cb'] );

		return array_merge( $new_columns, $columns );
	}

	/**
	 * Thumbnail column value added to category admin.
	 *
	 * @param string $columns
	 * @param string $column
	 * @param int $id
	 * @return array
	 */
	public function product_brand_column( $columns, $column, $id ) {

		if ( 'thumb' == $column ) {

			$image = get_term_meta( $id, 'thumbnail_bid', true );
			if (!$image)
				$image = wc_placeholder_img_src();
			$image = str_replace( ' ', '%20', $image );

			$columns .= '<img src="' . esc_url( $image ) . '" alt="' . esc_attr__( 'Thumbnail', 'wpbingo' ) . '" class="wp-post-image" height="48" width="48" />';

		}

		return $columns;
	}
	
	/**
	 * Display the widget on the screen.
	 */
	public function widget( $args, $instance ) {
		extract($args);
		
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		echo $before_widget;
		
		if (!isset($instance['category'])){
			$instance['category'] = 0;
		}
		
		extract($instance);

		if ( !array_key_exists('widget_template', $instance) ){
			$instance['widget_template'] = 'default';
		}
		
		if ( $tpl = $this->getTemplatePath( $instance['widget_template'] ) ){ 
			$link_img = plugins_url('images/', __FILE__);
			$widget_id = $args['widget_id'];		
			include $tpl;
		}
				
		/* After widget (defined by widgets-template). */
		echo $after_widget;
	}    

	protected function getTemplatePath($tpl='list', $type=''){
		$file = '/'.$tpl.$type.'.php';
		$dir = WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-brands';
		
		if ( file_exists( $dir.$file ) ){
			return $dir.$file;
		}
		
		return $tpl=='list' ? false : $this->getTemplatePath('list', $type);
	}
	
	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		// strip tag on text field
		$instance['title1'] = strip_tags( $new_instance['title1'] );

		// str or array
		if ( array_key_exists('category', $new_instance) ){
			if ( is_array($new_instance['category']) ){
				$instance['category'] = $new_instance['category'] ;
			} else {
				$instance['category'] = strip_tags( $new_instance['category'] );
			}
		}		

		if ( array_key_exists('numberposts', $new_instance) ){
			$instance['numberposts'] = intval( $new_instance['numberposts'] );
		}
	
        $instance['widget_template'] = strip_tags( $new_instance['widget_template'] );
        
					
        
		return $instance;
	}

	public function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults 		= array();
		$instance 		= wp_parse_args( (array) $instance, $defaults ); 		
		$title1    		= isset( $instance['title1'] )     	? strip_tags($instance['title1']) : '';      
		$categoryid 	= isset( $instance['category']  ) 	? $instance['category'] : null;
		$number     	= isset( $instance['numberposts'] ) ? intval($instance['numberposts']) : 5;
		$widget_template   = isset( $instance['widget_template'] ) ? strip_tags($instance['widget_template']) : 'default';                
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'wpbingo')?></label>
			<br />
			<input class="widefat" id="<?php echo $this->get_field_id('title1'); ?>" name="<?php echo $this->get_field_name('title1'); ?>"
				type="text"	value="<?php echo esc_attr($title1); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('numberposts'); ?>"><?php _e('Number of Posts', 'wpbingo')?></label>
			<br />
			<input class="widefat" id="<?php echo $this->get_field_id('numberposts'); ?>" name="<?php echo $this->get_field_name('numberposts'); ?>"
				type="text"	value="<?php echo esc_attr($number); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('widget_template'); ?>"><?php _e("Template", 'wpbingo')?></label>
			<br/>
			
			<select class="widefat"
				id="<?php echo $this->get_field_id('widget_template'); ?>"	name="<?php echo $this->get_field_name('widget_template'); ?>">
				<option value="list" <?php if ($widget_template=='list'){?> selected="selected"
				<?php } ?>>
					<?php _e('List Brands', 'wpbingo')?>
				</option>				
			</select>
		</p>               
	<?php
	}	
}
?>