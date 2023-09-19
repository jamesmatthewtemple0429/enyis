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
        Schema::create('sections', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->boolean('type');

            $table->string('model')->nullable();

            $table->integer('priority');

            $table->text('value')->nullable();
            $table->text('fields')->nullable();

            $table->integer('territory')->nullable();
            $table->integer('county')->nullable();

            $table->bigInteger('report_id')->unsigned();

            $table->foreign('report_id')
                ->references('id')
                ->on('reports')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
