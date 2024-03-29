<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Company extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('companyName');
            $table->text('companyAddress');
            $table->text('companyPhone');
            $table->decimal('myDebt', 8, 2)->default('0.00');
            $table->decimal('companyDebt', 8, 2)->default('0.00');
            $table->decimal('myBalance', 8, 2)->default('0.00');
            $table->decimal('companyBalance', 8, 2)->default('0.00');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company');
    }
}
