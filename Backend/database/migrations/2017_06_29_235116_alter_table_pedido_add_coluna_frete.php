<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTablePedidoAddColunaFrete extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('pedidos', function (Blueprint $table) {
      $table->decimal('frete', 10, 2)->default(0);
      $table->bigInteger('id_mercado_pago')->default(0);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('pedidos', function (Blueprint $table) {
      $table->dropColumn('frete');
      $table->dropColumn('id_mercado_pago');
    });
  }
}
