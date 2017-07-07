<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableComprovantes extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('comprovantes', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('vendedor_id');
      $table->unsignedInteger('user_id');
      $table->unsignedInteger('pedido_id');
      $table->string('codigo');
      $table->string('bandeira', 15);
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
    Schema::dropIfExists('comprovantes');
  }
}
