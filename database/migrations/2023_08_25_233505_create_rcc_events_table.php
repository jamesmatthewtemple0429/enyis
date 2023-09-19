<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * "event_event" => "EV-0165922"
     * "street" => "12 Ball Rd"
     * "event_created_date" => "4/30/2023"
     * "date_of_event" => "4/30/2023"
     * "city" => "Hastings"
     * "county" => "Oswego"
     * "event_type" => "SFF - Single-family Fire"
     */
    public function up(): void
    {
        Schema::create('rcc_events', function (Blueprint $table) {
            $table->id();

            $table->text('name');

            $table->string('location');
            $table->text('city');

            $table->string('county');
            $table->string('chapter')->nullable();
            $table->string('territory')->nullable();


            $table->timestamp('entered_at');
            $table->timestamp('happened_at');

            $table->string('type');

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
        Schema::dropIfExists('rcc_events');
    }
};
