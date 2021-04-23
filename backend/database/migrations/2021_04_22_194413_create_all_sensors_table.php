<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllSensorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('all_sensors', function (Blueprint $table) {
            $table->increments('id');
            //temperature (ambient) in °C
            $table->string('gtmp');
            // temperature (on chip) in °C
            $table->string('atmp');
            // sound volume (aggregated sound volume during 1 second in not specific unit)
            $table->string('vol');
            // light (probably in lux)
            $table->string('light');
            // barometric pressure
            $table->string('pres');
            // relative humidity in %
            $table->string('humi');
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
        Schema::dropIfExists('all_sensors');
    }
}
