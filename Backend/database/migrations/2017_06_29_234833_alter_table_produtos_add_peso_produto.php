<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableProdutosAddPesoProduto extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('produtos', function (Blueprint $table) {
      $table->decimal('peso', 10, 3)->default(0.00)->nullable();
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
      $table->dropColumn('peso');
    });
  }
}
