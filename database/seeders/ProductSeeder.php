<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Hash;

class ProductSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Product::create([
      'product_code' => 'MIN-1',
      'product_name' => 'Kompor Mini',
      'price' => 150000,
    ]);

    Product::create([
      'product_code' => 'MIN-2',
      'product_name' => 'Kompor Portable',
      'price' => 180000,
    ]);

    Product::create([
      'product_code' => 'PAN-1',
      'product_name' => 'Panci Stainless',
      'price' => 50000,
    ]);
  }
}
