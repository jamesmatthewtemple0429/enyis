<?php

namespace App\Console\Commands\Triggers;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;

class TriggerRcrCallsIngest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'is:trigger-rcr-calls-ingest';

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
        $result = Http::timeout(360)
            ->get(config('app.ingest_server') . "&ingest=rcr_calls")
            ->getBody()
            ->getContents();

	    if($result === "Fail") {
		    Artisan::call('is:trigger-rcr-calls-ingest');
	    }
    }
}
