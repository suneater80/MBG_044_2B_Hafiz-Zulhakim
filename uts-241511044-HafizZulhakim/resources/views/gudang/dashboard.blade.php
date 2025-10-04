<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Gudang - MBG</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h2>Selamat Datang, Petugas Gudang</h2>
    <p>Halo, {{ session('name') }}!</p>

    <!-- Tombol navigasi fitur gudang -->
    <div class="mb-4">
        <a href="/gudang/bahan" class="btn btn-info">Lihat Data Bahan Baku</a>
        <a href="/gudang/bahan/tambah" class="btn btn-success ms-2">+ Tambah Bahan Baku</a>
        <a href="/gudang/permintaan" class="btn btn-primary ms-2">Kelola Permintaan</a>
    </div>

    <a href="{{ route('logout') }}" class="btn btn-outline-danger">Logout</a>
</div>
</body>
</html>