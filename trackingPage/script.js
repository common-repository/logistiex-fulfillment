document.addEventListener("DOMContentLoaded", function () {
  var loader = document.getElementById("logistiex-fulfillment-loaderDiv");
  var trackingContent = document.getElementById(
    "logistiex-fulfillment-tracking-content"
  );
  var trackingNone = document.getElementById(
    "logistiex-fulfillment-tracking-none"
  );
  var trackingUrl = document.getElementById(
    "logistiex-fulfillment-tracking-url"
  );

  // Call the API function when the page loads
  getTrackingDetailsAPI();

  // Function to make API call
  function getTrackingDetailsAPI() {
    var url =
      "https://woocom.logistiex.com/api/trackingDetails/getTrackingDetails/" +
      orderId;

    fetch(url, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        store_url: storeUrl, // Send the store URL in headers
      },
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Get Tracking Details API failed");
        }
        return response.json();
      })
      .then((data) => {
        if (data?.trackingUrl) {
          trackingUrl.href = data?.trackingUrl;
          trackingUrl.innerText = data?.trackingUrl;
          trackingContent.style.display = "inline";
        } else {
          trackingContent.style.display = "none";
          trackingNone.style.display = "inline";
          trackingNone.innerText = "Tracking URL not present yet.";
        }
      })
      .catch((error) => {
        console.error(error.message);
        trackingNone.style.display = "inline";
        trackingNone.innerText =
          "Something Went Wrong, Please Refresh the Page.";
      })
      .finally(() => {
        // Hide the loader
        loader.style.display = "none";
      });
  }
});
