<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WatchForFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'is:watch-temp-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Watches the Temp Directory for new files, and identifies Volunteer Connection and RC Respond Files.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach(Storage::disk('temp')->allFiles() as $file){
            if(Str::contains($file, "inet_894754")) {
                $files = Storage::disk('temp')->allFiles();

                Storage::disk('lists')->put(
                    'members.xls',
                    Storage::disk('temp')->get($file)
                );
                Storage::disk("temp")->delete($file);

            } else if(Str::contains($file, "inet_898474")) {
                $files = Storage::disk('temp')->allFiles();

                Storage::disk('lists')->put(
                    'position_assignments.xls',
                    Storage::disk('temp')->get($file)
                );
                    Storage::disk("temp")->delete($file);
            } else if(Str::contains($file, "inet_1401448")) {
                $files = Storage::disk('temp')->allFiles();

                Storage::disk('lists')->put(
                    'trainings.xls',
                    Storage::disk('temp')->get($file)
                );
                Storage::disk("temp")->delete($file);

            } else if(Str::contains($file, "inet_606568")) {
                $files = Storage::disk('temp')->allFiles();

                Storage::disk('lists')->put(
                    'hours.xls',
                    Storage::disk('temp')->get($file)
                );
                Storage::disk("temp")->delete($file);

            } else if(Str::contains($file, "exported-file-")) {
                $files = Storage::disk('temp')->allFiles();

                Storage::disk('lists')->put(
                    'rcr_calls.csv',
                    Storage::disk('temp')->get($file)
                );
                Storage::disk("temp")->delete($file);
            }
        }
    }
}
