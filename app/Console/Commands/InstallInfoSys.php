<?php

namespace App\Console\Commands;

use App\Models\Permission;
use Illuminate\Console\Command;

class InstallInfoSys extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'is:install';

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
        Permission::truncate();

        Permission::insert([
            [
                'scope'     => 'Interim Assignments',
                'slug'      => 'interim.self-only',
                'name'      => 'Edit Own Interim Assignments'
            ],
            [
                'scope'     => 'Interim Assignments',
                'slug'      => 'interim.admin',
                'name'      => 'Edit All Interim Assignments'
            ],
        ]);
    }
}
