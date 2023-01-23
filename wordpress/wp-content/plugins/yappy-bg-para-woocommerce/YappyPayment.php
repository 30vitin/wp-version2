<?php

class YappyPayment extends WC_Payment_Gateway
{

    private $bgFirma;
    private $donation;
    private $logger;

    const DOMAIN_REGEX = '/^(https:\/\/www\.|https:\/\/)?[a-zñ0-9]+([\-\.]{1}[a-zñ0-9]+)*\.[a-z]{2,10}(:[0-9]{1,5})?(\/.*)?$/';
    const ERROR_MESSAGE = 'Algo salió mal, contacta al administrador.';
    const ERROR_LOG = 'yap_error';
    const NORMAL_LOG = 'yap_normal';
    const WARN_LOG = 'yap_warning';
    const AMP = '&amp;';

    public function __construct()
    {

        $this->logger = wc_get_logger();

        $this->id = "yappy_payment";
        $this->has_fields = true;
        $this->icon = plugins_url('yappy-bg-para-woocommerce/assets/badge-portrait-brand.svg', PLUGIN_PATH);
        $this->method_title = "Botón de Pago Yappy de Banco General";
        $this->method_description = "Utiliza Yappy como método de pago en tu tienda con el Botón de Pago Yappy de Banco General.";

        $this->init_form_fields();
        $this->init_settings();

        $this->enabled = $this->get_option('enabled');
        $this->title = 'Yappy';
        if (defined('DONACION')) {
            $this->donation = DONACION === true;
        }

        add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));
        add_action('woocommerce_thankyou', array($this, 'thankyou_page'));
        add_action('woocommerce_api_pagosbg', array($this, 'callback_handler'));
        add_filter('woocommerce_order_button_text', array($this, 'custom_order_button_text'));
        add_action('woocommerce_admin_order_data_after_order_details', array($this, 'admin_order_display_delivery_order_id'), 60, 1);

        if (is_ssl()) {
            if ($this->not_update()) {
                $this->update_option('ssl_flag', 'true');
                $this->update_option('sandbox', 'yes');
            } else {
                $this->update_option('ssl_flag', 'false');
            }
        }

        if ($this->get_option('default_payment') === 'yes' && is_checkout() && !is_wc_endpoint_url()) {
            WC()->session->set('chosen_payment_method', $this->id);
        }
    }

    private function yappy_log(string $type, string $title, $dataForDebug = '')
    {
        if ($this->get_option('logs') === 'yes') {
            $log = "";
            switch ($type) {
                case self::NORMAL_LOG:
                    $logHeader = "[YAPPY LOG] " . $title;
                    break;
                case self::ERROR_LOG:
                    $logHeader = "[YAPPY LOG][ERROR] " . $title;
                    break;
                case self::WARN_LOG:
                    $logHeader = "[YAPPY LOG][WARNING] " . $title;
                    break;
                default:
                    $logHeader = "[YAPPY LOG][GENERIC] " . $title;
                    break;
            }

            if (is_array($dataForDebug)) {
                $log = $logHeader . " " . json_encode($dataForDebug);
            } else {
                $log = $logHeader . " " . $dataForDebug;
            }

            $this->logger->debug($log, array('source' => 'Yappy Debug'));
        }
    }

    public function admin_order_display_delivery_order_id($order)
    {
        $confirmation = $order->get_meta('confirmationNumber');
        if ($order->get_payment_method() === $this->id && $confirmation) {
?>
            <script type="text/javascript">
                (function($) {
                    $(document).ready(function() {
                        const element = $('.woocommerce-order-data__meta')[0];
                        const confirmation = "<?php echo $confirmation ?>";
                        if (element) {
                            const payText = $(element).text();
                            const newText = payText.replace('Yappy.', `Yappy (#${confirmation}).`);
                            $(element).text(newText);
                        }
                    });
                })(jQuery);
            </script>
        <?php
        }
    }

    public function not_update()
    {
        global $woocommerce;
        global $wp_version;
        return !version_compare($wp_version, BG_WORDPRESS_VERSION, ">=") || !version_compare($woocommerce->version, BG_WOOCOMMERCE_VERSION, ">=") || !version_compare(PHP_VERSION, BG_PHP_VERSION, ">=");
    }

    public function callback_handler()
    {
        header('Content-Type: application/json');
        $success = true;
        try {

            $orderId = $_GET['orderId'];
            $status = $_GET['status'];
            $domain = $_GET['domain'];
            $hash = $_GET['hash'];
            $order = wc_get_order($orderId);

            $decodedSecret = base64_decode($this->settings['secret']);
            $key = explode('.', $decodedSecret);
            $orderHash = hash_hmac('sha256', $orderId . $status . $domain, $key[0]);

            if ($orderHash == $hash) {
                if ('E' == $status) {
                    $order->update_meta_data('confirmationNumber', $_GET['confirmationNumber']);
                    $order->payment_complete();
                    wc_reduce_stock_levels($orderId);
                    $this->yappy_log(self::NORMAL_LOG, 'Orden aprobada', 'ORDER_ID:' . $orderId);
                } elseif ('C' == $status || 'R' == $status) {
                    $order->update_status('cancelled');
                    $this->yappy_log(self::NORMAL_LOG, 'Orden cancelada o rechazada', 'ORDER_ID: ' . $orderId);
                } else {
                    $this->yappy_log(self::ERROR_LOG, 'No se ha recibido un status válido ', $status);
                    $success = false;
                }
            } else {
                $this->yappy_log(self::ERROR_LOG, 'Firma incorrecta', $orderHash);
                $success = false;
            }
        } catch (\Throwable $th) {
            $this->yappy_log(self::ERROR_LOG, 'Error al actualizar el pedido');
            $success = false;
        }
        wp_send_json(['success' => $success]);
    }

    public function init_form_fields()
    {

        $sandboxText = __('Habilitar el modo de pruebas (sandbox)', 'woocommerce');

        $logsText = __('Habilitar Logs', 'woocommerce');


        if (!is_ssl()) {
            $sandboxText .= '<p class="description"><em>' . __('Esta opción está habilitada. Solo se podrá deshabilitar si tienes un certificado SSL y una conexión por HTTPS.', 'woocommerce-gateway-paypal-express-checkout') . '</em></p>';
        }

        $this->form_fields = apply_filters('wc_offline_form_fields', array(
            'enabled'             => array(
                'title'             => __('Activar/Desactivar:', 'woocommerce'),
                'label'             => __('Activar Botón de Pago Yappy', 'woocommerce'),
                'type'              => 'checkbox',
                'description'       => '',
                'default'           => 'no',
            ),
            'api_details'         => array(
                'title'             => __('Credenciales', 'woocommerce'),
                'type'              => 'title',
                'description'       => __('Esta información puede ser encontrada en la Banca en Línea Comercial bajo el menú de Administración > Botón de Pago Yappy.', 'woocommerce'),
            ),
            'merchantID'          => array(
                'title'             => __('ID del comercio:', 'woocommerce'),
                'type'              => 'text',
                'description'       => __('<em>Identificador único del comercio.</em>', 'woocommerce'),
                'default'           => ''
            ),
            'secret'              => array(
                'title'             => __('Clave secreta:', 'woocommerce'),
                'class'             => 'bgmask',
                'type'              => 'password',
                'description'       => __('<em>Clave alfanumérica necesaria para la conexión con Banco General.</em>', 'woocommerce'),
                'default'           => '',
            ),
            'advanced_options'    => array(
                'title'             => __('Opciones avanzadas', 'woocommerce'),
                'type'              => 'title'
            ),
            'sandbox'             => array(
                'title'             => __('Modo de pruebas:', 'woocommerce'),
                'label'             => $sandboxText,
                'type'              => 'checkbox',
                'description'       => 'Permite activar el ambiente de pruebas para probar transacciones sin ser cobradas o habilitar el ambiente de producción para comenzar a vender.',
                'desc_tip'          => true,
                'default'           => !is_ssl() ? 'yes' : 'no'
            ),
            'color_theme'         => array(
                'title'             => 'Color del botón:',
                'type'              => 'select',
                'description'       => '<em>Selecciona el estilo del botón que se ajuste mejor a tu tienda.</em>',
                'default'           => 'blue',
                'options'           => array(
                    'blue'            => 'Brand (predeterminado)',
                    'dark'            => 'Dark',
                    'frost'           =>  'Light',
                    'white'           => 'White'
                ),
                'custom_attributes' => array(
                    'required'        => true
                ),
            ),
            'yappy_button'        => array(
                'title'             => __('Vista previa: ', 'woocommerce'),
                'type'              => 'title',
                'class'             => 'yappy-button-config',
            ),
            'ssl_flag'           => array(
                'type'              => 'text',
                'class'             => 'bg-ssl-flag',
                'default'           => __(!is_ssl() ? 'true' : 'false', 'woocommerce'),
            ),
            'default_payment'             => array(
                'title'             => __('Método de pago<br/>por defecto:', 'woocommerce'),
                'label'             => __('Habilitar Yappy como método de pago por defecto', 'woocommerce'),
                'type'              => 'checkbox',
                'description'       => __('<em>Yappy será la opción de pago por defecto, sin importar el orden.</em>', 'woocommerce'),
                'default'           => 'yes',
            ),
            'logs'             => array(
                'title'             => __('Activar Logs:', 'woocommerce'),
                'label'             => $logsText,
                'type'              => 'checkbox',
                'description'       => '<em>Activa la escritura de registros, lo que hace que depurar problemas sea más fácil. El directorio debe tener permisos de escritura para que esto suceda. Esta opción puede impactar los recursos de su servidor. Recomendamos activarla solamente para depuración de errores o pruebas.</em>',
                'desc_tip'          => false,
                'default'           => 'no'
            ),
        ));
    }

    public function admin_options()
    {
        if (!is_ssl()) : ?>
            <div class="inline error">
                <p>
                    <?php _e('Para desactivar el modo de pruebas (sandbox), se requiere de un certificado SSL y una conexión segura por HTTPS.', 'woocommerce');
                    $this->yappy_log(self::WARN_LOG, 'Sin certificado SSL');
                    ?>
                </p>
            </div>
        <?php endif;

        echo '<h1>Configuración del Botón de Pago Yappy</h1>';
        echo '<h4>El Botón de Pago Yappy de Banco General es un servicio que requiere una activación previa desde la Banca en Línea Comercial. Si buscas activar el servicio de Botón de Pago Yappy con Banco General por primera vez, <a href="https://www.bgeneral.com/desarrolladores/boton-de-pago-yappy" target="_blank">entra aquí</a> y sigue los pasos.</h4>';
        echo '<table class="form-table" validate>';
        $this->generate_settings_html();
        echo '</table>';
    }

    public function needs_setup()
    {
        $required = array('merchantID', 'secret');
        foreach ($required as $key) {
            if (!$this->get_option($key)) {
                return true;
            }
        }
        return false;
    }

    public function payment_fields()
    {
        echo '<p class="mini-size text-concrete p-cool">Ten a mano tu celular y paga en línea por medio de Yappy de Banco General.<br/><a href="https://www.bgeneral.com/yappy/?utm_source=BotonDePago&utm_medium=WooCommerce&utm_campaign=QueEsEsto" target="_blank" class="about_yappy">¿Qué es Yappy?</a></p>';
    }

    public function thankyou_page()
    {
        global $wp;
        $order = new WC_Order($wp->query_vars['order-received']);
        if ($order->get_payment_method() === $this->id) {
        ?>
            <script type="text/javascript">
                (function($) {
                    $('.woocommerce-table--order-details > tfoot > tr:nth-last-child(-n+2) td').addClass('bold-font');
                })(jQuery);
            </script>
        <?php
        }
    }

    public function process_payment($order_id)
    {

        $url = API_URL . '/validateapikeymerchand';
        $decodedSecret = base64_decode($this->settings['secret']);
        $decodedArray = explode('.', $decodedSecret);
        $merchantSecret = $decodedArray[1];
        $domain = mb_strtolower(get_site_url());

        if (!preg_match(self::DOMAIN_REGEX, $domain) || strlen($domain) > 64) {
            echo "Algo salió mal: Dominio no valido = $domain";
            $this->yappy_log(self::ERROR_LOG, 'Dominio no valido', $domain);
            wc_add_notice(__(self::ERROR_MESSAGE, 'woocommerce'), 'error');
            return null;
        }

        $body = [
            'merchantId'  => $this->settings['merchantID'],
            'urlDomain' => $domain
        ];

        $body = wp_json_encode($body);

        $response = wp_remote_post(
            $url,
            array(
                'method'      => 'POST',
                'timeout'     => 10,
                'redirection' => 5,
                'httpversion' => '1.0',
                'blocking'    => true,
                'headers'     => array(
                    'Content-Type' => 'application/json',
                    'x-api-key'    => $merchantSecret,
                    'version'      => PLUGIN_VERSION
                ),
                'body'        => $body,
                'cookies'     => array()
            )
        );

        if (is_wp_error($response)) {
            $error_message = $response->get_error_message();
            echo "Algo salió mal: $error_message";
            $this->yappy_log(self::ERROR_LOG, '', $error_message);
            wc_add_notice(__(self::ERROR_MESSAGE, 'woocommerce'), 'error');
            return null;
        } else {
            $serverResponse = json_decode($response['body']);
            $jwtToken = $serverResponse->{'accessToken'};
            $result = null;

            if (isset($jwtToken)) {
                $this->yappy_log(self::NORMAL_LOG, 'Credenciales correctas');
                $this->yappy_log(self::NORMAL_LOG, 'Respuesta al validar api key ', $response);
                $order = wc_get_order($order_id);
                $taxes = $order->get_total_tax();
                $discount = $order->get_total_discount();
                $shipping = $order->get_total_shipping();
                $sub_total = $order->get_subtotal() + $shipping - $discount;
                $total = $sub_total + $taxes;
                $this->bgFirma = new Inc\Base\BgFirma(
                    $total,
                    $this->settings['merchantID'],
                    'USD',
                    $sub_total,
                    $taxes,
                    $serverResponse->{'unixTimestamp'} * 1000,
                    'YAP',
                    'VEN',
                    $order_id,
                    str_replace(self::AMP, '&', $this->get_return_url($order)),
                    str_replace(self::AMP, '&', $order->get_cancel_order_url()),
                    str_replace(self::AMP, '&', $domain),
                    $this->settings['secret'],
                    $discount,
                    $shipping
                );
                $result = array(
                    'result'     => 'success',
                    'redirect'    => $this->get_redirect_url($jwtToken, $order->get_billing_phone()),
                );
            } else {
                $this->yappy_log(self::ERROR_LOG, 'Credenciales incorrectas', $response);
                wc_add_notice(__(self::ERROR_MESSAGE, 'woocommerce'), 'error');
            }
            return $result;
        }
    }

    public function custom_order_button_text($order_button_text)
    {
        ?>
        <script type="text/javascript">
            (function($) {
                let color = "<?php echo $this->settings['color_theme'] ?>";
                const title = "<?php echo $this->donation ?>";
                const innerHTMLButton = `
            <button class="ecommerce yappy ${color}" id="bg-payment">
                ${title ? 'Donar' : 'Pagar'} con <span class="yappy-logo ${color}"></span>
            </button>
            `;
                const isMobile = /iPhone|iPod|Android/i.test(navigator.userAgent);
                if ($('#payment_method_yappy_payment').is(':checked')) {
                    const placeOrder = document.querySelector(".woocommerce-terms-and-conditions-wrapper");
                    const defaultCheckButton = document.getElementById("order_review");
                    const button = document.createElement('div');
                    const bgPayment = document.getElementById('bg-payment');
                    button.classList.add('bg-payment-container');
                    const buttonPlaceOrder = document.getElementById('place_order');
                    if (buttonPlaceOrder) {
                        buttonPlaceOrder.classList.add('bg-none');
                    }
                    if (isMobile) {
                        button.classList.add('mobile');
                    }
                    defaultCheckButton.classList.add('bg');
                    if (bgPayment) {
                        return;
                    }
                    button.innerHTML = innerHTMLButton;
                    placeOrder.append(button);

                }

                $('form.checkout').on('change', 'input[name^="payment_method"]', function() {
                    const placeOrder = document.querySelector(".woocommerce-terms-and-conditions-wrapper");
                    const defaultCheckButton = document.getElementById("order_review");
                    const button = document.createElement('div');
                    const buttonPlaceOrder = document.getElementById('place_order');
                    button.classList.add('bg-payment-container');
                    if (isMobile) {
                        button.classList.add('mobile');
                    }
                    if (this.value === 'yappy_payment') {
                        const bgPayment = document.getElementById('bg-payment');
                        if (bgPayment) {
                            return;
                        }

                        if (buttonPlaceOrder) {
                            buttonPlaceOrder.classList.add('bg-none');
                        }
                        defaultCheckButton.classList.add('bg');
                        button.innerHTML = innerHTMLButton;
                        placeOrder.append(button);
                    } else {
                        const bgContainer = document.querySelectorAll('.bg-payment-container');
                        if (buttonPlaceOrder) {
                            buttonPlaceOrder.classList.remove('bg-none');
                        }
                        bgContainer.forEach(function(el) {
                            el.remove();
                        });
                        defaultCheckButton.classList.remove('bg');
                    }
                });
            })(jQuery);
        </script><?php

                    return $order_button_text;
                }

                private function get_redirect_url($token, $billing_phone)
                {
                    $data = array(
                        'merchantId' => $this->bgFirma->getMerchantId(),
                        'total' => $this->bgFirma->getTotal(),
                        'subtotal' => $this->bgFirma->getSubtotal(),
                        'taxes' => $this->bgFirma->getTaxes(),
                        'discount' => $this->bgFirma->getDiscount(),
                        'shipping' => $this->bgFirma->getShipping(),
                        'paymentDate' => $this->bgFirma->getPaymentDate(),
                        'paymentMethod' => $this->bgFirma->getPaymentMethod(),
                        'transactionType' => $this->bgFirma->getTransactionType(),
                        'orderId' => $this->bgFirma->getOrderId(),
                        'successUrl' => $this->bgFirma->getSuccessUrl(),
                        'failUrl' => $this->bgFirma->getFailUrl(),
                        'domain' => $this->bgFirma->getDomain(),
                        'platform' => 'woocomerce',
                        'jwtToken' => $token
                    );


                    return API_URL . '?sbx=' . $this->settings['sandbox'] .
                        '&donation=' . ($this->donation ? 'yes' :  'no') .
                        '&checkoutUrl=' . wc_get_checkout_url() .
                        '&signature=' .  $this->bgFirma->createHash() .
                        '&tel=' . $this->validate_phone($billing_phone) .
                        '&' . http_build_query($data, '', '&', PHP_QUERY_RFC3986);
                }

                private function validate_phone($billing_phone)
                {
                    $billing_phone = preg_replace('/[^0-9]/', '', $billing_phone);
                    if (strlen($billing_phone) == 8 && $billing_phone[0] == '6') {
                        return $billing_phone;
                    }
                    return '';
                }
            }
