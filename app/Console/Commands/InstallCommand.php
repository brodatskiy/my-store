<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{

    protected $signature = 'my-store:install';

    protected $description = 'Installation';

    public function handle()
    {
        $this->call('storage:link');
        $this->call('orchid:admin', ['name' => 'admin', 'email' => 'admin@admin.com', 'password' => 'password']);

        return self::SUCCESS;
    }
}
