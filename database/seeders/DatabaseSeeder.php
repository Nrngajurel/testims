<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Stock;
use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        Customer::factory(10)->create();
        $vendor = Vendor::factory(10)->create()->pluck('id');
        $stock = Stock::factory(100)->create()->pluck('id');

        for ($i=0; $i < 10; $i++) {
            $stock->each(function ($id) use ($vendor) {
                $purchase = Purchase::factory()->create([
                    'vendor_id' => $vendor->random(),
                ]);
                $purchase->stocks()->attach($id,[
                    'quantity' => random_int(1, 10),
                    'price' => random_int(100, 1000000),
                ]);
            });
        }




    }
}
