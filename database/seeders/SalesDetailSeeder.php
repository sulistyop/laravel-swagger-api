<?php

namespace Database\Seeders;

use App\Models\SalesDetail;
use Illuminate\Database\Seeder;

class SalesDetailSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    SalesDetail::create(["product_id" => 1, "sales_id" => 1]);
    SalesDetail::create(["product_id" => 2, "sales_id" => 1]);
    SalesDetail::create(["product_id" => 3, "sales_id" => 1]);

    SalesDetail::create(["product_id" => 1, "sales_id" => 2]);
    SalesDetail::create(["product_id" => 2, "sales_id" => 2]);

    SalesDetail::create(["product_id" => 1, "sales_id" => 3]);
    SalesDetail::create(["product_id" => 3, "sales_id" => 3]);
  }
}
