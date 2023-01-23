<?php
/*
Plugin Name: Wpbingo Core
Plugin URI: https://themeforest.net/user/wpbingo
Description: Use For Wpbingo Theme.
Version: 1.0
Author: TungHV
Author URI: https://themeforest.net/user/wpbingo
*/

// don't load directly
if (!defined('ABSPATH'))
    die('-1');

require_once( dirname(__FILE__) . '/function.php');
define('WPBINGO_SHORTCODES_PATH', dirname(__FILE__) . '/shortcodes/');
define('WPBINGO_SHORTCODES_TEMPLATE_PATH', dirname(__FILE__) . '/shortcodes-template/');
define('WPBINGO_CONTENT_TYPES_LIB', dirname(__FILE__) . '/lib/');
require_once WPBINGO_CONTENT_TYPES_LIB . 'lookbook/includes/bwp_lookbook_class.php';
define ( 'LOOKBOOK_TABLE', 'bwp_lookbook');
class WpbingoShortcodesClass {

    function __construct() {
        // Init plugins
		$this->loadInit();
		add_filter( 'wp_calculate_image_srcset', array( $this, 'bwp_disable_srcset' ) );
		load_plugin_textdomain('wpbingo', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
    }
	
	
	function loadInit() {
		global $woocommerce;
		if ( ! isset( $woocommerce ) || ! function_exists( 'WC' ) ) {
			add_action( 'admin_notices', array( $this, 'bwp_woocommerce_admin_notice' ) );
			return;
		}else{
			add_action('wp_enqueue_scripts', array( $this, 'bwp_framework_script' ) );	
			require_once(WPBINGO_CONTENT_TYPES_LIB.'settings/save_settings.php');	
			//Load Taxonomy
			$this->bwp_load_file(WPBINGO_CONTENT_TYPES_LIB);
			//Load ShortCodes
			$this->bwp_load_file(WPBINGO_SHORTCODES_PATH);
			//Register Widgets
			add_action( 'widgets_init', array( $this, 'register_widgets' ) );
			remove_filter( 'woocommerce_product_loop_start', 'woocommerce_maybe_show_product_subcategories' );
		}	
    }	
	function bwp_load_file($path){
		$files = array_diff(scandir($path), array('..', '.'));
		if(count($files)>0){
			foreach ($files as  $file) {
				if (strpos($file, '.php') !== false)
					require_once($path . $file);
			}
		}		
	}
	
	function bwp_framework_script(){
		wp_enqueue_script('bwp_wpbingo_js',plugins_url( '/wpbingo/assets/js/wpbingo.js' ),array("jquery"),false,true);	
	}
	
	// register widgets
	function register_widgets(){
		register_widget( 'bwp_product_list_widget');
		register_widget( 'bwp_brand_slider_widget');
		register_widget( 'bwp_widget_slider');
		register_widget( 'bwp_widget_testimonial');
		register_widget( 'bwp_woo_recent_post_widget');
		register_widget( 'bwp_widget_image');
		register_widget( 'bwp_widget_woo_categories');
		register_widget( 'bwp_ajax_filter_widget' );
		register_widget( 'bwp_widget_policy');	
	}		
	
	function bwp_woocommerce_admin_notice(){
		?>
		<div class="error">
			<p><?php _e( 'Wpbingo is enabled but not effective. It requires WooCommerce in order to work.', 'wpbingo' ); ?></p>
		</div>
		<?php
	}
	
	function bwp_disable_srcset( $sources ) {		
		return false;	
	}
	
}

function lookbook_install () {
    global $wpdb;
	
    $table_name = $wpdb->prefix . LOOKBOOK_TABLE;
	include_once ABSPATH.'wp-admin/includes/upgrade.php';
    if($wpdb->get_var("show tables like '$table_name'") != $table_name) {

        $sql = "CREATE TABLE IF NOT EXISTS `" . $table_name . "` (
                  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                  `name` varchar(255) NOT NULL,
				  `title` varchar(255),
				  `description` varchar(255),
                  `width` smallint(5) unsigned NOT NULL,
                  `height` smallint(5) unsigned NOT NULL,		  
                  `image` varchar(255) NOT NULL,
                  `pins` text NOT NULL,
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
		if(dbDelta($sql)){
			$sql_insert = "INSERT INTO `" . $table_name . "` (`id`, `name`, `title`, `description`, `width`, `height`, `image`, `pins`) VALUES
				(29, 'Lookbook 15', '', '', 525, 500, 'lookbook-home-1.jpg', '[{\"id\":\"1529552601211\",\"top\":73,\"left\":214,\"width\":30,\"height\":30,\"slug\":\"suspension-archives\",\"img_height\":500,\"img_width\":525,\"editable\":true},{\"id\":\"1529552626031\",\"top\":156,\"left\":410,\"width\":30,\"height\":30,\"slug\":\"ford-boutique-cups\",\"img_height\":500,\"img_width\":525,\"editable\":true},{\"id\":\"1529552727767\",\"top\":396,\"left\":495,\"width\":30,\"height\":32,\"slug\":\"best-jean-jackets\",\"img_height\":500,\"img_width\":525,\"editable\":true},{\"id\":\"1529552760845\",\"top\":436,\"left\":251,\"width\":30,\"height\":30,\"slug\":\"handmade-pillow\",\"img_height\":500,\"img_width\":525,\"editable\":true},{\"id\":\"1529552800198\",\"top\":466,\"left\":158,\"width\":30,\"height\":30,\"slug\":\"designer-glasses-frames\",\"img_height\":500,\"img_width\":525,\"editable\":true}]'),
				(30, 'Lookbook 1', '', '', 720, 345, '0_lookbook-home-5-1.jpg', '[{\"id\":\"1531727372679\",\"top\":112,\"left\":397,\"width\":30,\"height\":30,\"slug\":\"designer-baby-dresses\",\"img_height\":345,\"img_width\":720,\"editable\":true}]'),
				(31, 'Lookbook 2', '', '', 345, 720, '0_lookbook-home-5-4.jpg', '[{\"id\":\"1531727416880\",\"top\":128,\"left\":236,\"width\":30,\"height\":30,\"slug\":\"lounge-chair-high\",\"img_height\":720,\"img_width\":345,\"editable\":true},{\"id\":\"1531727471941\",\"top\":430,\"left\":216,\"width\":30,\"height\":30,\"slug\":\"fritz-hansen-objects\",\"img_height\":720,\"img_width\":345,\"editable\":true},{\"id\":\"1531727489095\",\"top\":663,\"left\":59,\"width\":30,\"height\":30,\"slug\":\"ford-boutique-cups\",\"img_height\":720,\"img_width\":345,\"editable\":true}]'),
				(32, 'Lookbook 3', '', '', 345, 345, '0_lookbook-home-5-6.jpg', '[{\"id\":\"1531727543885\",\"top\":182,\"left\":209,\"width\":30,\"height\":30,\"slug\":\"nice-dining-table\",\"img_height\":345,\"img_width\":345,\"editable\":true}]'),
				(33, 'Lookbook 4', '', '', 345, 345, 'lookbook-home-5-2.jpg', '[{\"id\":\"1531727579673\",\"top\":216,\"left\":190,\"width\":26,\"height\":33,\"slug\":\"more-cute-things\",\"img_height\":345,\"img_width\":345,\"editable\":true}]'),
				(34, 'Lookbook 5', '', '', 345, 345, '0_lookbook-home-5-3.jpg', '[{\"id\":\"1531727607464\",\"top\":197,\"left\":214,\"width\":30,\"height\":30,\"slug\":\"sleep-time-archives\",\"img_height\":345,\"img_width\":345,\"editable\":true}]'),
				(35, 'Lookbook 6', '', '', 345, 345, '0_lookbook-home-5-7.jpg', '[{\"id\":\"1531727628544\",\"top\":174,\"left\":214,\"width\":30,\"height\":30,\"slug\":\"london-table-lamp\",\"img_height\":345,\"img_width\":345,\"editable\":true}]'),
				(36, 'Lookbook 7', '', '', 720, 345, '0_lookbook-home-5-8.jpg', '[{\"id\":\"1531727659470\",\"top\":190,\"left\":294,\"width\":30,\"height\":30,\"slug\":\"chaise-pied-eiffel\",\"img_height\":345,\"img_width\":720,\"editable\":true}]'),
				(37, 'Lookbook 8', '', '', 720, 345, '0_lookbook-home-5-9.jpg', '[{\"id\":\"1531727687071\",\"top\":149,\"left\":390,\"width\":31,\"height\":30,\"slug\":\"handmade-pillow\",\"img_height\":345,\"img_width\":720,\"editable\":true}]'),
				(38, 'Lookbook 9', '', '', 345, 348, '0_lookbook-home-5-10.jpg', '[{\"id\":\"1531727725032\",\"top\":191,\"left\":189,\"width\":30,\"height\":30,\"slug\":\"designer-glasses-frames\",\"img_height\":345,\"img_width\":345,\"editable\":true}]'),
				(39, 'Lookbook 10', '', '', 720, 344, '0_lookbook-home-5-11.jpg', '[{\"id\":\"1531727752423\",\"top\":218,\"left\":364,\"width\":30,\"height\":30,\"slug\":\"stylish-baby-and-kids-fashion\",\"img_height\":344,\"img_width\":720,\"editable\":true}]'),
				(40, 'Lookbook 11', '', '', 345, 345, 'lookbook-home-5-12.jpg', '[{\"id\":\"1531727776078\",\"top\":228,\"left\":150,\"width\":30,\"height\":30,\"slug\":\"best-boy-dress-fashion\",\"img_height\":345,\"img_width\":345,\"editable\":true}]'),
				(41, 'Lookbook 16', '', '', 384, 682, 'lookbook-update-1.jpg', '[{\"id\":\"1535614231073\",\"top\":125,\"left\":125,\"width\":30,\"height\":30,\"slug\":\"london-table-lamp\",\"img_height\":682,\"img_width\":384,\"editable\":true},{\"id\":\"1535614267079\",\"top\":523,\"left\":76,\"width\":30,\"height\":30,\"slug\":\"lichtarena-lights\",\"img_height\":682,\"img_width\":384,\"editable\":true}]'),
				(42, 'Lookbook 17', '', '', 384, 682, 'lookbook-update-2.jpg', '[{\"id\":\"1535614308359\",\"top\":136,\"left\":230,\"width\":30,\"height\":30,\"slug\":\"more-cute-things\",\"img_height\":682,\"img_width\":384,\"editable\":true},{\"id\":\"1535614330080\",\"top\":564,\"left\":276,\"width\":30,\"height\":30,\"slug\":\"suspension-archives\",\"img_height\":682,\"img_width\":384,\"editable\":true}]'),
				(43, 'Lookbook 18', '', '', 384, 682, 'lookbook-update-3.jpg', '[{\"id\":\"1535614357801\",\"top\":99,\"left\":214,\"width\":30,\"height\":30,\"slug\":\"suspension-archives\",\"img_height\":682,\"img_width\":384,\"editable\":true},{\"id\":\"1535614379262\",\"top\":537,\"left\":113,\"width\":30,\"height\":30,\"slug\":\"girl-dress-suppliers\",\"img_height\":682,\"img_width\":384,\"editable\":true}]'),
				(44, 'Lookbook 19', '', '', 384, 682, 'lookbook-update-4.jpg', '[{\"id\":\"1535614421887\",\"top\":119,\"left\":141,\"width\":30,\"height\":30,\"slug\":\"handmade-pillow\",\"img_height\":682,\"img_width\":384,\"editable\":true},{\"id\":\"1535614433135\",\"top\":511,\"left\":96,\"width\":30,\"height\":30,\"slug\":\"best-jean-jackets\",\"img_height\":682,\"img_width\":384,\"editable\":true}]'),
				(45, 'Lookbook 20', '', '', 384, 682, 'lookbook-update-5.jpg', '[{\"id\":\"1535614526686\",\"top\":119,\"left\":232,\"width\":30,\"height\":30,\"slug\":\"ford-boutique-cups\",\"img_height\":682,\"img_width\":384,\"editable\":true},{\"id\":\"1535614558046\",\"top\":562,\"left\":192,\"width\":30,\"height\":30,\"slug\":\"bouquet-flower-vase\",\"img_height\":682,\"img_width\":384,\"editable\":true}]'),
				(46, 'Lookbook 21', '', '', 384, 682, 'lookbook-update-6.jpg', '[{\"id\":\"1535614594110\",\"top\":98,\"left\":252,\"width\":30,\"height\":30,\"slug\":\"chaise-pied-eiffel\",\"img_height\":682,\"img_width\":384,\"editable\":true},{\"id\":\"1535614615253\",\"top\":558,\"left\":269,\"width\":30,\"height\":30,\"slug\":\"girl-dress-suppliers\",\"img_height\":682,\"img_width\":384,\"editable\":true}]');";
			dbDelta($sql_insert);
		}
    }
    $file = new bwp_lookbook_class();
    $file->create_folder_recursive(LOOKBOOK_UPLOAD_PATH);
    $file->create_folder_recursive(LOOKBOOK_UPLOAD_PATH_THUMB);
	add_option('update2prof_notice', 0,0);
}

register_activation_hook(__FILE__, 'lookbook_install');

register_deactivation_hook(__FILE__, 'lookbook_deactivate');

function lookbook_deactivate() {
    if( !function_exists( 'the_field' )) {
        update_option( 'update2prof_notice', 0 );
    }
}

// Finally initialize code
new WpbingoShortcodesClass();

	
	