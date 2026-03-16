@extends('layouts.app')
@section('title', 'Edit Barang - Admin')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.barang.index') }}" class="text-decoration-none text-muted small">
        <i class="bi bi-arrow-left me-1"></i>Kembali ke daftar barang
    </a>
    <h4 class="fw-bold mt-1"><i class="bi bi-pencil-square me-2 text-warning"></i>Edit Barang</h4>
</div>

<div class="row">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header py-3">Form Edit Barang</div>
            <div class="card-body p-4">

                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <div><i class="bi bi-exclamation-circle me-1"></i>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('admin.barang.update', $barang) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kategori Barang <span class="text-danger">*</span></label>
                        <select name="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoris as $kat)
                                <option value="{{ $kat->id }}"
                                    {{ (old('kategori_id', $barang->kategori_id) == $kat->id) ? 'selected' : '' }}>
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
                            value="{{ old('nama_barang', $barang->nama_barang) }}"
                            minlength="5" maxlength="80" required>
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
                                value="{{ old('harga_barang', $barang->harga_barang) }}" min="0" required>
                            @error('harga_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jumlah Barang <span class="text-danger">*</span></label>
                        <input type="number" name="jumlah_barang"
                            class="form-control @error('jumlah_barang') is-invalid @enderror"
                            value="{{ old('jumlah_barang', $barang->jumlah_barang) }}" min="0" required>
                        @error('jumlah_barang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Foto Barang</label>
                        @if($barang->foto_barang)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $barang->foto_barang) }}" alt="Foto saat ini"
                                    style="height:100px; border-radius:8px;">
                                <small class="text-muted d-block mt-1">Foto saat ini. Upload baru untuk mengganti.</small>
                            </div>
                        @endif
                        <input type="file" name="foto_barang" id="foto_barang"
                            class="form-control @error('foto_barang') is-invalid @enderror"
                            accept="image/*" onchange="previewImage(this)">
                        @error('foto_barang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="mt-2" id="preview-container" style="display:none;">
                            <img id="preview-image" src="#" alt="Preview" style="max-height:120px; border-radius:8px;">
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning px-4">
                            <i class="bi bi-save me-2"></i>Update Barang
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
