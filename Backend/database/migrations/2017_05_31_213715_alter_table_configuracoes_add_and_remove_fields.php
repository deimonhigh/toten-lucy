<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableConfiguracoesAddAndRemoveFields extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::rename('themes', 'configuracoes');
    
    Schema::table('configuracoes', function (Blueprint $table) {
       $table->float('parcela1', 5, 2)->nullable();
       $table->float('parcela2', 5, 2)->nullable();
       $table->float('parcela3', 5, 2)->nullable();
       $table->float('parcela4', 5, 2)->nullable();
       $table->float('parcela5', 5, 2)->nullable();
       $table->float('parcela6', 5, 2)->nullable();
       $table->float('parcela7', 5, 2)->nullable();
       $table->float('parcela8', 5, 2)->nullable();
       $table->float('parcela9', 5, 2)->nullable();
       $table->float('parcela10', 5, 2)->nullable();
       $table->float('parcela11', 5, 2)->nullable();
       $table->float('parcela12', 5, 2)->nullable();

      $table->dropColumn('maxParcelas');
      $table->dropColumn('maxParcelasSemJuros');
      $table->dropColumn('juros');
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
      //
    });

    Schema::rename('configuracoes', 'themes');
    
  }
}
