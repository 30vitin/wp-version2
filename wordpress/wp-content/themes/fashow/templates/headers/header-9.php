	<?php 
		$fashow_settings = fashow_global_settings();
		$enable_sticky_header = ( isset($fashow_settings['enable-sticky-header']) && $fashow_settings['enable-sticky-header'] ) ? ($fashow_settings['enable-sticky-header']) : false;
		$show_minicart = (isset($fashow_settings['show-minicart']) && $fashow_settings['show-minicart']) ? ($fashow_settings['show-minicart']) : false;
		$show_searchform = (isset($fashow_settings['show-searchform']) && $fashow_settings['show-searchform']) ? ($fashow_settings['show-searchform']) : false;		
		$show_wishlist = (isset($fashow_settings['show-wishlist']) && $fashow_settings['show-wishlist']) ? ($fashow_settings['show-wishlist']) : false;
	?>
	<h1 class="bwp-title hide"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
	<header id='bwp-header' class="bwp-header header-v9">
		<div class='header-wrapper'>
			<div class="container">
				<div class='header-content' data-sticky_header="<?php echo esc_attr($enable_sticky_header); ?>">
					<div class="row">
						<div class="col-lg-4 col-md-4 col-sm-6 hidden-xs header-left">
							<?php if( isset($fashow_settings['phone']) && $fashow_settings['phone'] ) : ?>
								<div class="phone">
									<i class="fa fa-phone"></i><?php esc_html_e( 'Hotline:', 'fashow' ); ?>
									<span class="phone-number"><?php echo esc_html($fashow_settings['phone']); ?></span>
								</div>
							<?php endif; ?>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-12 col-xs-6 header-logo text-center">
							<?php fashow_header_logo(); ?>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 header-right topbar-right">							
							<?php if($show_minicart && class_exists( 'WooCommerce' )){ ?>
							<div class="wpbingoCartTop pull-right">
								<?php get_template_part( 'woocommerce/minicart-ajax' ); ?>
				        	</div>
							<?php } ?>
							<?php if($show_wishlist && class_exists( 'YITH_WCWL' )){ ?>
								<div class="wishlist-box pull-right">
									<a href="<?php echo get_permalink( get_option('yith_wcwl_wishlist_page_id') ); ?>"><i class="fa fa-heart-o"></i></a>
								</div>
							<?php } ?>	
							<?php if(is_active_sidebar('top-link')){ ?>
								<div class="block-top-link pull-right">			
									<?php dynamic_sidebar( 'top-link' ); ?>			
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div><!-- End header-wrapper -->
		<div class='header-bottom'>
			<div class="container">
				<div class="row">
					<div class="col-lg-6 col-md-7 col-sm-2 col-xs-4 wpbingo-menu-mobile">
						<?php fashow_top_menu(); ?>
					</div>
					<div class="col-lg-6 col-md-5 col-sm-10 col-xs-8 header-policy">
						<?php if($show_searchform && class_exists( 'WooCommerce' )){ ?>
							<div class="search-style">
								<?php fashow_search_form_product(); ?>				
							</div>
						<?php } ?>
						<?php if(is_active_sidebar('top-policy-2')){ ?>
							<div class="block-top-policy pull-right hidden-xs">			
								<?php dynamic_sidebar( 'top-policy-2' ); ?>			
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
		
	</header><!-- End #bwp-header -->