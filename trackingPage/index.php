<?php
function logistiex_fulfillment_enqueue_custom_scripts_and_styles() {
    // Define a version number for your assets
    $version = '1.0.3'; // Update this version number whenever you make changes to your CSS or JS files

    // Register the CSS file with version
    wp_register_style('logistiex-fulfillment-custom-styles', esc_url(plugins_url('styles.css', __FILE__)), [], $version);
    // Enqueue the CSS file
    wp_enqueue_style('logistiex-fulfillment-custom-styles');

    // Register the JavaScript file with version
    wp_register_script('logistiex-fulfillment-custom-scripts', esc_url(plugins_url('script.js', __FILE__)), [], $version, true);
    // Enqueue the JavaScript file
    wp_enqueue_script('logistiex-fulfillment-custom-scripts');

    // Check if we are on a WooCommerce order page
    if (is_wc_endpoint_url('order-received') || is_wc_endpoint_url('view-order')) {
        global $wp;
        $order_id = absint($wp->query_vars['order-received'] ?? $wp->query_vars['view-order'] ?? 0);
        if ($order_id) {
            $store_url = esc_js(get_site_url());
            wp_add_inline_script('logistiex-fulfillment-custom-scripts', 'var orderId = "' . $order_id . '"; var storeUrl = "' . $store_url . '";');
        }
    }
}

add_action('wp_enqueue_scripts', 'logistiex_fulfillment_enqueue_custom_scripts_and_styles');

function logistiex_fulfillment_display_order_tracking_info($order) {
    ?>
    <h3><?php esc_html_e('Tracking Information', 'logistiex-fulfillment'); ?></h3>
    <div id="logistiex-fulfillment-tracking-info">
        <div id="logistiex-fulfillment-loaderDiv" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
            <div class="logistiex-fulfillment-loader"></div>
            <p style="font-weight: bold; font-size: 16px; color: #777777; margin-top: 15px;">
                <?php esc_html_e('Fetching Tracking URL, please wait...', 'logistiex-fulfillment'); ?>
            </p>
        </div>
        <div id="logistiex-fulfillment-tracking-content" style="display: none;">
            <p id="logistiex-fulfillment-tracking-url-title"><?php esc_html_e('Tracking URL:', 'logistiex-fulfillment'); ?></p>
            <a id="logistiex-fulfillment-tracking-url" href="" target="_blank"><?php esc_html_e('link', 'logistiex-fulfillment'); ?></a>
        </div>
        <p id="logistiex-fulfillment-tracking-none" style="display: none;"></p>
    </div>
    <?php
}
?>
