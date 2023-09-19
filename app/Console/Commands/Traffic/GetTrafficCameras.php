<?php

namespace App\Console\Commands\Traffic;

use App\Models\County;
use App\Models\Ingest;
use App\Models\TrafficCamera;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetTrafficCameras extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'is:get-traffic-cameras';

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

        $ingest = Ingest::create(['name' => 'trafficCamera']);

        //    $countyNames = County::all()->pluck('name')->toArray();

        $nyCameras = json_decode(Http::get("https://511ny.org/api/getcameras?key=" . config('services.Traffic.key') . "&format=json")
            ->getBody()
            ->getContents(), true);

        $camerasArray = [];

        foreach ( $nyCameras as $camera ) {

            if ( $camera['Disabled'] == false ) {
                $camerasArray[] = [
                    'latitude' => $camera['Latitude'],
                    'longitude' => $camera['Longitude'],
                    'ny_id' => $camera['ID'],
                    'name' => $camera['Name'],
                    'travel_dir' => $camera['DirectionOfTravel'],
                    'roadway' => $camera['RoadwayName'],
                    'photo_url' => $camera['Url'],
                    'video_url' => $camera['VideoUrl'],
                    'ingest_id' => $ingest->id,
                ];
            }
        }

        foreach(collect($camerasArray)->chunk(100) as $chunk)
        {
            TrafficCamera::insert($chunk->toArray());

        }

        Ingest::where('name','trafficCamera')->where('id','!=', $ingest->id)->delete();
    }
}
