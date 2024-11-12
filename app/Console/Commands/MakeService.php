<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $stub = File::get(base_path('app/stubs/service.stub'));
        
        $serviceContent = str_replace(
            ['{{name}}'],
            [$name],
            $stub
        );

        $path = app_path("Services/{$name}Service.php");
        File::put($path, $serviceContent);

        $this->info("Service created successfully.");
    }
}
