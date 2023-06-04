<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    FacadesDB::statement('SET FOREIGN_KEY_CHECKS=0');
    FacadesDB::table('users')->truncate();
    FacadesDB::statement('SET FOREIGN_KEY_CHECKS=1');

    $newAuthUsers = [
      'name' => "admin",
      'email' => "admin@gmail.com",
      'email_verified_at' => now()->toDateTimeString(),
      'password' => Hash::make('admin')
    ];

    FacadesDB::transaction(function () use ($newAuthUsers) {
      $authUser = User::firstOrCreate($newAuthUsers);
    });
  }
}
