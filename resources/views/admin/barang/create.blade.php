@extends('layouts.app')
@section('title', 'Tambah Barang - Admin')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.barang.index') }}" class="text-decoration-none text-muted small">
        <i class="bi bi-arrow-left me-1"></i>Kembali ke daftar barang
    </a>
    <h4 class="fw-bold mt-1"><i class="bi bi-plus-circle me-2 text-primary"></i>Tambah Barang Baru</h4>
</div>

<div class="row">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header py-3">Form Tambah Barang</div>
            <div class="card-body p-4">

                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <div><i class="bi bi-exclamation-circle me-1"></i>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('admin.barang.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kategori Barang <span class="text-danger">*</span></label>
                        <select name="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoris as $kat)
                                <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>
                                    {{ $kat->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Barang <span class="text-danger">*</span></label>
                        <input type="text" name="nama_barang"
                            class="form-control @error('nama_barang') is-invalid @enderror"
                            placeholder="Minimal 5, maksimal 80 karakter"
                            value="{{ old('nama_barang') }}" minlength="5" maxlength="80" required>
                        @error('nama_barang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Harga Barang (Rp.) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp.</span>
                            <input type="number" name="harga_barang"
                                class="form-control @error('harga_barang') is-invalid @enderror"
                                placeholder="0" value="{{ old('harga_barang') }}" min="0" required>
                            @error('harga_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jumlah Barang <span class="text-danger">*</span></label>
                        <input type="number" name="jumlah_barang"
                            class="form-control @error('jumlah_barang') is-invalid @enderror"
                            placeholder="0" value="{{ old('jumlah_barang') }}" min="0" required>
                        @error('jumlah_barang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Foto Barang</label>
                        <input type="file" name="foto_barang" id="foto_barang"
                            class="form-control @error('foto_barang') is-invalid @enderror"
                            accept="image/*" onchange="previewImage(this)">
                        @error('foto_barang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="mt-2" id="preview-container" style="display:none;">
                            <img id="preview-image" src="#" alt="Preview" style="max-height:150px; border-radius:8px;">
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-2"></i>Simpan Barang
                        </button>
                        <a href="{{ route('admin.barang.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewImage(input) {
    const container = document.getElementById('preview-container');
    const preview   = document.getElementById('preview-image');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { preview.src = e.target.result; container.style.display = 'block'; };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
