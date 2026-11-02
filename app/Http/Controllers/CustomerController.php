<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $customers = Customer::when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%")
                      ->orWhere('address', 'like', "%{$search}%");
            })
            ->orderBy('name', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('customers.index', compact('customers', 'search'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ], [
            'name.required' => 'Nama pelanggan wajib diisi.',
            'name.max'      => 'Nama maksimal 100 karakter.',
            'phone.max'     => 'Nomor HP maksimal 20 karakter.',
        ]);

        Customer::create($request->only('name', 'phone', 'address'));

        return redirect()->route('customers.index')
            ->with('success', "Pelanggan '{$request->name}' berhasil ditambahkan.");
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ], [
            'name.required' => 'Nama pelanggan wajib diisi.',
            'name.max'      => 'Nama maksimal 100 karakter.',
            'phone.max'     => 'Nomor HP maksimal 20 karakter.',
        ]);

        $customer->update($request->only('name', 'phone', 'address'));

        return redirect()->route('customers.index')
            ->with('success', "Data pelanggan '{$customer->name}' berhasil diperbarui.");
    }

    public function destroy(Customer $customer)
    {
        $name = $customer->name;
        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', "Pelanggan '{$name}' berhasil dihapus.");
    }
}
