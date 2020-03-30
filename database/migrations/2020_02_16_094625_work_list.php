<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class WorkList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worklists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('schedule_list_code');
            $table->integer('worker');
            $table->string('point_check');
            $table->string('description');
            $table->integer('percent')->nullable();
            $table->string('status_check');
            $table->text('comment')->nullable();
            $table->date('date_check')->nullable();
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
        Schema::dropIfExists('worklists');
    }
}