<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Gudang - MBG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h2>Selamat Datang, Petugas Gudang</h2>
    <p>Halo, {{ session('name') }}!</p>

    <div class="btn-group mb-3" role="group">
        <a href="/gudang/bahan/tambah" class="btn btn-primary">+ Tambah Bahan Baku</a>
        <!-- Nanti tambah link lain: Lihat Bahan, dll -->
    </div>

    <a href="{{ route('logout') }}" class="btn btn-outline-danger">Logout</a>
</div>
</body>
</html>