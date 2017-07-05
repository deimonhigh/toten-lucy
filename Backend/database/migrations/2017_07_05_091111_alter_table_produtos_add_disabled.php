<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableProdutosAddDisabled extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('produtos', function (Blueprint $table) {
      $table->boolean('disabled')->default(true);
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
      $table->dropColumn('disabled');
    });
  }
}
