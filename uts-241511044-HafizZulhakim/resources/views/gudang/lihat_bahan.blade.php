<!DOCTYPE html>
<html>
<head>
    <title>Data Bahan Baku - MBG</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .status-tersedia { background-color: #d4edda; color: #155724; }
        .status-segera_kadaluarsa { background-color: #fff3cd; color: #856404; }
        .status-kadaluarsa { background-color: #f8d7da; color: #721c24; }
        .status-habis { background-color: #e2e3e5; color: #495057; }
    </style>
</head>
<body class="bg-light">
<div class="container mt-4">
    <h2>Data Bahan Baku</h2>
    <a href="/gudang" class="btn btn-secondary mb-3">← Kembali ke Dashboard</a>
    <a href="/gudang/bahan/tambah" class="btn btn-primary mb-3">+ Tambah Bahan Baku</a>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Tgl Masuk</th>
                    <th>Tgl Kadaluarsa</th>
                    <th>Status</th>
                    <th>Aksi</th> <!-- Kolom Aksi -->
                </tr>
            </thead>
            <tbody>
                @foreach($bahanDenganStatus as $b)
                <tr>
                    <td>{{ $b->nama }}</td>
                    <td>{{ $b->kategori }}</td>
                    <td>{{ $b->jumlah }}</td>
                    <td>{{ $b->satuan }}</td>
                    <td>{{ $b->tanggal_masuk }}</td>
                    <td>{{ $b->tanggal_kadaluarsa }}</td>
                    <td>
                        <span class="badge status-{{ $b->status_real }}">
                            {{ ucfirst(str_replace('_', ' ', $b->status_real)) }}
                        </span>
                    </td>
                    <td>
                        <!-- Tombol untuk Edit Stok -->
                        <a href="/gudang/bahan/{{ $b->id }}/edit-stok" class="btn btn-sm btn-warning">Edit Stok</a>
                        @if($b->status_real === 'kadaluarsa')
                            <a href="/gudang/bahan/{{ $b->id }}/hapus" class="btn btn-sm btn-danger ms-1">Hapus</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</body>
</html>