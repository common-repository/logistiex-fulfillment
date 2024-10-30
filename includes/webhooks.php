<?php

// Function to get all tax rates
function logistiex_fulfillment_get_all_tax_details() {
    // Ensure WooCommerce is active
    if (!class_exists('WooCommerce')) {
        return false;
    }

    // Get all tax classes
    $tax_classes = WC_Tax::get_tax_classes();

    // Get all tax rates
    $all_tax_rates = [];
    foreach ($tax_classes as $tax_class) {
        $tax_class_rates = WC_Tax::get_rates_for_tax_class($tax_class);
        $all_tax_rates = array_merge($all_tax_rates, $tax_class_rates);
    }

    // Include standard rates as well
    $standard_rates = WC_Tax::get_rates_for_tax_class('');
    $all_tax_rates = array_merge($all_tax_rates, $standard_rates);

    // Return all tax details
    return $all_tax_rates;
}

// Function to get tax rate details by ID
function logistiex_fulfillment_get_tax_rate_details_by_id($tax_rate_id) {
    $all_tax_details = logistiex_fulfillment_get_all_tax_details();

    foreach ($all_tax_details as $tax_detail) {
        if ($tax_detail->tax_rate_id == $tax_rate_id) {
            return $tax_detail;
        }
    }

    return null;
}

function logistiex_fulfillment_send_order_to_webhook($order_id) {
    $order = wc_get_order($order_id);

    // Get the entire order data
    $order_data = $order->get_data();
    $order_data['line_items'] = [];
    
    // Get line items data
    foreach ($order->get_items() as $item_id => $item) {
        $product = $item->get_product();
        $line_item = $item->get_data();
        $line_item['product'] = $product->get_data();

        // Get item discounts
        $line_item['discount'] = $item->get_subtotal() - $item->get_total();

        // Get tax details for the line item
        $line_item['tax_details'] = [];
        foreach ($item->get_taxes()['total'] as $tax_rate_id => $tax_total) {
            $tax_detail = logistiex_fulfillment_get_tax_rate_details_by_id($tax_rate_id);
            if($tax_detail){
                $line_item['tax_details'][] = [
                    'tax_rate_id' => $tax_rate_id,
                    'tax_rate' => $tax_detail->tax_rate,
                    'tax_name' => $tax_detail->tax_rate_name,
                    'tax_total' => "$tax_total",
                ];
            }
        }
        
        $order_data['line_items'][] = $line_item;
    }
    
    // Get shipping data
    $order_data['shipping_lines'] = [];
    foreach ($order->get_shipping_methods() as $shipping_item_id => $shipping_item) {
        $order_data['shipping_lines'][] = $shipping_item->get_data();
    }
    
    // Get fee data
    $order_data['fee_lines'] = [];
    foreach ($order->get_fees() as $fee_item_id => $fee_item) {
        $order_data['fee_lines'][] = $fee_item->get_data();
    }
    
    // Get coupon data
    $order_data['coupon_lines'] = [];
    foreach ($order->get_coupon_codes() as $coupon_code) {
        $coupon = new WC_Coupon($coupon_code);
        $order_data['coupon_lines'][] = $coupon->get_data();
    }

    // Retrieve store information with default empty strings
    $store_address     = get_option('woocommerce_store_address', '');
    $store_address_2   = get_option('woocommerce_store_address_2', '');
    $store_city        = get_option('woocommerce_store_city', '');
    $store_postcode    = get_option('woocommerce_store_postcode', '');
    $store_raw_country = get_option('woocommerce_default_country', '');

    // Split the country/state
    $split_country = explode(":", $store_raw_country);
    $store_country = isset($split_country[0]) ? $split_country[0] : '';
    $store_state   = isset($split_country[1]) ? $split_country[1] : '';

    // Store email and phone with default empty strings
    $store_email = get_option('woocommerce_email_from_address', '');
    $store_phone = get_option('woocommerce_store_phone', '');

    // Retrieve store owner's first and last name
    $admin_user_id = get_option('woocommerce_store_admin_user_id'); // Ensure this option is set with the correct user ID
    $store_owner_first_name = '';
    $store_owner_last_name = '';
    
    if ($admin_user_id) {
        $admin_user = get_userdata($admin_user_id);
        if ($admin_user) {
            $store_owner_first_name = $admin_user->first_name;
            $store_owner_last_name = $admin_user->last_name;
        }
    }

    // Add store information to the payload
    $order_data['store_location'] = [
        'address_id' => 1,
        'address_1' => $store_address,
        'address_2' => $store_address_2,
        'city'      => $store_city,
        'state'     => $store_state,
        'postcode'  => $store_postcode,
        'country'   => $store_country,
        'email'     => $store_email,
        'phone'     => $store_phone,
        'first_name' => $store_owner_first_name,
        'last_name'  => $store_owner_last_name,
    ];

    // Add payment details to the payload
    $order_data['payment_details'] = [
        'payment_method' => $order->get_payment_method(),
        'payment_method_title' => $order->get_payment_method_title(),
        'payment_status' => $order->is_paid() ? 'paid' : 'pending',
    ];

    // Webhook URL
    $webhook_url = 'https://woocom.logistiex.com/api/orders/updated';

    // Send data to webhook
    wp_remote_post($webhook_url, [
        'method' => 'POST',
        'body' => wp_json_encode($order_data),
        'headers' => [
            'Content-Type' => 'application/json',
            'store_url' => get_site_url(),
        ]
    ]);
}
