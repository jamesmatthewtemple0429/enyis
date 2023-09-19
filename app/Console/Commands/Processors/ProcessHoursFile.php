<?php

namespace App\Console\Commands\Processors;

use App\Models\Ingest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Imports\HourImport;
use Illuminate\Support\Facades\File;

class ProcessHoursFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'is:process-hours-file';

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
        if(Storage::disk('lists')->get('hours.xls')) {
            $ingest = Ingest::create(['name' => 'Hour']);

            \Excel::import(new HourImport($ingest), 'hours.xls','lists');

            Ingest::where('subject','Hour')->where('id','!=',$ingest->id)->delete();

            File::delete(storage_path('lists/hours.xls'));
        }

    }
}
