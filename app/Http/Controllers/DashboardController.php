<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        // Data hari ini
        $todayRevenue = Transaction::whereDate('transaction_date', today())
            ->where('payment_status', 'paid')
            ->sum('total_amount');

        $todayTransactions = Transaction::whereDate('transaction_date', today())->count();

        // Data keseluruhan
        $totalCustomers = Customer::count();
        $totalProducts  = Product::count();

        // 5 Transaksi terbaru
        $recentTransactions = Transaction::with('customer')
            ->orderBy('transaction_date', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'todayRevenue',
            'todayTransactions',
            'totalCustomers',
            'totalProducts',
            'recentTransactions'
        ));
    }
}
