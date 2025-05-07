document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const passwordField = document.getElementById("password-field");
    const passwordConfirmationField = document.getElementById(
        "password-confirmation-field"
    );
    const errorMessageContainer = document.getElementById(
        "error-message-container"
    ); // Ambil elemen untuk pesan kesalahan

    form.addEventListener("submit", function (event) {
        let hasError = false;
        errorMessageContainer.innerHTML = ""; // Kosongkan pesan kesalahan sebelumnya

        const password = passwordField.value;
        const passwordConfirmation = passwordConfirmationField.value;

        // Cek panjang kata sandi
        if (password.length < 6) {
            hasError = true;
            errorMessageContainer.innerHTML +=
                "<p>Kata sandi harus memiliki setidaknya 6 karakter.</p>";
        }

        // Cek kecocokan kata sandi
        if (password !== passwordConfirmation) {
            hasError = true;
            errorMessageContainer.innerHTML += "<p>Konfirmasi kata sandi tidak cocok.</p>";
        }

        // Jika ada kesalahan, mencegah pengiriman form dan menampilkan pesan kesalahan
        if (hasError) {
            event.preventDefault();
            errorMessageContainer.style.display = "block"; // Tampilkan pesan kesalahan
        } else {
            errorMessageContainer.style.display = "none"; // Sembunyikan pesan kesalahan jika tidak ada kesalahan
        }
    });
});
