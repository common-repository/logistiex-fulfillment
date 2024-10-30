<?php

// Add a custom menu item under WooCommerce
function logistiex_fulfillment_menu_item() {
    add_submenu_page(
        'woocommerce',
        esc_html__('Logistiex Fulfillment', 'logistiex-fulfillment'),
        esc_html__('Logistiex Fulfillment', 'logistiex-fulfillment'),
        'manage_options',
        'logistiex-fulfillment-org-setting',
        'logistiex_fulfillment_manage_org_details'
    );
}

// Enqueue styles and scripts
function logistiex_fulfillment_enqueue_styles_scripts() {
    // Define a version number for your assets
    $version = '1.0.3'; // Update this version number whenever you make changes to your CSS or JS files

    // Register and enqueue the CSS file with version
    wp_register_style('logistiex-fulfillment-styles', esc_url(plugins_url('styles.css', __FILE__)), [], $version);
    wp_enqueue_style('logistiex-fulfillment-styles');

    // Register and enqueue the JavaScript file with version
    wp_register_script('logistiex-fulfillment-script', esc_url(plugins_url('script.js', __FILE__)), [], $version, true);
    wp_enqueue_script('logistiex-fulfillment-script');

    // Inline script with localized store URL
    $store_url = esc_url(get_site_url());
    wp_add_inline_script('logistiex-fulfillment-script', 'var storeUrl = "' . esc_js($store_url) . '";');
}

add_action('admin_enqueue_scripts', 'logistiex_fulfillment_enqueue_styles_scripts');

