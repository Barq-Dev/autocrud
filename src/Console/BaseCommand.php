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
        $ui = $this->option('ui');
        # code...
        $this->call("make:model", [
            'name' => $name,
            '-a' => true
        ]);

        $this->call("make:request", [
            'name' => $name . "Request"
        ]);

        $this->routeResource($name);

        if ($ui == 'vue')
            $this->auto_ui($name);
    }

    public function routeResource($name)
    {
        # code...
        $import_controller =  "{$name}Controller,\n\t";
        $route = "Route::resource('" . str_replace('_', '-', Str::snake($name)) . "', " . $name . "Controller::class);\n\t";

        $this->write_file(base_path('routes/api.php'), $import_controller, '// #Autocrud Import#');
        $this->write_file(base_path('routes/api.php'), $route, '// #Autocrud#');

        $this->info('Route resource imported.');
    }

    public function auto_ui($module_name)
    {
        $this->write_file(
            resource_path('js/store/modules/theme/menu.js'),
            "{ icon: 'help', text: '$module_name', route: '/" . \Str::kebab($module_name) . "', auth: true }, \n\t\t",
            '// #Autocrud#'
        );
        $this->write_file(resource_path('js/router/routes.js'), "'$module_name', \n\t\t", '// #Autocrud#');


        $base_path = base_path('vendor/barq-dev/autocrud/src/Resources/js/vue/views/base');
        $dest_path = resource_path("js/views/" . \Str::snake($module_name));
        \File::copyDirectory($base_path, $dest_path);

        $this->write_file("$dest_path/Index.vue", $module_name, '#MODULE#', true);
    }

    public function write_file($path, $string, $needle, $replace = false)
    {
        $document = file_get_contents($path);
        $pos = strpos($document, $needle);

        $document = $replace ?
            str_replace($needle, $string, $document) : substr_replace($document, $string, $pos, 0);

        file_put_contents($path, $document);
    }
}
