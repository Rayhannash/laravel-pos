<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_produk' => 'required|unique:products',
            'nama_produk' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
        ]);

        Product::create($request->all());
        return redirect()->route('products.index');
    }

    public function edit($id)
    {
    $product = Product::findOrFail($id);
    return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
    $request->validate([
        'kode_produk' => 'required',
        'nama_produk' => 'required',
        'harga' => 'required|numeric',
        'stok' => 'required|integer',
    ]);

    $product->update([
        'kode_produk' => $request->kode_produk,
        'nama_produk' => $request->nama_produk,
        'harga' => $request->harga,
        'stok' => $request->stok,
    ]);

    return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
    $product->delete();
    return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }
}
