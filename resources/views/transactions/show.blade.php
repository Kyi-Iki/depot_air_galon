@extends('layouts.app')

@section('title', 'Detail Transaksi')
@section('page_header', 'Detail Transaksi')

@section('content')
<div class="max-w-3xl space-y-6">

    {{-- Back navigation --}}
    <div class="flex items-center justify-between">
        <a href="{{ route('transactions.index') }}"
           class="inline-flex items-center space-x-1.5 text-sm text-slate-500 hover:text-blue-700 font-medium transition-colors print:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            <span>Kembali ke Daftar Transaksi</span>
        </a>

        <div class="flex items-center gap-2 print:hidden">
            {{-- Print Button --}}
            <button onclick="window.print()"
                    class="inline-flex items-center px-4 py-2 border border-slate-200 text-slate-600 bg-white hover:bg-slate-50 font-bold text-xs rounded-xl transition-all shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                <span>Cetak Nota</span>
            </button>

            {{-- Delete / Cancel Button --}}
            <form method="POST" action="{{ route('transactions.destroy', $transaction) }}"
                  x-data
                  @submit.prevent="if(confirm('Batalkan transaksi ini? Stok produk akan dikembalikan.')) $el.submit()">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-red-50 hover:bg-red-100 text-red-700 font-bold text-xs rounded-xl transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    <span>Batalkan Transaksi</span>
                </button>
            </form>
        </div>
    </div>

    {{-- Invoice Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8 space-y-6 relative overflow-hidden print:border-0 print:shadow-none print:p-0">
        
        {{-- Watermark / Badge --}}
        <div class="absolute top-6 right-6 text-right print:relative print:top-0 print:right-0 print:mb-4">
            <span @class([
                'inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold shadow-sm',
                'bg-emerald-50 text-emerald-700 border border-emerald-100' => $transaction->payment_status === 'paid',
                'bg-amber-50 text-amber-700 border border-amber-100'     => $transaction->payment_status === 'unpaid',
            ])>
                {{ $transaction->payment_status === 'paid' ? 'LUNAS' : 'BELUM LUNAS' }}
            </span>
        </div>

        {{-- Header Info --}}
        <div class="flex flex-col sm:flex-row justify-between gap-4 border-b border-slate-100 pb-5">
            <div>
                <h3 class="text-xl font-extrabold text-blue-900">Nota Penjualan</h3>
                <p class="font-mono text-sm font-bold text-slate-500 mt-1">{{ $transaction->transaction_number }}</p>
            </div>
            <div class="text-left sm:text-right">
                <h4 class="font-bold text-slate-800">Depot Air AquaSegar</h4>
                <p class="text-xs text-slate-400 mt-0.5">Layanan Air Minum Higienis & Berkualitas</p>
                <p class="text-xs text-slate-400">Telp: 0812-3456-7890</p>
            </div>
        </div>

        {{-- Meta Detail Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm text-slate-600 bg-slate-50 rounded-2xl p-5 border border-slate-100 print:bg-white print:p-0 print:border-0">
            <div class="space-y-1.5">
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Informasi Pelanggan</p>
                <h5 class="font-bold text-slate-800">{{ $transaction->customer->name ?? 'Pembeli Umum' }}</h5>
                @if($transaction->customer)
                    <p class="text-xs text-slate-500">HP: {{ $transaction->customer->phone ?? '-' }}</p>
                    <p class="text-xs text-slate-500">Alamat: {{ $transaction->customer->address ?? '-' }}</p>
                @else
                    <p class="text-xs text-slate-400 italic">Transaksi Non-Member / Umum</p>
                @endif
            </div>
            <div class="space-y-1.5 sm:text-right">
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Waktu Transaksi</p>
                <p class="font-medium text-slate-800">{{ $transaction->transaction_date->format('d F Y, H:i') }}</p>
                <p class="text-xs text-slate-500">Metode: <span class="font-bold text-slate-700">{{ $transaction->payment_method_label }}</span></p>
                <p class="text-xs text-slate-500">Kasir: {{ $transaction->user->name ?? 'Admin' }}</p>
            </div>
        </div>

        {{-- Products Table --}}
        <div class="space-y-3">
            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Daftar Produk</h4>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-left border-b border-slate-100">
                            <th class="py-2.5 px-4 font-bold text-xs uppercase tracking-wider">Nama Produk</th>
                            <th class="py-2.5 px-4 font-bold text-xs uppercase tracking-wider text-right">Harga Satuan</th>
                            <th class="py-2.5 px-4 font-bold text-xs uppercase tracking-wider text-center">Jumlah</th>
                            <th class="py-2.5 px-4 font-bold text-xs uppercase tracking-wider text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($transaction->details as $detail)
                            <tr>
                                <td class="py-3 px-4 font-medium text-slate-800">
                                    {{ $detail->product->name }}
                                </td>
                                <td class="py-3 px-4 text-right text-slate-600">
                                    Rp {{ number_format($detail->unit_price, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-4 text-center font-bold text-slate-800">
                                    {{ $detail->quantity }}
                                </td>
                                <td class="py-3 px-4 text-right font-bold text-slate-900">
                                    Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Calculation Summary --}}
        <div class="border-t border-slate-100 pt-5 flex justify-end">
            <div class="w-full sm:w-64 space-y-2">
                <div class="flex justify-between text-sm text-slate-600">
                    <span>Total Item</span>
                    <span class="font-bold text-slate-800">{{ $transaction->details->sum('quantity') }}</span>
                </div>
                <div class="flex justify-between text-lg font-extrabold text-blue-900 border-t border-slate-100 pt-2">
                    <span>Total Bayar</span>
                    <span>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        {{-- Footer Note --}}
        <div class="text-center text-slate-400 text-xs pt-6 border-t border-slate-100/60 print:block">
            <p>Terima kasih atas kunjungan dan kepercayaan Anda.</p>
            <p class="mt-0.5">Air Minum Sehat untuk Keluarga Anda.</p>
        </div>
    </div>
</div>
@endsection
