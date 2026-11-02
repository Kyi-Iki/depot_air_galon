@extends('layouts.app')

@section('title', 'Daftar Pelanggan')
@section('page_header', 'Pelanggan')

@section('content')
<div class="space-y-5">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Daftar Pelanggan</h2>
            <p class="text-sm text-slate-400 mt-0.5">Kelola data pelanggan depot air minum Anda.</p>
        </div>
        <a href="{{ route('customers.create') }}"
           class="inline-flex items-center space-x-2 px-4 py-2.5 bg-blue-700 hover:bg-blue-800 text-white text-sm font-bold rounded-xl transition-all shadow-md shadow-blue-700/20">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            <span>Tambah Pelanggan</span>
        </a>
    </div>

    {{-- Card Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100">

        {{-- Search --}}
        <div class="p-4 border-b border-slate-100">
            <form method="GET" action="{{ route('customers.index') }}" class="flex gap-2">
                <div class="relative flex-1 max-w-sm">
                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                           placeholder="Cari nama, HP, atau alamat..."
                           class="w-full pl-9 pr-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-slate-700 placeholder-slate-400">
                </div>
                <button type="submit"
                        class="px-4 py-2 bg-blue-700 text-white text-sm font-semibold rounded-xl hover:bg-blue-800 transition-all">
                    Cari
                </button>
                @if($search)
                    <a href="{{ route('customers.index') }}"
                       class="px-4 py-2 border border-slate-200 text-slate-600 text-sm font-semibold rounded-xl hover:bg-slate-50 transition-all">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-left border-b border-slate-100">
                    <tr>
                        <th class="py-3 px-5 text-[11px] font-bold text-slate-500 uppercase tracking-wider">#</th>
                        <th class="py-3 px-5 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Nama Pelanggan</th>
                        <th class="py-3 px-5 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Nomor HP</th>
                        <th class="py-3 px-5 text-[11px] font-bold text-slate-500 uppercase tracking-wider hidden lg:table-cell">Alamat</th>
                        <th class="py-3 px-5 text-[11px] font-bold text-slate-500 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($customers as $i => $customer)
                        <tr class="hover:bg-blue-50/30 transition-colors">
                            <td class="py-3.5 px-5 text-slate-400 text-xs font-medium">
                                {{ $customers->firstItem() + $i }}
                            </td>
                            <td class="py-3.5 px-5">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center text-xs font-bold shrink-0">
                                        {{ strtoupper(substr($customer->name, 0, 1)) }}
                                    </div>
                                    <span class="font-semibold text-slate-800">{{ $customer->name }}</span>
                                </div>
                            </td>
                            <td class="py-3.5 px-5 text-slate-600">
                                {{ $customer->phone ?? '-' }}
                            </td>
                            <td class="py-3.5 px-5 text-slate-500 text-xs max-w-xs truncate hidden lg:table-cell">
                                {{ $customer->address ?? '-' }}
                            </td>
                            <td class="py-3.5 px-5">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('customers.edit', $customer) }}"
                                       class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-lg transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('customers.destroy', $customer) }}"
                                          x-data
                                          @submit.prevent="if(confirm('Hapus pelanggan \"{{ addslashes($customer->name) }}\"?\nData yang terhapus tidak bisa dikembalikan.')) $el.submit()">
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
                            <td colspan="5" class="py-14 text-center">
                                <div class="flex flex-col items-center text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <p class="font-semibold text-sm">
                                        @if($search) Tidak ada hasil untuk "{{ $search }}"
                                        @else Belum ada pelanggan terdaftar @endif
                                    </p>
                                    @if(!$search)
                                        <a href="{{ route('customers.create') }}" class="mt-3 text-sm text-blue-600 hover:underline font-medium">+ Tambah pelanggan pertama</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($customers->hasPages())
            <div class="px-5 py-4 border-t border-slate-100">
                {{ $customers->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
