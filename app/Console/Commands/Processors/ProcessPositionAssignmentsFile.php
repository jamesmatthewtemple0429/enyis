<?php

namespace App\Console\Commands\Processors;

use App\Imports\MemberImport;
use App\Imports\PositionAssignmentImport;
use App\Models\Ingest;
use App\Models\Member;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ProcessPositionAssignmentsFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'is:process-position-assignments-file';

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
            $ingest = Ingest::create(['name' => 'position_assignment']);

            \Excel::import(new PositionAssignmentImport($ingest, Member::all()), 'position_assignments.xls','lists');

            Ingest::where('id','!=', $ingest->id)->where('name','position_assignment')->delete();
        }
    }
}
