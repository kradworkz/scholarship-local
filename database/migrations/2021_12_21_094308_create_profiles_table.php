<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('email')->unique();
            $table->string('firstname',150);
            $table->string('lastname',150);
            $table->string('middlename',100);
            $table->string('suffix',10)->nullable();
            $table->string('gender',8);
            $table->string('mobile',15);
            $table->date('birthday');
            $table->string('avatar',200)->default('avatar.jpg');
            $table->json('information');
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
        Schema::dropIfExists('profiles');
    }
}
