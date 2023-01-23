<?php
	add_action( 'init', 'fashow_button_product' );
	add_action( 'init', 'fashow_woocommerce_single_product_summary' );
	add_filter( 'fashow_custom_category', 'woocommerce_maybe_show_product_subcategories' );
	
	function fashow_button_product(){
		$fashow_settings = fashow_global_settings();
		//Button List Product
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
		add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 25 );
		//Cart
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');
			add_action('woocommerce_before_shop_loop_item', 'fashow_woocommerce_template_loop_add_to_cart', 50 );
		//Whishlist
		if(isset($fashow_settings['product-wishlist']) && $fashow_settings['product-wishlist'] && class_exists( 'YITH_WCWL' ) ){
			add_action('woocommerce_before_shop_loop_item', 'fashow_add_loop_wishlist_link', 20 );	
		}	
		//Quickview
		add_action('woocommerce_before_shop_loop_item', 'fashow_quickview', 40 );	
	}

	function fashow_woocommerce_single_product_summary(){
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
		add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 15 );
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash');	
		add_action( 'woocommerce_after_add_to_cart_button', 'fashow_add_loop_wishlist_link', 30 );
		add_action( 'woocommerce_single_product_summary', 'fashow_add_social', 40 );
	}
	
	/* Ajax Search */
	add_action( 'wp_ajax_fashow_search_products_ajax', 'fashow_search_products_ajax' );
	add_action( 'wp_ajax_nopriv_fashow_search_products_ajax', 'fashow_search_products_ajax' );

	function fashow_search_products_ajax(){
		$character = (isset($_GET['character']) && $_GET['character'] ) ? $_GET['character'] : '';
		$limit = (isset($_GET['limit']) && $_GET['limit'] ) ? $_GET['limit'] : 5;
	
		$args = array(
			'post_type' 			=> 'product',
			'post_status'    		=> 'publish',
			'ignore_sticky_posts'   => 1,	  
			's' 					=> $character,
			'posts_per_page'		=> $limit
		);
		
		$list = new WP_Query( $args );

		$json = array();
		if ($list->have_posts()) {
			while($list->have_posts()): $list->the_post();
			global $product, $post;
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $product->id ), 'shop_catalog' );
			$json[] = array(
				'product_id' => $product->id,
				'name'       => $product->get_title(),		
				'image'		 =>  $image[0],
				'link'		 =>  get_permalink( $product->id ),
				'price'      =>  $product->get_price_html(),
			);			
			endwhile;
		}
		die (json_encode($json));
	}	
	
	function fashow_get_tax_attribute( $taxonomy ) {
		global $wpdb;

		$attr = substr( $taxonomy, 3 );
		$attr = $wpdb->get_row( "SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies WHERE attribute_name = '$attr'" );

		return $attr;
	}	
	
	function fashow_woocommerce_template_loop_add_to_cart( $args = array() ) {
		global $product;

		if ( $product ) {
			$defaults = array(
				'quantity' => 1,
				'class'    => implode( ' ', array_filter( array(
						'button',
						'product_type_' . $product->get_type(),
						$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : 'read_more',
						$product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
				) ) ),
			);

			$args = apply_filters( 'woocommerce_loop_add_to_cart_args', wp_parse_args( $args, $defaults ), $product );

			wc_get_template( 'loop/add-to-cart.php', $args );
		}
	}	
	
	function fashow_add_excerpt_in_product_archives() {
		global $post;
		if ( ! $post->post_excerpt ) return;		
		echo '<div class="item-description item-description2">'.wp_trim_words( $post->post_excerpt, 35 ).'</div>';
	}	

	
	/*add second thumbnail loop product*/
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
	add_action( 'woocommerce_before_shop_loop_item_title', 'fashow_woocommerce_template_loop_product_thumbnail', 10 );
	function fashow_product_thumbnail( $size = 'shop_catalog', $placeholder_width = 0, $placeholder_height = 0  ) {
		global $fashow_settings,$product;
		$html = '';
		$id = get_the_ID();
		$gallery = get_post_meta($id, '_product_image_gallery', true);
		$attachment_image = '';
		if(!empty($gallery)) {
			$gallery = explode(',', $gallery);
			$first_image_id = $gallery[0];
			$attachment_image = wp_get_attachment_image($first_image_id , $size, false, array('class' => 'hover-image back'));
		}
		
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $product->get_id() ), '' );
			if ( has_post_thumbnail() ){
				if( $attachment_image && $fashow_settings['category-image-hover']){
					$html .= '<div class="product-thumb-hover">';
					$html .= '<a href="' . get_the_permalink() . '" class="woocommerce-LoopProduct-link">';
					$html .= (get_the_post_thumbnail( $product->get_id(), $size )) ? get_the_post_thumbnail( $product->get_id(), $size ): '<img src="'.get_template_directory_uri().'/images/place_product.jpg" alt="'. esc_attr__('No thumb', 'fashow').'">';
					if($fashow_settings['category-image-hover']){
						$html .= $attachment_image;
					}
					$html .= '</a>';	
					$html .= '</div>';				
				}else{
					$html .= '<a href="' . get_the_permalink() . '" class="woocommerce-LoopProduct-link">';		
					$html .= (get_the_post_thumbnail( $product->get_id(), $size )) ? get_the_post_thumbnail( $product->get_id(), $size ): '<img src="'.get_template_directory_uri().'/images/place_product.jpg" alt="'. esc_attr__('No thumb', 'fashow').'">';
					$html .= '</a>';
				}			
			}else{
				$html .= '<a href="' . get_the_permalink() . '" class="woocommerce-LoopProduct-link">';		
				$html .= '<img src="'.get_template_directory_uri().'/images/place_product.jpg" alt="'. esc_attr__('No thumb', 'fashow').'">';
				$html .= '</a>';	
			}
	

		/* quickview */
		return $html;
	}
	
	function fashow_woocommerce_template_loop_product_thumbnail(){
		echo fashow_product_thumbnail();
	}	
	//Button List Product
	/*********QUICK VIEW PRODUCT**********/

	function fashow_product_quick_view_scripts() {	
		wp_enqueue_script('wc-add-to-cart-variation');
	}
	add_action( 'wp_enqueue_scripts', 'fashow_product_quick_view_scripts' );	
	
	function fashow_quickview(){
		global $product;
		$quickview = fashow_get_config('product_quickview'); 
		if( $quickview ) : 
			echo '<span class="product-quickview"><a href="#" data-product_id="'.esc_attr($product->get_id()).'" class="quickview quickview-button quickview-'.esc_attr($product->get_id()).'" >'.apply_filters( 'out_of_stock_add_to_cart_text', 'Quick View' ).' <i class="ion ion-ios-search-strong"></i>'.'</a></span>';
		endif;
	}

	add_action("wp_ajax_fashow_quickviewproduct", "fashow_quickviewproduct");
	add_action("wp_ajax_nopriv_fashow_quickviewproduct", "fashow_quickviewproduct");
	
	function fashow_quickviewproduct(){
		echo fashow_content_product();exit();
	}
	
	function fashow_content_product(){
		$productid = (isset($_REQUEST["product_id"]) && $_REQUEST["product_id"]>0) ? $_REQUEST["product_id"] : 0;
		$query_args = array(
			'post_type'	=> 'product',
			'p'			=> $productid
		);
		$outputraw = $output = '';
		$r = new WP_Query($query_args);
		if($r->have_posts()){ 

			while ($r->have_posts()){ $r->the_post(); setup_postdata($r->post);
				ob_start();
				wc_get_template_part( 'content', 'quickview-product' );
				$outputraw = ob_get_contents();
				ob_end_clean();
			}
		}
		$output = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $outputraw);
		
		return $output;	
	}
	//Wish list
	
	function fashow_add_loop_wishlist_link(){	
		if ( in_array( 'yith-woocommerce-wishlist/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ){
			echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );
		}
	}
	function fashow_add_social() {
		if ( shortcode_exists( 'social_share' ) ) :
			echo '<div class="social-icon">';
				echo '<div class="social-title">' . esc_html__( 'Share:', 'fashow' ) . '</div>';
				echo do_action( 'woocommerce_share' );
				echo do_shortcode( "[social_share]" );
			echo '</div>';
		endif;	
	}
	
	function fashow_add_thumb_single_product() {
		echo '<div class="image-thumbnail-list">';
		do_action( 'woocommerce_product_thumbnails' );
		echo '</div>';
	}
	
	function fashow_get_class_item_product(){
		$fashow_settings = fashow_global_settings();
		$product_col_large = 12 /(fashow_get_config('product_col_large',4));	
		$product_col_medium = 12 /(fashow_get_config('product_col_medium',3));
		$product_col_sm 	= 12 /(fashow_get_config('product_col_sm',1));
		$class_item_product = 'col-lg-'.$product_col_large.' col-md-'.$product_col_medium.' col-sm-'.$product_col_sm;
		
		return $class_item_product;
	}

	function fashow_catalog_perpage(){
		$fashow_settings = fashow_global_settings();
		$query_string = fashow_get_query_string();
		parse_str($query_string, $params);
		$query_string 	= '?'.$query_string;
		$per_page 	=   (isset($fashow_settings['product_count']) && $fashow_settings['product_count'])  ? (int)$fashow_settings['product_count'] : 12;
		$product_count = (isset($params['product_count']) && $params['product_count']) ? ($params['product_count']) : $per_page;
		?>
		<div class="fashow-woocommerce-sort-count">
			<div class="woocommerce-sort-count pwb-dropdown dropdown">
				<span class="pwb-dropdown-toggle dropdown-toggle" data-toggle="dropdown">
					<?php echo esc_attr($per_page); ?>
				</span>
				<ul class="pwb-dropdown-menu dropdown-menu">
					<li data-value="<?php echo esc_attr($per_page); 	?>" <?php if ($product_count == $per_page){?> class="active" <?php } ?> ><a href="<?php echo fashow_addURLParameter($query_string, 'product_count', $per_page); ?>"><?php echo esc_attr($per_page); ?></a></li>
					<li data-value="<?php echo esc_attr($per_page*2); 	?>" <?php if ($product_count == $per_page*2){?> class="active" <?php } ?> ><a href="<?php echo fashow_addURLParameter($query_string, 'product_count', $per_page*2); ?>"><?php echo esc_attr($per_page*2); ?></a></li>
					<li data-value="<?php echo esc_attr($per_page*3); 	?>" <?php if ($product_count == $per_page*3){?> class="active" <?php } ?> ><a href="<?php echo fashow_addURLParameter($query_string, 'product_count', $per_page*3); ?>"><?php echo esc_attr($per_page*3); ?></a></li>
				</ul>
			</div>		
		</div>
    <?php }	
	
	add_filter('loop_shop_per_page', 'fashow_loop_shop_per_page');

	function fashow_loop_shop_per_page() {
		$fashow_settings = fashow_global_settings();
		$query_string = fashow_get_query_string();
		parse_str($query_string, $params);
		$per_page 	=   (isset($fashow_settings['product_count']) && $fashow_settings['product_count'])  ? (int)$fashow_settings['product_count'] : 12;
		$product_count = (isset($params['product_count']) && $params['product_count']) ? ($params['product_count']) : $per_page;
		return $product_count;
	}	
	
	function fashow_found_posts(){
		wc_get_template( 'loop/woocommerce-found-posts.php' );
	}	
	
	remove_action('woocommerce_before_main_content', 'fashow_woocommerce_breadcrumb', 20);	
	remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
	remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
	
	function fashow_search_form_product(){ ?>
		<?php
			$class_ajax_search 	= "";	 
			$ajax_search 		= fashow_get_config('show-ajax-search',false);
			$limit_ajax_search 		= fashow_get_config('limit-ajax-search',5);
			if($ajax_search){
				$class_ajax_search = "ajax-search";
			}
		?>
		<form role="search" method="get" class="searchform search-from <?php echo esc_attr($class_ajax_search); ?>" action="<?php echo esc_url(home_url( '/' )); ?>" data-admin="<?php echo admin_url( 'admin-ajax.php', 'fashow' ); ?>" data-noresult="<?php echo esc_html__("No Result","fashow") ; ?>" data-limit="<?php echo esc_attr($limit_ajax_search); ?>">
			<input type="hidden" name="post_type" value="product" />
			<button class="searchsubmit btn" type="submit">
				<i class="ion ion-ios-search-strong"></i>
			</button>
			<input type="text" value="<?php echo get_search_query(); ?>" name="s"  class="input-search s" autocomplete="off" placeholder="<?php echo esc_attr__( 'Search', 'fashow' ); ?>..."/>
			<?php if($ajax_search){ ?>
				<ul class="result-search-products">
				</ul>
			<?php } ?>
		</form>
	<?php }
	
	function fashow_button_filter(){
		$html = '<a class="button-filter-toggle hidden-xs hidden-sm">'.esc_html__( 'Filter', 'fashow' ).'</a>';
		echo wp_kses_post($html);
	}	
	
	function fashow_image_single_product(){
		$fashow_settings = fashow_global_settings();
		$class = new stdClass;
		$class->show_thumb = isset($fashow_settings['product-thumbs']) ? $fashow_settings['product-thumbs'] : true;
		$position = (isset($fashow_settings['position-thumbs']) && $fashow_settings['position-thumbs']) ? $fashow_settings['position-thumbs'] : "bottom";
		$position = get_post_meta( get_the_ID(), 'product_position_thumb', true ) ? get_post_meta( get_the_ID(), 'product_position_thumb', true ) : $position;
		$class->position = $position;
		
		if($class->show_thumb && $position == "outsite"){
			add_action( 'woocommerce_single_product_summary', 'fashow_add_thumb_single_product', 50 );
		}	
		
		if($position == 'left' || $position == "right"){
			$class->class_thumb = "col-sm-2";
			$class->class_data_image = 'data-vertical="true" data-verticalswiping="true"';
			$class->class_image = "col-sm-10";
		}else{
			$class->class_thumb = $class->class_image = "col-sm-12";
			$class->class_data_image = "";
		}
		
		if(isset($fashow_settings['product-thumbs-count']) && $fashow_settings['product-thumbs-count'])
			$product_count_thumb = 	$fashow_settings['product-thumbs-count'];
		else
			$product_count_thumb = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
		
		$product_count_thumb = get_post_meta( get_the_ID(), 'product_count_thumb', true ) ? get_post_meta( get_the_ID(), 'product_count_thumb', true ) : $product_count_thumb;
		
		$class->product_count_thumb =	$product_count_thumb;
		
		$product_video = fashow_check_video_product();
		if($product_video)
			$class->product_layout_thumb =	"video";
		else{
			$product_layout_thumb = (isset($fashow_settings['layout-thumbs']) && $fashow_settings['layout-thumbs']) ? $fashow_settings['layout-thumbs'] : "zoom";
			$product_layout_thumb = get_post_meta( get_the_ID(), 'product_layout_thumb', true ) ? get_post_meta( get_the_ID(), 'product_layout_thumb', true ) : $product_layout_thumb;
			$class->product_layout_thumb =	$product_layout_thumb;
		}	
		
		return $class;
	}
	
	function fashow_check_video_product(){
		global $product;
		$check_video = false;
		if(class_exists('YITH_WC_Audio_Video')){
			$video_url = yit_get_prop( $product, '_video_url' );
			if( !empty( $video_url ) )
				$check_video = true;
		}
		return $check_video;
	}
	
	function fashow_category_top_bar(){
		$sidebar_product = fashow_category_sidebar();
		remove_action('woocommerce_before_shop_loop','woocommerce_result_count',20); 
		add_action('woocommerce_before_shop_loop','fashow_display_view', 10);
		add_action('woocommerce_before_shop_loop','fashow_found_posts', 20);
		add_action('woocommerce_before_shop_loop','woocommerce_catalog_ordering', 30);
		add_action('woocommerce_before_shop_loop','fashow_catalog_perpage', 35);
		if($sidebar_product == 'full'){
			add_action('woocommerce_before_shop_loop','fashow_button_filter', 25);
		}	
		do_action( 'woocommerce_before_shop_loop' );
	}
	
	function fashow_category_bottom(){
		add_action('woocommerce_after_shop_loop','woocommerce_result_count', 20);
		do_action( 'woocommerce_after_shop_loop' );
	}
	
	function fashow_top_cart(){
		global $woocommerce; ?>
		<div id="cart" class="top-cart">
			<a class="cart-icon" href="<?php echo get_permalink( wc_get_page_id( 'cart' ) ); ?>" title="<?php esc_attr_e('View your shopping cart', 'fashow'); ?>">
				<i class="ion ion-bag"></i>
			</a>
		</div>		
<?php } ?>