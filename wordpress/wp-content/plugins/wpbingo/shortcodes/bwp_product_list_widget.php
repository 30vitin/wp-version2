<?php
/**
 * Wpbingo Product List Widget
 * Plugin URI: http://www.wpbingo.com
 * Version: 1.0
 * This Widget help you to show images of product as a beauty tab reponsive slideshow
 */
class bwp_product_list_widget extends WP_Widget {

	/**
	 * Sets up a new Text widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'bwp_product_list_widget',
			'description' => __( 'Wpbingo Add Products List Widget.' ),
			'customize_selective_refresh' => true,
		);
		$control_ops = array( 'width' => 400, 'height' => 350 );
		parent::__construct( 'bwp_product_list_widget', __( 'Wpbingo Products List Widget' ), $widget_ops, $control_ops );
	}
	  
	 
	public function widget( $args, $instance ) {
		global $woocommerce;
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$number    		= isset( $instance['numberposts'] ) ? intval($instance['numberposts']) : 5;
		$source    		= isset( $instance['source'] ) ? ($instance['source']) : 'sale';

		echo $args['before_widget'];
		
		if($source == "bestseller"){
			$query = array(
				'posts_per_page' => $number,
				'post_status' 	 => 'publish',
				'post_type' 	 => 'product',
				'meta_key' 		 => 'total_sales',
				'orderby' 		 => 'meta_value_num',
				'no_found_rows'  => 1,
			);
			$query['meta_query'] = $woocommerce->query->get_meta_query();
			if ( isset( $instance['hide_free'] ) && 1 == $instance['hide_free'] ) {
				$query['meta_query'][] = array(
					'key'     => '_price',
					'value'   => 0,
					'compare' => '>',
					'type'    => 'DECIMAL',
				);
			}
		}elseif($source == "sale"){
			$query = array(
				'posts_per_page'    => $number,
				'no_found_rows'     => 1,
				'post_status'       => 'publish',
				'post_type'         => 'product',
				'meta_query'        => WC()->query->get_meta_query(),
				'post__in'          => array_merge( array( 0 ), wc_get_product_ids_on_sale() )
			);			
		}
		
		$widget_id = 'product-list-'.rand().time();
		
		$list = new WP_Query($query);

		if( $instance['layout'] == 'default' ){
			include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-product-list-widget/default.php' );
		}else{
			include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-product-list-widget/layout2.php' );
		}
		echo $args['after_widget'];
	}


	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		if ( array_key_exists('numberposts', $new_instance) ){
			$instance['numberposts'] = intval( $new_instance['numberposts'] );
		}
		$instance['source'] = strip_tags( $new_instance['source'] );
		$instance['layout'] = strip_tags( $new_instance['layout'] );
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
		$number    		= isset( $instance['numberposts'] ) ? intval($instance['numberposts']) : 3;
		$layout  = isset( $instance['layout'] )    ? 	strip_tags($instance['layout']) : '';
		$source  = isset( $instance['source'] )    ? 	strip_tags($instance['source']) : '';
		$title = isset( $instance['title'] )    ? 	strip_tags(sanitize_text_field( $instance['title'])) : '';
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php  echo esc_html_e('Title:', "wpbingo"); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('numberposts') ); ?>"><?php echo esc_html_e('Number of Posts', "wpbingo")?></label>
			<br />
			<input class="widefat"
				id="<?php echo esc_attr( $this->get_field_id('numberposts') ); ?>"name="<?php echo esc_attr( $this->get_field_name('numberposts') ); ?>" type="text"
				value="<?php echo esc_attr($number); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('source'); ?>"><?php echo esc_html_e("Source", "wpbingo")?></label>
			<br/>
			<select class="widefat"
				id="<?php echo $this->get_field_id('source'); ?>"	name="<?php echo $this->get_field_name('source'); ?>">
				<option value="sale" <?php if ($source=='sale'){?> selected="selected" <?php } ?>>
					<?php echo esc_html_e('Sale Product', "wpbingo")?>
				</option>
				<option value="bestseller" <?php if ($source=='bestseller'){?> selected="selected" <?php } ?>>
					<?php echo esc_html_e('Best Seller', "wpbingo")?>		
				</option>
			</select>
		</p>		
		<p>
			<label for="<?php echo $this->get_field_id('layout'); ?>"><?php echo _e("Template", "wpbingo")?></label>
			<br/>
			<select class="widefat"
				id="<?php echo $this->get_field_id('layout'); ?>"	name="<?php echo $this->get_field_name('layout'); ?>">
				<option value="default" <?php if ($layout=='default'){?> selected="selected" <?php } ?>>
					<?php echo _e('Default', "wpbingo")?>		
				</option>
				<option value="layout2" <?php if ($layout=='layout2'){?> selected="selected" <?php } ?>>
					<?php echo _e('Template 2', "wpbingo")?>		
				</option>				
			</select>
		</p>		
		<?php
	}
}
