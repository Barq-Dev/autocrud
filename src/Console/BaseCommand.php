<?php

namespace Barqdev\Autocrud\Console;

use Illuminate\Support\Str;
use Illuminate\Console\Command;

class BaseCommand extends Command
{
    protected $signature = 'autocrud:modul {name} {--ui}';
    protected $description = 'Making all necessery file (model, migration, controller, etc..)';

    public function handle()
    {
        $name = $this->argument('name');

        # code...
        $this->call("make:model", [
            'name' => $name,
            '-a' => true
        ]);

        $this->call("make:request", [
            'name' => $name . "Request"
        ]);

        $this->routeResource($name);

        auto_module($name);
    }

    public function routeResource($name)
    {
        # code...
        $import_controller =  "{$name}Controller,\n\t";
        $route = "Route::resource('" . str_replace('_', '-', Str::snake($name)) . "', " . $name . "Controller::class);\n\t";

        write_file(base_path('routes/api.php'), $import_controller, '// #Autocrud Import#');
        write_file(base_path('routes/api.php'), $route, '// #Autocrud#');

        $this->info('Route resource imported.');
    }
}
