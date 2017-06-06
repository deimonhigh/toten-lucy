<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableConfigAddColumns extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('configuracoes', function (Blueprint $table) {
      $table->unsignedInteger('produto_id')->nullable();
      // Add FK
      $table->foreign('produto_id')->references('id')->on('produtos')->onDelete('cascade');
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
      $table->dropForeign('produto_id');
      $table->dropColumn('produto_id');
    });
  }
}
