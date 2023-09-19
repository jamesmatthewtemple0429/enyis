<?php

namespace App\Console\Commands\Processors;

use App\Models\Ingest;
use App\Models\RccEvent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Imports\EventImport;
use Illuminate\Support\Facades\File;

class ProcessEventsFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'is:process-events-file';

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
        if(Storage::disk('lists')->get('events.csv')) {
            $ingest = Ingest::create(['name' => 'Event']);

            \Excel::import(new EventImport($ingest), 'events.csv','lists');

            RccEvent::where('entered_at','<',now()->subDays(30)->setTime(0,0,0))
                ->where('name','Event')
                ->update(['ingest_id' => $ingest->id]);

            Ingest::where('name','Event')->where('id','!=', $ingest->id)->delete();

            File::delete(storage_path('lists/events.csv'));
        }

    }
}
