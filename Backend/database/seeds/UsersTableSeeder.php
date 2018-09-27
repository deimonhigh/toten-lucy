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
        'email' => 'bruno@agenciadominio.com.br',
        'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
    ]);

    DB::table('users')->insert([
        'name' => "Alexsander",
        'email' => 'alex@agenciadominio.com.br',
        'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
    ]);

    DB::table('users')->insert([
        'name' => "Toten-Lucy",
        'email' => 'loja1@teste.com',
        'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
    ]);
  }
}
