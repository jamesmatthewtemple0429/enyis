<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class TriggerPowerOutageIngest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'is:trigger-power-outage-ingest';

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
        $nowMinutes = now()->minute;

        switch($nowMinutes) {
            case 1:
            case 11:
            case 21:
            case 31:
            case 41:
            case 51:
               $outageKey = "outage_t1";
               break;
            case 2:
            case 12:
            case 22:
            case 32:
            case 42:
            case 52:
                $outageKey = "outage_t2";
                break;
            case 3:
            case 13:
            case 23:
            case 33:
            case 43:
            case 53:
                $outageKey = "outage_t3";
                break;
            case 4:
            case 14:
            case 24:
            case 34:
            case 44:
            case 54:
                $outageKey = "outage_t4";
                break;
            case 5:
            case 15:
            case 25:
            case 35:
            case 45:
            case 55:
                $outageKey = "outage_5";
            default:
                $outageKey = null;
        }

        if(! is_null($outageKey)) {
            $result = Http::timeout(360)
                ->get(config('app.text_ingest') . "&ingest=$outageKey")
                ->getBody()
                ->getContents();

            dd($result);
        }
    }
}
