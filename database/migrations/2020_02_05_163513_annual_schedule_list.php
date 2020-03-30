<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AnnualScheduleList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('annualschedulelists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('schedule_list_code');
            $table->string('schedule_code');
            $table->integer('id_user');
            $table->integer('lane');
            $table->string('machine_code');
            $table->date('schedule_date');
            $table->string('status');
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
        Schema::dropIfExists('annualschedulelists');
    }
}
