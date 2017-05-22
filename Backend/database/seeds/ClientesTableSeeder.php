<?php

use App\Http\Controllers\Model\Cliente;
use Illuminate\Database\Seeder;

class ClientesTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Cliente::insert([
        'documento' => "02426884037",
        'nome' => "Bruno Souza",
        'enderecooriginal' => true,
    ]);

    Cliente::insert([
        'documento' => "00886005051",
        'nome' => "Evelyn Monique",
        'enderecooriginal' => true,
    ]);
  }
}
