<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - SmartFarm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #222529; font-size: 0.875rem; }
        .card-reset { border-radius: 16px; max-width: 360px; width: 100%; }
        .logo-circle { width: 64px; height: 64px; background-color: #1b4332; color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; font-size: 1.5rem; }
        .brand-title { color: #1b4332; font-weight: 700; font-size: 1.5rem; }
        .btn-custom { background-color: #1b4332; color: #fff; font-weight: 600; font-size: 0.875rem; padding: 10px; border-radius: 8px; }
        .btn-custom:hover { background-color: #2d6a4f; color: #fff; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 py-4">

    <div class="card card-reset border-0 shadow-lg overflow-hidden">
        <div class="card-body text-center pt-4 pb-3 px-4">
            <div class="logo-circle"><i class="fa-solid fa-tractor"></i></div>
            <h1 class="brand-title">SmartFarm</h1>
            <p class="text-muted small mb-0">Buat password baru akun kamu.</p>
        </div>

        <hr class="m-0 text-black-50">

        <form action="{{ route('password.update') }}" method="POST" class="card-body p-4">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            {{-- Alert Error Global (misal jika token expired / email mismatch) --}}
            @if ($errors->has('email'))
                <div class="alert alert-danger py-2 px-3 small mb-3">
                    {{ $errors->first('email') }}
                </div>
            @endif

            <div class="mb-3">
                <label for="email" class="form-label text-dark fw-semibold mb-1" style="font-size: 0.75rem;">Email</label>
                {{-- Fallback nilai email diambil dari $email atau request query --}}
                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $email ?? request('email')) }}" required readonly>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label text-dark fw-semibold mb-1" style="font-size: 0.75rem;">Password Baru</label>
                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" required>
                @error('password')
                    <div class="text-danger mt-1" style="font-size: 0.6875rem;">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label text-dark fw-semibold mb-1" style="font-size: 0.75rem;">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn btn-custom w-100">Simpan Password Baru</button>
        </form>
    </div>

</body>
</html>