<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Faktur;
use App\Models\FakturItem;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FakturController extends Controller
{
    public function create()
    {
        $keranjang = session()->get('keranjang', []);
        if (empty($keranjang)) {
            return redirect()->route('user.katalog')->with('error', 'Keranjang masih kosong.');
        }
        $total = array_sum(array_column($keranjang, 'subtotal'));
        return view('user.faktur.create', compact('keranjang', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'alamat_pengiriman' => 'required|string|min:10|max:100',
            'kode_pos'          => ['required', 'string', 'regex:/^[0-9]{5}$/'],
        ], [
            'kode_pos.regex' => 'Kode pos harus 5 digit angka.',
        ]);

        $keranjang = session()->get('keranjang', []);
        if (empty($keranjang)) {
            return redirect()->route('user.katalog')->with('error', 'Keranjang masih kosong.');
        }

        // Check stok
        foreach ($keranjang as $item) {
            $barang = Barang::find($item['barang_id']);
            if (!$barang || $barang->jumlah_barang < $item['kuantitas']) {
                return back()->with('error', "Stok barang '{$item['nama_barang']}' tidak mencukupi.");
            }
        }

        $total         = array_sum(array_column($keranjang, 'subtotal'));
        $nomorInvoice  = 'INV-' . strtoupper(Str::random(8)) . '-' . date('Ymd');

        $faktur = Faktur::create([
            'nomor_invoice'     => $nomorInvoice,
            'user_id'           => auth()->id(),
            'alamat_pengiriman' => $request->alamat_pengiriman,
            'kode_pos'          => $request->kode_pos,
            'total_harga'       => $total,
        ]);

        foreach ($keranjang as $item) {
            FakturItem::create([
                'faktur_id'  => $faktur->id,
                'barang_id'  => $item['barang_id'],
                'kuantitas'  => $item['kuantitas'],
                'subtotal'   => $item['subtotal'],
            ]);

            // Kurangi stok barang
            Barang::where('id', $item['barang_id'])->decrement('jumlah_barang', $item['kuantitas']);
        }

        session()->forget('keranjang');

        return redirect()->route('user.faktur.show', $faktur->id)->with('success', 'Faktur berhasil disimpan!');
    }

    public function show(Faktur $faktur)
    {
        if ($faktur->user_id !== auth()->id()) {
            abort(403);
        }
        $faktur->load('items.barang.kategori', 'user');
        return view('user.faktur.show', compact('faktur'));
    }

    public function history()
    {
        $fakturs = Faktur::where('user_id', auth()->id())->latest()->paginate(10);
        return view('user.faktur.history', compact('fakturs'));
    }

    public function cetak(Faktur $faktur)
    {
        if ($faktur->user_id !== auth()->id()) {
            abort(403);
        }
        $faktur->load('items.barang.kategori', 'user');
        return view('user.faktur.cetak', compact('faktur'));
    }
}
