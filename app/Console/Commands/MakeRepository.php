<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository class';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $stub = File::get(base_path('app/stubs/repository.stub'));
        
        $repositoryContent = str_replace(
            ['{{name}}'],
            [$name],
            $stub
        );

        $path = app_path("Repositories/{$name}Repository.php");
        File::put($path, $repositoryContent);

        $this->info("Repository created successfully.");
    }
}
