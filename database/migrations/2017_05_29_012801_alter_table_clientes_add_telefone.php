<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableClientesAddTelefone extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('clientes', function (Blueprint $table) {
      $table->string('telefone', 20)->nullable();
      $table->string('celular', 20)->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('clientes', function (Blueprint $table) {
      $table->dropColumn('telefone');
      $table->dropColumn('celular');
    });
  }
}
