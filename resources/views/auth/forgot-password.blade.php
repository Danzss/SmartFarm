<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - SmartFarm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background-color: #222529;
            font-size: 0.875rem;
        }

        .card-forgot {
            border-radius: 16px;
            max-width: 360px;
            width: 100%;
        }

        .logo-circle {
            width: 64px;
            height: 64px;
            background-color: #1b4332;
            color: #fff;
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
            background-color: #fff;
            box-shadow: none;
            border-color: #dee2e6;
        }

        .input-group:focus-within .input-group-text,
        .input-group:focus-within .form-control {
            border-color: #1b4332;
        }

        .btn-custom {
            background-color: #1b4332;
            color: #fff;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 10px;
            border-radius: 8px;
        }

        .btn-custom:hover {
            background-color: #2d6a4f;
            color: #fff;
        }

        .text-smartfarm {
            color: #1b4332;
        }
    </style>
</head>

<body class="d-flex align-items-center justify-content-center min-vh-100 py-4">

    <div class="card card-forgot border-0 shadow-lg overflow-hidden">
        <div class="card-body text-center pt-4 pb-3 px-4">
            <div class="logo-circle">
                <i class="fa-solid fa-tractor"></i>
            </div>
            <h1 class="brand-title">SmartFarm</h1>
            <p class="text-muted small mb-0">Masukkan email untuk mereset password.</p>
        </div>

        <hr class="m-0 text-black-50">

        <form action="{{ route('password.email') }}" method="POST" class="card-body p-4">
            @csrf

            <!-- Status Pesan Berhasil -->
            @if (session('status'))
                <div class="alert alert-success py-2 px-3 mb-3 text-center" style="font-size: 0.75rem;">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Field Email -->
            <div class="mb-3">
                <label for="email" class="form-label text-dark fw-semibold mb-1"
                    style="font-size: 0.75rem;">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fa-regular fa-envelope"></i></span>
                    <input type="email" id="email" name="email"
                        class="form-control @error('email') is-invalid @enderror" placeholder="nama@email.com"
                        value="{{ old('email') }}" required>
                </div>
                @error('email')
                    <div class="text-danger mt-1" style="font-size: 0.6875rem;">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-custom w-100 mt-2">Kirim Link Reset</button>
        </form>

        <hr class="m-0 text-black-50">

        <div class="card-footer text-center bg-light border-0 py-3">
            <a href="{{ route('login') }}" class="text-decoration-none fw-bold text-smartfarm"
                style="font-size: 0.75rem;">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Login
            </a>
        </div>
    </div>

</body>

</html>