@extends('layouts.app')

@section('title', 'Daftar Transaksi')
@section('page_header', 'Transaksi')

@section('content')
<div class="space-y-5">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Daftar Transaksi Penjualan</h2>
            <p class="text-sm text-slate-400 mt-0.5">Kelola seluruh riwayat transaksi penjualan depot air minum.</p>
        </div>
        <a href="{{ route('transactions.create') }}"
           class="inline-flex items-center space-x-2 px-4 py-2.5 bg-blue-700 hover:bg-blue-800 text-white text-sm font-bold rounded-xl transition-all shadow-md shadow-blue-700/20">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            <span>Transaksi Baru</span>
        </a>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100">

        {{-- Search --}}
        <div class="p-4 border-b border-slate-100">
            <form method="GET" action="{{ route('transactions.index') }}" class="flex gap-2">
                <div class="relative flex-1 max-w-sm">
                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                           placeholder="Cari No. Transaksi atau nama pelanggan..."
                           class="w-full pl-9 pr-4 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-slate-700 placeholder-slate-400">
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-700 text-white text-sm font-semibold rounded-xl hover:bg-blue-800 transition-all">Cari</button>
                @if($search)
                    <a href="{{ route('transactions.index') }}" class="px-4 py-2 border border-slate-200 text-slate-600 text-sm font-semibold rounded-xl hover:bg-slate-50 transition-all">Reset</a>
                @endif
            </form>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-left border-b border-slate-100">
                    <tr>
                        <th class="py-3 px-5 text-[11px] font-bold text-slate-500 uppercase tracking-wider">No. Transaksi</th>
                        <th class="py-3 px-5 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Pelanggan</th>
                        <th class="py-3 px-5 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Tanggal</th>
                        <th class="py-3 px-5 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Metode</th>
                        <th class="py-3 px-5 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="py-3 px-5 text-[11px] font-bold text-slate-500 uppercase tracking-wider text-right">Total Amount</th>
                        <th class="py-3 px-5 text-[11px] font-bold text-slate-500 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($transactions as $trx)
                        <tr class="hover:bg-blue-50/30 transition-colors">
                            <td class="py-3.5 px-5 font-mono text-xs font-bold text-blue-700">
                                <a href="{{ route('transactions.show', $trx) }}" class="hover:underline">
                                    {{ $trx->transaction_number }}
                                </a>
                            </td>
                            <td class="py-3.5 px-5 font-medium text-slate-800">
                                {{ $trx->customer->name ?? 'Umum' }}
                            </td>
                            <td class="py-3.5 px-5 text-slate-500 text-xs">
                                {{ $trx->transaction_date->format('d/m/Y H:i') }}
                            </td>
                            <td class="py-3.5 px-5 text-slate-600 font-medium">
                                {{ $trx->payment_method_label }}
                            </td>
                            <td class="py-3.5 px-5">
                                <span @class([
                                    'inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold',
                                    'bg-emerald-50 text-emerald-700' => $trx->payment_status === 'paid',
                                    'bg-amber-50 text-amber-700'     => $trx->payment_status === 'unpaid',
                                ])>
                                    {{ $trx->payment_status === 'paid' ? 'Lunas' : 'Belum Lunas' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-5 text-right font-extrabold text-slate-900">
                                Rp {{ number_format($trx->total_amount, 0, ',', '.') }}
                            </td>
                            <td class="py-3.5 px-5">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('transactions.show', $trx) }}"
                                       class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-lg transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Detail
                                    </a>
                                    <form method="POST" action="{{ route('transactions.destroy', $trx) }}"
                                          x-data
                                          @submit.prevent="if(confirm('Batalkan transaksi ini? Stok produk akan dikembalikan.')) $el.submit()">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-red-700 bg-red-50 hover:bg-red-100 rounded-lg transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Batalkan
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-14 text-center">
                                <div class="flex flex-col items-center text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3 opacity-40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    <p class="font-semibold text-sm">
                                        @if($search) Tidak ada hasil untuk "{{ $search }}"
                                        @else Belum ada transaksi penjualan @endif
                                    </p>
                                    @if(!$search)
                                        <a href="{{ route('transactions.create') }}" class="mt-3 text-sm text-blue-600 hover:underline font-medium">+ Buat transaksi pertama</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($transactions->hasPages())
            <div class="px-5 py-4 border-t border-slate-100">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
