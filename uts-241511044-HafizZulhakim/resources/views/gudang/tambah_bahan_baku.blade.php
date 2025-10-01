<!DOCTYPE html>
<html>
<head>
    <title>Tambah Bahan Baku - MBG</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h2>Tambah Bahan Baku</h2>
    <a href="/gudang" class="btn btn-secondary mb-3">← Kembali ke Dashboard</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="/gudang/bahan/simpan">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label>Nama Bahan</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Kategori</label>
                    <input type="text" name="kategori" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Jumlah</label>
                    <input type="number" name="jumlah" class="form-control" min="0" required>
                </div>
                <div class="mb-3">
                    <label>Satuan</label>
                    <input type="text" name="satuan" class="form-control" placeholder="kg, butir, liter, dll" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label>Tanggal Masuk</label>
                    <input type="date" name="tanggal_masuk" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Tanggal Kadaluarsa</label>
                    <input type="date" name="tanggal_kadaluarsa" class="form-control" required>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-success" onclick="return confirm('Simpan data bahan baku ini?')">Simpan Bahan</button>
    </form>
</div>
</body>
</html>