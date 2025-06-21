<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | E-PKH</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background:#ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .glass-card {
            background: rgba(255,255,255,0.13);
            box-shadow: 0 8px 32px 0 rgba(31,38,135,0.37);
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
            background: #0a3d91;
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
        .register-title {
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
            border: 1px solid #b0c4de;
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
            border: 1px solid #b0c4de;
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
            color: #0a3d91;
            font-size: 1.1rem;
        }
        .input-wrapper {
            position: relative;
            width: 100%;
        }
        .btn-group {
            display: flex;
            gap: 12px;
            margin-top: 10px;
            width: 100%;
            margin: 10px auto;
        }
        .btn-register, .btn-cancel {
            flex: 1;
            padding: 8px 0;
            border: none;
            border-radius: 18px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-register {
            background: #0a3d91;
            color: #fff;
        }
        .btn-register:hover {
            background: #1e90ff;
        }
        .btn-cancel {
            background: #fff;
            color: #0a3d91;
            border: 1px solid #0a3d91;
        }
        .btn-cancel:hover {
            background: #e3eafc;
        }
        .login-link {
            text-align: center;
            margin-top: 14px;
            font-size: 0.97rem;
            color: #222;
        }
        .login-link a {
            color: #0a3d91;
            text-decoration: underline;
        }
        .text-danger, .text-success {
            font-size: 0.95rem;
            display: block;
            text-align: center;
            margin-bottom: 10px;
        }
        .text-danger { color: #c0392b; }
        .text-success { color: #218838; }
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
        <div class="register-title">E-PKH</div>
        @if(session('success'))
            <span class="text-success">{{ session('success') }}</span>
        @endif
        @if($errors->any())
            @foreach($errors->all() as $error)
                <span class="text-danger">{{ $error }}</span>
            @endforeach
        @endif
        <form action="{{ url('/register') }}" method="post">
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
                <input type="text" name="nama_lengkap" id="nama_lengkap" placeholder="Nama Lengkap" value="{{ old('nama_lengkap') }}" required>
                <span class="input-icon"><i class="bi bi-person"></i></span>
            </div>
            <div class="form-group input-wrapper">
                <input type="text" name="nik" id="nik" placeholder="NIK" value="{{ old('nik') }}" required>
                <span class="input-icon"><i class="bi bi-person-badge"></i></span>
            </div>
            <div class="form-group input-wrapper">
                <input type="password" name="password" id="password" placeholder="Kata Sandi" required>
                <span class="input-icon" style="cursor:pointer;" onclick="togglePassword(this)">
                    <i class="bi bi-eye-slash" id="toggleIcon"></i>
                </span>
            </div>
            <div class="form-group input-wrapper">
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi Kata Sandi" required>
                <span class="input-icon" style="cursor:pointer;" onclick="togglePassword(this)">
                    <i class="bi bi-eye-slash" id="toggleIcon"></i>
                </span>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn-register">Daftar</button>
                <button type="button" class="btn-cancel" onclick="window.location.href='/'">Batal</button>
            </div>
        </form>
        <div class="login-link">
            <span>Sudah punya akun? <a href="{{ url('login') }}">Login</a></span>
        </div>
    </div>
    <script>
        function togglePassword(el) {
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