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
        }

        .registration-section {
            display: flex;
            width: 100%;
            height: 100vh;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .img {
            flex: 7;
            background-image: url('images/bg-1.jpg');
            background-size: cover;
            background-position: center;
            height: 100%;
            min-height: 300px;
        }

        .registration-wrap {
            flex: 3;
            background-color: #eff3f6;
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            box-sizing: border-box;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: bold;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
            width: 100%;
        }

        .form-control {
            height: 55px;
            border: 1px solid #ced4da;
            border-radius: 8px;
            padding: 10px 15px;
            width: 100%;
            box-sizing: border-box;
            font-size: 16px;
            color: #495057;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.5);
        }

        .btn {
            width: 100%;
            height: 55px;
            background-color: #007bff;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 18px;
            transition: background-color 0.3s ease;
            margin-top: 25px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .text-muted {
            font-size: 0.9em;
            color: #6c757d;
        }

        p.text-center {
            margin-top: 20px;
            text-align: center;
            font-size: 16px;
        }

        .field-icon {
            float: right;
            margin-top: -40px;
            margin-right: 15px;
            cursor: pointer;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 8px;
            font-size: 14px;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        @media (max-width: 768px) {
            .registration-section {
                flex-direction: column;
                height: auto;
            }

            .img {
                height: 40vh;
                min-height: 200px;
            }

            .registration-wrap {
                padding: 20px;
            }

            h2 {
                font-size: 24px;
            }

            .form-control {
                height: 50px;
            }

            .btn {
                font-size: 16px;
                height: 50px;
            }

            .text-muted {
                font-size: 0.8em;
            }

            
        }
    </style>
</head>

<body>
    <section class="registration-section">
        <div class="img"></div>
        <div class="registration-wrap">
            <h2>Registrasi</h2>
            <div id="error-message-container" class="alert alert-danger" style="display: none;"></div>
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
                    <small class="text-muted">Catatan : Kata sandi harus memiliki minimal 6 karakter.</small>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Kata Sandi <small class="text-muted">(Wajib
                            diisi)</small></label>
                    <input id="password-confirmation-field" type="password" name="password_confirmation"
                        class="form-control" required placeholder="Konfirmasi Kata Sandi" />
                    <span toggle="#password-confirmation-field"
                        class="fa fa-fw fa-eye field-icon toggle-password"></span>
                    <small class="text-muted">Harap masukkan kata sandi yang sama.</small>
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