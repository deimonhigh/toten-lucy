<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTablePedidosAddColumns extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('pedidos', function (Blueprint $table) {
      $table->smallInteger('parcelas', false);
      $table->rename('idcliente', 'cliente_id');
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
      $table->dropColumn('parcelas');
      $table->rename('cliente_id', 'idcliente');
    });
  }
}
