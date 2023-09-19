<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 'case_number'       => $row['case_number'],
     * 'owner'             => $row['case_owner'],
     * 'entered_at'        => new Carbon($row['datetime_opened']),
     * 'event'             => $row['event'],
     * 'virtual_response'  => $row['virtual_response'],
     * 'address'           => $row['pre_disaster_street'],
     * 'unit'              => $row['pre_disaster_unit'],
     * 'city'              => $row['pre_disaster_city'],
     * 'county'            => strtoupper(str_replace(' County','',$row['county'])),
     * 'amount_disbursed'  => $row['total_amount_disbursed']
     */
    public function up(): void
    {
        Schema::create('rcc_cases', function (Blueprint $table) {
            $table->id();

            $table->string('case_number');
            $table->string('owner');
            $table->timestamp('entered_at');
            $table->text('disaster_address');

            $table->string('event');
            $table->boolean('virtual_response');
            $table->text('address');
            $table->text('unit')->nullable();
            $table->text('city');

            $table->string('county');
            $table->string('chapter')->nullable();
            $table->string('territory')->nullable();

            $table->integer('amount_disbursed');

            $table->integer('total_clients');

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
        Schema::dropIfExists('rcc_cases');
    }
};
