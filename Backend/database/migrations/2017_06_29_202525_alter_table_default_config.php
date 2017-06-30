<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableDefaultConfig extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('configuracoes', function (Blueprint $table) {
      $table->string('empresa', 255)->default('Lucy Home')->change();
      $table->string('cor', 8)->default('#FF5B10')->change();

      $table->decimal('parcela0', 5, 2)->default(0)->change();
      $table->decimal('parcela1', 5, 2)->default(0)->change();
      $table->decimal('parcela2', 5, 2)->default(0)->change();
      $table->decimal('parcela3', 5, 2)->default(0)->change();
      $table->decimal('parcela4', 5, 2)->default(0)->change();
      $table->decimal('parcela5', 5, 2)->default(0)->change();
      $table->decimal('parcela6', 5, 2)->default(0)->change();
      $table->decimal('parcela7', 5, 2)->default(0)->change();
      $table->decimal('parcela8', 5, 2)->default(0)->change();
      $table->decimal('parcela9', 5, 2)->default(0)->change();
      $table->decimal('parcela10', 5, 2)->default(0)->change();
      $table->decimal('parcela11', 5, 2)->default(0)->change();
      $table->decimal('parcela12', 5, 2)->default(0)->change();

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
      $table->float('parcela0', 5, 2)->default(0)->change();
      $table->float('parcela1', 5, 2)->default(0)->change();
      $table->float('parcela2', 5, 2)->default(0)->change();
      $table->float('parcela3', 5, 2)->default(0)->change();
      $table->float('parcela4', 5, 2)->default(0)->change();
      $table->float('parcela5', 5, 2)->default(0)->change();
      $table->float('parcela6', 5, 2)->default(0)->change();
      $table->float('parcela7', 5, 2)->default(0)->change();
      $table->float('parcela8', 5, 2)->default(0)->change();
      $table->float('parcela9', 5, 2)->default(0)->change();
      $table->float('parcela10', 5, 2)->default(0)->change();
      $table->float('parcela11', 5, 2)->default(0)->change();
      $table->float('parcela12', 5, 2)->default(0)->change();
    });
  }
}
