<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | E-PKH</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: url('https://images.unsplash.com/photo-1519681393784-a4ee110ba2d6?auto=format&fit=crop&w=1920&q=80') center center / cover no-repeat; /* Placeholder wallpaper */
            background-size: cover; /* Ensure the image covers the entire background */
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .glass-card {
            background: rgba(255,255,255,0.13);
            box-shadow: 0 8px 32px 0 rgba(10,17,40,0.37);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-radius: 18px;
            border: 1.5px solid rgba(255,255,255,0.18);
            padding: 50px 40px 60px 32px;
            max-width: 370px;
            width: 100%;
            margin: 40px auto;
            position: relative;
        }
        .close-btn {
            position: absolute;
            top: 16px;
            right: 16px;
            background: #0A1128;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            font-size: 1.3rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-title {
            text-align: center;
            font-size: 2rem;
            font-weight: bold;
            color: #222;
            margin-bottom: 24px;
            letter-spacing: 1px;
        }
        .form-group {
            margin-bottom: 18px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        select {
            width: 80%;
            max-width: 250px;
            padding: 8px 15px;
            border: 1px solid #8CCDEB;
            border-radius: 8px;
            font-size: 1rem;
            background: rgba(255,255,255,0.7);
            color: #222;
            margin-bottom: 8px;
            text-align: center;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-caret-down-fill' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 16px;
            padding-right: 30px;
        }
        input[type="text"], input[type="password"] {
            width: 95%;
            padding: 10px 10px 10px 10px;
            border: 1px solid #8CCDEB;
            border-radius: 8px;
            font-size: 1rem;
            background: rgba(255,255,255,0.7);
            color: #222;
            margin-bottom: 8px;
            text-align: left;
        }
        .input-icon {
            position: absolute;
            right: 10px;
            top: 40%;
            transform: translateY(-50%);
            color: #0A1128;
            font-size: 1.1rem;
        }
        .input-wrapper {
            position: relative;
            width: 100%;
        }
        .remember-me {
            display: flex;
            align-items: center;
            font-size: 1rem;
            margin-bottom: 5px;
            margin-top: -5px;
            width: 100%;
            justify-content: space-between;
        }
        .remember-me input[type="checkbox"] {
            transform: scale(1.1);
            margin-right: 8px;
        }
        .remember-me label {
            margin-bottom: 0;
            flex-grow: 1;
        }
        .forgot-link {
            margin-left: auto;
            font-size: 0.97rem;
            color: #0A1128;
            text-decoration: underline;
            cursor: pointer;
        }
        .btn-group {
            display: flex;
            gap: 12px;
            margin-top: 10px;
            width: 100%;
            margin: 10px auto;
        }
        .btn-login, .btn-cancel {
            flex: 1;
            padding: 8px 0;
            border: none;
            border-radius: 18px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-login {
            background: #0A1128;
            color: #fff;
        }
        .btn-login:hover {
            background: #1B263B;
        }
        .btn-cancel {
            background: #fff;
            color: #0A1128;
            border: 1px solid #0A1128;
        }
        .btn-cancel:hover {
            background: #D9F3FC;
        }
        .register-link {
            text-align: center;
            margin-top: 14px;
            font-size: 0.97rem;
            color: #222;
        }
        .register-link a {
            color: #0A1128;
            text-decoration: underline;
        }
        @media (max-width: 500px) {
            .glass-card { padding: 18px 6vw; }
        }
    </style>
    <!-- Bootstrap Icons CDN for icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="glass-card">
        <button class="close-btn" onclick="window.location.href='/'"><i class="bi bi-x-lg"></i></button>
        <div class="login-title">E-PKH</div>
        <form action="{{ url('login') }}" method="post">
            @csrf
            <div class="form-group">
                <select name="role" required>
                    <option value="">----Pilih sebagai----</option>
                    <option value="admin">Admin</option>
                    <option value="pendamping">Pendamping</option>
                    <option value="penerima">Penerima Bansos</option>
                </select>
            </div>
            <div class="form-group input-wrapper">
                <input type="text" name="nik" placeholder="NIK" required>
                <span class="input-icon"><i class="bi bi-person-badge"></i></span>
            </div>
            <div class="form-group input-wrapper">
                <input type="password" name="password" placeholder="Kata Sandi" required>
                <span class="input-icon" style="cursor:pointer;" onclick="togglepassword(this)">
                    <i class="bi bi-eye-slash" id="toggleIcon"></i>
                </span>
            </div>
            <div class="remember-me">
                <input type="checkbox" name="remember" id="remember" style="margin-right:6px;">
                <label for="remember" style="margin-bottom:0;">Ingatkan Saya</label>
                <span class="forgot-link" onclick="window.location.href='{{ url('password/reset') }}'">Lupa Kata Sandi</span>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn-login">Masuk</button>
                <button type="button" class="btn-cancel" onclick="window.location.href='/'">Batal</button>
            </div>
        </form>
        <div class="register-link">
            Belum memiliki akun? <a href="{{ url('register') }}">Daftar</a>
        </div>
    </div>
    <script>
        function togglepassword(el) {
            const input = el.parentElement.querySelector('input[type="password"],input[type="text"]');
            const icon = el.querySelector('i');
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            } else {
                input.type = "password";
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        }
    </script>
</body>
</html>