<?php

namespace App\Console\Commands\Weather;

use App\Models\County;
use App\Models\Ingest;
use App\Models\WeatherAlert;
use App\Models\WeatherAlertZone;
use App\Models\WeatherZone;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetWeatherAlerts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'is:get-weather-alerts';

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
        $ingest = Ingest::create(['name' => 'wxAlert']);

        $startDate = now()->subDays(30)->format('Y-m-d') . "T00:00:00Z";
        $endDate = now()->format('Y-m-d') . "T" . now()->format('h:i:s') . "Z";
        WeatherAlert::where('effective_at','<', $startDate)->update(['ingest_id' => $ingest->id]);
        $oldAlerts = WeatherAlert::where('effective_at','<', $startDate)->get();

        $oldIds = [];
        foreach($oldAlerts as $alert) {
            $oldIds[] = $alert->wx_id;
        }

        WeatherAlertZone::whereIn('wx_id', $oldIds)->update(['ingest_id' => $ingest->id]);

        $zones = [];

        foreach($wxZones = WeatherZone::all() as $zone) {
            $zones[] = $zone->wx_id;
        }

        $alertArray = [];
        $zoneArray = [];

        foreach($wxZones as $zone) {
            $nwsAlerts = json_decode(
                Http::get("https://api.weather.gov/alerts?start={$startDate}&end={$endDate}&zone=$zone->wx_id")
                ->getBody()
                ->getContents(),true)['features'];

            foreach($nwsAlerts as $alert) {
                $affectedZones = $alert['properties']['geocode']['UGC'];

                foreach($affectedZones as $z){
                    if(in_array($z,$zones)) {
                        $zoneArray[] = [
                            'zone' => $z,
                            'wx_id' => $alert['properties']['id'],
                            'ingest_id' => $ingest->id,
                        ];
                    }
                }

                $alertArray[] = [
                    'wx_id' => $alert['properties']['id'],
                    'sender' => $alert['properties']['senderName'],
                    'message_type' => $alert['properties']['messageType'],
                    'severity' => $alert['properties']['severity'],
                    'certainty' => $alert['properties']['certainty'],
                    'urgency' => $alert['properties']['urgency'],
                    'event' => $alert['properties']['event'],
                    'headline' => $alert['properties']['headline'],
                    'description' => $alert['properties']['description'],
                    'instruction' => $alert['properties']['instruction'],
                    'response' => $alert['properties']['response'],
                    'ingest_id' => $ingest->id,
                    'sent_at' => $alert['properties']['sent'],
                    'effective_at' => $alert['properties']['effective'],
                    'expires_at' => $alert['properties']['expires'],

                ];
            }
        }

        WeatherAlert::insert($alertArray);
        WeatherAlertZone::insert($zoneArray);

        Ingest::where('name','wxAlert')->where('id','!=', $ingest->id)->delete();
    }
}
