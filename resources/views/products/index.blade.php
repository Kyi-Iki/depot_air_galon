@extends('layouts.app')

@section('title', 'Daftar Produk')
@section('page_header', 'Produk')

@section('content')
<div class="space-y-5">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Daftar Produk</h2>
            <p class="text-sm text-slate-400 mt-0.5">Kelola produk dan stok air minum depot Anda.</p>
        </div>
        <a href="{{ route('products.create') }}"
           class="inline-flex items-center space-x-2 px-4 py-2.5 bg-blue-700 hover:bg-blue-800 text-white text-sm font-bold rounded-xl transition-all shadow-md shadow-blue-700/20">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            <span>Tambah Produk</span>
        </a>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100">

        {{-- Search --}}
        <div class="p-4 border-b border-slate-100">
            <form method="GET" action="{{ route('products.index') }}" class="flex gap-2">
                <div class="relative flex-1 max-w-sm">
                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                           placeholder="Cari nama atau deskripsi produk..."
                           class="w-full pl-9 pr-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-slate-700 placeholder-slate-400">
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-700 text-white text-sm font-semibold rounded-xl hover:bg-blue-800 transition-all">Cari</button>
                @if($search)
                    <a href="{{ route('products.index') }}" class="px-4 py-2 border border-slate-200 text-slate-600 text-sm font-semibold rounded-xl hover:bg-slate-50 transition-all">Reset</a>
                @endif
            </form>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-left border-b border-slate-100">
                    <tr>
                        <th class="py-3 px-5 text-[11px] font-bold text-slate-500 uppercase tracking-wider">#</th>
                        <th class="py-3 px-5 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Nama Produk</th>
                        <th class="py-3 px-5 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Harga</th>
                        <th class="py-3 px-5 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Stok</th>
                        <th class="py-3 px-5 text-[11px] font-bold text-slate-500 uppercase tracking-wider hidden lg:table-cell">Deskripsi</th>
                        <th class="py-3 px-5 text-[11px] font-bold text-slate-500 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($products as $i => $product)
                        <tr class="hover:bg-blue-50/30 transition-colors">
                            <td class="py-3.5 px-5 text-slate-400 text-xs">{{ $products->firstItem() + $i }}</td>
                            <td class="py-3.5 px-5">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 3.5C7 7.5 4 9.5 4 12a6 6 0 0012 0c0-2.5-3-5-6-8.5z"/>
                                        </svg>
                                    </div>
                                    <span class="font-semibold text-slate-800">{{ $product->name }}</span>
                                </div>
                            </td>
                            <td class="py-3.5 px-5 font-bold text-slate-800">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </td>
                            <td class="py-3.5 px-5">
                                @php
                                    $stockClass = match(true) {
                                        $product->stock == 0  => 'bg-red-50 text-red-700',
                                        $product->stock <= 10 => 'bg-amber-50 text-amber-700',
                                        default               => 'bg-emerald-50 text-emerald-700',
                                    };
                                    $stockLabel = match(true) {
                                        $product->stock == 0  => 'Habis',
                                        $product->stock <= 10 => 'Hampir Habis',
                                        default               => 'Tersedia',
                                    };
                                @endphp
                                <div class="flex items-center space-x-2">
                                    <span class="font-bold text-slate-800">{{ $product->stock }}</span>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $stockClass }}">
                                        {{ $stockLabel }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-3.5 px-5 text-slate-500 text-xs max-w-xs truncate hidden lg:table-cell">
                                {{ $product->description ?? '-' }}
                            </td>
                            <td class="py-3.5 px-5">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('products.edit', $product) }}"
                                       class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-lg transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('products.destroy', $product) }}"
                                          x-data
                                          @submit.prevent="if(confirm('Hapus produk \"{{ addslashes($product->name) }}\"?')) $el.submit()">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-red-700 bg-red-50 hover:bg-red-100 rounded-lg transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-14 text-center">
                                <div class="flex flex-col items-center text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                    <p class="font-semibold text-sm">
                                        @if($search) Tidak ada hasil untuk "{{ $search }}"
                                        @else Belum ada produk terdaftar @endif
                                    </p>
                                    @if(!$search)
                                        <a href="{{ route('products.create') }}" class="mt-3 text-sm text-blue-600 hover:underline font-medium">+ Tambah produk pertama</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
            <div class="px-5 py-4 border-t border-slate-100">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
