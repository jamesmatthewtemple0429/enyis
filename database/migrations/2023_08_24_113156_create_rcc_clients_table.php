<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * "name" => "0035a00003FymPz"
     * "case_number" => "01516319"
     * "ingest_id" => 2204
     * "age" => 82
     * "is_military" => false
     */
    public function up(): void
    {
        Schema::create('rcc_clients', function (Blueprint $table) {
            $table->id();

            $table->text('name');
            $table->string('location');
            $table->integer('age');
            $table->boolean('is_military');
            $table->timestamp('entered_at');

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
        Schema::dropIfExists('rcc_clients');
    }
};
