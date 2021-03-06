<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableConfigAddParcelaAVista extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('configuracoes', function (Blueprint $table) {
      $table->float('parcela0', 5, 2)->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('configuracoes', function (Blueprint $table) {
      $table->dropColumn('parcela0');
    });
  }
}
