<?php
if ( ! function_exists( 'fashow_setup' ) ) :

		function fashow_setup() {

			load_theme_textdomain( 'fashow', get_template_directory() . '/languages' );
			// Add RSS feed links to <head> for posts and comments.
			add_theme_support( 'automatic-feed-links' );

			// Enable support for Post Thumbnails, and declare two sizes.
			add_theme_support( 'post-thumbnails' );
			set_post_thumbnail_size( 720, 470, true );
			add_image_size( 'fashow-full-width', 1500, 981, true );
			add_theme_support( 'title-tag' );
			/*
			 * Switch default core markup for search form, comment form, and comments
			 * to output valid HTML5.
			 */
			add_theme_support( 'html5', array(
				'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
			) );

			/*
			 * Enable support for Post Formats.
			 * See http://codex.wordpress.org/Post_Formats
			 */
			add_theme_support( 'post-formats', array(
				'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
			) );

			// This theme allows users to set a custom background.
			add_theme_support( 'custom-background', apply_filters( 'fashow_custom_background_args', array(
				'default-color' => 'f5f5f5',
			) ) );

			// Custom image header
			$fashow_image_headers = array(
				'default-image' => get_template_directory_uri().'/images/logo/logo-default.png',
				'uploads'       => true
			);
			add_theme_support( 'custom-header', $fashow_image_headers );

			// Tell the TinyMCE editor to use a custom stylesheet
			add_editor_style( 'css/editor-style.css' );
			
			// This theme uses its own gallery styles.
			add_filter( 'use_default_gallery_style', '__return_false' );
			
			add_theme_support( 'woocommerce' );
		}
		endif; // fashow_setup
		add_action( 'after_setup_theme', 'fashow_setup' );


		function fashow_widgets_init() {
			register_sidebar( array(
				'name'          => esc_html__( 'Sidebar Blog', 'fashow' ),
				'id'            => 'sidebar-blog',
				'description'   => esc_html__( 'Additional sidebar that appears on the right.', 'fashow' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			) );
			register_sidebar( array(
				'name'          => esc_html__( 'Sidebar Sticky Homepage', 'fashow' ),
				'id'            => 'sidebar-sticky',
				'description'   => esc_html__( 'Additional sidebar that appears on the homepage.', 'fashow' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			) );
			register_sidebar( array(
				'name'          => esc_html__( 'Header Top Link', 'fashow' ),
				'id'            => 'top-link',
				'description'   => esc_html__( 'Main sidebar that appears on the top.', 'fashow' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			) );
			register_sidebar( array(
				'name'          => esc_html__( 'Header Top Policy', 'fashow' ),
				'id'            => 'top-policy',
				'description'   => esc_html__( 'Main sidebar that appears on the left.', 'fashow' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			) );
			register_sidebar( array(
				'name'          => esc_html__( 'Header Top Policy 2', 'fashow' ),
				'id'            => 'top-policy-2',
				'description'   => esc_html__( 'Main sidebar that appears on the left.', 'fashow' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			) );
			register_sidebar( array(
				'name'          => esc_html__( 'Sidebar Shop', 'fashow' ),
				'id'            => 'sidebar-product',
				'description'   => esc_html__( 'Main sidebar that appears on the left.', 'fashow' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			) );					
			register_sidebar( array(
				'name'          => esc_html__( 'Newsletter Popup', 'fashow' ),
				'id'            => 'newletter-popup-form',
				'description'   => esc_html__( 'Appears in the content top section of the site.', 'fashow' ),
				'before_widget' => '<aside id="%1$s" class="widget clearfix %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			) );	
			register_sidebar( array(
				'name'          => esc_html__( 'Menu Categories', 'fashow' ),
				'id'            => 'menu-categories',
				'description'   => esc_html__( 'Appears in the content top section of the site.', 'fashow' ),
				'before_widget' => '<aside id="%1$s" class="widget clearfix %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			) );	
			register_sidebar( array(
				'name'          => esc_html__( 'Menu Right', 'fashow' ),
				'id'            => 'menu-right',
				'description'   => esc_html__( 'Appears in the content top section of the site.', 'fashow' ),
				'before_widget' => '<aside id="%1$s" class="widget clearfix %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			) );		
		}
		add_action( 'widgets_init', 'fashow_widgets_init' );

		function fashow_fonts_url() {
			$fonts_url = '';
			$hind = _x( 'on', 'Hind font: on or off', 'fashow' );
			$dosis = _x( 'on', 'Dosis font: on or off', 'fashow' );
			$dancingscript = _x( 'on', 'Dancing Script font: on or off', 'fashow' );
			$abrilfatface = _x( 'on', 'Abril Fatface font: on or off', 'fashow' );
			$playfair = _x( 'on', 'Playfair Display font: on or off', 'fashow' );

			if ( 'off' !== $hind || 'off' !== $dosis || 'off' !== $dancingscript || 'off' !== $abrilfatface || 'off' !== $playfair ) {
				$font_families = array();
				 
				if ( 'off' !== $hind ) {
				$font_families[] = 'Hind:300,400,500,600,700';
				}

				if ( 'off' !== $dosis ) {
				$font_families[] = 'Dosis:200,300,400,500,600,700,800';
				}

				if ( 'off' !== $dancingscript ) {
				$font_families[] = 'Dancing Script';
				}
				 
				if ( 'off' !== $abrilfatface ) {
				$font_families[] = 'Abril Fatface:400';
				}

				if ( 'off' !== $playfair ) {
				$font_families[] = 'Playfair Display:400';
				}
				
				$config_fonts = fashow_config_font();
				foreach($config_fonts as $key => $selector_fonts){
					if(isset($selector_fonts['font-family']) && $selector_fonts['font-family']){
						$font = str_replace(" ","+",$selector_fonts['font-family']);
						$font_default=implode(",",$font_families);
						$pos = strpos($font_default, $font);
						if ($pos === false)
							$font_families[] =	$font;
					}
				} 

				$query_args = array(
					'family' =>	urlencode( implode( '|', $font_families ) ),
					'subset' =>	urlencode( 'latin,latin-ext' ),
				);
				 
				$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
			
			}
			 
			return esc_url_raw( $fonts_url );
		}
		
		function fashow_scripts_styles() {
			wp_enqueue_style( 'fashow-fonts', fashow_fonts_url(), array(), null );
		}
		
		add_action( 'wp_enqueue_scripts', 'fashow_scripts_styles' );	
		
		function fashow_add_scripts() {
			// Load our main stylesheet.
			wp_enqueue_style( 'fashow-style', get_stylesheet_uri() );

			// Load the Internet Explorer specific stylesheet.
			wp_enqueue_style( 'fashow-ie', get_template_directory_uri() . '/css/ie.css', array( 'fashow-style' ), '20131205' );
			wp_style_add_data( 'fashow-ie', 'conditional', 'lt IE 9' );

			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}
			
			wp_enqueue_script('bootstrap',get_template_directory_uri().'/js/bootstrap.min.js', array('jquery'), null, true);
			wp_enqueue_script('jquery-mmenu-all',get_template_directory_uri().'/js/jquery.mmenu.all.min.js', array('jquery'), null, true);
			wp_enqueue_script('jquery-slick',get_template_directory_uri().'/js/slick.min.js',array('jquery'), null, true);
			wp_enqueue_script('instafeed',get_template_directory_uri().'/js/instafeed.min.js', array('jquery'), null, true);
			wp_enqueue_script('jquery-countdown',get_template_directory_uri().'/js/jquery.countdown.min.js', array('jquery'), null, true);
			wp_enqueue_script('jquery-fancybox', get_template_directory_uri().'/js/jquery.fancybox.min.js', array('jquery'), null, true);
			wp_enqueue_script( 'jquery-elevatezoom', get_template_directory_uri() . '/js/jquery.elevatezoom.js' , array('jquery'), null, true );
			wp_enqueue_script( 'jquery-swipebox', get_template_directory_uri() . '/js/jquery.swipebox.min.js' , array('jquery'), null, true );
			wp_enqueue_script( 'jquery-sticky-kit', get_template_directory_uri() . '/js/jquery.sticky-kit.min.js' , array('jquery'), null, true );	
			wp_enqueue_script('wc-quantity-increment', get_template_directory_uri().'/js/wc-quantity-increment.min.js', array('jquery'), null, true);
			wp_register_script( 'fashow-newsletter', get_template_directory_uri() . '/js/newsletter.js', array('jquery','jquery-cookie'), null, true );
			wp_enqueue_script( 'fashow-newsletter' );
			$direction = fashow_get_direction(); 
			if( is_rtl() || $direction == "rtl"){
				wp_enqueue_style( 'bootstrap-rtl',get_template_directory_uri().'/css/bootstrap-rtl.css' );
			}else{
				wp_enqueue_style( 'bootstrap', get_template_directory_uri().'/css/bootstrap.css' );
			}
			wp_enqueue_style('fancybox', get_template_directory_uri().'/css/jquery.fancybox.css', array(), null);
			wp_enqueue_style( 'mmenu-all', get_template_directory_uri().'/css/jquery.mmenu.all.css' );
			wp_enqueue_style('slick', get_template_directory_uri().'/css/slick/slick.css', array(), null);
			wp_enqueue_style( 'font-awesome',get_template_directory_uri().'/css/font-awesome.css' );
			wp_enqueue_style( 'materia',get_template_directory_uri().'/css/materia.css' );
			wp_enqueue_style( 'icofont',get_template_directory_uri().'/css/icofont.css' );
			wp_enqueue_style( 'animate',get_template_directory_uri().'/css/animate.css' );
			wp_enqueue_style( 'ionicons',get_template_directory_uri().'/css/ionicons.css' );
			wp_enqueue_style( 'rpg-awesome',get_template_directory_uri().'/css/rpg-awesome.css' );
			wp_enqueue_style( 'simple-line-icons', get_template_directory_uri().'/css/simple-line-icons.css' );
			add_filter( 'woocommerce_enqueue_styles', '__return_false' );	
		}
		add_action( 'wp_enqueue_scripts', 'fashow_add_scripts' );
		
		function fashow_admin_style() {
		  wp_enqueue_style('fashow-admin-styles', get_template_directory_uri().'/inc/admin/css/options.css');
		}
		add_action('admin_enqueue_scripts', 'fashow_admin_style');	
?>