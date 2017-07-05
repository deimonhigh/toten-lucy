<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableProdutosAddEstoqueAlterDescricao extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('produtos', function (Blueprint $table) {
      $table->longText('descricao')->nullable()->change();
      $table->bigInteger('estoque')->nullable()->default(0);
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
      $table->string('descricao')->change();
      $table->dropColumn('estoque');
    });
  }
}
