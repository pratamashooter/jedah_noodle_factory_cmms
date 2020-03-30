<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AnnualSchedule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('annualschedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('schedule_code');
            $table->integer('id_user');
            $table->integer('lane');
            $table->string('machine_code');
            $table->integer('time');
            $table->string('period');
            $table->date('start_date');
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
        Schema::dropIfExists('annualschedules');
    }
}
