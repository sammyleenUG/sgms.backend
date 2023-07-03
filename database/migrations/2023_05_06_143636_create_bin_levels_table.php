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
        Schema::create('bin_levels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("bin_id");
            $table->double("bin_level");
            $table->timestamps();
            $table->foreign('bin_id')->references('id')->on('bins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bin_levels');
    }
};
