<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->unsignedInteger('salon_id');
            $table->unsignedInteger('place_id');
            $table->unsignedInteger('coach_id');
            $table->unsignedInteger('field_id');
            $table->boolean('male');
            $table->unsignedSmallInteger('capacity');
            $table->unsignedSmallInteger('sessions');
            $table->boolean('auto_start')->default(0);
            $table->boolean('open')->default(1);
            $table->boolean('started')->default(0);
            $table->boolean('finished')->default(0);
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
        Schema::dropIfExists('courses');
    }
}
