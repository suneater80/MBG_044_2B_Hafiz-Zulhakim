<!DOCTYPE html>
<html>
<head>
    <title>Status Permintaan dapur - MBG</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h2>Status Permintaan Bahan Baku</h2>
    <a href="/dapur" class="btn btn-secondary mb-3">← Kembali ke Dashboard</a>

    @if($permintaanList->isEmpty())
        <div class="alert alert-info">Belum ada permintaan bahan.</div>
    @else
        @foreach($permintaanList as $p)
        <div class="card mb-4">
            <div class="card-header">
                <strong>{{ $p->menu_makan }}</strong> 
                <span class="badge bg-{{ $p->status == 'menunggu' ? 'warning' : ($p->status == 'disetujui' ? 'success' : 'danger') }} text-dark">
                    {{ ucfirst($p->status) }}
                </span>
            </div>
            <div class="card-body">
                <p>
                    <strong>Tanggal Masak:</strong> {{ $p->tgl_masak }}<br>
                    <strong>Jumlah Porsi:</strong> {{ $p->jumlah_porsi }}
                </p>
                <h6>Bahan yang Diminta:</h6>
                <ul>
                    @foreach($p->detail as $d)
                        <li>{{ $d->nama_bahan }}: {{ $d->jumlah_diminta }} {{ $d->satuan }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endforeach
    @endif
</div>
</body>
</html>