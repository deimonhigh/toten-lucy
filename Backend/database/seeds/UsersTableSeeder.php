<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('users')->insert([
        'name' => "Bruno Souza",
        'email' => 'brnosouza@gmail.com',
        'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
    ]);
  }
}
