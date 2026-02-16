<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // mengambil data pesanan beserta informasi produk nya
        $orders = Order::with('product')->latest()->get();

        //mengembalikan view dengan data pesanan
        return view('pages.order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data (name dan email tidak perlu divalidasi karena dari login)
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'address' => 'required|string',
            'total_item' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        // Ambil data produk
        $product = Product::findOrFail($request->product_id);

        // Cek apakah stok mencukupi
        if ($product->stock <= 0) {
            return back()->with('error', 'Maaf, stok produk ini sedang habis!');
        }

        // Cek ketersediaan stok sesuai jumlah pesanan
        if ($request->total_item > $product->stock) {
            return back()->with('error', 'Stok tidak mencukupi. Stok tersedia: ' . $product->stock);
        }

        // Hitung total harga
        $total_price = $product->price * $request->total_item;

        // Simpan pesanan dengan data dari user yang login
        Order::create([
            'product_id' => $request->product_id,
            'name' => Auth::user()->name,        // Ambil dari user login
            'email' => Auth::user()->email,      // Ambil dari user login
            'address' => $request->address,
            'notes' => $request->notes,
            'total_item' => $request->total_item,
            'total_price' => $total_price,
        ]);

        // Kurangi stok produk
        $product->stock -= $request->total_item;
        $product->save();

        return back()->with('success', 'Pesanan berhasil diproses!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}