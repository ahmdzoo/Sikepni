<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Sikepni</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            font-family: 'Lato', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            /* Mencegah scroll */
        }

        .registration-section {
            display: flex;
            width: 100%;
            height: 100vh;
            /* Full height */
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .img {
            flex: 7;
            /* 70% untuk gambar */
            background-image: url('images/bg-1.jpg');
            background-size: cover;
            background-position: center;
            height: 100%;
            /* Full height */
            min-height: 300px;
            /* Minimum height untuk mobile */
        }

        .registration-wrap {
            flex: 3;
            /* 30% untuk kolom registrasi */
            background: white;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            /* Center items vertically */
            box-sizing: border-box;
            /* Pastikan padding tidak mempengaruhi ukuran */
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
            width: 100%;
            /* Lebar penuh */
        }

        .form-control {
            height: 50px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 10px;
            width: 100%;
            /* Lebar penuh */
            box-sizing: border-box;
            /* Pastikan padding tidak mempengaruhi ukuran */
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .btn {
            width: 100%;
            height: 50px;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            transition: background-color 0.3s ease;
            margin-top: 20px;
            /* Space above button */
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .text-muted {
            font-size: 0.8em;
        }

        p.text-center {
            margin-top: 20px;
            text-align: center;
        }

        .field-icon {
            float: right;
            margin-top: -30px;
            margin-right: 10px;
            cursor: pointer;
        }

        /* Media Queries untuk mobile */
        @media (max-width: 768px) {
            .registration-section {
                flex-direction: column;
                /* Mengubah arah flex untuk mobile */
                height: auto;
                /* Tidak perlu 100vh pada mobile */
            }

            .img {
                height: 40vh;
                /* Atur tinggi untuk gambar di mobile */
                min-height: 200px;
                /* Minimum height untuk menjaga gambar tetap terlihat */
            }

            .registration-wrap {
                padding: 20px;
                /* Mengurangi padding untuk mobile */
            }

            h2 {
                font-size: 24px;
                /* Ukuran font yang lebih kecil untuk mobile */
            }

            .form-control {
                height: 45px;
                /* Ukuran input lebih kecil untuk mobile */
            }

            .btn {
                font-size: 14px;
                /* Ukuran font yang lebih kecil untuk tombol di mobile */
                height: 45px;
                /* Ukuran tombol lebih kecil untuk mobile */
            }

            .text-muted {
                font-size: 0.7em;
                /* Ukuran font yang lebih kecil untuk mobile */
            }
        }
    </style>
</head>

<body>
    <section class="registration-section">
        <div class="img"></div>
        <div class="registration-wrap">
            <h2>Registrasi</h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group">
                    <label for="name">Nama Lengkap <small class="text-muted">(Wajib diisi)</small></label>
                    <input type="text" name="name" class="form-control" required placeholder="Masukkan Nama Lengkap" />
                </div>
                <div class="form-group">
                    <label for="email">Email <small class="text-muted">(Wajib diisi)</small></label>
                    <input type="email" name="email" class="form-control" required placeholder="Masukkan Email" />
                </div>
                <div class="form-group">
                    <label for="password">Kata Sandi <small class="text-muted">(Wajib diisi)</small></label>
                    <input id="password-field" type="password" name="password" class="form-control" required
                        placeholder="Masukkan Kata Sandi" />
                    <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Kata Sandi <small class="text-muted">(Wajib
                            diisi)</small></label>
                    <input id="password-confirmation-field" type="password" name="password_confirmation"
                        class="form-control" required placeholder="Konfirmasi Kata Sandi" />
                    <span toggle="#password-confirmation-field"
                        class="fa fa-fw fa-eye field-icon toggle-password"></span>
                </div>
                <div class="form-group">
                    <label for="role">Role <small class="text-muted">(Wajib diisi)</small></label>
                    <select name="role" id="role" class="form-control" required>
                        <option value="mahasiswa">Mahasiswa</option>
                        <option value="dosen_pembimbing">Dosen Pembimbing</option>
                        <option value="mitra_magang">Mitra Magang</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn">Daftar</button>
                </div>
            </form>
            <p class="text-center">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
        </div>
    </section>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>