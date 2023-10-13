"use strict";

// Get the "Register" button and the form
let btnRegister = document.getElementById("btnRegister");
let form = document.querySelector(".vh-100");

// Add an event listener to the "Register" button
btnRegister.addEventListener("click", () => {
  // Toggle the visibility of the form
  if (form.style.display === "none") {
    form.style.display = "block";
  } else {
    form.style.display = "none";
  }
});
