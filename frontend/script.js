document.addEventListener("DOMContentLoaded", function () {
  var homeDiv = document.getElementById("homeDiv");
  var submitDiv = document.getElementById("submitDiv");
  var loader = document.getElementById("loaderDiv");
  var startedButton = document.getElementById("startedButton");
  var settingIcon = document.getElementById("settingIcon");
  var defaultIcon = document.getElementById("defaultIcon");
  var buttonText = document.getElementById("buttonText");
  var popUp = document.getElementById("popUp");
  var closePopUp = document.getElementById("closePopUp");
  var submitLoading = document.getElementById("submitLoading");
  var submitDetailsButton = document.getElementById("submitDetailsButton");
  var homeButton = document.getElementById("homeButton");
  var consignorOrgCodeInput = document.getElementById("consignorOrgCode");
  var popUpMessage = document.getElementById("popUpMessage");

  if (startedButton) {
    startedButton.addEventListener("click", function () {
      openSubmitDetailsForm();
    });
  }

  if (homeButton) {
    homeButton.addEventListener("click", function () {
      openHomePage();
    });
  }

  if (submitDetailsButton) {
    submitDetailsButton.addEventListener("click", function () {
      submitForm();
    });
  }

  if (closePopUp) {
    closePopUp.addEventListener("click", function () {
      popUp.style.display = "none";
    });
  }

  var locations = [];

  // Call the API function when the page loads
  getSellerDetailsAPI();

  // Function to make API call
  function getSellerDetailsAPI() {
    var url = "https://woocom.logistiex.com/api/sellerDetails/getSellerDetails";

    fetch(url, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        store_url: storeUrl, // Send the store URL in headers
      },
    })
      .then((response) => {
        if (!response.ok) {
          throw new Error("Get Seller Details API failed");
        }
        return response.json();
      })
      .then((data) => {
        consignorOrgCodeInput.value = data?.consignorOrgCode;
        locations = data?.locations;

        if (data.consignorOrgCode !== "") {
          buttonText.innerText = "Settings";
          settingIcon.style.display = "inline";
          defaultIcon.style.display = "none";
        } else {
          buttonText.innerText = "Get Started";
          settingIcon.style.display = "none";
          defaultIcon.style.display = "inline";
        }
      })
      .catch((error) => {
        console.error(error.message);
      })
      .finally(() => {
        // Hide the loader
        loader.style.display = "none";
      });
  }

  // Function to update the location object when input value changes
  function updateLocation(event) {
    const input = event.target;
    const locationId = parseInt(input.dataset.locationId);
    const inputValue = input.value;
    const locationToUpdate = locations.find(
      (location) => location.locationId === locationId
    );
    if (locationToUpdate) {
      locationToUpdate.uspLocationCode = inputValue;
    }
  }

  // Function to generate HTML form input fields dynamically
  function generateFormInputs() {
    const locationFormDiv = document.getElementById("locationFormDiv");
    locations.forEach((loc) => {
      locationFormDiv.innerHTML = `
        <div style="flex: 1; margin-right: 10px;">
          <label
            style="font-weight: bold; color: gray; margin-top: 10px; margin-bottom: 10px; display: block;"
          >
            Woocommerce Location
          </label>
          <input
            type="text"
            value="${loc?.locationName + " - " + loc?.locationPinCode}"
            disabled
            style="padding: 10px; font-size: 16px; border: 1px solid #004aad; border-radius: 5px; width: 100%; outline: none;"
          />
        </div>
        <div style="flex: 1;">
          <label
            style="font-weight: bold; color: gray; margin-top: 10px; margin-bottom: 10px; display: block;"
          >
            Logistiex Location Code
          </label>
          <input
            id="location-${loc.locationId}" 
            type="text" 
            value="${loc.uspLocationCode}" 
            data-location-id="${loc.locationId}"
            placeholder="Enter Logistiex Location Code"
            style="padding: 10px; font-size: 16px; border: 1px solid #004aad; border-radius: 5px; width: 100%; outline: none;"
          />
        </div>
      `;
    });
  }

  // Attach event listener to the form container to handle input changes
  document
    .getElementById("locationFormDiv")
    .addEventListener("input", function (event) {
      if (event.target.tagName === "INPUT" && event.target.dataset.locationId) {
        updateLocation(event);
      }
    });

  function openSubmitDetailsForm() {
    homeDiv.style.display = "none";
    submitDiv.style.display = "inline";
    submitLoading.style.display = "none";
    popUp.style.display = "none";
    generateFormInputs();
  }

  function openHomePage() {
    homeDiv.style.display = "inline";
    submitDiv.style.display = "none";
    loader.style.display = "flex";
    getSellerDetailsAPI();
  }

  // Function to submit form data
  function submitForm() {
    let isRequiredLocationsAvailable = true;

    for (let loc of locations) {
      if (!loc.uspLocationCode) {
        isRequiredLocationsAvailable = false;
        break;
      }
    }

    if (isRequiredLocationsAvailable && consignorOrgCodeInput.value) {
      submitLoading.style.display = "flex";
      submitDetailsButton.style.display = "none";

      var url =
        "https://woocom.logistiex.com/api/sellerDetails/submitSellerDetails";

      const requestBody = {
        locations: locations,
        consignorOrgCode: consignorOrgCodeInput.value,
      };

      // Send the POST request using fetch
      fetch(url, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          store_url: storeUrl,
        },
        body: JSON.stringify(requestBody),
      })
        .then((response) => response.json())
        .then((data) => {
          submitDetailsButton.style.display = "flex";
          submitLoading.style.display = "none";
          popUp.style.display = "flex";
          popUpMessage.innerText = data.message;
          if (data?.success) {
            setTimeout(() => {
              openHomePage();
            }, 1000);
          }
        })
        .catch((error) => {
          submitDetailsButton.style.display = "flex";
          submitLoading.style.display = "none";
          popUp.style.display = "flex";
          popUpMessage.innerText = "Something Went Wrong, Please Try Again";
          console.error("Error:", error);
        });
    } else {
      popUp.style.display = "flex";
      popUpMessage.innerText =
        "Please fill all the Location Mappings and Consignor Org Code";
    }
  }
});
