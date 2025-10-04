<!DOCTYPE html>
<html>
<head>
    <title>Ajukan Permintaan Bahan - MBG</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h3>Ajukan Permintaan Bahan Baku</h3>
    <a href="/dapur" class="btn btn-secondary mb-3">← Kembali</a>

    <form method="POST" action="/dapur/permintaan/simpan" id="formPermintaan" onsubmit="return confirm('Ajukan permintaan ini?')">
        @csrf
        <div class="row mb-3">
            <div class="col-md-4">
                <label>Tanggal Masak</label>
                <input type="date" name="tgl_masak" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label>Menu</label>
                <input type="text" name="menu_makan" class="form-control" placeholder="ayam bakar + lalapan" required>
            </div>
            <div class="col-md-4">
                <label>Jumlah Porsi</label>
                <input type="number" name="jumlah_porsi" class="form-control" min="1" required>
            </div>
        </div>

        <h5>Daftar Bahan yang Diminta</h5>
        <div id="daftarBahan">
        </div>
        <button type="button" class="btn btn-sm btn-outline-primary" onclick="tambahBarisBahan()">+ Tambah Bahan</button>

        <button type="submit" class="btn btn-success mt-3">Ajukan Permintaan</button>
    </form>
</div>

<script>
    let bahanList = @json($bahanLayak);

    function tambahBarisBahan() {
        const container = document.getElementById('daftarBahan');
        const index = container.children.length;

        let options = '<option value="">-- Pilih Bahan --</option>';
        bahanList.forEach(b => {
            options += `<option value="${b.id}">${b.nama} (${b.jumlah} ${b.satuan} tersedia)</option>`;
        });

        const baris = `
            <div class="row mb-2">
                <div class="col-md-6">
                    <select name="bahan_id[]" class="form-control" required>${options}</select>
                </div>
                <div class="col-md-5">
                    <input type="number" name="jumlah_diminta[]" class="form-control" min="1" placeholder="Jumlah" required>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-sm btn-danger" onclick="this.closest('.row').remove()">×</button>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', baris);
    }
</script>
</body>
</html>