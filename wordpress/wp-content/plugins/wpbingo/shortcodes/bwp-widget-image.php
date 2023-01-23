<?php
/**
 * Wpbingo Add Banner Image
 * Plugin URI: http://www.wpbingo.com
 * Version: 1.0
 * This Widget help you to show images of product as a beauty tab reponsive slideshow
 */
class bwp_widget_image extends WP_Widget {

	/**
	 * Sets up a new Text widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'bwp_widget_image',
			'description' => __( 'Wpbingo Add Banner Image.', "wpbingo" ),
			'customize_selective_refresh' => true,
		);
		$control_ops = array( 'width' => 400, 'height' => 350 );
		parent::__construct( 'bwp_widget_image', __( 'Wpbingo Banner Image', "wpbingo" ), $widget_ops, $control_ops );
		
		add_shortcode( 'woo_banner_image_widget', array( $this, 'bwp_banner_image_widget' ) );
		
		/* Create Vc_map */
		if ( class_exists('Vc_Manager') && class_exists( 'WooCommerce' ) ) {
			add_action( 'vc_before_init', array( $this, 'bwp_banner_image_widget_load' ) );
		}		
	}

	function bwp_banner_image_widget_load(){
		
		vc_map( array(
			"name" => __( "Wpbingo Banner Image", "wpbingo" ),
			"base" => "woo_banner_image_widget",
			"category" => __( "Wpbingo Shortcode", "wpbingo"),
			"params" => array(
			array(
				"type" => "textfield",
				"heading" => __( "Title", "wpbingo" ),
				"param_name" => "title1",
				"value" => 'Wpbingo Banner Image Widget',
				"description" => __( "Title", "wpbingo" )
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__( "Sub Title", "wpbingo" ),
				"param_name" => "subtitle"
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__( "Description", "wpbingo" ),
				"param_name" => "description"
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__( "Button label", "wpbingo" ),
				"param_name" => "label",
			),			 
			array(
				"type" => "textfield",
				"heading" => __( "Link", "wpbingo" ),
				"param_name" => "link",
				"value" => '#'
			),
			array(
				"type" => "attach_image",
				"class" => "",
				"heading" => __( "Image", "wpbingo"),
				"param_name" => "image",
				"value" => "",
				"description" => __( "Select image from media library","wpbingo")
			),			
			array(
				"type" => "dropdown",
				"heading" => __( "Style", "wpbingo" ),
				"param_name" => "layout",
				"value" => array( 
					'Style Default' => 'default', 
					'Layout 2' => 'layout2',
					'Layout 3' => 'layout3',
					'Layout 4' => 'layout4',
					'Layout 5' => 'layout5',
					'No Style' => 'nostyle',
				),
				"description" => __( "Select Style", "wpbingo" )
			 ),
		  )
	   ) );
	}
	/**
		** Add Shortcode
	**/
	function bwp_banner_image_widget( $atts, $content = null ){
		extract( shortcode_atts(
			array(
				'title1' => '',
				'subtitle' => '',
				'description' => '',
				'link' => '#',
				'label' => '',
				'image' => '',
				'layout'  => 'default',
			), $atts )
		);

		if($image){
			$image = wp_get_attachment_image_src( $image,'full');
			$image = $image[0];		
		}	
		ob_start();	
				
		if( $layout == 'nostyle' ){
			include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-widget-image/nostyle.php' );			
		}else{
			include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-widget-image/default.php' );
		}
		$content = ob_get_clean();
		
		return $content;
	}
	  
	 
	public function widget( $args, $instance ) {
		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title1 = apply_filters( 'widget_title', empty( $instance['title1'] ) ? '' : $instance['title1'], $instance, $this->id_base );
		$link		 = 	( $instance['link'] ) ? $instance['link'] : '';
		$subtitle		 = 	( $instance['subtitle'] ) ? $instance['subtitle'] : '';
		$description		 = 	( $instance['description'] ) ? $instance['description'] : '';
		$image		 = 	( $instance['image'] ) ? $instance['image'] : '';
		$layout		 = 	( $instance['layout'] ) ? $instance['layout'] : 'default';
		/**
		 * Filter the content of the Text widget.
		 *
		 * @since 2.3.0
		 * @since 4.4.0 Added the `$this` parameter.
		 *
		 * @param string         $widget_text The widget content.
		 * @param array          $instance    Array of settings for the current widget.
		 * @param WP_Widget_Text $this        Current Text widget instance.
		 */
		//$text = apply_filters( 'widget_text', $widget_text, $instance, $this );

		echo $args['before_widget'];
		if( $layout == 'default' )
		{
			include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-widget-image/default.php' );
		}elseif( $layout == 'nostyle' ){
			include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-widget-image/nostyle.php' );
		}
		echo $args['after_widget'];
	}

		
	/**
	 * Handles updating settings for the current Text widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Settings to save or bool false to cancel saving.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title1'] = sanitize_text_field( $new_instance['title1'] );
		$instance['link'] = sanitize_text_field( $new_instance['link'] );
		$instance['label'] = sanitize_text_field( $new_instance['label'] );
		$instance['image'] = sanitize_text_field( $new_instance['image'] );
		$instance['layout'] = sanitize_text_field( $new_instance['layout'] );
		if ( current_user_can( 'unfiltered_html' ) ) {
			$instance['subtitle'] = $new_instance['subtitle'];
		} else {
			$instance['subtitle'] = wp_kses_post( $new_instance['subtitle'] );
		}
		if ( current_user_can( 'unfiltered_html' ) ) {
			$instance['description'] = $new_instance['description'];
		} else {
			$instance['description'] = wp_kses_post( $new_instance['description'] );
		}
		$instance['filter'] = ! empty( $new_instance['filter'] );
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
							array( 'title1' => '', 'subtitle' => '', 'description' => '', 'link' => '#','layout' => 'default','image' => '' ) 
					);
		$filter = isset( $instance['filter'] ) ? $instance['filter'] : 0;
		$title1 = sanitize_text_field( $instance['title1'] );
		$subtitle = sanitize_text_field( $instance['subtitle'] );
		$description = sanitize_text_field( $instance['description'] );
		$link = sanitize_text_field( $instance['link'] );
		$image = sanitize_text_field( $instance['image'] );
		$layout   	= isset( $instance['layout'] ) ? strip_tags($instance['layout']) : 'default';
        ?>
		<p><label for="<?php echo $this->get_field_id('title1'); ?>"><?php _e('Title:', "wpbingo"); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title1'); ?>" name="<?php echo $this->get_field_name('title1'); ?>" type="text" value="<?php echo esc_attr($title1); ?>" /></p>
		<p><label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Link:', "wpbingo"); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo esc_attr($link); ?>" /></p>
		<p><label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e( 'Description:', "wpbingo" ); ?></label>
		<textarea class="widefat" rows="4" cols="8" id="<?php echo $this->get_field_id('description'); ?>" name="<?php echo $this->get_field_name('description'); ?>"><?php echo esc_textarea( $instance['description'] ); ?></textarea></p>
		
		<p><input id="<?php echo $this->get_field_id('filter'); ?>" name="<?php echo $this->get_field_name('filter'); ?>" type="checkbox"<?php checked( $filter ); ?> />&nbsp;<label for="<?php echo $this->get_field_id('filter'); ?>"><?php _e('Automatically add paragraphs'); ?></label></p>
		<p>
            <label for="<?php echo $this->get_field_name( 'image' ); ?>"><?php _e( 'Image:' ); ?></label>
            <input type="hidden" name="<?php echo $this->get_field_name( 'image' ); ?>" id="<?php echo $this->get_field_id( 'image' ); ?>" type="text" size="36"  value="<?php echo esc_url( $image ); ?>" />
			<?php if($image){?>
				<img class="<?php echo $this->get_field_id( 'image' ); ?>" src="<?php echo esc_url( $image ); ?>" style="display: block; width:400px;height :auto;">
			<?php }else{ ?>
				<img class="<?php echo $this->get_field_id( 'image' ); ?>" src="<?php echo esc_url( $image ); ?>" style="display: none; width:400px;height :auto;">
			<?php }?>
			<input class="bwp_upload_image_button button" data-image_id="<?php echo $this->get_field_id( 'image' ); ?>" type="button" value="<?php _e( 'Browse', 'wpbingo' ); ?>" />
			<input type="button" class="bwp_remove_image_button button" data-image_id="<?php echo $this->get_field_id( 'image' ); ?>" value="<?php _e( 'Remove image', 'wpbingo' ); ?>">
        </p>	
		
		<p>
			<label for="<?php echo $this->get_field_id('layout'); ?>"><?php _e("Template", "wpbingo" )?></label>
			<br/>
			
			<select class="widefat"
				id="<?php echo $this->get_field_id('layout'); ?>"	name="<?php echo $this->get_field_name('layout'); ?>">
				<option value="default" <?php if ($layout=='default'){?> selected="selected" <?php } ?>>
					<?php _e('Default', "wpbingo")?>		
				</option>
				<option value="nostyle" <?php if ($layout=='nostyle'){?> selected="selected" <?php } ?>>
					<?php _e('No Style', "wpbingo")?>		
				</option>			
			</select>
		</p>
		<?php
	}
}
