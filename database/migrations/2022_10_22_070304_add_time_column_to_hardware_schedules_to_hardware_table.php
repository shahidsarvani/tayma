<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimeColumnToHardwareSchedulesToHardwareTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hardware_schedules', function (Blueprint $table) {
            //
            $table->time('time');
            $table->enum('action', ['wakeup', 'shutdown']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hardware_schedules', function (Blueprint $table) {
            //
        });
    }
}
