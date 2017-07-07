<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableComprovantesAddFk extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('comprovantes', function (Blueprint $table) {
      $table->foreign('vendedor_id')->references('id')->on('vendedores');
      $table->foreign('user_id')->references('id')->on('users');
      $table->foreign('pedido_id')->references('id')->on('pedidos');

      $table->unsignedInteger('pedido_id')->index()->change();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('comprovantes', function (Blueprint $table) {
      $table->dropForeign(['cliente_id']);
      $table->dropForeign(['vendedor_id']);
      $table->dropForeign(['user_id']);
      $table->dropIndex(['pedido_id']);
    });
  }
}
