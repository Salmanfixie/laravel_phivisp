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
        Schema::create('phishing_simulations', function (Blueprint $table) {

            $table->id();
            $table->string('name');
            $table->string('simulation_type');
            $table->string('purpose');
            $table->string('target_audience');
            $table->string('num_of_victim');
            $table->string('phishing_link');
            $table->string('feedback')->nullable();
            $table->text('attachment_path')->nullable();
            $table->string('media_url')->nullable();
            $table->tinyInteger('is_sent')->default(0);
            $table->tinyInteger('is_completed')->default(0);
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
        Schema::dropIfExists('phishing_simulation');
    }
};