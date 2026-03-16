@extends('layouts.app')
@section('title', 'Kelola Kategori - Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0"><i class="bi bi-tags me-2 text-primary"></i>Kelola Kategori</h4>
        <small class="text-muted">Total: {{ $kategoris->total() }} kategori</small>
    </div>
    <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i>Tambah Kategori
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th style="width:50px">#</th>
                    <th>Nama Kategori</th>
                    <th>Jumlah Barang</th>
                    <th style="width:160px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategoris as $i => $kat)
                <tr>
                    <td class="text-muted small">{{ $kategoris->firstItem() + $i }}</td>
                    <td class="fw-semibold">{{ $kat->nama_kategori }}</td>
                    <td><span class="badge bg-secondary">{{ $kat->barang_count }} barang</span></td>
                    <td>
                        <a href="{{ route('admin.kategori.edit', $kat) }}" class="btn btn-sm btn-outline-warning me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.kategori.destroy', $kat) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Yakin ingin menghapus kategori ini? Semua barang dalam kategori ini juga akan terhapus.')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-2 d-block mb-2"></i>Belum ada kategori
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($kategoris->hasPages())
    <div class="card-footer bg-white">{{ $kategoris->links() }}</div>
    @endif
</div>
@endsection
