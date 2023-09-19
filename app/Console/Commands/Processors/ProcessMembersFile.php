<?php

namespace App\Console\Commands\Processors;

use App\Imports\MemberImport;
use App\Models\Ingest;
use App\Models\PositionAssignment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ProcessMembersFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'is:process-members-file';

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
        if(Storage::disk('lists')->has('members.xls')) {
            $ingest = Ingest::create(['name' => 'member']);

            \Excel::import(new MemberImport($ingest), 'members.xls','lists');

            Ingest::where('id','!=', $ingest->id)->where('name','member')->delete();

            Storage::disk('lists')->delete("members.xls");
        }
    }
}
