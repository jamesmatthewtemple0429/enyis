<?php

namespace App\Console\Commands\Traffic;

use App\Models\County;
use App\Models\TrafficCamera;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GeocodeTrafficCameras extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'is:geocode-traffic-cameras';

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
        $counties = County::all();
        $countyNames = $counties->pluck('name')->toArray();

        foreach(TrafficCamera::where('county',null)->get() as $camera) {
            $fccResponse = json_decode(Http::get("https://geo.fcc.gov/api/census/area?lat=$camera->latitude&lon=$camera->longitude&censusYear=2020&format=json")
                ->getBody()
                ->getContents(), true);

            if(count($fccResponse['results'])) {
                $countyName = strtoupper(str_replace('St.','Saint',
                    str_replace(' County','', $fccResponse['results'][0]['county_name']
                    )
                ));

                if(in_array($countyName, $countyNames)) {
                    $foundCounty = $counties->where('name', $countyName)->first();

                    $camera->update([
                        'county' => $foundCounty->name,
                        'territory' => $foundCounty->territory,
                        'chapter' => $foundCounty->chapter
                    ]);
                } else {
                    $camera->delete();
                }
            } else {
                $camera->delete();
            }
        }
    }
}
