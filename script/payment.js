"use strict";

function validate() {
  var errMsg = "";
  var result = true;
  var creditCard = document.getElementById("payment-service").value;
  var cardName = document.getElementById("credit-card-name").value;
  var cardNum = document.getElementById("credit-card-number").value;
  //check credit card type
  if (creditCard == "") {
    errMsg = errMsg + "Please choose a credit card type\n";
    result = false;
  }
  //check credit card name
  if (!cardName.match(/^[A-Za-z ]{1,40}$/)) {
    errMsg = errMsg + "Please reenter the name on your credit card\n";
  }
  // check card number
  if (cardNum == "") {
    errMsg = errMsg + "Please enter your card number\n";
  } else {
    var tempMsg = checkCreditCard(cardNum);
    if (tempMsg != "") {
      errMsg = tempMsg + errMsg;
      result = false;
    }
  }

  if (errMsg != "") {
    alert(errMsg);
  }
  return result;
}

function checkCreditCard(number) {
  var errMsg = "";
  var creditCard = document.getElementById("payment-service").value;
  switch (creditCard) {
    case "Visa":
      if (!number.match(/^4+\d{15}$/)) {
        errMsg =
          errMsg + "Visa card number must have 16 digits and start with a 4\n";
      }
      break;
    case "Mastercard":
      if (!number.match(/^5+[1-5]+\d{14}$/)) {
        errMsg =
          errMsg +
          "Mastercard card number must have 16 digits and start with digits from 51 through 55\n";
      }
      break;
    case "AmeEx":
      if (!number.match(/^34+\d{13}$|^37+\d{13}$/)) {
        errMsg =
          errMsg +
          "American Express card number must have 15 digits and start with 34 or 37\n";
      }
      break;
  }
  return errMsg;
}

function checkOut() {
  document.getElementById("confirm-name").textContent =
    sessionStorage.firstname + " " + sessionStorage.lastname;
  document.getElementById("confirm-email").textContent = sessionStorage.email;
  document.getElementById("confirm-phone").textContent = sessionStorage.phone;
  document.getElementById("confirm-address").textContent =
    sessionStorage.streetAdd +
    " " +
    sessionStorage.suburb +
    " " +
    sessionStorage.state;
  document.getElementById("confirm-postcode").textContent =
    sessionStorage.postcode;
  document.getElementById("confirm-contact").textContent =
    sessionStorage.contact;
  document.getElementById("confirm-service").textContent =
    sessionStorage.service;
  document.getElementById("confirm-price-per-month").textContent =
    sessionStorage.price + "$";
  document.getElementById("confirm-quantity").textContent =
    sessionStorage.quantity + " month(s)";

  console.log(typeof sessionStorage.quantity);
  var x = Number(sessionStorage.quantity);
  console.log(typeof x);
  var y = Number(sessionStorage.price);
  console.log(typeof y);
  var totalPrice = x * y;
  console.log(typeof totalPrice);
  document.getElementById("confirm-price").textContent = totalPrice + "$";

  document.getElementById("firstname").value = sessionStorage.firstname;
  document.getElementById("lastname").value = sessionStorage.lastname;
  document.getElementById("email").value = sessionStorage.email;
  document.getElementById("phone").value = sessionStorage.phone;
  document.getElementById("streetAdd").value = sessionStorage.streetAdd;
  document.getElementById("suburb").value = sessionStorage.suburb;
  document.getElementById("state").value = sessionStorage.state;
  document.getElementById("postcode").value = sessionStorage.postcode;
  document.getElementById("contact").value = sessionStorage.contact;
  document.getElementById("quantity").value = sessionStorage.quantity;
  document.getElementById("total-price").value = totalPrice;

  console.log(document.getElementById("firstname").value)
}

function cancelCheckOut() {
  window.location = "index.html";
}

function init() {
  var checkOutForm = document.getElementById("check-out-form"); // link the variable to the HTML element
  checkOutForm.onsubmit = validate; /* assigns functions to corresponding events */
  checkOut();
  document
    .getElementById("cancel-button")
    .addEventListener("onclick", cancelCheckOut);
}

window.onload = init;
