<?php
	/**
	 * Wpbingo Policy
	 * Plugin URI: http://www.wpbingo.com
	 * Version: 1.0
	 * This Widget help you to show images of product as a beauty tab reponsive slideshow
	 */
class bwp_widget_policy extends WP_Widget {
	public function __construct() {
		$widget_ops = array(
			'classname' => 'bwp_widget_policy',
			'description' => __( 'Wpbingo Add Policy.', 'wpbingo' ),
			'customize_selective_refresh' => true,
		);
		$control_ops = array( 'width' => 400, 'height' => 350 );
		parent::__construct( 'bwp_widget_policy', __( 'Wpbingo Policy', 'wpbingo' ), $widget_ops, $control_ops );
		
		add_shortcode( 'bwp_policy_shortcode', array( $this, 'bwp_policy_shortcode' ) );
		
		/* Create Vc_map */
		if ( class_exists('Vc_Manager') && class_exists( 'WooCommerce' ) ) {
			add_action( 'vc_before_init', array( $this, 'bwp_policy_shortcode_load' ));
		}		
	}
	/**
		* Add Vc Params
	**/
	function bwp_policy_shortcode_load(){
		
		vc_map( array(
			"name" => esc_html__( "Wpbingo Policy", 'wpbingo'),
			"base" => "bwp_policy_shortcode",
			"category" => esc_html__( "Wpbingo Shortcode", 'wpbingo'),
			"params" => array(
			array(
				"type" => "textfield",
				"heading" => esc_html__( "Title", 'wpbingo'),
				"param_name" => "title1",
				"value" => esc_html__( "Policy", 'wpbingo'),
				'admin_label' => true,
			),
			array(
				'heading'     => esc_html__( 'Content', 'wpbingo'),
				'type'        => 'textarea',
				'param_name'  => 'desc',
			),
			array(
				"type" => "textfield",
				"heading" => esc_html__( "Link", 'wpbingo'),
				"param_name" => "link",
				"value" => '#'
			),
			array(
				"type" => "attach_image",
				"class" => "",
				"heading" => esc_html__( "Image", 'wpbingo'),
				"param_name" => "image",
				"value" => "",
				"description" => esc_html__( "Select image from media library",'wpbingo')
			),
			array(
				"type" => "dropdown",
				"heading" => __( "Layout", "wpbingo" ),
				"param_name" => "layout",
				"value" => array( 'Layout Default' => 'default', 'Layout 2' => 'layout2'),
				"description" => __( "Layout", "wpbingo" )
			),
		  )
	   ) );
	}
	/**
		** Add Shortcode
	**/
	function bwp_policy_shortcode( $atts, $content = null ){
		extract( shortcode_atts(
			array(
				'title1'   => '',
				'desc' 	   => '',
				'image'    => '',
				'link'    => '#',
				'layout'  => 'default',
			), $atts )
		);
		if($image){
			$image = wp_get_attachment_image_src( $image,'large');
			$image = $image[0];		
		}	
		ob_start();	

		include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-policy/default.php' );
		
		$content = ob_get_clean();
		
		return $content;
	}
	
	public function widget( $args, $instance ) {
		$title1 = apply_filters( 'widget_title', empty( $instance['title1'] ) ? '' : $instance['title1'], $instance, $this->id_base );
		$desc		 = 	( $instance['desc'] ) ? $instance['desc'] : '';
		$image		 = 	( $instance['image'] ) ? $instance['image'] : '';	
		$link		 = 	( $instance['link'] ) ? $instance['link'] : '';
		$layout		 = 	( $instance['layout'] ) ? $instance['layout'] : 'default';
		
		echo $args['before_widget'];
		include(WPBINGO_SHORTCODES_TEMPLATE_PATH.'bwp-policy/default.php' );
		echo $args['after_widget'];
	}

	
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title1'] = sanitize_text_field( $new_instance['title1'] );
		$instance['desc'] = sanitize_text_field( $new_instance['desc'] );
		$instance['image'] = sanitize_text_field( $new_instance['image'] );
		$instance['link'] = sanitize_text_field( $new_instance['link'] );
		$instance['layout'] = sanitize_text_field( $new_instance['layout'] );
		return $instance;
	}

	public function form( $instance ) {
		$instance = wp_parse_args( 
					$instance, 
					array( 'title1' => '','desc' => '','image' => '','link' => '#','layout' => 'default' ) 
				);
		$title1 = sanitize_text_field( $instance['title1'] );
		$desc = sanitize_text_field( $instance['desc'] );
		$link = sanitize_text_field( $instance['link'] );
		$image   	= isset( $instance['image'] ) ? strip_tags($instance['image']) : '';
		$layout   	= isset( $instance['layout'] ) ? strip_tags($instance['layout']) : 'default';
        ?>
		<p><label for="<?php echo $this->get_field_id('title1'); ?>"><?php _e('Title:', 'wpbingo'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title1'); ?>" name="<?php echo $this->get_field_name('title1'); ?>" type="text" value="<?php echo esc_attr($title1); ?>" /></p>
		<p><label for="<?php echo $this->get_field_id( 'desc' ); ?>"><?php _e( 'Description:', 'wpbingo' ); ?></label>
		<textarea class="widefat" rows="4" cols="8" id="<?php echo $this->get_field_id('desc'); ?>" name="<?php echo $this->get_field_name('desc'); ?>"><?php echo esc_textarea( $instance['desc'] ); ?></textarea></p>
		<p><label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Link:', "wpbingo"); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>" type="text" value="<?php echo esc_attr($link); ?>" /></p>

		<p>
            <label for="<?php echo $this->get_field_name( 'image' ); ?>"><?php _e( 'Image:' ); ?></label>
            <input type="hidden" name="<?php echo $this->get_field_name( 'image' ); ?>" id="<?php echo $this->get_field_id( 'image' ); ?>" type="text" size="36"  value="<?php echo esc_url( $image ); ?>" />
            <?php if($image){?>
				<img class="<?php echo $this->get_field_id( 'image' ); ?>" src="<?php echo esc_url( $image ); ?>" style="display: block; width:400px;height:auto;">
			<?php }else{?>
				<img class="<?php echo $this->get_field_id( 'image' ); ?>" src="<?php echo esc_url( $image ); ?>" style="display: none; width:400px;height:auto;">
			<?php } ?>
			<input class="bwp_upload_image_button button" data-image_id="<?php echo $this->get_field_id( 'image' ); ?>" type="button" value="<?php _e( 'Browse', 'wpbingo' ); ?>" />
			<input type="button" class="bwp_remove_image_button button" data-image_id="<?php echo $this->get_field_id( 'image' ); ?>" value="<?php _e( 'Remove image', 'wpbingo' ); ?>">
        </p>	

        <p>
			<label for="<?php echo $this->get_field_id('layout'); ?>"><?php _e("Layout", "wpbingo" )?></label>
			<br/>
			
			<select class="widefat"
				id="<?php echo $this->get_field_id('layout'); ?>"	name="<?php echo $this->get_field_name('layout'); ?>">
				<option value="default" <?php if ($layout=='default'){?> selected="selected" <?php } ?>>
					<?php _e('Default', "wpbingo")?>		
				</option>	
			</select>
		</p>
		<?php
	}	
}	
?>