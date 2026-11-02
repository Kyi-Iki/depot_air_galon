@extends('layouts.app')

@section('title', 'Transaksi Baru')
@section('page_header', 'Transaksi')

@section('content')
<div class="space-y-5" x-data="transactionForm()">

    {{-- Back navigation --}}
    <div class="mb-2">
        <a href="{{ route('transactions.index') }}"
           class="inline-flex items-center space-x-1.5 text-sm text-slate-500 hover:text-blue-700 font-medium transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            <span>Kembali ke Daftar Transaksi</span>
        </a>
    </div>

    {{-- Form container --}}
    <form method="POST" action="{{ route('transactions.store') }}" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @csrf

        {{-- Left side (Items selection) --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Daftar Item Belanja</h2>
                        <p class="text-xs text-slate-400 mt-0.5">Pilih produk dan tentukan jumlah yang dibeli.</p>
                    </div>
                    <button type="button" @click="addItem()"
                            class="inline-flex items-center space-x-1 px-3 py-1.5 bg-blue-50 text-blue-700 text-xs font-bold rounded-lg hover:bg-blue-100 transition-all">
                        <span>+ Tambah Baris</span>
                    </button>
                </div>

                {{-- Error Message if any products duplicate --}}
                <template x-if="hasDuplicateError">
                    <div class="p-3 bg-red-50 border border-red-200 text-red-700 rounded-xl text-xs font-semibold">
                        Peringatan: Ada produk yang duplikat dipilih. Silakan gabungkan baris atau pilih produk lain.
                    </div>
                </template>

                {{-- Table headers on desktop --}}
                <div class="hidden sm:grid sm:grid-cols-12 gap-3 text-xs font-bold text-slate-400 px-2">
                    <div class="col-span-5">Produk</div>
                    <div class="col-span-2">Harga Satuan</div>
                    <div class="col-span-2">Jumlah</div>
                    <div class="col-span-2 text-right">Subtotal</div>
                    <div class="col-span-1 text-center">Aksi</div>
                </div>

                {{-- Dynamic rows --}}
                <div class="space-y-3">
                    <template x-for="(item, index) in items" :key="index">
                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center p-3 bg-slate-50 rounded-xl border border-slate-100 relative">

                            {{-- Mobile title --}}
                            <div class="sm:hidden text-xs font-bold text-slate-400 mb-1 flex justify-between">
                                <span x-text="'Item #' + (index + 1)"></span>
                                <button type="button" @click="removeItem(index)" class="text-red-500 hover:text-red-700" x-show="items.length > 1">Hapus</button>
                            </div>

                            {{-- Product Dropdown --}}
                            <div class="col-span-5">
                                <select :name="'items['+index+'][product_id]'" x-model="item.product_id" @change="onProductChange(index)"
                                        class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white text-slate-700">
                                    <option value="">-- Pilih Produk --</option>
                                    <template x-for="p in productsList" :key="p.id">
                                        <option :value="p.id" x-text="p.name + ' (Stok: ' + p.stock + ')'"></option>
                                    </template>
                                </select>
                            </div>

                            {{-- Unit Price (read-only) --}}
                            <div class="col-span-2 text-sm text-slate-600 sm:text-left px-1">
                                <span class="sm:hidden font-semibold text-slate-400">Harga: </span>
                                <span x-text="formatRupiah(item.price)"></span>
                            </div>

                            {{-- Quantity Input --}}
                            <div class="col-span-2 flex items-center space-x-1">
                                <span class="sm:hidden font-semibold text-slate-400 mr-2">Qty: </span>
                                <input type="number" :name="'items['+index+'][quantity]'" x-model.number="item.quantity" @input="calculateSubtotal(index)"
                                       min="1" :max="item.max_stock"
                                       class="w-20 px-2 py-1.5 border border-slate-200 rounded-lg text-center text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            </div>

                            {{-- Subtotal --}}
                            <div class="col-span-2 text-right text-sm font-bold text-slate-900 pr-1">
                                <span class="sm:hidden font-semibold text-slate-400 float-left">Subtotal: </span>
                                <span x-text="formatRupiah(item.subtotal)"></span>
                            </div>

                            {{-- Delete action --}}
                            <div class="col-span-1 text-center hidden sm:block">
                                <button type="button" @click="removeItem(index)" class="text-red-500 hover:text-red-700 focus:outline-none" :disabled="items.length === 1" :class="{'opacity-30 cursor-not-allowed': items.length === 1}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        {{-- Right side (Summary & Checkout Info) --}}
        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 space-y-5">
                <h2 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3">Detail Pembayaran</h2>

                {{-- Select Customer --}}
                <div>
                    <label for="customer_id" class="block text-sm font-semibold text-slate-700 mb-1.5">Pelanggan</label>
                    <select id="customer_id" name="customer_id"
                            class="w-full px-3 py-2.5 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white text-slate-700">
                        <option value="">-- Pembeli Umum (Tanpa Akun) --</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->phone ?? 'Tidak ada HP' }})</option>
                        @endforeach
                    </select>
                </div>

                {{-- Payment Method --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Metode Pembayaran</label>
                    <div class="grid grid-cols-3 gap-2">
                        <label class="border border-slate-200 rounded-xl p-2.5 flex flex-col items-center justify-center cursor-pointer hover:bg-blue-50/50 transition" :class="{'border-blue-600 bg-blue-50/30 text-blue-800': payment_method === 'cash'}">
                            <input type="radio" name="payment_method" value="cash" x-model="payment_method" class="sr-only">
                            <span class="text-xs font-bold">Tunai</span>
                        </label>
                        <label class="border border-slate-200 rounded-xl p-2.5 flex flex-col items-center justify-center cursor-pointer hover:bg-blue-50/50 transition" :class="{'border-blue-600 bg-blue-50/30 text-blue-800': payment_method === 'transfer'}">
                            <input type="radio" name="payment_method" value="transfer" x-model="payment_method" class="sr-only">
                            <span class="text-xs font-bold">Transfer</span>
                        </label>
                        <label class="border border-slate-200 rounded-xl p-2.5 flex flex-col items-center justify-center cursor-pointer hover:bg-blue-50/50 transition" :class="{'border-blue-600 bg-blue-50/30 text-blue-800': payment_method === 'qris'}">
                            <input type="radio" name="payment_method" value="qris" x-model="payment_method" class="sr-only">
                            <span class="text-xs font-bold">QRIS</span>
                        </label>
                    </div>
                </div>

                {{-- Payment Status --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Status Pembayaran</label>
                    <div class="grid grid-cols-2 gap-2">
                        <label class="border border-slate-200 rounded-xl p-2.5 flex flex-col items-center justify-center cursor-pointer hover:bg-emerald-50/50 transition" :class="{'border-emerald-600 bg-emerald-50/30 text-emerald-800': payment_status === 'paid'}">
                            <input type="radio" name="payment_status" value="paid" x-model="payment_status" class="sr-only">
                            <span class="text-xs font-bold">✓ Lunas</span>
                        </label>
                        <label class="border border-slate-200 rounded-xl p-2.5 flex flex-col items-center justify-center cursor-pointer hover:bg-amber-50/50 transition" :class="{'border-amber-600 bg-amber-50/30 text-amber-800': payment_status === 'unpaid'}">
                            <input type="radio" name="payment_status" value="unpaid" x-model="payment_status" class="sr-only">
                            <span class="text-xs font-bold">○ Belum Lunas</span>
                        </label>
                    </div>
                </div>

                {{-- Calculations --}}
                <div class="bg-slate-50 rounded-2xl p-4 space-y-2 border border-slate-100">
                    <div class="flex justify-between text-xs text-slate-500">
                        <span>Total Qty</span>
                        <span class="font-bold text-slate-700" x-text="totalQty + ' item'"></span>
                    </div>
                    <div class="flex justify-between text-base font-extrabold text-slate-900 border-t border-slate-200/60 pt-2.5">
                        <span>Total Bayar</span>
                        <span x-text="formatRupiah(totalAmount)"></span>
                    </div>
                </div>

                {{-- Action button --}}
                <button type="submit" :disabled="isSubmitDisabled"
                        class="w-full py-3 bg-blue-700 hover:bg-blue-800 active:bg-blue-900 disabled:opacity-50 disabled:cursor-not-allowed text-white font-bold text-sm rounded-xl transition shadow-lg shadow-blue-700/20">
                    Simpan Transaksi
                </button>
            </div>
        </div>
    </form>
</div>

{{-- Dynamic data encoding for Alpine --}}
<script>
    function transactionForm() {
        return {
            productsList: @json($products),
            items: [
                { product_id: '', quantity: 1, price: 0, subtotal: 0, max_stock: 0 }
            ],
            payment_method: 'cash',
            payment_status: 'paid',

            addItem() {
                this.items.push({ product_id: '', quantity: 1, price: 0, subtotal: 0, max_stock: 0 });
            },

            removeItem(index) {
                if (this.items.length > 1) {
                    this.items.splice(index, 1);
                }
            },

            onProductChange(index) {
                const item = this.items[index];
                if (!item.product_id) {
                    item.price = 0;
                    item.subtotal = 0;
                    item.max_stock = 0;
                    return;
                }
                const product = this.productsList.find(p => p.id == item.product_id);
                if (product) {
                    item.price = parseFloat(product.price);
                    item.max_stock = parseInt(product.stock);
                    if (item.quantity > item.max_stock) {
                        item.quantity = item.max_stock;
                    }
                    this.calculateSubtotal(index);
                }
            },

            calculateSubtotal(index) {
                const item = this.items[index];
                if (item.quantity < 1) item.quantity = 1;
                if (item.max_stock && item.quantity > item.max_stock) {
                    item.quantity = item.max_stock;
                }
                item.subtotal = item.price * item.quantity;
            },

            get totalQty() {
                return this.items.reduce((sum, item) => sum + (item.product_id ? parseInt(item.quantity) : 0), 0);
            },

            get totalAmount() {
                return this.items.reduce((sum, item) => sum + (item.product_id ? parseFloat(item.subtotal) : 0), 0);
            },

            get hasDuplicateError() {
                const selectedIds = this.items.map(item => item.product_id).filter(id => id !== '');
                return (new Set(selectedIds)).size !== selectedIds.length;
            },

            get isSubmitDisabled() {
                // Must select at least 1 product, no duplicates, total amount must be > 0
                const selectedCount = this.items.filter(item => item.product_id !== '').length;
                return selectedCount === 0 || this.hasDuplicateError || this.totalAmount <= 0;
            },

            formatRupiah(amount) {
                return 'Rp ' + parseFloat(amount).toLocaleString('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
            }
        }
    }
</script>
@endsection
