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
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();

            $table->boolean('type');

            $table->timestamp('starts_at');
            $table->timestamp('ends_at');

            $table->integer('account_id')->nullable();

            $table->timestamps();

            $table->bigInteger('ingest_id')->unsigned();

            $table->foreign('ingest_id')
                ->references('id')
                ->on('ingests')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};
