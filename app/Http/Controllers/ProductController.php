<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->get();
        $categories = Category::all();
        return view('pages.product.index', compact('products', 'categories'));
    }

    public function create()
    {
       
    }


    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'product_name'        => 'required',
            'category_id'         => 'required',
            'price'               => 'required|numeric',
            'stock'               => 'required|numeric',
            'product_image'       => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'product_description' => 'required',
        ]);

        $image = $request->file('product_image');

        $imagePath = $image->store('products', 'public');

        Product::create([
            'category_id'         => $request->category_id,
            'product_name'        => $request->product_name,
            'price'               => $request->price,
            'stock'               => $request->stock,
            'product_image'       => $imagePath,
            'product_description' => $request->product_description,
        ]);

        return redirect()
            ->route('product.index')
            ->with('success', 'Data produk berhasil ditambahkan!');
    }

    public function stockIndex()
    {
        // Mengambil semua produk
        $products = Product::all();

        return view('pages.stock.index', compact('products'));
    }

    // Logika mengupdate stok (Menambah jumlah lama dengan input baru)
    public function updateStock(Request $request, $id)
    {
        $request->validate([
            'penambahan' => 'required|numeric|min:1',
        ]);
        
        $product = Product::findOrFail($id);

        // Gunakan fungsi increment untuk menambah nilai stok yang ada
        $product->increment('stock', $request->penambahan);
        
        return redirect()->back()->with('success', 'Stok berhasil diperbarui!');
    }

    public function show(string $id)
    {
        
    }

    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $request->validate([
            'product_name'        => 'required',
            'category_id'         => 'required',
            'price'               => 'required|numeric',
            'stock'               => 'required|numeric',
            'product_image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'product_description' => 'required',
        ]);

        $product = Product::findOrFail($id);

        $data = [
            'category_id'         => $request->category_id,
            'product_name'        => $request->product_name,
            'price'               => $request->price,
            'stock'               => $request->stock,
            'product_description' => $request->product_description,
        ];

        // Cek apakah ada file gambar yang diupload
        if ($request->hasFile('product_image')) {
            // Hapus gambar lama
            if ($product->product_image) {
                Storage::disk('public')->delete($product->product_image);
            }
            
            // Upload gambar baru
            $image = $request->file('product_image');
            $imagePath = $image->store('products', 'public');
            $data['product_image'] = $imagePath;
        }

        // Update data produk
        $product->update($data);

        return redirect()
            ->route('product.index')
            ->with('success', 'Data produk berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        // Hapus gambar dari storage
        if ($product->product_image) {
            Storage::disk('public')->delete($product->product_image);
        }
        
        // Hapus data produk
        $product->delete();
        
        return redirect()
            ->route('product.index')
            ->with('success', 'Produk berhasil dihapus');
    }
}