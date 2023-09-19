<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 0 => array:5 [▼
     * "ingest_id" => 280
     * "county" => "ALBANY"
     * "affected" => 0
     * "total_customers" => 6240
     * "company" => "CENTRAL HUDSON"
     */
    public function up(): void
    {
        Schema::create('outage_data', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('ingest_id')->unsigned();

            $table->foreign('ingest_id')
                ->references('id')
                ->on('ingests')
                ->onDelete('cascade');

            $table->string('county');
            $table->integer('affected');
            $table->decimal('percentage');
            $table->integer('total_customers');
            $table->string('company');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outage_data');
    }
};
