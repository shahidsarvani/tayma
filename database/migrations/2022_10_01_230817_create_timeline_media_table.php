<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimelineMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timeline_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('timeline_item_id');
            $table->string('name');
            $table->string('type');
            $table->integer('order')->nullable();
            $table->text('description')->nullable();
            $table->enum('lang', ['en', 'ar']);
            $table->foreignId('menu_id');
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
        Schema::dropIfExists('timeline_media');
    }
}
