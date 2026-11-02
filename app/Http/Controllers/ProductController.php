<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $products = Product::when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
            })
            ->orderBy('name', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('products.index', compact('products', 'search'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:100',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'description' => 'nullable|string|max:500',
        ], [
            'name.required'  => 'Nama produk wajib diisi.',
            'price.required' => 'Harga produk wajib diisi.',
            'price.numeric'  => 'Harga harus berupa angka.',
            'price.min'      => 'Harga tidak boleh negatif.',
            'stock.required' => 'Stok wajib diisi.',
            'stock.integer'  => 'Stok harus berupa bilangan bulat.',
            'stock.min'      => 'Stok tidak boleh negatif.',
        ]);

        Product::create($request->only('name', 'price', 'stock', 'description'));

        return redirect()->route('products.index')
            ->with('success', "Produk '{$request->name}' berhasil ditambahkan.");
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'        => 'required|string|max:100',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'description' => 'nullable|string|max:500',
        ], [
            'name.required'  => 'Nama produk wajib diisi.',
            'price.required' => 'Harga produk wajib diisi.',
            'price.numeric'  => 'Harga harus berupa angka.',
            'price.min'      => 'Harga tidak boleh negatif.',
            'stock.required' => 'Stok wajib diisi.',
            'stock.integer'  => 'Stok harus berupa bilangan bulat.',
            'stock.min'      => 'Stok tidak boleh negatif.',
        ]);

        $product->update($request->only('name', 'price', 'stock', 'description'));

        return redirect()->route('products.index')
            ->with('success', "Produk '{$product->name}' berhasil diperbarui.");
    }

    public function destroy(Product $product)
    {
        $name = $product->name;
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', "Produk '{$name}' berhasil dihapus.");
    }
}
