<?php

namespace App\Console\Commands\Weather;

use App\Models\Ingest;
use App\Models\WeatherForecast;
use App\Models\WeatherZone;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetWeatherForecasts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'is:get-weather-forecasts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $ingest = Ingest::create(['name' => 'wxForecast']);

        $zones = [];

        foreach($wxZones = WeatherZone::all() as $zone) {
            $zones[] = $zone->wx_id;
        }

        $zones = array_unique($zones);

        $forecastsArray = [];

        foreach($wxZones as $zone) {
            $nwsAlerts = json_decode(
                Http::get("https://api.weather.gov/zones/forecast/{$zone->wx_id}/forecast")
                    ->getBody()
                    ->getContents(),true)['properties']['periods'];

            foreach($nwsAlerts as $alert) {
                $forecastsArray[] = [
                    'name'  => $alert['name'],
                    'description' => $alert['detailedForecast'],
                    'wx_id' => $zone->wx_id,
                    'ingest_id' => $ingest->id,
                ];
            }
        }

        foreach(collect($forecastsArray)->chunk(100) as $chunk) {
            WeatherForecast::insert($chunk->toArray());

        }

        Ingest::where('id','!=', $ingest->id)->where('name','wxForecast')->delete();
    }
}
