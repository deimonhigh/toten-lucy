<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableEnderecosAddFkClientes extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('enderecos', function (Blueprint $table) {
      $table->unsignedInteger('idcliente', false)->change();
      // Add FK
      $table->foreign('idcliente')->references('id')->on('clientes')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('enderecos', function (Blueprint $table) {
      $table->dropForeign('idCliente');
    });
  }
}
