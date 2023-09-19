<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('travel_edicts', function (Blueprint $table) {
            $table->id();

            $table->boolean('type');
            $table->boolean('sub_type')->default(2);
            $table->text('description');

            $table->timestamp('effective_at');
            $table->timestamp('expires_at');

            $table->timestamps();
        });

        Schema::create('county_travel_edict', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('county_id')->unsigned();
            $table->bigInteger('travel_edict_id')->unsigned();

            $table->foreign('county_id')
                ->references('id')->on('counties')
                ->onDelete('cascade');

            $table->foreign('travel_edict_id')
                ->references('id')->on('travel_edicts')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_edicts');
    }
};
