<?php

namespace App\Console\Commands\Processors;

use App\Models\Ingest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Imports\ClientImport;
use Illuminate\Support\Facades\File;

class ProcessClientsFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'is:process-clients-file';

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
        if(Storage::disk('lists')->get('clients.csv')) {
            $ingest = Ingest::create(['name' => 'Clients']);

            \Excel::import(new ClientImport($ingest), 'clients.csv','lists');

            Ingest::where('subject','Clients')->where('id','!=',$ingest->id)->delete();

            File::delete(storage_path('lists/clients.csv'));
        }

    }
}
