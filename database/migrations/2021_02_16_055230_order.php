<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Order extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('prodId');
            $table->foreignId('invId');
            $table->foreign('prodId')->references('id')->on('product')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('invId')->references('id')->on('invoice')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('weight', 8, 2);
            $table->decimal('Mweight', 8, 2);
            $table->decimal('price', 8, 2);
            $table->decimal('total', 8, 2);
            $table->text('remarks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
    }
}
