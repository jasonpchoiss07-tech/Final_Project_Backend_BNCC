@extends('layouts.app')
@section('title', 'Edit Kategori - Admin')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.kategori.index') }}" class="text-decoration-none text-muted small">
        <i class="bi bi-arrow-left me-1"></i>Kembali ke daftar kategori
    </a>
    <h4 class="fw-bold mt-1"><i class="bi bi-pencil-square me-2 text-warning"></i>Edit Kategori</h4>
</div>

<div class="row">
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header py-3">Form Edit Kategori</div>
            <div class="card-body p-4">
                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <div><i class="bi bi-exclamation-circle me-1"></i>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
                <form action="{{ route('admin.kategori.update', $kategori) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="nama_kategori"
                            class="form-control @error('nama_kategori') is-invalid @enderror"
                            value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required>
                        @error('nama_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning px-4">
                            <i class="bi bi-save me-2"></i>Update
                        </button>
                        <a href="{{ route('admin.kategori.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
