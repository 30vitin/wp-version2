	<?php 
		$fashow_settings = fashow_global_settings();
		$enable_sticky_header = ( isset($fashow_settings['enable-sticky-header']) && $fashow_settings['enable-sticky-header'] ) ? ($fashow_settings['enable-sticky-header']) : false;
		$show_minicart = (isset($fashow_settings['show-minicart']) && $fashow_settings['show-minicart']) ? ($fashow_settings['show-minicart']) : false;
		$show_searchform = (isset($fashow_settings['show-searchform']) && $fashow_settings['show-searchform']) ? ($fashow_settings['show-searchform']) : false;		
		$show_wishlist = (isset($fashow_settings['show-wishlist']) && $fashow_settings['show-wishlist']) ? ($fashow_settings['show-wishlist']) : false;
	?>
	<h1 class="bwp-title hide"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
	<header id='bwp-header' class="bwp-header header-v5">
		<?php if(isset($fashow_settings['show-header-top']) && $fashow_settings['show-header-top']){ ?>
		<div id="bwp-topbar">
			<div class="container">
				<div class="inner">
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-6 topbar-leftr">
							<?php if( isset($fashow_settings['discount']) && $fashow_settings['discount'] ) : ?>
								<div class="discount hidden-xs">
									<?php echo esc_html($fashow_settings['discount']); ?>
								</div>
							<?php endif; ?>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 topbar-right">
							<?php if(is_active_sidebar('top-link')){ ?>
								<div class="block-top-link pull-right">			
									<?php dynamic_sidebar( 'top-link' ); ?>			
								</div>
							<?php } ?>	
						</div>
					</div>
				</div>
			</div>	
		</div>
		<?php } ?>
		<div class='header-wrapper '>
			<div class="container">
				<div class='header-content' data-sticky_header="<?php echo esc_attr($enable_sticky_header); ?>">
					<div class="row">
						<div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 header-logo">
							<?php fashow_header_logo(); ?>
						</div>
						<div class="col-lg-8 col-md-8 col-sm-6 col-xs-6 wpbingo-menu-mobile text-center">
							<?php fashow_top_menu(); ?>
						</div>
						<div class="col-lg-2 col-md-2 col-sm-6 col-xs-6 header-right">							
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
							<!-- Begin Search -->
							<?php if($show_searchform && class_exists( 'WooCommerce' )){ ?>
							<div class="search-box pull-right">
								<div class="search-toggle"><i class="ion ion-ios-search-strong"></i></div>
							</div>
							<?php } ?>
							<!-- End Search -->		
						</div>
					</div>
				</div>
			</div>
		</div><!-- End header-wrapper -->

		
	</header><!-- End #bwp-header -->