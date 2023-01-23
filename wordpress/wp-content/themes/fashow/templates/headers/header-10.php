<?php 
	$fashow_settings = fashow_global_settings();
	$show_minicart = (isset($fashow_settings['show-minicart']) && $fashow_settings['show-minicart']) ? ($fashow_settings['show-minicart']) : false;
	$show_searchform = (isset($fashow_settings['show-searchform']) && $fashow_settings['show-searchform']) ? ($fashow_settings['show-searchform']) : false;		
	$show_wishlist = (isset($fashow_settings['show-wishlist']) && $fashow_settings['show-wishlist']) ? ($fashow_settings['show-wishlist']) : false;
?>
<h1 class="bwp-title hide"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
<header id='bwp-header' class="bwp-header header-v10">
	<div class='header-wrapper '>
		<div class="header-content">
				<div class="header-logo">
					<?php fashow_header_logo(); ?>
				</div>
				<div class="header-search">
					<?php if($show_searchform && class_exists( 'WooCommerce' )){ ?>
						<div class="search-style">
							<?php fashow_search_form_product(); ?>				
						</div>
					<?php } ?>
				</div>
				<div class="header-center">
					<?php if(class_exists( 'WooCommerce' )){ ?>
						<div class="myacount-box">
							<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php echo esc_html__('My Account','fashow'); ?>"><i class="fa fa-user-o"></i></a>
						</div>
					<?php } ?>
					<?php if($show_wishlist && class_exists( 'YITH_WCWL' )){ ?>
						<div class="wishlist-box">
							<a href="<?php echo get_permalink( get_option('yith_wcwl_wishlist_page_id') ); ?>"><i class="fa fa-heart-o"></i></a>
						</div>
					<?php } ?>
					<?php if($show_minicart && class_exists( 'WooCommerce' )){ ?>
					<div class="wpbingoCartTop">
						<?php fashow_top_cart(); ?>
					</div>
					<?php } ?>
				</div>
				<div class="wpbingo-menu-mobile wpbingo-menu-style">
					<?php fashow_top_menu(); ?>
				</div>
				<div class="header-bottom hidden-sm hidden-xs">
					<?php if( isset($fashow_settings['phone']) && $fashow_settings['phone'] ) : ?>
						<div class="phone">
							<i class="fa fa-phone"></i><span class="phone-number"><?php echo esc_html($fashow_settings['phone']); ?></span>
						</div>
					<?php endif; ?>
					<?php if( isset($fashow_settings['text']) && $fashow_settings['text'] ) : ?>
						<div class="email">
							<i class="fa fa-envelope-o"></i><?php echo esc_html($fashow_settings['text']); ?>
						</div>
					<?php endif; ?>
				</div>
		</div>
	</div><!-- End header-wrapper -->
</header><!-- End #bwp-header -->