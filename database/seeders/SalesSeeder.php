<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Sales;
use Illuminate\Database\Seeder;

class SalesSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Sales::create([
      'sales_code' => 'P-0001',
      'trans_date' => now()->toDateTimeString(),
      'buyer_name' => 'Sulistyo',
      'phone' => '085803123456',
    ]);
    Sales::create([
      'sales_code' => 'P-0002',
      'trans_date' => now()->toDateTimeString(),
      'buyer_name' => 'Fulana',
      'phone' => '085803123456'
    ]);
    Sales::create([
      'sales_code' => 'P-0003',
      'trans_date' => now()->toDateTimeString(),
      'buyer_name' => 'Fulini',
      'phone' => '085803123456'
    ]);
  }
}
