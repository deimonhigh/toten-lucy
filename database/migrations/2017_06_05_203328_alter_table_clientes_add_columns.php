<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableClientesAddColumns extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('clientes', function (Blueprint $table) {
      $table->string('email');
      $table->integer('codigo_cliente');
      $table->char('sexo');
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
      $table->dropColumn('email');
      $table->dropColumn('codigo_cliente');
    });
  }
}
