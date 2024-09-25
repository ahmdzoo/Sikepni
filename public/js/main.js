// Contoh isi main.js
document.addEventListener("DOMContentLoaded", function () {
    // Kode lain di sini...

    // Kode untuk toggle password
    const togglePassword = document.querySelector(".toggle-password");
    const passwordField = document.querySelector("#password-field");

    if (togglePassword && passwordField) {
        // Memastikan elemen ada
        togglePassword.addEventListener("click", function () {
            const type =
                passwordField.getAttribute("type") === "password"
                    ? "text"
                    : "password";
            passwordField.setAttribute("type", type);
            this.classList.toggle("fa-eye");
            this.classList.toggle("fa-eye-slash");
        });
    }
});
