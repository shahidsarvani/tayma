<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTouchTableScreenContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('touch_table_screen_contents', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->enum('lang', ['en', 'ar']);
            $table->foreignId('screen_id');
            $table->foreignId('menu_id');
            $table->integer('menu_level')->default(0);
            $table->string('background_color')->default('#ffffff');
            $table->string('text_color')->default('#000000');
            $table->string('title')->nullable();
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
        Schema::dropIfExists('touch_table_screen_contents');
    }
}
