<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function index()
    {
        $keranjang = session()->get('keranjang', []);
        $total     = 0;
        foreach ($keranjang as $item) {
            $total += $item['subtotal'];
        }
        return view('user.faktur.keranjang', compact('keranjang', 'total'));
    }

    public function tambah(Request $request, Barang $barang)
    {
        if ($barang->jumlah_barang <= 0) {
            return back()->with('error', 'Barang sudah habis, silakan tunggu hingga barang di-restock ulang.');
        }

        $request->validate([
            'kuantitas' => 'required|integer|min:1|max:' . $barang->jumlah_barang,
        ]);

        $keranjang = session()->get('keranjang', []);
        $key       = 'barang_' . $barang->id;

        if (isset($keranjang[$key])) {
            $newKuantitas = $keranjang[$key]['kuantitas'] + $request->kuantitas;
            if ($newKuantitas > $barang->jumlah_barang) {
                return back()->with('error', 'Jumlah melebihi stok yang tersedia.');
            }
            $keranjang[$key]['kuantitas'] = $newKuantitas;
            $keranjang[$key]['subtotal']  = $newKuantitas * $barang->harga_barang;
        } else {
            $keranjang[$key] = [
                'barang_id'      => $barang->id,
                'nama_barang'    => $barang->nama_barang,
                'harga_barang'   => $barang->harga_barang,
                'kuantitas'      => $request->kuantitas,
                'subtotal'       => $request->kuantitas * $barang->harga_barang,
                'nama_kategori'  => $barang->kategori->nama_kategori,
                'foto_barang'    => $barang->foto_barang,
            ];
        }

        session()->put('keranjang', $keranjang);
        return back()->with('success', 'Barang berhasil ditambahkan ke keranjang.');
    }

    public function hapus(Request $request, $barangId)
    {
        $keranjang = session()->get('keranjang', []);
        $key       = 'barang_' . $barangId;

        if (isset($keranjang[$key])) {
            unset($keranjang[$key]);
            session()->put('keranjang', $keranjang);
        }

        return back()->with('success', 'Barang berhasil dihapus dari keranjang.');
    }

    public function updateKuantitas(Request $request, $barangId)
    {
        $barang    = Barang::findOrFail($barangId);
        $request->validate([
            'kuantitas' => 'required|integer|min:1|max:' . $barang->jumlah_barang,
        ]);

        $keranjang = session()->get('keranjang', []);
        $key       = 'barang_' . $barangId;

        if (isset($keranjang[$key])) {
            $keranjang[$key]['kuantitas'] = $request->kuantitas;
            $keranjang[$key]['subtotal']  = $request->kuantitas * $barang->harga_barang;
            session()->put('keranjang', $keranjang);
        }

        return back()->with('success', 'Kuantitas berhasil diperbarui.');
    }

    public function clear()
    {
        session()->forget('keranjang');
        return back()->with('success', 'Keranjang berhasil dikosongkan.');
    }
}
