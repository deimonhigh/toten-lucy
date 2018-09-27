<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThemesDb extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('themes', function (Blueprint $table) {
      $table->increments('id');
      $table->text('empresa');
      $table->integer('maxParcelas', false)->nullable();
      $table->integer('maxParcelasSemJuros', false)->nullable();
      $table->integer('juros', false)->nullable();
      $table->string('cor', 8)->nullable();

//      FK's
      $table->integer('userId');

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
    Schema::dropIfExists('theme');
  }
}
