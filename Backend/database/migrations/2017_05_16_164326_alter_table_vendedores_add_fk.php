<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableVendedoresAddFk extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('vendedores', function (Blueprint $table) {
      $table->dropColumn('idcliente');
      $table->unsignedInteger('usuario_id', false);
      // Add FK
      $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('vendedores', function (Blueprint $table) {
      $table->dropColumn('idcliente');
      $table->dropForeign('idcliente');
    });
  }
}
