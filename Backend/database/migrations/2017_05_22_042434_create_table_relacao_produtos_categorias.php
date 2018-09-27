<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRelacaoProdutosCategorias extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('categoria_produto', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('produto_id');
      $table->unsignedInteger('codigocategoria_id');

      $table->foreign('produto_id')->references('id')->on('produtos')->onDelete('cascade');
      $table->foreign('codigocategoria_id')->references('codigocategoria')->on('categorias');
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
    Schema::dropIfExists('categoria_produto');
  }
}
