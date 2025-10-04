<!DOCTYPE html>
<html>
<head>
    <title>Konfirmasi Hapus - {{ $bahan->nama }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <div class="card border-danger">
        <div class="card-header bg-danger text-white">
            <h4>Konfirmasi Hapus Bahan Baku</h4>
        </div>
        <div class="card-body">
            <p><strong>Anda yakin ingin menghapus bahan berikut?</strong></p>
            <table class="table table-bordered">
                <tr>
                    <th>Nama</th>
                    <td>{{ $bahan->nama }}</td>
                </tr>
                <tr>
                    <th>Kategori</th>
                    <td>{{ $bahan->kategori }}</td>
                </tr>
                <tr>
                    <th>Jumlah</th>
                    <td>{{ $bahan->jumlah }} {{ $bahan->satuan }}</td>
                </tr>
                <tr>
                    <th>Tanggal Kadaluarsa</th>
                    <td>{{ $bahan->tanggal_kadaluarsa }} <span class="text-danger">(SUDAH KADALUARSA)</span></td>
                </tr>
            </table>

            <form method="POST" action="/gudang/bahan/{{ $bahan->id }}/proses-hapus" class="mt-3">
                @csrf
                <a href="/gudang/bahan" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus data ini? Tindakan tidak bisa dibatalkan!')">Hapus Permanen</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>