@extends('layouts.app')
@section('title', 'Kelola Barang - Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0"><i class="bi bi-box-seam me-2 text-primary"></i>Kelola Barang</h4>
        <small class="text-muted">Total: {{ $barang->total() }} barang</small>
    </div>
    <a href="{{ route('admin.barang.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Tambah Barang
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width:50px">#</th>
                        <th style="width:60px">Foto</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th style="width:160px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barang as $i => $item)
                    <tr>
                        <td class="text-muted small">{{ $barang->firstItem() + $i }}</td>
                        <td>
                            @if($item->foto_barang)
                                <img src="{{ asset('storage/' . $item->foto_barang) }}" class="img-thumbnail-sm" alt="{{ $item->nama_barang }}">
                            @else
                                <div class="img-thumbnail-sm d-flex align-items-center justify-content-center bg-light text-muted">
                                    <i class="bi bi-image"></i>
                                </div>
                            @endif
                        </td>
                        <td class="fw-semibold">{{ $item->nama_barang }}</td>
                        <td><span class="badge-kategori">{{ $item->kategori->nama_kategori }}</span></td>
                        <td>Rp. {{ number_format($item->harga_barang, 0, ',', '.') }}</td>
                        <td>
                            @if($item->jumlah_barang <= 0)
                                <span class="badge bg-danger">Habis</span>
                            @elseif($item->jumlah_barang <= 5)
                                <span class="badge bg-warning text-dark">{{ $item->jumlah_barang }} (Sedikit)</span>
                            @else
                                <span class="badge bg-success">{{ $item->jumlah_barang }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.barang.edit', $item) }}" class="btn btn-sm btn-outline-warning me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.barang.destroy', $item) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-2 d-block mb-2"></i>Belum ada barang
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($barang->hasPages())
    <div class="card-footer bg-white">
        {{ $barang->links() }}
    </div>
    @endif
</div>
@endsection
