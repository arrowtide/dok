<?php

namespace App\Console\Commands;

use App\Http\Controllers\GitHubSyncController;
use Illuminate\Console\Command;

class SyncGitHub extends Command
{
    protected $signature = 'github:sync {resource}';

    protected $description = 'Sync documentation from a GitHub repository to the local folder';

    public function handle()
    {
        $controller = new GitHubSyncController;
        $controller->runAction(
            $this->argument('resource')
        );
    }
}
