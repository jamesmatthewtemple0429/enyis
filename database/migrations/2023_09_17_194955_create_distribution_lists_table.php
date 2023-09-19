<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * "access" => "1"
     * "type" => "1"
     * "frequency" => "3"
     * "time" => "16"
     * "date" => "d"
     * "day" => "0"
     * "report" => "6"
     */
    public function up(): void
    {
        Schema::create('distribution_lists', function (Blueprint $table) {
            $table->id();

            $table->boolean('access');
            $table->boolean('type');
            $table->boolean('frequency')->nullable();
            $table->integer('time')->nullable();
            $table->integer('date')->nullable();
            $table->integer('day')->nullable();

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
        Schema::dropIfExists('distribution_lists');
    }
};
