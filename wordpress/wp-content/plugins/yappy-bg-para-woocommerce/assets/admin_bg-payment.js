(function () {
  if (pagenow === 'woocommerce_page_wc-settings') {

    jQuery('input.bgmask').focus(function () {
      jQuery(this).attr('type', 'text');
    });

    jQuery('input.bgmask').focusout(function () {
      jQuery(this).attr('type', 'password');
    });

    jQuery('h3.yappy-button-config').html(
      "Vista previa: <span class='yappy-button-position'>" +
      "<img id='button-blue' class='preview-yappy-button' style='display: none' src='../wp-content/plugins/yappy-bg-para-woocommerce/assets/blue.svg'></img>" +
      "<img id='button-dark' class='preview-yappy-button' style='display: none' src='../wp-content/plugins/yappy-bg-para-woocommerce/assets/dark.svg'></img>" +
      "<img id='button-frost' class='preview-yappy-button' style='display: none' src='../wp-content/plugins/yappy-bg-para-woocommerce/assets/frost.svg'></img>" +
      "<img id='button-white' class='preview-yappy-button' style='display: none' src='../wp-content/plugins/yappy-bg-para-woocommerce/assets/white.svg'></img>" +
      "</span>");

    var preSelectedColor = document.getElementById('woocommerce_yappy_payment_color_theme') ?
      document.getElementById('woocommerce_yappy_payment_color_theme').value : null;
      jQuery('#button-' + preSelectedColor).css("display", "inline");


    jQuery("select#woocommerce_yappy_payment_color_theme").change(function () {
      var selectedColor = jQuery(this).children("option:selected").val();
      jQuery('.preview-yappy-button').css("display", "none");
      jQuery('#button-' + selectedColor).css("display", "inline");
    });

    var sslFlag = document.getElementById('woocommerce_yappy_payment_ssl_flag');
    var sandbox = document.getElementById('woocommerce_yappy_payment_sandbox');

    if (sslFlag && sslFlag.value === 'true') {
      sandbox.checked = true;
      sandbox.addEventListener("click", function(event){
        event.preventDefault();
      });
    }
  }
})();
