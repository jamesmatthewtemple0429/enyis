<?php

namespace App\Console\Commands\Weather;

use App\Models\Ingest;
use App\Models\WeatherObservation;
use App\Models\WeatherZone;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GetWeatherObservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'is:get-weather-observations';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';


    public function getDirection($degree) {
        switch($degree) {
            case 350:
            case 360:
            case 010:
                return 'N';
            case 20:
            case 30:
                return 'N/NE';
            case 40:
            case 50:
                return 'NE';
            case 60:
            case 70:
                return 'E/NE';
            case 80:
            case 90:
            case 100:
                return 'E';
            case 110:
            case 120:
                return 'E/SE';
            case 130:
            case 140:
                return 'SE';
            case 150:
            case 160:
                return 'S/SE';
            case 170:
            case 180:
            case 190:
                return 'S';
            case 200:
            case 210:
                return 'S/SW';
            case 220:
            case 230:
                return 'SW';
            case 240:
            case 250:
                return 'W/SW';
            case 260:
            case 270:
            case 280:
                return 'W';
            case 290:
            case 300:
                return 'W/NW';
            case 310:
            case 320:
                return 'NW';
            case 330:
            case 340:
                return 'N/NW';
        }
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $ingest = Ingest::create(['name' => 'wxObservation']);

        $zones = [];

        foreach($wxZones = WeatherZone::all() as $zone) {
            $zones[] = $zone->wx_id;
        }

        $observationArray = [];

        foreach($wxZones as $zone) {
            $nwsObservations = json_decode(
                Http::get("https://api.weather.gov/zones/forecast/{$zone->wx_id}/observations")
                    ->getBody()
                    ->getContents(), true)['features'];

            foreach($nwsObservations as $observation) {
                $observationArray[] = [
                    'station'       => Str::after($observation['properties']['station'],'stations/'),
                    'temperature'   =>  round((($observation['properties']['temperature']['value']*9)/5)+32),
                    'heat_index'   =>  round((($observation['properties']['heatIndex']['value']*9)/5)+32),
                    'dewpoint'   =>  round((($observation['properties']['dewpoint']['value']*9)/5)+32),
                    'wind_dir' => $this->getDirection($observation['properties']['windDirection']['value']),
                    'wind_speed' => round($observation['properties']['windSpeed']['value']/1.609344,2),
                    'wind_gusts' => ($observation['properties']['windGust']['value'] == null) ? null : round($observation['properties']['windGust']['value']/1.609344,2),
                    'humidity' => round($observation['properties']['relativeHumidity']['value'],2),
                    'wind_chill'   =>  ($observation['properties']['windChill']['value'] == null) ? null : round((($observation['properties']['windChill']['value']*9)/5)+32),
                    'precipitation'    => ( $observation['properties']['precipitationLastHour']['value'] == null) ? null : $observation['properties']['precipitationLastHour']['value']/10,
                    'visibility' => $observation['properties']['visibility']['value'],
                    'wx_id' => $zone->wx_id,
                    'ingest_id' => $ingest->id
                ];
            }

            foreach(collect($observationArray)->chunk(100) as $chunk) {
                WeatherObservation::insert($chunk->toArray());
            }

            Ingest::where('id', '!=', $ingest->id)->where('subject','wxObservations')->delete();

        }
    }
}
