<?php

namespace App\Console\Commands\Processors;

use App\Models\Ingest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Imports\CallImport;
use Illuminate\Support\Facades\File;

class ProcessCallsFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'is:process-calls-file';

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
        if(Storage::disk('lists')->get('rcr_calls.csv')) {
            $ingest = Ingest::create(['name' => 'Calls']);

            \Excel::import(new CallImport($ingest), 'rcr_calls.csv','lists');

            Call::where('acknowledged_at', '<', now()->subDays(30)->setTime(0,0,0))
                ->update(['ingest_id' => $ingest->id]);

            Ingest::where('name','Calls')->where('id','!=',$ingest->id)->delete();

            File::delete(storage_path('lists/rcr_calls.csv'));
        }

    }
}
