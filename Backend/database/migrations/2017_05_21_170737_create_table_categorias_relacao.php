<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCategoriasRelacao extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('admincategoria_categoria', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('categoria_id');
      $table->unsignedInteger('admincategoria_id');

      $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');
      $table->foreign('admincategoria_id')->references('id')->on('admincategorias')->onDelete('cascade');

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
    Schema::dropIfExists('categoriasrelacao');
  }
}
