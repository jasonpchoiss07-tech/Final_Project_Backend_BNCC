@extends('layouts.app')
@section('title', 'Detail Faktur #' . $faktur->nomor_invoice)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 no-print">
    <div>
        <a href="{{ route('user.faktur.history') }}" class="text-decoration-none text-muted small">
            <i class="bi bi-arrow-left me-1"></i>Riwayat Faktur
        </a>
        <h4 class="fw-bold mt-1"><i class="bi bi-receipt me-2 text-primary"></i>Detail Faktur</h4>
    </div>
    <a href="{{ route('user.faktur.cetak', $faktur) }}" class="btn btn-success" target="_blank">
        <i class="bi bi-printer me-2"></i>Cetak Faktur
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between mb-3">
                    <div>
                        <h5 class="fw-bold text-primary">ChipiChapa Store</h5>
                        <small class="text-muted">Faktur Pembelian</small>
                    </div>
                    <div class="text-end">
                        <div class="fw-bold">{{ $faktur->nomor_invoice }}</div>
                        <small class="text-muted">{{ $faktur->created_at->format('d M Y, H:i') }}</small>
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-6">
                        <small class="text-muted d-block">Pembeli</small>
                        <span class="fw-semibold">{{ $faktur->user->nama_lengkap }}</span>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block">Kode Pos</small>
                        <span class="fw-semibold">{{ $faktur->kode_pos }}</span>
                    </div>
                    <div class="col-12 mt-2">
                        <small class="text-muted d-block">Alamat Pengiriman</small>
                        <span class="fw-semibold">{{ $faktur->alamat_pengiriman }}</span>
                    </div>
                </div>
                <hr>
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th>Barang</th>
                            <th>Kategori</th>
                            <th>Harga Satuan</th>
                            <th>Qty</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($faktur->items as $item)
                        <tr>
                            <td class="fw-semibold">{{ $item->barang->nama_barang }}</td>
                            <td><span class="badge-kategori">{{ $item->barang->kategori->nama_kategori }}</span></td>
                            <td>Rp. {{ number_format($item->barang->harga_barang, 0, ',', '.') }}</td>
                            <td>x{{ $item->kuantitas }}</td>
                            <td class="text-end fw-semibold">Rp. {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-end fw-bold">Total Pembayaran</td>
                            <td class="text-end fw-bold text-primary fs-5">
                                Rp. {{ number_format($faktur->total_harga, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
