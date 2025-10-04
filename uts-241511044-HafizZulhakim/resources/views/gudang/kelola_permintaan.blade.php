<!DOCTYPE html>
<html>
<head>
    <title>Kelola Permintaan - MBG</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h2>Permintaan Menunggu Persetujuan</h2>
    <a href="/gudang" class="btn btn-secondary mb-3">← Kembali ke Dashboard</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    @if($permintaanList->isEmpty())
        <div class="alert alert-info">Tidak ada permintaan menunggu.</div>
    @else
        @foreach($permintaanList as $p)
        <div class="card mb-3">
            <div class="card-body">
                <h5>{{ $p->menu_makan }} <span class="badge bg-warning text-dark">Menunggu</span></h5>
                <p>
                    <strong>Dapur:</strong> {{ $p->nama_dapur }}<br>
                    <strong>Tgl Masak:</strong> {{ $p->tgl_masak }}<br>
                    <strong>Porsi:</strong> {{ $p->jumlah_porsi }}
                </p>
                <h6>Bahan yang Diminta:</h6>
                <ul>
                    @foreach($p->detail as $d)
                        <li>{{ $d->nama_bahan }}: {{ $d->jumlah_diminta }} {{ $d->satuan }} 
                            @if($d->stok_tersedia < $d->jumlah_diminta)
                                <span class="text-danger">(Stok tidak cukup!)</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
                <a href="/gudang/permintaan/{{ $p->id }}/acc" class="btn btn-success btn-sm" onclick="return confirm('Setujui permintaan ini?')">ACC</a>
                <a href="/gudang/permintaan/{{ $p->id }}/tolak" class="btn btn-danger btn-sm" onclick="return confirm('Tolak permintaan ini?')">Tolak</a>
            </div>
        </div>
        @endforeach
    @endif
</div>
</body>
</html>