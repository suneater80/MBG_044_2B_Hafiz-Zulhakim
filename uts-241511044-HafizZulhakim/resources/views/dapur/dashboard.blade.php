<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Dapur </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h2>Halo Petugas Dapur</h2>
    <a href="/dapur/permintaan/buat" class="btn btn-primary">+ Ajukan Permintaan Bahan</a>
    <a href="/dapur/permintaan" class="btn btn-info">Lihat Status Permintaan</a>
    <a href="{{ route('logout') }}" class="btn btn-outline-danger ms-2">Logout</a>
</div>
</body>
</html>