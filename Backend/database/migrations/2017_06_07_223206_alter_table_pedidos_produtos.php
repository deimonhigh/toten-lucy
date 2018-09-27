<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTablePedidosProdutos extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('pedidosprodutos', function (Blueprint $table) {
      $table->unsignedInteger('produto_id');
      $table->foreign('produto_id')->references('id')->on('produtos')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('pedidosprodutos', function (Blueprint $table) {
      //
    });
  }
}
