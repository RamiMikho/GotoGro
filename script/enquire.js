"use strict";

function validate() {
  var errMsg = "";
  var result = true;
  var quantity = document.getElementById("quantity").value;
  var state = document.getElementById("state").value;
  var postcode = document.getElementById("postcode").value;
  var firstname = document.getElementById("firstname").value;
  var lastname = document.getElementById("lastname").value;
  var streetAdd = document.getElementById("street-address").value;
  var email = document.getElementById("email").value;
  var phone = document.getElementById("phone-number").value;
  var suburb = document.getElementById("suburb").value;
  var contactPhone = document.getElementById("contact-phone").checked;
  var contactEmail = document.getElementById("contact-email").checked;
  var contactPost = document.getElementById("contact-post").checked;
  var service = document.getElementById("service").value;
  var price = priceDetail(service);
  

  // check preferred contact
  var contact;
  if (!(contactEmail || contactPhone || contactPost)) {
    errMsg = errMsg + "Please select a way to get contacted";
    result = false;
  } else if (contactPost) {
    contact = "post";
  } else if (contactPhone) {
    contact = "phone";
  } else if (contactEmail) {
    contact = "email";
  }

  // check quantity
  if (isNaN(quantity)) {
    errMsg = errMsg + "Your service usage must be a positive number \n";
    result = false;
  } else if (quantity < 1) {
    errMsg = errMsg + "Your service usage must be a positive number \n";
    result = false;
  }
  //   check state
  if (state == "") {
    errMsg = errMsg + "Please reselect your state\n";
    result = false;
  }

  //   check state postcode
  if (postcode == "") {
    errMsg = errMsg + "Please type in your postcode\n";
    result = false;
  } else {
    var tempMsg = checkStatePostcode(postcode);
    if (tempMsg != "") {
      errMsg = tempMsg + errMsg;
      result = false;
    }
  }

  // store data
  if (result) {
    storeData(
      firstname,
      lastname,
      email,
      phone,
      streetAdd,
      suburb,
      state,
      postcode,
      contact,
      service,
      quantity,
      price
    );
  }

  // check service
  if ((service = "")) {
    errMsg = errMsg + "Please select a service\n";
  }
  //
  if (errMsg != "") {
    alert(errMsg);
  }

  return result;
}

// price detail
function priceDetail(service) {
  var price = 0;
  if (service == "Home Internet 100Mbps Plan") {
    price = 10;
  } else if (service == "Home Internet 250Mbps Plan") {
    price = 20;
  } else if (service == "Home Internet Gig Plan") {
    price = 45;
  } else if (service == "Business Internet High Speed 15") {
    price = 50;
  } else if (service == "Business Internet High Speed 55") {
    price = 70;
  } else if (service == "Business Internet High Speed 110") {
    price = 100;
  } else if (service == "Business Internet High Speed 250") {
    price = 125;
  } else if (service == "Business Internet Gig") {
    price = 250;
  }

  return price;
}

// validate postcode
function checkStatePostcode(postcode) {
  var errMsg = "";
  var state = document.getElementById("state").value;
  switch (state) {
    case "":
      errMsg = "Please reselect the state";
      break;
    case "VIC":
      if (!postcode.match(/^3+\d{3}$|^8+\d{3}$/)) {
        errMsg = "The first digit of the postcode should start with 3 or 8\n";
      }
      break;
    case "NSW":
      if (!postcode.match(/^1+\d{3}$|^2+\d{3}$/)) {
        errMsg = "The first digit of the postcode should start with 1 or 2\n";
      }
      break;
    case "QLD":
      if (!postcode.match(/^4+\d{3}$|^9+\d{3}$/)) {
        errMsg = "The first digit of the postcode should start with 4 or 9\n";
      }
      break;
    case "NT":
    case "ACT":
      if (!postcode.match(/^0+\d{3}$/)) {
        errMsg = "The first digit of the postcode should start with 0\n";
      }
      break;
    case "WA":
      if (!postcode.match(/^6+\d{3}$/)) {
        errMsg = "The first digit of the postcode should start with 6\n";
      }
      break;
    case "SA":
      if (!postcode.match(/^5+\d{3}$/)) {
        errMsg = "The first digit of the postcode should start with 5\n";
      }
      break;
    case "TAS":
      if (!postcode.match(/^7+\d{3}$/)) {
        errMsg = "The first digit of the postcode should start with 7\n";
      }
      break;
  }
  return errMsg;
}

// store data
function storeData(
  firstname,
  lastname,
  email,
  phone,
  streetAdd,
  suburb,
  state,
  postcode,
  contact,
  service,
  quantity,
  price
) {
  sessionStorage.firstname = firstname;
  sessionStorage.lastname = lastname;
  sessionStorage.email = email;
  sessionStorage.phone = phone;
  sessionStorage.streetAdd = streetAdd;
  sessionStorage.suburb = suburb;
  sessionStorage.state = state;
  sessionStorage.postcode = postcode;
  sessionStorage.service = service;
  sessionStorage.quantity = quantity;
  sessionStorage.price = price;
  sessionStorage.contact = contact;
}

function priceDisplay() {
  var service = document.getElementById("service").value;
  var x = priceDetail(service);
  document.getElementById("price").innerHTML = x;
}

function init() {
  var enquiryForm = document.getElementById("enquiryForm"); //get refto the HTMLelement
  enquiryForm.onsubmit = validate;
  document.getElementById("service").onchange = priceDisplay;
}

window.onload = init();
