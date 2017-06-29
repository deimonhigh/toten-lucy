<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableProdutosAddPreco1Preco2 extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('produtos', function (Blueprint $table) {
      $table->float('preco2', 15, 2)->nullable();
      $table->float('precopromocao2', 15, 2)->nullable();
      $table->renameColumn('preco', 'preco1')->nullable()->change();
      $table->renameColumn('precopromocao', 'precopromocao1')->nullable()->change();
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
      $table->dropColumn(['preco2', 'precopromocao2']);
      $table->renameColumn('preco1', 'preco')->nullable()->change();
      $table->renameColumn('precopromocao1', 'precopromocao')->nullable()->change();
    });
  }
}
