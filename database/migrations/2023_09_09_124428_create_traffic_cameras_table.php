<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * "latitutde" => 40.767013
     * "longitude" => -73.696306
     * "ny_id" => "Skyline-1867"
     * "name" => "I-495 West of New Hyde Park Rd"
     * "travel_dir" => "Eastbound"
     * "roadway" => "I-495"
     * "photo_url" => "https://511ny.org/map/Cctv/1867--1"
     * "video_url" => "https://s52.nysd
     */
    public function up(): void
    {
        Schema::create('traffic_cameras', function (Blueprint $table) {
            $table->id();

            $table->string('latitude');
            $table->string('longitude');
            $table->string('ny_id');
            $table->string('name');
            $table->string('travel_dir')->nullable();
            $table->string('roadway')->nullable();

            $table->string('photo_url')->nullable();
            $table->string('video_url')->nullable();

            $table->string('county')->nullable();
            $table->integer('territory')->nullable();
            $table->string('chapter')->nullable();

            $table->bigInteger('ingest_id')->unsigned();

            $table->foreign('ingest_id')
                ->references('id')
                ->on('ingests')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('traffic_cameras');
    }
};
