<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableProdutos extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('produtos', function (Blueprint $table) {
      $table->increments('id');

      $table->bigInteger('codigobarras')->index();

      $table->integer('codigoprodutoabaco')->nullable();
      $table->integer('codigoproduto')->nullable()->index();
      $table->integer('codigoprodutopai')->nullable()->index();

      $table->string('nomeproduto');
      $table->string('descricao');

      $table->string('cor')->nullable();

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
    Schema::dropIfExists('produtos');
  }
}
