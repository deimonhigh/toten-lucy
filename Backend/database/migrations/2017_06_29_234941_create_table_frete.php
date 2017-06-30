<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableFrete extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('fretes', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('cep_inicial')->index()->nullable();
      $table->integer('cep_final')->index()->nullable();
      $table->integer('peso_inicial')->index()->nullable();
      $table->integer('peso_final')->index()->nullable();
      $table->integer('valor')->nullable();
      $table->integer('prazo')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('fretes');
  }
}