// Callback function to display the custom plugin page content
function logistiex_fulfillment_manage_org_details() {
  ?>
    <div>
      <div id="homeDiv">
        <div
          id="loaderDiv"
          style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100vh;"
        >
          <div class="loader"></div>
          <p
            style="font-weight: bold; font-size: 16px; color: #777777; margin-top: 15px;"
          >
            Checking Details With Logistiex Please Wait...
          </p>
        </div>
        <div
          style="background-color: #f5f5f5; display: flex; flex-direction: column; justify-content: center; padding: 20px; align-items: center; height: 100%; overflow-y: auto;"
        >
          <div
            style="display: flex; flex-wrap: wrap; justify-content: center; align-items: center; text-align: center;"
          >
            <div
              style="border-radius: 50%; background-color: #004aad; height: 70px; width: 70px; display: flex; justify-content: center; align-items: center; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); margin-bottom: 30px;"
            >
              <img src="<?php echo esc_url(plugins_url('assets/WhiteFontLogistiex.png', __FILE__)); ?>" style="max-width: 100%; max-height: 100%;">
            </div>
            <p id="heading"
              style="font-size: 24px; font-weight: bold; margin-bottom: 50px; padding: 0 20px; color: #004aad;"
            >
              Enabling New Age Commerce
            </p>
          </div>
          <div
            style="display: flex; justify-content: center; align-items: center; flex-direction: column;"
          >
            <p style="font-size: 18px; text-align: center; color: #444; line-height: 1.5; margin: 0px 40px;">
              At LogistieX, we are creating a suite of products to help SMBs navigate the hassle of online retail across multiple platforms. We offer technology-backed integration with e-commerce platforms, storefronts, and fulfillment service providers.
              <a href="https://logistiex.com" target="_blank">
                Learn More
              </a>
            </p>
            <div
              style="display: flex; justify-content: center; margin-top: 30px;"
            >
              <button id="startedButton"
                style="background-color: #004aad; color: white; font-size: 18px; margin-right: 20px; border: none; border-radius: 5px; cursor: pointer; width: 150px; height: 45px; display: flex; justify-content: center; align-items: center;"
              >
                <svg id="defaultIcon" fill="white" width="25px" height="25px" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" style="margin-right: 10px">
                  <path d="M16.000,32.000 C7.178,32.000 0.000,24.822 0.000,16.000 C0.000,7.178 7.178,-0.000 16.000,-0.000 C24.822,-0.000 32.000,7.178 32.000,16.000 C32.000,24.822 24.822,32.000 16.000,32.000 ZM16.000,2.000 C8.280,2.000 2.000,8.280 2.000,16.000 C2.000,23.720 8.280,30.000 16.000,30.000 C23.720,30.000 30.000,23.720 30.000,16.000 C30.000,8.280 23.720,2.000 16.000,2.000 ZM23.923,16.382 C23.872,16.505 23.799,16.615 23.706,16.708 L19.707,20.707 C19.512,20.902 19.256,21.000 19.000,21.000 C18.744,21.000 18.488,20.902 18.293,20.707 C17.902,20.316 17.902,19.684 18.293,19.293 L20.586,17.000 L9.000,17.000 C8.448,17.000 8.000,16.552 8.000,16.000 C8.000,15.448 8.448,15.000 9.000,15.000 L20.586,15.000 L18.293,12.707 C17.902,12.316 17.902,11.684 18.293,11.293 C18.684,10.902 19.316,10.902 19.707,11.293 L23.706,15.292 C23.799,15.385 23.872,15.495 23.923,15.618 C24.024,15.862 24.024,16.138 23.923,16.382 Z" />
                </svg>
                <svg id="settingIcon" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="25px" height="25px" viewBox="0 0 50 50" fill="white" style="margin-right: 10px"
                >
                  <path d="M 22.205078 2 A 1.0001 1.0001 0 0 0 21.21875 2.8378906 L 20.246094 8.7929688 C 19.076509 9.1331971 17.961243 9.5922728 16.910156 10.164062 L 11.996094 6.6542969 A 1.0001 1.0001 0 0 0 10.708984 6.7597656 L 6.8183594 10.646484 A 1.0001 1.0001 0 0 0 6.7070312 11.927734 L 10.164062 16.873047 C 9.583454 17.930271 9.1142098 19.051824 8.765625 20.232422 L 2.8359375 21.21875 A 1.0001 1.0001 0 0 0 2.0019531 22.205078 L 2.0019531 27.705078 A 1.0001 1.0001 0 0 0 2.8261719 28.691406 L 8.7597656 29.742188 C 9.1064607 30.920739 9.5727226 32.043065 10.154297 33.101562 L 6.6542969 37.998047 A 1.0001 1.0001 0 0 0 6.7597656 39.285156 L 10.648438 43.175781 A 1.0001 1.0001 0 0 0 11.927734 43.289062 L 16.882812 39.820312 C 17.936999 40.39548 19.054994 40.857928 20.228516 41.201172 L 21.21875 47.164062 A 1.0001 1.0001 0 0 0 22.205078 48 L 27.705078 48 A 1.0001 1.0001 0 0 0 28.691406 47.173828 L 29.751953 41.1875 C 30.920633 40.838997 32.033372 40.369697 33.082031 39.791016 L 38.070312 43.291016 A 1.0001 1.0001 0 0 0 39.351562 43.179688 L 43.240234 39.287109 A 1.0001 1.0001 0 0 0 43.34375 37.996094 L 39.787109 33.058594 C 40.355783 32.014958 40.813915 30.908875 41.154297 29.748047 L 47.171875 28.693359 A 1.0001 1.0001 0 0 0 47.998047 27.707031 L 47.998047 22.207031 A 1.0001 1.0001 0 0 0 47.160156 21.220703 L 41.152344 20.238281 C 40.80968 19.078827 40.350281 17.974723 39.78125 16.931641 L 43.289062 11.933594 A 1.0001 1.0001 0 0 0 43.177734 10.652344 L 39.287109 6.7636719 A 1.0001 1.0001 0 0 0 37.996094 6.6601562 L 33.072266 10.201172 C 32.023186 9.6248101 30.909713 9.1579916 29.738281 8.8125 L 28.691406 2.828125 A 1.0001 1.0001 0 0 0 27.705078 2 L 22.205078 2 z M 23.056641 4 L 26.865234 4 L 27.861328 9.6855469 A 1.0001 1.0001 0 0 0 28.603516 10.484375 C 30.066026 10.848832 31.439607 11.426549 32.693359 12.185547 A 1.0001 1.0001 0 0 0 33.794922 12.142578 L 38.474609 8.7792969 L 41.167969 11.472656 L 37.835938 16.220703 A 1.0001 1.0001 0 0 0 37.796875 17.310547 C 38.548366 18.561471 39.118333 19.926379 39.482422 21.380859 A 1.0001 1.0001 0 0 0 40.291016 22.125 L 45.998047 23.058594 L 45.998047 26.867188 L 40.279297 27.871094 A 1.0001 1.0001 0 0 0 39.482422 28.617188 C 39.122545 30.069817 38.552234 31.434687 37.800781 32.685547 A 1.0001 1.0001 0 0 0 37.845703 33.785156 L 41.224609 38.474609 L 38.53125 41.169922 L 33.791016 37.84375 A 1.0001 1.0001 0 0 0 32.697266 37.808594 C 31.44975 38.567585 30.074755 39.148028 28.617188 39.517578 A 1.0001 1.0001 0 0 0 27.876953 40.3125 L 26.867188 46 L 23.052734 46 L 22.111328 40.337891 A 1.0001 1.0001 0 0 0 21.365234 39.53125 C 19.90185 39.170557 18.522094 38.59371 17.259766 37.835938 A 1.0001 1.0001 0 0 0 16.171875 37.875 L 11.46875 41.169922 L 8.7734375 38.470703 L 12.097656 33.824219 A 1.0001 1.0001 0 0 0 12.138672 32.724609 C 11.372652 31.458855 10.793319 30.079213 10.427734 28.609375 A 1.0001 1.0001 0 0 0 9.6328125 27.867188 L 4.0019531 26.867188 L 4.0019531 23.052734 L 9.6289062 22.117188 A 1.0001 1.0001 0 0 0 10.435547 21.373047 C 10.804273 19.898143 11.383325 18.518729 12.146484 17.255859 A 1.0001 1.0001 0 0 0 12.111328 16.164062 L 8.8261719 11.46875 L 11.523438 8.7734375 L 16.185547 12.105469 A 1.0001 1.0001 0 0 0 17.28125 12.148438 C 18.536908 11.394293 19.919867 10.822081 21.384766 10.462891 A 1.0001 1.0001 0 0 0 22.132812 9.6523438 L 23.056641 4 z M 25 17 C 20.593567 17 17 20.593567 17 25 C 17 29.406433 20.593567 33 25 33 C 29.406433 33 33 29.406433 33 25 C 33 20.593567 29.406433 17 25 17 z M 25 19 C 28.325553 19 31 21.674447 31 25 C 31 28.325553 28.325553 31 25 31 C 21.674447 31 19 28.325553 19 25 C 19 21.674447 21.674447 19 25 19 z"></path>
                </svg>
                <span id="buttonText">Get Started</span>
              </button>
              <a
                href="https://logistiex.com/#contact" target="_blank"
                style="background-color: white; color: #004aad; font-size: 18px; border: 2px solid #004aad; border-radius: 5px; cursor: pointer; text-decoration: none; display: flex; justify-content: center; align-items: center; width: 150px; height: 40px;"
              >
                <svg
                  width="25px"
                  height="25px"
                  viewBox="0 0 24 24"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                  style="margin-right: 10px"
                >
                  <path
                    d="M7 9H17M7 13H17M21 20L17.6757 18.3378C17.4237 18.2118 17.2977 18.1488 17.1656 18.1044C17.0484 18.065 16.9277 18.0365 16.8052 18.0193C16.6672 18 16.5263 18 16.2446 18H6.2C5.07989 18 4.51984 18 4.09202 17.782C3.71569 17.5903 3.40973 17.2843 3.21799 16.908C3 16.4802 3 15.9201 3 14.8V7.2C3 6.07989 3 5.51984 3.21799 5.09202C3.40973 4.71569 3.71569 4.40973 4.09202 4.21799C4.51984 4 5.0799 4 6.2 4H17.8C18.9201 4 19.4802 4 19.908 4.21799C20.2843 4.40973 20.5903 4.71569 20.782 5.09202C21 5.51984 21 6.0799 21 7.2V20Z"
                    stroke="#004aad"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                </svg>
                Contact
              </a>
            </div>
          </div>
          <div class="product-container">
            <div
              class="product-card"
            >
              <img src="<?php echo esc_url(plugins_url('assets/product1.png', __FILE__)); ?>" class="product-image">
              <div class="product-info">
                <p>
                  Our <b style="color: #004aad">Configurable Rate Cards</b> give you the flexibility to systematize your vendor terms and maximize your bottom line.
                </p>
              </div>
            </div>
            <div
              class="product-card"
            >
              <img src="<?php echo esc_url(plugins_url('assets/product2.png', __FILE__)); ?>" class="product-image">
              <div class="product-info">
                <p>
                  Our intelligent <b style="color: #004aad">State Machine</b> uses deep learning to understand each event and auto-reconciles shipment for real-time updates.
                </p>
              </div>
            </div>
            <div
              class="product-card"
            >
              <img src="<?php echo esc_url(plugins_url('assets/product3.png', __FILE__)); ?>" class="product-image">
              <div class="product-info">
                <p>
                  Our <b style="color: #004aad">Allocation Engine</b> uses the concept of "total cost of ownership" and an ML based Algo to give the most optimal output.
                </p>
              </div>
            </div>
            <div
              class="product-card"
            >
              <img src="<?php echo esc_url(plugins_url('assets/product4.png', __FILE__)); ?>" class="product-image">
              <div class="product-info">
                <p>
                  Our <b style="color: #004aad"}>Universal Fulfillment API</b> brings ease of enabling key 3PL service providers, with one single integration and zero hassle of API maintenance.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="submitDiv" style="display: none;">
        <div class="submitDetailsContainer">
          <div id="popUp" style="display: flex; position: absolute; z-index: 20; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">
            <div style="background-color: #fefefe; margin: auto; padding: 20px; border: 1px solid #888; width: 50%; border-radius: 10px;">
              <span id="closePopUp" style="color: #aaaaaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer;">&times;</span>
              <p id="popUpMessage"></p>
            </div>
          </div>
          <div class="formSubContainer">
            <div style="display: flex; justify-content: space-between; align-items: center;">
              <p style="font-weight: bold; color: #004aad; font-size: 20px;">
                Noetic Logistiex Mapping
              </p>
              <div style="display: flex;">
                <button
                  id="homeButton"
                  style="display: flex; padding: 4px 10px; font-size: 16px; border: 2px solid #004aad; border-radius: 5px; color: #004aad; background-color: transparent; cursor: pointer; transition: background-color 0.3s ease, color 0.3s ease; margin-right: 10px;"
                >
                  <svg
                    width="20"
                    height="20"
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                    style="margin-right: 5px;"
                  >
                    <path
                      d="M19 9.77806V16.2C19 17.8801 19 18.7202 18.673 19.3619C18.3854 19.9264 17.9265 20.3854 17.362 20.673C16.7202 21 15.8802 21 14.2 21H9.8C8.11984 21 7.27976 21 6.63803 20.673C6.07354 20.3854 5.6146 19.9264 5.32698 19.3619C5 18.7202 5 17.8801 5 16.2V9.7774M21 12L15.5668 5.96393C14.3311 4.59116 13.7133 3.90478 12.9856 3.65138C12.3466 3.42882 11.651 3.42887 11.0119 3.65153C10.2843 3.90503 9.66661 4.59151 8.43114 5.96446L3 12M14 12C14 13.1045 13.1046 14 12 14C10.8954 14 10 13.1045 10 12C10 10.8954 10.8954 9.99996 12 9.99996C13.1046 9.99996 14 10.8954 14 12Z"
                      stroke="#004aad"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                  </svg>
                  Home
                </button>
                <a
                  href="https://logistiex.com/#contact" target="_blank"
                  style="display: flex; padding: 4px 10px; font-size: 16px; border: 2px solid #004aad; border-radius: 5px; color: #004aad; background-color: transparent; cursor: pointer; transition: background-color 0.3s ease, color 0.3s ease; text-decoration: none;"
                >
                  <svg
                    width="20"
                    height="20"
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                    style="margin-right: 5px;"
                  >
                    <path
                      d="M7 9H17M7 13H17M21 20L17.6757 18.3378C17.4237 18.2118 17.2977 18.1488 17.1656 18.1044C17.0484 18.065 16.9277 18.0365 16.8052 18.0193C16.6672 18 16.5263 18 16.2446 18H6.2C5.07989 18 4.51984 18 4.09202 17.782C3.71569 17.5903 3.40973 17.2843 3.21799 16.908C3 16.4802 3 15.9201 3 14.8V7.2C3 6.07989 3 5.51984 3.21799 5.09202C3.40973 4.71569 3.71569 4.40973 4.09202 4.21799C4.51984 4 5.0799 4 6.2 4H17.8C18.9201 4 19.4802 4 19.908 4.21799C20.2843 4.40973 20.5903 4.71569 20.782 5.09202C21 5.51984 21 6.0799 21 7.2V20Z"
                      stroke="#004aad"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    />
                  </svg>
                  Contact
                </a>
              </div>
            </div>
            <div>
              <p
                style="margin-top: 10px; margin-bottom: 10px; font-weight: bold; color: gray;"
              >
                Consignor Org Code
              </p>
              <input
                id="consignorOrgCode"
                type="text"
                placeholder="Enter Logistiex Consignor Org Code"
                style="padding: 10px; font-size: 16px; border: 1px solid #004aad; border-radius: 5px; outline: none; width: 100%;"
              />
            </div>
            <div>
                <div
                  id="locationFormDiv"
                  style="display: flex; align-items: center;"
                >
                </div>
            </div>

          <div id="submitLoading"
            style="display: flex; justify-content: center; align-items: center; margin-top: 20px;"
          >
            <div class="loader"></div>
          </div>
              
            <button
              id="submitDetailsButton"
              style="display: flex; padding: 10px 20px; font-size: 16px; border: none; border-radius: 5px; color: #ffffff; background-color: #004aad; cursor: pointer; transition: background-color 0.3s ease, color 0.3s ease; margin-top: 20px; justify-content: center; align-items: center;"
            >
              <svg
                fill="white"
                width="25"
                height="25"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
                style="margin-right: 10px;"
              >
                <path d="M8.71,7.71,11,5.41V15a1,1,0,0,0,2,0V5.41l2.29,2.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42l-4-4a1,1,0,0,0-.33-.21,1,1,0,0,0-.76,0,1,1,0,0,0-.33.21l-4,4A1,1,0,1,0,8.71,7.71ZM21,12a1,1,0,0,0-1,1v6a1,1,0,0,1-1,1H5a1,1,0,0,1-1-1V13a1,1,0,0,0-2,0v6a3,3,0,0,0,3,3H19a3,3,0,0,0,3-3V13A1,1,0,0,0,21,12Z" />
              </svg>
              Submit Details
            </button>
          </div>
        </div>
      </div>
    </div>
  <?php
}