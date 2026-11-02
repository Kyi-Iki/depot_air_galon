@extends('layouts.app')

@section('title', 'Tambah Produk')
@section('page_header', 'Produk')

@section('content')
<div class="max-w-xl">

    <div class="mb-5">
        <a href="{{ route('products.index') }}"
           class="inline-flex items-center space-x-1.5 text-sm text-slate-500 hover:text-blue-700 font-medium transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            <span>Kembali ke Daftar Produk</span>
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-700 to-blue-600 px-6 py-5">
            <h2 class="text-lg font-bold text-white">Tambah Produk Baru</h2>
            <p class="text-blue-100 text-sm mt-0.5">Isi data produk dengan benar untuk menambah stok jualan.</p>
        </div>

        <form method="POST" action="{{ route('products.store') }}" class="p-6 space-y-5">
            @csrf

            {{-- Nama Produk --}}
            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">
                    Nama Produk <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                       placeholder="Contoh: Galon Isi Ulang 19L"
                       class="w-full px-4 py-2.5 border @error('name') border-red-400 bg-red-50 @else border-slate-200 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-slate-800 placeholder-slate-400 transition">
                @error('name')
                    <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                {{-- Harga --}}
                <div>
                    <label for="price" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Harga (Rp) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="price" name="price" value="{{ old('price') }}"
                           placeholder="Contoh: 5000"
                           class="w-full px-4 py-2.5 border @error('price') border-red-400 bg-red-50 @else border-slate-200 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-slate-800 placeholder-slate-400 transition">
                    @error('price')
                        <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Stok --}}
                <div>
                    <label for="stock" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Stok Awal <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="stock" name="stock" value="{{ old('stock', 0) }}"
                           placeholder="Contoh: 100"
                           class="w-full px-4 py-2.5 border @error('stock') border-red-400 bg-red-50 @else border-slate-200 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-slate-800 placeholder-slate-400 transition">
                    @error('stock')
                        <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Deskripsi --}}
            <div>
                <label for="description" class="block text-sm font-semibold text-slate-700 mb-1.5">
                    Deskripsi Produk
                </label>
                <textarea id="description" name="description" rows="3"
                          placeholder="Keterangan singkat tentang produk..."
                          class="w-full px-4 py-2.5 border @error('description') border-red-400 bg-red-50 @else border-slate-200 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-slate-800 placeholder-slate-400 transition resize-none">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="flex-1 sm:flex-none px-6 py-2.5 bg-blue-700 hover:bg-blue-800 text-white text-sm font-bold rounded-xl transition-all shadow-md shadow-blue-700/20">
                    Simpan Produk
                </button>
                <a href="{{ route('products.index') }}"
                   class="flex-1 sm:flex-none text-center px-6 py-2.5 border border-slate-200 text-slate-600 text-sm font-semibold rounded-xl hover:bg-slate-50 transition-all">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
