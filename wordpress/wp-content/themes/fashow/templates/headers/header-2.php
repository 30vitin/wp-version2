	<?php
	$fashow_settings = fashow_global_settings();
	$enable_sticky_header = (isset($fashow_settings['enable-sticky-header']) && $fashow_settings['enable-sticky-header']) ? ($fashow_settings['enable-sticky-header']) : false;
	$show_minicart = (isset($fashow_settings['show-minicart']) && $fashow_settings['show-minicart']) ? ($fashow_settings['show-minicart']) : false;
	$show_searchform = (isset($fashow_settings['show-searchform']) && $fashow_settings['show-searchform']) ? ($fashow_settings['show-searchform']) : false;
	$show_wishlist = (isset($fashow_settings['show-wishlist']) && $fashow_settings['show-wishlist']) ? ($fashow_settings['show-wishlist']) : false;
	?>
	<h1 class="bwp-title hide"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>

	<header id='bwp-header' class="bwp-header header-v2 sticky">
		<?php if (isset($fashow_settings['show-header-top']) && $fashow_settings['show-header-top'] && 1 == 2) { ?>
			<div id="bwp-topbar">
				<div class="container">
					<div class="inner">
						<div class="row">
							<div class="col-lg-3 col-md-3 col-sm-6 topbar-leftr">
								<?php if (isset($fashow_settings['socials_link']) && $fashow_settings['socials_link']) : ?>
									<div class="block-social pull-left">
										<?php echo do_shortcode('[social_link]'); ?>
									</div>
								<?php endif; ?>
							</div>
							<div class="col-lg-6 col-md-6 hidden-sm text-center">
								<?php if (isset($fashow_settings['discount']) && $fashow_settings['discount']) : ?>
									<div class="discount hidden-sm hidden-xs">
										<?php echo esc_html($fashow_settings['discount']); ?>
									</div>
								<?php endif; ?>
							</div>
							<div class="col-lg-3 col-md-3 col-sm-6 topbar-right">
								<?php if (is_active_sidebar('top-link')) { ?>
									<div class="block-top-link pull-right">
										<?php dynamic_sidebar('top-link'); ?>
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
						<div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 header-logo">
							<?php fashow_header_logo(); ?>
						</div>
						<div class="col-lg-5 col-md-4 col-sm-12 col-xs-12 header-logo search-box-underline">
							<!-- Begin Search -->
							<?php if ($show_searchform && class_exists('WooCommerce')) { ?>
								<div class="search-box /*pull-right*/">
									<div class="/*search-toggle*/ search-icon-submit">
										<!--<i class="ion ion-ios-search-strong icon-submit-search"></i>-->

										<!--<input type="text" name="s" id="" placeholder="Que estas buscando?" class="form-control">-->
										<?php
										$class_ajax_search 	= "";
										$ajax_search 		= fashow_get_config('show-ajax-search', false);
										$limit_ajax_search 		= fashow_get_config('limit-ajax-search', 5);
										if ($ajax_search) {
											//$class_ajax_search = "ajax-search";
										}
										?>
										<form role="search" method="get" class="searchform search-from <?php echo esc_attr($class_ajax_search); ?>" action="<?php echo esc_url(home_url('/')); ?>" data-admin="<?php echo admin_url('admin-ajax.php', 'fashow'); ?>" data-noresult="<?php echo esc_html__("No Result", "fashow"); ?>" data-limit="<?php echo esc_attr($limit_ajax_search); ?>">
											<input type="hidden" name="post_type" value="product" />
											<button class="searchsubmit btn" type="submit">
												<i class="ion ion-ios-search-strong"></i>
											</button>
											<input type="text" value="<?php echo get_search_query(); ?>" name="s" class="input-search s" autocomplete="off" placeholder="Que estas buscando?" />
											<?php //if ($ajax_search) { 
											?>
											<!--<ul class="result-search-products">
												</ul>-->
											<?php //} 
											?>
										</form>
										<span class="small-text"></span>
									</div>

								</div>

							<?php } ?>
							<!-- End Search -->
						</div>



						<div class="col-lg-4 col-md-4 col-sm-8 col-xs-10 header-right">
							<?php if ($show_minicart && class_exists('WooCommerce')) { ?>
								<div class="wpbingoCartTop pull-right">
									<?php get_template_part('woocommerce/minicart-ajax'); ?>
								</div>
							<?php } ?>
							<?php if ($show_wishlist && class_exists('YITH_WCWL')) { ?>
								<div class="wishlist-box pull-right">
									<a href="http://showtest.digitalclouddev.com/my-account/"><i class="fa fa-user-o"></i>
										<span class="small-text">Mi Cuenta</span>
									</a>


								</div>
								<div class="wishlist-box pull-right">
									<a href="<?php echo get_permalink(get_option('yith_wcwl_wishlist_page_id')); ?>"><i class="fa fa-heart-o"></i>
										<span class="small-text">Wish List</span>
									</a>

								</div>
							<?php } ?>

						</div>
						<div class="col-lg-12 col-md-8 col-sm-12 col-xs-12 wpbingo-menu-mobile text-center">
							<?php fashow_top_menu(); ?>
						</div>



					</div>
				</div>
			</div><!-- End header-wrapper -->


	</header><!-- End #bwp-header -->
	<div class="bwp-header header-v2 background-mn sticky">

	</div>
