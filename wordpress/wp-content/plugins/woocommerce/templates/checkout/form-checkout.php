<?php

/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if (!defined('ABSPATH')) {
	exit;
}

//do_action('woocommerce_before_checkout_form', $checkout);

// If checkout registration is disabled and not logged in, the user cannot checkout.
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
	echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
	return;
}

?>
<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">



	<!-- por aaqui aviso-->
	<div class="row cart-checkout">



		<div class="col-md-6 car-mitted-1">

			<div class="row section-form-checkout">

				<span id="step1" class="row section-form-checkout">


					<div class="col-md-12 row">

						<?php
						$fashow_settings = fashow_global_settings();
						$sitelogo = (isset($fashow_settings['sitelogo']['url']) && $fashow_settings['sitelogo']['url']) ? $fashow_settings['sitelogo']['url'] : "";
						$page_logo_url = get_post_meta(get_the_ID(), 'page_logo', true);
						$page_logo_url = ($page_logo_url) ? $page_logo_url : $sitelogo; ?>
						<div class="wpbingoLogo logo-checkout">
							<a href="<?php echo esc_url(home_url('/')); ?>">
								<?php if ($page_logo_url) { ?>
									<img src="<?php echo esc_url($page_logo_url); ?>" alt="<?php bloginfo('name'); ?>" class="logo-site-xt-checkout" />
								<?php } else {
									$logo = get_template_directory_uri() . '/images/logo/logo.png'; ?>
									<img src="<?php echo esc_attr($logo); ?>" alt="<?php bloginfo('name'); ?>" />
								<?php } ?>
							</a>
						</div>
					</div>

					<nav aria-label="breadcrumb " class="breadcrumb-checkout">

						<ol class="breadcrumb arr-right bg-dark ">

							<li class="breadcrumb-item "><a href="#" class="text-light">Carrito</a></li>

							<li class="breadcrumb-item current">Informacion</li>

							<li class="breadcrumb-item inactive">Pagos</li>

						</ol>

					</nav>

					<div class="col-md-12 informacion-contacto">
						<h4>Información de contacto</h4>
						<hr>


					</div>


					<div class="col-md-12 form-lists">
						<p class="form-row form-row-wide validate-required validate-email" id="billing_email_field" data-priority="110">
							<label for="billing_email" class="">Dirección de correo electrónico&nbsp;
								<abbr class="required" title="obligatorio">*</abbr>
								<span class="have-account">
									¿Ya tienes una cuenta? <a href="#" class="link">Iniciar sesión</a>

								</span>
							</label>
							<!--<span class="woocommerce-input-wrapper">
							<input type="email" class="input-text form-control" name="billing_email" id="billing_email" placeholder="email" value="" autocomplete="email username">
						</span>-->
						<div class="centralize">

							<div class="input-block">
								<input type="email" name="billing_email" id="billing_email" value="" required spellcheck="false" class="input-animations required-field">

								<span class="placeholder">
									Correo electrónico
								</span>
								<span class="vali-message d-none">Introduce un email valido</span>

							</div>
						</div>

						</p>
					</div>
					<div class="col-md-12 form-lists">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked>
							<label class="form-check-label" for="flexCheckDefault">
								Enviarme novedades y ofertas por correo electrónico
							</label>
						</div>
					</div>

					<div class="col-md-12 forma-entrega">
						<h4>Forma de Entrega</h4>
						<hr>
					</div>
					<div class="col-md-12 center-col-12 xsl-mb-4">

						<div class="wrapper">
							<input type="radio" name="select-forma" id="option-1" class="check-enviar required-field" value="enviar">
							<input type="radio" name="select-forma" id="option-2" class="check-retirar required-field" value="retirar">
							<label for="option-1" class="option option-1">
								<div class="dot"></div>
								<span><i class="fa fa-truck" aria-hidden="true"></i> Enviar</span>
							</label>
							<label for="option-2" class="option option-2">
								<div class="dot"></div>
								<span><i class="fa fa-shopping-bag" aria-hidden="true"></i> Retirar</span>
							</label>
						</div>
						<div class="col-md-12 forma-notice">
							<span class="vali-message d-none">Seleccione una forma de entrega</span>

						</div>


						<div class="enviar-paquete row d-none">
							<label for=""> Seleccione lugar de envio (Flete Chavales)</label>

							<hr>
							<div class="col-md-12 forma-notice-selection">
								<span class="vali-message d-none">Seleccione un lugar de envio</span>

							</div>
							<div class="col-md-12">
								<div class="wrapper-lugar-envio">
									<input type="radio" name="select-lugar-envio" id="lugar-envio-option-1" class="option-envio" value="option-envio1">
									<label for="lugar-envio-option-1" class="option lugar-envio-option-1">
										<div class="dot"></div>
										<span class="contenido row">
											<div class="col-md-11 extra-dets-options badge-location">
												<p class="badge badge-success ">Panama - Transístmica</p>
											</div>
											<div class="col-md-11 extra-dets-options">
												<p><i class="fa fa-map-marker" aria-hidden="true"></i> En vía Transístmica, Frente a Plaza Ágora, al lado de Thermo-King, Serfrasa.</p>
												<p>De Lunes a Viernes</p>
												<p>Horario: 7:00 a.m. 7:00 p.m.</p>
											</div>
											<div class="col-md-12 extra-dets-options message-line">
												<p>Normalmente los pedidos se realizan al dia siguiente en la mañana</p>
											</div>

										</span>
									</label>

								</div>
							</div>
							<div class="col-md-12">
								<div class="wrapper-lugar-envio">
									<input type="radio" name="select-lugar-envio" id="lugar-envio-option-2" class="option-envio" value="option-envio2">
									<label for="lugar-envio-option-2" class="option lugar-envio-option-2">
										<div class="dot"></div>
										<span class="contenido row">
											<div class="col-md-11 extra-dets-options badge-location">
												<p class="badge badge-success ">Panama - San Francisco</p>
											</div>
											<div class="col-md-11 extra-dets-options">
												<p><i class="fa fa-map-marker" aria-hidden="true"></i> A un costado del Evergreen, frente a Restaurante La Jarana, diagonal a P.H. Las Terrazas de San Francisco.</p>
												<p>De Lunes a Viernes</p>
												<p>Horario: 8:00 a.m. 6:00 p.m.</p>
											</div>
											<div class="col-md-12 extra-dets-options message-line">
												<p>Normalmente los pedidos se realizan al dia siguiente en la mañana</p>
											</div>

										</span>
									</label>

								</div>

							</div>


						</div>

						<div class="retirar-paquete d-none">
							<label for=""> Seleccione lugar de retiro (Hot Living Sucursales)</label>

							<hr>
							<div class="col-md-12 forma-notice-selection">
								<span class="vali-message d-none">Seleccione un lugar de retiro</span>
							</div>

							<div class="col-md-12">
								<div class="wrapper-lugar-envio">
									<input type="radio" name="select-lugar-retiro" id="lugar-retiro-option-1" class="option-retiro" value="option-retiro-sucusal1">
									<label for="lugar-retiro-option-1" class="option lugar-retiro-option-1">
										<div class="dot"></div>
										<span class="contenido row">
											<div class="col-md-11 extra-dets-options badge-location">
												<p class="badge badge-success ">Veraguas - Santiago</p>
											</div>
											<div class="col-md-11 extra-dets-options">
												<p><i class="fa fa-map-marker" aria-hidden="true"></i> Santiago calle 10.</p>
												<p>De Lunes a Viernes</p>
												<p>Horario: 8:00 a.m. 5:00 p.m. </p>
											</div>
											<div class="col-md-12 extra-dets-options message-line">
												<p>Normalmente esta listo en 1 hora</p>
											</div>

										</span>
									</label>

								</div>
							</div>

						</div>
					</div>

					<div class="col-md-6 center-col-12 checkout-fot-left">
						<p>
							<a href="./cart"><i class="fa fa-chevron-left" aria-hidden="true"></i>
								Volver al carrito</a>
						</p>
					</div>
					<div class="col-md-6 center-col-12 btn-enviar checkout-fot-right">
						<button type="button" class="button alt wp-element-button link-section-checkout" data-tab="#step1" data-next-tab="#step2" data-valid="true" name="woocommerce_checkout_place_order2" id="place_order2" value="Continuar con el pago" data-value="Continuar con el pago">Continuar con el pago</button>
					</div>

					<div class="col-md-12">
						<hr class="line-after">
						<div class="row politics">
							<p class="mr-3">
								<a href="">Politica de rembolso</a>
							</p>
							<p class="mr-3">
								<a href="">Politica de privacidad</a>
							</p>
							<p class="mr-3">
								<a href="">Términos de servicio</a>
							</p>
						</div>
					</div>
				</span>
				<!---- step 2--->
				<span id="step2" class="row section-form-checkout  d-none">
					<div class="col-md-12 row">

						<?php
						$fashow_settings = fashow_global_settings();
						$sitelogo = (isset($fashow_settings['sitelogo']['url']) && $fashow_settings['sitelogo']['url']) ? $fashow_settings['sitelogo']['url'] : "";
						$page_logo_url = get_post_meta(get_the_ID(), 'page_logo', true);
						$page_logo_url = ($page_logo_url) ? $page_logo_url : $sitelogo; ?>
						<div class="wpbingoLogo logo-checkout">
							<a href="<?php echo esc_url(home_url('/')); ?>">
								<?php if ($page_logo_url) { ?>
									<img src="<?php echo esc_url($page_logo_url); ?>" alt="<?php bloginfo('name'); ?>" class="logo-site-xt-checkout" />
								<?php } else {
									$logo = get_template_directory_uri() . '/images/logo/logo.png'; ?>
									<img src="<?php echo esc_attr($logo); ?>" alt="<?php bloginfo('name'); ?>" />
								<?php } ?>
							</a>
						</div>
					</div>

					<nav aria-label="breadcrumb " class="breadcrumb-checkout">

						<ol class="breadcrumb arr-right bg-dark ">

							<li class="breadcrumb-item "><a href="#" class="text-light">Carrito</a></li>

							<li class="breadcrumb-item inactive">Informacion</li>

							<li class="breadcrumb-item  current">Pagos</li>

						</ol>

					</nav>

					<div class="col-md-12 form-resumen">
						<div class="row ">
							<div class="col-md-3 ">
								<p class="text-mutted f-2">Contacto</p>
							</div>
							<div class="col-md-6 ">
								<p>Vitin3093@gmail.com</p>
							</div>
							<div class="col-md-3 ">
								<p class="f-3">Cambiar</p>
							</div>
							<div class="col-md-12 hr-mr">
								<hr>
							</div>

						</div>
						<div class="row ">
							<div class="col-md-3">
								<p class="text-mutted f-2">Enviar a</p>
							</div>
							<div class="col-md-6">
								<p>(No hay ninguna dirección)</p>
							</div>
							<div class="col-md-3">
								<p class="f-3">Cambiar</p>
							</div>
							<div class="col-md-12 hr-mr">
								<hr>
							</div>
						</div>
						<div class="row ">
							<div class="col-md-3">
								<p class="text-mutted f-2">Método</p>
							</div>
							<div class="col-md-6">
								<p>
									Retirar en la tienda · Wet Dreams Los Pueblos

									Centro Comercial Los Pueblos, Local #2A1 frente a Ep Furniture, Entre la Optica Tapia y Denti Center, Panamá, Panamá</p>
							</div>
							<div class="col-md-3">
								<p class="f-3">Cambiar</p>
							</div>
						</div>


					</div>

					<div class="col-md-12 informacion-contacto">
						<h4>Pago</h4>
						<p>Todas las transacciones son seguras y están encriptadas.</p>
						<hr>
						<p>

							<button class="btn btn-primary btn-yappy-collapse" type="button" disabled>
								Yappy <img width="100" height="45" src="http://showtest.digitalclouddev.com/wp-content/uploads/2023/01/yappy-logo.webp" class="vc_single_image-im attachment-medium mlx-2" alt="" decoding="async" loading="lazy" title="pasrela">
							</button>
							<button class="btn btn-primary btn-creditcard-collapse" type="button">
								Tarjeta de credito <img width="100" height="45" src="http://showtest.digitalclouddev.com/wp-content/uploads/2023/01/visa-and-mastercard-logos-logo-visa-png-logo-visa-mastercard-png-visa-logo-white-png-awesome-logos.png" class="vc_single_image-im attachment-medium  mlx-2" alt="" decoding="async" loading="lazy" title="pasrela">
							</button>
						</p>
						<div id="collapseYappy" class="collapse in">
							<div class="card card-body">

								<div id="order_review" class="woocommerce-checkout-review-order">
									<?php do_action('woocommerce_checkout_order_review');
									?>
								</div>

							</div>
						</div>
						<div id="collapseCreditCard" class="collapse">
							<div class="card card-body">
								<span class="bagde bagde-info">Lo sentimos, En este metodo se encuentra fuera de servicio en este momento!</span>
							</div>
						</div>
					</div>
					<div class="col-md-12 ">
						<h4>Dirección de facturación</h4>
						<p>Introduce la dirección que coincida con tu tarjeta o forma de pago.</p>
						<hr>

					</div>

					<div class="row informacion-contacto m-3">
						<div class="col-md-6 form-lists">
							<p class="form-row form-row-wide validate-required validate-email" id="billing_name_field" data-priority="110">
							<div class="centralize">

								<div class="input-block">
									<input type="text" name="billing_name" id="billing_name" value="" required spellcheck="false" class="input-animations">

									<span class="placeholder">
										Nombre
									</span>
								</div>
							</div>

							</p>
						</div>
						<div class="col-md-6 form-lists">
							<p class="form-row form-row-wide validate-required validate-email" id="billing_last_name_field" data-priority="110">
							<div class="centralize">

								<div class="input-block">
									<input type="text" name="billing_last_name" id="billing_last_name" value="" required spellcheck="false" class="input-animations">

									<span class="placeholder">
										Apellido
									</span>
								</div>
							</div>

							</p>
						</div>
						<div class="col-md-12 form-lists">
							<p class="form-row form-row-wide validate-required validate-email" id="billing_empresa_field" data-priority="110">
							<div class="centralize">

								<div class="input-block">
									<input type="text" name="billing_empresa" id="billing_empresa" value="" required spellcheck="false" class="input-animations">

									<span class="placeholder">
										Empresa (opcional)
									</span>
								</div>
							</div>

							</p>
						</div>
						<div class="col-md-12 form-lists">
							<p class="form-row form-row-wide validate-required validate-email" id="billing_direccion_field" data-priority="110">
							<div class="centralize">

								<div class="input-block">
									<input type="text" name="billing_direccion" id="billing_direccion" value="" required spellcheck="false" class="input-animations">

									<span class="placeholder">
										Dirección
									</span>
								</div>
							</div>
							</p>
						</div>
						<div class="col-md-12 form-lists">
							<p class="form-row form-row-wide validate-required validate-email" id="billing_casa_field" data-priority="110">
							<div class="centralize">

								<div class="input-block">
									<input type="text" name="billing_casa" id="billing_casa" value="" required spellcheck="false" class="input-animations">

									<span class="placeholder">
										Casa, apartamento, etc. (opcional)
									</span>
								</div>
							</div>
							</p>
						</div>
						<div class="col-md-4 form-lists">
							<p class="form-row form-row-wide validate-required validate-email" id="billing_postal_code_field" data-priority="110">
							<div class="centralize">

								<div class="input-block">
									<input type="text" name="billing_postal_code" id="billing_postal_code" value="" required spellcheck="false" class="input-animations">

									<span class="placeholder">
										Código postal
									</span>
								</div>
							</div>
							</p>
						</div>
						<div class="col-md-4 form-lists">
							<p class="form-row form-row-wide validate-required validate-email" id="billing_ciudad_field" data-priority="110">
							<div class="centralize">

								<div class="input-block">
									<input type="text" name="billing_ciudad" id="billing_ciudad" value="" required spellcheck="false" class="input-animations">

									<span class="placeholder">
										Ciudad
									</span>
								</div>
							</div>
							</p>
						</div>
						<div class="col-md-4 form-lists">
							<p class="form-row form-row-wide validate-required validate-email" id="billing_region_field" data-priority="110">
							<div class="centralize">

								<div class="input-block">
									<!--
									<input type="text" name="billing_region" id="billing_region" value="" required spellcheck="false" class="input-animations">
								-->
									<select name="billing_region" id="billing_region" class="form-control filled-inp">
										<option value="Veraguas" selected>Veraguas</option>
										<option value="Bocas del toro">Bocas del toro</option>
										<option value="Chiriqui">Chiriqui</option>
										<option value="Coclé">Coclé</option>
										<option value="Colón">Colón</option>
										<option value="Darien">Darien</option>
										<option value="Embera-Wounaan">Embera-Wounaan</option>
										<option value="Herrera">Herrera</option>
										<option value="Guna Yala">Guna Yala</option>
										<option value="Los Santos">Los Santos</option>
										<option value="Ngabe-Buglé">Ngabe-Buglé</option>
										<option value="Panamá">Panamá</option>
										<option value="Panamá Oeste">Panamá Oeste</option>

									</select>
									<span class="placeholder">
										Region
									</span>
								</div>
							</div>
							</p>
						</div>
						<div class="col-md-12 form-lists">
							<p class="form-row form-row-wide validate-required validate-email" id="billing_phone_field" data-priority="110">
							<div class="centralize">

								<div class="input-block">
									<input type="text" name="billing_phone" id="billing_phone" value="" required spellcheck="false" class="input-animations">

									<span class="placeholder">
										Telefono
									</span>
								</div>
							</div>
							</p>
						</div>

					</div>


					<div class="col-md-6 center-col-12 checkout-fot-left">
						<p>
							<a href="#" class="link-section-checkout" data-tab="#step2" data-next-tab="#step1"><i class="fa fa-chevron-left" aria-hidden="true"></i>
								Volver a información</a>
						</p>
					</div>
					<!--<div class="col-md-6 center-col-12 btn-enviar checkout-fot-right">
						<button type="button" class="button alt wp-element-button" name="woocommerce_checkout_place_order2" id="place_order2" value="Pagar ahora" data-value="Pagar ahora">Pagar ahora</button>
					</div>-->
					<div class="col-md-12">
						<hr class="line-after">
						<div class="row politics">
							<p class="mr-3">
								<a href="">Politica de rembolso</a>
							</p>
							<p class="mr-3">
								<a href="">Politica de privacidad</a>
							</p>
							<p class="mr-3">
								<a href="">Términos de servicio</a>
							</p>
						</div>
					</div>


				</span>
				<!---- step 3--->



			</div>


		</div>
		<div class="col-md-4 car-mitted-2">

			<div class="section-pr1">
				<?php
				foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
					$_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
					$product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

					if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
						$product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
				?>
						<div class="row section-items-checkout">
							<div class="col-md-2 img-produc-checkout">
								<?php

								$thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);

								if (!$product_permalink) {
									echo $thumbnail; // PHPCS: XSS ok.
								} else {
									printf('<a href="%s">%s <span class="badge badge-secondary bagde-cantidad-checkout">' . $cart_item['quantity'] . '</span></a>', esc_url($product_permalink), $thumbnail); // PHPCS: XSS ok.
								}
								?>


							</div>
							<div class="col-md-6 text-produc-checkout">

								<?php
								if (!$product_permalink) {
									echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key) . '&nbsp;');
								} else {
									echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
								}

								do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);

								// Meta data.
								echo wc_get_formatted_cart_item_data($cart_item); // PHPCS: XSS ok.

								// Backorder notification.
								if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
									echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>', $product_id));
								}
								?>
							</div>
							<div class="col-md-4 total-produc-checkout">
								<p> <?php
									echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // PHPCS: XSS ok.
									?></p>
							</div>
						</div>
						<hr>

				<?php
					}
				}
				?>
			</div>

			<?php do_action('woocommerce_cart_contents'); ?>

			<div class="space-divider1">

			</div>
			<div class="row section-totals2-checkout">
				<div class="col-md-12">
					<div class="wc-proceed-to-checkout row">
						<br>

						<!--<div class="section-cupon">
							<div class="coupon">
								<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="Código de cupón">
								<div class="centralize">

									<div class="input-block">
										<input type="text" name="coupon_code" id="coupon_code" value="" class="input-animations">

										<span class="placeholder">
											Placeholder
										</span>
									</div>
								</div>
								<button type="submit" class="button wp-element-button" name="apply_coupon" value="Aplicar cupón">Aplicar cupón</button>

							</div>


						</div>-->

						<div class="col-md-8 ">
							<div class="centralize">

								<div class="input-block">
									<input type="text" name="coupon_code" id="coupon_code" value="" class="input-animations">

									<span class="placeholder ">
										Tarjeta de regalo o código de cupon
									</span>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="coupon">
								<button type="submit" class="button wp-element-button" name="apply_coupon" value="Aplicar cupón">Aplicar cupón</button>
							</div>
						</div>

						<br>
						<div class="actions">
							<input type="hidden" id="woocommerce-cart-nonce" name="woocommerce-cart-nonce" value="6412625d4c"><input type="hidden" name="_wp_http_referer" value="/cart/?removed_item=1">
						</div>
					</div>
				</div>


			</div>

			<div class="row section-totals2-checkout details-totals">

				<div class="col-md-2 text-produc-checkout">
					<p>Subtotal</p>
				</div>
				<div class="col-md-5 text-produc-checkout">

				</div>
				<div class="col-md-5 total-produc-checkout">
					<p><?php wc_cart_totals_subtotal_html(); ?></p>
				</div>

			</div>

			<div class="row section-totals2-checkout details-totals">

				<div class="col-md-2 text-produc-checkout">
					<p>Envio</p>
				</div>
				<div class="col-md-5 text-produc-checkout">

				</div>
				<div class="col-md-5 total-produc-checkout">
					<p>$0.00</p>
				</div>
			</div>

			<div class="row section-totals2-checkout details-totals">

				<div class="col-md-2 text-produc-checkout">
					<p>Impuestos</p>
				</div>
				<div class="col-md-5 text-produc-checkout">

				</div>
				<div class="col-md-5 total-produc-checkout">
					<p><?php wc_cart_totals_taxes_total_html(); ?></p>
				</div>
			</div>
			<hr class="line-after">
			<div class="row section-totals3-checkout details-totals">

				<div class="col-md-2 text-produc-checkout">
					<h4>Total</h4>
				</div>
				<div class="col-md-4 text-produc-checkout">

				</div>
				<div class="col-md-5 total-produc-checkout">
					<span class="text-muted mt-4">USD</span>
					<h4><?php wc_cart_totals_order_total_html(); ?></h4>
				</div>
			</div>

		</div>


		<!--<div class="col-md-1">

		</div>
		<div class="col-lg-5 col-md-5">
			<?php //if ($checkout->get_checkout_fields()) : 
			?>

				<?php //do_action('woocommerce_checkout_before_customer_details'); 
				?>

				<div class="col2-set" id="customer_details">
					<div class="col-1">
						<?php //do_action('woocommerce_checkout_billing'); 
						?>
					</div>

					<div class="col-2">
						<?php  ///do_action('woocommerce_checkout_shipping'); 
						?>
					</div>
				</div>

				<?php ///do_action('woocommerce_checkout_after_customer_details'); 
				?>

			<?php //endif; 
			?>

			<?php //do_action('woocommerce_checkout_before_order_review_heading'); 
			?>



		</div>
		<div class="col-lg-5 col-md-5 details-sections">
			<h3 id="order_review_heading"><?php //esc_html_e('Your order', 'woocommerce'); 
											?></h3>

			<?php //do_action('woocommerce_checkout_before_order_review'); 
			?>


			<div id="order_review" class="woocommerce-checkout-review-order">
				<?php //do_action('woocommerce_checkout_order_review'); 
				?>
			</div>
		</div>
			-->


	</div>



	<?php do_action('woocommerce_checkout_after_order_review'); ?>
</form>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>
