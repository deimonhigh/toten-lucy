<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePedidosProdutos extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('pedidosprodutos', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('idcliente');
      $table->unsignedInteger('idpedido');

      // Add FK
      $table->foreign('idcliente')->references('id')->on('clientes')->onDelete('cascade');
      $table->foreign('idpedido')->references('id')->on('pedidos')->onDelete('cascade');

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
    Schema::dropIfExists('pedidosprodutos');
  }
}
