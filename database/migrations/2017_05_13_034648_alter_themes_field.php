<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterThemesField extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('themes', function (Blueprint $table) {
      $table->unsignedInteger('userId', false)->change();

      //Add FK
      $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('themes', function (Blueprint $table) {
      // Remove FK
      $table->dropForeign(['userId']);
      $table->dropForeign(['listaPrecoId']);
    });
  }
}
