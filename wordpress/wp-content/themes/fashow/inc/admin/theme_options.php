<?php

/**
 * Fashow Settings Options
 */

if (!class_exists('Redux_Framework_fashow_settings')) {

    class Redux_Framework_fashow_settings {

        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if (  true == Redux_Helpers::isTheme(__FILE__) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }

        }

        public function initSettings() {

            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();
            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        function compiler_action($options, $css, $changed_values) {

        }

        function dynamic_section($sections) {

            return $sections;
        }

        function change_arguments($args) {

            return $args;
        }

        function change_defaults($defaults) {

            return $defaults;
        }

        function remove_demo() {

        }

        public function setSections() {

            $page_layouts = fashow_options_layouts();
            $sidebars = fashow_options_sidebars();
            $body_wrapper = fashow_options_body_wrapper();
            $fashow_header_type = fashow_options_header_types();
            $fashow_banners_effect = fashow_options_banners_effect();
            
            // General Settings  ------------
            $this->sections[] = array(
                'icon' => 'fa fa-home',
                'icon_class' => 'icon',
                'title' => esc_html__('General', 'fashow'),
                'fields' => array(                
                )
            );  

            // Layout Settings
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Layout', 'fashow'),
                'fields' => array(              
                    array(
                        'id'=>'layout',
                        'type' => 'image_select',
                        'title' => esc_html__('Body Wrapper', 'fashow'),
                        'options' => $body_wrapper,
                        'default' => 'full'
                    ),
                    array(
                        'id' => 'background_img',
                        'type' => 'media',
                        'title' => esc_html__('Background Image', 'fashow'),
                        'sub_desc' => '',
                        'default' => ''
                    ),
                    array(
                        'id'=>'show-newletter',
                        'type' => 'switch',
                        'title' => esc_html__('Show Newletter Form', 'fashow'),
                        'default' => false,
                        'on' => esc_html__('Show', 'fashow'),
                        'off' => esc_html__('Hide', 'fashow'),
                    ),
                    array(
                        'id' => 'background_newletter_img',
                        'type' => 'media',
                        'title' => esc_html__('Popup Newletter Image', 'fashow'),
                        'url'=> true,
                        'readonly' => false,
                        'sub_desc' => '',
                        'default' => array(
                            'url' => get_template_directory_uri() . '/images/newsletter-image.jpg'
                        )
                    ),
                    array(
                            'id' => 'back_active',
                            'type' => 'switch',
                            'title' => esc_html__('Back to top', 'fashow'),
                            'sub_desc' => '',
                            'desc' => '',
                            'default' => '11'// 1 = on | 0 = off
                            ),                          
                    array(
                            'id' => 'direction',
                            'type' => 'select',
                            'title' => esc_html__('Direction', 'fashow'),
                            'options' => array( 'ltr' => esc_html__('Left to Right', 'fashow'), 'rtl' => esc_html__('Right to Left', 'fashow') ),
                            'default' => 'ltr'
                        )        
                )
            );
            
            // Logo & Icons Settings
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Logo & Icons', 'fashow'),
                'fields' => array(
                    array(
                        'id'=>'sitelogo',
                        'type' => 'media',
                        'compiler'  => 'true',
                        'mode'      => false,
                        'title' => esc_html__('Logo', 'fashow'),
                        'desc'      => esc_html__('Upload Logo image default here.', 'fashow'),
                        'default' => array(
                            'url' => get_template_directory_uri() . '/images/logo/logo.png'
                        )
                    )
                )
            );
            
            // Header Settings
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Header', 'fashow'),
                'fields' => array(
                    array(
                        'id'=>'header_style',
                        'type' => 'image_select',
                        'full_width' => true,
                        'title' => esc_html__('Header Type', 'fashow'),
                        'options' => $fashow_header_type,
                        'default' => '2'
                    ),
                    array(
                        'id'=>'show-header-top',
                        'type' => 'switch',
                        'title' => esc_html__('Show Header Top', 'fashow'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'fashow'),
                        'off' => esc_html__('No', 'fashow'),
                    ),
                    array(
                        'id'=>'show-searchform',
                        'type' => 'switch',
                        'title' => esc_html__('Show Search Form', 'fashow'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'fashow'),
                        'off' => esc_html__('No', 'fashow'),
                    ),
                    array(
                        'id'=>'show-ajax-search',
                        'type' => 'switch',
                        'title' => esc_html__('Show Ajax Search', 'fashow'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'fashow'),
                        'off' => esc_html__('No', 'fashow')
                    ),
                    array(
                        'id'=>'limit-ajax-search',
                        'type' => 'text',
                        'title' => esc_html__('Limit Of Result Search', 'fashow'),
						'default' => 5,
						'required' => array('show-ajax-search','equals',true)
                    ),	
                    array(
                        'id'=>'search-cats',
                        'type' => 'switch',
                        'title' => esc_html__('Show Categories', 'fashow'),
                        'required' => array('search-type','equals',array('post', 'product')),
                        'default' => false,
                        'on' => esc_html__('Yes', 'fashow'),
                        'off' => esc_html__('No', 'fashow'),
                    ),
                    array(
                        'id'=>'show-wishlist',
                        'type' => 'switch',
                        'title' => esc_html__('Show Wishlist', 'fashow'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'fashow'),
                        'off' => esc_html__('No', 'fashow'),
                    ),
                    array(
                        'id'=>'show-minicart',
                        'type' => 'switch',
                        'title' => esc_html__('Show Mini Cart', 'fashow'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'fashow'),
                        'off' => esc_html__('No', 'fashow'),
                    ),	
                    array(
                        'id'=>'show-policy',
                        'type' => 'switch',
                        'title' => esc_html__('Show Policy', 'fashow'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'fashow'),
                        'off' => esc_html__('No', 'fashow'),
                    ),		
                    array(
                        'id'=>'enable-sticky-header',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Sticky Header', 'fashow'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'fashow'),
                        'off' => esc_html__('No', 'fashow'),
                    ),	
                    array(
                        'id'=>'phone',
                        'type' => 'text',
                        'title' => esc_html__('Phone', 'fashow'),
                        'default' => ''
                    ),			
                    array(
                        'id'=>'discount',
                        'type' => 'text',
                        'title' => esc_html__('Discount', 'fashow'),
                        'default' => ''
                    ),
                    array(
                        'id'=>'text',
                        'type' => 'text',
                        'title' => esc_html__('Topbar Text', 'fashow'),
                        'default' => ''
                    ) 
                )
            );
            
            // Footer Settings
            $footers = fashow_get_footers();
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Footer', 'fashow'),
                'fields' => array(
                    array(
                        'id' => 'footer_style',
                        'type' => 'image_select',
                        'title' => esc_html__('Footer Style', 'fashow'),
                        'sub_desc' => esc_html__( 'Select Footer Style', 'fashow' ),
                        'desc' => '',
                        'options' => $footers,
                        'default' => '32'
                    ),
                )
            );

            // Copyright Settings
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Copyright', 'fashow'),
                'fields' => array(
                    array(
                        'id' => "footer-copyright",
                        'type' => 'textarea',
                        'title' => esc_html__('Copyright', 'fashow'),
                        'default' => sprintf( __('&copy; Copyright %s. All Rights Reserved.', 'fashow'), date('Y') )
                    ),
                    array(
                        'id'=>'footer-payments',
                        'type' => 'switch',
                        'title' => esc_html__('Show Payments Logos', 'fashow'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'fashow'),
                        'off' => esc_html__('No', 'fashow'),
                    ),
                    array(
                        'id'=>'footer-payments-image',
                        'type' => 'media',
                        'url'=> true,
                        'readonly' => false,
                        'title' => esc_html__('Payments Image', 'fashow'),
                        'required' => array('footer-payments','equals','1'),
                        'default' => array(
                            'url' => get_template_directory_uri() . '/images/payments.png'
                        )
                    ),
                    array(
                        'id'=>'footer-payments-image-alt',
                        'type' => 'text',
                        'title' => esc_html__('Payments Image Alt', 'fashow'),
                        'required' => array('footer-payments','equals','1'),
                        'default' => ''
                    ),
                    array(
                        'id'=>'footer-payments-link',
                        'type' => 'text',
                        'title' => esc_html__('Payments Link URL', 'fashow'),
                        'required' => array('footer-payments','equals','1'),
                        'default' => ''
                    )
                )
            );

            // Page Title Settings
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Page Title', 'fashow'),
                'fields' => array(
                    array(
                        'id'=>'page_title',
                        'type' => 'switch',
                        'title' => esc_html__('Show Page Title', 'fashow'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'fashow'),
                        'off' => esc_html__('No', 'fashow'),
                    ),
                    array(
                        'id'=>'page_title_bg',
                        'type' => 'media',
                        'url'=> true,
                        'readonly' => false,
                        'title' => esc_html__('Background', 'fashow'),
                        'required' => array('page_title','equals', true),
	                    'default' => array(
                            'url' => "",
                        )							
                    ),
                    array(
                        'id' => 'breadcrumb',
                        'type' => 'switch',
                        'title' => esc_html__('Show Breadcrumb', 'fashow'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'fashow'),
                        'off' => esc_html__('No', 'fashow'),
                        'required' => array('page_title','equals', true),
                    ),
                )
            );
            
            // 404 Page Settings
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('404 Error', 'fashow'),
                'fields' => array(
                    array(
                        'id'=>'title-error',
                        'type' => 'text',
                        'title' => esc_html__('Content Page 404', 'fashow'),
                        'desc' => esc_html__('Input a block slug name', 'fashow'),
                        'default' => 'page not found'
                    ),  
                    array(
                        'id'=>'text-error',
                        'type' => 'text',
                        'title' => esc_html__('Content Page 404', 'fashow'),
                        'desc' => esc_html__('Input a block slug name', 'fashow'),
                        'default' => 'Sorry but we couldn’t find the page you are looking for.'
                    ),    
                    array(
                        'id'=>'sub-error',
                        'type' => 'text',
                        'title' => esc_html__('Content Page 404', 'fashow'),
                        'desc' => esc_html__('Input a block slug name', 'fashow'),
                        'default' => 'If difficulties persist, please contact the System Administrator of this site and report the error below...'
                    ),               
                    array(
                        'id'=>'btn-error',
                        'type' => 'text',
                        'title' => esc_html__('Button Page 404', 'fashow'),
                        'desc' => esc_html__('Input a block slug name', 'fashow'),
                        'default' => 'home page'
                    ),
                    array(
                        'id'=>'img-404',
                        'type' => 'media',
                        'compiler'  => 'true',
                        'mode'      => false,
                        'title' => esc_html__('Image', 'fashow'),
                        'desc'      => esc_html__('Upload images 404 default here.', 'fashow'),
                        'default' => array(
                            'url' => get_template_directory_uri() . '/images/image_404.png'
                        )
                    )                      
                )
            );

            // Social Share Settings
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Social Share', 'fashow'),
                'fields' => array(
                    array(
                        'id'=>'social-share',
                        'type' => 'switch',
                        'title' => esc_html__('Show Social Links', 'fashow'),
                        'desc' => esc_html__('Show social links in post and product, page, portfolio, etc.', 'fashow'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'fashow'),
                        'off' => esc_html__('No', 'fashow'),
                    ),
                    array(
                        'id'=>'share-fb',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Facebook Share', 'fashow'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'fashow'),
                        'off' => esc_html__('No', 'fashow'),
                    ),
                    array(
                        'id'=>'share-tw',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Twitter Share', 'fashow'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'fashow'),
                        'off' => esc_html__('No', 'fashow'),
                    ),
                    array(
                        'id'=>'share-linkedin',
                        'type' => 'switch',
                        'title' => esc_html__('Enable LinkedIn Share', 'fashow'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'fashow'),
                        'off' => esc_html__('No', 'fashow'),
                    ),
                    array(
                        'id'=>'share-googleplus',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Google + Share', 'fashow'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'fashow'),
                        'off' => esc_html__('No', 'fashow'),
                    ),
                    array(
                        'id'=>'share-pinterest',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Pinterest Share', 'fashow'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'fashow'),
                        'off' => esc_html__('No', 'fashow'),
                    ),
                )
            );
			
            $this->sections[] = array(
				'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Socials Link', 'fashow'),
                'fields' => array(
                    array(
                        'id'=>'socials_link',
                        'type' => 'switch',
                        'title' => esc_html__('Enable Socials link', 'fashow'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'fashow'),
                        'off' => esc_html__('No', 'fashow'),
                    ),
                    array(
                        'id'=>'link-fb',
                        'type' => 'text',
                        'title' => esc_html__('Enter Facebook link', 'fashow'),
						'default' => '#'
                    ),
                    array(
                        'id'=>'link-tw',
                        'type' => 'text',
                        'title' => esc_html__('Enter Twitter link', 'fashow'),
						'default' => '#'
                    ),
                    array(
                        'id'=>'link-linkedin',
                        'type' => 'text',
                        'title' => esc_html__('Enter LinkedIn link', 'fashow'),
						'default' => '#'
                    ),
                    array(
                        'id'=>'link-googleplus',
                        'type' => 'text',
                        'title' => esc_html__('Enter Google + link', 'fashow'),
						'default' => '#'
                    ),
                    array(
                        'id'=>'link-pinterest',
                        'type' => 'text',
                        'title' => esc_html__('Enter Pinterest link', 'fashow'),
						'default' => '#'
                    ),
                    array(
                        'id'=>'link-instagram',
                        'type' => 'text',
                        'title' => esc_html__('Enter Instagram link', 'fashow'),
						'default' => '#'
                    ),
                )
            );			

            //     The end -----------
            
            // Styling Settings  -------------
            $this->sections[] = array(
                'icon' => 'icofont icofont-brand-appstore',
                'icon_class' => 'icon',
                'title' => esc_html__('Styling', 'fashow'),
                'fields' => array(              
                )
            );  
            
            // Color & Effect Settings
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Color & Effect', 'fashow'),
                'fields' => array(
                    array(
                        'id'=>'compile-css',
                        'type' => 'switch',
                        'title' => esc_html__('Compile Css', 'fashow'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'fashow'),
                        'off' => esc_html__('No', 'fashow'),
                    ),					
                    array(
                      'id' => 'main_theme_color',
                      'type' => 'color',
                      'title' => esc_html__('Main Theme Color', 'fashow'),
                      'subtitle' => esc_html__('Select a main color for your site.', 'fashow'),
                      'default' => '#222222',
                      'transparent' => false,
					  'required' => array('compile-css','equals',array(true)),
                    ),      
                    array(
                        'id'=>'show-loading-overlay',
                        'type' => 'switch',
                        'title' => esc_html__('Loading Overlay', 'fashow'),
                        'default' => false,
                        'on' => esc_html__('Show', 'fashow'),
                        'off' => esc_html__('Hide', 'fashow'),
                    ),
                    array(
                        'id'=>'banners_effect',
                        'type' => 'image_select',
                        'full_width' => true,
                        'title' => esc_html__('Banner Effect', 'fashow'),
                        'options' => $fashow_banners_effect,
                        'default' => 'banners-effect-1'
                    )                   
                )
            );
            
            // Typography Settings
            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Typography', 'fashow'),
                'fields' => array(
                    array(
                        'id'=>'select-google-charset',
                        'type' => 'switch',
                        'title' => esc_html__('Select Google Font Character Sets', 'fashow'),
                        'default' => false,
                        'on' => esc_html__('Yes', 'fashow'),
                        'off' => esc_html__('No', 'fashow'),
                    ),
                    array(
                        'id'=>'google-charsets',
                        'type' => 'button_set',
                        'title' => esc_html__('Google Font Character Sets', 'fashow'),
                        'multi' => true,
                        'required' => array('select-google-charset','equals',true),
                        'options'=> array(
                            'cyrillic' => 'Cyrrilic',
                            'cyrillic-ext' => 'Cyrrilic Extended',
                            'greek' => 'Greek',
                            'greek-ext' => 'Greek Extended',
                            'khmer' => 'Khmer',
                            'latin' => 'Latin',
                            'latin-ext' => 'Latin Extneded',
                            'vietnamese' => 'Vietnamese'
                        ),
                        'default' => array('latin','greek-ext','cyrillic','latin-ext','greek','cyrillic-ext','vietnamese','khmer')
                    ),
                    array(
                        'id'=>'family_font_body',
                        'type' => 'typography',
                        'title' => esc_html__('Body Font', 'fashow'),
                        'google' => true,
                        'subsets' => false,
                        'font-style' => false,
                        'text-align' => false,
						'output'      => array('body'),
                        'color' => false,
                        'default'=> array(
                            'color'=>"#777777",
                            'google'=>true,
                            'font-weight'=>'400',
                            'font-family'=>'Open Sans',
                            'font-size'=>'14px',
                            'line-height' => '22px'
                        ),
                    ),
                    array(
                        'id'=>'h1-font',
                        'type' => 'typography',
                        'title' => esc_html__('H1 Font', 'fashow'),
                        'google' => true,
                        'subsets' => false,
                        'font-style' => false,
                        'text-align' => false,
                        'color' 	=> false,
						'output'      => array('body h1'),
                        'default'=> array(
                            'color'=>"#1d2127",
                            'google'=>true,
                            'font-weight'=>'400',
                            'font-family'=>'Open Sans',
                            'font-size'=>'36px',
                            'line-height' => '44px'
                        ),
                    ),
                    array(
                        'id'=>'h2-font',
                        'type' => 'typography',
                        'title' => esc_html__('H2 Font', 'fashow'),
                        'google' => true,
                        'subsets' => false,
                        'font-style' => false,
                        'text-align' => false,
                        'color' => false,
						'output'      => array('body h2'),
                        'default'=> array(
                            'color'=>"#1d2127",
                            'google'=>true,
                            'font-weight'=>'300',
                            'font-family'=>'Open Sans',
                            'font-size'=>'30px',
                            'line-height' => '40px'
                        ),
                    ),
                    array(
                        'id'=>'h3-font',
                        'type' => 'typography',
                        'title' => esc_html__('H3 Font', 'fashow'),
                        'google' => true,
                        'subsets' => false,
                        'font-style' => false,
                        'text-align' => false,
                        'color' => false,
						'output'      => array('body h3'),
                        'default'=> array(
                            'color'=>"#1d2127",
                            'google'=>true,
                            'font-weight'=>'400',
                            'font-family'=>'Open Sans',
                            'font-size'=>'25px',
                            'line-height' => '32px'
                        ),
                    ),
                    array(
                        'id'=>'h4-font',
                        'type' => 'typography',
                        'title' => esc_html__('H4 Font', 'fashow'),
                        'google' => true,
                        'subsets' => false,
                        'font-style' => false,
                        'text-align' => false,
                        'color' => false,
						'output'      => array('body h4'),
                        'default'=> array(
                            'color'=>"#1d2127",
                            'google'=>true,
                            'font-weight'=>'400',
                            'font-family'=>'Open Sans',
                            'font-size'=>'20px',
                            'line-height' => '27px'
                        ),
                    ),
                    array(
                        'id'=>'h5-font',
                        'type' => 'typography',
                        'title' => esc_html__('H5 Font', 'fashow'),
                        'google' => true,
                        'subsets' => false,
                        'font-style' => false,
                        'text-align' => false,
                        'color' => false,
						'output'      => array('body h5'),
                        'default'=> array(
                            'color'=>"#1d2127",
                            'google'=>true,
                            'font-weight'=>'600',
                            'font-family'=>'Open Sans',
                            'font-size'=>'14px',
                            'line-height' => '18px'
                        ),
                    ),
                    array(
                        'id'=>'h6-font',
                        'type' => 'typography',
                        'title' => esc_html__('H6 Font', 'fashow'),
                        'google' => true,
                        'subsets' => false,
                        'font-style' => false,
                        'text-align' => false,
                        'color' => false,
						'output'      => array('body h6'),
                        'default'=> array(
                            'color'=>"#1d2127",
                            'google'=>true,
                            'font-weight'=>'400',
                            'font-family'=>'Open Sans',
                            'font-size'=>'14px',
                            'line-height' => '18px'
                        ),
                    ),
                    array(
                        'id'=>'family_font_custom',
                        'type' => 'typography',
                        'title' => esc_html__('Custom Font', 'fashow'),
                        'google' => true,
                        'subsets' => false,
                        'font-style' => false,
                        'text-align' => false,
                        'color' => false,
                        'default'=> array(
                            'color'=>"#777777",
                            'google'=>true,
                            'font-weight'=>'400',
                            'font-family'=>'Open Sans',
                            'font-size'=>'14px',
                            'line-height' => '22px'
                        ),
                    ),
                    array(
                            'id' => 'class_font_custom',
                            'type' => 'text',
                            'title' => esc_html__('Custom Class', 'fashow'),
                            'sub_desc' => esc_html__( 'Example : .product_title .', 'fashow' ), 
                            'default' => '.product_title'
                    )                   
                )
            );

            //     The end -----------          
        
            
            if ( class_exists( 'Woocommerce' ) ) :

                $this->sections[] = array(
                    'icon' => 'icofont icofont-cart-alt',
                    'icon_class' => 'icon',
                    'title' => esc_html__('Ecommerce', 'fashow'),
                    'fields' => array(              
                    )
                );

                $this->sections[] = array(
                    'icon' => 'icofont icofont-double-right',
                    'icon_class' => 'icon',
                    'subsection' => true,
                    'title' => esc_html__('Product Archives', 'fashow'),
                    'fields' => array(
                        array(
                            'id'=>'sidebar_product',
                            'type' => 'image_select',
                            'title' => esc_html__('Page Layout', 'fashow'),
                            'options' => $page_layouts,
                            'default' => 'left'
                        ),
                        array(
                            'id'=>'woo-show-rating',
                            'type' => 'switch',
                            'title' => esc_html__('Show Rating in Woocommerce Products Widget', 'fashow'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'fashow'),
                            'off' => esc_html__('No', 'fashow'),
                        ),
                        array(
                            'id'=>'category-view-mode',
                            'type' => 'button_set',
                            'title' => esc_html__('View Mode', 'fashow'),
                            'options' => fashow_ct_category_view_mode(),
                            'default' => 'grid',
                        ),
                        array(
                            'id' => 'product_count',
                            'type' => 'text',
                            'title' => esc_html__('Shop pages show at product', 'fashow'),
                            'default' => '12',
                            'sub_desc' => esc_html__( 'Type Count Product Per Shop Page', 'fashow' ),
                        ),							
                        array(
                            'id' => 'product_col_large',
                            'type' => 'button_set',
                            'title' => esc_html__('Product Listing column Desktop', 'fashow'),
                            'options' => array(
                                    '2' => '2',
                                    '3' => '3',
                                    '4' => '4',                         
                                    '6' => '6'                          
                                ),
                            'default' => '4',
                            'sub_desc' => esc_html__( 'Select number of column on Desktop Screen', 'fashow' ),
                        ),
                        array(
                            'id' => 'product_col_medium',
                            'type' => 'button_set',
                            'title' => esc_html__('Product Listing column Medium Desktop', 'fashow'),
                            'options' => array(
                                    '2' => '2',
                                    '3' => '3',
                                    '4' => '4',                         
                                    '6' => '6'                          
                                ),
                            'default' => '3',
                            'sub_desc' => esc_html__( 'Select number of column on Medium Desktop Screen', 'fashow' ),
                        ),
                        array(
                            'id' => 'product_col_sm',
                            'type' => 'button_set',
                            'title' => esc_html__('Product Listing column Ipad Screen', 'fashow'),
                            'options' => array(
                                    '2' => '2',
                                    '3' => '3',
                                    '4' => '4',                         
                                    '6' => '6'                          
                                ),
                            'default' => '3',
                            'sub_desc' => esc_html__( 'Select number of column on Ipad Screen', 'fashow' ),
                        ),						
                        array(
                            'id'=>'category-image-hover',
                            'type' => 'switch',
                            'title' => esc_html__('Enable Image Hover Effect', 'fashow'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'fashow'),
                            'off' => esc_html__('No', 'fashow'),
                        ),
                        array(
                            'id'=>'product-stock',
                            'type' => 'switch',
                            'title' => esc_html__('Show "Out of stock" Status', 'fashow'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'fashow'),
                            'off' => esc_html__('No', 'fashow'),
                        ),
                        array(
                            'id'=>'category-hover',
                            'type' => 'switch',
                            'title' => esc_html__('Enable Hover Effect', 'fashow'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'fashow'),
                            'off' => esc_html__('No', 'fashow'),
                        ),
                        array(
                            'id'=>'product-wishlist',
                            'type' => 'switch',
                            'title' => esc_html__('Show Wishlist', 'fashow'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'fashow'),
                            'off' => esc_html__('No', 'fashow'),
                        ),						
                        array(
                            'id'=>'product_quickview',
                            'type' => 'switch',
                            'title' => esc_html__('Show Quick View', 'fashow'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'fashow'),
                            'off' => esc_html__('No', 'fashow')
                        ),
                        array(
                            'id'=>'product-quickview-label',
                            'type' => 'text',
                            'required' => array('product-quickview','equals',true),
                            'title' => esc_html__('"Quick View" Text', 'fashow'),
                            'default' => ''
                        ),
                    )
                );

                $this->sections[] = array(
                    'icon' => 'icofont icofont-double-right',
                    'icon_class' => 'icon',
                    'subsection' => true,
                    'title' => esc_html__('Single Product', 'fashow'),
                    'fields' => array(
                        array(
                            'id'=>'sidebar_detail_product',
                            'type' => 'image_select',
                            'title' => esc_html__('Page Layout', 'fashow'),
                            'options' => $page_layouts,
                            'default' => 'full'
                        ),
                        array(
                            'id'=>'product-short-desc',
                            'type' => 'switch',
                            'title' => esc_html__('Show Short Description', 'fashow'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'fashow'),
                            'off' => esc_html__('No', 'fashow'),
                        ),                  
                        array(
                            'id'=>'product-related',
                            'type' => 'switch',
                            'title' => esc_html__('Show Related Products', 'fashow'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'fashow'),
                            'off' => esc_html__('No', 'fashow'),
                        ),
                        array(
                            'id'=>'product-related-count',
                            'type' => 'text',
                            'required' => array('product-related','equals',true),
                            'title' => esc_html__('Related Products Count', 'fashow'),
                            'default' => '10'
                        ),
                        array(
                            'id'=>'product-related-cols',
                            'type' => 'button_set',
                            'required' => array('product-related','equals',true),
                            'title' => esc_html__('Related Product Columns', 'fashow'),
                            'options' => fashow_ct_related_product_columns(),
                            'default' => '4',
                        ),
                        array(
                            'id'=>'product-upsell',
                            'type' => 'switch',
                            'title' => esc_html__('Show Upsell Products', 'fashow'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'fashow'),
                            'off' => esc_html__('No', 'fashow'),
                        ),                      
                        array(
                            'id'=>'product-upsell-count',
                            'type' => 'text',
                            'required' => array('product-upsell','equals',true),
                            'title' => esc_html__('Upsell Products Count', 'fashow'),
                            'default' => '10'
                        ),
                        array(
                            'id'=>'product-upsell-cols',
                            'type' => 'button_set',
                            'required' => array('product-upsell','equals',true),
                            'title' => esc_html__('Upsell Product Columns', 'fashow'),
                            'options' => fashow_ct_related_product_columns(),
                            'default' => '3',
                        ),
                        array(
                            'id'=>'product-crosssells',
                            'type' => 'switch',
                            'title' => esc_html__('Show Crooss Sells Products', 'fashow'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'fashow'),
                            'off' => esc_html__('No', 'fashow'),
                        ),                      
                        array(
                            'id'=>'product-crosssells-count',
                            'type' => 'text',
                            'required' => array('product-crosssells','equals',true),
                            'title' => esc_html__('Crooss Sells Products Count', 'fashow'),
                            'default' => '10'
                        ),
                        array(
                            'id'=>'product-crosssells-cols',
                            'type' => 'button_set',
                            'required' => array('product-crosssells','equals',true),
                            'title' => esc_html__('Crooss Sells Product Columns', 'fashow'),
                            'options' => fashow_ct_related_product_columns(),
                            'default' => '3',
                        ),						
                        array(
                            'id'=>'product-hot',
                            'type' => 'switch',
                            'title' => esc_html__('Show "Hot" Label', 'fashow'),
                            'desc' => esc_html__('Will be show in the featured product.', 'fashow'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'fashow'),
                            'off' => esc_html__('No', 'fashow'),
                        ),
                        array(
                            'id'=>'product-hot-label',
                            'type' => 'text',
                            'required' => array('product-hot','equals',true),
                            'title' => esc_html__('"Hot" Text', 'fashow'),
                            'default' => ''
                        ),
                        array(
                            'id'=>'product-sale',
                            'type' => 'switch',
                            'title' => esc_html__('Show "Sale" Label', 'fashow'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'fashow'),
                            'off' => esc_html__('No', 'fashow'),
                        ),
                        array(
                            'id'=>'product-sale-label',
                            'type' => 'text',
                            'required' => array('product-sale','equals',true),
                            'title' => esc_html__('"Sale" Text', 'fashow'),
                            'default' => ''
                        ),
                        array(
                            'id'=>'product-sale-percent',
                            'type' => 'switch',
                            'required' => array('product-sale','equals',true),
                            'title' => esc_html__('Show Saved Sale Price Percentage', 'fashow'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'fashow'),
                            'off' => esc_html__('No', 'fashow'),
                        ),
                        array(
                            'id'=>'product-share',
                            'type' => 'switch',
                            'title' => esc_html__('Show Social Share Links', 'fashow'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'fashow'),
                            'off' => esc_html__('No', 'fashow'),
                        ),
                    )
                );

                $this->sections[] = array(
                    'icon' => 'icofont icofont-double-right',
                    'icon_class' => 'icon',
                    'subsection' => true,
                    'title' => esc_html__('Image Product', 'fashow'),
                    'fields' => array(
                        array(
                            'id'=>'product-thumbs',
                            'type' => 'switch',
                            'title' => esc_html__('Show Thumbnails', 'fashow'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'fashow'),
                            'off' => esc_html__('No', 'fashow'),
                        ),
                        array(
                            'id'=>'position-thumbs',
                            'type' => 'button_set',
                            'title' => esc_html__('Position Thumbnails', 'fashow'),
                            'options' => array('left' => esc_html__('Left', 'fashow'),
												'right' => esc_html__('Right', 'fashow'),
												'bottom' => esc_html__('Bottom', 'fashow'),
												'outsite' => esc_html__('Outsite', 'fashow')),
                            'default' => 'bottom',
							'required' => array('product-thumbs','equals',true),
                        ),						
                        array(
                            'id' => 'product-thumbs-count',
                            'type' => 'button_set',
                            'title' => esc_html__('Thumbnails Count', 'fashow'),
                            'options' => array(
                                    '2' => '2',
                                    '3' => '3',
                                    '4' => '4', 
									'5' => '5', 									
                                    '6' => '6'                          
                                ),
							'default' => '4',
							'required' => array('product-thumbs','equals',true),
                        ),
                        array(
                            'id'=>'product-image-popup',
                            'type' => 'switch',
                            'title' => esc_html__('Enable Image Popup', 'fashow'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'fashow'),
                            'off' => esc_html__('No', 'fashow'),
                        ),						
                        array(
                            'id'=>'layout-thumbs',
                            'type' => 'button_set',
                            'title' => esc_html__('Layouts Thumbnails', 'fashow'),
                            'options' => array('zoom' => esc_html__('Zoom', 'fashow'),
												'scroll' => esc_html__('Scroll', 'fashow'),
												'list' => esc_html__('List', 'fashow'),
												'list2' => esc_html__('List 2', 'fashow'),
											),	
                            'default' => 'zoom',
                        ),
                        array(
                            'id'=>'zoom-type',
                            'type' => 'button_set',
                            'title' => esc_html__('Zoom Type', 'fashow'),
                            'options' => array('inner' => esc_html__('Inner', 'fashow'), 'lens' => esc_html__('Lens', 'fashow')),
                            'default' => 'inner',
							'required' => array('layout-thumbs','equals',"zoom"),
                        ),
                        array(
                            'id'=>'zoom-scroll',
                            'type' => 'switch',
                            'title' => esc_html__('Scroll Zoom', 'fashow'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'fashow'),
                            'off' => esc_html__('No', 'fashow'),
							'required' => array('layout-thumbs','equals',"zoom"),
                        ),
                        array(
                            'id'=>'zoom-border',
                            'type' => 'text',
                            'title' => esc_html__('Border Size', 'fashow'),
                            'default' => '2',
							'required' => array('layout-thumbs','equals',"zoom"),
                        ),
                        array(
                            'id'=>'zoom-border-color',
                            'type' => 'color',
                            'title' => esc_html__('Border Color', 'fashow'),
                            'default' => '#f9b61e',
							'required' => array('layout-thumbs','equals',"zoom"),
                        ),                      
                        array(
                            'id'=>'zoom-lens-size',
                            'type' => 'text',
                            'required' => array('zoom-type','equals',array('lens')),
                            'title' => esc_html__('Lens Size', 'fashow'),
                            'default' => '200',
							'required' => array('layout-thumbs','equals',"zoom"),
                        ),
                        array(
                            'id'=>'zoom-lens-shape',
                            'type' => 'button_set',
                            'required' => array('zoom-type','equals',array('lens')),
                            'title' => esc_html__('Lens Shape', 'fashow'),
                            'options' => array('round' => esc_html__('Round', 'fashow'), 'square' => esc_html__('Square', 'fashow')),
                            'default' => 'square',
							'required' => array('layout-thumbs','equals',"zoom"),
                        ),
                        array(
                            'id'=>'zoom-contain-lens',
                            'type' => 'switch',
                            'required' => array('zoom-type','equals',array('lens')),
                            'title' => esc_html__('Contain Lens Zoom', 'fashow'),
                            'default' => true,
                            'on' => esc_html__('Yes', 'fashow'),
                            'off' => esc_html__('No', 'fashow'),
							'required' => array('layout-thumbs','equals',"zoom"),
                        ),
                        array(
                            'id'=>'zoom-lens-border',
                            'type' => 'text',
                            'required' => array('zoom-type','equals',array('lens')),
                            'title' => esc_html__('Lens Border', 'fashow'),
                            'default' => true,
							'required' => array('layout-thumbs','equals',"zoom")
                        ),
                    )
                );

            endif;

            // Blog Settings  -------------
            $this->sections[] = array(
                'icon' => 'icofont icofont-ui-copy',
                'icon_class' => 'icon',
                'title' => esc_html__('Blog', 'fashow'),
                'fields' => array(              
                )
            );      

            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Blog & Post Archives', 'fashow'),
                'fields' => array(
                    array(
                        'id'=>'post-format',
                        'type' => 'switch',
                        'title' => esc_html__('Show Post Format', 'fashow'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'fashow'),
                        'off' => esc_html__('No', 'fashow'),
                    ),
                    array(
                        'id'=>'hot-label',
                        'type' => 'text',
                        'title' => esc_html__('"HOT" Text', 'fashow'),
                        'desc' => esc_html__('Hot post label', 'fashow'),
                        'default' => ''
                    ),
                    array(
                        'id'=>'sidebar_blog',
                        'type' => 'image_select',
                        'title' => esc_html__('Page Layout', 'fashow'),
                        'options' => $page_layouts,
                        'default' => 'left'
                    ),
                    array(
                        'id' => 'layout_blog',
                        'type' => 'button_set',
                        'title' => esc_html__('Layout Blog', 'fashow'),
                        'options' => array(
                                'list'  =>  esc_html__( 'List', 'fashow' ),
                                'grid' =>  esc_html__( 'Grid', 'fashow' )
                        ),
                        'default' => 'list',
                        'sub_desc' => esc_html__( 'Select style layout blog', 'fashow' ),
                    ),
                    array(
                        'id' => 'blog_col_large',
                        'type' => 'button_set',
                        'title' => esc_html__('Blog Listing column Desktop', 'fashow'),
                        'required' => array('layout_blog','equals','grid'),
                        'options' => array(
                                '2' => '2',
                                '3' => '3',
                                '4' => '4',                         
                                '6' => '6'                          
                            ),
                        'default' => '4',
                        'sub_desc' => esc_html__( 'Select number of column on Desktop Screen', 'fashow' ),
                    ),
                    array(
                        'id' => 'blog_col_medium',
                        'type' => 'button_set',
                        'title' => esc_html__('Blog Listing column Medium Desktop', 'fashow'),
                        'required' => array('layout_blog','equals','grid'),
                        'options' => array(
                                '2' => '2',
                                '3' => '3',
                                '4' => '4',                         
                                '6' => '6'                          
                            ),
                        'default' => '3',
                        'sub_desc' => esc_html__( 'Select number of column on Medium Desktop Screen', 'fashow' ),
                    ),   
                    array(
                        'id' => 'blog_col_sm',
                        'type' => 'button_set',
                        'title' => esc_html__('Blog Listing column Ipad Screen', 'fashow'),
                        'required' => array('layout_blog','equals','grid'),
                        'options' => array(
                                '2' => '2',
                                '3' => '3',
                                '4' => '4',                         
                                '6' => '6'                          
                            ),
                        'default' => '3',
                        'sub_desc' => esc_html__( 'Select number of column on Ipad Screen', 'fashow' ),
                    ),   					
                    array(
                        'id'=>'archives-author',
                        'type' => 'switch',
                        'title' => esc_html__('Show Author', 'fashow'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'fashow'),
                        'off' => esc_html__('No', 'fashow'),
                    ),
                    array(
                        'id'=>'archives-comments',
                        'type' => 'switch',
                        'title' => esc_html__('Show Count Comments', 'fashow'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'fashow'),
                        'off' => esc_html__('No', 'fashow'),
                    ),                  
                    array(
                        'id'=>'blog-excerpt',
                        'type' => 'switch',
                        'title' => esc_html__('Show Excerpt', 'fashow'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'fashow'),
                        'off' => esc_html__('No', 'fashow'),
                    ),
                    array(
                        'id'=>'list-blog-excerpt-length',
                        'type' => 'text',
                        'required' => array('blog-excerpt','equals',true),
                        'title' => esc_html__('List Excerpt Length', 'fashow'),
                        'desc' => esc_html__('The number of words', 'fashow'),
                        'default' => '20',
                    ),
                    array(
                        'id'=>'grid-blog-excerpt-length',
                        'type' => 'text',
                        'required' => array('blog-excerpt','equals',true),
                        'title' => esc_html__('Grid Excerpt Length', 'fashow'),
                        'desc' => esc_html__('The number of words', 'fashow'),
                        'default' => '12',
                    ),                  
                )
            );

            $this->sections[] = array(
                'icon' => 'icofont icofont-double-right',
                'icon_class' => 'icon',
                'subsection' => true,
                'title' => esc_html__('Single Post', 'fashow'),
                'fields' => array(
                    array(
                        'id'=>'post-single-layout',
                        'type' => 'image_select',
                        'title' => esc_html__('Page Layout', 'fashow'),
                        'options' => $page_layouts,
                        'default' => 'left'
                    ),
                    array(
                        'id'=>'post-title',
                        'type' => 'switch',
                        'title' => esc_html__('Show Title', 'fashow'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'fashow'),
                        'off' => esc_html__('No', 'fashow'),
                    ),
                    array(
                        'id'=>'post-author',
                        'type' => 'switch',
                        'title' => esc_html__('Show Author Info', 'fashow'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'fashow'),
                        'off' => esc_html__('No', 'fashow'),
                    ),
                    array(
                        'id'=>'post-comments',
                        'type' => 'switch',
                        'title' => esc_html__('Show Comments', 'fashow'),
                        'default' => true,
                        'on' => esc_html__('Yes', 'fashow'),
                        'off' => esc_html__('No', 'fashow'),
					)
				)
			);				
						
            $this->sections[] = array(
				'id' => 'wbc_importer_section',
				'title'  => esc_html__( 'Demo Importer', 'fashow' ),
				'icon'   => 'fa fa-cloud-download',
				'desc'   => __( 'Increase your max execution time, try 40000 I know its high but trust me.<br>
				Increase your PHP memory limit, try 512MB.<br>
				1. The import process will work best on a clean install. You can use a plugin such as WordPress Reset to clear your data for you.<br>
				2. Ensure all plugins are installed beforehand, e.g. WooCommerce - any plugins that you add content to.<br>
				3. Be patient and wait for the import process to complete. It can take up to 3-5 minutes.<br>
				4. Enjoy', 'fashow' ),				
				'fields' => array(
					array(
						'id'   => 'wbc_demo_importer',
						'type' => 'wbc_importer'
					)
				)
            );				

        }

        public function setHelpTabs() {

        }
        
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                'opt_name'          => 'fashow_settings',
                'display_name'      => $theme->get('Name') . ' ' . esc_html__('Theme Options', 'fashow'),
                'display_version'   => esc_html__('Theme Version: ', 'fashow') . fashow_version,
                'menu_type'         => 'submenu',
                'allow_sub_menu'    => true,
                'menu_title'        => esc_html__('Theme Options', 'fashow'),
                'page_title'        => esc_html__('Theme Options', 'fashow'),
                'footer_credit'     => esc_html__('Theme Options', 'fashow'),

                'google_api_key' => 'AIzaSyAX_2L_UzCDPEnAHTG7zhESRVpMPS4ssII',
                'disable_google_fonts_link' => true,

                'async_typography'  => false,
                'admin_bar'         => false,
                'admin_bar_icon'       => 'dashicons-admin-generic',
                'admin_bar_priority'   => 50,
                'global_variable'   => '',
                'dev_mode'          => false,
                'customizer'        => false,
                'compiler'          => false,

                'page_priority'     => null,
                'page_parent'       => 'themes.php',
                'page_permissions'  => 'manage_options',
                'menu_icon'         => '',
                'last_tab'          => '',
                'page_icon'         => 'icon-themes',
                'page_slug'         => 'fashow_settings',
                'save_defaults'     => true,
                'default_show'      => false,
                'default_mark'      => '',
                'show_import_export' => true,
                'show_options_object' => false,

                'transient_time'    => 60 * MINUTE_IN_SECONDS,
                'output'            => false,
                'output_tag'        => false,

                'database'              => '',
                'system_info'           => false,

                'hints' => array(
                    'icon'          => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'         => 'light',
                        'shadow'        => true,
                        'rounded'       => false,
                        'style'         => '',
                    ),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect'    => array(
                        'show'          => array(
                            'effect'        => 'slide',
                            'duration'      => '500',
                            'event'         => 'mouseover',
                        ),
                        'hide'      => array(
                            'effect'    => 'slide',
                            'duration'  => '500',
                            'event'     => 'click mouseleave',
                        ),
                    ),
                ),
                'ajax_save'                 => true,
                'use_cdn'                   => true,
            );


            // Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace('-', '_', $this->args['opt_name']);
                }
            }
            $this->args['intro_text'] = sprintf('<p style="color: #0088cc">'.__('Please regenerate again default css files in <strong>Skin > Compile Default CSS</strong> after <strong>update theme</strong>.', 'fashow').'</p>', $v);
        }           

    }

	if ( !function_exists( 'wbc_extended_example' ) ) {
		function wbc_extended_example( $demo_active_import , $demo_directory_path ) {
			reset( $demo_active_import );
			$current_key = key( $demo_active_import );	
			
			if ( isset( $demo_active_import[$current_key]['directory'] ) && !empty( $demo_active_import[$current_key]['directory'] )) {
				// Setting Menus
				$primary = get_term_by( 'name', 'Main menu', 'nav_menu' );
				$primary_currency = get_term_by( 'name', 'Currency Menu', 'nav_menu' );
				$primary_language = get_term_by( 'name', 'Language Menu', 'nav_menu' );
				if ( isset( $primary->term_id ) ) {
					set_theme_mod( 'nav_menu_locations', array(
							'main_navigation' => $primary->term_id						
						)
					);
				}
				
				// Set HomePage
				$home_page = 'Home 1';	
				$page = get_page_by_title( $home_page );
				if ( isset( $page->ID ) ) {
					update_option( 'page_on_front', $page->ID );
					update_option( 'show_on_front', 'page' );
				}					
			}
		}
		// Uncomment the below
		add_action( 'wbc_importer_after_content_import', 'wbc_extended_example', 10, 2 );
	}
	
    global $reduxFashowSettings;
    $reduxFashowSettings = new Redux_Framework_fashow_settings();
}