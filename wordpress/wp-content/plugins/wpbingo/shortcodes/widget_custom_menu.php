<?php
class Bwp_WP_Nav_Menu_Widget extends WP_Widget {

	/**
	 * Sets up a new Custom Menu widget instance.
	 *
	 * @since 3.0.0
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array(
			'description' => esc_html__( 'Add a custom menu to your sidebar.','wpbingo' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'nav_menu', esc_html__('Wpbingo Custom Menu','wpbingo'), $widget_ops );

		add_shortcode( 'bwp_custom_menu', array( $this, 'bwp_custom_menu_shortcode' ) );
		
		/* Create Vc_map */
		if ( class_exists('Vc_Manager') && class_exists( 'WooCommerce' ) ) {
			add_action( 'vc_before_init', array( $this, 'bwp_custom_menu_shortcode_load' ) );
		}	
		
	}
	
	function bwp_custom_menu_shortcode_load(){
		// Get menu
		$term = array();
		$menus = wp_get_nav_menus();
		if($menus){
			foreach ( $menus as $menu ) :
				$term[$menu->slug] = $menu->name;
			endforeach;
		}
		vc_map( array(
				"name" => esc_html__( "Wpbingo Custom Menu", "wpbingo" ),
				"base" => "bwp_custom_menu",
				"category" => esc_html__( "Wpbingo Shortcode", "wpbingo"),
				"params" => array(
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Title", "wpbingo" ),
					"param_name" => "title1",
					"value" => 'Wpbingo Custom Menu',
					"description" => esc_html__( "Title", "wpbingo" )
				),
				array(
					"type" => "textfield",
					"heading" => esc_html__( "Class", "wpbingo" ),
					"param_name" => "class"
				),
				array(
					"type" => "dropdown",
					"heading" => esc_html__( "Select Menu", "wpbingo" ),
					"param_name" => "nav_menu",
					"value" => $term,
					"description" => esc_html__( "Select Menu", "wpbingo" )
				),				
			  )
			)
		);
	}
	/**
		** Add Shortcode
	**/
	function bwp_custom_menu_shortcode( $atts, $content = null ){
		extract( shortcode_atts(
			array(
				'title1' => '',
				'class' => '',
				'nav_menu' => '',
			), $atts )
		);
		ob_start();	?>
		
		<div class="widget-custom-menu <?php echo ( (isset($class) && ($class)) ?  esc_attr($class) : '' ); ?>">
			<?php if ( !empty($title1) )
				echo $title1;
			
			$nav_menu_args = array(
				'fallback_cb' 	=> '',
				'menu'      => $nav_menu,
				'walker' 	=> new fashow_mega_menu_walker,
			); 
			wp_nav_menu( apply_filters( 'widget_nav_menu_args', $nav_menu_args, $nav_menu) ); ?>
		</div> 

		<?php $content = ob_get_clean();
		
		return $content;
	}	
	
	public function widget( $args, $instance ) {
		// Get menu
		$nav_menu = ! empty( $instance['nav_menu'] ) ? wp_get_nav_menu_object( $instance['nav_menu'] ) : false;

		if ( !$nav_menu )
			return;

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		echo $args['before_widget']; ?> 
	
		<div class="widget-custom-menu <?php echo ( (isset($instance['class']) && ($instance['class'])) ?  esc_attr($instance['class']) : '' ); ?>">
			<?php if ( !empty($instance['title']) )
				echo $args['before_title'] . $instance['title'] . $args['after_title'];

			$nav_menu_args = array(
				'fallback_cb' 	=> '',
				'menu'      => $nav_menu,
				'walker' 	=> new fashow_mega_menu_walker,
			); 
			wp_nav_menu( apply_filters( 'widget_nav_menu_args', $nav_menu_args, $nav_menu, $args, $instance ) ); ?> 
		</div> 
		
		<?php echo $args['after_widget'];
		
	}

	/**
	 * Handles updating settings for the current Custom Menu widget instance.
	 *
	 * @since 3.0.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		if ( ! empty( $new_instance['title'] ) ) {
			$instance['title'] = sanitize_text_field( $new_instance['title'] );
		}
		if ( ! empty( $new_instance['class'] ) ) {
			$instance['class'] = sanitize_text_field( $new_instance['class'] );
		}		
		if ( ! empty( $new_instance['nav_menu'] ) ) {
			$instance['nav_menu'] = $new_instance['nav_menu'];
		}
		return $instance;
	}

	/**
	 * Outputs the settings form for the Custom Menu widget.
	 *
	 * @since 3.0.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 * @global WP_Customize_Manager $wp_customize
	 */
	public function form( $instance ) {
		global $wp_customize;
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$class = isset( $instance['class'] ) ? $instance['class'] : '';
		$nav_menu = isset( $instance['nav_menu'] ) ? $instance['nav_menu'] : '';

		// Get menus
		$menus = wp_get_nav_menus();
		// If no menus exists, direct the user to go and create some.
		?>
		<p class="nav-menu-widget-no-menus-message" <?php if ( ! empty( $menus ) ) { echo ' style="display:none" '; } ?>>
			<?php
			if ( $wp_customize instanceof WP_Customize_Manager ) {
				$url = 'javascript: wp.customize.panel( "nav_menus" ).focus();';
			} else {
				$url = admin_url( 'nav-menus.php' );
			}
			?>
			<?php echo sprintf( esc_html__( 'No menus have been created yet. <a href="%s">Create some</a>.' ,'wpbingo'), esc_attr( $url ) ); ?>
		</p>
		<div class="nav-menu-widget-form-controls" <?php if ( empty( $menus ) ) { echo ' style="display:none" '; } ?>>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo esc_html__( 'Title:','wpbingo' ) ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>"/>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'class' ); ?>"><?php echo esc_html__( 'Class:','wpbingo' ) ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'class' ); ?>" name="<?php echo $this->get_field_name( 'class' ); ?>" value="<?php echo esc_attr( $class ); ?>"/>
			</p>			
			<p>
				<label for="<?php echo $this->get_field_id( 'nav_menu' ); ?>"><?php echo esc_html__( 'Select Menu:' ,'wpbingo'); ?></label>
				<select id="<?php echo $this->get_field_id( 'nav_menu' ); ?>" name="<?php echo $this->get_field_name( 'nav_menu' ); ?>">
					<option value="0"><?php esc_html__( '&mdash; Select &mdash;' ,'wpbingo'); ?></option>
					<?php foreach ( $menus as $menu ) : ?>
						<option value="<?php echo esc_attr( $menu->slug ); ?>" <?php selected( $nav_menu, $menu->slug ); ?>>
							<?php echo esc_html( $menu->name ); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</p>
			<?php if ( $wp_customize instanceof WP_Customize_Manager ) : ?>
				<p class="edit-selected-nav-menu" style="<?php if ( ! $nav_menu ) { echo 'display: none;'; } ?>">
					<button type="button" class="button"><?php esc_html__( 'Edit Menu','wpbingo' ) ?></button>
				</p>
			<?php endif; ?>
		</div>
		<?php
	}
}

add_action( 'widgets_init', 'bwp_widget_custom_menu' );
function bwp_widget_custom_menu(){
	unregister_widget('WP_Nav_Menu_Widget');
	register_widget( 'Bwp_WP_Nav_Menu_Widget');
}