<?php

namespace App\Console\Commands\Weather;

use App\Models\County;
use App\Models\Ingest;
use App\Models\WeatherZone;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetWeatherZones extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'is:get-weather-zones';

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
        $ingest = Ingest::create(['name' => 'wxZones']);

        $counties = County::all();

        $nwsZones = json_decode(Http::get("https://api.weather.gov/zones/forecast?area=NY")
            ->getBody()
            ->getContents(),true)['features'];

        $zones = [];

        foreach($nwsZones as $zone) {
            foreach($counties as $county) {
                if(str_contains(strtolower($zone['properties']['name']),strtolower($county->name))) {
                    $zones[] = [
                        'wx_id'     => $zone['properties']['id'],
                        'name'      => $zone['properties']['name'],
                        'county'    => $county->name,
                        'territory' => $county->territory,
                        'chapter'   => $county->chapter,
                        'ingest_id' => $ingest->id
                    ];
                }
            }
        }

        WeatherZone::insert($zones);

        Ingest::where('id', '!=', $ingest->id)->where('name','wxZones')->delete();
    }
}
