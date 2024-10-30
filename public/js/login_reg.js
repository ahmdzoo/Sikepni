const inputs = document.querySelectorAll(".input-field");
const toggle_btn = document.querySelectorAll(".toggle");
const main = document.querySelector("main");
const bullets = document.querySelectorAll(".bullets span");

inputs.forEach((inp) => {
  inp.addEventListener("focus", () => {
    inp.classList.add("active");
  });
  inp.addEventListener("blur", () => {
    if (inp.value != "") return;
    inp.classList.remove("active");
  });
});

function togglePasswordVisibility() {
  const passwordField = document.getElementById('password');
  const toggleIcon = document.getElementById('togglePassword');
  if (passwordField.type === 'password') {
    passwordField.type = 'text';
    toggleIcon.classList.remove('fa-eye');
    toggleIcon.classList.add('fa-eye-slash');
  } else {
    passwordField.type = 'password';
    toggleIcon.classList.remove('fa-eye-slash');
    toggleIcon.classList.add('fa-eye');
  }
}

function togglePasswordConfirmationVisibility() {
  const passwordField = document.getElementById('password_confirmation');
  const toggleIcon = document.getElementById('togglePassword_confirmation');
  if (passwordField.type === 'password') {
    passwordField.type = 'text';
    toggleIcon.classList.remove('fa-eye');
    toggleIcon.classList.add('fa-eye-slash');
  } else {
    passwordField.type = 'password';
    toggleIcon.classList.remove('fa-eye-slash');
    toggleIcon.classList.add('fa-eye');
  }
}

// const inputs = document.querySelectorAll(".input-field");
// const toggle_btn = document.querySelectorAll(".toggle");
// const main = document.querySelector("main");
// const bullets = document.querySelectorAll(".bullets span");
// const images = document.querySelectorAll(".image");

// inputs.forEach((inp) => {
//   inp.addEventListener("focus", () => {
//     inp.classList.add("active");
//   });
//   inp.addEventListener("blur", () => {
//     if (inp.value != "") return;
//     inp.classList.remove("active");
//   });
// });

// toggle_btn.forEach((btn) => {
//   btn.addEventListener("click", () => {
//     main.classList.toggle("sign-up-mode");
//   });
// });

// function togglePasswordVisibility() {
//   const passwordField = document.getElementById('password');
//   const toggleIcon = document.getElementById('togglePassword');
//   if (passwordField.type === 'password') {
//     passwordField.type = 'text';
//     toggleIcon.classList.remove('fa-eye');
//     toggleIcon.classList.add('fa-eye-slash');
//   } else {
//     passwordField.type = 'password';
//     toggleIcon.classList.remove('fa-eye-slash');
//     toggleIcon.classList.add('fa-eye');
//   }
// }

// function togglePasswordConfirmationVisibility() {
//   const passwordField = document.getElementById('password_confirmation');
//   const toggleIcon = document.getElementById('togglePassword_confirmation');
//   if (passwordField.type === 'password') {
//     passwordField.type = 'text';
//     toggleIcon.classList.remove('fa-eye');
//     toggleIcon.classList.add('fa-eye-slash');
//   } else {
//     passwordField.type = 'password';
//     toggleIcon.classList.remove('fa-eye-slash');
//     toggleIcon.classList.add('fa-eye');
//   }
// }