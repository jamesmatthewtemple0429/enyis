<?php

namespace App\Console\Commands\Processors;

use App\Models\Ingest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Imports\TrainingImport;
use Illuminate\Support\Facades\File;

class ProcessTrainingsFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'is:process-trainings-file';

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
        if(Storage::disk('lists')->get('trainings.xls')) {
            $ingest = Ingest::create(['name' => 'Training']);


            \Excel::import(new TrainingImport($ingest), 'trainings.xls','lists');

            Ingest::where('subject','Training')->where('id','!=',$ingest->id)->delete();

            File::delete(storage_path('lists/trainings.xls'));
        }

    }
}
