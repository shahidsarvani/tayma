<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHardwareSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hardware_schedules', function (Blueprint $table) {
            $table->id();
            $table->enum('day', [1, 2, 3, 4, 5, 6, 7]); //['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday']
            $table->boolean('is_active');
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
        Schema::dropIfExists('hardware_schedules');
    }
}
