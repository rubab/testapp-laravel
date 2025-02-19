<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::connection('sqlite')->create('temp_excel_data', function (Blueprint $table) {
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

    public function down()
    {
        Schema::connection('sqlite')->dropIfExists('temp_excel_data');
    }
};
