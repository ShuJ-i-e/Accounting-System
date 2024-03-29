<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Invoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('companyId');
            $table->foreignId('paymentId')->nullable();
            $table->foreign('companyId')->references('id')->on('company')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('paymentId')->references('id')->on('payment')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('invTotal', 8, 2);
            $table->text('payment')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice');
    }
}
