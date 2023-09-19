<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 'natureofcall'  => trim($row['natureofcalltext']),
     * 'ingest_id'     => $this->ingest->id
     */
    public function up(): void
    {
        Schema::create('calls', function (Blueprint $table) {
            $table->id();

            $table->string('call_id');

            $table->timestamp('happened_at')->nullable();
            $table->string('location');
            $table->timestamp('called_at')->nullable();
            $table->timestamp('acknowledged_at')->nullable();
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('on_scene_at')->nullable();
            $table->timestamp('off_scene_at')->nullable();
            $table->timestamp('suspended_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamp('iir_at')->nullable();

            $table->string('assigned_to');
            $table->text('disaster_address');

            $table->string('caller_type')->nullable();

            $table->text('address')->nullable();
            $table->text('city')->nullable();
            $table->string('county');
            $table->string('chapter');

            $table->string('reasonforclosure')->nullable();
            $table->string('territory');

            $table->string('event_type');
            $table->string('agency_type')->nullable();
            $table->string('status');

            $table->boolean('is_closed');
            $table->boolean('has_iir');
            $table->boolean('is_suspended');
            $table->boolean('activate_dat');
            $table->boolean('regional_resources');

            $table->string('nature');

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
        Schema::dropIfExists('calls');
    }
};
