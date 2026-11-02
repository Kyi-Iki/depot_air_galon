@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_header', 'Dashboard')

@section('content')
<div class="space-y-6">

    {{-- Welcome Banner --}}
    <div class="relative bg-gradient-to-r from-blue-800 to-blue-600 rounded-2xl p-6 overflow-hidden shadow-lg">
        <div class="absolute top-0 right-0 w-64 h-64 opacity-10">
            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" class="w-full h-full text-white fill-current">
                <path d="M100 10 C60 50, 20 70, 20 110 C20 150, 60 180, 100 180 C140 180, 180 150, 180 110 C180 70, 140 50, 100 10Z"/>
            </svg>
        </div>
        <div class="relative z-10">
            <p class="text-blue-200 text-xs font-semibold uppercase tracking-widest mb-1">{{ now()->translatedFormat('l, d F Y') }}</p>
            <h2 class="text-white text-xl font-bold">Selamat Datang, {{ Auth::user()->name }}! 👋</h2>
            <p class="text-blue-100 text-sm mt-1">Berikut ringkasan operasional depot air minum Anda hari ini.</p>
        </div>
        <div class="mt-4 relative z-10">
            <a href="{{ route('transactions.create') }}"
               class="inline-flex items-center space-x-2 px-5 py-2.5 bg-white text-blue-700 font-bold text-sm rounded-xl hover:bg-blue-50 transition-all shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Buat Transaksi Baru</span>
            </a>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

        {{-- Pendapatan Hari Ini --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pendapatan Hari Ini</p>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <h3 class="text-2xl font-extrabold text-slate-900">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</h3>
            <p class="text-xs text-emerald-600 font-medium mt-1">Transaksi lunas hari ini</p>
        </div>

        {{-- Transaksi Hari Ini --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Transaksi Hari Ini</p>
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
            <h3 class="text-2xl font-extrabold text-slate-900">{{ $todayTransactions }}</h3>
            <p class="text-xs text-blue-600 font-medium mt-1">Total order masuk hari ini</p>
        </div>

        {{-- Total Pelanggan --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pelanggan</p>
                <div class="w-10 h-10 rounded-xl bg-violet-50 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
            </div>
            <h3 class="text-2xl font-extrabold text-slate-900">{{ $totalCustomers }}</h3>
            <p class="text-xs text-violet-600 font-medium mt-1">Pelanggan terdaftar</p>
        </div>

        {{-- Total Produk --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-3">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Produk</p>
                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            </div>
            <h3 class="text-2xl font-extrabold text-slate-900">{{ $totalProducts }}</h3>
            <p class="text-xs text-amber-600 font-medium mt-1">Jenis produk tersedia</p>
        </div>

    </div>

    {{-- Recent Transactions --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center justify-between p-5 border-b border-slate-100">
            <div>
                <h3 class="text-base font-bold text-slate-900">5 Transaksi Terbaru</h3>
                <p class="text-xs text-slate-400 mt-0.5">Riwayat transaksi yang paling baru masuk</p>
            </div>
            <a href="{{ route('transactions.index') }}"
               class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center space-x-1 transition-colors">
                <span>Lihat Semua</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 text-left">
                        <th class="py-3 px-5 text-[11px] font-bold text-slate-500 uppercase tracking-wider">No. Transaksi</th>
                        <th class="py-3 px-5 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Pelanggan</th>
                        <th class="py-3 px-5 text-[11px] font-bold text-slate-500 uppercase tracking-wider hidden md:table-cell">Tanggal</th>
                        <th class="py-3 px-5 text-[11px] font-bold text-slate-500 uppercase tracking-wider">Pembayaran</th>
                        <th class="py-3 px-5 text-[11px] font-bold text-slate-500 uppercase tracking-wider text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($recentTransactions as $trx)
                        <tr class="hover:bg-blue-50/30 transition-colors">
                            <td class="py-3.5 px-5">
                                <a href="{{ route('transactions.show', $trx) }}"
                                   class="font-mono text-xs font-semibold text-blue-600 hover:text-blue-800 hover:underline">
                                    {{ $trx->transaction_number }}
                                </a>
                            </td>
                            <td class="py-3.5 px-5 font-medium text-slate-800">
                                {{ $trx->customer->name ?? 'Umum' }}
                            </td>
                            <td class="py-3.5 px-5 text-slate-500 text-xs hidden md:table-cell">
                                {{ $trx->transaction_date->format('d/m/Y H:i') }}
                            </td>
                            <td class="py-3.5 px-5">
                                <span @class([
                                    'inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold',
                                    'bg-emerald-50 text-emerald-700' => $trx->payment_status === 'paid',
                                    'bg-amber-50 text-amber-700'     => $trx->payment_status === 'unpaid',
                                ])>
                                    {{ $trx->payment_status === 'paid' ? '✓ Lunas' : '○ Belum Lunas' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-5 text-right font-bold text-slate-900">
                                Rp {{ number_format($trx->total_amount, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center">
                                <div class="flex flex-col items-center text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mb-2 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    <p class="text-sm font-medium">Belum ada transaksi</p>
                                    <p class="text-xs mt-1">Mulai buat transaksi pertama hari ini</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
