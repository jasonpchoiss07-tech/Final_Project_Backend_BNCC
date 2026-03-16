@extends('layouts.app')
@section('title', 'Katalog Barang')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0"><i class="bi bi-grid me-2 text-primary"></i>Katalog Barang</h4>
        <small class="text-muted">Temukan barang yang kamu butuhkan</small>
    </div>
</div>

<div class="row g-3">
    @forelse($barang as $item)
    <div class="col-sm-6 col-md-4 col-xl-3">
        <div class="card h-100">
            <div style="height:180px; overflow:hidden; border-radius:10px 10px 0 0; background:#f0f4f8;">
                @if($item->foto_barang)
                    <img src="{{ asset('storage/' . $item->foto_barang) }}"
                        alt="{{ $item->nama_barang }}"
                        style="width:100%; height:100%; object-fit:cover;">
                @else
                    <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted">
                        <i class="bi bi-image fs-1"></i>
                    </div>
                @endif
            </div>
            <div class="card-body d-flex flex-column">
                <span class="badge-kategori mb-2 d-inline-block">{{ $item->kategori->nama_kategori }}</span>
                <h6 class="card-title fw-bold mb-1">{{ $item->nama_barang }}</h6>
                <p class="text-primary fw-bold mb-1">Rp. {{ number_format($item->harga_barang, 0, ',', '.') }}</p>
                <p class="text-muted small mb-3">
                    @if($item->jumlah_barang <= 0)
                        <span class="text-danger"><i class="bi bi-x-circle me-1"></i>Stok habis</span>
                    @else
                        <i class="bi bi-check-circle me-1 text-success"></i>Stok: {{ $item->jumlah_barang }}
                    @endif
                </p>

                @if($item->jumlah_barang <= 0)
                    <button class="btn btn-secondary btn-sm mt-auto" disabled>
                        <i class="bi bi-cart-x me-1"></i>Stok Habis
                    </button>
                @else
                    <form action="{{ route('user.keranjang.tambah', $item) }}" method="POST" class="mt-auto">
                        @csrf
                        <div class="input-group input-group-sm mb-2">
                            <span class="input-group-text">Qty</span>
                            <input type="number" name="kuantitas" class="form-control"
                                value="1" min="1" max="{{ $item->jumlah_barang }}">
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm w-100">
                            <i class="bi bi-cart-plus me-1"></i>Masukkan ke Keranjang
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="text-center py-5 text-muted">
            <i class="bi bi-inbox fs-1 d-block mb-3"></i>
            <h5>Belum ada barang tersedia</h5>
        </div>
    </div>
    @endforelse
</div>

@if($barang->hasPages())
<div class="mt-4 d-flex justify-content-center">
    {{ $barang->links() }}
</div>
@endif
@endsection
