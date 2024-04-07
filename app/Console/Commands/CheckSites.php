<?php

namespace App\Console\Commands;

use App\Http\Controllers\SiteController;
use Illuminate\Console\Command;

class CheckSites extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sites:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To check sites availability';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("running sites check");
        (new SiteController)->checkSites($this);
        $this->info("sites check complete");
        return Command::SUCCESS;
    }
}
