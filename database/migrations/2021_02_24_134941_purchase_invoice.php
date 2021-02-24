<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PurchaseInvoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchaseInvoice', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('companyId');
            $table->foreign('companyId')->references('id')->on('company')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('invTotal', 8, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
