<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phishing_victims', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('phishing_simulations_id');
            $table->foreign('phishing_simulations_id')->references('id')->on('phishing_simulations')->onDelete('cascade');
            $table->string('name');
            $table->string('phone_no');
            $table->string('email');
            $table->string('company')->nullable();
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
        Schema::dropIfExists('phishing_victim');
    }
};