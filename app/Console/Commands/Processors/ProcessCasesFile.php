<?php

namespace App\Console\Commands\Processors;

use App\Models\Ingest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Imports\CaseImport;
use Illuminate\Support\Facades\File;

class ProcessCasesFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'is:process-cases-file';

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
        if(Storage::disk('lists')->get('cases.csv')) {
            $ingest = Ingest::create(['name' => 'Cases']);

            \Excel::import(new CaseImport($ingest), 'cases.csv','lists');

            Ingest::where('name','Cases')->where('id','!=',$ingest->id)->delete();

            File::delete(storage_path('lists/cases.csv'));
        }

    }
}
