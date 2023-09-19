<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 'station'       => Str::after($observation['properties']['station'],'stations/'),
     * 'temperature'   =>  round((($observation['properties']['temperature']['value']*9)/5)+32),
     * 'heat_index'   =>  round((($observation['properties']['heatIndex']['value']*9)/5)+32),
     * 'dewpoint'   =>  round((($observation['properties']['dewpoint']['value']*9)/5)+32),
     * 'wind_dir' => $this->getDirection($observation['properties']['windDirection']['value']),
     * 'wind_speed' => round($observation['properties']['windSpeed']['value']/1.609344,2),
     * 'wind_gusts' => ($observation['properties']['windGust']['value'] == null) ? null : round($observation['properties']['windGust']['value']/1.609344,2),
     * 'humidity' => round($observation['properties']['relativeHumidity']['value'],2),
     * 'wind_chill'   =>  ($observation['properties']['windChill']['value'] == null) ? null : round((($observation['properties']['windChill']['value']*9)/5)+32),
     * 'precipitation'    => ( $observation['properties']['precipitationLastHour']['value'] == null) ? null : $observation['properties']['precipitationLastHour']['value']/10,
     * 'visibility' => $observation['properties']['visibility']['value'],
     * 'wx_id' => $zone->wx_id,
     * 'ingest_id' => $ingest->id
     */
    public function up(): void
    {
        Schema::create('weather_observations', function (Blueprint $table) {
            $table->id();

            $table->string('station');
            $table->decimal('temperature',2);
            $table->decimal('heat_index',2);
            $table->decimal('dewpoint',2);
            $table->string('wind_dir')->nullable();
            $table->decimal('wind_speed',2)->nullable();
            $table->decimal('wind_gusts',2)->nullable();
            $table->decimal('humidity',2)->nullable();

            $table->decimal('wind_chill',2)->nullable();
            $table->decimal('precipitation',2)->nullable();
            $table->decimal('visibility',2)->nullable();

            $table->string('wx_id');

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
        Schema::dropIfExists('weather_observations');
    }
};
