=== Logistiex Fulfillment ===
Contributors: piyushvaish
Tags: logistics, fulfillment, woocommerce
Requires at least: 6.4
Tested up to: 6.6.1
Requires PHP: 7.4
Stable tag: 1.0.3
License: GPLv2 or later

Short Description: A powerful plugin offering seamless end-to-end fulfillment services.

Description: We provide a technology-backed integration with all the e-commerce platforms, storefronts, and fulfillment service providers. We bring the most differentiated capabilities enabled with AI-based engines delivering top-class experiences to its users on functionalities related to end-to-end fulfillment services.

== Changelog ==

= 1.0.3 =
* Initial release.

== Third-Party Services ==

This plugin interacts with backend service of NOETIC LOGISTIEX PRIVATE LIMITED for integration and data management between your WooCommerce store and our platform. Here's a brief overview of how data is handled:

* **Onboarding and Authentication**: During onboarding, sellers agree to our privacy policy and terms. We use the following endpoints to manage plugin installation and uninstallation:
  – **Install Plugin**: [https://woocom.logistiex.com/api/integration/installPlugin](https://woocom.logistiex.com/api/integration/installPlugin)
  – **Uninstall Plugin**: [https://woocom.logistiex.com/api/integration/uninstallPlugin](https://woocom.logistiex.com/api/integration/uninstallPlugin)

* **Seller Details**: To synchronize seller details, we use these endpoints:
  – **Get Seller Details**: [https://woocom.logistiex.com/api/sellerDetails/getSellerDetails](https://woocom.logistiex.com/api/sellerDetails/getSellerDetails)
  – **Submit Seller Details**: [https://woocom.logistiex.com/api/sellerDetails/submitSellerDetails](https://woocom.logistiex.com/api/sellerDetails/submitSellerDetails)

* **Order Syncing**: Once set up, orders are synced between WooCommerce and our platform:
  – **Order Updates**: [https://woocom.logistiex.com/api/orders/updated](https://woocom.logistiex.com/api/orders/updated)

* **Tracking Details**: To retrieve tracking information for orders:
  – **Get Tracking Details**: [https://woocom.logistiex.com/api/trackingDetails/getTrackingDetails/{orderId}](https://woocom.logistiex.com/api/trackingDetails/getTrackingDetails/{orderId})

For more information on how we manage and protect your data, please refer to the following resources:
* **Service URL**: [https://logistiex.com/](https://logistiex.com/)
* **Terms of Use**: [https://logistiex.com/terms_conditions](https://logistiex.com/terms_conditions)
* **Privacy Policy**: [https://logistiex.com/privacyPolicy](https://logistiex.com/privacyPolicy)

These documents provide detailed information about our practices and your rights regarding your data.
