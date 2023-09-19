<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallSymbolicLink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'is:install-symbolic-link';

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
        symlink(storage_path('reports'), './public/reports');
    }
}
