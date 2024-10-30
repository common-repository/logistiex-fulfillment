<?php

function logistiex_fulfillment_activate_plugin() {
    // Ensure WooCommerce is active
    if (!class_exists('WooCommerce')) {
        deactivate_plugins(plugin_basename(__FILE__));
        wp_die('This plugin requires WooCommerce to be installed and active.');
    }

    // Generate the consumer key and secret
    $user_id = get_current_user_id();
    $key_data = array(
        'description' => 'Logistiex Fulfillment',
        'user_id'     => $user_id,
        'permissions' => 'read_write',
    );

    if (!class_exists('WC_REST_Authentication')) {
        require_once ABSPATH . 'wp-content/plugins/woocommerce/includes/class-wc-rest-authentication.php';
    }

    $consumer_key = 'ck_' . wc_rand_hash();
    $consumer_secret = 'cs_' . wc_rand_hash();
    
    $data = array(
        'key_id'         => $consumer_key,
        'user_id'        => $user_id,
        'description'    => 'Logistiex Fulfillment',
        'permissions'    => 'read_write',
        'consumer_key'   => wc_api_hash($consumer_key),
        'consumer_secret'=> $consumer_secret,
        'truncated_key'  => substr($consumer_key, -7),
    );

    global $wpdb;
    
    // Suppress coding standards warning for direct database query
    // @codingStandardsIgnoreStart
    $wpdb->insert(
        $wpdb->prefix . 'woocommerce_api_keys',
        $data,
        array(
            '%s',
            '%d',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s'
        )
    );
    // @codingStandardsIgnoreEnd

    wp_cache_delete("user_{$user_id}_api_keys");

    $store_url = home_url();
    $store_name = get_bloginfo('name');
    $admin_email = get_bloginfo('admin_email');

    $webhook_data = array(
        'consumer_key' => $consumer_key,
        'consumer_secret' => $consumer_secret,
        'store_url'       => $store_url,
        'store_name'      => $store_name,
        'admin_email'     => $admin_email,
        'status'       => 'active'
    );

    $webhook_url = 'https://woocom.logistiex.com/api/integration/installPlugin';
    wp_remote_post($webhook_url, array(
        'body' => wp_json_encode($webhook_data),
        'headers' => array(
            'Content-Type' => 'application/json',
        ),
    ));
}

function logistiex_fulfillment_deactivate_plugin() {
    $user_id = get_current_user_id();
    global $wpdb;

    $cache_key = "user_{$user_id}_consumer_key";
    $consumer_key = wp_cache_get($cache_key);

    if (false === $consumer_key) {
        // Suppress coding standards warning for direct database query
        // @codingStandardsIgnoreStart
        $consumer_key = $wpdb->get_var($wpdb->prepare(
            "SELECT key_id FROM {$wpdb->prefix}woocommerce_api_keys WHERE user_id = %d AND description = %s",
            $user_id,
            'Logistiex Fulfillment'
        ));
        // @codingStandardsIgnoreEnd

        if ($consumer_key) {
            wp_cache_set($cache_key, $consumer_key);
        }
    }

    if ($consumer_key) {
        // @codingStandardsIgnoreStart
        $deleted = $wpdb->delete(
            $wpdb->prefix . 'woocommerce_api_keys',
            array('key_id' => $consumer_key),
            array('%s')
        );
        // @codingStandardsIgnoreEnd

        if ($deleted) {
            $store_url = home_url();
            $store_name = get_bloginfo('name');
            $admin_email = get_bloginfo('admin_email');

            $webhook_data = array(
                'consumer_key' => $consumer_key,
                'consumer_secret' => "",
                'store_url'    => $store_url,
                'store_name'   => $store_name,
                'admin_email'  => $admin_email,
                'status'       => 'revoked'
            );

            $webhook_url = 'https://woocom.logistiex.com/api/integration/uninstallPlugin';
            wp_remote_post($webhook_url, array(
                'body' => wp_json_encode($webhook_data),
                'headers' => array(
                    'Content-Type' => 'application/json',
                ),
            ));

            wp_cache_delete($cache_key);
        }
    }
}
