<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQualifiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qualifiers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('applicant_id')->unique();
            $table->string('lrn')->unique()->nullable();
            $table->string('school_code');
            $table->string('course_id');
            $table->year('year');
            $table->boolean('is_qualified')->nullable();
            $table->tinyInteger('category_id')->unsigned()->index();
            $table->foreign('category_id')->references('id')->on('dropdowns')->onDelete('cascade');
            $table->bigInteger('profile_id')->unsigned()->index();
            $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('cascade');
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
        Schema::dropIfExists('qualifiers');
    }
}
