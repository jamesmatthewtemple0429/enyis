<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 'source'                    => $row['data_source'],
     * 'course_name'               => $row['course_name'],
     * 'date'                      => Date::excelToDateTimeObject($row['start_date']),
     * 'primary_subject'           => $row['primary_subject'],
     * 'detailed_subject'          => $row['detailed_subject'],
     * 'account_id'                => $row['account_id'],
     * 'ingest_id'                 => $this->ingest->id
     */
    public function up(): void
    {
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();

            $table->string('source');
            $table->string('course_name');
            $table->timestamp('date');
            $table->string('primary_subject')->nullable();
            $table->string('detailed_subject')->nullable();
            $table->integer('account_id');
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
        Schema::dropIfExists('trainings');
    }
};
