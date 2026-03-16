@extends('layouts.app')
@section('title', 'Buat Faktur')

@section('content')
<div class="mb-4">
    <a href="{{ route('user.keranjang') }}" class="text-decoration-none text-muted small">
        <i class="bi bi-arrow-left me-1"></i>Kembali ke keranjang
    </a>
    <h4 class="fw-bold mt-1"><i class="bi bi-receipt me-2 text-primary"></i>Buat Faktur Pembelian</h4>
</div>

<div class="row">
    <div class="col-lg-7">
        <div class="card mb-3">
            <div class="card-header py-3">Ringkasan Barang</div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th>Kategori</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($keranjang as $item)
                        <tr>
                            <td class="fw-semibold">{{ $item['nama_barang'] }}</td>
                            <td><span class="badge-kategori">{{ $item['nama_kategori'] }}</span></td>
                            <td>x{{ $item['kuantitas'] }}</td>
                            <td>Rp. {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="table-light">
                            <td colspan="3" class="fw-bold text-end">Total:</td>
                            <td class="fw-bold text-primary">Rp. {{ number_format($total, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header py-3">Data Pengiriman</div>
            <div class="card-body p-4">
                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <div><i class="bi bi-exclamation-circle me-1"></i>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('user.faktur.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Alamat Pengiriman <span class="text-danger">*</span></label>
                        <textarea name="alamat_pengiriman"
                            class="form-control @error('alamat_pengiriman') is-invalid @enderror"
                            rows="3" placeholder="Minimal 10, maksimal 100 karakter"
                            minlength="10" maxlength="100" required>{{ old('alamat_pengiriman') }}</textarea>
                        @error('alamat_pengiriman')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Kode Pos <span class="text-danger">*</span></label>
                        <input type="text" name="kode_pos"
                            class="form-control @error('kode_pos') is-invalid @enderror"
                            placeholder="5 digit angka (cth: 12345)"
                            value="{{ old('kode_pos') }}" maxlength="5" required>
                        @error('kode_pos')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2">
                        <i class="bi bi-save me-2"></i>Simpan & Buat Faktur
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
