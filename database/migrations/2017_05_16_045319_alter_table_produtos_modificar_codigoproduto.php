<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableProdutosModificarCodigoproduto extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('produtos', function (Blueprint $table) {
      $table->string('codigoproduto')->change();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('produtos', function (Blueprint $table) {
      $table->integer('codigoproduto')->change();
    });
  }
}
