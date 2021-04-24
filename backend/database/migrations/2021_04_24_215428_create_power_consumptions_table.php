<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePowerConsumptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('power_consumptions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('U');
            $table->string('I');
            $table->string('P');
            $table->string('S');
            $table->string('Q');
            $table->string('E_I');
            $table->string('E_E');
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
        Schema::dropIfExists('power_consumptions');
    }
}
