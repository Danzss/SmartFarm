<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catat Tanaman Baru - SmartFarm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">
    <div class="container" style="max-width: 600px;">
        <div class="card shadow-sm border-0 rounded-4 p-4">
            <h4 class="fw-bold mb-3 text-success">Catat Data Tanaman Baru</h4>
            <form action="{{ route('tanaman.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Tanaman / Komoditas</label>
                    <input type="text" name="nama" class="form-control" placeholder="Contoh: Tomat Cherry" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Sektor Lahan</label>
                    <select name="lokasi" class="form-select" required>
                        <option value="Sektor A">Sektor A</option>
                        <option value="Sektor B">Sektor B</option>
                        <option value="Sektor C">Sektor C</option>
                        <option value="Sektor D">Sektor D</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Jumlah Tanaman</label>
                    <input type="number" name="populasi" class="form-control" placeholder="Contoh: 1500" required>
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-success">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>