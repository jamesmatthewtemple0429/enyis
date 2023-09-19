<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'ingest';
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ingest_accounts', function (Blueprint $table) {
            $table->id();

            $table->string('username');
            $table->string('password');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingest_accounts');
    }
};
