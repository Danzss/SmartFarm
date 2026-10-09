<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SmartFarm</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CDN untuk Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background-color: #ffffff;
            font-size: 0.875rem;
        }
        .card-login {
            border-radius: 16px;
            max-width: 360px;
            width: 100%;
        }
        .logo-circle {
            width: 64px;
            height: 64px;
            background-color: #1b4332;
            color: #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            font-size: 1.5rem;
        }
        .brand-title {
            color: #1b4332;
            font-weight: 700;
            font-size: 1.5rem;
            margin-bottom: 2px;
        }
        .input-group-text {
            background-color: #f8f9fa;
            border-right: none;
            color: #6c757d;
        }
        .form-control {
            background-color: #f8f9fa;
            border-left: none;
            font-size: 0.8125rem;
        }
        .form-control:focus {
            background-color: #ffffff;
            box-shadow: none;
            border-color: #dee2e6;
        }
        .input-group:focus-within .input-group-text,
        .input-group:focus-within .form-control {
            border-color: #1b4332;
        }
        .btn-custom {
            background-color: #1b4332;
            color: #ffffff;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 8px;
            border-radius: 8px;
        }
        .btn-custom:hover {
            background-color: #2d6a4f;
            color: #ffffff;
        }
        .text-smartfarm {
            color: #1b4332;
        }
        .text-smartfarm:hover {
            color: #2d6a4f;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100">

    <div class="card card-login border-0 shadow-lg overflow-hidden">
        
        <!-- Header / Logo -->
        <div class="card-body text-center pt-4 pb-3 px-4">
            <div class="logo-circle">
                <i class="fa-solid fa-tractor"></i>
            </div>
            <h1 class="brand-title">SmartFarm</h1>
            <p class="text-muted small mb-0">Sistem Manajemen Pertanian Modern</p>
        </div>

        <hr class="m-0 text-black-50">

        <!-- Form Login -->
        <form action="{{ route('login') }}" method="POST" class="card-body p-4">
            @csrf

            <!-- Field Email -->
            <div class="mb-3">
                <label for="email" class="form-label text-dark fw-semibold mb-1" style="font-size: 0.75rem;">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-regular fa-envelope"></i></span>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        placeholder="nama@email.com" 
                        value="{{ old('email') }}"
                        required
                    >
                </div>
                @error('email')
                    <div class="text-danger mt-1" style="font-size: 0.6875rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Field Password -->
            <div class="mb-3">
                <label for="password" class="form-label text-dark fw-semibold mb-1" style="font-size: 0.75rem;">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-control @error('password') is-invalid @enderror" 
                        placeholder="••••••••" 
                        required
                    >
                </div>
                @error('password')
                    <div class="text-danger mt-1" style="font-size: 0.6875rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember Me & Lupa Password -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label text-muted" for="remember" style="font-size: 0.75rem;">
                        Ingat Saya
                    </label>
                </div>
                <a href="{{ route('password.request') }}" class="text-decoration-none fw-semibold text-smartfarm" style="font-size: 0.75rem;">
                    Lupa Password?
                </a>
            </div>

            <!-- Tombol Submit -->
            <button type="submit" class="btn btn-custom w-full w-100">Login</button>
        </form>

        <hr class="m-0 text-black-50">

        <!-- Footer / Register Link -->
        <div class="card-footer text-center bg-light border-0 py-3">
            <span class="text-muted" style="font-size: 0.75rem;">Belum punya akun? </span>
            <a href="{{ route('register') }}" class="text-decoration-none fw-bold text-smartfarm" style="font-size: 0.75rem;">Register</a>
        </div>

    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>