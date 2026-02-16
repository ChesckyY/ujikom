<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
    /**
     * Menampilkan halaman utama marketplace
     */
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        return view('pages.front.index', compact('products'));
    }

    /**
     * Memproses pesanan dari customer
     */
    public function store(Request $request)
    {
        // Cek login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk memesan produk!');
        }

        // Validasi
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'address' => 'required|string|min:10',
            'total_item' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        // Ambil produk
        $product = Product::findOrFail($request->product_id);

        // Cek stok
        if ($product->stock <= 0) {
            return back()->with('error', 'Maaf, stok produk habis!');
        }

        if ($request->total_item > $product->stock) {
            return back()->with('error', 'Stok tidak cukup. Tersedia: ' . $product->stock);
        }

        // Hitung total
        $total_price = $product->price * $request->total_item;

        // Simpan order
        Order::create([
            'product_id' => $request->product_id,
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'address' => $request->address,
            'notes' => $request->notes,
            'total_item' => $request->total_item,
            'total_price' => $total_price,
        ]);

        // Kurangi stok
        $product->stock -= $request->total_item;
        $product->save();

        return back()->with('success', 'Pesanan berhasil diproses!');
    }
}