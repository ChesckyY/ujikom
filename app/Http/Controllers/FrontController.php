<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;


class FrontController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
     // Mengambil semua produk beserta kategorinya agar tidak error
        $products = Product::with('category')->get();

        // Mengirimkan variable $products ke view
        return view('pages.front.index', compact('products'));

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
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|string',
            'email' => 'required|email',
            'address' => 'required',
            'total_item' => 'required|numeric|min:1',
        ]);

        $product = \App\Models\Product::findOrFail($request->product_id);

        // 1. Simpan ke tabel order 
        Order::create([
            'product_id' => $product->id,
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'notes' => $request->notes,
            'total_item' => $request->total_item,
            'total_price' => $product->price * $request->total_item,
        ]);

        // 2. LOGIKA PENTING: Kurangi stok produk secara otomatis
        $product->decrement('stock', $request->total_item);

        return redirect()->back()->with('success', 'Pesanan Anda berhasil diproses!');
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