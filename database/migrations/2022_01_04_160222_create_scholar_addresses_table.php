<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScholarAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scholar_addresses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('address')->unique()->nullable();
            $table->string('type');
            $table->smallInteger('region_id')->unsigned()->index();
            $table->foreign('region_id')->references('id')->on('location_regions')->onDelete('cascade');
            $table->smallInteger('province_id')->unsigned()->index();
            $table->foreign('province_id')->references('id')->on('location_provinces')->onDelete('cascade');
            $table->smallInteger('municipality_id')->unsigned()->index();
            $table->foreign('municipality_id')->references('id')->on('location_municipalities')->onDelete('cascade');
            $table->bigInteger('scholar_id')->unsigned()->index();
            $table->foreign('scholar_id')->references('id')->on('scholars')->onDelete('cascade');
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
        Schema::dropIfExists('scholar_addresses');
    }
}
