<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run() : void
    {
        $this->call([
            AddressSeeder::class,
            SupplierSeeder::class,
            ImageSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            StockSeeder::class,
            ShoppingCartSeeder::class,
            UserSeeder::class,
            PurchaseSeeder::class,
        ]);
    }
}