<?php
			/*Call to order clause*/
	function order_by_rating_post_clauses( $args ) {
		global $wpdb;

		$args['fields'] .= ", AVG( $wpdb->commentmeta.meta_value ) as average_rating ";

		$args['where'] .= " AND ( $wpdb->commentmeta.meta_key = 'rating' OR $wpdb->commentmeta.meta_key IS null ) ";

		$args['join'] .= "
			LEFT OUTER JOIN $wpdb->comments ON($wpdb->posts.ID = $wpdb->comments.comment_post_ID)
			LEFT JOIN $wpdb->commentmeta ON($wpdb->comments.comment_ID = $wpdb->commentmeta.comment_id)
		";

		$args['orderby'] = "average_rating DESC, $wpdb->posts.post_date DESC";

		$args['groupby'] = "$wpdb->posts.ID";

		return $args;
	}
	
	function category_select( $field_name, $opts = array(), $field_value = null ){
		$default_options = array(
				'multiple' => true,
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
			if (array_key_exists('allow_select_all', $opts) && $opts['allow_select_all']){
				unset($opts['allow_select_all']);
				$allow_select_all = '<option value="0">All Categories</option>';
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
		
		$categories = get_terms('product_cat');
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
	
	function bwp_timezone_offset( $countdowntime ){
		$timeOffset = 0;	
		if( get_option( 'timezone_string' ) != '' ) :
			$timezone = get_option( 'timezone_string' );
			$dateTimeZone = new DateTimeZone( $timezone );
			$dateTime = new DateTime( "now", $dateTimeZone );
			$timeOffset = $dateTimeZone->getOffset( $dateTime );
		else :
			$dateTime = get_option( 'gmt_offset' );
			$dateTime = intval( $dateTime );
			$timeOffset = $dateTime * 3600;
		endif;
		$offset =  ( $timeOffset < 0 ) ? '-' . gmdate( "H:i", abs( $timeOffset ) ) : '+' . gmdate( "H:i", $timeOffset );
		
		$date = date( 'Y/m/d H:i:s', $countdowntime );
		$date1 = new DateTime( $date );
		$cd_date =  $date1->format('Y-m-d H:i:s') . $offset;
		
		return strtotime( $cd_date ); 
	}		

	if ( ! function_exists( 'wpbingo_posted_on' ) ) :

	function wpbingo_posted_on() {
		if ( is_sticky() && is_home() && ! is_paged() ) {
			echo '<span class="featured-post">' . esc_html__( 'Sticky', 'wpbingo' ) . '</span>';
		}

		// Set up and print post meta information.
		printf( '<span class="entry-date"><time class="entry-date" datetime="%2$s">%3$s</time></span>',
			esc_url( get_permalink() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);		
	}
	endif;

	if ( ! function_exists( 'wpbingo_posted_on2' ) ) :

	function wpbingo_posted_on2() {
		if ( is_sticky() && is_home() && ! is_paged() ) {
			echo '<span class="featured-post">' . esc_html__( 'Sticky', 'wpbingo' ) . '</span>';
		}

		// Set up and print post meta information.
		printf( '<span class="entry-date"><time class="entry-date" datetime="%2$s"><span>%3$s</span> <span>%4$s</span></time></span>',
			esc_url( get_permalink() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date('j') ),
			esc_html( get_the_date('M') )
		);			

	}
	endif;

	if ( ! function_exists( 'wpbingo_posted_on3' ) ) :

	function wpbingo_posted_on3() {
		if ( is_sticky() && is_home() && ! is_paged() ) {
			echo '<span class="featured-post">' . esc_html__( 'Sticky', 'wpbingo' ) . '</span>';
		}

		// Set up and print post meta information.
		printf( '<span class="entry-date"><time class="entry-date" datetime="%2$s"><i class="fa fa-calendar"></i>%4$s %3$s</time></span>',
			esc_url( get_permalink() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date('j, Y') ),
			esc_html( get_the_date('M') )
		);			

	}
	endif;
	
	if ( ! function_exists( 'wpbingo_get_excerpt_product' ) ) :
	function wpbingo_get_excerpt_product($limit=150,$more=true){
		if (has_excerpt()) {
			$excerpt = get_the_excerpt();
		} else {
			$excerpt = get_the_content();
		}
		$excerpt = wpbingo_strip_tags($excerpt);
		$length = strlen($excerpt);
		$excerpt = substr($excerpt, 0, $limit);
		$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
		$excerpt = trim($excerpt);
		if($length > $limit && $more){
			$excerpt = $excerpt.' ...';
		} 
		$excerpt = '<p class="product-excerpt">'.$excerpt.'</p>';
		echo $excerpt;
	}
	endif;	

	if ( ! function_exists( 'wpbingo_get_excerpt' ) ) :
	function wpbingo_get_excerpt($limit = 45, $more_link = true, $more_style_block = false) {
		if (!$limit) {
			$limit = 45;
		}

		if (has_excerpt()) {
			$content = get_the_excerpt();
		} else {
			$content = get_the_content();
		}

		$content = wpbingo_strip_tags( apply_filters( 'the_content', $content ) );
		$content = explode(' ', $content, $limit);

		if (count($content) >= $limit) {
			array_pop($content);
			if ($more_link)
				$content = implode(" ",$content).'... ';
			else
				$content = implode(" ",$content).' [...]';
		} else {
			$content = implode(" ",$content);
		}
		
		$content = '<p class="post-excerpt">'.$content.'</p>';
		
		return $content;
	}
	endif;

	if ( ! function_exists( 'wpbingo_strip_tags' ) ) :
	function wpbingo_strip_tags( $content ) {
		$content = str_replace( ']]>', ']]&gt;', $content );
		$content = preg_replace("/<script.*?\/script>/s", "", $content) ? : $content;
		$content = preg_replace("/<style.*?\/style>/s", "", $content) ? : $content;
		$content = strip_tags( $content );
		return $content;
	}	
	endif;

	if(!function_exists('get_header_types')) :
		function get_header_types() {
			$header = array('' => esc_html__( 'Default', 'wpbingo' ));
			$path = get_template_directory().'/templates/headers/';
			$files = array_diff(scandir($path), array('..', '.'));
			if(count($files)>0){
				foreach ($files as  $file) {
					$name = str_replace( '.php', '', basename($file) );
					$value = str_replace( 'header-', '',$name);
					$name =  str_replace( '-', ' ', ucwords($name) );
					$header[$value] = $name;
				}
			}		
			return $header;
		}
	endif;

	if(!function_exists('get_footers_types')) :
		function get_footers_types() {
			$footer = array('' => esc_html__( 'Default', 'wpbingo' ));
			$footers = get_posts( array('posts_per_page'=>-1,
										'post_type'=>'bwp_footer',
										'orderby'          => 'name',
										'order'            => 'ASC'
								) );
			foreach ($footers as  $value) {
				$footer[$value->ID] = $value->post_title;
			}
			return $footer;
		}
	endif;
	
	if(!function_exists('wpbingo_remove_object_filter')) :
		function wpbingo_remove_object_filter($tag, $class, $method) {
			$filters = (isset($GLOBALS['wp_filter'][$tag]) && $GLOBALS['wp_filter'][$tag]) ? $GLOBALS['wp_filter'][$tag] : "";
			if (empty($filters)){
				return;
			}
			if(version_compare(get_bloginfo('version'), '4.7', '>=')) {
				$callbacks = $filters->callbacks;
			} else {
				$callbacks = $filters;
			}
			foreach ($callbacks as $priority => $filter) {
				foreach ($filter as $identifier => $function) {
					if (is_array( $function) && is_a( $function['function'][0], $class ) && $method === $function['function'][1]) {
					  remove_filter($tag, array ( $function['function'][0], $method ), $priority);
					}
				}
			}
		}
	endif;	
	
	
	if(!function_exists('wpbingo_countdown_thumbnail')) :
	function wpbingo_countdown_thumbnail() {
		global $post, $product, $woocommerce;
		$attachment_ids = $product->get_gallery_image_ids();
		$_images =array();
		if(has_post_thumbnail()){
			$_images[] = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_catalog' ));
		}else{
			$_images[] = '<img src="'. esc_url(wc_placeholder_img_src()) .'" alt="'.esc_attr__('Placeholder', 'fashow').'" />';
		}
		foreach ($attachment_ids as $attachment_id) {
			$_images[]       = wp_get_attachment_image( $attachment_id, 'shop_catalog' );
		}
		?>
		<?php if(count($_images)>0){ ?>
		<!-- Indicators -->
		<div class="countdown-thumb">
			<div class="slick-carousel" data-columns4="4" data-columns3="4" data-columns2="4" data-columns1="4" data-columns="4" data-nav="true">
				<?php foreach ($_images as $key => $image) { ?>
				<div class="item">
					<?php echo trim( $image ); ?>
				</div>
				<?php } ?>
			</div>
		</div>
		<?php }
	}	
	endif;?>