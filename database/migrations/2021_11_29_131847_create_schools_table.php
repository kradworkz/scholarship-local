<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('deped_id')->unique();
            // $table->string('school_code')->unique();
            $table->string('name')->unique();
            $table->boolean('is_jlss');
            $table->boolean('is_undergrad');
            $table->tinyInteger('class_id')->unsigned()->index();
            $table->foreign('class_id')->references('id')->on('dropdowns')->onDelete('cascade');
            $table->tinyInteger('term_id')->unsigned()->index();
            $table->foreign('term_id')->references('id')->on('dropdowns')->onDelete('cascade');
            $table->tinyInteger('grading_id')->unsigned()->index();
            $table->foreign('grading_id')->references('id')->on('dropdowns')->onDelete('cascade');
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
        Schema::dropIfExists('schools');
    }
}
