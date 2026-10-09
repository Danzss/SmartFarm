<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SmartFarm Dashboard')</title>
    <!-- Bootstrap CSS & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root {
            --sidebar-width: 240px;
            --primary-green: #1b4332;
            --bg-light: #f8f9fa;
        }

        body {
            background-color: var(--bg-light);
            font-size: 0.875rem;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: #fff;
            border-right: 1px solid #dee2e6;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            padding: 1.25rem 1rem;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            padding: 1.5rem 2rem;
            background-color: var(--bg-light);
            min-height: 100vh;
        }

        .nav-link {
            color: #6c757d;
            font-weight: 500;
            border-radius: 8px;
            margin-bottom: 4px;
            padding: 8px 12px;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: var(--primary-green);
            color: #fff;
        }

        .nav-link i {
            width: 20px;
        }

        .card-custom {
            border: none;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
        }

        @media (max-width: 767.98px) {
            .sidebar {
                width: 200px;
            }

            .main-content {
                margin-left: 200px;
                padding: 1.25rem 1rem;
            }
        }
    </style>
</head>
<body>

    <div class="d-flex">
        <!-- Memanggil Sidebar Terpisah -->
        @include('layouts.sidebar')

        <!-- Konten Utama -->
        <div class="main-content w-100">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>