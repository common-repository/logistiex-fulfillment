<?php
/*
Plugin Name: Logistiex-Fulfillment
Description: We provide a technology backed integration with all the e-commerce platforms, storefronts and fulfilment service providers. We bring the most differentiated capabilities enabled with AI based engines delivering top class experience to its users on functionalities related with end to end fulfilment services.
Version: 1.0.3
Author: NOETIC LOGISTIEX PRIVATE LIMITED
Author URI: https://logistiex.com
License: GPLv2 or later
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Include the file containing activation functions
require_once plugin_dir_path(__FILE__) . 'includes/integration.php';

// Include the file containing webhook functions
require_once plugin_dir_path(__FILE__) . 'includes/webhooks.php';

// Include the file containing frontend functions
require_once plugin_dir_path(__FILE__) . 'frontend/index.php';

// Include the file containing trackingPage frontend and functions
require_once plugin_dir_path(__FILE__) . 'trackingPage/index.php';

// function for debounce for multiple time same webhook trigger
function logistiex_fulfillment_schedule_order_webhook($order_id) {
    // Cancel any previously scheduled webhook for this order
    if (wp_next_scheduled('logistiex_fulfillment_send_debounced_order_to_webhook', array($order_id))) {
        wp_clear_scheduled_hook('logistiex_fulfillment_send_debounced_order_to_webhook', array($order_id));
    }

    // Schedule a new webhook to trigger in 1 seconds
    wp_schedule_single_event(time() + 1, 'logistiex_fulfillment_send_debounced_order_to_webhook', array($order_id));
}

// Hook into the plugin activation action
register_activation_hook(__FILE__, 'logistiex_fulfillment_activate_plugin');

// Register deactivation hook
register_deactivation_hook(__FILE__, 'logistiex_fulfillment_deactivate_plugin');

// Hook into order creation
add_action('woocommerce_new_order', 'logistiex_fulfillment_send_order_to_webhook', 10, 1);

// Hook into order updation
// add_action('woocommerce_update_order', 'logistiex_fulfillment_send_order_to_webhook', 10, 1);
add_action('woocommerce_update_order', 'logistiex_fulfillment_schedule_order_webhook', 10, 1);

// debounce for multiple time same webhook trigger
add_action('logistiex_fulfillment_send_debounced_order_to_webhook', 'logistiex_fulfillment_send_order_to_webhook');

// Add Custom Menu in Frontend Under Woocommerce for logistiex_fulfillment Org Setting
add_action('admin_menu', 'logistiex_fulfillment_menu_item');

// Add action to display tracking information on the order details page
add_action('woocommerce_order_details_after_order_table', 'logistiex_fulfillment_display_order_tracking_info');
