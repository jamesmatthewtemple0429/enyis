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
        Schema::create('state_of_emergencies', function (Blueprint $table) {
            $table->id();

            $table->boolean('type')->default(2);
            $table->text('description');

            $table->timestamp('effective_at');
            $table->timestamp('expires_at');

            $table->timestamps();
        });

        Schema::create('county_state_of_emergency', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('county_id')->unsigned();
            $table->bigInteger('state_of_emergency_id')->unsigned();

            $table->foreign('county_id')
                ->references('id')->on('counties')
                ->onDelete('cascade');

            $table->foreign('state_of_emergency_id')
                ->references('id')->on('state_of_emergencies')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('state_of_emergencies');
        Schema::dropIfExists('county_state_of_emergency');
    }
};
