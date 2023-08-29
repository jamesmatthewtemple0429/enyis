<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 'account_id'        => $row['account_id'],
     * 'supervisor'        => optional($foundMember)->account_id,
     * 'name'              => trim(Str::after($row['position'],"DCS: ")),
     * 'type'              => $row['position_type'],
     * 'sub_type'          => $row['sub_type'],
     * 'ingest_id'         => $this->ingest->id
     */
    public function up(): void
    {
        Schema::create('position_assignments', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            $table->integer('account_id');
            $table->integer('supervisor')->nullable();
            $table->string('type')->nullable();
            $table->string('sub_type')->nullable();

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
        Schema::dropIfExists('position_assignments');
    }
};
