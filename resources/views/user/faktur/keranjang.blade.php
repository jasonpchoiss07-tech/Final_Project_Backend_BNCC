@extends('layouts.app')
@section('title', 'Keranjang Belanja')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-cart3 me-2 text-primary"></i>Keranjang Belanja</h4>
    @if(!empty($keranjang))
        <form action="{{ route('user.keranjang.clear') }}" method="POST"
            onsubmit="return confirm('Kosongkan semua keranjang?')">
            @csrf @method('DELETE')
            <button class="btn btn-outline-danger btn-sm">
                <i class="bi bi-trash me-1"></i>Kosongkan
            </button>
        </form>
    @endif
</div>

@if(empty($keranjang))
    <div class="text-center py-5 text-muted">
        <i class="bi bi-cart-x fs-1 d-block mb-3"></i>
        <h5>Keranjang masih kosong</h5>
        <a href="{{ route('user.katalog') }}" class="btn btn-primary mt-2">
            <i class="bi bi-grid me-1"></i>Lihat Katalog
        </a>
    </div>
@else
<div class="row">
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Barang</th>
                            <th>Harga</th>
                            <th style="width:140px">Kuantitas</th>
                            <th>Subtotal</th>
                            <th style="width:50px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($keranjang as $key => $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @if($item['foto_barang'])
                                        <img src="{{ asset('storage/' . $item['foto_barang']) }}" class="img-thumbnail-sm">
                                    @else
                                        <div class="img-thumbnail-sm d-flex align-items-center justify-content-center bg-light text-muted">
                                            <i class="bi bi-image"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-semibold">{{ $item['nama_barang'] }}</div>
                                        <span class="badge-kategori">{{ $item['nama_kategori'] }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>Rp. {{ number_format($item['harga_barang'], 0, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('user.keranjang.update', $item['barang_id']) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="kuantitas" class="form-control"
                                            value="{{ $item['kuantitas'] }}" min="1"
                                            onchange="this.form.submit()">
                                    </div>
                                </form>
                            </td>
                            <td class="fw-semibold text-primary">Rp. {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                            <td>
                                <form action="{{ route('user.keranjang.hapus', $item['barang_id']) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header py-3">Ringkasan Belanja</div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Jumlah Item</span>
                    <span class="fw-semibold">{{ count($keranjang) }}</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-3">
                    <span class="fw-bold">Total</span>
                    <span class="fw-bold text-primary fs-5">Rp. {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <a href="{{ route('user.faktur.create') }}" class="btn btn-primary w-100">
                    <i class="bi bi-receipt me-2"></i>Buat Faktur
                </a>
                <a href="{{ route('user.katalog') }}" class="btn btn-outline-secondary w-100 mt-2">
                    <i class="bi bi-arrow-left me-1"></i>Lanjut Belanja
                </a>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
