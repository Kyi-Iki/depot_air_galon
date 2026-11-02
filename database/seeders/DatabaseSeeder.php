<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name'     => 'Admin AquaSegar',
            'email'    => 'admin@aquasegar.com',
            'password' => Hash::make('password'),
        ]);

        // Sample Customers
        $customers = [
            ['name' => 'Budi Santoso',   'phone' => '081234567890', 'address' => 'Jl. Mawar No.5, RT 02/03, Kel. Sukamaju'],
            ['name' => 'Siti Rahayu',    'phone' => '082345678901', 'address' => 'Jl. Melati No.12, RT 01/04, Kel. Harapan'],
            ['name' => 'Agus Purnomo',   'phone' => '083456789012', 'address' => 'Jl. Dahlia No.7, RT 03/05, Kel. Sejahtera'],
            ['name' => 'Dewi Lestari',   'phone' => '084567890123', 'address' => 'Jl. Kenanga No.3, RT 04/02, Kel. Indah'],
            ['name' => 'Rudi Hartanto',  'phone' => '085678901234', 'address' => 'Jl. Anggrek No.15, RT 02/06, Kel. Baru'],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }

        // Sample Products
        $products = [
            [
                'name'        => 'Galon Isi Ulang 19L',
                'price'       => 5000,
                'stock'       => 150,
                'description' => 'Air mineral murni isi ulang kemasan galon 19 liter. Sudah melalui proses filtrasi 7 tahap.',
            ],
            [
                'name'        => 'Galon Aqua 19L',
                'price'       => 22000,
                'stock'       => 80,
                'description' => 'Galon air minum dalam kemasan merk Aqua ukuran 19 liter.',
            ],
            [
                'name'        => 'Air Mineral Botol 600ml',
                'price'       => 3500,
                'stock'       => 200,
                'description' => 'Air mineral dalam kemasan botol plastik 600ml. Siap minum.',
            ],
            [
                'name'        => 'Air Mineral Botol 1500ml',
                'price'       => 6000,
                'stock'       => 120,
                'description' => 'Air mineral dalam kemasan botol plastik 1500ml (1,5 liter).',
            ],
            [
                'name'        => 'Galon Kosong',
                'price'       => 3000,
                'stock'       => 50,
                'description' => 'Galon plastik kosong untuk ditukar dengan galon isi ulang.',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
