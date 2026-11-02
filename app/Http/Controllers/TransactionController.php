<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $transactions = Transaction::with('customer')
            ->when($search, function ($query, $search) {
                $query->where('transaction_number', 'like', "%{$search}%")
                      ->orWhereHas('customer', function ($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      });
            })
            ->orderBy('transaction_date', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('transactions.index', compact('transactions', 'search'));
    }

    public function create()
    {
        $customers = Customer::orderBy('name', 'asc')->get();
        $products  = Product::where('stock', '>', 0)->orderBy('name', 'asc')->get();

        return view('transactions.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id'       => 'nullable|exists:customers,id',
            'payment_method'    => 'required|in:cash,transfer,qris',
            'payment_status'    => 'required|in:paid,unpaid',
            'items'             => 'required|array|min:1',
            'items.*.product_id'=> 'required|exists:products,id',
            'items.*.quantity'  => 'required|integer|min:1',
        ], [
            'payment_method.required' => 'Metode pembayaran wajib dipilih.',
            'payment_method.in'       => 'Metode pembayaran tidak valid.',
            'payment_status.required' => 'Status pembayaran wajib dipilih.',
            'items.required'          => 'Tambahkan minimal satu produk.',
            'items.min'               => 'Tambahkan minimal satu produk.',
            'items.*.product_id.required' => 'Pilih produk terlebih dahulu.',
            'items.*.quantity.required'   => 'Jumlah produk wajib diisi.',
            'items.*.quantity.min'        => 'Jumlah produk minimal 1.',
        ]);

        try {
            DB::beginTransaction();

            $transactionNumber = Transaction::generateNumber();

            $transaction = Transaction::create([
                'customer_id'        => $request->customer_id,
                'user_id'            => Auth::id(),
                'transaction_number' => $transactionNumber,
                'transaction_date'   => now(),
                'total_amount'       => 0.00,
                'payment_method'     => $request->payment_method,
                'payment_status'     => $request->payment_status,
            ]);

            $totalAmount = 0;

            // Track duplicate product IDs
            $productIds = array_column($request->items, 'product_id');
            if (count($productIds) !== count(array_unique($productIds))) {
                throw new \Exception('Produk yang sama tidak boleh dimasukkan dua kali. Gabungkan dalam satu baris.');
            }

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);

                if ($product->stock < $item['quantity']) {
                    throw new \Exception(
                        "Stok produk \"{$product->name}\" tidak mencukupi. Tersisa: {$product->stock} unit."
                    );
                }

                $subtotal = $product->price * $item['quantity'];

                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id'     => $product->id,
                    'quantity'       => $item['quantity'],
                    'unit_price'     => $product->price,
                    'subtotal'       => $subtotal,
                ]);

                // Kurangi stok produk
                $product->decrement('stock', $item['quantity']);

                $totalAmount += $subtotal;
            }

            $transaction->update(['total_amount' => $totalAmount]);

            DB::commit();

            return redirect()->route('transactions.show', $transaction)
                ->with('success', "Transaksi {$transactionNumber} berhasil disimpan!");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show(Transaction $transaction)
    {
        $transaction->load('customer', 'user', 'details.product');
        return view('transactions.show', compact('transaction'));
    }

    public function destroy(Transaction $transaction)
    {
        try {
            DB::beginTransaction();

            // Kembalikan stok produk
            foreach ($transaction->details as $detail) {
                $detail->product->increment('stock', $detail->quantity);
            }

            $number = $transaction->transaction_number;
            $transaction->delete();

            DB::commit();

            return redirect()->route('transactions.index')
                ->with('success', "Transaksi {$number} berhasil dihapus dan stok produk telah dikembalikan.");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }
}
