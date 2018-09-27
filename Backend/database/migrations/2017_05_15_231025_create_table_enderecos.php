<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableEnderecos extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('enderecos', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('cep');
      $table->string('endereco');
      $table->integer('numero');
      $table->string('complemento')->nullable();
      $table->string('bairro');
      $table->string('cidade');
      $table->string('uf');
      $table->unsignedInteger('idcliente');
      $table->boolean('enderecooriginal')->default(true);

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('enderecos');
  }
}
