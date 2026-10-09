<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SmartFarm</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CDN untuk Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background-color: #ffffff;
            font-size: 0.875rem;
        }
        .card-register {
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
            padding: 10px;
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
<body class="d-flex align-items-center justify-content-center min-vh-100 py-4">

    <div class="card card-register border-0 shadow-lg overflow-hidden">
        
        <!-- Header / Logo Section -->
        <div class="card-body text-center pt-4 pb-3 px-4">
            <div class="logo-circle">
                <i class="fa-solid fa-tractor"></i>
            </div>
            <h1 class="brand-title">SmartFarm</h1>
            <p class="text-muted small mb-0">Create an account to manage your farm.</p>
        </div>

        <hr class="m-0 text-black-50">

        <!-- Form Register -->
        <form action="{{ route('register') }}" method="POST" class="card-body p-4">
            @csrf

            <!-- Field Full Name -->
            <div class="mb-3">
                <label for="name" class="form-label text-dark fw-semibold mb-1" style="font-size: 0.75rem;">Full Name</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-regular fa-user"></i></span>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        class="form-control @error('name') is-invalid @enderror" 
                        placeholder="John Doe" 
                        value="{{ old('name') }}"
                        required
                    >
                </div>
                @error('name')
                    <div class="text-danger mt-1" style="font-size: 0.6875rem;">{{ $message }}</div>
                @enderror
            </div>

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
                        placeholder="john@example.com" 
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

            <!-- Field Confirm Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="form-label text-dark fw-semibold mb-1" style="font-size: 0.75rem;">Confirm Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-solid fa-rotate-left"></i></span>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        class="form-control" 
                        placeholder="••••••••" 
                        required
                    >
                </div>
            </div>

            <!-- Tombol Submit Register -->
            <button type="submit" class="btn btn-custom w-100 d-flex align-items-center justify-content-center gap-2">
                <span>Register</span>
                <i class="fa-solid fa-user-plus" style="font-size: 0.75rem;"></i>
            </button>
        </form>

        <hr class="m-0 text-black-50">

        <!-- Footer / Login Link -->
        <div class="card-footer text-center bg-light border-0 py-3">
            <span class="text-muted" style="font-size: 0.75rem;">Sudah punya akun? </span>
            <a href="{{ route('login') }}" class="text-decoration-none fw-bold text-smartfarm" style="font-size: 0.75rem;">Login</a>
        </div>

    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>