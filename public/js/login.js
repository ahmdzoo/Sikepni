$(document).ready(function () {
    // Tangani pengiriman form untuk login
    $("form").on("submit", function (event) {
        // Cegah pengiriman form default
        event.preventDefault();

        // Ambil field email dan password
        const email = $('input[name="email"]').val();
        const password = $('input[name="password"]').val();

        // Periksa jika email atau password kosong
        if (!email || !password) {
            if (!email) {
                showErrorMessage("Email tidak boleh kosong.");
            }
            if (!password) {
                showErrorMessage("Kata sandi tidak boleh kosong.");
            }
            return; // Hentikan pengiriman form
        }

        // Jika kedua field terisi, kirim form
        this.submit();
    });

    // Function untuk menampilkan pesan kesalahan
    function showErrorMessage(message) {
        // Bersihkan pesan kesalahan sebelumnya
        $(".error-message-container").empty();

        // Tampilkan pesan kesalahan baru
        $(".error-message-container").prepend(
            `<div class="alert alert-danger error-message">${message}</div>`
        );
    }
});

// Toggle password visibility
$(".toggle-password").click(function () {
    const passwordField = $($(this).attr("toggle"));
    if (passwordField.attr("type") === "password") {
        passwordField.attr("type", "text");
        $(this).removeClass("fa-eye").addClass("fa-eye-slash");
    } else {
        passwordField.attr("type", "password");
        $(this).removeClass("fa-eye-slash").addClass("fa-eye");
    }
});
