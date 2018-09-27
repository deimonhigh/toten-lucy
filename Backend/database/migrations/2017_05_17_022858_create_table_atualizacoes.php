<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAtualizacoes extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('atualizacoes', function (Blueprint $table) {
      $table->increments('id');
      $table->dateTime('pedidos')->nullable();
      $table->dateTime('clientes')->nullable();
      $table->dateTime('produtos')->nullable();
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
    Schema::dropIfExists('atualizacoes');
  }
}
