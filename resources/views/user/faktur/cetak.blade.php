<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faktur #{{ $faktur->nomor_invoice }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Arial', sans-serif; background: #fff; color: #222; }
        .invoice-box { max-width: 700px; margin: 30px auto; padding: 30px; border: 1px solid #ddd; border-radius: 8px; }
        .header-logo { font-size: 1.6rem; font-weight: 800; color: #2c3e50; }
        .invoice-title { font-size: 1rem; color: #7f8c8d; }
        .divider { border-top: 2px solid #2c3e50; margin: 15px 0; }
        .table th { background: #2c3e50; color: #fff; font-size: .85rem; }
        .total-row td { background: #eaf4fb; font-weight: bold; font-size: 1.05rem; }
        .badge-kat { background: #e8f4fd; color: #2980b9; padding: 2px 8px; border-radius: 10px; font-size: .8rem; }
        .footer-note { font-size: .8rem; color: #95a5a6; text-align: center; margin-top: 20px; }
        .print-btn { display: block; text-align: center; margin-bottom: 20px; }
        @media print {
            .print-btn { display: none !important; }
            .invoice-box { border: none; margin: 0; padding: 10px; }
        }
    </style>
</head>
<body>
<div class="print-btn">
    <button onclick="window.print()" class="btn btn-primary me-2">
        <i class="bi bi-printer me-1"></i>Cetak / Simpan PDF
    </button>
    <a href="{{ route('user.faktur.show', $faktur) }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
</div>

<div class="invoice-box">
    {{-- Header --}}
    <div class="row align-items-center">
        <div class="col-7">
            <div class="header-logo">🛒 ChipiChapa Store</div>
            <div class="invoice-title">Faktur Pembelian</div>
        </div>
        <div class="col-5 text-end">
            <div class="fw-bold text-primary">{{ $faktur->nomor_invoice }}</div>
            <div class="text-muted small">{{ $faktur->created_at->format('d M Y, H:i') }} WIB</div>
        </div>
    </div>

    <div class="divider"></div>

    {{-- Info Pembeli --}}
    <div class="row mb-3">
        <div class="col-6">
            <table class="table table-borderless table-sm mb-0">
                <tr>
                    <td class="text-muted" style="width:110px;">Nama</td>
                    <td class="fw-semibold">{{ $faktur->user->nama_lengkap }}</td>
                </tr>
                <tr>
                    <td class="text-muted">Email</td>
                    <td>{{ $faktur->user->email }}</td>
                </tr>
                <tr>
                    <td class="text-muted">No. HP</td>
                    <td>{{ $faktur->user->nomor_handphone }}</td>
                </tr>
            </table>
        </div>
        <div class="col-6">
            <table class="table table-borderless table-sm mb-0">
                <tr>
                    <td class="text-muted" style="width:110px;">Alamat</td>
                    <td>{{ $faktur->alamat_pengiriman }}</td>
                </tr>
                <tr>
                    <td class="text-muted">Kode Pos</td>
                    <td class="fw-semibold">{{ $faktur->kode_pos }}</td>
                </tr>
            </table>
        </div>
    </div>

    {{-- Items --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width:35px">No</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th class="text-center" style="width:50px">Qty</th>
                <th class="text-end">Harga Satuan</th>
                <th class="text-end">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($faktur->items as $i => $item)
            <tr>
                <td class="text-center text-muted">{{ $i + 1 }}</td>
                <td class="fw-semibold">{{ $item->barang->nama_barang }}</td>
                <td><span class="badge-kat">{{ $item->barang->kategori->nama_kategori }}</span></td>
                <td class="text-center">{{ $item->kuantitas }}</td>
                <td class="text-end">Rp. {{ number_format($item->barang->harga_barang, 0, ',', '.') }}</td>
                <td class="text-end fw-semibold">Rp. {{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="5" class="text-end">TOTAL PEMBAYARAN</td>
                <td class="text-end text-primary">Rp. {{ number_format($faktur->total_harga, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="divider"></div>

    <div class="row align-items-end">
        <div class="col-7">
            <div class="footer-note">
                Terima kasih telah berbelanja di ChipiChapa Store.<br>
                Simpan faktur ini sebagai bukti pembayaran Anda.
            </div>
        </div>
        <div class="col-5 text-center">
            <div class="text-muted small mb-4">Tanda Tangan Pembeli</div>
            <div style="border-bottom: 1px solid #bbb; margin: 0 20px;"></div>
            <div class="text-muted small mt-1">{{ $faktur->user->nama_lengkap }}</div>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
