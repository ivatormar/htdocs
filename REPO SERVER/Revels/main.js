"use strict";

// Get the "Register" button and the form
let btnRegister = document.getElementById("btnRegister");
let btnLogin = document.getElementById("btnLogin");

let aLoginHere = document.getElementById("aLoginHere");
let aRegisterHere = document.getElementById("aRegisterHere");

let formRegister = document.getElementById("seccionRegister");
let formLogin = document.getElementById("seccionLogin");

btnLogin.addEventListener("click", () => {
  console.log("LOGIN");
  if (formLogin.style.display === "none") {
    formLogin.style.display = "block";
  } else {
    formLogin.style.display = "none";
  }
});

aLoginHere.addEventListener("click", () => {
  console.log("Login dentro del register");
});

aRegisterHere.addEventListener("click", () => {
  console.log("Register dentro del login");
});

// Add an event listener to the "Register" button
btnRegister.addEventListener("click", () => {
  console.log("REGISTER");

  // Toggle the visibility of the form
  if (formRegister.style.display === "none") {
    formRegister.style.display = "block";
  } else {
    formRegister.style.display = "none";
  }
});
