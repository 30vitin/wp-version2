	<?php 
		$fashow_settings = fashow_global_settings();
		$show_minicart = (isset($fashow_settings['show-minicart']) && $fashow_settings['show-minicart']) ? ($fashow_settings['show-minicart']) : false;
		$enable_sticky_header = ( isset($fashow_settings['enable-sticky-header']) && $fashow_settings['enable-sticky-header'] ) ? ($fashow_settings['enable-sticky-header']) : false;
		$show_searchform = (isset($fashow_settings['show-searchform']) && $fashow_settings['show-searchform']) ? ($fashow_settings['show-searchform']) : false;
		$show_wishlist = (isset($fashow_settings['show-wishlist']) && $fashow_settings['show-wishlist']) ? ($fashow_settings['show-wishlist']) : false;
	?>
	<h1 class="bwp-title hide"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
	<header id='bwp-header' class="bwp-header header-v3">
		<div class='header-wrapper '>
			<div class="header-content" data-sticky_header="<?php echo esc_attr($fashow_settings['enable-sticky-header']); ?>">
				<div class="container">	
					<div class="header-top">
						<div class="row">
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 header-logo">
								<?php fashow_header_logo(); ?>
							</div>
							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 header-right">												
								<?php if($show_searchform && class_exists( 'WooCommerce' )){ ?>
									<div class="search-style pull-right">
										<?php fashow_search_form_product(); ?>				
									</div>
								<?php } ?>
								
								<?php if($show_wishlist && class_exists( 'YITH_WCWL' )){ ?>
									<div class="wishlist-box pull-right">
										<a href="<?php echo get_permalink( get_option('yith_wcwl_wishlist_page_id') ); ?>"><i class="fa fa-heart-o"></i></a>
									</div>
								<?php } ?>
								
								<?php if($show_minicart && class_exists( 'WooCommerce' )){ ?>
									<div class="wpbingoCartTop pull-right">
										<?php get_template_part( 'woocommerce/minicart-ajax' ); ?>
									</div>
								<?php } ?>	
							</div>
						</div>	
					</div>
				</div>
			</div>

		</div><!-- End header-wrapper -->

		
	</header><!-- End #bwp-header -->