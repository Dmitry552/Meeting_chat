<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InitializeProject extends Command
{
    protected $signature = 'project:init';

    protected $description = 'Full project initialization. Creating databases, running migrations, etc.';

    public function handle()
    {
        $bar = $this->output->createProgressBar(5);

        $bar->start();

        $this->newLine();
        $this->line('Key generate!');
        $bar->advance();
        $this->newLine();
        $this->call('key:generate');

        $this->newLine();
        $this->line('Create the symbolic link!');
        $bar->advance();
        $this->newLine();
        $this->call('storage:link');

        $this->newLine();
        $this->line('JWT secret key generate!');
        $bar->advance();
        $this->newLine();
        $this->call('jwt:secret');

        $this->newLine();
        $this->line('Run all migrations!');
        $bar->advance();
        $this->newLine();
        $this->call('migrate:refresh');

        $this->newLine();
        $this->line('Seed the database with records!');
        $bar->advance();
        $this->newLine();
        $this->call('db:seed');

        $this->newLine();
        $bar->finish();
        $this->info('The initial initialization of the project is completed.');
    }
}
