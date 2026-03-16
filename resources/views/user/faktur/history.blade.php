@extends('layouts.app')
@section('title', 'Riwayat Faktur')

@section('content')
<div class="mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-clock-history me-2 text-primary"></i>Riwayat Faktur</h4>
    <small class="text-muted">Semua transaksi pembelian Anda</small>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>No. Invoice</th>
                    <th>Tanggal</th>
                    <th>Alamat Pengiriman</th>
                    <th>Kode Pos</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($fakturs as $faktur)
                <tr>
                    <td class="fw-semibold text-primary">{{ $faktur->nomor_invoice }}</td>
                    <td class="text-muted small">{{ $faktur->created_at->format('d M Y, H:i') }}</td>
                    <td>{{ Str::limit($faktur->alamat_pengiriman, 40) }}</td>
                    <td>{{ $faktur->kode_pos }}</td>
                    <td class="fw-semibold">Rp. {{ number_format($faktur->total_harga, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('user.faktur.show', $faktur) }}" class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('user.faktur.cetak', $faktur) }}" class="btn btn-sm btn-outline-success" target="_blank">
                            <i class="bi bi-printer"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="bi bi-receipt fs-2 d-block mb-2"></i>Belum ada faktur
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($fakturs->hasPages())
    <div class="card-footer bg-white">{{ $fakturs->links() }}</div>
    @endif
</div>
@endsection
