<!DOCTYPE html>
<html>
<head>
    <title>Edit Stok - {{ $bahan->nama }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h3>Edit Stok: {{ $bahan->nama }}</h3>
    <a href="/gudang/bahan" class="btn btn-secondary mb-3">← Kembali ke Daftar</a>

    <form method="POST" action="/gudang/bahan/{{ $bahan->id }}/update-stok" onsubmit="return confirm('Simpan perubahan stok ini?')">
        @csrf
        <div class="mb-3">
            <label>Nama Bahan</label>
            <input type="text" class="form-control" value="{{ $bahan->nama }}" disabled>
        </div>
        <div class="mb-3">
            <label>Jumlah Saat Ini: <strong>{{ $bahan->jumlah }} {{ $bahan->satuan }}</strong></label>
            <input type="number" name="jumlah" class="form-control" value="{{ $bahan->jumlah }}" min="0" required>
            <div class="form-text">Masukkan jumlah stok baru (tidak boleh negatif).</div>
        </div>
        <button type="submit" class="btn btn-warning">Perbarui Stok</button>
    </form>
</div>
</body>
</html>