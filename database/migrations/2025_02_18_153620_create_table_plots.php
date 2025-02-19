<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('plots', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('batch');
            $table->string('city'); 
            $table->string('society');
            $table->string('block');
            $table->integer('marla');
            $table->integer('plot_size');
            $table->bigInteger('price');
            $table->enum("status", ['Available', 'Sold', 'Booked']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plots');
    }
};
